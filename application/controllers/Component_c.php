<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Component_c extends MY_Controller
    {
        public function __construct()
        {
            parent:: __construct();
            
        }

        public function index()
        { 

            $api = 'Component_master/Component_List';
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'));
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            $d['component_list'] = $result['data'];

            $d['v'] = "component_view";
            $this->load->view('templates',$d); 
        }

        public function add_component()
        {
         
            $api = 'Component_master/Add_component';
            $data = 'component_name='.htmlspecialchars($this->input->post('component_name',true)).
            '&company_id='.htmlspecialchars($this->session->userdata('company_id')).
            '&c_by='.htmlspecialchars($this->session->userdata('company_id'));
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
                //print_r($data); die;
                //print_r($result);
                //die;

            if($result['response_code'] == 200)
            {
                $this->session->set_flashdata('success', $result['msg']);
                redirect('Component_c');
            }
            else
            {
                $this->session->set_flashdata('error', $result['msg']);
                redirect('Component_c');
            }
         echo json_encode($result);
        }

         public function update_Component()
        {
            $api = 'Component_master/Update_Component';
            $data = 'id='.htmlspecialchars($this->input->post('id',true))
            .'&component_name='.htmlspecialchars($this->input->post('component_name',true))
            .'&d_by='.htmlspecialchars($this->session->userdata('company_id'));
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            if($result['response_code'] == 200)
            {
                $this->session->set_flashdata('success', $result['msg']);
                redirect('Component_c');
            }
            else
            {
                $this->session->set_flashdata('error', $result['msg']);
                redirect('Component_c');
            }
            // echo json_encode($result);
        }

        public function get_component_details()
        {
            $api = 'Component_master/Component_List';
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id')) . '&id='.htmlspecialchars($this->input->post('id',true));
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }

        public function delete_Component()
        {
            $api = 'Component_master/deleteComponent';
            $method = 'POST';
            $data = 'id='.htmlspecialchars($this->input->post('id',true)).
                    '&d_by='.htmlspecialchars($this->session->userdata('company_id'));
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }
    }
?>