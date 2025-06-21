<style type="text/css">
	
	.table th {
    vertical-align: middle;
    border: none;
    border-bottom: 1px solid #ccc; 
/*    white-space: nowrap !important;*/
   word-break: break-all;
}
	.table td{
		vertical-align: middle;
		border:none;
		border-bottom: 1px solid #ccc; 
/*      white-space: nowrap !important;*/
      word-break: break-all;
	}
   .wrap {
   color: #000;
   font-size: 14px;
   line-height: 21px;
   max-width: 1840px;
   padding: 0 40px;
   margin: 0 auto;
   position: relative;
   }
   .arrow-down.one {
   position: absolute;
   bottom: 40px;
   transform: translateX(555%);
   border-left: 10px solid transparent;
   border-right: 10px solid transparent;
   border-top: 10px solid #27AE60;
   }
   .arrow-down.two {
   position: absolute;
   /*    bottom: 0px;*/
   bottom: 40px;
   transform: translateX(555%);
   border-left: 10px solid transparent;
   border-right: 10px solid transparent;
   border-top: 10px solid orange;
   }
   .btn_one{
   min-width: 150px;
   margin-bottom: 10px;
   color: #fff;
   display: inline-block;
   font-weight: 600;
   padding: 10px 20px;
   text-align: center;
   font-size: 14px;
   line-height: 1.4;
   transition: background .25s ease;
   border: none;
   white-space: normal;
   vertical-align: middle;
   overflow: visible;
   cursor: pointer;
   font-family: 'Poppins',sans-serif;
   text-decoration: none;
   background-color: #beac95;
   }
   .btn_one-blauw{background-color: #1C69D4; color: white;}
   .btn_one-btn_one-oranje {background-color: #ed9300; color: white;}  
   .timeline-wrap{position:relative; padding:0 50px;}
   .timeline {
   overflow-x: auto;
   -webkit-overflow-scrolling: touch;
   background-repeat: repeat-x;
   background-size: 3px 3px;
   background-position: center top 68%;
   background-image: linear-gradient(90deg, #5499c7, #5499c7);
   padding: 50px 0;
   display: flex;
   flex: 8 8 100%;
   flex-flow: row nowrap;
   transition: height .8s ease-out;
   position: relative; 
   }
   /*.timeline-item .bmw card{
   background-color:#B4D2E8;
   }*/
   .timeline-title, .timeline-content-title{font-weight:600;}
   .timeline-item{
   display: -webkit-box;
   display: -webkit-flex;
   display: -ms-flexbox;
   display:flex;
   justify-content: space-between;
   flex-flow:wrap;
   -webkit-transition: max-width .2s,-webkit-transform .4s ease-out;
   transition: max-width .2s,-webkit-transform .4s ease-out;
   transition: max-width .2s,transform .4s ease-out;
   transition: max-width .2s,transform .4s ease-out,-webkit-transform .4s ease-out;
   cursor: pointer;
   margin:0 50px; 
   height:auto;
   margin-top: -30px;
   }
   .mini:hover .p-timeline-block{background-color:#ed9300;}
   .bmw .p-timeline-block, .mini .p-timeline-block, .mini:hover .p-timeline-block, .bmw:hover .p-timeline-block {transition:background-color 1s ease;}
   .p-timeline-date, .p-timeline-carmodel, .p-timeline-block{width:100%;}
   .p-timeline-date{font-weight:600;font-size:15px;margin-top: 10px}
   .p-timeline-block.one {
   min-width:20px;
   min-height:20px;
   max-width:20px;
   max-height:20px;
   border-radius:50%;
   background:#27AE60;
   position:relative;
   top:-12px;
   left:112px;
   }
   .p-timeline-block.two {
   min-width:20px;
   min-height:20px;
   max-width:20px;
   max-height:20px;
   /*    border: solid 0px black;"*/
   border-radius:50%;
   background:orange;
   /*    box-shadow: 0 0 0 10px orange;*/
   position:relative;
   top:-12px;
   left:112px;`
   }
   .p-timeline-item{
   -webkit-box-align: center;
   -webkit-align-items: center;
   -ms-flex-align: center;
   align-items: center;
   display: -webkit-box;
   display: -webkit-flex;
   display: -ms-flexbox;
   display: flex;
   flex-wrap:wrap;
   min-width:250px;
   max-width:250px;
   position: relative;
   text-align:center;
   transition:color .3s ease-in-out;
   transition:transform .3s ease;
   }
   .p-timeline-content{
   width:98%;
   height:0;
   position:absolute;
   overflow:hidden;
   visibility:hidden;
   opacity: 0;
   transform:translateX(-1000px);
   -webkit-transition: all 1s ease-in-out;
   transition: all 1s ease-in-out;
   padding: 50px 20px 20px 20px;
   }
   .i-is-active.p-timeline-content{
   color: #000;
   height:auto;
   padding: 50px 20px 20px 20px;
   float:left;
   width:98%;
   text-align:left;
   position:relative;
   visibility: visible;
   opacity:1;
   transform:translateX(0px);
   -webkit-transition: all .5s ease-in-out;
   transition: all .5s ease-in-out;
   }
   .card-header{
   font-size: 16px;
   color:white;
   height:60px;
   }
   .card_height{
   height:170px;
   }
   @media (max-width: 768px) {
   #trip_chart {
   height: 180px !important;
   }
   #running_Chart {
   height: 180px !important;
   }
   }
   /* Default styles for the div */
   #header_image_part {
   display: block;
   }
   /* Media query to hide the div when screen size is small */
   @media screen and (max-width: 768px) {
   #header_image_part {
   display: none;
   }
   }
   .dot1
   {
   height: 25px;
   width: 25px;
   background-color: #FB4A4A;
   border-radius: 50%;
   display: inline-block;
   animation-name: example3;
   animation-duration: 1s;
   animation-iteration-count: infinite;
   }
   @keyframes example3 {
   from {background-color: red;}
   to {background-color: whitesmoke;}
   }
   .dot2
   {
   height: 25px;
   width: 25px;
   background-color: #06E763;
   border-radius: 50%;
   display: inline-block;
   animation-name: example2;
   animation-duration: 1s;
   animation-iteration-count: infinite;
   }
   @keyframes example2 {
   from {background-color: green;}
   to {background-color: whitesmoke;}
   }
   .dot3
   {
   height: 25px;
   width: 25px;
   background-color: yellow;
   border-radius: 50%;
   display: inline-block;
   animation-name: example;
   animation-duration: 1s;
   animation-iteration-count: infinite;
   }
   @keyframes example {
   from {background-color: yellow;}
   to {background-color: whitesmoke;}
   }
   .dotred
   {
   height: 20px;
   width: 20px;
   background-color: #FB4A4A;
   border-radius: 50%;
   display: inline-block;
   }
   .dotgreen
   {
   height: 20px;
   width: 20px;
   background-color: #06E763;
   border-radius: 50%;
   display: inline-block;
   }
   .border-right
   {
   border-right:1.5px dashed #161109;
   }
   @media (max-width: 768px) {
   .border-right {
   border-right: none;
   }
   }
   .canvas
   {
   -moz-user-select: none;
   -webkit-user-select: none;
   -ms-user-select: none;
   }
   .custome-name table th,.custome-name table td{
     
         white-space: normal !important;
      
   }
   .topCards{
      border-top-right-radius: 5px!important;
      border-top-left-radius: 5px!important;
   }

  /* .card-new
   {
    
    border: 1px solid #ededed;
    box-shadow:0 1px 1px rgba(0, 0, 0, 0.2); 
   }*/
</style>
<script src="https://unpkg.com/chart.js@2.8.0/dist/Chart.bundle.js"></script>
<script src="https://unpkg.com/chartjs-gauge@0.3.0/dist/chartjs-gauge.js"></script>
<script src="<?php echo base_url() ?>assets/local/assets/js/highcharts.js"></script>
<script src="<?php echo base_url() ?>assets/local/assets/js/highcharts-more.js"></script>
<script src="<?php echo base_url() ?>assets/local/assets/js/exporting.js"></script>
<script src="<?php echo base_url() ?>assets/local/assets/js/export-data.js"></script>
<script src="<?php echo base_url() ?>assets/local/assets/js/accessibility.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/paho-mqtt/1.0.1/mqttws31.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/local/wssclient.js"></script>
<!--APP-CONTENT OPEN-->
<!-- Page Wrapper -->
<div class="page-wrapper custome-name">
   <div class="content container-fluid" >
      <!-- Page Header -->
      <div class="page-header" style=" margin-bottom:0px; margin-top: -30px;">
         <div class="row align-items-center">
            <div class="col">
               <ul class="breadcrumb">
                  <li class="breadcrumb-item active"><h3 class="page-title">Single Well Dashboard</h3></li>
               </ul>
            </div>
            <div class="col-auto float-end ms-auto">
               <a href="<?php echo base_url('Dashboard_c'); ?>">
               <button type="button" class="btn btn-sm btn-success">Back</button>
               </a>

               
            </div>
         </div>
      </div>
      <!-- ================  Single Well Details code Starts ===================== -->
      <div class="row mt-2">
         <div class="col-md-3">
            <div class="bg-white rounded-3" style="height:100%;  border: 1px solid #ededed;box-shadow:0 1px 1px rgba(0, 0, 0, 0.2); ">
               <div class="card-header px-3 d-flex justify-content-between align-items-center topCards" style="height:50px;background-color:blueviolet;">
                  <b>Well Status</b>&nbsp;<img src="<?php echo base_url(); ?>assets/img/well.gif" width="30" style="border-radius: 50%;">
               </div>
               <div class="px-3" style="text-align: left;">
                 
                        <table class="table table-striped table-hover">
                           <input type="hidden" name="hdn_well_running" id="hdn_well_running" value="0">
                           <thead>
                              <tr>
                                 <th><b>Well Name </b></th>
                                 <td><?php echo $single_well_details[0]['well_name']; ?></td>
                              </tr>
                               <tr>
                                 <th><b>Well Type </b></th>
                                 <td><?php echo ($single_well_details[0]['well_type'] == 0) ? "Regular" : "Schedule"; ?></td>
                              </tr>

                              
                              <tr>
                                 <th><b>Well Status</b></th>
                                 <td>
                                    <div id="s_red" style="display: none;"><span class="dotred" ></span><br></div>
                                    <div id="s_green" style="display: none;"><span class="dotgreen" ></span><br></div>
                                 </td>
                              </tr>
                              <tr>
                                 <th style="border-bottom: none;"><b>Power Status</b></th>
                                 <td style="border-bottom: none;">
                                    <div id="p_red" style="display: none;"><span class="dotred" ></span><br></div>
                                    <div id="p_green" style="display: none;"><span class="dotgreen" ></span><br></div>
                                 </td>
                              </tr>
                           </thead>
                        </table>
                     </div>
                  </div>
               </div>
            
         <div class="col-md-3">
            <div class="bg-white rounded-3" style="height:100%;  border: 1px solid #ededed;box-shadow:0 1px 1px rgba(0, 0, 0, 0.2); ">
               <div class="card-header px-3 d-flex justify-content-between align-items-center topCards" style="height:50px;background-color:blueviolet;">
                  Current&nbsp;<img src="<?php echo base_url(); ?>assets/img/ampere.gif" width="30" style="border-radius: 50%;">
               </div>
               <div class="px-3" style="text-align: left;">
                  <table class="table table-striped table-hover">
                     <thead>
                        <tr>
                           <td><b>Current R</b></td>
                           <td><span  id="outputCurrent_R"></span> <span style="font-size: 12px;"> Amp</span> </td>
                        </tr>
                        <tr>
                           <td><b>Current Y</b></td>
                           <td><span  id="outputCurrent_Y"></span><span style="font-size: 12px;"> Amp</span> </td>
                        </tr>
                        <tr>
                           <td><b>Current B</b></td>
                           <td><span  id="outputCurrent_B"></span><span style="font-size: 12px;"> Amp</span> </td>
                        </tr>
                        <tr>
                           <td style="border-bottom: none;"><b>Average</b></td>
                           <td style="border-bottom: none;"><span  id="outputAverage_Current"></span><span style="font-size: 12px;"> Amp</span> </td>
                        </tr>
                     </thead>
                  </table>
               </div>
            </div>
         </div>
         <div class="col-md-3">
            <div class="bg-white rounded-3 " style="height:100%; border: 1px solid #ededed;box-shadow:0 1px 1px rgba(0, 0, 0, 0.2); ">
               <div class="card-header px-3 d-flex justify-content-between align-items-center topCards" style="height:50px;background-color:blueviolet;">
                  P2P Voltage&nbsp;<img src="<?php echo base_url(); ?>assets/img/volt.gif" width="30" style="border-radius: 50%;">
               </div>
               <div class="px-3" style="text-align: left; ">
                  <table class="table table-striped table-hover">
                     <thead>
                        <tr>
                           <td><b>Voltage RY</b></td>
                           <td><span  id="output_Voltage_P2PRY"></span><span style="font-size: 12px;"> Volt</span></td>
                        </tr>
                        <tr>
                           <td><b>Voltage YB</b></td>
                           <td><span  id="output_Voltage_P2PYB"></span><span style="font-size: 12px;"> Volt</span> </td>
                        </tr>
                        <tr>
                           <td><b>Voltage BR</b></td>
                           <td><span  id="output_Voltage_P2PBR"></span><span style="font-size: 12px;"> Volt</span> </td>
                        </tr>
                        <tr>
                           <td style="border-bottom: none;"><b>Average</b></td>
                           <td style="border-bottom: none;"><span  id="out_p2p_average_voltage"></span><span style="font-size: 12px;"> Volt</span> </td>
                        </tr>
                     </thead>
                  </table>
               </div>
            </div>
         </div>
         <!--  <tr>
            <th><b>Well Name </b></th>
             <td><?php echo $single_well_details[0]['well_name']; ?></td>
            </tr> -->
         <input type="hidden" name="hdn_well_id" id="hdn_well_id" value="<?php echo $single_well_details[0]['well_id']; ?>">
         <input type="hidden" name="hdn_well_name" id="hdn_well_name" value="<?php echo $single_well_details[0]['well_name']; ?>">
         <!-- <th><b>A/L Mode</b> </th>
            <td><input type="hidden" name="hdn_equipment_name" id="hdn_equipment_name" value="<?php echo $single_well_details[0]['equipment_name']; ?>"/><?php echo $single_well_details[0]['equipment_name']; ?></td> -->
         <!-- <tr>
            <th><b>Motor Capacity (KW)</b></th>
            <td><?php echo $single_well_details[0]['motor_capacity']; ?></td>
            <th><b>Surface Unit Make & Model</b></th>
            <td><?php echo $single_well_details[0]['surface_unit_make']; ?></td>
            </tr> -->
         <!-- <tr>
            <th><b>Panel Make</b> </th>
            <td><?php echo $single_well_details[0]['vfd_make']; ?></td>
            <th><b>Panel Model</b></th>
            <td><?php echo $single_well_details[0]['vfd_model']; ?></td>
            </tr> -->
         <!-- <tr>
            <th><b>Panel Capacity (HP) </b></th>
            <td><?php echo $single_well_details[0]['vfd_capacity']; ?></td>
             <th><b>Power Source</b></th>
            <td><?php echo $single_well_details[0]['power_source']; ?></td>
            </tr> -->
         <!-- <tr>
            <th><b>DG/GG Make</b></th>
            <td><?php echo $single_well_details[0]['dg_gg_make']; ?></td>
            <th><b>DG/GG Rating</b></th>
            <td><?php echo $single_well_details[0]['dg_gg_rating']; ?></td>
            </tr> -->
         <!-- ============== threshold hidden fields starts ============ -->
         <input type="hidden" name="input_hdn_last_alert" id="input_hdn_last_alert" readonly>
         <input type="hidden" name="input_hdn_last_datetime" id="input_hdn_last_datetime" readonly>
         <input type="hidden" name="input_l2n_ut" id="input_l2n_ut" readonly>
         <input type="hidden" name="input_l2n_lt" id="input_l2n_lt" readonly>
         <input type="hidden" name="output_l2n_ut" id="output_l2n_ut" readonly>
         <input type="hidden" name="output_l2n_lt" id="output_l2n_lt" readonly>
         <input type="hidden" name="input_p2p" id="input_p2p" readonly>
         <input type="hidden" name="input_p2p_ut" id="input_p2p_ut" readonly>
         <input type="hidden" name="input_p2p_lt" id="input_p2p_lt" readonly>
         <input type="hidden" name="output_p2p" id="output_p2p" readonly>
         <input type="hidden" name="output_p2p_ut" id="output_p2p_ut" readonly>
         <input type="hidden" name="output_p2p_lt" id="output_p2p_lt" readonly>
         <input type="hidden" name="threshold_inp_current" id="threshold_inp_current" readonly>
         <input type="hidden" name="inp_current_ut" id="inp_current_ut" readonly>
         <input type="hidden" name="inp_current_lt" id="inp_current_lt" readonly>
         <input type="hidden" name="inp_freq" id="threshold_out_current" readonly>
         <input type="hidden" name="out_current_ut" id="out_current_ut" readonly>
         <input type="hidden" name="out_current_lt" id="out_current_lt" readonly>
         <input type="hidden" name="inp_freq" id="inp_freq" readonly>
         <input type="hidden" name="inp_freq_ut" id="inp_freq_ut" readonly>
         <input type="hidden" name="inp_freq_lt" id="inp_freq_lt" readonly>
         <input type="hidden" name="out_freq" id="out_freq" readonly>
         <input type="hidden" name="out_freq_ut" id="out_freq_ut" readonly>
         <input type="hidden" name="out_freq_lt" id="out_freq_lt" readonly>
         <!-- ============== threshold hidden fields ends ============ -->
         <!-- ================  Single Well Details code Ends ===================== -->
         <div class="col-md-3">
            <div class="bg-white rounded-3" style="height:100%;border: 1px solid #ededed;box-shadow:0 1px 1px rgba(0, 0, 0, 0.2); ">
               <div id="top-inline-card" class="card-header px-3 d-flex justify-content-between align-items-center topCards" style="height:50px;background-color:blueviolet;">
                  <b>RTMS Status</b>&nbsp;<img src="<?php echo base_url(); ?>assets/img/device.gif" width="30" style="border-radius: 50%;">
               </div>
               <div class="px-3">
                  <div class="text-center">
                     <div class="row">
                        <div class="col-12">
                           <span class="dot1 my-1" style="animation:none;display:none;" id="dcu_red" ></span><br>
                           <h5><span id="dcu_offline" style="display:none;">Offline</span></h5>
                           <span class="dot2 my-1" style="animation:none;display:none;" id="dcu_green"></span><br>
                           <h5><span id="dcu_online" style="display:none;">Online</span></h5>
                        </div>
                        <div class="col-12">
                           <h4><b>Last Date-Time</b></h4>
                           <h4><span id="log_date_time"></span></h4>
                           <span style="font-size: 12px;"></span> 
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="row mt-4">
         <div class="col-md-3">
            <div class="card" style="height:280px;border-radius: 10px;">
               <div class="card-header  d-flex justify-content-between align-items-center" style="height:50px;background-color:#31C4C4;">
                  Machine Fault&nbsp;<img src="<?php echo base_url(); ?>assets/img/hand.gif" width="30" style="border-radius: 50%;">
               </div>
               <div class="card-body" style="text-align: left;">
                  <div class="row">
                     <table class="table table-striped table-hover">
                        <thead>
                           <tr>
                              <th><b style="margin-left: 6%;">OLR</b></th>
                              <td>
                                 <span  id="olr_fault" style="margin-left: 30%;"></span> <span style="font-size: 12px;"></span> 
                              </td>
                           </tr>
                           <tr>
                              <th><b style="margin-left: 6%;">ELR</b></th>
                              <td>
                                 <span  id="elr_fault" style="margin-left: 30%;"></span> <span style="font-size: 12px;"></span> 
                              </td>
                           </tr>
                           <tr>
                              <th style="border-bottom: none;"><b style="margin-left: 6%;">SPP</b></th>
                              <td style="border-bottom: none;">
                                 <span  id="spp_fault" style="margin-left: 30%;"></span> <span style="font-size: 12px;"></span>
                              </td>
                           </tr>
                        </thead>
                     </table>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-3">
            <div class="card" style="height:140px;border-radius: 10px;">
               <div class="card-header d-flex justify-content-between align-items-center" style="height:50px;background-color:#31C4C4;">
                  Well Running&nbsp;<img src="<?php echo base_url(); ?>assets/img/well.gif" width="30" style="border-radius: 50%;">
               </div>
               <div class="card-body text-center" style="padding: 13px;">
                  <div class="row">
                     <div class="col-6 border-right">
                        <h6 class="ad-title" style="font-size: 12px;">Today</h6>
                        <h5><span  id="output_load_hrs"></span> <span style="font-size: 10px;">Hrs</span>
                           <span id="output_load_min"></span> <span style="font-size: 10px;">Min</span>
                        </h5>
                     </div>
                     <div class="col-6 ">
                        <h6 class="ad-title" style="font-size: 12px;">Total</h6>
                        <h5><span  id="total_load_hrs"></span> <span style="font-size: 10px;">Hrs</span>
                           <span id="total_load_min"></span> <span style="font-size: 10px;">Min</span>
                        </h5>
                     </div>
                  </div>
                  
               </div>
            </div>

            <div class="card" style="height: 110px;border-radius: 10px;">
               <div class="card-header d-flex justify-content-between align-items-center" style="height:50px;background-color:#31C4C4;">
                  Power Factor&nbsp;<img src="<?php echo base_url(); ?>assets/img/socket.gif" width="30" style="border-radius: 50%;">
               </div>
               <div class="card-body text-center">
                  <h5><span  id="power_factor_output"></span><span style="font-size: 12px;"></span></h5>
               </div>
            </div>
           
         </div>
            <div class="col-md-3">
            <div class="card" style="height:140px;border-radius: 10px;">
               <div class="card-header d-flex justify-content-between align-items-center" style="height:50px;font-size:15px;background-color:#31C4C4;">
                  Energy Consumption&nbsp;<img src="<?php echo base_url(); ?>assets/img/oil-pump.gif" width="30" style="border-radius: 50%;">
               </div>
               <div class="card-body text-center" style="padding: 13px;">
                  <div class="row">
                     <div class="col-6 border-right">
                        <h6 class="ad-title" style="font-size: 12px;">Today</h6>
                        <h5><span  id="todays_energy"></span> <span style="font-size: 10px;">Kwh</span> </h5>
                     </div>
                     <div class="col-6 ">
                        <h6 class="ad-title" style="font-size: 12px;">Total</h6>
                        <h5><span  id="totals_energy"></span> <span style="font-size: 10px;">Kwh</span> </h5>
                     </div>
                  </div>
               </div>
            </div>
             <div class="card" style="height:110px;border-radius: 10px;">
               <div class="card-header d-flex justify-content-between align-items-center" style="height:50px;background-color:#31C4C4;">
                  Active Power&nbsp;<img src="<?php echo base_url(); ?>assets/img/wind-power.gif" width="30" style="border-radius: 50%;">
               </div>
               <div class="card-body text-center" style="margin-top">
                  <h5><span  id="active_power_output"></span><span style="font-size: 12px;"> kw</span> </h5>
               </div>
            </div>

            

         </div>
         <div class="col-md-3">
            <div class="card" style="height:280px;">
               <div class="card-header d-flex justify-content-between align-items-center" style="height:50px;background-color:#31C4C4;">
                  <b>RTMS Details</b>&nbsp;<img src="<?php echo base_url(); ?>assets/img/device.gif" width="30" style="border-radius: 50%;">
               </div>
               <div class="card-body" style="overflow-y: scroll;">
                  <div style="text-align: left;">
                     <div class="col-12">
                        <div  style="display:none;" id="normal_device_field">
                           <table class="table table-striped table-hover">
                              <thead>
                                 <tr>
                                    <th><b>Maker's Name</b></th>
                                    <td><?php echo $single_well_details[0]['manufacturer_name']; ?></td>
                                 </tr>
                                 <tr>
                                    <th><b>Device Name </b></th>
                                    <td><?php echo $single_well_details[0]['device_name']; ?></td>
                                 </tr>
                                 <tr>
                                    <th><b>IMEI No </b></th>
                                    <td><?php echo $single_well_details[0]['imei_no']; ?></td>
                                    <input type="hidden" name="hdn_imei_no" id="hdn_imei_no" value="<?php echo $single_well_details[0]['imei_no']; ?>">
                                 </tr>
                                 <tr>
                                    <th style="border-bottom: none;"><b>Model Name </b></th>
                                    <td style="border-bottom: none;"><?php echo $single_well_details[0]['model_name']; ?></td>
                                 </tr>
                              </thead>
                           </table>
                        </div>
                        <div  style="display:none;" id="shifted_device_field">
                           <table class="table table-striped table-hover">
                              <thead>
                                 <tr>
                                    <th><b style="color:red">Device Not Available</b></th>
                                 </tr>
                                 <tr>
                                    <th><b>Device Shifted Date Time</b></th>
                                 </tr>
                                 <tr >
                                    <td id="shifted_date_time" style="border-bottom: none;"></td>
                                 </tr>
                              </thead>
                           </table>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- ================================================================================================-->
      <div class="row">
         <div class="col-md-3">
            <div class="card" style="height:140px;border-radius: 10px;">
               <div class="card-header d-flex justify-content-between align-items-center" style="height:50px;background-color:#A038A0;">
                  Frequency&nbsp;<img src="<?php echo base_url(); ?>assets/img/responsible-consumption.gif" width="30" style="border-radius: 50%;">
               </div>
               <div class="card-body text-center">
                  <h5><span  id="frequency_output"></span><span style="font-size: 12px;"> Hz</span> </h5>
               </div>
            </div>
         </div>
          <div class="col-md-6">
            <div class="card" style="height:140px;border-radius: 10px;">
               <div class="card-header d-flex justify-content-between align-items-center" style="height:50px;background-color:#A038A0;">
                  Current Month Prediction &nbsp;<img src="<?php echo base_url(); ?>assets/img/recycle.gif" width="30" style="border-radius: 50%;">
               </div>
               <div class="card-body text-center">
                  <div class="row">
                     <div class="col-6 border-right">
                        <h6 class="ad-title" style="font-size: 12px;">Energy Consumption</h6>
                        <h5><span  id="predicted_energy"></span> <span style="font-size: 12px;"> Kwh</span> </h5>
                     </div>
                     <div class="col-6 ">
                        <h6 class="ad-title" style="font-size: 12px;">Running Hours</h6>
                        <h5><span  id="predicted_running"></span><span style="font-size: 12px;"> </span> </h5>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         
         <div class="col-md-3">
           
     
         <div class="card" style="height:140px;border-radius: 10px;">
               <div class="card-header d-flex justify-content-between align-items-center" style="height:50px;background-color:#A038A0;">
                  Voltage&nbsp;<img src="<?php echo base_url(); ?>assets/img/volt.gif" width="30" style="border-radius: 50%;">
               </div>
               <div class="card-body text-center">
                  <div class="row">
                  <div class="col-6 border-right">
                     <h6 class="ad-title" style="font-size: 12px;">Battery</h6>
                  <h4><span  id="battery_voltage_count"></span><span style="font-size: 12px;">&nbsp; Volt</span> </h4>
               </div>
               <div class="col-6 ">
                  <h6 class="ad-title" style="font-size: 12px;">SMPS</h6>
                <h4><span  id="smps_voltage_field"></span><span style="font-size: 12px;">&nbsp; Volt</span> </h4>
             </div>
            </div>
       </div>
      </div>
   </div>
</div>
     
      <div class="row">
         <div class="col-md-6">
            <div class="card" style="height:300px;">
               <div class="card-header d-flex justify-content-between align-items-center" style="height:50px;position: sticky;top:0px;z-index:1;background-color:#16A085;">
                  <div>
                     <img src="<?php echo base_url(); ?>assets/img/alert.gif" width="30" style="border-radius: 50%;">&nbsp; Alert Log&nbsp; &nbsp;
                     <badge class="badge badge-sm rounded-pill bg-blue" id="alert_count"></badge>
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
                     <tbody class="text-center" id="alert_table" >
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
         <div class="col-md-3" >
            <div class="card" style="height:300px;border-radius: 12px;">
            <div class="card-header d-flex justify-content-between align-items-center" style="background-color:#16A085;">
                <div>
                
                    <h5 class="text-white " style="font-size: 18px;">Well GIS Map</h5>
                </div>
                <div class="d-flex align-items-center">
                    <img src="<?php echo base_url() ?>assets/img/map.gif" width="40" style="border-radius: 25%;">
                </div>
            </div>
            <div class="card-body" style="overflow-y: scroll;">
               <div  id="mymap" style="width:100%;height: 300px;"></div>
            </div>
            
        </div>
     </div>
         <div class="col-md-3" >
            <div class="card" style="height:300px;border-radius: 12px;">
               <div class="card-header d-flex justify-content-between align-items-center" style="height: 50px;background-color:#16A085;">
                  Well Report Log&nbsp;<img src="<?php echo base_url(); ?>assets/img/oil-pump.gif" width="30" style="border-radius: 50%;">
               </div>
               <div class="card-body">
                  <a href="<?php echo base_url('Dashboard_c/get_running_well_page/').$single_well_details[0]['well_id']; ?>">
                     <div><button class="btn btn-sm mt-2" style="width:100%;background-color: #3498DB;color:white;">Well Running Log</button></div>
                  </a>
                  <a href="<?php echo base_url('Dashboard_c/get_mis_and_graph_data/').$single_well_details[0]['well_id']; ?>">
                     <div><button class="btn btn-sm mt-2" style="width:100%;background-color:#1ABC9C;color: white;">Historical Data Log</button></div>
                  </a>
                  <a href="<?php echo base_url().'Alert_report_c/dashboard_well_alert_page/'.$single_well_details[0]['well_id'];?>">
                     <div><button class="btn btn-sm mt-2" style="width:100%;background-color:#E74C3C;color: white;">Alert Log</button></div>
                  </a>
                  
                  <button class="btn btn-sm mt-2" style="width:100%; color: white; background-color:#31C4C4" data-bs-toggle="modal" data-bs-target="#timelinecard">Timeline</button>

                   <input type="hidden" name="hdn_well_type" id="hdn_well_type" value="<?php echo $single_well_details[0]['well_type']; ?>">
              
                    <div id="schdule_button">
                   <button class="btn btn-sm mt-2" style="width:100%; color: white; background-color:#3498DB" data-bs-toggle="modal" data-bs-target="#schdulecard">Schedule Time</button>
                    </div>
                   
                  
                  
               </div>
            </div>
         </div>
      </div>
      <!-- Timeline Start-->
   
       <div class="modal fade" id="timelinecard" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header" style="background-color: #31C4C4;">
                <h4 style="color:white;">Implementation Cycle of Well &nbsp;<span id="well_name_details" style="color:white"></span>&nbsp;</h4>
                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" style="background-color: white;"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <div class="row">
                        <div class="wrap">
                            <div class="timeline-wrap">
                                <ul class="timeline" id="well_data_details">
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


 <div class="modal fade" id="schdulecard" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header" style="background-color: #31C4C4;">
                <h4 style="color:white;">Schedule Time Of Well &nbsp;<span id="well_name_data" style="color:white"></span>&nbsp;</h4>
                <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" style="background-color: white;"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <div class="row">
                        <div class="table-responsive">
                           <table class="table table-striped table-bordered">
                              <thead class="text-center">
                                 
                                      <tr>
                                    <th style="width:20%;">Sl No.</th>
                                    <th>Start Time</th>
                                    <th>Stop Time</th>
                                   
                                    
                                    
                                 </tr>
                              </thead>
                              <tbody class="text-center" id="table_schdule">
                                 
                           </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
      <!-- =============== card for data selection starts ======================= -->
      <div class="row mt-2">
         <div class="col-md-12">
            <div class="card">
               <div class="card-header d-flex justify-content-between align-items-center" style="background-color:#2ECC71">
                  <div id="header_image_part">
                     <img src="<?php echo base_url(); ?>assets/img/line-chart.gif" width="50" style="border-radius: 50%;" id="icon_image">&nbsp;
                     <span id="selected_field"></span>
                  </div>
                  <div>
                     <div class="d-flex justify-content-evenly" style="margin-top:-4%">
                        <div class="form-group mt-3">
                           <select name="show_data" id="show_data" class="form-control select2" onchange="GetGraph();">
                              <option value="5"> Current</option>
                              <option value="3"> P2P Voltage</option>
                              <option value="1"> L2N Voltage</option>
                           </select>
                        </div>
                        <!-- ============== -->
                        <div class="form-group mt-3 mx-2">
                           <select name="hours" id="hours" class="form-control select2" onchange="GetGraph();">
                              <option value="1">Last 1 Hour</option>
                              <option value="2">Last 2 Hour</option>
                              <option value="6">Last 6 Hour</option>
                              <option value="12">Last 12 Hour</option>
                              <option value="24">Last 24 Hour</option>
                           </select>
                        </div>
                        <!-- ============== -->
                     </div>
                  </div>
               </div>
            </div>
            <div id="content">
               <div class="card-body text-center">
               </div>
            </div>
         </div>
      </div>
      <!-- =================== guage chart for Neutral  Voltage starts =============== -->
      <div class="row mt-2" id="NVO_chart" style="display:none;">
         <div class="col-md-12">
            <div class="card">
               <div class="card-body text-center">
                  <div class="row text-center">
                     <div class="col-md-4 border-right">
                        <div class="icontext">
                           <div id="container" ></div>
                           <h5 class="ad-title"><span id="out_l2n_r" style="font-size: 15px;"></span>&nbsp;(V)</h5>
                           <h5 class="ad-title" style="font-size: 12px;">Neutral V-RN</h5>
                        </div>
                     </div>
                     <div class="col-md-4 border-right">
                        <div class="icontext">
                           <div id="container1" ></div>
                           <h5 class="ad-title"><span id="out_l2n_y" style="font-size: 15px;"></span>&nbsp;(V)</h5>
                           <h5 class="ad-title" style="font-size: 12px;">Neutral V-YN</h5>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="icontext">
                           <div id="container2" ></div>
                           <h5 class="ad-title"><span id="out_l2n_b" style="font-size: 15px;"></span>&nbsp;(V)</h5>
                           <h5 class="ad-title" style="font-size: 12px;">Neutral V-BN</h5>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- =================== guage chart for OutPut Line Voltage starts =============== -->
      <div class="row mt-2" id="LVO_chart" style="display:none;">
         <div class="col-md-12">
            <div class="card">
               <div class="card-body text-center">
                  <div class="row">
                     <div class="col-md-4 border-right">
                        <div class="icontext">
                           <div id="container3"></div>
                           <h5 class="ad-title"><span id="out_p2p_r" style="font-size: 15px;"></span>&nbsp;(V)</h5>
                           <h5 class="ad-title" style="font-size: 12px;">Line V-RY</h5>
                        </div>
                     </div>
                     <div class="col-md-4 border-right">
                        <div class="icontext">
                           <div id="container4" ></div>
                           <h5 class="ad-title"><span id="out_p2p_y" style="font-size: 15px;"></span>&nbsp;(V)</h5>
                           <h5 class="ad-title" style="font-size: 12px;">Line V-YB</h5>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="icontext">
                           <div id="container5" ></div>
                           <h5 class="ad-title"><span id="out_p2p_b" style="font-size: 15px;"></span>&nbsp;(V)</h5>
                           <h5 class="ad-title" style="font-size: 12px;">Line V-BR</h5>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- =================== guage chart for Output Current starts =============== -->
      <div class="row mt-2" id="OC_chart" style="display:none;">
         <div class="col-md-12">
            <div class="card">
               <div class="card-body text-center">
                  <div class="row">
                     <div class="col-md-4 border-right">
                        <div class="icontext">
                           <div id="container6"></div>
                           <h5 class="ad-title"><span id="output_current_r" style="font-size: 15px;"></span>&nbsp;(A)</h5>
                           <h5 class="ad-title" style="font-size: 12px;"> Current-R</h5>
                        </div>
                     </div>
                     <div class="col-md-4 border-right">
                        <div class="icontext">
                           <div id="container7" ></div>
                           <h5 class="ad-title"><span id="output_current_y" style="font-size: 15px;"></span>&nbsp;(A)</h5>
                           <h5 class="ad-title" style="font-size: 12px;"> Current-Y</h5>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="icontext">
                           <div id="container8" ></div>
                           <h5 class="ad-title"><span id="output_current_b" style="font-size: 15px;"></span>&nbsp;(A)</h5>
                           <h5 class="ad-title" style="font-size: 12px;"> Current-B</h5>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- ============= line chart for all data starts ==================== -->
      <div class="row mt-2">
         <div class="col-md-12" id="NV_graph">
            <div class="card">
               <div class="card-body">
                  <div id="neutral_voltage" style="height: 600px; width: 100%;"></div>
               </div>
            </div>
         </div>
      </div>
      <!-- End Row -->
   </div>
</div>
<div class="modal fade"  id="on_well_list" data-bs-backdrop="static">
   <div class="modal-dialog modal-lg" role="document" >
      <div class="modal-content modal-content-demo">
         <div class="modal-header">
            <h4 class=""><b>Well Status</b></h4>
            <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" ><span aria-hidden="true">&times;</span></button>
         </div>
         <div class="modal-body">
            <div class="container" id="flash_data">
            </div>
         </div>
      </div>
   </div>
</div>

<script type="text/javascript">
   
  button_schedule();
   function button_schedule()
   {
      var well_type = $('#hdn_well_type').val();
      if(well_type == 1)
      {
         $('#schdule_button').show();
               
      }else{
          $('#schdule_button').hide();
      }
               
        
   }
</script>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
<!-- ============= line chart for all data ends ==================== -->
<script type="text/javascript">
   $(document).ready(function(){
   GetDashboardData(1);
   get_threshold_data();
   GetGraph();
   setupWebSocket();
   //MQTTconnect();
      
       var plotBand1=[{
           from: 0,
           to: 200,
           color: '#F4D03F', // green
           thickness: 20
       }, {
           from: 200,
           to: 400,
           color: '#1ABC9C', // yellow
           thickness: 20
       }, {
           from: 400,
           to: 500,
           color: '#E74C3C', // red
           thickness: 20
       }];
       var plotBand2=[{
           from: 0,
           to: 25,
           color: '#F4D03F', // green
           thickness: 20
       }, {
           from: 25,
           to: 50,
           color: '#1ABC9C', // yellow
           thickness: 20
       }, {
           from: 50,
           to: 75,
           color: '#E74C3C', // red
           thickness: 20
       }
   , {
           from: 75,
           to: 100,
           color: '#E74C3C', // red
           thickness: 20
       }
   ];
      
      
       loadGuage(document.getElementById('container'),0,'V','Voltage',500,plotBand1);
       loadGuage(document.getElementById('container1'),0,'V','Voltage',500,plotBand1);
       loadGuage(document.getElementById('container2'),0,'V','Voltage',500,plotBand1);
   
       loadGuage(document.getElementById('container3'),0,'V','Voltage',500,plotBand1);
       loadGuage(document.getElementById('container4'),0,'V','Voltage',500,plotBand1);
       loadGuage(document.getElementById('container5'),0,'V','Voltage',500,plotBand1);
   
       loadGuage(document.getElementById('container6'),0,'A','Ampere',100,plotBand2);
       loadGuage(document.getElementById('container7'),0,'A','Ampere',100,plotBand2);
       loadGuage(document.getElementById('container8'),0,'A','Ampere',100,plotBand2);
   
   // setInterval(function() {GetDashboardData()}, 15000)
   });
   
   // =================================================================================
       
   function GetDashboardData(myval)
   {
   var well_id = $('#hdn_well_id').val();
    $.ajax({
        url: '<?php echo base_url(); ?>Dashboard_c/get_all_dashboard_data_card_ajax',
        type: 'POST',
        data: {well_id:well_id},
        success:function(res)
        {
            var res=JSON.parse(res);
            //Bind Offline Data
            //console.log('dashboard data=',res);
             var last_output_vrn= parseFloat(res.data.single_welldevice_data[0].output_Voltage_L2N_R);
             var last_output_vyn= parseFloat(res.data.single_welldevice_data[0].output_Voltage_L2N_Y);
             var last_output_vbn= parseFloat(res.data.single_welldevice_data[0].output_Voltage_L2N_B);
             var last_output_vry= parseFloat(res.data.single_welldevice_data[0].output_Voltage_P2P_RY);
             var last_output_vyb= parseFloat(res.data.single_welldevice_data[0].output_Voltage_P2P_YB);
             var last_output_vbr= parseFloat(res.data.single_welldevice_data[0].output_Voltage_P2P_BR);
             var last_Ir_o= parseFloat(res.data.single_welldevice_data[0].output_Current_R);
             var last_Iy_o= parseFloat(res.data.single_welldevice_data[0].output_Current_Y);
             var last_Ib_o= parseFloat(res.data.single_welldevice_data[0].output_Current_B);
            // =============================================================
             updateGuage(last_output_vrn,0);
             updateGuage(last_output_vyn,1);
             updateGuage(last_output_vbn,2);
             updateGuage(last_output_vry,3);
             updateGuage(last_output_vyb,4);
             updateGuage(last_output_vbr,5);
             updateGuage(last_Ir_o,6);
             updateGuage(last_Iy_o,7);
             updateGuage(last_Ib_o,8);
             // ========== Card value  starts ================================
             var device_shift_status = res.data.single_welldevice_data[0].device_shifted;
             // alert(device_shift_status);
             if(device_shift_status == 0)
             {
             	$('#normal_device_field').show();
             	$('#shifted_device_field').hide();
             }else if(device_shift_status == 1)
             {
             	$('#normal_device_field').hide();
             	$('#shifted_device_field').show();
             	$('#shifted_date_time').text(moment(res.data.single_welldevice_data[0].date_of_shifted).format('DD-MM-YYYY hh:mm:ss a'))
             }
             var frequency_output = res.data.single_welldevice_data[0].output_System_Frequency;
             if(frequency_output == null || frequency_output == '' )
             {
             	$('#frequency_output').text(0);
             }else{
             	$('#frequency_output').text(frequency_output);
             }
                  var ECOTD = res.data.today_running_device[0].total_energy;
                  if (ECOTD == null || ECOTD == '')
                  {
                  	$('#active_energy_output').text(0);
                  }else{
                  	$('#active_energy_output').text(res.data.today_running_device[0].today_energy);
                  }
                  var active_power_output = res.data.single_welldevice_data[0].output_System_Running_KW;
                  if(active_power_output == null || active_power_output == '')
                  {
                  	$('#active_power_output').text(0);
                  }else{
                  	$('#active_power_output').text(active_power_output);
                  }
                  var battery_voltage_count = res.data.single_welldevice_data[0].battery_Voltage;
                  if(battery_voltage_count == null || battery_voltage_count == '')
                  {
                  	$('#battery_voltage_count').text(0);
                  }else{
                  	$('#battery_voltage_count').text(battery_voltage_count);
                  }
                  $('#device_status').val(res.data.single_welldevice_data[0].smps_Voltage);
                  var smps_voltage_field = res.data.single_welldevice_data[0].smps_Voltage;
                  if(smps_voltage_field == null || smps_voltage_field == '')
                  {
                  	$('#smps_voltage_field').text(0);
                  }else{
                  	$('#smps_voltage_field').text(smps_voltage_field);
                  }
                //   $('#power_factor_input').text(res.data.single_welldevice_data[0].input_System_PowerFactor1)
                  var  power_factor_output = res.data.single_welldevice_data[0].output_System_PowerFactor1;
                  if(power_factor_output == null || power_factor_output == '')
                  {
                  	$('#power_factor_output').text(0);
                  }else{
                  	$('#power_factor_output').text(power_factor_output);
                  }
                  var todayEnergyValue = res.data.today_running_device[0].today_energy;
   		if (todayEnergyValue !== null && todayEnergyValue !== undefined) {
   		    $('#todays_energy').text(todayEnergyValue);
   		} else {
   		    // Set a default value if the data is null or undefined
   		    $('#todays_energy').text("0");
   		}
   		var totalEnergyValue = res.data.total_running_device[0].total_energy;
   		if (totalEnergyValue !== null && totalEnergyValue !== undefined) {
   		    $('#totals_energy').text(totalEnergyValue);
   		} else {
   		   
   		    $('#totals_energy').text("0");
   		}
   	  var load_hr=(res.data.today_running_device[0].today_Hour);
   	  var load_min=(res.data.today_running_device[0].today_Minutes);
   	  if (load_hr == null || load_hr == '')
   	  {
   	  	$('#output_load_hrs').text(0);
   	  }else{
   	  	$('#output_load_hrs').text(parseFloat(load_hr).toFixed(0));
   	  }
   	  if (load_min == null || load_min == '')
   	  {
   	  	$('#output_load_min').text(0);
   	  }else{
   	  	$('#output_load_min').text(parseFloat(load_min).toFixed(0));
   	  }
   	  var total_load_hr=(res.data.total_running_device[0].total_Hour);
   	  var total_load_min=(res.data.total_running_device[0].total_Minutes);
   	  if (total_load_hr == null || total_load_hr == '')
   	  {
   	  	$('#total_load_hrs').text(0);
   	  }else{
   	  	$('#total_load_hrs').text(parseFloat(total_load_hr).toFixed(0));
   	  }
   	  if (total_load_min == null || total_load_min == '')
   	  {
   	  	$('#total_load_min').text(0);
   	  }else{
   	  	$('#total_load_min').text(parseFloat(total_load_min).toFixed(0));
   	  }
                  $('#out_l2n_voltage').text(res.data.single_welldevice_data[0].output_Average_Voltage_L2N);
                   var output_Voltage_P2PRY = res.data.single_welldevice_data[0].output_Voltage_P2P_RY;
                   if(output_Voltage_P2PRY == null || output_Voltage_P2PRY == '')
                   {
                   	 $('#output_Voltage_P2PRY').text(0);
                   }else{
                   	$('#output_Voltage_P2PRY').text(output_Voltage_P2PRY);
                   }
                   var output_Voltage_P2PYB = res.data.single_welldevice_data[0].output_Voltage_P2P_YB;
                   if(output_Voltage_P2PYB == null || output_Voltage_P2PYB == '')
                   {
                   	$('#output_Voltage_P2PYB').text(0);
                   }else{
                   	$('#output_Voltage_P2PYB').text(output_Voltage_P2PYB);
                   }
                   var output_Voltage_P2PBR = res.data.single_welldevice_data[0].output_Voltage_P2P_BR;
                   if(output_Voltage_P2PBR == null || output_Voltage_P2PBR == '')
                   {
                   	$('#output_Voltage_P2PBR').text(0);
                   }else{
                   	$('#output_Voltage_P2PBR').text(output_Voltage_P2PBR);
                   }
                   var out_p2p_average_voltage = res.data.single_welldevice_data[0].output_Average_Voltage_P2P;
                   if(out_p2p_average_voltage == null || out_p2p_average_voltage == '')
                   {
                   	$('#out_p2p_average_voltage').text(0);
                   }else{
                   	$('#out_p2p_average_voltage').text(out_p2p_average_voltage);
                   }
                  var outputCurrent_R = res.data.single_welldevice_data[0].output_Current_R;
                   if(outputCurrent_R == null || outputCurrent_R == '')
                   {
                   	$('#outputCurrent_R').text(0);
                   }else{
                   	$('#outputCurrent_R').text(outputCurrent_R);
                   }
                   var outputCurrent_Y = res.data.single_welldevice_data[0].output_Current_Y;
                   if(outputCurrent_Y == null || outputCurrent_Y == '')
                   {
                   	$('#outputCurrent_Y').text(0);
                   }else{
                   	$('#outputCurrent_Y').text(outputCurrent_Y);
                   }
                
                  var outputCurrent_B = res.data.single_welldevice_data[0].output_Current_B;
                   if(outputCurrent_B == null || outputCurrent_B == '')
                   {
                   	$('#outputCurrent_B').text(0);
                   }else{
                   	$('#outputCurrent_B').text(outputCurrent_B);
                   }
                  var outputAverage_Current = res.data.single_welldevice_data[0].output_Average_Current;
                   if(outputAverage_Current == null || outputAverage_Current == '')
                   {
                   	$('#outputAverage_Current').text(0);
                   }else{
                   	$('#outputAverage_Current').text(outputAverage_Current);
                   }   
             var predictedEnergyValue = res.data.single_welldevice_data[0].predicted_energy_consumption;
   			if (predictedEnergyValue !== null && predictedEnergyValue !== undefined) {
   			    $('#predicted_energy').text(predictedEnergyValue);
   			} else {
   			   
   			    $('#predicted_energy').text("0");
   			}
                      var runningHours = res.data.single_welldevice_data[0].predicated_running_hours;
                      var hours = Math.floor(runningHours);
                     var minutes = Math.round((runningHours - hours) * 60);
                         $('#predicted_running').text(hours + ' Hrs ' + minutes + ' Min');
   
           var olr_status = res.data.single_welldevice_data[0].olr_status;
   		if (olr_status == 1)
   		{
   			$('#olr_fault').text('Healthy');
   			$('#olr_fault').css("color","green");
   		}else {
   			$('#olr_fault').text('Faulty');
   			$('#olr_fault').css("color","red");
   		}
   
   		var elr_status = res.data.single_welldevice_data[0].elr_status;
   		if (elr_status == 1)
   		{
   			$('#elr_fault').text('Healthy');
   			$('#elr_fault').css("color","green");
   		}else {
   			$('#elr_fault').text('Faulty');
   			$('#elr_fault').css("color","red");
   		}
   
   		var spp_fault = res.data.single_welldevice_data[0].spp_status;
   		if (spp_fault == 1)
   		{
   			$('#spp_fault').text('Healthy');
   			$('#spp_fault').css("color","green");
   		}else {
   			$('#spp_fault').text('Faulty');
   			$('#spp_fault').css("color","red");
   		}
                      var log_datetime = (res.data.single_welldevice_data[0].last_log_datetime);
                  // alert(log_datetime);
   
                  if(log_datetime != null)
                  {
                  	$('#log_date_time').text(moment(log_datetime).format('DD-MM-YYYY h:mm:ss a'));
                  }else{
                  	$('#log_date_time').text('NA');
                  }
              		
   
                 
                  $('#out_l2n_r').text(res.data.single_welldevice_data[0].output_Voltage_L2N_R);
                  $('#out_l2n_y').text(res.data.single_welldevice_data[0].output_Voltage_L2N_Y);
                  $('#out_l2n_b').text(res.data.single_welldevice_data[0].output_Voltage_L2N_B);
                  
                  $('#out_p2p_r').text(res.data.single_welldevice_data[0].output_Voltage_P2P_RY);
                  $('#out_p2p_y').text(res.data.single_welldevice_data[0].output_Voltage_P2P_YB);
                  $('#out_p2p_b').text(res.data.single_welldevice_data[0].output_Voltage_P2P_BR);
                  
                  $('#output_current_r').text(res.data.single_welldevice_data[0].output_Current_R);
                  $('#output_current_y').text(res.data.single_welldevice_data[0].output_Current_Y);
                  $('#output_current_b').text(res.data.single_welldevice_data[0].output_Current_B);
                   $('#alert_count').text(res.data.total_alert);
   
                   // ========== alert table start ==========
   
                   $('#alert_table').html("");
                if(res.data.well_alert_details.length > 0)
                {
   			//console.log(res.data.well_alert_details);
   
                   	$.each(res.data.well_alert_details,function(i,v){
                   		var alert_type = v.alert_type != null ? v.alert_type : "NA";
                   		var alerts_details = v.alerts_details != null ? v.alerts_details : "NA";
                   		var trip_datetime = v.trip_datetime != null ? moment(v.trip_datetime).format('DD-MM-YYYY H:mm:ss') : "NA";
   
                       	$("#alert_table").append('<tr>'+
                             	'<td>'+(i+1)+'</td>'+
                             	'<td>'+alert_type+'</td>'+
   						              '<td>'+alerts_details+'</td>'+
                             	'<td>'+trip_datetime+'</td>'+
                           	'</tr>');
   				 
                   	});
   		  document.getElementById('input_hdn_last_alert').value=res.data.well_alert_details[0].alert_type;
           			  document.getElementById('input_hdn_last_datetime').value=res.data.well_alert_details[0].trip_datetime;
                }
                else{
                   $('#alert_table').html('<tr>'+
                            '<td class="text-danger" style="text-align:center;" colspan="4">No Alert Recorded !!</td>'+
                         '</tr>');
                }
   
                   // ======= alert table ends ============
              // ============= starts ========================================
              	//========= dcu status starts ==============================
          var last_data_time = res.data.single_welldevice_data[0].last_log_datetime;
   		var currentDate = new Date();
   
   		var year = currentDate.getFullYear();
   		var month = String(currentDate.getMonth() + 1).padStart(2, '0');
   		var day = String(currentDate.getDate()).padStart(2, '0');
   		var hours = String(currentDate.getHours()).padStart(2, '0');
   		var minutes = String(currentDate.getMinutes()).padStart(2, '0');
   		var seconds = String(currentDate.getSeconds()).padStart(2, '0');
   
   		var formattedDate = year + '-' + month + '-' + day + ' ' + hours + ':' + minutes + ':' + seconds;
   
   		var formattedDateObj = new Date(formattedDate);
   		var lastDataTimeObj = new Date(last_data_time);
   
   		var diffInMilliseconds = formattedDateObj - lastDataTimeObj;
   		var diffInSeconds = Math.floor(diffInMilliseconds / 1000); // Convert milliseconds to seconds
   
   		// console.log('seconds==',diffInSeconds);
   
   
   		// alert(diffInSeconds);
   		if(diffInSeconds > 300)
   		{
   			$('#dcu_red').show();
   			$('#dcu_offline').show();
   			$('#dcu_green').hide();
   			$('#dcu_online').hide();
   
   		}else{
   			$('#dcu_red').hide();
   			$('#dcu_offline').hide();
   			$('#dcu_green').show();
   			$('#dcu_online').show();
   		}
   
   		//========= dcu status ends ==============================
   		var avg_out_current  = res.data.single_welldevice_data[0].output_Average_Current;
                  	
            
                   if (avg_out_current  > 0 && diffInSeconds < 300)
                   {
                   	$('#s_red').hide();
                   	$('#s_green').show();
   			if(myval>0)
                   		$('#hdn_well_running').val(1);
                   }
                   else{
                   	$('#s_red').show();
                   	$('#s_green').hide();
   			if(myval>0)
                   		$('#hdn_well_running').val(0);
                   }
   
              		  var smps_Voltage  = res.data.single_welldevice_data[0].smps_Voltage;
                   if (smps_Voltage  > 5 && diffInSeconds < 300)
                   {
                   	$('#p_red').hide();
                   	$('#p_green').show();
   
                   }else{
                   	$('#p_red').show();
                   	$('#p_green').hide();
                   }
   
                  
            // ============== ends ============
   
        }
   
    });		
   }
   
   function GetGraph()
   {
   var selectedOption = document.getElementById("show_data").value;
   var selectedField = document.getElementById("selected_field");
   var iconImage = document.getElementById("icon_image");
   var content = document.getElementById("content");
   
   var NVO_chart = document.getElementById("NVO_chart");
   var LVO_chart = document.getElementById("LVO_chart");
   var OC_chart = document.getElementById("OC_chart");
   
   if(selectedOption === "1")
   {
   selectedField.textContent = " Neutral Voltage";
   iconImage.src = "<?php echo base_url(); ?>assets/img/speedometer.gif";
   content.innerHTML = ""; 
   
   NVO_chart.style.display = "block";
   LVO_chart.style.display = "none";
   OC_chart.style.display = "none";
   
   
   }  else if(selectedOption === "3")
   {
   selectedField.textContent = " Line Voltage";
   iconImage.src = "<?php echo base_url(); ?>assets/img/speedometer.gif";
   content.innerHTML = ""; // Clear previous content
   NVO_chart.style.display = "none";
   LVO_chart.style.display = "block";
   OC_chart.style.display = "none";
   
   } else if(selectedOption === "5")
   {
   selectedField.textContent = " Current";
   iconImage.src = "<?php echo base_url(); ?>assets/img/frequency.gif";
   content.innerHTML = ""; // Clear previous content
   NVO_chart.style.display = "none";
   LVO_chart.style.display = "none";
   OC_chart.style.display = "block";
   
   }
   var well_id = $('#hdn_well_id').val();
   //var hours = 24;
   var hours = $('#hours').val();
   $.ajax({
           url: '<?php echo base_url(); ?>Dashboard_c/get_all_dashboard_data_graph_ajax',
           type: 'POST',
           data: {well_id:well_id,hours:hours,graphtype:selectedOption},
           success:function(res)
           {
   var res=JSON.parse(res);
    //console.log('Graph Data=',res);
   
    if(selectedOption==="1"){
   	input_volt_l2n_r=res.data.output_neutral_voltage['output_n_R'];
   	input_volt_l2n_y=res.data.output_neutral_voltage['output_n_Y'];
   	input_volt_l2n_b=res.data.output_neutral_voltage['output_n_B'];
   	input_volt_l2n_avg=res.data.output_neutral_voltage['output_n_Avg'];
   	limit_slice=res.data.output_neutral_voltage['output_n_Avg'].length;
   	loadchart("neutral_voltage","Trend of L2N  Voltage","L2N R (v) ","L2N Y (v) ", "L2N B (v) ", "L2N Avg (v) " ,0, 500); 
   }
   else if(selectedOption==="3"){
   	input_volt_l2n_r=res.data.output_line_voltage['output_v_R'];
   	input_volt_l2n_y=res.data.output_line_voltage['output_v_Y'];
   	input_volt_l2n_b=res.data.output_line_voltage['output_v_B'];
   	input_volt_l2n_avg=res.data.output_line_voltage['output_v_Avg'];
   	limit_slice=res.data.output_line_voltage['output_v_Avg'].length;
   	loadchart("neutral_voltage","Trend of P2P  Voltage","P2P R (v) ","P2P Y (v) ", "P2P B (v) ", "P2P Avg (v) ", 0, 500);      
   }
   else if(selectedOption==="5"){
   	input_volt_l2n_r=res.data.output_current['output_i_R'];
   	input_volt_l2n_y=res.data.output_current['output_i_Y'];
   	input_volt_l2n_b=res.data.output_current['output_i_B'];
   	input_volt_l2n_avg=res.data.output_current['output_i_Avg'];
   	limit_slice=res.data.output_current['output_i_Avg'].length;
   	//console.log(input_volt_l2n_avg);
   	loadchart("neutral_voltage","Trend of  Current","R (a) ","Y (a) ", "B (a) ", "Avg (a) ",0, 70); 
   }
   
   
   }});
   }
   
   
   function get_threshold_data()
   {
   	var well_id = $('#hdn_well_id').val();
   	// alert(well_id);
   
       $.ajax({
           url: '<?php echo base_url(); ?>Dashboard_c/get_device_threshold_details_ajax',
           type: 'POST',
           data: {well_id:well_id},
           success:function(res)
           {
               var res=JSON.parse(res);
               //console.log('threshold data=',res);
            
             
              $('#output_l2n_ut').val(res.data[0].output_l2n_ut);
              $('#output_l2n_lt').val(res.data[0].output_l2n_lt);
   
              
   
              $('#output_p2p_ut').val(res.data[0].output_p2p_ut);
              $('#output_p2p_lt').val(res.data[0].output_p2p_lt);
        
            
              $('#out_current_ut').val(res.data[0].out_current_ut);
              $('#out_current_lt').val(res.data[0].out_current_lt);
   
             
      
           }
       });
   }
   
   
   
   
   function loadGuage(varId,myvalue,notifyLabel,lbl, maxVal,dataPointPlotBand)
   {
       Highcharts.chart(varId, {
   
     chart: {
         type: 'gauge',
         plotBackgroundColor: null,
         plotBackgroundImage: null,
         plotBorderWidth: 0,
         plotShadow: false,
         height: '70%'
     },
   
     title: {
         text: ''
     },
   
     pane: {
         startAngle: -90,
         endAngle: 89.9,
         background: null,
         center: ['50%', '75%'],
         size: '120%'
     },
   
     // the value axis
     yAxis: {
         min: 0,
         max: maxVal,
         tickPixelInterval: 72,
         tickPosition: 'inside',
         tickColor: Highcharts.defaultOptions.chart.backgroundColor || '#FFFFFF',
         tickLength: 20,
         tickWidth: 2,
         minorTickInterval: null,
         labels: {
             distance: 20,
             style: {
                 fontSize: '14px'
             }
         },
         plotBands: dataPointPlotBand
     },
   
     series: [{
         name: lbl,
         data: [myvalue],
         tooltip: {
             valueSuffix: notifyLabel
         },
         dataLabels: {
             format: '{y} '+notifyLabel,
             borderWidth: 0,
             color: (
                 Highcharts.defaultOptions.title &&
                 Highcharts.defaultOptions.title.style &&
                 Highcharts.defaultOptions.title.style.color
             ) || '#333333',
             style: {
                 fontSize: '16px'
             }
         },
         dial: {
             radius: '80%',
             backgroundColor: 'gray',
             baseWidth: 12,
             baseLength: '0%',
             rearLength: '0%'
         },
         pivot: {
             backgroundColor: 'gray',
             radius: 6
         }
   
     }]
   
   });
   }
   
   
   function updateGuage(myvalue,chartIndex)
   {
   	//console.log(myvalue,chartIndex);
    const chart = Highcharts.charts[chartIndex];
    if (chart && !chart.renderer.forExport) {
        const point = chart.series[0].points[0],
            inc = Math.round((Math.random() - 0.5) * 20);
   
        let newVal = point.y + inc;
        if (newVal < 0 || newVal > 200) {
            newVal = point.y - inc;
        }
   
        point.update(myvalue);
    }
   }
   
</script>
<script type="text/javascript">
   get_well_data();
   function get_well_data() {
    var well_id = $('#hdn_well_id').val();
    // alert(well_id);
   
    $.ajax({
        url: '<?php echo base_url(); ?>Dashboard_c/well_shifted_single_dashboard',
        method: 'POST',
        data: { well_id: well_id },
        success: function (res) {
            var response = JSON.parse(res);
            //console.log('well_datasimran=', response);
             	$('#well_details').hide();
            if (response.status) {
                $('#well_data_details').html('');
   
                if (response.data.length > 0) {
   
                
                    displayedWellNames = [];
   
                    // Sort data array in descending order based on the date
                    response.data.sort(function(a, b) {
                        return new Date(b.date) - new Date(a.date);
                    });
   
                    $.each(response.data, function (i, v) {
                        var well_id = v.well_name;
                        $('#well_name_details').text(well_id);
                         $('#well_name_data').text(well_id);
   
                        var eventColor = (v.status == 0) ? 'one' : 'two';
                       var cardBackgroundColor = (v.status == 0) ? '#27AE60' : 'orange';
   		             var textColor = (v.status == 0) ? 'white' : 'white';  // A
   
                        var shiftedDateText = (v.shifteddate) ? '<p><span style="color: ' + textColor + ';"> &nbsp; &nbsp; Shifted On :' + moment(v.shifteddate).format('DD-MM-YYYY h:mm:ss a') + '</span></p>' : '';
   
                        var imei_no = v.imei_no;
   
                        
                        if (v.device_name && v.imei_no) 
                        {
   
   
                        		$('#well_details').show();
   
                        	var fixedCardHeight = '150px';
   
                            var timelineItem =
                                '<li class="timeline-item bmw">' +
   								  '<div class="card" style="border:none;background-color: ' + cardBackgroundColor + '; height: ' + fixedCardHeight + '; width: 100%">' +
                          '<span></span>' +
   								        '<div class="p-timeline-item">' +
   								            '<time class="p-timeline-date"><span style="color: ' + textColor + ';">Installed Date:' + moment(v.date).format('DD-MM-YYYY h:mm:ss a') + '</span></time>' 
   								            + shiftedDateText +
   								           
   								            '<p class="p-timeline-carmodel"><span style="color: ' + textColor + ';">Imei No:' + imei_no + '</span></p>' +
   								            '<p class="p-timeline-carmodel"><span style="color: ' + textColor + ';">Device Name:' + v.device_name + '</span></p>' +
   								             '</div>' +
   
   
   								      '</div>'+
   								       '<div class="arrow-down '+ eventColor +'"></div>' +
   								       
   								            '<div class="p-timeline-block ' + eventColor + '"></div>' +
   								   
   								    '</li>';
                            $('#well_data_details').append(timelineItem);
                        
                        }
                    });
                }
            } else {
                $('#well_data_details').html('<p>No data available</p>');
            }
        },
        error: function (error) {
            console.error('Error fetching well data:', error);
        }
    });
   }
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA80-_i6Nd7DPLz-axQE8eFEXV6WPDmwK4"></script>


<script type="text/javascript">
   
   initMap();
function initMap() {

   
   var well_id = $('#hdn_well_id').val();


  $.ajax({
    url:'<?php echo base_url(); ?>Dashboard_c/get_site_location_for_new_tab',
    type : 'POST',
    data : {well_id:well_id},
    success : function(res)
    {
      response = JSON.parse(res);
         
      if(response.data.length>0)
      {   
        let markers=[];
        for(item of response.data){
          markers.push({
            position: {lat: parseFloat(item.lat), lng: parseFloat(item.long)},
            title: item.well_name,
            status: item.smps_voltage,
            site_id: item.site_id,
            well_id: item.well_id,
            ins_status: item.device_setup_status,
            device_active_status:item.device_active_status,
            avg_out_current : item.output_Average_Current,
            offline_time : item.last_log_datetime,
            lat:item.lat,
            long:item.long
          })
        }

        var map = new google.maps.Map(document.getElementById('mymap'), {
          zoom: 13,
          center: {lat:22.24541800, lng:73.07932750}
        });

        

         markers.forEach(function(marker) {
          var markerIcon = {
            url: '<?php echo base_url(); ?>assets/images/yellow-well.png',
            scaledSize: new google.maps.Size(20, 20)
            
          };

          var well_name = marker.title; 
          $('#well_namedata').text(well_name);

          if (marker.offline_time != null )
            {
               // =============== time convert code starts =========
                     var last_data_time = marker.offline_time;
                           var currentDate = new Date();

                           var year = currentDate.getFullYear();
                           var month = String(currentDate.getMonth() + 1).padStart(2, '0');
                           var day = String(currentDate.getDate()).padStart(2, '0');
                           var hours = String(currentDate.getHours()).padStart(2, '0');
                           var minutes = String(currentDate.getMinutes()).padStart(2, '0');
                           var seconds = String(currentDate.getSeconds()).padStart(2, '0');

                           var formattedDate = year + '-' + month + '-' + day + ' ' + hours + ':' + minutes + ':' + seconds;

                           var formattedDateObj = new Date(formattedDate);
                           var lastDataTimeObj = new Date(last_data_time);

                           var diffInMilliseconds = formattedDateObj - lastDataTimeObj;
                           var diffInSeconds = Math.floor(diffInMilliseconds / 1000); // Convert milliseconds to seconds

                           // console.log('seconds==',diffInSeconds);

                           var second = diffInSeconds;
                           // console.log(second);
            // =============== time convert code ends ===========
                  }else{
                        var second = 200;
                        // console.log(second);
                  }

             if (marker.ins_status == '1' && marker.device_active_status == '1')
               {
                  if (second < 300 )
                  {
                        if (marker.avg_out_current > 0) {
                     markerIcon.url = '<?php echo base_url(); ?>assets/img/green.png';
                      } else {
                        markerIcon.url = '<?php echo base_url(); ?>assets/img/red.png';
                      } 
                     
                  }  else{
                        markerIcon.url = '<?php echo base_url(); ?>assets/img/offline.png';
                  }
                     
               }else{
                     
                     markerIcon.url = '<?php echo base_url(); ?>assets/img/orange.png';
               }

                var mapMarker = new google.maps.Marker({
                  position: marker.position,
                  map: map,
                  icon: markerIcon,
                  title: marker.title
                });

                var statusText = '';
                  if (marker.ins_status == 1)
                  {
                     if (second < 300)
                     {
                           if (marker.avg_out_current > 0 )
                           {
                              statusText = 'ON';
                           }else{
                              statusText = 'OFF';
                           }
                     }else{
                        statusText = 'DCU OFF';
                     }
                     
                    
                  }
                  
                  else{
                      statusText = 'Device Not Installed';
                  }

          var infowindow = new google.maps.InfoWindow({
              content: '<div class="site-info" style="width: 100px; height: 100px;">' +
                        '<h5>' + marker.title + '</h5>' +
                        '<h6><b>Well Status</b>: ' + statusText + '</h6>' +
                        ((marker.status == null )
                          ? ''
                          : '<a target="_blank" href="<?php echo base_url(); ?>Dashboard_c/get_single_well_detail_dashboard/' + marker.well_id + '">View Details</a>'+
                          
                              '<h5><a target="_blank" href="https://www.google.com/maps/place/' + marker.lat + ',' + marker.long + '">View on Google Maps</a></h5>'
  

                          ) +

                        '</div>'
               });

          mapMarker.addListener('click', function() {
                   infowindow.open(map, mapMarker);
               });

               map.addListener('click', function() {
                   infowindow.close();
               });

        });
      }
    }
  });
}
</script>
<script type="text/javascript">
    get_schduling_data();
   function get_schduling_data() 
   {
      $('#table_schdule').html('<tr><td colspan="3">Processing please wait.......</td></tr>');
      var well_id = $('#hdn_well_id').val();

      $.ajax({
       url: '<?php echo base_url(); ?>Dashboard_c/get_schduling_details',
       method: 'POST',
       data: {well_id:well_id},
       success: function(res) {
           var response = JSON.parse(res);
 
           if (response.response_code == 200) {
               
               $('#table_schdule').html("");
               if (response.data[0]['schdule_time'].length > 0) {
                   
                   $.each(response.data[0]['schdule_time'], function(i, v) {
                     
                           $("#table_schdule").append('<tr>'+
                               '<td>'+(i+1)+'</td>'+
                               '<td>'+ moment('1970-01-01 ' + v.start_time, 'YYYY-MM-DD HH:mm:ss').format('h:mm:ss a')+'</td>'+
                               '<td>'+ moment('1970-01-01 ' + v.stop_time, 'YYYY-MM-DD HH:mm:ss').format('h:mm:ss a')+'</td>'+
                               '</tr>');
                          
                   });
               } else {
                   $('#table_schdule').html('<tr>'+
                       '<td class="text-danger" style="text-align:center;" colspan="7">No Record Found !!</td>'+
                       '</tr>');
               }
           }else {
                   $('#table_schdule').html('<tr>'+
                       '<td class="text-danger" style="text-align:center;" colspan="7">No Record Found !!</td>'+
                       '</tr>');
               }
       }
      });
   }
</script>
<script type="text/javascript">
   setInterval(()=>{
   	GetDashboardData(0);
   	initMap();
   
     },60000);
</script>