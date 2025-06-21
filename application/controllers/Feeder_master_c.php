<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Feeder_master_c extends MY_Controller
    {
        public function __construct()
        {
            parent:: __construct();
        }

        public function index()
        {
            
            $api ='FeederMaster/FeederList';
            $data = '';
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['feeder_list'] = $result['data'];
            // echo '<pre>';
            // print_r($d['feeder_list']);die;

            $module_name = 'Feeder List';
            $api = 'Master/AccessLog';
            $data = 'id='.htmlspecialchars($this->session->userdata('id')).'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $d['v'] = "feeder_view";
            $this->load->view('templates',$d); 
        }

        public function add_feeder_page()
        {
            $api ='Area_Dashboard/AreaList_forDashboard';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['area_list'] = $result['data'];

           
            // echo '<pre>';
            // print_r($d['area_list']);die;


            $d['v'] = "add/add_feeder_view";
            $this->load->view('templates',$d);
        }

        public function add_feeder()
        {
            $userid = htmlspecialchars($this->session->userdata('id'));

            $module_name = 'Add Area';
            $api = 'Master/AccessLog';
            $data = 'id='.$userid.'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $api = 'FeederMaster/AddFeeder';
            $data = 'feeder_name='.htmlspecialchars($this->input->post('feeder_name',true)).
                     '&area_id='.htmlspecialchars($this->input->post('area_id')).
            '&c_by='.$userid;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            if($result['response_code'] == 200)
            {
                $this->session->set_flashdata('success', $result['msg']);
                redirect('Feeder_master_c');
            }
            else
            {
                $this->session->set_flashdata('error', $result['msg']);
                redirect('Feeder_master_c');
            }
        }

        public function edit_feeder()
        {

            $id = htmlspecialchars($this->uri->segment(3));
            $api = 'FeederMaster/FeederList';
            $data = 'id='.$id;
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['feeder_list'] = $result['data'];

            // echo "<pre>";
            // print_r($result);die;
           

            $d['v'] = 'edit/edit_feeder_view';
            $this->load->view('templates',$d);  
        }

        public function update_feeder()
        {
            $userId = htmlspecialchars($this->session->userdata('id'));
            $module_name = 'Edit Feeder Data';
            $api = 'Master/AccessLog';
            $data = 'id='.$userId.'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $api = 'FeederMaster/updateFeederData';
            $data = 'id='.htmlspecialchars($this->input->post('id',true))
            .'&feeder_name='.htmlspecialchars($this->input->post('feeder_name',true))
            .'&d_by='.$userId;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            if($result['response_code'] == 200)
            {
                $this->session->set_flashdata('success', $result['msg']);
                redirect('Feeder_master_c');
            }
            else
            {
                $this->session->set_flashdata('error', $result['msg']);
                redirect('Feeder_master_c');
            }
        }

        public function delete_feeder()
        {
            $userId = htmlspecialchars($this->session->userdata('id'));

            $module_name = 'Delete Feeder Data';
            $api = 'Master/AccessLog';
            $data = 'id='.$userId.'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $api = 'FeederMaster/deleteFeederData';
            $method = 'POST';
            $data = 'id='.htmlspecialchars($this->input->post('id',true)).'&d_by='.$userId;
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }
    }
?>