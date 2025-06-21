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
                                    <button class="btn btn-sm  btn-success" onclick="export_report();">Export</button>
                                    <button class="btn btn-sm  btn-primary" onclick="printPage('data-table');">PDF</button>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                                <div class="form-group col-md-4 mt-2">
                                    <h5><b>Area Name</b></h5>
                                    <select name="site_id" id="site_id" class="form-control select2" onchange="device_performance_list();">
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
                                     <select class="form-control select2" name="month" id="month" onchange="device_performance_list();">
                                        <?php
                                        $user_type = $this->session->userdata('user_type', true);
                                        $role_type = $this->session->userdata('role_type', true);
                                        if ($user_type == 3) 
                                        {
                                            echo '<option value="">Select</option>';
                                            for ($x = 1; $x <= 12; $x++) 
                                            {
                                                $month_num = sprintf("%02d", $x);
                                                $month_name = date('F', mktime(0, 0, 0, $x, 1));
                                                if ($x == date('n')) {
                                                    continue;
                                                }
                                                echo '<option value="' . $month_num . '" ';
                                                if ($x == date('n') - 1) {
                                                    echo 'selected';
                                                }
                                                echo '>' . $month_name . '</option>';
                                            }
                                        } else {
                                           echo '<option value="">Select</option>';
                                            for ($x = 1; $x <= 12; $x++) 
                                            {
                                                $month_num = sprintf("%02d", $x);
                                                $month_name = date('F', mktime(0, 0, 0, $x, 1));
                                                echo '<option value="' . $month_num . '" ';
                                                if ($x == date('n') - 1) {
                                                    echo 'selected';
                                                }
                                                echo '>' . $month_name . '</option>';
                                            }
                                        }
                                        ?>

                                        </select>
                                 </div>
                                 <div class="form-group col-md-4 mt-2">
                                   <h5><b>Year</b></h5>
                                    <select class="form-control select2" name="year" id="year" onchange="device_performance_list();">
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
            <div class="row" >
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive mt-4" id="data-table">
                                <table class="table table-bordered border-bottom">
                                    <thead class="bg-light text-center">
                                        <tr>
                                           <th colspan="12" class="" style="font-size: 18px;font-weight: bolder;">Hiring of IoT based SRP wells online monitoring services for a period of three
                                            years for Cambay Asset <br> awarded vide GEMC-511687710464918 dated 21.12.2023 to M/s iOTAS Solutions Pvt. Ltd.     
                                           </th>
                                        </tr>
                                        <tr>
                                            <th colspan="12" class="text-uppercase" style="font-size: 15px;font-weight: bolder;" id="details_heading"></th>
                                        </tr>
                                    </thead>
                                </table>
                                <table class="table table-bordered border-bottom table-responsive">

                                        <tr>
                                            <th colspan ="12">Sample generated per minute per panel-01 no.</th>
                                        </tr>
                                        <tr>
                                            <th colspan ="12">Field:- <span id="selected_site_name"></span></th>
                                        </tr>
                                        <tr>
                                             <th colspan ="4"></th>
                                             <th colspan="1" class="text-center">Samples not <br>recorded due <br>to ONGC reason</th>
                                             <th  colspan="5"></th>
                                        </tr>
                                        <tr class="text-center">
                                            <th>SL No.</th>
                                            <th>Well Name</th>
                                            <!-- <th>Device No.</th> -->
                                            <th>Running Hours</th>
                                            <th>Baseline Samples</th>
                                            <th>Power Supply <br>Not Available</th>
                                            <!-- <th>Idle/Faulty SRP Unit</th> -->
                                            <th>Eligible baseline<br> samples</th>
                                            <th>Actual samples</th>
                                            <th>% Data Availablity</th>
                                            <th>No of days <br> where device/network<br> not connected for  <br>  more than <br>1 Hr in single <br>  stretch</th>
                                            <th>Remarks</th>
                                        </tr>
                                        <tbody class="text-center" id="table_data">   
                                        <tr>
                                            <th colspan ="12" style="text-align: right; font-size: 12px;height:50px;">Sign of Installation Manager</th>
                                        </tr>
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
<script type="text/javascript">
    device_performance_list();
    function device_performance_list() {
    $('#table_data').html('<tr><td colspan="12">processing please wait.......</td></tr>');
    var site_id = $('#site_id').val();
    var month = $('#month').val();
    var year = $('#year').val();

    var selectedsiteName = $('#site_id option:selected').text();
    var monthName = $('#month option:selected').text();


    let headingText = ` Monthly Device Availablity Report For ${monthName}-${year}     `;
     $('#details_heading').text(headingText);
    $.ajax({
        url: '<?php echo base_url(); ?>Device_billing_repot_c/get_device_details_report',
        method: 'POST',
        data: { site_id:site_id,month:month,year:year },
        success: function (res) {
            var response = JSON.parse(res);
             console.log('sgdg',response);
            if (response.response_code == 200) {
                var count = 0; // declare a count variable
                $('#table_data').html("");
                if (response.data.length > 0) { 
                     var prev_device_name = null;
                    var totalbaseline = 0;
                    var totalpower_not_available = 0;
                    var totalfaulty_srp = 0;
                    var totaleligible = 0;
                    var totalactual = 0;
                    var total_network =0;
                    var avg_availability = 0;
                    var Avg_Aval = 0;
                    var final_avaiability = 0;
                    $('#selected_site_name').text(selectedsiteName);
                    $.each(response.data, function (i, v) {

                        var baseline = v.baseline;
                        totalbaseline += parseFloat(baseline);

                        var power_not_available = v.power_not_available;
                        totalpower_not_available += parseFloat(power_not_available);

                        var faulty_srp = v.faulty_srp;
                        totalfaulty_srp += parseFloat(faulty_srp);

                        var  eligible_sample = v.eligible_sample;
                        totaleligible += parseFloat(eligible_sample);
                        if(v.actual_sample > 0)
                        {
                            var availability =  (v.actual_sample/eligible_sample*100).toFixed(2);
                        }else{
                            var availability = 0;
                        }
                       

                        avg_availability += parseFloat(availability);
                        var actual_sample = v.actual_sample;
                        totalactual += parseFloat(actual_sample);

                        var network_not_connected_day = v.network_not_connected_day;
                        total_network += parseFloat(network_not_connected_day);

                        // var Avg_Aval = (avg_availability/response.data.length).toFixed(2);
                        //  final_avaiability = parseFloat(Avg_Aval);


                         var total_hours_running = parseInt(v.running_minutes);
                        
                         var running_hours = Math.floor(total_hours_running / 60);
                         var runningminutes = total_hours_running % 60;
                         var running_duration = running_hours + ' Hrs ' + runningminutes + ' Mins';

                          
                        if (v.device_name != prev_device_name) {
                        $("#table_data").append('<tr>' +
                            '<td>'+(++count)+'</td>'+
                            '<td>' + v.well_name + '</td>' +
                            // '<td>' + v.device_name+ '</td>' +
                            '<td>' + running_duration+ '</td>' +
                            '<td>' + v.baseline + '</td>' +
                            '<td>' + v.power_not_available + '</td>' +
                            // '<td>' + v.faulty_srp + '</td>' +
                            '<td>' + v.eligible_sample + '</td>' +
                            '<td>' + v.actual_sample + '</td>' +
                            '<td>'+ availability +  '</td>'+
                            '<td>' + v.network_not_connected_day + '</td>' +
                            '<td></td>' +
                            '</tr>');
                   
                     prev_device_name = v.device_name; 
                    } else if (prev_device_name == v.device_name && v.well_status == 0) {
                       
                         //   console.log('device_name',v.device_name);
                         // console.log('prev_device_name',prev_device_name);
                         //  console.log('well_status',v.well_status);
                        var prev_row = $("#table_data tr").last();
                        prev_row.find("td:first").attr("rowspan", function(i, val) {
                            return parseInt(val) + 1;
                        });
                        prev_row.after('<tr>'+
                            '<td colspan="1">-</td>'+
                           '<td>' + v.well_name + '</td>' +
                            // '<td>' + v.device_name+ '</td>' +
                            '<td>' + running_duration+ '</td>' +
                            '<td>' + v.baseline + '</td>' +
                            '<td>' + v.power_not_available + '</td>' +
                            // '<td>' + v.faulty_srp + '</td>' +
                            '<td>' + v.eligible_sample + '</td>' +
                            '<td>' + v.actual_sample + '</td>' +
                            '<td>'+ availability +  '</td>'+
                            '<td>' + v.network_not_connected_day + '</td>' +
                            '</tr>');
                    }else{
                         $("#table_data").append('<tr>' +
                            '<td>'+(++count)+'</td>'+
                            '<td>' + v.well_name + '</td>' +
                            // '<td>' + v.device_name+ '</td>' +
                            '<td>' + running_duration+ '</td>' +
                            '<td>' + v.baseline + '</td>' +
                            '<td>' + v.power_not_available + '</td>' +
                            // '<td>' + v.faulty_srp + '</td>' +
                            '<td>' + v.eligible_sample + '</td>' +
                            '<td>' + v.actual_sample + '</td>' +
                            '<td>'+ availability +  '</td>'+
                            '<td>' + v.network_not_connected_day + '</td>' +
                            '<td></td>' +
                            '</tr>');
                    }
                });

                    var final_avaiability = (totalactual  / totaleligible  *100).toFixed(2);
            
                     $("#table_data").append('<tr>' +
                        '<td colspan="3" style="text-align:right;"><b>Total</b></td>' +
                        '<td><b>' + totalbaseline + '</b></td>' +
                       '<td><b>' + totalpower_not_available + '</b></td>' +
                       // '<td><b>' + totalfaulty_srp + '</b></td>' +
                       '<td><b>' + totaleligible + '</b></td>' +
                       '<td><b>' +totalactual+'</b></td>'+
                       '<td><b> Avg '  +final_avaiability+ '</b></td>'+
                       '<td><b>' +total_network+'</b></td>'+
                        '<td></td>' +
                        '</tr>'
                        );

                  
                } else {
                    $('#table_data').html('<tr>' +
                        '<td class="text-danger" style="text-align:center;" colspan="12">No Record Found !!</td>' +
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
        var ws = XLSX.utils.table_to_sheet(table, {
            raw: true
        });

        Object.keys(ws).forEach(cell => {
            if (cell[0] !== '!') {
                ws[cell].t = 's'; 
            }
        });

        var wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, sheetName);

     
        XLSX.writeFile(wb, fileName);
    }

</script>
 <style>
    @media print {
       
        @page {
            size: A4 landscape; 
        }

        table {
            width: 100%;
            font-size: 10px;
        }

        th, td {
            padding: 4px;
            word-wrap: break-word;
        }
        .btn, .non-printable {
            display: none;
        }
    }
</style>


<script>
function printPage(sectionId) {
    var printContents = document.getElementById(sectionId).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
    location.reload();
}

</script>