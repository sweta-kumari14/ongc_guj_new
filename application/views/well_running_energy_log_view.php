<div class="page-wrapper">
    <div class="content container-fluid pb-0">
    	<div class="page-header">
			<div class="content-page-header">
				<h5>Well Performance Report</h5>
			</div>	
		</div>
			<div class="row">					
						<!-- Lightbox -->
                        <div class="col-lg-12">
                            <div class="card">
                               
                                <div class="card-body">
                                   <div class="row align-items-center">
                                        <div class="col">
                                           <h4 class="header-title mb-4"><b>Well Performance Report</b></h4>
                                        </div>
                                        <div class="col-auto float-end ms-auto">
                                             <button  id="area_wise_data" class="btn btn-success btn-sm  mx-2" onclick="export_report_area_wise()" style="font-size: 14px; display: none;">Export</button>
                                              <button id="asset_wise_data" class="btn btn-success btn-sm mx-2" onclick="export_report_asset_wise()" style="font-size: 14px;display: none;">Export</button>
                                               <button class="btn btn-sm  btn-primary" id="area_wise_pdf" onclick="printArea();"style="display: none;">PDF</button>
                                               <button class="btn btn-sm  btn-primary" id="assets_wise_pdf" onclick="printAssets();"style="display: none;">PDF</button>
                                        </div>
                                    </div>


                                    
                                <div class="row">
                                         <div class="form-group col-md-3 mt-2">
                                    <h5><b>Area Name</b></h5>
                                    <select name="site_id" id="site_id" class="form-control select2" onchange="get_running_area_log();get_running_asset_log();get_feeder_list();">
                                       <?php
                                    $user_type = $this->session->userdata('user_type', true);
                                    $role_type = $this->session->userdata('role_type',true);
                                   if ($user_type == 3 && $role_type == 2) {
                                       if (!empty($site_list)) {
                                            
                                            foreach ($site_list as $key => $value) {
                                                ?>
                                                <option value="<?php echo $value['id']; ?>"> <?php echo $value['well_site_name']; ?></option>
                                                <?php
                                            }
                                        }
                                    } else {
                                        if (!empty($site_list)) {
                                            echo '<option value="">All Area</option>'; 
                                            foreach ($site_list as $key => $value) {
                                                ?>
                                                <option value="<?php echo $value['id']; ?>"> <?php echo $value['well_site_name']; ?></option>
                                                <?php
                                            }
                                        }
                                    }
                                    ?>
                                    </select>
                                </div>
                                 <div class="form-group col-md-3 mt-2" style="display:none;" id="feeder_dropdown">
                                <h5><b>Feeder</b></h5>
                                <select name="feeder_id" id="feeder_id" class="form-control select2" onchange="get_running_area_log();">
                                    <option value="">Select Feeder</option>

                                </select>
                            </div>

                               

                                <div class="form-group col-md-3 mt-2">
                                    <h5><b>From Date</b></h5>
                                    <input type="date" name="from_date" id="from_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" onchange="get_running_area_log();get_running_asset_log();">
                                </div>

                                <div class="form-group col-md-3 mt-2">
                                    <h5><b>To Date</b></h5>
                                    <input type="date" name="to_date" id="to_date" class="form-control" value="<?php echo date('Y-m-d'); ?>"  onchange="get_running_area_log();get_running_asset_log();">
                                </div>

                                <div class="form-group col-md-3 mt-2" id="company_wise" style="display: none;">
                                    <h5><b>Sort By</b></h5>
                                    <select class="form-control select2" name="sort_by_company" id="sort_by_company" onchange="get_running_asset_log();">
                                        <option value="">Select Column</option>
                                        <option value="well_site_name">Area Name</option>
                                        <option value="total_no_of_wells">Total Wells</option>
                                        <!-- <option value="running_minutes">Schedule Hours</option>
                                        <option value="t_minute">Running Hours</option>
                                        <option value="shutdown_minutes">Shutdown Hours</option>
                                        <option value="availablity">Availability</option> -->
                                        <option value="e_consumption">Energy Consumption</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-3 mt-2" id="user_wise" style="display: none;">
                                    <h5><b>Sort By</b></h5>
                                    <select class="form-control select2" name="sort_by_user" id="sort_by_user" onchange="get_running_area_log();">
                                        <option value="">Select Column</option>
                                        <option value="well_site_name">Area Name</option>
                                        <option value="well_name">Well Name</option>
                                        <option value="running_minutes">Schedule Hours</option>
                                        <option value="t_minute">Running Hours</option>
                                        <!-- <option value="shutdown_minutes">Shutdown Hours</option> -->
                                        <!-- <option value="availability">Availability</option> -->
                                        <option value="e_consumption">Energy Consumption</option>
                                    </select>
                                </div>
                                
                            </div>
                            <div id ="GFGAssets">  
                                <div class="card-body" id="asset_wise" style="display:none;">
                                <div class="table-responsive mt-4" id="data-table">
                                <table class="table table-bordered border-bottom table-striped" >
                                      <thead style="background-color:blue; color: white; text-align: center;">
                                        <tr>
                                           <th colspan="9" class="text-uppercase" style="font-size: 20px;font-weight: bolder;">IOT BASED REAL TIME WELL MONITORING SYSTEM ONGC,CAMBAY ASSET </th>
                                        </tr>
                                        <tr>
                                            <th colspan="9" class="text-uppercase" style="font-size: 15px;font-weight: bolder;" id="report-heading_data"></th>
                                        </tr>
                                    </thead>
                                </table>
                                 <table class="table table-bordered border-bottom table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width:10%;">Sl No.</th>
                                            <th>Area Name</th>
                                            <th>Total Wells</th>
                                            <th>Schedule Hours</th>
                                            <th>Running Hours</th>
                                            <th>Shut Down Hours</th>
                                            <th>Availability %</th>
                                            <th>Energy Consumption</th>
                                            <th>Energy Consumption Per Well</th>
                                           
                                        </tr>
                                     </thead>
                                   
                                    <tbody class="text-center" id="table_data"> 
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
              
                            <div id="GFGArea">
                            <div class="card-body" id="area_wise"  style="display:none;">
                            <div class="table-responsive mt-4" id="data-table2">
                                <table class="table table-bordered border-bottom table-striped" >
                                      <thead style="background-color:blue; color: white; text-align: center;">
                                        <tr>
                                           <th colspan="8" class="text-uppercase" style="font-size: 20px;font-weight: bolder;">IOT BASED REAL TIME WELL MONITORING SYSTEM ONGC,CAMBAY ASSET </th>
                                        </tr>
                                        <tr>
                                            <th colspan="8" class="text-uppercase" style="font-size: 15px;font-weight: bolder;" id="report-heading"></th>
                                        </tr>
                                         </thead>
                                     </table>
                                      <table class="table table-bordered border-bottom table-striped" ><thead>
                                        <tr>
                                            <th style="width:10%;">Sl No.</th>
                                            <th>Area Name</th>
                                            <th>Well Name</th>
                                            <th>Schedule Hours</th>
                                            <th>Running Hours</th>
                                            <th>Shut Down Hours</th>
                                            <th>Availability %</th>
                                            <th>Energy Consumption</th>
                                            <th>Remarks</th>
                                           
                                        </tr>
                                        </thead>
                                   
                                    <tbody class="text-center" id="table_data_area"> 
                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div>
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
get_feeder_list();
function get_feeder_list() { 
    
    let site_id = $('#site_id').val();
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url();?>Running_log_c/feeder_list',
        data: { site_id:site_id },
        success: function(data) {
            data = JSON.parse(data);
           
            if (data.response_code == 200) {   
                if (data.data.length > 0) {
                    $('#feeder_id').html('');
                    $('#feeder_id').html('<option value="">Select Feeder</option>');
                    $.each(data.data, function(i, v) {
                     
                        $('#feeder_id').append('<option value="' + v.id + '">' + v.feeder_name + '</option>');
                    });
                } else {
                    $('#feeder_id').html('<option value=""></option>');
                }
            } else {
                swal('error', data.msg, 'error');
            }   
        }
    });
}


