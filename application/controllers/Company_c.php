<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    date_default_timezone_set('Asia/Kolkata');
    class Company_c extends MY_Controller
    {
        public function __construct()
        {
            parent:: __construct();
            
        }

        public function index()
        {
            $module_name = 'Company Listing page';
            $api = 'Master/AccessLog';
            $data = 'id='.htmlspecialchars((string)$this->session->userdata('id'),ENT_QUOTES, 'UTF-8').'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $api ='Company_master/CompanyDataList';
            $data = '';
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['company_list'] = $result['data'];
            // echo "<pre>";
            // print_r($result);die;

            $d['v'] = "company_view";
            $this->load->view('templates',$d); 
        }

        public function add_company_page()
        {
            $api ='Master/CountryList';
            $data = '';
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['country_list'] = $result['data'];

            $d['v'] = "add/add_company_master_view";
            $this->load->view('templates',$d);
        }

        public function get_state_list()
        {
            $api ='Master/StateList';
            $data = 'country_code='.htmlspecialchars((string)$this->input->post('country_code',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }
        
         
        // public function add_company()
        // {
        //     $logo='';
        //     if(isset($_FILES["logo"]) && $_FILES["logo"]["size"] !=0)
        //     {
        //         $logo = base64_encode(file_get_contents($_FILES["logo"]["tmp_name"]),ENT_QUOTES, 'UTF-8');
        //     }
        //     $user_id = $this->session->userdata('id');

        //     $module_name = 'Save Company Data';
        //     $api = 'Master/AccessLog';
        //     $data = 'id='.$user_id.'&module_name='.$module_name;
        //     $method = 'POST';
        //     $result = $this->CallAPI($api, $data, $method);

        //     $api = 'Company_master/Add_CompanyData';
        //     $data = 'company_name='.$this->input->post('company_name',true).
        //     '&email_id='.$this->input->post('email_id',true).
        //     '&contact_no='.$this->input->post('mobile_no',true).
        //     '&comp_userId='.$this->input->post('company_id',true).
        //     '&country_code='.$this->input->post('country',true).
        //     '&state_code='.$this->input->post('state',true).
        //     '&city='.$this->input->post('city',true).
        //     '&address='.$this->input->post('address',true).
        //     '&logo='.$logo.
        //     '&super_admin_id='.$this->session->userdata('admin_id').
        //     '&c_by='.$user_id;
        //     $method = 'POST';
        //     $result = $this->CallAPI($api, $data, $method);
        //     // echo "<pre>";
        //     // print_r($result);die;

        //     if($result['response_code'] == 200)
        //     {
        //         $this->session->set_flashdata('success', $result['msg']);
        //         redirect('Company_c');
        //     }
        //     else
        //     {
        //         $this->session->set_flashdata('error', $result['msg']);
        //         redirect('Company_c');
        //     }

        // }

        public function add_company()
        {
            $logo = '';
            if(isset($_FILES["logo"]) && $_FILES["logo"]["size"] != 0) {
                // Process logo upload securely
                $logo = base64_encode(file_get_contents($_FILES["logo"]["tmp_name"]),ENT_QUOTES, 'UTF-8');
            }
            // Sanitize user inputs
            $company_name = htmlspecialchars((string)$this->input->post('company_name', true),ENT_QUOTES, 'UTF-8');
            $email_id = htmlspecialchars((string)$this->input->post('email_id', true),ENT_QUOTES, 'UTF-8');
            $mobile_no = htmlspecialchars((string)$this->input->post('mobile_no', true),ENT_QUOTES, 'UTF-8');
            $company_id = htmlspecialchars((string)$this->input->post('company_id', true),ENT_QUOTES, 'UTF-8');
            $country_code = htmlspecialchars((string)$this->input->post('country', true),ENT_QUOTES, 'UTF-8');
            $state_code = htmlspecialchars((string)$this->input->post('state', true),ENT_QUOTES, 'UTF-8');
            $city = htmlspecialchars((string)$this->input->post('city', true),ENT_QUOTES, 'UTF-8');
            $address = htmlspecialchars((string)$this->input->post('address', true),ENT_QUOTES, 'UTF-8');

            // Other validations and logic as needed
            
            $user_id = htmlspecialchars((string)$this->session->userdata('id'),ENT_QUOTES, 'UTF-8');
            $super_admin_id = htmlspecialchars((string)$this->session->userdata('admin_id'),ENT_QUOTES, 'UTF-8');

            // Logging access
            $module_name = 'Save Company Data';
            $api_access_log = 'Master/AccessLog';
            $access_data = 'id='.$user_id.'&module_name='.$module_name;
            $access_result = $this->CallAPI($api_access_log, $access_data, 'POST');

            // Adding company data
            $api = 'Company_master/Add_CompanyData';
            $data = 'company_name='.$company_name.
                            '&email_id='.$email_id.
                            '&contact_no='.$mobile_no.
                            '&comp_userId='.$company_id.
                            '&country_code='.$country_code.
                            '&state_code='.$state_code.
                            '&city='.$city.
                            '&address='.$address.
                            '&logo='.$logo.
                            '&super_admin_id='.$super_admin_id.
                            '&c_by='.$user_id;
            $method = 'POST';
            // echo "<pre>";
            // print_r($company_data);die;
            $result = $this->CallAPI($api, $data,$method);

            if($result['response_code'] == 200) {
                $this->session->set_flashdata('success', $result['msg']);
                redirect('Company_c');
            } else {
                $this->session->set_flashdata('error', $result['msg']);
                redirect('Company_c');
            }
        }

        public function edit_company()
        {

            $id = $this->uri->segment(3);
            $api = 'Company_master/CompanyDataList';
            $data = 'id='.$id;
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['company_list'] = $result['data'];

            // echo "<pre>";
            // print_r($result);die;
            $api ='Master/CountryList';
            $data = '';
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['country_list'] = $result['data'];

            $d['v'] = 'edit/edit_company_view';
            $this->load->view('templates',$d);  
        }


        public function update_company()
        {
            $logo='';
            if(isset($_FILES["logo"]) && $_FILES["logo"]["size"] !=0)
            {
                $logo = base64_encode(file_get_contents($_FILES["logo"]["tmp_name"]),ENT_QUOTES, 'UTF-8');
            }

            $userid = htmlspecialchars((string)$this->session->userdata('id'),ENT_QUOTES, 'UTF-8');

            $module_name = 'Edit Company Data';
            $api = 'Master/AccessLog';
            $data = 'id='.$userid.'&module_name='.htmlspecialchars((string)$module_name);
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $api = 'Company_master/UpdateCompanyData';
            $data = 'id='.htmlspecialchars((string)$this->input->post('id',true),ENT_QUOTES, 'UTF-8').
            '&company_name='.htmlspecialchars((string)$this->input->post('company_name',true),ENT_QUOTES, 'UTF-8').
            '&email_id='.htmlspecialchars((string)$this->input->post('email_id',true),ENT_QUOTES, 'UTF-8').
            '&contact_no='.htmlspecialchars((string)$this->input->post('mobile_no',true),ENT_QUOTES, 'UTF-8').
            '&country_code='.htmlspecialchars((string)$this->input->post('country',true),ENT_QUOTES, 'UTF-8').
            '&state_code='.htmlspecialchars((string)$this->input->post('state',true),ENT_QUOTES, 'UTF-8').
            '&city='.htmlspecialchars((string)$this->input->post('city',true),ENT_QUOTES, 'UTF-8').
            '&logo='.$logo.
            '&address='.htmlspecialchars((string)$this->input->post('address',true),ENT_QUOTES, 'UTF-8').
            '&d_by='.$userid;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            if($result['response_code'] == 200)
            {
                $this->session->set_flashdata('success', $result['msg']);
                redirect('Company_c');
            }
            else
            {
                $this->session->set_flashdata('error', $result['msg']);
                redirect('Company_c');
            }
        }

        public function delete_company()
        {
            $userid = $this->session->userdata('id');

            $module_name = 'Delete Company Data';
            $api = 'Master/AccessLog';
            $data = 'id='.$userid.'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $api = 'Company_master/deleteCompany';
            $method = 'POST';
            $data = 'id='.htmlspecialchars((string)$this->input->post('id',true),ENT_QUOTES, 'UTF-8').'&d_by='.$userid;
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }

      

    }
?>