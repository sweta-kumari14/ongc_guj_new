<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    date_default_timezone_set('Asia/Kolkata');
    class Equipment_details_c extends MY_Controller
    {
        public function __construct()
        {
            parent:: __construct();
            
        }

        public function index()
        {
            $api = 'Master/Assets_list';
            $data = 'company_id='.$this->session->userdata('company_id');
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            $d['assets_list'] = $result['data'];

            $api = 'Master/Equipment_list';
            $data = 'company_id='.$this->session->userdata('company_id');
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            $d['equipment_list'] = $result['data'];

            $d['v'] = "equipment_allotment_view";
            $this->load->view('templates',$d); 
        }

        public function get_area_list()
        {
            $api = 'Master/Arealist';
            $data = 'company_id='.$this->session->userdata('company_id').'&assets_id='.$this->input->post('assets_id');
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }

        public function get_site_list()
        {
            $api = 'Master/areaWiseSite_list';
            $data = 'company_id='.$this->session->userdata('company_id').'&assets_id='.$this->input->post('assets_id').'&area_id='.$this->input->post('area_id');
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }

        public function get_well_list()
        {
            $api = 'Master/Well_list';
            $data = 'company_id='.$this->session->userdata('company_id').'&assets_id='.$this->input->post('assets_id').'&area_id='.$this->input->post('area_id').'&site_id='.$this->input->post('site_id');
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }

        public function equipment_allotment()
        {
            $module_name = 'Save Equipment Data';
            $api = 'Master/AccessLog';
            $data = 'id='.$this->session->userdata('id').'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

        	$api ='Equipment_Details/Save_Equipment_Data';
            $data = 'company_id='.$this->session->userdata('company_id').
            '&motor_name='.$this->input->post('motor_name',true).
            '&motor_capacity='.$this->input->post('motor_capacity',true).
            '&surface_unit_make='.$this->input->post('surface_unit_make_name',true).
            '&vfd_make='.$this->input->post('vfd_make',true).
            '&vfd_model='.$this->input->post('vfd_model',true).
            '&vfd_capacity='.$this->input->post('vfd_capacity',true).
            '&power_source='.$this->input->post('power_source',true).
            '&dg_gg_make='.$this->input->post('dg_gg_make',true).
            '&dg_gg_rating='.$this->input->post('dg_gg_rating',true).

            '&motor_sl_no='.$this->input->post('serial_no',true).
            '&assets_id='.$this->input->post('assets_id',true).
            '&area_id='.$this->input->post('area_id',true).
            '&site_id='.$this->input->post('site_id',true).
            '&well_id='.$this->input->post('well_id',true).
            '&eqp_id='.$this->input->post('equipment_id',true).

            '&c_by='.$this->session->userdata('id');
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            if($result['response_code'] == 200)
            {
                $this->session->set_flashdata('success', $result['msg']);
                redirect('Equipment_details_c');
            }
            else
            {
                $this->session->set_flashdata('error', $result['msg']);
                redirect('Equipment_details_c');
            }
        }

        public function get_motor_serial_number()
        {
            $api = 'Equipment_Details/EquipmentList_for_update';
            $data = 'company_id='.$this->session->userdata('company_id').
            '&serial_no='.$this->input->post('serial_no',true).
            '&assets_id='.$this->input->post('assets_id',true).
            '&area_id='.$this->input->post('area_id',true).
            '&site_id='.$this->input->post('site_id',true).
            '&well_id='.$this->input->post('well_id',true).
            '&eqp_id='.$this->input->post('eqp_id',true);
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }
    }
?>

        