</script>
<script type="text/javascript">
     get_feeder_data();
    function get_feeder_data() 
   { 
        let site_id = $('#site_id').val();
        if (site_id  == "c1bcb5e4-b394-11ee-a6d4-5cb901ad9cf0") 
        {
            
            $('#feeder_dropdown').show();  
        } else {
            
            $('#feeder_dropdown').hide();
           
        }
    }
</script>

<script type="text/javascript">
    function getCurrentDate() {
        const date = new Date();
        const year = date.getFullYear();
        const month = ('0' + (date.getMonth() + 1)).slice(-2); 
        const day = ('0' + date.getDate()).slice(-2);
        return `${year}-${month}-${day}`;
    }

    function isCurrentDate() {
        const currentDate = getCurrentDate();
       
        const fromDate = document.getElementById('from_date').value;
        const toDate = document.getElementById('to_date').value;

        return fromDate === currentDate || toDate === currentDate;
    }
    
get_running_asset_log();
function get_running_asset_log()
{
   $('#table_data').html('<tr><td colspan="10">Processing please wait.......</td></tr>');
    let site_id = $('#site_id').val();
    let from_date = $('#from_date').val();
    let to_date = $('#to_date').val();
    let sort_by = $('#sort_by_company').val();



    var selectedsiteName = $('#site_id option:selected').text();
    let formattedFromDate = moment(from_date, 'YYYY-MM-DD').format('DD-MM-YYYY');
    let formattedToDate = moment(to_date, 'YYYY-MM-DD').format('DD-MM-YYYY');

    let headingText = ` ${selectedsiteName} Well Performance ${formattedFromDate} to ${formattedToDate}   `;
         $('#report-heading_data').text(headingText);
  
    $.ajax({
        url:'<?php echo base_url(); ?>Well_running_energy_log_c/get_running_and_energy_log_Assets_wise_data',
        method:'POST',
        data:{ site_id:site_id,from_date:from_date,to_date:to_date,sort_by:sort_by},
        success:function(res)
        {
            var response = JSON.parse(res);
            // console.log('response====',response);
            if(response.response_code==200)
                {
                    $('#table_data').html("");
                     if(response.data.assets_wise.length > 0)
                     {
                         var total_kwh_sum = 0;
                         var total_minutes_sum = 0;
                         var total_shutdown_sum = 0;
                         var total_hours_sum = 0;
                         var avg_availability = 0;
                         var avg_EnergyConsumption = 0;
                         var total_no_well = 0;

                        $.each(response.data.assets_wise,function(i,v){

                             var total_running_minute = v.t_minute;
                             total_minutes_sum += parseFloat(total_running_minute);
                             total_kwh_sum += parseFloat(v.e_consumption);

                             var hours = Math.floor(total_running_minute / 60);
                             var minutes = total_running_minute % 60;
                             var duration = hours + ' Hrs ' + minutes + ' Mins';
                         
                             var total_shutdown =  parseInt(v.shutdown_minutes);
                             total_shutdown_sum += parseFloat(Math.abs(total_shutdown));

                             var shutdown_hours = Math.floor(total_shutdown / 60);
                             var shut_down_minutes = total_shutdown % 60;

                            if(total_shutdown < 0)
                             {

                                var hours = Math.floor(Math.abs(total_shutdown) / 60);
                                var minutes = Math.abs(total_shutdown) % 60;
                                if(hours > 0)
                                {
                                    var shutdown_duration = "0 Hrs (Extra " + hours + ' Hrs ' + minutes + ' Min ) '
                                }else{
                                    var shutdown_duration = "0 Hrs (Extra " + minutes + ' Min ) '
                                }
                             }else{

                                 var shutdown_duration = shutdown_hours + ' Hrs ' + shut_down_minutes + ' Mins';
                             }

                            var total_hours_running = parseInt(v.running_minutes);
                             total_hours_sum += parseFloat(total_hours_running);
                             // console.log(total_hours_running);

                            var running_hours = Math.floor(total_hours_running / 60);
                            var runningminutes = total_hours_running % 60;
                            var running_duration = running_hours + ' Hrs ' + runningminutes + ' Mins';
                            var availablity = Math.min(parseFloat(v.availablity).toFixed(2),100);
                            // console.log('availablity=',availablity);
                            avg_availability += parseFloat(availablity);

                            var EnergyPerWell = parseFloat(v.e_consumption)/parseInt(v.total_no_of_wells);
                            avg_EnergyConsumption +=parseFloat(EnergyPerWell);

                             total_no_well += parseInt(v.total_no_of_wells);
                            $("#table_data").append('<tr>'+
                                    '<td>'+(i+1)+'</td>'+
                                    '<td>'+v.well_site_name+'</td>'+
                                    '<td>'+v.total_no_of_wells+'</td>'+
                                    '<td>'+ running_duration +'</td>'+
                                    '<td>' + duration+ '</td>' +
                                    '<td>'+ shutdown_duration +'</td>'+
                                    '<td>'+ availablity + '</td>'+
                                    '<td>'+v.e_consumption+'</td>'+
                                    '<td>'+parseFloat(EnergyPerWell).toFixed(2)+'</td>'+
                                    
                                '</tr>');
                        });

                        var total_hours = Math.floor(total_minutes_sum / 60);
                        var remaining_minutes = total_minutes_sum % 60;
                        var total_duration = total_hours + ' Hrs ' + remaining_minutes + ' Minutes';

                        var total_shut_downhours = Math.floor(total_shutdown_sum / 60);
                        var shut_downremaining_minutes = total_shutdown_sum % 60;
                        var total_shutdown_duration = total_shut_downhours + ' Hrs ' + shut_downremaining_minutes + ' Mins';

                        var total_running_hours = Math.floor(total_hours_sum / 60);
                        var total_runningminutes = total_hours_sum % 60;
                        var total_running_duration = total_running_hours + ' Hrs ' + total_runningminutes + ' Mins';
                        var Avg_Aval = (avg_availability/response.data.assets_wise.length);
                        var final_avaiability = parseFloat(Avg_Aval).toFixed(2);

                        var Avg_ENE_Comp = (avg_EnergyConsumption/response.data.assets_wise.length);
                        var final_ECPW = parseFloat(Avg_ENE_Comp).toFixed(2);

                         $("#table_data").append('<tr>' +
                            '<td colspan="2" style="text-align:right;"><b>Total</b></td>' +
                            '<td><b>'+total_no_well+'</b></td>'+
                            '<td><b>'+total_running_duration+'</b></td>'+
                            '<td><b>' + total_duration + '</b></td>' +
                             '<td><b>'+ total_shutdown_duration +'</b></td>'+
                            '<td><b >Avg. '+final_avaiability+' </b></td>'+
                            '<td><b>' + total_kwh_sum.toFixed(2) + ' Kwh</b></td>' +
                             '<td ><b>Avg. '+final_ECPW+' Kwh</b></td>'+
                         '</tr>'
                        );
                     }
                     else{
                        $('#table_data').html('<tr>'+
                                 '<td class="text-danger" style="text-align:center;" colspan="10">No Record Found !!</td>'+
                              '</tr>');
                     }
                }
        }
    });
}

