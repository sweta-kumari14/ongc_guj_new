<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
<div class="page-wrapper">
<!-- Page Content -->
    <div class="content container-fluid">
    	<!-- Page Header -->
			<div class="page-header">
				<div class="row">
					<div class="col-sm-12">
						<h3 class="page-title">Running Log Graph Report</h3>
						<ul class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard_c');?>">Dashboard</a></li>
							<li class="breadcrumb-item ">Running Log Graph Log Report</li>
							
						</ul>
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
                        <h3><b>Running Log Graph Report</b></h3>
                    </div>
                    <div class="col-md-6 d-md-flex justify-content-end">
                        <div>
	                    <a href="Dashboard_c"><button class="btn btn-sm  btn-primary mx-2">Back</button></a>
                        </div>
                    </div>
    	        </div>
	        </div>
	    	  <hr style="margin-top: -10px;">
		        <div class="card-body">
					<div class="row">
						<div class="form-group col-md-4">
						    <h5><b>Graph Type</b></h5>
						    <select name="Graph_view" id="Graph_view" class="form-control select2" onchange="get_graph();">
						        <option value=""> Select Type </option>
						        <option value="Bar">Bar Graph</option>
						        <option value="Line">Line Graph</option>
						    </select>
						</div>
						<div class="form-group col-md-4" style="display:none;" id="View_bar">
						    <h5><b>View Report</b></h5>
						    <select name="report_view" id="report_view" class="form-control select2" onchange="get_view();">
						        <option value=""> Select View </option>
						        <option value="fin">Financial Year</option>
						        <option value="month">Month Wise</option>
						    </select>
						</div>
						<div class="form-group col-md-4" style="display:none;" id="View_Line">
						    <h5><b>View Report</b></h5>
						    <select name="Line_report_view" id="Line_report_view" class="form-control select2" onchange="get_Line_view();">
						        <option value=""> Select View </option>
						        <option value="Financial">Financial Year</option>
						        <option value="Month">Month Wise</option>
						    </select>
						</div>
<!-- ========================================View part for Both============================================ -->
						<div class="form-group" style="display:none;" id="filter_date">
		                    <div class="row">
								<div class="form-group col-md-3 mt-2" >
									<h5><b>Month</b></h5>
									<select class="form-control select2" name="month" id="month" onchange="get_Financial_year_graph_data(); get_monthly_running_graph_data();">
			                            <option>Select</option>
			                                <?php
			                                  for ($x = 1; $x <= 12; $x++) {
			                                    $month_num = sprintf("%02d", $x);
			                                    $month_name = date('F', mktime(0,0,0,$x));
			                                    echo '<option value="'.$month_num.'" ';
			                                    if ($x == date('n')) {
			                                      echo 'selected';
			                                    }
			                                    echo' >'.$month_name.'</option>';
			                                  }
			                                ?>
			                        </select>
								</div>
								<div class="form-group col-md-3 mt-2" >
									<h5><b> Year</b></h5>
	                                <select class="form-control select2" name="year" id="year" onchange="get_Financial_year_graph_data();get_monthly_running_graph_data(); ">
		                                <option>Select</option>
	                                    <?php
	                                        $current_year = date('Y');
	                                        for($i= $current_year ; $i < $current_year +2; $i++) {
	                                             echo '<option value="'.$i.'"';
	                                             if( $i ==  $current_year ) {
	                                                    echo ' selected="selected"';
	                                             }
	                                             echo ' >'.$i.'</option>';
	                                         }               
	                                         echo '<select>';
	                                        ?>
		                            </select>
			                    </div>

			                    <div class="form-group col-md-3 mt-2">
			                        <h5><b>Area Name</b></h5>
			                        <select name="site_id_month_bar" id="site_id_month_bar" class="form-control select2" onchange="get_well_month_bar_list();get_monthly_running_graph_data();">
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
									<h5><b>Well</b></h5>
									<select name="well_id" id="well_id" class="form-control select2" onchange="get_Financial_year_graph_data();get_monthly_running_graph_data();">
										<option value="">Select Well </option>

									</select>
								</div>
						    </div>
			            </div>

						<div id="well_wise_graph" style="display:none;">
							<div class="row">
								<div class="form-group col-md-4 mt-2">
			                        <h5><b>Area Name</b></h5>
			                        <select name="site_id" id="site_id" class="form-control select2" onchange="get_well_list();get_Financial_year_graph_data();get_monthly_running_graph_data();">
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

					        <div class="form-group col-md-4 mt-2">
								<h5><b>Well</b></h5>
								<select name="well_id_fin" id="well_id_fin" class="form-control select2" onchange="get_Financial_year_graph_data();">
									<option value="">Select Well </option>

								</select>
							</div>
								
							<div class="form-group col-md-4 mt-2">
							    <h5><b>Financial Year</b></h5>
							  
			                       <select name="fin_year" id="fin_year"  class="form-control select2" onchange="get_Financial_year_graph_data();">
			                         <option>Select</option>
			                        <?php
			                        $current_month = date('m');
			                        $current_year = date('Y');

			                        if ($current_month < 4 ) {
			                        $financial_year_start = $current_year - 1;
			                        } else {
			                        $financial_year_start = $current_year;
			                        }

			                        $financial_year_end = $financial_year_start + 1;

			                        for($i = $financial_year_start-1; $i < $financial_year_end + 2; $i++) {
			                        $fin_year = $i . '-' . ($i + 1);
			                        echo '<option value="'.$fin_year.'"';
			                       if( $fin_year === $financial_year_start . '-' . $financial_year_end ) {
			                       echo ' selected="selected"';
			                       }
			                        echo ' >'.$fin_year.'</option>';
			                       }
			                       echo '</select>';
			                      ?>
			                     </select>    
							</div>
				        </div>
				    </div>
<!-- ==============================Bar graph Filters part for =========================================== -->

