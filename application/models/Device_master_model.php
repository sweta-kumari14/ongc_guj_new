<?php
class Device_master_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function verify_imeiExist($imei_no)
	{
		$res = $this->db->select("count(id) as total")->from('tbl_device_setup')->where(['imei_no'=>$imei_no,'status'=>1])->get()->result_array();

		if(!empty($res))
		{
			return $res[0]['total'];
		}else{
			return 0;
		}
	}
	
	public function getDevID()
    {
        return $this->db->select("UUID()")->get()->result_array();
    }

    public function AddDevice($data)
    {
    	return $this->db->insert('tbl_device_setup',$data);
    }

    public function verify_ImeitExist_OrNot($imei_no,$id)
	{
		if($imei_no!='')
			$this->db->where('imei_no',$imei_no);
		if($id!='')
			$this->db->where('id !=',$id);
		$res = $this->db->select("count(id) as total")->from('tbl_device_setup')->where(['status'=>1])->get()->result_array();

		if(!empty($res))
		{
			return $res[0]['total'];
		}else{
			return 0;
		}
	}

	public function Update_DeviceData($data,$where)
    {
    	return $this->db->update('tbl_device_setup',$data,$where);
    }

    public function DEviceList($id)
    {
    	if($id!='')
    		$this->db->where('d.id',$id);
    
    	return $this->db->select("d.*,c.company_name")->from('tbl_device_setup d')->join('tbl_company_setup c','d.company_id=c.id','left')->where('d.status',1)->get()->result_array();
    }

    public function Delete_Device($data,$where)
    {
    	return $this->db->update('tbl_device_setup',$data,$where);
    }

    public function SaveCompany_AllotmentData($data)
    {
    	return $this->db->insert('tbl_device_allotment_to_company',$data);
    }

    public function UpdateDevice_status($data,$where)
    {
    	return $this->db->update('tbl_device_setup',$data,$where);
    }

    public function importDevice($mainData)
    {

      return $this->db->insert('tbl_device_setup',$mainData);
    }

}
?>