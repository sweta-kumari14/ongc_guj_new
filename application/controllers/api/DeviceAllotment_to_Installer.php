<?php
require APPPATH.'libraries/REST_Controller.php';
class DeviceAllotment_to_Installer extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('DeviceAllotment_ToInstaller_model');
	}

    public function AllotDevice_List_post()
    {
        try{
            
            $company_id = $this->input->post('company_id',true)!=""?$this->input->post('company_id',true):"";
            $result = $this->DeviceAllotment_ToInstaller_model->getDevice_list($company_id);
            $this->response(['status'=>true,'data'=>$result,'msg'=>'successfully','response_code' => REST_Controller::HTTP_OK]);
        }catch(Exception $e)
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong !','response_code' => REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

    public function AllotUser_List_post()
    {
        try{
            
            $company_id = $this->input->post('company_id',true)!=""?$this->input->post('company_id',true):"";
            $result = $this->DeviceAllotment_ToInstaller_model->getUser_list($company_id);
            $this->response(['status'=>true,'data'=>$result,'msg'=>'successfully','response_code' => REST_Controller::HTTP_OK]);
        }catch(Exception $e)
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong !','response_code' => REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

    public function get_devicelist_for_installer_post()
    {
        try{
            $user_id = $this->input->post('user_id',true)!=""?$this->input->post('user_id',true):"";
            $company_id = $this->input->post('company_id',true)!=""?$this->input->post('company_id',true):"";
            // $assign_devices = $this->DeviceAllotment_ToInstaller_model->getAssigndeviceList($user_id,$company_id);
            $result_data = $this->DeviceAllotment_ToInstaller_model->get_device_list_for_installer($company_id);
            $this->response(['status'=>true,'data'=>$result_data,'msg'=>'successfully','response_code' => REST_Controller::HTTP_OK]);
        }catch(Exception $e)
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong !','response_code' => REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

    public function Installer_Allotment_post()
    {
        
        if($this->input->post('company_id',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'C Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif($this->input->post('user_id',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'U Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif($this->input->post('assign_device',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Device required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif($this->input->post('c_by',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'c kon required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }else{
            try {
                    $assign_device = json_decode($this->input->post('assign_device',true),true);
                    // print_r($assign_device);die;
                    foreach($assign_device as $key=>$value)
                    {
                        $local_variable = explode('|', $value);
                        // print_r($local_variable);die;

                        $id = $this->DeviceAllotment_ToInstaller_model->getIns_userId();
                        $dataArray = [];
                        $dataArray['id'] = $id[0]['UUID()'];
                        $dataArray['company_id'] = $this->input->post('company_id',true);
                        $dataArray['user_id'] = $this->input->post('user_id',true);
                        $dataArray['device_name'] = $local_variable[0];
                        $dataArray['imei_no'] = $local_variable[1];
                        $dataArray['allotment_date_time'] = date('Y-m-d H:i:s');
                        $dataArray['c_by'] = $this->input->post('c_by',true);
                        $dataArray['c_date'] = date('Y-m-d H:i:s');
                        $dataArray['status'] = 1;
                        $this->DeviceAllotment_ToInstaller_model->InstallerAllotment($dataArray);

                        $this->DeviceAllotment_ToInstaller_model->UpdateDevice_Status(['ins_allot_status'=>1,'d_by'=>$dataArray['c_by'],'d_date'=>date('Y-m-d H:i:s')],['imei_no'=>$local_variable[1],'status'=>1]);
                    
                }
                $this->response(['status'=>true,'data'=>[],'msg'=>'Successfully Device Alloted to Installer !!','response_code'=>REST_Controller::HTTP_OK]);
            } catch (Exception $e) {
                $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong !!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
            }
        }
    }


}
?>