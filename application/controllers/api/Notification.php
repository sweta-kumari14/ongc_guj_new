<?php
require APPPATH.'libraries/REST_Controller.php';
class Notification extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Notification_model');
	}


	public function NotificationReport_post()
	{
		try {

			$imei_no = $this->input->post('imei_no',true)!=''?$this->input->post('imei_no',true):'';
			$from_date = $this->input->post('from_date',true)!=''?$this->input->post('from_date',true):'';
			$to_date = $this->input->post('to_date',true)!=''?$this->input->post('to_date',true):'';
			$user_id = $this->input->post('user_id',true)!=''?$this->input->post('user_id',true):'';

			$result = $this->Notification_model->Mobile_Notification_Report($imei_no,$from_date,$to_date,$user_id);

			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}
}
?>