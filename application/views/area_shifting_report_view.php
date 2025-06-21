<div class="page-wrapper">
<!-- Page Content -->
    <div class="content container-fluid">
    	<!-- Page Header -->
			<div class="page-header">
				<div class="row">
					<div class="col-sm-12">
						<h3 class="page-title">Shifted Well List</h3>
						<ul class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard_c');?>">Dashboard</a></li>
							<li class="breadcrumb-item ">Shifted Well List</li>
							
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
		                            <h4 class="header-title mb-4">Shifted Well List</h4>
		                        </div>
					            <div class="col-auto float-end ms-auto">
					            	<a href="<?php echo base_url('Dashboard_c'); ?>"><button type="button" class="btn btn-sm btn-info">Back</button></a>
						            <button class="btn btn-sm  btn-success" onclick="export_report();">Export</button>
					            </div>
			                </div>

			                <div class="card-body">
							<div class="row">
								<div class="table-responsive">
								<table class="table table-striped custom-table mb-0 datatable" id="data-table">
									<thead class="text-center">
										<tr class="bg-light">
											<th>Sl.No</th>
											<th>Well No</th>
											<th>RTMS Status</th>
											<th>Shifted Date Time</th>
																						
										</tr>
									</thead>
									<tbody class="text-center" id="table_body">
										
										
									</tbody>
								</table>
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
	
	on_unit_details();
	function on_unit_details()
	{
		let company_id = "<?php echo $this->session->userdata('company_id') ?>";
		let user_id = "<?php echo $this->session->userdata('user_id') ?>";
		let area_id = "<?php echo $this->uri->segment(3) ?>";

		$.ajax({
		    url: '<?php echo base_url(); ?>Dashboard_c/get_well_shifted_data',
		    method: 'POST',
		    data: { company_id: company_id, user_id: user_id,area_id:area_id },
		    success: function (res) {
		        var response = JSON.parse(res);
		        console.log(response);
		        if (response.response_code == 200) {
		            $('#table_body').html("");

		            if (response.data.length > 0) {
		                console.log(response.data);
		                $.each(response.data, function (i, v) {
		                   
                        	var date_of_shifted = v.date_of_shifted == null ? "NA" : moment(v.date_of_shifted).format('DD-MM-YYYY h:mm:ss a');                      	
		                  
		                    rtms_status = '<button class="btn btn-sm btn-rounded btn-pill" style="color:white;background-color:#46C7C7;white-space: nowrap;">Shifted</button>';
		                    

		                    $("#table_body").append('<tr>' +
		                        '<td>' + (i + 1) + '</td>' +
		                        '<td><a  style="color:green;" href="<?php echo base_url('Dashboard_c/get_single_well_detail_dashboard/'); ?>' + v.well_id + '">' + v.well_name + '</a></td>' +
		                        '<td>' +rtms_status+'</td>' +
		                        '<td>' + date_of_shifted + '</td>' +
		                        '</tr>');
		                });
		            } else {
		                $('#table_body').html('<tr>' +
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
	
	function export_report() {
	  var sheetName = "Sheet1";
	  var fileName = "Well Shifted list.xlsx";
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

<script type="text/javascript">
	
	setInterval(()=>{
	 	on_unit_details();
    },30000);
</script>