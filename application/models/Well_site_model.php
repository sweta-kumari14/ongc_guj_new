<?php
class Well_site_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function verifySiteExist($well_site_name)
	{
		$res = $this->db->select("count(id) as total")->from('tbl_well_site_master')->where(['well_site_name'=>$well_site_name,'status'=>1])->get()->result_array();

		if(!empty($res))
		{
			return $res[0]['total'];
		}else{
			return 0;
		}
	}
	
	public function getSiteID()
    {
        return $this->db->select("UUID()")->get()->result_array();
    }

    public function Add_WellSite($data)
    {
    	return $this->db->insert('tbl_well_site_master',$data);
    }

    public function verifyWellSiteExist_OrNot($well_site_name,$id)
	{
		if($well_site_name!='')
			$this->db->where('well_site_name',$well_site_name);
		if($id!='')
			$this->db->where('id !=',$id);
		$res = $this->db->select("count(id) as total")->from('tbl_well_site_master')->where(['status'=>1])->get()->result_array();

		if(!empty($res))
		{
			return $res[0]['total'];
		}else{
			return 0;
		}
	}

	public function UpdateWellSiteData($data,$where)
    {
    	return $this->db->update('tbl_well_site_master',$data,$where);
    }

    public function SiteList($id,$company_id)
    {
    	if($id!='')
    		$this->db->where('ws.id',$id);
    	if($company_id!='')
    		$this->db->where('ws.company_id',$company_id);
    
    	return $this->db->select("ws.id,ws.well_site_name,ws.area_id,c.area_name,cs.company_name,am.assets_name,ws.assets_id")
    	->from('tbl_well_site_master ws')
    	->join('tbl_area_master c','ws.area_id=c.id','left')
    	->join('tbl_assets_master am','ws.assets_id=am.id','left')
    	->join('tbl_company_setup cs','ws.company_id=cs.id','left')
    	->where('ws.status',1)->get()->result_array();
    }

    public function DeleteSite($data,$where)
    {
    	return $this->db->update('tbl_well_site_master',$data,$where);
    }


	public function Well_Running_Details( $from_date_time, $to_date_time)
	{
	 $result_imei=$this->db->distinct()->select("imei_no")
		->from("tbl_device_log")->get()->result_array();
		//print_r(count($result_imei));die;
	for($j=0; $j<count($result_imei); $j++)
	{
		$imei_no=$result_imei[$j]['imei_no'];
		$result_well_id=$this->db->select("well_id")
		->from("tbl_site_device_installation")->where(['imei_no'=>$imei_no])->get()->result_array();
		$well_id=$result_well_id[0]['well_id'];
		$last_data=$this->get_last_data($imei_no, $from_date_time, $to_date_time);
		$ct=count($last_data);
		$result='';
		if(count($last_data)<=0){
			//print_r('hello'); die;
			$result=$this->db->select("offline_device_timestamp,output_Average_Current,output_Kwh")
			->from("tbl_device_log")
			->where(['imei_no'=>$imei_no,'offline_device_timestamp>='=>$from_date_time,'offline_device_timestamp<'=>$to_date_time])
			->order_by('offline_device_timestamp','ASC')
			->get()->result_array();
		}
		else{
			
			$result=$this->db->select("offline_device_timestamp,output_Average_Current,output_Kwh")
			->from("tbl_device_log")
			->where(['imei_no'=>$imei_no,'offline_device_timestamp>='=>$last_data[0]['end_datetime'],'offline_device_timestamp<'=>$to_date_time])
			->order_by('offline_device_timestamp','ASC')
			->get()->result_array();
			//print_r($result); die;

		}
		$nextValue=0;
		$prevValue=0;
		$next_date_time='';
		$prev_date_time='';
		$result_set='';
		$status_run=1;
		$last_row=count($result);
		for($i=1; $i<$last_row-1; $i++){
			$last_data=$this->get_last_data($imei_no, $from_date_time, $to_date_time);
			$ct=count($last_data);
			$prevValue=$result[$i-1]['output_Average_Current'];
			$current_date_time=$result[$i]['offline_device_timestamp'];
			$nextValue=$result[$i+1]['output_Average_Current'];
			$next_date_time=$result[$i+1]['offline_device_timestamp'];
			//print_r($ct); die;
			//$result_set.='Previous Value Of Current :-'. $prevValue.' at '.$prev_date_time;
			if($prevValue<=0 and $result[$i]['output_Average_Current']<=0 and $nextValue<=0 and $status_run>0){
				$status_run=0;
			}else if($prevValue<=0 and $result[$i]['output_Average_Current']>0 and $nextValue>0 and $status_run!=1){
				//$result_set.='Stopped till '.$result[$i-1]['offline_device_timestamp'];
				if($ct<=0){
					$data = [];
					$data['imei_no'] = $imei_no;
					$data['well_id'] = $well_id;
					$data['start_datetime'] = $result[$i]['offline_device_timestamp'];
					$data['start_kwh'] = $result[$i]['output_Kwh'];
					$data['end_datetime'] = $result[$i]['offline_device_timestamp'];
					$data['end_kwh'] = $result[$i]['output_Kwh'];
					$data['total_kwh'] = 0;
					$data['total_running_minute']=0;
					$this->Savedata($data);
				}else{
					$diff_minute_1=floor(abs(strtotime($result[$i]['offline_device_timestamp']) - strtotime($last_data[0]['start_datetime']))/60);
					$diff_minute_2=floor(abs(strtotime($result[$i]['offline_device_timestamp']) - strtotime($last_data[0]['end_datetime']))/60);
					if($diff_minute_2<5){
						if($diff_minute_1>2){
							$data = [];
							$data['imei_no'] = $imei_no;
							$data['end_datetime'] = $result[$i]['offline_device_timestamp'];
							$data['end_kwh'] = $result[$i]['output_Kwh'];
							$data['total_kwh'] = $result[$i]['output_Kwh']-$last_data[0]['start_kwh'];
							$data['total_running_minute']=$diff_minute_1;
							$this->updatedata($data,['id'=>$last_data[0]['id']]);
						}
						
					}else{
						$data = [];
						$data['imei_no'] = $imei_no;
						$data['well_id'] = $well_id;
						$data['start_datetime'] = $result[$i]['offline_device_timestamp'];
						$data['start_kwh'] = $result[$i]['output_Kwh'];
						$data['end_datetime'] = $result[$i]['offline_device_timestamp'];
						$data['end_kwh'] = $result[$i]['output_Kwh'];
						$data['total_kwh'] = 0;
						$data['total_running_minute']=0;
						$this->Savedata($data);
					}
					
				}
				$status_run=1;
			}else if($prevValue>0 and $result[$i]['output_Average_Current']>0 and $nextValue>0 and ($status_run>0 and $status_run<2)){
				if($ct<=0){
						$data = [];
						$data['imei_no'] = $imei_no;
						$data['well_id'] = $well_id;
						$data['start_datetime'] = $result[$i]['offline_device_timestamp'];
						$data['start_kwh'] = $result[$i]['output_Kwh'];
						$data['end_datetime'] = $result[$i]['offline_device_timestamp'];
						$data['end_kwh'] = $result[$i]['output_Kwh'];
						$data['total_kwh'] = 0;
						$data['total_running_minute']=0;
						$this->Savedata($data);
				}else{
					$diff_minute_1=floor(abs(strtotime($result[$i]['offline_device_timestamp']) - strtotime($last_data[0]['start_datetime']))/60);
					$diff_minute_2=floor(abs(strtotime($result[$i]['offline_device_timestamp']) - strtotime($last_data[0]['end_datetime']))/60);
					if($diff_minute_2<5){
						if($diff_minute_1>2){
							$data = [];
							$data['imei_no'] = $imei_no;
							$data['end_datetime'] = $result[$i]['offline_device_timestamp'];
							$data['end_kwh'] = $result[$i]['output_Kwh'];
							$data['total_kwh'] = $result[$i]['output_Kwh']-$last_data[0]['start_kwh'];
							$data['total_running_minute']=$diff_minute_1;
							$this->updatedata($data,['id'=>$last_data[0]['id']]);
						}
					}else{
						//print_r($diff_minute_1.'--'.$diff_minute_2.'***'.$result[$i]['offline_device_timestamp'].'#####'.$last_data[0]['end_datetime']); die;
						$data = [];
						$data['imei_no'] = $imei_no;
						$data['well_id'] = $well_id;
						$data['start_datetime'] = $result[$i]['offline_device_timestamp'];
						$data['start_kwh'] = $result[$i]['output_Kwh'];
						$data['end_datetime'] = $result[$i]['offline_device_timestamp'];
						$data['end_kwh'] = $result[$i]['output_Kwh'];
						$data['total_kwh'] = 0;
						$data['total_running_minute']=0;
						$this->Savedata($data);
						//break;
					}
				}
				// $result_set.='Running at '.$result[$i]['offline_device_timestamp'].'-'.$diffInMinutes;
				// $status_run=2;
				
			}
		}
		//print_r($result_set);
	 }
		
 }
	public function get_last_data($imei_no,$from_date_time, $to_date_time)
	{
		return $this->db->select("id,start_datetime,start_kwh,end_datetime")
		->from("tbl_well_running_log")->where(['imei_no'=>$imei_no,'start_datetime>='=>$from_date_time,'end_datetime<'=>$to_date_time])
		->order_by('id','DESC')->limit(1)->get()->result_array();
	}
	public function Savedata($data)
	{
		return $this->db->insert('tbl_well_running_log',$data);
	}
	public function updatedata($data,$where)
	{
		return $this->db->update('tbl_well_running_log',$data,$where);
	}
}
?>