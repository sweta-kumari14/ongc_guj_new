<div class="page-wrapper">
    <div class="content container-fluid pb-0">
    	<div class="page-header">
			<div class="content-page-header">
				<h5>Device Replacement</h5>
			</div>	
		</div>
			<div class="row">					
						<!-- Lightbox -->
                        <div class="col-lg-12">
                            <div class="card">
                               
                                <div class="card-body">
                                   <div class="row align-items-center">
                                        <div class="col">
                                           <h4 class="header-title mb-4"><b>Device Replacement</b></h4>
                                        </div>
                                        <div class="col-auto float-end ms-auto">
                                             <a href="<?php echo base_url('Dashboard_c'); ?>">
                                               <button type="button" class="btn btn-sm btn-rounded btn-success">Back</button>
                                            </a>
                                        </div>
                                    </div>


                                 <form class="custom-validation" method="POST" action="<?php echo base_url('Device_replacement_c/Device_replacement'); ?>" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="form-group col-md-4 mt-2" >
                                        <h4><b>Assets Name<span style="color:red">*</span></b></h4>
                                            <select name="assets_id" id="assets_id" class="form-control select2" onchange="get_area_list();" required>
                                            <option value="">Select Assets</option>
                                            <?php 
                                                foreach ($asset_name as $key => $value) 
                                                {
                                                    ?>
                                                        <option  value="<?php echo $value['assets_id']; ?>"><?php echo $value['assets_name']; ?></option>
                                                    <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group col-md-4 mt-2" >
                                        <h4><b>Area Name<span style="color:red">*</span></b></h4>
                                            <select name="area_id" id="area_id" class="form-control select2" onchange="get_site_list();" required>
                                            <option value="">Select Area</option>
                            
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4 mt-2" >
                                        <h4><b>Site Name<span style="color:red">*</span></b></h4>
                                            <select name="site_id" id="site_id" class="form-control select2" onchange="get_well_list();" required>
                                            <option value="">Select Site</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4 mt-2" >
                                        <h4><b>Well Name<span style="color:red">*</span></b></h4>
                                            <select name="well_id" id="well_id" class="form-control select2" onchange="get_well_data();get_device_list();" required>
                                            <option value="">Select Well</option>
                                        </select>
                                    </div>

                                    <input type="hidden" name="well_hdn" id="well_hdn" class="form-control">
                                    <input type="hidden" name="lat_hdn" id="lat_hdn" class="form-control">
                                    <input type="hidden" name="long_hdn" id="long_hdn" class="form-control">

                                    <div class="form-group col-md-4 mt-2" >
                                        <h4><b>Device Name<span style="color:red">*</span></b></h4>
                                        <select name="old_device_name" id="old_device_name" class="form-control select2"  required onchange="get_old_device_data();">
                                          <option value="">Select Device</option>
                                        </select>
                                        <input type="hidden" name="old_imei_no" id="old_imei_no" class="form-control">
                                    </div>
                                
                                    <div class="col-md-4 mt-2">
                                    
                                       <h4><b>Sim Provider<span style="color:red">*</span></b></h4>
                                       <input type="text" name="old_sim_name" id="old_sim_name" class="form-control" required readonly>
                                       <input type="hidden" name="old_sim_name_hdn" id="old_sim_name_hdn">  
                                    </div>
                                    <div class="col-md-4 mt-2">
                                    
                                        <h4><b>Sim Serial No<span style="color:red"></span></b></h4>
                                        <input type="number" name="old_sim_serial_no" id="old_sim_serial_no" class="form-control"  readonly>
                                    </div>

                                    <div class="col-md-4 mt-2">
                                    
                                         <h4><b>Network Type<span style="color:red">*</span></b></h4>
                                        <input type="text" name="old_network_type" id="old_network_type" class="form-control" required readonly>
                                        <input type="hidden" name="old_network_type_hdn"id="old_network_type_hdn" class="form-control">
                                    </div>
                                
                                    <div class="col-md-4 mt-2 form-group">
                                      
                                        <h4><b>Reason for Replacement<span style="color:red">*</span></b></h4>
                                        <select name="replacement_reason" id="replacement_reason" class="form-control select2" required onchange="get_replacement_field();">
                                            <option value="">Select Reason</option>
                                            <option value="1">Device Problem</option>
                                            <option value="2">Network Problem</option>
                                            <option value="3">Both Device and Network Problem</option>
                                        </select>
                                    </div> 

                                    <div class="col-md-4 mt-2 form-group" id="new_device_field" style="display:none;">
                                      
                                        <h4><b>New Device<span style="color:red">*</span></b></h4>
                                        <select name="new_device_name" id="new_device_name" class="form-control select2" style="width:100%">
                                            <option value="">Select New Device</option>
                                        </select>
                                    </div>                      

                                            
                                    <div class="col-md-4 mt-2 form-group" id="new_sim_field" style="display:none;">
                                      
                                         <h4><b>New Sim Provider<span style="color:red">*</span></b></h4>
                                        <select name="new_sim_name" id="new_sim_name" class="form-control select2" style="width:100%">
                                            <option value="">Select Sim</option>
                                            <!-- <option value="1">Vi</option> -->
                                            <option value="2">Airtel</option>
                                            <option value="3">JIO</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4 mt-2 form-group" id="new_serial_no_field" style="display:none;">
                                     
                                        <h4><b>New Serial No<span style="color:red"></span></b></h4>
                                        <input type="number" name="sim_new_serial_no" id="sim_new_serial_no" class="form-control" style="width:100%" maxlength="10" min="10">
                                    </div>

                                    <div class="col-md-4 mt-2 form-group" id="new_network_field" style="display:none;">
                                      
                                        <h4><b>Network Type<span style="color:red">*</span></b></h4>
                                        <select name="new_network_type" id="new_network_type" class="form-control select2" style="width:100%">
                                            <option value="">Select Network</option>
                                           
                                            <option value="3">4G</option>
                                        </select>
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
    
    function get_replacement_field()
    {
        let reason = $('#replacement_reason').val();
        // alert(reason);

        if (reason == 1)
        {
            $('#new_device_field').show();
            $('#new_sim_field').hide();
            $('#new_serial_no_field').hide();
            $('#new_network_field').hide();

            $('#new_device_name').attr('required',true);

            $('#new_sim_name').attr('required',false);
           
            $('#new_network_type').attr('required',false);

        }else if(reason == 2)
        {
            $('#new_device_field').hide();
            $('#new_sim_field').show();
            $('#new_serial_no_field').show();
            $('#new_network_field').show();

            $('#new_device_name').attr('required',false);
            $('#new_sim_name').attr('required',true);
           
            $('#new_network_type').attr('required',true);
        }else if(reason == 3)
        {
            $('#new_device_field').show();
            $('#new_sim_field').show();
            $('#new_serial_no_field').show();
            $('#new_network_field').show();

            $('#new_device_name').attr('required',true);
            $('#new_sim_name').attr('required',true);
            // $('#sim_new_serial_no').attr('required',true);
            $('#new_network_type').attr('required',true);
        }else{
            $('#new_device_field').hide();
            $('#new_sim_field').hide();
            $('#new_serial_no_field').hide();
            $('#new_network_field').hide();

            $('#new_device_name').attr('required',false);
            $('#new_sim_name').attr('required',false);
            // $('#sim_new_serial_no').attr('required',false);
            $('#new_network_type').attr('required',false);
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
            url: '<?php echo base_url();?>Device_replacement_c/get_area_list_for_replacement',
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
            url: '<?php echo base_url();?>Device_replacement_c/get_site_list_for_replacement',
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

    function get_well_list()
    { 
       let company_id = "<?php echo $this->session->userdata('company_id') ?>";
       let user_id = "<?php echo $this->session->userdata('user_id') ?>";
       let assets_id = $('#assets_id').val(); 
       let area_id = $('#area_id').val();
        let site_id = $('#site_id').val();
       
       $.ajax({
            type: 'POST',
            url: '<?php echo base_url();?>Device_replacement_c/get_well_list_for_replacement',
            data:{company_id,company_id,user_id:user_id,assets_id:assets_id,area_id:area_id,site_id:site_id},
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


    function get_device_list()
    { 
       let company_id = "<?php echo $this->session->userdata('company_id') ?>";
       let user_id = "<?php echo $this->session->userdata('user_id') ?>";
       let assets_id = $('#assets_id').val(); 
       let area_id = $('#area_id').val();
       let site_id = $('#site_id').val();
       let well_id = $('#well_hdn').val();
       // alert(well_id);

       
       $.ajax({
            type: 'POST',
            url: '<?php echo base_url();?>Device_replacement_c/get_device_list_for_replacement',
            data:{company_id:company_id,user_id:user_id,assets_id:assets_id,area_id:area_id,site_id:site_id,well_id:well_id},
            success:function(data)
            {
                data = JSON.parse(data);
                console.log(data);
                if(data.response_code==200)
                {   
                    if(data.data.length>0)
                    {
                        $('#old_device_name').html('');
                        $('#old_device_name').html('<option value=" ">Select device</option>');
                        $.each(data.data,function(i,v){
                        $('#old_device_name').append('<option value="' + v.imei_no +'|'+v.sim_no+'|'+v.network_type+'|'+v.sim_provider+'">'+v.device_name+'</option>');
                           
                            
                        });
                        
                    }else
                    {
                        $('#old_device_name').html('No Data Found');
                    }
                }else
                {
                    swal('error',data.msg,'error');
                }
              console.log();
            }
    
          });
    }
     get_new_device_list();
     function get_new_device_list()
    { 
       let company_id = "<?php echo $this->session->userdata('company_id') ?>";
       let user_id = "<?php echo $this->session->userdata('user_id') ?>";
       
       $.ajax({
            type: 'POST',
            url: '<?php echo base_url();?>Device_replacement_c/get_new_device_data',
            data:{company_id:company_id,user_id:user_id},
            success:function(data)
            {
                data = JSON.parse(data);
                console.log(data);
                if(data.response_code==200)
                {   
                    if(data.data.length>0)
                    {
                        $('#new_device_name').html('');
                        $('#new_device_name').html('<option value=" ">Select device</option>');
                        $.each(data.data,function(i,v){
                        $('#new_device_name').append('<option value="' + v.imei_no +'">'+v.device_name+'</option>');
                           
                            
                        });
                        
                    }else
                    {
                        $('#new_device_name').html('No Data Found');
                    }
                }else
                {
                    swal('error',data.msg,'error');
                }
              console.log();
            }
    
          });
    }

    function get_old_device_data()
   {
        var old_device_data = $('#old_device_name').val();
        // console.log(old_device_data);
        $('#old_imei_no').val(old_device_data.split("|")[0]);
        $('#old_sim_serial_no').val(old_device_data.split("|")[1]);
        $('#old_network_type_hdn').val(old_device_data.split("|")[2]);
        var network_type = old_device_data.split("|")[2];
        if (network_type == '1') {
            $('#old_network_type').val('2G');
        } else if (network_type == '2') {
            $('#old_network_type').val('3G');
        } else if (network_type == '3') {
            $('#old_network_type').val('4G');
        } else {
            $('#old_network_type').val('');
        }
        $('#old_sim_name_hdn').val(old_device_data.split("|")[3]);
        var sim_name = old_device_data.split("|")[3];
        if (sim_name == '1') {
            $('#old_sim_name').val('Vi');
        } else if (sim_name == '2') {
            $('#old_sim_name').val('Airtel');
        }else if (sim_name == '3') {
            $('#old_sim_name').val('JIO');
        }  
         else {
            $('#old_sim_name').val('');
        }
   }

  
   </script>
   <script type="text/javascript">
       function get_well_data()
       {
        var well_id = $('#well_id').val();
        $('#well_hdn').val(well_id.split("|")[0]);
        $('#lat_hdn').val(well_id.split("|")[1]);
        $('#long_hdn').val(well_id.split("|")[2]);
    }
   </script>


  