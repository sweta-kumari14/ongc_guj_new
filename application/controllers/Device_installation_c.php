<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    date_default_timezone_set('Asia/Kolkata');
    class Device_installation_c extends MY_Controller
    {
        public function __construct()
        {
            parent:: __construct();
            
        }

        public function index()
        {
            $api = 'Master/get_AssetList';
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'))
                    .'&user_id='.htmlspecialchars($this->session->userdata('user_id'));
            $method = 'POST';
            $result = $this->CallAPI($api,$data,$method);
            $d['assets_list'] = $result['data'];

            // echo "<pre>";
            // print_r($data);
            // print_r($result);die;
          
           $api = 'Well_type_master/Welllist';
                    $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'));
                    $method = 'POST';
                    $result = $this->CallAPI($api, $data, $method);
                    $d['well_type_list'] = $result['data'];


            $api = 'Master/getinstallation_DeviceList';
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'))
                    .'&user_id='.htmlspecialchars($this->session->userdata('user_id'));
            $method = 'POST';
            $result = $this->CallAPI($api,$data,$method);
            $d['device_list'] = $result['data'];
            
            $d['v'] = "device_installation_view";
            $this->load->view('templates',$d); 
        }
        public function get_well_type_for_device_install()
        {
             // Get well list from API
            $api = 'Area_Dashboard/WellList_forDashboard';
            $data = 'company_id=' . htmlspecialchars((string)$this->session->userdata('company_id'), ENT_QUOTES, 'UTF-8')
                . '&site_id=c1bcb5e4-b394-11ee-a6d4-5cb901ad9cf0'
                .'&well_type='.$this->input->post('well_type');
            $method = 'POST';
            $result = $this->CALLAPI($api, $data, $method);
            echo json_encode($result);

        }
        public function get_area_list()
        {
             $api = 'Master/get_Area_List';
             $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'))
                    .'&user_id='.htmlspecialchars($this->session->userdata('user_id'))
                    .'&assets_id='.htmlspecialchars($this->input->post('assets_id'));
             $method = 'POST';
             $result = $this->CallAPI($api,$data,$method);
             echo json_encode($result);
        }

        public function get_feeder_list()
        {
            $api ='FeederMaster/FeederList';
            $data = 'area_id='.htmlspecialchars((string)$this->input->post('area_id',true));
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $result = $this->CallAPI($api,$data,$method);
             echo json_encode($result);
        }

         public function getsite_list()
        {
             $api = 'Master/getSite_List';
             $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'))
                    .'&user_id='.htmlspecialchars($this->session->userdata('user_id'))
                    .'&assets_id='.htmlspecialchars($this->input->post('assets_id'))
                    .'&area_id='.htmlspecialchars($this->input->post('area_id'));
             $method = 'POST';
             $result = $this->CallAPI($api,$data,$method);
             echo json_encode($result);
        }


        public function getWell_forinstallation_list()
        {
             $api = 'Master/getWell_List';
             $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'))
                    .'&user_id='.htmlspecialchars($this->session->userdata('user_id'))
                    .'&assets_id='.htmlspecialchars($this->input->post('assets_id'))
                    .'&area_id='.htmlspecialchars($this->input->post('area_id'))
                    .'&site_id='.htmlspecialchars($this->input->post('site_id'));
             $method = 'POST';
             $result = $this->CallAPI($api,$data,$method);
           

             echo json_encode($result);
        }

      

        public function Device_install()
        {
            $user_id = $this->session->userdata('user_id');
            $api = 'Device_install_data/AddDevice_Installation_Data';
            $data = 'well_id='.htmlspecialchars($this->input->post('well_hdn',true)).
            '&assets_id='.htmlspecialchars($this->input->post('assets_id',true)).
            '&area_id='.htmlspecialchars($this->input->post('area_id',true)).
            '&site_id='.htmlspecialchars($this->input->post('site_id',true)).
            '&device_name='.htmlspecialchars($this->input->post('device_name_hdn',true)).
            '&imei_no='.htmlspecialchars($this->input->post('imei_no_hdn',true)).
            '&sim_no='.htmlspecialchars($this->input->post('sim_no',true)).
            '&sim_provider='.htmlspecialchars($this->input->post('sim_provider',true)).
            '&network_type='.htmlspecialchars($this->input->post('network_type',true)).
            '&company_id='.htmlspecialchars($this->session->userdata('company_id')).
            '&installed_by='.htmlspecialchars($this->session->userdata('user_id')).
            '&feeder_id='.htmlspecialchars($this->input->post('feeder_id')).
            '&lat='.htmlspecialchars($this->input->post('lat_hdn',true)).
            '&long='.htmlspecialchars($this->input->post('long_hdn',true)).
            '&c_by='.$user_id;
            '&well_type=' . htmlspecialchars($this->input->post('well_type', true)) . // New
            '&image=' . urlencode($image_base64); // New

            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
             // echo "<pre>";
             //print_r($data);
             //print_r($result);die;
        
            if($result['response_code'] == 200)
            {
                $this->session->set_flashdata('success', $result['msg']);
                redirect('Device_installation_c');
            }
            else
            {
                $this->session->set_flashdata('error', $result['msg']);
                redirect('Device_installation_c');
            }
        }

            

    }
?>