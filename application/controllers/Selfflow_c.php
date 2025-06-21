<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    date_default_timezone_set('Asia/Kolkata');

    class Selfflow_c extends MY_Controller
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

            $d['v'] = "Dashboard_new_view";
            $this->load->view('templates', $d); 
        }
      //  public function newdashboard()
        //{
          //  $d['v'] = "Dashboard_new_view";
            //$this->load->view('templates', $d); 

        //}
       // public function newsingledashboard()
        //{
          //  $d['v'] = "singledashboard_new";
            //$this->load->view('templates', $d); 

       // }


        public function SingleWellDashboard()
        {     $api = 'Area_Dashboard/AreaList_forDashboard';
            $data = 'company_id=' . htmlspecialchars((string)$this->session->userdata('company_id'), ENT_QUOTES, 'UTF-8')
                  . '&assets_id=' . htmlspecialchars((string)$this->input->post('assets_id', true), ENT_QUOTES, 'UTF-8')
                  . '&user_id=' . htmlspecialchars((string)$this->session->userdata('user_id'), ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api, $data, $method);
            $d['area_list'] = $result['data'];
            $d['v'] = "singledashboard_new";
            $this->load->view('templates', $d); 
        }
         public function add_well_reason()
        {
            
            $userid = htmlspecialchars($this->session->userdata('id'));

            $api = 'Temporary_off_reason_master/well_status_mark';
            $data = 'reason='.htmlspecialchars($this->input->post('reason',true))
                     .'&well_id='.htmlspecialchars($this->input->post('well_data_id',true))
                     .'&effective_date_time='.htmlspecialchars($this->input->post('effective_date_time',true))
                     .'&flag_status='.htmlspecialchars($this->input->post('flag_status',true))
                     .'&user_id='.htmlspecialchars($this->session->userdata('id')).
                    '&c_by='.$userid;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            if($result['response_code'] == 200)
            {
                $this->session->set_flashdata('success', $result['msg']);
                redirect('Dashboard_c/get_single_well_detail_dashboard/'.$this->input->post('well_data_id'));
            }
            else
            {
                $this->session->set_flashdata('error', $result['msg']);
                redirect('Dashboard_c/get_single_well_detail_dashboard/'.$this->input->post('well_data_id'));
            }
        }
        public function well_card_data()
        {

            $api ='list_selflow/Dashboard_Well_Details';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
            .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id'),ENT_QUOTES, 'UTF-8')
            .'&assets_id='.htmlspecialchars((string)$this->session->userdata('assets_id'),ENT_QUOTES, 'UTF-8')
            .'&area_id='.htmlspecialchars((string)$this->input->post('area_id',true),ENT_QUOTES, 'UTF-8')
            .'&site_id='.htmlspecialchars((string)$this->input->post('site_id',true),ENT_QUOTES, 'UTF-8')
            .'&well_id='.htmlspecialchars((string)$this->input->post('well_id',true),ENT_QUOTES, 'UTF-8')
            .'&well_type='.htmlspecialchars((string)$this->input->post('well_type',true),ENT_QUOTES, 'UTF-8')
            .'&user_type='.htmlspecialchars((string)$this->input->post('user_type',true),ENT_QUOTES, 'UTF-8')
            .'&role_type='.htmlspecialchars((string)$this->input->post('role_type',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }

        public function Well_type()
        {    
            $d['v'] = "well_type";
            $this->load->view('templates', $d); 
        }

        public function add_well_page()
        {
            $d['v'] = "add/add_welltype_view";
            $this->load->view('templates', $d);
        }

        public function Well_list()
        {
            $api = 'Selfflow_area_dashboard/WellList_forDashboard';
            $data = 'company_id=' . htmlspecialchars((string)$this->session->userdata('company_id'), ENT_QUOTES, 'UTF-8')
                  . '&assets_id=' . htmlspecialchars((string)$this->input->post('assets_id', true), ENT_QUOTES, 'UTF-8')
                  . '&area_id=' . htmlspecialchars((string)$this->input->post('area_id', true), ENT_QUOTES, 'UTF-8')
                  . '&user_id=' . htmlspecialchars((string)$this->session->userdata('user_id'), ENT_QUOTES, 'UTF-8')
                  . '&feeder_id=' . htmlspecialchars((string)$this->input->post('feeder_id', true), ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api, $data, $method);
            echo json_encode($result);
        }

        public function feeder_list()
        {
            $api = 'Selfflow_feeder_master/FeederList';
            $data = 'area_id=' . htmlspecialchars((string)$this->input->post('area_id', true));
            $method = 'POST';
            $result = $this->CALLAPI($api, $data, $method);
            echo json_encode($result);
        }

        public function site_list()
        {
            $api = 'Selfflow_area_dashboard/SiteList_forDashboard';
            $data = 'company_id=' . htmlspecialchars((string)$this->session->userdata('company_id'), ENT_QUOTES, 'UTF-8')
                  . '&assets_id=' . htmlspecialchars((string)$this->input->post('assets_id', true), ENT_QUOTES, 'UTF-8')
                  . '&area_id=' . htmlspecialchars((string)$this->input->post('area_id', true), ENT_QUOTES, 'UTF-8')
                  . '&user_id=' . htmlspecialchars((string)$this->session->userdata('user_id'), ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api, $data, $method);
            echo json_encode($result);
        }
         public function get_alert_log()
        {
            $api = 'Web_Single_Selfflow_Dashboard_Data/Well_Single_Dashboard_Details';
            $data = 'well_id='.htmlspecialchars((string)$this->input->post('well_id',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CallAPI($api,$data,$method);
            echo json_encode($result);
        }

        public function get_all_dashboard_data_graph_ajax()
        {
            $api = 'Web_Single_Selfflow_Dashboard_Data/get_Alltype_Single_graphData';
            $data = 'well_id=' . htmlspecialchars((string)$this->input->post('well_id', true), ENT_QUOTES, 'UTF-8')
                  . '&from_date=' . htmlspecialchars((string)$this->input->post('from_date', true), ENT_QUOTES, 'UTF-8')
                  . '&to_date=' . htmlspecialchars((string)$this->input->post('to_date', true), ENT_QUOTES, 'UTF-8')
                  . '&graph_type=' . htmlspecialchars((string)$this->input->post('graph_type', true), ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api, $data, $method);
            echo json_encode($result);
        }
        
         public function get_single_well_details()
        {
            $api = 'Web_Single_Selfflow_Dashboard_Data/Well_Single_Dashboard_Details';
            $data = 'well_id='.htmlspecialchars((string)$this->input->post('well_id',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CallAPI($api,$data,$method);
            echo json_encode($result);
        } 

       public function get_dashboard_count()
         {
            $api = 'Selfflow_area_dashboard/get_Total_InstalledSite';
            $data = 'company_id=' . htmlspecialchars((string)$this->session->userdata('company_id'), ENT_QUOTES, 'UTF-8')
            . '&area_id=' . htmlspecialchars((string)$this->input->post('area_id', true), ENT_QUOTES, 'UTF-8')
            . '&site_id=' . htmlspecialchars((string)$this->input->post('site_id', true), ENT_QUOTES, 'UTF-8')
            . '&well_id=' . htmlspecialchars((string)$this->input->post('well_id', true), ENT_QUOTES, 'UTF-8')
            . '&assets_id=' . htmlspecialchars((string)$this->input->post('assets_id', true), ENT_QUOTES, 'UTF-8')
            . '&feeder_id=' . htmlspecialchars((string)$this->input->post('feeder_id', true), ENT_QUOTES, 'UTF-8'); 
            $method = 'POST';
            $result = $this->CALLAPI($api, $data, $method);
            echo json_encode($result);
}
 public function get_site_location_for_dashboard()
        {
            $api ='Selfflow_area_dashboard/SiteList_for_Map';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
            .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id'),ENT_QUOTES, 'UTF-8')
            .'&assets_id='.htmlspecialchars((string)$this->session->userdata('assets_id'),ENT_QUOTES, 'UTF-8')
            .'&area_id='.htmlspecialchars((string)$this->input->post('area_id',true),ENT_QUOTES, 'UTF-8')
            .'&site_id='.htmlspecialchars((string)$this->input->post('site_id',true),ENT_QUOTES, 'UTF-8')
            .'&well_id='.htmlspecialchars((string)$this->input->post('well_id',true),ENT_QUOTES, 'UTF-8')
            .'&well_type='.htmlspecialchars((string)$this->input->post('well_type',true),ENT_QUOTES, 'UTF-8')
             .'&user_type='.htmlspecialchars((string)$this->input->post('user_type',true),ENT_QUOTES, 'UTF-8').'&role_type='.htmlspecialchars((string)$this->input->post('role_type',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }
       
        public function well_location()
        {
            $d['v'] = "well_google_map_location_view_well";
            $this->load->view('templates',$d); 
        }

        public  function get_site_location_for_new_tab()
        {
            $api ='Area_Dashboard/SiteList_for_Map';
            $data = 'well_id='.htmlspecialchars((string)$this->input->post('well_id',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }
   
        
    }
?>
