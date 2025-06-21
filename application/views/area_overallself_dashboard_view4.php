
<style type="text/css">
    #back_btns {
        font-size: 16px;
        padding: 2px 13px;
    }

    #back_btns i {
        margin-right: -20px;
        position: relative;
        opacity: 0;
        transition: all 0.5s ease-out;
    }

    #back_btns:hover i {
        opacity: 1;
        margin-right: 2px;
    }

    #export_btns {
        font-size: 16px;
        padding: 3px 13px;
    }

    #export_btns i {
        margin-right: -20px;
        position: relative;
        opacity: 0;
        transition: all 0.5s ease-out;
    }

    #export_btns:hover i {
        opacity: 1;
        margin-right: 2px;
    }

    table thead tr th {
        background-color: aliceblue !important;
    }

    .card {
        margin: 20px;
        padding: 0;
    }

    .card-header,
    .card-body {
        padding: 15px 20px;
    }

    .table-responsive {
        overflow-x: auto;
    }

    table {
        min-width: 1800px;
        margin-bottom: 0;
    }

    th, td {
        padding: 8px 12px !important;
        vertical-align: middle;
    }
    table td {
    font-size: 15px; /* You can reduce this to 12px or 11px if needed */
}


    .content.container-fluid {
        padding-left: 5px;
        padding-right: 5px;
    }
    .card-header {
    position: relative;
    padding: 10px 10px;
    background-color: #fff;
    z-index: 1;
}

/* Top border gradient */
.card-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    height: 4px; /* Border thickness */
    width: 100%;
    background: linear-gradient(to right, #032448 20%, #fc6075 100%);
    z-index: 2;
    border-top-left-radius: 0.5rem;
    border-top-right-radius: 0.5rem;
}
</style>

<div class="page-wrapper custome-name" style="margin-top: -20px;">      
        <div class="row">
            <div class="col-12">
                <!-- Card -->
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h5 class="card-title fs-20 mb-0">Rtms Non Functional Wells</h5>
                            </div>
                            <div class="col-md-6 d-flex justify-content-end gap-2">
                                <a href="<?php echo base_url() ?>Selfflow_c" class="btn btn-info btn-sm" id="back_btns">
                                    <i class="fa-solid fa-left-long"></i> Back
                                </a>
                                <button class="btn btn-sm btn-success" onclick="export_report();" id="export_btns">
                                    <i class="fa-solid fa-file-excel"></i>Export
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive mt-2">
                            <table id="datatable" class="table table-bordered dt-responsive nowrap text-center">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Area</th>
                                        <th>Site</th>
                                        <th>Well Type</th>
                                        <th>Well</th>
                                        <th>Installation Status</th>
                                        <th>Installation Date</th>
                                        <th>Last Updated Time</th>
                                        <th>Device Name</th>
                                        <th>Imei No</th>
                                        <th>GIP</th>
                                        <th>CHP</th>
                                        <th>THP</th>
                                        <th>ABP</th>
                                        <th>THT</th>
                                        <th>Battery Voltage</th>
                                        <th>Target Time</th>
                                        <th>On Time</th>
                                        <th>Off Time</th>
                                        <th>Passcode</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center" id="table_body">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /Card -->
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
    
    off_unit_details();

