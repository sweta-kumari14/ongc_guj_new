<?php
class Equipment_Allotment_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getAllotId()
	{
		return $this->db->select("UUID()")->get()->result_array();
	}

	public function Save_EquipmentAllotment_data($data)
	{
		return $this->db->insert('tbl_equipment_allotment_details',$data);
	}

	public function getEqupId()
	{
		return $this->db->select("UUID()")->get()->result_array();
	}

	public function Save_Equipment_Details_data($details)
	{
		return $this->db->insert('tbl_equipment_details',$details);
	}

	public function UpdateAllotedDevice($data,$where)
	{
		return $this->db->update('tbl_device_setup',$data,$where);
	}
}
?>