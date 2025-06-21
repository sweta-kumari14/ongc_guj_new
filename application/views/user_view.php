 <div class="page-wrapper">
			
				<!-- Page Content -->
                <div class="content container-fluid">
					
					<!-- Page Header -->
					<div class="page-header">
						<div class="row">
							<div class="col-sm-12">
								<h3 class="page-title">User</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard_c');?>">Dashboard</a></li>
									<li class="breadcrumb-item ">User</li>
									
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
					                       <h4 class="header-title mb-4">User</h4>
					                    </div>
								        <div class="col-auto float-end ms-auto">
								             <a href="<?php echo base_url('User_c/add_user_page'); ?>">
                                               <button type="button" class="btn btn-sm btn-rounded btn-success">Add</button>
                                            </a>
								
									        <button class="btn btn-primary btn-sm btn-rounded mx-2" onclick="export_report()" style="font-size: 14px;">Export</button>
								
							            </div>
						            </div>
                                	
                                <div class="table-responsive">
								<table class="table table-striped custom-table mb-0 datatable" id="data-table">
									<thead class="text-center">
										<tr>
											<th style="width:10%;">Sl No.</th>
											<th>User Name</th>
											<th>User ID</th>
											<th>Mobile No</th>
											<th>Email Id</th>
											<th>Employee Id</th>
											<th>Country</th>
											<th>State</th>
											<th>City</th>
											<th>Address</th>
											<th>Level</th>
											<th>Password</th>
											<th>Active Status</th>
											<th>Web Access</th>
											<th>Mobile Access</th>
											<th style="width:20%;">Action</th>
											
										</tr>
									</thead>
									<tbody class="text-center">
										<?php 
											if (!empty($user_list))
											{
												foreach ($user_list as $key => $value)
												{
													?>
														<tr>
															<td><?php echo $key+1; ?></td>
															<td><?php echo $value['user_full_name']; ?></td>
															<td><?php echo $value['userId']; ?></td>
															<td><?php echo $value['contact_no']; ?></td>
															<td><?php echo $value['email_id']; ?></td>
															<td><?php echo $value['emp_id']; ?></td>
															<td><?php echo $value['country_name']; ?></td>
															<td><?php echo $value['state_name']; ?></td>
															<td><?php echo $value['city']; ?></td>
															<td><?php echo $value['address']; ?></td>
															<td><?php 
															if ($value['role_type']==1)
															{
																echo "Assets Level(Tier-III)";
															}elseif ($value['role_type']==2)
															{
																echo "Area Level(Tier-II)";
															}elseif ($value['role_type']==3)
															{
																echo "Installation Level(Tier-I)";
															}elseif ($value['role_type']==5)
													        {
														        echo "Field Maintenance User";
													        }else{
																echo "";
															}
															 

															?></td>
															<td><?php echo $value['password']; ?></td>
															<td> <a href="<?php echo base_url(); ?>User_c/StatusChange/<?php echo $value['id']; ?>" ><input <?php if($value['active_status']==1){echo 'checked="checked"';} ?> onclick="StatusChange(this)" type="checkbox" value="<?php echo $value['id']; ?>"  class="mx-2" style="margin-top: 7px;"></a>
															</td>
                                                			
															<td><?php 
															if ($value['web_functionality']=='1'){
																?>
																	<img src="<?php echo base_url(); ?>assets/green_tick.png" width="25" alt="Active">
																<?php
																}else{
																	?>
																	<img src="<?php echo base_url(); ?>assets/delete-button.png" width="25" alt="inactive">
																	<?php
																}

															?></td>
															<td><?php 
															if ($value['mobile_functionality']=='1'){
																?>
																	<img src="<?php echo base_url(); ?>assets/green_tick.png" width="25">
																<?php
																}else{
																	?>
																	<img src="<?php echo base_url(); ?>assets/delete-button.png" width="25">
																	<?php
																}

															?></td>
															<td>
															
									                          <a href="<?php echo base_url().'User_c/edit_user/'.$value['id'];  ?>"><i class="fas fa-pencil-alt" style="font-size:20px;color:green;"></i>
									                          </a>
									                                                
									                          <a id="<?php echo $value['id']; ?>" onclick="delete_user(this.id);">
									                             <i class="fas fa-trash mx-2" style="color:#A93226;font-size:20px;cursor:pointer;"></i> 
									                          </a>
									                                                      
									                        </td>
														</tr>
													<?php
												}
												
											}else{
			                                        ?>
			                                            <tr>
			                                                <td colspan="16" class="text-danger text-center">No records Found !!</td>
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
    
    
   
    function delete_user(id)
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
                url:'<?php echo base_url(); ?>User_c/delete_user',
                data:{id: id},
                success:function(res)
                {
                    res = JSON.parse(res);
                    console.log(res);
                    if(res.response_code==200)
                    {
                      swal('success',res.msg,'success');
                      setTimeout(()=>{window.location.href="<?php echo base_url(); ?>User_c"},200)
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
	  var fileName = "user list.xlsx";
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
<script type="text/javascript">
    
    function StatusChange(objref)
        {
            let id = $(objref).val();
            if($(objref).prop('checked')==true)
            {
                
                $.ajax({
                    type:'POST',
                    url:'<?php echo base_url(); ?>/User_c/Active_Inactive',
                    data:{id: id,active_status:1},
                    success:function(response)
                    {
                        response = JSON.parse(response);
                        if(response.response_code==200)
                        {
                            swal('success','User Activated Successfully','success');
                        }else
                        {
                            swal('error',response.msg,'error');
                        }
                        // console.log(response);
                    }
                });
            }else
            {
                $.ajax({
                    type:'POST',
                    url:'<?php echo base_url(); ?>/User_c/Active_Inactive',
                    data:{id: id,active_status:0},
                    success:function(response)
                    {
                        response = JSON.parse(response);
                        if(response.response_code==200)
                        {
                            swal('success','User Blocked Successfully !!','success');
                        }else
                        {
                            swal('error',response.msg,'error');
                        }
                        // console.log(response);
                    }
                });
            }
            
        }
</script>
				

				

                
