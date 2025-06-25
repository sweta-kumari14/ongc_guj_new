<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata');

class Device_installation_selflow_c extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $api = 'Well_type_master/Welllist';
        $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'));
        $method = 'POST';
        $result = $this->CallAPI($api, $data, $method);
        $d['well_type_list'] = $result['data'];

        // print_r($d['well_type_list']);die;

        $api = 'Assets_Master/AssetsList';
        $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'));
        $method = 'POST';
        $result = $this->CallAPI($api, $data, $method);
        $d['assets_list'] = $result['data'];


        $api = 'Master/getinstallation_DeviceList';
        $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'));
        $method = 'POST';
        $result = $this->CallAPI($api, $data, $method);
        $d['device_list'] = $result['data'];

        $d['v'] = "well_installation_view";
        $this->load->view('templates', $d);
    }


    public function get_well_type_details_list()
    {
        $api = 'Well_setup/well_formula_list';
        $data = 'company_id='. htmlspecialchars($this->session->userdata('company_id')) . '&well_type='. htmlspecialchars($this->input->post('well_type'));
        $method = 'POST';
        $result = $this->CallAPI($api, $data, $method);
        echo json_encode($result);
    }

    public function get_area_list()
    {
        $api = 'Master/get_Area_List';
        $data = 'company_id=' . htmlspecialchars($this->session->userdata('company_id'))
            . '&user_id=' . htmlspecialchars($this->session->userdata('user_id'))
            . '&assets_id=' . htmlspecialchars($this->input->post('assets_id'));
        $method = 'POST';
        $result = $this->CallAPI($api, $data, $method);
        echo json_encode($result);
    }

    public function getsite_list()
    {
        $api = 'Master/getSite_List';
        $data = 'company_id=' . htmlspecialchars($this->session->userdata('company_id'))
            . '&user_id=' . htmlspecialchars($this->session->userdata('user_id'))
            . '&assets_id=' . htmlspecialchars($this->input->post('assets_id'))
            . '&area_id=' . htmlspecialchars($this->input->post('area_id'));
        $method = 'POST';
        $result = $this->CallAPI($api, $data, $method);
        echo json_encode($result);
    }


    public function getWell_forinstallation_list()
    {
        $api = 'Master/get_well_list_for_installtion';
        $data = 'company_id=' .htmlspecialchars($this->session->userdata('company_id'))
            . '&assets_id=' .htmlspecialchars($this->input->post('assets_id'))
            . '&area_id=' . htmlspecialchars($this->input->post('area_id'))
            . '&site_id=' . htmlspecialchars($this->input->post('site_id'))
            . '&well_type=' . htmlspecialchars($this->input->post('wellType'));
        $method = 'POST';
        $result = $this->CallAPI($api, $data, $method);
        echo json_encode($result);
    }

    public function getItem_list()
    {
        $api = 'Master/Not_installedTag_List';
        $data = 'company_id='.$this->session->userdata('company_id',true).
                '&component_id='.$this->input->post('component_id',true);
        $method = 'POST';
        $result = $this->CallAPI($api, $data, $method);
        echo json_encode($result);
    }


    public function Device_install()
    {
        $user_id = $this->session->userdata('user_id');
       
        $image = '';
            if(isset($_FILES["image"]) && $_FILES["image"]["size"] != 0) {
               $image = base64_encode(file_get_contents($_FILES["image"]["tmp_name"]));
            }
        $assign_component = [];
        if (isset($_POST['tag_number']) && isset($_POST['component_id'])) {
            foreach ($_POST['tag_number'] as $key => $tag_number) {
                $component_id = $_POST['component_id'][$key] ?? '';
                $assign_component[] = [
                    'component_id' => $component_id,
                    'tag_number' => $tag_number
                ];
            }
        }
        $tag_data_json = json_encode($assign_component); 

        $api = 'Device_selfflow_well_installation/Save_wellDevice_Installation_Data';
        $data = 'well_id=' .$this->input->post('well_id', true) .
            '&assets_id=' .$this->input->post('assets_id', true) .
            '&area_id=' .$this->input->post('area_id', true).
            '&site_id=' .$this->input->post('site_id', true).
            '&device_name=' .$this->input->post('device_name_hdn', true).
            '&imei_no=' .$this->input->post('imei_no_hdn', true).
            '&sim_no=' .$this->input->post('sim_no', true).
            '&sim_provider=' .$this->input->post('sim_provider', true).
            '&network_type=' .$this->input->post('network_type', true).
            '&company_id=' .$this->session->userdata('company_id').
            '&installed_by=' .$this->session->userdata('user_id').
            '&tag_data=' .$tag_data_json.
            '&lat=' .$this->input->post('lat_hdn', true).
            '&long=' .$this->input->post('long_hdn', true).
            '&well_type='.$this->input->post('well_type', true).
            '&image='.$image.
            '&c_by='.$user_id;
        $method = 'POST';
        $result = $this->CallAPI($api, $data, $method);
        echo'<pre>';
        print_r($data);die;
        if ($result['response_code'] == 200) {
            $this->session->set_flashdata('success', $result['msg']);
            redirect('Device_installation_selflow_c');
        } else {
            $this->session->set_flashdata('error', $result['msg']);
            redirect('Device_installation_selflow_c');
        }
    }
}
?>
