<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
<script src="https://unpkg.com/chart.js@2.8.0/dist/Chart.bundle.js"></script>
<script src="https://unpkg.com/chartjs-gauge@0.3.0/dist/chartjs-gauge.js"></script>


<div class="page-wrapper">
    <div class="content container-fluid">
	<!-- Page Header -->
	<div class="page-header">
		<div class="row align-items-center">
		 	 <div class="col">
				<h3 class="page-title">Historical Report</h3>
				<ul class="breadcrumb">
					<li class="breadcrumb-item active">Dashboard</li>
				</ul>
			</div>

			<div class="col-auto float-end ms-auto">
			    

                <a href="<?php echo base_url('Dashboard_c'); ?>">
                <button type="button" class="btn btn-sm btn-success">Back</button>
                </a>
            </div>
        </div>
    </div>



<!-- ====================== Card for date and filter starts ============= -->
<div class="row mx-1">
	<div class="card card-body">
		<div class="row"> 
			<div class="form-group col-md-4 mt-2">
				<label><b>View</b></label>
				<select name="view" id="view" class="form-control select2" onchange="get_data_view();">
					<option value="">Select View</option>
					<option value="mis_report">MIS Report</option>
					<option value="graph">Graph</option>


				</select>
			</div>

			<div class="form-group col-md-4 mt-2">
				<h5><b>Well No</b></h5>
				<select name="well_id" id="well_id" class="form-control select2" onchange="get_Average_data();get_mis_report();GetGraph();">
					
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
			    <h5><b>From Date</b></h5>
			    <input type="date" name="from_date" id="from_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" onchange="get_Average_data();get_mis_report();GetGraph();">
			</div>

			<div class="form-group col-md-4 mt-2">
			    <h5><b>To Date</b></h5>
			    <input type="date" name="to_date" id="to_date" class="form-control"  value="<?php echo date('Y-m-d'); ?>" onchange="get_Average_data();get_mis_report();GetGraph();">
			</div>

			<div class="form-group col-md-4 mt-2">
			    <h5><b>Sort By</b></h5>
			    <select class="form-control select2" name="sort_by" id="sort_by" onchange="get_mis_report();">
			    	<option value="">Select Column</option>
			    	<option value="last_log_datetime">Last Log DateTime</option>
			    	<option value="output_Average_Current">Average Current</option>
			    	<option value="output_Average_Voltage_L2N">Average L2N Voltage</option>
			    	<option value="output_Average_Voltage_P2P">Average P2P Voltage</option>
			    				    	
			    </select>
			</div>

		</div>
	</div>
</div>


<div class="row">
	 <div class="col-md-4">
		<div class="card mt-1" style="height:180px;border-radius: 10px;">
			<div class="card-header d-flex justify-content-between align-items-center" style="height:50px;background-color:#16A085;">
				Average Current&nbsp;<img src="<?php echo base_url(); ?>assets/img/ampere.gif" width="30" style="border-radius: 50%;"></div>
			<div class="card-body text-center">
		 <div class="row">
					<div class="col-3 border-right">
	            <h6 class="ad-title" style="font-size: 12px;">Current R</h6>
	            <h5><span  id="current_R"></span> <span style="font-size: 12px;"><br>Amp</span> </h5>
					</div>
					<div class="col-3  border-right">
	            <h6 class="ad-title" style="font-size: 12px;">Current Y</h6>
	            <h5><span  id="current_Y"></span><span style="font-size: 12px;"><br>Amp</span> </h5>
						</div>
						<div class="col-3  border-right">
	            <h6 class="ad-title" style="font-size: 12px;">Current B</h6>
	            <h5><span  id="current_B"></span><span style="font-size: 12px;"><br>Amp</span> </h5>
						</div>
						<div class="col-3">
	            <h6 class="ad-title" style="font-size: 12px;">Average</h6>
	            <h5><span  id="Avg_current"></span><span style="font-size: 12px;"><br>Amp</span> </h5>
						</div>
	        </div>
			</div> 
		</div>
	</div>
