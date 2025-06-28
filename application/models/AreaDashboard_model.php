
<?php
   date_default_timezone_set('Asia/Kolkata');
class AreaDashboard_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function TotalSite($company_id,$assets_id,$area_id)
    {
        if($company_id!='')
            $this->db->where('company_id',$company_id);
        if($assets_id!='')
            $this->db->where('assets_id',$assets_id);
        if($area_id!='')
            $this->db->where('area_id',$area_id);

        $res = $this->db->select("count(distinct id) as total")->from('tbl_well_site_master')->where(['status'=>1])->get()->result_array();

        if(!empty($res))
        {
            return $res[0]['total'];
        }else{
            return 0;
        }
    }

    public function Totalwell($company_id,$assets_id,$area_id,$site_id,$well_id,$feeder_id)
    {
        if($company_id!='')
            $this->db->where('wm.company_id',$company_id);
        if($assets_id!='')
            $this->db->where('wm.assets_id',$assets_id);
        if($area_id!='')
            $this->db->where('wm.area_id',$area_id);
        if($site_id!='')
            $this->db->where('wm.site_id',$site_id);
        if($well_id!='')
            $this->db->where('wm.id',$well_id);
        if ($feeder_id != '') {
            $this->db->where('sd.feeder_id', $feeder_id);
        }

        $res = $this->db->select("count(distinct wm.id) as total")->from('tbl_well_master wm')
        ->join('tbl_site_device_installation sd','wm.id=sd.well_id','left')
        ->where(['wm.status'=>1,'sd.status'=>1,'sd.device_shifted'=>0])->get()->result_array();
                      

        if(!empty($res))
        {
            return $res[0]['total'];
        }else{
            return 0;
        }
    }

    public function TotalInstalledSite($company_id,$assets_id,$area_id,$site_id,$well_id,$feeder_id)
    {
        if($company_id!='')
            $this->db->where('company_id',$company_id);
        if($assets_id!='')
            $this->db->where('assets_id',$assets_id);
        if($area_id!='')
            $this->db->where('area_id',$area_id);
        if($site_id!='')
            $this->db->where('site_id',$site_id);
        if($well_id!='')
            $this->db->where('well_id',$well_id);
        if ($feeder_id != '') {
            $this->db->where('feeder_id', $feeder_id);
        }

        $res = $this->db->select("count(distinct well_id) as total")->from('tbl_site_device_installation')->where(['status'=>1,'device_shifted'=>0])->get()->result_array();

        if(!empty($res))
        {
            return $res[0]['total'];
        }else{
            return 0;
        }
    }

    public function Total_shiftedDevice($company_id,$assets_id,$area_id,$site_id,$feeder_id)
    {
        if($company_id!='')
            $this->db->where('company_id',$company_id);
        if($assets_id!='')
            $this->db->where('assets_id',$assets_id);
        if($area_id!='')
            $this->db->where('area_id',$area_id);
        if($site_id!='')
            $this->db->where('site_id',$site_id);
        if ($feeder_id != '') {
            $this->db->where('feeder_id', $feeder_id);
        }

        $res = $this->db->select("count(distinct well_id) as total_shifted")->from('tbl_site_device_installation')->where(['status'=>1,'device_shifted'=>1])->get()->result_array();

        if(!empty($res))
        {
            return $res[0]['total_shifted'];
        }else{
            return 0;
        }
    }

    public function Total_Functional_unit($company_id,$assets_id,$area_id,$site_id,$well_id,$feeder_id)
    {
        if($company_id!='')
            $this->db->where('company_id',$company_id);
        if($assets_id!='')
            $this->db->where('assets_id',$assets_id);
        if($area_id!='')
            $this->db->where('area_id',$area_id);
        if($site_id!='')
            $this->db->where('site_id',$site_id);
        if($well_id!='')
            $this->db->where('well_id',$well_id);
        if ($feeder_id != '') 
            $this->db->where('feeder_id', $feeder_id);

        $this->db->where("(TIMESTAMPDIFF(MINUTE, last_log_datetime, NOW()) < 5)");

        $res = $this->db->select("count(distinct well_id) as total")->from('tbl_site_device_installation')->where(['status'=>1,'device_shifted'=>0])->get()->result_array();

        if(!empty($res))
        {
            return $res[0]['total'];
        }else{
            return 0;
        }
    }


    public function Total_temporary_unit($company_id,$assets_id,$area_id,$site_id,$well_id,$feeder_id)
    {
        if($company_id!='')
            $this->db->where('company_id',$company_id);
        if($assets_id!='')
            $this->db->where('assets_id',$assets_id);
        if($area_id!='')
            $this->db->where('area_id',$area_id);
        if($site_id!='')
            $this->db->where('site_id',$site_id);
        if($well_id!='')
            $this->db->where('well_id',$well_id);
        if ($feeder_id != '') {
            $this->db->where('feeder_id', $feeder_id);
        }

        $this->db->where("(TIMESTAMPDIFF(MINUTE, last_log_datetime, NOW()) > 5 
                        OR (TIMESTAMPDIFF(MINUTE, last_log_datetime, NOW()) < 5 
                        AND output_Average_Current <= 0))");

        $res = $this->db->select("count(distinct well_id) as total")->from('tbl_site_device_installation')->where(['status'=>1,'device_shifted'=>0,'flag_status'=>1])->get()->result_array();

        if(!empty($res))
        {
            return $res[0]['total'];
        }else{
            return 0;
        }
    }



    public function Total_faulty_Well($company_id, $assets_id, $area_id, $site_id,$well_id,$feeder_id)
    {
        if ($company_id != '') {
            $this->db->where('sd.company_id', $company_id);
        }
        if ($assets_id != '') {
            $this->db->where('sd.assets_id', $assets_id);
        }
        if ($area_id != '') {
            $this->db->where('sd.area_id', $area_id);
        }
        if ($site_id != '') {
            $this->db->where('sd.site_id', $site_id);
        }
        if ($well_id != '')
        $this->db->where('sd.well_id', $well_id);

        if ($feeder_id != '') {
            $this->db->where('sd.feeder_id', $feeder_id);
        }

        $currentTime = date('H:i:s');

        $this->db->where("(TIMESTAMPDIFF(MINUTE, sd.last_log_datetime, NOW()) < 5)");
        $this->db->where(['sd.flag_status'=>0]);
     
        $res =  $this->db->select("COUNT(DISTINCT sd.well_id) as total")
            ->from('tbl_site_device_installation sd')
            ->join('tbl_well_configuration wc', 'sd.well_id = wc.well_id and wc.status = 1', 'left')
            ->group_start()
                ->where("(
                    (sd.output_Average_Current <= 0 AND sd.output_Average_Voltage_P2P > 200 AND (
                        (wc.well_type = 0 AND (wc.start_time IS NULL OR (wc.start_time <= '$currentTime' AND wc.stop_time >= '$currentTime'))) OR
                        (wc.well_type = 1 AND wc.start_time <= '$currentTime' AND wc.stop_time >= '$currentTime')
                    ))
                )")
            ->group_end()
            ->get()
            ->result_array();
            if(!empty($res))
            {
                return $res[0]['total'];
            }else{
                return 0;
            }
    }

   public function Total_power_cutWell($company_id, $assets_id, $area_id, $site_id, $well_id,$feeder_id)
   {
        if ($company_id != '') {
            $this->db->where('sd.company_id', $company_id);
        }
        if ($assets_id != '') {
            $this->db->where('sd.assets_id', $assets_id);
        }
        if ($area_id != '') {
            $this->db->where('sd.area_id', $area_id);
        }
        if ($site_id != '') {
            $this->db->where('sd.site_id', $site_id);
        }
        if ($well_id != '') {
            $this->db->where('sd.well_id', $well_id);
        }
        if ($feeder_id != '') {
            $this->db->where('sd.feeder_id', $feeder_id);
        }

        $currentTime = date('H:i:s');

    

        $this->db->where("(TIMESTAMPDIFF(MINUTE, sd.last_log_datetime, NOW()) < 5)");
        $this->db->where(['sd.flag_status'=>0]);

        $res = $this->db->select("COUNT(DISTINCT sd.well_id) as total")
            ->from('tbl_site_device_installation sd')
            ->join('tbl_well_configuration wc', 'sd.well_id = wc.well_id and wc.status = 1', 'left')
            ->group_start()
                ->where("
                    (
                        (sd.output_Average_Current <= 0 AND sd.output_Average_Voltage_P2P < 200 AND(
                            (wc.well_type = 0 AND (wc.start_time IS NULL OR (wc.start_time <= '$currentTime' AND wc.stop_time >= '$currentTime'))) OR
                            (wc.well_type = 1 AND wc.start_time <= '$currentTime' AND wc.stop_time >= '$currentTime')
                        ))
                    )
                ")
            ->group_end()
            ->get()
            ->result_array();

        if (!empty($res)) {
            return $res[0]['total'];
        } else {
            return 0;
        }
    }
   public function Total_timeroffWell($company_id, $assets_id, $area_id, $site_id, $well_id,$feeder_id)
   {
        if ($company_id != '') {
            $this->db->where('sd.company_id', $company_id);
        }
        if ($assets_id != '') {
            $this->db->where('sd.assets_id', $assets_id);
        }
        if ($area_id != '') {
            $this->db->where('sd.area_id', $area_id);
        }
        if ($site_id != '') {
            $this->db->where('sd.site_id', $site_id);
        }
        if ($well_id != '') {
            $this->db->where('sd.well_id', $well_id);
        }

        if ($feeder_id != '') {
            $this->db->where('sd.feeder_id', $feeder_id);
        }

        $currentTime = date('H:i:s');
        // print_r($currentTime);die;
                            
        $timeRanges = $this->db->select('sd.well_id, GROUP_CONCAT(DISTINCT wc.start_time ORDER BY wc.c_date DESC) as start_time, GROUP_CONCAT(DISTINCT wc.stop_time ORDER BY wc.c_date DESC) as stop_time')
                         ->from('tbl_site_device_installation sd')
                         ->join('tbl_well_configuration wc', 'wc.well_id = sd.well_id', 'left')
                         ->where(['wc.status' => 1,'wc.well_type' => 1,'sd.output_Average_Current <=' => 0,'sd.flag_status'=>0])
                         ->where("(TIMESTAMPDIFF(MINUTE, sd.last_log_datetime, NOW()) < 5)")
                         ->group_by('sd.well_id') 
                         ->get()
                         ->result_array();

        $timer_off_wells_count = 0; 

        foreach ($timeRanges as $range) {
       
            $isInRange = false;
            foreach (explode(',', $range['start_time']) as $key => $start_time) {
                $stop_times = explode(',', $range['stop_time']);
                $stop_time = isset($stop_times[$key]) ? $stop_times[$key] : end($stop_times);
                if ($currentTime >= $start_time && $currentTime <= $stop_time) {
                    $isInRange = true;
                    break;
                }
            }
          
            if (!$isInRange) {
                $timer_off_wells_count++; 
            }
        }

          return $timer_off_wells_count;
    }


    public function getAsset($company_id,$user_id)
    {
        if($company_id!='')
            $this->db->where('am.company_id',$company_id);
        if($user_id!='')
            $this->db->where('ad.user_id',$user_id);
        return $this->db->select("am.id,am.assets_name,ad.user_id")->from('tbl_assets_master am')->join('tbl_role_wise_user_assign_details ad','am.id=ad.assets_id','left')->where(['am.status'=>1,'ad.status'=>1])->group_by('am.id')->get()->result_array();
    }

    public function getArea($company_id,$assets_id,$user_id)
    {
        if($company_id!='')
            $this->db->where('am.company_id',$company_id);
        if($assets_id!='')
            $this->db->where('am.assets_id',$assets_id);
        if($user_id!='')
            $this->db->where('ad.user_id',$user_id);
        return $this->db->select("am.id,am.assets_id,am.area_name,ad.user_id")->from('tbl_area_master am')->join('tbl_role_wise_user_assign_details ad','am.id=ad.area_id','left')->where(['am.status'=>1,'ad.status'=>1])->group_by('am.id')->get()->result_array();
    }

    public function getSite($company_id,$assets_id,$area_id,$user_id)
    {
        if($company_id!='')
            $this->db->where('sm.company_id',$company_id);
        if($assets_id!='')
            $this->db->where('sm.assets_id',$assets_id);
        if($area_id!='')
            $this->db->where('sm.area_id',$area_id);
        if($user_id!='')
            $this->db->where('ad.user_id',$user_id);
        return $this->db->select("sm.id,sm.assets_id,sm.area_id,sm.well_site_name,ad.user_id")->from('tbl_well_site_master sm')->join('tbl_role_wise_user_assign_details ad','sm.id=ad.site_id','left')->where(['sm.status'=>1,'ad.status'=>1])->group_by('sm.id')->get()->result_array();
    }



    public function getWelllist($company_id, $assets_id, $area_id, $user_id, $well_id, $site_id, $feeder_id, $well_type)
    {
        if ($company_id != '') {
            $this->db->where('wm.company_id', $company_id);
        }
        if ($assets_id != '') {
            $this->db->where('wm.assets_id', $assets_id);
        }
        if ($area_id != '') {
            $this->db->where('wm.area_id', $area_id);
        }
        if ($user_id != '') {
            $this->db->where('ad.user_id', $user_id);
        }
        if ($well_id != '') {
            $this->db->where('ad.well_id', $well_id);
        }
        if ($well_type != '') {
            $this->db->where('wm.well_type', $well_type);
        }
        if ($site_id != '') {
            $this->db->where('ws.id', $site_id);
        }
        if ($feeder_id != '') {
            $this->db->where('sd.feeder_id', $feeder_id);
        }
        $this->db->select("wm.id as well_id, wm.assets_id,wm.area_id,ws.id as site_id,wm.well_name, wm.well_type,ad.user_id,sd.device_name,sd.imei_no");
        $this->db->from('tbl_well_master wm');
        $this->db->join('tbl_role_wise_user_assign_details ad', 'wm.site_id = ad.site_id and ad.status = 1', 'left');
        $this->db->join('tbl_well_site_master ws', 'ws.id = ad.site_id', 'left');

        if ($well_type == 2) {
            $this->db->join('tbl_site_device_installtion_self_flow sd', 'wm.id = sd.well_id and sd.status =1', 'left');
        } else {
            $this->db->join('tbl_site_device_installation sd', 'wm.id = sd.well_id', 'left');
        }

        $this->db->where(['wm.status' =>1,'sd.status'=>1]);
        $this->db->group_by('wm.id');
        return $this->db->get()->result_array();
    }

    public function getSite_for_Map($company_id,$assets_id,$area_id,$site_id,$user_id,$well_id,$feeder_id)
    {
        if($company_id!='')
            $this->db->where('w.company_id',$company_id);
        if($assets_id!='')
            $this->db->where('w.assets_id',$assets_id);
        if($area_id!='')
            $this->db->where('w.area_id',$area_id);
        if($site_id!='')
            $this->db->where('w.site_id',$site_id);
        if($well_id!='')
            $this->db->where('w.id',$well_id);
        if($user_id!='')
            $this->db->where('ad.user_id',$user_id);
         if($feeder_id!='')
            $this->db->where('sd.feeder_id',$feeder_id);


        return $this->db->select("w.id as well_id,w.company_id,w.assets_id,w.area_id,am.area_name,w.site_id,wm.well_site_name,w.well_name,w.lat,w.long,sd.smps_voltage,w.device_setup_status,sd.status as device_active_status,sd.output_Average_Current,sd.offline_device_timestamp,sd.last_log_datetime")
        ->from('tbl_well_master w')
        ->join('tbl_area_master am','w.area_id=am.id','left')
        ->join('tbl_well_site_master wm','w.site_id=wm.id','left')
        ->join('tbl_role_wise_user_assign_details ad','w.site_id=w.site_id and ad.status =1 ','left')
        ->join('tbl_site_device_installation sd','sd.well_id=w.id','left')
        ->where(['w.status'=>1])->group_by('w.id')->get()->result_array();
    }

    public function DashboardWelldetails($company_id,$assets_id,$area_id,$site_id,$user_id)
    {
        
        if($company_id!='')
            $this->db->where('ua.company_id',$company_id);
        if($assets_id!='')
            $this->db->where('ua.assets_id',$assets_id);
        if($area_id!='')
            $this->db->where('ua.area_id',$area_id);
        if($site_id!='')
            $this->db->where('ua.site_id',$site_id);
        if($user_id!='')
            $this->db->where('ua.user_id',$user_id);

        return $this->db->select("ua.id,ua.company_id,ua.user_id,ua.assets_id,ua.area_id,a.area_name,ua.site_id,sm.well_site_name,di.well_id,w.well_name,di.id as installed_status,di.imei_no,di.device_name,di.date_of_installation,dr.id as replace_status,dr.replacement_datetime")
        ->from('tbl_site_device_installation di')
        ->join('tbl_role_wise_user_assign_details ua','di.site_id=ua.site_id and di.status = 1','left')
        ->join('tbl_area_master a','di.area_id=a.id','left')
        ->join('tbl_well_site_master sm','di.site_id=sm.id','left')
        ->join('tbl_well_master w','di.well_id=w.id','left')
        ->join('tbl_device_replecement_details dr','di.imei_no = dr.new_imei_no','left')
        ->where(['di.status'=>1,'di.device_shifted'=>0,'w.well_type'=>1])
        ->group_by('w.id')->order_by("CAST(SUBSTRING_INDEX(w.well_name, '#', -1) AS UNSIGNED) ASC")->get()->result_array();
       
    }

    public function Well_Wise_Equipment_Details($well_id)
    {
        
        if($well_id!='')
            $this->db->where('di.well_id',$well_id);

        return $this->db->select("di.id,di.well_id,w.well_name,e.equipment_name,ed.motor_name,ed.serial_no,ed.surface_unit_make,ed.motor_capacity,ed.vfd_make,ed.vfd_model,ed.vfd_capacity,ed.dh_pump_make,ed.dh_pump_capacity,ed.power_source,ed.dg_gg_rating,ed.dg_gg_make,ed.active_energy,di.device_name,di.imei_no,ds.manufacturer_name,ds.serial_no as device_serial_no,di.device_last_status,ds.model_name,wc.well_type,di.flag_status")
        ->from('tbl_site_device_installation di')
        ->join('tbl_equipment_details ed','di.well_id=ed.well_id','left')
        ->join('tbl_equipment_master e','ed.eqp_id=e.id','left')
        ->join('tbl_well_configuration wc','wc.well_id=di.well_id and wc.status = 1','left')
        ->join('tbl_well_master w','di.well_id=w.id and w.status = 1','left')
        ->join('tbl_device_setup ds','di.imei_no=ds.imei_no','left')
        ->where(['di.status'=>1])
        ->group_by('di.well_id')
        ->get()->result_array();
       
    }

    public function Functional_Unit($company_id,$assets_id,$area_id,$site_id,$user_id)
    {
        
        if($company_id!='')
            $this->db->where('di.company_id',$company_id);
        if($assets_id!='')
            $this->db->where('di.assets_id',$assets_id);
        if($area_id!='')
            $this->db->where('di.area_id',$area_id);
        if($site_id!='')
        {
            $project = explode(',', $site_id);
                $this->db->where_in('di.site_id',$site_id);
        }
        if($user_id!='')
            $this->db->where('ad.user_id',$user_id);

        return $this->db->select("di.id,di.company_id,di.assets_id,di.area_id,di.site_id,di.well_id,di.installed_by,ad.user_id,am.area_name,wm.well_site_name,wmm.well_name,di.device_name,di.imei_no,di.date_of_installation,omm.user_full_name")
        ->from('tbl_site_device_installation di')
        ->join('tbl_role_wise_user_assign_details ad','di.site_id = ad.site_id','left')
        ->join('tbl_area_master am','di.area_id = am.id','left')
        ->join('tbl_well_site_master wm','di.site_id = wm.id','left')
        ->join('tbl_well_master wmm','di.well_id = wmm.id','left')
        ->join('tbl_ongc_member_master omm','di.installed_by = omm.id','left')
        ->where(['di.status'=>1,'ad.status'=>1])->group_by('di.id')->get()->result_array();
       
    }

    public function Single_DeviceData($well_id,$imei_no)
    {
        
        if($well_id!='')
            $this->db->where('sd.well_id',$well_id);
        if($imei_no!='')
            $this->db->where('sd.imei_no',$imei_no);

        return $this->db->select("sd.*,wm.well_name")
        ->from('tbl_site_device_installation sd')
        ->join('tbl_well_master wm','sd.well_id=wm.id','left')
        ->where(['sd.status'=>1,'wm.status'=>1])->group_by('sd.well_id')->get()->result_array();
       
    }

    public function WellAlert_Report($well_id,$imei_no,$date)
    {
        
        if($well_id!='')
            $this->db->where('sd.well_id',$well_id);
        if($imei_no!='')
            $this->db->where('sd.imei_no',$imei_no);

        $from_date = date('Y-m-d 06:00:00', strtotime($date));
        $to_date = date('Y-m-d 06:00:00', strtotime($date . '+1 day'));

        return $this->db->select("sd.id,sd.well_id,wm.well_name,tl.imei_no,sd.device_name,tl.alert_type,tl.alerts_details,tl.start_date_time as trip_datetime, tl.end_date_time as trip_end_datetime")
        ->from('tbl_site_device_installation sd')
        ->join('tbl_alert_log tl','sd.well_id=tl.well_id','left')
        ->join('tbl_well_master wm','sd.well_id=wm.id','left')
        ->where('tl.start_date_time >=', $from_date)
        ->where('tl.end_date_time <', $to_date)
        ->where('sd.status',1)->get()->result_array();
       
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
        ->from('tbl_alert_log al')
        ->join('tbl_site_device_installation sd','sd.imei_no=al.imei_no and al.status=1','left')
        ->where(['sd.status'=>1,'al.c_date >='=> $from_date, 'al.c_date <='=> $to_date])->get()->result_array();
        if($res!='')
        {
            return $res[0]['total'];
        }else{
            return 0;
        }
       
    }

    public function get_Single_Daily_report($imei_no,$start_datetime,$end_datetime)
    {
        if($imei_no!='')
            $this->db->where('imei_no',$imei_no);
        if($start_datetime!='' && $end_datetime!='')
            $this->db->where(['date(start_datetime)>='=>$start_datetime,'date(start_datetime)<='=>$end_datetime]);
        return $this->db->select("id,device_name,imei_no,start_datetime,end_datetime,   time_format( timediff(end_datetime, start_datetime), '%H') as hours,
            time_format( timediff(end_datetime, start_datetime), '%i') as mins,
            time_format(timediff(end_datetime, start_datetime), '%s') as sec    
     ")->from('tbl_device_running_log_daily')->where(['status'=>1])->get()->result_array();
    }

    public function get_Single_Hourly_report($imei_no,$start_datetime,$end_datetime)
    {
        if($imei_no!='')
            $this->db->where('imei_no',$imei_no);
        if($start_datetime!='' && $end_datetime!='')
            $this->db->where(['(start_datetime)>='=>$start_datetime,'date(start_datetime)<='=>$end_datetime]);
        return $this->db->select("id,device_name,imei_no,start_datetime,end_datetime,time_format(SUM(abs(timediff(end_datetime, start_datetime))), '%H:%i:%s') as diff,   
     ")->from('tbl_device_running_log_hourly')->where(['status'=>1])->get()->result_array();
    }


    public function Well_On_status($company_id,$assets_id,$area_id,$site_id,$well_id,$feeder_id)
    {

        if($company_id!='')
            $this->db->where('company_id',$company_id);
        if($assets_id!='')
            $this->db->where('assets_id',$assets_id);
        if($area_id!='')
            $this->db->where('area_id',$area_id);
        if($site_id!='')
            $this->db->where('site_id',$site_id);
        if($well_id!='')
            $this->db->where('well_id',$well_id);
        if($feeder_id!='')
            $this->db->where('feeder_id',$feeder_id);
        $this->db->where('status',1);

        $this->db->where("(TIMESTAMPDIFF(SECOND, last_log_datetime, NOW()) < 300)");

        $res = $this->db->select("count(well_id) as total")
        ->from('tbl_site_device_installation')
        ->where(['output_Average_Current>'=>0,'status'=>1,'device_shifted'=>0])->get()->result_array();
        if($res!='')
        {
            return $res[0]['total'];
        }else{
            return 0;
        }

    }

    public function Total_rtmsoffWell($company_id, $assets_id, $area_id, $site_id, $well_id, $feeder_id)
    {
   
        if (!empty($company_id)) {
            $this->db->where('company_id', $company_id);
        }
        if (!empty($assets_id)) {
            $this->db->where('assets_id', $assets_id);
        }
        if (!empty($area_id)) {
            $this->db->where('area_id', $area_id);
        }
        if (!empty($site_id)) {
            $this->db->where('site_id', $site_id);
        }
        if (!empty($feeder_id)) {
            $this->db->where('feeder_id', $feeder_id);
        }

        if(!empty($well_id))
        {
            $this->db->where('well_id', $well_id);
        }

        // Base Conditions
        $this->db->from('tbl_site_device_installation');
        $this->db->where('status', 1);
        $this->db->where('device_shifted', 0);
        $this->db->where(['flag_status' => 0]);

        $this->db->group_start();
        $this->db->where('TIMESTAMPDIFF(SECOND, last_log_datetime, NOW()) > 300');
        $this->db->or_where('last_log_datetime IS NULL');
        $this->db->group_end();


        $this->db->select("COUNT(DISTINCT CASE WHEN ((output_Average_Voltage_L2N <= 0 OR output_Average_Voltage_P2P <= 0) AND battery_voltage < 9) THEN well_id END) AS battery_issue");
        $this->db->select("COUNT(DISTINCT CASE WHEN ((output_Average_Voltage_L2N > 0 OR output_Average_Voltage_P2P > 0) OR battery_voltage > 0) THEN well_id END) AS network_issue");

        $this->db->select("COUNT(DISTINCT well_id) AS total_offline");
        $query = $this->db->get();
        
        return $query->row();
    }



    public function Total_OffInstalled_Well($company_id, $assets_id, $area_id, $site_id,$feeder_id)
    {
        if ($company_id != '') {
            $this->db->where('company_id', $company_id);
        }
        if ($assets_id != '') {
            $this->db->where('assets_id', $assets_id);
        }
        if ($area_id != '') {
            $this->db->where('area_id', $area_id);
        }
        if ($site_id != '') {
            $this->db->where('site_id', $site_id);
        }
        if ($feeder_id != '') {
            $this->db->where('feeder_id', $feeder_id);
        }
        
        $this->db->select('COUNT(well_id) AS total');
        $this->db->from('tbl_site_device_installation');

        $this->db->where('status', 1);
        $this->db->where('device_shifted', 0);
        $this->db->group_start();
        $this->db->where('(output_Average_Current = 0 AND TIMESTAMPDIFF(SECOND, last_log_datetime, NOW()) < 300)');
        $this->db->or_where('TIMESTAMPDIFF(SECOND, last_log_datetime, NOW()) > 300');
        $this->db->or_where('output_Average_Current IS NULL');
        $this->db->or_where('last_log_datetime IS NULL');
        $this->db->group_end();

        $query = $this->db->get();
        return $query->row()->total;
    }

    public function Running_Well_List($company_id,$assets_id,$area_id,$site_id,$user_id)
    {

        if($company_id!='')
            $this->db->where('sd.company_id',$company_id);
        if($assets_id!='')
            $this->db->where('sd.assets_id',$assets_id);
        if($area_id!='')
            $this->db->where('sd.area_id',$area_id);
        if($site_id!='')
            $this->db->where('sd.site_id',$site_id);
         if($user_id!='')
            $this->db->where('ad.user_id',$user_id);

        $this->db->where("(TIMESTAMPDIFF(SECOND, sd.last_log_datetime, NOW()) < 300 OR sd.last_log_datetime IS NULL)");

        return $this->db->select("sd.*,wm.well_name")
        ->from('tbl_site_device_installation sd')
        ->join('tbl_role_wise_user_assign_details ad','sd.site_id = ad.site_id','left')
        ->join('tbl_well_master wm','sd.well_id=wm.id','left')
        ->where(['sd.output_Average_Current>'=>0,'sd.status'=>1,'sd.device_shifted'=>0,'ad.status'=>1])
        ->group_by('sd.well_id')
        ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")->get()->result_array();
       
    }

    public function Not_Running_Well_List($company_id, $assets_id, $area_id, $site_id,$user_id)
    {
        if ($company_id != '') {
            $this->db->where('sd.company_id', $company_id);
        }
        if ($assets_id != '') {
            $this->db->where('sd.assets_id', $assets_id);
        }
        if ($area_id != '') {
            $this->db->where('sd.area_id', $area_id);
        }
        if ($site_id != '') {
            $this->db->where('sd.site_id', $site_id);
        }

         if ($user_id != '') {
            $this->db->where('ad.user_id', $user_id);
        }

        $this->db->select("sd.*,wm.well_name");
        $this->db->from('tbl_site_device_installation sd');
         $this->db->join('tbl_role_wise_user_assign_details ad','sd.site_id = ad.site_id','left');
        $this->db->join('tbl_well_master wm','sd.well_id=wm.id','left');

        $this->db->where('sd.status', 1);
        $this->db->where('sd.device_shifted', 0);
        $this->db->where('ad.status',1);
        $this->db->group_start();
        $this->db->where('(sd.output_Average_Current = 0 AND TIMESTAMPDIFF(SECOND, sd.last_log_datetime, NOW()) < 300)');
        $this->db->or_where('TIMESTAMPDIFF(SECOND, sd.last_log_datetime, NOW()) > 300');
        $this->db->or_where('sd.output_Average_Current IS NULL');
        $this->db->or_where('sd.last_log_datetime IS NULL');
        $this->db->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC");
        $this->db->group_end();
        $this->db->group_by('sd.well_id');

        return $this->db->get()->result_array();
    }




    public function RTMS_List($company_id,$assets_id,$area_id,$site_id)
    {

        if($company_id!='')
            $this->db->where('sd.company_id',$company_id);
        if($assets_id!='')
            $this->db->where('sd.assets_id',$assets_id);
        if($area_id!='')
            $this->db->where('sd.area_id',$area_id);
        if($site_id!='')
            $this->db->where('sd.site_id',$site_id);

        return $this->db->select("sd.*,wm.well_name")
        ->from('tbl_site_device_installation sd')
        ->join('tbl_well_master wm','sd.well_id=wm.id','left')
        ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
        ->where(['sd.status'=>1,'sd.device_shifted'=>0])->get()->result_array();
       
    }
    public function Active_Well_for_popup($company_id, $user_id, $assets_id, $area_id, $site_id, $well_id, $search)
    {
        if ($company_id != '') $this->db->where('ad.company_id', $company_id);
        if ($user_id != '') $this->db->where('ad.user_id', $user_id);
        if ($assets_id != '') $this->db->where('ad.assets_id', $assets_id);
        if ($area_id != '') $this->db->where('sd.area_id', $area_id);
        if ($site_id != '') $this->db->where('sd.site_id', $site_id);
        if ($well_id != '') $this->db->where('sd.well_id', $well_id);
        if ($search != '') $this->db->like('wm.well_name', $search);

       $current_time = date('H:i:s');
        // print_r($current_time);

       $result = $this->db->select("sd.well_id, sd.output_Average_Current, sd.device_shifted,
            sd.last_log_datetime, sd.status, sd.offline_device_timestamp, wm.well_name")
            ->from('tbl_well_master wm')
            ->join('tbl_role_wise_user_assign_details ad', 'wm.site_id=ad.site_id', 'left')
            ->join('tbl_site_device_installation sd', 'wm.id=sd.well_id', 'left')
            ->join('tbl_well_configuration wc','wm.id=wc.well_id and wc.status = 1', 'left')
             ->order_by("
                    CASE
                        WHEN TIMESTAMPDIFF(SECOND, sd.last_log_datetime, NOW()) > 300 OR sd.last_log_datetime IS NULL THEN 4
                        WHEN sd.output_Average_Current <= 0 AND TIMESTAMPDIFF(SECOND, sd.last_log_datetime, NOW()) < 300 THEN 3
                        WHEN sd.output_Average_Current > 0 AND TIMESTAMPDIFF(SECOND, sd.last_log_datetime, NOW()) < 300 THEN 1
                        ELSE 5
                    END
              ")
            ->order_by('wm.well_name','asc')
            ->where(['wm.status' => 1,'sd.status'=>1,'ad.status'=>1,'sd.device_shifted'=>0])
            ->group_by('wm.id')
            ->get()
            ->result_array();
            return $result;
    }

    public function ActiveWell_Detail_for_popup($company_id, $user_id, $assets_id, $area_id, $site_id, $well_id, $search,$feeder_id)
    {
        if ($company_id != '') $this->db->where('ad.company_id', $company_id);
        if ($user_id != '') $this->db->where('ad.user_id', $user_id);
        if ($assets_id != '') $this->db->where('ad.assets_id', $assets_id);
        if ($area_id != '') $this->db->where('sd.area_id', $area_id);
        if ($site_id != '') $this->db->where('sd.site_id', $site_id);
        if ($well_id != '') $this->db->where('sd.well_id', $well_id);
        if ($search != '') $this->db->like('wm.well_name', $search);
        if ($feeder_id != '') $this->db->where('sd.feeder_id', $feeder_id);

        $current_time = date('H:i:s');

        // print_r($current_time);die;

        $result = $this->db->select("sd.well_id, sd.output_Average_Current, sd.device_shifted,
                sd.last_log_datetime, sd.status, sd.offline_device_timestamp, wm.well_name, 
                GROUP_CONCAT(DISTINCT wc.start_time ORDER BY wc.c_date DESC) as start_time, GROUP_CONCAT(DISTINCT wc.stop_time  ORDER BY wc.c_date DESC) as stop_time,sd.flag_status,sd.smps_voltage,sd.battery_voltage,sd.output_Average_Voltage_P2P,sd.output_Average_Voltage_L2N")
            ->from('tbl_well_master wm')
            ->join('tbl_role_wise_user_assign_details ad', 'wm.site_id=ad.site_id', 'left')
            ->join('tbl_site_device_installation sd', 'wm.id=sd.well_id', 'left')
            ->join('tbl_well_configuration wc', 'wm.id=wc.well_id and wc.status = 1', 'left')
            ->order_by("
                    CASE
                        WHEN sd.device_shifted = 1 THEN 6

                        WHEN TIMESTAMPDIFF(SECOND, sd.last_log_datetime, NOW()) > 300 OR sd.last_log_datetime IS NULL AND sd.flag_status = 0 THEN 1
                        WHEN TIMESTAMPDIFF(SECOND, sd.last_log_datetime, NOW()) > 300 OR sd.last_log_datetime IS NULL  THEN 2
                        WHEN sd.output_Average_Current <= 0 AND TIMESTAMPDIFF(SECOND, sd.last_log_datetime, NOW()) < 300 AND ((wc.start_time IS NULL AND wc.stop_time IS NULL) OR ('$current_time' >= wc.start_time AND '$current_time' <= wc.stop_time)) THEN 3
                        WHEN sd.output_Average_Current <= 0 AND TIMESTAMPDIFF(SECOND, sd.last_log_datetime, NOW()) < 300 AND ('$current_time' < wc.start_time OR '$current_time' > wc.stop_time) THEN 4
                        WHEN sd.output_Average_Current > 0 AND TIMESTAMPDIFF(SECOND, sd.last_log_datetime, NOW()) < 300 THEN 5
                        
                        ELSE 7
                    END
              ")
            ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
            ->where(['wm.status' => 1, 'sd.status' => 1, 'ad.status' => 1,'sd.device_shifted'=>0])
            ->group_by('wm.id')
            ->get()
            ->result_array();

    foreach ($result as &$row) 
    {
        $status_variable = '';

        $current_date_time = strtotime(date('Y-m-d H:i:s'));
        // $current_date_time = strtotime("2024-03-28 15:18:00");
        $last_log_timestamp = $row['last_log_datetime'] ? strtotime($row['last_log_datetime']) : null; 
        if ($last_log_timestamp !== null) 
        {
            $time_diff_seconds = $current_date_time - $last_log_timestamp;
            $time_diff_minutes = round($time_diff_seconds / 60); 

            
            if ($row['flag_status'] == 0 && $time_diff_minutes > 5) 
            {
                if(($row['output_Average_Voltage_P2P'] <= 0 || $row['output_Average_Voltage_L2N'] <= 0 ) && $row['battery_voltage'] < 9)
                {
                     $status_variable = 'battery_issue';
                }else{
                     $status_variable = 'offline';
                }
               
            }elseif($row['flag_status'] == 1 && ($time_diff_minutes > 5 || ($time_diff_minutes < 5 && $row['output_Average_Current'] <= 0))) 
            {
            
                $status_variable = 'temperory_offline';

            } elseif($row['output_Average_Current'] <= 0 && $time_diff_minutes < 5 ) {
                if ($row['start_time'] == null && $row['stop_time'] == null) 
                {
                    $status_variable = 'well_not_running';
                } else {
                    $start_times = explode(",", $row['start_time']);
                    $stop_times = explode(",", $row['stop_time']);
                    $found = false;

                    foreach ($start_times as $index => $start_time) 
                    {
                        $stop_time = $stop_times[$index];

                        if ($current_time >= $start_time && $current_time <= $stop_time) {
                            $status_variable = 'well_not_running';
                            $found = true;
                            break;
                        }
                    }

                    if (!$found) {
                        $status_variable = 'timer_off_well';
                    }
                }
            } elseif ($row['output_Average_Current'] > 0 && $time_diff_minutes < 5) {
                $status_variable = 'well_running';
            } else {
                $status_variable = 'unknown';
            }
        } else {

            if($row['flag_status'] == 1)
            {
                 $status_variable = 'temperory_offline';
             }else{
                 $status_variable = 'offline';
             }
            
           
        }

        $row['status_variable'] = $status_variable;
    }


       return $result;
    }



    public function Functional_RTMS_List($company_id, $assets_id, $area_id, $site_id)
    {
    
        if ($company_id !== '') {
            $this->db->where('sd.company_id', $company_id);
        }
        if ($assets_id !== '') {
            $this->db->where('sd.assets_id', $assets_id);
        }
        if ($area_id !== '') {
            $this->db->where('sd.area_id', $area_id);
        }
        if ($site_id !== '') {
            $this->db->where('sd.site_id', $site_id);
        }
       
        $this->db->where("(TIMESTAMPDIFF(SECOND, sd.last_log_datetime, NOW()) < 300 AND sd.last_log_datetime IS NOT NULL)");

        return $this->db->select("sd.*, wm.well_name")
            ->from('tbl_site_device_installation sd')
            ->join('tbl_well_master wm', 'sd.well_id = wm.id', 'left')
            ->where(['sd.status' => 1,'sd.device_shifted'=>0])
            ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
            ->get()
            ->result_array();
    }

    public function NonFunctional_RTMS_List($company_id, $assets_id, $area_id, $site_id,$user_id)
    {
        
        if ($company_id !== '') {
            $this->db->where('sd.company_id', $company_id);
        }
        if ($assets_id !== '') {
            $this->db->where('sd.assets_id', $assets_id);
        }
        if ($area_id !== '') {
            $this->db->where('sd.area_id', $area_id);
        }
        if ($site_id !== '') {
            $this->db->where('sd.site_id', $site_id);
        }
         if ($user_id !== '') {
            $this->db->where('ad.user_id', $user_id);
            $this->db->where('ad.status', 1);
        }
       
            $this->db->where("(TIMESTAMPDIFF(SECOND, sd.last_log_datetime, NOW()) > 300 OR sd.last_log_datetime IS NULL)");

       
        return $this->db->select("sd.*, wm.well_name")
            ->from('tbl_site_device_installation sd')
            ->join('tbl_well_master wm', 'wm.id=sd.well_id', 'left')
            ->join('tbl_role_wise_user_assign_details ad','wm.site_id=ad.site_id','left')
            ->where(['sd.status' => 1,'sd.device_shifted'=>0,'ad.status'=>1,'sd.flag_status'=>0])
            ->group_by('sd.well_id')
            ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
            ->get()
            ->result_array();
    }


    public function temperory_Well_List($company_id,$assets_id,$area_id,$site_id,$user_id)
    {
        if ($company_id !== '') {
            $this->db->where('sd.company_id', $company_id);
        }
        if ($assets_id !== '') {
            $this->db->where('sd.assets_id', $assets_id);
        }
        if ($area_id !== '') {
            $this->db->where('sd.area_id', $area_id);
        }
        if ($site_id !== '') {
            $this->db->where('sd.site_id', $site_id);
        }
        if ($user_id !== '') {
            $this->db->where('ad.user_id', $user_id);
           
        }
      
       $this->db->where("(TIMESTAMPDIFF(MINUTE, last_log_datetime, NOW()) > 5 
                        OR (TIMESTAMPDIFF(MINUTE, last_log_datetime, NOW()) < 5 
                        AND output_Average_Current <= 0))");
       return $this->db->select("sd.well_id, sd.flag_status, sd.effective_date_time, wm.well_name,ow.reason as temporary_reason")
            ->from('tbl_site_device_installation sd')
            ->join('tbl_well_master wm', 'sd.well_id = wm.id and wm.status=1', 'left')
            ->join('tbl_role_wise_user_assign_details ad', 'wm.site_id = ad.site_id', 'left')
            ->join('(SELECT * FROM tbl_temporary_off_well_reson_log rl INNER JOIN (SELECT MAX(id) AS max_id FROM tbl_temporary_off_well_reson_log GROUP BY well_id) latest ON rl.id = latest.max_id) latest_rl', 'latest_rl.well_id = wm.id', 'left')
            ->join('tbl_temporary_off_well ow', 'ow.id = latest_rl.reason', 'left')
            ->where(['sd.status' => 1, 'sd.device_shifted' => 0, 'ad.status' => 1, 'sd.flag_status' => 1])
            ->group_by('sd.id')
            ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
            ->get()
            ->result_array();
    }


    public function faulty_Well_List($company_id, $assets_id, $area_id, $site_id, $user_id)
    {
        if ($company_id !== '') {
            $this->db->where('sd.company_id', $company_id);
        }
        if ($assets_id !== '') {
            $this->db->where('sd.assets_id', $assets_id);
        }
        if ($area_id !== '') {
            $this->db->where('sd.area_id', $area_id);
        }
        if ($site_id !== '') {
            $this->db->where('sd.site_id', $site_id);
        }
        if ($user_id !== '') {
            $this->db->where('ad.user_id', $user_id);
           
        }

        $currentTime = date("H:i:s");
         $this->db->where("(TIMESTAMPDIFF(MINUTE, sd.last_log_datetime, NOW()) < 5)");
        return $this->db->select("sd.well_id,sd.olr_status,sd.elr_status,sd.spp_status, sd.output_Average_Current, sd.output_Average_Voltage_P2P, sd.last_log_datetime, wm.well_name")
            ->from('tbl_site_device_installation sd')
            ->join('tbl_well_configuration wc', 'sd.well_id = wc.well_id and wc.status = 1', 'left')
            ->join('tbl_well_master wm', 'sd.well_id = wm.id', 'left')
            ->join('tbl_role_wise_user_assign_details ad', 'sd.site_id = ad.site_id', 'left')
            ->where(['sd.status' => 1,'sd.device_shifted'=>0,'ad.status'=>1,'sd.flag_status'=>0])
            ->group_start()
                ->where("(
                     (sd.output_Average_Current <= 0 AND sd.output_Average_Voltage_P2P > 200 AND (
                        (wc.well_type = 0 AND (wc.start_time IS NULL OR (wc.start_time <= '$currentTime' AND wc.stop_time >= '$currentTime'))) OR
                        (wc.well_type = 1 AND wc.start_time <= '$currentTime' AND wc.stop_time >= '$currentTime')
                    ))
                )")
            ->group_end()
            ->group_by('sd.id')
            ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
            ->get()
            ->result_array();
    }


    public function powerCut_Well_List($company_id, $assets_id, $area_id, $site_id, $user_id)
    {
        if ($company_id !== '') {
            $this->db->where('sd.company_id', $company_id);
        }
        if ($assets_id !== '') {
            $this->db->where('sd.assets_id', $assets_id);
        }
        if ($area_id !== '') {
            $this->db->where('sd.area_id', $area_id);
        }
        if ($site_id !== '') {
            $this->db->where('sd.site_id', $site_id);
        }
        if ($user_id !== '') {
            $this->db->where('ad.user_id', $user_id);
           
        }

        $currentTime = date("H:i:s");
           $this->db->where("(TIMESTAMPDIFF(MINUTE, sd.last_log_datetime, NOW()) < 5)");
        return $this->db->select("sd.well_id, sd.output_Average_Current, sd.output_Average_Voltage_P2P, sd.last_log_datetime, wm.well_name")
            ->from('tbl_site_device_installation sd')
            ->join('tbl_well_configuration wc', 'sd.well_id = wc.well_id and wc.status = 1', 'left')
            ->join('tbl_well_master wm', 'sd.well_id = wm.id', 'left')
            ->join('tbl_role_wise_user_assign_details ad', 'sd.site_id = ad.site_id', 'left')
            ->where(['sd.status' => 1,'sd.device_shifted'=>0,'ad.status'=>1,'sd.flag_status'=>0])
            ->group_start()
                ->where("(
                     (sd.output_Average_Current <= 0 AND sd.output_Average_Voltage_P2P < 200 AND(
                            (wc.well_type = 0 AND (wc.start_time IS NULL OR (wc.start_time <= '$currentTime' AND wc.stop_time >= '$currentTime'))) OR
                            (wc.well_type = 1 AND wc.start_time <= '$currentTime' AND wc.stop_time >= '$currentTime')
                        ))
                )")
            ->group_end()
            ->group_by('sd.id')
            ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
            ->get()
            ->result_array();
    }

    public function Timer_offWell_List($company_id, $assets_id, $area_id, $site_id, $user_id)
    {

        if ($company_id !== '') {
            $this->db->where('sd.company_id', $company_id);
        }
        if ($assets_id !== '') {
            $this->db->where('sd.assets_id', $assets_id);
        }
        if ($area_id !== '') {
            $this->db->where('sd.area_id', $area_id);
        }
        if ($site_id !== '') {
            $this->db->where('sd.site_id', $site_id);
        }
        if ($user_id !== '') {
            $this->db->where('ad.user_id', $user_id);
        }

        $currentTime = date('H:i:s');
        // print_r($currentTime);

 
        $timeRanges = $this->db->select('GROUP_CONCAT(DISTINCT wc.start_time ORDER BY wc.c_date DESC) as start_time, GROUP_CONCAT(DISTINCT wc.stop_time ORDER BY wc.c_date DESC) as stop_time,sd.well_id, sd.output_Average_Current, sd.output_Average_Voltage_P2P, sd.last_log_datetime, wm.well_name')
            ->from('tbl_site_device_installation sd')
            ->join('tbl_well_configuration wc', 'wc.well_id = sd.well_id', 'left')
            ->join('tbl_well_master wm', 'sd.well_id = wm.id', 'left')
            ->join('tbl_role_wise_user_assign_details ad', 'sd.site_id = ad.site_id', 'left')
            ->where(['wc.status' => 1, 'wc.well_type' => 1, 'sd.output_Average_Current <=' => 0,'sd.flag_status'=>0])
            ->where("(TIMESTAMPDIFF(MINUTE, sd.last_log_datetime, NOW()) < 5)")
            ->group_by('sd.well_id')
            ->get()
            ->result_array();

        $timer_off_wells = array();

        foreach ($timeRanges as $range) {
           
            $isInRange = false;
            foreach (explode(',', $range['start_time']) as $key => $start_time) {
                $stop_times = explode(',', $range['stop_time']);
                $stop_time = isset($stop_times[$key]) ? $stop_times[$key] : end($stop_times);
                if ($currentTime >= $start_time && $currentTime <= $stop_time) {
                    $isInRange = true;
                    break;
                }
            }
          
            if (!$isInRange) {
                $timer_off_wells[] = $range;
            }
        }

        return $timer_off_wells;
   }

  public function Alert_Report($well_id, $imei_no, $from_date, $to_date, $user_id,$sort_by)
  {
        if ($well_id != '') {
            $this->db->where('sd.well_id', $well_id);
        }
        if ($imei_no != '') {
            $this->db->where('sd.imei_no', $imei_no);
        }

        if ($from_date != '' && $to_date != '') {
            $fromTime = date('Y-m-d 06:00:00', strtotime($from_date));
            if ($from_date == $to_date) {
                $toTime = date('Y-m-d 06:00:00', strtotime($to_date . '+1 day'));
            } else {
                $toTime = date('Y-m-d 06:00:00', strtotime($to_date));
            }

            $this->db->where('tl.c_date >=', $fromTime);
            $this->db->where('tl.c_date <=', $toTime);
        }

        if ($user_id != '') {
            $this->db->where('ad.user_id',$user_id);
           
        }

        if ($sort_by != '') {
            $this->db->order_by($sort_by,'ASC');
           
        }

       return   $this->db->select("tl.id,tl.alert_type,tl.alerts_details,tl.start_date_time,tl.end_date_time,sd.well_id,wm.well_name,tl.imei_no,sd.device_name,ws.well_site_name")
            ->from('tbl_alert_log tl')
            ->join('tbl_site_device_installation sd', 'sd.well_id=tl.well_id', 'left')
            ->join('tbl_well_master wm', 'sd.well_id=wm.id', 'left')
            ->join('tbl_role_wise_user_assign_details ad', 'sd.site_id = ad.site_id', 'left')
            ->join('tbl_well_site_master ws','sd.site_id=ws.id and ws.status=1','left')
            ->where(['sd.status' => 1,'wm.status'=>1,'ad.status'=>1])
            ->group_by('tl.id')
            ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
            ->get()->result_array();
    }

    public function Date_wise_Alert_Report($date,$user_id,$sort_by)
    {
        if ($date != '') 
        {
            $from_date = date('Y-m-d 06:00:00', strtotime($date));
            $to_date = date('Y-m-d 06:00:00', strtotime($date . '+1 day'));
         if ($user_id != '') {
            $this->db->where('ad.user_id',$user_id);
           
        }

        if ($sort_by != '') {
            $this->db->order_by($sort_by,'ASC');
           
        }

            return $this->db->select("al.id,al.imei_no,sd.device_name,sd.well_id,wm.well_name,al.alert_type,al.alerts_details,al.start_date_time,al.end_date_time,ws.well_site_name")
            ->from('tbl_alert_log al')
            ->join('tbl_site_device_installation sd','sd.well_id=al.well_id','left')
            ->join('tbl_role_wise_user_assign_details ad', 'sd.site_id = ad.site_id', 'left')
            ->join('tbl_well_master wm','sd.well_id=wm.id','left')
            ->join('tbl_well_site_master ws','sd.site_id=ws.id and ws.status=1','left')
            ->where(['sd.status'=>1,'ad.status'=>1,'wm.status'=>1,'al.start_date_time >='=>$from_date,'al.start_date_time <'=>$to_date])
            ->group_by('al.id')
            ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")->get()->result_array();
        }
       
    }

    public function Shifted_Well_List($company_id,$assets_id,$area_id,$site_id,$user_id)
    {

        if($company_id!='')
            $this->db->where('sd.company_id',$company_id);
        if($assets_id!='')
            $this->db->where('sd.assets_id',$assets_id);
        if($area_id!='')
            $this->db->where('sd.area_id',$area_id);
        if($site_id!='')
            $this->db->where('sd.site_id',$site_id);
        if($user_id!='')
            $this->db->where('ad.user_id',$user_id);


        return $this->db->select("sd.*,wm.well_name")
        ->from('tbl_site_device_installation sd')
        ->join('tbl_well_master wm', 'sd.well_id = wm.id', 'left')
        ->join('tbl_role_wise_user_assign_details ad', 'sd.site_id = ad.site_id', 'left')
        ->where(['sd.status'=>1,'sd.device_shifted'=>1])
        ->group_by('sd.well_id')
        ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")->get()->result_array();
       
    }

}
?>