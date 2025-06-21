<?php
class Device_install_data_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function CheckImei_no_Exist($imei_no)
	{
		$res = $this->db->select("count(id) as total")->from('tbl_site_device_installation')->where(['imei_no'=>$imei_no,'status'=>1])->get()->result_array();
		if($res!='')
		{
			return $res[0]['total'];
		}else{
			return 0;
		}
	}

	public function CheckWell_id_Exist($well_id)
	{
		$res = $this->db->select("count(id) as total")->from('tbl_site_device_installation')->where(['well_id'=>$well_id,'device_shifted'=>1])->get()->result_array();
		if($res!='')
		{
			return $res[0]['total'];
		}else{
			return 0;
		}
	}

	public function CheckAllot_WellExist($well_id)
	{
		return $this->db->select("count(id) as total")->from('tbl_shift_reinstall_well_log')->where(['well_id'=>$well_id,'status'=>1,'re_install_status'=>0])->get()->result_array();
	}


	public function Update_WellData($data,$where)
	{
		return $this->db->update('tbl_site_device_installation',$data,$where);
	}

	public function Update_Reinstall_Devicestatus($data,$where)
	{
		return $this->db->update('tbl_shift_reinstall_well_log',$data,$where);
	}

	public function getInstall_id()
	{
		return $this->db->select("UUID()")->get()->result_array();
	}

	public function getWCId()
	{
		return $this->db->select("UUID()")->get()->result_array();
	}
   
   
	public function Add_InstallationData($data)
	{
		return $this->db->insert('tbl_site_device_installation',$data);
	}

	public function Save_details($data)
	{
		return $this->db->insert('tbl_device_reinstall_exist_well_log',$data);
	}

	public function Update_Setupstatus($data,$where)
	{
		return $this->db->update('tbl_device_allotment_to_installer',$data,$where);
	}

	public function WellWiseDevice_installation_Status($data,$where)
	{
		return $this->db->update('tbl_well_master',$data,$where);
	}

	



}
?>