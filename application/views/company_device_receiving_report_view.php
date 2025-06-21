<div class="page-wrapper">
<!-- Page Content -->
    <div class="content container-fluid">
    	<!-- Page Header -->
			<div class="page-header">
				<div class="row">
					<div class="col-sm-12">
						<h3 class="page-title">Device Receiving Report</h3>
						<ul class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard_c');?>">Dashboard</a></li>
							<li class="breadcrumb-item ">Device Receiving Report</li>
							
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
                                <h3><b>Device Receiving Report</b></h3>
                            </div>
                            <div class="col-md-6 d-md-flex justify-content-end">
                                <div>
                                   <div>
                                    <button class="btn btn-sm  btn-success" onclick="export_report();">Export</button>
                                </div>
                                </div>
                            </div>
                    	</div>
                    	</div>

                    	<div class="card-body">
							<div class="row">
								<div class="form-group col-md-4 mt-2">
									<h5><b>From Date</b></h5>
									<input type="date" name="from_date" id="from_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" onchange="get_receiving_report_data();get_device_receiving_date_date();">
								</div>

								<div class="form-group col-md-4 mt-2">
									<h5><b>To Date</b></h5>
									<input type="date" name="to_date" id="to_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" onchange="get_receiving_report_data();get_device_receiving_date_date();">
								</div>
								
							</div>

						<div class="table-responsive mt-2">
							<table class="table table-bordered border-bottom" id="basic-datatable">
								<thead class="bg-light text-center">
									<tr>
										<th colspan="6" class="text-uppercase" style="font-size: 20px;font-weight: bolder;">IOT BASED REAL TIME WELL MONITORING SYSTEM ONGC,CAMBAY ASSET</th>
									</tr>
									<tr>
										<th colspan="6" class="text-uppercase" style="font-size: 15px;font-weight: bolder;">Device Receiving Report as on <span id="show_from_date"></span> <span id="to">To</span> <span id="show_to_date"></span></th>
									</tr>
									<tr>
										<th style="width:10%;">Sl No.</th>
										<th>Device Name</th>
										<th>IMEI No</th>
										<th>Serial No</th>
										<th>Allotment Date</th>
									</tr>
								</thead>
								<tbody class="text-center" id="table_data">							
									
								</tbody>
							</table>
						</div>
					</div>

						<!-- ============== date wise running log =============== -->

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
        get_device_receiving_date_date();
    function get_device_receiving_date_date()
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
    
get_receiving_report_data();
function get_receiving_report_data()
{
	let company_id = "<?php echo $this->session->userdata('company_id') ?>";
	let from_date = $('#from_date').val();
	let to_date = $('#to_date').val();

	$.ajax({
		url:'<?php echo base_url(); ?>Company_device_receiving_report_c/get_device_receiving_report',
		method:'POST',
		data:{company_id:company_id,from_date:from_date,to_date:to_date},
		success:function(res)
		{
			var response = JSON.parse(res);
			console.log(response);
			if(response.response_code==200)
                {
                    $('#table_data').html("");
                     if(response.data.length > 0)
                     {
                        $.each(response.data,function(i,v){
                            $("#table_data").append('<tr>'+
                                    '<td>'+(i+1)+'</td>'+
                                    '<td>'+v.device_name+'</td>'+
                                    '<td>'+v.imei_no+'</td>'+
                                    '<td>'+v.serial_no+'</td>'+
                                    '<td>'+moment(v.datetime).format('DD-MM-YYYY h:mm:ss a')+'</td>'+
                                '</tr>');
                        });
                     }
                     else{
                        $('#table_data').html('<tr>'+
                                 '<td class="text-danger" style="text-align:center;" colspan="5">No Record Found !!</td>'+
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
	  var fileName = "Device Receiving Report.xlsx";
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