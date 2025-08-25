<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://code.highcharts.com/stock/highstock.js"></script>
<style>
  .blink-red {
        color: red;
        animation: blink 1s infinite;
    }

    .blink-blue {
        color: #0099ff;
        animation: blink 1s infinite;
    }

    .normal {
        color: black; /* green */
    }

    @keyframes blink {
        0% { opacity: 1; }
        50% { opacity: 0; }
        100% { opacity: 1; }
    }

    #back_btns{
        font-size: 16px;
        padding: 3px 13px;
    }
    #back_btns i{
        margin-right: -20px;
        position: relative;
        opacity: 0; 
        transition: all 0.5s ease-out;
    }
    #back_btns:hover i{
        opacity: 1; 
        margin-right: 2px;
    }

    .battery {
    padding: 0px 8px;
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
   

    .sensor-card:hover {
        transform: scale(1.02);
    }

    .pump-image {
        position: relative;
        text-align: center;
       
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
.sensor-three {
    position: absolute;
}

.sensor_one     { left: 70%;  top: 32%; }
.sensor-two     { left: 44%; top: 18%; }
.sensor-two_one { left: 58%; top: 32%; }
.sensor-three   { left: 41%; top: 57%; }

/* Sensor data bubbles */
.sensor_one_data, .sensor_two_data,
.sensor_two_data_two, .sensor_three_data,
.sensor_four_data {
    position: absolute;
    display: flex;
    border: 1px solid #ccc;
    background: #fff;
    font-size: 12px;
    font-weight: 500;
    border-radius: 3px;       
    box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    min-width: 68px;          
    justify-content: center;  
    align-items: center;    
    padding: 2px 6px;         
    line-height: 1.4;    
    white-space: nowrap;    
}


/* Data bubble positioning (also in %) */
.sensor_one_data     { left: 20%; top:166%; }
.sensor_two_data     { left: -88%;; bottom:109%; }
.sensor_two_data_two { left: -11%; bottom:105%; }
.sensor_three_data   { left: -115%; bottom: 102%; }



 .pump-image img[alt="sensor-icon"] {
    height: 30px !important; /* smaller size */

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
     .battery-container {
        max-width: 120px;
        margin: auto;
    }

    #batteryCircle {
        transition: stroke-dashoffset 0.8s ease, stroke 0.5s ease;
    }
    .tooltip-inner {
        background-color: #1e88e5 !important;
        color: #fff !important;            
        font-weight: 500;
        font-size: 13px;
        padding: 6px 10px;
        border-radius: 6px;
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
<div class="page-wrapper custome-name">
   <div class="content container-fluid" >
      <!-- Page Header -->
      <div class="page-header" style=" margin-bottom:0px; margin-top: -30px;">
         <div class="row align-items-center">
            <div class="col">
               <ul class="breadcrumb">
                  <li class="breadcrumb-item active"><h3 class="page-title">Self Flow Single Well Dashboard</h3></li>
               </ul>
            </div>
                <div class="col-auto float-end ms-auto">
                   <a href="<?php echo base_url('')?>Selfflow_c">
                        <button type="button" id="back_btns" class="btn btn-outline-warning">
                            <i class="fa-solid fa-left-long"></i> Back
                        </button>
                    </a>
                   
                </div>
             </div>
          </div>
        <div class="row mt-2">
          <!-- Well Status Card -->
          <div class="col-md-4 mb-3">
             <div class="bg-white rounded-3" style="height:100%; border: 1px solid #ededed; box-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);">
                <div class=" px-3 d-flex justify-content-between align-items-center topCards" style="height:40px; background-color:blueviolet;border-top-left-radius: 10px;  border-top-right-radius: 10px;">
                   <b class="text-white"><span id="wellnamehdn"></span> &nbsp; ( <span id="welltypehdn"></span> )</b>
                   <img src="<?php echo base_url(); ?>assets/img/well.gif" width="30" style="border-radius: 50%;">
                </div>
                <div class="px-3 text-start">
                   <div class="pump-image">
                      <!-- Sensors -->
                      <div class="sensor_one">
                         <img src="<?php echo base_url() ?>assets/icons/psr.png" alt="sensor-icon">
                         <div class="sensor_one_data"><strong>FLT &nbsp;</strong> <span id="sensor-one-value"><span id="flt_image"></span> (°C)</span></div>
                      </div>
                      <div class="sensor-two" id="sensorthp">
                         <img height="35" src="<?php echo base_url() ?>assets/icons/psr.png" alt="sensor-icon">
                         <div class="sensor_two_data"><strong>THP &nbsp;</strong> <span id="sensor-two-value"><span id="thp_image"></span> (kg/cm²) </span></div>
                      </div>
                      <div class="sensor-two_one" id="sensorabp">
                         <img height="35" src="<?php echo base_url() ?>assets/icons/psr.png" alt="sensor-icon">
                         <div class="sensor_two_data_two"><strong>ABP &nbsp; </strong> <span id="sensor-two-value"><span id="abp_image"></span> (kg/cm²)</span></div>
                      </div>
                      <div class="sensor-three" id="sensorchp">
                         <img height="35" src="<?php echo base_url() ?>assets/icons/psr.png" alt="sensor-icon">
                         <div class="sensor_three_data"><strong> CHP &nbsp; </strong> <span id="sensor-three-value"> <span id="chp_image"></span> (kg/cm²)</span></div>
                      </div>
                      <div style="padding-top:25px;">
                         <img class="pump-img" style="max-width:100%; margin-top: -10px; margin-right:24px; height: 279px;" 
                            src="<?php echo base_url() ?>assets/img/well_image.png" alt="pump-img">
                      </div>
                   </div>
                   <div class="text-center">
                       <a href="<?php echo base_url('Selfflow_alert_c/index/'.$this->uri->segment(3)); ?>" 
                          class="btn btn-sm btn-outline-danger w-50 mb-2" 
                          style="border-radius:50px;" 
                          data-bs-toggle="tooltip" 
                          data-bs-placement="top" 
                          title="View all alert logs">
                         <i class="fas fa-clipboard-list"></i> Alert Log
                       </a>
                     </div>


                </div>
             </div>
          </div>
          <div class="col-md-4 mb-3">
             <div class="bg-white rounded-3" style="height:100%; border: 1px solid #ededed; box-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);">
                <div class=" px-3 d-flex justify-content-between align-items-center topCards" style="height:40px; background-color:blueviolet;border-top-left-radius: 10px; border-top-right-radius: 10px;">
                   <b class="text-white">Battery</b>
                   <img src="<?php echo base_url(); ?>assets/img/volt.gif" width="30" style="border-radius: 50%;">
                </div>
                <div class="px-3 text-start">
                   <div class="card-body text-center" style="padding: 13px;">
                      <div class="row">
                         <div class="col-12 text-center">
                            <!-- Circular Battery -->
                            <div class="col-12">
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
                                    <strong class="fs-15">Battery  </strong><span id="battery_value">0 V</span>
                                </div>
                        
                            </div>
                         </div>
                         <div class="px-3 pt-2 pb-3" style="text-align: left;">
                            <div class="card-body p-0">
                               <!-- Compact Table -->
                               <table class="table table-sm text-center mb-0" style="font-size: 11px; line-height: 1; border-collapse: collapse; width: 100%;">
                                  <thead style="background-color: blueviolet;">
                                     <tr>
                                        <th style="padding: 6px; border: 1px solid #dee2e6;"></th>
                                        <th colspan="2" style="padding: 6px; border: 1px solid #dee2e6; font-weight: bold; text-align: center;">Average</th>
                                        <th style="padding: 6px; border: 1px solid #dee2e6;"></th>
                                     </tr>
                                     <tr>
                                        <th style="padding: 6px; border: 1px solid #dee2e6;">Mes. Point</th>
                                        <th style="padding: 6px; border: 1px solid #dee2e6;">Daily</th>
                                        <th style="padding: 6px; border: 1px solid #dee2e6;">Monthly</th>
                                        <th style="padding: 6px; border: 1px solid #dee2e6; width:20%">Battery Voltage</th>
                                     </tr>
                                  </thead>
                                  <tbody>
                                     <!-- Row 1 -->
                                     <tr>
                                        <td style="padding: 3px; border: 1px solid #dee2e6;">FLT ( °C )</td>
                                        <td style="padding: 3px; border: 1px solid #dee2e6;"><span id="flt_daily"></span></td>
                                        <td style="padding: 3px; border: 1px solid #dee2e6;"><span id="flt_monthly"></span></td>
                                        <td style="padding: 3px; border: 1px solid #dee2e6;">
                                           <div class="d-flex align-items-center gap-2">
                                              <!-- Circular Battery -->
                                              <div class="position-relative d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                 <svg width="40" height="40">
                                                    <circle cx="20" cy="20" r="16" stroke="#E8E4E1" stroke-width="4" fill="none" />
                                                    <circle id="FLT_batteryCircle" cx="20" cy="20" r="16" stroke="#28a745" stroke-width="4" fill="none"
                                                       stroke-dasharray="100.5" stroke-dashoffset="30"
                                                       stroke-linecap="round" transform="rotate(-90 20 20)" />
                                                 </svg>
                                                 <div class="position-absolute top-50 start-50 translate-middle">
                                                    <img id="FLT_batteryImg" src="<?= base_url() ?>assets/img/empty-battery.png" 
                                                       style="height: 16px;" alt="Battery">
                                                 </div>


                                              </div>
                                              <span id="FLT_battery_volt" style="margin-top: 5px; font-size: 12px; font-weight: bold;">0 V</span>
                                           </div>
                                        </td>
                                     </tr>
                                     <!-- Row 2 -->
                                     <tr>
                                        <td style="padding: 3px; border: 1px solid #dee2e6;">THP ( kg/cm² )</td>
                                        <td style="padding: 3px; border: 1px solid #dee2e6;"><span id="thp_daily"></span></td>
                                        <td style="padding: 3px; border: 1px solid #dee2e6;"><span id="thp_monthly"></span></td>
                                        <td style="padding: 3px; border: 1px solid #dee2e6;">
                                           <div class="d-flex align-items-center gap-2">
                                              <!-- Circular Battery -->
                                              <div class="position-relative d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                 <svg width="40" height="40">
                                                    <circle cx="20" cy="20" r="16" stroke="#E8E4E1" stroke-width="4" fill="none" />
                                                    <circle id="THP_batteryCircle" cx="20" cy="20" r="16" stroke="#28a745" stroke-width="4" fill="none"
                                                       stroke-dasharray="100.5" stroke-dashoffset="30"
                                                       stroke-linecap="round" transform="rotate(-90 20 20)" />
                                                 </svg>
                                                 <div class="position-absolute top-50 start-50 translate-middle">
                                                    <img id="THP_batteryImg" src="<?= base_url() ?>assets/img/empty-battery.png" 
                                                       style="height: 16px;" alt="Battery">
                                                 </div>
                                              </div>
                                              <span id="THP_battery_volt" style="margin-top: 5px; font-size: 12px; font-weight: bold;">0 V</span>
                                           </div>
                                        </td>
                                     </tr>
                                     <!-- Row 3 -->
                                     <tr>
                                        <td style="padding: 3px; border: 1px solid #dee2e6;">ABP ( kg/cm² )</td>
                                        <td style="padding: 3px; border: 1px solid #dee2e6;"><span id="abp_daily"></span></td>
                                        <td style="padding: 3px; border: 1px solid #dee2e6;"><span id="abp_monthly"></span></td>
                                        <td style="padding: 3px; border: 1px solid #dee2e6;">
                                           <div class="d-flex align-items-center gap-2">
                                              <!-- Circular Battery -->
                                              <div class="position-relative d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                 <svg width="40" height="40">
                                                    <circle cx="20" cy="20" r="16" stroke="#E8E4E1" stroke-width="4" fill="none" />
                                                    <circle id="ABP_batteryCircle" cx="20" cy="20" r="16" stroke="#28a745" stroke-width="4" fill="none"
                                                       stroke-dasharray="100.5" stroke-dashoffset="30"
                                                       stroke-linecap="round" transform="rotate(-90 20 20)" />
                                                 </svg>
                                                 <div class="position-absolute top-50 start-50 translate-middle">
                                                    <img id="ABP_batteryImg" src="<?= base_url() ?>assets/img/empty-battery.png" 
                                                       style="height: 16px;" alt="Battery">
                                                 </div>
                                              </div>
                                              <span id="ABP_battery_volt" style="margin-top: 5px; font-size: 12px; font-weight: bold;">0 V</span>
                                           </div>
                                        </td>
                                     </tr>
                                     <!-- Row 4 -->
                                     <!-- Row 5 -->
                                     <tr>
                                        <td style="padding: 3px; border: 1px solid #dee2e6;">CHP ( kg/cm² )</td>
                                        <td style="padding: 3px; border: 1px solid #dee2e6;">
                                           <span id="chp_daily"></span>
                                        </td>
                                        <td style="padding: 3px; border: 1px solid #dee2e6;">
                                           <span id="chp_monthly"></span>
                                        </td>
                                        <td style="padding: 3px; border: 1px solid #dee2e6;">
                                           <div class="d-flex align-items-center gap-2">
                                              <div class="position-relative d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                 <svg width="40" height="40">
                                                    <circle cx="20" cy="20" r="16" stroke="#E8E4E1" stroke-width="4" fill="none" />
                                                    <circle id="CHP_batteryCircle" cx="20" cy="20" r="16" stroke="#28a745" stroke-width="4" fill="none"
                                                       stroke-dasharray="100.5" stroke-dashoffset="30"
                                                       stroke-linecap="round" transform="rotate(-90 20 20)" />
                                                 </svg>
                                                 <div class="position-absolute top-50 start-50 translate-middle">
                                                    <img id="CHP_batteryImg" src="<?= base_url() ?>assets/img/empty-battery.png" 
                                                       style="height: 16px;" alt="Battery">
                                                 </div>
                                              </div>
                                              <span id="CHP_battery_volt" style="margin-top: 5px; font-size: 12px; font-weight: bold;">0 V</span>
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
          <div class="col-md-4 mb-3">
             <div class="bg-white rounded-3 shadow-sm border" style="height: 100%; border: 1px solid #ededed;">
                <!-- Card Header -->
                <div class="card-header px-3 d-flex justify-content-between align-items-center"
                   style="height: 40px; background:blueviolet ;color: white;border-top-left-radius: 10px; border-top-right-radius: 10px;">
                   <b>RTMS Status</b>
                   <img src="<?php echo base_url(); ?>assets/img/device.gif" 
                      width="30" height="24" 
                      style="border-radius: 50%;">
                </div>
                <!-- Card Body -->
                <div class="p-3">
                   <!-- Status -->
                   <div class="text-center mb-3" id="rtms_status_image">
                     
                   </div>
                   <!-- Last Date-Time -->
                   <div class="text-center mb-3">
                      <div style="font-size: 13px; color: #555;">Last Updated</div>
                      <div style="font-weight: bold; font-size: 13px;">
                         <i class="bi bi-clock me-1 text-primary"></i><span id="last_updated_datetime"></span>
                      </div>
                   </div>
                   <!-- RTMS Info Grid -->
                   <div class="d-flex flex-column gap-2 px-2">
                      <div class="d-flex align-items-center justify-content-between bg-light rounded px-2 py-1">
                         <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-lightning-fill text-secondary"></i>
                            <span style="font-size: 13px;">Device Name</span>
                         </div>
                         <span style="font-weight: 500; font-size: 13px;" id="device_name"></span>
                      </div>
                      <div class="d-flex align-items-center justify-content-between bg-light rounded px-2 py-1">
                         <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-upc-scan text-secondary"></i>
                            <span style="font-size: 13px;">Imei No</span>
                         </div>
                         <span style="font-weight: 500; font-size: 13px;" id="imei_no"></span>
                      </div>
                   </div>
                   <!-- Flag Button Centered -->
                   <div class="text-center mt-3">
                      <button class="btn btn-sm btn-outline-danger w-50  mb-2"  data-bs-toggle="modal"
                         data-bs-target="#well_mark_status"
                         id="flag_text"
                         style="border-radius:50px;">
                      <i class="bi bi-flag-fill"></i> Flag Well
                      </button>
                  <a href="<?php echo base_url('Selfflow_historical_report_c/index/' . $this->uri->segment(3)); ?>" 
                        class="btn btn-sm btn-outline-success w-50 mb-2" 
                        style="border-radius:50px;"
                        data-bs-toggle="tooltip" 
                        data-bs-placement="top" 
                        title="View Historical logs">
                        <i class="fas fa-file-alt"></i> Historical Log
                     </a>

                     <a href="<?php echo base_url('Selfflow_historical_report_c/historical_graph_page/' . $this->uri->segment(3)); ?>" 
                        class="btn btn-sm btn-outline-primary w-50" 
                        style="border-radius:50px;" 
                        data-bs-toggle="tooltip" 
                        data-bs-placement="top" 
                        title="View Historical log Graph">
                        <i class="fas fa-chart-line"></i> Historical Graph
                     </a>

                 </div>
                </div>
             </div>
          </div>
        </div>
          <!-- row -->
          <div class="row mt-3">
             <div class="col-md-6">
                <div class="card" style="height: 300px; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                   <!-- Card Header -->
                   <div class="d-flex justify-content-between align-items-center"
                      style="height:40px; top: 0; z-index: 1; background-color: #A038A0; padding: 0 10px;border-top-left-radius: 10px; 
                      border-top-right-radius: 10px;">
                      <div style="color:white;">
                         Alert Log&nbsp;&nbsp;
                         <badge class="badge badge-sm rounded-pill bg-blue" id="alert_count">0</badge>
                      </div>
                      <!-- Right: Image -->
                      <div>
                         <img src="<?php echo base_url(); ?>assets/img/alert.gif"
                            width="40"
                            style="border-radius: 50%; max-width: 82%;">
                      </div>
                   </div>
                   <!-- Card Body with Scroll -->
                   <div class="card-body" style="overflow-y: scroll;">
                      <table class="table table-bordered" style="font-size: 15px; border-collapse: collapse;">
                        <thead class="text-center" style="border: 1px solid #dee2e6;">
                            <tr>
                                <th style="border: 1px solid #dee2e6;">S.No</th>
                                <th style="border: 1px solid #dee2e6;">Alert Type</th>
                                <th style="border: 1px solid #dee2e6;">Alert Status</th>
                                <th style="border: 1px solid #dee2e6;">Alert Date-Time</th>
                            </tr>
                        </thead>
                        <tbody class="text-center" id="alert_log_table">
                        </tbody>
                    </table>

                   </div>
                </div>
             </div>
             <!-- Well GIS Map -->
             <div class="col-md-6">
                <div class="card" style="height: 300px;border-radius:10px;border-top-left-radius: 10px; border-top-right-radius: 10px;">
                    <div class="d-flex justify-content-between align-items-center"
                      style="height:40px; top: 0; z-index: 1; background-color: #A038A0; padding: 0 10px;border-top-left-radius: 10px; 
                      border-top-right-radius: 10px;">
                      <div style="color:white;">
                         Well GIS Map&nbsp;&nbsp;
                      </div>
                      <!-- Right: Image -->
                      <div>
                         <img src="<?php echo base_url(); ?>assets/img/map.gif"
                            width="40"
                            style="border-radius: 50%; max-width: 82%;">
                      </div>
                   </div>
                   <div class="card-body" style="overflow-y: auto;padding: 2px;">
                      <div id="mymap" style="width: 100%; height: 253px;"></div>
                   </div>
                </div>
             </div>
          </div>
          <div class="row">
          <div class="col-md-12">
           <div class="card" style="height: 520px; border-radius: 10px;">
              <div class="card-header d-flex justify-content-between align-items-center" 
                   style="padding: 5px; background-color:#6f42c1; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                 
                 <!-- Left side: Graph Image + Title -->
                 <div class="d-flex align-items-center" style="color:white;">
                    <img src="<?php echo base_url(); ?>assets/img/line-chart.gif" 
                         width="33" 
                         style="border-radius: 50%; margin-left:3px; margin-right:6px;">
                    <span style="font-size:16px; font-weight:500;">Graph</span>
                 </div>

                 <!-- Right side: Inputs + Buttons -->
                 <div class="d-flex align-items-center">
                    <input type="datetime-local" name="from_date" class="form-control me-2"
                       id="from_date" style="max-width: 123px; padding: 2px 6px; font-size: 12px; height: 30px;">
                    <input type="datetime-local" name="to_date" class="form-control me-2"
                       id="to_date" style="max-width: 123px; padding: 2px 6px; font-size: 12px; height: 30px;">

                    <button class="btn btn-danger me-2"
                       style="height: 30px; line-height: 1; display: flex; align-items: center; justify-content: center; padding: 0 12px;"
                       onclick="Get_Graph()">Generate</button>

                    <button type="button" class="btn btn-light" onclick="resetDates()" style="padding: 2px 6px; margin-right:2px;">
                       <i class="fa-solid fa-arrows-rotate"></i>
                    </button>
                 </div>
              </div>

              <div id="processing_message" style="display: none;">
                 <img src="<?php echo base_url(); ?>assets/loader_img.svg" 
                      class="loader-img" 
                      alt="Loader" 
                      style="height:200px;width:100px; display:block; margin:0 auto;">
              </div>

              <div id="neutral_voltage" style="height: 600px; width: 100%;"></div>
           </div>
        </div>
         </div>
       </div>
    </div>

<div class="modal fade" id="well_mark_status" data-bs-backdrop="static">
<div class="modal-dialog" role="document">
<div class="modal-content modal-content-demo">
<div class="modal-header" style="background-color: #31C4C4;">
   <h4 style="color:white;">Mark  <span id="well_name_data_2" style="color:white"></span>&nbsp; Well Status As Temporary Off &nbsp;&nbsp;</h4>
   <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" style="background-color: white;"><span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">
   <form class="custom-validation" method="POST" action="<?php echo base_url('Selfflow_c/add_well_reason')?>">
      <div class="row">
         <input type="hidden" name="well_data_id" id="well_data_id" value="">
         <input type="hidden" name="well_type" id="well_type" value="">
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
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<!-- Load Raphael.js first -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.3.0/raphael.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBKoAgLoslTEUCNabLj5H5jLVdWFD2WhK8"></script>
<!-- <script src="<?php echo base_url() ?>assets/local/wssclient.js"></script> -->
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
getAlertLog();
function getAlertLog() {
    let well_id = '<?php echo $this->uri->segment(3); ?>'; 

    if (!well_id) {
        console.warn("Well ID not selected!");
        return;
    }

    $.ajax({
        url: "<?php echo base_url() ?>Selfflow_c/get_single_well_details",
        type: "POST",
        data: { well_id },
        dataType: "json",
        success: function(resp) {
            console.log(resp, 'alert');

            if (resp.response_code !== 200) {
                $("#alert_log_table").html(`<tr><td colspan="4" class="text-center text-danger">Failed to fetch data!</td></tr>`);
                return;
            }

            const alertList = resp.data.well_alert_details || [];
            $('#alert_count').text(resp.data.total_alert || 0);

            let html = "";

            if (alertList.length > 0) {
                const alertMap = {
                    1: 'CHP Low',
                    2: 'CHP High',
                    3: 'ABP Low',
                    4: 'ABP High',
                    5: 'THP Low',
                    6: 'THP High',
                    7: 'FLT Low',
                    8: 'FLT High',
                    9: 'Battery Low',
                    10: 'Battery High'
                };

                $.each(alertList, function(i, v) {
                    let alert_data = alertMap[parseInt(v.alert_type)] || 'Unknown Alert Type';
                    let date = v.trip_datetime ? new Date(v.trip_datetime) : null;
                    let formattedDatetime = date
                        ? `${date.getDate().toString().padStart(2,'0')}-${(date.getMonth()+1).toString().padStart(2,'0')}-${date.getFullYear()} ${date.getHours().toString().padStart(2,'0')}:${date.getMinutes().toString().padStart(2,'0')}:${date.getSeconds().toString().padStart(2,'0')}`
                        : 'Invalid Date';

                    html += `<tr>
                        <td>${i + 1}</td>
                        <td>${alert_data}</td>
                        <td>${v.alert_details}</td>
                        <td>${formattedDatetime}</td>
                    </tr>`;
                });
            } else {
                html = `<tr>
                    <td colspan="4" class="text-center">
                        <img src="<?php echo base_url(); ?>assets/img/no_records.svg" alt="No Alerts" style="height:50px;"><br>
                        No alert log found!
                    </td>
                </tr>`;
            }

            $("#alert_log_table").html(html);
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", status, error);
            $("#alert_log_table").html(`<tr><td colspan="4" class="text-center text-danger">Error loading alerts!</td></tr>`);
        }
    });
}

get_single_well_details();
function get_single_well_details() {
    let well_id = '<?php echo $this->uri->segment(3); ?>'; 
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

                if (resp.data.single_welldevice_data.length > 0) {
                    let deviceData = resp.data.single_welldevice_data[0];
                    $('#device_name').text(deviceData.device_name || '');
                    $('#imei_no').text(deviceData.imei_no || '');
                    $('#imei_no_hdn').val(deviceData.imei_no || '');
                    $('#well_id_hdn').val(deviceData.well_id || '');
                    $('#well_name_hdn').text(deviceData.well_name || '');
                    $('#flag_status').text(deviceData.flag_status || '');
                    $('#well_data_id').val(deviceData.well_id || '');
                    $('#well_type').val(deviceData.well_type || '');
                    $('#wellnamehdn').text(deviceData.well_name || '');
                    $('#well_name_data_2').text(deviceData.well_name || '');
                    $('#welltypehdn').text(deviceData.well_type_name || '');
                    
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

                    $('#chp_image').text((deviceData.CHP || 0) + " kg/cm²");
                    $('#thp_image').text((deviceData.THP || 0) + " kg/cm²");
                    $('#abp_image').text((deviceData.ABP || 0) + " kg/cm²");
                    $('#flt_image').text((deviceData.FLT || 0) + " °C");


                    $('#battery_value').text((deviceData.Battery_Voltage || 0) + " v ");

                    var last_datetime = deviceData.Log_Date_Time != null ? moment(deviceData.Log_Date_Time)
                        .format('DD-MM-YYYY h:mm:ss a') : "NA";

                    $('#last_updated_datetime').text(last_datetime);
                    var last_updated_time = deviceData.Log_Date_Time;
                    var lastDataTimeObj = new Date(last_updated_time);
                    var currentDate = new Date();
                    var diffInMilliseconds = currentDate - lastDataTimeObj;
                    seconds = Math.floor(diffInMilliseconds / 1000);
                
                    let timeLimit = 300; 

                    if (seconds < timeLimit) {
                        $('#rtms_status_image').html(
                            '<span class="badge rounded-pill  px-4 py-2" style="font-size: 13px;background:#20c997;">' +
                            '<i class="bi bi-circle-fill me-1" style="font-size:10px;"></i> Online' +
                            '</span>'
                        );
                    } else if(flag_status_data == 1)
                    {
                        $('#rtms_status_image').html(
                            '<span class="badge rounded-pill px-4 py-2" style="font-size: 13px;background:#800000;">' +
                            '<i class="bi bi-circle-fill me-1" style="font-size:10px;"></i> Temporary off well' +
                            '</span>'
                        );
                    }else{
                        $('#rtms_status_image').html(
                               '<span class="badge rounded-pill bg-secondary px-4 py-2" style="font-size: 13px;">' +
                               '<i class="bi bi-circle-fill me-1" style="font-size:10px;"></i> Offline' +
                               '</span>'
                           );
                    }


                    $('#THP_battery_volt').text((parseFloat(deviceData.THP_battery_volt) || 0).toFixed(2));
                    $('#ABP_battery_volt').text((parseFloat(deviceData.ABP_battery_volt) || 0).toFixed(2));
                    $('#CHP_battery_volt').text((parseFloat(deviceData.CHP_battery_volt) || 0).toFixed(2));
                    $('#FLT_battery_volt').text((parseFloat(deviceData.FLT_battery_volt) || 0).toFixed(2));

                        // Battery status updates (assuming you have this function)
                    updateBatteryStatus(parseFloat(deviceData.THP_battery_volt || 0), 'THP_batteryCircle', 'THP_battery_volt', 'THP_batteryImg');
                    updateBatteryStatus(parseFloat(deviceData.ABP_battery_volt || 0), 'ABP_batteryCircle', 'ABP_battery_volt', 'ABP_batteryImg');
                    updateBatteryStatus(parseFloat(deviceData.CHP_battery_volt || 0), 'CHP_batteryCircle', 'CHP_battery_volt', 'CHP_batteryImg');
                    updateBatteryStatus(parseFloat(deviceData.FLT_battery_volt || 0), 'FLT_batteryCircle', 'FLT_battery_volt', 'FLT_batteryImg');



                    const thresholdData = deviceData.threshold_data || [];

                    function getThresholdLimits(nodeName, thresholdArray) {
                        const match = thresholdArray.find(item => item.node_name === nodeName);
                        return {
                            lower: match ? parseFloat(match.lower_value) : 0.00,
                            upper: match ? parseFloat(match.upper_value) : 0.00
                        };
                    }

                    // Helper function to apply color class based on thresholds
                    function applyThresholdColor(value, lower, upper, elementId) {
                        const $el = $('#' + elementId);
                        $el.removeClass('blink-red normal');
                        if (value > upper || value < lower) {
                            $el.addClass('blink-red');
                        } else {
                            $el.addClass('normal');
                        }
                    }

                    const sensors = ['CHP', 'THP', 'ABP', 'FLT'];

                    sensors.forEach(sensor => {
                    const limits = getThresholdLimits(sensor, thresholdData);
                    const value = parseFloat(deviceData[sensor] || 0.00);

                    // Set sensor value in span with 2 decimal places
                    $('#' + sensor.toLowerCase() + '_image').text(value.toFixed(2));

                    // Apply threshold color
                    applyThresholdColor(value, limits.lower, limits.upper, sensor.toLowerCase() + '_image');
                });


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

                    // setupWebSocket();


                }
            }
        }
    });
}


