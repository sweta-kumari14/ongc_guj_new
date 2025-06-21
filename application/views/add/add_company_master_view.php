<div class="page-wrapper">
    <div class="content container-fluid pb-0">
    	<div class="page-header">
			<div class="content-page-header">
				<h5>Company</h5>
			</div>	
		</div>
			<div class="row">					
						<!-- Lightbox -->
                        <div class="col-lg-12">
                            <div class="card">
                               
                                <div class="card-body">
                                   <div class="row align-items-center">
                                        <div class="col">
                                           <h4 class="header-title mb-4"><b>Add Company</b></h4>
                                        </div>
                                        <div class="col-auto float-end ms-auto">
                                             <a href="<?php echo base_url('Company_c/index'); ?>">
                                               <button type="button" class="btn btn-sm btn-rounded btn-success">Back</button>
                                            </a>
                                        </div>
                                    </div>


                                    <form class="custom-validation" method="POST" action="<?php echo base_url('Company_c/add_company'); ?>" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="form-group col-md-6 mb-4">
                                        <h4><b>Company Name <span style="color:red">*</span></b></h4>
                                        <input type="text" name="company_name" id="company_name" class="form-control" required onkeyup="this.value = this.value.replace(/[^a-zA-Z-,. ]/g,'')">
                                    </div>

                                    <div class="form-group col-md-6 mb-4">
                                        <h4><b>Mobile No <span style="color:red">*</span></b></h4>
                                        <input type="number" name="mobile_no" id="mobile_no" class="form-control" maxlength="10" minlength="10" required >
                                    </div>

                                    <div class="form-group col-md-6 mb-4">
                                        <h4><b>Email Id <span style="color:red">*</span></b></h4>
                                        <input type="email" name="email_id" id="email_id" class="form-control" required >
                                    </div>

                                    <div class="form-group col-md-6 mb-4">
                                        <h4><b>Company ID <span style="color:red">*</span></b></h4>
                                        <input type="text" name="company_id" id="company_id" class="form-control" required onkeyup="this.value = this.value.replace(/[^a-zA-Z0-9-]/g,'')">
                                    </div>

                                    <div class="form-group col-md-6 mb-4" >
                                        <h4><b>Country <span style="color:red">*</span></b></h4>
                                        <select name="country" id="country" class="form-control select2"  required onchange="getstate_list();" style="width:100%;">
                                            <option value="">Select Country</option>
                                            <?php 
                                            if(!empty($country_list))
                                            {
                                                foreach ($country_list as $key => $value) 
                                                {
                                                    ?>
                                                        <option value="<?php echo htmlspecialchars($value['id']); ?>"> <?php echo htmlspecialchars($value['name']); ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                      </div>

                                      <div class="form-group col-md-6 mb-4">
                                        <h4><b>State <span style="color:red">*</span></b></h4>
                                        <select class="select2 form-control" id="state" name="state" required>
                                            <option value="">Select state</option>
                                            
                                        </select>
                                      </div>

                                    <div class="form-group col-md-6 mb-4">
                                        <h4><b>City <span style="color:red">*</span></b></h4>
                                        <input type="text" name="city" id="city" class="form-control" required onkeyup="this.value = this.value.replace(/[^a-zA-Z0-9- ]/g,'')">
                                    </div>

                                    <div class="form-group col-md-6 mb-4">
                                        <h4><b>Logo <span style="color:red">*</span></b></h4>
                                        <input type="file" name="logo" id="logo" class="form-control" required accept=".jpg,.png,.jpeg">
                                    </div>

                                    <div class="form-group col-md-6 mb-4">
                                        <h4><b>Address <span style="color:red">*</span></b></h4>
                                        <textarea type="text" name="address" id="address" class="form-control" required onkeyup="this.value = this.value.replace(/[^a-zA-Z0-9-,.\/ ]/g,'')"></textarea>
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
<script type="text/javascript">
    
    function getstate_list()
    {

        let country_code = $('#country').val();
        // alert(country_code);
         $.ajax({
            url: '<?php echo base_url(); ?>Company_c/get_state_list',
            type: 'POST',
            data: {country_code: country_code},
            success:function(res)
            {
                response = JSON.parse(res);
                console.log(response);
                if(response.data.length>0)
                {
                    $('#state').html('<option value="">Select state</option>');
                    $.each(response.data,function(i,v){
                        $('#state').append('<option value="'+v.id+'">'+v.name+'</option>');
                    });
                }
            }
        });
    }
</script>