<div class="col-md-4">
		<div class="card mt-1" style="height:180px;border-radius: 10px;">
			<div class="card-header d-flex justify-content-between align-items-center" style="height:50px;background-color:#16A085;">
				Average P2P Voltage&nbsp;<img src="<?php echo base_url(); ?>assets/img/volt.gif" width="30" style="border-radius: 50%;"></div>
			   
        <div class="card-body text-center">
			<div class="row">
				<div class="col-3 border-right">
                   <h6 class="ad-title" style="font-size: 12px;">Voltage RY</h6>
  			       <h5><span  id="voltage_p2p_RY"></span><span style="font-size: 12px;"><br>Volt</span></h5>
				</div>
				<div class="col-3 border-right">
                <h6 class="ad-title" style="font-size: 12px;">Voltage YB</h6>
  			        <h5><span  id="voltage_P2P_YB"></span><span style="font-size: 12px;"><br>Volt</span> </h5>
				</div>
				<div class="col-3 border-right">
                <h6 class="ad-title" style="font-size: 12px;">Voltage BR</h6>
  			        <h5><span  id="voltage_P2P_BR"></span><span style="font-size: 12px;"><br>Volt</span> </h5>
				</div>
				<div class="col-3">
                <h6 class="ad-title" style="font-size: 12px;">Average</h6>
  			        <h5><span  id="Avg_Voltage_P2P_value"></span><span style="font-size: 12px;"><br>Volt</span> </h5>
				</div>
			</div>
			</div>
		</div>
	</div>
	
    <div class="col-md-4">
		<div class="card mt-1" style="height:180px;border-radius: 10px;">
			<div class="card-header d-flex justify-content-between align-items-center" style="height:50px;background-color:#16A085;">
				 Average L2N Voltage&nbsp;<img src="<?php echo base_url(); ?>assets/img/volt.gif" width="30" style="border-radius: 50%;"></div>
			<div class="card-body text-center">
		 <div class="row">
					<div class="col-3 border-right">
	            <h6 class="ad-title" style="font-size: 12px;">Voltage  R</h6>
	            <h5><span  id="voltage_L2N_R"></span> <span style="font-size: 12px;"><br>Volt</span> </h5>
					</div>
					<div class="col-3  border-right">
	            <h6 class="ad-title" style="font-size: 12px;">Voltage  Y</h6>
	            <h5><span  id="voltage_L2N_Y"></span><span style="font-size: 12px;"><br>Volt</span> </h5>
						</div>
						<div class="col-3  border-right">
	            <h6 class="ad-title" style="font-size: 12px;">Voltage  B</h6>
	            <h5><span  id="voltage_L2N_B"></span><span style="font-size: 12px;"><br>Volt</span> </h5>
						</div>
				<div class="col-3">
	            <h6 class="ad-title" style="font-size: 12px;">Average</h6>
	            <h5><span  id="Avg_Voltage_L2N_value"></span><span style="font-size: 12px;"><br>Volt</span> </h5>
				</div>
	        </div>
			</div> 
		</div>
	</div>
</div>




