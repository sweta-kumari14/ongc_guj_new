<div class="page-wrapper">
    <div class="content container-fluid pb-0">
    	<div class="page-header">
			<div class="content-page-header">
				<h5>Device</h5>
			</div>	
		</div>
		<div class="row">					
			<!-- Lightbox -->
            <div class="col-lg-12">
                <div class="card">
                   
                    <div class="card-body">
                       <div class="row align-items-center">
                            <div class="col">
                               <h4 class="header-title mb-4"><b>Edit Device</b></h4>
                            </div>
                            <div class="col-auto float-end ms-auto">
                                 <a href="<?php echo base_url('Device_c'); ?>">
                                   <button type="button" class="btn btn-sm btn-rounded btn-success">Back</button>
                                </a>
                            </div>
                        </div>


                        <form  class="custom-validation" role="form" method="POST" action="<?php echo base_url('Device_c/update_device') ?>" enctype="multipart/form-data">
                            <input type="hidden" name="id" id="id" value="<?php echo $device_list[0]['id']; ?>">
                            <div class="row">
                            <div class="form-group col-md-6 mt-2">
                                <h5><b>Imei No </b><span class="text-danger">*</span></h5>
                                <div class="controls">
                                    <input data-parsley-type="alphanum" name="imei_no" id="imei_nos" class="form-control" required maxlength="20" minlength="10" value="<?php echo $device_list[0]['imei_no']; ?>" onkeyup="this.value = this.value.replace(/[<>]/g,'')">
                                </div>
                            </div>

                            <div class="col-md-6 mt-2">
                                <h5><b>Serial No</b></h5>
                                <input data-parsley-type="text" name="serial_no" id="serial_no" class="form-control"  maxlength="20" minlength="10" value="<?php echo htmlspecialchars($device_list[0]['serial_no']); ?>" onkeyup="this.value = this.value.replace(/[^a-zA-Z0-9,.-]/g,'')">
                            </div>
                             <div class="col-md-6 mt-2">
                                <h5><b>Model Name</b><span style="color:red;">*</span></h5>
                                <input data-parsley-type="text" name="model_name" id="model_name" class="form-control" required value="<?php echo htmlspecialchars($device_list[0]['model_name']); ?>" onkeyup="this.value = this.value.replace(/[<>]/g,'')">
                            </div>
                            
                            <div class="col-md-6 mt-2">
                                <h5><b>Manufacturer Year</b><span style="color:red;">*</span></h5>
                                <select name="manufacturer_year" id="manufacturer_year" class="form-control" >
                                <?php
                                    $current_year = date('Y');
                                    for($i= $current_year - 3; $i < $current_year +3; $i++)
                                     {
                                         echo '<option value="'.$i.'"';
                                         if( $i ==  $device_list[0]['year_of_manufacturer'] ) {
                                                echo ' selected="selected"';
                                         }
                                         echo ' >'.$i.'</option>';
                                     }               
                                     echo '<select>';
                                    ?>
                                </select>
                                
                            </div>
                            <div class="col-md-6 mt-2">
                                <h5><b>Manufacture Month</b><span style="color:red;">*</span></h5>
                                <input data-parsley-type="text" name="manufacturer_month" id="manufacturer_month" class="form-control" required value="<?php echo htmlspecialchars($device_list[0]['manufacturer_month']); ?>" onkeyup="this.value = this.value.replace(/[<>]/g,'')">
                            </div>
                            </div>
                            <div class="footer mt-4">
                             <div>
                                <button type="submit" class="btn btn-sm btn-primary" >Update</button>
                             </div>
                            </div>
                    
                        </form>
                                                            
                        </div>
                    </div>
                </div>
            </div>
        </div>                  
	</div>		
