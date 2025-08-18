<?php
require APPPATH.'libraries/REST_Controller.php';
class Selfflow_report extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('selfflow_report_model');
	}


	// public function Date_Wise_Alert_Report_post()
	// {
	// 	try {
			
	// 		   $well_id = $this->input->post('well_id',true)!=''?$this->input->post('well_id',true):'';			
	// 		   $date = $this->input->post('date',true)!=''?$this->input->post('date',true):'';	
	// 		   $result = $this->selfflow_report_model->date_wise_Alert_Report($well_id,$date);

	// 		  $this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
	// 	} catch (Exception $e) {
	// 		$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
	// 	}
	// }

	// public function Well_wise_Alert_Report_post()
	// {
	// 	try {
			
	// 		$well_id = $this->input->post('well_id',true)!=''?$this->input->post('well_id',true):'';
				
	// 		$from_date = $this->input->post('from_date',true)!=''?$this->input->post('from_date',true):'';	
	// 		$to_date = $this->input->post('to_date',true)!=''?$this->input->post('to_date',true):'';
	// 		$user_id = $this->input->post('user_id',true)!=""?$this->input->post('user_id',true):"";
	// 		$sort_by = $this->input->post('sort_by',true)!=""?$this->input->post('sort_by',true):"";
	// 		$result = $this->selfflow_report_model->Well_wise_Alert_Report($well_id,$from_date,$to_date,$user_id,$sort_by);

	// 		$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
	// 	} catch (Exception $e) {
	// 		$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
	// 	}
	// }

	// public function Well_Wise_Count_post()
	// {
	// 	try {
			
	// 		$well_id = $this->input->post('well_id',true)!=''?$this->input->post('well_id',true):'';
	// 		$imei_no = $this->input->post('imei_no',true)!=''?$this->input->post('imei_no',true):'';	
			
	// 		$result = [];
	// 		$result['total_alert'] = $this->selfflow_report_model->Well_Wise_Total_Alert($well_id,$imei_no);

	// 		$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
	// 	} catch (Exception $e) {
	// 		$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
	// 	}
	// }

	public function Historial_data_Mis_Report_post()
	{
		try {
			
			$well_id = $this->input->post('well_id',true)!=''?$this->input->post('well_id',true):'';
			$from_date = $this->input->post('from_date',true)!=''?$this->input->post('from_date',true):'';
			$to_date = $this->input->post('to_date',true)!=''?$this->input->post('to_date',true):'';
			$result = $this->selfflow_report_model->HistoricalDataMis_Report($well_id,$from_date,$to_date);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function Historical_All_Type_Graph_post()
	{
	    try {
	        $well_ids = json_decode($this->input->post('well_id', true), true);
	        $components = json_decode($this->input->post('components', true), true);
	        $from_date = $this->input->post('from_date', true);
	        $to_date = $this->input->post('to_date', true);

	        $result = [];

	        if (!empty($components) && !empty($well_ids)) {
	            foreach ($well_ids as $well_id) {
	                foreach ($components as $component) {
	                    switch (strtolower($component)) {
	                        case 'chp':
	                            $result[$well_id]['output_chp'] = $this->selfflow_report_model->OutPut_historical_chp($well_id, $from_date, $to_date);
	                            break;
	                        case 'abp':
	                            $result[$well_id]['output_abp'] = $this->selfflow_report_model->Output_His_abp($well_id, $from_date, $to_date);
	                            break;
	                        case 'thp':
	                            $result[$well_id]['output_thp'] = $this->selfflow_report_model->Output_His_thp($well_id, $from_date, $to_date);
	                            break;
	                        case 'flt':
	                            $result[$well_id]['output_flt'] = $this->selfflow_report_model->Output_His_FLT($well_id, $from_date, $to_date);
	                            break;
	                        case 'battery':
	                            $result[$well_id]['output_battery'] = $this->selfflow_report_model->output_His_battery($well_id, $from_date, $to_date);
	                            break;
	                        default:
	                            // Optionally: log invalid component
	                            break;
	                    }
	                }
	            }
	        }

	        $this->response(['status' => true,'data' => $result,'msg' => 'Successfully fetched!!','response_code' => REST_Controller::HTTP_OK]);
	    } catch (Exception $e) {$this->response(['status' => false,'data' => [],'msg' => 'Something went wrong!!','response_code' => REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
	    }
	}
    
}
?>