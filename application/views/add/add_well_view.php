<div class="page-wrapper">
    <div class="content container-fluid pb-0">
    	<div class="page-header">
			<div class="content-page-header">
				<h5>Well</h5>
			</div>	
		</div>
			<div class="row">					
						<!-- Lightbox -->
                        <div class="col-lg-12">
                            <div class="card">
                               
                                <div class="card-body">
                                   <div class="row align-items-center">
                                        <div class="col">
                                           <h4 class="header-title mb-4"><b>Add Well</b></h4>
                                        </div>
                                        <div class="col-auto float-end ms-auto">
                                             <a href="<?php echo base_url('Well_c'); ?>">
                                               <button type="button" class="btn btn-sm btn-rounded btn-success">Back</button>
                                            </a>
                                        </div>
                                    </div>


                                    <form class="custom-validation" method="POST" action="<?php echo base_url('Well_c/add_well'); ?>" enctype="multipart/form-data">
                                <div class="row">
                                   <div class="form-group col-md-6 mt-2">
                                        <h4><b>Assets</b><span style="color:red;">*</span></h4>
                                        <select name="assets_id" id="assets_id" class="form-control select2" required onchange="get_area_list();get_site_list();">
                                            <option value="">Select</option>
                                            <?php 
                                            if(!empty($assets_list))
                                            {
                                                foreach ($assets_list as $key => $value) 
                                                {
                                                    ?>
                                                        <option value="<?php echo $value['id']; ?>"> <?php echo $value['assets_name']; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6 mt-2">
                                        <h4><b>Area</b><span style="color:red;">*</span></h4>
                                        <select name="area_id" id="area_id" class="form-control select2" required onchange="get_site_list();">
                                            <option value="">Select Area</option>
                                            
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6 mt-2">
                                        <h4><b>Site</b><span style="color:red;">*</span></h4>
                                        <select name="site_id" id="site_id" class="form-control select2" required>
                                            <option value="">Select Site</option>
                                            
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6 mt-2">
                                    <h4><b>Well Type</b><span style="color:red;">*</span></h4>
                                    <select name="well_type" id="well_type" class="form-control select2" required>
                                        <option value="">Select</option>
                                        <?php 
                                        if(!empty($well_type))
                                        {
                                            foreach ($well_type as $key => $value) 
                                            {
                                                ?>
                                                    <option value="<?php echo $value['id']; ?>"> <?php echo $value['well_type_name']; ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                    <div class="form-group col-md-6 mt-2">
                                        <h4><b>Well Name</b><span style="color:red;">*</span></h4>
                                        <input type="text" name="well_name" id="well_name" class="form-control" required  onkeyup="this.value = this.value.replace(/[^a-zA-Z0-9-# ]/g,'')" >
                                    </div>

                                    

                                    <div class="form-group col-md-6  mt-2">
                                        <h4><b>Latitude</b><span style="color:red;"></span></h4>
                                        <input data-parsley-type="number" data-parsley-pattern="^[-+]?[0-9]*\.?[0-9]+([eE][-+]?[0-9]+)?$" name="latitude" id="latitude" class="form-control" onkeyup="this.value = this.value.replace(/[^0-9.]/g,'')">
                                    </div>

                                    <div class="form-group col-md-6 mt-2">
                                        <h4><b>Longitude</b><span style="color:red;"></span></h4>
                                        <input data-parsley-type="number" data-parsley-pattern="^[-+]?[0-9]*\.?[0-9]+([eE][-+]?[0-9]+)?$" name="longitude" id="longitude" class="form-control" onkeyup="this.value = this.value.replace(/[^0-9.]/g,'')">
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
            url: '<?php echo base_url(); ?>Well_c/get_state_list',
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
                }else{
                      $('#state').html('No Data Found');
                }
            }
        });
    }

   
    function get_area_list()
    {

        let assets_id = $('#assets_id').val();
        // alert(assets_id);
         $.ajax({
            url: '<?php echo base_url(); ?>Well_c/get_area_list',
            type: 'POST',
            data: {assets_id: assets_id},
            success:function(res)
            {
                response = JSON.parse(res);
                console.log(response);
                if(response.data.length>0)
                {
                    $('#area_id').html('<option value="">Select Area</option>');
                    $.each(response.data,function(i,v){
                        $('#area_id').append('<option value="'+v.id+'">'+v.area_name+'</option>');
                    });
                }else{
                      $('#area_id').html('No Data Found');
                }
            }
        });
    }

    
    function get_site_list()
    {

        let assets_id = $('#assets_id').val();
        let area_id = $('#area_id').val();
        let company_id = '<?php echo $this->session->userdata('company_id') ?>';
        // alert(assets_id);
         $.ajax({
            url: '<?php echo base_url(); ?>Well_c/get_site_list',
            type: 'POST',
            data: {assets_id: assets_id,area_id:area_id,company_id:company_id},
            success:function(res)
            {
                response = JSON.parse(res);
                console.log(response);
                if(response.data.length>0)
                {
                    $('#site_id').html('<option value="">Select Site</option>');
                    $.each(response.data,function(i,v){
                        $('#site_id').append('<option value="'+v.id+'">'+v.well_site_name+'</option>');
                    });
                }else{
                      $('#site_id').html('No Data Found');
                }
            }
        });
    }
</script>

