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

    

    public function getWell_forinstallation_list()
    {
        $api = 'Master/get_well_list_for_installtion';
        $data = 'company_id=' .htmlspecialchars($this->session->userdata('company_id'))
            . '&assets_id=' .htmlspecialchars($this->input->post('assets_id'))
            . '&area_id=' . htmlspecialchars($this->input->post('area_id'))
            . '&site_id=' . htmlspecialchars($this->input->post('site_id'))
            . '&well_type=' . '2';
        $method = 'POST';
        $result = $this->CallAPI($api, $data, $method);
        echo json_encode($result);
    }

    public function getItem_list()
    {
        $api = 'Master/Not_installedTag_List';
        $data = 'company_id='.$this->session->userdata('company_id',true);
        $method = 'POST';
        $result = $this->CallAPI($api, $data, $method);
        echo json_encode($result);
    }

    


    public function Device_install()
    {
        $user_id = $this->session->userdata('user_id');
       
        $wells_data = [];
        if (!empty($_POST['wells'])) {

            foreach ($_POST['wells'] as $i => $w) {
                $image = '';
                if (isset($_FILES['wells']['name'][$i]['image']) && $_FILES['wells']['size'][$i]['image'] > 0) {

                    $tmpPath = $_FILES['wells']['tmp_name'][$i]['image'];
                    $image = base64_encode(file_get_contents($tmpPath));
                }

                // Components mapping
                $components = [];
                if (!empty($w['component_id']) && !empty($w['tag_number'])) {
                    foreach ($w['component_id'] as $idx => $cid) {
                        $components[] = [
                            "component_id" => $cid,
                            "tag_number"   => $w["tag_number"][$idx] ?? ""
                        ];
                    }
                }

                $wells_data[] = [
                    "well_id"       => $w["well_id"],
                    "well_type_id"  => $w["well_type"], 
                    "image"         => $image,
                    "components"    => $components
                ];
            }
        }

       
        $tag_data_json = json_encode($wells_data); 

         

        $api = 'Device_selfflow_well_installation/Save_wellDevice_Installation_Data';
        $data = 'device_name=' .$this->input->post('device_name_hdn', true).
            '&imei_no=' .$this->input->post('imei_no_hdn', true).
            '&sim_no=' .$this->input->post('sim_no', true).
            '&sim_provider=' .$this->input->post('sim_provider', true).
            '&network_type=' .$this->input->post('network_type', true).
            '&company_id=' .$this->session->userdata('company_id').
            '&installed_by=' .$this->session->userdata('user_id').
            '&wells=' .$tag_data_json.
            '&latitude=' .$this->input->post('lat_hdn', true).
            '&longitude=' .$this->input->post('long_hdn', true).
            '&c_by='.$user_id;
        $method = 'POST';
        $result = $this->CallAPI($api, $data, $method);
        // echo'<pre>';
        // print_r($data);
        // print_r($result);die;
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
