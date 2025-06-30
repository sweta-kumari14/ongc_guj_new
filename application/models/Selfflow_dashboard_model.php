<?php
date_default_timezone_set('Asia/Kolkata');
class Selfflow_dashboard_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function Totalwell_self_flow($company_id,$assets_id,$area_id,$site_id,$well_id,$feeder_id)
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

        $res = $this->db->select("count(distinct wm.id) as total")
                        ->from('tbl_well_master wm')
                        ->join('tbl_site_device_installtion_self_flow sd','wm.id=sd.well_id','left')
                        ->where(['wm.status'=>1,'sd.status'=>1,'sd.well_setup_status'=>1])
                        ->get()
                        ->result_array();
                      

        if(!empty($res))
        {
            return $res[0]['total'];
        }else{
            return 0;
        }
    }

    public function Total_flowing_well($company_id,$assets_id,$area_id,$site_id,$well_id,$feeder_id)
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
            $this->db->where('id',$well_id);
        if ($feeder_id != '') {
            $this->db->where('feeder_id', $feeder_id);
        }

        $this->db->where("(TIMESTAMPDIFF(MINUTE, Log_Date_Time, NOW()) < 5)");

        $res = $this->db->select("count(distinct well_id) as total")->from('tbl_site_device_installtion_self_flow')->where(['status'=>1,'well_setup_status'=>1])->get()->result_array();

                      
        if(!empty($res))
        {
            return $res[0]['total'];
        }else{
            return 0;
        }
    }
    public function Total_not_flowing_well($company_id,$assets_id,$area_id,$site_id,$well_id,$feeder_id)
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

       $this->db->where("(TIMESTAMPDIFF(MINUTE, Log_Date_Time, NOW()) > 5 OR Log_Date_Time IS NULL)");


        $res = $this->db->select("count(distinct well_id) as total")->from('tbl_site_device_installtion_self_flow')->where(['status'=>1,'well_setup_status'=>1,'well_status'=>1])->get()->result_array();

        if(!empty($res))
        {
            return $res[0]['total'];
        }else{
            return 0;
        }
    }

     public function Total_rtms_flowing_Well($company_id, $assets_id, $area_id, $site_id, $well_id, $feeder_id)
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
              $this->db->where("(TIMESTAMPDIFF(MINUTE, Log_Date_Time, NOW()) > 20 OR Log_Date_Time IS NULL)");


        $res = $this->db->select("count(distinct well_id) as total")->from('tbl_site_device_installtion_self_flow')->where(['status'=>1,'well_setup_status'=>1,'well_status'=>1])->get()->result_array();

        if(!empty($res))
        {
            return $res[0]['total'];
        }else{
            return 0;
        }
    }


    public function getWelllist($company_id,$assets_id,$area_id,$user_id,$well_id,$site_id,$feeder_id)
    {
        if($company_id!='')
            $this->db->where('wm.company_id',$company_id);
        if($assets_id!='')
            $this->db->where('wm.assets_id',$assets_id);
        if($area_id!='')
            $this->db->where('wm.area_id',$area_id);
        if($user_id!='')
            $this->db->where('ad.user_id',$user_id);
        if($well_id!='')
            $this->db->where('ad.well_id',$well_id);
         if($site_id!='')
            $this->db->where('ws.id',$site_id);
        if($feeder_id!='')
            $this->db->where('sd.feeder_id',$feeder_id);

        return $this->db->select("wm.id as well_id,wm.assets_id,wm.area_id,sd.site_id,wm.well_name,ad.user_id,sd.device_name,sd.imei_no,ws.well_site_name")
                ->from('tbl_well_master wm')
                ->join('tbl_site_device_installtion_self_flow sd','wm.id=sd.well_id','left')
                ->join('tbl_well_site_master ws','ws.id=sd.site_id','left')
                ->join('tbl_role_wise_user_assign_details ad','wm.site_id=ad.site_id and ad.status =1','left')
                ->where(['wm.status'=>1,'ad.status'=>1,'sd.status'=>1])
                ->group_by('wm.id')
                ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")->get()->result_array();
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

    public function DashboardWelldetails($company_id, $assets_id, $area_id, $site_id, $user_id, $well_id, $well_type)
    {
        $this->db->select("
            ua.id, ua.company_id, ua.user_id, ua.assets_id, ua.area_id,
            a.area_name, sm.well_site_name, w.id as well_id, w.well_name, 
            di.id as installed_status, di.imei_no, di.device_name, 
            di.date_time, di.well_status as flag_status, di.well_type, wt.well_type_name, 
            di.RTC_Time as Log_Date_Time, di.PS_1_GIP, di.PS_2_CHP, di.PS_3_THP, di.PS_4_ABP, 
            di.FLTP_1_Temp, di.Battery_Voltage, di.PSF_1, di.PSF_2, di.PSF_3, di.PSF_4, 
            di.TSF_1, di.BVF_1, di.SF_1_solenide, di.TRGT_Time, di.ON_Time, di.Off_Time, 
         di.passcode, di.site_id, di.well_type
        ")
        ->from('tbl_well_master w')
        ->join('tbl_site_device_installtion_self_flow di', 'di.well_id = w.id', 'left')
        ->join('tbl_role_wise_user_assign_details ua', 'ua.site_id = w.site_id', 'left');
        $this->db->join('tbl_area_master a', 'w.area_id = a.id', 'left')
                 ->join('tbl_well_site_master sm', 'w.site_id = sm.id', 'left')
                 ->join('tbl_well_type wt', 'di.well_type = wt.id', 'left')
                 ->where(['w.status' => 1, 'di.status' => 1, 'di.well_setup_status' => 1]);

        if (!empty($company_id)) $this->db->where('ua.company_id', $company_id);
        if (!empty($assets_id)) $this->db->where('ua.assets_id', $assets_id);
        if (!empty($area_id)) $this->db->where('ua.area_id', $area_id);
        if (!empty($site_id)) $this->db->where('di.site_id', $site_id);
        if (!empty($user_id)) $this->db->where('ua.user_id', $user_id);
        if (!empty($well_id)) $this->db->where('di.well_id', $well_id);
        if (!empty($well_type)) $this->db->where('di.well_type', $well_type);

        $dynamictime = 7200;

        $this->db->order_by("
            CASE
                WHEN TIMESTAMPDIFF(SECOND, di.RTC_Time, NOW()) > $dynamictime OR di.RTC_Time IS NULL THEN 1
                WHEN TIMESTAMPDIFF(SECOND, di.RTC_Time, NOW()) <= $dynamictime AND di.well_status = 2 THEN 2
                WHEN TIMESTAMPDIFF(SECOND, di.RTC_Time, NOW()) <= $dynamictime AND di.well_status = 1 THEN 3
            END
        ", '', false);

        $this->db->order_by("SUBSTRING_INDEX(w.well_name, '-', 1) ASC", '', false);
        $this->db->order_by("CAST(SUBSTRING_INDEX(w.well_name, '-', -1) AS UNSIGNED) ASC", '', false);
        $this->db->group_by('w.id');

        $result = $this->db->get()->result_array();

        foreach ($result as &$row) {
            $status_variable = 'Offline_well';  
            if (!empty($row['Log_Date_Time'])) {
                $current_date_time = time(); 
                $last_log_timestamp = strtotime($row['Log_Date_Time']);
                $time_diff_seconds = $current_date_time - $last_log_timestamp; 

                if ($time_diff_seconds <= $dynamictime) {  
                    $status_variable = 'flowing_well';
                } else {  
                    $status_variable = ($row['well_status'] == 1) ? 'Offline_well' : 'non_flowing_well';
                }
            }
            $row['status_variable'] = $status_variable;
        }

        return $result;
    }
     public function getSite_for_Map($company_id, $assets_id, $area_id, $user_id, $well_id, $well_type,$site_id)
    {
        $this->db->select("w.id as well_id, w.company_id, w.assets_id, w.area_id, am.area_name, w.site_id, ws.well_site_name, w.well_name, w.lat, w.long, sd.id as installed_status, sd.RTC_Time as Log_Date_Time, sd.well_status as flag_status, sd.well_type")
            ->from('tbl_well_master w')
            ->join('tbl_area_master am', 'w.area_id = am.id', 'left')
            ->join('tbl_well_site_master ws', 'w.site_id = ws.id', 'left')
            ->join('tbl_site_device_installtion_self_flow sd', 'sd.well_id = w.id', 'left')
            ->join('tbl_role_wise_user_assign_details ad', 'w.area_id = ad.area_id', 'left');
        if ($company_id != '')
            $this->db->where('w.company_id', $company_id);
        if ($assets_id != '')
            $this->db->where('w.assets_id', $assets_id);
        if ($area_id != '')
            $this->db->where('w.area_id', $area_id);
        if ($well_id != '')
            $this->db->where('w.id', $well_id);
        if ($user_id != '')
            $this->db->where('ad.user_id', $user_id);
        if ($well_type != '')
            $this->db->where('sd.well_type', $well_type);
        if ($site_id != '')
            $this->db->where('sd.site_id', $site_id);

        $this->db->where(['w.status' => 1,'ad.status' => 1,'sd.status' => 1]);
        return $this->db->group_by('w.id')->get()->result_array();
    }
}
?>