<?php
class Device_Threshold_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getId()
	{
		return $this->db->select("UUID()")->get()->result_array();
	}

	public function verifyImeiExist($well_id,$imei_no)
	{
		if($well_id!='')
			$this->db->where('well_id',$well_id);
		if($imei_no!='')
			$this->db->where('imei_no',$imei_no);
		
		$result = $this->db->select("count(imei_no) as total")->from('tbl_threshold_details')->where(['status'=>1])->get()->result_array();
		if($result!='')
		{
			return $result[0]['total'];
		}else{
			return 0;
		}
	}

	public function verifywellExist($well_id)
	{
		if($well_id!='')
			$this->db->where('well_id',$well_id);
	
		$result = $this->db->select("count(well_id) as total")->from('tbl_threshold_self_flow_details')->where(['status'=>1])->get()->result_array();
		if($result!='')
		{
			return $result[0]['total'];
		}else{
			return 0;
		}
	}

	public function Save_pressure_Threshold_data($data)
	{
		return $this->db->insert('tbl_threshold_self_flow_details',$data);
	}

	public function Save_pressure_Threshold_data_log($data)
	{
		return $this->db->insert('tbl_threshold_self_flow_log',$data);
	}

	public function Update_last_Threshold_self_flowData($data,$where)
	{
		
		return $this->db->update('tbl_threshold_self_flow_details',$data,$where);
	}

	public function Save_DeviceThreshold_data($details)
	{
		return $this->db->insert('tbl_threshold_details',$details);
	}

	public function getTh_LogId()
	{
		return $this->db->select("UUID()")->get()->result_array();
	}

	public function Save_DeviceThreshold_Log_data($details)
	{
		return $this->db->insert('tbl_threshold_log',$details);
	}

	public function Update_last_ThresholdData($data,$where)
	{
		return $this->db->update('tbl_threshold_details',$data,$where);
	}

	public function getWell_list()
	{
		return $this->db->select('sd.well_id,wm.well_name,em.equipment_name,sd.imei_no')
		->from('tbl_site_device_installation sd')
		->join('tbl_well_master wm','sd.well_id=wm.id','left')
		->join('tbl_equipment_details ed','sd.well_id=ed.well_id','left')
		->join('tbl_equipment_master em','ed.eqp_id=em.id','left')
		->where(['sd.status'=>1,'sd.device_shifted'=>0])->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")->get()->result_array();
	}

	public function getWell_WiseImei_list($well_id)
	{
		if($well_id!='')
			$this->db->where('well_id',$well_id);
		return $this->db->select('imei_no')->from('tbl_site_device_installation')->where(['status'=>1,'device_shifted'=>0])->get()->result_array();
	}

	public function getThreshold_LastData_list($well_id,$imei_no)
	{
		if($well_id!='')
			$this->db->where('well_id',$well_id);

		if($imei_no!='')
			$this->db->where('imei_no',$imei_no);

		return $this->db->select('*')->from('tbl_threshold_details')->where('status',1)->get()->result_array();
	}

	public function getThreshold_report($well_id,$from_date,$to_date,$site_id)
	{
		if($well_id!= '')
			$this->db->where('sd.well_id',$well_id);
		if($site_id!= '')
			$this->db->where('sd.site_id',$site_id);
		if($site_id!= '')
			$this->db->where('sd.site_id',$site_id);
		if ($from_date != '' && $to_date != '') {
            $this->db->where('wi.c_date >=', $from_date);
            $this->db->where('wi.c_date <=', $to_date);
        }
		return $this->db->select('wm.well_name,wi.chp_uppar,chp_lower,thp_uppar,thp_lower,tht_uppar,tht_lower,abp_uppar,abp_lower,ws.well_site_name,wi.c_date as threshold_setup_date_time')
		->from('tbl_site_device_installtion_self_flow sd')
		->join('tbl_threshold_self_flow_details wi','sd.well_id=wi.well_id','left')
		->join('tbl_well_master wm','sd.well_id=wm.id','left')
		->join('tbl_well_site_master ws','sd.site_id=ws.id','left')
		->where(['sd.status'=>1])->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")->get()->result_array();
	}
}
?>