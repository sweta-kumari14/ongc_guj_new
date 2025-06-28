<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    date_default_timezone_set('Asia/Kolkata');
    class Technical_compalint_c extends MY_Controller
    {
        public function __construct()
        {
            parent:: __construct();
            
        }

        public function index()
        {

            $api = 'User_complaint_data/get_complaint_list';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
                     .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id'),ENT_QUOTES, 'UTF-8')
                     .'&ticket_id='.htmlspecialchars((string)$this->input->post('ticket_id',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            $d['ticket_list'] = $result['data'];
            // echo '<pre>';
            // print_r($d['ticket_list']);die;

            $api = 'Master/get_well_list_for_Complain_raised';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
                     .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id'),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            $d['well_list'] = $result['data'];
            
            // echo '<pre>';
            // print_r($d['well_list']);die;

            $api ='Area_Dashboard/AreaList_forDashboard';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
            .'&assets_id='.htmlspecialchars((string)$this->input->post('assets_id',true),ENT_QUOTES, 'UTF-8')
            .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id'),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['area_list'] = $result['data'];
           

            $d['v'] = "complaint_dashboard_view";
            $this->load->view('templates',$d); 
        }

        public function get_count_complain()
        {
            $api = 'User_complaint_data/get_total_count';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
                     .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id'),ENT_QUOTES, 'UTF-8')
                     .'&from_date='.htmlspecialchars((string)$this->input->post('from_date'),ENT_QUOTES, 'UTF-8')
                     .'&to_date='.htmlspecialchars((string)$this->input->post('to_date'),ENT_QUOTES, 'UTF-8')
                     .'&ticket_id='.htmlspecialchars((string)$this->input->post('ticket_id'),ENT_QUOTES, 'UTF-8')
                     .'&complaint_status='.htmlspecialchars((string)$this->input->post('complaint_status'),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }

        public function Add_complain_details()
        {
            $api = 'User_complaint_data/Add_complaint_data';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id',true),ENT_QUOTES, 'UTF-8')
                    .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id',true),ENT_QUOTES, 'UTF-8')
                    .'&well_id='.htmlspecialchars((string)$this->input->post('hdn_well_id',true),ENT_QUOTES, 'UTF-8')
                    .'&complaint_description='.htmlspecialchars((string)$this->input->post('complaint_description',true),ENT_QUOTES, 'UTF-8')
                    .'&complaint_type='.htmlspecialchars((string)$this->input->post('complaint_type',true),ENT_QUOTES, 'UTF-8')
                    .'&c_by='.htmlspecialchars((string)$this->session->userdata('user_id',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);


            if($result['response_code'] == 200)
            {
                $this->session->set_flashdata('success', $result['msg']);
                redirect('Technical_compalint_c');
            }
            else
            {
                $this->session->set_flashdata('error', $result['msg']);
                redirect('Technical_compalint_c');
            }

        }

       

        public function complaint_details_admin_page()
        {

            $api = 'User_complaint_data/get_total_count';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
                     .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id'),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            $d['ticket_data'] = $result['data'];
            


            $api = 'User_complaint_data/get_complaint_list';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
                     .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id'),ENT_QUOTES, 'UTF-8')
                     .'&ticket_id='.htmlspecialchars((string)$this->input->post('ticket_id',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            $d['ticket_list'] = $result['data'];



             $id = htmlspecialchars((string)$this->input->post('id',true),ENT_QUOTES, 'UTF-8');
            $api = 'User_complaint_data/get_complaint_list';
            $data = 'id='.$id;
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['list_complaints'] = $result['data'];

            $api ='Area_Dashboard/SiteList_forDashboard';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
            .'&assets_id='.htmlspecialchars((string)$this->input->post('assets_id',true),ENT_QUOTES, 'UTF-8')
            .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id'),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['site_list'] = $result['data'];

            

            $d['v'] = "complaint_dashboard_admin_view";
            $this->load->view('templates',$d); 
        }

        public  function get_complaint_data()
        {
            $api ='User_complaint_data/get_report_complaint_details';
            $data = 'id='.htmlspecialchars((string)$this->input->post('id',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CallAPI($api,$data,$method);
            echo json_encode($result);
        }

        public  function complaints_report_details()
        {
            $api ='User_complaint_data/get_report_complaint_ticket_details';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id',true),ENT_QUOTES, 'UTF-8')
                    .'&area_id='.htmlspecialchars((string)$this->input->post('area_id',true),ENT_QUOTES, 'UTF-8')
                    .'&from_date='.htmlspecialchars((string)$this->input->post('from_date',true),ENT_QUOTES, 'UTF-8')
                    .'&to_date='.htmlspecialchars((string)$this->input->post('to_date',true),ENT_QUOTES, 'UTF-8')
                    .'&ticket_id='.htmlspecialchars((string)$this->input->post('ticket_id',true),ENT_QUOTES, 'UTF-8')
                    .'&sort_by='.htmlspecialchars((string)$this->input->post('sort_by',true),ENT_QUOTES, 'UTF-8')
                    .'&complaint_status='.htmlspecialchars((string)$this->input->post('complaint_status',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CallAPI($api,$data,$method);
            echo json_encode($result);
        }

        public function edit_complaints()
        {
            $id = htmlspecialchars((string)$this->input->post('id',true),ENT_QUOTES, 'UTF-8');
            $api = 'User_complaint_data/get_complaint_list';
            $data = 'id='.$id;
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['list_complaints'] = $result['data'];
            // echo '<pre>';
            // print_r($d['list_complaints']);die;
            
            $this->load->view('edit/edit_complaints_view',$d); 
        
        }

        public function update_complaints()
        {  
            $userId = htmlspecialchars((string)$this->session->userdata('user_id'),ENT_QUOTES, 'UTF-8');
            
            $api = 'User_complaint_data/Update_complaint_data';
            $data = 'id='.htmlspecialchars((string)$this->input->post('id',true),ENT_QUOTES, 'UTF-8')
                    .'&company_id='.htmlspecialchars((string)$this->session->userdata('company_id',true),ENT_QUOTES, 'UTF-8')
                    .'&user_id='.htmlspecialchars((string)$this->input->post('user_id',true),ENT_QUOTES, 'UTF-8')
                    .'&well_id='.htmlspecialchars((string)$this->input->post('well_id',true),ENT_QUOTES, 'UTF-8')
                    .'&ticket_id='.htmlspecialchars((string)$this->input->post('ticket_id',true),ENT_QUOTES, 'UTF-8')
                    .'&device_name='.htmlspecialchars((string)$this->input->post('device_name',true),ENT_QUOTES, 'UTF-8')
                    .'&imei_no='.htmlspecialchars((string)$this->input->post('imei_no',true),ENT_QUOTES, 'UTF-8')
                    .'&date_of_installation='.htmlspecialchars((string)$this->input->post('date_of_installation',true),ENT_QUOTES, 'UTF-8')
                    .'&resolution_description='.htmlspecialchars((string)$this->input->post('resolution_description',true),ENT_QUOTES, 'UTF-8')
                    .'&complaint_status='.htmlspecialchars((string)$this->input->post('complaint_status',true),ENT_QUOTES, 'UTF-8')
                    .'&complaint_description='.htmlspecialchars((string)$this->input->post('complaint_description',true),ENT_QUOTES, 'UTF-8')
                    .'&complaint_type='.htmlspecialchars((string)$this->input->post('complaint_type',true),ENT_QUOTES, 'UTF-8')
                    .'&d_by='.$userId;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            // echo'<pre>';
            // print_r($data);
            // print_r($result);die;

            if($result['response_code'] == 200)
            {
                $this->session->set_flashdata('success', $result['msg']);
                redirect('Technical_compalint_c/complaint_details_admin_page');
            }
            else
            {
                $this->session->set_flashdata('error', $result['msg']);
                redirect('Technical_compalint_c/complaint_details_admin_page');
            }
        }
         

         public function get_report_log_complaints()
         {
            
            $api = 'User_complaint_data/get_complaint_list';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
                .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id'),ENT_QUOTES, 'UTF-8')
                .'&ticket_id='.htmlspecialchars((string)$this->input->post('ticket_id',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            $d['ticket_list'] = $result['data'];

            $api = 'Master/get_well_list_for_Complain_raised';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
                     .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id'),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            $d['well_list'] = $result['data'];

            
            $api ='Area_Dashboard/SiteList_forDashboard';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
            .'&assets_id='.htmlspecialchars((string)$this->input->post('assets_id',true),ENT_QUOTES, 'UTF-8')
            .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id'),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['site_list'] = $result['data'];
            


            $d['v'] = "report/technical_complaint_report_view";
            $this->load->view('templates',$d); 
        }

        public  function complaints_report_log()
        {
            $api ='User_complaint_data/get_report_complaint_log';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id',true),ENT_QUOTES, 'UTF-8')
                    .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id',true),ENT_QUOTES, 'UTF-8')
                    .'&from_date='.htmlspecialchars((string)$this->input->post('from_date',true),ENT_QUOTES, 'UTF-8')
                    .'&to_date='.htmlspecialchars((string)$this->input->post('to_date',true),ENT_QUOTES, 'UTF-8')
                    .'&ticket_id='.htmlspecialchars((string)$this->input->post('ticket_id',true),ENT_QUOTES, 'UTF-8')
                    .'&well_id='.htmlspecialchars((string)$this->input->post('well_id',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CallAPI($api,$data,$method);
            echo json_encode($result);
        }

        public  function complaints_report_log_details()
        {
            $api ='User_complaint_data/get_report_complaint_details_log';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id',true),ENT_QUOTES, 'UTF-8')
                    .'&site_id='.htmlspecialchars((string)$this->input->post('site_id',true),ENT_QUOTES, 'UTF-8')
                    .'&from_date='.htmlspecialchars((string)$this->input->post('from_date',true),ENT_QUOTES, 'UTF-8')
                    .'&to_date='.htmlspecialchars((string)$this->input->post('to_date',true),ENT_QUOTES, 'UTF-8')
                    .'&ticket_id='.htmlspecialchars((string)$this->input->post('ticket_id',true),ENT_QUOTES, 'UTF-8')
                    .'&sort_by='.htmlspecialchars((string)$this->input->post('sort_by',true),ENT_QUOTES, 'UTF-8')
                    .'&well_id='.htmlspecialchars((string)$this->input->post('well_id',true),ENT_QUOTES, 'UTF-8');
                    
            $method = 'POST';
            $result = $this->CallAPI($api,$data,$method);
            echo json_encode($result);
        }

        public function getWell_list()
        {
             $api = 'Area_Dashboard/WellList_forDashboard';
             $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
                     .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id'),ENT_QUOTES, 'UTF-8')
                     .'&site_id='.htmlspecialchars((string)$this->input->post('site_id'),ENT_QUOTES, 'UTF-8');
                    
             $method = 'POST';
             $result = $this->CallAPI($api,$data,$method);
           

             echo json_encode($result);
        }

       
    }
?>