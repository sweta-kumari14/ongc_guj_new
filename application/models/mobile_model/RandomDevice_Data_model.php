<?php
class RandomDevice_Data_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function CheckImei_Exist($imei_no)
	{
		return $this->db->select("count(id) as total,device_name")->from('tbl_site_device_installation')->where(['imei_no'=>$imei_no,'status'=>1])->get()->result_array();
		
	}

	public function getLogId()
	{
		return $this->db->select("UUID()")->get()->result_array();
	}

	public function Save_Installation_DeviceLogData($data)
	{
		return $this->db->insert('tbl_device_log',$data);
	}

	public function Update_LastData($data,$where)
	{
		return $this->db->update('tbl_site_device_installation',$data,$where);
	}

	public function getTripId()
	{
		return $this->db->select("UUID()")->get()->result_array();
	}

	public function getFault_number($trip_status)
	{
		return $this->db->select("fault_number,fault_name")->from('tbl_fault_master')->where(['status'=>1,'fault_number'=>$trip_status])->get()->result_array();
	}

	public function SaveFault_Data($trip)
	{
		return $this->db->insert('tbl_trip_log',$trip);
	}

	public function getAlertId()
	{
		return $this->db->select("UUID()")->get()->result_array();
	}

	public function SaveAlert_Data($alert)
	{
		return $this->db->insert('tbl_device_alert_log',$alert);
	}
}
?>