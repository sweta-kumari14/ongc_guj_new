<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    date_default_timezone_set('Asia/Kolkata');
    class Last_10_data_report_c extends MY_Controller
    {
        public function __construct()
        {
            parent:: __construct();
        }

        public function index()
        {
            
            $api = 'DeviceLog_last_Data/Imei_list';
            $data ='';
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            $d['imei_list'] = $result['data'];

            $d['v'] = "report/last_10_data_report_view";
            $this->load->view('templates',$d); 
        }

        public function get_last_10_data_ajax()
        {
            $api = 'DeviceLog_last_Data/Device_Log_last_tenData';
            $method = 'POST';
            $data = 'imei_no='.htmlspecialchars($this->input->post('imei_no',true));
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }

        

        

        

        
    }
?>