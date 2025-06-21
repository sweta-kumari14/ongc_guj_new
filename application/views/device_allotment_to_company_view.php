<div class="page-wrapper">
    <div class="content container-fluid pb-0">
    	<div class="page-header">
			<div class="content-page-header">
				<h5>Device Allotment</h5>
			</div>	
		</div>
			<div class="row">					
				<!-- Lightbox -->
                <div class="col-lg-12">
                    <div class="card">
                       
                        <div class="card-body">
                           <div class="row align-items-center">
                                <div class="col">
                                   <h4 class="header-title mb-4"><b>Device Allotment</b></h4>
                                </div>
                               
                            </div>


                            <form class="custom-validation" method="POST" action="<?php echo base_url('Device_allotment_to_company_c/allot_devices'); ?>" enctype="multipart/form-data">
                        <div class="row">
                            <div class="form-group col-md-4 mt-2" >
                                <h4><b>Company Name</b></h4>
                                <select name="company_name" id="company_name" class="form-control select2"  required>
                                    <option value="">Select Company</option>
                                    <?php 
                                    if(!empty($company_list))
                                    {
                                        foreach ($company_list as $key => $value) 
                                        {
                                            ?>
                                                <option value="<?php echo htmlspecialchars($value['id']); ?>"> <?php echo htmlspecialchars($value['company_name']); ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        
                            <div class="form-group col-md-4 mt-2" >
                                <h4><b>Device Name</b></h4>
                                <select name="device_id" id="device_id" class="form-control select2" onchange="get_device_hdn_data();">
                                    <option value="">Select Device</option>
                                    <?php 
                                    if(!empty($device_list))
                                    {
                                        foreach ($device_list as $key => $value) 
                                        {
                                            ?>
                                                <option value="<?php echo $value['id'].'|'.$value['imei_no'].'|'.$value['serial_no'].'|'.$value['device_name']; ?>"> <?php echo $value['device_name']; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <input type="hidden" name="device_name_hdn[]" id="device_name_hdn">
                                <input type="hidden" name="imei_no_hdn[]" id="imei_no_hdn">
                                <input type="hidden" name="serial_no_hdn[]" id="serial_no_hdn">
                            </div>  

                            <div class="col-md-1 mt-4">
                                <button type="button" onclick="add_devices();" class="btn btn-sm btn-success mt-4">Add</button>
                            </div>
                            
                        </div>
                        <div class="" id="assign_device">
                            
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
    
    function get_device_hdn_data()
    {
        let device_data = $('#device_id').val();
        $('#imei_no_hdn').val(device_data.split('|')[1]);
        $('#serial_no_hdn').val(device_data.split('|')[2]);
        $('#device_name_hdn').val(device_data.split('|')[3]);
    }


    let row_no = 0;
    function add_devices()
    {
        
        
        let device_data = $('#device_id').val();
        if (!device_data) 
        {
            swal('Device required','','error');
            return false;
        }
        $('#assign_device').append('<div id="row_' + row_no + '" class="row">'+
            '<div class="col-md-4 mt-3">'+
                '<label>Device Name</label>'+
                '<input type="text" name="device_name[]" class="form-control" value="'+$('#device_name_hdn').val() +'" readonly>'+
                
            '</div>'+
            '<div class="col-md-4 mt-3">'+
                '<label>Imei No</label>'+
                '<input type="text" name="imei_no[]" class="form-control" value="'+$('#imei_no_hdn').val() +'" readonly>'+
            '</div>'+
             '<div class="col-md-3 mt-3">'+
                    '<label>Serial No</label>'+
                    '<input type="text" name="serial_no[]" class="form-control" value="'+$('#serial_no_hdn').val() +'" readonly>'+
                           
            '</div>'+
            '<div class="col-md-1 mt-4">'+
                '<img src="<?php echo base_url(); ?>assets/img/delete.png" alt="" width="20" onclick="deleterow(' + row_no + ')" style="cursor:pointer;" class="mt-4">' +
                           
            '</div>'+
            '</div>');

        row_no++;
        
        $('#device_id').val('').change();
               
    }

      function deleterow(id) {


        swal({
            title: "Are you sure You want to delete",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    $('#row_' + id).remove();

                    swal("Deleted Successfully", {
                        icon: "success",
                    });
                } else {
                    swal("Delete Cancelled");
                }
            });



    }
</script>








                


