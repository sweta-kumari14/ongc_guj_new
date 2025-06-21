<div class="page-wrapper">
    <div class="content container-fluid pb-0">
    	<div class="page-header">
			<div class="content-page-header">
				<h5>Equipment Details</h5>
			</div>	
		</div>
			<div class="row">					
						<!-- Lightbox -->
                        <div class="col-lg-12">
                            <div class="card">
                               
                                <div class="card-body">
                                   <div class="row align-items-center">
                                        <div class="col">
                                           <h4 class="header-title mb-4"><b>Equipment Details</b></h4>
                                        </div>
                                        <div class="col-auto float-end ms-auto">
                                             <button class="btn btn-success btn-sm btn-rounded mx-2" onclick="export_report()" style="font-size: 14px;">Export</button>
                                        </div>
                                    </div>


                                    
                                <div class="row">
                                      <div class="form-group col-md-4 mt-2">
                                    <h5><b>From Date</b></h5>
                                    <input type="date" name="from_date" id="from_date" class="form-control"  value="<?php echo date('Y-m-d'); ?>" onchange="get_equipment_details_data();get_equipmentdate();">
                                </div>

                                <div class="form-group col-md-4 mt-2">
                                    <h5><b>To Date</b></h5>
                                    <input type="date" name="to_date" id="to_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" onchange="get_equipment_details_data();get_equipmentdate();">
                                </div>
                                
                            </div>

                             <div class="table-responsive mt-4">
                                <table class="table table-bordered border-bottom table-striped" id="data-table">
                                      <thead style="background-color:blue; color: white; text-align: center;">
                                        <tr>
                                          <th colspan="13" class="text-uppercase" style="font-size: 20px;font-weight: bolder;">IOT BASED REAL TIME WELL MONITORING SYSTEM ONGC,CAMBAY ASSET</th>
                                        </tr>
                                        <tr>
                                            <th colspan="13" class="text-uppercase" style="font-size: 15px;font-weight: bolder;">Equipment Reports as on <span id="show_from_date"></span> <span id="to">To</span> <span id="show_to_date"></span></th>
                                        </tr>
                                        <tr>
                                            <th style="width:10%;">Sl No.</th>
                                           <th>Well No</th>
                                            <th>Equipment Name</th>
                                            <th>Motor Serial No</th>
                                            <th>Motor Name</th>
                                            <th>Motor Capacity (HP)</th>
                                            <th>Surface Unit Make</th>
                                            <th>VFD Make</th>
                                            <th>VFD Model</th>
                                            <th>VFD Capacity (HP)</th>
                                            
                                            <th>Power Source</th>
                                            <th>DG/GG Make</th>
                                            <th>DG/GG Rating</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center" id="table_data"> 
                                    </tbody>
                                </table>


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
        get_equipmentdate();
    function get_equipmentdate()
    {
        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();

        f_from_date = moment(from_date);
        t_to_date = moment(to_date);

        if(f_from_date.isValid())
        {
            $('#show_from_date').text(f_from_date.format("DD-MM-YYYY"));
            $('#to').show();
        }else{
            $('#show_from_date').text('');
        }

        if(t_to_date.isValid())
        {
            $('#show_to_date').text(t_to_date.format("DD-MM-YYYY"));
            $('#to').show();
        }else{
            $('#show_to_date').text('');
        }

        // Additional check to show only the 'from date' if from_date == to_date
          if (f_from_date.isValid() && t_to_date.isValid() && f_from_date.isSame(t_to_date, 'day')) {
            $('#show_to_date').text('');
            $('#to').hide();

          }

    }
</script>


<script type="text/javascript">
    
get_equipment_details_data();
function get_equipment_details_data()
{
    let company_id = "<?php echo $this->session->userdata('company_id') ?>";
    let from_date = $('#from_date').val();
    let to_date = $('#to_date').val();
    let user_id = $('#user_id').val();

    $.ajax({
        url:'<?php echo base_url(); ?>Equipment_details_report_c/get_equipment_details',
        method:'POST',
        data:{company_id:company_id,from_date:from_date,to_date:to_date,user_id:user_id},
        success:function(res)
        {
            var response = JSON.parse(res);
            console.log(response);
            if(response.response_code==200)
                {
                    console.log(response);
                    $('#table_data').html("");
                     if(response.data.length > 0)
                     {
                        $.each(response.data,function(i,v){
                            
                            var phase  = '';
                            if (v.phase == 1)
                            {
                                var phase = "Single Phase";
                            }else if (v.phase == 2)
                            {
                                var phase = "Three Phase";
                            }else{
                                var phase = " ";
                            }
                            var surface_make_unit = v.surface_unit_make == null ? "NA" : v.surface_unit_make;
                            $("#table_data").append('<tr>'+
                                    '<td>'+(i+1)+'</td>'+
                                    '<td>'+v.well_name+'</td>'+
                                    '<td>'+v.equipment_name+'</td>'+
                                    '<td>'+v.serial_no+'</td>'+
                                    '<td>'+v.motor_name+'</td>'+
                                    '<td>'+v.motor_capacity+'</td>'+
                                    '<td>'+v.surface_unit_make+'</td>'+
                                    '<td>'+v.vfd_make+'</td>'+
                                    '<td>'+v.vfd_model+'</td>'+
                                    '<td>'+v.vfd_capacity+'</td>'+
                                    '<td>'+v.power_source+'</td>'+
                                    '<td>'+v.dg_gg_make+'</td>'+
                                    '<td>'+v.dg_gg_rating+'</td>'+
                                                                        
                                '</tr>');
                        });
                     }
                     else{
                        $('#table_data').html('<tr>'+
                                 '<td class="text-danger" style="text-align:center;" colspan="13">No Record Found !!</td>'+
                              '</tr>');
                     }
                }

        }
        
    });
}
</script>
<script src="<?php echo base_url(); ?>assets/local/excel/xlsx.full.min.js"></script>
<script type="text/javascript">
    
    function export_report() {
      var sheetName = "Sheet1";
      var fileName = "Equipment Details.xlsx";
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
         

                

