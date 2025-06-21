<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Installer_login_model extends CI_Model
{
    public function __construct() 
    {
        parent::__construct(); 
    }
    
    public function verifY_Installer($mobile_no)
    {
        return $this->db->select('count(id) as total')->from('tbl_authentication_master')->where(['mobile_no'=>$mobile_no,'status'=>1,'user_type'=>3])->get()->result_array();
    }

     public function getinstallationInfo($mobile_no)
    {
        return $this->db->select('a.id,as.company_id,a.user_member_id,om.user_full_name,a.email_id,a.mobile_no,om.emp_id,om.role_type,GROUP_CONCAT(as.assets_id) as assign_id,GROUP_CONCAT(am.assets_name) as assets_name,GROUP_CONCAT(as.area_id) as area_id,GROUP_CONCAT(amm.area_name) as area_name,GROUP_CONCAT(as.site_id) as site_id,GROUP_CONCAT(wsm.well_site_name) as site_name,GROUP_CONCAT(as.well_id) as well_id,GROUP_CONCAT(wm.well_name) as well_name,om.active_status,om.mobile_functionality,a.password,a.user_type,a.login_date_time,a.login_status,cm.company_name')->from('tbl_authentication_master a')
        ->join('tbl_role_wise_user_assign_details as','a.user_member_id=as.user_id ','left')
        ->join('tbl_ongc_member_master om','om.id=a.user_member_id','left')
        ->join('tbl_assets_master am','as.assets_id=am.id','left')
        ->join('tbl_area_master amm','as.area_id=amm.id ','left')
        ->join('tbl_well_site_master wsm','as.site_id=wsm.id ','left')
        ->join('tbl_well_master wm','as.well_id=wm.id ','left')
        ->join('tbl_company_setup cm','as.company_id=cm.id ','left')
        ->where(['a.mobile_no'=>$mobile_no,'as.status'=>1,'a.user_type'=>3])->get()->result_array();
    }

    public function InstallerLast_Entry($data,$where)
    {
        return $this->db->update('tbl_authentication_master',$data,$where);
    }
}
?>