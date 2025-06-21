<div class="page-wrapper">
    <div class="content container-fluid pb-0">
<div class="container-xxl">

    <!-- Breadcrumb Start -->
    <div class="row">

        <div class="col-12 px-0">
            <div class="d-flex justify-content-between align-items-center">
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent">
                        <li class="breadcrumb-item">
                            <a href="<?php echo base_url(); ?>">Home</a>
                        </li>
                        <li class="breadcrumb-item active m-0 p-0" aria-current="page">
                            Device Installtion Report
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- Breadcrumb End -->

    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header mb-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="mb-1">Device Installtion Report</h4>
                        </div>
                        <div class="col-auto ms-auto d-flex gap-2">
                            <button type="button" id="export_btns" onclick="export_report()" class="btn btn-sm btn-primary motion-btn">
                                <i class="fas fa-file-export me-1" style="font-size: 12px;"></i> Export</button>
                        </div>
                    </div>
                </div>

                <hr class="mt-n1 mb-3">            

            <div class="filter-section" style="padding: 15px 20px;">
                <div class="col-xl-12">
                    <div class="row">
                        <div class="form-group col-md-4 mt-2">
                                <h5><b>Assets Name</b></h5>
                                <select name="assets_id" id="assets_id" class="form-control select2" onchange="get_installation_report();get_area_list();">
                                    <option value=""> Select Assets </option>
                                    <?php 
                                    if (!empty($assets_list))
                                    {
                                        foreach ($assets_list as $key => $value)
                                        {
                                            ?>
                                                <option value="<?php echo $value['assets_id']; ?>"><?php echo $value['assets_name']; ?></option>

                                            <?php
                                        }
                                    }

                                    ?>
                                </select>
                            </div>

                                <div class="form-group col-md-4 mt-2">
                                    <h5><b>Area Name</b></h5>
                                    <select name="area_id" id="area_id" class="form-control select2" onchange="get_installation_report();get_sitelist();">
                                        <option value=""> Select </option>
                                        
                                    </select>
                                </div>

                                <div class="form-group col-md-4 mt-2">
                                    <h5><b>Site Name</b></h5>
                                    <select name="site_id" id="site_id" class="form-control select2" onchange="get_installation_report();">
                                        <option value=""> Select </option>
                                        
                                    </select>
                                </div>
                                <div class="form-group col-md-4 mt-2">
                                    <h5><b>From Date</b></h5>
                                    <input type="date" name="from_date" id="from_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" onchange="get_installation_report();get_installation_date();">
                                </div>

                                <div class="form-group col-md-4 mt-2">
                                    <h5><b>To Date</b></h5>
                                    <input type="date" name="to_date" id="to_date" class="form-control" value="<?php echo date('Y-m-d'); ?>"  onchange="get_installation_report();get_installation_date();">
                                </div>
                            </div>
                            <div class="table-responsive mt-4">
                                <table class="table table-bordered border-bottom table-striped" id="data-table">
                                      <thead style="background-color:#d9e1ec; color: white; text-align: center;">
                                        <tr>
                                          <th colspan="25" class="text-uppercase" style="font-size: 20px;font-weight: bolder;">IOT Based Real Time Well Monitoring System ONGC Rajahmundry, Asset</th>
                                        </tr>
                                        <tr>
                                            <th colspan="25" class="text-uppercase" style="font-size: 15px;font-weight: bolder;">Device Installation Report as on <span id="show_from_date"></span> <span id="to">To</span> <span id="show_to_date"></span></th>
                                        </tr>
                                        <tr>
                                            <th style="width:10%;">Sl No.</th>
                                            <th>Area Name</th>
                                            <th>Site Name</th>
                                            <th>Well Name</th>
                                            <th>Device Name</th>
                                            <th>IMEI No</th>
                                            <th>Serial No</th>
                                            <th>User Name</th>
                                            <th>Installation Date</th>
                                            <th>Sim Provider</th>
                                            <th>Network Type</th>
                                            <th>Latitude</th>
                                            <th>Longitude</th>
                                            <th>GPS Latitude</th>
                                            <th>GPS Longitude</th>
                                            <th>Image</th>
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

<!-- ========= modal for image viewer starts ================================== -->

<div class="modal fade"  id="ImageViewModal">
    <div class="modal-dialog modal-md" role="document" >
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Image Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="width:100%;">
                <img src="" id="image_view" alt="image-view-area" style="width:100%;height: 100%;">
            </div>
        </div>
    </div>
</div>

