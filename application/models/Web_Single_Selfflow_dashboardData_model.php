<?php
date_default_timezone_set('Asia/Kolkata');
class Web_Single_Selfflow_dashboardData_model extends CI_Model
{
	private $client;
    public function __construct()
    {
        parent::__construct();
        $this->load->library('ClickHouseDB'); 
        $this->client = $this->clickhousedb->getClient(); 

        if (!$this->client->ping()) {
            log_message('error', 'ClickHouse connection failed');
            show_error('ClickHouse not connected');
        }
    }
    public function Single_Well_DeviceData($well_id)
    {
        if($well_id!='')
            $this->db->where('sd.well_id',$well_id);
        $res = $this->db->select("sd.well_id, sd.area_id, sd.site_id, sd.well_type, sd.device_name, sd.imei_no,sd.RTC_Time as Log_Date_Time, sd.CHP, sd.THP, sd.ABP, sd.FLT, sd.Battery_Voltage, wm.well_name, sd.well_status as flag_status, wm.lat,wm.long as long,sd.CHP_battery_volt,sd.FLT_battery_volt,sd.THP_battery_volt,sd.ABP_battery_volt,wt.well_type_name")

        ->from('tbl_site_device_installtion_self_flow sd')
        ->join('tbl_well_master wm','sd.well_id=wm.id','left')
         ->join('tbl_well_type wt','sd.well_type=wt.id','left')
        ->where(['sd.status'=>1])->get()->result_array();


           $thresholdData = $this->db
            ->select("id,node_name,upper_value, lower_value")
            ->from('tbl_well_threshold_setup_master')
            ->where(['status' => 1, 'well_id' => $well_id])
            ->get()
            ->result_array();

        foreach ($res as $key => $value) {
            $res[$key]['threshold_data'] = $thresholdData;
        }

        return $res;
       
    }
        public function WellAlert_Details($well_id)
    {
        // 06:00 to 06:00 window
        if (date('H') < 6) {
            $from_date = date('Y-m-d', strtotime('-1 day')) . ' 06:00:00';
            $to_date   = date('Y-m-d') . ' 06:00:00';
        } else {
            $from_date = date('Y-m-d') . ' 06:00:00';
            $to_date   = date('Y-m-d', strtotime('+1 day')) . ' 06:00:00';
        }

        $sql = "
            SELECT alert_type, alert_details, start_date_time AS trip_datetime
            FROM tbl_alert_log_self_flow
            WHERE status = 1
              AND start_date_time >= :from_date
              AND end_date_time < :to_date
        ";

        $params = ['from_date' => $from_date, 'to_date' => $to_date];

        if (!empty($well_id)) {
            $sql .= " AND well_id = :well_id";
            $params['well_id'] = $well_id;
        }

        try {
            $stmt = $this->client->select($sql, $params);
            $rows = $stmt->rows();
            return $rows ?: [];
        } catch (Exception $e) {
            log_message('error', 'ClickHouse select failed: '.$e->getMessage());
            return [];
        }
    }

    public function Well_WiseTotal_Alert($well_id)
    {
        if (date('H') < 6) {
            $from_date = date('Y-m-d', strtotime('-1 day')) . ' 06:00:00';
            $to_date   = date('Y-m-d') . ' 06:00:00';
        } else {
            $from_date = date('Y-m-d') . ' 06:00:00';
            $to_date   = date('Y-m-d', strtotime('+1 day')) . ' 06:00:00';
        }

        $sql = "SELECT count() AS total
                FROM tbl_alert_log_self_flow
                WHERE status = 1
                  AND start_date_time >= :from_date
                  AND end_date_time < :to_date";

        $params = ['from_date' => $from_date, 'to_date' => $to_date];

        if (!empty($well_id)) {
            $sql .= " AND well_id = :well_id";
            $params['well_id'] = $well_id;
        }

        try {
            $stmt = $this->client->select($sql, $params);
            $rows = $stmt->rows();
            return !empty($rows) ? (int)$rows[0]['total'] : 0;
        } catch (Exception $e) {
            log_message('error', 'ClickHouse count failed: '.$e->getMessage());
            return 0;
        }
    }


