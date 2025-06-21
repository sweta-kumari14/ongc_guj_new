<?php
class Company_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function verify_CompanyExist($company_name)
	{
		$res = $this->db->select("count(id) as total")->from('tbl_company_setup')->where(['company_name'=>$company_name,'status'=>1])->get()->result_array();

		if(!empty($res))
		{
			return $res[0]['total'];
		}else{
			return 0;
		}
	}

	public function verify_CompEmailExist($email_id)
	{
		$res = $this->db->select("count(id) as total")->from('tbl_company_setup')->where(['email_id'=>$email_id,'status'=>1])->get()->result_array();

		if(!empty($res))
		{
			return $res[0]['total'];
		}else{
			return 0;
		}
	}

	public function verifyContactExist($contact_no)
	{
		$res = $this->db->select("count(id) as total")->from('tbl_company_setup')->where(['contact_no'=>$contact_no,'status'=>1])->get()->result_array();

		if(!empty($res))
		{
			return $res[0]['total'];
		}else{
			return 0;
		}
	}
	
	public function getCompID()
    {
        return $this->db->select("UUID()")->get()->result_array();
    }

    public function verifyExist_UserId($comp_userId)
	{
		$res = $this->db->select("count(id) as total")->from('tbl_company_setup')->where(['comp_userId'=>$comp_userId,'status'=>1])->get()->result_array();

		if(!empty($res))
		{
			return $res[0]['total'];
		}else{
			return 0;
		}
	}

    public function AddCompanyData($data)
    {
    	return $this->db->insert('tbl_company_setup',$data);
    }

    public function verify_CompanyExist_OrNot($company_name,$id)
	{
		if($company_name!='')
			$this->db->where('company_name',$company_name);
		if($id!='')
			$this->db->where('id !=',$id);
		$res = $this->db->select("count(id) as total")->from('tbl_company_setup')->where(['status'=>1])->get()->result_array();

		if(!empty($res))
		{
			return $res[0]['total'];
		}else{
			return 0;
		}
	}

	public function verifyCompEmailExist_OrNot($email_id,$id)
	{
		if($email_id!='')
			$this->db->where('email_id',$email_id);
		if($id!='')
			$this->db->where('id !=',$id);
		$res = $this->db->select("count(id) as total")->from('tbl_company_setup')->where(['status'=>1])->get()->result_array();

		if(!empty($res))
		{
			return $res[0]['total'];
		}else{
			return 0;
		}
	}

	public function verifyCompContExist_OrNot($contact_no,$id)
	{
		if($contact_no!='')
			$this->db->where('contact_no',$contact_no);
		if($id!='')
			$this->db->where('id !=',$id);
		$res = $this->db->select("count(id) as total")->from('tbl_company_setup')->where(['status'=>1])->get()->result_array();

		if(!empty($res))
		{
			return $res[0]['total'];
		}else{
			return 0;
		}
	}

	public function UpdateCompanyData($data,$where)
    {
    	return $this->db->update('tbl_company_setup',$data,$where);
    }

    // public function CompanyDataList($id)
    // {
    // 	if($id!='')
    // 		$this->db->where('id',$id);
    
    // 	return $this->db->select("c.id,c.company_name,c.email_id,c.contact_no,c.country_code,c.state_code,c.city,c.address,cm.name as country_name,sm.name as state_name,am.password")
    // 	->from('tbl_company_setup c')
    // 	->join('tbl_country_master cm','c.country_code=cm.id','left')
    // 	->join('tbl_state_master sm','c.state_code=sm.id','left')
    // 	->join('tbl_authentication_master am','am.company_id = c.id','left')
    // 	->where(['c.status'=>1,'am.user_type'=>2])->get()->result_array();
    // }

    public function CompanyDataList($id)
    {
    	$logo = base_url().'album/';
    	if($id!='')
    		$this->db->where('c.id',$id);
    
    	return $this->db->select("c.id,c.company_name,c.comp_userId,c.email_id,c.contact_no,CONCAT('$logo',logo) as logo,c.country_code,c.state_code,c.city,c.address,cm.name as country_name,sm.name as state_name,am.password")
    	->from('tbl_company_setup c')
    	->join('tbl_country_master cm','c.country_code=cm.id','left')
    	->join('tbl_state_master sm','c.state_code=sm.id','left')
    	->join('tbl_authentication_master am','am.company_id = c.id','left')
    	->where(['c.status'=>1,'am.user_type'=>2])->get()->result_array();
    }

    public function DeleteCompany($data,$where)
    {
    	return $this->db->update('tbl_company_setup',$data,$where);
    }

    public function getAuth_Id()
    {
    	return $this->db->select("UUID()")->get()->result_array();
    }

    public function SaveAuth_Data($auth)
    {
    	return $this->db->insert('tbl_authentication_master',$auth);
    }

    public function EditOnboardindcompany($data,$where)
    {
    	return $this->db->update('tbl_authentication_master',$data,$where);
    }

}
?>