<?php
class Well_type_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();


	}

	public function get_well_type($well_type_name,$company_id)
	{
		$res =  $this->db->select('count(id) as total')->from('tbl_well_type')
		             ->where(['well_type_name'=>$well_type_name,'company_id'=>$company_id])
		             ->get()->result_array();

		                   if(!empty($res))
		                   {
		                   	  return $res[0]['total'];
		                   }else {
		                   	 return 0;
		                   }
	}

    public function SaveWell($data)
	{
		return $this->db->insert('tbl_well_type',$data);
	}
	public function verifywellExist_OR_not($well_type_name,$id)
	{
		if($id!='')
			$this->db->where('id!=',$id);
		$res = $this->db->select("count(id) as total")->from('tbl_well_type')->where(['well_type_name'=>$well_type_name,'status'=>1])->get()->result_array();

		if(!empty($res))
		{
			return $res[0]['total'];
		}else{
			return 0;
		}
	}
	public function Updatewell($data,$where)
	{
		return $this->db->update('tbl_well_type',$data,$where);
	}
	public function Deletewell($data,$where)
	{
		return $this->db->update('tbl_well_type',$data,$where);
	}
	public function Welllist($id,$company_id)
	{
		if($id!='')
			$this->db->where('a.id',$id);
		if($company_id!='')
			$this->db->where('a.company_id',$company_id);
		return $this->db->select("a.id,a.company_id,cs.company_name,a.well_type_name")
		->from('tbl_well_type a')
		->join('tbl_company_setup cs','a.company_id=cs.id','left')
		->where('a.status',1)->get()->result_array();
	}
}
?>