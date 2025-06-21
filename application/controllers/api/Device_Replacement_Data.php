<?php
require APPPATH.'libraries/REST_Controller.php';

class Device_Replacement_Data extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Device_Replacementdata_model');
	}

	public function Device_ReplacementData_post()
	{
        $reason_for_replacement = $this->input->post('reason_for_replacement',true);
        $old_imei_no = $this->input->post('old_imei_no',true);
        $sim_provider = $this->input->post('sim_provider',true);
        $network_type = $this->input->post('network_type',true);
        $lat = $this->input->post('lat',true);
        $long = $this->input->post('long',true);
          
       
       	if($this->input->post('company_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'C Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('user_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'User required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('assets_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Assets required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('area_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Area required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('site_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Site required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('well_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Well required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('old_imei_no',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Old IMEI required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[0-9]{10,20}$/",$old_imei_no))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'IMEI should be 10 to 20 digits!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('reason_for_replacement',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Reason required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[1-3]*$/",$reason_for_replacement))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Reason should be 1,2 and 3 allowed!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('lat',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Latitude required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[0-9.]*$/",$lat))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Latitude not valid !!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('long',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Longitude required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[0-9.]*$/",$long))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Longitude not valid !!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}else{
			try 
			{	
				$verify = $this->Device_Replacementdata_model->CheckDevie_Exist($this->input->post('old_imei_no',true));
				// print_r($verify);die;

				$replaced_Id = $this->Device_Replacementdata_model->getReplacedId();
				if($verify[0]['total'] == 1)
				{
					$id = $this->Device_Replacementdata_model->get_Ins_id();
					

					if($reason_for_replacement == 1)
					{
						$new_imei_no = $this->input->post('new_imei_no',true);

						if($this->input->post('new_imei_no',true) == '')
						{
							$this->response(['status'=>false,'data'=>[],'msg'=>'New IMEI required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
						}elseif(!preg_match("/^[0-9]{10,20}$/",$new_imei_no))
						{
							$this->response(['status'=>false,'data'=>[],'msg'=>'New IMEI should be 10 to 20 digits!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
						}else{
							$NewDev = $this->Device_Replacementdata_model->getDevice_Name($this->input->post('user_id',true),$this->input->post('new_imei_no',true));
							// print_r($NewDev);die;
							if(!empty($NewDev))
							{
								$data = [];
								$data['id'] = $id[0]['UUID()'];
								$data['company_id'] = $this->input->post('company_id',true);
								$data['replaced_by'] = $this->input->post('user_id',true);
								$data['asset_id'] = $this->input->post('assets_id',true);
								$data['area_id'] = $this->input->post('area_id',true);
								$data['site_id'] = $this->input->post('site_id',true);
								$data['well_id'] = $this->input->post('well_id',true);
								$data['old_device_name'] = $verify[0]['device_name'];
								$data['old_imei_no'] = $this->input->post('old_imei_no',true);
								$data['old_installation_date'] = $verify[0]['date_of_installation'];
								$data['reason_for_replacement'] = $this->input->post('reason_for_replacement',true);
								$data['new_device_name'] = $NewDev[0]['device_name'];
								$data['new_imei_no'] = $this->input->post('new_imei_no',true);
								
								$data['replacement_datetime'] = date('Y-m-d H:i:s');
								$data['status'] = 1;
								$this->Device_Replacementdata_model->SaveReplecement_Device($data);

								$this->Device_Replacementdata_model->UpdateSetup_status(['device_setup_status'=>2,'device_setup_datetime'=>date('Y-m-d H:i:s')],['imei_no'=>$this->input->post('new_imei_no',true)]);

								$replaced = [];
								$replaced['id'] = $replaced_Id[0]['UUID()'];
								$replaced['reason'] = $data['reason_for_replacement'];
								$replaced['device_name'] = $data['old_device_name'];
								$replaced['imei_no'] = $data['old_imei_no'];
								$replaced['date_time'] = date('Y-m-d H:i:s');
								$replaced['status'] = 1;
								$this->Device_Replacementdata_model->SaveReplecementLog_Data($replaced);

								$this->Device_Replacementdata_model->Update_Device_and_Sim(['device_name'=>$data['new_device_name'],'imei_no'=>$data['new_imei_no'],'date_of_installation'=>date('Y-m-d H:i:s'),'dby'=>$this->input->post('user_id',true),'ddate'=>date('Y-m-d H:i:s')],['imei_no'=>$data['old_imei_no']]);

								$this->Device_Replacementdata_model->UpdateOld_Device_Allotstatus(['allot_status'=>0,'d_date'=>date('Y-m-d H:i:s')],['imei_no'=>$data['old_imei_no']]);

								$this->response(['status'=>true,'data'=>[],'msg'=>'Successfully Device Replaced!!','response_code'=>REST_Controller::HTTP_OK]);
							}else{
								$this->response(['status'=>false,'data'=>[],'msg'=>'Device not alloted!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
							}

							
						}
						
					}

					if($reason_for_replacement == 2)
					{
						$old_sim_provider = $this->input->post('old_sim_provider',true);
						$old_network = $this->input->post('old_network',true);
						$new_sim_provider = $this->input->post('new_sim_provider',true);
						$new_network = $this->input->post('new_network',true);
						
						if($this->input->post('old_sim_provider',true) == '')
						{
							$this->response(['status'=>false,'data'=>[],'msg'=>'Old Sim Provider required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
						}elseif(!preg_match("/^[1-3]{1}$/",$old_sim_provider))
						{
							$this->response(['status'=>false,'data'=>[],'msg'=>'Old Sim only 1 and 2 allowed!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
						}elseif($this->input->post('old_network',true) == '')
						{
							$this->response(['status'=>false,'data'=>[],'msg'=>'Old Network required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
						}elseif(!preg_match("/^[1-3]{1}$/",$old_network))
						{
							$this->response(['status'=>false,'data'=>[],'msg'=>'Old Network should be 1 ,2and 3 allowed!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
						}elseif($this->input->post('new_sim_provider',true) == '')
						{
							$this->response(['status'=>false,'data'=>[],'msg'=>'New Sim Provider required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
						}elseif(!preg_match("/^[1-3]{1}$/",$new_sim_provider))
						{
							$this->response(['status'=>false,'data'=>[],'msg'=>'New Sim should be 1 and 2 allowed!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
						}elseif($this->input->post('new_network',true) == '')
						{
							$this->response(['status'=>false,'data'=>[],'msg'=>'New Network required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
						}elseif(!preg_match("/^[1-3]{1}$/",$new_network))
						{
							$this->response(['status'=>false,'data'=>[],'msg'=>'New Network should be 1 ,2and 3 allowed!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
						}else{
							
								$data = [];
								$data['id'] = $id[0]['UUID()'];
								$data['company_id'] = $this->input->post('company_id',true);
								$data['replaced_by'] = $this->input->post('user_id',true);
								$data['asset_id'] = $this->input->post('assets_id',true);
								$data['area_id'] = $this->input->post('area_id',true);
								$data['site_id'] = $this->input->post('site_id',true);
								$data['well_id'] = $this->input->post('well_id',true);
								$data['old_device_name'] = $verify[0]['device_name'];
								$data['old_imei_no'] = $this->input->post('old_imei_no',true);
								$data['old_installation_date'] = $verify[0]['date_of_installation'];
								$data['reason_for_replacement'] = $this->input->post('reason_for_replacement',true);
								$data['old_sim_provider'] = $this->input->post('old_sim_provider',true);
								$data['old_network'] = $this->input->post('old_network',true);
								$data['new_sim_provider'] = $this->input->post('new_sim_provider',true);
								$data['new_network'] = $this->input->post('new_network',true);
								$data['old_sim_no'] = $this->input->post('old_sim_no',true);
								$data['new_sim_no'] = $this->input->post('new_sim_no',true);
								
								$data['replacement_datetime'] = date('Y-m-d H:i:s');
								$data['status'] = 1;
								$this->Device_Replacementdata_model->SaveReplecement_Device($data);

								$replaced = [];
								$replaced['id'] = $replaced_Id[0]['UUID()'];
								$replaced['reason'] = $data['reason_for_replacement'];
								$replaced['device_name'] = $data['old_device_name'];
								$replaced['imei_no'] = $data['old_imei_no'];
								$replaced['sim_type'] = $data['old_sim_provider'];
								$replaced['network'] = $data['old_network'];
								$replaced['date_time'] = date('Y-m-d H:i:s');
								$replaced['status'] = 1;
								$this->Device_Replacementdata_model->SaveReplecementLog_Data($replaced);

								$this->Device_Replacementdata_model->Update_Device_and_Sim(['sim_no'=>$data['new_sim_no'],'sim_provider'=>$data['new_sim_provider'],'network_type'=>$data['new_network'],'date_of_installation'=>date('Y-m-d H:i:s')],['imei_no'=>$data['old_imei_no']]);

								$this->response(['status'=>true,'data'=>[],'msg'=>'Successfully Sim Replaced!!','response_code'=>REST_Controller::HTTP_OK]);
							
						}
						
					}

					if($reason_for_replacement == 3)
					{
						$new_imei_no = $this->input->post('new_imei_no',true);
						$old_sim_provider = $this->input->post('old_sim_provider',true);
						$old_network = $this->input->post('old_network',true);
						$new_sim_provider = $this->input->post('new_sim_provider',true);
						$new_network = $this->input->post('new_network',true);
						
						if($this->input->post('new_imei_no',true) == '')
						{
							$this->response(['status'=>false,'data'=>[],'msg'=>'New IMEI required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
						}elseif(!preg_match("/^[0-9]{10,20}$/",$new_imei_no))
						{
							$this->response(['status'=>false,'data'=>[],'msg'=>'New IMEI should be 10 to 20 digits!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
						}elseif($this->input->post('old_sim_provider',true) == '')
						{
							$this->response(['status'=>false,'data'=>[],'msg'=>'Old Sim required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
						}elseif(!preg_match("/^[1-3]{1}$/",$old_sim_provider))
						{
							$this->response(['status'=>false,'data'=>[],'msg'=>'Old Sim only 1 and 2 allowed!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
						}elseif($this->input->post('old_network',true) == '')
						{
							$this->response(['status'=>false,'data'=>[],'msg'=>'Old Network required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
						}elseif(!preg_match("/^[1-3]{1}$/",$old_network))
						{
							$this->response(['status'=>false,'data'=>[],'msg'=>'Old Network should be 1 ,2and 3 allowed!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
						}elseif($this->input->post('new_sim_provider',true) == '')
						{
							$this->response(['status'=>false,'data'=>[],'msg'=>'New Sim required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
						}elseif(!preg_match("/^[1-3]{1}$/",$new_sim_provider))
						{
							$this->response(['status'=>false,'data'=>[],'msg'=>'New Sim Provider should be 1 and 2 allowed!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
						}elseif($this->input->post('new_network',true) == '')
						{
							$this->response(['status'=>false,'data'=>[],'msg'=>'New Network required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
						}elseif(!preg_match("/^[1-3]{1}$/",$new_network))
						{
							$this->response(['status'=>false,'data'=>[],'msg'=>'New Network should be 1 ,2and 3 allowed!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
						}else{
							$NewDev = $this->Device_Replacementdata_model->getDevice_Name($this->input->post('user_id',true),$this->input->post('new_imei_no',true));
							// print_r($NewDev);die;
							if(!empty($NewDev))
							{
								$data = [];
								$data['id'] = $id[0]['UUID()'];
								$data['company_id'] = $this->input->post('company_id',true);
								$data['replaced_by'] = $this->input->post('user_id',true);
								$data['asset_id'] = $this->input->post('assets_id',true);
								$data['area_id'] = $this->input->post('area_id',true);
								$data['site_id'] = $this->input->post('site_id',true);
								$data['well_id'] = $this->input->post('well_id',true);
								$data['old_device_name'] = $verify[0]['device_name'];
								$data['old_imei_no'] = $this->input->post('old_imei_no',true);
								$data['old_installation_date'] = $verify[0]['date_of_installation'];
								$data['reason_for_replacement'] = $this->input->post('reason_for_replacement',true);
								$data['new_device_name'] = $NewDev[0]['device_name'];
								$data['new_imei_no'] = $this->input->post('new_imei_no',true);
								$data['old_sim_provider'] = $this->input->post('old_sim_provider',true);
								$data['old_network'] = $this->input->post('old_network',true);
								$data['new_sim_provider'] = $this->input->post('new_sim_provider',true);
								$data['new_network'] = $this->input->post('new_network',true);
								$data['old_sim_no'] = $this->input->post('old_sim_no',true);
								$data['new_sim_no'] = $this->input->post('new_sim_no',true);
								
								$data['replacement_datetime'] = date('Y-m-d H:i:s');
								$data['status'] = 1;
								$this->Device_Replacementdata_model->SaveReplecement_Device($data);

								$this->Device_Replacementdata_model->UpdateSetup_status(['device_setup_status'=>2,'device_setup_datetime'=>date('Y-m-d H:i:s')],['imei_no'=>$this->input->post('new_imei_no',true)]);

								$replaced = [];
								$replaced['id'] = $replaced_Id[0]['UUID()'];
								$replaced['reason'] = $data['reason_for_replacement'];
								$replaced['device_name'] = $data['old_device_name'];
								$replaced['imei_no'] = $data['old_imei_no'];
								$replaced['sim_type'] = $data['old_sim_provider'];
								$replaced['network'] = $data['old_network'];
								$replaced['date_time'] = date('Y-m-d H:i:s');
								$replaced['status'] = 1;
								$this->Device_Replacementdata_model->SaveReplecementLog_Data($replaced);

								$dataArray = [];
								$dataArray['device_name'] = $data['new_device_name'];
								$dataArray['imei_no'] = $data['new_imei_no'];
								$dataArray['sim_no'] = $data['new_sim_no'];
								$dataArray['sim_provider'] = $data['new_sim_provider'];
								$dataArray['network_type'] = $data['new_network'];
								$dataArray['date_of_installation'] = date('Y-m-d H:i:s');
								$dataArray['ddate'] = date('Y-m-d H:i:s');
								$dataArray['dby'] = $this->input->post('user_id',true);
								
								$this->Device_Replacementdata_model->Update_Device_and_Sim($dataArray,['imei_no'=>$data['old_imei_no']]);

								$this->Device_Replacementdata_model->UpdateOld_Device_Allotstatus(['allot_status'=>0,'d_date'=>date('Y-m-d H:i:s')],['imei_no'=>$data['old_imei_no']]);

								$this->response(['status'=>true,'data'=>[],'msg'=>'Successfully Device and Sim Replaced!!','response_code'=>REST_Controller::HTTP_OK]);
							}else{
								$this->response(['status'=>false,'data'=>[],'msg'=>'New IMEI not installed !!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
							}

							
						}
						
					}
					
				}else{
					$this->response(['status'=>false,'data'=>[],'msg'=>'OLd IMEI not valid!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					
				}	

			}catch (Exception $e){
				$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
				}
		}
    }
}
?>