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
                                           <h4 class="header-title mb-4"><b>Edit Site</b></h4>
                                        </div>
                                        <div class="col-auto float-end ms-auto">
                                             <a href="<?php echo base_url('Site_c'); ?>">
                                               <button type="button" class="btn btn-sm btn-rounded btn-success">Back</button>
                                            </a>
                                        </div>
                                    </div>


                                   <form class="custom-validation" method="POST" action="<?php echo base_url('Site_c/update_site'); ?>" enctype="multipart/form-data">
                                <div class="row">
                                    <input type="hidden" id="id" name="id" value="<?php echo $this->uri->segment(3); ?>">
                                     <div class="form-group col-md-6">
                                         <h4><b>Assets Name <span style="color:red">*</span></b></h4>
                                        <select name="assets_id" id="assets_id" class="form-control select2" required onchange="get_area_list();">
                                          <?php 
                                            if(!empty($assets_list))
                                            {
                                                foreach ($assets_list as $key => $value) 
                                                {
                                                    ?>
                                                        <option <?php if($value['id'] == $site_list[0]['assets_id']){echo 'selected="selected"';} ?> value="<?php echo $value['id']; ?>"> <?php echo $value['assets_name']; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                        </div>

                                    <div class="form-group col-md-6 mt-2">
                                        <h4><b>Area Name <span style="color:red">*</span></b></h4>
                                        <input type="hidden" name="area_hdn" id="area_hdn" value="<?php echo $site_list[0]['area_name']; ?>">
                                        <select name="area_id" id="area_id" class="form-control select2" required>
                                      <option value="">Select Area</option>
                                      
                                        </select>
                                    </div>

                                    <div class="col-md-6 mt-2">
                                        <h4><b>Site Name <span style="color:red">*</span></b></h4>
                                        <input type="text" name="site_name" id="site_name" class="form-control" value="<?php echo $site_list[0]['well_site_name']; ?>" required onkeyup="this.value = this.value.replace(/[^a-zA-Z0-9- ]/g,'')">
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
        url: '<?php echo base_url(); ?>Site_c/get_area_list',
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
                        // alert('hi');
                        $('#area_id').append('<option '+selected+' value="'+v.id+'">'+v.area_name+'</option>');
                    }else{
                        // alert('by');
                        $('#area_id').append('<option value="'+v.id+'">'+v.area_name+'</option>');
                    }
                });
            }
        }
    });
}
</script>