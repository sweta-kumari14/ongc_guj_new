
<div class="page-wrapper">
<!-- Page Content -->
    <div class="content container-fluid">
    	<!-- Page Header -->
			<div class="page-header">
				<div class="row">
					<div class="col-sm-12">
						<h3 class="page-title">Alert Log Report</h3>
						<ul class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard_c');?>">Dashboard</a></li>
							<li class="breadcrumb-item ">Alert Log Report</li>
							
						</ul>
					</div>
				</div>
			</div>
<!-- /Page Header -->
		    <div class="row row-sm">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-body">
						<div class="row">
                            <div class="col-md-6">
                                <h3><b>Alert Log Report</b></h3>
                            </div>
                            <div class="col-md-6 d-md-flex justify-content-end">
                                <div>
                                    <button id="well_wise_export" style="display: none;" class="btn btn-sm  btn-success" onclick="export_well_wise_report();">Export</button>
	                                    <button id="date_wise_export" style="display: none;" class="btn btn-sm  btn-success" onclick="export_date_wise_report();">Export</button>
	                                     <button class="btn btn-sm  btn-primary" id="well_wise_pdf" onclick="printWell();"style="display: none;">PDF</button>
	                                      <button class="btn btn-sm  btn-primary" id="date_wise_pdf" onclick="printDate();"style="display: none;">PDF</button>

	                                    <a href="Dashboard_c"><button class="btn btn-sm  btn-primary mx-2">Back</button></a>
                                </div>
                            </div>
                    	</div>
                    	</div>
                    	<hr>

                    	<div class="card-body">
							<div class="row">
								<div class="form-group col-md-4 mt-2">
									<h5><b>View Report</b></h5>
									<select name="report_view" id="report_view" class="form-control select2" onchange="get_view();">
										<option value=""> Select View </option>
										<option value="well">Well Wise</option>
										<option value="date">Date Wise</option>
									</select>
								</div>

								<div class="form-group col-md-4 mt-2" style="display:none;" id="filter_date">
									<h5><b>Date</b></h5>
									<input type="date" name="date" id="date" class="form-control" value="<?= date('Y-m-d',time()); ?>" onchange="datewise_alert_list();get_date();">
								</div>

								<div class="form-group col-md-4 mt-2" id="date_wise_sort" style="display: none;">
								    <h5><b>Sort By</b></h5>
								    <select class="form-control select2" name="sort_by_date" id="sort_by_date" onchange="datewise_alert_list();">
								    	<option value="">Select Column</option>
								    	<option value="well_site_name">Area Name</option>
								    	<option value="well_name">Well No</option>
								    	<option value="alert_type">Alert Type</option>
								    	<option value="alerts_details">Alert Details</option>
								    									    	
								    </select>
								</div>
							</div>
						</div>

						<div class="card-body" id="well_wise_table" style="display:none;">
							<div class="row">
								<div class="form-group col-md-3 mt-2">
									<h5><b>Well No</b></h5>
									<select name="well_id" id="well_id" class="form-control select2" onchange="get_wellwise_alert_report();">
										<option value=""> Select Well No </option>
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

								<div class="form-group col-md-3 mt-2">
								    <h5><b>From Date</b></h5>
								    <input type="date" name="from_date" id="from_date" class="form-control" onchange="get_wellwise_alert_report();get_well_wise_date();">
								</div>

								<div class="form-group col-md-3 mt-2">
								    <h5><b>To Date</b></h5>
								    <input type="date" name="to_date" id="to_date" class="form-control" onchange="get_wellwise_alert_report();get_well_wise_date();">
								</div>

								<div class="form-group col-md-3 mt-2" id="well_wise_sort" style="display: none;">
								    <h5><b>Sort By</b></h5>
								    <select class="form-control select2" name="sort_by_well" id="sort_by_well" onchange="get_wellwise_alert_report();">
								    	<option value="">Select Column</option>
								    	<option value="well_site_name">Area Name</option>
								    	<option value="well_name">Well No</option>
								    	<option value="alert_type">Alert Type</option>
								    	<option value="alerts_details">Alert Details</option>
								    	<option value="start_date_time">From Date</option>
								    	<option value="end_date_time">To Date</option>

								    </select>
								</div>

								
							</div>
							<div id="GFGWell">
							<div class="table-responsive mt-4" id="basic-datatable">
								<table class="table table-bordered border-bottom"  style="width: 100%;">
									<thead class="bg-light text-center">
										<tr>
											<th colspan="7" class="text-uppercase" style="font-size: 20px;font-weight: bolder;">IOT BASED REAL TIME WELL MONITORING SYSTEM ONGC,CAMBAY ASSET</th>
										</tr>
										<tr>
											<th colspan="7" class="text-uppercase" style="font-size: 15px;font-weight: bolder;">Alert Log Report of <span id="show_from_date"></span> <span id="to">To</span> <span id="show_to_date"></span></th>
										</tr>
									</thead>
								</table>
									<table class="table table-bordered border-bottom"  style="width: 100%;">
										<tr>
											<th style="width:10%;">Sl No.</th>
											<th>Area Name</th>
											<th>Well No</th>
											<th>Alert Type</th>
											<th>Alert Details</th>
											<th>From Date Time </th>
											<th>To Date Time</th>
										</tr>
									
									<tbody class="text-center" id="table_data">							
										
									</tbody>
								</table>
							</div>
						</div>
					</div>


						<!-- ============== date wise Alert log =============== -->
                       <div id="GFGdata">
						<div class="card-body" id="date_wise_table" style="display:none;">
							
							<div class="table-responsive" id="date_wise_table_export">
								<table class="table table-bordered border-bottom" >
									<thead class="bg-light text-center">
										<tr>
											<th colspan="5" class="text-uppercase" style="font-size: 20px;font-weight: bolder;">IOT BASED REAL TIME WELL MONITORING SYSTEM ONGC,CAMBAY ASSET</th>
										</tr>
										<tr>
											<th colspan="5" class="text-uppercase" style="font-size: 15px;font-weight: bolder;">Alert Log Report of <span id="show_date"></span></th>
										</tr>
									</thead>
								</table>
								<table class="table table-bordered border-bottom" >
										<tr>
											<th style="width:10%;">Sl No.</th>
											<th>Area Name</th>
											<th>Well No</th>
											<th>Alert Type</th>
											<th>Alert Details</th>
											
										</tr>
									
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
			$('#date_wise_table').hide();
			$('#filter_date').hide();
			$('#well_wise_export').show();
			$('#date_wise_export').hide();

			$('#well_wise_sort').show();
			$('#date_wise_sort').hide();
			$('#well_wise_pdf').show();
			$('#date_wise_pdf').hide();
						
			
		}else if(value == 'date')
		{
			$('#well_wise_table').hide();
			$('#date_wise_table').show();
			$('#filter_date').show();
			$('#well_wise_export').hide();
			$('#date_wise_export').show();

			$('#well_wise_sort').hide();
			$('#date_wise_sort').show();
			$('#well_wise_pdf').hide();
			$('#date_wise_pdf').show();	
		}else{
			$('#well_wise_table').hide();
			$('#date_wise_table').hide();
			$('#filter_date').hide();
			$('#well_wise_export').show();
			$('#date_wise_export').hide();

			$('#well_wise_sort').hide();
			$('#date_wise_sort').hide();
			$('#well_wise_pdf').hide();
			$('#date_wise_pdf').hide();		
		}
	}
