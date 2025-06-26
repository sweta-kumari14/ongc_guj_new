<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata');
class Sensor_installed_report_c extends MY_Controller
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
            // echo'<pre>';
            // print_r($d['site_list']);die;
            
            
            $api = 'Component_master/Component_List';
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'));
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            $d['component_list'] = $result['data'];

            //   echo'<pre>';
            // print_r($d['component_list']);die;

            $d['v'] = "report/sensor_installed_report";
            $this->load->view('templates',$d); 
        }

        public function get_sensor_installed_report()
        {
        	
        	$api ='Report/Well_installed_sensorLog_Report';
            $data = 'well_id='.$this->input->post('well_id',true)
                    .'&component_id='.$this->input->post('component_id',true)
                    .'&from_date='.$this->input->post('from_date',true)
                    .'&to_date='.$this->input->post('to_date',true)
                    .'&tag_status'.$this->input->post('tag_status',true);
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }

}
?>