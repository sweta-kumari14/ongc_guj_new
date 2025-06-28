<?php
require APPPATH.'libraries/REST_Controller.php';
class Daily_Runniny_Report extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Daily_Running_Report_model');
	}

	public function Device_WellRunning_Details_post()
	{
		try {
			$well_id = $this->input->post('well_id',true)!=""?$this->input->post('well_id',true):"";
			$from_date = $this->input->post('from_date',true)!=""?$this->input->post('from_date',true):"";
			$to_date = $this->input->post('to_date',true)!=""?$this->input->post('to_date',true):"";
			$site_id = $this->input->post('site_id',true)!=""?$this->input->post('site_id',true):"";
			$sort_by = $this->input->post('sort_by',true)!=""?$this->input->post('sort_by',true):"";
			$feeder_id = $this->input->post('feeder_id',true)!=""?$this->input->post('feeder_id',true):"";
			$result = $this->Daily_Running_Report_model->getRunning_DeviceWell_Details($well_id,$from_date,$to_date,$site_id,$sort_by,$feeder_id);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}



	public function Datewise_WellRunning_Details_post()
	{
		try {
			
			$date = $this->input->post('date',true)!=""?$this->input->post('date',true):"";
			$site_id = $this->input->post('site_id',true)!=""?$this->input->post('site_id',true):"";
			$sort_by = $this->input->post('sort_by',true)!=""?$this->input->post('sort_by',true):"";
			$feeder_id = $this->input->post('feeder_id',true)!=""?$this->input->post('feeder_id',true):"";
			$result = $this->Daily_Running_Report_model->Date_wiseRunning_DeviceWell_Details($date,$site_id,$sort_by,$feeder_id);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function Datewise_WellRunning_self_flow_Details_post()
	{
		try {
			
			$date = $this->input->post('date',true)!=""?$this->input->post('date',true):"";
			$site_id = $this->input->post('site_id',true)!=""?$this->input->post('site_id',true):"";
			$result = $this->Daily_Running_Report_model->Date_wiseRunning_self_flow_Well_Details($date,$site_id);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function well_commulative_self_flow_log_post()
	{
		try {
			
			$from_date = $this->input->post('from_date',true)!=""?$this->input->post('from_date',true):"";
			$to_date = $this->input->post('to_date',true)!=""?$this->input->post('to_date',true):"";
			$well_id = $this->input->post('well_id',true)!=""?$this->input->post('well_id',true):"";
			$site_id = $this->input->post('site_id',true)!=""?$this->input->post('site_id',true):"";
			$result = $this->Daily_Running_Report_model->well_commulative_self_flow_log_report($well_id,$from_date,$to_date,$site_id);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function Well_Comulative_log_Report_post()
	{
		try{
		    $well_id = $this->input->post('well_id',true)!=""?$this->input->post('well_id',true):"";
			$from_date = $this->input->post('from_date',true)!=""?$this->input->post('from_date',true):"";
			$to_date = $this->input->post('to_date',true)!=""?$this->input->post('to_date',true):"";
			$site_id = $this->input->post('site_id',true)!=""?$this->input->post('site_id',true):"";
			$sort_by = $this->input->post('sort_by',true)!=""?$this->input->post('sort_by',true):"";
			$feeder_id = $this->input->post('feeder_id',true)!=""?$this->input->post('feeder_id',true):"";
			$result = $this->Daily_Running_Report_model->well_comulative_logreport($well_id,$from_date,$to_date,$site_id,$sort_by,$feeder_id);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	
	public function Well_running_Period_wiselog_report_post()
	{
		try {
			$site_id = $this->input->post('site_id',true)!=''?$this->input->post('site_id',true):'';
			$well_id = $this->input->post('well_id',true)!=''?$this->input->post('well_id',true):'';
			$from_date = $this->input->post('from_date',true)!=''?$this->input->post('from_date',true):'';
			$to_date = $this->input->post('to_date',true)!=''?$this->input->post('to_date',true):'';
			$sort_by = $this->input->post('sort_by',true)!=''?$this->input->post('sort_by',true):'';
			$feeder_id = $this->input->post('feeder_id',true)!=""?$this->input->post('feeder_id',true):"";
			$result = $this->Daily_Running_Report_model->well_runningperoid_logreport($site_id,$well_id,$from_date,$to_date,$sort_by,$feeder_id);
			
           $this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function Device_Max_Min_Value_post()
	{
		try {
			
			$well_id = $this->input->post('well_id',true)!=""?$this->input->post('well_id',true):"";
			$date = $this->input->post('date',true)!=""?$this->input->post('date',true):"";
			$user_id = $this->input->post('user_id',true)!=""?$this->input->post('user_id',true):"";
			$result = $this->Daily_Running_Report_model->Date_Max_MinValue_Details($well_id,$date,$user_id);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function Device_Max_Min_Value_for_mobile_post()
	{
		try {
			
			$well_id = $this->input->post('well_id',true)!=""?$this->input->post('well_id',true):"";
			$date = $this->input->post('date',true)!=""?$this->input->post('date',true):"";
			$user_id = $this->input->post('user_id',true)!=""?$this->input->post('user_id',true):"";
			$result = $this->Daily_Running_Report_model->Date_Max_MinValue_Details_for_mobile($well_id,$date,$user_id);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function Monthly_Running_All_Type_Graph_post()
	{
		try{
	        $well_id = $this->input->post('well_id',true)!=""?$this->input->post('well_id',true):"";
	        $month_id = $this->input->post('month_id',true)!=""?$this->input->post('month_id',true):"";
	        $year = $this->input->post('year',true)!=""?$this->input->post('year',true):"";
	        $graph_type = $this->input->post('graph_type',true)!=""?$this->input->post('graph_type',true):"";
	        $site_id = $this->input->post('site_id',true)!=""?$this->input->post('site_id',true):"";

	     
	        if($this->input->post('graph_type',true)!='')
	        {
	        	if($graph_type == 1)
	        	{

	               $result = $this->Daily_Running_Report_model->running_log_energy_details($well_id,$month_id,$year,$site_id);

	            }elseif($graph_type == 2)
	            {
	            	$result = $this->Daily_Running_Report_model->running_logdetails($well_id,$month_id,$year,$site_id);
	            }elseif($graph_type == 3)
	            {
	            	$result = $this->Daily_Running_Report_model->energy_consumption_details($well_id,$month_id,$year,$site_id);
	            }elseif($graph_type == 4)
	            {
	            	$result = $this->Daily_Running_Report_model->Running_shutdown_details($well_id,$month_id,$year,$site_id);
	            }elseif($graph_type == 5)
	            {
	            	$result = $this->Daily_Running_Report_model->well_performance_details($well_id,$month_id,$year,$site_id);
	            }
	        }
	        
	        $this->response(['status' => true, 'data' => $result, 'msg' => 'Successfully fetched!!', 'response_code' => REST_Controller::HTTP_OK]);
	    } catch (Exception $e) {
	        $this->response(['status' => false, 'data' => [], 'msg' => 'something went wrong!!', 'response_code' => REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
	    }
	}

	public function Financial_year_Running_All_Type_Graph_post()
	{
		try{
	        $well_id = $this->input->post('well_id',true)!=""?$this->input->post('well_id',true):"";
	        $fin_year = $this->input->post('fin_year',true)!=''?$this->input->post('fin_year',true):'';
	        $site_id = $this->input->post('site_id',true)!=""?$this->input->post('site_id',true):"";

	        $graph_type = $this->input->post('graph_type',true)!=""?$this->input->post('graph_type',true):"";

	        $result = [];
	        if($this->input->post('graph_type',true)!='')
	        {
	        	if($graph_type == 1)
	            {
	            	$result = $this->Daily_Running_Report_model->fin_running_logdetails($well_id,$fin_year,$site_id);
	            }elseif($graph_type == 2)
	            {
	            	$result = $this->Daily_Running_Report_model->fin_energy_consumption_details($well_id,$fin_year,$site_id);
	            }elseif($graph_type == 3)
	            {
	            	$result = $this->Daily_Running_Report_model->fin_Running_shutdown_details($well_id,$fin_year,$site_id);
	            }elseif($graph_type == 4)
	            {
	            	$result = $this->Daily_Running_Report_model->fin_well_performance_details($well_id,$fin_year,$site_id);
	            }
	        }
	        
	        $this->response(['status' => true, 'data' => $result, 'msg' => 'Successfully fetched!!', 'response_code' => REST_Controller::HTTP_OK]);
	    } catch (Exception $e) {
	        $this->response(['status' => false, 'data' => [], 'msg' => 'something went wrong!!', 'response_code' => REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
	    }
	}


	public function Device_mis_log_data_post()
	{
		try {
			
			$imei_no = $this->input->post('imei_no',true)!=""?$this->input->post('imei_no',true):"";
			$from_date = $this->input->post('from_date',true)!=""?$this->input->post('from_date',true):"";
			$to_date = $this->input->post('to_date',true)!=""?$this->input->post('to_date',true):"";
			$result = $this->Daily_Running_Report_model->Device_mis_log_report($imei_no,$from_date,$to_date);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function Monthly_running_line_graph_post()
	{
		try {
	        
	        $well_id = $this->input->post('well_id',true)!=""?$this->input->post('well_id',true):"";
	        $month_id = $this->input->post('month_id',true)!=""?$this->input->post('month_id',true):"";
	        $year = $this->input->post('year',true)!=""?$this->input->post('year',true):"";
	        $site_id = $this->input->post('site_id',true)!=""?$this->input->post('site_id',true):"";

	        $graph_type = $this->input->post('graph_type',true)!=""?$this->input->post('graph_type',true):"";

	        $result = [];
	        if($this->input->post('graph_type',true)!='')
	        {
	        	if($graph_type == 1)
	            {
	            	$result = $this->Daily_Running_Report_model->running_logdetails_linegraph($well_id,$month_id,$year,$site_id);
	            }elseif($graph_type == 2)
	            {
	            	$result = $this->Daily_Running_Report_model->energy_consumption_details_linegraph($well_id,$month_id,$year,$site_id);
	            }elseif($graph_type == 3)
	            {
	            	$result['running_shutdown'] = $this->Daily_Running_Report_model->Running_shutdown_details_linegraph($well_id,$month_id,$year,$site_id);
	            }elseif($graph_type == 4)
	            {
	            	$result['well_performance'] = $this->Daily_Running_Report_model->well_performance_details_linegraph($well_id,$month_id,$year,$site_id);
	            }
	        }
	        
	        $this->response(['status' => true, 'data' => $result, 'msg' => 'Successfully fetched!!', 'response_code' => REST_Controller::HTTP_OK]);
	    } catch (Exception $e) {
	        $this->response(['status' => false, 'data' => [], 'msg' => 'something went wrong!!', 'response_code' => REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
	    }
	      
	}

	public function Financial_year_Running_Line_Graph_post()
	{
		try{
	        $well_id = $this->input->post('well_id',true)!=""?$this->input->post('well_id',true):"";
	        $fin_year = $this->input->post('fin_year',true)!=''?$this->input->post('fin_year',true):'';
	        $site_id = $this->input->post('site_id',true)!=""?$this->input->post('site_id',true):"";

	        $graph_type = $this->input->post('graph_type',true)!=""?$this->input->post('graph_type',true):"";

	        $result = [];
	        if($this->input->post('graph_type',true)!='')
	        {
	        	if($graph_type == 1)
	            {
	            	$result = $this->Daily_Running_Report_model->fin_running_logdetails_linegraph($well_id,$fin_year,$site_id);
	            }elseif($graph_type == 2)
	            {
	            	 $result = $this->Daily_Running_Report_model->fin_energy_consumption_details_linegraph($well_id,$fin_year,$site_id);
	            }elseif($graph_type == 3)
	            {
	            	$result['running_shutdown']  = $this->Daily_Running_Report_model->fin_Running_shutdown_details_linegraph($well_id,$fin_year,$site_id);
	            }elseif($graph_type == 4)
	            {
	            	$result['well_performance'] = $this->Daily_Running_Report_model->fin_well_performance_details_linegraph($well_id,$fin_year,$site_id);
	            }
	        }
	        
	        $this->response(['status' => true, 'data' => $result, 'msg' => 'Successfully fetched!!', 'response_code' => REST_Controller::HTTP_OK]);
	    } catch (Exception $e) {
	        $this->response(['status' => false, 'data' => [], 'msg' => 'something went wrong!!', 'response_code' => REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
	    }
	}

	public function device_mis_ime_no_list_post()
	{
		try {

			 $imei_no = $this->input->post('imei_no',true)!=""?$this->input->post('imei_no',true):"";
			 $result = $this->Daily_Running_Report_model->ime_no_list_get($imei_no);
			  $this->response(['status' => true, 'data' => $result, 'msg' => 'Successfully fetched!!', 'response_code' => REST_Controller::HTTP_OK]);


		}catch (Exception $e) {
	        $this->response(['status' => false, 'data' => [], 'msg' => 'something went wrong!!', 'response_code' => REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
	    }
	}
}
?>