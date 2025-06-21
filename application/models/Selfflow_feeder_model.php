<?php
class Selfflow_feeder_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function verifyFeederExist($feeder_name)
	{
		$res = $this->db->select("count(id) as total")->from('tbl_feeder_master')->where(['feeder_name'=>$feeder_name,'status'=>1])->get()->result_array();

		if(!empty($res))
		{
			return $res[0]['total'];
		}else{
			return 0;
		}
	}

	public function getFeederId()
	{
		return $this->db->select("UUID()")->get()->result_array();
	}

	public function saveFeeder($dataArray)
	{
		return $this->db->insert('tbl_feeder_master',$dataArray);
	}

	public function Feeder_List($area_id,$id)
    {
    	if($area_id!='')
    		$this->db->where('f.area_id',$area_id);

    	if($id!='')
    		$this->db->where('f.id',$id);

    	return $this->db->select("f.id,f.area_id,wm.area_name,f.feeder_name")
    	->from('tbl_feeder_master f')
    	->join('tbl_area_master wm','f.area_id=wm.id and wm.status = 1','left')
    	->where('f.status',1)
    	->get()->result_array();
    }

    public function Feeder_List_data($site_id)
    {
    	if($site_id!='')
    		$this->db->where('ws.id',$site_id);
    	return $this->db->select("f.id,f.area_id,wm.area_name,ws.id as site_id,f.feeder_name")
    	->from('tbl_feeder_master f')
    	->join('tbl_area_master wm','f.area_id=wm.id and wm.status = 1','left')
    	->join('tbl_well_site_master ws','f.area_id=ws.area_id and ws.status=1','left')
    	->where('f.status',1)
    	->get()->result_array();

    }

    public function verifyFeederExist_OR_not($feeder_name,$id)
	{
		if($id!='')
			$this->db->where('id!=',$id);
		$res = $this->db->select("count(id) as total")->from('tbl_feeder_master')->where(['feeder_name'=>$feeder_name,'status'=>1])->get()->result_array();

		if(!empty($res))
		{
			return $res[0]['total'];
		}else{
			return 0;
		}
	}

	public function updateFeederData($dataArray,$where)
	{
		return $this->db->update('tbl_feeder_master',$dataArray,$where);
	}
}
?>