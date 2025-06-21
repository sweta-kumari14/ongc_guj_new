<?php
require APPPATH.'libraries/REST_Controller.php';
class list_selflow extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Selfflow_dashboard_model');
		$this->load->model('list_model');
	}
	public function Dashboard_Well_Details_post()
	{
		try {
			
			$company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
			$assets_id = $this->input->post('assets_id',true)!=''?$this->input->post('assets_id',true):'';
			$area_id = $this->input->post('area_id',true)!=''?$this->input->post('area_id',true):'';
			$site_id = $this->input->post('site_id',true)!=''?$this->input->post('site_id',true):'';
			$user_id = $this->input->post('user_id',true)!=''?$this->input->post('user_id',true):'';
			$well_id = $this->input->post('well_id',true)!=''?$this->input->post('well_id',true):'';
			$well_type = $this->input->post('well_type',true)!=''?$this->input->post('well_type',true):'';
			$user_type = $this->input->post('user_type',true)!=''?$this->input->post('user_type',true):'';
			$role_type = $this->input->post('role_type',true)!=''?$this->input->post('role_type',true):'';
			$result = $this->Selfflow_dashboard_model->DashboardWelldetails($company_id,$assets_id,$area_id,$site_id,$user_id,$well_id,$well_type,$user_type,$role_type);

			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}
  public function Dashboard_Flowing_well_post()
	{
		try {
			
			$company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
			$assets_id = $this->input->post('assets_id',true)!=''?$this->input->post('assets_id',true):'';
			$area_id = $this->input->post('area_id',true)!=''?$this->input->post('area_id',true):'';
			$site_id = $this->input->post('site_id',true)!=''?$this->input->post('site_id',true):'';
			$user_id = $this->input->post('user_id',true)!=''?$this->input->post('user_id',true):'';
			$well_id = $this->input->post('well_id',true)!=''?$this->input->post('well_id',true):'';
			$well_type = $this->input->post('well_type',true)!=''?$this->input->post('well_type',true):'';
			$user_type = $this->input->post('user_type',true)!=''?$this->input->post('user_type',true):'';
			$role_type = $this->input->post('role_type',true)!=''?$this->input->post('role_type',true):'';
			$result = $this->list_model->Flowing_Well($company_id,$assets_id,$area_id,$user_id,$well_id,$well_type,$site_id,$user_type,$role_type);

			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function Non_Flowing_Well_post()
	{
		try {
			$company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
			$assets_id = $this->input->post('assets_id',true)!=''?$this->input->post('assets_id',true):'';
			$area_id = $this->input->post('area_id',true)!=''?$this->input->post('area_id',true):'';
			$site_id = $this->input->post('site_id',true)!=''?$this->input->post('site_id',true):'';
			$user_id = $this->input->post('user_id',true)!=''?$this->input->post('user_id',true):'';
			$well_id = $this->input->post('well_id',true)!=''?$this->input->post('well_id',true):'';
			$well_type = $this->input->post('well_type',true)!=''?$this->input->post('well_type',true):'';
			$user_type = $this->input->post('user_type',true)!=''?$this->input->post('user_type',true):'';
			$role_type = $this->input->post('role_type',true)!=''?$this->input->post('role_type',true):'';
			$result = $this->list_model->Non_Flowing_Well($company_id,$assets_id,$area_id,$user_id,$well_id,$well_type,$site_id,$user_type,$role_type);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}
   public function get_FunctionalOr_NonfunctionalRTMS_List_post()
	{
		try {
			$company_id = $this->input->post('company_id',true)!=""?$this->input->post('company_id',true):"";
			$assets_id = $this->input->post('assets_id',true)!=""?$this->input->post('assets_id',true):"";
			$area_id = $this->input->post('area_id',true)!=""?$this->input->post('area_id',true):"";
			$site_id = $this->input->post('site_id',true)!=""?$this->input->post('site_id',true):"";
			$user_id = $this->input->post('user_id',true)!=""?$this->input->post('user_id',true):"";
			$result['functional'] = $this->list_model->Functional_RTMS_List($company_id,$assets_id,$area_id,$site_id);
			$result['non_functional'] = $this->list_model->NonFunctional_RTMS_List($company_id,$assets_id,$area_id,$site_id,$user_id);

			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

}
?>