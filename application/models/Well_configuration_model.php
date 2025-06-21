<?php
class Well_configuration_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function Verify_Well_configuration($well_id)
	{
		$res = $this->db->select("count(id) as total")->from('tbl_well_configuration')->where(['well_id'=>$well_id,'status'=>1])->get()->result_array();

		if(!empty($res))
		{
			return $res[0]['total'];
		}else{
			return 0;
		}
	}


	public function getWCId()
	{
		return $this->db->select("UUID()")->get()->result_array();
	}

	public function Save_well($data)
	{
		return $this->db->insert('tbl_well_configuration',$data);
	}

	public function Verify_Well_configuration_Exist($well_id, $start_time, $stop_time)
	{
		if($well_id!='')
			$this->db->where('well_id',$well_id);

		if($start_time!='' && $stop_time!='')
       	{
       	  	 $this->db->where("start_time <= '$stop_time' AND stop_time >= '$start_time'");
       	}

		$res = $this->db->select("count(well_id) as total")->from('tbl_well_configuration')->where(['status'=>1])->get()->result_array();

		if(!empty($res))
		{
			return $res[0]['total'];
		}else{
			return 0;
		}

	}

	public function Save_well_log($data)
	{
		return $this->db->insert('tbl_well_configuration_log',$data);
	}

	public function get_configration_data($id, $company_id,$user_id,$search)
    	{
	    	if ($id != '') {
	        $this->db->where('wc.id', $id);
	    	}

	    	if($company_id != '') {
	        $this->db->where('wc.company_id', $company_id);
	    	}

	     if ($user_id != '') {
	        $this->db->where('ad.user_id', $user_id);
	    	}

	    	if ($search != '') 
	    	{
			$this->db->like('wm.well_name', $search);
	    	}
        

       	return $this->db->select('wc.id,wc.company_id,wc.well_id,wm.well_name,wc.well_type,wc.assign_date,vw.running_minutes')
       	->from('tbl_well_configuration wc')
       	->join('tbl_well_master wm', 'wc.well_id = wm.id', 'left')
       	->join('v_well_running_config vw','vw.well_id=wm.id','left')
       	->join('tbl_role_wise_user_assign_details ad','ad.well_id=wm.id and ad.status=1','left')
       	->where(['wc.status'=>1,'wm.status'=>1])
       	->group_by('vw.well_id')
       	->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")->get()->result_array();

    	}

    	public function get_well_config_list($id, $company_id,$user_id)
    	{
    	 	if ($id != '') {
	        $this->db->where('wc.id', $id);
	    	}

	    	if ($company_id != '') {
	        $this->db->where('wc.company_id', $company_id);
	    	}

	     if ($user_id != '') {
	        $this->db->where('ad.user_id', $user_id);
	    	}

       	return $this->db->select('wc.id,wc.company_id,wc.well_id,wm.well_name,wc.well_type,wc.assign_date,wc.start_time,wc.stop_time')
            ->from('tbl_well_configuration wc')
            ->join('tbl_well_master wm', 'wc.well_id = wm.id', 'left')
           ->join('tbl_role_wise_user_assign_details ad','ad.well_id=wm.id  and ad.status=1','left')
            ->where(['wc.status'=>1,'wm.status'=>1])
            ->group_by('wc.id')
            ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")->get()->result_array();
    	}
 
	public function Delete_well_data($data,$where)
	{
		return $this->db->update('tbl_well_configuration',$data,$where);
	}

	public function UpdateWellConfigration($data,$where)
	{
		return $this->db->update('tbl_well_configuration',$data,$where);
	}

	

	public function updateWellConfiguration($data,$where)
	{
		return $this->db->update('tbl_well_configuration',$data,$where);
	}

	public function UpdateWell_logConfigration($data,$where)
	{
		return $this->db->update('tbl_well_configuration_log',$data,$where);
	}

	public function Update_dataWell_Configration($where)
	{
		return $this->db->delete('tbl_well_configuration',$where);
	}

    	public function Verify_Well_configuration_Exist_or_Not($well_id, $start_time, $stop_time)
    	{
        	
		if($well_id!='')
			$this->db->where('well_id=',$well_id);

	    	if ($start_time != '' && $stop_time != '') {
	        	$this->db->where("start_time < '$stop_time' AND stop_time > '$start_time'", null, false);
	    	}

	    	$res = $this->db->select("COUNT(id) as total")->from('tbl_well_configuration')->where([ 'status' => 1])->get()->result_array();

	    	if (!empty($res)) {
	        return $res[0]['total'];
	    	} else {
	        return 0;
	    	}
    	}

    public function verifyWellSheduleExist_OR_not($well_id,$id)
    {
    	if($well_id!='')
    		$this->db->where('well_id',$well_id);
    	if($id!='')
			$this->db->where('id!=',$id);
		$res = $this->db->select("COUNT(id) as total")->from('tbl_well_configuration')->where([ 'status' =>1])->get()->result_array();

	    if (!empty($res)) {
	        return $res[0]['total'];
	    } else {
	        return 0;
	    }
    }

    

    public function Well_configuration_report($company_id,$from_date,$to_date,$well_id,$user_id,$sort_by)
    {
    	if($company_id!='')
			$this->db->where('wc.company_id',$company_id);

		if($well_id!='')
			$this->db->where('wc.well_id',$well_id);

		if($from_date!='' && $to_date!='')
			$this->db->where(['date(wc.c_date)>='=>$from_date,'date(wc.c_date)<='=>$to_date]);

		if($user_id!='')
			$this->db->where('ad.user_id',$user_id);
		if ($sort_by != '') 
            $this->db->order_by($sort_by, 'ASC');

		$result['regular_data'] =  $this->db->select("wc.*,wm.well_name")
		->from('tbl_well_configuration wc')
		->join('tbl_well_master wm','wc.well_id=wm.id','left')
		->join('tbl_role_wise_user_assign_details ad','ad.well_id=wm.id  and ad.status=1','left')
		->where(['wc.status'=>1,'wm.status'=>1,'wc.well_type'=>0])
		->group_by('wc.id')
		->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")->get()->result_array();

		if($company_id!='')
			$this->db->where('wc.company_id',$company_id);

		if($well_id!='')
			$this->db->where('wc.well_id',$well_id);

		if($from_date!='' && $to_date!='')
			$this->db->where(['date(wc.c_date)>='=>$from_date,'date(wc.c_date)<='=>$to_date]);

		if($user_id!='')
			$this->db->where('ad.user_id',$user_id);
		
		if ($sort_by != '') 
            $this->db->order_by($sort_by, 'ASC');


		$result['periodic_data'] =  $this->db->select('wc.id,wc.company_id,wc.well_id,wm.well_name,wc.well_type,wc.start_time,wc.stop_time,
	        CASE
	            WHEN ROW_NUMBER() OVER (PARTITION BY wc.well_id ORDER BY wc.c_date) = 1 THEN SUM(wc.running_hours) OVER (PARTITION BY wc.well_id)
	            ELSE null
	        END AS running_hours,wc.c_by,wc.c_date,wc.status')
            ->from('tbl_well_configuration wc')
            ->join('tbl_well_master wm', 'wc.well_id = wm.id', 'left')
            ->join('tbl_role_wise_user_assign_details ad','ad.well_id=wm.id  and ad.status=1','left')
            ->where(['wc.status'=>1,'wm.status'=>1,'wc.well_type'=>1])
            ->group_by('wc.id')
            ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")->get()->result_array();

		 $Data = array_merge($result['regular_data'] , $result['periodic_data']);
		 return $Data;
    }

    	public function get_welldetails_list($well_id)
    	{
		$result = $this->db->select('wc.id, wc.well_id, wc.well_type, wm.well_name, wc.running_hours, wc.assign_date, wc.start_time, wc.stop_time')
		    ->from('tbl_well_configuration wc')
		    ->join('tbl_well_master wm', 'wc.well_id=wm.id', 'left')
		    ->where(['wc.status' => 1, 'wc.well_id' => $well_id])
		    ->get()
		    ->result_array();

		$resultLength = count($result);

		return ['result' => $result, 'resultLength' => $resultLength];
   	}


   	public function verify_well_details($well_id)
   	{
   	 	return $this->db->select('well_id,well_type')
                 ->from('tbl_well_configuration')
                 ->where(['well_id'=>$well_id,'status'=>1])
                 ->group_by('well_id')
                 ->get()->result_array();
   	}

   	public function verify_exists_well_data($id)
	{
		$res = $this->db->select('well_id')->from('tbl_well_configuration')->where(['status'=>1,'id'=>$id])->get()->result_array();

		if (!empty($res)) 
		{
	        return $res;
	     } else {
	        return 0;
	     }
	}

	public function verify_exists_recode_or_not($id,$well_id)
	{
		if($id!='')
			$this->db->where('id!=',$id);
		$res =  $this->db->select('*')->from('tbl_well_configuration')->where(['status'=>1,'well_id'=>$well_id])->get()->result_array();
		if (!empty($res)) 
		{
	        return $res;
	     } else {

	        return 0;
	     }
	}

	public function verify_well_recode($well_id)
	{
		$res = $this->db->select('*')->from('tbl_well_configuration')->where(['status'=>1,'well_id'=>$well_id])->get()->result_array();
		 if (!empty($res)) 
		 {
	        return $res;
	      } else {

	        return 0;
	      }
	}

	public function checkCurrent_Daterecode($well_id)
	{
		$this->db->where(['date(c_date)'=>date('Y-m-d')]);
		$res = $this->db->select('count(well_id) as well')->from('tbl_well_configuration_log')->where(['status'=>1,'well_id'=>$well_id])->get()->result_array();
		if (!empty($res)) 
		{
	        return $res[0]['well'];
	     } else {
	        return 0;
	     }
	}

	public function DeleteWell_ConfigrationLogData($where)
	{
		return $this->db->delete('tbl_well_configuration_log',$where);
	}

	
	
}
?>