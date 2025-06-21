<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    date_default_timezone_set('Asia/Kolkata');

    class Well_setup_c extends MY_Controller
    {
        public function __construct()
        {
            parent:: __construct();
        }

        public function index()
        {         
            $api = 'Component_master/Component_List';
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'));
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            $d['component_list'] = $result['data'];

            $api = 'Well_type_master/Welllist';
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'));
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            $d['well_type_list'] = $result['data'];

            $d['v'] = "well_setup_view";
            $this->load->view('templates',$d); 
        }
         public function store_well_formula_data()
        {
            $well_type = $this->input->post('well_type',true);

            $asset_items = [];
            foreach ($_POST['items'] as $key => $company_id) {
                $asset = [
                    'company_id' => $company_id,
                    'quantity_required' => $_POST['qty'][$key] ?? 0,
                ];
                $asset_items[] = $asset;
            }
            $assetItems = json_encode($asset_items);
            $api = 'Well_setup/Item_Allotment_to_well_type';
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id')).'&assign_item='.$assetItems.'&well_type='.$well_type.'&c_by='.$this->session->userdata('id',true);
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
           //echo "<pre>";
          //  print_r($data);
           // exit;

            if($result['response_code'] == 200)
            {
                $this->session->set_flashdata('success', $result['msg']);
                redirect('Well_setup_c');
            }
            else
            {
                $this->session->set_flashdata('error', $result['msg']);
                redirect('Well_setup_c');
            }
        }
        public function cgl_well_setup_list()
        {    
            $api = 'Component_master/Component_List';
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'));
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            $d['component_list'] = $result['data'];


            $api = 'Well_type_master/Welllist';
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'));
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            $d['well_type_list'] = $result['data'];
            $d['v'] = "well_setup_list_view";
            $this->load->view('templates',$d);
        }
        public function well_setup_list()
        {
            $api = 'Component_master/Component_List';
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'));
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            $d['component_list'] = $result['data'];


            $api = 'Well_type_master/Welllist';
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'));
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            $d['well_type_list'] = $result['data'];
            $d['v'] = "well_setup_list_view";
            $this->load->view('templates',$d);
            
            $api = 'Well_setup/well_formula_list';
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id')).'&well_type='.htmlspecialchars($this->input->post('well_type'));
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }
          public function edit_cgl_setup()
        {
            $api = 'Well_setup/well_formula_list';
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id')).'&id='. $this->input->post('id',true);
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }
         public function update_cgl_setup()
        {
            $api = 'Well_setup/Update_Well_formula';
            $data = 'id='. $this->input->post('id',true).'&quantity_required='.$this->input->post('qty',true).'&d_by='.$this->session->userdata('id',true);
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }
    }
?>    