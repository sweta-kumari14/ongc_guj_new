<?php
require APPPATH.'libraries/REST_Controller.php';
class Device_billing_report extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Device_billing_report_model');
	}

	public function Device_Billing_Details_post()
	{
		try {
			$well_id = $this->input->post('well_id',true)!=""?$this->input->post('well_id',true):"";
			$site_id = $this->input->post('site_id',true)!=""?$this->input->post('site_id',true):"";
			$from_date = $this->input->post('from_date',true)!=""?$this->input->post('from_date',true):"";
			$to_date = $this->input->post('to_date',true)!=""?$this->input->post('to_date',true):"";
			$result = $this->Device_billing_report_model->getDevice_BillingDetails($well_id,$site_id,$from_date,$to_date);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}
}
?>