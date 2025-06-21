<div class="page-wrapper">
<!-- Page Content -->
    <div class="content container-fluid">
    	<!-- Page Header -->
			<div class="page-header">
				<div class="row">
					<div class="col-sm-12">
						<h3 class="page-title">Well Wise Alert Report</h3>
						<ul class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard_c');?>">Dashboard</a></li>
							<li class="breadcrumb-item ">Well Wise Alert Report</li>
							
						</ul>
					</div>
				</div>
			</div>



			<!--APP-CONTENT OPEN-->

			<div class="row row-sm">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-body">
							<div class="row">
	                            <div class="col-md-6">
	                                <h3><b>Well Wise Alert Report</b></h3>
	                            </div>
	                            <div class="col-md-6 d-md-flex justify-content-end">
	                                <div>
	                                    <button id="well_wise_export"  class="btn btn-sm  btn-success" onclick="export_well_wise_report();">Export</button>

	                                    <a href="<?php echo base_url().'Dashboard_c/get_single_well_detail_dashboard/'.$this->uri->segment(3); ?>"><button type="button" class="btn btn-sm btn-info mx-2">Back</button></a>
	                                </div>
	                            </div>
	                    	</div>
                    	</div>
                    	<hr>

						<div class="card-body">
							<div class="row">
								
								<div class="form-group col-md-4 mt-2">
								    <h5><b>From Date</b></h5>
								    <input type="date" name="from_date" id="from_date" class="form-control" onchange="get_wellwise_alert_report();get_well_wise_date();">
								</div>

								<div class="form-group col-md-4 mt-2">
								    <h5><b>To Date</b></h5>
								    <input type="date" name="to_date" id="to_date" class="form-control" onchange="get_wellwise_alert_report();get_well_wise_date();">
								</div>

								<div class="form-group col-md-4 mt-2">
								    <h5><b>Sort By</b></h5>
								    <select class="form-control select2" name="sort_by" id="sort_by" onchange="get_wellwise_alert_report();">
								    	<option value="">Select Column</option>
								    	<option value="well_site_name">Area Name</option>
								    	<option value="alert_type">Alert Type</option>
								    	<option value="alerts_details">Alert Details</option>
								    	<option value="start_date_time">From Date</option>
								    	<option value="end_date_time">To Date</option>
								    </select>
								</div>
							</div>
							<div class="table-responsive mt-4">
								<table class="table table-bordered border-bottom" id="basic-datatable" style="width: 100%;">
									<thead class="bg-light text-center">
										<tr>
											<th colspan="6" class="text-uppercase" style="font-size: 20px;font-weight: bolder;">IOT Based Real Time Well Monitoring System ONGC,Cambay Asset </th>
										</tr>
										<tr>
											<th colspan="6" class="text-uppercase" style="font-size: 15px;font-weight: bolder;">Alert Log Report of <span id="show_from_date"></span> <span id="to">To</span> <span id="show_to_date"></span></th>
										</tr>
										<tr>
											<th style="width:10%;">Sl No.</th>
											<th>Area Name</th>
											<th>Alert Type</th>
											<th>Alert Details</th>
											<th>From Date Time</th>
											<th>To Date Time</th>
										</tr>
									</thead>
									<tbody class="text-center" id="table_data">							
										
									</tbody>
								</table>
							</div>
						</div>
					</div>
					</div>
				</div>
			</div>
			<!-- End Row -->
		</div>
		<!-- CONTAINER CLOSED -->
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
    
	get_wellwise_alert_report();
	function get_wellwise_alert_report() {
    $('#table_data').html('<tr><td colspan="6">processing please wait.......</td></tr>');
    var from_date = $('#from_date').val();
    var to_date = $('#to_date').val();
    var sort_by = $('#sort_by').val();

    var well_id = '<?php echo $this->uri->segment(3) ?>';

    $.ajax({
        url: '<?php echo base_url(); ?>Alert_report_c/get_dashboard_alert_data',
        method: 'POST',
        data: { from_date: from_date, to_date: to_date, well_id: well_id , sort_by:sort_by },
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
                            '<td>'+v.well_site_name+'</td>'+
                            '<td>'+alert_type+'</td>'+
                            '<td>'+alerts_details+'</td>'+
                            '<td>'+start_date_time+'</td>'+
                            '<td>'+end_date_time+'</td>'+
                            '</tr>');
                    });

                   
                } else {
                    $('#table_data').html('<tr>' +
                        '<td class="text-danger" style="text-align:center;" colspan="6">No Record Found !!</td>' +
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
	  var fileName = "Well Wise Alert report.xlsx";
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

<script type="text/javascript">
	
	 setInterval(()=>{
        get_wellwise_alert_report();
    },30000);
</script>
				

                


