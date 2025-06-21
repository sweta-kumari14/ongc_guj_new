<div class="page-wrapper">
    <div class="content container-fluid pb-0">
    	<div class="page-header">
			<div class="content-page-header">
				<h5>Well Add/Replace</h5>
			</div>	
		</div>
		<div class="row">						
            <div class="col-lg-12">
                <div class="card">
                   
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto float-end ms-auto">
                                 <a href="<?php echo base_url('Dashboard_c'); ?>">
                                   <button type="button" class="btn btn-sm  btn-success">Back</button>
                                </a>
                            </div>
                        </div>

                        <form class="custom-validation" method="POST" action="<?php echo base_url('Well_Integration_c/Add_Well_integration_details'); ?>" >
                            <div class="row">
                                <div class="form-group col-md-6 mt-2">
                                    <h4><b>Assets</b><span style="color:red;">*</span></h4>
                                    <select name="assets_id" id="assets_id" class="form-control select2" required onchange="get_area_list();get_site_list();">
                                        <?php 
                                        if(!empty($assets_list))
                                        {
                                            foreach ($assets_list as $key => $value) 
                                            {
                                                ?>
                                                    <option value="<?php echo $value['assets_id']; ?>"> <?php echo $value['assets_name']; ?></option>
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

                                <div class="form-group col-md-6 mt-4">
                                    <h4><b>Site</b><span style="color:red;">*</span></h4>
                                    <select name="site_id" id="site_id" class="form-control select2" required onchange="get_well_list();get_To_well_list();">
                                        <option value="">Select Site</option>
                                        
                                    </select>
                                </div>

                                <div class="form-group col-md-6 mt-4">
                                    <h4><b>Action</b><span style="color:red;">*</span></h4>
                                    <select name="well_type" id="well_type" class="form-control select2" onchange="get_well_type();">
                                        <option value=""> Select Well Type </option>
                                        <option value="0">Add New Well</option>
                                        <option value="1">Remove Well</option>
                                        <option value="2">Shift Well</option>

                                    </select>
                                </div>

                                <div class="form-group col-md-6 mt-4" id="add_new_well" style="display: none;">
                                    <h4><b>Well Name</b><span style="color:red;">*</span></h4>
                                    <input type="text" name="well_name" id="well_name" class="form-control"   onkeyup="this.value = this.value.replace(/[^a-zA-Z0-9-# ]/g,'')" >
                                </div>
                                <div class="form-group col-md-6 mt-4" id="remove_well" style="display: none;">
                                    <h4><b id="well_text">Well Name</b><span style="color:red;">*</span></h4>
                                    <select name="well_id" id="well_id" class="form-control select2" onchange="get_well_data();check_well();">
                                    <option value="">Select Well </option>
                                        
                                    </select>
                                    <input type="hidden" name="well_name_hdn" id="well_name_hdn">
                                    <input type="hidden" name="well_id_hdn" id="well_id_hdn">
                                </div>

                                <div class="form-group col-md-6 mt-4" id="remove_device" style="display: none;">
                                    <h4><b>Device Name</b><span style="color:red;">*</span></h4>
                                    <input type="text" name="device_name_hdn" id="device_name_hdn" class="form-control"  readonly>
                                </div>

                                <div class="form-group col-md-6 mt-4" id="remove_imei_no" style="display: none;">
                                    <h4><b>Imei No</b><span style="color:red;">*</span></h4>
                                    <input type="number" name="imei_no_hdn" id="imei_no_hdn" class="form-control"  readonly>
                                </div>

                                <div class="form-group col-md-6 mt-4" id="well_Aval" style="display: none;">
                                    <h4><b>Well Status</b><span style="color:red;">*</span></h4>
                                    <select name="well_status" id="well_status" class="form-control select2" onchange="well_availability_condition();">
                                        <option value=""> Select Well Status </option>
                                        <option value="0">Available Well</option>
                                        <option value="1">New Well</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-6 mt-4" id="to_well_id_field" style="display: none;">
                                    <h4><b>To Well</b><span style="color:red;">*</span></h4>
                                    <select name="to_well_id" id="to_well_id" class="form-control select2" onchange="get_toWell_hdn_id();check_well();">
                                    <option value="">Select Well </option>
                                        
                                    </select>
                                    <input type="hidden" name="to_well_hdn_id" id="to_well_hdn_id" >
                                </div>

                                <div class="form-group col-md-6 mt-4" id="to_well_name_field" style="display: none;">
                                    <h4><b>To Well Name</b><span style="color:red;">*</span></h4>
                                    <input type="text" name="to_well_name" id="to_well_name" class="form-control"  onkeyup="this.value = this.value.replace(/[^a-zA-Z0-9-# ]/g,'')" >
                                </div>

                                

                                <div class="form-group col-md-6 mt-4" id="add_new_well_date" style="display: none;">
                                    <h4><b>Tentative Date</b><span style="color:red;">*</span></h4>
                                    <input type="datetime-local" id="tentative_date" name="tentative_date" value="<?= date('Y-m-d\TH:i', time()); ?>" class="form-control" required>
                                </div>

                                <div class="form-group col-md-6 mt-4" id="remove_reason" style="display: none;">
                                    <h4><b id="reason_text">Remove Reason</b><span style="color:red;">*</span></h4>
                                   
                                    <textarea type="text" name="reason_remove" id="reason_remove" class="form-control" onkeyup="this.value = this.value.replace(/[<>]/g,'')" ></textarea>
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
    
    

   get_area_list();
    function get_area_list()
    {

        let assets_id = $('#assets_id').val();
        let user_id = "<?php echo $this->session->userdata('user_id') ?>";
        let company_id = "<?php echo $this->session->userdata('company_id') ?>";
   
        $.ajax({
            url: '<?php echo base_url(); ?>Well_Integration_c/get_area_list',
            type: 'POST',
            data: {assets_id: assets_id,company_id:company_id,user_id:user_id},
            success:function(res)
            {
                response = JSON.parse(res);
                // console.log(response);
                if(response.data.length>0)
                {
                    $('#area_id').html('<option value="">Select Area</option>');
                    $.each(response.data,function(i,v){
                        $('#area_id').append('<option value="'+v.area_id+'">'+v.area_name+'</option>');
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
        let user_id = "<?php echo $this->session->userdata('user_id') ?>";
        let company_id = "<?php echo $this->session->userdata('company_id') ?>";

 

         $.ajax({
            url: '<?php echo base_url(); ?>Well_Integration_c/get_site_list',
            type: 'POST',
            data: {assets_id: assets_id,area_id:area_id,company_id:company_id,user_id:user_id},
            success:function(res)
            {
                response = JSON.parse(res);
                // console.log(response);
                if(response.data.length>0)
                {
                    $('#site_id').html('<option value="">Select Site</option>');
                    $.each(response.data,function(i,v){
                        $('#site_id').append('<option value="'+v.site_id+'">'+v.well_site_name+'</option>');
                    });
                }else{
                      $('#site_id').html('No Data Found');
                }
            }
        });
    }


    function get_well_list()
    {

        let assets_id = $('#assets_id').val();
        let area_id = $('#area_id').val();
        let user_id = "<?php echo $this->session->userdata('user_id') ?>";
        let company_id = "<?php echo $this->session->userdata('company_id') ?>";
        let site_id = $('#site_id').val();

 

         $.ajax({
            url: '<?php echo base_url(); ?>Well_Integration_c/get_well_list',
            type: 'POST',
            data: {company_id:company_id,user_id:user_id,assets_id: assets_id,area_id:area_id,site_id:site_id},
            success:function(res)
            {
                response = JSON.parse(res);
                // console.log('well_data',res);
                if(response.data.length>0)
                {
                    $('#well_id').html('<option value="">Select Well</option>');
                    $.each(response.data,function(i,v){
                        $('#well_id').append('<option value="'+v.well_id+'|'+v.device_name+'|'+v.imei_no+ '|'+ v.well_name+'">'+v.well_name+'</option>');
                    });
                }else{
                      $('#well_id').html('No Data Found');
                }
            }
        });
    }


    function get_To_well_list()
    {
        let assets_id = $('#assets_id').val();
        let area_id = $('#area_id').val();
        let user_id = "<?php echo $this->session->userdata('user_id') ?>";
        let company_id = "<?php echo $this->session->userdata('company_id') ?>";
        let site_id = $('#site_id').val();

        $.ajax({
            url: '<?php echo base_url(); ?>Well_Integration_c/get_well_list',
            type: 'POST',
            data: {company_id:company_id,user_id:user_id,assets_id: assets_id,area_id:area_id,site_id:site_id},
            success:function(res)
            {
                response = JSON.parse(res);
                // console.log('well_data',res);
                if(response.data.length>0)
                {
                    $('#to_well_id').html('<option value="">Select Well</option>');
                    $.each(response.data,function(i,v){
                        $('#to_well_id').append('<option value="'+v.well_id+'">'+v.well_name+'</option>');
                    });
                }else{
                      $('#to_well_id').html('No Data Found');
                }
            }
        });
    }
</script>

<script type="text/javascript">
    
    function get_well_type()
    {
        var value = $('#well_type').val();

        if (value == '0')
        {
            $('#add_new_well').show();
            $('#add_new_well_date').show();
            $('#remove_well').hide();
            $('#remove_device').hide();
            $('#remove_imei_no').hide();
            $('#remove_reason').hide();

            $('#well_Aval').hide();
            $('#to_well_id_field').hide();
            $('#to_well_name_field').hide();

        }else if(value == '1')
        {
            $('#add_new_well').hide();
            $('#add_new_well_date').show();
            $('#remove_well').show();
            $('#remove_device').show();
            $('#remove_imei_no').show();
         
            $('#remove_reason').show();

            $('#well_text').text('Well Name');
            $('#reason_text').text('Replace Reason');

            $('#well_Aval').hide();
            $('#to_well_id_field').hide();
            $('#to_well_name_field').hide();
        }else if(value == '2')
        {
            $('#add_new_well').hide();
            $('#add_new_well_date').show();
            $('#remove_well').show();
            $('#remove_device').hide();
            $('#remove_imei_no').hide();
         
            $('#remove_reason').show();
            $('#well_text').text('From Well');
            $('#reason_text').text('Shift Reason');

            $('#well_Aval').show();
            $('#to_well_id_field').hide();
            $('#to_well_name_field').hide();
            
            
        }else{
            $('#add_new_well').hide();
            $('#add_new_well_date').hide();
            $('#remove_well').hide();
            $('#remove_device').hide();
            $('#remove_imei_no').hide();
            $('#remove_well_date').hide();
            $('#remove_reason').hide();

            $('#well_Aval').hide();
            $('#to_well_id_field').hide();
            $('#to_well_name_field').hide();
        }
           
            
    }
</script>
  <script type="text/javascript">
       function get_well_data()
       {
        var well_id = $('#well_id').val();
        $('#well_id_hdn').val(well_id.split("|")[0]);
        $('#device_name_hdn').val(well_id.split("|")[1]);
        $('#imei_no_hdn').val(well_id.split("|")[2]);
        $('#well_name_hdn').val(well_id.split("|")[3]);
    }
   </script>


<script type="text/javascript">


    function get_toWell_hdn_id()
    {
        var to_well_id = $('#to_well_id').val();
        $('#to_well_hdn_id').val(to_well_id);
    }
    
    function check_well()
    {
        var from_well_id = $('#well_id_hdn').val();
        var to_well_id = $('#to_well_hdn_id').val();

        // console.log('from_well_id===',from_well_id);
        // console.log('to_well_id==',to_well_id);


        if(from_well_id == to_well_id)
        {
            // console.log('hi')
            swal('error','Both Well Are Same','error');
            $('#well_id').val('').change();
            $('#to_well_id').val('').change();

            $('#well_id_hdn').val('');
            $('#device_name_hdn').val('');
            $('#imei_no_hdn').val('');
            $('#well_name_hdn').val('');
        }
    }

    function well_availability_condition()
    {
        var selected_value = $('#well_status').val();
        console.log('selected_value===',selected_value);

        if(selected_value == 0)
        {
            $('#to_well_id_field').show();
            $('#to_well_name_field').hide();

        }else if(selected_value == 1)
        {
            $('#to_well_id_field').hide();
            $('#to_well_name_field').show();
        }else if(selected_value == "" || selected_value == null)
        {
            $('#to_well_id_field').hide();
            $('#to_well_name_field').hide();
        }else{
            $('#to_well_id_field').hide();
            $('#to_well_name_field').hide();
        }
    }
</script>