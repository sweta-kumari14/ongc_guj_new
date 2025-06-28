<?php
require APPPATH.'libraries/REST_Controller.php';
class Device_Threshold_Details extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Device_Threshold_model');
	}

	public function Save_ThresholdData_post()
	{
		$well_id = $this->input->post('well_id',true);
		$imei_no = $this->input->post('imei_no',true);
		$output_p2p_ut = $this->input->post('output_p2p_ut',true);
		$output_p2p_lt = $this->input->post('output_p2p_lt',true);
		$out_current_ut = $this->input->post('out_current_ut',true);
		$out_current_lt = $this->input->post('out_current_lt',true);
		
		if($this->input->post('well_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Well required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('imei_no',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'IMEI required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[a-zA-Z0-9]{10,20}$/",$imei_no))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'IMEI should be 10 to 20 digit and character allowed !!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('output_p2p_ut',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'OutPut  Volt Upper Threshold required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[0-9.]*$/",$output_p2p_ut))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'OutPut  Volt Upper Threshold not valid!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('output_p2p_lt',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'OutPut  Volt Lower Threshold required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[0-9.]*$/",$output_p2p_lt))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'OutPut  Volt Lower Threshold not valid!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('out_current_ut',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'OutPut Current Upper Threshold required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[0-9.]*$/",$out_current_ut))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'OutPut Current Upper Threshold not valid!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('out_current_lt',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'OutPut Current Lower Threshold required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[0-9.]*$/",$out_current_lt))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'OutPut Current Lower Threshold not valid!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}else{
			try {
				
				$imei = $this->Device_Threshold_model->verifyImeiExist($this->input->post('well_id',true),$this->input->post('imei_no',true));
				// print_r($serial);die;
				if($imei == 0)
				{
					$T_Id = $this->Device_Threshold_model->getId();
					$details = [];
					$details['id'] = $T_Id[0]['UUID()'];
					$details['well_id'] = $this->input->post('well_id',true);
					$details['imei_no'] = $this->input->post('imei_no',true);
					$details['output_p2p_ut'] = $this->input->post('output_p2p_ut',true);
					$details['output_p2p_lt'] = $this->input->post('output_p2p_lt',true);
					$details['out_current_ut'] = $this->input->post('out_current_ut',true);
					$details['out_current_lt'] = $this->input->post('out_current_lt',true);	$details['cby'] = $this->input->post('c_by',true);
					$details['cdate'] = date('Y-m-d H:i:s');
					$details['status'] = 1;
					$this->Device_Threshold_model->Save_DeviceThreshold_data($details);

					$log_id = $this->Device_Threshold_model->getTh_LogId();

					$log = [];
					$log['id'] = $log_id[0]['UUID()'];
					$log['well_id'] = $this->input->post('well_id',true);
					$log['imei_no'] = $this->input->post('imei_no',true);
					$log['output_p2p_ut'] = $this->input->post('output_p2p_ut',true);
					$log['output_p2p_lt'] = $this->input->post('output_p2p_lt',true);
					$log['out_current_ut'] = $this->input->post('out_current_ut',true);
					$log['out_current_lt'] = $this->input->post('out_current_lt',true);
					$log['cby'] = $this->input->post('c_by',true);
					$log['cdate'] = date('Y-m-d H:i:s');
					$log['status'] = 1;
					$this->Device_Threshold_model->Save_DeviceThreshold_Log_data($log);
				}else{
					
					$log_id = $this->Device_Threshold_model->getTh_LogId();
					$log = [];
					$log['id'] = $log_id[0]['UUID()'];
					$log['well_id'] = $this->input->post('well_id',true);
					$log['imei_no'] = $this->input->post('imei_no',true);
					$log['output_p2p_ut'] = $this->input->post('output_p2p_ut',true);
					$log['output_p2p_lt'] = $this->input->post('output_p2p_lt',true);
					$log['out_current_ut'] = $this->input->post('out_current_ut',true);
					$log['out_current_lt'] = $this->input->post('out_current_lt',true);
					$log['cby'] = $this->input->post('c_by',true);
					$log['cdate'] = date('Y-m-d H:i:s');
					$log['status'] = 1;
					$this->Device_Threshold_model->Save_DeviceThreshold_Log_data($log);

					$l_data = [];
					
					$l_data['output_p2p_ut'] = $this->input->post('output_p2p_ut',true);
					$l_data['output_p2p_lt'] = $this->input->post('output_p2p_lt',true);
					$l_data['out_current_ut'] = $this->input->post('out_current_ut',true);
					$l_data['out_current_lt'] = $this->input->post('out_current_lt',true);
					$l_data['dby'] = $this->input->post('d_by',true);
					$l_data['ddate'] = date('Y-m-d H:i:s');
					$this->Device_Threshold_model->Update_last_ThresholdData($l_data,['well_id'=>$this->input->post('well_id',true),'imei_no'=>$this->input->post('imei_no',true)]);
				}				

				$this->response(['status'=>true,'data'=>[],'msg'=>'Successfully Thresholds Data Saved!!','response_code'=>REST_Controller::HTTP_OK]);
				
			} catch (Exception $e) {
				$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
			}
		}
		
	}

	public function Well_List_post()
	{
		try {
			$result = $this->Device_Threshold_model->getWell_list();
			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function Well_Wise_imeiList_post()
	{
		try {
			$well_id = $this->input->post('well_id',true)!=''?$this->input->post('well_id',true):'';
			$result = $this->Device_Threshold_model->getWell_WiseImei_list($well_id);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function Threshold_DetailsList_post()
	{
		try {
			$well_id = $this->input->post('well_id',true)!=''?$this->input->post('well_id',true):'';
			$imei_no = $this->input->post('imei_no',true)!=''?$this->input->post('imei_no',true):'';
			$result = $this->Device_Threshold_model->getThreshold_LastData_list($well_id,$imei_no);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function Save_ThresholdData_self_flow_post()
	{
		$threshold_type  = $this->input->post('threshold_type',true);
		
		if($this->input->post('threshold_type',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Threshold setup type required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}else{
			try {

				if($threshold_type == 1)
				{
					$site_id = $this->input->post('site_id',true);
					$well_ids = json_decode($this->input->post('well_ids',true));

					if($this->input->post('site_id',true) == '')
					{
						$this->response(['status'=>false,'data'=>[],'msg'=>'site id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}else if($well_ids == '')
					{
						$this->response(['status'=>false,'data'=>[],'msg'=>'well id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);

					}else{

						foreach($well_ids as $value)
						{

							// print_r($well_ids);die;
							$verify = $this->Device_Threshold_model->verifywellExist($value);
							// print_r($serial);die;
							if($verify == 0)
							{
								$details = [];
								$details['well_id'] = $value;
								$details['site_id'] = $this->input->post('site_id',true);
								$details['chp_uppar'] = $this->input->post('chp_uppar',true);
								$details['chp_lower'] = $this->input->post('chp_lower',true);
								$details['abp_uppar'] = $this->input->post('abp_uppar',true);
								$details['abp_lower'] = $this->input->post('abp_lower',true);
								$details['thp_uppar'] = $this->input->post('thp_uppar',true);
								$details['thp_lower'] = $this->input->post('thp_lower',true);
								$details['tht_uppar'] = $this->input->post('tht_uppar',true);	
								$details['tht_lower'] = $this->input->post('tht_lower',true);
			                	$details['c_by'] = $this->input->post('c_by',true);
								$details['c_date'] = date('Y-m-d H:i:s');
								$details['status'] = 1;
								$this->Device_Threshold_model->Save_pressure_Threshold_data($details);

								
								$log = [];
								$log['well_id'] = $value;
								$log['site_id'] = $this->input->post('site_id',true);
								$log['chp_uppar'] = $this->input->post('chp_uppar',true);
								$log['chp_lower'] = $this->input->post('chp_lower',true);
								$log['abp_uppar'] = $this->input->post('abp_uppar',true);
								$log['abp_lower'] = $this->input->post('abp_lower',true);
								$log['thp_uppar'] = $this->input->post('thp_uppar',true);
								$log['thp_lower'] = $this->input->post('thp_lower',true);
								$log['tht_uppar'] = $this->input->post('tht_uppar',true);	
								$log['tht_lower'] = $this->input->post('tht_lower',true);
								$log['c_by'] = $this->input->post('c_by',true);
								$log['c_date'] = date('Y-m-d H:i:s');
								$log['status'] = 1;
								$this->Device_Threshold_model->Save_pressure_Threshold_data_log($log);
							}else{
								
								$log = [];
								$log['well_id'] = $value;
								$log['site_id'] = $this->input->post('site_id',true);
								$log['chp_uppar'] = $this->input->post('chp_uppar',true);
								$log['chp_lower'] = $this->input->post('chp_lower',true);
								$log['abp_uppar'] = $this->input->post('abp_uppar',true);
								$log['abp_lower'] = $this->input->post('abp_lower',true);
								$log['thp_uppar'] = $this->input->post('thp_uppar',true);
								$log['thp_lower'] = $this->input->post('thp_lower',true);
								$log['tht_uppar'] = $this->input->post('tht_uppar',true);	
								$log['tht_lower'] = $this->input->post('tht_lower',true);
								$log['c_by'] = $this->input->post('c_by',true);
								$log['c_date'] = date('Y-m-d H:i:s');
								$log['status'] = 1;
								$this->Device_Threshold_model->Save_pressure_Threshold_data_log($log);

								$l_data = [];
								$l_data['chp_uppar'] = $this->input->post('chp_uppar',true);
								$l_data['chp_lower'] = $this->input->post('chp_lower',true);
								$l_data['abp_uppar'] = $this->input->post('abp_uppar',true);
								$l_data['abp_lower'] = $this->input->post('abp_lower',true);
								$l_data['thp_uppar'] = $this->input->post('thp_uppar',true);
								$l_data['thp_lower'] = $this->input->post('thp_lower',true);
								$l_data['tht_uppar'] = $this->input->post('tht_uppar',true);	
								$l_data['tht_lower'] = $this->input->post('tht_lower',true);
								$l_data['d_by'] = $this->input->post('c_by',true);
								$l_data['d_date'] = date('Y-m-d H:i:s');
								$this->Device_Threshold_model->Update_last_Threshold_self_flowData($l_data,['well_id'=>$value]);
							}				
						}
						$this->response(['status'=>true,'data'=>[],'msg'=>'Successfully Thresholds Data Saved!!','response_code'=>REST_Controller::HTTP_OK]);
						}	
					
				}else{
					   $well_id = $this->input->post('well_id', true);
				        if (empty($well_id)) 
				        {
				            $this->response(['status' => false, 'data' => [], 'msg' => 'well_id required!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
				        }

				        $verify = $this->Device_Threshold_model->verifywellExist($well_id);
				            if($verify == 0)
							{
								$details = [];
								$details['well_id'] = $well_id;
								$details['site_id'] = $this->input->post('site_id',true);
								$details['chp_uppar'] = $this->input->post('chp_uppar',true);
								$details['chp_lower'] = $this->input->post('chp_lower',true);
								$details['abp_uppar'] = $this->input->post('abp_uppar',true);
								$details['abp_lower'] = $this->input->post('abp_lower',true);
								$details['thp_uppar'] = $this->input->post('thp_uppar',true);
								$details['thp_lower'] = $this->input->post('thp_lower',true);
								$details['tht_uppar'] = $this->input->post('tht_uppar',true);	
								$details['tht_lower'] = $this->input->post('tht_lower',true);
			                	$details['c_by'] = $this->input->post('c_by',true);
								$details['c_date'] = date('Y-m-d H:i:s');
								$details['status'] = 1;
								$this->Device_Threshold_model->Save_pressure_Threshold_data($details);

								
								$log = [];
								$log['well_id'] = $well_id;
								$log['site_id'] = $this->input->post('site_id',true);
								$log['chp_uppar'] = $this->input->post('chp_uppar',true);
								$log['chp_lower'] = $this->input->post('chp_lower',true);
								$log['abp_uppar'] = $this->input->post('abp_uppar',true);
								$log['abp_lower'] = $this->input->post('abp_lower',true);
								$log['thp_uppar'] = $this->input->post('thp_uppar',true);
								$log['thp_lower'] = $this->input->post('thp_lower',true);
								$log['tht_uppar'] = $this->input->post('tht_uppar',true);	
								$log['tht_lower'] = $this->input->post('tht_lower',true);
								$log['c_by'] = $this->input->post('c_by',true);
								$log['c_date'] = date('Y-m-d H:i:s');
								$log['status'] = 1;
								$this->Device_Threshold_model->Save_pressure_Threshold_data_log($log);
							}else{
								
								$log = [];
								$log['well_id'] = $well_id;
								$log['site_id'] = $this->input->post('site_id',true);
								$log['chp_uppar'] = $this->input->post('chp_uppar',true);
								$log['chp_lower'] = $this->input->post('chp_lower',true);
								$log['abp_uppar'] = $this->input->post('abp_uppar',true);
								$log['abp_lower'] = $this->input->post('abp_lower',true);
								$log['thp_uppar'] = $this->input->post('thp_uppar',true);
								$log['thp_lower'] = $this->input->post('thp_lower',true);
								$log['tht_uppar'] = $this->input->post('tht_uppar',true);	
								$log['tht_lower'] = $this->input->post('tht_lower',true);
								$log['c_by'] = $this->input->post('c_by',true);
								$log['c_date'] = date('Y-m-d H:i:s');
								$log['status'] = 1;
								$this->Device_Threshold_model->Save_pressure_Threshold_data_log($log);

								$l_data = [];
								$l_data['chp_uppar'] = $this->input->post('chp_uppar',true);
								$l_data['chp_lower'] = $this->input->post('chp_lower',true);
								$l_data['abp_uppar'] = $this->input->post('abp_uppar',true);
								$l_data['abp_lower'] = $this->input->post('abp_lower',true);
								$l_data['thp_uppar'] = $this->input->post('thp_uppar',true);
								$l_data['thp_lower'] = $this->input->post('thp_lower',true);
								$l_data['tht_uppar'] = $this->input->post('tht_uppar',true);
								$l_data['tht_lower'] = $this->input->post('tht_lower',true);
								$l_data['d_by'] = $this->input->post('c_by',true);
								$l_data['d_date'] = date('Y-m-d H:i:s');
								$this->Device_Threshold_model->Update_last_Threshold_self_flowData($l_data,['well_id'=>$well_id]);
							}
							$this->response(['status'=>true,'data'=>[],'msg'=>'Successfully Thresholds Data Saved!!','response_code'=>REST_Controller::HTTP_OK]);	

				}
				
			} catch (Exception $e) {
				$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
			}
		}
		
	}

	public function threshold_setup_details_report_post()
	{
		try {
			$well_id = $this->input->post('well_id',true)!=''?$this->input->post('well_id',true):'';
			$from_date = $this->input->post('from_date',true)!=''?$this->input->post('from_date',true):'';
			$to_date = $this->input->post('to_date',true)!=''?$this->input->post('to_date',true):'';
			$site_id = $this->input->post('site_id',true)!=''?$this->input->post('site_id',true):'';
			$result = $this->Device_Threshold_model->getThreshold_report($well_id,$from_date,$to_date,$site_id);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

}
?>
