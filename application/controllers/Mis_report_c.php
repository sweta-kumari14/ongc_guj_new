<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    date_default_timezone_set('Asia/Kolkata');
    class Mis_report_c extends MY_Controller
    {
        public function __construct()
        {
            parent:: __construct();
        }

        public function index()
        {
            $module_name = 'Visit Mis Report Module';
            $api = 'Master/AccessLog';
            $data = 'id='.htmlspecialchars($this->session->userdata('id')).'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $api = 'Master/Assets_list';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id'),ENT_QUOTES,'UTF-8');
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            $d['assets_list'] = $result['data'];

            $d['v'] = "report/mis_report_view";
            $this->load->view('templates',$d); 
        }

        public function get_mis_report()
        {
            $api = 'Report/Installed_DeviceReport';
            $method = 'POST';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id',true),ENT_QUOTES,'UTF-8')
            .'&from_date='.htmlspecialchars((string)$this->input->post('from_date',true),ENT_QUOTES,'UTF-8')
            .'&to_date='.htmlspecialchars((string)$this->input->post('to_date',true),ENT_QUOTES,'UTF-8')
            .'&assets_id='.htmlspecialchars((string)$this->input->post('assets_id',true),ENT_QUOTES,'UTF-8')
            .'&site_id='.htmlspecialchars((string)$this->input->post('site_id',true),ENT_QUOTES,'UTF-8')
            .'&area_id='.htmlspecialchars((string)$this->input->post('area_id',true),ENT_QUOTES,'UTF-8')
            .'&well_id='.htmlspecialchars((string)$this->input->post('well_id',true),ENT_QUOTES,'UTF-8');
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }

        public function get_area_list()
        {
            $api = 'Master/Arealist';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id',true),ENT_QUOTES,'UTF-8')
            .'&assets_id='.htmlspecialchars((string)$this->input->post('assets_id',true),ENT_QUOTES,'UTF-8');
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }

        public function get_site_list()
        {
            $api = 'Master/areaWiseSite_list';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id',true),ENT_QUOTES,'UTF-8')
            .'&area_id='.htmlspecialchars((string)$this->input->post('area_id',true),ENT_QUOTES,'UTF-8')
            .'&assets_id='.htmlspecialchars((string)$this->input->post('assets_id',true),ENT_QUOTES,'UTF-8');
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }

        public function get_well_list()
        {
            $api = 'Master/Well_list';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id',true),ENT_QUOTES,'UTF-8')
            .'&area_id='.htmlspecialchars((string)$this->input->post('area_id',true),ENT_QUOTES,'UTF-8')
            .'&assets_id='.htmlspecialchars((string)$this->input->post('assets_id',true),ENT_QUOTES,'UTF-8')
            .'&site_id='.htmlspecialchars((string)$this->input->post('site_id',true),ENT_QUOTES,'UTF-8');
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }

        public function mis_detail_page()
        {
            
            $id = htmlspecialchars($this->uri->segment(3));
            $api = 'Report/DeviceInstallation_Mis_Report';
            $data = 'imei_no='.$id;
            $method = 'POST';
            $result = $this->CallAPI($api,$data,$method);
            $d['details_data'] = $result['data'];

            $d['v'] = 'report/mis_detail_page_view';
            $this->load->view('templates',$d);
        }
    }
?>