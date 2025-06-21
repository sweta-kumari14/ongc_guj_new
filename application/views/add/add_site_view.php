<div class="page-wrapper">
    <div class="content container-fluid pb-0">
    	<div class="page-header">
			<div class="content-page-header">
				<h5>Site</h5>
			</div>	
		</div>
			<div class="row">					
						<!-- Lightbox -->
                        <div class="col-lg-12">
                            <div class="card">
                               
                                <div class="card-body">
                                   <div class="row align-items-center">
                                        <div class="col">
                                           <h4 class="header-title mb-4"><b>Add Site</b></h4>
                                        </div>
                                        <div class="col-auto float-end ms-auto">
                                             <a href="<?php echo base_url('Site_c'); ?>">
                                               <button type="button" class="btn btn-sm btn-rounded btn-success">Back</button>
                                            </a>
                                        </div>
                                    </div>


                                    <form class="custom-validation" method="POST" action="<?php echo base_url('Site_c/add_site'); ?>" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="form-group col-md-6 mt-2">
                                        <h4><b>Assets</b><span style="color:red;">*</span></h4>
                                        <select name="assets_id" id="assets_id" class="form-control select2" required onchange="get_area_list();">
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
                                        <select name="area_id" id="area_id" class="form-control select2" required>
                                            <option value="">Select Area</option>
                                            
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6 mt-2">
                                        <h4><b>Site Name</b><span style="color:red;">*</span></h4>
                                        <input type="text" name="site_name" id="site_name" class="form-control" required onkeyup="this.value = this.value.replace(/[^a-zA-Z0-9- ]/g,'')">
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

 
    function get_area_list()
    {

        let assets_id = $('#assets_id').val();
 
         $.ajax({
            url: '<?php echo base_url(); ?>Site_c/get_area_list',
            type: 'POST',
            data: {assets_id: assets_id},
            success:function(res)
            {
                response = JSON.parse(res);
                console.log(response);
                if(response.data.length>0)
                {
                    $('#area_id').html('');
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
</script>