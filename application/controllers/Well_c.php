<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    date_default_timezone_set('Asia/Kolkata');
    class Well_c extends MY_Controller
    {
        public function __construct()
        {
            parent:: __construct();
            
        }

        public function index()
        {
            $module_name = 'Well List';
            $api = 'Master/AccessLog';
            $data = 'id='.htmlspecialchars($this->session->userdata('id')).'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $api ='Well_master/Well_List';
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'));
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['well_list'] = $result['data'];

            $api = 'Well_type_master/Welllist';
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'));
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            $d['well_type_list'] = $result['data'];


            $d['v'] = "well_view";
            $this->load->view('templates',$d); 
        }

        public function well_list_ajax()
        {
            $api ='Well_master/Well_List';
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'))
                     .'&well_type='.$this->input->post('well_type',true);
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
            

        }
        public function well_type_list_ajax()
        {
            $api='Well_type_master/Welllist';
             $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'));
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
           echo json_encode($result);
        }

        public function add_well_page()
        {
            $api ='Master/Assets_list';
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'));
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['assets_list'] = $result['data'];
           
  

            $api ='Well_type_master/Welllist';
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'));
            $method = 'POST';
            $result =$this->CALLAPI($api,$data,$method);
            $d['well_type'] = $result['data'];
            //echo "<pre>";
             //print_r($d['well_list']);die;


            $d['v'] = "add/add_well_view";
            $this->load->view('templates',$d);
        }

        public function get_site_list()
        {
            $api ='Master/areaWiseSite_list';
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'))
            .'&assets_id='.htmlspecialchars($this->input->post('assets_id',true))
            .'&area_id='.htmlspecialchars($this->input->post('area_id',true));
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }

        public function get_area_list()
        {
            $api ='Master/Arealist';
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'))
                .'&assets_id='.htmlspecialchars($this->input->post('assets_id',true));
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }
        
         
        public function add_well()
        {
            
            $user_id = htmlspecialchars($this->session->userdata('id'));

            $module_name = 'Well Add';
            $api = 'Master/AccessLog';
            $data = 'id='.$user_id.'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $api = 'Well_master/AddWell';
            $data = 'well_name='.htmlspecialchars($this->input->post('well_name',true)).
            '&assets_id='.htmlspecialchars($this->input->post('assets_id',true)).
            '&well_type='.htmlspecialchars($this->input->post('well_type',true)).
            '&area_id='.htmlspecialchars($this->input->post('area_id',true)).
            '&site_id='.htmlspecialchars($this->input->post('site_id',true)).
            '&latitude='.htmlspecialchars($this->input->post('latitude',true)).
            '&longitude='.htmlspecialchars($this->input->post('longitude',true)).
            '&company_id='.htmlspecialchars($this->session->userdata('company_id')).
            '&c_by='.$user_id;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            if($result['response_code'] == 200)
            {
                $this->session->set_flashdata('success', $result['msg']);
                redirect('Well_c');
            }
            else
            {
                $this->session->set_flashdata('error', $result['msg']);
                redirect('Well_c');
            }

        }

        public function edit_well()
        {

            $id = htmlspecialchars($this->uri->segment(3));
            $api = 'Well_master/Well_List';
            $data = 'id='.$id;
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['well_list'] = $result['data'];
            // echo "<pre>";
            // print_r($result);die;
            $api ='Master/Assets_list';
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'));
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['assets_list'] = $result['data'];

            $api = 'Well_type_master/Welllist';
    $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'));
    $method = 'POST';
    $result = $this->CallAPI($api, $data, $method);
    $d['well_type'] = $result['data'];

            $d['v'] = 'edit/edit_well_view';
            $this->load->view('templates',$d);  
        }


        public function update_well()
        {
            $userid = htmlspecialchars($this->session->userdata('id'));

            $module_name = 'Edit Well Data';
            $api = 'Master/AccessLog';
            $data = 'id='.$userid.'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $api = 'Well_master/UpdateWell';
            $data = 'id='.htmlspecialchars($this->input->post('id',true)).
            '&site_id='.htmlspecialchars($this->input->post('site_id',true)).
            '&well_type='.htmlspecialchars($this->input->post('well_type',true)).
            '&assets_id='.htmlspecialchars($this->input->post('assets_id',true)).
            '&area_id='.htmlspecialchars($this->input->post('area_id',true)).
            '&latitude='.htmlspecialchars($this->input->post('latitude',true)).
            '&longitude='.htmlspecialchars($this->input->post('longitude',true)).
            '&well_name='.htmlspecialchars($this->input->post('well_name',true)).
            '&d_by='.$userid;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            if($result['response_code'] == 200)
            {
                $this->session->set_flashdata('success', $result['msg']);
                redirect('Well_c');
            }
            else
            {
                $this->session->set_flashdata('error', $result['msg']);
                redirect('Well_c');
            }
        }

        public function delete_well()
        {
            $userid = htmlspecialchars($this->session->userdata('id'));

            $module_name = 'Delete Well Data';
            $api = 'Master/AccessLog';
            $data = 'id='.$userid.'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $api = 'Well_master/deleteWell';
            $method = 'POST';
            $data = 'id='.htmlspecialchars($this->input->post('id',true)).'&d_by='.$userid;
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }
    }
?>

