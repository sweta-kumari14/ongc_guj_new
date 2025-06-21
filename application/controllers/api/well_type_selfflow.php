<?php
require APPPATH.'libraries/REST_Controller.php';
class Well_type_changes extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Well_type_changes_model');
    }

    
}
?>