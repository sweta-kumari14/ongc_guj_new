<?php
   date_default_timezone_set('Asia/Kolkata');
class list_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
public function DashboardWelldetails($company_id, $assets_id, $area_id, $site_id, $user_id, $well_id, $well_type, $user_type, $role_type)
    {
        $this->db->select("
            ua.id, ua.company_id, ua.user_id, ua.assets_id, ua.area_id,
            a.area_name, sm.well_site_name, w.id as well_id, w.well_name, 
            di.id as installed_status, di.imei_no, di.device_name, 
            di.date_of_installation, di.flag_status, di.well_type, wt.well_type_name, 
            di.RTC_Time as Log_Date_Time, di.PS_1_GIP, di.PS_2_CHP, di.PS_3_THP, di.PS_4_ABP, 
            di.FLTP_1_Temp, di.Battery_Voltage, di.PSF_1, di.PSF_2, di.PSF_3, di.PSF_4, 
            di.TSF_1, di.BVF_1, di.SF_1_solenide, di.TRGT_Time, di.ON_Time, di.Off_Time, 
            di.lat, di.lng as longitude, di.passcode, di.site_id, di.well_type
        ")
        ->from('tbl_well_master w')
        ->join('tbl_site_device_installtion_self_flow di', 'di.well_id = w.id', 'left');

        // Conditional Join Based on user_type and role_type
        if ($user_type == 3 && $role_type == 6) {
            $this->db->join('tbl_role_wise_user_assign_details ua', 'w.id = ua.well_id', 'left');
            $this->db->where('ua.role_type', $role_type);
        } else {
            $this->db->join('tbl_role_wise_user_assign_details ua', 'ua.site_id = w.site_id', 'left');
        }

        $this->db->join('tbl_area_master a', 'w.area_id = a.id', 'left')
                 ->join('tbl_well_site_master sm', 'w.site_id = sm.id', 'left')
                 ->join('tbl_well_type wt', 'di.well_type = wt.id', 'left')
                 ->where(['w.status' => 1, 'di.status' => 1, 'di.device_shifted' => 0]);

        if (!empty($company_id)) $this->db->where('ua.company_id', $company_id);
        if (!empty($assets_id)) $this->db->where('ua.assets_id', $assets_id);
        if (!empty($area_id)) $this->db->where('ua.area_id', $area_id);
        if (!empty($site_id)) $this->db->where('di.site_id', $site_id);
        if (!empty($user_id)) $this->db->where('ua.user_id', $user_id);
        if (!empty($well_id)) $this->db->where('di.well_id', $well_id);
        if (!empty($well_type)) $this->db->where('di.well_type', $well_type);

        $dynamictime = ($user_type == 2 || ($user_type == 3 && $role_type == 3)) ? 900 : 7200;

        $this->db->order_by("
            CASE
                WHEN TIMESTAMPDIFF(SECOND, di.RTC_Time, NOW()) > $dynamictime OR di.RTC_Time IS NULL THEN 1
                WHEN TIMESTAMPDIFF(SECOND, di.RTC_Time, NOW()) <= $dynamictime AND di.flag_status = 1 THEN 2
                WHEN TIMESTAMPDIFF(SECOND, di.RTC_Time, NOW()) <= $dynamictime AND di.flag_status = 0 THEN 3
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
                    $status_variable = ($row['flag_status'] == 0) ? 'Offline_well' : 'non_flowing_well';
                }
            }
            $row['status_variable'] = $status_variable;
        }

        return $result;
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

        $res = $this->db->select("count(distinct well_id) as total")->from('tbl_site_device_installtion_self_flow')->where(['status'=>1,'device_shifted'=>0])->get()->result_array();

        if(!empty($res))
        {
            return $res[0]['total'];
        }else{
            return 0;
        }
    }
      public function Totalwell($company_id, $area_id, $well_id, $well_type, $site_id, $user_type, $role_type)
    {
        $this->db->select("count(distinct wm.id) as total")
             ->from('tbl_well_master wm')
             ->join(' tbl_site_device_installtion_self_flow  sd', 'wm.id = sd.well_id', 'left');
        if ($user_type == 3 && $role_type == 6) {
            $this->db->join('tbl_role_wise_user_assign_details rwua', 'rwua.well_id = wm.id', 'left');
            $this->db->where('rwua.role_type', $role_type); 
        }
        if ($company_id != '')
            $this->db->where('wm.company_id', $company_id);
        if ($area_id != '')
            $this->db->where('wm.area_id', $area_id);
        if ($well_id != '')
            $this->db->where('wm.id', $well_id);
        if ($well_type != '')
            $this->db->where('sd.well_type', $well_type);
        if ($site_id != '')
            $this->db->where('sd.site_id', $site_id);
           
        $this->db->where(['wm.status' => 1,'sd.status' => 1,'sd.device_shifted' => 0]);

        $res = $this->db->get()->result_array();

        if (!empty($res)) {
            return $res[0]['total'];
        } else {
            return 0;
        }
    }


 public function Flowing_Well($company_id, $assets_id, $area_id, $user_id, $well_id, $well_type, $site_id, $user_type, $role_type)
    {
        $this->db->from('tbl_site_device_installtion_self_flow di');

        if ($user_type == 3 && $role_type == 6) {
            $this->db->join('tbl_role_wise_user_assign_details ad', 'di.well_id = ad.well_id', 'left');
            $this->db->where('ad.role_type', $role_type);
        } else {
            $this->db->join('tbl_role_wise_user_assign_details ad', 'di.site_id = ad.site_id', 'left');
        }

        if ($company_id != '')
            $this->db->where('di.company_id', $company_id);
        if ($assets_id != '')
            $this->db->where('di.assets_id', $assets_id);
        if ($area_id != '')
            $this->db->where('di.area_id', $area_id);
        if ($user_id != '')
            $this->db->where('ad.user_id', $user_id);
        if ($well_id != '')
            $this->db->where('di.well_id', $well_id);
        if ($well_type != '')
            $this->db->where('di.well_type', $well_type);
        if ($site_id != '')
            $this->db->where('di.site_id', $site_id);

        if ($user_type == 2 || ($user_type == 3 && $role_type == 3)) {
            $this->db->where("(TIMESTAMPDIFF(MINUTE, RTC_Time, NOW()) < 15)");
        } else {
            $this->db->where("(TIMESTAMPDIFF(MINUTE, RTC_Time, NOW()) < 120)");
        }

        $this->db->join('tbl_area_master am', 'di.area_id = am.id and am.status=1', 'left');
        $this->db->join('tbl_well_site_master wm', 'di.site_id = wm.id and wm.status=1', 'left');
        $this->db->join('tbl_well_master wmm', 'di.well_id = wmm.id and wm.status=1', 'left');
        $this->db->join('tbl_well_type wt', 'di.well_type = wt.id and wt.status=1', 'left');
        $this->db->where([
            'di.status' => 1,
            'ad.status' => 1
        ]);

        $this->db->group_by('di.id');

        return $this->db->select("di.well_id, wmm.well_name, di.RTC_Time as Log_Date_Time, di.PS_1_GIP, di.PS_3_THP, di.PS_2_CHP, di.PS_4_ABP, di.FLTP_1_Temp, di.Battery_Voltage, di.PSF_1, di.PSF_2, di.PSF_3, di.PSF_4, di.TSF_1, di.BVF_1, di.SF_1_solenide, di.TRGT_Time, di.ON_Time, di.Off_Time, am.area_name, wm.well_site_name, wt.well_type_name, di.lat, di.long as long, di.passcode, di.site_id, di.well_type, di.area_id, di.device_name, di.imei_no")
            ->get()
            ->result_array();
    }
      public function Non_Flowing_Well($company_id, $assets_id, $area_id, $user_id, $well_id, $well_type, $site_id, $user_type, $role_type)
    {
        $this->db->from('tbl_site_device_installtion_self_flow di');

        if ($user_type == 3 && $role_type == 6) {
            $this->db->join('tbl_role_wise_user_assign_details ad', 'di.well_id = ad.well_id', 'left');
            $this->db->where('ad.role_type', $role_type);
        } else {
            $this->db->join('tbl_role_wise_user_assign_details ad', 'di.site_id = ad.site_id', 'left');
        }

        if ($company_id != '')
            $this->db->where('di.company_id', $company_id);
        if ($assets_id != '')
            $this->db->where('di.assets_id', $assets_id);
        if ($area_id != '')
            $this->db->where('di.area_id', $area_id);
        if ($user_id != '')
            $this->db->where('ad.user_id', $user_id);
        if ($well_id != '')
            $this->db->where('di.well_id', $well_id);
        if ($well_type != '')
            $this->db->where('di.well_type', $well_type);
        if ($site_id != '')
            $this->db->where('di.site_id', $site_id);
        if ($user_type == 2 || ($user_type == 3 && $role_type == 3)) {
            $this->db->where("(TIMESTAMPDIFF(MINUTE, RTC_Time, NOW()) > 15)");
        } else {
            $this->db->where("(TIMESTAMPDIFF(MINUTE, RTC_Time, NOW()) > 120)");
        }

        $this->db->join('tbl_area_master am', 'di.area_id = am.id and am.status=1', 'left');
        $this->db->join('tbl_well_site_master wm', 'di.site_id = wm.id and wm.status=1', 'left');
        $this->db->join('tbl_well_master wmm', 'di.well_id = wmm.id and wm.status=1', 'left');
        $this->db->join('tbl_well_type wt', 'di.well_type = wt.id and wt.status=1', 'left');

        $this->db->where([
            'di.status' => 1,
            'ad.status' => 1,
            'di.flag_status' => 1 
        ]);

        $this->db->group_by('di.id');

        return $this->db->select("di.well_id, wmm.well_name, di.RTC_Time as Log_Date_Time, di.PS_1_GIP, di.PS_3_THP, di.PS_2_CHP, di.PS_4_ABP, di.FLTP_1_Temp, di.Battery_Voltage, di.PSF_1, di.PSF_2, di.PSF_3, di.PSF_4, di.TSF_1, di.BVF_1, di.SF_1_solenide, di.TRGT_Time, di.ON_Time, di.Off_Time, am.area_name, wm.well_site_name, wt.well_type_name, di.lat, di.long as long, di.passcode, di.site_id, di.well_type, di.area_id, di.device_name, di.imei_no")
            ->get()
            ->result_array();
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
       
        $this->db->where("(TIMESTAMPDIFF(SECOND, sd.Log_Date_Time , NOW()) < 300 AND sd.Log_Date_Time  IS NOT NULL)");

        return $this->db->select("sd.*, wm.well_name")
            ->from('tbl_site_device_installtion_self_flow sd')
            ->join('tbl_well_master wm', 'sd.well_id = wm.id', 'left')
            ->where(['sd.status' => 1,'sd.device_shifted'=>0])
            ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
            ->get()
            ->result_array();
    }

public function NonFunctional_RTMS_List($company_id, $assets_id, $area_id, $site_id, $user_id)
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

    $this->db->where("(TIMESTAMPDIFF(SECOND, sd.Log_Date_Time , NOW()) > 300 OR sd.Log_Date_Time IS NULL)");

    return $this->db->select("sd.*, wm.well_name, am.area_name, sm.well_site_name, wt.well_type_name")
        ->from('tbl_site_device_installtion_self_flow sd')
        ->join('tbl_well_master wm', 'sd.well_id = wm.id', 'left')
        ->join('tbl_area_master am', 'sd.area_id = am.id', 'left')
        ->join('tbl_well_site_master sm', 'sd.site_id = sm.id', 'left')
        ->join('tbl_well_type wt', 'sd.well_type = wt.id', 'left')
        ->join('tbl_role_wise_user_assign_details ad', 'wm.id = ad.well_id', 'left')
        ->where(['sd.status' => 1, 'sd.device_shifted' => 0, 'ad.status' => 1, 'sd.flag_status' => 0])
        ->group_by('sd.well_id')
        ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
        ->get()
        ->result_array();
}


}
?>