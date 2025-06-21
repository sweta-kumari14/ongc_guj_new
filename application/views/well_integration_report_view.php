<div class="page-wrapper">
<!-- Page Content -->
    <div class="content container-fluid">
    	<!-- Page Header -->
			<div class="page-header">
                <div class="row align-items-center justify-content-between">
                   <div class="col">
                       <h3 class="page-title">Well Add/Replace/Shifting Request Report</h3>
                   </div>
                   <div class="col-auto">
                       <a href="<?php echo base_url('Well_Integration_c'); ?>" class="btn btn-primary">Add Request</a>
                        <?php
	                      $user_type = $this->session->userdata('user_type', true);
	                      $role_type = $this->session->userdata('role_type', true);

	                      if ($user_type == 3 && $role_type == 3) { ?>
	                         <button class="btn btn-success" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"> Add Well Feeder
	                        </button>
	                   <?php } ?>

                  </div>
                 
                </div>
            </div>
			<!-- /Page Header -->
		    <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                    	<div class="card-header" style="background :linear-gradient(to left, #E29990 , #5D6D7E );border-radius: 5px;">
							<div class="row">
								<div class="form-group col-md-3 mt-2">
                                    <h5 style="color:white;"><b>Area Name</b></h5>
                                    <select name="site_id" id="site_id" class="form-control select2" onchange="get_integartion_well();get_count_complain_data();">
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
									<h5 style="color:white;"><b>From Date</b></h5>
									<input type="date" name="from_date" id="from_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" onchange="get_integartion_well();get_count_complain_data();">
								</div>

								<div class="form-group col-md-3 mt-2">
									<h5 style="color:white;"><b>To Date</b></h5>
									<input type="date" name="to_date" id="to_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" onchange="get_integartion_well();get_count_complain_data();">
								</div>

								<div class="form-group col-md-3 mt-2">
									<h5 style="color:white;"><b>Sort By</b></h5>
									<select name="sort_by" id="sort_by" class="form-control select2" onchange="get_integartion_well();">
										<option value="">Select Sort</option>
										<option value="well_name">Well name</option>
										<option value="well_type">Well Type</option>
										<option value="device_name">Device Name</option>
										<option value="imei_no">Imei No</option>
										<option value="to_well_name">To Well</option>
										<option value="to_device_name">To Well Device Name</option>
										<option value="to_imei_no">To Well Imei No</option>
										<option value="reason_remove">Remove reason</option>
										<option value="tentative_date">Tentative Date</option>
									</select>
								</div>
								
							</div>
						</div>
						<div class="col-md-12 mt-4">
			                <div class="card" style="background: linear-gradient(to left,#AEA4A2, #D88D82);">
				            <div class="card-body">
					            <div class="row align-items-center"> 
						           <div class="col-xl-12">
							          <div class="row">
							          	<div class="col-xl-4 col-sm-4 col-6">
										<div class="card ov-card" style="height:87%;box-shadow: 0 4px 8px rgba(44, 62, 80);">
											<div class="card-body">
												<div class="ana-box">	
													<div class="ic-n-bx">
														<div class=" text-center bd-warning rounded-circle">
		                                                    <img src="<?php echo base_url(); ?>assets/img/controls.gif" width="45" style="border-radius: 50%; border: 5%;">
														</div>
													</div>
													<div class="anta-data mt-4">
														<h3 class="text-center" id="total_request"></h3>
														<h5 class="text-center">Total Requested</h5>
													</div>
												</div>
											</div>
										</div>
								
								</div>
							
						                 <div class="col-xl-4 col-sm-4 col-6">
										<div class="card ov-card" style="height:87%;box-shadow: 0 4px 8px rgba(44, 62, 80);">
											<div class="card-body">
												<div class="ana-box">	
													<div class="ic-n-bx">
														<div class=" text-center bd-warning rounded-circle">
		                                                    <img src="<?php echo base_url(); ?>assets/img/working.gif" width="45" style="border-radius: 50%; border: 5%;">
														</div>
													</div>
													<div class="anta-data mt-4">
														<h3 class="text-center" id="total_pending"></h3>
														<h5 class="text-center">Total Pending</h5>
													</div>
												</div>
											</div>
										</div>
								
								</div>
							
								<div class="col-xl-4 col-sm-4 col-6">
									
									<div class="card ov-card" style="height:87%;box-shadow: 0 4px 8px rgba(44, 62, 80);">
	                                    <div class="card-body">
											<div class="ana-box">	
												<div class="ic-n-bx">
													<div class=" text-center rounded-circle">
	                                                    <img src="<?php echo base_url(); ?>assets/img/complete.gif" width="45" style="border-radius: 50%; border: 5%;">
													</div>
												</div>
												<div class="anta-data mt-4">
													<h3 class="text-center" id="total_solved"></h3>
													<h5 class="text-center">Total Solved</h5>
												</div>
											</div>
										</div>
									</div>
							
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
						<div class="card-body">
                            <div class="col-md-12 mt-2">
	                            <div class="row mt-2 ml-3 text-center">
	                                <div class="col-lg-12">
	                                    <div class="row align-items-center">
						                    <div class="col-auto float-end ms-auto">
						            	       <a href="<?php echo base_url('Dashboard_c'); ?>"><button type="button" class="btn btn-sm btn-info">Back</button></a>
							                   <button class="btn btn-sm  btn-success" onclick="export_report();">Export</button>
						                    </div>
				                        </div>
                                  <div class="table-responsive mt-4">
								        <table class="table table-bordered border-bottom table-striped" id="data-table">
									    <thead>
									    <tr>
											<th colspan="20" class="text-uppercase text-center" style="font-size: 20px;font-weight: bolder;">IOT Based Real Time Well Monitoring System ONGC,CAMBAY Asset</th>
										</tr>
										<tr>
											<th colspan="20" class="text-uppercase text-center" style="font-size: 15px;font-weight: bolder;" id="report-heading"></th>
										</tr>
										<tr style="text-align: center;">
											<th style="width:10%;">Sl No.</th>
											 <?php if ($this->session->userdata('user_type') == 3 && $this->session->userdata('role_type') == 3): ?>
                                            <th>Action</th>
                                            <?php endif; ?>
											<th>Ticket Id</th>
											<th>Well Name</th>
											<th>Request Type</th>
											<th>Device Name</th>
											<th>Imei No</th>
											<th>To Well</th>
											<th>Well Availibility</th>
											<th>To Well Device Name</th>
											<th>To Well Imei No</th>
											<th>Reason</th>
											<th>Request Status</th>
											<th>Request By</th>
											<th>Request Date Time</th>
											<th>Solved By</th>
											<th>Solved Date Time</th>
											<th>Resolution Time</th>
											
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
<div class="col-md-4">
    <div class="offcanvas offcanvas-end" tabindex="-1" id="EditComplaint" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h4 id="offcanvasRightLabel"><b>Edit Well Add/Replace/Shifting Request</b></h4>
                <button type="button" class="btn-close text-reset btn-primary" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <hr class="colored-hr">
        <div class="offcanvas-body" id="model_data">
        </div>
    </div>
