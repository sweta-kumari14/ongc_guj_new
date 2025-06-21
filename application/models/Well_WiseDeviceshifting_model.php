<?php
class Well_WiseDeviceshifting_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function Check_Well_Exist_orNOt($well_id)
	{
		return $this->db->select("count(id) as total,sim_no,sim_provider,network_type")->from('tbl_site_device_installation')->where(['well_id'=>$well_id,'device_shifted'=>0,'status'=>1])->get()->result_array();
		
	}

	public function CheckCurrentWellExist($well_id)
	{
		return $this->db->select("count(id) as total,device_shifted")->from('tbl_site_device_installation')->where(['well_id'=>$well_id,'status'=>1])->get()->result_array();
		
	}

	public function CheckAllotWellExist($well_id)
	{
		return $this->db->select("count(id) as total")->from('tbl_shift_reinstall_well_log')->where(['well_id'=>$well_id,'status'=>1,'re_install_status'=>0])->get()->result_array();
	}

	public function Update_Previous_Installed_Devicestatus($data,$where)
	{
		return $this->db->update('tbl_device_allotment_to_installer',$data,$where);
	}

	public function Update_ReinstallDevicestatus($data,$where)
  {
  	return $this->db->update('tbl_shift_reinstall_well_log',$data,$where);
  }

	public function getInstallId()
	{
		return $this->db->select('UUID()')->get()->result_array();
	}

	public function get_wellShiftedId()
	{
		return $this->db->select('UUID()')->get()->result_array();
	}

	public function get_wellInterchangeId()
	{
		return $this->db->select('UUID()')->get()->result_array();
	}


	public function WellShifted_Device_Save($data)
	{
		return $this->db->insert('tbl_well_shifted_device_details',$data);
	}

	public function getInstalledwell_data($well_id)
	{
		if($well_id!='')
			$this->db->where('id',$well_id);
       return $this->db->select('assets_id,area_id,site_id,well_name,lat,long')
               ->from('tbl_well_master')->where(['device_setup_status'=>0,'status'=>1])->get()->result_array();
	}

	public function Update_Devicestatus($data,$where)
	{
		return $this->db->update('tbl_site_device_installation',$data,$where);
	}


	public function Well_shifted_Device_Save($data)
	{
		return $this->db->insert('tbl_site_device_installation',$data);
	}

	public function SaveDevice_data($data)
	{
		return $this->db->insert('tbl_shift_reinstall_well_log',$data);
	}
	public function WellWiseDevice_installationStatus($data,$where)
	{
		return $this->db->update('tbl_well_master',$data,$where);
	}

	public function getEqu_details($well_id)
	{
		$this->db->where('well_id',$well_id);
		$res = $this->db->select("count(id) as total")->from('tbl_equipment_details')->where('status',1)->get()->result_array();
		if($res!='')
		{
			return $res[0]['total'];
		}else{
			return 0;
		}
	}

	
	public function getreportwell_replacement_device_log($company_id, $user_id, $well_id,$from_date, $to_date)
	{
	    if ($company_id != '') {
	        $this->db->where('ws.company_id', $company_id);
	    }
	    if ($user_id != '') {
	        $this->db->where('ws.shifted_by', $user_id);
	    }
	    if ($well_id != '') {
	        $this->db->where('ws.shifted_well_id', $well_id);
	    }

	    if ($from_date != '' && $to_date != '') {
	        $this->db->where(['date(ws.shifted_datetime) >=' => $from_date, 'date(ws.shifted_datetime) <=' => $to_date]);
	    }

	    return $this->db
	        ->select("ws.*, wm_shifted.well_name as shifted_well_name, wm_allotted.well_name as allotted_well_name,omm.user_full_name")

	        ->from('tbl_well_shifted_device_details ws')

	        ->join('tbl_well_master wm_shifted', 'ws.shifted_well_id = wm_shifted.id and wm_shifted.status = 1', 'left')

	        ->join('tbl_well_master wm_allotted', 'ws.allot_well_id = wm_allotted.id and wm_allotted.status = 1', 'left')

	        ->join('tbl_ongc_member_master omm', 'ws.shifted_by = omm.id and omm.status = 1', 'left')
	        
                ->order_by('ws.shifted_datetime','desc')
	       
	        ->get()
	        ->result_array();
	}



	public function get_well_shifting_log($imei_no)
	{
	    if ($imei_no != '') {
	        $this->db->where('sd.imei_no', $imei_no);
	    }

	    $result['currnt'] = $this->db
	        ->select("sd.well_id, wmc.well_name as well_name, sd.date_of_installation as date, sd.device_shifted as status")
	        ->from('tbl_site_device_installation sd')
	        ->join('tbl_well_shifted_device_details ws', 'sd.imei_no=ws.allot_current_imei_no', 'left')
	        ->join('tbl_well_master wmc', 'wmc.id=sd.well_id', 'left')
	        ->group_by('sd.well_id')
	        ->get()
	        ->result_array();

	        // print_r($result['currnt']);die;

	    $result['shifted'] = $this->db
	        ->select("ws.shifted_well_id, wms.well_name as well_name, ws.shifted_well_installation_date as date, ws.shifted_imei_no as imei_no, ws.shifted_datetime as shifteddate, sd.device_shifted as status")
	        ->from('tbl_site_device_installation sd')
	        ->join('tbl_well_shifted_device_details ws', 'sd.well_id=ws.shifted_well_id', 'left')
	        ->join('tbl_well_master wms', 'wms.id=ws.shifted_well_id', 'left')
	        ->where(['shifted_imei_no' => $imei_no])
	        ->get()
	        ->result_array();

	    $Data = array_merge($result['currnt'], $result['shifted']);

	    return $Data;
	}


	public function get_well_wise_shifting_log($well_id)
	{
	   if ($well_id != '') {
           $this->db->where('sd.well_id', $well_id);
    }

        $result['currnt'] = $this->db
              ->select("sd.well_id, wmc.well_name as well_name, sd.date_of_installation as date, sd.device_shifted as status, 
               COALESCE(sd.device_name, ws.allot_current_device_name,ws.allot_prv_device_name) as device_name,
               COALESCE(sd.imei_no, ws.allot_current_imei_no,ws.allot_prv_imei_no) as imei_no,sd.date_of_shifted as shifteddate")
   				 ->from('tbl_site_device_installation sd')
    			 ->join('tbl_well_shifted_device_details ws', 'sd.well_id=ws.shifted_well_id', 'left')
                 ->join('tbl_well_master wmc', 'wmc.id=sd.well_id', 'left')
                 ->order_by('ws.shifted_datetime', 'desc')
                 ->limit(1)
                 ->get()
                 ->result_array();

        // print_r($result['currnt']);die;

	      

	    $result['shifted'] = $this->db
	        ->select("ws.allot_well_id, wms.well_name as well_name, ws.allot_prv_installation_date as date, ws.allot_prv_device_name as device_name, ws.shifted_datetime as shifteddate, ws.status as status,ws.allot_prv_imei_no as imei_no")
	        ->from('tbl_site_device_installation sd')
	        ->join('tbl_well_shifted_device_details ws', 'sd.well_id=ws.allot_well_id', 'left')
	        ->join('tbl_well_master wms', 'wms.id=ws.allot_well_id', 'left')
	        ->where(['allot_well_id' => $well_id])
	        ->get()
	        ->result_array();

	    $Data = array_merge($result['currnt'], $result['shifted']);

	    return $Data;
	}



			
}
?>
