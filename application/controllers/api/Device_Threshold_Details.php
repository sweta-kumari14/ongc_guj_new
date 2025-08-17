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

	public function setup_well_thresholdData_post()
	{
		$threshold_type  = $this->input->post('threshold_type',true);
		
		if($this->input->post('threshold_type',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Threshold setup type required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('c_by',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Created required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}else{
			try {

				if($threshold_type == 1)
				{
					$area_id = $this->input->post('area_id',true);
					$site_id = $this->input->post('site_id',true);

					if($this->input->post('area_id',true) == '')
					{
						$this->response(['status'=>false,'data'=>[],'msg'=>'Area required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}elseif($this->input->post('site_id',true) == '')
					{
						$this->response(['status'=>false,'data'=>[],'msg'=>'site id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}elseif($this->input->post('well_data',true) == '')
					{
						$this->response(['status'=>false,'data'=>[],'msg'=>'well Data required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);

					}else{

						$all_well_data = json_decode($this->input->post('well_data', true), true);

						foreach ($all_well_data as $well) {
					    	$well_id   = $well['well_id'];
					    	$tag_data  = $well['node_value'];

						    foreach ($tag_data as $value) {
						        $tag_id     = $value['tag_id'];
						        $node_type  = $value['node_type'];

						        $verify_InactiveData = $this->Device_Threshold_model->verifywll_NotExist_record($well_id,$value['node_type']);
			        	
					        	if($verify_InactiveData > 0)
					        	{
							    	$verifyNode = $this->Device_Threshold_model->delete_existNodeType($well_id, $value['node_type']);

					        	}
					        	
						        $verify = $this->Device_Threshold_model->verifywllExist($well_id, $value['node_type']);

						        // Prepare base data
						        $base_data = [
						            'area_id'     => $area_id,
						            'site_id'     => $site_id,
						            'well_id'     => $well_id,
						            'tag_no'      => $tag_id,
						            'node_name'   => $node_type,
						            'max_value'   => $value['max_value']   ?? null,
						            'upper_value' => $value['upper_value'] ?? null,
						            'lower_value' => $value['lower_value'] ?? null,
						            'multiplier'  => $value['multiplier']  ?? null,
						            'offset'      => $value['offset']      ?? null,
						            'c_by'        => $this->input->post('c_by',true),
						            'c_date'      => date('Y-m-d H:i:s'),
						            'status'      => 1
						        ];

						        // Save log regardless
						        $this->Device_Threshold_model->Save_pressure_Threshold_data_log($base_data);

						        if ($verify == 0) {
						            // Insert new
						            $this->Device_Threshold_model->Save_pressure_Threshold_data($base_data);
						        } else {
						            // Only update if values exist
						            $update_data = [];
						            foreach (['max_value', 'upper_value', 'lower_value', 'multiplier', 'offset'] as $field) {
						                if (isset($value[$field])) {
						                    $update_data[$field] = $value[$field];
						                }
						            }

						            if (!empty($update_data)) {
						                $update_data['d_by']   = $this->input->post('c_by',true);
						                $update_data['d_date'] = date('Y-m-d H:i:s');

						                $this->Device_Threshold_model->Update_last_Threshold_self_flowData(
						                    $update_data,
						                    ['well_id' => $well_id, 'tag_no' => $tag_id,'status'=>1]
						                );
						            }
						        }
						    }
						}

						$this->response(['status' => true,'msg' => 'Successfully Thresholds Data Saved!!','response_code' => REST_Controller::HTTP_OK]);
					}
					
				}else{
				   	$well_id = $this->input->post('well_id', true);

			        if (empty($well_id)) 
			        {
			            $this->response(['status' => false, 'data' => [], 'msg' => 'Well required!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
			        }elseif ($this->input->post('threshold_data', true) =='') 
			        {
			            $this->response(['status' => false, 'data' => [], 'msg' => 'Thresold Data required!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
			        }

				   	$thresholdData = json_decode($this->input->post('threshold_data', true),TRUE);

					foreach ($thresholdData as $key => $value) 
					{

			        	$verify_InactiveData = $this->Device_Threshold_model->verifywll_NotExist_record($well_id,$value['node_type']);

			        	if($verify_InactiveData > 0)
			        	{
					    	$verifyNode = $this->Device_Threshold_model->delete_existNodeType($well_id, $value['node_type']);

			        	}

			        	$verify = $this->Device_Threshold_model->verifywllExist($well_id,$value['node_type']);

					    if($verify == 0)
					    {
					        $details = [];
					        $details['well_id'] = $well_id;
					        $details['area_id'] = $this->input->post('area_id',true);
					        $details['site_id'] = $this->input->post('site_id',true);
					        $details['tag_no'] = $value['tag_id'];
					        $details['node_name'] = $value['node_type'];
					        $details['max_value'] = $value['max_value'] ?? '0';
					        $details['upper_value'] = $value['upper_value'] ?? '0';
					        $details['lower_value'] = $value['lower_value'] ?? '0';
					        $details['multiplier'] = $value['multiplier'] ?? '0';
					        $details['offset'] = $value['offset'] ?? '0';
					        $details['c_by'] = $this->input->post('c_by',true);
					        $details['c_date'] = date('Y-m-d H:i:s');
					        $details['status'] = 1;

					        $this->Device_Threshold_model->Save_pressure_Threshold_data($details);
					        $this->Device_Threshold_model->Save_pressure_Threshold_data_log($details);

					    } else {

					       	$existing = $this->Device_Threshold_model->get_existing_threshold($value['tag_id'], $well_id);

					        $log = [];
					        $log['well_id']      = $well_id;
					        $log['area_id']      = $this->input->post('area_id',true);
					        $log['site_id']      = $this->input->post('site_id',true);
					        $log['tag_no']       = $value['tag_id'];
					        $log['node_name']    = $value['node_type'];
					        $log['max_value']   = isset($value['max_value']) ? $value['max_value'] : $existing['max_value'];
							$log['upper_value'] = isset($value['upper_value']) ? $value['upper_value'] : $existing['upper_value'];
							$log['lower_value'] = isset($value['lower_value']) ? $value['lower_value'] : $existing['lower_value'];
							$log['multiplier']  = isset($value['multiplier']) ? $value['multiplier'] : $existing['multiplier'];
							$log['offset']      = isset($value['offset']) ? $value['offset'] : $existing['offset'];
					        $log['c_by']         = $this->input->post('c_by',true);
					        $log['c_date']       = date('Y-m-d H:i:s');
					        $log['status']       = 1;

					        $this->Device_Threshold_model->Save_pressure_Threshold_data_log($log);

					        // Only update the fields that are actually present
					        $l_data = [];
					        $allowed_fields = ['max_value', 'upper_value', 'lower_value', 'multiplier', 'offset'];
					        foreach ($allowed_fields as $field) {
					            if (isset($value[$field])) {
					                $l_data[$field] = $value[$field];
					            }
					        }

					        $l_data['d_by']   = $this->input->post('c_by',true);
					        $l_data['d_date'] = date('Y-m-d H:i:s');

					        if (!empty($l_data)) {
					            $this->Device_Threshold_model->Update_last_Threshold_self_flowData(
					                $l_data,
					                ['well_id' => $well_id, 'tag_no' => $value['tag_id'],'status'=>1]
					            );
					        }
					    }
					}

					$this->response(['status' => true,'data' => [],'msg' => 'Successfully Thresholds Data Saved!!','response_code' => REST_Controller::HTTP_OK]);

				}
				
			} catch (Exception $e) {
				$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
			}
		}
		
	}

	public function Last_threshold_dataList_post()
	{
		try {

			$well_id = $this->input->post('well_id',true)!=''?$this->input->post('well_id',true):'';
			$node_type = $this->input->post('node_type',true)!=''?$this->input->post('node_type',true):'';
			$tag_no = $this->input->post('tag_no',true)!=''?$this->input->post('tag_no',true):'';
			
			$result = $this->Device_Threshold_model->getwell_lastThreshold_list($well_id,$node_type,$tag_no);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function well_threshold_setup_report_post()
	{
		try {

			$area_id = $this->input->post('area_id',true)!=''?$this->input->post('area_id',true):'';
			$site_id = $this->input->post('site_id',true)!=''?$this->input->post('site_id',true):'';
			$well_id = $this->input->post('well_id',true)!=''?$this->input->post('well_id',true):'';
			$from_date = $this->input->post('from_date',true)!=''?$this->input->post('from_date',true):'';
			$to_date = $this->input->post('to_date',true)!=''?$this->input->post('to_date',true):'';

			$result = $this->Device_Threshold_model->getwellThreshold_setup_report($area_id,$site_id,$well_id,$from_date,$to_date);

			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

}
?>
