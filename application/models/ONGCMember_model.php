<?php
class ONGCMember_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function verifyEmail_Exist($email_id)
	{
		$res = $this->db->select("count(id) as total")->from('tbl_ongc_member_master')->where(['email_id'=>$email_id,'status'=>1])->get()->result_array();

		if(!empty($res))
		{
			return $res[0]['total'];
		}else{
			return 0;
		}
	}

	public function verifyMobile_Exist($contact_no)
	{
		$res = $this->db->select("count(id) as total")->from('tbl_ongc_member_master')->where(['contact_no'=>$contact_no,'status'=>1])->get()->result_array();

		if(!empty($res))
		{
			return $res[0]['total'];
		}else{
			return 0;
		}
	}

	public function verifyEmp_Id_Exist($emp_id)
	{
		$res = $this->db->select("count(id) as total")->from('tbl_ongc_member_master')->where(['emp_id'=>$emp_id,'status'=>1])->get()->result_array();

		if(!empty($res))
		{
			return $res[0]['total'];
		}else{
			return 0;
		}
	}

	public function getUserID()
    {
        return $this->db->select("UUID()")->get()->result_array();
    }

    public function verifyUserId($userId)
	{
		$res = $this->db->select("count(id) as total")->from('tbl_ongc_member_master')->where(['userId'=>$userId,'status'=>1])->get()->result_array();

		if(!empty($res))
		{
			return $res[0]['total'];
		}else{
			return 0;
		}
	}

    public function Add_UserData($data)
    {
    	return $this->db->insert('tbl_ongc_member_master',$data);
    }

	public function verifyEmailExist_OrNot($email_id,$id)
	{
		if($email_id!='')
			$this->db->where('email_id',$email_id);
		if($id!='')
			$this->db->where('id !=',$id);
		$res = $this->db->select("count(id) as total")->from('tbl_ongc_member_master')->where(['status'=>1])->get()->result_array();

		if(!empty($res))
		{
			return $res[0]['total'];
		}else{
			return 0;
		}
	}

	public function verifyMobileExist_OrNot($contact_no,$id)
	{
		if($contact_no!='')
			$this->db->where('contact_no',$contact_no);
		if($id!='')
			$this->db->where('id !=',$id);
		$res = $this->db->select("count(id) as total")->from('tbl_ongc_member_master')->where(['status'=>1])->get()->result_array();

		if(!empty($res))
		{
			return $res[0]['total'];
		}else{
			return 0;
		}
	}


	public function verifyEmpExist_OrNot($emp_id,$id)
	{
		if($emp_id!='')
			$this->db->where('emp_id',$emp_id);
		if($id!='')
			$this->db->where('id !=',$id);
		$res = $this->db->select("count(id) as total")->from('tbl_ongc_member_master')->where(['status'=>1])->get()->result_array();

		if(!empty($res))
		{
			return $res[0]['total'];
		}else{
			return 0;
		}
	}

	public function Update_UserData($data,$where)
    {
    	return $this->db->update('tbl_ongc_member_master',$data,$where);
    }

    public function Member_List($id,$company_id)
    {
    	if($id!='')
    		$this->db->where('u.id',$id);
    	if($company_id!='')
    		$this->db->where('u.company_id',$company_id);
    	
    	return $this->db->select("u.id,u.company_id,cs.company_name,u.user_full_name,u.email_id,u.userId,u.contact_no,u.address,u.city,u.active_status,u.web_functionality,u.mobile_functionality,u.country_code,c.name as country_name,u.state_code,s.name as state_name,u.role_type,a.password,u.emp_id")
    	->from('tbl_ongc_member_master u')
    	->join('tbl_company_setup cs','u.company_id=cs.id','left')
    	->join('tbl_country_master c','u.country_code=c.id','left')
    	->join('tbl_state_master s','u.state_code=s.id','left')
    	->join('tbl_authentication_master a','u.id=a.user_member_id','left')
    	->where(['u.status'=>1])->order_by("CAST(SUBSTRING_INDEX(u.userId, '-', -1) AS UNSIGNED) ASC")->get()->result_array();
    }

    public function Delete_UserData($data,$where)
    {
    	return $this->db->update('tbl_ongc_member_master',$data,$where);
    }

    public function getAuthID()
    {
        return $this->db->select("UUID()")->get()->result_array();
    }

    public function SaveOnboardindUser($onboarding)
    {
    	return $this->db->insert('tbl_authentication_master',$onboarding);
    }

    public function UpdateOnboardindUser($data,$where)
    {
    	return $this->db->update('tbl_authentication_master',$data,$where);
    }

    public function DeleteOnboardindUser($data,$where)
    {
    	return $this->db->update('tbl_authentication_master',$data,$where);
    }

    

}
?>