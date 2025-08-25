<script src="https://code.highcharts.com/stock/highstock.js"></script>
<script src="https://code.highcharts.com/stock/modules/exporting.js"></script>
<script src="https://code.highcharts.com/stock/modules/export-data.js"></script>
<script src="https://code.highcharts.com/stock/modules/accessibility.js"></script>
<script src="https://code.highcharts.com/themes/adaptive.js"></script>
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
 #back_btns{
        font-size: 16px;
        padding: 3px 13px;
    }
    #back_btns i{
        margin-right: -20px;
        position: relative;
        opacity: 0; 
        transition: all 0.5s ease-out;
    }
    #back_btns:hover i{
        opacity: 1; 
        margin-right: 2px;
    }
</style>
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header" style="margin-top:-39px;">
            <div class="content-page-header">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <!-- Left side -->
                    <h5 class="mb-0">Historical Graph</h5>

                    <!-- Right side -->
                    <a href="<?php echo base_url('')?>Selfflow_c">
                        <button type="button" id="back_btns" class="btn btn-outline-warning">
                            <i class="fa-solid fa-left-long"></i> Back
                        </button>
                    </a>
                </div>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="card" style="background: linear-gradient(to left, #5D6D7E,  #F1948A ); margin-top:-20px;">
                <div class="card-body">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label for="well_id" class="form-label" style="color:white;">Well Name</label>
                        <select onchange="GetGraph(); handleSelection();" class="form-select select2" id="well_id" name="well_id[]" multiple></select>
                    </div>
                     <div class="col-md-3">
                      <label class="form-label text-white">Component</label>
                      <select class="form-control select2" id="alert_type" name="alert_type[]" multiple style="width: 100%;" onchange="GetGraph();">
                        <option value="">Select Component</option>
                        <option value="chp">CHP</option>
                        <option value="abp">ABP</option>
                        <option value="thp">THP</option>
                        <option value="flt">FLT</option>
                        <option value="battery">Battery</option>
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
                    <div class="card-body">
                         <div id="processing_message" style="display: none;">
                           <img src="<?php echo base_url(); ?>assets/loader_img.svg" class="loader-img" alt="Loader" style="height: 200px; width: 100px;">
                    </div>
                    <div id="speedChart" style="width: 100%; height: 500px;"> </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
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
const unitsMap = {
  'CHP': 'kg/cm²',
  'ABP': 'kg/cm²',
  'THP': 'kg/cm²',
  'FLT': '°C',
  'BATTERY': 'V'
};

let chartInstance = null;
GetGraph();
function GetGraph() {
    const selectedComponents = $('#alert_type').val();
    const well_ids = $('#well_id').val();
    const from_date = $('#from_date').val();
    const to_date = $('#to_date').val();
    const processingMessage = document.getElementById("processing_message");

    if (!well_ids || !from_date || !to_date || !selectedComponents || selectedComponents.length === 0) {
        document.getElementById('speedChart').innerHTML = `
            <div class="text-center">
                <div class="text-danger mt-2">No records found. Please select well and date range.</div>
            </div>`;
        return;
    }

    processingMessage.style.display = "block";

    $.ajax({
        url: "<?= base_url(); ?>Selfflow_historical_report_c/get_graph_histrorical",
        type: 'POST',
        data: {
            well_id: well_ids,
            from_date: from_date,
            to_date: to_date,
            components: selectedComponents
        },
        success: function (res) {
            console.log('graph_data===', res);

            processingMessage.style.display = "none";

            if (typeof res === 'string') {
                try {
                    res = JSON.parse(res);
                } catch (e) {
                    console.error("Failed to parse response JSON", e);
                    return;
                }
            }

            if (!res || !res.status || res.status === "false" || res.status === 0) {
                document.getElementById('speedChart').innerHTML = `
                  <div class="text-center text-danger">
                    Error loading data.
                  </div>`;
                return;
            }

            processGraphData(res);
        },
        error: function (err) {
            processingMessage.style.display = "none";
            console.error("AJAX error", err);
        }
    });
}

