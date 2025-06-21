<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
<div class="page-wrapper">
<!-- Page Content -->
    <div class="content container-fluid">
    	<!-- Page Header -->
			<div class="page-header">
				<div class="row">
					<div class="col-sm-12">
						<h3 class="page-title">Comparison  Graphs</h3>
						<ul class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard_c');?>">Dashboard</a></li>
							<li class="breadcrumb-item ">Comparison  Graphs</li>
							
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
                        <h3><b>Comparison  Graphs</b></h3>
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

						<div class="form-group">
		                    <div class="row">
                                 <div class="form-group col-md-3 mt-2" >
                                 	<h5><b>View Report </b></h5>
                                 	
										<select name="report_view" id="report_view" class="form-control select2" onchange="get_view();get_monthly_running_graph_data();">
											<?php
											$user_type = $this->session->userdata('user_type', true);
											$role_type = $this->session->userdata('role_type', true);
											if ($user_type == 3 && $role_type == 2){
											    ?>
											    <option value="">Select Report</option>
											    <option value="area">Area Wise</option>
											    <option value="well">Well Wise</option>
											    <?php
											} else {
											    ?>
											    <option value="">Select Report</option>
											    <option value="assets">Assets Wise</option>
											    <option value="area">Area Wise</option>
											    <option value="well">Well Wise</option>
											    <?php
											}
											?>
									</select>
                                 </div>

			                    <div class="form-group col-md-3 mt-2" id="assets_view" style="display:none">
			                        <h5><b>Area Name</b></h5>
			                        <select name="site_id" id="site_id" class="form-control select2" onchange="get_monthly_running_graph_data();get_well_list();">
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

						        <div class="form-group col-md-3 mt-2" id="well_view" style="display:none">
									<h5><b>Well</b></h5>
									<select name="well_id" id="well_id" class="form-control select2" onchange="get_monthly_running_graph_data();">
										<option value="">Select Well </option>

									</select>
								</div>
								<div class="form-group col-md-3 mt-2" id="month_view" style="display:none">
									<h5><b>Month</b></h5>
									<select class="form-control select2" name="month" id="month" onchange="get_monthly_running_graph_data();">
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
								<div class="form-group col-md-3 mt-2" id="year_view" style="display:none">
									<h5><b>Year</b></h5>
	                                <select class="form-control select2" name="year" id="year" onchange="get_monthly_running_graph_data();">
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
						    </div>
			            </div>
			        </div>
			    </div>
			</div>

       
          <div class="card" style="display: none;" id="extra_card">
        	<div class="card-body">
        	<div class="row">
	        <div class="col-md-12" id="well_wise" style="display:none">
	        <div class="card-header d-flex justify-content-between align-items-center" style="background-color:#31C4C4; height: 50px;">
	            <span style="font-weight: bold; font-size: 18px; color: white;">
	                <img src="<?php echo base_url() ?>assets/img/line-chart.gif" width="30" style="border-radius: 25%; vertical-align: middle; margin-right: 10px;">
	               <span id="selected_field_well"></span>
	            </span>
	            <div class="d-flex justify-content-end align-items-end mt-n2">
	                <div class="form-group" style="margin-right: 10px;">
	                    <select name="graph_well" id="graph_well" class="form-control select2" style="min-width: 200px !important; text-align: left;" onchange="get_monthly_running_graph_data();">
	                        <option value="1">Running Hours</option>
	                        <option value="2">Energy Consumption</option>
	                        <option value="3">Running Hours  and Schedule Hours </option>
	                      
	                    </select>
	                </div>
	            </div>
	        </div>
	    </div>

	    <div class="col-md-12" id="area_wise" style="display:none">
	        <div class="card-header d-flex justify-content-between align-items-center" style="background-color:#31C4C4; height: 50px;">
	            <span style="font-weight: bold; font-size: 18px; color: white;">
	                <img src="<?php echo base_url() ?>assets/img/line-chart.gif" width="30" style="border-radius: 25%; vertical-align: middle; margin-right: 10px;">
	               <span id="selected_field_area"></span>
	            </span>
	            <div class="d-flex justify-content-end align-items-end mt-n2">
	                <div class="form-group" style="margin-right: 10px;">
	                    <select name="graph_area" id="graph_area" class="form-control select2" style="min-width: 200px !important; text-align: left;" onchange="get_monthly_running_graph_data();">
	                        <option value="4">Running Hours</option>
	                        <option value="5">Energy Consumption</option>
	                        <option value="6">Running Hours  and Schedule Hours </option>
	                      
	                    </select>
	                </div>
	            </div>
	        </div>
	    </div>
	
	        
	      	<div class="col-md-12 mt-4" id="assets_wise" style="display:none">
             <div class="card-body">
	         <div class="card-header d-flex justify-content-between align-items-center" style="background-color:blueviolet; height: 50px;">
	            <span style="font-weight: bold; font-size: 18px; color: white;">
	                <img src="<?php echo base_url() ?>assets/img/line-chart.gif" width="30" style="border-radius: 25%; vertical-align: middle; margin-right: 10px;">
	               <span id="selected_field_assets"></span>
	            </span>
	            <div class="d-flex justify-content-end align-items-end mt-n2">
	                <div class="form-group" style="margin-right: 10px;">
	                    <select name="graph_assets" id="graph_assets" class="form-control select2" style="min-width: 200px !important; text-align: left;" onchange="get_monthly_running_graph_data();">
	                        <option value="7">Running Hours</option>
	                        <option value="8">Energy Consumption</option>
	                        <option value="9">Running Hours  and Schedule Hours </option>
	                      
	                    </select>
	                </div>
	            </div>

	        </div>
	    </div>
	</div>
	

   
	    <div class="col-md-12 mt-4" id ='graph_area'>

	        <div class="card-body" style="overflow-x: scroll;">
	        	<div id="processing_message">
                  <img src="<?php echo base_url(); ?>assets/loader_img.svg" class="loader-img " alt="Loader" style="height:200px;width:100px;align-items: center;">
                  </div>
	            <div id="bargraph" style="height: 900px;font-size: -5px;"></div>
	        </div>
	   
	    </div>
     </div>
    </div>
    </div>
   </div>
  </div>
