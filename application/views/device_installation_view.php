<div class="page-wrapper">
    <div class="content container-fluid pb-0">
    	<div class="page-header">
			<div class="content-page-header">
				<h5>Device Installation</h5>
			</div>	
		</div>
			<div class="row">					
						<!-- Lightbox -->
                        <div class="col-lg-12">
                            <div class="card">
                               
                                <div class="card-body">
                                   <div class="row align-items-center">
                                        <div class="col">
                                           <h4 class="header-title mb-4"><b>Device Installation</b></h4>
                                        </div>
                                        <div class="col-auto float-end ms-auto">
                                             <a href="<?php echo base_url('Dashboard_c'); ?>">
                                               <button type="button" class="btn btn-sm btn-rounded btn-success">Back</button>
                                            </a>
                                        </div>
                                    </div>


                                   <form class="custom-validation" method="POST" action="<?php echo base_url('Device_installation_c/Device_install'); ?>" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="form-group col-md-4 mt-2" >
                                        <h4><b>Assets Name<span style="color:red">*</span></b></h4>
                                            <select name="assets_id" id="assets_id" class="form-control select2" onchange="get_area_list();" required>
                                            <option value="">Select Assets</option>
                                            <?php 
                                            if (!empty($assets_list))
                                            {
                                                foreach ($assets_list as $key => $value)
                                                {
                                                    ?>
                                                        <option value="<?php echo $value['assets_id']; ?>"><?php echo $value['assets_name']; ?></option>

                                                    <?php
                                                }
                                            }
                                            ?>
                                            </select>
                                    </div>
                                    <div class="form-group col-md-4 mt-2" >
                                        <h4><b>Area Name<span style="color:red">*</span></b></h4>
                                            <select name="area_id" id="area_id" class="form-control select2" onchange="get_site_list();get_feeder_list();get_feeder_data();" required>
                                            <option value="">Select Area</option>
                            
                                        </select>
                                    </div>
                                   

                                    <div class="form-group col-md-4 mt-2" >
                                        <h4><b>Site Name<span style="color:red">*</span></b></h4>
                                            <select name="site_id" id="site_id" class="form-control select2" onchange="get_well_list();" required>
                                            <option value="">Select Site</option>
                                        </select>
                                    </div>

                                     <div class="form-group col-md-4 mt-2" style="display:none;" id="feeder_dropdown">
                                       <h4><b>Feeder<span style="color:red">*</span></b></h4>
                                         <select name="feeder_id" id="feeder_id" class="form-control select2">
                                         <option value="">Select Feeder</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4 mt-2" >
                                        <h4><b>Well Name<span style="color:red">*</span></b></h4>
                                            <select name="well_id" id="well_id" class="form-control select2" required onchange="get_device_data();">
                                            <option value="">Select Well</option>
                                        </select>
                                    </div>
                                  
                                    <input type="hidden" name="well_hdn" id="well_hdn" class="form-control">
                                    <input type="hidden" name="lat_hdn" id="lat_hdn" class="form-control">
                                    <input type="hidden" name="long_hdn" id="long_hdn" class="form-control">
                                    
                                    <div class="form-group col-md-4 mt-2" >
                                        <h4><b>Device Name<span style="color:red">*</span></b></h4>
                                            <select name="device_name" id="device_name" class="form-control select2" onchange="get_device_data();" required>
                                            <option value="">Select Device</option>
                                            <?php 
                                            if (!empty($device_list))
                                            {
                                                foreach ($device_list as $key => $value)
                                                {
                                                    ?>
                                                        <option value="<?php echo $value['device_name'].'|'.$value['imei_no']; ?>"><?php echo $value['device_name']; ?></option>

                                                    <?php
                                                }
                                            }
                                            ?>
                                            </select>
                                    </div>

                                    <input type="hidden" name="device_name_hdn" id="device_name_hdn" class="form-control">
                                    <input type="hidden" name="imei_no_hdn" id="imei_no_hdn" class="form-control">
                                                            
                                    <div class="form-group col-md-4 mt-2" >
                                        <h4><b>Sim Provider<span style="color:red">*</span></b></h4>
                                        <select name="sim_provider" id="sim_provider" class="form-control select2" required>
                                            <option value="">Select Sim</option>
                                            <option value="2" selected>Airtel</option>
                                            <option value="3">JIO</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4 mt-2" >
                                        <h4><b>Sim Serial No</b></h4>
                                        <input type="number" name="sim_no" id="sim_no" class="form-control" maxlength="10" minlength="10">
                                    </div>

                                    <div class="form-group col-md-4 mt-2" >
                                        <h4><b>Network Type<span style="color:red">*</span></b></h4>
                                        <select name="network_types" id="network_types" class="form-control select2" required disabled>
                                            <option value="">Select Network</option>
                                            <!-- <option value="1">2G</option>
                                            <option value="2">3G</option> -->
                                            <option value="3" selected>4G</option>
                                        </select>
										<input type="hidden" value="3" name="network_type" id="network_type" >
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
     get_feeder_data();
    function get_feeder_data() 
   { 
        let area_id = $('#area_id').val();
        if (area_id  == "52dbde99-b394-11ee-a6d4-5cb901ad9cf0") 
        {
            $('#feeder_dropdown').show();  
        } else {
            $('#feeder_dropdown').hide();
           
        }
    }
