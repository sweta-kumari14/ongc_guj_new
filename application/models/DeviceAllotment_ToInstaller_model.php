<?php
class DeviceAllotment_ToInstaller_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

   	public function getUser_list($company_id)
   	{
   		if($company_id!="")
   				$this->db->where(['ra.company_id'=>$company_id]);
   		return $this->db->select('ra.id as assign_id,ra.company_id,mm.id,mm.user_full_name,mm.emp_id')->from('tbl_role_wise_user_assign_details ra')
   		->join('tbl_ongc_member_master mm','ra.user_id = mm.id','left')
   		->where(['ra.role_type'=>3,'ra.status'=>1])->group_by('ra.user_id')->get()->result_array();
   	}

   	// public function getAssigndeviceList($user_id,$company_id)
	//    {
	//    		return $this->db->select('id,device_name,imei_no')->from('tbl_device_allotment_to_installer')->where(['status'=>1,'user_id'=>$user_id,'company_id'=>$company_id])->get()->result_array();
	   		
	//    }

	public function get_device_list_for_installer($company_id)
	   {
	   		if($company_id!="")
   				$this->db->where(['company_id'=>$company_id]);
   			return $this->db->select('id,company_id,device_name,imei_no')->from('tbl_device_allotment_to_company')->where(['ins_allot_status'=>0,'status'=>1])->get()->result_array();
	   }

	public function getIns_userId()
    {
        return $this->db->select("UUID()")->get()->result_array();
    }

    public function InstallerAllotment($data)
    {
        return $this->db->insert('tbl_device_allotment_to_installer',$data);
    }

    public function UpdateDevice_Status($dataArray,$where)
    {
        return $this->db->update('tbl_device_allotment_to_company',$dataArray,$where);
    }

}
?>