get_running_area_log();
function get_running_area_log()
{
    $('#table_data_area').html('<tr><td colspan="10">Processing please wait.......</td></tr>');
    let site_id = $('#site_id').val();
    let from_date = $('#from_date').val();
    let to_date = $('#to_date').val();
    let sort_by = $('#sort_by_user').val();
    let feeder_id = $('#feeder_id').val();
    
    var selectedfeederName = $('#feeder_id option:selected').text();
    var selectedsiteName = $('#site_id option:selected').text();
    let formattedFromDate = moment(from_date, 'YYYY-MM-DD').format('DD-MM-YYYY');
    let formattedToDate = moment(to_date, 'YYYY-MM-DD').format('DD-MM-YYYY');

    let headingText = ` ${selectedsiteName} ${selectedfeederName} Well Performance ${formattedFromDate} to ${formattedToDate}   `;
         $('#report-heading').text(headingText);
  

   

    $.ajax({
        url:'<?php echo base_url(); ?>Well_running_energy_log_c/get_running_and_energy_log_data',
        method:'POST',
        data:{ site_id:site_id,from_date:from_date,to_date:to_date,sort_by:sort_by,feeder_id:feeder_id},
        success:function(res)
        {
            var response = JSON.parse(res);
            // console.log('-----',response);
            if(response.response_code==200)
                {
                    $('#table_data_area').html("");
                     if(response.data.area_wise.length > 0)
                     {
                         var total_kwh_sum = 0;
                         var total_minutes_sum = 0;
                         var total_shutdown_sum = 0;
                         var total_hours_sum = 0;
                         var avg_availability = 0;

                        $.each(response.data.area_wise,function(i,v){
                             var total_running_minute = v.t_minute;
                             total_minutes_sum += parseFloat(total_running_minute);
                             total_kwh_sum += parseFloat(v.e_consumption);

                               // console.log('total_running===',total_minutes_sum)
                             var hours = Math.floor(total_running_minute / 60);
                             var minutes = total_running_minute % 60;
                             var duration = hours + ' Hrs ' + minutes + ' Mins';

                             var total_shutdown =  parseInt(v.shutdown_minutes);
                             total_shutdown_sum += parseFloat(Math.abs(total_shutdown));

                            var shutdown_hours = Math.floor(total_shutdown / 60);
                            var shut_down_minutes = total_shutdown % 60;

                            if(total_shutdown < 0)
                             {

                                var hours = Math.floor(Math.abs(total_shutdown) / 60);
                                var minutes = Math.abs(total_shutdown) % 60;
                                if(hours > 0)
                                {
                                    var shutdown_duration = "0 Hrs (Extra " + hours + ' Hrs ' + minutes + ' Min ) '
                                }else{
                                    var shutdown_duration = "0 Hrs (Extra " + minutes + ' Min ) '
                                }
                             }else{

                                 var shutdown_duration = shutdown_hours + ' Hrs ' + shut_down_minutes + ' Mins';
                             }

                            var availability = Math.min(parseFloat(v.availability).toFixed(2),100);

                             var total_hours_running = parseInt(v.running_minutes);
                             total_hours_sum += parseFloat(total_hours_running);

                             // console.log('shedule_hours===',total_hours_sum)

                            var running_hours = Math.floor(total_hours_running / 60);
                            var runningminutes = total_hours_running % 60;
                            var running_duration = running_hours + ' Hrs ' + runningminutes + ' Mins';

                            avg_availability += parseFloat(availability);
                            
                           
                            $("#table_data_area").append('<tr>'+
                                    '<td>'+(i+1)+'</td>'+
                                    '<td>'+v.well_site_name+'</td>'+
                                    '<td>'+v.well_name+'</td>'+
                                    '<td>'+ running_duration +'</td>'+
                                    '<td>'+ duration+ '</td>' +
                                    '<td>'+shutdown_duration+'</td>'+
                                    '<td>'+ availability + '</td>'+
                                    '<td>'+v.e_consumption+'</td>'+
                                    '<td>'+v.remarks+'</td>'+
                                    
                                    
                                '</tr>');
                        });

                        // console.log(response);

                        var total_hours = Math.floor(total_minutes_sum / 60);
                        var remaining_minutes = total_minutes_sum % 60;
                        var total_duration = total_hours + ' Hrs ' + remaining_minutes + ' Mins';

                        
                        var total_shut_downhours = Math.floor(total_shutdown_sum / 60);
                        var shut_downremaining_minutes = total_shutdown_sum % 60;
                        var total_shutdown_duration = total_shut_downhours + ' Hrs ' + shut_downremaining_minutes + ' Mins';

                         var total_running_hours = Math.floor(total_hours_sum / 60);
                        var total_runningminutes = total_hours_sum % 60;
                        var total_running_duration = total_running_hours + ' Hrs ' + total_runningminutes + ' Mins';

                        var Avg_Aval = (avg_availability/response.data.area_wise.length);
                        var final_avaiability = parseFloat(Avg_Aval).toFixed(2);

                         $("#table_data_area").append('<tr>' +
                            '<td colspan="3" style="text-align:right;"><b>Total</b></td>' +
                           
                            '<td><b>'+total_running_duration+'</b></td>'+
                             '<td><b>' + total_duration + '</b></td>' +
                            '<td><b>'+ total_shutdown_duration +'</b></td>'+
                            '<td><b >Avg. '+final_avaiability+'</b></td>'+
                            '<td><b>' + total_kwh_sum.toFixed(2) + ' Kwh</b></td>' +
                            '<td></td>'+
                                    
                         '</tr>'
                        );
                     }
                     else{
                        $('#table_data_area').html('<tr>'+
                                 '<td class="text-danger" style="text-align:center;" colspan="10">No Record Found !!</td>'+
                              '</tr>');
                     }
                }

        }
        
    });
}

