<?php
require APPPATH.'libraries/REST_Controller.php';
class Web_Single_Selfflow_Dashboard_Data extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Web_Single_Selfflow_dashboardData_model');
	}

	public function get_Alltype_Single_graphData_post()
	{
		try {
	        $well_id = $this->input->post('well_id', true) ?: '';
	  	    $from_date = $this->input->post('from_date',true);	
	  	    $to_date = $this->input->post('to_date',true);	
	        $graph_type = $this->input->post('graph_type',true);		
				
	        $result = [];
	        if($this->input->post('graph_type',true)!='')
	        {
		        	if($graph_type == 1)
		        	{
		        		$result['Output_pressure'] = $this->Web_Single_Selfflow_dashboardData_model->OutPut_graph($well_id,$from_date,$to_date);
		          }
	        }
	        
	        $this->response(['status' => true, 'data' => $result, 'msg' => 'Successfully fetched!!', 'response_code' => REST_Controller::HTTP_OK]);
	    } catch (Exception $e) {
	        $this->response(['status' => false, 'data' => [], 'msg' => 'something went wrong!!', 'response_code' => REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
	    }
	}
 


		public function Well_Single_Dashboard_Details_post()
	{
	    try {
	        $well_id = $this->input->post('well_id', true);
	        if($this->input->post('well_id', true) == '')
	        {
	        	$this->response(['status' => true, 'data' =>[], 'msg' => 'Well required!!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
	        }else{
	        	     $result = [];

	               $result['single_welldevice_data'] = $this->Web_Single_Selfflow_dashboardData_model->Single_Well_DeviceData($well_id);

	              $result['well_alert_details'] = $this->Web_Single_Selfflow_dashboardData_model->WellAlert_Details($well_id);
//
	              $result['total_alert'] = $this->Web_Single_Selfflow_dashboardData_model->Well_WiseTotal_Alert($well_id);

	               $result['pressure_daily_avg'] = $this->Web_Single_Selfflow_dashboardData_model->Well_wise_daily_avg($well_id);

	               $result['pressure_monthly_avg'] = $this->Web_Single_Selfflow_dashboardData_model->Well_wise_monthly_avg($well_id);
	             //  $result['command_update'] = $this->Web_Single_Selfflow_dashboardData_model->command_update($well_id);


	               $this->response(['status' => true, 'data' => $result, 'msg' => 'Successfully fetched!!', 'response_code' => REST_Controller::HTTP_OK]);

	        }
	     
	    } catch (Exception $e) { 
	        $this->response(['status' => false, 'data' => [], 'msg' => 'something went wrong!!', 'response_code' => REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
	    }
	}
}
?>