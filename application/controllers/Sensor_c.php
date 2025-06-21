<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Sensor_c extends MY_Controller
    {
        public function __construct()
        {
            parent:: __construct();
        }

        public function index()
       {
    $api = 'Sensor_master/List';
    $sensor_no = htmlspecialchars((string) $this->session->userdata('sensor_no'), ENT_QUOTES, 'UTF-8');
    $data = 'sensor_no=' . $sensor_no;
    $method = 'POST';

    $result = $this->CallAPI($api, $data, $method);

    // Validate response
    $d['device_list'] = (is_array($result) && isset($result['data']) && $result['data']) ? $result['data'] : [];

    $d['v'] = "sensor_view";
    $this->load->view('templates', $d);
}

         public function add_sensor_page()
        {
            $api = 'Item_master/Item_List';
            $data = '';
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            $d['items'] = $result['data'];

            $d['v'] = "add/add_sensor_master_view";
            $this->load->view('templates',$d);
        }

         public function add_sensor()
        {
             $userid = htmlspecialchars((string)$this->session->userdata('id'),ENT_QUOTES,'UTF-8');
            $api = 'Sensor_master/SensorAdd';
            $data = 'id='.htmlspecialchars((string)$this->input->post('id',true),ENT_QUOTES,'UTF-8')
            .'&sensor_no='.htmlspecialchars((string)$this->input->post('sensor_no',true),ENT_QUOTES,'UTF-8')
            .'&sensor_name='.htmlspecialchars((string)$this->input->post('sensor_name',true),ENT_QUOTES,'UTF-8')
            .'&item_name='.$this->input->post('item_name',true)
            .'&sensor_allotment_year='.htmlspecialchars((string)$this->input->post('manufacturer_year',true),ENT_QUOTES,'UTF-8')
            .'&sensor_allotment_month='.htmlspecialchars((string)$this->input->post('manufacturer_month',true),ENT_QUOTES,'UTF-8');
           // .'&c_by='.$userId;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
              $result = $this->CallAPI($api, $data, $method);
//echo '<pre>';
//print_r($result);
//echo '</pre>';
//exit;

            
            if ($result['response_code'] == 200) {
                $this->session->set_flashdata('success', $result['msg']);
                redirect('Sensor_c');
            } else {
                $this->session->set_flashdata('error', $result['msg']);
                redirect('Sensor_c');
            }
        }
        public function edit()
        {
            $api = 'Item_master/Item_List';
            $data = '';
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            $d['items'] = $result['data'];


            $id = htmlspecialchars((string)$this->uri->segment(3),ENT_QUOTES,'UTF-8');
            $api = 'Sensor_master/List';
            $data = 'id='.$id;
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['device_list'] = $result['data'];

            $d['v'] = "edit/edit_sensor_view";
            $this->load->view('templates',$d);

        }
            
       public function update_device()
{
            $userId = htmlspecialchars((string)$this->session->userdata('id'));
            $api = 'Sensor_master/update_Device';
            $data ='id='.htmlspecialchars((string)$this->input->post('id',true),ENT_QUOTES,'UTF-8')
            .'&sensor_no='.htmlspecialchars((string)$this->input->post('sensor_no',true),ENT_QUOTES,'UTF-8')
            .'&sensor_name='.htmlspecialchars((string)$this->input->post('sensor_name',true),ENT_QUOTES,'UTF-8')
            .'&item_name='.$this->input->post('item_name',true)
            .'&sensor_allotment_year='.htmlspecialchars((string)$this->input->post('sensor_allotment_year',true),ENT_QUOTES,'UTF-8')
            .'&sensor_allotment_month='.htmlspecialchars((string)$this->input->post('sensor_allotment_month',true),ENT_QUOTES,'UTF-8')
            .'&d_by='.$userId;
            $method = 'POST';
             $result = $this->CALLAPI($api,$data,$method);
           
            if($result['response_code'] == 200)
            {
                $this->session->set_flashdata('success', $result['msg']);
                redirect('Sensor_c');
            }
            else
            {
                $this->session->set_flashdata('error', $result['msg']);
                redirect('Sensor_c');
            }
}

  public function delete_device()
        {
            $userId = htmlspecialchars((string)$this->session->userdata('id'),ENT_QUOTES,'UTF-8');
            $api = 'Sensor_master/deleteDevice';
            $method = 'POST';
            $data = 'id='.htmlspecialchars((string)$this->input->post('id',true),ENT_QUOTES,'UTF-8')
                   .'&d_by='.$userId;
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }


    }
?>