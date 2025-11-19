<style type="text/css">
.readonly-gray {
    background-color: #e0e0e0 !important;
    color: #000 !important;
}
#jsonPreviewModal .modal-dialog {
    max-width: 90% !important;  /* Increase width */
}

#jsonPreviewModal .btn-close {
    filter: invert(1) brightness(200%);
}

</style>

<div class="page-wrapper">
<!-- Page Content -->
    <div class="content container-fluid">
            <div class="row row-sm">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body" >
                        <div class="row">
                            <div class="col-md-6">
                                <h3><b>Device Multi-Well Configuration Publisher</b></h3>
                            </div>
                            <div class="col-md-6 d-md-flex justify-content-end">
                                <div>
                                    <button type="button" class="btn btn-sm btn-warning text-white" onclick="previewJson()">
                                        <i class="fas fa-eye me-1 text-white"></i> Preview JSON
                                    </button>
                                     <a href="<?php echo base_url('Main_dashboard'); ?>" class="btn btn-sm btn-success motion-btn">
                                      <i class="fas fa-arrow-left me-1" style="font-size: 12px;"></i> Back
                                    </a>
                                </div>
                            </div>
                        </div>
                        </div>
                        <hr style="margin: 0rem 0 !important;">
                    <div class="card-body">                    
                        <form method="POST" action="" enctype="multipart/form-data" class="needs-validation" novalidate>
                        <div class="row">
                            <div class="form-group col-md-3" >
                                <label class="form-label">Device Name<sup class="text-danger">*</sup></label>
                                <select name="device_name" id="device_name" class="form-control select2" 
                                 onchange="get_device_data();" required>
                                 <option value="">Select Device</option>
                                </select>
                                <div class="invalid-feedback">Please select device!</div>
                            </div>
                            <div class="form-group col-md-3 " >
                                <label class="form-label">Number of Wells (nw)<sup class="text-danger">*</sup></label>
                                <input type="text" name="no_of_wells" id="no_of_wells" 
                                  class="form-control readonly-gray">

                            </div>
                            <div class="form-group col-md-2 " >
                                <label class="form-label">Node Scan Time<sup class="text-danger">*</sup></label>
                                <input type="text" name="node_scan_time" id="node_scan_time" class="form-control device-setting">
                            </div>

                            <div class="form-group col-md-2 " >
                                <label class="form-label">Node Log Time<sup class="text-danger">*</sup></label>
                                <input type="text" name="node_log_time" id="node_log_time" class="form-control device-setting">
                            </div>

                            <div class="form-group col-md-2" >
                                <label class="form-label">GateWay Log Time<sup class="text-danger">*</sup></label>
                                <input type="text" name="gateway_log_time" id="gateway_log_time" class="form-control device-setting">
                            </div>

                           
                            <input type="hidden" name="device_name_hdn" id="device_name_hdn" class="form-control">
                            <input type="hidden" name="imei_no_hdn" id="imei_no_hdn" class="form-control">
                            
                        </div>

                        <div class="text-end mt-2" id="deviceUpdateBox" style="display:none;">
                             <button type="button" class="btn btn-sm btn-secondary" onclick="resetDeviceConfig()">Cancel</button>
                              <button  type="button" class="btn btn-sm btn-primary" onclick="updateDeviceConfig()">Update Device Config</button>
                              
                        </div>
                       
                        <hr>
                        <div class="table-responsive mt-3">
                          <table class="table table-bordered table-sm" id="well_table" style="display:none;">
                              <thead class="table-light">
                                  <tr class="text-center">
                                      <th>Well Name</th>
                                      <th>No. of Installed Sensors (nn)</th>
                                      <th>Action</th>
                                  </tr>
                              </thead>
                              <tbody class="text-center" id="well_table_body"></tbody>
                          </table>
                      </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <div class="card" id="well_config_card" style="display:none;">
        <div class="card-header mb-0">
            <div class="row align-items-center">
                <div class="col">
                    <h4 class="mb-1">Well Configuration Editor</h4>
                </div>
            </div>
        </div>
         <div class="card-body">     
              <div class="row">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Well Name (nw)</label>
                    <input type="text" id="wc_well_name" class="form-control" readonly>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">No. of Installed Sensors (nn)</label>
                    <input type="text" id="wc_no_of_sensors" class="form-control" readonly>
                </div>
              </div>
              <form method="POST" action="" enctype="multipart/form-data" class="needs-validation" novalidate>
                 <input type="hidden" id="wc_well_id">
                 <input type="hidden" id="wc_site_id">
                 <input type="hidden" id="wc_area_id">
                 <div id="threshold_form_container"></div>

                <hr>
               <div class="text-end">
                  <button type="submit" class="btn btn-sm btn-success" onclick="updateWellConfig(event)">Update Configuration</button>
               </div>
             </form>
          </div>
      </div>
    </div>

