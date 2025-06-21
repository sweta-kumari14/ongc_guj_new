<style type="text/css">
     .custom-tooltip {
        position: relative;
        display: inline-block;
        cursor: pointer;
    }

    .custom-tooltip[data-tooltip]:hover:after {
        content: attr(data-tooltip);
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        background-color: #333;
        color: #fff;
        padding: 5px 10px;
        border-radius: 5px;
        white-space: nowrap;
        font-size: 14px;
        z-index: 1000;
        opacity: 0;
        transition: opacity 0.3s;
    }

    .custom-tooltip[data-tooltip]:hover:after {
        opacity: 1;
    }

    .colored-hr {
    border-top: 2px solid orange; 
}


#content {
    margin-top: 50px;
    text-align: center;
}

section.timeline-outer {
    width: 80%;
    margin: 0 auto;
}

.timeline {
    border-left: 4px solid #42A5F5;
    border-bottom-right-radius: 2px;
    border-top-right-radius: 2px;
    box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
    color: #333;
    margin: 50px auto;
    letter-spacing: 0.5px;
    position: relative;
    line-height: 1.4em;
    padding: 20px;
    list-style: none;
    text-align: left;
}

.timeline h1,
.timeline h2,
.timeline h3 {
    font-size: 1.4em;
}



.timeline .event {
    border-bottom: 1px solid rgba(160, 160, 160, 0.2);
    padding-bottom: 15px;
    margin-bottom: 20px;
    position: relative;
}

.timeline .event:last-of-type {
    padding-bottom: 0;
    margin-bottom: 0;
    border: none;
}

.timeline .event:before,
.timeline .event:after {
    position: absolute;
    display: block;
    top: 0;
}

.timeline .event:before {
    left: -177.5px;
    color: #212121;
    content: attr(data-date);
    text-align: right;
    font-size: 16px;
    min-width: 120px;
}

.timeline .event:after {
    box-shadow: 0 0 0 8px #42A5F5;
    left: -30px;
    background: #212121;
    border-radius: 50%;
    height: 11px;
    width: 11px;
    content: "";
    top: 5px;
}

.timeline .event.one:after {
    box-shadow: 0 0 0 8px red;
    left: -30px;
    background: #fff;
}

.timeline .event.two:after {
    box-shadow: 0 0 0 8px orange;
    left: -30px;
    background: #fff;
}

.timeline .event.three:after {
    box-shadow: 0 0 0 8px #27ae60;
    left: -30px;
    background: #fff;
}

</style>
<!-- Page Wrapper -->
<div class="page-wrapper">
    <div class="content container-fluid">
    	<div class="page-header">

            <div class="row mt-2" id="main_heading">
                <div class="card card-body">
                    <div class="d-flex justify-content-evenly align-items-center">
                      
                        <div class="col-md-11 mb-0">
                            <h5 class="text-center" style="font-size:20px;font-family:Serif;font-weight: 900;">If you have any query please Contact this details Email-id :- iotasoperation@gmail.com , Contact No. - +91-8340127593 , Contact Person - Raushan Kumar</h5>
                        </div>
                    </div>
                </div>
            </div>
		
			 <div class="row align-items-center">
               
			 	 <div class="col">
					<h3 class="page-title">Device Complaint</h3>
					
				</div>

					<div class="col-auto float-end ms-auto">
                        
                        <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Add Device Complaint</button>
                        

                       
                    </div>



				</div>
			</div>