<!-- ==============================Bar Line Filters part for =========================================== -->
					    <div class="form-group" style="display:none;" id="filter_date_Line_graph">
		                    <div class="row">
								<div class="form-group col-md-3 mt-2" >
									<h5><b>Month</b></h5>
									<select class="form-control select2" name="month_line" id="month_line" onchange="get_Financial_year_Line_graph_data(); get_Month_year_Line_graph_data();">
			                            <option>Select</option>
			                                <?php
			                                  for ($x = 1; $x <= 12; $x++) {
			                                    $month_num = sprintf("%02d", $x);
			                                    $month_name = date('F', mktime(0,0,0,$x));
			                                    echo '<option value="'.$month_num.'" ';
			                                    if ($x == date('n')) {
			                                      echo 'selected';
			                                    }
			                                    echo' >'.$month_name.'</option>';
			                                  }
			                                ?>
			                        </select>
								</div>
								<div class="form-group col-md-3 mt-2" >
									<h5><b> Year</b></h5>
	                                <select class="form-control select2" name="year_line" id="year_line" onchange="get_Financial_year_Line_graph_data();get_Month_year_Line_graph_data();">
		                                <option>Select</option>
	                                    <?php
	                                        $current_year = date('Y');
	                                        for($i= $current_year ; $i < $current_year +2; $i++) {
	                                             echo '<option value="'.$i.'"';
	                                             if( $i ==  $current_year ) {
	                                                    echo ' selected="selected"';
	                                             }
	                                             echo ' >'.$i.'</option>';
	                                         }               
	                                         echo '<select>';
	                                        ?>
		                            </select>
			                    </div>
			                    <div class="form-group col-md-3 mt-2">
			                        <h5><b>Area Name</b></h5>
			                        <select name="site_id_month_Line" id="site_id_month_Line" class="form-control select2" onchange="get_well_month_Line_list();;get_Month_year_Line_graph_data();">
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
									<h5><b>Well</b></h5>
									<select name="well_line" id="well_line" class="form-control select2" onchange="get_Month_year_Line_graph_data();">
										<option value="">Select Well </option>

									</select>
								</div>
						    </div>
			            </div>

					    <div id="well_wise_Line_graph" style="display:none;">
							<div class="row">
								<div class="form-group col-md-4 mt-2">
			                        <h5><b>Area Name</b></h5>
				                    <select name="site_id_line" id="site_id_line" class="form-control select2" onchange="get_well_list_Line();get_Financial_year_Line_graph_data();get_Month_year_Line_graph_data();">
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
					            <div class="form-group col-md-4 mt-2">
									<h5><b>Well</b></h5>
									<select name="well_id_fin_line" id="well_id_fin_line" class="form-control select2" onchange="get_Financial_year_Line_graph_data();">
										<option value="">Select Well </option>

									</select>
								</div>
								<div class="form-group col-md-4 mt-2">
								    <h5><b>Financial Year</b></h5>
								  
				                       <select name="fin_year_Line" id="fin_year_Line"  class="form-control select2" onchange="get_Financial_year_Line_graph_data();">
				                         <option>Select</option>
				                        <?php
				                        $current_month = date('m');
				                        $current_year = date('Y');

				                        if ($current_month < 4 ) {
				                        $financial_year_start = $current_year - 1;
				                        } else {
				                        $financial_year_start = $current_year;
				                        }

				                        $financial_year_end = $financial_year_start + 1;

				                        for($i = $financial_year_start-1; $i < $financial_year_end + 2; $i++) {
				                        $fin_year = $i . '-' . ($i + 1);
				                        echo '<option value="'.$fin_year.'"';
				                       if( $fin_year === $financial_year_start . '-' . $financial_year_end ) {
				                       echo ' selected="selected"';
				                       }
				                        echo ' >'.$fin_year.'</option>';
				                       }
				                       echo '</select>';
				                      ?>
				                     </select>    
								</div>
					        </div>
					    </div>
		           </div>
	            </div>
            </div>
        </div>
    </div>
    <!-- ========================================================================================= -->
	<div class="col-md-12" style="display: none;" id="bargraphical_chart">
	    <div class="card" style="">
	        <div class="card-header d-flex justify-content-between align-items-center" style="background-color:#90a4ae; height: 50px;">
	            <span style="font-weight: bold; font-size: 18px; color: white;">
	                <img src="<?php echo base_url() ?>assets/img/line-chart.gif" width="30" style="border-radius: 25%; vertical-align: middle; margin-right: 10px;">
	               <span id="selected_field_1"></span>
	            </span>
	            <div class="d-flex justify-content-end align-items-end mt-n2">
	                <div class="form-group" style="margin-right: 10px;">
	                    <select name="graph_type" id="graph_type" class="form-control select2" style="min-width: 200px !important; text-align: left;" onchange="get_Financial_year_graph_data();get_monthly_running_graph_data();">
	                        <option value="2">Running Log</option>
	                        <option value="3">Energy Consumption Log</option>
	                        <option value="4">Running Log and Shut Down</option>
	                        <option value="5">Well Performance</option>
	                    </select>
	                </div>
	            </div>
	        </div>

	        <div class="card-body">
	            <div id="bargraph" style="height: 2000px; width: 100%; font-size: -5px;"></div>
	        </div>
	    </div>
	</div>

	<div class="col-md-12" style="display: none;" id="finbargraphical_chart">
	    <div class="card">
	        <div class="card-header d-flex justify-content-between align-items-center" style="background-color:#90a4ae; height: 50px;">
	            <span style="font-weight: bold; font-size: 18px; color: white;">
	                <img src="<?php echo base_url() ?>assets/img/line-chart.gif" width="30" style="border-radius: 25%; vertical-align: middle; margin-right: 10px;">
	               <span id="selected_field"></span>
	            </span>
	            <div class="d-flex justify-content-end align-items-end mt-n2">
	                <div class="form-group" style="margin-right: 10px;">
	                    <select name="graph_type_1" id="graph_type_1" class="form-control select2" style="min-width: 200px !important; text-align: left;" onchange="get_Financial_year_graph_data();get_monthly_running_graph_data();">
	                        <option value="1">Running Log</option>
	                        <option value="2">Energy Consumption Log</option>
	                        <option value="3">Running Log and Shut Down</option>
	                        <option value="4">Well Performance</option>
	                    </select>
	                </div>
	            </div>
	        </div>

	        <div class="card-body">
	            <div class="col-12">
	                <div id="fin_bargraph" style="height: 2000px; width: 100%; font-size: -5px;"></div>
	                
	            </div>
	        </div>
	    </div>
	</div>
<!-- ======================================================================================== -->
	<div class="col-md-12" style="display: none;" id="fin_Line_graphical_chart">
	    <div class="card">
	        <div class="card-header d-flex justify-content-between align-items-center" style="background-color:#90a4ae; height: 50px;">
	            <span style="font-weight: bold; font-size: 18px; color: white;">
	                <img src="<?php echo base_url() ?>assets/img/line-chart.gif" width="30" style="border-radius: 25%; vertical-align: middle; margin-right: 10px;">
	               <span id="selected_field_2"></span>
	            </span>
	            <div class="d-flex justify-content-end align-items-end mt-n2">
	                <div class="form-group" style="margin-right: 10px;">
	                    <select name="graph_type_2" id="graph_type_2" class="form-control select2" style="min-width: 200px !important; text-align: left;" onchange="get_Financial_year_Line_graph_data();">
	                        <option value="1">Running Log</option>
	                        <option value="2">Energy Consumption Log</option>
	                        <option value="3">Running Log and Shut Down</option>
	                        <option value="4">Well Performance</option>
	                    </select>
	                </div>
	                <img src="<?php echo base_url() ?>assets/img/line-chart.gif" width="30" style="border-radius: 25%;">
	            </div>
	        </div>

	        <div class="card-body" style="height: 1000px; width: 100%;">
	            <div class="col-12">
	                <div id="Fin_Line_graph" style="height: 1000px; width: 100%; font-size: -5px;"></div>
	                
	            </div>
	        </div>
	    </div>
	</div>

	<div class="col-md-12" style="display: none;" id="Month_Line_graphical_chart">
	    <div class="card">
	        <div class="card-header d-flex justify-content-between align-items-center" style="background-color:#90a4ae; height: 50px;">
	            <span style="font-weight: bold; font-size: 18px; color: white;">
	                <img src="<?php echo base_url() ?>assets/img/line-chart.gif" width="30" style="border-radius: 25%; vertical-align: middle; margin-right: 10px;">
	               <span id="selected_field_3"></span>
	            </span>
	            <div class="d-flex justify-content-end align-items-end mt-n2">
	                <div class="form-group" style="margin-right: 10px;">
	                    <select name="graph_type_3" id="graph_type_3" class="form-control select2" style="min-width: 200px !important; text-align: left;" onchange="get_Month_year_Line_graph_data();">
	                        <option value="1">Running Log</option>
	                        <option value="2">Energy Consumption Log</option>
	                        <option value="3">Running Log and Shut Down</option>
	                        <option value="4">Well Performance</option>
	                    </select>
	                </div>
	            </div>
	        </div>


	        <div class="card-body" style="height: 1000px; width: 100%;">
	            <div class="col-12">
	                <div id="month_Line_graph" style="height: 1000px; width: 100%; font-size: -5px;"></div>
	                
	            </div>
	        </div>
	    </div>
	</div>

			
		</div>
    </div>
</div>

