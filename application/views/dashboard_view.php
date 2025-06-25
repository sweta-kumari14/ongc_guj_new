<style>
.colored-hr {
    border-top: 2px solid orange; 
}

.circle{
		display:inline-block; 
		border-radius:50%;
		color:white;
		width:45px; 
		height:50px;
		text-align:center;
		font-size:25px;
		line-height:55px;
		margin-top: 10PX;
		
	}

	
.card-success {
background-color: #06E763;   /* start   */
color: white;
}

.card-danger {
    background-color: #FB4A4A;   /* stop  */
    color: white;
}

.card-timer {
    background-color: #59ADEC;   /* timer  */
    color: white;
}



.card-fault {
    background-color: #5D6D7E ;   /* fault error	*/
    color: white;
}
.card-temporary
{
    background-color: #800000 ;   /* fault error	*/
    color: white;
}

.card-shifting
{
    background-color: #f39c12 ;   /* fault error	*/
    color: white;
}




.box3{
	width: 20px;		/* fault  */
    height: 20px;
    background-color: #5D6D7E ; 
    border-radius: 10%;
}

.box4{
	width: 20px;		/* timer off  */
    height: 20px;
    background-color: #59ADEC ; 
    border-radius: 10%;
}

.box1{
    width: 20px;        
    height: 20px;
    background-color: #06E763; 
    border-radius: 10%;
}

.box5{
	width: 20px;		/* timer off  */
    height: 20px;
    background-color: #800000 ; 
    border-radius: 10%;
}

.box2{
    width: 20px;        
    height: 20px;
    background-color: #FB4A4A; 
    border-radius: 10%;
}

.box6{
    width: 20px;        
    height: 20px;
    background-color: #f39c12; 
    border-radius: 10%;
}


.card-container {
    padding-left: 0px;
    padding-top: 30px;
    flex-basis: calc(12.5% - 10px); /* Adjusted for 8 cards per row */
    max-width: calc(12.5% - 10px); /* Adjusted for 8 cards per row */
    margin-right: 10px;
    height: 90px;
    overflow: hidden;
}

.card-body {
    padding: 15px;
    transition: all 0.1s ease-in 0s;
    cursor: pointer;
    border-radius: 7px;
    box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.06) 0px 2px 4px -1px;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.card-title {
    margin: 0px;
    font-weight: 600;
    font-size: 1.5rem;
    line-height: 1.75rem;
    font-family: "Plus Jakarta Sans", sans-serif;
    text-align: center;
    word-break: break-all;
}

.card-subtitle {
    margin: 0px;
    font-weight: 600;
    font-size: 0.75rem;
    line-height: 1.2rem;
    font-family: "Plus Jakarta Sans", sans-serif;
    text-align: center;
    word-break: break-all;
}

@media only screen and (max-width: 768px) {
    .card-container {
        flex-basis: calc(50% - 10px);
        max-width: calc(50% - 10px);
        margin-right: 5px;
        height: auto;
    }
}

