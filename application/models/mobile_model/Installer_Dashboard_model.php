<?php
class Installer_Dashboard_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_TotalSite($company_id,$user_id)
	{
		$this->db->where('company_id',$company_id);
		$this->db->where('user_id',$user_id);
		$res = $this->db->select("count(distinct site_id) as total")->from('tbl_role_wise_user_assign_details')->where(['status'=>1,'role_type'=>3])->get()->result_array();
		if($res!='')
		{
			return $res[0]['total'];
		}else{
			return 0;
		}
	}

	public function get_TotalWell($company_id,$user_id)
	{
		$this->db->where('company_id',$company_id);
		$this->db->where('user_id',$user_id);

		$res = $this->db->select("count(distinct well_id) as total")->from('tbl_role_wise_user_assign_details')->where(['status'=>1,'role_type'=>3])->get()->result_array();
		if($res!='')
		{
			return $res[0]['total'];
		}else{
			return 0;
		}
	}

	public function get_TotalAlloted_Device($company_id,$user_id)
	{
		$this->db->where('company_id',$company_id);
		$this->db->where('user_id',$user_id);

		$res = $this->db->select("count(distinct imei_no) as total")->from('tbl_device_allotment_to_installer')->where(['status'=>1])->get()->result_array();
		if($res!='')
		{
			return $res[0]['total'];
		}else{
			return 0;
		}
	}

	public function get_TotalInstalled_Device($company_id,$user_id)
	{
		$this->db->where('company_id',$company_id);
		$this->db->where('user_id',$user_id);

		$res = $this->db->select("count(distinct imei_no) as total")->from('tbl_device_allotment_to_installer')->where(['status'=>1,'device_setup_status'=>2])->get()->result_array();
		if($res!='')
		{
			return $res[0]['total'];
		}else{
			return 0;
		}
	}


}
?>