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
            $api = 'Area_Dashboard/AreaList_forDashboard';
            $data = 'company_id=' . htmlspecialchars((string)$this->session->userdata('company_id'), ENT_QUOTES, 'UTF-8')
                  . '&assets_id=' . htmlspecialchars((string)$this->input->post('assets_id', true), ENT_QUOTES, 'UTF-8')
                  . '&user_id=' . htmlspecialchars((string)$this->session->userdata('user_id'), ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CALLAPI($api, $data, $method);
            $d['area_list'] = $result['data'];


            $d['v'] = "thresold_setup_selfflow";
            $this->load->view('templates', $d); 
        }

        public function get_tag_list()
        {
            $api = 'Master/get_wellInstalledTag_List';
            $data = 'company_id=' .htmlspecialchars($this->session->userdata('company_id'))
                .'&well_id=' .htmlspecialchars($this->input->post('well_id',true));
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);

        }
        public function getsite_list()
        {
            $api = 'Area_Dashboard/SiteList_forDashboard';
            $data = 'company_id=' . htmlspecialchars($this->session->userdata('company_id'))
                . '&area_id=' . htmlspecialchars($this->input->post('area_id'));
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }


        public function getWell_forinstallation_list()
        {
            $api = 'Selfflow_area_dashboard/WellList_forDashboard';
            $data = 'company_id=' . htmlspecialchars($this->session->userdata('company_id'))
                . '&area_id=' . htmlspecialchars($this->input->post('area_id',true))
                . '&site_id=' . htmlspecialchars($this->input->post('site_id',true));
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }
        
        public function add_threshold_setup()
        {
            $api ='Device_Threshold_Details/setup_well_thresholdData';
            $data = 'site_id='.$this->input->post('site_id',true)
                     .'&area_id='.$this->input->post('area_id',true)
                     .'&well_id='.$this->input->post('well_id',true)
                     .'&threshold_type='.$this->input->post('threshold_type',true)
                     .'&threshold_data='.($this->input->post('threshold_data',true))
                     .'&well_data='.$this->input->post('well_data',true)
                     .'&c_by='.$this->session->userdata('id');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }

        public function get_well_last_details()
        {
            $api = 'Device_Threshold_Details/Last_threshold_dataList';
            $data = 'well_id='.$this->input->post('well_id',true)
                     .'&node_type='.$this->input->post('node_type',true);
            $method = 'POST';
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

            $api = 'Device_configration_setup/device_List';
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'));
            $method ='POST';
            $result = $this->CallAPI($api,$data,$method);
            $d['device_list'] = $result['data'];


            $d['v'] = "threshold_setup_report";
            $this->load->view('templates', $d); 


        }

        public function get_Threshold_report()
        {
            $well_ids = $this->input->post('well_id'); 
            $api = 'Device_Threshold_Details/well_threshold_setup_report';
            $data = 'area_id='.$this->input->post('area_id',true)
                    .'&site_id='.$this->input->post('site_id',true)
                    .'&well_id='.json_encode($well_ids)
                    .'&imei_no='.$this->input->post('imei_no',true)
                    .'&from_date='.$this->input->post('from_date',true)
                    .'&to_date='.$this->input->post('to_date',true);
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }
    
    }
?>    

   