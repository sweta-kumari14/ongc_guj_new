<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    date_default_timezone_set('Asia/Kolkata');
    class Alert_report_c extends MY_Controller
    {
        public function __construct()
        {
            parent:: __construct();
        }

        public function index()
        {
            $module_name = 'Visit Alert Report Module';
            $api = 'Master/AccessLog';
            $data = 'id='.htmlspecialchars((string)$this->session->userdata('id'),ENT_QUOTES, 'UTF-8').'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $api ='Area_Dashboard/WellList_forDashboard';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
            .'&assets_id='.htmlspecialchars((string)$this->session->userdata('assets_id'),ENT_QUOTES, 'UTF-8')
            .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id'),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['well_list'] = $result['data'];

            // echo "<pre>";
            // print_r($result);die;


            $d['v'] = "alert_report_view";
            $this->load->view('templates',$d); 
        }

        public function get_alert_report()
        {
            $api = 'Area_Dashboard/Alert_Report';
            $method = 'POST';
            $data = 'well_id='.htmlspecialchars((string)$this->input->post('well_id',true),ENT_QUOTES, 'UTF-8')
            .'&from_date='.htmlspecialchars((string)$this->input->post('from_date',true),ENT_QUOTES, 'UTF-8')
            .'&to_date='.htmlspecialchars((string)$this->input->post('to_date',true),ENT_QUOTES, 'UTF-8')
            .'&sort_by='.htmlspecialchars((string)$this->input->post('sort_by',true),ENT_QUOTES, 'UTF-8')
            .'&user_id='.htmlspecialchars((string)$this->input->post('user_id',true),ENT_QUOTES, 'UTF-8');
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }

        public function get_datewise_alert_report()
        {
            $api = 'Area_Dashboard/Datewise_Alert_Log';
            $method = 'POST';
            $data = 'date='.htmlspecialchars((string)$this->input->post('date',true),ENT_QUOTES, 'UTF-8')
            .'&sort_by='.htmlspecialchars((string)$this->input->post('sort_by',true),ENT_QUOTES, 'UTF-8')
            .'&user_id='.htmlspecialchars((string)$this->input->post('user_id',true),ENT_QUOTES, 'UTF-8');
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }

        public function get_area_list()
        {
            $api = 'Master/Arealist';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
            .'&assets_id='.htmlspecialchars((string)$this->input->post('assets_id',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }

        public function get_site_list()
        {
            $api = 'Master/areaWiseSite_list';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
            .'&area_id='.htmlspecialchars((string)$this->input->post('area_id',true),ENT_QUOTES, 'UTF-8')
            .'&assets_id='.htmlspecialchars((string)$this->input->post('assets_id',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }

        public function get_well_list()
        {
            $api = 'Master/Well_list';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
            .'&area_id='.htmlspecialchars((string)$this->input->post('area_id',true),ENT_QUOTES, 'UTF-8')
            .'&assets_id='.htmlspecialchars((string)$this->input->post('assets_id',true),ENT_QUOTES, 'UTF-8')
            .'&site_id='.htmlspecialchars((string)$this->input->post('site_id',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }

        public function dashboard_well_alert_page()
        {

            $d['v'] = "well_wise_alert_report_view";
            $this->load->view('templates',$d); 
        }

        public function get_dashboard_alert_data()
        {
            $api = 'Area_Dashboard/Alert_Report';
            $method = 'POST';
            $data = 'well_id='.htmlspecialchars((string)$this->input->post('well_id',true),ENT_QUOTES, 'UTF-8')
            .'&from_date='.htmlspecialchars((string)$this->input->post('from_date',true),ENT_QUOTES, 'UTF-8')
            .'&sort_by='.htmlspecialchars((string)$this->input->post('sort_by',true),ENT_QUOTES, 'UTF-8')
            .'&to_date='.htmlspecialchars((string)$this->input->post('to_date',true),ENT_QUOTES, 'UTF-8');
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }


    }
?>