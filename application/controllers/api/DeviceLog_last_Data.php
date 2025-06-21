<?php
require APPPATH.'libraries/REST_Controller.php';
class DeviceLog_last_Data extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('DeviceLog_LastData_model');
	}

	public function Device_Log_last_tenData_post()
	{
		try {
			$well_id = $this->input->post('well_id',true)!=''?$this->input->post('well_id',true):'';
			$imei_no = $this->input->post('imei_no',true)!=''?$this->input->post('imei_no',true):'';
			
			$result = $this->DeviceLog_LastData_model->Device_log_last_tenData($well_id,$imei_no);

			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function Imei_list_post()
	{
		try {
			
			$result = $this->DeviceLog_LastData_model->getImei();

			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}
		
}
?>