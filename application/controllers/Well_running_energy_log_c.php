
<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    date_default_timezone_set('Asia/Kolkata');
    class Well_running_energy_log_c extends MY_Controller
    {
        public function __construct()
        {
            parent:: __construct();
            
        }

        public function index()
        {
            
            $api ='Area_Dashboard/SiteList_forDashboard';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
            .'&assets_id='.htmlspecialchars((string)$this->input->post('assets_id',true),ENT_QUOTES, 'UTF-8')
            .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id'),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['site_list'] = $result['data'];
            
            // echo'<pre>';
            // print_r($d['site_list']);die;

        	$d['v'] = "well_running_energy_log_view";
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

        public function get_running_and_energy_log_data()
        {
            $api = 'Report/Well_running_Energy_Consumption_log_report';
            $data = 'site_id='.htmlspecialchars((string)$this->input->post('site_id',true),ENT_QUOTES, 'UTF-8')
                     .'&from_date='.htmlspecialchars((string)$this->input->post('from_date',true),ENT_QUOTES, 'UTF-8')
                    .'&to_date='.htmlspecialchars((string)$this->input->post('to_date',true),ENT_QUOTES, 'UTF-8')
                    .'&sort_by='.htmlspecialchars((string)$this->input->post('sort_by',true),ENT_QUOTES, 'UTF-8')
                    .'&well_id='.htmlspecialchars((string)$this->input->post('well_id',true),ENT_QUOTES, 'UTF-8')
                    .'&feeder_id='.htmlspecialchars((string)$this->input->post('feeder_id',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CallAPI($api,$data,$method);
            echo json_encode($result);
        }

         public function get_running_and_energy_log_Assets_wise_data()
        {
            $api = 'Report/Well_running_Assets_wise_report';
            $data = 'site_id='.htmlspecialchars((string)$this->input->post('site_id',true),ENT_QUOTES, 'UTF-8')
                     .'&from_date='.htmlspecialchars((string)$this->input->post('from_date',true),ENT_QUOTES, 'UTF-8')
                     .'&sort_by='.htmlspecialchars((string)$this->input->post('sort_by',true),ENT_QUOTES, 'UTF-8')
                    .'&to_date='.htmlspecialchars((string)$this->input->post('to_date',true),ENT_QUOTES, 'UTF-8');
                   
            $method = 'POST';
            $result = $this->CallAPI($api,$data,$method);
            echo json_encode($result);
        }
    }
?>