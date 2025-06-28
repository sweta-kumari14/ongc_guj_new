<?php
date_default_timezone_set('Asia/Kolkata');
class Daily_Running_Report_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
 
    public function getRunning_DeviceWell_Details($well_id, $from_date, $to_date, $site_id, $sort_by,$feeder_id)
    {
        if ($well_id != '') {
            $this->db->where('sd.well_id', $well_id);
        }

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

        if ($site_id != '') 
        {
            $this->db->where('sd.site_id', $site_id);
        }

        if ($sort_by != '') {
            $this->db->order_by($sort_by, 'ASC');
        }

        if ($feeder_id != '') 
        {
            $this->db->where('sd.feeder_id', $feeder_id);
        }

        $result = $this->db->select('wrl.id, wrl.well_id, wm.well_name, wrl.start_datetime, wrl.start_kwh, wrl.end_datetime, wrl.end_kwh, wrl.total_kwh, wrl.total_running_minute,DATE_FORMAT(DATE_SUB(wrl.start_datetime, INTERVAL 6 HOUR), "%Y-%m-%d") AS compare_datetime, COALESCE(cl.well_type, 0) AS well_type, IFNULL(SUM(cl.schdule_minutes), 1440) as running_minutes,COALESCE(vw.total_running_required,0)AS total_running_required')
            ->from('tbl_well_running_log wrl')
            ->join('tbl_site_device_installation sd', 'wrl.well_id = sd.well_id', 'left')
            ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
            ->join('tbl_well_configuration_log cl', 'sd.well_id = cl.well_id AND cl.apply_datetime <= wrl.start_datetime AND COALESCE(cl.valid_datetime, NOW()) >= wrl.end_datetime','left')
            ->join('v_period_well_running_required  vw', 'vw.well_id=sd.well_id', 'left')
            ->where(['sd.status' => 1])
            ->group_by('wrl.id, cl.well_id')
            ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
            ->order_by('wrl.start_datetime', 'ASC')->get()->result_array();

       return $result;
       
    }

    public function Date_wiseRunning_DeviceWell_Details($date, $site_id, $sort_by, $feeder_id)
    {
     if ($date != '') 
     {
        $from_date = date('Y-m-d 06:00:00', strtotime($date));
        $to_date = date('Y-m-d 06:00:00', strtotime($date . '+1 day'));

        $this->db->where('wr.start_datetime >=', $from_date);
        $this->db->where('wr.end_datetime <', $to_date);

        if ($site_id != '') 
        {
            $this->db->where('ws.id', $site_id);
        }

        if ($sort_by != '') 
        {
            $this->db->order_by($sort_by, 'ASC');
        }

        if ($feeder_id != '') 
        {
            $this->db->where('sd.feeder_id', $feeder_id);
        }

        $current_date = date('Y-m-d');

        $result = $this->db->select('sd.well_id, wm.well_name, COALESCE(SUM(wr.total_kwh), 0) AS total_consumption, COALESCE(SUM(wr.total_running_minute), 0) AS total_running_minute, COALESCE((vw.running_minutes), 0) AS running_minutes, ws.well_site_name, COALESCE(vw.well_type, 0) AS well_type, COALESCE(vp.total_running_required, 0) AS total_running_required')
            ->from('tbl_site_device_installation sd')
            ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
            ->join('tbl_well_site_master ws', 'ws.id = sd.site_id and ws.status = 1', 'left')
            ->join('tbl_well_running_log wr', 'sd.well_id = wr.well_id', 'left')
            ->join('v_running_schdule_minutes vw', 'sd.well_id = vw.well_id AND vw.apply_datetime <= wr.start_datetime AND COALESCE(vw.valid_datetime, NOW()) >= wr.end_datetime', 'left')
            ->join('v_period_well_running_required vp', 'vp.well_id = sd.well_id', 'left')
            ->group_start()
            ->where('sd.device_shifted', 0)
            ->or_group_start()
                ->where('sd.status', 1)
                ->where('date(sd.date_of_shifted) >=', $date)
                ->where('sd.device_shifted', 1)
            ->group_end()
            ->group_end()
            ->group_by('sd.well_id')
            ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")->get()->result_array();

        if ($site_id != '') 
        {
            $this->db->where('ws.id', $site_id);
        }

        if ($feeder_id != '') 
        {
            $this->db->where('sd.feeder_id', $feeder_id);
        }

        $all_wells = $this->db->select('sd.well_id, wsmm.well_name, ws.well_site_name, COALESCE(vw.running_minutes, 0) AS running_minutes, COALESCE(vw.well_type, 0) AS well_type, COALESCE(vp.total_running_required, 0) AS total_running_required, sd.date_of_installation')
            ->from('tbl_site_device_installation sd')
            ->join('tbl_well_master wsmm', 'wsmm.id = sd.well_id', 'left')
            ->join('tbl_well_site_master ws', 'sd.site_id = ws.id', 'left')
            ->join('v_running_schdule_minutes vw', 'vw.well_id = sd.well_id AND vw.apply_datetime <= "' . $date . '" AND COALESCE(vw.valid_datetime, NOW()) >= "' . $date . '"', 'left')
            ->join('v_period_well_running_required vp', 'vp.well_id = sd.well_id', 'left')
            ->where(['date(sd.commissioning_date) <=' => $date, 'sd.status' => 1])
            ->group_start() 
            ->where('sd.device_shifted', 0)
            ->or_group_start()
                ->where('sd.status', 1)
                ->where('date(sd.date_of_shifted) >=', $date)
                ->where('sd.device_shifted', 1)
            ->group_end() 
            ->group_end() 
            ->order_by("CAST(SUBSTRING_INDEX(wsmm.well_name, '#', -1) AS UNSIGNED) ASC")->get()->result_array();

        $result_well_ids = array_column($result, 'well_id');
        foreach ($all_wells as $well) 
        {
            $well_id = $well['well_id'];
            $temporary_off_log = $this->db->select('well_id, effective_date_time, deeffective_date_time')
                ->from('tbl_temporary_off_well_reson_log')
                ->where('well_id', $well_id)
                ->where('date(effective_date_time) <=', $date)
                ->where('COALESCE(date(deeffective_date_time), NOW()) >=', $date)
                ->get()
                ->row();

            if ($temporary_off_log) 
            {
                $well['remarks'] = 'Temporary Off Well';
            } 
            else 
            {
                $well['remarks'] = '';
            }

            if (!in_array($well['well_id'], $result_well_ids)) 
            {
                $result[] = [
                    'well_id' => $well['well_id'],
                    'well_name' => $well['well_name'],
                    'total_consumption' => '0',
                    'total_running_minute' => '0',
                    'running_minutes' => $well['running_minutes'], 
                    'well_site_name' => $well['well_site_name'],
                    'well_type' => $well['well_type'], 
                    'total_running_required' => $well['total_running_required'],
                    'remarks' => $well['remarks'], 
                ];
            }
        }

        foreach ($result as &$row) 
        {
            if ($row['total_consumption'] == 0 && $row['total_running_minute'] == 0) 
            {
                $row['total_consumption'] = 0;
                $row['total_running_minute'] = 0;
            }

            if (isset($row['remarks']) && $row['remarks'] == 'Temporary Off Well') 
            {
                $row['total_shut_down_minute'] = $row['running_minutes'];
                $row['total_shut_down_running_well'] = 0;
            } 
            else 
            {
                if ($row['well_type'] == 1) 
                {
                    if ($date == $current_date) 
                    {
                        $row['total_shut_down_minute'] = $row['total_running_required'];
                        $row['total_shut_down_running_well'] = $row['total_shut_down_minute'] - $row['total_running_minute'];
                        $row['remarks'] ='';
                    } 
                    else 
                    {
                        $row['total_shut_down_minute'] = $row['running_minutes'];
                        $row['total_shut_down_running_well'] = $row['total_shut_down_minute'] - $row['total_running_minute'];
                         $row['remarks'] ='';
                    }
                } 
                else 
                {
                    if ($date == $current_date) 
                    {
                        $current_time_now = time(); 
                        $current_time = strtotime(date('Y-m-d 06:00:00'));
                        $current_time_minutes = ($current_time_now - $current_time) / 60;
                        $row['total_shut_down_minute'] = $current_time_minutes;
                        $row['total_shut_down_running_well'] = $row['total_shut_down_minute'] - $row['total_running_minute'];
                         $row['remarks'] ='';
                    } 
                    else 
                    {
                        $row['total_shut_down_minute'] = $row['running_minutes'];
                        $row['total_shut_down_running_well'] = $row['total_shut_down_minute'] - $row['total_running_minute'];
                         $row['remarks'] ='';
                    }
                }
            }
        }

        return $result;
    }
}

    public function Date_wiseRunning_self_flow_Well_Details($date,$site_id)
    {
         
   
        $from_date = date('Y-m-d 06:00:00', strtotime($date));
        $to_date = date('Y-m-d 06:00:00', strtotime($date . '+1 day'));

        $this->db->where('wr.start_datetime >=', $from_date);
        $this->db->where('wr.end_datetime <', $to_date);

        if ($site_id != '') 
        {
            $this->db->where('ws.id', $site_id);
        }
        $current_date = date('Y-m-d');
         $max_running_minutes = 24 * 60;

        $query = $this->db->select('
            wm.well_name,
            COALESCE(SUM(wr.total_running_minute), 0) AS total_running_minute,
            ws.well_site_name,
            ' . $max_running_minutes . ' AS max_possible_minutes
        ')
            ->from('tbl_site_device_installtion_self_flow sd')
            ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
            ->join('tbl_well_site_master ws', 'ws.id = sd.site_id and ws.status = 1', 'left')
            ->join('tbl_well_running_self_flow_log wr', 'sd.well_id = wr.well_id', 'left')
            ->where('sd.well_setup_status',1)
            ->group_by('sd.well_id')
            ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")->get();
              return $query->result_array();
    }
    public function well_commulative_self_flow_log_report($well_id,$from_date,$to_date,$site_id)
    {
        if ($well_id != '') {
            $this->db->where('sd.well_id', $well_id);
        }

        if ($from_date != '' && $to_date != '') {
            $fromTime = date('Y-m-d 06:00:00', strtotime($from_date));
            if ($from_date == $to_date) {
                $toTime = date('Y-m-d 06:00:00', strtotime($to_date . '+1 day'));
            } else {
                $toTime = date('Y-m-d 06:00:00', strtotime($to_date . '+1 day'));
            }
            $this->db->where('wr.start_datetime >=', $fromTime);
            $this->db->where('wr.end_datetime <', $toTime);
        }

        $current_date = date('Y-m-d');

        if ($site_id != '') {
            $this->db->where('ws.id', $site_id);
        }
        $max_running_minutes = 24 * 60;
       return $this->db->select('wm.well_name,ws.well_site_name, DATE_FORMAT(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR), "%Y-%m-%d") AS start_datetime, sd.well_id,COALESCE(SUM(wr.total_running_minute),0) AS t_minute,' . $max_running_minutes . ' AS max_possible_minutes')
            ->from('tbl_site_device_installtion_self_flow sd')
            ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
            ->join('tbl_well_site_master ws', 'ws.id=sd.site_id  and ws.status = 1', 'left')
            ->join('tbl_well_running_self_flow_log wr', 'wm.id=wr.well_id', 'left')
            ->where('sd.well_setup_status',1)
            ->group_by('sd.well_id, DATE_FORMAT(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR), "%Y-%m-%d")') 
            ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
            ->order_by("wr.start_datetime ASC")->get()->result_array();
    }



    public function well_comulative_logreport($well_id, $from_date, $to_date, $site_id,$sort_by,$feeder_id)
    {
        if ($well_id != '') {
            $this->db->where('sd.well_id', $well_id);
        }

        if ($from_date != '' && $to_date != '') {
            $fromTime = date('Y-m-d 06:00:00', strtotime($from_date));
            if ($from_date == $to_date) {
                $toTime = date('Y-m-d 06:00:00', strtotime($to_date . '+1 day'));
            } else {
                $toTime = date('Y-m-d 06:00:00', strtotime($to_date . '+1 day'));
            }
            $this->db->where('wr.start_datetime >=', $fromTime);
            $this->db->where('wr.end_datetime <', $toTime);
        }

        $current_date = date('Y-m-d');

        if ($site_id != '') {
            $this->db->where('ws.id', $site_id);
        }

        if ($sort_by != '') 
            $this->db->order_by($sort_by, 'ASC');
        if ($feeder_id != '') {
            $this->db->where('sd.feeder_id', $feeder_id);
        }

       $result = $this->db->select('wm.well_name, DATE_FORMAT(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR), "%Y-%m-%d") AS start_datetime, sd.well_id, COALESCE(SUM(wr.total_kwh), 0) AS e_consumption, COALESCE(SUM(wr.total_running_minute),0) AS t_minute, COALESCE(vw.running_minutes,1440)AS running_minutes,COALESCE(vp.total_running_required,0)AS total_running_required, COALESCE(vw.well_type,0)AS well_type')
            ->from('tbl_site_device_installation sd')
            ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
            ->join('tbl_well_site_master ws', 'ws.id=sd.site_id  and ws.status = 1', 'left')
            ->join('tbl_well_running_log wr', 'wm.id=wr.well_id', 'left')
            ->join('v_running_schdule_minutes vw', 'sd.well_id = vw.well_id AND vw.apply_datetime <= wr.start_datetime AND COALESCE(vw.valid_datetime, NOW()) >= wr.end_datetime','left')
            ->join('v_period_well_running_required vp', 'vp.well_id = sd.well_id', 'left')
            ->group_start()
                ->where('sd.device_shifted', 0)
                ->or_group_start()
                    ->where('sd.status', 1)
                    ->where('date(sd.date_of_shifted) >=', date($toTime))
                    ->where('sd.device_shifted', 1)
                ->group_end()
                ->group_end()
                ->group_by('sd.well_id, DATE_FORMAT(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR), "%Y-%m-%d")') 
            ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
            ->order_by("wr.start_datetime ASC")->get()->result_array(); 

            if ($well_id != '') 
            {
                $this->db->where('sd.well_id', $well_id);
            }

            if ($site_id != '') 
            {
                 $this->db->where('ws.id', $site_id);
            }

            if ($feeder_id != '') 
            {
                $this->db->where('sd.feeder_id', $feeder_id);
            }

            $all_wells = $this->db->select('sd.well_id, wsmm.well_name, ws.well_site_name,COALESCE(vw.running_minutes, 0) AS running_minutes,COALESCE(vw.well_type,0)AS well_type,COALESCE(vp.total_running_required, 0) AS total_running_required,sd.date_of_installation')
            ->from('tbl_site_device_installation sd')
            ->join('tbl_well_master wsmm', 'wsmm.id = sd.well_id', 'left')
            ->join('tbl_well_site_master ws', 'sd.site_id = ws.id', 'left')
            ->join('v_running_schdule_minutes vw', 'vw.well_id = sd.well_id AND vw.apply_datetime <= "'.$from_date.'" AND COALESCE(vw.valid_datetime, NOW()) >= "'.$to_date.'"', 'left')
            ->join('v_period_well_running_required vp', 'vp.well_id = sd.well_id', 'left')
            ->where(['date(sd.commissioning_date)<='=>$to_date,'sd.status'=>1])
            ->group_start() 
            ->where('sd.device_shifted', 0)
            ->or_group_start()
            ->where('sd.status', 1)
            ->where('date(sd.date_of_shifted) >=', $to_date)
            ->where('sd.device_shifted', 1)
            ->group_end() 
            ->group_end() 
            ->order_by("CAST(SUBSTRING_INDEX(wsmm.well_name, '#', -1) AS UNSIGNED) ASC")->get()->result_array();

            $running_wells = array_column($result, 'well_id');
            $all_installed_wells = array_column($all_wells, 'well_id');
            $non_running_wells = array_diff($all_installed_wells, $running_wells);

        foreach ($non_running_wells as $well_id) {
          
            $well_name = '';
            foreach ($all_wells as $well) {
                if ($well['well_id'] == $well_id) {
                    $well_name = $well['well_name'];

                    break;
                }
            }

            for ($date = $from_date; $date <= $to_date; $date = date('Y-m-d', strtotime($date . ' +1 day'))) 
            {

                $temporary_off_log = $this->db->select('well_id, effective_date_time, deeffective_date_time')
                ->from('tbl_temporary_off_well_reson_log')
                ->where('well_id', $well_id)
                ->where('date(effective_date_time) <=', $date)
                ->where('COALESCE(date(deeffective_date_time), NOW()) >=', $date)
                ->get()
                ->row();

                if ($temporary_off_log) {
                     $remarks_for_date = 'Temporary Off Well';
                }else{
                    $remarks_for_date = '';
                }

                $empty_entry = [
                    'well_name' => $well_name,
                    'well_id' => $well_id,
                    'start_datetime' => $date,
                    'e_consumption' => 0,
                    't_minute' => 0,
                    'running_minutes' => $well['running_minutes'], 
                    'well_type' => $well['well_type'], 
                    'total_running_required' => $well['total_running_required'], 
                    'remarks'=>$remarks_for_date,
                ];

                $result[] = $empty_entry;
            }
        }
        foreach ($result as &$row)
        {

            $date = $row['start_datetime'];

            if (isset($row['remarks']) && $row['remarks'] == 'Temporary Off Well') 
            {
                $row['total_shutdown_min'] = 0;
                $row['running_minutes'] = $row['running_minutes'];
                
            } 
            else 
            {

               if($row['well_type'] == 1)
               {
                
                    if( $date == $current_date)
                    {
                        $row['running_minutes'] =   $row['total_running_required'];
                        $row['total_shutdown_min'] = $row['running_minutes'] - $row['t_minute'];
                        $row['remarks'] = '';

                    }else{

                        $row['running_minutes'] = $row['running_minutes'];
                        $row['total_shutdown_min'] = $row['running_minutes'] - $row['t_minute'];
                        $row['remarks'] = '';
                    }
                }else{

                    if($date == $current_date)
                    {
                    
                         $current_time_now = time(); 
                         $current_time = strtotime(date('Y-m-d 06:00:00'));
                         $current_time_minutes = ($current_time_now - $current_time) / 60;
                         $row['running_minutes'] = $current_time_minutes;
                         $row['total_shutdown_min'] = $row['running_minutes'] - $row['t_minute'];
                         $row['remarks'] = '';

                       
                    }else{

                        $row['running_minutes'] = $row['running_minutes'];
                        $row['total_shutdown_min'] = $row['running_minutes'] - $row['t_minute'];
                        $row['remarks'] = '';

                    }
                }
            }
        }

       return $result;
    }


    public function well_runningperoid_logreport($site_id, $well_id, $from_date, $to_date, $sort_by,$feeder_id)
    {
        if ($site_id != '') {
            $this->db->where('ws.id', $site_id);
        }
        if ($well_id != '') {
            $this->db->where('sd.well_id', $well_id);
        }

        $current_date = date('Y-m-d');

        if ($from_date != '' && $to_date != '') {
            $fromTime = date('Y-m-d 06:00:00', strtotime($from_date));
            $toTime = date('Y-m-d 06:00:00', strtotime($to_date . '+1 day'));
            $this->db->where('wr.start_datetime >=', $fromTime);
            $this->db->where('wr.end_datetime <', $toTime);
        }

        if ($sort_by != '') {
            $this->db->order_by($sort_by, 'ASC');
        }

        if ($feeder_id != '') {
            $this->db->where('sd.feeder_id', $feeder_id);
        }


     $result = $this->db->select('sd.well_id, wm.well_name, COALESCE(SUM(wr.total_kwh), 0) AS e_consumption, COALESCE(SUM(wr.total_running_minute), 0) AS t_minute, ws.well_site_name,COALESCE(vp.total_running_required, 0) AS total_running_required, sd.date_of_installation')
        ->from('tbl_site_device_installation sd')
        ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
        ->join('tbl_well_site_master ws', 'ws.id = sd.site_id and ws.status = 1', 'left')
        ->join('tbl_well_running_log wr', 'sd.well_id = wr.well_id', 'left')
        ->join('v_period_well_running_required vp', 'vp.well_id = sd.well_id', 'left')
        ->group_start()
                ->where('sd.device_shifted', 0)
                ->or_group_start()
                    ->where('sd.status', 1)
                    ->where('date(sd.date_of_shifted) >=', date($toTime))
                    ->where('sd.device_shifted', 1)
                ->group_end()
                ->group_end()
                ->group_by('sd.well_id')
        ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
        ->get()->result_array();

        if ($site_id != '') {
            $this->db->where('ws.id', $site_id);
        }
        if ($well_id != '') {
            $this->db->where('sd.well_id', $well_id);
        }

         if ($feeder_id != '') {
            $this->db->where('sd.feeder_id', $feeder_id);
        }


        $all_wells = $this->db->select('sd.well_id, wsmm.well_name, ws.well_site_name,COALESCE(vw.running_minutes, 1440) AS running_minutes, COALESCE(vw.well_type,0)AS well_type,COALESCE(vp.total_running_required, 0) AS total_running_required,sd.date_of_installation')
            ->from('tbl_site_device_installation sd')
            ->join('tbl_well_master wsmm', 'wsmm.id = sd.well_id', 'left')
            ->join('tbl_well_site_master ws', 'sd.site_id = ws.id', 'left')
            ->join('v_running_schdule_minutes vw', 'vw.well_id = sd.well_id AND vw.apply_datetime <= "'.$from_date.'" AND COALESCE(vw.valid_datetime, NOW()) >= "'.$to_date.'"','left')
            ->join('v_period_well_running_required vp', 'vp.well_id = sd.well_id', 'left')
            ->where(['date(sd.commissioning_date)<='=>$to_date,'sd.status'=>1])
            ->group_start() 
            ->where('sd.device_shifted', 0)
            ->or_group_start()
            ->where('sd.status', 1)
            ->where('date(sd.date_of_shifted) >=', $to_date)
            ->where('sd.device_shifted', 1)
            ->group_end() 
            ->group_end() 
            ->order_by("CAST(SUBSTRING_INDEX(wsmm.well_name, '#', -1) AS UNSIGNED) ASC")->get()->result_array();
         // print_r($all_wells);die;

        $result_well_ids = array_column($result, 'well_id');
        foreach ($all_wells as $well) {
            $well_id = $well['well_id'];
            
            if (!in_array($well['well_id'], $result_well_ids)) {
                $result[] = [
                    'well_id' => $well['well_id'],
                    'well_name' => $well['well_name'],
                    't_minute' => '0',
                    'e_consumption' => '0',
                    'schdule_minute'=>'0',
                    'running_minutes' => $well['running_minutes'], 
                    'well_site_name' => $well['well_site_name'],
                    'well_type' => $well['well_type'], 
                    'total_running_required' => $well['total_running_required'], 
                   
                ];
            }
        }

        foreach ($result as &$row) {
        $running_minutes = 0;
        $well_type = '';
        for ($date = $from_date; $date <= $to_date; $date = date('Y-m-d', strtotime($date . ' +1 day'))) 
        {
            
                   $running_schedule = $this->db->select('COALESCE(running_minutes,1440)AS running_minutes,well_id,COALESCE(well_type,0)AS well_type')
                        ->from('v_running_schdule_minutes')
                        ->where('well_id', $row['well_id'])
                        ->where('apply_datetime <=', $date . ' 06:00:00')  
                        ->where('COALESCE(valid_datetime, NOW()) >=', $date . ' 05:59:59')
                        ->get()->row_array();

                    if ($running_schedule) {
                        $running_minutes += $running_schedule['running_minutes'];
                    }

                    $well_type = isset($running_schedule['well_type']) ? $running_schedule['well_type'] : 0;
               
            }

          $last_schedule = $this->db->select('COALESCE(running_minutes, 1440) AS schdule_minute, well_id, COALESCE(well_type, 0) AS well_type')
            ->from('v_running_schdule_minutes')
            ->where('well_id', $row['well_id'])
            ->where('apply_datetime <=', $from_date . ' 06:00:00')
            ->where('COALESCE(valid_datetime, NOW()) >=', $to_date . ' 05:59:59')
            ->order_by('apply_datetime', 'desc')
            ->limit(1)
            ->get()->row_array();
          
             $schdule_minute = isset($last_schedule['schdule_minute'] ) ? $last_schedule['schdule_minute']:0;
             
            $row['running_minutes'] = $running_minutes;

            if (isset($row['remarks']) && $row['remarks'] == 'Temporary Off Well') 
            {
                $row['shutdown_minutes'] = 0;
                $row['running_minutes'] = $row['running_minutes'];
                
            } 
            else 
            {
                    if($well_type == 1)
                    {
                        if( $to_date == $current_date)
                        {

                            $row['current_required'] = $schdule_minute - $row['total_running_required'];
                            $row['running_minutes'] = $row['running_minutes'] - $row['current_required'];
                            $row['shutdown_minutes'] = $row['running_minutes'] - $row['t_minute'];
                            $row['remarks'] = '';
                        }else{
                            $row['running_minutes'] = $row['running_minutes'];
                            $row['shutdown_minutes'] = $row['running_minutes'] - $row['t_minute'];
                            $row['remarks'] = '';

                            
                        }
                    }else{
                        if($to_date == $current_date)
                        {
                             $current_time_now = time(); 
                             $current_time = strtotime(date('Y-m-d 06:00:00'));
                             $current_time_minutes = ($current_time_now - $current_time) / 60;
                             $current_required = $schdule_minute - $current_time_minutes;
                             $row['shutdown_minutes'] = $row['running_minutes'] - $row['t_minute'];
                             $row['remarks'] = '';

                        }else{

                            $row['running_minutes'] = $row['running_minutes'];
                            $row['shutdown_minutes'] = $row['running_minutes'] - $row['t_minute'];
                            $row['remarks'] = '';

                        }
                }
            }
        }

     return $result;
   }

  
    public function Date_Max_MinValue_Details($well_id,$date,$user_id)
    {

        if($well_id!='')
            $this->db->where('sd.well_id',$well_id);
        $this->db->where('date(dl.offline_device_timestamp)', $date);

        if($user_id!='')
            $this->db->where('ad.user_id',$user_id);

        

        $this->db->where(['dl.output_Voltage_L2N_R >'=> 0,'dl.output_Voltage_L2N_R >'=> 0,'dl.output_Voltage_L2N_B >' => 0,'dl.output_Average_Voltage_L2N >'=> 0]);

        
        $this->db->where(['dl.output_Voltage_P2P_RY >'=> 0,'dl.output_Voltage_P2P_YB >'=> 0,'dl.output_Voltage_P2P_BR >' => 0,'dl.output_Average_Voltage_P2P >'=> 0]);

        
        $this->db->where(['dl.output_Current_R >'=> 0,'dl.output_Current_Y >'=> 0,'dl.output_Current_B >' => 0,'dl.output_Average_Current >'=> 0]);

        $this->db->where(['dl.output_System_Frequency >'=> 0]);
        
        return $this->db->select("dl.id,sd.well_id,wm.well_name,dl.imei_no,max(dl.output_Voltage_L2N_R) as max_output_R_L2N,max(dl.output_Voltage_L2N_Y) as max_output_Y_L2N,max(dl.output_Voltage_L2N_B) as max_output_B_L2N,max(dl.output_Average_Voltage_L2N) as max_output_Avg_L2N,
            min(dl.output_Voltage_L2N_R) as min_output_R_L2N,min(dl.output_Voltage_L2N_Y) as min_output_Y_L2N,min(dl.output_Voltage_L2N_B) as min_output_B_L2N,min(dl.output_Average_Voltage_L2N) as min_output_Avg_L2N,max(dl.output_Voltage_P2P_RY) as max_output_P2P_RY,max(dl.output_Voltage_P2P_YB) as max_output_P2P_YB,max(dl.output_Voltage_P2P_BR) as max_output_P2P_BR,max(dl.output_Average_Voltage_P2P) as max_output_Avg_P2P,min(dl.output_Voltage_P2P_RY) as min_output_P2P_RY,min(dl.output_Voltage_P2P_YB) as min_output_P2P_YB,min(dl.output_Voltage_P2P_BR) as min_output_P2P_BR,min(dl.output_Average_Voltage_P2P) as min_output_Avg_P2P,max(dl.output_Current_R) as max_output_cur_R,max(dl.output_Current_Y) as max_output_cur_Y,max(dl.output_Current_B) as max_output_cur_B,max(dl.output_Average_Current) as max_output_Avg,min(dl.output_Current_R) as min_output_cur_R,min(dl.output_Current_Y) as min_output_cur_Y,min(dl.output_Current_B) as min_output_cur_B,min(dl.output_Average_Current) as min_output_Avg,max(dl.output_System_Frequency) as max_out_frq,min(dl.output_System_Frequency) as min_out_frq,dl.offline_device_timestamp as cdate")
        ->from('tbl_device_log dl')
        ->join('tbl_site_device_installation sd','dl.imei_no=sd.imei_no','left')
        ->join('tbl_role_wise_user_assign_details ad','sd.site_id=ad.site_id','left')
        ->join('tbl_well_master wm','sd.well_id=wm.id','left')
        ->where(['dl.status'=>1,'sd.status'=>1,'ad.status'=>1])->group_by('dl.imei_no')->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")->get()->result_array();
    }

    public function Date_Max_MinValue_Details_for_mobile($well_id,$date,$user_id)
    {

        if($well_id!='')
            $this->db->where('sd.well_id',$well_id);
         if($user_id!='')
            $this->db->where('ad.user_id',$user_id);
        
        $this->db->where("(DATE_FORMAT(dl.offline_device_timestamp,'%d-%m-%Y'))", date('d-m-Y',strtotime($date)));

        
        $this->db->where(['dl.output_Voltage_L2N_R >'=> 0,'dl.output_Voltage_L2N_R >'=> 0,'dl.output_Voltage_L2N_B >' => 0,'dl.output_Average_Voltage_L2N >'=> 0]);

       
        $this->db->where(['dl.output_Voltage_P2P_RY >'=> 0,'dl.output_Voltage_P2P_YB >'=> 0,'dl.output_Voltage_P2P_BR >' => 0,'dl.output_Average_Voltage_P2P >'=> 0]);

      
        $this->db->where(['dl.output_Current_R >'=> 0,'dl.output_Current_Y >'=> 0,'dl.output_Current_B >' => 0,'dl.output_Average_Current >'=> 0]);

        $this->db->where(['dl.output_System_Frequency >'=> 0]);
        
        return $this->db->select("dl.id,sd.well_id,wm.well_name,dl.imei_no,max(dl.output_Voltage_L2N_R) as max_output_R_L2N,max(dl.output_Voltage_L2N_Y) as max_output_Y_L2N,max(dl.output_Voltage_L2N_B) as max_output_B_L2N,max(dl.output_Average_Voltage_L2N) as max_output_Avg_L2N,
            min(dl.output_Voltage_L2N_R) as min_output_R_L2N,min(dl.output_Voltage_L2N_Y) as min_output_Y_L2N,min(dl.output_Voltage_L2N_B) as min_output_B_L2N,min(dl.output_Average_Voltage_L2N) as min_output_Avg_L2N,max(dl.output_Voltage_P2P_RY) as max_output_P2P_RY,max(dl.output_Voltage_P2P_YB) as max_output_P2P_YB,max(dl.output_Voltage_P2P_BR) as max_output_P2P_BR,max(dl.output_Average_Voltage_P2P) as max_output_Avg_P2P,min(dl.output_Voltage_P2P_RY) as min_output_P2P_RY,min(dl.output_Voltage_P2P_YB) as min_output_P2P_YB,min(dl.output_Voltage_P2P_BR) as min_output_P2P_BR,min(dl.output_Average_Voltage_P2P) as min_output_Avg_P2P,max(dl.output_Current_R) as max_output_cur_R,max(dl.output_Current_Y) as max_output_cur_Y,max(dl.output_Current_B) as max_output_cur_B,max(dl.output_Average_Current) as max_output_Avg,min(dl.output_Current_R) as min_output_cur_R,min(dl.output_Current_Y) as min_output_cur_Y,min(dl.output_Current_B) as min_output_cur_B,min(dl.output_Average_Current) as min_output_Avg,max(dl.output_System_Frequency) as max_out_frq,min(dl.output_System_Frequency) as min_out_frq,dl.offline_device_timestamp as cdate")
        ->from('tbl_device_log dl')
        ->join('tbl_site_device_installation sd','dl.imei_no=sd.imei_no','left')
        ->join('tbl_role_wise_user_assign_details ad','sd.site_id=ad.site_id','left')
        ->join('tbl_well_master wm','sd.well_id=wm.id','left')
        ->where(['dl.status'=>1,'sd.status'=>1,'ad.status'=>1])->group_by('dl.imei_no')->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")->get()->result_array();
    }


    public function running_log_energy_details($well_id,$month_id,$year,$site_id)
    {
        if ($well_id != '') 
        {
            $this->db->where('wr.well_id', $well_id);
        }

        if ($site_id != '') {
            $this->db->where('ws.id', $site_id);
        }

    
        $this->db->where("MONTH(wr.start_datetime)", $month_id);
        $this->db->where("year(wr.start_datetime)", $year);

        return $this->db->select("wm.well_name x, SUM(wr.total_kwh) AS e_consumption, SUM(wr.total_running_minute) AS t_minute")
                       ->from('tbl_site_device_installation sd')
                       ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
                       ->join('tbl_well_site_master ws', 'ws.id=sd.site_id and ws.status =1', 'left')
                       ->join('tbl_well_running_log wr','wm.id=wr.well_id', 'left')
                       ->where(['sd.status' => 1])
                       ->group_by('MONTH(wr.start_datetime),year(wr.start_datetime),sd.well_id') 
                       ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
                       ->get()
                       ->result_array();

    }

    public function running_logdetails($well_id,$month_id,$year,$site_id)
    {
        if ($well_id != '') 
        {
            $this->db->where('wr.well_id', $well_id);
        }

        if ($site_id != '') 
        {
            $this->db->where('ws.id', $site_id);
        }
    
    
        $this->db->where("MONTH(wr.start_datetime)", $month_id);
        $this->db->where("year(wr.start_datetime)", $year);

        return $this->db->select("wm.well_name as x,SUM(wr.total_running_minute) AS t_minute")
                       ->from('tbl_site_device_installation sd')
                       ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
                       ->join('tbl_well_site_master ws', 'ws.id=sd.site_id and ws.status =1', 'left')
                       ->join('tbl_well_running_log wr','wm.id=wr.well_id', 'left')
                       ->where(['sd.status' => 1])
                       ->group_by('MONTH(wr.start_datetime),year(wr.start_datetime),sd.well_id') 
                       ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
                       ->get()
                       ->result_array();
    }

    public function energy_consumption_details($well_id,$month_id,$year,$site_id)
    {
        if ($well_id != '') 
        {
            $this->db->where('wr.well_id', $well_id);
        }

        if ($site_id != '') 
        {
            $this->db->where('ws.id', $user_id);
        }
    
    
        $this->db->where("MONTH(wr.start_datetime)", $month_id);
        $this->db->where("year(wr.start_datetime)", $year);

        return $this->db->select("wm.well_name x,SUM(wr.total_kwh) AS e_consumption")
                       ->from('tbl_site_device_installation sd')
                       ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
                       ->join('tbl_well_site_master ws', 'ws.id=sd.site_id and ws.status =1', 'left')
                       ->join('tbl_well_running_log wr','wm.id=wr.well_id', 'left')
                       ->where(['sd.status' => 1])
                       ->group_by('MONTH(wr.start_datetime),year(wr.start_datetime),sd.well_id') 
                       ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
                       ->get()
                       ->result_array();
    }

    public function Running_shutdown_details($well_id, $month_id, $year,$site_id)
    {
        if ($well_id != '') {
            $this->db->where('wr.well_id', $well_id);
        }

        if ($site_id != '') 
        {
            $this->db->where('ws.id', $site_id);
        }
        
        $this->db->where("MONTH(wr.start_datetime)", $month_id);
        $this->db->where("YEAR(wr.start_datetime)", $year);

        $current_month = date('m');
        $current_year = date('Y');
        $current_day = date('d');
       
        if($current_month == $month_id && $current_year == $year)
        {
            $num_days_in_month = date($current_day, strtotime($current_year . '-' . $current_month . '-01'));
        }else{
            $num_days_in_month = cal_days_in_month(CAL_GREGORIAN, $month_id, $year);

        }

        $result = $this->db->select("wm.well_name as x, 
                                  SUM(wr.total_running_minute) AS t_minute,vw.running_minutes")
                    ->from('tbl_site_device_installation sd')
                    ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
                    ->join('tbl_well_running_log wr', 'wm.id = wr.well_id', 'left')
                    ->join('tbl_well_site_master ws', 'ws.id=sd.site_id and ws.status =1', 'left')
                    ->join('v_well_running_config vw', 'vw.well_id = sd.well_id', 'left')
                    ->where(['sd.status' => 1])
                    ->group_by('MONTH(wr.start_datetime), YEAR(wr.start_datetime), sd.well_id') 
                    ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
                    ->get()
                    ->result_array();

           foreach ($result as &$row) 
           {
            $running_hours = $row['running_minutes'] * $num_days_in_month;
            $row['shutdown_minutes'] = $running_hours - $row['t_minute'];
            
           }

        return $result;
    }

    public function well_performance_details($well_id,$month_id,$year,$site_id)
    {
        if ($well_id != '') {
            $this->db->where('wr.well_id', $well_id);
        }

        if ($site_id != '') 
        {
            $this->db->where('ws.id', $site_id);
        }
        
        $this->db->where("MONTH(wr.start_datetime)", $month_id);
        $this->db->where("YEAR(wr.start_datetime)", $year);

        $current_month = date('m');
        $current_year = date('Y');
        $current_day = date('d');

        if($current_month == $month_id && $current_year == $year)
        {
            $num_days_in_month = date($current_day, strtotime($current_year . '-' . $current_month . '-01'));
        }else{
            $num_days_in_month = cal_days_in_month(CAL_GREGORIAN, $month_id, $year);

        }

        // print_r($num_days_in_month);die;
       
        $result = $this->db->select("wm.well_name as x, 
                                  SUM(wr.total_running_minute) AS t_minute,vw.running_minutes")
                    ->from('tbl_site_device_installation sd')
                    ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
                    ->join('tbl_well_running_log wr', 'wm.id = wr.well_id', 'left')
                    ->join('tbl_well_site_master ws', 'ws.id=sd.site_id and ws.status =1', 'left')
                    ->join('v_well_running_config vw', 'vw.well_id = sd.well_id', 'left')
                    ->where(['sd.status' => 1])
                    ->group_by('MONTH(wr.start_datetime), YEAR(wr.start_datetime), sd.well_id') 
                    ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
                    ->get()
                    ->result_array();

           foreach ($result as &$row) 
           {
             $row['running_minutes'] *= $num_days_in_month;
             $availability = ($row['t_minute'] / $row['running_minutes']) * 100;
             $row['availability'] = number_format($availability, 2) . ' % ';
            
           }

        return $result;
         
    }


   public function fin_running_logdetails($well_id, $fin_year, $site_id)
   {
      if($well_id != "") 
      {
            if ($site_id != '') 
                 $this->db->where('ws.id', $site_id);

            $currentMonth = date('n');
            $currentYear = date('Y');
            $startMonth = 4;
            $startYear = ($currentMonth < $startMonth) ? ($currentYear - 1) : $currentYear;

            if ($fin_year != "") {
                $yearRange = explode('-', $fin_year);
                $startYear = intval($yearRange[0]);
            }

            $endMonth = 3;
            $endYear = $startYear + 1;
            $start_date = $startYear . '-04-01';
            $end_date = $endYear . '-03-31';

            $this->db->where('wr.start_datetime >=', $start_date);
            $this->db->where('wr.start_datetime <=', $end_date);

          $result = $this->db->select('MONTHNAME(wr.start_datetime) AS x, COALESCE(SUM(wr.total_running_minute), 0) AS y')
                       ->from('tbl_site_device_installation sd')
                       ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
                       ->join('tbl_well_site_master ws', 'ws.id=sd.site_id and ws.status =1', 'left')
                       ->join('tbl_well_running_log wr', 'wm.id=wr.well_id', 'left')
                       ->where(['sd.status' => 1])
                       ->where('sd.well_id', $well_id)
                       ->group_by('MONTH(wr.start_datetime)')->get()->result_array();
        $formatted_result = [];
        for ($month = 4; $month <= 15; $month++) { 
            $month_number = ($month <= 12) ? $month : $month - 12; 
            $month_name = date("F", mktime(0, 0, 0, $month_number, 1));
            $found = false;
            foreach ($result as $row) {
                if (date('F', strtotime($row['x'])) == $month_name) {
                    $formatted_result[] = $row;
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $formatted_result[] = ['x' => $month_name, 'y' => 0];
            }
        }

        return $formatted_result;

      }else{
            
            if ($site_id != '') 
                 $this->db->where('ws.id', $site_id);

            $currentMonth = date('n');
            $currentYear = date('Y');
            $startMonth = 4;
            $startYear = ($currentMonth < $startMonth) ? ($currentYear - 1) : $currentYear;

            if ($fin_year != "") {
                $yearRange = explode('-', $fin_year);
                $startYear = intval($yearRange[0]);
            }

            $endMonth = 3;
            $endYear = $startYear + 1;
            $start_date = $startYear . '-04-01';
            $end_date = $endYear . '-03-31';

            $this->db->where('wr.start_datetime >=', $start_date);
            $this->db->where('wr.start_datetime <=', $end_date);

            return $this->db->select('wm.well_name as x,SUM(wr.total_running_minute) AS y')
                       ->from('tbl_site_device_installation sd')
                       ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
                       ->join('tbl_well_site_master ws', 'ws.id=sd.site_id and ws.status =1', 'left')
                       ->join('tbl_well_running_log wr','wm.id=wr.well_id', 'left')
                       ->where(['sd.status' => 1])
                       ->group_by('sd.well_id') 
                       ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
                       ->get()
                       ->result_array();
       }

   }

    public function fin_energy_consumption_details($well_id,$fin_year,$site_id)
    {
        if($well_id != "") 
        {

            if ($site_id != '') 
                 $this->db->where('ws.id', $site_id);

            $currentMonth = date('n');
            $currentYear = date('Y');
            $startMonth = 4;
            $startYear = ($currentMonth < $startMonth) ? ($currentYear - 1) : $currentYear;

            if ($fin_year != "") {
                $yearRange = explode('-', $fin_year);
                $startYear = intval($yearRange[0]);
            }

            $endMonth = 3;
            $endYear = $startYear + 1;
            $start_date = $startYear . '-04-01';
            $end_date = $endYear . '-03-31';

            $this->db->where('wr.start_datetime >=', $start_date);
            $this->db->where('wr.start_datetime <=', $end_date);

            $result = $this->db->select('MONTHNAME(wr.start_datetime) AS x, COALESCE(SUM(wr.total_kwh), 0) AS y')
                       ->from('tbl_site_device_installation sd')
                       ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
                       ->join('tbl_well_site_master ws', 'ws.id=sd.site_id and ws.status =1', 'left')
                       ->join('tbl_well_running_log wr', 'wm.id=wr.well_id', 'left')
                       ->where(['sd.status' => 1])
                       ->where('sd.well_id', $well_id)
                       ->group_by('MONTH(wr.start_datetime)')->get()->result_array();
            $formatted_result = [];
            for ($month = 4; $month <= 15; $month++) { 
                $month_number = ($month <= 12) ? $month : $month - 12; 
                $month_name = date("F", mktime(0, 0, 0, $month_number, 1));
                $found = false;
                foreach ($result as $row) {
                    if (date('F', strtotime($row['x'])) == $month_name) {
                        $formatted_result[] = $row;
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    $formatted_result[] = ['x' => $month_name, 'y' => 0];
                }
            }

            return $formatted_result;
    }else{

        if ($site_id != '') 
        {
            $this->db->where('ws.id', $site_id);
        }
           $currentMonth = date('n');
           $currentYear = date('Y');
           $startMonth = 4;
           $startYear = ($currentMonth < $startMonth) ? ($currentYear - 1) : $currentYear;

            if ($fin_year!= "") 
            {
                $yearRange = explode('-', $fin_year);
                $startYear = intval($yearRange[0]);
            }

            $endMonth = 3;
            $endYear = $startYear + 1;
            $start_date = $startYear . '-04-01';
            $end_date = $endYear . '-03-31';

  
            $this->db->where('wr.start_datetime >=', $start_date);
            $this->db->where('wr.start_datetime <=', $end_date);

            return $this->db->select('wm.well_name as x,SUM(wr.total_kwh) AS y')
                       ->from('tbl_site_device_installation sd')
                       ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
                       ->join('tbl_well_site_master ws', 'ws.id=sd.site_id and ws.status =1', 'left')
                       ->join('tbl_well_running_log wr','wm.id=wr.well_id', 'left')
                       ->where(['sd.status' => 1])
                       ->group_by('sd.well_id') 
                       ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
                       ->get()
                       ->result_array();          
        }
    }

    public function fin_Running_shutdown_details($well_id,$fin_year,$site_id)
    {
        if($well_id != "") 
        {

            if ($site_id != '') 
            {
               $this->db->where('ws.id', $site_id);
            }
           $currentMonth = date('n');
           $currentYear = date('Y');
           $startMonth = 4;
           $endmonth = 3;
           if ($currentMonth >= $startMonth && $currentMonth <= 12) 
           {
               $start_Year = $currentYear;
               $end_Year = $currentYear + 1;
           } elseif ($currentMonth >= 1 && $currentMonth <= $endMonth) 
           {
               $start_Year = $currentYear - 1;
               $end_Year = $currentYear;
           }

           $startYear = ($currentMonth < $startMonth) ? ($currentYear - 1) : $currentYear;

            if ($fin_year!= "") 
            {
                $yearRange = explode('-', $fin_year);
                $startYear = intval($yearRange[0]);


            }

            $endMonth = 3;
            $endYear = $startYear + 1;
            $start_date = $startYear . '-04-01';
            $end_date = $endYear . '-03-31';
            $current_date = date('Y-m-d');

            $this->db->where('wr.start_datetime >=', $start_date);
            $this->db->where('wr.start_datetime <=', $end_date);

             $result = $this->db->select('MONTHNAME(wr.start_datetime) AS x, COALESCE(SUM(wr.total_running_minute),0) AS t_minute,vw.running_minutes')
                   ->from('tbl_site_device_installation sd')
                   ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
                   ->join('tbl_well_site_master ws', 'ws.id=sd.site_id and ws.status =1', 'left')
                   ->join('tbl_well_running_log wr', 'wm.id = wr.well_id', 'left')
                   ->join('v_well_running_config vw', 'vw.well_id = sd.well_id', 'left')
                   ->where(['sd.status' => 1])
                   ->where('sd.well_id', $well_id)
                   ->group_by('MONTH(wr.start_datetime)')->get()->result_array();
            $formatted_result = [];
            for ($month = 4; $month <= 15; $month++) 
            { 
                $month_number = ($month <= 12) ? $month : $month - 12; 
                $month_name = date("F", mktime(0, 0, 0, $month_number, 1));
                $current_month = date('m');
                $current_year = date('Y');
                $current_day = date('d');
                if($current_month == $month_number && $current_year == date('Y'))
                {
                   $days_in_month = date($current_day, strtotime($current_year . '-' . $current_month . '-01'));
                }else{
                     $days_in_month = cal_days_in_month(CAL_GREGORIAN, $month_number, date('Y'));
              
                }
               
                $found = false;
                foreach ($result as $row)
                {
                     if (date('F', strtotime($row['x'])) == $month_name) 
                     {
          
                       $running_hours = $row['running_minutes'] * $days_in_month;
                       $shutdown_hours = $running_hours - $row['t_minute'];
                       $formatted_result[] = [
                            'x' => $month_name,
                            't_minute' => $row['t_minute'],
                            'shutdown_minutes' => $shutdown_hours
                            ];
                        $found = true;
                        break;
                     }
                }

                if (!$found) {
                    $formatted_result[] = [
                        'x' => $month_name,
                        't_minute' => 0,
                        'shutdown_minutes' => 0
                    ];
                }
            }

            return $formatted_result;

        }else{

            if ($site_id != '') 
            {
                $this->db->where('ws.id', $site_id);
            }
                   $currentMonth = date('n');
                   $currentYear = date('Y');
                   $startMonth = 4;
                   $endmonth = 3;
                   if ($currentMonth >= $startMonth && $currentMonth <= 12) 
                   {
                       $start_Year = $currentYear;
                       $end_Year = $currentYear + 1;
                   } elseif ($currentMonth >= 1 && $currentMonth <= $endMonth) 
                   {
                       $start_Year = $currentYear - 1;
                       $end_Year = $currentYear;
                   }

                   $startYear = ($currentMonth < $startMonth) ? ($currentYear - 1) : $currentYear;

                    if ($fin_year!= "") 
                    {
                        $yearRange = explode('-', $fin_year);
                        $startYear = intval($yearRange[0]);


                    }

                    $endMonth = 3;
                    $endYear = $startYear + 1;
                    $start_date = $startYear . '-04-01';
                    $end_date = $endYear . '-03-31';
                    $current_date = date('Y-m-d');

                    $this->db->where('wr.start_datetime >=', $start_date);
                    $this->db->where('wr.start_datetime <=', $end_date);

                if ($fin_year == $start_Year . '-' . $end_Year) 
                {
                 
                    $startDateTime = new DateTime($start_date);
                    $endDateTime = new DateTime($current_date);
                    $diff = $endDateTime->diff($startDateTime);
                    $num_days_in_fin_year = $diff->days + 1;
                } else {
                   
                    $startDateTime = new DateTime($start_date);
                    $endDateTime = new DateTime($end_date);
                    $diff = $endDateTime->diff($startDateTime);
                    $num_days_in_fin_year = $diff->days + 1;
                }


            $result = $this->db->select('wm.well_name as x,SUM(wr.total_running_minute) AS t_minute,vw.running_minutes')
                    ->from('tbl_site_device_installation sd')
                    ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
                    ->join('tbl_well_site_master ws', 'ws.id=sd.site_id and ws.status =1', 'left')
                    ->join('tbl_well_running_log wr', 'wm.id = wr.well_id', 'left')
                    ->join('v_well_running_config vw', 'vw.well_id = sd.well_id', 'left')
                    ->where(['sd.status' => 1])
                    ->group_by('sd.well_id') 
                    ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
                    ->get()
                    ->result_array();

               foreach ($result as &$row) 
               {
                $row['running_minutes'] *= $num_days_in_fin_year;
                $row['shutdown_minutes'] = $row['running_minutes'] - $row['t_minute'];
                
               }

            return $result;
        }
    }

    public function fin_well_performance_details($well_id,$fin_year,$site_id)
    {

        if($well_id!='')
        {

            if ($site_id != '') 
            {
                $this->db->where('ws.id', $site_id);
            }
               $currentMonth = date('n');
               $currentYear = date('Y');
               $startMonth = 4;
               $endmonth = 3;
               if ($currentMonth >= $startMonth && $currentMonth <= 12) 
               {
                   $start_Year = $currentYear;
                   $end_Year = $currentYear + 1;
               } elseif ($currentMonth >= 1 && $currentMonth <= $endMonth) 
               {
                   $start_Year = $currentYear - 1;
                   $end_Year = $currentYear;
               }
               $startYear = ($currentMonth < $startMonth) ? ($currentYear - 1) : $currentYear;

                if ($fin_year!= "") 
                {
                    $yearRange = explode('-', $fin_year);
                    $startYear = intval($yearRange[0]);
                }

                $endMonth = 3;
                $endYear = $startYear + 1;
                $start_date = $startYear . '-04-01';
                $end_date = $endYear . '-03-31';
                $current_date = date('Y-m-d');

                $this->db->where('wr.start_datetime >=', $start_date);
                $this->db->where('wr.start_datetime <=', $end_date);


            $result = $this->db->select('MONTHNAME(wr.start_datetime) AS x, COALESCE(SUM(wr.total_running_minute),0) AS t_minute,vw.running_minutes')
                   ->from('tbl_site_device_installation sd')
                   ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
                   ->join('tbl_well_site_master ws', 'ws.id=sd.site_id and ws.status =1', 'left')
                   ->join('tbl_well_running_log wr', 'wm.id = wr.well_id', 'left')
                   ->join('v_well_running_config vw', 'vw.well_id = sd.well_id', 'left')
                   ->where(['sd.status' => 1])
                   ->where('sd.well_id', $well_id)
                   ->group_by('MONTH(wr.start_datetime)')->get()->result_array();
            $formatted_result = [];
            for ($month = 4; $month <= 15; $month++) 
            { 
                $month_number = ($month <= 12) ? $month : $month - 12; 
                $month_name = date("F", mktime(0, 0, 0, $month_number, 1));
                $current_month = date('m');
                $current_year = date('Y');
                $current_day = date('d');
                if($current_month == $month_number && $current_year == date('Y'))
                {
                   $days_in_month = date($current_day, strtotime($current_year . '-' . $current_month . '-01'));
                }else{
                     $days_in_month = cal_days_in_month(CAL_GREGORIAN, $month_number, date('Y'));
              
                }
               
                $found = false;
                foreach ($result as $row)
                {
                     if (date('F', strtotime($row['x'])) == $month_name) 
                     {
          
                       $running_hours = $row['running_minutes'] * $days_in_month;
                       $availability = ($row['t_minute'] / $running_hours) * 100;
                       $availability_value =number_format($availability, 2);
                       $formatted_result[] = [
                            'x' => $month_name,
                            'y' => $availability_value
                            ];
                        $found = true;
                        break;
                     }
                }

                if (!$found) {
                    $formatted_result[] = [
                        'x' => $month_name,
                        'y' => 0
                    ];
                }
            }

            return $formatted_result;

        }else{

            if ($site_id != '') 
            {
                $this->db->where('ws.id', $site_id);
            }
               $currentMonth = date('n');
               $currentYear = date('Y');
               $startMonth = 4;
               $endmonth = 3;
               if ($currentMonth >= $startMonth && $currentMonth <= 12) 
               {
                   $start_Year = $currentYear;
                   $end_Year = $currentYear + 1;
               } elseif ($currentMonth >= 1 && $currentMonth <= $endMonth) 
               {
                   $start_Year = $currentYear - 1;
                   $end_Year = $currentYear;
               }
               $startYear = ($currentMonth < $startMonth) ? ($currentYear - 1) : $currentYear;

                if ($fin_year!= "") 
                {
                    $yearRange = explode('-', $fin_year);
                    $startYear = intval($yearRange[0]);
                }

                $endMonth = 3;
                $endYear = $startYear + 1;
                $start_date = $startYear . '-04-01';
                $end_date = $endYear . '-03-31';
                $current_date = date('Y-m-d');

                $this->db->where('wr.start_datetime >=', $start_date);
                $this->db->where('wr.start_datetime <=', $end_date);

                if($fin_year == $start_Year . '-' . $end_Year) 
                {
                 
                    $startDateTime = new DateTime($start_date);
                    $endDateTime = new DateTime($current_date);
                    $diff = $endDateTime->diff($startDateTime);
                    $num_days_in_fin_year = $diff->days + 1;
                }else {
                   
                    $startDateTime = new DateTime($start_date);
                    $endDateTime = new DateTime($end_date);
                    $diff = $endDateTime->diff($startDateTime);
                    $num_days_in_fin_year = $diff->days + 1;
                } 


            $result = $this->db->select('wm.well_name as x,SUM(wr.total_running_minute) AS t_minute,vw.running_minutes')
                        ->from('tbl_site_device_installation sd')
                        ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
                        ->join('tbl_well_running_log wr', 'wm.id = wr.well_id', 'left')
                        ->join('tbl_well_site_master ws', 'ws.id=sd.site_id and ws.status =1', 'left')
                        ->join('v_well_running_config vw', 'vw.well_id = sd.well_id', 'left')
                        ->where(['sd.status' => 1])
                        ->group_by('sd.well_id')  
                        ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
                        ->get()
                        ->result_array();

               foreach ($result as &$row) 
               {
                 $row['running_minutes'] *= $num_days_in_fin_year;
                 $availability = ($row['t_minute'] / $row['running_minutes']) * 100;
                 $row['y'] = number_format($availability, 2) . ' % ';
                 $row = array('x'=>$row['x'], 'y'=>$row['y'] );
                 
                
               }

            return $result;
             
        }
    }


    public function Device_mis_log_report($imei_no,$from_date,$to_date)
    {
         if ($imei_no != '') {
            $this->db->where('imei_no', $imei_no);
        }
       

        if ($from_date != '' && $to_date != '') {
            $fromTime = date('Y-m-d 06:00:00', strtotime($from_date));
            if ($from_date == $to_date) {
                $toTime = date('Y-m-d 06:00:00', strtotime($to_date . '+1 day'));
            } else {
                $toTime = date('Y-m-d 06:00:00', strtotime($to_date . '+1 day'));
            }
            $this->db->where('offline_device_timestamp >=', $fromTime);
            $this->db->where('offline_device_timestamp <', $toTime);
        }

        return $this->db->select('imei_no,output_Current_R,output_Current_Y,output_Current_B,output_Average_Current,output_Voltage_P2P_RY,output_Voltage_P2P_YB,output_Voltage_P2P_BR,output_Average_Voltage_P2P,output_Kwh,smps_Voltage,battery_Voltage,offline_device_timestamp,last_log_datetime')
                         ->from('tbl_device_log')
                         ->where(['status'=>1])
                         ->order_by('offline_device_timestamp','ASC')
                         ->get()
                         ->result_array();
    }

   
    public function running_logdetails_linegraph($well_id,$month_id,$year,$site_id)
    {
        if ($well_id != '') 
        {
            $this->db->where('wr.well_id', $well_id);
        }

        if ($site_id != '') 
        {
            $this->db->where('ws.id', $site_id);
        }
    
        $this->db->where("MONTH(wr.start_datetime)", $month_id);
        $this->db->where("year(wr.start_datetime)", $year);

        return $this->db->select("wm.well_name as x, SUM(wr.total_running_minute) AS y")
                       ->from('tbl_site_device_installation sd')
                       ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
                       ->join('tbl_well_site_master ws', 'ws.id=sd.site_id and ws.status =1', 'left')
                       ->join('tbl_well_running_log wr','wm.id=wr.well_id', 'left')
                       ->where(['sd.status' => 1])
                       ->group_by('MONTH(wr.start_datetime),year(wr.start_datetime),sd.well_id') 
                       ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
                       ->get()
                       ->result_array();

        
    }

    public function energy_consumption_details_linegraph($well_id,$month_id,$year,$site_id)
    {
        if ($well_id != '') 
        {
            $this->db->where('wr.well_id', $well_id);
        }

        if ($site_id != '') 
        {
            $this->db->where('ws.id', $site_id);
        }
    
        $this->db->where("MONTH(wr.start_datetime)", $month_id);
        $this->db->where("year(wr.start_datetime)", $year);

        return  $this->db->select("wm.well_name as x, SUM(wr.total_kwh) AS y")
                       ->from('tbl_site_device_installation sd')
                       ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
                       ->join('tbl_well_site_master ws', 'ws.id=sd.site_id and ws.status =1', 'left')
                       ->join('tbl_well_running_log wr','wm.id=wr.well_id', 'left')
                       ->where(['sd.status' => 1])
                       ->group_by('MONTH(wr.start_datetime),year(wr.start_datetime),sd.well_id') 
                       ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
                       ->get()
                       ->result_array();
     

    }

    public  function Running_shutdown_details_linegraph($well_id,$month_id,$year,$site_id)
    {
        $result = [];

        if ($well_id != '') 
        {
            $this->db->where('wr.well_id', $well_id);
        }

        if ($site_id != '') 
        {
            $this->db->where('ws.id', $site_id);
        }
        
        $this->db->where("MONTH(wr.start_datetime)", $month_id);
        $this->db->where("YEAR(wr.start_datetime)", $year);

        $result['running_minutes'] = $this->db->select("wm.well_name as x, 
                                  SUM(wr.total_running_minute) AS y")
                    ->from('tbl_site_device_installation sd')
                    ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
                    ->join('tbl_well_site_master ws', 'ws.id=sd.site_id and ws.status =1', 'left')
                    ->join('tbl_well_running_log wr', 'wm.id = wr.well_id', 'left')
                    ->where(['sd.status' => 1])
                    ->group_by('MONTH(wr.start_datetime), YEAR(wr.start_datetime), sd.well_id') 
                    ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
                    ->get()
                    ->result_array();

        if ($well_id != '') {
            $this->db->where('wr.well_id', $well_id);
        }

        if ($site_id != '') 
        {
            $this->db->where('ws.id', $site_id);
        }
        
        $this->db->where("MONTH(wr.start_datetime)", $month_id);
        $this->db->where("YEAR(wr.start_datetime)", $year);

        $current_month = date('m');
        $current_year = date('Y');
        $current_day = date('d');
       
        if($current_month == $month_id && $current_year == $year)
        {
            $num_days_in_month = date($current_day, strtotime($current_year . '-' . $current_month . '-01'));
        }else{
            $num_days_in_month = cal_days_in_month(CAL_GREGORIAN, $month_id, $year);

        }

        $result['shutdown_minutes'] = $this->db->select("wm.well_name as x, 
                                  SUM(wr.total_running_minute) AS t_minute,vw.running_minutes")
                    ->from('tbl_site_device_installation sd')
                    ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
                    ->join('tbl_well_site_master ws', 'ws.id=sd.site_id and ws.status =1', 'left')
                    ->join('tbl_well_running_log wr', 'wm.id = wr.well_id', 'left')
                    ->join('v_well_running_config vw', 'vw.well_id = sd.well_id', 'left')
                    ->where(['sd.status' => 1])
                    ->group_by('MONTH(wr.start_datetime), YEAR(wr.start_datetime), sd.well_id') 
                    ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
                    ->get()
                    ->result_array();


           foreach ($result['shutdown_minutes'] as &$row) 
           {
             $running_hours = $row['running_minutes'] * $num_days_in_month;
             $row['y'] = $running_hours - $row['t_minute'];
             $row = array('x'=>$row['x'], 'y'=>$row['y'] );
           }

           return $result;

    }

    public function well_performance_details_linegraph($well_id,$month_id,$year,$site_id)
    {
        if ($well_id != '') {
            $this->db->where('wr.well_id', $well_id);
        }

        if ($site_id != '') 
        {
            $this->db->where('ws.id', $site_id);
        }
        
        $this->db->where("MONTH(wr.start_datetime)", $month_id);
        $this->db->where("YEAR(wr.start_datetime)", $year);

        $current_month = date('m');
        $current_year = date('Y');
        $current_day = date('d');

        if($current_month == $month_id && $current_year == $year)
        {
            $num_days_in_month = date($current_day, strtotime($current_year . '-' . $current_month . '-01'));
        }else{
            $num_days_in_month = cal_days_in_month(CAL_GREGORIAN, $month_id, $year);

        }

        // print_r($num_days_in_month);die;
       
        $result = $this->db->select("wm.well_name as x, 
                                  SUM(wr.total_running_minute) AS t_minute,vw.running_minutes")
                    ->from('tbl_site_device_installation sd')
                    ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
                    ->join('tbl_well_site_master ws', 'ws.id=sd.site_id and ws.status =1', 'left')
                    ->join('tbl_well_running_log wr', 'wm.id = wr.well_id', 'left')
                    ->join('v_well_running_config vw', 'vw.well_id = sd.well_id', 'left')
                    ->where(['sd.status' => 1])
                    ->group_by('MONTH(wr.start_datetime), YEAR(wr.start_datetime), sd.well_id') 
                    ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
                    ->get()
                    ->result_array();

           foreach ($result as &$row) 
           {
             $row['running_minutes'] *= $num_days_in_month;
             $availability = ($row['t_minute'] / $row['running_minutes']) * 100;
             $row['y'] = number_format($availability, 2);
             $row = array('x'=>$row['x'], 'y'=>$row['y'] );
            
           }

        return $result;
    }



    public function fin_running_logdetails_linegraph($well_id,$fin_year,$site_id)
    {
        if($well_id != "") 
        {
           if ($site_id != '') 
            {
                $this->db->where('ws.id', $site_id);
            }
        
           $currentMonth = date('n');
           $currentYear = date('Y');
           $startMonth = 4;
           $startYear = ($currentMonth < $startMonth) ? ($currentYear - 1) : $currentYear;


            if ($fin_year!= "") 
            {
                $yearRange = explode('-', $fin_year);
                $startYear = intval($yearRange[0]);
            }

            $endMonth = 3;
            $endYear = $startYear + 1;
            $start_date = $startYear . '-04-01';
            $end_date = $endYear . '-03-31';

  
            $this->db->where('wr.start_datetime >=', $start_date);
            $this->db->where('wr.start_datetime <=', $end_date);

            $result = $this->db->select('MONTHNAME(wr.start_datetime) AS x, COALESCE(SUM(wr.total_running_minute), 0) AS y')
                       ->from('tbl_site_device_installation sd')
                       ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
                       ->join('tbl_well_site_master ws', 'ws.id=sd.site_id and ws.status =1', 'left')
                       ->join('tbl_well_running_log wr', 'wm.id=wr.well_id', 'left')
                       ->where(['sd.status' => 1])
                       ->where('sd.well_id', $well_id)
                       ->group_by('MONTH(wr.start_datetime)')->get()->result_array();
            $formatted_result = [];
            for ($month = 4; $month <= 15; $month++) { 
                $month_number = ($month <= 12) ? $month : $month - 12; 
                $month_name = date("F", mktime(0, 0, 0, $month_number, 1));
                $found = false;
                foreach ($result as $row) {
                    if (date('F', strtotime($row['x'])) == $month_name) {
                        $formatted_result[] = $row;
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    $formatted_result[] = ['x' => $month_name, 'y' => 0];
                }
            }

         return $formatted_result;

        }else{

            if ($site_id != '') 
            {
                $this->db->where('ws.id', $site_id);
            }
        
           $currentMonth = date('n');
           $currentYear = date('Y');
           $startMonth = 4;
           $startYear = ($currentMonth < $startMonth) ? ($currentYear - 1) : $currentYear;



            if ($fin_year!= "") 
            {
                $yearRange = explode('-', $fin_year);
                $startYear = intval($yearRange[0]);
            }

            $endMonth = 3;
            $endYear = $startYear + 1;
            $start_date = $startYear . '-04-01';
            $end_date = $endYear . '-03-31';

  
            $this->db->where('wr.start_datetime >=', $start_date);
            $this->db->where('wr.start_datetime <=', $end_date);

        return $this->db->select('wm.well_name as x,SUM(wr.total_running_minute) AS y')
                       ->from('tbl_site_device_installation sd')
                       ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
                       ->join('tbl_well_site_master ws', 'ws.id=sd.site_id and ws.status =1', 'left')
                       ->join('tbl_well_running_log wr','wm.id=wr.well_id', 'left')
                       ->where(['sd.status' => 1])
                       ->group_by('sd.well_id') 
                       ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
                       ->get()
                       ->result_array();
        }
    }

    public function fin_energy_consumption_details_linegraph($well_id,$fin_year,$site_id)
    {
        if($well_id != "") 
        {
            if ($site_id != '') 
            {
               $this->db->where('ws.id', $site_id);
            }
               $currentMonth = date('n');
               $currentYear = date('Y');
               $startMonth = 4;
               $startYear = ($currentMonth < $startMonth) ? ($currentYear - 1) : $currentYear;

            if ($fin_year!= "") 
            {
                $yearRange = explode('-', $fin_year);
                $startYear = intval($yearRange[0]);
            }

            $endMonth = 3;
            $endYear = $startYear + 1;
            $start_date = $startYear . '-04-01';
            $end_date = $endYear . '-03-31';

            $this->db->where('wr.start_datetime >=', $start_date);
            $this->db->where('wr.start_datetime <=', $end_date);

            $result = $this->db->select('MONTHNAME(wr.start_datetime) AS x, COALESCE(SUM(wr.total_kwh), 0) AS y')
                       ->from('tbl_site_device_installation sd')
                       ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
                       ->join('tbl_well_site_master ws', 'ws.id=sd.site_id and ws.status =1', 'left')
                       ->join('tbl_well_running_log wr', 'wm.id=wr.well_id', 'left')
                       ->where(['sd.status' => 1])
                       ->where('sd.well_id', $well_id)
                       ->group_by('MONTH(wr.start_datetime)')->get()->result_array();

            $formatted_result = [];
            for ($month = 4; $month <= 15; $month++) { 
                $month_number = ($month <= 12) ? $month : $month - 12; 
                $month_name = date("F", mktime(0, 0, 0, $month_number, 1));
                $found = false;
                foreach ($result as $row) {
                    if (date('F', strtotime($row['x'])) == $month_name) {
                        $formatted_result[] = $row;
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    $formatted_result[] = ['x' => $month_name, 'y' => 0];
                }
            }

         return $formatted_result;
        
        }else{

        if ($site_id != '') 
        {
            $this->db->where('ws.id', $site_id);
        }
           $currentMonth = date('n');
           $currentYear = date('Y');
           $startMonth = 4;
           $startYear = ($currentMonth < $startMonth) ? ($currentYear - 1) : $currentYear;



            if ($fin_year!= "") 
            {
                $yearRange = explode('-', $fin_year);
                $startYear = intval($yearRange[0]);
            }

            $endMonth = 3;
            $endYear = $startYear + 1;
            $start_date = $startYear . '-04-01';
            $end_date = $endYear . '-03-31';

  
            $this->db->where('wr.start_datetime >=', $start_date);
            $this->db->where('wr.start_datetime <=', $end_date);

            return $this->db->select('wm.well_name as x,SUM(wr.total_kwh) AS y')
                       ->from('tbl_site_device_installation sd')
                       ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
                       ->join('tbl_well_site_master ws', 'ws.id=sd.site_id and ws.status =1', 'left')
                       ->join('tbl_well_running_log wr','wm.id=wr.well_id', 'left')
                       ->where(['sd.status' => 1])
                       ->group_by('sd.well_id') 
                       ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
                       ->get()
                       ->result_array();
        }

    }

    public function fin_Running_shutdown_details_linegraph($well_id,$fin_year,$site_id)
    {
        $result = [];

        if($well_id != "") 
        {

            if ($site_id != '') 
            {
                $this->db->where('ws.id', $site_id);
            }
               $currentMonth = date('n');
               $currentYear = date('Y');
               $startMonth = 4;
               $endmonth = 3;
               if ($currentMonth >= $startMonth && $currentMonth <= 12) 
               {
                   $start_Year = $currentYear;
                   $end_Year = $currentYear + 1;
               } elseif ($currentMonth >= 1 && $currentMonth <= $endMonth) 
               {
                   $start_Year = $currentYear - 1;
                   $end_Year = $currentYear;
               }

               $startYear = ($currentMonth < $startMonth) ? ($currentYear - 1) : $currentYear;

                if ($fin_year!= "") 
                {
                    $yearRange = explode('-', $fin_year);
                    $startYear = intval($yearRange[0]);


                }

                $endMonth = 3;
                $endYear = $startYear + 1;
                $start_date = $startYear . '-04-01';
                $end_date = $endYear . '-03-31';
                $current_date = date('Y-m-d');

                $this->db->where('wr.start_datetime >=', $start_date);
                $this->db->where('wr.start_datetime <=', $end_date);

            $result = $this->db->select('MONTHNAME(wr.start_datetime) AS x, COALESCE(SUM(wr.total_running_minute), 0) AS y')
                       ->from('tbl_site_device_installation sd')
                       ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
                       ->join('tbl_well_site_master ws', 'ws.id=sd.site_id and ws.status =1', 'left')
                       ->join('tbl_well_running_log wr', 'wm.id=wr.well_id', 'left')
                       ->where(['sd.status' => 1])
                       ->where('sd.well_id', $well_id)
                       ->group_by('MONTH(wr.start_datetime)')->get()->result_array();
            $formatted_result_daat = [];
            for ($month = 4; $month <= 15; $month++) { 
                $month_number = ($month <= 12) ? $month : $month - 12; 
                $month_name = date("F", mktime(0, 0, 0, $month_number, 1));
                $found = false;
                foreach ($result as $row) {
                    if (date('F', strtotime($row['x'])) == $month_name) {
                        $formatted_result_daat[] = $row;
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    $formatted_result_daat[] = ['x' => $month_name, 'y' => 0];
                }
            }

         // return $formatted_result;

           if($site_id != '') 
            {
                $this->db->where('ws.id', $site_id);
            }


               $currentMonth = date('n');
               $currentYear = date('Y');
               $startMonth = 4;
               $endmonth = 3;
               if ($currentMonth >= $startMonth && $currentMonth <= 12) 
               {
                   $start_Year = $currentYear;
                   $end_Year = $currentYear + 1;
               } elseif ($currentMonth >= 1 && $currentMonth <= $endMonth) 
               {
                   $start_Year = $currentYear - 1;
                   $end_Year = $currentYear;
               }

               $startYear = ($currentMonth < $startMonth) ? ($currentYear - 1) : $currentYear;

                if ($fin_year!= "") 
                {
                    $yearRange = explode('-', $fin_year);
                    $startYear = intval($yearRange[0]);


                }

                $endMonth = 3;
                $endYear = $startYear + 1;
                $start_date = $startYear . '-04-01';
                $end_date = $endYear . '-03-31';
                $current_date = date('Y-m-d');

                $this->db->where('wr.start_datetime >=', $start_date);
                $this->db->where('wr.start_datetime <=', $end_date);

             $result = $this->db->select('MONTHNAME(wr.start_datetime) AS x, COALESCE(SUM(wr.total_running_minute),0) AS t_minute,vw.running_minutes')
                   ->from('tbl_site_device_installation sd')
                   ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
                   ->join('tbl_well_site_master ws', 'ws.id=sd.site_id and ws.status =1', 'left')
                   ->join('tbl_well_running_log wr', 'wm.id = wr.well_id', 'left')
                   ->join('v_well_running_config vw', 'vw.well_id = sd.well_id', 'left')
                   ->where(['sd.status' => 1])
                   ->where('sd.well_id', $well_id)
                   ->group_by('MONTH(wr.start_datetime)')->get()->result_array();
            $formatted_result = [];
            for ($month = 4; $month <= 15; $month++) 
            { 
                $month_number = ($month <= 12) ? $month : $month - 12; 
                $month_name = date("F", mktime(0, 0, 0, $month_number, 1));
                $current_month = date('m');
                $current_year = date('Y');
                $current_day = date('d');
                if($current_month == $month_number && $current_year == date('Y'))
                {
                   $days_in_month = date($current_day, strtotime($current_year . '-' . $current_month . '-01'));
                }else{
                     $days_in_month = cal_days_in_month(CAL_GREGORIAN, $month_number, date('Y'));
              
                }
               
                $found = false;
                foreach ($result as $row)
                {
                     if (date('F', strtotime($row['x'])) == $month_name) 
                     {
          
                       $running_hours = $row['running_minutes'] * $days_in_month;
                       $shutdown_hours = $running_hours - $row['t_minute'];
                       $formatted_result[] = [
                            'x' => $month_name,
                            'y' => $shutdown_hours
                            ];
                        $found = true;
                        break;
                     }
                }

                if (!$found) {
                    $formatted_result[] = [
                        'x' => $month_name,
                        'y' => 0
                    ];
                }
            }

            return ['running'=>$formatted_result_daat,'shutdown_minutes' => $formatted_result];

        }else{

            if ($site_id != '') 
            {
                $this->db->where('ws.id', $site_id);
            }
               $currentMonth = date('n');
               $currentYear = date('Y');
               $startMonth = 4;
               $endmonth = 3;
               if ($currentMonth >= $startMonth && $currentMonth <= 12) 
               {
                   $start_Year = $currentYear;
                   $end_Year = $currentYear + 1;
               } elseif ($currentMonth >= 1 && $currentMonth <= $endMonth) 
               {
                   $start_Year = $currentYear - 1;
                   $end_Year = $currentYear;
               }

               $startYear = ($currentMonth < $startMonth) ? ($currentYear - 1) : $currentYear;

                if ($fin_year!= "") 
                {
                    $yearRange = explode('-', $fin_year);
                    $startYear = intval($yearRange[0]);


                }

                $endMonth = 3;
                $endYear = $startYear + 1;
                $start_date = $startYear . '-04-01';
                $end_date = $endYear . '-03-31';
                $current_date = date('Y-m-d');

                $this->db->where('wr.start_datetime >=', $start_date);
                $this->db->where('wr.start_datetime <=', $end_date);


            $result['running'] = $this->db->select('wm.well_name as x,SUM(wr.total_running_minute) AS y')
                        ->from('tbl_site_device_installation sd')
                        ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
                        ->join('tbl_well_site_master ws', 'ws.id=sd.site_id and ws.status =1', 'left')
                        ->join('tbl_well_running_log wr', 'wm.id = wr.well_id', 'left')
                        ->where(['sd.status' => 1])
                        ->group_by('sd.well_id') 
                        ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
                        ->get()
                        ->result_array();
             if($site_id != '') 
            {
                $this->db->where('ws.id', $site_id);
            }


               $currentMonth = date('n');
               $currentYear = date('Y');
               $startMonth = 4;
               $endmonth = 3;
               if ($currentMonth >= $startMonth && $currentMonth <= 12) 
               {
                   $start_Year = $currentYear;
                   $end_Year = $currentYear + 1;
               } elseif ($currentMonth >= 1 && $currentMonth <= $endMonth) 
               {
                   $start_Year = $currentYear - 1;
                   $end_Year = $currentYear;
               }

               $startYear = ($currentMonth < $startMonth) ? ($currentYear - 1) : $currentYear;

                if ($fin_year!= "") 
                {
                    $yearRange = explode('-', $fin_year);
                    $startYear = intval($yearRange[0]);


                }

                $endMonth = 3;
                $endYear = $startYear + 1;
                $start_date = $startYear . '-04-01';
                $end_date = $endYear . '-03-31';
                $current_date = date('Y-m-d');

                $this->db->where('wr.start_datetime >=', $start_date);
                $this->db->where('wr.start_datetime <=', $end_date);

            if ($fin_year == $start_Year . '-' . $end_Year) 
            {
             
                $startDateTime = new DateTime($start_date);
                $endDateTime = new DateTime($current_date);
                $diff = $endDateTime->diff($startDateTime);
                $num_days_in_fin_year = $diff->days + 1;
            } else {
               
                $startDateTime = new DateTime($start_date);
                $endDateTime = new DateTime($end_date);
                $diff = $endDateTime->diff($startDateTime);
                $num_days_in_fin_year = $diff->days + 1;
            }


            $result['shutdown_minutes'] = $this->db->select('wm.well_name as x,SUM(wr.total_running_minute) AS t_minute,vw.running_minutes')
                        ->from('tbl_site_device_installation sd')
                        ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
                        ->join('tbl_well_site_master ws', 'ws.id=sd.site_id and ws.status =1', 'left')
                        ->join('tbl_well_running_log wr', 'wm.id = wr.well_id', 'left')
                        ->join('v_well_running_config vw', 'vw.well_id = sd.well_id', 'left')
                        ->where(['sd.status' => 1])
                        ->group_by('sd.well_id') 
                        ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
                        ->get()
                        ->result_array();

               foreach ($result['shutdown_minutes'] as &$row) 
               {
                $row['running_minutes'] *= $num_days_in_fin_year;
                $row['y'] = $row['running_minutes'] - $row['t_minute'];
                $row = array('x'=>$row['x'], 'y'=>$row['y'] );
                
               }

            return $result;
        }
    }

    public function fin_well_performance_details_linegraph($well_id,$fin_year,$site_id)
    {
        if($well_id != "") 
        {
            if ($site_id != '') 
            {
                $this->db->where('ws.id', $site_id);
            }
               $currentMonth = date('n');
               $currentYear = date('Y');
               $startMonth = 4;
               $endmonth = 3;
               if ($currentMonth >= $startMonth && $currentMonth <= 12) 
               {
                   $start_Year = $currentYear;
                   $end_Year = $currentYear + 1;
               } elseif ($currentMonth >= 1 && $currentMonth <= $endMonth) 
               {
                   $start_Year = $currentYear - 1;
                   $end_Year = $currentYear;
               }
               $startYear = ($currentMonth < $startMonth) ? ($currentYear - 1) : $currentYear;

                if ($fin_year!= "") 
                {
                    $yearRange = explode('-', $fin_year);
                    $startYear = intval($yearRange[0]);
                }

                $endMonth = 3;
                $endYear = $startYear + 1;
                $start_date = $startYear . '-04-01';
                $end_date = $endYear . '-03-31';
                $current_date = date('Y-m-d');

                $this->db->where('wr.start_datetime >=', $start_date);
                $this->db->where('wr.start_datetime <=', $end_date);

                 $result = $this->db->select('MONTHNAME(wr.start_datetime) AS x, COALESCE(SUM(wr.total_running_minute),0) AS t_minute,vw.running_minutes')
                   ->from('tbl_site_device_installation sd')
                   ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
                   ->join('tbl_well_site_master ws', 'ws.id=sd.site_id and ws.status =1', 'left')
                   ->join('tbl_well_running_log wr', 'wm.id = wr.well_id', 'left')
                   ->join('v_well_running_config vw', 'vw.well_id = sd.well_id', 'left')
                   ->where(['sd.status' => 1])
                   ->where('sd.well_id', $well_id)
                   ->group_by('MONTH(wr.start_datetime)')->get()->result_array();
            $formatted_result = [];
            for ($month = 4; $month <= 15; $month++) 
            { 
                $month_number = ($month <= 12) ? $month : $month - 12; 
                $month_name = date("F", mktime(0, 0, 0, $month_number, 1));
                $current_month = date('m');
                $current_year = date('Y');
                $current_day = date('d');
                if($current_month == $month_number && $current_year == date('Y'))
                {
                   $days_in_month = date($current_day, strtotime($current_year . '-' . $current_month . '-01'));
                }else{
                     $days_in_month = cal_days_in_month(CAL_GREGORIAN, $month_number, date('Y'));
              
                }
               
                $found = false;
                foreach ($result as $row)
                {
                     if (date('F', strtotime($row['x'])) == $month_name) 
                     {
          
                       $running_hours = $row['running_minutes'] * $days_in_month;
                       $availability = ($row['t_minute'] / $running_hours) * 100;
                       $availability_value =number_format($availability, 2);
                       $formatted_result[] = [
                            'x' => $month_name,
                            'y' => $availability_value
                            ];
                        $found = true;
                        break;
                     }
                }

                if (!$found) {
                    $formatted_result[] = [
                        'x' => $month_name,
                        'y' => 0
                    ];
                }
            }

            return $formatted_result;

        }else{

            if ($site_id != '') 
            {
                $this->db->where('ws.id', $site_id);
            }
               $currentMonth = date('n');
               $currentYear = date('Y');
               $startMonth = 4;
               $endmonth = 3;
               if ($currentMonth >= $startMonth && $currentMonth <= 12) 
               {
                   $start_Year = $currentYear;
                   $end_Year = $currentYear + 1;
               } elseif ($currentMonth >= 1 && $currentMonth <= $endMonth) 
               {
                   $start_Year = $currentYear - 1;
                   $end_Year = $currentYear;
               }
               $startYear = ($currentMonth < $startMonth) ? ($currentYear - 1) : $currentYear;

                if ($fin_year!= "") 
                {
                    $yearRange = explode('-', $fin_year);
                    $startYear = intval($yearRange[0]);
                }

                $endMonth = 3;
                $endYear = $startYear + 1;
                $start_date = $startYear . '-04-01';
                $end_date = $endYear . '-03-31';
                $current_date = date('Y-m-d');

                $this->db->where('wr.start_datetime >=', $start_date);
                $this->db->where('wr.start_datetime <=', $end_date);

                if($fin_year == $start_Year . '-' . $end_Year) 
                {
                 
                    $startDateTime = new DateTime($start_date);
                    $endDateTime = new DateTime($current_date);
                    $diff = $endDateTime->diff($startDateTime);
                    $num_days_in_fin_year = $diff->days + 1;
                }else {
                   
                    $startDateTime = new DateTime($start_date);
                    $endDateTime = new DateTime($end_date);
                    $diff = $endDateTime->diff($startDateTime);
                    $num_days_in_fin_year = $diff->days + 1;
                } 


            $result = $this->db->select('wm.well_name as x,SUM(wr.total_running_minute) AS t_minute,vw.running_minutes')
                        ->from('tbl_site_device_installation sd')
                        ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
                        ->join('tbl_well_running_log wr', 'wm.id = wr.well_id', 'left')
                        ->join('tbl_well_site_master ws', 'ws.id=sd.site_id and ws.status =1', 'left')
                        ->join('v_well_running_config vw', 'vw.well_id = sd.well_id', 'left')
                        ->where(['sd.status' => 1])
                        ->group_by('MONTH(wr.start_datetime), YEAR(wr.start_datetime), sd.well_id') 
                        ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
                        ->get()
                        ->result_array();

               foreach ($result as &$row) 
               {
                 $row['running_minutes'] *= $num_days_in_fin_year;
                 $availability = ($row['t_minute'] / $row['running_minutes']) * 100;
                 $row['y'] = number_format($availability, 2);
                 $row = array('x'=>$row['x'], 'y'=>$row['y'] );
                 
                
               }

          return $result;
        }   
   }
 
   public function ime_no_list_get($imei_no)
   {
    if ($imei_no != '') {
        $this->db->where('sd.imei_no', $imei_no);
    }
    
    return $this->db->select('sd.imei_no, wm.well_name')
                   ->from('tbl_site_device_installation sd')
                   ->join('tbl_well_master wm', 'wm.id = sd.well_id')
                   ->join('tbl_device_setup dm', 'sd.imei_no = dm.imei_no')
                   ->where(['sd.status' => 1, 'wm.status' => 1, 'dm.status' => 1,'sd.device_shifted'=>0])
                   ->get()
                   ->result_array();
   }

 
}
?>

