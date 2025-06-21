<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata');

class Change_password_c extends MY_Controller 
{

 	public function __construct()
 	{
 		parent:: __construct();
 	}

 	public function index()
 	{
        $d['v'] = "change_password";
        $this->load->view('templates',$d); 
 	}


    public function change_password()
    {
        $api = 'Member_Entry/changePassword';
        $data = 'user_id='.$this->session->userdata('id').'&old_auth_pass='.$this->input->post('old_password',true).'&new_auth_pass='.$this->input->post('new_password',true);
        $method = 'POST';
        $result = $this->CallAPI($api, $data, $method);
        // echo "<pre>";
        // print_r($result);die;
        if($result['response_code'] == 200)
        {
            $this->session->set_flashdata('success', $result['msg']);
            redirect('Change_password_c');
        }
        else
        {
            $this->session->set_flashdata('error', $result['msg']);
            redirect('Change_password_c');
        }
    }
}
?>