function getThresholdLimits(nodeName, thresholdArray) {
    const match = thresholdArray.find(item => item.node_name === nodeName);
    return {
        lower: match ? parseFloat(match.lower_value) : 0,
        upper: match ? parseFloat(match.upper_value) : 0
    };
}

function applyThresholdColor(value, lower, upper, elementId) {
    const $el = $('#' + elementId);
    $el.removeClass('blink-red blink-blue normal'); 

    if (value > upper) {
        $el.addClass('blink-red');
    } else if (value < lower) {
        $el.addClass('blink-red');
    } else {
        $el.addClass('normal');
    }
}


function updateBatteryStatus(voltage, circleId, valueId, imageId, isMain = false) {
    let percentage;
    let color = '';
    let imageSrc = '';

    const batteryCircle = document.getElementById(circleId);
    const batteryValue = document.getElementById(valueId);
    const batteryImage = document.getElementById(imageId);

        const maxVoltage = 3.7;
        if (voltage >= 3.7) {
            color = '#28a745';
            imageSrc = "<?= base_url() ?>assets/img/p1.png";
        } else if (voltage > 3 && voltage <= 3.7) {
            color = '#28a745';
            imageSrc = "<?= base_url() ?>assets/img/b4.png";
        } else if (voltage > 2.8 && voltage < 3) {
            color = '#ffc107';
            imageSrc = "<?= base_url() ?>assets/img/power.png";
        } else if (voltage > 0 && voltage <= 2.8) {
            color = '#dc3545';
            imageSrc = "<?= base_url() ?>assets/img/low-bat1.png";
        } else {
            color = '#E8E4E1';
            imageSrc = "<?= base_url() ?>assets/img/empty-battery.png";
        }

        percentage = (voltage <= 0) ? 100 : Math.min(100, Math.max(0, (voltage / maxVoltage) * 100));
    

    const dashOffset = (voltage <= 0) ? 0 : (106.8 - (106.8 * (percentage / 100)));
    if (batteryCircle) {
        batteryCircle.setAttribute('stroke-dashoffset', dashOffset.toFixed(2));
        batteryCircle.setAttribute('stroke', color);
    }

    // Update value
    if (batteryValue) {
        batteryValue.innerText = voltage.toFixed(2) + ' v';
    }

    // Update image
    if (batteryImage) {
        batteryImage.setAttribute('src', imageSrc);
    }
}
get_temperory_well_value();
function get_temperory_well_value() {
    let well_id = '<?php echo $this->uri->segment('3')?>';

    $.ajax({
        url: '<?php echo base_url(); ?>Selfflow_c/well_status_details',
        type: 'POST',
        data: {
            well_id: well_id
        },
        success: function(res) {
            res = JSON.parse(res);
            console.log(res, 'fhdgesj');
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
    let well_id = '<?php echo $this->uri->segment('3')?>';

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
                
                    $('#chp_daily').text(parseFloat(pressureDailyAvg.avg_CHP || 0).toFixed(2));
                    $('#thp_daily').text(parseFloat(pressureDailyAvg.avg_THP || 0).toFixed(2));
                    $('#abp_daily').text(parseFloat(pressureDailyAvg.avg_ABP || 0).toFixed(2));
                    $('#flt_daily').text(parseFloat(pressureDailyAvg.avg_FLT || 0).toFixed(2));
                   
                    // Bind monthly pressure data
                    let pressureMonthlyAvg = resp.data.pressure_monthly_avg || {};
                    $('#chp_monthly').text(parseFloat(pressureMonthlyAvg.avg_CHP || 0).toFixed(2));
                    $('#flt_monthly').text(parseFloat(pressureMonthlyAvg.avg_FLT || 0).toFixed(2));
                    $('#abp_monthly').text(parseFloat(pressureMonthlyAvg.avg_ABP || 0).toFixed(2));
                    $('#thp_monthly').text(parseFloat(pressureMonthlyAvg.avg_THP || 0).toFixed(2));
                    
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
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>

   Get_Graph();
    function Get_Graph() {
   let base_url = '<?php echo base_url();?>';
        const well_id = '<?php echo $this->uri->segment('3');?>'
        const from_date = $('#from_date').val();
        const to_date = $('#to_date').val();
        document.getElementById("neutral_voltage").innerHTML = "";
        document.getElementById("processing_message").style.display = "block";

        $.ajax({
            url: '<?php echo base_url();?>Selfflow_c/get_all_dashboard_data_graph_ajax',
            type: 'POST',
            data: {
                well_id: well_id,
                from_date: from_date,
                to_date: to_date,
            },
            success: function (res) 
            {
                document.getElementById("processing_message").style.display = "none";

                try {
                    const result = JSON.parse(res);
                    if (!result?.data?.Output_pressure) {
                        swal('warning',"No data returned from server.",'warning');
                        return;
                    }

                    loadChartNeutralVoltage(result.data.Output_pressure);

                } catch (e) {
                    console.error("JSON parse error:", e);
                    swal('warning',"Something went wrong while processing data.",'warning');
                }
            },
            error: function (xhr, status, error) {
                document.getElementById("processing_message").style.display = "none";
                console.error("AJAX Error:", error);
            }
        });
    
}

function loadChartNeutralVoltage(output) {
    console.log(output, 'output');
    const chartContainer = document.querySelector("#neutral_voltage");
    if (!chartContainer) return;

    const convertToTimestamp = (data) => {
        return data
            .filter(d => d.x && !isNaN(new Date(d.x.replace(' ', 'T')).getTime()))
            .map(d => [
                new Date(d.x.replace(' ', 'T')).getTime(),
                parseFloat(d.y)
            ]);
    };

    const series = [];

    if (output.CHP?.length) {
        const data = convertToTimestamp(output.CHP);
        if (data.length) series.push({ name: 'CHP', data, tooltip: { valueSuffix: ' ( kg/cm² )' } });
    }

    if (output.ABP?.length) {
        const data = convertToTimestamp(output.ABP);
        if (data.length) series.push({ name: 'ABP', data, tooltip: { valueSuffix: ' ( kg/cm² )' } });
    }

    if (output.THP?.length) {
        const data = convertToTimestamp(output.THP);
        if (data.length) series.push({ name: 'THP', data, tooltip: { valueSuffix: ' ( kg/cm² )' } });
    }

    if (output.FLT?.length) {
        const data = convertToTimestamp(output.FLT);
        if (data.length) series.push({ name: 'FLT', data, tooltip: { valueSuffix: ' ( °C )' } });
    }

    if (output.Battery_Voltage?.length) {
        const data = convertToTimestamp(output.Battery_Voltage);
        if (data.length) series.push({ name: 'Battery Voltage', data, tooltip: { valueSuffix: ' ( V )' } });
    }

    if (series.length === 0) {
        chartContainer.innerHTML = `
            <div class="text-center mt-4">
                <img src="<?php echo base_url();?>assets/img/no_records.svg" width="100" class="mx-auto d-block" />
                <div class="text-danger mt-2">No records found or all graph filters are off.</div>
            </div>`;
        return;
    }

    const unitsMap = {
        'CHP': 'kg/cm²',
        'ABP': 'kg/cm²',
        'THP': 'kg/cm²',
        'FLT': '°C',
        'Battery Voltage': 'V'
    };

    Highcharts.stockChart('neutral_voltage', {
        time: {
            useUTC: false
        },
        chart: {
            height: 500
        },
        rangeSelector: {
            enabled: true
        },
        navigator: {
            enabled: true
        },
        scrollbar: {
            enabled: true
        },
        legend: {
            enabled: true,
            align: 'center',
            verticalAlign: 'top',
            layout: 'horizontal',
            labelFormatter: function () {
                const unit = unitsMap[this.name] || '';
                const lastPoint = this.yData?.[this.yData.length - 1];
                if (typeof lastPoint !== 'undefined') {
                    return `${this.name}: ${lastPoint.toFixed(2)} ${unit}`;
                } else {
                    return `${this.name} (${unit})`;
                }
            }
        },
        xAxis: {
            type: 'datetime',
            labels: {
                format: '{value:%d-%m-%Y %I:%M %p}',
                align: 'center',
                style: {
                    fontSize: '10px'
                }
            },
            tickPixelInterval: 150,
            dateTimeLabelFormats: {
                millisecond: '%d-%m-%Y %I:%M:%S %p',
                second: '%d-%m-%Y %I:%M:%S %p',
                minute: '%d-%m-%Y %I:%M %p',
                hour: '%d-%m-%Y %I:%M %p',
                day: '%d-%m-%Y %I:%M %p',
                week: '%d-%m-%Y %I:%M %p',
                month: '%d-%m-%Y %I:%M %p',
                year: '%d-%m-%Y %I:%M %p'
            }
        },
        yAxis: [{
            title: {
                text: 'Component Value',
                style: {
                    fontSize: '12px',
                    color: '#333'
                }
            },
            labels: {
                align: 'right',
                x: 0,
                formatter: function () {
                    return this.value.toFixed(2);
                }
            },
            opposite: false,
            plotLines: [{
                value: 0,
                width: 1,
                color: 'silver'
            }]
        }],
        tooltip: {
            split: true,
            valueDecimals: 2
        },
        plotOptions: {
            series: {
                showInNavigator: false,
                marker: { enabled: false }
            }
        },
        series: series
    });
}
initMap();
function initMap() {

    let well_id = '<?php echo $this->uri->segment('3');?>';
    $.ajax({
        url: '<?php echo base_url(); ?>Selfflow_c/get_site_location_for_dashboard',
        type: 'POST',
        data: {
            well_id: well_id,
        },
        success: function(res) {
            response = JSON.parse(res);
            console.log(response, 'map');

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
                        lat: item.lat,
                       
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
                        scaledSize: new google.maps.Size(40, 40)
                    };

                    var seconds = 200;

                    if (marker.offline_time) {
                        var lastDataTimeObj = new Date(marker.offline_time);
                        var currentDate = new Date();

                        var diffInMilliseconds = currentDate - lastDataTimeObj;
                        seconds = Math.floor(diffInMilliseconds / 1000);
                    }

                    let timeLimit = 300;
                    if (seconds <= timeLimit) {
                        markerIcon.url = '<?php echo base_url(); ?>assets/img/flowing_map.png';
                    } else if (marker.flag_status == 1) {
                        markerIcon.url = '<?php echo base_url(); ?>assets/img/tem_off.png';
                    } else{
                      markerIcon.url = '<?php echo base_url(); ?>assets/img/offline.png';

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
                     if (seconds <= timeLimit && marker.flag_status == 0) {
                        statusText = 'Flowing Well';
                    } else if (marker.flag_status == 1) {
                        statusText = 'Temporary off Well';
                    }else{
                       statusText = 'Offline Well';
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
