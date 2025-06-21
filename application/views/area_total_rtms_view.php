 <div class="page-wrapper">
			
				<!-- Page Content -->
                <div class="content container-fluid">
					
					<!-- Page Header -->
					<div class="page-header">
						<div class="row">
							<div class="col-sm-12">
								<h3 class="page-title">Wells Under RTMS</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard_c');?>">Dashboard</a></li>
									<li class="breadcrumb-item ">Wells Under RTMS</li>
									
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
					                       <h4 class="header-title mb-4">Wells Under RTMS</h4>
					                    </div>
								        <div class="col-auto float-end ms-auto">
								            <a href="<?php echo base_url('Dashboard_c'); ?>"><button type="button" class="btn btn-sm btn-info">Back</button></a>
                                            <button class="btn btn-sm  btn-success" onclick="export_report();">Export</button>
								
							            </div>
						            </div>
                                	
                                <div class="table-responsive">
								<table class="table table-striped" id="data-table">
									<thead class="text-center">
                                        <tr class="bg-light">
											<th>Sl.No</th>
											<th>Well No</th>
											<th>Well Status</th>
											<th>RTMS Status</th>
											<th>Last Log DateTime</th>
											<th>Average Output Current</th>
											<th>Average Output L2N Voltage</th>
											<th>Average Output P2P Voltage</th>
											<!-- <th>Total Running Hours</th> -->
										</tr>
									</thead>
									<tbody class="text-center" id="table_body">
									</tbody>
								</table>
							</div>
						</div>
					</div>
				
					<!-- /Content End -->
					
                </div>
				<!-- /Page Content -->
				
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
	
	total_rtms_list();
	function total_rtms_list()
	{
		let company_id = "<?php echo $this->session->userdata('company_id') ?>";
		
		$.ajax({
		    url: '<?php echo base_url(); ?>Dashboard_c/area_total_rtms_ajax',
		    method: 'POST',
		    data: { company_id: company_id },
		    success: function (res) {
		        var response = JSON.parse(res);
		        console.log(response);
		        if (response.response_code == 200) {
		            $('#table_body').html("");

		            if (response.data.length > 0) {
		                console.log(response.data);
		                $.each(response.data, function (i, v) {
		                    // Remove decimal and pad leading zero for output_Load_Hour and output_Load_Minute
		                    

		                    // ======= dcu status code starts ==========
		                    var last_data_time = v.offline_device_timestamp;
							var currentDate = new Date();

							var year = currentDate.getFullYear();
							var month = String(currentDate.getMonth() + 1).padStart(2, '0');
							var day = String(currentDate.getDate()).padStart(2, '0');
							var hours = String(currentDate.getHours()).padStart(2, '0');
							var minutes = String(currentDate.getMinutes()).padStart(2, '0');
							var seconds = String(currentDate.getSeconds()).padStart(2, '0');

							var formattedDate = year + '-' + month + '-' + day + ' ' + hours + ':' + minutes + ':' + seconds;

							var formattedDateObj = new Date(formattedDate);
							var lastDataTimeObj = new Date(last_data_time);

							var diffInMilliseconds = formattedDateObj - lastDataTimeObj;
							var diffInSeconds = Math.floor(diffInMilliseconds / 1000); // Convert milliseconds to seconds
							var dcu_status = '';
							// alert(diffInSeconds);
							var shifted_status = v.device_shifted;

							if (shifted_status == 0)
							{
								if(diffInSeconds > 120)
								{
									dcu_status = '<button class="btn btn-sm btn-rounded btn-pill" style="color:white;background-color:#ce2029;white-space: nowrap;">OFF</button>';
				                  	
								}else{
									dcu_status = '<button class="btn btn-sm btn-rounded btn-pill" style="color:white;background-color:#74B72E;white-space: nowrap;">ON</button>';
								}
							}else if(shifted_status == 1)
							{
								dcu_status = '<button class="btn btn-sm btn-rounded btn-pill" style="color:white;background-color:#46C7C7;white-space: nowrap;">Shifted</button>';
							}


							
							

							
		                    var well_status = '';
		                    if(v.output_Average_Current > 0 && diffInSeconds < 120)
		                    {
		                    	well_status = '<button class="btn btn-sm btn-rounded btn-pill" style="color:white;background-color:#74B72E;white-space: nowrap;">ON</button>';
		                    }else{
		                    	well_status = '<button class="btn btn-sm btn-rounded btn-pill" style="color:white;background-color:#ce2029;white-space: nowrap;">OFF</button>';
		                    }
		                   
		                    var output_Average_Current = v.output_Average_Current == null ? "NA" : v.output_Average_Current;
		                    var output_Average_Voltage_L2N = v.output_Average_Voltage_L2N == null ? "NA" : v.output_Average_Voltage_L2N;
		                    var output_Average_Voltage_P2P = v.output_Average_Voltage_P2P == null ? "NA" : v.output_Average_Voltage_P2P;
                        	var last_log_datetime = v.last_log_datetime == null ? "NA" : moment(v.last_log_datetime).format('DD-MM-YYYY h:mm:ss a');



		                    $("#table_body").append('<tr>' +
		                        '<td>' + (i + 1) + '</td>' +
		                        '<td><a href="<?php echo base_url('Area_Dashboard_c/get_single_well_detail_dashboard/'); ?>' + v.well_id + '">' + v.well_name + '</a></td>' +
		                        '<td>'+well_status+'</td>' +
		                        '<td>'+dcu_status+'</td>' +
		                        '<td>' + last_log_datetime + '</td>' +
		                        '<td>' + output_Average_Current + '</td>' +
		                        '<td>' + output_Average_Voltage_L2N + '</td>' +
		                        '<td>' + output_Average_Voltage_P2P + '</td>' +
		                       
		                        
		                        
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
	  var fileName = "Wells Under RTMS List.xlsx";
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
				

                