</div>
</div>



<script type="text/javascript">

get_well_list();
function get_well_list() { 
    let company_id = "<?php echo $this->session->userdata('company_id') ?>";
    let site_id = $('#site_id').val();
  
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url();?>Running_log_c/Well_list',
        data: { company_id: company_id, site_id: site_id},
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
	function get_view()
	{
		var value = $('#report_view').val();

		if (value == 'assets')
		{
            $('#assets_view').show();
            $('#month_view').show();
            $('#year_view').show();
            $('#assets_wise').show();
            $('#graph_area').show();
            $('#extra_card').show();
            $('#bargraph').html('');
            $('#area_wise').hide();
            $('#well_wise').hide();
		}else if(value == 'area')
		{
            $('#well_view').show();
			$('#assets_view').show();
			$('#month_view').show();
            $('#year_view').show();
            $('#well_view').val('').change();
            $('#assets_view').val('').change();
            $('#bargraph').html('');
            $('#assets_wise').hide();
            $('#area_wise').show();
            $('#graph_area').show();
            $('#extra_card').show();
            $('#well_wise').hide();
		}else if(value == 'well')
		{
            $('#well_view').show();
			$('#assets_view').show();
			$('#month_view').show();
            $('#year_view').show();
            $('#well_view').val('').change();
            $('#assets_view').val('').change();
            $('#bargraph').html('');
            $('#assets_wise').hide();
            $('#area_wise').hide();
            $('#well_wise').show();
            $('#graph_area').show();
            $('#extra_card').show();
		}else{
            $('#well_view').hide();
			$('#assets_view').hide();
			$('#month_view').hide();
            $('#year_view').hide();
            $('#area_wise').hide();
            $('#assets_wise').hide();
            $('#graph_area').hide();
            $('#extra_card').hide();
            $('#well_wise').hide();
			
		}
	}
</script>


<script type="text/javascript">
	get_monthly_running_graph_data();
	function get_monthly_running_graph_data()
	{
	    var site_id =  $('#site_id').val();
	    var well_id = $('#well_id').val();
	    var month = $('#month').val();
	    var year = $('#year').val();

	    var value = $('#report_view').val();
	 
	    if(value == 'assets'){
	    	var graph_type =$('#graph_assets').val();
	    }else if(value == 'area'){
	    	var graph_type = $('#graph_area').val();
	    }else if(value == 'well'){
	    	var graph_type = $('#graph_well').val();
	    }
	  
	    
	    var well_name = $('#well_id option:selected').text();
	    if(value == 'assets')
	    {
	       var selected_field_assets = document.getElementById("selected_field_assets");
	    }else if(value == 'area'){
	       var selected_field_area = document.getElementById("selected_field_area");
	    }else if(value == 'well'){
	    	  var selected_field_well = document.getElementById("selected_field_well");
	    } 
	 
	    document.getElementById("processing_message").style.display = "block";

	      function getMonthName(monthNumber) {
                const monthNames = ["January", "February", "March", "April", "May", "June", 
                                    "July", "August", "September", "October", "November", "December"];
                return monthNames[monthNumber - 1];
            }

            var currentMonthName = getMonthName(parseInt(month));
            var previousMonthNumber = month - 1;
            var previousMonthName = previousMonthNumber > 0 ? getMonthName(previousMonthNumber) : getMonthName(12);
            var monthNameDisplay = previousMonthName + " - " + currentMonthName;

          

	    $.ajax({
	        url: '<?php echo base_url(); ?>Comparison_data_c/get_comparisn_running_log_graph_data',
	        type: 'POST',
	        data: {
	        	site_id:site_id,
	            well_id: well_id,
	            month: month,
	            year: year,
	            graph_type: graph_type
	        },
	        success: function (res) {
	        	var res = JSON.parse(res);
	        	document.getElementById("processing_message").style.display = "none";
	        	var headingText1 = `Well wise Comparison Running Graph ${monthNameDisplay} `;
                var headingText2 = `Well wise Comparison Energy Consumption Graph ${monthNameDisplay} `;
                var headingText3 = `Well wise Comparison Running and Schdule Graph ${monthNameDisplay} `;
                var headingText4 = `Area wise Comparison Running Graph ${monthNameDisplay} `;
                var headingText5 = `Area wise Comparison Energy Consumption Graph ${monthNameDisplay} `;
                var headingText6 = `Area wise Comparison Running and Schdule Graph ${monthNameDisplay} `;

                var headingText7 = `Assets Wise Comparison Graph ${monthNameDisplay} Running Hours`;
                var headingText8 = `Assets Wise Comparison Graph  ${monthNameDisplay} Energy Consumption`;
                var headingText9 = `Assets Wise Comparison Graph  ${monthNameDisplay} Running and Schdule Hours`;
                
	            get_bar_graph_chart(res.data, graph_type,headingText1,headingText2,headingText3,headingText4,headingText5,headingText6,headingText7,headingText8,headingText9);
	        }

	    });
	}

	function get_bar_graph_chart(data_points, graph_type,headingText1,headingText2,headingText3,headingText4,headingText5,headingText6,headingText7,headingText8,headingText9)
	{
		
	    var chart;
	    if (graph_type == 1) 
	    {
	    	
	    	$('#bargraph').html('');
	    	document.getElementById("processing_message").style.display = "block";
	        var t_minutes_data = [];
	        var p_minutes_data = [];

	        for (var i = 0; i < data_points.length; i++) {
	            var totalMinutes = parseFloat(data_points[i].y);

	            var hours = Math.floor(totalMinutes / 60);
	            var minutes = totalMinutes % 60;

	            // Construct the formatted time string
	            var formattedTime = hours + " hours " + minutes + " minutes";

	            var dataPoint = {
	                label: data_points[i].x,
	                y: totalMinutes 
	            };

	            t_minutes_data.push(dataPoint);

	            var previous_minutes = parseFloat(data_points[i].z);
                var previous_hours = Math.floor(previous_minutes / 60);
                var previous_remaining_minutes = previous_minutes % 60;
                var previous_formatted_time = previous_hours + "h " + previous_remaining_minutes + "m";

                var previous_point = {
                    y: previous_minutes, 
                    label: data_points[i].x 
                };
                p_minutes_data.push(previous_point);
	        }
            selected_field_well.textContent = headingText1;
	        chart = new CanvasJS.Chart("bargraph", {
	        	width: 2500, 
                 height: 900,
	            animationEnabled: true,
	            title: {
	              
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
			             content += "<strong>" + e.entries[i].dataSeries.name + "</strong> " + hours + " hours " + minutes + " minutes<br/>";
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
	                type: "column",
	                name: "Running (Hours)",
	                legendText: "Running (Hours)",
	                dataPoints: t_minutes_data
                   },
	                {
                        type: "column",
                        name: "Running (Hours)",
                        legendText: "Running (Hours)",
                        dataPoints: p_minutes_data,
                       
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
	          document.getElementById("processing_message").style.display = "none";
	    }
	    
		else if(graph_type ==2)
		{
			$('#bargraph').html('');
			document.getElementById("processing_message").style.display = "block";
			 var energy_data = [];
			 var previous_energy_data = [];


		        for (var i = 0; i < data_points.length; i++) {
		            var totalkwh = parseFloat(data_points[i].y);
		            var dataPoint = {
		                label: data_points[i].x,
		                y: totalkwh 
		            };

		            energy_data.push(dataPoint);

		         var totalkwh = parseFloat(data_points[i].z);

                var previous_point = {
                    y: totalkwh, 
                    label: data_points[i].x 
                 };
                  previous_energy_data.push(previous_point);
		        }

	            selected_field_well.textContent = headingText2;
		        chart = new CanvasJS.Chart("bargraph", {
		        	width: 3000, 
	                 height: 900,
		            animationEnabled: true,
		            title: {
		                
		            },
		            axisY: [{
		                title: "E Consumption (Kwh)",
		                titleFontColor: "#4F81BC",
		                lineColor: "#4F81BC",
		                labelFontColor: "#4F81BC",
		                tickColor: "#4F81BC",
		                labelFontSize: 15,
		                titleFontSize: 15,
		                
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
		                
					
		            },
		            legend: {
		                cursor: "pointer",
		                itemclick: toggleDataSeries,
		                fontSize: 8
		            },
		            data: [{
		                type: "column",
		                name: "E Consumption (Kwh)",
		                legendText: "E Consumption (Kwh)",
		                dataPoints: energy_data
                        },
                        {
                          type: "column",
		                  name: "E Consumption (Kwh)",
		                  legendText: "E Consumption (Kwh)",
		                  dataPoints: previous_energy_data

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
		      document.getElementById("processing_message").style.display = "none";
		}
		else if (graph_type == 3) 
	    {
	    	
	    	$('#bargraph').html('');
	    	document.getElementById("processing_message").style.display = "block";
	        var t_minutes_data = [];
	        var schdule_minutes_data = [];

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

	            var shut_down_minutes = parseFloat(data_points[i].z);
                var shut_down_hours = Math.floor(shut_down_minutes / 60);
                var shut_down_remaining_minutes = shut_down_minutes % 60;
                var shut_down_formatted_time = shut_down_hours + "h " + shut_down_remaining_minutes + "m";

                var shut_down_point = {
                    y: shut_down_minutes, 
                    label: data_points[i].x 
                };
                schdule_minutes_data.push(shut_down_point);
	        }
            selected_field_well.textContent = headingText3;
	        chart = new CanvasJS.Chart("bargraph", {
	        	width: 2500, 
                 height: 900,
	            animationEnabled: true,
	            title: {
	                // text: "Running Log Graph",
	                // fontSize: 23
	            },
	            axisY: [{
	               title: "Hours and Minutes",
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
			            minutes = parseFloat(minutes).toFixed(2); // Limiting minutes to two 
			           content += "<strong>" + e.entries[i].dataSeries.name + "</strong> " + hours + " hours " + minutes + " minutes<br/>";

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
	                type: "column",
	                name: "Running (Hours)",
	                legendText: "Running (Hours)",
	                dataPoints: t_minutes_data
                    },
	                {
                        type: "column",
                        name: "Schdule (Hours)",
                        legendText: "Schdule (Hours)",
                        dataPoints: schdule_minutes_data,
                       
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
	          document.getElementById("processing_message").style.display = "none";
	    }else if (graph_type == 4) 
	    {
	    	
	    	$('#bargraph').html('');
	    	document.getElementById("processing_message").style.display = "block";
	        var t_minutes_data = [];
	        var p_minutes_data = [];

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

	            var previous_minutes = parseFloat(data_points[i].z);
                var previous_hours = Math.floor(previous_minutes / 60);
                var previous_remaining_minutes = previous_minutes % 60;
                var previous_formatted_time = previous_hours + "h " + previous_remaining_minutes + "m";

                var previous_point = {
                    y: previous_minutes, 
                    label: data_points[i].x 
                };
                p_minutes_data.push(previous_point);
	        }
            selected_field_area.textContent = headingText4;
	        chart = new CanvasJS.Chart("bargraph", {
	        	width: 1500, 
                 height: 900,
	            animationEnabled: true,
	            title: {
	              
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
			             content += "<strong>" + e.entries[i].dataSeries.name + "</strong> " + hours + " hours " + minutes + " minutes<br/>";
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
	                type: "column",
	                name: "Running (Hours)",
	                legendText: "Running (Hours)",
	                dataPoints: t_minutes_data
                   },
	                {
                        type: "column",
                        name: "Running (Hours)",
                        legendText: "Running (Hours)",
                        dataPoints: p_minutes_data,
                       
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
	          document.getElementById("processing_message").style.display = "none";
	    }else if(graph_type ==5)
		{
			$('#bargraph').html('');
			document.getElementById("processing_message").style.display = "block";
			 var energy_data = [];
			 var previous_energy_data = [];


		        for (var i = 0; i < data_points.length; i++) {
		            var totalkwh = parseFloat(data_points[i].y);
		            var dataPoint = {
		                label: data_points[i].x,
		                y: totalkwh 
		            };

		            energy_data.push(dataPoint);

		         var totalkwh = parseFloat(data_points[i].z);

                var previous_point = {
                    y: totalkwh, 
                    label: data_points[i].x 
                 };
                  previous_energy_data.push(previous_point);
		        }

	            selected_field_assets.textContent = headingText5;
		        chart = new CanvasJS.Chart("bargraph", {
		        	width: 3000, 
	                 height: 900,
		            animationEnabled: true,
		            title: {
		                
		            },
		            axisY: [{
		                title: "E Consumption (Kwh)",
		                titleFontColor: "#4F81BC",
		                lineColor: "#4F81BC",
		                labelFontColor: "#4F81BC",
		                tickColor: "#4F81BC",
		                labelFontSize: 15,
		                titleFontSize: 15,
		                
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
		                
					
		            },
		            legend: {
		                cursor: "pointer",
		                itemclick: toggleDataSeries,
		                fontSize: 8
		            },
		            data: [{
		                type: "column",
		                name: "E Consumption (Kwh)",
		                legendText: "E Consumption (Kwh)",
		                dataPoints: energy_data
                        },
                        {
                          type: "column",
		                  name: "E Consumption (Kwh)",
		                  legendText: "E Consumption (Kwh)",
		                  dataPoints: previous_energy_data

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
		      document.getElementById("processing_message").style.display = "none";
		}else if (graph_type == 6) 
	    {
	    
	    	$('#bargraph').html('');
	    	document.getElementById("processing_message").style.display = "block";
	        var t_minutes_data = [];
	        var schdule_minutes_data = [];

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

	            var shut_down_minutes = parseFloat(data_points[i].z);
                var shut_down_hours = Math.floor(shut_down_minutes / 60);
                var shut_down_remaining_minutes = shut_down_minutes % 60;
                var shut_down_formatted_time = shut_down_hours + "h " + shut_down_remaining_minutes + "m";

                var shut_down_point = {
                    y: shut_down_minutes, 
                    label: data_points[i].x 
                };
                schdule_minutes_data.push(shut_down_point);
	        }
            selected_field_area.textContent = headingText6;
	        chart = new CanvasJS.Chart("bargraph", {
	        	width: 2500, 
                 height: 900,
	            animationEnabled: true,
	            title: {
	                // text: "Running Log Graph",
	                // fontSize: 23
	            },
	            axisY: [{
	               title: "Hours and Minutes",
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
			            minutes = parseFloat(minutes).toFixed(2); // Limiting minutes to two 
			           content += "<strong>" + e.entries[i].dataSeries.name + "</strong> " + hours + " hours " + minutes + " minutes<br/>";

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
	                type: "column",
	                name: "Running (Hours)",
	                legendText: "Running (Hours)",
	                dataPoints: t_minutes_data
                    },
	                {
                        type: "column",
                        name: "Schdule (Hours)",
                        legendText: "Schdule (Hours)",
                        dataPoints: schdule_minutes_data,
                       
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
	          document.getElementById("processing_message").style.display = "none";
	    }else if (graph_type == 7) 
	    {
	    	
	    	$('#bargraph').html('');
	    	document.getElementById("processing_message").style.display = "block";
	        var t_minutes_data = [];
	        var p_minutes_data = [];

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

	            var previous_minutes = parseFloat(data_points[i].z);
                var previous_hours = Math.floor(previous_minutes / 60);
                var previous_remaining_minutes = previous_minutes % 60;
                var previous_formatted_time = previous_hours + "h " + previous_remaining_minutes + "m";

                var previous_point = {
                    y: previous_minutes, 
                    label: data_points[i].x 
                };
                p_minutes_data.push(previous_point);
	        }
            selected_field_assets.textContent = headingText7;
	        chart = new CanvasJS.Chart("bargraph", {
	        	width: 1500, 
                 height: 900,
	            animationEnabled: true,
	            title: {
	              
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
			             content += "<strong>" + e.entries[i].dataSeries.name + "</strong> " + hours + " hours " + minutes + " minutes<br/>";
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
	                type: "column",
	                name: "Running (Hours)",
	                legendText: "Running (Hours)",
	                dataPoints: t_minutes_data
                   },
	                {
                        type: "column",
                        name: "Running (Hours)",
                        legendText: "Running (Hours)",
                        dataPoints: p_minutes_data,
                       
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
	          document.getElementById("processing_message").style.display = "none";
	    }else if(graph_type ==8)
		{
			$('#bargraph').html('');
			document.getElementById("processing_message").style.display = "block";
			 var energy_data = [];
			 var previous_energy_data = [];


		        for (var i = 0; i < data_points.length; i++) {
		            var totalkwh = parseFloat(data_points[i].y);
		            var dataPoint = {
		                label: data_points[i].x,
		                y: totalkwh 
		            };

		            energy_data.push(dataPoint);

		         var totalkwh = parseFloat(data_points[i].z);

                var previous_point = {
                    y: totalkwh, 
                    label: data_points[i].x 
                 };
                  previous_energy_data.push(previous_point);
		        }

	            selected_field_assets.textContent = headingText8;
		        chart = new CanvasJS.Chart("bargraph", {
		        	width: 3000, 
	                 height: 900,
		            animationEnabled: true,
		            title: {
		                
		            },
		            axisY: [{
		                title: "E Consumption (Kwh)",
		                titleFontColor: "#4F81BC",
		                lineColor: "#4F81BC",
		                labelFontColor: "#4F81BC",
		                tickColor: "#4F81BC",
		                labelFontSize: 15,
		                titleFontSize: 15,
		                
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
		                
					
		            },
		            legend: {
		                cursor: "pointer",
		                itemclick: toggleDataSeries,
		                fontSize: 8
		            },
		            data: [{
		                type: "column",
		                name: "E Consumption (Kwh)",
		                legendText: "E Consumption (Kwh)",
		                dataPoints: energy_data
                        },
                        {
                          type: "column",
		                  name: "E Consumption (Kwh)",
		                  legendText: "E Consumption (Kwh)",
		                  dataPoints: previous_energy_data

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
		      document.getElementById("processing_message").style.display = "none";
		}else if (graph_type == 9) 
	    {
	    
	    	$('#bargraph').html('');
	    	document.getElementById("processing_message").style.display = "block";
	        var t_minutes_data = [];
	        var schdule_minutes_data = [];

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

	            var shut_down_minutes = parseFloat(data_points[i].z);
                var shut_down_hours = Math.floor(shut_down_minutes / 60);
                var shut_down_remaining_minutes = shut_down_minutes % 60;
                var shut_down_formatted_time = shut_down_hours + "h " + shut_down_remaining_minutes + "m";

                var shut_down_point = {
                    y: shut_down_minutes, 
                    label: data_points[i].x 
                };
                schdule_minutes_data.push(shut_down_point);
	        }
            selected_field_assets.textContent = headingText9;
	        chart = new CanvasJS.Chart("bargraph", {
	        	width: 2500, 
                 height: 900,
	            animationEnabled: true,
	            title: {
	                // text: "Running Log Graph",
	                // fontSize: 23
	            },
	            axisY: [{
	               title: "Hours and Minutes",
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
			            minutes = parseFloat(minutes).toFixed(2); // Limiting minutes to two 
			           content += "<strong>" + e.entries[i].dataSeries.name + "</strong> " + hours + " hours " + minutes + " minutes<br/>";

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
	                type: "column",
	                name: "Running (Hours)",
	                legendText: "Running (Hours)",
	                dataPoints: t_minutes_data
                    },
	                {
                        type: "column",
                        name: "Schdule (Hours)",
                        legendText: "Schdule (Hours)",
                        dataPoints: schdule_minutes_data,
                       
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
	          document.getElementById("processing_message").style.display = "none";
	    }
	}
</script>
