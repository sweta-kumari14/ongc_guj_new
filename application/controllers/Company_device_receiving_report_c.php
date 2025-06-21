<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    date_default_timezone_set('Asia/Kolkata');
    class Company_device_receiving_report_c extends MY_Controller
    {
        public function __construct()
        {
            parent:: __construct();
        }

        public function index()
        {
            $module_name = 'Company Device receiving Report Module';
            $api = 'Master/AccessLog';
            $data = 'id='.htmlspecialchars((string)$this->session->userdata('id'),ENT_QUOTES, 'UTF-8').'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $d['v'] = "company_device_receiving_report_view";
            $this->load->view('templates',$d); 
        }

        public function get_device_receiving_report()
        {
            $api = 'Report/DeviceReceiving_Report';
            $method = 'POST';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id',true),ENT_QUOTES, 'UTF-8')
            .'&from_date='.htmlspecialchars((string)$this->input->post('from_date',true),ENT_QUOTES, 'UTF-8')
            .'&to_date='.htmlspecialchars((string)$this->input->post('to_date',true),ENT_QUOTES, 'UTF-8');
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }

        public function Device_allotment_to_installer()
        {
            $module_name = 'Device allotment to installer Report Module';
            $api = 'Master/AccessLog';
            $data = 'id='.htmlspecialchars((string)$this->session->userdata('id',ENT_QUOTES, 'UTF-8')).'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

        	$api = 'DeviceAllotment_to_Installer/AllotUser_List';
            $method = 'POST';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id',true),ENT_QUOTES, 'UTF-8');
            $result = $this->CallAPI($api, $data, $method);	
            $d['user_list'] = $result['data'];
            // echo "<pre>";
            // print_r($result);die;
            $d['v'] = "report/device_allotment_to_installer_view";
            $this->load->view('templates',$d); 
        }

        public function device_allotment_to_installer_report()
        {
            $api = 'Report/DeviceAllotment_to_Installer_Report';
            $method = 'POST';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id',true,ENT_QUOTES, 'UTF-8'))
            .'&from_date='.htmlspecialchars((string)$this->input->post('from_date',true),ENT_QUOTES, 'UTF-8')
            .'&to_date='.htmlspecialchars((string)$this->input->post('to_date',true),ENT_QUOTES, 'UTF-8')
            .'&user_id='.htmlspecialchars((string)$this->input->post('user_id',true),ENT_QUOTES, 'UTF-8');
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }

        public function userwise_site_allotment()
        {
            $module_name = 'User Wise Site allotment Report Module';
            $api = 'Master/AccessLog';
            $data = 'id='.htmlspecialchars((string)$this->session->userdata('id'),ENT_QUOTES, 'UTF-8').'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

        	$api = 'Master/Arealist';
            $method = 'POST';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id',true),ENT_QUOTES, 'UTF-8');
            $result = $this->CallAPI($api, $data, $method);	
            $d['area_list'] = $result['data'];
            // echo "<pre>";
            // print_r($result);die;

            $api = 'Master/User_list';
            $method = 'POST';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id',true),ENT_QUOTES, 'UTF-8');
            $result = $this->CallAPI($api, $data, $method);	
            $d['user_list'] = $result['data'];
            // echo "<pre>";
            // print_r($result);die;
            $d['v'] = "site_allotment_report_view";
            $this->load->view('templates',$d); 
        }

        public function get_site_list()
        {
        	$api = 'Master/Site_list';
            $method = 'POST';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id',true),ENT_QUOTES, 'UTF-8')
            .'&area_id='.htmlspecialchars((string)$this->input->post('area_id',true),ENT_QUOTES, 'UTF-8');
            $result = $this->CallAPI($api, $data, $method);	
            echo json_encode($result);
        }

        public function userwise_site_report()
        {
            $api = 'Report/SiteUser_Allotment_Report';
            $method = 'POST';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id',true,ENT_QUOTES, 'UTF-8'))
            .'&from_date='.htmlspecialchars((string)$this->input->post('from_date',true),ENT_QUOTES, 'UTF-8')
            .'&to_date='.htmlspecialchars((string)$this->input->post('to_date',true),ENT_QUOTES, 'UTF-8')
            .'&site_id='.htmlspecialchars((string)$this->input->post('site_id',true),ENT_QUOTES, 'UTF-8')
            .'&user_id='.htmlspecialchars((string)$this->input->post('user_id',true),ENT_QUOTES, 'UTF-8')
            .'&area_id='.htmlspecialchars((string)$this->input->post('area_id',true),ENT_QUOTES, 'UTF-8');
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }
    }
?>