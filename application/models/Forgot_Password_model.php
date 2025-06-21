<?php 
class Forgot_Password_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}


	public function getOtpAttempts($email_id)
	{
	    $this->db->select('COUNT(id) as attempts');
	    $this->db->from('tbl_forgot_password_log');
	    $this->db->where('email_id', $email_id);
	    $this->db->where('TIMESTAMPDIFF(MINUTE, c_date, NOW()) <= 30');
	    $this->db->where('status', 1);

	    $result = $this->db->get()->row_array();

	    return $result['attempts'];
	}

	public function getPassID()
	{
		return $this->db->select("UUID()")->get()->result_array();
	}

	public function checkEmail_valid($email_id)
	{
		$this->db->where('email_id',$email_id);
		return $this->db->select("count(id) as total,user_type,company_id,user_member_id")->from('tbl_authentication_master')->where(['status'=>1])->get()->result_array();
	
	}

	public function saveOtp($data)
	{
		return $this->db->insert('tbl_forgot_password_log',$data);
	}

	public function getOtp($email_id)
	{
		$this->db->where('email_id',$email_id);
		
		$this->db->where('TIMESTAMPDIFF(MINUTE, c_date, now())<=3');
		return $this->db->select('otp,user_type,user_id')->from('tbl_forgot_password_log')->where(['status'=>1])->get()->result_array();
	}

	public function ResetPassword($data,$where)
	{
		return $this->db->update('tbl_authentication_master',$data,$where);
	}

	public function UpdateForgot_Status($data,$where)
	{
		return $this->db->update('tbl_forgot_password_log',$data,$where);
	}


	public function get_otp_verify_wrong_attepmt($email_id)
    {
        $this->db->select('COUNT(email_id) as total');
        $this->db->from('tbl_wrong_otp_attempt');
        $this->db->where('email_id', $email_id);
        $this->db->where('TIMESTAMPDIFF(MINUTE, c_date, NOW()) <= 30');
        $this->db->where('status', 1);

        $result = $this->db->get()->row_array();
        return $result['total'];

       
    }

    public function getWOId()
    {
    	return $this->db->select("UUID()")->get()->result_array();
    }

    public function SaveWrong_OtpData($wrongAttempt)
    {
    	return $this->db->insert('tbl_wrong_otp_attempt',$wrongAttempt);
    }


	
}
?>	