<script type="text/javascript">
get_well_month_bar_list();
function get_well_month_bar_list() { 
    let company_id = "<?php echo $this->session->userdata('company_id') ?>";
    let site_id = $('#site_id_month_bar').val();

    $.ajax({
        type: 'POST',
        url: '<?php echo base_url();?>Running_Log_Graph_report_c/Well_list',
        data: { company_id: company_id,site_id: site_id,},
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
get_well_list();
function get_well_list() { 
    let company_id = "<?php echo $this->session->userdata('company_id') ?>";
    let site_id = $('#site_id').val();

    $.ajax({
        type: 'POST',
        url: '<?php echo base_url();?>Running_Log_Graph_report_c/Well_list',
        data: { company_id: company_id,site_id: site_id,},
        success: function(data) {
            data = JSON.parse(data);
            if (data.response_code == 200) {   
                if (data.data.length > 0) {
                    $('#well_id_fin').html('');
                    $('#well_id_fin').html('<option value="">Select Well</option>');
                    $.each(data.data, function(i, v) {
                     
                        $('#well_id_fin').append('<option value="' + v.well_id + '">' + v.well_name + '</option>');
                    });
                } else {
                    $('#well_id_fin').html('<option value="">No Well Found</option>');
                }
            } else {
                swal('error', data.msg, 'error');
            }   
        }
    });
}
</script>

<script type="text/javascript">
get_well_list_Line();
function get_well_list_Line() { 
    let company_id = "<?php echo $this->session->userdata('company_id') ?>";
    let site_id = $('#site_id_line').val();

    $.ajax({
        type: 'POST',
        url: '<?php echo base_url();?>Running_Log_Graph_report_c/Well_list_Line',
        data: { company_id: company_id,site_id: site_id},
        success: function(data) {
            data = JSON.parse(data);
            if (data.response_code == 200) {   
                if (data.data.length > 0) {
                    $('#well_id_fin_line').html('');
                    $('#well_id_fin_line').html('<option value="">Select Well</option>');
                    $.each(data.data, function(i, v) {
                     
                        $('#well_id_fin_line').append('<option value="' + v.well_id + '">' + v.well_name + '</option>');
                    });
                } else {
                    $('#well_id_fin_line').html('<option value="">No Well Found</option>');
                }
            } else {
                swal('error', data.msg, 'error');
            }   
        }
    });
}
</script>

<script type="text/javascript">
get_well_month_Line_list();
function get_well_month_Line_list() { 
    let company_id = "<?php echo $this->session->userdata('company_id') ?>";
    let site_id = $('#site_id_month_Line').val();

    $.ajax({
        type: 'POST',
        url: '<?php echo base_url();?>Running_Log_Graph_report_c/Well_list',
        data: { company_id: company_id,site_id: site_id,},
        success: function(data) {
            data = JSON.parse(data);
            if (data.response_code == 200) {   
                if (data.data.length > 0) {
                    $('#well_line').html('');
                    $('#well_line').html('<option value="">Select Well</option>');
                    $.each(data.data, function(i, v) {
                     
                        $('#well_line').append('<option value="' + v.well_id + '">' + v.well_name + '</option>');
                    });
                } else {
                    $('#well_line').html('<option value="">No Well Found</option>');
                }
            } else {
                swal('error', data.msg, 'error');
            }   
        }
    });
}
</script>

<script type="text/javascript">
    function get_graph() {
        var value = $('#Graph_view').val();

        if (value == 'Bar') {
            $('#View_bar').show();
            $('#View_Line').hide(); 
        } else if (value == 'Line') {
            $('#View_bar').hide();
            $('#View_Line').show(); 
        } else {
            $('#View_bar').hide();
            $('#View_Line').hide(); 
        }
    }

    function get_view() {
        var value = $('#report_view').val();

        if (value == 'fin') {
            $('#well_wise_graph').show();
            $('#filter_date').hide();
            $('#bargraphical_chart').hide();
            $('#finbargraphical_chart').show();

            $('#well_wise_Line_graph').hide();
            $('#filter_date_Line_graph').hide();
            $('#Month_Line_graphical_chart').hide();
            $('#fin_Line_graphical_chart').hide();
        } else if (value == 'month') {
            $('#well_wise_graph').hide();
            $('#filter_date').show();
            $('#bargraphical_chart').show();
            $('#finbargraphical_chart').hide();

            $('#well_wise_Line_graph').hide();
            $('#filter_date_Line_graph').hide();
            $('#Month_Line_graphical_chart').hide();
            $('#fin_Line_graphical_chart').hide()
        } else {
            $('#well_wise_graph').hide();
            $('#filter_date').hide();
            $('#bargraphical_chart').hide();
            $('#finbargraphical_chart').hide();

            $('#well_wise_Line_graph').hide();
            $('#filter_date_Line_graph').hide();
            $('#Month_Line_graphical_chart').hide();
            $('#fin_Line_graphical_chart').hide()
        }
    }

    function get_Line_view() {
        var value = $('#Line_report_view').val();

        if (value == 'Financial') {
            $('#well_wise_Line_graph').show();
            $('#filter_date_Line_graph').hide();
            $('#Month_Line_graphical_chart').hide();
            $('#fin_Line_graphical_chart').show();

            $('#well_wise_graph').hide();
            $('#finbargraphical_chart').hide();
            $('#bargraphical_chart').hide();
            $('#filter_date').hide();
        } else if (value == 'Month') {
            $('#well_wise_Line_graph').hide();
            $('#filter_date_Line_graph').show();
            $('#Month_Line_graphical_chart').show();
            $('#fin_Line_graphical_chart').hide();

            $('#well_wise_graph').hide();
            $('#finbargraphical_chart').hide();
            $('#bargraphical_chart').hide();
            $('#filter_date').hide();
        } else {
            $('#well_wise_Line_graph').hide();
            $('#filter_date_Line_graph').hide();
            $('#Month_Line_graphical_chart').hide();
            $('#fin_Line_graphical_chart').hide();

            $('#well_wise_graph').hide();
            $('#finbargraphical_chart').hide();
            $('#bargraphical_chart').hide();
            $('#filter_date').hide();
        }
    }
</script>

<script>
get_Financial_year_graph_data();
    function get_Financial_year_graph_data(){
        var site_id = $('#site_id').val();
        var well_id = $('#well_id_fin').val();
        var fin_year = $('#fin_year').val();
        var graph_type = $('#graph_type_1').val();
        var well_name = $('#well_id_fin option:selected').text();

        $.ajax({
            url: '<?php echo base_url(); ?>Running_Log_Graph_report_c/get_Financial_running_log_graph_data',
            type: 'POST',
            data: {
            	site_id:site_id,
                well_id: well_id,
                fin_year: fin_year,
                graph_type: graph_type
            },
            success: function (res) {
                var res = JSON.parse(res);
                var headingText = "Running Log Graph: " + well_name;
                var headingText1 = "Energy Consumption Graph: " + well_name;
                var headingText2 = "Running and Shut Down Hours Graph: " + well_name;
                var headingText3 = "Well Performance Graph: " + well_name;

                get_Financial_bar_graph_chart(res.data,graph_type,headingText,headingText1,headingText2,headingText3);
            }

        });
    }

    function get_Financial_bar_graph_chart(data_points, graph_type,headingText,headingText1,headingText2,headingText3){
    	var selectedField = document.getElementById("selected_field");

        var chart;

        if (graph_type == 1) {
            var t_minutes_data = [];

            for (var i = 0; i < data_points.length; i++) {
                var totalMinutes = parseFloat(data_points[i].y);

                var hours = Math.floor(totalMinutes / 60);
                var minutes = totalMinutes % 60;

                // Construct the formatted time string
                var formattedTime = hours + " hours " + minutes + " minutes";

                var dataPoint = {
                    label: data_points[i].x,
                    y: totalMinutes // Use the numerical value for the y-axis
                };

                t_minutes_data.push(dataPoint);
            }
               selectedField.textContent = headingText;
            chart = new CanvasJS.Chart("fin_bargraph", {
            	
            	 width: 950, 
                 height: 2000,
 
                animationEnabled: true,
                title: {
                    // text: "Running Log Graph",
                    // fontSize: 23
                },
                axisY: [{
                    title: "Running (Hours)",
                    titleFontColor: "#4F81BC",
                    lineColor: "#4F81BC",
                    labelFontColor: "#4F81BC",
                    tickColor: "#4F81BC",
                    labelFontSize: 15,
                    titleFontSize: 15,
                    labelFormatter: function (e) {
                        var hours = Math.floor(e.value / 60);
                        var minutes = e.value % 60;
                        return hours + " hours " + minutes + " minutes";
                    }
                }],
                axisX: [{
                    titleFontColor: "#4F81BC",
                    lineColor: "#4F81BC",
                    labelFontColor: "#4F81BC",
                    tickColor: "#4F81BC",
                    labelFontSize: 15,
                    titleFontSize: 15
                }],
                toolTip: {
                    shared: true,
                    fontSize: 12,
                    contentFormatter: function (e) {
                        var content = " ";
                        for (var i = 0; i < e.entries.length; i++) {
                            var hours = Math.floor(e.entries[i].dataPoint.y / 60);
                            var minutes = e.entries[i].dataPoint.y % 60;
                            content += "<strong>" + e.entries[i].dataPoint.label + " (Running Hours):</strong> " + hours + " hours " + minutes + " minutes<br/>";
                        }
                        return content;
                    }
                },
                legend: {
                    cursor: "pointer",
                    itemclick: toggleDataSeries,
                    fontSize: 8
                },
                data: [{
                    type: "bar",
                    name: "Running (Minutes)",
                    legendText: "Running (Minutes)",
                    dataPoints: t_minutes_data
                }]
            });

            chart.render();

            function toggleDataSeries(e) {
                if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                    e.dataSeries.visible = false;
                } else {
                    e.dataSeries.visible = true;
                }
                chart.render();
            }
        } else if (graph_type == 2) {
            var e_consumption_data = [];

            for (var i = 0; i < data_points.length; i++) {
                var dataPoint = {
                    label: data_points[i].x,
                    y: parseFloat(data_points[i].y)
                };
                e_consumption_data.push(dataPoint);

            }
             selectedField.textContent = headingText1;
            chart = new CanvasJS.Chart("fin_bargraph", {
            	width: 950, 
                height: 2000,
                animationEnabled: true,
                title: {
                    // text: "Energy Consumption Graph",
                    // fontSize: 23
                },
                axisY: [{
                    title: "Energy in Kwh",
                    titleFontColor: "#4F81BC",
                    lineColor: "#4F81BC",
                    labelFontColor: "#4F81BC",
                    tickColor: "#4F81BC",
                    labelFontSize: 15,
                    titleFontSize: 15
                }],
                axisX: [{
                    titleFontColor: "#4F81BC",
                    lineColor: "#4F81BC",
                    labelFontColor: "#4F81BC",
                    tickColor: "#4F81BC",
                    labelFontSize: 15,
                    titleFontSize: 15
                }],
                toolTip: {
                    shared: true,
                    labelFontSize: 12
                },
                legend: {
                    cursor: "pointer",
                    itemclick: toggleDataSeries,
                    labelFontSize: 12
                },
                data: [{
                    type: "bar",
                    name: "E Consumption (Kwh)",
                    dataPoints: e_consumption_data,
                    labelFontSize: 12
                }]
            });

            chart.render();


            function toggleDataSeries(e) {
                if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                    e.dataSeries.visible = false;
                } else {
                    e.dataSeries.visible = true;
                }
                chart.render();
            }
        } else if (graph_type == 3) {
            var t_minutes_data = [];
            var shut_down_data = [];

            for (var i = 0; i < data_points.length; i++) {
                var t_minutes = parseFloat(data_points[i].t_minute);
                var t_hours = Math.floor(t_minutes / 60);
                var t_remaining_minutes = t_minutes % 60;
                var t_formatted_time = t_hours + "h " + t_remaining_minutes + "m"; // Format: hours 'h' minutes 'm'
                var t_minutes_point = {
                    y: t_minutes, 
                    label: data_points[i].x 
                };
                t_minutes_data.push(t_minutes_point);

                var shut_down_minutes = parseFloat(data_points[i].shutdown_minutes);
                var shut_down_hours = Math.floor(shut_down_minutes / 60);
                var shut_down_remaining_minutes = shut_down_minutes % 60;
                var shut_down_formatted_time = shut_down_hours + "h " + shut_down_remaining_minutes + "m";

                var shut_down_point = {
                    y: shut_down_minutes, 
                    label: data_points[i].x 
                };
                shut_down_data.push(shut_down_point);
            }
              selectedField.textContent = headingText2;
            chart = new CanvasJS.Chart("fin_bargraph", {
            	width: 950, 
                height: 2000,
                animationEnabled: true,
                title: {
                    // text: "Running and Shut Down Hours Graph",
                    // fontSize: 23
                },
                axisX: [{
                    // title: "Minutes", // X-axis title
                    titleFontColor: "#4F81BC",
                    lineColor: "#4F81BC",
                    labelFontColor: "#4F81BC",
                    tickColor: "#4F81BC",
                    reversed: true,
                    labelFontSize: 15,
                    titleFontSize: 15
                }],
                axisY: {
                    title: "Hour's and Minutes", // Y-axis title
                    titleFontColor: "#4F81BC",
                    lineColor: "#4F81BC",
                    labelFontColor: "#4F81BC",
                    tickColor: "#4F81BC",
                    labelFontSize: 15,
                    titleFontSize: 15,
                    labelFormatter: function (e) {
                        var hours = Math.floor(e.value / 60);
                        var minutes = e.value % 60;
                        return hours + " hours " + minutes + " minutes";
                    }
                },
                toolTip: {
			    shared: true,
			    labelFontSize: 12,
			    contentFormatter: function (e) {
			        var content = "";
			        for (var i = 0; i < e.entries.length; i++) {
			            var dataPoint = e.entries[i].dataPoint;
			            var wellName = e.entries[i].dataPoint.label;
			            var hours = Math.floor(dataPoint.y / 60);
			            var minutes = dataPoint.y % 60;
			            if(hours < 0)
			            {
			            	var hours = Math.floor(Math.abs(dataPoint.y) / 60);
			            	var minutes = Math.abs(dataPoint.y) % 60;
			            	content += "<strong>" + e.entries[i].dataSeries.name + "</strong> (" + wellName + "): Extra " + hours + " hours " + minutes + " minutes<br/>";
			            }else{
			            	content += "<strong>" + e.entries[i].dataSeries.name + "</strong> (" + wellName + "): " + hours + " hours " + minutes + " minutes<br/>";
			            }
			            
			        }
			        return content;
			    }
			},
                legend: {
                    cursor: "pointer",
                    itemclick: toggleDataSeries,
                    labelFontSize: 12
                },
                data: [{
                        type: "bar",
                        name: "Running (Hours)",
                        dataPoints: t_minutes_data,
                        labelFontSize: 15,
                        titleFontSize: 15
                    },
                    {
                        type: "bar",
                        name: "Shut Down (Hours)",
                        dataPoints: shut_down_data,
                        labelFontSize: 15,
                        titleFontSize: 15
                    }
                ]
            });

            chart.render();


            function toggleDataSeries(e) {
                if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                    e.dataSeries.visible = false;
                } else {
                    e.dataSeries.visible = true;
                }
                chart.render();
            }
        } else if (graph_type == 4) {
            var availability_data = [];

            for (var i = 0; i < data_points.length; i++) {
                var dataPoint = {
                    label: data_points[i].x,
                    y: parseFloat(data_points[i].y)
                };
                availability_data.push(dataPoint);
            }
                selectedField.textContent = headingText3;
            chart = new CanvasJS.Chart("fin_bargraph", {
            	width: 950, 
                height: 2000,
                animationEnabled: true,
                title: {
                    // text: "Well Performance Graph",
                    // fontSize: 23
                },
                axisX: {
                    // title: "Well Performance",
                    titleFontColor: "#4F81BC",
                    lineColor: "#4F81BC",
                    labelFontColor: "#4F81BC",
                    tickColor: "#4F81BC",
                    labelFontSize: 15,
                    titleFontSize: 15
                },
                axisY: {
	            title: "Availability (%)", // Include the percentage sign here
	            titleFontColor: "#4F81BC",
	            lineColor: "#4F81BC",
	            labelFontColor: "#4F81BC",
	            tickColor: "#4F81BC",
	            labelFontSize: 15,
	            titleFontSize: 15,
	            labelFormatter: function (e) {
	                return e.value + "%";
	            }
	        },

                toolTip: {
                    shared: true,
                    labelFontSize: 12
                },
                legend: {
                    cursor: "pointer",
                    itemclick: toggleDataSeries,
                    labelFontSize: 12
                },
                data: [{
                    type: "bar",
                    name: "Availability %",
	                // legendText: "Availability",
                    // showInLegend: true,
                    dataPoints: availability_data,
                    labelFontSize: 12,
                    titleFontSize: 8
                }]
            });

            chart.render();


            function toggleDataSeries(e) {
                if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                    e.dataSeries.visible = false;
                } else {
                    e.dataSeries.visible = true;
                }
                chart.render();
            }
    }
}