</script>
<script src="<?php echo base_url(); ?>assets/local/excel/xlsx.full.min.js"></script>
<script type="text/javascript">
    
    function export_report_asset_wise() {
      var sheetName = "Sheet1";
      var fileName = "Well running report asset wise.xlsx";
      var table = $("#data-table")[0];
      // Convert table to worksheet
      var ws = XLSX.utils.table_to_sheet(table);
      // Create a new workbook and add the worksheet to it
      var wb = XLSX.utils.book_new();
      XLSX.utils.book_append_sheet(wb, ws, sheetName);
      // Save the workbook as an Excel file and download it
      XLSX.writeFile(wb, fileName);
    }

     function export_report_area_wise() {
      var sheetName = "Sheet1";
      var fileName = "Well Running report area wise.xlsx";
      var table = $("#data-table2")[0];
      // Convert table to worksheet
      var ws = XLSX.utils.table_to_sheet(table);
      // Create a new workbook and add the worksheet to it
      var wb = XLSX.utils.book_new();
      XLSX.utils.book_append_sheet(wb, ws, sheetName);
      // Save the workbook as an Excel file and download it
      XLSX.writeFile(wb, fileName);
    }

</script>
<script type="text/javascript">
    
     setInterval(()=>{
        if (isCurrentDate()) {
        get_running_area_log();
        get_running_asset_log();
      } 
        },60000);
