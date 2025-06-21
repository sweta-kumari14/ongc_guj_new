<div class="page-wrapper">
    <div class="content container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Device Performance Report</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard_c');?>">Dashboard</a></li>
                            <li class="breadcrumb-item ">Device Performance Report</li>
                            
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row row-sm">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h3><b>Device Performance Report</b></h3>
                            </div>
                            <div class="col-md-6 d-md-flex justify-content-end">
                                <div>
                                    <button class="btn btn-sm  btn-success" onclick="export_well_wise_report();">Export</button>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                                <div class="form-group col-md-4 mt-2">
                                    <h5><b>Area Name</b></h5>
                                    <select name="site_id" id="site_id" class="form-control select2" onchange="device_details_monthly();">
                                       <?php
                                    $user_type = $this->session->userdata('user_type', true);
                                    $role_type = $this->session->userdata('role_type',true);
                                   if ($user_type == 3 && $role_type == 2) {
                                       if (!empty($site_list)) {
                                            
                                            foreach ($site_list as $key => $value) {
                                                ?>
                                                <option value="<?php echo $value['id']; ?>"> <?php echo $value['well_site_name']; ?></option>
                                                <?php
                                            }
                                        }
                                    } else {
                                        if (!empty($site_list)) {
                                            echo '<option value="">All Area</option>'; 
                                            foreach ($site_list as $key => $value) {
                                                ?>
                                                <option value="<?php echo $value['id']; ?>"> <?php echo $value['well_site_name']; ?></option>
                                                <?php
                                            }
                                        }
                                    }
                                    ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-4 mt-2">
                                   <h5><b>Month</b></h5>
                                       <select class="form-control select2" name="month" id="month" onchange="device_details_monthly();generateTableHeaders();">
                                          <option value="">Select</option>
                                          <?php
                                          for ($x = 1; $x <= 12; $x++) {
                                            $month_num = sprintf("%02d", $x);
                                            $month_name = date('F', mktime(0,0,0,$x,1));
                                            // $month_name = date('F', mktime(0,0,0,$x));
                                            echo '<option value="'.$month_num.'" ';
                                            if ($x == date('n') - 1) {
                                              echo 'selected';
                                            }
                                            echo' >'.$month_name.'</option>';
                                          }
                                          ?>
                                        </select>
                                 </div>
                                 <div class="form-group col-md-4 mt-2">
                                   <h5><b>Year</b></h5>
                                    <select class="form-control select2" name="year" id="year" onchange="device_details_monthly();generateTableHeaders();">
                                     <option>Select</option>
                                      <?php
                                                    $current_year = date('Y');
                                                    for($i= $current_year - 3; $i < $current_year +3; $i++) {
                                                         echo '<option value="'.$i.'"';
                                                         if( $i ==  $current_year ) {
                                                                echo ' selected="selected"';
                                                         }
                                                         echo ' >'.$i.'</option>';
                                                     }               
                                                     echo '<select>';
                                                    ?>
                                   
                                    </select>
                                </div>
                            </div>
                    </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive mt-4">
                                <table class="table table-bordered border-bottom" id="well_wise_table_export">
                                    <thead class="bg-light text-center">
                                        <tr>
                                            <th colspan="42" class="" style="font-size: 20px;font-weight: bolder;">iOTAS Solutions Pvt Ltd</th>
                                        </tr>
                                        <tr>
                                            <th colspan="42" class="text-uppercase" style="font-size: 15px;font-weight: bolder;" id ='details_heading'></th>
                                        </tr>
                                        <thead  class="text-center">
                                             <tr id="tableHeaders" style="display:none;"></tr>
                                        </thead>
                                         <tbody id="tableBody"></tbody>
                                        <tbody class="text-center" id="device_available_data">               
                                       </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>


        </div>

    

<?php
if ($this->session->flashdata('success') != '') {
?>
    <script type="text/javascript">
        $(document).ready(function() {
            var msg = "<?php echo $this->session->flashdata('success'); ?>";
            swal(msg, "", "success");
        });
    </script>
<?php
}
if ($this->session->flashdata('error') != '') {
?>
    <script type="text/javascript">
        $(document).ready(function() {
            var msg = "<?php echo $this->session->flashdata('error'); ?>";
            swal(msg, "", "error");
        });
    </script>
<?php
}
?>
<script>
    function generateTableHeaders() {
        var selected_month = parseInt(document.getElementById('month').value);
        var selected_year = parseInt(document.getElementById('year').value);
        var num_days = new Date(selected_year, selected_month, 0).getDate();

        var tableHeaders = '';
        for (var i = 1; i <= num_days; i++) {
            tableHeaders += '<th>' + i + '</th>';
        }

        document.getElementById('tableHeaders').innerHTML = tableHeaders; 

      
        generateTableBody(num_days);
    }

    document.getElementById('month').addEventListener('change', generateTableHeaders);
    document.getElementById('year').addEventListener('change', generateTableHeaders);

  function generateTableBody(num_days) 
  {
    var tableBody = document.getElementById('tableBody');
    tableBody.innerHTML = '';

        var row = '<tr>' +
            '<td>Sl No.</td>' +
            '<td>Well Name</td>' +
            '<td>Date of Installation/Replacement/Shifting</td>' +
            '<td>Device Name</td>';

        for (var j = 1; j <= num_days; j++) {
            row += '<td>' + j + '</td>';
        }


        row += '<td>Days</td>' +
            '<td>Record on server</td>' +
            '<td>Record To Be</td>' +
            '<td>% Device Availablity</td>' +
            '<td>Avg</td>' +
            '<td>Remarks</td>' +
            '</tr>';

        tableBody.innerHTML = row;
    }