get_monthly_running_graph_data();
	function get_monthly_running_graph_data() {
	    var site_id =  $('#site_id_month_bar').val();
	    var well_id = $('#well_id').val();
	    var month_id = $('#month').val();
	    var year = $('#year').val();
	    var graph_type = $('#graph_type').val();
	    var well_name = $('#well_id option:selected').text();

	    $.ajax({
	        url: '<?php echo base_url(); ?>Running_Log_Graph_report_c/get_monthly_running_log_graph_data',
	        type: 'POST',
	        data: {
	        	site_id:site_id,
	            well_id: well_id,
	            month_id: month_id,
	            year: year,
	            graph_type: graph_type
	        },
	        success: function (res) {
	        	var res = JSON.parse(res);
	        	var headingText8 = "Running Log Graph: " + well_name;
                var headingText9 = "Energy Consumption Graph: " + well_name;
                var headingText10 = "Running and Shut Down Hours Graph: " + well_name;
                var headingText11 = "Well Performance Graph: " + well_name;

	            get_bar_graph_chart(res.data, graph_type,headingText8,headingText9,headingText10,headingText11);
	        }

	    });
	}

	function get_bar_graph_chart(data_points, graph_type,headingText8,headingText9,headingText10,headingText11) {
		var selected_field_1 = document.getElementById("selected_field_1");
	    var chart;
	    if (graph_type == 2) {
	        var t_minutes_data = [];

	        for (var i = 0; i < data_points.length; i++) {
	            var totalMinutes = parseFloat(data_points[i].t_minute);

	            var hours = Math.floor(totalMinutes / 60);
	            var minutes = totalMinutes % 60;

	            // Construct the formatted time string
	            var formattedTime = hours + " hours " + minutes + " minutes";

	            var dataPoint = {
	                label: data_points[i].x,
	                y: totalMinutes // Use the numerical value for the y-axis
	            };

	            t_minutes_data.push(dataPoint);
	        }
            selected_field_1.textContent = headingText8;
	        chart = new CanvasJS.Chart("bargraph", {
	        	width: 950, 
                 height: 2000,
	            animationEnabled: true,
	            title: {
	                // text: "Running Log Graph",
	                // fontSize: 23
	            },
	            axisY: [{
	                title: "Running (Hours)",
	                titleFontColor: "#4F81BC",
	                lineColor: "#4F81BC",
	                labelFontColor: "#4F81BC",
	                tickColor: "#4F81BC",
	                labelFontSize: 15,
	                titleFontSize: 15,
	                labelFormatter: function (e) {
                        var hours = Math.floor(e.value / 60);
                        var minutes = e.value % 60;
                        return hours + " hours " + minutes + " minutes";
                    }
	            }],
	            axisX: [{
	                titleFontColor: "#4F81BC",
	                lineColor: "#4F81BC",
	                labelFontColor: "#4F81BC",
	                tickColor: "#4F81BC",
	                labelFontSize: 15,
	                titleFontSize: 15
	            }],
	            toolTip: {
	                shared: true,
	                fontSize: 12,
	                contentFormatter: function (e) {
			        var content = " ";
			        for (var i = 0; i < e.entries.length; i++) {
			            var hours = Math.floor(e.entries[i].dataPoint.y / 60);
			            var minutes = e.entries[i].dataPoint.y % 60;
			            minutes = parseFloat(minutes).toFixed(2); // Limiting minutes to two digits after the decimal point
			            content += "<strong>" + e.entries[i].dataPoint.label + " (Running Hours):</strong> " + hours + " hours " + minutes + " minutes<br/>";
			        }
			        return content;
				}
	            },
	            legend: {
	                cursor: "pointer",
	                itemclick: toggleDataSeries,
	                fontSize: 8
	            },
	            data: [{
	                type: "bar",
	                name: "Running (Hour's)",
	                legendText: "Running (Hour's)",
	                dataPoints: t_minutes_data
	            }]
	        });

	        chart.render();

	        function toggleDataSeries(e) {
	            if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
	                e.dataSeries.visible = false;
	            } else {
	                e.dataSeries.visible = true;
	            }
	            chart.render();
	        }
	    } else if (graph_type == 3) {
	        var e_consumption_data = [];

	        for (var i = 0; i < data_points.length; i++) {
	            var dataPoint = {
	                label: data_points[i].x,
	                y: parseFloat(data_points[i].e_consumption)
	            };
	            e_consumption_data.push(dataPoint);
	        }
            selected_field_1.textContent = headingText9;
	        chart = new CanvasJS.Chart("bargraph", {
	        	width: 950, 
                 height: 2000,
	            animationEnabled: true,
	            title: {
	                // text: "Energy Consumption Graph",
	                // fontSize: 16
	            },
	            axisY: [{
	                title: "Energy in Kwh",
	                titleFontColor: "#4F81BC",
	                lineColor: "#4F81BC",
	                labelFontColor: "#4F81BC",
	                tickColor: "#4F81BC",
	                labelFontSize: 15,
	                titleFontSize: 15
	            }],
	            axisX: [{
	                titleFontColor: "#4F81BC",
	                lineColor: "#4F81BC",
	                labelFontColor: "#4F81BC",
	                tickColor: "#4F81BC",
	                labelFontSize: 15,
	                titleFontSize: 15
	            }],
	            toolTip: {
	                shared: true,
	                labelFontSize: 12
	            },
	            legend: {
	                cursor: "pointer",
	                itemclick: toggleDataSeries,
	                labelFontSize: 12
	            },
	            data: [{
	                type: "bar",
	                name: "E_Consumption (Kwh)",
	                dataPoints: e_consumption_data,
	                labelFontSize: 12
	            }]
	        });

	        chart.render();


	        function toggleDataSeries(e) {
	            if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
	                e.dataSeries.visible = false;
	            } else {
	                e.dataSeries.visible = true;
	            }
	            chart.render();
	        }
	    } else if (graph_type == 4) {
	        var t_minutes_data = [];
	        var shut_down_data = [];

	        for (var i = 0; i < data_points.length; i++) {
	            var t_minutes = parseFloat(data_points[i].t_minute);
	            var t_hours = Math.floor(t_minutes / 60);
	            var t_remaining_minutes = t_minutes % 60;
	            var t_formatted_time = t_hours + "h " + t_remaining_minutes + "m"; // Format: hours 'h' minutes 'm'
	            var t_minutes_point = {
	                y: t_minutes, 
	                label: data_points[i].x 
	            };
	            t_minutes_data.push(t_minutes_point);

	            var shut_down_minutes = parseFloat(data_points[i].shutdown_minutes);
	            var shut_down_hours = Math.floor(shut_down_minutes / 60);
	            var shut_down_remaining_minutes = shut_down_minutes % 60;
	            var shut_down_formatted_time = shut_down_hours + "h " + shut_down_remaining_minutes + "m"; 
	            var shut_down_point = {
	                y: shut_down_minutes, 
	                label: data_points[i].x 
	            };
	            shut_down_data.push(shut_down_point);
	        }
            selected_field_1.textContent = headingText10;
	        chart = new CanvasJS.Chart("bargraph", {
	        	width: 950, 
                 height: 2000,
	            animationEnabled: true,
	            title: {
	                // text: "Running and Shut Down Hours Graph",
	                // fontSize: 23
	            },
	            axisX: [{
	                // title: "Minutes", // X-axis title
	                titleFontColor: "#4F81BC",
	                lineColor: "#4F81BC",
	                labelFontColor: "#4F81BC",
	                tickColor: "#4F81BC",
	                reversed: true,
	                labelFontSize: 15,
	                titleFontSize: 15
	            }],
	            axisY: {
	                title: "Hour's and Minutes", // Y-axis title
	                titleFontColor: "#4F81BC",
	                lineColor: "#4F81BC",
	                labelFontColor: "#4F81BC",
	                tickColor: "#4F81BC",
	                labelFontSize: 15,
	                titleFontSize: 15,
	                labelFormatter: function (e) {
	                    var hours = Math.floor(e.value / 60);
	                    var minutes = e.value % 60;
	                    return hours + " hours " + minutes + " minutes";
	                }
	            },
	            toolTip: {
	                shared: true,
	                labelFontSize: 12,
	                contentFormatter: function (e) {
			        var content = "";
			        for (var i = 0; i < e.entries.length; i++) {
			            var dataPoint = e.entries[i].dataPoint;
			            var wellName = e.entries[i].dataPoint.label;
			            var hours = Math.floor(dataPoint.y / 60);
			            var minutes = dataPoint.y % 60;
			            // content += "<strong>" + e.entries[i].dataSeries.name + "</strong> (" + wellName + "): " + hours + " hours " + minutes + " minutes<br/>";

			            // --------------------------
			            if(hours < 0)
			            {
			            	var hours = Math.floor(Math.abs(dataPoint.y) / 60);
			            	var minutes = Math.abs(dataPoint.y) % 60;
			            	content += "<strong>" + e.entries[i].dataSeries.name + "</strong> (" + wellName + "): Extra " + hours + " hours " + minutes + " minutes<br/>";
			            }else{
			            	content += "<strong>" + e.entries[i].dataSeries.name + "</strong> (" + wellName + "): " + hours + " hours " + minutes + " minutes<br/>";
			            }
			            // ----------------------------
			        }
			        return content;
			    }
			},
	            legend: {
	                cursor: "pointer",
	                itemclick: toggleDataSeries,
	                labelFontSize: 12
	            },
	            data: [{
	                    type: "bar",
	                    name: "Running (Minutes)",
	                    dataPoints: t_minutes_data,
	                    labelFontSize: 15,
	                    titleFontSize: 15
	                },
	                {
	                    type: "bar",
	                    name: "Shut Down (Minutes)",
	                    dataPoints: shut_down_data,
	                    labelFontSize: 15,
	                    titleFontSize: 15
	                }
	            ]
	        });

	        chart.render();


	        function toggleDataSeries(e) {
	            if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
	                e.dataSeries.visible = false;
	            } else {
	                e.dataSeries.visible = true;
	            }
	            chart.render();
	        }

	    } else if (graph_type == 5) {
	        var availability_data = [];

	        for (var i = 0; i < data_points.length; i++) {
	            var dataPoint = {
	                label: data_points[i].x,
	                y: parseFloat(data_points[i].availability)
	            };
	            availability_data.push(dataPoint);
	        }
            selected_field_1.textContent = headingText11;
	        chart = new CanvasJS.Chart("bargraph", {
	        	width: 950, 
                 height: 2000,
	            animationEnabled: true,
	            title: {
	                text: "Well Performance Graph",
	                fontSize: 23
	            },
	            axisX: {
	                // title: "Well Performance",
	                titleFontColor: "#4F81BC",
	                lineColor: "#4F81BC",
	                labelFontColor: "#4F81BC",
	                tickColor: "#4F81BC",
	                labelFontSize: 15,
	                titleFontSize: 15
	            },
	            axisY: {
	            title: "Availability (%)", // Include the percentage sign here
	            titleFontColor: "#4F81BC",
	            lineColor: "#4F81BC",
	            labelFontColor: "#4F81BC",
	            tickColor: "#4F81BC",
	            labelFontSize: 15,
	            titleFontSize: 15,
	            labelFormatter: function (e) {
	                return e.value + "%";
	            }
	        },

	            toolTip: {
	                shared: true,
	                labelFontSize: 12
	            },
	            legend: {
	                cursor: "pointer",
	                itemclick: toggleDataSeries,
	                labelFontSize: 12
	            },
	            data: [{
	                type: "bar",
	                name: "Availability %",
	                // legendText: "Availability",
	                // showInLegend: true,
	                dataPoints: availability_data,
	                labelFontSize: 12,
	                titleFontSize: 8
	            }]
	        });

	        chart.render();


	        function toggleDataSeries(e) {
	            if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
	                e.dataSeries.visible = false;
	            } else {
	                e.dataSeries.visible = true;
	            }
	            chart.render();
	        }
	    }
	}
