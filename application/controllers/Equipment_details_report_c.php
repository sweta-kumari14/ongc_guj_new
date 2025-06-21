<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    date_default_timezone_set('Asia/Kolkata');
    class Equipment_details_report_c extends MY_Controller
    {
        public function __construct()
        {
            parent:: __construct();
        }

        public function index()
        {
            $module_name = 'Equipment Details Report Module';
            $api = 'Master/AccessLog';
            $data = 'id='.$this->session->userdata('id').'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $d['v'] = "report/equipment_details_report_view";
            $this->load->view('templates',$d); 
        }

        public function get_equipment_details()
        {
            $api = 'Report/EquipmentDetails_Report';
            $method = 'POST';
            $data = 'company_id='.$this->session->userdata('company_id').'&from_date='.$this->input->post('from_date',true).'&to_date='.$this->input->post('to_date',true);
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }

      
    }
?>