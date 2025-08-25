<style type="text/css">
    .select2-selection__rendered{
        margin-top: 9px!important;
    }
</style>
<style>
    .thead-dark th {
        background-color: #001A6E !important;
        color: white !important;
        text-align: center;
        white-space: nowrap;
        padding-right: 16px;
        position: relative;
    }

    .tooltip-inner {
        background-color: #1e88e5 !important;
        color: #fff !important;            
        font-weight: 500;
        font-size: 13px;
        padding: 6px 10px;
        border-radius: 6px;
    }

    #data-table thead {
        position: sticky;
        top: 0;
        z-index: 5;
    }

    .table-responsive thead th {
        
        color: black;
        position: sticky;
        top: 0;
        z-index: 2;
        border: 1px solid #fff;
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
        background-color: #fff;
        color: #001A6E;
        cursor: pointer;
        transition: all 0.2s ease-in-out;
        border-radius: 4px;
    }

    .pagination button:hover:not(.active) {
        background-color: #001A6E;
        color: #fff;
        border-color: #001A6E;
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
</style>

<div class="page-wrapper">
    <div class="content container-fluid pt-2">
        <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Flowing Well</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo base_url('Selfflow_c');?>">Dashboard</a></li>
                            <li class="breadcrumb-item ">Flowing</li>
                            
                        </ul>
                    </div>
                </div>
            </div>
<!-- /Page Header -->
            <div class="row"style="margin-top: -20px;">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <!-- Header row with title and buttons -->
                <div class="row align-items-center mb-3">
                    <div class="col">
                        <h4 class="header-title mb-0">Flowing Well List</h4>
                    </div>
                    <div class="col-auto ms-auto">
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
                <!-- Table controls row -->
                <div class="row mb-2 align-items-center">
                    <div class="col-md-6 mt-2">
                        <label class="me-2">Page Size</label>
                        <select id="page-size" class="form-select form-select-sm w-auto d-inline-block">
                            <option value="5">5</option>
                            <option value="10" selected>10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                        </select>
                    </div>
                    <div class="col-md-6 text-end">
                        <input type="text" id="mis-search" class="form-control form-control-sm w-50 d-inline-block" placeholder="Search...">
                    </div>
                </div>

                <!-- Table -->
                <div class="table-responsive" style="max-height: 500px; overflow-y: auto; overflow-x: auto;">
                    <table class="table table-bordered table-hover m-0" id="data-table">
                        <thead>
                            <tr>
                                <th class="sortable" data-index="0" onclick="sortMIS(0)">S.No <span class="arrow"><span class="up">▲</span><span class="down">▼</span></span></th>
                                <th class="sortable" data-index="1" onclick="sortMIS(1)">Area <span class="arrow"><span class="up">▲</span><span class="down">▼</span></span></th>
                                <th class="sortable" data-index="2" onclick="sortMIS(2)">Well <span class="arrow"><span class="up">▲</span><span class="down">▼</span></span></th>
                                <th class="sortable" data-index="5" onclick="sortMIS(5)">Last Updated Date Time <span class="arrow"><span class="up">▲</span><span class="down">▼</span></span></th>
                                <th class="sortable" data-index="6" onclick="sortMIS(6)">Imei No <span class="arrow"><span class="up">▲</span><span class="down">▼</span></span></th>
                                <th class="sortable" data-index="7" onclick="sortMIS(7)">THP (kgf/cm²)<span class="arrow"><span class="up">▲</span><span class="down">▼</span></span></th>
                                <th class="sortable" data-index="8" onclick="sortMIS(8)">CHP (kgf/cm²)<span class="arrow"><span class="up">▲</span><span class="down">▼</span></span></th>
                                <th class="sortable" data-index="9" onclick="sortMIS(9)">ABP (kgf/cm²)<span class="arrow"><span class="up">▲</span><span class="down">▼</span></span></th>
                                <th class="sortable" data-index="10" onclick="sortMIS(10)">FLT (°C)<span class="arrow"><span class="up">▲</span><span class="down">▼</span></span></th>
                                <th class="sortable" data-index="11" onclick="sortMIS(11)">Battery (v)<span class="arrow"><span class="up">▲</span><span class="down">▼</span></span></th>
                            </tr>
                        </thead>
                        <tbody id="table_data"></tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="row mt-2">
                    <div class="col-12">
                        <div class="pagination" style="float:right;" id="pagination"></div>
                    </div>
                </div>
            </div> <!-- card-body -->
        </div> <!-- card -->
    </div> <!-- col-xl-12 -->
</div> <!-- row -->

            <!-- End Row -->
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
        renderWell_statusTable();
    });

    $('#mis-search').on('keyup', function () {
        const keyword = $(this).val().toLowerCase().trim();
        isSearching = keyword.length > 0;

        if (!keyword) {
            filteredMisGroups = [];
            currentPage = 1;
            renderWell_statusTable();
            return;
        }

        filteredMisGroups = misDataGroups.filter(group => {
            const groupMatch = [group.area_name, group.well_name]
                .some(val => val?.toLowerCase().includes(keyword));

            const recordMatch = group.records.some(row =>
                Object.values(row).some(val => val?.toString().toLowerCase().includes(keyword))
            );

            return groupMatch || recordMatch;
        });

        currentPage = 1;
        renderWell_statusTable();
    });

    get_overall_dashboard(); 
});

