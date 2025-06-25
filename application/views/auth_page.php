<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">
    
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Smarthr - Bootstrap Admin Template">
	<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
    <meta name="author" content="Dreamguys - Bootstrap Admin Template">
    <title>Login :: ONGC</title>
   <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>assets/img/logo_square.png"/>
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/fontawesome/css/fontawesome.min.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/line-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/material.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/line-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/customeStyle.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>


</head>
<body class="account-page">
	<style type="text/css">
	  .colored-hr {
               border-top: 2px solid blue; 
               background-image: linear-gradient(to right, #b3e0ff, #66a3ff); 
             }

	</style>
		
    <div class="main-wrapper blur-background" style="background-image: url('assets/img/ongc.jpeg');"> 
        <div class="account-content">
	        <div class="container" >
	           <div class="account-box" style="right:0;position:absolute;bottom:0;margin:0;width:400px;">
                    <div class="card-box p-4" style="height:100vh;">
                        <div class="p-2">
                            <h3 class=" text-center" style="color:blue;"><b>Oil and Natural Gas Corporation Cambay Asset</b></h3>
                           
                            <div class="text-center">
                                 <img src="<?php echo base_url() ?>assets/img/logo.png" width="70" style="border-radius: 50%; height:50"> 
                            </div>
                            <hr class="colored-hr">

                            <form method="POST" class="custom-validation" action="<?php echo base_url(); ?>Authentication/login_details" enctype="multipart/form-data"> 

                               <div class="input-block mb-1">
    		                       <label class="col-form-label">User Id</label>
    			                   <input class="form-control" id="mobile_no" name="mobile_no" type="text" required>
    			               </div>
    				            <div class="input-block mb-1">
    				              <label class="col-form-label">Password</label>
    					          <input class="form-control" type="password" id="password" name="password" required placeholder="************" >
    					            <!-- <span class="fa-solid fa-eye-slash" id="toggle-password"></span> -->
    				            </div>
				        
                            <div class="input-block mb-2 ">
                                <div class="row">
                                    <div class="col-6">
                                        <canvas class="bg-light rounded px-2" id="captchaCanvas" width="150" height="50"></canvas>
                                    </div>
                                    <div class="col-4 mt-3">
                                        <button class="fa fa-refresh mt-1" type="button" onclick="refreshCaptcha();" style="color: blue;"></button>
                                    </div>
                                </div>
                                <input type="hidden" name="hdn_captcha" id="hdn_captcha" readonly>
                            </div>

                            <div class="input-block mb-2">
                                <h6><b>Enter Captcha</b></h6>
                                <input type="text" name="captchaText" id="captchaText" class="form-control" required>
                            </div>
    
                             <div class="input-block mb-4 text-center">
			                       <button class="btn btn-primary account-btn" type="submit">Login</button>
                                    
                             </div>
                             <div class="input-block mb-4 text-center">
                                     <button type="button" data-bs-toggle="modal" data-bs-target="#modal1" class="btn btn-success">Forgot Password ?</button>
                            </div>

				             
                            </form>

                            <div class="mt-5 pt-4 text-center position-relative">
                             <p class="text">CopyRight © <script>document.write(new Date().getFullYear())</script> &nbsp;Developed by ISPL™</p>
                        </div>

                    </div>
                    </div>
                </div>
            </div>
        </div> 
    </div> 
    <!-- Add Forget Password Modal -->
    <div id="modal1" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Forgot Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <hr class="colored-hr">
                <div class="modal-body">
                    <form role="form" class="custom-validation" method="POST" action="<?php echo base_url('Authentication/get_otp'); ?>" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="input-block mb-3">
                                    <label class="col-form-label">Email Id</label>
                                        <input type="email" name="email_id" id="email_id" class="form-control" required  >
                                                    </div>
                                                </div>
                                                 <div class="col-md-12 mt-1">
                                                    <h5><b>CAPTCHA <span style="color:red">*</span></b></h5>
                                                    
                                        <canvas class="bg-light rounded px-2" id="canvas_captcha" width="150" height="50"></canvas>
                                                    <button class="fa fa-refresh mt-1" type="button" onclick="refreshCaptcha_login();"  style="color: blue;"></button>
                                                   <input type="hidden" class="form-control" id="captchimage" name="captchimage">
                                                </div>
                                                <div class="col-md-12 mt-1">
                                                 <h5><b>Enter Captcha <span style="color:red">*</span></b></h5>
                                                 <input type="text" name="recaptcha" id="recaptcha" class="form-control" required onchange="validateData();">
                                                </div>
                                                
                                                
                                            </div>
                                            <div class="submit-section">
                                                <button type="submit" class="btn btn-sm btn-success" onclick="show_otp();">Send OTP</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                <!-- /Add Goal Modal -->     


		
<script src="<?php echo base_url() ?>assets/js/jquery-3.7.1.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/app.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</body>
</html>
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


<script type="text/javascript">
    generateCaptcha();
   
    function generateCaptcha() {
            var charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            var captcha = '';
            for (var i = 0; i < 6; i++) {
                captcha += charset.charAt(Math.floor(Math.random() * charset.length));
            }

            // Set captcha text
            document.getElementById('captchaText').textContent = captcha;

            document.getElementById('hdn_captcha').value = captcha;

            var canvas = document.getElementById('captchaCanvas');
            var ctx = canvas.getContext('2d');
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.font = '30px Arial';
            ctx.fillText(captcha, 10, 30);
        }
</script>
<script type="text/javascript">
     generate_data_Captcha();
    function generate_data_Captcha() {
       var charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            var captcha = '';
            for (var i = 0; i < 6; i++) {
                captcha += charset.charAt(Math.floor(Math.random() * charset.length));
            }

            // Set captcha text
            document.getElementById('captchaText').textContent = captcha;

            document.getElementById('captchimage').value = captcha;

            var canvas = document.getElementById('canvas_captcha');
            var ctx = canvas.getContext('2d');
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.font = '30px Arial';
            ctx.fillText(captcha, 10, 30);

    }
</script>
<script type="text/javascript">
  
  function show_otp()
  {
    let email = $('#email_id').val();
    let captcha = $('#captchimage').val();
    let recaptcha = $('#recaptcha').val();
    if (email == "")
    {
      swal('error','Please Enter your Email Id to get OTP','error');
    }else if(captcha != recaptcha)
    {
        swal('error','Please Enter Correct captcha','error');
    }
  }

</script>
<script type="text/javascript">
     function validateData() 
     {

        var captcha = document.getElementById('captchimage').value; 
        var userInput = document.getElementById('recaptcha').value;
        if (captcha == userInput) {
            
            
        } else {
             
            swal("warning","CAPTCHA is incorrect. Please try again.",'error');
        }
    }
</script>
<script type="text/javascript">
    function refreshCaptcha() {
      
        generateCaptcha();
    }
</script>
<script type="text/javascript">
    function refreshCaptcha_login() {
      
        generate_data_Captcha();
    }
</script>