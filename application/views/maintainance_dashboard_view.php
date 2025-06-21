<style>
.colored-hr {
    border-top: 2px solid orange; 
}
	
.card-battery {
	background-color: #F4D03F;   /* battery error  */
	color: white;
}

.card-network {
    background-color: #5DADE2;   /* network error */
    color: white;
}

.card-power {
    background-color: #9C640C;   /* power error */
    color: white;
}

.card_modbus {
    background-color: #EC7063 ;   /* modbus error	*/
    color: white;
}

.card-temporary
{
    background-color: #800000 ;   /* fault error	*/
    color: white;
}

.card-shifting
{
    background-color: #808000 ;   /* fault error	*/
    color: white;
}


.box1{					/* box1 for battery  */
    width: 20px;        
    height: 20px;
    background-color: #F4D03F; 
    border-radius: 10%;
}

.box2{					/* box2 for Network  */
    width: 20px;        
    height: 20px;
    background-color: #5DADE2; 
    border-radius: 10%;
}

.box3{
	width: 20px;		/* box3 for Power Supply  */
    height: 20px;
    background-color: #9C640C; 
    border-radius: 10%;
}

.box4{
	width: 20px;		/* box4 for Modbus Error  */
    height: 20px;
    background-color: #EC7063; 
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
							<div class="form-group col-md-6">
								<label  style="color:white;"><b>Installation/Field</b></label>
								<select name="area_id" id="area_id" class="form-control select2" onchange="get_maintainance_count();get_all_device_well_list_data();get_all_welwise_well_list_data();get_well_list();">
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

							<div class="form-group col-md-6">
								<label  style="color:white;"><b>Well Name</b></label>
								<select name="well_id" id="well_id" class="form-control select2" onchange="get_maintainance_count();get_all_device_well_list_data();get_all_welwise_well_list_data();">
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
									<div class="col-xl-3 col-sm-6 col-md-6">
										<div class="card ov-card" style="height:87%;box-shadow: 0 4px 8px rgba(44, 62, 80);">
											<div class="card-body">
												<div class="ana-box">	
													<div class="ic-n-bx">
														<div class=" text-center bd-warning rounded-circle">
		                                                    <img src="<?php echo base_url(); ?>assets/img/battery.gif" width="45" style="border-radius: 50%; border: 5%;">
														</div>
													</div>
													<div class="anta-data mt-4">
														<h3 class="text-center" id="battery_count">0</h3>
														<h5 class="text-center">Battery Drain</h5>
													</div>
												</div>
											</div>
										</div>
									</div>
									
									<div class="col-xl-3 col-sm-6 col-md-6">
										<div class="card ov-card" style="height:87%;box-shadow: 0 4px 8px rgba(44, 62, 80);">
		                                     <div class="card-body">
												<div class="ana-box">	
													<div class="ic-n-bx">
														<div class=" text-center rounded-circle">
		                                                    <img src="<?php echo base_url(); ?>assets/img/warning.gif" width="45" style="border-radius: 50%; border: 5%;">
														</div>
													</div>
													<div class="anta-data mt-4">
														<h3 class="text-center" id="network_error_count">0</h3>
														<h5 class="text-center">Network Error</h5>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xl-3 col-sm-6 col-md-6">
										<div class="card ov-card" style="height:87%;box-shadow: 0 4px 8px rgba(44, 62, 80);">
		                                     <div class="card-body">
												<div class="ana-box">	
													<div class="ic-n-bx">
														<div class=" text-center rounded-circle">
		                                                    <img src="<?php echo base_url(); ?>assets/img/unplugged.gif" width="45" style="border-radius: 50%; border: 5%;">
														</div>
													</div>
													<div class="anta-data mt-4">
														<h3 class="text-center" id="power_cut_count">0</h3>
														<h5 class="text-center">Power Cut</h5>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xl-3 col-sm-6 col-md-6">
										<div class="card ov-card" style="height:87%;box-shadow: 0 4px 8px rgba(44, 62, 80);">
		                                    <div class="card-body">
												<div class="ana-box">	
													<div class="ic-n-bx">
														<div class=" text-center rounded-circle">
		                                                    <img src="<?php echo base_url(); ?>assets/img/working.gif" width="45" style="border-radius: 50%; border: 5%;">
														</div>
													</div>
													<div class="anta-data mt-4">
														<h3 class="text-center" id="modbus_error_count">0</h3>
														<h5 class="text-center">Modbus Error</h5>
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

		<div class="row mt-2">
		    <div class="col-md-12">
	    		<div class="card">
		            <div class="card-header d-flex justify-content-between align-items-center" style="height: 65px;background-color:#EF948A;cursor: pointer;" data-bs-toggle="collapse" data-bs-target="#offline_devices" aria-expanded="false" aria-controls="offline_devices" id="accordionButton">
		                <div>
		                    <h5 class="text-white " style="font-size: 18px;">Offline Devices</h5>
		                </div>
		                <div class="d-flex align-items-center">
		                    <img src="<?php echo base_url() ?>assets/img/div.gif" width="40" style="border-radius: 25%;">
		                </div>
		            </div>
		            <div class="card-body">
		                <div class="mt-1 accordion-collapse collapse" id="offline_devices" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
		                	<div class="row">
			                   <div class="col-md-12">
			                   		<div class="row">
			                   			<div class="col-md-3 d-flex justify-content-inline" >
					                        <div class="box1"></div>
					                        <h6 class="mx-6 mt-1">&nbsp; &nbsp;Battery Down</h6>
					                    </div>
					                    
					                    <div class="col-md-3 d-flex justify-content-inline">
					                        <div class="box2"></div>
					                        <h6 class="mx-6 mt-1">&nbsp; &nbsp;Network Error</h6>
					                    </div>
			                   		</div>
			                   </div>
			                   <div class="col-md-12">
			                   		<div class="row flex mb-4" id="well_area_card" style="margin-right:5px; margin-left:5px;">
		            				</div>
			                   </div>
		            		</div>
		        		</div>
		    		</div>
				</div>
	    	
	    		<div class="card">
		            <div class="card-header d-flex justify-content-between align-items-center" style="height: 65px;background-color:#CD5C5C;cursor: pointer;" data-bs-toggle="collapse" data-bs-target="#offline_wells" aria-expanded="false" aria-controls="offline_wells" id="accordionButton">
		                <div>
		                    <h5 class="text-white " style="font-size: 18px;">Offline Well</h5>
		                </div>
		                <div class="d-flex align-items-center">
		                    <img src="<?php echo base_url() ?>assets/img/well.gif" width="40" style="border-radius: 25%;">
		                </div>
		            </div>
		            <div class="card-body">
		                <div class="mt-1 accordion-collapse collapse" id="offline_wells" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
		                	<div class="row">
			                   <div class="col-md-12">
			                   		<div class="row">
			                   			<div class="col-md-3 d-flex justify-content-inline" >
					                        <div class="box3"></div>
					                        <h6 class="mx-6 mt-1">&nbsp; &nbsp;Power Supply Error</h6>
					                    </div>
					                    
					                    <div class="col-md-3 d-flex justify-content-inline">
					                        <div class="box4"></div>
					                        <h6 class="mx-6 mt-1">&nbsp; &nbsp;Modbus Error</h6>
					                    </div>
			                   		</div>
			                   </div>
			                   <div class="col-md-12">
			                   		<div class="row flex mb-4" id="well_wise_card_area" style="margin-right:5px; margin-left:5px;">
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


<!-- -------------- modal code starts------------------- -->
<!-- Modal 1 -->
    <div class="modal fade device_model" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Offline Device</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 d-flex">
						<div class="card flex-fill">
							<div class="card-body">
								<h4 class="text-center">Device Last Data</h4>
								<hr>
								<div>
									<p>
										<i class="fa-regular fa-circle-dot text-info me-2"></i>
										Well Name 
										<span class="float-end" id="m1_well_name"></span>
									</p>
									<p>
										<i class="fa-regular fa-circle-dot text-info me-2"></i>
										Offline Reason 
										<span class="float-end" id='m1_offline_reason'></span>
									</p>
									<p>
										<i class="fa-regular fa-circle-dot text-info me-2"></i>
										SMPS Voltage 
										<span class="float-end" id="m1_smps_voltage"></span> 
									</p>
									<p>
										<i class="fa-regular fa-circle-dot text-info me-2"></i>
										Battery Voltage 
										<span class="float-end" id="m1_battery_voltage"></span>
									</p>
									<p class="mb-0">
										<i class="fa-regular fa-circle-dot text-info me-2"></i>
										Last Log DateTime
										<span class="float-end" id="m1_last_log_datetime"></span>
									</p>
								</div>
							</div>
						</div>
					</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    
                </div>
            </div>
        </div>
    </div>


    <!-- Modal 2 -->
    <div class="modal fade well_wise_model" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Offline Well</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 d-flex">
						<div class="card flex-fill">
							<div class="card-body">
								<h4 class="text-center">Well Last Data</h4>
								<hr>
								<div>
									<p>
										<i class="fa-regular fa-circle-dot text-info me-2"></i>
										Well Name 
										<span class="float-end" id="m2_well_name"></span>
									</p>
									<p>
										<i class="fa-regular fa-circle-dot text-info me-2"></i>
										Offline Reason 
										<span class="float-end" id='m2_offline_reason'></span>
									</p>
									<p>
										<i class="fa-regular fa-circle-dot text-info me-2"></i>
										SMPS Voltage 
										<span class="float-end" id="m2_smps_voltage"></span> 
									</p>
									<p>
										<i class="fa-regular fa-circle-dot text-info me-2"></i>
										Battery Voltage 
										<span class="float-end" id="m2_battery_voltage"></span>
									</p>
									<p>
										<i class="fa-regular fa-circle-dot text-info me-2"></i>
										Last Log DateTime
										<span class="float-end" id="m2_last_log_datetime"></span>
									</p>
									<div style="display:none" id="modbus_extra_data">
										<p>
											<i class="fa-regular fa-circle-dot text-info me-2"></i>
											Average Current
											<span class="float-end" id="m2_avg_current"></span>
										</p>
										<p>
											<i class="fa-regular fa-circle-dot text-info me-2"></i>
											Average P2P Voltage
											<span class="float-end" id="m2_avg_p2p_voltage"></span>
										</p>
										<p>
											<i class="fa-regular fa-circle-dot text-info me-2"></i>
											OLR Status
											<span class="float-end" id="m2_olr_status"></span>
										</p>
										<p>
											<i class="fa-regular fa-circle-dot text-info me-2"></i>
											ELR Status
											<span class="float-end" id="m2_elr_status">Faulty</span>
										</p>
										<p>
											<i class="fa-regular fa-circle-dot text-info me-2"></i>
											SPP Status
											<span class="float-end" id="m2_spp_status"></span>
										</p>
										<p>
											<i class="fa-regular fa-circle-dot text-info me-2"></i>
											Power Factor
											<span class="float-end" id="m2_power_factor"></span>
										</p>
										<!-- <p>
											<i class="fa-regular fa-circle-dot text-info me-2"></i>
											Active Power
											<span class="float-end" id="m2_active_power">27</span>
										</p> -->
										<p>
											<i class="fa-regular fa-circle-dot text-info me-2"></i>
											Frequency
											<span class="float-end" id="m2_frequency"></span>
										</p>
									</div>
								</div>
							</div>
						</div>
					</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<!-- -------------- modal code ends -------------------- -->

<script type="text/javascript">

get_well_list();
function get_well_list() { 
    let company_id = "<?php echo $this->session->userdata('company_id') ?>";
    let user_id = "<?php echo $this->session->userdata('user_id') ?>";
    let assets_id = "<?php echo $this->session->userdata('assets_id') ?>";
    let area_id = $('#area_id').val();

    $.ajax({
        type: 'POST',
        url: '<?php echo base_url();?>Maintainance_Dasboard_c/Well_list',
        data: { company_id: company_id, assets_id: assets_id, area_id: area_id, user_id: user_id },
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

	get_maintainance_count();
	function get_maintainance_count()
	{
		let company_id = '<?php echo $this->session->userdata('company_id') ?>';
		let assets_id = '<?php echo $this->session->userdata('assets_id') ?>';
		let area_id = $('#area_id').val();
		let well_id = $('#well_id').val();

		$.ajax({
           url: '<?php echo base_url();?>Maintainance_Dasboard_c/get_maintainance_device_count',
           type: 'POST',
           data: {company_id:company_id,assets_id:assets_id,area_id:area_id,well_id:well_id},
           success: function (res) {
               res = JSON.parse(res);

               // console.log('res===',res)
               if(res.response_code==200)
                {
                    $('#battery_count').text(res.data.batteryPrb[0].total);
                    $('#network_error_count').text(res.data.networkPrb[0].total);
                    $('#power_cut_count').text(res.data.powerPrb[0].total);
                    $('#modbus_error_count').text(res.data.modbusPrb[0].total);
                }else
                {
                    swal('error',res.msg,'error');
                }
              
           },
       }); 
	}
</script>

<script type="text/javascript">

get_all_device_well_list_data();
function get_all_device_well_list_data() {
    var company_id = '<?php echo $this->session->userdata("company_id"); ?>';
    
    let area_id = $('#area_id').val();
    let well_id = $('#well_id').val();
    // let user_id = '<?php echo $this->session->userdata('user_id') ?>';

    $.ajax({
        url: '<?php echo base_url(); ?>Maintainance_Dasboard_c/get_all_well_list',
        method: 'POST',
        data: {
            company_id: company_id,
            area_id: area_id,
            // user_id: user_id,
            well_id: well_id
        },
        success: function (res) {
            var response = JSON.parse(res);
            if (response.response_code == 200) 
            {
                if (response.data.length > 0) 
                {
                    $("#well_area_card").html('');
                  
                    // response.data.sort(function(a, b) 
                    // {
                    //     if (a.status_variable == b.status_variable) 
                    //     {
                    //         return a.well_name.localeCompare(b.well_name);
                    //     }
                    //     return a.status_variable.localeCompare(b.status_variable);


                    // });

                    // console.log('all well list==',response)
                    $.each(response.data, function (i, v)
                    {
                    	if(v.offline_reason == 1 || v.offline_reason == 2)
                    	{
                    		var dcu_status = '';
	                        var offline_reason = v.offline_reason;

	                        if (offline_reason == 1) 
	                        {
	                            dcu_status = 'card-battery';
	                        } else if (offline_reason == 2) 
	                        {
	                            dcu_status = 'card-network';
	                        }

	                        var well_name = v.well_name !== null ? v.well_name : 'NA';

	                        $("#well_area_card").append(
	                            '<div class="card-container">' +
	                            '<div class="card-body '+dcu_status+'" data-bs-toggle="modal" data-bs-target=".device_model" onclick="show_well_details(\'' + v.well_id + '\')">'+
	                            '<h6 class="card-subtitle">' + well_name + '</h6>' +
	                            '</div>' +
	                            '</div>'
	                        );
	                    } 
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

get_all_welwise_well_list_data();
function get_all_welwise_well_list_data() {
    var company_id = '<?php echo $this->session->userdata("company_id"); ?>';
    
    let area_id = $('#area_id').val();
    let well_id = $('#well_id').val();
    // let user_id = '<?php echo $this->session->userdata('user_id') ?>';

    $.ajax({
        url: '<?php echo base_url(); ?>Maintainance_Dasboard_c/get_all_well_list',
        method: 'POST',
        data: {
            company_id: company_id,
            area_id: area_id,
            // user_id: user_id,
            well_id: well_id
        },
        success: function (res) {
            var response = JSON.parse(res);
            if (response.response_code == 200) 
            {
                if (response.data.length > 0) 
                {
                    $("#well_wise_card_area").html('');
                  
                    // response.data.sort(function(a, b) 
                    // {
                    //     if (a.status_variable == b.status_variable) 
                    //     {
                    //         return a.well_name.localeCompare(b.well_name);
                    //     }
                    //     return a.status_variable.localeCompare(b.status_variable);


                    // });

                    // console.log('all well list==',response)
                    $.each(response.data, function (i, v)
                    {
                    	if(v.offline_reason == 3 || v.offline_reason == 4)
                    	{
                    		var dcu_status = '';
	                        var offline_reason = v.offline_reason;

	                        if (offline_reason == 3) 
	                        {
	                           dcu_status = 'card_modbus';
	                        } else if (offline_reason == 4) 
	                        {
	                            dcu_status = 'card-power';
	                        }

	                        var well_name = v.well_name !== null ? v.well_name : 'NA';

	                        $("#well_wise_card_area").append(
	                            '<div class="card-container">' +
	                            '<div class="card-body '+dcu_status+'" data-bs-toggle="modal" data-bs-target=".well_wise_model" onclick="show_well_wise_well_data(\'' + v.well_id + '\')">'+
	                            '<h6 class="card-subtitle">' + well_name + '</h6>' +
	                            '</div>' +
	                            '</div>'
	                        );
	                    } 
                    });
                }else {
                    $('#well_wise_card_area').html('<div class="card card-body mx-3 mt-3">' +
                        '<div class="text-danger" style="text-align:center;" colspan="6"><h4>No Well Found !!</h4></div>' +
                        '</div>');
                }
            }
        }
    });
}



	function show_well_details(well_id) {
        // alert(well_id);
        $.ajax({
            url: '<?php echo base_url(); ?>Maintainance_Dasboard_c/get_single_well_data',
            type: 'POST',
            data: {well_id: well_id},
            success: function(res) {
                // Handle the response here, for example, update the modal content
                var res = JSON.parse(res);
                // console.log('single well data = ', res);
               
                $('#m1_well_name').text(res.data[0].well_name);
                var Offline_reason = res.data[0].offline_reason;
                if(Offline_reason == 1)
                {
                	var reason = 'Battery Drain';
                }else if(Offline_reason == 2)
                {
                	var reason = 'Network Problem';
                }else{
                	var reason = 'NA';
                }
                $('#m1_offline_reason').text(reason);
                $('#m1_smps_voltage').text(res.data[0].start_smps_voltage +' V');
                $('#m1_battery_voltage').text(res.data[0].start_battery_voltage +' V');

                var date = res.data[0].start_date_time !== null ? moment(res.data[0].start_date_time).format('DD-MM-YYYY hh:mm:ss a') : "NA";
                $('#m1_last_log_datetime').text(date);

            }
        });
    }

    function show_well_wise_well_data(well_id) {
        // alert(well_id);
        $.ajax({
            url: '<?php echo base_url(); ?>Maintainance_Dasboard_c/get_single_well_data',
            type: 'POST',
            data: {well_id: well_id},
            success: function(res) {
                
                var res = JSON.parse(res);
                console.log('single well data = ', res);
               
                $('#m2_well_name').text(res.data[0].well_name);
                var Offline_reason = res.data[0].offline_reason;
                if(Offline_reason == 3)
                {
                	var reason = 'Modbus Error';
                	$('#modbus_extra_data').show();
                }else if(Offline_reason == 4)
                {
                	var reason = 'Power Down';
                	$('#modbus_extra_data').hide();
                }else{
                	var reason = 'NA';
                }
                $('#m2_offline_reason').text(reason);
                $('#m2_smps_voltage').text(res.data[0].start_smps_voltage +' V');
                $('#m2_battery_voltage').text(res.data[0].start_battery_voltage +' V');

                var date = res.data[0].start_date_time !== null ? moment(res.data[0].start_date_time).format('DD-MM-YYYY hh:mm:ss a') : "NA";
                $('#m2_last_log_datetime').text(date);


                $('#m2_avg_current').text(res.data[0].output_Average_Current +' A');
                $('#m2_avg_p2p_voltage').text(res.data[0].output_Average_Voltage_P2P +' V');

                var olr_S = res.data[0].olr_status !== null ? res.data[0].olr_status : '2';
                if(olr_S == 1)
                {
                	var olr_text = 'Healthy';
                }else if(olr_S == 0){
                	var olr_text = 'Faulty';
                }else{
                	var olr_text = 'NA';
                }
                $('#m2_olr_status').text(olr_text);

                var elr_S = res.data[0].elr_status !== null ? res.data[0].elr_status : '2';
                if(elr_S == 1)
                {
                	var elr_text = 'Healthy';
                }else if(elr_S == 0){
                	var elr_text = 'Faulty';
                }else{
                	var elr_text = 'NA';
                }
                $('#m2_elr_status').text(elr_text);

                var spp_S = res.data[0].spp_status !== null ? res.data[0].spp_status : '2';
                if(spp_S == 1)
                {
                	var spp_text = 'Healthy';
                }else if(spp_S == 0){
                	var spp_text = 'Faulty';
                }else{
                	var spp_text = 'NA';
                }

                $('#m2_spp_status').text(spp_text);
                
                $('#m2_power_factor').text(res.data[0].output_Kwh +' Kwh');
                // $('#m2_active_power').text(res.data[0].end_battery_voltage +' kw');
                $('#m2_frequency').text(res.data[0].output_System_Frequency +' Hz');
            }
        });
    }
</script>

<script type="text/javascript">
  
   setInterval(()=>{
   	   get_all_device_well_list_data();
   	   get_all_welwise_well_list_data();
   	   get_maintainance_count();
    },60000);
</script>
