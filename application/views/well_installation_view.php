
<div class="page-wrapper">
   
<div class="container-xxl">

   

    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header mb-0" style="padding: 10px;">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="mb-1">Installation</h4>
                        </div>
                        <div class="col-auto ms-auto d-flex gap-2">
                             <a href="<?php echo base_url('Main_dashboard'); ?>" class="btn btn-sm btn-success motion-btn">
                              <i class="fas fa-arrow-left me-1" style="font-size: 12px;"></i> Back
                            </a>

                        </div>
                    </div>
                </div>

                    <div class="card-body pt-1">                    
                        <form method="POST" action="<?php echo base_url('Device_installation_selflow_c/Device_install')?>" enctype="multipart/form-data" class="needs-validation" novalidate>
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label class="form-label">Assets Name<sup class="text-danger">*</sup></label>
                                <select name="assets_id" id="assets_id" class="form-control select2" onchange="get_area_list();" required>
                                    <option value="">Select Assets</option>
                                    <?php 
                                        if (!empty($assets_list))
                                        {
                                            foreach ($assets_list as $key => $value)
                                            {
                                                ?>
                                                <option value="<?php echo $value['id']; ?>"><?php echo $value['assets_name']; ?></option>
                                                <?php
                                            }
                                            }
                                        ?>
                                </select>
                                <div class="invalid-feedback">
                                    Please select an asset!
                                </div>
                            </div>
                               
                            <div class="form-group col-md-4">
                                <label class="form-label">Area Name<sup class="text-danger">*</sup></label>
                                <select name="area_id" id="area_id" class="form-control select2" onchange="get_site_list();" required>
                                    <option value="">Select Area</option>
                    
                                </select>
                                <div class="invalid-feedback">
                                    Please select an area!
                                </div>
                            </div>

                            <div class="form-group col-md-4" >
                                <label class="form-label">Site Name<sup class="text-danger">*</sup></label>
                                <select name="site_id" id="site_id" class="form-control select2" required>
                                    <option value="">Select Site</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please select site!
                                </div>
                            </div>
                            <div class="form-group col-md-4 mt-2">
                                <label class="form-label">Well Type<sup class="text-danger">*</sup></label>
                                <select name="well_type" id="well_type" class="form-control select2" required onchange="get_well_formula_list();get_well_list();">
                                    <option value="">Select well type</option>
                                    <?php 
                                        if (!empty($well_type_list)) {
                                          foreach ($well_type_list as $key => $value) { ?>
                                            <option value="<?php echo $value['id']; ?>"><?php echo $value['well_type_name']; ?></option>
                                        <?php } 
                                    } ?>
                                </select>
                                <div class="invalid-feedback">
                                    Please select well type!
                                </div>
                            </div>
                            <div class="form-group col-md-4 mt-2" >
                                <label class="form-label">Well Name<sup class="text-danger">*</sup></label>
                                <select name="well_id" id="well_id" class="form-control select2" required>
                                    <option value="">Select Well</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please select well!
                                </div>
                            </div>
                                  
                            <div class="form-group col-md-4 mt-2" >
                                <label class="form-label">Latitude<sup class="text-danger">*</sup></label>
                                <input type="text" name="lat_hdn" id="lat_hdn" required class="form-control"  data-parsley-pattern="^-?([1-8]?[0-9](\.\d+)?|90(\.0+)?)$"
                                       data-parsley-pattern-message="Please enter a valid latitude between -90 and 90."
                                       placeholder="e.g., 23.45678">
                                <div class="invalid-feedback">
                                    Please enter a valid latitude between -90 and 90.
                                </div>
                            </div>
                            <div class="form-group col-md-4 mt-2" >
                                <label class="form-label">Longitude<sup class="text-danger">*</sup></label>
                                <input type="text" name="long_hdn" id="long_hdn" class="form-control" required
                                   data-parsley-pattern="^-?(180(\.0+)?|((1[0-7][0-9])|([1-9]?[0-9]))(\.\d+)?)$"
                                   data-parsley-pattern-message="Please enter a valid longitude between -180 and 180."
                                   placeholder="e.g., 72.12345">
                                <div class="invalid-feedback">
                                    Please enter a valid longitude between -180 and 180.
                                </div>
                            </div>
                                    
                            <div class="form-group col-md-4 mt-2" >
                                <label class="form-label">Device Name<sup class="text-danger">*</sup></label>
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
                                <div class="invalid-feedback">
                                    Please select device!
                                </div>
                            </div>

                            <input type="hidden" name="device_name_hdn" id="device_name_hdn" class="form-control">
                            <input type="hidden" name="imei_no_hdn" id="imei_no_hdn" class="form-control">
                            <div class="form-group col-md-4 mt-2" >
                                <label class="form-label">Sim Provider<sup class="text-danger">*</sup></label>
                                <select name="sim_provider" id="sim_provider" required class="form-control select2" >
                                    <option value="">Select Sim</option>
                                    <option value="2" selected>Airtel</option>
                                    <option value="3">JIO</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please select sim!
                                </div>
                            </div>

                            <div class="form-group col-md-4 mt-2" >
                                <label class="form-label">Sim Serial No</label>
                                <input type="number" name="sim_no" id="sim_no" class="form-control" maxlength="10" minlength="10">
                            </div>

                            <div class="form-group col-md-4 mt-2" >
                                <label class="form-label">Network Type<sup class="text-danger">*</sup></label>
                                <select name="network_type" id="network_type" class="form-control select2" required >
                                    <option value="3" selected>4G</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please select network type!
                                </div>
                            </div>
                            <div class="form-group col-md-2 mt-2">
                                <label class="form-label">Image</label>
                                <input type="file" name="image" id="image" class="form-control"  accept=".jpg,.png,.jpeg" onchange="previewImage(event)">
                            </div>
                            <div class="form-group col-md-2 mt-2">
                                <!-- Preview container -->
                                <img id="imagePreview" style="width: 100px; height: 100px; display: none; margin-top: 10px;" alt="Image Preview">
                            </div>

                        </div>
                        <div class="form-group col-md-12 mt-2">
                            <h5 class="form-label">Well Formula<sup class="text-danger">*</sup></h5>
                            <div class="row" id="well_type_formula"></div>
                            <div class="pt-1 pb-1 text-center">
                                <button type="button" class="btn btn-primary" id="button-show" onclick="get_item_list();" style="display:none;">Choose</button>
                            </div>
                        </div>
                        <hr>
                        <div class="text-end">
                            <button type="submit"  class="btn btn-sm btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function previewImage(event) {
        var image = document.getElementById('image').files[0];
        if (image) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var preview = document.getElementById('imagePreview');
                preview.src = e.target.result; // Set image source to file content
                preview.style.display = 'block'; // Display the preview image
            }
            reader.readAsDataURL(image); // Read the file as a data URL
        }
    }
