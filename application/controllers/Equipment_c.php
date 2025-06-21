<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Equipment_c extends MY_Controller
    {
        public function __construct()
        {
            parent:: __construct();
        }

        public function index()
        {
            $module_name = 'Equipment List';
            $api = 'Master/AccessLog';
            $data = 'id='.htmlspecialchars($this->session->userdata('id')).'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $api = 'Equipment_master/EquipmentList';
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'));
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            $d['equipment_list'] = $result['data'];
            // echo "<pre>";
            // print_r($result);die;
            $d['v'] = "equipment_view";
            $this->load->view('templates',$d); 
        }

         public function add_Equipment_page()
        {
            $d['v'] = "add/add_equipment_view";
            $this->load->view('templates',$d);
        }

        public function add_equipment()
        {
            $userid = htmlspecialchars($this->session->userdata('id'));

            $module_name = 'Add Equipment Data';
            $api = 'Master/AccessLog';
            $data = 'id='.$userid.'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $api = 'Equipment_master/AddEquipment';
            $data = 'equipment_name='.htmlspecialchars($this->input->post('equipment_name',true)).
            '&company_id='.htmlspecialchars($this->session->userdata('company_id')).
            '&c_by='.$userid;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            if($result['response_code'] == 200)
            {
                $this->session->set_flashdata('success', $result['msg']);
                redirect('Equipment_c');
            }
            else
            {
                $this->session->set_flashdata('error', $result['msg']);
                redirect('Equipment_c');
            }
        }



        public function edit_equipment()
        {
             $id = htmlspecialchars($this->uri->segment(3));
            $api = 'Equipment_master/EquipmentList';
            $data = 'id='.$id;
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['last_equipment_data'] = $result['data'];


            $d['v'] = 'edit/edit_equipment_view';
            $this->load->view('templates',$d);
        }

        public function update_equipment()
        {
            $userId = htmlspecialchars($this->session->userdata('id'));

            $module_name = 'Edit Equipment Data';
            $api = 'Master/AccessLog';
            $data = 'id='.$userId.'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $api = 'Equipment_master/UpdateEquipment';
            $data = 'id='.htmlspecialchars($this->input->post('id',true))
            .'&equipment_name='.htmlspecialchars($this->input->post('equipment_name',true))
            .'&d_by='.$userId;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            if($result['response_code'] == 200)
            {
                $this->session->set_flashdata('success', $result['msg']);
                redirect('Equipment_c');
            }
            else
            {
                $this->session->set_flashdata('error', $result['msg']);
                redirect('Equipment_c');
            }
        }

        public function delete_equipment()
        {
            $userId = htmlspecialchars($this->session->userdata('id'));

            $module_name = 'Delete Equipment Data';
            $api = 'Master/AccessLog';
            $data = 'id='.$userId.'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $api = 'Equipment_master/deleteEquipment';
            $method = 'POST';
            $data = 'id='.htmlspecialchars($this->input->post('id',true)).'&d_by='.$userId;
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }
    }
?>