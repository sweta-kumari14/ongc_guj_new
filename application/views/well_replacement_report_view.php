<div class="page-wrapper">
    <div class="content container-fluid pb-0">
    	<div class="page-header">
			<div class="content-page-header">
				<h5>Device Shifting Report</h5>
			</div>	
		</div>
			<div class="row">					
						<!-- Lightbox -->
                        <div class="col-lg-12">
                            <div class="card">
                               
                                <div class="card-body">
                                   <div class="row align-items-center">
                                        <div class="col">
                                           <h4 class="header-title mb-4"><b>Device Shifting Report</b></h4>
                                        </div>
                                        <div class="col-auto float-end ms-auto">
                                             <button class="btn btn-success btn-sm btn-rounded mx-2" onclick="export_report()" style="font-size: 14px;">Export</button>
                                        </div>
                                    </div>


                                    
                                <div class="row">
                                        <div class="form-group col-md-4 mt-2">
                                    <h5><b>Well name</b></h5>
                                    <select name="well_id" id="well_id" class="form-control select2" onchange="get_well_replacement_report();">
                                        <option value="">Select Well </option>
                                            <?php 
                                            if(!empty($well_list))
                                            {
                                                foreach ($well_list as $key => $value) 
                                                {
                                                    ?>
                                                        <option value="<?php echo $value['well_id']; ?>"><?php echo $value['well_name']?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-4 mt-2">
                                    <h5><b>From Date</b></h5>
                                    <input type="date" name="from_date" id="from_date" class="form-control" onchange="get_well_replacement_report();">
                                </div>

                                <div class="form-group col-md-4 mt-2">
                                    <h5><b>To Date</b></h5>
                                    <input type="date" name="to_date" id="to_date" class="form-control" onchange="get_well_replacement_report();">
                                </div>
                            </div>


                             <div class="table-responsive mt-4">
                                <table class="table table-bordered border-bottom table-striped" id="data-table">
                                      <thead style="background-color:blue; color: white; text-align: center;">
                                        <tr>
                                           <th colspan="10" class="text-uppercase" style="font-size: 20px;font-weight: bolder;">Oil and Natural Gas Corporation</th>
                                        </tr>
                                        <tr>
                                            <th colspan="14" class="text-uppercase" style="font-size: 15px;font-weight: bolder;">Device Shifting Report as on <?php echo date('d-m-Y h:i:s a') ?></th>
                                        </tr>
                                        <tr>
                                            <th style="width:10%;">Sl No.</th>
                                            <th>From Well Name</th>
                                            <th>From Well Device Name</th>
                                            <th>From Well IMEI No</th>
                                            <th>To Well Name</th>
                                            <th>To Well Previous Device Name</th>
                                            <th>To Well Previous IMEI No</th>
                                            <th>To Well Current Device Name</th>
                                            <th>To Well Current IMEI No</th>
                                            <th>Shifted Date-Time</th>
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

get_well_replacement_report();
function get_well_replacement_report()
{
    let company_id = "<?php echo $this->session->userdata('company_id') ?>";
    // alert(company_id);
    let user_id = "<?php echo $this->session->userdata('user_id') ?>";
    // alert(user_id);
    let from_date = $('#from_date').val();
    let to_date = $('#to_date').val();
    let well_id = $('#well_id').val();
    
    $.ajax({
        url:'<?php echo base_url(); ?>Well_replacement_report_c/get_shifted_well_data',
        method:'POST',
        data:{company_id:company_id,user_id:user_id,from_date:from_date,to_date:to_date,well_id:well_id},
        success:function(res)
        {
            var response = JSON.parse(res);
            console.log(response);
             if (response.response_code == 200) {
                $('#table_data').html("");
                if (response.data.length > 0) {
                    
                    $.each(response.data, function (i, v) {
                        
                            var allot_prv_device_name = v.allot_prv_device_name != null ? v.allot_prv_device_name :"NA";
                            var allot_prv_imei_no = v.allot_prv_imei_no != null ? v.allot_prv_imei_no :"NA";

                            $("#table_data").append('<tr>'+
                                    '<td>'+(i+1)+'</td>'+
                                    '<td>'+v.shifted_well_name+'</td>'+
                                    '<td>'+v.shifted_device_name+'</td>'+
                                    '<td>'+v.shifted_imei_no+'</td>'+
                                    '<td>'+v.allotted_well_name+'</td>'+
                                    '<td>'+allot_prv_device_name+'</td>'+
                                    '<td>'+allot_prv_imei_no+'</td>'+
                                    '<td>'+v.allot_current_device_name+'</td>'+
                                    '<td>'+v.allot_current_imei_no+'</td>'+
                                    '<td>'+moment(v.shifted_datetime).format('DD-MM-YYYY h:mm:ss a')+'</td>'+
                                '</tr>');
                        });
                     }
                     else{
                        $('#table_data').html('<tr>'+
                                 '<td class="text-danger" style="text-align:center;" colspan="14">No Record Found !!</td>'+
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
      var fileName = "Device Shifting Report.xlsx";
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
         
<!-- <div class="page-wrapper">
    <div class="content container-fluid pb-0">
    	<div class="page-header">
			<div class="content-page-header">
				<h5>Device Shifting Report</h5>
			</div>	
		</div>
			<div class="row">					
				<!-- Lightbox -->
                <div class="col-md-12">
                    <div class="card">
                       
                        <div class="card-body">
                           <div class="row align-items-center">
                                <div class="col">
                                   <h4 class="header-title mb-4"><b>Device Shifting Report</b></h4>
                                </div>
                                <div class="col-auto float-end ms-auto">
                                     <button class="btn btn-success btn-sm btn-rounded mx-2" onclick="export_report()" style="font-size: 14px;">Export</button>
                                </div>
                            </div>
            	        <div class="row">
                            <div class="form-group col-md-4 mt-2">
							<h5><b>Well name</b></h5>
							<select name="well_id" id="well_id" class="form-control select2" onchange="get_well_replacement_report();">
								<option value="">Select Well </option>
		                        	<?php 
		                            if(!empty($well_list))
		                            {
		                                foreach ($well_list as $key => $value) 
		                                {
		                                    ?>
		                                        <option value="<?php echo $value['well_id']; ?>"><?php echo $value['well_name']?></option>
		                                    <?php
		                                }
		                            }
		                            ?>
							</select>
						</div>

						<div class="form-group col-md-4 mt-2">
							<h5><b>From Date</b></h5>
							<input type="date" name="from_date" id="from_date" class="form-control" onchange="get_well_replacement_report();">
						</div>

						<div class="form-group col-md-4 mt-2">
							<h5><b>To Date</b></h5>
							<input type="date" name="to_date" id="to_date" class="form-control" onchange="get_well_replacement_report();">
						</div>
					</div>

					<div class="table-responsive">
						<table class="table table-bordered border-bottom table-nowrap" id="basic-datatable">
							<thead class="bg-light text-center">
								<tr>
									<th colspan="14" class="text-uppercase" style="font-size: 20px;font-weight: bolder;">IOT Based Real Time Well Monitoring System ONGC,CBM Asset Bokaro</th>
								</tr>
								<tr>
									<th colspan="14" class="text-uppercase" style="font-size: 15px;font-weight: bolder;">Device Shifting Report as on <?php echo date('d-m-Y h:i:s a') ?></th>
								</tr>
								<tr>
									<th style="width:10%;">Sl No.</th>
									<th>From Well Name</th>
									<th>From Well Device Name</th>
									<th>From Well IMEI No</th>
									<th>To Well Name</th>
									<th>To Well Previous Device Name</th>
									<th>To Well Previous IMEI No</th>
									<th>To Well Current Device Name</th>
									<th>To Well Current IMEI No</th>
									<th>Shifted Date-Time</th>
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
	</div> -->

<!-- <?php 
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
?> -->




<!-- <script type="text/javascript">

get_well_replacement_report();
function get_well_replacement_report()
{
	let company_id = "<?php echo $this->session->userdata('company_id') ?>";
	// alert(company_id);
	let user_id = "<?php echo $this->session->userdata('user_id') ?>";
	// alert(user_id);
	let from_date = $('#from_date').val();
	let to_date = $('#to_date').val();
	let well_id = $('#well_id').val();
	
	$.ajax({
		url:'<?php echo base_url(); ?>Well_replacement_report_c/get_shifted_well_data',
		method:'POST',
		data:{company_id:company_id,user_id:user_id,from_date:from_date,to_date:to_date,well_id:well_id},
		success:function(res)
		{
			var response = JSON.parse(res);
			console.log(response);
			 if (response.response_code == 200) {
                $('#table_data').html("");
                if (response.data.length > 0) {
                    
                    $.each(response.data, function (i, v) {
                        
                        	var allot_prv_device_name = v.allot_prv_device_name != null ? v.allot_prv_device_name :"NA";
                        	var allot_prv_imei_no = v.allot_prv_imei_no != null ? v.allot_prv_imei_no :"NA";

                            $("#table_data").append('<tr>'+
                                    '<td>'+(i+1)+'</td>'+
                                    '<td>'+v.shifted_well_name+'</td>'+
                                    '<td>'+v.shifted_device_name+'</td>'+
                                    '<td>'+v.shifted_imei_no+'</td>'+
                                    '<td><a href="<?php echo base_url('Area_Dashboard_c/get_single_well_detail_dashboard/'); ?>' + v.allot_well_id + '">' + v.allotted_well_name + '</a></td>' +
                                    // '<td>'+v.allotted_well_name+'</td>'+
                                    '<td>'+allot_prv_device_name+'</td>'+
                                    '<td>'+allot_prv_imei_no+'</td>'+
                                    '<td>'+v.allot_current_device_name+'</td>'+
                                    '<td>'+v.allot_current_imei_no+'</td>'+
                                    '<td>'+moment(v.shifted_datetime).format('DD-MM-YYYY h:mm:ss a')+'</td>'+
                                '</tr>');
                        });
                     }
                     else{
                        $('#table_data').html('<tr>'+
                                 '<td class="text-danger" style="text-align:center;" colspan="14">No Record Found !!</td>'+
                              '</tr>');
                     }
                }

		}
		
	});
}
</script>

 --><script src="<?php echo base_url(); ?>assets/local/excel/xlsx.full.min.js"></script>
<!-- <script type="text/javascript">
	
	function export_report() {
	  var sheetName = "Sheet1";
	  var fileName = "Shifting Report.xlsx";
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
 -->