</script>
 <script>
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(
        function (position) {
          var latitude = position.coords.latitude;
          var longitude = position.coords.longitude;
          document.getElementById("lat_hdn").value = latitude;
          document.getElementById("long_hdn").value = longitude;
        },
        function (error) {
          console.error("Error occurred while fetching location: ", error.message);
          swal("Unable to retrieve location. Please enable location services.");
        }
      );
    } else {
      swal("Geolocation is not supported by your browser.");
    }
  </script>
<script type="text/javascript">

function get_well_formula_list() {
    let well_type = $('#well_type').val();

    $.ajax({
        type: 'POST',
        url: '<?php echo base_url();?>Device_installation_selflow_c/get_well_type_details_list',
        data: { well_type: well_type },
        success: function(data) {
            data = JSON.parse(data);
            console.log(data);


            if (data.response_code == 200) {
                if (data.data.length > 0) {
                    $('#well_type_formula').html('');
                    $.each(data.data, function(i, v) {
                        let serialNumbersRowId = `serial_numbers_${v.component_id}`;
                        $('#well_type_formula').append(
                            `<div class="col-md-12 mt-1">
                                <input type="checkbox" class="form-check-input" required
                                       value="${v.component_id}|${v.quantity_required}|${v.component_name}" 
                                       id="checkbox_${v.component_id}" 
                                       onchange="toggle_item_fields(${v.component_id}, ${v.quantity_required}, '${v.component_name}', '${serialNumbersRowId}');">
                                <label class="form-check-label" for="checkbox_${v.component_id}">
                                    ${v.component_name} | ${v.quantity_required}
                                </label>
                            </div>
                            <div id="${serialNumbersRowId}" class="row"></div>`
                        );
                    });
                } else {
                   $('#well_type_formula').html('<p class="mt-2 text-danger"><i class="fas fa-exclamation-triangle me-1"></i> Opps! Well formula not setup.</p>');
                }
            } else {
                swal('error', data.msg, 'error');
            }
        }
    });
}

