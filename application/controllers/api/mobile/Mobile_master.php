<?php
require APPPATH.'libraries/REST_Controller.php';
class Mobile_master extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('mobile_model/Mobile_master_model');
	}

	public function getinstallation_DeviceList_post()
	{
		try {
			$company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
			$user_id = $this->input->post('user_id',true)!=''?$this->input->post('user_id',true):'';
			$result = $this->Mobile_master_model->getDeviceList($company_id,$user_id);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function get_AssetList_post()
	{
		try {
			$company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
			$user_id = $this->input->post('user_id',true)!=''?$this->input->post('user_id',true):'';
			$result = $this->Mobile_master_model->get_Asset_List($company_id,$user_id);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function get_Area_List_post()
	{
		try {
			$company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
			$user_id = $this->input->post('user_id',true)!=''?$this->input->post('user_id',true):'';
			$assets_id = $this->input->post('assets_id',true)!=''?$this->input->post('assets_id',true):'';
			$result = $this->Mobile_master_model->get_Area_List($company_id,$user_id,$assets_id);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function getSite_List_post()
	{
		try {
			$company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
			$user_id = $this->input->post('user_id',true)!=''?$this->input->post('user_id',true):'';
			$assets_id = $this->input->post('assets_id',true)!=''?$this->input->post('assets_id',true):'';
			$area_id = $this->input->post('area_id',true)!=''?$this->input->post('area_id',true):'';
			$result = $this->Mobile_master_model->getSite_List($company_id,$user_id,$assets_id,$area_id);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function getWell_List_post()
	{
		try {
			$company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
			$user_id = $this->input->post('user_id',true)!=''?$this->input->post('user_id',true):'';
			$assets_id = $this->input->post('assets_id',true)!=''?$this->input->post('assets_id',true):'';
			$area_id = $this->input->post('area_id',true)!=''?$this->input->post('area_id',true):'';
			$site_id = $this->input->post('site_id',true)!=''?$this->input->post('site_id',true):'';
			$result = $this->Mobile_master_model->getWell_List($company_id,$user_id,$assets_id,$area_id,$site_id);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function Device_List_for_replacement_post()
	{
		try {
			$company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
			$user_id = $this->input->post('user_id',true)!=''?$this->input->post('user_id',true):'';
			$assets_id = $this->input->post('assets_id',true)!=''?$this->input->post('assets_id',true):'';
			$area_id = $this->input->post('area_id',true)!=''?$this->input->post('area_id',true):'';
			$site_id = $this->input->post('site_id',true)!=''?$this->input->post('site_id',true):'';
			$well_id = $this->input->post('well_id',true)!=''?$this->input->post('well_id',true):'';
			$result = $this->Mobile_master_model->Device_List_for_Replacement($company_id,$user_id,$assets_id,$area_id,$site_id,$well_id);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	// ================= replacement code =========================

	public function get_AssetList_for_replacement_post()
	{
		try {
			$company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
			$installed_by = $this->input->post('installed_by',true)!=''?$this->input->post('installed_by',true):'';
			$result = $this->Mobile_master_model->get_Asset_List_for_replacement($company_id,$installed_by);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function get_AreaList_for_replacement_post()
	{
		try {
			$company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
			$installed_by = $this->input->post('installed_by',true)!=''?$this->input->post('installed_by',true):'';
			$assets_id = $this->input->post('assets_id',true)!=''?$this->input->post('assets_id',true):'';
			$result = $this->Mobile_master_model->get_Area_List_for_replacement($company_id,$installed_by,$assets_id);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function get_SiteList_for_replacement_post()
	{
		try {
			$company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
			$installed_by = $this->input->post('installed_by',true)!=''?$this->input->post('installed_by',true):'';
			$assets_id = $this->input->post('assets_id',true)!=''?$this->input->post('assets_id',true):'';
			$area_id = $this->input->post('area_id',true)!=''?$this->input->post('area_id',true):'';
			$result = $this->Mobile_master_model->get_Site_List_for_replacement($company_id,$installed_by,$assets_id,$area_id);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function get_WellList_for_replacement_post()
	{
		try {
			$company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
			$installed_by = $this->input->post('installed_by',true)!=''?$this->input->post('installed_by',true):'';
			$assets_id = $this->input->post('assets_id',true)!=''?$this->input->post('assets_id',true):'';
			$area_id = $this->input->post('area_id',true)!=''?$this->input->post('area_id',true):'';
			$site_id = $this->input->post('site_id',true)!=''?$this->input->post('site_id',true):'';
			$result = $this->Mobile_master_model->get_WellList_for_replacement($company_id,$installed_by,$assets_id,$area_id,$site_id);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	

    

    
}
?>