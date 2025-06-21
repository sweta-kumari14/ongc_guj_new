<?php
class DeviceReplacement_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function CheckDevie_Exist($imei_no)
	{
		return $this->db->select("count(id) as total,device_name")->from('tbl_site_device_installation')->where(['imei_no'=>$imei_no,'status'=>1])->get()->result_array();
		
	}

	public function get_Ins_id()
	{
		return $this->db->select("UUID()")->get()->result_array();
	}

	public function getDevice_Name($user_id,$imei_no)
	{
		$this->db->where('user_id',$user_id);
		return $this->db->select("device_name")->from('tbl_device_allotment_to_installer')->where(['imei_no'=>$imei_no,'status'=>1,'device_setup_status'=>1])->get()->result_array();
	}

	public function Update_Device_and_Sim($data,$where)
	{
		return $this->db->update('tbl_site_device_installation',$data,$where);
	}

	public function UpdateSetup_status($data,$where)
	{
		return $this->db->update('tbl_device_allotment_to_installer',$data,$where);
	}

	public function SaveReplecement_Device($data)
	{
		return $this->db->insert('tbl_device_replecement_details',$data);
	}

	public function getReplacedId()
	{
		return $this->db->select('UUID()')->get()->result_array();
	}

	public function SaveReplecementLog_Data($replaced)
	{
		return $this->db->insert('tbl_device_replacement_log',$replaced);
	}
}
?>