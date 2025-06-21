<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    date_default_timezone_set('Asia/Kolkata');
    class Device_installation_report_c extends MY_Controller
    {
        public function __construct()
        {
            parent:: __construct();
            
        }

        public function index()
        {
            $api = 'Master/get_AssetList';
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'))
                    .'&user_id='.htmlspecialchars($this->session->userdata('user_id'));
            $method = 'POST';
            $result = $this->CallAPI($api,$data,$method);
            $d['assets_list'] = $result['data'];

            // print_r($d['assets_list']);die;
            $d['v'] = "device_installtion_report_view";
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
            $api = 'Well_site_device_Installtion/device_installation_report';
            $method = 'POST';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id',true),ENT_QUOTES,'UTF-8')
            .'&from_date='.htmlspecialchars((string)$this->input->post('from_date',true),ENT_QUOTES,'UTF-8')
            .'&to_date='.htmlspecialchars((string)$this->input->post('to_date',true),ENT_QUOTES,'UTF-8')
            .'&assets_id='.htmlspecialchars((string)$this->input->post('assets_id',true),ENT_QUOTES,'UTF-8')
            .'&area_id='.htmlspecialchars((string)$this->input->post('area_id',true),ENT_QUOTES,'UTF-8')
            .'&site_id='.htmlspecialchars((string)$this->input->post('site_id',true),ENT_QUOTES,'UTF-8');
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }

        public function device_replacement_report()
        {
            $api = 'Well_master/Well_List';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            $d['wellList'] = $result['data'];
            // echo "<pre>";
            // print_r($d); die;
            $d['v'] = "reports/device_replacement_report_view";
            $this->load->view('templates',$d); 
        }

        public function get_replacement_report_list()
        {
            $api = 'Report/Replacent_changes_Report';
            $method = 'POST';
            $data = 'company_id='.htmlspecialchars($this->input->post('company_id',true))
            .'&from_date='.htmlspecialchars((string)$this->input->post('from_date',true),ENT_QUOTES,'UTF-8')
            .'&to_date='.htmlspecialchars((string)$this->input->post('to_date',true),ENT_QUOTES,'UTF-8')
            .'&well_id='.htmlspecialchars((string)$this->input->post('well_id',true),ENT_QUOTES,'UTF-8')
            .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id',true),ENT_QUOTES,'UTF-8');
 // print_r($data); die;
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }
    }
?>

