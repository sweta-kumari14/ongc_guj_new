<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    date_default_timezone_set('Asia/Kolkata');
    class Site_allotment_to_user_c extends MY_Controller
    {
        public function __construct()
        {
            parent:: __construct();
            
        }

        public function index()
        {
            $module_name = 'Site allotment Module';
            $api = 'Master/AccessLog';
            $data = 'id='.htmlspecialchars($this->session->userdata('id')).'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $api ='Master/Assets_list';
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'));
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['assets_list'] = $result['data'];
            // echo "<pre>";
            // print_r($result);die;

            $d['v'] = "site_allotment_to_user_view";
            $this->load->view('templates',$d); 
        }

        public function get_user_data()
        {
            $api = 'Master/RoleWise_User_list';
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'))
            .'&role_type='.htmlspecialchars($this->input->post('role_type'));
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result,true); 
        }

        public function get_site_list()
        {
            $api = 'Master/Arealist';
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'))
            .'&assets_id='.htmlspecialchars($this->input->post('assets_id'));
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result,true); 
        }

        public function get_assets_list()
        {
            $company_id = htmlspecialchars($this->session->userdata('company_id'));
            $user_id = $this->input->post('user_id')!=''?$this->input->post('user_id'):'';
            $api = 'Role_UserAllotment/get_asset_for_allotment';
            $data = 'company_id='.$company_id.'&user_id='.htmlspecialchars($user_id);
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            // echo "<pre>";
            // print_r($result);die;
            echo json_encode($result,true); 
        }

        public function get_area_list()
        {
            $company_id = $this->session->userdata('company_id');
            $user_id = $this->input->post('user_id')!=''?$this->input->post('user_id'):'';
            $assets_id = $this->input->post('assets_id')!=''?$this->input->post('assets_id'):'';
            $api = 'Role_UserAllotment/get_area_for_allotment';
            $data = 'company_id='.htmlspecialchars($company_id).'&user_id='.htmlspecialchars($user_id).'&assets_id='.htmlspecialchars($assets_id);
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            // echo "<pre>";
            // print_r($result);die;
            echo json_encode($result,true); 
        }

        // ===================== code for Site =======================

        public function get_Site_list_for_listing()
        {
            $company_id = $this->session->userdata('company_id');
            $user_id = $this->input->post('user_id')!=''?$this->input->post('user_id'):'';
            $assets_id = $this->input->post('assets_id')!=''?$this->input->post('assets_id'):'';
            $area_id = $this->input->post('area_id')!=''?$this->input->post('area_id'):'';
            $api = 'Role_UserAllotment/get_site_for_allotment';
            $data = 'company_id='.htmlspecialchars($company_id).'&user_id='.htmlspecialchars($user_id).'&assets_id='.htmlspecialchars($assets_id).'&area_id='.htmlspecialchars($area_id);
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            // echo "<pre>";
            // print_r($result);die;
            echo json_encode($result,true); 
        }


        // ================== code for allotment ======================
        public function allot_site()
        {
            $assign_assets = $this->input->post('assign_assets')!=''?json_encode($this->input->post('assign_assets'),true):json_encode([],true);
            $assign_area = $this->input->post('assign_area')!=''?json_encode($this->input->post('assign_area'),true):json_encode([],true);
            $assign_site = $this->input->post('assign_site')!=''?json_encode($this->input->post('assign_site'),true):json_encode([],true);

            $module_name = 'Site allotment to users';
            $api = 'Master/AccessLog';
            $data = 'id='.htmlspecialchars($this->session->userdata('id')).'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $api = 'Role_UserAllotment/User_Allotment';
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id')).
            '&role_type='.htmlspecialchars($this->input->post('role_type',true)).
            '&user_id='.htmlspecialchars($this->input->post('user_id',true)).
            '&assets_id='.htmlspecialchars($this->input->post('assets_id',true)).
            '&area_id='.htmlspecialchars($this->input->post('area_id',true)).
            '&site_id='.htmlspecialchars($this->input->post('site_id',true)).
            '&assign_assets='.$assign_assets.
            '&assign_area='.$assign_area.
            '&assign_site='.$assign_site.
            '&c_by='.htmlspecialchars($this->session->userdata('id'));
            
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            // echo "<pre>";
            // print_r($data);
            // echo "<br>";
            // print_r($result);die;
            if($result['response_code'] == 200)
            {
                $this->session->set_flashdata('success', $result['msg']);
                redirect('Site_allotment_to_user_c');
            }
            else
            {
                $this->session->set_flashdata('error', $result['msg']);
                redirect('Site_allotment_to_user_c');
            }
        }
    }
?>

