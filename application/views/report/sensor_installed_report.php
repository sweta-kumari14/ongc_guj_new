<div class="page-wrapper">
    <div class="content container-fluid pb-0">

    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header mb-0" style="padding: 8px;">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="mb-1">Sensor Installation Details</h4>
                        </div>
                        <div class="col-auto ms-auto d-flex gap-2">
                            <button type="button" id="export_btns" onclick="export_report()" class="btn btn-sm btn-primary motion-btn">
                                <i class="fas fa-file-export me-1" style="font-size: 12px;"></i> Export</button>
                        </div>
                    </div>
                </div>
                 

                <div class="row m-2" style="margin: 1.5rem !important;">
                    <div class="col-md-3">
                        <label class="form-label">Well Name</label>
                        <select name="well_id" id="well_id" class="form-control select2" onchange="get_wellwise_sensor_details_report();">
                            <option value=""> Select Well </option>
                            <?php 
                            if (!empty($well_list))
                            {
                                foreach ($well_list as $key => $value)
                                {
                                    ?>
                                        <option value="<?php echo $value['well_id']; ?>"><?php echo $value['well_name']; ?></option>

                                    <?php
                                }
                            }

                            ?>
                        </select>
                    </div>
                     <div class="col-md-3">
                        <label class="form-label">Component Name</label>
                        <select name="component_id" id="component_id" class="form-control select2" onchange="get_wellwise_sensor_details_report();">
                            <option value=""> Select Component </option>
                            <?php 
                            if (!empty($component_list))
                            {
                                foreach ($component_list as $key => $value)
                                {
                                    ?>
                                        <option value="<?php echo $value['id']; ?>"><?php echo $value['component_name']; ?></option>

                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                         <label for="example-select" class="form-label">From Date</label>
                        <input type="date" name="from_date" id="from_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" onchange="get_wellwise_sensor_details_report();get_installation_date();">
                    </div>
                    <div class="col-md-3">
                         <label for="example-select" class="form-label">To Date</label>
                        <input type="date" name="to_date" id="to_date" class="form-control" value="<?php echo date('Y-m-d'); ?>"  onchange="get_wellwise_sensor_details_report();get_installation_date();">
                    </div>
                </div>

               <div class="card-body mt-1">
                    <div class="table-responsive">
                         <table class="table datatable border 0" id="alertData">
                            <thead class="table-secondary text-center">
                               
                                <tr style="border-bottom: 1px solid #C5D3E8;">
                                    <th colspan="6" class="text-uppercase text-center" style="font-size: 15px; font-weight: bolder; color: #843534;">
                                        Sensor Installation Details as on <span id="show_from_date"></span> <span id="to">To</span> <span id="show_to_date"></span>
                                    </th>
                                </tr>
                                <tr>
                                    <th>SL.No.</th>
                                    <th>Well name</th>
                                    <th>Component Name</th>
                                    <th>Tag Number</th>
                                    <th>From Date</th>
                                    <th>To Date</th>
                                </tr>
                            </thead>

                            <tbody id="table_data" class="text-center">
                                
                            </tbody>
                        </table>
                    </div>   
                </div>
            </div>
        </div>
    </div>
</div>                   

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>

<script type="text/javascript">
    get_installation_date();
    function get_installation_date()
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

    get_wellwise_sensor_details_report();
    function get_wellwise_sensor_details_report() {
        $('#table_data').html('<tr ><td class="text-center text-danger" colspan="6">processing please wait.......</td></tr>');
        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();
        var well_id = $('#well_id').val();
        var component_id = $('#component_id').val();
    // alert(well_id);
        var base_url = '<?php echo base_url();?>';

            $.ajax({
                url: '<?php echo base_url(); ?>reports/Sensor_installed_report_c/get_sensor_installed_report',
                method: 'POST',
                data: { from_date: from_date, to_date: to_date, well_id: well_id,component_id:component_id},
                success: function (res) {
                    var response = JSON.parse(res);
              
                    if (response.response_code == 200) {
                        $('#table_data').html("");
                        if (response.data.length > 0) {
                            
                            $.each(response.data, function (i, v) {
                                
                               
                                var start_date_time  = v.from_date_time != null ? moment(v.from_date_time).format('DD-MM-YYYY h:mm:ss a') :"NA";
                                 var end_date_time  = v.to_date_time != null ? moment(v.to_date_time).format('DD-MM-YYYY h:mm:ss a') :"NA";

                                $("#table_data").append('<tr>' +
                                    '<td>' + (i + 1) + '</td>' +
                                    '<td>' + (v.well_name ? v.well_name  : 'NA')  + '</td>' +
                                    '<td>' + (v.component_name ? v.component_name  : 'NA')  + '</td>' +
                                    '<td>' + (v.sensor_no ? v.sensor_no  : 'NA') + '</td>' +
                                    '<td>' + start_date_time + '</td>' +
                                    '<td>' + end_date_time + '</td>' +
                                '</tr>');

                            });

                           
                        } else {
                            $('#table_data').html(`<tr>
                                <td colspan="6" class="text-center">
                                    <div class="mt-3">
                                        <img src="<?php echo base_url(); ?>assets/images/no_records.svg" width="100">
                                        <p class="text-danger mt-2 fw-bold">No Record Found !!</p>
                                    </div>
                                </td>
                            </tr>
                          `);
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
      var fileName = "Sensor Installated report.xlsx";
      var table = $("sensordata")[0];
      // Convert table to worksheet
      var ws = XLSX.utils.table_to_sheet(table);
      // Create a new workbook and add the worksheet to it
      var wb = XLSX.utils.book_new();
      XLSX.utils.book_append_sheet(wb, ws, sheetName);
      // Save the workbook as an Excel file and download it
      XLSX.writeFile(wb, fileName);
    }

</script>
         

                


    </div>
</div>