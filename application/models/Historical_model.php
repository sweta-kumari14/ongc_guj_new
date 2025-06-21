<?php
class Historical_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}


	public function HistoricalDataMis_Report($well_id,$from_date,$to_date,$sort_by)
    {
       
        if($well_id != '')
            $this->db->where('dl.well_id', $well_id);

        if($from_date != '' && $to_date != '') {
            if($from_date == $to_date)
            {
                $to_datetime = date('Y-m-d', strtotime($to_date . '+1 day')) . ' 06:00:00';
            }else{
                $to_datetime = date('Y-m-d', strtotime($to_date)) . ' 06:00:00';
            }
            
            $from_datetime = date('Y-m-d', strtotime($from_date)) . ' 06:00:00';
            $this->db->where(['dl.last_log_datetime >=' => $from_datetime,'dl.last_log_datetime <=' => $to_datetime]);
        }

        if ($sort_by != '') 
            $this->db->order_by($sort_by, 'ASC');

        return $this->db->select("dl.well_id,output_Average_Voltage_L2N,output_Average_Voltage_P2P,output_Current_R,output_Average_Current,dl.last_log_datetime")
            ->from('tbl_historical_device_log dl')
            ->where(['dl.status'=>1])->order_by('dl.last_log_datetime','asc')->get()->result_array();
    }

    public function OutPut_historicalNeutral_Voltage($well_id,$from_date,$to_date)
    {
        
       $result = [];

        if($well_id!='')
            $this->db->where('dl.well_id',$well_id);
        
        if ($from_date != '' && $to_date != '') {

            if($from_date == $to_date)
            {
                $to_datetime = date('Y-m-d 06:00:00', strtotime($to_date . '+1 day'));
            }else{
                $to_datetime = date('Y-m-d 06:00:00', strtotime($to_date));
            }

            $from_datetime = date('Y-m-d 06:00:00', strtotime($from_date));
            
            $this->db->where("dl.last_log_datetime >= '$from_datetime' AND dl.last_log_datetime < '$to_datetime'");
        }

        $result['output_n_Avg']=$this->db->select("dl.last_log_datetime as x,dl.output_Average_Voltage_L2N as y")
        ->from('tbl_historical_device_log dl')
       
        ->where(['dl.status' => 1])->order_by('dl.last_log_datetime','ASC')->get()->result_array();

        return $result;
        
    }

    public function Output_LineHis_Voltage($well_id,$from_date, $to_date)
    {
        
        $result = [];

        if($well_id!='')
            $this->db->where('dl.well_id',$well_id);
       
        if ($from_date != '' && $to_date != '') {

            if($from_date == $to_date)
            {
                $to_datetime = date('Y-m-d 06:00:00', strtotime($to_date . '+1 day'));
            }else{
                $to_datetime = date('Y-m-d 06:00:00', strtotime($to_date));
            }

            $from_datetime = date('Y-m-d 06:00:00', strtotime($from_date));
            
            $this->db->where("dl.last_log_datetime >= '$from_datetime' AND dl.last_log_datetime < '$to_datetime'");
        }

        $result['output_v_Avg']=$this->db->select("dl.last_log_datetime as x,dl.output_Average_Voltage_P2P as y")
        ->from('tbl_historical_device_log dl')
        
        ->where(['dl.status' => 1])->order_by('dl.last_log_datetime','ASC')->get()->result_array();

        return $result;
        
    }

    public function Output_Current($well_id,$from_date, $to_date)
    {
        
         $result = [];

        if($well_id!='')
            $this->db->where('dl.well_id',$well_id);
        
        if ($from_date != '' && $to_date != '') {

            if($from_date == $to_date)
            {
                $to_datetime = date('Y-m-d 06:00:00', strtotime($to_date . '+1 day'));
            }else{
                $to_datetime = date('Y-m-d 06:00:00', strtotime($to_date));
            }

            $from_datetime = date('Y-m-d 06:00:00', strtotime($from_date));
            
            $this->db->where("dl.last_log_datetime >= '$from_datetime' AND dl.last_log_datetime < '$to_datetime'");
        }

        $result['output_i_Avg']=$this->db->select("dl.last_log_datetime as x,dl.output_Average_Current as y")
        ->from('tbl_historical_device_log dl')
        
        ->where(['dl.status' => 1])->order_by('dl.last_log_datetime','ASC')->get()->result_array();

        return $result;
        
    }

    public function Battery_voltage($well_id,$from_date, $to_date)
    {
        
         $result = [];

        if($well_id!='')
            $this->db->where('dl.well_id',$well_id);
        
        if ($from_date != '' && $to_date != '') {

            if($from_date == $to_date)
            {
                $to_datetime = date('Y-m-d 06:00:00', strtotime($to_date . '+1 day'));
            }else{
                $to_datetime = date('Y-m-d 06:00:00', strtotime($to_date));
            }

            $from_datetime = date('Y-m-d 06:00:00', strtotime($from_date));
            
            $this->db->where("dl.last_log_datetime >= '$from_datetime' AND dl.last_log_datetime < '$to_datetime'");
        }

        $result['battery_voltage']=$this->db->select("dl.last_log_datetime as x,dl.battery_Voltage as y")
        ->from('tbl_historical_device_log dl')
        
        ->where(['dl.status' => 1])->order_by('dl.last_log_datetime','ASC')->get()->result_array();

        return $result;
        
    }

    public function smps_Voltage($well_id,$from_date, $to_date)
    {
        
         $result = [];

        if($well_id!='')
            $this->db->where('dl.well_id',$well_id);
        
        if ($from_date != '' && $to_date != '') {

            if($from_date == $to_date)
            {
                $to_datetime = date('Y-m-d 06:00:00', strtotime($to_date . '+1 day'));
            }else{
                $to_datetime = date('Y-m-d 06:00:00', strtotime($to_date));
            }

            $from_datetime = date('Y-m-d 06:00:00', strtotime($from_date));
            
            $this->db->where("dl.last_log_datetime >= '$from_datetime' AND dl.last_log_datetime < '$to_datetime'");
        }

        $result['smps_voltage']=$this->db->select("dl.last_log_datetime as x,dl.smps_Voltage as y")
        ->from('tbl_historical_device_log dl')
        
        ->where(['dl.status' => 1])->order_by('dl.last_log_datetime','ASC')->get()->result_array();

        return $result;
        
    }

   public function HistoricalData_Average_value($well_id, $from_date, $to_date)
   {
        if ($well_id != '') {
            $this->db->where('dl.well_id', $well_id);
        }

        if ($from_date != '' && $to_date != '') {
            if ($from_date == $to_date) {
                $to_datetime = date('Y-m-d 06:00:00', strtotime($to_date . '+1 day'));
            } else {
                $to_datetime = date('Y-m-d 06:00:00', strtotime($to_date . '+1 day'));
            }

            $from_datetime = date('Y-m-d 06:00:00', strtotime($from_date));
            
            $this->db->where("dl.last_log_datetime >= '$from_datetime' AND dl.last_log_datetime < '$to_datetime'");
        }

        $this->db->select("COALESCE(AVG(dl.output_Current_R), 0) as  Current_R,COALESCE(AVG(dl.output_Current_Y), 0) as Current_Y,COALESCE(AVG(dl.output_Current_B), 0) as Current_B,COALESCE(AVG(dl.output_Average_Current), 0) as Avg_current,COALESCE(AVG(dl.output_Voltage_P2P_RY), 0) as Voltage_p2p_RY, COALESCE(AVG(dl.output_Voltage_P2P_YB), 0) as Voltage_P2P_YB, COALESCE(AVG(dl.output_Voltage_P2P_BR), 0) as Voltage_P2P_BR,COALESCE(AVG(dl.output_Average_Voltage_P2P), 0) as Avg_Voltage_P2P,COALESCE(AVG(dl.output_Voltage_L2N_R), 0) as Voltage_L2N_R,COALESCE(AVG(dl.output_Voltage_L2N_Y), 0) as Voltage_L2N_Y,COALESCE(AVG(dl.output_Voltage_L2N_B), 0) as Voltage_L2N_B,COALESCE(AVG(dl.output_Average_Voltage_L2N), 0) as Avg_Voltage_L2N")
                 ->from('tbl_historical_device_log dl')
                 ->where(['dl.status' => 1]);
            return $this->db->get()->result_array();
    }
  
}
?>