function processGraphData(res) {
    const data = res.data || {};
    const selectedComponents = $('#alert_type').val() || [];
    const series = [];

    const wellIdNameMap = {};
    $('#well_id option:selected').each(function () {
        const wellId = $(this).val();
        const wellName = $(this).text();
        wellIdNameMap[wellId] = wellName;
    });

    Object.keys(data).forEach(wellId => {
        const wellData = data[wellId];
        const wellName = wellIdNameMap[wellId] || wellId;

        selectedComponents.forEach(component => {
            const key = `output_${component}`;
            const timeSeries = wellData[key];

            if (Array.isArray(timeSeries) && timeSeries.length > 0) {
                const formattedSeries = timeSeries.map(pt => [
                    new Date(pt.x.replace(' ', 'T')).getTime(),  // fix date parsing
                    parseFloat(pt.y)
                ]);

                series.push({
                    name: `${wellName} - ${component.toUpperCase()}`,
                    data: formattedSeries,
                    custom: {
                        unit: unitsMap[component.toUpperCase()] || ''
                    }
                });
                console.log('Component key:', component.toUpperCase());
            }
        });
    });

    if (series.length === 0) {
        document.getElementById('speedChart').innerHTML = `
          <div class="text-center">
            <div class="text-danger mt-2">No data found for selected parameters.</div>
          </div>`;
        return;
    }

    updateMultiLineChart(series);
}

function updateMultiLineChart(series) {
    if (chartInstance && chartInstance.destroy) {
        chartInstance.destroy();
    }
    Highcharts.setOptions({
        time: {
            useUTC: false,
            getTimezoneOffset: () => -330
        }
    });

    chartInstance = Highcharts.stockChart('speedChart', {
        chart: {
            height: 500
        },
        rangeSelector: {
            enabled: true
        },
        navigator: {
            enabled: true
        },
        scrollbar: {
            enabled: true
        },
        legend: {
            enabled: true,
            align: 'center',
            verticalAlign: 'top',
            layout: 'horizontal',
            labelFormatter: function () {
                const unit = this.userOptions.custom?.unit || '';
                const lastPoint = this.yData?.[this.yData.length - 1];
                if (typeof lastPoint === 'number') {
                    return `${this.name}: ${lastPoint.toFixed(2)} ${unit}`;
                } else {
                    return `${this.name} (${unit})`;
                }
            }
        },
        xAxis: {
            type: 'datetime',
            labels: {
                formatter: function () {
                    return Highcharts.dateFormat('%d-%m-%Y %I:%M %p', this.value);
                },
                align: 'center',
                style: {
                    fontSize: '10px'
                }
            },
            tickPixelInterval: 150
        },
        yAxis: [{
            title: {
                text: 'Component Value',
                style: {
                    fontSize: '12px',
                    color: '#333'
                }
            },
            labels: {
                align: 'right',
                x: -5,
                formatter: function () {
                    return this.value.toFixed(2);
                }
            },
            opposite: false,
            plotLines: [{
                value: 0,
                width: 1,
                color: 'silver'
            }]
        }],
        tooltip: {
            shared: true,
            formatter: function () {
                let formattedTime = Highcharts.dateFormat('%d-%m-%Y %I:%M %p', this.x);
                let s = `<b>${formattedTime}</b>`;
                this.points.forEach(function (point) {
                    const unit = point.series.userOptions.custom?.unit || '';
                    s += `<br/><span style="color:${point.color}">\u25CF</span> ${point.series.name}: <b>${point.y.toFixed(2)} ${unit}</b>`;
                });
                return s;
            }
        },
        plotOptions: {
            series: {
                showInNavigator: false,
                marker: { enabled: false }
            }
        },
        series: series
    });
}
</script>
