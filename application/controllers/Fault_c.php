<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Fault_c extends MY_Controller
    {
        public function __construct()
        {
            parent:: __construct();
        }

        public function index()
        {
            $module_name = 'Fault List';
            $api = 'Master/AccessLog';
            $data = 'id='.htmlspecialchars($this->session->userdata('id')).'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $api = 'Fault_master/FaultList';
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'));
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            $d['fault_list'] = $result['data'];
            // echo "<pre>";
            // print_r($result);die;
            $d['v'] = "fault_view";
            $this->load->view('templates',$d); 
        }

         public function add_Fault_page()
        {
            $d['v'] = "add/add_fault_view";
            $this->load->view('templates',$d);
        }

        public function add_faults()
        {
        	
            $userid = htmlspecialchars($this->session->userdata('id'));

            $api = 'Fault_master/Add_Fault';
            $data = 'fault_name='.htmlspecialchars($this->input->post('fault_name',true)).
            '&color_code='.htmlspecialchars($this->input->post('color_code',true)).
            '&company_id='.htmlspecialchars($this->session->userdata('company_id')).
            '&c_by='.$userid;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            if($result['response_code'] == 200)
            {
                $this->session->set_flashdata('success', $result['msg']);
                redirect('Fault_c');
            }
            else
            {
                $this->session->set_flashdata('error', $result['msg']);
                redirect('Fault_c');
            }
        }

        public function edit_faults()
        {

            $id = htmlspecialchars($this->uri->segment(3));
            $api = 'Fault_master/FaultList';
            $data = 'id='.$id;
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['fault_list'] = $result['data'];


            $d['v'] = 'edit/edit_fault_view';
            $this->load->view('templates',$d);  
        }



        public function update_faults()
        {
            $userId = $this->session->userdata('id');

            

            $api = 'Fault_master/Update_Fault';
            $data = 'id='.$this->input->post('id',true).
            '&fault_name='.$this->input->post('fault_name',true).
            '&color_code='.$this->input->post('color_code',true).
            '&d_by='.$userId;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            if($result['response_code'] == 200)
            {
                $this->session->set_flashdata('success', $result['msg']);
                redirect('Fault_c');
            }
            else
            {
                $this->session->set_flashdata('error', $result['msg']);
                redirect('Fault_c');
            }
        }

        public function delete_faults()
        {
            $userId = htmlspecialchars($this->session->userdata('id'));

            $module_name = 'Delete Fault Details';
            $api = 'Master/AccessLog';
            $data = 'id='.$userId.'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $api = 'Fault_master/deleteFault';
            $method = 'POST';
            $data = 'id='.htmlspecialchars($this->input->post('id',true)).'&d_by='.$userId;
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }
    }
?>