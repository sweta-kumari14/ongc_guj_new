<div class="page-wrapper">
    <div class="content container-fluid pb-0">
    	<div class="page-header">
			<div class="content-page-header">
				<h5>Device Shifting</h5>
			</div>	
		</div>
			<div class="row">					
						<!-- Lightbox -->
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                   <div class="row align-items-center">
                                        <div class="col">
                                           <h4 class="header-title mb-4"><b>Well Wise Device Shifting</b></h4>
                                        </div>
                                        <div class="col-auto float-end ms-auto">
                                             <a href="<?php echo base_url('Dashboard_c'); ?>">
                                               <button type="button" class="btn btn-sm  btn-success">Back</button>
                                            </a>
                                        </div>
                                    </div>
                                <form class="custom-validation" method="POST" action="<?php echo base_url('Device_shifting_c/device_shifting_data'); ?>" 
                                enctype="multipart/form-data">
                                <div class="row">
                                    <div class="form-group col-md-4 mb-4" >
                                        <h4><b>Shifting Status<span style="color:red">*</span></b></h4>
                                        <select name="shifting_status" id="shifting_status" class="form-control select2"required>
                                        <option value="">Select Status</option>
                                        <option value="1">Device Interchange</option> 
                                        <option value="0">Device Shifting</option>   
                                        </select>
                                       
                                    </div>

                                    <div class="form-group col-md-4 mb-4" >
                                        <h4><b> From Well Name<span style="color:red">*</span></b></h4>
                                        <select name="from_well_id" id="from_well_id" class="form-control select2" onchange="get_from_well_data();check_well();"required>
                                        <option value="">Select Well</option>
                                            <?php 
                                                foreach ($from_well_list as $key => $value) 
                                                {
                                                    ?>
                                                        <option  value="<?php echo $value['well_id'].'|'.$value['imei_no'].'|'.$value['device_name'].'|'.$value['date_of_installation']; ?>"><?php echo $value['well_name']; ?></option>
                                                    <?php
                                                }
                                            ?>
                                        </select>
                                        <input type="hidden" name="hdn_from_well_id" id="hdn_from_well_id" class="form-control" required>
                                    </div>

                                    <div class="form-group col-md-4 mb-4" >
                                        <h4><b>From Well Device Name<span style="color:red">*</span></b></h4>
                                        <input type="text" name="from_well_device_name" id="from_well_device_name" class="form-control" required readonly>
                                        
                                    </div>
                                    <div class="form-group col-md-4 mb-4" >
                                        <h4><b>From Well Imei No<span style="color:red">*</span></b></h4>
                                        <input type="number" name="from_well_imei_no" id="from_well_imei_no" class="form-control " required readonly>
                                    </div>

                                    <input type="hidden" name="from_installation_date" id="from_installation_date" class="form-control" required readonly>

                                    <div class="form-group col-md-4 mb-4" >
                                        <h4><b>To Well Name<span style="color:red">*</span></b></h4>
                                        <select name="to_well_id" id="to_well_id" class="form-control select2" onchange="get_to_well_data();check_well();" required>
                                            <option value="">Select To Well</option>
                                            <?php 
                                                foreach ($to_well_list as $key => $value) 
                                                {
                                                    ?>
                                                        <option  value="<?php echo $value['id'].'|'.$value['imei_no'].'|'.$value['device_name'].'|'.$value['date_of_installation']; ?>"><?php echo $value['well_name']; ?></option>
                                                    <?php
                                                }
                                            ?>
                                        </select>
                                        <input type="hidden" name="hdn_to_well_id" id="hdn_to_well_id" class="form-control" required readonly>

                                    </div>
                                    <div class="form-group col-md-4 mb-4" >
                                        <h4><b>To Well Previous Device Name<span style="color:red">*</span></b></h4>
                                        <input type="text" name="to_well_previous_device_name" id="to_well_previous_device_name" class="form-control" readonly>
                                        
                                    </div>
                                    <div class="form-group col-md-4 mb-4" >
                                        <h4><b>To Well Previous Imei No<span style="color:red">*</span></b></h4>
                                        <input type="number" name="to_well_previous_imei_no" id="to_well_previous_imei_no" class="form-control" readonly>
                                    </div>
                                    <input type="hidden" name="to_well_previous_installation_date" id="to_well_previous_installation_date" class="form-control" required>
                                    <div class="form-group col-md-4 mb-4" >
                                        <h4><b>Shifting Date Time<span style="color:red">*</span></b></h6>
                                        <input type="datetime-local" name="shifting_date_time" id="shifting_date_time" class="form-control" required>    
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
    function get_from_well_data()
    {
        let dataset = $('#from_well_id').val();
        $('#hdn_from_well_id').val(dataset.split("|")[0]);
        $('#from_well_imei_no').val(dataset.split("|")[1]);
        $('#from_well_device_name').val(dataset.split("|")[2]); 
        $('#from_installation_date').val(dataset.split("|")[3]);
    }

    function get_to_well_data()
    {
        let dataset = $('#to_well_id').val();
        $('#hdn_to_well_id').val(dataset.split("|")[0]);
        $('#to_well_previous_imei_no').val(dataset.split("|")[1]);
        $('#to_well_previous_device_name').val(dataset.split("|")[2]);  
        $('#to_well_previous_installation_date').val(dataset.split("|")[3]);  
    }

    function check_well()
    {
        var from_well_id = $('#hdn_from_well_id').val();
        var to_well_id = $('#hdn_to_well_id').val();

        if(from_well_id == to_well_id)
        {
            swal('error','Both Well Are Same','error');
            $('#to_well_id').val('').change();
            $('#hdn_to_well_id').val('');
            $('#to_well_previous_imei_no').val('');
            $('#to_well_previous_device_name').val('');    

        }
    }
</script>
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

