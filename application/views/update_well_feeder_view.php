<div class="page-wrapper">
    <div class="content container-fluid pb-0">
        <div class="page-header">
            <div class="content-page-header">
                <h5>Change Well Feeder</h5>
            </div>  
        </div>
            <div class="row">                   
                        <!-- Lightbox -->
                        <div class="col-lg-12">
                            <div class="card">
                               
                                <div class="card-body">
                                   <div class="row align-items-center">
                                        <div class="col">
                                           <h4 class="header-title mb-4"><b>Change Well Feeder</b></h4>
                                        </div>
                                    </div>

                        <div class="card-body">
                            <form class="custom-validation" method="POST" action="<?php echo base_url('Well_Integration_c/update_feeder_well'); ?>" enctype="multipart/form-data">
                                    <div class="row">
                                    <div class="col-md-3">
                                  <div class="form-group">
                                    <h5><b>Well type <span style="color:red">*</span></b></h5>
                                    <select class="form-select select2" id="well_type" name="well_type"  onchange="get_well_list();">
                                        <?php

                                        if (!empty($well_type_list)) {
                                            echo '<option value="">Select All</option>';
                                            foreach ($well_type_list as $key => $value) {
                                        ?>
                                        <option value="<?php echo $value['id']; ?>">
                                            <?php echo $value['well_type_name']; ?></option>
                                        <?php
                                            }
                                        }

                                        ?>
                                    </select>
                                </div>
                            </div>
                                    <div class="form-group col-md-3">
                                        <h5><b>Well Name <span style="color:red">*</span></b></h5>
                                        <select name="well_id" id="well_id" class="form-control select2"  required>
                                            <option value="">Select</option>
                                          
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6 ">
                                        <h5><b>Feeder Name <span style="color:red">*</span></b></h5>
                                       <select name="feeder_id" id="feeder_id" class="form-control select2"  required>
                                            <option value="">Select</option>
                                            <?php 
                                            if(!empty($feeder_list))
                                            {
                                                foreach ($feeder_list as $key => $value) 
                                                {
                                                    ?>
                                                        <option value="<?php echo $value['id']; ?>"> <?php echo $value['feeder_name']; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
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

get_well_list();
function get_well_list() { 
    
    let well_type = $('#well_type').val();
    

    $.ajax({
        type: 'POST',
        url: '<?php echo base_url();?>Well_Integration_c/get_well_list_for_feeder',
        data: { well_type: well_type },
        success: function(data) {
            data = JSON.parse(data);
           
            if (data.response_code == 200) {   
                if (data.data.length > 0) {
                    $('#well_id').html('');
                    $('#well_id').html('<option value="">Select Well</option>');
                    $.each(data.data, function(i, v) {
                     
                        $('#well_id').append('<option value="' + v.well_id + '">' + v.well_name + '</option>');
                    });
                } else {
                    $('#well_id').html('<option value="">No Well Found</option>');
                }
            } else {
                swal('error', data.msg, 'error');
            }   
        }
    });
}


</script>