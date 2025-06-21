<style type="text/css">
    
    table thead tr th{
        background: #daebf9 !important;
    }
   
     .btn.btn-rounded {
      border-radius: 50px;
     }

     #content {
    margin-top: 50px;
    text-align: center;
}

section.timeline-outer {
    width: 80%;
    margin: 0 auto;
}

.timeline {
    border-left: 4px solid #42A5F5;
    border-bottom-right-radius: 2px;
    border-top-right-radius: 2px;
    box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
    color: #333;
    margin: 50px auto;
    letter-spacing: 0.5px;
    position: relative;
    line-height: 1.4em;
    padding: 20px;
    list-style: none;
    text-align: left;
}

.timeline h1,
.timeline h2,
.timeline h3 {
    font-size: 1.4em;
}



.timeline .event {
    border-bottom: 1px solid rgba(160, 160, 160, 0.2);
    padding-bottom: 15px;
    margin-bottom: 20px;
    position: relative;
}

.timeline .event:last-of-type {
    padding-bottom: 0;
    margin-bottom: 0;
    border: none;
}

.timeline .event:before,
.timeline .event:after {
    position: absolute;
    display: block;
    top: 0;
}

.timeline .event:before {
    left: -177.5px;
    color: #212121;
    content: attr(data-date);
    text-align: right;
    font-size: 16px;
    min-width: 120px;
}

.timeline .event:after {
    box-shadow: 0 0 0 8px #42A5F5;
    left: -30px;
    background: #212121;
    border-radius: 50%;
    height: 11px;
    width: 11px;
    content: "";
    top: 5px;
}

.timeline .event.one:after {
    box-shadow: 0 0 0 8px red;
    left: -30px;
    background: #fff;
}

.timeline .event.two:after {
    box-shadow: 0 0 0 8px orange;
    left: -30px;
    background: #fff;
}