</script>

<script>
get_Financial_year_Line_graph_data();
    function get_Financial_year_Line_graph_data(){
        var site_id = $('#site_id_line').val();
        var well_id = $('#well_id_fin_line').val();
        var fin_year = $('#fin_year_Line').val();
        var graph_type = $('#graph_type_2').val();
        var well_name = $('#well_id_fin_line option:selected').text();


        $.ajax({
            url: '<?php echo base_url(); ?>Running_Log_Graph_report_c/get_Financial_running_log_Line_graph_data',
            type: 'POST',
            data: {
            	site_id:site_id,
                well_id: well_id,
                fin_year: fin_year,
                graph_type: graph_type
            },
            success: function (res) {
                var res = JSON.parse(res);

                var headingText4 = "Running Log Graph: " + well_name;
                var headingText5 = "Energy Consumption Graph: " + well_name;
                var headingText6 = "Running and Shut Down Hours Graph: " + well_name;
                var headingText7 = "Well Performance Graph: " + well_name;

                get_Financial_Line_graph_chart(res.data,graph_type,headingText4,headingText5,headingText6,headingText7);
            }

        });
    }

    function get_Financial_Line_graph_chart(data_points, graph_type,headingText4,headingText5,headingText6,headingText7) {
    	var selected_field_2 = document.getElementById("selected_field_2");
    var chart;

	if (graph_type == 1) {
    var t_minutes_data = [];

    for (var i = 0; i < data_points.length; i++) {
        var totalHours = parseFloat(data_points[i].y); // Assuming data_points[i].y represents total hours

        var hours = Math.floor(totalHours);
        var minutes = Math.round((totalHours - hours) * 60);

        var formattedTime = hours + " hours " + minutes + " minutes";

        var dataPoint = {
            label: data_points[i].x, // Assuming data_points[i].x represents well names
            y: totalHours // Use the total hours for the y-axis
        };

        t_minutes_data.push(dataPoint);
    }
	    var t_minutes_data = [];

		var colors = ["red", "blue", "green", "orange", "purple"]; 
		for (var i = 0; i < data_points.length; i++) {
		    var totalHours = parseFloat(data_points[i].y);

		    var hours = Math.floor(totalHours);
		    var minutes = Math.round((totalHours - hours) * 60);

		    var formattedTime = hours + " hours " + minutes + " minutes";

		    var colorIndex = i % colors.length;
		    var dataPoint = {
		        label: data_points[i].x,
		        y: totalHours, 
		        color: colors[colorIndex]
		    };

		    t_minutes_data.push(dataPoint);
		}
        selected_field_2.textContent = headingText4;
		chart = new CanvasJS.Chart("Fin_Line_graph", {
			width: 950, 
            height: 950,
		    animationEnabled: true,
		    exportEnabled: true,
		    title: {
		        // text: "Running Log Graph",
		        // fontSize: 23
		    },
		    axisY: [{
		        title: "Running (Hours)",
		        titleFontColor: "#4F81BC",
		        lineColor: "#4F81BC",
		        labelFontColor: "#4F81BC",
		        tickColor: "#4F81BC",
		        labelFontSize: 15,
		        titleFontSize: 15,
		        labelFormatter: function (e) {
		            var hours = Math.floor(e.value / 60);
		            var minutes = e.value % 60;
		            return hours + " hours " + minutes + " minutes";
		        }
		    }],
		    axisX: [{
		        titleFontColor: "#4F81BC",
		        lineColor: "#4F81BC",
		        labelFontColor: "#4F81BC",
		        tickColor: "#4F81BC",
		        labelFontSize: 15,
		        titleFontSize: 15
		    }],
		    toolTip: {
                    shared: true,
                    fontSize: 12,
                    contentFormatter: function (e) {
                        var content = " ";
                        for (var i = 0; i < e.entries.length; i++) {
                            var hours = Math.floor(e.entries[i].dataPoint.y / 60);
                            var minutes = e.entries[i].dataPoint.y % 60;
                            content += "<strong>" + e.entries[i].dataPoint.label + " (Running Hours):</strong> " + hours + " hours " + minutes + " minutes<br/>";
                        }
                        return content;
                    }
                },
		    legend: {
		        cursor: "pointer",
		        itemclick: toggleDataSeries,
		        fontSize: 12
		    },
		    data: [{
		        type: "spline",
		        // showInLegend: true,
		        // name: "Running (Hours)",
		        // legendText: "Running (Hours)",
		        labelFontSize: 20,
		        titleFontSize: 20,
		        dataPoints: t_minutes_data
		    }]
		});

		chart.render();

		function toggleDataSeries(e) {
		    if(typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		        e.dataSeries.visible = false;
		    }
		    else {
		        e.dataSeries.visible = true;            
		    }
		    chart.render();
		}
        } else if (graph_type == 2) {
            var e_consumption_data = [];

            for (var i = 0; i < data_points.length; i++) {
                var dataPoint = {
                    label: data_points[i].x,
                    y: parseFloat(data_points[i].y)
                };
                e_consumption_data.push(dataPoint);
            }
            selected_field_2.textContent = headingText5;
            chart = new CanvasJS.Chart("Fin_Line_graph", {
            	width: 950, 
                height: 950,
                animationEnabled: true,
		        exportEnabled: true,
                title: {
                    // text: "Energy Consumption Graph",
                    // fontSize: 23
                },
                axisY: [{
                    title: "Energy in Kwh",
                    titleFontColor: "#4F81BC",
                    lineColor: "#4F81BC",
                    labelFontColor: "#4F81BC",
                    tickColor: "#4F81BC",
                    labelFontSize: 15,
                    titleFontSize: 15
                }],
                axisX: [{
                    titleFontColor: "#4F81BC",
                    lineColor: "#4F81BC",
                    labelFontColor: "#4F81BC",
                    tickColor: "#4F81BC",
                    labelFontSize: 15,
                    titleFontSize: 15
                }],
                toolTip: {
                    shared: true,
                    labelFontSize: 12
                },
                legend: {
                    cursor: "pointer",
                    itemclick: toggleDataSeries,
                    labelFontSize: 8
                },
                data: [{
		        type: "spline",
		        // showInLegend: true,
		        name: "E_Consumption (Kwh)",
		        // legendText: "E_Consumption (Kwh)",
		        labelFontSize: 12,
		        dataPoints: e_consumption_data
			    }]
            });

            chart.render();


            function toggleDataSeries(e) {
                if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                    e.dataSeries.visible = false;
                } else {
                    e.dataSeries.visible = true;
                }
                chart.render();
            }
        } else if (graph_type == 3) {

			var t_minutes_data = [];
			var shut_down_data = [];

			for (var i = 0; i < data_points.running_shutdown.running.length; i++) {
			    // Processing running time
			    var running_minutes = parseFloat(data_points.running_shutdown.running[i].y);
			    var running_hours = Math.floor(running_minutes / 60);
			    var running_remaining_minutes = running_minutes % 60;
			    var running_formatted_time = running_hours + "h " + running_remaining_minutes + "m"; // Format: hours 'h' minutes 'm'
			    var running_point = {
			        y: running_minutes,
			        label: data_points.running_shutdown.running[i].x
			    };
			    t_minutes_data.push(running_point);
			    
			    var shut_down_minutes = parseFloat(data_points.running_shutdown.shutdown_minutes[i].y);
			    var shut_down_hours = Math.floor(shut_down_minutes / 60);
			    var shut_down_remaining_minutes = shut_down_minutes % 60;
			    var shut_down_formatted_time = shut_down_hours + "h " + shut_down_remaining_minutes + "m";
			    var shut_down_point = {
			        y: shut_down_minutes,
			        label: data_points.running_shutdown.shutdown_minutes[i].x
			    };
			    shut_down_data.push(shut_down_point);
			}
			selected_field_2.textContent = headingText6;
            chart = new CanvasJS.Chart("Fin_Line_graph", {
            	width: 950, 
                height: 950,
                animationEnabled: true,
                title: {
                    // text: "Running and Shut Down Hours Graph",
                    // fontSize: 23
                },
                axisX: [{
                    // title: "Minutes", // X-axis title
                    titleFontColor: "#CB4335",
                    lineColor: "#CB4335",
                    labelFontColor: "#CB4335",
                    tickColor: "#CB4335",
                    reversed: true,
                    labelFontSize: 15,
                    titleFontSize: 15
                }],
                axisY: {
                    title: "Hours", // Y-axis title
                    titleFontColor: "#4F81BC",
                    lineColor: "#4F81BC",
                    labelFontColor: "#4F81BC",
                    tickColor: "#4F81BC",
                    labelFontSize: 15,
                    titleFontSize: 15,
                    labelFormatter: function (e) {
                        var hours = Math.floor(e.value / 60);
                        var minutes = e.value % 60;
                        return hours + " hours " + minutes + " minutes";
                    }
                },
                toolTip: {
                    shared: true,
                    labelFontSize: 12,
                    contentFormatter: function (e) {
			        var content = "";
			        for (var i = 0; i < e.entries.length; i++) {
			            var dataPoint = e.entries[i].dataPoint;
			            var wellName = e.entries[i].dataPoint.label;
			            var hours = Math.floor(dataPoint.y / 60);
			            var minutes = dataPoint.y % 60;
			            // content += "<strong>" + e.entries[i].dataSeries.name + "</strong> (" + wellName + "): " + hours + " hours " + minutes + " minutes<br/>";

			            
			            // --------------------------
			            if(hours < 0)
			            {
			            	var hours = Math.floor(Math.abs(dataPoint.y) / 60);
			            	var minutes = Math.abs(dataPoint.y) % 60;
			            	content += "<strong>" + e.entries[i].dataSeries.name + "</strong> (" + wellName + "): Extra " + hours + " hours " + minutes + " minutes<br/>";
			            }else{
			            	content += "<strong>" + e.entries[i].dataSeries.name + "</strong> (" + wellName + "): " + hours + " hours " + minutes + " minutes<br/>";
			            }
			            // ----------------------------
			            
			        }
			        return content;
			    }
                },
                legend: {
                    cursor: "pointer",
                    itemclick: toggleDataSeries,
                    labelFontSize: 12
                },
                data: [{
                        type: "spline",
                        name: "Running (Minutes)",
                        dataPoints: t_minutes_data,
                        labelFontSize: 15,
                        titleFontSize: 15
                    },
                    {
                        type: "spline",
                        name: "Shut Down (Minutes)",
                        dataPoints: shut_down_data,
                        labelFontSize: 15,
                        titleFontSize: 15
                    }
                ]
            });

            chart.render();

            function toggleDataSeries(e) {
                if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                    e.dataSeries.visible = false;
                } else {
                    e.dataSeries.visible = true;
                }
                chart.render();
            }
        } else if (graph_type == 4) {
            var availability_data = [];

            for (var i = 0; i <  data_points.well_performance.length; i++) {
                var dataPoint = {
                    label:  data_points.well_performance[i].x,
                    y: parseFloat( data_points.well_performance[i].y)
                };
                availability_data.push(dataPoint);
            }
            selected_field_2.textContent = headingText7;

            chart = new CanvasJS.Chart("Fin_Line_graph", {
            	width: 950, 
                height: 950,
                animationEnabled: true,
                title: {
                    // text: "Well Performance Graph",
                    // fontSize: 23
                },
                axisX: {
                    // title: "Well Performance",
                    titleFontColor: "#4F81BC",
                    lineColor: "#4F81BC",
                    labelFontColor: "#4F81BC",
                    tickColor: "#4F81BC",
                    labelFontSize: 15,
                    titleFontSize: 15
                },
                axisY: {
	            title: "Availability (%)", // Include the percentage sign here
	            titleFontColor: "#4F81BC",
	            lineColor: "#4F81BC",
	            labelFontColor: "#4F81BC",
	            tickColor: "#4F81BC",
	            labelFontSize: 15,
	            titleFontSize: 15,
	            labelFormatter: function (e) {
	                return e.value + "%";
	            }
	        },

                toolTip: {
                    shared: true,
                    labelFontSize: 12
                },
                legend: {
                    cursor: "pointer",
                    itemclick: toggleDataSeries,
                    labelFontSize: 12
                },
                data: [{
                    type: "spline",
                    name: "Availability %",
	                // legendText: "Availability",
                    // showInLegend: true,
                    dataPoints: availability_data,
                    labelFontSize: 15,
                    titleFontSize: 15
                }]
            });

            chart.render();


            function toggleDataSeries(e) {
                if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                    e.dataSeries.visible = false;
                } else {
                    e.dataSeries.visible = true;
                }
                chart.render();
            }
        }
    }

