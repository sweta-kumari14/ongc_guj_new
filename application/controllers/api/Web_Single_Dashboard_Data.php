<?php
require APPPATH.'libraries/REST_Controller.php';
class Web_Single_Dashboard_Data extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Web_Single_dashboardData_model');
	}

	public function Well_Single_Dashboard_Details_post()
	{
	    try {
	        $well_id = $this->input->post('well_id', true) ?: '';
	        $imei_no = $this->input->post('imei_no', true) ?: '';
	        $hours = $this->input->post('hours', true) ?: '';			
				
	        $result = [];

	        $result['single_welldevice_data'] = $this->Web_Single_dashboardData_model->Single_Well_DeviceData($well_id,$imei_no);

	        $result['well_alert_details'] = $this->Web_Single_dashboardData_model->WellAlert_Details($well_id,$imei_no);

	        $result['total_alert'] = $this->Web_Single_dashboardData_model->Well_WiseTotal_Alert($well_id,$imei_no);
	        $result['today_running_device'] = $this->Web_Single_dashboardData_model->getRunning_Device($well_id,$imei_no);

	        $result['total_running_device'] = $this->Web_Single_dashboardData_model->get_total_Running_Device($well_id,$imei_no);

	         $result['forcasting_data'] = $this->Web_Single_dashboardData_model->getForcasting_data($well_id);
	       
	        $this->response(['status' => true, 'data' => $result, 'msg' => 'Successfully fetched!!', 'response_code' => REST_Controller::HTTP_OK]);
	    } catch (Exception $e) {
	        $this->response(['status' => false, 'data' => [], 'msg' => 'something went wrong!!', 'response_code' => REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
	    }
	}

	public function get_Alltype_Single_graphData_post()
	{
		try {
	        $well_id = $this->input->post('well_id', true) ?: '';
	        $imei_no = $this->input->post('imei_no', true) ?: '';
	        $hours = $this->input->post('hours', true) ?: '';			
	        $grapg_type = $this->input->post('grapg_type',true);		
				
	        $result = [];
	        if($this->input->post('grapg_type',true)!='')
	        {
	        	if($grapg_type == 1)
	        	{
	        		$result['output_neutral_voltage'] = $this->Web_Single_dashboardData_model->OutPut_Neutral_Voltage($well_id,$imei_no,$hours);
	        	}elseif($grapg_type == 3) 
		        {
		        	$result['output_line_voltage'] = $this->Web_Single_dashboardData_model->OutputLine_to_Line_Voltage($well_id,$imei_no,$hours);
		        }elseif($grapg_type == 5)
	        	{
		        	$result['output_current'] = $this->Web_Single_dashboardData_model->WellOutput_Current($well_id,$imei_no,$hours);
		        }elseif($grapg_type == 2)
	        	{
		        	$result['battery_voltage'] = $this->Web_Single_dashboardData_model->battery_voltage($well_id,$imei_no,$hours);
		        }elseif($grapg_type == 4)
	        	{
		        	$result['smps_voltage'] = $this->Web_Single_dashboardData_model->smps_voltage($well_id,$imei_no,$hours);
		        }
	        
	        }
	        
	        $this->response(['status' => true, 'data' => $result, 'msg' => 'Successfully fetched!!', 'response_code' => REST_Controller::HTTP_OK]);
	    } catch (Exception $e) {
	        $this->response(['status' => false, 'data' => [], 'msg' => 'something went wrong!!', 'response_code' => REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
	    }
	}

	
	  public function well_sheduling_details_post()
	  {
	  	try{

	  		$well_id = $this->input->post('well_id',true);

	  		if($this->input->post('well_id',true) == '')
            {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Well Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
            }else{

              $result = $this->Web_Single_dashboardData_model->get_well_sheduling_details($well_id);
              if(empty($result))
              {
              	$this->response(['status'=>false,'data'=>[],'msg'=>'No Record Found!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
              }else{
              	$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
              }

			
		   }
			}catch (Exception $e) {
				$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
			}
	  }
}
?>
