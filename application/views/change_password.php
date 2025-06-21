<div class="page-wrapper">
    <div class="content container-fluid pb-0">
    	<div class="page-header">
			<div class="content-page-header">
				<h5>Change Password</h5>
			</div>	
		</div>
			<div class="row">					
					<!-- Lightbox -->
                    <div class="col-lg-12">
                        <div class="card">
                           
                            <div class="card-body">
                               <div class="row align-items-center">
                                    <div class="col">
                                       <h4 class="header-title mb-4"><b>Change Password</b></h4>
                                    </div>
                                    <div class="col-auto float-end ms-auto">
                                         <a href="<?php echo base_url('Dashboard_c'); ?>">
                                           <button type="button" class="btn btn-sm btn-rounded btn-success">Back</button>
                                        </a>
                                    </div>
                                </div>


                               <form class="custom-validation" method="POST" action="<?php echo base_url('Change_password_c/change_password'); ?>" enctype="multipart/form-data">
                            <div class="row">
                                <div class="form-group col-md-6 mt-2">
                                    <h4><b>Old Password <span style="color:red">*</span></b></h4>
                                    <input type="password" name="old_password" id="old_password" class="form-control" required onkeyup="this.value = this.value.replace(/[<>]/g,'')">
                                </div>

                                <div class="form-group col-md-6 mt-2">
                                    <h4><b>New Password <span style="color:red">*</span></b></h4>
                                    <input type="password" name="new_password" id="new_password" class="form-control" required onkeyup="this.value = this.value.replace(/[<>]/g,'')">
                                </div>
                            </div>
                            <div class="footer mt-4">
                                <div>
                                    <button type="submit" class="btn btn-sm btn-primary" >Submit</button>
                                </div>
                            </div>
                            
                        </form>
                                
                    </div>
                </div>
            </div>
        </div>
    </div>                  			
</div>
<?php 
if($this->session->flashdata('success') != '')
{
    ?>
    <script type="text/javascript">
      $(document).ready(function () {
        var msg = "<?php echo $this->session->flashdata('success'); ?>";
        swal(msg, "", "success");
        setTimeout(function(){
            window.location.href = "<?php echo site_url('Authentication/signout'); ?>";
        }, 900); 
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