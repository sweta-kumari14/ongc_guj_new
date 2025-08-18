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
                              sd.RTC_Time as Log_Date_Time, sd.CHP, sd.THP, sd.ABP, sd.FLT, sd.Battery_Voltage, wm.well_name, sd.well_status as flag_status, wm.lat, 
                              wm.long as long,sd.CHP_battery_volt,sd.FLT_battery_volt,sd.THP_battery_volt,sd.ABP_battery_volt")

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

        return $this->db->select("sd.id,sd.well_id,tl.imei_no,sd.device_name,tl.alert_type,tl.alert_details,tl.start_date_time as trip_datetime")
        ->from('tbl_alert_log_self_flow tl')
        ->join('tbl_site_device_installtion_self_flow sd','sd.well_id=tl.well_id','left')
        ->where(['sd.status'=>1,'tl.start_date_time >='=> $from_date,'tl.end_date_time <'=> $to_date])->get()->result_array();
       
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
        ->where(['sd.status'=>1,'tl.start_date_time >='=> $from_date,'tl.end_date_time <'=> $to_date])->get()->result_array();
        if($res!='')
        {
            return $res[0]['total'];
        }else{
            return 0;
        }
       
    }

    public function Well_wise_daily_avg($well_id)
    {
        $current_date = date('Y-m-d');

        $this->db->select('COALESCE(AVG(dl.THP), 0) as avg_THP, 
                           COALESCE(AVG(dl.CHP), 0) as avg_CHP, 
                           COALESCE(AVG(dl.ABP), 0) as avg_ABP,
                           COALESCE(AVG(dl.FLT), 0) as avg_FLT')
                 ->from('tbl_site_device_installtion_self_flow sd')
                 ->join('tbl_historical_log_self_flow dl','sd.well_id=dl.well_id','left')
                 ->where('DATE(dl.Log_Date_Time)', $current_date);

        if ($well_id != '') {
            $this->db->where('sd.well_id', $well_id);
        }

        $this->db->group_by('DATE(dl.Log_Date_Time)')
                 ->order_by('dl.Log_Date_Time', 'ASC');

        $row = $this->db->get()->row_array();

        // Ensure all fields exist with 0 if null
        $default = [
            'avg_THP' => 0,
            'avg_CHP' => 0,
            'avg_ABP' => 0,
            'avg_FLT' => 0
        ];

        return $row ? $row : $default;
    }

    public function Well_wise_monthly_avg($well_id)
{
    // Previous month date based on current date
    $prevMonth = date('m', strtotime('-1 month')); // month number
    $prevYear  = date('Y', strtotime('-1 month')); // year

    if ($well_id != '') {
        $this->db->where('sd.well_id', $well_id);
    }
    
    // Filter logs by previous month and year
    $this->db->where('MONTH(dl.Log_Date_Time)', $prevMonth); 
    $this->db->where('YEAR(dl.Log_Date_Time)', $prevYear);  

    return $this->db->select('
                COALESCE(AVG(dl.THP), 0) as avg_THP, 
                COALESCE(AVG(dl.CHP), 0) as avg_CHP, 
                COALESCE(AVG(dl.ABP), 0) as avg_ABP,
                COALESCE(AVG(dl.FLT), 0) as avg_FLT
            ')
            ->from('tbl_site_device_installtion_self_flow sd')
            ->join('tbl_historical_log_self_flow dl','sd.well_id=dl.well_id','left')
            ->get()
            ->row_array(); 
}


  // Controller or Model function to get graph data
public function OutPut_graph($wellId, $from_date, $to_date)
{
    $conditions = [];
    if (!empty($wellId)) {
        $conditions['well_id'] = $wellId;
    }

    // Set date range
    if (empty($from_date) || empty($to_date)) {
        $queryStartTime = date('Y-m-d H:i:s', strtotime('-24 hours'));
        $currentTime = date('Y-m-d H:i:s');
    } else {
        $queryStartTime = date('Y-m-d H:i:s', strtotime($from_date));
        $currentTime = date('Y-m-d H:i:s', strtotime($to_date));
    }

    // Parameters to fetch
    $columns = ['CHP', 'THP', 'ABP', 'FLT', 'Battery_Voltage'];

    // Fetch formatted data
    $historicalData = $this->fetchMultipleData('tbl_historical_log_self_flow', $columns, $queryStartTime, $currentTime, $conditions);

    // Return in JSON-friendly format
    return $historicalData ? $historicalData : [];
}


// Helper function to fetch multiple columns and format for JS graph
private function fetchMultipleData($table, $columns, $startTime, $endTime, $conditions = [])
{
    // Build SELECT statement
    $columnSelect = "Log_Date_Time AS x, " . implode(", ", array_map(function($col){
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

    // Format each column as array of {x, y} for JS chart
    $formattedData = [];
    foreach ($columns as $column) {
        $formattedData[$column] = array_map(function($row) use ($column){
            // Ensure y is numeric, default to 0 if null
            $yValue = isset($row["y_$column"]) ? (float)$row["y_$column"] : 0;
            return ['x' => $row['x'], 'y' => $yValue];
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

}
?>
