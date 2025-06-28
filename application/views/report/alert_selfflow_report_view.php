
<div class="page-wrapper">
<!-- Page Content -->
    <div class="content container-fluid">
    
            <div class="row row-sm">
                <div class="col-lg-12">
                    <div class="card">
                      <div class="card-body" style="padding:6px;">
    <div class="row align-items-center mb-3">
        
        <!-- Left side: Heading -->
        <div class="col-md-6 d-flex align-items-center ps-3">
            <h3 class="m-0" style="font-size:20px; margin-top:4px">Alert Log Report</h3>
        </div>

        <!-- Right side: Buttons -->
        <div class="col-md-6 d-flex justify-content-end align-items-center">
            <div class="d-flex gap-2 flex-wrap align-items-center">
                <button id="well_wise_export" class="btn btn-sm btn-success" onclick="export_well_wise_report();" style="display: none;">Export</button>
                <button id="date_wise_export" class="btn btn-sm btn-success" onclick="export_date_wise_report();" style="display: none;">Export</button>
                <button id="well_wise_pdf" class="btn btn-sm btn-primary" onclick="printWell();" style="display: none;">PDF</button>
                <button id="date_wise_pdf" class="btn btn-sm btn-primary" onclick="printDate();" style="display: none;">PDF</button>
                <a href="Dashboard_c">
                    <button class="btn btn-sm btn-primary">Back</button>
                </a>
            </div>
        </div>

    </div>
