<div class="page-wrapper">
<!-- Page Content -->
    <div class="content container-fluid" style=" margin-top: -22px;">
    	<!-- Page Header -->
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
                                    <button class="btn btn-sm  btn-primary" id="well_wise_pdf" onclick="printdetails();" style="display: none;">PDF</button>
                                    <button id="date_wise_export" style="display: none;" class="btn btn-sm  btn-success" onclick="export_date_wise_report();">Export</button>
                                    <button class="btn btn-sm  btn-primary" id="date_wise_pdf" onclick="printDate();"style="display: none;">PDF</button>

                                    <butten id="commulative_wise_export" style="display:none;" class="btn btn-sm btn-success" onclick="export_commulative_report();">Export</butten>

                                     <button class="btn btn-sm  btn-primary" id="commulative_wise_pdf" onclick="printcommulative();"style="display: none;">PDF</button>

                                    <butten id="period_wise_export" style="display:none;" class="btn btn-sm btn-success" onclick="export_period_report();">Export</butten>
                                    <button class="btn btn-sm  btn-primary" id="period_wise_pdf" onclick="printpriod();"style="display: none;">PDF</button>
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
									</select>
								</div>
								<div class="form-group col-md-4 mt-2">
                                    <h5><b>Area Name</b></h5>
                                    <select name="site_id" id="site_id" class="form-control select2" onchange="datewise_running_list();commulative_running_list();get_well_list();get_feeder_list();get_feeder_data();">
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
							<div class="row">
								<div class="form-group col-md-4 mt-2" style="display:none;" id="filter_date">
									<h5><b>Date</b></h5>
									<input type="date" name="date" id="date" class="form-control" value="<?= date('Y-m-d',time()); ?>" onchange="datewise_running_list();get_date();">
								</div>

								
							</div>	
							</div>
						<div class="card-body" >
                            <div class="row" id="filter_table" style="display:none;">
								<div class="form-group col-md-3 mt-2">
									<h5><b>Well No</b></h5>
									<select name="well_id" id="well_id" class="form-control select2" onchange="commulative_running_list();">
										<option value=""> All Well </option>
									</select>
								</div>

								<div class="form-group col-md-3 mt-2">
								    <h5><b>From Date</b></h5>
								    <input type="date" name="from_date" id="from_date" value="<?php echo date('Y-m-d'); ?>" class="form-control" onchange="commulative_running_list();">
								</div>

								<div class="form-group col-md-3 mt-2">
								    <h5><b>To Date</b></h5>
								    <input type="date" name="to_date" id="to_date"  value="<?php echo date('Y-m-d'); ?>" class="form-control" onchange="commulative_running_list();">
								</div>


								
							</div>
							
                            <div id="GFGdetails">
                            	<div class="card-body" id="details_report" style="display:none;">
							    <div class="table-responsive mt-4"   id="well_wise_table_export">
								<table class="table table-bordered border-bottom">
									<thead class="bg-light text-center">
										<tr>
											<th colspan="8" class="text-uppercase" style="font-size: 20px;font-weight: bolder;">IOT Based Real Time Well Monitoring System ONGC,CAMBAY Asset</th>
										</tr>
										<tr>
											<th colspan="8" class="text-uppercase" style="font-size: 15px;font-weight: bolder;" id="details_heading"></th>
										</tr>
										</thead>
									</table>
									<table class="table table-bordered border-bottom">
										<tr>
											<th style="width:10%;">Sl No.</th>
											<th>Well Name</th>
											<th>Site name</th>
											<th>Total Running Hours</th>
											<th>Shut Down Hours</th>
										</tr>
									
									<tbody class="text-center" id="table_data">							
										
									</tbody>
								</table>
							</div>
						</div>
					</div>
                          <div id="GFGCom">
                          	<div class="card-body" id="commulative_report"  style="display:none;">
							<div class="table-responsive mt-4"  id="commulative_wise_table_export">
								<table class="table table-bordered border-bottom">
									<thead class="bg-light text-center">
										<tr>
											<th colspan="7" class="text-uppercase" style="font-size: 20px;font-weight: bolder;">IOT Based Real Time Well Monitoring System ONGC,CAMBAY Asset</th>
										</tr>
										<tr>
											<th colspan="7" class="text-uppercase" style="font-size: 15px;font-weight: bolder;" id="commulative_heading"></th>
										</tr>
									</thead>
								</table>
								<table class="table table-bordered border-bottom">
										<tr>
											<th class="text-center" style="width:10%;">Sl No.</th>
      <th class="text-center">Well Name</th>
      <th class="text-center">Site name</th>
      <th class="text-center">Total Hours</th>
      <th class="text-center">Total Running Hours</th>
      <th class="text-center">Shut Down Hours</th>
										</tr>

								
									<tbody class="text-center" id="commulative_data">							
										
									</tbody>
								</table>
							</div>
						</div>

						
					</div>

						<!-- ============== date wise running log =============== -->
                       <div id="GFGdata">
						<div class="" id="date_wise_table" style="display:none;">
							
							<div class="table-responsive" id="date_wise_table_export">
								<table class="table table-bordered border-bottom">
									<thead class="bg-light text-center">
										<tr>
											<th colspan="6" class="text-uppercase" style="font-size: 20px;font-weight: bolder;">IOT Based Real Time Well Monitoring System ONGC,CAMBAY Asset</th>
										</tr>
										<tr>
											<th colspan="6" class="text-uppercase" style="font-size: 15px;font-weight: bolder;" id="date_heading"></th>
										</tr>
									</thead>
									</table>
								   <table class="table table-bordered border-bottom">
  <thead>
    <tr>
      <th class="text-center" style="width:10%;">Sl No.</th>
      <th class="text-center">Well Name</th>
      <th class="text-center">Site name</th>
      <th class="text-center">Total Hours</th>
      <th class="text-center">Total Running Hours</th>
      <th class="text-center">Shut Down Hours</th>
    </tr>
  </thead>
  <tbody class="text-center" id="date_table_data">			
  </tbody>
