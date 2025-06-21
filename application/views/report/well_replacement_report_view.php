<style>
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
    box-shadow: 0 0 0 8px green;
    left: -30px;
    background: #fff;
}

.timeline .event.two:after {
    box-shadow: 0 0 0 8px orange;
    left: -30px;
    background: #fff;
}


</style>

<div class="page-wrapper">
    <div class="content container-fluid pb-0">
        <div class="page-header">
            <div class="content-page-header">
                <h5>Device Shifting Report</h5>
            </div>
        </div>
        <div class="row">
            <!-- Lightbox -->
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="header-title mb-4"><b>Device Shifting Report</b></h4>
                            </div>
                            <div class="col-auto float-end ms-auto">
                                <button class="btn btn-success btn-sm btn-rounded mx-2" onclick="export_report()" style="font-size: 14px;">Export</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4 mt-2">
                                <h5><b>Well name</b></h5>
                                <select name="well_id" id="well_id" class="form-control select2" onchange="get_well_replacement_report();">
                                    <option value="">Select Well </option>
                                    <?php
                                    if (!empty($well_list)) {
                                        foreach ($well_list as $key => $value) {
                                    ?>
                                            <option value="<?php echo $value['well_id']; ?>"><?php echo $value['well_name'] ?>
                                            </option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group col-md-4 mt-2">
                                <h5><b>From Date</b></h5>
                                <input type="date" name="from_date" id="from_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" onchange="get_well_replacement_report();get_shiftdate();">
                            </div>

                            <div class="form-group col-md-4 mt-2">
                                <h5><b>To Date</b></h5>
                                <input type="date" name="to_date" id="to_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" onchange="get_well_replacement_report();get_shiftdate();">
                            </div>
                        </div>
                        <div class="row">
                            <!-- <div class="col-md-8"> -->

                            <div class="table-responsive mt-4">
                                <table class="table table-bordered border-bottom table-striped" id="data-table">
                                    <thead style="background-color:blue; color: white; text-align: center;">
                                        <tr>
                                            <th colspan="10" class="text-uppercase" style="font-size: 20px;font-weight: bolder;">IOT BASED REAL TIME WELL MONITORING SYSTEM ONGC,CAMBAY ASSET</th>
                                        </tr>
                                        <tr>
                                            <th colspan="14" class="text-uppercase" style="font-size: 15px;font-weight: bolder;">Device Shifting Report as on &nbsp;<span id="show_from_date"></span> <span id="to">To</span> <span id="show_to_date"></span>
                                                </th>
                                        </tr>
                                        <tr>
                                            <th style="width:10%;">Sl No.</th>
                                            <th>From Well Name</th>
                                            <th>From Well Device Name</th>
                                            <th>From Well IMEI No</th>
                                            <th>To Well Name</th>
                                            <th>To Well Previous Device Name</th>
                                            <th>To Well Previous IMEI No</th>
                                            <th>To Well Current Device Name</th>
                                            <th>To Well Current IMEI No</th>
                                            <th>Shifted Date-Time</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center" id="table_data">
                                    </tbody>
                                </table>
                            </div>
                            <!-- </div> -->
                            <div class="col-md-4">
                                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                                    <h1 class="text-center mt-5" style="font-size: 1.4em;">Implementation Cycle of Imei No. - <span id="imei_no"></span></h1>


                                    <div class="offcanvas-body ">
                                        <section id="timeline" class="timeline-outer">
                                            <div class="main-container mt-n4">
                                                <hr style="color:blue;">
                                                <div class="container" id="content">
                                                    <ul class="timeline">
                                                       <div id="well_details"></div>
                                                    </ul>
                                                </div>

                                            </div>
                                        </section>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="offcanvas offcanvas-end" tabindex="-1" id="model2" aria-labelledby="offcanvasRightLabel">
                                    <h1 class="text-center mt-5" style="font-size: 1.4em;"> Implementation Cycle of  Well - <span id="well_name"></span> </h1>
                                    <div class="offcanvas-body ">
                                        <section id="timeline" class="timeline-outer">
                                            <div class="main-container mt-n4">
                                                 <hr style="color:blue;">
                                                <div class="container" id="content">
                                                    <ul class="timeline">
                                                       <div id="well_data_id"></div>
                                                    </ul>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
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
        get_shiftdate();
    function get_shiftdate()
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

    get_well_replacement_report();

    function get_well_replacement_report() 
    {
        let company_id = "<?php echo $this->session->userdata('company_id') ?>";
        // alert(company_id);
        let user_id = "<?php echo $this->session->userdata('user_id') ?>";
        // alert(user_id);
        let from_date = $('#from_date').val();
        let to_date = $('#to_date').val();
        let well_id = $('#well_id').val();

        $.ajax({
            url: '<?php echo base_url(); ?>Well_replacement_report_c/get_shifted_well_data',
            method: 'POST',
            data: {
                company_id: company_id,
                user_id: user_id,
                from_date: from_date,
                to_date: to_date,
                well_id: well_id
            },
            success: function(res) {
                var response = JSON.parse(res);
                console.log(response);
                if (response.response_code == 200) {
                    $('#table_data').html("");
                    if (response.data.length > 0) {

                        $.each(response.data, function(i, v) {

                            var allot_prv_device_name = v.allot_prv_device_name != null ? v
                                .allot_prv_device_name : "NA";
                            var allot_prv_imei_no = v.allot_prv_imei_no != null ? v
                                .allot_prv_imei_no : "NA";

                            $("#table_data").append('<tr>' +
                                '<td>' + (i + 1) + '</td>' +
                                '<td>' + v.shifted_well_name + '</td>' +
                                '<td>' + v.shifted_device_name + '</td>' +
                                '<td>' +
                                '<button  class="btn btn-sm btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"> <span onclick="well_detils_through_imei_no(' +
                                v.shifted_imei_no + ')">' + v.shifted_imei_no +
                                '</span></button>' + '</td>' +

                                '<td><button class="btn btn-sm btn btn-success" type="button" data-bs-toggle="offcanvas" data-bs-target="#model2" aria-controls="offcanvasRight" onclick="get_well_data(\'' + v.allot_well_id + '\')">' + v.allotted_well_name +
                                '</button></td>' +
                                '<td>' + allot_prv_device_name + '</td>' +
                                '<td>' + allot_prv_imei_no + '</td>' +
                                '<td>' + v.allot_current_device_name + '</td>' +
                                '<td>' + v.allot_current_imei_no + '</td>' +
                                '<td>' + moment(v.shifted_datetime).format(
                                    'DD-MM-YYYY h:mm:ss a') + '</td>' +
                                '</tr>');
                        });
                    } else {
                        $('#table_data').html('<tr>' +
                            '<td class="text-danger" style="text-align:center;" colspan="14">No Record Found !!</td>' +
                            '</tr>');
                    }
                }

            }

        });
    }
function well_detils_through_imei_no(imei_no) {
    $.ajax({
        url: '<?php echo base_url(); ?>Well_replacement_report_c/well_shifted_details_through',
        method: 'POST',
        data: {
            imei_no: imei_no
        },
        success: function (res) {
            // Parsing the JSON response
            var response = JSON.parse(res);
            console.log('imei_no', response);

            if (response.status) {
                $('#well_details').html('');

                if (response.data.length > 0) {

                     response.data.sort(function(a, b) {
                        return new Date(b.date) - new Date(a.date);
                    });
                    var displayedWellNames = [];

                    $.each(response.data, function (i, v) {
                        var wellName = v.well_name;

                       
                            var imei_no = v.imei_no;
                            $('#imei_no').text(imei_no);

                            var eventColor = (v.status == 0) ? 'one' : 'two';
                            var textColor = (v.status == 0) ? 'green' : 'orange';
                            var wellNameText = (v.status == 0) ? 'Currently Well Name' : ' Well Name';

                            var shiftedDateText = (v.shifteddate) ? '<p><span style="color: ' + textColor + ';"> Shifted On :' + moment(v.shifteddate).format('DD-MM-YYYY h:mm:ss a') + '</span></p>' : '';

                            var htmlContent =
                                '<li class="event ' + eventColor + '" >' +
                                '<p><span style="color: ' + textColor + ';"> ' + wellNameText + ': ' + wellName + '</span></p>' +
                                '<p><span style="color: ' + textColor + ';">Installed Date :' + moment(v.date).format('DD-MM-YYYY h:mm:ss a') + '</span></p>' +
                                shiftedDateText +
                                '</li>';

                            $('#well_details').append(htmlContent);
                        
                    });
                } else {
                    $('#well_details').html('<p>No data available</p>');
                }
            }
        }
    });
}

function get_well_data(well_id) {
    console.log('well_id', well_id);

    $.ajax({
        url: '<?php echo base_url(); ?>Well_replacement_report_c/well_shifted_details_through_well_id',
        method: 'POST',
        data: {
            well_id,
            well_id
        },
        success: function (res) {
            var response = JSON.parse(res);
            console.log('well_data=', response);

            if (response.status) {

                $('#well_data_id').html('');

                if (response.data.length > 0) {

                    displayedWellNames = [];

                    response.data.sort(function(a, b) {
                        return new Date(b.date) - new Date(a.date);
                    });
                    $.each(response.data, function (i, v) {

                        var imei_no = v.imei_no;


                            var well_id = v.well_name;
                            $('#well_name').text(well_id);

                            // Check for null or empty values before calling trim()
                            if (v.device_name && v.imei_no) {
                                var eventColor = (v.status == 0) ? 'one' : 'two';
                                var textColor = (v.status == 0) ? 'green' : 'orange';
                                var shiftedDateText = (v.shifteddate) ? '<p> Shifted On :' + moment(v.shifteddate).format('DD-MM-YYYY h:mm:ss a') + '</p>' : '';

                                var htmlContent =
                                    '<li class="event ' + eventColor + '" style="color: ' + textColor + ';">' +
                                    '<p> Device Name: <span style="color: ' + textColor + ';">' + v.device_name + '</span></p>' +
                                    '<p> Imei No: <span style="color: ' + textColor + ';">' + imei_no + '</span></p>' +
                                    '<p>Installed Date :<span style="color: ' + textColor + ';">' + moment(v.date).format('DD-MM-YYYY h:mm:ss a') + '</span></p>' +
                                    shiftedDateText +
                                    '</li>';
                                $('#well_data_id').append(htmlContent);
                            
                        }
                    });
                }
            } else {
                $('#well_data_id').html('<p>No data available</p>');
            }
        }
    });
}

</script>