    public function Well_wise_daily_avg($well_id)
    {
        $from = date('Y-m-d') . ' 00:00:00';
        $to   = date('Y-m-d', strtotime('+1 day')) . ' 00:00:00';

        $sql = "
            SELECT
                COALESCE(avg(THP), 0) AS avg_THP,
                COALESCE(avg(CHP), 0) AS avg_CHP,
                COALESCE(avg(ABP), 0) AS avg_ABP,
                COALESCE(avg(FLT), 0) AS avg_FLT
            FROM tbl_historical_log_self_flow
            WHERE Log_Date_Time >= :from
              AND Log_Date_Time <  :to
        ";

        $params = ['from' => $from, 'to' => $to];

        if (!empty($well_id)) {
            $sql .= " AND well_id = :well_id";
            $params['well_id'] = $well_id;
        }

        $default = [
            'avg_THP' => 0.0,
            'avg_CHP' => 0.0,
            'avg_ABP' => 0.0,
            'avg_FLT' => 0.0,
        ];

        try {
            // USE $this->client, not $this->click
            $res  = $this->client->select($sql, $params);
            $rows = $res->rows();
            return !empty($rows) ? $rows[0] : $default;
        } catch (Exception $e) {
            log_message('error', 'daily_avg failed: ' . $e->getMessage());
            return $default;
        }
    }



    public function Well_wise_monthly_avg($well_id)
    {

        $to   = date('Y-m-d H:i:s');
        $from = date('Y-m-d H:i:s', strtotime('-1 month'));

        $sql = "
            SELECT
                COALESCE(avg(THP), 0) AS avg_THP,
                COALESCE(avg(CHP), 0) AS avg_CHP,
                COALESCE(avg(ABP), 0) AS avg_ABP,
                COALESCE(avg(FLT), 0) AS avg_FLT
            FROM tbl_historical_log_self_flow
            WHERE Log_Date_Time >= :from
              AND Log_Date_Time <= :to
        ";

        $params = ['from' => $from, 'to' => $to];

        if (!empty($well_id)) {
            $sql .= " AND well_id = :well_id";
            $params['well_id'] = $well_id;
        }

        $default = [
            'avg_THP' => 0.0,
            'avg_CHP' => 0.0,
            'avg_ABP' => 0.0,
            'avg_FLT' => 0.0,
        ];

        try {
            $res  = $this->client->select($sql, $params);
            $rows = $res->rows();
            return !empty($rows) ? $rows[0] : $default;
        } catch (Exception $e) {
            log_message('error', 'monthly_avg failed: ' . $e->getMessage());
            return $default;
        }
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

        $columns = ['CHP', 'THP', 'ABP', 'FLT', 'Battery_Voltage'];

        $historicalData = $this->fetchMultipleData('tbl_historical_log_self_flow', $columns, $queryStartTime, $currentTime, $conditions);

        return $historicalData ? $historicalData : [];
    }

    private function fetchMultipleData($table, $columns, $startTime, $endTime, $conditions)
    {
        $columnSelect = "Log_Date_Time AS x, " . implode(", ", array_map(function($col) {
            return "$col AS y_$col";
        }, $columns));

        $whereClauses = [];
        $whereClauses[] = "Log_Date_Time >= toDateTime('{$startTime}')";
        $whereClauses[] = "Log_Date_Time <= toDateTime('{$endTime}')";

        foreach ($conditions as $key => $value) {
            $whereClauses[] = "{$key} = '{$value}'";
        }

        $whereSql = implode(' AND ', $whereClauses);

        $sql = "
            SELECT {$columnSelect}
            FROM {$table}
            WHERE {$whereSql}
            ORDER BY Log_Date_Time ASC
        ";

        $result = $this->client->select($sql);
        $rows = $result->rows();

        $formattedData = [];
        foreach ($columns as $column) {
            $formattedData[$column] = array_map(function ($row) use ($column) {
                return ['x' => $row['x'], 'y' => $row["y_$column"]];
            }, $rows);
        }

        return $formattedData;
    }
}
?>
