<div class="page-wrapper">
<!-- Page Content -->
    <div class="content container-fluid">
    	<!-- Page Header -->
			<div class="page-header">
				<div class="row">
					<div class="col-sm-12">
						<h3 class="page-title">Power Cut Wells</h3>
						<ul class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard_c');?>">Dashboard</a></li>
							<li class="breadcrumb-item ">Power Cut Wells</li>
							
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
		                            <h4 class="header-title mb-4">Power Cut Wells List</h4>
		                        </div>
					            <div class="col-auto float-end ms-auto">
						            <a href="<?php echo base_url('Dashboard_c'); ?>"><button type="button" class="btn btn-sm btn-info">Back</button></a>
                                    <button class="btn btn-sm  btn-success" onclick="export_report();">Export</button>
					            </div>
			                </div>
                                	
                             <div class="table-responsive">
								<table class="table table-striped" id="data-table">
									<thead class="text-center">
										<th>Sl.No</th>
											<th>Well Name</th>
										    <th>Last Log DateTime</th>
											<th>Average Current</th>
											<th>Average P2P Voltage</th>
											
											
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
	
	power_cut_wells_details();
	function power_cut_wells_details()
	{
		 $('#table_body').html('<tr><td colspan="7">Processing please wait.......</td></tr>');
		let company_id = "<?php echo $this->session->userdata('company_id') ?>";
		let user_id = "<?php echo $this->session->userdata('user_id') ?>";
		let area_id = "<?php echo $this->uri->segment(3) ?>";
		
		$.ajax({
		    url: '<?php echo base_url(); ?>Dashboard_c/power_cut_well_ajax',
		    method: 'POST',
		    data: { company_id: company_id,user_id:user_id,area_id:area_id },
		    success: function (res) {
		        var response = JSON.parse(res);
		        console.log(response);
		        if (response.response_code == 200) {
		            $('#table_body').html("");

		            if (response.data.length > 0) {
		                console.log(response.data);
		                $.each(response.data, function (i, v) {
		                    
		                  
                             
		                    
                        	var last_log_datetime = v.last_log_datetime == null ? "NA" : moment(v.last_log_datetime).format('DD-MM-YYYY h:mm:ss a');

		                    $("#table_body").append('<tr>' +
		                        '<td>' + (i + 1) + '</td>' +
		                       '<td><a href="<?php echo base_url('Dashboard_c/get_single_well_detail_dashboard/'); ?>' + v.well_id + '" style="color: green;">' + v.well_name + '</a></td>'+
                                '<td>' +last_log_datetime + '</td>' +
		                        '<td>'+ v.output_Average_Current + '</td>' +
		                         '<td>'+ v.output_Average_Voltage_P2P + '</td>' +
		                        
		                        
		                        
		                        '</tr>');
		                });
		            } else {
		                $('#table_body').html('<tr>' +
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
	
	function export_report() {
	  var sheetName = "Sheet1";
	  var fileName = "Power Cut wells List.xlsx";
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
   	   power_cut_wells_details();
   	          
    },60000);
</script>
