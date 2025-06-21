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
					$details['out_current_lt'] = $this->input->post('out_current_lt',true);
										
					
										
					
										
					$details['cby'] = $this->input->post('c_by',true);
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

}
?>
