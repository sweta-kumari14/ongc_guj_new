 <div class="page-wrapper">
			
				<!-- Page Content -->
                <div class="content container-fluid">
					
					<!-- Page Header -->
					<div class="page-header">
						<div class="row">
							<div class="col-sm-12">
								<h3 class="page-title">Well Scheduling</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard_c');?>">Dashboard</a></li>
									<li class="breadcrumb-item ">Well Scheduling</li>
									
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
					                       <h4 class="header-title mb-4">Well Scheduling List</h4>
					                    </div>
								        <div class="col-auto float-end ms-auto">
								             <a href="<?php echo base_url('Well_configration_c/Add_well_Configration_page'); ?>">
                                               <button type="button" class="btn btn-sm btn-rounded btn-success">Add</button>
                                            </a>
								
									        <button class="btn btn-primary btn-sm btn-rounded mx-2" onclick="export_report()" style="font-size: 14px;">Export</button>
								
							            </div>
						            </div>

                                	
                                <div class="table-responsive">
                                	<div class="col-md-4">
                                		<label><b>Search Well Name</b></label>   
                                     <input type="text" onkeyup="get_sheduling_well()" name="search_box_1" id="search_box_1" class="form-control">
                                 </div>
								<table class="table table-striped " id="data-table">
									
									<thead class="text-center">
										<tr>
											<th style="width:10%;">Sl No.</th>
											<th>Well Name</th>
											<th>Well Type</th>
											<th>Running Hours</th>
                                            <th>Shut Down Hours</th>
                                            <th>Assign Date</th>
											<th style="width:25%;">Action</th>
											
										</tr>
									</thead>
									<tbody class="text-center" id="table_data">
								
										
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
    
    
   
    function delete_well_configration(well_id)
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
                url:'<?php echo base_url(); ?>Well_configration_c/DeleteWell_Configration',
                data:{well_id: well_id},
                success:function(res)
                {
                    res = JSON.parse(res);
                    console.log(res);
                    if(res.response_code==200)
                    {
                      swal('success',res.msg,'success');
                      setTimeout(()=>{window.location.href="<?php echo base_url(); ?>Well_configration_c"},200)
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
	  var fileName = "Well configration list.xlsx";
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
	get_sheduling_well();
function get_sheduling_well() {
    let company_id = "<?php echo $this->session->userdata('company_id') ?>";
    let user_id = "<?php echo $this->session->userdata('user_id') ?>";
     var search = $('#search_box_1').val();
    $.ajax({
        url: '<?php echo base_url(); ?>Well_configration_c/Well_sheduling_data',
        method: 'POST',
        data: {
            company_id: company_id,
            user_id: user_id,
            search:search
        },
        success: function(res) {
            var response = JSON.parse(res);

            if (response.response_code == 200) {
                var count = 0;
                $('#table_data').html("");
                if (response.data.length > 0) {

                    $.each(response.data, function(i, v) {
                        var well_type = '';
                        if (v.well_type == '0') {
                            well_type = "Regular";
                        } else {
                            well_type = "Periodic";
                        }

                        var total_minutes = v.running_minutes;
                        var hours = Math.floor(total_minutes / 60);
                        var minutes = total_minutes % 60;
                        var running = hours + " hrs " + minutes + " mins";

                        var shut_minutes = (1440 - v.running_minutes);
                        var shuthours = Math.floor(shut_minutes / 60);
                        var shutminutes = shut_minutes % 60;
                        var shut_running = shuthours + " hrs " + shutminutes + " mins";

                        $("#table_data").append('<tr>' +
                            '<td>' + (i + 1) + '</td>' +
                            '<td>' + v.well_name + '</td>' +
                            '<td>' + well_type + '</td>' +
                            '<td>' + running + '</td>' +
                            '<td>'+shut_running+'</td>'+
                            '<td>' + moment(v.assign_date).format('DD-MM-YYYY') + '</td>' +
                            '<td>' +
                            '<a href="<?php echo base_url(); ?>Well_configration_c/edit_configration/' + v.well_id + '">' +
                            '<i class="fas fa-pencil-alt" style="font-size:20px;color:green;"></i>' +
                            '</a>' +
                            '<a id="' + v.well_id + '" onclick="delete_well_configration(this.id);">' +
                            '<i class="fas fa-trash mx-2" style="color:#A93226;font-size:20px;cursor:pointer;"></i>' +
                            '</a>' +
                            '</td>' +
                            '</tr>');
                    });
                } else {
                    $('#table_data').html('<tr>' +
                        '<td class="text-danger" style="text-align:center;" colspan="7">No Record Found !!</td>' +
                        '</tr>');
                }
            }
        }
    });
}
</script>


				

                
