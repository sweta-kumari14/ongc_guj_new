<div class="page-wrapper">
<!-- Page Content -->
    <div class="content container-fluid">
    	<!-- Page Header -->
			<div class="page-header">
				<div class="row">
					<div class="col-sm-12">
						<h3 class="page-title">Running Log Report</h3>
						<ul class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard_c');?>">Dashboard</a></li>
							<li class="breadcrumb-item ">Running Log Report</li>
							
						</ul>
					</div>
				</div>
			</div>

		    <div class="row row-sm">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-body">
						<div class="row">
                            <div class="col-md-6">
                                <h3><b>Running Log Report</b></h3>
                            </div>
                            <div class="col-md-6 d-md-flex justify-content-end">
                                <div>
                                    <button id="well_wise_export" style="display: none;" class="btn btn-sm  btn-success" onclick="export_well_wise_report();">Export</button>
                                    <button id="date_wise_export" style="display: none;" class="btn btn-sm  btn-success" onclick="export_date_wise_report();">Export</button>
                                    <butten id="commulative_wise_export" style="display:none;" class="btn btn-sm btn-success" onclick="export_commulative_report();">Export</butten>
                                    <a href="<?php echo base_url('Dashboard_c');?>"><button class="btn btn-sm  btn-primary mx-2">Back</button></a>

                                </div>
                            </div>
                    	</div>
                    	<div class="row">
                    	    
								<div class="form-group col-md-4 mt-2">
									<h5><b>View Report</b></h5>
									<select name="report_view" id="report_view" class="form-control select2" onchange="get_view();">
										<option value=""> Select View </option>
										<option value="well">Well Wise</option>
										<option value="date">Date Wise</option>
									</select>
								</div>
							

                            	<div class="form-group col-md-4 mt-2"  id="well_wise_table" style="display:none;">
									<h5><b>View Report</b></h5>
									<select name="report_type" id="report_type" class="form-control select2" onchange="get_view();">
										<option value=""> Select Report Type </option>
										<option value="commulative">Commulative report</option>
										<option value="details">Details Report</option>
									</select>
								</div>
								<div class="form-group col-md-4 mt-2">
                                    <h5><b>Area Name</b></h5>
                                    <select name="site_id" id="site_id" class="form-control select2" onchange="datewise_running_list();get_wellwise_running_report();commulative_running_list();">
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
							</div>
								<div class="form-group col-md-4 mt-2" style="display:none;" id="filter_date">
									<h5><b>Date</b></h5>
									<input type="date" name="date" id="date" class="form-control" value="<?= date('Y-m-d',time()); ?>" onchange="datewise_running_list();get_date();">
								</div>
								
								
							</div>
						
						<div class="card-body" >
                            <div class="row" id="filter_table" style="display:none;">
								<div class="form-group col-md-4 mt-2">
									<h5><b>Well No</b></h5>
									<select name="well_id" id="well_id" class="form-control select2" onchange="get_wellwise_running_report();commulative_running_list();">
										<option value=""> All Well </option>
										<?php 
										if (!empty($well_list))
										{
											foreach ($well_list as $key => $value)
											{
												?>
													<option value="<?php echo $value['well_id']; ?>"><?php echo $value['well_name']; ?></option>

												<?php
											}
										}
										?>
									</select>
								</div>

							
								
								<div class="form-group col-md-4 mt-2">
								    <h5><b>From Date</b></h5>
								    <input type="date" name="from_date" id="from_date" value="<?php echo date('Y-m-d'); ?>" class="form-control" onchange="get_wellwise_running_report();commulative_running_list();">
								</div>

								<div class="form-group col-md-4 mt-2">
								    <h5><b>To Date</b></h5>
								    <input type="date" name="to_date" id="to_date"  value="<?php echo date('Y-m-d'); ?>" class="form-control" onchange="get_wellwise_running_report();commulative_running_list();">
								</div>
							</div>
							

							<div class="table-responsive mt-4" id="details_report" style="display:none;">
								<table class="table table-bordered border-bottom" id="well_wise_table_export">
									<thead class="bg-light text-center">
										<tr>
											<th colspan="7" class="text-uppercase" style="font-size: 20px;font-weight: bolder;">IOT Based Real Time Well Monitoring System ONGC,CAMBAY Asset</th>
										</tr>
										<tr>
											<th colspan="7" class="text-uppercase" style="font-size: 15px;font-weight: bolder;" id="details_heading"></th>
										</tr>
										<tr>
											<th style="width:10%;">Sl No.</th>
											<th>Well Name</th>
											<th>From Date Time</th>
											<th>To Date Time</th>
											<th>Total Running Hours</th>
											<th>Shut Down Hours</th>
											<th>Total Energy Consumption(Kwh)</th>
										</tr>
									</thead>
									<tbody class="text-center" id="table_data">							
										
									</tbody>
								</table>
							</div>

							<div class="table-responsive mt-4" id="commulative_report" style="display:none;">
								<table class="table table-bordered border-bottom" id="commulative_wise_table_export">
									<thead class="bg-light text-center">
										<tr>
											<th colspan="7" class="text-uppercase" style="font-size: 20px;font-weight: bolder;">IOT Based Real Time Well Monitoring System ONGC,CAMBAY Asset</th>
										</tr>
										<tr>
											<th colspan="7" class="text-uppercase" style="font-size: 15px;font-weight: bolder;" id="commulative_heading"></th>
										</tr>
										<tr>
											<th style="width:10%;">Sl No.</th>
											<th>Well Name</th>
											<th>Date</th>
											<th>Schedule Hours</th>
											<th>Total Running Hours</th>
											<th>Shut Down Hours</th>
											<th>Total Energy Consumption(Kwh)</th>
										</tr>
									</thead>
									<tbody class="text-center" id="commulative_data">							
										
									</tbody>
								</table>
							</div>
						
					</div>

						<!-- ============== date wise running log =============== -->

						<div class="card-body" id="date_wise_table" style="display:none;">
							
							<div class="table-responsive">
								<table class="table table-bordered border-bottom" id="date_wise_table_export">
									<thead class="bg-light text-center">
										<tr>
											<th colspan="5" class="text-uppercase" style="font-size: 20px;font-weight: bolder;">IOT Based Real Time Well Monitoring System ONGC,CAMBAY Asset</th>
										</tr>
										<tr>
											<th colspan="5" class="text-uppercase" style="font-size: 15px;font-weight: bolder;" id="date_heading"></th>
										</tr>
										<tr>
											<th style="width:10%;">Sl No.</th>
											<th>Well Name</th>
											<th>Total Running Hours</th>
											<th>Shut Down Hours</th>
											<th style="width:30%;">Total Energy Consumption(Kwh)</th>
										</tr>
									</thead>
									<tbody class="text-center" id="date_table_data">							
										
									</tbody>

								</table>
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
    document.getElementById('date').value = getDefaultDateValue();
