 <div class="page-wrapper">
			
				<!-- Page Content -->
                <div class="content container-fluid">
					
					<!-- Page Header -->
					<div class="page-header">
						<div class="row">
							<div class="col-sm-12">
								<h3 class="page-title">Assets</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard_c');?>">Dashboard</a></li>
									<li class="breadcrumb-item ">Assets</li>
									
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
					                       <h4 class="header-title mb-4">Assets</h4>
					                    </div>
								        <div class="col-auto float-end ms-auto">
								             <a href="<?php echo base_url('Assets_c/add_assets_page'); ?>">
                                               <button type="button" class="btn btn-sm btn-rounded btn-success">Add</button>
                                            </a>
								
									        <button class="btn btn-primary btn-sm btn-rounded mx-2" onclick="export_report()" style="font-size: 14px;">Export</button>
								
							            </div>
						            </div>
                                	
                                <div class="table-responsive">
                                	<input type="hidden" name="search" id="search" class="form-control">
								<table class="table table-striped custom-table mb-0 datatable" id="data-table">
									<thead class="text-center">
										<tr>
											<th style="width:10%;">Sl No.</th>
											<th>Assets Name</th>
											<th style="width:20%;">Action</th>
											
										</tr>
									</thead>
									<tbody class="text-center">
										<?php 
											if (!empty($assets_list))
											{
												foreach ($assets_list as $key => $value)
												{
													?>
														<tr>
															<td><?php echo $key+1; ?></td>
															<td><?php echo $value['assets_name']; ?></td>
															<td>
															
															
									                          <a href="<?php echo base_url().'Assets_c/edit_assets/'.$value['id'];  ?>"><i class="fas fa-pencil-alt" style="font-size:20px;color:green;"></i>
									                          </a>
									                                                
									                          <a id="<?php echo $value['id']; ?>" onclick="delete_assets(this.id);">
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
    
    
   
    function delete_assets(id)
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
                url:'<?php echo base_url(); ?>Assets_c/delete_assets',
                data:{id: id},
                success:function(res)
                {
                    res = JSON.parse(res);
                    console.log(res);
                    if(res.response_code==200)
                    {
                      swal('success',res.msg,'success');
                      setTimeout(()=>{window.location.href="<?php echo base_url(); ?>Assets_c"},200)
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
	  var fileName = "Assets list.xlsx";
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

				

                