get_Month_year_Line_graph_data();
    function get_Month_year_Line_graph_data(){
        var site_id = $('#site_id_month_Line').val();
        var well_id = $('#well_line').val();
        var year = $('#year_line').val();
        var month_id = $('#month_line').val();
        var graph_type = $('#graph_type_3').val();
        var well_name = $('#well_line option:selected').text();

        $.ajax({
            url: '<?php echo base_url(); ?>Running_Log_Graph_report_c/get_monthly_running_log_Line_graph_data',
            type: 'POST',
            data: {
            	site_id:site_id,
                well_id: well_id,
                year: year,
                month_id:month_id,
                graph_type: graph_type
            },
            success: function (res) {
                var res = JSON.parse(res);
                var headingText12 = "Running Log Graph: " + well_name;
                var headingText13 = "Energy Consumption Graph: " + well_name;
                var headingText14 = "Running and Shut Down Hours Graph: " + well_name;
                var headingText15 = "Well Performance Graph: " + well_name;

                get_Month_Line_graph_chart(res.data,graph_type,headingText12,headingText13,headingText14,headingText15);
            }

        });
    }

    function get_Month_Line_graph_chart(data_points, graph_type,headingText12,headingText13,headingText14,headingText15) {
    var selected_field_3 = document.getElementById("selected_field_3");
    var chart;

	if (graph_type == 1) {
    var t_minutes_data = [];

    for (var i = 0; i < data_points.length; i++) {
        var totalHours = parseFloat(data_points[i].y); // Assuming data_points[i].y represents total hours

        var hours = Math.floor(totalHours);
        var minutes = Math.round((totalHours - hours) * 60);

        var formattedTime = hours + " hours " + minutes + " minutes";

        var dataPoint = {
            label: data_points[i].x, // Assuming data_points[i].x represents well names
            y: totalHours // Use the total hours for the y-axis
        };

        t_minutes_data.push(dataPoint);
    }

	    var t_minutes_data = [];

		var colors = ["red", "blue", "green", "orange", "purple"]; 
		for (var i = 0; i < data_points.length; i++) {
		    var totalHours = parseFloat(data_points[i].y);

		    var hours = Math.floor(totalHours);
		    var minutes = Math.round((totalHours - hours) * 60);

		    var formattedTime = hours + " hours " + minutes + " minutes";

		    var colorIndex = i % colors.length;
		    var dataPoint = {
		        label: data_points[i].x,
		        y: totalHours, 
		        color: colors[colorIndex]
		    };

		    t_minutes_data.push(dataPoint);
		}
		selected_field_3.textContent = headingText12;

		chart = new CanvasJS.Chart("month_Line_graph", {
			width: 950, 
            height: 950,
		    animationEnabled: true,
		    exportEnabled: true,
		    title: {
		        // text: "Running Log Graph",
		        // fontSize: 23
		    },
		    axisY: [{
		        title: "Running (Hours)",
		        titleFontColor: "#4F81BC",
		        lineColor: "#4F81BC",
		        labelFontColor: "#4F81BC",
		        tickColor: "#4F81BC",
		        labelFontSize: 15,
		        titleFontSize: 15,
		        labelFormatter: function (e) {
		            var hours = Math.floor(e.value / 60);
		            var minutes = e.value % 60;
		            return hours + " hours " + minutes + " minutes";
		        }
		    }],
		    axisX: [{
		        titleFontColor: "#4F81BC",
		        lineColor: "#4F81BC",
		        labelFontColor: "#4F81BC",
		        tickColor: "#4F81BC",
		        labelFontSize: 15,
		        titleFontSize: 15
		    }],
		    toolTip: {
		    shared: true,
		    fontSize: 12,
		    contentFormatter: function (e) {
		        var content = "";
		        for (var i = 0; i < e.entries.length; i++) {
		            var totalMinutes = e.entries[i].dataPoint.y;
		            var hours = Math.floor(totalMinutes / 60);
		            var minutes = totalMinutes % 60;
                            content += "<strong>" + e.entries[i].dataPoint.label + " (Running Hours):</strong> " + hours + " hours " + minutes + " minutes<br/>";
		        }
		        return content;
		    }
		},
		    legend: {
		        cursor: "pointer",
		        itemclick: toggleDataSeries,
		        fontSize: 8
		    },
		    data: [{
		        type: "spline",
		        // showInLegend: true,
		        // name: "Running (Hours)",
		        // legendText: "Running (Hours)",
		        labelFontSize: 15,
		        titleFontSize: 15,
		        dataPoints: t_minutes_data
		    }]
		});

		chart.render();

		function toggleDataSeries(e) {
		    if(typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		        e.dataSeries.visible = false;
		    }
		    else {
		        e.dataSeries.visible = true;            
		    }
		    chart.render();
		}
        } else if (graph_type == 2) {
           var e_consumption_data = [];

			for (var i = 0; i < data_points.length; i++) {
			    var dataPoint = {
			        label: data_points[i].x,
			        y: parseFloat(data_points[i].y)
			    };
			    e_consumption_data.push(dataPoint);
			}
            selected_field_3.textContent = headingText13;
			chart = new CanvasJS.Chart("month_Line_graph", {
				width: 950, 
                height: 950,
			    animationEnabled: true,
			    exportEnabled: true,
			    title: {
			        // text: "Energy Consumption Graph",
			        // fontSize: 23
			    },
			    axisY: [{
			        title: "Energy in Kwh",
			        titleFontColor: "#4F81BC",
			        lineColor: "#4F81BC",
			        labelFontColor: "#4F81BC",
			        tickColor: "#4F81BC",
			        labelFontSize: 15,
			        titleFontSize: 15
			    }],
			    axisX: [{
			        titleFontColor: "#4F81BC",
			        lineColor: "#4F81BC",
			        labelFontColor: "#4F81BC",
			        tickColor: "#4F81BC",
			        labelFontSize: 15,
			        titleFontSize: 15
			    }],
			    toolTip: {
			        shared: true,
			        labelFontSize: 12
			    },
			    legend: {
			        cursor: "pointer",
			        itemclick: toggleDataSeries,
			        labelFontSize: 8
			    },
			    data: [{
			        type: "spline",
			        // showInLegend: true,
			        name: "E_Consumption (Kwh)",
			        // legendText: "E_Consumption (Kwh)",
			        labelFontSize: 15,
			        dataPoints: e_consumption_data
			    }]
			});

			chart.render();
            function toggleDataSeries(e) {
                if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                    e.dataSeries.visible = false;
                } else {
                    e.dataSeries.visible = true;
                }
                chart.render();
            }
        } else if (graph_type == 3) {

			var t_minutes_data = [];
			var shut_down_data = [];

			for (var i = 0; i < data_points.running_shutdown.running_minutes.length; i++) {
			    // Processing running time
			    var running_minutes = parseFloat(data_points.running_shutdown.running_minutes[i].y);
			    var running_hours = Math.floor(running_minutes / 60);
			    var running_remaining_minutes = running_minutes % 60;
			    var running_formatted_time = running_hours + "h " + running_remaining_minutes + "m"; // Format: hours 'h' minutes 'm'
			    var running_point = {
			        y: running_minutes,
			        label: data_points.running_shutdown.running_minutes[i].x
			    };
			    t_minutes_data.push(running_point);

			    // Processing shutdown time
			    var shut_down_minutes = parseFloat(data_points.running_shutdown.shutdown_minutes[i].y);
			    var shut_down_hours = Math.floor(shut_down_minutes / 60);
			    var shut_down_remaining_minutes = shut_down_minutes % 60;
			    var shut_down_formatted_time = shut_down_hours + "h " + shut_down_remaining_minutes + "m";
			    var shut_down_point = {
			        y: shut_down_minutes,
			        label: data_points.running_shutdown.shutdown_minutes[i].x
			    };
			    shut_down_data.push(shut_down_point);
			}
			selected_field_3.textContent = headingText14;
            chart = new CanvasJS.Chart("month_Line_graph", {
            	width: 950, 
                height: 950,
                animationEnabled: true,
                title: {
                    // text: "Running and Shut Down Hours Graph",
                    // fontSize: 23
                },
                axisX: [{
                    // title: "Minutes", // X-axis title
                    titleFontColor: "#CB4335",
                    lineColor: "#CB4335",
                    labelFontColor: "#CB4335",
                    tickColor: "#CB4335",
                    reversed: true,
                    labelFontSize: 15,
                    titleFontSize: 15
                }],
                axisY: {
                    title: "Hours", // Y-axis title
                    titleFontColor: "#4F81BC",
                    lineColor: "#4F81BC",
                    labelFontColor: "#4F81BC",
                    tickColor: "#4F81BC",
                    labelFontSize: 15,
                    titleFontSize: 15,
                    labelFormatter: function (e) {
                        var hours = Math.floor(e.value / 60);
                        var minutes = e.value % 60;
                        return hours + " hours " + minutes + " minutes";
                    }
                },
                toolTip: {
                    shared: true,
                    labelFontSize: 12,
                    contentFormatter: function (e) {
			        var content = "";
			        for (var i = 0; i < e.entries.length; i++) {
			            var dataPoint = e.entries[i].dataPoint;
			            var wellName = e.entries[i].dataPoint.label;
			            var hours = Math.floor(dataPoint.y / 60);
			            var minutes = dataPoint.y % 60;
			            // content += "<strong>" + e.entries[i].dataSeries.name + "</strong> (" + wellName + "): " + hours + " hours " + minutes + " minutes<br/>";

			            // --------------------------
			            if(hours < 0)
			            {
			            	var hours = Math.floor(Math.abs(dataPoint.y) / 60);
			            	var minutes = Math.abs(dataPoint.y) % 60;
			            	content += "<strong>" + e.entries[i].dataSeries.name + "</strong> (" + wellName + "): Extra " + hours + " hours " + minutes + " minutes<br/>";
			            }else{
			            	content += "<strong>" + e.entries[i].dataSeries.name + "</strong> (" + wellName + "): " + hours + " hours " + minutes + " minutes<br/>";
			            }
			            // ----------------------------
			        }
			        return content;
			    }
                },
                legend: {
                    cursor: "pointer",
                    itemclick: toggleDataSeries,
                    labelFontSize: 12
                },
                data: [{
                        type: "spline",
                        name: "Running (Minutes)",
                        dataPoints: t_minutes_data,
                        labelFontSize: 15,
                        titleFontSize: 15
                    },
                    {
                        type: "spline",
                        name: "Shut Down (Minutes)",
                        dataPoints: shut_down_data,
                        labelFontSize: 15,
                        titleFontSize: 15
                    }
                ]
            });

            chart.render();

            function toggleDataSeries(e) {
                if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                    e.dataSeries.visible = false;
                } else {
                    e.dataSeries.visible = true;
                }
                chart.render();
            }

        } else if (graph_type == 4) {
            var availability_data = [];

            for (var i = 0; i <  data_points.well_performance.length; i++) {
                var dataPoint = {
                    label:  data_points.well_performance[i].x,
                    y: parseFloat( data_points.well_performance[i].y)
                };
                availability_data.push(dataPoint);
            }
            selected_field_3.textContent = headingText15;

            chart = new CanvasJS.Chart("month_Line_graph", {
            	width: 950, 
                height: 950,
                animationEnabled: true,
                title: {
                    // text: "Well Performance Graph",
                    // fontSize: 23
                },
                axisX: {
                    // title: "Well Performance",
                    titleFontColor: "#4F81BC",
                    lineColor: "#4F81BC",
                    labelFontColor: "#4F81BC",
                    tickColor: "#4F81BC",
                    labelFontSize: 15,
                    titleFontSize: 15
                },
                axisY: {
	            title: "Availability (%)", // Include the percentage sign here
	            titleFontColor: "#4F81BC",
	            lineColor: "#4F81BC",
	            labelFontColor: "#4F81BC",
	            tickColor: "#4F81BC",
	            labelFontSize: 15,
	            titleFontSize: 15,
	            labelFormatter: function (e) {
	                return e.value + "%";
	            }
	        },

                toolTip: {
                    shared: true,
                    labelFontSize: 12
                },
                legend: {
                    cursor: "pointer",
                    itemclick: toggleDataSeries,
                    labelFontSize: 12
                },
                data: [{
                    type: "spline",
                    name: "Availability %",
	                // legendText: "Availability",
                    // showInLegend: true,
                    dataPoints: availability_data,
                    labelFontSize: 15,
                    titleFontSize: 15
                }]
            });

            chart.render();


            function toggleDataSeries(e) {
                if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                    e.dataSeries.visible = false;
                } else {
                    e.dataSeries.visible = true;
                }
                chart.render();
            }
        }
    }
</script>
