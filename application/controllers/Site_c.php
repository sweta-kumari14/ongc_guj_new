<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata');
class Site_c extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

    } 


        public function index()
        {
            $module_name = 'Site List';
            $api = 'Master/AccessLog';
            $data = 'id='.htmlspecialchars($this->session->userdata('id')).'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $api ='Well_site_master/Well_SiteList';
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'));
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['site_list'] = $result['data'];
            // echo'<pre>';
            // print_r($d['site_list']);die;

            $d['v'] = "site_view";
            $this->load->view('templates',$d); 
        }

        public function add_site_page()
        {
            $api ='Master/Assets_list';
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'));
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['assets_list'] = $result['data'];
            // echo "<pre>";
            // print_r($result);die;

            $d['v'] = "add/add_site_view";
            $this->load->view('templates',$d);
        }

        public function get_area_list()
        {
            $api ='Master/Arealist';
            $data = 'company_id='.($this->session->userdata('company_id'))
            .'&assets_id='.($this->input->post('assets_id',true));
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            echo json_encode($result);
        }
        
         
        public function add_site()
        {
            
            $user_id = htmlspecialchars($this->session->userdata('id'));

            $module_name = 'Add Site';
            $api = 'Master/AccessLog';
            $data = 'id='.$user_id.'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $api = 'Well_site_master/WellSiteAdd';
            $data = 'well_site_name='.htmlspecialchars($this->input->post('site_name',true)).
            '&assets_id='.htmlspecialchars($this->input->post('assets_id',true)).
            '&area_id='.htmlspecialchars($this->input->post('area_id',true)).
            '&company_id='.htmlspecialchars($this->session->userdata('company_id')).
            '&c_by='.$user_id;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            if($result['response_code'] == 200)
            {
                $this->session->set_flashdata('success', $result['msg']);
                redirect('Site_c');
            }
            else
            {
                $this->session->set_flashdata('error', $result['msg']);
                redirect('Site_c');
            }

        }

        public function edit_site()
        {

            $id = htmlspecialchars($this->uri->segment(3));
            $api = 'Well_site_master/Well_SiteList';
            $data = 'id='.$id;
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['site_list'] = $result['data'];

            // echo "<pre>";
            // print_r($result);die;
            $api ='Master/Assets_list';
            $data = 'company_id='.htmlspecialchars($this->session->userdata('company_id'));
            $method = 'POST';
            $result = $this->CALLAPI($api,$data,$method);
            $d['assets_list'] = $result['data'];

            $d['v'] = 'edit/edit_site_view';
            $this->load->view('templates',$d);  
        }


        public function update_site()
        {
            $userid = htmlspecialchars($this->session->userdata('id'));

            $module_name = 'Edit Site Data';
            $api = 'Master/AccessLog';
            $data = 'id='.$userid.'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $api = 'Well_site_master/UpdateWellSite';
            $data = 'id='.htmlspecialchars($this->input->post('id',true)).
            '&well_site_name='.htmlspecialchars($this->input->post('site_name',true)).
            '&assets_id='.htmlspecialchars($this->input->post('assets_id',true)).
            '&area_id='.htmlspecialchars($this->input->post('area_id',true)).
            '&d_by='.$userid;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            if($result['response_code'] == 200)
            {
                $this->session->set_flashdata('success', $result['msg']);
                redirect('Site_c');
            }
            else
            {
                $this->session->set_flashdata('error', $result['msg']);
                redirect('Site_c');
            }
        }

        public function delete_site()
        {
            $userid = htmlspecialchars($this->session->userdata('id'));

            $module_name = 'Delete Site Data';
            $api = 'Master/AccessLog';
            $data = 'id='.$userid.'&module_name='.$module_name;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $api = 'Well_site_master/deleteSite';
            $method = 'POST';
            $data = 'id='.htmlspecialchars($this->input->post('id',true)).'&d_by='.$userid;
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }
    }
?>

        