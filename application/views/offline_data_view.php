<div class="page-wrapper">
<!-- Page Content -->
    <div class="content container-fluid">
    	<!-- Page Header -->
			<div class="page-header">
				<div class="row">
					<div class="col-sm-12">
						<h3 class="page-title">Well Offline Report</h3>
						<ul class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard_c');?>">Dashboard</a></li>
							<li class="breadcrumb-item ">Well Offline Report</li>
							
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
                                <h3><b>Well Offline Report</b></h3>
                            </div>
                            <div class="col-md-6 d-md-flex justify-content-end">
                                <div>
                                    <button class="btn btn-sm  btn-success" onclick="export_well_wise_report();">Export</button>
                                   
                                    <a href="<?php echo base_url('Dashboard_c');?>"><button class="btn btn-sm  btn-primary mx-2">Back</button></a>

                                </div>
                            </div>
                    	</div>
                    	<div class="row">
                          
                                <div class="form-group col-md-3 mt-2">
									<h5><b>Well Name</b></h5>
									<select name="well_id" id="well_id" class="form-control select2" onchange="offline_data_list();">
									
										<?php
										  if (!empty($well_list)) {
                                            
                                            foreach ($well_list as $key => $value) {
                                                ?>
                                                <option value="<?php echo $value['well_id']; ?>"> <?php echo $value['well_name']; ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
									</select>
								</div>
								<div class="form-group col-md-3 mt-2">
								    <h5><b>From Date</b></h5>
								    <input type="date" name="from_date" id="from_date" value="<?php echo date('Y-m-d'); ?>" class="form-control" onchange="offline_data_list();">
								</div>

								<div class="form-group col-md-3 mt-2">
								    <h5><b>To Date</b></h5>
								    <input type="date" name="to_date" id="to_date"  value="<?php echo date('Y-m-d'); ?>" class="form-control" onchange="offline_data_list();">
								</div>

						    </div>	
						
						<div class="card-body">
							<div class="table-responsive mt-4">
								<table class="table table-bordered border-bottom" id="well_wise_table_export">
									<thead class="bg-light text-center">
										<tr>
											<th colspan="9" class="text-uppercase" style="font-size: 20px;font-weight: bolder;">IOT Based Real Time Well Monitoring System ONGC,CAMBAY Asset</th>
										</tr>
										<tr>
											<th style="width:10%;">Sl No.</th>
											<th>Imei No</th>
											<th>Previous Event Date Time</th>
											<th>Last Log Date Time</th>
											<th>Previous Frame Number</th>
											<th>Frame Number</th>
											<th>Action</th>	
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
offline_data_list();
function offline_data_list() {
    $('#table_data').html('<tr><td colspan="9">processing please wait.......</td></tr>');
    var from_date = $('#from_date').val();
    var to_date = $('#to_date').val();
    var well_id = $('#well_id').val();
    var dateDifference = Math.abs(new Date(to_date) - new Date(from_date));
    var daysDifference = Math.ceil(dateDifference / (1000 * 60 * 60 * 24));

    if (daysDifference <= 2){
        $.ajax({
            url: '<?php echo base_url(); ?>Offline_data_report_c/Offline_data_report',
            method: 'POST',
            data: { from_date: from_date, to_date: to_date, well_id: well_id },
            success: function (res) {
                var response = JSON.parse(res);
                console.log(response);

                if (response.response_code == 200) {
                    $('#table_data').html("");
                    if (response.data.length > 0) {

                        $.each(response.data, function (i, v) {


                            $("#table_data").append('<tr>' +
                                '<td>' + (i + 1) + '</td>' +
                                '<td>' + v.imei_no + '</td>' +
                                '<td>' + moment(v.previous_event_time).format('DD-MM-YYYY h:mm:ss a') + '</td>' +
                                '<td>' + moment(v.last_log_datetime).format('DD-MM-YYYY h:mm:ss a') + '</td>' +
                                '<td>' + v.previous_frame_number + '</td>' +
                                '<td>' + v.frame_number + '</td>' +
                                '<td>' + '<a ><button type="button" class="btn btn-sm btn-info">Get</button></a>' + '</td>' +
                                '</tr>');
                        });

                    } else {
                        $('#table_data').html('<tr>' +
                            '<td class="text-danger" style="text-align:center;" colspan="9">No Record Found !!</td>' +
                            '</tr>');
                    }
                }
            }
        });
    } else {
    	$('#table_data').html('<tr>' +
            '<td class="text-danger" style="text-align:center;" colspan="9">No Record Found !!</td>' +
        '</tr>');
        swal('warning', "Please select a date range of maximum 2 days.", 'warning');
        var currentDate = new Date();
        var formattedDate = currentDate.toISOString().slice(0, 10);
        document.getElementById('from_date').value = formattedDate;
        document.getElementById('to_date').value = formattedDate;
    }
}
</script>
<script src="<?php echo base_url(); ?>assets/local/excel/xlsx.full.min.js"></script>
<script type="text/javascript">
	
	function export_well_wise_report() {
	  var sheetName = "Sheet1";
	  var fileName = "Details offline well.xlsx";
	  var table = $("#well_wise_table_export")[0];
	  // Convert table to worksheet
	  var ws = XLSX.utils.table_to_sheet(table);
	  // Create a new workbook and add the worksheet to it
	  var wb = XLSX.utils.book_new();
	  XLSX.utils.book_append_sheet(wb, ws, sheetName);
	  // Save the workbook as an Excel file and download it
	  XLSX.writeFile(wb, fileName);
	}
</script>