<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header" style="background :linear-gradient(to left, #E29990 , #5D6D7E );border-radius: 5px;">
						
						<div class="row">
							<div class="form-group col-md-4">
								<label style="color:white;"><b>Ticket ID</b></label>
								<select name="ticket_id" id="ticket_id" class="form-control select2" onchange="get_complaints_data();get_count_complain_data();" >
									<option value="">Select </option>
									<?php 
										if (!empty($ticket_list))
										{
											foreach ($ticket_list as $key => $value)
											{
												?>
													<option  value="<?php echo $value['ticket_id']; ?>"><?php echo $value['ticket_id']; ?></option>
												<?php
											}
										}
									?>
								</select>
							</div>

                            <div class="form-group col-md-4">
                                <label style="color:white;"><b>Complaint Status</b></label>
                                <select name="complaint_status" id="complaint_status" class="form-control select2" onchange="get_complaints_data();get_count_complain_data();" >
                                    <option value="">Select</option>
                                    <option value="0">Pending</option>
                                    <option value="1">In Progress</option>
                                    <option value="2">Solved</option>
                                    
                                </select>
                            </div>
                            <div class="form-group col-md-2" style="display:none;">
                                     <label style="color:white;"><b>Area Name</b></label>
                                    <select name="area_id" id="area_id" class="form-control select2" onchange="get_complaints_data();">
                                      
                                    <?php
                                    $user_type = $this->session->userdata('user_type', true);
                                    $role_type = $this->session->userdata('role_type',true);
                                    if ($user_type == 3 && $role_type == 2) {
                                       if (!empty($area_list)) {
                                            
                                            foreach ($area_list as $key => $value) {
                                                ?>
                                                <option value="<?php echo $value['id']; ?>"> <?php echo $value['area_name']; ?></option>
                                                <?php
                                            }
                                        }
                                    } else {
                                        if (!empty($area_list)) {
                                            echo '<option value="">Select All</option>'; 
                                            foreach ($area_list as $key => $value) {
                                                ?>
                                                <option value="<?php echo $value['id']; ?>"> <?php echo $value['area_name']; ?></option>
                                                <?php
                                            }
                                        }
                                    }
                                    ?>
                                    </select>
                                </div>

							<div class="form-group col-md-4">
								<label  style="color:white;"><b>From Date</b></label>
								 <input type="date" name="from_date" id="from_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" onchange="get_complaints_data();get_complaint_date();get_count_complain_data();">
							</div>

							<div class="form-group col-md-4">
								<label  style="color:white;"><b>To Date</b></label>
								<input type="date" name="to_date" id="to_date" class="form-control"  value="<?php echo date('Y-m-d'); ?>" onchange="get_complaints_data();get_complaint_date();get_count_complain_data();">
							</div>

                            <div class="form-group col-md-4">
                                <label  style="color:white;"><b>Sort By</b></label>
                                <select class="form-control select2" name="sort_by" id="sort_by" onchange="get_complaints_data();">
                                    <option value="">Select Column</option>
                                    <option value="ticket_id">Ticket Id</option>
                                    <option value="well_name">Well Name</option>
                                    <option value="device_name">Device Name</option>
                                    <option value="imei_no">Imei No</option>
                                    <option value="complaint_type">Reason For Complaint</option>
                                    <option value="complaint_status">Complaint Status</option>
                                    <option value="c_date">Date</option>
                                    <!-- <option value="raised_user_name">Raised User Name</option>
                                    <option value="progress_name">Progress User Name</option>
                                    <option value="sloved_name">Solved User Name</option> -->
                                </select>
                            </div>
							
						</div>
					</div>
					   <div class="card-body" id="GFG">
                            <div class="col-md-12 mt-2">
	                            <div class="row mt-2 ml-3 text-center">
	                                <div class="col-lg-12">
                                        <div class="row align-items-center">
                                            <div class="col-auto float-end ms-auto">
                                                <button class="btn btn-success btn-sm mx-2" onclick="export_report()" style="font-size: 14px;">Export</button>
                                                <button class="btn btn-sm  btn-primary" onclick="printReport();">PDF</button>
                                            </div>
                                            <div id="GFG">
                                            <div class="table-responsive mt-4"  id="data-table">
                                               <table class="table table-bordered border-bottom table-striped">
                                               <thead style="background-color:blue; color: white; text-align: center;">
                                        <tr>
                                          <th colspan="12" class="text-uppercase" style="font-size: 20px;font-weight: bolder;">IOT BASED REAL TIME WELL MONITORING SYSTEM ONGC,CAMBAY ASSET</th>
                                        </tr>
                                        <tr>
                                            <th colspan="12" class="text-uppercase" style="font-size: 15px;font-weight: bolder;">Device Complaint Report as on <span id="show_from_date"></span> <span id="to">To</span> <span id="show_to_date"></span></th>
                                        </tr>
                                     </thead>
                                 </table>
                                        <table class="table table-bordered border-bottom table-striped text-wrap">
                                      
                                        <tr>
                                            <th style="width:10%;">Sl No.</th>
                                            <th>Ticket ID</th>
                                            <th>Well Name</th>
                                            <th>Device Name</th>
                                            <th>IMEI No</th>
                                            <th class="text-wrap">Complaint Reason</th>
                                            <th class="text-wrap">Complaint Details</th>
                                            <th class="text-wrap">Complaint Date</th>
                                            <th class="text-wrap">Complaint Status</th>
                                            <th class="text-wrap">Resolution Details</th>
                                            <th class="text-wrap">Resolved Date</th>
                                            <th class="text-wrap">Raised User Name</th>
                                            <th class="text-wrap">Progress User Name</th>
                                            <th class="text-wrap">Solved User Name</th>
                                            
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
			</div>

			<div class="row">
		<div class="col-md-12">
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
														<h3 class="text-center" id="total_complaint"></h3>
														<h5 class="text-center">Total Complaint</h5>
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
	                                                    <img src="<?php echo base_url(); ?>assets/img/working.gif" width="45" style="border-radius: 50%; border: 5%;">
													</div>
												</div>
												<div class="anta-data mt-4">
													<h3 class="text-center" id="total_inprogress"></h3>
													<h5 class="text-center">Total In Progress</h5>
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
	</div>
	 <div class="col-md-4">
           <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
              <div class="offcanvas-header">
    <h3 id="offcanvasRightLabel"><b>Add Complaint</b></h3>
    <button type="button" class="btn-close text-reset btn-primary" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>

   <hr class="colored-hr">
                <div class="offcanvas-body ">
                	<div class="card-body">
                	 <form class="custom-validation" method="POST" action="<?php echo base_url('Technical_compalint_c/Add_complain_details'); ?>" enctype="multipart/form-data">
                             
                                    <div class="form-group col-md-12 mt-2" >
                                        <h4><b> Well Name<span style="color:red">*</span></b></h4>
                                        <select name="well_id" id="well_id" class="form-control" onchange="get_well_data()"required>
                                        <option value="">Select Well</option>
                                            <?php 
                                                foreach ($well_list as $key => $value) 
                                                {
                                                    ?>
                                                        <option  value="<?php echo $value['well_id'].'|'.$value['imei_no'].'|'.$value['device_name'].'|'.$value['date_of_installation']; ?>"><?php echo $value['well_name']; ?></option>
                                                    <?php
                                                }
                                            ?>
                                        </select>
                                        <input type="hidden" name="hdn_well_id" id="hdn_well_id" class="form-control" required>
                                    </div>

                                    <div class="form-group col-md-12 mt-2">
                                        <h4><b>Device Name<span style="color:red">*</span></b></h4>
                                        <input type="text" name="device_name" id="device_name" class="form-control" required readonly>
                                        
                                    </div>
                                    <div class="form-group col-md-12 mt-2">
                                        <h4><b>Imei No<span style="color:red">*</span></b></h4>
                                        <input type="number" name="imei_no" id="imei_no" class="form-control " required readonly>
                                    </div>
                                    <div class="form-group col-md-12 mt-2">
                                        <h4><b>Installtion Date<span style="color:red">*</span></b></h4>
                                        <input type="text" name="date_of_installation" id="date_of_installation" class="form-control " required readonly>
                                    </div>
                                    

                                  
                                    <div class="form-group col-md-12 mt-2">
                                        <h4><b>Complaint Type<span style="color:red">*</span></b></h4>
                                    <select name="complaint_type" id="complaint_type" class="form-control" required>
                                            <option value="">Select Complaint Type</option>
                                            <option value="0">RTMS Offline</option>
                                            <option value="1">RTMS Physical Damage</option>
                                            <option value="2">RTMS Burn</option>
                                            <option value="3">Others</option>
                                        </select>
                                    </div>

                                   

                                     <div class="form-group col-md-12 mt-2">
                                        <h4><b>Complaint Description <span style="color:red">*</span></b></h4>
                                        <textarea type="text" name="complaint_description" id="complaint_description" class="form-control" required onkeyup="this.value = this.value.replace(/[^a-zA-Z0-9-,.\/ ]/g,'')"></textarea>
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

                            <div class="col-md-4">
                                <div class="offcanvas offcanvas-end" tabindex="-1" id="model2" aria-labelledby="offcanvasRightLabel">
                                    <div class="offcanvas-header">
                                       <h1 class="text-center mt-5" style="font-size: 1.4em;">Complaint Ticket Status - <span id="ticket_name"></span> </h1>
                                     <button type="button" class="btn-close text-reset btn-primary mt-4" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                    </div>
                                     
                                    <div class="offcanvas-body ">
                                        <section id="timeline" class="timeline-outer">
                                            <div class="main-container mt-n4">
                                                 <hr style="color:blue;">
                                                <div class="container" id="content">
                                                    <ul class="timeline">
                                                       <div id="coplaint_data_ticket_no"></div>
                                                    </ul>
                                                </div>
                                            </div>

                                             <div class="main-container mt-n4" style="display: none; " id="resolution_time_show">
                                                <hr style="color:blue;">
                                                  <div class="container" id="content">
                                                     <ul class="timeline">
                                                         <div id="coplaint_data_resolution"></div>

                                                     </ul>
                                                  </div>
                                                 </div>
                                        </section>
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
    $(document).ready(function() {
        
        $('.select2').select2();
    });
</script>
<script type="text/javascript">
    function get_well_data()
    {
        let dataset = $('#well_id').val();
        $('#hdn_well_id').val(dataset.split("|")[0]);
        $('#imei_no').val(dataset.split("|")[1]);
        $('#device_name').val(dataset.split("|")[2]); 
         let dateOfInstallation = dataset.split("|")[3];

         let dateOfInstallation_well = moment(dateOfInstallation).format('DD-MM-YYYY h:mm A');

        $('#date_of_installation').val(dateOfInstallation_well);
       
    }

    
</script>

<script type="text/javascript">
        get_complaint_date();
    function get_complaint_date()
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

get_count_complain_data();
    function get_count_complain_data()
    {
        let company_id = '<?php echo $this->session->userdata('company_id') ?>';
        let user_id = '<?php echo $this->session->userdata('user_id') ?>';
        let from_date = $('#from_date').val();
        let to_date = $('#to_date').val();
        let ticket_id = $('#ticket_id').val();
        let complaint_status = $('#complaint_status').val();

         $.ajax({
           url: '<?php echo base_url();?>Technical_compalint_c/get_count_complain',
           type: 'POST',
           data: {company_id:company_id,user_id:user_id,from_date:from_date,to_date:to_date,ticket_id:ticket_id,complaint_status:complaint_status},
           success: function (res) {
               res = JSON.parse(res);


               if(res.response_code==200)
                {
                    $('#total_complaint').text(res.data.total_complaints);
                    $('#total_inprogress').text(res.data.total_inprogress);
                    $('#total_solved').text(res.data.total_solved);
                  

                }else
                {
                    
                    swal('error',res.msg,'error');
                }
              
           },
       }); 
    }
</script>
<script type="text/javascript">
    
get_complaints_data();
function get_complaints_data()
{
    let company_id = "<?php echo $this->session->userdata('company_id') ?>";
    let area_id =  $('#area_id').val();
    let from_date = $('#from_date').val();
    let to_date = $('#to_date').val();
    let ticket_id = $('#ticket_id').val();
    let complaint_status = $('#complaint_status').val();
    let sort_by = $('#sort_by').val();



    $.ajax({
        url:'<?php echo base_url(); ?>Technical_compalint_c/complaints_report_details',
        method:'POST',
        data:{company_id:company_id,from_date:from_date,to_date:to_date,area_id:area_id,ticket_id:ticket_id,complaint_status:complaint_status,sort_by:sort_by},
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
                            
                         var compaint_type = v.complaint_type;
                           var resolution_time = ''; 
                         if(compaint_type == 0)
                            {
                                complaint_type_status = 'RTMS Offline';
                            }else if(compaint_type == 1){
                                complaint_type_status = 'RTMS Physical Damage';
                            }else if(compaint_type == 2){
                                complaint_type_status = 'RTMS Burn';
                            }else if(compaint_type == 3){
                                complaint_type_status = 'Others';
                            }

                             var compaint_status = v.complaint_status;
                            if(compaint_status == 0)
                            {
                                rtms_status = '<button class="btn btn-sm btn-rounded btn-pill btn-primary" style="color:white;white-space: nowrap;">Pending </button>';
                            }else if(compaint_status == 1){
                                rtms_status = '<button class="btn btn-sm btn-rounded btn-pill btn-info" style="color:white;white-space: nowrap;">In Progress </button>';
                            }else if(compaint_status == 2){
                               rtms_status = '<button class="btn btn-sm btn-rounded btn-pill btn-success" style="color:white;white-space: nowrap;">Solved </button>';
                            }
                            

                           

                            $("#table_data").append('<tr>'+
                                    '<td>'+(i+1)+'</td>'+
                                    
                                     '<td><button class="btn btn-sm btn btn-success" type="button" data-bs-toggle="offcanvas" data-bs-target="#model2" aria-controls="offcanvasRight" onclick="get_coplaint_data(\'' + v.ticket_id + '\')">' + v.ticket_id +
                                '</button></td>' +
                                    '<td class="text-wrap">'+v.well_name+'</td>'+
                                    '<td class="text-wrap">'+v.device_name+'</td>'+
                                    '<td class="text-wrap">'+v.imei_no+'</td>'+
                                    '<td class="text-wrap">'+complaint_type_status+'</td>'+
                                    '<td class="text-wrap">'+(v.complaint_description ? v.complaint_description : '')+'</td>'+
                                    '<td>' + (v.c_date ? moment(v.c_date).format('DD-MM-YYYY h:mm:ss a') : '') + '</td>' +
                                    '<td class="text-wrap">'+rtms_status +'</td>'+
                                    '<td class="text-wrap">'+(v.resolution_description ? v.resolution_description : '') +'</td>'+
                                    '<td>' + (v.d_date ? moment(v.d_date).format('DD-MM-YYYY h:mm:ss a') : '') + '</td>'+
                                    '<td class="text-wrap">'+v.raised_user_name+'</td>'+
                                    '<td class="text-wrap">'+v.progress_name+'</td>'+
                                    '<td class="text-wrap">'+v.sloved_name+'</td>'+
                                    
                                '</tr>');
                        });
                     }
                     else{
                        $('#table_data').html('<tr>'+
                                 '<td class="text-danger" style="text-align:center;" colspan="20">No Record Found !!</td>'+
                              '</tr>');
                     }
                }

        }
        
    });
}


