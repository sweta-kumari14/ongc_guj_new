<?php
date_default_timezone_set('Asia/Kolkata');
class Report_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function DeviceAllotment_To_CompanyReport($company_id,$from_date,$to_date)
	{
		if($company_id!='')
			$this->db->where('dac.company_id',$company_id);
		if($from_date!='' && $to_date!='')
			$this->db->where(['date(dac.c_date)>='=>$from_date,'date(dac.c_date)<='=>$to_date]);
		return $this->db->select("dac.id,dac.company_id,dac.device_name,dac.imei_no,dac.serial_no,dac.c_date as datetime,cs.company_name")
		->from('tbl_device_allotment_to_company dac')
		->join('tbl_company_setup cs','dac.company_id=cs.id','left')
		->where(['dac.status'=>1])->get()->result_array();
	}

	public function DeviceReceiving_To_CompanyReport($company_id,$from_date,$to_date)
	{
		if($company_id!='')
			$this->db->where('dac.company_id',$company_id);
		if($from_date!='' && $to_date!='')
			$this->db->where(['date(dac.c_date)>='=>$from_date,'date(dac.c_date)<='=>$to_date]);
		return $this->db->select("dac.id,dac.company_id,dac.device_name,dac.imei_no,dac.serial_no,dac.c_date as datetime,cs.company_name")
		->from('tbl_device_allotment_to_company dac')
		->join('tbl_company_setup cs','dac.company_id=cs.id','left')
		->where(['dac.status'=>1])->get()->result_array();
	}

	public function DeviceAllotment_To_InstallerReport($company_id,$user_id,$from_date,$to_date)
	{
		if($company_id!='')
			$this->db->where('dai.company_id',$company_id);
		if($user_id!='')
			$this->db->where('dai.user_id',$user_id);
		if($from_date!='' && $to_date!='')
			$this->db->where(['date(dai.c_date)>='=>$from_date,'date(dai.c_date)<='=>$to_date]);
		return $this->db->select("dai.id,dai.company_id,dai.user_id,dai.device_name,dai.imei_no,dai.allotment_date_time,cs.company_name,mm.user_full_name")
		->from('tbl_device_allotment_to_installer dai')
		->join('tbl_company_setup cs','dai.company_id=cs.id','left')
		->join('tbl_ongc_member_master mm','dai.user_id=mm.id','left')
		->where(['dai.status'=>1])->get()->result_array();
	}

	public function Site_Allotment_to_user_Report($company_id,$area_id,$site_id,$user_id,$from_date,$to_date)
	{
		if($company_id!='')
			$this->db->where('swa.company_id',$company_id);
		if($area_id!='')
			$this->db->where('sm.area_id',$area_id);
		if($site_id!='')
			$this->db->where('swa.site_id',$site_id);
		if($user_id!='')
			$this->db->where('swa.user_id',$user_id);
		if($from_date!='' && $to_date!='')
			$this->db->where(['date(swa.allotment_datetime)>='=>$from_date,'date(swa.allotment_datetime)<='=>$to_date]);
		return $this->db->select("swa.id,swa.company_id,cs.company_name,swa.role_type,swa.user_id,mm.user_full_name,swa.assets_id,a.assets_name,swa.area_id,am.area_name,swa.site_id,sm.well_site_name,swa.well_id,w.well_name,swa.allotment_datetime")
		->from('tbl_role_wise_user_assign_details swa')
		->join('tbl_company_setup cs','swa.company_id=cs.id','left')
		->join('tbl_ongc_member_master mm','swa.user_id=mm.id','left')
		->join('tbl_assets_master a','swa.assets_id=a.id','left')
		->join('tbl_area_master am','swa.area_id=am.id','left')
		->join('tbl_well_site_master sm','swa.site_id=sm.id','left')
		->join('tbl_well_master w','swa.well_id=w.id','left')
		->where(['swa.status'=>1])->order_by('swa.id')->get()->result_array();
	}

	public function Equipment_Details_Report($id,$company_id,$from_date,$to_date)
	{
		if($id!='')
			$this->db->where('ed.id',$id);
		if($company_id!='')
			$this->db->where('ed.company_id',$company_id);
		if($from_date!='' && $to_date!='')
			$this->db->where(['date(ed.c_date)>='=>$from_date,'date(ed.c_date)<='=>$to_date]);
		
		return $this->db->select("ed.*,cs.company_name,em.equipment_name,wm.well_name")
		->from('tbl_equipment_details ed')
		->join('tbl_equipment_master em','ed.eqp_id=em.id','left')
		->join('tbl_company_setup cs','ed.company_id=cs.id','left')
		->join('tbl_well_master wm','ed.well_id=wm.id','left')
		->where(['ed.status'=>1])->get()->result_array();
	}

	public function Equipment_Log_Report($equipment_detail_id)
	{
		if($equipment_detail_id!='')
			$this->db->where('equipment_detail_id',$equipment_detail_id);
		
		return $this->db->select("*")
		->from('tbl_equipment_details_log')
		->where(['status'=>1])->get()->result_array();
	}

	public function Installed_Device_Report($company_id,$user_id,$assets_id,$area_id,$site_id,$well_id,$from_date,$to_date)
	{
		$base_url = base_url().'album/';
		if($company_id!='')
			$this->db->where('di.company_id',$company_id);
		if($user_id!='')
			$this->db->where('di.installed_by',$user_id);
		if($assets_id!='')
			$this->db->where('di.assets_id',$assets_id);
		if($area_id!='')
			$this->db->where('di.area_id',$area_id);
		if($site_id!='')
			$this->db->where('di.site_id',$site_id);
		if($well_id!='')
			$this->db->where('di.well_id',$well_id);
		if($from_date!='' && $to_date!='')
			$this->db->where(['date(di.date_of_installation)>='=>$from_date,'date(di.date_of_installation)<='=>$to_date]);

		return $this->db->select("di.id,di.company_id,cs.company_name,di.installed_by,mm.user_full_name,di.assets_id,as.assets_name,di.area_id,am.area_name,di.site_id,sm.well_site_name,di.well_id,wm.well_name,di.device_name,di.imei_no,dac.serial_no,di.sim_no,di.sim_provider,di.network_type,di.date_of_installation,di.lat,di.long,CONCAT('$base_url',di.image) as icon")
		->from('tbl_site_device_installation di')
		->join('tbl_company_setup cs','di.company_id=cs.id','left')
		->join('tbl_ongc_member_master mm','di.installed_by=mm.id','left')
		->join('tbl_assets_master as','di.assets_id=as.id','left')
		->join('tbl_area_master am','di.area_id=am.id','left')
		->join('tbl_well_site_master sm','di.site_id=sm.id','left')
		->join('tbl_well_master wm','di.well_id=wm.id','left')
		->join('tbl_device_allotment_to_company dac','di.imei_no=dac.imei_no','left')
		->where(['di.status'=>1,'di.device_shifted'=>0])->group_by('di.well_id')->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")->get()->result_array();
	}

	public function Mis_Report($imei_no)
	{
		
		if($imei_no!='')
			$this->db->where('dl.imei_no',$imei_no);

		return $this->db->select("dl.*,ds.device_name")
		->from('tbl_device_log dl')
		->join('tbl_device_setup ds','dl.imei_no=ds.imei_no','left')
		->where(['dl.status'=>1])->order_by('dl.id','desc')->get()->result_array();
	}

	public function DeviceReplacement_Report($company_id,$user_id,$assets_id,$area_id,$site_id,$from_date,$to_date)
	{
		$base_url = base_url().'album/Replacement/';
		if($company_id!='')
			$this->db->where('dr.company_id',$company_id);
		if($user_id!='')
			$this->db->where('dr.replaced_by',$user_id);
		if($assets_id!='')
			$this->db->where('dr.asset_id',$assets_id);
		if($area_id!='')
			$this->db->where('dr.area_id',$area_id);
		if($site_id!='')
			$this->db->where('dr.site_id',$site_id);
		if($from_date!='' && $to_date!='')
			$this->db->where(['date(dr.replacement_datetime)>='=>$from_date,'date(dr.replacement_datetime)<='=>$to_date]);

		return $this->db->select("dr.id,dr.company_id,cs.company_name,dr.replaced_by,mm.user_full_name,dr.asset_id,as.assets_name,dr.area_id,am.area_name,dr.site_id,sm.well_site_name,dr.well_id,wm.well_name,dr.old_device_name,dr.old_imei_no,dr.reason_for_replacement,dr.new_device_name,dr.new_imei_no,dr.old_sim_provider,dr.old_sim_no,dr.new_sim_no,dr.old_network,dr.new_sim_provider,dr.new_network,dr.replacement_datetime,dr.lat,dr.long,CONCAT('$base_url',dr.image) as icon")
		->from('tbl_device_replecement_details dr')
		->join('tbl_company_setup cs','dr.company_id=cs.id','left')
		->join('tbl_ongc_member_master mm','dr.replaced_by=mm.id','left')
		->join('tbl_assets_master as','dr.asset_id=as.id','left')
		->join('tbl_area_master am','dr.area_id=am.id','left')
		->join('tbl_well_site_master sm','dr.site_id=sm.id','left')
		->join('tbl_well_master wm','dr.well_id=wm.id','left')
		->where(['dr.status'=>1])->order_by('dr.replacement_datetime','desc')->get()->result_array();
	}

	public function DeviceLog_daily_Report($company_id,$start_date,$end_date)
	{
		if($company_id!='')
			$this->db->where('dac.company_id',$company_id);
		$this->db->where('start_datetime >=', $start_date . ' 00:00:00');
	    $this->db->where('end_datetime <=', $end_date . ' 	23:59:59');

		return $this->db->select("rh.id,rh.device_name,rh.imei_no,rh.start_datetime,rh.end_datetime,dac.company_id,cs.company_name")
		->from('tbl_device_running_log_daily rh')
		->join('tbl_device_allotment_to_company dac','rh.imei_no=dac.imei_no','left')
		->join('tbl_company_setup cs','dac.company_id=cs.id','left')
		->where('rh.status',1)->get()->result_array();
	   
	}

	public function DeviceLog_hourly_Report($company_id)
	{
	    $s_time = date('Y-m-d H', time() - 60 * 60 * 1); 
		

		if($company_id!='')
			$this->db->where('dac.company_id',$company_id);
		$this->db->where('start_datetime >=', $s_time);
	    $this->db->where('end_datetime <=', date('Y-m-d H:i:s'));

		return $this->db->select("rh.id,rh.device_name,rh.imei_no,rh.start_datetime,rh.end_datetime,dac.company_id,cs.company_name")
		->from('tbl_device_running_log_hourly rh')
		->join('tbl_device_allotment_to_company dac','rh.imei_no=dac.imei_no','left')
		->join('tbl_company_setup cs','dac.company_id=cs.id','left')
		->where('rh.status',1)->get()->result_array();
	   
	}

	public function Trip_Report($well_id,$from_date,$to_date)
	{
	    
		if ($well_id != '') {
	        $this->db->where('sd.well_id', $well_id);
	    }

	    if ($from_date != '' && $to_date != '') {

	        $fromTime = date('Y-m-d 06:00:00', strtotime($from_date));
	        $toTime = date('Y-m-d 06:00:00', strtotime($to_date));
	        $this->db->where('tl.c_date >=', $fromTime);
	        $this->db->where('tl.c_date <', $toTime);
	    }

		return $this->db->select("sd.id,sd.device_name,sd.imei_no,sd.well_id,w.well_name,tl.trip_status,tl.trip_name,f.color_code,tl.c_date")
		->from('tbl_site_device_installation sd')
		->join('tbl_well_master w','sd.well_id=w.id','left')
		->join('tbl_trip_log tl','sd.imei_no=tl.imei_no','left')
		->join('tbl_fault_master f','tl.trip_status=f.fault_number','left')
		->where(['sd.status'=>1,'tl.status'=>1])->get()->result_array();
	   
	}

	public function Access_Report($from_date,$to_date)
	{
		if($from_date!='' && $to_date!='')
			$this->db->where(['date(al.access_date_time)>='=>$from_date,'date(al.access_date_time)<='=>$to_date]);

		return $this->db->select("al.id,al.user_id,cs.company_name,mm.user_full_name,al.module_name,al.access_date_time")
		->from('tbl_access_log al')
		->join('tbl_authentication_master am','al.user_id=am.id','left')
		->join('tbl_company_setup cs','am.company_id=cs.id','left')
		->join('tbl_ongc_member_master mm','am.user_member_id=mm.id','left')
		->where('al.status',1)->get()->result_array();
	   
	}

   public function well_runningEnergy_logreport($site_id, $well_id, $from_date, $to_date, $sort_by,$feeder_id)
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
        ->where(['sd.device_shifted'=>0])
        ->group_by('sd.well_id')->get()->result_array();

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
            ->where('sd.date_of_installation <=', $to_date)
            ->where(['sd.status'=> 1,'sd.device_shifted'=>0])
            ->get()
            ->result_array();
         // print_r($all_wells);die;

        $result_well_ids = array_column($result, 'well_id');
        foreach ($all_wells as $well) {
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

		$last_schedule = $this->db->select('COALESCE(running_minutes,1440) AS schdule_minute, well_id, COALESCE(well_type,0) AS well_type')
             ->from('v_running_schdule_minutes')
             ->where('well_id', $row['well_id'])
             ->where('apply_datetime <=', date('Y-m-d 06:00:00', strtotime($to_date . '+1 day')))  
             ->where('COALESCE(valid_datetime, NOW()) >=', date('Y-m-d 05:59:59', strtotime($to_date . '+1 day')))  
             ->order_by('apply_datetime', 'desc') 
             ->limit(1)
             ->get()
             ->result_array();

            $row['schdule_minute'] = isset($last_schedule[0]['schdule_minute']) ? $last_schedule[0]['schdule_minute'] : 0;   
		    $row['running_minutes'] = $running_minutes;

	     if($well_type == 1)
	        {
	            if( $to_date == $current_date)
	            {

	            	$row['current_required'] = $row['schdule_minute'] - $row['total_running_required'];
                    $row['running_minutes'] = $row['running_minutes'] - $row['current_required'];
	                $row['shutdown_minutes'] = $row['running_minutes'] - $row['t_minute'];

	                if ($row['running_minutes']!= 0) {
	                    $row['availability'] = ($row['t_minute'] / $row['running_minutes']) * 100;
	                } else {
	                    $row['availability'] = 0; 
	                }
	            }else{
	                $row['running_minutes'] = $row['running_minutes'];
	                $row['shutdown_minutes'] = $row['running_minutes'] - $row['t_minute'];

	                if ($row['running_minutes']!= 0) {
	                    $row['availability'] = ($row['t_minute'] / $row['running_minutes']) * 100;
	                } else {
	                    $row['availability'] = 0; 
	                }
	            }
	        }else{
	            if($to_date == $current_date)
	            {
	                 $current_time_now = time(); 
	                 $current_time = strtotime(date('Y-m-d 06:00:00'));
	                 $current_time_minutes = ($current_time_now - $current_time) / 60;
	                 $current_required = $row['schdule_minute'] - $current_time_minutes;
	                 $row['shutdown_minutes'] = $row['running_minutes'] - $row['t_minute'];

	                 if ($row['running_minutes']!= 0) 
	                 {
	                     $row['availability'] = ($row['t_minute'] / $row['running_minutes']) * 100;
	                 } else {
	                      $row['availability'] = 0; 
	                 }

	            }else{

	                $row['running_minutes'] = $row['running_minutes'];
	                $row['shutdown_minutes'] = $row['running_minutes'] - $row['t_minute'];

	                 if ($row['running_minutes']!= 0) 
	                 {
	                     $row['availability'] = ($row['t_minute'] / $row['running_minutes']) * 100;
	                 } else {
	                      $row['availability'] = 0; 
	                 }
	            }
	            
	        }
		}

     return $result;
   }

    // public function well_runningEnergylog($site_id, $from_date, $to_date,$sort_by)
	// {
	//     if ($from_date != '' && $to_date != '') {
	//         $fromTime = date('Y-m-d 06:00:00', strtotime($from_date));
	//         $toTime = date('Y-m-d 06:00:00', strtotime($to_date . '+1 day'));
	//     }

	//     $datetime1 = new DateTime($from_date);
	//     $datetime2 = new DateTime($to_date);
	//     $interval = $datetime1->diff($datetime2);
	//     $dateDifference = $interval->days + 1;

	//     $current_date = date('Y-m-d'); 

	//     if ($site_id != '') {
	//         $sql = "SELECT ws.well_site_name,
	//                COUNT(sd.well_id) AS total_no_of_wells,
	//                SUM(CASE WHEN vw.well_type = 1 THEN 1 ELSE 0 END) AS total_no_of_type1_wells,
    //                SUM(CASE WHEN vw.well_type = 0 THEN 1 ELSE 0 END) AS total_no_of_type0_wells,
	//                SUM(COALESCE(CASE WHEN vw.well_type = 1 THEN vw.running_minutes ELSE 0 END, 0)) AS running_minutes_type1,
	//                SUM(COALESCE(CASE WHEN vw.well_type = 0 THEN vw.running_minutes ELSE 0 END, 0)) AS running_minutes_type0,
	//                SUM(COALESCE(CASE WHEN vw.well_type = 1 THEN wrl.running_log_minutes ELSE 0 END, 0)) AS t_minute_type1,
	//                SUM(COALESCE(CASE WHEN vw.well_type = 0 THEN wrl.running_log_minutes ELSE 0 END, 0)) AS t_minute_type0,
	//                SUM(COALESCE(vp.total_running_required, 0)) AS total_running_required,
	//                SUM(COALESCE(wrl.e_consumption, 0)) AS e_consumption
	//         FROM tbl_site_device_installation sd
	//         LEFT JOIN tbl_well_site_master ws ON ws.id = sd.site_id 
	//         LEFT JOIN v_well_running_config vw ON sd.well_id = vw.well_id 
	//         LEFT JOIN v_period_well_running_required vp ON vp.well_id = sd.well_id
	//         LEFT JOIN (
	//             SELECT wrl.well_id, 
	//                    SUM(wrl.total_running_minute) AS running_log_minutes, 
	//                    SUM(wrl.total_kwh) AS e_consumption 
	//             FROM tbl_well_running_log wrl
	//             JOIN v_well_running_config vw ON wrl.well_id = vw.well_id 
	//             WHERE wrl.start_datetime >= '{$fromTime}' AND wrl.end_datetime < '{$toTime}' 
	//             GROUP BY wrl.well_id, vw.well_type
	//         ) wrl ON sd.well_id = wrl.well_id
	//         WHERE sd.site_id = '{$site_id}' AND sd.status = 1 AND sd.device_shifted = 0
	//         GROUP BY ws.id";

	//         if ($sort_by != '') 
	//         {

    //             $valid_columns = ['total_no_of_wells', 'well_site_name',  'e_consumption'];
    //               if (in_array($sort_by, $valid_columns)) 
    //               {
    //                  $sql .= " ORDER BY $sort_by ASC";
    //               }
	//         }

	//         $query = $this->db->query($sql);
	//         $result = $query->result_array();

	//         print_r($result);die;

	//         foreach ($result as &$row) 
	//         {
	//         	if($to_date == $current_date)
	//     		{
	//         	    $current_time_now = time(); 
	//                 $current_time = strtotime(date('Y-m-d 06:00:00'));
    //                 $current_time_minutes = ($current_time_now - $current_time) / 60;
    //                 $current_date_running0 = (($row['running_minutes_type0']*($dateDifference -1)) +($current_time_minutes*$row['total_no_of_type0_wells']));
    //                 $current_date_running1 = (($row['running_minutes_type1']*($dateDifference -1)) +$row['total_running_required']);
    //                 $row['running_minutes'] = $current_date_running0 + $current_date_running1;
    //                 $row['t_minute'] = $row['t_minute_type1'] + $row['t_minute_type0'];
	// 	            $row['shutdown_minutes'] = $row['running_minutes'] - $row['t_minute'];
	// 	            $row['availablity'] = ($row['t_minute'] / $row['running_minutes'])*100;

	//            }else{
    //                 $row['running_minutes'] = ($row['running_minutes_type1'] + $row['running_minutes_type0'])*$dateDifference;
    //                 $row['t_minute'] = $row['t_minute_type1'] + $row['t_minute_type0'];
	// 	            $row['shutdown_minutes'] = $row['running_minutes'] - $row['t_minute'];
	// 	            $row['availablity'] = ($row['t_minute'] / $row['running_minutes'])*100;

	//            }
	//         }

	//         return $result;
	//     }else{
	//     	$sql = "SELECT ws.well_site_name,
	//                COUNT(sd.well_id) AS total_no_of_wells,
	//                SUM(CASE WHEN vw.well_type = 1 THEN 1 ELSE 0 END) AS total_no_of_type1_wells,
    //                SUM(CASE WHEN vw.well_type = 0 THEN 1 ELSE 0 END) AS total_no_of_type0_wells,
	//                SUM(COALESCE(CASE WHEN vw.well_type = 1 THEN vw.running_minutes ELSE 0 END, 0)) AS running_minutes_type1,
	//                SUM(COALESCE(CASE WHEN vw.well_type = 0 THEN vw.running_minutes ELSE 0 END, 0)) AS running_minutes_type0,
	//                SUM(COALESCE(CASE WHEN vw.well_type = 1 THEN wrl.running_log_minutes ELSE 0 END, 0)) AS t_minute_type1,
	//                SUM(COALESCE(CASE WHEN vw.well_type = 0 THEN wrl.running_log_minutes ELSE 0 END, 0)) AS t_minute_type0,
	//                SUM(COALESCE(vp.total_running_required, 0)) AS total_running_required,
	//                SUM(COALESCE(wrl.e_consumption, 0)) AS e_consumption
	//         FROM tbl_site_device_installation sd
	//         LEFT JOIN tbl_well_site_master ws ON ws.id = sd.site_id 
	//         LEFT JOIN v_well_running_config vw ON sd.well_id = vw.well_id
	//         LEFT JOIN v_period_well_running_required vp ON vp.well_id = sd.well_id
	//         LEFT JOIN (
	//             SELECT wrl.well_id, 
	//                    SUM(wrl.total_running_minute) AS running_log_minutes, 
	//                    SUM(wrl.total_kwh) AS e_consumption 
	//             FROM tbl_well_running_log wrl
	//             JOIN v_well_running_config vw ON wrl.well_id = vw.well_id 
	//             WHERE wrl.start_datetime >= '{$fromTime}' AND wrl.end_datetime < '{$toTime}' 
	//             GROUP BY wrl.well_id, vw.well_type
	//         ) wrl ON sd.well_id = wrl.well_id
	//          WHERE sd.status = 1 AND sd.device_shifted = 0
	//          GROUP BY ws.id";

	//         if ($sort_by != '') 
	//         {

    //             $valid_columns = ['total_no_of_wells', 'well_site_name',  'e_consumption'];
    //               if (in_array($sort_by, $valid_columns)) 
    //               {
    //                  $sql .= " ORDER BY $sort_by ASC";
    //               }
	//         }


	//         $query = $this->db->query($sql);
	//         $result = $query->result_array();

	//         foreach ($result as &$row) 
	//         {
	//         	if($to_date == $current_date)
	//     		{
	//         	    $current_time_now = time(); 
	//                 $current_time = strtotime(date('Y-m-d 06:00:00'));
    //                 $current_time_minutes = ($current_time_now - $current_time) / 60;
    //                 $current_date_running0 = (($row['running_minutes_type0']*($dateDifference -1)) +($current_time_minutes*$row['total_no_of_type0_wells']));
    //                 $row['current_time_datasweta'] = $current_date_running0;
    //                 $current_date_running1 = (($row['running_minutes_type1']*($dateDifference -1)) +$row['total_running_required']);
    //                 $row['running_minutes'] = $current_date_running0 + $current_date_running1;
    //                 $row['t_minute'] = $row['t_minute_type1'] + $row['t_minute_type0'];
	// 	            $row['shutdown_minutes'] = $row['running_minutes'] - $row['t_minute'];
	// 	            $row['availablity'] = ($row['t_minute'] / $row['running_minutes'])*100;

	//            }else{
    //                 $row['running_minutes'] = ($row['running_minutes_type1'] + $row['running_minutes_type0'])*$dateDifference;
    //                 $row['t_minute'] = $row['t_minute_type1'] + $row['t_minute_type0'];
	// 	            $row['shutdown_minutes'] = $row['running_minutes'] - $row['t_minute'];
	// 	            $row['availablity'] = ($row['t_minute'] / $row['running_minutes'])*100;

	//            }
	//         }

	//         return $result;

	//     }
	// }
     
    public function well_runningEnergylog($site_id, $from_date, $to_date, $sort_by)
	{
	    if ($from_date != '' && $to_date != '') {
	        $fromTime = date('Y-m-d 06:00:00', strtotime($from_date));
	        $toTime = date('Y-m-d 06:00:00', strtotime($to_date . '+1 day'));
	    }

	    $datetime1 = new DateTime($from_date);
	    $datetime2 = new DateTime($to_date);
	    $interval = $datetime1->diff($datetime2);
	    $dateDifference = $interval->days + 1;

	    $current_date = date('Y-m-d');

	    if ($site_id != '') {
		    $sql = "SELECT ws.well_site_name,ws.id AS site_id,
		           COUNT(DISTINCT sd.well_id) AS total_no_of_wells,
		           SUM(CASE WHEN vw.well_type = 1 THEN 1 ELSE 0 END) AS total_no_of_type1_wells,
		           SUM(CASE WHEN vw.well_type = 0 THEN 1 ELSE 0 END) AS total_no_of_type0_wells,
		           SUM(COALESCE(CASE WHEN vw.well_type = 1 THEN wrl.running_log_minutes ELSE 0 END, 0)) AS t_minute_type1,
		           SUM(COALESCE(CASE WHEN vw.well_type = 0 THEN wrl.running_log_minutes ELSE 0 END, 0)) AS t_minute_type0,
		           SUM(COALESCE(vp.total_running_required, 0)) AS total_running_required,
		           SUM(COALESCE(wrl.e_consumption, 0)) AS e_consumption
		    FROM tbl_site_device_installation sd
		    LEFT JOIN tbl_well_site_master ws ON ws.id = sd.site_id 
		    LEFT JOIN v_asset_running_schdule_minutes vw ON sd.well_id = vw.well_id AND vw.apply_datetime <= '{$toTime}' AND COALESCE(vw.valid_datetime, NOW()) >= '{$fromTime}'

		    LEFT JOIN v_period_well_running_required vp ON vp.well_id = sd.well_id
		    LEFT JOIN (
		        SELECT wrl.well_id, 
		               SUM(wrl.total_running_minute) AS running_log_minutes, 
		               SUM(wrl.total_kwh) AS e_consumption 
		        FROM tbl_well_running_log wrl
		        JOIN v_asset_running_schdule_minutes vw ON wrl.well_id = vw.well_id AND vw.apply_datetime <= wrl.start_datetime AND COALESCE(vw.valid_datetime, NOW()) >= wrl.end_datetime
		        WHERE wrl.start_datetime >= '{$fromTime}' AND wrl.end_datetime < '{$toTime}' 
		        GROUP BY vw.well_id, vw.well_type
		    ) wrl ON sd.well_id = wrl.well_id
		    WHERE sd.site_id = '{$site_id}' AND sd.status = 1 AND sd.device_shifted = 0
		    GROUP BY ws.id";

		    if ($sort_by != '') {
		        $valid_columns = ['total_no_of_wells', 'well_site_name', 'e_consumption'];
		        if (in_array($sort_by, $valid_columns)) {
		            $sql .= " ORDER BY $sort_by ASC";
		        }
		    }

		    $query = $this->db->query($sql);
		    $result = $query->result_array();

		    // print_r($result);die;

		    foreach ($result as &$row) {
		        
		         $total_running_minutes_well_type_0 = 0;
                 $total_running_minutes_well_type_1 = 0;
                 $running_minutes_type1 =0;
                 $running_minutes_type0 =0;

		        for ($date = $from_date; $date <= $to_date; $date = date('Y-m-d', strtotime($date . ' +1 day'))) {
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
		        $row['running_minutes_type0'] = $total_running_minutes_well_type_0;
		        $row['running_minutes_type1'] = $total_running_minutes_well_type_1;
		         // print_r($running_schedule_query);die;

		        $one_day_running_required0 = $row['running_minutes_type0']/$dateDifference;
		        $one_day_running_required1 = $row['running_minutes_type1']/$dateDifference;
		       
		        if ($to_date == $current_date) 
		        {
		            $current_time_now = time();
		            $current_time = strtotime(date('Y-m-d 06:00:00'));
		            $current_time_minutes = ($current_time_now - $current_time) / 60;
                    $row['current_date_running0'] =  ($current_time_minutes * $row['total_no_of_type0_wells']);
                    $row['current_date_running1'] = $row['total_running_required'];
                    $total_runningtype0 =  $one_day_running_required0 - $row['current_date_running0'];
		            $total_runningtype1 = $one_day_running_required1 - $row['current_date_running1'];
		            $running_minute0 = $row['running_minutes_type0'] - $total_runningtype0;
		            $running_minutes1 = $row['running_minutes_type1'] - $total_runningtype1;
		            $row['running_minutes'] = $running_minute0 + $running_minutes1;
		            $row['t_minute'] = $row['t_minute_type1'] + $row['t_minute_type0'];
		            $row['shutdown_minutes'] = $row['running_minutes'] - $row['t_minute'];

		             if ($row['running_minutes']!= 0) 
	                 {
	                      $row['availablity'] = ($row['t_minute'] / $row['running_minutes']) * 100;
	                 } else {
	                      $row['availablity'] = 0; 
	                 }
		           
		        } else {
		            $row['running_minutes'] = ($row['running_minutes_type1'] + $row['running_minutes_type0']);
		            $row['t_minute'] = $row['t_minute_type1'] + $row['t_minute_type0'];
		            $row['shutdown_minutes'] = $row['running_minutes'] - $row['t_minute'];
		             if ($row['running_minutes']!= 0) 
	                 {
	                      $row['availablity'] = ($row['t_minute'] / $row['running_minutes']) * 100;
	                 } else {
	                      $row['availablity'] = 0; 
	                 }
		        }
		    }

		    return $result;
		}else{
			   $sql = "SELECT ws.well_site_name,ws.id AS site_id,
		           COUNT(DISTINCT sd.well_id) AS total_no_of_wells,
		           SUM(CASE WHEN vw.well_type = 1 THEN 1 ELSE 0 END) AS total_no_of_type1_wells,
		           SUM(CASE WHEN vw.well_type = 0 THEN 1 ELSE 0 END) AS total_no_of_type0_wells,
		           SUM(COALESCE(CASE WHEN vw.well_type = 1 THEN wrl.running_log_minutes ELSE 0 END, 0)) AS t_minute_type1,
		           SUM(COALESCE(CASE WHEN vw.well_type = 0 THEN wrl.running_log_minutes ELSE 0 END, 0)) AS t_minute_type0,
		           SUM(COALESCE(vp.total_running_required, 0)) AS total_running_required,
		           SUM(COALESCE(wrl.e_consumption, 0)) AS e_consumption
	        FROM tbl_site_device_installation sd
		    LEFT JOIN tbl_well_site_master ws ON ws.id = sd.site_id 
		    LEFT JOIN v_asset_running_schdule_minutes vw ON sd.well_id = vw.well_id AND vw.apply_datetime <= '{$toTime}' AND COALESCE(vw.valid_datetime, NOW()) >= '{$fromTime}'

		    LEFT JOIN v_period_well_running_required vp ON vp.well_id = sd.well_id
		    LEFT JOIN (
		        SELECT wrl.well_id, 
		               SUM(wrl.total_running_minute) AS running_log_minutes, 
		               SUM(wrl.total_kwh) AS e_consumption 
		        FROM tbl_well_running_log wrl
		        JOIN v_asset_running_schdule_minutes vw ON wrl.well_id = vw.well_id AND vw.apply_datetime <= wrl.start_datetime AND COALESCE(vw.valid_datetime, NOW()) >= wrl.end_datetime
		        WHERE wrl.start_datetime >= '{$fromTime}' AND wrl.end_datetime < '{$toTime}' 
		        GROUP BY vw.well_id, vw.well_type
		    ) wrl ON sd.well_id = wrl.well_id
	         WHERE sd.status = 1 AND sd.device_shifted = 0
	         GROUP BY ws.id";

	        if ($sort_by != '') 
	        {

                $valid_columns = ['total_no_of_wells', 'well_site_name',  'e_consumption'];
                  if (in_array($sort_by, $valid_columns)) 
                  {
                     $sql .= " ORDER BY $sort_by ASC";
                  }
	        }


	        $query = $this->db->query($sql);
	        $result = $query->result_array();

	        foreach ($result as &$row) {
		        
		         $total_running_minutes_well_type_0 = 0;
                 $total_running_minutes_well_type_1 = 0;
                 $running_minutes_type1 =0;
                 $running_minutes_type0 =0;

		        for ($date = $from_date; $date <= $to_date; $date = date('Y-m-d', strtotime($date . ' +1 day'))) {
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
		        $row['running_minutes_type0'] = $total_running_minutes_well_type_0;
		        $row['running_minutes_type1'] = $total_running_minutes_well_type_1;

		        $one_day_running_required0 = $row['running_minutes_type0']/$dateDifference;
		        $one_day_running_required1 = $row['running_minutes_type1']/$dateDifference;
		       
		        if ($to_date == $current_date) 
		        {
		            $current_time_now = time();
		            $current_time = strtotime(date('Y-m-d 06:00:00'));
		            $current_time_minutes = ($current_time_now - $current_time) / 60;
                    $row['current_date_running0'] =  ($current_time_minutes * $row['total_no_of_type0_wells']);
                    $row['current_date_running1'] = $row['total_running_required'];
                    $total_runningtype0 =  $one_day_running_required0 - $row['current_date_running0'];
		            $total_runningtype1 = $one_day_running_required1 - $row['current_date_running1'];
		            $running_minute0 = $row['running_minutes_type0'] - $total_runningtype0;
		            $running_minutes1 = $row['running_minutes_type1'] - $total_runningtype1;
		            $row['running_minutes'] = $running_minute0 + $running_minutes1;
		            $row['t_minute'] = $row['t_minute_type1'] + $row['t_minute_type0'];
		            $row['shutdown_minutes'] = $row['running_minutes'] - $row['t_minute'];

		             if ($row['running_minutes']!= 0) 
	                 {
	                      $row['availablity'] = ($row['t_minute'] / $row['running_minutes']) * 100;
	                 } else {
	                      $row['availablity'] = 0; 
	                 }
		           
		        } else {
		            $row['running_minutes'] = ($row['running_minutes_type1'] + $row['running_minutes_type0']);
		            $row['t_minute'] = $row['t_minute_type1'] + $row['t_minute_type0'];
		            $row['shutdown_minutes'] = $row['running_minutes'] - $row['t_minute'];
		             if ($row['running_minutes']!= 0) 
	                 {
	                      $row['availablity'] = ($row['t_minute'] / $row['running_minutes']) * 100;
	                 } else {
	                      $row['availablity'] = 0; 
	                 }
		        }
		    }

		     return $result;

		}

	}

	// public function Asset_Areawise_monthly_WellDetails_model($assets_id, $area_id, $month)
	// {
	//     $applyFilters = function ($query) use ($assets_id, $area_id) {
	//         if (!empty($assets_id)) {
	//             $query->where('sd.assets_id', $assets_id);
	//         }

	//         if (!empty($area_id)) {
	//             $query->where('sd.area_id', $area_id);
	//         }
	//     };

	//     $res = [];

	//     $existWellCount = $this->db->select("IFNULL(count(sd.well_id), 0) as totalwell")
	//         ->from('tbl_site_device_installation sd')
	//         ->where(['sd.status'=>1, 'sd.device_shifted'=>0]);
	//         // ->where('MONTH(sd.date_of_installation)<=', $month);

	//     $applyFilters($existWellCount);
	//     $totalWellResult = $existWellCount->get()->row();
	//     $res['exist_Well']['existtotalwell'] = $totalWellResult->totalwell;

	//     $existWellQuery = $this->db->select("
	// 	    sd.well_id,
	// 	    wm.well_name,
	// 	    DATE_FORMAT(sd.date_of_installation, '%d-%m-%Y') as installation_date,
	// 	    CASE
	// 		    WHEN sd.date_of_installation >= '2024-03-21 06:00:00' THEN
	// 		        CASE
	// 		            WHEN DATE_FORMAT(DATE_ADD(sd.date_of_installation, INTERVAL 1 DAY), '%H:%i:%s') >= '06:00:00' THEN DATE_FORMAT(DATE_ADD(sd.date_of_installation, INTERVAL 1 DAY), '%d-%m-%Y')
	// 		            ELSE DATE_FORMAT(sd.date_of_installation, '%d-%m-%Y')
	// 		        END
	// 		    WHEN sd.date_of_installation < '2024-03-21 06:00:00' THEN DATE_FORMAT('2024-03-21', '%d-%m-%Y')
	// 		    ELSE ''
	// 		END AS commissioning_date")


	// 	->from('tbl_site_device_installation sd')
	// 	->join('tbl_well_master wm', 'sd.well_id=wm.id and wm.status=1', 'left')
	// 	->where(['sd.status'=>1, 'sd.device_shifted'=>0]);
	// 	// ->where('MONTH(sd.date_of_installation)<=', $month);

	// 	$applyFilters($existWellQuery);
	// 	$res['exist_Well']['existwellDetails'] = $existWellQuery->get()->result_array();

	//     // ========================================================================

	//     $newWellCount = $this->db->select("IFNULL(count(sd.well_id), 0) as totalwell")
	//         ->from('tbl_site_device_installation sd')
	//         ->where(['sd.status'=>1, 'sd.device_shifted'=>0])
	//         ->where('MONTH(sd.date_of_installation)', $month)
	//         ->where('sd.date_of_installation >=', '2024-03-21 06:00:00');

	//     $applyFilters($newWellCount);
	//     $totalWellResult = $newWellCount->get()->row();
	//     // print_r($totalWellResult);die;
	//     $res['new_Well']['newtotalwell'] = $totalWellResult->totalwell;

	//     $newWellQuery = $this->db->select("sd.well_id, wm.well_name, DATE_FORMAT(sd.date_of_installation, '%d-%m-%Y') as installation_date,CASE
	// 		    WHEN sd.date_of_installation >= '2024-03-21 06:00:00' THEN
	// 		        CASE
	// 		            WHEN DATE_FORMAT(DATE_ADD(sd.date_of_installation, INTERVAL 1 DAY), '%H:%i:%s') >= '06:00:00' THEN DATE_FORMAT(DATE_ADD(sd.date_of_installation, INTERVAL 1 DAY), '%d-%m-%Y')
	// 		            ELSE DATE_FORMAT(sd.date_of_installation, '%d-%m-%Y')
	// 		        END
	// 		    WHEN sd.date_of_installation < '2024-03-21 06:00:00' THEN DATE_FORMAT('2024-03-21', '%d-%m-%Y')
	// 		    ELSE ''
	// 		END AS commissioning_date")
	//         ->from('tbl_site_device_installation sd')
	//         ->join('tbl_well_master wm', 'sd.well_id=wm.id and wm.status=1', 'left')
	//         ->where(['sd.status'=>1, 'sd.device_shifted'=>0])
	//         ->where('MONTH(sd.date_of_installation)', $month)
	//         ->where('sd.date_of_installation >=', '2024-03-21 06:00:00');

	//     $applyFilters($newWellQuery);
	//     $res['new_Well']['newwellDetails'] = $newWellQuery->get()->result_array();
	//     // print_r($res['new_Well']['newwellDetails']);die;

	//     // =============================================================

	//     // $shiftWellCount = $this->db->select("IFNULL(count(sd.well_id), 0) as totalwell")
	//     //     ->from('tbl_site_device_installation sd')
	//     //     ->where(['sd.status'=>1, 'sd.device_shifted'=>1])
	//     //     ->where('MONTH(sd.date_of_shifted)', $month);

	//     // $applyFilters($shiftWellCount);
	//     // $totalWellResult = $shiftWellCount->get()->row();
	//     // $res['shift_Well']['totalshiftwell'] = $totalWellResult->totalwell;

	//     // $shiftWellQuery = $this->db->select("sd.well_id, wm.well_name, DATE_FORMAT(sd.date_of_shifted, '%d-%m-%Y') as shifted_date,CASE
	// 	// 	    WHEN sd.date_of_installation >= '2024-03-21 06:00:00' THEN
	// 	// 	        CASE
	// 	// 	            WHEN DATE_FORMAT(DATE_ADD(sd.date_of_installation, INTERVAL 1 DAY), '%H:%i:%s') >= '06:00:00' THEN DATE_FORMAT(DATE_ADD(sd.date_of_installation, INTERVAL 1 DAY), '%d-%m-%Y')
	// 	// 	            ELSE DATE_FORMAT(sd.date_of_installation, '%d-%m-%Y')
	// 	// 	        END
	// 	// 	    WHEN sd.date_of_installation < '2024-03-21 06:00:00' THEN DATE_FORMAT('2024-03-21', '%d-%m-%Y')
	// 	// 	    ELSE ''
	// 	// 	END AS commissioning_date")
	//     //     ->from('tbl_site_device_installation sd')
	//     //     ->join('tbl_well_master wm', 'sd.well_id=wm.id and wm.status=1', 'left')
	//     //     ->where(['sd.status'=>1, 'sd.device_shifted'=>1])
	//     //     ->where('MONTH(sd.date_of_shifted)', $month);

	//     // $applyFilters($shiftWellQuery);
	//     // $res['shift_Well']['shiftwellDetails'] = $shiftWellQuery->get()->result_array();

	//     $shiftWellCount = $this->db->select("IFNULL(count(sdd.shifted_well_id), 0) as totalwell")
	//         ->from('tbl_well_shifted_device_details sdd')
	//         ->join('tbl_site_device_installation sd','sd.well_id=sdd.shifted_well_id and sdd.status = 1','left')
	//         ->where(['sd.status'=>1])
	//         ->where('MONTH(sdd.shifted_well_installation_date)', $month);
	//         // ->where('sdd.shifted_well_installation_date >=', '2024-03-21 06:00:00');

	//     $applyFilters($shiftWellCount);
	//     $totalWellResult = $shiftWellCount->get()->row();
	//     $res['shift_Well']['totalshiftwell'] = $totalWellResult->totalwell;

	//     $shiftWellQuery = $this->db->select("sdd.shifted_well_id, wm.well_name, DATE_FORMAT(sdd.shifted_well_installation_date, '%d-%m-%Y') as shifted_date,CASE
	// 		    WHEN sdd.shifted_well_installation_date >= '2024-03-21 06:00:00' THEN
	// 		        CASE
	// 		            WHEN DATE_FORMAT(DATE_ADD(sdd.shifted_well_installation_date, INTERVAL 1 DAY), '%H:%i:%s') >= '06:00:00' THEN DATE_FORMAT(DATE_ADD(sdd.shifted_well_installation_date, INTERVAL 1 DAY), '%d-%m-%Y')
	// 		            ELSE DATE_FORMAT(sdd.shifted_well_installation_date, '%d-%m-%Y')
	// 		        END
	// 		    WHEN sdd.shifted_well_installation_date < '2024-03-21 06:00:00' THEN DATE_FORMAT('2024-03-21', '%d-%m-%Y')
	// 		    ELSE ''
	// 		END AS commissioning_date")
	//         ->from('tbl_well_shifted_device_details sdd')
	//         ->join('tbl_site_device_installation sd','sd.well_id=sdd.shifted_well_id and sdd.status = 1','left')
	//         ->join('tbl_well_master wm', 'sdd.shifted_well_id=wm.id and wm.status=1', 'left')
	//         ->where('MONTH(sdd.shifted_well_installation_date)', $month);
	//         // ->where('sdd.shifted_well_installation_date >=', '2024-03-21 06:00:00');

	//     $applyFilters($shiftWellQuery);
	//     $res['shift_Well']['shiftwellDetails'] = $shiftWellQuery->get()->result_array();
	//     // print_r($res['shift_Well']['shiftwellDetails']);die;

	//     // =========================================================

	//     $removeWellCount = $this->db->select("IFNULL(count(sd.well_id), 0) as totalwell")
	//         ->from('tbl_site_device_installation sd')
	//         ->where(['sd.status'=>0])
	//         ->where('MONTH(sd.ddate)', $month);

	//     $applyFilters($shiftWellCount);
	//     $totalWellResult = $shiftWellCount->get()->row();
	//     $res['remove_Well']['totalremovewell'] = $totalWellResult->totalwell;

	//     $removeWellQuery = $this->db->select("sd.well_id, wm.well_name, DATE_FORMAT(sd.ddate, '%d-%m-%Y') as remove_date,CASE
	// 		    WHEN sd.date_of_installation >= '2024-03-21 06:00:00' THEN
	// 		        CASE
	// 		            WHEN DATE_FORMAT(DATE_ADD(sd.date_of_installation, INTERVAL 1 DAY), '%H:%i:%s') >= '06:00:00' THEN DATE_FORMAT(DATE_ADD(sd.date_of_installation, INTERVAL 1 DAY), '%d-%m-%Y')
	// 		            ELSE DATE_FORMAT(sd.date_of_installation, '%d-%m-%Y')
	// 		        END
	// 		    WHEN sd.date_of_installation < '2024-03-21 06:00:00' THEN DATE_FORMAT('2024-03-21', '%d-%m-%Y')
	// 		    ELSE ''
	// 		END AS commissioning_date")
	//         ->from('tbl_site_device_installation sd')
	//         ->join('tbl_well_master wm', 'sd.well_id=wm.id and wm.status=1', 'left')
	//         ->where(['sd.status'=>0])
	//         ->where('MONTH(sd.ddate)', $month);

	//     $applyFilters($removeWellQuery);
	//     $res['remove_Well']['removewellDetails'] = $removeWellQuery->get()->result_array();

	//     return $res;
	// }

	public function Asset_Areawise_monthly_WellDetails_model($site_id,$month,$year)
	{
	    $applyFilters = function ($query) use ($site_id) {
	        if (!empty($site_id)) 
	        {
	            $query->where('sd.site_id', $site_id);
	        }

	    };

	    $res = [];

	    $endDate = date("Y-m-t", strtotime("$year-$month-01"));
	    $existWellCount = $this->db->select("SUM(CASE 
                                        WHEN sd.status = 1 AND date(sd.cdate) <= '$endDate' AND sd.device_shifted = 0 THEN 1
                                        WHEN sd.status = 1 AND Month(sd.date_of_shifted) > '$month' AND sd.device_shifted = 1 THEN 1
                                        ELSE 0
                                      END) as totalwell")
                           ->from('tbl_site_device_installation sd');
        $applyFilters($existWellCount);
        $totalWellResult = $existWellCount->get()->row();
        $res['exist_Well']['existtotalwell'] = intval($totalWellResult->totalwell);

       

	    $existWellQuery = $this->db->select("
		    sd.well_id,
		    wm.well_name,
		    DATE_FORMAT(sd.cdate, '%d-%m-%Y') as installation_date,
		    CASE
			    WHEN sd.cdate >= '2024-03-21 06:00:00' THEN
			        CASE
			            WHEN DATE_FORMAT(DATE_ADD(sd.cdate, INTERVAL 1 DAY), '%H:%i:%s') >= '06:00:00' THEN DATE_FORMAT(DATE_ADD(sd.cdate, INTERVAL 1 DAY), '%d-%m-%Y')
			            ELSE DATE_FORMAT(sd.cdate, '%d-%m-%Y')
			        END
			    WHEN sd.cdate < '2024-03-21 06:00:00' THEN DATE_FORMAT('2024-03-21', '%d-%m-%Y')
			    ELSE ''
			END AS commissioning_date")


		->from('tbl_site_device_installation sd')
		->join('tbl_well_master wm', 'sd.well_id=wm.id and wm.status=1', 'left')
		->where('sd.status', 1)
        ->where('date(sd.cdate) <=', $endDate)
        ->group_start() 
        ->where('sd.device_shifted', 0)
        ->or_group_start()
            ->where('sd.status', 1)
            ->where('MONTH(sd.date_of_shifted) >', $month)
            ->where('sd.device_shifted', 1)
        ->group_end() 
        ->group_end() 
        ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC");

		$applyFilters($existWellQuery);
		$res['exist_Well']['existwellDetails'] = $existWellQuery->get()->result_array();

	    // ========================================================================

	    $newWellCount = $this->db->select("IFNULL(count(sd.well_id), 0) as totalwell")
	        ->from('tbl_site_device_installation sd')
	        ->where(['sd.status'=>1, 'sd.device_shifted'=>0])
	        ->where('MONTH(sd.cdate)', $month)
	        ->where('YEAR(sd.cdate)', $year)
	        ->where('sd.cdate >=', '2024-03-21 06:00:00');

	    $applyFilters($newWellCount);
	    $totalWellResult = $newWellCount->get()->row();
	    // print_r($totalWellResult);die;
	    $res['new_Well']['newtotalwell'] = $totalWellResult->totalwell;

	    $newWellQuery = $this->db->select("sd.well_id, wm.well_name, DATE_FORMAT(sd.cdate, '%d-%m-%Y') as installation_date,CASE
			    WHEN sd.cdate >= '2024-03-21 06:00:00' THEN
			        CASE
			            WHEN DATE_FORMAT(DATE_ADD(sd.cdate, INTERVAL 1 DAY), '%H:%i:%s') >= '06:00:00' THEN DATE_FORMAT(DATE_ADD(sd.cdate, INTERVAL 1 DAY), '%d-%m-%Y')
			            ELSE DATE_FORMAT(sd.cdate, '%d-%m-%Y')
			        END
			    WHEN sd.cdate < '2024-03-21 06:00:00' THEN DATE_FORMAT('2024-03-21', '%d-%m-%Y')
			    ELSE ''
			END AS commissioning_date")
	        ->from('tbl_site_device_installation sd')
	        ->join('tbl_well_master wm', 'sd.well_id=wm.id and wm.status=1', 'left')
	        ->where(['sd.status'=>1, 'sd.device_shifted'=>0])
	        ->where('MONTH(sd.cdate)', $month)
	        ->where('YEAR(sd.cdate)', $year)
	        ->where('sd.cdate >=', '2024-03-21 06:00:00');

		$applyFilters($newWellQuery);

		$result = $newWellQuery->get()->result_array();

		$newWellDetails = array_filter($result, function($item) use ($month) {
		    return date('m', strtotime($item['commissioning_date'])) == $month;
		});


		$newWellDetails = array_values($newWellDetails);

		$res['new_Well']['newwellDetails'] = $newWellDetails;
	    // print_r($res['new_Well']['newwellDetails']);die;

	    // =============================================================

	    // $shiftWellCount = $this->db->select("IFNULL(count(sd.well_id), 0) as totalwell")
	    //     ->from('tbl_site_device_installation sd')
	    //     ->where(['sd.status'=>1, 'sd.device_shifted'=>1])
	    //     ->where('MONTH(sd.date_of_shifted)', $month);

	    // $applyFilters($shiftWellCount);
	    // $totalWellResult = $shiftWellCount->get()->row();
	    // $res['shift_Well']['totalshiftwell'] = $totalWellResult->totalwell;

	    // $shiftWellQuery = $this->db->select("sd.well_id, wm.well_name, DATE_FORMAT(sd.date_of_shifted, '%d-%m-%Y') as shifted_date,CASE
		// 	    WHEN sd.date_of_installation >= '2024-03-21 06:00:00' THEN
		// 	        CASE
		// 	            WHEN DATE_FORMAT(DATE_ADD(sd.date_of_installation, INTERVAL 1 DAY), '%H:%i:%s') >= '06:00:00' THEN DATE_FORMAT(DATE_ADD(sd.date_of_installation, INTERVAL 1 DAY), '%d-%m-%Y')
		// 	            ELSE DATE_FORMAT(sd.date_of_installation, '%d-%m-%Y')
		// 	        END
		// 	    WHEN sd.date_of_installation < '2024-03-21 06:00:00' THEN DATE_FORMAT('2024-03-21', '%d-%m-%Y')
		// 	    ELSE ''
		// 	END AS commissioning_date")
	    //     ->from('tbl_site_device_installation sd')
	    //     ->join('tbl_well_master wm', 'sd.well_id=wm.id and wm.status=1', 'left')
	    //     ->where(['sd.status'=>1, 'sd.device_shifted'=>1])
	    //     ->where('MONTH(sd.date_of_shifted)', $month);

	    // $applyFilters($shiftWellQuery);
	    // $res['shift_Well']['shiftwellDetails'] = $shiftWellQuery->get()->result_array();

	    $shiftWellCount = $this->db->select("IFNULL(count(sdd.shifted_well_id), 0) as totalwell")
	        ->from('tbl_well_shifted_device_details sdd')
	        ->join('tbl_site_device_installation sd','sd.well_id=sdd.shifted_well_id and sdd.status = 1','left')
	        ->where(['sd.status'=>1])
	        ->where('MONTH(sdd.shifted_well_installation_date)', $month)
	        ->where('YEAR(sd.date_of_installation)', $year);
	        // ->where('sdd.shifted_well_installation_date >=', '2024-03-21 06:00:00');

	    $applyFilters($shiftWellCount);
	    $totalWellResult = $shiftWellCount->get()->row();
	    $res['shift_Well']['totalshiftwell'] = $totalWellResult->totalwell;

	    $shiftWellQuery = $this->db->select("sdd.shifted_well_id, wm.well_name,wm2.well_name as well_name2, DATE_FORMAT(sdd.shifted_datetime, '%d-%m-%Y') as shifted_date,
	    	CASE
		        WHEN sdd.shifted_well_installation_date >= '2024-03-21 06:00:00' THEN
		            CASE
		                WHEN DATE_FORMAT(DATE_ADD(sdd.shifted_well_installation_date, INTERVAL 1 DAY), '%H:%i:%s') >= '06:00:00' THEN DATE_FORMAT(DATE_ADD(sdd.shifted_well_installation_date, INTERVAL 1 DAY), '%d-%m-%Y')
		                ELSE DATE_FORMAT(sdd.shifted_well_installation_date, '%d-%m-%Y')
		            END
		        WHEN sdd.shifted_well_installation_date < '2024-03-21 06:00:00' THEN DATE_FORMAT('2024-03-21', '%d-%m-%Y')
		        ELSE ''
		    END AS commissioning_date")
	        ->from('tbl_well_shifted_device_details sdd')
	        ->join('tbl_site_device_installation sd','sd.well_id=sdd.shifted_well_id and sdd.status = 1','left')
	        ->join('tbl_well_master wm', 'sdd.shifted_well_id=wm.id and wm.status=1', 'left')
	        ->join('tbl_well_master wm2', 'sdd.allot_well_id=wm2.id and wm.status=1', 'left')
	        ->where('MONTH(sdd.shifted_datetime)', $month)
	        ->where('YEAR(sdd.shifted_datetime)', $year);

	    $applyFilters($shiftWellQuery);
	    $res['shift_Well']['shiftwellDetails'] = $shiftWellQuery->get()->result_array();
	    // print_r($res['shift_Well']['shiftwellDetails']);die;

	    // =========================================================

	    $removeWellCount = $this->db->select("IFNULL(count(sd.well_id), 0) as totalwell")
	        ->from('tbl_site_device_installation sd')
	        ->where(['sd.status'=>0])
	        ->where('MONTH(sd.ddate)', $month)
	        ->where('YEAR(sd.ddate)', $year);

	    $applyFilters($shiftWellCount);
	    $totalWellResult = $shiftWellCount->get()->row();
	    $res['remove_Well']['totalremovewell'] = $totalWellResult->totalwell;

	    $removeWellQuery = $this->db->select("sd.well_id, wm.well_name, DATE_FORMAT(sd.ddate, '%d-%m-%Y') as remove_date,CASE
			    WHEN sd.date_of_installation >= '2024-03-21 06:00:00' THEN
			        CASE
			            WHEN DATE_FORMAT(DATE_ADD(sd.date_of_installation, INTERVAL 1 DAY), '%H:%i:%s') >= '06:00:00' THEN DATE_FORMAT(DATE_ADD(sd.date_of_installation, INTERVAL 1 DAY), '%d-%m-%Y')
			            ELSE DATE_FORMAT(sd.date_of_installation, '%d-%m-%Y')
			        END
			    WHEN sd.date_of_installation < '2024-03-21 06:00:00' THEN DATE_FORMAT('2024-03-21', '%d-%m-%Y')
			    ELSE ''
			END AS commissioning_date")
	        ->from('tbl_site_device_installation sd')
	        ->join('tbl_well_master wm', 'sd.well_id=wm.id and wm.status=1', 'left')
	        ->where(['sd.status'=>0])
	        ->where('MONTH(sd.ddate)', $month)
	        ->where('YEAR(sd.ddate)', $year);

	    $applyFilters($removeWellQuery);
	    $res['remove_Well']['removewellDetails'] = $removeWellQuery->get()->result_array();

	    return $res;
	}

// 	public function Asset_Areawise_monthlyDeviceRecord_model($site_id,$month,$year)
//     {
//     $applyFilters = function ($query) use ($site_id, $month,$year) {
//         if (!empty($site_id)) 
// 	    {
// 	        $query->where('sd.site_id', $site_id);
// 	    }

        
//         $year = date('Y');
// 	    $startDateTime = date('Y-m-d H:i:s', strtotime("$year-$month-01 06:00:00")); 
// 	    $endDateTime = date('Y-m-d H:i:s', strtotime("$year-".($month+1)."-01 05:59:59"));
// 	    $query->where('hl.last_log_datetime >=', $startDateTime)
// 		          ->where('hl.last_log_datetime <', $endDateTime);
//     };

//     $res = [];

//     $query = $this->db->select("am.area_name, sd.well_id, wm.well_name, DATE_FORMAT(sd.date_of_installation, '%d-%m-%Y') as installation_date, sd.device_name, hl.imei_no, DATE_FORMAT(hl.last_log_datetime,'%d') as date, COUNT(hl.id) as total")
//         ->from('tbl_site_device_installation sd')
//         ->join('tbl_device_log hl', 'sd.well_id=hl.well_id')
//         ->join('tbl_well_master wm', 'sd.well_id=wm.id and wm.status=1', 'left')
//         ->join('tbl_area_master am', 'sd.area_id=am.id and am.status=1', 'left')
//         ->where(['sd.status'=>1, 'sd.device_shifted'=>0])
//         ->where('MONTH(sd.date_of_installation)', $month)
//         ->where('YEAR(sd.date_of_installation)', $year)
//         ->group_by('hl.well_id, DATE(hl.last_log_datetime)');


       

//     $applyFilters($query);

//     $records = $query->get()->result_array();

//     $deviceRecord = [];
//     foreach ($records as $record) {
//         $wellId = $record['well_id'];

//         if (!isset($deviceRecord[$wellId])) {
//             $deviceRecord[$wellId] = [
//                 'well_id' => $record['well_id'],
//                 'well_name' => $record['well_name'],
//                 'installation_date' => $record['installation_date'],
//                 'imei_no' => $record['imei_no'],
//                 'device_name' => $record['device_name'],
//                 'log' => [],
//                 'replacement_records' => []
//             ];
//         }

//         // Initialize log with zero counts for all dates in the month
//         $daysInMonth = cal_days_in_month(CAL_GREGORIAN, intval(date('m', strtotime($record['installation_date']))), intval(date('Y', strtotime($record['installation_date']))));
//         for ($i = 1; $i <= $daysInMonth; $i++) {
//             $deviceRecord[$wellId]['log'][str_pad($i, 2, '0', STR_PAD_LEFT)] = 0;
//         }

//         // Add installation record counts to the log
//         $deviceRecord[$wellId]['log'][$record['date']] = $record['total'];
//     }

//     // Fetch and add replacement records
//     foreach ($deviceRecord as &$wellData) {
//         $replaceQuery = $this->db->select("am.area_name, wm.well_name, DATE_FORMAT(rd.replacement_datetime, '%d-%m-%Y') as replace_date, rd.old_device_name as device_name, rd.old_imei_no as imei_no, DATE_FORMAT(hl.last_log_datetime,'%d') as date, COUNT(hl.id) as total")
//           ->from('tbl_device_replecement_details rd')
//           ->join('tbl_site_device_installation sd','rd.well_id=sd.well_id and sd.status = 1')
//           ->join('tbl_device_log hl', 'rd.well_id=hl.well_id and rd.old_imei_no=hl.imei_no')
//           ->join('tbl_area_master am', 'rd.area_id=am.id and am.status=1', 'left')
//           ->join('tbl_well_master wm', 'rd.well_id=wm.id and wm.status=1', 'left')
//           ->where(['rd.status'=>1,'sd.device_shifted'=>0, 'rd.well_id' => $wellData['well_id']])
//           ->where('rd.replacement_datetime >= hl.last_log_datetime')
//           ->where('MONTH(rd.replacement_datetime)', $month)
//           ->group_by('hl.well_id, rd.old_imei_no, DATE(hl.last_log_datetime)');

//         $applyFilters($replaceQuery);
//         $replaceRecords = $replaceQuery->get()->result_array();
      

//         foreach ($replaceRecords as $replace) {
//             // Initialize log with zero counts for all dates in the month
//             $daysInMonth = cal_days_in_month(CAL_GREGORIAN, intval(date('m', strtotime($replace['replace_date']))), intval(date('Y', strtotime($replace['replace_date']))));
//             for ($i = 1; $i <= $daysInMonth; $i++) {
//                 $replace['log'][] = ['date' => str_pad($i, 2, '0', STR_PAD_LEFT), 'count' => 0];
//             }
            
//             // Set count for the replacement date
//             foreach ($replace['log'] as &$log) {
//                 if ($log['date'] === $replace['date']) {
//                     $log['count'] = $replace['total'];
//                     break;
//                 }
//             }
            
//             unset($replace['date']);
//             unset($replace['total']);
//             $wellData['replacement_records'][] = $replace;
//         }
//     }

//     $deviceRecord = ['well_detail' => $deviceRecord];

//     return $deviceRecord;
// }


	
	public function Asset_Areawise_monthlyDeviceRecord_model($site_id, $month, $year)
	{
		    $applyFilters = function ($query) use ($site_id, $month, $year) {
		        if (!empty($site_id)) {
		            $query->where('sd.site_id', $site_id);
		        }

		        $year = date('Y');
		        $startDateTime = date('Y-m-d H:i:s', strtotime("$year-$month-01 06:00:00"));
		        $endDateTime = date('Y-m-d H:i:s', strtotime("$year-" . ($month + 1) . "-01 05:59:59"));

		        $query->where('hl.last_log_datetime >=', $startDateTime)
		            ->where('hl.last_log_datetime <', $endDateTime);
		    };

			    $res = [];

			    $query = $this->db->select("sd.well_id,wm.well_name, DATE_FORMAT(sd.date_of_installation, '%d-%m-%Y') as installation_date, sd.device_name, hl.imei_no, DATE_FORMAT(hl.last_log_datetime,'%d') as date, COUNT(hl.id) as total")
			        ->from('tbl_site_device_installation sd')
			        ->join('tbl_device_log hl', 'sd.well_id=hl.well_id')
			        ->join('tbl_well_master wm', 'sd.well_id=wm.id and wm.status=1', 'left')
			        ->where(['sd.status' => 1, 'sd.device_shifted' => 0])
			        ->where('MONTH(sd.date_of_installation)', $month)
			        ->where('YEAR(sd.date_of_installation)', $year)
			        ->where('sd.date_of_installation <= hl.last_log_datetime OR sd.date_of_shifted <= hl.last_log_datetime ')
			        ->group_by('hl.well_id, DATE(hl.last_log_datetime)');

			    $applyFilters($query);

			    $records = $query->get()->result_array();

			   
			    $deviceRecord = [];

			    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, date('Y'));

			    $allDates = [];
			    for ($i = 1; $i <= $daysInMonth; $i++) {
			        $allDates[str_pad($i, 2, '0', STR_PAD_LEFT)] = 0;
			    }

			    foreach ($records as $record) {
			        $date = $record['date'];
			        $count = $record['total'];

			        $deviceRecord[] = [
			        	'well_id'=>$record['well_id'],
			            'well_name' => $record['well_name'],
			            'installation_date' => $record['installation_date'],
			            'imei_no' => $record['imei_no'],
			            'device_name' => $record['device_name'],
			            'log' => $allDates,
			            'replacement_records' => [],
			            'shifted_records' => []
			        ];

			        $index = count($deviceRecord) - 1;

			        $deviceRecord[$index]['log'][$date] = $count;
			    }

			    foreach ($deviceRecord as &$record) {
			        $log = [];
			        foreach ($record['log'] as $date => $count) {
			            $log[] = ['date' => $date, 'count' => $count];
			        }
			        $record['log'] = $log;
			    }

			    foreach ($deviceRecord as &$wellData) {
			        $replaceQuery = $this->db->select("wm.well_name, DATE_FORMAT(rd.replacement_datetime, '%d-%m-%Y') as replace_date, rd.old_device_name as device_name, rd.old_imei_no as imei_no, DATE_FORMAT(hl.last_log_datetime,'%d') as date, COUNT(hl.id) as total")
			            ->from('tbl_device_replecement_details rd')
			            ->join('tbl_site_device_installation sd', 'rd.well_id=sd.well_id and sd.status = 1')
			            ->join('tbl_device_log hl', 'rd.well_id=hl.well_id and rd.old_imei_no=hl.imei_no')
			            ->join('tbl_well_master wm', 'rd.well_id=wm.id and wm.status=1', 'left')
			            ->where(['rd.status' => 1, 'sd.device_shifted' => 0, 'rd.well_id' => $wellData['well_id']])
			            ->where('rd.replacement_datetime >= hl.last_log_datetime')
			            ->where('MONTH(rd.replacement_datetime)', $month)
			            ->group_by('hl.well_id, rd.old_imei_no, DATE(hl.last_log_datetime)');

			        $applyFilters($replaceQuery);
			        $replaceRecords = $replaceQuery->get()->result_array();

			        foreach ($replaceRecords as $replace) {
			        
			            $replace['log'] = [];
			            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, intval(date('m', strtotime($replace['replace_date']))), intval(date('Y', strtotime($replace['replace_date']))));
			            for ($i = 1; $i <= $daysInMonth; $i++) {
			                $replace['log'][] = ['date' => str_pad($i, 2, '0', STR_PAD_LEFT), 'count' => 0];
			            }

			            foreach ($replace['log'] as &$log) {
			                if ($log['date'] === $replace['date']) {
			                    $log['count'] = $replace['total'];
			                    break;
			                }
			            }

			            unset($replace['date']);
			            unset($replace['total']);

			           
			            foreach ($deviceRecord as &$record) {
			                if ($record['well_name'] == $replace['well_name']) {
			                    $record['replacement_records'][] = $replace;
			                    break;
			                }
			            }
			        }
			    }


			    foreach ($deviceRecord as &$wellData) {
			        $shiftedQuery = $this->db->select("wm.well_name, DATE_FORMAT(rd.shifted_datetime, '%d-%m-%Y') as shifted_date,DATE_FORMAT(rd.shifted_well_installation_date, '%d-%m-%Y') as installed_date,rd.shifted_device_name as device_name, rd.shifted_imei_no as imei_no, DATE_FORMAT(hl.last_log_datetime,'%d') as date, COUNT(hl.id) as total")
			            ->from('tbl_well_shifted_device_details rd')
			            ->join('tbl_site_device_installation sd', 'rd.shifted_well_id=sd.well_id and sd.status = 1')
			            ->join('tbl_device_log hl', 'rd.shifted_well_id=hl.well_id and rd.shifted_imei_no=hl.imei_no')
			            ->join('tbl_well_master wm', 'rd.shifted_well_id=wm.id and wm.status=1', 'left')
			            ->where(['rd.status' => 1,'rd.shifted_well_id' => $wellData['well_id']])
			            ->where('rd.shifted_datetime >= hl.last_log_datetime')
			            ->where('MONTH(rd.shifted_datetime)', $month)
			            ->group_by('hl.well_id,DATE(hl.last_log_datetime)');

			        $applyFilters($shiftedQuery);
			        $shiftedRecords = $shiftedQuery->get()->result_array();

			         // print_r($wellData['well_id']);die;

			        foreach ($shiftedRecords as $shifted) {
			        
			            $shifted['log'] = [];
			            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, intval(date('m', strtotime($shifted['shifted_date']))), intval(date('Y', strtotime($shifted['shifted_date']))));
			            for ($i = 1; $i <= $daysInMonth; $i++) {
			                $shifted['log'][] = ['date' => str_pad($i, 2, '0', STR_PAD_LEFT), 'count' => 0];
			            }

			            foreach ($shifted['log'] as &$log) {
			                if ($log['date'] === $shifted['date']) {
			                    $log['count'] = $shifted['total'];
			                    break;
			                }
			            }

			            unset($shifted['date']);
			            unset($shifted['total']);

			           
			            foreach ($deviceRecord as &$record) {
			                if ($record['well_name'] == $shifted['well_name']) {
			                    $record['shifted_records'][] = $shifted;
			                    break;
			                }
			            }
			        }
			    }



			    return $deviceRecord;
	}


	// public function device_recode_data($site_id,$month,$year)
	// {
	//    if ($site_id != '') 
    //    {
    //    	 $this->db->where('sd.site_id',$site_id);
    //    }

    //    if ($month != '') 
    //    {
    //    	 $this->db->where('hd.month',$month);
    //    }

    //    if ($year != '') 
    //    {
    //    	 $this->db->where('hd.year',$year);
    //    }
         
    //     return $this->db->select('hd.running_minutes,hd.running_days,hd.baseline,COALESCE(hd.power_not_available,0)as power_not_available,COALESCE(hd.faulty_srp,0)as faulty_srp,COALESCE(hd.eligible_sample,0)eligible_sample,COALESCE(hd.actual_sample,0)as actual_sample,hd.availability_perc,COALESCE(hd.network_not_connected_day,0)network_not_connected_day,hd.record_date,wm.well_name,ds.device_name')
    //             ->from('tbl_site_device_installation sd')
    //             ->join('tbl_device_record_count_log hd','hd.well_id = sd.well_id','left')
    //             ->join('tbl_well_master wm','sd.well_id=wm.id','left')
    //             ->join('tbl_device_setup ds','ds.imei_no=hd.imei_no','left')
    //             ->where(['sd.status'=>1,'wm.status'=>1])
    //             ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
    //             ->get()->result_array();
	// }

	public function device_recode_data($site_id,$month,$year)
	{
	   if ($site_id != '') 
       {
       	 $this->db->where('sd.site_id',$site_id);
       }

       if ($month != '') 
       {
       	 $this->db->where('hd.month',$month);
       }

       if ($year != '') 
       {
       	 $this->db->where('hd.year',$year);
       }
         
        return $this->db->select('SUM(hd.running_minutes) as running_minutes,SUM(hd.baseline) as baseline,COALESCE(SUM(hd.power_not_available),0)as power_not_available,COALESCE(SUM(hd.faulty_srp),0)as faulty_srp,COALESCE(SUM(hd.eligible_sample),0)eligible_sample,COALESCE(SUM(hd.actual_sample),0)as actual_sample,SUM(hd.availability_perc),COALESCE(SUM(hd.network_not_connected_day),0)network_not_connected_day,hd.record_date,wm.well_name,ds.device_name')
                ->from('tbl_site_device_installation sd')
                ->join('tbl_device_record_count_log hd','hd.well_id = sd.well_id','left')
                ->join('tbl_well_master wm','sd.well_id=wm.id','left')
                ->join('tbl_device_setup ds','ds.imei_no=hd.imei_no','left')
                ->where(['sd.status'=>1,'wm.status'=>1])
                ->group_by('sd.well_id')
                ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
                ->get()->result_array();
	}




}
?> 
