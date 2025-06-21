<?php
require APPPATH.'libraries/REST_Controller.php';
require APPPATH . 'controllers/api/Base64fileUploads.php';
class Company_master extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Company_model');
	}

	public function Add_CompanyData_post()
	{
        $company_name = $this->input->post('company_name',true);
        $email_id = $this->input->post('email_id',true);
        $contact_no = $this->input->post('contact_no',true);
        $comp_userId = $this->input->post('comp_userId',true);
        $city = $this->input->post('city',true);
        $address = $this->input->post('address',true);

        if($this->input->post('company_name',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Copm Name required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[a-zA-Z-,. ]*$/",$company_name))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Comp Name should be alphabet!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('email_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'E Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email_id))
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Invalid Email Id required !','response_code' => REST_Controller::HTTP_BAD_REQUEST]);
        }elseif($this->input->post('contact_no',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Mob required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[0-9]{10}$/",$contact_no))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Mob should be ten digit !!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('comp_userId',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'User Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[A-Za-z]+-[0-9]+$/", $comp_userId))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'User Id alphabet and integer allowed like [COMP-1]!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('country_code',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'C code required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('state_code',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'S Code required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('city',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'City required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[a-zA-Z-. ]*$/",$city))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'City not valid!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('address',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Adrs required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[a-zA-Z0-9-.,\/ ]*$/",$address))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Address not valid !!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('logo',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Company Logo required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('c_by',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'c kon required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}else{
			try 
			{	
				$verify_name = $this->Company_model->verify_CompanyExist($this->input->post('company_name',true));
				if($verify_name == 0)
				{
					$verify_email = $this->Company_model->verify_CompEmailExist($this->input->post('email_id',true));
					if($verify_email == 0)
					{
						$verify_contact = $this->Company_model->verifyContactExist($this->input->post('contact_no',true));
						if($verify_contact == 0)
						{
							$verify_UserId = $this->Company_model->verifyExist_UserId($this->input->post('comp_userId',true));

							if($verify_UserId == 0)
							{
								$image ='';
	                            if($this->input->post('logo',true)!='')
	                            {

		                            $image = str_replace(' ', '+', $this->input->post('logo',true));
					                $base64file   = new Base64fileUploads();
					                $image = $base64file->du_uploads('album/',$image);
	                            }
								$id = $this->Company_model->getCompID();
									// print_r($id);die;
								$data = [];
								$data['id'] = $id[0]['UUID()'];
								$data['super_admin_id'] = $this->input->post('super_admin_id',true);
								$data['company_name'] = $this->input->post('company_name',true);
								$data['comp_userId'] = $this->input->post('comp_userId',true);
								$data['email_id'] = $this->input->post('email_id',true);
								$data['contact_no'] = $this->input->post('contact_no',true);
								$data['logo'] = $image;
								$data['country_code'] = $this->input->post('country_code',true);
								$data['state_code'] = $this->input->post('state_code',true);
								$data['city'] = $this->input->post('city',true);
								$data['address'] = $this->input->post('address',true);
								$data['c_by'] = $this->input->post('c_by',true);
								$data['c_date'] = date('Y-m-d H:i:s');
								$data['status'] = 1;
								$this->Company_model->AddCompanyData($data);

								$chars = "0123456789bcdfghjkmnpqrstvwxyzBCDFGHJKLMNPQRSTVWXYZ";
	    						$pass = substr(str_shuffle($chars),0,8);

								$A_Id = $this->Company_model->getAuth_Id();
								$auth = [];
								$auth['id'] = $A_Id[0]['UUID()'];
								$auth['company_id'] = $data['id'];
								$auth['email_id'] = $data['email_id'];
								$auth['unique_userId'] = $data['comp_userId'];
								$auth['mobile_no'] = $data['contact_no'];
								$auth['password'] = $pass;
								$auth['user_type'] = 2;
								$auth['c_by'] = $this->input->post('c_by',true);
								$auth['c_date'] = date('Y-m-d H:i:s');
								$auth['status'] = 1;
								$this->Company_model->SaveAuth_Data($auth);

								$this->response(['status'=>true,'data'=>[],'msg'=>'successfully saved!!','response_code'=>REST_Controller::HTTP_OK]);
							}else{
								$this->response(['status'=>false,'data'=>[],'msg'=>'User Id Already Exist!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
							}
						}else{
							$this->response(['status'=>false,'data'=>[],'msg'=>'Contact Already Exist!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
						}
					}else{
						$this->response(['status'=>false,'data'=>[],'msg'=>'C Email Already Exist!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}
							
				}else{
					$this->response(['status'=>false,'data'=>[],'msg'=>'Company Already Exist!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);	
				}	
        	
			}catch (Exception $e){
				$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
				}
		}
    }

   public function UpdateCompanyData_post()
	{
        $company_name = $this->input->post('company_name',true);
        $email_id = $this->input->post('email_id',true);
        $contact_no = $this->input->post('contact_no',true);
        $city = $this->input->post('city',true);
        $address = $this->input->post('address',true);

        if($this->input->post('id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'ID required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('company_name',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Copm Name required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[a-zA-Z-,. ]*$/",$company_name))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Comp Name should be alphabet!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('email_id',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'E Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email_id))
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Invalid Email Id required !','response_code' => REST_Controller::HTTP_BAD_REQUEST]);
        }elseif($this->input->post('contact_no',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Mob required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[0-9]{10}$/",$contact_no))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Mob should be ten digit !!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('country_code',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'C code required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('state_code',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'S Code required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('city',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'City required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[a-zA-Z-. ]*$/",$city))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'City not valid!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('address',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Adrs required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif(!preg_match("/^[a-zA-Z0-9-.,\/ ]*$/",$address))
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'Address not valid !!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}elseif($this->input->post('d_by',true) == '')
		{
			$this->response(['status'=>false,'data'=>[],'msg'=>'D kon required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
		}else{
			try 
			{	
				$verify_name = $this->Company_model->verify_CompanyExist_OrNot($this->input->post('company_name',true),$this->input->post('id',true));
				if($verify_name == 0)
				{
					$verify_email = $this->Company_model->verifyCompEmailExist_OrNot($this->input->post('email_id',true),$this->input->post('id',true));
					if($verify_email == 0)
					{
						$verify_contact = $this->Company_model->verifyCompContExist_OrNot($this->input->post('contact_no',true),$this->input->post('id',true));
						if($verify_contact == 0)
						{
							$data = [];
							if($this->input->post('logo',true)!='')
                            {
                            	$image = str_replace(' ', '+', $this->input->post('logo',true));
				                $base64file   = new Base64fileUploads();
				                $image = $base64file->du_uploads('album/',$image);
                            	$data['logo'] = $image;
                            }
							$data['company_name'] = $this->input->post('company_name',true);
							$data['email_id'] = $this->input->post('email_id',true);
							$data['contact_no'] = $this->input->post('contact_no',true);
							$data['country_code'] = $this->input->post('country_code',true);
							$data['state_code'] = $this->input->post('state_code',true);
							$data['city'] = $this->input->post('city',true);
							$data['address'] = $this->input->post('address',true);
							$data['d_by'] = $this->input->post('d_by',true);
							$data['d_date'] = date('Y-m-d H:i:s');
							$data['status'] = 1;
							$this->Company_model->UpdateCompanyData($data,['id'=>$this->input->post('id',true)]);

							$this->Company_model->EditOnboardindcompany(['email_id'=>$this->input->post('email_id',true),'mobile_no'=>$this->input->post('contact_no',true),'d_by'=>$this->input->post('id',true),'d_date'=>date('Y-m-d H:i:s')],['company_id'=>$this->input->post('id',true),'user_type'=>2]);

							$this->response(['status'=>true,'data'=>[],'msg'=>'successfully updated!!','response_code'=>REST_Controller::HTTP_OK]);
						}else{
							$this->response(['status'=>false,'data'=>[],'msg'=>'Contact Already Exist!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
						}
					}else{
						$this->response(['status'=>false,'data'=>[],'msg'=>'C Email Already Exist!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
					}
							
				}else{
					$this->response(['status'=>false,'data'=>[],'msg'=>'Company Already Exist!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);	
				}	
        	
			}catch (Exception $e){
				$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
				}
		}
    }

	public function CompanyDataList_post()
	{
		try {
			$id = $this->input->post('id',true)!=""?$this->input->post('id',true):"";
			$result = $this->Company_model->CompanyDataList($id);
			$this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	  
	}

	public function deleteCompany_post()
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
				$this->Company_model->DeleteCompany($data,['id'=>$this->input->post('id',true)]);
				$this->Company_model->EditOnboardindcompany($data,['company_id'=>$this->input->post('id',true)]);
				$this->response(['status'=>true,'data'=>[],'msg'=>'successfully delete!!','response_code'=>REST_Controller::HTTP_OK]);
					
				
			}catch (Exception $e){
				$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
				}
		}
    }

}
?>