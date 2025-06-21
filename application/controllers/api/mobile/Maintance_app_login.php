<?php 
require APPPATH . 'libraries/REST_Controller.php';

class Maintance_app_login extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mobile_model/Maintance_app_login_model');
    }

    public function Entry_Get_post()
    {
        $auth_password = $this->input->post('auth_password', true);

        if($this->input->post('mobile_no', true) == '') {
            $this->response(['status'=>false, 'data'=>[], 'msg'=>'Mobile No. required !', 'response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        } elseif($this->input->post('auth_password', true) == '') {
            $this->response(['status'=>false, 'data'=>[], 'msg'=>'Pass required !', 'response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        } elseif(!preg_match("/^[a-zA-Z0-9@\W]+$/", $auth_password)) {
            $this->response(['status'=>false, 'data'=>[], 'msg'=>'Pass should be eight digit, alphabet and special characters allowed!!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
        } else {
            try {
                $verify = $this->Maintance_app_login_model->verifY_user_Level($this->input->post('mobile_no', true));

                if ((isset($verify[0]['total']) && $verify[0]['total'] > 0)) {
                    $userinfo = array();
                    if($verify[0]['user_type'] == 3) {
                        $userinfoData = $this->Maintance_app_login_model->get_Installtion_Data($this->input->post('mobile_no', true));
                        // print_r($userinfoData);die;

                        if($userinfoData[0]['password'] == $this->input->post('auth_password', true)) 
                        {
                            $userinfo['id'] = $userinfoData[0]['id'];
                            $userinfo['company_id'] = $userinfoData[0]['company_id'];
                            $userinfo['asset_level_userId'] = $userinfoData[0]['unique_userId'];
                            $userinfo['company_name'] = $userinfoData[0]['company_name'];
                            $userinfo['user_member_id'] = $userinfoData[0]['user_member_id'];
                            $userinfo['user_full_name'] = $userinfoData[0]['user_full_name'];
                            $userinfo['email_id'] = $userinfoData[0]['email_id'];
                            $userinfo['role_type'] = $userinfoData[0]['role_type'];
                            $userinfo['contact_no'] = $userinfoData[0]['contact_no'];
                            $userinfo['assets_id'] = $userinfoData[0]['assets_id'];
                            $userinfo['assets_name'] = $userinfoData[0]['assets_name'];
                            $userinfo['area_id'] = $userinfoData[0]['area_id'];
                            $userinfo['area_name'] = $userinfoData[0]['area_name'];
                            $userinfo['site_id'] = $userinfoData[0]['site_id'];
                            $userinfo['site_name'] = $userinfoData[0]['well_site_name'];
                            $userinfo['user_type'] = $userinfoData[0]['user_type'];
                            $userinfo['login_date_time'] = $userinfoData[0]['login_date_time'];
                            $userinfo['password'] = $userinfoData[0]['password'];
                            $userinfo['login_status'] = $userinfoData[0]['login_status'];

                            $data = [];
                            $data['login_status'] = 1;
                            $data['login_date_time'] = date('Y-m-d H:i:s');
                            $data['d_by'] = $userinfo['user_member_id'];
                            $data['d_date'] = date('Y-m-d H:i:s');
                            
                            $this->Maintance_app_login_model->Last_Entry($data,['user_member_id'=> $userinfo['user_member_id'],'user_type'=>3]);

                            $this->response(['status'=>true,'data'=>$userinfo,'msg'=>'Auth Success !','response_code' => REST_Controller::HTTP_OK]);
                        }else{

                             $this->response(['status'=>false, 'data'=>[], 'msg'=>'Password Not Valid !', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);

                        }
                       
                    } else {
                        $this->response(['status'=>false, 'data'=>[], 'msg'=>'User Not Assigned This Site !', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
                    }
                } else {
                    $this->response(['status'=>false, 'data'=>[], 'msg'=>'Invalid Credentials. !', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
                }
            } catch (Exception $e) {
                $this->response(['status'=>false, 'data'=>[], 'msg'=>'Something went wrong!!', 'response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
            }
        }
    }
}
?>
