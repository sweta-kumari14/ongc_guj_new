<?php
require APPPATH.'libraries/REST_Controller.php';
class Selfflow_alert extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Selfflow_alert_model');
	}
    

	public function Date_Wise_Alert_Report_post()
	{
		try {
			   $well_id = $this->input->post('well_id',true)!=''?$this->input->post('well_id',true):'';	
			   $site_id = $this->input->post('site_id',true)!=''?$this->input->post('site_id',true):'';	
			   $user_id = $this->input->post('user_id',true)!=''?$this->input->post('user_id',true):'';			
			   $date = $this->input->post('date',true)!=''?$this->input->post('date',true):'';	
			   $result = $this->Selfflow_alert_model->date_wise_Alert_Report($well_id,$date,$site_id,$user_id);

			  $this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function Well_wise_Alert_Report_post()
	{
		try {
			
			$well_id = $this->input->post('well_id',true)!=''?$this->input->post('well_id',true):'';
			$site_id = $this->input->post('site_id',true)!=''?$this->input->post('site_id',true):'';	
				
			$from_date = $this->input->post('from_date',true)!=''?$this->input->post('from_date',true):'';	
			$to_date = $this->input->post('to_date',true)!=''?$this->input->post('to_date',true):'';
			$user_id = $this->input->post('user_id',true)!=""?$this->input->post('user_id',true):"";
			$sort_by = $this->input->post('sort_by',true)!=""?$this->input->post('sort_by',true):"";
			$result = $this->Selfflow_alert_model->Well_wise_Alert_Report($well_id,$site_id,$from_date,$to_date,$user_id,$sort_by);

			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function Well_Wise_Count_post()
	{
		try {
			
			$well_id = $this->input->post('well_id',true)!=''?$this->input->post('well_id',true):'';
			$imei_no = $this->input->post('imei_no',true)!=''?$this->input->post('imei_no',true):'';	
			
			$result = [];
			$result['total_alert'] = $this->Selfflow_alert_model->Well_Wise_Total_Alert($well_id,$imei_no);

			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}
}
?>