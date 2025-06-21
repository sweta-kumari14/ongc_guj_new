<?php
class Equipment_master_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function verify_EquipmentExist($equipment_name)
	{
		$res = $this->db->select("count(id) as total")->from('tbl_equipment_master')->where(['equipment_name'=>$equipment_name,'status'=>1])->get()->result_array();

		if(!empty($res))
		{
			return $res[0]['total'];
		}else{
			return 0;
		}
	}

	public function getEqpId()
	{
		return $this->db->select("UUID()")->get()->result_array();
	}

	public function SaveEquipment($data)
	{
		return $this->db->insert('tbl_equipment_master',$data);
	}

	public function verifyEquimentExist_OR_not($equipment_name,$id)
	{
		if($id!='')
			$this->db->where('id!=',$id);
		$res = $this->db->select("count(id) as total")->from('tbl_equipment_master')->where(['equipment_name'=>$equipment_name,'status'=>1])->get()->result_array();

		if(!empty($res))
		{
			return $res[0]['total'];
		}else{
			return 0;
		}
	}
	public function UpdateEquipment($data,$where)
	{
		return $this->db->update('tbl_equipment_master',$data,$where);
	}

	public function EquipmentList($id,$company_id)
	{
		if($id!='')
			$this->db->where('e.id',$id);
		if($company_id!='')
			$this->db->where('e.company_id',$company_id);
		
		return $this->db->select("e.id,e.company_id,cs.company_name,e.equipment_name")
		->from('tbl_equipment_master e')
		->join('tbl_company_setup cs','e.company_id=cs.id','left')
		->where('e.status',1)->get()->result_array();
	}

	public function DeleteEquipment($data,$where)
	{
		return $this->db->update('tbl_equipment_master',$data,$where);
	}
}
?>