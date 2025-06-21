<?php
class Device_Installation_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function CheckImei_Exist($imei_no)
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

	public function get_Ins_id()
	{
		return $this->db->select("UUID()")->get()->result_array();
	}

	public function getWCId()
	{
		return $this->db->select("UUID()")->get()->result_array();
	}

	public function Save_InstallationData($data)
	{
		return $this->db->insert('tbl_site_device_installation',$data);
	}
    

    public function Save_well_Configration($data)
    {
    	return $this->db->insert('tbl_well_configuration',$data);
    }

    public function Check_well_Configration($well_id)
    {
    	$res = $this->db->select("count(id) as total")->from('tbl_well_configuration')->where(['well_id'=>$well_id,'status'=>1])->get()->result_array();
		if($res!='')
		{
			return $res[0]['total'];
		}else{
			return 0;
		}
    }

	public function Update_Setup_status($data,$where)
	{
		return $this->db->update('tbl_device_allotment_to_installer',$data,$where);
	}

	public function WellWise_Device_installation_Status($data,$where)
	{
		return $this->db->update('tbl_well_master',$data,$where);
	}

	// ========= 27/04/2023 =============

	public function getEqu_details($well_id)
	{
		$this->db->where('well_id',$well_id);
		$res = $this->db->select("count(id) as total")->from('tbl_equipment_details')->where('status',1)->get()->result_array();
		if($res!='')
		{
			return $res[0]['total'];
		}else{
			return 0;
		}
	}

}
?>