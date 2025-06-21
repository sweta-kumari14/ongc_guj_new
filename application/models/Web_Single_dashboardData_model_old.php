<?php
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

  
    // public function OutPut_Neutral_Voltage($well_id,$imei_no,$hours)
    // {
        
    //     $timeRangeStart = date('Y-m-d H:i:s', strtotime("-$hours hours"));

    //     $result = [];

    //     if($well_id!='')
    //         $this->db->where('well_id',$well_id);

    //     if($imei_no!='')
    //         $this->db->where('imei_no',$imei_no);

    //     $result['output_n_R']=$this->db->select("last_log_datetime  as x,output_Voltage_L2N_R as y")
    //     ->from('tbl_device_log')
    //     ->where(['last_log_datetime >='=>$timeRangeStart])->order_by('last_log_datetime ','ASC')->get()->result_array();

    //     // ================================================================

    //     if($well_id!='')
    //         $this->db->where('well_id',$well_id);

    //     if($imei_no!='')
    //         $this->db->where('imei_no',$imei_no);

    //     $result['output_n_Y']=$this->db->select("last_log_datetime  as x,output_Voltage_L2N_Y as y")
    //     ->from('tbl_device_log')
    //     ->where(['last_log_datetime >='=>$timeRangeStart])->order_by('last_log_datetime ','ASC')->get()->result_array();

    //     // ===============================================================

    //     if($well_id!='')
    //         $this->db->where('well_id',$well_id);

    //     if($imei_no!='')
    //         $this->db->where('imei_no',$imei_no);

    //     $result['output_n_B']=$this->db->select("last_log_datetime  as x,output_Voltage_L2N_B as y")
    //     ->from('tbl_device_log')
    //     ->where(['last_log_datetime >='=>$timeRangeStart])->order_by('last_log_datetime ','ASC')->get()->result_array();

    //     // ==============================================================

    //     if($well_id!='')
    //         $this->db->where('well_id',$well_id);

    //     if($imei_no!='')
    //         $this->db->where('imei_no',$imei_no);

    //     $result['output_n_Avg']=$this->db->select("last_log_datetime  as x,output_Average_Voltage_L2N as y")
    //     ->from('tbl_device_log')
    //     ->where(['last_log_datetime >='=>$timeRangeStart])->order_by('last_log_datetime ','ASC')->get()->result_array();

    //     return $result;
        
    // }

   
    // public function OutputLine_to_Line_Voltage($well_id,$imei_no,$hours)
    // {

    //     $timeRangeStart = date('Y-m-d H:i:s', strtotime("-$hours hours"));

    //     $result = [];

    //     if($well_id!='')
    //         $this->db->where('well_id',$well_id);

    //     if($imei_no!='')
    //         $this->db->where('imei_no',$imei_no);

    //     $result['output_v_R']=$this->db->select("last_log_datetime  as x,output_Voltage_P2P_RY as y")
    //     ->from('tbl_device_log')
    //     ->where(['last_log_datetime >='=>$timeRangeStart])->order_by('last_log_datetime ','ASC')->get()->result_array();

    //     // ===========================================================

    //     if($well_id!='')
    //         $this->db->where('well_id',$well_id);

    //     if($imei_no!='')
    //         $this->db->where('imei_no',$imei_no);

    //     $result['output_v_Y']=$this->db->select("last_log_datetime  as x,output_Voltage_P2P_YB as y")
    //     ->from('tbl_device_log')
    //     ->where(['last_log_datetime >='=>$timeRangeStart])->order_by('last_log_datetime ','ASC')->get()->result_array();

    //     // =============================================================

    //     if($well_id!='')
    //         $this->db->where('well_id',$well_id);

    //     if($imei_no!='')
    //         $this->db->where('imei_no',$imei_no);

    //     $result['output_v_B']=$this->db->select("last_log_datetime  as x,output_Voltage_P2P_BR as y")
    //     ->from('tbl_device_log')
    //     ->where(['last_log_datetime >='=>$timeRangeStart])->order_by('last_log_datetime ','ASC')->get()->result_array();

    //     // ===============================================================

    //     if($well_id!='')
    //         $this->db->where('well_id',$well_id);

    //     if($imei_no!='')
    //         $this->db->where('imei_no',$imei_no);

    //     $result['output_v_Avg']=$this->db->select("last_log_datetime  as x,output_Average_Voltage_P2P as y")
    //     ->from('tbl_device_log')
    //     ->where(['last_log_datetime >='=>$timeRangeStart])->order_by('last_log_datetime ','ASC')->get()->result_array();

    //     return $result;
        
    // }

   

    // public function WellOutput_Current($well_id,$imei_no,$hours)
    // {

    //     $timeRangeStart = date('Y-m-d H:i:s', strtotime("-$hours hours"));

    //     $result = [];

    //     if($well_id!='')
    //         $this->db->where('well_id',$well_id);

    //     if($imei_no!='')
    //         $this->db->where('imei_no',$imei_no);

    //     $result['output_i_R']=$this->db->select("last_log_datetime as x,output_Current_R as y")
    //     ->from('tbl_device_log')
    //     ->where(['last_log_datetime>='=>$timeRangeStart])->order_by('last_log_datetime','ASC')->get()->result_array();

    //     // ===================================================================

    //     if($well_id!='')
    //         $this->db->where('well_id',$well_id);

    //     if($imei_no!='')
    //         $this->db->where('imei_no',$imei_no);

    //     $result['output_i_Y']=$this->db->select("last_log_datetime as x,output_Current_Y as y")
    //      ->from('tbl_device_log')
    //     ->where(['last_log_datetime>='=>$timeRangeStart])->order_by('last_log_datetime','ASC')->get()->result_array();

    //     // ==================================================================

    //     if($well_id!='')
    //         $this->db->where('well_id',$well_id);

    //     if($imei_no!='')
    //         $this->db->where('imei_no',$imei_no);

    //     $result['output_i_B']=$this->db->select("last_log_datetime as x,output_Current_B as y")
    //      ->from('tbl_device_log')
    //     ->where(['last_log_datetime>='=>$timeRangeStart])->order_by('last_log_datetime','ASC')->get()->result_array();

    //     // ==============================================================

    //     if($well_id!='')
    //         $this->db->where('well_id',$well_id);

    //     if($imei_no!='')
    //         $this->db->where('imei_no',$imei_no);

    //     $result['output_i_Avg']=$this->db->select("last_log_datetime as x,output_Average_Current as y")
    //      ->from('tbl_device_log')
    //     ->where(['last_log_datetime>='=>$timeRangeStart])->order_by('last_log_datetime','ASC')->get()->result_array();

    //     return $result;
        
    // }

    public function OutPut_Neutral_Voltage($well_id,$imei_no,$hours)
    {
        
        $timeRangeStart = date('Y-m-d H:i:s', strtotime("-$hours hours"));

        $result = [];

        if ($hours == 1) {
            $table_name = 'tbl_device_log';            
        } else {
             $table_name = 'tbl_historical_device_log';
        }

        if($well_id!='')
            $this->db->where('well_id',$well_id);

        if($imei_no!='')
            $this->db->where('imei_no',$imei_no);

        $result['output_n_R']=$this->db->select("last_log_datetime  as x,output_Voltage_L2N_R as y")
        ->from($table_name)
        ->where(['last_log_datetime >='=>$timeRangeStart])->order_by('last_log_datetime ','ASC')->get()->result_array();

        // ================================================================

        if($well_id!='')
            $this->db->where('well_id',$well_id);

        if($imei_no!='')
            $this->db->where('imei_no',$imei_no);

        $result['output_n_Y']=$this->db->select("last_log_datetime  as x,output_Voltage_L2N_Y as y")
        ->from($table_name)
        ->where(['last_log_datetime >='=>$timeRangeStart])->order_by('last_log_datetime ','ASC')->get()->result_array();

        // ===============================================================

        if($well_id!='')
            $this->db->where('well_id',$well_id);

        if($imei_no!='')
            $this->db->where('imei_no',$imei_no);

        $result['output_n_B']=$this->db->select("last_log_datetime  as x,output_Voltage_L2N_B as y")
        ->from($table_name)
        ->where(['last_log_datetime >='=>$timeRangeStart])->order_by('last_log_datetime ','ASC')->get()->result_array();

        // ==============================================================

        if($well_id!='')
            $this->db->where('well_id',$well_id);

        if($imei_no!='')
            $this->db->where('imei_no',$imei_no);

        $result['output_n_Avg']=$this->db->select("last_log_datetime  as x,output_Average_Voltage_L2N as y")
        ->from($table_name)
        ->where(['last_log_datetime >='=>$timeRangeStart])->order_by('last_log_datetime ','ASC')->get()->result_array();

        return $result;
        
    }

    public function OutputLine_to_Line_Voltage($well_id,$imei_no,$hours)
    {

        $timeRangeStart = date('Y-m-d H:i:s', strtotime("-$hours hours"));

        $result = [];

        if ($hours == 1) {
            $table_name = 'tbl_device_log';
        } else {
            $table_name = 'tbl_historical_device_log';
        }

        if($well_id!='')
            $this->db->where('well_id',$well_id);

        if($imei_no!='')
            $this->db->where('imei_no',$imei_no);

        $result['output_v_R']=$this->db->select("last_log_datetime  as x,output_Voltage_P2P_RY as y")
        ->from($table_name)
        ->where(['last_log_datetime >='=>$timeRangeStart])->order_by('last_log_datetime ','ASC')->get()->result_array();

        // ===========================================================

        if($well_id!='')
            $this->db->where('well_id',$well_id);

        if($imei_no!='')
            $this->db->where('imei_no',$imei_no);

        $result['output_v_Y']=$this->db->select("last_log_datetime  as x,output_Voltage_P2P_YB as y")
        ->from($table_name)
        ->where(['last_log_datetime >='=>$timeRangeStart])->order_by('last_log_datetime ','ASC')->get()->result_array();

        // =============================================================

        if($well_id!='')
            $this->db->where('well_id',$well_id);

        if($imei_no!='')
            $this->db->where('imei_no',$imei_no);

        $result['output_v_B']=$this->db->select("last_log_datetime  as x,output_Voltage_P2P_BR as y")
        ->from($table_name)
        ->where(['last_log_datetime >='=>$timeRangeStart])->order_by('last_log_datetime ','ASC')->get()->result_array();

        // ===============================================================

        if($well_id!='')
            $this->db->where('well_id',$well_id);

        if($imei_no!='')
            $this->db->where('imei_no',$imei_no);

        $result['output_v_Avg']=$this->db->select("last_log_datetime  as x,output_Average_Voltage_P2P as y")
        ->from($table_name)
        ->where(['last_log_datetime >='=>$timeRangeStart])->order_by('last_log_datetime ','ASC')->get()->result_array();

        return $result;
        
    }

    public function WellOutput_Current($well_id,$imei_no,$hours)
    {

        $timeRangeStart = date('Y-m-d H:i:s', strtotime("-$hours hours"));

        $result = [];

        if ($hours == 1) {
            $table_name = 'tbl_device_log';
        } else {
            $table_name = 'tbl_historical_device_log';
        }

        if($well_id!='')
            $this->db->where('well_id',$well_id);

        if($imei_no!='')
            $this->db->where('imei_no',$imei_no);

        $result['output_i_R']=$this->db->select("last_log_datetime as x,output_Current_R as y")
        ->from($table_name)
        ->where(['last_log_datetime>='=>$timeRangeStart])->order_by('last_log_datetime','ASC')->get()->result_array();

        // ===================================================================

        if($well_id!='')
            $this->db->where('well_id',$well_id);

        if($imei_no!='')
            $this->db->where('imei_no',$imei_no);

        $result['output_i_Y']=$this->db->select("last_log_datetime as x,output_Current_Y as y")
         ->from($table_name)
        ->where(['last_log_datetime>='=>$timeRangeStart])->order_by('last_log_datetime','ASC')->get()->result_array();

        // ==================================================================

        if($well_id!='')
            $this->db->where('well_id',$well_id);

        if($imei_no!='')
            $this->db->where('imei_no',$imei_no);

        $result['output_i_B']=$this->db->select("last_log_datetime as x,output_Current_B as y")
         ->from($table_name)
        ->where(['last_log_datetime>='=>$timeRangeStart])->order_by('last_log_datetime','ASC')->get()->result_array();

        // ==============================================================

        if($well_id!='')
            $this->db->where('well_id',$well_id);

        if($imei_no!='')
            $this->db->where('imei_no',$imei_no);

        $result['output_i_Avg']=$this->db->select("last_log_datetime as x,output_Average_Current as y")
         ->from($table_name)
        ->where(['last_log_datetime>='=>$timeRangeStart])->order_by('last_log_datetime','ASC')->get()->result_array();

        return $result;
        
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