.timeline .event.three:after {
    box-shadow: 0 0 0 8px #27ae60;
    left: -30px;
    background: #fff;
}

    
</style>

 <div class="page-wrapper">
    <div class="content container-fluid pb-0">
        <div class="page-header">
            <div class="content-page-header">
                <h5>Maintenance Report</h5>
            </div>  
        </div>
            <div class="row">                   
                    
                        <div class="col-lg-12">
                            <div class="card">
                               
                                <div class="card-body">
                                   <div class="row align-items-center">
                                        <div class="col">
                                           <h4 class="header-title mb-4"><b>Maintenance Report</b></h4>
                                        </div>
                                        <div class="col-auto float-end ms-auto">
                                             <a href="Dashboard_c"><button class="btn btn-sm  btn-primary mx-2">Back</button></a>
                                             <button class="btn btn-success btn-sm" onclick="export_report()" style="font-size: 14px;">Export</button>
                                        </div>
                                    </div>

                      <div class="row">
                        <div class="form-group col-md-3 mt-2">
                            <label for="example-select" class="form-label">Well Name</label>
                            <select onchange="get_maintance_log();" class="form-select select2" id="well_id" name="well_id">
                                <option value="">Select Well</option>
                                <?php 
                                    if (!empty($well_list))
                                    {
                                        foreach ($well_list as $key => $value)
                                        {
                                            ?>
                                                <option value="<?php echo $value['id']; ?>"><?php echo $value['well_name']; ?></option>

                                            <?php
                                        }
                                    }

                                    ?>
                                    
                            </select>
                        </div>
                         <div class="form-group col-md-3 mt-2">
                            <label for="example-select" class="form-label">Well Name</label>
                            <select onchange="get_maintance_log();" class="form-select select2" id="issue_status" name="issue_status">
                                <option value="">Select Issue</option>
                                <?php 
                                    if (!empty($issue_list))
                                    {
                                        foreach ($issue_list as $key => $value)
                                        {
                                            ?>
                                                <option value="<?php echo $value['id']; ?>"><?php echo $value['issue_type']; ?></option>

                                            <?php
                                        }
                                    }

                                    ?>
                                    
                            </select>
                        </div>
                                <div class="form-group col-md-3 mt-2">
                                     <label for="example-select" class="form-label">From Date</label>
                                    <input type="date" name="from_date" id="from_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" onchange="get_maintance_log();get_installation_date();">
                                </div>

                                <div class="form-group col-md-3 mt-2">
                                     <label for="example-select" class="form-label">To Date</label>
                                    <input type="date" name="to_date" id="to_date" class="form-control" value="<?php echo date('Y-m-d'); ?>"  onchange="get_maintance_log();get_installation_date();">
                                </div>
                            </div>
           
                             <div class="table-responsive mt-4">
                                <table class="table table-bordered border-bottom table-striped" id="datatable">
                                      <thead style="background-image:linear-gradient(to bottom right, #165c5121, #adefd1 color: white; text-align: center;">
                                        <tr>
                                          <th colspan="16" class="text-uppercase text-center" style="font-size: 20px;font-weight: bolder;">IOT Based Real Time Well Monitoring System ONGC,Cambay Asset</th>
                                        </tr>
                                        <tr>
                                            <th colspan="16" class="text-uppercase text-center" style="font-size: 15px;font-weight: bolder;">Maintenance Log Report as on <span id="show_from_date"></span> <span id="to">To</span> <span id="show_to_date"></span></th>
                                        </tr>
                                        <tr class="text-center">
                                            <th style="width:10%;">Sl No.</th>
                                            <th>Maintenance Id</th>
                                            <th>Area Name</th>
                                            <th>Site Name</th>
                                            <th>Well Name</th>
                                            <th>Issue Type</th>
                                            <th>Maintenance status</th>
                                            <th>Action Taken</th>
                                            <th>Quantity</th>
                                            <th>Item Serial</th>
                                            <th>Create By</th>
                                            <th>Create Date</th>
                                            <th>Update By</th>
                                            <th>Update Date</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center" id="table_data"> 
                                    </tbody>
                                </table>
                        </div>
        </div>
    </div>
