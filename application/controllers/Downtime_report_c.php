<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Downtime_report_c extends MY_Controller
    {
        public function __construct()
        {
            parent:: __construct();
        }

        public function index()
        {
            $api ='Master/Install_self_flow_Well_List';
        $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'));
        $method = 'POST';
        $result = $this->CALLAPI($api,$data,$method);
        $d['well_list'] = $result['data'];

            $d['v'] = "report/downTime_report_view";
            $this->load->view('templates',$d); 
        }

        public function  getWell_downtime_report()
        { 
            $api = 'Report/WellDowntimeLog_Report';
            $data = 'well_id='.htmlspecialchars((string)$this->input->post('well_id'),ENT_QUOTES, 'UTF-8')
                    .'&from_date='.htmlspecialchars((string)$this->input->post('from_date'),ENT_QUOTES, 'UTF-8')
                    .'&to_date='.htmlspecialchars((string)$this->input->post('to_date'),ENT_QUOTES, 'UTF-8')
                    .'&limit='.$this->input->post('limit',true)
                    .'&offset='.$this->input->post('offset',true);
            $method = 'POST';
            $result = $this->CallAPI($api,$data,$method);
            // print_r($result); die;
            echo json_encode($result);
        }
}
?>