<?php
require APPPATH.'libraries/REST_Controller.php';
class Historical_Data extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Historical_model');
	}

	public function Historial_data_Mis_Report_post()
	{
		try {
			
			$well_id = $this->input->post('well_id',true)!=''?$this->input->post('well_id',true):'';
			$from_date = $this->input->post('from_date',true)!=''?$this->input->post('from_date',true):'';
			$to_date = $this->input->post('to_date',true)!=''?$this->input->post('to_date',true):'';
            $sort_by = $this->input->post('sort_by',true)!=''?$this->input->post('sort_by',true):''; 
			$result = $this->Historical_model->HistoricalDataMis_Report($well_id,$from_date,$to_date,$sort_by);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function Historical_All_Type_Graph_post()
	{
		try {
	        $well_id = $this->input->post('well_id', true) ?: '';
	        $from_date = $this->input->post('from_date', true) ?: '';			
	        $to_date = $this->input->post('to_date', true) ?: '';			
	        $graph_type = $this->input->post('graph_type',true);		
				
	        $result = [];
	        if($this->input->post('graph_type',true)!='')
	        {
	        	if($graph_type == 1)
	        	{
	        		$result['output_neutral_voltage'] = $this->Historical_model->OutPut_historicalNeutral_Voltage($well_id,$from_date,$to_date);
	        	}elseif($graph_type == 3) 
		        {
		        	$result['output_line_voltage'] = $this->Historical_model->Output_LineHis_Voltage($well_id,$from_date,$to_date);
		        }elseif($graph_type == 5)
	        	{
		        	$result['output_current'] = $this->Historical_model->Output_Current($well_id,$from_date,$to_date);
		        }elseif($graph_type == 2)
		        {
		        	$result['battery_voltage'] = $this->Historical_model->Battery_voltage($well_id,$from_date,$to_date);
		        }elseif($graph_type == 4)
		        {
		        	$result['smps_Voltage'] = $this->Historical_model->smps_Voltage($well_id,$from_date,$to_date);
		        }
	        }
	        
	        
	        $this->response(['status' => true, 'data' => $result, 'msg' => 'Successfully fetched!!', 'response_code' => REST_Controller::HTTP_OK]);
	    } catch (Exception $e) {
	        $this->response(['status' => false, 'data' => [], 'msg' => 'something went wrong!!', 'response_code' => REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
	    }
	}

	public function Historial_data_Average_post()
	{
		try {
			
			$well_id = $this->input->post('well_id',true)!=''?$this->input->post('well_id',true):'';
			
			$from_date = $this->input->post('from_date',true)!=''?$this->input->post('from_date',true):'';
			$to_date = $this->input->post('to_date',true)!=''?$this->input->post('to_date',true):'';

			$result = $this->Historical_model->HistoricalData_Average_value($well_id,$from_date,$to_date);
			

			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}



}
?>