let link_url = '<?php echo base_url();?>';

function get_overall_dashboard() {
    $('#table_data').html('<tr><td colspan="12">Loading...</td></tr>');
    let well_id = $('#well_id').val();
    let site_id = $('#site_id').val();
    let area_id = $('#area_id').val();
    let base_url = '<?php echo base_url();?>';

    $.ajax({
        url: base_url + 'Overall_list_selfflow_c/flowing_well_ajax',
        method: 'POST',
        data: { well_id, site_id, area_id },
        success: function (res) {
            const response = JSON.parse(res);
            // console.log(response,'response');
            if (response.response_code == 200 && response.data?.length > 0) {
                const dataList = response.data;
                groupMap = {};

                dataList.forEach((row, idx) => {
                    const key = `${row.area_name}_${row.well_name}`;
                    if (!groupMap[key]) {
                        groupMap[key] = {
                            groupKey: key,
                            area_name: row.area_name,
                            well_name: row.well_name,
                            originalIndex: idx,
                            records: []
                        };
                    }
                    groupMap[key].records.push(row);
                });

                misDataGroups = Object.values(groupMap);
                filteredMisGroups = [];
                currentPage = 1;
                renderWell_statusTable();
            } else {
                $('#table_data').html(`
                    <tr><td colspan="12" class="text-danger text-center">
                        <div style="margin-top: 5px;">No records Found.</div>
                    </td></tr>
                `);
            }
        },
        error: function () {
            $('#table_data').html(`
                <tr><td colspan="12" class="text-danger text-center">
                    <div style="margin-top: 5px;">Error fetching data</div>
                </td></tr>
            `);
        }
    });
}

function renderWell_statusTable() {
    let groups = isSearching ? filteredMisGroups : misDataGroups;

    if (!groups || groups.length === 0) {
        $('#table_data').html(`
            <tr><td colspan="12" class="text-center text-danger">
                <div style="margin-top: 5px;">No matching records.</div>
            </td></tr>
        `);
        $('#pagination').html('');
        return;
    }

    const start = (currentPage - 1) * pageSize;
    const end = start + pageSize;
    const pageGroups = groups.slice(start, end);

    let html = '';
    let serial = start + 1;

    pageGroups.forEach(group => {
        const records = group.records;
        let areaRendered = false;

        records.forEach((v, i) => {
            const lastUpdatedTime = v.Log_Date_Time ? moment(v.Log_Date_Time).format('DD-MM-YYYY h:mm:ss a') : "NA";
            const link = `${link_url}Selfflow_c/SingleWellDashboard/${v.well_id}`;
          
            html += `<tr>`;

            if (!areaRendered) {
                html += `<td rowspan="${records.length}" style="text-align:center; vertical-align:middle;">${serial++}</td>`;
                html += `<td rowspan="${records.length}" style="text-align:center; vertical-align:middle;">${group.area_name}</td>`;
                areaRendered = true;
            }

           html += `<td style="text-align:center;">
            <a style="color: green;" href="${link}">
                ${v.well_name ?? '-'}
            </a>
            </td>`;


            html += `<td style="text-align:center;">${lastUpdatedTime}</td>`;
            html += `<td style="text-align:center;">${v.imei_no ?? ''}</td>`;
            html += `<td style="text-align:center;">${v.THP ? parseFloat(v.THP).toFixed(2) : '0.00'}</td>`;
            html += `<td style="text-align:center;">${v.CHP ? parseFloat(v.CHP).toFixed(2) : '0.00'}</td>`;
            html += `<td style="text-align:center;">${v.ABP ? parseFloat(v.ABP).toFixed(2) : '0.00'}</td>`;
            html += `<td style="text-align:center;">${v.FLT ? parseFloat(v.FLT).toFixed(2) : '0.00'}</td>`;
            html += `<td style="text-align:center;">${v.Battery_Voltage ? parseFloat(v.Battery_Voltage).toFixed(2) : '0.00'}</td>`;
            html += `</tr>`;
        });
    });

    $('#table_data').html(html);
    $('[data-toggle="tooltip"]').tooltip();
    renderPaginationControls();
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
            renderWell_statusTable();
        });
        container.appendChild(btn);
    }
}

