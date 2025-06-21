// public function well_runningEnergy_logreport($site_id, $well_id, $from_date, $to_date,$sort_by)
    // {

    // 	if ($site_id != '') {
	//         $this->db->where('ws.id', $site_id);
	//     }
	//     if ($well_id != '') {
	//         $this->db->where('sd.well_id', $well_id);
	//     }

	   
	//      if ($from_date != '' && $to_date != '') {
    //         $fromTime = date('Y-m-d 06:00:00', strtotime($from_date));
    //         if ($from_date == $to_date) {
    //             $toTime = date('Y-m-d 06:00:00', strtotime($to_date . '+1 day'));
    //         } else {
    //             $toTime = date('Y-m-d 06:00:00', strtotime($to_date . '+1 day'));
    //         }
    //         $this->db->where('wr.start_datetime >=', $fromTime);
    //         $this->db->where('wr.end_datetime <', $toTime);
    //     }

    //     if ($sort_by != '') 
    //         $this->db->order_by($sort_by, 'ASC');

	//     $datetime1 = new DateTime($from_date);
	//     $datetime2 = new DateTime($to_date);
	//     $interval = $datetime1->diff($datetime2);
	//     $dateDifference = $interval->days + 1; 

	//     $result = $this->db->select('wm.well_name, sd.well_id, SUM(wr.total_kwh) AS e_consumption, SUM(wr.total_running_minute) AS t_minute,vw.running_minutes,ws.well_site_name')
	//         ->from('tbl_site_device_installation sd')
	//         ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
	//         ->join('tbl_well_site_master ws', 'ws.id=sd.site_id  and ws.status = 1', 'left')
	//         ->join('tbl_well_running_log wr', 'wm.id=wr.well_id', 'left')
	//         ->join('v_well_running_config vw', 'vw.well_id=sd.well_id', 'left')
	//         ->where(['sd.status' => 1])
	//         ->group_by('sd.well_id')
	//         ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
	//         ->get()
	//         ->result_array();
	    
	//     foreach ($result as &$row) {
	//         $row['running_minutes'] *= $dateDifference;
	//         $row['shutdown_minutes'] = $row['running_minutes'] - $row['t_minute'];
	        
	     
	//         if ($row['running_minutes']!= 0) {
	//             $row['availability'] = ($row['t_minute'] / $row['running_minutes']) * 100;
	//         } else {
	//             $row['availability'] = 0; 
	//         }
	//     }

    //   return $result;
    // }

	// public function well_runningEnergy_logreport($site_id, $well_id, $from_date, $to_date,$sort_by)
    // {

    // 	if ($site_id != '') {
	//         $this->db->where('ws.id', $site_id);
	//     }
	//     if ($well_id != '') {
	//         $this->db->where('sd.well_id', $well_id);
	//     }

	//        $current_date = date('Y-m-d');
	   
	//      if ($from_date != '' && $to_date != '') {
    //         $fromTime = date('Y-m-d 06:00:00', strtotime($from_date));

    //         if ($from_date == $to_date) {
    //             $toTime = date('Y-m-d 06:00:00', strtotime($to_date . '+1 day'));
    //         } else {
    //             $toTime = date('Y-m-d 06:00:00', strtotime($to_date . '+1 day'));
    //         }
    //         $this->db->where('wr.start_datetime >=', $fromTime);
    //         $this->db->where('wr.end_datetime <', $toTime);
    //     }

    //     if ($sort_by != '') 
    //         $this->db->order_by($sort_by, 'ASC');

	//     $datetime1 = new DateTime($from_date);
	//     $datetime2 = new DateTime($to_date);
	//     $interval = $datetime1->diff($datetime2);
	//     $dateDifference = $interval->days + 1; 

	//     $result = $this->db->select('wm.well_name, sd.well_id, SUM(wr.total_kwh) AS e_consumption, SUM(wr.total_running_minute) AS t_minute,vw.running_minutes,ws.well_site_name,vw.well_type,vp.total_running_required')
	//         ->from('tbl_site_device_installation sd')
	//         ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
	//         ->join('tbl_well_site_master ws', 'ws.id=sd.site_id  and ws.status = 1', 'left')
	//         ->join('tbl_well_running_log wr', 'wm.id=wr.well_id', 'left')
	//         ->join('v_well_running_config vw', 'vw.well_id=sd.well_id', 'left')
	//         ->join('v_period_well_running_required vp','vp.well_id=sd.well_id','left')
	//         ->where(['sd.status'=>1,'sd.device_shifted'=>0])
	//         ->group_by('sd.well_id')
	//         ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
	//         ->get()
	//         ->result_array();
	    
	//     foreach ($result as &$row) 
	//     {
	//     	if($row['well_type'] == 1)
	//     	{
                
    //             if( $to_date == $current_date)
	//     		{
    //                 $row['running_minutes'] = ($row['running_minutes']*($dateDifference -1)) + $row['total_running_required'];
	// 	        	$row['shutdown_minutes'] = $row['running_minutes'] - $row['t_minute'];

	// 	        	if ($row['running_minutes']!= 0) {
	//                  $row['availability'] = ($row['t_minute'] / $row['running_minutes']) * 100;
	//                 } else {
	//                   $row['availability'] = 0; 
	//                 }

    //             }else{

    //             	$row['running_minutes'] = $row['running_minutes'] * $dateDifference;
	// 	        	$row['shutdown_minutes'] = $row['running_minutes'] - $row['t_minute'];

	// 	        	if ($row['running_minutes']!= 0) {
	//                  $row['availability'] = ($row['t_minute'] / $row['running_minutes']) * 100;
	//                 } else {
	//                   $row['availability'] = 0; 
	//                 }
    //             }
	//     	}else{

	//     		if($to_date == $current_date)
	//     		{
	//     			 $current_time_now = time(); 
	//                  $current_time = strtotime(date('Y-m-d 06:00:00'));
    //                  $current_time_minutes = ($current_time_now - $current_time) / 60;
	//     			 $row['running_minutes'] = (($row['running_minutes']*($dateDifference -1)) +$current_time_minutes);
	//         		 $row['shutdown_minutes'] = $row['running_minutes'] - $row['t_minute'];

	//         		 if ($row['running_minutes']!= 0) 
	//         		 {
	//                      $row['availability'] = ($row['t_minute'] / $row['running_minutes']) * 100;
	//                  } else {
	//                       $row['availability'] = 0; 
	//                  }

	// 	        }else{

	// 	        	$row['running_minutes'] = $row['running_minutes'] * $dateDifference;
	// 	        	$row['shutdown_minutes'] = $row['running_minutes'] - $row['t_minute'];

	// 	        	 if ($row['running_minutes']!= 0) 
	//         		 {
	//                      $row['availability'] = ($row['t_minute'] / $row['running_minutes']) * 100;
	//                  } else {
	//                       $row['availability'] = 0; 
	//                  }
	// 	        }
	    		
	//     	}
	//     }

    //   return $result;
    // }

    // public function well_runningEnergy_logreport($site_id, $well_id, $from_date, $to_date, $sort_by)
	// {
	//     if ($site_id != '') {
	//         $this->db->where('ws.id', $site_id);
	//     }
	//     if ($well_id != '') {
	//         $this->db->where('sd.well_id', $well_id);
	//     }

	//     $current_date = date('Y-m-d');

	//     if ($from_date != '' && $to_date != '') {
	//         $fromTime = date('Y-m-d 06:00:00', strtotime($from_date));
	//         $toTime = date('Y-m-d 06:00:00', strtotime($to_date . '+1 day'));
	//         $this->db->where('wr.start_datetime >=', $fromTime);
	//         $this->db->where('wr.end_datetime <', $toTime);
	//     }

	//     if ($sort_by != '') {
	//         $this->db->order_by($sort_by, 'ASC');
	//     }

	//     $datetime1 = new DateTime($from_date);
	//     $datetime2 = new DateTime($to_date);
	//     $interval = $datetime1->diff($datetime2);
	//     $dateDifference = $interval->days + 1;

	//     $result = $this->db->select('sd.well_id, wm.well_name, COALESCE(SUM(wr.total_kwh), 0) AS e_consumption, COALESCE(SUM(wr.total_running_minute), 0) AS t_minute, COALESCE(vw.running_minutes,1440) AS running_minutes,ws.well_site_name,vw.well_type, COALESCE(vp.total_running_required,0)AS total_running_required,sd.date_of_installation')
	//         ->from('tbl_site_device_installation sd')
	//         ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
	//         ->join('tbl_well_site_master ws', 'ws.id = sd.site_id and ws.status = 1', 'left')
	//         ->join('tbl_well_running_log wr', 'sd.well_id = wr.well_id', 'left')
	//         ->join('v_running_schdule_minutes vw', 'sd.well_id = vw.well_id AND vw.apply_datetime <= wr.start_datetime AND COALESCE(vw.valid_datetime, NOW()) >= wr.end_datetime','left')
	//         ->join('v_period_well_running_required vp', 'vp.well_id = sd.well_id', 'left')
	//         ->group_by('sd.well_id')->get()->result_array();

	//         // print_r($result);die;


	//     foreach ($result as &$row) {
	     

	//         	if($row['well_type'] == 1)
	//     	   {
                
    //             if( $to_date == $current_date)
	//     		{
    //                 $row['running_minutes'] = ($row['running_minutes']*($dateDifference -1)) + $row['total_running_required'];
	// 	        	$row['shutdown_minutes'] = $row['running_minutes'] - $row['t_minute'];

	// 	        	if ($row['running_minutes']!= 0) {
	//                  $row['availability'] = ($row['t_minute'] / $row['running_minutes']) * 100;
	//                 } else {
	//                   $row['availability'] = 0; 
	//                 }

    //             }else{

    //             	$row['running_minutes'] = $row['running_minutes'] * $dateDifference;
	// 	        	$row['shutdown_minutes'] = $row['running_minutes'] - $row['t_minute'];

	// 	        	if ($row['running_minutes']!= 0) {
	//                  $row['availability'] = ($row['t_minute'] / $row['running_minutes']) * 100;
	//                 } else {
	//                   $row['availability'] = 0; 
	//                 }
    //             }
	//     	}else{

	//     		if($to_date == $current_date)
	//     		{
	//     			 $current_time_now = time(); 
	//                  $current_time = strtotime(date('Y-m-d 06:00:00'));
    //                  $current_time_minutes = ($current_time_now - $current_time) / 60;
	//     			 $row['running_minutes'] = (($row['running_minutes']*($dateDifference -1)) +$current_time_minutes);
	//         		 $row['shutdown_minutes'] = $row['running_minutes'] - $row['t_minute'];

	//         		 if ($row['running_minutes']!= 0) 
	//         		 {
	//                      $row['availability'] = ($row['t_minute'] / $row['running_minutes']) * 100;
	//                  } else {
	//                       $row['availability'] = 0; 
	//                  }

	// 	        }else{

	// 	        	$row['running_minutes'] = $row['running_minutes'] * $dateDifference;
	// 	        	$row['shutdown_minutes'] = $row['running_minutes'] - $row['t_minute'];

	// 	        	 if ($row['running_minutes']!= 0) 
	//         		 {
	//                      $row['availability'] = ($row['t_minute'] / $row['running_minutes']) * 100;
	//                  } else {
	//                       $row['availability'] = 0; 
	//                  }
	// 	        }
	    		
	//     	}
	//     }

	//     return $result;
	// }

	// public function well_runningEnergy_logreport($site_id, $well_id, $from_date, $to_date, $sort_by)
	// {
	//    	if ($site_id != '') 
	//    	{
	//         $this->db->where('ws.id', $site_id);
	//     }
	//     if ($well_id != '') 
	//     {
	//         $this->db->where('sd.well_id', $well_id);
	//     }

	//     $current_date = date('Y-m-d');

	//     if ($from_date != '' && $to_date != '') 
	//     {
	//         $fromTime = date('Y-m-d 06:00:00', strtotime($from_date));
	//         if ($from_date == $to_date) {
	//             $toTime = date('Y-m-d 06:00:00', strtotime($to_date . '+1 day'));
	//         } else {
	//             $toTime = date('Y-m-d 06:00:00', strtotime($to_date . '+1 day'));
	//         }
	//         $this->db->where('wr.start_datetime >=', $fromTime);
	//         $this->db->where('wr.end_datetime <', $toTime);
    //     }

    //     if ($sort_by != '') 
    //         $this->db->order_by($sort_by, 'ASC');

	//        $result = $this->db->select('wm.well_name, DATE_FORMAT(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR), "%Y-%m-%d") AS start_datetime, sd.well_id, COALESCE(SUM(wr.total_kwh), 0) AS e_consumption, COALESCE(SUM(wr.total_running_minute),0) AS t_minute, COALESCE(vw.running_minutes,1440)AS running_minutes,COALESCE(vp.total_running_required,0)AS total_running_required, COALESCE(vw.well_type,0)AS well_type,ws.well_site_name')
	//             ->from('tbl_site_device_installation sd')
	//             ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
	//             ->join('tbl_well_site_master ws', 'ws.id=sd.site_id  and ws.status = 1', 'left')
	//             ->join('tbl_well_running_log wr', 'wm.id=wr.well_id', 'left')
	//             ->join('v_running_schdule_minutes vw', 'sd.well_id = vw.well_id AND vw.apply_datetime <= wr.start_datetime AND COALESCE(vw.valid_datetime, NOW()) >= wr.end_datetime','left')
	//             ->join('v_period_well_running_required vp', 'vp.well_id = sd.well_id', 'left')
	//             ->where(['sd.status' => 1,'sd.device_shifted'=>0])
	//             ->group_by('sd.well_id, DATE_FORMAT(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR), "%Y-%m-%d")') 
	//             ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
	//             ->order_by("wr.start_datetime ASC") 
	//             ->get()
	//             ->result_array();



    //         if ($well_id != '') 
    //         {
    //             $this->db->where('sd.well_id', $well_id);
    //         }

    //         if ($site_id != '') 
    //         {
    //              $this->db->where('ws.id', $site_id);
    //         }

    //         $all_wells = $this->db->select('sd.well_id, wsmm.well_name, ws.well_site_name,COALESCE(vw.running_minutes, 1440) AS running_minutes,COALESCE(vw.well_type,0)AS well_type,COALESCE(vp.total_running_required, 0) AS total_running_required,sd.date_of_installation')
    //         ->from('tbl_site_device_installation sd')
    //         ->join('tbl_well_master wsmm', 'wsmm.id = sd.well_id', 'left')
    //         ->join('tbl_well_site_master ws', 'sd.site_id = ws.id', 'left')
    //         ->join('v_running_schdule_minutes vw', 'vw.well_id = sd.well_id AND vw.apply_datetime <= "'.$from_date.'" AND COALESCE(vw.valid_datetime, NOW()) >= "'.$to_date.'"', 'left')
    //         ->join('v_period_well_running_required vp', 'vp.well_id = sd.well_id', 'left')
    //         ->where('sd.date_of_installation <=', $to_date)
    //         ->where(['sd.status'=> 1,'sd.device_shifted'=>0])
    //         ->get()
    //         ->result_array();

    //         $running_wells = array_column($result, 'well_id');
    //         $all_installed_wells = array_column($all_wells, 'well_id');
    //         $non_running_wells = array_diff($all_installed_wells, $running_wells);

    //     foreach ($non_running_wells as $well_id) {
          
    //         $well_name = '';
    //         foreach ($all_wells as $well) {
    //             if ($well['well_id'] == $well_id) 
    //             {
    //                 $well_name = $well['well_name'];
    //                 $well_site_name = $well['well_site_name'];

    //                 break;
    //             }
    //         }

    //         for ($date = $from_date; $date <= $to_date; $date = date('Y-m-d', strtotime($date . ' +1 day'))) {
    //             $empty_entry = [
    //                 'well_name' => $well_name,
    //                 'well_id' => $well_id,
    //                 'well_site_name'=>$well_site_name,
    //                 'start_datetime' => $date,
    //                 'e_consumption' => 0,
    //                 't_minute' => 0,
    //                 'running_minutes' => $well['running_minutes'], 
    //                 'well_type' => $well['well_type'], 
    //                 'total_running_required' => $well['total_running_required'], 
    //             ];

    //             $result[] = $empty_entry;
    //         }
    //     }
    //     foreach ($result as &$row)
    //     {

    //         $date = $row['start_datetime'];

    //             if($row['well_type'] == 1)
    //            {
                
    //             if( $date == $current_date)
    //             {
    //                 $row['running_minutes'] =   $row['total_running_required'];
    //                 $row['shutdown_minutes'] = $row['running_minutes'] - $row['t_minute'];

    //             }else{

    //                 $row['running_minutes'] = $row['running_minutes'];
    //                 $row['shutdown_minutes'] = $row['running_minutes'] - $row['t_minute'];

    //             }
    //         }else{

    //             if($date == $current_date)
    //             {
                
    //                  $current_time_now = time(); 
    //                  $current_time = strtotime(date('Y-m-d 06:00:00'));
    //                  $current_time_minutes = ($current_time_now - $current_time) / 60;
    //                  $row['running_minutes'] = $current_time_minutes;
    //                  $row['shutdown_minutes'] = $row['running_minutes'] - $row['t_minute'];

    //             }else{

    //                 $row['running_minutes'] = $row['running_minutes'];
    //                 $row['shutdown_minutes'] = $row['running_minutes'] - $row['t_minute'];
                   
    //             }
                
    //         }
    //     }
    //     // return $result;

    //     $grouped_result = [];
    //        foreach ($result as $row) {
    //          $grouped_result[$row['well_id']][] = $row;
    //       }
	//        $combined_result = [];
	//        foreach ($grouped_result as $well_id => $data) 
	//        {
	       	
	//         $running_minutes_sum = array_sum(array_column($data, 'running_minutes'));
	// 		$t_minute_sum = array_sum(array_column($data, 't_minute'));
	// 		$availability = $running_minutes_sum != 0 ? ($t_minute_sum / $running_minutes_sum) * 100 : 0;

	// 		$combined_entry = [
	// 		'well_name' => isset($data[0]['well_name']) ? $data[0]['well_name'] : '',
    //         'well_site_name' =>isset($data[0]['well_site_name']) ? $data[0]['well_site_name'] :'',
	// 		'e_consumption' => array_sum(array_column($data, 'e_consumption')),
	// 		't_minute' => $t_minute_sum,
	// 		'running_minutes' => $running_minutes_sum, 
	// 		'shutdown_minutes' => $running_minutes_sum - $t_minute_sum,
	// 		'availability' => $availability,
	// 		];
	//         $combined_result[] = $combined_entry;
	//     }

	//     return $combined_result;

	// }// public function well_runningEnergylog($site_id, $from_date, $to_date,$sort_by)
	// {
	// 	if ($site_id != '') 
	//    	{
	//         $this->db->where('ws.id', $site_id);
	//     }
	    

	//     $current_date = date('Y-m-d');

	//     if ($from_date != '' && $to_date != '') 
	//     {
	//         $fromTime = date('Y-m-d 06:00:00', strtotime($from_date));
	//         if ($from_date == $to_date) {
	//             $toTime = date('Y-m-d 06:00:00', strtotime($to_date . '+1 day'));
	//         } else {
	//             $toTime = date('Y-m-d 06:00:00', strtotime($to_date . '+1 day'));
	//         }
	//         $this->db->where('wr.start_datetime >=', $fromTime);
	//         $this->db->where('wr.end_datetime <', $toTime);
    //     }

    //     if ($sort_by != '') 
    //         $this->db->order_by($sort_by, 'ASC');

	//        $result = $this->db->select('wm.well_name, DATE_FORMAT(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR), "%Y-%m-%d") AS start_datetime, sd.well_id, COALESCE(SUM(wr.total_kwh), 0) AS e_consumption, COALESCE(SUM(wr.total_running_minute),0) AS t_minute, COALESCE(vw.running_minutes,1440)AS running_minutes,COALESCE(vp.total_running_required,0)AS total_running_required, COALESCE(vw.well_type,0)AS well_type,ws.well_site_name,sd.site_id')
	//             ->from('tbl_site_device_installation sd')
	//             ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status = 1', 'left')
	//             ->join('tbl_well_site_master ws', 'ws.id=sd.site_id  and ws.status = 1', 'left')
	//             ->join('tbl_well_running_log wr', 'wm.id=wr.well_id', 'left')
	//             ->join('v_running_schdule_minutes vw', 'sd.well_id = vw.well_id AND vw.apply_datetime <= wr.start_datetime AND COALESCE(vw.valid_datetime, NOW()) >= wr.end_datetime','left')
	//             ->join('v_period_well_running_required vp', 'vp.well_id = sd.well_id', 'left')
	//             ->where(['sd.status' => 1,'sd.device_shifted'=>0])
	//             ->group_by('sd.well_id, DATE_FORMAT(DATE_SUB(wr.start_datetime, INTERVAL 6 HOUR), "%Y-%m-%d")') 
	//             ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
	//             ->order_by("wr.start_datetime ASC") 
	//             ->get()
	//             ->result_array();

    //         if ($site_id != '') 
    //         {
    //              $this->db->where('ws.id', $site_id);
    //         }

    //         $all_wells = $this->db->select('sd.well_id, wsmm.well_name, ws.well_site_name,COALESCE(vw.running_minutes, 1440) AS running_minutes,COALESCE(vw.well_type,0)AS well_type,COALESCE(vp.total_running_required, 0) AS total_running_required,sd.date_of_installation,sd.site_id')
    //         ->from('tbl_site_device_installation sd')
    //         ->join('tbl_well_master wsmm', 'wsmm.id = sd.well_id', 'left')
    //         ->join('tbl_well_site_master ws', 'sd.site_id = ws.id', 'left')
    //         ->join('v_running_schdule_minutes vw', 'vw.well_id = sd.well_id AND vw.apply_datetime <= "'.$from_date.'" AND COALESCE(vw.valid_datetime, NOW()) >= "'.$to_date.'"', 'left')
    //         ->join('v_period_well_running_required vp', 'vp.well_id = sd.well_id', 'left')
    //         ->where('sd.date_of_installation <=', $to_date)
    //         ->where(['sd.status'=> 1,'sd.device_shifted'=>0])
    //         ->get()
    //         ->result_array();

    //         $running_wells = array_column($result, 'well_id');
    //         $all_installed_wells = array_column($all_wells, 'well_id');
    //         $non_running_wells = array_diff($all_installed_wells, $running_wells);

    //     foreach ($non_running_wells as $well_id) {
          
    //         $well_name = '';
    //         foreach ($all_wells as $well) {
    //             if ($well['well_id'] == $well_id) 
    //             {
    //                 $well_name = $well['well_name'];
    //                 $well_site_name = $well['well_site_name'];

    //                 break;
    //             }
    //         }

    //         for ($date = $from_date; $date <= $to_date; $date = date('Y-m-d', strtotime($date . ' +1 day'))) {
    //             $empty_entry = [
    //                 'well_name' => $well_name,
    //                 'well_id' => $well_id,
    //                 'site_id'=>$site_id,
    //                 'well_site_name'=>$well_site_name,
    //                 'start_datetime' => $date,
    //                 'e_consumption' => 0,
    //                 't_minute' => 0,
    //                 'running_minutes' => $well['running_minutes'], 
    //                 'well_type' => $well['well_type'], 
    //                 'total_running_required' => $well['total_running_required'], 
    //             ];

    //             $result[] = $empty_entry;
    //         }
    //     }
    //     foreach ($result as &$row)
    //     {

    //         $date = $row['start_datetime'];

    //             if($row['well_type'] == 1)
    //            {
                
    //             if( $date == $current_date)
    //             {
    //                 $row['running_minutes'] =   $row['total_running_required'];
    //                 $row['shutdown_minutes'] = $row['running_minutes'] - $row['t_minute'];

    //             }else{

    //                 $row['running_minutes'] = $row['running_minutes'];
    //                 $row['shutdown_minutes'] = $row['running_minutes'] - $row['t_minute'];

    //             }
    //         }else{

    //             if($date == $current_date)
    //             {
                
    //                  $current_time_now = time(); 
    //                  $current_time = strtotime(date('Y-m-d 06:00:00'));
    //                  $current_time_minutes = ($current_time_now - $current_time) / 60;
    //                  $row['running_minutes'] = $current_time_minutes;
    //                  $row['shutdown_minutes'] = $row['running_minutes'] - $row['t_minute'];

    //             }else{

    //                 $row['running_minutes'] = $row['running_minutes'];
    //                 $row['shutdown_minutes'] = $row['running_minutes'] - $row['t_minute'];
                   
    //             }
                
    //         }
    //     }
    //     // return $result;
    //     $grouped_result = [];
    //        foreach ($result as $row) {
    //          $grouped_result[$row['site_id']][] = $row;
    //       }
	//        $combined_result = [];
	//        foreach ($grouped_result as $site_id => $data) 
	//        {

	//        	  $distinct_well_ids = array_unique(array_column($data, 'well_id'));
    //           $total_wells = count($distinct_well_ids);
	       	
	//         $running_minutes_sum = array_sum(array_column($data, 'running_minutes'));
	// 		$t_minute_sum = array_sum(array_column($data, 't_minute'));
	// 		$availability = $running_minutes_sum != 0 ? ($t_minute_sum / $running_minutes_sum) * 100 : 0;

	// 		$combined_entry = [
	// 		'total_wells'=>$total_wells,
    //         'well_site_name' =>isset($data[0]['well_site_name']) ? $data[0]['well_site_name'] :'',
	// 		'e_consumption' => array_sum(array_column($data, 'e_consumption')),
	// 		't_minute' => $t_minute_sum,
	// 		'running_minutes' => $running_minutes_sum, 
	// 		'shutdown_minutes' => $running_minutes_sum - $t_minute_sum,
	// 		'availability' => $availability,
	// 		];
	//         $combined_result[] = $combined_entry;
	//     }

	//     return $combined_result;
	// }
   


   [well_site_name] => Nadiad