<div class="modal fade" id="jsonPreviewModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header text-white" style="background: linear-gradient(to right, #032448 20%, #fc6075 100%);">
            <h5 class="modal-title">JSON Preview</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
             </div>
          <div class="modal-body">
            <pre id="jsonPreviewModalBody" class="bg-light p-3 rounded" style="font-size:14px;"></pre>
          </div>
          <div class="modal-footer">
             <button class="btn btn-sm btn-warning" data-bs-dismiss="modal">Cancel</button>
             <button class="btn btn-sm btn-success" onclick="publishConfig()">Publish</button>
          </div>
      </div>
    </div>
</div>
<script>
$(".device-setting").on("input change", function() {
    $("#deviceUpdateBox").show();
});
loadDeviceList();
function loadDeviceList(selectedImei = null) {
    $.ajax({
        url: "<?php echo base_url('Device_configration_setup_c/device_list'); ?>",
        type: "POST",
        dataType: "json",
        success: function(res) {
            if(res.status && res.data.length > 0){
                let options = '<option value="">Select Device</option>';

                res.data.forEach(function(d){
                    let optVal = `${d.device_name}|${d.imei_no}|${d.no_of_wells}|${d.node_scan_time}|${d.node_log_time}|${d.gateway_log_time}`;
                    let selected = (selectedImei && selectedImei == d.imei_no) ? "selected" : "";
                    options += `<option value="${optVal}" ${selected}>${d.device_name}</option>`;
                });

                $("#device_name").html(options).trigger('change.select2');
            } else {
                $("#device_name").html('<option value="">No Device Found</option>');
            }
        }
    });
}


function get_device_data()
{
    var device_data = $('#device_name').val();
    if (device_data === "") return;
    let parts = device_data.split("|");
    $('#device_name_hdn').val(parts[0]);
    $('#imei_no_hdn').val(parts[1]);
    $('#no_of_wells').val(parts[2]);
    $('#node_scan_time').val(parts[3]);
    $('#node_log_time').val(parts[4]);
    $('#gateway_log_time').val(parts[5]);
    fetch_well_list();
}



function updateDeviceConfig(){
   var imei = $("#imei_no_hdn").val();

    var formData = {
        device_name: $("#device_name_hdn").val(),
        imei_no: imei,
        node_scan_time: $("#node_scan_time").val(),
        node_log_time: $("#node_log_time").val(),
        gateway_log_time: $("#gateway_log_time").val()
    };

    swal({
        title: "Are you sure?",
        text: "Do you want to update device configuration?",
        icon: "warning",
        buttons: ["Cancel", "ok"]
    }).then((willUpdate) => {
        if (willUpdate) {
            $.ajax({
                url: "<?php echo base_url('Device_configration_setup_c/update_device_time_settings'); ?>",
                type: "POST",
                data: formData,
                dataType: "json",
                success: function(res){
                    if(res.response_code == 200){
                        swal("Success!", res.msg, "success");
                        loadDeviceList(imei);
                        $("#deviceUpdateBox").hide();
                    } else {
                        swal("Error!", res.msg, "error");
                    }
                },
                error: function(){
                    swal("Error!", "Something went wrong!", "error");
                }
            });
        }
    });
}

</script>
<script type="text/javascript">
 function fetch_well_list()
{
 let imei_no = $('#imei_no_hdn').val();

    $("#well_table_body").html(""); // Clear old rows
    $("#well_table").hide();

    $.ajax({
        url: "<?php echo base_url('Device_configration_setup_c/well_list_details'); ?>",
        type: "POST",
        data: { imei_no: imei_no },
        dataType: "json",
        success: function(res) {
            if(res.status && res.data.length > 0){
                
                let html = '';
                res.data.forEach(function(row){
                    html += `
                        <tr>
                            <td>${row.well_name}</td>
                            <td>${row.no_of_installed_sensor}</td>
                            <td>
                              <button type="button" class="btn btn-primary btn-sm" onclick="editWell('${row.well_id}')">
                                  <i class="fa fa-edit"></i> 
                              </button>
                           </td>
                        </tr>`;
                });

                $("#well_table_body").html(html);
                $("#well_table").show();

            } else {
                $("#well_table_body").html('<tr><td colspan="3" class="text-center text-danger">No wells found!</td></tr>');
                $("#well_table").show();
            }
        },
        error: function() {
            alert("Error fetching well information!");
        }
    });
}

