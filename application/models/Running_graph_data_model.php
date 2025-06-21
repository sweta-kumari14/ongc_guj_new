<?php
date_default_timezone_set('Asia/Kolkata');
class Running_graph_data_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function well_running_graph_comparison($site_id, $well_id, $month, $year)
    {
	    $current_month = date('m');
	    $current_year = date('Y');
	    $current_day = date('d');

	    if ($current_month == $month && $current_year == $year) {

	        if ($well_id != '') {
	            $this->db->where('wr.well_id', $well_id);
	        }

	        if ($site_id != '') {
	            $this->db->where('ws.id', $site_id);
	        }

	         function get_last_day_of_previous_month($month, $year) {
                 $date = DateTime::createFromFormat('m-Y', sprintf("%02d-%d", $month - 1, $year));
                return $date->format('t');
             }


	        if($current_day == 01)
	        {
	        	$previous_month = sprintf("%02d", $month - 1);
	        	$last_day_previous_month = get_last_day_of_previous_month($previous_month, $year);
                $startmonth = date('Y') . '-' . $previous_month . '-'.$last_day_previous_month.' 06:00:00';
	            $endmonth = date('Y') . '-' . $month . '-' . $current_day . ' 05:59:59';

	        }else{

	        	$startmonth = date('Y') . '-' . $month . '-01 06:00:00';
	            $endmonth = date('Y') . '-' . $month . '-' . $current_day . ' 05:59:59';

	        }

	        $this->db->where('wr.start_datetime >=', $startmonth);
	        $this->db->where('wr.end_datetime <=', $endmonth);

	        $current = $this->db->select("wm.well_name, wm.well_name AS x, SUM(wr.total_running_minute) AS y, MONTHNAME(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)) as month_name")
	            ->from('tbl_site_device_installation sd')
	            ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
	            ->join('tbl_well_site_master ws', 'ws.id = sd.site_id and ws.status = 1', 'left')
	            ->join('tbl_well_running_log wr', 'wm.id = wr.well_id', 'left')
	            ->where(['sd.status' => 1])
	            ->group_by('MONTH(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), year(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), sd.well_id')
	            ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
	            ->get()
	            ->result_array();

	        if ($well_id != '') {
	            $this->db->where('wr.well_id', $well_id);
	        }

	        if ($site_id != '') {
	            $this->db->where('ws.id', $site_id);
	        }

	        $next_month = sprintf("%02d", $month + 1);
	        $previous_month = sprintf("%02d", $month - 1);
            if($current_day == 01)
	        {
	        	$previous_month = sprintf("%02d", $month - 1);
	        	$last_day_previous_month = get_last_day_of_previous_month($previous_month, $year);
                $startmonth = date('Y') . '-' . $previous_month . '-'.$last_day_previous_month.' 06:00:00';
	            $endmonth = date('Y') . '-' . $next_month . '-' . $current_day . ' 05:59:59';

	        }else{
	        	 $startmonth = date('Y') . '-' . $previous_month . '-01 06:00:00';
	             $endmonth = date('Y') . '-' . $previous_month . '-' . $current_day . ' 05:59:59';
	        }
	       

	        $this->db->where('wr.start_datetime >=', $startmonth);
	        $this->db->where('wr.end_datetime <=', $endmonth);

	        $previous = $this->db->select("wm.well_name, wm.well_name AS x, SUM(wr.total_running_minute) AS y, MONTHNAME(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)) as month_name")
	            ->from('tbl_site_device_installation sd')
	            ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
	            ->join('tbl_well_site_master ws', 'ws.id = sd.site_id and ws.status = 1', 'left')
	            ->join('tbl_well_running_log wr', 'wm.id = wr.well_id', 'left')
	            ->where(['sd.status' => 1])
	            ->group_by('MONTH(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), year(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), sd.well_id')
	            ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
	            ->get()
	            ->result_array();

	    } else {

	        $next_month = sprintf("%02d", $month + 1);
	        $previous_month = sprintf("%02d", $month - 1);

	        if ($well_id != '') {
	            $this->db->where('wr.well_id', $well_id);
	        }

	        if ($site_id != '') {
	            $this->db->where('ws.id', $site_id);
	        }

	        $startmonth = date('Y') . '-' . $month . '-01 06:00:00';
	        $endmonth = date('Y') . '-' . $next_month . '-01 05:59:59';

	        $this->db->where('wr.start_datetime >=', $startmonth);
	        $this->db->where('wr.end_datetime <=', $endmonth);

	        $current = $this->db->select("wm.well_name, wm.well_name AS x, SUM(wr.total_running_minute) AS y, MONTHNAME(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)) as month_name")
	            ->from('tbl_site_device_installation sd')
	            ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
	            ->join('tbl_well_site_master ws', 'ws.id = sd.site_id and ws.status = 1', 'left')
	            ->join('tbl_well_running_log wr', 'wm.id = wr.well_id', 'left')
	            ->where(['sd.status' => 1])
	            ->group_by('MONTH(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), year(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), sd.well_id')
	            ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
	            ->get()
	            ->result_array();

	        if ($well_id != '') {
	            $this->db->where('wr.well_id', $well_id);
	        }

	        if ($site_id != '') {
	            $this->db->where('ws.id', $site_id);
	        }

	        $startmonth = date('Y') . '-' . $previous_month . '-01 06:00:00';
	        $endmonth = date('Y') . '-' . $month . '-01 05:59:59';

	        $this->db->where('wr.start_datetime >=', $startmonth);
	        $this->db->where('wr.end_datetime <=', $endmonth);

	        $previous = $this->db->select("wm.well_name, wm.well_name AS x, SUM(wr.total_running_minute) AS y, MONTHNAME(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)) as month_name")
	            ->from('tbl_site_device_installation sd')
	            ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
	            ->join('tbl_well_site_master ws', 'ws.id = sd.site_id and ws.status = 1', 'left')
	            ->join('tbl_well_running_log wr', 'wm.id = wr.well_id', 'left')
	            ->where(['sd.status' => 1])
	            ->group_by('MONTH(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), year(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), sd.well_id')
	            ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
	            ->get()
	            ->result_array();
	    }

	    $merged_results = [];

	    foreach ($current as $current_row) {
	        $well_name = $current_row['well_name'];
	        $merged_results[$well_name] = [
	            'well_name' => $well_name,
	            'x' => $current_row['x'],
	            'y' => $current_row['y'],
	            'z' => 0,
	           
	        ];
	    }

	    foreach ($previous as $previous_row) {
	        $well_name = $previous_row['well_name'];
	        if (isset($merged_results[$well_name])) {
	            $merged_results[$well_name]['x'] = $merged_results[$well_name]['x'];
	            $merged_results[$well_name]['z'] = $previous_row['y'];
	        } else {
	            $merged_results[$well_name] = [
	                'well_name' => $well_name,
	                'x' => $previous_row['x'],
	                'y' => 0,
	                'z' => $previous_row['y'],
	                
	            ];
	        }
	    }

	    $flattened_results = array_values($merged_results);

	    return $flattened_results;
    }

    public function well_energy_graph_comparison($site_id, $well_id, $month, $year)
    { 
    	$current_month = date('m');
	    $current_year = date('Y');
	    $current_day = date('d');

	    if ($current_month == $month && $current_year == $year) {

	        if ($well_id != '') {
	            $this->db->where('wr.well_id', $well_id);
	        }

	        if ($site_id != '') {
	            $this->db->where('ws.id', $site_id);
	        }

	         function get_last_day_of_previous_month($month, $year) {
                 $date = DateTime::createFromFormat('m-Y', sprintf("%02d-%d", $month - 1, $year));
                return $date->format('t');
             }


	        if($current_day == 01)
	        {
	        	$previous_month = sprintf("%02d", $month - 1);
	        	$last_day_previous_month = get_last_day_of_previous_month($previous_month, $year);
                $startmonth = date('Y') . '-' . $previous_month . '-'.$last_day_previous_month.' 06:00:00';
	            $endmonth = date('Y') . '-' . $month . '-' . $current_day . ' 05:59:59';

	        }else{

	        	$startmonth = date('Y') . '-' . $month . '-01 06:00:00';
	            $endmonth = date('Y') . '-' . $month . '-' . $current_day . ' 05:59:59';

	        }

	        $this->db->where('wr.start_datetime >=', $startmonth);
	        $this->db->where('wr.end_datetime <=', $endmonth);

	        $current = $this->db->select("wm.well_name, wm.well_name AS x, SUM(wr.total_kwh) AS y, MONTHNAME(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)) as month_name")
	            ->from('tbl_site_device_installation sd')
	            ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
	            ->join('tbl_well_site_master ws', 'ws.id = sd.site_id and ws.status = 1', 'left')
	            ->join('tbl_well_running_log wr', 'wm.id = wr.well_id', 'left')
	            ->where(['sd.status' => 1])
	            ->group_by('MONTH(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), year(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), sd.well_id')
	            ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
	            ->get()
	            ->result_array();

	        if ($well_id != '') {
	            $this->db->where('wr.well_id', $well_id);
	        }

	        if ($site_id != '') {
	            $this->db->where('ws.id', $site_id);
	        }

	        $next_month = sprintf("%02d", $month + 1);
	        $previous_month = sprintf("%02d", $month - 1);
            if($current_day == 01)
	        {
	        	$previous_month = sprintf("%02d", $month - 1);
	        	$last_day_previous_month = get_last_day_of_previous_month($previous_month, $year);
                $startmonth = date('Y') . '-' . $previous_month . '-'.$last_day_previous_month.' 06:00:00';
	            $endmonth = date('Y') . '-' . $next_month . '-' . $current_day . ' 05:59:59';

	        }else{
	        	 $startmonth = date('Y') . '-' . $previous_month . '-01 06:00:00';
	             $endmonth = date('Y') . '-' . $previous_month . '-' . $current_day . ' 05:59:59';
	        }
	       

	        $this->db->where('wr.start_datetime >=', $startmonth);
	        $this->db->where('wr.end_datetime <=', $endmonth);

	        $previous = $this->db->select("wm.well_name, wm.well_name AS x, SUM(wr.total_kwh) AS y, MONTHNAME(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)) as month_name")
	            ->from('tbl_site_device_installation sd')
	            ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
	            ->join('tbl_well_site_master ws', 'ws.id = sd.site_id and ws.status = 1', 'left')
	            ->join('tbl_well_running_log wr', 'wm.id = wr.well_id', 'left')
	            ->where(['sd.status' => 1])
	            ->group_by('MONTH(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), year(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), sd.well_id')
	            ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
	            ->get()
	            ->result_array();

	    } else {

	        $next_month = sprintf("%02d", $month + 1);
	        $previous_month = sprintf("%02d", $month - 1);

	        if ($well_id != '') {
	            $this->db->where('wr.well_id', $well_id);
	        }

	        if ($site_id != '') {
	            $this->db->where('ws.id', $site_id);
	        }

	        $startmonth = date('Y') . '-' . $month . '-01 06:00:00';
	        $endmonth = date('Y') . '-' . $next_month . '-01 05:59:59';

	        $this->db->where('wr.start_datetime >=', $startmonth);
	        $this->db->where('wr.end_datetime <=', $endmonth);

	        $current = $this->db->select("wm.well_name, wm.well_name AS x, SUM(wr.total_kwh) AS y, MONTHNAME(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)) as month_name")
	            ->from('tbl_site_device_installation sd')
	            ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
	            ->join('tbl_well_site_master ws', 'ws.id = sd.site_id and ws.status = 1', 'left')
	            ->join('tbl_well_running_log wr', 'wm.id = wr.well_id', 'left')
	            ->where(['sd.status' => 1])
	            ->group_by('MONTH(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), year(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), sd.well_id')
	            ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
	            ->get()
	            ->result_array();

	        if ($well_id != '') {
	            $this->db->where('wr.well_id', $well_id);
	        }

	        if ($site_id != '') {
	            $this->db->where('ws.id', $site_id);
	        }

	        $startmonth = date('Y') . '-' . $previous_month . '-01 06:00:00';
	        $endmonth = date('Y') . '-' . $month . '-01 05:59:59';

	        $this->db->where('wr.start_datetime >=', $startmonth);
	        $this->db->where('wr.end_datetime <=', $endmonth);

	        $previous = $this->db->select("wm.well_name, wm.well_name AS x, SUM(wr.total_kwh) AS y, MONTHNAME(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)) as month_name")
	            ->from('tbl_site_device_installation sd')
	            ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
	            ->join('tbl_well_site_master ws', 'ws.id = sd.site_id and ws.status = 1', 'left')
	            ->join('tbl_well_running_log wr', 'wm.id = wr.well_id', 'left')
	            ->where(['sd.status' => 1])
	            ->group_by('MONTH(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), year(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), sd.well_id')
	            ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
	            ->get()
	            ->result_array();
	    }

	    $merged_results = [];

	    foreach ($current as $current_row) {
	        $well_name = $current_row['well_name'];
	        $merged_results[$well_name] = [
	            'well_name' => $well_name,
	            'x' => $current_row['x'],
	            'y' => $current_row['y'],
	            'z' => 0,
	           
	        ];
	    }

	    foreach ($previous as $previous_row) {
	        $well_name = $previous_row['well_name'];
	        if (isset($merged_results[$well_name])) {
	            $merged_results[$well_name]['x'] = $merged_results[$well_name]['x'];
	            $merged_results[$well_name]['z'] = $previous_row['y'];
	        } else {
	            $merged_results[$well_name] = [
	                'well_name' => $well_name,
	                'x' => $previous_row['x'],
	                'y' => 0,
	                'z' => $previous_row['y'],
	                
	            ];
	        }
	    }

	    $flattened_results = array_values($merged_results);

	    return $flattened_results;
    
    }

    public function well_running_schdule_graph_comparison($site_id,$well_id,$month,$year)
    {
    	$current_month = date('m');
	    $current_year = date('Y');
	    $current_day =  date('d');
	  

	    if($current_month == $month && $current_year == $year)
	    {

           if ($well_id != '') 
	       {
	        $this->db->where('wr.well_id', $well_id);
	       }

	       if ($site_id != '') {
	        $this->db->where('ws.id', $site_id);
	       }

	    	
	         function get_last_day_of_previous_month($month, $year) {
                 $date = DateTime::createFromFormat('m-Y', sprintf("%02d-%d", $month - 1, $year));
                return $date->format('t');
             }


	        if($current_day == 01)
	        {
	        	$previous_month = sprintf("%02d", $month - 1);
	        	$last_day_previous_month = get_last_day_of_previous_month($previous_month, $year);
                $startmonth = date('Y') . '-' . $previous_month . '-'.$last_day_previous_month.' 06:00:00';
	            $endmonth = date('Y') . '-' . $month . '-' . $current_day . ' 05:59:59';

	        }else{

	        	$startmonth = date('Y') . '-' . $month . '-01 06:00:00';
	            $endmonth = date('Y') . '-' . $month . '-' . $current_day . ' 05:59:59';

	        }

	        $this->db->where('wr.start_datetime >=', $startmonth);
	        $this->db->where('wr.end_datetime <=', $endmonth);

	       $current = $this->db->select("wm.well_name,sd.well_id,(wm.well_name) AS x, SUM(wr.total_running_minute) AS y")
	        ->from('tbl_site_device_installation sd')
	        ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
	        ->join('tbl_well_site_master ws', 'ws.id=sd.site_id and ws.status =1', 'left')
	        ->join('tbl_well_running_log wr','wm.id=wr.well_id', 'left')
	        ->where(['sd.status' => 1])
	        ->group_by('MONTH(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), year(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), sd.well_id') 
	        ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
	        ->get()
	        ->result_array();

	      

	      foreach ($current as &$row) {

	        $schdule_minutes = 0;
            
            for ($date = date($startmonth); $date <= date($endmonth); $date = date('Y-m-d', strtotime($date . ' +1 day'))) 
            {
            
            $running_schedule = $this->db->select('COALESCE(running_minutes,1440)AS schdule_minutes,well_id')
                ->from('v_running_schdule_minutes')
                ->where('well_id', $row['well_id'])
                ->where('apply_datetime <=', $date . ' 06:00:00')  
                ->where('COALESCE(valid_datetime, NOW()) >=', $date . ' 05:59:59')
                ->get()->row_array();


            $schdule_minutes += empty($running_schedule) ? 1440 : $running_schedule['schdule_minutes'];
              
            }

            $row['schdule_minutes'] = $schdule_minutes;


          } 
       
          if ($well_id != '') 
	      {
	        $this->db->where('wr.well_id', $well_id);
	      }

	      if ($site_id != '') {
	        $this->db->where('ws.id', $site_id);
	      }

	   
	        $next_month = sprintf("%02d", $month + 1);
	        $previous_month = sprintf("%02d", $month - 1);
            if($current_day == 01)
	        {
	        	$previous_month = sprintf("%02d", $month - 1);
	        	$last_day_previous_month = get_last_day_of_previous_month($previous_month, $year);
                $startmonth = date('Y') . '-' . $previous_month . '-'.$last_day_previous_month.' 06:00:00';
	            $endmonth = date('Y') . '-' . $next_month . '-' . $current_day . ' 05:59:59';

	        }else{
	        	 $startmonth = date('Y') . '-' . $previous_month . '-01 06:00:00';
	             $endmonth = date('Y') . '-' . $previous_month . '-' . $current_day . ' 05:59:59';
	        }
	       


	      $this->db->where('wr.start_datetime >=', $startmonth);
	      $this->db->where('wr.end_datetime <=', $endmonth);

	    $previous = $this->db->select("wm.well_name,sd.well_id, (wm.well_name) AS x, SUM(wr.total_running_minute) AS y")
	        ->from('tbl_site_device_installation sd')
	        ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
	        ->join('tbl_well_site_master ws', 'ws.id=sd.site_id and ws.status =1', 'left')
	        ->join('tbl_well_running_log wr','wm.id=wr.well_id', 'left')
	        ->where(['sd.status' => 1])
	        ->group_by('MONTH(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), year(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), sd.well_id') 
	        ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
	        ->get()
	        ->result_array();


	      foreach ($previous as &$row) {
	      	 $schdule_minutes = 0;

            for ($date = $startmonth; $date <= $endmonth; $date = date('Y-m-d', strtotime($date . ' +1 day'))) 
            {
           
            $running_schedule = $this->db->select('COALESCE(running_minutes,1440)AS schdule_minutes,well_id')
                ->from('v_running_schdule_minutes')
                ->where('well_id', $row['well_id'])
                ->where('apply_datetime <=', $date . ' 06:00:00')  
                ->where('COALESCE(valid_datetime, NOW()) >=', $date . ' 05:59:59')
                ->get()->row_array();

            
                 $schdule_minutes += empty($running_schedule) ? 1440 : $running_schedule['schdule_minutes'];
              
            
            }

             $row['schdule_minutes'] = $schdule_minutes;

            
          } 



	    }else{
             
             $next_month = sprintf("%02d",$month + 1);
	    	 $previous_month = sprintf("%02d", $month - 1);	


	      if ($well_id != '') 
	      {
	        $this->db->where('wr.well_id', $well_id);
	      }

	      if ($site_id != '') {
	        $this->db->where('ws.id', $site_id);
	      }

	    $startmonth = date('Y') . '-' . $month . '-01 06:00:00';
	    $endmonth = date('Y') . '-' . $next_month . '-01 05:59:59';

	    
	    $this->db->where('wr.start_datetime >=', $startmonth);
	    $this->db->where('wr.end_datetime <=', $endmonth);

	    $current = $this->db->select("wm.well_name,sd.well_id, (wm.well_name) AS x, SUM(wr.total_running_minute) AS y")
	        ->from('tbl_site_device_installation sd')
	        ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
	        ->join('tbl_well_site_master ws', 'ws.id=sd.site_id and ws.status =1', 'left')
	        ->join('tbl_well_running_log wr','wm.id=wr.well_id', 'left')
	        ->where(['sd.status' => 1])
	        ->group_by('MONTH(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), year(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), sd.well_id') 
	        ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
	        ->get()
	        ->result_array();

           
	      foreach ($current as &$row) {
	      	 $schdule_minutes = 0;
            
            for ($date = $startmonth; $date <= $endmonth; $date = date('Y-m-d', strtotime($date . ' +1 day'))) 
            {
           
            $running_schedule = $this->db->select('COALESCE(running_minutes,1440)AS schdule_minutes,well_id')
                ->from('v_running_schdule_minutes')
                ->where('well_id', $row['well_id'])
                ->where('apply_datetime <=', $date . ' 06:00:00')  
                ->where('COALESCE(valid_datetime, NOW()) >=', $date . ' 05:59:59')
                ->get()->row_array();

            $schdule_minutes += empty($running_schedule) ? 1440 : $running_schedule['schdule_minutes'];
              

            }

             $row['schdule_minutes'] = $schdule_minutes;
          } 


	       
	    if ($well_id != '') 
	    {
	        $this->db->where('wr.well_id', $well_id);
	    }

	    if ($site_id != '') {
	        $this->db->where('ws.id', $site_id);
	    }

	    $startmonth = date('Y') . '-' . $previous_month . '-01 06:00:00';
	    $endmonth = date('Y') . '-' . $month . '-01 05:59:59';

	    $this->db->where('wr.start_datetime >=', $startmonth);
	    $this->db->where('wr.end_datetime <=', $endmonth);

	    $previous = $this->db->select("wm.well_name,sd.well_id, (wm.well_name) AS x, SUM(wr.total_running_minute) AS y")
	        ->from('tbl_site_device_installation sd')
	        ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
	        ->join('tbl_well_site_master ws', 'ws.id=sd.site_id and ws.status =1', 'left')
	        ->join('tbl_well_running_log wr','wm.id=wr.well_id', 'left')
	        ->where(['sd.status' => 1])
	        ->group_by('MONTH(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), year(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), sd.well_id') 
	        ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
	        ->get()
	        ->result_array();

	        foreach ($previous as &$row) {
            $schdule_minutes = 0;
            
            for ($date = $startmonth; $date <= $endmonth; $date = date('Y-m-d', strtotime($date . ' +1 day'))) 
            {
           
            $running_schedule = $this->db->select('COALESCE(running_minutes,1440)AS schdule_minutes,well_id')
                ->from('v_running_schdule_minutes')
                ->where('well_id', $row['well_id'])
                ->where('apply_datetime <=', $date . ' 06:00:00')  
                ->where('COALESCE(valid_datetime, NOW()) >=', $date . ' 05:59:59')
                ->get()->row_array();

            $schdule_minutes += empty($running_schedule) ? 1440 : $running_schedule['schdule_minutes'];
              

            }
              $row['schdule_minutes'] = $schdule_minutes;
            } 
          
	     }

	    $merged_results = [];

  
 
	    foreach ($previous as $previous_row) {
	        $well_name = $previous_row['well_name'];
	        $merged_results[$well_name][] = [
	            'x' => $previous_row['x'],
	            'y' => $previous_row['y'],
	            'z' => $previous_row['schdule_minutes']
	           
	        ];
	    }
	    
	    foreach ($current as $current_row) {
	        $well_name = $current_row['well_name'];
	        $merged_results[$well_name][] = [
	            'x' => $current_row['x'],
	            'y' => $current_row['y'],
	            'z' => $current_row['schdule_minutes']
	           
	        ];
	    }



	    $flattened_results = [];
	    foreach ($merged_results as $well_data) {
	        foreach ($well_data as $data) {
	            $flattened_results[] = $data;
	        }
	    }

      return $flattened_results;
    
    }


    public function well_running_Area_wise_comparison($site_id,$month,$year)
    {
	    $current_month = date('m');
	    $current_year = date('Y');
	    $current_day = date('d');

	    if ($current_month == $month && $current_year == $year) {

	        
	        if ($site_id != '') {
	            $this->db->where('ws.id', $site_id);
	        }

	        function get_last_day_of_previous_month($month, $year) {
                 $date = DateTime::createFromFormat('m-Y', sprintf("%02d-%d", $month - 1, $year));
                return $date->format('t');
             }


	        if($current_day == 01)
	        {
	        	$previous_month = sprintf("%02d", $month - 1);
	        	$last_day_previous_month = get_last_day_of_previous_month($previous_month, $year);
                $startmonth = date('Y') . '-' . $previous_month . '-'.$last_day_previous_month.' 06:00:00';
	            $endmonth = date('Y') . '-' . $month . '-' . $current_day . ' 05:59:59';

	        }else{

	        	$startmonth = date('Y') . '-' . $month . '-01 06:00:00';
	            $endmonth = date('Y') . '-' . $month . '-' . $current_day . ' 05:59:59';

	        }
 
	        $this->db->where('wr.start_datetime >=', $startmonth);
	        $this->db->where('wr.end_datetime <=', $endmonth);

	        $current = $this->db->select("ws.well_site_name,ws.well_site_name AS x, SUM(wr.total_running_minute) AS y, MONTHNAME(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)) as month_name")
	            ->from('tbl_site_device_installation sd')
	            ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
	            ->join('tbl_well_site_master ws', 'ws.id = sd.site_id and ws.status = 1', 'left')
	            ->join('tbl_well_running_log wr', 'wm.id = wr.well_id', 'left')
	            ->where(['sd.status' => 1])
	            ->group_by('MONTH(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), year(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), sd.site_id')
	            ->get()
	            ->result_array();

	      
	        if ($site_id != '') {
	            $this->db->where('ws.id', $site_id);
	        }
            $next_month = sprintf("%02d", $month + 1);
	        $previous_month = sprintf("%02d", $month - 1);
            if($current_day == 01)
	        {
	        	$previous_month = sprintf("%02d", $month - 1);
	        	$last_day_previous_month = get_last_day_of_previous_month($previous_month, $year);
                $startmonth = date('Y') . '-' . $previous_month . '-'.$last_day_previous_month.' 06:00:00';
	            $endmonth = date('Y') . '-' . $next_month . '-' . $current_day . ' 05:59:59';

	        }else{
	        	 $startmonth = date('Y') . '-' . $previous_month . '-01 06:00:00';
	             $endmonth = date('Y') . '-' . $previous_month . '-' . $current_day . ' 05:59:59';
	        }
	       

	        $this->db->where('wr.start_datetime >=', $startmonth);
	        $this->db->where('wr.end_datetime <=', $endmonth);
	        print_r($startmonth);
	        print_r($endmonth);die;

	        $previous = $this->db->select("ws.well_site_name, ws.well_site_name AS x, SUM(wr.total_running_minute) AS y, MONTHNAME(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)) as month_name")
	            ->from('tbl_site_device_installation sd')
	            ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
	            ->join('tbl_well_site_master ws', 'ws.id = sd.site_id and ws.status = 1', 'left')
	            ->join('tbl_well_running_log wr', 'wm.id = wr.well_id', 'left')
	            ->where(['sd.status' => 1])
	            ->group_by('MONTH(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), year(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), sd.site_id')
	            ->get()
	            ->result_array();

	    }else{

	        $next_month = sprintf("%02d", $month + 1);
	        $previous_month = sprintf("%02d", $month - 1);

	      
	        if ($site_id != '') {
	            $this->db->where('ws.id', $site_id);
	        }

	        $startmonth = date('Y') . '-' . $month . '-01 06:00:00';
	        $endmonth = date('Y') . '-' . $next_month . '-01 05:59:59';

	        $this->db->where('wr.start_datetime >=', $startmonth);
	        $this->db->where('wr.end_datetime <=', $endmonth);

	        $current = $this->db->select("ws.well_site_name, ws.well_site_name AS x, SUM(wr.total_running_minute) AS y, MONTHNAME(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)) as month_name")
	            ->from('tbl_site_device_installation sd')
	            ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
	            ->join('tbl_well_site_master ws', 'ws.id = sd.site_id and ws.status = 1', 'left')
	            ->join('tbl_well_running_log wr', 'wm.id = wr.well_id', 'left')
	            ->where(['sd.status' => 1])
	            ->group_by('MONTH(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), year(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), sd.site_id')
	            ->get()
	            ->result_array();

	       

	        if ($site_id != '') {
	            $this->db->where('ws.id', $site_id);
	        }

	        $startmonth = date('Y') . '-' . $previous_month . '-01 06:00:00';
	        $endmonth = date('Y') . '-' . $month . '-01 05:59:59';

	        $this->db->where('wr.start_datetime >=', $startmonth);
	        $this->db->where('wr.end_datetime <=', $endmonth);

	        $previous = $this->db->select("ws.well_site_name, ws.well_site_name AS x, SUM(wr.total_running_minute) AS y, MONTHNAME(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)) as month_name")
	            ->from('tbl_site_device_installation sd')
	            ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
	            ->join('tbl_well_site_master ws', 'ws.id = sd.site_id and ws.status = 1', 'left')
	            ->join('tbl_well_running_log wr', 'wm.id = wr.well_id', 'left')
	            ->where(['sd.status' => 1])
	            ->group_by('MONTH(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), year(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), sd.site_id')
	            ->get()
	            ->result_array();
	    }

	    $merged_results = [];

	    foreach ($current as $current_row) {
	        $well_site_name = $current_row['well_site_name'];
	        $merged_results[$well_site_name] = [
	            'well_site_name' => $well_site_name,
	            'x' => $current_row['x'],
	            'y' => $current_row['y'],
	            'z' => 0,
	           
	        ];
	    }

	    foreach ($previous as $previous_row) {
	        $well_site_name = $previous_row['well_site_name'];
	        if (isset($merged_results[$well_site_name])) {
	            $merged_results[$well_site_name]['x'] = $merged_results[$well_site_name]['x'];
	            $merged_results[$well_site_name]['z'] = $previous_row['y'];
	        } else {
	            $merged_results[$well_site_name] = [
	                'well_site_name' => $well_site_name,
	                'x' => $previous_row['x'],
	                'y' => 0,
	                'z' => $previous_row['y'],
	                
	            ];
	        }
	    }

	    $flattened_results = array_values($merged_results);

	    return $flattened_results;
    }

    public function well_energy_Area_wise_comparison($site_id,$month,$year)
    {
	    $current_month = date('m');
	    $current_year = date('Y');
	    $current_day = date('d');

	    if ($current_month == $month && $current_year == $year) {

	        
	        if ($site_id != '') {
	            $this->db->where('ws.id', $site_id);
	        }

	        function get_last_day_of_previous_month($month, $year) {
                 $date = DateTime::createFromFormat('m-Y', sprintf("%02d-%d", $month - 1, $year));
                return $date->format('t');
             }


	        if($current_day == 01)
	        {
	        	$previous_month = sprintf("%02d", $month - 1);
	        	$last_day_previous_month = get_last_day_of_previous_month($previous_month, $year);
                $startmonth = date('Y') . '-' . $previous_month . '-'.$last_day_previous_month.' 06:00:00';
	            $endmonth = date('Y') . '-' . $month . '-' . $current_day . ' 05:59:59';

	        }else{

	        	$startmonth = date('Y') . '-' . $month . '-01 06:00:00';
	            $endmonth = date('Y') . '-' . $month . '-' . $current_day . ' 05:59:59';

	        }
 
	        $this->db->where('wr.start_datetime >=', $startmonth);
	        $this->db->where('wr.end_datetime <=', $endmonth);

	        $current = $this->db->select("ws.well_site_name,ws.well_site_name AS x, SUM(wr.total_kwh) AS y, MONTHNAME(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)) as month_name")
	            ->from('tbl_site_device_installation sd')
	            ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
	            ->join('tbl_well_site_master ws', 'ws.id = sd.site_id and ws.status = 1', 'left')
	            ->join('tbl_well_running_log wr', 'wm.id = wr.well_id', 'left')
	            ->where(['sd.status' => 1])
	            ->group_by('MONTH(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), year(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), sd.site_id')
	            ->get()
	            ->result_array();

	      
	        if ($site_id != '') {
	            $this->db->where('ws.id', $site_id);
	        }
            $next_month = sprintf("%02d", $month + 1);
	        $previous_month = sprintf("%02d", $month - 1);
            if($current_day == 01)
	        {
	        	$previous_month = sprintf("%02d", $month - 1);
	        	$last_day_previous_month = get_last_day_of_previous_month($previous_month, $year);
                $startmonth = date('Y') . '-' . $previous_month . '-'.$last_day_previous_month.' 06:00:00';
	            $endmonth = date('Y') . '-' . $next_month . '-' . $current_day . ' 05:59:59';

	        }else{
	        	 $startmonth = date('Y') . '-' . $previous_month . '-01 06:00:00';
	             $endmonth = date('Y') . '-' . $previous_month . '-' . $current_day . ' 05:59:59';
	        }
	       

	        $this->db->where('wr.start_datetime >=', $startmonth);
	        $this->db->where('wr.end_datetime <=', $endmonth);

	        $previous = $this->db->select("ws.well_site_name, ws.well_site_name AS x, SUM(wr.total_kwh) AS y, MONTHNAME(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)) as month_name")
	            ->from('tbl_site_device_installation sd')
	            ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
	            ->join('tbl_well_site_master ws', 'ws.id = sd.site_id and ws.status = 1', 'left')
	            ->join('tbl_well_running_log wr', 'wm.id = wr.well_id', 'left')
	            ->where(['sd.status' => 1])
	            ->group_by('MONTH(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), year(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), sd.site_id')
	            ->get()
	            ->result_array();

	    }else{

	        $next_month = sprintf("%02d", $month + 1);
	        $previous_month = sprintf("%02d", $month - 1);

	       

	        if ($site_id != '') {
	            $this->db->where('ws.id', $site_id);
	        }

	        $startmonth = date('Y') . '-' . $month . '-01 06:00:00';
	        $endmonth = date('Y') . '-' . $next_month . '-01 05:59:59';

	        $this->db->where('wr.start_datetime >=', $startmonth);
	        $this->db->where('wr.end_datetime <=', $endmonth);

	        $current = $this->db->select("ws.well_site_name,sd.site_id, ws.well_site_name AS x, SUM(wr.total_kwh) AS y, MONTHNAME(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)) as month_name")
	            ->from('tbl_site_device_installation sd')
	            ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
	            ->join('tbl_well_site_master ws', 'ws.id = sd.site_id and ws.status = 1', 'left')
	            ->join('tbl_well_running_log wr', 'wm.id = wr.well_id', 'left')
	            ->where(['sd.status' => 1])
	            ->group_by('MONTH(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), year(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), sd.site_id')
	            ->get()
	            ->result_array();

	       
	        if ($site_id != '') {
	            $this->db->where('ws.id', $site_id);
	        }

	        $startmonth = date('Y') . '-' . $previous_month . '-01 06:00:00';
	        $endmonth = date('Y') . '-' . $month . '-01 05:59:59';

	        $this->db->where('wr.start_datetime >=', $startmonth);
	        $this->db->where('wr.end_datetime <=', $endmonth);

	        $previous = $this->db->select("ws.well_site_name, ws.well_site_name AS x, SUM(wr.total_kwh) AS y, MONTHNAME(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)) as month_name")
	            ->from('tbl_site_device_installation sd')
	            ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
	            ->join('tbl_well_site_master ws', 'ws.id = sd.site_id and ws.status = 1', 'left')
	            ->join('tbl_well_running_log wr', 'wm.id = wr.well_id', 'left')
	            ->where(['sd.status' => 1])
	            ->group_by('MONTH(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), year(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), sd.site_id')
	            ->get()
	            ->result_array();
	    }

	    $merged_results = [];

	    foreach ($current as $current_row) {
	        $well_site_name = $current_row['well_site_name'];
	        $merged_results[$well_site_name] = [
	            'well_site_name' => $well_site_name,
	            'x' => $current_row['x'],
	            'y' => $current_row['y'],
	            'z' => 0,
	           
	        ];
	    }

	    foreach ($previous as $previous_row) {
	        $well_site_name = $previous_row['well_site_name'];
	        if (isset($merged_results[$well_site_name])) {
	            $merged_results[$well_site_name]['x'] = $merged_results[$well_site_name]['x'];
	            $merged_results[$well_site_name]['z'] = $previous_row['y'];
	        } else {
	            $merged_results[$well_site_name] = [
	                'well_site_name' => $well_site_name,
	                'x' => $previous_row['x'],
	                'y' => 0,
	                'z' => $previous_row['y'],
	                
	            ];
	        }
	    }

	    $flattened_results = array_values($merged_results);

	    return $flattened_results;
    }

     public function well_Area_running_schdule_graph_comparison($site_id,$month,$year)
    {
    	$current_month = date('m');
	    $current_year = date('Y');
	    $current_day =  date('d');
	  

	    if($current_month == $month && $current_year == $year)
	    {


	       if ($site_id != '') {
	        $this->db->where('ws.id', $site_id);
	       }

	    	
	         function get_last_day_of_previous_month($month, $year) {
                 $date = DateTime::createFromFormat('m-Y', sprintf("%02d-%d", $month - 1, $year));
                return $date->format('t');
             }


	        if($current_day == 01)
	        {
	        	$previous_month = sprintf("%02d", $month - 1);
	        	$last_day_previous_month = get_last_day_of_previous_month($previous_month, $year);
                $startmonth = date('Y') . '-' . $previous_month . '-'.$last_day_previous_month.' 06:00:00';
	            $endmonth = date('Y') . '-' . $month . '-' . $current_day . ' 05:59:59';

	        }else{

	        	$startmonth = date('Y') . '-' . $month . '-01 06:00:00';
	            $endmonth = date('Y') . '-' . $month . '-' . $current_day . ' 05:59:59';

	        }

	        $this->db->where('wr.start_datetime >=', $startmonth);
	        $this->db->where('wr.end_datetime <=', $endmonth);

	       $current = $this->db->select("ws.well_site_name,sd.site_id, CONCAT(MONTHNAME(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), ' ', ws.well_site_name) AS x, SUM(wr.total_running_minute) AS y")
	        ->from('tbl_site_device_installation sd')
	        ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
	        ->join('tbl_well_site_master ws', 'ws.id=sd.site_id and ws.status =1', 'left')
	        ->join('tbl_well_running_log wr','wm.id=wr.well_id', 'left')
	        ->where(['sd.status' => 1])
	        ->group_by('MONTH(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), year(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), sd.site_id') 
	        ->get()
	        ->result_array();

	     foreach ($current as &$row) {
		        
		         $total_running_minutes_well_type_0 = 0;
                 $total_running_minutes_well_type_1 = 0;
                 $running_minutes_type1 =0;
                 $running_minutes_type0 =0;

		        for ($date = $startmonth; $date <= $endmonth; $date = date('Y-m-d', strtotime($date . ' +1 day'))) {
		            $running_schedule_query = $this->db->select('COALESCE(running_minutes, 0) AS running_minutes, COALESCE(well_type, 0) AS well_type, well_id, site_id')
                        ->from('v_asset_running_schdule_minutes')
                        ->where('site_id', $row['site_id'])
                        ->where('apply_datetime <=', $date . ' 06:00:00')
                        ->where('COALESCE(valid_datetime, NOW()) >=', $date . ' 05:59:59')
                        ->get();



                        $total_running_minutes = 0;
                       if ($running_schedule_query->num_rows() > 0) 
                       {

                            foreach ($running_schedule_query->result_array() as $rowdata) 
                            {
                               if ($rowdata['well_type'] == 0) 
                               {
                                  $total_running_minutes_well_type_0 += $rowdata['running_minutes'];
                               }elseif($rowdata['well_type'] == 1) 
                               {
                                  $total_running_minutes_well_type_1 += $rowdata['running_minutes'];
                               }
                            }
                        }
		                
		             
                   }
                  $row['schdule_minutes'] = $total_running_minutes_well_type_0+$total_running_minutes_well_type_1;
		       

               }
		    
	      if ($site_id != '') {
	        $this->db->where('ws.id', $site_id);
	      }

	   
	        $next_month = sprintf("%02d", $month + 1);
	        $previous_month = sprintf("%02d", $month - 1);
            if($current_day == 01)
	        {
	        	$previous_month = sprintf("%02d", $month - 1);
	        	$last_day_previous_month = get_last_day_of_previous_month($previous_month, $year);
                $startmonth = date('Y') . '-' . $previous_month . '-'.$last_day_previous_month.' 06:00:00';
	            $endmonth = date('Y') . '-' . $next_month . '-' . $current_day . ' 05:59:59';

	        }else{
	        	 $startmonth = date('Y') . '-' . $previous_month . '-01 06:00:00';
	             $endmonth = date('Y') . '-' . $previous_month . '-' . $current_day . ' 05:59:59';
	        }

	      $this->db->where('wr.start_datetime >=', $startmonth);
	      $this->db->where('wr.end_datetime <=', $endmonth);

	    $previous = $this->db->select("ws.well_site_name,sd.site_id, CONCAT(MONTHNAME(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), ' ', ws.well_site_name) AS x, SUM(wr.total_running_minute) AS y")
	        ->from('tbl_site_device_installation sd')
	        ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
	        ->join('tbl_well_site_master ws', 'ws.id=sd.site_id and ws.status =1', 'left')
	        ->join('tbl_well_running_log wr','wm.id=wr.well_id', 'left')
	        ->where(['sd.status' => 1])
	        ->group_by('MONTH(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), year(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), sd.site_id') 
	        ->get()
	        ->result_array();

	        foreach ($previous as &$row) {
		        
		         $total_running_minutes_well_type_0 = 0;
                 $total_running_minutes_well_type_1 = 0;
                 $running_minutes_type1 =0;
                 $running_minutes_type0 =0;

		        for ($date = $startmonth; $date <= $endmonth; $date = date('Y-m-d', strtotime($date . ' +1 day'))) {
		            $running_schedule_query = $this->db->select('COALESCE(running_minutes, 0) AS running_minutes, COALESCE(well_type, 0) AS well_type, well_id, site_id')
                        ->from('v_asset_running_schdule_minutes')
                        ->where('site_id', $row['site_id'])
                        ->where('apply_datetime <=', $date . ' 06:00:00')
                        ->where('COALESCE(valid_datetime, NOW()) >=', $date . ' 05:59:59')
                        ->get();



                        $total_running_minutes = 0;
                       if ($running_schedule_query->num_rows() > 0) 
                       {

                            foreach ($running_schedule_query->result_array() as $rowdata) 
                            {
                               if ($rowdata['well_type'] == 0) 
                               {
                                  $total_running_minutes_well_type_0 += $rowdata['running_minutes'];
                               }elseif($rowdata['well_type'] == 1) 
                               {
                                  $total_running_minutes_well_type_1 += $rowdata['running_minutes'];
                               }
                            }
                        }   
		             
                   }
                    $row['schdule_minutes'] = $total_running_minutes_well_type_0+$total_running_minutes_well_type_1;


               }
		       

	    }else{
             
             $next_month = sprintf("%02d",$month + 1);
	    	 $previous_month = sprintf("%02d", $month - 1);	


	      if ($site_id != '') {
	        $this->db->where('ws.id', $site_id);
	      }

	    $startmonth = date('Y') . '-' . $month . '-01 06:00:00';
	    $endmonth = date('Y') . '-' . $next_month . '-01 05:59:59';

	    
	    $this->db->where('wr.start_datetime >=', $startmonth);
	    $this->db->where('wr.end_datetime <=', $endmonth);

	    $current = $this->db->select("ws.well_site_name,sd.site_id, CONCAT(MONTHNAME(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), ' ', ws.well_site_name) AS x, SUM(wr.total_running_minute) AS y")
	        ->from('tbl_site_device_installation sd')
	        ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
	        ->join('tbl_well_site_master ws', 'ws.id=sd.site_id and ws.status =1', 'left')
	        ->join('tbl_well_running_log wr','wm.id=wr.well_id', 'left')
	        ->where(['sd.status' => 1])
	        ->group_by('MONTH(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), year(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), sd.site_id') 
	        ->get()
	        ->result_array();

           
	       foreach ($current as &$row) {
		        
		         $total_running_minutes_well_type_0 = 0;
                 $total_running_minutes_well_type_1 = 0;
                 $running_minutes_type1 =0;
                 $running_minutes_type0 =0;

		        for ($date = $startmonth; $date <= $endmonth; $date = date('Y-m-d', strtotime($date . ' +1 day'))) {
		            $running_schedule_query = $this->db->select('COALESCE(running_minutes, 0) AS running_minutes, COALESCE(well_type, 0) AS well_type, well_id, site_id')
                        ->from('v_asset_running_schdule_minutes')
                        ->where('site_id', $row['site_id'])
                        ->where('apply_datetime <=', $date . ' 06:00:00')
                        ->where('COALESCE(valid_datetime, NOW()) >=', $date . ' 05:59:59')
                        ->get();



                        $total_running_minutes = 0;
                       if ($running_schedule_query->num_rows() > 0) 
                       {

                            foreach ($running_schedule_query->result_array() as $rowdata) 
                            {
                               if ($rowdata['well_type'] == 0) 
                               {
                                  $total_running_minutes_well_type_0 += $rowdata['running_minutes'];
                               }elseif($rowdata['well_type'] == 1) 
                               {
                                  $total_running_minutes_well_type_1 += $rowdata['running_minutes'];
                               }
                            }
                        }
		                
		             
                   }
                     $row['schdule_minutes'] = $total_running_minutes_well_type_0+$total_running_minutes_well_type_1;

               }
		      


	    if ($site_id != '') {
	        $this->db->where('ws.id', $site_id);
	    }

	    $startmonth = date('Y') . '-' . $previous_month . '-01 06:00:00';
	    $endmonth = date('Y') . '-' . $month . '-01 05:59:59';

	    $this->db->where('wr.start_datetime >=', $startmonth);
	    $this->db->where('wr.end_datetime <=', $endmonth);

	    $previous = $this->db->select("ws.well_site_name,sd.site_id, CONCAT(MONTHNAME(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), ' ', ws.well_site_name) AS x, SUM(wr.total_running_minute) AS y")
	        ->from('tbl_site_device_installation sd')
	        ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
	        ->join('tbl_well_site_master ws', 'ws.id=sd.site_id and ws.status =1', 'left')
	        ->join('tbl_well_running_log wr','wm.id=wr.well_id', 'left')
	        ->where(['sd.status' => 1])
	        ->group_by('MONTH(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), year(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), sd.site_id') 
	        ->get()
	        ->result_array();

	         foreach ($previous as &$row) {
		        
		         $total_running_minutes_well_type_0 = 0;
                 $total_running_minutes_well_type_1 = 0;
                 $running_minutes_type1 =0;
                 $running_minutes_type0 =0;

		        for ($date = $startmonth; $date <= $endmonth; $date = date('Y-m-d', strtotime($date . ' +1 day'))) {
		            $running_schedule_query = $this->db->select('COALESCE(running_minutes, 0) AS running_minutes, COALESCE(well_type, 0) AS well_type, well_id, site_id')
                        ->from('v_asset_running_schdule_minutes')
                        ->where('site_id', $row['site_id'])
                        ->where('apply_datetime <=', $date . ' 06:00:00')
                        ->where('COALESCE(valid_datetime, NOW()) >=', $date . ' 05:59:59')
                        ->get();

                        $total_running_minutes = 0;
                       if ($running_schedule_query->num_rows() > 0) 
                       {

                            foreach ($running_schedule_query->result_array() as $rowdata) 
                            {
                               if ($rowdata['well_type'] == 0) 
                               {
                                  $total_running_minutes_well_type_0 += $rowdata['running_minutes'];
                               }elseif($rowdata['well_type'] == 1) 
                               {
                                  $total_running_minutes_well_type_1 += $rowdata['running_minutes'];
                               }
                            }
                        }
		                
		             
                   }
                    $row['schdule_minutes'] = $total_running_minutes_well_type_0+$total_running_minutes_well_type_1;
               }
		       
            }


	    $merged_results = [];

  
	    foreach ($current as $current_row) {
	        $well_site_name = $current_row['well_site_name'];
	        $merged_results[$well_site_name][] = [
	            'x' => $current_row['x'],
	            'y' => $current_row['y'],
	            'z' => $current_row['schdule_minutes']
	           
	        ];
	    }

 
	    foreach ($previous as $previous_row) {
	        $well_site_name = $previous_row['well_site_name'];
	        $merged_results[$well_site_name][] = [
	            'x' => $previous_row['x'],
	            'y' => $previous_row['y'],
	            'z' => $previous_row['schdule_minutes']
	           
	        ];
	    }


	    $flattened_results = [];
	    foreach ($merged_results as $well_data) {
	        foreach ($well_data as $data) {
	            $flattened_results[] = $data;
	        }
	    }

      return $flattened_results;
    
    }

    public function well_running_Assets_wise_comparison($site_id,$month,$year)
    {

    	if ($site_id != '') 
    	{

	    $current_month = date('m');
	    $current_year = date('Y');
	    $current_day = date('d');

	    if ($current_month == $month && $current_year == $year) {

	        
	        if ($site_id != '') {
	            $this->db->where('ws.id', $site_id);
	        }

	        function get_last_day_of_previous_month($month, $year) {
                 $date = DateTime::createFromFormat('m-Y', sprintf("%02d-%d", $month - 1, $year));
                return $date->format('t');
             }


	        if($current_day == 01)
	        {
	        	$previous_month = sprintf("%02d", $month - 1);
	        	$last_day_previous_month = get_last_day_of_previous_month($previous_month, $year);
                $startmonth = date('Y') . '-' . $previous_month . '-'.$last_day_previous_month.' 06:00:00';
	            $endmonth = date('Y') . '-' . $month . '-' . $current_day . ' 05:59:59';

	        }else{

	        	$startmonth = date('Y') . '-' . $month . '-01 06:00:00';
	            $endmonth = date('Y') . '-' . $month . '-' . $current_day . ' 05:59:59';

	        }
 
	        $this->db->where('wr.start_datetime >=', $startmonth);
	        $this->db->where('wr.end_datetime <=', $endmonth);

	        $current = $this->db->select("ws.well_site_name,ws.well_site_name AS x, SUM(wr.total_running_minute) AS y, MONTHNAME(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)) as month_name")
	            ->from('tbl_site_device_installation sd')
	            ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
	            ->join('tbl_well_site_master ws', 'ws.id = sd.site_id and ws.status = 1', 'left')
	            ->join('tbl_well_running_log wr', 'wm.id = wr.well_id', 'left')
	            ->where(['sd.status' => 1,'ws.id'=>$site_id])
	            ->group_by('MONTH(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), year(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), sd.site_id')
	            ->get()
	            ->result_array();

            $next_month = sprintf("%02d", $month + 1);
	        $previous_month = sprintf("%02d", $month - 1);
            if($current_day == 01)
	        {
	        	$previous_month = sprintf("%02d", $month - 1);
	        	$last_day_previous_month = get_last_day_of_previous_month($previous_month, $year);
                $startmonth = date('Y') . '-' . $previous_month . '-'.$last_day_previous_month.' 06:00:00';
	            $endmonth = date('Y') . '-' . $next_month . '-' . $current_day . ' 05:59:59';

	        }else{
	        	 $startmonth = date('Y') . '-' . $previous_month . '-01 06:00:00';
	             $endmonth = date('Y') . '-' . $previous_month . '-' . $current_day . ' 05:59:59';
	        }
	       

	        $this->db->where('wr.start_datetime >=', $startmonth);
	        $this->db->where('wr.end_datetime <=', $endmonth);

	        $previous = $this->db->select("ws.well_site_name, ws.well_site_name AS x, SUM(wr.total_running_minute) AS y, MONTHNAME(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)) as month_name")
	            ->from('tbl_site_device_installation sd')
	            ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
	            ->join('tbl_well_site_master ws', 'ws.id = sd.site_id and ws.status = 1', 'left')
	            ->join('tbl_well_running_log wr', 'wm.id = wr.well_id', 'left')
	            ->where(['sd.status' => 1,'ws.id'=>$site_id])
	            ->group_by('MONTH(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), year(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), sd.site_id')
	            ->get()
	            ->result_array();

	    }else{

	        $next_month = sprintf("%02d", $month + 1);
	        $previous_month = sprintf("%02d", $month - 1);

	        $startmonth = date('Y') . '-' . $month . '-01 06:00:00';
	        $endmonth = date('Y') . '-' . $next_month . '-01 05:59:59';

	        $this->db->where('wr.start_datetime >=', $startmonth);
	        $this->db->where('wr.end_datetime <=', $endmonth);

	        $current = $this->db->select("ws.well_site_name, ws.well_site_name AS x, SUM(wr.total_running_minute) AS y, MONTHNAME(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)) as month_name")
	            ->from('tbl_site_device_installation sd')
	            ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
	            ->join('tbl_well_site_master ws', 'ws.id = sd.site_id and ws.status = 1', 'left')
	            ->join('tbl_well_running_log wr', 'wm.id = wr.well_id', 'left')
	            ->where(['sd.status' => 1,'ws.id'=>$site_id])
	            ->group_by('MONTH(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), year(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), sd.site_id')
	            ->get()
	            ->result_array();

	       
	        $startmonth = date('Y') . '-' . $previous_month . '-01 06:00:00';
	        $endmonth = date('Y') . '-' . $month . '-01 05:59:59';

	        $this->db->where('wr.start_datetime >=', $startmonth);
	        $this->db->where('wr.end_datetime <=', $endmonth);

	        $previous = $this->db->select("ws.well_site_name, ws.well_site_name AS x, SUM(wr.total_running_minute) AS y, MONTHNAME(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)) as month_name")
	            ->from('tbl_site_device_installation sd')
	            ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
	            ->join('tbl_well_site_master ws', 'ws.id = sd.site_id and ws.status = 1', 'left')
	            ->join('tbl_well_running_log wr', 'wm.id = wr.well_id', 'left')
	            ->where(['sd.status' => 1,'ws.id'=>$site_id])
	            ->group_by('MONTH(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), year(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), sd.site_id')
	            ->get()
	            ->result_array();
	    }

	    $merged_results = [];

	    foreach ($current as $current_row) {
	        $well_site_name = $current_row['well_site_name'];
	        $merged_results[$well_site_name] = [
	            'well_site_name' => $well_site_name,
	            'x' => $current_row['x'],
	            'y' => $current_row['y'],
	            'z' => 0,
	           
	        ];
	    }

	    foreach ($previous as $previous_row) {
	        $well_site_name = $previous_row['well_site_name'];
	        if (isset($merged_results[$well_site_name])) {
	            $merged_results[$well_site_name]['x'] = $merged_results[$well_site_name]['x'];
	            $merged_results[$well_site_name]['z'] = $previous_row['y'];
	        } else {
	            $merged_results[$well_site_name] = [
	                'well_site_name' => $well_site_name,
	                'x' => $previous_row['x'],
	                'y' => 0,
	                'z' => $previous_row['y'],
	                
	            ];
	        }
	    }

	    $flattened_results = array_values($merged_results);

	    return $flattened_results;
    
	}else{


    	$current_month = date('m');
	    $current_year = date('Y');
	    $current_day = date('d');

	    if ($current_month == $month && $current_year == $year) 
	    {

	        function get_last_day_of_previous_month($month, $year) {
                 $date = DateTime::createFromFormat('m-Y', sprintf("%02d-%d", $month - 1, $year));
                return $date->format('t');
             }


	        if($current_day == 01)
	        {
	        	$previous_month = sprintf("%02d", $month - 1);
	        	$last_day_previous_month = get_last_day_of_previous_month($previous_month, $year);
                $startmonth = date('Y') . '-' . $previous_month . '-'.$last_day_previous_month.' 06:00:00';
	            $endmonth = date('Y') . '-' . $month . '-' . $current_day . ' 05:59:59';

	        }else{

	        	$startmonth = date('Y') . '-' . $month . '-01 06:00:00';
	            $endmonth = date('Y') . '-' . $month . '-' . $current_day . ' 05:59:59';

	        }
 
	        $this->db->where('wr.start_datetime >=', $startmonth);
	        $this->db->where('wr.end_datetime <=', $endmonth);

	        $current = $this->db->select("ws.assets_name,ws.assets_name AS x, SUM(wr.total_running_minute) AS y, MONTHNAME(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)) as month_name")
	            ->from('tbl_site_device_installation sd')
	            ->join('tbl_assets_master ws', 'ws.id = sd.assets_id and ws.status = 1', 'left')
	            ->join('tbl_well_running_log wr', 'sd.well_id = wr.well_id', 'left')
	            ->where(['sd.status' => 1])
	            ->group_by('MONTH(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), year(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), sd.assets_id')
	            ->get()
	            ->result_array();

            $next_month = sprintf("%02d", $month + 1);
	        $previous_month = sprintf("%02d", $month - 1);
            if($current_day == 01)
	        {
	        	$previous_month = sprintf("%02d", $month - 1);
	        	$last_day_previous_month = get_last_day_of_previous_month($previous_month, $year);
                $startmonth = date('Y') . '-' . $previous_month . '-'.$last_day_previous_month.' 06:00:00';
	            $endmonth = date('Y') . '-' . $next_month . '-' . $current_day . ' 05:59:59';

	        }else{
	        	 $startmonth = date('Y') . '-' . $previous_month . '-01 06:00:00';
	             $endmonth = date('Y') . '-' . $previous_month . '-' . $current_day . ' 05:59:59';
	        }
	       

	        $this->db->where('wr.start_datetime >=', $startmonth);
	        $this->db->where('wr.end_datetime <=', $endmonth);

	       $previous = $this->db->select("ws.assets_name,ws.assets_name AS x, SUM(wr.total_running_minute) AS y, MONTHNAME(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)) as month_name")
	            ->from('tbl_site_device_installation sd')
	            ->join('tbl_assets_master ws', 'ws.id = sd.assets_id and ws.status = 1', 'left')
	            ->join('tbl_well_running_log wr', 'sd.well_id = wr.well_id', 'left')
	            ->where(['sd.status' => 1])
	            ->group_by('MONTH(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), year(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), sd.assets_id')
	            ->get()
	            ->result_array();

	    }else{

	        $next_month = sprintf("%02d", $month + 1);
	        $previous_month = sprintf("%02d", $month - 1);

	       
	        if ($site_id != '') {
	            $this->db->where('ws.id', $site_id);
	        }

	        $startmonth = date('Y') . '-' . $month . '-01 06:00:00';
	        $endmonth = date('Y') . '-' . $next_month . '-01 05:59:59';

	        $this->db->where('wr.start_datetime >=', $startmonth);
	        $this->db->where('wr.end_datetime <=', $endmonth);

	        $current = $this->db->select("ws.assets_name,ws.assets_name AS x, SUM(wr.total_running_minute) AS y, MONTHNAME(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)) as month_name")
	            ->from('tbl_site_device_installation sd')
	            ->join('tbl_assets_master ws', 'ws.id = sd.assets_id and ws.status = 1', 'left')
	            ->join('tbl_well_running_log wr', 'sd.well_id = wr.well_id', 'left')
	            ->where(['sd.status' => 1])
	            ->group_by('MONTH(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), year(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), sd.assets_id')
	            ->get()
	            ->result_array();

	        $startmonth = date('Y') . '-' . $previous_month . '-01 06:00:00';
	        $endmonth = date('Y') . '-' . $month . '-01 05:59:59';

	        $this->db->where('wr.start_datetime >=', $startmonth);
	        $this->db->where('wr.end_datetime <=', $endmonth);

	        $previous = $this->db->select("ws.assets_name,ws.assets_name AS x, SUM(wr.total_running_minute) AS y, MONTHNAME(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)) as month_name")
	            ->from('tbl_site_device_installation sd')
	            ->join('tbl_assets_master ws', 'ws.id = sd.assets_id and ws.status = 1', 'left')
	            ->join('tbl_well_running_log wr', 'sd.well_id = wr.well_id', 'left')
	            ->where(['sd.status' => 1])
	            ->group_by('MONTH(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), year(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), sd.assets_id')
	            ->get()
	            ->result_array();
	    }

	    $merged_results = [];

	    foreach ($current as $current_row) {
	        $assets_name = $current_row['assets_name'];
	        $merged_results[$assets_name] = [
	            'assets_name' => $assets_name,
	            'x' => $current_row['x'],
	            'y' => $current_row['y'],
	            'z' => 0,
	           
	        ];
	    }

	    foreach ($previous as $previous_row) {
	        $assets_name = $previous_row['assets_name'];
	        if (isset($merged_results[$assets_name])) {
	            $merged_results[$assets_name]['x'] = $merged_results[$assets_name]['x'];
	            $merged_results[$assets_name]['z'] = $previous_row['y'];
	        } else {
	            $merged_results[$assets_name] = [
	                'assets_name' => $assets_name,
	                'x' => $previous_row['x'],
	                'y' => 0,
	                'z' => $previous_row['y'],
	                
	            ];
	        }
	    }

	    $flattened_results = array_values($merged_results);

	    return $flattened_results;

	    }

    }

    public function well_energy_consumption_Assets_wise_comparison($site_id,$month,$year)
    {

    	if ($site_id != '') 
    	{

	    $current_month = date('m');
	    $current_year = date('Y');
	    $current_day = date('d');

	    if ($current_month == $month && $current_year == $year) {

	    
	        function get_last_day_of_previous_month($month, $year) {
                 $date = DateTime::createFromFormat('m-Y', sprintf("%02d-%d", $month - 1, $year));
                return $date->format('t');
             }


	        if($current_day == 01)
	        {
	        	$previous_month = sprintf("%02d", $month - 1);
	        	$last_day_previous_month = get_last_day_of_previous_month($previous_month, $year);
                $startmonth = date('Y') . '-' . $previous_month . '-'.$last_day_previous_month.' 06:00:00';
	            $endmonth = date('Y') . '-' . $month . '-' . $current_day . ' 05:59:59';

	        }else{

	        	$startmonth = date('Y') . '-' . $month . '-01 06:00:00';
	            $endmonth = date('Y') . '-' . $month . '-' . $current_day . ' 05:59:59';

	        }
 
	        $this->db->where('wr.start_datetime >=', $startmonth);
	        $this->db->where('wr.end_datetime <=', $endmonth);

	        $current = $this->db->select("ws.well_site_name,ws.well_site_name AS x, SUM(wr.total_kwh) AS y, MONTHNAME(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)) as month_name")
	            ->from('tbl_site_device_installation sd')
	            ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
	            ->join('tbl_well_site_master ws', 'ws.id = sd.site_id and ws.status = 1', 'left')
	            ->join('tbl_well_running_log wr', 'wm.id = wr.well_id', 'left')
	            ->where(['sd.status' => 1,'ws.id'=>$site_id])
	            ->group_by('MONTH(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), year(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), sd.site_id')
	            ->get()
	            ->result_array();

            $next_month = sprintf("%02d", $month + 1);
	        $previous_month = sprintf("%02d", $month - 1);
            if($current_day == 01)
	        {
	        	$previous_month = sprintf("%02d", $month - 1);
	        	$last_day_previous_month = get_last_day_of_previous_month($previous_month, $year);
                $startmonth = date('Y') . '-' . $previous_month . '-'.$last_day_previous_month.' 06:00:00';
	            $endmonth = date('Y') . '-' . $next_month . '-' . $current_day . ' 05:59:59';

	        }else{
	        	 $startmonth = date('Y') . '-' . $previous_month . '-01 06:00:00';
	             $endmonth = date('Y') . '-' . $previous_month . '-' . $current_day . ' 05:59:59';
	        }
	       

	        $this->db->where('wr.start_datetime >=', $startmonth);
	        $this->db->where('wr.end_datetime <=', $endmonth);

	        $previous = $this->db->select("ws.well_site_name, ws.well_site_name AS x, SUM(wr.total_kwh) AS y, MONTHNAME(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)) as month_name")
	            ->from('tbl_site_device_installation sd')
	            ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
	            ->join('tbl_well_site_master ws', 'ws.id = sd.site_id and ws.status = 1', 'left')
	            ->join('tbl_well_running_log wr', 'wm.id = wr.well_id', 'left')
	            ->where(['sd.status' => 1,'ws.id'=>$site_id])
	            ->group_by('MONTH(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), year(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), sd.site_id')
	            ->get()
	            ->result_array();

	    }else{

	        $next_month = sprintf("%02d", $month + 1);
	        $previous_month = sprintf("%02d", $month - 1);

	        $startmonth = date('Y') . '-' . $month . '-01 06:00:00';
	        $endmonth = date('Y') . '-' . $next_month . '-01 05:59:59';

	        $this->db->where('wr.start_datetime >=', $startmonth);
	        $this->db->where('wr.end_datetime <=', $endmonth);

	        $current = $this->db->select("ws.well_site_name, ws.well_site_name AS x, SUM(wr.total_kwh) AS y, MONTHNAME(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)) as month_name")
	            ->from('tbl_site_device_installation sd')
	            ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
	            ->join('tbl_well_site_master ws', 'ws.id = sd.site_id and ws.status = 1', 'left')
	            ->join('tbl_well_running_log wr', 'wm.id = wr.well_id', 'left')
	            ->where(['sd.status' => 1,'ws.id'=>$site_id])
	            ->group_by('MONTH(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), year(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), sd.site_id')
	            ->get()
	            ->result_array();

	       
	        $startmonth = date('Y') . '-' . $previous_month . '-01 06:00:00';
	        $endmonth = date('Y') . '-' . $month . '-01 05:59:59';

	        $this->db->where('wr.start_datetime >=', $startmonth);
	        $this->db->where('wr.end_datetime <=', $endmonth);

	        $previous = $this->db->select("ws.well_site_name, ws.well_site_name AS x, SUM(wr.total_kwh) AS y, MONTHNAME(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)) as month_name")
	            ->from('tbl_site_device_installation sd')
	            ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
	            ->join('tbl_well_site_master ws', 'ws.id = sd.site_id and ws.status = 1', 'left')
	            ->join('tbl_well_running_log wr', 'wm.id = wr.well_id', 'left')
	            ->where(['sd.status' => 1,'ws.id'=>$site_id])
	            ->group_by('MONTH(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), year(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), sd.site_id')
	            ->get()
	            ->result_array();
	    }

	    $merged_results = [];

	    foreach ($current as $current_row) {
	        $well_site_name = $current_row['well_site_name'];
	        $merged_results[$well_site_name] = [
	            'well_site_name' => $well_site_name,
	            'x' => $current_row['x'],
	            'y' => $current_row['y'],
	            'z' => 0,
	           
	        ];
	    }

	    foreach ($previous as $previous_row) {
	        $well_site_name = $previous_row['well_site_name'];
	        if (isset($merged_results[$well_site_name])) {
	            $merged_results[$well_site_name]['x'] = $merged_results[$well_site_name]['x'];
	            $merged_results[$well_site_name]['z'] = $previous_row['y'];
	        } else {
	            $merged_results[$well_site_name] = [
	                'well_site_name' => $well_site_name,
	                'x' => $previous_row['x'],
	                'y' => 0,
	                'z' => $previous_row['y'],
	                
	            ];
	        }
	    }

	    $flattened_results = array_values($merged_results);

	    return $flattened_results;
    
	}else{


    	$current_month = date('m');
	    $current_year = date('Y');
	    $current_day = date('d');

	    if ($current_month == $month && $current_year == $year) 
	    {

	        function get_last_day_of_previous_month($month, $year) {
                 $date = DateTime::createFromFormat('m-Y', sprintf("%02d-%d", $month - 1, $year));
                return $date->format('t');
             }


	        if($current_day == 01)
	        {
	        	$previous_month = sprintf("%02d", $month - 1);
	        	$last_day_previous_month = get_last_day_of_previous_month($previous_month, $year);
                $startmonth = date('Y') . '-' . $previous_month . '-'.$last_day_previous_month.' 06:00:00';
	            $endmonth = date('Y') . '-' . $month . '-' . $current_day . ' 05:59:59';

	        }else{

	        	$startmonth = date('Y') . '-' . $month . '-01 06:00:00';
	            $endmonth = date('Y') . '-' . $month . '-' . $current_day . ' 05:59:59';

	        }
 
	        $this->db->where('wr.start_datetime >=', $startmonth);
	        $this->db->where('wr.end_datetime <=', $endmonth);

	        $current = $this->db->select("ws.assets_name,ws.assets_name AS x, SUM(wr.total_kwh) AS y, MONTHNAME(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)) as month_name")
	            ->from('tbl_site_device_installation sd')
	            ->join('tbl_assets_master ws', 'ws.id = sd.assets_id and ws.status = 1', 'left')
	            ->join('tbl_well_running_log wr', 'sd.well_id = wr.well_id', 'left')
	            ->where(['sd.status' => 1])
	            ->group_by('MONTH(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), year(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), sd.assets_id')
	            ->get()
	            ->result_array();

            $next_month = sprintf("%02d", $month + 1);
	        $previous_month = sprintf("%02d", $month - 1);
            if($current_day == 01)
	        {
	        	$previous_month = sprintf("%02d", $month - 1);
	        	$last_day_previous_month = get_last_day_of_previous_month($previous_month, $year);
                $startmonth = date('Y') . '-' . $previous_month . '-'.$last_day_previous_month.' 06:00:00';
	            $endmonth = date('Y') . '-' . $next_month . '-' . $current_day . ' 05:59:59';

	        }else{
	        	 $startmonth = date('Y') . '-' . $previous_month . '-01 06:00:00';
	             $endmonth = date('Y') . '-' . $previous_month . '-' . $current_day . ' 05:59:59';
	        }
	       

	        $this->db->where('wr.start_datetime >=', $startmonth);
	        $this->db->where('wr.end_datetime <=', $endmonth);

	       $previous = $this->db->select("ws.assets_name,ws.assets_name AS x, SUM(wr.total_kwh) AS y, MONTHNAME(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)) as month_name")
	            ->from('tbl_site_device_installation sd')
	            ->join('tbl_assets_master ws', 'ws.id = sd.assets_id and ws.status = 1', 'left')
	            ->join('tbl_well_running_log wr', 'sd.well_id = wr.well_id', 'left')
	            ->where(['sd.status' => 1])
	            ->group_by('MONTH(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), year(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), sd.assets_id')
	            ->get()
	            ->result_array();

	    }else{

	        $next_month = sprintf("%02d", $month + 1);
	        $previous_month = sprintf("%02d", $month - 1);

	       
	        if ($site_id != '') {
	            $this->db->where('ws.id', $site_id);
	        }

	        $startmonth = date('Y') . '-' . $month . '-01 06:00:00';
	        $endmonth = date('Y') . '-' . $next_month . '-01 05:59:59';

	        $this->db->where('wr.start_datetime >=', $startmonth);
	        $this->db->where('wr.end_datetime <=', $endmonth);

	        $current = $this->db->select("ws.assets_name,ws.assets_name AS x, SUM(wr.total_kwh) AS y, MONTHNAME(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)) as month_name")
	            ->from('tbl_site_device_installation sd')
	            ->join('tbl_assets_master ws', 'ws.id = sd.assets_id and ws.status = 1', 'left')
	            ->join('tbl_well_running_log wr', 'sd.well_id = wr.well_id', 'left')
	            ->where(['sd.status' => 1])
	            ->group_by('MONTH(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), year(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), sd.assets_id')
	            ->get()
	            ->result_array();

	        $startmonth = date('Y') . '-' . $previous_month . '-01 06:00:00';
	        $endmonth = date('Y') . '-' . $month . '-01 05:59:59';

	        $this->db->where('wr.start_datetime >=', $startmonth);
	        $this->db->where('wr.end_datetime <=', $endmonth);

	        $previous = $this->db->select("ws.assets_name,ws.assets_name AS x, SUM(wr.total_kwh) AS y, MONTHNAME(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)) as month_name")
	            ->from('tbl_site_device_installation sd')
	            ->join('tbl_assets_master ws', 'ws.id = sd.assets_id and ws.status = 1', 'left')
	            ->join('tbl_well_running_log wr', 'sd.well_id = wr.well_id', 'left')
	            ->where(['sd.status' => 1])
	            ->group_by('MONTH(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), year(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), sd.assets_id')
	            ->get()
	            ->result_array();
	    }

	    $merged_results = [];

	    foreach ($current as $current_row) {
	        $assets_name = $current_row['assets_name'];
	        $merged_results[$assets_name] = [
	            'assets_name' => $assets_name,
	            'x' => $current_row['x'],
	            'y' => $current_row['y'],
	            'z' => 0,
	           
	        ];
	    }

	    foreach ($previous as $previous_row) {
	        $assets_name = $previous_row['assets_name'];
	        if (isset($merged_results[$assets_name])) {
	            $merged_results[$assets_name]['x'] = $merged_results[$assets_name]['x'];
	            $merged_results[$assets_name]['z'] = $previous_row['y'];
	        } else {
	            $merged_results[$assets_name] = [
	                'assets_name' => $assets_name,
	                'x' => $previous_row['x'],
	                'y' => 0,
	                'z' => $previous_row['y'],
	                
	            ];
	        }
	    }

	    $flattened_results = array_values($merged_results);

	    return $flattened_results;

	    }

    }

    public function well_running_schduling_Assets_wise_comparison($site_id,$month,$year)
    {
    	if($site_id!= '')
    	{
    		$current_month = date('m');
	        $current_year = date('Y');
	        $current_day =  date('d');
	  

	    if($current_month == $month && $current_year == $year)
	    {

	         function get_last_day_of_previous_month($month, $year) {
                 $date = DateTime::createFromFormat('m-Y', sprintf("%02d-%d", $month - 1, $year));
                return $date->format('t');
             }


	        if($current_day == 01)
	        {
	        	$previous_month = sprintf("%02d", $month - 1);
	        	$last_day_previous_month = get_last_day_of_previous_month($previous_month, $year);
                $startmonth = date('Y') . '-' . $previous_month . '-'.$last_day_previous_month.' 06:00:00';
	            $endmonth = date('Y') . '-' . $month . '-' . $current_day . ' 05:59:59';

	        }else{

	        	$startmonth = date('Y') . '-' . $month . '-01 06:00:00';
	            $endmonth = date('Y') . '-' . $month . '-' . $current_day . ' 05:59:59';

	        }

	        $this->db->where('wr.start_datetime >=', $startmonth);
	        $this->db->where('wr.end_datetime <=', $endmonth);

	       $current = $this->db->select("ws.well_site_name,sd.site_id, CONCAT(MONTHNAME(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), ' ', ws.well_site_name) AS x, SUM(wr.total_running_minute) AS y")
	        ->from('tbl_site_device_installation sd')
	        ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
	        ->join('tbl_well_site_master ws', 'ws.id=sd.site_id and ws.status =1', 'left')
	        ->join('tbl_well_running_log wr','wm.id=wr.well_id', 'left')
	        ->where(['sd.status' => 1,'ws.id'=>$site_id])
	        ->group_by('MONTH(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), year(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), sd.site_id') 
	        ->get()
	        ->result_array();

	     foreach ($current as &$row) {
		        
		         $total_running_minutes_well_type_0 = 0;
                 $total_running_minutes_well_type_1 = 0;
                 $running_minutes_type1 =0;
                 $running_minutes_type0 =0;

		        for ($date = $startmonth; $date <= $endmonth; $date = date('Y-m-d', strtotime($date . ' +1 day'))) {
		            $running_schedule_query = $this->db->select('COALESCE(running_minutes, 0) AS running_minutes, COALESCE(well_type, 0) AS well_type, well_id, site_id')
                        ->from('v_asset_running_schdule_minutes')
                        ->where('site_id', $row['site_id'])
                        ->where('apply_datetime <=', $date . ' 06:00:00')
                        ->where('COALESCE(valid_datetime, NOW()) >=', $date . ' 05:59:59')
                        ->get();



                        $total_running_minutes = 0;
                       if ($running_schedule_query->num_rows() > 0) 
                       {

                            foreach ($running_schedule_query->result_array() as $rowdata) 
                            {
                               if ($rowdata['well_type'] == 0) 
                               {
                                  $total_running_minutes_well_type_0 += $rowdata['running_minutes'];
                               }elseif($rowdata['well_type'] == 1) 
                               {
                                  $total_running_minutes_well_type_1 += $rowdata['running_minutes'];
                               }
                            }
                        }
		                
		             
                   }
                  $row['schdule_minutes'] = $total_running_minutes_well_type_0+$total_running_minutes_well_type_1;
		       

               }
		  
	        $next_month = sprintf("%02d", $month + 1);
	        $previous_month = sprintf("%02d", $month - 1);
            if($current_day == 01)
	        {
	        	$previous_month = sprintf("%02d", $month - 1);
	        	$last_day_previous_month = get_last_day_of_previous_month($previous_month, $year);
                $startmonth = date('Y') . '-' . $previous_month . '-'.$last_day_previous_month.' 06:00:00';
	            $endmonth = date('Y') . '-' . $next_month . '-' . $current_day . ' 05:59:59';

	        }else{
	        	 $startmonth = date('Y') . '-' . $previous_month . '-01 06:00:00';
	             $endmonth = date('Y') . '-' . $previous_month . '-' . $current_day . ' 05:59:59';
	        }

	      $this->db->where('wr.start_datetime >=', $startmonth);
	      $this->db->where('wr.end_datetime <=', $endmonth);

	    $previous = $this->db->select("ws.well_site_name,sd.site_id, CONCAT(MONTHNAME(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), ' ', ws.well_site_name) AS x, SUM(wr.total_running_minute) AS y")
	        ->from('tbl_site_device_installation sd')
	        ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
	        ->join('tbl_well_site_master ws', 'ws.id=sd.site_id and ws.status =1', 'left')
	        ->join('tbl_well_running_log wr','wm.id=wr.well_id', 'left')
	        ->where(['sd.status' => 1,'ws.id'=>$site_id])
	        ->group_by('MONTH(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), year(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), sd.site_id') 
	        ->get()
	        ->result_array();

	        foreach ($previous as &$row) {
		        
		         $total_running_minutes_well_type_0 = 0;
                 $total_running_minutes_well_type_1 = 0;
                 $running_minutes_type1 =0;
                 $running_minutes_type0 =0;

		        for ($date = $startmonth; $date <= $endmonth; $date = date('Y-m-d', strtotime($date . ' +1 day'))) {
		            $running_schedule_query = $this->db->select('COALESCE(running_minutes, 0) AS running_minutes, COALESCE(well_type, 0) AS well_type, well_id, site_id')
                        ->from('v_asset_running_schdule_minutes')
                        ->where('site_id', $row['site_id'])
                        ->where('apply_datetime <=', $date . ' 06:00:00')
                        ->where('COALESCE(valid_datetime, NOW()) >=', $date . ' 05:59:59')
                        ->get();



                        $total_running_minutes = 0;
                       if ($running_schedule_query->num_rows() > 0) 
                       {

                            foreach ($running_schedule_query->result_array() as $rowdata) 
                            {
                               if ($rowdata['well_type'] == 0) 
                               {
                                  $total_running_minutes_well_type_0 += $rowdata['running_minutes'];
                               }elseif($rowdata['well_type'] == 1) 
                               {
                                  $total_running_minutes_well_type_1 += $rowdata['running_minutes'];
                               }
                            }
                        }   
		             
                   }
                    $row['schdule_minutes'] = $total_running_minutes_well_type_0+$total_running_minutes_well_type_1;


               }
		       

	    }else{
             
             $next_month = sprintf("%02d",$month + 1);
	    	 $previous_month = sprintf("%02d", $month - 1);	


	    $startmonth = date('Y') . '-' . $month . '-01 06:00:00';
	    $endmonth = date('Y') . '-' . $next_month . '-01 05:59:59';

	    
	    $this->db->where('wr.start_datetime >=', $startmonth);
	    $this->db->where('wr.end_datetime <=', $endmonth);

	    $current = $this->db->select("ws.well_site_name,sd.site_id, CONCAT(MONTHNAME(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), ' ', ws.well_site_name) AS x, SUM(wr.total_running_minute) AS y")
	        ->from('tbl_site_device_installation sd')
	        ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
	        ->join('tbl_well_site_master ws', 'ws.id=sd.site_id and ws.status =1', 'left')
	        ->join('tbl_well_running_log wr','wm.id=wr.well_id', 'left')
	        ->where(['sd.status' => 1,'ws.id'=>$site_id])
	        ->group_by('MONTH(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), year(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), sd.site_id') 
	        ->get()
	        ->result_array();

           
	       foreach ($current as &$row) {
		        
		         $total_running_minutes_well_type_0 = 0;
                 $total_running_minutes_well_type_1 = 0;
                 $running_minutes_type1 =0;
                 $running_minutes_type0 =0;

		        for ($date = $startmonth; $date <= $endmonth; $date = date('Y-m-d', strtotime($date . ' +1 day'))) {
		            $running_schedule_query = $this->db->select('COALESCE(running_minutes, 0) AS running_minutes, COALESCE(well_type, 0) AS well_type, well_id, site_id')
                        ->from('v_asset_running_schdule_minutes')
                        ->where('site_id', $row['site_id'])
                        ->where('apply_datetime <=', $date . ' 06:00:00')
                        ->where('COALESCE(valid_datetime, NOW()) >=', $date . ' 05:59:59')
                        ->get();



                        $total_running_minutes = 0;
                       if ($running_schedule_query->num_rows() > 0) 
                       {

                            foreach ($running_schedule_query->result_array() as $rowdata) 
                            {
                               if ($rowdata['well_type'] == 0) 
                               {
                                  $total_running_minutes_well_type_0 += $rowdata['running_minutes'];
                               }elseif($rowdata['well_type'] == 1) 
                               {
                                  $total_running_minutes_well_type_1 += $rowdata['running_minutes'];
                               }
                            }
                        }
		                
		             
                   }
                     $row['schdule_minutes'] = $total_running_minutes_well_type_0+$total_running_minutes_well_type_1;

               }
		
	    $startmonth = date('Y') . '-' . $previous_month . '-01 06:00:00';
	    $endmonth = date('Y') . '-' . $month . '-01 05:59:59';

	    $this->db->where('wr.start_datetime >=', $startmonth);
	    $this->db->where('wr.end_datetime <=', $endmonth);

	    $previous = $this->db->select("ws.well_site_name,sd.site_id, CONCAT(MONTHNAME(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), ' ', ws.well_site_name) AS x, SUM(wr.total_running_minute) AS y")
	        ->from('tbl_site_device_installation sd')
	        ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
	        ->join('tbl_well_site_master ws', 'ws.id=sd.site_id and ws.status =1', 'left')
	        ->join('tbl_well_running_log wr','wm.id=wr.well_id', 'left')
	        ->where(['sd.status' => 1,'ws.id'=>$site_id])
	        ->group_by('MONTH(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), year(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), sd.site_id') 
	        ->get()
	        ->result_array();

	         foreach ($previous as &$row) {
		        
		         $total_running_minutes_well_type_0 = 0;
                 $total_running_minutes_well_type_1 = 0;
                 $running_minutes_type1 =0;
                 $running_minutes_type0 =0;

		        for ($date = $startmonth; $date <= $endmonth; $date = date('Y-m-d', strtotime($date . ' +1 day'))) {
		            $running_schedule_query = $this->db->select('COALESCE(running_minutes, 0) AS running_minutes, COALESCE(well_type, 0) AS well_type, well_id, site_id')
                        ->from('v_asset_running_schdule_minutes')
                        ->where('site_id', $row['site_id'])
                        ->where('apply_datetime <=', $date . ' 06:00:00')
                        ->where('COALESCE(valid_datetime, NOW()) >=', $date . ' 05:59:59')
                        ->get();

                        $total_running_minutes = 0;
                       if ($running_schedule_query->num_rows() > 0) 
                       {

                            foreach ($running_schedule_query->result_array() as $rowdata) 
                            {
                               if ($rowdata['well_type'] == 0) 
                               {
                                  $total_running_minutes_well_type_0 += $rowdata['running_minutes'];
                               }elseif($rowdata['well_type'] == 1) 
                               {
                                  $total_running_minutes_well_type_1 += $rowdata['running_minutes'];
                               }
                            }
                        }
		                
		             
                   }
                    $row['schdule_minutes'] = $total_running_minutes_well_type_0+$total_running_minutes_well_type_1;
               }
		       
            }


	    $merged_results = [];

	    foreach ($previous as $previous_row) {
	        $well_site_name = $previous_row['well_site_name'];
	        $merged_results[$well_site_name][] = [
	            'x' => $previous_row['x'],
	            'y' => $previous_row['y'],
	            'z' => $previous_row['schdule_minutes']
	           
	        ];
	    }

	    foreach ($current as $current_row) {
	        $well_site_name = $current_row['well_site_name'];
	        $merged_results[$well_site_name][] = [
	            'x' => $current_row['x'],
	            'y' => $current_row['y'],
	            'z' => $current_row['schdule_minutes']
	           
	        ];
	    }


	    $flattened_results = [];
	    foreach ($merged_results as $well_data) {
	        foreach ($well_data as $data) {
	            $flattened_results[] = $data;
	        }
	    }

      return $flattened_results;
    
    }else{

        $current_month = date('m');
	    $current_year = date('Y');
	    $current_day =  date('d');
	  

	    if($current_month == $month && $current_year == $year)
	    {


	    	
	         function get_last_day_of_previous_month($month, $year) {
                 $date = DateTime::createFromFormat('m-Y', sprintf("%02d-%d", $month - 1, $year));
                return $date->format('t');
             }


	        if($current_day == 01)
	        {
	        	$previous_month = sprintf("%02d", $month - 1);
	        	$last_day_previous_month = get_last_day_of_previous_month($previous_month, $year);
                $startmonth = date('Y') . '-' . $previous_month . '-'.$last_day_previous_month.' 06:00:00';
	            $endmonth = date('Y') . '-' . $month . '-' . $current_day . ' 05:59:59';

	        }else{

	        	$startmonth = date('Y') . '-' . $month . '-01 06:00:00';
	            $endmonth = date('Y') . '-' . $month . '-' . $current_day . ' 05:59:59';

	        }

	        $this->db->where('wr.start_datetime >=', $startmonth);
	        $this->db->where('wr.end_datetime <=', $endmonth);

	       $current = $this->db->select("ws.assets_name,sd.assets_id, CONCAT(MONTHNAME(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), ' ', ws.assets_name) AS x, SUM(wr.total_running_minute) AS y")
	        ->from('tbl_site_device_installation sd')
	        ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
	        ->join('tbl_assets_master ws', 'ws.id=sd.assets_id and ws.status =1', 'left')
	        ->join('tbl_well_running_log wr','wm.id=wr.well_id', 'left')
	        ->where(['sd.status' => 1])
	        ->group_by('MONTH(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), year(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), sd.assets_id') 
	        ->get()
	        ->result_array();

	       
	     foreach ($current as &$row) {
		        
		         $total_running_minutes_well_type_0 = 0;
                 $total_running_minutes_well_type_1 = 0;
                 $running_minutes_type1 =0;
                 $running_minutes_type0 =0;

		        for ($date = $startmonth; $date <= $endmonth; $date = date('Y-m-d', strtotime($date . ' +1 day'))) {
		            $running_schedule_query = $this->db->select('COALESCE(running_minutes, 0) AS running_minutes, COALESCE(well_type, 0) AS well_type, well_id, site_id')
                        ->from('v_asset_running_schdule_minutes')
                        ->where('assets_id', $row['assets_id'])
                        ->where('apply_datetime <=', $date . ' 06:00:00')
                        ->where('COALESCE(valid_datetime, NOW()) >=', $date . ' 05:59:59')
                        ->get();



                        $total_running_minutes = 0;
                       if ($running_schedule_query->num_rows() > 0) 
                       {

                            foreach ($running_schedule_query->result_array() as $rowdata) 
                            {
                               if ($rowdata['well_type'] == 0) 
                               {
                                  $total_running_minutes_well_type_0 += $rowdata['running_minutes'];
                               }elseif($rowdata['well_type'] == 1) 
                               {
                                  $total_running_minutes_well_type_1 += $rowdata['running_minutes'];
                               }
                            }
                        }
		                
		             
                   }
                  $row['schdule_minutes'] = $total_running_minutes_well_type_0+$total_running_minutes_well_type_1;

               }
		    
	      if ($site_id != '') {
	        $this->db->where('ws.id', $site_id);
	      }

	   
	        $next_month = sprintf("%02d", $month + 1);
	        $previous_month = sprintf("%02d", $month - 1);
            if($current_day == 01)
	        {
	        	$previous_month = sprintf("%02d", $month - 1);
	        	$last_day_previous_month = get_last_day_of_previous_month($previous_month, $year);
                $startmonth = date('Y') . '-' . $previous_month . '-'.$last_day_previous_month.' 06:00:00';
	            $endmonth = date('Y') . '-' . $next_month . '-' . $current_day . ' 05:59:59';

	        }else{
	        	 $startmonth = date('Y') . '-' . $previous_month . '-01 06:00:00';
	             $endmonth = date('Y') . '-' . $previous_month . '-' . $current_day . ' 05:59:59';
	        }

	      $this->db->where('wr.start_datetime >=', $startmonth);
	      $this->db->where('wr.end_datetime <=', $endmonth);

	     $previous = $this->db->select("ws.assets_name,sd.assets_id, CONCAT(MONTHNAME(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), ' ', ws.assets_name) AS x, SUM(wr.total_running_minute) AS y")
	        ->from('tbl_site_device_installation sd')
	        ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
	        ->join('tbl_assets_master ws', 'ws.id=sd.assets_id and ws.status =1', 'left')
	        ->join('tbl_well_running_log wr','wm.id=wr.well_id', 'left')
	        ->where(['sd.status' => 1])
	        ->group_by('MONTH(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), year(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), sd.assets_id') 
	        ->get()
	        ->result_array();

	        foreach ($previous as &$row) {
		        
		         $total_running_minutes_well_type_0 = 0;
                 $total_running_minutes_well_type_1 = 0;
                 $running_minutes_type1 =0;
                 $running_minutes_type0 =0;

		        for ($date = $startmonth; $date <= $endmonth; $date = date('Y-m-d', strtotime($date . ' +1 day'))) {
		            $running_schedule_query = $this->db->select('COALESCE(running_minutes, 0) AS running_minutes, COALESCE(well_type, 0) AS well_type,assets_id')
                        ->from('v_asset_running_schdule_minutes')
                        ->where('assets_id', $row['assets_id'])
                        ->where('apply_datetime <=', $date . ' 06:00:00')
                        ->where('COALESCE(valid_datetime, NOW()) >=', $date . ' 05:59:59')
                        ->get();



                        $total_running_minutes = 0;
                       if ($running_schedule_query->num_rows() > 0) 
                       {

                            foreach ($running_schedule_query->result_array() as $rowdata) 
                            {
                               if ($rowdata['well_type'] == 0) 
                               {
                                  $total_running_minutes_well_type_0 += $rowdata['running_minutes'];
                               }elseif($rowdata['well_type'] == 1) 
                               {
                                  $total_running_minutes_well_type_1 += $rowdata['running_minutes'];
                               }
                            }
                        }   
		             
                   }
                    $row['schdule_minutes'] = $total_running_minutes_well_type_0+$total_running_minutes_well_type_1;


               }
		       

	    }else{
             
             $next_month = sprintf("%02d",$month + 1);
	    	 $previous_month = sprintf("%02d", $month - 1);	


	      if ($site_id != '') {
	        $this->db->where('ws.id', $site_id);
	      }

	    $startmonth = date('Y') . '-' . $month . '-01 06:00:00';
	    $endmonth = date('Y') . '-' . $next_month . '-01 05:59:59';

	    
	    $this->db->where('wr.start_datetime >=', $startmonth);
	    $this->db->where('wr.end_datetime <=', $endmonth);

	    $current = $this->db->select("ws.assets_name,sd.assets_id, CONCAT(MONTHNAME(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), ' ', ws.assets_name) AS x, SUM(wr.total_running_minute) AS y")
	        ->from('tbl_site_device_installation sd')
	        ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
	        ->join('tbl_assets_master ws', 'ws.id=sd.assets_id and ws.status =1', 'left')
	        ->join('tbl_well_running_log wr','wm.id=wr.well_id', 'left')
	        ->where(['sd.status' => 1])
	        ->group_by('MONTH(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), year(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), sd.assets_id') 
	        ->get()
	        ->result_array();

           
	       foreach ($current as &$row) {
		        
		         $total_running_minutes_well_type_0 = 0;
                 $total_running_minutes_well_type_1 = 0;
                 $running_minutes_type1 =0;
                 $running_minutes_type0 =0;

		        for ($date = $startmonth; $date <= $endmonth; $date = date('Y-m-d', strtotime($date . ' +1 day'))) {
		            $running_schedule_query = $this->db->select('COALESCE(running_minutes, 0) AS running_minutes, COALESCE(well_type, 0) AS well_type, well_id, assets_id')
                        ->from('v_asset_running_schdule_minutes')
                        ->where('assets_id', $row['assets_id'])
                        ->where('apply_datetime <=', $date . ' 06:00:00')
                        ->where('COALESCE(valid_datetime, NOW()) >=', $date . ' 05:59:59')
                        ->get();



                        $total_running_minutes = 0;
                       if ($running_schedule_query->num_rows() > 0) 
                       {

                            foreach ($running_schedule_query->result_array() as $rowdata) 
                            {
                               if ($rowdata['well_type'] == 0) 
                               {
                                  $total_running_minutes_well_type_0 += $rowdata['running_minutes'];
                               }elseif($rowdata['well_type'] == 1) 
                               {
                                  $total_running_minutes_well_type_1 += $rowdata['running_minutes'];
                               }
                            }
                        }
		                
		             
                   }
                     $row['schdule_minutes'] = $total_running_minutes_well_type_0+$total_running_minutes_well_type_1;

               }
		      


	    if ($site_id != '') {
	        $this->db->where('ws.id', $site_id);
	    }

	    $startmonth = date('Y') . '-' . $previous_month . '-01 06:00:00';
	    $endmonth = date('Y') . '-' . $month . '-01 05:59:59';

	    $this->db->where('wr.start_datetime >=', $startmonth);
	    $this->db->where('wr.end_datetime <=', $endmonth);

	    $previous = $this->db->select("ws.assets_name,sd.assets_id, CONCAT(MONTHNAME(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), ' ', ws.assets_name) AS x, SUM(wr.total_running_minute) AS y")
	        ->from('tbl_site_device_installation sd')
	        ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
	        ->join('tbl_assets_master ws', 'ws.id=sd.assets_id and ws.status =1', 'left')
	        ->join('tbl_well_running_log wr','wm.id=wr.well_id', 'left')
	        ->where(['sd.status' => 1])
	        ->group_by('MONTH(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), year(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR)), sd.assets_id') 
	        ->get()
	        ->result_array();


	         foreach ($previous as &$row) {
		        
		         $total_running_minutes_well_type_0 = 0;
                 $total_running_minutes_well_type_1 = 0;
                 $running_minutes_type1 =0;
                 $running_minutes_type0 =0;

		        for ($date = $startmonth; $date <= $endmonth; $date = date('Y-m-d', strtotime($date . ' +1 day'))) {
		            $running_schedule_query = $this->db->select('COALESCE(running_minutes, 0) AS running_minutes, COALESCE(well_type, 0) AS well_type, well_id, assets_id')
                        ->from('v_asset_running_schdule_minutes')
                        ->where('assets_id', $row['assets_id'])
                        ->where('apply_datetime <=', $date . ' 06:00:00')
                        ->where('COALESCE(valid_datetime, NOW()) >=', $date . ' 05:59:59')
                        ->get();

                        $total_running_minutes = 0;
                       if ($running_schedule_query->num_rows() > 0) 
                       {

                            foreach ($running_schedule_query->result_array() as $rowdata) 
                            {
                               if ($rowdata['well_type'] == 0) 
                               {
                                  $total_running_minutes_well_type_0 += $rowdata['running_minutes'];
                               }elseif($rowdata['well_type'] == 1) 
                               {
                                  $total_running_minutes_well_type_1 += $rowdata['running_minutes'];
                               }
                            }
                        }
		                
		             
                   }
                    $row['schdule_minutes'] = $total_running_minutes_well_type_0+$total_running_minutes_well_type_1;
               }
		       
            }
        }


	    $merged_results = [];

	    foreach ($previous as $previous_row) {
	        $assets_name = $previous_row['assets_name'];
	        $merged_results[$assets_name][] = [
	            'x' =>$previous_row['x'],
	            'y' => $previous_row['y'],
	            'z' => $previous_row['schdule_minutes']
	           
	        ];
	    }


	    foreach ($current as $current_row) {
	        $assets_name = $current_row['assets_name'];
	        $merged_results[$assets_name][] = [
	            'x' => $current_row['x'],
	            'y' => $current_row['y'],
	            'z' => $current_row['schdule_minutes']
	           
	        ];
	    }



	    $flattened_results = [];
	    foreach ($merged_results as $well_data) {
	        foreach ($well_data as $data) {
	            $flattened_results[] = $data;
	        }
	    }

      return $flattened_results;
    }

}
?>
