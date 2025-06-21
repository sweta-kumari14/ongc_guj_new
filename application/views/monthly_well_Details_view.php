<div class="page-wrapper">
    <div class="content container-fluid">
			<div class="page-header">
				<div class="row">
					<div class="col-sm-12">
						<h3 class="page-title">Well Details Report</h3>
						<ul class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard_c');?>">Dashboard</a></li>
							<li class="breadcrumb-item ">Well Details Report</li>
							
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
                                <h3><b>Well Details Report</b></h3>
                            </div>
                            <div class="col-md-6 d-md-flex justify-content-end">
                                <div>
                                    <button class="btn btn-sm  btn-success" onclick="export_well_wise_report();">Export</button>
                                    <button class="btn btn-sm  btn-primary" onclick="printReport();">PDF</button>

                                </div>
                            </div>
                    	</div>
                    	<div class="row">
								<div class="form-group col-md-4 mt-2">
                                    <h5><b>Area Name</b></h5>
                                    <select name="site_id" id="site_id" class="form-control select2" onchange="well_details_monthly();">
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
                                   <h5><b>Month</b></h5>
                                       <select class="form-control select2" name="month" id="month" onchange="well_details_monthly();">
                                          <option value="">Select</option>
                                          <?php
                                          for ($x = 1; $x <= 12; $x++) {
                                            $month_num = sprintf("%02d", $x);
                                            $month_name = date('F', mktime(0,0,0,$x,1));
                                            // $month_name = date('F', mktime(0,0,0,$x));
                                            echo '<option value="'.$month_num.'" ';
                                            if ($x == date('n')) {
                                              echo 'selected';
                                            }
                                            echo' >'.$month_name.'</option>';
                                          }
                                          ?>
                                        </select>
                                 </div>
                                 <div class="form-group col-md-4 mt-2">
                                   <h5><b>Year</b></h5>
                                    <select class="form-control select2" name="year" id="year" onchange="well_details_monthly();">
                                     <option>Select</option>
                                      <?php
                                        $current_year = date('Y');
                                        for($i= $current_year - 3; $i < $current_year +3; $i++) {
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
			<div class="card">
				<div class="card-body" id=GFG>
				    <div class="row">
				    	<div class="table-responsive mt-4" id="well_wise_table_export">
								<table class="table table-bordered border-bottom" >
									<thead class="bg-light text-center">
										<tr>
											<th colspan="5" class="" style="font-size: 15px;font-weight: bolder;">Hiring of IoT based SRP wells online monitoring services for a <br>period of three
                                            years for Cambay Asset awarded vide <br>  GEMC-511687710464918 dated 21.12.2023 to M/s iOTAS Solutions Pvt. Ltd.		
                                           </th>
										</tr>

										<tr>
											<th colspan="5" class="text-uppercase" style="font-size: 12px;font-weight: bolder;" id ='details_heading'></th>
										</tr>
									</thead>
								

										<tr>
                                           <th colspan="5">
                                             <div style="display: flex; justify-content: space-between; align-items: center;">
                                                 <div>Field: <span id="selected_site_name"></span></div>
                                                 <div>Date:<?php echo date('d-m-Y');?></div>
                                                </div>
                                            </th>
										</tr>
									</table>
									<table class="table table-bordered border-bottom" >
										
										<tr>
											<th colspan="5">Existing Device</th>
											
										</tr>
										<thead  class="text-center" >
										<tr>
											<th>Sl No.</th>
											<th>Well Name</th>
											<th>Date of Comissioning</th>
											<th>Remark</th>
											<th></th>
										</tr>
										</thead>
										<tbody class="text-center" id="exists_well_data">				
									   </tbody>
										<tr>
				                           <th colspan ="5" style="height:30px;"></th>
				
			                            </tr> 
			                           
										<tr>
											<th colspan="5">New Device Addition</th>
										</tr>
										 <thead  class="text-center" >
										<tr>
											<th>Sl No.</th>
											<th>Well Name</th>
											<th>Date of Comissioning</th>
											<th>No.of Days</th>
											<th>Remark</th>
										</tr>
										</thead>
										<tbody class="text-center" id="new_well_data">				
									   </tbody>
										<tr>
				                           <th colspan ="5" style="height:30px;"></th>
				
			                            </tr> 
			                            
										<tr>
											<th colspan="5">Device Shifting</th>
																				</tr>
										<thead class="text-center">
										<tr>
											<th>Sl No.</th>
											<th>Well Name</th>
											<th>Date of Shifting</th>
											<th>No.of Days</th>
											<th>Remark</th>
										</tr>
										</thead>
										<tbody class="text-center" id="shifting_well_data">				
									   </tbody>
										
										<tr>
				                           <th colspan ="5" style="height:30px;"></th>
				
			                            </tr>


			                            <tr>
											<th colspan="5">Re-installation</th>
										</tr>
										<thead class="text-center">
										<tr>
											<th>Sl No.</th>
											<th>Well Name</th>
											<th>Date of Re-installation</th>
											<th>No.of Days</th>
											<th>Remark</th>
										</tr>
										</thead>
										<tbody class="text-center" id="reinstall_well_data">				
									   </tbody>
										
										<tr>
				                           <th colspan ="5" style="height:30px;"></th>
				
			                            </tr>
			                            

										<tr>
											<th colspan="5">Device Removal</th>
										
										</tr>
										<thead class="text-center">
										<tr>
											<th>Sl No.</th>
											<th>Well Name</th>
											<th>Date of De Comissioning</th>
											<th>Remark</th>
											<th></th>
										</tr>
										</thead>
										<tbody class="text-center" id="remove_well_data">				
									   </tbody>
										
										<tr>
				                           <th colspan ="5" style="height:30px;"></th>
				
			                            </tr> 
										
										
			                           <tr>
			                             
			                             <th colspan ="5" style="text-align: right; font-size: 18px;height:50px;">Sign of Installation Manager</th>
		                                </tr>
										<tr>
				                           <th colspan ="5" style="height:30px;"></th>
				
			                            </tr> 
										
									</thead>
								</table>
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
	well_details_monthly();
	function well_details_monthly() {
   
    var site_id = $('#site_id').val();
    var month = $('#month').val();
    var year = $('#year').val();

    var selectedsiteName = $('#site_id option:selected').text();
    var monthName = $('#month option:selected').text();


    let headingText = `Report of Device Installation, Removal and Shifting for Month of ${monthName}-${year}     `;
     $('#details_heading').text(headingText);
  
   
    $.ajax({
        url: '<?php echo base_url(); ?>Monthly_well_Details_c/get_area_assetwise_monthlywell_report',
        method: 'POST',
        data: {site_id:site_id,month:month,year:year},
        success: function (res) {
            var response = JSON.parse(res);
            if (response.response_code == 200) {
            	console.log(response);
            	 $('#exists_well_data').html("");
            	 $('#new_well_data').html("");
            	 $('#shifting_well_data').html("");
            	 $('#remove_well_data').html("");
            	 $('#reinstall_well_data').html("");


            	 // existing well start //

            	var total_exist_well = response.data.exist_Well.existtotalwell;
            	$('#total_exist_well').text(total_exist_well);
            	 $('#selected_site_name').text(selectedsiteName);
                	
                if (response.data.exist_Well.existwellDetails.length > 0)
                {
                     $.each(response.data.exist_Well.existwellDetails, function (i, v) {
                     
                     	$("#exists_well_data").append('<tr>' +
                            '<td>' + (i + 1) + '</td>' +
                            '<td>'+v.well_name+'</td>'+
                            // '<td>'+v.installation_date+'</td>'+
                            '<td>'+v.commissioning_date+'</td>'+
                            '<td></td>'+
                            '<td></td>'+
                           
                            '</tr>');
                       });

                } else {
                    $('#exists_well_data').html('<tr>' +
                        '<td class="text-danger" style="text-align:center;" colspan="5">No Record Found !!</td>' +
                        '</tr>');
                }

                 // existing well end //

                //new_well details start //


                var total_new_well = response.data.new_Well.newtotalwell;
            	$('#total_new_well').text(total_new_well);
                	
                if (response.data.new_Well.newwellDetails.length > 0)
                {
                     $.each(response.data.new_Well.newwellDetails, function (i, v) {
                     
                     	$("#new_well_data").append('<tr>' +
                            '<td>' + (i + 1) + '</td>' +
                            '<td>'+v.well_name+'</td>'+
                            // '<td>'+v.installation_date+'</td>'+
                            '<td>'+v.commissioning_date+'</td>'+
                            '<td>'+v.no_of_days+'</td>'+
                            '<td></td>'+
                           
                            '</tr>');
                       });

                } else {
                    $('#new_well_data').html('<tr>' +
                        '<td class="text-danger" style="text-align:center;" colspan="5">No Record Found !!</td>' +
                        '</tr>');
                }

                //new_well details end //

                //shifting details start //

                 var total_shifting_well = response.data.shift_Well.totalshiftwell;
            	$('#total_shifting_well').text(total_shifting_well);
                	
                if (response.data.shift_Well.shiftwellDetails.length > 0)
                {
                     $.each(response.data.shift_Well.shiftwellDetails, function (i, v) {

                     	var shifted_well = v.well_name + " to " + v.well_name2;
                     
                     	$("#shifting_well_data").append('<tr>' +
                            '<td>' + (i + 1) + '</td>' +
                            '<td>'+shifted_well+'</td>'+
                            '<td>'+v.shifted_date+'</td>'+
                            // '<td>'+v.commissioning_date+'</td>'+
                             '<td>'+v.no_of_days+'</td>'+
                             '<td></td>'+
                            
                           
                            '</tr>');
                       });

                } else {
                    $('#shifting_well_data').html('<tr>' +
                        '<td class="text-danger" style="text-align:center;" colspan="5">No Record Found !!</td>' +
                        '</tr>');
                }
                // shifting details end //

                

                //reinstall well details start //

               
                if (response.data.reinstall_Well.reinstallwellDetails.length > 0)
                {
                     $.each(response.data.reinstall_Well.reinstallwellDetails, function (i, v) {

                     	var reinstall_well = v.well_name;
                     
                     	$("#reinstall_well_data").append('<tr>' +
                            '<td>' + (i + 1) + '</td>' +
                            '<td>'+reinstall_well+'</td>'+
                            '<td>'+v.reinstall_date+'</td>'+
                            // '<td>'+v.commissioning_date+'</td>'+
                             '<td>'+v.no_of_days+'</td>'+
                             '<td>' +(v.reason !== null ? v.reason : '')+ '</td>' +
                            '</tr>');
                       });

                } else {
                    $('#reinstall_well_data').html('<tr>' +
                        '<td class="text-danger" style="text-align:center;" colspan="5">No Record Found !!</td>' +
                        '</tr>');
                }
                // reinstall well details end //

                 //remove details start //

                 var total_remove_well = response.data.remove_Well.totalremovewell;
            	$('#total_remove_well').text(total_remove_well);
                	
                if (response.data.remove_Well.removewellDetails.length > 0)
                {
                     $.each(response.data.remove_Well.removewellDetails, function (i, v) {
                     
                     	$("#remove_well_data").append('<tr>' +
                            '<td>' + (i + 1) + '</td>' +
                            '<td>'+v.well_name+'</td>'+
                            '<td>'+v.remove_date+'</td>'+
                            // '<td>'+v.commissioning_date+'</td>'+
                            '<td></td>'+
                            '<td></td>'+
                           
                            '</tr>');
                       });

                } else {
                    $('#remove_well_data').html('<tr>' +
                        '<td class="text-danger" style="text-align:center;" colspan="5">No Record Found !!</td>' +
                        '</tr>');
                }
                // remove details end //
            }
        }
    });
}
</script>

<script src="<?php echo base_url(); ?>assets/local/excel/xlsx.full.min.js"></script>
<script type="text/javascript">
	 function export_well_wise_report() {
        var sheetName = "Sheet1";
        var fileName = "Well Installation and Replacement and Shifting Report.xlsx";
        var table = $("#well_wise_table_export")[0];
        var ws = XLSX.utils.table_to_sheet(table, {
            raw: true
        });

        Object.keys(ws).forEach(cell => {
            if (cell[0] !== '!') {
                ws[cell].t = 's'; 
            }
        });

        var wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, sheetName);

     
        XLSX.writeFile(wb, fileName);
    }

</script>
 <style>
        @media print {
            .no-print {
                display: none !important;
            }
            
        table, th, td {
            border: 1px solid black !important;
            border-collapse: collapse;
        }
       
    </style>
 <script>
        function printReport() {
            printDiv = "#GFG"; 
            $("*").addClass("no-print");
            $(printDiv+" *").removeClass("no-print");
            $(printDiv).removeClass("no-print");

            parent =  $(printDiv).parent();
            while($(parent).length) {
                $(parent).removeClass("no-print");
                parent =  $(parent).parent();
            }
            window.print();
        }
    </script> 