[total_no_of_wells] => 8
[total_no_of_type1_wells] => 5
[total_no_of_type0_wells] => 3
[running_minutes_type1] => 3840
[running_minutes_type0] => 4320
[t_minute_type1] => 3601
[t_minute_type0] => 3251
[total_running_required] => 2469
[e_consumption] => 504.58


 "well_site_name": "Nadiad",
                "total_no_of_wells": "8",
                "total_no_of_type1_wells": "5",
                "total_no_of_type0_wells": "3",
                "running_minutes_type1": 1380,
                "running_minutes_type0": 0,
                "t_minute_type1": "3601",
                "t_minute_type0": "3251",
                "total_running_required": "2475",
                "e_consumption": "504.58",
                "schedule_minute": "480",
                "running_minutes": 1380,
                "t_minute": 6852,
                "shutdown_minutes": -5472,
                "availability": 496.5217391304348

   <tr>
    <th>well_id</th>
    <th>running_minutes</th>
    <th>apply_datetime</th>
     <th>valid_datetime</th>
  </tr>
  <tr>
    <td>1202eeb3-b396-11ee-a6d4-5cb901ad9cf0</td>
    <td>480</td>
    <td>2024-03-19 06:00:00</td>
    <td>2024-04-19 05:59:59</td>
  </tr>
  <tr>
   <td>1202eeb3-b396-11ee-a6d4-5cb901ad9cf0</td>
    <td>1440</td>
    <td>2024-04-19 06:00:00</td>
    <td>2024-04-27 05:59:59</td>
  </tr>
  <tr>
    <td>1202eeb3-b396-11ee-a6d4-5cb901ad9cf0</td>
    <td>1440</td>
    <td>2024-04-27 06:00:00</td>
    <td></td>
  </tr>


  output return 
   <tr>
    <th>well_id</th>
    <th>running_minutes</th>
    <th>apply_datetime</th>
     <th>valid_datetime</th>
     <th>No_of_days</th>
  </tr>
  <tr>
    <td>1202eeb3-b396-11ee-a6d4-5cb901ad9cf0</td>
    <td>480</td>
    <td>2024-04-01 06:00:00</td>
    <td>2024-04-19 05:59:59</td>
  </tr>
  <tr>
   <td>1202eeb3-b396-11ee-a6d4-5cb901ad9cf0</td>
    <td>1440</td>
    <td>2024-04-19 06:00:00</td>
    <td>2024-04-27 05:59:59</td>
  </tr>
  <tr>
    <td>1202eeb3-b396-11ee-a6d4-5cb901ad9cf0</td>
    <td>1440</td>
    <td>2024-04-27 06:00:00</td>
    <td>2024-04-31 05:59:59</td>
    
  </tr>

 