</div>


                        <hr style="margin-top: -10px;">

                                                                <div class="card-body" style=" margin-top: -19px;">
                                                                    <div class="row">
                                                                        <div class="form-group col-md-4">
                                            <label for="report_view" class="form-label"><b>View Report</b></label>
                                            <select name="report_view" id="report_view" class="form-control select2" onchange="get_view();" style="width: 100%;">
                                                <option value=""> Select View </option>
                                                <option value="well">Well Wise</option>
                                                <option value="date">Date Wise</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="alert_type" class="form-label"><b>Alert Type</b></label>
                                            <select onchange="get_wellwise_alert_report();" class="form-control select2" id="alert_type" name="alert_type" style="width: 100%;">
                                                <option value="">ALL</option>
                                                <option value="1">Low CHP</option>
                                                <option value="2">High CHP</option>
                                                <option value="3">Low THP</option>
                                                <option value="4">High THP</option>
                                                <option value="5">Low ABP</option>
                                                <option value="6">High ABP</option>
                                                <option value="7">Temp FLT</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4 " >
                                       <label  class="form-label"><b>Area Name</b></labe>
                        <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h3><b>Alert Log Report</b></h3>
                            </div>
                            <div class="col-md-6 d-md-flex justify-content-end">
                                <div>
                                    <button id="well_wise_export" style="display: none;" class="btn btn-sm btn-success" onclick="export_well_wise_report();">Export</button>
                                    <button id="date_wise_export" style="display: none;" class="btn btn-sm btn-success" onclick="export_date_wise_report();">Export</button>
                                    <button class="btn btn-sm btn-primary" id="well_wise_pdf" onclick="printWell();" style="display: none;">PDF</button>
                                    <button class="btn btn-sm btn-primary" id="date_wise_pdf" onclick="printDate();" style="display: none;">PDF</button>
                                    <a href="Dashboard_c">
                                        <button class="btn btn-sm btn-primary">Back</button>
                                    </a>
                                </div>
                            </div>

                        </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="report_view" class="form-label"><b>View Report</b></label>
                                <select name="report_view" id="report_view" class="form-control select2" onchange="get_view();" style="width: 100%;">
                                    <option value=""> Select View </option>
                                    <option value="well">Well Wise</option>
                                    <option value="date">Date Wise</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="alert_type" class="form-label"><b>Alert Type</b></label>
                                <select onchange="get_wellwise_alert_report();" class="form-control select2" id="alert_type" name="alert_type" style="width: 100%;">
                                    <option value="">ALL</option>
                                    <option value="1">Low CHP</option>
                                    <option value="2">High CHP</option>
                                    <option value="3">Low THP</option>
                                    <option value="4">High THP</option>
                                    <option value="5">Low ABP</option>
                                    <option value="6">High ABP</option>
                                    <option value="7">Temp FLT</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                            <label  class="form-label"><b>Area Name</b></label>

                                <select name="area_id" id="area_id" class="form-control select2">
                                    <?php
                                    $user_type = $this->session->userdata('user_type', true);
                                    $role_type = $this->session->userdata('role_type', true);

                                    if ($user_type == 3 && $role_type == 2) {
                                        if (!empty($area_list)) {
                                            foreach ($area_list as $value) {
                                                echo '<option value="' . $value['id'] . '">' . $value['area_name'] . '</option>';
                                            }
                                        }
                                    } else {
                                        if (!empty($area_list)) {
                                            echo '<option value="">Select All</option>';
                                            foreach ($area_list as $value) {
                                                echo '<option value="' . $value['id'] . '">' . $value['area_name'] . '</option>';
                                            }
                                        }
                                    }
                                    ?>
                                </select>
                                    </div>


                                <div class="form-group col-md-4" style="display:none;" id="filter_date">
                                    <h5 style="margin-top: 15px;"><b>Date</b></h5>
                                    <input type="date" name="date" id="date" class="form-control" value="<?= date('Y-m-d',time()); ?>" onchange="datewise_alert_list();get_date();">
                                </div>

                                <div class="form-group col-md-4" id="date_wise_sort" style="display: none;">
                                    <h5 style="margin-top: 15px;"><b>Sort By</b></h5>
                            </div>
                            <div class="form-group col-md-4 mt-2" style="display:none;" id="filter_date">
                               <label  class="form-label"><b>Date</b></label>
                                <input type="date" name="date" id="date" class="form-control" value="<?= date('Y-m-d',time()); ?>" onchange="datewise_alert_list();get_date();">
                            </div>
                            <div class="form-group col-md-4 mt-2" id="date_wise_sort" style="display: none;">
                                     <label  class="form-label"><b>Sort By</b></label>
                                    <select class="form-control select2" name="sort_by_date" id="sort_by_date" onchange="datewise_alert_list();">
                                        <option value="">Select Column</option>
                                        <option value="well_site_name">Area Name</option>
                                        <option value="well_name">Well No</option>
                                        <option value="alert_type">Alert Type</option>
                                        <option value="alerts_details">Alert Details</option>
                                         <option value="status">Status</option>
                                                                                
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="card-body" id="well_wise_table" style="display:none;    margin-top: -19px;">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <h5><b>Well No</b></h5>
                                    <select name="well_id" id="well_id" class="form-control select2" onchange="get_wellwise_alert_report();">
                                        <option value=""> Select Well No </option>
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

                                <div class="form-group col-md-3">
                                    <h5><b>From Date</b></h5>
                                    <input type="date" name="from_date" id="from_date" class="form-control" onchange="get_wellwise_alert_report();get_well_wise_date();">
                                </div>

                                <div class="form-group col-md-3">
                                    <h5><b>To Date</b></h5>
                                    <input type="date" name="to_date" id="to_date" class="form-control" onchange="get_wellwise_alert_report();get_well_wise_date();">
                                </div>

                                <div class="form-group col-md-3" id="well_wise_sort" style="display: none;">
                                    <h5><b>Sort By</b></h5>
                                    <select class="form-control select2" name="sort_by_well" id="sort_by_well" onchange="get_wellwise_alert_report();">
                                        <option value="">Select Column</option>
                                        <option value="well_site_name">Area Name</option>
                                        <option value="well_name">Well No</option>
                                        <option value="alert_type">Alert Type</option>
                                        <option value="alerts_details">Alert Details</option>
                                        <option value="start_date_time">From Date</option>
                                        <option value="end_date_time">To Date</option>

                                    </select>
                                </div>

                                
                            </div>
                            <div id="GFGWell">
                            <div class="table-responsive mt-4" id="basic-datatable">
                                <table class="table table-bordered border-bottom"  style="width: 100%;">
                                    <thead class="bg-light text-center">
                                        <tr>
                                            <th colspan="7" class="text-uppercase" style="font-size: 20px;font-weight: bolder;">IOT BASED REAL TIME WELL MONITORING SYSTEM ONGC,CAMBAY ASSET</th>
                                        </tr>
                                        <tr>
                                            <th colspan="8" class="text-uppercase" style="font-size: 15px;font-weight: bolder;">Alert Log Report of <span id="show_from_date"></span> <span id="to">To</span> <span id="show_to_date"></span></th>
                                        </tr>
                                    </thead>
                                </table>
                                    <table class="table table-bordered border-bottom"  style="width: 100%;">
                                        <tr>
                                            <th style="width:10%;">Sl No.</th>
                                            <th>Area Name</th>
                                            <th>Well No</th>
                                            <th>Alert Type</th>
                                            <th>Alert Details</th>
                                            <th>From Date Time </th>
                                            <th>To Date Time</th>
                                            <th>Total Durations</th>
                                        </tr>
                                    
                                    <tbody class="text-center" id="table_data">    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                        <!-- ============== date wise Alert log =============== -->
                       <div id="GFGdata">
                        <div class="card-body" id="date_wise_table" style="display:none;">
                            
                            <div class="table-responsive" id="date_wise_table_export">
                                <table class="table table-bordered border-bottom" >
                                    <thead class="bg-light text-center">
                                        <tr>
                                            <th colspan="6" class="text-uppercase" style="font-size: 20px;font-weight: bolder;">IOT BASED REAL TIME WELL MONITORING SYSTEM ONGC,CAMBAY ASSET</th>
                                        </tr>
                                        <tr>
                                            <th colspan="6" class="text-uppercase" style="font-size: 15px;font-weight: bolder;">Alert Log Report of <span id="show_date"></span></th>
                                        </tr>
                                    </thead>
                                </table>
                                <table class="table table-bordered border-bottom" >
                                        <tr>
                                            <th style="width:10%;">Sl No.</th>
                                            <th>Area Name</th>
                                            <th>Well No</th>
                                            <th>Alert Type</th>
                                            <th>Alert Details</th>
                                            <th>From Date Time </th>
                                            <th>To Date Time</th>
                                            <th>Total Durations</th>
                                        </tr>
                                    
                                    <tbody class="text-center" id="date_table_data">                            
                                        
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


