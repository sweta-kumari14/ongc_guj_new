<?php 
	$this->load->view("inc/topHeader.php");
	$this->load->view("inc/header.php");
	$this->load->view("inc/sidebar.php");
	$this->load->view($v);
	$this->load->view("inc/footer.php");
	$this->load->view("inc/footerEnd.php");
?>