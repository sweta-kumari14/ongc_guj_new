<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    date_default_timezone_set('Asia/Kolkata');
    class Device_allot_to_installer_c extends MY_Controller
    {
        public function __construct()
        {
            parent:: __construct();
            
        }

        public function index()
        {
            $module_name = 'Device allotment List';
            $api = 'Master/AccessLog';
            $data = 'id='.htmlspecialchars($this->session->userdata('id')).'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $api ='DeviceAllotment_to_Installer/AllotUser_List';
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'));
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['user_list'] = $result['data'];
           

            $d['v'] = "device_allotment_to_installer_view";
            $this->load->view('templates',$d); 
        }

        public function get_device_list()
        {
            $company_id = $this->session->userdata('company_id');
            $user_id = $this->input->post('user_id')!=''?$this->input->post('user_id'):'';
            $api = 'DeviceAllotment_to_Installer/get_devicelist_for_installer';
            $data = 'company_id='.htmlspecialchars($company_id).'&user_id='.htmlspecialchars($user_id);
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            // echo "<pre>";
            // print_r($result);die;
            echo json_encode($result,true);
            
        }


        public function allot_ins_devices()
        {
            $device_list = $this->input->post('assign')!=''?json_encode($this->input->post('assign'),true):json_encode([],true);

            $module_name = 'Allot Device to installer';
            $api = 'Master/AccessLog';
            $data = 'id='.htmlspecialchars($this->session->userdata('id')).'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $api = 'DeviceAllotment_to_Installer/Installer_Allotment';
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id')).
            '&user_id='.htmlspecialchars($this->input->post('user_id',true)).
            '&assign_device='.$device_list.
            '&c_by='.htmlspecialchars($this->session->userdata('id'));
            
            $method = 'POST';
           
            $result = $this->CallAPI($api, $data, $method);
            if($result['response_code'] == 200)
            {
                $this->session->set_flashdata('success', $result['msg']);
                redirect('Device_allot_to_installer_c');
            }
            else
            {
                $this->session->set_flashdata('error', $result['msg']);
                redirect('Device_allot_to_installer_c');
            }
        }
    }
?>

