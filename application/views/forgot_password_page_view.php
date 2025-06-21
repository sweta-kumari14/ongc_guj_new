<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">
    
<!-- Mirrored from smarthr.dreamstechnologies.com/html/template/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 18 Dec 2023 08:33:03 GMT -->
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <title>Change Password :: ONGC </title>
		
		<!-- Favicon -->
          <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>assets/img/logo_square.png"/>
		
		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">

		<!-- Fontawesome CSS -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/fontawesome/css/fontawesome.min.css">
    	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/fontawesome/css/all.min.css">

		<!-- Lineawesome CSS -->
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/line-awesome.min.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/material.css">
			
		<!-- Lineawesome CSS -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/line-awesome.min.css">
		
		<!-- Main CSS -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">
          <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
       

    </head>
    <body class="account-page">
      <style type="text/css">
    .colored-hr {
               border-top: 2px solid blue; 
               background-image: linear-gradient(to right, #b3e0ff, #66a3ff); 
             }

  </style>
	
		<!-- Main Wrapper -->
        <div class="main-wrapper">
			<div class="account-content">
				
				<div class="container">
				
					<!-- Account Logo -->
				
					<!-- /Account Logo -->
					
					<div class="account-box">
						<div class="account-wrapper">
							 <h2 class=" text-center mt-4" style="color:blue;"><b>Oil and Natural Gas Corporation Cambay Asset</b></h2>

                <div class="account-logo">
             <img src="<?php echo base_url() ?>assets/img/logo.png" width="70" style="border-radius: 50%; height:50">
          </div>
							<h3 class="account-title">Change Password</h3>
							
							 <hr class="colored-hr">
							        <form role="form" class="custom-validation" method="POST" action="<?php echo base_url('Authentication/change_password_through_otp'); ?>">
								<div class="input-block mb-4">
									<label class="col-form-label">Please Check Your email for OTP</label>
                                    <input type="hidden" name="email_id" id="email_id" value="<?php echo $email; ?>" readonly>
            
								</div>

								<div class="col-md-12 mt-3">
                    <div style="color:red;" class="text-center" id="countdown"></div>
                </div>

               <div class="col-md-12 mt-3" id="resend_field" style="display: none;">
              <h5>Did Not Received OTP <button type="button" onclick="resend_otp();" class="btn btn-md btn-primary">Resend OTP</button></h5>
            </div>

            <div class="col-md-12 mt-3" id="spinner" style="display: none;text-align: center;">
              <div class="spinner-border text-dark" role="status">
                <span class="sr-only">Please Wait.</span>
              </div>
            </div>

            <div class="col-md-12 mt-3">
              <h5><b>Enter OTP <span style="color:red">*</span></b></h5>
              <input type="number" name="otp" id="otp" maxlength="6" minlength="6" class="form-control" required>
            </div>

           
              
            
            <div class="col-md-12 mt-3">
                <h5><b>CAPTCHA <span style="color:red">*</span></b></h5>
               <canvas class="bg-light rounded px-2" id="canvas_captcha" width="150" height="50"></canvas>
                <button class="fa fa-refresh mt-2" type="button" onclick="refreshCaptcha();" style="color: blue;"></button>
                <input type="hidden" class="form-control" id="hdn_captcha" name="hdn_captcha" readonly>
               
            </div>
            <div class="col-md-12 mt-3">
                 <h5><b>Renter Captcha <span style="color:red">*</span></b></h5>
                 <input type="text" name="recaptcha" id="recaptcha" class="form-control" required onblur="validateData();">
            </div>

            <div class="col-md-12 mt-3">
              <button class="btn btn-sm btn-primary" id="verified_otp_btn" type="button" disabled style="display:none;">Verified</button>
            </div>
            <div class="col-md-12 mt-3">
             <button class="btn btn-sm btn-primary" id="verify_otp_btn" type="button" onclick="verify_otp();" style="display:none;">Verify OTP</button>
            </div>

            <div class="col-md-12 mt-3" style="display:none;" id="password_field">
              <h5><b>Enter Password <span style="color:red">*</span></b></h5>
              <input type="password" name="password" id="password"  class="form-control" required>
            </div>

           <div class="input-block mb-4" style="display:none;" id="confirm_password_field">
              <h5><b>Confirm Password <span style="color:red">*</span></b></h5>
              <input type="password" name="confirm_password" id="confirm_password"  class="form-control" required>
            </div>
								
								<div class="input-block mt-4 text-center" style="display:none;" id="password_save">
									<button class="btn btn-primary account-btn" type="submit">Save</button>
								</div>
								
							</form>
							<!-- /Account Form -->
							
						</div>
					</div>
				</div>
			</div>
        </div>
		<!-- /Main Wrapper -->
		
		<!-- jQuery -->
     <script src="<?php echo base_url() ?>assets/js/jquery-3.7.1.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/app.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
		<!-- ========================================== -->
<?php 
if($this->session->flashdata('success') != '')
{
    ?>
    <script type="text/javascript">
      $(document).ready(function () {
        var msg = "<?php echo $this->session->flashdata('success'); ?>";
        swal(msg, "", "success");
      });
    </script>
  <?php
}
if($this->session->flashdata('error') != '')
{
    ?>
        <script type="text/javascript">
          $(document).ready(function () {
            var msg = "<?php echo $this->session->flashdata('error'); ?>";
            swal(msg, "", "error");
          });
        </script>
    <?php
}
?>
		
    </body>



</html>
<script type="text/javascript">
  timer();
  function timer()
  {
   
    var now = Math.floor(Date.now() / 1000);

  
    var end = now + (3 * 60);

  
    var interval = setInterval(function() {
  
    var now = Math.floor(Date.now() / 1000);
    
   
    var remaining = end - now;
    
  
    if (remaining <= 0) {
        clearInterval(interval);
        document.getElementById('countdown').innerHTML = 'OTP expired.';
        return;
    }
    
  
    var minutes = Math.floor(remaining / 60);
    var seconds = remaining % 60;
    

    var time = ('0' + minutes).slice(-2) + ':' + ('0' + seconds).slice(-2);
    

    document.getElementById('countdown').innerHTML = 'Time remaining: ' + time;
    }, 1000);
  }
</script>

<script type="text/javascript">
  
  function resend_otp()
  {
        $("#resend_field").hide();
        $("#spinner").show();
        var email_id = $("#email_id").val();
        $.ajax({
               type: "POST",
               url: '<?php echo base_url(); ?>Authentication/get_again_otp',
               data: { email_id:email_id},
               success: function (res) {

                  var response = JSON.parse(res);
                  console.log(response);
                   if (response.response_code == 200) {
                      $("#spinner").hide();
                       swal("success", "OTP Resend Successfully.", "success");
                       timer();
                   }
                   else {
                       swal("warning", response.msg, "error");
                   }
               },
           }); 
       }

  function verify_otp()
  {
    
        var email_id = $("#email_id").val();
        var otp = $("#otp").val();
        $.ajax({
               type: "POST",
               url: '<?php echo base_url(); ?>Authentication/verify_otp',
               data: { email_id:email_id,otp:otp},
               success: function (res) {

                  var response = JSON.parse(res);
              
                   if (response.response_code == 200) {
                       swal("success", "OTP Verified Successfully.", "success");
                       $('#password_field').show();
                       $('#confirm_password_field').show();
                       $('#otp').attr('readonly',true);
                       $('#verify_otp_btn').hide();
                       $('#verified_otp_btn').show();
                       $('#password_save').show();
                       
                   }
                   else {
                       swal("warning", response.msg, "error");
                       $('#password_field').hide();
                       $('#confirm_password_field').hide();
                       $('#password_save').hide();
                   }
               },
           }); 
       }

  
  function show_resend() {
    $('#resend_field').show();
    
  }

  setTimeout(show_resend, 3 * 60 * 1000); 

 
</script>
<script type="text/javascript">
    generateCaptcha();
    function generateCaptcha() {
       var charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            var captcha = '';
            for (var i = 0; i < 6; i++) {
                captcha += charset.charAt(Math.floor(Math.random() * charset.length));
            }

            // Set captcha text
            document.getElementById('recaptcha').textContent = captcha;

            document.getElementById('hdn_captcha').value = captcha;

            var canvas = document.getElementById('canvas_captcha');
            var ctx = canvas.getContext('2d');
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.font = '30px Arial';
            ctx.fillText(captcha, 10, 30);
    }
</script>
<script type="text/javascript">
     function validateData() 
     {

        var captcha = document.getElementById('hdn_captcha').value; 
        var userInput = document.getElementById('recaptcha').value;

        console.log('captcha==',captcha);
        console.log('userInput==',userInput);
        if (captcha == userInput) {
             $('#verify_otp_btn').show(); 
            
        } else {
             $('#verify_otp_btn').hide();
            swal("warning","CAPTCHA is incorrect. Please try again.",'error');
        }
    }
</script>
<script type="text/javascript">
    function refreshCaptcha() {
      
        generateCaptcha();
    }
</script>