</div>
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight2" aria-labelledby="offcanvasRightLabel">
                        <div class="offcanvas-header">
                              <h4 id="offcanvasRightLabel" style="text-align: center;">Maintenance Ticket Status - <span id="ticket_name"></span> | Area : (<span id="area_name_data"></span>) | Site : (<span id="well_site_name_data"></span>) | Well : ( <span id="well_name_data"></span>) | Issue : <span id="issue_type_data"></span> </h4>
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div> 
                        <div class="offcanvas-body">
                            <div class="col-xxl-6">
                            
                                <section id="timeline" class="timeline-outer">
                                <div class="main-container mt-n4" style="display: none; " id="resolution_time_show">
                                    <hr style="color:blue;">
                                    <div class="container" id="content">
                                        <ul class="timeline">
                                             <div id="maintance_resolution_data"></div>

                                        </ul>
                                    </div>
                                </div>
                                <div class="main-container mt-n4">
                                    <hr style="color:blue;">
                                    <div class="container" id="content">
                                        <ul class="timeline">
                                            <div id="maintance_data"></div>

                                        </ul>
                                    </div>
                                </div>

                                
                            </section>
                        
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
</script>
<script type="text/javascript">
  get_maintance_log();
    function get_maintance_log() {
    $('#table_data').html('<tr><td colspan="16">processing please wait.......</td></tr>');
    var from_date = $('#from_date').val();
    var to_date = $('#to_date').val();
    var well_id = $('#well_id').val();
    var area_id = $('#area_id').val();
    var site_id = $('#site_id').val();
    var issue_status = $('#issue_status').val();
    $.ajax({
        url: '<?php echo base_url(); ?>Maintenance_c/get_maintenance_report',
        method: 'POST',
        data: {area_id:area_id,site_id:site_id,well_id:well_id,from_date:from_date,to_date:to_date,issue_status:issue_status},
        success: function (res) {
            var response = JSON.parse(res);
            console.log(response);
            if (response.response_code == 200) {
                $('#table_data').html("");
                if (response.data.length > 0) {
                    
                    $.each(response.data, function (i, v) {
                         var issue_status = v.issue_status;
                      var issue_status_badge = '';

                      if (issue_status == 1) {
                            issue_status_badge = '<button class="btn btn-sm btn-rounded btn-pill" style="color:white;background-color:#f59440;white-space: nowrap;">Open </button>';
                        } else if (issue_status == 2) {
                            issue_status_badge = '<button class="btn btn-sm btn-rounded btn-pill" style="color:white;background-color:#ce2029;white-space: nowrap;">In Progress</button>';
                        } else if (issue_status == 3) {
                            issue_status_badge = '<button class="btn btn-sm btn-rounded btn-pill" style="color:white;background-color:#008000ed;white-space: nowrap;">Closed</button>';
                        }

                        var c_date  = v.c_date != null ? moment(v.c_date).format('DD-MM-YYYY h:mm:ss a') :"";
                         var d_date  = v.d_date != null ? moment(v.d_date).format('DD-MM-YYYY h:mm:ss a') :"";
                         action_taken_data = '';
                         var action_taken = v.action_taken;
                         if(action_taken == 1)
                         {
                             action_taken_data ='<button class="btn btn-sm btn-rounded btn-pill" style="color:white;background-color:#008000ed;white-space: nowrap;">Repaired</button>'
                         }else if(action_taken == 2)
                         {
                             action_taken_data ='<button class="btn btn-sm btn-rounded btn-pill" style="color:white;background-color:#f59440;white-space: nowrap;">Replaced</button>'
                         }else{
                             action_taken_data = '';
                         }
                        $("#table_data").append('<tr>' +
                            '<td>' + (i + 1) + '</td>' +
                            '<td><button class="btn btn-sm btn btn-success" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight2" aria-controls="offcanvasRight" onclick="get_maintance_timeline(\'' + v.maintance_id + '\')">' + v.maintance_id +
                                '</button></td>' +
                            '<td>' + v.area_name + '</td>' +
                            '<td>' + v.well_site_name + '</td>' +
                            '<td>' + v.well_name + '</td>' +
                            '<td>' + v.issue_type + '</td>' +
                            '<td>' + issue_status_badge + '</td>' +
                            '<td>' + action_taken_data + '</td>' +
                            '<td>' + (v.quantity ? v.quantity : '') + '</td>' +
                            '<td>' + (v.item_serial ? v.item_serial : '') + '</td>' +
                          
                            '<td>' + (v.create_by && v.create_id ? v.create_by + ' (' + v.create_id + ')' : '') + '</td>' + 
                            '<td>' + c_date + '</td>' +
                            '<td>' + (v.update_by && v.update_id ? v.update_by + ' (' + v.update_id + ')' : '') + '</td>' + 
                            '<td>' + d_date + '</td>' +
                            '</tr>');
                    });

                   
                } else {
                    $('#table_data').html('<tr>' +
                        '<td class="text-danger" style="text-align:center;" colspan="16">No Record Found !!</td>' +
                        '</tr>');
                }
            }
        }

    });
}
</script>
<script type="text/javascript">
     
