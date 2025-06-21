<?php
 date_default_timezone_set('Asia/Kolkata');
class Temporary_off_reason_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function SaveReason($data)
	{
		return $this->db->insert('tbl_temporary_off_well',$data);
	}

	public function verifyReasonExist($reason)
	{
		$res = $this->db->select("count(id) as total")->from('tbl_temporary_off_well')->where(['reason'=>$reason,'status'=>1])->get()->result_array();

		if(!empty($res))
		{
			return $res[0]['total'];
		}else{
			return 0;
		}
	}

	
	public function ReasonList($id,$company_id)
	{
		if($id!='')
			$this->db->where('a.id',$id);
		if($company_id!='')
			$this->db->where('a.company_id',$company_id);
		

		return $this->db->select("a.id,a.company_id,a.reason")
		->from('tbl_temporary_off_well a')
		->join('tbl_company_setup cs','a.company_id=cs.id','left')
		->where('a.status',1)->get()->result_array();
	}

	public function DeleteReason($data,$where)
	{
		return $this->db->update('tbl_temporary_off_well',$data,$where);
	}

	public  function Update_Flagstatus($data,$where)
	{
		return $this->db->update('tbl_site_device_installation',$data,$where);
	}

	public function SaveFlagdata_log($data_log)
	{
		return $this->db->insert('tbl_temporary_off_well_reson_log',$data_log);
	}


	public function Update_Flag_logstatus($data,$where)
	{
		return $this->db->update('tbl_temporary_off_well_reson_log',$data,$where);
	}

	public function verify_well_flag_details($well_id)
	{
		
		    $res =  $this->db->select("count(id) as total")
		            ->from('tbl_temporary_off_well_reson_log')
		            ->where(['flag_status'=>1,'well_id'=>$well_id])
		            ->order_by('c_date', 'desc')
                    ->limit(1)->get()->result_array();
        if(!empty($res))
		{
			return $res[0]['total'];
		}else{
			return 0;
		}
	}


	public function last_status_well($well_id)
	{
		 return $this->db->select('tl.well_id, tl.reason, tl.effective_date_time, tl.flag_status,tc.reason as reason_name')
                    ->from('tbl_temporary_off_well_reson_log tl')
                    ->join('tbl_temporary_off_well tc','tc.id=tl.reason','left')
                    ->where(['tl.status' => 1,'tl.well_id'=>$well_id])
                    ->order_by('tl.c_date', 'desc')
                    ->limit(1)
                    ->get()
                    ->result_array();
	}
}
?>