</div>
<!-- feeder add  -->
        <div class="col-md-4">
           <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
              <div class="offcanvas-header">
                  <h3 id="offcanvasRightLabel"><b>Add Well Feeder</b></h3>
                  <button type="button" class="btn-close text-reset btn-primary" data-bs-dismiss="offcanvas" aria-label="Close"></button>
              </div>

               <hr class="colored-hr">
                <div class="offcanvas-body ">
                	<div class="card-body">
                	 <form class="custom-validation" method="POST" action="<?php echo base_url('Well_Integration_c/update_feeder_well'); ?>" enctype="multipart/form-data">
                             
                                    <div class="form-group col-md-12 mt-2" >
                                        <h4><b> Well Name<span style="color:red">*</span></b></h4>
                                        <select name="well_id" id="well_id" class="form-control" onchange="get_well_data()"required>
                                        <option value="">Select Well</option>
                                            <?php 
                                                foreach ($well_list as $key => $value) 
                                                {
                                                    ?>
                                                        <option  value="<?php echo $value['well_id'];?>"><?php echo $value['well_name']; ?></option>
                                                    <?php
                                                }
                                            ?>
                                        </select>
                                       
                                    </div>
                                     <div class="form-group col-md-12 mt-2" >
                                        <h4><b> Feeder Name<span style="color:red">*</span></b></h4>
                                        <select name="feeder_id" id="feeder_id" class="form-control" required>
                                        <option value="">Select Feeder</option>
                                            <?php 
                                                foreach ($feeder_list as $key => $value) 
                                                {
                                                    ?>
                                                        <option  value="<?php echo $value['id'];?>"><?php echo $value['feeder_name']; ?></option>
                                                    <?php
                                                }
                                            ?>
                                        </select>
                                       
                                    </div>
                                  
                                <div class="footer mt-4">
                                    <div>
                                        <button type="submit" class="btn btn-sm btn-primary" >Submit</button>
                                    </div>
                                </div>
                                
                            </form>
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

  function EditComplaint(ticket_id,well_type)
    {
       
        $.ajax({
        url:"<?php echo base_url();?>Well_Integration_c/edit_complaints",
        method:"POST",
        data:{ticket_id: ticket_id,well_type:well_type},
        success:function(data){
            console.log( data);
            $('#model_data').html(data);

            }
        })
    }