function editWell(well_id){
 
    $.ajax({
        url: "<?php echo base_url('Device_configration_setup_c/well_threshold_list_details'); ?>",
        type: "POST",
        data: { well_id: well_id },
        dataType: "json",
        success: function(res){
            if(res.status){
                const well = res.data.well_details;
                const thresholds = res.data.thresholds;

                $("#wc_well_id").val(well.well_id);
                $("#wc_area_id").val(well.area_id);
                $("#wc_site_id").val(well.site_id);
                $("#wc_well_name").val(well.well_name);
                $("#wc_no_of_sensors").val(well.no_of_installed_sensor);

                let html = '';

                if (thresholds.length === 0) {
                    html = `<p class="text-danger mt-2">No threshold configuration found for this well.</p>`;
                } else {
                    html += `
                        <div class="table-responsive mt-2">
                         <h5> Node Data (ndata)</h5>
                          <table class="table table-bordered table-sm align-middle mt-2">
                            <thead class="table-light">
                              <tr>
                                <th>#</th>
                                <th>Tag Number (nm)</th>
                                <th>Component (vnm)</th>
                                <th>Max Value (vmx)</th>
                                <th>Upper Value (vu)</th>
                                <th>Lower Value (vl)</th>
                                <th>Multiplier (mul)</th>
                                <th>Offset (ofs)</th>
                               
                              </tr>
                            </thead>
                            <tbody>
                    `;

                    thresholds.forEach(function(th, i){
                        html += `
                            <tr>
                                <td class="text-center">${i + 1}</td>
                                
                                <td>
                                  <strong>${th.tag_number}</strong>
                                  <input type="hidden" class="form-control form-control-sm" 
                                           name="id[]" value="${th.id}">
                                    <input type="hidden" class="form-control form-control-sm" 
                                           name="tag_no[]" value="${th.tag_no}">
                                </td>
                                <td>
                                    <strong>${th.component_name}</strong>
                                    <input type="hidden" name="component_id[]" value="${th.component_id}">
                                </td>
                                <td>
                                    <input type="number" step="any" class="form-control form-control-sm" 
                                           name="max_value[]" value="${th.max_value}">
                                </td>
                                <td>
                                    <input type="number" step="any" class="form-control form-control-sm" 
                                           name="upper_value[]" value="${th.upper_value}">
                                </td>
                                
                                <td>
                                    <input type="number" step="any" class="form-control form-control-sm" 
                                           name="lower_value[]" value="${th.lower_value}">
                                </td>
                                
                                 <td>
                                    <input type="number" step="any" class="form-control form-control-sm" 
                                           name="multiplier[]" value="${th.multiplier}">
                                </td>
                                <td>
                                    <input type="number" step="any" class="form-control form-control-sm" 
                                           name="offset[]" value="${th.offset}">
                                </td>
                               
                            </tr>
                        `;
                    });

                    html += `
                            </tbody>
                          </table>
                        </div>
                    `;
                }

                $("#threshold_form_container").html(html);
                $("#well_config_card").show();
                window.scrollTo({ 
                    top: $("#well_config_card").offset().top - 80, 
                    behavior: 'smooth' 
                });
            }
        }
    });
}


