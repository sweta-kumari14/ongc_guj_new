<?php
require APPPATH.'libraries/REST_Controller.php';
class ONGC_Member_master extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('ONGCMember_model');
	}

	public function Save_UserData_post()
	{
        $user_full_name = $this->input->post('user_full_name',true);
        $userId = $this->input->post('userId',true);
	    $email_id = $this->input->post('email_id',true);
	    $contact_no = $this->input->post('contact_no',true);
	    $emp_id = $this->input->post('emp_id',true);
	    $role_type = $this->input->post('role_type',true);
	    $address = $this->input->post('address',true);
	    $password = $this->input->post('password',true);
	    $city = $this->input->post('city',true);
	    $web_functionality = $this->input->post('web_functionality',true);
	    $mobile_functionality = $this->input->post('mobile_functionality',true);

        if($this->input->post('company_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Comp Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('user_full_name',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Name required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[a-zA-Z ]*$/",$user_full_name))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Name should be alphabet!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('email_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Email required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email_id))
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Invalid Email Id required !','response_code' => REST_Controller::HTTP_BAD_REQUEST]);
        }elseif($this->input->post('contact_no',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Mob required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[0-9]{10}$/",$contact_no))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Mob should be ten digit !!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('emp_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Employee Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[a-zA-Z0-9-.]*$/",$emp_id))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Employee Id not valid !!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('role_type',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Role required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[1-5]{1}$/",$role_type))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Role should be 1,2 and 3 allowed !!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[0-1]*$/",$web_functionality))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'W functionality 0 and 1 allowed!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[0-1]*$/",$mobile_functionality))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'M functionality 0 and 1 allowed!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('password',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Password required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[a-zA-Z0-9@\W]{8,10}$/", $password))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Password should be 8 to 10 alphabet,integer and special characters allowed!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);

	    }elseif($this->input->post('c_by',true) == '')
	 	{
			$this->response(['status'=>false,'data'=>[],'msg'=>'c kon required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}else{
			try 
			{	
				
				$verify_email = $this->ONGCMember_model->verifyEmail_Exist($this->input->post('email_id',true));
				if($verify_email == 0)
				{
					// $verify_mob = $this->ONGCMember_model->verifyMobile_Exist($this->input->post('contact_no',true));
					// if($verify_mob == 0)
					// {
						$verify_emp = $this->ONGCMember_model->verifyEmp_Id_Exist($this->input->post('emp_id',true));
						if($verify_emp == 0)
						{
							$verify_UserId = $this->ONGCMember_model->verifyUserId($this->input->post('userId',true));

							if($verify_UserId == 0)
							{
								if($this->input->post('city',true) != '')
								{
									if(!preg_match("/^[a-zA-Z ]*$/",$city))
									{
										$this->response(['status'=>false,'data'=>[],'msg'=>'City should be alphabet!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
									}
								}

								if($this->input->post('address',true) != '')
								{
									if(!preg_match("/^[a-zA-Z0-9-.,\/ ]*$/",$address))
									{
										$this->response(['status'=>false,'data'=>[],'msg'=>'Address not valid !!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
									}
								}
								$id = $this->ONGCMember_model->getUserID();
								$data = [];
								$data['id'] = $id[0]['UUID()'];
								$data['company_id'] = $this->input->post('company_id',true);
								$data['userId'] = $this->input->post('userId',true);
								$data['user_full_name'] = $this->input->post('user_full_name',true);
								$data['email_id'] = $this->input->post('email_id',true);
								$data['contact_no'] = $this->input->post('contact_no',true);
								$data['emp_id'] = $this->input->post('emp_id',true);
								$data['address'] = $this->input->post('address',true);
								$data['country_code'] = $this->input->post('country_code',true);
								$data['state_code'] = $this->input->post('state_code',true);
								$data['city'] = $this->input->post('city',true);
								$data['role_type'] = $this->input->post('role_type',true);
								$data['web_functionality'] = $this->input->post('web_functionality',true);
		                        $data['mobile_functionality'] = $this->input->post('mobile_functionality',true);
								$data['c_by'] = $this->input->post('c_by',true);
								$data['c_date'] = date('Y-m-d H:i:s');
								$data['status'] = 1;
								$this->ONGCMember_model->Add_UserData($data);	

								// $chars = "0123456789bcdfghjkmnpqrstvwxyzBCDFGHJKLMNPQRSTVWXYZ";
	    						// $pass = substr(str_shuffle($chars),0,8);
	    						$A_id = $this->ONGCMember_model->getAuthID();

								$onboarding['id'] = $A_id[0]['UUID()'];
								$onboarding['company_id'] = $this->input->post('company_id',true);
								$onboarding['user_member_id'] = $data['id'];
								$onboarding['unique_userId'] = $data['userId'];	
								$onboarding['email_id'] = $this->input->post('email_id',true);
								$onboarding['mobile_no'] = $this->input->post('contact_no',true);
								$onboarding['password'] = $this->input->post('password',true);
								$onboarding['user_type'] = 3;
								$onboarding['c_by'] = $this->input->post('c_by',true);
								$onboarding['c_date'] = date('Y-m-d H:i:s');
								$onboarding['status'] = 1;
								$this->ONGCMember_model->SaveOnboardindUser($onboarding);
							
								$this->response(['status'=>true,'data'=>[],'msg'=>'successfully saved!!','response_code'=>REST_Controller::HTTP_OK]);
							}else{
								$this->response(['status'=>false,'data'=>[],'msg'=>'User Id Already Exist!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
							}
						}else{
							$this->response(['status'=>false,'data'=>[],'msg'=>'Employee Id Already Exist!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
				
						}
						
					// }else{
					// 	$this->response(['status'=>false,'data'=>[],'msg'=>'Mob Already Exist!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
				
					// }
				}else{
					$this->response(['status'=>false,'data'=>[],'msg'=>'Email Already Exist!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
				
				}
        	
			}catch (Exception $e){
				$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
				}
		}
    }


   	public function UpdateUserData_post()
	{
        $user_full_name = $this->input->post('user_full_name',true);
	    $email_id = $this->input->post('email_id',true);
	    $contact_no = $this->input->post('contact_no',true);
	    $city = $this->input->post('city',true);
	    $address = $this->input->post('address',true);
	    $role_type = $this->input->post('role_type',true);
	    $web_functionality = $this->input->post('web_functionality',true);
	    $mobile_functionality = $this->input->post('mobile_functionality',true);

        if($this->input->post('id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('company_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'C ID required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('user_full_name',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Name required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[a-zA-Z ]*$/",$user_full_name))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Name should be alphabet!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('email_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Email required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email_id))
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Invalid Email Id required !','response_code' => REST_Controller::HTTP_BAD_REQUEST]);
        }elseif($this->input->post('role_type',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Role required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[1-5]{1}$/",$role_type))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Role should be 1,2 and 3 allowed !!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[0-1]*$/",$web_functionality))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'W functionality 0 and 1 allowed!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[0-1]*$/",$mobile_functionality))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'M functionality 0 and 1 allowed!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('d_by',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'d kon required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}else{
			try 
			{	
				$verify_email = $this->ONGCMember_model->verifyEmailExist_OrNot($this->input->post('email_id',true),$this->input->post('id',true));
				if($verify_email == 0)
				{
					// $verify_mob = $this->ONGCMember_model->verifyMobileExist_OrNot($this->input->post('contact_no',true),$this->input->post('id',true));
					// if($verify_mob == 0)
					// {
						$verify_emp = $this->ONGCMember_model->verifyEmpExist_OrNot($this->input->post('emp_id',true),$this->input->post('id',true));
						if($verify_emp == 0)
						{
							if($this->input->post('contact_no',true) != '')
							{
								if(!preg_match("/^[0-9]{10}$/",$contact_no))
								{
									$this->response(['status'=>false,'data'=>[],'msg'=>'Mob should be ten digit allowed!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
								}
							}
							if($this->input->post('city',true) != '')
							{
								if(!preg_match("/^[a-zA-Z ]*$/",$city))
								{
									$this->response(['status'=>false,'data'=>[],'msg'=>'City should be alphabet!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
								}
							}

							if($this->input->post('address',true) != '')
							{
								if(!preg_match("/^[a-zA-Z0-9-.,\/ ]*$/",$address))
								{
									$this->response(['status'=>false,'data'=>[],'msg'=>'Address not valid !!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
								}
							}
							
							$data = [];
							$data['user_full_name'] = $this->input->post('user_full_name',true);
							$data['email_id'] = $this->input->post('email_id',true);
							$data['contact_no'] = $this->input->post('contact_no',true);
							$data['emp_id'] = $this->input->post('emp_id',true);
							$data['address'] = $this->input->post('address',true);
							$data['country_code'] = $this->input->post('country_code',true);
							$data['state_code'] = $this->input->post('state_code',true);
							$data['city'] = $this->input->post('city',true);
							$data['role_type'] = $this->input->post('role_type',true);
							$data['web_functionality'] = $this->input->post('web_functionality',true);
							$data['mobile_functionality'] = $this->input->post('mobile_functionality',true);
							$data['d_by'] = $this->input->post('d_by',true);
							$data['d_date'] = date('Y-m-d H:i:s');
							$data['status'] = 1;
							$this->ONGCMember_model->Update_UserData($data,['id'=>$this->input->post('id',true)]);

							$this->ONGCMember_model->UpdateOnboardindUser(['company_id'=>$this->input->post('company_id',true),'email_id'=>$this->input->post('email_id',true),'mobile_no'=>$this->input->post('contact_no',true),'d_by'=>$data['d_by'],'d_date'=>date('Y-m-d H:i:s')],['user_member_id'=>$this->input->post('id',true),'user_type'=>3]);
						
							$this->response(['status'=>true,'data'=>[],'msg'=>'successfully updated!!','response_code'=>REST_Controller::HTTP_OK]);
						}else{
							$this->response(['status'=>false,'data'=>[],'msg'=>'Employee Already Exist!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
						}
						
					// }else{
					// 	$this->response(['status'=>false,'data'=>[],'msg'=>'Mob Already Exist!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
				
					// }
				}else{
					$this->response(['status'=>false,'data'=>[],'msg'=>'Email Already Exist!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
				
				}
        	
			}catch (Exception $e){
				$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
				}
		}
    }


    public function MemberList_post()
	{
		try {
			$id = $this->input->post('id',true)!=""?$this->input->post('id',true):"";
			$company_id = $this->input->post('company_id',true)!=""?$this->input->post('company_id',true):"";

			$result = $this->ONGCMember_model->Member_List($id,$company_id);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	  
	}

	public function delete_User_Data_post()
	{	    
        if($this->input->post('id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'ID required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('d_by',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'d kon required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}else{
			try 
			{	
				$data = [];
				$data['d_by'] = $this->input->post('d_by',true);
				$data['d_date'] = date('Y-m-d H:i:s');
				$data['status'] = 0;
				$this->ONGCMember_model->Delete_UserData($data,['id'=>$this->input->post('id',true)]);
				$this->ONGCMember_model->DeleteOnboardindUser($data,['user_member_id'=>$this->input->post('id',true)]);
				$this->response(['status'=>true,'data'=>[],'msg'=>'successfully delete!!','response_code'=>REST_Controller::HTTP_OK]);
					
				
			}catch (Exception $e){
				$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
				}
		}
    }

    public function Active_inactive_post()
    {
       	$active_status = $this->input->post('active_status',true);

        if($this->input->post('id',true)=='')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Id required !','response_code' => REST_Controller::HTTP_BAD_REQUEST]);
        }elseif($this->input->post('active_status',true)=='')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Active Inactive Status required !','response_code' => REST_Controller::HTTP_BAD_REQUEST]);
        }elseif(!preg_match("/^[0-1]{1}$/",$active_status))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Active Inactive Status 0 and 1 allowed!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('d_by',true)=='')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'d kon required !','response_code' => REST_Controller::HTTP_BAD_REQUEST]);
        }else
        {

            try{
                $dataArray = [];
                $dataArray['d_by'] = $this->input->post('d_by',true);
                $dataArray['active_status'] = $this->input->post('active_status',true);
                $dataArray['d_date'] = date('Y-m-d H:i:s');
                $dataArray['status'] = 1;
                $this->ONGCMember_model->Update_UserData($dataArray,['id'=>$this->input->post('id',true)]);
                $this->response(['status'=>true,'data'=>[],'msg'=>'Active Status Updated!!','response_code' => REST_Controller::HTTP_OK]);
                
            }catch(Exception $e)
            {
                $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong !','response_code' => REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
            }

        }        
        
    }


}
?>