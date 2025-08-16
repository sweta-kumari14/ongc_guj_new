
<style type="text/css">
    .select2-container--default .select2-selection--single{
        border: 1px solid #8299b557;
    }
    .select2-container .select2-selection--single{
        height: 38px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered{
        line-height: 35px;
    }
    table thead tr th{
        background: #daebf9 !important;
    }
    .table-bordered th {
       border: 1px solid var(--bs-tertiary-color);

    }
    #data-table th[data-sort]::after {
      content: "";
      position: absolute;
      right: 6px;
      top: 50%;
      transform: translateY(-50%);
      border-left: 5px solid transparent;
      border-right: 5px solid transparent;
      border-bottom: 6px solid #ccc; /* light gray arrow initially */
    }

    #data-table th.sort-asc::after {
        border-bottom: 6px solid #000;
        border-top: none;
    }

    #data-table th.sort-desc::after {
        border-top: 6px solid #000;
        border-bottom: none;
    }

    .table-bordered td {
       border: 1px solid var(--bs-tertiary-color);

    }
    .form-label{
        font-size: 15px;
    }
     #export_btns{
        font-size: 16px;
        padding: 3px 13px;
    }
    #export_btns i{
        margin-right: -20px;
        position: relative;
        opacity: 0; 
        transition: all 0.5s ease-out;
    }
    #export_btns:hover i{
        opacity: 1; 
        margin-right: 2px;
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
    
    .card-header {
    
     background-color: var(--bs-white) !important;
   
    }
