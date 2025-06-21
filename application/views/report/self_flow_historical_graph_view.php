<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
<script src="https://unpkg.com/chart.js@2.8.0/dist/Chart.bundle.js"></script>
<script src="https://unpkg.com/chartjs-gauge@0.3.0/dist/chartjs-gauge.js"></script>
<style type="text/css">
    table thead tr th{
        background: #daebf9 !important;
    }
    .form-label{
        font-size: 15px;
    }
    .card {
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    transition: box-shadow 0.3s ease;
}
.card:hover {
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
}
</style>
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header mb-3">
            <div class="content-page-header">
                <h5 class="mb-0">Historical Graph</h5>
            </div>
        </div>
        <!-- Filter Card -->
        <div class="card" style="background: linear-gradient(to left, #5D6D7E,  #F1948A );">
                <div class="card-body">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label for="well_id" class="form-label" style="color:white;">Well Name</label>
                        <select onchange="GetGraph(); handleSelection();" class="form-select select2" id="well_id" name="well_id[]" multiple></select>
                    </div>
                    <div class="col-md-3">
                        <label for="alert_type" class="form-label" style="color:white;">Report Type</label>
                        <select onchange="GetGraph();" class="form-select select2" id="alert_type" name="alert_type">
                            <option value="1">CHP</option>
                            <option value="2">THP</option>
                            <option value="3">ABP</option>
                            <option value="4">GIP</option>
                            <option value="5">THT</option>
                            <option value="6">Battery</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="from_date" class="form-label" style="color:white;">From Date</label>
                        <input type="date" name="from_date" id="from_date" class="form-control"
                            value="<?php echo date('Y-m-d'); ?>" onchange="GetGraph(); get_installation_date();">
                    </div>
                    <div class="col-md-3">
                        <label for="to_date" class="form-label" style="color:white;">To Date</label>
                        <input type="date" name="to_date" id="to_date" class="form-control"
                            value="<?php echo date('Y-m-d'); ?>" onchange="GetGraph(); get_installation_date();">
                    </div>
                </div>
           </div>
        </div>
        <!-- Chart Card -->
        <div class="row">
            <div class="col-md-12">
                <div class="card" style="border-top:5px #5D6D7E solid;">
                    <div class="card-header py-4">
                        <div id="processing_message" style="display: none; text-align: center;">
                            <img src="<?php echo base_url(); ?>assets/loader_img.svg" class="loader-img" alt="Loader"
                                style="height: 200px; width: 100px;">
                        </div>
                        <span id="selected_field" style="color: black; font-weight: 500;"></span>
                        <canvas id="speedChart" width="600" height="400"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
function handleSelection() {
    var wellSelect = document.getElementById("well_id");
    if (!wellSelect) {
        console.error("Well select element not found.");
        return;
    }

    var selectedOptions = Array.from(wellSelect.selectedOptions);
    if (selectedOptions.length > 10) {
        Swal.fire({
            title: 'Well Selection Limit Exceeded',
            text: 'You can only select up to 10 wells.',
            icon: "warning",
            buttons: true,
            dangerMode: true,
        });
    }
}
</script>

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
    get_well_list();
    function get_well_list(){

        
        $.ajax({
            url : '<?php echo base_url() ?>Selfflow_historical_report_c/get_well_list',
            type: 'POST',
            data: {},
            success:(res)=>{
                let resp = JSON.parse(res);

                if(resp.response_code == 200){
                     console.log(resp,'well_id');
                    if(resp.data.length > 0){

                        $('#well_id').html(`<option value="">select</option>`);
                        $.each(resp.data, (i,v)=>{
                            $('#well_id').append(`<option value="${v.well_id}">${v.well_name}</option>`);
                        });
                    }else{
                        $('#well_id').html(`<option value="">select</option>`);
                    }
                }
            }
        });
    }
</script>

<script type="text/javascript">

