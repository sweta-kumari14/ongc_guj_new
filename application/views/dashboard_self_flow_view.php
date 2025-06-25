<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
.sensor-card {
    border: 1px solid #d4d4d4;
    border-radius: 14px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    font-family: 'Segoe UI', sans-serif;
    background: white;
    transition: transform 0.2s ease;
}
.sensor-icon {
    height: 31px;
    width: auto;
}
.sensor-card .pump-image img[alt="sensor-icon"] {
    height: 35px !important; 
}
.card-header {
    background-color: #EEE1E1;
    color: white;
    padding: 12px 20px;
    font-size: 18px;
    font-weight: 600;
    letter-spacing: 0.5px;
}
.card-headerr {
    background: #CD5C5C;
    color: white;
    padding: 12px 20px;
    font-size: 20px;
    font-weight: 600;
    letter-spacing: 0.5px;
}
.pump-image {
    display: flex;
    position: relative;
    text-align: center;
    margin: 9px;
    
}
.sensor-card img.pump-img {
    width: 90%;
    height: auto;
    border-radius: 8px;
    margin-top: 10px;

}
.status-dot {
    display: inline-block;
    height: 29px;
    width: 26px;
    border-radius: 50%;
    margin-left: 8px;
}
@media (max-width: 576px) {
    .card-header {
        font-size: 14px;
        height: 50px;
    }
}
.card .card-body {
    padding: 10px;

}
.sensor-wrapper {
    position: relative;
    width: 100%;
    max-width: 600px; 
    height: auto;
}
.sensor_one, .sensor-two, .sensor-two_one,
.sensor-three, .sensor-four {
    position: absolute;
}
.sensor_one     { left: 14%;  top: 4%; }
.sensor-two     { left: 37%; top: 20%; }
.sensor-two_one { left: 70%; top: 35%; }
.sensor-three   { left: 41%; top: 63%; }
.sensor-four    { left: 70%; top: 62%; }

