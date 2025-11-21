<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    date_default_timezone_set('Asia/Kolkata');
    class Device_configration_setup_c extends MY_Controller
    {
        public function __construct()
        {
            parent:: __construct();
            
        }

        public function index()
        { 
            
            $d['v'] = "device_configration_setup_view";
            $this->load->view('templates',$d); 
        }


        public function device_list()
        {
            $api = 'Device_configration_setup/device_List';
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'));
            $method ='POST';
            $result = $this->CallAPI($api,$data,$method);
            echo json_encode($result);
        }

        public function well_list_details()
        {
            $api = 'Device_configration_setup/well_details_for_configration_setup';
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'))
                    .'&imei_no='.htmlspecialchars($this->input->post('imei_no',true));
            $method ='POST';
            $result = $this->CallAPI($api,$data,$method);
            echo json_encode($result);
        }

        public function well_threshold_list_details()
        {
            $api = 'Device_configration_setup/well_details_threshold_details';
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'))
                    .'&well_id='.htmlspecialchars($this->input->post('well_id',true));
            $method ='POST';
            $result = $this->CallAPI($api,$data,$method);
            echo json_encode($result);
        }

        
        public function well_preview_jason_details()
        {
            $api = 'Device_configration_setup/well_preview_jason_details';
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'))
                    .'&imei_no='.htmlspecialchars($this->input->post('imei_no',true));
            $method ='POST';
            $result = $this->CallAPI($api,$data,$method);
            echo json_encode($result);
        }

        public function update_threshold_details()
        {
            $api = 'Device_configration_setup/update_configration';
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'))
                    .'&area_id='.htmlspecialchars($this->input->post('area_id',true))
                    .'&site_id='.htmlspecialchars($this->input->post('site_id',true))
                    .'&well_id='.htmlspecialchars($this->input->post('well_id',true))
                    .'&threshold_data='.($this->input->post('threshold_data',true))
                    .'&c_by='.htmlspecialchars($this->session->userdata('user_id'));
            $method ='POST';
            $result = $this->CallAPI($api,$data,$method);
            echo json_encode($result);
        }

        public function update_device_time_settings()
        {
            $api = 'Device_configration_setup/update_device_configration';
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'))
                    .'&device_name='.htmlspecialchars($this->input->post('device_name',true))
                    .'&imei_no='.htmlspecialchars($this->input->post('imei_no',true))
                    .'&node_scan_time='.htmlspecialchars($this->input->post('node_scan_time',true))
                    .'&node_log_time='.htmlspecialchars($this->input->post('node_log_time',true))
                     .'&gateway_log_time='.htmlspecialchars($this->input->post('gateway_log_time',true))
                   
                    .'&d_by='.htmlspecialchars($this->session->userdata('user_id'));
            $method ='POST';
            $result = $this->CallAPI($api,$data,$method);
            echo json_encode($result);
        }

        public function publish_device_config()
        {
            $api ='Real_Time_mqtt_data/Device_configration_send';
            $data = 'command_data='.$this->input->post('command_data',true)
                     .'&imei_no='.$this->input->post('imei_no',true)
                     .'&c_by='.$this->session->userdata('user_id',true);
            $method ='POST';
            $result = $this->CallAPI($api,$data,$method);
            echo json_encode($result);
        }

        public function device_configration_report_page()
        {
            $api = 'Device_configration_setup/device_List';
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'));
            $method ='POST';
            $result = $this->CallAPI($api,$data,$method);
            $d['device_list'] = $result['data'];

            $d['v'] = "report/device_configration_report";
            $this->load->view('templates',$d); 
        }

        public function device_config_ajax()
        {
            $api ='Real_Time_mqtt_data/Device_configration_publish_log';
            $data = 'imei_no='.$this->input->post('imei_no',true)
                     .'&from_date='.$this->input->post('from_date',true)
                     .'&to_date='.$this->input->post('to_date',true)
                     .'&c_by='.$this->session->userdata('user_id',true);
            $method ='POST';
            $result = $this->CallAPI($api,$data,$method);
            echo json_encode($result);
        }
    
}
?>