<!-- ========== modal for image viewer ends =================================== -->
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
</script>
<script type="text/javascript">
    
    
    function get_area_list()
    {
        let company_id = "<?php echo $this->session->userdata('company_id') ?>";
        let assets_id = $('#assets_id').val();
        // alert(assets_id);
         $.ajax({
            url: '<?php echo base_url(); ?>Device_installation_report_c/get_area_list',
            type: 'POST',
            data: {company_id:company_id,assets_id: assets_id},
            success:function(res)
            {
                response = JSON.parse(res);
                console.log(response);
                if(response.data.length>0)
                {
                    $('#area_id').html('<option value="">Select Area</option>');
                    $.each(response.data,function(i,v){
                        $('#area_id').append('<option value="'+v.id+'">'+v.area_name+'</option>');
                    });
                }
            }
        });
    }

    function get_sitelist()
    {
        let company_id = "<?php echo $this->session->userdata('company_id') ?>";
        let area_id = $('#area_id').val();
        // alert(area_id);
         $.ajax({
            url: '<?php echo base_url(); ?>Device_installation_report_c/get_site_list',
            type: 'POST',
            data: {company_id:company_id,area_id: area_id},
            success:function(res)
            {
                response = JSON.parse(res);
                console.log(response);
                if(response.data.length>0)
                {
                    $('#site_id').html('<option value="">Select site</option>');
                    $.each(response.data,function(i,v){
                        $('#site_id').append('<option value="'+v.id+'">'+v.well_site_name+'</option>');
                    });
                }
            }
        });
    }
</script>

<script type="text/javascript">
    
get_installation_report();
function get_installation_report()
{
    let company_id = "<?php echo $this->session->userdata('company_id') ?>";
    let assets_id = $('#assets_id').val();
    let area_id = $('#area_id').val();
    let site_id = $('#site_id').val();
    let from_date = $('#from_date').val();
    let to_date = $('#to_date').val();
    // alert(assets_id);

    $.ajax({
        url:'<?php echo base_url(); ?>Device_installation_report_c/get_installation_report',
        method:'POST',
        data:{company_id:company_id,from_date:from_date,to_date:to_date,assets_id:assets_id,area_id:area_id,site_id:site_id},
        success:function(res)
        {
            var response = JSON.parse(res);
            // console.log(response);
            if(response.response_code==200)
                {
                    $('#table_data').html("");
                     if(response.data.length > 0)
                     {
                        $.each(response.data,function(i,v){
                            let image = v.image;
                            let image_design = '';
                            if(image!=null)
                            {
                               image_design += '<a id="'+image+'" onclick="viewImage(this.id)" data-bs-toggle="modal" data-bs-target="#ImageViewModal"><img src="'+image+'" width="100" class="text-center" style="cursor: pointer;"></a>';
                               
                            }else{
                               image_design = '<p class="mx-3 text-center"></p>';
                            }
                            var sim_provider = v.sim_provider == 1 ? "Vi" : v.sim_provider == 2 ? "Airtel" : v.sim_provider == 3 ? "JIO"  : "NA";

                            var network_type = v.network_type == 1 ? "2G" : v.network_type == 2 ? "3G" : v.network_type == 3 ? "4G" : "NA";

                             v.area_name = v.area_name ?? "NA";
                                v.well_site_name = v.well_site_name ?? "NA";
                                v.well_name = v.well_name ?? "NA";
                            
                          $("#table_data").append('<tr>' +
                            '<td>' + (i + 1) + '</td>' +
                            '<td>' + (v.area_name !== null ? v.area_name : 'NA') + '</td>' +
                            '<td>' + (v.well_site_name !== null ? v.well_site_name : 'NA') + '</td>' +
                            '<td>' + (v.well_name !== null ? v.well_name : 'NA') + '</td>' +
                            '<td>' + (v.device_name !== null ? v.device_name : 'NA') + '</td>' +
                            '<td>' + (v.imei_no !== null ? v.imei_no : 'NA') + '</td>' +
                            '<td>' + (v.serial_no !== null ? v.serial_no : 'NA') + '</td>' +
                            '<td>' + (v.user_full_name !== null ? v.user_full_name : 'NA') + '</td>' +
                            '<td>' + (moment(v.date_of_installation).format('DD-MM-YYYY h:mm:ss a') !== null ? moment(v.date_of_installation).format('DD-MM-YYYY h:mm:ss a') : 'NA') + '</td>' +
                            '<td>' + (sim_provider !== null ? sim_provider : 'NA') + '</td>' +
                            '<td>' + (network_type !== null ? network_type : 'NA') + '</td>' +
                            '<td>' + (v.lat !== null ? v.lat : 'NA') + '</td>' +
                            '<td>' + (v.long !== null ? v.long : 'NA') + '</td>' +
                            '<td>' + (v.gps_lat!== null ? v.gps_lat :'NA')+'</td>'+
                            '<td>' + (v.gps_long!== null ? v.gps_long :'NA')+'</td>'+
                            '<td>' + image_design + '</td>' +
                            '</tr>');
                        });
                     }
                     else{
                        $('#table_data').html('<tr>'+
                                 '<td class="text-danger" style="text-align:center;" colspan="25">No Record Found !!</td>'+
                              '</tr>');
                     }
                }

        }
        
    });
}

function viewImage(id)
{
   $('#image_view').attr('src',id);
}
</script>


<script src="<?php echo base_url(); ?>assets/local/excel/xlsx.full.min.js"></script>
<script type="text/javascript">
    
    function export_report() {
      var sheetName = "Sheet1";
      var fileName = "Installation report.xlsx";
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
         

                

