<?php 
require APPPATH . 'libraries/REST_Controller.php';
class Installer_Login extends REST_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->model('mobile_model/Installer_login_model');
    }

    public function InstallerEntry_post()
    {
        $auth_password = $this->input->post('auth_password',true);
        $mobile_no = $this->input->post('mobile_no',true);

        if($this->input->post('mobile_no',true)=='')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Mobile required !','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif(!preg_match("/^[0-9]{10}$/i", $mobile_no))
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Mobile should be 10 digit allowed !!','response_code' => REST_Controller::HTTP_BAD_REQUEST]);
        }elseif($this->input->post('auth_password',true)==''){
            $this->response(['status'=>false,'data'=>[],'msg'=>'Pass required !','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif(!preg_match("/^[a-zA-Z0-9]{8}$/",$auth_password))
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Pass should be eight character and number allowed!!','response_code' => REST_Controller::HTTP_BAD_REQUEST]);
        }else{
            try {
                $verify = $this->Installer_login_model->verifY_Installer($this->input->post('mobile_no',true));
                // print_r($verify); die;
                if($verify[0]['total'] > 0)
                {
                    $userinfoData = array();
                    
                    $userInfo = $this->Installer_login_model->getinstallationInfo($this->input->post('mobile_no',true));
                    // print_r($userInfo); die;

                    if(!empty($userInfo))
                    {
                        if($userInfo[0]['role_type'] == 3)
                        {
                            if($userInfo[0]['password'] == $this->input->post('auth_password',true))
                            {
                            
                                if($userInfo[0]['active_status'] == 1)
                                {
                                    if($userInfo[0]['mobile_functionality'] == 1)
                                    {
                                        
                                        $userinfoData['id'] = $userInfo[0]['id'];
                                        $userinfoData['company_id'] = $userInfo[0]['company_id'];
                                        $userinfoData['company_name'] = $userInfo[0]['company_name'];
                                        $userinfoData['user_member_id'] = $userInfo[0]['user_member_id'];
                                        $userinfoData['user_full_name'] = $userInfo[0]['user_full_name'];
                                        $userinfoData['email_id'] = $userInfo[0]['email_id'];
                                        $userinfoData['emp_id'] = $userInfo[0]['emp_id'];
                                        $userinfoData['contact_no'] = $userInfo[0]['mobile_no'];
                                        $userinfoData['assets_id'] = $userInfo[0]['assign_id'];
                                        $userinfoData['assets_name'] = $userInfo[0]['assets_name'];
                                        $userinfoData['area_id'] = $userInfo[0]['area_id'];
                                        $userinfoData['area_name'] = $userInfo[0]['area_name'];
                                        $userinfoData['site_id'] = $userInfo[0]['site_id'];
                                        $userinfoData['site_name'] = $userInfo[0]['site_name'];
                                        $userinfoData['well_id'] = $userInfo[0]['well_id'];
                                        $userinfoData['well_name'] = $userInfo[0]['well_name'];
                                        $userinfoData['user_type'] = $userInfo[0]['user_type'];
                                        $userinfoData['role_type'] = $userInfo[0]['role_type'];
                                        $userinfoData['login_date_time'] = $userInfo[0]['login_date_time'];
                                        $userinfoData['login_status'] = $userInfo[0]['login_status'];

                                        $data = [];
                                        $data['login_status'] = 1;
                                        $data['login_date_time'] = date('Y-m-d H:i:s');
                                        $data['d_by'] = $userinfoData['company_id'];
                                        $data['d_date'] = date('Y-m-d H:i:s');
                                        $this->Installer_login_model->InstallerLast_Entry($data,['user_member_id'=> $userinfoData['user_member_id'],'user_type'=>3]);

                                        $this->response(['status'=>true,'data'=>$userinfoData,'msg'=>'Auth Success !','response_code' => REST_Controller::HTTP_OK]);
                                        
                                    }else{
                                        $this->response(['status'=>false,'data'=>[],'msg'=>'Not Authorized for Mobile Functionality!!','response_code' => REST_Controller::HTTP_BAD_REQUEST]);
                                    }
                                }else{
                                    $this->response(['status'=>false,'data'=>[],'msg'=>'Installer Not Authorized !!','response_code' => REST_Controller::HTTP_BAD_REQUEST]);
                                }
                            
                            }else{
                                $this->response(['status'=>false,'data'=>[],'msg'=>'password wrong. !','response_code' => REST_Controller::HTTP_BAD_REQUEST]);
                            }
                        }else{
                            $this->response(['status'=>false,'data'=>[],'msg'=>'Installer Not Authorized !','response_code' => REST_Controller::HTTP_BAD_REQUEST]);
                            }
                        
                    }else{
                        $this->response(['status'=>false,'data'=>[],'msg'=>'Installer Not Assign This Site !','response_code' => REST_Controller::HTTP_BAD_REQUEST]);
                    }
                      
                }else{
                    $this->response(['status'=>false,'data'=>[],'msg'=>'Invalid Credentials. !','response_code' => REST_Controller::HTTP_BAD_REQUEST]);
                }
                    
            } catch (Exception $e) {
                $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
            }
                
        }
    }
}
?>