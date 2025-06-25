
<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    date_default_timezone_set('Asia/Kolkata');
    class Well_Integration_c extends MY_Controller
    {
        public function __construct()
        {
            parent:: __construct();
            
        }

        public function index()
        {
            
            $api ='Master/get_AssetList_Data';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
                     .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id'),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['assets_list'] = $result['data'];

            $d['v'] = "well_integration_view";
            $this->load->view('templates',$d);
        }

        

        public function get_site_list()
        {
            $api ='Master/get_Site_List_Data';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
            .'&assets_id='.htmlspecialchars((string)$this->input->post('assets_id',true),ENT_QUOTES, 'UTF-8')
            .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id',true),ENT_QUOTES, 'UTF-8')
            .'&area_id='.htmlspecialchars((string)$this->input->post('area_id',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }

        public function get_area_list()
        {
            $api ='Master/get_Area_List_Data';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
            .'&assets_id='.htmlspecialchars((string)$this->input->post('assets_id',true),ENT_QUOTES, 'UTF-8')
            .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }
        
        public function get_well_list()
        {

            $api ='Area_Dashboard/WellList_forDashboard';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
                    .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id'),ENT_QUOTES, 'UTF-8')
                    .'&assets_id='.htmlspecialchars((string)$this->input->post('assets_id',true),ENT_QUOTES, 'UTF-8')
                    .'&area_id='.htmlspecialchars((string)$this->input->post('area_id',true),ENT_QUOTES, 'UTF-8')
                    .'&site_id='.htmlspecialchars((string)$this->input->post('site_id',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
            
        }

        public function Add_Well_integration_details()
        {
            // echo "<pre>";
            // print_r($_POST);
            $user_id = htmlspecialchars((string)$this->session->userdata('user_id'),ENT_QUOTES, 'UTF-8');

            $well_type = htmlspecialchars((string)$this->input->post('well_type'),ENT_QUOTES, 'UTF-8');
            if($well_type == '0')
            {
                $well_name = htmlspecialchars((string)$this->input->post('well_name',true),ENT_QUOTES, 'UTF-8');

            }else if($well_type == '1')
            {
                $well_name = htmlspecialchars((string)$this->input->post('well_name_hdn',true),ENT_QUOTES, 'UTF-8');
            }else if($well_type == '2')
            {
                $well_name = "";
            } 

            $api = 'Well_integration/Add_Well_integration';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id',true),ENT_QUOTES, 'UTF-8').
            '&assets_id='.htmlspecialchars((string)$this->input->post('assets_id',true),ENT_QUOTES, 'UTF-8').
            '&area_id='.htmlspecialchars((string)$this->input->post('area_id',true),ENT_QUOTES, 'UTF-8').
            '&site_id='.htmlspecialchars((string)$this->input->post('site_id',true),ENT_QUOTES, 'UTF-8').
            '&well_type='.$well_type.
            '&well_name='.$well_name.
            '&well_id='.htmlspecialchars((string)$this->input->post('well_id_hdn'),ENT_QUOTES, 'UTF-8').
            '&device_name='.htmlspecialchars((string)$this->input->post('device_name_hdn'),ENT_QUOTES, 'UTF-8').
            '&imei_no='.htmlspecialchars((string)$this->input->post('imei_no_hdn'),ENT_QUOTES, 'UTF-8').
            '&to_well_id='.htmlspecialchars((string)$this->input->post('to_well_id'),ENT_QUOTES, 'UTF-8').
            '&to_well_name='.htmlspecialchars((string)$this->input->post('to_well_name'),ENT_QUOTES, 'UTF-8').
            '&well_status='.htmlspecialchars((string)$this->input->post('well_status'),ENT_QUOTES, 'UTF-8').
            '&tentative_date='.htmlspecialchars((string)$this->input->post('tentative_date'),ENT_QUOTES, 'UTF-8').
            '&reason_remove='.htmlspecialchars((string)$this->input->post('reason_remove'),ENT_QUOTES, 'UTF-8').
            '&c_by='.$user_id;
            $method = 'POST';

            // echo "<pre>";
            // print_r($data);die;
            $result = $this->CallAPI($api, $data, $method);
            
            if($result['response_code'] == 200)
            {
                $this->session->set_flashdata('success', $result['msg']);
                redirect('Well_Integration_c/well_integration_report');
            }
            else
            {
                $this->session->set_flashdata('error', $result['msg']);
                redirect('Well_Integration_c/well_integration_report');
            }
        }

        public function well_integration_report()
        {

            $api ='Area_Dashboard/SiteList_forDashboard';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
            .'&assets_id='.htmlspecialchars((string)$this->input->post('assets_id',true),ENT_QUOTES, 'UTF-8')
            .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id'),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['site_list'] = $result['data'];

            $api ='Area_Dashboard/WellList_forDashboard';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['well_list'] = $result['data'];

            $api ='FeederMaster/FeederList';
            $data = '';
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['feeder_list'] = $result['data'];

            $d['v'] = "well_integration_report_view";
            $this->load->view('templates',$d); 
        }

        public function update_well_feeder()
        {  

            $api = 'Well_type_master/Welllist';
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'));
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            $d['well_type_list'] = $result['data'];
           
            // Get feeder list from API
            $api = 'FeederMaster/FeederList';
            $data = '';
            $method = 'POST';
            $result = $this->CALLAPI($api, $data, $method);
            $d['feeder_list'] = $result['data'];

            $d['v'] = "update_well_feeder_view";
            $this->load->view('templates', $d); 
        }

        public function get_well_list_for_feeder()
        {
            $api = 'Area_Dashboard/WellList_forDashboard';
            $data = 'company_id=' . htmlspecialchars((string)$this->session->userdata('company_id'), ENT_QUOTES, 'UTF-8')
                . '&site_id=c1bcb5e4-b394-11ee-a6d4-5cb901ad9cf0'
                .'&well_type='.$this->input->post('well_type');
            $method = 'POST';
            $result = $this->CALLAPI($api, $data, $method);
            echo json_encode($result);

        }


        public function get_integration_details_report()
        {

            $api ='Well_integration/well_integration_report';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
                     .'&from_date='.htmlspecialchars((string)$this->input->post('from_date',true),ENT_QUOTES, 'UTF-8')
                     .'&to_date='.htmlspecialchars((string)$this->input->post('to_date',true),ENT_QUOTES, 'UTF-8')
                     .'&sort_by='.htmlspecialchars((string)$this->input->post('sort_by',true),ENT_QUOTES, 'UTF-8')
                     .'&site_id='.htmlspecialchars((string)$this->input->post('site_id',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
            
        }

        public function edit_complaints()
        {
            $ticket_id = htmlspecialchars((string)$this->input->post('ticket_id',true),ENT_QUOTES, 'UTF-8');
            $well_type = htmlspecialchars((string)$this->input->post('well_type',true),ENT_QUOTES, 'UTF-8');
            $api = 'Well_integration/well_integration_report';
            $data = 'ticket_id='.$ticket_id
                     .'&well_type='.$well_type;
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['list_complaints'] = $result['data'];
            // echo '<pre>';
            // print_r($d['list_complaints']);die;
            $this->load->view('edit/edit_well_integration_view',$d); 
        
        }

        public function well_integration_update()
        {
            $api = 'Well_integration/Update_well_integration_data';
            $data = 'ticket_id='.htmlspecialchars((string)$this->input->post('ticket_id',true),ENT_QUOTES, 'UTF-8')
                   .'&well_type='.$this->input->post('well_type',true)
                   .'&operation_date='.$this->input->post('operation_date',true)
                   .'&imei_no='.$this->input->post('imei_no',true)
                   .'&complaint_status='.$this->input->post('complaint_status',true)
                   .'&reason_remove='.$this->input->post('reason_remove',true)
                   .'&d_by='.htmlspecialchars((string)$this->session->userdata('user_id',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
           
            if($result['response_code'] == 200)
            {
                $this->session->set_flashdata('success', $result['msg']);
                redirect('Well_Integration_c/well_integration_report');
            }
            else
            {
                $this->session->set_flashdata('error', $result['msg']);
                redirect('Well_Integration_c/well_integration_report');
            }

        }
        

        public function get_total_count()
        {
            $api ='Well_integration/get_total_count';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
                     .'&from_date='.htmlspecialchars((string)$this->input->post('from_date',true),ENT_QUOTES, 'UTF-8')
                     .'&to_date='.htmlspecialchars((string)$this->input->post('to_date',true),ENT_QUOTES, 'UTF-8')
                     .'&sort_by='.htmlspecialchars((string)$this->input->post('sort_by',true),ENT_QUOTES, 'UTF-8')
                     .'&site_id='.htmlspecialchars((string)$this->input->post('site_id',true),ENT_QUOTES, 'UTF-8')
                     .'&complaint_status='.htmlspecialchars((string)$this->input->post('complaint_status',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }

        public function update_feeder_well()
        {
             $api ='Well_integration/Well_feeder_change';
             $data = 'well_id='.$this->input->post('well_id',true)
                    . '&well_type=' . $this->input->post('well_type', true)
                      .'&feeder_id='.$this->input->post('feeder_id',true)
                      .'&d_by='.htmlspecialchars((string)$this->session->userdata('user_id',true),ENT_QUOTES, 'UTF-8');  
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            // print_r($data);
            // print_r($result);die;
            if($result['response_code'] == 200)
            {
                $this->session->set_flashdata('success', $result['msg']);
                redirect('Well_Integration_c/update_well_feeder');
            }
            else
            {
                $this->session->set_flashdata('error', $result['msg']);
                redirect('Well_Integration_c/update_well_feeder');
            }      
    }
}
?>