function off_unit_details() {   
    $('#table_body').html('<tr><td colspan="7">Processing please wait.......</td></tr>');

    let company_id = "<?php echo $this->session->userdata('company_id') ?>";
    let user_id = "<?php echo $this->session->userdata('user_id') ?>";
    let area_id = "<?php echo $this->uri->segment(3) ?>";

    $.ajax({
        url: '<?php echo base_url(); ?>Overall_list_selfflow_c/off_unit_ajax',
        method: 'POST',
        data: { company_id: company_id, user_id: user_id, area_id: area_id },
        success: function (res) {
            var response = JSON.parse(res);
             console.log(response); 

            if (response.response_code == 200) {
                $('#table_body').html("");

                if (response.data.non_functional.length > 0) {
                    console.log(response.data.non_functional);
                    
                    $.each(response.data.non_functional, function (i, v) {
                        var output_Average_Current = v.output_Average_Current == null ? "NA" : v.output_Average_Current;
                        var output_Average_Voltage_L2N = v.output_Average_Voltage_L2N == null ? "NA" : v.output_Average_Voltage_L2N;
                        var output_Average_Voltage_P2P = v.output_Average_Voltage_P2P == null ? "NA" : v.output_Average_Voltage_P2P;
                       var Log_Date_Time  = v.Log_Date_Time  == null ? "NA" : moment(v.Log_Date_Time ).format('DD-MM-YYYY h:mm:ss a');

                        var shifted_status = v.device_shifted;
                        var rtms_status = '';

                        var smps_voltage = parseFloat(v.smps_Voltage);
                        var battery_voltage = parseFloat(v.battery_Voltage);

                        // **Status Conditions**
                        if (shifted_status == 0) {  
                            if ((output_Average_Voltage_L2N <= 0 || output_Average_Voltage_P2P <= 0) && battery_voltage < 9)
                            {
                              
                                rtms_status = '<button class="btn btn-sm btn-rounded btn-pill" style="color:white;background-color:#5D6D7E;white-space: nowrap;">Battery Issue</button>';
                            } 
                            else if ((output_Average_Voltage_L2N > 0 || output_Average_Voltage_P2P > 0) || battery_voltage > 0){
                              
                                rtms_status = '<button class="btn btn-sm btn-rounded btn-pill" style="color:white;background-color:#f39c12;white-space: nowrap;">Network Issue</button>';
                            } 
                            else {
                                // Generic Offline
                                rtms_status = '<button class="btn btn-sm btn-rounded btn-pill" style="color:white;background-color:#ce2029;white-space: nowrap;">OFF</button>';
                            }
                        } 
                        else if (shifted_status == 1) {
                            // Shifted Wells
                            rtms_status = '<button class="btn btn-sm btn-rounded btn-pill" style="color:white;background-color:#46C7C7;white-space: nowrap;">Shifted</button>';
                        }

                        // **Table Data Binding**
                       $("#table_body").append('<tr>' +
    '<td>'+(i+1)+'</td>'+
    '<td>'+v.area_name +'</td>'+
    '<td>'+v.well_site_name+'</td>'+
    '<td>'+v.well_type_name+'</td>'+
    '<td>' +'<a style="color: green;" href="SingleWellDashboard/' + v.well_id +'/'+ v.site_id + '/' + v.area_id + '/' + v.well_type+'">' +v.well_name +'</a>' +'</td>'+
    '<td>'+Log_Date_Time+'</td>'+
    '<td>'+(v.device_name != null ? v.device_name : "")+'</td>'+
    '<td>'+(v.imei_no != null ? v.imei_no : "")+'</td>'+
    '<td>'+(v.PS_1_GIP != null ? v.PS_1_GIP : "")+'</td>'+
    '<td>'+(v.PS_2_CHP != null ? v.PS_2_CHP : "")+'</td>'+
    '<td>'+(v.PS_3_THP != null ? v.PS_3_THP : "")+'</td>'+
    '<td>'+(v.PS_4_ABP != null ? v.PS_4_ABP : "")+'</td>'+
    '<td>'+(v.FLTP_1_Temp != null ? v.FLTP_1_Temp : "")+'</td>'+
    '<td>'+(v.Battery_Voltage != null ? v.Battery_Voltage : "")+'</td>'+
    '<td>'+(v.TRGT_Time != null ? v.TRGT_Time : "")+'</td>'+
    '<td>'+(v.ON_Time != null ? v.ON_Time : "")+'</td>'+
    '<td>'+(v.Off_Time != null ? v.Off_Time : "")+'</td>'+
    '</tr>'
);

                    });

                }else {
                    $('#table_body').html(`
                        <tr>
                            <td class="text-danger" style="text-align:center;" colspan="12">No Record Found !!</td>
                        </tr>
                    `);
                }
            }
        }
    });
}

</script>>



<script src="<?php echo base_url(); ?>assets/local/excel/xlsx.full.min.js"></script>
<script type="text/javascript">
    
    function export_report() {
      var sheetName = "Sheet1";
      var fileName = "Well Not Functional RTMS List.xlsx";
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
