<?php
class WellScheduling_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function wellSchedulingData_save($from_date, $to_date)
	{
	    $from_date_time = date('Y-m-d H:i:s', strtotime($from_date . ' 06:00:00'));
	    $to_date_time = date('Y-m-d H:i:s', strtotime($to_date . ' 06:00:00'));

	    $allWell = $this->db->distinct()->select("ol.well_id")
	    ->from('tbl_well_configuration_old ol')->join('tbl_site_device_installation sd','ol.well_id = sd.well_id','left')->where(['sd.site_id'=>'c1bcb5e4-b394-11ee-a6d4-5cb901ad9cf0'])->get()->result_array();
	    // print_r($allWell);die;

	    if (!empty($allWell)) {
	        foreach ($allWell as $well) {
	            $well_id = $well['well_id'];

	            $result = $this->db->select("*")->from('tbl_well_configuration_old')->where(['well_id' => $well_id, 'status' => 1])->order_by('c_date', 'ASC')->get()->result_array();

	            foreach ($result as $oldData) {
	                $configData = $this->db->select("*")->from('tbl_well_configuration_log')->where(['well_id' => $well_id])->order_by('c_date', 'ASC')->get()->result_array();
	                $ct = count($configData);

	                if ($ct == 0) {
	                    $data = [];
	                    $data['id'] = $this->getID();
	                    $data['company_id'] = $oldData['company_id'];
	                    $data['well_id'] = $oldData['well_id'];
	                    $data['well_type'] = 0;
	                    $data['start_time'] = null;
	                    $data['stop_time'] = null;
	                    $data['running_hours'] = 1440;
	                    $data['assign_date'] = $oldData['assign_date'];
	                    $data['c_by'] = $oldData['c_by'];
	                    $data['c_date'] = $oldData['c_date'];
	                    $data['from_active_date_time'] = (new DateTime($data['c_date']))->modify('+1 day')->setTime(6, 0, 0)->format('Y-m-d H:i:s');
	                    $data['status'] = 1;

	                    // Insert data into tbl_well_configuration table
	                    $this->SaveData($data);

	                    // Corrected variable usage here
	                    $logdata = [];
	                    $logdata['unique_id'] = $data['id'];
	                    $logdata['company_id'] = $oldData['company_id'];
	                    $logdata['well_id'] = $oldData['well_id'];
	                    $logdata['well_type'] = 0;
	                    $logdata['start_time'] = null;
	                    $logdata['stop_time'] = null;
	                    $logdata['schdule_minutes'] = 1440;
	                    $logdata['assign_date'] = $oldData['assign_date'];
	                    $logdata['from_active_date_time'] = $oldData['c_date'];
	                    $logdata['c_by'] = $oldData['c_by'];
	                    $logdata['c_date'] = $oldData['c_date'];
	                    $logdata['apply_datetime'] = (new DateTime($data['c_date']))->modify('+1 day')->setTime(6, 0, 0)->format('Y-m-d H:i:s');
	                    $logdata['status'] = 1;

	                    // Insert logdata into tbl_well_configuration_log table
	                    $this->SaveLogData($logdata);
	                }else{

	                }
	            }
	        }
	    } else {
	        echo "No well data found.";
	    }
	}

	public function getID()
	{
	    return $this->db->select("UUID() as id")->get()->row()->id;
	}

	public function SaveData($dataArray)
	{
	    return $this->db->insert('tbl_well_configuration', $dataArray);
	}

	public function SaveLogData($dataArray)
	{
	    return $this->db->insert('tbl_well_configuration_log', $dataArray);
	}

}
?>