</style>
<div class="page-wrapper">
    <div class="content container-fluid pb-0">
        <div class="page-header">
            <div class="content-page-header" style="margin-top: -28px;">
                <h5>Historical Report Self Flow</h5>
            </div>  
        </div>
        <div class="row">                    
            <div class="col-lg-12" style="margin-top: -16px;">
                <div class="card">
                    <div class="card-header">
                       <div class="row">
                           <div class="col-12 d-flex justify-content-between align-items-center">
                              <h4 class="header-title m-0"><b>Historical Report</b></h4>
                           <div>
                            <button type="button" id="export_btns" onclick="export_report();" class="btn btn-outline-success me-2">
                                <i class="fa-solid fa-file-excel"></i> Export
                            </button>

                            <a href="<?php echo base_url('')?>Selfflow_c">
                                <button type="button" id="back_btns" class="btn btn-outline-warning">
                                    <i class="fa-solid fa-left-long"></i> Back
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="filter-section" style="padding: 0px 20px;">
                <div class="col-xl-12">
                    <div class="row mt-4">
                        <div class="form-labele col-md-4">
                                <h5><b>Well  Name</b></h5>
                                <select name="well_id" id="well_id" class="form-control select2" onchange="get_mis_report();">
                                 
                                    <?php 
                                    if (!empty($well_list))
                                    {
                                        foreach ($well_list as $key => $value)
                                        {
                                            ?>
                                                <option <?php if ($this->uri->segment(3) == $value['well_id']) {echo 'selected="selected"';} ?> value="<?php echo $value['well_id']; ?>">
                                                  <?php echo $value['well_name']; ?>
                                             </option>

                                            <?php
                                        }
                                    }

                                    ?>
                                </select>
                            </div>

                                <div class="form-group col-md-4">
                                    <h5><b>From Date</b></h5>
                                    <input type="date" name="from_date" id="from_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" onchange="get_mis_report();get_installation_date();">
                                </div>

                                <div class="form-group col-md-4">
                                    <h5><b>To Date</b></h5>
                                    <input type="date" name="to_date" id="to_date" class="form-control" value="<?php echo date('Y-m-d'); ?>"  onchange="get_mis_report();get_installation_date();">
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-4">
                                 <div>
                                    <label>per page</label>
                                    <select id="page-size" class="form-select form-select-sm w-auto d-inline-block">
                                        <option value="5">5</option>
                                        <option value="10" selected="">10</option>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                    </select>
                                       
                                </div>
                                <input type="text" id="searchBox" placeholder="Search..." class="form-control w-25" />

                            </div>
           
                             <div class="table-responsive mt-4">

                                <table class="table table-bordered border-bottom table-striped" id="data-table">
                                      <thead style="background-color:blue; color: white; text-align: center;">
                                        <tr>
                                          <th colspan="25" class="text-uppercase" style="font-size: 20px;font-weight: bolder;">IOT BASED REAL TIME WELL MONITORING SYSTEM ONGC,CAMBAY ASSET</th>
                                        </tr>
                                        <tr>
                                            <th colspan="25" class="text-uppercase" style="font-size: 15px;font-weight: bolder;" id="report-heading"> Historical Report as on </th>
                                        </tr>
                                        <tr>
                                            <th rowspan="2" style="vertical-align: middle; text-align: center; position: relative; padding-right: 20px;" data-sort="number" data-key="sl_no">Sl No.</th>
                                            <th rowspan="2" style="vertical-align: middle; text-align: center; position: relative; padding-right: 20px;" data-sort="string" data-key="well_name">Well</th>
                                            <th rowspan="2" style="vertical-align: middle; text-align: center; position: relative; padding-right: 20px;" data-sort="date" data-key="Log_Date_Time">Last Log Date Time</th>
                                            <th colspan="2">CHP (kg/cm²)</th>
                                            <th colspan="2">THP (kg/cm²)</th>
                                            <th colspan="2">ABP (kg/cm²)</th>
                                            <th colspan="2">FLT (°C)</th>
                                            <th rowspan="2" style="vertical-align: middle; text-align: center; position: relative; padding-right: 20px;" data-sort="number" data-key="Battery_Voltage">Battery (v)</th>
                                            
                                        </tr>
                                       <tr>
                                            <th data-sort="number" data-key="CHP" style="position: relative; padding-right: 20px;">Sensor</th>
                                            <th data-sort="number" data-key="CHP_battery_volt" style="position: relative; padding-right: 20px;">Battery (v)</th>
                                            <th data-sort="number" data-key="THP" style="position: relative; padding-right: 20px;">Sensor</th>
                                            <th data-sort="number" data-key="THP_battery_volt" style="position: relative; padding-right: 20px;">Battery (v)</th>
                                            <th data-sort="number" data-key="ABP" style="position: relative; padding-right: 20px;">Sensor</th>
                                            <th data-sort="number" data-key="ABP_battery_volt" style="position: relative; padding-right: 20px;">Battery (v)</th>
                                            <th data-sort="number" data-key="FLT" style="position: relative; padding-right: 20px;">Sensor</th>
                                            <th data-sort="number" data-key="FLT_battery_volt" style="position: relative; padding-right: 20px;">Battery (v)</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center" id="table_data"> 
                                    </tbody>
                                </table>
                                <div id="pagination" class="mt-3 text-end"></div>
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
          if (f_from_date.isValid() && t_to_date.isValid() && f_from_date.isSame(t_to_date, 'day')) {
            $('#show_to_date').text('');
            $('#to').hide();

          }

    }
</script>
<script type="text/javascript">
let tableDataArray = [];
let currentPage = 1;
let rowsPerPage = 10;
let sortDirection = 1;
let sortColumnIndex = null;

// Fetch data
function get_mis_report() {
    $('#table_data').html('<tr><td colspan="25">Processing please wait....</td></tr>');

    let from_date = $('#from_date').val();
    let to_date = $('#to_date').val();
    let well_id = $('#well_id').val();

    $.ajax({
        url: '<?= base_url("Self_flow_well_historical_log_c/get_mis_report_histrorical") ?>',
        method: 'POST',
        data: {from_date, to_date, well_id},
        success: function(res) {
            let response = JSON.parse(res);
            if(response.response_code == 200) {
                tableDataArray = response.data || [];
                currentPage = 1;
                renderTable();
                renderPagination();
            } else {
                $('#table_data').html('<tr><td colspan="25" class="text-danger">No records found</td></tr>');
            }
        }
    });
}

