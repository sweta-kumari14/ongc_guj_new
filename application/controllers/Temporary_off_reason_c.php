<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Temporary_off_reason_c extends MY_Controller
    {
        public function __construct()
        {
            parent:: __construct();
        }

        public function index()
        {
            
            $api = 'Temporary_off_reason_master/ReasonList';
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'));
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            $d['reason_list'] = $result['data'];
            // echo '<pre>';
            // print_r($d['reason_list']);die;

            $module_name = 'Reason List';
            $api = 'Master/AccessLog';
            $data = 'id='.htmlspecialchars($this->session->userdata('id')).'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $d['v'] = "reson_view";
            $this->load->view('templates',$d); 
        }

        public function add_reason_page()
        {
            
            $d['v'] = "add/add_reason_view";
            $this->load->view('templates',$d);
        }

        public function add_reason()
        {
            $userid = htmlspecialchars($this->session->userdata('id'));

            $module_name = 'Add Reason';
            $api = 'Master/AccessLog';
            $data = 'id='.$userid.'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $api = 'Temporary_off_reason_master/AddReason';
            $data = 'reason='.htmlspecialchars($this->input->post('reason',true)).
            '&company_id='.htmlspecialchars($this->session->userdata('company_id')).
            '&c_by='.$userid;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            if($result['response_code'] == 200)
            {
                $this->session->set_flashdata('success', $result['msg']);
                redirect('Temporary_off_reason_c');
            }
            else
            {
                $this->session->set_flashdata('error', $result['msg']);
                redirect('Temporary_off_reason_c');
            }
        }

       
        public function delete_reason()
        {
            $userId = htmlspecialchars($this->session->userdata('id'));

            $module_name = 'Delete Reason Data';
            $api = 'Master/AccessLog';
            $data = 'id='.$userId.'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $api = 'Temporary_off_reason_master/delete_reason';
            $method = 'POST';
            $data = 'id='.htmlspecialchars($this->input->post('id',true)).'&d_by='.$userId;
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }
    }
?>