<div class="page-wrapper">
    <div class="content container-fluid pb-0">
    	<div class="page-header">
			<div class="content-page-header">
				<h5>User</h5>
			</div>	
		</div>
			<div class="row">					
						<!-- Lightbox -->
                <div class="col-lg-12">
                    <div class="card">
                       
                        <div class="card-body">
                           <div class="row align-items-center">
                                <div class="col">
                                   <h4 class="header-title mb-4"><b>Add User</b></h4>
                                </div>
                                <div class="col-auto float-end ms-auto">
                                     <a href="<?php echo base_url('User_c'); ?>">
                                       <button type="button" class="btn btn-sm btn-rounded btn-success">Back</button>
                                    </a>
                                </div>
                            </div>


                            <form class="custom-validation" method="POST" action="<?php echo base_url('User_c/add_user'); ?>" enctype="multipart/form-data">
                        <div class="row">
                            <div class="form-group col-md-6 mt-2">
                                <h4><b>User Name <span style="color:red">*</span></b></h4>
                                <input type="text" name="user_name" id="user_name" class="form-control" required onkeyup="this.value = this.value.replace(/[^a-zA-Z ]/g,'')">
                            </div>

                            <div class="form-group col-md-6 mt-2">
                                <h4><b>Mobile No <span style="color:red">*</span></b></h4>
                                <input type="tel" name="mobile_no" id="mobile_no" class="form-control" maxlength="10" minlength="10" required onkeyup="this.value = this.value.replace(/[^0-9]/g,'')">
                            </div>

                            <div class="form-group col-md-6 mt-2">
                                <h4><b>Email Id <span style="color:red">*</span></b></h4>
                                <input type="email" name="email_id" id="email_id" class="form-control" required >
                            </div>

                             <div class="form-group col-md-6 mt-2">
                                <h4><b>Password <span style="color:red">*</span></b></h4>
                                <input type="password" name="password" id="password" class="form-control" required maxlength="10" minlength="8" onkeyup="this.value = this.value.replace(/[<>]/g,'')">
                            </div>

                            <div class="form-group col-md-6 mt-2">
                                <h4><b>User Id <span style="color:red">*</span></b></h4>
                                <input type="text" name="emp_user_id" id="emp_user_id" class="form-control" required onkeyup="this.value = this.value.replace(/[^a-zA-Z0-9-]/g,'')">
                            </div>

                            <div class="form-group col-md-6 mt-2">
                                <h4><b>Employee Id <span style="color:red">*</span></b></h4>
                                <input type="text" name="emp_id" id="emp_id" class="form-control" required onkeyup="this.value = this.value.replace(/[^a-zA-Z0-9- ]/g,'')">
                                <p>Note:-write employee id as EMP-</p>
                            </div>

                            <div class="form-group col-md-6 mt-2" >
                                <h4><b>Level <span style="color:red">*</span></b></h4>
                                <select name="user_level" id="user_level" class="form-control select2"  required >
                                    <option value="">Select level</option>
                                    <option value="1">Assets level(Tier-III)</option>
                                    <option value="2">Area Level(Tier-II)</option>
                                    <option value="3">Installation Level(Tier-I)</option>
                                    <option value="5"> Field Maintenance User</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6 mt-2" >
                                <h4><b>Country <span style="color:red"></span></b></h4>
                                <select name="country" id="country" class="form-control select2"   onchange="getstate_list();">
                                    <option value="">Select Country</option>
                                    <?php 
                                    if(!empty($country_list))
                                    {
                                        foreach ($country_list as $key => $value) 
                                        {
                                            ?>
                                                <option value="<?php echo $value['id']; ?>"> <?php echo $value['name']; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                              </div>

                              <div class="form-group col-md-6 mt-2">
                                <h4><b>State <span style="color:red"></span></b></h4>
                                <select name="state" id="state" class="form-control select2" >
                                    <option value="">Select state</option>
                                    
                                </select>
                              </div>

                              <div class="form-group col-md-6 mt-2">
                                <h4><b>City <span style="color:red"></span></b></h4>
                                <input type="text" name="city" id="city" class="form-control"  onkeyup="this.value = this.value.replace(/[^a-zA-Z- ]/g,'')">
                              </div>



                            <div class="form-group col-md-6 mt-2">
                                <h4><b>Address <span style="color:red"></span></b></h4>
                                <textarea type="text" name="address" id="address" class="form-control"  onkeyup="this.value = this.value.replace(/[^a-zA-Z0-9-,.\/ ]/g,'')"></textarea>
                            </div>
                        </div>
                        <h4><b>Access Functionality</b></h4>
                        <div class="row mt-3">
                            <div class="form-group col-md-3 mt-2">
                                <input type="checkbox" name="web_access" value="1" id="web_access" >
                                <label style="font-size: 15px;"><b>Web Access</b></label>
                            </div>

                            <div class="form-group col-md-3 mt-2">
                                <input type="checkbox" name="mobile_access" id="mobile_access" value="1" >
                                <label style="font-size: 15px;"><b>Mobile Access</b></label>
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
            url: '<?php echo base_url(); ?>User_c/get_state_list',
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
