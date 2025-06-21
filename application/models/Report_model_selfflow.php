<?php
date_default_timezone_set('Asia/Kolkata');
class Report_model_selfflow extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	public function flag_unflag_data($site_id, $well_id, $from_date, $to_date,$status)
    {
	    if ($site_id != '')
	        $this->db->where('sd.site_id', $site_id);

	    if ($well_id != '')
	        $this->db->where('sd.well_id', $well_id);

	    if ($from_date != '' && $to_date != '')
	        $this->db->where(['date(ot.c_date) >=' => $from_date, 'date(ot.c_date) <=' => $to_date]);
	     if ($status != '')
	        $this->db->where('ot.flag_status', $status);


	    return $this->db->select("
	            ot.*, 
	            sd.site_id, 
	            tw.reason as reason_name, 
	            COALESCE(am.unique_userId, om_alt.userId) as createuser, 
	            COALESCE(amd.unique_userId, omd_alt.userId) as updateeuser, 
	            COALESCE(om.user_full_name, om_alt.user_full_name) as c_user, 
	            COALESCE(om2.user_full_name, omd_alt.user_full_name) as d_user,
	            wm.well_name
             ")
	        ->from('tbl_site_device_installtion_self_flow  sd')
	        ->join('tbl_temporary_off_well_reson_log ot', 'sd.well_id = ot.well_id', 'left')
	        ->join('tbl_temporary_off_well tw', 'ot.reason = tw.id', 'left')
	        ->join('tbl_well_master wm', 'wm.id = ot.well_id', 'left')
	        ->join('tbl_authentication_master am', 'am.id = ot.c_by', 'left')
	        ->join('tbl_authentication_master amd', 'amd.id = ot.d_by', 'left')
	        ->join('tbl_ongc_member_master om', 'am.user_member_id = om.id', 'left')
	        ->join('tbl_ongc_member_master om_alt', 'ot.c_by = om_alt.id', 'left')
	        ->join('tbl_ongc_member_master omd_alt', 'ot.d_by = omd_alt.id', 'left')
	        ->join('tbl_ongc_member_master om2', 'amd.user_member_id = om2.id', 'left')
	        ->where(['ot.status' => 1, 'sd.status' => 1])
	        ->order_by('ot.c_date DESC')
	        ->order_by("CAST(SUBSTRING_INDEX(wm.well_name, '#', -1) AS UNSIGNED) ASC")
	        ->get()
	        ->result_array();
     }
}
?>
