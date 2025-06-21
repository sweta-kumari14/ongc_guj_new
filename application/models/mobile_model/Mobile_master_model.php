<?php
class Mobile_master_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getDeviceList($company_id,$user_id)
	{
		if($company_id!='')
			$this->db->where('company_id',$company_id);
		if($user_id!='')
			$this->db->where('user_id',$user_id);

		return $this->db->select("company_id,user_id,device_name,imei_no")->from('tbl_device_allotment_to_installer')->where(['status'=>1,'device_setup_status'=>1])->get()->result_array();
	}

    public function get_Asset_List($company_id,$user_id)
    {
        if($company_id!='')
            $this->db->where('ad.company_id',$company_id);
        if($user_id!='')
            $this->db->where('ad.user_id',$user_id);

        return $this->db->select("ad.id,ad.company_id,user_id,ad.assets_id,am.assets_name")
        ->from('tbl_role_wise_user_assign_details ad')
        ->join('tbl_assets_master am','ad.assets_id=am.id','left')
        ->where(['ad.status'=>1,'ad.role_type'=>3])->group_by('ad.assets_id')->get()->result_array();
    }

    public function get_Area_List($company_id,$user_id,$assets_id)
    {
        if($company_id!='')
            $this->db->where('ad.company_id',$company_id);
        if($user_id!='')
            $this->db->where('ad.user_id',$user_id);
        if($assets_id!='')
            $this->db->where('ad.assets_id',$assets_id);

        return $this->db->select("ad.id,ad.company_id,ad.user_id,ad.assets_id,ad.area_id,am.area_name")
        ->from('tbl_role_wise_user_assign_details ad')
        ->join('tbl_area_master am','ad.area_id=am.id','left')
        ->where(['ad.status'=>1,'ad.role_type'=>3])->group_by('ad.area_id')->get()->result_array();
    }

    public function getSite_List($company_id,$user_id,$assets_id,$area_id)
    {
        if($company_id!='')
            $this->db->where('ad.company_id',$company_id);
        if($user_id!='')
            $this->db->where('ad.user_id',$user_id);
        if($assets_id!='')
            $this->db->where('ad.assets_id',$assets_id);
        if($area_id!='')
            $this->db->where('ad.area_id',$area_id);

        return $this->db->select("ad.id,ad.company_id,ad.user_id,ad.assets_id,ad.area_id,ad.site_id,wm.well_site_name")
        ->from('tbl_role_wise_user_assign_details ad')
        ->join('tbl_well_site_master wm','ad.site_id=wm.id','left')
        ->where(['ad.status'=>1,'ad.role_type'=>3])->group_by('ad.site_id')->get()->result_array();
    }

    public function getWell_List($company_id,$user_id,$assets_id,$area_id,$site_id)
    {
        if($company_id!='')
            $this->db->where('ad.company_id',$company_id);
        if($user_id!='')
            $this->db->where('ad.user_id',$user_id);
        if($assets_id!='')
            $this->db->where('ad.assets_id',$assets_id);
        if($area_id!='')
            $this->db->where('ad.area_id',$area_id);
        if($site_id!='')
            $this->db->where('ad.site_id',$site_id);

        // return $this->db->select("ad.id,ad.company_id,ad.user_id,ad.assets_id,ad.area_id,ad.site_id,ad.well_id,wm.well_name")
        // ->from('tbl_role_wise_user_assign_details ad')
        // ->join('tbl_well_master wm','ad.well_id=wm.id','left')
        // ->where(['ad.status'=>1,'ad.role_type'=>3])->order_by("CAST(SUBSTRING_INDEX(well_name, '#', -1) AS UNSIGNED) ASC")->get()->result_array();

         $res['assign_well'] = $this->db->select("ad.id,ad.company_id,ad.user_id,ad.assets_id,ad.area_id,ad.site_id,ad.well_id,wm.well_name,wm.lat,wm.long")
        ->from('tbl_role_wise_user_assign_details ad')
        ->join('tbl_well_master wm','ad.well_id=wm.id','left')
        ->where(['ad.status'=>1,'ad.role_type'=>3,'wm.device_setup_status'=>0])->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")->get()->result_array();

        $res['shift_well'] = $this->db->select("ad.id,ad.company_id,ad.user_id,ad.assets_id,ad.area_id,ad.site_id,ad.well_id,wm.well_name,wm.lat,wm.long")
        ->from('tbl_role_wise_user_assign_details ad')
        ->join('tbl_site_device_installation si','ad.well_id=si.well_id','left')
        ->join('tbl_well_master wm','ad.well_id=wm.id','left')
        ->where(['ad.status'=>1,'ad.role_type'=>3,'si.device_shifted'=>1])->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")->get()->result_array();

        $Result = array_merge($res['assign_well'], $res['shift_well']);

        return $Result;
    }

    

    // ================ replacement code =================

    public function Device_List_for_Replacement($company_id,$user_id,$assets_id,$area_id,$site_id,$well_id)
    {
        if($company_id!='')
            $this->db->where('company_id',$company_id);
        if($user_id!='')
            $this->db->where('installed_by',$user_id);
        if($assets_id!='')
            $this->db->where('assets_id',$assets_id);
        if($area_id!='')
            $this->db->where('area_id',$area_id);
        if($site_id!='')
            $this->db->where('site_id',$site_id);
        if($well_id!='')
            $this->db->where('well_id',$well_id);

        return $this->db->select("id,company_id,installed_by,assets_id,area_id,site_id,well_id,device_name,imei_no,sim_no,network_type,sim_provider")
        ->from('tbl_site_device_installation')
        ->where(['status'=>1])->get()->result_array();
    }

    public function get_Asset_List_for_replacement($company_id,$installed_by)
    {
        if($company_id!='')
            $this->db->where('di.company_id',$company_id);
        if($installed_by!='')
            $this->db->where('di.installed_by',$installed_by);

        return $this->db->select("di.company_id,di.installed_by,di.assets_id,am.assets_name")
        ->from('tbl_site_device_installation di')
        ->join('tbl_assets_master am','di.assets_id=am.id','left')
        ->where(['di.status'=>1])->group_by('di.assets_id')->get()->result_array();
    }

    public function get_Area_List_for_replacement($company_id,$installed_by,$assets_id)
    {
        if($company_id!='')
            $this->db->where('di.company_id',$company_id);
        if($installed_by!='')
            $this->db->where('di.installed_by',$installed_by);
        if($assets_id!='')
            $this->db->where('di.assets_id',$assets_id);

        return $this->db->select("di.company_id,di.installed_by,di.assets_id,di.area_id,am.area_name")
        ->from('tbl_site_device_installation di')
        ->join('tbl_area_master am','di.area_id=am.id','left')
        ->where(['di.status'=>1])->group_by('di.area_id')->get()->result_array();
    }

    public function get_Site_List_for_replacement($company_id,$installed_by,$assets_id,$area_id)
    {
        if($company_id!='')
            $this->db->where('di.company_id',$company_id);
        if($installed_by!='')
            $this->db->where('di.installed_by',$installed_by);
        if($assets_id!='')
            $this->db->where('di.assets_id',$assets_id);
        if($area_id!='')
            $this->db->where('di.area_id',$area_id);

        return $this->db->select("di.company_id,di.installed_by,di.assets_id,di.area_id,site_id,wm.well_site_name")
        ->from('tbl_site_device_installation di')
        ->join('tbl_well_site_master wm','di.site_id=wm.id','left')
        ->where(['di.status'=>1])->group_by('di.site_id')->get()->result_array();
    }

    public function get_WellList_for_replacement($company_id,$installed_by,$assets_id,$area_id,$site_id)
    {
        if($company_id!='')
            $this->db->where('di.company_id',$company_id);
        if($installed_by!='')
            $this->db->where('di.installed_by',$installed_by);
        if($assets_id!='')
            $this->db->where('di.assets_id',$assets_id);
        if($area_id!='')
            $this->db->where('di.area_id',$area_id);
        if($site_id!='')
            $this->db->where('di.site_id',$site_id);

        return $this->db->select("di.company_id,di.installed_by,di.assets_id,di.area_id,di.site_id,di.well_id,wm.well_name")
        ->from('tbl_site_device_installation di')
        ->join('tbl_well_master wm','di.well_id=wm.id','left')
        ->where(['di.status'=>1])->group_by('di.well_id')->get()->result_array();
    }

	

	

    

    
}
?>