<script>
    // Function to get the default date value
    function getDefaultDateValue() {
        const currentDate = new Date();
        const currentHour = currentDate.getHours();
        const currentDateString = currentDate.toISOString().slice(0, 10);

        // If the current hour is before 6 am, show the previous date as the default value
        if (currentHour < 6) {
            const previousDate = new Date(currentDate);
            previousDate.setDate(previousDate.getDate() - 1);
            return previousDate.toISOString().slice(0, 10);
        }

        return currentDateString;
    }

    // Set the default date value when the page loads
    document.getElementById('from_date').value = getDefaultDateValue();
    document.getElementById('to_date').value = getDefaultDateValue();
    document.getElementById('date').value = getDefaultDateValue();
</script>




<script type="text/javascript">
    
    function get_view()
    {
        var value = $('#report_view').val();

        if (value == 'well')
        {
            $('#well_wise_table').show();
            $('#date_wise_table').hide();
            $('#filter_date').hide();
            $('#well_wise_export').show();
            $('#date_wise_export').hide();

            $('#well_wise_sort').show();
            $('#date_wise_sort').hide();
            $('#well_wise_pdf').show();
            $('#date_wise_pdf').hide();
                        
            
        }else if(value == 'date')
        {
            $('#well_wise_table').hide();
            $('#date_wise_table').show();
            $('#filter_date').show();
            $('#well_wise_export').hide();
            $('#date_wise_export').show();

            $('#well_wise_sort').hide();
            $('#date_wise_sort').show();
            $('#well_wise_pdf').hide();
            $('#date_wise_pdf').show(); 
        }else{
            $('#well_wise_table').hide();
            $('#date_wise_table').hide();
            $('#filter_date').hide();
            $('#well_wise_export').show();
            $('#date_wise_export').hide();

            $('#well_wise_sort').hide();
            $('#date_wise_sort').hide();
            $('#well_wise_pdf').hide();
            $('#date_wise_pdf').hide();     
        }
    }
</script>
<script type="text/javascript">
    get_well_wise_date();
    function get_well_wise_date()
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

    get_date();
    function get_date()
    {
        var selected_date = $('#date').val();
        formated_date = moment(selected_date);

        if(formated_date.isValid())
        {
            $('#show_date').text(formated_date.format("DD-MM-YYYY"));
        }else{
            $('#show_date').text('');
        } 
    }
    get_wellwise_alert_report();
