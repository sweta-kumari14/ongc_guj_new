<?php
date_default_timezone_set('Asia/Kolkata');
class selfflow_report_model extends CI_Model
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
    // Mysql query
  
    // public function HistoricalDataMis_Report($well_id, $from_date, $to_date)
    // {
    //     $conditions = [];
    //     if (!empty($well_id)) {
    //         $conditions['well_id'] = $well_id;
    //     }

    //     if (!empty($from_date) && !empty($to_date)) {
    //         if ($from_date == $to_date) {
    //             $currentTime = date('Y-m-d', strtotime($to_date . '+1 day')) . ' 06:00:00';
    //         } else {
    //             $currentTime = date('Y-m-d', strtotime($to_date)) . ' 06:00:00';
    //         }

    //         $queryStartTime = date('Y-m-d', strtotime($from_date)) . ' 06:00:00';
    //     }

    //     // Step 1: Fetch historical data
    //     $historicalData = $this->fetchData(
    //         'tbl_historical_log_self_flow',
    //         'well_id, CHP, CHP_battery_volt, THP, THP_battery_volt, ABP, ABP_battery_volt, FLT, FLT_battery_volt, Battery_Voltage, Log_Date_Time',
    //         $queryStartTime,
    //         $currentTime,
    //         $conditions
    //     );

    //     if (!empty($historicalData)) {
    //         // Step 2: Fetch well names for all unique well_ids
    //         $wellIds = array_column($historicalData, 'well_id');

    //         $this->db->select('id, well_name');
    //         $this->db->from('tbl_well_master');
    //         $this->db->where_in('id', $wellIds);
    //         $wellMasterData = $this->db->get()->result_array();
    //         $wellMap = [];
    //         foreach ($wellMasterData as $w) {
    //             $wellMap[$w['id']] = $w['well_name'];
    //         }

    //         foreach ($historicalData as &$row) {
    //             $row['well_name'] = $wellMap[$row['well_id']] ?? 'Unknown Well';
    //         }
    //         unset($row); 
    //     }

    //      return $historicalData;
    // }


    // private function fetchData($table, $columns, $queryStartTime, $currentTime, $conditions)
    // {
    //     $this->db->select($columns)
    //     ->from($table);
    //     if (!empty($queryStartTime) && !empty($currentTime)) {
    //         $this->db->where([
    //             'Log_Date_Time >=' => $queryStartTime,
    //             'Log_Date_Time <=' => $currentTime
    //         ]);
    //     }
    //     if (!empty($conditions)) {
    //         $this->db->where($conditions);
    //     }
    //     $this->db->order_by('Log_Date_Time','ASC');
    //     return $this->db->get()->result_array();
    // }

    // click house query 

    public function HistoricalDataMis_Report($well_id, $from_date, $to_date)
    {
        $conditions = [];
        if (!empty($well_id)) {
            $conditions['well_id'] = $well_id;
        }

        if (!empty($from_date) && !empty($to_date)) {
            if ($from_date == $to_date) {
                $currentTime = date('Y-m-d', strtotime($to_date . '+1 day')) . ' 06:00:00';
            } else {
                $currentTime = date('Y-m-d', strtotime($to_date)) . ' 06:00:00';
            }

            $queryStartTime = date('Y-m-d', strtotime($from_date)) . ' 06:00:00';
        }

        $historicalData = $this->fetchDataFromClickHouse(
            'tbl_historical_log_self_flow',
            'well_id, CHP, CHP_battery_volt, THP, THP_battery_volt, ABP, ABP_battery_volt, FLT, FLT_battery_volt, Battery_Voltage, Log_Date_Time',
            $queryStartTime,
            $currentTime,
            $conditions
        );

        if (!empty($historicalData)) {
            $wellIds = array_column($historicalData, 'well_id');

            $this->db->select('id, well_name');
            $this->db->from('tbl_well_master');
            $this->db->where_in('id', $wellIds);
            $wellMasterData = $this->db->get()->result_array();

            $wellMap = [];
            foreach ($wellMasterData as $w) {
                $wellMap[$w['id']] = $w['well_name'];
            }
            foreach ($historicalData as &$row) {
                $row['well_name'] = $wellMap[$row['well_id']] ?? 'Unknown Well';
            }
            unset($row); 
        }

        return $historicalData;
    }

    private function fetchDataFromClickHouse($table, $columns, $queryStartTime, $currentTime, $conditions)
    {
        $where = [];
        if (!empty($queryStartTime) && !empty($currentTime)) {
            $where[] = "Log_Date_Time >= '{$queryStartTime}' AND Log_Date_Time <= '{$currentTime}'";
        }
        if (!empty($conditions['well_id'])) {
            $where[] = "well_id = '{$conditions['well_id']}'";
        }

        $whereClause = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';

        $query = "
            SELECT {$columns}
            FROM {$table}
            {$whereClause}
            ORDER BY Log_Date_Time ASC
        ";
        $statement = $this->client->select($query);
        return $statement->rows();
    }

    // public function OutPut_historical_chp($well_id,$from_date,$to_date)
    // {
    //     $result = [];
    //     $conditions = [];
    //     if (!empty($well_id)) {
    //         $conditions['dl.well_id'] = $well_id;
    //     }

    //     if (!empty($from_date) && !empty($to_date)) {
    //         $queryStartTime = date('Y-m-d', strtotime($from_date)) . ' 06:00:00';

    //         $currentTime = date('Y-m-d', strtotime($to_date . ' +1 day')) . ' 06:00:00';
    //     }

    //     $historicalData = $this->fetchHisData(
    //         'tbl_historical_log_self_flow dl',
    //         'dl.Log_Date_Time as x,dl.CHP as y',
    //         $queryStartTime,
    //         $currentTime,
    //         $conditions
    //     );

    //     return $historicalData;
        
    // }

    // public function Output_His_abp($well_id,$from_date, $to_date)
    // {
    //     $result = [];
    //     $conditions = [];
    //     if (!empty($well_id)) {
    //         $conditions['dl.well_id'] = $well_id;
    //     }

    //     if (!empty($from_date) && !empty($to_date)) {
    //         $queryStartTime = date('Y-m-d', strtotime($from_date)) . ' 06:00:00';

    //         $currentTime = date('Y-m-d', strtotime($to_date . ' +1 day')) . ' 06:00:00';
    //     }

    //     $historicalData = $this->fetchHisData(
    //         'tbl_historical_log_self_flow dl',
    //         'dl.Log_Date_Time as x,dl.ABP as y',
    //         $queryStartTime,
    //         $currentTime,
    //         $conditions
    //     );

    //     return $historicalData;
        
    // }

    // public function Output_His_thp($well_id,$from_date, $to_date)
    // {
    //     $result = [];
    //     $conditions = [];
    //     if (!empty($well_id)) {
    //         $conditions['dl.well_id'] = $well_id;
    //     }

    //     if (!empty($from_date) && !empty($to_date)) {
    //         $queryStartTime = date('Y-m-d', strtotime($from_date)) . ' 06:00:00';

    //         $currentTime = date('Y-m-d', strtotime($to_date . ' +1 day')) . ' 06:00:00';
    //     }

    //     $historicalData = $this->fetchHisData(
    //         'tbl_historical_log_self_flow dl',
    //         'dl.Log_Date_Time as x,dl.THP as y',
    //         $queryStartTime,
    //         $currentTime,
    //         $conditions
    //     );

    //     return $historicalData;
        
    // }

    // public function Output_His_FLT($well_id,$from_date, $to_date)
    // {
    //     $result = [];
    //     $conditions = [];
    //     if (!empty($well_id)) {
    //         $conditions['dl.well_id'] = $well_id;
    //     }

    //     if (!empty($from_date) && !empty($to_date)) {
    //         $queryStartTime = date('Y-m-d', strtotime($from_date)) . ' 06:00:00';

    //         $currentTime = date('Y-m-d', strtotime($to_date . ' +1 day')) . ' 06:00:00';
    //     }
    //     $historicalData = $this->fetchHisData(
    //         'tbl_historical_log_self_flow dl',
    //         'dl.Log_Date_Time as x,dl.FLT as y',
    //         $queryStartTime,
    //         $currentTime,
    //         $conditions
    //     );

    //     return $historicalData;
        
    // }

    // public function output_His_battery($well_id,$from_date, $to_date)
    // {
    //     $result = [];
    //     $conditions = [];
    //     if (!empty($well_id)) {
    //         $conditions['dl.well_id'] = $well_id;
    //     }

    //     if (!empty($from_date) && !empty($to_date)) {
    //         $queryStartTime = date('Y-m-d', strtotime($from_date)) . ' 06:00:00';

    //         $currentTime = date('Y-m-d', strtotime($to_date . ' +1 day')) . ' 06:00:00';
    //     }
    //     $historicalData = $this->fetchHisData(
    //         'tbl_historical_log_self_flow dl',
    //         'dl.Log_Date_Time as x,dl.Battery_Voltage as y',
    //         $queryStartTime,
    //         $currentTime,
    //         $conditions
    //     );

    //     return $historicalData;
        
    // }


    // private function fetchHisData($table, $columns, $queryStartTime, $currentTime, $conditions)
    // {
    //     $this->db->select($columns);
    //     $this->db->from($table);

    //     // Time filter
    //     if (!empty($queryStartTime) && !empty($currentTime)) {
    //         $this->db->where('dl.Log_Date_Time >=', $queryStartTime);
    //         $this->db->where('dl.Log_Date_Time <=', $currentTime);
    //     }

    //     // Dynamic conditions
    //     if (!empty($conditions)) {
    //         foreach ($conditions as $key => $value) {
    //             $this->db->where($key, $value);
    //         }
    //     }

    //     $this->db->order_by('dl.Log_Date_Time', 'ASC');

    //     $query = $this->db->get();
    //     return $query->result_array(); // Return as array
    // }

    public function OutPut_historical_chp($well_id,$from_date,$to_date)
    {
        return $this->fetchHisDataFromCH(
            'tbl_historical_log_self_flow dl',
            'dl.Log_Date_Time as x, dl.CHP as y',
            $well_id,
            $from_date,
            $to_date
        );
    }

    public function Output_His_abp($well_id,$from_date,$to_date)
    {
        return $this->fetchHisDataFromCH(
            'tbl_historical_log_self_flow dl',
            'dl.Log_Date_Time as x, dl.ABP as y',
            $well_id,
            $from_date,
            $to_date
        );
    }

    public function Output_His_thp($well_id,$from_date,$to_date)
    {
        return $this->fetchHisDataFromCH(
            'tbl_historical_log_self_flow dl',
            'dl.Log_Date_Time as x, dl.THP as y',
            $well_id,
            $from_date,
            $to_date
        );
    }

    public function Output_His_FLT($well_id,$from_date,$to_date)
    {
        return $this->fetchHisDataFromCH(
            'tbl_historical_log_self_flow dl',
            'dl.Log_Date_Time as x, dl.FLT as y',
            $well_id,
            $from_date,
            $to_date
        );
    }

    public function output_His_battery($well_id,$from_date,$to_date)
    {
        return $this->fetchHisDataFromCH(
            'tbl_historical_log_self_flow dl',
            'dl.Log_Date_Time as x, dl.Battery_Voltage as y',
            $well_id,
            $from_date,
            $to_date
        );
    }

    /**
     * ✅ Universal function to fetch data from ClickHouse
     */
    private function fetchHisDataFromCH($table, $columns, $well_id, $from_date, $to_date)
    {
        $queryStartTime = '';
        $currentTime    = '';

        if (!empty($from_date) && !empty($to_date)) {
            $queryStartTime = date('Y-m-d', strtotime($from_date)) . ' 06:00:00';
            $currentTime    = date('Y-m-d', strtotime($to_date . ' +1 day')) . ' 06:00:00';
        }

        $where = [];
        if (!empty($queryStartTime) && !empty($currentTime)) {
            $where[] = "dl.Log_Date_Time >= '{$queryStartTime}' AND dl.Log_Date_Time <= '{$currentTime}'";
        }
        if (!empty($well_id)) {
            $where[] = "dl.well_id = '{$well_id}'";
        }

        $whereClause = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';

        $sql = "
            SELECT {$columns}
            FROM {$table}
            {$whereClause}
            ORDER BY dl.Log_Date_Time ASC
        ";

        $stmt = $this->client->select($sql);
        return $stmt->rows(); 
    }
}
?>