get_count_complain_data();
    function get_count_complain_data()
    {
        let company_id = '<?php echo $this->session->userdata('company_id') ?>';
        let from_date = $('#from_date').val();
        let to_date = $('#to_date').val();
        let site_id = $('#site_id').val();
        let complaint_status = $('#complaint_status').val();

         $.ajax({
           url: '<?php echo base_url();?>Well_Integration_c/get_total_count',
           type: 'POST',
           data: {company_id:company_id,from_date:from_date,to_date:to_date,site_id:site_id,complaint_status:complaint_status},
           success: function (res) {
               res = JSON.parse(res);
               console.log(res,'wellcount');
               if(res.response_code==200)
                {
                	$('#total_request').text(res.data.total_request);
                    $('#total_pending').text(res.data.total_pending);
                    $('#total_solved').text(res.data.total_solved);
                  

                }else
                {
                    
                    swal('error',res.msg,'error');
                }
              
           },
       }); 
    }  

get_integartion_well();
function get_integartion_well() {
    let company_id = "<?php echo $this->session->userdata('company_id') ?>";
    let from_date = $('#from_date').val();
    let to_date = $('#to_date').val();
    let site_id = $('#site_id').val();
    let sort_by = $('#sort_by').val();

    var user_type = '<?php echo $this->session->userdata('user_type') ?>';
    var role_type = '<?php echo $this->session->userdata('role_type') ?>';

    var selectedsiteName = $('#site_id option:selected').text();
    let formattedFromDate = moment(from_date, 'YYYY-MM-DD').format('DD-MM-YYYY');
    let formattedToDate = moment(to_date, 'YYYY-MM-DD').format('DD-MM-YYYY');

    let headingText = ` ${selectedsiteName} Well Add/Replace/Shifting Request Report ${formattedFromDate} to ${formattedToDate} `;
    $('#report-heading').text(headingText);

    $.ajax({
        url: '<?php echo base_url(); ?>Well_Integration_c/get_integration_details_report',
        method: 'POST',
        data: {company_id: company_id, from_date: from_date, to_date: to_date, site_id: site_id, sort_by: sort_by},
        success: function(res) {
            var response = JSON.parse(res);
            
            if (response.response_code == 200) {
                $('#table_data').html("");
                
                if (response.data.length > 0) {
                    $.each(response.data, function(i, v) {
                        var request_type = '';
                        var well_avail = 'NA';

                        if (v.well_type == '0') {
                            request_type = "Add New Well";
                        } else if (v.well_type == '1') {
                            request_type = "Remove Well";
                        } else if (v.well_type == '2') {
                            request_type = "Shift Well";
                            well_avail = (v.well_status == 0) ? 'Available well' : (v.well_status == 1) ? 'New Well' : 'NA';
                        }

                        var requested_date = v.c_date ? moment(v.c_date).format('DD-MM-YYYY h:mm:ss a') : "NA";
                        var solved_date = v.d_date ? moment(v.d_date).format('DD-MM-YYYY h:mm:ss a') : "NA";

                        var to_well_name = v.to_well_name ? v.to_well_name : "NA";

                        let resolution_time = 'NA';
                        if (v.c_date && v.d_date) {
                            let start_time = moment(v.c_date);
                            let end_time = moment(v.d_date);
                            let duration = moment.duration(end_time.diff(start_time));

                            let hours = Math.floor(duration.asHours());
                            let minutes = Math.floor(duration.asMinutes()) % 60;

                            resolution_time = `${hours} hr ${minutes} min`;
                        }

                        var complaint_status = v.execution_status;  
                        var well_type = v.well_type;  
                        var rtms_status = '';  

                        if (complaint_status == 0) {
                            rtms_status = '<button class="btn btn-sm btn-rounded btn-pill btn-primary" style="color:white;white-space: nowrap;">Pending</button>';
                        } else if (complaint_status == 1) {
                            if (well_type == 0) {
                                rtms_status = '<button class="btn btn-sm btn-rounded btn-pill btn-success" style="color:white;white-space: nowrap;">Installation Done</button>';
                            } else if (well_type == 1) {
                                rtms_status = '<button class="btn btn-sm btn-rounded btn-pill btn-danger" style="color:white;white-space: nowrap;">Removed Done</button>';
                            } else if (well_type == 2) {
                                rtms_status = '<button class="btn btn-sm btn-rounded btn-pill btn-warning" style="color:white;white-space: nowrap;">Shifting Done</button>';
                            }
                        }
                        let editButton = "";
                        if (user_type == 3 && role_type == 3) {
                            editButton = '<a id="' + v.ticket_id + '" data-bs-toggle="offcanvas" data-bs-target="#EditComplaint" aria-controls="offcanvasRight" onclick="EditComplaint(this.id, \'' + v.well_type + '\');">' +
                                '<i class="fas fa-edit" style="color: #28B463; margin-right: 10px; font-size: 15px; cursor: pointer;"></i>' +
                             '</a>';

                        }

                        $("#table_data").append(`
                            <tr>
                                <td>${i + 1}</td>
                                ${user_type == 3 && role_type == 3 ? '<td>' + editButton + '</td>' : ''}  
                                <td>
                                    <button class="btn btn-sm btn btn-success" type="button" data-bs-toggle="offcanvas" data-bs-target="#model2" aria-controls="offcanvasRight">
                                        ${v.ticket_id}
                                    </button>
                                </td>
                                <td>${v.well_name}</td>
                                <td>${request_type}</td>
                                <td>${v.device_name ? v.device_name : 'NA'}</td>
                                <td>${v.imei_no ? v.imei_no : 'NA'}</td>
                                <td>${to_well_name}</td>
                                <td>${well_avail}</td>
                                <td>${v.to_device_name ? v.to_device_name : 'NA'}</td>
                                <td>${v.to_imei_no ? v.to_imei_no : 'NA'}</td>
                                <td>${v.reason_remove ? v.reason_remove : 'NA'}</td>
                                <td>${rtms_status}</td>
                                <td>${v.request_user_data ? v.request_user_data : 'NA'}</td>
                                <td>${requested_date}</td>
                                <td>${v.operation_user_data ? v.operation_user_data : 'NA'}</td>
                                <td>${solved_date}</td>
                                <td>${resolution_time}</td>
                            </tr>
                        `);
                    });
                } else {
                    $('#table_data').html('<tr>' +
                        '<td class="text-danger text-center" colspan="17">No Record Found !!</td>' +
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
	  var fileName = "Well Integration Report.xlsx";
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
