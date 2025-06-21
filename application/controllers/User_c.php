<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    date_default_timezone_set('Asia/Kolkata');
    class User_c extends MY_Controller
    {
        public function __construct()
        {
            parent:: __construct();
            
        }

        public function index()
        {
            $module_name = 'User List';
            $api = 'Master/AccessLog';
            $data = 'id='.htmlspecialchars($this->session->userdata('id')).'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $api ='ONGC_Member_master/MemberList';
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'));
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['user_list'] = $result['data'];
            // echo "<pre>";
            // print_r($result);die;

            $d['v'] = "user_view";
            $this->load->view('templates',$d); 
        }

        public function add_user_page()
        {
            $api ='Master/CountryList';
            $data = '';
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['country_list'] = $result['data'];

            $d['v'] = "add/add_user_master_view";
            $this->load->view('templates',$d);
        }

        public function get_state_list()
        {
            $api ='Master/StateList';
            $data = 'country_code='.htmlspecialchars($this->input->post('country_code',true));
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }
        
         
        public function add_user()
        {
            
            $user_id = htmlspecialchars($this->session->userdata('id'));

            $module_name = 'Add Users Details';
            $api = 'Master/AccessLog';
            $data = 'id='.$user_id.'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $api = 'ONGC_Member_master/Save_UserData';
            $data = 'user_full_name='.htmlspecialchars($this->input->post('user_name',true)).
            '&email_id='.htmlspecialchars($this->input->post('email_id',true)).
            '&contact_no='.htmlspecialchars($this->input->post('mobile_no',true)).
            '&country_code='.htmlspecialchars($this->input->post('country',true)).
            '&state_code='.htmlspecialchars($this->input->post('state',true)).
            '&city='.htmlspecialchars($this->input->post('city',true)).
            '&address='.htmlspecialchars($this->input->post('address',true)).
            '&emp_id='.htmlspecialchars($this->input->post('emp_id',true)).
            '&userId='.htmlspecialchars($this->input->post('emp_user_id',true)).
            '&role_type='.htmlspecialchars($this->input->post('user_level',true)).
            '&password='.htmlspecialchars($this->input->post('password',true)).
            '&company_id='.htmlspecialchars($this->session->userdata('company_id')).
            '&web_functionality='.htmlspecialchars($this->input->post('web_access',true)).
            '&mobile_functionality='.htmlspecialchars($this->input->post('mobile_access',true)).
            '&c_by='.$user_id;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            if($result['response_code'] == 200)
            {
                $this->session->set_flashdata('success', $result['msg']);
                redirect('User_c');
            }
            else
            {
                $this->session->set_flashdata('error', $result['msg']);
                redirect('User_c');
            }

        }

        public function edit_user()
        {

            $id = htmlspecialchars($this->uri->segment(3));
            $api = 'ONGC_Member_master/MemberList';
            $data = 'id='.$id;
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['user_list'] = $result['data'];

            // echo "<pre>";
            // print_r($result);die;
            $api ='Master/CountryList';
            $data = '';
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['country_list'] = $result['data'];

            $d['v'] = 'edit/edit_user_view';
            $this->load->view('templates',$d);  
        }


        public function update_user()
        {
            $userid = htmlspecialchars($this->session->userdata('id'));

            $module_name = 'Edit Users Details';
            $api = 'Master/AccessLog';
            $data = 'id='.$userid.'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $api = 'ONGC_Member_master/UpdateUserData';
            $data = 'id='.htmlspecialchars($this->input->post('id',true)).
            '&user_full_name='.htmlspecialchars($this->input->post('user_name',true)).
            '&email_id='.htmlspecialchars($this->input->post('email_id',true)).
            '&contact_no='.htmlspecialchars($this->input->post('mobile_no',true)).
            '&country_code='.htmlspecialchars($this->input->post('country',true)).
            '&state_code='.htmlspecialchars($this->input->post('state',true)).
            '&city='.htmlspecialchars($this->input->post('city',true)).
            '&address='.htmlspecialchars($this->input->post('address',true)).
            '&emp_id='.htmlspecialchars($this->input->post('emp_id',true)).
            '&role_type='.htmlspecialchars($this->input->post('user_level',true)).
            '&designation_id='.htmlspecialchars($this->input->post('designation_id',true)).
            '&company_id='.htmlspecialchars($this->session->userdata('company_id')).
            '&web_functionality='.htmlspecialchars($this->input->post('web_access',true)).
            '&mobile_functionality='.htmlspecialchars($this->input->post('mobile_access',true)).
            '&d_by='.$userid;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            if($result['response_code'] == 200)
            {
                $this->session->set_flashdata('success', $result['msg']);
                redirect('User_c');
            }
            else
            {
                $this->session->set_flashdata('error', $result['msg']);
                redirect('User_c');
            }
        }

        public function delete_user()
        {
            $userid = htmlspecialchars($this->session->userdata('id'));

            $module_name = 'Delete Users';
            $api = 'Master/AccessLog';
            $data = 'id='.$userid.'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $api = 'ONGC_Member_master/delete_User_Data';
            $method = 'POST';
            $data = 'id='.$this->input->post('id',true).'&d_by='.$userid;
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }

        public function Active_Inactive()
        {
            $userid = htmlspecialchars($this->session->userdata('id'));
            
            $module_name = 'Active Inactive Users';
            $api = 'Master/AccessLog';
            $data = 'id='.$userid.'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $id = htmlspecialchars($this->input->post('id',true));
            $active_inactive = htmlspecialchars($this->input->post('active_status',true));
            $api = 'ONGC_Member_master/Active_inactive';
            $data = 'id='.$id.'&active_status='.$active_inactive.'&d_by='.htmlspecialchars($this->session->userdata('id',true));
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result,true);
        }

      

    }
?>

        