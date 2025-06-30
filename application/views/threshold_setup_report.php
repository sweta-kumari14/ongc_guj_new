<div class="page-wrapper">
    <div class="content container-fluid pb-0">
       
            <div class="row" style="    margin-top: -21px;">                   
                        <!-- Lightbox -->
                        <div class="col-lg-12">
                            <div class="card">
                               
                                <div class="card-body">
                                               <div class="row align-items-center justify-content-between mb-3">
                <div class="col-md-6">
                    <h4 class="header-title mb-0"><b>Threshold-Report</b></h4>
                </div>
                <div class="col-md-6 text-end">
                    <button class="btn btn-success btn-sm btn-rounded" onclick="export_report()" style="font-size: 14px;">
                        Export
                    </button>
                </div>
            </div>

<hr>
                                    
                                <div class="row">
                                    <div class="form-group col-md-4 mt-2">
                                    <h5><b>Well No</b></h5>
                                    <select name="well" id="well_single" class="form-control select2">
                                        <option value="">Select Well</option>
                                        <?php 
                                        if (!empty($well_list)) {
                                            foreach ($well_list as $value) {
                                                echo '<option value="' . $value['well_id'] . '">' . $value['well_name'] . '</option>';
                                            }
                                        }
                                        ?>
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
                                           <th colspan="11" class="text-uppercase" style="font-size: 20px;font-weight: bolder;">IOT BASED REAL TIME WELL MONITORING SYSTEM ONGC,CAMBAY ASSET </th>
                                        </tr>
                                        <tr>
                                            <th colspan="14" class="text-uppercase" style="font-size: 15px;font-weight: bolder;" id="report-heading"></span> Threshold  Report as on <span id="show_from_date"></span><span id="to">To</span> <span id="show_to_date"></span></th>
                                        </tr>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Well Name</th>
                                            <th>Upper CHP</th>
                                            <th>Lower CHP</th>
                                            <th>Upper THP</th>
                                            <th>Lower THP</th>
                                            <th>Upper ABP</th>
                                            <th>Lower ABP</th>
                                            <th>Upper THT</th>
                                            <th>Lower THT</th>
                                            <th>Site</th>
                                            <th>Setup time</th>     
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
    
get_mis_report();
function get_mis_report()
{
   
    let well_id = $('#well_id').val();
    let from_date = $('#from_date').val();
    let to_date = $('#to_date').val();

    var selectedimeiNo = $('#well_id option:selected').text();

    let formattedFromDate = moment(from_date, 'YYYY-MM-DD').format('DD-MM-YYYY');
    let formattedToDate = moment(to_date, 'YYYY-MM-DD').format('DD-MM-YYYY');



      let headingText = ` (${selectedimeiNo} )MIS Report of ${formattedFromDate} to ${formattedToDate}`;
     $('#report-heading').text(headingText);

    $.ajax({
        url:'<?php echo base_url(); ?>Threshold_setup_selfflow_c/get_Device_mis_report',
        method:'POST',
        data:{well_id:well_id,from_date:from_date,to_date:to_date,},
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
                            $("#table_data").append('<tr>'+
                                 '<td>'+(i+1)+'</td>'+
                                 '<td>' + v.well_name + '</td>' +
                                 '<td>' + v.well_site_name + '</td>' +
                                   
                                    '<td>'+v.chp_uppar+'</td>'+
                                    '<td>'+v.chp_lower+'</td>'+
                                    '<td>'+v.thp_uppar+'</td>'+
                                    '<td>'+v.thp_lower+'</td>'+
                                    '<td>'+v.abp_uppar+'</td>'+
                                    '<td>'+v.abp_lower+'</td>'+
                                    '<td>'+v.tht_uppar+'</td>'+
                                    '<td>'+v.tht_lower+'</td>'+
                                    '<td>'+moment(v.threshold_setup_date_time).format('DD-MM-YYYY h:mm:ss a')+'</td>'+
                                    
                                '</tr>');
                        });
                     }
                     else{
                        $('#table_data').html('<tr>'+
                                 '<td class="text-danger" style="text-align:center;" colspan="14">No Record Found !!</td>'+
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
      var fileName = "Device mis report.xlsx";
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

                

                

