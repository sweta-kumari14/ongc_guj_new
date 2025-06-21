<?php
   date_default_timezone_set('Asia/Kolkata');
class Selfflow_historical_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
  
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
        $deviceLogData = $this->fetchData(
            'tbl_device_log_self_flow',
            'well_id,PS_1_GIP,PS_2_CHP,PS_3_THP,PS_4_ABP,FLTP_1_Temp,Battery_Voltage,TRGT_Time,ON_Time,Off_Time,RTC_Time as Log_Date_Time',
            $queryStartTime,
            $currentTime,
            $conditions
        );

  
        $historicalData = $this->fetchData(
            'tbl_historical_log_self_flow',
            'well_id,PS_1_GIP,PS_2_CHP,PS_3_THP,PS_4_ABP,FLTP_1_Temp,Battery_Voltage,TRGT_Time,ON_Time,Off_Time,RTC_Time as Log_Date_Time',
            $queryStartTime,
            $currentTime, 
            $conditions
        );

   
       $combinedData = array_merge($historicalData, $deviceLogData);

        return $combinedData;
    }

    private function fetchData($table, $columns, $queryStartTime, $currentTime, $conditions)
    {
        $this->db->select($columns)
        ->from($table);
        if (!empty($queryStartTime) && !empty($currentTime)) {
            $this->db->where([
                'RTC_Time >=' => $queryStartTime,
                'RTC_Time <=' => $currentTime
            ]);
        }
        if (!empty($conditions)) {
            $this->db->where($conditions);
        }
        $this->db->order_by('RTC_Time','ASC');
        return $this->db->get()->result_array();
    }

    public function OutPut_historical_chp($well_id,$from_date,$to_date)
    {
        $result = [];
        $conditions = [];
        if (!empty($well_id)) {
            $conditions['dl.well_id'] = $well_id;
        }

        if (!empty($from_date) && !empty($to_date)) {
            if ($from_date == $to_date) {
                $currentTime = date('Y-m-d', strtotime($to_date . '+1 day')) . ' 06:00:00';
            } else {
                $currentTime = date('Y-m-d', strtotime($to_date)) . ' 06:00:00';
            }

             $queryStartTime = date('Y-m-d', strtotime($from_date)) . ' 06:00:00';
        }
        $deviceLogData = $this->fetchHisData(
            'tbl_device_log_self_flow dl',
            'wm.well_name,dl.RTC_Time as x,dl.PS_2_CHP as y',
            $queryStartTime,
            $currentTime,
            $conditions
        );
        $historicalData = $this->fetchHisData(
            'tbl_historical_log_self_flow dl',
            'wm.well_name,dl.RTC_Time as x,dl.PS_2_CHP as y',
            $queryStartTime,
            $currentTime,
            $conditions
        );

        $result['output_chp'] = array_merge($historicalData, $deviceLogData);

        return $result;
        
    }

    public function Output_His_thp($well_id,$from_date, $to_date)
    {
        $result = [];
        $conditions = [];
        if (!empty($well_id)) {
            $conditions['dl.well_id'] = $well_id;
        }

        if (!empty($from_date) && !empty($to_date)) {
            if ($from_date == $to_date) {
                $currentTime = date('Y-m-d', strtotime($to_date . '+1 day')) . ' 06:00:00';
            } else {
                $currentTime = date('Y-m-d', strtotime($to_date)) . ' 06:00:00';
            }

             $queryStartTime = date('Y-m-d', strtotime($from_date)) . ' 06:00:00';
        }
        $deviceLogData = $this->fetchHisData(
            'tbl_device_log_self_flow dl',
            'wm.well_name,dl.RTC_Time as x,dl.PS_3_THP as y',
            $queryStartTime,
            $currentTime,
            $conditions
        );
        $historicalData = $this->fetchHisData(
            'tbl_historical_log_self_flow dl',
            'wm.well_name,dl.RTC_Time as x,dl.PS_3_THP as y',
            $queryStartTime,
            $currentTime,
            $conditions
        );

        $result['output_thp'] = array_merge($historicalData, $deviceLogData);

        return $result;
        
    }

    public function Output_His_abp($well_id,$from_date, $to_date)
    {
        $result = [];
        $conditions = [];
        if (!empty($well_id)) {
            $conditions['dl.well_id'] = $well_id;
        }

        if (!empty($from_date) && !empty($to_date)) {
            if ($from_date == $to_date) {
                $currentTime = date('Y-m-d', strtotime($to_date . '+1 day')) . ' 06:00:00';
            } else {
                $currentTime = date('Y-m-d', strtotime($to_date)) . ' 06:00:00';
            }

             $queryStartTime = date('Y-m-d', strtotime($from_date)) . ' 06:00:00';
        }
        $deviceLogData = $this->fetchHisData(
            'tbl_device_log_self_flow dl',
            'wm.well_name,dl.RTC_Time as x,dl.PS_4_ABP as y',
            $queryStartTime,
            $currentTime,
            $conditions
        );
        $historicalData = $this->fetchHisData(
            'tbl_historical_log_self_flow dl',
            'wm.well_name,dl.RTC_Time as x,dl.PS_4_ABP as y',
            $queryStartTime,
            $currentTime,
            $conditions
        );

        $result['output_abp'] = array_merge($historicalData, $deviceLogData);

        return $result;
        
    }

    public function Output_His_gip($well_id,$from_date, $to_date)
    {
        $result = [];
        $conditions = [];
        if (!empty($well_id)) {
            $conditions['dl.well_id'] = $well_id;
        }

        if (!empty($from_date) && !empty($to_date)) {
            if ($from_date == $to_date) {
                $currentTime = date('Y-m-d', strtotime($to_date . '+1 day')) . ' 06:00:00';
            } else {
                $currentTime = date('Y-m-d', strtotime($to_date)) . ' 06:00:00';
            }

             $queryStartTime = date('Y-m-d', strtotime($from_date)) . ' 06:00:00';
        }
        $deviceLogData = $this->fetchHisData(
            'tbl_device_log_self_flow dl',
            'wm.well_name,dl.RTC_Time as x,dl.PS_1_GIP as y',
            $queryStartTime,
            $currentTime,
            $conditions
        );
        $historicalData = $this->fetchHisData(
            'tbl_historical_log_self_flow dl',
            'wm.well_name,dl.RTC_Time as x,dl.PS_1_GIP as y',
            $queryStartTime,
            $currentTime,
            $conditions
        );

        $result['output_gip'] = array_merge($historicalData, $deviceLogData);

        return $result;
        
    }

    public function Output_His_tht($well_id,$from_date, $to_date)
    {
        $result = [];
        $conditions = [];
        if (!empty($well_id)) {
            $conditions['dl.well_id'] = $well_id;
        }

        if (!empty($from_date) && !empty($to_date)) {
            if ($from_date == $to_date) {
                $currentTime = date('Y-m-d', strtotime($to_date . '+1 day')) . ' 06:00:00';
            } else {
                $currentTime = date('Y-m-d', strtotime($to_date)) . ' 06:00:00';
            }

             $queryStartTime = date('Y-m-d', strtotime($from_date)) . ' 06:00:00';
        }
        $deviceLogData = $this->fetchHisData(
            'tbl_device_log_self_flow dl',
            'wm.well_name,dl.RTC_Time as x,dl.FLTP_1_Temp as y',
            $queryStartTime,
            $currentTime,
            $conditions
        );
        $historicalData = $this->fetchHisData(
            'tbl_historical_log_self_flow dl',
            'wm.well_name,dl.RTC_Time as x,dl.FLTP_1_Temp as y',
            $queryStartTime,
            $currentTime,
            $conditions
        );

        $result['output_tht'] = array_merge($historicalData, $deviceLogData);

        return $result;
        
    }
    public function output_His_battery($well_id,$from_date, $to_date)
    {
        $result = [];
        $conditions = [];
        if (!empty($well_id)) {
            $conditions['dl.well_id'] = $well_id;
        }

        if (!empty($from_date) && !empty($to_date)) {
            if ($from_date == $to_date) {
                $currentTime = date('Y-m-d', strtotime($to_date . '+1 day')) . ' 06:00:00';
            } else {
                $currentTime = date('Y-m-d', strtotime($to_date)) . ' 06:00:00';
            }

             $queryStartTime = date('Y-m-d', strtotime($from_date)) . ' 06:00:00';
        }
        $deviceLogData = $this->fetchHisData(
            'tbl_device_log_self_flow dl',
            'wm.well_name,dl.RTC_Time as x,dl.Battery_Voltage as y',
            $queryStartTime,
            $currentTime,
            $conditions
        );
        $historicalData = $this->fetchHisData(
            'tbl_historical_log_self_flow dl',
            'wm.well_name,dl.RTC_Time as x,dl.Battery_Voltage as y',
            $queryStartTime,
            $currentTime,
            $conditions
        );

        $result['output_battery'] = array_merge($historicalData, $deviceLogData);

        return $result;
        
    }

    private function fetchHisData($table, $columns, $queryStartTime, $currentTime, $conditions)
    {
        $this->db->select($columns)
        ->from($table)
        ->join('tbl_well_master wm', 'wm.id = dl.well_id', 'left');

        if (!empty($queryStartTime) && !empty($currentTime)) {
            $this->db->where([
                'dl.RTC_Time >=' => $queryStartTime,
                'dl.RTC_Time <=' => $currentTime
            ]);
        }

        if (!empty($conditions)) {
            $this->db->where($conditions);
        }

        return $this->db->get()->result_array();
    }

}
?>