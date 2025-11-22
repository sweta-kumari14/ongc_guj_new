 <style>
  

    #data-table thead {
        position: sticky;
        top: 0;
        z-index: 5;
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

    #data-table tbody tr:hover {
        background-color: #f1f1f1;
        cursor: pointer;
    }

    .pagination {
        text-align: center;
        margin-top: 20px;
    }

    .pagination button {
        margin: 0 3px;
        padding: 6px 12px;
        border: 1px solid #888;
        background-color: #22c55e;
        cursor: pointer;
    }

    .pagination button.active {
        background-color: #231692;
        color: white;
        border-color: #231692;
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
        color: #ccc;
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
</style>
<div class="page-wrapper">
    <div class="content container-fluid">
            <div class="row row-sm">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h3><b>Device Commissioning Report</b></h3>
                            </div>
                            <div class="col-md-6 d-md-flex justify-content-end">
                                <div>
                                    <button class="btn btn-sm  btn-success" onclick="export_report();">Export</button>

                                </div>
                            </div>
                        </div>
                    <div class="row mb-2">
                       
                        <div class="col-md-4 mt-2">
                            <label class="form-group">Area Name</label>
                            <select name="area_id" id="area_id" class="form-control select2" style="width: 100%;" onchange="get_commissioning_report();">
                                <option value=""> All </option>
                                <?php 
                                if (!empty($area_list))
                                {
                                    foreach ($area_list as $key => $value)
                                    {
                                        ?>
                                            <option value="<?php echo $value['area_id']; ?>"><?php echo $value['area_name']; ?></option>

                                        <?php
                                    }
                                }

                                ?>
                            </select>
                        </div>
                        
                        <div class="col-md-4 mt-2">
                            <label for="example-select" class="form-group">From Date</label>
                            <input type="date" name="from_date" id="from_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" onchange="get_commissioning_report();get_installation_date();">
                        </div>
                        <div class="col-md-4 mt-2">
                            <label for="example-select" class="form-group">To Date</label>
                            <input type="date" name="to_date" id="to_date" class="form-control" value="<?php echo date('Y-m-d'); ?>"  onchange="get_commissioning_report();get_installation_date();">
                        </div>
                    </div>
                

                    <div class="row justify-content-center">
                    <div class="col-12 mt-2">
                    <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                        <div class="row mb-2 align-items-center">
                            <div class="col-md-6">
                                <select id="page-size" class="form-select form-select-sm w-auto">
                                    <option value="5">5</option>
                                    <option value="10" selected>10</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                </select>
                            </div>
                            <div class="col-md-6 text-end">
                                <input type="text" id="alert-search" class="form-control form-control-sm w-50 d-inline-block" placeholder="Search ...">
                            </div>
                        </div>

                         <div class="table-responsive mt-3">
                          <table class="table table-bordered table-sm" id="data-table">
                              <thead class="table-light">
                                <tr>
                                    <th class="text-center" style="width:5%;">SL.No.</th>
                                    <th class="text-center sortable" data-index="0" onclick="sortConfigLog(0)">Location <span class="arrow">
                                    <span class="up">▲</span>
                                    <span class="down">▼</span>
                                  </span></th>
                                    <th class="text-center sortable" data-index="1" onclick="sortConfigLog(1)">Well<span class="arrow">
                                    <span class="up">▲</span>
                                    <span class="down">▼</span>
                                   </span></th>
                                   <th class="text-center sortable" data-index="1" onclick="sortConfigLog(2)">Device Name<span class="arrow">
                                    <span class="up">▲</span>
                                    <span class="down">▼</span>
                                   </span></th>
                                   <th class="text-center sortable" data-index="1" onclick="sortConfigLog(3)">Imei No<span class="arrow">
                                    <span class="up">▲</span>
                                    <span class="down">▼</span>
                                   </span></th>
                                   <th class="text-center sortable" data-index="1" onclick="sortConfigLog(4)">Installation Date Time<span class="arrow">
                                    <span class="up">▲</span>
                                    <span class="down">▼</span>
                                   </span></th>
                                    <th class="text-center sortable" data-index="2" onclick="sortConfigLog(5)">Commissioning Date<span class="arrow">
                                    <span class="up">▲</span>
                                    <span class="down">▼</span>
                                  </span></th>
                                  
                                </tr>
                            </thead>

                            <tbody id="table_data" class="text-center">
                                
                            </tbody>
                        </table>
                    </div> 
                     <div class="row">
                            <div class="col-12">
                                <div class="pagination" style="float:right;" id="config-pagination"></div>
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
</div>      

        
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>

<script type="text/javascript">

    function toggleFilter() {
        $("#filter_section").toggle();
    }

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
let configData = [];
let filteredData = null;
let rowsPerPage = 10;
let currentPage = 1;
let currentSortIndex = 1; // default publish_date_time
let sortDirection = 1;
let base_url = '<?php echo base_url();?>';

get_commissioning_report();

function get_commissioning_report() {
    $('#table_data').html('<tr><td colspan="6" class="text-center">Loading...</td></tr>');

    const from_date = $('#from_date').val();
    const to_date = $('#to_date').val();
    const area_id = $('#area_id').val();

    $.ajax({
        url: "<?php echo base_url(); ?>Device_commissioning_c/commissioning_report_ajax",
        type: "POST",
        data: { from_date, to_date, area_id },
        success: function(res) {
            let response = JSON.parse(res);
               console.log('AJAX Response:', response);

            if (response.response_code == 200) {
                configData = response.data || [];
                filteredData = null;
                currentPage = 1;
                renderTable();
            } else {
                $('#table_data').html(`
                    <tr>
                        <td colspan="6" class="text-center">
                           
                            <p class="text-danger mt-2 fw-bold">No Record Found !!</p>
                        </td>
                    </tr>
                `);

            }
        }
    });
}

function renderTable() {
    let source = filteredData ?? configData;

    if (!source || source.length === 0) {
        $('#table_data').html(`
            <tr>
                <td colspan="7" class="text-center">
                    
                    <p class="text-danger mt-2 fw-bold">No Record Found !!</p>
                </td>
            </tr>
        `);
        $('#config-pagination').html('');
        return;
    }

    // Sorting
    source.sort((a, b) => {
        let valA = getValue(a, currentSortIndex);
        let valB = getValue(b, currentSortIndex);

        if (currentSortIndex === 4 || currentSortIndex === 5) {
            return (new Date(valA) - new Date(valB)) * sortDirection;
        }

        return String(valA).localeCompare(String(valB)) * sortDirection;
    });

    // Pagination
    const totalPages = Math.ceil(source.length / rowsPerPage);
    const start = (currentPage - 1) * rowsPerPage;
    const pageData = source.slice(start, start + rowsPerPage);

    let html = '';
    let sl = start + 1;

    pageData.forEach(row => {
        html += `
            <tr class="text-center">
                <td>${sl++}</td>
                <td>${row.area_name}</td>
                <td>${row.well_name}</td>
                <td>${row.device_name}</td>
                <td>${row.imei_no}</td>
                <td>${moment(row.installation_date).format("DD-MM-YYYY hh:mm:ss A")}</td>
                <td>${moment(row.commissioning_date).format("DD-MM-YYYY")}</td>
            </tr>
        `;
    });

    $('#table_data').html(html);
    renderPagination(totalPages);
}


function getValue(r, index) {
    switch (index) {
        case 0: return r.area_name || '';
        case 1: return r.well_name || '';
        case 2: return r.device_name || '';
        case 3: return r.imei_no || '';
        case 4: return r.installation_date || '';
        case 5: return r.commissioning_date || '';
        default: return '';
    }
}

// Sorting columns
function sortConfigLog(index) {
    if (currentSortIndex === index) sortDirection *= -1;
    else {
        currentSortIndex = index;
        sortDirection = 1;
    }
    renderTable();
}

// Pagination
function renderPagination(total) {
    let html = '';
    for (let i = 1; i <= total; i++) {
        html += `<button class="btn btn-sm ${i === currentPage ? 'btn-primary' : 'btn-primary'}"
                 onclick="gotoPage(${i})">${i}</button>`;
    }
    $('#config-pagination').html(html);
}

function gotoPage(p) {
    currentPage = p;
    renderTable();
}

// Search
$('#alert-search').on('keyup', function() {
    const key = $(this).val().toLowerCase();
    filteredData = key
        ? configData.filter(r =>
            (r.area_name ?? '').toLowerCase().includes(key) ||
            (r.well_site_name ?? '').toLowerCase().includes(key) ||
            (r.well_name ?? '').toLowerCase().includes(key) ||
            moment(r.installation_date).format("DD-MM-YYYY hh:mm:ss A").toLowerCase().includes(key)||
            moment(r.commissioning_date).format("DD-MM-YYYY hh:mm:ss A").toLowerCase().includes(key)
        )
        : null;
    currentPage = 1;
    renderTable();
});
</script>
<script src="https://cdn.jsdelivr.net/npm/exceljs@4.3.0/dist/exceljs.min.js"></script>
<script type="text/javascript">

async function export_report() {
    const table = document.getElementById("data-table");
    if (!table) {
        alert("No table found.");
        return;
    }

    let fromDateRaw = document.getElementById("from_date")?.value || '';
    let toDateRaw = document.getElementById("to_date")?.value || '';

    const fromDate = fromDateRaw ? moment(fromDateRaw).format('DD-MM-YYYY') : '-';
    const toDate = toDateRaw ? moment(toDateRaw).format('DD-MM-YYYY') : '-';

    const workbook = new ExcelJS.Workbook();
    const sheet = workbook.addWorksheet('Device Config Report');

    const allRows = [];
    const spanMap = {};
    let maxColCount = 0;

    // Convert HTML table → array rows
    for (let r = 0; r < table.rows.length; r++) {
        const row = table.rows[r];
        const excelRow = [];
        let colIndex = 0;

        while (excelRow[colIndex] !== undefined) colIndex++;

        for (let c = 0; c < row.cells.length; c++) {
            const cell = row.cells[c];

            // ⭐ REMOVE SORTING ARROWS FROM HEADER/TEXT ⭐
            let text = cell.innerText
                .replace(/[\u2190-\u21FF\u25B2\u25BC\u25B3\u25BD]/g, '')   // remove all arrow icons
                .replace(/[\n\s]+/g, ' ')
                .trim();

            while (spanMap[`${r}:${colIndex}`] !== undefined) {
                excelRow[colIndex] = spanMap[`${r}:${colIndex}`];
                colIndex++;
            }

            const colspan = parseInt(cell.getAttribute("colspan") || "1");
            const rowspan = parseInt(cell.getAttribute("rowspan") || "1");

            if (rowspan > 1) {
                for (let i = 1; i < rowspan; i++) {
                    for (let j = 0; j < colspan; j++) {
                        spanMap[`${r + i}:${colIndex + j}`] = "";
                    }
                }
            }

            excelRow[colIndex] = text;
            colIndex += colspan;
        }

        maxColCount = Math.max(maxColCount, excelRow.length);
        allRows.push(excelRow);
    }

    // Title Rows
    sheet.addRow([]);
    sheet.addRow([]);

    sheet.getCell('A1').value = 'IOT Based Real Time Well Monitoring System ONGC,CAMBAY Asset';
    sheet.mergeCells(1, 1, 1, maxColCount);
    sheet.getCell('A1').alignment = { horizontal: 'center', vertical: 'middle', wrapText: true };
    sheet.getCell('A1').font = { bold: true, size: 22, color: { argb: 'FFFFFF' } };
    sheet.getCell('A1').fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: '001A6E' } };

    sheet.getCell('A2').value = `Well Commissioning Report from ${fromDate} to ${toDate}`;
    sheet.mergeCells(2, 1, 2, maxColCount);
    sheet.getCell('A2').alignment = { horizontal: 'center', vertical: 'middle', wrapText: true };
    sheet.getCell('A2').font = { italic: true, size: 15, color: { argb: 'FFFFFF' } };
    sheet.getCell('A2').fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: '001A6E' } };

    // Add table rows
    allRows.forEach(row => {
        while (row.length < maxColCount) row.push('');
        sheet.addRow(row);
    });

    // Apply styling
    sheet.eachRow((row, rowNumber) => {
        row.eachCell(cell => {
            if (rowNumber === 1 || rowNumber === 2) {
                cell.fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: '001A6E' } };
                cell.font = { color: { argb: 'FFFFFF' }, bold: rowNumber === 1 };
            } else if (rowNumber === 3) {
                cell.fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: '001A6E' } };
                cell.font = { color: { argb: 'FFFFFF' }, bold: true };
            }

            cell.border = {
                top: { style: 'thin', color: { argb: 'CCCCCC' } },
                bottom: { style: 'thin', color: { argb: 'CCCCCC' } },
                left: { style: 'thin', color: { argb: 'CCCCCC' } },
                right: { style: 'thin', color: { argb: 'CCCCCC' } }
            };

            cell.alignment = { vertical: 'middle', horizontal: 'center', wrapText: true };
        });
    });

    sheet.columns.forEach(col => { col.width = 20; });

    // Download Excel
    const buffer = await workbook.xlsx.writeBuffer();
    const blob = new Blob([buffer], {
        type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
    });

    const link = document.createElement("a");
    link.href = URL.createObjectURL(blob);
    link.download = "Device_Commissioning_Report.xlsx";
    link.click();
}




</script>


                

