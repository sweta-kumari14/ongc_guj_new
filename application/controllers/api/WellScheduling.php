<?php
require APPPATH.'libraries/REST_Controller.php';
class WellScheduling extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('WellScheduling_model');
	}

	public function insertScheduleData_post()
	{
		try {
			$from_date = $this->input->post('from_date',true)!=''?$this->input->post('from_date',true):'';
            $to_date = $this->input->post('to_date',true)!=''?$this->input->post('to_date',true):'';
			$allWell = $this->WellScheduling_model->wellSchedulingData_save($from_date,$to_date);
			// print_r($allWell);die;
			$this->response(['status'=>true,'data'=>[],'msg'=>'Successfully save!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}

	}
}
?>