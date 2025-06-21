<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    date_default_timezone_set('Asia/Kolkata');
    class Running_Log_Graph_report_c extends MY_Controller
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

            $api ='Area_Dashboard/SiteList_forDashboard';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
            .'&assets_id='.htmlspecialchars((string)$this->session->userdata('assets_id',true),ENT_QUOTES, 'UTF-8')
            .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id'),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['site_list'] = $result['data'];
            
            // echo "<pre>";
            // print_r($d['site_list']);die;
           
            $d['v'] = "running_log_graph_report_view";
            $this->load->view('templates',$d); 
        }

        public function Well_list()
        {
            $api ='Area_Dashboard/WellList_forDashboard';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
             .'&site_id='.htmlspecialchars((string)$this->input->post('site_id'),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);

            echo json_encode($result);
        }

        public function Well_list_Line()
        {
            $api ='Area_Dashboard/WellList_forDashboard';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
             .'&site_id='.htmlspecialchars((string)$this->input->post('site_id'),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);

            echo json_encode($result);
        }

        public function get_Financial_running_log_graph_data()
        {
            $api ='Daily_Runniny_Report/Financial_year_Running_All_Type_Graph';
            $data = 'site_id='.$this->input->post('site_id')
                    .'&well_id='.$this->input->post('well_id')
                    .'&fin_year='.$this->input->post('fin_year')
                    .'&graph_type='.$this->input->post('graph_type');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }

        public function get_monthly_running_log_graph_data()
        {
            $api ='Daily_Runniny_Report/Monthly_Running_All_Type_Graph';
            $data = 'site_id='.$this->input->post('site_id')
                    .'&well_id='.$this->input->post('well_id')
                    .'&month_id='.$this->input->post('month_id')
                    .'&year='.$this->input->post('year')
                    .'&graph_type='.$this->input->post('graph_type');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }

        public function get_Financial_running_log_Line_graph_data()
        {
            $api ='Daily_Runniny_Report/Financial_year_Running_Line_Graph';
            $data = 'site_id='.$this->input->post('site_id')
                    .'&well_id='.$this->input->post('well_id')
                    .'&fin_year='.$this->input->post('fin_year')
                    .'&graph_type='.$this->input->post('graph_type');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);

            // echo "<pre>";
            // print_r($data);die;

            echo json_encode($result);
        }

        public function get_monthly_running_log_Line_graph_data()
        {
            $api ='Daily_Runniny_Report/Monthly_running_line_graph';
            $data = 'site_id='.$this->input->post('site_id')
                    .'&well_id='.$this->input->post('well_id')
                    .'&month_id='.$this->input->post('month_id')
                    .'&year='.$this->input->post('year')
                    .'&graph_type='.$this->input->post('graph_type');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }
    }
?>