function get_wellwise_alert_report() {
    $('#table_data').html('<tr><td colspan="9">Processing, please wait...</td></tr>');

    var from_date = $('#from_date').val();
    var to_date = $('#to_date').val();
    var well_id = $('#well_id').val();
    var sort_by = $('#sort_by_well').val();
    var user_id = "<?php echo $this->session->userdata('user_id'); ?>";

    $.ajax({
        url: '<?php echo base_url(); ?>Selfflow_alert_c/get_wellwise_alert_data',
        method: 'POST',
        data: {
            from_date: from_date,
            to_date: to_date,
            well_id: well_id,
            user_id: user_id,
            sort_by: sort_by
        },
        success: function (res) {
            var response = JSON.parse(res);
            $('#table_data').html("");

            if (response.response_code == 200) {
                if (response.data.length > 0) {
                    $.each(response.data, function (i, v) {
                        var alert_type = parseInt(v.alert_type);
                        var alert_data = '';

                        if (alert_type == 0) {
                            alert_data = 'SOV ON';
                        } else if (alert_type == 1) {
                            alert_data = 'SOV OFF';
                        } else if (alert_type == 2) {
                            alert_data = 'Battery Low';
                        } else if (alert_type == 3) {
                            alert_data = 'Battery High';
                        } else if (alert_type == 4) {
                            alert_data = 'GIP Low';
                        } else if (alert_type == 5) {
                            alert_data = 'GIP High';
                        } else if (alert_type == 6) {
                            alert_data = 'THP Low';
                        } else if (alert_type == 7) {
                            alert_data = 'THP High';
                        } else if (alert_type == 8) {
                            alert_data = 'CHP Low';
                        } else if (alert_type == 9) {
                            alert_data = 'CHP High';
                        } else if (alert_type == 10) {
                            alert_data = 'ABP Low';
                        } else if (alert_type == 11) {
                            alert_data = 'ABP High';
                        } else if (alert_type == 12) {
                            alert_data = 'Temp Low';
                        } else if (alert_type == 13) {
                            alert_data = 'Temp High';
                        } else if (alert_type == 14) {
                            alert_data = 'Door Closed';
                        } else if (alert_type == 15) {
                            alert_data = 'Door Open';
                        } else {
                            alert_data = 'Unknown Alert Type';
                        }
                        var alert_details = v.alert_details !== null ? v.alert_details : "NA";
                        var start_date_time = v.start_date_time !== null ? moment(v.start_date_time).format('DD-MM-YYYY h:mm:ss a') : "NA";
                        var end_date_time = v.end_date_time !== null ? moment(v.end_date_time).format('DD-MM-YYYY h:mm:ss a') : "NA";
                        var duration = v.duration !== null ? v.duration : "00:00:00";
                       
                        var parts = duration.split(":");
                        var hrs = parseInt(parts[0]) || 0;
                        var mins = parseInt(parts[1]) || 0;
                        var duration_human = hrs + ' hrs ' + mins + ' min';
                        var total_hours = hrs + (mins / 60);

                        let durationBadgeBg = "#cce5ff";   
                        let durationBadgeText = "#004085"; 

                        if (total_hours > 12 && total_hours <= 24) {
                            durationBadgeBg = "#f8d7da";  
                            durationBadgeText = "#721c24";
                        } else if (total_hours > 24 && total_hours <= 48) {
                            durationBadgeBg = "#fff3cd";   
                            durationBadgeText = "#856404";
                        } else if (total_hours > 48) {
                            durationBadgeBg = "#d4edda";    
                            durationBadgeText = "#155724";
                        }

                        $('#table_data').append('<tr>' +
                            '<td>' + (i + 1) + '</td>' +
                            '<td>' + v.well_site_name + '</td>' +
                            '<td>' + v.well_name + '</td>' +
                            '<td>' + alert_data + '</td>' +
                            '<td>' + alert_details + '</td>' +
                            '<td>' + start_date_time + '</td>' +
                            '<td>' + end_date_time + '</td>' +
                            '<td><span class="badge" style="background-color:' + durationBadgeBg + '; color:' + durationBadgeText + '; font-weight: 600;">' + duration_human + '</span></td>'+

                            '</tr>');
                    });
                } else {
                    $('#table_data').html('<tr>' +
                        '<td class="text-danger text-center" colspan="9">No Record Found !!</td>' +
                        '</tr>');
                }
            } else {
                $('#table_data').html('<tr>' +
                    '<td class="text-danger text-center" colspan="9">Error retrieving data</td>' +
                    '</tr>');
            }
        },
        error: function () {
            $('#table_data').html('<tr>' +
                '<td class="text-danger text-center" colspan="9">AJAX request failed</td>' +
                '</tr>');
        }
    });
}



    datewise_alert_list();
