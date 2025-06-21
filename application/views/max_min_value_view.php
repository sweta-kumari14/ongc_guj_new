<div class="page-wrapper">
<!-- Page Content -->
    <div class="content container-fluid">
    	<!-- Page Header -->
			<div class="page-header">
				<div class="row">
					<div class="col-sm-12">
						<h3 class="page-title">Max and Min Value</h3>
						
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
                                <h3><b>Max and Min Value</b></h3>
                            </div>
                            <div class="col-md-6 d-md-flex justify-content-end">
                                <div>
                                   <button class="btn btn-sm  btn-success" onclick="export_report();">Export</button>
                                    <a href="Dashboard_c"><button class="btn btn-sm  btn-primary mx-2">Back</button></a>
                                </div>
                            </div>
                    	</div>
                    	

                    	
					
								<div class="row">
								<div class="form-group col-md-4 mt-2">
									<h5><b>Well No</b></h5>
									<select name="well_id" id="well_id" class="form-control select2" onchange="get_max_and_min_value();">
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

								<div class="form-group col-md-4 mt-2">
									<h5><b>Date</b></h5>
									<input type="date" name="date" id="date" class="form-control" value="<?= date('Y-m-d',time()); ?>" onchange="get_max_and_min_value();get_date();">
								</div>
							</div>


							<div class="table-responsive mt-4">
								<table class="table table-bordered border-bottom" id="basic-datatable">
									<thead class="bg-light text-center">
										<tr>
											<th colspan="31" class="text-uppercase text-center" style="color: black;font-size: 20px;font-weight: bolder;">IOT Based Real Time Well Monitoring System ONGC,CAMBAY Asset</th>
										</tr>
										
										<tr>
											<th colspan="31" class="text-uppercase text-center" style="color: black;font-size: 15px;font-weight: bolder;">Max and Min Value Report of <span id="show_date"></span> </th>
										</tr>
										<tr>
											<th style="width:10%;">Sl No.</th>
											<th>Well No</th>
											
											<th>Max Output L2N R</th>
											<th>Max Output L2N Y</th>
											<th>Max Output L2N B</th>
											<th>Max Output L2N Avg.</th>
											<th>Min Output L2N R</th>
											<th>Min Output L2N Y</th>
											<th>Min Output L2N B</th>
											<th>Min Output L2N Avg.</th>
											<th>Max Output P2P RY</th>
											<th>Max Output P2P YB</th>
											<th>Max Output P2P BR</th>
											<th>Max Output P2P Avg.</th>
											<th>Min Output P2P RY</th>
											<th>Min Output P2P YB</th>
											<th>Min Output P2P BR</th>
											<th>Min Output P2P Avg.</th>
											<th>Max Output Current R</th>
											<th>Max Output Current Y</th>
											<th>Max Output Current B</th>
											<th>Max Output Current Avg.</th>
											<th>Min Output Current R</th>
											<th>Min Output Current Y</th>
											<th>Min Output Current B</th>
											<th>Min Output Current Avg.</th>
											<th>Max Output Frequency</th>
											<th>Min Output Frequency</th>
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
    
get_max_and_min_value();
function get_max_and_min_value()
{
	 $('#table_data').html('<tr><td colspan = "56">Processing Please Wait.....</td></tr>');
	let date = $('#date').val();
	let well_id = $('#well_id').val();
	let user_id = "<?php echo $this->session->userdata('user_id') ?>";
	

	$.ajax({
		url:'<?php echo base_url(); ?>Max_min_value_c/get_max_and_min_value',
		method:'POST',
		data:{date:date,well_id:well_id,user_id:user_id},
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
                                    '<td>'+v.well_name+'</td>'+
                                    '<td>'+v.max_output_R_L2N+'</td>'+
                                    '<td>'+v.max_output_Y_L2N+'</td>'+
                                    '<td>'+v.max_output_B_L2N+'</td>'+
                                    '<td>'+v.max_output_Avg_L2N+'</td>'+
                                    '<td>'+v.min_output_R_L2N+'</td>'+
                                    '<td>'+v.min_output_Y_L2N+'</td>'+
                                    '<td>'+v.min_output_B_L2N+'</td>'+
                                    '<td>'+v.min_output_Avg_L2N+'</td>'+
                                    '<td>'+v.max_output_P2P_RY+'</td>'+
                                    '<td>'+v.max_output_P2P_YB+'</td>'+
                                    '<td>'+v.max_output_P2P_BR+'</td>'+
                                    '<td>'+v.max_output_Avg_P2P+'</td>'+
                                    '<td>'+v.min_output_P2P_RY+'</td>'+
                                    '<td>'+v.min_output_P2P_YB+'</td>'+
                                    '<td>'+v.min_output_P2P_BR+'</td>'+
                                    '<td>'+v.min_output_Avg_P2P+'</td>'+
                                    '<td>'+v.max_output_cur_R+'</td>'+
                                    '<td>'+v.max_output_cur_Y+'</td>'+
                                    '<td>'+v.max_output_cur_B+'</td>'+
                                    '<td>'+v.max_output_Avg+'</td>'+
                                    '<td>'+v.min_output_cur_R+'</td>'+
                                    '<td>'+v.min_output_cur_Y+'</td>'+
                                    '<td>'+v.min_output_cur_B+'</td>'+
                                    '<td>'+v.min_output_Avg+'</td>'+
                                    '<td>'+v.max_out_frq+'</td>'+
                                    '<td>'+v.min_out_frq+'</td>'+
                                '</tr>');
                        });
                     }
                     else{
                        $('#table_data').html('<tr>'+
                                 '<td class="text-danger" style="text-align:center;" colspan="31">No Record Found !!</td>'+
                              '</tr>');
                     }
                }

		}
		
	});
}


</script>



</script><script src="<?php echo base_url(); ?>assets/local/excel/xlsx.full.min.js"></script>
<script type="text/javascript">
	
	function export_report() {
	  var sheetName = "Sheet1";
	  var fileName = "Max Min Value Report.xlsx";
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
        get_max_and_min_value();
    
    },60000);
</script>
