<?php
require APPPATH.'libraries/REST_Controller.php';
class Well_setup extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Well_setup_model');
    }

    public function Item_Allotment_to_well_type_post()
    {
        
        if($this->input->post('company_id',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'C Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif($this->input->post('well_type',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Well Type required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif($this->input->post('quantity_required',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'item required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif($this->input->post('c_by',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'c kon required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }else{
            try {
                    $quantity_required = json_decode($this->input->post('quantity_required',true),true);
                    // print_r($quantity_required);die;
                    foreach($quantity_required as $key=>$value)
                    {
                        $verifyitem = $this->Well_setup_model->getItemTypeExistOr_Not($value['component_id'],$this->input->post('well_type',true));

                        if($verifyitem == 0)
                        {
                            $id = $this->Well_setup_model->getItemAllId();
                            $dataArray = [];
                            $dataArray['id'] = $id[0]['UUID()'];
                            $dataArray['company_id'] = $this->input->post('company_id',true);
                            $dataArray['well_type'] = $this->input->post('well_type',true);
                            $dataArray['component_id'] = $value['component_id'];
                            $dataArray['quantity_required'] = $value['quantity_required'];
                            $dataArray['c_by'] = $this->input->post('c_by',true);
                            $dataArray['c_date'] = date('Y-m-d H:i:s');
                            $dataArray['status'] = 1;
                            $this->Well_setup_model->WellType_ItemAllotment($dataArray);

                        }else{

                            $this->response(['status'=>false,'data'=>[],'msg'=>'item Alerady Exists!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);

                        }
                    }
                $this->response(['status'=>true,'data'=>[],'msg'=>'Successfully Alloted!!','response_code'=>REST_Controller::HTTP_OK]);
            }catch (Exception $e) {
                $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong !!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
            }
        }
    }
    public function well_formula_list_post()
    {
        try {
            $id = $this->input->post('id',true)!=""?$this->input->post('id',true):"";
            $company_id = $this->input->post('company_id',true)!=""?$this->input->post('company_id',true):"";
            $component_id = $this->input->post('component_id',true)!=""?$this->input->post('component_id',true):"";
            $well_type = $this->input->post('well_type',true)!=""?$this->input->post('well_type',true):"";
            $result = $this->Well_setup_model->getwell_formula_list($id,$company_id,$component_id,$well_type);
            $this->response(['status'=>true,'data'=>$result,'msg'=>'successfully Fetched!!','response_code'=>REST_Controller::HTTP_OK]);
        } catch (Exception $e) {
            $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }
     public function Update_Well_formula_post()
    {
        
        $id = $this->input->post('id',true);

        if($this->input->post('id',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'Id required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }elseif($this->input->post('d_by',true) == '')
        {
            $this->response(['status'=>false,'data'=>[],'msg'=>'D kon required!!','response_code'=>REST_Controller::HTTP_BAD_REQUEST]);
        }else{
            try 
            {   
                $data = [];
                $data['quantity_required'] = $this->input->post('quantity_required',true);
                $data['d_by'] = $this->input->post('d_by',true);
                $data['d_date'] = date('Y-m-d H:i:s');
                $this->Well_setup_model->update_well_formula($data,['id'=>$this->input->post('id',true)]);
                $this->response(['status'=>true,'data'=>[],'msg'=>'Successfully Updated!!','response_code'=>REST_Controller::HTTP_OK]);
                      
            }catch (Exception $e){
                $this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
                }
        }
    }
}
?>