<?php
class Single_dashboard_AllData_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}


   

	public function Single_Well_DeviceData($well_id,$imei_no)
    {
        
        if($well_id!='')
            $this->db->where('sd.well_id',$well_id);
        if($imei_no!='')
            $this->db->where('sd.imei_no',$imei_no);

        return $this->db->select("dl.*,dl.offline_device_timestamp as last_date_time")
        ->from('tbl_site_device_installation sd')
        ->join('tbl_device_log dl','sd.imei_no=dl.imei_no','left')
        ->where('sd.status',1)->order_by('dl.id','desc')->limit(1)->get()->result_array();
       
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
        ->where(['sd.status'=>1,'tl.c_date >='=> $from_date,'tl.c_date <='=> $to_date])->get()->result_array();
        if($res!='')
        {
            return $res[0]['total'];
        }else{
            return 0;
        }
       
    }

    public function WellFrequency_Details($well_id,$imei_no,$hours)
    {

        $currentTime = date('Y-m-d H:i:s');
        $timeRangeStart = date('Y-m-d H:i:s', strtotime("-$hours hours"));

        $result = [];

        

        if($well_id!='')
            $this->db->where('di.well_id',$well_id);
        if($imei_no!='')
            $this->db->where('dl.imei_no',$imei_no);
        $result['output']=$this->db->select("DATE_FORMAT(dl.offline_device_timestamp, '%H:%i:%s') as x,dl.output_System_Frequency as y")
        ->from('tbl_device_log dl')
        ->join('tbl_site_device_installation di', 'di.imei_no = dl.imei_no', 'left')
        ->where(['dl.status' => 1,'dl.offline_device_timestamp >='=>$timeRangeStart,'dl.offline_device_timestamp <='=>$currentTime])->order_by('dl.offline_device_timestamp ')->get()->result_array();

        return $result;

         
    }

    public function Well_Active_EnergyDetails($well_id,$imei_no,$hours)
    {
        
        $currentTime = date('Y-m-d H:i:s');
        $timeRangeStart = date('Y-m-d H:i:s', strtotime("-$hours hours"));

        $result = [];

        

        if($well_id!='')
            $this->db->where('di.well_id',$well_id);
        if($imei_no!='')
            $this->db->where('dl.imei_no',$imei_no);
        $result['output']=$this->db->select("DATE_FORMAT(dl.offline_device_timestamp, '%H:%i:%s') as x,dl.output_Kwh as y")
        ->from('tbl_device_log dl')
        ->join('tbl_site_device_installation di', 'di.imei_no = dl.imei_no', 'left')
        ->where(['dl.status' => 1,'dl.offline_device_timestamp >='=>$timeRangeStart,'dl.offline_device_timestamp <='=>$currentTime])->order_by('dl.offline_device_timestamp ')->get()->result_array();

        return $result;
        
    }

    

    public function OutPut_Neutral_Voltage($well_id,$imei_no,$hours)
    {
        
        $currentTime = date('Y-m-d H:i:s');
        $timeRangeStart = date('Y-m-d H:i:s', strtotime("-$hours hours"));

        $result = [];

        if($well_id!='')
            $this->db->where('di.well_id',$well_id);
        if($imei_no!='')
            $this->db->where('dl.imei_no',$imei_no);

        $result['output_n_R']=$this->db->select("DATE_FORMAT(dl.offline_device_timestamp, '%H:%i:%s') as x,dl.output_Voltage_L2N_R as y")
        ->from('tbl_device_log dl')
        ->join('tbl_site_device_installation di', 'di.imei_no = dl.imei_no', 'left')
        ->where(['dl.status' => 1,'dl.offline_device_timestamp >='=>$timeRangeStart,'dl.offline_device_timestamp <='=>$currentTime])->order_by('dl.offline_device_timestamp ')->get()->result_array();

        if($well_id!='')
            $this->db->where('di.well_id',$well_id);
        if($imei_no!='')
            $this->db->where('dl.imei_no',$imei_no);
        $result['output_n_Y']=$this->db->select("DATE_FORMAT(dl.offline_device_timestamp, '%H:%i:%s') as x,dl.output_Voltage_L2N_Y as y")
        ->from('tbl_device_log dl')
        ->join('tbl_site_device_installation di', 'di.imei_no = dl.imei_no', 'left')
        ->where(['dl.status' => 1,'dl.offline_device_timestamp >='=>$timeRangeStart,'dl.offline_device_timestamp <='=>$currentTime])->order_by('dl.offline_device_timestamp')->get()->result_array();

        if($well_id!='')
            $this->db->where('di.well_id',$well_id);
        if($imei_no!='')
            $this->db->where('dl.imei_no',$imei_no);
        $result['output_n_B']=$this->db->select("DATE_FORMAT(dl.offline_device_timestamp, '%H:%i:%s') as x,dl.output_Voltage_L2N_B as y")
        ->from('tbl_device_log dl')
        ->join('tbl_site_device_installation di', 'di.imei_no = dl.imei_no', 'left')
        ->where(['dl.status' => 1,'dl.offline_device_timestamp >='=>$timeRangeStart,'dl.offline_device_timestamp <='=>$currentTime])->order_by('dl.offline_device_timestamp')->get()->result_array();

        if($well_id!='')
            $this->db->where('di.well_id',$well_id);
        if($imei_no!='')
            $this->db->where('dl.imei_no',$imei_no);
        $result['output_n_Avg']=$this->db->select("DATE_FORMAT(dl.offline_device_timestamp, '%H:%i:%s') as x,dl.output_Average_Voltage_L2N as y")
        ->from('tbl_device_log dl')
        ->join('tbl_site_device_installation di', 'di.imei_no = dl.imei_no', 'left')
        ->where(['dl.status' => 1,'dl.offline_device_timestamp >='=>$timeRangeStart,'dl.offline_device_timestamp <='=>$currentTime])->order_by('dl.offline_device_timestamp')->get()->result_array();

        return $result;
        
    }

   

    public function OutputLine_to_Line_Voltage($well_id,$imei_no,$hours)
    {
        
        $currentTime = date('Y-m-d H:i:s');
        $timeRangeStart = date('Y-m-d H:i:s', strtotime("-$hours hours"));

        $result = [];

        if($well_id!='')
            $this->db->where('di.well_id',$well_id);
        if($imei_no!='')
            $this->db->where('dl.imei_no',$imei_no);

        $result['output_v_R']=$this->db->select("DATE_FORMAT(dl.offline_device_timestamp, '%H:%i:%s') as x,dl.output_Voltage_P2P_RY as y")
        ->from('tbl_device_log dl')
        ->join('tbl_site_device_installation di', 'di.imei_no = dl.imei_no', 'left')
        ->where(['dl.status' => 1,'dl.offline_device_timestamp >='=>$timeRangeStart,'dl.offline_device_timestamp <='=>$currentTime])->order_by('dl.offline_device_timestamp')->get()->result_array();

        if($well_id!='')
            $this->db->where('di.well_id',$well_id);
        if($imei_no!='')
            $this->db->where('dl.imei_no',$imei_no);
        $result['output_v_Y']=$this->db->select("DATE_FORMAT(dl.offline_device_timestamp, '%H:%i:%s') as x,dl.output_Voltage_P2P_YB as y")
        ->from('tbl_device_log dl')
        ->join('tbl_site_device_installation di', 'di.imei_no = dl.imei_no', 'left')
        ->where(['dl.status' => 1,'dl.offline_device_timestamp >='=>$timeRangeStart,'dl.offline_device_timestamp <='=>$currentTime])->order_by('dl.offline_device_timestamp')->get()->result_array();

        if($well_id!='')
            $this->db->where('di.well_id',$well_id);
        if($imei_no!='')
            $this->db->where('dl.imei_no',$imei_no);
        $result['output_v_B']=$this->db->select("DATE_FORMAT(dl.offline_device_timestamp, '%H:%i:%s') as x,dl.output_Voltage_P2P_BR as y")
        ->from('tbl_device_log dl')
        ->join('tbl_site_device_installation di', 'di.imei_no = dl.imei_no', 'left')
        ->where(['dl.status' => 1,'dl.offline_device_timestamp >='=>$timeRangeStart,'dl.offline_device_timestamp <='=>$currentTime])->order_by('dl.offline_device_timestamp')->get()->result_array();

        if($well_id!='')
            $this->db->where('di.well_id',$well_id);
        if($imei_no!='')
            $this->db->where('dl.imei_no',$imei_no);
        $result['output_v_Avg']=$this->db->select("DATE_FORMAT(dl.offline_device_timestamp, '%H:%i:%s') as x,dl.output_Average_Voltage_P2P as y")
        ->from('tbl_device_log dl')
        ->join('tbl_site_device_installation di', 'di.imei_no = dl.imei_no', 'left')
        ->where(['dl.status' => 1,'dl.offline_device_timestamp >='=>$timeRangeStart,'dl.offline_device_timestamp <='=>$currentTime])->order_by('dl.offline_device_timestamp')->get()->result_array();

        return $result;
        
    }

    public function WellInput_Current($well_id,$imei_no,$hours)
    {
        
        $currentTime = date('Y-m-d H:i:s');
        $timeRangeStart = date('Y-m-d H:i:s', strtotime("-$hours hours"));

        $result = [];

        if($well_id!='')
            $this->db->where('di.well_id',$well_id);
        if($imei_no!='')
            $this->db->where('dl.imei_no',$imei_no);

        $result['input_i_R']=$this->db->select("DATE_FORMAT(dl.offline_device_timestamp, '%H:%i:%s') as x,dl.input_Current_R as y")
        ->from('tbl_device_log dl')
        ->join('tbl_site_device_installation di', 'di.imei_no = dl.imei_no', 'left')
        ->where(['dl.status' => 1,'dl.offline_device_timestamp >='=>$timeRangeStart,'dl.offline_device_timestamp <='=>$currentTime])->order_by('dl.offline_device_timestamp')->get()->result_array();

        if($well_id!='')
            $this->db->where('di.well_id',$well_id);
        if($imei_no!='')
            $this->db->where('dl.imei_no',$imei_no);
        $result['input_i_Y']=$this->db->select("DATE_FORMAT(dl.offline_device_timestamp, '%H:%i:%s') as x,dl.input_Current_Y as y")
        ->from('tbl_device_log dl')
        ->join('tbl_site_device_installation di', 'di.imei_no = dl.imei_no', 'left')
        ->where(['dl.status' => 1,'dl.offline_device_timestamp >='=>$timeRangeStart,'dl.offline_device_timestamp <='=>$currentTime])->order_by('dl.offline_device_timestamp')->get()->result_array();

        if($well_id!='')
            $this->db->where('di.well_id',$well_id);
        if($imei_no!='')
            $this->db->where('dl.imei_no',$imei_no);
        $result['input_i_B']=$this->db->select("DATE_FORMAT(dl.offline_device_timestamp, '%H:%i:%s') as x,dl.input_Current_B as y")
        ->from('tbl_device_log dl')
        ->join('tbl_site_device_installation di', 'di.imei_no = dl.imei_no', 'left')
        ->where(['dl.status' => 1,'dl.offline_device_timestamp >='=>$timeRangeStart,'dl.offline_device_timestamp <='=>$currentTime])->order_by('dl.offline_device_timestamp')->get()->result_array();

        
        return $result;
        
    }

    public function WellOutput_Current($well_id,$imei_no,$hours)
    {
        
        $currentTime = date('Y-m-d H:i:s');
        $timeRangeStart = date('Y-m-d H:i:s', strtotime("-$hours hours"));

        $result = [];

        if($well_id!='')
            $this->db->where('di.well_id',$well_id);
        if($imei_no!='')
            $this->db->where('dl.imei_no',$imei_no);

        $result['output_i_R']=$this->db->select("DATE_FORMAT(dl.offline_device_timestamp, '%H:%i:%s') as x,dl.output_Current_R as y")
        ->from('tbl_device_log dl')
        ->join('tbl_site_device_installation di', 'di.imei_no = dl.imei_no', 'left')
        ->where(['dl.status' => 1,'dl.offline_device_timestamp >='=>$timeRangeStart,'dl.offline_device_timestamp <='=>$currentTime])->order_by('dl.offline_device_timestamp')->get()->result_array();

        if($well_id!='')
            $this->db->where('di.well_id',$well_id);
        if($imei_no!='')
            $this->db->where('dl.imei_no',$imei_no);
        $result['output_i_Y']=$this->db->select("DATE_FORMAT(dl.offline_device_timestamp, '%H:%i:%s') as x,dl.output_Current_Y as y")
        ->from('tbl_device_log dl')
        ->join('tbl_site_device_installation di', 'di.imei_no = dl.imei_no', 'left')
        ->where(['dl.status' => 1,'dl.offline_device_timestamp >='=>$timeRangeStart,'dl.offline_device_timestamp <='=>$currentTime])->order_by('dl.offline_device_timestamp')->get()->result_array();

        if($well_id!='')
            $this->db->where('di.well_id',$well_id);
        if($imei_no!='')
            $this->db->where('dl.imei_no',$imei_no);
        $result['output_i_B']=$this->db->select("DATE_FORMAT(dl.offline_device_timestamp, '%H:%i:%s') as x,dl.output_Current_B as y")
        ->from('tbl_device_log dl')
        ->join('tbl_site_device_installation di', 'di.imei_no = dl.imei_no', 'left')
        ->where(['dl.status' => 1,'dl.offline_device_timestamp >='=>$timeRangeStart,'dl.offline_device_timestamp <='=>$currentTime])->order_by('dl.offline_device_timestamp')->get()->result_array();

        if($well_id!='')
            $this->db->where('di.well_id',$well_id);
        if($imei_no!='')
            $this->db->where('dl.imei_no',$imei_no);
        $result['output_i_Avg']=$this->db->select("DATE_FORMAT(dl.offline_device_timestamp, '%H:%i:%s') as x,dl.output_Average_Current as y")
        ->from('tbl_device_log dl')
        ->join('tbl_site_device_installation di', 'di.imei_no = dl.imei_no', 'left')
        ->where(['dl.status' => 1,'dl.offline_device_timestamp >='=>$timeRangeStart,'dl.offline_device_timestamp <='=>$currentTime])->order_by('dl.offline_device_timestamp')->get()->result_array();

        return $result;
        
    }

    public function Well_Active_power($well_id,$imei_no,$hours)
    {
        
        $currentTime = date('Y-m-d H:i:s');
        $timeRangeStart = date('Y-m-d H:i:s', strtotime("-$hours hours"));

        $result = [];

        

        if($well_id!='')
            $this->db->where('di.well_id',$well_id);
        if($imei_no!='')
            $this->db->where('dl.imei_no',$imei_no);
        $result['output_power']=$this->db->select("DATE_FORMAT(dl.offline_device_timestamp, '%H:%i:%s') as x,dl.output_System_Running_KW as y")
        ->from('tbl_device_log dl')
        ->join('tbl_site_device_installation di', 'di.imei_no = dl.imei_no', 'left')
        ->where(['dl.status' => 1,'dl.offline_device_timestamp >='=>$timeRangeStart,'dl.offline_device_timestamp <='=>$currentTime])->order_by('dl.offline_device_timestamp')->get()->result_array();        

        return $result;
        
    }

    public function getRunning_Device_Details($well_id,$imei_no,$from_date,$to_date)
    {
        if($well_id!='')
            $this->db->where('sd.well_id',$well_id);
        if($imei_no!='')
            $this->db->where('sd.imei_no',$imei_no);

     

        if ($from_date != '' && $to_date != '') {
            $fromTime = date('Y-m-d 06:00:00', strtotime($from_date));
            if ($from_date == $to_date) {
                $toTime = date('Y-m-d 06:00:00', strtotime($to_date . '+1 day'));
            } else {
                $toTime = date('Y-m-d 06:00:00', strtotime($to_date . '+1 day'));
            }
            $this->db->where('wrl.start_datetime >=', $fromTime);
            $this->db->where('wrl.end_datetime <', $toTime);
        }

        

      return  $this->db->select('wrl.id,wm.well_name,wrl.start_datetime, wrl.start_kwh, wrl.end_datetime, wrl.end_kwh, wrl.total_kwh, wrl.total_running_minute,COALESCE(cl.well_type, 0) AS well_type, IFNULL(SUM(cl.schdule_minutes), 1440) as running_minutes,vw.total_running_required,DATE_FORMAT(DATE_SUB(wrl.start_datetime, INTERVAL 6 HOUR), "%Y-%m-%d") AS compare_datetime')
            ->from('tbl_well_running_log wrl')
            ->join('tbl_site_device_installation sd', 'wrl.well_id=sd.well_id', 'left')
            ->join('tbl_well_master wm', 'sd.well_id=wm.id and wm.status =1', 'left')
            ->join('tbl_well_configuration_log cl', 'sd.well_id = cl.well_id AND cl.apply_datetime <= wrl.start_datetime AND COALESCE(cl.valid_datetime, NOW()) >= wrl.end_datetime','left')
            ->join('v_period_well_running_required  vw', 'vw.well_id=sd.well_id', 'left')
            ->where(['sd.status' => 1,'sd.device_shifted'=>0,'wrl.status'=>1])
            ->group_by('wrl.id, cl.well_id')
            ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
            ->order_by('wrl.start_datetime','ASC')
            ->get()->result_array();
    }


    public function get_wellwise_log($well_id)
    {


         if($well_id!='')
            $this->db->where('well_id',$well_id);

        $result =  $this->db->select('sd.well_id,sd.imei_no,sd.device_name,sd.date_of_installation, ws.shifted_datetime,sd.device_shifted,ws.status,ws.allot_prv_device_name,ws.allot_prv_imei_no,wm.well_name')
                    ->from('tbl_site_device_installation sd')
                    ->join('tbl_well_master wm','sd.well_id=wm.id','left')
                    ->join('tbl_well_shifted_device_details ws','sd.well_id=ws.allot_well_id','left')

                    ->where(['sd.status'=>1])->get()->result_array();

               

                    foreach($result as $value)
                    {
                        $Details[] = [
                                    'well_name' =>$value['well_name'],
                                    'device_name' => $value['device_name'],
                                    'imei_no' => $value['imei_no'],
                                    'date' => $value['date_of_installation'],
                                    'status' => $value['device_shifted'],
                                    ];

                        $Details[] = [
                                    'well_name' =>$value['well_name'],
                                    'device_name' => $value['allot_prv_device_name'],
                                    'imei_no' => $value['allot_prv_imei_no'],
                                    'date_shifted' => $value['shifted_datetime'],
                                    'status' => $value['status'],
                                    ];
                                                                                                                                                                                                                                                               
                    }

                    return $Details;


    }


}
?>
