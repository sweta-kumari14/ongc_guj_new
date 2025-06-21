<div class="page-wrapper">
<!-- Page Content -->
    <div class="content container-fluid">
    	<!-- Page Header -->
			<div class="page-header">
				<div class="row">
					<div class="col-sm-12">
						<h3 class="page-title">Running Well Report</h3>
						<ul class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard_c');?>">Dashboard</a></li>
							<li class="breadcrumb-item ">Running Well Report</li>
							
						</ul>
					</div>
				</div>
			</div>
<!-- /Page Header -->
		    <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">
                        	    <div class="col">
		                            <h4 class="header-title mb-4">Running Well Report</h4>
		                        </div>
					            <div class="col-auto float-end ms-auto">
						            <button class="btn btn-sm  btn-success" onclick="export_report();">Export</button>
                                  
                                      <button class="btn btn-sm  btn-primary" onclick="printDate();">PDF</button>
                                        <a href="<?php echo base_url().'Dashboard_c/get_single_well_detail_dashboard/'.$this->uri->segment(3); ?>"><button type="button" class="btn btn-sm btn-success mx-2">Back</button></a>
					            </div>
			                </div>

			                <div class="row m-2">
		                        <div class="form-group col-md-4 mt-2">
							    <h5><b>From Date</b></h5>
							    <input type="date" name="from_date" id="from_date" class="form-control" onchange="get_well_running_report();">
							</div>

							<div class="form-group col-md-4 mt-2">
							    <h5><b>To Date</b></h5>
							    <input type="date" name="to_date" id="to_date" class="form-control" onchange="get_well_running_report();">
							</div>
						</div>
					</div>

					<div class="card-body" id="GFG">
				   <div class="table-responsive" id="basic-datatable">
					<table class="table table-bordered border-bottom">
						<thead class="bg-light text-center">
							<tr>
								<th colspan="7" class="text-uppercase" style="font-size: 20px;font-weight: bolder;">IOT Based Real Time Well Monitoring System ONGC,Cambay Asset </th>
							</tr>
							<tr>
								<th colspan="7" class="text-uppercase" style="font-size: 15px;font-weight: bolder;"> Well &nbsp;(<span id="well_name"></span>) Running Report as on <?php echo date('d-m-Y h:i:s a') ?></th>
							</tr>
                        </thead>
                    </table>
                    <table class="table table-bordered border-bottom" >
							<tr>
								<th style="width:10%;">Sl No.</th>
								<th>From Date Time</th>
								<th>To Date Time</th>
                                <th>Schedule Hours</th>
								<th>Total Running Hour</th>
								<th>Shut Down Hour </th>
								<th>Total Energy Consumption</th>
							</tr>
						
						<tbody class="text-center" id="table_data">							
							
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

<script>
    // Function to get the default date value
    function getDefaultDateValue() {
        const currentDate = new Date();
        const currentHour = currentDate.getHours();
        const currentDateString = currentDate.toISOString().slice(0, 10);

        // If the current hour is before 6 am, show the previous date as the default value
        if (currentHour < 6) {
            const previousDate = new Date(currentDate);
            previousDate.setDate(previousDate.getDate() - 1);
            return previousDate.toISOString().slice(0, 10);
        }

        return currentDateString;
    }

    // Set the default date value when the page loads
    document.getElementById('from_date').value = getDefaultDateValue();
    document.getElementById('to_date').value = getDefaultDateValue();
</script>


