<?php
class Area_master_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function verifyAreaExist($area_name)
	{
		$res = $this->db->select("count(id) as total")->from('tbl_area_master')->where(['area_name'=>$area_name,'status'=>1])->get()->result_array();

		if(!empty($res))
		{
			return $res[0]['total'];
		}else{
			return 0;
		}
	}

	public function getClsId()
	{
		return $this->db->select("UUID()")->get()->result_array();
	}

	public function SaveArea($data)
	{
		return $this->db->insert('tbl_area_master',$data);
	}

	public function verifyAreaExist_OR_not($area_name,$id)
	{
		if($id!='')
			$this->db->where('id!=',$id);
		$res = $this->db->select("count(id) as total")->from('tbl_area_master')->where(['area_name'=>$area_name,'status'=>1])->get()->result_array();

		if(!empty($res))
		{
			return $res[0]['total'];
		}else{
			return 0;
		}
	}
	public function UpdateArea($data,$where)
	{
		return $this->db->update('tbl_area_master',$data,$where);
	}

	public function AreaList($id,$company_id,$assets_id)
	{
		if($id!='')
			$this->db->where('a.id',$id);
		if($company_id!='')
			$this->db->where('a.company_id',$company_id);
		if($assets_id!='')
			$this->db->where('a.assets_id',$assets_id);

		return $this->db->select("a.id,a.company_id,assets_id,a.area_name,cs.company_name,am.assets_name")
		->from('tbl_area_master a')
		->join('tbl_company_setup cs','a.company_id=cs.id','left')
		->join('tbl_assets_master am','a.assets_id=am.id','left')
		->where('a.status',1)->get()->result_array();
	}

	public function DeleteArea($data,$where)
	{
		return $this->db->update('tbl_area_master',$data,$where);
	}
}
?>