function toggle_item_fields(component_id, quantity_required, component_name, serialNumbersRowId) {
    let checkbox = $(`#checkbox_${component_id}`);
    let container = $(`#${serialNumbersRowId}`);

    if (checkbox.is(':checked')) {
        container.html(''); 
        get_item_list(component_id, quantity_required, component_name, serialNumbersRowId);
    } else {
        container.html(''); 
    }
}


function checkAllCheckboxesBeforeSubmit() 
{
    let allChecked = true;
    $('input[type="checkbox"]').each(function() {
        if (!$(this).prop('checked')) {
            allChecked = false;
        }
    });
    if (!allChecked) {
    
        swal('Error', 'Please choose all checkboxes', 'error');
    } 
}
$('#submit_button').on('click', function(event) {
    event.preventDefault(); 
    checkAllCheckboxesBeforeSubmit(); 
});

function get_item_list(component_id, quantity_required, component_name, serialNumbersRowId) {
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url();?>Device_installation_selflow_c/getItem_list',
        data: { component_id: component_id },
        success: function(serialResponse) 
        {
            serialResponse = JSON.parse(serialResponse);
            console.log(serialResponse,'serialResponse');

            if (serialResponse.response_code == 200 && serialResponse.data.length > 0) {
                let selectOptions = '';
                $.each(serialResponse.data, function(j, serial) {
                    selectOptions += `<option value="${serial.tag_number}">${serial.tag_number}</option>`;
                });
                for (let q = 1; q <= quantity_required; q++) {
                    $(`#${serialNumbersRowId}`).append(
                        `<div class="form-group col-md-3">
                            <label>${component_name} ${q}</label>
                            <select name="tag_number[]" 
                                class="form-control select2 serial-number-dropdown" 
                                data-component-id="${component_id}">
                                <option value="">Select</option>
                                ${selectOptions}
                            </select>
                             <input type="hidden" name="component_id[]" value="${component_id}">
                        </div>`
                    );
                }
            } else {
                for (let q = 1; q <= quantity_required; q++) {
                    $(`#${serialNumbersRowId}`).append(
                        `<div class="form-group col-md-4">
                            <label>${component_name} Serial Number ${q}</label>
                            <select name="tag_number[]" 
                                    class="form-control select2 serial-number-dropdown" 
                                data-component-id="${component_id}" disabled>
                                <option value="">No Data Found</option>
                            </select>
                        </div>`
                    );
                }
            }

            $('.select2').select2();
            validateSerialNumbers();
        },
        error: function() {
            console.error("Failed to fetch serial numbers.");
        }
    });
}
    

function validateSerialNumbers() {
   
    $(document).on('change', '.serial-number-dropdown', function() {
        let selectedValues = [];
        let duplicateFound = false;
        let selectedElement = $(this); 
        $('.serial-number-dropdown').each(function() {
            let value = $(this).val();
            if (value) {
                selectedValues.push(value);
            }
        });
        let duplicates = selectedValues.filter((item, index) => selectedValues.indexOf(item) !== index);

        if (duplicates.length > 0) {
            swal({
                icon: 'error',
                title: 'Duplicate Serial Number',
                text: `Serial number "${duplicates[0]}" is already selected. Please choose another serial number.`
            }).then(() => {
                // Reset the current dropdown (unselect)
                selectedElement.val('').trigger('change'); // Reset the dropdown to default
            });
        }
    });
}



    function get_area_list()
    {  
       let company_id = "<?php echo $this->session->userdata('company_id') ?>";
       let user_id = "<?php echo $this->session->userdata('user_id') ?>";
       let assets_id = $('#assets_id').val();
       
       $.ajax({
            type: 'POST',
            url: '<?php echo base_url();?>Device_installation_selflow_c/get_area_list',
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
            url: '<?php echo base_url();?>Device_installation_selflow_c/getsite_list',
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
       let wellType = $("#well_type").val();

       $.ajax({
            type: 'POST',
            url: '<?php echo base_url();?>Device_installation_selflow_c/getWell_forinstallation_list',
            data:{company_id:company_id,user_id:user_id,assets_id:assets_id,area_id:area_id,site_id:site_id,wellType:wellType},
            success:function(data)
            {
                data = JSON.parse(data);
                console.log(data,'sdfsfs');
                if(data.response_code==200)
                {   
                    if(data.data.length>0)
                    {
                        $('#well_id').html('');
                        $('#well_id').html('<option value=" ">Select well</option>');
                        $.each(data.data,function(i,v){
  
                         $('#well_id').append('<option value="'+ v.id +'">'+v.well_name+'</option>');
                           
                            
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

        
    }
</script>