@media only screen and (min-width: 879px) {
    .card-container {
        flex-basis: calc(14.2857% - 10px); 
        max-width: calc(14.2857% - 10px);
        margin-right: 10px;
    }

</style>

<div class="page-wrapper">
    <div class="content container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body" style="background-color: #5D6D7E;border-radius: 5px;">
						<div class="row">
							<div class="form-group col-md-4">
								<label  style="color:white;"><b>Installation/Field</b></label>
								<select name="area_id" id="area_id" class="form-control select2" onchange="get_site_list();get_dashboard_count();initMap();get_well_data();on_well_list();get_feeder_list();get_well_list();get_feeder_data();updateURLAndRefresh();">
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
							

							<div class="form-group col-md-6" style="display: none;">
								<label  style="color:white;"><b>Site</b></label>
								<select name="site_id" id="site_id" class="form-control select2" onchange="get_dashboard_count();initMap();get_well_data();on_well_list();">
									<option value="">Select site</option>

								</select>
							</div>
							<div class="form-group col-md-4" style="display:none;" id="feeder_dropdown">
								<label  style="color:white;"><b>Feeder</b></label>
								<select name="feeder_id" id="feeder_id" class="form-control select2" onchange="get_dashboard_count();get_well_data();on_well_list();get_well_list();">
									<option value="">Select Feeder</option>

								</select>
							</div>
							

							<div class="form-group col-md-4">
								<label  style="color:white;"><b>Well Name</b></label>
								<select name="well_id" id="well_id" class="form-control select2" onchange="get_dashboard_count();initMap();get_well_data();on_well_list();">
									<option value="">Select Well </option>

								</select>
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>

<div class="row">
		<div class="col-md-12">
			<div class="card" style="background: linear-gradient(to left, #5D6D7E,  #F1948A );">
				<div class="card-body">
					<div class="row align-items-center"> 
						<div class="col-xl-12">
							<div class="row">
								<div class="col-xl-3 col-sm-4 col-6">
									<a id="overall_details_link" href="<?php echo base_url('Dashboard_c/overall_details'); ?>">
										<div class="card ov-card" style="height:87%;box-shadow: 0 4px 8px rgba(44, 62, 80);">
											<div class="card-body">
												<div class="ana-box">	
													<div class="ic-n-bx">
														<div class=" text-center bd-warning rounded-circle">
		                                                    <img src="<?php echo base_url(); ?>assets/img/oil-pump.gif" width="45" style="border-radius: 50%; border: 5%;">
														</div>
													</div>
													<div class="anta-data mt-4">
														<h3 class="text-center" id="total_well">0</h3>
														<h5 class="text-center">Total Wells</h5>
													</div>
												</div>
											</div>
										</div>
									</a>
								</div>
								
							<!-- 	<div class="col-xl-3 col-sm-4 col-6">
									<a id="shifting_well_id" href="<?php echo base_url('Dashboard_c/get_well_shifted_list_page'); ?>">
									<div class="card ov-card" style="height:87%;box-shadow: 0 4px 8px rgba(44, 62, 80);">
	                                     <div class="card-body">
											<div class="ana-box">	
												<div class="ic-n-bx">
													<div class=" text-center rounded-circle">
	                                                    <img src="<?php echo base_url(); ?>assets/img/transfer.gif" width="45" style="border-radius: 50%; border: 5%;">
													</div>
												</div>
												<div class="anta-data mt-4">
													<h3 class="text-center" id="shifted_well"></h3>
													<h5 class="text-center">Shifted Wells</h5>
												</div>
											</div>
										</div>
									</div>
								</a>
								</div> -->
								<div class="col-xl-3 col-sm-4 col-6">
									<a id="running_well_id" href="<?php echo base_url('Dashboard_c/area_running_well_list'); ?>">
									<div class="card ov-card" style="height:87%;box-shadow: 0 4px 8px rgba(44, 62, 80);">
	                                     <div class="card-body">
											<div class="ana-box">	
												<div class="ic-n-bx">
													<div class=" text-center rounded-circle">
	                                                    <img src="<?php echo base_url(); ?>assets/img/well.gif" width="45" style="border-radius: 50%; border: 5%;">
													</div>
												</div>
												<div class="anta-data mt-4">
													<h3 class="text-center" id="on_wells"></h3>
													<h5 class="text-center">Running Wells</h5>
												</div>
											</div>
										</div>
									</div>
								</a>
								</div>
								<div class="col-xl-3 col-sm-4 col-6">
									<a id="fault_well_id" href="<?php echo base_url('Dashboard_c/faulty_details_data'); ?>">
									<div class="card ov-card" style="height:87%;box-shadow: 0 4px 8px; background-color:#ED2939;">

	                                    <div class="card-body">
											<div class="ana-box">	
												<div class="ic-n-bx">
													<div class=" text-center rounded-circle">
	                                                    <img src="<?php echo base_url(); ?>assets/img/working.gif" width="45" style="border-radius: 50%; border: 5%;">
													</div>
												</div>
												<div class="anta-data mt-4">
													<h3 class="text-center text-white" id="faulty_well"></h3>
													<h5 class="text-center text-white">Faulty Wells</h5>
												</div>
											</div>
										</div>
									</div>
								</a>
								</div>

								<div class="col-xl-3 col-sm-4 col-6">
									<a id="power_cut_id" href="<?php echo base_url('Dashboard_c/power_cut_details_data'); ?>"> 
									<div class="card ov-card" style="height:87%;box-shadow: 0 4px 8px; background-color: #ED2939;">
	                                    <div class="card-body">
											<div class="ana-box">	
												<div class="ic-n-bx">
													<div class=" text-center rounded-circle">
	                                                    <img src="<?php echo base_url(); ?>assets/img/unplugged.gif" width="45" style="border-radius: 50%; border: 5%;">
													</div>
												</div>
												<div class="anta-data mt-4">
													<h3 class="text-center text-white" id="power_cut_well"></h3>
													<h5 class="text-center text-white">Power Cut Wells</h5>
												</div>
											</div>
										</div>
									</div>
								 </a> 
								</div>
							
								<div class="col-xl-4 col-sm-4 col-6">
								    <a id="rtms_non_functional" href="<?php echo base_url('Dashboard_c/off_unit_details'); ?>">
								        <div class="card ov-card" style="height: 87%; box-shadow: 0 4px 8px rgba(44, 62, 80);">
								            <div class="card-body">
								                <div class="ana-box">    
								                    <div class="ic-n-bx">
								                        <div class="text-center rounded-circle">
								                            <img src="<?php echo base_url(); ?>assets/img/cancel.gif" width="45" style="border-radius: 50%; border: 5%;">
								                        </div>
								                    </div>

								                    <!-- Total Offline Count -->
								                    <div class="anta-data mt-4">
								                        <h3 class="text-center" id="off_unit">0</h3>
								                        <h5 class="text-center">RTMS Non-Functional</h5>

								                        <hr>
								                        <div class="row text-center mt-3">
								                            <div class="col-6" style="border-right: 1px solid #ccc;">
								                                <span style="color: #f39c12; font-weight: bold;">Network Issue</span><br>
								                                <span id="network_issue" style="font-size: 18px;">9</span>
								                            </div>
								                            <div class="col-6">
								                                <span style="color: #5D6D7E; font-weight: bold;">Battery Issue:</span><br>
								                                <span id="battery_issue" style="font-size: 18px;">0</span>
								                            </div>
								                        </div>
								                    </div>
								                </div>
								            </div>
								        </div>
								    </a>
								</div>


								<div class="col-xl-4 col-sm-4 col-6">
									<a id="temp_non_functional" href="<?php echo base_url('Dashboard_c/temp_off_details_data'); ?>">
									<div class="card ov-card" style="height:87%;box-shadow: 0 4px 8px rgba(44, 62, 80);">
	                                    <div class="card-body">
											<div class="ana-box">	
												<div class="ic-n-bx">
													<div class=" text-center rounded-circle">
	                                                    <img src="<?php echo base_url(); ?>assets/img/well.gif" width="45" style="border-radius:50%; border: 5%;">
													</div>
												</div>
												<div class="anta-data mt-4">
													<h3 class="text-center" id="total_temperory_well"></h3>
													<h5 class="text-center">Temporary off wells</h5>
												</div>
											</div>
										</div>
									</div>
								</a>
								</div>
							
								<div class="col-xl-4 col-sm-4 col-6">
								 <a id="timer_off_id" href="<?php echo base_url('Dashboard_c/timer_off_details_data'); ?>">
									<div class="card ov-card" style="height:87%;box-shadow: 0 4px 8px rgba(44, 62, 80);">
	                                    <div class="card-body">
											<div class="ana-box">	
												<div class="ic-n-bx">
													<div class=" text-center rounded-circle">
	                                                    <img src="<?php echo base_url(); ?>assets/img/hourglass.gif" width="45" style="border-radius: 50%; border: 5%;">
													</div>
												</div>
												<div class="anta-data mt-4">
													<h3 class="text-center" id="timer_off_well"></h3>
													<h5 class="text-center"> Timer Off Wells</h5>
												</div>
											</div>
										</div>
									</div>
								 </a> 
								</div>
								
                              
							</div>
						</div>
					</div>
				</div>	
			</div>
		</div>
	</div>

<div class="row">
    <div class="col-xl-12 col-md-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center" style="height: 65px; background-color: #CD5C5C; cursor: pointer; color:white;">
            <b><h4>Well Details&nbsp;<badge class="circle" style="background-color:#515A5A;" id="totalcount"></badge></h4></b>
            <div class="d-flex align-items-center">
                <img src="<?php echo base_url() ?>assets/img/oil-pump.gif" width="40" style="border-radius: 25%;">
            </div>
        </div>
        <div class="card-body">
        
            	<!-- <div class="col-md-12"> -->
	                <div class="row mt-2 ml-3 text-center">
	                	
                        <div class="col-md-12" style="display: inline-flex;">
	                        <div class="box3"></div>
	                        <h6 class="mx-6 mt-1" style="margin-right:15px">&nbsp; &nbsp;Battery Issue</h6>
                            
                            <div class="box6"></div>
	                        <h6 class="mx-6 mt-1" style="margin-right:15px">&nbsp; &nbsp;Network Issue</h6>
	                 
	                        <div class="box5"></div>
	                        <h6 class="mx-6 mt-1" style="margin-right:15px">&nbsp; &nbsp;Temporary off</h6>
	                   
	                        <div class="box4"></div>
	                        <h6 class="mx-6 mt-1" style="margin-right:15px">&nbsp; &nbsp;Timer Off</h6>
	                   
	                        <div class="box2"></div>
	                        <h6 class="mx-6 mt-1" style="margin-right:15px">&nbsp; &nbsp;Not Running</h6>
	                   
	                        <div class="box1"></div>
	                        <h6 class="mx-6 mt-1" style="margin-right:15px">&nbsp; &nbsp;Running</h6>
	                   
	                    <!-- <div class="col-md-2 d-flex justify-content-inline" style="display: none;" id="wellRunningDiv">
	                        <div class="box6"></div>
	                        <h6 class="mx-6 mt-1">&nbsp; &nbsp;Shifting Well</h6>
	                    </div>  -->
	                    
	                </div>
                </div>
	            <div class="row flex mb-4" id="well_area_card" style="margin-right:5px; margin-left:5px;">
	            </div>
            </div>
       
    </div>
    </div>
</div>

 <div class="row mt-2">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center" style="height: 65px;background-color:#F1948A;cursor: pointer;" data-bs-toggle="collapse" data-bs-target="#map_area_card" aria-expanded="false" aria-controls="map_area_card" id="accordionButton">
                <div>
                    <h5 class="text-white " style="font-size: 18px;">Asset GIS Map</h5>
                </div>
                <div class="d-flex align-items-center">
                    <img src="<?php echo base_url() ?>assets/img/map.gif" width="40" style="border-radius: 25%;">
                </div>
            </div>
            <div class="card-body">
                <div class="mt-1 accordion-collapse collapse" id="map_area_card" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                	<div class="row">
                    <div class="col-md-6">
                        <button type="button" class="btn btn-sm btn-rounded" style="background-color: #06E763;color:white;"> Well Running</button>
                        <button type="button" class="btn btn-sm btn-rounded mx-3" style="background-color: rgb(227,66,52);color:white;">Well Not Running</button>
                        <button type="button" class="btn btn-sm btn-rounded" style="background-color: #F39C12;color:white;">Device Not Installed</button>
                        <button type="button" class="btn btn-sm btn-rounded" style="background-color:#5D6D7E;color:white;">Offline</button>

                    </div>
                </div>
                    <div class="mt-2" id="mymap" style="width:100%;height: 400px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel"> 
  <div class="offcanvas-header">
  	 <!-- <img src="<?php echo base_url() ?>assets/img/logo.png" width="70" style="border-radius: 50%; height:50"> -->
    <h5 id="offcanvasRightLabel">Well Status</h5>
    
       <button type="button" class="btn-close text-reset btn-primary" data-bs-dismiss="offcanvas" aria-label="Close"></button>

  </div>
  <div class="col-md-10" style="margin-left:20px;">
  <label><b>Search Well Name</b></label>   
    <input type="text" onkeyup="get_well_details()" name="search_box_1" id="search_box_1" class="form-control">
  </div>

   <hr class="colored-hr">
  <div class="offcanvas-body">
        <div class="container" id="flash_data">
					
				</div>
			</div>
			
		</div>
	</div>


<script type="text/javascript">
	
	on_well_list()
	function on_well_list()
    {
    	var company_id = '<?php echo $this->session->userdata('company_id') ?>';
    	var user_id = '<?php echo $this->session->userdata('user_id') ?>';
    	var assets_id = '<?php echo $this->session->userdata('assets_id') ?>';
    	var area_id = $('#area_id').val();
    	let site_id = $('#site_id').val();
    	
    
        $.ajax({
            url: '<?php echo base_url(); ?>Dashboard_c/get_popup_data',
            type: 'POST',
            data: {company_id:company_id,user_id:user_id,assets_id:assets_id,area_id:area_id,site_id:site_id},
            success:function(res)
            {
                $('#flash_data').html(res);
            }
        });
    } 
</script>


 <script type="text/javascript">
	
	get_offcampus();
  function get_offcampus() {
    $('#offcanvasRight').addClass('show');
  } 
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBKoAgLoslTEUCNabLj5H5jLVdWFD2WhK8"></script>
<script type="text/javascript">
	
	get_site_list();

function get_site_list() { 
    let company_id = "<?php echo $this->session->userdata('company_id') ?>";
    let user_id = "<?php echo $this->session->userdata('user_id') ?>";
    let assets_id = "<?php echo $this->session->userdata('assets_id') ?>";
    let area_id = $('#area_id').val();

    $.ajax({
        type: 'POST',
        url: '<?php echo base_url();?>Dashboard_c/site_list',
        data: { company_id: company_id, assets_id: assets_id, area_id: area_id, user_id: user_id },
        success: function(data) {
            data = JSON.parse(data);
    
            if (data.response_code == 200) {   
                if (data.data.length > 0) {
                    $('#site_id').html('');
                    $('#site_id').html('<option value="">Select site</option>');
                    $.each(data.data, function(i, v) {
                        // let selected = (v.id == v.id) ? 'selected' : '';
                        $('#site_id').append('<option value="' + v.id + '">' + v.well_site_name + '</option>');
                    });
                } else {
                    $('#site_id').html('<option value="">No Data Found</option>');
                }
            } else {
                swal('error', data.msg, 'error');
            }   
        }
    });
}

get_well_list();
function get_well_list() { 
    let company_id = "<?php echo $this->session->userdata('company_id') ?>";
    let user_id = "<?php echo $this->session->userdata('user_id') ?>";
    let assets_id = "<?php echo $this->session->userdata('assets_id') ?>";
    let area_id = $('#area_id').val();
    let feeder_id = $('#feeder_id').val();
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url();?>Dashboard_c/Well_list',
        data: { company_id: company_id, assets_id: assets_id, area_id: area_id, user_id: user_id,feeder_id:feeder_id },
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

get_feeder_list();
function get_feeder_list() { 
    
    let area_id = $('#area_id').val();
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url();?>Dashboard_c/feeder_list',
        data: { area_id:area_id },
        success: function(data) {
            data = JSON.parse(data);
           
            if (data.response_code == 200) {   
                if (data.data.length > 0) {
                    $('#feeder_id').html('');
                    $('#feeder_id').html('<option value="">Select Feeder</option>');
                    $.each(data.data, function(i, v) {
                     
                        $('#feeder_id').append('<option value="' + v.id + '">' + v.feeder_name + '</option>');
                    });
                } else {
                    $('#feeder_id').html('<option value="">No Feeder Found</option>');
                }
            } else {
                swal('error', data.msg, 'error');
            }   
        }
    });
}


