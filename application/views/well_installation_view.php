
<div class="page-wrapper">
<div class="container-xxl">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header mb-0" style="padding: 10px;">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="mb-1">Selfflow-Installation</h4>
                        </div>
                        <div class="col-auto ms-auto d-flex gap-2">
                             <a href="<?php echo base_url('Main_dashboard'); ?>" class="btn btn-sm btn-success motion-btn">
                              <i class="fas fa-arrow-left me-1" style="font-size: 12px;"></i> Back
                            </a>

                        </div>
                    </div>
                </div>

                    <div class="card-body pt-1">                    
                        <form id="deviceInstallForm" method="POST" 
                          action="" enctype="multipart/form-data" class="needs-validation" novalidate>
                        <div class="row">
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
                                                <option value="<?php echo $value['device_name'].'|'.$value['imei_no']; ?>"><?php echo $value['device_name'].'|'.$value['imei_no']; ?></option>

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
                                <label class="form-label">Well Name<sup class="text-danger">*</sup></label>
                                <select name="well_id[]" id="well_id" class="form-control select2" multiple required onchange="get_well_formula_list()">
                                    <option value="">Select Well</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please select well!
                                </div>
                            </div>
                            
                        </div>
                        <div class="form-group col-md-12 mt-2">
                            <label class="form-label">Well-wise Sensor Mapping & Image<sup class="text-danger">*</sup></label>
                            <div id="well_blocks" class="row g-2"></div>
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
function get_device_data()
{
    var device_data = $('#device_name').val();
    $('#device_name_hdn').val(device_data.split("|")[0]);
    $('#imei_no_hdn').val(device_data.split("|")[1]);

    
}
</script>
<script type="text/javascript">
    let wellFormulaByType = {};   
    let renderedWells     = {};   

    $(document).ready(function () {
        get_well_list();
        validateSerialNumbers(); // bind once
    });

    // 1) Well list load from backend
    function get_well_list() {
        let company_id = "<?php echo $this->session->userdata('company_id') ?>";
        let user_id    = "<?php echo $this->session->userdata('user_id') ?>";

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url();?>Device_installation_selflow_c/getWell_forinstallation_list',
            data: { company_id: company_id, user_id: user_id },
            success: function (data) {
                data = JSON.parse(data);
                console.log("well_list", data);

                if (data.response_code == 200) {
                    if (data.data.length > 0) {
                        $('#well_id').html('');
                        $('#well_id').html('<option value="">Select well</option>');
                        $.each(data.data, function (i, v) {
                            $('#well_id').append(
                                '<option value="' + v.well_id + '" ' +
                                ' data-well-type-id="' + v.well_type + '" ' +
                                ' data-well-type-name="' + v.well_type_name + '">' +
                                v.well_name + ' (' + v.well_type_name + ')' +
                                '</option>'
                            );
                        });
                    } else {
                        $('#well_id').html('<option value="">No Data Found</option>');
                    }
                } else {
                    swal('error', data.msg, 'error');
                }

                $('#well_id').select2();
            }
        });
    }

    // 2) Well selection change (multiple support)
    function get_well_formula_list() {
        const $selectedOptions = $('#well_id option:selected');



        $('#well_type_formula').html('');

        if ($selectedOptions.length === 0) {
            // agar user ne sab wells hata diye
            $('#well_blocks').html('<p class="mt-2 text-danger">Please select at least one well.</p>');
            renderedWells = {};
            return;
        }

        // Distinct well_type_id list
        let typeMap          = {}; // typeId -> typeName
        let typeIdsToLoad    = []; // sirf naye types ke liye AJAX

        $selectedOptions.each(function () {
            const tId   = $(this).data('well-type-id');
            const tName = $(this).data('well-type-name');
            if (tId) {
                typeMap[tId] = tName;
                // agar is type ka formula abhi tak load nahi hua hai to hi AJAX karo
                if (!wellFormulaByType[tId]) {
                    typeIdsToLoad.push(tId);
                }
            }
        });

        const uniqueTypeIdsToLoad = [...new Set(typeIdsToLoad)];

        if (uniqueTypeIdsToLoad.length === 0) {
            // sab type ka formula already loaded hai, direct blocks render karo
            renderWellBlocks(typeMap);
            return;
        }

        let pending = uniqueTypeIdsToLoad.length;

        uniqueTypeIdsToLoad.forEach(function (typeId) {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url();?>Device_installation_selflow_c/get_well_type_details_list',
                data: { well_type: typeId },
                success: function (data) {
                    data = JSON.parse(data);
                    console.log("well_type_details_list for type " + typeId, data);

                    if (data.response_code == 200 && data.data.length > 0) {
                        wellFormulaByType[typeId] = data.data;
                    } else {
                        wellFormulaByType[typeId] = []; // no formula
                    }
                },
                error: function () {
                    console.error("Failed to load formula for type ", typeId);
                    wellFormulaByType[typeId] = [];
                },
                complete: function () {
                    pending--;
                    if (pending === 0) {
                        // saare naye type load ho gaye, ab blocks render karo
                        renderWellBlocks(typeMap);
                    }
                }
            });
        });
    }

    // 3) Well-wise blocks render (existing data preserve)
    function renderWellBlocks(typeMap) {
        let selectedWells = $('#well_id').val() || [];

        // alert(selectedWells);
        let $container    = $('#well_blocks');

        if (selectedWells.length === 0) {
            $container.html('<p class="mt-2 text-danger">Please select at least one well.</p>');
            renderedWells = {};
            return;
        }

        // Well info map: id -> details
        let wellInfoMap = {};
        $('#well_id option').each(function () {
            let id       = $(this).val();
            let name     = $(this).text();
            let typeId   = $(this).data('well-type-id');
            let typeName = $(this).data('well-type-name') || '';
            if (id) {
                wellInfoMap[id] = {
                    name: name,
                    typeId: typeId,
                    typeName: typeName
                };
            }
        });

        // (a) Jo wells pehle render the but ab unselect ho gaye, unke blocks remove karo
        Object.keys(renderedWells).forEach(function (oldWellId) {
            if (!selectedWells.includes(oldWellId)) {
                $('#well_block_' + oldWellId).remove();
                delete renderedWells[oldWellId];
            }
        });

        // (b) Har selected well ke liye, agar block nahi bana hai to naya banaye
        selectedWells.forEach(function (wellId) {
            if (renderedWells[wellId]) {
                // pehle se bana hua hai, touch mat karo (data safe rahega)
                return;
            }

            let info      = wellInfoMap[wellId] || {};
            let wellName  = info.name || ('Well ID ' + wellId);
            let typeId    = info.typeId;
            let typeName  = info.typeName ? ` <span class="badge bg-light text-dark border ms-1">${info.typeName}</span>` : '';
            let blockId   = 'well_block_' + wellId;
            let formulaContainerId = 'well_formula_' + wellId;

            let blockHtml = `
                <div class="col-md-6">
                  <div class="border rounded p-2 mb-2 well-row" id="well_block_${wellId}">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                      <div>
                        <strong>Well- ${wellName}</strong>${typeName}
                        <input type="hidden" class="well_id" name="wells[${wellId}][well_id]" value="${wellId}">
                        <input type="hidden" class="well_type" name="wells[${wellId}][well_type]" value="${typeId}">
                      </div>
                    </div>

                    <div class="row mb-2">
                      <div class="form-group col-md-8">
                        <label>Well Image</label>
                        <input type="file"
                             name="wells[${wellId}][image]"
                             class="form-control"
                             accept=".jpg,.png,.jpeg">
                      </div>
                    </div>

                    <div>
                      <label class="form-label mb-1">Components</label>
                      <div class="row" id="${formulaContainerId}">
                      </div>
                    </div>
                  </div>
                </div>
            `;

            $container.append(blockHtml);

            // is well ke type ka formula lo
            const formula = wellFormulaByType[typeId] || [];
            let $formulaContainer = $('#' + formulaContainerId);

           if (formula.length === 0) {
            $formulaContainer.append(
                `<div class="col-12 mt-1 text-danger">
                    Formula not setup for this well type.
                 </div>`
            );
        } else {
            formula.forEach(function (v) {
                let serialRowId = `serial_numbers_w${wellId}_c${v.component_id}`;
                $formulaContainer.append(`
            <div class="col-md-6 mt-1">
              
                    <div class="d-flex align-items-center">
                        <input type="checkbox" class="form-check-input me-2"
                           value="${v.component_id}|${v.quantity_required}|${v.component_name}"
                           id="checkbox_w${wellId}_c${v.component_id}" 
                           onchange="toggle_item_fields(this, ${v.component_id}, ${v.quantity_required}, '${v.component_name}', '${serialRowId}', '${wellId}');"
                           checked
                           onclick="return false;">

                        <label class="form-check-label" for="checkbox_w${wellId}_c${v.component_id}">
                            ${v.component_name}
                        </label>
                    </div>
               
                <div id="${serialRowId}" class="row"></div>
            </div>
        `);

            });

            // 👇 Yahi par sab components ke liye fields by default open kara rahe hain
            formula.forEach(function (v) {
                let cbId          = `checkbox_w${wellId}_c${v.component_id}`;
                let serialRowId   = `serial_numbers_w${wellId}_c${v.component_id}`;
                let checkboxElem  = document.getElementById(cbId);
                if (checkboxElem) {
                    toggle_item_fields(
                        checkboxElem,
                        v.component_id,
                        v.quantity_required,
                        v.component_name,
                        serialRowId,
                        wellId
                    );
                }
            });
        }


            renderedWells[wellId] = true;
        });

        $('.select2').select2();
    }

    // 4) Checkbox change -> items load/remove
    function toggle_item_fields(checkboxElem, component_id, quantity_required, component_name, serialNumbersRowId, wellId) {
        let $container = $('#' + serialNumbersRowId);

        if (checkboxElem.checked) {
            $container.html('');
            get_item_list(component_id, quantity_required, component_name, serialNumbersRowId, wellId);
        } else {
            $container.html('');
        }
    }

