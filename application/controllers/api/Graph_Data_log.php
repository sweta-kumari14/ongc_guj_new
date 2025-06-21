<?php
require APPPATH.'libraries/REST_Controller.php';
class Graph_Data_log extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Graph_data_log_model');
	}

	public function Add_Graph_data_log_post()
	{
		$imei_no = $this->input->post('imei_no',true);

		if($this->input->post('imei_no',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'imei required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[a-zA-Z0-9]{10,20}$/",$imei_no))
      {
         $this->response(['status'=>false,'data'=>[],'msg'=>'IMEI should be 10 to 20 digit and character allowed !!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
      }else{
			 try{
			 	$verify = $this->Graph_data_log_model->AlreadyexistImei($this->input->post('imei_no',true));
			 	
               if($verify == 0)
               { 
                	
                	$Deviclogdata = $this->Graph_data_log_model->ExistDetails($this->input->post('imei_no',true));
                	// print_r($Deviclogdata);die;
                   
                  $data = [];
                  $data['imei_no'] = $Deviclogdata[0]['imei_no'];
                  $data['input_Kwh'] = $Deviclogdata[0]['input_Kwh'];
                  $data['input_Voltage_L2N_R'] = $Deviclogdata[0]['input_Voltage_L2N_R'];
                  $data['input_Voltage_L2N_Y'] = $Deviclogdata[0]['input_Voltage_L2N_Y'];
                  $data['input_Voltage_L2N_B'] = $Deviclogdata[0]['input_Voltage_L2N_B'];
                  $data['input_Average_Voltage_L2N'] = $Deviclogdata[0]['input_Average_Voltage_L2N'];
                  $data['input_Voltage_P2P_RY'] = $Deviclogdata[0]['output_Voltage_P2P_RY'];
                  $data['input_Voltage_P2P_YB'] = $Deviclogdata[0]['output_Voltage_P2P_YB'];
                  $data['input_Voltage_P2P_BR'] = $Deviclogdata[0]['output_Voltage_P2P_BR'];
                  $data['input_Average_Voltage_P2P'] = $Deviclogdata[0]['input_Average_Voltage_P2P'];
                  $data['input_Current_R'] = $Deviclogdata[0]['input_Current_R'];
                  $data['input_Current_Y'] = $Deviclogdata[0]['input_Current_Y'];
                  $data['input_Current_B'] = $Deviclogdata[0]['input_Current_B'];
                  $data['input_Average_Current'] = $Deviclogdata[0]['input_Average_Current'];
                  $data['input_System_Frequency'] = $Deviclogdata[0]['input_System_Frequency'];
                  $data['input_System_Running_KW'] = $Deviclogdata[0]['input_System_Running_KW'];
                  $data['output_Kwh'] = $Deviclogdata[0]['output_Kwh'];
                  $data['output_Voltage_L2N_R'] = $Deviclogdata[0]['output_Voltage_L2N_R'];
                  $data['output_Voltage_L2N_Y'] = $Deviclogdata[0]['output_Voltage_L2N_Y'];
                  $data['output_Voltage_L2N_B'] = $Deviclogdata[0]['output_Voltage_L2N_B'];
                  $data['output_Average_Voltage_L2N'] = $Deviclogdata[0]['output_Average_Voltage_L2N'];
                  $data['output_Voltage_P2P_RY'] = $Deviclogdata[0]['output_Voltage_P2P_RY'];
                  $data['output_Voltage_P2P_YB'] = $Deviclogdata[0]['output_Voltage_P2P_YB'];
                  $data['output_Voltage_P2P_BR'] = $Deviclogdata[0]['output_Voltage_P2P_BR'];
                  $data['output_Average_Voltage_P2P'] = $Deviclogdata[0]['output_Average_Voltage_P2P'];
                  $data['output_Current_R'] = $Deviclogdata[0]['output_Current_R'];
                  $data['output_Current_Y'] = $Deviclogdata[0]['output_Current_Y'];
                  $data['output_Current_B'] = $Deviclogdata[0]['output_Current_B'];
                  $data['output_Average_Current'] = $Deviclogdata[0]['output_Average_Current'];
                  $data['output_System_Frequency'] = $Deviclogdata[0]['output_System_Frequency']; 
                  $data['output_System_Running_KW'] = $Deviclogdata[0]['output_System_Running_KW'];
                  $data['log_date_time'] = $Deviclogdata[0]['offline_device_timestamp'];

                  $this->Graph_data_log_model->Device_log_detail_Save($data);
                  
               }else{

                 	$device_log = $this->Graph_data_log_model->log_time_less($this->input->post('imei_no',true));
                 	// print_r($device_log);die;
                  $details = [];

                	$details['imei_no'] = $device_log[0]['imei_no'];
                  $details['input_Kwh'] = $device_log[0]['input_Kwh'];
                  $details['input_Voltage_L2N_R'] = $device_log[0]['input_Voltage_L2N_R'];
                  $details['input_Voltage_L2N_Y'] = $device_log[0]['input_Voltage_L2N_Y'];
                  $details['input_Voltage_L2N_B'] = $device_log[0]['input_Voltage_L2N_B'];
                  $details['input_Average_Voltage_L2N'] = $device_log[0]['input_Average_Voltage_L2N'];
                  $details['input_Voltage_P2P_RY'] = $device_log[0]['output_Voltage_P2P_RY'];
                  $details['input_Voltage_P2P_YB'] = $device_log[0]['output_Voltage_P2P_YB'];
                  $details['input_Voltage_P2P_BR'] = $device_log[0]['output_Voltage_P2P_BR'];
                  $details['input_Average_Voltage_P2P'] = $device_log[0]['output_Average_Voltage_P2P'];
                  $details['input_Current_R'] = $device_log[0]['input_Current_R'];
                  $details['input_Current_Y'] = $device_log[0]['input_Current_Y'];
                  $details['input_Current_B'] = $device_log[0]['input_Current_B'];
                  $details['input_Average_Current'] = $device_log[0]['input_Average_Current'];
                  $details['input_System_Frequency'] = $device_log[0]['input_System_Frequency'];
                  $details['input_System_Running_KW'] = $device_log[0]['input_System_Running_KW'];
                  $details['output_Kwh'] = $device_log[0]['output_Kwh'];
                  $details['output_Voltage_L2N_R'] = $device_log[0]['output_Voltage_L2N_R'];
                  $details['output_Voltage_L2N_Y'] = $device_log[0]['output_Voltage_L2N_Y'];
                  $details['output_Voltage_L2N_B'] = $device_log[0]['output_Voltage_L2N_B'];
                  $details['output_Average_Voltage_L2N'] = $device_log[0]['output_Average_Voltage_L2N'];
                  $details['output_Voltage_P2P_RY'] = $device_log[0]['output_Voltage_P2P_RY'];
                  $details['output_Voltage_P2P_YB'] = $device_log[0]['output_Voltage_P2P_YB'];
                  $details['output_Voltage_P2P_BR'] = $device_log[0]['output_Voltage_P2P_BR'];
                  $details['output_Average_Voltage_P2P'] = $device_log[0]['output_Average_Voltage_P2P'];
                  $details['output_Current_R'] = $device_log[0]['output_Current_R']; 
                  $details['output_Current_Y'] = $device_log[0]['output_Current_Y'];
                  $details['output_Current_B'] = $device_log[0]['output_Current_B'];
                  $details['output_Average_Current'] = $device_log[0]['output_Average_Current'];
                  $details['output_System_Frequency'] = $device_log[0]['output_System_Frequency'];
                  $details['output_System_Running_KW'] = $device_log[0]['output_System_Running_KW'];
                  $details['log_date_time'] = $device_log[0]['offline_device_timestamp'];
            
                  $this->Graph_data_log_model->Device_Details_Save($details);

               }

               $this->response(['status'=>true,'data'=>[],'msg'=>'Successfully saved!! ','response_code'=>REST_Controller::HTTP_OK]);

			 }catch(Exception $ex){
			 	$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
			 }
		}

	}
}
?>