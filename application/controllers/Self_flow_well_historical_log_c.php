<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata');
class Self_flow_well_historical_log_c extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

    } 

    public function index()
    {
        $api ='Selfflow_area_dashboard/WellList_forDashboard';
        $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
        .'&assets_id='.htmlspecialchars((string)$this->session->userdata('assets_id'),ENT_QUOTES, 'UTF-8')
        .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id'),ENT_QUOTES, 'UTF-8');
        $method = 'POST';
        $result = $this->CALLAPI($api,$data,$method);
        $d['well_list'] = $result['data'];

        // echo'<pre>';
        // print_r($d['well_list']);die;

        $d['v']= "report/self_histrorical_report_well_view";
        $this->load->view('templates',$d);
    }

    public  function historical_graph_page()
    {
        $d['v']= "report/self_flow_historical_graph_view";
        $this->load->view('templates',$d);
    }

    public function get_well_list()
    {
        $api ='Selfflow_area_dashboard/WellList_forDashboard';
        $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
        .'&assets_id='.htmlspecialchars((string)$this->session->userdata('assets_id'),ENT_QUOTES, 'UTF-8')
        .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id'),ENT_QUOTES, 'UTF-8');
        $method = 'POST';
        $result = $this->CALLAPI($api,$data,$method);
        echo json_encode($result);
    }
    public function  get_mis_report_histrorical()
    { 
        $api = 'Selfflow_report/Historial_data_Mis_Report';
        $data = 'well_id='.htmlspecialchars((string)$this->input->post('well_id'),ENT_QUOTES, 'UTF-8')
                .'&from_date='.htmlspecialchars((string)$this->input->post('from_date'),ENT_QUOTES, 'UTF-8')
                .'&to_date='.htmlspecialchars((string)$this->input->post('to_date'),ENT_QUOTES, 'UTF-8');
        $method = 'POST';
        $result = $this->CallAPI($api,$data,$method);
        echo json_encode($result);
    }

        public function  get_graph_histrorical()
        {
            $well_ids = $this->input->post('well_id'); 
            $well_ids = json_encode($well_ids);
            $api = 'Selfflow_report/Historical_All_Type_Graph';
            $data = 'well_id='.$well_ids
                    .'&from_date='.htmlspecialchars((string)$this->input->post('from_date',true),ENT_QUOTES, 'UTF-8')
                    .'&to_date='.htmlspecialchars((string)$this->input->post('to_date',true),ENT_QUOTES, 'UTF-8')
                    .'&graph_type='.htmlspecialchars((string)$this->input->post('graph_type',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CallAPI($api,$data,$method);

            // print_r($data);die;
            echo json_encode($result);
        }
}
?>









