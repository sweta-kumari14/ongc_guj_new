<?php
class Well_Reinstall_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

    public function AddWellData($data)
    {
    	return $this->db->insert('tbl_well_reinstall_details_monthly',$data);
    }

}
?>