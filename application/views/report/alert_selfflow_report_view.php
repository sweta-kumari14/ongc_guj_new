 <style>
    table thead tr th{
        background: #daebf9 !important;
    }
    .table-bordered th {
       border: 1px solid var(--bs-tertiary-color);

    }
   th {
    position: relative;
    cursor: pointer;
    padding-right: 20px;
    }

    th.sort-asc::after {
        content:"";
        position:absolute;
        right:6px; top:50%;
        margin-top:-5px;
        border-left:5px solid transparent;
        border-right:5px solid transparent;
        border-bottom:6px solid #000;
    }

    th.sort-desc::after {
        content:"";
        position:absolute;
        right:6px; top:50%;
        margin-top:-5px;
        border-left:5px solid transparent;
        border-right:5px solid transparent;
        border-top:6px solid #000;
    }

    .table-bordered td {
       border: 1px solid var(--bs-tertiary-color);

    }
    .form-label{
        font-size: 15px;
    }
    /* Well Wise Export */
button#well_wise_export {
    font-size: 16px !important;
    padding: 3px 13px !important;
}

button#well_wise_export i {
    margin-right: -20px;
    position: relative;
    opacity: 0; 
    transition: all 0.5s ease-out;
}

button#well_wise_export:hover i {
    opacity: 1; 
    margin-right: 2px;
}

/* Date Wise Export */
button#date_wise_export {
    font-size: 16px !important;
    padding: 3px 13px !important;
}

button#date_wise_export i {
    margin-right: -20px;
    position: relative;
    opacity: 0; 
    transition: all 0.5s ease-out;
}

button#date_wise_export:hover i {
    opacity: 1; 
    margin-right: 2px;
}

/* Back Button */
button#back_btns {
    font-size: 16px !important;
    padding: 3px 13px !important;
}

button#back_btns i {
    margin-right: -20px;
    position: relative;
    opacity: 0; 
    transition: all 0.5s ease-out;
}

button#back_btns:hover i {
    opacity: 1; 
    margin-right: 2px;
}

/* Card header background */
.card-header {
    background-color: var(--bs-white) !important;
}

</style>