function get_item_list(component_id, quantity_required, component_name, serialNumbersRowId, wellId) {

    // console.log(component_id,'component_id');
    // console.log(quantity_required,'quantity_required');
    //  console.log(component_name,'component_name');
    //  console.log(serialNumbersRowId,'serialNumbersRowId');
    //  console.log(wellId,'wellId');

    $.ajax({
        type: 'POST',
        url: '<?php echo base_url();?>Device_installation_selflow_c/getItem_list',
        data: { component_id: component_id },
        success: function (serialResponse) {
            serialResponse = JSON.parse(serialResponse);
            console.log('serialResponse', serialResponse);

            let $container = $('#' + serialNumbersRowId);
            $container.html('');

            if (serialResponse.response_code == 200 && serialResponse.data.length > 0) {
                let selectOptions = '';
                $.each(serialResponse.data, function (j, serial) {
                    selectOptions += `<option value="${serial.id}" data-tag="${serial.tag_number}">${serial.tag_number}</option>`;
                });

                for (let q = 1; q <= quantity_required; q++) {
                    $container.append(
                            `<div class="form-group col-md-12 mt-2 component-row">
                            <select name="wells[${wellId}][tag_number][]" 
                                    class="form-control select2 serial-number-dropdown" 
                                    data-component-id="${component_id}">
                                <option value="">Select</option>
                                ${selectOptions}
                            </select>
                            <input type="hidden" name="wells[${wellId}][component_id][]" value="${component_id}">
                          </div>
                        </div>`
                    );

                }
            } else {
                for (let q = 1; q <= quantity_required; q++) {
                    $container.append(
                        `<div class="form-group col-md-4 component-row">
                            <select name="wells[${wellId}][tag_number][]" 
                                    class="form-control select2 serial-number-dropdown" 
                                    data-component-id="${component_id}" disabled>
                                <option value="">No Data Found</option>
                            </select>
                            <input type="hidden" name="wells[${wellId}][component_id][]" value="${component_id}">
                        </div>`
                    );
                }
            }

            $('.select2').select2();
            validateSerialNumbers();          
            $('.serial-number-dropdown').trigger('change'); 
        },
        error: function () {
            console.error("Failed to fetch serial numbers.");
        }
    });
}
function validateSerialNumbers() {

    $(document).off('change', '.serial-number-dropdown');

    // Naya handler
    $(document).on('change', '.serial-number-dropdown', function () {
        let selectedMap = {};     // value -> true
        let selectedTags = {};    // value -> tag text (display)
        $('.serial-number-dropdown').each(function () {
            let val = $(this).val();
            if (val) {
                selectedMap[val] = true;
                let tagText = $(this).find('option:selected').data('tag');
                if (tagText) {
                    selectedTags[val] = tagText;
                }
            }
        });

        $('.serial-number-dropdown option').prop('disabled', false);
        $('.serial-number-dropdown').each(function () {
            let currentVal = $(this).val();
            $(this).find('option').each(function () {
                let optVal = $(this).attr('value');
                if (!optVal) return;  // "Select" / blank option skip

                if (selectedMap[optVal] && optVal !== currentVal) {
                  
                    $(this).prop('disabled', true);
                }
            });
        });
        let allSelected = [];
        $('.serial-number-dropdown').each(function () {
            let v = $(this).val();
            if (v) allSelected.push(v);
        });

        let duplicates = allSelected.filter((item, index) => allSelected.indexOf(item) !== index);

        if (duplicates.length > 0) {
            let duplicateValue = duplicates[0];
            let duplicateTag   = selectedTags[duplicateValue] || duplicateValue;

            swal({
                icon: 'error',
                title: 'Duplicate Serial Number',
                text: `Serial number "${duplicateTag}" is already selected. Please choose another serial number.`
            });
        }
    });

    // Initial run (agar pehle se kuch selected hai)
    setTimeout(function () {
        $('.serial-number-dropdown').trigger('change');
    }, 0);
}
</script>
<script type="text/javascript">
    $('#deviceInstallForm').on('submit', function(e) {
    e.preventDefault();

    swal({
        title: 'Are you sure?',
        text: "Do you want to install this device?",
        icon: 'warning',
        buttons: true,
        dangerMode: true
    }).then(async (isConfirmed) => {
        if (!isConfirmed) return;

        const wells = [];
        const promises = [];

        $('.well-row').each(function(i, row) {
            const well_id = $(row).find('.well_id').val();
            const well_type_id = $(row).find('.well_type').val();

            const components = [];
            $(row).find('.component-row').each(function(j, comp) {
                const compId = $(comp).find('input[name*="[component_id]"]').val();
                const tagNo  = $(comp).find('select[name*="[tag_number]"]').val();
                if (compId && tagNo) {
                    components.push({ component_id: compId, tag_number: tagNo });
                }
            });

            const imageInput = $(row).find('input[type="file"]')[0];
            let imagePromise = Promise.resolve(""); 

            if (imageInput && imageInput.files.length > 0) {
                imagePromise = new Promise((resolve, reject) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        resolve(e.target.result.split(',')[1]);
                    };
                    reader.onerror = reject;
                    reader.readAsDataURL(imageInput.files[0]);
                });
            }

            promises.push(
                imagePromise.then(imageBase64 => {
                    wells.push({ well_id, well_type_id, components, image: imageBase64 });
                })
            );
        });

        await Promise.all(promises);

        const formData = new FormData();
        formData.append('wells', JSON.stringify(wells));
        formData.append('device_name_hdn', $('#device_name_hdn').val());
        formData.append('imei_no_hdn', $('#imei_no_hdn').val());
        formData.append('sim_no', $('#sim_no').val());
        formData.append('sim_provider', $('#sim_provider').val());
        formData.append('network_type', $('#network_type').val());
        formData.append('lat_hdn', $('#lat_hdn').val());
        formData.append('long_hdn', $('#long_hdn').val());

        console.log("Sending Data:", wells);

        $.ajax({
            url: "<?php echo base_url('Device_installation_selflow_c/Device_install'); ?>",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            beforeSend: function() {
                $('#submitBtn').prop('disabled', true).text('Processing...');
            },
            success: function(res) {
                $('#submitBtn').prop('disabled', false).text('Submit');

                if (res.response_code == 200) {

                    let imei = $('#imei_no_hdn').val();
                    let nextUrl = "<?php echo base_url('Device_configration_setup_c/index/'); ?>" + imei;

                    swal({
                        title: "Success",
                        text: "Device Installation done! Now you may proceed for Device Configuration.",
                        icon: "success",
                        button: "Go to Configuration"
                    }).then(() => {
                        window.location.href = nextUrl;
                    });

                    $('#deviceInstallForm')[0].reset();

                } else {
                    swal('Error', res.msg, 'error');
                }
            },
            error: function(err) {
                $('#submitBtn').prop('disabled', false).text('Submit');
                swal('Error', 'Something went wrong', 'error');
            }
        });

    });
});
</script>

