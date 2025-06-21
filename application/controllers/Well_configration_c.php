<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    date_default_timezone_set('Asia/Kolkata');
    class Well_configration_c extends MY_Controller
    {
        public function __construct()
        {
            parent:: __construct();
            
        }

        public function index()
        {
            $module_name = 'Well configuration List';
            $api = 'Master/AccessLog';
            $data = 'id='.htmlspecialchars((string)$this->session->userdata('id'),ENT_QUOTES, 'UTF-8').'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $d['v'] = "well_configration_setup_view";
            $this->load->view('templates',$d); 
        }


        public function Well_sheduling_data()
        {
            $api ='Well_configuration/get_Well_Configration_list';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
                     .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id'),ENT_QUOTES, 'UTF-8')
                     .'&search='.htmlspecialchars((string)$this->input->post('search'),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }

        public function Add_well_Configration_page()
        {
            $api ='Master/Well_list';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
                     .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id'),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['well_list'] = $result['data'];

            $d['v'] = "add/add_well_configration_view";
            $this->load->view('templates',$d); 
        }

        public function well_details_data()
        {
            $api ='Well_configuration/get_well_details_configration';
            $data = 'well_id='.htmlspecialchars((string)$this->input->post('well_id'),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
            
        }

        public function allot_well_configration()
        {

            $module_name = 'Add well Configration';
            $api = 'Master/AccessLog';
            $data = 'id='.htmlspecialchars((string)$this->session->userdata('id'),ENT_QUOTES, 'UTF-8').'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $well_type = htmlspecialchars((string)$this->input->post('well_type',true),ENT_QUOTES, 'UTF-8');
           

            if($well_type == 1)
            {
                $well = array();
                $start_time = $this->input->post('start_time',true);
                $stop_time = $this->input->post('stop_time',true);
                for ($i=0; $i < count($start_time); $i++)
                { 
                    $dev = array();
                    $dev['start_time'] = $start_time[$i];
                    $dev['stop_time'] = $stop_time[$i];
               
                        array_push($well,$dev);
                }
            }
            
            

            $api = 'Well_configuration/Add_Well_configuration';
            

            if($well_type == 0)
            {
                 $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8').
                         '&well_id='.htmlspecialchars((string)$this->input->post('well_id_hdn',true),ENT_QUOTES, 'UTF-8').
                         '&well_type='.$well_type.
                         '&assign_date='.htmlspecialchars((string)$this->input->post('assign_date',true),ENT_QUOTES, 'UTF-8').
                         '&c_by='.htmlspecialchars((string)$this->session->userdata('id'),ENT_QUOTES, 'UTF-8');
            }else{

                $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8').
                         '&periodic_time='.(json_encode($well)).
                         '&well_id='.htmlspecialchars((string)$this->input->post('well_id_hdn',true),ENT_QUOTES, 'UTF-8').
                         '&well_type='.$well_type.
                         '&assign_date='.htmlspecialchars((string)$this->input->post('assign_date',true),ENT_QUOTES, 'UTF-8').
                         '&c_by='.htmlspecialchars((string)$this->session->userdata('id'),ENT_QUOTES, 'UTF-8');

            }
           
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            
            if($result['response_code'] == 200)
            {
                $this->session->set_flashdata('success', $result['msg']);
                redirect('Well_configration_c');
            }
            else
            {
                $this->session->set_flashdata('error', $result['msg']);
                redirect('Well_configration_c');
            }
        }


         public function edit_configration()
        {
            $api ='Master/Well_list';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
                     .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id'),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['well_list'] = $result['data'];


            $well_id = htmlspecialchars((string)$this->uri->segment(3),ENT_QUOTES, 'UTF-8');
            $api = 'Well_configuration/get_well_details_configration';
            $data = 'well_id='.$well_id;
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['well_configration'] = $result['data'];
           
            // echo '<pre>';
            // print_r($d['well_configration']);die;

            

            $d['v'] = 'edit/edit_well_configration_view';
            $this->load->view('templates',$d);
        }

         public function edit_configration_data()
        {
            $id = htmlspecialchars((string)$this->input->post('id',true),ENT_QUOTES, 'UTF-8'); 
            $api = 'Well_configuration/get_well_list_configration';
            $data = 'id='.$id;
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['well_configration_list'] = $result['data'];

             // echo "<pre>";
             // print_r($result);die;
           
            $this->load->view('edit/edit_single_well_id_details_update_view',$d); 
        
        }

        public function update_configration()
        {
            $userId = htmlspecialchars((string)$this->session->userdata('id'),ENT_QUOTES, 'UTF-8');

            $api = 'Well_configuration/Update_Well_single_Configuration';
            $data = 'id='.htmlspecialchars((string)$this->input->post('id',true),ENT_QUOTES, 'UTF-8')
                    .'&well_id='.htmlspecialchars((string)$this->input->post('well_id',true),ENT_QUOTES, 'UTF-8')
                    .'&company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
                    .'&well_type='.htmlspecialchars((string)$this->input->post('well_type_hdn',true),ENT_QUOTES, 'UTF-8')
                    .'&assign_date='.htmlspecialchars((string)$this->input->post('assign_date',true),ENT_QUOTES, 'UTF-8')
                    .'&start_time='.htmlspecialchars((string)$this->input->post('start_time',true),ENT_QUOTES, 'UTF-8')
                    .'&stop_time='.htmlspecialchars((string)$this->input->post('stop_time',true),ENT_QUOTES, 'UTF-8')
                    .'&d_by='.$userId;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            
            if($result['response_code'] == 200)
            {
                $this->session->set_flashdata('success', $result['msg']);
                redirect('Well_configration_c');
            }
            else
            {
                $this->session->set_flashdata('error', $result['msg']);
                redirect('Well_configration_c');
            }
        }

        public function DeleteWell_Configration()
        {

            $userId = htmlspecialchars((string)$this->session->userdata('id'),ENT_QUOTES, 'UTF-8');

            $module_name = 'Remove Well Configration Details';
            $api = 'Master/AccessLog';
            $data = 'id='.$userId.'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $api ='Well_configuration/Delete_Well_Configration';
            $data = 'well_id='.htmlspecialchars((string)$this->input->post('well_id',true),ENT_QUOTES, 'UTF-8').'&d_by='.$userId;
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }

        public function Delete_WellConfigration()
        {
             $userId = $this->session->userdata('id');
            $api ='Well_configuration/Delete_Well_Details_through_id';
            $data = 'id='.htmlspecialchars((string)$this->input->post('id',true),ENT_QUOTES, 'UTF-8').'&d_by='.$userId;
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }

        public function Well_configration_details_report()
        {
            $api ='Master/Well_list';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
                     .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id'),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['well_list'] = $result['data'];
            // echo '<pre>';
            // print_r($d['well_list']);die;
            

            $d['v'] = "report/well_configration_report_view";
            $this->load->view('templates',$d); 
        }

        public function well_configration_report()
        {
            $api =  'Well_configuration/Well_configuration_log_report';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
                     .'&from_date='.htmlspecialchars((string)$this->input->post('from_date',true),ENT_QUOTES, 'UTF-8')
                     .'&to_date='.htmlspecialchars((string)$this->input->post('to_date',true),ENT_QUOTES, 'UTF-8')
                     .'&well_id='.htmlspecialchars((string)$this->input->post('well_id',true),ENT_QUOTES, 'UTF-8')
                     .'&sort_by='.htmlspecialchars((string)$this->input->post('sort_by',true),ENT_QUOTES, 'UTF-8')
                     .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id'),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CallAPI($api,$data,$method);
            echo json_encode($result);
        }

        public function well_update_configration()
        {
           $well_type = htmlspecialchars((string)$this->input->post('well_type',true),ENT_QUOTES, 'UTF-8');
           

            if($well_type == 1)
            {
                $well = array();
                $start_time = $this->input->post('start_time',true);
                $stop_time = $this->input->post('stop_time',true);
                for ($i=0; $i < count($start_time); $i++)
                { 
                    $dev = array();
                    $dev['start_time'] = $start_time[$i];
                    $dev['stop_time'] = $stop_time[$i];
               
                        array_push($well,$dev);
                }
            }
            
            

            $api = 'Well_configuration/Update_Well_Configuration';
            

            if($well_type == 0)
            {
                 $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8').
                         '&well_id='.htmlspecialchars((string)$this->input->post('well_id_hdn',true),ENT_QUOTES, 'UTF-8').
                         '&well_type='.$well_type.
                         '&assign_date='.htmlspecialchars((string)$this->input->post('assign_date',true),ENT_QUOTES, 'UTF-8').
                         '&d_by='.htmlspecialchars((string)$this->session->userdata('id'),ENT_QUOTES, 'UTF-8');
            }else{

                $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8').
                         '&periodic_time='.(json_encode($well)).
                         '&well_id='.htmlspecialchars((string)$this->input->post('well_id_hdn',true),ENT_QUOTES, 'UTF-8').
                         '&well_type='.$well_type.
                         '&assign_date='.htmlspecialchars((string)$this->input->post('assign_date',true),ENT_QUOTES, 'UTF-8').
                         '&d_by='.htmlspecialchars((string)$this->session->userdata('id'),ENT_QUOTES, 'UTF-8');

            }
           
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            
            if($result['response_code'] == 200)
            {
                $this->session->set_flashdata('success', $result['msg']);
                redirect('Well_configration_c');
            }
            else
            {
                $this->session->set_flashdata('error', $result['msg']);
                redirect('Well_configration_c');
            }
        }
    }
?>
