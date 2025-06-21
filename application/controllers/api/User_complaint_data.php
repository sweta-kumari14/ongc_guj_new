<?php
require APPPATH.'libraries/REST_Controller.php';
class User_complaint_data extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('User_complaint_data_model');
	}

    public function Add_complaint_data_post()
    {
        $well_id = $this->input->post('well_id',true);
        $user_id = $this->input->post('user_id',true);
        $company_id = $this->input->post('company_id',true);
        $complaint_description = $this->input->post('complaint_description',true);
        $complaint_type = $this->input->post('complaint_type',true);


        if($this->input->post('company_id',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Company Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif($this->input->post('user_id',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'User Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif($this->input->post('well_id',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Well Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif($this->input->post('complaint_description',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Complaint Description required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif(!preg_match("/^[a-zA-Z0-9-.,\/ ]*$/",$complaint_description))
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Complaint Description not valid !!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif($this->input->post('complaint_type',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'complaint type required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif($this->input->post('c_by',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'c kon required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }else{
            try {

                        $verify = $this->User_complaint_data_model->get_well_details($this->input->post('well_id',true));
                               
                            $id = $this->User_complaint_data_model->getCOMId();

                            $verify_ticket_id = $this->User_complaint_data_model->get_ticket_id();
                            
                         
                            if(empty($verify_ticket_id))
                            {
                                $ticket_id = 'TKT#001';
                            }else{
                                  $latestTicketId   = $verify_ticket_id['ticket_id'];
                                  $nextTicketNumber = intval(substr($latestTicketId, 4)) + 1;
                                  $ticket_id = 'TKT#' . str_pad($nextTicketNumber, 3, '0', STR_PAD_LEFT);

                            }
                            
                                $data = [];
                                $data['id'] = $id[0]['UUID()'];
                                $data['company_id'] = $this->input->post('company_id',true);
                                $data['user_id'] = $this->input->post('user_id',true);
                                $data['well_id'] = $this->input->post('well_id',true);
                                $data['device_name'] = $verify[0]['device_name'];
                                $data['imei_no'] = $verify[0]['imei_no'];
                                $data['date_of_installation'] = $verify[0]['date_of_installation'];
                                $data['ticket_id'] = $ticket_id;
                                $data['complaint_description'] = $this->input->post('complaint_description',true);
                                $data['complaint_type'] = $this->input->post('complaint_type',true);
                                $data['c_by'] = $this->input->post('c_by',true);
                                $data['c_date'] = date('Y-m-d H:i:s');
                                $data['status'] = 1;
                                $data['complaint_status'] = 0;
                             
                                $this->User_complaint_data_model->Save_complaint($data);

                                 $id = $this->User_complaint_data_model->getCOMlogId();

                                $data_log = [];
                                $data_log['id'] = $id[0]['UUID()'];
                                $data_log['company_id'] = $this->input->post('company_id',true);
                                $data_log['user_id'] = $this->input->post('user_id',true);
                                $data_log['well_id'] = $this->input->post('well_id',true);
                                $data_log['device_name'] = $verify[0]['device_name'];
                                $data_log['imei_no'] = $verify[0]['imei_no'];
                                $data_log['date_of_installation'] = $verify[0]['date_of_installation'];
                                $data_log['ticket_id'] = $ticket_id;
                                $data_log['complaint_description'] = $this->input->post('complaint_description',true);
                                $data_log['complaint_type'] = $this->input->post('complaint_type',true);
                                $data_log['c_by'] = $this->input->post('c_by',true);
                                $data_log['c_date'] = date('Y-m-d H:i:s');
                                $data_log['status'] = 1;
                                $data_log['complaint_status'] = 0;
                                $this->User_complaint_data_model->Save_complaint_log($data_log);

                           

                    $this->response(['status'=>true,'data'=>[], 'msg'=>'Thank You! Grievance  Successfully Raised! Your ticket has been created with ID: ' . $data['ticket_id'],'response_code'=>REST_Controller::HTTP_OK]);
                    
                }catch (Exception $e) {
                $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong !!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
            }
        }
    }


    public function get_complaint_list_post()
    {
        try {
            $company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
            $user_id = $this->input->post('user_id',true)!=''?$this->input->post('user_id',true):'';
            $id = $this->input->post('id',true)!=''?$this->input->post('id',true):'';
            $ticket_id = $this->input->post('ticket_id',true)!=''?$this->input->post('ticket_id',true):'';
            
            $result = $this->User_complaint_data_model->get_complaint_details_list($company_id,$user_id,$id,$ticket_id);

            $this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
        }catch (Exception $e) {
            $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

    Public function get_report_complaint_details_post()
    {
        try {
            $company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
            $user_id = $this->input->post('user_id',true)!=''?$this->input->post('user_id',true):'';
            $from_date = $this->input->post('from_date',true)!=''?$this->input->post('from_date',true):'';
            $to_date = $this->input->post('to_date',true)!=''?$this->input->post('to_date',true):'';
            $ticket_id = $this->input->post('ticket_id',true)!=''?$this->input->post('ticket_id',true):'';
            $complaint_status = $this->input->post('complaint_status',true)!=''?$this->input->post('complaint_status',true):'';
            
            $result = $this->User_complaint_data_model->get_complaint_details($company_id,$user_id,$from_date,$to_date,$ticket_id,$complaint_status);

            $this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
        }catch (Exception $e) {
            $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

     Public function get_report_complaint_ticket_details_post()
    {
        try {
            $company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
            $area_id = $this->input->post('area_id',true)!=''?$this->input->post('area_id',true):'';
            $from_date = $this->input->post('from_date',true)!=''?$this->input->post('from_date',true):'';
            $to_date = $this->input->post('to_date',true)!=''?$this->input->post('to_date',true):'';
            $ticket_id = $this->input->post('ticket_id',true)!=''?$this->input->post('ticket_id',true):'';
            $complaint_status = $this->input->post('complaint_status',true)!=''?$this->input->post('complaint_status',true):'';
            $sort_by = $this->input->post('sort_by',true)!=''?$this->input->post('sort_by',true):'';
            
            $result = $this->User_complaint_data_model->get_complaint_ticket_details($company_id,$area_id,$from_date,$to_date,$ticket_id,$complaint_status,$sort_by);

            $this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
        }catch (Exception $e) {
            $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }


    Public function get_report_complaint_log_post()
    {
        try {
            $company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
            $user_id = $this->input->post('user_id',true)!=''?$this->input->post('user_id',true):'';
            $from_date = $this->input->post('from_date',true)!=''?$this->input->post('from_date',true):'';
            $to_date = $this->input->post('to_date',true)!=''?$this->input->post('to_date',true):'';
            $ticket_id = $this->input->post('ticket_id',true)!=''?$this->input->post('ticket_id',true):'';
            $well_id = $this->input->post('well_id',true)!=''?$this->input->post('well_id',true):'';
            
            $result = $this->User_complaint_data_model->get_complaint_log($company_id,$user_id,$from_date,$to_date,$ticket_id,$well_id);

            $this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
        }catch (Exception $e) {
            $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

    public function Update_complaint_data_post()
    {
         $ticket_id = $this->input->post('ticket_id', true);
         $well_id = $this->input->post('well_id', true);
         $d_by = $this->input->post('d_by', true);

        if($this->input->post('ticket_id',true) == '') 
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Ticket ID required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif ($this->input->post('complaint_status',true) == '') 
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Complaint Status required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif ($this->input->post('resolution_description',true) == '') 
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Description required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif ($this->input->post('d_by',true) == '') 
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'D Kon required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }else{
            try {

                $verify = $this->User_complaint_data_model->get_ticket_details($this->input->post('ticket_id',true));

                // print_r($verify);die;
                
                if($verify[0]['complaint_status'] == $this->input->post('complaint_status',true))
                {

                     $this->response(['status'=>false,'data'=>[],'msg'=>'Grievance  Status  Same Alredy Exist!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
                   

                }elseif($verify[0]['complaint_status'] == 0 && $this->input->post('complaint_status', true) == 2) 
                {
 
                    $this->response(['status' => false, 'data' => [], 'msg' => 'Please update the Grievance  Status to In Progress before marking it as Solved.', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
                }else{

                    $data = [];
                    $data['resolution_description'] = $this->input->post('resolution_description',true);
                    $data['complaint_status'] = $this->input->post('complaint_status',true);
                    $data['d_by'] = $this->input->post('d_by',true);
                    $data['d_date'] = date('Y-m-d H:i:s');
                    $data['status'] = 1;

                    $this->User_complaint_data_model->Update_status_complaint($data,['id'=>$this->input->post('id',true)]);
                    
                    $id = $this->User_complaint_data_model->getCOMlogId();
                    $data_log = [];
                    $data_log['id'] = $id[0]['UUID()'];
                    $data_log['company_id'] = $this->input->post('company_id',true);
                    $data_log['user_id'] = $this->input->post('user_id',true);
                    $data_log['well_id'] = $this->input->post('well_id',true);
                    $data_log['device_name'] = $this->input->post('device_name',true);
                    $data_log['imei_no'] = $this->input->post('imei_no',true);
                    $data_log['date_of_installation'] = $this->input->post('date_of_installation',true);
                    $data_log['ticket_id'] = $this->input->post('ticket_id',true);
                    $data_log['complaint_description'] = $this->input->post('complaint_description',true);
                    $data_log['complaint_type'] = $this->input->post('complaint_type',true);
                    $data_log['resolution_description'] = $this->input->post('resolution_description',true);
                    $data_log['complaint_status'] = $this->input->post('complaint_status',true);
                    $data_log['c_by'] = $this->input->post('d_by',true);
                    $data_log['c_date'] = date('Y-m-d H:i:s');
                    $data_log['status'] = 1;
                   
                    $this->User_complaint_data_model->Save_complaint_log($data_log);

                           

                }
                
                 $this->response(['status'=>true,'data'=>[],'msg'=>'Successfully Update!!','response_code'=>REST_Controller::HTTP_OK]);


                }catch (Exception $e) {

                $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
            }
        }
    }


    public function get_total_count_post()
    {
        try{

            $company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
            $user_id = $this->input->post('user_id',true)!=''?$this->input->post('user_id',true):'';
            $from_date = $this->input->post('from_date',true)!=''?$this->input->post('from_date',true):'';
            $to_date = $this->input->post('to_date',true)!=''?$this->input->post('to_date',true):'';
            $ticket_id = $this->input->post('ticket_id',true)!=''?$this->input->post('ticket_id',true):'';
            $complaint_status = $this->input->post('complaint_status',true)!=''?$this->input->post('complaint_status',true):'';

            $result = [];
            $result['total_complaints'] = $this->User_complaint_data_model->get_total_complaints($company_id,$user_id,$from_date,$to_date,$ticket_id,$complaint_status);

            $result['total_inprogress'] = $this->User_complaint_data_model->get_total_inprogress($company_id,$user_id,$from_date,$to_date,$ticket_id,$complaint_status);
            $result['total_solved'] = $this->User_complaint_data_model->get_total_solved($company_id,$user_id,$from_date,$to_date,$ticket_id,$complaint_status);


            $this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);



        }catch(Exception $ex)
        {
             $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }


    Public function get_report_complaint_details_log_post()
    {
        try {
            $company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
            $site_id = $this->input->post('site_id',true)!=''?$this->input->post('site_id',true):'';
            $from_date = $this->input->post('from_date',true)!=''?$this->input->post('from_date',true):'';
            $to_date = $this->input->post('to_date',true)!=''?$this->input->post('to_date',true):'';
            $ticket_id = $this->input->post('ticket_id',true)!=''?$this->input->post('ticket_id',true):'';
            $well_id = $this->input->post('well_id',true)!=''?$this->input->post('well_id',true):'';
            $sort_by = $this->input->post('sort_by',true)!=''?$this->input->post('sort_by',true):'';
           
            
            $result = $this->User_complaint_data_model->get_complaint_log_data($company_id,$site_id,$from_date,$to_date,$ticket_id,$well_id,$sort_by);

            $this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
        }catch (Exception $e) {
            $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

}
?>