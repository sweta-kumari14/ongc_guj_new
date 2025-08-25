<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
.blink {
    animation: blink-animation 1s infinite;
}

@keyframes blink-animation {
    0%, 50%, 100% { opacity: 1; }
    25%, 75% { opacity: 0; }
}

    .circle {
    display: inline-block;
    border-radius: 50%;
    color: white;
    width: 39px;
    height: 40px;
    text-align: center;
    font-size: 25px;
    line-height: 41px;
    margin-top: 0PX;
}
 
.card .card-body {
    padding: 10px;

}
.tag-name, .tag-count {
    font-size: 15px;
    font-weight: 600;
    color: #000000;
    font-family: KhandBold, sans-serif;
}
.content-area {
  padding: 6px 0px;
}
.card .card-header {
    padding: 12px;
}
.button {
    padding: 7px 9px;
    background: #28a745;
    border: none;
    color: #fff;
    font-weight: bold;
    border-radius: 6px;
    cursor: pointer;
    animation: flash 1s infinite;
    transition: background 0.3s;
  
}
 .tooltip-inner {
        background-color: #dc3545 !important; /* Dark blue background */
        color: #ffffff !important; /* White text */
        font-size: 14px;
        padding: 8px 12px;
        border-radius: 6px;
    }

    .tooltip.bs-tooltip-top .tooltip-arrow::before {
        border-top-color: #dc3545 !important;
    }
    .tooltip.bs-tooltip-bottom .tooltip-arrow::before {
        border-bottom-color: #dc3545 !important;
    }
    .tooltip.bs-tooltip-start .tooltip-arrow::before {
        border-left-color: #dc3545 !important;
    }
    .tooltip.bs-tooltip-end .tooltip-arrow::before {
        border-right-color: #dc3545 !important;
    }

/*css by samir */
.sensors-top{
    position: absolute;
    top: 26%;
    left: 50%;
}
.sensors-top img,
.sensors-top-two img,
.sensors-top-three img,
.sensors-top-bottom img{
    height: 25px !important;
}
.sensor-values {
    position: absolute;
    bottom: 32px;
    border: 1px solid grey;
    padding: 3px 5px;
    align-items: center;
    white-space: nowrap;   /* ek line me rakhega */
    display: inline-flex;  /* inline-flex se ek line me flex align hoga */
}

.sensor-values_chp {
    position: absolute;
    bottom: 27px;
    left:-43px;
    border: 1px solid grey;
    padding: 3px 5px;
    align-items: center;
    white-space: nowrap;   /* ek line me rakhega */
    display: inline-flex;  /* inline-flex se ek line me flex align hoga */
}

.sensor-values_flt {
    position: absolute;
    top: 50px;
    left:-20px;
    border: 1px solid grey;
    padding: 3px 5px;
    align-items: center;
    white-space: nowrap;   /* ek line me rakhega */
    display: inline-flex;  /* inline-flex se ek line me flex align hoga */
}
.sensors-top-two{
    position: absolute;
    top: 37%;
    left: 62%;
}

