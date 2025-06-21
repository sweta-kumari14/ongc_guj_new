<div class="page-wrapper">
    <div class="content container-fluid pb-0">
    	<div class="page-header">
			<div class="content-page-header">
				<h4>Equipment Details</h4>
			</div>	
		</div>
			<div class="row">					
						<!-- Lightbox -->
                        <div class="col-lg-12">
                            <div class="card">
                               
                                <div class="card-body">
                                   <div class="row align-items-center">
                                        <div class="col">
                                           <h4 class="header-title mb-4"><b>Equipment Details</b></h4>
                                        </div>
                                        <div class="col-auto float-end ms-auto">
                                             <a href="<?php echo base_url('Dashboard_c'); ?>">
                                               <button type="button" class="btn btn-sm btn-rounded btn-success">Back</button>
                                            </a>
                                        </div>
                                    </div>

                                   <form role="form" class="custom-validation" method="POST" action="<?php echo base_url('Equipment_details_c/equipment_allotment'); ?>">
									<div class="row">
										<div class="form-group col-md-4 mb-4">
											<h4><b>Assets</b></h4>
											<select name="assets_id" id="assets_id" class="form-control select2" required onchange="get_area_list();"> 
												<!-- <option value="">Select Assets</option> -->
												<?php 
												if (!empty($assets_list))
												{
													foreach ($assets_list as $key => $value)
													{
														?>
															<option value="<?php echo $value['id']; ?>"><?php echo $value['assets_name']; ?></option>
														<?php
													}
												}
												?>
											</select>
										</div>

										<div class="form-group col-md-4 mb-4">
											<h4><b>Area</b></h4>
											<select name="area_id" id="area_id" class="form-control select2" required onchange="get_site_list();"> 
												<option value="">Select</option>
																							
											</select>
										</div>

										<div class="form-group col-md-4 mb-4">
											<h4><b>Site</b></h4>
											<select name="site_id" id="site_id" class="form-control select2" required onchange="get_well_list();"> 
												<option value="">Select Site</option>
																							
											</select>
										</div>

										<div class="form-group col-md-4 mb-4">
											<h4><b>Well</b></h4>
											<select name="well_id" id="well_id" class="form-control select2" required> 
												<option value="">Select Well</option>
																							
											</select>
										</div>


										<div class="form-group col-md-4 mb-4">
											<h4><b>Select Equipment</b></h4>
											<select name="equipment_id" id="equipment_id" class="form-control select2" required> 
												<option value="">Select Equipment</option>
												<?php 
												if (!empty($equipment_list))
												{
													foreach ($equipment_list as $key => $value)
													{
														?>
															<option value="<?php echo $value['id']; ?>"><?php echo $value['equipment_name']; ?></option>
														<?php
													}
												}
												?>
											</select>
										</div>

										<div class="form-group col-md-4 mb-4">
											<h4><b>Motor Serial No</b></h4>
											<input data-parsley-type="number" name="serial_no" id="serial_no" maxlength="20" minlength="8" class="form-control" required onblur="get_motor_serial_number();">
										</div>

										<div class="form-group col-md-4 mb-4">
											<h4><b>Name</b></h4>
											<input type="text" name="motor_name" id="motor_name" class="form-control" required onkeyup="this.value = this.value.replace(/[<>]/g,'')">
										</div>

										<div class="form-group col-md-4 mb-4">
											<h4><b>Motor Capacity (in HP)</b></h4>
											<input data-parsley-type="number" data-parsley-pattern="^[-+]?[0-9]*\.?[0-9]+([eE][-+]?[0-9]+)?$" name="motor_capacity" id="motor_capacity" class="form-control" required>
										</div>

										<div class="form-group col-md-4 mb-4">
											<h4><b>Surface Unit Make && Model</b></h4>
											<input type="text" name="surface_unit_make_name" id="surface_unit_make_name" class="form-control" required onkeyup="this.value = this.value.replace(/[<>]/g,'')">
										</div>

										<div class="form-group col-md-4 mb-4">
											<h4><b>Panel Make</b></h4>
											<input type="text" name="vfd_make" id="vfd_make" class="form-control" required onkeyup="this.value = this.value.replace(/[<>]/g,'')">
										</div>

										<div class="form-group col-md-4 mb-4">
											<h4><b>Panel Model</b></h4>
											<input type="text" name="vfd_model" id="vfd_model" class="form-control" required onkeyup="this.value = this.value.replace(/[<>]/g,'')">
										</div>

										<div class="form-group col-md-4 mb-4">
											<h4><b>Panel Capacity (HP)</b></h4>
											<input data-parsley-type="number" data-parsley-pattern="^[-+]?[0-9]*\.?[0-9]+([eE][-+]?[0-9]+)?$" name="vfd_capacity" id="vfd_capacity" class="form-control" required>
										</div>
										<div class="form-group col-md-4 mb-4">
											<h4><b>Power Source</b></h4>
											<select name="power_source" id="power_source" class="form-control select2" required> 
												<option value="">Select Power Source</option>
												<option value="DG">DG</option>
												<option value="GG">GG</option>
												<option value="SEB(Gujarat)">SEB(Gujarat)</option>
											
											</select>
										</div>

										<div class="form-group col-md-4 mb-4">
											<h4><b>DG/GG Make</b></h4>
											<input type="text" name="dg_gg_make" id="dg_gg_make" class="form-control" required onkeyup="this.value = this.value.replace(/[<>]/g,'')">
										</div>

										<div class="form-group col-md-4 mb-4">
											<h4><b>DG/GG rating (Kva)</b></h4>
											<input data-parsley-type="number" data-parsley-pattern="^[-+]?[0-9]*\.?[0-9]+([eE][-+]?[0-9]+)?$" name="dg_gg_rating" id="dg_gg_rating" class="form-control" required>
										</div>                                   
									</div>
                                
                                <div class="footer">
                                    <button type="submit" class="btn btn-primary ">Submit</button>
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



