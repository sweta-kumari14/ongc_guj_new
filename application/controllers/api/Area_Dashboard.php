<?php
require APPPATH.'libraries/REST_Controller.php';
class Area_Dashboard extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('AreaDashboard_model');
	}

	public function get_Total_InstalledSite_post()
	{
		try {
			$company_id = $this->input->post('company_id',true)!=""?$this->input->post('company_id',true):"";
			$assets_id = $this->input->post('assets_id',true)!=""?$this->input->post('assets_id',true):"";
			$area_id = $this->input->post('area_id',true)!=""?$this->input->post('area_id',true):"";
			$site_id = $this->input->post('site_id',true)!=""?$this->input->post('site_id',true):"";
			$well_id = $this->input->post('well_id',true)!=""?$this->input->post('well_id',true):"";
			$feeder_id = $this->input->post('feeder_id',true)!=""?$this->input->post('feeder_id',true):"";
			
			$result = [];
			$result['total_site'] = $this->AreaDashboard_model->TotalSite($company_id,$assets_id,$area_id);

			$result['total_well'] = $this->AreaDashboard_model->Totalwell($company_id,$assets_id,$area_id,$site_id,$well_id,$feeder_id);

			$result['total_installedsite'] = $this->AreaDashboard_model->TotalInstalledSite($company_id,$assets_id,$area_id,$site_id,$well_id,$feeder_id);

			$result['total_shifted'] = $this->AreaDashboard_model->Total_shiftedDevice($company_id,$assets_id,$area_id,$site_id,$feeder_id);

			$result['total_functional_unit'] = $this->AreaDashboard_model->Total_Functional_unit($company_id,$assets_id,$area_id,$site_id,$well_id,$feeder_id);
			$result['total_temperory_well'] = $this->AreaDashboard_model->Total_temporary_unit($company_id,$assets_id,$area_id,$site_id,$well_id,$feeder_id);
			$result['ON_Well'] = $this->AreaDashboard_model->Well_On_status($company_id,$assets_id,$area_id,$site_id,$well_id,$feeder_id);

			$result['Off_Well'] = $this->AreaDashboard_model->Total_OffInstalled_Well($company_id,$assets_id,$area_id,$site_id,$feeder_id);
			$result['faulty_well'] = $this->AreaDashboard_model->Total_faulty_Well($company_id,$assets_id,$area_id,$site_id,$well_id,$feeder_id);

			$result['power_cut_well'] = $this->AreaDashboard_model->Total_power_cutWell($company_id,$assets_id,$area_id,$site_id,$well_id,$feeder_id);

			$result['timer_off_well'] = $this->AreaDashboard_model->Total_timeroffWell($company_id,$assets_id,$area_id,$site_id,$well_id,$feeder_id);

			$result['rtms_offline'] = $this->AreaDashboard_model->Total_rtmsoffWell($company_id,$assets_id,$area_id,$site_id,$well_id,$feeder_id);

			// print_r($result['rtms_offline']);die;
			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function AssetList_forDashboard_post()
	{
		try {
			$company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
			$user_id = $this->input->post('user_id',true)!=''?$this->input->post('user_id',true):'';
			$result = $this->AreaDashboard_model->getAsset($company_id,$user_id);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function AreaList_forDashboard_post()
	{
		try {
			$company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
			$assets_id = $this->input->post('assets_id',true)!=''?$this->input->post('assets_id',true):'';
			$user_id = $this->input->post('user_id',true)!=''?$this->input->post('user_id',true):'';
			$result = $this->AreaDashboard_model->getArea($company_id,$assets_id,$user_id);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function SiteList_forDashboard_post()
	{
		try {
			$company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
			$assets_id = $this->input->post('assets_id',true)!=''?$this->input->post('assets_id',true):'';
			$area_id = $this->input->post('area_id',true)!=''?$this->input->post('area_id',true):'';
			$user_id = $this->input->post('user_id',true)!=''?$this->input->post('user_id',true):'';
			$result = $this->AreaDashboard_model->getSite($company_id,$assets_id,$area_id,$user_id);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function WellList_forDashboard_post()
	{
		try {
			$company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
			$assets_id = $this->input->post('assets_id',true)!=''?$this->input->post('assets_id',true):'';
			$area_id = $this->input->post('area_id',true)!=''?$this->input->post('area_id',true):'';
			$user_id = $this->input->post('user_id',true)!=''?$this->input->post('user_id',true):'';
			$well_id = $this->input->post('well_id',true)!=''?$this->input->post('well_id',true):'';
			$well_type = $this->input->post('well_type',true)!=''?$this->input->post('well_type',true):'';
			$site_id = $this->input->post('site_id',true)!=''?$this->input->post('site_id',true):'';
			$feeder_id = $this->input->post('feeder_id',true)!=''?$this->input->post('feeder_id',true):'';
			$result = $this->AreaDashboard_model->getWelllist($company_id,$assets_id,$area_id,$user_id,$well_id,$site_id,$feeder_id,$well_type);

			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function SiteList_for_Map_post()
	{
		try {
			$company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
			$assets_id = $this->input->post('assets_id',true)!=''?$this->input->post('assets_id',true):'';
			$area_id = $this->input->post('area_id',true)!=''?$this->input->post('area_id',true):'';
			$site_id = $this->input->post('site_id',true)!=''?$this->input->post('site_id',true):'';
			$user_id = $this->input->post('user_id',true)!=''?$this->input->post('user_id',true):'';
			$well_id = $this->input->post('well_id',true)!=''?$this->input->post('well_id',true):'';
			$feeder_id = $this->input->post('feeder_id',true)!=''?$this->input->post('feeder_id',true):'';
			$result = $this->AreaDashboard_model->getSite_for_Map($company_id,$assets_id,$area_id,$site_id,$user_id,$well_id,$feeder_id);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function Dashboard_Well_Details_post()
	{
		try {
			
			$company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
			$assets_id = $this->input->post('assets_id',true)!=''?$this->input->post('assets_id',true):'';
			$area_id = $this->input->post('area_id',true)!=''?$this->input->post('area_id',true):'';
			$site_id = $this->input->post('site_id',true)!=''?$this->input->post('site_id',true):'';
			$user_id = $this->input->post('user_id',true)!=''?$this->input->post('user_id',true):'';
			
			$result = $this->AreaDashboard_model->DashboardWelldetails($company_id,$assets_id,$area_id,$site_id,$user_id);

			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}
	public function Well_WiseEquipmentDetails_post()
	{
		try {
			
			$well_id = $this->input->post('well_id',true)!=''?$this->input->post('well_id',true):'';	
			
			$result = $this->AreaDashboard_model->Well_Wise_Equipment_Details($well_id);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function Dashboard_Functional_unit_post()
	{
		try {
			
			$company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
			$assets_id = $this->input->post('assets_id',true)!=''?$this->input->post('assets_id',true):'';
			$area_id = $this->input->post('area_id',true)!=''?$this->input->post('area_id',true):'';
			$site_id = $this->input->post('site_id',true)!=''?$this->input->post('site_id',true):'';
			$user_id = $this->input->post('user_id',true)!=''?$this->input->post('user_id',true):'';
			
			$result = $this->AreaDashboard_model->Functional_Unit($company_id,$assets_id,$area_id,$site_id,$user_id);

			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function Single_Device_Data_post()
	{
		try {
			
			$well_id = $this->input->post('well_id',true)!=''?$this->input->post('well_id',true):'';
			$imei_no = $this->input->post('imei_no',true)!=''?$this->input->post('imei_no',true):'';			
			
			$result = $this->AreaDashboard_model->Single_DeviceData($well_id,$imei_no);

			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function Well_Wise_Alert_Report_post()
	{
		try {
			
			$well_id = $this->input->post('well_id',true)!=''?$this->input->post('well_id',true):'';
			$imei_no = $this->input->post('imei_no',true)!=''?$this->input->post('imei_no',true):'';			
			$date = $this->input->post('date',true)!=''?$this->input->post('date',true):'';	
			$result = $this->AreaDashboard_model->WellAlert_Report($well_id,$imei_no,$date);

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
			$result['total_alert'] = $this->AreaDashboard_model->Well_Wise_Total_Alert($well_id,$imei_no);

			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function Single_Imei_daily_report_post()
	{
		try {
			$imei_no = $this->input->post('imei_no',true)!=''?$this->input->post('imei_no',true):'';
			$start_datetime = $this->input->post('start_datetime',true)!=''?$this->input->post('start_datetime',true):'';
			$end_datetime = $this->input->post('end_datetime',true)!=''?$this->input->post('end_datetime',true):'';
			$result = $this->AreaDashboard_model->get_Single_Daily_report($imei_no,$start_datetime,$end_datetime);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function Single_Imei_hourly_report_post()
	{
		try {
			$imei_no = $this->input->post('imei_no',true)!=''?$this->input->post('imei_no',true):'';
			$start_datetime = $this->input->post('start_datetime',true)!=''?$this->input->post('start_datetime',true):'';
			$end_datetime = $this->input->post('end_datetime',true)!=''?$this->input->post('end_datetime',true):'';
			$result = $this->AreaDashboard_model->get_Single_Hourly_report($imei_no,$start_datetime,$end_datetime);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function get_RunningWell_List_post()
	{
		try {
			$company_id = $this->input->post('company_id',true)!=""?$this->input->post('company_id',true):"";
			$assets_id = $this->input->post('assets_id',true)!=""?$this->input->post('assets_id',true):"";
			$area_id = $this->input->post('area_id',true)!=""?$this->input->post('area_id',true):"";
			$site_id = $this->input->post('site_id',true)!=""?$this->input->post('site_id',true):"";
			$user_id = $this->input->post('user_id',true)!=""?$this->input->post('user_id',true):"";
			$result = $this->AreaDashboard_model->Running_Well_List($company_id,$assets_id,$area_id,$site_id,$user_id);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function get_Not_RunningWell_List_post()
	{
		try {
			$company_id = $this->input->post('company_id',true)!=""?$this->input->post('company_id',true):"";
			$assets_id = $this->input->post('assets_id',true)!=""?$this->input->post('assets_id',true):"";
			$area_id = $this->input->post('area_id',true)!=""?$this->input->post('area_id',true):"";
			$site_id = $this->input->post('site_id',true)!=""?$this->input->post('site_id',true):"";
			$user_id = $this->input->post('user_id',true)!=""?$this->input->post('user_id',true):"";
			$result = $this->AreaDashboard_model->Not_Running_Well_List($company_id,$assets_id,$area_id,$site_id,$user_id);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function get_temperory_well_List_post()
	{
		try {
			$company_id = $this->input->post('company_id',true)!=""?$this->input->post('company_id',true):"";
			$assets_id = $this->input->post('assets_id',true)!=""?$this->input->post('assets_id',true):"";
			$area_id = $this->input->post('area_id',true)!=""?$this->input->post('area_id',true):"";
			$site_id = $this->input->post('site_id',true)!=""?$this->input->post('site_id',true):"";
			$user_id = $this->input->post('user_id',true)!=""?$this->input->post('user_id',true):"";
			$result = $this->AreaDashboard_model->temperory_Well_List($company_id,$assets_id,$area_id,$site_id,$user_id);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}


	public function get_FaultyWell_List_post()
	{
		try {
			$company_id = $this->input->post('company_id',true)!=""?$this->input->post('company_id',true):"";
			$assets_id = $this->input->post('assets_id',true)!=""?$this->input->post('assets_id',true):"";
			$area_id = $this->input->post('area_id',true)!=""?$this->input->post('area_id',true):"";
			$site_id = $this->input->post('site_id',true)!=""?$this->input->post('site_id',true):"";
			$user_id = $this->input->post('user_id',true)!=""?$this->input->post('user_id',true):"";
			$result = $this->AreaDashboard_model->faulty_Well_List($company_id,$assets_id,$area_id,$site_id,$user_id);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

    public function get_powercutWell_List_post()
	{
		try {
			$company_id = $this->input->post('company_id',true)!=""?$this->input->post('company_id',true):"";
			$assets_id = $this->input->post('assets_id',true)!=""?$this->input->post('assets_id',true):"";
			$area_id = $this->input->post('area_id',true)!=""?$this->input->post('area_id',true):"";
			$site_id = $this->input->post('site_id',true)!=""?$this->input->post('site_id',true):"";
			$user_id = $this->input->post('user_id',true)!=""?$this->input->post('user_id',true):"";
			$result = $this->AreaDashboard_model->powerCut_Well_List($company_id,$assets_id,$area_id,$site_id,$user_id);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function get_timeroffWell_List_post()
	{
		try {
			$company_id = $this->input->post('company_id',true)!=""?$this->input->post('company_id',true):"";
			$assets_id = $this->input->post('assets_id',true)!=""?$this->input->post('assets_id',true):"";
			$area_id = $this->input->post('area_id',true)!=""?$this->input->post('area_id',true):"";
			$site_id = $this->input->post('site_id',true)!=""?$this->input->post('site_id',true):"";
			$user_id = $this->input->post('user_id',true)!=""?$this->input->post('user_id',true):"";
			$result = $this->AreaDashboard_model->Timer_offWell_List($company_id,$assets_id,$area_id,$site_id,$user_id);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}



	public function get_RTMS_List_post()
	{
		try {
			$company_id = $this->input->post('company_id',true)!=""?$this->input->post('company_id',true):"";
			$assets_id = $this->input->post('assets_id',true)!=""?$this->input->post('assets_id',true):"";
			$area_id = $this->input->post('area_id',true)!=""?$this->input->post('area_id',true):"";
			$site_id = $this->input->post('site_id',true)!=""?$this->input->post('site_id',true):"";
			$result = $this->AreaDashboard_model->RTMS_List($company_id,$assets_id,$area_id,$site_id);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function get_Well_ListPopup_post()
	{
		try {
			$company_id = $this->input->post('company_id',true)!=""?$this->input->post('company_id',true):"";
			$assets_id = $this->input->post('assets_id',true)!=""?$this->input->post('assets_id',true):"";
			$area_id = $this->input->post('area_id',true)!=""?$this->input->post('area_id',true):"";
			$site_id = $this->input->post('site_id',true)!=""?$this->input->post('site_id',true):"";
			$well_id = $this->input->post('well_id',true)!=""?$this->input->post('well_id',true):"";
			$user_id = $this->input->post('user_id',true)!=""?$this->input->post('user_id',true):"";
			$search = $this->input->post('search',true)!=''? $this->input->post('search','true'):'';
			$feeder_id = $this->input->post('feeder_id',true)!=''? $this->input->post('feeder_id','true'):'';

			$result = $this->AreaDashboard_model->ActiveWell_Detail_for_popup($company_id,$user_id,$assets_id,$area_id,$site_id,$well_id,$search,$feeder_id);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function get_Well_Popup_List_post()
	{
		try {
			$company_id = $this->input->post('company_id',true)!=""?$this->input->post('company_id',true):"";
			$assets_id = $this->input->post('assets_id',true)!=""?$this->input->post('assets_id',true):"";
			$area_id = $this->input->post('area_id',true)!=""?$this->input->post('area_id',true):"";
			$site_id = $this->input->post('site_id',true)!=""?$this->input->post('site_id',true):"";
			$well_id = $this->input->post('well_id',true)!=""?$this->input->post('well_id',true):"";
			$user_id = $this->input->post('user_id',true)!=""?$this->input->post('user_id',true):"";
			$search = $this->input->post('search',true)!=''? $this->input->post('search','true'):'';

			$result = $this->AreaDashboard_model->Active_Well_for_popup($company_id,$user_id,$assets_id,$area_id,$site_id,$well_id,$search);
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
			$result['functional'] = $this->AreaDashboard_model->Functional_RTMS_List($company_id,$assets_id,$area_id,$site_id);
			$result['non_functional'] = $this->AreaDashboard_model->NonFunctional_RTMS_List($company_id,$assets_id,$area_id,$site_id,$user_id);

			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function Alert_Report_post()
	{
		try {
			
			$well_id = $this->input->post('well_id',true)!=''?$this->input->post('well_id',true):'';
			$imei_no = $this->input->post('imei_no',true)!=''?$this->input->post('imei_no',true):'';	
			$from_date = $this->input->post('from_date',true)!=''?$this->input->post('from_date',true):'';	
			$to_date = $this->input->post('to_date',true)!=''?$this->input->post('to_date',true):'';
			$user_id = $this->input->post('user_id',true)!=""?$this->input->post('user_id',true):"";
			$sort_by = $this->input->post('sort_by',true)!=""?$this->input->post('sort_by',true):"";
			$result = $this->AreaDashboard_model->Alert_Report($well_id,$imei_no,$from_date,$to_date,$user_id,$sort_by);

			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function Datewise_Alert_Log_post()
	{
		try {
			
			$date = $this->input->post('date',true)!=""?$this->input->post('date',true):"";
			$user_id = $this->input->post('user_id',true)!=""?$this->input->post('user_id',true):"";
			$sort_by = $this->input->post('sort_by',true)!=""?$this->input->post('sort_by',true):"";

			$result = $this->AreaDashboard_model->Date_wise_Alert_Report($date,$user_id,$sort_by);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function get_Shifted_WellList_post()
	{
		try {
			$company_id = $this->input->post('company_id',true)!=""?$this->input->post('company_id',true):"";
			$assets_id = $this->input->post('assets_id',true)!=""?$this->input->post('assets_id',true):"";
			$area_id = $this->input->post('area_id',true)!=""?$this->input->post('area_id',true):"";
			$site_id = $this->input->post('site_id',true)!=""?$this->input->post('site_id',true):"";
			$user_id = $this->input->post('user_id',true)!=""?$this->input->post('user_id',true):"";
			$result = $this->AreaDashboard_model->Shifted_Well_List($company_id,$assets_id,$area_id,$site_id,$user_id);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}
	
}
?>