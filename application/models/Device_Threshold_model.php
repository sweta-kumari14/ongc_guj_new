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

	
		public function verifywllExist($well_id,$node_name)
	{
		if($well_id!='')
			$this->db->where('well_id',$well_id);

		if($node_name!='')
			$this->db->where('node_name',$node_name);
	
		$result = $this->db->select("count(well_id) as total")
				->from('tbl_well_threshold_setup_master')
				->where(['status'=>1])->get()->result_array();
		if($result!='')
		{
			return $result[0]['total'];
		}else{
			return 0;
		}
	}

	public function verifywll_NotExist_record($well_id,$node_name)
	{
		if($well_id!='')
			$this->db->where('well_id',$well_id);

		if($node_name!='')
			$this->db->where('node_name',$node_name);
	
		$result = $this->db->select("count(well_id) as total")
				->from('tbl_well_threshold_setup_master')
				->where(['status'=>0])->get()->result_array();
		if($result!='')
		{
			return $result[0]['total'];
		}else{
			return 0;
		}
	}

	public function Save_pressure_Threshold_data($data)
	{
		return $this->db->insert('tbl_well_threshold_setup_master',$data);
	}

	public function Save_pressure_Threshold_data_log($data)
	{
		return $this->db->insert('tbl_well_threshold_setup_log',$data);
	}

	public function Update_last_Threshold_self_flowData($data,$where)
	{
		
		return $this->db->update('tbl_well_threshold_setup_master',$data,$where);
	}

	public function delete_existNodeType($well_id,$node_name)
	{
		if (!empty($well_id)) {
	        $this->db->where('well_id',$well_id);
	        $this->db->where('node_name',$node_name);
	        $this->db->delete('tbl_well_threshold_setup_master');
	    }
	}

	public function getwell_lastThreshold_list($well_id,$node_type,$tagNo)
	{
		if($well_id!='')
			$this->db->where('well_id',$well_id);

		if($node_type!='')
			$this->db->where('node_name',$node_type);

		if($tagNo!='')
			$this->db->where('tag_no',$tagNo);

		return $this->db->select('*')->from('tbl_well_threshold_setup_master')->where('status',1)->get()->result_array();
	}

	public function get_existing_threshold($tagNo,$well_id)
	{
		$this->db->where('tag_no',$tagNo);
		$this->db->where('well_id',$well_id);
		return $this->db->select("*")->from('tbl_well_threshold_setup_master')->where(['status'=>1])->get()->row_array();
	}

	public function getwellThreshold_setup_report($area_id,$site_id,$well_id,$from_date,$to_date)
	{

		if($area_id!= '')
			$this->db->where('sl.area_id',$area_id);

		if($site_id!= '')
			$this->db->where('sl.site_id',$site_id);

		if($well_id!= '')
			$this->db->where('sl.well_id',$well_id);

		 if ($from_date != '' && $to_date != '') {
	        $this->db->where("date(sl.c_date) BETWEEN '{$from_date}' AND '{$to_date}'");
	    }

		return $this->db->select('sl.area_id,am.area_name,sl.site_id,ws.well_site_name,wm.well_name,sl.tag_no,tg.tag_number,sl.node_name,sl.max_value,sl.upper_value,sl.lower_value,sl.multiplier,sl.offset,sl.c_date as threshold_setup_date_time')

		->from('tbl_well_threshold_setup_master sl')
		->join('tbl_well_master wm','sl.well_id=wm.id','left')
		->join('tbl_well_site_master ws','sl.site_id=ws.id','left')
		->join('tbl_area_master am','sl.area_id=am.id','left')
		->join('tbl_tags_number_master tg','sl.tag_no=tg.id','left')
		->where(['sl.status'=>1])->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")->get()->result_array();
	}
}
?>