</script>
<script type="text/javascript">
     get_feeder_data();
    function get_feeder_data() 
   { 
        let area_id = $('#area_id').val();
        if (area_id  == "52dbde99-b394-11ee-a6d4-5cb901ad9cf0") 
        {
            $('#feeder_dropdown').show();  
        } else {
            $('#feeder_dropdown').hide();
           
        }
    }
</script>

<script>
function updateURLAndRefresh() {
    var selectedAreaId = document.getElementById("area_id").value;
    // alert(selectedAreaId);
   
    var baseUrl = "<?php echo base_url('Dashboard_c/overall_details/'); ?>";
    var finalUrl = baseUrl + selectedAreaId;
    document.getElementById("overall_details_link").setAttribute("href", finalUrl);

    
    // var baseUrl = "<?php echo base_url('Dashboard_c/get_well_shifted_list_page/'); ?>";
    // var finalUrl = baseUrl + selectedAreaId;
    // document.getElementById("shifting_well_id").setAttribute("href", finalUrl);


    var baseUrl = "<?php echo base_url('Dashboard_c/area_running_well_list/'); ?>";
    var finalUrl = baseUrl + selectedAreaId;
    document.getElementById("running_well_id").setAttribute("href", finalUrl);

    var baseUrl = "<?php echo base_url('Dashboard_c/faulty_details_data/'); ?>";
    var finalUrl = baseUrl + selectedAreaId;
    document.getElementById("fault_well_id").setAttribute("href", finalUrl);

    var baseUrl = "<?php echo base_url('Dashboard_c/off_unit_details/'); ?>";
    var finalUrl = baseUrl + selectedAreaId;
    document.getElementById("rtms_non_functional").setAttribute("href", finalUrl);

     var baseUrl = "<?php echo base_url('Dashboard_c/temp_off_details_data/'); ?>";
    var finalUrl = baseUrl + selectedAreaId;
    document.getElementById("temp_non_functional").setAttribute("href", finalUrl);

    var baseUrl = "<?php echo base_url('Dashboard_c/power_cut_details_data/'); ?>";
    var finalUrl = baseUrl + selectedAreaId;
    document.getElementById("power_cut_id").setAttribute("href", finalUrl);

    var baseUrl = "<?php echo base_url('Dashboard_c/timer_off_details_data/'); ?>";
    var finalUrl = baseUrl + selectedAreaId;
    document.getElementById("timer_off_id").setAttribute("href", finalUrl);
}
</script>



