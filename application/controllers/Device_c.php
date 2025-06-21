<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Device_c extends MY_Controller
    {
        public function __construct()
        {
            parent:: __construct();
        }

        public function index()
        {
            $module_name = 'Device Details page';
            $api = 'Master/AccessLog';
            $data = 'id='.htmlspecialchars((string)$this->session->userdata('id'),ENT_QUOTES,'UTF-8').'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);


            $api = 'Device_master/DeviceList';
            $data = 'company_id='.htmlspecialchars((string)$this->session->userdata('company_id',ENT_QUOTES,'UTF-8'));
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            $d['device_list'] = $result['data'];
            // echo '<pre>';
            // print_r($d['device_list']);die;

            $d['v'] = "device_view";
            $this->load->view('templates',$d); 
        }

        public function add_device_page()
        {

            $d['v'] = "add/add_device_master_view";
            $this->load->view('templates',$d);
        }

        public function add_device()
        {
            $userid = htmlspecialchars((string)$this->session->userdata('id'),ENT_QUOTES,'UTF-8');

            $module_name = 'Add Device Details';
            $api = 'Master/AccessLog';
            $data = 'id=' . $userid. '&module_name=' . htmlspecialchars($module_name);
            $method = 'POST';
            $result = $this->CallAPI($api,$data,$method);
            $api = 'Device_master/DeviceAdd';
            $data = 'imei_no=' . htmlspecialchars((string)$this->input->post('imei_no', true),ENT_QUOTES,'UTF-8') .
                    '&admin_id=' . htmlspecialchars((string)$this->session->userdata('admin_id',true),ENT_QUOTES,'UTF-8') .
                    '&serial_no=' . htmlspecialchars((string)$this->input->post('serial_no', true),ENT_QUOTES,'UTF-8') .
                    '&year_of_manufacturer=' . htmlspecialchars((string)$this->input->post('manufacturer_year', true),ENT_QUOTES,'UTF-8') .
                    '&model_name=' . htmlspecialchars((string)$this->input->post('model_name', true),ENT_QUOTES,'UTF-8') .
                    '&manufacturer_month=' . htmlspecialchars((string)$this->input->post('manufacturer_month', true),ENT_QUOTES,'UTF-8') .
                    '&c_by=' .($userid);
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            
            if ($result['response_code'] == 200) {
                $this->session->set_flashdata('success', $result['msg']);
                redirect('Device_c');
            } else {
                $this->session->set_flashdata('error', $result['msg']);
                redirect('Device_c');
            }
        }

        public function edit_device()
        {

            $id = htmlspecialchars((string)$this->uri->segment(3),ENT_QUOTES,'UTF-8');
            $api = 'Device_master/DeviceList';
            $data = 'id='.$id;
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['device_list'] = $result['data'];

           
            $d['v'] = 'edit/edit_device_view';
            $this->load->view('templates',$d);  
        }

        public function update_device()
        {
            $userId = htmlspecialchars((string)$this->session->userdata('id'));

            $module_name = 'Edit Device Details';
            $api = 'Master/AccessLog';
            $data = 'id='.$userId.'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $api = 'Device_master/update_Device';
            $data = 'id='.htmlspecialchars((string)$this->input->post('id',true),ENT_QUOTES,'UTF-8')
            .'&imei_no='.htmlspecialchars((string)$this->input->post('imei_no',true),ENT_QUOTES,'UTF-8')
            .'&serial_no='.htmlspecialchars((string)$this->input->post('serial_no',true),ENT_QUOTES,'UTF-8')
            .'&year_of_manufacturer='.htmlspecialchars((string)$this->input->post('manufacturer_year',true),ENT_QUOTES,'UTF-8')
            .'&model_name='.htmlspecialchars((string)$this->input->post('model_name',true),ENT_QUOTES,'UTF-8')
            .'&manufacturer_month='.htmlspecialchars((string)$this->input->post('manufacturer_month',true),ENT_QUOTES,'UTF-8')
            .'&d_by='.$userId;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            if($result['response_code'] == 200)
            {
                $this->session->set_flashdata('success', $result['msg']);
                redirect('Device_c');
            }
            else
            {
                $this->session->set_flashdata('error', $result['msg']);
                redirect('Device_c');
            }
        }

        public function delete_device()
        {
            $userId = htmlspecialchars((string)$this->session->userdata('id'),ENT_QUOTES,'UTF-8');

            $module_name = 'Remove Device Details';
            $api = 'Master/AccessLog';
            $data = 'id='.$userId.'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $api = 'Device_master/deleteDevice';
            $method = 'POST';
            $data = 'id='.htmlspecialchars((string)$this->input->post('id',true),ENT_QUOTES,'UTF-8')
                   .'&d_by='.$userId;
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }

        public function upload()
        {
            $module_name = 'Import Device';
            $api = 'Master/AccessLog';
            $data = 'id='.$this->session->userdata('id',true)
                 .'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            if(isset($_FILES['file']) && $_FILES['file']!='')
            {   
                $admin_id = $this->session->userdata('admin_id');
                $c_by = $this->session->userdata('id');

                $file = json_encode($_FILES['file'],TRUE);
                $api = 'Device_master/import_Device';
                $data = 'file='.$file.'&admin_id='.$admin_id.'&c_by='.$c_by;
                $method = 'POST'; 
                $result = $this->CallAPI($api, $data, $method);
                // print_r($result);die;
                if($result['response_code'] == 200){
                    $this->session->set_flashdata('success',$result['message']);
                    redirect('Device_c','refresh');
                }
                else{
                    $this->session->set_flashdata('error',$result['message']);
                    redirect('Device_c','refresh');
                }
            }   
        }
    }
?>