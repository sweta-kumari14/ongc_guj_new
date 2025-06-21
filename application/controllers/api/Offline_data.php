<?php
require APPPATH.'libraries/REST_Controller.php';
class Offline_data extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Offline_data_model');
	}

	public function Offline_data_report_post()
	{
		try {
			$well_id = $this->input->post('well_id',true)!=''?$this->input->post('well_id',true):'';
			$from_date = $this->input->post('from_date',true)!=''?$this->input->post('from_date',true):'';
			$to_date = $this->input->post('to_date',true)!=''?$this->input->post('to_date',true):'';
			$result = $this->Offline_data_model->well_offline_data($well_id,$from_date,$to_date);

			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}
}
?>