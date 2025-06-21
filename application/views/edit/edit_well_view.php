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
                                           <h4 class="header-title mb-4"><b>Edit Well</b></h4>
                                        </div>
                                        <div class="col-auto float-end ms-auto">
                                             <a href="<?php echo base_url('Well_c'); ?>">
                                               <button type="button" class="btn btn-sm btn-rounded btn-success">Back</button>
                                            </a>
                                        </div>
                                    </div>


                                   <form class="custom-validation" method="POST" action="<?php echo base_url('Well_c/update_well'); ?>" enctype="multipart/form-data">
                                <div class="row">
                                    <input type="hidden" id="id" name="id" value="<?php echo $this->uri->segment(3); ?>">
                                     <div class="form-group col-md-6 mt-2">
                                        <h4><b>Assets Name <span style="color:red">*</span></b></h4>
                                        <select name="assets_id" id="assets_id" class="form-control select2" required onchange="get_area_list();">
                                          <?php 
                                            if(!empty($assets_list))
                                            {
                                                foreach ($assets_list as $key => $value) 
                                                {
                                                    ?>
                                                        <option <?php if($value['id'] == $well_list[0]['assets_id']){echo 'selected="selected"';} ?> value="<?php echo $value['id']; ?>"> <?php echo $value['assets_name']; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    

                                    <div class="form-group col-md-6 mt-2">
                                        <h4><b>Area Name <span style="color:red">*</span></b></h4>
                                        <input type="hidden" name="area_hdn" id="area_hdn" value="<?php echo $well_list[0]['area_name']; ?>">
                                        <select name="area_id" id="area_id" class="form-control select2" required onchange="get_site_list();">
                                      <option value="">Select Area</option>
                                      
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6 mt-2">
                                        <h4><b>Site Name <span style="color:red">*</span></b></h4>
                                        <input type="hidden" name="site_hdn" id="site_hdn" value="<?php echo $well_list[0]['well_site_name']; ?>">
                                        <select name="site_id" id="site_id" class="form-control select2" required >
                                      <option value="">Select Site</option>
                                      
                                        </select>
                                    </div>
                                     <div class="form-group col-md-6 mt-2">
                                    <h4><b>Well Type</b><span style="color:red;">*</span></h4>
                                   <select name="well_type" id="well_type" class="form-control select2" required>
    <option value="">Select</option>
    <?php 
    if (!empty($well_type)) {
        foreach ($well_type as $type) {
            $selected = ($type['id'] == $well_list[0]['well_type_id']) ? 'selected' : '';
            echo '<option value="' . $type['id'] . '" ' . $selected . '>' . $type['well_type_name'] . '</option>';
        }
    }
    ?>
</select>

                                </div>
                                    <div class="form-group col-md-6 mt-2">
                                        <h4><b>Well Name</b><span style="color:red;">*</span></h4>
                                        <input type="text" name="well_name" id="well_name" class="form-control" required  onkeyup="this.value = this.value.replace(/[^a-zA-Z0-9-# ]/g,'')" value="<?php echo $well_list[0]['well_name']; ?>">
                                    </div>

                                    <div class="form-group col-md-6 mt-2">
                                        <h4><b>Latitude</b><span style="color:red;"></span></h4>
                                        <input data-parsley-type="number" data-parsley-pattern="^[-+]?[0-9]*\.?[0-9]+([eE][-+]?[0-9]+)?$" name="latitude" id="latitude" class="form-control"  value="<?php echo $well_list[0]['lat']; ?>" onkeyup="this.value = this.value.replace(/[^0-9.]/g,'')">
                                    </div>

                                    <div class="form-group col-md-6 mt-2">
                                        <h4><b>Longitude</b><span style="color:red;"></span></h4>
                                        <input data-parsley-type="number" data-parsley-pattern="^[-+]?[0-9]*\.?[0-9]+([eE][-+]?[0-9]+)?$" name="longitude" id="longitude" class="form-control"  value="<?php echo $well_list[0]['long']; ?>" onkeyup="this.value = this.value.replace(/[^0-9.]/g,'')">
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

    get_area_list();
    function get_area_list()
    {
    let assets_id = $('#assets_id').val();
    var area = $('#area_hdn').val();
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
                var selected = "selected='selected'";
                $('#area_id').html('');
                $.each(response.data,function(i,v){
                    if(v.area_name == area){
                    
                        $('#area_id').append('<option '+selected+' value="'+v.id+'">'+v.area_name+'</option>');
                    }else{
                      
                        $('#area_id').append('<option value="'+v.id+'">'+v.area_name+'</option>');
                    }
                    get_site_list();
                });
            }
        }
    });
    }


     get_site_list();
    function get_site_list()
    {
        let assets_id = $('#assets_id').val();
        let area_id = $('#area_id').val();
        let site = $('#site_hdn').val();
        
    $.ajax({
        url: '<?php echo base_url(); ?>Well_c/get_site_list',
        type: 'POST',
        data: {assets_id: assets_id,area_id:area_id},
        success:function(res)
        {
            response = JSON.parse(res);
            console.log(response);
            if(response.data.length>0)
            {
                var selected = "selected='selected'";
                $('#site_id').html('');
                $.each(response.data,function(i,v){
                    if(v.well_site_name == site){
                       
                        $('#site_id').append('<option '+selected+' value="'+v.id+'">'+v.well_site_name+'</option>');
                    }else{
                      
                        $('#site_id').append('<option value="'+v.id+'">'+v.well_site_name+'</option>');
                    }
                });
            }
        }
    });
    }

   
</script>