<script type="text/javascript">
	
	initMap();
function initMap() {

	let assets_id = '<?php echo $this->session->userdata('assets_id') ?>';
	let area_id = $('#area_id').val();
	let well_id = $('#well_id').val();
	let user_id = '<?php echo $this->session->userdata('user_id') ?>';
	let company_id = '<?php echo $this->session->userdata('company_id') ?>';
	let feeder_id = $('#feeder_id').val();

  $.ajax({
    url:'<?php echo base_url(); ?>Dashboard_c/get_site_location_for_dashboard',
    type : 'POST',
    data : {company_id:company_id,assets_id:assets_id,area_id:area_id,user_id:user_id,well_id:well_id,feeder_id:feeder_id},
    success : function(res)
    {
      response = JSON.parse(res);
         
      if(response.data.length>0)
      {   
        let markers=[];
        for(item of response.data){
          markers.push({
            position: {lat: parseFloat(item.lat), lng: parseFloat(item.long)},
            title: item.well_name,
            status: item.smps_voltage,
            well_id: item.well_id,
            ins_status: item.device_setup_status,
            device_active_status:item.device_active_status,
            avg_out_current : item.output_Average_Current,
            offline_time : item.last_log_datetime,
            long:item.long,
            lat: item.lat
          })
        }

        var map = new google.maps.Map(document.getElementById('mymap'), {
          zoom: 13,
          center: {lat:22.24541800, lng:73.07932750}
        });

        

       	markers.forEach(function(marker) {
          var markerIcon = {
            url: '<?php echo base_url(); ?>assets/images/yellow-well.png',
            scaledSize: new google.maps.Size(20, 20)
            
          };

          if (marker.offline_time != null )
      	 	{
      	 		// =============== time convert code starts =========
			        		var last_data_time = marker.offline_time;
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

									// console.log('seconds==',diffInSeconds);

									var second = diffInSeconds;
									// console.log(second);
        		// =============== time convert code ends ===========
		      	 	}else{
		      	 			var second = 200;
		      	 			// console.log(second);
		      	 	}

	          if (marker.ins_status == '1' && marker.device_active_status == '1')
	         	{
	         		if (second < 300 )
	         		{
	         				if (marker.avg_out_current > 0) {
			            markerIcon.url = '<?php echo base_url(); ?>assets/img/green.png';
				          } else {
				            markerIcon.url = '<?php echo base_url(); ?>assets/img/red.png';
				          } 
				         
	         		}else{
	         				markerIcon.url = '<?php echo base_url(); ?>assets/img/offline.png';
	         		}
		         		
	         	}else{
	         			
	         			markerIcon.url = '<?php echo base_url(); ?>assets/img/orange.png';
	         	}

		          var mapMarker = new google.maps.Marker({
		            position: marker.position,
		            map: map,
		            icon: markerIcon,
		            title: marker.title,
		            lat : marker.lat,
		            long :marker.long
		          });

		          var statusText = '';
						if (marker.ins_status == 1)
						{
							if (second < 300)
							{
									if (marker.avg_out_current > 0 )
									{
										statusText = 'ON';
									}else{
										statusText = 'OFF';
									}
							}else{
								statusText = 'DCU OFF';
							}
							
						  
						}
						
						else{
							 statusText = 'Device Not Installed';
						}

          var infowindow = new google.maps.InfoWindow({
				  content: '<div class="site-info" style="width: 100px; height: 100px;">' +
				            '<h5>' + marker.title + '</h5>' +
				            '<h6><b>Well Status</b>: ' + statusText + '</h6>' +
				            ((marker.status == null )
				              ? ''
				              : '<a target="_blank" href="<?php echo base_url(); ?>Dashboard_c/get_single_well_detail_dashboard/' + marker.well_id + '">View Details</a>'+
                                '<h5><a target="_blank" href="https://www.google.com/maps/place/' + marker.lat + ',' + marker.long + '">View on Google Maps</a></h5>'

				              ) +

				            '</div>'
					});

          mapMarker.addListener('click', function() {
					    infowindow.open(map, mapMarker);
					});

					map.addListener('click', function() {
					    infowindow.close();
					});

        });
      }
    }
  });
}
</script>

