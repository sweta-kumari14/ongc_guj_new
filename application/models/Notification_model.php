<?php
class Notification_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function Mobile_Notification_Report($imei_no,$from_date,$to_date,$user_id)
	{

	    if($imei_no != '')
	        $this->db->where('al.imei_no', $imei_no);

	    if ($from_date != '' && $to_date != '') {

	        $from_datetime = date('Y-m-d', strtotime($from_date)) . ' 06:00:00';
	        $to_datetime = date('Y-m-d', strtotime($from_date . '+1 day')) . ' 06:00:00';

	        if ($from_date == $to_date) {
	            $to_datetime = date('Y-m-d', strtotime($to_date . '+1 day')) . ' 06:00:00';
	        }

	        $this->db->where(['al.c_date >=' => $from_datetime, 'al.c_date <' => $to_datetime]);
	    }

	      if($user_id != '')
	        $this->db->where('ad.user_id', $user_id);

	   return $this->db->select("al.imei_no,al.alert_type,al.alerts_details,DATE_FORMAT(al.start_date_time,'%d-%m-%Y %H:%i:%s') as start_date_time,DATE_FORMAT(al.end_date_time,'%d-%m-%Y %H:%i:%s') as end_date_time")
	        ->from('tbl_alert_log al')
            ->join('tbl_site_device_installation sd','al.imei_no=sd.imei_no','left')
            ->join('tbl_role_wise_user_assign_details ad','sd.well_id=ad.well_id','left')
            ->join('tbl_well_master wm','sd.well_id=wm.id','left')
            ->where(['al.status'=>1,'sd.status'=>1,'ad.status'=>1])->group_by('al.imei_no')
            ->order_by('al.start_date_time','DESC')
            ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")->get()->result_array();
	        
	}
}
?>