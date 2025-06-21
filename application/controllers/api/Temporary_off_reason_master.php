<?php
require APPPATH.'libraries/REST_Controller.php';
class Temporary_off_reason_master extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Temporary_off_reason_model');
	}

	public function AddReason_post()
	{
       $reason = $this->input->post('reason',true);

            if($this->input->post('company_id',true) == '')
			{
				$this->response(['status'=>false,'data'=>[],'msg'=>'C Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
			}elseif($this->input->post('reason',true) == '')
			{
				$this->response(['status'=>false,'data'=>[],'msg'=>'Reason required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
			}elseif(!preg_match("/^[a-zA-Z-. \/]*$/",$reason))
			{
				$this->response(['status'=>false,'data'=>[],'msg'=>'Reason should be alphabet!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
			}elseif($this->input->post('c_by',true) == '')
			{
				$this->response(['status'=>false,'data'=>[],'msg'=>'c kon required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
			}else{
				try 
				{	
					$verify = $this->Temporary_off_reason_model->verifyReasonExist($this->input->post('reason',true));
					if($verify == 0)
					{
						
						$data = [];
						$data['company_id'] = $this->input->post('company_id',true);
					    $data['reason'] = $this->input->post('reason',true);
						$data['c_by'] = $this->input->post('c_by',true);
						$data['c_date'] = date('Y-m-d H:i:s');
						$data['status'] = 1;
						$this->Temporary_off_reason_model->SaveReason($data);
						$this->response(['status'=>true,'data'=>[],'msg'=>'Successfully Saved!!','response_code'=>REST_Controller::HTTP_OK]);
						
					}else{
						$this->response(['status'=>false,'data'=>[],'msg'=>'Reason Already Exist!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
						
					}	
	        	
				}catch (Exception $e){
					$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
					}
			}
    }

   

    public function ReasonList_post()
    {
		try {
				$id = $this->input->post('id',true)!=""?$this->input->post('id',true):"";
				$company_id = $this->input->post('company_id',true)!=""?$this->input->post('company_id',true):"";
				$result = $this->Temporary_off_reason_model->ReasonList($id,$company_id);
			   $this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		  } catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	  
	}

	public function delete_reason_post()
	{	    
          if($this->input->post('id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'ID required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('d_by',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'d kon required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}else{
			 try 
			   {	
				$data = [];
				$data['d_by'] = $this->input->post('d_by',true);
				$data['d_date'] = date('Y-m-d H:i:s');
				$data['status'] = 0;
				$this->Temporary_off_reason_model->DeleteReason($data,['id'=>$this->input->post('id',true)]);
				$this->response(['status'=>true,'data'=>[],'msg'=>'successfully delete!!','response_code'=>REST_Controller::HTTP_OK]);
					
					
			  }catch (Exception $e){
				$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
			}
		}
    }


    public function well_status_mark_post()
    {
		if($this->input->post('well_id',true) == '')
	     {
			$this->response(['status'=>false,'data'=>[],'msg'=>'well id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('user_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'User Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);

	     }elseif($this->input->post('reason',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Reason required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('effective_date_time',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'date required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('flag_status',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Flag required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('c_by',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'c kon required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}else{
			try 
			{
	                $currentDateTime = date('Y-m-d H:i:s');
	                $effective_date_time = date('Y-m-d H:i:s',strtotime($this->input->post('effective_date_time',true)));

		          if ($effective_date_time > $currentDateTime) 
		          {
		              $this->response(['status' => false, 'data' => [], 'msg' => 'Please select a date time equal to or less than the current date time.', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
		          }else{

		          	$verify_well = $this->Temporary_off_reason_model->verify_well_flag_details($this->input->post('well_id',true));

		          	if($verify_well == 0)
		          	{
		          	    $data_log = [];
					    $data_log['well_id'] = $this->input->post('well_id',true);
					    $data_log['user_id'] = $this->input->post('user_id',true);
					    $data_log['reason'] = $this->input->post('reason',true);
					    $data_log['effective_date_time'] = $effective_date_time;
					    $data_log['flag_status'] = $this->input->post('flag_status',true);
					    $data_log['c_by'] = $this->input->post('c_by',true);
					    $data_log['c_date'] = date('Y-m-d H:i:s');
					    $data_log['status'] = 1;
					    $this->Temporary_off_reason_model->SaveFlagdata_log($data_log);

					    $data = [];
					    $data['effective_date_time'] =  $effective_date_time;
					    $data['flag_status'] = $this->input->post('flag_status',true);
					    $data['dby'] = $this->input->post('c_by',true);
					    $data['ddate'] = date('Y-m-d H:i:s');

						$this->Temporary_off_reason_model->Update_Flagstatus($data,['well_id'=>$this->input->post('well_id',true)]);

						$this->response(['status'=>true,'data'=>[],'msg'=>'Successfully !!','response_code'=>REST_Controller::HTTP_OK]);

					}else{


						$data_log['deeffective_date_time'] = date('Y-m-d H:i:s');
						$data_log['flag_status'] = $this->input->post('flag_status',true);
					     $data_log['d_by'] = $this->input->post('c_by',true);
					     $data_log['d_date'] = date('Y-m-d H:i:s');
					     $data_log['status'] = 1;

					     $this->Temporary_off_reason_model->Update_Flag_logstatus($data_log,['well_id'=>$this->input->post('well_id',true),'flag_status'=>1]);


					    $data = [];
					    $data['effective_date_time'] =  $effective_date_time;
					    $data['flag_status'] = $this->input->post('flag_status',true);
					    $data['dby'] = $this->input->post('c_by',true);
					    $data['ddate'] = date('Y-m-d H:i:s');

						$this->Temporary_off_reason_model->Update_Flagstatus($data,['well_id'=>$this->input->post('well_id',true)]);

						$this->response(['status'=>true,'data'=>[],'msg'=>'Successfully !!','response_code'=>REST_Controller::HTTP_OK]);

					}
				  }	
										
				}catch (Exception $e)
				{
					$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
			     }
		    }
    }

    public function get_well_last_mark_status_post()
    {
    	     if($this->input->post('well_id',true) == '')
		{
		    $this->response(['status'=>false,'data'=>[],'msg'=>'W ID required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}else{
			   try 
			     {	
                       $result = $this->Temporary_off_reason_model->last_status_well($this->input->post('well_id',true));
				    $this->response(['status'=>true,'data'=>$result,'msg'=>'successfully delete!!','response_code'=>REST_Controller::HTTP_OK]);
					
			     }catch (Exception $e)
			     {
				    $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
				}
		    }
    }
}
?>