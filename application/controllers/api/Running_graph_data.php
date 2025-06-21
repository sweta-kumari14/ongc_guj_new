<?php
require APPPATH.'libraries/REST_Controller.php';
class Running_graph_data extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Running_graph_data_model');
	}
	public function comparison_graph_month_wise_running_post()
	{
		try {
			$site_id = $this->input->post('site_id',true)!=''?$this->input->post('site_id',true):'';
			$well_id = $this->input->post('well_id',true)!=''?$this->input->post('well_id',true):'';
			$month = $this->input->post('month',true)!=''?$this->input->post('month',true):'';
			$year = $this->input->post('year',true)!=''?$this->input->post('year',true):'';
            $graph_type = $this->input->post('graph_type',true);	

            $result = [];
	        if($this->input->post('graph_type',true)!='')
	        {

	        	if($graph_type == 1)
	        	{
			        $result = $this->Running_graph_data_model->well_running_graph_comparison($site_id,$well_id,$month,$year);
			    }else if($graph_type == 2){

                    $result = $this->Running_graph_data_model->well_energy_graph_comparison($site_id,$well_id,$month,$year);

			    }else if($graph_type == 3){

                    $result = $this->Running_graph_data_model->well_running_schdule_graph_comparison($site_id,$well_id,$month,$year);
			    }else if($graph_type == 4)
	        	{
			        $result = $this->Running_graph_data_model->well_running_Area_wise_comparison($site_id,$month,$year);
			    }else if($graph_type == 5)
	        	{
			        $result = $this->Running_graph_data_model->well_energy_Area_wise_comparison($site_id,$month,$year);
			    }else if($graph_type == 6)
	        	{
			        $result = $this->Running_graph_data_model->well_Area_running_schdule_graph_comparison($site_id,$month,$year);
			    }else if($graph_type == 7)
	        	{
			
			        $result = $this->Running_graph_data_model->well_running_Assets_wise_comparison($site_id,$month,$year);
			    }else if($graph_type == 8)
	        	{
			
			        $result = $this->Running_graph_data_model->well_energy_consumption_Assets_wise_comparison($site_id,$month,$year);
			    }else if($graph_type == 9)
	        	{
			
			        $result = $this->Running_graph_data_model->well_running_schduling_Assets_wise_comparison($site_id,$month,$year);
			    }
 
 
		    }
		
           $this->response(['status'=>true,'data'=>$result,'msg'=>'Successfully fetched!!','response_code'=>REST_Controller::HTTP_OK]);
		} catch (Exception $e) {
			$this->response(['status'=>false,'data'=>[],'msg'=>'something went wrong!!','response_code'=>REST_Controller::HTTP_INTERNAL_SERVER_ERROR]);
		}
	}
}
?>