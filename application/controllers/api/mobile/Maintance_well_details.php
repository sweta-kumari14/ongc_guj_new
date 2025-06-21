<?php
require APPPATH.'libraries/REST_Controller.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once APPPATH . 'third_party/PHPMailer/Exception.php';
require_once APPPATH . 'third_party/PHPMailer/PHPMailer.php';
require_once APPPATH . 'third_party/PHPMailer/SMTP.php'; 
class Maintance_well_details extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('mobile_model/Maintance_well_details_model');
	}

	public function Add_well_open_case_post()
	{
        $area_id = $this->input->post('area_id',true);
        $site_id = $this->input->post('site_id',true);
        $well_id = $this->input->post('well_id',true);
        $issue_type_id = $this->input->post('issue_type_id',true);

       	if($this->input->post('site_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'site Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('area_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'A Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('well_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'well required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('issue_type_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'issue type required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('c_by',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'C kon equired!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}else{
			try 
			{	
					$data = [];
					$data['site_id'] = $this->input->post('site_id',true);
					$data['area_id'] = $this->input->post('area_id',true);
					$data['well_id'] = $this->input->post('well_id',true);
					$data['issue_type_id'] = $this->input->post('issue_type_id',true);
					$data['maintance_id'] = $this->Maintance_well_details_model->get_next_ref_no();
					$data['issue_status'] = 1;
					$data['c_by'] = $this->input->post('c_by',true);
					$data['c_date'] = date('Y-m-d H:i:s');
					$data['status'] = 1;
					$this->Maintance_well_details_model->Save_Maintance($data);

					$Logdata = [];
					$Logdata['site_id'] = $this->input->post('site_id',true);
					$Logdata['area_id'] = $this->input->post('area_id',true);
					$Logdata['well_id'] = $this->input->post('well_id',true);
					$Logdata['issue_type_id'] = $this->input->post('issue_type_id',true);
					$Logdata['maintance_id'] = $data['maintance_id'];
					$Logdata['issue_status'] = 1;
					$Logdata['c_by'] = $this->input->post('c_by',true);
					$Logdata['c_date'] = date('Y-m-d H:i:s');
					$Logdata['status'] = 1;
					$this->Maintance_well_details_model->Save_Maintancelog($Logdata);
					$this->response(['status'=>true,'data'=>[],'msg'=>'Successfully Saved!!','response_code'=>REST_Controller::HTTP_OK]);
						
        	
			}catch (Exception $e){
				$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
				}
		}
    }

    public function Update_well_open_case_post()
    {
	    $maintance_id = $this->input->post('maintance_id', true);
	    $issue_status = $this->input->post('issue_status', true);
	    $d_by = $this->input->post('d_by', true);
	    $action_taken = $this->input->post('action_taken', true);
	    $quantity = $this->input->post('quantity', true);
	    $item_serial = $this->input->post('item_serial', true);
	    
	    if (empty($maintance_id)) {
	        $this->response(['status' => false, 'msg' => 'Maintance ID required!!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
	    } elseif (empty($issue_status)) {
	        $this->response(['status' => false, 'msg' => 'Issue Status required!!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
	    } elseif (empty($d_by)) {
	        $this->response(['status' => false, 'msg' => 'D Kon required!!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
	    } else {
	        try {
	            $verify = $this->Maintance_well_details_model->get_maintance_details($maintance_id);
	            
	            if ($verify[0]['issue_status'] == $issue_status) {
	                $this->response(['status' => false, 'msg' => 'Status Same Already Exist!!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
	            } elseif ($verify[0]['issue_status'] == 1 && $issue_status == 3) {
	                $this->response(['status' => false, 'msg' => 'Please update the Status to In Progress before marking it as Solved.', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
	            } else {
	                if ($issue_status == 3) {
	                    if (empty($action_taken)) {
	                        $this->response(['status' => false, 'msg' => 'Action required!!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
	                    } elseif ($action_taken == 2) {
	                        if (empty($quantity)) {
	                            $this->response(['status' => false, 'msg' => 'Quantity required!!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
	                        } elseif (empty($item_serial)) {
	                            $this->response(['status' => false, 'msg' => 'Serial no. required!!', 'response_code' => REST_Controller::HTTP_BAD_REQUEST]);
	                        }
	                    }
	                }
	                
	                $data = [
	                    'issue_status' => $issue_status,
	                    'd_by' => $d_by,
	                    'd_date' => date('Y-m-d H:i:s'),
	                ];
	                
	                if ($issue_status == 3) {
	                    $data['action_taken'] = $action_taken;
	                    if ($action_taken == 2) {
	                        $data['quantity'] = $quantity;
	                        $data['item_serial'] = $item_serial;
	                    }
	                }
	                
	                $this->Maintance_well_details_model->Update_status_maintance($data, ['maintance_id' => $maintance_id]);
	                
	                $data_log = [
	                    'area_id' => $verify[0]['area_id'],
	                    'well_id' => $verify[0]['well_id'],
	                    'site_id' => $verify[0]['site_id'],
	                    'issue_status' => $issue_status,
	                    'issue_type_id' => $verify[0]['issue_type_id'],
	                    'maintance_id' => $maintance_id,
	                    'c_by' => $d_by,
	                    'c_date' => date('Y-m-d H:i:s'),
	                    'status' => 1,
	                ];
	                
	                if ($issue_status == 3) {
	                    $data_log['action_taken'] = $action_taken;
	                    if ($action_taken == 2) {
	                        $data_log['quantity'] = $quantity;
	                        $data_log['item_serial'] = $item_serial;
	                    }
	                }
	                
	                $this->Maintance_well_details_model->Save_Maintancelog($data_log);
	                
	                $this->response(['status' => true, 'msg' => 'Successfully Updated!!', 'response_code' => REST_Controller::HTTP_OK]);
	            }
	        } catch (Exception $e) {
	            $this->response(['status' => false, 'msg' => 'Something went wrong!!', 'response_code' => REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
	        }
	    }
	}


    public function Report_Maintance_post()
	{
		try {
			$maintance_id = $this->input->post('maintance_id',true)!=""?$this->input->post('maintance_id',true):"";
			$case_status = $this->input->post('case_status',true)!=""?$this->input->post('case_status',true):"";
			$user_id = $this->input->post('user_id',true)!=""?$this->input->post('user_id',true):"";
			$well_id = $this->input->post('well_id',true)!=""?$this->input->post('well_id',true):"";
			$from_date = $this->input->post('from_date',true)!=""?$this->input->post('from_date',true):"";
			$to_date = $this->input->post('to_date',true)!=""?$this->input->post('to_date',true):"";
			$result = $this->Maintance_well_details_model->MaintanceList($maintance_id,$well_id,$from_date,$to_date,$case_status,$user_id);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	  
	}

	public function dashboard_count_post()
	{
		try {
			$user_id = $this->input->post('user_id',true)!=""?$this->input->post('user_id',true):"";
			$result['total_case'] =  $this->Maintance_well_details_model->get_total_case($user_id);
			$result['total_open'] =  $this->Maintance_well_details_model->get_total_open($user_id);
			$result['total_in_progress'] =  $this->Maintance_well_details_model->get_total_inprogress($user_id);
			$result['total_close'] =  $this->Maintance_well_details_model->get_total_close($user_id);
			
			$this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	  
	}

	public function get_area_list_post()
	{
        try {
			
			$result = $this->Maintance_well_details_model->AreaList();
			$this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function get_site_list_post()
	{
        try {
        	$area_id = $this->input->post('area_id',true)!=""?$this->input->post('area_id',true):"";
			$result = $this->Maintance_well_details_model->siteList($area_id);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function get_welllist_post()
	{
        try {
        	$area_id = $this->input->post('area_id',true)!=""?$this->input->post('area_id',true):"";
        	$site_id = $this->input->post('site_id',true)!=""?$this->input->post('site_id',true):"";
			$result = $this->Maintance_well_details_model->wellList($area_id,$site_id);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		}catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}

	public function get_problemlist_post()
	{
        try{

			$result = $this->Maintance_well_details_model->problemList();
			$this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		}catch (Exception $e) 
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}


    // For mail Purpose  code 


	public function get_case_details_for_mail_post()
	{
	
	    $case_details = $this->Maintance_well_details_model->get_well_case_details();
	    
	    if(!empty($case_details))
        {

        	  $count_details = $this->Maintance_well_details_model->get_total_case_count();

		    $total_open = $total_in_progress = $total_closed = 0;

		    $total_open = $count_details['total_open'];
		    $total_in_progress = $count_details['total_in_progress'];
		    $total_closed = $count_details['total_closed'];

		    $issue_counts = [];

		    foreach ($case_details as $case) {
		        
		        $issue_type = $case['issue_type'];
		        if (!isset($issue_counts[$issue_type])) {
		            $issue_counts[$issue_type] = 0;
		        }
		        $issue_counts[$issue_type]++;
		    }

		    $total_cases = count($case_details);
		    $content = '';

		    $content  = '<html><head>';
			$content .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
			$content .= '<title>ONGC Cambay Assets Case Details</title>';
			$content .= '<style> 
			            body { font-family: Arial, sans-serif; background:#f4f4f4; padding:20px; margin:0; color:#333; }
			            .container { max-width: 900px; margin: auto; background:#fff; padding:20px; border-radius:8px; box-shadow: 0px 4px 8px rgba(0,0,0,0.1); }
			            table { width: 100%; border-collapse: collapse; border: 2px solid black; margin-top: 20px; }
			            th, td { padding: 10px; border: 1px solid black; text-align: center; }
			            th { background-color: #2786f1; color: white; }
			            .status-open { color: red; font-weight: bold; }
			            .status-in-progress { color: orange; font-weight: bold; }
			            .status-closed { color: green; font-weight: bold; }
			            </style>';
			$content .= '</head><body>';
			$content .= '<div class="container">';

			$content .= '<table>';
			$content .= '<tr><th colspan="8" style="font-size: 20px; padding: 15px;">ONGC Cambay Assets Case Details - ' . date('d-m-Y h:i A') . '</th></tr>';


		    $content .= '<tr><th colspan="8" style="height: 40px; background-color: white;"></th></tr>';

			$content .= '<tr>';

			$content .= '<th colspan=2>Total Case</th><th colspan=2>Open Case</th><th colspan=2>In Progress Case</th><th colspan=2>Closed Case</th>';
			$content .= '</tr>';
			$content .= '<tr>';
			$content .= '<td colspan=2>' . $total_cases . '</td>';
			$content .= '<td colspan=2>' . $total_open . '</td>';
			$content .= '<td colspan=2>' . $total_in_progress . '</td>';
			$content .= '<td colspan=2>' . $total_closed . '</td>';
			$content .= '</tr>';

			$content .= '<tr><th colspan="8" style="height: 40px; background-color: white;"></th></tr>';

			$content .= '<tr><th colspan="8">Issue Type</th></tr>';
			$content .= '<tr><th colspan=4>Issue</th><th colspan=4>Total Count</th></tr>';
			foreach ($issue_counts as $type => $count) {
			    $content .= '<tr>';
			    $content .= '<td colspan= 4>' . htmlspecialchars($type) . '</td>';
			    $content .= '<td colspan = 4>' . $count . '</td>';
			    $content .= '</tr>';
			}

			$content .= '<tr><th colspan="8" style="height: 40px; background-color: white;"></th></tr>';
			$content .= '<tr><th>Maintenance ID</th><th>Area</th><th>Well</th><th>Site</th><th>Issue</th><th>Pending</th><th>In Progress</th><th>Closed</th></tr>';
			foreach ($case_details as $case) {
			    $open = $in_progress = $closed = '-';
			    
			    if (!empty($case['case_status']['open'])) {
			        $open_case = $case['case_status']['open'][0];
			        $open = '<span class="status-open">' . date('d-m-Y h:i A', strtotime($open_case['open_time'])) . '<br>' . htmlspecialchars($open_case['user_data']).'</span>';
			    }
			    if (!empty($case['case_status']['in_progress'])) {
			        $in_progress_case = $case['case_status']['in_progress'][0];
			        $in_progress =  '<span class="status-in-progress">'.date('d-m-Y h:i A', strtotime($in_progress_case['in_progress_time'])) . '<br>' . htmlspecialchars($in_progress_case['user_data']).'</span>';
			    }
			    if (!empty($case['case_status']['closed'])) {
			        $closed_case = $case['case_status']['closed'][0];
			        $action = $closed_case['action_taken'] == 1 ? 'Repaired' : 'Replaced';
			        $closed = '<span class="status-closed">' . date('d-m-Y h:i:A', strtotime($closed_case['closed_time'])) . '<br>' . htmlspecialchars($closed_case['user_data']) . '<br>' . $action.'</span>';
			        if ($closed_case['action_taken'] == 2) {
			            $closed .= ' ( <strong>Quantity:</strong> ' . $closed_case['quantity'] . 
			                ' | <strong>Item Serial:</strong> ' . htmlspecialchars($closed_case['item_serial']) . ' )';
			        }
			    }
			    
			    $content .= '<tr>';
			    $content .= '<td>' . htmlspecialchars($case['maintance_id']) . '</td>';
			    $content .= '<td>' . htmlspecialchars($case['area_name']) . '</td>';
			    $content .= '<td>' . htmlspecialchars($case['well_name']) . '</td>';
			    $content .= '<td>' . htmlspecialchars($case['site_name']) . '</td>';
			    $content .= '<td>' . htmlspecialchars($case['issue_type']) . '</td>';
			    $content .= '<td>' . $open . '</td>';
			    $content .= '<td>' . $in_progress . '</td>';
			    $content .= '<td>' . $closed . '</td>';
			    $content .= '</tr>';
			}

			$content .= '</table>';
			$content .= '</div></body></html>';

				  
	        $mail = new PHPMailer();
	        $mail->IsSMTP();
	        $mail->Mailer = "smtp";
	        $mail->SMTPDebug = 0;
	        $mail->SMTPAuth = true;
	        $mail->SMTPSecure = "ssl";
	        $mail->Port = 465;
	        $mail->Host = "ssl://smtp.gmail.com";
	        $mail->Username = "nonreplyongc@gmail.com";
	        $mail->Password = "fdgxdljgmgcrjcaj";
	        $mail->IsHTML(true);
	        $mail->SetFrom("nonreplyongc@gmail.com",'ONGC');
	        $mail->AddAddress('iotassolutions@outlook.com');
	        $mail->AddAddress('iotasbhola@gmail.com');
			$mail->Subject = "Ongc Cambay case details.";
		    $mail->MsgHTML($content);
		    // print_r($content);die;
		    
		    if(!$mail->Send()) {
			   
			    $this->response(['status'=>false,'data'=>$mail->ErrorInfo,'msg'=>'Mail Not Send!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);

			} else {

			   $this->response(['status'=>true,'data'=>[],'msg'=>'successfully Send!!','response_code'=>REST_Controller::HTTP_OK]);
			}

		    }else{

		    	$this->response(['status'=>false,'data'=>[],'msg'=>'Mail Not Send!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);

		    }
	}


      // Case generate static  

	public function case_generate_system_post()
    {
	    try {
	       
	        $active_wells = $this->Maintance_well_details_model->get_active_wells();

	        if (!empty($active_wells)) {
	            foreach ($active_wells as $well) {
	                $well_id = $well['well_id'];
	                $is_online = $this->Maintance_well_details_model->is_well_online($well_id);

					if ($is_online) { 
					    $details = [];
					    
					    $details['issue_status'] = 3;
					    $details['d_date'] = date('Y-m-d H:i:s');
					    $details['d_by'] = 'system_generate';

					    $this->Maintance_well_details_model->UpdateMiantance($details,['maintance_id'=>$is_online['maintance_id']]);


					    $data = [];
					    $data = [
					        'site_id'       => $is_online['site_id'],
					        'area_id'       => $is_online['area_id'],
					        'well_id'       => $is_online['well_id'],
					        'issue_type_id' => 1,
					        'maintance_id'  => $is_online['maintance_id'],
					        'issue_status'  => 3,
					        'c_by'          => 'system_generate',
					        'c_date'        => date('Y-m-d H:i:s'),
					        'status'        => 1
					    ];
					    $this->Maintance_well_details_model->Save_Maintancelog($data);
					}
	            }
	        }
	        $offline_wells = $this->Maintance_well_details_model->get_offline_well_details();
	        
	        if (!empty($offline_wells)) {
	            foreach ($offline_wells as $well) {
	                $well_id = $well['well_id'];

	                $existing_case = $this->Maintance_well_details_model->get_existing_case($well_id);

	                if (!$existing_case) {
	                    $data = [
	                        'site_id'       => $well['site_id'],
	                        'area_id'       => $well['area_id'],
	                        'well_id'       => $well_id,
	                        'issue_type_id' => 1,
	                        'maintance_id'  => $this->Maintance_well_details_model->get_next_ref_no(),
	                        'issue_status'  => 1,
	                        'c_by'          => 'system_generate',
	                        'c_date'        => date('Y-m-d H:i:s'),
	                        'status'        => 1
	                    ];
	                    $this->Maintance_well_details_model->Save_Maintance($data);

	                    $Logdata = $data; 
	                    $this->Maintance_well_details_model->Save_Maintancelog($Logdata);
	                }
	            }
	        }

	        $this->response([
	            'status' => true,
	            'data' => [],
	            'msg' => 'Successfully Processed!',
	            'response_code' => REST_Controller::HTTP_OK
	        ]);

	    } catch (Exception $e) {
	        $this->response([
	            'status' => false,
	            'data' => [],
	            'msg' => 'Something went wrong!',
	            'response_code' => REST_Controller::HTTP_INTERNAL_SERVER_ERROR
	        ]);
	    }
	}
}
?>