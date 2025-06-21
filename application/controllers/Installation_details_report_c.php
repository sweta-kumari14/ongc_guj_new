<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    date_default_timezone_set('Asia/Kolkata');
    class Installation_details_report_c extends MY_Controller
    {
        public function __construct()
        {
            parent:: __construct();
        }

        public function index()
        {
            $module_name = 'Installed Device Report Module';
            $api = 'Master/AccessLog';
            $data = 'id='.htmlspecialchars((string)$this->session->userdata('id',true),ENT_QUOTES, 'UTF-8').'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $api = 'Master/Assets_list';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id',true),ENT_QUOTES,'UTF-8');
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            $d['assets_list'] = $result['data'];

            $api = 'DeviceAllotment_to_Installer/AllotUser_List';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            $d['user_list'] = $result['data'];

            // echo "<pre>";
            // print_r($result);die;

            $d['v'] = "report/installation_details_report_view";
            $this->load->view('templates',$d); 
        }

        public function get_area_list()
        {
            $api = 'Master/Arealist';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id',true),ENT_QUOTES,'UTF-8')
            .'&assets_id='.htmlspecialchars((string)$this->input->post('assets_id',true),ENT_QUOTES,'UTF-8');
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }

        public function get_site_list()
        {
        	$api = 'Master/Site_list';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES,'UTF-8')
            .'&area_id='.htmlspecialchars((string)$this->input->post('area_id',true),ENT_QUOTES,'UTF-8');
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }

        public function get_installation_report()
        {
            $api = 'Report/Installed_DeviceReport';
            $method = 'POST';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id',true),ENT_QUOTES,'UTF-8')
            .'&from_date='.htmlspecialchars((string)$this->input->post('from_date',true),ENT_QUOTES,'UTF-8')
            .'&to_date='.htmlspecialchars((string)$this->input->post('to_date',true),ENT_QUOTES,'UTF-8')
            .'&assets_id='.htmlspecialchars((string)$this->input->post('assets_id',true),ENT_QUOTES,'UTF-8')
            .'&area_id='.htmlspecialchars((string)$this->input->post('area_id',true),ENT_QUOTES,'UTF-8')
            .'&site_id='.htmlspecialchars((string)$this->input->post('site_id',true),ENT_QUOTES,'UTF-8')
            .'&user_id='.htmlspecialchars((string)$this->input->post('user_id',true),ENT_QUOTES,'UTF-8');
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }

        public function replacement_report_page()
        {
            $module_name = 'Replacement Report';
            $api = 'Master/AccessLog';
            $data = 'id='.htmlspecialchars((string)$this->session->userdata('id'),ENT_QUOTES, 'UTF-8').'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $api = 'Master/Assets_list';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            $d['assets_list'] = $result['data'];

            $api = 'DeviceAllotment_to_Installer/AllotUser_List';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            $d['user_list'] = $result['data'];

            $d['v'] = "report/replacement_report_view";
            $this->load->view('templates',$d);
        }

        public function get_replacement_report()
        {
            $api = 'Report/Device_Replacement_Report';
            $method = 'POST';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id',true),ENT_QUOTES,'UTF-8')
            .'&from_date='.htmlspecialchars((string)$this->input->post('from_date',true),ENT_QUOTES,'UTF-8')
            .'&to_date='.htmlspecialchars((string)$this->input->post('to_date',true),ENT_QUOTES,'UTF-8')
            .'&assets_id='.htmlspecialchars((string)$this->input->post('assets_id',true),ENT_QUOTES,'UTF-8')
            .'&area_id='.htmlspecialchars((string)$this->input->post('area_id',true),ENT_QUOTES,'UTF-8')
            .'&site_id='.htmlspecialchars((string)$this->input->post('site_id',true),ENT_QUOTES,'UTF-8')
            .'&user_id='.htmlspecialchars((string)$this->input->post('user_id',true),ENT_QUOTES,'UTF-8');
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }
    }
?>