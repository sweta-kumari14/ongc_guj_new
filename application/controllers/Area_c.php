<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Area_c extends MY_Controller
    {
        public function __construct()
        {
            parent:: __construct();
        }

        public function index()
        {
            
            $api = 'Area_master/AreaList';
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'));
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            $d['area_list'] = $result['data'];
            // echo '<pre>';
            // print_r($d['area_list']);die;

            $module_name = 'Area List';
            $api = 'Master/AccessLog';
            $data = 'id='.htmlspecialchars($this->session->userdata('id')).'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $d['v'] = "area_view";
            $this->load->view('templates',$d); 
        }

        public function add_area_page()
        {
            $api = 'Master/Assets_list';
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'));
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            $d['assets_list'] = $result['data'];

            $d['v'] = "add/add_area_view";
            $this->load->view('templates',$d);
        }

        public function add_area()
        {
            $userid = htmlspecialchars($this->session->userdata('id'));

            $module_name = 'Add Area';
            $api = 'Master/AccessLog';
            $data = 'id='.$userid.'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $api = 'Area_master/AddArea';
            $data = 'area_name='.htmlspecialchars($this->input->post('area_name',true)).
            '&company_id='.htmlspecialchars($this->session->userdata('company_id')).
            '&assets_id='.htmlspecialchars($this->input->post('assets_name')).
            '&c_by='.$userid;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            if($result['response_code'] == 200)
            {
                $this->session->set_flashdata('success', $result['msg']);
                redirect('Area_c');
            }
            else
            {
                $this->session->set_flashdata('error', $result['msg']);
                redirect('Area_c');
            }
        }

        public function edit_area()
        {

            $id = htmlspecialchars($this->uri->segment(3));
            $api = 'Area_master/AreaList';
            $data = 'id='.$id;
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['area_list'] = $result['data'];

            // echo "<pre>";
            // print_r($result);die;
            $api = 'Master/Assets_list';
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'));
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            $d['assets_list'] = $result['data'];

            $d['v'] = 'edit/edit_area_view';
            $this->load->view('templates',$d);  
        }

        public function update_area()
        {
            $userId = htmlspecialchars($this->session->userdata('id'));
            $module_name = 'Edit Area Data';
            $api = 'Master/AccessLog';
            $data = 'id='.$userId.'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $api = 'Area_master/UpdateArea';
            $data = 'id='.htmlspecialchars($this->input->post('id',true))
            .'&area_name='.htmlspecialchars($this->input->post('area_name',true))
            .'&assets_id='.htmlspecialchars($this->input->post('assets_name',true))
            .'&d_by='.$userId;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            if($result['response_code'] == 200)
            {
                $this->session->set_flashdata('success', $result['msg']);
                redirect('Area_c');
            }
            else
            {
                $this->session->set_flashdata('error', $result['msg']);
                redirect('Area_c');
            }
        }

        public function delete_area()
        {
            $userId = htmlspecialchars($this->session->userdata('id'));

            $module_name = 'Delete Area Data';
            $api = 'Master/AccessLog';
            $data = 'id='.$userId.'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $api = 'Area_master/deleteArea';
            $method = 'POST';
            $data = 'id='.htmlspecialchars($this->input->post('id',true)).'&d_by='.$userId;
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }
    }
?>