<script type="text/javascript">


    get_well_running_report();
    function get_well_running_report() {
    $('#table_data').html('<tr><td colspan="7">processing please wait.......</td></tr>');
    var from_date = $('#from_date').val();
    var to_date = $('#to_date').val();
    var well_id = '<?php echo $this->uri->segment(3) ?>';

    $.ajax({
        url: '<?php echo base_url(); ?>Dashboard_c/get_running_report_ajax',
        method: 'POST',
        data: { from_date: from_date, to_date: to_date, well_id: well_id },
        success: function(res) {
            var response = JSON.parse(res);
            // console.log(response);
            if (response.response_code == 200) {
                $('#table_data').html("");
                if (response.data.length > 0) {
                    var groupedData = {};
                    var all_minutes_sum = 0;
                    var all_shutdown_sum = 0;
                    var all_kwh_sum = 0;
                    var all_minutes_schdule_sum = 0;

                    response.data.forEach(function(item) {
                
                        var start_datetime = moment(item.start_datetime);
                        var date = start_datetime.format('YYYY-MM-DD');
                        if (start_datetime.hours() < 6) {
                            date = start_datetime.subtract(1, 'days').format('YYYY-MM-DD');
                        }
                        if (!groupedData[date]) {
                            groupedData[date] = {};
                        }
                        if (!groupedData[date][item.well_name]) {
                            groupedData[date][item.well_name] = {
                                totalKwh: 0,
                                totalRunningMinute: 0,
                                totalshutdown:0,
                                rows: []
                            };
                        }
                        var total_running_minute = parseFloat(item.total_running_minute);
                        groupedData[date][item.well_name].totalKwh += parseFloat(item.total_kwh);
                        groupedData[date][item.well_name].totalRunningMinute += total_running_minute;
                        groupedData[date][item.well_name].totalshutdown = item.running_minutes;
                        groupedData[date][item.well_name].well_type = item.well_type;
                        groupedData[date][item.well_name].start_datetime = item.start_datetime;
                        groupedData[date][item.well_name].compare_datetime = item.compare_datetime;
                        groupedData[date][item.well_name].total_running_required = item.total_running_required;
                        groupedData[date][item.well_name].rows.push({
                            well_name: item.well_name,
                            start_datetime: item.start_datetime,
                            end_datetime: item.end_datetime,
                            total_running_minute: total_running_minute,
                            total_shut_down: item.running_minutes,
                            total_kwh: parseFloat(item.total_kwh),
                            well_type:item.well_type,
                            required_running:item.total_running_required,
                            compare_datetime:item.compare_datetime
                        });


                    });

                      // --------------------------
                    var currentDate = moment();
                    var current_date = currentDate.format('YYYY-MM-DD');
                    var current_dateTime = moment(current_date + ' 06:00:00');
                    var differenceInMinutes = currentDate.diff(current_dateTime, 'minutes');

                    // --------------------------

                     var serialNumber = 1; 

                    Object.keys(groupedData).forEach(function(date) {
                        Object.keys(groupedData[date]).forEach(function(well) {
                            var wellData = groupedData[date][well];

                             // ----------------------
                               var SDTime = wellData.compare_datetime;
                               

                                if(SDTime === current_date)
                                {
                                    if(wellData.well_type == 1)
                                    {
                                        var remainingMinutes = wellData.total_running_required - wellData.totalRunningMinute;
                                        var scheduled_minutes = wellData.total_running_required;
                                    }else{
                                        var remainingMinutes = differenceInMinutes - wellData.totalRunningMinute;
                                        var scheduled_minutes = differenceInMinutes;
                                    }
                                    
                                }else{
                                    var remainingMinutes = wellData.totalshutdown - wellData.totalRunningMinute;

                                    var scheduled_minutes = wellData.totalshutdown;
                                }
                             // ----------------------

                            // var remainingMinutes = wellData.totalshutdown - wellData.totalRunningMinute;
            
                                var hours = Math.floor(remainingMinutes / 60);
                                var minutes = remainingMinutes % 60;

                                
                                if(remainingMinutes < 0)
                                {
                                    var hours = Math.floor(Math.abs(remainingMinutes) / 60);
                                    var minutes = Math.abs(remainingMinutes) % 60;
                                    if(hours > 0)
                                    {
                                        var duration2 = "0 Hrs (Extra " + hours + ' Hrs ' + minutes + ' Min ) '
                                    }else{
                                        var duration2 = "0 Hrs (Extra " + minutes + ' Min ) '
                                    }
                                    
                                }else{
                                    var duration2 = hours + ' Hrs ' + minutes + ' Min';
                                }

                                var  Totalminute =  wellData.totalRunningMinute;

                                var hours = Math.floor(Totalminute / 60);
                                var minutes = Totalminute % 60;
                                var duration3 = hours + ' Hrs ' + minutes + ' Min';

                                all_minutes_sum += Totalminute;
                                all_shutdown_sum += parseFloat(Math.abs(remainingMinutes));

                                var schdule_hours = Math.floor(scheduled_minutes/60);
                                var s_minutes = scheduled_minutes % 60;
                                var duration4 = schdule_hours + ' Hrs ' + s_minutes + ' Min';

                                all_minutes_schdule_sum += parseFloat(scheduled_minutes);

                                

                                wellData.rows.forEach(function(row) {

                                 
                                var hours = Math.floor(row.total_running_minute / 60);
                                var minutes = row.total_running_minute % 60;
                                var duration = hours + ' Hrs ' + minutes + ' Min';

                                var well_name = row.well_name;
                                $('#well_name').text(well_name);
                                
                               
                                $('#table_data').append('<tr>' +
                                    '<td>' + (serialNumber++) + '</td>' +
                                    '<td>' + moment(row.start_datetime).format('DD-MM-YYYY h:mm:ss a') + '</td>' +
                                    '<td>' + moment(row.end_datetime).format('DD-MM-YYYY h:mm:ss a') + '</td>' +
                                      '<td></td>'+
                                    '<td>' + duration + '</td>' +
                                    '<td></td>'+
                                    '<td>' + row.total_kwh + '</td>' +
                                    '</tr>');
                            });
                            $('#table_data').append('<tr>' +
                                '<td colspan="3" style="color:black;"><b>Total</b></td>' +
                                '<td><b>'+duration4+'</b></td>'+
                                '<td><b>' + duration3 + '</b></td>' +
                                '<td><b>' + duration2 + '</b></td>' +
                                '<td><b>' + wellData.totalKwh.toFixed(2) + '</b></td>' +
                                '</tr>');
                            all_kwh_sum += wellData.totalKwh;
                            

                        });

                    });

                    var total_hours = Math.floor(all_minutes_sum / 60);
                    var remaining_minutes = all_minutes_sum % 60;
                    var total_duration = total_hours + ' Hr ' + remaining_minutes + ' Minute';

                    var total_schdule_hours = Math.floor(all_minutes_schdule_sum / 60);
                    var remaining_schdule_minutes = all_minutes_schdule_sum % 60;
                    var total_duration_schdule = total_schdule_hours + ' Hr ' + remaining_schdule_minutes + ' Minute';

                     var total_hours = Math.floor(all_shutdown_sum / 60);
                    var remaining_minutes = all_shutdown_sum % 60;
                    var total_duration_shutdown = total_hours + ' Hr ' + remaining_minutes + ' Minute';
            
                     $("#table_data").append('<tr>' +
                        '<td colspan="3" style="text-align:right;"><b>Total</b></td>' +
                        '<td><b>' + total_duration_schdule + '</b></td>' +
                       '<td><b>' + total_duration + '</b></td>' +
                       '<td><b>' + total_duration_shutdown + '</b></td>' +
                       '<td><b>' + all_kwh_sum.toFixed(2) + ' Kwh</b></td>' +
                        '</tr>'
                        );

                } else {
                    $('#table_data').html('<tr>' +
                        '<td class="text-danger" style="text-align:center;" colspan="7">No Record Found !!</td>' +
                        '</tr>');
                }
            }
        }
    });
}


</script>

<script type="text/javascript">
	
	 setInterval(()=>{
        get_well_running_report();
    },60000);
</script>

<script src="<?php echo base_url(); ?>assets/local/excel/xlsx.full.min.js"></script>
<script type="text/javascript">
	
	function export_report() {

	  var sheetName = "Sheet1";
	  var fileName = 'Well Running Report .xlsx';
	  var table = $("#basic-datatable")[0];
	  // Convert table to worksheet
	  var ws = XLSX.utils.table_to_sheet(table);
	  // Create a new workbook and add the worksheet to it
	  var wb = XLSX.utils.book_new();
	  XLSX.utils.book_append_sheet(wb, ws, sheetName);
	  // Save the workbook as an Excel file and download it
	  XLSX.writeFile(wb, fileName);
	}

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
    function printDate() {
        var printDiv = "#GFG"; 
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