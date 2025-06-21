<?php
require APPPATH.'libraries/REST_Controller.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once APPPATH . 'third_party/PHPMailer/Exception.php';
require_once APPPATH . 'third_party/PHPMailer/PHPMailer.php';
require_once APPPATH . 'third_party/PHPMailer/SMTP.php'; 
class ForgotPassword extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Forgot_Password_model');
	}

	public function ForgotPassword_post()
    {
       
       $email_id = $this->input->post('email_id',true);

        if($this->input->post('email_id',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Email required!','response_code' => REST_Controller::HTTP_BAD_REQUEST]);
        }elseif(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email_id))
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Invalid Email Id !','response_code' => REST_Controller::HTTP_BAD_REQUEST]);
        }else{
            try {
                       
                $check = $this->Forgot_Password_model->checkEmail_valid($this->input->post('email_id',true));
                // print_r($check);die;
                if(!empty($check))
                {
                	if($check[0]['total'] == 1)
	                {
	                	$otpAttempts = $this->Forgot_Password_model->getOtpAttempts($email_id);
	                	if ($otpAttempts < 3) {

	                		
	                	$num = "0123456789";
	    				$Pin_num = substr(str_shuffle($num),0,6);
	    						
		                	if($check[0]['user_type'] == 2)
		                	{

			                    $id = $this->Forgot_Password_model->getPassID();  
			                    $data = [];
			                    $data['id'] = $id[0]['UUID()'];
			                    $data['user_id'] =  $check[0]['company_id'];
			                    $data['user_type'] = 2;
			                    $data['email_id'] = $this->input->post('email_id',true);
			                    $data['otp'] = $Pin_num;
			                    $data['c_date'] = date('Y-m-d H:i:s');
			                    $data['status'] = 1;
			                    $this->Forgot_Password_model->saveOtp($data);
		                	}
		                	if($check[0]['user_type'] == 3)
		                	{
		                		$id = $this->Forgot_Password_model->getPassID();  
			                    $data = [];
			                    $data['id'] = $id[0]['UUID()'];
			                    $data['user_id'] =  $check[0]['user_member_id'];
			                    $data['user_type'] = 3;
			                    $data['email_id'] = $this->input->post('email_id',true);
			                    $data['otp'] = $Pin_num;
			                    $data['c_date'] = date('Y-m-d H:i:s');
			                    $data['status'] = 1;
			                    $this->Forgot_Password_model->saveOtp($data);
		                	}
	                    
	                       
		                    $content = '';
		                    $mail = new PHPMailer();
		                    $mail->IsSMTP();
		                    $mail->Mailer = "smtp";
		                    $mail->SMTPDebug = 0;
		                    $mail->SMTPAuth = true;
		                    $mail->SMTPSecure = "ssl";
		                    $mail->Port = 465;
		                    $mail->Host = "ssl://smtp.gmail.com";
		                    $mail->Username = "nonreplyongc@gmail.com";
		                    $mail->Password = "fdgxdljgmgcrjcaj";
		                    $mail->IsHTML(true);
		                    $mail->SetFrom("nonreplyongc@gmail.com",'ONGC');
		                    $mail->AddAddress($data['email_id']);
		                
		                    // print_r($mail);die;
		                    $mail->Subject = "Forgot Password.";
		                    $content = '<table style="width:100%;background: #ececef;font-family: system-ui;">';
		                    $content .= '<div style="width:70%; background: white;color:black; margin: 40px auto;padding: 20px;font-size: 13px;margin-bottom:100px;border-radius: 6px;">';
		                    $content .= '<p>Dear Sir/ Madam ,</p>';
		                    $content .= '<p>'.'Your one time otp is :'.' '.$data['otp'].'</p>';                
		                    $content .= '<strong>';
		                    $content .= '<address style="line-height: 12px;font-size: 12px;">';
		                    $content .= '<p><strong>Regards,</strong></p>';
		                    $content .= '<p>Support Team,</p>';
		                    $content .= '<p>ONGC</p>';
		                    $content .= '</address>';
		                    $content .= '</strong>';
		                    $content .= '</div>';
		                    $content .= '</table>';

		                    $mail->MsgHTML($content);
		                    // print_r($mail);die;
		                    $mail->Send();
		                
		                    $this->response(['status'=>true,'data'=>['email'=>$data['email_id']],'msg'=>'OTP send successfully!!','response_code' => REST_Controller::HTTP_OK]);
		                } else {
                        	$this->response(['status' => false, 'data' => [], 'msg' => 'Maximum OTP attempts reached. Try again after 30 minutes.', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
                    	}
	                
	                }else{
	                    $this->response(['status'=>false,'data'=>[],'msg'=>'Not Valid !','response_code' => REST_Controller::HTTP_BAD_REQUEST]);
	                }
                }else{
                	$this->response(['status'=>false,'data'=>[],'msg'=>'User Not Exist!!','response_code' => REST_Controller::HTTP_BAD_REQUEST]);
                }
                                
            }catch (Exception $e)
            {
              $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
            }
        }
    }

    public function validate_otp_post()
    {
    	$email_id = $this->input->post('email_id',true);
    	$otp = $this->input->post('otp');

        if($this->input->post('email_id',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Email required!','response_code' => REST_Controller::HTTP_BAD_REQUEST]);
        }elseif(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email_id))
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Invalid Email Id !','response_code' => REST_Controller::HTTP_BAD_REQUEST]);
        }elseif($this->input->post('otp',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'OTP required!','response_code' => REST_Controller::HTTP_BAD_REQUEST]);
        }elseif(!preg_match("/^[0-9]{6}$/i", $otp))
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'OTP should be six digit !','response_code' => REST_Controller::HTTP_BAD_REQUEST]);
        }else{
        	try {
        		$otp_verify = $this->Forgot_Password_model->getOtp($this->input->post('email_id',true));
        	
        		if(!empty($otp_verify))
        		{
        			if($otp_verify[0]['otp'] == $this->input->post('otp',true))
        			{
        				$password = $this->input->post('password',true);
        				$confirm_password = $this->input->post('confirm_password',true);
        				if($this->input->post('password',true) == '')
	        			{
	        				$this->response(['status'=>false,'data'=>[],'msg'=>'Password required!','response_code' => REST_Controller::HTTP_BAD_REQUEST]);
	        			}elseif(!preg_match("/^[a-zA-Z0-9@\W]{8,10}$/", $password))
				        {
				           	$this->response(['status'=>false,'data'=>[],'msg'=>'Password should be 8 to 10 digit and character allowed !','response_code' => REST_Controller::HTTP_BAD_REQUEST]);
				        }elseif($this->input->post('confirm_password',true) == '')
	        			{
	        				$this->response(['status'=>false,'data'=>[],'msg'=>'Confirm Password required!','response_code' => REST_Controller::HTTP_BAD_REQUEST]);
	        			}elseif(!preg_match("/^[a-zA-Z0-9@\W]{8,10}$/", $confirm_password))
				        {
				           	$this->response(['status'=>false,'data'=>[],'msg'=>'Confirm Password should be 8 to 10   digit and character allowed !','response_code' => REST_Controller::HTTP_BAD_REQUEST]);
				        }else{
				        	if($this->input->post('password',true) == $this->input->post('confirm_password',true))
			        		{
				        		if($otp_verify[0]['user_type'] == 2)
				        		{
				        			$data = [];
					        		$data['password'] = $this->input->post('confirm_password',true);
					        		$data['d_by'] = $otp_verify[0]['user_id'];
					        		$data['d_date'] = date('Y-m-d H:i:s');
					        		$this->Forgot_Password_model->ResetPassword($data,['email_id'=>$this->input->post('email_id',true),'user_type'=>2]);

					        		$this->Forgot_Password_model->UpdateForgot_Status(['status'=>0],['email_id'=>$this->input->post('email_id',true),'user_type'=>2]);
				        		}
				        		if($otp_verify[0]['user_type'] == 3)
				        		{
				        			$data = [];
					        		$data['password'] = $this->input->post('confirm_password',true);
					        		$data['d_by'] = $otp_verify[0]['user_id'];
					        		$data['d_date'] = date('Y-m-d H:i:s');
					        		$this->Forgot_Password_model->ResetPassword($data,['email_id'=>$this->input->post('email_id',true),'user_type'=>3]);

					        		$this->Forgot_Password_model->UpdateForgot_Status(['status'=>0],['email_id'=>$this->input->post('email_id',true),'user_type'=>3]);
				        		}

				        		$this->response(['status'=>true,'data'=>[],'msg'=>'Password Reset Successfully !!','response_code'=>REST_Controller::HTTP_OK]);
	 
				        	}else{
				        		$this->response(['status'=>false,'data'=>[],'msg'=>'Confirm Password not matched!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
				        	}
        				}
			        }else{
			        	$this->response(['status'=>false,'data'=>[],'msg'=>'Not valid!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
			        }
        		}else{
        			$this->response(['status'=>false,'data'=>[],'msg'=>'Not valid!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        		}
        		
        		
        	} catch (Exception $e) {
        		$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'::HTTP_INTERNAL_SERVER_ERROR]);
        	}
        }
    }

    public function verify_otp_post()
    {
    	$email_id = $this->input->post('email_id',true);
    	$otp = $this->input->post('otp');

        if($this->input->post('email_id',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Email required!','response_code' => REST_Controller::HTTP_BAD_REQUEST]);
        }elseif(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email_id))
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Invalid Email Id !','response_code' => REST_Controller::HTTP_BAD_REQUEST]);
        }elseif($this->input->post('otp',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'OTP required!','response_code' => REST_Controller::HTTP_BAD_REQUEST]);
        }elseif(!preg_match("/^[0-9]{6}$/i", $otp))
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'OTP should be six digit !','response_code' => REST_Controller::HTTP_BAD_REQUEST]);
        }else{
        	try {
        		$otp_verify = $this->Forgot_Password_model->getOtp($this->input->post('email_id',true));
        		
        		if(!empty($otp_verify))
        		{
        			$otp_wrong = $this->Forgot_Password_model->get_otp_verify_wrong_attepmt($this->input->post('email_id',true));

        			if($otp_wrong < 3)
                    {


	        			if($otp_verify[0]['otp'] == $this->input->post('otp',true))
	        			{
	        				$this->response(['status'=>true,'data'=>[],'msg'=>'Successfully otp verify','response_code'=>REST_Controller::HTTP_OK]);
				        }else{

				        	    $W_id = $this->Forgot_Password_model->getWOId();
                                $wrongAttempt = [];
                                $wrongAttempt['id'] = $W_id[0]['UUID()'];
                                $wrongAttempt['user_id'] = $otp_verify[0]['user_id'];
                                $wrongAttempt['email_id']  = $email_id;
                                $wrongAttempt['user_type'] = $otp_verify[0]['user_type'];
                                $wrongAttempt['c_date'] = date("Y-m-d H:i:s");
                                $wrongAttempt['c_by'] = $otp_verify[0]['user_id'];
                                $wrongAttempt['status'] = 1;

                            $this->Forgot_Password_model->SaveWrong_OtpData($wrongAttempt);
				        	$this->response(['status'=>false,'data'=>[],'msg'=>' not valid!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
				        }

				    }else{
                    
                       $this->response(['status'=>false,'data'=>[],'msg'=>'Otp Wrong Attempts Maximum Reached. Try Again After 30 Minutes!!','response_code' => REST_Controller::HTTP_BAD_REQUEST]); 
                    } 

        		}else{
        			$this->response(['status'=>false,'data'=>[],'msg'=>'Invalid!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        		}
        		
        		
        	} catch (Exception $e) {
        		$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'::HTTP_INTERNAL_SERVER_ERROR]);
        	}
        }
    }


   
}
?>