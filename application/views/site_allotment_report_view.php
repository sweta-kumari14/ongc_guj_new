area_running_well_list<div class="page-wrapper">
<!-- Page Content -->
    <div class="content container-fluid">
    	<!-- Page Header -->
			<div class="page-header">
				<div class="row">
					<div class="col-sm-12">
						<h3 class="page-title">Site Allotment Report</h3>
						<ul class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard_c');?>">Dashboard</a></li>
							<li class="breadcrumb-item ">Site Allotment Report</li>
							
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
		                            <h4 class="header-title mb-4">Site Allotment Report</h4>
		                        </div>
					            <div class="col-auto float-end ms-auto">
					            	<a href="<?php echo base_url('Dashboard_c'); ?>"><button type="button" class="btn btn-sm btn-info">Back</button></a>
						            <button class="btn btn-sm  btn-success" onclick="export_report();">Export</button>
					            </div>
			                </div>
			                <div class="card-body">
							<div class="row">
								<div class="form-group col-md-4 mt-2">
									<h5><b>Area Name</b></h5>
									<select name="area_id" id="area_id" class="form-control select2" onchange="get_sitewise_user_allotment_data();get_sitelist();">
										<option value=""> Select Area </option>
										<?php 
										if (!empty($area_list))
										{
											foreach ($area_list as $key => $value)
											{
												?>
													<option value="<?php echo $value['id']; ?>"><?php echo $value['area_name']; ?></option>

												<?php
											}
										}

										?>
									</select>
								</div>
								<div class="form-group col-md-4 mt-2">
									<h5><b>Site Name</b></h5>
									<select name="site_id" id="site_id" class="form-control select2" onchange="get_sitewise_user_allotment_data();">
										<option value=""> Select Site </option>
										
									</select>
								</div>

								<div class="form-group col-md-4 mt-2">
									<h5><b>User Name</b></h5>
									<select name="user_id" id="user_id" class="form-control select2" onchange="get_sitewise_user_allotment_data();">
										<option value=""> Select User </option>
										<?php 
										if (!empty($user_list))
										{
											foreach ($user_list as $key => $value)
											{
												?>
													<option value="<?php echo $value['id']; ?>"><?php echo $value['user_full_name']; ?></option>

												<?php
											}
										}

										?>
									</select>
								</div>

								<div class="form-group col-md-4 mt-2">
									<h5><b>From Date</b></h5>
									<input type="date" name="from_date" id="from_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" onchange="get_sitewise_user_allotment_data();get_sitedate();">
								</div>

								<div class="form-group col-md-4 mt-2">
									<h5><b>To Date</b></h5>
									<input type="date" name="to_date" id="to_date" class="form-control"  value="<?php echo date('Y-m-d'); ?>" onchange="get_sitewise_user_allotment_data();get_sitedate();">
								</div>
								
							</div>
                                	
                             <div class="table-responsive mt-4">
								<table class="table table-striped custom-table mb-0 datatable" id="data-table">
									<tr>
											<th colspan="7" class="text-uppercase text-center" style="font-size: 20px;font-weight: bolder;">IOT Based Real Time Well Monitoring System ONGC,CAMBAY Asset</th>
										</tr>
										<tr>
											<th colspan="7" class="text-uppercase text-center" style="font-size: 15px;font-weight: bolder;">Site Allotment Report as on <span id="show_from_date"></span> <span id="to">To</span> <span id="show_to_date"></span></th>
										</tr>
										<tr>
											<th style="width:10%;">Sl No.</th>
											<th>User Name</th>
											<th>User Level</th>
											<th>Area Name</th>
											<th>Site Name</th>
											<th>Well Name</th>
											<th>Assign Date</th>
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
        get_sitedate();
    function get_sitedate()
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
	
	function get_sitelist()
    {
    	let company_id = "<?php echo $this->session->userdata('company_id') ?>";
        let area_id = $('#area_id').val();
        // alert(area_id);
         $.ajax({
            url: '<?php echo base_url(); ?>Company_device_receiving_report_c/get_site_list',
            type: 'POST',
            data: {company_id:company_id,area_id: area_id},
            success:function(res)
            {
                response = JSON.parse(res);
                console.log(response);
                if(response.data.length>0)
                {
                    $('#site_id').html('<option value="">Select site</option>');
                    $.each(response.data,function(i,v){
                        $('#site_id').append('<option value="'+v.id+'">'+v.well_site_name+'</option>');
                    });
                }
            }
        });
    }
</script>

<script type="text/javascript">
    
get_sitewise_user_allotment_data();
function get_sitewise_user_allotment_data()
{
	let company_id = "<?php echo $this->session->userdata('company_id') ?>";
	let from_date = $('#from_date').val();
	let to_date = $('#to_date').val();
	let site_id = $('#site_id').val();
	let user_id = $('#user_id').val();
	let area_id = $('#area_id').val();

	$.ajax({
    url: '<?php echo base_url(); ?>Company_device_receiving_report_c/userwise_site_report',
    method: 'POST',
    data: {company_id:company_id, from_date:from_date, to_date:to_date, site_id:site_id, user_id:user_id, area_id:area_id},
    success: function(res) {
        var response = JSON.parse(res);
        console.log(response);
        if (response.response_code == 200) {
            var count = 0; // declare a count variable
            $('#table_data').html("");
            if (response.data.length > 0) {
                var prev_user_id = null;
                $.each(response.data, function(i, v) {
                    var role_type = '';
                    if (v.role_type == '1') {
                        role_type = "Assets level";
                    } else if (v.role_type == '2') {
                        role_type = "Area level";
                    } else if (v.role_type == '3') {
                        role_type = "installation level";
                    }
                    if (v.user_id != prev_user_id) {
                        $("#table_data").append('<tr>'+
                            '<td>'+(++count)+'</td>'+ // increment count here
                            '<td>'+v.user_full_name+'</td>'+
                            '<td>'+role_type+'</td>'+
                            '<td>'+v.area_name+'</td>'+
                            '<td>'+v.well_site_name+'</td>'+
                            '<td>'+v.well_name+'</td>'+
                            '<td>'+moment(v.allotment_datetime).format('DD-MM-YYYY h:mm:ss a')+'</td>'+
                            '</tr>');
                        prev_user_id = v.user_id;
                    } else {
                        var prev_row = $("#table_data tr").last();
                        prev_row.find("td:first").attr("rowspan", function(i, val) {
                            return parseInt(val) + 1;
                        });
                        prev_row.after('<tr>'+
                            '<td colspan="3">-</td>'+
                            '<td>'+v.area_name+'</td>'+
                            '<td>'+v.well_site_name+'</td>'+
                            '<td>'+v.well_name+'</td>'+
                            '<td>'+moment(v.allotment_datetime).format('DD-MM-YYYY h:mm:ss a')+'</td>'+
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
	  var fileName = "Site Allotment Report.xlsx";
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