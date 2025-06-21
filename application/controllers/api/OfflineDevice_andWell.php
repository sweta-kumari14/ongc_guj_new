<?php
require APPPATH.'libraries/REST_Controller.php';
class OfflineDevice_andWell extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('OfflineDeviceandWellModel');
	}

	public function getDeviceData_post()
	{
		try{
			if($this->input->post('date',true) == '')
			{
				$this->response(['status'=>false,'data'=>[],'msg'=>'Date required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
			}

			$date = $this->input->post('date',true);
			$result = $this->OfflineDeviceandWellModel->checkOffline_Status($date);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'successfully saved!!','response_code'=>REST_Controller::HTTP_OK]);
		
		}catch (Exception $e){
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
			
		
	}

	public function getAllwell_ForMaintainance_dashboard_post()
	{
		try{
			$company_id = $this->input->post('company_id',true)!=""?$this->input->post('company_id',true):"";
			
			$area_id = $this->input->post('area_id',true)!=""?$this->input->post('area_id',true):"";
			
			$well_id = $this->input->post('well_id',true)!=""?$this->input->post('well_id',true):"";
			$result = $this->OfflineDeviceandWellModel->getMaintainanceDetails($company_id,$area_id,$well_id);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'successfully saved!!','response_code'=>REST_Controller::HTTP_OK]);
		
		}catch (Exception $e){
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function getMaintainanceDashboard_post()
	{
		try{
			$company_id = $this->input->post('company_id',true)!=""?$this->input->post('company_id',true):"";
			
			$area_id = $this->input->post('area_id',true)!=""?$this->input->post('area_id',true):"";
			
			$well_id = $this->input->post('well_id',true)!=""?$this->input->post('well_id',true):"";
			$result = $this->OfflineDeviceandWellModel->getMaintainanceDashboard_Count($company_id,$area_id,$well_id);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'successfully saved!!','response_code'=>REST_Controller::HTTP_OK]);
		
		}catch (Exception $e){
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function MaintananceDashboardMis_Report_post()
	{
		try {
			
			$company_id = $this->input->post('company_id',true)!=""?$this->input->post('company_id',true):"";
			
			$area_id = $this->input->post('area_id',true)!=""?$this->input->post('area_id',true):"";

			$well_id = $this->input->post('well_id',true)!=''?$this->input->post('well_id',true):'';

			$from_date = $this->input->post('from_date',true)!=''?$this->input->post('from_date',true):'';

			$to_date = $this->input->post('to_date',true)!=''?$this->input->post('to_date',true):'';
			$offline_reason = $this->input->post('offline_reason',true)!=''?$this->input->post('offline_reason',true):'';

			$result = $this->OfflineDeviceandWellModel->MaintananceDashboardMis_Report($company_id,$area_id,$well_id,$from_date,$to_date,$offline_reason);


			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function maintainanceDashboardGraph_post()
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
	        		$result['batt_Prb'] = $this->OfflineDeviceandWellModel->BatteryProblemGraph($well_id,$from_date,$to_date);
	        	}
	        		// elseif($graph_type == 3) 
		        // {
		        // 	$result['output_line_voltage'] = $this->Historical_model->Output_LineHis_Voltage($well_id,$from_date,$to_date);
		        // }elseif($graph_type == 5)
	        	// {
		        // 	$result['output_current'] = $this->Historical_model->Output_Current($well_id,$from_date,$to_date);
		        // }
	        }else{
	        	$this->response(['status' => false, 'data' => [], 'msg' => 'Graph Type required!!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
	        }
	        
	        
	        $this->response(['status' => true, 'data' => $result, 'msg' => 'Successfully fetched!!', 'response_code' => REST_Controller::HTTP_OK]);
	    } catch (Exception $e) {
	        $this->response(['status' => false, 'data' => [], 'msg' => 'something went wrong!!', 'response_code' => REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
	    }
	}
}
?>