// Render Table
function renderTable(filteredData) {
    let data = filteredData || tableDataArray;
    data.sort((a,b) => (a.well_name||'').localeCompare(b.well_name||''));

    let start = (currentPage-1)*rowsPerPage;
    let end = start+rowsPerPage;
    let paginatedData = data.slice(start, end);

    $('#table_data').empty();
    if(paginatedData.length > 0) {
        $.each(paginatedData, function(i,v){
            $('#table_data').append(`
                <tr>
                    <td>${start+i+1}</td>
                    <td class="well_name_cell">${v.well_name || ''}</td>
                    <td>${v.Log_Date_Time ? moment(v.Log_Date_Time).format('DD-MM-YYYY h:mm:ss a') : 'NA'}</td>
                    <td>${v.CHP||''}</td>
                    <td>${v.CHP_battery_volt||''}</td>
                    <td>${v.THP||''}</td>
                    <td>${v.THP_battery_volt||''}</td>
                    <td>${v.ABP||''}</td>
                    <td>${v.ABP_battery_volt||''}</td>
                    <td>${v.FLT||''}</td>
                    <td>${v.FLT_battery_volt||''}</td>
                    <td>${v.Battery_Voltage||''}</td>
                </tr>
            `);
        });
        mergeWellNameCells();
    } else {
        $('#table_data').html('<tr><td colspan="25" class="text-danger">No Record Found !!</td></tr>');
    }
}

// Merge well_name cells
function mergeWellNameCells() {
    let prevText = null, rowspan = 1, prevCell = null;
    $('#table_data .well_name_cell').each(function() {
        let currentText = $(this).text();
        if(currentText === prevText) {
            rowspan++;
            $(this).remove();
            prevCell.attr('rowspan', rowspan);
        } else {
            prevText = currentText;
            rowspan = 1;
            prevCell = $(this);
        }
    });
}

// Pagination
function renderPagination(filteredData) {
    let data = filteredData || tableDataArray;
    let totalPages = Math.ceil(data.length / rowsPerPage);
    let pagHTML = '';
    for(let i=1; i<=totalPages; i++){
        pagHTML += `<button class="btn btn-sm ${i===currentPage?'btn-primary':'btn-outline-primary'} me-1" onclick="goToPage(${i})">${i}</button>`;
    }
    $('#pagination').html(pagHTML);
}

function goToPage(page){
    currentPage = page;
    renderTable();
    renderPagination();
}

// Sorting
$('#data-table thead th[data-key]').on('click', function() {
    let key = $(this).data('key');
    let sortType = $(this).data('sort') || 'string';

    if(sortColumnIndex===key) sortDirection=-sortDirection;
    else { sortDirection=1; sortColumnIndex=key; }

    $('#data-table thead th').removeClass('sort-asc sort-desc');
    $(this).addClass(sortDirection===1?'sort-asc':'sort-desc');

    tableDataArray.sort((a,b)=>{
        let valA = a[key]||'', valB = b[key]||'';
        if(sortType==='number') return ((parseFloat(valA)||0)-(parseFloat(valB)||0))*sortDirection;
        if(sortType==='date') return (new Date(valA)-new Date(valB))*sortDirection;
        return valA.toString().localeCompare(valB.toString())*sortDirection;
    });
    currentPage=1;
    renderTable();
    renderPagination();
});

// Event listeners
$(document).ready(function(){
    get_mis_report();
    $('#from_date,#to_date,#well_id').on('change', get_mis_report);
    $('#page-size').on('change', function(){
        rowsPerPage = parseInt($(this).val());
        currentPage = 1;
        renderTable();
        renderPagination();
    });
    $('#searchBox').on('input', function(){
        let term = $(this).val().toLowerCase();
        let filtered = tableDataArray.filter(row=>Object.values(row).some(v=>v&&v.toString().toLowerCase().includes(term)));
        currentPage=1;
        renderTable(filtered);
        renderPagination(filtered);
    });
});
</script>

<script src="<?php echo base_url(); ?>assets/local/excel/xlsx.full.min.js"></script>
<script type="text/javascript">
    
    function export_report() {
      var sheetName = "Sheet1";
      var fileName = "Historical report.xlsx";
      var table = $("#data-table")[0];
      var ws = XLSX.utils.table_to_sheet(table);
      var wb = XLSX.utils.book_new();
      XLSX.utils.book_append_sheet(wb, ws, sheetName);
      XLSX.writeFile(wb, fileName);
    }

</script>
         

