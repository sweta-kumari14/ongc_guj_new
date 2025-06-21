<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    date_default_timezone_set('Asia/Kolkata');
    class Device_allotment_report_c extends MY_Controller
    {
        public function __construct()
        {
            parent:: __construct();
        }

        public function index()
        {
            $module_name = 'Device Allotment Module';
            $api = 'Master/AccessLog';
            $data = 'id='.htmlspecialchars($this->session->userdata('id')).'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $api = 'Master/Company_list';
            $data = '';
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            $d['company_list'] = $result['data'];

            $d['v'] = "report/device_allot_report_view";
            $this->load->view('templates',$d); 
        }

        public function get_device_allotment_report()
        {
            $api = 'Report/CompanyAllotment_Report';
            $method = 'POST';
            $data = 'company_id='.htmlspecialchars($this->input->post('company_id',true))
            .'&from_date='.htmlspecialchars($this->input->post('from_date',true))
            .'&to_date='.htmlspecialchars($this->input->post('to_date',true));
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }
    }
?>