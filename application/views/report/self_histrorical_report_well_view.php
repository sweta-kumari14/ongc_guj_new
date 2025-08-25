<style>
    .thead-dark th {
        color: black !important;
        text-align: center;
        white-space: nowrap;
        padding-right: 16px;
        position: relative;
    }

    #data-table thead {
        position: sticky;
        top: 0;
        z-index: 5;
    }

    .table-responsive thead th {
        color: white;
        position: sticky;
        top: 0;
        z-index: 2;
        border: 1px solid black;
    }

    #data-table {
        border-collapse: collapse;
        width: 100%;
    }

    #data-table th,
    #data-table td {
        border: 1px solid #dee2e6 !important;
        vertical-align: middle;
        text-align: center;
        white-space: nowrap;
    }

    .pagination {
        text-align: center;
        margin-top: 20px;
    }

    .pagination button {
        margin: 0 3px;
        padding: 6px 12px;
        border: 1px solid #888;
        background-color: #fff;
        color: #ffbc34;
        cursor: pointer;
        transition: all 0.2s ease-in-out;
        border-radius: 4px;
    }

    .pagination button:hover:not(.active) {
        background-color: #ffbc34;
        color: #fff;
        border-color: #ffbc34;
    }

    .pagination button.active {
        background-color: #ffbc34;
        color: white;
        border-color: #ffbc34;
    }

    th.sortable {
        cursor: pointer;
        user-select: none;
        position: relative;
        text-align: center;
        vertical-align: middle;
        white-space: nowrap;
        padding-right: 20px; /* space for arrows */
    }

    th.sortable .arrow {
        position: absolute;
        top: 50%;
        right:11px;
        transform: translateY(-50%);
        display: flex;
        flex-direction: column;
        font-size: 0.5em;
        color: black;
        line-height: 1;
    }

    th.sortable .arrow span {
        display: block;
        text-align: center;
    }

    th.sortable.active.asc .arrow .up {
        color: #fff;
        font-weight: bold;
    }

    th.sortable.active.desc .arrow .down {
        color: #fff;
        font-weight: bold;
    }

    .table thead th:first-child {
        border-radius: 0 !important;
    }

    .table thead th:last-child {
        border-radius: 0 !important;
      border-radius: 0 !important;
    }
    .table thead th:last-child{
     border-radius: 0 !important;
    }

    .tooltip-inner {
        background-color: #1e88e5 !important;
        color: #fff !important;            
        font-weight: 500;
        font-size: 13px;
        padding: 6px 10px;
        border-radius: 6px;
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
    .card-header{
        background-color: white !important;
    }
    .table-hover > tbody > tr:hover > * {
    --bs-table-color-state: inherit !important;
    --bs-table-bg-state: #fff !important;
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
                                <input type="text" id="mis_search" placeholder="Search..." class="form-control w-25" />

                            </div>
                            <div class="table-responsive mt-2" style="max-height: 1000px; overflow-y: auto;">
                                <table class="table table-bordered table-hover m-0" id="data-table">
                                   <thead class="thead-dark">
                                      <tr>
                                       <th class="sortable" data-index="0" onclick="sortMIS(0)" rowspan="2">
                                          Sl No.
                                          <span class="arrow">
                                            <span class="up">▲</span>
                                            <span class="down">▼</span>
                                          </span>
                                        </th>
                                        
                                        <th style="border:1px solid #fff;" rowspan="2" class="sortable" data-index="1" onclick="sortMIS(1)">
                                          Well
                                          <span class="arrow">
                                            <span class="up">▲</span>
                                            <span class="down">▼</span>
                                          </span>
                                        </th>
                                        
                                        <th style="border:1px solid #fff;" rowspan="2" class="sortable" data-index="3" onclick="sortMIS(2)">
                                          Log Date Time
                                          <span class="arrow">
                                            <span class="up">▲</span>
                                            <span class="down">▼</span>
                                          </span>
                                        </th>
                                        <th style="border:1px solid #fff;" colspan="2">CHP (kg/cm²)</th>
                                        <th style="border:1px solid #fff;" colspan="2">THP (kg/cm²)</th>
                                        <th style="border:1px solid #fff;" colspan="2">ABP (kg/cm²)</th>
                                        <th style="border:1px solid #fff;" colspan="2">FLT (°C)</th>
                                        <th style="border:1px solid #fff;" rowspan="2" class="sortable" data-index="11" onclick="sortMIS(11)">
                                          Battery(v)
                                          <span class="arrow">
                                            <span class="up">▲</span>
                                            <span class="down">▼</span>
                                          </span>
                                        </th>
                                      </tr>
                                      <tr>
                                        <th style="border:1px solid #fff;" class="sortable" data-index="3" onclick="sortMIS(3)">
                                          Sensor
                                          <span class="arrow">
                                            <span class="up">▲</span>
                                            <span class="down">▼</span>
                                          </span>
                                        </th>
                                        <th style="border:1px solid #fff;" class="sortable" data-index="4" onclick="sortMIS(4)">
                                          Battery(v)
                                          <span class="arrow">
                                            <span class="up">▲</span>
                                            <span class="down">▼</span>
                                          </span>
                                        </th>
                                        <th style="border:1px solid #fff;" class="sortable" data-index="5" onclick="sortMIS(5)">
                                          Sensor
                                          <span class="arrow">
                                            <span class="up">▲</span>
                                            <span class="down">▼</span>
                                          </span>
                                        </th>
                                        <th style="border:1px solid #fff;" class="sortable" data-index="6" onclick="sortMIS(6)">
                                          Battery(v)
                                          <span class="arrow">
                                            <span class="up">▲</span>
                                            <span class="down">▼</span>
                                          </span>
                                        </th>
                                        <th style="border:1px solid #fff;" class="sortable" data-index="7" onclick="sortMIS(7)">
                                          Sensor
                                          <span class="arrow">
                                            <span class="up">▲</span>
                                            <span class="down">▼</span>
                                          </span>
                                        </th>
                                        <th style="border:1px solid #fff;" class="sortable" data-index="8" onclick="sortMIS(8)">
                                          Battery(v)
                                          <span class="arrow">
                                            <span class="up">▲</span>
                                            <span class="down">▼</span>
                                          </span>
                                        </th>
                                        <th style="border:1px solid #fff;" class="sortable" data-index="9" onclick="sortMIS(9)">
                                          Sensor
                                          <span class="arrow">
                                            <span class="up">▲</span>
                                            <span class="down">▼</span>
                                          </span>
                                        </th>
                                        <th style="border:1px solid #fff;" class="sortable" data-index="10" onclick="sortMIS(10)">
                                          Battery(v)
                                          <span class="arrow">
                                            <span class="up">▲</span>
                                            <span class="down">▼</span>
                                          </span>
                                        </th>
                                        
                                        
                                      </tr>
                                    </thead>

                                    <tbody id="table_data">
                                        <!-- Injected via JS -->
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                  <div class="pagination" style="float:right;" id="pagination"></div>
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
// JS
let groupMap = {};
let misDataGroups = [];
let filteredMisGroups = [];
let currentPage = 1;
let pageSize = 10;
let currentSortIndex = 1;
let sortDirection = 1;
let isSearching = false;

$(document).ready(function () {
    $('#page-size').on('change', function () {
        pageSize = parseInt($(this).val()) || 10;
        currentPage = 1;
        renderMisTable();
    });

    $('#mis_search').on('keyup', function () {
        const keyword = $(this).val().toLowerCase().trim();
        isSearching = keyword.length > 0;

        if (!keyword) {
            filteredMisGroups = [];
            currentPage = 1;
            renderMisTable();
            return;
        }

        filteredMisGroups = misDataGroups.map(group => {
            const filteredRecords = group.records.filter(row =>
                Object.values(row).some(val =>
                    val?.toString().toLowerCase().includes(keyword)
                )
            );

            // Search across well_name and cluster_name
            const groupMatch = [group.well_name, group.cluster_name]
                .some(val => val?.toLowerCase().includes(keyword));

            if (groupMatch || filteredRecords.length > 0) {
                return {
                    ...group,
                    records: groupMatch ? group.records : filteredRecords
                };
            }
            return null;
        }).filter(g => g !== null);

        currentPage = 1;
        renderMisTable();
    });

    get_mis_report();
});

function get_mis_report() {
    $('#table_data').html('<tr><td colspan="10">Loading...</td></tr>');

    const base_url = "<?= base_url(); ?>";
    const from_date = $('#from_date').val();
    const to_date = $('#to_date').val();
    const well_id = $('#well_id').val();

    if (!from_date || !to_date) {
        $('#table_data').html('<tr><td colspan="10">Please select well and date range.</td></tr>');
        return;
    }

    $.ajax({
        url: base_url + 'Self_flow_well_historical_log_c/get_mis_report_histrorical',
        method: 'POST',
        data: { from_date, to_date, well_id },
        success: function (res) {
            const response = JSON.parse(res);
            console.log(response,'sahdhsgf');
            if (response.response_code === 200 && response.data?.length > 0) {
                groupMap = {};
                response.data.forEach(row => {
                    const key = row.well_name;
                    if (!groupMap[key]) {
                        groupMap[key] = { groupKey: key, well_name: row.well_name, records: [] };
                    }
                    groupMap[key].records.push(row);
                });
                misDataGroups = Object.values(groupMap);
                filteredMisGroups = [];
                currentPage = 1;
                renderMisTable();
            } else {
                $('#table_data').html('<tr><td colspan="12">No records found.</td></tr>');
            }
        },
        error: function () {
            $('#table_data').html('<tr><td colspan="12">Error fetching data</td></tr>');
        }
    });
}

function renderMisTable() {
    const groups = isSearching ? filteredMisGroups : misDataGroups;
    if (!groups || groups.length === 0) {
        $('#table_data').html('<tr><td colspan="12">No matching records.</td></tr>');
        $('#pagination').html('');
        return;
    }

    // Flatten all rows with reference to their group
    let allRows = [];
    groups.forEach(group => {
        group.records.forEach(record => {
            allRows.push({
                well_name: group.well_name,
                record
            });
        });
    });

    const totalRows = allRows.length;
    const totalPages = Math.ceil(totalRows / pageSize);

    const start = (currentPage - 1) * pageSize;
    const end = start + pageSize;
    const pageRows = allRows.slice(start, end);

    let html = '';
    let serial = start + 1;

    // Track rowspan for well_name in current page
    let wellRowMap = {};
    pageRows.forEach((row, index) => {
        const well = row.well_name;
        if (!wellRowMap[well]) wellRowMap[well] = [];
        wellRowMap[well].push(index);
    });

    pageRows.forEach((row, index) => {
        html += `<tr>`;

        // Serial number
        html += `<td>${serial}</td>`;

        // Merge well_name if first occurrence on this page
        const well = row.well_name;
        const wellIndexes = wellRowMap[well];
        if (wellIndexes[0] === index) {
            html += `<td rowspan="${wellIndexes.length}" style="vertical-align: middle; text-align: center;">${well}</td>`;
        }

        html += `
            <td>${row.record.Log_Date_Time ?? '-'}</td>
            <td>${row.record.CHP ?? '-'}</td>
            <td>${row.record.CHP_battery_volt ?? '-'}</td>
            <td>${row.record.THP ?? '-'}</td>
            <td>${row.record.THP_battery_volt ?? '-'}</td>
            <td>${row.record.ABP ?? '-'}</td>
            <td>${row.record.ABP_battery_volt ?? '-'}</td>
            <td>${row.record.FLT ?? '-'}</td>
            <td>${row.record.FLT_battery_volt ?? '-'}</td>
            <td>${row.record.Battery_Voltage ?? '-'}</td>
        </tr>`;
        serial++;
    });

    $('#table_data').html(html);

    // Pagination
    const container = document.getElementById("pagination");
    container.innerHTML = '';
    for (let i = 1; i <= totalPages; i++) {
        const btn = document.createElement("button");
        btn.textContent = i;
        if (i === currentPage) btn.classList.add("active");
        btn.addEventListener("click", () => {
            currentPage = i;
            renderMisTable();
        });
        container.appendChild(btn);
    }
}


function renderPaginationControls() {
    const groups = isSearching ? filteredMisGroups : misDataGroups;
    const totalPages = Math.ceil(groups.length / pageSize);
    const container = document.getElementById("pagination");
    container.innerHTML = '';

    for (let i = 1; i <= totalPages; i++) {
        const btn = document.createElement("button");
        btn.textContent = i;
        if (i === currentPage) btn.classList.add("active");
        btn.addEventListener("click", () => {
            currentPage = i;
            renderMisTable();
        });
        container.appendChild(btn);
    }
}

const columnMap = {
  1: 'well_name',
  2: 'Log_Date_Time',
  3: 'CHP',
  4: 'CHP_battery_volt',
  5: 'THP',
  6: 'THP_battery_volt',
  7: 'ABP',
  8: 'ABP_battery_volt',
  9: 'FLT',
  10: 'FLT_battery_volt',
  11: 'Battery_Voltage'
};

function sortMIS(columnIndex) {
    if (columnIndex === currentSortIndex) sortDirection *= -1;
    else { currentSortIndex = columnIndex; sortDirection = 1; }

    const prop = columnMap[columnIndex];
    if (!prop) return;

    const groups = isSearching ? filteredMisGroups : misDataGroups;
    groups.forEach(group => {
        group.records.sort((a, b) => {
            let valA = a[prop] ?? '';
            let valB = b[prop] ?? '';

            if (prop === 'Log_Date_Time') return (new Date(valA) - new Date(valB)) * sortDirection;
            if (!isNaN(valA) && !isNaN(valB)) return (Number(valA) - Number(valB)) * sortDirection;
            return String(valA).localeCompare(String(valB)) * sortDirection;
        });
    });

    renderMisTable();
    $('th.sortable').removeClass('active asc desc');
    $(`th[data-index="${columnIndex}"]`).addClass(`active ${sortDirection === 1 ? 'asc' : 'desc'}`);
}


</script>

<script src="https://cdn.jsdelivr.net/npm/exceljs@4.3.0/dist/exceljs.min.js"></script>

<script type="text/javascript">

async function export_report() {
  if (!misDataGroups || misDataGroups.length === 0) {
    alert('No data available to export');
    return;
  }

  const fromDateRaw = document.getElementById("from_date")?.value || '-';
  const toDateRaw   = document.getElementById("to_date")?.value   || '-';

  const fromDate = fromDateRaw ? moment(fromDateRaw, ['YYYY-MM-DD', 'DD-MM-YYYY']).format('DD-MM-YYYY') : '-';
  const toDate   = toDateRaw   ? moment(toDateRaw,   ['YYYY-MM-DD', 'DD-MM-YYYY']).format('DD-MM-YYYY') : '-';

  const workbook = new ExcelJS.Workbook();
  const sheet = workbook.addWorksheet('Threshold Report');

  const BLUE = '001A6E';
  const WHITE = 'FFFFFFFF';

  // ===== Title rows (NO blank row before this) =====
  sheet.getCell('A1').value = 'IOT BASED REAL TIME WELL MONITORING SYSTEM ONGC, CAMBAY ASSET';
  sheet.getCell('A1').alignment = { horizontal: 'center', vertical: 'middle' };
  sheet.getCell('A1').font = { bold: true, size: 14, color: { argb: 'FFFFFF' } };
  sheet.getCell('A1').fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: BLUE } };
  sheet.mergeCells(1, 1, 1, 12);

  sheet.getCell('A2').value = `Historical Report from ${fromDate} to ${toDate}`;
  sheet.getCell('A2').alignment = { horizontal: 'center', vertical: 'middle' };
  sheet.getCell('A2').font = { italic: true, size: 12, color: { argb: 'FFFFFF' } };
  sheet.getCell('A2').fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: BLUE } };
  sheet.mergeCells(2, 1, 2, 12);

  // Bottom border for full merged band of Row 2
  for (let c = 1; c <= 12; c++) {
    sheet.getCell(2, c).border = {
      bottom: { style: 'thin', color: { argb: WHITE } }
    };
  }

  // ===== Header rows =====
  const header1 = [
    'S.No', 'Well', 'Log Date Time', 'CHP (kg/cm²)', '', 'THP (kg/cm²)', '',
    'ABP (kg/cm²)', '', 'FLT (°C)', '', 'Battery(v)'
  ];
  const header2 = [
    '', '', '', 'Sensor', 'Battery(v)', 'Sensor', 'Battery(v)',
    'Sensor', 'Battery(v)', 'Sensor', 'Battery(v)', ''
  ];

  sheet.addRow(header1); // row 3
  sheet.addRow(header2); // row 4

  // Merge grouped header cells
  sheet.mergeCells(3, 4, 3, 5);  // CHP
  sheet.mergeCells(3, 6, 3, 7);  // THP
  sheet.mergeCells(3, 8, 3, 9);  // ABP
  sheet.mergeCells(3, 10, 3, 11); // FLT

  // Single-column headers span both rows
  [1, 2, 3, 12].forEach(col => {
    sheet.mergeCells(3, col, 4, col);
  });

  // Style header rows (3 & 4)
  [3, 4].forEach(r => {
    sheet.getRow(r).eachCell(cell => {
      cell.font = { bold: true, color: { argb: WHITE } };
      cell.alignment = { vertical: 'middle', horizontal: 'center', wrapText: true };
      cell.fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: BLUE } };
      cell.border = {
        top:    { style: 'thin', color: { argb: WHITE } },
        bottom: { style: 'thin', color: { argb: WHITE } },
        left:   { style: 'thin', color: { argb: WHITE } },
        right:  { style: 'thin', color: { argb: WHITE } }
      };
    });
  });

  // ===== Data rows start at row 5 =====
  let rowIndex = 5;
  let serial = 1;

  for (const group of misDataGroups) {
    const rowspan = group.records.length;

    // Merge Well column vertically
    sheet.mergeCells(rowIndex, 2, rowIndex + rowspan - 1, 2);
    sheet.getCell(rowIndex, 2).value = group.well_name || '-';
    sheet.getCell(rowIndex, 2).alignment = { vertical: 'middle', horizontal: 'center' };

    for (let i = 0; i < rowspan; i++) {
      const record = group.records[i];
      const row = sheet.getRow(rowIndex + i);

      // S.No — first row of the group
     row.getCell(1).value = serial++;

      row.getCell(3).value  = record.Log_Date_Time ? moment(record.Log_Date_Time).format('DD-MM-YYYY h:mm:ss a') : '-';
      row.getCell(4).value  = record.CHP ?? 0;
      row.getCell(5).value  = record.CHP_battery_volt ?? 0;
      row.getCell(6).value  = record.THP ?? 0;
      row.getCell(7).value  = record.THP_battery_volt ?? 0;
      row.getCell(8).value  = record.ABP ?? 0;
      row.getCell(9).value  = record.ABP_battery_volt ?? 0;
      row.getCell(10).value = record.FLT ?? 0;
      row.getCell(11).value = record.FLT_battery_volt ?? 0;
      row.getCell(12).value = record.Battery_Voltage ?? 0;

      for (let c = 1; c <= 12; c++) {
        row.getCell(c).alignment = { vertical: 'middle', horizontal: 'center' };
      }
    }

    rowIndex += rowspan;
  }

  // Column widths
  sheet.columns.forEach(col => col.width = 15);

  const buffer = await workbook.xlsx.writeBuffer();
  const blob = new Blob([buffer], { type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" });
  const link = document.createElement("a");
  link.href = URL.createObjectURL(blob);
  link.download = `Historical_Report_${moment().format("DD-MM-YYYY_HHmmss")}.xlsx`;
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
}


</script>