</script>

<script type="text/javascript">
	
	function get_view()
	{
		var value = $('#report_view').val();

		if (value == 'well')
		{
		   $('#well_wise_table').show();
			var value = $('#report_type').val();

			if(value == 'commulative')
			{
             
             $('#filter_table').show();
             $('#well_wise_export').hide();
             $('#date_wise_table').hide();
			 $('#filter_date').hide();
			 $('#date_wise_export').hide();
			 $('#commulative_report').show();
			 $('#details_report').hide();
			 $('#commulative_wise_export').show();

			}else if(value == 'details')
			{
				
                $('#filter_table').show();
                $('#well_wise_export').show();
                $('#date_wise_table').hide();
			    $('#filter_date').hide();
			    $('#date_wise_export').hide();
			    $('#details_report').show();
			    $('#commulative_report').hide();
			    $('#commulative_wise_export').hide();

			}else{
				$('#filter_table').hide();
                $('#brakup_details_table').hide();
                $('#well_wise_export').hide();
                $('#date_wise_table').hide();
			    $('#filter_date').hide();
			    $('#date_wise_export').hide();
			    $('#details_report').hide();
			    $('#commulative_report').hide();
			    $('#commulative_wise_export').hide();

			}
			
			
		}else if(value == 'date')
		{
			$('#well_wise_table').hide();
			$('#date_wise_table').show();
			$('#filter_date').show();
			$('#well_wise_export').hide();
			$('#date_wise_export').show();
			$('#details_report').hide();
			$('#commulative_report').hide();
			$('#filter_table').hide();
			$('#commulative_wise_export').hide();
			
		}else{
			$('#well_wise_table').hide();
			$('#date_wise_table').hide();
			$('#filter_date').hide();
			$('#well_wise_export').hide();
			$('#date_wise_export').hide();
			$('#details_report').hide();
			$('#commulative_report').hide();
			$('#filter_table').hide();
			$('#commulative_wise_export').hide();
			
		}
	}

	
</script>

<script type="text/javascript">

	
	get_date();
	function get_date()
	{
		var selected_date = $('#date').val();
		formated_date = moment(selected_date);

		if(formated_date.isValid())
		{
			$('#show_date').text(formated_date.format("DD-MM-YYYY"));
		}else{
			$('#show_date').text('');
		}

		
	}
    
