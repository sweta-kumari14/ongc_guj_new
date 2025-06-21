<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<div id="loader-container" style="display:none;">
    <div class="loader"></div>
    <div id="loader-message">Please Wait while we are configuring.</div>
</div>
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"> -->
<style type="text/css">
   #export_btns{
        font-size: 16px;
        padding: 3px 13px;
    }
    #export_btns i{
        margin-right: -20px;
        position: relative;
        opacity: 0; 
        transition: all 0.5s ease-out;
    }
    #export_btns:hover i{
        opacity: 1; 
        margin-right: 2px;
    }
.form-label {
    margin-bottom: 0px;
}
#processing_message {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
    width: 100%;
    text-align: center;
}
.loader-img {
    height: 200px;
    width: 100px;
}
#loader-container {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: rgba(0, 0, 0, 0.5);
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 9999;
}

.loader {
    border: 4px solid #f3f3f3;
    border-top: 4px solid #3498db;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    animation: spin 1s linear infinite;
}

#loader-message {
    color: white !important;
    font-size: 20px;
    font-weight: bold;
    margin-left: 18%;
    margin-top: 65px;
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
}

.battery {
    padding: -1px 10px;
    width: 275px;
    border: solid thin black;
    position: relative;
}

.battery:after {
    content: " ";
    top: 14px;
    right: -7px;
    height: 20px;
    width: 7px;
    position: absolute;
    background: black;
}

.bar {
    cursor: pointer;
    display: inline-block;
    width: 0;
    border: solid thin rgb(36 34 34 / 52%);
    padding: 10px;
    height: 35px;
    background: #00000099;
    transition: background 1s;
    margin-top: 5px;
}

.bar.active {
    background: limegreen;
}

table {
    border-color: #80808075;
}

.well-last-update {
    position: relative;
    display: flex;
    flex-direction: row;
    gap: 8px;
}

.sensor_one {
    position: absolute;
    left: 64px;
    top: -10px;
}

.sensor-two {
    position: absolute;
    left: 150px;
    top: 60px;
}

.sensor-two_one {
    position: absolute;
    top: 115px;
    left: 260px;
}

.sensor_two_data_two {
    position: relative;
    bottom: 60px;
    border: 1px solid grey;
    padding: 0px 5px;
    left: 25px;
}

.sensor-three {
    position: absolute;
    top: 212px;
    left: 165px;
}

.sensor-four {
    position: absolute;
    top: 212px;
    left: 290px;
}

.sensor_one_data {
    position: relative;
    border: 1px solid #808080e3;
    padding: 0px 2px;
    left: 35px;
    bottom: 30px;
    font-size: 12px;
}

.sensor_two_data {
    position: relative;
    border: 1px solid #808080e3;
    padding: 0px 2px;
    left: 35px;
    bottom: 45px;
    font-size: 12px;
}

.sensor_three_data {
    position: relative;
    border: 1px solid #808080e3;
    padding: 0px 2px;
    left: 30px;
    bottom: 50px;
    font-size: 12px;
}
.sensor_one img{
  height: 35px !important;
}
.sensor-two img{
  height: 35px !important;
}
.sensor-three img{
  height: 35px !important;
}
.sensor-four img{
  height: 35px !important;
}
.sensor-two_one img{
  height: 35px !important;
}
.sensor_four_data {
    border: 1px solid grey;
    position: relative;
    padding: 0px 2px;
    left: 30px;
    bottom: 50px;
    font-size: 12px;
}

tspan {
    font-size: 14px;
    font-weight: 600;
}

.single-alert-log {
    height: 305px;
    overflow: scroll;
    scroll-behavior: smooth;
    scrollbar-width: none;
}

.select2-container--default .select2-selection--single {
    border: 1px solid #8299b557;
}

.select2-container .select2-selection--single {
    height: 35px;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 30px;
}
</style>

<div class="page-wrapper">
    <div class="content container-fluid pt-2">
    <div class="row">
      <div class="col-md-12">

