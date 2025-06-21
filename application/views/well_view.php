 <div class="page-wrapper">
			
				<!-- Page Content -->
                <div class="content container-fluid">
					
					<!-- Page Header -->
					<div class="page-header">
						<div class="row">
							<div class="col-sm-12">
								<h3 class="page-title">Well</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard_c');?>">Dashboard</a></li>
									<li class="breadcrumb-item ">Well</li>
									
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					 <div class="row">
    <div class="col-xl-12"> <!-- Correct grid width -->
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center mb-3">
                    <div class="col-md-6">
                        <h4 class="header-title mb-3"> <strong>Well List</strong></h4>
                    </div>
                </div>

                <div class="row align-items-center mb-3">
                    <!-- Well Type Filter -->
                    <div class="col-md-3">
                        <label for="well_type" class="form-label">Well Type</label>
                        <select class="form-control select2" id="well_type" name="well_type" onchange="flag_unflag_list();">
                            <option value="">All Types</option>
                            <?php foreach ($well_type_list as $type) { ?>
                                <option value="<?php echo $type['id']; ?>"><?php echo $type['well_type_name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <!-- Buttons aligned to right -->
                    <div class="col-md-9 text-end">
                        <a href="<?php echo base_url('Well_c/add_well_page'); ?>" class="btn btn-success btn-sm btn-rounded me-2 mt-4">Add</a>
                        <button class="btn btn-primary btn-sm btn-rounded mt-4" onclick="export_report()" style="font-size: 14px;">Export</button>
                    </div>
                </div>

                                	
                               <div class="table-responsive" style="margin-top: 0; padding-top: 0;">
								<table class="table table-striped custom-table mb-0 datatable" id="data-table">
									<thead class="text-center">
										<tr>
											<th style="width:10%;">Sl No.</th>
											<th>Asset</th>
											<th>Area</th>
											<th>Site</th>
											<th>Well Type</th>
											<th>Well Name</th>
											<th>Latitude</th>
											<th>Longitude</th>
											<th style="width:25%;">Action</th>
											
										</tr>
									</thead>
									<tbody class="text-center" id="table_data">
										<!-- <?php 
											if (!empty($well_list))
											{
												foreach ($well_list as $key => $value)
												{
													?>
														<tr>
															<td><?php echo $key+1; ?></td>
															<td><?php echo $value['assets_name'];?>
															<td><?php echo $value['area_name']; ?></td>
															<td><?php echo $value['well_site_name']; ?></td>
															<td><?php echo $value['well_type_name']; ?></td>
															<td><?php echo $value['well_name']; ?></td>
															<td><?php echo $value['lat']; ?></td>
															<td><?php echo $value['long']; ?></td>
															<td>
									                          <a href="<?php echo base_url().'Well_c/edit_well/'.$value['id'];  ?>"><i class="fas fa-pencil-alt" style="font-size:20px;color:green;"></i>
									                          </a>
									                                                
									                          <a id="<?php echo $value['id']; ?>" onclick="delete_well(this.id);">
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
										 -->
										
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
    
    
   
    function delete_well(id)
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
                url:'<?php echo base_url(); ?>Well_c/delete_well',
                data:{id: id},
                success:function(res)
                {
                    res = JSON.parse(res);
                    console.log(res);
                    if(res.response_code==200)
                    {
                      swal('success',res.msg,'success');
                      setTimeout(()=>{window.location.href="<?php echo base_url(); ?>Well_c"},200)
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
	  var fileName = "Well list.xlsx";
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

	flag_unflag_list();
	function flag_unflag_list() {
    var well_type = $('#well_type').val();  
    // alert(well_type);

    $('#table_data').html('<tr><td colspan="11">Processing, please wait...</td></tr>');

    $.ajax({
        url: '<?php echo base_url(); ?>Well_c/well_list_ajax',
        method: 'POST',
        data: { well_type: well_type },  // Send filter
        success: function (res) {
            var response = JSON.parse(res);

            if (response.response_code == 200) {
                $('#table_data').html('');
                if (response.data.length > 0) {
                    $.each(response.data, function (i, v) {
                        $("#table_data").append('<tr>' +
                            '<td>' + (i + 1) + '</td>' +
                            '<td>' + (v.assets_name ? v.assets_name : '') + '</td>' +
                            '<td>' + (v.area_name ? v.area_name : '') + '</td>' +
                            '<td>' + (v.well_site_name ? v.well_site_name : '') + '</td>' +
                            '<td>' + (v.well_type_name ? v.well_type_name : '') + '</td>' +
                            '<td>' + (v.well_name ? v.well_name : '') + '</td>' +
                            '<td>' + (v.lat ? v.lat : '') + '</td>' +
                            '<td>' + (v.long ? v.long : '') + '</td>' +
                            '<td>' +
                            '<a href="<?php echo base_url(); ?>Well_c/edit_well/' + v.id + '">' +
                            '<i class="fas fa-pencil-alt" style="font-size:20px;color:green;"></i></a>' +
                            '<a onclick="delete_well(' + v.id + ')" style="cursor:pointer;">' +
                            '<i class="fas fa-trash mx-2" style="color:#A93226;font-size:20px;"></i></a>' +
                            '</td>' +
                            '</tr>');
                    });
                } else {
                    $('#table_data').html('<tr><td colspan="11" class="text-center text-danger">No Record Found!!</td></tr>');
                }
            }
        }
    });
}




</script>
				

                
