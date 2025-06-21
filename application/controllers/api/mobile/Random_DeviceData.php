<?php
require APPPATH.'libraries/REST_Controller.php';
class Random_DeviceData extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('mobile_model/RandomDevice_Data_model');
	}

	public function SaveDevice_Data_post()
	{
        $imei_no = $this->input->post('imei_no',true);
        $device_status = $this->input->post('device_status',true);
        $trip_status = $this->input->post('trip_status',true);       

       	if($this->input->post('imei_no',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'IMEI required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[a-zA-Z-0-9]{10,20}$/",$imei_no))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'IMEI should be 10 to 20 digits !!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('device_status',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Device Status required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[0-2]{1}$/",$device_status))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Device status only 0,1 and 2 allowed !!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}else{
			try 
			{	
				
				$verify = $this->RandomDevice_Data_model->CheckImei_Exist($this->input->post('imei_no',true));

				// print_r($verify);die;

				if($verify[0]['total'] == 1)
				{
					
					$data = [];
					for ($i = 1; $i < 2; $i++) 
					{
						$Log_Id = $this->RandomDevice_Data_model->getLogId();
						$data['id'] = $Log_Id[0]['UUID()'];
						$data['imei_no'] = $this->input->post('imei_no',true);
						$data['device_name'] = $verify[0]['device_name'];
						$data['device_status'] = $this->input->post('device_status',true);
						if($data['device_status'] == 2)
	                	{
	                		if($this->input->post('trip_status',true) == '')
	                		{
	                			$this->response(['status'=>false,'data'=>[],'msg'=>'Trip status required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
	                		}elseif(!preg_match("/^[3-9]$/",$trip_status))
							{
								$this->response(['status'=>false,'data'=>[],'msg'=>'Trip status not valid allowed !!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
							}else{
								$T_id = $this->RandomDevice_Data_model->getTripId();
								$T_Name = $this->RandomDevice_Data_model->getFault_number($this->input->post('trip_status',true));
								if(!empty($T_Name))
								{
									// print_r($T_Name);die;
									$trip = [];
									$trip['id'] = $T_id[0]['UUID()'];
									$trip['imei_no'] = $this->input->post('imei_no',true);
									$trip['device_name'] = $verify[0]['device_name'];
									$trip['trip_status'] = $this->input->post('trip_status',true);
									$trip['trip_name'] = $T_Name[0]['fault_name'];
									$trip['c_date'] = date("Y-m-d H:i:s");
									$trip['status'] = 1;
									$this->RandomDevice_Data_model->SaveFault_Data($trip);
								}else{
									$this->response(['status'=>false,'data'=>[],'msg'=>'Trip status not valid!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
								}
								
							}
							$data['trip_status'] = $this->input->post('trip_status',true);
	                	}
	                	
						$data['power_factor'] = rand(100,1000);
						$data['frequency'] = rand(1000,20000);
						$data['active_energy'] = rand(100,550);
						$data['battery_voltage'] = rand(100,450);
						$data['ap_R'] = rand(1000,12000);
						$data['ap_Y'] = rand(1000,12000);
						$data['ap_B'] = rand(1000,12000);
						$data['vrn'] = rand(0,10);
						$data['vyn'] = rand(0,10);
						$data['vbn'] = rand(0,10);
						$data['vry'] = rand(0,500);
						$data['vyb'] = rand(0,500);
						$data['vbr'] = rand(0,500);
						$data['Ir_i'] = rand(0,100);
						$data['Iy_i'] = rand(0,100);
						$data['Ib_i'] = rand(0,100);
						$data['Ir_o'] = rand(0,100);
						$data['Iy_o'] = rand(0,100);
						$data['Ib_o'] = rand(0,100);
						$data['c_date'] = date('Y-m-d H:i:s');
						$data['status'] = 1;
						$this->RandomDevice_Data_model->Save_Installation_DeviceLogData($data);

						$alert_id = $this->RandomDevice_Data_model->getAlertId();
						$alert = [];
						$alert['id'] = $alert_id[0]['UUID()'];
						$alert['device_name'] = $verify[0]['device_name'];
						$alert['imei_no'] = $this->input->post('imei_no',true);
						$alert['alert_status'] = $this->input->post('device_status',true);
						$alert['alert_date_time'] = date('Y-m-d H:i:s');
						$this->RandomDevice_Data_model->SaveAlert_Data($alert);

						$l_data = [];
						$l_data['device_last_status'] = $this->input->post('device_status',true);
						$l_data['last_date_time'] = date('Y-m-d H:i:s');
						if($this->input->post('device_status',true) == 2)
						{
							$l_data['last_trip_status'] = $this->input->post('trip_status',true);
							$l_data['last_trip_datetime'] = date('Y-m-d H:i:s');
						}	
						
						$l_data['last_power_factor'] = rand(100,1000);
						$l_data['last_frequency'] = rand(1000,20000);
						$l_data['last_active_energy'] = rand(100,550);
						$l_data['last_battery_voltage'] = rand(0,450);
						$l_data['last_ap_R'] = rand(1000,12000);
						$l_data['last_ap_Y'] = rand(1000,12000);
						$l_data['last_ap_B'] = rand(1000,12000);
						$l_data['last_vrn'] = rand(0,10);
						$l_data['last_vyn'] = rand(0,10);
						$l_data['last_vbn'] = rand(0,10);
						$l_data['last_vry'] = rand(0,500);
						$l_data['last_vyb'] = rand(0,500);
						$l_data['last_vbr'] = rand(0,500);
						$l_data['last_Ir_i'] = rand(0,100);
						$l_data['last_Iy_i'] = rand(0,100);
						$l_data['last_Ib_i'] = rand(0,100);
						$l_data['last_Ir_o'] = rand(0,100);
						$l_data['last_Iy_o'] = rand(0,100);
						$l_data['last_Ib_o'] = rand(0,100);
						$this->RandomDevice_Data_model->Update_LastData($l_data,['imei_no'=>$this->input->post('imei_no',true)]);
					}

					$this->response(['status'=>true,'data'=>[],'msg'=>'Successfull!!','response_code'=>REST_Controller::HTTP_OK]);

				}else{
					$this->response(['status'=>false,'data'=>[],'msg'=>'IMEI not exist!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
				}


				
			}catch (Exception $e){
				$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
				}
		}
    }
}
?>