<script type="text/javascript">

	get_dashboard_count();
	function get_dashboard_count()
	{
		let company_id = '<?php echo $this->session->userdata('company_id') ?>';
		let assets_id = '<?php echo $this->session->userdata('assets_id') ?>';
		let area_id = $('#area_id').val();
		let site_id = $('#site_id').val();
		let well_id = $('#well_id').val();
		let feeder_id = $('#feeder_id').val();

	

		 $.ajax({
           url: '<?php echo base_url();?>Dashboard_c/get_dashboard_count',
           type: 'POST',
           data: {company_id:company_id,assets_id:assets_id,area_id:area_id,site_id:site_id,well_id:well_id,feeder_id:feeder_id},
           success: function (res) {
               res = JSON.parse(res);


               if(res.response_code==200)
                {
                    $('#total_well').text(res.data.total_well);
                    $('#Installed_units').text(res.data.total_installedsite);
                    $('#on_unit').text(res.data.total_functional_unit);
                    $('#faulty_well').text(res.data.faulty_well);
                    $('#total_units').text(res.data.total_installedsite);
                    $('#total_temperory_well').text(res.data.total_temperory_well);
                    let non_func = res.data.total_installedsite - res.data.total_functional_unit;

                   
                    $('#on_wells').text(res.data.ON_Well);
                    $('#off_wells').text(res.data.Off_Well);
                    $('#shifted_well').text(res.data.total_shifted);
                    // let total_well_count = parseInt(res.data.total_installedsite) + parseInt(res.data.total_shifted);
                    let total_well_count = parseInt(res.data.total_installedsite);
                    

                    $('#totalcount').text(total_well_count);
   		            $('#power_cut_well').text(res.data.power_cut_well);
   		            $('#timer_off_well').text(res.data.timer_off_well);
   		             let total_data = parseInt(res.data.total_temperory_well) + parseInt(res.data.faulty_well) + parseInt(res.data.timer_off_well)+parseInt(res.data.power_cut_well)+parseInt(res.data.ON_Well);
   		             let off_func = res.data.total_well - total_data;
   		             if(off_func < 0)
   		             {
   		             	off_func_data = 0;

   		             }else{
   		             	
                        off_func_data = off_func;
   		             }
   		             $('#off_unit').text(off_func_data) ;

   		             $('#total_offline').text(res.data.rtms_offline.total_offline);
                     $('#network_issue').text(res.data.rtms_offline.network_issue);
                     $('#battery_issue').text(res.data.rtms_offline.battery_issue);
                    
                }else
                {
               	    swal('error',res.msg,'error');
                }
              
           },
       }); 
	}
