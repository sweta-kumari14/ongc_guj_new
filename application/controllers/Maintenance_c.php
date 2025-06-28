
<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata');
class Maintenance_c extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

    } 
        public function index()
        {

            $api ='Master/Well_list';
            $data = '';
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['well_list'] = $result['data'];
            // echo'<pre>';
            // print_r($d['well_list']);die;
            $api ='Report/get_problemlist';
            $data = '';
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['issue_list'] = $result['data'];


            $d['v'] = "report/maintenance_report";
            $this->load->view('templates',$d); 
        }

        public function get_maintenance_report()
        {
        	
        	$api ='Report/Report_Maintance';
            $data = 'area_id='.$this->input->post('area_id',true)
                    .'&site_id='.$this->input->post('site_id',true)
                    .'&well_id='.$this->input->post('well_id',true)
                    .'&from_date='.$this->input->post('from_date',true)
                    .'&to_date='.$this->input->post('to_date',true)
                    .'&issue_status='.$this->input->post('issue_status',true);
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }

        public function get_timeline_maintance_details()
        {
            
            $api ='Report/get_maintenance_timeline';
            $data = 'maintance_id='.$this->input->post('maintance_id',true);
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        
        }

}
?>