.sensor_one_data, .sensor_two_data,
.sensor_two_data_two, .sensor_three_data,
.sensor_four_data {
    position: absolute;
    display: flex;
    border: 1px solid #ccc;
    background: #fff;
    padding: -2px ;      
    font-size: 12px;
    font-weight: 500;
    border-radius: 3px;    
    box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    min-width: 68px;        
    justify-content: center; 
}
.sensor_one_data     { left: 100%; bottom: 48%; }
.sensor_two_data     { left: 100%; bottom: 45%; }
.sensor_two_data_two { left: 96%; bottom: 60%; }
.sensor_three_data   { left: 88%; bottom: 87%; }
.sensor_four_data    { left: 88%; bottom: 87%; }
.card-footer {
    background-color: #fafafa;
    padding: 4px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.card-footer .datetime {
    font-size: 14px;
    color: #333;
    font-weight: 500;
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



        <!-- Dashboard Cards -->
            <div class="col-md-12 col-xl-12">
        <div class="d-flex align-items-center">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3 position-relative">
                        <div class="card text-center shadow-sm rounded-2 pt-4 mt-3 pb-3 px-2 border-0 border-start border-end border-3 border-danger">
        
                        <div class="position-absolute top-0 start-50 translate-middle" style="width: 60px; height: 60px; z-index: 1;">
                            <img src="<?php echo base_url('assets/icons/oil.png'); ?>" alt="img" class="img-fluid rounded-circle bg-light shadow" style="width: 100%; height: 100%; object-fit: cover; border: 2px solid #ef4d56;">
                        </div>
                        <div class="content-area text-center mt-2">
                            <span class="tag-name" style="color: #312929;margin-top: 5px; display: inline-block;">Total Wells</span><br>
                            <span class="tag-count" id="total_well"></span>
                        </div>
                       </div>
                   </div>

                    <div class="col-md-3 position-relative">
                       <div class="card text-center shadow-sm rounded-2 pt-4 mt-3 pb-3 px-2 border-0 border-start border-end border-3 border-success">
        
                        <div class="position-absolute top-0 start-50 translate-middle" style="width: 60px; height: 60px; z-index: 1;">
                            <img src="<?php echo base_url('assets/icons/02.png'); ?>" alt="Complaint" class="img-fluid rounded-circle bg-light shadow" style="width: 100%; height: 100%; object-fit: cover; border: 2px solid #22c5ad;">
                        </div>
                        <div class="content-area text-center mt-2">
                            <span class="tag-name" style="color: #312929;margin-top: 5px; display: inline-block;">Flowing Wells</span><br>
                            <span class="tag-count" id="total_flowing_well"></span>
                        </div>
                       </div>
                   </div>

                    <div class="col-md-3 position-relative">
                       <div class="card text-center shadow-sm rounded-2 pt-4 mt-3 pb-3 px-2 border-0 border-start border-end border-4 border-danger">
                        <div class="position-absolute top-0 start-50 translate-middle" style="width: 60px; height:60px; z-index: 1;">
                            <img src="<?php echo base_url('assets/icons/04.png'); ?>" alt="Complaint" class="img-fluid rounded-circle bg-light shadow" style="width: 100%; height: 100%; object-fit: cover; border: 2px solid #ef4d56;">
                        </div>
                         <div class="content-area text-center mt-2">
                            <span class="tag-name" style="color: #312929;margin-top: 5px; display: inline-block;">Non-Flowing Wells</span><br>
                            <span class="tag-count" id="total_non_flowing_well"></span>
                        </div>
                       </div>
                   </div>

                    <div class="col-md-3 position-relative">
                       <div class="card text-center shadow-sm rounded-2 pt-4 mt-3 pb-3 px-2 border-0 border-start border-end border-4 border-success">
                        <div class="position-absolute top-0 start-50 translate-middle" style="width: 60px; height:60px; z-index: 1;">
                            <img src="<?php echo base_url('assets/icons/10.png'); ?>" alt="Complaint" class="img-fluid rounded-circle bg-light shadow" style="width: 100%; height: 100%; object-fit: cover; border: 2px solid #22c5ad;">
                        </div>
                        <div class="content-area text-center mt-2">
                            <span class="tag-name" style="color: #312929;margin-top: 5px; display: inline-block";>RTMS Non-Functional</span><br>
                            <span class="tag-count" id="off_unit"></span>
                        </div>
                       </div>
                   </div>
                </div>
            </div>
        </div>
    </div>
       <!--  <div class="col-md-12 col-xl-12">
            <div class="row mt-4">
                <div class="col-md-3 mt-2">
                    <a href="<?= base_url('Overall_list_selfflow_c/overall_details_total') ?>" onclick="setId();">
                        <div class="card small-card">
                            <div class="card-content p-0">
                                <div class="icon-counter gap-2 mt-2">
                                    <div class="icons mb-2" style="bottom:50px; background:#f2dee5">
                                       <img src="<?= base_url('assets/icons/oil.png') ?>" style="max-width: 117%; height: 41px;">

                                    </div>
                                    <div class="content-area text-center">
                                      <span class="tag-name" style="color: #312929; margin-top: 5px; display: inline-block;">Total Wells</span><br>
                                        <span class="tag-count" id="total_well"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
               <div class="col-md-3 mt-2">
                    <a href="<?= base_url('Overall_list_selfflow_c/overall_details_flowing') ?>">
                        <div class="card small-card">
                            <div class="running-card p-0">
                                <div class="icon-counter gap-2 mt-2">
                                    <div class="icons mb-2" style="bottom:50px;background:#f2dee5">
                                        <img src="<?= base_url('assets/icons/02.png') ?>" style="max-width: 117%; height: 41px;">
                                    </div>
                                    <div class="content-area text-center mt-2">
                                        <span class="tag-name" style="color: #312929;margin-top: 5px; display: inline-block;">Flowing Wells</span><br>
                                        <span class="tag-count" id="total_flowing_well"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 mt-2">
                    <a href="<?= base_url('Overall_list_selfflow_c') ?>">
                        <div class="card small-card">
                            <div class="power-cut-card p-0">
                                <div class="icon-counter gap-2 mt-2">
                                    <div class="icons mb-2" style="bottom: 50px; background:#f2dee5">
                                        <img src="<?= base_url('assets/icons/04.png') ?>" style="max-width: 117%; height: 41px;">
                                    </div>
                                    <div class="content-area text-center mt-2">
                                        <span class="tag-name" style="color: #312929;margin-top: 5px; display: inline-block;">Non-Flowing Wells</span><br>
                                        <span class="tag-count" id="total_non_flowing_well"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 mt-2">
                    <a href="<?= base_url('Overall_list_selfflow_c/overall_details_rtms') ?>">
                    </a>
                    <div class="card small-card">
                        <div class="faulty-card p-0">
                            <div class="icon-counter gap-2 mt-2">
                                <div class="icons mb-2" style="bottom: 50px; background:#f2dee5">
                                    <img src="<?= base_url('assets/icons/03.png') ?>" style="max-width: 117%; height: 41px;">
                                </div>
                                <div class="content-area text-center mt-2">
                                    <span class="tag-name" style="color: #312929;margin-top: 5px; display: inline-block";>RTMS Non-Functional</span><br>
                                    <span class="tag-count" id="off_unit"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- Well Details Card -->
        <div class="row">
            <div class="col-xl-12 col-md-12">
                <div class="card">
                    <!-- Header with Legends -->
                   <div class="card-headerr d-flex justify-content-between align-items-center flex-wrap" style="background-color: #CD5C5C; color: white; padding: 4px; cursor: pointer; min-height:46px;">
                        <div class="d-flex align-items-center me-auto" style="padding-left: 10px;">
                            <img src="<?= base_url('assets/img/oil-pump.gif') ?>" width="40"
                                style="border-radius: 25%; margin-right: 10px;">
                            <h4 style="margin: 0;">
                                <strong>Well Details&nbsp;</strong>
                                <span class="circle" id="totalcount" style="background-color: #312929;"></span>
                            </h4>
                        </div>
                        <div class="indicator d-flex flex-wrap align-items-center gap-3" style="padding-right: 8px;">
                            <div class="d-flex align-items-center gap-2">
                                <div style="background-color: rgb(215, 51, 36); width: 16px; height: 16px; border-radius: 50%;"></div>
                                <span style="font-size: 13px;">Non Flowing Wells</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <div style="background-color:#06E763; width: 16px; height: 16px; border-radius: 50%;"></div>
                                <span style="font-size: 13px;">Flowing Well</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <div style="background-color: #394f62; width: 16px; height: 16px; border-radius: 50%;"></div>
                                <span style="font-size: 13px;">RTMS Non-Functional Wells</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="padding: 9px;">
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
                        style="background-color: #CD5C5C; color: white; padding: 4px; cursor: pointer; min-height: 50px;">

                        <!-- Left: Image + Title -->
                        <div class="d-flex align-items-center me-auto">
                            <img src="<?= base_url('assets/img/map.gif') ?>" width="40"
                                style="border-radius: 25%; margin-right: 10px;">
                            <h4 style="margin: 0;">
                                <strong>Asset GIS</strong>
                                <span class="circle" id="totalcount" style="background-color: #312929;"></span>
                            </h4>
                        </div>

                        <!-- Right: Indicator Legend -->
                        <div class="indicator d-flex flex-wrap align-items-center gap-3" style="padding-right: 10px;">
                            <div class="d-flex align-items-center gap-2">
                                <div style="background-color: rgb(215, 51, 36); width: 16px; height: 16px; border-radius: 50%;"></div>
                                <span style="font-size: 13px;">Non Flowing Wells</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <div style="background-color:#06E763; width: 16px; height: 16px; border-radius: 50%;"></div>
                                <span style="font-size: 13px;">Flowing Well</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <div style="background-color: #394f62; width: 16px; height: 16px; border-radius: 50%;"></div>
                                <span style="font-size: 13px;">RTMS Non-Functional Wells</span>
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
    let well_type = $('#well_type').val();
    let site_id = $('#site_id').val();
    let feeder_id = $('#feeder_id').val();
    let assets_id = $('#assets_id').val();

    $.ajax({
        url: '<?php echo base_url(); ?>Selfflow_c/get_dashboard_count',
        type: 'POST',
        data: {
            company_id: company_id,
            area_id: area_id,
            well_id: well_id,
            well_type: well_type,
            site_id: site_id,
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
                    $('#totalcount').text(res.data.total_well_count ?? 0);

                    // Safely calculate total_data
                    let total_data = 
                        (parseInt(res.data.total_temperory_well) || 0) +
                        (parseInt(res.data.faulty_well) || 0) +
                        (parseInt(res.data.timer_off_well) || 0) +
                        (parseInt(res.data.power_cut_well) || 0) +
                        (parseInt(res.data.ON_Well) || 0);

                    let total_well = parseInt(res.data.total_well) || 0;
                    let off_func = total_well - total_data;
                    let off_func_data = off_func < 0 ? 0 : off_func;

                    $('#off_unit').text(off_func_data);
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
    let well_type = $('#well_type').val();
    let site_id = $('#site_id').val();
    let user_type = '<?php echo $this->session->userdata('user_type') ?>';
    let role_type = '<?php echo $this->session->userdata('role_type') ?>';

    $.ajax({
        url: '<?php echo base_url(); ?>Selfflow_c/well_card_data',
        method: 'POST',
        data: {
            area_id: area_id,
            well_id: well_id,
            well_type: well_type,
            site_id: site_id,
            user_type: user_type,
            role_type: role_type
        },
        success: function(res) {
            var response = JSON.parse(res);
            console.log(res, 'well_details');

            if (response.response_code == 200) {
                if (response.data.length > 0) {
                    $("#well_area_card").html('');

                    $.each(response.data, function(i, v) {
                        var statusColor = '';
                        if (v.status_variable === 'flowing_well') {
                            statusColor = 'green';
                        } else if (v.status_variable === 'non_flowing_well') {
                            statusColor = 'red';
                        } else {
                            statusColor = '#394f62'; // Default for offline or unknown
                        }

                        var link = '<?php echo base_url("Selfflow_c/SingleWellDashboard/"); ?>' + v.well_id 

                        $("#well_area_card").append(
                            '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">' +
                            '<div class="sensor-card responsive-card" style="min-width:235px;">' +
                            '<div class="card-header d-flex justify-content-between align-items-center" style="padding: 3px; text-align: left; color: black;">' +
                            '<span style="margin-left: 7px;">' + v.well_name + '</span>' +
                            '<span class="status-dot" style="height: 29px; width: 26px; border-radius: 50%; background-color:'  + '; display: inline-block;"></span>' +
                            '</div>' +
                            '<div class="pump-image">' +
                            '<div class="sensor_one"><img src="<?= base_url('assets/icons/psr.png') ?>" class="sensor-icon"><div class="sensor_one_data"><strong>THT ' + v.FLTP_1_Temp + '</strong></div></div>' +
                            '<div class="sensor-two"><img src="<?= base_url('assets/icons/psr.png') ?>" class="sensor-icon"><div class="sensor_two_data"><strong>THP ' + v.PS_3_THP + '</strong></div></div>' +
                            '<div class="sensor-two_one"><img src="<?= base_url('assets/icons/psr.png') ?>" class="sensor-icon"><div class="sensor_two_data_two"><strong>ABP ' + v.PS_4_ABP + '</strong></div></div>' +
                            '<div class="sensor-three"><img src="<?= base_url('assets/icons/psr.png') ?>" class="sensor-icon"><div class="sensor_three_data"><strong>CHP ' + v.PS_2_CHP + '</strong></div></div>' +
                            '<div class="sensor-four"><img src="<?= base_url('assets/icons/psr.png') ?>" class="sensor-icon"><div class="sensor_four_data"><strong>GIP ' + v.PS_1_GIP + '</strong></div></div>' +
                            '<img class="pump-img" src="<?= base_url('assets/icons/11.jpg') ?>" class="sensor-icon">' +
                            '</div>' +
                            '<div class="card-footer d-flex justify-content-between align-items-center">' +
                            '<div class="datetime"><strong>' + v.Log_Date_Time + '</strong></div>' +
                            '<button class="button" onclick="window.location.href=\'' + link + '\'"><i class="fas fa-info-circle fa-lg"></i></button>' +
                            '</div>' +
                            '</div>' +
                            '</div>'
                        );
                    });

                } else {
                    $('#well_area_card').html('<div class="card card-body mx-3 mt-3">' +
                        '<div class="text-danger" style="text-align:center;" colspan="6"><h4>No Well Found !!</h4></div>' +
                        '</div>');
                }
            }
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
    let well_type = $('#well_type').val();
    let site_id = $('#site_id').val();
   
    $.ajax({
        url: '<?php echo base_url(); ?>Selfflow_c/get_site_location_for_dashboard',
        type: 'POST',
        data: {
            area_id,
            well_id,
            well_type,
            site_id
        },
        success: function(res) {
            let response;
            try {
                response = JSON.parse(res);
            } catch (error) {
                console.error("Invalid JSON response:", error);
                return;
            }

            if (response.data && Array.isArray(response.data)) {
                const markers = response.data.map(item => ({
                    position: {
                        lat: parseFloat(item.lat),
                        lng: parseFloat(item.long)
                    },
                    title: item.well_name,
                    well_id: item.well_id,
                    offline_time: item.Log_Date_Time,
                    flag_status: item.flag_status,
                    long: item.long,
                    lat: item.lat,
                    site: item.site_id,
                    area_id: item.area_id,
                    well_type: item.well_type,
                }));

                const map = new google.maps.Map(document.getElementById('mymap'), {
                    zoom: 13,
                    center: {
                        lat: 21.62640  ,
                        lng:  73.0152
                    }
                });

                const timeLimit = (user_type == 2 || (user_type == 3 && role_type == 3)) ? 900 : 7200;

                markers.forEach((marker, index) => {
                    const baseUrl = '<?php echo base_url(); ?>assets/img/';
                    let markerIcon = {
                        url: baseUrl + 'offline.png',
                        scaledSize: new google.maps.Size(20, 20)
                    };

                    const lastDataTimeObj = marker.offline_time ? new Date(marker.offline_time) : null;
                    const seconds = lastDataTimeObj ? Math.floor((new Date() - lastDataTimeObj) / 1000) : Infinity;

                    if (!marker.offline_time || seconds > timeLimit) {
                        markerIcon.url = baseUrl + 'offline.png';
                    } else if (seconds <= timeLimit && marker.flag_status == 0) {
                        markerIcon.url = baseUrl + 'green.png';
                    } else if (seconds <= timeLimit && marker.flag_status == 1) {
                        markerIcon.url = baseUrl + 'red.png';
                    }

                    const adjustedPosition = {
                        lat: parseFloat(marker.lat) + index * 0.000001,
                        lng: parseFloat(marker.long) + index * 0.000001
                    };

                    const mapMarker = new google.maps.Marker({
                        position: adjustedPosition,
                        map,
                        icon: markerIcon,
                        title: marker.title,
                    });
                    let statusText = '';

                    if (!marker.offline_time || seconds > timeLimit) {
                        statusText = 'RTMS Non functional Well';
                    } else if (seconds <= timeLimit && marker.flag_status == 0) {
                        statusText = 'Flowing Well';
                    } else if (seconds <= timeLimit && marker.flag_status == 1) {
                        statusText = 'Non-Flowing Well';
                    } else {
                        statusText = 'RTMS Non functional Well';
                    }

                    const infowindow = new google.maps.InfoWindow({
                        content: `
                            <div class="site-info" style="width: 150px; height: auto;">
                                <h6><a target="_blank" href="https://www.google.com/maps/place/${marker.lat},${marker.long}">View on Google Maps</a></h6>
                                <h6>${marker.title}</h6>
                                <h6><b>Well Status</b>: ${statusText}</h6>
                                <h6><b><a href="<?php echo base_url(); ?>Selfflow_c/SingleWellDashboard/${marker.well_id}/${marker.site}/${marker.area_id}/${marker.well_type}">View Details</a></b></h6>
                            </div>`
                    });

                    mapMarker.addListener('click', () => infowindow.open(map, mapMarker));
                    map.addListener('click', () => infowindow.close());
                });
            } else {
                console.error("Invalid or empty data array");
            }
        }
    });
}
</script>