<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    date_default_timezone_set('Asia/Kolkata');
    class Device_allotment_to_company_c extends MY_Controller
    {
        public function __construct()
        {
            parent:: __construct();
            
        }

        public function index()
        {
            $module_name = 'Visit Device Allotment to Company Module';
            $api = 'Master/AccessLog';
            $data = 'id='.htmlspecialchars($this->session->userdata('id')).'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $api ='Master/Company_list';
            $data = '';
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['company_list'] = $result['data'];
            // echo "<pre>";
            // print_r($result);die;

            $api ='Master/Device_list_for_company';
            $data = '';
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['device_list'] = $result['data'];

            $d['v'] = "device_allotment_to_company_view";
            $this->load->view('templates',$d); 
        }

        public function allot_devices()
        {
            $module_name = 'Allot Device to Company';
            $api = 'Master/AccessLog';
            $data = 'id='.htmlspecialchars($this->session->userdata('id')).'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $device = array();
            $device_name = $this->input->post('device_name',true);
            $imei_no = $this->input->post('imei_no',true);
            $serial_no = $this->input->post('serial_no',true);
            for ($i=0; $i < count($device_name); $i++) { 
                $dev = array();
                $dev['device_name'] = $device_name[$i];
                $dev['imei_no'] = $imei_no[$i];
                $dev['serial_no'] = $serial_no[$i];
                array_push($device,$dev);
            }

            $api = 'Device_master/Device_Allotment_To_Comapany';
            $data = 'company_id='.htmlspecialchars($this->input->post('company_name',true)).
            '&allot_device='.(json_encode($device)).
            '&c_by='.htmlspecialchars($this->session->userdata('id'));
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            
            if($result['response_code'] == 200)
            {
                $this->session->set_flashdata('success', $result['msg']);
                redirect('Device_allotment_to_company_c');
            }
            else
            {
                $this->session->set_flashdata('error', $result['msg']);
                redirect('Device_allotment_to_company_c');
            }
        }
    }
?>

