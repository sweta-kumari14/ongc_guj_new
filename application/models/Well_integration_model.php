<?php
class Well_integration_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function verify_well_name($well_name)
	{
		$res = $this->db->select("count(id) as total")->from('tbl_well_integration_details')->where(['well_name'=>$well_name,'status'=>1])->get()->result_array();

		if(!empty($res))
		{
			return $res[0]['total'];
		}else{
			return 0;
		}
	}

	public function verify_well_id_data($well_id)
	{
		$res = $this->db->select("count(id) as total")->from('tbl_well_integration_details')->where(['well_id'=>$well_id,'status'=>1])->get()->result_array();

		if(!empty($res))
		{
			return $res[0]['total'];
		}else{
			return 0;
		}
	}

	public function getWIntId()
	{
		return $this->db->select("UUID()")->get()->result_array();
	}

	public function getWIntLogId()
	{
		return $this->db->select("UUID()")->get()->result_array();
	}

	public function Save_well_data($data)
	{
		return $this->db->insert('tbl_well_integration_details',$data);
	}

	public function Save_well_log_data($data)
	{
		return $this->db->insert('tbl_well_integration_details_log',$data);
	}
	public function get_ticket_id()
    {
        $this->db->select('ticket_id')
             ->from('tbl_well_integration_details')
             ->order_by('c_date', 'desc') 
             ->limit(1);

        return $this->db->get()->row_array();
    }

	public function verify_well_ExitsOr_Not($well_id)
	{
		if($well_id!='')
		   $this->db->where('sd.well_id',$well_id);

		 return $this->db->select('count(sd.well_id) as total, wm.well_name, sd.device_name,sd.imei_no')
		                 ->from('tbl_site_device_installation sd')
		                 ->join('tbl_well_master wm','sd.well_id=wm.id','left')
		                 ->where(['wm.status'=>1,'sd.status'=>1])
		                 ->group_by('sd.well_id')
		                 ->get()->result_array();
		 
		
	}

	public function Well_Integration_Report($company_id,$from_date,$to_date,$site_id,$sort_by,$ticket_id,$well_type)
	{
		if($company_id!='')
			$this->db->where('ad.company_id',$company_id);
		if($from_date!='' && $to_date!='')
			$this->db->where(['date(wi.c_date)>='=>$from_date,'date(wi.c_date)<='=>$to_date]);
		if($site_id!='')
			$this->db->where('ad.id',$site_id);
		if ($sort_by != '') 
		{
            $this->db->order_by($sort_by, 'ASC');
        }

        if($ticket_id!='')
			$this->db->where('wi.ticket_id',$ticket_id);
		if($well_type!='')
			$this->db->where('wi.well_type',$well_type);

		return $this->db->select("wi.well_name, wi.well_type, wi.device_name, wi.imei_no, wi.reason_remove, wi.operation_date as tentative_date, ad.well_site_name, wi.to_well_name, wi.to_device_name, wi.to_imei_no, wi.well_status, wi.execution_status, wi.ticket_id, CONCAT(om.user_full_name, ' (', om.userId, ')') AS request_user_data,wi.c_date,wi.d_date,CONCAT(om1.user_full_name, ' (', om.userId, ')') AS operation_user_data")
                ->from('tbl_well_integration_details wi')
                ->join('tbl_well_site_master ad', 'wi.site_id = ad.id', 'left')
                ->join('tbl_authentication_master am', 'am.user_member_id = wi.c_by', 'left')
                ->join('tbl_ongc_member_master om', 'om.id = am.user_member_id', 'left')
                ->join('tbl_authentication_master am1', 'am1.user_member_id = wi.d_by', 'left')
                ->join('tbl_ongc_member_master om1', 'om1.id = am1.user_member_id', 'left')
                ->group_by('wi.id')
                ->where(['wi.status' => 1, 'ad.status' => 1])
                ->order_by("CAST(SUBSTRING_INDEX(wi.ticket_Id, '#', -1) AS UNSIGNED) desc")->order_by('wi.c_date','desc')
                ->get()
                ->result_array();
	}

	public function get_total_request($company_id,$from_date,$to_date,$site_id,$complaint_status)
	{
		if($company_id!='')
			$this->db->where('wi.company_id',$company_id);
		if($from_date!='' && $to_date!='')
			$this->db->where(['date(wi.c_date)>='=>$from_date,'date(wi.c_date)<='=>$to_date]);
		if($site_id!='')
			$this->db->where('wi.site_id',$site_id);
		if($complaint_status!='')
		   $this->db->where('wi.complaint_status',$complaint_status);

		$result = $this->db->select('count(distinct wi.ticket_id)  as total_request')
		                   ->from('tbl_well_integration_details wi')
		                   ->join('tbl_well_site_master ws', 'wi.site_id = ws.id', 'left')
		                   ->where(['wi.status'=>1])
		                   ->get()->result_array();
		if(!empty($result))
        {
            return $result[0]['total_request'];
        }else{
            return 0;
        }

	}


	public function get_total_pending($company_id,$from_date,$to_date,$site_id,$complaint_status)
	{
		if($company_id!='')
			$this->db->where('wi.company_id',$company_id);
		if($from_date!='' && $to_date!='')
			$this->db->where(['date(wi.c_date)>='=>$from_date,'date(wi.c_date)<='=>$to_date]);
		if($site_id!='')
			$this->db->where('wi.site_id',$site_id);
		if($complaint_status!='')
		   $this->db->where('wi.complaint_status',$complaint_status);

		$result = $this->db->select('count(distinct wi.ticket_id)  as total_pending')
		                   ->from('tbl_well_integration_details wi')
		                   ->join('tbl_well_site_master ws', 'wi.site_id = ws.id', 'left')
		                   ->where(['wi.status'=>1,'wi.execution_status'=>0])
		                   ->get()->result_array();
		if(!empty($result))
        {
            return $result[0]['total_pending'];
        }else{
            return 0;
        }

	}
	public function get_total_solved($company_id,$from_date,$to_date,$site_id,$complaint_status)
	{
		if($company_id!='')
			$this->db->where('wi.company_id',$company_id);
		if($from_date!='' && $to_date!='')
			$this->db->where(['date(wi.c_date)>='=>$from_date,'date(wi.c_date)<='=>$to_date]);
		if($site_id!='')
			$this->db->where('wi.site_id',$site_id);
		if($complaint_status!='')
		   $this->db->where('wi.complaint_status',$complaint_status);

		$result = $this->db->select('count(distinct wi.ticket_id)  as total_solved')
		                   ->from('tbl_well_integration_details wi')
		                   ->join('tbl_well_site_master ws', 'wi.site_id = ws.id', 'left')
		                   ->where(['wi.status'=>1,'wi.execution_status'=>1])
		                   ->get()->result_array();
		if(!empty($result))
        {
            return $result[0]['total_solved'];
        }else{
            return 0;
        }

	}

	public function get_ticket_wellintdetails($ticket_id)
	{
		return $this->db->select('company_id,assets_id,area_id,site_id,well_type,well_name,well_id,imei_no,device_name,to_well_id,to_well_name,to_device_name,to_imei_no,well_status,reason_remove,operation_date,well_type,execution_status')->from('tbl_well_integration_details')->where(['ticket_id'=>$ticket_id])->get()->result_array();

	}

	public function Update_status_well_integration($data,$where)
	{
		return $this->db->update('tbl_well_integration_details',$data,$where);
	}

public function update_well_feeder($data, $where)
{
    return $this->db->update('tbl_site_device_installtion', $data, $where);
}

public function update_well_feeder_selfflow($data, $where)
{
    return $this->db->update('tbl_site_device_installtion_self_flow ', $data, $where);
}


}
?>