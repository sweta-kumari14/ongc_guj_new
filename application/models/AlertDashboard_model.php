<?php
class AlertDashboard_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function SaveAlert_Data($dataArray)
	{
		return $this->db->insert('tbl_alert_log',$dataArray);
	}

	public function Alert_Report($company_id,$assets_id,$area_id,$site_id,$user_id,$date)
	{
		
		if($company_id!='')
			$this->db->where('di.company_id',$company_id);
		if($assets_id!='')
			$this->db->where('di.assets_id',$assets_id);
		if($area_id!='')
			$this->db->where('di.area_id',$area_id);
		if($site_id!='')
			$this->db->where('di.site_id',$site_id);
		if($user_id!='')
			$this->db->where('omm.user_id',$user_id);
		if($date!='')
			$this->db->where(['date(dl.c_date)'=>date('Y-m-d',strtotime($date))]);

		return $this->db->select("di.id,di.company_id,di.assets_id,di.area_id,am.area_name,di.site_id,wm.well_site_name,di.well_id,wmm.well_name,di.device_name,di.imei_no,dl.device_status,fm.fault_name,fm.color_code,dl.c_date,omm.user_id")
		->from('tbl_site_device_installation di')
		->join('tbl_device_log dl','di.imei_no=dl.imei_no','left')
		->join('tbl_fault_master fm','dl.trip_status=fm.fault_number','left')
		->join('tbl_role_wise_user_assign_details omm','di.site_id=omm.site_id','left')
		->join('tbl_area_master am','di.area_id=am.id','left')
		->join('tbl_well_site_master wm','di.site_id=wm.id','left')
		->join('tbl_well_master wmm','di.well_id=wmm.id','left')
		->where(['di.status'=>1,'dl.device_status!='=>1])->group_by('dl.id')->order_by("CAST(SUBSTRING_INDEX(wmm.well_name, '#', -1) AS UNSIGNED) ASC")->get()->result_array();
	}

	public function single_time_Alert_Report($imei_no,$date)
	{
		
		if($imei_no!='')
			$this->db->where('di.imei_no',$imei_no);
		if($date!='')
			$this->db->where(['dl.c_date'=>$date]);

		return $this->db->select("di.id,di.company_id,di.assets_id,di.area_id,am.area_name,di.site_id,wm.well_site_name,di.well_id,wmm.well_name,di.device_name,di.imei_no,dl.device_status,fm.fault_name,fm.color_code,dl.c_date,omm.user_id")
		->from('tbl_site_device_installation di')
		->join('tbl_device_log dl','di.imei_no=dl.imei_no','left')
		->join('tbl_fault_master fm','dl.trip_status=fm.fault_number','left')
		->join('tbl_role_wise_user_assign_details omm','di.site_id=omm.site_id','left')
		->join('tbl_area_master am','di.area_id=am.id','left')
		->join('tbl_well_site_master wm','di.site_id=wm.id','left')
		->join('tbl_well_master wmm','di.well_id=wmm.id','left')
		->where(['di.status'=>1,'dl.device_status!='=>1])->group_by('dl.id')->order_by("CAST(SUBSTRING_INDEX(wmm.well_name, '#', -1) AS UNSIGNED) ASC")->get()->result_array();
	}

}
?>