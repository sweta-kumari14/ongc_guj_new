<?php
require APPPATH.'libraries/REST_Controller.php';
class Report extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Report_model');
	}

	public function CompanyAllotment_Report_post()
	{
		try {
			$company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
			$from_date = $this->input->post('from_date',true)!=''?$this->input->post('from_date',true):'';
			$to_date = $this->input->post('to_date',true)!=''?$this->input->post('to_date',true):'';
			$result = $this->Report_model->DeviceAllotment_To_CompanyReport($company_id,$from_date,$to_date);

			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function DeviceReceiving_Report_post()
	{
		try {
			$company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
			$from_date = $this->input->post('from_date',true)!=''?$this->input->post('from_date',true):'';
			$to_date = $this->input->post('to_date',true)!=''?$this->input->post('to_date',true):'';
			$result = $this->Report_model->DeviceReceiving_To_CompanyReport($company_id,$from_date,$to_date);

			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function DeviceAllotment_to_Installer_Report_post()
	{
		try {
			$company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
			$user_id = $this->input->post('user_id',true)!=''?$this->input->post('user_id',true):'';
			$from_date = $this->input->post('from_date',true)!=''?$this->input->post('from_date',true):'';
			$to_date = $this->input->post('to_date',true)!=''?$this->input->post('to_date',true):'';
			$result = $this->Report_model->DeviceAllotment_To_InstallerReport($company_id,$user_id,$from_date,$to_date);

			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function SiteUser_Allotment_Report_post()
	{
		try {
			$company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
			$area_id = $this->input->post('area_id',true)!=''?$this->input->post('area_id',true):'';
			$site_id = $this->input->post('site_id',true)!=''?$this->input->post('site_id',true):'';
			$user_id = $this->input->post('user_id',true)!=''?$this->input->post('user_id',true):'';
			$from_date = $this->input->post('from_date',true)!=''?$this->input->post('from_date',true):'';
			$to_date = $this->input->post('to_date',true)!=''?$this->input->post('to_date',true):'';
			$result = $this->Report_model->Site_Allotment_to_user_Report($company_id,$area_id,$site_id,$user_id,$from_date,$to_date);

			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function EquipmentDetails_Report_post()
	{
		try {
			$id = $this->input->post('id',true)!=''?$this->input->post('id',true):'';
			$company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
			$from_date = $this->input->post('from_date',true)!=''?$this->input->post('from_date',true):'';
			$to_date = $this->input->post('to_date',true)!=''?$this->input->post('to_date',true):'';
			$result = $this->Report_model->Equipment_Details_Report($id,$company_id,$from_date,$to_date);

			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function EquipmentLog_Report_post()
	{
		try {
			$equipment_detail_id = $this->input->post('equipment_detail_id',true)!=''?$this->input->post('equipment_detail_id',true):'';
		
			$result = $this->Report_model->Equipment_Log_Report($equipment_detail_id);

			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	

	public function Installed_DeviceReport_post()
	{
		try {
			$company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
			$user_id = $this->input->post('user_id',true)!=''?$this->input->post('user_id',true):'';
			$assets_id = $this->input->post('assets_id',true)!=''?$this->input->post('assets_id',true):'';
			$area_id = $this->input->post('area_id',true)!=''?$this->input->post('area_id',true):'';
			$site_id = $this->input->post('site_id',true)!=''?$this->input->post('site_id',true):'';
			$well_id = $this->input->post('well_id',true)!=''?$this->input->post('well_id',true):'';
			$from_date = $this->input->post('from_date',true)!=''?$this->input->post('from_date',true):'';
			$to_date = $this->input->post('to_date',true)!=''?$this->input->post('to_date',true):'';
			$well_type = $this->input->post('well_type',true)!=''?$this->input->post('well_type',true):'';
			$result = $this->Report_model->Installed_Device_Report($company_id,$user_id,$assets_id,$area_id,$site_id,$well_id,$from_date,$to_date,$well_type);

			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function DeviceInstallation_Mis_Report_post()
	{
		try {
			$imei_no = $this->input->post('imei_no',true)!=''?$this->input->post('imei_no',true):'';
			
			$result = $this->Report_model->Mis_Report($imei_no);

			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function Device_Replacement_Report_post()
	{
		try {
			
			$company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
			$user_id = $this->input->post('user_id',true)!=''?$this->input->post('user_id',true):'';
			$assets_id = $this->input->post('assets_id',true)!=''?$this->input->post('assets_id',true):'';
			$area_id = $this->input->post('area_id',true)!=''?$this->input->post('area_id',true):'';
			$site_id = $this->input->post('site_id',true)!=''?$this->input->post('site_id',true):'';
			$from_date = $this->input->post('from_date',true)!=''?$this->input->post('from_date',true):'';
			$to_date = $this->input->post('to_date',true)!=''?$this->input->post('to_date',true):'';
			$result = $this->Report_model->DeviceReplacement_Report($company_id,$user_id,$assets_id,$area_id,$site_id,$from_date,$to_date);

			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function Device_Logdaily_Report_post()
	{
		try {
			
			$company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
			$start_date = $this->input->post('start_date',true)!=''?$this->input->post('start_date',true):'';
			$end_date = $this->input->post('end_date',true)!=''?$this->input->post('end_date',true):'';
			$result = $this->Report_model->DeviceLog_daily_Report($company_id,$start_date,$end_date);

			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function Device_Log_hourly_Report_post()
	{
		try {
			
			$company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
			$start_date = $this->input->post('start_date',true)!=''?$this->input->post('start_date',true):'';
			$end_date = $this->input->post('end_date',true)!=''?$this->input->post('end_date',true):'';
			$result = $this->Report_model->DeviceLog_hourly_Report($company_id,$start_date,$end_date);

			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function TripReport_post()
	{
		try {
			
			$well_id = $this->input->post('well_id',true)!=''?$this->input->post('well_id',true):'';
			$from_date = $this->input->post('from_date',true)!=''?$this->input->post('from_date',true):'';
			$to_date = $this->input->post('to_date',true)!=''?$this->input->post('to_date',true):'';
			$result = $this->Report_model->Trip_Report($well_id,$from_date,$to_date);

			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function Access_Log_post()
	{
		try {
			$from_date = $this->input->post('from_date',true)!=''?$this->input->post('from_date',true):'';
			$to_date = $this->input->post('to_date',true)!=''?$this->input->post('to_date',true):'';
			$result = $this->Report_model->Access_Report($from_date,$to_date);

			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function Well_running_Energy_Consumption_log_report_post()
	{
		try {
			$site_id = $this->input->post('site_id',true)!=''?$this->input->post('site_id',true):'';
			$well_id = $this->input->post('well_id',true)!=''?$this->input->post('well_id',true):'';
			$from_date = $this->input->post('from_date',true)!=''?$this->input->post('from_date',true):'';
			$to_date = $this->input->post('to_date',true)!=''?$this->input->post('to_date',true):'';
			$sort_by = $this->input->post('sort_by',true)!=''?$this->input->post('sort_by',true):'';
			$feeder_id = $this->input->post('feeder_id',true)!=""?$this->input->post('feeder_id',true):"";
			$result['area_wise'] = $this->Report_model->well_runningEnergy_logreport($site_id,$well_id,$from_date,$to_date,$sort_by,$feeder_id);
			
           $this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function Well_running_Assets_wise_report_post()
	{
		try {
			$site_id = $this->input->post('site_id',true)!=''?$this->input->post('site_id',true):'';
			$from_date = $this->input->post('from_date',true)!=''?$this->input->post('from_date',true):'';
			$to_date = $this->input->post('to_date',true)!=''?$this->input->post('to_date',true):'';
			$sort_by = $this->input->post('sort_by',true)!=''?$this->input->post('sort_by',true):'';
			
			$result['assets_wise'] = $this->Report_model->well_runningEnergylog($site_id,$from_date,$to_date,$sort_by);
			
           $this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function Asset_Areawise_monthly_WellDetails_report_post()
	{
		try {
			$site_id = $this->input->post('site_id',true)!=''?$this->input->post('site_id',true):'';
			$month = $this->input->post('month',true)!=''?$this->input->post('month',true):'';
			$year = $this->input->post('year',true)!=''?$this->input->post('year',true):'';
			
			$result = $this->Report_model->Asset_Areawise_monthly_WellDetails_model($site_id,$month,$year);
			
           $this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function Asset_Areawise_monthlyDevice_Record_report_post()
	{
		try {
			$site_id = $this->input->post('site_id',true)!=''?$this->input->post('site_id',true):'';
			$month = $this->input->post('month',true)!=''?$this->input->post('month',true):'';
			$year = $this->input->post('year',true)!=''?$this->input->post('year',true):'';
			
			$result = $this->Report_model->Asset_Areawise_monthlyDeviceRecord_model($site_id,$month,$year);
			
           $this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}


	public function Device_performance_data_post()
	{
		try {
			$site_id = $this->input->post('site_id',true)!=''?$this->input->post('site_id',true):'';
			$month = $this->input->post('month',true)!=''?$this->input->post('month',true):'';
			$year = $this->input->post('year',true)!=''?$this->input->post('year',true):'';
			
			$result = $this->Report_model->device_recode_data($site_id,$month,$year);
			
           $this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
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

	public function Report_Maintance_post()
	{
		try {
			$maintance_id = $this->input->post('maintance_id',true)!=""?$this->input->post('maintance_id',true):"";
			$issue_status = $this->input->post('issue_status',true)!=""?$this->input->post('issue_status',true):"";
			$well_id = $this->input->post('well_id',true)!=""?$this->input->post('well_id',true):"";
			$area_id = $this->input->post('area_id',true)!=""?$this->input->post('area_id',true):"";
			$site_id = $this->input->post('site_id',true)!=""?$this->input->post('site_id',true):"";
			$from_date = $this->input->post('from_date',true)!=""?$this->input->post('from_date',true):"";
			$to_date = $this->input->post('to_date',true)!=""?$this->input->post('to_date',true):"";
			$result = $this->Report_model->MaintanceList($maintance_id,$area_id,$site_id,$well_id,$from_date,$to_date,$issue_status);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	  
	}

	Public function get_maintenance_timeline_post()
    {
        try {
            
            $maintance_id = $this->input->post('maintance_id',true)!=''?$this->input->post('maintance_id',true):'';
            $result = $this->Report_model->get_maintance_timeline_log($maintance_id);
            $this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
        }catch (Exception $e) {
            $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

    public function get_problemlist_post()
	{
        try{

			$result = $this->Report_model->problemList();
			$this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		}catch (Exception $e) 
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}


}
?>
