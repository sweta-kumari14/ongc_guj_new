<div class="page-wrapper custome-name">
   <div class="content container-fluid" >

    <!-- Breadcrumb Start -->
    <div class="row" style=" margin-top: -24px;">

        <div class="col-12 px-0" style="margin-left: 17px;">
            <div class="d-flex justify-content-between align-items-center">
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent">
                        <li class="breadcrumb-item">
                            <a href="<?php echo base_url(); ?>">Home</a>
                        </li>
                        <li class="breadcrumb-item active m-0 p-0" aria-current="page">
                            Device/Tags Removal
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- Breadcrumb End -->

<div class="row justify-content-center" style="margin-top:10px;">
    <div class="col-12">
        <div class="card">
            <div class="card-header mb-0" style="padding:10px;">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="mb-1">Device/Tags Removal</h4>
                    </div>
                    <div class="col-auto ms-auto d-flex gap-2">
                        <a href="<?php echo base_url('Main_dashboard'); ?>" class="btn btn-sm btn-success motion-btn">
                            <i class="fas fa-arrow-left me-1" style="font-size: 12px;"></i> Back
                        </a>
                    </div>
                </div>
            </div>

            <hr class="mt-n1 mb-3">

            <div class="card-body pt-0">
                <form method="POST" class="row needs-validation" novalidate onsubmit="submitdata(event)">
                    <div class="row">
                        <div class="col-md-4 mt-2">
                            <label class="form-label">Well Name<sup class="text-danger">*</sup></label>
                            <select name="well_id" id="well_id" class="form-control select2" onchange="fetchInstalledItems();" required>
                                <option value="">Select Well</option>
                                <?php foreach ($well_list as $well): ?>
                                    <option value="<?= $well['well_id'] ?>"><?= $well['well_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">
                                Please select well!
                            </div>
                        </div>
                        <div class="col-md-4 mt-2">
                            <label class="form-label">Remove Type<sup class="text-danger">*</sup></label>
                            <select name="remove_type" id="remove_type" class="form-control select2" onchange="get_data();fetchInstalledItems();" required>
                                <option value="">Select Remove Type</option>
                                <option value="1">Device</option>
                                <option value="2">Component</option>
                                <option value="3">Both</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select removal type!
                            </div>
                        </div>

                        <!-- Device Section -->
                        <div id="device_section" class="mt-4" style="display: none;">
                           <label class="form-label"><b>Device</b><sup class="text-danger">*</sup></label>
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="remove_device_checkbox" name="remove_device_checkbox">
                                        <label class="form-check-label" for="remove_device_checkbox" id="device_label">
                                        </label>
                                    </div>
                                    <input type="hidden" class="form-control" id="remove_device_imei" name="remove_device_imei" readonly>
                                </div>
                                
                            </div>
                        </div>

                        <div id="component_section" class="mt-4" style="display: none;">
                             <label class="form-label"><b>Components</b><sup class="text-danger">*</sup></label>
                            <div id="component_checkboxes" class="row"></div> <!-- Important -->
                        </div>
                    </div>
                    <hr class="mt-3">
                    <div class="text-end">
                        <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function get_data()
    {
        var remove_type = $('#remove_type').val();
        if(remove_type == 1)
        {
            $('#device_section').show();
            $('#component_section').hide();

        }else if(remove_type == 2)
        {
            $('#device_section').hide();
            $('#component_section').show();

        }else if(remove_type == 3)
        {
           $('#device_section').show();
           $('#component_section').show();
        }else{
            $('#device_section').hide();
            $('#component_section').hide();
        }

    }
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function fetchInstalledItems() {
    let well_id = $('#well_id').val();
    let remove_type = $('#remove_type').val();

    // Clear previous data
    $('#device_section, #component_section').hide();
    $('#device_label').text('');
    $('#remove_device_checkbox').val('');
    $('#component_checkboxes').html('');

    if (well_id == '' || remove_type == '') {
        return;
    }

    $.ajax({
        url: "<?php echo base_url('Removal_c/get_installed_detilas'); ?>",
        method: "POST",
        data: { well_id: well_id, remove_type: remove_type },
        dataType: "json",
        success: function (response) 
        {
            console.log(response,'sdfhsfj');
            if (response && response.data) {
               if (response.data.device && response.data.device.length > 0) {
                let device = response.data.device[0]; 
                $('#device_section').show();

                if (!device.device_name || !device.imei_no) {
                    $('#device_label').html(`<span style="color:red;">Already device removed</span>`);
                    $('#remove_device_checkbox').prop('disabled', true).prop('checked', false);
                    $('#remove_device_imei').val('');
                } else {
                    $('#device_label').text(`${device.device_name}`);
                    $('#remove_device_checkbox').val(device.device_name);
                    $('#remove_device_checkbox').prop('disabled', false);
                    $('#remove_device_imei').val(device.imei_no);
                }
            }


                if (response.data.component && response.data.component.length > 0) {
                    $('#component_section').show();
                    response.data.component.forEach(function (comp, index) {
                        $('#component_checkboxes').append(`
                            <div class="col-md-4 mt-2"> <!-- 3 per row -->
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" 
                                           name="remove_components[]" 
                                           value="${comp.sensor_no}" 
                                           data-component-id="${comp.component_id}"
                                           id="comp_${index}">
                                    <label class="form-check-label" for="comp_${index}">
                                        ${comp.component_name} - ${comp.sensor_no}
                                    </label>
                                </div>
                            </div>
                        `);

                    });
                }
            } else {
                toastr.warning('No installed items found for the selected well.');
            }
        },
        error: function () {
            toastr.error('Failed to fetch installed items.');
        }
    });
}
function submitdata(e) {
    e.preventDefault();

    let well_id = $('#well_id').val();
    let remove_type = $('#remove_type').val();

    let is_device_checked = $('#remove_device_checkbox').is(':checked');
    let device_name = is_device_checked ? $('#remove_device_checkbox').val() : '';
    let imei_no = is_device_checked ? $('#remove_device_imei').val() : '';

    let tag_data = [];

    $('input[name="remove_components[]"]:checked').each(function () {
        let labelText = $(`label[for="${$(this).attr('id')}"]`).text();
        let parts = labelText.split(" - ");
        let sensor_no = parts[1].trim();
        let component_id = $(this).data("component-id");

        tag_data.push({
            component_id: component_id,
            tag_number: sensor_no
        });
    });

    if (!is_device_checked && tag_data.length === 0) {
        Swal.fire({
            icon: 'error',
            title: 'Oops!',
            text: 'Please select at least a device or one component.'
        });
        return;
    }

    let removalTypeMsg = '';
    if (remove_type == '1') {
        removalTypeMsg = 'Device';
    } else if (remove_type == '2') {
        removalTypeMsg = 'Tag';
    } else if (remove_type == '3') {
        removalTypeMsg = 'Device and Tag';
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Invalid Selection',
            text: 'Invalid removal type.'
        });
        return;
    }

    Swal.fire({
        title: `Are you sure you want to remove ${removalTypeMsg}?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, Remove it!',
        cancelButtonText: 'No, Cancel',
        dangerMode: true
    }).then((result) => {
        if (result.isConfirmed) {
            let formData = {
                well_id: well_id,
                removal_type: remove_type,
                device_name: device_name,
                imei_no: imei_no,
                tag_data: JSON.stringify(tag_data)
            };

            $.ajax({
                url: "<?php echo base_url('Removal_c/removal_data'); ?>",
                method: "POST",
                data: formData,
                success: (res) => {
                    let resp = JSON.parse(res);
                    console.log(resp, 'device_section');

                    if (resp.response_code == 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: resp.msg,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = "<?php echo base_url('Removal_c'); ?>";
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: resp.msg
                        });
                    }
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed!',
                        text: 'Failed to submit removal data.'
                    });
                }
            });
        } else {
            Swal.fire("Cancelled", "Remove operation cancelled", "info");
        }
    });
}

</script>


