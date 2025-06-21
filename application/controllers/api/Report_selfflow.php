<?php
require APPPATH.'libraries/REST_Controller.php';
class Report_selfflow extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Report_model');
	}
	public function flag_unflag_report_log_post()
	{
		try {
			$site_id = $this->input->post('site_id',true)!=''?$this->input->post('site_id',true):'';
			$well_id = $this->input->post('well_id',true)!=''?$this->input->post('well_id',true):'';
			$from_date = $this->input->post('from_date',true)!=''?$this->input->post('from_date',true):'';
			$to_date = $this->input->post('to_date',true)!=''?$this->input->post('to_date',true):'';
			$status = $this->input->post('status',true)!=''?$this->input->post('status',true):'';
			
			$result = $this->Report_model->flag_unflag_data($site_id,$well_id,$from_date,$to_date,$status);
			
           $this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}
}
?>