</script>

<script type="text/javascript">

get_well_data();
function get_well_data() {
    var company_id = '<?php echo $this->session->userdata("company_id"); ?>';
    let assets_id = '<?php echo $this->session->userdata("assets_id"); ?>';
    let area_id = $('#area_id').val();
    let well_id = $('#well_id').val();
    let feeder_id = $('#feeder_id').val();
    let user_id = '<?php echo $this->session->userdata('user_id') ?>';

    $.ajax({
        url: '<?php echo base_url(); ?>Dashboard_c/well_card_data',
        method: 'POST',
        data: {
            company_id: company_id,
            assets_id: assets_id,
            area_id: area_id,
            user_id: user_id,
            well_id: well_id,
            feeder_id:feeder_id
        },
        success: function (res) {
            var response = JSON.parse(res);
            if (response.response_code == 200) 
            {
                if (response.data.length > 0) 
                {
                    $("#well_area_card").html('');
                  
                    response.data.sort(function(a, b) 
                    {
                        if (a.status_variable == b.status_variable) 
                        {
                            return a.well_name.localeCompare(b.well_name);
                        }
                        return a.status_variable.localeCompare(b.status_variable);


                    });
                    $.each(response.data, function (i, v)
                    {
                        var dcu_status = '';
                        var card_status = v.status_variable;
                        var smps_voltage = (v.smps_voltage);
                        var battery_voltage = (v.battery_voltage);

                        if(card_status == 'battery_issue')
                        {
                        	 dcu_status = 'card-fault'; 
                        }
                        else if (card_status == 'offline') 
                        {
                            dcu_status = 'card-shifting'; 
                          
                        } else if (card_status == 'well_running') 
                        {
                            dcu_status = 'card-success';
                        } else if (card_status == 'timer_off_well') 
                        {
                            dcu_status = 'card-timer';
                        }else if (card_status == 'temperory_offline') 
                        {
                            dcu_status = 'card-temporary';
                        } else if (card_status == 'well_not_running') 
                        {
                            dcu_status = 'card-danger';
                        }else 
                        {
                            dcu_status = 'card-danger'; 
                        }

                        var link = '<?php echo base_url("Dashboard_c/get_single_well_detail_dashboard/"); ?>' + v.well_id;

                        $("#well_area_card").append(
                            '<div class="card-container">' +
                            '<a href="' + link + '"style="text-decoration: none;color:inherit">' +
                            '<div class="card-body '+dcu_status+'">'+
                            '<h6 class="card-subtitle">' + v.well_name + '</h6>' +
                            '</div></a>' +
                            '</div>'
                        );
                    });
                }else {
                    $('#well_area_card').html('<div class="card card-body mx-3 mt-3">' +
                        '<div class="text-danger" style="text-align:center;" colspan="6"><h4>No Well Found !!</h4></div>' +
                        '</div>');
                }
            }
        }
    });
}
</script>

<script type="text/javascript">
  
   setInterval(()=>{
   	   get_well_data();
   	   get_dashboard_count();
       initMap();        
    },60000);
</script>
