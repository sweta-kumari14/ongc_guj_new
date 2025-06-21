<?php
require APPPATH.'libraries/REST_Controller.php';
class Equipment_Details extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Equipment_details_model');
	}

	public function Save_Equipment_Data_post()
	{
		$motor_name = $this->input->post('motor_name',true);
		$motor_type = $this->input->post('motor_type',true);
		$motor_sl_no = $this->input->post('motor_sl_no',true);
		$motor_capacity = $this->input->post('motor_capacity',true);
		$surface_unit_make = $this->input->post('surface_unit_make',true);
		$vfd_make = $this->input->post('vfd_make',true);
		$vfd_model = $this->input->post('vfd_model',true);
		$vfd_capacity = $this->input->post('vfd_capacity',true);					
		$dg_gg_make = $this->input->post('dg_gg_make',true);
		$dg_gg_rating = $this->input->post('dg_gg_rating',true);


		if($this->input->post('company_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Company required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('assets_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Asset required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('area_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Area required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('site_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Site required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('well_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Well required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('eqp_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Equ Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('motor_name',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'M Name required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('motor_sl_no',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Motor Serial Number required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('motor_capacity',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Motor Capacity required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('surface_unit_make',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Surface Make required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('vfd_make',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'VFD Make required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('vfd_model',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'VFD Model required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('vfd_capacity',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'VFD Capacity required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('power_source',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Power Source required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('dg_gg_make',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'DG make required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('dg_gg_rating',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'DG Rating required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('c_by',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'C Kon required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}else{
			try {
				
				$serial = $this->Equipment_details_model->verifySerial_numExist($this->input->post('motor_sl_no',true));
				// print_r($serial);die;
				if($serial == 0)
				{
					$E_Id = $this->Equipment_details_model->getEqupId();
					$details = [];
					$details['id'] = $E_Id[0]['UUID()'];
					$details['company_id'] = $this->input->post('company_id',true);
					$details['assets_id'] = $this->input->post('assets_id',true);
					$details['area_id'] = $this->input->post('area_id',true);
					$details['site_id'] = $this->input->post('site_id',true);
					$details['well_id'] = $this->input->post('well_id',true);
					$details['eqp_id'] = $this->input->post('eqp_id',true);
					$details['motor_name'] = $this->input->post('motor_name',true);
					$details['serial_no'] = $this->input->post('motor_sl_no',true);
					$details['motor_capacity'] = $this->input->post('motor_capacity',true);
					$details['surface_unit_make'] = $this->input->post('surface_unit_make',true);
					$details['vfd_make'] = $this->input->post('vfd_make',true);
					$details['vfd_model'] = $this->input->post('vfd_model',true);
					$details['vfd_capacity'] = $this->input->post('vfd_capacity',true);
					$details['power_source'] = $this->input->post('power_source',true);
					$details['dg_gg_make'] = $this->input->post('dg_gg_make',true);
					$details['dg_gg_rating'] = $this->input->post('dg_gg_rating',true);
					$details['phase'] = 2;

					$details['c_by'] = $this->input->post('c_by',true);
					$details['c_date'] = date('Y-m-d H:i:s');
					$details['status'] = 1;
					$this->Equipment_details_model->Save_Equipment_Details_data($details);

					$log_id = $this->Equipment_details_model->getLogId();

					$log = [];
					$log['id'] = $log_id[0]['UUID()'];
					$log['equipment_detail_id'] = $details['id'];
					
					
					$log['c_by'] = $this->input->post('c_by',true);
					$log['c_date'] = date('Y-m-d H:i:s');
					$log['status'] = 1;
					$this->Equipment_details_model->Save_Equipment_Log_data($log);
				}else{
					$last_value = $this->Equipment_details_model->getLast_Data($this->input->post('motor_sl_no',true));
					$log_id = $this->Equipment_details_model->getLogId();

					$log = [];
					$log['id'] = $log_id[0]['UUID()'];
					$log['equipment_detail_id'] = $last_value[0]['id'];
					
					$log['c_by'] = $this->input->post('c_by',true);
					$log['c_date'] = date('Y-m-d H:i:s');
					$log['status'] = 1;
					$this->Equipment_details_model->Save_Equipment_Log_data($log);

					$l_data = [];
					$l_data['eqp_id'] = $this->input->post('eqp_id',true);
					$l_data['motor_name'] = $this->input->post('motor_name',true);
					$l_data['motor_capacity'] = $this->input->post('motor_capacity',true);
					$l_data['surface_unit_make'] = $this->input->post('surface_unit_make',true);
					$l_data['vfd_make'] = $this->input->post('vfd_make',true);
					$l_data['vfd_model'] = $this->input->post('vfd_model',true);
					$l_data['vfd_capacity'] = $this->input->post('vfd_capacity',true);
					$l_data['power_source'] = $this->input->post('power_source',true);
					$l_data['dg_gg_make'] = $this->input->post('dg_gg_make',true);
					$l_data['dg_gg_rating'] = $this->input->post('dg_gg_rating',true);

					$l_data['last_update_date_time'] = date('Y-m-d H:i:s');
					$this->Equipment_details_model->Update_LastLog_Data($l_data,['serial_no'=>$this->input->post('motor_sl_no',true),'id'=>$last_value[0]['id']]);
				}				

				$this->response(['status'=>true,'data'=>[],'msg'=>'Successfully Equipment Details Saved!!','response_code'=>REST_Controller::HTTP_OK]);
				
			} catch (Exception $e) {
				$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
			}
		}
	}

	public function EquipmentList_for_update_post()
	{
		try {
			$company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
			$assets_id = $this->input->post('assets_id',true)!=''?$this->input->post('assets_id',true):'';
			$area_id = $this->input->post('area_id',true)!=''?$this->input->post('area_id',true):'';
			$site_id = $this->input->post('site_id',true)!=''?$this->input->post('site_id',true):'';
			$well_id = $this->input->post('well_id',true)!=''?$this->input->post('well_id',true):'';
			$eqp_id = $this->input->post('eqp_id',true)!=''?$this->input->post('eqp_id',true):'';
			$serial_no = $this->input->post('serial_no',true)!=''?$this->input->post('serial_no',true):'';
			$result = $this->Equipment_details_model->get_EquipmentList($company_id,$assets_id,$area_id,$site_id,$well_id,$eqp_id,$serial_no);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully Fetched !!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}
}
?>
