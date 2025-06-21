<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata');

class Authentication extends MY_Controller {

 	public function __construct()
 	{
 		parent:: __construct();
 	}

	public function index()
	{
		$this->load->view('auth_page');
	}

   public function first_time_login($email_id)
        {
            $api = 'ForgotPassword/ForgotPassword';
            $data = 'email_id=' .htmlspecialchars((string)$email_id,ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            
            if ($result['response_code'] == 200)
            {
                if (is_array($result['data']) && isset($result['data'])) {
                    $d['email'] = $result['data']['email'];
                    $this->load->view('forgot_password_page_view', $d);
                } else {
                   $this->session->set_flashdata('error', $result['msg']);
                    redirect('Authentication');
                }
               
            }
            else
            {
                $this->session->set_flashdata('error', $result['msg']);
                redirect('Authentication');
            }
        }

	public function login_details()
    {
           // $captcha_img  = $this->input->post('captchimage_lo',true);
           // $recaptch = $this->input->post('recaptcha_login',true);
            $captcha_img  = $this->input->post('hdn_captcha',true);
            $recaptcha = $this->input->post('captchaText',true);


            $api = 'Member_Entry/Entry_Get';
            $data = 'mobile_no='.htmlspecialchars((string)$this->input->post('mobile_no',true),ENT_QUOTES, 'UTF-8')
            .'&auth_password='.htmlspecialchars((string)$this->input->post('password',true),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CallAPI($api,$data,$method);

            // print_r($_SESSION);die;
       
            if($captcha_img == $recaptcha)
            {
           
                if($result['response_code'] == 200)
                {
                   
                    if ($result['data']['user_type']=='1')
                    {

                         $this->generateSesionTocken($_SESSION['__ci_last_regenerate'],$result['data']['admin_id']);


                        $logged_in_ongc = array(
                        'id' => $result['data']['admin_id'],
                        'admin_id' => $result['data']['admin_id'],
                        'mobile_no' => $result['data']['mobile_no'],
                        'login_status' => $result['data']['login_status'],
                        'last_login_date_time' => $result['data']['last_login_date_time'],
                        'user_type' => $result['data']['user_type'],
                        'logged_in' => TRUE
                        );


                       
                        $this->session->set_userdata($logged_in_ongc);
                        redirect('Dashboard_c','refresh');
                    }elseif ($result['data']['user_type']=='2')
                    {
                        $this->generateSesionTocken($_SESSION['__ci_last_regenerate'],$result['data']['id']);


                        $logged_in_ongc = array(
                        'id' => $result['data']['id'],
                        'admin_id' => $result['data']['super_admin_id'],
                        'company_id' => $result['data']['company_id'],
                        'name' => $result['data']['company_name'],
                        'company_name' => $result['data']['company_name'],
                        'email_id' => $result['data']['email_id'],
                        'mobile_no' => $result['data']['mobile_no'],
                        'login_status' => $result['data']['login_status'],
                        'last_login_date_time' => $result['data']['login_date_time'],
                        'user_type' => $result['data']['user_type'],
                        'logged_in' => TRUE
                        );
                        $this->session->set_userdata($logged_in_ongc);
                        redirect('Dashboard_c','refresh');
                    }elseif ($result['data']['user_type']=='3')
                    {
                        if ($result['data']['password'] == '123456') 
                        {

                            $this->first_time_login($result['data']['email_id']);
                           
                        }else{
                            $this->generateSesionTocken($_SESSION['__ci_last_regenerate'],$result['data']['id']);
                            
                            $logged_in_ongc = array(
                            'id' => $result['data']['id'],
                            'company_id' => $result['data']['company_id'],
                            'company_name' => $result['data']['company_name'],
                            'user_id' => $result['data']['user_member_id'],
                            'name' => $result['data']['user_full_name'],
                            'email_id' => $result['data']['email_id'],
                            'role_type' => $result['data']['role_type'],
                            'mobile_no' => $result['data']['contact_no'],
                            'assets_id' => $result['data']['assets_id'],
                            'assets_name' => $result['data']['assets_name'],
                            'area_id' => $result['data']['area_id'],
                            'area_name' => $result['data']['area_name'],
                            'site_id' => $result['data']['site_id'],
                            'site_name' => $result['data']['site_name'],
                            'login_status' => $result['data']['login_status'],
                            'last_login_date_time' => $result['data']['login_date_time'],
                            'user_type' => $result['data']['user_type'],
                            'logged_in' => TRUE
                            );
                            
                            $this->session->set_userdata($logged_in_ongc);
                            redirect('Dashboard_c','refresh');
                        }

                       
                    }else{
                        $this->session->set_flashdata('error', 'Invalid User');
                        redirect('Authentication','refresh');
                    }
                }else{
                    $this->session->set_flashdata('error', $result['msg']);
                    redirect('Authentication','refresh');
                }

             }else{
                    $this->session->set_flashdata('error', 'Not Valid!!');
                    redirect('Authentication','refresh');
            }

                

        }

        public function generateSesionTocken($sessionTocken,$userId)
        {
            $api = 'Member_Entry/Create_Session';
            $data = 'sessionTocken='.$sessionTocken
                     .'&id='.$userId;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

        }

        public function session_details()
        {
            $api = 'Member_Entry/Session_details';
            $data = 'id='.htmlspecialchars((string)$this->session->userdata('id'),ENT_QUOTES, 'UTF-8');
                   
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);

        }

        public function signout()
        {
            $api = 'Member_Entry/Logged_out';
            $data = 'user_id='.htmlspecialchars($this->session->userdata('id'),ENT_QUOTES, 'UTF-8');
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            $this->session->sess_destroy();
            redirect('Authentication', 'refresh');
        }

        

        public function get_otp()
        {

            $captcha_img  = $this->input->post('captchimage',true);
            $recaptch = $this->input->post('recaptcha',true);
            
            $api = 'ForgotPassword/ForgotPassword';
            $email_id = htmlspecialchars($this->input->post('email_id',true));
            $data = 'email_id=' . $email_id;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);

            if($captcha_img == $recaptch)
            {
                if ($result['response_code'] == 200)
                {
                    if (is_array($result['data']) && isset($result['data'])) {
                        $d['email'] = $result['data']['email'];
                        $this->load->view('forgot_password_page_view', $d);
                    } else {
                       $this->session->set_flashdata('error', $result['msg']);
                        redirect('Authentication');
                    }
                }else
                {
                   $this->session->set_flashdata('error', $result['msg']);
                   redirect('Authentication');
                }

            }else{
                    $this->session->set_flashdata('error', 'Not Valid!!');
                    redirect('Authentication','refresh');
            }
            
        }

        

        public function get_again_otp()
        {
            $api = 'ForgotPassword/ForgotPassword';
            $email_id = htmlspecialchars($this->input->post('email_id',true));
            $data = 'email_id=' . $email_id;
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }

        public function verify_otp()
        {
            $api = 'ForgotPassword/verify_otp';
            $data = 'email_id='.htmlspecialchars($this->input->post('email_id',true))
            .'&otp='.htmlspecialchars($this->input->post('otp',true));
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            echo json_encode($result);
        }


        public function change_password_through_otp()
        {
            $api = 'ForgotPassword/validate_otp';
            $data = 'otp='.htmlspecialchars($this->input->post('otp',true))
            .'&password='.htmlspecialchars($this->input->post('password',true))
            .'&confirm_password='.htmlspecialchars($this->input->post('confirm_password',true))
            .'&email_id='.htmlspecialchars($this->input->post('email_id',true));
            $method = 'POST';
            $result = $this->CallAPI($api, $data, $method);
            if($result['response_code'] == 200)
            {
                $this->session->set_flashdata('success', $result['msg']);
               redirect('Authentication');
            }
            else
            {
                $this->session->set_flashdata('error', $result['msg']);
                redirect('Authentication');
            }
            
        }



}
?>