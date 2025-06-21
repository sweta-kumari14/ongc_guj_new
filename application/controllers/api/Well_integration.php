<?php
require APPPATH.'libraries/REST_Controller.php';
class Well_integration extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Well_integration_model');
	}

    public function Add_Well_integration_post()
    {

        $company_id = $this->input->post('company_id',true);
        $assets_id = $this->input->post('assets_id',true);
        $site_id = $this->input->post('site_id',true);
        $area_id = $this->input->post('area_id',true);
        $well_id = $this->input->post('well_id',true);
        $well_name = $this->input->post('well_name',true);
        $well_type = $this->input->post('well_type',true);
        $tentative_date = $this->input->post('tentative_date',true);

        if($this->input->post('company_id',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Company Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif($this->input->post('assets_id',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Assets Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif($this->input->post('site_id',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Site id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif($this->input->post('area_id',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Area id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif($this->input->post('well_type',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'well type required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif(!preg_match('/^[0-2]{1}$/',$well_type))
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'well type should be integer!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif($this->input->post('tentative_date',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Date required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif($this->input->post('c_by',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'c kon required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }else{
            try {

                    if($this->input->post('well_type',true)== 0)
                    {

                         if($this->input->post('well_name',true) == '')
                         {
                              $this->response(['status'=>false,'data'=>[],'msg'=>'Well Nmae required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
                         }elseif(!preg_match("/^[a-zA-Z0-9-# ]*$/",$well_name))
                         {
                            $this->response(['status'=>false,'data'=>[],'msg'=>'Well Name should be alphabet!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
                         }else{

                                $verify_well_name = $this->Well_integration_model->verify_well_name($this->input->post('well_name',true));
                                // print_r($verify_well_id);die;

                                if($verify_well_name == 0)
                                {
                                    $verify_ticket_id = $this->Well_integration_model->get_ticket_id();
                                    if(empty($verify_ticket_id))
                                    {
                                        $ticket_id = 'TKT#01';
                                    }else{
                                          $latestTicketId   = $verify_ticket_id['ticket_id'];
                                          $nextTicketNumber = intval(substr($latestTicketId, 4)) + 1;
                                          $ticket_id = 'TKT#' . str_pad($nextTicketNumber, 2, '0', STR_PAD_LEFT);

                                    }
                                    $id = $this->Well_integration_model->getWIntId();
                                    $data = [];
                                    $data['id'] = $id[0]['UUID()'];
                                    $data['company_id'] = $this->input->post('company_id',true);
                                    $data['assets_id'] = $this->input->post('assets_id',true);
                                    $data['area_id'] = $this->input->post('area_id',true);
                                    $data['site_id'] = $this->input->post('site_id',true);
                                    $data['well_type'] = $this->input->post('well_type',true);
                                    $data['well_name'] = $this->input->post('well_name',true);
                                    $data['operation_date'] = $this->input->post('tentative_date',true);
                                    $data['ticket_id'] = $ticket_id;
                                    $data['c_by'] = $this->input->post('c_by',true);
                                    $data['c_date'] = date('Y-m-d H:i:s');
                                    $data['status'] = 1;
                                    $this->Well_integration_model->Save_well_data($data);

                                    $id = $this->Well_integration_model->getWIntLogId();
                                    $logdata = [];
                                    $logdata['id'] = $id[0]['UUID()'];
                                    $logdata['company_id'] = $data['company_id'];
                                    $logdata['assets_id'] = $data['assets_id'];
                                    $logdata['area_id'] = $data['area_id'];
                                    $logdata['site_id'] = $data['site_id'];
                                    $logdata['well_type'] = $data['well_type'];
                                    $logdata['well_name'] = $data['well_name'];
                                    $logdata['operation_date'] = $data['operation_date'];
                                    $logdata['ticket_id'] = $ticket_id;
                                    $logdata['c_by'] = $data['c_by'];
                                    $logdata['c_date'] = date('Y-m-d H:i:s');
                                    $logdata['status'] = 1;

                                    $this->Well_integration_model->Save_well_log_data($logdata);
                                    $this->response(['status'=>true,'data'=>[],'msg'=>'Thank You! Grievance  Successfully submitted for a new well installation Request!! Your ticket has been created with ID: ' . $data['ticket_id'],'response_code'=>REST_Controller::HTTP_OK]);
                                }else{
                                    $this->response(['status'=>false,'data'=>[],'msg'=>'Well Alredy Requested for installation!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]); 
                                }
                        }

                    }else if($this->input->post('well_type',true)== 1)
                    {

                    
                         if($this->input->post('well_id',true) == '')
                         {
                              $this->response(['status'=>false,'data'=>[],'msg'=>'Well id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
                         }else if($this->input->post('reason_remove',true) == '')
                         {
                              $this->response(['status'=>false,'data'=>[],'msg'=>'Reason Remove required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
                         }else{

                             $verify_well_name = $this->Well_integration_model->verify_well_id_data($this->input->post('well_id',true));
                                // print_r($verify_well_id);die;

                            if($verify_well_name == 0)
                            {
                                
                                 $verify_well = $this->Well_integration_model->verify_well_ExitsOr_Not($this->input->post('well_id',true));
                                 // print_r($verify_well);die;

                                 if($verify_well[0]['total'] == 1)
                                 {
                                    $verify_ticket_id = $this->Well_integration_model->get_ticket_id();
                                    if(empty($verify_ticket_id))
                                    {
                                        $ticket_id = 'TKT#01';
                                    }else{
                                          $latestTicketId   = $verify_ticket_id['ticket_id'];
                                          $nextTicketNumber = intval(substr($latestTicketId, 4)) + 1;
                                          $ticket_id = 'TKT#' . str_pad($nextTicketNumber, 2, '0', STR_PAD_LEFT);

                                    }
                                    $id = $this->Well_integration_model->getWIntId();
                                    $data = [];
                                    $data['id'] = $id[0]['UUID()'];
                                    $data['company_id'] = $this->input->post('company_id',true);
                                    $data['assets_id'] = $this->input->post('assets_id',true);
                                    $data['area_id'] = $this->input->post('area_id',true);
                                    $data['site_id'] = $this->input->post('site_id',true);
                                    $data['well_id'] = $this->input->post('well_id',true);
                                    $data['well_type'] = $this->input->post('well_type',true);
                                    $data['well_name'] = $verify_well[0]['well_name'];
                                    $data['operation_date'] = $this->input->post('tentative_date',true);
                                    $data['ticket_id'] = $ticket_id;
                                    $data['device_name'] = $verify_well[0]['device_name'];
                                    $data['imei_no'] = $verify_well[0]['imei_no'];
                                    $data['reason_remove'] = $this->input->post('reason_remove',true);
                                    $data['c_by'] = $this->input->post('c_by',true);
                                    $data['c_date'] = date('Y-m-d H:i:s');
                                    $data['status'] = 1;
                                    $this->Well_integration_model->Save_well_data($data);

                                    $logdata = [];
                                    $logdata['id'] = $id[0]['UUID()'];
                                    $logdata['company_id'] = $data['company_id'];
                                    $logdata['assets_id'] = $data['assets_id'];
                                    $logdata['area_id'] = $data['area_id'];
                                    $logdata['site_id'] = $data['site_id'];
                                    $logdata['well_id'] = $data['well_id'];
                                    $logdata['well_type'] = $data['well_type'];
                                    $logdata['well_name'] = $verify_well[0]['well_name'];
                                    $logdata['operation_date'] = $data['operation_date'];
                                    $logdata['ticket_id'] = $ticket_id;
                                    $logdata['device_name'] = $verify_well[0]['device_name'];
                                    $logdata['imei_no'] = $verify_well[0]['imei_no'];
                                    $logdata['reason_remove'] = $data['reason_remove'];
                                    $logdata['c_by'] = $data['c_by'];
                                    $logdata['c_date'] = date('Y-m-d H:i:s');
                                    $logdata['status'] = 1;

                                    $this->Well_integration_model->Save_well_log_data($logdata);

                                    $this->response(['status'=>true,'data'=>[],'msg'=>'Thank You! Grievance  Successfully submitted for removing well Request!! Your ticket has been created with ID: ' . $data['ticket_id'],'response_code'=>REST_Controller::HTTP_OK]);
                             }else{
                                    $this->response(['status'=>false,'data'=>[],'msg'=>'Well Not  Exists!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]); 
                                }

                         }else{
                            $this->response(['status'=>false,'data'=>[],'msg'=>'Well Alredy Requested for Remove  !!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]); 
                         }

                    }
                }else if($this->input->post('well_type',true)== 2)
                {

                  
                    if($this->input->post('well_id',true) == '')
                    {
                        $this->response(['status'=>false,'data'=>[],'msg'=>'Well Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
                    }else if($this->input->post('well_status',true) == '')
                    {
                        $this->response(['status'=>false,'data'=>[],'msg'=>'Well Status required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
                    }else if($this->input->post('reason_remove',true) == '')
                    {
                              $this->response(['status'=>false,'data'=>[],'msg'=>'Reason Remove required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
                    }else{

                           if($this->input->post('well_status',true) == 0)
                           {
                            
                                if($this->input->post('to_well_id',true) == '')
                                {
                                   $this->response(['status'=>false,'data'=>[],'msg'=>'To Well Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
                                }else if($this->input->post('reason_remove',true) == '')
                                {
                                    $this->response(['status'=>false,'data'=>[],'msg'=>'Reason Remove required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
                                }else{


                                    $verify_well_id = $this->Well_integration_model->verify_well_id_data($this->input->post('well_id',true));
                                // print_r($verify_well_id);

                                if($verify_well_id == 0)
                                {

                                     $verify_from_well = $this->Well_integration_model->verify_well_ExitsOr_Not($this->input->post('well_id',true));
                                     // print_r($verify_from_well);die;

                                     $verify_to_well = $this->Well_integration_model->verify_well_ExitsOr_Not($this->input->post('to_well_id',true));
                                     // print_r($verify_to_well);die;

                                     if($verify_from_well[0]['total'] == 1)
                                     {
                                        $verify_ticket_id = $this->Well_integration_model->get_ticket_id();
                                        if(empty($verify_ticket_id))
                                        {
                                            $ticket_id = 'TKT#01';
                                        }else{
                                              $latestTicketId   = $verify_ticket_id['ticket_id'];
                                              $nextTicketNumber = intval(substr($latestTicketId, 4)) + 1;
                                              $ticket_id = 'TKT#' . str_pad($nextTicketNumber, 2, '0', STR_PAD_LEFT);

                                        }
                                        $id = $this->Well_integration_model->getWIntId();
                                        $data = [];
                                        $data['id'] = $id[0]['UUID()'];
                                        $data['company_id'] = $this->input->post('company_id',true);
                                        $data['assets_id'] = $this->input->post('assets_id',true);
                                        $data['area_id'] = $this->input->post('area_id',true);
                                        $data['site_id'] = $this->input->post('site_id',true);
                                        $data['well_id'] = $this->input->post('well_id',true);
                                        $data['well_type'] = $this->input->post('well_type',true);
                                        $data['well_status'] = $this->input->post('well_status',true);
                                        $data['well_name'] = $verify_from_well[0]['well_name'];
                                        $data['operation_date'] = $this->input->post('tentative_date',true);
                                        $data['ticket_id'] = $ticket_id;
                                        $data['device_name'] = $verify_from_well[0]['device_name'];
                                        $data['imei_no'] = $verify_from_well[0]['imei_no'];
                                        $data['to_well_id'] = $this->input->post('to_well_id',true);
                                        $data['to_well_name'] = $verify_to_well[0]['well_name'];
                                        $data['to_device_name'] = $verify_to_well[0]['device_name'];
                                        $data['to_imei_no'] = $verify_to_well[0]['imei_no'];
                                        $data['reason_remove'] = $this->input->post('reason_remove',true);
                                        $data['c_by'] = $this->input->post('c_by',true);
                                        $data['c_date'] = date('Y-m-d H:i:s');
                                        $data['status'] = 1;
                                        $this->Well_integration_model->Save_well_data($data);


                                        $logdata = [];
                                        $logdata['id'] = $id[0]['UUID()'];
                                        $logdata['company_id'] = $this->input->post('company_id',true);
                                        $logdata['assets_id'] = $this->input->post('assets_id',true);
                                        $logdata['area_id'] = $this->input->post('area_id',true);
                                        $logdata['site_id'] = $this->input->post('site_id',true);
                                        $logdata['well_id'] = $this->input->post('well_id',true);
                                        $logdata['well_type'] = $this->input->post('well_type',true);
                                        $logdata['well_status'] = $this->input->post('well_status',true);
                                        $logdata['well_name'] = $verify_from_well[0]['well_name'];
                                        $logdata['operation_date'] = $this->input->post('tentative_date',true);
                                        $logdata['ticket_id'] = $ticket_id;
                                        $logdata['device_name'] = $verify_from_well[0]['device_name'];
                                        $logdata['imei_no'] = $verify_from_well[0]['imei_no'];
                                        $logdata['to_well_id'] = $this->input->post('to_well_id',true);
                                        $logdata['to_well_name'] = $verify_to_well[0]['well_name'];
                                        $logdata['to_device_name'] = $verify_to_well[0]['device_name'];
                                        $logdata['to_imei_no'] = $verify_to_well[0]['imei_no'];
                                        $logdata['reason_remove'] = $this->input->post('reason_remove',true);
                                        $logdata['c_by'] = $this->input->post('c_by',true);
                                        $logdata['c_date'] = date('Y-m-d H:i:s');
                                        $logdata['status'] = 1;
                                        $this->Well_integration_model->Save_well_log_data($logdata);

                                        $this->response(['status'=>true,'data'=>[],'msg'=>'Thank You! Grievance  Successfully submitted for Shifting well Request!! Your ticket has been created with ID: ' . $data['ticket_id'],'response_code'=>REST_Controller::HTTP_OK]);
                                 }else{
                                        $this->response(['status'=>false,'data'=>[],'msg'=>'Well Not  Exists!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]); 
                                    }

                                }else{
                                $this->response(['status'=>false,'data'=>[],'msg'=>'Well Alredy Requested for shifted !!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]); 
                               }
                            
                            }
                            }else if($this->input->post('well_status',true) == 1)
                            {
                         

                            if($this->input->post('to_well_name',true) == '')
                            {
                                $this->response(['status'=>false,'data'=>[],'msg'=>'To Well Name required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
                            }else if($this->input->post('reason_remove',true) == '')
                            {
                                $this->response(['status'=>false,'data'=>[],'msg'=>'Reason Remove required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
                            }else{

                                $verify_well_id = $this->Well_integration_model->verify_well_id_data($this->input->post('well_id',true));
                                // print_r($verify_well_id);

                                if($verify_well_id == 0)
                                {
                                

                                     $verify_from_well = $this->Well_integration_model->verify_well_ExitsOr_Not($this->input->post('well_id',true));
                                     // print_r($verify_from_well);die;

                                     if($verify_from_well[0]['total'] == 1)
                                     {
                                        $verify_ticket_id = $this->Well_integration_model->get_ticket_id();
                                        if(empty($verify_ticket_id))
                                        {
                                            $ticket_id = 'TKT#01';
                                        }else{
                                              $latestTicketId   = $verify_ticket_id['ticket_id'];
                                              $nextTicketNumber = intval(substr($latestTicketId, 4)) + 1;
                                              $ticket_id = 'TKT#' . str_pad($nextTicketNumber, 2, '0', STR_PAD_LEFT);

                                        }
                                        $id = $this->Well_integration_model->getWIntId();
                                        $data = [];
                                        $data['id'] = $id[0]['UUID()'];
                                        $data['company_id'] = $this->input->post('company_id',true);
                                        $data['assets_id'] = $this->input->post('assets_id',true);
                                        $data['area_id'] = $this->input->post('area_id',true);
                                        $data['site_id'] = $this->input->post('site_id',true);
                                        $data['well_id'] = $this->input->post('well_id',true);
                                        $data['well_type'] = $this->input->post('well_type',true);
                                        $data['well_status'] = $this->input->post('well_status',true);
                                        $data['well_name'] = $verify_from_well[0]['well_name'];
                                        $data['operation_date'] = $this->input->post('tentative_date',true);
                                        $data['ticket_id'] = $ticket_id;
                                        $data['device_name'] = $verify_from_well[0]['device_name'];
                                        $data['imei_no'] = $verify_from_well[0]['imei_no'];
                                        $data['to_well_name'] = $this->input->post('to_well_name',true);
                                        $data['reason_remove'] = $this->input->post('reason_remove',true);
                                        $data['c_by'] = $this->input->post('c_by',true);
                                        $data['c_date'] = date('Y-m-d H:i:s');
                                        $data['status'] = 1;
                                        $this->Well_integration_model->Save_well_data($data);


                                        $logdata = [];
                                        $logdata['id'] = $id[0]['UUID()'];
                                        $logdata['company_id'] = $this->input->post('company_id',true);
                                        $logdata['assets_id'] = $this->input->post('assets_id',true);
                                        $logdata['area_id'] = $this->input->post('area_id',true);
                                        $logdata['site_id'] = $this->input->post('site_id',true);
                                        $logdata['well_id'] = $this->input->post('well_id',true);
                                        $logdata['well_type'] = $this->input->post('well_type',true);
                                        $logdata['well_status'] = $this->input->post('well_status',true);
                                        $logdata['well_name'] = $verify_from_well[0]['well_name'];
                                        $logdata['operation_date'] = $this->input->post('tentative_date',true);
                                        $logdata['ticket_id'] = $ticket_id;
                                        $logdata['device_name'] = $verify_from_well[0]['device_name'];
                                        $logdata['imei_no'] = $verify_from_well[0]['imei_no'];
                                        $logdata['to_well_name'] = $this->input->post('to_well_name',true);
                                        $logdata['reason_remove'] = $this->input->post('reason_remove',true);
                                        $logdata['c_by'] = $this->input->post('c_by',true);
                                        $logdata['c_date'] = date('Y-m-d H:i:s');
                                        $logdata['status'] = 1;
                                         $this->Well_integration_model->Save_well_log_data($logdata);

                                        $this->response(['status'=>true,'data'=>[],'msg'=>'Your request for Shifting well has been successfully submitted !!','response_code'=>REST_Controller::HTTP_OK]);
                                 }else{
                                        $this->response(['status'=>false,'data'=>[],'msg'=>'Well Not  Exists!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]); 
                                    }

                             }else{
                                        $this->response(['status'=>false,'data'=>[],'msg'=>'Well Alredy Requested for Shifting!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]); 
                                    }
                         }

                       } 
                    }
                } 
                    
                }catch (Exception $e) {
                $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong !!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
            }
        }
    }

    public function well_integration_report_post()
    {
        try {
            $company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
            $from_date = $this->input->post('from_date',true)!=''?$this->input->post('from_date',true):'';
            $to_date = $this->input->post('to_date',true)!=''?$this->input->post('to_date',true):'';
            $site_id = $this->input->post('site_id',true)!=''?$this->input->post('site_id',true):'';
            $sort_by = $this->input->post('sort_by',true)!=''?$this->input->post('sort_by',true):'';
            $ticket_id = $this->input->post('ticket_id',true)!=''?$this->input->post('ticket_id',true):'';
            $well_type = $this->input->post('well_type',true)!=''?$this->input->post('well_type',true):'';
            $result = $this->Well_integration_model->Well_Integration_Report($company_id,$from_date,$to_date,$site_id,$sort_by,$ticket_id,$well_type);

            $this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
        } catch (Exception $e) {
            $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

    public function get_total_count_post()
    {
        try{

            $company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
            $from_date = $this->input->post('from_date',true)!=''?$this->input->post('from_date',true):'';
            $to_date = $this->input->post('to_date',true)!=''?$this->input->post('to_date',true):'';
            $site_id = $this->input->post('site_id',true)!=''?$this->input->post('site_id',true):'';
            $complaint_status = $this->input->post('complaint_status',true)!=''?$this->input->post('complaint_status',true):'';

            $result = [];
            $result['total_request'] = $this->Well_integration_model->get_total_request($company_id,$from_date,$to_date,$site_id,$complaint_status);
            $result['total_pending'] = $this->Well_integration_model->get_total_pending($company_id,$from_date,$to_date,$site_id,$complaint_status);
            $result['total_solved'] = $this->Well_integration_model->get_total_solved($company_id,$from_date,$to_date,$site_id,$complaint_status);


            $this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);

        }catch(Exception $ex)
        {
             $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

    public function Update_well_integration_data_post()
    {
        $ticket_id = $this->input->post('ticket_id', true);
        $well_type = $this->input->post('well_type', true);
        $reason_remove = $this->input->post('reason_remove',true);
        $d_by = $this->input->post('d_by', true);

        if($this->input->post('ticket_id',true) == '') 
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Ticket ID required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif($this->input->post('well_type',true) == '') 
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Well Type required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif ($this->input->post('complaint_status',true) == '') 
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Complaint Status required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif ($this->input->post('reason_remove',true) == '') 
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Remarks required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif ($this->input->post('d_by',true) == '') 
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'D Kon required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }else{
            try {

                $verify = $this->Well_integration_model->get_ticket_wellintdetails($this->input->post('ticket_id',true));

                // print_r($verify);die;

                if($verify[0]['execution_status'] == $this->input->post('complaint_status',true))
                {

                     $this->response(['status'=>false,'data'=>[],'msg'=>'Grievance  Status  Same Alredy Exist!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
                   

                }else{

                    if($well_type == 0)
                    {
                        if($this->input->post('imei_no',true) == '') 
                        {
                            $this->response(['status'=>false,'data'=>[],'msg'=>'Imei No required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
                        }elseif($this->input->post('operation_date',true) == '') 
                        {
                            $this->response(['status'=>false,'data'=>[],'msg'=>'Installation Date required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
                        }else{

                            $data = [];
                            $data['imei_no'] = $this->input->post('imei_no',true);
                            $last_eight_digits = substr($data['imei_no'], -8);
                            $data['device_name'] = 'IOT-RTMS-' . $last_eight_digits;
                            $data['operation_date'] = $this->input->post('operation_date',true);
                            $data['reason_remove'] = $this->input->post('reason_remove',true);
                            $data['execution_status'] = 1;
                            $data['d_by'] = $this->input->post('d_by',true);
                            $data['d_date'] = $this->input->post('operation_date',true);

                            $this->Well_integration_model->Update_status_well_integration($data,['ticket_id'=>$this->input->post('ticket_id',true)]);

                            $id = $this->Well_integration_model->getWIntId();
                            $data_log = [];
                            $data_log['id'] = $id[0]['UUID()'];
                            $data_log['company_id'] = $verify[0]['company_id'];
                            $data_log['assets_id'] = $verify[0]['assets_id'];
                            $data_log['area_id'] = $verify[0]['area_id'];
                            $data_log['site_id'] = $verify[0]['site_id'];
                            $data_log['device_name'] = $data['device_name'];
                            $data_log['imei_no'] = $data['imei_no'];
                            $data_log['well_type'] = $verify[0]['well_type'];
                            $data_log['well_name'] = $verify[0]['well_name'];
                            $data_log['operation_date'] = $data['operation_date'];
                            $data_log['ticket_id'] = $this->input->post('ticket_id',true);
                            $data_log['reason_remove'] = $this->input->post('reason_remove',true);
                            $data_log['execution_status'] = 1;
                            $data_log['well_status'] = $verify[0]['well_status'];
                            $data_log['c_by'] = $this->input->post('d_by',true);
                            $data_log['c_date'] = date('Y-m-d H:i:s');
                            $data_log['status'] = 1;
                           
                            $this->Well_integration_model->Save_well_log_data($data_log);

                        }
                    
                    }elseif($well_type == 1)
                    {
                        if($this->input->post('operation_date',true) == '') 
                        {
                            $this->response(['status'=>false,'data'=>[],'msg'=>'Remove Date required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
                        }else{

                            $data = [];
                            $data['operation_date'] = $this->input->post('operation_date');
                            $data['execution_status'] = 1;
                            $data['reason_remove'] = $this->input->post('reason_remove',true);
                            $data['d_by'] = $this->input->post('d_by',true);
                            $data['d_date'] = $this->input->post('operation_date',true);

                            $this->Well_integration_model->Update_status_well_integration($data,['ticket_id'=>$this->input->post('ticket_id',true)]);

                            $id = $this->Well_integration_model->getWIntId();
                            $data_log = [];
                            $data_log['id'] = $id[0]['UUID()'];
                            $data_log['company_id'] = $verify[0]['company_id'];
                            $data_log['assets_id'] = $verify[0]['assets_id'];
                            $data_log['area_id'] = $verify[0]['area_id'];
                            $data_log['site_id'] = $verify[0]['site_id'];
                            $data_log['device_name'] = $verify[0]['device_name'];
                            $data_log['imei_no'] = $verify[0]['imei_no'];
                            $data_log['well_type'] = $verify[0]['well_type'];
                            $data_log['well_id'] = $verify[0]['well_id'];
                            $data_log['well_name'] = $verify[0]['well_name'];
                            $data_log['operation_date'] = $data['operation_date'];
                            $data_log['ticket_id'] = $this->input->post('ticket_id',true);
                            $data_log['reason_remove'] = $this->input->post('reason_remove',true);
                            $data_log['execution_status'] = 1;
                            $data_log['well_status'] = $verify[0]['well_status'];
                            $data_log['c_by'] = $this->input->post('d_by',true);
                            $data_log['c_date'] = date('Y-m-d H:i:s');
                            $data_log['status'] = 1;
                           
                            $this->Well_integration_model->Save_well_log_data($data_log);

                        }
                    
                    }elseif($well_type == 2)
                    {
                        if($this->input->post('operation_date',true) == '') 
                        {
                            $this->response(['status'=>false,'data'=>[],'msg'=>'Shifting Date required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
                        }else{

                            $data = [];
                            $data['operation_date'] = $this->input->post('operation_date');
                            $data['execution_status'] = 1;
                            $data['d_by'] = $this->input->post('d_by',true);
                            $data['d_date'] = $this->input->post('operation_date',true);
                            $data['reason_remove'] = $this->input->post('reason_remove',true);

                            $this->Well_integration_model->Update_status_well_integration($data,['ticket_id'=>$this->input->post('ticket_id',true)]);

                            $id = $this->Well_integration_model->getWIntId();
                            $data_log = [];
                            $data_log['id'] = $id[0]['UUID()'];
                            $data_log['company_id'] = $verify[0]['company_id'];
                            $data_log['assets_id'] = $verify[0]['assets_id'];
                            $data_log['area_id'] = $verify[0]['area_id'];
                            $data_log['site_id'] = $verify[0]['site_id'];
                            $data_log['device_name'] = $verify[0]['device_name'];
                            $data_log['imei_no'] = $verify[0]['imei_no'];
                            $data_log['well_type'] = $verify[0]['well_type'];
                            $data_log['well_name'] = $verify[0]['well_name'];
                            $data_log['to_well_id'] = $verify[0]['to_well_id'];
                            $data_log['to_well_name'] = $verify[0]['to_well_name'];
                            $data_log['to_device_name'] = $verify[0]['to_device_name'];
                            $data_log['to_imei_no'] = $verify[0]['to_imei_no'];
                            $data_log['operation_date'] = $data['operation_date'];
                            $data_log['ticket_id'] = $this->input->post('ticket_id',true);
                            $data_log['reason_remove'] = $this->input->post('reason_remove',true);
                            $data_log['execution_status'] = 1;
                            $data_log['well_status'] = $verify[0]['well_status'];
                            $data_log['c_by'] = $this->input->post('d_by',true);
                            $data_log['c_date'] = date('Y-m-d H:i:s');
                            $data_log['status'] = 1;
                           
                            $this->Well_integration_model->Save_well_log_data($data_log);

                        }
                    
                    }
                }
                
                 $this->response(['status'=>true,'data'=>[],'msg'=>'Successfully Update!!','response_code'=>REST_Controller::HTTP_OK]);


                }catch (Exception $e) {

                $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
            }
        }
    }

   public function Well_feeder_change_post()
{
    $well_id = $this->input->post('well_id', true);
    $well_type = $this->input->post('well_type', true);
    $feeder_id = $this->input->post('feeder_id', true);
    $d_by = $this->input->post('d_by', true);

    if ($well_id == '') {
        $this->response(['status' => false, 'data' => [], 'msg' => 'W ID required!!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
        return;
    }
    if ($well_type == '') {
        $this->response(['status' => false, 'data' => [], 'msg' => 'well type required!!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
        return;
    }
    if ($feeder_id == '') {
        $this->response(['status' => false, 'data' => [], 'msg' => 'feeder_id required!!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
        return;
    }
   // if ($d_by == '') {
       // $this->response(['status' => false, 'data' => [], 'msg' => 'd Kon required!!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
       // return;
   // }

    try {
        $data = [
            'feeder_id' => $feeder_id,
            'd_by' => $d_by,
            'd_date' => date('Y-m-d H:i:s')
        ];

        $where = ['well_id' => $well_id];

        if ($well_type == 1) {
            
            $update_result = $this->Well_integration_model->update_well_feeder($data, $where);
        } else if ($well_type == 2) {
            $update_result = $this->Well_integration_model->update_well_feeder_selfflow($data, $where);
        } else {
            $this->response(['status' => false, 'data' => [], 'msg' => 'Invalid well type!!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
            return;
        }

        if ($update_result) {
            $this->response(['status' => true, 'data' => [], 'msg' => 'Successfully Updated!!', 'response_code' => REST_Controller::HTTP_OK]);
        } else {
            $this->response(['status' => false, 'data' => [], 'msg' => 'Update failed!!', 'response_code' => REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        }
    } catch (Exception $e) {
        $this->response(['status' => false, 'data' => [], 'msg' => 'Something went wrong!!', 'response_code' => REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
    }
}

}
?>