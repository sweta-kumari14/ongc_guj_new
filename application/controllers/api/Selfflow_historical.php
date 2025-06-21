<?php
require APPPATH.'libraries/REST_Controller.php';
class Selfflow_historical extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Selfflow_historical_model');
	}
    
	public function Well_Wise_Count_post()
	{
		try {
			
			$well_id = $this->input->post('well_id',true)!=''?$this->input->post('well_id',true):'';
			$imei_no = $this->input->post('imei_no',true)!=''?$this->input->post('imei_no',true):'';	
			
			$result = [];
			$result['total_alert'] = $this->Selfflow_historical_model->Well_Wise_Total_Alert($well_id,$imei_no);

			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function Historial_data_Mis_Report_post()
	{
		try {
			
			$well_id = $this->input->post('well_id',true)!=''?$this->input->post('well_id',true):'';
			$from_date = $this->input->post('from_date',true)!=''?$this->input->post('from_date',true):'';
			$to_date = $this->input->post('to_date',true)!=''?$this->input->post('to_date',true):'';
			$result = $this->Selfflow_historical_model->HistoricalDataMis_Report($well_id,$from_date,$to_date);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function Historical_All_Type_Graph_post()
	{
		try {
			  $well_ids = json_decode($this->input->post('well_id',true),true);
			  // print_r($well_ids);die;
		     $from_date = $this->input->post('from_date',true);
		     $to_date = $this->input->post('to_date',true);

			    $result = [];
			    $graph_type = $this->input->post('graph_type',true);
		        if($this->input->post('graph_type',true)!='')
		        {
		        	if($graph_type == 1)
		        	{
		        	    foreach ($well_ids as $well_id) 
		        	    {
                          $result[$well_id]['output_chp'] = $this->Selfflow_historical_model->OutPut_historical_chp($well_id,$from_date, $to_date);
                        }
      
		        	}elseif($graph_type == 2) 
			        {
			        	foreach ($well_ids as $well_id) 
		        	    {
			        	  $result[$well_id]['output_thp'] = $this->Selfflow_historical_model->Output_His_thp($well_id,$from_date,$to_date);
			        	}
			        }elseif($graph_type == 3)
		        	{
		        		foreach ($well_ids as $well_id) 
		        	    {
			        	  $result[$well_id]['output_abp'] = $this->Selfflow_historical_model->Output_His_abp($well_id,$from_date,$to_date);
			        	}
			        }elseif($graph_type == 4)
			        {
			        	foreach ($well_ids as $well_id) 
		        	    {
			        	  $result[$well_id]['output_gip'] = $this->Selfflow_historical_model->Output_His_gip($well_id,$from_date,$to_date);
			        	}
			        }elseif($graph_type == 5)
			        {
			        	foreach ($well_ids as $well_id) 
		        	    {
			        	   $result[$well_id]['output_tht'] = $this->Selfflow_historical_model->Output_His_tht($well_id,$from_date,$to_date);
			        	}
			        }elseif($graph_type == 6)
			        {
			        	foreach ($well_ids as $well_id) 
		        	    {
			        	   $result[$well_id]['output_battery'] = $this->Selfflow_historical_model->output_His_battery($well_id,$from_date,$to_date);
			        	}
			        }
		        }
	        
	        $this->response(['status' => true, 'data' => $result, 'msg' => 'Successfully fetched!!', 'response_code' => REST_Controller::HTTP_OK]);
	    } catch (Exception $e) {
	        $this->response(['status' => false, 'data' => [], 'msg' => 'something went wrong!!', 'response_code' => REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
	    }
	}
    
}
?>