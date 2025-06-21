<?php
require APPPATH.'libraries/REST_Controller.php';
class Alert_Dashboard extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('AlertDashboard_model');
	}

	public function Save_AlertData_post()
	{
		$imei_no = $this->input->post('imei_no',true);

		if($this->input->post('imei_no',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Imei required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[a-zA-Z0-9]{10,20}$/",$imei_no))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'IMEI should be 10 to 20 digit and character allowed !!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('alert_type',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Alert Type required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('alerts_details',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Alert Detail required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}else{
			try {
				$dataArray = [];
				$dataArray['imei_no'] = $this->input->post('imei_no',true);
				$dataArray['alert_type'] = $this->input->post('alert_type',true);
				$dataArray['alerts_details'] = $this->input->post('alerts_details',true);
				$this->AlertDashboard_model->SaveAlert_Data($dataArray);
				$this->response(['status'=>true,'data'=>[],'msg'=>'Successfully Saved!!','response_code'=>REST_Controller::HTTP_OK]);
			} catch (Exception $e) {
				$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
			}
		}
	}

	public function get_AlertReport_post()
	{
		try {
			$company_id = $this->input->post('company_id',true)!=""?$this->input->post('company_id',true):"";
			$assets_id = $this->input->post('assets_id',true)!=""?$this->input->post('assets_id',true):"";
			$area_id = $this->input->post('area_id',true)!=""?$this->input->post('area_id',true):"";
			$site_id = $this->input->post('site_id',true)!=""?$this->input->post('site_id',true):"";
			$user_id = $this->input->post('user_id',true)!=""?$this->input->post('user_id',true):"";
			$date = $this->input->post('date',true)!=""?$this->input->post('date',true):"";

			$result = $this->AlertDashboard_model->Alert_Report($company_id,$assets_id,$area_id,$site_id,$user_id,$date);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function get_single_AlertReport_post()
	{
		try {
			$imei_no = $this->input->post('imei_no',true)!=""?$this->input->post('imei_no',true):"";
			$date = $this->input->post('date',true)!=""?$this->input->post('date',true):"";
			$result = $this->AlertDashboard_model->single_time_Alert_Report($imei_no,$date);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}
}
?>