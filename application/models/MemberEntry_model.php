<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
class MemberEntry_model extends CI_Model
{
    public function __construct() 
    {
        parent::__construct(); 
    }
    
    public function verifY_userLevel($mobile_no)
    {
        return $this->db->select('count(id) as total,user_type')->from('tbl_authentication_master')->where(['unique_userId'=>$mobile_no,'status'=>1])->group_by('user_type')->get()->result_array();
    }


    public function get_AdminData($mobile_no)
    {
        return $this->db->select('id,unique_userId,mobile_no,password,user_type,login_status,login_date_time')
        ->from('tbl_authentication_master')
        ->where(['unique_userId'=>$mobile_no,'status'=>1,'user_type'=>1])->get()->result_array();
    }

    public function getCompanyInfo($mobile_no)
    {
        return $this->db->select('a.id,a.company_id,c.super_admin_id,a.unique_userId,c.company_name,c.email_id,c.contact_no,a.password,a.user_type,a.login_date_time,a.login_status')->from('tbl_company_setup c')->join('tbl_authentication_master a','c.id=a.company_id','left')
        ->where(['c.comp_userId'=>$mobile_no,'c.status'=>1,'user_type'=>2])->get()->result_array();
    }

    public function getinstallationInfo($mobile_no)
    {
        return $this->db->select('a.id,om.company_id,a.user_member_id,a.unique_userId,om.user_full_name,om.email_id,om.contact_no,om.emp_id,om.role_type,GROUP_CONCAT(distinct as.assets_id) as assets_id,GROUP_CONCAT(distinct am.assets_name) as assets_name,GROUP_CONCAT(distinct as.area_id) as area_id,GROUP_CONCAT(distinct amm.area_name) as area_name,GROUP_CONCAT(distinct as.site_id) as site_id,GROUP_CONCAT(distinct wsm.well_site_name) as well_site_name,om.active_status,om.web_functionality,om.mobile_functionality,a.password,a.user_type,a.login_date_time,a.login_status,cs.company_name')->from('tbl_ongc_member_master om')
        ->join('tbl_authentication_master a','om.id=a.user_member_id','left')
        ->join('tbl_role_wise_user_assign_details as','a.user_member_id=as.user_id ','inner')
        ->join('tbl_assets_master am','as.assets_id=am.id','left')
        ->join('tbl_area_master amm','as.area_id=amm.id ','left')
        ->join('tbl_well_site_master wsm','as.site_id=wsm.id ','left')
        ->join('tbl_company_setup cs','as.company_id=cs.id ','left')
        ->where(['om.userId'=>$mobile_no,'as.status'=>1,'a.user_type'=>3])->get()->result_array();
    }

    public function getAreaUserDetails($email_id)
    {
        return $this->db->select('a.id,om.company_id,a.user_member_id,om.user_full_name,om.email_id,om.contact_no,a.password,a.user_type,a.login_date_time,a.login_status')->from('tbl_ongc_member_master om')->join('tbl_authentication_master a','om.id=a.user_member_id','left')
        ->where(['om.email_id'=>$email_id,'om.status'=>1,'a.user_type'=>4])->get()->result_array();
    }

    public function getAssetUser($email_id)
    {
        return $this->db->select('a.id,om.company_id,a.user_member_id,om.user_full_name,om.email_id,om.contact_no,a.password,a.user_type,a.login_date_time,a.login_status')->from('tbl_ongc_member_master om')->join('tbl_authentication_master a','om.id=a.user_member_id','left')
        ->where(['om.email_id'=>$email_id,'om.status'=>1,'a.user_type'=>5])->get()->result_array();
    }

    public function Last_Entry($data,$where)
    {
        return $this->db->update('tbl_authentication_master',$data,$where);
    }

    public function getPassword($user_id)
    {
        return $this->db->select('id,password,user_member_id,unique_userId,user_type')->from('tbl_authentication_master')->where(['id'=>$user_id,'status'=>1])->get()->result_array();
    }

    public function updatePassword($data,$where)
    {
        return $this->db->update('tbl_authentication_master',$data,$where);
    }

    public function getAId()
    {
        return $this->db->select("UUID()")->get()->result_array();
    }

    public function SaveAccessData($access)
    {
        return $this->db->insert('tbl_access_log',$access);
    }
    public function Update_Device_token($data,$where)
    {
        return $this->db->update('tbl_authentication_master',$data,$where);
    }
    public function getDeviceId()
    {
        return $this->db->select("UUID()")->get()->result_array();
    }

    public function Save_Device_TokenData($dataArray)
    {
        return $this->db->insert('tbl_device_token_details',$dataArray);
    }



    public function SaveWrongData($wrongAttempt)
    {
        return $this->db->insert('tbl_wrong_login_attempt',$wrongAttempt);
    }

    public function getWId()
    {
        return $this->db->select("UUID()")->get()->result_array();
    }

    public function getpasswordAttempts($mobile_no)
    {
        $this->db->select('COUNT(id) as attempts');
        $this->db->from('tbl_wrong_login_attempt');
        $this->db->where('unique_user_id', $mobile_no);
        $this->db->where('TIMESTAMPDIFF(MINUTE, c_date, NOW()) <= 30');
        $this->db->where('status', 1);

        $result = $this->db->get()->row_array();

        return $result['attempts'];
    }

    public function get_wrong_attepmt($user_id)
    {
        $this->db->select('COUNT(user_id) as total,user_type');
        $this->db->from('tbl_wrong_changepassword_attempt');
        $this->db->where('user_id', $user_id);
        $this->db->where('TIMESTAMPDIFF(MINUTE, c_date, NOW()) <= 30');
        $this->db->where('status', 1);

        $result = $this->db->get()->row_array();
        return $result['total'];

       
    }

    public function SaveWrong_Data($wrongAttempt)
    {
        return $this->db->insert('tbl_wrong_changepassword_attempt',$wrongAttempt);
    }

    public function getWPId()
    {
        return $this->db->select("UUID()")->get()->result_array();
    }

   

    public function update_session($data,$where)
    {
        return $this->db->update('tbl_session_details',$data,$where);
    }

        
    public function save_session($data)
    {
        return $this->db->insert('tbl_session_details', $data);
    }
    

    public function verify_user($id)
    {
        return $this->db->select('password,unique_userId')
                        ->from('tbl_authentication_master')
                        ->where(['id'=>$id,'status'=>1])
                        ->get()->result_array();
    }


    public function session_exists_or_not($id)
    {
        $res = $this->db->select("count(id) as total")->from('tbl_session_details')->where(['user_id'=>$id,'status'=>1])->get()->result_array();

        if(!empty($res))
        {
            return $res[0]['total'];
        }else{
            return 0;
        }
    }

    public function session_existsOR_not($id)
    {
        return $this->db->select('sessionTocken,unique_id,password')->from('tbl_session_details')->where(['user_id'=>$id,'status'=>1])->get()->result_array();
    }
    
   
    
}
?>