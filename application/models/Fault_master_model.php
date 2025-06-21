<?php
class Fault_master_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getFault_Number()
    {
       $result = $this->db->query("SELECT fault_number FROM tbl_fault_master order by fault_number desc limit 1");
        $data = $result->result_array();
        if(empty($data))
        {
            return $str = '3';
        }else
        {
            $id = $data[0]['fault_number'];
            $id = intval($id);
            return $str = ($id+1);

        }
    
    }

	public function verifyFaultExist($fault_name)
	{
		$res = $this->db->select("count(id) as total")->from('tbl_fault_master')->where(['fault_name'=>$fault_name,'status'=>1])->get()->result_array();

		if(!empty($res))
		{
			return $res[0]['total'];
		}else{
			return 0;
		}
	}

	public function getFalutId()
	{
		return $this->db->select("UUID()")->get()->result_array();
	}

	public function SaveFault($data)
	{
		return $this->db->insert('tbl_fault_master',$data);
	}

	public function verifyFaultExist_OR_not($fault_name,$id)
	{
		if($id!='')
			$this->db->where('id!=',$id);
		$res = $this->db->select("count(id) as total")->from('tbl_fault_master')->where(['fault_name'=>$fault_name,'status'=>1])->get()->result_array();

		if(!empty($res))
		{
			return $res[0]['total'];
		}else{
			return 0;
		}
	}
	public function UpdateFault($data,$where)
	{
		return $this->db->update('tbl_fault_master',$data,$where);
	}

	public function FaultList($id,$company_id)
	{
		if($id!='')
			$this->db->where('f.id',$id);
		if($company_id!='')
			$this->db->where('f.company_id',$company_id);

		return $this->db->select("f.id,f.company_id,cs.company_name,f.fault_name,f.color_code,f.fault_number")
		->from('tbl_fault_master f')
		->join('tbl_company_setup cs','f.company_id=cs.id','left')
		->where('f.status',1)->get()->result_array();
	}

	public function DeleteFault($data,$where)
	{
		return $this->db->update('tbl_fault_master',$data,$where);
	}
}
?>