</script>

<script type="text/javascript">

	get_well_wise_date();
	function get_well_wise_date()
	{
		var from_date = $('#from_date').val();
		var to_date = $('#to_date').val();

		f_from_date = moment(from_date);
		t_to_date = moment(to_date);

		if(f_from_date.isValid())
		{
			$('#show_from_date').text(f_from_date.format("DD-MM-YYYY"));
			$('#to').show();
		}else{
			$('#show_from_date').text('');
		}

		if(t_to_date.isValid())
		{
			$('#show_to_date').text(t_to_date.format("DD-MM-YYYY"));
			$('#to').show();
		}else{
			$('#show_to_date').text('');
		}

		// Additional check to show only the 'from date' if from_date == to_date
		  if (f_from_date.isValid() && t_to_date.isValid() && f_from_date.isSame(t_to_date, 'day')) {
		    $('#show_to_date').text('');
		    $('#to').hide();

		  }

	}

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
    
	get_wellwise_alert_report();
	function get_wellwise_alert_report() {
    $('#table_data').html('<tr><td colspan="7">processing please wait.......</td></tr>');
    var from_date = $('#from_date').val();
    var to_date = $('#to_date').val();
    var well_id = $('#well_id').val();
    var sort_by = $('#sort_by_well').val();

    var user_id = "<?php echo $this->session->userdata('user_id') ?>";

    $.ajax({
        url: '<?php echo base_url(); ?>Alert_report_c/get_alert_report',
        method: 'POST',
        data: { from_date: from_date, to_date: to_date, well_id: well_id,user_id:user_id,sort_by:sort_by},
        success: function (res) {
            var response = JSON.parse(res);
            console.log(response);
            if (response.response_code == 200) {
                $('#table_data').html("");
                if (response.data.length > 0) {
                    
                    $.each(response.data, function (i, v) {
                        

                        var alert_type = v.alert_type != null ? v.alert_type :"NA";
                    	var alerts_details = v.alerts_details != null ? v.alerts_details :"NA";
                    	var start_date_time  = v.start_date_time != null ? moment(v.start_date_time).format('DD-MM-YYYY h:mm:ss a') :"NA";
                    	var end_date_time  = v.end_date_time != null ? moment(v.end_date_time).format('DD-MM-YYYY h:mm:ss a') :"NA";

                        $("#table_data").append('<tr>' +
                            '<td>'+(i+1)+'</td>'+
                            '<td>'+v.well_site_name +'</td>'+
                            '<td>'+v.well_name+'</td>'+
                            '<td>'+alert_type+'</td>'+
                            '<td>'+alerts_details+'</td>'+
                            '<td>'+start_date_time+'</td>'+
                            '<td>'+end_date_time+'</td>'+
                            '</tr>');
                    });

                   
                } else {
                    $('#table_data').html('<tr>' +
                        '<td class="text-danger" style="text-align:center;" colspan="7">No Record Found !!</td>' +
                        '</tr>');
                }
            }
        }

    });
}


	datewise_alert_list();
	function datewise_alert_list() {
    $('#date_table_data').html('<tr><td colspan="5">processing please wait.......</td></tr>');
    var date = $('#date').val();
    var sort_by = $('#sort_by_date').val();

    var user_id = "<?php echo $this->session->userdata('user_id') ?>";


    $.ajax({
        url: '<?php echo base_url(); ?>Alert_report_c/get_datewise_alert_report',
        method: 'POST',
        data: { date: date,user_id:user_id ,sort_by:sort_by},
        success: function (res) {
            var response = JSON.parse(res);
            console.log(response);
            if (response.response_code == 200) {
                $('#date_table_data').html("");
                if (response.data.length > 0) {
                   
                    $.each(response.data, function (i, v) {
                        
                        var alert_type = v.alert_type != null ? v.alert_type :"NA";
                    	var alerts_details = v.alerts_details != null ? v.alerts_details :"NA";
                        $("#date_table_data").append('<tr>' +
                            '<td>'+(i+1)+'</td>'+
                            '<td>'+v.well_site_name +'</td>'+
                            '<td>'+v.well_name+'</td>'+
                            '<td>'+alert_type+'</td>'+
                            '<td>'+alerts_details+'</td>'+
                                    
                            '</tr>');
                    });

                    
                } else {
                    $('#date_table_data').html('<tr>' +
                        '<td class="text-danger" style="text-align:center;" colspan="5">No Record Found !!</td>' +
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
	  var fileName = "Well Alert Log.xlsx";
	  var table = $("#basic-datatable")[0];

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
	  var fileName = "Alert log Date Wise.xlsx";
	  var table = $("#date_wise_table_export")[0];

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
    },30000);
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

     function printWell() {
        var printDiv = "#GFGWell"; 
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