<?php  
require APPPATH . 'libraries/REST_Controller.php';     
class Real_Time_mqtt_data extends REST_Controller 
{
    public function __construct() 
    {
        parent::__construct();
        $this->load->model('Real_Time_mqtt_model');
    }

    public function Device_configration_send_post()
    {
        
        if($this->input->post('imei_no',true)=='')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Imei no required','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif($this->input->post('command_data',true)=='')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Command data required','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif($this->input->post('c_by',true)=='')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'c kon required','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }else{
            try {
                    $command_data = json_decode($this->input->post('command_data',true),true);
                      // print_r($command_data);die;

                    $topic = "ongc/rj/" . $this->input->post('imei_no',true) . "/ack";

                    // print_r($topic);die;
                
                    $data = [];
                    $data['imei_no'] = $this->input->post('imei_no',true);
                    $data['command_value'] = json_encode($command_data);
                    $data['topic'] = $topic;
                    $data['c_by'] = $this->input->post('c_by',true);
                    $data['c_date'] = date('Y-m-d H:i:s');

                    // print_r($data);die;
                    $this->Real_Time_mqtt_model->SaveDevice_configration($data);

                    $this->response(['status'=>true,'data'=>['imei_no'=>$data['imei_no']],'msg'=>'Your Device Configuration has been done!!!','response_code'=>REST_Controller::HTTP_OK]);
                    
                
            } catch (Exception $e) {
                $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!'.$e->getMessage(),'response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
            }
        }
    }

    public function Device_configration_publish_log_post()
    {
        try {

            $imei_no   = $this->input->post('imei_no', true);
            $from_date = $this->input->post('from_date', true);
            $to_date   = $this->input->post('to_date', true);

            $result = $this->Real_Time_mqtt_model->Device_configration_log($imei_no, $from_date, $to_date);

            $this->response(['status'=> true,'data'=> $result,'msg'            => 'Device Configuration Log Loaded Successfully','response_code'  => REST_Controller::HTTP_OK
            ], REST_Controller::HTTP_OK);

        } catch (Exception $ex) {

            $this->response(['status'=> false,'data'=> [],'msg'=>'Something went wrong!! ' . $ex->getMessage(),'response_code'  => REST_Controller::HTTP_INTERNAL_SERVER_ERROR
            ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
?>