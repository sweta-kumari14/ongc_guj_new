<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata');
class Faulty_alert_report_c extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

    } 
        public function index()
        { 
        	$api ='Master/Install_self_flow_Well_List';
        $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'));
        $method = 'POST';
        $result = $this->CALLAPI($api,$data,$method);
        $d['well_list'] = $result['data'];
        
        	$d['v'] = "report/faulty_alert_report";
            $this->load->view('templates',$d); 
        }
}
?>