function get_maintance_timeline(maintance_id) {
    // alert(maintance_id);
    
    $.ajax({
        url: '<?php echo base_url(); ?>Maintenance_c/get_timeline_maintance_details',
        method: 'POST',
        data: {
            maintance_id,
            maintance_id
        },
        success: function (res) {
            var response = JSON.parse(res);
            // console.log('complaint_data=', response);

            if (response.status) {

                $('#maintance_data').html('');

                $('#maintance_resolution_data').html('');

                if (response.data.mainteance_timeline.length > 0) {

                  
                    $.each(response.data.mainteance_timeline, function (i, v) {

                            var ticket_name = v.maintance_id;
                            $('#ticket_name').text(ticket_name);
                             var well_name = v.well_name;
                            $('#well_name_data').text(well_name);

                            var area_name = v.area_name;
                            $('#area_name_data').text(area_name);

                            var well_site_name = v.well_site_name;
                            $('#well_site_name_data').text(well_site_name);

                            var issue_type = v.issue_type;
                            $('#issue_type_data').text(issue_type);
                            

                              var eventColor = (v.issue_status == 1) ? 'one' : (v.issue_status == 2) ? 'two' : 'three';

                            
                             var textColor = (v.issue_status == 1) ? '#EE0A0A' : (v.issue_status == 2) ? 'orange' : '#27ae60 ';
                              var textComplaint = (v.issue_status == 1) ? ' Open Case' : (v.issue_status == 2) ? 'In Progress Case' : 'Closed Case';
                               
                               

                                var htmlContent =

                                    
                                    '<li class="event ' + eventColor + '" style="color: ' + textColor + ';">' +
                                    '<p> <span style="color: ' + textColor + ';">' + textComplaint + '</span></p>' +
                                
                                    '<p> <span style="color: ' + textColor + ';">' + moment(v.c_date).format('DD-MM-YYYY h:mm:ss a') + '</span></p>' +
                                    '<p> <span style="color: ' + textColor + ';">' + (v.user_data) + '</span></p>' +
                                 
                                         '</li>';
                                   
                                $('#maintance_data').append(htmlContent);
                            
                        
                    });
                }

                  $('#resolution_time_show').hide();

                 if (response.data.mainteance_resolution.length > 0) {

                        $('#resolution_time_show').show();
                    $.each(response.data.mainteance_resolution, function (i, v) {

                            var ticket_name = v.ticket_id;
                            $('#ticket_name').text(ticket_name);
                            
                             var textColor = (v.issue_status == 1) ? '#EE0A0A' : (v.issue_status == 2) ? 'orange' : '#27ae60';
                              var textComplaint = (v.issue_status == 1) ? ' Case On Time' : (v.issue_status == 2) ? 'Case Resolution Time' : 'Case Resolution Time';
                               
                              var cDateMoment = moment(v.c_date);
                              var dDateMoment = moment(v.d_date);

                              var duration = moment.duration(dDateMoment.diff(cDateMoment));
                              var hours = Math.floor(duration.asHours());
                              var minutes = Math.floor(duration.asMinutes()) % 60;

                             
                                 var htmlContent =
                                 '<li class="timeline-item timeline-item-transparent">' +
                                     '<span class="timeline-dot timeline-dot-primary">'+
                                     '</span>'+
                                   '<p style="color: ' + textColor + ';">'+ textComplaint +'</p>'+
                                   '<p> <span style="color: ' + textColor + ';">' + hours + ' hours ' + minutes + ' minutes</span></p>' +
                                 
                                    '</li>';
                                 $('#maintance_resolution_data').append(htmlContent);
                            

                    });
                }


            } else {
                $('#maintance_data').html('<p>No data available</p>');
            }
        }
    });
}

</script>
<script src="<?php echo base_url(); ?>assets/local/excel/xlsx.full.min.js"></script>
<script type="text/javascript">
    
    function export_report() 
    {
      var sheetName = "Sheet1";
      var fileName = "maintenance Log report.xlsx";
      var table = $("#datatable")[0];
      // Convert table to worksheet
      var ws = XLSX.utils.table_to_sheet(table);
      // Create a new workbook and add the worksheet to it
      var wb = XLSX.utils.book_new();
      XLSX.utils.book_append_sheet(wb, ws, sheetName);
      // Save the workbook as an Excel file and download it
      XLSX.writeFile(wb, fileName);
    }

</script>
         

                

