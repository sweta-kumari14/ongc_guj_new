<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

<style>
    .sensor-card {
        width: 300px;
        border: 1px solid #d4d4d4;
        border-radius: 5px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        font-family: 'Segoe UI', sans-serif;
        margin: -3px;
        transition: transform 0.2s ease;
        background-color: #ffffff;
    }
        .table th {
    vertical-align: middle;
    border: none;
    border-bottom: 1px solid #ccc; 
    padding: 0rem 0.75rem;
/*    white-space: nowrap !important;*/
   word-break: break-all;
}

    .sensor-card:hover {
        transform: scale(1.02);
    }

    .card-header {
        background: linear-gradient(to right, #007bff, #0056b3);
        color: white;
        padding: 7px 17px;
        font-size: 20px;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .pump-image {
        position: relative;
        text-align: center;
        border-bottom: 1px solid #ddd;
    }

   
    .status-dot {
    position: absolute;
    top: 8px;
    right: 10px;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background-color: #06E763; /* green */
}
 .sensor-wrapper {
    position: relative;
    width: 100%;
    max-width: 600px; /* or any container width */
    height: auto;
}

/* Absolute sensors with % so they scale on screen resize */
.sensor_one, .sensor-two, .sensor-two_one,
.sensor-three, .sensor-four {
    position: absolute;
}

.sensor_one     { left: 17%;  top: 5%; }
.sensor-two     { left: 37%; top: 22%; }
.sensor-two_one { left: 70%; top: 36%; }
.sensor-three   { left: 41%; top: 63%; }
.sensor-four    { left: 70%; top: 63%; }

/* Sensor data bubbles */
.sensor_one_data, .sensor_two_data,
.sensor_two_data_two, .sensor_three_data,
.sensor_four_data {
    position: absolute;
    display: flex;
    border: 1px solid #ccc;
    background: #fff;
    padding: -2px ;         /* Increased padding for a wider box */
    font-size: 12px;
    font-weight: 500;
    border-radius: 3px;        /* Reduced from 5px to 3px for more rectangle look */
    box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    min-width: 68px;           /* Optional: fixes size if text is short */
    justify-content: center;   /* Centers the text */
}


/* Data bubble positioning (also in %) */
.sensor_one_data     { left: 100%; bottom: 48%; }
.sensor_two_data     { left: 100%; bottom: 45%; }
.sensor_two_data_two { left: 96%; bottom: 60%; }
.sensor_three_data   { left: 88%; bottom: 87%; }
.sensor_four_data    { left: 88%; bottom: 87%; }



 .pump-image img[alt="sensor-icon"] {
    height: 29px !important; /* smaller size */

    .flash-button {
        padding: 8px 16px;
        background: #28a745;
        border: none;
        color: #fff;
        font-weight: bold;
        border-radius: 6px;
        cursor: pointer;
        animation: flash 1s infinite;
        transition: background 0.3s;
    }
.status-item {
    display: flex;
    flex-direction: column; 
    align-items: center;    
    justify-content: center; 
    text-align: center;     
}

/* Dot Styling */
.dot {
    width: 20px;         
    height: 20px;
    border-radius: 50%;
    display: inline-block;
    margin-bottom: 10px;    
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); 
}

/* Dot Colors */
.dot-temporary {
    background-color: #800000; /* Maroon */
}

.dot-offline {
    background-color: #FB4A4A; /* Red */
}
.dot-battery {
    background-color: #5D6D7E; /* Red */
}
.dot-network{
   
   background-color: #f39c12; /* Red */
}


.dot-online {
    background-color: #28a745; /* Green */
}

/* Status Label Styling */
.status-label {
    font-size: 16px;
    font-weight: bold;
    color: #333;
}
    .flash-button:hover {
        background: #218838;
    }

    @keyframes flash {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.6; }
    }
</style>
<style>
    .btn-flag {
        background-color: #f3c200;
        color: #212529;
        border: none;
    }
    .btn-flag:hover {
        background-color: #e0b100;
        color: #000;
    }
</style>

<button class="btn btn-sm btn-flag d-flex align-items-center gap-1 mx-auto"
        data-bs-toggle="modal"
        data-bs-target="#well_mark_status"
        id="flag_text">
    <i class="bi bi-flag-fill"></i> Flag Well
</button>

                                     <div class="page-wrapper custome-name">
                                     <div class="content container-fluid" style="padding: 12px;">
                                                  <!-- Page Header -->
                                     <div class="page-header" style="margin-bottom:4px; margin-top: -40px;">
                                       <div class="d-flex justify-content-between align-items-center flex-wrap">
                                          <!-- Title -->
                                          <h3 class="page-title mb-0" style="font-size: 20px;">Single Well Dashboard</h3>

                                          <!-- Back Button -->
                                          <a href="<?php echo base_url('Selfflow_c'); ?>">
                                             <button type="button" class="btn btn-sm btn-success">
                                             <i class="bi bi-arrow-left"></i> Back</button>
                                          </a>
                                       </div>
                                    </div>
                                    <div class="row mt-2">
                        <!-- Well Status Card -->

                        <div class="col-md-4">
                            <div class="bg-white rounded-3" style="height:95%; border: 1px solid #ededed; box-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);">
                                <div class=" px-3 d-flex justify-content-between align-items-center topCards" style="height:40px; background-color:#e7838c; font-size:18px;">
                                    <b class="text-white">Well Name</b>

                                    <img src="<?php echo base_url(); ?>assets/img/well.gif" width="30" style="border-radius: 50%;">
                                </div>
                                <div class="px-3 text-start">
                                    <div class="pump-image">
                                        <!-- Sensors -->
                                        <div class="sensor_one">
                                            <img src="<?php echo base_url() ?>assets/icons/psr.png" alt="sensor-icon">
                                            <div class="sensor_one_data"><strong>THT 53.20 </strong> <span id="sensor-one-value"><span id="tht_image"></span></span></div>
                                        </div>
                                        <div class="sensor-two" id="sensorthp">
                                            <img height="35" src="<?php echo base_url() ?>assets/icons/psr.png" alt="sensor-icon">
                                            <div class="sensor_two_data"><strong>THP 53.20 </strong> <span id="sensor-two-value"><span id="thp_image"></span></span></div>
                                        </div>
                                        <div class="sensor-two_one" id="sensorabp">
                                            <img height="35" src="<?php echo base_url() ?>assets/icons/psr.png" alt="sensor-icon">
                                            <div class="sensor_two_data_two"><strong>ABP 53.20 </strong> <span id="sensor-two-value"><span id="abp_image"></span></span></div>
                                        </div>
                                        <div class="sensor-three" id="sensorchp">
                                            <img height="35" src="<?php echo base_url() ?>assets/icons/psr.png" alt="sensor-icon">
                                            <div class="sensor_three_data"><strong>CHP 53.20 </strong> <span id="sensor-three-value"><span id="chp_image"></span></span></div>
                                        </div>
                                        <div class="sensor-four" id="sensorgip">
                                            <img height="35" src="<?php echo base_url() ?>assets/icons/psr.png" alt="sensor-icon">
                                            <div class="sensor_four_data"><strong>GIP 53.20 </strong> <span id="sensor-four-value"><span id="gip_image"></span></span></div>
                                        </div>
                                        <div style="padding-top:25px;">
                                        <img class="pump-img" style="max-width:88%; margin-top: -10px; margin-right:24px;" 
                                        src="<?php echo base_url() ?>assets/icons/11.jpg" alt="pump-img">

                                    </div>

                                </div>
                                </div>
                            </div>
                        </div>
                                    <input type="hidden" class="form-control" name="chped" id="chped">
                                    <input type="hidden" class="form-control" name="giped" id="giped">
                                    <input type="hidden" class="form-control" name="thped" id="thped">
                                    <input type="hidden" class="form-control" name="abped" id="abped">

                                     <!-- Battery Voltage Card -->
                                    <div class="col-md-4">
                                    <div class="bg-white rounded-3" style="height:95%; border: 1px solid #ededed; box-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);">
                                        <div class=" px-3 d-flex justify-content-between align-items-center topCards" style="height:40px; background-color:#e7838c; font-size:18px;">
                                         <b class="text-white">Battery Voltage</b>
                                            <img src="<?php echo base_url(); ?>assets/img/volt.gif" width="30" style="border-radius: 50%;">
                                        </div>
                                        <div class="px-3 text-start">
                                            <div class="card-body text-center" style="padding: 13px;">
                                                <div class="row">
                                        <div class="col-12">
                                            <div style="display: flex; align-items: center; border: 1px solid #000; width: 100%; height: 50px; padding: 5px;">
                                                <div style="display: flex; gap: 2px; width: 100%; height: 100%;">
                                                    <!-- 10 Green Bars -->
                                                    <?php for ($i = 0; $i < 10; $i++): ?>
                                                        <div style="width: 10%; background: #00cc33;"></div>
                                                    <?php endfor; ?>
                                                </div>
                                                <div style="width: 5px; background: #000; height: 60%; margin-left: 4px;"></div>
                                            </div>
                                            <div style="margin-top: 12px; padding-bottom:18px;">
                                                <strong style="font-size: 14px;">Battery :</strong> <span id="battery_value">11.35</span>
                                            </div>
                                        </div>
                                    <div class="px-3 pt-2 pb-3" style="text-align: left;">
                                       <div class="card-body p-0">
                     <!-- Compact Table -->
                                      <table class="table table-sm text-center mb-0" style="font-size: 11px; line-height: 1; border-collapse: collapse; width: 100%;">
                            <thead style="background-color: #f8f9fa;">
                                <tr>
        <th style="padding: 3px; border: 1px solid #dee2e6;"></th>
        <th colspan="2" style="padding: 3px; border: 1px solid #dee2e6; font-weight: bold; text-align: center;">Average</th>
        <th style="padding: 3px; border: 1px solid #dee2e6;"></th>
    </tr>
                                <tr>
                                    <th style="padding: 3px; border: 1px solid #dee2e6;">Mes. Point</th>
                                    <th style="padding: 3px; border: 1px solid #dee2e6;">Daily</th>
                                    <th style="padding: 3px; border: 1px solid #dee2e6;">Monthly</th>
                                    <th style="padding: 3px; border: 1px solid #dee2e6; width:20%">Battery Voltage</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Row 1 -->
                                <tr>
                                    <td style="padding: 3px; border: 1px solid #dee2e6;">THT</td>
                                    <td style="padding: 3px; border: 1px solid #dee2e6;"><span id="tht_daily"></span></td>
                                    <td style="padding: 3px; border: 1px solid #dee2e6;"><span id="tht_monthly"></span></td>
                                    <td style="padding: 3px; border: 1px solid #dee2e6;">
                                        <div style="display: flex; align-items: center;">
                                            <div class="progress" style="height: 12px; width: 50%; background-color: #e9ecef; border-radius: 0; margin-right: 2px;">
                                                <div class="progress-bar bg-success" style="width: 90%; border-radius: 0;"></div>
                                            </div>
                                            <div style="height: 8px; width: 2px; background-color: #343a40;"></div>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Row 2 -->
                                <tr>
                                    <td style="padding: 3px; border: 1px solid #dee2e6;">THP</td>
                                    <td style="padding: 3px; border: 1px solid #dee2e6;"><span id="thp_daily"></span></td>
                                    <td style="padding: 3px; border: 1px solid #dee2e6;"><span id="thp_monthly"></span></td>
                                    <td style="padding: 3px; border: 1px solid #dee2e6;">
                                        <div style="display: flex; align-items: center;">
                                            <div class="progress" style="height: 12px; width: 50%; background-color: #e9ecef; border-radius: 0; margin-right: 2px;">
                                                <div class="progress-bar bg-warning" style="width: 60%; border-radius: 0;"></div>
                                            </div>
                                            <div style="height: 8px; width: 2px; background-color: #343a40;"></div>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Row 3 -->
                                <tr>
                                    <td style="padding: 3px; border: 1px solid #dee2e6;">ABP</td>
                                    <td style="padding: 3px; border: 1px solid #dee2e6;"><span id="abp_daily"></span></td>
                                    <td style="padding: 3px; border: 1px solid #dee2e6;"><span id="abp_monthly"></span></td>
                                    <td style="padding: 3px; border: 1px solid #dee2e6;">
                                        <div style="display: flex; align-items: center;">
                                            <div class="progress" style="height: 12px; width: 50%; background-color: #e9ecef; border-radius: 0; margin-right: 2px;">
                                                <div class="progress-bar bg-warning" style="width: 60%; border-radius: 0;"></div>
                                            </div>
                                            <div style="height: 8px; width: 2px; background-color: #343a40;"></div>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Row 4 -->
                                <tr>
                                    <td style="padding: 3px; border: 1px solid #dee2e6;">GIP</td>
                                    <td style="padding: 3px; border: 1px solid #dee2e6;"><span id="gip_daily"></span></td>
                                    <td style="padding: 3px; border: 1px solid #dee2e6;"><span id="gip_monthly"></span></td>
                                    <td style="padding: 3px; border: 1px solid #dee2e6;">
                                        <div style="display: flex; align-items: center;">
                                            <div class="progress" style="height: 12px; width: 50%; background-color: #e9ecef; border-radius: 0; margin-right: 2px;">
                                                <div class="progress-bar bg-warning" style="width: 60%; border-radius: 0;"></div>
                                            </div>
                                            <div style="height: 8px; width: 2px; background-color: #343a40;"></div>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Row 5 -->
                                <tr>
                                    <td style="padding: 3px; border: 1px solid #dee2e6;">CHP</td>
                                    <td style="padding: 3px; border: 1px solid #dee2e6;"><span id="chp_daily"></span></td>
                                    <td style="padding: 3px; border: 1px solid #dee2e6;"><span id="chp_monthly"></span></td>
                                    <td style="padding: 3px; border: 1px solid #dee2e6;">
                                        <div style="display: flex; align-items: center;">
                                            <div class="progress" style="height: 12px; width: 50%; background-color: #e9ecef; border-radius: 0; margin-right: 2px;">
                                                <div class="progress-bar bg-warning" style="width: 60%; border-radius: 0;"></div>
                                            </div>
                                            <div style="height: 8px; width: 2px; background-color: #343a40;"></div>
                                        </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                                   </div>
                                                    </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                   <!-- RTMS Status Card (Merged with Details) -->
                                    <div class="col-md-4">
                                    <div class="bg-white rounded-3 shadow-sm border" style="height: 95%; border: 1px solid #ededed;">
                                        <!-- Card Header -->
                                        <div class="card-header px-3 d-flex justify-content-between align-items-center"
                                             style="height: 40px; background:#e7838c ;color: white; font-size:18px;">
                                            <b>RTMS Status</b>
                                            <img src="<?php echo base_url(); ?>assets/img/device.gif" 
                                             width="30" height="24" 
                                             style="border-radius: 50%;">
                                        </div>


                                        <!-- Card Body -->
                                        <div class="p-3">
                                    <!-- Status -->
                                        <div class="text-center mb-3">
                                        <span class="badge rounded-pill bg-success px-4 py-2" style="font-size: 13px;">
                                            <i class="bi bi-circle-fill me-1" style="font-size:10px;"></i> Online
                                        </span>
                                        </div>

                                    <!-- Last Date-Time -->
                                        <div class="text-center mb-3">
                                        <div style="font-size: 13px; color: #555;">Last Updated</div>
                                        <div style="font-weight: bold; font-size: 13px;">
                                            <i class="bi bi-clock me-1 text-primary"></i><span id="log_date_time">2025-04-01 11:57:44</span>
                                        </div>
                                        </div>

                                    <!-- RTMS Info Grid -->
                                        <div class="d-flex flex-column gap-2 px-2">
                                        <div class="d-flex align-items-center justify-content-between bg-light rounded px-2 py-1">
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="bi bi-lightning-fill text-secondary"></i>
                                                <span style="font-size: 13px;">Device Name</span>
                                            </div>
                                            <span style="font-weight: 500; font-size: 13px;">RTMS-X100</span>
                                        </div>

                                        <div class="d-flex align-items-center justify-content-between bg-light rounded px-2 py-1">
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="bi bi-upc-scan text-secondary"></i>
                                                <span style="font-size: 13px;">IMEI</span>
                                            </div>
                                            <span style="font-weight: 500; font-size: 13px;">123456789012345</span>
                                        </div>
                                    </div>

                                    <!-- Flag Button Centered -->
                                    <div class="text-center mt-3">
                                        <button class="btn btn-sm btn-flag d-flex align-items-center gap-1 mx-auto"
                                        data-bs-toggle="modal"
                                        data-bs-target="#well_mark_status"
                                        id="flag_text" style="color:white;">
                                    <i class="bi bi-flag-fill"></i> Flag Well
                                </button>
                                </div>
                                </div>

                                </div>
                                </div>  <!-- row -->

                                 <div class="row " style="margin-top: 1px;">
                                  <!-- Alert Log -->
                                  <div class="col-md-9">
                                    <div class="card" style="height: 300px;">
                                        <!-- Card Header -->
                                        <div class="d-flex justify-content-between align-items-center"
                                             style="height: 37px;  top: 0; z-index: 1; background-color: #d56570; padding: 0 10px;">
                                             <div style="color:white;">
                                           <img src="<?php echo base_url(); ?>assets/img/alert.gif" width="40" style="border-radius: 50%; max-width: 21%;">&nbsp; Alert Log&nbsp; &nbsp;
                                            <badge class="badge badge-sm rounded-pill bg-blue" id="alert_count">0</badge>
                                        </div>
                                    </div>

                                            <!-- Card Body with Scroll -->
                                            <div class="card-body" style="overflow-y: scroll;">
                                                <table class="table table-striped table-bordered" style="font-size: 16px;">
                                                    <thead class="text-center">
                                                        <tr>
                                                            <th style="font-size: 15px;">S.No</th>
                                                            <th style="font-size: 15px;">Alert Type</th>
                                                            <th style="font-size: 15px;">Alert Status</th>
                                                            <th style="font-size: 15px;">Alert Date-Time</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="text-center" id="alert_log_table">
                                                         </tbody> 
                                                </table>
                                            </div>
                                        </div>
                                    </div>



                                  <!-- Well GIS Map -->
                                  
                                  <!-- Well Report Log -->
                                  <div class="col-md-3">
                                    <div class="card shadow-sm rounded-0" style="height:170px; ">
                                    <div class="d-flex align-items-center justify-content-between text-white"
                                         style="height: 45px; background-color: #d56570; padding: 0 0px;">

                                        <!-- Left side text with margin -->
                                        <strong style="margin-left: 6px;">Well Log</strong>

                                        <!-- Right side image -->
                                    <img src="<?= base_url('assets/img/oil-pump.gif') ?>" 
                                         width="33" height="35" 
                                         style="border-radius: 50%; object-fit: cover; margin-right:7px;">

                                    </div>


                                    <div class="card-body d-flex flex-column" style="padding:10px;">
                                        <a href="<?php echo base_url('Selfflow_historical_report_c'); ?>" 
                                           class="btn btn-sm btn-success w-100 mb-2">
                                           <i class="fas fa-file-alt"></i> Historical Data Log
                                        </a>


                                        <a href="<?php echo base_url('Selfflow_alert_c'); ?>" 
                                           class="btn btn-sm btn-danger w-100 mb-2">
                                           <i class="fas fa-clipboard-list"></i>
                                           Alert Log
                                        </a>

                                        <a href="<?php echo base_url('Selfflow_historical_report_c/historical_graph_page'); ?>" 
                                           class="btn btn-sm" 
                                           style="width:100%; background-color: #3498DB; color:white;">
                                           <i class="fas fa-chart-line"></i>
                                           Historical Log Graph
                                        </a>
                                    </div>

                                    </div>
                                    <div class="col-md-12" style="margin-top: -16px;">
                                    <div class="card" style="height:115px; border-radius:10px;">
                                    <div class="d-flex justify-content-between align-items-center" 
                                         style="background-color:#d56570; padding: 0px 4px 0px 1px;">

                                        <h5 class="text-white" style="font-size: 15px; margin-left:4px ;">Well GIS Map</h5>

                                        <img src="<?php echo base_url() ?>assets/img/map.gif" 
                                             width="40" height="40"
                                             style="border-radius: 50%; border: 2px solid white; object-fit: cover; height:80%;">
                                    </div>

                                        <div class="card-body" style="overflow-y: auto;padding: 2px;">
                                      <div id="mymap" style="width: 100%; height: 70px;"></div>
                                      </div>
                                    </div>
                                  </div>

                                  </div>
                                </div>

                                 <div class="col-xl-12 col-lg-12" style="margin-top:-13px">
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
                                    </div>
                                    </div>
                                    <div class="modal fade" id="well_mark_status" data-bs-backdrop="static">
    <div class="modal-dialog " role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header" style="background-color: #31C4C4;">
                <h4 style="color:white;">Mark  <span id="well_name_data_2" style="color:white"></span>&nbsp; Well Status As Temporary Off &nbsp;&nbsp;</h4>
                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" style="background-color: white;"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
    <form class="custom-validation" method="POST" action="#">
        <div class="row">
            <!-- Hidden field for well_id -->
            <input type="hidden" name="well_data_id" id="well_data_id" value="12345">

            <!-- Reason Dropdown -->
            <div class="form-group col-md-12">
                <h4><b>Temporary Off Reason <span style="color:red">*</span></b></h4>
                <select name="reason" id="reason" class="form-control" required>
                                <option value="">Select</option>
                                <?php 
                                if(!empty($reason_list))
                                {
                                    foreach ($reason_list as $key => $value) 
                                    {
                                        ?>
                                            <option value="<?php echo $value['id']; ?>"> <?php echo $value['reason']; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                              </select>
            </div>

            <!-- Effective Date Time -->
            <div class="form-group col-md-12 mt-2">
                <h4><b>Effective Date Time <span style="color:red">*</span></b></h4>
                <input type="datetime-local" id="effective_date_time" name="effective_date_time" class="form-control" required value="2025-06-19T12:00">
            </div>

            <!-- Flag/Unflag Buttons -->
            <div class="footer mt-4 text-center"> 
                <input type="hidden" name="hdn_flag_status" id="hdn_flag_status" value="1">
                <div id="flag">
                    <button type="submit" class="btn btn-sm btn-primary" name="flag_status" value="1">
                        <i class="fas fa-flag"></i> Flag Well
                    </button>
                </div>
                <div id="unflag" class="mt-2">
                    <button type="submit" class="btn btn-sm btn-primary" name="flag_status" value="0">
                        <i class="fas fa-flag"></i> Un Flag Well
                    </button>
                </div>
            </div>
        </div>
    </form>
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
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<!-- Load Raphael.js first -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.3.0/raphael.min.js"></script>
<!-- Load JustGage.js from another reliable CDN -->
<script src="https://cdn.jsdelivr.net/npm/justgage@1.4.0/justgage.min.js"></script>


<script src="https://cdn.jsdelivr.net/npm/canvas-gauges/gauge.min.js"></script>
<script type="text/javascript" src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBKoAgLoslTEUCNabLj5H5jLVdWFD2WhK8"></script>
<!-- <script src="<?php echo base_url() ?>assets/local/wssclient.js"></script> -->

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

function getAlertLog() {
   let well_id = getWellIdFromURL();

    if (!well_id) {
        console.warn("Well ID not selected!");
        return;
    }

    $.ajax({
    url: "<?php echo base_url() ?>Selfflow_c/get_alert_log",
    type: "POST",
    data: { well_id },
    dataType: "json", // ← This handles JSON parsing
    success: (resp) => {
        console.log(resp, 'alert');
        if (resp.response_code == 200) {
            const alertList = resp.data.well_alert_details || [];
            $('#alert_count').text(resp.data.total_alert || 0);
            let html = "";

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

                    html += `<tr>
                        <td>${i + 1}</td>
                        <td>${alert_data}</td>
                        <td>${v.alert_details}</td>
                        <td>${formattedDatetime}</td>
                    </tr>`;
                });
            } html = `<tr>
    <td colspan="4" class="text-center">
        <img src="<?php echo base_url(); ?>assets/img/no_records.svg" alt="No Alerts" style="height:50px;"><br>
        No alert log found!
    </td>
</tr>`;


            $("#alert_log_table").html(html);
        }
    },
    error: function(xhr, status, error) {
        console.error("AJAX Error:", status, error);
        console.log(xhr.responseText);
        $("#alert_log_table").html(`<tr><td colspan="4">Error loading alerts!</td></tr>`);
    }
});

}
function getWellIdFromURL() {
    const pathSegments = window.location.pathname.split('/');
    return pathSegments[pathSegments.length - 1];
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
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
function toggleDataSeries(e) {
    if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
        e.dataSeries.visible = false;
    } else {
        e.dataSeries.visible = true;
    }
    e.chart.render();
}
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
function Get_Graph() {
    var selectedOption = "1";
    if (selectedOption === "1") {
        var well_id = $('#well_id').val();
        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();

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
                console.log('single_graph', res);
                var res = JSON.parse(res);

                // Create series data
                const mapSeries = (data, name) => ({
                    name: name,
                    data: data.map(point => [new Date(point.x).getTime(), parseFloat(point.y)])
                });

                let series = [
                    mapSeries(res.data.Output_pressure.output_chp, "CHP"),
                    mapSeries(res.data.Output_pressure.output_gip, "GIP"),
                    mapSeries(res.data.Output_pressure.output_thp, "THP"),
                    mapSeries(res.data.Output_pressure.output_abp, "ABP"),
                    mapSeries(res.data.Output_pressure.output_tht, "THT"),
                    mapSeries(res.data.Output_pressure.output_battery, "Battery Voltage")
                ];

                // Destroy existing chart if any
                if (window.outputChart) {
                    window.outputChart.destroy();
                }

                // Chart options
                var options = {
                    chart: {
                        type: 'line',
                        height: 400,
                        zoom: { enabled: true },
                        toolbar: { show: true }
                    },
                    series: series,
                    xaxis: {
                        type: 'datetime',
                        title: { text: 'Timestamp' }
                    },
                    yaxis: {
                        title: { text: 'Reading Value' },
                        min: 0,
                        max: 50
                    },
                    stroke: {
                        curve: 'smooth',  // Spline effect
                        width: 2
                    },
                    tooltip: {
                        x: {
                            format: 'dd MMM yyyy HH:mm'
                        }
                    },
                    legend: {
                        position: 'top'
                    }
                };

                // Render chart in the container
                window.outputChart = new ApexCharts(document.querySelector("#neutral_voltage"), options);
                window.outputChart.render();
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
$(document).ready(function () {
      initMap();
});
$(document).ready(function () {
    getAlertLog(); // or trigger on some well_id change
});
flag_details();
   function flag_details()
   {
      var flag_status_data = $('#hdn_flag_status').val();
      if(flag_status_data == 0)
      {
         $('#flag').show();
         $('#unflag').hide();
               
      }else{
          $('#unflag').show();
          $('#flag').hide();
      }
   }
</script>
