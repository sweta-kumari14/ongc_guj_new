<?php
class Equipment_details_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getEqupId()
	{
		return $this->db->select("UUID()")->get()->result_array();
	}

	public function verifySerial_numExist($serial_no)
	{
		if($serial_no!='')
			$this->db->where('serial_no',$serial_no);
		
		$result = $this->db->select("count(id) as total")->from('tbl_equipment_details')->where(['status'=>1])->get()->result_array();
		if($result!='')
		{
			return $result[0]['total'];
		}else{
			return 0;
		}
	}

	public function Save_Equipment_Details_data($details)
	{
		return $this->db->insert('tbl_equipment_details',$details);
	}

	public function getLogId()
	{
		return $this->db->select("UUID()")->get()->result_array();
	}

	public function Save_Equipment_Log_data($log)
	{
		return $this->db->insert('tbl_equipment_details_log',$log);
	}

	public function getLast_Data($serial_no)
	{
		if($serial_no!='')
			$this->db->where('serial_no',$serial_no);
		return $this->db->select("id")->from('tbl_equipment_details')->where(['status'=>1])->get()->result_array();

	}

	public function Update_LastLog_Data($data,$where)
	{
		return $this->db->update('tbl_equipment_details',$data,$where);
	}

	public function get_EquipmentList($company_id,$assets_id,$area_id,$site_id,$well_id,$eqp_id,$serial_no)
	{
		if($company_id!='')
			$this->db->where('company_id',$company_id);
		if($assets_id!='')
			$this->db->where('assets_id',$assets_id);
		if($area_id!='')
			$this->db->where('area_id',$area_id);
		if($site_id!='')
			$this->db->where('site_id',$site_id);
		if($well_id!='')
			$this->db->where('well_id',$well_id);
		if($eqp_id!='')
			$this->db->where('eqp_id',$eqp_id);
		if($serial_no!='')
			$this->db->where('serial_no',$serial_no);

		return $this->db->select("*")->from('tbl_equipment_details')->where(['status'=>1])->get()->result_array();
	}

}
?>