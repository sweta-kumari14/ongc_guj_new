<div class="page-wrapper">
<!-- Page Content -->
    <div class="content container-fluid">
    	<!-- Page Header -->
			<div class="page-header">
				<div class="row">
					<div class="col-sm-12">
						<h3 class="page-title">Temp Running Log Report</h3>
						<ul class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard_c');?>">Dashboard</a></li>
							<li class="breadcrumb-item ">Temp Running Log Report</li>
							
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
                                <h3><b>Temp Running Log Report</b></h3>
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
                                    <select name="site_id" id="site_id" class="form-control select2" onchange="datewise_running_list();get_wellwise_running_report();commulative_running_list();get_well_list();get_feeder_list();get_feeder_data();">
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
                                <div class="form-group col-md-4 mt-2" style="display:none;" id="feeder_dropdown">
								<h5><b>Feeder</b></h5>
								<select name="feeder_id" id="feeder_id" class="form-control select2" onchange="datewise_running_list();get_wellwise_running_report();commulative_running_list();get_well_list();">
									<option value="">Select Feeder</option>

								</select>
							</div>
							</div>
							<div class="row">
								<div class="form-group col-md-4 mt-2" style="display:none;" id="filter_date">
									<h5><b>Date</b></h5>
									<input type="date" name="date" id="date" class="form-control" value="<?= date('Y-m-d',time()); ?>" onchange="datewise_running_list();get_date();">
								</div>

								<div class="form-group col-md-4 mt-2" id="datewise_sorting" style="display: none;">
								    <h5><b>Sort By</b></h5>
								    <select class="form-control select2" name="sort_by_date" id="sort_by_date" onchange="datewise_running_list();">
								    	<option value="">Select Column</option>
								    	<option value="well_name">Well name</option>
								    	<!-- <option value="total_shut_down_minute">Scheduled Hours</option> -->
								    	<option value="total_running_minute">Total running Hours</option>
								    	<option value="total_consumption">Total Energy Consumption</option>

								    	
								    </select>
								</div>
							</div>
								
								
								
							</div>
						
						<div class="card-body" >
                            <div class="row" id="filter_table" style="display:none;">
								<div class="form-group col-md-3 mt-2">
									<h5><b>Well No</b></h5>
									<select name="well_id" id="well_id" class="form-control select2" onchange="get_wellwise_running_report();commulative_running_list();">
										<option value=""> All Well </option>
									</select>
								</div>

							
								
								<div class="form-group col-md-3 mt-2">
								    <h5><b>From Date</b></h5>
								    <input type="date" name="from_date" id="from_date" value="<?php echo date('Y-m-d'); ?>" class="form-control" onchange="get_wellwise_running_report();commulative_running_list();">
								</div>

								<div class="form-group col-md-3 mt-2">
								    <h5><b>To Date</b></h5>
								    <input type="date" name="to_date" id="to_date"  value="<?php echo date('Y-m-d'); ?>" class="form-control" onchange="get_wellwise_running_report();commulative_running_list();">
								</div>

								<div class="form-group col-md-3 mt-2" id="detail_wise_sorting" style="display:none;">
								    <h5><b>Sort By</b></h5>
								    <select class="form-control select2" name="sort_by_detail" id="sort_by_detail" onchange="get_wellwise_running_report();">
								    	<option value="">Select Column</option>
								    	<option value="well_name">Well Name</option>
								    	<option value="start_datetime">From DateTime</option>
								    	<option value="end_datetime">To DateTime</option>
								    	<option value="total_running_minute">Total Running Hours</option>
								    	<option value="total_kwh">Total energy Consumption</option>

								    	
								    </select>
								</div>

								<div class="form-group col-md-3 mt-2" id="commulative_wise_sorting" style="display:none;">
								    <h5><b>Sort By</b></h5>
								    <select class="form-control select2" name="sort_by_commulative" id="sort_by_commulative" onchange="commulative_running_list();">
								    	<option value="">Select Column</option>
								    	<option value="well_name">Well Name</option>
								    	<option value="start_datetime">Date</option>
								    	<option value="running_minutes">Scheduled Hour</option>
								    	<option value="t_minute">Total Running Hours</option>
								    	<!-- <option value="total_shutdown_min">ShutDown Hours</option> -->
								    	<option value="e_consumption">Total energy Consumption</option>
								    </select>
								</div>
							</div>
							

							<div class="table-responsive mt-4" id="details_report" style="display:none;">
								<table class="table table-bordered border-bottom" id="well_wise_table_export">
									<thead class="bg-light text-center">
										<tr>
											<th colspan="8" class="text-uppercase" style="font-size: 20px;font-weight: bolder;">IOT Based Real Time Well Monitoring System ONGC,CAMBAY Asset</th>
										</tr>
										<tr>
											<th colspan="8" class="text-uppercase" style="font-size: 15px;font-weight: bolder;" id="details_heading"></th>
										</tr>
										<tr>
											<th style="width:10%;">Sl No.</th>
											<th>Well Name</th>
											<th>From Date Time</th>
											<th>To Date Time</th>
											<th>Scheduled Hour</th>
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
											<th colspan="6" class="text-uppercase" style="font-size: 20px;font-weight: bolder;">IOT Based Real Time Well Monitoring System ONGC,CAMBAY Asset</th>
										</tr>
										<tr>
											<th colspan="6" class="text-uppercase" style="font-size: 15px;font-weight: bolder;" id="date_heading"></th>
										</tr>
										<tr>
											<th style="width:10%;">Sl No.</th>
											<th>Well Name</th>
											<th>Scheduled Hours</th>
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
			 $('#datewise_sorting').hide();
			 $('#detail_wise_sorting').hide();
			 $('#commulative_wise_sorting').show();


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
			    $('#datewise_sorting').hide();
			    $('#detail_wise_sorting').show();
			 	$('#commulative_wise_sorting').hide();


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
			    $('#datewise_sorting').hide();
			    $('#detail_wise_sorting').hide();
			    $('#commulative_wise_sorting').hide();
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

			
			$('#datewise_sorting').show();
			$('#detail_wise_sorting').hide();
			$('#commulative_wise_sorting').hide();
			
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

			$('#datewise_sorting').hide();
			$('#detail_wise_sorting').hide();
			$('#commulative_wise_sorting').hide();
			
		}
	}

	
