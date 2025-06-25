<style type="text/css">
.readonly-gray {
    background-color: #e0e0e0 !important;
    color: #000 !important;
}
</style>
<div class="page-wrapper">
    <div class="content container-fluid pb-0">
<div class="container-xxl">

<div class="row justify-content-center">
    <div class="col-12">
        <div class="card">
            <div class="card-header mb-0" style="padding: 9px;">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="mb-1">Re-installation</h4>
                    </div>
                    <div class="col-auto ms-auto d-flex gap-2">
                        <a href="<?php echo base_url('Main_dashboard'); ?>" class="btn btn-sm btn-success motion-btn">
                            <i class="fas fa-arrow-left me-1" style="font-size: 12px;"></i> Back
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body pt-0">
                <form method="POST" class="row needs-validation" novalidate onsubmit="submitdata(event)">
                    <div class="row">
                        <div class="col-md-4 mt-2">
                            <label class="form-label">Well Name<sup class="text-danger">*</sup></label>
                            <select name="well_id" id="well_id" class="form-control select2" onchange="get_well_data();fetchInstalledItems();get_device_list();get_well_formula_list();" required>
                                <option value="">Select Well</option>
                               <?php 
                                if (!empty($well_list))
                                    {
                                        foreach ($well_list as $key => $value)
                                        {
                                            ?>
                                                <option value="<?php echo $value['well_id'] . '|' . $value['well_type'] . '|' . $value['well_type_name'].'|' .$value['device_name'] .'|' .$value['imei_no']; ?>">
                                                      <?php echo $value['well_name']; ?>
                                                   </option>

                                            <?php
                                        }
                                    }
                                ?>
                            </select>
                            <div class="invalid-feedback">
                                Please select well!
                            </div>
                        </div>
                        <input type="hidden" name="hdn_well_id" id="hdn_well_id" class="form-control">
                        <input type="hidden" name="from_well_type" id="from_well_type" class="form-control">
                         <input type="hidden" name="hdn_imei_no" id="hdn_imei_no" class="form-control">
                          <input type="hidden" name="hdn_device_name" id="hdn_device_name" class="form-control">
                        
                        <div class="col-md-4 mt-2">
                            <label class="form-label">From Well Type<sup class="text-danger">*</sup></label>
                            <input type="text" class="form-control readonly-gray" name="hdn_from_well_type" id="hdn_from_well_type" readonly>

                        </div>

                        <div class="col-md-4 mt-2">
                            <label class="form-label">Re-installation Type<sup class="text-danger">*</sup></label>
                            <select name="reinstallation_type" id="reinstallation_type" class="form-control select2" onchange="get_data();fetchInstalledItems();" required>
                                <option value="">Select Re-installtion Type</option>
                                <option value="1">Device</option>
                                <option value="2">Component</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select re-installtion type!
                            </div>
                        </div>
                        <!-- Device Section -->
                        <div id="device_section" class="mt-4" style="display: none;">
                           <label class="form-label"><b>Device</b><sup class="text-danger">*</sup></label>
                                <div class="col-md-4">
                                   <select name="new_device_name" id="new_device_name" class="form-control select2" style="width:100%" onchange="get_deviceImei();">
                                   </select>
                                </div>
                        </div>

                        <div id="component_section" class="mt-4" style="display: none;">
                             <label class="form-label"><b>Components</b><sup class="text-danger">*</sup></label>
                           <div id="well_type_formula"></div> 
                        </div>
                    </div>
                    <div class="mt-3">
                    <div class="text-end">
                        <button type="submit" class="btn btn-sm btn-danger">Submit</button>
                    </div>
                </form>
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
<script>
    function get_well_data()
    {
       let dataset = $('#well_id').val();
       let data = dataset.split("|");
       $('#hdn_well_id').val(data[0]);
       $('#from_well_type').val(data[1]);
       $('#hdn_from_well_type').val(data[2]);
       $('#hdn_imei_no').val(data[4]);
       $('#hdn_device_name').val(data[3]);

    }
    function get_data()
    {
        var reinstallation_type = $('#reinstallation_type').val();
        if(reinstallation_type == 1)
        {
            $('#device_section').show();
            $('#component_section').hide();
            

        }else if(reinstallation_type == 2)
        {
            $('#device_section').hide();
            $('#component_section').show();

        }else{
            $('#device_section').hide();
            $('#component_section').hide();
        }

    }
    function get_device_list() { 
        let user_id = $('#hdn_user_id').val();
        let imei_no_hdn = $('#hdn_imei_no').val();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url();?>Device_reinstalltion_c/device_list_ajax',
            data: {user_id: user_id },
            success: function(data) {
                data = JSON.parse(data);
                if (data.response_code == 200) {   
                    if (data.data.length > 0) {
                        $('#new_device_name').html('');
                        $('#new_device_name').html('<option value="">Select device</option>');
                   
                        let isPreselected = false;

                        $.each(data.data, function(i, v) {
                            let selected = (v.imei_no == imei_no_hdn) ? 'selected' : '';
                            let isDisabled = (v.imei_no == imei_no_hdn) ? 'disabled' : '';

                            if (selected !== '') isPreselected = true;

                            $('#new_device_name').append(
                                '<option value="' + v.imei_no +  '|' + v.device_name + '" ' + selected + ' ' + isDisabled + '>' + v.device_name + '</option>'
                            );
                        });

                        // Disable the entire dropdown if preselected
                        if (isPreselected) {
                            $('#new_device_name').prop('disabled', true).addClass('readonly-gray');
                        } else {
                            $('#new_device_name').prop('disabled', false).removeClass('readonly-gray');
                        }

                    } else {
                        $('#new_device_name').html('<option>No Data Found</option>');
                    }
                } else {
                    swal('error', data.msg, 'error');
                }
            }
        });
    }

        function get_deviceImei()
        {
            let oldDeviceValue = $("#new_device_name").val();
            let deviceName = $("#hdn_device_name").val();
            
            if (oldDeviceValue) {
                let deviceData = oldDeviceValue.split("|");
                // alert(deviceData[0]); 
                $("#hdn_imei_no").val(deviceData[0]);
                $("#hdn_device_name").val(deviceData[1]);
            }
        }
    function get_well_formula_list() {
        let well_type = $('#from_well_type').val();

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url();?>Device_reinstalltion_c/get_well_type_details_list',
            data: { well_type: well_type },
            success: function(data) {
                console.log(data,'sdnvfsdhf');
                data = JSON.parse(data);
                
                if (data.response_code == 200) {
                    if (data.data.length > 0) {
                        $('#well_type_formula').html(''); 
                        $.each(data.data, function(i, v) {
                            let serialNumbersRowId = `serial_numbers_${v.component_id}`;
                            $('#well_type_formula').append(`
                                <div class="col-md-12 mt-2 mb-2">
                                    <input type="checkbox" class="form-check-input component-checkbox"
                                           value="${v.component_id}|${v.quantity_required}|${v.component_name}" 
                                           id="checkbox_${v.component_id}" 
                                           onchange="get_item_data(${v.component_id}, ${v.quantity_required}, '${v.component_name}', '${serialNumbersRowId}');">
                                    <label class="form-check-label" for="checkbox_${v.component_id}">
                                        ${v.component_name} | ${v.quantity_required}
                                    </label>
                                </div>
                                <div id="${serialNumbersRowId}" class="row"></div>
                            `);

                        });
                    } else {
                        $('#well_type_formula').html('<p>No Data Found</p>');
                    }
                } else {
                    swal('error', data.msg, 'error');
                }
            }
        });
    }
