<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    date_default_timezone_set('Asia/Kolkata');

    class Threshold_setup_selfflow_c extends MY_Controller
    {
        public function __construct()
        {
            parent::__construct();
        }

        public function index()
        {
             $api = 'Area_Dashboard/AreaList_forDashboard';
            $data = 'company_id=' . htmlspecialchars((string)$this->session->userdata('company_id'), ENT_QUOTES, 'UTF-8')
                  . '&assets_id=' . htmlspecialchars((string)$this->input->post('assets_id', true), ENT_QUOTES, 'UTF-8')
                  . '&user_id=' . htmlspecialchars((string)$this->session->userdata('user_id'), ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api, $data, $method);
            $d['area_list'] = $result['data'];

            
             $api ='Selfflow_area_dashboard/WellList_forDashboard';
        $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
        .'&assets_id='.htmlspecialchars((string)$this->session->userdata('assets_id'),ENT_QUOTES, 'UTF-8')
        .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id'),ENT_QUOTES, 'UTF-8');
        $method = 'POST';
        $result = $this->CALLAPI($api,$data,$method);
        $d['well_list'] = $result['data'];
            // echo'<pre>';
            // print_r($d['well_list']);die;

            $d['v'] = "thresold_setup_selfflow";
            $this->load->view('templates', $d); 
        }
         public function get_imei_no()
        {
            $api = 'Device_Threshold_Details/Well_Wise_imeiList';
            $data = 'well_id='.htmlspecialchars($this->input->post('well_id',true));
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }

        public function add_threshold_setup()
        {
            $api ='Device_Threshold_Details/Save_ThresholdData';
            $data = 'well_id='.htmlspecialchars($this->input->post('well_id',true)).
            '&imei_no='.htmlspecialchars($this->input->post('imei_no',true)).
            '&output_p2p_ut='.htmlspecialchars($this->input->post('out_p2p_ut',true)).
            '&output_p2p_lt='.htmlspecialchars($this->input->post('out_p2p_lt',true)).
            '&out_current_ut='.htmlspecialchars($this->input->post('out_current_ut',true)).
            '&out_current_lt='.htmlspecialchars($this->input->post('out_current_lt',true)).
            '&c_by='.htmlspecialchars($this->session->userdata('id'));
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            if($result['response_code'] == 200)
            {
                $this->session->set_flashdata('success', $result['msg']);
                redirect('Threshold_setup_c');
            }
            else
            {
                $this->session->set_flashdata('error', $result['msg']);
                redirect('Threshold_setup_c');
            }
        }

        public function get_well_threshold_details()
        {
            $api = 'Device_Threshold_Details/Threshold_DetailsList';
            $data = 'well_id='.htmlspecialchars($this->input->post('well_id',true)).
            '&imei_no='.htmlspecialchars($this->input->post('imei_no',true));
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }
    
    }
?>    