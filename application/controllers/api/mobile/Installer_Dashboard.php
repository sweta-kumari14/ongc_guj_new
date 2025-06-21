<?php
require APPPATH.'libraries/REST_Controller.php';
class Installer_Dashboard extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('mobile_model/Installer_Dashboard_model');
	}

	public function gettotal_Site_post()
	{
		try {
			$company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
			$user_id = $this->input->post('user_id',true)!=''?$this->input->post('user_id',true):'';
			
			$result = [];
			$result['total_site'] = $this->Installer_Dashboard_model->get_TotalSite($company_id,$user_id);
			$result['total_well'] = $this->Installer_Dashboard_model->get_TotalWell($company_id,$user_id);
			$result['total_alloted_device'] = $this->Installer_Dashboard_model->get_TotalAlloted_Device($company_id,$user_id);
			$result['total_installed_device'] = $this->Installer_Dashboard_model->get_TotalInstalled_Device($company_id,$user_id);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}
}
?>