let installedTagMap = {};

function fetchInstalledItems() {
    let well_id = $('#hdn_well_id').val();
    let remove_type = '2';

    $.ajax({
        url: "<?php echo base_url('Removal_c/get_installed_detilas'); ?>",
        method: "POST",
        data: { well_id: well_id, remove_type: remove_type },
        dataType: "json",
        success: function (response) {
            installedTagMap = {};

            if (response.data && response.data.component && response.data.component.length > 0) {
                response.data.component.forEach(item => {
                    const compId = item.component_id;
                    const tag = item.sensor_no;

                    if (!installedTagMap[compId]) {
                        installedTagMap[compId] = [];
                    }
                    installedTagMap[compId].push(tag);
                });
            } 
        },
        error: function () {
            swal('warning','Failed to fetch installed items.','warning');
        }
    });
}

function get_item_data(componentid, quantity, component_name, serialNumbersRowId) {
    const checkbox = document.getElementById(`checkbox_${componentid}`);
    if (!checkbox || !checkbox.checked) {
        $(`#${serialNumbersRowId}`).html("");
        return;
    }

    let well_id = $("#hdn_well_id").val();

    $.ajax({
        type: "POST",
        url: "<?php echo base_url();?>Device_reinstalltion_c/item_list_ajax",
        data: { component_id: componentid, well_id: well_id },
        success: function (serialResponse) {
            serialResponse = JSON.parse(serialResponse);

            if (serialResponse.response_code === 200 && serialResponse.data.length > 0) {
                $(`#${serialNumbersRowId}`).html("");

                const preSelectedTags = installedTagMap[componentid] || [];

                for (let q = 1; q <= quantity; q++) {
                    const selectId = `${componentid}_${q}`;
                    const selectName = `${componentid}_${q}`;
                    const preSelectedTag = preSelectedTags[q - 1] || '';
                    const disableSelect = preSelectedTag !== '';

                    // Collect other selected tags
                    let alreadySelectedTags = [];
                    $('.serial-number-dropdown').each(function () {
                        const val = $(this).val();
                        const id = $(this).attr('id');
                        if (val && !$(this).prop('disabled') && id !== selectId) {
                            alreadySelectedTags.push(val);
                        }
                    });

                    // Add other pre-selected tags of same component (excluding current index)
                    preSelectedTags.forEach((tag, idx) => {
                        if (idx !== (q - 1) && tag) {
                            alreadySelectedTags.push(tag);
                        }
                    });

                    // Build dropdown options
                    let options = '<option value="">Select</option>';
                    serialResponse.data.forEach(serial => {
                        const tag = serial.tag_number;
                        if (tag === preSelectedTag || !alreadySelectedTags.includes(tag)) {
                            const selected = tag === preSelectedTag ? 'selected' : '';
                            options += `<option value="${tag}" ${selected}>${tag}</option>`;
                        }
                    });

                    // Create select element
                    const $select = $(`
                        <select name="${selectName}"
                                id="${selectId}"
                                class="form-control select2 serial-number-dropdown"
                                data-component-id="${componentid}">
                            ${options}
                        </select>
                    `);

                    if (disableSelect) {
                        $select.prop('disabled', true).addClass('readonly-gray');
                    }

                    // Append label + dropdown
                    $(`#${serialNumbersRowId}`).append(`
                        <div class="form-group col-md-3">
                            <label>${component_name} ${q}</label>
                        </div>
                    `);
                    $(`#${serialNumbersRowId} .form-group:last-child`).append($select);
                    $select.select2();
                }

                validateSerialNumbers();
            } else {
                $(`#${serialNumbersRowId}`).html("<p>No Serial Numbers Found</p>");
            }
        }
    });
}