function updateWellConfig(event){

    if(event) event.preventDefault(); 

    var ids = $("input[name='id[]']").map(function(){ return $(this).val(); }).get();
    var component_ids = $("input[name='component_id[]']").map(function(){ return $(this).val(); }).get();
    var tags = $("input[name='tag_no[]']").map(function(){ return $(this).val(); }).get();
    var lower_values = $("input[name='lower_value[]']").map(function(){ return $(this).val(); }).get();
    var upper_values = $("input[name='upper_value[]']").map(function(){ return $(this).val(); }).get();
    var max_values = $("input[name='max_value[]']").map(function(){ return $(this).val(); }).get();
    var offsets = $("input[name='offset[]']").map(function(){ return $(this).val(); }).get();
    var multipliers = $("input[name='multiplier[]']").map(function(){ return $(this).val(); }).get();
    
    var thresholdData = [];
    for(var i = 0; i < ids.length; i++){
        thresholdData.push({
            id: ids[i],
            component_id: component_ids[i],
            tag_number: tags[i],
            lower_value: lower_values[i],
            upper_value: upper_values[i],
            max_value: max_values[i],
            offset: offsets[i],
            multiplier: multipliers[i]
        });
    }

    var formData = {
        well_id: $("#wc_well_id").val(),
        area_id: $("#wc_area_id").val(),
        site_id: $("#wc_site_id").val(),
        threshold_data: JSON.stringify(thresholdData)
    };

    swal({
        title: "Are you sure?",
        text: "Do you want to update well configuration?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((yes) => {
        if (yes) {
            $.ajax({
                url: "<?php echo base_url('Device_configration_setup_c/update_threshold_details'); ?>",
                type: "POST",
                data: formData,
                dataType: "json",
               success: function(res){
                 if(res.response_code == 200){
                    swal("Success!", res.msg, "success")
                    .then(() => {

                        let well_id = $("#wc_well_id").val();

                      
                        fetch_well_list();
                        editWell(well_id);
                        setTimeout(() => {
                            $('html, body').animate({
                                scrollTop: $("#well_config_card").offset().top - 80
                            }, 600);
                        }, 500);
                    });

                } else {
                    swal("Error!", res.msg, "error");
                }
            },

                error: function(){
                    swal("Error!", "Something went wrong!", "error");
                }
            });
        }
    });
}




function previewJson() 
{
    let imei_no = $('#imei_no_hdn').val();
    let base_url = '<?php echo base_url();?>';

    if(imei_no == ""){
        swal("warning","Please select IMEI first!","warning");
        return;
    }

    $.ajax({
        url: base_url + "Device_configration_setup_c/well_preview_jason_details",
        type: "POST",
        data: { imei_no: imei_no },
        dataType: "json",
        success: function(res) {

            if(!res.status){
                swal("warning","No threshold data found!","warning");
                return;
            }
            let dateNow = new Date().toISOString().slice(0, 10);    
            let timeNow = new Date().toTimeString().slice(0, 8);

            let jsonPreview = {
                sVal: `${dateNow},${timeNow},${$("#node_scan_time").val()},${$("#node_log_time").val()},${$("#gateway_log_time").val()}`,
                nw: $("#no_of_wells").val(),
                wd: res.data.map(w => ({
                    wn: w.well_name,
                    nn: w.no_of_installed_sensor,
                    ndata: (w.thresholds || []).map(t => ({
                        nm:  t.tag_number,
                        vnm: t.component_name,
                        vmx: t.max_value,
                        vu:  t.upper_value,
                        vl:  t.lower_value,
                        mul: t.multiplier,
                        ofs: t.offset
                    }))
                }))
            };

            let jsonText = JSON.stringify(jsonPreview, null, 2);
          jsonText = jsonText.replace(
              /"ndata": \[\s*([\s\S]*?)\s*\]/g,
              function(match, inner) {
                  let items = inner
                      .trim()
                      .replace(/\n/g, "")      
                      .replace(/\s+/g, " ")     
                      .replace(/}\s*,\s*{/g, "}|{")
                      .split("|")               
                      .map(x => x.trim());

                  let formatted = 
                      "[\n" +
                      items.map(obj => `        ${obj}`).join(",\n") +
                      "\n      ]"; 

                  return `"ndata": ${formatted}`;
              }
          );

            $("#jsonPreviewModalBody").text(jsonText);
            $("#jsonPreviewModal").modal("show");
        },

        error: function(){
            alert("Error fetching threshold details!");
        }
    });
}



function publishConfig() {
    let jsonData = $("#jsonPreviewModalBody").text();

    $.ajax({
        url: "<?php echo base_url('Device_configration_setup_c/publish_device_config'); ?>",
        type: "POST",
        data: { config_json: jsonData },
        dataType: "json",
        success: function(res){
            if(res.status){
                alert("Configuration published successfully!");
                $("#jsonPreviewModal").modal("hide");
            } else {
                alert("Publishing failed!");
            }
        }
    });
}
</script>
      