<!-- ====================== Code for MIS Table starts ============= -->
<div class="row" id="mis_table_view" style="display:none;">
	<div class="col-md-12">
		<div class="card card-body">
		    <div class="row">
			    <div class="col-md-6">
			        <h3><b>MIS Report</b></h3>
			    </div>
				<div class="col-md-6 d-flex justify-content-end">
				  <div>
				      <button class="btn btn-sm  btn-success" onclick="export_report();">Export</button>
				      <button class="btn btn-sm  btn-primary" onclick="printReport();">PDF</button>
				  </div>
				</div>
            </div>
	    <hr>
	    <div id ="GFG">
			<div class="card-body">
				<div class="table-responsive" id="basic-datatable">
					<table class="table table-bordered border-bottom" >
						<thead class="bg-light text-center">
							
							<tr>
								<th colspan="21" class="text-uppercase" style="font-size: 18px;font-weight: bolder;" id ="report-heading"> </th>
							</tr>
							</thead>
						</table>
						<table class="table table-bordered border-bottom" >
							<tr>
								<th style="width:10%;">Sl No.</th>
								<th>Last Log Datetime</th>
								<th>Avg Current</th>
								<th>Avg Voltage L2N</th>
								<th>Avg  Voltage P2P</th>
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
<!-- ====================== Code for MIS Table ends ============= -->
<!-- =============== card for data selection starts ======================= -->
<div class="row" id="graphical_view" style="display:none;">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header  d-flex justify-content-between align-items-center" style="background-color:blueviolet;">
                <div id="header_image_part">
                    <img src="<?php echo base_url(); ?>assets/img/line-chart.gif" width="50" style="border-radius: 50%;" id="icon_image">&nbsp;
                    <span style="color: black;" id="selected_field"></span>
                </div>
                <div>
                    <div class="d-flex justify-content-evenly mx-n3">
                        <div class="form-group mt-n1">
                            <select name="show_data" id="show_data" class="form-control select2" onchange="GetGraph();"> 
                                 <?php
									$user_type = $this->session->userdata('user_type', true);
									$role_type = $this->session->userdata('role_type', true);
									if ($user_type == 2 || ($user_type == 3 && $role_type == 3)) {
									    ?>
									    <option value="5"> Current</option>
									    <option value="3"> P2P Voltage</option>
									    <option value="1"> L2N Voltage</option>
									    <option value="2">Battery Voltage</option>
									    <option value="4">SMPS Voltage</option>
									    <?php
									} else {
									    ?>
									    <option value="5"> Current</option>
									    <option value="3"> P2P Voltage</option>
									    <option value="1"> L2N Voltage</option>
									    <?php
									}
									?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="content">
            <div class="card-body text-center">
             
            </div>
        </div>
    </div>
</div>


<div class="row" id="graphical_chart" style="display: none;">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body text-center">
            	 <div id="processing_message" style="display: none;">
                  <img src="<?php echo base_url(); ?>assets/loader_img.svg" class="loader-img " alt="Loader" style="height:200px;width:100px;align-items: center;">
                  </div>
            	<div id="neutral_voltage" style="height: 600px; width: 100%;">
                 
                </div>
            </div>
        </div>
    </div> 
</div>

<!-- =============== card for data selection end ======================= -->
</div>
</div>

<script type="text/javascript">
	
	get_data_view();
	function get_data_view()
	{
		var data_value = $('#view').val();

		if (data_value == 'mis_report')
		{
			$('#mis_table_view').show();
			$('#graphical_view').hide();
			$('#graphical_chart').hide();
		
			

		}else if(data_value == 'graph')
		{
			$('#mis_table_view').hide();
			$('#graphical_view').show();
			$('#graphical_chart').show();
		
		}else{
			$('#mis_table_view').hide();
			$('#graphical_view').hide();
			$('#graphical_chart').hide();
		
		}

	}
</script>

<script type="text/javascript">

get_Average_data();

