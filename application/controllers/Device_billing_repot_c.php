<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    date_default_timezone_set('Asia/Kolkata');
    class Device_billing_repot_c extends MY_Controller
    {
        public function __construct()
        {
            parent:: __construct();
        }

        public function index()
        {
            
            $api ='Area_Dashboard/SiteList_forDashboard';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
            .'&assets_id='.htmlspecialchars((string)$this->session->userdata('assets_id',true),ENT_QUOTES, 'UTF-8')
            .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id'),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['site_list'] = $result['data'];
            
            $d['v'] = "device_biling_report_view";
            $this->load->view('templates',$d); 
        }

	     public  function Device_billing_repot_data()
        {
            $api ='Report/Asset_Areawise_monthlyDevice_Record_report';
            $data ='site_id='.htmlspecialchars((string)$this->input->post('site_id',true),ENT_QUOTES, 'UTF-8')
                    .'&month='.htmlspecialchars((string)$this->input->post('month',true),ENT_QUOTES, 'UTF-8')
                    .'&year='.htmlspecialchars((string)$this->input->post('year',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CallAPI($api,$data,$method);
            echo json_encode($result);
        }

         

        public function device_performance()
        {
            $api ='Area_Dashboard/SiteList_forDashboard';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
            .'&assets_id='.htmlspecialchars((string)$this->session->userdata('assets_id',true),ENT_QUOTES, 'UTF-8')
            .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id'),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['site_list'] = $result['data'];
            
            $d['v'] = "device_performance_report_view";
            $this->load->view('templates',$d);   
        } 


        public function get_device_details_report()
        {
            $api = 'Report/Device_performance_data';
            $method = 'POST';
            $data = 'site_id='.htmlspecialchars((string)$this->input->post('site_id',true),ENT_QUOTES, 'UTF-8')
                    .'&month='.htmlspecialchars((string)$this->input->post('month',true),ENT_QUOTES, 'UTF-8')
                    .'&year='.htmlspecialchars((string)$this->input->post('year',true),ENT_QUOTES, 'UTF-8');
            $result = $this->CallAPI($api, $data, $method);


            echo json_encode($result);
        }


    }
?>