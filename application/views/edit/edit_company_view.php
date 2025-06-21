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
                                           <h4 class="header-title mb-4"><b>Edit Company</b></h4>
                                        </div>
                                        <div class="col-auto float-end ms-auto">
                                             <a href="<?php echo base_url('Company_c'); ?>">
                                               <button type="button" class="btn btn-sm btn-rounded btn-success">Back</button>
                                            </a>
                                        </div>
                                    </div>


                                   <form class="custom-validation" method="POST" action="<?php echo base_url('Company_c/update_company'); ?>" enctype="multipart/form-data">
                                <div class="row">
                                    <input type="hidden" id="id" name="id" value="<?php echo htmlspecialchars($this->uri->segment(3)); ?>">
                                    <div class="col-md-6 mt-2">
                                        <h4><b>Company Name <span style="color:red">*</span></b></h4>
                                        <input type="text" name="company_name" id="company_name" class="form-control" value="<?php echo htmlspecialchars($company_list[0]['company_name']); ?>" required onkeyup="this.value = this.value.replace(/[^a-zA-Z- ]/g,'')">
                                    </div>

                                    <div class="col-md-6 mt-2">
                                        <h4><b>Mobile No <span style="color:red">*</span></b></h4>
                                        <input type="number" name="mobile_no" id="mobile_no" class="form-control" maxlength="10" minlength="10" required value="<?php echo htmlspecialchars($company_list[0]['contact_no']); ?>">
                                    </div>

                                    <div class="col-md-6 mt-2">
                                        <h4><b>Email Id <span style="color:red">*</span></b></h4>
                                        <input type="email" name="email_id" id="email_id" class="form-control" required value="<?php echo htmlspecialchars($company_list[0]['email_id']); ?>">
                                    </div>

                                    <div class="form-group col-md-6 mt-2">
                                        <h4>Country <span style="color:red">*</span></h4>
                                        <select name="country" id="country" class="form-control select2" required onchange="get_state_data(this.value);">
                                          <option value="">Select Country</option>
                                          <?php 
                                            if(!empty($country_list))
                                            {
                                                foreach ($country_list as $key => $value) 
                                                {
                                                    ?>
                                                        <option <?php if($value['id'] == $company_list[0]['country_code']){echo 'selected="selected"';} ?> value="<?php echo $value['id']; ?>"> <?php echo $value['name']; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                      </div>

                                      <div class="form-group col-md-6 mt-2">
                                        <h4>State <span style="color:red">*</span></h4>
                                        <input type="hidden" name="state_hdn" id="state_hdn" value="<?php echo htmlspecialchars($company_list[0]['state_name']); ?>">
                                        <select name="state" id="state" class="form-control select2" required>
                                          <option value="">Select state</option>
                                          
                                        </select>
                                      </div>

                                      <div class="col-md-6 mt-2">
                                        <h4><b>City <span style="color:red">*</span></b></h4>
                                        <input type="text" name="city" id="city" class="form-control" required value="<?php echo htmlspecialchars($company_list[0]['city']); ?>" onkeyup="this.value = this.value.replace(/[^a-zA-Z- ]/g,'')">
                                    </div>

                                    <div class="form-group col-md-6 mt-2">
                                        <h4><b>Logo <span style="color:red">*</span></b></h4>
                                        <input type="file" onchange="document.getElementById('blahh').src = window.URL.createObjectURL(this.files[0])" name="logo" id="logo" class="form-control" value="<?php echo $company_list[0]['logo']; ?>" accept=".jpg,.png,.jpeg">
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <p><strong>Preview Image</strong></p>
                                            <img id="blahh"  width="100" height="100" class="mt-2"/>
                                    </div>

                                    <div class="col-md-3 mb-3">
                                            <p><strong>Previous Image</strong></p>
                                            <img src="<?php echo htmlspecialchars($company_list[0]['logo']); ?>"  width="100" height="100" class="mt-2"  />
                                    </div>

                                    <div class="col-md-6 mt-2">
                                        <h4><b>Address <span style="color:red">*</span></b></h4>
                                        <textarea type="text" name="address" id="address" class="form-control" required onkeyup="this.value = this.value.replace(/[^a-zA-Z0-9-,.\/ ]/g,'')"><?php echo htmlspecialchars($company_list[0]['address']); ?></textarea>
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
<script type="text/javascript">

    
    get_state_data();
    function get_state_data()
    {
    let country_code = $('#country').val();
    var state = $('#state_hdn').val();
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