get_wellwise_running_report();
function get_wellwise_running_report() {
    $('#table_data').html('<tr><td colspan="7">Processing please wait.......</td></tr>');
    let user_id = "<?php echo $this->session->userdata('user_id') ?>";
    var from_date = $('#from_date').val();
    var to_date = $('#to_date').val();
    var well_id = $('#well_id').val();
    var site_id = $('#site_id').val();

     var selectedwellName = $('#well_id option:selected').text();
    let formattedFromDate = moment(from_date, 'YYYY-MM-DD').format('DD-MM-YYYY');
    let formattedToDate = moment(to_date, 'YYYY-MM-DD').format('DD-MM-YYYY');

    var selectedsiteName = $('#site_id option:selected').text();
   


    let headingText = ` ${selectedsiteName}  ${selectedwellName} Details Running Log Report ${formattedFromDate} to ${formattedToDate}   `;
         $('#details_heading').text(headingText);
  
    
    $.ajax({
        url: '<?php echo base_url(); ?>Running_log_c/get_well_wise_report',
        method: 'POST',
        data: { user_id: user_id, well_id: well_id, from_date: from_date, to_date: to_date, site_id: site_id },
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
                        groupedData[date][item.well_name].rows.push({
                            well_name: item.well_name,
                            start_datetime: item.start_datetime,
                            end_datetime: item.end_datetime,
                            total_running_minute: total_running_minute,
                            total_shut_down: item.running_minutes,
                            total_kwh: parseFloat(item.total_kwh)
                        });


                    });

                   var serialNumber = 1; 
                       Object.keys(groupedData).forEach(function(date) {
                        Object.keys(groupedData[date]).forEach(function(well) {
                            var wellData = groupedData[date][well];
                            var remainingMinutes = wellData.totalshutdown - wellData.totalRunningMinute;
                                var hours = Math.floor(remainingMinutes / 60);
                                var minutes = remainingMinutes % 60;
                                var duration2 = hours + ' Hrs ' + minutes + ' Min';

                                var  Totalminute =  wellData.totalRunningMinute;

                                var hours = Math.floor(Totalminute / 60);
                                var minutes = Totalminute % 60;
                                var duration3 = hours + ' Hrs ' + minutes + ' Min';

                                all_minutes_sum += parseFloat(Totalminute);
                                all_shutdown_sum += parseFloat(remainingMinutes);
                            
                            wellData.rows.forEach(function(row) {
 
                                var hours = Math.floor(row.total_running_minute / 60);
                                var minutes = row.total_running_minute % 60;
                                var duration = hours + ' Hrs ' + minutes + ' Min';
                           
                                $('#table_data').append('<tr>' +
                                    '<td>' + (serialNumber++) + '</td>' +
                                    '<td>' + row.well_name + '</td>' +
                                    '<td>' + moment(row.start_datetime).format('DD-MM-YYYY h:mm:ss a') + '</td>' +
                                    '<td>' + moment(row.end_datetime).format('DD-MM-YYYY h:mm:ss a') + '</td>' +
                                    '<td>' + duration + '</td>' +
                                    '<td></td>'+
                                    '<td>' + row.total_kwh + '</td>' +
                                    '</tr>');
                            });
                            $('#table_data').append('<tr>' +
                                '<td colspan="4" style="color:black;"><b>Total</b></td>' +
                                
                                '<td><b>' + duration3 + '</b></td>' +
                                '<td><b>' + duration2 + '</b></td>' +
                                '<td><b>' + wellData.totalKwh.toFixed(2) + '</b></td>' +
                                '</tr>');
                            all_kwh_sum += parseFloat(wellData.totalKwh);
                        	

                        });

                    });

                    var total_hours = Math.floor(all_minutes_sum / 60);
                    var remaining_minutes = all_minutes_sum % 60;
                    var total_duration = total_hours + ' Hr ' + remaining_minutes + ' Minute';

                     var total_hours = Math.floor(all_shutdown_sum / 60);
                    var remaining_minutes = all_shutdown_sum % 60;
                    var total_duration_shutdown = total_hours + ' Hr ' + remaining_minutes + ' Minute';
            
                     $("#table_data").append('<tr>' +
                        '<td colspan="4" style="text-align:right;"><b>Total</b></td>' +
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


	datewise_running_list();
	function datewise_running_list() {
    $('#date_table_data').html('<tr><td colspan="5">processing please wait.......</td></tr>');
    var date = $('#date').val();
    var site_id = $('#site_id').val();

    var selectedsiteName = $('#site_id option:selected').text();
   
    let formattedToDate = moment(date, 'YYYY-MM-DD').format('DD-MM-YYYY');
    let headingText = `Date Wise ${selectedsiteName} Running Log Report of  ${formattedToDate}   `;
         $('#date_heading').text(headingText);
  
   
    $.ajax({
        url: '<?php echo base_url(); ?>Running_log_c/get_datewise_running_report',
        method: 'POST',
        data: { date: date,site_id:site_id },
        success: function (res) {
            var response = JSON.parse(res);
            console.log(response);
            if (response.response_code == 200) {
                $('#date_table_data').html("");
                if (response.data.length > 0) {
                    var total_kwh_sum = 0;
                    var total_minutes_sum = 0;
                    var total_shutdown_minute = 0;
                    $.each(response.data, function (i, v) {
                        var total_running_minute = v.total_running_minute;
                        total_minutes_sum += parseFloat(total_running_minute);
                        

                        // Add the total_kwh to the sum
                        total_kwh_sum += parseFloat(v.total_consumption);

                        var hours = Math.floor(total_running_minute / 60);
                        var minutes = total_running_minute % 60;
                        var duration = hours + ' Hrs ' + minutes + ' Min';
                         


                          var total_shut_down_running = v.total_shut_down_running_well;

                       
                       
                         var hours = Math.floor(total_shut_down_running / 60);
                        var minutes = total_shut_down_running % 60;
                        var duration_shut_down = hours + ' Hrs ' + minutes + ' Min';

                        total_shutdown_minute += parseFloat(total_shut_down_running);

                 


                        $("#date_table_data").append('<tr>' +
                            '<td>' + (i + 1) + '</td>' +
                            '<td>' + v.well_name + '</td>' +
                            '<td>' + duration+ '</td>' +
                            '<td>' + duration_shut_down + '</td>' +
                            '<td>' + v.total_consumption + '</td>' +
                            '</tr>');
                    });

                    // Convert total minutes to hours and minutes
                    var total_hours = Math.floor(total_minutes_sum / 60);
                    var remaining_minutes = total_minutes_sum % 60;
                    var total_duration = total_hours + ' Hr ' + remaining_minutes + ' Minute';

                     var total_hours = Math.floor(total_shutdown_minute / 60);
                    var remaining_minutes = total_shutdown_minute % 60;
                    var total_duration_shutdown = total_hours + ' Hr ' + remaining_minutes + ' Minute';
            
                     $("#date_table_data").append('<tr>' +
                        '<td colspan="2" style="text-align:right;"><b>Total</b></td>' +
                       '<td><b>' + total_duration + '</b></td>' +
                       '<td><b>' + total_duration_shutdown + '</b></td>' +
                       '<td><b>' + total_kwh_sum.toFixed(2) + ' Kwh</b></td>' +
                        '</tr>'
                        );
                } else {
                    $('#date_table_data').html('<tr>' +
                        '<td class="text-danger" style="text-align:center;" colspan="5">No Record Found !!</td>' +
                        '</tr>');
                }
            }
        }
    });
}

commulative_running_list();
	function commulative_running_list() {
    $('#commulative_data').html('<tr><td colspan="7">processing please wait.......</td></tr>');
    var from_date = $('#from_date').val();
    var to_date = $('#to_date').val();
    var well_id = $('#well_id').val();
    var site_id = $('#site_id').val();

    var selectedsiteName = $('#site_id option:selected').text();
    var selectedwellName = $('#well_id option:selected').text();
    let formattedFromDate = moment(from_date, 'YYYY-MM-DD').format('DD-MM-YYYY');
    let formattedToDate = moment(to_date, 'YYYY-MM-DD').format('DD-MM-YYYY');

    let headingText = ` ${selectedsiteName} ${selectedwellName} Commulative  Running Log Report ${formattedFromDate} to ${formattedToDate}   `;
         $('#commulative_heading').text(headingText);
  

    $.ajax({
        url: '<?php echo base_url(); ?>Running_log_c/get_well_commulative_log_report',
        method: 'POST',
        data: { from_date: from_date,to_date:to_date,well_id:well_id,site_id:site_id },
        success: function (res) {
            var response = JSON.parse(res);
            console.log(response);
            if (response.response_code == 200) {
                $('#commulative_data').html("");
                if (response.data.length > 0) {
                    var total_kwh_sum = 0;
                    var total_minutes_sum = 0;
                    var total_shutdown_minute = 0;
                    var total_running_minute_sum = 0;
                    $.each(response.data, function (i, v) {
                        var total_running_minute = v.t_minute;
                        total_minutes_sum += parseFloat(total_running_minute);
                        

                        // Add the total_kwh to the sum
                        total_kwh_sum += parseFloat(v.e_consumption);

                        var hours = Math.floor(total_running_minute / 60);
                        var minutes = total_running_minute % 60;
                        var duration = hours + ' Hrs ' + minutes + ' Min';
                         


                          var total_shut_down_running = v.total_shutdown_min;

                       
                       
                         var hours = Math.floor(total_shut_down_running / 60);
                        var minutes = total_shut_down_running % 60;
                        var duration_shut_down = hours + ' Hrs ' + minutes + ' Min';

                        total_shutdown_minute += parseFloat(total_shut_down_running);


                         var total_running = v.running_minutes;

                       
                       
                         var hours = Math.floor(total_running / 60);
                        var minutes = total_running % 60;
                        var duration_running = hours + ' Hrs ' + minutes + ' Min';

                        total_running_minute_sum += parseFloat(total_running);

                 


                        $("#commulative_data").append('<tr>' +
                            '<td>' + (i + 1) + '</td>' +
                            '<td>' + v.well_name + '</td>' +
                            '<td>' + moment(v.start_datetime).format('DD-MM-YYYY') + '</td>' +
                            '<td>'+ duration_running +'</td>'+
                            '<td>' + duration+ '</td>' +
                            
                            '<td>' + duration_shut_down + '</td>' +
                            '<td>' + v.e_consumption + '</td>' +
                            '</tr>');
                    });

               
                    var total_hours = Math.floor(total_minutes_sum / 60);
                    var remaining_minutes = total_minutes_sum % 60;
                    var total_duration = total_hours + ' Hr ' + remaining_minutes + ' Min';

                     var total_hours = Math.floor(total_shutdown_minute / 60);
                    var remaining_minutes = total_shutdown_minute % 60;
                    var total_duration_shutdown = total_hours + ' Hr ' + remaining_minutes + ' Min';

                     
                     var total_hours = Math.floor(total_running_minute_sum / 60);
                    var remaining_minutes = total_running_minute_sum % 60;
                    var total_duration_running = total_hours + ' Hr ' + remaining_minutes + ' Min';
            
                     $("#commulative_data").append('<tr>' +
                        '<td colspan="3" style="text-align:right;"><b>Total</b></td>' +
                        '<td><b>'+total_duration_running+'</b></td>'+
                       '<td><b>' + total_duration + '</b></td>' +
                       
                       '<td><b>' + total_duration_shutdown + '</b></td>' +
                      
                       '<td><b>' + total_kwh_sum.toFixed(2) + ' Kwh</b></td>' +
                        '</tr>'
                        );
                } else {
                    $('#commulative_data').html('<tr>' +
                        '<td class="text-danger" style="text-align:center;" colspan="7">No Record Found !!</td>' +
                        '</tr>');
                }
            }
        }
    });
}
</script>
<script src="<?php echo base_url(); ?>assets/local/excel/xlsx.full.min.js"></script>
<script type="text/javascript">
	
	function export_well_wise_report() {
	  var sheetName = "Sheet1";
	  var fileName = "Details Running Log.xlsx";
	  var table = $("#well_wise_table_export")[0];

	  // Convert table to worksheet
	  var ws = XLSX.utils.table_to_sheet(table);

	  // Create a new workbook and add the worksheet to it
	  var wb = XLSX.utils.book_new();
	  XLSX.utils.book_append_sheet(wb, ws, sheetName);

	  // Save the workbook as an Excel file and download it
	  XLSX.writeFile(wb, fileName);
	}

	function export_date_wise_report() {
	  var sheetName = "Sheet1";
	  var fileName = "Date Wise Running log Date Wise.xlsx";
	  var table = $("#date_wise_table_export")[0];

	  // Convert table to worksheet
	  var ws = XLSX.utils.table_to_sheet(table);

	  // Create a new workbook and add the worksheet to it
	  var wb = XLSX.utils.book_new();
	  XLSX.utils.book_append_sheet(wb, ws, sheetName);

	  // Save the workbook as an Excel file and download it
	  XLSX.writeFile(wb, fileName);
	}

	function export_commulative_report() {
	  var sheetName = "Sheet1";
	  var fileName = "Commulative Running log Date Wise.xlsx";
	  var table = $("#commulative_wise_table_export")[0];

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
        get_wellwise_running_report();
        datewise_running_list();
    },60000);
</script>