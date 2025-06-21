<?php
class Assets_Master_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function verifyAssetExist($assets_name)
	{
		$res = $this->db->select("count(id) as total")->from('tbl_assets_master')->where(['assets_name'=>$assets_name,'status'=>1])->get()->result_array();

		if(!empty($res))
		{
			return $res[0]['total'];
		}else{
			return 0;
		}
	}

	public function getAssetId()
	{
		return $this->db->select("UUID()")->get()->result_array();
	}

	public function SaveAssets($data)
	{
		return $this->db->insert('tbl_assets_master',$data);
	}

	public function verifyAssetExist_OR_not($assets_name,$id)
	{
		if($id!='')
			$this->db->where('id!=',$id);
		$res = $this->db->select("count(id) as total")->from('tbl_assets_master')->where(['assets_name'=>$assets_name,'status'=>1])->get()->result_array();

		if(!empty($res))
		{
			return $res[0]['total'];
		}else{
			return 0;
		}
	}
	public function UpdateAssets($data,$where)
	{
		return $this->db->update('tbl_assets_master',$data,$where);
	}

	public function AssetsList($id,$company_id)
	{
		if($id!='')
			$this->db->where('a.id',$id);
		if($company_id!='')
			$this->db->where('a.company_id',$company_id);
		return $this->db->select("a.id,a.company_id,a.assets_name,cs.company_name")
		->from('tbl_assets_master a')
		->join('tbl_company_setup cs','a.company_id=cs.id','left')
		->where('a.status',1)->get()->result_array();
	}

	public function DeleteAssets($data,$where)
	{
		return $this->db->update('tbl_assets_master',$data,$where);
	}
}
?>