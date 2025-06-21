<div class="page-wrapper">
<!-- Page Content -->
    <div class="content container-fluid">
    	<!-- Page Header -->
			<div class="page-header">
				<div class="row">
					<div class="col-sm-12">
						<h3 class="page-title">Flag Unflag Report</h3>
						<ul class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard_c');?>">Dashboard</a></li>
							<li class="breadcrumb-item ">Flag Unflag Report</li>
							
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
                                <h3><b>Flag Unflag Report</b></h3>
                            </div>
                            <div class="col-md-6 d-md-flex justify-content-end">
                                <div>
                                    <button class="btn btn-sm  btn-success" onclick="export_report();">Export</button>
                                    <button class="btn btn-sm  btn-primary" onclick="printdetails();" >PDF</button>
                                    
                                </div>
                            </div>
                    	</div>
                    	<div class="row">
                    	    
								<div class="form-group col-md-3 mt-2">
                                    <h5><b>Area Name</b></h5>
                                    <select name="site_id" id="site_id" class="form-control select2" onchange="flag_unflag_list();get_well_list();">
                                       <?php
                                    $user_type = $this->session->userdata('user_type', true);
                                    $role_type = $this->session->userdata('role_type',true);
                                   if ($user_type == 3 && $role_type == 2) {
                                       if (!empty($site_list)) {
                                            
                                            foreach ($site_list as $key => $value) {
                                                ?>
                                                <option value="<?php echo $value['id']; ?>"> <?php echo $value['well_site_name']; ?></option>
                                                <?php
                                            }
                                        }
                                    } else {
                                        if (!empty($site_list)) {
                                            echo '<option value="">All Area</option>'; 
                                            foreach ($site_list as $key => $value) {
                                                ?>
                                                <option value="<?php echo $value['id']; ?>"> <?php echo $value['well_site_name']; ?></option>
                                                <?php
                                            }
                                        }
                                    }
                                    ?>
                                    </select>
                                </div>
              
                           
								<div class="form-group col-md-3 mt-2">
									<h5><b>Well No</b></h5>
									<select name="well_id" id="well_id" class="form-control select2" onchange="flag_unflag_list();">
										<option value=""> All Well </option>
									</select>
								</div>

								<div class="form-group col-md-3 mt-2">
								    <h5><b>From Date</b></h5>
								    <input type="date" name="from_date" id="from_date" value="<?php echo date('Y-m-d'); ?>" class="form-control" onchange="flag_unflag_list();">
								</div>

								<div class="form-group col-md-3 mt-2">
								    <h5><b>To Date</b></h5>
								    <input type="date" name="to_date" id="to_date"  value="<?php echo date('Y-m-d'); ?>" class="form-control" onchange="flag_unflag_list();">
								</div>
								<div class="form-group col-md-3 mt-2">
									<h5><b>Flag Status</b></h5>
									<select name="status_well" id="status_well" class="form-control select2" onchange="flag_unflag_list();">
										<!-- <option value="">Select</option> -->
										<option value="1">Flag Well</option>
										<option value="0">UnFlag Well</option>
									</select>
								</div>

							</div>
							
                            <div id="GFGdata">
                            	<div class="card-body">
							    <div class="table-responsive mt-4"   id="well_wise_table_export">
								<table class="table table-bordered border-bottom">
									<thead class="bg-light text-center">
										<tr>
											<th colspan="8" class="text-uppercase" style="font-size: 20px;font-weight: bolder;">IOT Based Real Time Well Monitoring System ONGC,CAMBAY Asset</th>
										</tr>
										<tr>
											<th colspan="8" class="text-uppercase" style="font-size: 15px;font-weight: bolder;" id="date_heading"></th>
										</tr>
										</thead>
									</table>
									<table class="table table-bordered border-bottom">
										<tr>
											<th>S.No</th>
										    <th>Well Name</th>
								            <th>Reason for Flagging</th>
								            <th>Current Status</th>
								            <th>Flagged By</th>
								            <th>Flagging Date and Time</th>
								            <th>Unflagged By</th>
								            <th>Unflagging Date and Time</th>
								        </tr>
									
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

