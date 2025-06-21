<?php
class Well_master_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function verifyWellExist($well_name)
	{
		$res = $this->db->select("count(id) as total")->from('tbl_well_master')->where(['well_name'=>$well_name,'status'=>1])->get()->result_array();

		if(!empty($res))
		{
			return $res[0]['total'];
		}else{
			return 0;
		}
	}

	public function getWellId()
	{
		return $this->db->select("UUID()")->get()->result_array();
	}

	public function SaveWellData($data)
	{
		return $this->db->insert('tbl_well_master',$data);
	}

	public function verifyWellExist_OR_not($well_name,$id)
	{
		if($id!='')
			$this->db->where('id!=',$id);
		$res = $this->db->select("count(id) as total")->from('tbl_well_master')->where(['well_name'=>$well_name,'status'=>1])->get()->result_array();

		if(!empty($res))
		{
			return $res[0]['total'];
		}else{
			return 0;
		}
	}
	public function UpdateWell($data,$where)
	{
		return $this->db->update('tbl_well_master',$data,$where);
	}

	public function WellList($id,$company_id,$assets_id,$area_id,$site_id,$well_type)
	{
		if($id!='')
			$this->db->where('w.id',$id);
		if($company_id!='')
			$this->db->where('w.company_id',$company_id);
		if($assets_id!='')
			$this->db->where('w.assets_id',$assets_id);
		if($area_id!='')
			$this->db->where('w.area_id',$area_id);
		if($site_id!='')
			$this->db->where('w.site_id',$site_id);
		if($well_type!='')
			$this->db->where('w.well_type',$well_type);

		return $this->db->select("w.id,w.company_id,cs.company_name,w.assets_id,am.assets_name,w.area_id,amm.area_name,w.site_id,wsm.well_site_name,w.well_name,w.lat,w.long,wt.well_type_name,wt.id as well_type_id")
		->from('tbl_well_master w')
		->join('tbl_company_setup cs','w.company_id=cs.id','left')
		->join('tbl_assets_master am','w.assets_id=am.id','left')
		->join('tbl_area_master amm','w.area_id=amm.id','left')
		->join('tbl_well_site_master wsm','w.site_id=wsm.id','left')
		->join('tbl_well_type wt', 'w.well_type = wt.id', 'left')
		->order_by("CAST(SUBSTRING_INDEX(w.well_name, '#', -1) AS UNSIGNED) ASC")
		->where('w.status',1)->get()->result_array();
	}

	public function Delete_Well($data,$where)
	{
		return $this->db->update('tbl_well_master',$data,$where);
	}
}
?>