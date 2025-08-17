<div class="page-wrapper">
    <div class="content container-fluid pb-0">
        <div class="page-header">
            <div class="content-page-header">
                <h5>Threshold Setup</h5>
            </div>  
        </div>
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-body pt-1">
                    <form class="custom-validation" method="POST" enctype="multipart/form-data">

                    <div class="row">
                        
                        <div class="form-group col-md-3 mt-2">
                            <label for="report_view" class="form-label"><b>View Setup</b></label>
                            <select name="threshold_type" id="threshold_type" class="form-control select2" onchange="get_view();" style="width: 100%;">
                                <option value="">Select Setup</option>
                                <option value="2">Well Wise</option>
                                <option value="1">Area Wise</option>
                            </select>
                        </div>

                        <div class="form-group col-md-3 mt-2" id="area_wise" style="display: none;">
                            <label for="inline_area_select" class="form-label">Area</label>
                            <select name="area_id" id="area_id" class="form-control select2" onchange="get_site_list();get_well_list();get_multplewell_list();" style="width: 100%;">
                                <?php
                                    if (!empty($area_list)) {
                                        echo '<option value="">Select All</option>';
                                        foreach ($area_list as $value) {
                                            echo '<option value="' . $value['id'] . '">' . $value['area_name'] . '</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                         <div class="form-group col-md-3 mt-2" id="site_wise" style="display: none;">
                            <label class="form-label">Site</label>
                            <select name="site_id" id="site_id" class="form-control select2" onchange="get_well_list();get_multplewell_list();" style="width:100%">
                            </select>
                        </div>

                        <div class="form-group col-md-3 mt-2" id="well_wise" style="display: none;">
                            <label for="inline_well_name" class="form-label">Well Name</label>
                            <select name="well_id" id="well_id" class="form-control select2" style="width: 100%;" onchange="get_last_thereshold_value();get_tag_list();"> 
                            </select>
                        </div>

                                <div class="form-group col-md-3 mt-2" id="area_multiple_well" style="display: none;">
                                    <label for="well" class="form-label">Select Wells</label>
                                    <select name="well_ids[]" id="well_ids" class="form-control select2" multiple="multiple" style="width: 100%;" onchange="get_group_well_tag_list();">
                                    </select>
                                </div>
                            <div class="mt-2 mb-2" id="add_btns_area" style="display:none;">
                                <button type="button" class="btn btn-sm btn-primary" onclick="addPressurePointRow()">+ Add</button>
                                
                            </div>
                              <div class="mt-2" id="add_btns_well" style="display:none;">
                                <button type="button" class="btn btn-sm btn-success" onclick="addNewRow();"> Addd well</button>
                              </div>

                            <div id="thresholdFields" style="display: none;">
                                <div id="pressurePointContainer" class="row mt-2"></div>

                               
                             </div>
                             <div id="wellWiseThresholdContainer" style="display:none;"></div>
                         </div>
                       
                            <div class="mt-4 mb-2 d-flex justify-content-end">
                                <button type="button" class="btn btn-sm btn-success" onclick="threshold_data_submit();">Submit</button>
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
function get_view() {
    var threshold_type = $('#threshold_type').val();

    $('#site_id').html('<option value="">Select Site</option>');
    $('#well_id').html('<option value="">Select Well</option>');
    $('#well_ids').html('<option value="">Select Well</option>');

    $('#pressurePointContainer').html('');
    $('#wellWiseThresholdContainer').html('');

    if (threshold_type == '1') {
        
        $('#area_wise, #site_wise, #area_multiple_well, #thresholdFields, #wellWiseThresholdContainer,#submit_btns,#add_btns_area').show();
        $('#well_wise,#add_btns_well').hide();
    } else if (threshold_type == '2') {
        
        $('#area_wise, #site_wise, #well_wise, #thresholdFields, #submit_btns,#add_btns_well').show();
        $('#area_multiple_well, #wellWiseThresholdContainer,#add_btns_area').hide();
    } else {
        
        $('#area_wise, #site_wise, #well_wise, #thresholdFields, #area_multiple_well, #wellWiseThresholdContainer, #add_btns, #submit_btns,#add_btns_well,#add_btns_area').hide();
    }

    get_site_list();
    get_well_list();
    get_multplewell_list();
}


    function get_site_list()
    { 
       let company_id = "<?php echo $this->session->userdata('company_id') ?>";
       let area_id = $('#area_id').val();
       
       $.ajax({
            type: 'POST',
            url: '<?php echo base_url();?>Threshold_setup_selfflow_c/getsite_list',
            data:{company_id:company_id,area_id:area_id},
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
  
                        $('#site_id').append('<option value="'+v.id+'">'+v.well_site_name+'</option>');
                           
                            
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
        let area_id = $('#area_id').val();
        let site_id = $('#site_id').val();
       
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url();?>Threshold_setup_selfflow_c/getWell_forinstallation_list',
            data:{company_id:company_id,area_id:area_id,site_id:site_id},
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
  
                         $('#well_id').append('<option value="'+ v.well_id +'">'+v.well_name+'</option>');
                           
                            
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
     get_multplewell_list();
    function get_multplewell_list() {
    let company_id = "<?php echo $this->session->userdata('company_id') ?>";
    let area_id = $('#area_id').val();
    let site_id = $('#site_id').val();

    $.ajax({
        type: 'POST',
        url: '<?php echo base_url();?>Threshold_setup_selfflow_c/getWell_forinstallation_list',
        data: { company_id: company_id, area_id: area_id, site_id: site_id },
        success: function(data) {
            data = JSON.parse(data);
            console.log(data, 'well list');

            if (data.response_code == 200) {
                if (data.data.length > 0) {
                    $('#well_ids').html('');
                    $('#well_ids').append('<option value="">Select well</option>');
                    $.each(data.data, function(i, v) {
                        $('#well_ids').append('<option value="' + v.well_id + '">' + v.well_name + '</option>');
                    });
                } else {
                    $('#well_ids').html('<option>No Data Found</option>');
                }
            } else {
                swal('Error', data.msg, 'error');
            }
        }
    });
}
$('#area_id').on('change', function () {
    get_site_list();
});
$('#site_id').on('change', function () {
    get_well_list();
    get_multplewell_list(); 
});
$('#area_id, #site_id').on('change', function () {
    $('#pressurePointContainer').html('');
    $('#wellWiseThresholdContainer').html('');
});
</script>
<script type="text/javascript">
let counter = 0;
const pressureTypes = ["CHP", "ABP", "FLT", "THP"];
let lastThresholdData = [];
function get_last_thereshold_value() {
    let well_id = $('#well_id').val();
     if (!well_id) {
        $('#pressurePointContainer').html('');
        return;
    }

    $.ajax({
        url: '<?= base_url(); ?>Threshold_setup_selfflow_c/get_well_last_details',
        type: 'POST',
        data: { well_id: well_id },
        success: function (res) {
            res = JSON.parse(res);
            if (res.response_code == 200 && res.data.length > 0) {
                lastThresholdData = res.data;
                

                res.data.forEach(item => {
                    addNewRow(item);  // pass item to prefill
                });
            }else{
                 $('#pressurePointContainer').html(''); 

            }
        }
    });
}

function get_tag_list(selectElement, preselected = null) {
    let well_id = $('#well_id').val();
    if (!well_id) {
        $(selectElement).html('<option value="">Select Well First</option>');
        return;
    }

    $.ajax({
        type: 'POST',
        url: '<?= base_url(); ?>Threshold_setup_selfflow_c/get_tag_list',
        data: { well_id },
        success: function (response) {
            var response = JSON.parse(response);
            if (response.response_code == 200) {
                const tagList = response.data;
                let options = '<option value="">Select Tag</option>';
                tagList.forEach(tag => {
                    options += `<option value="${tag.tag_id}" ${preselected == tag.tag_id ? 'selected' : ''}>${tag.tag_number}</option>`;
                });
                $(selectElement).html(options).trigger('change');
            }
        }
    });
}

function addPressurePointRow() {
    let thresholdType = $('#threshold_type').val();

    if (thresholdType == '1') {
        $('#wellWiseThresholdContainer').html('').show(); // Show for Well Wise
        $('#pressurePointContainer').hide(); // Hide Area Wise container if it was open

        const selectedWells = $('#well_ids').select2('data');
        if (!selectedWells || selectedWells.length == 0) {
            swal('Warning', 'Select at least one well', 'warning');
            return;
        }

        selectedWells.forEach((well, index) => {
            const containerId = `well_container_${index}`;
            const html = `
                <div class="card p-2 mb-3 border border-primary" id="${containerId}">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>Well: ${well.text}</h5>
                        <input type="hidden" name="well_ids_grouped[]" value="${well.id}" />
                        <button class="btn btn-sm btn-success" type="button" onclick="addNewGroupedRow('${containerId}', '${well.id}')">+ Add Row</button>
                    </div>
                    <div class="row-group mt-2" id="group_${containerId}"></div>
                </div>`;
            $('#wellWiseThresholdContainer').append(html);
            getGroupedLastThresholdValue(containerId, well.id);
        });

    } else {
        $('#wellWiseThresholdContainer').html('').hide(); 
        $('#pressurePointContainer').show().html('');
        get_last_thereshold_value();
    }
}

function getGroupedLastThresholdValue(containerId, well_id) {
    $.ajax({
        url: '<?= base_url(); ?>Threshold_setup_selfflow_c/get_well_last_details',
        type: 'POST',
        data: { well_id },
        success: function (res) {
            res = JSON.parse(res);
            if (res.response_code == 200 && res.data.length > 0) {
                res.data.forEach(item => {
                    addNewGroupedRow(containerId, well_id, item);
                });
            }
        }
    });
}



function addNewRow(prefillData = null) {
    counter++;

    const nodeType = prefillData?.node_name || '';
    const selectedTag = prefillData?.tag_no || '';

    const options = pressureTypes.map(pt => {
        const selected = nodeType === pt ? 'selected' : '';
        return `<option value="${pt}" ${selected}>${pt}</option>`;
    }).join('');

    const html = `
    <div class="row threshold-row" data-index="${counter}">
        <div class="form-group col-md-3 mt-1">
            <label>Node Name</label>
            <select name="pressure_type[]" class="form-control select2 pressure_type_select" onchange="checkDuplicatePressureType(this)" required>
                <option value="">Select</option>
                ${options}
            </select>
        </div>
        <div class="form-group col-md-3 mt-1">
            <label>Tag No</label>
            <select name="tag_id[]" class="form-control select2 tag_select" onchange="checkDuplicateTagType(this)" required></select>
        </div>
        <div class="form-group col-md-2 mt-1"><label>Max</label><input type="number" name="max_value[]" class="form-control" value="${prefillData?.max_value || ''}" /></div>
        <div class="form-group col-md-2 mt-1"><label>Upper</label><input type="number" name="upper_value[]" class="form-control" value="${prefillData?.upper_value || ''}" required/></div>
        <div class="form-group col-md-2 mt-1"><label>Lower</label><input type="number" name="lower_value[]" class="form-control" value="${prefillData?.lower_value || ''}" required/></div>
        <div class="form-group col-md-2 mt-1"><label>Offset</label><input type="number" name="offset[]" class="form-control" value="${prefillData?.offset || ''}" /></div>
        <div class="form-group col-md-2 mt-1"><label>Multiplier</label><input type="number" name="multiplier[]" class="form-control" value="${prefillData?.multiplier || ''}" /></div>
        <div class="form-group col-md-1" style="margin-top:30px;">
            <button type="button" class="btn btn-danger btn-sm" onclick="$(this).closest('.row').remove()">X</button>
        </div>
    </div>`;

    $('#pressurePointContainer').append(html);
    $('.select2').select2();
    

    const tagSelect = $('.tag_select').last();
    get_tag_list(tagSelect, selectedTag);
}

function checkDuplicatePressureType(selectElement) {
    const selectedValue = $(selectElement).val();
    const selectedText = $(selectElement).find('option:selected').text(); // get the name

    let duplicateCount = 0;

    $('.pressure_type_select').each(function () {
        if ($(this).val() === selectedValue) {
            duplicateCount++;
        }
    });

    if (duplicateCount > 1) {
        swal('Warning', `Duplicate Pressure Type '${selectedText}' not allowed!`, 'warning');
        $(selectElement).val('').trigger('change');
    }
}


function checkDuplicateTagType() {
    const selectedTags = [];

    // Collect selected tag IDs
    $('.tag_select').each(function () {
        const val = $(this).val();
        if (val) selectedTags.push(val);
    });

    // Update all dropdowns
    $('.tag_select').each(function () {
        const current = $(this);
        const currentVal = current.val();
        current.find('option').each(function () {
            const optionVal = $(this).val();
            if (optionVal === "" || optionVal === currentVal) {
                $(this).prop('disabled', false);
            } else if (selectedTags.includes(optionVal)) {
                $(this).prop('disabled', true);
            } else {
                $(this).prop('disabled', false);
            }
        });
    });
}

function addNewGroupedRow(containerId, well_id = null, prefillData = null) {
    counter++;
    const nodeType = prefillData?.node_name || '';
    const selectedTag = prefillData?.tag_no || '';

    const options = pressureTypes.map(pt => {
        const selected = nodeType === pt ? 'selected' : '';
        return `<option value="${pt}" ${selected}>${pt}</option>`;
    }).join('');

    const html = `
    <div class="row threshold-row mb-2" data-index="${counter}">
        <div class="form-group col-md-2 mt-1">
            <label>Node Name</label>
            <select name="pressure_type_grouped_${containerId}[]" class="form-control select2 pressure_type_select" required>
                <option value="">Select</option>${options}
            </select>
        </div>
        <div class="form-group col-md-2 mt-1">
            <label>Tag No</label>
            <select name="tag_id_grouped_${containerId}[]" class="form-control select2 tag_select" required onchange="checkDuplicateTagType(this);">
                <option value="">Select Tag</option>
            </select>
        </div>
        <div class="form-group col-md-2 mt-1">
            <label>Max</label>
            <input type="number" name="max_value_grouped_${containerId}[]" class="form-control" value="${prefillData?.max_value || ''}" />
        </div>
        <div class="form-group col-md-2 mt-1">
            <label>Upper</label>
            <input type="number" name="upper_value_grouped_${containerId}[]" class="form-control" value="${prefillData?.upper_value || ''}" required/>
        </div>
        <div class="form-group col-md-2 mt-1">
            <label>Lower</label>
            <input type="number" name="lower_value_grouped_${containerId}[]" class="form-control" value="${prefillData?.lower_value || ''}" required/>
        </div>
        <div class="form-group col-md-2 mt-1">
            <label>Offset</label>
            <input type="number" name="offset_grouped_${containerId}[]" class="form-control" value="${prefillData?.offset || ''}" />
        </div>
        <div class="form-group col-md-2 mt-1">
            <label>Multiplier</label>
            <input type="number" name="multiplier_grouped_${containerId}[]" class="form-control" value="${prefillData?.multiplier || ''}" />
        </div>
        <div class="form-group col-md-1" style="margin-top:30px;">
            <button type="button" class="btn btn-danger btn-sm" onclick="$(this).closest('.row').remove()">X</button>
        </div>
    </div>`;

    $(`#${containerId} .row-group`).append(html);
    $('.select2').select2();
    updatePressureTypeOptions(containerId);
    updateTagOptions(containerId);

    const tagSelect = $(`#${containerId} .row-group .row`).last().find('.tag_select');
    get_group_well_tag_list(tagSelect, selectedTag, well_id);
}

function get_group_well_tag_list(selectElement, selectedTag = '', well_id = '') {
    if (!well_id) {
        $(selectElement).html('<option value="">Select Well First</option>');
        return;
    }

    $.ajax({
        type: 'POST',
        url: '<?= base_url(); ?>Threshold_setup_selfflow_c/get_tag_list',
        data: { well_id },
        success: function (response) {
            var response = JSON.parse(response);
            if (response.response_code == 200) {
                const tagList = response.data;
                let options = '<option value="">Select Tag</option>';
                tagList.forEach(tag => {
                    options += `<option value="${tag.tag_id}" ${selectedTag == tag.tag_id ? 'selected' : ''}>${tag.tag_number}</option>`;
                });
                $(selectElement).html(options).trigger('change');
            }
        }
    });
}

function updatePressureTypeOptions(containerId) {
    const selectedTypes = [];
    $(`#${containerId} .pressure_type_select`).each(function () {
        const val = $(this).val();
        if (val) selectedTypes.push(val);
    });

    $(`#${containerId} .pressure_type_select`).each(function () {
        const $select = $(this);
        const currentVal = $select.val();
        $select.find('option').each(function () {
            const optionVal = $(this).val();
            if (optionVal === "") return; // ignore placeholder
            if (optionVal !== currentVal && selectedTypes.includes(optionVal)) {
                $(this).attr('disabled', true);
            } else {
                $(this).attr('disabled', false);
            }
        });
    });
}

function updateTagOptions(containerId) {
    const selectedTags = [];
    $(`#${containerId} .tag_select`).each(function () {
        const val = $(this).val();
        if (val) selectedTags.push(val);
    });

    $(`#${containerId} .tag_select`).each(function () {
        const $select = $(this);
        const currentVal = $select.val();
        $select.find('option').each(function () {
            const optionVal = $(this).val();
            if (optionVal === "") return;
            if (optionVal !== currentVal && selectedTags.includes(optionVal)) {
                $(this).attr('disabled', true);
            } else {
                $(this).attr('disabled', false);
            }
        });
    });
}

$(document).on('change', `.pressure_type_select`, function () {
    // Find containerId from this select
    const containerId = $(this).closest('.row-group').attr('id');
    updatePressureTypeOptions(containerId);
});

$(document).on('change', `.tag_select`, function () {
    const containerId = $(this).closest('.row-group').attr('id');
    updateTagOptions(containerId);
});


function threshold_data_submit() {
    swal({
        title: "Confirm",
        text: "Submit threshold setup?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((ok) => {
        if (!ok) return;

        const formData = new FormData();
        const site_id = $('#site_id').val();
        const area_id = $('#area_id').val();
        const well_id = $('#well_id').val();
        const threshold_type = $('#threshold_type').val();

        formData.append('site_id', site_id);
        formData.append('area_id', area_id);
        formData.append('well_id', well_id);
        formData.append('threshold_type', threshold_type);

        let thresholdData = [];

       if (threshold_type == '1') {
    const well_data = [];

    $('#wellWiseThresholdContainer .card').each(function () {
        const well_id = $(this).find('input[name="well_ids_grouped[]"]').val();
        const node_value = [];

        $(this).find('.threshold-row').each(function () {
            const row = $(this);

            const tag_id = row.find('.tag_select').val();
            const node_type = row.find('.pressure_type_select').val();
            const max_value = row.find('input[name^="max_value"]').val();
            const upper_value = row.find('input[name^="upper_value"]').val();
            const lower_value = row.find('input[name^="lower_value"]').val();
            const multiplier = row.find('input[name^="multiplier"]').val();
            const offset = row.find('input[name^="offset"]').val();

            if (tag_id && node_type) {
                node_value.push({
                    tag_id,
                    node_type,
                    max_value,
                    upper_value,
                    lower_value,
                    multiplier,
                    offset
                });
            }
        });

        if (node_value.length > 0 && well_id) {
            well_data.push({ well_id, node_value });
        }
    });

    formData.append('well_data', JSON.stringify(well_data));
    }else if (threshold_type == '2') {
            // Area Wise
            const node_value = [];

            $('#pressurePointContainer .threshold-row').each(function () {
                const row = $(this);
                node_value.push({
                    node_type: row.find('.pressure_type_select').val(),
                    tag_id: row.find('.tag_select').val(),
                    max_value: row.find('input[name="max_value[]"]').val(),
                    upper_value: row.find('input[name="upper_value[]"]').val(),
                    lower_value: row.find('input[name="lower_value[]"]').val(),
                    multiplier: row.find('input[name="multiplier[]"]').val(),
                    offset: row.find('input[name="offset[]"]').val()
                });
            });

            if (node_value.length > 0) {
                thresholdData = node_value;
            }
        }
        formData.append('threshold_data', JSON.stringify(thresholdData));

        $.ajax({
            url: '<?= base_url("Threshold_setup_selfflow_c/add_threshold_setup") ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
                let response = JSON.parse(res);
                if (response.response_code == 200) {
                    swal('Success', response.msg, 'success');
                    setTimeout(() => location.reload(), 2000);
                } else {
                    swal('Error', response.msg, 'error');
                }
            }
        });
    });
}


</script>
