<?php
class Device_configration_setup_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}   

    public function device_installList($company_id)
	{
	    if ($company_id != '')
	        $this->db->where('sd.company_id', $company_id);

	   
	    return $this->db->select('
	                sd.device_name,
	                sd.imei_no,
	                COUNT(sd.well_id) AS no_of_wells,
	                IFNULL(dm.node_scan_time, 0) AS node_scan_time,
	                IFNULL(dm.node_log_time, 0) AS node_log_time,
	                IFNULL(dm.gateway_log_time, 0) AS gateway_log_time
	            ')
	            ->from('tbl_site_device_installtion_self_flow sd')
	            ->join('tbl_device_setup dm', 'dm.imei_no = sd.imei_no', 'left')
	            ->where(['sd.well_setup_status'=>1])
	            ->group_by('sd.imei_no')
	            ->get()
	            ->result_array();
	}

	public function get_well_details_for_configration($company_id,$imei_no)
	{
		 if ($company_id != '')
	        $this->db->where('sd.company_id', $company_id);
	     if ($imei_no != '')
	        $this->db->where('sd.imei_no', $imei_no);

	   
	    return $this->db->select('
	                sd.well_id,wm.well_name,
	                sd.no_of_installed_sensor,
	                sd.imei_no
	            ')
	            ->from('tbl_site_device_installtion_self_flow sd')
	            ->join('tbl_well_master wm', 'wm.id = sd.well_id', 'left')
	            ->where(['sd.well_setup_status'=>1])
	            ->group_by('sd.well_id')
	            ->get()
	            ->result_array();
	}

	
	public function get_well_details_threshold($company_id, $well_id)
	{
	    if ($company_id != '')
	        $this->db->where('sd.company_id', $company_id);
	    if ($well_id != '')
	        $this->db->where('sd.well_id', $well_id);

	    $query = $this->db->select('
	    	        tm.id,
	                sd.well_id,
	                sd.area_id,
	                sd.site_id,
	                wm.well_name,
	                sd.no_of_installed_sensor,
	                tm.component_id,
	                tm.tag_no,
	                tn.tag_number,
	                cm.component_name,
	                tm.max_value,
	                tm.lower_value,
	                tm.upper_value,
	                tm.offset,
	                tm.multiplier
	            ')
	            ->from('tbl_site_device_installtion_self_flow sd')
	            ->join('tbl_well_master wm', 'wm.id = sd.well_id', 'left')
	            ->join('tbl_well_threshold_setup_master tm', 'tm.well_id = sd.well_id', 'left')
	            ->join('tbl_component_master cm', 'cm.id = tm.component_id', 'left')
	            ->join('tbl_tags_number_master tn', 'tn.id = tm.tag_no', 'left')
	            ->where(['tm.status'=>1,'sd.well_setup_status'=>1])
	            ->group_by('tm.component_id, sd.well_id')
	            ->get()
	            ->result_array();

	    if (empty($query)) {
	        return [];
	    }
	    $wellDetails = [
	    	'well_id' => $query[0]['well_id'],
	        'area_id' => $query[0]['area_id'],
	        'site_id' => $query[0]['site_id'],
	        'well_name' => $query[0]['well_name'],
	        'no_of_installed_sensor' => $query[0]['no_of_installed_sensor'],
	    ];
	    $thresholds = [];
	    foreach ($query as $row) {
	        if ($row['component_id'] !== null) {
	            $thresholds[] = [
                    'id'=>$row['id'],
	                'component_id'   => $row['component_id'],
	                'component_name' => $row['component_name'],
	                'tag_no'         =>$row['tag_no'],
	                'tag_number'     => $row['tag_number'],
	                'max_value'      => $row['max_value'],
	                'lower_value'    => $row['lower_value'],
	                'upper_value'    => $row['upper_value'],
	                'offset'         => $row['offset'],
	                'multiplier'     => $row['multiplier']
	            ];
	        }
	    }

	    return [
	        'well_details' => $wellDetails,
	        'thresholds'   => $thresholds
	    ];
	}


	public function get_well_details_for_preview_jason($company_id, $well_id, $imei_no)
	{
	    if ($company_id != '')
	        $this->db->where('sd.company_id', $company_id);
	    if ($well_id != '')
	        $this->db->where('sd.well_id', $well_id);

	    $result = $this->db->select('
	    	        tm.id,
	                sd.well_id,
	                sd.area_id,
	                sd.site_id,
	                wm.well_name,
	                sd.no_of_installed_sensor,
	                tm.component_id,
	                tm.tag_no,
	                tn.tag_number,
	                cm.component_name,
	                tm.max_value,
	                tm.lower_value,
	                tm.upper_value,
	                tm.offset,
	                tm.multiplier
	            ')
	            ->from('tbl_site_device_installtion_self_flow sd')
	            ->join('tbl_well_master wm', 'wm.id = sd.well_id', 'left')
	            ->join('tbl_well_threshold_setup_master tm', 'tm.well_id = sd.well_id', 'left')
	            ->join('tbl_component_master cm', 'cm.id = tm.component_id', 'left')
	            ->join('tbl_tags_number_master tn', 'tn.id = tm.tag_no', 'left')
	            ->where('sd.imei_no', $imei_no)
	            ->where(['tm.status'=>1,'sd.well_setup_status'=>1])
	            ->order_by('sd.well_id, tm.component_id')
	            ->get()
	            ->result_array();

	    if (empty($result)) {
	        return [];
	    }

	    $response = [];
	    foreach ($result as $row) {
	        $wid = $row['well_id'];

	        if (!isset($response[$wid])) {
	            $response[$wid] = [
	                'well_id' => $row['well_id'],
	                'area_id' => $row['area_id'],
	                'site_id' => $row['site_id'],
	                'well_name' => $row['well_name'],
	                'no_of_installed_sensor' => $row['no_of_installed_sensor'],
	                'thresholds' => []
	            ];
	        }

	        if ($row['component_id'] !== null) {
	            $response[$wid]['thresholds'][] = [
	            	'id'   => $row['id'],
	                'component_id'   => $row['component_id'],
	                'component_name' => $row['component_name'],
	                'tag_no'         => $row['tag_no'],
	                'tag_number'     => $row['tag_number'],
	                'max_value'      => $row['max_value'],
	                'lower_value'    => $row['lower_value'],
	                'upper_value'    => $row['upper_value'],
	                'offset'         => $row['offset'],
	                'multiplier'     => $row['multiplier']
	            ];
	        }
	    }

	    return array_values($response); 
	}
	public function Update_Threshold_data($data,$where)
	{
		return $this->db->update('tbl_well_threshold_setup_master',$data,$where);
	}

	public function Save_pressure_Threshold_data_log($data)
	{
		return $this->db->insert('tbl_well_threshold_setup_log',$data);
	}

	public function verify_ImeitExist_OrNot($imei_no)
	{
			if($imei_no!='')
				$this->db->where('imei_no',$imei_no);
			
			$res = $this->db->select("count(id) as total")->from('tbl_device_setup')->where(['status'=>1,])->get()->result_array();

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

    public function Insert_DeviceData($data)
    {
    		return $this->db->insert('tbl_device_sval_setup_log',$data);
    }

}
?>