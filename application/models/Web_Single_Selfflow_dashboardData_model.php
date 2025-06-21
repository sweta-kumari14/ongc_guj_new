<?php
date_default_timezone_set('Asia/Kolkata');
class Web_Single_Selfflow_dashboardData_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

   public function Single_Well_DeviceData($well_id)
    {
        if($well_id!='')
            $this->db->where('sd.well_id',$well_id);
        return $this->db->select("sd.well_id, sd.area_id, sd.site_id, sd.well_type, sd.device_name, sd.imei_no, 
                              sd.RTC_Time as Log_Date_Time, sd.PS_1_GIP, sd.PS_2_CHP, sd.PS_3_THP, sd.PS_4_ABP, 
                              sd.FLTP_1_Temp, sd.Battery_Voltage, sd.flag_status, sd.PSF_1, sd.PSF_2, sd.PSF_3, 
                              sd.PSF_4, sd.TSF_1, sd.SF_1_solenide, sd.BVF_1, sd.TRGT_Time, sd.ON_Time, sd.Off_Time, 
                              sd.next_cycle, sd.last_cycle, wm.well_name, sd.flag_status, sd.passcode, sd.lat, 
                              sd.long as long")

        ->from('tbl_site_device_installtion_self_flow sd')
        ->join('tbl_well_master wm','sd.well_id=wm.id','left')
        ->where(['sd.status'=>1])->get()->result_array();
       
    }
    public function WellAlert_Details($well_id)
    {
        
        if($well_id!='')
            $this->db->where('sd.well_id',$well_id);
        

        if (date('H') < 6){
        
            $from_date = date('Y-m-d', strtotime('-1 day')) . ' 06:00:00';
            $to_date = date('Y-m-d') . ' 06:00:00';
        }else{
            $from_date = date('Y-m-d') . ' 06:00:00';
            $to_date = date('Y-m-d', strtotime('+1 day')) . ' 06:00:00';
        }

        return $this->db->select("sd.id,sd.well_id,tl.imei_no,sd.device_name,tl.alert_type,tl.alert_details,tl.alert_date_time as trip_datetime")
        ->from('tbl_alert_log_self_flow tl')
        ->join('tbl_site_device_installtion_self_flow sd','sd.well_id=tl.well_id','left')
        ->where(['sd.status'=>1,'tl.alert_date_time >='=> $from_date,'tl.alert_date_time <'=> $to_date])->get()->result_array();
       
    }


    public function Well_WiseTotal_Alert($well_id)
    {
        
        if($well_id!='')
            $this->db->where('sd.well_id',$well_id);
        if (date('H') < 6){
        
            $from_date = date('Y-m-d', strtotime('-1 day')) . ' 06:00:00';
            $to_date = date('Y-m-d') . ' 06:00:00';
        }else{
            $from_date = date('Y-m-d') . ' 06:00:00';
            $to_date = date('Y-m-d', strtotime('+1 day')) . ' 06:00:00';
        }

        $res = $this->db->select("count(tl.well_id) as total")
        ->from('tbl_site_device_installtion_self_flow sd')
        ->join('tbl_alert_log_self_flow tl','sd.well_id=tl.well_id and tl.status=1','left')
        ->where(['sd.status'=>1,'tl.alert_date_time >='=> $from_date,'tl.alert_date_time <'=> $to_date])->get()->result_array();
        if($res!='')
        {
            return $res[0]['total'];
        }else{
            return 0;
        }
       
    }

    public function Well_wise_daily_avg($well_id)
    {
        if ($well_id != '') {
            $this->db->where('sd.well_id', $well_id);
        }

        $current_date = date('Y-m-d');
        $this->db->where('DATE(dl.Log_Date_Time)', $current_date);

        return $this->db->select('COALESCE(AVG(dl.PS_1_GIP), 0) as avg_PS_1_GIP, 
                                    COALESCE(AVG(dl.PS_2_CHP), 0) as avg_PS_2_CHP, 
                                    COALESCE(AVG(dl.PS_3_THP), 0) as avg_PS_3_THP, 
                                    COALESCE(AVG(dl.PS_4_ABP), 0) as avg_PS_4_ABP,
                                    COALESCE(AVG(dl.FLTP_1_Temp), 0) as avg_FLTP_1_Temp')
                            ->from('tbl_site_device_installtion_self_flow sd')
                            ->join('tbl_device_log_self_flow dl','sd.well_id=dl.well_id','left')
                            ->group_by('DATE(dl.Log_Date_Time)')
                            ->order_by('dl.Log_Date_Time', 'ASC')
                            ->get()
                            ->row_array();
    }

   

   public function Well_wise_monthly_avg($well_id)
    {
        if ($well_id != '') {
            $this->db->where('sd.well_id', $well_id);
        }
        
        $this->db->where('MONTH(dl.Log_Date_Time)', date('m')); 
        $this->db->where('YEAR(dl.Log_Date_Time)', date('Y'));  

            return $this->db->select('
                              COALESCE(AVG(dl.PS_1_GIP), 0) as avg_PS_1_GIP, 
                                    COALESCE(AVG(dl.PS_2_CHP), 0) as avg_PS_2_CHP, 
                                    COALESCE(AVG(dl.PS_3_THP), 0) as avg_PS_3_THP, 
                                    COALESCE(AVG(dl.PS_4_ABP), 0) as avg_PS_4_ABP,
                                    COALESCE(AVG(dl.FLTP_1_Temp), 0) as avg_FLTP_1_Temp')
                    ->from('tbl_site_device_installtion_self_flow sd')
                    ->join('tbl_device_log_self_flow dl','sd.well_id=dl.well_id','left')
                    ->get()
                    ->row_array(); 
    }


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


   public function OutPut_graph($wellId, $from_date, $to_date)
    {
        $conditions = [];
        if (!empty($wellId)) {
            $conditions['well_id'] = $wellId;
        }

        if (empty($from_date) || empty($to_date)) {
            $queryStartTime = date('Y-m-d H:i:s', strtotime('-24 hours'));
            $currentTime = date('Y-m-d H:i:s');
        } else {
            $queryStartTime = date('Y-m-d H:i:s', strtotime($from_date));
            $currentTime = date('Y-m-d H:i:s', strtotime($to_date));
        }

        // Define the parameters to fetch
        $columns = [
            'PS_2_CHP', 'PS_1_GIP', 'PS_4_ABP', 'PS_3_THP', 'FLTP_1_Temp', 'Battery_Voltage'
        ];

        // Fetch all data in a single query for both tables
        $deviceLogData = $this->fetchMultipleData('tbl_device_log_self_flow', $columns, $queryStartTime, $currentTime, $conditions);
        $historicalData = $this->fetchMultipleData('tbl_historical_log_self_flow', $columns, $queryStartTime, $currentTime, $conditions);

        // Merge historical and real-time data
        $mergedData = [];
        foreach ($columns as $column) {
            $mergedData[$column] = array_merge($historicalData[$column] ?? [], $deviceLogData[$column] ?? []);
        }



        // Prepare the final output structure
        $result = [
            'output_chp' => $mergedData['PS_2_CHP'],
            'output_gip' => $mergedData['PS_1_GIP'],
            'output_abp' => $mergedData['PS_4_ABP'],
            'output_thp' => $mergedData['PS_3_THP'],
            'output_tht' => $mergedData['FLTP_1_Temp'],
            'output_battery' => $mergedData['Battery_Voltage'],
        ];

        return $result;
    }


    private function fetchMultipleData($table, $columns, $startTime, $endTime, $conditions)
    {
        $columnSelect = "Log_Date_Time  AS x, " . implode(", ", array_map(function($col) {
            return "$col AS y_$col";
        }, $columns));

        $this->db->select($columnSelect)
            ->from($table)
            ->where("Log_Date_Time BETWEEN '{$startTime}' AND '{$endTime}'", null, false);

        if (!empty($conditions)) {
            $this->db->where($conditions);
        }

        $this->db->order_by('Log_Date_Time', 'ASC');
        $result = $this->db->get()->result_array();

        $formattedData = [];
        foreach ($columns as $column) {
            $formattedData[$column] = array_map(function ($row) use ($column) {
                return ['x' => $row['x'], 'y' => $row["y_$column"]];
            }, $result);
        }

        return $formattedData;
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
