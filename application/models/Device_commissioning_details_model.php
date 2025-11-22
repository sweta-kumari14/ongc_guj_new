<?php
class Device_commissioning_details_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function verify_wellExist($well_id)
	{
		$res = $this->db->select("count(id) as total")->from('tbl_well_commissioning_details')->where(['well_id'=>$well_id,'status'=>1])->get()->result_array();

		if(!empty($res))
		{
			return $res[0]['total'];
		}else{
			return 0;
		}
	}

	public function save_commissiong_data($data)
	{
		return $this->db->insert('tbl_well_commissioning_details',$data);
	}

	public function update_commissiong_data($data,$where)
	{
		return $this->db->update('tbl_well_commissioning_details',$data,$where);
	}

	public function WellList($company_id,$area_id)
	{
		if($company_id!='')
			$this->db->where('sd.company_id',$company_id);
		if($area_id!='')
			$this->db->where('sd.area_id',$area_id);

		return $this->db->select("am.area_name,ws.well_site_name,sd.area_id,sd.site_id,wm.well_name,sd.well_id,sd.device_name,sd.imei_no,sd.date_time,")
		->from('tbl_site_device_installtion_self_flow sd')
		->join('tbl_area_master am','sd.area_id=am.id','left')
		->join('tbl_well_site_master ws','sd.site_id=ws.id','left')
		->join('tbl_well_master wm','sd.well_id=wm.id','left')
		->where('sd.status',1,'sd.well_setup_status',1)->get()->result_array();
	}

	public function get_well_commissioning_report($area_id,$from_date,$to_date)
	{
	    if($area_id!='')
			$this->db->where('sd.area_id',$area_id);

		if ($from_date != '' && $to_date != '') {
	        $this->db->where("date(sd.c_date) BETWEEN '{$from_date}' AND '{$to_date}'");
	    }

		return $this->db->select("am.area_name,ws.well_site_name,wm.well_name,sd.well_id,sd.device_name,sd.imei_no,sd.installation_date,sd.commissioning_date")
		->from('tbl_well_commissioning_details sd')
		->join('tbl_area_master am','sd.area_id=am.id','left')
		->join('tbl_well_site_master ws','sd.site_id=ws.id','left')
		->join('tbl_well_master wm','sd.well_id=wm.id','left')
		->where('sd.status',1)->get()->result_array();
	}
}
?>