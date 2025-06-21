<div class="page-wrapper">
<!-- Page Content -->
    <div class="content container-fluid">
    	<!-- Page Header -->
			<div class="page-header">
				<div class="row">
					<div class="col-sm-12">
						<h3 class="page-title">Well Scheduling Report</h3>
						<ul class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard_c');?>">Dashboard</a></li>
							<li class="breadcrumb-item ">Well Scheduling Report</li>
							
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
		                            <h4 class="header-title mb-4">Well Scheduling Report</h4>
		                        </div>
					            <div class="col-auto float-end ms-auto">
					            	<a href="<?php echo base_url('Dashboard_c'); ?>"><button type="button" class="btn btn-sm btn-info">Back</button></a>
						            <button class="btn btn-sm  btn-success" onclick="export_report();">Export</button>
						              <button class="btn btn-sm  btn-primary" onclick="printReport();">PDF</button>
					            </div>
			                </div>
			                <div class="card-body">
							<div class="row">
								<div class="form-group col-md-3 mt-2">
									<h5><b>Well Name</b></h5>
									<select name="well_id" id="well_id" class="form-control select2" onchange="get_configration_well_setup();">
										<option value=""> Select Well </option>
										<?php 
										if (!empty($well_list))
										{
											foreach ($well_list as $key => $value)
											{
												?>
													<option value="<?php echo $value['id']; ?>"><?php echo $value['well_name']; ?></option>

												<?php
											}
										}

										?>
									</select>
								</div>
								

								<div class="form-group col-md-3 mt-2">
									<h5><b>From Date</b></h5>
									<input type="date" name="from_date" id="from_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" onchange="get_configration_well_setup();get_configrationdate();">
								</div>

								<div class="form-group col-md-3 mt-2">
									<h5><b>To Date</b></h5>
									<input type="date" name="to_date" id="to_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" onchange="get_configration_well_setup();get_configrationdate();">
								</div>

								<div class="form-group col-md-3 mt-2">
								    <h5><b>Sort By</b></h5>
								    <select class="form-control select2" name="sort_by" id="sort_by" onchange="get_configration_well_setup();">
								    	<option value="">Select Column</option>
								    	<option value="well_name">Well Name</option>
								    	<option value="well_type">Well Type</option>
								    	<option value="start_time">Start Time</option>
								    	<option value="stop_time">Stop Time</option>
								    	<option value="running_hours">Running Hours</option>
								    	<option value="c_date">Setup Date</option>
								    </select>
								</div>
							</div>
                             <div id="GFG">   	
                             <div class="table-responsive mt-4" id="data-table">
								  <table class="table table-bordered border-bottom table-striped" >
									<thead>
									<tr>
											<th colspan="7" class="text-uppercase text-center" style="font-size: 20px;font-weight: bolder;">IOT Based Real Time Well Monitoring System ONGC,CAMBAY Asset</th>
										</tr>
										<tr>
											<th colspan="7" class="text-uppercase text-center" style="font-size: 15px;font-weight: bolder;">Well Scheduling Report as on <span id="show_from_date"></span> <span id="to">To</span> <span id="show_to_date"></span></th>
										</tr>
										</thead>
										</table>
										 <table class="table table-bordered border-bottom table-striped" >
										<thead>
										<tr style="text-align: center;">
											<th style="width:10%;">Sl No.</th>
											<th>Well Name</th>
											<th>Well Type</th>
											<th>Start Time</th>
											<th>Stop Time</th>
											<th>Running Hours</th>
											<th>Setup Date</th>
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
        get_configrationdate();
    function get_configrationdate()
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
</script>


<script type="text/javascript">
    
get_configration_well_setup();
function get_configration_well_setup()
{
	let company_id = "<?php echo $this->session->userdata('company_id') ?>";
	let from_date = $('#from_date').val();
	let to_date = $('#to_date').val();
	let well_id = $('#well_id').val();
	let sort_by = $('#sort_by').val();
	let user_id = "<?php echo $this->session->userdata('user_id') ?>";
	
	$.ajax({
    url: '<?php echo base_url(); ?>Well_configration_c/well_configration_report',
    method: 'POST',
    data: {company_id:company_id, from_date:from_date, to_date:to_date, well_id:well_id,user_id:user_id,sort_by:sort_by},
    success: function(res) {
        var response = JSON.parse(res);
        console.log(response);
        if (response.response_code == 200) {
            var count = 0; 
            $('#table_data').html("");
            if (response.data.length > 0) {
                var prev_well_id = null;
                var total_minutes_sum = 0;
                $.each(response.data, function(i, v) {
                    var well_type = '';
                    if (v.well_type == '0') {
                        well_type = "Regular";
                    } else if (v.well_type == '1') {
                        well_type = "Periodic";
                    }

                        var total_running_minute = v.running_hours;

                        if (total_running_minute !== null && total_running_minute !== '') 
                        {
                            total_minutes_sum += parseFloat(total_running_minute);
                          
                            var hours = Math.floor(total_running_minute / 60);
                            var minutes = total_running_minute % 60;
                            var duration = hours + ' Hrs ' + minutes + ' Min';
                        } else {
                            var duration = '-';
                        }

                    if (v.well_id != prev_well_id) {
                        $("#table_data").append('<tr>'+
                            '<td>'+(++count)+'</td>'+ 
                            '<td>'+v.well_name+'</td>'+
                            '<td>'+well_type+'</td>'+
                            
                            
                           '<td>' + (v.start_time ? moment('1970-01-01 ' + v.start_time, 'YYYY-MM-DD HH:mm:ss').format('h:mm:ss a') : '-') + '</td>' +
                            '<td>' + (v.stop_time ? moment('1970-01-01 ' + v.stop_time, 'YYYY-MM-DD HH:mm:ss').format('h:mm:ss a') : '-') + '</td>'+
                            '<td>'+ duration +'</td>'+

                               '<td>'+moment(v.c_date).format('DD-MM-YYYY h:mm:ss a')+'</td>'+// Format start_time to AM/PM
                             
                            '</tr>');
                        prev_well_id = v.well_id;
                    } else {
                        var prev_row = $("#table_data tr").last();
                        prev_row.find("td:first").attr("rowspan", function(i, val) {
                            return parseInt(val) + 1;
                        });
                        prev_row.after('<tr>'+
                            '<td colspan="3">-</td>'+
                           
                            
                            
                            
                             '<td>' + (v.start_time ? moment('1970-01-01 ' + v.start_time, 'YYYY-MM-DD HH:mm:ss').format('h:mm:ss a') : '-') + '</td>' +
                             '<td>' + (v.stop_time ? moment('1970-01-01 ' + v.stop_time, 'YYYY-MM-DD HH:mm:ss').format('h:mm:ss a') : '-') + '</td>'+
                              '<td>'+ duration +'</td>'+

                              '<td>'+moment(v.c_date).format('DD-MM-YYYY h:mm:ss a')+'</td>'+
                            '</tr>');
                    }
                });
            } else {
                $('#table_data').html('<tr>'+
                    '<td class="text-danger" style="text-align:center;" colspan="7">No Record Found !!</td>'+
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
	  var fileName = "Well Configration Report.xlsx";
	  var table = $("#data-table")[0];

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
                font-size: 9px; 
                padding: 1px;
                border: 1px solid black; 
            }

            .no-print {
                display: none;
            }
        }
    </style>
<script>
    function printReport() {
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