</script>

<script>
   
function get_coplaint_data(ticket_id) {
    
    $.ajax({
        url: '<?php echo base_url(); ?>Technical_compalint_c/complaints_report_log',
        method: 'POST',
        data: {
            ticket_id,
            ticket_id
        },
        success: function (res) {
            var response = JSON.parse(res);
            console.log('complaint_data=', response);

            if (response.status) {

                $('#coplaint_data_ticket_no').html('');

                $('#coplaint_data_resolution').html('');

                if (response.data.complaint_timeline.length > 0) {

                  
                    $.each(response.data.complaint_timeline, function (i, v) {

                            var ticket_name = v.ticket_id;
                            $('#ticket_name').text(ticket_name);

                           
                            
                              var eventColor = (v.complaint_status == 0) ? 'one' : (v.complaint_status == 1) ? 'two' : 'three';

                            
                             var textColor = (v.complaint_status == 0) ? '#EE0A0A' : (v.complaint_status == 1) ? 'orange' : '#27ae60 ';
                              var textComplaint = (v.complaint_status == 0) ? 'Complaint Raised On' : (v.complaint_status == 1) ? 'Complaint Progress In' : 'Complaint Solved At';
                               

                                var htmlContent =
                                    '<li class="event ' + eventColor + '" style="color: ' + textColor + ';">' +
                                    '<p> <span style="color: ' + textColor + ';">' + textComplaint + '</span></p>' +
                                
                                    '<p> <span style="color: ' + textColor + ';">' + moment(v.c_date).format('DD-MM-YYYY h:mm:ss a') + '</span></p>' +
                                    '<p> <span style="color: ' + textColor + ';">' + (v.user_data) + '</span></p>' +
                                 
                                    '</li>';
                                $('#coplaint_data_ticket_no').append(htmlContent);
                            
                        
                    });
                }

                  $('#resolution_time_show').hide();

                 if (response.data.complaint_resolution.length > 0) {

                        $('#resolution_time_show').show();
                    $.each(response.data.complaint_resolution, function (i, v) {

                       


                            var ticket_name = v.ticket_id;
                            $('#ticket_name').text(ticket_name);

                           
                            

                            
                             var textColor = (v.complaint_status == 0) ? '#EE0A0A' : (v.complaint_status == 1) ? 'orange' : '#27ae60';
                              var textComplaint = (v.complaint_status == 0) ? 'Complaint Resolution Time' : (v.complaint_status == 1) ? 'Complaint Resolution Time' : 'Complaint Resolution Time';
                               
                              var cDateMoment = moment(v.c_date);
                              var dDateMoment = moment(v.d_date);

                              var duration = moment.duration(dDateMoment.diff(cDateMoment));
                              var hours = Math.floor(duration.asHours());
                              var minutes = Math.floor(duration.asMinutes()) % 60;

                             
                                 var htmlContent =
                                 
                                   '<p style="color: ' + textColor + ';">'+ textComplaint +'</p>'+
                                   '<p> <span style="color: ' + textColor + ';">' + hours + ' hours ' + minutes + ' minutes</span></p>' +
                                 
                                    '</li>';
                                 $('#coplaint_data_resolution').append(htmlContent);
                            

                    });
                }


            } else {
                $('#coplaint_data_ticket_no').html('<p>No data available</p>');
            }
        }
    });
}


</script>


<script src="<?php echo base_url(); ?>assets/local/excel/xlsx.full.min.js"></script>
<script type="text/javascript">
    
    function export_report() {
      var sheetName = "Sheet1";
      var fileName = "Complaints Report.xlsx";
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


