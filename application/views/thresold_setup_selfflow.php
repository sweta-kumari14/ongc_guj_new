<div class="page-wrapper">
    <!-- Page Content -->
    <div class="content container-fluid">

        <div class="row row-sm">
            <div class="col-lg-12">
                <div class="card">

                    <!-- Header -->
                    <div class="card-body" style="padding: 6px;">
                        <div class="row align-items-center">
                            <div class="col-md-6 d-flex align-items-center" style="margin-top: 8px;">
                                <h3 class="m-0">Threshold Setup</h3>
                            </div>
                            <div class="col-md-6 d-flex justify-content-end align-items-center" style="margin-top: 8px;">
                                <a href="Threshold_setup_selfflow_c">
                                    <button class="btn btn-sm btn-primary mx-2">Back</button>
                                </a>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Main Body -->
                    <div class="card-body">
                         <form class="custom-validation" method="POST" action="<?php echo base_url('Threshold_setup_selfflow_c/add_threshold_setup'); ?>" enctype="multipart/form-data">
                        
                                <div class="row align-items-end" style="margin-top:-25px">
                                    <!-- View Setup Dropdown -->
                                    <div class="form-group col-md-4">
                                        <label for="report_view" class="form-label"><b>View Setup</b></label>
                                        <select name="threshold_type" id="threshold_type" class="form-control select2" onchange="get_view();" style="width: 100%;">
                                            <option value="">Select Setup</option>
                                            <option value="1">Area Wise</option>
                                            <option value="2">Well Wise</option>
                                           
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4" id="inline_area_div" style="display: none;">
                                        <label class="form-label">Area</label>
                                        <select name="site_id" id="site_id" class="form-control select2"required onchange="get_well_list();get_multiple_well_list();">

                                           <?php 
                                                if (!empty($site_list)) {
                                                    echo '<option value="">Select All</option>';
                                                    foreach ($site_list as $value) {
                                                        echo '<option value="' . $value['id'] . '">' . $value['well_site_name'] . '</option>';
                                                    }
                                                }
                                            
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4" id="inline_well_div" style="display: none;">
                                        <label for="well_single" class="form-label">Well Name</label>
                                      <select class="form-select select2" id="well_id" name="well_id" >
                                    <option value="">Select Well</option>
                                           </select>
                                    </div>
                            <div id="multiWellDiv" style="display: none;">
                                <div class="row mt-2">
                                    <div class="form-group col-md-8">
                                        <label for="well_ids" class="form-label">Select Wells</label>
                                        <select name="well_ids[]" id="well_ids" class="form-control select2" multiple="multiple" style="width: 100%;">
                                        </select>
                                    </div>
                                </div>
                            </div>
                                <div id="thresholdFields" style="display: none; margin-top: 23px;">
                                    <div class="row mt-2">
                                        <!-- CHP -->
                                        <div class="form-group col-md-3">
                                            <label><b>Upper CHP</b></label>
                                            <input type="number" class="form-control" name="chp_uppar" id="chp_uppar" placeholder="Enter Upper CHP">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label><b>Lower CHP</b></label>
                                            <input type="number" class="form-control" name="chp_lower" id="chp_lower" placeholder="Enter Lower CHP">
                                        </div>
                                        <!-- THP -->
                                        <div class="form-group col-md-3">
                                            <label><b>Upper THP</b></label>
                                            <input type="number" class="form-control" name="thp_uppar" id="thp_uppar" placeholder="Enter Upper THP">
                                        </div>


                                        <div class="form-group col-md-3">
                                            <label><b>Lower THP</b></label>
                                            <input type="number" class="form-control" name="thp_lower" id="thp_lower" placeholder="Enter Lower THP">
                                        </div>
                                        <!-- ABP -->
                                        <div class="form-group col-md-3" style="margin-top: 18px;">
                                            <label><b>Upper ABP</b></label>
                                            <input type="number" class="form-control" name="abp_uppar" id="abp_uppar"placeholder="Enter Upper ABP">
                                        </div>
                                        <div class="form-group col-md-3" style="margin-top: 18px;">
                                            <label><b>Lower ABP</b></label>
                                            <input type="number" class="form-control" name="abp_lower" id="abp_lower" placeholder="Enter Lower ABP">
                                        </div>
                                        <!-- THT -->
                                        <div class="form-group col-md-3" style="margin-top: 18px;">
                                            <label><b>Upper THT</b></label>
                                            <input type="number" class="form-control" name="tht_uppar" id="tht_uppar" placeholder="Enter Upper THT">
                                        </div>
                                        <div class="form-group col-md-3" style="margin-top: 18px;">
                                            <label><b>Lower THT</b></label>
                                            <input type="number" class="form-control" name="tht_lower" id="tht_lower" placeholder="Enter Lower THT">
                                        </div>
                                    </div>
                                </div>
                            </div>
                                 <div class="footer mt-4">
                                    <div>
                                        <button type="submit" class="btn btn-sm btn-primary" >Submit</button>
                                    </div>
                                </div>
                                
                                </form>
                            </div>

                    </div> <!-- card -->
                </div> <!-- col -->
            </div> <!-- row -->

        </div> <!-- container-fluid -->
    </div> <!-- page-wrapper -->
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

    function get_view()
    {
        var value = $('#threshold_type').val();
        if(value == 1)
        {
            $('#inline_area_div').show();
            $('#inline_well_div').hide();
            $('#multiWellDiv').show();
            $('#thresholdFields').show();


        }else if(value == 2 )
        {
             $('#inline_area_div').show();
             $('#inline_well_div').show();
             $('#multiWellDiv').hide();
             $('#thresholdFields').show();
        }
    }
    function get_well_list() 
    {
        let site_id = $('#site_id').val();
     
         $.ajax({
            url: '<?php echo base_url(); ?>Threshold_setup_selfflow_c/get_well_list',
            type: 'POST',
            data: {site_id:site_id},
            success:function(res)
            {
                response = JSON.parse(res);
                console.log(response,'fhshdfj');
                if(response.data.length>0)
                {
                    $('#well_id').html('<option value="">Select well</option>');
                    $.each(response.data,function(i,v){
                        $('#well_id').append('<option value="'+v.id+'">'+v.well_name+'</option>');
                    });
                }else{
                      $('#well_id').html('No Data Found');
                }
            }
        });
    }

    function get_multiple_well_list() 
    {
        let site_id = $('#site_id').val();
        
         $.ajax({
            url: '<?php echo base_url(); ?>Threshold_setup_selfflow_c/get_well_list',
            type: 'POST',
            data: {site_id:site_id},
            success:function(res)
            {
                response = JSON.parse(res);
                console.log(response,'multiple');
                if(response.data.length>0)
                {
                    $('#well_ids').html('<option value="">Select well</option>');
                    $.each(response.data,function(i,v){
                        $('#well_ids').append('<option value="'+v.id+'">'+v.well_name+'</option>');
                    });
                }else{
                      $('#well_ids').html('No Data Found');
                }
            }
        });
    }


</script>