const columnMap = {
  0: null, // Sl No.
  1: 'area_name',
  2: 'well_name',
  5: 'last_Log_Date_Time',
  6: 'imei_no',
  7: 'FTHP',
  8: 'CHP',
  9: 'ABP',
  10: 'FLT',
  11: 'Battery_Voltage'
};

function flattenRecords(groups) {
    return groups.flatMap(group =>
        group.records.map(record => ({
            ...record,
            area_name: group.area_name,
            well_name: group.well_name
        }))
    );
}

function sortMIS(columnIndex) {
    if (columnIndex === currentSortIndex) {
        sortDirection *= -1;
    } else {
        currentSortIndex = columnIndex;
        sortDirection = 1;
    }

    const prop = columnMap[columnIndex];
    if (!prop) return;

    const groups = isSearching ? filteredMisGroups : misDataGroups;
    let flatRecords = flattenRecords(groups);

    flatRecords.sort((a, b) => {
        let valA = a[prop] ?? '';
        let valB = b[prop] ?? '';
        if (!isNaN(valA) && !isNaN(valB)) return (Number(valA) - Number(valB)) * sortDirection;
        return String(valA).localeCompare(String(valB)) * sortDirection;
    });

    const regrouped = {};
    flatRecords.forEach((row, idx) => {
        const key = `${row.area_name}_${row.well_name}`;
        if (!regrouped[key]) {
            regrouped[key] = {
                groupKey: key,
                area_name: row.area_name,
                well_name: row.well_name,
                originalIndex: idx,
                records: []
            };
        }
        regrouped[key].records.push(row);
    });

    const result = Object.values(regrouped);
    if (isSearching) filteredMisGroups = result; else misDataGroups = result;

    renderWell_statusTable();
    $('th.sortable').removeClass('active asc desc');
    $(`th[data-index="${columnIndex}"]`).addClass(`active ${sortDirection === 1 ? 'asc' : 'desc'}`);
}

</script>
<script src="https://cdn.jsdelivr.net/npm/exceljs@4.3.0/dist/exceljs.min.js"></script>