<div class="col-md-12 col-xl-12 mt-2">
    <div class="card" style="background: linear-gradient(to left,#F1948A ,#5D6D7E);">

        <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md" style="flex: 0 0 30%; max-width: 30%;">
                            <div class="form-group">
                                <label for="example-select" class="form-label" style="color:white;">Area</label>
                                <select class="form-select select2" id="area_id" name="area_id"
                                    onchange="get_site_list();">
                                   <?php
                                    if (!empty($area_list)) {
                                        echo '<option value="">Select All</option>';
                                        foreach ($area_list as $key => $value) {
                                            $selected = ($value['id'] == $this->uri->segment(5)) ? 'selected' : '';
                                    ?>
                                    <option value="<?php echo $value['id']; ?>" <?php echo $selected; ?>>
                                        <?php echo $value['area_name']; ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>

                            </div>
                        </div>
                       <div class="col-md" style="flex: 0 0 30%; max-width: 30%;">
                            <div class="form-group">
                                <label for="example-select" class="form-label" style="color:white;">Installation/Field</label>
                                <select class="form-select select2" id="site_id" name="site_id"
                                    onchange="get_well_list();updateAlertLogLink();">

                                </select>
                            </div>
                        </div>
                       
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="example-select" class="form-label" style="color:white;">Well Name</label>
                                <select class="form-select select2" id="well_id" name="well_id">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1 pt-4">
                             <button class="btn btn-md btn-success"
                                onclick="get_single_well_details();Get_Graph();setupWebSocket();initMap();updateAlertLogLink();getAlertLog();get_pressure_details();get_temperory_well_value();"type="button">Generate</button></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="single-well-details-area">
    <div class="card"
        style="box-shadow: rgba(14, 30, 37, 0.12) 0px 2px 4px 0px, rgba(14, 30, 37, 0.32) 0px 2px 16px 0px;">
        <div class="card-body">
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="pump-image" style="position: relative;">
                            <div class="sensor_one">
                                <img height="35" src="<?php echo base_url() ?>assets/icons/psr.png" alt="sensor-icon">
                                <div class="sensor_one_data">
                                    <strong>THT : </strong> <span id="sensor-one-value"><span
                                            id="tht_image"></span></span>
                                </div>
                            </div>
                            <div class="sensor-two" >
                                <img height="35" src="<?php echo base_url() ?>assets/icons/psr.png" alt="sensor-icon">
                                <div class="sensor_two_data">
                                    <strong>THP : </strong> <span id="sensor-two-value"><span id="thp_image"></span>
                                </div>
                            </div>
                            <div class="sensor-two_one">
                                <img height="35" src="<?php echo base_url() ?>assets/icons/psr.png" alt="sensor-icon">
                                <div class="sensor_two_data_two">
                                    <strong>ABP : </strong> <span id="sensor-two-value"><span id="abp_image"></span>
                                </div>
                            </div>
                            <div class="sensor-three">
                                <img height="35" src="<?php echo base_url() ?>assets/icons/psr.png" alt="sensor-icon">
                                <div class="sensor_three_data">
                                    <strong>CHP : </strong> <span id="sensor-three-value"><span id="chp_image"></span>
                                </div>
                            </div>
                            <div class="sensor-four">
                                <img height="35" src="<?php echo base_url() ?>assets/icons/psr.png" alt="sensor-icon">
                                <div class="sensor_four_data">
                                    <strong>GIP : </strong> <span id="sensor-four-value"><span id="gip_image"></span>
                                </div>
                            </div>
                            <img src="<?php echo base_url() ?>assets/icons/11.jpg" alt="pump-img">
                        </div>
                        <div class="setup-btn pt-3 d-flex justify-content-start gap-2">
                            <a id="HistoricalLogLink"
                                href="<?php echo base_url() ?>Self_flow_well_historical_log_c">
                                <button type="button" class="btn btn-outline-secondary rounded-pill">Historical Data Log</button>
                            </a>
                            <a id="alertLogLink" href="<?php echo base_url() ?>Selfflow_alert_c">
                                <button type="button" class="btn btn-outline-secondary rounded-pill">Alert Log</button>
                            </a>
                            <?php
                            if ($this->session->userdata('user_type') == 3 || 2) {
                                if ($this->session->userdata('role_type') == 4 || 1) {
                            ?>
                            <a id="sovLogLink" href="<?php echo base_url() ?>Sov_report_c/">
                                <button type="button" class="btn btn-outline-secondary rounded-pill">SOV Log</button>
                            </a>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <input type="hidden" class="form-control" name="chped" id="chped">
                    <input type="hidden" class="form-control" name="giped" id="giped">
                    <input type="hidden" class="form-control" name="thped" id="thped">
                    <input type="hidden" class="form-control" name="abped" id="abped">

                    <div class="col-lg-4">
                        <div class="battery-card-details pt-1">
                            <div class="well-status pb-2">
                                <strong class="fs-16"> Well Type : </strong><span
                                    class="badge bg-danger-subtle text-danger fw-semibold rounded-pill fs-14"
                                    id="well_type_status" style="padding: 8px 18px;"></span>
                            </div>
                            <div id="project_container text-center">
                                <div id="projectbox">
                                    <div class='battery'>
                                        <div class='bar' data-power='10'></div>
                                        <div class='bar' data-power='20'></div>
                                        <div class='bar' data-power='30'></div>
                                        <div class='bar' data-power='40'></div>
                                        <div class='bar' data-power='50'></div>
                                        <div class='bar' data-power='60'></div>
                                        <div class='bar' data-power='70'></div>
                                        <div class='bar' data-power='80'></div>
                                        <div class='bar' data-power='90'></div>
                                        <div class='bar' data-power='100'></div>
                                    </div>
                                </div>
                                <div class="btry-title pt-1">
                                    <strong class="fs-15">Battery : </strong><span id="battery_value">0 V</span>
                                </div>
                                <div class="btry-title pt-1">
                                    <strong class="fs-15">Bean Size : </strong><span id="bean_size">W/B</span>
                                </div>
                                <div class="battery-parameters pt-3">
                                    <table class="table-responsive table-bordered" id="cyclic_time"
                                        style="display: none;">
                                        <tbody class="fs-12">
                                            <tr>
                                                <th style="padding: 2px 8px;">On Time : </th>
                                                <td style="padding: 2px 8px;"><span id="on_time"></span></td>

                                                <th style="padding: 2px 8px;">Off Time : </th>
                                                <td style="padding: 2px 8px;"><span id="off_time"></span></td>
                                            </tr>
                                            <tr>
                                                <th style="padding: 2px 6px;">Last Cycle : </th>
                                                <td style="padding: 2px 6px;"><span id="last_cycle"></span></td>
                                                <th style="padding: 2px 6px;">Next Cycle : </th>
                                                <td style="padding: 2px 6px;"><span id="next_cycle"></span></td>


                                            </tr>
                                        </tbody>
                                    </table>

                                    <table class="table-responsive table-bordered mt-3">
                                        <tbody class="fs-12">
                                            <tr>
                                                <th style="padding: 2px 6px;">Field Name</th>
                                                <th style="padding: 2px 6px;">Daily Average</th>
                                                <th style="padding: 2px 6px;">Monthly Average</th>
                                            </tr>
                                            <tr>
                                                <th style="padding: 2px 6px;">GIP</th>
                                                <td style="padding: 2px 6px;"><span id="gip_daily"></span></td>
                                                <td style="padding: 2px 6px;"><span id="gip_monthly"></span></td>
                                            </tr>
                                            <tr>
                                                <th style="padding: 2px 6px;">CHP</th>
                                                <td style="padding: 2px 6px;"><span id="chp_daily"></span></td>
                                                <td style="padding: 2px 6px;"><span id="chp_monthly"></span></td>
                                            </tr>
                                            <tr>
                                                <th style="padding: 2px 6px;">THP</th>
                                                <td style="padding: 2px 6px;"><span id="thp_daily"></span></td>
                                                <td style="padding: 2px 6px;"><span id="thp_monthly"></span></td>
                                            </tr>

                                            <tr>
                                                <th style="padding: 2px 6px;">ABP</th>
                                                <td style="padding: 2px 6px;"><span id="abp_daily"></span></td>
                                                <td style="padding: 2px 6px;"><span id="abp_monthly"></span></td>
                                            </tr>
                                            <tr>
                                                <th style="padding: 2px 6px;">THT</th>
                                                <td style="padding: 2px 6px;"><span id="tht_daily"></span></td>
                                                <td style="padding: 2px 6px;"><span id="tht_monthly"></span></td>
                                            </tr>
                                        </tbody>
                                    </table>


                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="battery-card-details pt-1">
                            <div id="project_container text-center">
                                <div class="battery-parameters">
                                    <div class="well-status pb-2">
                                        <strong class="fs-16"> Well Status : </strong><span
                                            class="badge bg-warning-subtle text-warning fw-semibold rounded-pill fs-14"
                                             style="padding: 8px 18px;" id="wellnamehdn"></span>
                                    </div>
                                    <table class="table-responsive table-bordered">
                                        <tbody class="fs-12">
                                            <thead>
                                                <tr>
                                                    <th class="fs-16 text-center" colspan="2"
                                                        style="padding: 2px 10px;"><strong>RTMS STATUS</strong></th>
                                                </tr>
                                            </thead>
                                            <tr>
                                                <th style="padding: 2px 4px;">Status </th>
                                                <td style="padding: 2px 4px;"><span id="rtms_status_text">Offline</span> <span
                                                        id="rtms_status_image"></span>
                                                </td>

                                            </tr>
                                            <tr>
                                                <th style="padding: 2px 4px;">Last Updated Time</th>
                                                <td><span id="last_updated_datetime"></span></td>
                                            </tr>
                                            <tr>
                                                <th style="padding:2px 4px;">Passcode</th>
                                                <th><span id="passcode"></span></th>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <table class="table-responsive table-bordered mt-4">
                                        <tbody class="fs-12">
                                            <thead>
                                                <tr>
                                                    <th class="fs-16 text-center" colspan="2"
                                                        style="padding: 2px 10px;"><strong>RTMS DETAILS</strong></th>
                                                </tr>
                                            </thead>

                                            <tr>
                                                <th style="padding: 2px 6px;">Device Name</th>
                                                <td style="padding: 2px 6px;"><span id="device_name"></span></td>
                                            </tr>
                                            <tr>
                                                <th style="padding: 2px 6px;">Imei No.</th>
                                                <td style="padding: 2px 6px;"><span id="imei_no"></span></td>

                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="setup-btn pt-3 d-flex justify-content-start gap-3">
                                        <?php
                                        if ($this->session->userdata('user_type') == 3) {
                                            if ($this->session->userdata('role_type') == 4) {
                                        ?>
                                        <button id="ietcc_btn_action" type="button"
                                            class="btn btn-outline-secondary rounded-pill" data-bs-toggle="offcanvas"
                                            data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"
                                            style="font-size:12px;display:none;">Update IETCC</button>

                                        <button type="button" class="btn btn-outline-secondary rounded-pill"
                                            data-bs-toggle="offcanvas" data-bs-target="#offcanvasTemporary"
                                            aria-controls="offcanvasRight" style="font-size:12px;">Flag Well</button>
                                        <?php
                                            } else if ($this->session->userdata('role_type') == 1) {
                                            ?>
                                        <button id="ietcc_btn_action" type="button"
                                            class="btn btn-outline-secondary rounded-pill" data-bs-toggle="offcanvas"
                                            data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"
                                            style="font-size:12px;display:none;">Update IETCC</button>
                                        <?php
                                            }
                                        } else if ($this->session->userdata('user_type') == 2) {
                                            ?>
                                        <button id="ietcc_btn_action" type="button"
                                            class="btn btn-outline-secondary rounded-pill" data-bs-toggle="offcanvas"
                                            data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"
                                            style="font-size:12px;display:none;">Update IETCC</button>

                                        <button type="button" class="btn btn-outline-secondary rounded-pill"
                                            data-bs-toggle="offcanvas" data-bs-target="#offcanvasTemporary"
                                            aria-controls="offcanvasRight" style="font-size:12px;">Flag Well</button>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-12 col-lg-12">
        <div class="card pressure-card" style="height: 520px;">
            <div class="card-header"
                style="padding: 8px; background-image: linear-gradient(to right, #00203fad, #0b2542a8);">
                <div class="row align-items-center">
                    <div  style="color:white;" class="col-md-6">
                    <img src="<?php echo base_url(); ?>assets/img/line-chart.gif" width="40" style="border-radius: 50%;">&nbsp;Graph&nbsp; &nbsp;
                   
                     </div>
                    <div class="col-md-6 d-flex justify-content-end align-items-center">
                        <input type="datetime-local" name="from_date" class="form-control me-2" id="from_date"
                            style="max-width: 160px;">
                        <input type="datetime-local" name="to_date" class="form-control me-2" id="to_date"
                            style="max-width: 160px;">
                        <button class="btn btn-danger me-2" onclick="Get_Graph()">Generate</button>
                        <button type="button" class="btn btn-light" onclick="resetDates()" style="padding: 6px 12px;">
                            <i class="fa-solid fa-arrows-rotate"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div id="processing_message" style="display: none;">
                  <img src="<?php echo base_url(); ?>assets/loader_img.svg" class="loader-img " alt="Loader" style="height:200px;width:100px;align-items: center!important;">
            </div>
            <div id="neutral_voltage" style="height: 600px; width: 100%;"></div>
        </div>
    </div>

    <div class="col-md-12 col-xl-12">
        <div class="row">
          <div class="col-md-8">
            <div class="card" style="height:300px;">
               <div class="card-header d-flex justify-content-between align-items-center" style="height:50px;position: sticky;top:0px;z-index:1;background-image: linear-gradient(to right, #00203fad, #0b2542a8);">
                  <div style="color:white;">
                     <img src="<?php echo base_url(); ?>assets/img/alert.gif" width="40" style="border-radius: 50%;">&nbsp; Alert Log&nbsp; &nbsp;
                     <badge class="badge badge-sm rounded-pill bg-blue" id="alert_count">0</badge>
                  </div>
               </div>
               <div class="card-body" style="overflow-y: scroll;">
                  <table class="table table-striped" style="font-size:12px">
                     <thead class="text-center">
                        <tr>
                           <th style="font-size:15px">S.No</th>
                           <th style="font-size:15px">Alert Type</th>
                           <th style="font-size:15px">Alert Status</th>
                           <th style="font-size:15px">Alert Date-Time</th>
                        </tr>
                     </thead>
                     
                    <tbody class="text-center" id="alert_log_table">
                     </tbody> 
                  </table>
               </div>
            </div>
         </div>

            <div class="col-md-4" >
              <div class="card" style="height:300px;">
            <div class="card-header d-flex justify-content-between align-items-center" style="height:50px;position: sticky;top:0px;z-index:1;background-image: linear-gradient(to right, #00203fad, #0b2542a8);">
                <div  style="color:white;">
                    <img src="<?php echo base_url(); ?>assets/img/map.gif" width="40" style="border-radius: 50%;">&nbsp;Well Gis Map&nbsp; &nbsp;
                   
                </div>

            </div>
            <div class="card-body" style="overflow-y: scroll;">
               <div  id="mymap" style="width:100%;height: 300px;"></div>
            </div>
            
        </div>
     </div>

        </div>
    </div>
</section>


<!-- Temporary off well -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasTemporary" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Mark Well Status As Non Flowing Well <span
                class="badge bg-success-subtle text-success fw-semibold rounded-pill" id="well_name_hdn"></span></h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="container" style="border: 1px solid #80808080;padding: 10px 10px;">
            <form class="custom-validation" method="POST"
                action="<?php echo base_url('Main_dashboard_c/add_well_reason'); ?>" enctype="multipart/form-data">
                <div class="row">
                    <input type="hidden" name="well_id_hdn" id="well_id_hdn">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label><strong>Temporary Off Reason</strong></label>
                            <select name="reason" id="reason" class="form-control select2">
                                <option value="">Select</option>
                                <?php
                                if (!empty($reason_list)) {
                                    foreach ($reason_list as $key => $value) {
                                ?>
                                <option value="<?php echo $value['id']; ?>"> <?php echo $value['reason']; ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 mt-2">
                        <div class="form-group">
                            <label><strong>Effective Date Time</strong></label>
                            <input type="datetime-local" id="effective_date_time" name="effective_date_time"
                                class="form-control" required value="<?php echo date('Y-m-d\TH:i'); ?>">
                        </div>
                    </div>
                    <div class="btns-section pt-3 text-center">

                        <div id="unflag">
                            <button type="submit" class="btn btn-danger rounded-pill" name="flag_status" value="0"><i
                                    class="fas fa-flag"></i>Un Flag</button>

                        </div>
                        <div id="flag">
                            <button type="submit" class="btn btn-success rounded-pill" name="flag_status" value="1"><i
                                    class="fas fa-flag"></i></i>Flag</button>
                        </div>
                    </div>
                    <div class="cyclic-time pt-3 text-center" id="flag_by">
                        <strong>Last Updated : </strong><span id="c_date"></span><br>
                        <strong>Update By : </strong><span id="created_by"></span>
                    </div>
                    <div class="cyclic-time pt-3 text-center" id="un_flag_by">
                        <strong>Last Updated : </strong><span id="d_date"></span><br>
                        <strong>Update By : </strong><span id="update_by"></span>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- end Temporary -->

<!-- right off canvas  -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Update Controls of well <span
                class="badge bg-success-subtle text-success fw-semibold rounded-pill" id="wellnamehdn"></span></h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="container" style="border: 1px solid #80808080;padding: 10px 10px;">
            <form method="post">

                <input type="hidden" name="wellidhdn" id="wellidhdn" class="form-control">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-md-12">
                            <label><strong>Imei No.</strong></label>
                            <input type="text" name="imei_no_hdn" id="imei_no_hdn" class="form-control">
                        </div>
                        
                        <div class="col-md-12 pt-2">
                            <div class="form-group">
                                <label><strong>On Time(Minutes)</strong></label>
                                <input type="number" name="ontime" id="ontime" class="form-control"
                                    placeholder="Enter on time">
                            </div>

                        </div>
                        <div class="col-md-12 pt-2">
                            <div class="form-group">
                                <label><strong>Off Time(Minutes)</strong></label>
                                <input type="number" name="offtime" id="offtime" class="form-control"
                                    placeholder="Enter off time">
                            </div>

                        </div>
                        <div class="col-md-12 pt-2">
                            <div class="form-group">
                                <label><strong>Target Time</strong></label>
                                <input type="time" name="target_time" id="target_time" class="form-control">
                            </div>

                        </div>

                        <div class="cyclic-time pt-3 text-center">
                            <button type="button" class="btn btn-primary mt-2 text-center" onclick="SendCammandForm()">Update
                            </button>
                        </div>
                    </div>

                </div>
            </form>
            <div class="cyclic-time pt-3 text-center">
                <strong>Cycle Time : </strong><span id="cycleTime">00:00:00</span>
                <strong>Target Time : </strong><span id="targetTimeDisplay">00:00:00</span>
            </div>
            <div class="cyclic-time pt-3 text-center">
                <strong>Last Updated Time : </strong><span id="command_log_date"></span><br>
                <strong>User By: </strong><span id="command_update_by"></span>
            </div>
        </div>
    </div>
</div>

<div id="loader_for_sd"
    style="display: none; position: fixed; top: 60%; left: 50%; transform: translate(-50%, -50%); z-index: 9999;">
    <img src="<?php echo base_url(); ?>assets/icons/animated.gif" alt="internal-loader"
        style="height: 130px;margin-top: 70px;">
</div>

</section>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<!-- Load Raphael.js first -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.3.0/raphael.min.js"></script>
<!-- Load JustGage.js from another reliable CDN -->
<script src="https://cdn.jsdelivr.net/npm/justgage@1.4.0/justgage.min.js"></script>


<script src="https://cdn.jsdelivr.net/npm/canvas-gauges/gauge.min.js"></script>
<script type="text/javascript" src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBKoAgLoslTEUCNabLj5H5jLVdWFD2WhK8"></script>
<script src="<?php echo base_url() ?>assets/local/wssclient.js"></script>
<script type="text/javascript">
function calculateCycleTime() {
    var onTime = parseFloat(document.getElementById("ontime").value) || 0;
    var offTime = parseFloat(document.getElementById("offtime").value) || 0;
    var totalMinutes = onTime + offTime;
    var hours = Math.floor(totalMinutes / 60);
    var minutes = Math.floor(totalMinutes % 60);
    var seconds = Math.floor((totalMinutes % 1) * 60);
    var formattedCycleTime = formatTime(hours, minutes, seconds);
    document.getElementById("cycleTime").innerText = formattedCycleTime;
}

function formatTime(hours, minutes, seconds) {
    return (
        (hours < 10 ? "0" : "") + hours + ":" +
        (minutes < 10 ? "0" : "") + minutes + ":" +
        (seconds < 10 ? "0" : "") + seconds
    );
}

document.getElementById("ontime").addEventListener("input", calculateCycleTime);
document.getElementById("offtime").addEventListener("input", calculateCycleTime);

function displayTargetTime() {
    var targetTimeValue = document.getElementById("target_time").value;
    if (targetTimeValue) {
        var timeParts = targetTimeValue.split(":");
        var hours = timeParts[0];
        var minutes = timeParts[1];
        var seconds = "00";
        var formattedTargetTime = formatTime(hours, minutes, seconds);
        document.getElementById("targetTimeDisplay").innerText = formattedTargetTime;
    } else {
        document.getElementById("targetTimeDisplay").innerText = "00:00:00";
    }
}

document.getElementById("target_time").addEventListener("change", displayTargetTime);
</script>

<script>
function formatDateToLocalInput(date) {
    if (!(date instanceof Date) || isNaN(date)) {
        console.error('Invalid Date object provided:', date);
        return '';
    }

    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are 0-based
    const day = String(date.getDate()).padStart(2, '0');
    const hours = String(date.getHours()).padStart(2, '0');
    const minutes = String(date.getMinutes()).padStart(2, '0');
    return `${year}-${month}-${day}T${hours}:${minutes}`;
}

// Function to reset the date inputs to default values
function resetDates() {
    const now = new Date();
    if (isNaN(now)) {
        console.error('Failed to create a valid Date object for "now".');
        return;
    }

    const toDateValue = formatDateToLocalInput(now);
    const fromDateValue = formatDateToLocalInput(new Date(now.getTime() - 24 * 60 * 60 * 1000));

    // Set values to elements if they exist
    const toDateElement = document.getElementById('to_date');
    const fromDateElement = document.getElementById('from_date');

    if (toDateElement) {
        toDateElement.value = toDateValue;
    } else {
        console.warn('Element with ID "to_date" not found.');
    }

    if (fromDateElement) {
        fromDateElement.value = fromDateValue;
    } else {
        console.warn('Element with ID "from_date" not found.');
    }
}

// Initialize the date inputs on page load
document.addEventListener('DOMContentLoaded', resetDates);
</script>




<script type="text/javascript">
$(document).ready(function() {
    let areaID = $("#area_id").val();
    if (areaID) {
        get_site_list();
    }
});

function get_site_list() {
    let company_id = "<?php echo $this->session->userdata('company_id') ?>";
    let user_id = "<?php echo $this->session->userdata('user_id') ?>";
    let assets_id = "<?php echo $this->session->userdata('assets_id') ?>";
    let area_id = $('#area_id').val();
    let siteID = "<?php echo $this->uri->segment(4); ?>";

    $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>Selfflow_c/site_list',
        data: {
            company_id: company_id,
            assets_id: assets_id,
            area_id: area_id,
            user_id: user_id
        },
        success: function(data) {
            data = JSON.parse(data);

            if (data.response_code == 200) {
                const siteDropdown = $('#site_id');
                siteDropdown.html('<option value="">Select site</option>'); 

                if (data.data.length > 0) {
                    $.each(data.data, function(i, v) {
                        let selected = siteID == v.id ? "selected" : "";
                        siteDropdown.append('<option value="' + v.id + '" ' + selected + '>' + v
                            .well_site_name + '</option>');
                    });
                } else {
                    siteDropdown.html('<option value="">No Data Found</option>');
                }

                siteDropdown.trigger('change'); 
            } else {
                swal('Error', data.msg, 'error');
            }
        },
        error: function() {
            swal('Error', 'Failed to fetch site list.', 'error');
        }
    });
}

$(document).ready(function() {
    let wellTypeId = $("#well_type").val();
    if (wellTypeId) {
        get_well_list();
    }
});

function get_well_list() {
    let area_id = $('#area_id').val();
    let site_id = $('#site_id').val();
    let well_type = $('#well_type').val();

    $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>Selfflow_c/Well_list',
        data: {
            area_id: area_id,
            well_type: well_type,
            site_id: site_id
        },
        success: function(data) {
            data = JSON.parse(data);

            if (data.response_code == 200) {
                if (data.data.length > 0) {
                    $('#well_id').html('<option value="">Select Well</option>');
                    $.each(data.data, function(i, v) {
                        let selected = "<?php echo $this->uri->segment(3); ?>" == v.well_id ?
                            "selected" : "";
                        $('#well_id').append('<option value="' + v.well_id + '" ' + selected + '>' +
                            v.well_name + '</option>');
                    });
                    let selectedWellId = "<?php echo $this->uri->segment(3); ?>";
                    if (selectedWellId) {
                        $('#well_id').val(selectedWellId).trigger('change');
                        get_single_well_details();
                        get_temperory_well_value();
                        get_pressure_details();
                        Get_Graph();
                        initMap();
                        updateAlertLogLink();
                        getAlertLog();
                        setupWebSocket();
                    }

                } else {
                    $('#well_id').html('<option value="">No Wells Available</option>');
                }
            } else {
                swal('Error', data.msg, 'error');
            }
        },
        error: function() {
            swal('Error', 'Failed to fetch well list.', 'error');
        },
    });
}

$('#area_id, #site_id, #well_type, #well_id').on('change', function() {

    const area_name = $('#area_id option:selected').text();
    $('#area_name').text(area_name);

    const site_name = $('#site_id option:selected').text();
    $('#well_site_name').text(site_name);

    const well_type_name = $('#well_type option:selected').text();
    $('#well_type_name').text(well_type_name);
     $('#well_type_status').text(well_type_name);

    const well_name = $('#well_id option:selected').text();
    $('#well_name').text(well_name);

});

function getAlertLog() {
    let well_id = $('#well_id').val();
    if (!well_id) {
        console.warn("Well ID not selected!");
        return;
    }

    $.ajax({
        url: "<?php echo base_url() ?>Selfflow_c/get_alert_log",
        type: "POST",
        data: { well_id },
        success: (res) => {
            let resp = JSON.parse(res);
            console.log(resp, 'alert');

            if (resp.response_code == 200) {
                const alertList = resp.data.well_alert_details || [];

                $('#alert_count').text(resp.data.total_alert || 0);
                $("#alert_log_table").html(``);

                if (alertList.length > 0) {
                    const alertMap = {
                        0: 'SOV ON', 1: 'SOV OFF', 2: 'Battery Low', 3: 'Battery High',
                        4: 'GIP Low', 5: 'GIP High', 6: 'THP Low', 7: 'THP High',
                        8: 'CHP Low', 9: 'CHP High', 10: 'ABP Low', 11: 'ABP High',
                        12: 'Temp Low', 13: 'Temp High', 14: 'Door Closed', 15: 'Door Open'
                    };

                    $.each(alertList, (i, v) => {
                        let alert_data = alertMap[v.alert_type] || 'Unknown Alert Type';
                        let date = v.trip_datetime ? new Date(v.trip_datetime) : null;
                        let formattedDatetime = date
                            ? `${date.getDate().toString().padStart(2, '0')}-${(date.getMonth() + 1).toString().padStart(2, '0')}-${date.getFullYear()} ${date.getHours().toString().padStart(2, '0')}:${date.getMinutes().toString().padStart(2, '0')}:${date.getSeconds().toString().padStart(2, '0')}`
                            : 'Invalid Date';

                        $("#alert_log_table").append(`<tr>
                            <td>${i + 1}</td>
                            <td>${alert_data}</td>
                            <td>${v.alert_details}</td>
                            <td>${formattedDatetime}</td>
                        </tr>`);
                    });
                } else {
                    $("#alert_log_table").html(`<tr><td colspan="4">No alert log found!</td></tr>`);
                }
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", status, error);
            console.log(xhr.responseText);
        }
    });
}

get_single_well_details();
function get_single_well_details() {
     let well_id = $('#well_id').val();
     console.log("Well ID:", well_id);

   //  $('#loader_for_sd').show();
    // $('#single_dadhboard_content_div').hide();
    let user_type = '<?php echo $this->session->userdata('user_type') ?>';
    let role_type = '<?php echo $this->session->userdata('role_type') ?>';
    $.ajax({
        url: "<?php echo base_url() ?>Selfflow_c/get_single_well_details",
        type: "POST",
        data: {
            well_id: well_id,
        },
        success: (res) => {
            let resp = JSON.parse(res);
            console.log(resp, 'signle_details');
            if (resp.response_code == 200) {
                // $('#loader_for_sd').hide();
                // $('#single_dadhboard_content_div').show();
                if (resp.data.single_welldevice_data.length > 0) {
                    let deviceData = resp.data.single_welldevice_data[0];
                    $('#device_name').text(deviceData.device_name || '');
                    $('#imei_no').text(deviceData.imei_no || '');
                    $('#imei_no_hdn').val(deviceData.imei_no || '');
                    $('#well_id_hdn').val(deviceData.well_id || '');
                    $('#well_name_hdn').text(deviceData.well_name || '');
                    $('#flag_status').text(deviceData.flag_status || '');
                    $('#wellidhdn').val(deviceData.well_id || '');
                    $('#wellnamehdn').text(deviceData.well_name || '');
                    $('#passcode').text(deviceData.passcode || '');

                    var flag_status_data = deviceData.flag_status;
                   
                    if (flag_status_data == 0) {
                        $('#flag').show();
                        $('#unflag').hide();
                        $('#un_flag_by').hide();
                        $('#flag_by').show();

                    } else {
                        $('#unflag').show();
                        $('#flag').hide();
                        $('#un_flag_by').hide();
                        $('#flag_by').show();
                    }

                    $('#chp_image').text(deviceData.PS_2_CHP || 0);
                    $('#gip_image').text(deviceData.PS_1_GIP || 0);
                    $('#abp_image').text(deviceData.PS_4_ABP || 0);
                    $('#thp_image').text(deviceData.PS_3_THP || 0);
                    $('#tht_image').text(deviceData.FLTP_1_Temp || 0);

                    let chp_ed = deviceData.chp_ed;
                    let gip_ed = deviceData.gip_ed;
                    let thp_ed = deviceData.thp_ed;
                    let abp_ed = deviceData.abp_ed;
                    let temp_ed = deviceData.temp_ed;

                    $('#chped').val(deviceData.chp_ed || 0);
                    $('#giped').val(deviceData.gip_ed || 0);
                    $('#thped').val(deviceData.thp_ed || 0);
                    $('#abped').val(deviceData.abp_ed || 0);

                    if(chp_ed == 1)
                    {
                        $('#sensorchp').show();
                        $('#sensorchp_monthly').show();
                    }else{
                        $('#sensorchp').hide();
                        $('#sensorchp_monthly').hide();
                    }

                    if(abp_ed == 1)
                    {
                        $('#sensorabp').show();
                        $('#sensorabp_monthly').show();
                    }else{
                        $('#sensorabp').hide();
                        $('#sensorabp_monthly').hide();
                    }

                    if(gip_ed == 1)
                    {
                        $('#sensorgip').show();
                        $('#sensorgip_monthly').show();
                        
                    }else{
                        $('#sensorgip').hide();
                        $('#sensorgip_monthly').hide();
                    }

                    if(thp_ed == 1)
                    {
                        $('#sensorthp').show();
                        $('#sensorthp_monthly').show();
                    }else{
                        $('#sensorthp').hide();
                        $('#sensorthp_monthly').hide();
                    }

                    $('#on_time').text(deviceData.ON_Time || 0);
                    $('#off_time').text(deviceData.Off_Time || 0);
                    $('#targettime').text(deviceData.TRGT_Time || 0);
                    let last_cycle_time = deviceData.last_cycle != null ? moment(deviceData.last_cycle)
                        .format('DD-MM-YYYY HH:mm a') : " ";
                    $('#last_cycle').text(last_cycle_time);
                    let next_cycle_time = deviceData.next_cycle != null ? moment(deviceData.next_cycle)
                        .format('DD-MM-YYYY HH:mm a') : " ";
                    $('#next_cycle').text(next_cycle_time);
                    $('#bean_size').text(deviceData.bean_size || "W/B");
                    $('#battery_voltage').text(deviceData.Battery_Voltage || 0);
                    $('#battery_value').text(deviceData.Battery_Voltage || 0);

                    var last_datetime = deviceData.Log_Date_Time != null ? moment(deviceData.Log_Date_Time)
                        .format('DD-MM-YYYY h:mm:ss a') : "NA";

                    $('#last_updated_datetime').text(last_datetime);
                    var last_updated_time = deviceData.Log_Date_Time;
                    var lastDataTimeObj = new Date(last_updated_time);
                    var currentDate = new Date();
                    var diffInMilliseconds = currentDate - lastDataTimeObj;
                    seconds = Math.floor(diffInMilliseconds / 1000);
                    let timeLimit = (user_type == 2 || (user_type == 3 && role_type == 3)) ? 900 : 7200;

                   if (seconds < timeLimit) {
                        $('#rtms_status_image').html(
                            '<img src="<?php echo base_url() ?>assets/img/greendot.png" alt="symbol-img" style="height: 30px; width: 30px;">'
                        );
                        $('#rtms_status_text').text('ON');
                    } else {
                        $('#rtms_status_image').html(
                            '<img src="<?php echo base_url() ?>assets/img/reddot.png" alt="symbol-img" style="height: 30px; width: 30px;">'
                        );
                        $('#rtms_status_text').text('OFF');
                    }


                    var flag_status = deviceData.flag_status;
                    if (seconds < timeLimit) {
                        if (flag_status == 0) {
                            $('#well_status').text('Flowing Well');

                        } else if (flag_status == 1) {
                            $('#well_status').text('Non Flowing Well');

                        }
                    } else {
                        $('#well_status').text('Offline Well');

                    }


                    function battery(charge) {
                        var activeBars = Math.floor(Math.min(Math.max((charge - 6.0) / (7.9 - 6.0) * 10, 0),
                            10));
                        $(".battery .bar").each(function(index) {
                            if (index < activeBars) {
                                $(this).addClass("active");
                            } else {
                                $(this).removeClass("active");
                            }
                        });
                    }

                    var battery_value = parseFloat(deviceData.Battery_Voltage);
                    battery(battery_value);

                    setupWebSocket();


                }
            }
        }
    });
}
function get_temperory_well_value() {
    let well_id = $('#well_id').val();

    $.ajax({
        url: '<?php echo base_url(); ?>Main_dashboard_c/well_status_details',
        type: 'POST',
        data: {
            well_id: well_id
        },
        success: function(res) {
            res = JSON.parse(res);
            // console.log(res, 'fhdgesj');
            if (res.response_code == 200) {
                $.each(res.data, function(i, v) {
                    if (v.well_id == well_id) {
                        $('#reason').val(v.reason).trigger('change');
                        $('#effective_date_time').val(v.effective_date_time);

                        var reason_name = v.reason_name !== null ? v.reason_name : "NA";
                        $('#flag_reason').text(reason_name);
                        let c_date = formatDateTime(v.c_date);
                        let d_date = formatDateTime(v.d_date);

                        $('#created_by').text(v.created_by);
                        $('#c_date').text(c_date);
                        $('#update_by').text(v.update_by);
                        $('#d_date').text(d_date);
                    }
                });
            }
        },
    });
}

function formatDateTime(dateString) {
    if (!dateString) return '';
    return moment(dateString).format('DD-MM-YYYY HH:mm:ss');
}
get_pressure_details();
function get_pressure_details() {
    let well_id = '27394648-f40e-11ef-8373-0e1c481aa072';
    // alert(well_id);

    $.ajax({
        url: "<?php echo base_url() ?>Selfflow_c/get_single_well_details",
        type: "POST",
        data: {
            well_id: well_id,
        },
        success: (res) => {
            try {
                let resp = JSON.parse(res);
                if (resp.response_code == 200 && resp.data) {

                    let pressureDailyAvg = resp.data.pressure_daily_avg || {};
                
                    $('#chp_daily').text(parseFloat(pressureDailyAvg.avg_PS_2_CHP || 0).toFixed(2));
                    $('#gip_daily').text(parseFloat(pressureDailyAvg.avg_PS_1_GIP || 0).toFixed(2));
                    $('#abp_daily').text(parseFloat(pressureDailyAvg.avg_PS_4_ABP || 0).toFixed(2));
                    $('#thp_daily').text(parseFloat(pressureDailyAvg.avg_PS_3_THP || 0).toFixed(2));
                    $('#tht_daily').text(parseFloat(pressureDailyAvg.avg_FLTP_1_Temp || 0).toFixed(2));
                    // console.log("THT Daily Value:", pressureDailyAvg.avg_FLTP_1_Temp);

                    // Bind monthly pressure data
                    let pressureMonthlyAvg = resp.data.pressure_monthly_avg || {};
                    $('#chp_monthly').text(parseFloat(pressureMonthlyAvg.avg_PS_2_CHP || 0).toFixed(2));
                    $('#gip_monthly').text(parseFloat(pressureMonthlyAvg.avg_PS_1_GIP || 0).toFixed(2));
                    $('#abp_monthly').text(parseFloat(pressureMonthlyAvg.avg_PS_4_ABP || 0).toFixed(2));
                    $('#thp_monthly').text(parseFloat(pressureMonthlyAvg.avg_PS_3_THP || 0).toFixed(2));
                    $('#tht_monthly').text(parseFloat(pressureMonthlyAvg.avg_FLTP_1_Temp || 0).toFixed(2));

                    // let command_update = resp.data.command_update || {}
                    // $('#command_update_by').text(command_update.unique_userId || '');
                    // let command_date = formatDateTime(command_update.log_date || '');
                    // $('#command_log_date').text(command_date);
                    // // console.log(command_update,'command_update');
                }
            } catch (e) {
                console.error("Error parsing response:", e);
            }
        },
        error: (xhr, status, error) => {
            console.error("AJAX Error:", status, error);
        }
    });
}
get_motor_image();
function get_motor_image() {
    var well_type = $('#well_type').val();
    // alert(well_type);
    if (well_type == 1) {
        $('#cyclic_time').hide();
        $("#ietcc_btn_action").hide();
        $("#sovLogLink").hide();
    } else if (well_type == 2) {
        $('#cyclic_time').hide();
        $("#ietcc_btn_action").hide();
        $("#sovLogLink").hide();
    } else if (well_type == 3) {
        $('#cyclic_time').show();
        $("#ietcc_btn_action").show();
        $("#sovLogLink").show();
    } else if (well_type == 4) {
        $('#cyclic_time').hide();
        $("#ietcc_btn_action").hide();
        $("#sovLogLink").hide();
    } else {
        $('#cyclic_time').hide();
        $("#ietcc_btn_action").hide();
        $("#sovLogLink").hide();
    }
}
</script>
<script>
function updateAlertLogLink() {
    let wellId = $('#well_id').val();
    let siteId = $('#site_id').val();
    let areaId = $('#area_id').val();
    let wellType = $('#well_type').val();
    let baseUrl = "<?php echo base_url(); ?>Alert_log_report_c/index/";
    let hisbaseUrl = "<?php echo base_url(); ?>Historical_report_c/mis_report_page/";
    let sovbaseUrl = "<?php echo base_url(); ?>Sov_report_c/index/";

    let newHref = wellId ? baseUrl + wellId + '/' + siteId + '/' + areaId + '/' + wellType : baseUrl;
    $('#alertLogLink').attr('href', newHref);

    let newHrefhis = wellId ? hisbaseUrl + wellId + '/' + siteId + '/' + areaId + '/' + wellType : hisbaseUrl;
    $('#HistoricalLogLink').attr('href', newHrefhis);

    let newHrefsov = wellId ? sovbaseUrl + wellId + '/' + siteId + '/' + areaId + '/' + wellType : sovbaseUrl;
    $('#sovLogLink').attr('href', newHrefsov);
}
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script>
function toggleDataSeries(e) {
    if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
        e.dataSeries.visible = false;
    } else {
        e.dataSeries.visible = true;
    }
    e.chart.render();
}

// Function to load the chart
function loadchart(mychart, mytitle, name1, name2, name3, name4, name5, name6, minYVal, maxYVal,
    dataPoints1, dataPoints2, dataPoints3, dataPoints4, dataPoints5, dataPoints6) {

    var chart = new CanvasJS.Chart(mychart, {
        zoomEnabled: true,
        title: {
            text: mytitle,
            fontSize: 14
        },
        axisX: {
            valueFormatString: "DD-MM-YYYY HH:mm:ss",
            labelFontSize: 9,
            labelAutoFit: true,
            labelAngle: 180,
        },
        axisY: {
            prefix: " ",
            labelFontSize: 9,
            minimum: minYVal,
            maximum: maxYVal
        },
        toolTip: {
            shared: true
        },
        legend: {
            cursor: "pointer",
            verticalAlign: "top",
            fontSize: 16,
            fontColor: "dimGrey",
            itemclick: toggleDataSeries
        },
        data: [
            {
                type: "line",
                name: name1,
                dataPoints: dataPoints1,
                showInLegend: true,
                lineColor: '#ec344c',
                markerColor: '#ec344c'
            },
            {
                type: "line",
                name: name2,
                dataPoints: dataPoints2,
                showInLegend: true,
                lineColor: '#f59440',
                markerColor: '#f59440'
            },
            {
                type: "line",
                name: name3,
                dataPoints: dataPoints3,
                showInLegend: true,
                lineColor: '#287f71e0',
                markerColor: '#287f71e0'
            },
            {
                type: "line",
                name: name4,
                dataPoints: dataPoints4,
                showInLegend: true,
                lineColor: '#402fd4',
                markerColor: '#402fd4'
            },
            {
                type: "line",
                name: name5,
                dataPoints: dataPoints5,
                showInLegend: true,
                lineColor: '#2786f1',
                markerColor: '#2786f1'
            },
            {
                type: "line",
                name: name6,
                dataPoints: dataPoints6,
                showInLegend: true,
                lineColor: '#dd33ff',
                markerColor: '#dd33ff'
            }
        ]
    });

    chart.render();
}

// Function to fetch data via AJAX and plot the chart
function Get_Graph() {
    var selectedOption = "1";
    if (selectedOption === "1") {
        var well_id = $('#well_id').val();
        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();
        var graph_type = selectedOption;

       // document.getElementById("processing_message").style.display = "block";

        $.ajax({
            url: '<?php echo base_url(); ?>Selfflow_c/get_all_dashboard_data_graph_ajax',
            type: 'POST',
            data: {
                well_id: well_id,
                from_date: from_date,
                to_date: to_date,
                graph_type: selectedOption
            },
            success: function (res) {

              console.log('single_graph',res);
                var res = JSON.parse(res);
              //  document.getElementById("processing_message").style.display = "none";

                let chp = res.data.Output_pressure.output_chp;
                let gip = res.data.Output_pressure.output_gip;
                let thp = res.data.Output_pressure.output_thp;
                let abp = res.data.Output_pressure.output_abp;
                let tht = res.data.Output_pressure.output_tht;
                let battery = res.data.Output_pressure.output_battery;

                // Correctly parse string date to Date object for CanvasJS
                let dataPoints1 = chp.map(point => ({
                    x: new Date(point.x),
                    y: parseFloat(point.y)
                }));
                let dataPoints2 = gip.map(point => ({
                    x: new Date(point.x),
                    y: parseFloat(point.y)
                }));
                let dataPoints3 = thp.map(point => ({
                    x: new Date(point.x),
                    y: parseFloat(point.y)
                }));
                let dataPoints4 = abp.map(point => ({
                    x: new Date(point.x),
                    y: parseFloat(point.y)
                }));
                let dataPoints5 = tht.map(point => ({
                    x: new Date(point.x),
                    y: parseFloat(point.y)
                }));
                let dataPoints6 = battery.map(point => ({
                    x: new Date(point.x),
                    y: parseFloat(point.y)
                }));

                loadchart(
                    "neutral_voltage",
                    "Output Pressure Graph",
                    "CHP",
                    "GIP",
                    "THP",
                    "ABP",
                    "THT",
                    "Battery Voltage",
                    0,
                    50,
                    dataPoints1,
                    dataPoints2,
                    dataPoints3,
                    dataPoints4,
                    dataPoints5,
                    dataPoints6
                );
            }
        });
    }
}

function initMap() {
    let area_id = $('#area_id').val();
    let well_id = $('#well_id').val();
    let well_type = $('#well_type').val();
    let user_type = '<?php echo $this->session->userdata('user_type') ?>';
    let role_type = '<?php echo $this->session->userdata('role_type') ?>';
    // alert(well_id);

    $.ajax({
        url: '<?php echo base_url(); ?>Selfflow_c/get_site_location_for_dashboard',
        type: 'POST',
        data: {
            area_id: area_id,
            well_id: well_id,
            well_type: well_type
        },
        success: function(res) {
            response = JSON.parse(res);
            // console.log(response, 'map');

            if (response.data.length > 0) {
                let markers = [];
                let selectedWell = null;

                for (let item of response.data) {
                    if (item.well_id === well_id) {
                        selectedWell = item;
                    }

                    markers.push({
                        position: {
                            lat: parseFloat(item.lat),
                            lng: parseFloat(item.long)
                        },
                        title: item.well_name,
                        well_id: item.well_id,
                        offline_time: item.Log_Date_Time,
                        flag_status: item.flag_status,
                        long: item.long,
                        lat: item.lat
                    });
                }
                let mapCenter = {
                    lat: 21.6316586,
                    lng: 72.994056
                }; // Default center
                if (selectedWell) {
                    mapCenter = {
                        lat: parseFloat(selectedWell.lat),
                        lng: parseFloat(selectedWell.long)
                    };
                }

                var map = new google.maps.Map(document.getElementById('mymap'), {
                    zoom: 13,
                    center: mapCenter
                });

                markers.forEach(function(marker) {
                    var markerIcon = {
                        url: '<?php echo base_url(); ?>assets/img/offline.png',
                        scaledSize: new google.maps.Size(20, 20)
                    };

                    var seconds = 200;

                    if (marker.offline_time) {
                        var lastDataTimeObj = new Date(marker.offline_time);
                        var currentDate = new Date();

                        var diffInMilliseconds = currentDate - lastDataTimeObj;
                        seconds = Math.floor(diffInMilliseconds / 1000);
                    }

                    let timeLimit = (user_type == 2 || (user_type == 3 && role_type == 3)) ? 900 : 7200;

                    if (!marker.offline_time || seconds > timeLimit) {
                        markerIcon.url = '<?php echo base_url(); ?>assets/img/offline.png';
                    } else if (seconds <= timeLimit && marker.flag_status == 0) {
                        markerIcon.url = '<?php echo base_url(); ?>assets/img/green.png';
                    } else if (seconds <= timeLimit && marker.flag_status == 1) {
                        markerIcon.url = '<?php echo base_url(); ?>assets/img/red.png';
                    }

                    var mapMarker = new google.maps.Marker({
                        position: marker.position,
                        map: map,
                        icon: markerIcon,
                        title: marker.title,
                        lat: marker.lat,
                        long: marker.long
                    });

                    var statusText = '';
                    if (!marker.offline_time || seconds > timeLimit) {
                        statusText = 'Offline Well';
                    } else if (seconds <= timeLimit && marker.flag_status == 0) {
                        statusText = 'Flowing Well';
                    } else if (seconds <= timeLimit && marker.flag_status == 1) {
                        statusText = 'Non-Flowing Well';
                    }

                    var infowindow = new google.maps.InfoWindow({
                        content: '<div class="site-info" style="width: 150px; height: auto;">' +
                            '<h6 style="color:black;"><a target="_blank" href="https://www.google.com/maps/place/' +
                            marker.lat + ',' + marker.long +
                            '">View on Google Maps</a></h6>' +
                            '<h6>' + marker.title + '</h6>' +
                            '<h6><b>Well Status</b>: ' + statusText + '</h6>' +
                            '</div>'
                    });

                    mapMarker.addListener('click', function() {
                        infowindow.open(map, mapMarker);
                    });

                    // Close InfoWindow on map click
                    map.addListener('click', function() {
                        infowindow.close();
                    });
                });
            }
        }
    });
}

$(document).ready(function () {
    Get_Graph();
});
</script>