</table>

							</div>
						</div>
					</div>

						<!------------- period wise well report ----------------------------------->
					<!-----<div id="GFGPeriod">
						<div class="card-body" id="period_wise" style="display:none;">
						    <div class="table-responsive mt-4" id="period_wise_table_export">
								<table class="table table-bordered border-bottom" >
									<thead class="bg-light text-center">
										<tr>
											<th colspan="7" class="text-uppercase" style="font-size: 20px;font-weight: bolder;">IOT Based Real Time Well Monitoring System ONGC,CAMBAY Asset</th>
										</tr>
										<tr>
											<th colspan="7" class="text-uppercase" style="font-size: 15px;font-weight: bolder;" id="period_heading"></th>
										</tr>
									</thead>
								</table>
								<table class="table table-bordered border-bottom">
										<tr>
											<th style="width:10%;">Sl No.</th>
											<th>Well Name</th>
											<th>Schedule Hours</th>
											<th>Total Running Hours</th>
											<th>Shut Down Hours</th>
											<th>Total Energy Consumption(Kwh)</th>
											<th>Remarks</th>
										</tr>
									
									<tbody class="text-center" id="period_data">							
										
									</tbody>
								</table>
							</div>
                        </div>
					</div>  ----->
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
			 
			 $('#well_id').val('').change();

			 $('#commulative_wise_pdf').show();
			 
			 $('#well_wise_pdf').hide();
			 $('#date_wise_pdf').hide();
			 
			 commulative_running_list();

			 
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
			 	
			 	$('#well_id').val('').change();
	
			 	$('#commulative_wise_pdf').hide();
				
				$('#well_wise_pdf').show();
				$('#date_wise_pdf').hide();
			 


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
			    
			
			    $('#commulative_wise_pdf').hide();
				
				$('#well_wise_pdf').hide();
				$('#date_wise_pdf').hide();
			 


			
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
			$('#commulative_wise_pdf').hide();
			
			$('#well_wise_pdf').hide();
			$('#date_wise_pdf').show();
		 

			
		}else if(value == 'period')
		{
			$('#well_wise_table').hide();
			$('#date_wise_table').hide();
			$('#filter_date').hide();
			$('#well_wise_export').hide();
			$('#date_wise_export').hide();
			$('#details_report').hide();
			$('#commulative_report').hide();
			$('#filter_table').show();
			$('#commulative_wise_export').hide();
			$('#period_wise').show();
			$('#datewise_sorting').hide();
			$('#detail_wise_sorting').hide();
			$('#commulative_wise_sorting').hide();
			$('#well_id').val('').change();
			$('#period_wise_export').show();
			$('#period_wise_pdf').show();
			$('#commulative_wise_pdf').hide();
			$('#well_wise_pdf').hide();
			$('#date_wise_pdf').hide();
			
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
			
			$('#commulative_wise_pdf').hide();
			$('#well_wise_pdf').hide();
			$('#date_wise_pdf').hide();
			
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
        url: '<?php echo base_url();?>Running_log_selfflow_c/Well_list',
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
        url: '<?php echo base_url();?>Running_log_selfflow_c/feeder_list',
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

    


function formatToHrMin(minutes) {
    const hrs = Math.floor(minutes / 60);
    const mins = minutes % 60;
    return `${hrs} Hr ${mins} Min`;
}


	datewise_running_list();
function datewise_running_list() {
    $('#date_table_data').html('<tr><td colspan="6">Processing, please wait...</td></tr>');

    const date = $('#date').val();
    const site_id = $('#site_id').val();
    const sort_by = $('#sort_by_date').val();
    const feeder_id = $('#feeder_id').val();

    const selectedsiteName = $('#site_id option:selected').text();
    const selectedfeederName = $('#feeder_id option:selected').text();
    const formattedToDate = moment(date, 'YYYY-MM-DD').format('DD-MM-YYYY');
    const headingText = `Date Wise ${selectedsiteName} ${selectedfeederName} Running Log Report of ${formattedToDate}`;
    $('#date_heading').text(headingText);

    $.ajax({
        url: '<?php echo base_url(); ?>Running_log_selfflow_c/get_datewise_running_report',
        method: 'POST',
        data: { date, site_id, sort_by, feeder_id },
        success: function (res) {
            const response = JSON.parse(res);
            if (response.response_code === 200) {
                $('#date_table_data').html("");
                console.log('date_wise', response);

                if (response.data.length > 0) {
                    let total_kwh_sum = 0;
                    let total_minutes_sum = 0;
                    let total_shutdown_minute = 0;
                    let total_schedule_minute = 0;

                    response.data.forEach(function (v, i) {
                        const total_running_minute = parseFloat(v.total_running_minute) || 0;
                        const max_possible_minutes = parseInt(v.max_possible_minutes) || 0;
                        const total_consumption = parseFloat(v.total_consumption) || 0;
                        const remarks = v.remarks || 'NA';

                        const shutdown_minutes = Math.max(0, max_possible_minutes - total_running_minute);

                        total_minutes_sum += total_running_minute;
                        total_schedule_minute += max_possible_minutes;
                        total_shutdown_minute += shutdown_minutes;
                        total_kwh_sum += total_consumption;

                        const duration = `${Math.floor(total_running_minute / 60)} Hrs ${total_running_minute % 60} Min`;
                        const duration_shut_down = remarks !== 'Temporary Off Well'
                            ? `${Math.floor(shutdown_minutes / 60)} Hrs ${shutdown_minutes % 60} Min`
                            : '0 Hrs 0 Min';

                        $('#date_table_data').append(`<tr>
                            <td>${i + 1}</td>
                            <td>${v.well_name || 'NA'}</td>
                            <td>${v.well_site_name || 'NA'}</td>
                           <td>${formatToHrMin(max_possible_minutes)}</td>

                            <td>${duration}</td>
                            <td>${duration_shut_down}</td>
                        </tr>`);
                    });

                    const Total_SHM = `${Math.floor(total_schedule_minute / 60)} Hr ${total_schedule_minute % 60} Min`;
                    const total_duration = `${Math.floor(total_minutes_sum / 60)} Hr ${total_minutes_sum % 60} Min`;
                    const total_duration_shutdown = `${Math.floor(total_shutdown_minute / 60)} Hr ${total_shutdown_minute % 60} Min`;

                    $('#date_table_data').append(`<tr>
                        <td colspan="3" style="text-align:right;"><b>Total</b></td>
                        <td><b>${Total_SHM}</b></td>
                        <td><b>${total_duration}</b></td>
                        <td><b>${total_duration_shutdown}</b></td>
                    </tr>`);
                } else {
                    $('#date_table_data').html(`<tr>
                        <td class="text-danger text-center" colspan="6">No Record Found !!</td>
                    </tr>`);
                }
            }
        }
    });
}
	function commulative_running_list() {
    $('#commulative_data').html('<tr><td colspan="6">Processing, please wait...</td></tr>');

    var from_date = $('#from_date').val();
    var to_date = $('#to_date').val();
    var well_id = $('#well_id').val();
    var site_id = $('#site_id').val();

    // alert(from_date);
    // alert(to_date);
    // alert(well_id);

    $.ajax({
        url: '<?php echo base_url(); ?>Running_log_selfflow_c/get_well_commulative_log_report',
        method: 'POST',
        data: {
            from_date: from_date,
            to_date: to_date,
            well_id: well_id,
            site_id: site_id
        },
        success: function (res) {
            var response = (typeof res === 'string') ? JSON.parse(res) : res;

            if (response.status && response.response_code === 200) {
                $('#commulative_data').html("");

                if (response.data.length > 0) {
                    let total_possible_minutes = 0;
                    let total_actual_minutes = 0;
                    let total_shutdown_minutes = 0;

                    $.each(response.data, function (i, v) {
                        let max_possible_minutes = parseFloat(v.max_possible_minutes || 0);
                        let actual_running_minutes = parseFloat(v.t_minute || 0);
                        let shutdown_minutes = max_possible_minutes - actual_running_minutes;

                        total_possible_minutes += max_possible_minutes;
                        total_actual_minutes += actual_running_minutes;
                        total_shutdown_minutes += shutdown_minutes;

                        let formatted_possible = formatToHrMin(max_possible_minutes);
                        let formatted_running = formatToHrMin(actual_running_minutes);
                        let formatted_shutdown = formatToHrMin(shutdown_minutes);

                        $('#commulative_data').append(`
                            <tr>
                                <td>${i + 1}</td>
                                <td>${v.well_name || 'NA'}</td>
                                <td>${v.well_site_name || 'NA'}</td>
                                <td>${formatted_possible}</td>
                                <td>${formatted_running}</td>
                                <td>${formatted_shutdown}</td>
                            </tr>
                        `);
                    });

                    $('#commulative_data').append(`
                        <tr>
                            <td colspan="3" style="text-align:right;"><b>Total</b></td>
                            <td><b>${formatToHrMin(total_possible_minutes)}</b></td>
                            <td><b>${formatToHrMin(total_actual_minutes)}</b></td>
                            <td><b>${formatToHrMin(total_shutdown_minutes)}</b></td>
                        </tr>
                    `);

                } else {
                    $('#commulative_data').html('<tr><td class="text-danger text-center" colspan="6">No Records Found</td></tr>');
                }
            } else {
                $('#commulative_data').html('<tr><td class="text-danger text-center" colspan="6">Error: ' + response.msg + '</td></tr>');
            }
        },
        error: function () {
            $('#commulative_data').html('<tr><td class="text-danger text-center" colspan="6">API request failed!</td></tr>');
        }
    });
}

function formatToHrMin(minutes) {
    minutes = parseFloat(minutes);
    if (isNaN(minutes)) return '0 Hrs 0 Min';
    let hrs = Math.floor(minutes / 60);
    let min = Math.abs(Math.floor(minutes % 60));
    return `${hrs} Hrs ${min} Min`;
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
		function export_period_report() {
	  var sheetName = "Sheet1";
	  var fileName = "Period Running log Date Wise.xlsx";
	  var table = $("#period_wise_table_export")[0];

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
	setInterval(() => {
        if (isCurrentDate()) {
        	
            datewise_running_list();
            commulative_running_list();
        }
    }, 60000);
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

            table, th, td {
           
            border: 1px solid black !important;
            border-collapse: collapse;
        }
         table, tr, td {
           
            color:black;
            
        }

            .no-print {
                display: none;
            }
        }
    </style>
<script>
    function printDate() {
        var printDiv = "#GFGdata"; 
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

     function printcommulative() {
        var printDiv = "#GFGCom"; 
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

     function printpriod() {
        var printDiv = "#GFGPeriod"; 
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

     function printdetails() {
        var printDiv = "#GFGdetails"; 
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
	 