</script>
<script type="text/javascript">

get_well_list();
function get_well_list() { 
    let company_id = "<?php echo $this->session->userdata('company_id') ?>";
    let user_id = "<?php echo $this->session->userdata('user_id') ?>";
    let assets_id = "<?php echo $this->session->userdata('assets_id') ?>";
    let site_id = $('#site_id').val();
    let feeder_id = $('#feeder_id').val();

    $.ajax({
        type: 'POST',
        url: '<?php echo base_url();?>Temp_running_log_c/Well_list',
        data: { company_id: company_id, assets_id: assets_id, site_id: site_id, user_id: user_id,feeder_id:feeder_id },
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
    
    let site_id = $('#site_id').val();
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url();?>Temp_running_log_c/feeder_list',
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
    $('#table_data').html('<tr><td colspan="8">Processing please wait.......</td></tr>');
    let user_id = "<?php echo $this->session->userdata('user_id') ?>";
    var from_date = $('#from_date').val();
    var to_date = $('#to_date').val();
    var well_id = $('#well_id').val();
    var site_id = $('#site_id').val();
    var sort_by = $('#sort_by_detail').val();
    let feeder_id = $('#feeder_id').val();
    

    var selectedwellName = $('#well_id option:selected').text();
    var selectedfeederName = $('#feeder_id option:selected').text();
    let formattedFromDate = moment(from_date, 'YYYY-MM-DD').format('DD-MM-YYYY');
    let formattedToDate = moment(to_date, 'YYYY-MM-DD').format('DD-MM-YYYY');

    var selectedsiteName = $('#site_id option:selected').text();
   


    let headingText = ` ${selectedsiteName} ${selectedfeederName} ${selectedwellName} Details Temp Running Log Report ${formattedFromDate} to ${formattedToDate}   `;
         $('#details_heading').text(headingText);
  
    
    $.ajax({
        url: '<?php echo base_url(); ?>Temp_running_log_c/get_well_wise_report',
        method: 'POST',
        data: { user_id: user_id, well_id: well_id, from_date: from_date, to_date: to_date, site_id: site_id,sort_by: sort_by,feeder_id:feeder_id},
        success: function(res) {
            var response = JSON.parse(res);
            
            if (response.response_code == 200) {
                $('#table_data').html("");
                if (response.data.length > 0) {
                    var groupedData = {};
                    var all_minutes_sum = 0;
                    var all_shutdown_sum = 0;
                    var all_kwh_sum = 0;
                    var total_duration_schdule =0;
                    var scheduled_minutes = 0;

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
                            start_datetime:item.start_datetime
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

                                all_minutes_sum += parseFloat(Totalminute);
                                all_shutdown_sum += parseFloat(Math.abs(remainingMinutes));

                                var schdule_hours = Math.floor(scheduled_minutes/60);
                                var s_minutes = scheduled_minutes % 60;
                                var duration4 = schdule_hours + ' Hrs ' + s_minutes + ' Min';

                                all_minutes_schdule_sum += parseFloat(scheduled_minutes);

                            wellData.rows.forEach(function(row) {
 
                                var hours = Math.floor(row.total_running_minute / 60);
                                var minutes = row.total_running_minute % 60;
                                var duration = hours + ' Hrs ' + minutes + ' Min';
                           
                                $('#table_data').append('<tr>' +
                                    '<td>' + (serialNumber++) + '</td>' +
                                    '<td>' + row.well_name + '</td>' +
                                    '<td>' + moment(row.start_datetime).format('DD-MM-YYYY h:mm:ss a') + '</td>' +
                                    '<td>' + moment(row.end_datetime).format('DD-MM-YYYY h:mm:ss a') + '</td>' +
                                    '<td></td>'+
                                    '<td>' + duration + '</td>' +
                                    '<td></td>'+
                                    '<td>' + row.total_kwh + '</td>' +
                                    '</tr>');
                            });
                            $('#table_data').append('<tr>' +
                                '<td colspan="4" style="color:black;"><b>Total</b></td>' +
                                '<td><b>'+duration4+'</b></td>'+
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

                     var total_schdule_hours = Math.floor(all_minutes_schdule_sum / 60);
                    var remaining_schdule_minutes = all_minutes_schdule_sum % 60;
                    var total_duration_schdule = total_schdule_hours + ' Hr ' + remaining_schdule_minutes + ' Minute';

                     var total_hours = Math.floor(all_shutdown_sum / 60);
                    var remaining_minutes = all_shutdown_sum % 60;
                    var total_duration_shutdown = total_hours + ' Hr ' + remaining_minutes + ' Minute';
            
                     $("#table_data").append('<tr>' +
                        '<td colspan="4" style="text-align:right;"><b>Total</b></td>' +
                        '<td><b>' + total_duration_schdule + '</b></td>' +
                       '<td><b>' + total_duration + '</b></td>' +
                       '<td><b>' + total_duration_shutdown + '</b></td>' +
                       '<td><b>' + all_kwh_sum.toFixed(2) + ' Kwh</b></td>' +
                        '</tr>'
                        );

                } else {
                    $('#table_data').html('<tr>' +
                        '<td class="text-danger" style="text-align:center;" colspan="8">No Record Found !!</td>' +
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
    var sort_by = $('#sort_by_date').val();
    let feeder_id = $('#feeder_id').val();


    var selectedsiteName = $('#site_id option:selected').text();
    var selectedfeederName = $('#feeder_id option:selected').text();
   
    let formattedToDate = moment(date, 'YYYY-MM-DD').format('DD-MM-YYYY');
    let headingText = `Date Wise ${selectedsiteName} ${selectedfeederName} Temp Running Log Report of  ${formattedToDate}   `;
         $('#date_heading').text(headingText);
  
   
    $.ajax({
        url: '<?php echo base_url(); ?>Temp_running_log_c/get_datewise_running_report',
        method: 'POST',
        data: { date: date,site_id:site_id,sort_by:sort_by,feeder_id:feeder_id },
        success: function (res) {
            var response = JSON.parse(res);
       
            if (response.response_code == 200) {
                $('#date_table_data').html("");
                if (response.data.length > 0) {
                    var total_kwh_sum = 0;
                    var total_minutes_sum = 0;
                    var total_shutdown_minute = 0;
                    var total_schedule_minute = 0;
                    $.each(response.data, function (i, v) {
                        var total_running_minute = v.total_running_minute;
                        total_minutes_sum += parseFloat(total_running_minute);
                        

                        var scheduled_hrs = parseInt(v.total_shut_down_minute);
                        var S_hours = Math.floor(scheduled_hrs / 60);
                        var S_minutes = scheduled_hrs % 60;
                        var Scheduled_Time = S_hours + ' Hrs ' + S_minutes + ' Min';

                        total_schedule_minute += parseInt(v.total_shut_down_minute); 


                        // Add the total_kwh to the sum
                        total_kwh_sum += parseFloat(v.total_consumption);

                        var hours = Math.floor(total_running_minute / 60);
                        var minutes = total_running_minute % 60;
                        var duration = hours + ' Hrs ' + minutes + ' Min';

                        var extra_hours = parseInt(v.total_shut_down_minute) - parseInt(v.total_running_minute);

                        var hours = Math.floor(extra_hours / 60);
                        var minutes = extra_hours % 60;

                        if(extra_hours < 0)
                        {
                        	var hours = Math.floor(Math.abs(extra_hours) / 60);
                        	var minutes = Math.abs(extra_hours) % 60;

                        	if(hours > 0)
                        	{
                        		var duration_shut_down = "0 Hrs (Extra " + hours + ' Hrs ' + minutes + ' Min ) ';
                        	}else{
                        		var duration_shut_down = "0 Hrs (Extra " + minutes + ' Min ) ';
                        	}

                        	
                        }else{
                        	var duration_shut_down = hours + ' Hrs ' + minutes + ' Min';
                        }
                        

                        total_shutdown_minute += parseFloat(Math.abs(extra_hours));

                        $("#date_table_data").append('<tr>' +
                            '<td>' + (i + 1) + '</td>' +
                            '<td>' + v.well_name + '</td>' +
                            '<td>' + Scheduled_Time+ '</td>' +
                            '<td>' + duration+ '</td>' +
                            '<td>' + duration_shut_down + '</td>' +
                            '<td>' + v.total_consumption + '</td>' +
                            '</tr>');
                    });

                    
                    var Total_SH = Math.floor(total_schedule_minute / 60);
                    var Total_SM = total_schedule_minute % 60;
                    var Total_SHM = Total_SH + ' Hr ' + Total_SM + ' Minute';

                    // Convert total minutes to hours and minutes
                    var total_hours = Math.floor(total_minutes_sum / 60);
                    var remaining_minutes = total_minutes_sum % 60;
                    var total_duration = total_hours + ' Hr ' + remaining_minutes + ' Minute';

                    var total_hours = Math.floor(total_shutdown_minute / 60);
                    var remaining_minutes = total_shutdown_minute % 60;
                    var total_duration_shutdown = total_hours + ' Hr ' + remaining_minutes + ' Minute';
            
                     $("#date_table_data").append('<tr>' +
                        '<td colspan="2" style="text-align:right;"><b>Total</b></td>' +
                        '<td><b>' + Total_SHM + '</b></td>' +
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
    var sort_by = $('#sort_by_commulative').val();
    let feeder_id = $('#feeder_id').val();

    var selectedfeederName = $('#feeder_id option:selected').text();
    var selectedsiteName = $('#site_id option:selected').text();
    var selectedwellName = $('#well_id option:selected').text();
    let formattedFromDate = moment(from_date, 'YYYY-MM-DD').format('DD-MM-YYYY');
    let formattedToDate = moment(to_date, 'YYYY-MM-DD').format('DD-MM-YYYY');

    let headingText = ` ${selectedsiteName} ${selectedfeederName} ${selectedwellName} Commulative Temp Running Log Report ${formattedFromDate} to ${formattedToDate}   `;
         $('#commulative_heading').text(headingText);
  

    $.ajax({
        url: '<?php echo base_url(); ?>Temp_running_log_c/get_well_commulative_log_report',
        method: 'POST',
        data: { from_date: from_date,to_date:to_date,well_id:well_id,site_id:site_id ,sort_by:sort_by,feeder_id:feeder_id},
        success: function (res) {
            var response = JSON.parse(res);
            
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
                        var total_shut_down_running = parseInt(v.total_shutdown_min);

                        var hours = Math.floor(total_shut_down_running / 60);
                        var minutes = total_shut_down_running % 60;

                        if(total_shut_down_running < 0)
                        {
                        	var hours = Math.floor(Math.abs(total_shut_down_running) / 60);
                        	var minutes = Math.abs(total_shut_down_running) % 60;
                        	if(hours > 0)
                        	{
                        		var duration_shut_down = "0 Hrs (Extra " + hours + ' Hrs ' + minutes + ' Min ) '
                        	}else{
                        		var duration_shut_down = "0 Hrs (Extra " + minutes + ' Min ) '
                        	}
                        	
                        }else{
                        	var duration_shut_down = hours + ' Hrs ' + minutes + ' Min';
                        }

                        total_shutdown_minute += parseFloat(Math.abs(total_shut_down_running));


                        var total_running = parseInt(v.running_minutes);
                       
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
        commulative_running_list();
    },60000);
</script>