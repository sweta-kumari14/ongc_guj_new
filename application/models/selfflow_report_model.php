<?php
   date_default_timezone_set('Asia/Kolkata');
class selfflow_report_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
  public function date_wise_Alert_Report($well_id,$date)
    {
        
        if($well_id!='')
            $this->db->where('sd.well_id',$well_id);
      
        $from_date = date('Y-m-d 06:00:00', strtotime($date));
        $to_date = date('Y-m-d 06:00:00', strtotime($date . '+1 day'));

        return $this->db->select("sd.id,sd.well_id,wm.well_name,tl.imei_no,sd.device_name,tl.alert_type,tl.alert_details,tl.alert_date_time,ws.well_site_name")
        ->from('tbl_site_device_installtion_self_flow sd')
        ->join('tbl_alert_log_self_flow tl','tl.well_id=sd.well_id','left')
        ->join('tbl_well_master wm','sd.well_id=wm.id','left')
        ->join('tbl_well_site_master ws','sd.site_id=ws.id','left')
        ->where('tl.alert_date_time >=', $from_date)
        ->where('tl.alert_date_time <', $to_date)
        ->where('sd.status',1)->get()->result_array();
       
    }

   
    public function Well_wise_Alert_Report($well_id,$from_date, $to_date, $user_id,$sort_by)
    {
        if ($well_id != '') {
            $this->db->where('sd.well_id', $well_id);
        }
        
        if ($from_date != '' && $to_date != '') {
            $fromTime = date('Y-m-d 06:00:00', strtotime($from_date));
            if ($from_date == $to_date) {
                $toTime = date('Y-m-d 06:00:00', strtotime($to_date . '+1 day'));
            } else {
                $toTime = date('Y-m-d 06:00:00', strtotime($to_date));
            }

            $this->db->where('tl.alert_date_time >=', $fromTime);
            $this->db->where('tl.alert_date_time <=', $toTime);
        }

        if ($user_id != '') {
            $this->db->where('ad.user_id',$user_id);
           
        }

        if ($sort_by != '') {
            $this->db->order_by($sort_by,'ASC');
           
        }

       return   $this->db->select("tl.id,tl.alert_type,tl.alert_details,tl.alert_date_time,sd.well_id,wm.well_name,tl.imei_no,sd.device_name,ws.well_site_name")
            
            ->from('tbl_site_device_installtion_self_flow sd')
            ->join('tbl_alert_log_self_flow tl','tl.well_id=sd.well_id', 'left')
            ->join('tbl_well_master wm', 'wm.id=sd.well_id', 'left')
            ->join('tbl_role_wise_user_assign_details ad', 'sd.well_id = ad.well_id', 'left')
            ->join('tbl_well_site_master ws','sd.site_id=ws.id and ws.status=1','left')
            ->where(['sd.status' => 1,'wm.status'=>1,'ad.status'=>1])
            ->group_by('tl.id')
            ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
            ->get()->result_array();
    }

    public function Well_Wise_Total_Alert($well_id,$imei_no)
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

        $res = $this->db->select("count(al.imei_no) as total")
        ->from('tbl_alert_log_self_flow al')
        ->join('tbl_site_device_installtion_self_flow sd','sd.imei_no=al.imei_no and al.status=1','left')
        ->where(['sd.status'=>1,'al.c_date >='=> $from_date, 'al.c_date <='=> $to_date])->get()->result_array();
        if($res!='')
        {
            return $res[0]['total'];
        }else{
            return 0;
        }
       
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