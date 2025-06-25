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
    
    

    public function get_device_removal_log($company_id,$user_id,$well_id,$from_date,$to_date)
    {
        $image = base_url().'album/';

        if($company_id!="")
                $this->db->where(['il.company_id'=>$company_id]);
            
        if($user_id!="")
                $this->db->where(['il.installed_by'=>$user_id]);

        if($well_id!="")
                $this->db->where(['il.well_id'=>$well_id]);


        if ($from_date != '' && $to_date != '') {
            $this->db->where("DATE(il.from_date_time) BETWEEN '{$from_date}' AND '{$to_date}'");
        }


        return $this->db->select("il.id,il.company_id,il.installed_by,om.user_full_name,il.assets_id,as.assets_name,il.area_id,am.area_name,il.site_id,ws.well_site_name,il.well_type,il.well_id,wm.well_name,wm.lat,wm.long,wm.gps_lat,wm.gps_long,il.imei_no,il.device_name,il.from_date_time,il.to_date_time,il.sim_no,il.network_type,il.sim_provider,CONCAT('$image',il.image) as image,il.no_of_installed_sensor,wt.well_type_name,il.well_installation_status,il.well_status")

            ->from('tbl_well_device_installation_log  il')
            ->join('tbl_device_master ds','ds.imei_no=il.imei_no and ds.status=1','left')
            ->join('tbl_well_type wt','il.well_type=wt.id and wt.status=1','left')
            ->join('tbl_assets_master as','as.id=il.assets_id and as.status=1','left')
            ->join('tbl_area_master am','am.id=il.area_id and am.status=1','left')
            ->join('tbl_well_site_master ws','ws.id=il.site_id and ws.status=1','left')
            ->join('tbl_ongc_member_master om','om.id=il.installed_by and om.status=1','left')
            ->join('tbl_well_master wm','wm.id=il.well_id and wm.status=1','left')
            ->where(['il.status'=>1])->get()->result_array();
    }
}
?>