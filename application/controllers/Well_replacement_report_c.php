<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    date_default_timezone_set('Asia/Kolkata');
    class Well_replacement_report_c extends MY_Controller
    {
        public function __construct()
        {
            parent:: __construct();
            
        }

        public function index()
        {
            $api = 'Master/get_well_list_for_report'; 
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'));
            $method = 'POST';
            $result = $this->CallAPI($api,$data,$method);
            $d['well_list'] = $result['data'];
            

        	$d['v'] = "report/well_replacement_report_view";
            $this->load->view('templates',$d); 
        }

        public function get_shifted_well_data()
        {
            $api = 'Well_wiseDeviceShifting/Well_to_Well_Shifting_Report';
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'))
                    .'&from_date='.htmlspecialchars($this->input->post('from_date',true))
                    .'&to_date='.htmlspecialchars($this->input->post('to_date',true))
                    .'&well_id='.htmlspecialchars($this->input->post('well_id',true));
            $method = 'POST';
            $result = $this->CallAPI($api,$data,$method);
            echo json_encode($result);
        }

        public function well_shifted_details_through()
        {
            $api = 'Well_wiseDeviceShifting/Well_shifting_details';
            $data = 'imei_no='.htmlspecialchars($this->input->post('imei_no'));
            $method = 'POST';
            $result = $this->CallAPI($api,$data,$method);
            echo json_encode($result);
        }

        public function well_shifted_details_through_well_id()
        {
            $api = 'Well_wiseDeviceShifting/well_shifting_details_through_well_id';
            $data = 'well_id='.htmlspecialchars($this->input->post('well_id'));
            $method = 'POST';
            $result = $this->CallAPI($api,$data,$method);
            echo json_encode($result);
        }


    }
?>