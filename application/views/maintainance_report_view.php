<div class="page-wrapper">
    <div class="content container-fluid">
		<!-- Page Header -->
		<div class="page-header">
			<div class="row align-items-center">
			 	 <div class="col">
					<h3 class="page-title">Maintenance Report</h3>
					<ul class="breadcrumb">
						<li class="breadcrumb-item active">Report</li>
					</ul>
				</div>

				<div class="col-auto float-end ms-auto">
	                <a href="<?php echo base_url('Dashboard_c'); ?>">
	                <button type="button" class="btn btn-sm btn-success">Back</button>
	                </a>
	            </div>
	        </div>
	    </div>

		<div class="row mx-1">
			<div class="card card-body">
				<div class="row"> 
					<div class="form-group col-md-4 mt-2">
						<h5><b>Well No</b></h5>
						<select name="well_id" id="well_id" class="form-control select2" onchange="get_mis_report();">
							<option value="">All Well</option>
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
					    <input type="date" name="from_date" id="from_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" onchange="get_mis_report();">
					</div>

					<div class="form-group col-md-4 mt-2">
					    <h5><b>To Date</b></h5>
					    <input type="date" name="to_date" id="to_date" class="form-control"  value="<?php echo date('Y-m-d'); ?>" onchange="get_mis_report();">
					</div>

					<div class="form-group col-md-4 mt-2">
					    <h5><b>Offline Reason</b></h5>
					    <select class="form-control select2" name="reason" id="reason" onchange="get_mis_report();">
					    	<option value="">Select Reason</option>
					    	<option value="1">Battery Problem</option>
					    	<option value="2">Network Problem</option>
					    	<option value="3">Modbus Error</option>
					    	<option value="4">Power Cut</option>    	
					    </select>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="card card-body">
				    <div class="row">
					    <div class="col-md-6">
					        <h3><b>Maintenance Report</b></h3>
					    </div>
						<div class="col-md-6 d-flex justify-content-end">
						  	<div>
						    	<button class="btn btn-sm  btn-success" onclick="export_report();">Export</button>
						  	</div>
						</div>
		            </div>
			    	<hr>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-bordered border-bottom" id="basic-datatable">
								<thead class="bg-light text-center">
									<tr>
										<th colspan="10" class="text-uppercase" style="font-size: 18px;font-weight: bolder;" id ="report-heading"> </th>
									</tr>
									<tr>
										<th style="width:10%;">Sl No.</th>
										<th>Well Name</th>
										<th>Offline Reason</th>
										<th>SMPS Voltage</th>
										<th>Battery Voltage</th>
										<th>Average Current</th>
										<th>Average P2P voltage</th>
										<th>Power Factor</th>
										<th>Start DateTime</th>
										<th>End DateTime</th>


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
		<!-- ====================== Code for maintainance Table ends ============= -->
	</div>
</div>

<script type="text/javascript">
	
	
		get_mis_report();
		function get_mis_report()
		{
			$('#table_data').html('<tr><td colspan="5">Processing please wait.......</td></tr>');
			var company_id = "<?php echo $this->session->userdata('company_id') ?>";
			var from_date = $('#from_date').val();
			var to_date = $('#to_date').val();
			var well_id = $('#well_id').val();
			var offline_reason = $('#reason').val();

            var selectedWellName = $('#well_id option:selected').text();
            let formattedFromDate = moment(from_date, 'YYYY-MM-DD').format('DD-MM-YYYY');
            let formattedToDate = moment(to_date, 'YYYY-MM-DD').format('DD-MM-YYYY');
            let headingText = ` Maintenance Report Of ${selectedWellName} from ${formattedFromDate} to ${formattedToDate}   `;
            $('#report-heading').text(headingText);

			$.ajax({
				url:'<?php echo base_url(); ?>Maintainance_Dasboard_c/get_maintenance_report_ajax',
				method:'POST',
				data:{company_id:company_id,from_date:from_date,to_date:to_date,well_id:well_id,offline_reason:offline_reason},
				success:function(res)
				{
					var response = JSON.parse(res);
					console.log('mis',response);
				
					if(response.response_code==200)
		                {
		                    $('#table_data').html("");
		                     if(response.data.length > 0)
		                     {
		                     	
		                        $.each(response.data,function(i,v){
		                        	var well_name = v.well_name !== null ? v.well_name :"NA";
		                        	var start_smps_voltage = v.start_smps_voltage !== null ? v.start_smps_voltage :"NA";
			                     	var start_battery_voltage = v.start_battery_voltage !== null ? v.start_battery_voltage :"NA";
			                     	var avg_current = v.avg_current !== null ? v.avg_current :"NA";
			                     	var output_Average_Voltage_P2P = v.output_Average_Voltage_P2P !== null ? v.output_Average_Voltage_P2P :"NA";
			                     	var output_Kwh = v.output_Kwh !== null ? v.output_Kwh :"NA";

			                     	var start_date_time = v.start_date_time !== null ? moment(v.start_date_time).format('DD-MM-YYYY hh:mm:ss a') :"NA";

			                     	var end_date_time = v.end_date_time !== null ? moment(v.end_date_time).format('DD-MM-YYYY hh:mm:ss a') :"NA";

			                     	var offline_reason = v.offline_reason !== null ? 
										    (v.offline_reason == 1 ? "Battery Problem" :
										    (v.offline_reason == 2 ? "Network Problem" :
										    (v.offline_reason == 3 ? "Modbus Error" :
										    (v.offline_reason == 4 ? "Power Cut Problem" : "NA"))))
										    : "NA";

		                            $("#table_data").append('<tr>'+
		                                '<td>'+ (i+1)+'</td>'+
                                        '<td>'+ well_name +'</td>' +
                                        '<td>'+ offline_reason +'</td>' +
                                        '<td>'+ start_smps_voltage +'</td>' +
                                        '<td>'+ start_battery_voltage +'</td>' +
                                        '<td>'+ avg_current +'</td>' +
                                        '<td>'+ output_Average_Voltage_P2P +'</td>' +
                                        '<td>'+ output_Kwh +'</td>' +
                                        '<td>'+ start_date_time +'</td>' +
                                        '<td>'+ end_date_time +'</td>' +


		                            '</tr>');
		                        });
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

</script>

<script src="<?php echo base_url(); ?>assets/local/excel/xlsx.full.min.js"></script>
<script type="text/javascript">
	
	function export_report() {

	  
	  var sheetName = "Sheet1";
	  var selectedWellName = $('#well_id option:selected').text().trim();
     
      var fileName = 'Maintenance Report of ('+selectedWellName+').xlsx';
	 
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
