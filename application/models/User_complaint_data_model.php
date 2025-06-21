<?php
class User_complaint_data_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}


	public function get_well_details($well_id)
	{
		if($well_id!='')
			$this->db->where('well_id',$well_id);
		return $this->db->select('sd.device_name,sd.imei_no,sd.date_of_installation')
		                ->from('tbl_site_device_installation sd')
		                ->join('tbl_well_master wm','sd.well_id=wm.id','left')
		                ->where(['sd.status'=>1,'sd.device_shifted'=>0,'wm.status'=>1])
		                ->get()->result_array();
	}

	public function get_ticket_id()
    {
        $this->db->select('ticket_id')
             ->from('tbl_technical_complaint')
             ->order_by('c_date', 'desc') 
             ->limit(1);

    return $this->db->get()->row_array();
    
    }

	public function getCOMId()
	{
		 return $this->db->select("UUID()")->get()->result_array();
	}

	public function getCOMlogId()
	{
		return $this->db->select("UUID()")->get()->result_array();
	}

	public function Save_complaint($data)
	{
		$this->db->insert('tbl_technical_complaint',$data);
		
	}

	public function Save_complaint_log($data)
	{
		$this->db->insert('tbl_technical_complaint_log',$data);
		
	}


	public function get_complaint_details($company_id,$user_id,$from_date,$to_date,$ticket_id,$complaint_status)
	{
		if($company_id!='')
			$this->db->where('tc.company_id',$company_id);

		if($user_id!='')
			$this->db->where('ad.user_id',$user_id);

		if($from_date!='' && $to_date!='')
			$this->db->where(['date(tc.c_date)>='=>$from_date,'date(tc.c_date)<='=>$to_date]);
		if($ticket_id!='')
			$this->db->where('tc.ticket_id',$ticket_id);

		if($complaint_status!='')
		   $this->db->where('tc.complaint_status',$complaint_status);


	     return $this->db->select("tc.*,wm.well_name")
		->from('tbl_technical_complaint tc')
		->join('tbl_well_master wm','tc.well_id=wm.id','left')
		->join('tbl_role_wise_user_assign_details ad','ad.site_id=wm.site_id','left')
		->where(['tc.status'=>1,'wm.status'=>1])
		->group_by('tc.ticket_Id, wm.well_name')
		->order_by("CAST(SUBSTRING_INDEX(tc.ticket_Id, '#', -1) AS UNSIGNED) ASC")->get()->result_array();

	}

	public function get_complaint_ticket_details($company_id, $area_id, $from_date, $to_date, $ticket_id, $complaint_status,$sort_by)
    {
	    if ($company_id != '')
	        $this->db->where('tc.company_id', $company_id);

	    if ($area_id != '')
	        $this->db->where('ws.id', $area_id);

	    if ($from_date != '' && $to_date != '')
	        $this->db->where(['date(tc.c_date) >=' => $from_date, 'date(tc.c_date) <=' => $to_date]);
	    if ($ticket_id != '')
	        $this->db->where('tc.ticket_id', $ticket_id);

	    if ($complaint_status != '')
	        $this->db->where('tc.complaint_status', $complaint_status);

	    if($sort_by != '') 
            $this->db->order_by($sort_by, 'ASC');


	    $result = $this->db->select("tc.*, wm.well_name,GROUP_CONCAT(CONCAT(om.user_full_name, ' (', om.userId, ')') ORDER BY tl.c_date ASC) AS user_data ")
	        ->from('tbl_technical_complaint tc')
	        ->join('tbl_technical_complaint_log tl', 'tc.ticket_id=tl.ticket_id', 'left')
	        ->join('tbl_site_device_installation sd', 'tc.well_id=sd.well_id', 'left')
	        ->join('tbl_well_master wm', 'tc.well_id=wm.id', 'left')
	        ->join('tbl_area_master ws', 'ws.id=sd.area_id and ws.status =1', 'left')
	        ->join('tbl_ongc_member_master om', 'om.id=tl.c_by and om.status=1', 'left')
	        ->where(['tc.status' => 1,'tl.status'=>1 ,'wm.status' => 1])
	        ->group_by('tc.ticket_Id, wm.well_name')
	        ->order_by("CAST(SUBSTRING_INDEX(tc.ticket_Id, '#', -1) AS UNSIGNED) desc")
	        ->get()->result_array();

   
	    foreach ($result as &$row) {
	        $user_data_array = explode(',', $row['user_data']);
	       
	        $row['raised_user_name'] = isset($user_data_array[0]) ? $user_data_array[0] : '';
	        $row['progress_name'] = isset($user_data_array[1]) ? $user_data_array[1] : '';
	        $row['sloved_name'] = isset($user_data_array[2]) ? $user_data_array[2] : '';
	        
	    }

        return $result;
    }


	public function get_complaint_log($company_id,$user_id,$from_date,$to_date,$ticket_id,$well_id)
	{
		if($company_id!='')
			$this->db->where('tc.company_id',$company_id);

		if($user_id!='')
			$this->db->where('ad.user_id',$user_id);

		if($from_date!='' && $to_date!='')
			$this->db->where(['date(tc.c_date)>='=>$from_date,'date(tc.c_date)<='=>$to_date]);
		if($ticket_id!='')
			$this->db->where('tc.ticket_id',$ticket_id);
		if($well_id!='')
			$this->db->where('tc.well_id',$well_id);


	     $result['complaint_timeline'] = $this->db->select("tc.complaint_status,tc.ticket_id,tc.c_date,,wm.well_name,tc.c_by,CONCAT(om.user_full_name, ' (', om.userId, ')') AS user_data")
		->from('tbl_technical_complaint_log tc')
		->join('tbl_well_master wm','tc.well_id=wm.id','left')
		->join('tbl_role_wise_user_assign_details ad','ad.well_id=wm.id','left')
		->join('tbl_ongc_member_master om','om.id=tc.c_by','left')
		->where(['tc.status'=>1,'wm.status'=>1])
		->group_by('tc.id')
		->order_by("CAST(SUBSTRING_INDEX(tc.ticket_Id, '#', -1) AS UNSIGNED) ASC")->order_by('tc.c_date','asc')->get()->result_array();

		if($ticket_id!='')
			$this->db->where('tc.ticket_id',$ticket_id);

		$result['complaint_resolution'] = $this->db->select("tc.ticket_id,tc.c_date,tc.d_date,wm.well_name")
		->from('tbl_technical_complaint tc')
		->join('tbl_well_master wm','tc.well_id=wm.id','left')
		->join('tbl_role_wise_user_assign_details ad','ad.well_id=wm.id','left')
		->where(['tc.status'=>1,'wm.status'=>1,'tc.complaint_status'=>2])
		->group_by('tc.id')
		->order_by("CAST(SUBSTRING_INDEX(tc.ticket_Id, '#', -1) AS UNSIGNED) ASC")->order_by('tc.c_date','desc')->get()->result_array();

		return $result;

	}

	public function Update_status_complaint($data,$where)
	{
		return $this->db->update('tbl_technical_complaint',$data,$where);
	}

	public function get_complaint_details_list($company_id,$user_id,$id,$ticket_id)
	{
		if($company_id!='')
			$this->db->where('tc.company_id',$company_id);
		if($user_id!='')
			$this->db->where('ad.user_id',$user_id);
		if($id!='')
			$this->db->where('tc.id',$id);
		if($ticket_id!='')
			$this->db->where('tc.ticket_id',$ticket_id);
		return $this->db->select("tc.*,wm.well_name")
		->from('tbl_technical_complaint tc')
		->join('tbl_well_master wm','tc.well_id=wm.id','left')
		->join('tbl_role_wise_user_assign_details ad', 'wm.id= ad.well_id', 'left')
		->where(['tc.status'=>1,'wm.status'=>1])
		->group_by('tc.id')
		->order_by("CAST(SUBSTRING_INDEX(tc.ticket_Id, '#', -1) AS UNSIGNED) desc")->get()->result_array();

	}

	public function get_total_complaints($company_id,$user_id,$from_date,$to_date,$ticket_id,$complaint_status)
	{
		if($company_id!='')
			$this->db->where('wm.company_id',$company_id);
		if($user_id!='')
			$this->db->where('ad.user_id',$user_id);
		if($from_date!='' && $to_date!='')
			$this->db->where(['date(tc.c_date)>='=>$from_date,'date(tc.c_date)<='=>$to_date]);
		if($ticket_id!='')
			$this->db->where('tc.ticket_id',$ticket_id);
		if($complaint_status!='')
		   $this->db->where('tc.complaint_status',$complaint_status);

		$result = $this->db->select('count(distinct tc.ticket_id)  as total_complaint')
		                   ->from('tbl_technical_complaint tc')
		                   ->join('tbl_well_master wm','tc.well_id=wm.id','left')
		                   ->join('tbl_role_wise_user_assign_details ad', 'wm.id= ad.well_id', 'left')
		                   ->where(['tc.status'=>1,'tc.complaint_status'=>0])
		                   ->get()->result_array();
		if(!empty($result))
        {
            return $result[0]['total_complaint'];
        }else{
            return 0;
        }

	}

	public function get_total_inprogress($company_id,$user_id,$from_date,$to_date,$ticket_id,$complaint_status)
	{
		if($company_id!='')
			$this->db->where('wm.company_id',$company_id);
		if($user_id!='')
			$this->db->where('ad.user_id',$user_id);
		if($from_date!='' && $to_date!='')
			$this->db->where(['date(tc.c_date)>='=>$from_date,'date(tc.c_date)<='=>$to_date]);
		if($ticket_id!='')
			$this->db->where('tc.ticket_id',$ticket_id);
		if($complaint_status!='')
		   $this->db->where('tc.complaint_status',$complaint_status);


		$result = $this->db->select('count(distinct tc.ticket_id)  as total_complaint')
		                   ->from('tbl_technical_complaint tc')
		                   ->join('tbl_well_master wm','tc.well_id=wm.id','left')
		                   ->join('tbl_role_wise_user_assign_details ad', 'wm.id= ad.well_id', 'left')
		                   ->where(['tc.status'=>1,'tc.complaint_status'=>1])->get()->result_array();
		if(!empty($result))
        {
            return $result[0]['total_complaint'];
        }else{
            return 0;
        }

	}

	public function get_total_solved($company_id,$user_id,$from_date,$to_date,$ticket_id,$complaint_status)
	{
		if($company_id!='')
			$this->db->where('wm.company_id',$company_id);
		if($user_id!='')
			$this->db->where('ad.user_id',$user_id);
		if($from_date!='' && $to_date!='')
			$this->db->where(['date(tc.c_date)>='=>$from_date,'date(tc.c_date)<='=>$to_date]);
		if($ticket_id!='')
			$this->db->where('tc.ticket_id',$ticket_id);
		if($complaint_status!='')
		   $this->db->where('tc.complaint_status',$complaint_status);


		$result = $this->db->select('count(distinct tc.ticket_id)  as total_complaint')
		                   ->from('tbl_technical_complaint tc')
		                   ->join('tbl_well_master wm','tc.well_id=wm.id','left')
		                   ->join('tbl_role_wise_user_assign_details ad', 'wm.id= ad.well_id', 'left')
		                   ->where(['tc.status'=>1,'tc.complaint_status'=>2])->get()->result_array();
		if(!empty($result))
        {
            return $result[0]['total_complaint'];
        }else{
            return 0;
        }

	}

	public function get_ticket_details($ticket_id)
	{
		return $this->db->select('well_id,ticket_id,device_name,imei_no,date_of_installation,complaint_status')->from('tbl_technical_complaint')->where(['ticket_id'=>$ticket_id])->get()->result_array();

	}


	public function get_complaint_log_data($company_id, $site_id, $from_date, $to_date, $ticket_id, $well_id,$sort_by)
    {
	    if ($company_id != '')
	        $this->db->where('tc.company_id', $company_id);

	    if ($site_id != '')
	        $this->db->where('ws.id', $site_id);

	    if ($from_date != '' && $to_date != '')
	        $this->db->where(['date(ta.c_date) >=' => $from_date, 'date(ta.c_date) <=' => $to_date]);

	    if ($ticket_id != '')
	        $this->db->where('tc.ticket_id', $ticket_id);

	    if ($well_id != '')
	        $this->db->where('tc.well_id', $well_id);

	    if ($sort_by != '') 
            $this->db->order_by($sort_by, 'ASC');

	    return $this->db->select("tc.ticket_id, tc.device_name, tc.imei_no, tc.resolution_description, tc.complaint_type, tc.complaint_description, GROUP_CONCAT(CONCAT(tc.c_date) ORDER BY tc.c_date ASC) AS complaint_date, GROUP_CONCAT(CONCAT(tc.complaint_status) ORDER BY tc.c_date ASC) AS complaint_status, wm.well_name")
	        ->from('tbl_technical_complaint_log tc')
	        ->join('tbl_technical_complaint ta','ta.ticket_id=tc.ticket_id','left')
	        ->join('tbl_site_device_installation sd', 'tc.well_id=sd.well_id', 'left')
	        ->join('tbl_well_master wm', 'tc.well_id=wm.id', 'left')
	        ->join('tbl_well_site_master ws', 'ws.id=sd.site_id and ws.status =1', 'left')
	        ->where(['tc.status' => 1, 'wm.status' => 1])
	        ->group_by('tc.ticket_Id, wm.well_name')
	        ->order_by("CAST(SUBSTRING_INDEX(tc.ticket_Id, '#', -1) AS UNSIGNED) desc")
	        ->order_by('ta.c_date', 'desc')
	        ->get()
	        ->result_array();
    }
	
}
?>