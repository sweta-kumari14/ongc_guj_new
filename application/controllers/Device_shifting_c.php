<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    date_default_timezone_set('Asia/Kolkata');
    class Device_shifting_c extends MY_Controller
    {
        public function __construct()
        {
            parent:: __construct();
            
        }

        public function index()
        {
        	$api = 'Master/get_from_wellList_for_shifting'; 
	        $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'));
	        $method = 'POST';
	        $result = $this->CallAPI($api,$data,$method);
	        $d['from_well_list'] = $result['data'];

            $api = 'Master/get_to_wellList_for_shifting'; 
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'));     
            $method = 'POST';
            $result = $this->CallAPI($api,$data,$method);
            $d['to_well_list'] = $result['data'];

        	$d['v'] = "device_shifting_view";
            $this->load->view('templates',$d); 
        }

        public function device_shifting_data()
        {
            $user_id = $this->session->userdata('user_id');
            $api = 'Well_wiseDeviceShifting/SaveShifted_Device';
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id')).
                    '&shifted_by='.htmlspecialchars($this->session->userdata('id')).
                    '&shifted_well_id='.htmlspecialchars($this->input->post('hdn_from_well_id',true)).
                    '&shifted_imei_no='.htmlspecialchars($this->input->post('from_well_imei_no',true)).
                    '&shifted_device_name='.htmlspecialchars($this->input->post('from_well_device_name',true)).
                    '&shifted_well_installation_date='.htmlspecialchars($this->input->post('from_installation_date',true)).
                    '&allot_well_id='.htmlspecialchars($this->input->post('hdn_to_well_id',true)).
                    '&date_of_shifted='.htmlspecialchars($this->input->post('shifting_date_time',true)).
                    '&allot_prv_device_name='.htmlspecialchars($this->input->post('to_well_previous_device_name',true)).
                    '&allot_prv_imei_no='.htmlspecialchars($this->input->post('to_well_previous_imei_no',true)).
                    '&shifting_status='.htmlspecialchars($this->input->post('shifting_status',true)).
                    '&allot_prv_installation_date='.htmlspecialchars($this->input->post('to_well_previous_installation_date',true));
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
          
            if($result['response_code'] == 200)
            {
                $this->session->set_flashdata('success', $result['msg']);
                redirect('Device_shifting_c');
            }
            else
            {
                $this->session->set_flashdata('error', $result['msg']);
                redirect('Device_shifting_c');
            }
        }
        
        }
    
?>