<script type="text/javascript">
    get_area_list();
    function get_area_list()
    {  
       let assets_id = $('#assets_id').val();
       let company_id = '<?php echo $this->session->userdata('company_id') ?>';
       $.ajax({
            type: 'POST',
            url: '<?php echo base_url();?>Equipment_details_c/get_area_list',
            data:{company_id:company_id,assets_id:assets_id},
            success:function(data)
            {
                data = JSON.parse(data);
                console.log(data);
                if(data.response_code==200)
                {   
                    if(data.data.length>0)
                    {
                        $('#area_id').html('');
                        $('#area_id').html('<option value=" ">Select Area</option>');
                        $.each(data.data,function(i,v){
  
                        $('#area_id').append('<option value="'+v.id+'">'+v.area_name+'</option>');
                           
                            
                        });
                        
                    }else
                    {
                        $('#area_id').html('No Data Found');
                    }
                }else
                {
                    swal('error',data.msg,'error');
                }
              console.log();
            }
    
          });
    }

    function get_site_list()
    {  
       let assets_id = $('#assets_id').val();
       let area_id = $('#area_id').val();
       let company_id = '<?php echo $this->session->userdata('company_id') ?>';
       $.ajax({
            type: 'POST',
            url: '<?php echo base_url();?>Equipment_details_c/get_site_list',
            data:{company_id:company_id,assets_id:assets_id,area_id:area_id},
            success:function(data)
            {
                data = JSON.parse(data);
                console.log(data);
                if(data.response_code==200)
                {   
                    if(data.data.length>0)
                    {
                        $('#site_id').html('');
                        $('#site_id').html('<option value=" ">Select Area</option>');
                        $.each(data.data,function(i,v){
  
                        $('#site_id').append('<option value="'+v.id+'">'+v.well_site_name+'</option>');
                           
                            
                        });
                        
                    }else
                    {
                        $('#site_id').html('No Data Found');
                    }
                }else
                {
                    swal('error',data.msg,'error');
                }
              console.log();
            }
    
          });
    }

    function get_well_list()
    {  
       let assets_id = $('#assets_id').val();
       let area_id = $('#area_id').val();
       let site_id = $('#site_id').val();
       let company_id = '<?php echo $this->session->userdata('company_id') ?>';
       $.ajax({
            type: 'POST',
            url: '<?php echo base_url();?>Equipment_details_c/get_well_list',
            data:{company_id:company_id,assets_id:assets_id,area_id:area_id,site_id:site_id},
            success:function(data)
            {
                data = JSON.parse(data);
                console.log(data);
                if(data.response_code==200)
                {   
                    if(data.data.length>0)
                    {
                        $('#well_id').html('');
                        $('#well_id').html('<option value=" ">Select Area</option>');
                        $.each(data.data,function(i,v){
  
                        $('#well_id').append('<option value="'+v.id+'">'+v.well_name+'</option>');
                           
                            
                        });
                        
                    }else
                    {
                        $('#well_id').html('No Data Found');
                    }
                }else
                {
                    swal('error',data.msg,'error');
                }
              console.log();
            }
    
          });
    }
</script>

<script type="text/javascript">
    

    function get_motor_serial_number()
    {
       
        let serial_no = $('#serial_no').val();
        let assets_id = $('#assets_id').val();
        let area_id = $('#area_id').val();
        let site_id = $('#site_id').val();
        let well_id = $('#well_id').val();
        let eqp_id = $('#equipment_id').val();
        let company_id = '<?php echo $this->session->userdata('company_id') ?>';
        $.ajax({
           url: '<?php echo base_url();?>Equipment_details_c/get_motor_serial_number',
           type: 'POST',
           data: {serial_no:serial_no,company_id:company_id,assets_id:assets_id,area_id:area_id,site_id:site_id,well_id:well_id,eqp_id:eqp_id},
           success: function (res) {
                res = JSON.parse(res);
               if(res.response_code==200)
               {
                    $.each(res.data, function (i, v) {
                    if (v.serial_no == serial_no)
                    {
                       $('#motor_name').val(v.motor_name); 
                       $('#motor_capacity').val(v.motor_capacity); 
                       $('#surface_unit_make_name').val(v.surface_unit_make);
                       $('#vfd_make').val(v.vfd_make);
                       $('#vfd_model').val(v.vfd_model);
                       $('#vfd_capacity').val(v.vfd_capacity);
                       $('#dh_pump_make').val(v.dh_pump_make);
                       $('#dh_pump_capacity').val(v.dh_pump_capacity);
                       $('#power_source').val(v.power_source).change();
                       $('#dg_gg_make').val(v.dg_gg_make);
                       $('#dg_gg_rating').val(v.dg_gg_rating); 
                       
                    }   
               });   
               }else
               {
                   swal('error','','error');
               }
              console.log(res);
           },
       }); 
    }
</script>
