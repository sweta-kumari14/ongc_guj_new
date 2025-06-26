<div class="page-wrapper">
    <div class="content container-fluid pb-0">
    	<div class="page-header">
			<div class="content-page-header">
				<h5>User Allotment</h5>
			</div>	
		</div>
		<div class="row">					
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                       <div class="row align-items-center">
                            <div class="col">
                               <h4 class="header-title mb-4"><b>User Allotment</b></h4>
                            </div>
                        </div>
                        <form class="custom-validation" method="POST" action="<?php echo base_url('Site_allotment_to_user_c/allot_site'); ?>" enctype="multipart/form-data">
                        <div class="row">
                        <div class="form-group col-md-3 mt-2" >
                            <h4><b>User Type</b></h4>
                            <select name="role_type" id="role_type" class="form-control select2"  required onchange="get_role_type();get_user_list_for_allotment();">
                                <option value=" ">Select User Type</option>
                                <option value="1">Asset level</option>
                                <option value="2">Area Level</option>
                                <option value="3">Installation Level</option>
                                <option value="5"> Field Maintenance User</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3 mt-2" id="asset_field" style="display:none;">
                        <h4><b>Assets List</b></h4>
                        <select name="assets_id" id="assets_id" class="form-control select2" onchange="get_area_list();get_area_list_for_allotment();get_site_list_for_allotment();">
                            <option value="">Select Assets</option>
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
                        <div class="form-group col-md-3 mt-2" id="area_field" style="display:none;">
                        <h4><b>Area List</b></h4>
                        <select name="area_id" id="area_id" class="form-control select2" onchange="get_site_list_for_allotment();">
                            <option value="">Select Area</option>
                            
                        </select>
                        </div>
                        <div class="form-group col-md-3 mt-2" >
                            <h4><b>User Name</b></h4>
                            <select name="user_id" id="user_id" class="form-control select2" onchange="get_asset_list_for_allotment();get_area_list_for_allotment();get_site_list_for_allotment();">
                                <option value="">Select User</option>

                            </select>
                        </div>
                        </div>  
                        <div class="row mt-3 mx-2" id="asset_listing_field" style="display: none;">
                            <div  style="max-height:500px;overflow-y: scroll;" class="user-class mt-3">
                                <div>
                                    <h3><b>Assets List</b></h3>
                                </div>
                                <div class="row mt-2" id="asset_list_to_allot">
                                    
                                </div>
                            </div    >  
                        </div>
                        <!-- ===========  Area Listing =================== -->
                        <div class="row mt-3 mx-2" id="area_listing_field" style="display: none;">
                            <div  style="max-height:500px;overflow-y: scroll;" class="user-class mt-3">
                                <div><h3><b>Area List</b></h3></div>
                                <div class="row mt-2" id="area_list_to_allot"></div>
                            </div>  
                        </div>
                        <div class="row mt-3 mx-2" id="site_listing_field" style="display: none;">
                            <div>
                                <div><h3><b>Site List</b></h3>
                            </div>
                            <div class="row mt-2" id="site_list_to_allot"></div>
                            </div>  
                        </div>
                         <div class="footer mt-4">
                             <div><button type="submit" class="btn btn-sm btn-primary" >Submit</button></div>
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
    function get_role_type()
    {
        let role_type = $('#role_type').val();
        // alert(role_type);

        if (role_type == 1 || role_type == 5)
        {
            $('#asset_field').hide();
            $('#area_field').hide();

            $('#asset_listing_field').show();
            $('#area_listing_field').hide();
            $('#site_listing_field').hide();

            get_asset_list_for_allotment();
        }else if(role_type == 2){
            $('#asset_field').show();
            $('#area_field').hide();

            $('#asset_listing_field').hide();
            $('#area_listing_field').show();
            $('#site_listing_field').hide();

            // get_area_list_for_allotment();
        }else if(role_type == 3)
        {
            $('#asset_field').show();
            $('#area_field').show();

            $('#asset_listing_field').hide();
            $('#area_listing_field').hide();
            $('#site_listing_field').show();

            // get_site_list_for_allotment();
        }
        else{
            $('#asset_field').hide();
            $('#area_field').hide();

            $('#asset_listing_field').hide();
            $('#area_listing_field').hide();
            $('#site_listing_field').hide();
        }
    }

    // ================ user listing for dropdown ============================
    function get_user_list_for_allotment()
    {  
       let role_type = $('#role_type').val();
       let company_id = '<?php echo $this->session->userdata('company_id') ?>';
       $.ajax({
            type: 'POST',
            url: '<?php echo base_url();?>Site_allotment_to_user_c/get_user_data',
            data:{company_id:company_id,role_type:role_type},
            success:function(data)
            {
                data = JSON.parse(data);
                console.log(data);
                if(data.response_code==200)
                {   
                    if(data.data.length>0)
                    {
                        $('#user_id').html('');
                        $('#user_id').html('<option value=" ">Select User</option>');
                        $.each(data.data,function(i,v){
  
                        $('#user_id').append('<option value="'+v.id+'">'+v.user_full_name+'-['+v.emp_id+']</option>');
                        });
                    }else
                    {
                        $('#user_list').html('No Data Found');
                    }
                }else
                {
                    swal('error',data.msg,'error');
                }
              console.log();
            }
    
          });
    }
    // ================= area listing for select dropdown =====================
    function get_area_list()
    {  
       let assets_id = $('#assets_id').val();
       let company_id = '<?php echo $this->session->userdata('company_id') ?>';
       $.ajax({
            type: 'POST',
            url: '<?php echo base_url();?>Site_allotment_to_user_c/get_site_list',
            data:{company_id:company_id,assets_id:assets_id},
            success:function(data)
            {
                data = JSON.parse(data);
                console.log(data);
                if(data.response_code==200)
                {   
                    if(data.data.length>0)
                    {
                        $('#area_id').html('');
                        $('#area_id').html('<option value=" ">Select Area</option>');
                        $.each(data.data,function(i,v){
  
                        $('#area_id').append('<option value="'+v.id+'">'+v.area_name+'</option>');
                        });
                    }else
                    {
                        $('#user_list').html('No Data Found');
                    }
                }else
                {
                    swal('error',data.msg,'error');
                }
              console.log();
            }
    
          });
    }
    // =============== code of assets checkbox listing ======================
    function get_asset_list_for_allotment()
    {  
       let user_id = $('#user_id').val();
       let company_id = '<?php echo $this->session->userdata('company_id') ?>';
       $.ajax({
            type: 'POST',
            url: '<?php echo base_url();?>Site_allotment_to_user_c/get_assets_list',
            data:{company_id:company_id,user_id:user_id},
            success:function(data)
            {
                data = JSON.parse(data);
                console.log(data);
                if(data.response_code==200)
                {   
                    if(data.data.length>0)
                    {
                        $('#asset_list_to_allot').html('');
                        $.each(data.data,function(i,v){

                            if(data.assign_assets.find(e=>e.assets_id==v.id)!=undefined)
                            {
                               $('#asset_list_to_allot').append('<div class="col-md-3"><div>'+
                                '<input type="checkbox" checked="checked" value="'+v.id+'" name="assign_assets[]" class="mx-1">'+
                                '&nbsp;<strong>'+v.assets_name+'</strong>'+
                                '</div></div>'); 
                           }else
                           {
                            $('#asset_list_to_allot').append('<div class="col-md-3">'+
                            '<div><input type="checkbox" value="'+v.id+'" name="assign_assets[]" class="mx-1">'+
                            '&nbsp;<strong>'+v.assets_name+'</strong>'+
                            '</div></div>');
                           }
                            
                        });
                        
                    }else
                    {
                        $('#asset_list_to_allot').html('No Data Found');
                    }
                }else
                {
                    swal('error',data.msg,'error');
                }
              console.log();
            }
    
          });
    }
    // ================ code for area checkbox listing ======================
    function get_area_list_for_allotment()
    {  
       let user_id = $('#user_id').val();
       let company_id = '<?php echo $this->session->userdata('company_id') ?>';
       let assets_id = $('#assets_id').val();
       $.ajax({
            type: 'POST',
            url: '<?php echo base_url();?>Site_allotment_to_user_c/get_area_list',
            data:{company_id:company_id,user_id:user_id,assets_id:assets_id},
            success:function(data)
            {
                data = JSON.parse(data);
                console.log(data);
                if(data.response_code==200)
                {   
                    if(data.data.length>0)
                    {
                        $('#area_list_to_allot').html('');
                        $.each(data.data,function(i,v){

                            if(data.assign_area.find(e=>e.area_id==v.id)!=undefined)
                            {
                               $('#area_list_to_allot').append('<div class="col-md-3"><div>'+
                                '<input type="checkbox" checked="checked" value="'+v.id+'" name="assign_area[]" class="mx-1">'+
                                '&nbsp;<strong>'+v.area_name+'</strong>'+
                               '</div></div>'); 
                           }else
                           {
                                $('#area_list_to_allot').append('<div class="col-md-3">'+
                                '<div><input type="checkbox" value="'+v.id+'" name="assign_area[]" class="mx-1">'+
                                '&nbsp;<strong>'+v.area_name+'</strong>'+
                                '</div></div>');
                           }  
                        });
                    }else
                    {
                        $('#area_list_to_allot').html('No Data Found');
                    }
                }else
                {
                    swal('error',data.msg,'error');
                }
              console.log();
            }
    
          });
    }
    // =============== code for site checkbox listing =======================
    function get_site_list_for_allotment()
    {  
       let user_id = $('#user_id').val();
       let company_id = '<?php echo $this->session->userdata('company_id') ?>';
       let assets_id = $('#assets_id').val();
       let area_id = $('#area_id').val();
       $.ajax({
            type: 'POST',
            url: '<?php echo base_url();?>Site_allotment_to_user_c/get_Site_list_for_listing',
            data:{company_id:company_id,user_id:user_id,assets_id:assets_id,area_id:area_id},
            success:function(data)
            {
                data = JSON.parse(data);
                console.log(data);
                if(data.response_code==200)
                {   
                    if(data.data.length>0)
                    {
                        $('#site_list_to_allot').html('');
                        $.each(data.data,function(i,v){

                            if(data.assign_site.find(e=>e.site_id==v.id)!=undefined)
                            {
                               $('#site_list_to_allot').append('<div class="col-md-3"><div>'+
                               '<input type="checkbox" checked="checked" value="'+v.id+'" name="assign_site[]" class="mx-1">'+
                                '&nbsp;<strong>'+v.well_site_name+'</strong>'+
                                '</div></div>'); 
                           }else
                           {
                                $('#site_list_to_allot').append('<div class="col-md-3">'+
                               '<div><input type="checkbox" value="'+v.id+'" name="assign_site[]" class="mx-1">'+
                                '&nbsp;<strong>'+v.well_site_name+'</strong>'+
                             '</div></div>');
                           }
                        });
                        
                    }else
                    {
                        $('#site_list_to_allot').html('No Data Found');
                    }
                }else
                {
                    swal('error',data.msg,'error');
                }
              console.log();
            }
    
          });
    }
</script>



