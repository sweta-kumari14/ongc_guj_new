<?php  
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Master_model extends CI_Model
{
		
	public function __construct() 
	{

        parent::__construct(); 
    }

    
    public function CountryList()
    {
    	return $this->db->select("id,name")->from('tbl_country_master')->get()->result_array();
    }

    public function State_List($country_id)
    {
    	if($country_id!='')
    		$this->db->where('country_id',$country_id);
    	return $this->db->select("id,country_id,name")->from('tbl_state_master')->get()->result_array();
    }

    public function companyList()
    {
        return $this->db->select("id,company_name")->from('tbl_company_setup')->where(['status'=>1])->get()->result_array();
    }

    public function DesignationList()
    {
        return $this->db->select("id,designation,designation_name")->from('tbl_designation_setup')->where(['status'=>1])->get()->result_array();
    }

    public function ComponentList()
    {
        return $this->db->select("id,component_name")->from('tbl_component_master')->where(['status'=>1])->get()->result_array();
    }

    public function Site_List($company_id,$area_id)
    {
        if($company_id!='')
            $this->db->where('company_id',$company_id);
        if($area_id!='')
            $this->db->where('area_id',$area_id);
        return $this->db->select("id,well_site_name,company_id,area_id")->from('tbl_well_site_master')->where(['status'=>1])->get()->result_array();
    }

    public function Device_list_for_company()
    {
        return $this->db->select("id,device_name,imei_no,serial_no")->from('tbl_device_setup')->where(['status'=>1,'allot_status'=>0])->get()->result_array();
    }


    public function user_List($company_id)
    {
        if($company_id!='')
            $this->db->where('company_id',$company_id);
        return $this->db->select("id,user_full_name,company_id")->from('tbl_ongc_member_master')->where(['status'=>1])->get()->result_array();
    }

    public function AssetsList($id,$company_id)
    {
        if($id!='')
            $this->db->where('am.id',$id);
        if($company_id!='')
            $this->db->where('am.company_id',$company_id);
        return $this->db->select("am.id,am.company_id,am.assets_name,cs.company_name")
        ->from('tbl_assets_master am')
        ->join('tbl_company_setup cs','am.company_id=cs.id','left')
        ->where(['am.status'=>1])->get()->result_array();
    }

 public function getWelllist($company_id,$assets_id,$user_id,$well_id,$site_id)
    {
        if($company_id!='')
            $this->db->where('wm.company_id',$company_id);
        if($assets_id!='')
            $this->db->where('wm.assets_id',$assets_id);
        if($user_id!='')
            $this->db->where('ad.user_id',$user_id);
        if($well_id!='')
            $this->db->where('ad.well_id',$well_id);
         if($site_id!='')
            $this->db->where('ws.id',$site_id);

        return $this->db->select("wm.id as well_id,wm.assets_id,wm.area_id,ws.id as site_id,wm.well_name,ad.user_id,sd.device_name,sd.imei_no")
                ->from('tbl_well_master wm')
                ->join('tbl_site_device_installtion_self_flow sd','wm.id=sd.well_id','left')
                ->join('tbl_well_site_master ws','ws.id=sd.site_id','left')
                ->join('tbl_role_wise_user_assign_details ad','wm.id=ad.well_id','left')
                ->where(['wm.status'=>1,'ad.status'=>1,'sd.status'=>1])->group_by('wm.id')
                ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")->get()->result_array();
    }
    public function AreaList($id,$company_id,$assets_id)
    {
        if($id!='')
            $this->db->where('a.id',$id);
        if($company_id!='')
            $this->db->where('a.company_id',$company_id);
        if($assets_id!='')
            $this->db->where('a.assets_id',$assets_id);

        return $this->db->select("a.id,a.company_id,a.assets_id,a.area_name,cs.company_name,am.assets_name")
        ->from('tbl_area_master a')
        ->join('tbl_company_setup cs','a.company_id=cs.id','left')
        ->join('tbl_assets_master am','a.assets_id=am.id','left')
        ->where(['a.status'=>1])->get()->result_array();
    }

    public function Area_WiseSite_List($company_id,$assets_id,$area_id)
    {
        if($company_id!='')
            $this->db->where('company_id',$company_id);
        if($assets_id!='')
            $this->db->where('assets_id',$assets_id);
        if($area_id!='')
            $this->db->where('area_id',$area_id);
        return $this->db->select("id,well_site_name,company_id,assets_id,area_id")->from('tbl_well_site_master')->where(['status'=>1])->get()->result_array();
    }

    public function Well_List($company_id,$assets_id,$area_id,$site_id,$user_id,$well_type)
    {
        if($company_id!='')
            $this->db->where('wm.company_id',$company_id);
        if($assets_id!='')
            $this->db->where('wm.assets_id',$assets_id);
        if($area_id!='')
            $this->db->where('wm.area_id',$area_id);
        if($site_id!='')
            $this->db->where('wm.site_id',$site_id);
        if($user_id!='')
            $this->db->where('ad.user_id',$user_id);
        if($well_type!='')
            $this->db->where('wm.well_type',$well_type);
        
        
        return $this->db->select("wm.id,wm.company_id,wm.assets_id,wm.area_id,wm.site_id,wm.well_name")
                         ->from('tbl_well_master wm')
                         ->join('tbl_role_wise_user_assign_details ad','ad.well_id=wm.id','left')
                         ->where(['wm.status'=>1])
                         ->group_by('wm.id')
                         ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")->get()->result_array();
    }

    public function Rolewise_User_List($company_id,$role_type)
    {
        if($company_id!='')
            $this->db->where('company_id',$company_id);
        if($role_type!='')
            $this->db->where('role_type',$role_type);
        
        return $this->db->select("id,company_id,user_full_name,role_type,emp_id")->from('tbl_ongc_member_master')->where(['status'=>1])->get()->result_array();
    }

    public function Equipment_List($company_id)
    {
        if($company_id!='')
            $this->db->where('company_id',$company_id);
        
        return $this->db->select("id,company_id,equipment_name")->from('tbl_equipment_master')->where(['status'=>1])->get()->result_array();
    }

    public function getAccessId()
    {
        return $this->db->select("UUID()")->get()->result_array();
    }

    public function SaveAccess_LogData($data)
    {
        return $this->db->insert('tbl_access_log',$data);
    }

    public function get_install_Well_list()
    {
        return $this->db->select('sd.well_id,wm.well_name,em.equipment_name,sd.imei_no')
        ->from('tbl_site_device_installation sd')
        ->join('tbl_well_master wm','sd.well_id=wm.id','left')
        ->join('tbl_equipment_details ed','sd.well_id=ed.well_id','left')
        ->join('tbl_equipment_master em','ed.eqp_id=em.id','left')
        ->where('sd.status',1)->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")->get()->result_array();
    }


    // ==================== code for installation ==========================

    public function get_Asset_Listforinstall($company_id,$user_id)
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

    public function get_Area_Listforinstall($company_id,$user_id,$assets_id)
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

    public function getSite_Listforinstall($company_id,$user_id,$assets_id,$area_id)
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

    
   
    public function getWell_Listforinstall($company_id,$user_id,$assets_id,$area_id,$site_id)
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
        
        $res = [];

        $res['assign_well'] = $this->db->select("ad.id,ad.company_id,ad.user_id,ad.assets_id,ad.area_id,ad.site_id,ad.well_id,wm.well_name,wm.lat,wm.long")
        ->from('tbl_role_wise_user_assign_details ad')
        ->join('tbl_well_master wm','ad.well_id=wm.id','left')
        ->where(['ad.status'=>1,'ad.role_type'=>3,'wm.device_setup_status'=>0,'wm.well_type'=>1])
        ->group_by('wm.id')
        ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")->get()->result_array();

        $res['shift_well'] = $this->db->select("ad.id,ad.company_id,ad.user_id,ad.assets_id,ad.area_id,ad.site_id,ad.well_id,wm.well_name,wm.lat,wm.long")
        ->from('tbl_role_wise_user_assign_details ad')
        ->join('tbl_site_device_installation si','ad.well_id=si.well_id','left')
        ->join('tbl_well_master wm','ad.well_id=wm.id','left')
        ->where(['ad.status'=>1,'ad.role_type'=>3,'si.device_shifted'=>1])
        ->group_by('wm.id')
        ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")->get()->result_array();

        $Result = array_merge($res['assign_well'], $res['shift_well']);

        return $Result;
    }

    public function get_self_flow_Well_Listforinstall($user_id,$assets_id,$area_id,$site_id,$well_type)
    {
        if($user_id!='')
            $this->db->where('ad.user_id',$user_id);
        if($assets_id!='')
            $this->db->where('wm.assets_id',$assets_id);
        if($area_id!='')
            $this->db->where('wm.area_id',$area_id);
        if($site_id!='')
            $this->db->where('wm.site_id',$site_id);
         if($well_type!='')
            $this->db->where('wm.well_type',$well_type);
        
        return $this->db->select("ad.user_id,ad.assets_id,ad.area_id,ad.site_id,ad.well_id,wm.well_name,wm.lat,wm.long")
        ->from('tbl_role_wise_user_assign_details ad')
        ->join('tbl_well_master wm','ad.well_id=wm.id','left')
        ->where(['ad.status'=>1,'ad.role_type'=>3,'wm.device_setup_status'=>0])
        ->group_by('wm.id')
        ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")->get()->result_array();
        
    }

    public function getDeviceListforinstall($company_id,$user_id)
    {
        if($company_id!='')
            $this->db->where('company_id',$company_id);
        if($user_id!='')
            $this->db->where('user_id',$user_id);

        return $this->db->select("company_id,user_id,device_name,imei_no")->from('tbl_device_allotment_to_installer')->where(['status'=>1,'device_setup_status'=>1])->get()->result_array();
    }

    // ==================== replacement code  =================================

    public function Device_Listfor_Replacement($company_id,$user_id,$assets_id,$area_id,$site_id,$well_id)
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

    public function getArea_List_forreplacement($company_id,$installed_by,$assets_id)
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

    public function getSiteList_forreplacement($company_id,$installed_by,$assets_id,$area_id)
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

    public function getWellList_forreplacement($company_id,$installed_by,$assets_id,$area_id,$site_id)
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

        return $this->db->select("di.company_id,di.installed_by,di.assets_id,di.area_id,di.site_id,di.well_id,wm.well_name,wm.lat,wm.long")
        ->from('tbl_site_device_installation di')
        ->join('tbl_well_master wm','di.well_id=wm.id','left')
        ->where(['di.status'=>1])
        ->order_by("CAST(SUBSTRING_INDEX(well_name, '#', -1) AS UNSIGNED) ASC")->group_by('di.well_id')->get()->result_array();
    }

    // =================== shifting code starts =============================


    public function get_from_WellList_for_shifting_model($company_id)
    {
        if($company_id!='')
            $this->db->where('di.company_id',$company_id);

        return $this->db->select("di.company_id,di.well_id,wm.well_name,di.device_name,di.imei_no,di.sim_no,di.sim_provider,di.network_type,di.date_of_installation")
        ->from('tbl_site_device_installation di')
        ->join('tbl_well_master wm','di.well_id=wm.id','left')
        ->where(['di.status'=>1,'di.device_shifted'=>0])
        ->order_by("CAST(SUBSTRING_INDEX(well_name, '#', -1) AS UNSIGNED) ASC")->group_by('di.well_id')->get()->result_array();
    }

    public function get_to_WellList_for_shifting_model($company_id)
    {
        if($company_id!='')
            $this->db->where('wm.company_id',$company_id);

        return $this->db->select("wm.id, wm.well_name, wm.lat, wm.long, IFNULL(sdi.device_name, NULL) as device_name, IFNULL(sdi.imei_no, NULL) as imei_no,IFNULL(sdi.date_of_installation , NULL) as date_of_installation")
        ->from('tbl_well_master wm')
        ->join('tbl_site_device_installation sdi', 'sdi.well_id = wm.id', 'left')
        ->where(['wm.status' => 1])
        ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
        ->group_by('wm.id')
        ->get()
        ->result_array();
    }

    public function get_well_list_for_report_model($company_id,$user_id)
    {
        if($company_id!='')
            $this->db->where('di.company_id',$company_id);
        if($user_id!='')
            $this->db->where('ad.user_id',$user_id);

        return $this->db->select("di.company_id,di.well_id,wm.well_name")
        ->from('tbl_site_device_installation di')
        ->join('tbl_well_master wm','di.well_id=wm.id','left')
        ->join('tbl_role_wise_user_assign_details ad','ad.well_id=wm.id','left')
        ->where(['di.status'=>1,'wm.status'=>1])
        ->group_by('di.well_id')
        ->order_by("CAST(SUBSTRING_INDEX(well_name, '#', -1) AS UNSIGNED) ASC")->group_by('di.well_id')->get()->result_array();
    }
    

  //==================== compain_raised on well ============

    public function get_well_for_complain_raised($company_id,$user_id)
    {
        if($company_id!='')
            $this->db->where('di.company_id',$company_id);
         if($user_id!='')
            $this->db->where('ad.user_id',$user_id);


        return $this->db->select("di.company_id,di.well_id,wm.well_name,di.device_name,di.imei_no,di.date_of_installation")
        ->from('tbl_site_device_installation di')
        ->join('tbl_role_wise_user_assign_details ad','ad.well_id=di.well_id','left')
        ->join('tbl_well_master wm','di.well_id=wm.id','left')
        ->where(['di.status'=>1,'di.device_shifted'=>0,'ad.status'=>1])
        ->order_by("CAST(SUBSTRING_INDEX(well_name, '#', -1) AS UNSIGNED) ASC")->group_by('di.well_id')->get()->result_array();
    }


     // ==================== code for integartion ==========================

    public function get_Asset_List_data($company_id,$user_id)
    {
        if($company_id!='')
            $this->db->where('ad.company_id',$company_id);
        if($user_id!='')
            $this->db->where('ad.user_id',$user_id);

        return $this->db->select("ad.id,ad.company_id,user_id,ad.assets_id,am.assets_name")
        ->from('tbl_role_wise_user_assign_details ad')
        ->join('tbl_assets_master am','ad.assets_id=am.id','left')
        ->where(['ad.status'=>1,'am.status'=>1])->group_by('ad.assets_id')->get()->result_array();
    }

    public function get_Area_Listdata($company_id,$user_id,$assets_id)
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
        ->where(['ad.status'=>1, 'am.status'=>1])->group_by('ad.area_id')->get()->result_array();
    }

    public function getSite_ListData($company_id,$user_id,$assets_id,$area_id)
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
        ->where(['ad.status'=>1,'wm.status'=>1])->group_by('ad.site_id')->get()->result_array();
    }



    // well type 

    public function getwell_typelistData($company_id)
    {
        if($company_id!='')
            $this->db->where('wt.company_id',$company_id);
         return $this->db->select("wt.id,wt.well_type_name")
        ->from('tbl_well_type wt')
        ->join('tbl_country_master cm','cm.id=wt.company_id','left')
        ->where(['wt.status'=>1])->get()->result_array();
    }

    public function Not_installedTagList($company_id,$component_id)
    {
        
        if($company_id!='')
            $this->db->where('im.company_id',$company_id);

        if($component_id!='')
            $this->db->where('im.component_id',$component_id);

        $result = $this->db->select("im.id,im.company_id,im.component_id,im.tag_number,im.installation_status,cm.component_name")
        ->from('tbl_tags_number_master im')
        ->join('tbl_component_master cm','cm.id=im.component_id','left')
        ->order_by("CAST(SUBSTRING_INDEX(im.tag_number, '#', -1) AS UNSIGNED) ASC")
        ->where(['im.status'=>1,'im.installation_status'=>0])->get()->result_array();

        return $result;
    }

    public function get_install_self_Well_list($company_id)
    {
        if($company_id!= '')
            $this->db->where('sd.company_id',$company_id);

          return $this->db->select('sd.well_id, wm.well_name,wm.well_type,sd.imei_no,sd.device_name,sd.date_time')
            ->from('tbl_site_device_installtion_self_flow sd')
            ->join('tbl_well_master wm', 'sd.well_id = wm.id', 'left')
            ->where('sd.status', 1)
            ->get()
            ->result_array();
    }



   public function get_install_Well_for_removed_list($company_id, $remove_type, $well_id)
    {
        $result = [
            'device' => [],
            'component' => []
        ];

        if ($remove_type == 1 || $remove_type == 3) {
            $this->db->select('sd.well_id, wm.well_name, sd.device_name, sd.imei_no')
                ->from('tbl_site_device_installtion_self_flow sd')
                ->join('tbl_well_master wm', 'sd.well_id = wm.id', 'left')
                ->where('sd.status', 1)
                ->where('sd.well_id', $well_id);
            
            if ($company_id != '') {
                $this->db->where('wm.company_id', $company_id);
            }

            $result['device'] = $this->db->get()->result_array();
        }

        if ($remove_type == 2 || $remove_type == 3) {
            $result['component'] = $this->db->select('ws.well_id, cm.component_name, ws.sensor_no,cm.id as component_id')
                ->from('tbl_well_sensor_tag_installation_log ws')
                ->join('tbl_component_master cm', 'ws.component_id = cm.id', 'left')
                ->where('ws.tag_status', 1)
                ->where('ws.status', 1)
                ->where('ws.well_id', $well_id)
                ->get()
                ->result_array();
        }

        return $result;
    }


}
?>