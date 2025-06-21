<?php
class Component_master_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function verify_componentExist($component_name)
	{
		$res = $this->db->select("count(id) as total")->from('tbl_component_master')->where(['component_name'=>$component_name,'status'=>1])->get()->result_array();

		if(!empty($res))
		{
			return $res[0]['total'];
		}else{
			return 0;
		}
	}

	public function Save_componentData($data)
	{
		return $this->db->insert('tbl_component_master',$data);
	}

	public function verifyComponentExist_OR_not($component_name,$id)
	{
		if($id!='')
			$this->db->where('id!=',$id);
		$res = $this->db->select("count(id) as total")->from('tbl_component_master')->where(['component_name'=>$component_name,'status'=>1])->get()->result_array();

		if(!empty($res))
		{
			return $res[0]['total'];
		}else{
			return 0;
		}
	}
	public function UpdateComponent($data,$where)
	{
		return $this->db->update('tbl_component_master',$data,$where);
	}

	public function ComponentList($id,$company_id)
	{
		if($id!='')
			$this->db->where('im.id',$id);
		if($company_id!='')
			$this->db->where('im.company_id',$company_id);

		$result = $this->db->select("im.id,im.company_id,cs.company_name,im.component_name")
		->from('tbl_component_master im')
		->join('tbl_company_setup cs','im.company_id=cs.id','left')
		->order_by("CAST(SUBSTRING_INDEX(im.component_name, '#', -1) AS UNSIGNED) ASC")
		->where(['im.status'=>1,'cs.status'=>1])->get()->result_array();

        return $result;
	}

	public function DeleteItem($data,$where)
	{
		return $this->db->update('tbl_component_master',$data,$where);
	}
}
?>