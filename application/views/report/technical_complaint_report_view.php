<div class="page-wrapper">
    <div class="content container-fluid pb-0">
        <div class="page-header">
            <div class="content-page-header">
                <h5>Complaint Report</h5>
            </div>  
        </div>
            <div class="row">                   
                    
                        <div class="col-lg-12">
                            <div class="card">
                               
                                <div class="card-body">
                                   <div class="row align-items-center">
                                        <div class="col">
                                           <h4 class="header-title mb-4"><b>Complaint Report</b></h4>
                                        </div>
                                        <div class="col-auto float-end ms-auto">
                                             <button class="btn btn-success btn-sm btn-rounded mx-2" onclick="export_report()" style="font-size: 14px;">Export</button>
                                        </div>
                                    </div>


                                    
                        <div class="row">
                            <div class="form-group col-md-4 mt-2">
                                <h5><b>Ticket ID</b></h5>
                                <select name="ticket_id" id="ticket_id" class="form-control select2" onchange="get_complaints_data();" >
                                    <option value="">Select </option>
                                    <?php 
                                        if (!empty($ticket_list))
                                        {
                                            foreach ($ticket_list as $key => $value)
                                            {
                                                ?>
                                                    <option  value="<?php echo $value['ticket_id']; ?>"><?php echo $value['ticket_id']; ?></option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group col-md-4 mt-2">
                                <h5><b>Site Name</b> </h5>
                                <select name="site_id" id="site_id" class="form-control select2" onchange="get_complaints_data();get_well_list();" >
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
                                 <h5><b>Well Name</b> </h5>
                                <select name="well_id" id="well_id" class="form-control select2" onchange="get_well_hdn_data();get_complaints_data();" >
                                    <option value="">Select </option>
                                </select>
                            </div>
                            <input type="hidden" name="well_id_hdn" id="well_id_hdn">
                            <input type="hidden" name="well_name_hdn" id="well_name_hdn">
                        </div>
                                      
                        <div class="row">
                            <div class="form-group col-md-4 mt-2">
                                <h5><b>From Date</b></h5>
                                <input type="date" name="from_date" id="from_date" class="form-control" value="<?php echo date('Y-m-d'); ?>"  onchange="get_complaints_data();get_well_wise_date();">
                            </div>

                            <div class="form-group col-md-4 mt-2">
                                <h5><b>To Date</b></h5>
                                <input type="date" name="to_date" id="to_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" onchange="get_complaints_data();get_well_wise_date();">
                            </div>

                            <div class="form-group col-md-4 mt-2">
                                <h5><b>Sort By</b></h5>
                                <select class="form-control select2" name="sort_by" id="sort_by" onchange="get_complaints_data();">
                                    <option value="">Select Column</option>
                                    <option value="ticket_id">Ticket Id</option>
                                    <option value="well_name">Well Name</option>
                                    <option value="device_name">Device Name</option>
                                    <option value="imei_no">Imei No</option>
                                    <option value="complaint_type">Reason For Complaint</option>
                                    <option value="complaint_description">Complaint Description</option>
                                    <option value="resolution_description">Resolution Description</option>
                                    <!-- <option value="c_date">Complaint Status</option> -->

                                </select>
                            </div>
                            
                        </div>

                             <div class="table-responsive mt-4">
                                <table class="table table-bordered border-bottom table-striped" id="data-table">
                                      <thead style="background-color:blue; color: white; text-align: center;">
                                        <tr>
                                          <th colspan="12" class="text-uppercase" style="font-size: 20px;font-weight: bolder;">IOT BASED REAL TIME WELL MONITORING SYSTEM ONGC,CAMBAY ASSET</th>
                                        </tr>
                                        <tr>
                                            <th colspan="12" id="report-heading" class="text-uppercase" style="font-size: 15px;font-weight: bolder;">Device Complaint Report as on<span id="show_from_date"></span> <span id="to">To</span> <span id="show_to_date"></span></th>
                                        </tr>
                                        <tr><th colspan="8">Complaint Details</th>
                                            <th colspan="4">Complaint Status</th>
                                           </tr>
                                        <tr>
                                            <th style="width:10%;">Sl No.</th>
                                            <th>Ticket Id</th>
                                            <th>Well Name</th>
                                            <th>Device Name</th>
                                            <th>Imei No</th>
                                            <th>Reason for Complaint</th>
                                            <th>Complaint Description</th>
                                            <th>Resolution Description</th>
                                            <th><button class="btn btn-sm btn-rounded btn-pill btn-primary" style="color:white;white-space: nowrap;">Raised </button></th>
                                            <th><button class="btn btn-sm btn-rounded btn-pill btn-info" style="color:white;white-space: nowrap;">In Progress </button></th>
                                            <th><button class="btn btn-sm btn-rounded btn-pill btn-success" style="color:white;white-space: nowrap;">Solved </button></th>
                                            <th>Total Resolution Time</th>
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
</script>

<script type="text/javascript">
get_well_list();
    function get_well_list()
    { 
       let company_id = "<?php echo $this->session->userdata('company_id') ?>";
       let user_id = "<?php echo $this->session->userdata('user_id') ?>";
       let site_id = $('#site_id').val();

       $.ajax({
            type: 'POST',
            url: '<?php echo base_url();?>Technical_compalint_c/getWell_list',
            data:{company_id:company_id,user_id:user_id,site_id:site_id},
            success:function(data)
            {
                data = JSON.parse(data);
             
                if(data.response_code==200)
                {   
                    if(data.data.length>0)
                    {
                        $('#well_id').html('');
                        $('#well_id').html('<option value=" ">Select well</option>');
                        $.each(data.data,function(i,v){
  
                         $('#well_id').append('<option value="'+ v.well_id +'|'+v.well_name+'|'+v.long+'">'+v.well_name+'</option>');
                           
                            
                        });
                        
                    }else
                    {
                        $('#well_id').html('No Data Found');
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


<script type="text/javascript">
 get_complaints_data();

function get_complaints_data() {
    let company_id = "<?php echo $this->session->userdata('company_id') ?>";
   
    let from_date = $('#from_date').val();
    let to_date = $('#to_date').val();
    let ticket_id = $('#ticket_id').val();
    let well_id = $('#well_id_hdn').val();
    let site_id = $('#site_id').val();
    let sort_by = $('#sort_by').val();

   

     var selectedRefrigratorName = $('#site_id option:selected').text();
        var selectedLoggerName = $('#well_name_hdn').val();
      
  
        let formattedFromDate = moment(from_date, 'YYYY-MM-DD').format('DD-MM-YYYY');
        let formattedToDate = moment(to_date, 'YYYY-MM-DD').format('DD-MM-YYYY');



          let headingText = `Complaint Report ${formattedFromDate} to ${formattedToDate} of  ${selectedRefrigratorName} ( ${selectedLoggerName} )`;
         $('#report-heading').text(headingText);
  


    $.ajax({
        url: '<?php echo base_url(); ?>Technical_compalint_c/complaints_report_log_details',
        method: 'POST',
        data: { company_id: company_id, from_date: from_date, to_date: to_date, ticket_id: ticket_id,well_id:well_id,site_id:site_id,sort_by:sort_by},
        success: function (res) {
            var response = JSON.parse(res);
   
            if (response.response_code == 200) {
                $('#table_data').html("");
                if (response.data.length > 0) {

                    var total_minutes_sum = 0;
                    var total_hours_sum = 0;
                   
                    $.each(response.data, function (i, v) {
                        var totalResolutionHours = v.totalResolutionHours;
                        
                        var complaint_type_status;
                        var compaint_type = v.complaint_type;
                        if (compaint_type == 0) {
                            complaint_type_status = 'RTMS Offline';
                        } else if (compaint_type == 1) {
                            complaint_type_status = 'RTMS Physical Damage';
                        } else if (compaint_type == 2) {
                            complaint_type_status = 'RTMS Burn';
                        } else if (compaint_type == 3) {
                            complaint_type_status = 'Others';
                        }
                          

                           var complaint_date_status = v.complaint_date ? v.complaint_date.split(',') : [];
                       

                            var pending_date = complaint_date_status[0] || '-';
                            var inprogress_date = complaint_date_status[1] || '-';
                            var solved_date = complaint_date_status[2] || '-';

                           

                            var formattedPendingDate = pending_date !== '-' ? moment(pending_date).format('DD-MM-YYYY h:mm:ss a') : '-';
                            var formattedInProgressDate = inprogress_date !== '-' ? moment(inprogress_date).format('DD-MM-YYYY h:mm:ss a') : '-';
                            var formattedSolvedDate = solved_date !== '-' ? moment(solved_date).format('DD-MM-YYYY h:mm:ss a') : '-';
                          

                            var pending_date_data = (complaint_date_status[0]) || 0;
                            var solved_date_data = (complaint_date_status[2]) || 0;
                            
                            if(solved_date_data == 0)
                            {
                                 totalResolutionHours = '';
                                 var total_minute  = 0;
                             }else{
                                

                                    var formattedDateObj = new Date(solved_date_data);
                                    var lastDataTimeObj = new Date(pending_date_data);
                                    var diffInMilliseconds = formattedDateObj - lastDataTimeObj;
                                    var diffInMinutes = Math.floor(diffInMilliseconds / (1000 * 60));
                                    var hours = Math.floor(diffInMinutes / 60);
                                    var minutes = diffInMinutes % 60;

                                
                                    totalResolutionHours = hours + ' hours ' + minutes + ' minutes';  
                                     total_hours_sum += parseFloat(hours * 60);
                                     // console.log(total_hours_sum);
                                     total_minutes_sum += parseFloat(minutes);
                            }


                           $("#table_data").append('<tr>' +
                                '<td>' + (i + 1) + '</td>' +
                                '<td>' + v.ticket_id + '</td>' +
                                '<td>' + v.well_name + '</td>' +
                                '<td>' + v.device_name + '</td>' +
                                '<td>' + v.imei_no + '</td>' +
                                '<td>' + complaint_type_status + '</td>' +
                                '<td>' + (v.complaint_description ? v.complaint_description:'NA')+ '</td>' +
                                '<td>' + (v.resolution_description ? v.resolution_description : 'NA') + '</td>' +
                         
                                '<td>' + formattedPendingDate + '</td>' +
                                '<td>' + formattedInProgressDate + '</td>' +
                                '<td>' + formattedSolvedDate + '</td>' +
                                '<td>'+ totalResolutionHours +'</td>'+
                                
                            '</tr>');

                            });


                            var totalHours = Math.floor(total_hours_sum / 60);
                            var totalMinutes = total_minutes_sum % 60;
                            var total_duration = totalHours + ' hours ' + totalMinutes + ' minutes';

                        $("#table_data").append('<tr>' +
                          
                          '<td style="height:35px;"></td>' +
                          '<td style="height:35px;"></td>' +   
                          '<td style="height:35px;"></td>' +   
                          '<td style="height:35px;"></td>' +   
                          '<td style="height:35px;"></td>' +   
                          '<td style="height:35px;"></td>' +   
                          '<td style="height:35px;"></td>' +   
                          '<td style="height:35px;"></td>' +   
                          '<td style="height:35px;"></td>' +   
                          '<td style="height:35px;"></td>' +   
                          '<td style="height:35px;"></td>' +   
                          '<td style="height:35px;"></td>' +
                        '</tr>'
                        );

                        $("#table_data").append('<tr>' +
                          
                          '<td style="height:35px;"></td>' +
                          '<td style="height:35px;"></td>' +   
                          '<td style="height:35px;"></td>' +   
                          '<td style="height:35px;"></td>' +   
                          '<td style="height:35px;"></td>' +   
                          '<td style="height:35px;"></td>' +   
                          '<td style="height:35px;"></td>' +   
                          '<td style="height:35px;"></td>' +   
                          '<td style="height:35px;"></td>' +   
                          '<td style="height:35px;"></td>' +   
                          '<td style="height:35px;"></td>' +   
                          '<td style="height:35px;"></td>' +


                       
                        '</tr>'
                        );

                             $("#table_data").append('<tr>' +
                           '<td colspan="1" style="text-align:right;"><b>Sign of Installation Manager</b></td>' +
                           '<td><b>'+'<img src="">'+'</b></td>' +

                           '<td colspan="9" style="text-align:right;"><b>Total</b></td>' +
                           '<td><b>' + total_duration + '</b></td>' +


                       
                        '</tr>'
                        );

                } else {
                    $('#table_data').html('<tr>' +
                        '<td class="text-danger" style="text-align:center;" colspan="20">No Record Found !!</td>' +
                        '</tr>');
                }
            }
        }
    });
}

</script>

<script type="text/javascript">
    function get_well_hdn_data()
    {
        let device_data = $('#well_id').val();
        $('#well_id_hdn').val(device_data.split('|')[0]);
       
        $('#well_name_hdn').val(device_data.split('|')[1]);
    }
    
</script>

<script src="<?php echo base_url(); ?>assets/local/excel/xlsx.full.min.js"></script>
<script type="text/javascript">
    
    function export_report() {
      var sheetName = "Sheet1";
      var fileName = "Complaints Report.xlsx";
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
         

                

