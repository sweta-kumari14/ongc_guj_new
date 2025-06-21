<?php
require APPPATH.'libraries/REST_Controller.php';
class Well_wiseDeviceShifting extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Well_WiseDeviceshifting_model');
	}

	public function SaveShifted_Device_post()
	{
		$shifting_status = $this->input->post('shifting_status',true);

		if($this->input->post('company_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Company Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('shifted_by',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Shifted By required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('shifted_well_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Shifted Well Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('shifted_imei_no',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Shifted IMEI required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('shifted_device_name',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Shifted Device Name required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('allot_well_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Allot Well Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('date_of_shifted',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Date of Shifting required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('shifting_status',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Shifting status required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}else{
			try{

				if($shifting_status == 1)
				{

					if($this->input->post('allot_prv_device_name',true) =='')
					{
						$this->response(['status'=>false,'data'=>[],'msg'=>'Previous Device required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}elseif($this->input->post('allot_prv_imei_no',true) =='')
					{
						$this->response(['status'=>false,'data'=>[],'msg'=>'Previous Imei required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}
					$SId1 = $this->Well_WiseDeviceshifting_model->get_wellShiftedId();
					$SId2 = $this->Well_WiseDeviceshifting_model->get_wellInterchangeId();
					$sh1Log = [];
					$sh1Log['id'] = $SId1[0]['UUID()'];
					$sh1Log['company_id'] = $this->input->post('company_id',true);
					$sh1Log['shifted_by'] = $this->input->post('shifted_by',true);
					$sh1Log['shifted_well_id'] = $this->input->post('shifted_well_id',true);
					$sh1Log['shifted_device_name'] = $this->input->post('shifted_device_name',true);
					$sh1Log['shifted_well_installation_date'] = $this->input->post('shifted_well_installation_date',true);
					$sh1Log['shifted_imei_no'] = $this->input->post('shifted_imei_no',true);
					$sh1Log['allot_well_id'] = $this->input->post('allot_well_id',true);
					$sh1Log['allot_prv_device_name'] = $this->input->post('allot_prv_device_name',true);
					$sh1Log['allot_prv_imei_no'] = $this->input->post('allot_prv_imei_no',true);
					$sh1Log['allot_prv_installation_date'] = $this->input->post('allot_prv_installation_date',true);
					$sh1Log['allot_current_device_name'] = $this->input->post('shifted_device_name',true);
					$sh1Log['allot_current_imei_no'] = $this->input->post('shifted_imei_no',true);
					$sh1Log['shifted_datetime'] = date('Y-m-d H:i:s',strtotime($this->input->post('date_of_shifted',true)));

					$sh2Log = [];
					$sh2Log['id'] = $SId2[0]['UUID()'];
					$sh2Log['company_id'] = $this->input->post('company_id',true);
					$sh2Log['shifted_by'] = $this->input->post('shifted_by',true);
					$sh2Log['shifted_well_id'] = $this->input->post('allot_well_id',true);
					$sh2Log['shifted_device_name'] = $this->input->post('allot_prv_device_name',true);
					$sh2Log['shifted_well_installation_date'] = $this->input->post('allot_prv_installation_date',true);
					$sh2Log['shifted_imei_no'] =  $this->input->post('allot_prv_imei_no',true);
					$sh2Log['allot_well_id'] = $this->input->post('shifted_well_id',true);
					$sh2Log['allot_prv_device_name'] = $this->input->post('shifted_device_name',true);
					$sh2Log['allot_prv_imei_no'] = $this->input->post('shifted_imei_no',true);
					$sh2Log['allot_prv_installation_date'] = $this->input->post('shifted_well_installation_date',true);
					$sh2Log['allot_current_device_name'] = $this->input->post('allot_prv_device_name',true);
					$sh2Log['allot_current_imei_no'] = $this->input->post('allot_prv_imei_no',true);
					$sh2Log['shifted_datetime'] = date('Y-m-d H:i:s',strtotime($this->input->post('date_of_shifted',true)));

                    $this->Well_WiseDeviceshifting_model->WellShifted_Device_Save($sh1Log);
                    $this->Well_WiseDeviceshifting_model->WellShifted_Device_Save($sh2Log);

                    $UpD1 = [];
					$UpD1['device_name'] = $sh1Log['allot_prv_device_name'];
					$UpD1['imei_no'] = $sh1Log['allot_prv_imei_no'];
					$UpD1['device_shifted'] = 0;
					$UpD1['date_of_installation'] = date('Y-m-d H:i:s',strtotime($this->input->post('date_of_shifted',true)));

					$this->Well_WiseDeviceshifting_model->Update_Devicestatus($UpD1,['well_id'=>$this->input->post('shifted_well_id')]);

					$UpD2 = [];
					$UpD2['device_name'] = $sh1Log['shifted_device_name'];
					$UpD2['imei_no'] = $sh1Log['shifted_imei_no'];
					$UpD2['device_shifted'] = 0;
					$UpD2['date_of_installation'] = date('Y-m-d H:i:s',strtotime($this->input->post('date_of_shifted',true)));

					$this->Well_WiseDeviceshifting_model->Update_Devicestatus($UpD2,['well_id'=>$this->input->post('allot_well_id')]);

					$this->response(['status'=>true,'data'=>[],'msg'=>'Successfully device interchange!!','response_code'=>REST_Controller::HTTP_OK]);


				}else{

				$verifyShiftedWell = $this->Well_WiseDeviceshifting_model->Check_Well_Exist_orNOt($this->input->post('shifted_well_id',true));

				// print_r($verifyShiftedWell);die;
				$SId = $this->Well_WiseDeviceshifting_model->get_wellShiftedId();

				if($verifyShiftedWell[0]['total'] == 1)
				{	
					$checkPrvWell = $this->Well_WiseDeviceshifting_model->CheckCurrentWellExist($this->input->post('allot_well_id',true));
					// print_r($checkPrvWell);die;
					if($checkPrvWell[0]['total'] == 1)
					{

						$shLog = [];
						$shLog['id'] = $SId[0]['UUID()'];
						$shLog['company_id'] = $this->input->post('company_id',true);
						$shLog['shifted_by'] = $this->input->post('shifted_by',true);
						$shLog['shifted_well_id'] = $this->input->post('shifted_well_id',true);
						$shLog['shifted_device_name'] = $this->input->post('shifted_device_name',true);
						$shLog['shifted_well_installation_date'] = $this->input->post('shifted_well_installation_date',true);
						$shLog['shifted_imei_no'] = $this->input->post('shifted_imei_no',true);
						$shLog['allot_well_id'] = $this->input->post('allot_well_id',true);
						if($checkPrvWell[0]['device_shifted'] == 1)
						{
							$shLog['allot_prv_device_name'] = null;
							$shLog['allot_prv_imei_no'] = null;
							$shLog['allot_prv_installation_date'] = null;
						}else{
							if($this->input->post('allot_prv_device_name',true) =='')
							{
								$this->response(['status'=>false,'data'=>[],'msg'=>'Previous Device required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
							}elseif($this->input->post('allot_prv_imei_no',true) =='')
							{
								$this->response(['status'=>false,'data'=>[],'msg'=>'Previous Imei required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
							}
							$shLog['allot_prv_device_name'] = $this->input->post('allot_prv_device_name',true);
							$shLog['allot_prv_imei_no'] = $this->input->post('allot_prv_imei_no',true);
							$shLog['allot_prv_installation_date'] = $this->input->post('allot_prv_installation_date',true);

							$this->Well_WiseDeviceshifting_model->Update_Previous_Installed_Devicestatus(['device_setup_status'=>1,'d_by'=>$shLog['shifted_by'],'d_date'=>date('Y-m-d H:i:s')],['imei_no'=>$this->input->post('allot_prv_imei_no')]);
						}

						$shLog['allot_current_device_name'] = $this->input->post('shifted_device_name',true);
						$shLog['allot_current_imei_no'] = $this->input->post('shifted_imei_no',true);
						$shLog['shifted_datetime'] = date('Y-m-d H:i:s',strtotime($this->input->post('date_of_shifted',true)));

						$this->Well_WiseDeviceshifting_model->WellShifted_Device_Save($shLog);

						$UpD1 = [];
						$UpD1['device_name'] = null;
						$UpD1['imei_no'] = null;
						$UpD1['device_shifted'] = 1;
						$UpD1['date_of_shifted'] = date('Y-m-d H:i:s',strtotime($this->input->post('date_of_shifted',true)));

						$this->Well_WiseDeviceshifting_model->Update_Devicestatus($UpD1,['well_id'=>$this->input->post('shifted_well_id')]);

						$UpD2 = [];
						$UpD2['device_name'] = $shLog['shifted_device_name'];
						$UpD2['imei_no'] = $shLog['shifted_imei_no'];
						$UpD2['device_shifted'] = 0;
						$UpD2['date_of_installation'] = date('Y-m-d H:i:s',strtotime($this->input->post('date_of_shifted',true)));

						$this->Well_WiseDeviceshifting_model->Update_Devicestatus($UpD2,['well_id'=>$this->input->post('allot_well_id')]);
						$AddData = [];
						$AddData['well_id'] = $this->input->post('shifted_well_id',true);
						$AddData['c_by'] = $this->input->post('shifted_by',true);
						$AddData['shifted_date_time'] = date('Y-m-d H:i:s',strtotime($this->input->post('date_of_shifted',true)));
						$AddData['c_date'] = date('Y-m-d H:i:s');
						$AddData['status'] = 1;

						$this->Well_WiseDeviceshifting_model->SaveDevice_data($AddData);

						$checkAllotWell = $this->Well_WiseDeviceshifting_model->CheckAllotWellExist($this->input->post('allot_well_id',true));
						if($checkAllotWell[0]['total'] == 1)
					    {
					    	$UpD = [];
					    	$UpD['d_by'] = $this->input->post('shifted_by',true);
						    $UpD['re_installation_date_time'] = date('Y-m-d H:i:s',strtotime($this->input->post('date_of_shifted',true)));
						    $UpD['d_date'] = date('Y-m-d H:i:s');
						    $UpD['re_install_status'] = 1;
					    	

					    	$this->Well_WiseDeviceshifting_model->Update_ReinstallDevicestatus($UpD,['well_id'=>$this->input->post('allot_well_id')]);
					    }



						$this->response(['status'=>true,'data'=>[],'msg'=>'Successfully device shifted!!','response_code'=>REST_Controller::HTTP_OK]);
					}else{

					

							$WellData = $this->Well_WiseDeviceshifting_model->getInstalledwell_data($this->input->post('allot_well_id'));
							// print_r($WellData);die;

							$IID = $this->Well_WiseDeviceshifting_model->getInstallId();
							$InsData = [];
							$InsData['id'] = $IID[0]['UUID()'];
							$InsData['company_id'] = $this->input->post('company_id',true);
							$InsData['installed_by'] = $this->input->post('shifted_by',true);
							$InsData['assets_id'] = $WellData[0]['assets_id'];
							$InsData['area_id'] = $WellData[0]['area_id'];
							$InsData['site_id'] = $WellData[0]['site_id'];
							$InsData['well_id'] = $this->input->post('allot_well_id',true);
							$InsData['device_name'] = $this->input->post('shifted_device_name',true);;
							$InsData['imei_no'] = $this->input->post('shifted_imei_no',true);;
							$InsData['lat'] = $WellData[0]['lat'];
							$InsData['long'] = $WellData[0]['long'];
							$InsData['sim_no'] = $verifyShiftedWell[0]['sim_no'];
							$InsData['sim_provider'] = $verifyShiftedWell[0]['sim_provider'];
							$InsData['network_type'] = $verifyShiftedWell[0]['network_type'];
							$InsData['device_shifted'] = 0;
							$InsData['date_of_installation'] = date('Y-m-d H:i:s',strtotime($this->input->post('date_of_shifted',true)));
							$InsData['cby'] = $this->input->post('shifted_by',true);
					        $InsData['cdate'] = date('Y-m-d H:i:s');
					        $InsData['status'] = 1;
							$this->Well_WiseDeviceshifting_model->Well_shifted_Device_Save($InsData);

							$this->Well_WiseDeviceshifting_model->WellWiseDevice_installationStatus(['device_setup_status'=>1,'device_setup_datetime'=>$InsData['date_of_installation']],['id'=>$this->input->post('allot_well_id')]);

							$shLog = [];
							$shLog['id'] = $SId[0]['UUID()'];
							$shLog['company_id'] = $this->input->post('company_id',true);
							$shLog['shifted_by'] = $this->input->post('shifted_by',true);
							$shLog['shifted_well_id'] = $this->input->post('shifted_well_id',true);
							$shLog['shifted_device_name'] = $this->input->post('shifted_device_name',true);
							$shLog['shifted_imei_no'] = $this->input->post('shifted_imei_no',true);
							$shLog['shifted_well_installation_date'] = $this->input->post('shifted_well_installation_date',true);
							$shLog['allot_well_id'] = $this->input->post('allot_well_id',true);
							$shLog['allot_prv_device_name'] = null;
							$shLog['allot_prv_imei_no'] = null;
							$shLog['allot_prv_installation_date'] = null;
							$shLog['allot_current_device_name'] = $this->input->post('shifted_device_name',true);
							$shLog['allot_current_imei_no'] = $this->input->post('shifted_imei_no',true);
							$shLog['shifted_datetime'] = date('Y-m-d H:i:s',strtotime($this->input->post('date_of_shifted',true)));

							$this->Well_WiseDeviceshifting_model->WellShifted_Device_Save($shLog);

							$UpD1 = [];
							$UpD1['device_name'] = null;
							$UpD1['imei_no'] = null;
							$UpD1['device_shifted'] = 1;
							$UpD1['date_of_shifted'] = date('Y-m-d H:i:s',strtotime($this->input->post('date_of_shifted',true)));
							$AddData = [];
							$AddData['well_id'] = $this->input->post('shifted_well_id',true);
							$AddData['c_by'] = $this->input->post('shifted_by',true);
							$AddData['shifted_date_time'] = date('Y-m-d H:i:s',strtotime($this->input->post('date_of_shifted',true)));
							$AddData['c_date'] = date('Y-m-d H:i:s');
							$AddData['status'] = 1;

							$this->Well_WiseDeviceshifting_model->SaveDevice_data($AddData);
							$this->Well_WiseDeviceshifting_model->Update_Devicestatus($UpD1,['well_id'=>$this->input->post('shifted_well_id')]);
							$checkAllotWell = $this->Well_WiseDeviceshifting_model->CheckAllotWellExist($this->input->post('allot_well_id',true));
							if($checkAllotWell[0]['total'] == 1)
						    {
						    	$UpD = [];
						    	$UpD['d_by'] = $this->input->post('shifted_by',true);
							    $UpD['re_installation_date_time'] = date('Y-m-d H:i:s',strtotime($this->input->post('date_of_shifted',true)));
							    $UpD['d_date'] = date('Y-m-d H:i:s');
							    $UpD['re_install_status'] = 1;
						    	

						    	$this->Well_WiseDeviceshifting_model->Update_ReinstallDevicestatus($UpD,['well_id'=>$this->input->post('allot_well_id')]);
						    }

							$this->response(['status'=>true,'data'=>[],'msg'=>'Successfully device shifted!!','response_code'=>REST_Controller::HTTP_OK]);
							
					}
					
				}else{
					$this->response(['status'=>false,'data'=>[],'msg'=>'From Well Already Shifted!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
				}

			}

			}catch (Exception $e)
			{
				$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
			}
		}

		
    }

    public function Well_to_Well_Shifting_Report_post()
    {
    	try {
			$company_id = $this->input->post('company_id',true)!=''?$this->input->post('company_id',true):'';
			$user_id = $this->input->post('user_id',true)!=''?$this->input->post('user_id',true):'';
			$well_id = $this->input->post('well_id',true)!=''?$this->input->post('well_id',true):'';
			$from_date = $this->input->post('from_date',true)!=''?$this->input->post('from_date',true):'';
			$to_date = $this->input->post('to_date',true)!=''?$this->input->post('to_date',true):'';
			$result = $this->Well_WiseDeviceshifting_model->getreportwell_replacement_device_log($company_id,$user_id,$well_id,$from_date,$to_date);

			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
    }

    public function Well_shifting_details_post()
    {
    try{

    	$imei_no = $this->input->post('imei_no',true);

    	$result = $this->Well_WiseDeviceshifting_model->get_well_shifting_log($imei_no);

			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		}catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}


	  public function well_shifting_details_through_well_id_post()
	  {

	  	try{

             $well_id = $this->input->post('well_id',true);
	         $result = $this->Well_WiseDeviceshifting_model->get_well_wise_shifting_log($well_id);

			$this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		}catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	  }

}
?>
