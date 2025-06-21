<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Historical_report_c extends MY_Controller
    {
        public function __construct()
        {
            parent:: __construct();
        }

        public function index()
        {

            $api ='Area_Dashboard/WellList_forDashboard';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
            .'&assets_id='.htmlspecialchars((string)$this->session->userdata('assets_id'),ENT_QUOTES, 'UTF-8')
            .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id'),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['well_list'] = $result['data'];
            
            $d['v'] = "histrorical_report_view";
            $this->load->view('templates',$d); 
        }

        public function  get_mis_report_histrorical()
        {
            $api = 'Historical_Data/Historial_data_Mis_Report';
            $data = 'well_id='.htmlspecialchars((string)$this->input->post('well_id'),ENT_QUOTES, 'UTF-8')
                    .'&from_date='.htmlspecialchars((string)$this->input->post('from_date'),ENT_QUOTES, 'UTF-8')
                    .'&to_date='.htmlspecialchars((string)$this->input->post('to_date'),ENT_QUOTES, 'UTF-8')
                    .'&sort_by='.htmlspecialchars((string)$this->input->post('sort_by'),ENT_QUOTES, 'UTF-8')
                    .'&company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CallAPI($api,$data,$method);
            echo json_encode($result);
        }

        public function  get_graph_histrorical()
        {
            $api = 'Historical_Data/Historical_All_Type_Graph';
            $data = 'well_id='.htmlspecialchars((string)$this->input->post('well_id',true),ENT_QUOTES, 'UTF-8')
                    .'&from_date='.htmlspecialchars((string)$this->input->post('from_date',true),ENT_QUOTES, 'UTF-8')
                    .'&to_date='.htmlspecialchars((string)$this->input->post('to_date',true),ENT_QUOTES, 'UTF-8')
                    .'&graph_type='.htmlspecialchars((string)$this->input->post('graph_type',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CallAPI($api,$data,$method);
            echo json_encode($result);
        }

    

    public function get_Average_data_value()
        {
            $api ='Historical_Data/Historial_data_Average';
            $data = 'well_id='.htmlspecialchars((string)$this->input->post('well_id',true),ENT_QUOTES, 'UTF-8')
                   .'&from_date='.htmlspecialchars((string)$this->input->post('from_date',true),ENT_QUOTES, 'UTF-8')
                   .'&to_date='.htmlspecialchars((string)$this->input->post('to_date',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }


}

?>
