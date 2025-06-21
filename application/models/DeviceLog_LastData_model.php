<?php
class DeviceLog_LastData_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function Device_log_last_tenData($well_id,$imei_no)
	{
		if($well_id!='')
			$this->db->where('ds.well_id',$well_id);

		if($imei_no!='')
			$this->db->where('dl.imei_no',$imei_no);

		return $this->db->select("dl.*,ds.well_id,wm.well_name")
		->from('tbl_device_log dl')
		->join('tbl_site_device_installation ds','dl.imei_no=ds.imei_no','left')
		->join('tbl_well_master wm','ds.well_id=wm.id','left')
		->where(['dl.status'=>1])->order_by('dl.id','desc')->limit(10)->get()->result_array();
	}

	public function getImei()
	{
		return $this->db->select("imei_no")->from('tbl_site_device_installation')->where('status',1)->get()->result_array();
	}
}
?>