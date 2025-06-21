<?php
class Tag_master_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function verifyTag_numberExist($tag_number)
	{
		$res = $this->db->select("count(id) as total")->from('tbl_tags_number_master')->where(['tag_number'=>$tag_number,'status'=>1])->get()->result_array();

		if(!empty($res))
		{
			return $res[0]['total'];
		}else{
			return 0;
		}
	}

	public function Save_TagData($data)
	{
		return $this->db->insert('tbl_tags_number_master',$data);
	}

	public function verifyTagExist_OR_not($tag_number,$id)
	{
		if($id!='')
			$this->db->where('id!=',$id);
		$res = $this->db->select("count(id) as total")->from('tbl_tags_number_master')->where(['tag_number'=>$tag_number,'status'=>1])->get()->result_array();

		if(!empty($res))
		{
			return $res[0]['total'];
		}else{
			return 0;
		}
	}
	public function UpdateComponent($data,$where)
	{
		return $this->db->update('tbl_tags_number_master',$data,$where);
	}

	public function ComponentList($id,$company_id,$component_id)
	{
		if($id!='')
			$this->db->where('im.id',$id);
		if($company_id!='')
			$this->db->where('im.company_id',$company_id);

		if($component_id!='')
			$this->db->where('im.component_id',$component_id);

		$result = $this->db->select("im.id,im.company_id,cs.company_name,im.component_id,cm.component_name,im.tag_number")
		->from('tbl_tags_number_master im')
		->join('tbl_company_setup cs','im.company_id=cs.id','left')
		->join('tbl_component_master cm','im.component_id=cm.id','left')
		->order_by("CAST(SUBSTRING_INDEX(im.tag_number, '#', -1) AS UNSIGNED) ASC")
		->where(['im.status'=>1,'cs.status'=>1])->get()->result_array();

        return $result;
	}

	public function DeleteItem($data,$where)
	{
		return $this->db->update('tbl_tags_number_master',$data,$where);
	}
}
?>