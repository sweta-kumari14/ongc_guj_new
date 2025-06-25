<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata');

class Removal_c extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $api ='Master/Install_Well_List';
        $data='company_id='.$this->session->userdata('company_id',true);
        $method = 'POST';
        $result = $this->CallAPI($api,$data,$method);
        $d['well_list'] = $result['data'];

        $d['v'] = "removal_view";
        $this->load->view('templates', $d);
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

    public function removal_data()
    {
        $api ='Well_site_device_Installtion/save_device_andtag_removal_data';
        $data= 'removal_type='.$this->input->post('removal_type',true)
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
