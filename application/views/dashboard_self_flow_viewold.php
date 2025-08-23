<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
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
 .sensor_one {
        position: absolute;
        left: 47%;   /* 133px ≈ 15% of screen width */
    top: 10vh;
    }
@media (max-width: 992px) {
    .sensor_one {
        left: 40%;
        top: 12vh;
    }
}

/* Mobile */
@media (max-width: 576px) {
    .sensor_one {
        left: 35%;
        top: 15vh;
    }
}
    .sensor_six {
        position: absolute;
         top:18vh;   /* 94px ≈ 12% of screen height */
    left: 74%;
    }

    .sensor-two {
  position: absolute;
    left: 45%;
    top: 30vh;   /* 164px ≈ 22% of viewport height */
    }

    .sensor-two_one {
        position: absolute;
    top: 18vh;
    left: 62%; 
    }

    .sensor_two_data_two {
        position: relative;
        bottom: 56px;
        border: 1px solid grey;
        padding: 0px 5px;
        left: 8px;
        font-size: 10px;
        border-radius: 3px;
    }

    .sensor-three {
        position: absolute;
        top: 127px;
        left: 223px;
    }

    .sensor-four {
        position: absolute;
        bottom:66px;
        left: 277px;
    }

    .sensor_one_data {
        position: relative;
        border: 1px solid #808080e3;
        padding: 0px 5px;
        left: -22px;
        bottom: 55px;
        font-size: 10px;
        border-radius: 3px;
    }
    .sensor_six_data {
        position: relative;
    border: 1px solid #808080e3;
    padding: 0px 5px;
    left: 9px;
    bottom: -17px;
    font-size: 10px;
    border-radius: 3px;
    }

    .sensor_two_data {
        position: relative;
        border: 1px solid #808080e3;
        padding: 0px 5px;
        left: -3px;
        bottom: 51px;
        font-size: 10px;
        border-radius: 3px
    }

    .sensor_three_data {
        position: relative;
        border: 1px solid #808080e3;
        padding: 0px 5px;
        left: -17px;
        bottom: 56px;
        font-size: 10px;
        border-radius: 5px;
    }

    .sensor_four_data {
        border: 1px solid grey;
        position: absolute;
        padding: 2px 5px;
        left: -40px;
        bottom: -36px;
        font-size: 10px;
        border-radius: 3px;
        transform-origin: bottom left; /* controls pivot point */
        white-space: nowrap; /* keeps text in one line */
    }

 .well_image img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        display: block;
    }


    @media (min-width: 768px) {
        .well_image {
            padding-left: 15px;
        }
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
.tooltip-container {
  position: relative;
  display: inline-block;
}

.tooltip-container .tooltip {
  position: absolute;   /* 👈 ab yeh parent ke upar float karega */
  visibility: hidden;
  background-color: #5D6D7E;
  color: #fff;
  font-size: 12px;
  text-align: center;
  padding: 8px 12px;
  border-radius: 4px;

  bottom: 125%;   /* text ke upar dikhayega */
  left: 50%;
  transform: translateX(-50%);
  z-index: 10;

  white-space: normal;
  max-width: 320px;
  min-width: 200px;
  word-wrap: break-word;

  opacity: 0;
  transition: opacity 0.3s;
  pointer-events: none;  /* 👈 size effect remove */
}

.tooltip-container .tooltip::after {
  content: "";
  position: absolute;
  top: 100%;
  left: 50%;
  margin-left: -6px;
  border-width: 6px;
  border-style: solid;
  border-color: #358a48cf transparent transparent transparent;
}

.tooltip-container:hover .tooltip {
  visibility: visible;
  opacity: 1;
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
        <div class="card text-center shadow-sm rounded-2 pt-4 mt-3 pb-3 px-2 border-0 border-start border-end border-3 border-danger">
            <div class="position-absolute top-0 start-50 translate-middle" style="width: 60px; height: 60px; z-index: 1;">
                <img src="<?php echo base_url('assets/icons/oil.png'); ?>" alt="img" class="img-fluid rounded-circle bg-light shadow" style="width: 100%; height: 100%; object-fit: cover; border: 2px solid #ef4d56;">
            </div>
            <div class="content-area text-center mt-2">
                <a href="<?= base_url('Overall_list_selfflow_c/overall_details_total') ?>" onclick="setId();" class="tooltip-container">
                    <span class="tag-name" style="color: #312929;margin-top: 5px; display: inline-block;">Total Wells</span><br>
                    <span class="tag-count" id="total_well"></span>
                    <!-- Tooltip absolutely placed -->
                    <div class="tooltip"><b>Click to view overall total wells details</b></div>
                </a>
            </div>
        </div>
    </div>
    <!-- Flowing Wells -->
   <div class="col-md-3 position-relative">
    <div class="card text-center shadow-sm rounded-2 pt-4 mt-3 pb-3 px-2 border-0 border-start border-end border-3 border-success">
        <div class="position-absolute top-0 start-50 translate-middle" style="width: 60px; height: 60px; z-index: 1;">
            <img src="<?php echo base_url('assets/icons/02.png'); ?>" alt="Complaint" 
                 class="img-fluid rounded-circle bg-light shadow" 
                 style="width: 100%; height: 100%; object-fit: cover; border: 2px solid #22c5ad;">
        </div>
        <div class="content-area text-center mt-2">
            <a href="<?= base_url('Overall_list_selfflow_c/overall_details_flowing') ?>" 
               class="tooltip-container">
                <span class="tag-name" style="color: #312929;margin-top: 5px; display: inline-block;">
                    Flowing Wells
                </span><br>
                <span class="tag-count" id="total_flowing_well"></span>

                <!-- Tooltip absolutely placed -->
                <div class="tooltip"><b>Click to view overall flowing wells details</b></div>
            </a>
        </div>
    </div>
</div>


    <!-- Non-Flowing Wells -->
    <div class="col-md-3 position-relative">
        <a href="<?= base_url('Overall_list_selfflow_c') ?>">
            <div class="card text-center shadow-sm rounded-2 pt-4 mt-3 pb-3 px-2 border-0 border-start border-end border-3 border-danger">
                <div class="position-absolute top-0 start-50 translate-middle" style="width: 60px; height:60px; z-index: 1;">
                    <img src="<?php echo base_url('assets/icons/04.png'); ?>" alt="Complaint" class="img-fluid rounded-circle bg-light shadow" style="width: 100%; height: 100%; object-fit: cover; border: 2px solid #ef4d56;">
                </div>
                <div class="content-area text-center mt-2">
                    <span class="tag-name" style="color: #312929;margin-top: 5px; display: inline-block;">Non-Flowing Wells</span><br>
                    <span class="tag-count" id="total_non_flowing_well"></span>

                </div>
            </div>
        </a>
    </div>

    <!-- RTMS Non-Functional -->
    <div class="col-md-3 position-relative">
        <a href="<?= base_url('Overall_list_selfflow_c/overall_details_rtms') ?>">
            <div class="card text-center shadow-sm rounded-2 pt-4 mt-3 pb-3 px-2 border-0 border-start border-end border-3 border-success">
                <div class="position-absolute top-0 start-50 translate-middle" style="width: 60px; height:60px; z-index: 1;">
                    <img src="<?php echo base_url('assets/icons/10.png'); ?>" alt="Complaint" class="img-fluid rounded-circle bg-light shadow" style="width: 100%; height: 100%; object-fit: cover; border: 2px solid #22c5ad;">
                </div>
                <div class="content-area text-center mt-2">
                    <span class="tag-name" style="color: #312929;margin-top: 5px; display: inline-block;">RTMS Non-Functional</span><br>
                    <span class="tag-count" id="off_unit"></span>
                </div>
            </div>
        </a>
    </div>
</div>
        <div class="row">
            <div class="col-xl-12 col-md-12">
                <div class="card">
                    <!-- Header with Legends -->
                   <div class="card-headerr d-flex justify-content-between align-items-center flex-wrap" style="background-color: #CD5C5C; color: white; padding: 4px; cursor: pointer; min-height:46px; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                        <div class="d-flex align-items-center me-auto" style="padding-left: 10px;">
                            <img src="<?= base_url('assets/img/oil-pump.gif') ?>" width="40"
                                style="border-radius: 25%; margin-right: 10px;">
                            <h4 style="margin: 0;">
                                <strong>Well Details&nbsp;</strong>
                                <!-- <span class="circle" id="totalcount" style="display:inline-block;width:30px;height:30px;border-radius:50%;background-color:#312929;margin-left:8px;"></span> -->
                                <badge class="circle" id="totalcount"style="background-color:#515A5A;" id="totalcount">190</badge>
                            </h4>
                        </div>
                        <div class="indicator d-flex flex-wrap align-items-center gap-3" style="padding-right: 8px;">
                            <div class="d-flex align-items-center gap-2">
                                <div style="background-color: rgb(215, 51, 36); width: 16px; height: 16px; border-radius: 50%;"></div>
                                <span style="font-size: 13px;">Non Flowing Wells</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <div style="background-color:#75A47F; width: 16px; height: 16px; border-radius: 50%;"></div>
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
                        style="background-color: #CD5C5C; color: white;  cursor: pointer; min-height: 50px;border-top-left-radius: 10px; border-top-right-radius: 10px;">

                        <!-- Left: Image + Title -->
                        <div class="d-flex align-items-center me-auto">
                            <img src="<?= base_url('assets/img/map.gif') ?>" width="40"
                                style="border-radius: 25%; margin-right: 10px;margin-left: 10px;">
                            <h4 style="margin: 0;">
                                <strong>Asset GIS</strong>
                                <!-- <span class="circle" id="totalcount" style="background-color: #312929;"></span> -->
                            </h4>
                        </div>

                        <!-- Right: Indicator Legend -->
                        <div class="indicator d-flex flex-wrap align-items-center gap-3" style="padding-right: 10px;">
                            <div class="d-flex align-items-center gap-2">
                                <div style="background-color: rgb(215, 51, 36); width: 16px; height: 16px; border-radius: 50%;"></div>
                                <span style="font-size: 13px;">Non Flowing Wells</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <div style="background-color:#75A47F; width: 16px; height: 16px; border-radius: 50%;"></div>
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

<!-- Threshold Setup Offcanvas -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="addThreshold_data" aria-labelledby="offcanvasRightLabel" style="width:600px;">
    <!-- Header -->
    <div class="offcanvas-header text-primary" style="background: #f1f1f1;">
        <h5 id="offcanvasRightLabel" class="offcanvas-title" style="color:#231692;">
            Threshold Setup <span id="well_name" style="color:#231692;"></span>
        </h5>
        <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <!-- Body -->
    <div class="offcanvas-body">
        <form class="custom-validation" method="POST" enctype="multipart/form-data" id="threshold_form">
                <div class="row mt-2">
    <!-- CHP -->
    <div class="col-md-12 d-flex align-items-center mb-2">
        <div class="col-md-2"><b>CHP</b></div>
        <div class="col-md-5 pe-1">
            <input type="number" class="form-control" name="chp_upper" id="chp_upper" placeholder="Upper CHP">
        </div>
        <div class="col-md-5">
            <input type="number" class="form-control" name="chp_lower" id="chp_lower" placeholder="Lower CHP">
        </div>
    </div>

    <!-- THP -->
    <div class="col-md-12 d-flex align-items-center mb-2">
        <div class="col-md-2"><b>THP</b></div>
        <div class="col-md-5 pe-2">
            <input type="number" class="form-control" name="thp_upper" id="thp_upper" placeholder="Upper THP">
        </div>
        <div class="col-md-5">
            <input type="number" class="form-control" name="thp_lower" id="thp_lower" placeholder="Lower THP">
        </div>
    </div>

    <!-- ABP -->
    <div class="col-md-12 d-flex align-items-center mb-2">
        <div class="col-md-2"><b>ABP</b></div>
        <div class="col-md-5 pe-2">
            <input type="number" class="form-control" name="abp_upper" id="abp_upper" placeholder="Upper ABP">
        </div>
        <div class="col-md-5">
            <input type="number" class="form-control" name="abp_lower" id="abp_lower" placeholder="Lower ABP">
        </div>
    </div>

    <!-- flt -->
    <div class="col-md-12 d-flex align-items-center mb-2">
        <div class="col-md-2"><b>FLT</b></div>
        <div class="col-md-5 pe-2">
            <input type="number" class="form-control" name="flt_upper" id="flt_upper" placeholder="Upper FLt">
        </div>
        <div class="col-md-5">
            <input type="number" class="form-control" name="flt_lower" id="flt_lower" placeholder="Lower FLT">
        </div>
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
    $.ajax({
        url: '<?php echo base_url(); ?>Selfflow_c/well_card_data',
        method: 'POST',
        data: {
            area_id: area_id,
            well_id: well_id,
            well_type: well_type,
            site_id: site_id,
        },
        success: function(res) {
            var response = JSON.parse(res);
            console.log(res, 'well_details');

            if (response.response_code == 200) {
                if (response.data.length > 0) {
                    $("#well_area_card").html('');

                    $.each(response.data, function(i, v) {
                        let statusColor = '';
                        if (v.status_variable === 'flowing_well') {
                            statusColor = 'green';
                        } else if (v.status_variable === 'non_flowing_well') {
                            statusColor = 'red';
                        } else {
                            statusColor = '#394f62'; // Default
                        }

                        let link = '<?php echo base_url("Selfflow_c/SingleWellDashboard/"); ?>' + v.well_id;

                        // --- Card HTML ---
                        let cardHtml = `
                        <div class="col-md-4">
                        <div class="card shadow-sm">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-bold" style="font-size:14pxpx">${v.well_name}</h6>
                                <div class="status-circle" 
                                     style="width:20px;height:20px;border-radius:50%;background:${statusColor};">
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="card-body d-flex flex-column justify-content-center"> 
                            <div class="pump-image" style="position: relative;    padding: 11px;"> 
                                 <div class="sensor_one"> <img src="<?php echo base_url() ?>assets/img/psr.png" style="height:32px"> 
                                   <div class="sensor_one_data"> <strong>THP</strong> <span id="sensor-one-value"><span id="fthp_image"></span> (kg/cm²)</span> 
                                 </div> 
                                 </div> 
                                 <div class="sensor_six"> 
                                 <img src="<?php echo base_url() ?>assets/img/psr.png"style="height:32px"> 
                                   <div class="sensor_six_data"> <strong>FLT</strong> <span id="sensor-six-value"><span id="flt_image"></span> (°C)</span> 
                                   </div> 
                                </div> 
                                <div class="sensor-two"> 
                                 <img src="<?php echo base_url() ?>assets/img/psr.png"style="height:32px"> 
                                 <div class="sensor_two_data"> <strong>CHP</strong> <span id="sensor-two-value"><span id="chp_image"></span> (kg/cm²)</span> 
                                </div> 
                                </div> 
                                <div class="sensor-two_one"> <img src="<?php echo base_url() ?>assets/img/psr.png"style="height:32px"> 
                                <div class="sensor_two_data_two"> <strong>ABP</strong> <span id="sensor-five-value"><span id="abp_image"></span> (kg/cm²)</span> </div> </div>  </div> <div class="well_image"> <img src="<?php echo base_url() ?>assets/img/well_image.png" alt="pump-img"> </div> 
                            </div>      
                            <div class="card-footer d-flex justify-content-between align-items-center">
                                <div class="datetime">
                                    <small class="text-muted"><strong>${v.Log_Date_Time ? v.Log_Date_Time : 'N/A'}</strong></small>
                                </div>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-primary" onclick="window.location.href='${link}'">
                                        <i class="fas fa-info-circle fa-lg"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary" 
                                            data-bs-toggle="offcanvas" 
                                            data-bs-target="#addThreshold_data" 
                                            aria-controls="addThreshold_data">
                                        <i class="fas fa-sliders-h"></i>
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                    `;

                        $("#well_area_card").append(cardHtml);
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