<div class="page-wrapper">
<!-- Page Content -->
    <div class="content container-fluid">
    
            <div class="row row-sm">
                <div class="col-lg-12">
                    <div class="card" style="margin-top: -16px;">
                        <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h3><b>Alert Log Report</b></h3>
                            </div>
                            <div class="col-md-6 d-md-flex justify-content-end">
                                <div>
                                    <button id="well_wise_export" style="display: none;" onclick="export_well_wise_report();" class="btn btn-outline-success me-2"><i class="fa-solid fa-file-excel"></i>Export</button>
                                    <button id="date_wise_export" style="display: none;" onclick="export_date_wise_report();" class="btn btn-outline-success me-2"><i class="fa-solid fa-file-excel"></i>Export</button>
                            
                                    <a href="<?php echo base_url('')?>Selfflow_c">
                                        <button  id="back_btns" class="btn btn-outline-warning">
                                    <i class="fa-solid fa-left-long"></i> Back</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                   <div class="card-body">
                        <div class="col-xl-12">
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
                                <select onchange="get_wellwise_alert_report();datewise_alert_list();" class="form-control select2" id="alert_type" name="alert_type" style="width: 100%;">
                                    <option value="">ALL</option>
                                    <option value="1">CHP Low</option>
                                    <option value="2">CHP High</option>
                                    <option value="3">ABP Low</option>
                                    <option value="4">ABP High</option>
                                    <option value="5">THP Low</option>
                                    <option value="6">THP High</option>
                                    <option value="7">FLT Low</option>
                                    <option value="8">FLT High</option>
                                    <option value="9">Battery Low</option>
                                    <option value="10">Battery High</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                            <label  class="form-label"><b>Area Name</b></label>
                                <select name="site_id" id="site_id" class="form-control select2" onchange="datewise_alert_list();get_wellwise_alert_report(); getWell_list();">
                                    <?php
                                    $user_type = $this->session->userdata('user_type', true);
                                    $role_type = $this->session->userdata('role_type', true);

                                    if ($user_type == 3 && $role_type == 2) {
                                        if (!empty($site_list)) {
                                            foreach ($site_list as $value) {
                                                echo '<option value="' . $value['id'] . '">' . $value['well_site_name'] . '</option>';
                                            }
                                        }
                                    } else {
                                        if (!empty($site_list)) {
                                            echo '<option value="">Select All</option>';
                                            foreach ($site_list as $value) {
                                                echo '<option value="' . $value['id'] . '">' . $value['well_site_name'] . '</option>';
                                            }
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-md-4 mt-2" style="display:none;" id="filter_date">
                               <label  class="form-label"><b>Date</b></label>
                                <input type="date" name="date" id="date" class="form-control" value="<?= date('Y-m-d',time()); ?>" onchange="datewise_alert_list();get_date();">
                            </div>
                            </div>
                        </div>
                    </div>

                        <div class="card-body" id="well_wise_table" style="display:none;margin-top:-18px;">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <h5><b>Well No</b></h5>
                                    <select name="well_id" id="well_id" class="form-control select2" onchange="get_wellwise_alert_report();">
                                        <option value=""> Select Well No </option>
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <h5><b>From Date</b></h5>
                                    <input type="date" name="from_date" id="from_date" class="form-control" onchange="get_wellwise_alert_report();get_well_wise_date();">
                                </div>

                                <div class="form-group col-md-4">
                                    <h5><b>To Date</b></h5>
                                    <input type="date" name="to_date" id="to_date" class="form-control" onchange="get_wellwise_alert_report();get_well_wise_date();">
                                </div>
                                
                            </div>
                           
                            <div class="table-responsive mt-4" id="basic-datatable">
                                <div class="d-flex justify-content-between mb-2">
                                    <div>
                                        <label for="wellRowsPerPage">Rows per page: </label>
                                        <select id="wellRowsPerPage" class="form-select d-inline-block w-auto">
                                            <option value="5">5</option>
                                            <option value="10" selected>10</option>
                                            <option value="20">20</option>
                                            <option value="50">50</option>
                                        </select>
                                    </div>
                                    <input type="text" id="well_searchBox" placeholder="Search well-wise..." class="form-control w-25">
                                </div>

                                <table class="table table-bordered border-bottom"  style="width: 100%;">
                                    <thead class="bg-light text-center" id="well_table_header">
                                        <tr>
                                            <th colspan="8" class="text-uppercase" style="font-size: 20px;font-weight: bolder;">IOT BASED REAL TIME WELL MONITORING SYSTEM ONGC,CAMBAY ASSET</th>
                                        </tr>
                                        <tr>
                                            <th colspan="8" class="text-uppercase" style="font-size: 15px;font-weight: bolder;">Alert Log Report of <span id="show_from_date"></span> <span id="to">To</span> <span id="show_to_date"></span></th>
                                        </tr>
                                        <tr>
                                            <th data-key="sl_no" data-sort="number">Sl No.</th>
                                            <th data-key="well_site_name" data-sort="string">Site Name</th>
                                            <th data-key="well_name" data-sort="string">Well Name</th>
                                            <th data-key="alert_type" data-sort="number">Alert Type</th>
                                            <th data-key="alert_details" data-sort="string">Details</th>
                                            <th data-key="start_date_time" data-sort="date">Start</th>
                                            <th data-key="end_date_time" data-sort="date">End</th>
                                            <th data-key="duration" data-sort="string">Duration</th>
                                        </tr>
                                     </thead>
                                    <tbody class="text-center" id="table_data">    
                                    </tbody>
                                </table>
                                <div id="wellwise_pagination" class="mt-2 text-end"></div>
                            </div>
                        </div>
                        <!-- ============== date wise Alert log =============== -->
                        <div class="card-body" id="date_wise_table" style="display:none;">
                            
                            <div class="table-responsive" id="date_wise_table_export">
                                <div class="d-flex justify-content-between mb-2">
                                    <div>
                                        <label for="dateRowsPerPage">Rows per page: </label>
                                        <select id="dateRowsPerPage" class="form-select d-inline-block w-auto">
                                            <option value="5">5</option>
                                            <option value="10" selected>10</option>
                                            <option value="20">20</option>
                                            <option value="50">50</option>
                                        </select>
                                    </div>
                                    <input type="text" id="date_searchBox" placeholder="Search date-wise..." class="form-control w-25">
                                    
                                </div>

                                <table class="table table-bordered border-bottom" >
                                    <thead class="bg-light text-center" id="date_table_header">
                                        <tr>
                                            <th colspan="8" class="text-uppercase" style="font-size: 20px;font-weight: bolder;">IOT BASED REAL TIME WELL MONITORING SYSTEM ONGC,CAMBAY ASSET</th>
                                        </tr>
                                        <tr>
                                            <th colspan="8" class="text-uppercase" style="font-size: 15px;font-weight: bolder;">Alert Log Report of <span id="show_date"></span></th>
                                        </tr>
                                        <tr>
                                            <th data-key="sl_no" data-sort="number">Sl No.</th>
                                            <th data-key="well_site_name" data-sort="string">Site Name</th>
                                            <th data-key="well_name" data-sort="string">Well Name</th>
                                            <th data-key="alert_type" data-sort="number">Alert Type</th>
                                            <th data-key="alert_details" data-sort="string">Details</th>
                                            <th data-key="start_date_time" data-sort="date">Start</th>
                                            <th data-key="end_date_time" data-sort="date">End</th>
                                            <th data-key="duration" data-sort="string">Duration</th>
                                        </tr>
                                    
                                    <tbody class="text-center" id="date_table_data">                            
                                        
                                    </tbody>
                                </table>
                                <div id="datewise_pagination" class="mt-2 text-end"></div>
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
            get_wellwise_alert_report();        
            
        }else if(value == 'date')
        {
            $('#well_wise_table').hide();
            $('#date_wise_table').show();
            $('#filter_date').show();
            $('#well_wise_export').hide();
            $('#date_wise_export').show();
            datewise_alert_list();
        }else{
            $('#well_wise_table').hide();
            $('#date_wise_table').hide();
            $('#filter_date').hide();
            $('#well_wise_export').show();
            $('#date_wise_export').hide();
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

 // Well-wise table
let wellwiseData = [];
let wellCurrentPage = 1;
let wellRowsPerPage = 10;
let wellSortColumn = null;
let wellSortDir = 1;

// Date-wise table
let datewiseData = [];
let dateCurrentPage = 1;
let dateRowsPerPage = 10;
let dateSortColumn = null;
let dateSortDir = 1;

function get_wellwise_alert_report() {
    $('#table_data').html('<tr><td colspan="9">Processing, please wait...</td></tr>');

    var from_date = $('#from_date').val();
    var to_date = $('#to_date').val();
    var well_id = $('#well_id').val();
    var site_id = $('#site_id').val();
    var alert_type = $('#alert_type').val();
    var user_id = "<?php echo $this->session->userdata('user_id'); ?>";
    // alert(from_date);
    // alert(to_date);

    $.ajax({
        url: '<?php echo base_url(); ?>Selfflow_alert_c/get_wellwise_alert_data',
        method: 'POST',
        data: { from_date:from_date, to_date:to_date, well_id:well_id, user_id:user_id, alert_type:alert_type,site_id:site_id },
        success: function (res) {
            var response = JSON.parse(res);
            console.log(response,'sdsaf');
            if (response.response_code == 200 && response.data.length > 0) {
                wellwiseData = response.data;
            } else {
                wellwiseData = [];
            }
            wellCurrentPage = 1;
            renderWellwiseTable();
            renderWellwisePagination();
        },
        error: function () {
            $('#table_data').html('<tr><td colspan="9" class="text-danger text-center">AJAX request failed</td></tr>');
        }
    });
}

function renderWellwiseTable(filteredData) {
    let data = filteredData || wellwiseData;
    let start = (wellCurrentPage - 1) * wellRowsPerPage;
    let end = start + wellRowsPerPage;
    let paginated = data.slice(start, end);

    $('#table_data').empty();

    if (paginated.length > 0) {
        $.each(paginated, function (i, v) {
            var alert_type = parseInt(v.alert_type);
                        var alert_data = '';

                        if (alert_type == 1) {
                            alert_data = 'CHP Low';
                        } else if (alert_type == 2) {
                            alert_data = 'CHP High';
                        } else if (alert_type == 3) {
                            alert_data = 'ABP Low';
                        } else if (alert_type == 4) {
                            alert_data = 'ABP High';
                        } else if (alert_type == 5) {
                            alert_data = 'THT Low';
                        } else if (alert_type == 6) {
                            alert_data = 'THT High';
                        } else if (alert_type == 7) {
                            alert_data = 'FLT Low';
                        } else if (alert_type == 8) {
                            alert_data = 'FLT High';
                        } else if (alert_type  == 9) {
                            alert_data = 'Battery Low';
                        } else if (alert_type  == 10) {
                            alert_data = 'Battery High';
                        } else {
                            alert_data = 'Unknown Alert Type';
                        }
            let alert_details = v.alert_details || 'NA';
            let start_date_time = v.start_date_time ? moment(v.start_date_time).format('DD-MM-YYYY h:mm:ss a') : 'NA';
            let end_date_time = v.end_date_time ? moment(v.end_date_time).format('DD-MM-YYYY h:mm:ss a') : 'NA';

            let duration = v.duration || "00:00:00";
            let parts = duration.split(":");
            let hrs = parseInt(parts[0]) || 0;
            let mins = parseInt(parts[1]) || 0;
            let duration_human = hrs + ' hrs ' + mins + ' min';
            let total_hours = hrs + (mins / 60);
            let durationBadgeBg = "#cce5ff", durationBadgeText = "#004085";
            if(total_hours > 12 && total_hours <= 24){ durationBadgeBg="#f8d7da"; durationBadgeText="#721c24";}
            else if(total_hours > 24 && total_hours <= 48){ durationBadgeBg="#fff3cd"; durationBadgeText="#856404";}
            else if(total_hours > 48){ durationBadgeBg="#d4edda"; durationBadgeText="#155724";}

            $('#table_data').append('<tr>'+
                `<td>${start + i + 1}</td>`+
                `<td>${v.well_site_name}</td>`+
                `<td>${v.well_name}</td>`+
                `<td>${alert_data}</td>`+
                `<td>${alert_details}</td>`+
                `<td>${start_date_time}</td>`+
                `<td>${end_date_time}</td>`+
                `<td><span class="badge" style="background-color:${durationBadgeBg}; color:${durationBadgeText}; font-weight:600;">${duration_human}</span></td>`+
                '</tr>');
        });
    } else {
        $('#table_data').html('<tr><td colspan="9" class="text-danger text-center">No Record Found !!</td></tr>');
    }
}

// Pagination
function renderWellwisePagination(filteredData) {
    let data = filteredData || wellwiseData;
    let totalPages = Math.ceil(data.length / wellRowsPerPage);
    let html = '';
    for(let i=1; i<=totalPages; i++){
        html += `<button class="btn btn-sm ${i===wellCurrentPage?'btn-primary':'btn-outline-primary'} me-1" onclick="goWellPage(${i})">${i}</button>`;
    }
    $('#wellwise_pagination').html(html);
}

function goWellPage(page){
    wellCurrentPage = page;
    renderWellwiseTable();
    renderWellwisePagination();
}

function datewise_alert_list() {
    $('#date_table_data').html('<tr><td colspan="9">Processing, please wait...</td></tr>');

    var date = $('#date').val();
    var site_id = $('#site_id').val();
    var alert_type = $('#alert_type').val();
    var user_id = "<?php echo $this->session->userdata('user_id'); ?>";

    $.ajax({
        url: '<?php echo base_url(); ?>Selfflow_alert_c/get_datewise_alert_report',
        method: 'POST',
        data: { date, user_id, alert_type,site_id },
        success: function (res) {
            var response = JSON.parse(res);
            datewiseData = response.response_code==200 && response.data.length>0 ? response.data : [];
            dateCurrentPage = 1;
            renderDatewiseTable();
            renderDatewisePagination();
        },
        error: function () {
            $('#date_table_data').html('<tr><td colspan="9" class="text-danger text-center">AJAX request failed</td></tr>');
        }
    });
}

function renderDatewiseTable(filteredData){
    let data = filteredData || datewiseData;
    let start = (dateCurrentPage-1)*dateRowsPerPage;
    let end = start + dateRowsPerPage;
    let paginated = data.slice(start,end);

    $('#date_table_data').empty();

    if(paginated.length>0){
        $.each(paginated,function(i,v){
            let alert_type = parseInt(v.alert_type);
            var alert_data = '';
                if (alert_type == 1) {
                    alert_data = 'CHP Low';
                } else if (alert_type == 2) {
                    alert_data = 'CHP High';
                } else if (alert_type == 3) {
                    alert_data = 'ABP Low';
                } else if (alert_type == 4) {
                    alert_data = 'ABP High';
                } else if (alert_type == 5) {
                    alert_data = 'THT Low';
                } else if (alert_type == 6) {
                    alert_data = 'THT High';
                } else if (alert_type == 7) {
                    alert_data = 'FLT Low';
                } else if (alert_type == 8) {
                    alert_data = 'FLT High';
                } else if (alert_type  == 9) {
                    alert_data = 'Battery Low';
                } else if (alert_type  == 10) {
                    alert_data = 'Battery High';
                } else {
                    alert_data = 'Unknown Alert Type';
                }
            let alert_details = v.alert_details || 'NA';
            let start_date_time = v.start_date_time ? moment(v.start_date_time).format('DD-MM-YYYY h:mm:ss a') : 'NA';
            let end_date_time = v.end_date_time ? moment(v.end_date_time).format('DD-MM-YYYY h:mm:ss a') : 'NA';

            let duration = v.duration || "00:00:00";
            let parts = duration.split(":");
            let hrs = parseInt(parts[0]) || 0;
            let mins = parseInt(parts[1]) || 0;
            let duration_human = hrs+' hrs '+mins+' min';
            let total_hours = hrs + (mins/60);
            let durationBadgeBg="#cce5ff", durationBadgeText="#004085";
            if(total_hours>12 && total_hours<=24){ durationBadgeBg="#f8d7da"; durationBadgeText="#721c24"; }
            else if(total_hours>24 && total_hours<=48){ durationBadgeBg="#fff3cd"; durationBadgeText="#856404"; }
            else if(total_hours>48){ durationBadgeBg="#d4edda"; durationBadgeText="#155724"; }

            $('#date_table_data').append('<tr>'+
                `<td>${start + i + 1}</td>`+
                `<td>${v.well_site_name}</td>`+
                `<td>${v.well_name}</td>`+
                `<td>${alert_data}</td>`+
                `<td>${alert_details}</td>`+
                `<td>${start_date_time}</td>`+
                `<td>${end_date_time}</td>`+
                `<td><span class="badge" style="background-color:${durationBadgeBg}; color:${durationBadgeText}; font-weight:600;">${duration_human}</span></td>`+
                '</tr>');
        });
    } else {
        $('#date_table_data').html('<tr><td colspan="9" class="text-danger text-center">No Record Found !!</td></tr>');
    }
}

function renderDatewisePagination(filteredData){
    let data = filteredData || datewiseData;
    let totalPages = Math.ceil(data.length / dateRowsPerPage);
    let html = '';
    for(let i=1;i<=totalPages;i++){
        html += `<button class="btn btn-sm ${i===dateCurrentPage?'btn-primary':'btn-outline-primary'} me-1" onclick="goDatePage(${i})">${i}</button>`;
    }
    $('#datewise_pagination').html(html);
}

function goDatePage(page){ dateCurrentPage=page; renderDatewiseTable(); renderDatewisePagination(); }



$('#wellRowsPerPage').on('change', function() {
    wellRowsPerPage = parseInt($(this).val());
    wellCurrentPage = 1;
    renderWellwiseTable();
    renderWellwisePagination();
});

$('#dateRowsPerPage').on('change', function() {
    dateRowsPerPage = parseInt($(this).val());
    dateCurrentPage = 1;
    renderDatewiseTable();
    renderDatewisePagination();
});

// Bind Search
$('#well_searchBox').on('input', function() {
    let term = $(this).val().toLowerCase();
    let filtered = wellwiseData.filter(r => Object.values(r).some(val => val && val.toString().toLowerCase().includes(term)));
    wellCurrentPage = 1;
    renderWellwiseTable(filtered);
    renderWellwisePagination(filtered);
});

$('#date_searchBox').on('input', function() {
    let term = $(this).val().toLowerCase();
    let filtered = datewiseData.filter(r => Object.values(r).some(val => val && val.toString().toLowerCase().includes(term)));
    dateCurrentPage = 1;
    renderDatewiseTable(filtered);
    renderDatewisePagination(filtered);
});

// Bind Sorting (Well-wise)
$('#well_table_header th[data-key]').on('click', function() {
    let key = $(this).data('key');
    let type = $(this).data('sort') || 'string';
    if(wellSortColumn === key) wellSortDir *= -1; 
    else { wellSortColumn = key; wellSortDir = 1; }
    $('#well_table_header th').removeClass('sort-asc sort-desc');
    $(this).addClass(wellSortDir===1?'sort-asc':'sort-desc');

    wellwiseData.sort((a,b)=>{
        let valA = a[key]||'', valB = b[key]||'';
        if(type==='number') return (parseFloat(valA)||0 - parseFloat(valB)||0)*wellSortDir;
        if(type==='date') return (new Date(valA)-new Date(valB))*wellSortDir;
        return valA.toString().localeCompare(valB.toString())*wellSortDir;
    });
    wellCurrentPage = 1;
    renderWellwiseTable();
    renderWellwisePagination();
});

// Bind Sorting (Date-wise)
$('#date_table_header th[data-key]').on('click', function() {
    let key = $(this).data('key');
    let type = $(this).data('sort') || 'string';
    if(dateSortColumn === key) dateSortDir *= -1; 
    else { dateSortColumn = key; dateSortDir = 1; }
    $('#date_table_header th').removeClass('sort-asc sort-desc');
    $(this).addClass(dateSortDir===1?'sort-asc':'sort-desc');

    datewiseData.sort((a,b)=>{
        let valA = a[key]||'', valB = b[key]||'';
        if(type==='number') return (parseFloat(valA)||0 - parseFloat(valB)||0)*dateSortDir;
        if(type==='date') return (new Date(valA)-new Date(valB))*dateSortDir;
        return valA.toString().localeCompare(valB.toString())*dateSortDir;
    });
    dateCurrentPage = 1;
    renderDatewiseTable();
    renderDatewisePagination();
});

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
<script>
   getWell_list();

function getWell_list() {  
    let company_id = "<?php echo $this->session->userdata('company_id') ?>";
    let user_id    = "<?php echo $this->session->userdata('user_id') ?>";
    let site_id    = $('#site_id').val();
    
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url();?>Selfflow_alert_c/getWell_list',
        data: { company_id: company_id, user_id: user_id, site_id: site_id },
        beforeSend: function () {
            // Loading indicator
            $('#well_id').html('<option>Loading...</option>');
        },
        success: function (res) {
            let data = JSON.parse(res);
            console.log("Response:", data);

            if (data.response_code == 200) {   
                if (data.data.length > 0) {
                    $('#well_id').empty();
                    $('#well_id').append('<option value="">Select Well</option>');

                    $.each(data.data, function (i, v) {
                        $('#well_id').append(
                            '<option value="' + v.well_id + '">' + v.well_name + '</option>'
                        );
                    });
                } else {
                    $('#well_id').html('<option value="">No Data Found</option>');
                }
            } else {
                swal('Error', data.msg, 'error');
                $('#well_id').html('<option value="">Error Loading Wells</option>');
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", error);
            $('#well_id').html('<option value="">Failed to load wells</option>');
        }
    });
}

    </script>