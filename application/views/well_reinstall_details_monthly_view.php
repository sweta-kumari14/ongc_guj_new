<div class="page-wrapper">
    <div class="content container-fluid pb-0">
    	<div class="page-header">
			<div class="content-page-header">
				<h5>Well Re-Installation</h5>
			</div>	
		</div>
			<div class="row">					
						<!-- Lightbox -->
                        <div class="col-lg-12">
                            <div class="card">
                               
                                <div class="card-body">
                                   <div class="row align-items-center">
                                        <div class="col">
                                           <h4 class="header-title mb-4"><b>Well Re-Installation</b></h4>
                                        </div>
                                       
                                    </div>

                                <form class="custom-validation" method="POST" action="<?php echo base_url('Well_install_c/add_well_install'); ?>" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="form-group col-md-3 mt-2">
                                        <h4><b>Well Name<span style="color:red">*</span></b></h4>
                                        <select name="well_id" id="well_id" class="form-control select2" >
                                            <option value="">Select Well</option>
                                            <?php 
                                            if(!empty($well_list))
                                            {
                                                foreach ($well_list as $key => $value) 
                                                {
                                                    ?>
                                                        <option value="<?php echo $value['id']; ?>"> <?php echo $value['well_name']; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>

                                  
                                    <div class="form-group col-md-3 mt-2">
                                        <h4><b>Re-Installtion Date<span style="color:red">*</span></b></h4>
                                        <input type="date" id="date" name="date" value="<?= date('Y-m-d',time()); ?>" class="form-control" required>
                                        
                                    </div>
                                     <div class="form-group col-md-3 mt-2">
                                        <h4><b>reason</b></h4>
                                        <textarea type="text" id="reason" name="reason" class="form-control"></textarea>
                                        
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






                


