<?php
date_default_timezone_set('Asia/Kolkata');
class Web_Single_dashboardData_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function Single_Well_DeviceData($well_id,$imei_no)
    {
        
        if($well_id!='')
            $this->db->where('well_id',$well_id);
        if($imei_no!='')
            $this->db->where('imei_no',$imei_no);

        return $this->db->select("id,company_id,installed_by,assets_id,area_id,site_id,well_id,device_name,imei_no,device_last_status,output_Voltage_L2N_R,output_Voltage_L2N_Y,output_Voltage_L2N_B,output_Average_Voltage_L2N,output_Voltage_P2P_RY,output_Voltage_P2P_YB,output_Voltage_P2P_BR,output_Average_Voltage_P2P,output_Current_R,output_Current_Y,output_Current_B,output_Average_Current,output_System_PowerFactor1,output_System_Frequency,output_System_Running_KW,battery_Voltage,smps_Voltage,offline_device_timestamp,last_log_datetime,offline_device_timestamp as last_date_time,device_shifted,date_of_shifted,olr_status,elr_status,spp_status,predicated_energy_consumption,predicated_running_hours,flag_status")
        ->from('tbl_site_device_installation')
        ->where('status',1)->group_by('imei_no')->get()->result_array();
       
    }

   
    public function WellAlert_Details($well_id,$imei_no)
    {
        
        if($well_id!='')
            $this->db->where('sd.well_id',$well_id);
        if($imei_no!='')
            $this->db->where('sd.imei_no',$imei_no);

        if (date('H') < 6){
        
            $from_date = date('Y-m-d', strtotime('-1 day')) . ' 06:00:00';
            $to_date = date('Y-m-d') . ' 06:00:00';
        }else{
            $from_date = date('Y-m-d') . ' 06:00:00';
            $to_date = date('Y-m-d', strtotime('+1 day')) . ' 06:00:00';
        }

        return $this->db->select("sd.id,sd.well_id,tl.imei_no,sd.device_name,tl.alert_type,tl.alerts_details,tl.start_date_time as trip_datetime, tl.end_date_time as trip_end_datetime")
        ->from('tbl_alert_log tl')
        ->join('tbl_site_device_installation sd','sd.imei_no=tl.imei_no','left')
        ->where(['sd.status'=>1,'tl.c_date >='=> $from_date,'tl.c_date <'=> $to_date])->get()->result_array();
       
    }
    public function Well_WiseTotal_Alert($well_id,$imei_no)
    {
        
        if($well_id!='')
            $this->db->where('sd.well_id',$well_id);
        if($imei_no!='')
            $this->db->where('sd.imei_no',$imei_no);

        if (date('H') < 6){
        
            $from_date = date('Y-m-d', strtotime('-1 day')) . ' 06:00:00';
            $to_date = date('Y-m-d') . ' 06:00:00';
        }else{
            $from_date = date('Y-m-d') . ' 06:00:00';
            $to_date = date('Y-m-d', strtotime('+1 day')) . ' 06:00:00';
        }

        $res = $this->db->select("count(tl.imei_no) as total")
        ->from('tbl_site_device_installation sd')
        ->join('tbl_alert_log tl','sd.imei_no=tl.imei_no and tl.status=1','left')
        ->where(['sd.status'=>1,'tl.c_date >='=> $from_date,'tl.c_date <'=> $to_date])->get()->result_array();
        if($res!='')
        {
            return $res[0]['total'];
        }else{
            return 0;
        }
       
    }

    // public function OutPut_Neutral_Voltage($wellId, $imeiNo, $hours)
    // {
    //     $conditions = [];
    //     if (!empty($wellId)) {
    //         $conditions['well_id'] = $wellId;
    //     }
    //     if (!empty($imeiNo)) {
    //         $conditions['imei_no'] = $imeiNo;
    //     }

    //     $currentTime = date('Y-m-d H:i:s');
    //     $queryStartTime = date('Y-m-d H:i:s', strtotime("-{$hours} hours"));

    //     // Always fetch recent data from tbl_device_log within the desired time frame
    //     $deviceLogData1 = $this->db->select("last_log_datetime AS x, output_Voltage_L2N_R AS y")
    //         ->from('tbl_device_log')
    //         ->where('last_log_datetime >=', $queryStartTime)
    //         ->where($conditions)
    //         ->order_by('last_log_datetime', 'ASC')
    //         ->get()
    //         ->result_array();

    //     $deviceLogData2 = $this->db->select("last_log_datetime AS x, output_Voltage_L2N_Y AS y")
    //         ->from('tbl_device_log')
    //         ->where('last_log_datetime >=', $queryStartTime)
    //         ->where($conditions)
    //         ->order_by('last_log_datetime', 'ASC')
    //         ->get()
    //         ->result_array();

    //     $deviceLogData3 = $this->db->select("last_log_datetime AS x, output_Voltage_L2N_B AS y")
    //         ->from('tbl_device_log')
    //         ->where('last_log_datetime >=', $queryStartTime)
    //         ->where($conditions)
    //         ->order_by('last_log_datetime', 'ASC')
    //         ->get()
    //         ->result_array();

    //     $deviceLogData4 = $this->db->select("last_log_datetime AS x, output_Average_Voltage_L2N AS y")
    //         ->from('tbl_device_log')
    //         ->where('last_log_datetime >=', $queryStartTime)
    //         ->where($conditions)
    //         ->order_by('last_log_datetime', 'ASC')
    //         ->get()
    //         ->result_array();

    //     if ($hours > 1) {
    //         // Fetch historical data for the additional time if needed
    //         $historicalData1 = $this->db->select("last_log_datetime AS x, output_Voltage_L2N_R AS y")
    //             ->from('tbl_historical_device_log')
    //             ->where('last_log_datetime >=', $queryStartTime)
    //             ->where($conditions)
    //             ->order_by('last_log_datetime', 'ASC')
    //             ->get()
    //             ->result_array();

    //         // Merge historical data with device log data
    //         $deviceLogData1 = array_merge($historicalData1, $deviceLogData1);

    //         // ====================================================================
    //         $historicalData2 = $this->db->select("last_log_datetime AS x, output_Voltage_L2N_Y AS y")
    //             ->from('tbl_historical_device_log')
    //             ->where('last_log_datetime >=', $queryStartTime)
    //             ->where($conditions)
    //             ->order_by('last_log_datetime', 'ASC')
    //             ->get()
    //             ->result_array();

    //         // Merge historical data with device log data
    //         $deviceLogData2 = array_merge($historicalData2, $deviceLogData2);

    //         // =======================================================

    //         $historicalData3 = $this->db->select("last_log_datetime AS x, output_Voltage_L2N_B AS y")
    //             ->from('tbl_historical_device_log')
    //             ->where('last_log_datetime >=', $queryStartTime)
    //             ->where($conditions)
    //             ->order_by('last_log_datetime', 'ASC')
    //             ->get()
    //             ->result_array();

    //         // Merge historical data with device log data
    //         $deviceLogData3 = array_merge($historicalData3, $deviceLogData3);

    //          // =======================================================

    //         $historicalData4 = $this->db->select("last_log_datetime AS x, output_Average_Voltage_L2N AS y")
    //             ->from('tbl_historical_device_log')
    //             ->where('last_log_datetime >=', $queryStartTime)
    //             ->where($conditions)
    //             ->order_by('last_log_datetime', 'ASC')
    //             ->get()
    //             ->result_array();

    //         // Merge historical data with device log data
    //         $deviceLogData4 = array_merge($historicalData4, $deviceLogData4);
    //     }

    //     // Prepare the result
    //     $result = [
    //         'output_n_R' => $deviceLogData1,
    //         'output_n_Y' => $deviceLogData2,
    //         'output_n_B' => $deviceLogData3,
    //         'output_n_Avg' => $deviceLogData4,
    //     ];

    //     return $result;
    // }
    public function OutPut_Neutral_Voltage($wellId, $imeiNo, $hours)
    {
        $conditions = [];
        if (!empty($wellId)) {
            $conditions['well_id'] = $wellId;
        }
        if (!empty($imeiNo)) {
            $conditions['imei_no'] = $imeiNo;
        }

        $currentTime = date('Y-m-d H:i:s');
        $queryStartTime = date('Y-m-d H:i:s', strtotime("-{$hours} hours"));

        $deviceLogData1 = $this->fetchData('tbl_device_log', 'output_Voltage_L2N_R', $queryStartTime, $conditions);
        $deviceLogData2 = $this->fetchData('tbl_device_log', 'output_Voltage_L2N_Y', $queryStartTime, $conditions);
        $deviceLogData3 = $this->fetchData('tbl_device_log', 'output_Voltage_L2N_B', $queryStartTime, $conditions);
        $deviceLogData4 = $this->fetchData('tbl_device_log', 'output_Average_Voltage_L2N', $queryStartTime, $conditions);

        if ($hours > 1) {
            $historicalData1 = $this->fetchData('tbl_historical_device_log', 'output_Voltage_L2N_R', $queryStartTime, $conditions);
            $historicalData2 = $this->fetchData('tbl_historical_device_log', 'output_Voltage_L2N_Y', $queryStartTime, $conditions);
            $historicalData3 = $this->fetchData('tbl_historical_device_log', 'output_Voltage_L2N_B', $queryStartTime, $conditions);
            $historicalData4 = $this->fetchData('tbl_historical_device_log', 'output_Average_Voltage_L2N', $queryStartTime, $conditions);

            $deviceLogData1 = array_merge($historicalData1, $deviceLogData1);
            $deviceLogData2 = array_merge($historicalData2, $deviceLogData2);
            $deviceLogData3 = array_merge($historicalData3, $deviceLogData3);
            $deviceLogData4 = array_merge($historicalData4, $deviceLogData4);
           
        }

         // Fill in missing data points with 0 values
        $deviceLogData1 = $this->fillMissingData($deviceLogData1);
        $deviceLogData2 = $this->fillMissingData($deviceLogData2);
        $deviceLogData3 = $this->fillMissingData($deviceLogData3);
        $deviceLogData4 = $this->fillMissingData($deviceLogData4);
        
        $result = [
            'output_n_R' => $deviceLogData1,
            'output_n_Y' => $deviceLogData2,
            'output_n_B' => $deviceLogData3,
            'output_n_Avg' => $deviceLogData4,
        ];

        return $result;
    }

    // public function OutputLine_to_Line_Voltage($wellId, $imeiNo, $hours)
    // {
    //     $conditions = [];
    //     if (!empty($wellId)) {
    //         $conditions['well_id'] = $wellId;
    //     }
    //     if (!empty($imeiNo)) {
    //         $conditions['imei_no'] = $imeiNo;
    //     }

    //     $currentTime = date('Y-m-d H:i:s');
    //     $queryStartTime = date('Y-m-d H:i:s', strtotime("-{$hours} hours"));

      
    //     $deviceLogData1 = $this->db->select("last_log_datetime AS x, output_Voltage_P2P_RY AS y")
    //         ->from('tbl_device_log')
    //         ->where('last_log_datetime >=', $queryStartTime)
    //         ->where($conditions)
    //         ->order_by('last_log_datetime', 'ASC')
    //         ->get()
    //         ->result_array();

    //     $deviceLogData2 = $this->db->select("last_log_datetime AS x, output_Voltage_P2P_YB AS y")
    //         ->from('tbl_device_log')
    //         ->where('last_log_datetime >=', $queryStartTime)
    //         ->where($conditions)
    //         ->order_by('last_log_datetime', 'ASC')
    //         ->get()
    //         ->result_array();

    //     $deviceLogData3 = $this->db->select("last_log_datetime AS x, output_Voltage_P2P_BR AS y")
    //         ->from('tbl_device_log')
    //         ->where('last_log_datetime >=', $queryStartTime)
    //         ->where($conditions)
    //         ->order_by('last_log_datetime', 'ASC')
    //         ->get()
    //         ->result_array();

    //     $deviceLogData4 = $this->db->select("last_log_datetime AS x, output_Average_Voltage_P2P AS y")
    //         ->from('tbl_device_log')
    //         ->where('last_log_datetime >=', $queryStartTime)
    //         ->where($conditions)
    //         ->order_by('last_log_datetime', 'ASC')
    //         ->get()
    //         ->result_array();

    //     if ($hours > 1) {
         
    //         $historicalData1 = $this->db->select("last_log_datetime AS x, output_Voltage_P2P_RY AS y")
    //             ->from('tbl_historical_device_log')
    //             ->where('last_log_datetime >=', $queryStartTime)
    //             ->where($conditions)
    //             ->order_by('last_log_datetime', 'ASC')
    //             ->get()
    //             ->result_array();

    //         // Merge historical data with device log data
    //         $deviceLogData1 = array_merge($historicalData1, $deviceLogData1);

    //         // ====================================================================
    //         $historicalData2 = $this->db->select("last_log_datetime AS x, output_Voltage_P2P_YB AS y")
    //             ->from('tbl_historical_device_log')
    //             ->where('last_log_datetime >=', $queryStartTime)
    //             ->where($conditions)
    //             ->order_by('last_log_datetime', 'ASC')
    //             ->get()
    //             ->result_array();

    //         // Merge historical data with device log data
    //         $deviceLogData2 = array_merge($historicalData2, $deviceLogData2);

    //         // =======================================================

    //         $historicalData3 = $this->db->select("last_log_datetime AS x, output_Voltage_P2P_BR AS y")
    //             ->from('tbl_historical_device_log')
    //             ->where('last_log_datetime >=', $queryStartTime)
    //             ->where($conditions)
    //             ->order_by('last_log_datetime', 'ASC')
    //             ->get()
    //             ->result_array();

    //         // Merge historical data with device log data
    //         $deviceLogData3 = array_merge($historicalData3, $deviceLogData3);

    //          // =======================================================

    //         $historicalData4 = $this->db->select("last_log_datetime AS x, output_Average_Voltage_P2P AS y")
    //             ->from('tbl_historical_device_log')
    //             ->where('last_log_datetime >=', $queryStartTime)
    //             ->where($conditions)
    //             ->order_by('last_log_datetime', 'ASC')
    //             ->get()
    //             ->result_array();

    //         // Merge historical data with device log data
    //         $deviceLogData4 = array_merge($historicalData4, $deviceLogData4);
    //     }

    //     // Prepare the result
    //     $result = [
    //         'output_v_R' => $deviceLogData1,
    //         'output_v_Y' => $deviceLogData2,
    //         'output_v_B' => $deviceLogData3,
    //         'output_v_Avg' => $deviceLogData4,
    //     ];

    //     return $result;
    // }
    public function OutputLine_to_Line_Voltage($wellId, $imeiNo, $hours)
    {
        $conditions = [];
        if (!empty($wellId)) {
            $conditions['well_id'] = $wellId;
        }
        if (!empty($imeiNo)) {
            $conditions['imei_no'] = $imeiNo;
        }

        $currentTime = date('Y-m-d H:i:s');
        $queryStartTime = date('Y-m-d H:i:s', strtotime("-{$hours} hours"));

        $deviceLogData1 = $this->fetchData('tbl_device_log', 'output_Voltage_P2P_RY', $queryStartTime, $conditions);
        $deviceLogData2 = $this->fetchData('tbl_device_log', 'output_Voltage_P2P_YB', $queryStartTime, $conditions);
        $deviceLogData3 = $this->fetchData('tbl_device_log', 'output_Voltage_P2P_BR', $queryStartTime, $conditions);
        $deviceLogData4 = $this->fetchData('tbl_device_log', 'output_Average_Voltage_P2P', $queryStartTime, $conditions);

        if ($hours > 1) {
            
            $historicalData1 = $this->fetchData('tbl_historical_device_log', 'output_Voltage_P2P_RY', $queryStartTime, $conditions);
            $historicalData2 = $this->fetchData('tbl_historical_device_log', 'output_Voltage_P2P_YB', $queryStartTime, $conditions);
            $historicalData3 = $this->fetchData('tbl_historical_device_log', 'output_Voltage_P2P_BR', $queryStartTime, $conditions);
            $historicalData4 = $this->fetchData('tbl_historical_device_log', 'output_Average_Voltage_P2P', $queryStartTime, $conditions);

            $deviceLogData1 = array_merge($historicalData1, $deviceLogData1);
            $deviceLogData2 = array_merge($historicalData2, $deviceLogData2);
            $deviceLogData3 = array_merge($historicalData3, $deviceLogData3);
            $deviceLogData4 = array_merge($historicalData4, $deviceLogData4);
        }

          // Fill in missing data points with 0 values
        $deviceLogData1 = $this->fillMissingData($deviceLogData1);
        $deviceLogData2 = $this->fillMissingData($deviceLogData2);
        $deviceLogData3 = $this->fillMissingData($deviceLogData3);
        $deviceLogData4 = $this->fillMissingData($deviceLogData4);
        
        $result = [
            'output_v_R' => $deviceLogData1,
            'output_v_Y' => $deviceLogData2,
            'output_v_B' => $deviceLogData3,
            'output_v_Avg' => $deviceLogData4,
        ];

        return $result;
    }

    // public function WellOutput_Current($wellId, $imeiNo, $hours)
    // {
    //     $conditions = [];
    //     if (!empty($wellId)) {
    //         $conditions['well_id'] = $wellId;
    //     }
    //     if (!empty($imeiNo)) {
    //         $conditions['imei_no'] = $imeiNo;
    //     }

    //     $currentTime = date('Y-m-d H:i:s');
    //     $queryStartTime = date('Y-m-d H:i:s', strtotime("-{$hours} hours"));

    //     // Always fetch recent data from tbl_device_log within the desired time frame
    //     $deviceLogData1 = $this->db->select("last_log_datetime AS x, output_Current_R AS y")
    //         ->from('tbl_device_log')
    //         ->where('last_log_datetime >=', $queryStartTime)
    //         ->where($conditions)
    //         ->order_by('last_log_datetime', 'ASC')
    //         ->get()
    //         ->result_array();

    //     $deviceLogData2 = $this->db->select("last_log_datetime AS x, output_Current_Y AS y")
    //         ->from('tbl_device_log')
    //         ->where('last_log_datetime >=', $queryStartTime)
    //         ->where($conditions)
    //         ->order_by('last_log_datetime', 'ASC')
    //         ->get()
    //         ->result_array();

    //     $deviceLogData3 = $this->db->select("last_log_datetime AS x, output_Current_B AS y")
    //         ->from('tbl_device_log')
    //         ->where('last_log_datetime >=', $queryStartTime)
    //         ->where($conditions)
    //         ->order_by('last_log_datetime', 'ASC')
    //         ->get()
    //         ->result_array();

    //     $deviceLogData4 = $this->db->select("last_log_datetime AS x, output_Average_Current AS y")
    //         ->from('tbl_device_log')
    //         ->where('last_log_datetime >=', $queryStartTime)
    //         ->where($conditions)
    //         ->order_by('last_log_datetime', 'ASC')
    //         ->get()
    //         ->result_array();

    //     if ($hours > 1) {
    //         // Fetch historical data for the additional time if needed
    //         $historicalData1 = $this->db->select("last_log_datetime AS x, output_Current_R AS y")
    //             ->from('tbl_historical_device_log')
    //             ->where('last_log_datetime >=', $queryStartTime)
    //             ->where($conditions)
    //             ->order_by('last_log_datetime', 'ASC')
    //             ->get()
    //             ->result_array();

    //         // Merge historical data with device log data
    //         $deviceLogData1 = array_merge($historicalData1, $deviceLogData1);

    //         // ====================================================================
    //         $historicalData2 = $this->db->select("last_log_datetime AS x, output_Current_Y AS y")
    //             ->from('tbl_historical_device_log')
    //             ->where('last_log_datetime >=', $queryStartTime)
    //             ->where($conditions)
    //             ->order_by('last_log_datetime', 'ASC')
    //             ->get()
    //             ->result_array();

    //         // Merge historical data with device log data
    //         $deviceLogData2 = array_merge($historicalData2, $deviceLogData2);

    //         // =======================================================

    //         $historicalData3 = $this->db->select("last_log_datetime AS x, output_Current_B AS y")
    //             ->from('tbl_historical_device_log')
    //             ->where('last_log_datetime >=', $queryStartTime)
    //             ->where($conditions)
    //             ->order_by('last_log_datetime', 'ASC')
    //             ->get()
    //             ->result_array();

    //         // Merge historical data with device log data
    //         $deviceLogData3 = array_merge($historicalData3, $deviceLogData3);

    //          // =======================================================

    //         $historicalData4 = $this->db->select("last_log_datetime AS x, output_Average_Current AS y")
    //             ->from('tbl_historical_device_log')
    //             ->where('last_log_datetime >=', $queryStartTime)
    //             ->where($conditions)
    //             ->order_by('last_log_datetime', 'ASC')
    //             ->get()
    //             ->result_array();

    //         // Merge historical data with device log data
    //         $deviceLogData4 = array_merge($historicalData4, $deviceLogData4);
    //     }

    //     // Prepare the result
    //     $result = [
    //         'output_i_R' => $deviceLogData1,
    //         'output_i_Y' => $deviceLogData2,
    //         'output_i_B' => $deviceLogData3,
    //         'output_i_Avg' => $deviceLogData4,
    //     ];

    //     return $result;
    // }
    public function WellOutput_Current($wellId, $imeiNo, $hours)
    {
        $conditions = [];
        if (!empty($wellId)) {
            $conditions['well_id'] = $wellId;
        }
        if (!empty($imeiNo)) {
            $conditions['imei_no'] = $imeiNo;
        }

        $currentTime = date('Y-m-d H:i:s');
        $queryStartTime = date('Y-m-d H:i:s', strtotime("-{$hours} hours"));

        // Fetch recent data from tbl_device_log within the desired time frame
        $deviceLogData1 = $this->fetchData('tbl_device_log', 'output_Current_R', $queryStartTime, $conditions);
        $deviceLogData2 = $this->fetchData('tbl_device_log', 'output_Current_Y', $queryStartTime, $conditions);
        $deviceLogData3 = $this->fetchData('tbl_device_log', 'output_Current_B', $queryStartTime, $conditions);
        $deviceLogData4 = $this->fetchData('tbl_device_log', 'output_Average_Current', $queryStartTime, $conditions);

        if ($hours > 1) {
            // Fetch historical data for the additional time if needed
            $historicalData1 = $this->fetchData('tbl_historical_device_log', 'output_Current_R', $queryStartTime, $conditions);
            $historicalData2 = $this->fetchData('tbl_historical_device_log', 'output_Current_Y', $queryStartTime, $conditions);
            $historicalData3 = $this->fetchData('tbl_historical_device_log', 'output_Current_B', $queryStartTime, $conditions);
            $historicalData4 = $this->fetchData('tbl_historical_device_log', 'output_Average_Current', $queryStartTime, $conditions);

            // Merge historical data with device log data
            $deviceLogData1 = array_merge($historicalData1, $deviceLogData1);
            $deviceLogData2 = array_merge($historicalData2, $deviceLogData2);
            $deviceLogData3 = array_merge($historicalData3, $deviceLogData3);
            $deviceLogData4 = array_merge($historicalData4, $deviceLogData4);
        }

        // Fill in missing data points with 0 values
        $deviceLogData1 = $this->fillMissingData($deviceLogData1);
        $deviceLogData2 = $this->fillMissingData($deviceLogData2);
        $deviceLogData3 = $this->fillMissingData($deviceLogData3);
        $deviceLogData4 = $this->fillMissingData($deviceLogData4);

        // Prepare the result
        $result = [
            'output_i_R' => $deviceLogData1,
            'output_i_Y' => $deviceLogData2,
            'output_i_B' => $deviceLogData3,
            'output_i_Avg' => $deviceLogData4,
        ];

        return $result;
    }

     public function smps_voltage($wellId, $imeiNo, $hours)
    {
        $conditions = [];
        if (!empty($wellId)) {
            $conditions['well_id'] = $wellId;
        }
        if (!empty($imeiNo)) {
            $conditions['imei_no'] = $imeiNo;
        }

        $currentTime = date('Y-m-d H:i:s');
        $queryStartTime = date('Y-m-d H:i:s', strtotime("-{$hours} hours"));

        // Fetch recent data from tbl_device_log within the desired time frame
        $deviceLogData1 = $this->fetchData('tbl_device_log', 'smps_voltage', $queryStartTime, $conditions);
       

        if ($hours > 1) {
            // Fetch historical data for the additional time if needed
            $historicalData1 = $this->fetchData('tbl_historical_device_log', 'smps_voltage', $queryStartTime, $conditions);
          

            // Merge historical data with device log data
            $deviceLogData1 = array_merge($historicalData1, $deviceLogData1);
           
        }

        // Fill in missing data points with 0 values
        $deviceLogData1 = $this->fillMissingData($deviceLogData1);
       

        // Prepare the result
        $result = [
            'smps_voltage' => $deviceLogData1,
           
        ];

        return $result;
    }

     public function battery_voltage($wellId, $imeiNo, $hours)
    {
        $conditions = [];
        if (!empty($wellId)) {
            $conditions['well_id'] = $wellId;
        }
        if (!empty($imeiNo)) {
            $conditions['imei_no'] = $imeiNo;
        }

        $currentTime = date('Y-m-d H:i:s');
        $queryStartTime = date('Y-m-d H:i:s', strtotime("-{$hours} hours"));

  
        $deviceLogData1 = $this->fetchData('tbl_device_log', 'battery_Voltage', $queryStartTime, $conditions);

        if ($hours > 1) {
         
            $historicalData1 = $this->fetchData('tbl_historical_device_log', 'battery_Voltage', $queryStartTime, $conditions);
          

            // Merge historical data with device log data
            $deviceLogData1 = array_merge($historicalData1, $deviceLogData1);
           
        }

        // Fill in missing data points with 0 values
        $deviceLogData1 = $this->fillMissingData($deviceLogData1);
       

        // Prepare the result
        $result = [
            'battery_voltage' => $deviceLogData1,
           
        ];

        return $result;
    }

    private function fetchData($table, $column, $queryStartTime, $conditions)
    {
        return $this->db->select("last_log_datetime AS x, {$column} AS y")
            ->from($table)
            ->where('last_log_datetime >=', $queryStartTime)
            ->where($conditions)
            ->order_by('last_log_datetime', 'ASC')
            ->get()
            ->result_array();
    }

    private function fillMissingData($data)
    {
        $filledData = [];
        $timeFormat = 'Y-m-d H:i:s';
        $previousTime = null;
        $interval = new DateInterval('PT1M'); 

        foreach ($data as $entry) {
            $currentTime = DateTime::createFromFormat($timeFormat, $entry['x']);

            if ($previousTime !== null) {
                while ($previousTime->add($interval) < $currentTime) {
                    $filledData[] = ['x' => $previousTime->format($timeFormat), 'y' => 0];
                }
            }

            $filledData[] = $entry;
            $previousTime = $currentTime;
        }

        return $filledData;
    }

  
    
    public function getRunning_Device($well_id,$imei_no)
    {
        if (date('H') < 6)
        {
            $from_date = date('Y-m-d', strtotime('-1 day')) . ' 06:00:00';
            $to_date = date('Y-m-d') . ' 06:00:00';

        }else{
            $from_date = date('Y-m-d') . ' 06:00:00';
            $to_date = date('Y-m-d', strtotime('+1 day')) . ' 06:00:00';
            
        }

        if($well_id!='')
            $this->db->where('well_id',$well_id);

        if($imei_no!='')
            $this->db->where('imei_no',$imei_no);
        

        return $this->db->select("sum(total_kwh) as today_energy,floor(sum(total_running_minute)/60) as today_Hour, (sum(total_running_minute)%60) as today_Minutes")
        ->from('tbl_well_running_log')
        ->where(['start_datetime >='=> $from_date, 'end_datetime <='=> $to_date])
        ->get()->result_array();
    }


    public function get_total_Running_Device($well_id,$imei_no)
    {
         if($well_id!='')
            $this->db->where('well_id',$well_id);

        if($imei_no!='')
            $this->db->where('imei_no',$imei_no);
        

        return $this->db->select("sum(total_kwh) as total_energy,floor(sum(total_running_minute)/60) as total_Hour, (sum(total_running_minute)%60) as total_Minutes")
        ->from('tbl_well_running_log')
        ->get()->result_array();
    }

   public function getForcasting_data($well_id)
   {
        if ($well_id != '') 
        {
            $this->db->where('fs.well_id', $well_id);
        }

        $current_month = date('m'); 
        $current_year = date('Y');
        $current_day = date('d'); 
 
        if ($current_month == 1) {
            $previous_month = 12;
            $previous_year = $current_year - 1;
          
        } else {
            $previous_month = $current_month - 1;
            $previous_year = $current_year;
           
        }

        $previous_month = sprintf("%02d", $previous_month);

        if($current_day == 1)
        {
             $previous_month = $current_month - 2;
             $previous_month_data = $current_month - 1;

            $from_date = date('Y') . '-' . $previous_month . '-01 06:00:00';
            $to_date = date('Y') . '-' . $previous_month_data . '-01 05:59:59';

        }else{

            $from_date = date('Y') . '-' . $previous_month . '-01 06:00:00';
             $to_date = date('Y') . '-' . $current_month . '-01 05:59:59';

        }

        $this->db->where('wr.start_datetime >=', $from_date);
        $this->db->where('wr.end_datetime <=', $to_date);

        $this->db->select("COALESCE(sum(wr.total_kwh), 0) as total_energy,
                       COALESCE(sum(wr.total_running_minute), 0) as total_Minutes,
                       COALESCE(fs.comparison_kwh_result_percentage, 0) as comparison_kwh_result_percentage,
                       COALESCE(fs.forecasted_kwh, 0) as forecasted_kwh,
                       COALESCE(fs.total_kwh_current_month, 0) as total_kwh_current_month,
                       COALESCE(fs.total_kwh_previous_month, 0) as total_kwh_previous_month,
                       COALESCE(fs.forecasted_minutes, 0) as forecasted_minutes,
                       COALESCE(fs.comparison_minutes_result_percentage, 0) as comparison_minutes_result_percentage,
                       COALESCE(fs.total_running_minute_current_month, 0) as total_running_minute_current_month,
                       COALESCE(fs.total_running_minute_previous_month, 0) as total_running_minute_previous_month,
                       fs.well_name, fs.Generating_date, fs.Comparison_date")
           ->from('forecasting_results fs')
           ->join('tbl_well_running_log wr', 'wr.well_id = fs.well_id', 'left')
           ->where('fs.Comparison_date = (SELECT MAX(Comparison_date) 
                                           FROM forecasting_results 
                                           WHERE well_id = fs.well_id)', null, false)
           ->group_by('fs.well_id');
         

       $result = $this->db->get()->result_array();
           if (empty($result)) {
            return [[
                'total_energy' => 0,
                'total_Minutes' => 0,
                'comparison_kwh_result_percentage' => 0,
                'forecasted_kwh' => 0,
                'total_kwh_current_month' => 0,
                'total_kwh_previous_month' => 0,
                'forecasted_minutes' => 0,
                'comparison_minutes_result_percentage' => 0,
                'total_running_minute_current_month' => 0,
                'total_running_minute_previous_month' => 0,
                'well_name' => '',
                'Generating_date' => '',
                'Comparison_date' => ''
            ]];
         }

       return $result;
    }

    public function get_well_sheduling_details($well_id)
    {
    
      $schduleData =  $this->db->select('start_time,stop_time,well_id')
                      ->from('tbl_well_configuration')
                       ->where(['status'=>1,'well_id'=>$well_id,'well_type'=>1])
                       ->order_by('start_time','ASC')
                       ->get()->result_array();

          $schduleDetails = [];

            foreach ($schduleData as $row) {
                $wellName = $row['well_id'];
                $schduleDetails[$wellName]['well_id'] = $wellName;
                $schduleDetails[$wellName]['schdule_time'][] = [
                    'start_time' => $row['start_time'],
                    'stop_time' => $row['stop_time']
                ];
            }
        $schduleDetails = array_values($schduleDetails);

         return $schduleDetails;
    }     
}
?>
