<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    date_default_timezone_set('Asia/Kolkata');

    class Threshold_setup_selfflow_c extends MY_Controller
    {
        public function __construct()
        {
            parent::__construct();
        }

        public function index()
        {
             $api = 'Area_Dashboard/SiteList_forDashboard';
            $data = 'company_id=' . htmlspecialchars((string)$this->session->userdata('company_id'), ENT_QUOTES, 'UTF-8')
                  . '&assets_id=' . htmlspecialchars((string)$this->input->post('assets_id', true), ENT_QUOTES, 'UTF-8')
                  . '&user_id=' . htmlspecialchars((string)$this->session->userdata('user_id'), ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api, $data, $method);
            $d['site_list'] = $result['data'];
            // echo '<pre>';

            // print_r($d['site_list']);die;

            
            $d['v'] = "thresold_setup_selfflow";
            $this->load->view('templates', $d); 
        }
         
public function get_well_list()
{
     $api = 'Selfflow_area_dashboard/WellList_forDashboard';
            $data = 'company_id=' . htmlspecialchars((string)$this->session->userdata('company_id'), ENT_QUOTES, 'UTF-8')
                  . '&user_id=' . htmlspecialchars((string)$this->session->userdata('user_id'), ENT_QUOTES, 'UTF-8')
                  . '&site_id='.htmlspecialchars((string)$this->input->post('site_id'),ENT_QUOTES,'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api, $data, $method);
            echo json_encode($result);
}


        public function add_threshold_setup()
        {   
        
                $api = 'Device_Threshold_Details/Save_ThresholdData_self_flow';
                $data = 'threshold_type=' .$this->input->post('threshold_type',true)
                         .'&well_id='.$this->input->post('well_id',true)
                          .'&site_id=' . $this->input->post('site_id', true)
                         .'&well_ids='.json_encode($this->input->post('well_ids',true))
                         .'&chp_uppar='.$this->input->post('chp_uppar',true)
                         .'&chp_lower='.$this->input->post('chp_lower',true)
                         .'&thp_lower='.$this->input->post('thp_lower',true)
                         .'&thp_uppar='.$this->input->post('thp_uppar',true)
                         .'&tht_uppar='.$this->input->post('tht_uppar',true)
                         .'&tht_lower='.$this->input->post('tht_lower',true)
                         .'&abp_uppar='.$this->input->post('abp_uppar',true)
                         .'&abp_lower='.$this->input->post('abp_lower',true)
                         .'&c_by='.$this->session->userdata('id',true);
                $method = 'POST';
                $result = $this->CallAPI($api,$data,$method);
               // print_r($data);
                //print_r($result);die;
                if($result['response_code'] == 200)
                {
                    $this->session->set_flashdata('success', $result['msg']);
                    redirect('Threshold_setup_selfflow_c');
                }
                else
                {
                    $this->session->set_flashdata('error', $result['msg']);
                    redirect('Threshold_setup_selfflow_c');
                } 
        }

     public function get_Device_mis_report()
        {
            $api ='Device_Threshold_Details/threshold_setup_details_report';
            $method = 'POST';
            $data = 'well_id='.htmlspecialchars((string)$this->input->post('well_id',true),ENT_QUOTES,'UTF-8')
            .'&from_date='.htmlspecialchars((string)$this->input->post('from_date',true),ENT_QUOTES,'UTF-8')
            .'&to_date='.htmlspecialchars((string)$this->input->post('to_date',true),ENT_QUOTES,'UTF-8');
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }
         public function thresold_report()
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

            $d['v'] = "threshold_setup_report";
            $this->load->view('templates', $d); 
        }

    }
?> 