get_well_list();
function get_well_list() { 
    let company_id = "<?php echo $this->session->userdata('company_id') ?>";
    let user_id = "<?php echo $this->session->userdata('user_id') ?>";
    let assets_id = "<?php echo $this->session->userdata('assets_id') ?>";
    let site_id = $('#site_id').val();
    

    $.ajax({
        type: 'POST',
        url: '<?php echo base_url();?>Flag_unflag_report_c/Well_list',
        data: { company_id: company_id, assets_id: assets_id, site_id: site_id, user_id: user_id, },
        success: function(data) {
            data = JSON.parse(data);
           
            if (data.response_code == 200) {   
                if (data.data.length > 0) {
                    $('#well_id').html('');
                    $('#well_id').html('<option value="">Select Well</option>');
                    $.each(data.data, function(i, v) {
                     
                        $('#well_id').append('<option value="' + v.well_id + '">' + v.well_name + '</option>');
                    });
                } else {
                    $('#well_id').html('<option value="">No Well Found</option>');
                }
            } else {
                swal('error', data.msg, 'error');
            }   
        }
    });
}


</script>

<script type="text/javascript">

	flag_unflag_list();
	function flag_unflag_list() {
    $('#date_table_data').html('<tr><td colspan="11">processing please wait.......</td></tr>');
    var from_date = $('#from_date').val();
    var to_date = $('#to_date').val();
    var site_id = $('#site_id').val();
    var well_id = $('#well_id').val();
    var status = $('#status_well').val();
    // alert(status);
    
    var selectedsiteName = $('#site_id option:selected').text();
    var selectedwellName = $('#well_id option:selected').text();
   
    let formattedToDate = moment(to_date, 'YYYY-MM-DD').format('DD-MM-YYYY');
    let formattedFromDate = moment(from_date, 'YYYY-MM-DD').format('DD-MM-YYYY');
    let headingText = ` ${selectedsiteName}  Flag UnFlag Log Report of  ${formattedToDate} To ${formattedFromDate}   `;
    $('#date_heading').text(headingText);
  
   
    $.ajax({
        url: '<?php echo base_url(); ?>Flag_unflag_report_c/flag_log_report',
        method: 'POST',
        data: { well_id:well_id,site_id:site_id,from_date:from_date,to_date:to_date,status:status },
        success: function (res) {
            var response = JSON.parse(res);
       
            if (response.response_code == 200) {
                $('#table_data').html("");
                if (response.data.length > 0) {
                   
                    $.each(response.data, function (i, v) {

                    	var flag_status = v.flag_status;
                    	if(flag_status == 1)
                    	{
                    		flag_data = 'flag Well';
                    		text_color ='#800000'
                    	}else if(flag_status == 0)
                    	{
                    		flag_data = 'Unflag Well';
                    		text_color ='blue'
                    	}else{
                    		flag_data = '';
                    	}
                        

                        $("#table_data").append('<tr>' +
						    '<td>' + (i + 1) + '</td>' +
						    '<td>' + (v.well_name ? v.well_name : '') + '</td>' +
						    '<td>' + (v.reason_name ? v.reason_name : '') + '</td>' +
						    '<td style="color:'+text_color+';">' + flag_data + '</td>' +
						    '<td>' + (v.c_user ? v.c_user : '') + ' (' + (v.createuser ? v.createuser : '') + ')</td>' +
						    '<td>' + (v.c_date ? moment(v.c_date).format('DD-MM-YYYY h:mm:ss a') : '') + '</td>' +
						    
						    '<td>' + (v.updateeuser ? v.updateeuser : '') + 
						           (v.d_user ? ' (' + v.d_user + ')' : '') + '</td>' +
						   '<td>' + (v.d_date ? moment(v.d_date).format('DD-MM-YYYY h:mm:ss a') : '') + '</td>' +
						    '</tr>');
						});


                } else {
                    $('#table_data').html('<tr>' +
                        '<td class="text-danger" style="text-align:center;" colspan="11">No Record Found !!</td>' +
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
	  var fileName = "Well flag_unflag Log.xlsx";
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
                font-size: 10px; 
                padding: 1px;
                border: 1px solid black; 
            }

            .no-print {
                display: none;
            }
        }
    </style>
<script>
    function printdetails() {
        var printDiv = "#GFGdata"; 
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
	 