function validateSerialNumbers() {
    $(document).on('change', '.serial-number-dropdown', function () {
        let selectedValues = [];
        let selectedElement = $(this);

        $('.serial-number-dropdown').each(function () {
            let value = $(this).val();
            if (value) selectedValues.push(value);
        });

        let duplicates = selectedValues.filter((item, index) => selectedValues.indexOf(item) !== index);

        if (duplicates.length > 0) {
            swal('warning',`Serial number "${duplicates[0]}" is already selected. Please choose another serial number.`, 'Duplicate Serial Number','warning');
            selectedElement.val('').trigger('change');
        }
    });
}

let originalDeviceName, originalImeiNo;
$(document).ready(function() {
    originalDeviceName = $('#hdn_device_name').val();
    originalImeiNo = $('#hdn_imei_no').val();
});
function submitdata(e) {
    e.preventDefault();

    let well_id = $('#hdn_well_id').val();
    let device_name = $('#hdn_device_name').val();
    let imei_no = $('#hdn_imei_no').val();
    let from_well_type = $('#from_well_type').val();
    let reinstallation_type = $('#reinstallation_type').val();
    

    if (!well_id || !from_well_type || !reinstallation_type) {
        toastr.error("All field are required.");
        return;
    }

    let tag_data = [];
    let selectedValues = [];
    let isValid = true;

    $('.serial-number-dropdown').each(function () {
        if ($(this).prop('disabled')) return; // skip preselected/disabled dropdowns

        let tag_number = $(this).val();
        let component_id = $(this).data('component-id');
        let elementId = $(this).attr('id');
        let tagIndex = parseInt(elementId.split('_')[1]) - 1;

        if (!tag_number) {
            swal('warning',"Please select all serial numbers before submitting.",'warning');
            isValid = false;
            return false;
        }

        if (selectedValues.includes(tag_number)) {
            swal('warning',`Duplicate serial number "${tag_number}" selected. Please choose unique serial numbers.`,'warning');
            isValid = false;
            return false;
        }

        selectedValues.push(tag_number);

        // Compare with installed tag
        let existingTag = installedTagMap[component_id] ? installedTagMap[component_id][tagIndex] : '';
        if (existingTag !== tag_number) {
            // Only push if changed
            tag_data.push({
                component_id: component_id,
                tag_number: tag_number
            });
        }
    });

    if (!isValid) return;

    if (tag_data.length === 0 && device_name === originalDeviceName && imei_no === originalImeiNo) {
        swal('warning',"No changes detected in serial numbers or device info.",'warning');
        return;
    }

    let submitData = {
        well_id: well_id,
        reinstallation_type:reinstallation_type,
        tag_data: JSON.stringify(tag_data)
    };

    if (device_name !== originalDeviceName) {
        submitData.device_name = device_name;
    }
    if (imei_no !== originalImeiNo) {
        submitData.imei_no = imei_no;
    }
    console.log(submitData,'form-data');
    swal({
        title: `Are you sure you want to Re-installtion?`,
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willSubmit) => {
        if (willSubmit) {
            $.ajax({
                url: "<?php echo base_url('Device_reinstalltion_c/save_reinstalltion_data'); ?>",
                method: "POST",
                data: submitData,
                success: function (res) {
                    let resp = JSON.parse(res);

                    if (resp.response_code == 200) {
                        swal('success',resp.msg,'success');
                        setTimeout(() => {
                            window.location.href = "<?php echo base_url('Device_reinstalltion_c'); ?>";
                        }, 2000);
                    } else {
                        swal('error',resp.msg,'error');
                         setTimeout(() => {
                            window.location.href = "<?php echo base_url('Device_reinstalltion_c'); ?>";
                        }, 2000);
                    }
                },
                error: function () {
                    swal('warning','Failed to submit well type change.','warning');
                }
            });
        } else {
            toastr.info("Well Re-installtion Cancelled");
             setTimeout(() => {
                window.location.href = "<?php echo base_url('Device_reinstalltion_c'); ?>";
            }, 2000);
        }
    });
}

</script>