function get_Average_data() {

	var well_id = $('#well_id').val();
	var from_date = $('#from_date').val();
	var to_date = $('#to_date').val();
	
    $.ajax({
        url: '<?php echo base_url(); ?>Historical_report_c/get_Average_data_value',
        type: 'POST',
        data: { well_id: well_id,from_date:from_date,to_date:to_date }, 
        success: function(res) {
            var res = JSON.parse(res);
            // console.log('ag',res);
     
            var Current_R = parseFloat(res.data[0].Current_R).toFixed(2);
            $('#current_R').text(Current_R);
          
            var Current_Y = parseFloat(res.data[0].Current_Y).toFixed(2);	
            $('#current_Y').text(Current_Y);

            var Current_B = parseFloat(res.data[0].Current_B).toFixed(2);
            $('#current_B').text(Current_B);

            var Avg_Current = parseFloat(res.data[0].Avg_current).toFixed(2);
            $('#Avg_current').text(Avg_Current);


            var Voltage_p2p_RY = parseFloat(res.data[0].Voltage_p2p_RY).toFixed(2);
            $('#voltage_p2p_RY').text(Voltage_p2p_RY);
          
            var Voltage_P2P_YB = parseFloat(res.data[0].Voltage_P2P_YB).toFixed(2);	
            $('#voltage_P2P_YB').text(Voltage_P2P_YB);

            var Voltage_P2P_BR = parseFloat(res.data[0].Voltage_P2P_BR).toFixed(2);
            $('#voltage_P2P_BR').text(Voltage_P2P_BR);

            var Avg_Voltage_P2P = parseFloat(res.data[0].Avg_Voltage_P2P).toFixed(2);
            $('#Avg_Voltage_P2P_value').text(Avg_Voltage_P2P);


             var Voltage_L2N_R = parseFloat(res.data[0].Voltage_L2N_R).toFixed(2);
            $('#voltage_L2N_R').text(Voltage_L2N_R);
          
            var Voltage_L2N_Y = parseFloat(res.data[0].Voltage_L2N_Y).toFixed(2);	
            $('#voltage_L2N_Y').text(Voltage_L2N_Y);

            var Voltage_L2N_B = parseFloat(res.data[0].Voltage_L2N_B).toFixed(2);
            $('#voltage_L2N_B').text(Voltage_L2N_B);

            var Avg_Voltage_L2N = parseFloat(res.data[0].Avg_Voltage_L2N).toFixed(2);
            $('#Avg_Voltage_L2N_value').text(Avg_Voltage_L2N);
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}
</script>


<script type="text/javascript">
	
	
		get_mis_report();
		function get_mis_report()
		{
			$('#table_data').html('<tr><td colspan="5">Processing please wait.......</td></tr>');
			var company_id = "<?php echo $this->session->userdata('company_id') ?>";
			var from_date = $('#from_date').val();
			var to_date = $('#to_date').val();
			var well_id = $('#well_id').val();
			var sort_by = $('#sort_by').val();

            var selectedWellName = $('#well_id option:selected').text();
            let formattedFromDate = moment(from_date, 'YYYY-MM-DD').format('DD-MM-YYYY');
            let formattedToDate = moment(to_date, 'YYYY-MM-DD').format('DD-MM-YYYY');
            let headingText = ` Historical Trend Of ${selectedWellName} from ${formattedFromDate} to ${formattedToDate}   `;
            $('#report-heading').text(headingText);

			$.ajax({
				url:'<?php echo base_url(); ?>Historical_report_c/get_mis_report_histrorical',
				method:'POST',
				data:{company_id:company_id,from_date:from_date,to_date:to_date,well_id:well_id,sort_by:sort_by},
				success:function(res)
				{
					var response = JSON.parse(res);
					console.log('mis',response);
				
					if(response.response_code==200)
		                {
		                    $('#table_data').html("");
		                     if(response.data.length > 0)
		                     {
		                        $.each(response.data,function(i,v){
		                            $("#table_data").append('<tr>'+
		                                '<td>'+(i+1)+'</td>'+
                                        '<td>' + (v.last_log_datetime !== null ? moment(v.last_log_datetime).format('DD-MM-YYYY h:mm:ss a') : 'NA') + '</td>' +
                                       
                                        '<td>' + (v.output_Average_Current !== null ? v.output_Average_Current : 'NA') + '</td>' +
                                       
                                        '<td>' + (v.output_Average_Voltage_L2N !== null ? v.output_Average_Voltage_L2N : 'NA') + '</td>' +
		                               
		                                '<td>' + (v.output_Average_Voltage_P2P !== null ? v.output_Average_Voltage_P2P : 'NA') + '</td>' +
		                                
		                            '</tr>');
		                        });
		                     }
		                     else{
		                        $('#table_data').html('<tr>'+
		                                 '<td class="text-danger" style="text-align:center;" colspan="5">No Record Found !!</td>'+
		                              '</tr>');
		                     }
		                }

				}
				
			});
		}

</script>



<script type="text/javascript">
	function GetGraph(){
			var selectedOption = document.getElementById("show_data").value;
			var selectedField = document.getElementById("selected_field");
			var iconImage = document.getElementById("icon_image");
			var content = document.getElementById("content");
		    document.getElementById("processing_message").style.display = "block";
			
			
			if(selectedOption == "1")
			{
					selectedField.textContent = " Neutral Voltage";
					iconImage.src = "<?php echo base_url(); ?>assets/img/speedometer.gif";
					content.innerHTML = "";
					var well_id = $('#well_id').val();
					var from_date = $('#from_date').val();
					var to_date = $('#to_date').val();


					
					$.ajax({
			            url: '<?php echo base_url(); ?>Historical_report_c/get_graph_histrorical',
			            type: 'POST',
			            data: {well_id:well_id,from_date:from_date,to_date:to_date,graph_type:selectedOption},
			            success:function(res)
			            {
			            	document.getElementById("processing_message").style.display = "none";
							var res=JSON.parse(res);
							input_volt_l2n_r=res.data.output_neutral_voltage['output_n_Avg'];
							limit_slice=res.data.output_neutral_voltage['output_n_Avg'].length;
							loadchart("neutral_voltage","Trend of L2N  Voltage", "L2N Avg (v) "); 
						}
					});


			}else if(selectedOption == "3")
			{
					selectedField.textContent = " Line Voltage";
					iconImage.src = "<?php echo base_url(); ?>assets/img/speedometer.gif";
					content.innerHTML = "";
					var well_id = $('#well_id').val();
					var from_date = $('#from_date').val();
					var to_date = $('#to_date').val();

					
					$.ajax({
			            url: '<?php echo base_url(); ?>Historical_report_c/get_graph_histrorical',
			            type: 'POST',
			            data: {well_id:well_id,from_date:from_date,to_date:to_date,graph_type:selectedOption},
			            success:function(res)
			            {
			            	document.getElementById("processing_message").style.display = "none";
							var res=JSON.parse(res);
							input_volt_l2n_r=res.data.output_line_voltage['output_v_Avg'];
							limit_slice=res.data.output_line_voltage['output_v_Avg'].length;
							loadchart("neutral_voltage","Trend of P2P  Voltage", "P2P Avg (v) "); 
					}});

			}else if(selectedOption == "5")
			{
					selectedField.textContent = " Current";
					iconImage.src = "<?php echo base_url(); ?>assets/img/frequency.gif";
					content.innerHTML = "";
					var well_id = $('#well_id').val(); 
					var from_date = $('#from_date').val();
					var to_date = $('#to_date').val();
					
					
					$.ajax({
			            url: '<?php echo base_url(); ?>Historical_report_c/get_graph_histrorical',
			            type: 'POST',
			            data: {well_id:well_id,from_date:from_date,to_date:to_date,graph_type:selectedOption},
			            success:function(res)
			            {
			            	document.getElementById("processing_message").style.display = "none";
							var res=JSON.parse(res);
							input_volt_l2n_r=res.data.output_current['output_i_Avg'];
							limit_slice=res.data.output_current['output_i_Avg'].length;
							loadchart("neutral_voltage","Trend of  Current", "Avg (a) "); 
						
					}});

			}else if(selectedOption == "2")
			{
					selectedField.textContent = "Battery Voltage";
					iconImage.src = "<?php echo base_url(); ?>assets/img/volt.gif";
					content.innerHTML = "";
					var well_id = $('#well_id').val();
					var from_date = $('#from_date').val();
					var to_date = $('#to_date').val();
					$.ajax({
			            url: '<?php echo base_url(); ?>Dashboard_c/get_historical_all_graph_ajax',
			            type: 'POST',
			            data: {well_id:well_id,from_date:from_date,to_date:to_date,graphtype:selectedOption},
			            success:function(res)
			            {
			            	document.getElementById("processing_message").style.display = "none";
							var res=JSON.parse(res);

							input_volt_l2n_r=res.data.battery_voltage['battery_voltage'];
							limit_slice=res.data.battery_voltage['battery_voltage'].length;
							loadchart("neutral_voltage","Trend of  Battery Voltage", " (V) "); 
						
					}});

			}else if(selectedOption == "4")
			{
					selectedField.textContent = "SMPS Voltage";
					iconImage.src = "<?php echo base_url(); ?>assets/img/volt.gif";
					content.innerHTML = "";
					var well_id = $('#well_id').val();
					var from_date = $('#from_date').val();
					var to_date = $('#to_date').val();
					$.ajax({
			            url: '<?php echo base_url(); ?>Dashboard_c/get_historical_all_graph_ajax',
			            type: 'POST',
			            data: {well_id:well_id,from_date:from_date,to_date:to_date,graphtype:selectedOption},
			            success:function(res)
			            {
			            	document.getElementById("processing_message").style.display = "none";
							var res=JSON.parse(res);

							input_volt_l2n_r=res.data.smps_Voltage['smps_voltage'];
							limit_slice=res.data.smps_Voltage['smps_voltage'].length;
							loadchart("neutral_voltage","Trend of  SMPS Voltage", " (V) "); 
						
					}});

			}
	}

	function loadchart(mychart, mytitle,name1) {
    var dataPoints1 = [];
 
  
    var chart = new CanvasJS.Chart(mychart, {
        zoomEnabled: true,
        title: {
            text: mytitle,
            fontSize: 14
        },
        axisX:{  
          
                valueFormatString: "DD-MM-YYYY HH:mm:ss",
                labelFontSize: 12,
                labelAutoFit: false,
                labelAngle: 180,
              },
        axisY:{
            prefix: " ",
            labelFontSize: 10,
        }, 
        toolTip: {
            shared: true
        },
        legend: {
            cursor:"pointer",
            verticalAlign: "top",
            fontSize: 16,
            fontColor: "dimGrey",
            itemclick : toggleDataSeries
        },
        data: [{ 
            type: "line",
            xValueType: "dateTime",
            xValueFormatString: "DD-MM-YYYY HH:mm:ss",
            showInLegend: true,
            name: name1,
            dataPoints: dataPoints1
            }]
    });
    
    function toggleDataSeries(e) {
        if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
            e.dataSeries.visible = false;
        }
        else {
            e.dataSeries.visible = true;
        }
        chart.render();
    }
    
    var updateInterval = 1000;
    function updateChart() {
        for (var i = 0; i < input_volt_l2n_r.length; i++) {
                var yValue1 = parseFloat(input_volt_l2n_r[i].y);
                var xValue1 =new Date(input_volt_l2n_r[i].x).getTime();
                var prevlnr=0;
                var nextlnr=0;
                if(i>0){
                    prevlnr=parseFloat(input_volt_l2n_r[i-1].y);
                    
                } 
                if(i<input_volt_l2n_r.length-1){
                    nextlnr=parseFloat(input_volt_l2n_r[i+1].y);
                   
                }   
                if(dataPoints1.length<limit_slice){
                   if(!(prevlnr>0 && parseFloat(input_volt_l2n_r[i].y)<=0 && nextlnr>0)){
                    dataPoints1.push({
                        x: xValue1,
                        y: yValue1
                   });   
                  }
                  
                   
                }else{
                    if(!(prevlnr>0 && parseFloat(input_volt_l2n_r[i].y)<=0 && nextlnr>0)){
                        dataPoints1.shift();
                        dataPoints1.push({
                            x: xValue1,
                            y: yValue1
                       });   
                      }
                
            }
                
        }
        // updating legend text with  updated with y Value 
        chart.options.data[0].legendText = name1;
        chart.render();
    }
    // generates first set of dataPoints 
    updateChart();
    setInterval(function(){updateChart()}, updateInterval);
    
}
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/canvasjs/1.7.0/canvasjs.min.js"></script>



<script src="<?php echo base_url(); ?>assets/local/excel/xlsx.full.min.js"></script>
<script type="text/javascript">
	
	function export_report() {

	  
	  var sheetName = "Sheet1";
	  var selectedWellName = $('#well_id option:selected').text().trim();
     
      var fileName = 'Mis Report of ('+selectedWellName+').xlsx';
	 
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
