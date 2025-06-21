<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    date_default_timezone_set('Asia/Kolkata');
    class Max_min_value_c extends MY_Controller
    {
        public function __construct()
        {
            parent:: __construct();
        }

        public function index()
        {
            
            $api ='Area_Dashboard/WellList_forDashboard';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
            .'&assets_id='.htmlspecialchars((string)$this->session->userdata('assets_id'),ENT_QUOTES, 'UTF-8')
            .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id'),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['well_list'] = $result['data'];

            $d['v'] = "max_min_value_view";
            $this->load->view('templates',$d); 
        }

        public function get_max_and_min_value()
        {
            $api = 'Daily_Runniny_Report/Device_Max_Min_Value';
            $method = 'POST';
            $data = 'date='.htmlspecialchars((string)$this->input->post('date',true),ENT_QUOTES, 'UTF-8')
                    .'&well_id='.htmlspecialchars((string)$this->input->post('well_id',true),ENT_QUOTES, 'UTF-8')
                    .'&user_id='.htmlspecialchars((string)$this->input->post('user_id',true),ENT_QUOTES, 'UTF-8');
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }
    }
?>