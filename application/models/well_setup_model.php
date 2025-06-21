<?php
class Well_setup_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getItemAllId()
    {
        return $this->db->select("UUID()")->get()->result_array();
    }

    public function WellType_ItemAllotment($data)
    {
        return $this->db->insert('tbl_well_formula_setup',$data);
    }
        public function getItemTypeExistOr_Not($component_id,$well_type)
    {
        $res = $this->db->select("count(id) as total")->from('tbl_well_formula_setup')->where(['component_id'=>$component_id,'well_type'=>$well_type,'status'=>1])->get()->result_array();

        if(!empty($res))
        {
            return $res[0]['total'];
        }else{
            return 0;
        }
    }
    public function getwell_formula_list($id,$company_id,$component_id,$well_type)
    {
        if($id!='')
            $this->db->where('wf.id',$id);
        if($company_id!='')
            $this->db->where('wf.company_id',$company_id);
        if($component_id!='')
            $this->db->where('wf.component_id',$component_id);
        if($well_type!='')
            $this->db->where('wf.well_type',$well_type);

        return $this->db->select("wf.id,wf.company_id as company_id,wf.component_id,wf.well_type,wt.well_type_name,im.component_name,wf.quantity_required")
        ->from('tbl_well_formula_setup wf')
        ->join('tbl_well_type wt','wt.id=wf.well_type','left')
        ->join('tbl_component_master im','im.id=wf.component_id and im.status =1','left')
        ->where(['wf.status'=>1])->get()->result_array();
    }
    public  function update_well_formula($data,$where)
    {
        return $this->db->update('tbl_well_formula_setup',$data,$where);
    }
}
?>