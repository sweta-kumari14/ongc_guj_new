<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata');

class Device_commissioning_c extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $api = 'Master/get_Area_List';
        $data = 'company_id=' . htmlspecialchars($this->session->userdata('company_id'));
        $method = 'POST';
        $result = $this->CallAPI($api, $data, $method);
        $d['area_list'] = $result['data'];

        $d['v'] = "device_commissioning_add_view";
        $this->load->view('templates', $d);
    }

    public function well_list_ajax()
    {
    	$api = 'Device_commissioning_details/get_well_list';
        $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'))
                .'&area_id='.htmlspecialchars($this->input->post('area_id'));
        $method = 'POST';
        $result = $this->CallAPI($api, $data, $method);
        echo json_encode($result);

    }

    public function add_commissoning_data()
    {
    	$api = 'Device_commissioning_details/add_well_commissiong_date';
        $data = 'c_by='.htmlspecialchars($this->session->userdata('id'))
                .'&commissioningData='.($this->input->post('commissioningData'))
                .'&area_id='.htmlspecialchars($this->input->post('area_id'))
                .'&commissioning_date='.($this->input->post('commissioning_date'));
        $method = 'POST';
        $result = $this->CallAPI($api, $data, $method);
        echo json_encode($result);

    }

    public function commissioning_report_page()
    {
        $api = 'Master/get_Area_List';
        $data = 'company_id=' . htmlspecialchars($this->session->userdata('company_id'));
        $method = 'POST';
        $result = $this->CallAPI($api, $data, $method);
        $d['area_list'] = $result['data'];

        $d['v'] = "device_commissioning_report_view";
        $this->load->view('templates', $d);
    }

    public function commissioning_report_ajax()
    {
    	$api = 'Device_commissioning_details/well_commissioning_report_details';
        $data = 'area_id='.htmlspecialchars($this->input->post('area_id'))
                .'&from_date='.htmlspecialchars($this->input->post('from_date'))
                .'&to_date='.htmlspecialchars($this->input->post('to_date'));
        $method = 'POST';
        $result = $this->CallAPI($api, $data, $method);
        echo json_encode($result);

    }
}
?>