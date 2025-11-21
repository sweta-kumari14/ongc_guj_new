<?php
class Real_Time_mqtt_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function SaveDevice_configration($data)
	{
		return $this->db->insert('tbl_device_configration_log',$data);
	}

	public function Device_configration_log($imei_no, $from_date, $to_date)
	{
	    if ($imei_no != '') {
	        $this->db->where('dac.imei_no', $imei_no);
	    }

	    if ($from_date != '' && $to_date != '') {
	        $this->db->where("DATE(dac.c_date) >=", $from_date);
	        $this->db->where("DATE(dac.c_date) <=", $to_date);
	    }

	    return $this->db->select("
	            dm.device_name,
	            dac.imei_no,dac.topic,dac.command_value,
	            dac.c_date AS publish_date_time,
	            am.unique_userId,om.user_full_name
	        ")
	        ->from("tbl_device_configration_log dac")
	        ->join("tbl_device_setup dm", "dm.imei_no = dac.imei_no", "left")
	        ->join("tbl_authentication_master am", "am.user_member_id = dac.c_by", "left")
	        ->join("tbl_ongc_member_master om", "om.id = am.user_member_id", "left")
	        ->where("dac.status", 1)
	        ->order_by("dac.c_date", "DESC")
	        ->get()
	        ->result_array();
	}

}
?>