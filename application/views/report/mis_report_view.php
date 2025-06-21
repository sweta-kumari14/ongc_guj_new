<div class="page-wrapper">
    <div class="content container-fluid pb-0">
    	<div class="page-header">
			<div class="content-page-header">
				<h5>MIS Report</h5>
			</div>	
		</div>
			<div class="row">					
						<!-- Lightbox -->
                        <div class="col-lg-12">
                            <div class="card">
                               
                                <div class="card-body">
                                   <div class="row align-items-center">
                                        <div class="col">
                                           <h4 class="header-title mb-4"><b>MIS Report</b></h4>
                                        </div>
                                        <div class="col-auto float-end ms-auto">
                                             <button class="btn btn-success btn-sm btn-rounded mx-2" onclick="export_report()" style="font-size: 14px;">Export</button>
                                        </div>
                                    </div>


                                    
                                <div class="row">
                                         <div class="form-group col-md-4 mt-2">
                                    <h5><b>Assets Name</b></h5>
                                    <select name="assets_id" id="assets_id" class="form-control select2" onchange="get_mis_report();get_area_list();">
                                        <option value=""> Select Assets </option>
                                        <?php 
                                        if (!empty($assets_list))
                                        {
                                            foreach ($assets_list as $key => $value)
                                            {
                                                ?>
                                                    <option value="<?php echo $value['id']; ?>"><?php echo $value['assets_name']; ?></option>

                                                <?php
                                            }
                                        }

                                        ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-4 mt-2">
                                    <h5><b>Area Name</b></h5>
                                    <select name="area_id" id="area_id" class="form-control select2" onchange="get_mis_report();get_sitelist();">
                                        <option value=""> Select </option>
                                        
                                    </select>
                                </div>

                                <div class="form-group col-md-4 mt-2">
                                    <h5><b>Site Name</b></h5>
                                    <select name="site_id" id="site_id" class="form-control select2" onchange="get_mis_report();get_well_list();">
                                        <option value=""> Select Site </option>
                                        
                                    </select>
                                </div>

                                <div class="form-group col-md-4 mt-2">
                                    <h5><b>Well Name</b></h5>
                                    <select name="well_id" id="well_id" class="form-control select2" onchange="get_mis_report();">
                                        <option value=""> Select </option>
                                        
                                    </select>
                                </div>

                                <div class="form-group col-md-4 mt-2">
                                    <h5><b>From Date</b></h5>
                                    <input type="date" name="from_date" id="from_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" onchange="get_mis_report();get_misdate();">
                                </div>

                                <div class="form-group col-md-4 mt-2">
                                    <h5><b>To Date</b></h5>
                                    <input type="date" name="to_date" id="to_date" class="form-control" value="<?php echo date('Y-m-d'); ?>"  onchange="get_mis_report();get_misdate();">
                                </div>
                                
                            </div>

                             <div class="table-responsive mt-4">
                                <table class="table table-bordered border-bottom table-striped" id="data-table">
                                      <thead style="background-color:blue; color: white; text-align: center;">
                                        <tr>
                                           <th colspan="10" class="text-uppercase" style="font-size: 20px;font-weight: bolder;">IOT BASED REAL TIME WELL MONITORING SYSTEM ONGC,CAMBAY ASSET </th>
                                        </tr>
                                        <tr>
                                            <th colspan="10" class="text-uppercase" style="font-size: 15px;font-weight: bolder;">MIS Report as on <span id="show_from_date"></span> <span id="to">To</span> <span id="show_to_date"></span></th>
                                        </tr>
                                        <tr>
                                            <th style="width:10%;">Sl No.</th>
                                            <th>Area Name</th>
                                            <th>Site Name</th>
                                            <th>Well Name</th>
                                            <th>Device Name</th>
                                            <th>IMEI No</th>
                                            <th>Installed Date</th>
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
        get_misdate();
    function get_misdate()
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
    
    
    function get_area_list()
    {
        let company_id = "<?php echo $this->session->userdata('company_id') ?>";
        let assets_id = $('#assets_id').val();
        // alert(assets_id);
         $.ajax({
            url: '<?php echo base_url(); ?>Mis_report_c/get_area_list',
            type: 'POST',
            data: {company_id:company_id,assets_id: assets_id},
            success:function(res)
            {
                response = JSON.parse(res);
                console.log(response);
                if(response.data.length>0)
                {
                    $('#area_id').html('<option value="">Select Area</option>');
                    $.each(response.data,function(i,v){
                        $('#area_id').append('<option value="'+v.id+'">'+v.area_name+'</option>');
                    });
                }
            }
        });
    }

    function get_sitelist()
    {
        let company_id = "<?php echo $this->session->userdata('company_id') ?>";
        let assets_id = $('#assets_id').val();
        let area_id = $('#area_id').val();
        // alert(area_id);
         $.ajax({
            url: '<?php echo base_url(); ?>Mis_report_c/get_site_list',
            type: 'POST',
            data: {company_id:company_id,area_id: area_id,assets_id:assets_id},
            success:function(res)
            {
                response = JSON.parse(res);
                console.log(response);
                if(response.data.length>0)
                {
                    $('#site_id').html('<option value="">Select site</option>');
                    $.each(response.data,function(i,v){
                        $('#site_id').append('<option value="'+v.id+'">'+v.well_site_name+'</option>');
                    });
                }
            }
        });
    }

    function get_well_list()
    {
        let company_id = "<?php echo $this->session->userdata('company_id') ?>";
        let assets_id = $('#assets_id').val();
        let area_id = $('#area_id').val();
        let site_id = $('#site_id').val();
        // alert(area_id);
         $.ajax({
            url: '<?php echo base_url(); ?>Mis_report_c/get_well_list',
            type: 'POST',
            data: {company_id:company_id,area_id: area_id,assets_id:assets_id,site_id:site_id},
            success:function(res)
            {
                response = JSON.parse(res);
                console.log(response);
                if(response.data.length>0)
                {
                    $('#well_id').html('<option value="">Select Well</option>');
                    $.each(response.data,function(i,v){
                        $('#well_id').append('<option value="'+v.id+'">'+v.well_name+'</option>');
                    });
                }
            }
        });
    }
