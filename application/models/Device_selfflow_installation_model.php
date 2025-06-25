<?php
class Device_selfflow_installation_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function CheckWell_formula_Exist($well_type)
    {
        $res = $this->db->select("count(id) as total")
            ->from('tbl_well_formula_setup')
            ->where(['well_type'=>$well_type,'status'=>1])
            ->get()->result_array();
            if($res!='')
            {
                return $res[0]['total'];
            }else{
                return 0;
            }
    }

    public function get_well_formula_list($well_type)
    {
        return $this->db->select("wf.well_type,wf.component_id,cm.component_name,wf.quantity_required")
        ->from('tbl_well_formula_setup wf')
        ->join('tbl_component_master cm','cm.id=wf.component_id','left')
        ->where(['wf.status'=>1,'wf.well_type'=>$well_type])->get()->result_array();
    }

    public function CheckWell_id_Exist($well_id)
    {
        return $this->db->select("id,company_id,installed_by,well_id,assets_id,area_id,site_id,well_type,network_type,sim_provider,c_date,date_time,imei_no,device_name,imei_no,no_of_installed_sensor,sim_no")
        ->from('tbl_site_device_installtion_self_flow')
        ->where(['well_id'=>$well_id,'status'=>1])
        ->get()->result_array();
    }

    public function installed_tag_list($well_id)
    {
        return $this->db->select("well_id,component_id,sensor_no")
        ->from('tbl_well_sensor_tag_installation_log`')
        ->where(['well_id'=>$well_id,'status'=>1,'tag_status'=>1])
        ->get()->result_array();
    }

    public function get_Ins_id()
    {
        return $this->db->select("UUID()")->get()->result_array();
    }

    public function Save_Installation_Data($data)
    {
        $result = $this->db->insert('tbl_site_device_installtion_self_flow',$data);

        if($result == true){
            return 200;
        }else{
            return 105;
        }
    }

    public function update_well_reinstallation_record($data,$where)
    {
        return $this->db->update('tbl_site_device_installtion_self_flow',$data,$where);
    }

    public function update_well_removal_record($data,$where)
    {
        return $this->db->update('tbl_site_device_installtion_self_flow',$data,$where);
    }

    public function Save_Tag_Detail($data)
    {
        return $this->db->insert('tbl_well_sensor_tag_installation_log`',$data);
    }

    public function update_Tag_installation_status($data,$where)
    {
        return $this->db->update('tbl_tags_number_master',$data,$where);
    }

    public function Well_Wise_Device_installation_Status($data,$where)
    {
        return $this->db->update('tbl_well_master',$data,$where);
    }

    public function SaveWell_installationlog($data)
    {
        return $this->db->insert('tbl_well_device_installation_log ',$data);
    }

    public function update_installation_device_logData($data,$where)
    {
        return $this->db->update('tbl_well_device_installation_log ',$data,$where);
    }

    public function UpdateRemoved_sensorStatus($data,$where)
    {
        return $this->db->update('tbl_well_sensor_tag_installation_log`',$data,$where);
        
    }

}
?>