</script>
<script type="text/javascript">
    $(document).ready(function() {
        var user_type = "<?php echo $this->session->userdata('user_type') ?>";
        var role_type = "<?php echo $this->session->userdata('role_type') ?>";
        
        if (user_type == 3 && role_type == 2) {
          
            $('#area_wise').show();
            $('#asset_wise').hide();
            $('#asset_wise_data').hide();
            $('#area_wise_data').show();

            $('#company_wise').hide();
            $('#user_wise').show();
            $('#area_wise_pdf').show();
            $('#assets_wise_pdf').hide();
        } else {
            
            $('#asset_wise').show();
            $('#area_wise').hide();
            $('#asset_wise_data').show();
            $('#area_wise_data').hide();

            $('#company_wise').show();
            $('#user_wise').hide();
            $('#area_wise_pdf').hide();
            $('#assets_wise_pdf').show();
        }
    });

</script>
 <style>
        @media print {
            @page {
                size: landscape;
                margin: 0.5cm; 
            }

            body {
                -webkit-print-color-adjust: exact; 
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            th, td {
                font-size: 10px; 
                padding: 1px;
                border: 1px solid black; 
            }

            .no-print {
                display: none;
            }
        }
    </style>
<script>
    function printArea() {
        var printDiv = "#GFGArea"; 
        $("*").addClass("no-print");
        $(printDiv + " *").removeClass("no-print");
        $(printDiv).removeClass("no-print");

        var parent = $(printDiv).parent();
        while ($(parent).length) {
            $(parent).removeClass("no-print");
            parent = $(parent).parent();
        }
        window.print();
    }

     function printAssets() {
        var printDiv = "#GFGAssets"; 
        $("*").addClass("no-print");
        $(printDiv + " *").removeClass("no-print");
        $(printDiv).removeClass("no-print");

        var parent = $(printDiv).parent();
        while ($(parent).length) {
            $(parent).removeClass("no-print");
            parent = $(parent).parent();
        }
        window.print();
    }
</script>

                


                

                