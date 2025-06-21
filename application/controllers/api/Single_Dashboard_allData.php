<?php
require APPPATH.'libraries/REST_Controller.php';
class Single_Dashboard_allData extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Single_dashboard_AllData_model');
	}

	public function Well_All_Dashboard_Details_post()
	{
	    try {
	        $well_id = $this->input->post('well_id', true) ?: '';
	        $imei_no = $this->input->post('imei_no', true) ?: '';
	        $hours = $this->input->post('hours', true) ?: '';			
				
	        $result = [];

	        $result['single_welldevice_data'] = $this->Single_dashboard_AllData_model->Single_Well_DeviceData($well_id, $imei_no);
	        $result['well_alert_details'] = $this->Single_dashboard_AllData_model->WellAlert_Details($well_id, $imei_no);
	        $result['total_alert'] = $this->Single_dashboard_AllData_model->Well_WiseTotal_Alert($well_id, $imei_no);
	        $result['frequency'] = $this->Single_dashboard_AllData_model->WellFrequency_Details($well_id,$imei_no,$hours);
	        $result['active_energy'] = $this->Single_dashboard_AllData_model->Well_Active_EnergyDetails($well_id,$imei_no,$hours);

	       $result['output_neutral_voltage'] = $this->Single_dashboard_AllData_model->OutPut_Neutral_Voltage($well_id,$imei_no,$hours);
	       
	        $result['output_line_voltage'] = $this->Single_dashboard_AllData_model->OutputLine_to_Line_Voltage($well_id,$imei_no,$hours);
	       
	        $result['output_current'] = $this->Single_dashboard_AllData_model->WellOutput_Current($well_id,$imei_no,$hours);
	        $result['active_power'] = $this->Single_dashboard_AllData_model->Well_Active_power($well_id,$imei_no,$hours);
	        

	        $this->response(['status' => true, 'data' => $result, 'msg' => 'Successfully fetched!!', 'response_code' => REST_Controller::HTTP_OK]);
	    } catch (Exception $e) {
	        $this->response(['status' => false, 'data' => [], 'msg' => 'something went wrong!!', 'response_code' => REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
	    }
	}

	

	public function Device_Running_Details_post()
	{
		try {
			$well_id = $this->input->post('well_id',true)!=""?$this->input->post('well_id',true):"";
			$imei_no = $this->input->post('imei_no',true)!=""?$this->input->post('imei_no',true):"";
			$from_date = $this->input->post('from_date',true)!=""?$this->input->post('from_date',true):"";
			$to_date = $this->input->post('to_date',true)!=""?$this->input->post('to_date',true):"";
			
			$result = $this->Single_dashboard_AllData_model->getRunning_Device_Details($well_id,$imei_no,$from_date,$to_date);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) 
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}


	  public function well_shiftingdetails_throughwell_id_post()
	  {

	  	try{

             $well_id = $this->input->post('well_id',true);
	         $result = $this->Single_dashboard_AllData_model->get_wellwise_log($well_id);

			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		}catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	  }


}
?>
