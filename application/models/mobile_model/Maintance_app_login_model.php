<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Maintance_app_login_model extends CI_Model
{
    public function __construct() 
    {
        parent::__construct(); 
    }
    
    public function verifY_user_Level($mobile_no)
    {
        return $this->db->select('count(id) as total,user_type')->from('tbl_authentication_master')->where(['mobile_no'=>$mobile_no,'status'=>1])->group_by('user_type')->get()->result_array();
    }

    public function get_Installtion_Data($mobile_no)
    {
        return $this->db->select('a.id,om.company_id,a.user_member_id,a.unique_userId,om.user_full_name,om.email_id,om.contact_no,om.role_type,GROUP_CONCAT(distinct as.assets_id) as assets_id,GROUP_CONCAT(distinct am.assets_name) as assets_name,GROUP_CONCAT(distinct as.area_id) as area_id,GROUP_CONCAT(distinct amm.area_name) as area_name,GROUP_CONCAT(distinct as.site_id) as site_id,GROUP_CONCAT(distinct wsm.well_site_name) as well_site_name,om.active_status,om.web_functionality,om.mobile_functionality,a.password,a.user_type,a.login_date_time,a.login_status,cs.company_name')->from('tbl_ongc_member_master om')
        ->join('tbl_authentication_master a','om.id=a.user_member_id','left')
        ->join('tbl_role_wise_user_assign_details as','a.user_member_id=as.user_id ','inner')
        ->join('tbl_assets_master am','as.assets_id=am.id','left')
        ->join('tbl_area_master amm','as.area_id=amm.id ','left')
        ->join('tbl_well_site_master wsm','as.site_id=wsm.id ','left')
        ->join('tbl_company_setup cs','as.company_id=cs.id ','left')
        ->where(['a.mobile_no'=>$mobile_no,'as.status'=>1,'a.user_type'=>3])->get()->result_array();
    }

    public function Last_Entry($data,$where)
    {
        return $this->db->update('tbl_authentication_master',$data,$where);
    }


}
?>
