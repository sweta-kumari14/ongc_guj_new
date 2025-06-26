<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata');
class Selfflow_alert_c extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

    } 

    public function index()
    {
         $api = 'Area_Dashboard/AreaList_forDashboard';
            $data = 'company_id=' . htmlspecialchars((string)$this->session->userdata('company_id'), ENT_QUOTES, 'UTF-8')
                  . '&assets_id=' . htmlspecialchars((string)$this->input->post('assets_id', true), ENT_QUOTES, 'UTF-8')
                  . '&user_id=' . htmlspecialchars((string)$this->session->userdata('user_id'), ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api, $data, $method);
            $d['area_list'] = $result['data'];


        $api ='Selfflow_area_dashboard/WellList_forDashboard';
        $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
        .'&assets_id='.htmlspecialchars((string)$this->session->userdata('assets_id'),ENT_QUOTES, 'UTF-8')
        .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id'),ENT_QUOTES, 'UTF-8');
        $method = 'POST';
        $result = $this->CALLAPI($api,$data,$method);
        $d['well_list'] = $result['data'];

        // echo'<pre>';
        // print_r($d['well_list']);die;

        $d['v']= "report/alert_selfflow_report_view";
        $this->load->view('templates',$d);
    }
 
    public function get_datewise_alert_report()
    {
        $api = 'Selfflow_alert/Date_Wise_Alert_Report';
        $method = 'POST';
        $data = 'date='.htmlspecialchars((string)$this->input->post('date',true),ENT_QUOTES, 'UTF-8')
        .'&sort_by='.htmlspecialchars((string)$this->input->post('sort_by',true),ENT_QUOTES, 'UTF-8')
        .'&user_id='.htmlspecialchars((string)$this->input->post('user_id',true),ENT_QUOTES, 'UTF-8');
        $result = $this->CallAPI($api, $data, $method);
        echo json_encode($result);
    }
    public function get_wellwise_alert_data()
    {
        $api = 'Selfflow_alert/Well_wise_Alert_Report';
        $method = 'POST';
        $data = 'well_id='.htmlspecialchars((string)$this->input->post('well_id',true),ENT_QUOTES, 'UTF-8')
        .'&from_date='.htmlspecialchars((string)$this->input->post('from_date',true),ENT_QUOTES, 'UTF-8')
        .'&sort_by='.htmlspecialchars((string)$this->input->post('sort_by',true),ENT_QUOTES, 'UTF-8')
        .'&to_date='.htmlspecialchars((string)$this->input->post('to_date',true),ENT_QUOTES, 'UTF-8');
        $result = $this->CallAPI($api, $data, $method);
        echo json_encode($result);
    }   
}
?>