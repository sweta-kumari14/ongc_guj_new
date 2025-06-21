<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    date_default_timezone_set('Asia/Kolkata');
    class Company_Mis_Report_c extends MY_Controller
    {
        public function __construct()
        {
            parent:: __construct();
            
        }

        public function index()
        {
        	$api = 'Daily_Runniny_Report/device_mis_ime_no_list';
            $data ='imei_no'.$this->input->post('imei_no');
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            $d['imei_list'] = $result['data'];

           
            $d['v'] = "company_mis_report_view";
            $this->load->view('templates',$d); 
        }

        public function get_Device_mis_report()
        {
            $api = 'Daily_Runniny_Report/Device_mis_log_data';
            $method = 'POST';
            $data = 'well_id='.htmlspecialchars((string)$this->input->post('well_id',true),ENT_QUOTES,'UTF-8')
            .'&imei_no='.htmlspecialchars((string)$this->input->post('imei_no',true),ENT_QUOTES,'UTF-8')
            .'&from_date='.htmlspecialchars((string)$this->input->post('from_date',true),ENT_QUOTES,'UTF-8')
            .'&to_date='.htmlspecialchars((string)$this->input->post('to_date',true),ENT_QUOTES,'UTF-8');
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }
    }
?>