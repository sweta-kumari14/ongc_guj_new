<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    date_default_timezone_set('Asia/Kolkata');
    class Overall_list_selfflow_c extends MY_Controller
    {
        public function __construct()
        {
            parent:: __construct();
            
        }
         public function index()
        {
            $d['v'] = "area_overallself_dashboard_view3";
            $this->load->view('templates',$d); 
       }
        public function non_flowing_well_ajax()
        {
            $api ='list_selflow/Non_Flowing_Well';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
            .'&assets_id='.htmlspecialchars((string)$this->input->post('assets_id',true),ENT_QUOTES, 'UTF-8')
            .'&area_id='.htmlspecialchars((string)$this->input->post('area_id',true),ENT_QUOTES, 'UTF-8')
            .'&site_id='.htmlspecialchars((string)$this->input->post('site_id',true),ENT_QUOTES, 'UTF-8')
            .'&well_id='.htmlspecialchars((string)$this->input->post('well_id',true),ENT_QUOTES, 'UTF-8')
            .'&well_type='.htmlspecialchars((string)$this->input->post('well_type',true),ENT_QUOTES, 'UTF-8')
            .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id'),ENT_QUOTES, 'UTF-8')
            .'&user_type='.$this->session->userdata('user_type')
            .'&role_type='.$this->session->userdata('role_type');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }


        public function overall_details_flowing()
        {
            $d['v'] = "area_overallself_dashboard_view2";
            $this->load->view('templates', $d); 
        }

           public function flowing_well_ajax()
        {
            $api ='list_selflow/Dashboard_Flowing_well';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
            .'&assets_id='.htmlspecialchars((string)$this->input->post('assets_id',true),ENT_QUOTES, 'UTF-8')
            .'&area_id='.htmlspecialchars((string)$this->input->post('area_id',true),ENT_QUOTES, 'UTF-8')
            .'&site_id='.htmlspecialchars((string)$this->input->post('site_id',true),ENT_QUOTES, 'UTF-8')
            .'&well_id='.htmlspecialchars((string)$this->input->post('well_id',true),ENT_QUOTES, 'UTF-8')
            .'&well_type='.htmlspecialchars((string)$this->input->post('well_type',true),ENT_QUOTES, 'UTF-8')
            .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id'),ENT_QUOTES, 'UTF-8')
            .'&user_type='.$this->session->userdata('user_type')
            .'&role_type='.$this->session->userdata('role_type');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }



      
        
 public function overall_details_rtms()
        {
            $d['v'] = "area_overallself_dashboard_view4";
            $this->load->view('templates',$d); 
        }
       public function off_unit_ajax()
        {
              $api ='list_selflow/get_FunctionalOr_NonfunctionalRTMS_List';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
            .'&assets_id='.htmlspecialchars((string)$this->input->post('assets_id',true),ENT_QUOTES, 'UTF-8')
            .'&area_id='.htmlspecialchars((string)$this->input->post('area_id',true),ENT_QUOTES, 'UTF-8')
            .'&site_id='.htmlspecialchars((string)$this->input->post('site_id',true),ENT_QUOTES, 'UTF-8')
           .'&well_id='.htmlspecialchars((string)$this->input->post('well_id',true),ENT_QUOTES, 'UTF-8')
           .'&well_type='.htmlspecialchars((string)$this->input->post('well_type',true),ENT_QUOTES, 'UTF-8')
            .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id'),ENT_QUOTES, 'UTF-8')
            .'&user_type='.htmlspecialchars((string)$this->session->userdata('user_type'),ENT_QUOTES, 'UTF-8')
            .'&role_type='.htmlspecialchars((string)$this->session->userdata('role_type'),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }

         public function overall_details_total()
        {
            $d['v'] = "area_overallself_dashboard_view1";
            $this->load->view('templates',$d); 
        }
          public function overall_details_ajax()
        {
            $api ='list_selflow/Dashboard_Well_Details';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES, 'UTF-8')
            .'&assets_id='.htmlspecialchars((string)$this->input->post('assets_id',true),ENT_QUOTES, 'UTF-8')
            .'&area_id='.htmlspecialchars((string)$this->input->post('area_id',true),ENT_QUOTES, 'UTF-8')
            .'&site_id='.htmlspecialchars((string)$this->input->post('site_id',true),ENT_QUOTES, 'UTF-8')
           .'&well_id='.htmlspecialchars((string)$this->input->post('well_id',true),ENT_QUOTES, 'UTF-8')
           .'&well_type='.htmlspecialchars((string)$this->input->post('well_type',true),ENT_QUOTES, 'UTF-8')
            .'&user_id='.htmlspecialchars((string)$this->session->userdata('user_id'),ENT_QUOTES, 'UTF-8')
            .'&user_type='.htmlspecialchars((string)$this->session->userdata('user_type'),ENT_QUOTES, 'UTF-8')
            .'&role_type='.htmlspecialchars((string)$this->session->userdata('role_type'),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }
}
?>