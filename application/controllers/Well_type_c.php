<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    class Well_type_c extends MY_Controller
    {
        public function __construct()
        {
            parent:: __construct();
        }
        

        public function index()
        {
            $api = 'Well_type_master/Welllist';
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'));
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            $d['well_type_list'] = $result['data'];

          
           
            $d['v'] = "well_type";
            $this->load->view('templates',$d); 
        }

         public function add_well_type_page()
        {

            $d['v'] = "add/add_welltype_view";
            $this->load->view('templates',$d);
        }

        public function add_well_type()
        {
            $userid = htmlspecialchars($this->session->userdata('id'));

            $api = 'Well_type_master/SaveWell';
            $data = 'well_type_name='.htmlspecialchars($this->input->post('well_type_name',true)).
            '&company_id='.htmlspecialchars($this->session->userdata('company_id')).
            '&c_by='.$userid;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            // echo'<pre>';
            // print_r($data);
            // print_r($result);die;
            if($result['response_code'] == 200)
            {
                $this->session->set_flashdata('success', $result['msg']);
                redirect('Well_type_c');
            }
            else
            {
                $this->session->set_flashdata('error', $result['msg']);
                redirect('Well_type_c');
            }
        }

      

         public function edit_well_type()
        {

           $id = htmlspecialchars($this->uri->segment(3));
            $api = 'Well_type_master/Welllist';
            $data = 'id='.$id;
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['well_type_list'] = $result['data'];


            // print_r($d['well_type_list']);die;

           
            $d['v'] = 'edit/edit_well_type_view';
            $this->load->view('templates',$d);  
       }

        public function update_well_type()
        {

            $userId = htmlspecialchars($this->session->userdata('id'));


            $api = 'Well_type_master/Updatewell';
            $data = 'id='.htmlspecialchars($this->input->post('id',true))
            .'&well_type_name='.htmlspecialchars($this->input->post('well_type_name',true))
            .'&d_by='.$userId;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            // print_r($data);
            // print_r($result);die;
            if($result['response_code'] == 200)
            {
                $this->session->set_flashdata('success', $result['msg']);
                redirect('Well_type_c');
            }
            else
            {
                $this->session->set_flashdata('error', $result['msg']);
                redirect('Well_type_c');
            }
        }

        public function delete_well()
        {
            // print_r($data);
          //  print_r($result);die;
            
            $userId = htmlspecialchars($this->session->userdata('id'));
            $api = 'Well_type_master/Deletewell';
            $data = 'id='.htmlspecialchars($this->input->post('id',true)).'&d_by='.$userId;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }
    }
?>