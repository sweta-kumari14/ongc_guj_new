<?php
class Maintance_well_details_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function Save_Maintance($data)
	{
		return $this->db->insert('tbl_maintance_well_issue_master',$data);
	}

	public function Save_Maintancelog($data)
	{
		return $this->db->insert('tbl_maintance_well_issue_log',$data);


	}

	public function Update_status_maintance($data,$where)
	{
		return $this->db->update('tbl_maintance_well_issue_master',$data,$where);
	}


	public function MaintanceList($maintance_id,$well_id,$from_date,$to_date,$case_status,$user_id)
	{
		if($maintance_id!='')
			$this->db->where('mw.maintance_id=',$maintance_id);
		if($well_id!='')
			$this->db->where('mw.well_id=',$well_id);
		if($case_status!='')
			$this->db->where('mw.issue_status=',$case_status);
		 if ($user_id != '') 
		 {
	        $this->db->group_start()
	                 ->where('mw.c_by', $user_id)
	                 ->or_where('mw.c_by', 'system_generate')
	                 ->group_end();
        }
		if($from_date!='' && $to_date!='')
			$this->db->where(['date(mw.c_date)>='=>$from_date,'date(mw.c_date)<='=>$to_date]);

		return $this->db->select("mw.id,mw.maintance_id,mw.area_id,mw.site_id,mw.well_id,mw.issue_type_id,mw.issue_status,mw.c_date,mw.d_date,wm.well_name,ws.well_site_name,am.area_name,wi.issue_type,om.userId as create_id,om.user_full_name as create_by,omd.userId as update_id,omd.user_full_name as update_by,mw.issue_status,mw.action_taken,mw.quantity,mw.item_serial")
		       ->from('tbl_maintance_well_issue_master mw')
		       ->join('tbl_area_master am','mw.area_id=am.id','left')
		       ->join('tbl_well_site_master ws','ws.id=mw.site_id','left')
		       ->join('tbl_well_master wm','wm.id=mw.well_id','left')
		       ->join('tbl_well_issue_type wi','wi.id=mw.issue_type_id','left')
		       ->join('tbl_ongc_member_master om','om.id=mw.c_by','left')
		       ->join('tbl_ongc_member_master omd','omd.id=mw.d_by','left')
		       ->where(['mw.status'=>1])
		       ->order_by('mw.issue_status','asc')->get()->result_array();

		
	}

	public function get_next_ref_no()
    {
       $this->db->select('MAX(maintance_id) as maintance_id');
       $this->db->from('tbl_maintance_well_issue_master'); 
       $query = $this->db->get();
       $result = $query->row_array();

	    if (!empty($result['maintance_id'])) {
	        $last_number = intval(substr($result['maintance_id'], 3)); 
	        $new_number = $last_number + 1;
	        return 'TKT' . str_pad($new_number, 3, '0', STR_PAD_LEFT); 
	    } else {
	        return 'TKT001';
	    }
    }

    public function get_maintance_details($maintance_id)
	{
		return $this->db->select('area_id,site_id,well_id,issue_type_id,maintance_id,issue_status')->from('tbl_maintance_well_issue_master')->where(['maintance_id'=>$maintance_id])->get()->result_array();

	}

	public function UpdateMiantance($data,$where)
	{
		return $this->db->update('tbl_maintance_well_issue_master',$data,$where);
	}
	public function AreaList()
	{
        return $this->db->select('area_name,id as area_id')->from('tbl_area_master')->where(['status'=>1])->get()->result_array();
	}

	public function siteList($area_id)
	{
		
        if($area_id!='')
			$this->db->where('area_id=',$area_id);
        return $this->db->select("id,well_site_name,area_id")->from('tbl_well_site_master')->where(['status'=>1])->get()->result_array();
	}

	public function wellList($area_id,$site_id)
	{
        if($area_id!='')
            $this->db->where('sd.area_id=',$area_id);
        if($site_id!='')
            $this->db->where('sd.site_id=',$site_id);

        return $this->db->select("wm.id as well_id,wm.area_id,wm.site_id,wm.well_name")
                         ->from('tbl_site_device_installation sd')
                         ->join('tbl_well_master wm','sd.well_id=wm.id','left')
                         ->where(['sd.status'=>1,'wm.status'=>1])->get()->result_array();
	}

	public function problemList()
	{
		 return $this->db->select("id,issue_type")->from('tbl_well_issue_type')->where(['status'=>1])->get()->result_array();
	}


   //  count 
	public function get_total_case($user_id)
	{
	    $this->db->select("count(id) as total")
	             ->from('tbl_maintance_well_issue_master')
	             ->where('status', 1)
	             ->group_start()
	                 ->where('c_by', $user_id)
	                 ->or_where('c_by', 'system_generate')
	             ->group_end();

	    $res = $this->db->get()->result_array();

	    if (!empty($res)) {
		        return $res[0]['total'];
		    } else {
		        return 0;
		    }
	}

	public function get_total_open($user_id)
	{
	    $this->db->select("count(id) as total")
	             ->from('tbl_maintance_well_issue_master')
	             ->where('status', 1)
	             ->where('issue_status', 1)
	             ->group_start()
	                 ->where('c_by', $user_id)
	                 ->or_where('c_by', 'system_generate')
	             ->group_end();

	    $res = $this->db->get()->result_array();

	    if (!empty($res)) {
		        return $res[0]['total'];
		    } else {
		        return 0;
		    }
	}

	public function get_total_inprogress($user_id)
	{
	    $this->db->select("count(id) as total")
	             ->from('tbl_maintance_well_issue_master')
	             ->where('status', 1)
	             ->where('issue_status', 2)
	             ->group_start()
	                 ->where('c_by', $user_id)
	                 ->or_where('c_by', 'system_generate')
	             ->group_end();

	    $res = $this->db->get()->result_array();

	    if (!empty($res)) {
		        return $res[0]['total'];
		    } else {
		        return 0;
		    }
	}

	public function get_total_close($user_id)
    {
	    $this->db->select("count(id) as total")
	             ->from('tbl_maintance_well_issue_master')
	             ->where('status', 1)
	             ->where('issue_status', 3)
	             ->group_start()
	                 ->where('c_by', $user_id)
	                 ->or_where('c_by', 'system_generate')
	             ->group_end();

	    $res = $this->db->get()->result_array();

	    if (!empty($res)) {
	        return $res[0]['total'];
	    } else {
	        return 0;
	    }
   }

	// for mail purpose 

	public function get_well_case_details()
	{
	    $current_date = date('Y-m-d');
	   
	    $ticket_id = $this->db->select("maintance_id")
	        ->from('tbl_maintance_well_issue_master')
	        ->where('status', 1)
	        ->group_start()
	        ->where('DATE(c_date)', $current_date)
	        ->or_where('DATE(d_date)', $current_date)
	        ->group_end()
	        ->order_by('issue_status', 'asc')
	        ->order_by('c_date', 'desc')
	        ->get()
	        ->result_array();

	    if (empty($ticket_id)) {
	        return []; 
	    }
	    
	    $result = [];

	    foreach ($ticket_id as $value) {
	       
	        $timeline = $this->db->select("mw.maintance_id, am.area_name, ws.well_site_name, wm.well_name, CASE WHEN mw.c_by = 'system_generate' THEN 'System Generated' ELSE CONCAT(om.user_full_name, ' (', om.userId, ')') END AS user_data, mw.issue_status, wi.issue_type, mw.c_date,mw.action_taken,mw.quantity,mw.item_serial")
	            ->from('tbl_maintance_well_issue_log mw')
	            ->join('tbl_well_master wm', 'mw.well_id = wm.id', 'left')
	            ->join('tbl_area_master am', 'mw.area_id = am.id', 'left')
	            ->join('tbl_well_site_master ws', 'ws.id = mw.site_id', 'left')
	            ->join('tbl_well_issue_type wi', 'wi.id = mw.issue_type_id', 'left')
	            ->join('tbl_ongc_member_master om', 'om.id = mw.c_by', 'left')
	            ->where(['mw.status' => 1, 'wm.status' => 1, 'mw.maintance_id' => $value['maintance_id']])
	            ->group_by('mw.id')
	            ->order_by('mw.id', 'desc')
	            ->get()
	            ->result_array();
	            
	        $resolution = $this->db->select("am.area_name, ws.well_site_name, mw.maintance_id, mw.c_date, mw.d_date, wm.well_name")
	            ->from('tbl_maintance_well_issue_master mw')
	            ->join('tbl_well_master wm', 'mw.well_id = wm.id', 'left')
	            ->join('tbl_area_master am', 'mw.area_id = am.id', 'left')
	            ->join('tbl_well_site_master ws', 'ws.id = mw.site_id', 'left')
	            ->where(['mw.status' => 1, 'wm.status' => 1, 'mw.issue_status' => 3, 'mw.maintance_id' => $value['maintance_id']])
	            ->group_by('mw.id')
	            ->get()
	            ->result_array();

	        // Process maintenance timeline and resolution
	        $formatted_data = [
	            'maintance_id' => $value['maintance_id'],
	            'well_name' => '', 
	            'site_name' => '', 
	            'area_name' => '', 
	            'issue_type'=>'',
	            'case_status' => [
	                'open' => [],
	                'in_progress' => [],
	                'closed' => [],
	            ],
	            'resolution' => []
	        ];

	        // Process timeline data
	        foreach ($timeline as $entry) {
	            $status = $entry['issue_status'] == 3 ? 'closed' : ($entry['issue_status'] == 2 ? 'in_progress' : 'open');
	            $formatted_data['well_name'] = $entry['well_name'];  
	            $formatted_data['site_name'] = $entry['well_site_name']; 
	            $formatted_data['area_name'] = $entry['area_name'];
	             $formatted_data['issue_type'] = $entry['issue_type'];  
	            
	            if ($status == 'open') {
	                $formatted_data['case_status']['open'][] = [
	                    'open_time' => $entry['c_date'],
	                    'user_data' => $entry['user_data'],
	                    'issue_status' => $entry['issue_status'],
	                ];
	            } elseif ($status == 'in_progress') {
	                $formatted_data['case_status']['in_progress'][] = [
	                    'in_progress_time' => $entry['c_date'],
	                    'user_data' => $entry['user_data'],
	                    'issue_status' => $entry['issue_status'],
	                ];
	            } elseif ($status == 'closed') {
	                $formatted_data['case_status']['closed'][] = [
	                    'action_taken' => $entry['action_taken'],
	                    'quantity' => $entry['quantity'], 
	                    'item_serial' => $entry['item_serial'],
	                    'closed_time' => $entry['c_date'],
	                    'user_data' => $entry['user_data'],
	                    'issue_status' => $entry['issue_status'],
	                ];
	            }
	        }

	       
	        foreach ($resolution as $res) {
	            $formatted_data['resolution'][] = [
	                'create_time' => $res['c_date'],
	                'closed_time' => $res['d_date'],
	            ];
	        }
	        $result[] = $formatted_data;
	    }

	     return $result;
	}
	public  function get_total_case_count()
	{
		$current_date = date('Y-m-d');
		$total_counts = $this->db->select("issue_status, COUNT(*) as count")
	        ->from('tbl_maintance_well_issue_master')
	        ->where('status', 1)
	        ->where_in('issue_status', [1, 2, 3])
	        ->group_start()
	        ->where('DATE(c_date)', $current_date)
	        ->or_where('DATE(d_date)', $current_date)
	        ->group_end()
	        ->group_by('issue_status')
	        ->get()
	        ->result_array();

        $totals = ['total_open' => 0, 'total_in_progress' => 0, 'total_closed' => 0];
    
        foreach ($total_counts as $count) {
        if ($count['issue_status'] == 1) {
            $totals['total_open'] = $count['count'];
        } elseif ($count['issue_status'] == 2) {
            $totals['total_in_progress'] = $count['count'];
        } elseif ($count['issue_status'] == 3) {
            $totals['total_closed'] = $count['count'];
        }
       }
       return $totals;
	}

	public function get_offline_well_details()
    {
       $two_hours_ago = date('Y-m-d H:i:s', strtotime('-2 hours'));
     

       return $this->db->select("well_id, area_id, site_id")
        ->from('tbl_site_device_installation')
        ->where(['status'=>1,'device_shifted'=>0,'flag_status'=>0])
        ->where('last_log_datetime <', $two_hours_ago) 
        ->get()
        ->result_array();
   }
   public function update_case_status($data,$where)
   {
        $this->db->update("tbl_maintance_well_issue_master", $data,$where);
   }

    public function get_active_wells()
	{
	    return $this->db->select("well_id")
	        ->from("tbl_maintance_well_issue_master")
	        ->where_in("issue_status", [1, 2]) 
	        ->get()
	        ->result_array();
	}

	public function is_well_online($well_id)
{
    $two_hours_ago = date('Y-m-d H:i:s', strtotime('-2 hours'));

    $query = $this->db->select("sd.well_id, sd.last_log_datetime, mw.maintance_id, sd.area_id, sd.site_id")
        ->from("tbl_site_device_installation sd")
        ->join("tbl_maintance_well_issue_master mw", "sd.well_id = mw.well_id", "left")
        ->where("sd.well_id", $well_id)
        ->where("sd.last_log_datetime >=", $two_hours_ago)
        ->where_in("mw.issue_status", [1, 2]) 
        ->get();

    return $query->row_array(); 
}
	public function close_case($well_id)
	{
	    $this->db->where("well_id", $well_id)
	        ->where_in("issue_status", [1, 2]) 
	        ->update("tbl_maintance_well_issue_master", ["issue_status" => 3]);
	}
	public function get_existing_case($well_id)
	{
	    return $this->db->select("maintance_id")
	        ->from("tbl_maintance_well_issue_master")
	        ->where("well_id", $well_id)
	        ->where_in("issue_status", [1, 2]) 
	        ->get()
	        ->row_array();
	}
}
?>