function datewise_alert_list() {
    $('#date_table_data').html('<tr><td colspan="9">Processing, please wait...</td></tr>');

    var date = $('#date').val();
    var sort_by = $('#sort_by_date').val();
    var user_id = "<?php echo $this->session->userdata('user_id'); ?>";

    $.ajax({
        url: '<?php echo base_url(); ?>Selfflow_alert_c/get_datewise_alert_report',
        method: 'POST',
        data: {
            date: date,
            user_id: user_id,
            sort_by: sort_by
        },
        success: function (res) {
            var response = JSON.parse(res);
            console.log('alertdetails', response);

            $('#date_table_data').html("");

            if (response.response_code == 200) {
                if (response.data.length > 0) {
                    $.each(response.data, function (i, v) {
                        var alert_type = parseInt(v.alert_type);
                        var alert_data = '';

                        if (alert_type == 0) {
                            alert_data = 'SOV ON';
                        } else if (alert_type == 1) {
                            alert_data = 'SOV OFF';
                        } else if (alert_type == 2) {
                            alert_data = 'Battery Low';
                        } else if (alert_type == 3) {
                            alert_data = 'Battery High';
                        } else if (alert_type == 4) {
                            alert_data = 'GIP Low';
                        } else if (alert_type == 5) {
                            alert_data = 'GIP High';
                        } else if (alert_type == 6) {
                            alert_data = 'THP Low';
                        } else if (alert_type == 7) {
                            alert_data = 'THP High';
                        } else if (alert_type == 8) {
                            alert_data = 'CHP Low';
                        } else if (alert_type == 9) {
                            alert_data = 'CHP High';
                        } else if (alert_type == 10) {
                            alert_data = 'ABP Low';
                        } else if (alert_type == 11) {
                            alert_data = 'ABP High';
                        } else if (alert_type == 12) {
                            alert_data = 'Temp Low';
                        } else if (alert_type == 13) {
                            alert_data = 'Temp High';
                        } else if (alert_type == 14) {
                            alert_data = 'Door Closed';
                        } else if (alert_type == 15) {
                            alert_data = 'Door Open';
                        } else {
                            alert_data = 'Unknown Alert Type';
                        }
                       
                        var alert_details = v.alert_details !== null ? v.alert_details : "NA";
                        var start_date_time = v.start_date_time !== null ? moment(v.start_date_time).format('DD-MM-YYYY h:mm:ss a') : "NA";
                        var end_date_time = v.end_date_time !== null ? moment(v.end_date_time).format('DD-MM-YYYY h:mm:ss a') : "NA";

                        var duration = v.duration !== null ? v.duration : "00:00:00";
                       
                        var parts = duration.split(":");
                        var hrs = parseInt(parts[0]) || 0;
                        var mins = parseInt(parts[1]) || 0;
                        var duration_human = hrs + ' hrs ' + mins + ' min';
                        var total_hours = hrs + (mins / 60);

                        let durationBadgeBg = "#cce5ff";   
                        let durationBadgeText = "#004085"; 

                        if (total_hours > 12 && total_hours <= 24) {
                            durationBadgeBg = "#f8d7da";  
                            durationBadgeText = "#721c24";
                        } else if (total_hours > 24 && total_hours <= 48) {
                            durationBadgeBg = "#fff3cd";   
                            durationBadgeText = "#856404";
                        } else if (total_hours > 48) {
                            durationBadgeBg = "#d4edda";    
                            durationBadgeText = "#155724";
                        }

                        $('#date_table_data').append('<tr>' +
                            '<td>' + (i + 1) + '</td>' +
                            '<td>' + v.well_site_name + '</td>' +
                            '<td>' + v.well_name + '</td>' +
                            '<td>' + alert_data + '</td>' +
                            '<td>' + alert_details + '</td>' +
                            '<td>' + start_date_time + '</td>' +
                            '<td>' + end_date_time + '</td>' +
                            '<td><span class="badge" style="background-color:' + durationBadgeBg + '; color:' + durationBadgeText + '; font-weight: 600;">' + duration_human + '</span></td>'+

                            '</tr>');
                    });
                } else {
                    $('#date_table_data').html('<tr>' +
                        '<td class="text-danger text-center" colspan="9">No Record Found !!</td>' +
                        '</tr>');
                }
            } else {
                $('#date_table_data').html('<tr>' +
                    '<td class="text-danger text-center" colspan="9">Error retrieving data</td>' +
                    '</tr>');
            }
        },
        error: function () {
            $('#date_table_data').html('<tr>' +
                '<td class="text-danger text-center" colspan="9">AJAX request failed</td>' +
                '</tr>');
        }
    });
}


  setInterval(()=>{
        get_wellwise_running_report();
        datewise_running_list();
    },30000);

