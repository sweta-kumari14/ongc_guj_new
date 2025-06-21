<div class="page-wrapper">
    <div class="content container-fluid pb-0">
        <div class="page-header">
            <div class="content-page-header">
                <h5>Last 10 Data MIS Report</h5>
            </div>  
        </div>
            <div class="row">                   
                        <!-- Lightbox -->
                        <div class="col-lg-12">
                            <div class="card">
                               
                                <div class="card-body">
                                   <div class="row align-items-center">
                                        <div class="col">
                                           <h4 class="header-title mb-4"><b>Last 10 Data MIS Report</b></h4>
                                        </div>
                                        <div class="col-auto float-end ms-auto">
                                             <button class="btn btn-success btn-sm btn-rounded mx-2" onclick="export_report()" style="font-size: 14px;">Export</button>
                                        </div>
                                    </div>


                                    
                                <div class="row">
                                          <div class="form-group col-md-4">
                                    <label><b>IMEI No</b></label>
                                    <select name="imei_no" id="imei_no" class="form-control select2" onchange="get_last_10_data_table();">
                                        <!-- <option value="">Select Imei No</option> -->
                                        <?php 
                                        if (!empty($imei_list))
                                        {
                                            foreach ($imei_list as $key => $value)
                                            {
                                                ?>
                                                    <option value="<?php echo $value['imei_no']; ?>"><?php echo $value['imei_no']; ?></option>

                                                <?php
                                            }
                                        }

                                        ?>
                                    </select>
                                </div>
                                   
                                    
                            </div>

                             <div class="table-responsive mt-4">
                                <table class="table table-bordered border-bottom table-striped" id="data-table">
                                      <thead style="background-color:blue; color: white; text-align: center;">
                                        <tr>
                                            <th colspan="72" class="text-uppercase" style="font-size: 15px;font-weight: bolder;">Last 10 Data MIS Report as on <?php echo date('d-m-Y h:i:s a') ?></th>
                                        
                                        </tr>
                                        <tr>
                                            <th style="width:10%;">Sl No.</th>
                                            <th>Well No</th>
                                            <th>Imei No</th>
                                            <th>Last Log Datetime</th>
                                            <th>Output Current R</th>
                                            <th>Output Current Y</th>
                                            <th>Output Current B</th>
                                            <th>Avg Output Current</th>
                                            <th>Output Voltage L2N R</th>
                                            <th>Output Voltage L2N Y</th>
                                            <th>Output Voltage L2N B</th>
                                            <th>Avg Output Voltage L2N</th>
                                            <th>Outut Voltage P2P RY</th>
                                            <th>Outut Voltage P2P YB</th>
                                            <th>Outut Voltage P2P BR</th>
                                            <th>Avg Output Voltage P2P</th>
                                            <th>Output Frequency</th>
                                            <th>Output Active Energy</th>
                                            <th>Output Active Power</th>
                                            <th>Battery Voltage</th>
                                            <th>SMPS Voltage</th>
                                            <th>Output Kvah</th>
                                            <th>Output Kvarh</th>
                                            <th>Output System PowerFactor</th>
                                            <th>Output System PowerFactor1</th>
                                            <th>Output Total Kva</th>
                                            <th>Output Total Kvar</th>
                                            <th>Device Last Status</th>
                                            <th>Offline Device Timestamp</th>
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
get_last_10_data_table();
        function get_last_10_data_table()
        {
            $('#table_data').html('<tr><td colspan="72">processing please wait.......</td></tr>');
            
            var imei_no = $('#imei_no').val();
            
            

            $.ajax({
                url:'<?php echo base_url(); ?>Last_10_data_report_c/get_last_10_data_ajax',
                method:'POST',
                data:{imei_no:imei_no},
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
                                            '<td>'+v.well_name+'</td>'+
                                            '<td>'+v.imei_no+'</td>'+
                                            '<td>'+moment(v.last_log_datetime).format('DD-MM-YYYY h:mm:ss a')+'</td>'+
                                            '<td>'+v.output_Current_R+'</td>'+
                                            '<td>'+v.output_Current_Y+'</td>'+
                                            '<td>'+v.output_Current_B+'</td>'+
                                            '<td>'+v.output_Average_Current+'</td>'+
                                            '<td>'+v.output_Voltage_L2N_R+'</td>'+
                                            '<td>'+v.output_Voltage_L2N_Y+'</td>'+
                                            '<td>'+v.output_Voltage_L2N_B+'</td>'+
                                            '<td>'+v.output_Average_Voltage_L2N+'</td>'+
                                            '<td>'+v.output_Voltage_P2P_RY+'</td>'+
                                            '<td>'+v.output_Voltage_P2P_YB+'</td>'+
                                            '<td>'+v.output_Voltage_P2P_BR+'</td>'+
                                            '<td>'+v.output_Average_Voltage_P2P+'</td>'+
                                            '<td>'+v.output_System_Frequency+'</td>'+
                                            '<td>'+v.output_Kwh+'</td>'+
                                            '<td>'+v.output_System_Running_KW+'</td>'+
                                            '<td>'+v.battery_Voltage+'</td>'+
                                            '<td>'+v.smps_Voltage+'</td>'+
                                            '<td>'+v.output_Kvah+'</td>'+
                                            '<td>'+v.output_Kvarh+'</td>'+
                                            '<td>'+v.output_System_PowerFactor+'</td>'+
                                            '<td>'+v.output_System_PowerFactor1+'</td>'+
                                            '<td>'+v.output_Total_Kva+'</td>'+
                                            '<td>'+v.output_Total_Kvar+'</td>'+
                                            '<td>'+v.device_last_status+'</td>'+
                                            '<td>'+moment(v.offline_device_timestamp).format('DD-MM-YYYY h:mm:ss a')+'</td>'+
                                            
                                        '</tr>');
                                });
                             }
                             else{
                                $('#table_data').html('<tr>'+
                                         '<td class="text-danger" style="text-align:center;" colspan="72">No Record Found !!</td>'+
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
      var fileName = "last 10 data raport.xlsx";
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
        get_last_10_data_table();
    },30000);
</script>