</script>

<script type="text/javascript">
    
get_mis_report();
function get_mis_report()
{
    let company_id = "<?php echo $this->session->userdata('company_id') ?>";
    let assets_id = $('#assets_id').val();
    let area_id = $('#area_id').val();
    let site_id = $('#site_id').val();
    let well_id = $('#well_id').val();
    let from_date = $('#from_date').val();
    let to_date = $('#to_date').val();

    $.ajax({
        url:'<?php echo base_url(); ?>Mis_report_c/get_mis_report',
        method:'POST',
        data:{company_id:company_id,from_date:from_date,to_date:to_date,assets_id:assets_id,area_id:area_id,site_id:site_id,well_id:well_id},
        success:function(res)
        {
            var response = JSON.parse(res);
            console.log(response);
            if(response.response_code==200)
                {
                    $('#table_data').html("");
                     if(response.data.length > 0)
                     {
                        

                        $.each(response.data,function(i,v){
                            var device_name = v.device_name != null ? v.device_name :"NA";
                            var imei_no = v.imei_no != null ? v.imei_no :"NA";
                            $("#table_data").append('<tr>'+
                                    '<td>'+(i+1)+'</td>'+
                                    '<td>'+v.area_name+'</td>'+
                                    '<td>'+v.well_site_name+'</td>'+
                                    '<td>'+v.well_name+'</td>'+
                                    '<td>'+device_name+'</td>'+
                                    '<td>'+imei_no+'</td>'+
                                    '<td>'+moment(v.date_of_installation).format('DD-MM-YYYY h:mm:ss a')+'</td>'+
                                    
                                '</tr>');
                        });
                     }
                     else{
                        $('#table_data').html('<tr>'+
                                 '<td class="text-danger" style="text-align:center;" colspan="10">No Record Found !!</td>'+
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
      var fileName = "mis report.xlsx";
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
    
     setInterval(()=>{
        get_mis_report();
    },30000);
</script>

                

                

