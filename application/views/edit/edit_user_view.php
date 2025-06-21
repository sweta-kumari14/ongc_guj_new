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
                                           <h4 class="header-title mb-4"><b>Edit User</b></h4>
                                        </div>
                                        <div class="col-auto float-end ms-auto">
                                             <a href="<?php echo base_url('User_c'); ?>">
                                               <button type="button" class="btn btn-sm btn-rounded btn-success">Back</button>
                                            </a>
                                        </div>
                                    </div>

                                  <form class="custom-validation" method="POST" action="<?php echo base_url('User_c/update_user'); ?>" enctype="multipart/form-data">
                                <div class="row">
                                    <input type="hidden" id="id" name="id" value="<?php echo $this->uri->segment(3); ?>">
                                    <div class="col-md-6 mt-2">
                                        <h4><b>User Name <span style="color:red">*</span></b></h4>
                                        <input type="text" name="user_name" id="user_name" class="form-control" value="<?php echo $user_list[0]['user_full_name']; ?>" required onkeyup="this.value = this.value.replace(/[^a-zA-Z ]/g,'')">
                                    </div>

                                    <div class="col-md-6 mt-2">
                                        <h4><b>Mobile No <span style="color:red"></span></b></h4>
                                        <input type="number" name="mobile_no" id="mobile_no" class="form-control" maxlength="10" minlength="10"  value="<?php echo $user_list[0]['contact_no']; ?>" onkeyup="this.value = this.value.replace(/[^0-9]/g,'')"
>
                                    </div>

                                    <div class="col-md-6 mt-2">
                                        <h4><b>Email Id <span style="color:red">*</span></b></h4>
                                        <input type="email" name="email_id" id="email_id" class="form-control" required value="<?php echo $user_list[0]['email_id']; ?>">
                                    </div>

                                    <div class="form-group col-md-6 mt-2">
                                        <h4><b>Employee Id <span style="color:red">*</span></b></h4>
                                        <input type="text" name="emp_id" id="emp_id" class="form-control" required onkeyup="this.value = this.value.replace(/[^a-zA-Z0-9- ]/g,'')" value="<?php echo $user_list[0]['emp_id']; ?>">
                                    </div>

                                    <div class="form-group col-md-6 mt-2" >
                                        <h4><b>Level <span style="color:red">*</span></b></h4>
                                        <select name="user_level" id="user_level" class="form-control select2"  required >
                                            <option value="">Select level</option>
                                            <option <?php if($user_list[0]['role_type'] == "1"){echo "selected='selected'";} ?> value="1">Assets  Level(Tier-III)</option>
                                            <option <?php if($user_list[0]['role_type']==2){echo "selected='selected'";} ?> value="2">Area Level(Tier-II)</option>
                                            <option <?php if($user_list[0]['role_type']==3){echo "selected='selected'";} ?> value="3"> Installation Level(Tier-I)</option>
                                            <option <?php if($user_list[0]['role_type']==5){echo "selected='selected'";} ?> value="5"> Field Maintenance User</option>
                                            
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6 mt-2">
                                        <h4>Country <span style="color:red"></span></h4>
                                        <select name="country" id="country" class="form-control select2"  onchange="get_state_data(this.value);">
                                          <option value="">Select Country</option>
                                          <?php 
                                            if(!empty($country_list))
                                            {
                                                foreach ($country_list as $key => $value) 
                                                {
                                                    ?>
                                                        <option <?php if($value['id'] == $user_list[0]['country_code']){echo 'selected="selected"';} ?> value="<?php echo $value['id']; ?>"> <?php echo $value['name']; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                      </div>

                                      <div class="form-group col-md-6 mt-2">
                                        <h4>State <span style="color:red"></span></h4>
                                        <input type="hidden" name="state_hdn" id="state_hdn" value="<?php echo $user_list[0]['state_name']; ?>">
                                        <select name="state" id="state" class="form-control select2" >
                                          <option value="">Select state</option>
                                          
                                        </select>
                                      </div>

                                      <div class="col-md-6 mt-2">
                                        <h4><b>City <span style="color:red"></span></b></h4>
                                        <input type="text" name="city" id="city" class="form-control"  value="<?php echo $user_list[0]['city']; ?>" onkeyup="this.value = this.value.replace(/[^a-zA-Z- ]/g,'')">
                                    </div>

                                    <div class="col-md-6 mt-2">
                                        <h4><b>Address <span style="color:red"></span></b></h4>
                                        <textarea type="text" name="address" id="address" class="form-control"  onkeyup="this.value = this.value.replace(/[^a-zA-Z0-9-,.\/ ]/g,'')"><?php echo $user_list[0]['address']; ?></textarea>
                                    </div>
                                </div>
                                <h4><b>Access Functionality</b></h4>
                                <div class="row mt-3">
                                    <div class="form-group col-md-3 mt-2">
                                        <input type="checkbox" name="web_access" value="1" id="web_access" <?php if($user_list[0]['web_functionality'] == '1'){echo 'checked';}?> >
                                        <label style="font-size: 15px;"><b>Web Access</b></label>
                                    </div>

                                    <div class="form-group col-md-3 mt-2">
                                        <input type="checkbox" name="mobile_access" id="mobile_access" value="1" <?php if($user_list[0]['mobile_functionality'] == '1'){echo 'checked';}?> >
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

    
    get_state_data();
    function get_state_data()
    {
    let country_code = $('#country').val();
    var state = $('#state_hdn').val();
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
                var selected = "selected='selected'";
                $('#state').html('');
                $.each(response.data,function(i,v){
                    if(v.name == state){
                        // alert('hi');
                        $('#state').append('<option '+selected+' value="'+v.id+'">'+v.name+'</option>');
                    }else{
                        // alert('by');
                        $('#state').append('<option value="'+v.id+'">'+v.name+'</option>');
                    }
                });
            }
        }
    });
}
</script>	
