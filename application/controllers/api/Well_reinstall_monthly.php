<?php
require APPPATH.'libraries/REST_Controller.php';
class Well_reinstall_monthly extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Well_Reinstall_model');
	}

	public function Addwellreinstall_post()
	{
        $well_id = $this->input->post('well_id',true);
        $date = $this->input->post('date',true);
       

        if($this->input->post('well_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Well Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('date',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'date required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		
		}elseif($this->input->post('c_by',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'c kon required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}else{
			try 
			{	
		
					$data = [];
					$data['well_id'] = $this->input->post('well_id',true);
					$data['date'] = $this->input->post('date',true);
					$data['reason'] = $this->input->post('reason',true);
					$data['c_by'] = $this->input->post('c_by',true);
					$data['c_date'] = date('Y-m-d H:i:s');
					$data['status'] = 1;
					$this->Well_Reinstall_model->AddWellData($data);

					$this->response(['status'=>true,'data'=>[],'msg'=>'successfully saved!!','response_code'=>REST_Controller::HTTP_OK]);
							
				
        	
			}catch (Exception $e){
				$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
				}
		}
    }
}
?>