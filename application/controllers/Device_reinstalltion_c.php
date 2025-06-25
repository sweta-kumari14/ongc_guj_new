<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata');

class Device_reinstalltion_c extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $api ='Master/Install_self_flow_Well_List';
        $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'));
        $method = 'POST';
        $result = $this->CALLAPI($api,$data,$method);
        $d['well_list'] = $result['data'];

       // print_r($d['well_list']);die;

        $d['v'] = "device_re-installtion_view";
        $this->load->view('templates', $d);
    }
    public function get_well_type_details_list(){
        $api = 'Well_setup/well_formula_list';
        $data = 'company_id='. htmlspecialchars($this->session->userdata('company_id')) . '&well_type='. htmlspecialchars($this->input->post('well_type'));
        $method = 'POST';
        $result = $this->CallAPI($api, $data, $method);
        echo json_encode($result);
    }

    public function item_list_ajax()
    {
        $api ='Master/get_item_list_for_re_installation';
        $data ='well_id='.$this->input->post('well_id',true)
               .'&component_id='.$this->input->post('component_id',true);
        $method ='POST';
        $result = $this->CallAPI($api,$data,$method);
        echo json_encode($result);
    }

    public function device_list_ajax()
    {
        $api ='Master/device_list_for_re_installation';
        $data ='user_id='.$this->input->post('user_id',true);
        $method ='POST';
        $result = $this->CallAPI($api,$data,$method);
        echo json_encode($result);
    }
    
    public function get_installed_detilas()
    {
        $api ='master/Install_Well_details_for_removed';
        $data ='company_id='.$this->session->userdata('company_id',true)
               .'&remove_type='.$this->input->post('remove_type',true)
               .'&well_id='.$this->input->post('well_id',true);
        $method ='POST';
        $result = $this->CallAPI($api,$data,$method);
        echo json_encode($result);
    }

    public function save_reinstalltion_data()
    {
        $api ='Device_selfflow_well_installation/save_device_and_tag_re_installtion_data';
        $data= 'reinstallation_type='.$this->input->post('reinstallation_type',true)
                .'&well_id='.$this->input->post('well_id',true)
                .'&device_name='.$this->input->post('device_name',true)
                .'&imei_no='.$this->input->post('imei_no',true)
                .'&tag_data='.($this->input->post('tag_data',true))
                .'&c_by='.$this->session->userdata('user_id',true);
        $method = 'POST';
        $result = $this->CallAPI($api,$data,$method);
        echo json_encode($result);

    }
}
?>
