<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    date_default_timezone_set('Asia/Kolkata');
    class Temp_running_log_c extends MY_Controller
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
            
            $d['v'] = "temp_running_log_view";
            $this->load->view('templates',$d); 
        }


        public function feeder_list()
        {
            $api ='FeederMaster/FeederList_sitedata';
            $data = 'site_id='.htmlspecialchars((string)$this->input->post('site_id',true));
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }

        public function Well_list()
        {
            $api ='Area_Dashboard/WellList_forDashboard';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
            .'&assets_id='.htmlspecialchars((string)$this->input->post('assets_id',true),ENT_QUOTES, 'UTF-8')
            .'&site_id='.htmlspecialchars((string)$this->input->post('site_id',true),ENT_QUOTES, 'UTF-8')
            .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id'),ENT_QUOTES, 'UTF-8')
            .'&feeder_id='.htmlspecialchars((string)$this->input->post('feeder_id',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }

        public function get_well_wise_report()
        {
            $api = 'Daily_Runniny_Report/Device_TempWellRunning_Details';
            $method = 'POST';
            $data = 'well_id='.htmlspecialchars((string)$this->input->post('well_id',true),ENT_QUOTES, 'UTF-8')
                    .'&from_date='.htmlspecialchars((string)$this->input->post('from_date',true),ENT_QUOTES, 'UTF-8')
                    .'&to_date='.htmlspecialchars((string)$this->input->post('to_date',true),ENT_QUOTES, 'UTF-8')
                    .'&sort_by='.htmlspecialchars((string)$this->input->post('sort_by',true),ENT_QUOTES, 'UTF-8')
                    .'&site_id='.htmlspecialchars((string)$this->input->post('site_id',true),ENT_QUOTES, 'UTF-8')
                    .'&feeder_id='.htmlspecialchars((string)$this->input->post('feeder_id',true),ENT_QUOTES, 'UTF-8');
            $result = $this->CallAPI($api, $data, $method);


            echo json_encode($result);
        }

        public function get_datewise_running_report()
        {
            $api = 'Daily_Runniny_Report/Datewise_TempWellRunning_Details';
            $method = 'POST';
            $data = 'date='.htmlspecialchars((string)$this->input->post('date',true),ENT_QUOTES, 'UTF-8')
            .'&sort_by='.htmlspecialchars((string)$this->input->post('sort_by',true),ENT_QUOTES, 'UTF-8')
            .'&site_id='.htmlspecialchars((string)$this->input->post('site_id',true),ENT_QUOTES, 'UTF-8')
            .'&feeder_id='.htmlspecialchars((string)$this->input->post('feeder_id',true),ENT_QUOTES, 'UTF-8');
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }

        Public function get_well_commulative_log_report()
        {
            
            $api = 'Daily_Runniny_Report/Well_temprunningComulative_log_Report';
            $method = 'POST';
            $data = 'well_id='.htmlspecialchars((string)$this->input->post('well_id',true),ENT_QUOTES, 'UTF-8')
                    .'&from_date='.htmlspecialchars((string)$this->input->post('from_date',true),ENT_QUOTES, 'UTF-8')
                    .'&to_date='.htmlspecialchars((string)$this->input->post('to_date',true),ENT_QUOTES, 'UTF-8')
                    .'&sort_by='.htmlspecialchars((string)$this->input->post('sort_by',true),ENT_QUOTES, 'UTF-8')
                    .'&site_id='.htmlspecialchars((string)$this->input->post('site_id',true),ENT_QUOTES, 'UTF-8')
                    .'&feeder_id='.htmlspecialchars((string)$this->input->post('feeder_id',true),ENT_QUOTES, 'UTF-8');
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }
    }
?>