function GetGraph() {
    var selectedOption = document.getElementById("alert_type").value;
    var processingMessage = document.getElementById("processing_message");

    if (!processingMessage) {
        console.error("Processing message element was not found.");
        return;
    }

    processingMessage.style.display = "block";

    var well_ids = $('#well_id').val();
    var well_type = $('#well_type').val();
    var from_date = $('#from_date').val();
    var to_date = $('#to_date').val();
    // alert(well_id);

    var url = '';
    var selcetedtext = '';
    switch (selectedOption) 
    {
        case "1":
            selcetedtext = 'CHP';
            url = '<?php echo base_url(); ?>Self_flow_well_historical_log_c/get_graph_histrorical';
            break;
        case "2":
            selcetedtext = 'THP';
            url = '<?php echo base_url(); ?>Self_flow_well_historical_log_c/get_graph_histrorical';
            break;
        case "3":
             selcetedtext = 'ABP';
            url = '<?php echo base_url(); ?>Self_flow_well_historical_log_c/get_graph_histrorical';
            break;
        case "4":
            selcetedtext = 'GIP';
            url = '<?php echo base_url(); ?>Self_flow_well_historical_log_c/get_graph_histrorical';
            break;
        case "5":
            selcetedtext = 'THT';
            url = '<?php echo base_url(); ?>Self_flow_well_historical_log_c/get_graph_histrorical';
            break;
        case "6":
            selcetedtext = 'Battery';
            url = '<?php echo base_url(); ?>Self_flow_well_historical_log_c/get_graph_histrorical';
            break;
        default:
            console.error("Invalid selection option");
            processingMessage.style.display = "none";
            return;
    }

    $.ajax({
        url: url,
        type: 'POST',
        data: {
            well_id: well_ids,
            well_type: well_type,
            from_date: from_date,
            to_date: to_date,
            graph_type: selectedOption
        },
        success: function(res) {
            processingMessage.style.display = "none";
            // console.log("API Response:", res);
            if (typeof res === 'string') {
                try {
                    res = JSON.parse(res);
                } catch (e) {
                    console.error("Error parsing JSON response:", e);
                    return;
                }
            }

            if (!res || !res.data) {
                console.error('API response is missing "data" property:', res);
                return;
            }
            var datasets = [];
            var labels = [];
            var colors = ["#FF5733", "#33FF57", "#3357FF", "#FF33A1", "#FF8C33"];
            Object.keys(res.data).forEach(function(wellId, index) {
        var wellData;
        switch (selectedOption) {
            case "1":
                wellData = res.data[wellId].output_chp.output_chp;
                break;
            case "2":
                wellData = res.data[wellId].output_thp.output_thp;
                break;
            case "3":
                wellData = res.data[wellId].output_abp.output_abp;
                break;
            case "4":
                wellData = res.data[wellId].output_gip.output_gip;
                break;
            case "5":
                wellData = res.data[wellId].output_tht.output_tht;
                break;
            case "6":
                wellData = res.data[wellId].output_battery.output_battery;
                break;
        }

        if (!wellData || wellData.length === 0 || !wellData[0].well_name) {
            console.warn(`No data found for well ID: ${wellId}`);
            return;
        }

        var dataPoints = wellData.map(function(point) {
            return {
                x: new Date(point.x).getTime(),
                y: parseFloat(point.y)
            };
        });

        labels = wellData.map(function(point) {
            return point.x;
        });

        var color = colors[index] || getRandomColor();

        datasets.push({
            label: wellData[0].well_name + " - " + selcetedtext,
            data: dataPoints,
            lineTension: 0,
            fill: false,
            borderColor: color
        });
    });
            updateLineChart(datasets, labels);
        },
        error: function(xhr, status, error) {
            processingMessage.style.display = "none";
            console.error('AJAX Error: ', error);
        }
    });
}

function updateLineChart(datasets, labels) {
    var speedCanvas = document.getElementById("speedChart");

    if (window.lineChart) {
        window.lineChart.destroy();
    }

    window.lineChart = new Chart(speedCanvas, {
        type: 'line',
        data: {
            labels: labels, 
            datasets: datasets 
        },
        options: {
            legend: {
                display: true,
                position: 'top',
                labels: {
                    boxWidth: 80,
                    fontColor: 'black'
                }
            },
            scales: {
                xAxes: [{
                    type: 'time',
                    time: {
                        displayFormats: {
                            second: 'DD-MM-YYYY HH:mm:ss',
                            minute: 'DD-MM-YYYY HH:mm:ss',
                            hour: 'DD-MM-YYYY HH:mm:ss'
                        }
                    }
                }]
            }
        }
    });
}

function getRandomColor() {
    var letters = '0123456789ABCDEF';
    var color = '#';
    for (var i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}


</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/canvasjs/1.7.0/canvasjs.min.js"></script>
                

