<?php
class Item_master_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
public function ItemList($id = "")
{
    $this->db->select('id, item_name');
    $this->db->from('tbl_item_master');
   

    if (!empty($id)) {
        $this->db->where('id', $id);
    }

    $query = $this->db->get();
    return $query->result_array();
}
public function verifyItemExist($item_name)
	{
		$res = $this->db->select("count(id) as total")->from('tbl_item_master')->where(['item_name'=>$item_name,'status'=>1])->get()->result_array();

		if(!empty($res))
		{
			return $res[0]['total'];
		}else{
			return 0;
		}
	}

	public function SaveItemData($data)
	{
		return $this->db->insert('tbl_item_master',$data);
	}
	public function verifyItemExist_OR_not($item_name,$id)
	{
		if($id!='')
			$this->db->where('id!=',$id);
		$res = $this->db->select("count(id) as total")->from('tbl_item_master')->where(['item_name'=>$item_name,'status'=>1])->get()->result_array();

		if(!empty($res))
		{
			return $res[0]['total'];
		}else{
			return 0;
		}
	}
	public function UpdateItem($data,$where)
	{
		return $this->db->update('tbl_item_master',$data,$where);
	}
	public function DeleteItem($data,$where)
	{
		return $this->db->update('tbl_item_master',$data,$where);
	}

}
?>