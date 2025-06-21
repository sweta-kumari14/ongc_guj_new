<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Tag_master_c extends MY_Controller
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

            $d['v'] = "tag_master_view";
            $this->load->view('templates',$d); 
        }

        public function tagMaster_list()
        {
            $api = 'Tags_master/Tag_List';
            $data = 'company_id='.$this->session->userdata('company_id',true).
                    '&component_id='.$this->input->post('component_id',true);
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }

        public function add_Tag_data()
        {
            // print_r($_POST); die;
            $api = 'Tags_master/Add_tag_number';
            $data = 'tag_number='.htmlspecialchars($this->input->post('tag_number',true)).
                    '&component_id='.htmlspecialchars($this->input->post('component_id')).
                    '&company_id='.htmlspecialchars($this->session->userdata('company_id')).
                    '&c_by='.htmlspecialchars($this->session->userdata('company_id'));
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            if($result['response_code'] == 200)
            {
                $this->session->set_flashdata('success', $result['msg']);
                redirect('Tag_master_c');
            }
            else
            {
                $this->session->set_flashdata('error', $result['msg']);
                redirect('Tag_master_c');
            }
            // echo json_encode($result);
        }

        public function update_TagData()
        {
            $api = 'Tags_master/Update_TagData';
            $data = 'id='.htmlspecialchars($this->input->post('id',true)).
                    '&tag_number='.htmlspecialchars($this->input->post('tag_number',true)).
                    '&component_id='.htmlspecialchars($this->input->post('component_id')).
                    '&company_id='.htmlspecialchars($this->session->userdata('company_id')).
                    '&d_by='.htmlspecialchars($this->session->userdata('company_id'));
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            if($result['response_code'] == 200)
            {
                $this->session->set_flashdata('success', $result['msg']);
                redirect('Tag_master_c');
            }
            else
            {
                $this->session->set_flashdata('error', $result['msg']);
                redirect('Tag_master_c');
            }
            // echo json_encode($result);
        }

        public function get_tag_details()
        {
            $api = 'Tags_master/Tag_List';
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id')) . '&id='.htmlspecialchars($this->input->post('id',true));
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }

        public function deleteTag_data()
        {
            $api = 'Tags_master/deleteTag';
            $method = 'POST';
            $data = 'id='.htmlspecialchars($this->input->post('id',true)).
                    '&d_by='.htmlspecialchars($this->session->userdata('company_id'));
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }
    }
?>