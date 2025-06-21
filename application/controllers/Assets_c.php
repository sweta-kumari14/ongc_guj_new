<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Assets_c extends MY_Controller
    {
        public function __construct()
        {
            parent:: __construct();
        }

        public function index()
        {
            $api = 'Assets_Master/AssetsList';
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'));
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            $d['assets_list'] = $result['data'];

            $module_name = 'Assets List';
            $api = 'Master/AccessLog';
            $data = 'id='.htmlspecialchars($this->session->userdata('id')).'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            // echo "<pre>";
            // print_r($result);die;
            $d['v'] = "assets_view";
            $this->load->view('templates',$d); 
        }

         public function add_assets_page()
        {

            $d['v'] = "add/add_assets_master_view";
            $this->load->view('templates',$d);
        }

        public function add_assets()
        {
            $userid = htmlspecialchars($this->session->userdata('id'));

            $module_name = 'Add Assets';
            $api = 'Master/AccessLog';
            $data = 'id='.$userid.'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $api = 'Assets_Master/Add_Asset';
            $data = 'assets_name='.htmlspecialchars($this->input->post('assets_name',true)).
            '&company_id='.htmlspecialchars($this->session->userdata('company_id')).
            '&c_by='.$userid;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            if($result['response_code'] == 200)
            {
                $this->session->set_flashdata('success', $result['msg']);
                redirect('Assets_c');
            }
            else
            {
                $this->session->set_flashdata('error', $result['msg']);
                redirect('Assets_c');
            }
        }

      

         public function edit_assets()
        {

            $id = htmlspecialchars($this->uri->segment(3));
            $api = 'Assets_Master/AssetsList';
            $data = 'id='.$id;
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['assets_list'] = $result['data'];

           
            $d['v'] = 'edit/edit_assets_view';
            $this->load->view('templates',$d);  
        }

        public function update_assets()
        {

            $userId = htmlspecialchars($this->session->userdata('id'));

            $module_name = 'Edit Assets Module';
            $api = 'Master/AccessLog';
            $data = 'id='.$userId.'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $api = 'Assets_Master/Update_Asset';
            $data = 'id='.htmlspecialchars($this->input->post('id',true))
            .'&assets_name='.htmlspecialchars($this->input->post('assets_name',true))
            .'&d_by='.$userId;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            if($result['response_code'] == 200)
            {
                $this->session->set_flashdata('success', $result['msg']);
                redirect('Assets_c');
            }
            else
            {
                $this->session->set_flashdata('error', $result['msg']);
                redirect('Assets_c');
            }
        }

        public function delete_assets()
        {
            $userId = htmlspecialchars($this->session->userdata('id'));

            $module_name = 'Delete Assets Data';
            $api = 'Master/AccessLog';
            $data = 'id='.$userId.'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $api = 'Assets_Master/deleteAssets';
            $method = 'POST';
            $data = 'id='.htmlspecialchars($this->input->post('id',true)).'&d_by='.$userId;
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }
    }
?>