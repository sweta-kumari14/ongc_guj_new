<?php 
require APPPATH . 'libraries/REST_Controller.php';
class Member_Entry extends REST_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->model('MemberEntry_model');
    }

    public function Entry_Get_post()
    {
        $auth_password = $this->input->post('auth_password',true);

        if($this->input->post('mobile_no',true)=='')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'User Id required !','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif($this->input->post('auth_password',true)==''){
            $this->response(['status'=>false,'data'=>[],'msg'=>'Pass required !','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif(!preg_match("/^[a-zA-Z0-9@\W]+$/", $auth_password))
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Pass should be eight digit,alphabet  and special characters allowed!!','response_code' => REST_Controller::HTTP_BAD_REQUEST]);
        }else{
            try {
                
                $verify = $this->MemberEntry_model->verifY_userLevel($this->input->post('mobile_no',true));
                // print_r($verify); die;
                if ((isset($verify[0]['total']) && $verify[0]['total'] > 0)) 
                {
                    $userinfoData = array();
                    if($verify[0]['user_type'] == 1)
                    {
                        $adminInfo = $this->MemberEntry_model->get_AdminData($this->input->post('mobile_no',true));
                        
                       $passwordAttempts = $this->MemberEntry_model->getpasswordAttempts($this->input->post('mobile_no',true));
                        if ($passwordAttempts < 3) 
                        {


                        if($adminInfo[0]['password'] == $this->input->post('auth_password',true))
                        {
                            $userinfoData['admin_id'] = $adminInfo[0]['id'];
                            $userinfoData['super_admin_userid'] = $adminInfo[0]['unique_userId'];
                            $userinfoData['mobile_no'] = $adminInfo[0]['mobile_no'];
                            $userinfoData['login_status'] = $adminInfo[0]['login_status'];
                            $userinfoData['user_type'] = $adminInfo[0]['user_type'];
                            $userinfoData['last_login_date_time'] = $adminInfo[0]['login_date_time'];

                            $data = [];
                            $data['login_status'] = 1;
                            $data['login_date_time'] = date('Y-m-d H:i:s');
                            $data['d_by'] = $userinfoData['admin_id'];
                            $data['d_date'] = date('Y-m-d H:i:s');
                            $this->MemberEntry_model->Last_Entry($data,['id'=> $userinfoData['admin_id'],'user_type'=>1]);

                            $A_id = $this->MemberEntry_model->getAId();
                            $access = [];
                            $access['id'] = $A_id[0]['UUID()'];
                            $access['user_id'] = $userinfoData['admin_id'];
                            $access['module_name'] = 'Admin Login';
                            $access['access_date_time'] = date("Y-m-d H:i:s");
                            $this->MemberEntry_model->SaveAccessData($access);

                            $this->response(['status'=>true,'data'=>$userinfoData,'msg'=>'Auth Success!','response_code' => REST_Controller::HTTP_OK]);
                        }else{

                             $W_id = $this->MemberEntry_model->getWId();
                                $wrongAttempt = [];
                                $wrongAttempt['id'] = $W_id[0]['UUID()'];
                                $wrongAttempt['user_id'] = $adminInfo[0]['id'];
                                $wrongAttempt['unique_user_id']  = $adminInfo[0]['unique_userId'];
                                $wrongAttempt['user_type'] = $adminInfo[0]['user_type'];
                                $wrongAttempt['Password'] = $this->input->post('auth_password',true);
                                $wrongAttempt['c_date'] =  date("Y-m-d H:i:s");
                                $wrongAttempt['c_by'] = $adminInfo[0]['id'];
                                $this->MemberEntry_model->SaveWrongData($wrongAttempt);

                            $this->response(['status'=>false,'data'=>[],'msg'=>'Authentication Failed. Please check your credentials!!','response_code' => REST_Controller::HTTP_BAD_REQUEST]);

                                
                               
                            }
                        }else{
                            $this->response(['status' => false, 'data' => [], 'msg' => 'Wrong Password Attempts Maximum Reached. Try Again After 30 Minutes!!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
                        }
                    
                    }elseif($verify[0]['user_type'] == 2)
                    {
                        $compInfo = $this->MemberEntry_model->getCompanyInfo($this->input->post('mobile_no',true));
                        // print_r($compInfo); die;
                        $passwordAttempts = $this->MemberEntry_model->getpasswordAttempts($this->input->post('mobile_no',true));
                        if ($passwordAttempts < 3) 
                        {
                          if($compInfo[0]['password'] == $this->input->post('auth_password',true))
                         {
                            $userinfoData['id'] = $compInfo[0]['id'];
                            $userinfoData['super_admin_id'] = $compInfo[0]['super_admin_id'];
                            $userinfoData['company_id'] = $compInfo[0]['company_id'];
                            $userinfoData['company_userid'] = $compInfo[0]['unique_userId'];
                            $userinfoData['company_name'] = $compInfo[0]['company_name'];
                            $userinfoData['email_id'] = $compInfo[0]['email_id'];
                            $userinfoData['mobile_no'] = $compInfo[0]['contact_no'];
                            $userinfoData['user_type'] = $compInfo[0]['user_type'];
                            $userinfoData['login_date_time'] = $compInfo[0]['login_date_time'];
                            $userinfoData['login_status'] = $compInfo[0]['login_status'];

                            $data = [];
                            $data['login_status'] = 1;
                            $data['login_date_time'] = date('Y-m-d H:i:s');
                            $data['d_by'] = $userinfoData['company_id'];
                            $data['d_date'] = date('Y-m-d H:i:s');
                            $this->MemberEntry_model->Last_Entry($data,['company_id'=> $userinfoData['company_id'],'user_type'=>2]);

                            $A_id = $this->MemberEntry_model->getAId();
                            $access = [];
                            $access['id'] = $A_id[0]['UUID()'];
                            $access['user_id'] = $userinfoData['company_id'];
                            $access['module_name'] = 'Company Login';
                            $access['access_date_time'] = date("Y-m-d H:i:s");
                            $this->MemberEntry_model->SaveAccessData($access);

                            $this->response(['status'=>true,'data'=>$userinfoData,'msg'=>'Auth Success !','response_code' => REST_Controller::HTTP_OK]);
                            
                        }else{

                                $W_id = $this->MemberEntry_model->getWId();
                                $wrongAttempt = [];
                                $wrongAttempt['id'] = $W_id[0]['UUID()'];
                                $wrongAttempt['user_id'] = $compInfo[0]['company_id'];
                                $wrongAttempt['unique_user_id']  = $compInfo[0]['unique_userId'];
                                $wrongAttempt['user_type'] = $compInfo[0]['user_type'];
                                $wrongAttempt['Password'] = $this->input->post('auth_password',true);
                                $wrongAttempt['c_date'] =  date("Y-m-d H:i:s");
                                $this->MemberEntry_model->SaveWrongData($wrongAttempt);

                            $this->response(['status'=>false,'data'=>[],'msg'=>'Authentication Failed. Please check your credentials!!','response_code' => REST_Controller::HTTP_BAD_REQUEST]);
                        }
                    }else{
                            $this->response(['status' => false, 'data' => [], 'msg' => 'Wrong Password Attempts Maximum Reached. Try Again After 30 Minutes!!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
                        }
                    
                    }elseif($verify[0]['user_type'] == 3)
                    {

                        $userInfo = $this->MemberEntry_model->getinstallationInfo($this->input->post('mobile_no',true));
                     
                        if($userInfo[0]['id']!='')
                        {
                           $passwordAttempts = $this->MemberEntry_model->getpasswordAttempts($this->input->post('mobile_no',true));
                          if ($passwordAttempts < 3) 
                         {  
                            if($userInfo[0]['password'] == $this->input->post('auth_password',true))
                            {
                                if($userInfo[0]['role_type'] == 1 || $userInfo[0]['role_type'] == 4 ||$userInfo[0]['role_type'] == 5)
                                {
                                    if($userInfo[0]['active_status'] == 1 )
                                    {
                                        if($userInfo[0]['web_functionality'] == 1 || $userInfo[0]['mobile_functionality'] == 1)
                                        {
                                           

                                                $userinfoData['id'] = $userInfo[0]['id'];
                                                $userinfoData['company_id'] = $userInfo[0]['company_id'];
                                                $userinfoData['asset_level_userId'] = $userInfo[0]['unique_userId'];
                                                $userinfoData['company_name'] = $userInfo[0]['company_name'];
                                                $userinfoData['user_member_id'] = $userInfo[0]['user_member_id'];
                                                $userinfoData['user_full_name'] = $userInfo[0]['user_full_name'];
                                                $userinfoData['email_id'] = $userInfo[0]['email_id'];
                                                $userinfoData['role_type'] = $userInfo[0]['role_type'];
                                                $userinfoData['emp_id'] = $userInfo[0]['emp_id'];
                                                $userinfoData['contact_no'] = $userInfo[0]['contact_no'];
                                                $userinfoData['assets_id'] = $userInfo[0]['assets_id'];
                                                $userinfoData['assets_name'] = $userInfo[0]['assets_name'];
                                                $userinfoData['area_id'] = $userInfo[0]['area_id'];
                                                $userinfoData['area_name'] = $userInfo[0]['area_name'];
                                                $userinfoData['site_id'] = $userInfo[0]['site_id'];
                                                $userinfoData['site_name'] = $userInfo[0]['well_site_name'];
                                                $userinfoData['user_type'] = $userInfo[0]['user_type'];
                                                $userinfoData['login_date_time'] = $userInfo[0]['login_date_time'];
                                                 $userinfoData['password'] = $userInfo[0]['password'];
                                                $userinfoData['login_status'] = $userInfo[0]['login_status'];

                                                $data = [];
                                                $data['login_status'] = 1;
                                                $data['login_date_time'] = date('Y-m-d H:i:s');
                                                $data['d_by'] = $userinfoData['company_id'];
                                                $data['d_date'] = date('Y-m-d H:i:s');
                                                $this->MemberEntry_model->Last_Entry($data,['user_member_id'=> $userinfoData['user_member_id'],'user_type'=>3]);

                                                $A_id = $this->MemberEntry_model->getAId();
                                                $access = [];
                                                $access['id'] = $A_id[0]['UUID()'];
                                                $access['user_id'] = $userinfoData['user_member_id'];
                                                $access['module_name'] = 'Asset User Login';
                                                $access['access_date_time'] = date("Y-m-d H:i:s");
                                                $this->MemberEntry_model->SaveAccessData($access);

                                                $this->response(['status'=>true,'data'=>$userinfoData,'msg'=>'Auth Success !','response_code' => REST_Controller::HTTP_OK]);
                                           
                                        }else{
                                            $this->response(['status'=>false,'data'=>[],'msg'=>'Not Authorized for Web Functionality!!','response_code' => REST_Controller::HTTP_BAD_REQUEST]);
                                        }
                                    }else{
                                        $this->response(['status'=>false,'data'=>[],'msg'=>'Not Authorized!!','response_code' => REST_Controller::HTTP_BAD_REQUEST]);
                                    }
                                }elseif($userInfo[0]['role_type'] == 2)
                                {
                                    if($userInfo[0]['active_status'] == 1)
                                    {
                                        if($userInfo[0]['web_functionality'] == 1 || $userInfo[0]['mobile_functionality'] == 1)
                                        {
                                           

                                                $userinfoData['id'] = $userInfo[0]['id'];
                                                $userinfoData['company_id'] = $userInfo[0]['company_id'];
                                                $userinfoData['area_level_userId'] = $userInfo[0]['unique_userId'];
                                                $userinfoData['company_name'] = $userInfo[0]['company_name'];
                                                $userinfoData['user_member_id'] = $userInfo[0]['user_member_id'];
                                                $userinfoData['user_full_name'] = $userInfo[0]['user_full_name'];
                                                $userinfoData['email_id'] = $userInfo[0]['email_id'];
                                                $userinfoData['role_type'] = $userInfo[0]['role_type'];
                                                $userinfoData['emp_id'] = $userInfo[0]['emp_id'];
                                                $userinfoData['contact_no'] = $userInfo[0]['contact_no'];
                                                $userinfoData['assets_id'] = $userInfo[0]['assets_id'];
                                                $userinfoData['assets_name'] = $userInfo[0]['assets_name'];
                                                $userinfoData['area_id'] = $userInfo[0]['area_id'];
                                                $userinfoData['area_name'] = $userInfo[0]['area_name'];
                                                $userinfoData['site_id'] = $userInfo[0]['site_id'];
                                                $userinfoData['site_name'] = $userInfo[0]['well_site_name'];
                                                $userinfoData['user_type'] = $userInfo[0]['user_type'];
                                                $userinfoData['login_date_time'] = $userInfo[0]['login_date_time'];
                                                $userinfoData['password'] = $userInfo[0]['password'];
                                                $userinfoData['login_status'] = $userInfo[0]['login_status'];

                                                $data = [];
                                                $data['login_status'] = 1;
                                                $data['login_date_time'] = date('Y-m-d H:i:s');
                                                $data['d_by'] = $userinfoData['company_id'];
                                                $data['d_date'] = date('Y-m-d H:i:s');
                                                $this->MemberEntry_model->Last_Entry($data,['user_member_id'=> $userinfoData['user_member_id'],'user_type'=>3]);

                                                $A_id = $this->MemberEntry_model->getAId();
                                                $access = [];
                                                $access['id'] = $A_id[0]['UUID()'];
                                                $access['user_id'] = $userinfoData['user_member_id'];
                                                $access['module_name'] = 'Area User Login';
                                                $access['access_date_time'] = date("Y-m-d H:i:s");
                                                $this->MemberEntry_model->SaveAccessData($access);

                                                $this->response(['status'=>true,'data'=>$userinfoData,'msg'=>'Auth Success !','response_code' => REST_Controller::HTTP_OK]);
                                            
                                            
                                        }else{
                                            $this->response(['status'=>false,'data'=>[],'msg'=>'Not Authorized for Web Functionality!!','response_code' => REST_Controller::HTTP_BAD_REQUEST]);
                                        }
                                    }else{
                                        $this->response(['status'=>false,'data'=>[],'msg'=>'Not Authorized!!','response_code' => REST_Controller::HTTP_BAD_REQUEST]);
                                    }
                                }elseif($userInfo[0]['role_type'] == 3)
                                {
                                    if($userInfo[0]['active_status'] == 1)
                                    {
                                        if($userInfo[0]['web_functionality'] == 1 || $userInfo[0]['mobile_functionality'] == 1)
                                        {
                                           

                                                $userinfoData['id'] = $userInfo[0]['id'];
                                                $userinfoData['company_id'] = $userInfo[0]['company_id'];
                                                $userinfoData['company_name'] = $userInfo[0]['company_name'];
                                                $userinfoData['user_member_id'] = $userInfo[0]['user_member_id'];
                                                $userinfoData['user_full_name'] = $userInfo[0]['user_full_name'];
                                                $userinfoData['email_id'] = $userInfo[0]['email_id'];
                                                $userinfoData['role_type'] = $userInfo[0]['role_type'];
                                                $userinfoData['emp_id'] = $userInfo[0]['emp_id'];
                                                $userinfoData['contact_no'] = $userInfo[0]['contact_no'];
                                                 $userinfoData['assets_id'] = $userInfo[0]['assets_id'];
                                                $userinfoData['assets_name'] = $userInfo[0]['assets_name'];
                                                $userinfoData['area_id'] = $userInfo[0]['area_id'];
                                                $userinfoData['area_name'] = $userInfo[0]['area_name'];
                                                $userinfoData['site_id'] = $userInfo[0]['site_id'];
                                                $userinfoData['site_name'] = $userInfo[0]['well_site_name'];
                                                $userinfoData['user_type'] = $userInfo[0]['user_type'];
                                                $userinfoData['login_date_time'] = $userInfo[0]['login_date_time'];
                                                $userinfoData['password'] = $userInfo[0]['password'];
                                                
                                                $userinfoData['login_status'] = $userInfo[0]['login_status'];

                                                $data = [];
                                                $data['login_status'] = 1;
                                                $data['login_date_time'] = date('Y-m-d H:i:s');
                                                $data['d_by'] = $userinfoData['company_id'];
                                                $data['d_date'] = date('Y-m-d H:i:s');
                                                $this->MemberEntry_model->Last_Entry($data,['user_member_id'=> $userinfoData['user_member_id'],'user_type'=>3]);

                                                $A_id = $this->MemberEntry_model->getAId();
                                                $access = [];
                                                $access['id'] = $A_id[0]['UUID()'];
                                                $access['user_id'] = $userinfoData['user_member_id'];
                                                $access['module_name'] = 'Installer Login';
                                                $access['access_date_time'] = date("Y-m-d H:i:s");
                                                $this->MemberEntry_model->SaveAccessData($access);

                                                $this->response(['status'=>true,'data'=>$userinfoData,'msg'=>'Auth Success !','response_code' => REST_Controller::HTTP_OK]);
                                            
                                            
                                        }else{
                                            $this->response(['status'=>false,'data'=>[],'msg'=>'Not Authorized for Web Functionality!!','response_code' => REST_Controller::HTTP_BAD_REQUEST]);
                                        }
                                    }else{
                                        $this->response(['status'=>false,'data'=>[],'msg'=>'Not Authorized!!','response_code' => REST_Controller::HTTP_BAD_REQUEST]);
                                    }
                                }else{
                                    $this->response(['status'=>false,'data'=>[],'msg'=>'User Not Assign !','response_code' => REST_Controller::HTTP_BAD_REQUEST]);
                                }
                         
                            }else{

                                $W_id = $this->MemberEntry_model->getWId();
                                $wrongAttempt = [];
                                $wrongAttempt['id'] = $W_id[0]['UUID()'];
                                $wrongAttempt['user_id'] = $userInfo[0]['user_member_id'];
                                $wrongAttempt['unique_user_id']  = $userInfo[0]['unique_userId'];
                                $wrongAttempt['user_type'] = $userInfo[0]['user_type'];
                                $wrongAttempt['Password'] = $this->input->post('auth_password',true);
                                $wrongAttempt['c_date'] =  date("Y-m-d H:i:s");
                                $this->MemberEntry_model->SaveWrongData($wrongAttempt);

                                $this->response(['status'=>false,'data'=>[],'msg'=>'Authentication Failed. Please check your credentials!!','response_code' => REST_Controller::HTTP_BAD_REQUEST]);


                            }

                        }else{
                             $this->response(['status' => false, 'data' => [], 'msg' => 'Wrong Password Attempts Maximum Reached. Try Again After 30 Minutes!!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
                        }
                            
                            
                        }else{
                            $this->response(['status'=>false,'data'=>[],'msg'=>'User Not Assign This Site !','response_code' => REST_Controller::HTTP_BAD_REQUEST]);
                        }
                        
                    }
                       
                }else{
                    $this->response(['status'=>false,'data'=>[],'msg'=>'Invalid Credentials. !','response_code' => REST_Controller::HTTP_BAD_REQUEST]);
                }
                    
            } catch (Exception $e) {
                $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
            }
                
        }
    }


    public function changePassword_post()
    {
        $new_auth_pass = $this->input->post('new_auth_pass',true);

        if($this->input->post('user_id')=='')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>' Id required !','response_code' => REST_Controller::HTTP_BAD_REQUEST]);
        }elseif($this->input->post('old_auth_pass')=='')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'old pass required !','response_code' => REST_Controller::HTTP_BAD_REQUEST]);
        }elseif($this->input->post('new_auth_pass')=='')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'new pass required !','response_code' => REST_Controller::HTTP_BAD_REQUEST]);
        }elseif(!preg_match("/^[a-zA-Z0-9@\W]{8,10}$$/", $new_auth_pass))
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Password should be 8 to 10 alphabet,integer and special characters allowed','response_code' => REST_Controller::HTTP_BAD_REQUEST]);
        }else{
            try{
                $userCred = $this->MemberEntry_model->getPassword($this->input->post('user_id',true));
                // print_r($userCred);die;

                if(empty($userCred))
                {
                    $this->response(['status'=>false,'data'=>[],'msg'=>'User id Or Password Wrong !','response_code' => REST_Controller::HTTP_BAD_REQUEST]);
                }else{

                   
                  $change_Pass_Wrong = $this->MemberEntry_model->get_wrong_attepmt($this->input->post('user_id',true));
                  // print_r($change_Pass_Wrong);die;

                    if($change_Pass_Wrong < 3)
                    {
                        if($userCred[0]['password']==$this->input->post('old_auth_pass',true))
                        {
                        
                            $this->MemberEntry_model->updatePassword(['password'=>$this->input->post('new_auth_pass',true),'d_by'=>$this->input->post('user_id',true),'d_date'=>date('Y-m-d H:i:s')],['id'=>$this->input->post('user_id',true),'status'=>1]); 

                            $A_id = $this->MemberEntry_model->getAId();
                            $access = [];
                            $access['id'] = $A_id[0]['UUID()'];
                            $access['user_id'] = $this->input->post('user_id');
                            $access['module_name'] = 'Access change password module';
                            $access['access_date_time'] = date("Y-m-d H:i:s");
                            $this->MemberEntry_model->SaveAccessData($access);

                        $this->response(['status'=>true,'data'=>[],'msg'=>'Successfully Password Updated!!','response_code' => REST_Controller::HTTP_OK]);
                        
                        }else{

                                $W_id = $this->MemberEntry_model->getWPId();
                                $wrongAttempt = [];
                                $wrongAttempt['id'] = $W_id[0]['UUID()'];
                                $wrongAttempt['user_id'] = $userCred[0]['id'];
                                $wrongAttempt['unique_user_id']  = $userCred[0]['unique_userId'];
                                $wrongAttempt['user_type'] = $userCred[0]['user_type'];
                                $wrongAttempt['c_date'] =  date("Y-m-d H:i:s");
                                $wrongAttempt['c_by'] = $userCred[0]['user_member_id'];
                                $wrongAttempt['status'] = 1;

                            $this->MemberEntry_model->SaveWrong_Data($wrongAttempt);
                            $this->response(['status'=>false,'data'=>[],'msg'=>' Not Valid !','response_code' => REST_Controller::HTTP_BAD_REQUEST]);                        
                        } 

                    }else{
                    
                    $this->response(['status'=>false,'data'=>[],'msg'=>'During Password Change Wrong Attempts Maximum Reached. Try Again After 30 Minutes!!','response_code' => REST_Controller::HTTP_BAD_REQUEST]); 
                  } 
                    
                }
            
            }catch(Exception $e){
                $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong !','response_code' => REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
                }

            }
  
    }

    public function Logged_out_post()
    {
        if($this->input->post('user_id',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }else{
            try {
            $data = [];
            $data['id'] = $this->input->post('user_id',true);
            $data['logout_date_time'] = date('Y-m-d H:i:s');
            $data['login_status'] = 0;
            $this->MemberEntry_model->Last_Entry($data,['id'=>$this->input->post('user_id',true)]);

            $A_id = $this->MemberEntry_model->getAId();
            $access = [];
            $access['id'] = $A_id[0]['UUID()'];
            $access['user_id'] = $this->input->post('user_id');
            $access['module_name'] = 'Company Logout';
            $access['access_date_time'] = date("Y-m-d H:i:s");
            $this->MemberEntry_model->SaveAccessData($access);

            $this->response(['status'=>true,'data'=>[],'msg'=>'Successfully Logged Out!!','response_code' => REST_Controller::HTTP_OK]);
            } catch (Exception $e) {
                $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong !','response_code' => REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
            }
        }
        
    }
    public function Update__UserDevice_token_post()
    {
        if($this->input->post('user_id',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif($this->input->post('device_token',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Token required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }else{
            try {
            $data = [];
            $data['id'] = $this->input->post('user_id',true);
            $data['device_token'] = $this->input->post('device_token',true);
            $data['login_status'] = 1;
            $data['login_date_time'] = date('Y-m-d H:i:s');
            $this->MemberEntry_model->Update_Device_token($data,['id'=>$this->input->post('user_id',true)]);

            $this->response(['status'=>true,'data'=>[],'msg'=>'Successfully Token Updated!!','response_code' => REST_Controller::HTTP_OK]);
            } catch (Exception $e) {
                $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong !','response_code' => REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
            }
        }
        
    }
    public function SaveDevice_tokenData_post()
    {
        if($this->input->post('user_id',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif($this->input->post('device_token',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Token required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }else{
            try {

            $Id =  $this->MemberEntry_model->getDeviceId();
            $dataArray = [];
            $dataArray['id'] = $Id[0]['UUID()'];
            $dataArray['user_id'] = $this->input->post('user_id',true);
            $dataArray['mobile_no'] = $this->input->post('mobile_no',true);
            $dataArray['unique_userId'] = $this->input->post('unique_userId',true);
            $dataArray['device_token'] = $this->input->post('device_token',true);
            $dataArray['generate_datetime'] = date('Y-m-d H:i:s');
            $dataArray['status'] = 1;
            $this->MemberEntry_model->Save_Device_TokenData($dataArray);

            $data['id'] = $this->input->post('user_id',true);
            $data['device_token'] = $this->input->post('device_token',true);
            $data['login_status'] = 1;
            $data['login_date_time'] = date('Y-m-d H:i:s');
            $this->MemberEntry_model->Update_Device_token($data,['id'=>$this->input->post('user_id',true)]);


            $this->response(['status'=>true,'data'=>[],'msg'=>'Successfully Token Save!!','response_code' => REST_Controller::HTTP_OK]);
            } catch (Exception $e) {
                $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong !','response_code' => REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
            }
        }
        
    }

    public function Create_Session_post()
    {
        if ($this->input->post('id', true) == '') {
            $this->response(['status' => false, 'data' => [], 'msg' => ' id required!!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
        }elseif ($this->input->post('sessionTocken', true) == '') {
            $this->response(['status' => false, 'data' => [], 'msg' => 'session token required !', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
        }else{
          try {

               $verify = $this->MemberEntry_model->verify_user($this->input->post('id',true));
               

      
               if(!empty($verify))
               {
                  $exist_session = $this->MemberEntry_model->session_exists_or_not($this->input->post('id',true));


                   if($exist_session == 0)
                   {
                     $data = [];
                     $data['user_id'] = $this->input->post('id',true);
                     $data['sessionTocken'] = $this->input->post('sessionTocken',true);
                     $data['unique_id'] = $verify[0]['unique_userId'];
                     $data['password'] = $verify[0]['password'];
                     $data['c_date'] = date('Y-m-d H:i:s');
                     $data['c_by'] = $this->input->post('id',true);
                     $data['status'] = 1;
                     $this->MemberEntry_model->save_session($data);
                     $this->response(['status'=>true,'data'=>[],'msg'=>'Successfully Token Save!!','response_code' => REST_Controller::HTTP_OK]);

                   }else{
                         $data['sessionTocken'] = $this->input->post('sessionTocken',true);
                         $data['d_date'] = date('Y-m-d H:i:s');
                         $data['d_by'] = $this->input->post('id',true);
                         $data['status'] = 1;
                         $this->MemberEntry_model->update_session($data,['user_id'=>$this->input->post('id',true)]);
                         $this->response(['status'=>true,'data'=>[],'msg'=>'Successfully gh Token Save!!','response_code' => REST_Controller::HTTP_OK]);

                   }
               }else{

                $this->response(['status'=>false,'data'=>[],'msg'=>'invalid!!','response_code' => REST_Controller::HTTP_BAD_REQUEST]);
               }

            } catch (Exception $e) {
                $this->response(['status' => false, 'data' => [], 'msg' => 'something went wrong !', 'response_code' => REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
            }
    }

   }

   public function Session_details_post()
   { 

      $id = $this->input->post('id',true);
      if ($this->input->post('id', true) == '') {
            $this->response(['status' => false, 'data' => [], 'msg' => ' id required!!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
        }else{
               try{
                
               $result =  $this->MemberEntry_model->session_existsOR_not($this->input->post('id',true));
               if(empty($result))
               {
                 $this->response(['status'=>false,'data'=>$result,'msg'=>'NO response!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);


               }else{
                  $this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);

               }

               

            } catch (Exception $e) {
                    $this->response(['status' => false, 'data' => [], 'msg' => 'something went wrong !', 'response_code' => REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
                }
         }
}
   
}
?>