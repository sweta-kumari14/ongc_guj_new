<?php
require APPPATH.'libraries/REST_Controller.php';
class Selfflow_feeder_master extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Selfflow_feeder_model');
	}

	public function AddFeeder_post()
	{
        $feeder_name = $this->input->post('feeder_name',true);

        if($this->input->post('area_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Area required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('feeder_name',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Feeder required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[a-zA-Z0-9-() ]*$/",$feeder_name))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Feeder Not Valid!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('c_by',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'c kon required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}else{
			try 
			{	
				$verifyFeeder = $this->Selfflow_feeder_model->verifyFeederExist($this->input->post('feeder_name',true));
				// print_r($verifyFeeder);die;
				if($verifyFeeder == 0)
				{
					
					$id = $this->Selfflow_feeder_model->getFeederId();
					$data = [];
					$data['id'] = $id[0]['UUID()'];
					$data['area_id'] = $this->input->post('area_id',true);
					$data['feeder_name'] = $this->input->post('feeder_name',true);
					$data['c_by'] = $this->input->post('c_by',true);
					$data['c_date'] = date('Y-m-d H:i:s');
					$data['status'] = 1;
					$this->Selfflow_feeder_model->saveFeeder($data);
					$this->response(['status'=>true,'data'=>[],'msg'=>'Successfully Saved!!','response_code'=>REST_Controller::HTTP_OK]);
					
				}else{
					$this->response(['status'=>false,'data'=>[],'msg'=>'Feeder Already Exist!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					
				}	
        	
			}catch (Exception $e){
				$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
				}
		}
    }

    public function FeederList_post()
	{
		try {

			$area_id = $this->input->post('area_id',true)!=""?$this->input->post('area_id',true):"";
			$id = $this->input->post('id',true)!=""?$this->input->post('id',true):"";

			$result = $this->Selfflow_feeder_model->Feeder_List($area_id,$id);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	  
	}

	public function FeederList_sitedata_post()
	{
		try {

			$site_id = $this->input->post('site_id',true)!=""?$this->input->post('site_id',true):"";
			
			$result = $this->Selfflow_feeder_model->Feeder_List_data($site_id);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	  
	}


	public function updateFeederData_post()
	{
        $feeder_name = $this->input->post('feeder_name',true);

        if($this->input->post('id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('feeder_name',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Feeder required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[a-zA-Z0-9-() ]*$/",$feeder_name))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Feeder Not Valid!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('d_by',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'D kon required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}else{
			try 
			{	
				$verifyFeeder = $this->Selfflow_feeder_model->verifyFeederExist_OR_not($this->input->post('feeder_name',true),$this->input->post('id',true));
				// print_r($verifyFeeder);die;
				if($verifyFeeder == 0)
				{
					
					$data = [];
					$data['feeder_name'] = $this->input->post('feeder_name',true);
					$data['d_by'] = $this->input->post('d_by',true);
					$data['d_date'] = date('Y-m-d H:i:s');
					$data['status'] = 1;
					$this->Selfflow_feeder_model->updateFeederData($data,['id'=>$this->input->post('id',true)]);
					$this->response(['status'=>true,'data'=>[],'msg'=>'Successfully Update!!','response_code'=>REST_Controller::HTTP_OK]);
					
				}else{
					$this->response(['status'=>false,'data'=>[],'msg'=>'Feeder Already Exist!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					
				}	
        	
			}catch (Exception $e){
				$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
				}
		}
    }

    public function deleteFeederData_post()
	{

        if($this->input->post('id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('d_by',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'D kon required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}else{
			try 
			{	
				$data = [];
				$data['d_by'] = $this->input->post('d_by',true);
				$data['d_date'] = date('Y-m-d H:i:s');
				$data['status'] = 0;
				$this->Selfflow_feeder_model->updateFeederData($data,['id'=>$this->input->post('id',true)]);
				$this->response(['status'=>true,'data'=>[],'msg'=>'Successfully Deleted!!','response_code'=>REST_Controller::HTTP_OK]);	
        	
			}catch (Exception $e){
				$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
				}
		}
    }
}
?>