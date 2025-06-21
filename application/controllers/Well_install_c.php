<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    date_default_timezone_set('Asia/Kolkata');
    class Well_install_c extends MY_Controller
    {
        public function __construct()
        {
            parent:: __construct();
            
        }

        public function index()
        {
           $api ='Master/Well_list';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['well_list'] = $result['data'];

            $d['v'] = "well_reinstall_details_monthly_view";
            $this->load->view('templates',$d); 
        }

        public function add_well_install()
        {
            $userid = htmlspecialchars($this->session->userdata('id'));
            $api = 'Well_reinstall_monthly/Addwellreinstall';
            $data = 'well_id='.htmlspecialchars($this->input->post('well_id',true)).
            '&date='.htmlspecialchars($this->input->post('date',true)).
            '&reason='.htmlspecialchars($this->input->post('reason')).
            '&c_by='.$userid;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            // print_r($data);
            // print_r($result);die;
            if($result['response_code'] == 200)
            {
                $this->session->set_flashdata('success', $result['msg']);
                redirect('Well_install_c');
            }
            else
            {
                $this->session->set_flashdata('error', $result['msg']);
                redirect('Well_install_c');
            }
        }

    }
?>