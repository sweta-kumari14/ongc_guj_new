<?php
require APPPATH.'libraries/REST_Controller.php';
class Equipment_Allotment extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Equipment_Allotment_model');
	}

	public function AllotEquipment_post()
	{
		$imei_no = $this->input->post('imei_no',true);
		$equipment_type = $this->input->post('equipment_type',true);
		$motor_name = $this->input->post('motor_name',true);
		$capacity = $this->input->post('capacity',true);
		$power = $this->input->post('power',true);
		$volt_1 = $this->input->post('volt_1',true);
		$v1_ut = $this->input->post('v1_ut',true);
		$v1_lt = $this->input->post('v1_lt',true);
		$amp_1 = $this->input->post('amp_1',true);
		$amp1_ut = $this->input->post('amp1_ut',true);
		$amp1_lt = $this->input->post('amp1_lt',true);
		$volt_2 = $this->input->post('volt_2',true);
		$v2_ut = $this->input->post('v2_ut',true);
		$v2_lt = $this->input->post('v2_lt',true);
		$amp_2 = $this->input->post('amp_2',true);
		$amp2_ut = $this->input->post('amp2_ut',true);
		$amp2_lt = $this->input->post('amp2_lt',true);
		$volt_3 = $this->input->post('volt_3',true);
		$v3_ut = $this->input->post('v3_ut',true);
		$v3_lt = $this->input->post('v3_lt',true);
		$amp_3 = $this->input->post('amp_3',true);
		$amp3_ut = $this->input->post('amp3_ut',true);
		$amp3_lt = $this->input->post('amp3_lt',true);

		if($this->input->post('company_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Company required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('site_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'S Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('device_name',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Device required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('imei_no',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Imei required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[a-zA-Z0-9]{10,20}$/",$imei_no))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'IMEI should be 10 to 20 digit and character!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('equipment_type',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Equipment required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[1-2]{1,2}$/",$equipment_type))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Type only 1 and 2 allowed!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('motor_name',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Name required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[a-zA-Z0-9-. ]*$/",$motor_name))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Name not valid!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('capacity',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Range required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[0-9.]*$/",$capacity))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Range not valid!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('power',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Potential required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[0-9.]*$/",$power))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Potential not valid!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('phase',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Stage required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('c_by',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'C Kon required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}else{
			try {
				$Id = $this->Equipment_Allotment_model->getAllotId();
				if($this->input->post('phase',true) == 1)
				{
					if($this->input->post('volt_1',true) == '')
					{
						$this->response(['status'=>false,'data'=>[],'msg'=>'Volt required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}elseif(!preg_match("/^[0-9.]*$/",$volt_1))
					{
						$this->response(['status'=>false,'data'=>[],'msg'=>'Volt not valid!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}elseif($this->input->post('v1_ut',true) == '')
					{
						$this->response(['status'=>false,'data'=>[],'msg'=>'Volt Upper Threshold required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}elseif(!preg_match("/^[0-9.]*$/",$v1_ut))
					{
						$this->response(['status'=>false,'data'=>[],'msg'=>'Volt Upper Threshold not valid!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}elseif($this->input->post('v1_lt',true) == '')
					{
						$this->response(['status'=>false,'data'=>[],'msg'=>'Volt Lower Threshold required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}elseif(!preg_match("/^[0-9.]*$/",$v1_lt))
					{
						$this->response(['status'=>false,'data'=>[],'msg'=>'Volt Lower Threshold not valid!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}elseif($this->input->post('amp_1',true) == '')
					{
						$this->response(['status'=>false,'data'=>[],'msg'=>'Ampere required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}elseif(!preg_match("/^[0-9.]*$/",$amp_1))
					{
						$this->response(['status'=>false,'data'=>[],'msg'=>'Ampere not valid!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}elseif($this->input->post('amp1_ut',true) == '')
					{
						$this->response(['status'=>false,'data'=>[],'msg'=>'Ampere Lower Threshold required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}elseif(!preg_match("/^[0-9.]*$/",$amp1_ut))
					{
						$this->response(['status'=>false,'data'=>[],'msg'=>'Ampere Upper Threshold not valid!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}elseif($this->input->post('amp1_lt',true) == '')
					{
						$this->response(['status'=>false,'data'=>[],'msg'=>'Ampere Lower Threshold required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}elseif(!preg_match("/^[0-9.]*$/",$amp1_lt))
					{
						$this->response(['status'=>false,'data'=>[],'msg'=>'Ampere Lower Threshold not valid!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}
					$data = [];
					$data['id'] = $Id[0]['UUID()'];
					$data['company_id'] = $this->input->post('company_id',true);
					$data['site_id'] = $this->input->post('site_id',true);
					$data['device_name'] = $this->input->post('device_name',true);
					$data['imei_no'] = $this->input->post('imei_no',true);
					$data['equipment_type'] = $this->input->post('equipment_type',true);
					$data['c_by'] = $this->input->post('c_by',true);
					$data['c_date'] = date('Y-m-d H:i:s');
					$data['status'] = 1;
					$this->Equipment_Allotment_model->Save_EquipmentAllotment_data($data);

					$A_Id = $this->Equipment_Allotment_model->getEqupId();
					$details = [];
					$details['id'] = $A_Id[0]['UUID()'];
					$details['eqp_allot_id'] = $data['id'];
					$details['motor_name'] = $this->input->post('motor_name',true);
					$details['capacity'] = $this->input->post('capacity',true);
					$details['power'] = $this->input->post('power',true);
					$details['phase'] = $this->input->post('phase',true);
					$details['volt_1'] = $this->input->post('volt_1',true);
					$details['v1_ut'] = $this->input->post('v1_ut',true);
					$details['v1_lt'] = $this->input->post('v1_lt',true);
					$details['amp_1'] = $this->input->post('amp_1',true);
					$details['amp1_ut'] = $this->input->post('amp1_ut',true);
					$details['amp1_lt'] = $this->input->post('amp1_lt',true);
					$details['c_by'] = $this->input->post('c_by',true);
					$details['c_date'] = date('Y-m-d H:i:s');
					$details['status'] = 1;
					$this->Equipment_Allotment_model->Save_Equipment_Details_data($details);

				}
				elseif($this->input->post('phase',true) == 2)
				{
					if($this->input->post('volt_1',true) == '')
					{
						$this->response(['status'=>false,'data'=>[],'msg'=>'Volt1 required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}elseif(!preg_match("/^[0-9.]*$/",$volt_1))
					{
						$this->response(['status'=>false,'data'=>[],'msg'=>'Volt1 not valid!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}elseif($this->input->post('v1_ut',true) == '')
					{
						$this->response(['status'=>false,'data'=>[],'msg'=>'Volt1 Upper Threshold required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}elseif(!preg_match("/^[0-9.]*$/",$v1_ut))
					{
						$this->response(['status'=>false,'data'=>[],'msg'=>'Volt1 Upper Threshold not valid!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}elseif($this->input->post('v1_lt',true) == '')
					{
						$this->response(['status'=>false,'data'=>[],'msg'=>'Volt1 Lower Threshold required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}elseif(!preg_match("/^[0-9.]*$/",$v1_lt))
					{
						$this->response(['status'=>false,'data'=>[],'msg'=>'Volt1 Lower Threshold not valid!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}elseif($this->input->post('amp_1',true) == '')
					{
						$this->response(['status'=>false,'data'=>[],'msg'=>'Ampere1 required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}elseif(!preg_match("/^[0-9.]*$/",$amp_1))
					{
						$this->response(['status'=>false,'data'=>[],'msg'=>'Ampere1 not valid!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}elseif($this->input->post('amp1_ut',true) == '')
					{
						$this->response(['status'=>false,'data'=>[],'msg'=>'Ampere1 Lower Threshold required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}elseif(!preg_match("/^[0-9.]*$/",$amp1_ut))
					{
						$this->response(['status'=>false,'data'=>[],'msg'=>'Ampere1 Upper Threshold not valid!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}elseif($this->input->post('amp1_lt',true) == '')
					{
						$this->response(['status'=>false,'data'=>[],'msg'=>'Ampere1 Lower Threshold required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}elseif(!preg_match("/^[0-9.]*$/",$amp1_lt))
					{
						$this->response(['status'=>false,'data'=>[],'msg'=>'Ampere1 Lower Threshold not valid!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}elseif($this->input->post('volt_2',true) == '')
					{
						$this->response(['status'=>false,'data'=>[],'msg'=>'Volt2 required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}elseif(!preg_match("/^[0-9.]*$/",$volt_2))
					{
						$this->response(['status'=>false,'data'=>[],'msg'=>'Volt2 not valid!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}elseif($this->input->post('v2_ut',true) == '')
					{
						$this->response(['status'=>false,'data'=>[],'msg'=>'Volt2 Upper Threshold required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}elseif(!preg_match("/^[0-9.]*$/",$v2_ut))
					{
						$this->response(['status'=>false,'data'=>[],'msg'=>'Volt2 Upper Threshold not valid!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}elseif($this->input->post('v2_lt',true) == '')
					{
						$this->response(['status'=>false,'data'=>[],'msg'=>'Volt2 Lower Threshold required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}elseif(!preg_match("/^[0-9.]*$/",$v2_lt))
					{
						$this->response(['status'=>false,'data'=>[],'msg'=>'Volt2 Lower Threshold not valid!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}elseif($this->input->post('amp_2',true) == '')
					{
						$this->response(['status'=>false,'data'=>[],'msg'=>'Ampere2 required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}elseif(!preg_match("/^[0-9.]*$/",$amp_2))
					{
						$this->response(['status'=>false,'data'=>[],'msg'=>'Ampere2 not valid!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}elseif($this->input->post('amp2_ut',true) == '')
					{
						$this->response(['status'=>false,'data'=>[],'msg'=>'Ampere2 Upper Threshold required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}elseif(!preg_match("/^[0-9.]*$/",$amp2_ut))
					{
						$this->response(['status'=>false,'data'=>[],'msg'=>'Ampere2 Upper Threshold not valid!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}elseif($this->input->post('amp2_lt',true) == '')
					{
						$this->response(['status'=>false,'data'=>[],'msg'=>'Ampere2 Lower Threshold required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}elseif(!preg_match("/^[0-9.]*$/",$amp2_lt))
					{
						$this->response(['status'=>false,'data'=>[],'msg'=>'Ampere2 Lower Threshold not valid!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}elseif($this->input->post('volt_3',true) == '')
					{
						$this->response(['status'=>false,'data'=>[],'msg'=>'Volt3 required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}elseif(!preg_match("/^[0-9.]*$/",$volt_3))
					{
						$this->response(['status'=>false,'data'=>[],'msg'=>'Volt3 not valid!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}elseif($this->input->post('v3_ut',true) == '')
					{
						$this->response(['status'=>false,'data'=>[],'msg'=>'Volt3 Upper Threshold required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}elseif(!preg_match("/^[0-9.]*$/",$v3_ut))
					{
						$this->response(['status'=>false,'data'=>[],'msg'=>'Volt3 Upper Threshold not valid!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}elseif($this->input->post('v3_lt',true) == '')
					{
						$this->response(['status'=>false,'data'=>[],'msg'=>'Volt3 Lower Threshold required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}elseif(!preg_match("/^[0-9.]*$/",$v3_lt))
					{
						$this->response(['status'=>false,'data'=>[],'msg'=>'Volt3 Lower Threshold not valid!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}elseif($this->input->post('amp_3',true) == '')
					{
						$this->response(['status'=>false,'data'=>[],'msg'=>'Ampere3 required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}elseif(!preg_match("/^[0-9.]*$/",$amp_3))
					{
						$this->response(['status'=>false,'data'=>[],'msg'=>'Ampere3 not valid!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}elseif($this->input->post('amp3_ut',true) == '')
					{
						$this->response(['status'=>false,'data'=>[],'msg'=>'Ampere3 Upper Threshold required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}elseif(!preg_match("/^[0-9.]*$/",$amp3_ut))
					{
						$this->response(['status'=>false,'data'=>[],'msg'=>'Ampere3 Upper Threshold not valid!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}elseif($this->input->post('amp3_lt',true) == '')
					{
						$this->response(['status'=>false,'data'=>[],'msg'=>'Ampere3 Lower Threshold required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}elseif(!preg_match("/^[0-9.]*$/",$amp3_lt))
					{
						$this->response(['status'=>false,'data'=>[],'msg'=>'Ampere3 Lower Threshold not valid!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}
					$data = [];
					$data['id'] = $Id[0]['UUID()'];
					$data['company_id'] = $this->input->post('company_id',true);
					$data['site_id'] = $this->input->post('site_id',true);
					$data['device_name'] = $this->input->post('device_name',true);
					$data['imei_no'] = $this->input->post('imei_no',true);
					$data['equipment_type'] = $this->input->post('equipment_type',true);
					$data['c_by'] = $this->input->post('c_by',true);
					$data['c_date'] = date('Y-m-d H:i:s');
					$data['status'] = 1;
					$this->Equipment_Allotment_model->Save_EquipmentAllotment_data($data);

					$A_Id = $this->Equipment_Allotment_model->getEqupId();
					$details = [];
					$details['id'] = $A_Id[0]['UUID()'];
					$details['eqp_allot_id'] = $data['id'];
					$details['motor_name'] = $this->input->post('motor_name',true);
					$details['capacity'] = $this->input->post('capacity',true);
					$details['power'] = $this->input->post('power',true);
					$details['phase'] = $this->input->post('phase',true);
					$details['volt_1'] = $this->input->post('volt_1',true);
					$details['v1_ut'] = $this->input->post('v1_ut',true);
					$details['v1_lt'] = $this->input->post('v1_lt',true);
					$details['amp_1'] = $this->input->post('amp_1',true);
					$details['amp1_ut'] = $this->input->post('amp1_ut',true);
					$details['amp1_lt'] = $this->input->post('amp1_lt',true);
					$details['volt_2'] = $this->input->post('volt_2',true);
					$details['v2_ut'] = $this->input->post('v2_ut',true);
					$details['v2_lt'] = $this->input->post('v2_lt',true);
					$details['amp_2'] = $this->input->post('amp_2',true);
					$details['amp2_ut'] = $this->input->post('amp2_ut',true);
					$details['amp2_lt'] = $this->input->post('amp2_lt',true);
					$details['volt_3'] = $this->input->post('volt_3',true);
					$details['v3_ut'] = $this->input->post('v3_ut',true);
					$details['v3_lt'] = $this->input->post('v3_lt',true);
					$details['amp_3'] = $this->input->post('amp_3',true);
					$details['amp3_ut'] = $this->input->post('amp3_ut',true);
					$details['amp3_lt'] = $this->input->post('amp3_lt',true);
					$details['c_by'] = $this->input->post('c_by',true);
					$details['c_date'] = date('Y-m-d H:i:s');
					$details['status'] = 1;
					$this->Equipment_Allotment_model->Save_Equipment_Details_data($details);


				}
				$this->Equipment_Allotment_model->UpdateAllotedDevice(['allot_status'=>1,'d_by'=>$this->input->post('c_by',true),'d_date'=>date('Y-m-d H:i:s')],['imei_no'=>$this->input->post('imei_no',true)]);

				$this->response(['status'=>true,'data'=>[],'msg'=>'Successfully Equipment Alloted','response_code'=>REST_Controller::HTTP_OK]);
				
			} catch (Exception $e) {
				$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
			}
		}
	}
}
?>