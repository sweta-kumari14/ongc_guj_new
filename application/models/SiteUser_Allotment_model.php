<?php
class SiteUser_Allotment_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getsite_userId()
	{
		return $this->db->select("UUID()")->get()->result_array();
	}

    public function Site_UserAllotment($data)
    {
    	return $this->db->insert('tbl_role_wise_user_assign_details',$data);
    }

    public function assign_UserUpdate($dataArray,$where)
	{
		return $this->db->update('tbl_role_wise_user_assign_details',$dataArray,$where);
	}

	public function getAll_area($company_id,$assets_id)
	{
		if($company_id!='')
			$this->db->where('am.company_id',$company_id);
		if($assets_id!='')
			$this->db->where('am.assets_id',$assets_id);
		return $this->db->select('am.id,am.assets_id,wsm.id as well_site_id')->from('tbl_area_master am')->join('tbl_well_site_master wsm','am.id = wsm.area_id and wsm.status = 1','left')->where(['am.status'=>1])->get()->result_array();
	}

	public function getAll_site($company_id,$assets_id,$area_id)
	{
		if($company_id!='')
			$this->db->where('w.company_id',$company_id);
		if($assets_id!='')
			$this->db->where('w.assets_id',$assets_id);
		if($area_id!='')
			$this->db->where('w.area_id',$area_id);
		return $this->db->select('w.id,w.assets_id,w.area_id')->from('tbl_well_site_master w')
		->where(['w.status'=>1])->get()->result_array();
	}

	public function getAll_details($company_id,$assets_id,$area_id,$site_id)
	{
		if($company_id!='')
			$this->db->where('company_id',$company_id);
		if($assets_id!='')
			$this->db->where('assets_id',$assets_id);
		if($area_id!='')
			$this->db->where('area_id',$area_id);
		if($site_id!='')
			$this->db->where('id',$site_id);

		return $this->db->select('id,assets_id,area_id,well_site_name')
		->from('tbl_well_site_master')->where(['status',1])->get()->result_array();
	}

	// ===================== code for listing assets  =========================

	public function getAssignAssetList($user_id,$company_id)
	{
	   	return $this->db->select('id,assets_id')->from('tbl_role_wise_user_assign_details')->where(['status'=>1,'user_id'=>$user_id,'company_id'=>$company_id])->get()->result_array();
	   		
	}

	public function get_assets_list_to_allot($company_id)
    {
   		if($company_id!="")
				$this->db->where(['company_id'=>$company_id]);
			return $this->db->select('id,company_id,assets_name')->from('tbl_assets_master')->where(['status'=>1])->get()->result_array();
    }

    // ===================== code for listing area  =========================

	public function getAssignAreaList($user_id,$company_id,$assets_id)
	{
	   	return $this->db->select('id,area_id')->from('tbl_role_wise_user_assign_details')->where(['status'=>1,'user_id'=>$user_id,'company_id'=>$company_id,'assets_id'=>$assets_id])->get()->result_array();
	   		
	}

	public function get_area_list_to_allot($company_id,$assets_id)
    {
   		if($company_id!="")
				$this->db->where(['company_id'=>$company_id]);
		if($assets_id!="")
				$this->db->where(['assets_id'=>$assets_id]);
			return $this->db->select('id,company_id,assets_id,area_name')->from('tbl_area_master')->where(['status'=>1])->get()->result_array();
    }

    // ===================== code for listing Site  =========================

	public function getAssignSiteList($user_id,$company_id,$assets_id,$area_id)
	{
	   	return $this->db->select('id,site_id')->from('tbl_role_wise_user_assign_details')->where(['status'=>1,'user_id'=>$user_id,'company_id'=>$company_id,'assets_id'=>$assets_id,'area_id'=>$area_id])->get()->result_array();
	   		
	}

	public function get_Site_list_to_allot($company_id,$assets_id,$area_id)
    {
   		if($company_id!="")
				$this->db->where(['company_id'=>$company_id]);
		if($assets_id!="")
				$this->db->where(['assets_id'=>$assets_id]);
		if($area_id!="")
				$this->db->where(['area_id'=>$area_id]);
			return $this->db->select('id,company_id,assets_id,area_id,well_site_name')->from('tbl_well_site_master')->where(['status'=>1])->get()->result_array();
    }


}
?>