</script>

<script type="text/javascript">
function get_area_list()
    {  
       let company_id = "<?php echo $this->session->userdata('company_id') ?>";
       let user_id = "<?php echo $this->session->userdata('user_id') ?>";
       let assets_id = $('#assets_id').val();
       
       $.ajax({
            type: 'POST',
            url: '<?php echo base_url();?>Device_installation_c/get_area_list',
            data:{company_id:company_id,user_id:user_id,assets_id:assets_id},
            success:function(data)
            {
                data = JSON.parse(data);
                console.log(data);
                if(data.response_code==200)
                {   
                    if(data.data.length>0)
                    {
                        $('#area_id').html('');
                        $('#area_id').html('<option value=" ">Select area</option>');
                        $.each(data.data,function(i,v){
  
                        $('#area_id').append('<option value="'+v.area_id+'">'+v.area_name+'</option>');
                           
                            
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
       let company_id = "<?php echo $this->session->userdata('company_id') ?>";
       let user_id = "<?php echo $this->session->userdata('user_id') ?>";
       let assets_id = $('#assets_id').val(); 
       let area_id = $('#area_id').val();
       
       $.ajax({
            type: 'POST',
            url: '<?php echo base_url();?>Device_installation_c/getsite_list',
            data:{company_id:company_id,user_id:user_id,assets_id:assets_id,area_id:area_id},
            success:function(data)
            {
                data = JSON.parse(data);
                console.log(data);
                if(data.response_code==200)
                {   
                    if(data.data.length>0)
                    {
                        $('#site_id').html('');
                        $('#site_id').html('<option value=" ">Select site</option>');
                        $.each(data.data,function(i,v){
  
                        $('#site_id').append('<option value="'+v.site_id+'">'+v.well_site_name+'</option>');
                           
                            
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

get_feeder_list();
function get_feeder_list() { 
    
    let area_id = $('#area_id').val();
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url();?>Dashboard_c/feeder_list',
        data: { area_id:area_id },
        success: function(data) {
            data = JSON.parse(data);
           
            if (data.response_code == 200) {   
                if (data.data.length > 0) {
                    $('#feeder_id').html('');
                    $('#feeder_id').html('<option value="">Select Feeder</option>');
                    $.each(data.data, function(i, v) {
                     
                        $('#feeder_id').append('<option value="' + v.id + '">' + v.feeder_name + '</option>');
                    });
                } else {
                    $('#feeder_id').html('<option value="">No Feeder Found</option>');
                }
            } else {
                swal('error', data.msg, 'error');
            }   
        }
    });
}

    function get_well_list()
    { 
        let company_id = "<?php echo $this->session->userdata('company_id') ?>";
       let user_id = "<?php echo $this->session->userdata('user_id') ?>";
       let assets_id = $('#assets_id').val(); 
       let area_id = $('#area_id').val();
       let site_id = $('#site_id').val();
      
       $.ajax({
            type: 'POST',
            url: '<?php echo base_url();?>Device_installation_c/getWell_forinstallation_list',
            data:{company_id:company_id,user_id:user_id,assets_id:assets_id,area_id:area_id,site_id:site_id},
            success:function(data)
            {
                data = JSON.parse(data);
                console.log(data);
                if(data.response_code==200)
                {   
                    if(data.data.length>0)
                    {
                        $('#well_id').html('');
                        $('#well_id').html('<option value=" ">Select well</option>');
                        $.each(data.data,function(i,v){
  
                         $('#well_id').append('<option value="'+ v.well_id +'|'+v.lat+'|'+v.long+'">'+v.well_name+'</option>');
                           
                            
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



    function get_device_data()
    {
        var device_data = $('#device_name').val();
        $('#device_name_hdn').val(device_data.split("|")[0]);
        $('#imei_no_hdn').val(device_data.split("|")[1]);

        var well_id = $('#well_id').val();
        $('#well_hdn').val(well_id.split("|")[0]);
        $('#lat_hdn').val(well_id.split("|")[1]);
        $('#long_hdn').val(well_id.split("|")[2]);
    }


   </script>
