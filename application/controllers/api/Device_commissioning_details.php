<?php
require APPPATH.'libraries/REST_Controller.php';
class Device_commissioning_details extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Device_commissioning_details_model');
	}


	public function add_well_commissiong_date_post()
	{
        
		if ($this->input->post('area_id', true) =='') 
	    {
			$this->response(['status' => false, 'data' => [], 'msg' => 'Area Name required!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
	    }elseif ($this->input->post('commissioning_date', true) =='') 
	    {
			$this->response(['status' => false, 'data' => [], 'msg' => 'Commissioning Date required!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
	    }elseif ($this->input->post('commissioningData', true) =='') 
	    {
			$this->response(['status' => false, 'data' => [], 'msg' => 'Commissioning Data required!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
	    }elseif ($this->input->post('c_by', true) =='') 
	    {
			$this->response(['status' => false, 'data' => [], 'msg' => 'c kon required!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
	    }else{
		try {

			$commissioningData = json_decode($this->input->post('commissioningData', true), TRUE);

			
			foreach ($commissioningData as $key => $value) 
			{

				$well_id = $value['well_id'];
                $exists = $this->Device_commissioning_details_model->verify_wellExist($well_id);
                if ($exists > 0) {
                    $this->Device_commissioning_details_model->update_commissiong_data(
                        ['status' => 0,'d_by'=>$this->input->post('c_by', true),'d_date'=>date('Y-m-d H:i:s')],
                        ['well_id' => $well_id, 'status' => 1]
                    );
                }

			    $details = [];
			    $details['area_id']   = $this->input->post('area_id',true);
			    $details['site_id'] = $value['site_id'] ?? '0';
			    $details['well_id'] = $value['well_id'] ?? '0';
			    $details['device_name'] = $value['device_name'] ?? '0';
			    $details['imei_no']  = $value['imei_no']  ?? '0';
			    $details['installation_date'] = $value['installation_date']      ?? '0';
			    $details['commissioning_date'] = $this->input->post('commissioning_date',true);
			  
			    $details['c_by']        = $this->input->post('c_by', true);
			    $details['c_date']      = date('Y-m-d H:i:s');
			    $this->Device_commissioning_details_model->save_commissiong_data($details);
			}

			
            $this->response(['status'=>true,'data'=>[],'msg'=>'Well commissioning date update Successfully!', 'response_code'=>REST_Controller::HTTP_OK]);
			
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	  } 
	}

	public function get_well_list_post()
	{
		try {

			$company_id = $this->input->post('company_id',true)!=""?$this->input->post('company_id',true):"";
			$area_id = $this->input->post('area_id',true)!=""?$this->input->post('area_id',true):"";

			$result = $this->Device_commissioning_details_model->WellList($company_id,$area_id);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		} 
	}

	public function well_commissioning_report_details_post()
	{
		try {

			$area_id = $this->input->post('area_id',true)!=''?$this->input->post('area_id',true):'';
			$from_date = $this->input->post('from_date',true)!=''?$this->input->post('from_date',true):'';
			$to_date = $this->input->post('to_date',true)!=''?$this->input->post('to_date',true):'';

			$result = $this->Device_commissioning_details_model->get_well_commissioning_report($area_id,$from_date,$to_date);

			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}
}
?>