</script>


<script src="<?php echo base_url(); ?>assets/local/excel/xlsx.full.min.js"></script>
<script type="text/javascript">
    
    function export_well_wise_report() {
      var sheetName = "Sheet1";
      var fileName = "Well Alert Log.xlsx";
      var table = $("#basic-datatable")[0];

      // Convert table to worksheet
      var ws = XLSX.utils.table_to_sheet(table);

      // Create a new workbook and add the worksheet to it
      var wb = XLSX.utils.book_new();
      XLSX.utils.book_append_sheet(wb, ws, sheetName);

      // Save the workbook as an Excel file and download it
      XLSX.writeFile(wb, fileName);
    }

    function export_date_wise_report() {
      var sheetName = "Sheet1";
      var fileName = "Alert log Date Wise.xlsx";
      var table = $("#date_wise_table_export")[0];

      // Convert table to worksheet
      var ws = XLSX.utils.table_to_sheet(table);

      // Create a new workbook and add the worksheet to it
      var wb = XLSX.utils.book_new();
      XLSX.utils.book_append_sheet(wb, ws, sheetName);

      // Save the workbook as an Excel file and download it
      XLSX.writeFile(wb, fileName);
    }

    

</script>


 <style>
        @media print {
            @page {
                size: landscape;
                margin: 0.5cm; 
            }

            body {
                -webkit-print-color-adjust: exact; 
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            th, td {
                font-size: 10px; 
                padding: 1px;
                border: 1px solid black; 
            }

            .no-print {
                display: none;
            }
        }
    </style>
<script>
    function printDate() {
        var printDiv = "#GFGdata"; 
        $("*").addClass("no-print");
        $(printDiv + " *").removeClass("no-print");
        $(printDiv).removeClass("no-print");

        var parent = $(printDiv).parent();
        while ($(parent).length) {
            $(parent).removeClass("no-print");
            parent = $(parent).parent();
        }
        window.print();
    }

     function printWell() {
        var printDiv = "#GFGWell"; 
        $("*").addClass("no-print");
        $(printDiv + " *").removeClass("no-print");
        $(printDiv).removeClass("no-print");

        var parent = $(printDiv).parent();
        while ($(parent).length) {
            $(parent).removeClass("no-print");
            parent = $(parent).parent();
        }
        window.print();
    }
    
function get_area_list()
    {  
       let company_id = "<?php echo $this->session->userdata('company_id') ?>";
       let user_id = "<?php echo $this->session->userdata('user_id') ?>";
       let assets_id = $('#assets_id').val();
       
       $.ajax({
            type: 'POST',
            url: '<?php echo base_url();?>Selfflow_alert_c/get_area_list',
            data:{company_id:company_id,user_id:user_id,assets_id:assets_id},
            success:function(data)
            {
                data = JSON.parse(data);
                console.log(data);
                if(data.response_code==200)
                {   
                    if(data.data.length>0)
                    {
                        $('#area_id').html('');
                        $('#area_id').html('<option value=" ">Select area</option>');
                        $.each(data.data,function(i,v){
  
                        $('#area_id').append('<option value="'+v.area_id+'">'+v.area_name+'</option>');
                           
                            
                        });
                        
                    }else
                    {
                        $('#area_id').html('No Data Found');
                    }
                }else
                {
                    swal('error',data.msg,'error');
                }
              console.log();
            }
    
          });
    }
    </script>