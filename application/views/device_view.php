 <div class="page-wrapper">
			
				<!-- Page Content -->
                <div class="content container-fluid">
					
					<!-- Page Header -->
					<div class="page-header">
						<div class="row">
							<div class="col-sm-12">
								<h3 class="page-title">Device</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard_c');?>">Dashboard</a></li>
									<li class="breadcrumb-item ">Device</li>
									
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
					                       <h4 class="header-title mb-4">Device</h4>
					                    </div>
								        <div class="col-auto float-end ms-auto">
								             <a href="<?php echo base_url('Device_c/add_device_page'); ?>">
                                               <button type="button" class="btn btn-sm btn-rounded btn-success">Add</button>
                                            </a>
								
									        <button class="btn btn-primary btn-sm btn-rounded mx-2" onclick="export_report()" style="font-size: 14px;">Export</button>
								
							            </div>
						            </div>

						            <div class="row mb-2 ">
					                    <form id="formData" method="POST" action="<?php echo base_url('Device_c/upload'); ?>" enctype="multipart/form-data">
				                            <div class="row">
				                                <div class="col-md-4 pb-4">
				                                    <strong class="form-group">Import Excel</strong>
				                                    <input type="file" onchange="javascript:document.getElementById('formData').submit()" name="file" id="file" class="form-control">
				                                </div>
				                                <div class="col-md-4" style="margin-top: 2.2%;">
				                                    <a class="btn btn-md" style="background:lightseagreen;margin-left: -3%;" href="<?php echo base_url().'assets/device_master.xlsx'; ?>" id="downloadBtn" download>Format<i class=" la la-download"></i></a>
				                                </div>
				                            </div>
					                    </form>
					                </div>
                                	
                                <div class="table-responsive">
								<table class="table table-striped custom-table mb-0 datatable" id="data-table">
									<thead class="text-center">
										<tr>
											    <th style="width:10%;">Sl No.</th>
											    <th>Manufacturer Name</th>
											    <th>Model Name</th>
												<th>Device Name</th>
												<th>Imei No</th>
												<th>Serial No</th>
												<th>Manufacture Month</th>
												<th>Manufacturer Year</th>

												<th>Allot Status</th>
												<th>Alloted Company</th>
											    <th style="width:20%;">Action</th>
											
										</tr>
									</thead>
									<tbody class="text-center">
										<?php 
											if (!empty($device_list))
											{
												foreach ($device_list as $key => $value)
												{
													?>
														<tr>
															<td><?php echo $key+1; ?></td>
																<td><?php echo $value['manufacturer_name']; ?></td>
																<td><?php echo $value['model_name']; ?></td>
																<td><?php echo $value['device_name']; ?></td>
																<td><?php echo $value['imei_no']; ?></td>
																<td><?php echo $value['serial_no']; ?></td>
																<td><?php echo $value['manufacturer_month']; ?></td>
																<td><?php echo $value['year_of_manufacturer']; ?></td>
																<td>
																	<?php 
		                                                         if($value['allot_status'] == 1){
		                                                             ?>
		                                                        <img src="<?php echo base_url(); ?>assets/green_tick.png" width="20px" alt="Active">
		                                                        <?php
		                                                            }
		                                                         if($value['allot_status'] == 0){
		                                                        ?>
		                                                        <img src="<?php echo base_url(); ?>assets/cross-tick.png" width="20px" alt="Not-Active">
		                                                        <?php
		                                                        }
		                                                    ?>   
																		
																</td>
																<td><?php 
																if ($value['company_name'] == ''){
																	echo "NA";
																	}else{
																		echo $value['company_name'];
																	}


																?></td>
																<td>
															
									                          <a href="<?php echo base_url().'Device_c/edit_device/'.$value['id'];  ?>"><i class="fas fa-pencil-alt" style="font-size:20px;color:green;"></i>
									                          </a>
									                                                
									                          <a id="<?php echo $value['id']; ?>" onclick="delete_device(this.id);">
									                             <i class="fas fa-trash mx-2" style="color:#A93226;font-size:20px;cursor:pointer;"></i> 
									                          </a>
									                                                      
									                        </td>
														</tr>
													<?php
												}
												
											}else{
			                                        ?>
			                                            <tr>
			                                                <td colspan="9" class="text-danger text-center">No records Found !!</td>
			                                            </tr>
			                                        <?php
			                                    }

										?>
										
										
									</tbody>
								</table>
							</div>
						</div>
					</div>
				
					<!-- /Content End -->
					
                </div>
				<!-- /Page Content -->
				
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
    
    
   
    function delete_device(id)
    {
      swal({
           title: "Are you sure?",
           text: "You want to delete",
           icon: "warning",
           buttons: true,
           dangerMode: true,
         })
         .then((willDelete) => {
           if (willDelete) {
            
            $.ajax({
                type:'POST',
                url:'<?php echo base_url(); ?>Device_c/delete_device',
                data:{id: id},
                success:function(res)
                {
                    res = JSON.parse(res);
                    console.log(res);
                    if(res.response_code==200)
                    {
                      swal('success',res.msg,'success');
                      setTimeout(()=>{window.location.href="<?php echo base_url(); ?>Device_c"},200)
                   }else
                   {
                        swal('warning',res.msg,'warning');
                   }
                    
                }
            })

           }
         });
    }
</script>

<script src="<?php echo base_url(); ?>assets/local/excel/xlsx.full.min.js"></script>
<script type="text/javascript">
	
	function export_report() {
	  var sheetName = "Sheet1";
	  var fileName = "device list.xlsx";
	  var table = $("#data-table")[0];
      var ws = XLSX.utils.table_to_sheet(table);
      var wb = XLSX.utils.book_new();
	  XLSX.utils.book_append_sheet(wb, ws, sheetName);
      XLSX.writeFile(wb, fileName);
	}

</script>

				

                
