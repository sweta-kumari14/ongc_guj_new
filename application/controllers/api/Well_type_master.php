<?php
require APPPATH.'libraries/REST_Controller.php';
class Well_type_master extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Well_type_model');
    }
    public function SaveWell_post()
    {
        try
        {
        
        $company_id=$this->input->post('company_id',true);
        $well_type_name=$this->input->post('well_type_name',true);
        $c_by=$this->post('c_by',true);
        $c_date=$this->post('c_date',true);
        $d_by=$this->post('d_by',true);
        $d_date=$this->post('d_date',true);

        if($this->input->post('company_id',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Company Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif($this->input->post('well_type_name',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'type required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif(!preg_match("/^[a-zA-Z-. ]*$/",$well_type_name))
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Area should be alphabet!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif($this->input->post('c_by',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'c kon required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }else
            {

                $verify = $this->Well_type_model->get_well_type($well_type_name,$company_id);
                 // print_r($verify);die;
                    if($verify == 0)
                    {
                        $data = [];
                        $data['company_id'] = $this->input->post('company_id',true);
                        $data['well_type_name'] = $this->input->post('well_type_name',true);
                        $data['c_by'] = $this->input->post('c_by',true);
                        $data['c_date'] = date('Y-m-d H:i:s');
                        $data['status'] = 1;
                        $this->Well_type_model->SaveWell($data);
                        $this->response(['status'=>true,'data'=>[],'msg'=>'Successfully Saved!!','response_code'=>REST_Controller::HTTP_OK]);
                    }else {
                         $this->response(['status'=>false,'data'=>[],'msg'=>'Well Type Alredy Exits!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);

                    }
                    
                    
                } 
            }
            
            catch (Exception $e){
                $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
                }


        }
    public function Updatewell_post()
    {
        try
        {
            $id=$this->input->post('id',true);
        $well_type_name = $this->input->post('well_type_name',true);

        if($this->input->post('id',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif($this->input->post('well_type_name',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'well_type_name required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif(!preg_match("/^[a-zA-Z-. ]*$/",$well_type_name))
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'well_type should be alphabet!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif($this->input->post('d_by',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'D kon required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }else
            {

                $verify = $this->Well_type_model->verifywellExist_OR_not($well_type_name,$id);
                 // print_r($verify);die;
                    if($verify == 0)
                    {
                        $data = [];
                        $data['id'] = $this->input->post('id',true);
                        $data['well_type_name'] = $this->input->post('well_type_name',true);
                        $data['d_by'] = $this->input->post('d_by',true);
                        $data['d_date'] = date('Y-m-d H:i:s');
                        $data['status'] = 1;
                        $where = ['id' => $id];
                        $this->Well_type_model->Updatewell($data,$where);
                        $this->response(['status'=>true,'data'=>[],'msg'=>'Successfully Saved!!','response_code'=>REST_Controller::HTTP_OK]);
                    }else {
                         $this->response(['status'=>false,'data'=>[],'msg'=>'Well Type Alredy Exits!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);

                    }
         
            }
        }
            catch (Exception $e){
                $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
                }
    }
    public function Deletewell_post()
    {       
        if($this->input->post('id',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'ID required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif($this->input->post('d_by',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'d_by required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }else{
            try 
            {   
                $data = [];
                $data['d_by'] = $this->input->post('d_by',true);
                $data['d_date'] = date('Y-m-d H:i:s');
                $data['status'] = 0;
                $this->Well_type_model->Deletewell($data,['id'=>$this->input->post('id',true)]);
                $this->response(['status'=>true,'data'=>[],'msg'=>'successfully delete!!','response_code'=>REST_Controller::HTTP_OK]);
                    
                
            }catch (Exception $e){
                $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
                }
        }
    }
     public function Welllist_post()
    {
        try {
            $id = $this->input->post('id',true)!=""?$this->input->post('id',true):"";
            $company_id = $this->input->post('company_id',true)!=""?$this->input->post('company_id',true):"";
            $result = $this->Well_type_model->Welllist($id,$company_id);
            $this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
        } catch (Exception $e) {
            $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        }
      
    
    }

}
?>