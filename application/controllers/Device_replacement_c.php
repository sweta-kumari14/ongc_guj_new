<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    date_default_timezone_set('Asia/Kolkata');
    class Device_replacement_c extends MY_Controller
    {
        public function __construct()
        {
            parent:: __construct();
            
        }

        public function index()
        {
        	$api = 'Master/get_AssetList_for_replacement'; 
	        $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'))
                    .'&installed_by='.htmlspecialchars($this->session->userdata('user_id'));
	        $method = 'POST';
	        $result = $this->CallAPI($api,$data,$method);
	        $d['asset_name'] = $result['data'];

        	$d['v'] = "device_replacment_view";
            $this->load->view('templates',$d); 
        }

        public function get_area_list_for_replacement()
        {
        	$api = 'Master/getAreaList_forreplacement'; 
	        $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'))
                    .'&installed_by='.htmlspecialchars($this->session->userdata('user_id'))
                    .'&assets_id='.htmlspecialchars($this->input->post('assets_id',true)); 
	        $method = 'POST';
	        $result = $this->CallAPI($api,$data,$method);
	        
	        echo json_encode($result);
        }


        public function get_site_list_for_replacement()
        {
        	$api = 'Master/getSiteList_forreplacement'; 
	        $data =  'company_id='.htmlspecialchars($this->session->userdata('company_id'))
                     .'&installed_by='.htmlspecialchars($this->session->userdata('user_id'))
                     .'&assets_id='.htmlspecialchars($this->input->post('assets_id',true))
	                 .'&area_id='.htmlspecialchars($this->input->post('area_id',true)); 
	        $method = 'POST';
	        $result = $this->CallAPI($api,$data,$method);
	       
	        echo json_encode($result);
        }

        public function get_well_list_for_replacement()
        {
        	$api = 'Master/getWellList_forreplacement'; 
	        $data =  'company_id='.htmlspecialchars($this->session->userdata('company_id'))
                    .'&installed_by='.htmlspecialchars($this->session->userdata('user_id'))
                    .'&assets_id='.htmlspecialchars($this->input->post('assets_id',true))
	                 .'&area_id='.htmlspecialchars($this->input->post('area_id',true))
	                 .'&site_id='.htmlspecialchars($this->input->post('site_id',true)); 
	        $method = 'POST';
	        $result = $this->CallAPI($api,$data,$method);
	        
	        echo json_encode($result);
        }

        public function get_device_list_for_replacement()
        {
        	$api = 'Master/Device_Listfor_replacement'; 
	        $data =  'company_id='.htmlspecialchars($this->session->userdata('company_id'))
                    .'&user_id='.htmlspecialchars($this->session->userdata('user_id'))
                    .'&assets_id='.htmlspecialchars($this->input->post('assets_id',true))
	                 .'&area_id='.htmlspecialchars($this->input->post('area_id',true))
	                 .'&site_id='.htmlspecialchars($this->input->post('site_id',true))
	                 .'&well_id='.htmlspecialchars($this->input->post('well_id',true)); 
	        $method = 'POST';
	        $result = $this->CallAPI($api,$data,$method);
	      
	        echo json_encode($result);
        }

        public function get_new_device_data()
        {
        	$api = 'Master/getinstallation_DeviceList'; 
	        $data =  'company_id='.htmlspecialchars($this->session->userdata('company_id'))
                    .'&user_id='.htmlspecialchars($this->session->userdata('user_id'));
            $method = 'POST';
	        $result = $this->CallAPI($api,$data,$method);
	      
	        echo json_encode($result);
        }

        public function Device_replacement()
        {
            $user_id = htmlspecialchars($this->session->userdata('user_id'));
            $api = 'Device_Replacement_Data/Device_ReplacementData';
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id')).
                     '&user_id='.htmlspecialchars($this->session->userdata('user_id')).
                     '&assets_id='.htmlspecialchars($this->input->post('assets_id',true)).
                     '&area_id='.htmlspecialchars($this->input->post('area_id',true)).
                     '&site_id='.htmlspecialchars($this->input->post('site_id',true)).
                     '&well_id='.htmlspecialchars($this->input->post('well_hdn',true)).
                    '&old_imei_no='.htmlspecialchars($this->input->post('old_imei_no',true)).
                    '&reason_for_replacement='.htmlspecialchars($this->input->post('replacement_reason',true)).
                    '&old_sim_provider='.htmlspecialchars($this->input->post('old_sim_name_hdn',true)).
                    '&old_network='.htmlspecialchars($this->input->post('old_network_type_hdn',true)).
                    '&old_sim_no='.htmlspecialchars($this->input->post('old_sim_serial_no',true)).
                   '&new_imei_no='.htmlspecialchars($this->input->post('new_device_name',true)).
                   '&new_sim_provider='.htmlspecialchars($this->input->post('new_sim_name',true)).
                    '&new_network='.htmlspecialchars($this->input->post('new_network_type',true)).
                    '&new_sim_no='.htmlspecialchars($this->input->post('sim_new_serial_no',true)).
                    '&lat='.htmlspecialchars($this->input->post('lat_hdn',true)).
                    '&long='.htmlspecialchars($this->input->post('long_hdn',true)).
                   '&c_by='.$user_id;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
           

        
            if($result['response_code'] == 200)
            {
                $this->session->set_flashdata('success', $result['msg']);
                redirect('Device_replacement_c');
            }
            else
            {
                $this->session->set_flashdata('error', $result['msg']);
                redirect('Device_replacement_c');
            }
        }
        

    }
?>