.sensors-top-three{
    position: absolute;
    top: 37%;
    left: 78%;
}
.sensors-top-bottom{
    position: absolute;
    bottom: 36%;
    left: 48%;
}
</style>
<div class="page-wrapper">
    <div class="content container-fluid pt-2">
        <div class="row">
            <div class="col-md-12">
                <div class="card" style="background: linear-gradient(to left,#F1948A ,#5D6D7E);">
                    <div class="card-body">
                        <div class="row">
                            <!-- Area Dropdown -->
                            <div class="form-group col-md-3">
                                <label style="color:white;"><b>Installation/Field</b></label>
                                <select name="area_id" id="area_id" class="form-control select2"
                                    onchange="get_site_list();get_dashboard_count();initMap();get_well_data();on_well_list();get_feeder_list(); get_feeder_data(); get_well_list();">
                                    <?php
                                    $user_type = $this->session->userdata('user_type', true);
                                    $role_type = $this->session->userdata('role_type', true);

                                    if ($user_type == 3 && $role_type == 2) {
                                        if (!empty($area_list)) {
                                            foreach ($area_list as $value) {
                                                echo '<option value="' . $value['id'] . '">' . $value['area_name'] . '</option>';
                                            }
                                        }
                                    } else {
                                        if (!empty($area_list)) {
                                            echo '<option value="">Select All</option>';
                                            foreach ($area_list as $value) {
                                                echo '<option value="' . $value['id'] . '">' . $value['area_name'] . '</option>';
                                            }
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-md-3" style="display:none;" id="feeder_dropdown">
                                <label style="color:white;"><b>Feeder</b></label>
                                <select name="feeder_id" id="feeder_id" class="form-control select2"
                                    onchange="get_dashboard_count();get_well_data();on_well_list();get_well_list();">
                                    <option value="">Select Feeder</option>
                                </select>
                            </div>

                            <!-- Well Dropdown -->
                            <div class="form-group col-md-3">
                                <label style="color:white;"><b>Well Name</b></label>
                                <select name="well_id" id="well_id" class="form-control select2"
                                    onchange="get_dashboard_count();initMap();get_well_data();on_well_list();">
                                    <option value="">Select Well</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- Dashboard Cards Row -->
    <div class="row">
        <!-- Total Wells -->
        <div class="col-md-3 position-relative">
            <a href="<?php echo base_url('Overall_list_selfflow_c/overall_details_total');?>">
            <div class="card text-center shadow-sm rounded-2 pt-4 mt-3 pb-3 px-2 border-0 border-start border-end border-3 border-danger"  data-bs-toggle="tooltip" data-bs-placement="top" title="Click to View Total Well">
                <div class="position-absolute top-0 start-50 translate-middle" style="width: 60px; height: 60px; z-index: 1;">
                    <img src="<?php echo base_url('assets/icons/oil.png'); ?>" alt="img" class="img-fluid rounded-circle bg-light shadow" style="width: 100%; height: 100%; object-fit: cover; border: 2px solid #ef4d56;">
                </div>
                <div class="content-area text-center mt-2">
                        <span class="tag-name" style="color: #312929;margin-top: 5px; display: inline-block;">Total Wells</span><br>
                        <span class="tag-count" id="total_well"></span>
                </div>
            </div>
           </a>
        </div>
        <!-- Flowing Wells -->
       <div class="col-md-3 position-relative">
         <a href="<?php echo base_url('');?>Overall_list_selfflow_c/overall_details_flowing">
            <div class="card text-center shadow-sm rounded-2 pt-4 mt-3 pb-3 px-2 border-0 border-start border-end border-3 border-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Click to View Flowing Well">
                <div class="position-absolute top-0 start-50 translate-middle" style="width: 60px; height: 60px; z-index: 1;">
                    <img src="<?php echo base_url('assets/icons/02.png'); ?>" alt="Complaint" 
                         class="img-fluid rounded-circle bg-light shadow" 
                         style="width: 100%; height: 100%; object-fit: cover; border: 2px solid #22c5ad;">
                </div>
                <div class="content-area text-center mt-2">
                        <span class="tag-name" style="color: #312929;margin-top: 5px; display: inline-block;">
                            Flowing Wells
                        </span><br>
                        <span class="tag-count" id="total_flowing_well"></span>
                </div>
            </div>
          </a>
        </div>
        <!-- Non-Flowing Wells -->
        <div class="col-md-3 position-relative">
            <a href="<?php echo base_url('Overall_list_selfflow_c');?>">
            <div class="card text-center shadow-sm rounded-2 pt-4 mt-3 pb-3 px-2 border-0 border-start border-end border-3 border-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Click to View Tenporary Off Wells">
                <div class="position-absolute top-0 start-50 translate-middle" style="width: 60px; height:60px; z-index: 1;">
                    <img src="<?php echo base_url('assets/icons/04.png'); ?>" alt="Complaint" class="img-fluid rounded-circle bg-light shadow" style="width: 100%; height: 100%; object-fit: cover; border: 2px solid #ef4d56;">
                </div>
                <div class="content-area text-center mt-2">
                    <span class="tag-name" style="color: #312929;margin-top: 5px; display: inline-block;">Temporary Off Wells</span><br>
                    <span class="tag-count" id="total_non_flowing_well"></span>

                </div>
            </div>
           </a>
        </div>
        <div class="col-md-3 position-relative">
            <a href="<?php echo base_url('Overall_list_selfflow_c/overall_details_rtms');?>">
            <div class="card text-center shadow-sm rounded-2 pt-4 mt-3 pb-3 px-2 border-0 border-start border-end border-3 border-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Click to View Offline Wells">
                <div class="position-absolute top-0 start-50 translate-middle" style="width: 60px; height:60px; z-index: 1;">
                    <img src="<?php echo base_url('assets/icons/10.png'); ?>" alt="Complaint" class="img-fluid rounded-circle bg-light shadow" style="width: 100%; height: 100%; object-fit: cover; border: 2px solid #22c5ad;">
                </div>
                <div class="content-area text-center mt-2">
                    <span class="tag-name" style="color: #312929;margin-top: 5px; display: inline-block;">Offline Wells</span><br>
                    <span class="tag-count" id="off_unit"></span>
                </div>
            </div>
        </div>
      </a>
    </div>
    <div class="row">
            <div class="col-xl-12 col-md-12">
                <div class="card">
                   <div class="card-headerr d-flex justify-content-between align-items-center flex-wrap" style="background-color: #CD5C5C; color: white; padding: 4px; cursor: pointer; min-height:46px; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                        <div class="d-flex align-items-center me-auto" style="padding-left: 10px;">
                            <img src="<?= base_url('assets/img/oil-pump.gif') ?>" width="40"
                                style="border-radius: 25%; margin-right: 10px;">
                            <h4 style="margin: 0;">
                                <strong>Well Details&nbsp;</strong>
                                <badge class="circle" id="totalcount"style="background-color:#515A5A;" id="totalcount">0</badge>
                            </h4>
                        </div>
                        <div class="indicator d-flex flex-wrap align-items-center gap-3" style="padding-right: 8px;">
                            <div class="d-flex align-items-center gap-2">
                                <div style="background-color: #800000; width: 16px; height: 16px; border-radius: 50%;"></div>
                                <span style="font-size: 13px;">Temporary Off Wells</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <div style="background-color:#20c997; width: 16px; height: 16px; border-radius: 50%;"></div>
                                <span style="font-size: 13px;">Flowing Wells</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <div style="background-color: #6C757D; width: 16px; height: 16px; border-radius: 50%;"></div>
                                <span style="font-size: 13px;">Offline Wells</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                       <div class="row" id="well_area_card"></div> 
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <!-- Card Header -->
                    <div class="card-headerr d-flex justify-content-between align-items-center flex-wrap"
                        style="background-color: #CD5C5C; color: white;  cursor: pointer; min-height: 50px;border-top-left-radius: 10px; border-top-right-radius: 10px;">

                        <!-- Left: Image + Title -->
                        <div class="d-flex align-items-center me-auto">
                            <img src="<?= base_url('assets/img/map.gif') ?>" width="40"
                                style="border-radius: 25%; margin-right: 10px;margin-left: 10px;">
                            <h4 style="margin: 0;">
                                <strong>Asset GIS</strong>
                            </h4>
                        </div>

                        <!-- Right: Indicator Legend -->
                        <div class="indicator d-flex flex-wrap align-items-center gap-3" style="padding-right: 10px;">
                            <div class="d-flex align-items-center gap-2">
                                <div style="background-color: #800000; width: 16px; height: 16px; border-radius: 50%;"></div>
                                <span style="font-size: 13px;">Temporary off Wells</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <div style="background-color:#20c997; width: 16px; height: 16px; border-radius: 50%;"></div>
                                <span style="font-size: 13px;">Flowing Well</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <div style="background-color: #6C757D; width: 16px; height: 16px; border-radius: 50%;"></div>
                                <span style="font-size: 13px;">Offline Wells</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="background-color: #f9f9f9;">
                        <div class="d-flex flex-wrap gap-3 justify-content-start">
                        <div class="mt-2" id="mymap" style="width:100%;height: 400px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="addThreshold_data" aria-labelledby="offcanvasRightLabel" style="width:600px;">
    <!-- Header with background color -->
    <div class="offcanvas-header text-primary" style="background: linear-gradient(to right, #032448 20%, #fc6075 100%);">
        <h5 id="offcanvasRightLabel" class="offcanvas-title" style="color:white;">Threshold Setup   <span id="well_name_hdn_th" style="color:white;"></span></h5>
        <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <!-- Body -->
    <div class="offcanvas-body">
            <form class="custom-validation" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <input type="hidden" name="wellidhdn" id="wellidhdn">
                    <input type="hidden" name="area_id_hdn" id="area_id_hdn">
                     <input type="hidden" name="site_id_hdn" id="site_id_hdn">
                    <div id="threshold_dynamic_ui"></div>
                    <div class="btns-section pt-3 text-end" id="btns-section">
                        <button type="button" class="btn btn-sm btn-success" onclick="submit_threshold();"> Submit
                        </button>
                    </div>
                </div>
            </form>
        </div>
</div>



<script type="text/javascript">
    get_site_list();
function get_site_list() { 
    let company_id = "<?php echo $this->session->userdata('company_id') ?>";
    let user_id = "<?php echo $this->session->userdata('user_id') ?>";
    let assets_id = "<?php echo $this->session->userdata('assets_id') ?>";
    let area_id = $('#area_id').val();

    $.ajax({
        type: 'POST',
        url: '<?php echo base_url();?>Selfflow_c/site_list',
        data: { company_id: company_id, assets_id: assets_id, area_id: area_id, user_id: user_id },
        success: function(data) {
            data = JSON.parse(data);
    
            if (data.response_code == 200) {   
                if (data.data.length > 0) {
                    $('#site_id').html('');
                    $('#site_id').html('<option value="">Select site</option>');
                    $.each(data.data, function(i, v) {
                        // let selected = (v.id == v.id) ? 'selected' : '';
                        $('#site_id').append('<option value="' + v.id + '">' + v.well_site_name + '</option>');
                    });
                } else {
                    $('#site_id').html('<option value="">No Data Found</option>');
                }
            } else {
                swal('error', data.msg, 'error');
            }   
        }
    });
}

get_well_list();
function get_well_list() { 
    let company_id = "<?php echo $this->session->userdata('company_id') ?>";
    let user_id = "<?php echo $this->session->userdata('user_id') ?>";
    let assets_id = "<?php echo $this->session->userdata('assets_id') ?>";
    let area_id = $('#area_id').val();
    let feeder_id = $('#feeder_id').val();
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url();?>Selfflow_c/Well_list',
        data: { company_id: company_id, assets_id: assets_id, area_id: area_id, user_id: user_id,feeder_id:feeder_id },
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
get_feeder_list();
function get_feeder_list() { 
    let area_id = $('#area_id').val();
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url();?>Selfflow_c/feeder_list',
        data: { area_id: area_id },
        success: function(data) {
            data = JSON.parse(data);
            if (data.response_code == 200) {   
                if (data.data.length > 0) {
                    $('#feeder_id').html('<option value="">Select Feeder</option>');
                    $.each(data.data, function(i, v) {
                        $('#feeder_id').append('<option value="' + v.id + '">' + v.feeder_name + '</option>');
                    });
                } else {
                    $('#feeder_id').html('<option value="">No Feeder Found</option>');
                }
            } else {
                swal('error', data.msg, 'error');
            }   
        }
    });
}

function get_feeder_data() { 
    let area_id = $('#area_id').val();
    if (area_id == "52dbde99-b394-11ee-a6d4-5cb901ad9cf0") {
        $('#feeder_dropdown').show();
    } else {
        $('#feeder_dropdown').hide();
    }
}

$('#area_id').on('change', function() {
    get_feeder_list();
    get_feeder_data();
});

get_feeder_list();
get_feeder_data();



</script>
<script type="text/javascript">
    
    on_well_list()
    function on_well_list()
    {
        var company_id = '<?php echo $this->session->userdata('company_id') ?>';
        var user_id = '<?php echo $this->session->userdata('user_id') ?>';
        var assets_id = '<?php echo $this->session->userdata('assets_id') ?>';
        var area_id = $('#area_id').val();
        let site_id = $('#site_id').val();
        
    
        $.ajax({
            url: '<?php echo base_url(); ?>Dashboard_c/get_popup_data',
            type: 'POST',
            data: {company_id:company_id,user_id:user_id,assets_id:assets_id,area_id:area_id,site_id:site_id},
            success:function(res)
            {
                $('#flash_data').html(res);
            }
        });
    } 
</script>

<script type="text/javascript">
  get_dashboard_count();
function get_dashboard_count() {
    let company_id = '<?php echo $this->session->userdata('company_id') ?>';
    let area_id = $('#area_id').val();
    let well_id = $('#well_id').val();
    let feeder_id = $('#feeder_id').val();
    let assets_id = $('#assets_id').val();

    $.ajax({
        url: '<?php echo base_url(); ?>Selfflow_c/get_dashboard_count',
        type: 'POST',
        data: {
            company_id: company_id,
            area_id: area_id,
            well_id: well_id,
            feeder_id: feeder_id,
            assets_id: assets_id
        },
        success: function(res) {
            try {
                res = JSON.parse(res);
                console.log(res, 'dashboard_count');

                if (res.response_code == 200) {
                    // Populate basic stats
                    $('#total_well').text(res.data.total_well ?? 0);
                    $('#total_flowing_well').text(res.data.total_flowing_well ?? 0);
                    $('#total_non_flowing_well').text(res.data.total_not_flowing_well ?? 0);
                    $('#off_unit').text(res.data.rtms_offline ?? 0);
                } else {
                    console.error('API Error:', res.msg || 'Unknown error');
                }
            } catch (e) {
                console.error('JSON Parse Error:', e.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', status, error);
        }
    });
}
get_well_data();
function get_well_data() {
    let area_id = $('#area_id').val();
    let well_id = $('#well_id').val();
    let feeder_id = $('#feeder_id').val();
    $.ajax({
        url: '<?php echo base_url(); ?>Selfflow_c/well_card_data',
        method: 'POST',
        data: {
            area_id: area_id,
            well_id: well_id,
            feeder_id:feeder_id,
        },
        success: function(res) {
            var response = JSON.parse(res);
            console.log(res, 'well_details');

            if (response.response_code == 200) {
                if (response.data.length > 0) {
                    $("#well_area_card").html('');

                    $.each(response.data, function(i, v) {

                        let statusColor = '';
                        if (v.status_variable == 'flowing_well') {
                            statusColor = '#20c997';
                        } else if (v.status_variable == 'non_flowing_well') {
                            statusColor = '#800000';
                        } else {
                            statusColor = '#6c757d'; // Default
                        }

                      function getBlinkClass(node, value, thresholds) {
                        let threshold = thresholds.find(t => t.node_name === node);
                        if (!threshold) return '';

                        let val = parseFloat(value);
                        let upper = parseFloat(threshold.upper_value);
                        let lower = parseFloat(threshold.lower_value);

                        // Handle cases where upper < lower
                        if (upper < lower) {
                            [upper, lower] = [lower, upper]; // Swap to make upper > lower
                        }

                        if (val < lower || val > upper) {
                            return 'text-danger blink'; // Red blink
                        } 
                    }

                        let link = '<?php echo base_url("Selfflow_c/SingleWellDashboard/"); ?>' + v.well_id;

                        // --- Card HTML ---
                        let cardHtml = `
                        <div class="col-md-4" data-well-id="${v.well_id}" data-area-id="${v.area_id}" data-site-id="${v.site_id}">
                                <div class="card shadow-sm">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0 fw-bold" style="font-size:14pxpx">${v.well_name}</h6>
                                        <div class="status-circle" 
                                             style="width:20px;height:20px;border-radius:50%;background:${statusColor};">
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="content-section">
                                            <div class="pump-image">
                                                <img src="<?php echo base_url('assets/img/well_image.png') ?>">
                                            </div>
                                            <div class="sensors-top">
                                                <img src="<?php echo base_url() ?>assets/img/psr.png">
                                                <div class="sensor-values d-flex">
                                                    <span style="font-size: 10px;"><strong>THP <span class="${getBlinkClass('THP', v.THP, v.threshold_setup)}"> ${v.THP && v.THP !== '' ? v.THP : '0.00'} </span> kg/cm²</strong></span>
                                                </div>
                                            </div>

                                            <div class="sensors-top-two">
                                                <img src="<?php echo base_url() ?>assets/img/psr.png">
                                                <div class="sensor-values d-flex">
                                                    <span style="font-size: 10px;"><strong>ABP <span class="${getBlinkClass('ABP', v.ABP, v.threshold_setup)}"> ${v.ABP && v.ABP !== '' ? v.ABP : '0.00'}</span> kg/cm²  </strong></span>
                                                </div>
                                            </div>

                                            <div class="sensors-top-three">
                                                <img src="<?php echo base_url() ?>assets/img/psr.png">
                                                <div class="sensor-values_flt d-flex">
                                                    <span style="font-size: 10px;"><strong>FLT <span class="${getBlinkClass('FLT', v.FLT , v.threshold_setup)}">  ${v.FLT && v.FLT !== '' ? v.FLT : '0.00'} </span> °C </strong></span>
                                                </div>
                                            </div>

                                            <div class="sensors-top-bottom">
                                                <img src="<?php echo base_url() ?>assets/img/psr.png">
                                                <div class="sensor-values_chp d-flex">
                                                    <span style="font-size: 10px;"><strong>CHP <span class="${getBlinkClass('CHP', v.CHP , v.threshold_setup)}"> ${v.CHP && v.CHP !== '' ? v.CHP : '0.00'} </span> kg/cm² </strong></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex justify-content-between align-items-center" style="margin-top:-20px;">
                                        <div class="datetime">
                                           <small class="text-muted">
                                              <strong>
                                                ${v.Log_Date_Time ? moment(v.Log_Date_Time).format("DD-MM-YYYY hh:mm:ss A") : 'NA'}
                                              </strong>
                                            </small>

                                        </div>
                                        <div class="d-flex gap-2">
                                        <a href="${link}">
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Click to view Single Dashboard">
                                                <i class="fas fa-info-circle fa-lg"></i>
                                            </button>
                                            </a>
                                            <button class="btn btn-sm btn-outline-success"  
                                                data-bs-toggle="offcanvas" 
                                                data-bs-target="#addThreshold_data" 
                                                aria-controls="addThreshold_data"
                                                title="Click to Setup Threshold">
                                            <i class="fas fa-sliders-h"></i>
                                        </button>
                                        </div>
                                    </div>
                                </div>
                            </div>`;

                        $("#well_area_card").append(cardHtml);

                        var tooltipTriggerList = [].slice.call(document.querySelectorAll('#well_area_card [data-bs-toggle="tooltip"]'))
                           tooltipTriggerList.map(function (tooltipTriggerEl) {
                           return new bootstrap.Tooltip(tooltipTriggerEl)
                         });
                    });

                } else {
                    $('#well_area_card').html(`
                        <div class="card card-body mx-3 mt-3">
                            <div class="text-danger text-center">
                                <h4>No Well Found !!</h4>
                            </div>
                        </div>
                    `);
                }
            }
        }
    });
}

$(document).on('click', '.btn-outline-success', function() {
    let card = $(this).closest('.card');
    let well_id = card.closest('.col-md-4').data('well-id');
    let area_id = card.closest('.col-md-4').data('area-id');
    let site_id = card.closest('.col-md-4').data('site-id'); // card ke parent column se
    let well_name = card.find('.card-header h6').text().trim();

    $('#wellidhdn').val(well_id);  // set well_id
    $('#well_name_hdn_th').text(well_name); // show well name in offcanvas header
    $('#area_id_hdn').val(area_id);
    $('#site_id_hdn').val(site_id);

    get_last_thereshold_value(); // populate threshold values
});


function get_last_thereshold_value() {
    let well_id = $('#wellidhdn').val();

    $.ajax({
        url: '<?php echo base_url(); ?>Selfflow_c/get_last_threshold_setup',
        type: 'POST',
        data: { well_id: well_id },
        success: function (res) {
            res = JSON.parse(res);
            console.log(res, 'threshold');

            if (res.response_code == 200 && res.data.length > 0) {
                get_tag_list_for_threshold(res.data);
            } else {
                get_tag_list_for_threshold([]);
            }
        },
        error: function (err) {
            console.error("Error fetching threshold data", err);
            $('#threshold_dynamic_ui').html('<p class="text-danger">Something went wrong while fetching threshold data.</p>');
            $('.btns-section').hide();
        }
    });
}


function get_tag_list_for_threshold(thresholdData) {
    let well_id = $('#wellidhdn').val();
    let chp_ed = 1;
    let abp_ed = 1;
    let thp_ed = 1;
    let flt_ed = 1;
   

    let user_type = <?= json_encode($this->session->userdata('user_type')) ?>;
    let role_type = <?= json_encode($this->session->userdata('role_type')) ?>;

    $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>Selfflow_c/get_tag_list',
        data: { well_id: well_id },
        success: function (data) {
            data = JSON.parse(data);
            console.log(data, 'tag list');

            let html = '';
            let tagList = data.data || [];

            if (data.response_code == 200 && tagList.length > 0) {
                // Sensors and their enabled flags
                let sensorFlags = {
                    THP: thp_ed,
                    CHP: chp_ed,
                    ABP: abp_ed,
                    FLT: flt_ed,
                };

                // Filter thresholdData or default nodes only if enabled (flag == "1")
                let entries = [];

                if (thresholdData.length > 0) {
                    entries = thresholdData.filter(item => sensorFlags[item.node_name] == "1");
                } else {
                    // Default list filtered by flags
                    entries = ['THP', 'CHP', 'ABP', 'FLT']
                        .filter(name => sensorFlags[name] == "1")
                        .map(name => ({ node_name: name }));
                }

                // Now build the HTML as usual
                entries.forEach((item, index) => {
                    const node_name = item.node_name;
                    const upper_value = item.upper_value != null ? parseFloat(item.upper_value).toFixed(2) : '0.00';
                    const lower_value = item.lower_value != null ? parseFloat(item.lower_value).toFixed(2) : '0.00';

                    const selected_tag_id = item.tag_no || '';

                    let tagFieldHtml = '';

                    if (user_type == 2) {
                        tagFieldHtml = `
                            <div class="col-md-4">
                                <label class="form-group">Tag No</label>
                                <select name="tag_id[]" class="form-control form-control-sm tag-select">
                                    <option value="">Select Tag</option>
                                    ${tagList.map(tag => `
                                        <option value="${tag.tag_id}" ${tag.tag_id == selected_tag_id ? 'selected' : ''}>
                                            ${tag.tag_number}
                                        </option>`).join('')}
                                </select>
                            </div>
                        `;
                    } else {
                        tagFieldHtml = `<input type="hidden" name="tag_id[]" value="${selected_tag_id}">`;
                    }
                    html += `
                        <div class="row mb-2 pressure-row">
                            ${tagFieldHtml}
                            <div class="${user_type == 2 ? 'col-md-4' : 'col-md-6'}">
                                <label class="form-group">Upper (${node_name})</label>
                                <input type="number" name="upper_value[]" class="form-control" value="${upper_value}">
                            </div>
                            <div class="${user_type == 2 ? 'col-md-4' : 'col-md-6'}">
                                <label class="form-group">Lower (${node_name})</label>
                                <input type="number" name="lower_value[]" class="form-control" value="${lower_value}">
                            </div>
                            <input type="hidden" name="node_name[]" value="${node_name}">
                        </div>`;
                });

                $('#threshold_dynamic_ui').html(html);
                $('.btns-section').show();

                if (user_type == 2) {
                    $('.tag-select').select2({
                        placeholder: "Select Tag",
                        width: '100%'
                    });

                    $('.tag-select').on('change', function () {
                        let selectedValues = $('.tag-select').map(function () {
                            return $(this).val();
                        }).get();

                        $('.tag-select option').prop('disabled', false);

                        $('.tag-select').each(function () {
                            let currentSelect = $(this);
                            let currentValue = currentSelect.val();

                            selectedValues.forEach(val => {
                                if (val && val !== currentValue) {
                                    currentSelect.find(`option[value="${val}"]`).prop('disabled', true);
                                }
                            });
                        });
                    }).trigger('change');
                }
            } else {
                $('#threshold_dynamic_ui').html(`
                    <div class="d-flex justify-content-center align-items-center" style="height:100px;">
                        <p class="text-danger fw-bold mb-0">No tags found.</p>
                    </div>
                `);
                $('.btns-section').hide();
            }
        },
        error: function () {
            $('#threshold_dynamic_ui').html('<p class="text-danger">Error loading tags.</p>');
            $('.btns-section').hide();
        }
    });
}



function submit_threshold() {
    swal({
        title: "Are you sure?",
        text: "Do you want to setup threshold value?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willSubmit) => {
        if (willSubmit) {

            let site_id = $('#site_id_hdn').val();
            let area_id = $('#area_id_hdn').val();
            let well_id = $('#wellidhdn').val(); // corrected here!

            const thresholdData = [];

            $('#threshold_dynamic_ui .pressure-row').each(function () {
                const row = $(this);
                 const tag_id = row.find('select[name="tag_id[]"], input[name="tag_id[]"]').val();
                const node_name = row.find('input[name="node_name[]"]').val();
                const upper_value = row.find('input[name="upper_value[]"]').val();
                const lower_value = row.find('input[name="lower_value[]"]').val();

                if (node_name && (tag_id || upper_value || lower_value)) {
                    thresholdData.push({
                        tag_id: tag_id,
                        node_type: node_name,
                        upper_value: upper_value,
                        lower_value: lower_value
                    });
                }
            });

            let formData = new FormData();
            formData.append('site_id', site_id);
            formData.append('area_id', area_id);
            formData.append('well_id', well_id);
            formData.append('threshold_data', JSON.stringify(thresholdData));

            $.ajax({
                type: 'POST',
                url: '<?= base_url("Selfflow_c/add_threshold_setup") ?>',
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {
                    try {
                        const response = JSON.parse(res);
                        if (response.response_code == 200) {
                            swal('Success', response.msg, 'success');
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        } else {
                            swal("Error", response.msg, "error");
                            setTimeout(function() {
                            location.reload();
                            }, 2000);
                        }
                    } catch (err) {
                        console.error('Parse error:', err);
                    }
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', error);
                    alert('AJAX Request Failed.');
                }
            });
        } else {
            swal("Cancelled", "Threshold setup was not submitted.", "info");
        }
    });
}


</script>
<!-- Google Maps JS API -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBKoAgLoslTEUCNabLj5H5jLVdWFD2WhK8"></script>
<script type="text/javascript">
initMap();
function initMap() {
    let area_id = $('#area_id').val();
    let well_id = $('#well_id').val();
    let site_id = $('#site_id').val();
    let feeder_id = $('#feeder_id').val();

    $.ajax({
        url: '<?php echo base_url(); ?>Selfflow_c/get_site_location_for_dashboard',
        type: 'POST',
        data: { area_id, well_id, feeder_id, site_id },
        success: function(res) {
            let response;
            try {
                response = JSON.parse(res);
                console.log(response, 'map');
            } catch (error) {
                console.error("Invalid JSON response:", error);
                return;
            }

            if (!response.data || !Array.isArray(response.data) || response.data.length === 0) {
                console.error("No data found");
                return;
            }

            const mapCenter = {
                lat: parseFloat(response.data[0].lat) || 21.62640,
                lng: parseFloat(response.data[0].long) || 73.0152
            };

            const map = new google.maps.Map(document.getElementById('mymap'), {
                zoom: 13,
                center: mapCenter
            });

            const timeLimit = 5 * 60 * 1000; 
            const baseUrl = '<?php echo base_url(); ?>assets/img/';

            response.data.forEach((marker, index) => {
                console.log(marker.flag_status,'flag_status');
                const lastDataTimeObj = marker.Log_Date_Time ? new Date(marker.Log_Date_Time) : null;
                const diffMs = lastDataTimeObj ? (new Date() - lastDataTimeObj) : Infinity;

                let iconFile = 'offline_map.png'; // default
                if (diffMs <= timeLimit) {
                    iconFile = 'flowing_map.png'; 
                } else if (marker.flag_status == 1) {
                    iconFile = 'temp_off.png';  
                }else{
                     iconFile = 'offline_map.png';

                }

                const markerIcon = {
                    url: baseUrl + iconFile,
                    scaledSize: new google.maps.Size(40, 40)
                };

                const adjustedPosition = {
                    lat: parseFloat(marker.lat),
                    lng: parseFloat(marker.long)
                };

                const mapMarker = new google.maps.Marker({
                    position: adjustedPosition,
                    map,
                    icon: markerIcon,
                    title: marker.well_name
                });

                let statusText = '';
                if (diffMs <= timeLimit) {
                    statusText = 'Flowing Well';
                } else if (marker.flag_status == 1) {
                    statusText = 'Temporary Off Well';
                } else {
                    statusText = 'Offline';
                }

                const infowindow = new google.maps.InfoWindow({
                    content: `
                        <div class="site-info" style="width: 200px;">
                            <h6><a target="_blank" href="https://www.google.com/maps/place/${marker.lat},${marker.long}">View on Google Maps</a></h6>
                            <h6>${marker.well_name}</h6>
                            <h6><b>Well Status</b>: ${statusText}</h6>
                            <h6><b><a href="<?php echo base_url(); ?>Selfflow_c/SingleWellDashboard/${marker.well_id}/${marker.site}/${marker.area_id}/${marker.well_type}">View Details</a></b></h6>
                        </div>`
                });

                mapMarker.addListener('click', () => infowindow.open(map, mapMarker));
                map.addListener('click', () => infowindow.close());
            });
        }
    });
}


</script>