<style type="text/css">
	.select2-selection__rendered{
		margin-top: 9px!important;
	}
</style>

<div class="page-wrapper">
<!-- Page Content -->
    <div class="content container-fluid">
    	<!-- Page Header -->
			<div class="page-header">
				<div class="row">
					<div class="col-sm-12">
						<h3 class="page-title">Overall</h3>
						<ul class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard_c');?>">Dashboard</a></li>
							<li class="breadcrumb-item ">Overall</li>
							
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
		                            <h4 class="header-title mb-4">Overall List</h4>
		                        </div>
					            <div class="col-auto float-end ms-auto">
						            <a href="<?php echo base_url('Dashboard_c'); ?>">
	                                   <button type="button" class="btn btn-sm  btn-info">Back</button>
	                                </a> 
					                <button class="btn btn-success btn-sm  mx-2" onclick="export_report()" style="font-size: 14px;">Export</button>
					            </div>
			                </div>
                                	
                             <div class="table-responsive">
								<table class="table table-striped custom-table mb-0 datatable" id="data-table">
									<thead class="text-center">
										<tr class="" style="">
											<th rowspan="2"><b>Sl.No.</b></th>
											<th colspan="5" style="font-size: 18px;"><b>Well Details</b></th>
											<th colspan="2" style="font-size: 18px;"><b>Installation details</b></th>
											<th colspan="2" style="font-size: 18px;"><b>Replacement details</b></th>
											<th colspan="2" style="font-size: 18px;"><b>DCU details</b></th>
										</tr>
										<tr class="bg-light">
											<th>Area</th>
											<th>Site</th>
											<th>Well </th>
											<th>Equipment Name</th>
											<th>Motor Name</th>
											<th>Installation Status</th>
											<th>Installation Date</th>
											<th>Replacement Status</th>
											<th>Replacement Date</th>
											<th>DCU</th>
											<th>Imei No</th>
										</tr>
									</thead>
									<tbody class="text-center">
										<?php 
										if (!empty($well_details))
										{
											foreach ($well_details as $key => $value)
											{
												?>
												<tr>
													<td><?php echo $key+1; ?></td>
													<td><?php echo $value['area_name']; ?></td>
													<td><?php echo $value['well_site_name']; ?></td>
													<td><?php
													if ($value['installed_status'] != '')
													{
														?>
															<a style="color: green;" href="<?php echo base_url().'Dashboard_c/get_single_well_detail_dashboard/'
															.$value['well_id'];  ?>"><?php echo $value['well_name']; ?>
																
															</a>
														<?php
													}else{
														?>
															<?php echo $value['well_name']; ?>
														<?php
													 
													}
													?></td>
													<td><?php echo $value['equipment_name']; ?></td>
													<td><?php echo $value['motor_name']; ?></td>
													<td><?php
													if ($value['installed_status'] != '')
													{
														?>
															<img src="<?php echo base_url(); ?>assets/green_tick.png" width="40">
														<?php
													}else{
														?>
															<img src="<?php echo base_url(); ?>assets/cross-tick.png" width="40">
														<?php
													 
													}
													?></td>
													<td><h6><?php 
                                                         if ($value['date_of_installation'] == "" || $value['date_of_installation'] == "1970-01-01")
                                                         {
                                                            echo " ";
                                                         }else{
                                                            echo  date('d-m-Y h:i:s a',strtotime($value['date_of_installation'])) ;
                                                         }


                                                         ?></h6>
                                                    </td>
													<td><?php
													if ($value['replace_status'] != '')
													{
														?>
															<img src="<?php echo base_url(); ?>assets/green_tick.png" width="40">
														<?php
													}else{
														?>
															<img src="<?php echo base_url(); ?>assets/cross-tick.png" width="40">
														<?php
													 
													}
													?></td>
													<!-- <td><?php echo $value['replacement_datetime']; ?></td> -->
													<td><h6><?php 
                                                         if ($value['replacement_datetime'] == "" || $value['replacement_datetime'] == "1970-01-01")
                                                         {
                                                            echo " ";
                                                         }else{
                                                            echo  date('d-m-Y h:i:s a',strtotime($value['replacement_datetime'])) ;
                                                         }


                                                         ?></h6>
                                                    </td>
													<td><?php echo $value['device_name']; ?></td>
													<td><?php echo $value['imei_no']; ?></td>
													
												</tr>
												<?php
											}
										}else{
											?>
												<tr>
													<td colspan="13" class="text-center" style="color:red;">No Records Found</td>
												</tr>
											<?php
										}

										?>
										
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


<script src="<?php echo base_url(); ?>assets/local/excel/xlsx.full.min.js"></script>
<script type="text/javascript">
	
	function export_report() {
	  var sheetName = "Sheet1";
	  var fileName = "Total Well List.xlsx";
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