generateTableHeaders();

</script>

<script type="text/javascript">
    device_details_monthly();
    function device_details_monthly() 
    {
    $('#device_available_data').html('<tr><td colspan="42">Processing please wait.......</td></tr>');
    var site_id = $('#site_id').val();
    var month = $('#month').val();
    var year = $('#year').val();
    var selectedsiteName = $('#site_id option:selected').text();
    var monthName = $('#month option:selected').text();
    let headingText = `Monthly Device availablity Report Month Of ${monthName} ${year} , ${selectedsiteName} , Cambay  `;
    $('#details_heading').text(headingText);

    $.ajax({
        url: '<?php echo base_url(); ?>Device_billing_repot_c/Device_billing_repot_data',
        method: 'POST',
        data: {site_id:site_id,month:month,year:year},
        success: function (res) {
            var response = JSON.parse(res);

            if (response.response_code == 200) {
                console.log(response);
                 $('#device_available_data').html("");

               
                if (response.data.length > 0)
                {
                    $.each(response.data, function(i, v) {
                        let totalLogCount = 0; 
                        let recorde_to_be = 0;
                        let device_availablity = 0;
                        let avg_availability = 0;

                       recorde_to_be = v.log.length *1440;

                        let row = '<tr>' +
                            '<td>' + (i + 1) + '</td>' +
                            '<td>' + v.well_name + '</td>' +
                            '<td>' + v.installation_date +   '&nbsp; (Installed)</td>' +
                            '<td>' + v.device_name + '</td>';

                        for (let j = 0; j < v.log.length; j++) {
                            row += '<td>' + v.log[j].count + '</td>';
                            
                            totalLogCount += parseInt(v.log[j].count);
                        }

                          device_availablity = (totalLogCount*100/recorde_to_be).toFixed(2);
                            avg_availability += parseFloat(device_availablity);

                         row += '<td>' + v.log.length + '</td>'; 
                         row += '<td>' + totalLogCount + '</td>';
                         row += '<td>' + recorde_to_be + '</td>'; 
                         row += '<td>' + device_availablity+ '</td>';
                         row += '<td>'+avg_availability+'</td>';
                           row += '<td></td>';

                        row += '</tr>';

                        $("#device_available_data").append(row);

                            if (v.replacement_records && v.replacement_records.length > 0) 
                            {
                              $.each(v.replacement_records, function(ir,vr) 
                              {
                                let totalLogCount = 0; 
                                let recorde_to_be = 0;
                                let device_availablity = 0;
                                let avg_availability = 0;

                               recorde_to_be = v.log.length *1440;

                                let row = '<tr>' +
                                    '<td></td>' +
                                    '<td>' + vr.well_name + '</td>' +
                                    '<td>' + vr.replace_date +  '&nbsp; (Replaced)</td>' +
                                    '<td>' + vr.device_name + '</td>';

                                for (let j = 0; j < vr.log.length; j++) {
                                    row += '<td>' + vr.log[j].count + '</td>';
                                    
                                    totalLogCount += parseInt(vr.log[j].count);
                                }

                                  device_availablity = (totalLogCount*100/recorde_to_be).toFixed(2);
                                    avg_availability += parseFloat(device_availablity);

                                 row += '<td>' + v.log.length + '</td>'; 
                                 row += '<td>' + totalLogCount + '</td>';
                                 row += '<td>' + recorde_to_be + '</td>'; 
                                 row += '<td>' + device_availablity+ '</td>';
                                 row += '<td>'+avg_availability+'</td>';
                                   row += '<td></td>';

                                row += '</tr>';

                                $("#device_available_data").append(row);
                
                              });
                            }
                        });

                } else {
                    $('#device_available_data').html('<tr>' +
                        '<td class="text-danger" style="text-align:center;" colspan="42">No Record Found !!</td>' +
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
	  var fileName = "Device Performance Report.xlsx";
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