<script type="text/javascript">

    async function export_report() {
        const table = document.getElementById("data-table");
        if (!table) {
            alert("No table found.");
            return;
        }

        const workbook = new ExcelJS.Workbook();
        const sheet = workbook.addWorksheet('Total Well Report');

        const spanMap = {};
        let maxColCount = 0;
        const allRows = [];

        // Step 1: Parse table rows
        for (let r = 0; r < table.rows.length; r++) {
            const row = table.rows[r];
            const excelRow = [];
            let colIndex = 0;

            while (excelRow[colIndex] !== undefined) colIndex++;

            for (let c = 0; c < row.cells.length; c++) {
                const cell = row.cells[c];
                let cellValue = cell.innerText
                    .replace(/[\u2190-\u21FF\u25B2\u25BC]/g, '')
                    .replace(/\n+/g, ' ')
                    .replace(/\s+/g, ' ')
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
                            spanMap[`${r + i}:${colIndex + j}`] = cellValue;
                        }
                    }
                }

                excelRow[colIndex] = cellValue;
                colIndex += colspan;
            }

            maxColCount = Math.max(maxColCount, excelRow.length);
            allRows.push(excelRow);
        }

        // Step 2: Title Rows
        sheet.addRow([]);
        sheet.addRow([]);

        sheet.getCell('A1').value = 'IOT Based Real Time Well Monitoring System ONGC, Cambay Assets';
        sheet.getRow(1).height = 30;
        sheet.getCell('A1').alignment = { horizontal: 'center', vertical: 'middle', wrapText: true };
        sheet.getCell('A1').font = { bold: true, size: 22, color: { argb: 'FFFFFF' } };
        sheet.getCell('A1').fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: '001A6E' } };
        sheet.mergeCells(1, 1, 1, maxColCount);

        sheet.getCell('A2').value = `Flowing Well List Report`;
        sheet.getCell('A2').alignment = { horizontal: 'center', vertical: 'middle', wrapText: true };
        sheet.getCell('A2').font = { italic: true, size: 15, color: { argb: 'FFFFFF' } };
        sheet.getCell('A2').fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: '001A6E' } };
        sheet.mergeCells(2, 1, 2, maxColCount);

        // Step 3: Add rows
        const headerRowCount = 2;
        allRows.forEach((row) => {
            while (row.length < maxColCount) row.push('');
            sheet.addRow(row);
        });

        // Step 4: Merge SL No if Area matches
        const areaColIndex = 2;
        const slNoColIndex = 1;
        const startRow = headerRowCount + 1;

        let prevArea = sheet.getCell(startRow, areaColIndex).value;
        let mergeStartRow = startRow;

        for (let i = startRow + 1; i <= sheet.rowCount + 1; i++) {
            const currArea = i <= sheet.rowCount ? sheet.getCell(i, areaColIndex).value : '__END__';

            if (currArea !== prevArea || i === sheet.rowCount + 1) {
                const mergeEndRow = i - 1;
                if (mergeStartRow < mergeEndRow) {
                    sheet.mergeCells(mergeStartRow, slNoColIndex, mergeEndRow, slNoColIndex);
                    sheet.getCell(mergeStartRow, slNoColIndex).alignment = {
                        vertical: 'middle',
                        horizontal: 'center',
                        wrapText: true
                    };
                }
                mergeStartRow = i;
                prevArea = currArea;
            }
        }

        // Step 5: Merge Area & Cluster columns
        const mergeCols = [2, 3];
        mergeCols.forEach(col => {
            let start = startRow;
            let prevVal = sheet.getCell(start, col).value;

            for (let i = start + 1; i <= sheet.rowCount + 1; i++) {
                const currentVal = i <= sheet.rowCount ? sheet.getCell(i, col).value : '__END__';
                if (currentVal !== prevVal || i === sheet.rowCount + 1) {
                    const endRow = i - 1;
                    if (start < endRow) {
                        sheet.mergeCells(start, col, endRow, col);
                        sheet.getCell(start, col).alignment = {
                            vertical: 'middle',
                            horizontal: 'center',
                            wrapText: true
                        };
                    }
                    start = i;
                    prevVal = currentVal;
                }
            }
        });

        // Step 6: Styling and Status Text Color
        sheet.eachRow((row, rowNumber) => {
            row.eachCell(cell => {
                const value = (cell.value || "").toString().toLowerCase();

                if (rowNumber === 1 || rowNumber === 2) {
                    cell.fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: '001A6E' } };
                    cell.font = {
                        color: { argb: 'FFFFFF' },
                        bold: rowNumber === 1,
                        italic: rowNumber === 2
                    };
                } else if (rowNumber === 3) {
                    cell.fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: '001A6E' } };
                    cell.font = { color: { argb: 'FFFFFF' }, bold: true };
                    cell.border = {
                        top: { style: 'thin', color: { argb: 'FFFFFF' } },
                        bottom: { style: 'thin', color: { argb: 'FFFFFF' } },
                        left: { style: 'thin', color: { argb: 'FFFFFF' } },
                        right: { style: 'thin', color: { argb: 'FFFFFF' } }
                    };
                } else {
                    // 🖍️ Color based on status text
                    if (value === "flowing") {
                        cell.font = { color: { argb: 'FF28A745' } }; // Green
                    } else if (value === "offline") {
                        cell.font = { color: { argb: 'FFDC3545' } }; // Red
                    } else if (value === "non-flowing") {
                        cell.font = { color: { argb: 'FFECA869' } }; // Orange
                    } else if (value === "battery issue") {
                        cell.font = { color: { argb: 'FF82A0D8' } }; // Blue
                    } else if (value === "unknown") {
                        cell.font = { color: { argb: 'FF6C757D' } }; // Grey
                    }

                    cell.border = {
                        top: { style: 'thin', color: { argb: 'CCCCCC' } },
                        bottom: { style: 'thin', color: { argb: 'CCCCCC' } },
                        left: { style: 'thin', color: { argb: 'CCCCCC' } },
                        right: { style: 'thin', color: { argb: 'CCCCCC' } }
                    };
                }

                cell.alignment = { vertical: 'middle', horizontal: 'center', wrapText: true };
            });
        });

        // Step 7: Set column widths
        sheet.columns.forEach(col => {
            col.width = 20;
        });

        // Step 8: Download
        const buffer = await workbook.xlsx.writeBuffer();
        const blob = new Blob([buffer], {
            type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
        });
        const link = document.createElement("a");
        link.href = URL.createObjectURL(blob);
        link.download = "Flowing_Well_Report.xlsx";
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

</script>
