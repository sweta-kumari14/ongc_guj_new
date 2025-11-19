<?php
require APPPATH.'libraries/REST_Controller.php';
class  Device_configration_setup extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Device_configration_setup_model');
	}

	
    public function device_List_post()
	{
		try {
			
			$company_id = $this->input->post('company_id',true)!=""?$this->input->post('company_id',true):"";
			$result = $this->Device_configration_setup_model->device_installList($company_id);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		} 
	}


	public function well_details_for_configration_setup_post()
	{
		try {
			
			$company_id = $this->input->post('company_id',true)!=""?$this->input->post('company_id',true):"";
			$imei_no = $this->input->post('imei_no',true)!=""?$this->input->post('imei_no',true):"";
			$result = $this->Device_configration_setup_model->get_well_details_for_configration($company_id,$imei_no);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		} 
	}

	public function well_details_threshold_details_post()
	{
		try {
			
			$company_id = $this->input->post('company_id',true)!=""?$this->input->post('company_id',true):"";
			
			$well_id = $this->input->post('well_id',true)!=""?$this->input->post('well_id',true):"";
			$result = $this->Device_configration_setup_model->get_well_details_threshold($company_id,$well_id);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		} 
	}

	
	public function well_preview_jason_details_post()
	{
		try {
			
			$company_id = $this->input->post('company_id',true)!=""?$this->input->post('company_id',true):"";
			$imei_no = $this->input->post('imei_no',true)!=""?$this->input->post('imei_no',true):"";
			$well_id = $this->input->post('well_id',true)!=""?$this->input->post('well_id',true):"";
			$result = $this->Device_configration_setup_model->get_well_details_for_preview_jason($company_id,$well_id,$imei_no);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		} 
	}


	public function update_configration_post()
	{
        
		if ($this->input->post('well_id', true) =='') 
	    {
			$this->response(['status' => false, 'data' => [], 'msg' => 'Well required!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
	    }elseif ($this->input->post('area_id', true) =='') 
	    {
			$this->response(['status' => false, 'data' => [], 'msg' => 'Area required!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
	    }elseif ($this->input->post('site_id', true) =='') 
	    {
			$this->response(['status' => false, 'data' => [], 'msg' => 'Site required!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
	    }elseif ($this->input->post('threshold_data', true) =='') 
	    {
			$this->response(['status' => false, 'data' => [], 'msg' => 'Thresold Data required!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
	    }
		try {

			    $thresholdData = json_decode($this->input->post('threshold_data', true), TRUE);

			foreach ($thresholdData as $key => $value) 
			{

			    $details = [];
			    $details['max_value']   = $value['max_value']   ?? '0';
			    $details['upper_value'] = $value['upper_value'] ?? '0';
			    $details['lower_value'] = $value['lower_value'] ?? '0';
			    $details['multiplier']  = $value['multiplier']  ?? '0';
			    $details['offset']      = $value['offset']      ?? '0';
			  
			    $details['d_by']        = $this->input->post('c_by', true);
			    $details['d_date']      = date('Y-m-d H:i:s');

			    $where = [
			        'id'           => $value['id'],
			        'component_id' => $value['component_id'],
			        'tag_no'       => $value['tag_number']
			    ];
			    $this->Device_configration_setup_model->Update_Threshold_data($details, $where);
			    $log = $details;
			    $log['area_id'] = $this->input->post('area_id',true);
			    $log['site_id'] = $this->input->post('site_id',true);
			    $log['well_id'] = $this->input->post('well_id',true);
			    $log['tag_no']       = $value['tag_number'];
			    $log['component_id'] = $value['component_id'];
			    $log['setup_type']   = 3;
			    $log['c_by']         = $this->input->post('c_by',true);
			    $log['c_date']       = date('Y-m-d H:i:s');
			    $log['status']       = 1;

			    $this->Device_configration_setup_model->Save_pressure_Threshold_data_log($log);
			}

            $this->response(['status'=>true,'data'=>[],'msg'=>'Well Configuration update Successfully!', 'response_code'=>REST_Controller::HTTP_OK]);


			
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		} 
	}

	public function update_device_configration_post()
	{
		$imei_no = $this->input->post('imei_no',true);
        $device_name = $this->input->post('device_name',true);
        $node_scan_time = $this->input->post('node_scan_time',true);
        $node_log_time = $this->input->post('node_log_time',true);
        $gateway_log_time = $this->input->post('gateway_log_time',true);
        $d_by = $this->input->post('d_by',true);
        
        if($this->input->post('imei_no',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'IMEI required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('device_name',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Device required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('node_scan_time',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Node scan time required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('node_log_time',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Node Log time required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('gateway_log_time',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Gate way Log time required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('d_by',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Updated By required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}else{
			try 
			{	
				$IMEI = $this->Device_configration_setup_model->verify_ImeitExist_OrNot($this->input->post('imei_no',true));
				if($IMEI > 0)
				{
					
					$data = [];
					$data['node_scan_time'] = $this->input->post('node_scan_time',true);
					$data['node_log_time'] = $this->input->post('node_log_time',true);
					$data['gateway_log_time'] = $this->input->post('gateway_log_time',true);
					$data['d_by'] = $this->input->post('d_by',true);
					$data['d_date'] = date('Y-m-d H:i:s');
					$data['status'] = 1;
					$this->Device_configration_setup_model->Update_DeviceData($data,['imei_no'=>$this->input->post('imei_no',true)]);

					$log = [];
					$log['device_name'] = $this->input->post('device_name',true);
					$log['imei_no'] = $this->input->post('imei_no',true);
					$log['node_scan_time'] = $this->input->post('node_scan_time',true);
					$log['node_log_time'] = $this->input->post('node_log_time',true);
					$log['gateway_log_time'] = $this->input->post('gateway_log_time',true);
					$log['setup_type'] = 2;
					$log['d_by'] = $this->input->post('d_by',true);
					$log['d_date'] = date('Y-m-d H:i:s');
					$log['status'] = 1;

					$this->Device_configration_setup_model->Insert_DeviceData($log);

					$this->response(['status'=>true,'data'=>[],'msg'=>'Device Configration successfully updated!!','response_code'=>REST_Controller::HTTP_OK]);
							
				}else{
					$this->response(['status'=>false,'data'=>[],'msg'=>'Device Already Exist!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					
				}	
        	
			}catch (Exception $e){
				$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
			}
		}
	}
	
}
?>