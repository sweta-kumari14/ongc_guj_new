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
    
</style>
<div class="page-wrapper">
    <div class="content container-fluid pb-0">
            <div class="page-header">
                <div class="content-page-header" style="margin-top: -28px;">
                    <h5>Configuration Report</h5>
                </div>  
            </div>
            <div class="row" style="margin-top: -21px;">                   
                <!-- Lightbox -->
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                           <div class="row align-items-center justify-content-between mb-3">
                            <div class="col-md-6">
                                <h4 class="header-title mb-0"><b>Configuration Report</b></h4>
                            </div>
                            <div class="col-md-6 text-end">
                                 <button type="button" id="export_btns" onclick="exportThresholdReportToExcel();" class="btn btn-outline-success me-2">
                                   <i class="fa-solid fa-file-excel"></i> Export
                                </button>

                                <a href="<?php echo base_url('')?>Selfflow_c">
                                    <button type="button" id="back_btns" class="btn btn-outline-warning">
                                        <i class="fa-solid fa-left-long"></i> Back
                                    </button>
                                </a>
                            </div>
                        </div>
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-group text-dark">Area</label>
                                <select class="form-control select2" id="area_id" name="area_id"
                                    onchange="get_site_list();get_well_list();get_threshold_report();" style="width: 100%;">
                                    <?php
                                        if (!empty($area_list)) {
                                            echo '<option value="">Select Area</option>';
                                            foreach ($area_list as $key => $value) {
                                    ?>
                                    <option value="<?php echo $value['id']; ?>">
                                        <?php echo $value['area_name']; ?></option>
                                    <?php
                                            
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-group text-dark">Location</label>
                                <select class="form-control select2" id="site_id" name="site_id"
                                    onchange="get_well_list();get_threshold_report();" style="width: 100%;">
                                </select>
                            </div>
                            <div class="col-md-4">
                            <label class="form-group text-dark">Device Name</label>
                            <select name="imei_no" id="imei_no" class="form-control select2" style="width: 100%;" onchange="get_threshold_report();">
                                <option value=""> Select Device </option>
                                <?php 
                                if (!empty($device_list))
                                {
                                    foreach ($device_list as $key => $value)
                                    {
                                        ?>
                                            <option value="<?php echo $value['imei_no']; ?>"><?php echo $value['device_name'] .'|'.$value['imei_no']; ?></option>

                                        <?php
                                    }
                                }

                                ?>
                            </select>
                        </div>

                            <div class="col-md-4 mt-2">
                                <label class="form-group">Well Name</label>
                                <select onchange="get_threshold_report();" class="form-select select2" id="well_id" name="well_id[]" multiple style="width: 100%;">
                                        
                                </select>
                            </div>
                            <div class="col-md-4 mt-2">
                                 <label class="form-group">From Date</label>
                                <input type="date" name="from_date" id="from_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" onchange="get_threshold_report();get_installation_date();">
                            </div>
                            <div class="col-md-4 mt-2">
                                 <label class="form-group">To Date</label>
                                <input type="date" name="to_date" id="to_date" class="form-control" value="<?php echo date('Y-m-d'); ?>"  onchange="get_threshold_report();get_installation_date();">
                            </div>
                        </div>
                    </div>
                </div>
            <div class="row justify-content-center">
               <div class="col-12 mt-2">
                        <div class="row mb-2 align-items-center">
                        <div class="col-md-6">
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
                    <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                        <table class="table table-bordered m-0" id="data-table">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="sortable" data-index="0" onclick="sortMIS(0)">Sl No.<span class="arrow"><span class="up">▲</span><span class="down">▼</span></span></th>
                                    <th class="sortable" data-index="1" onclick="sortMIS(1)">Area <span class="arrow"><span class="up">▲</span><span class="down">▼</span></span></th>
                                    <th class="sortable" data-index="2" onclick="sortMIS(2)">Location <span class="arrow"><span class="up">▲</span><span class="down">▼</span></span></th>
                                    <th class="sortable" data-index="3" onclick="sortMIS(3)">Well <span class="arrow"><span class="up">▲</span><span class="down">▼</span></span></th>
                                    <th class="sortable" data-index="3" onclick="sortMIS(12)">Device  <span class="arrow"><span class="up">▲</span><span class="down">▼</span></span></th>

                                    <th class="sortable" data-index="4" onclick="sortMIS(4)">Node Name <span class="arrow"><span class="up">▲</span><span class="down">▼</span></span></th>
                                    <th class="sortable" data-index="5" onclick="sortMIS(5)">Tag No <span class="arrow"><span class="up">▲</span><span class="down">▼</span></span></th>
                                     <th class="sortable" data-index="6" onclick="sortMIS(6)">Max Value <span class="arrow"><span class="up">▲</span><span class="down">▼</span></span></th>
                                    <th class="sortable" data-index="7" onclick="sortMIS(7)">Upper Value <span class="arrow"><span class="up">▲</span><span class="down">▼</span></span></th>
                                    <th class="sortable" data-index="8" onclick="sortMIS(8)">Lower Value <span class="arrow"><span class="up">▲</span><span class="down">▼</span></span></th>
                                    <th class="sortable" data-index="9" onclick="sortMIS(9)">Multiplier <span class="arrow"><span class="up">▲</span><span class="down">▼</span></span></th>
                                    <th class="sortable" data-index="10" onclick="sortMIS(10)">Offset <span class="arrow"><span class="up">▲</span><span class="down">▼</span></span></th>
                                    <th class="sortable" data-index="11" onclick="sortMIS(11)">Date Time <span class="arrow"><span class="up">▲</span><span class="down">▼</span></span></th>
                                </tr>
                                
                            </thead>
                            <tbody class="text-center" id="table_data"> 
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
</div>
 
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

    get_site_list();
    function get_site_list() 
    {
        let company_id = "<?php echo $this->session->userdata('company_id') ?>";
        let user_id = "<?php echo $this->session->userdata('user_id') ?>";
        let area_id = $('#area_id').val();

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>Threshold_setup_selfflow_c/getsite_list',
            data: {
                company_id: company_id,
                area_id: area_id,
                user_id: user_id
            },
            success: function(data) {
                data = JSON.parse(data);

                if (data.response_code == 200) {
                    if (data.data.length > 0) {
                        $('#site_id').html('');
                        $('#site_id').html('<option value="">Select site</option>');
                        $.each(data.data, function(i, v) {
                            // let selected = (v.id == v.id) ? 'selected' : '';
                            $('#site_id').append('<option value="' + v.id + '">' + v.well_site_name +
                                '</option>');
                        });
                    } else {
                        $('#site_id').html('<option value="">No Data Found</option>');
                    }
                } else {
                    swal('error', data.msg, 'error');
                }
            }
        });
    }

    get_well_list();

    function get_well_list() {
        let company_id = "<?php echo $this->session->userdata('company_id') ?>";
        let user_id = "<?php echo $this->session->userdata('user_id') ?>";
       
        let area_id = $('#area_id').val();
        let site_id = $('#site_id').val();
        
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>Threshold_setup_selfflow_c/getWell_forinstallation_list',
            data: {
                company_id: company_id,
                area_id: area_id,
                user_id: user_id,
                site_id: site_id,
               
            },
            success: function(data) {
                data = JSON.parse(data);

                if (data.response_code == 200) {
                    if (data.data.length > 0) {
                        $('#well_id').html('');
                        $('#well_id').html('<option value="">Select Well</option>');
                        $.each(data.data, function(i, v) {

                            $('#well_id').append('<option value="' + v.well_id + '">' + v.well_name +
                                '</option>');
                        });
                    } else {
                        $('#well_id').html('<option value="">No Well Found</option>');
                    }
                } else {
                    swal('error', data.msg, 'error');
                }
            }
        });
    }

</script>
<script type="text/javascript">

let groupMap = {};
let misDataGroups = [];
let filteredMisGroups = [];
let currentPage = 1;
let pageSize = 10;
let currentSortIndex = 1;
let sortDirection = 1;
let isSearching = false;  // Search state flag

$(document).ready(function () {
    $('#page-size').on('change', function () {
        pageSize = parseInt($(this).val()) || 10;
        currentPage = 1;
        renderMisTable();
    });

    $('#mis-search').on('keyup', function () {
        const keyword = $(this).val().toLowerCase().trim();
        console.log('Search keyword:', keyword);
        isSearching = keyword.length > 0;

        if (!keyword) {
            console.log('Empty search keyword, resetting filteredMisGroups');
            filteredMisGroups = [];
            currentPage = 1;
            renderMisTable();
            return;
        }

        filteredMisGroups = misDataGroups.map(group => {
            // Filter records inside this group
            const filteredRecords = group.records.filter(row =>
                Object.values(row).some(val =>
                    val?.toString().toLowerCase().includes(keyword)
                )
            );

            // Check if group name matches OR any record matched
            const groupMatch = [group.area_name, group.well_site_name, group.well_name]
                .some(val => val?.toLowerCase().includes(keyword));

            if (groupMatch || filteredRecords.length > 0) {
                return {
                    ...group,
                    records: groupMatch ? group.records : filteredRecords  // <- keep full group if group matched
                };
            }
            return null;
        }).filter(g => g !== null);


        console.log('Filtered groups count:', filteredMisGroups.length);
        currentPage = 1;
        renderMisTable();
    });

    get_threshold_report(); // Initial call
});
let link_url = '<?php echo base_url();?>';

function get_threshold_report() {
    $('#table_data').html('<tr><td colspan="18">Loading...</td></tr>');

    const company_id = "<?= $this->session->userdata('company_id'); ?>";
    const base_url = "<?= base_url(); ?>";
    const from_date = $('#from_date').val();
    const to_date = $('#to_date').val();
    const area_id = $('#area_id').val();
    const site_id = $('#site_id').val();
    const well_id = $('#well_id').val();
    const imei_no = $('#imei_no').val();

    

    $.ajax({
        url: base_url + 'Threshold_setup_selfflow_c/get_Threshold_report',
        method: 'POST',
        data: { company_id, from_date, to_date,area_id,site_id, well_id,imei_no },
        success: function (res) {
            const response = JSON.parse(res);

            console.log(response,'sdfhsadfj');
            if (response.response_code == 200 && response.data?.length > 0) {
                const dataList = response.data;
                groupMap = {};

                dataList.forEach(row => {
                    const key = `${row.area_name}_${row.well_site_name}_${row.well_name}`;
                    if (!groupMap[key]) {
                        groupMap[key] = {
                            groupKey: key,
                            area_name: row.area_name,
                            well_site_name: row.well_site_name,
                            well_name: row.well_name,
                            device_name:row.device_name,
                            records: []
                        };
                    }
                    groupMap[key].records.push(row);
                });

                misDataGroups = Object.values(groupMap);
                filteredMisGroups = [];
                currentPage = 1;
                renderMisTable();
            } else {
                $('#table_data').html(`<tr><td colspan="18" class="text-danger text-center"><div>
          </div>
          <div style="margin-top: 5px;">No record Found.</div></td></tr>`);
            }
        },
        error: function () {
            $('#table_data').html('<tr><td colspan="18">Error fetching data</td></tr>');
        }
    });
}

function renderMisTable() {
    let groups = isSearching ? filteredMisGroups : misDataGroups;

    if (!groups || groups.length === 0) {
        $('#table_data').html(`<tr><td colspan="18" class="text-danger text-center">
            <div style="margin-top: 5px;">No matching records.</div>
        </td></tr>`);
        $('#pagination').html('');
        return;
    }

    const start = (currentPage - 1) * pageSize;
    const end = start + pageSize;
    const pageGroups = groups.slice(start, end);

    if (pageGroups.length === 0) {
        $('#table_data').html(`<tr><td colspan="18" class="text-danger text-center">
            <div style="margin-top: 5px;">No matching record.</div>
        </td></tr>`);
        renderPaginationControls();
        return;
    }

    // Group by area_name
    const areaMap = {};
    pageGroups.forEach(group => {
        const areaKey = group.area_name;
        if (!areaMap[areaKey]) {
            areaMap[areaKey] = [];
        }
        areaMap[areaKey].push(group);
    });

    let html = '';
    let serial = start + 1;

    Object.keys(areaMap).forEach(areaName => {
        const areaGroups = areaMap[areaName];
        const totalRowsInArea = areaGroups.reduce((sum, g) => sum + g.records.length, 0);

        let areaRowRendered = false;

        areaGroups.forEach(group => {
            const wellRowspan = group.records.length;

            group.records.forEach((v, i) => {
                html += `<tr>`;

                // SL No and Area only once per area group
                if (!areaRowRendered) {
                    html += `<td rowspan="${totalRowsInArea}" style="text-align:center; vertical-align:middle;">${serial++}</td>`;
                    html += `<td rowspan="${totalRowsInArea}" style="text-align:center; vertical-align:middle;">${areaName ?? '-'}</td>`;
                    areaRowRendered = true;
                }

                if (i === 0) {
                    html += `<td rowspan="${wellRowspan}" style="text-align:center; vertical-align:middle;">${group.well_site_name ?? '-'}</td>`;
                    html += `<td rowspan="${wellRowspan}" style="text-align:center;">
                        <a ${v.well_geo_name ? `data-toggle="tooltip" title="Geo Well - ${v.well_geo_name}"` : ''}>
                            ${v.well_name ?? '-'}
                            ${v.well_geo_name ? `<br>(${v.well_geo_name})` : ''}
                        </a>
                        </td>`;

                        html += `
                        <td rowspan="${wellRowspan}" style="text-align:center; vertical-align:middle;">
                            ${group.device_name ?? '-'} 
                            <br>
                            ${v.imei_no ? `( ${v.imei_no} )` : ''}
                        </td>`;
                }

                html += `<td>${v.node_name ?? '-'}</td>`;
                html += `<td>${v.tag_number ?? '-'}</td>`;
                html += `<td>${v.max_value ?? '0'}</td>`;
                html += `<td>${v.upper_value ?? '0'}</td>`;
                html += `<td>${v.lower_value ?? '0'}</td>`;
                 html += `<td>${v.multiplier ?? '0'}</td>`;
                html += `<td>${v.offset ?? '0'}</td>`;
               
                html += `<td>${v.threshold_setup_date_time ? moment(v.threshold_setup_date_time).format('DD-MM-YYYY h:mm:ss a') : '-'}</td>`;

                html += `</tr>`;
            });
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
            renderMisTable();
        });
        container.appendChild(btn);
    }
}

const columnMap = {
  0: null, // Sl No. no sorting
  1: 'area_name',
  2: 'well_site_name',
  3: 'well_name',
  4: 'node_name',
  5: 'tag_no',
  6: 'max_value',
  7: 'upper_value',
  8: 'lower_value',
  9: 'multiplier',
  10: 'offset',
  11: 'threshold_setup_date_time',
  12: 'device_name',
};

function sortMIS(columnIndex) {
    if (columnIndex === currentSortIndex) {
        sortDirection *= -1; // toggle asc/desc
    } else {
        currentSortIndex = columnIndex;
        sortDirection = 1;
    }

    const prop = columnMap[columnIndex];
    if (!prop) return; // no sort for this column

    const groups = isSearching ? filteredMisGroups : misDataGroups;

    groups.forEach(group => {
        group.records.sort((a, b) => {
            let valA = a[prop];
            let valB = b[prop];

            if (valA == null) valA = '';
            if (valB == null) valB = '';

            if (!isNaN(valA) && !isNaN(valB)) {
                return (Number(valA) - Number(valB)) * sortDirection;
            }

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

   async function exportThresholdReportToExcel() {
    const table = document.getElementById("data-table");
    if (!table) {
        alert("No table found.");
        return;
    }

    // Get date range text or input values
    let fromDateRaw = document.getElementById("show_from_date")?.innerText || document.getElementById("from_date")?.value || '';
    let toDateRaw = document.getElementById("show_to_date")?.innerText || document.getElementById("to_date")?.value || '';

    // Format dates using moment.js (ensure moment.js is loaded on page)
    const fromDate = fromDateRaw ? moment(fromDateRaw, ['YYYY-MM-DD', 'DD-MM-YYYY']).format('DD-MM-YYYY') : '-';
    const toDate = toDateRaw ? moment(toDateRaw, ['YYYY-MM-DD', 'DD-MM-YYYY']).format('DD-MM-YYYY') : '-';

    const workbook = new ExcelJS.Workbook();
    const sheet = workbook.addWorksheet('Configuration Report');

    const spanMap = {};  // Track merged cells
    let maxColCount = 0;
    const allRows = [];

    // Parse the HTML table rows and handle colspan/rowspan
    for (let r = 0; r < table.rows.length; r++) {
        const row = table.rows[r];
        const excelRow = [];
        let colIndex = 0;

        while (excelRow[colIndex] !== undefined) colIndex++;

        for (let c = 0; c < row.cells.length; c++) {
            const cell = row.cells[c];
            let cellValue = cell.innerText
                .replace(/[\u2190-\u21FF\u25B2\u25BC]/g, '')  // Remove arrows
                .replace(/\n+/g, ' ')
                .replace(/\s+/g, ' ')
                .trim();

            // Skip columns covered by rowspan/colspan from previous rows
            while (spanMap[`${r}:${colIndex}`] !== undefined) {
                excelRow[colIndex] = spanMap[`${r}:${colIndex}`];
                colIndex++;
            }

            const colspan = parseInt(cell.getAttribute("colspan") || "1");
            const rowspan = parseInt(cell.getAttribute("rowspan") || "1");

            // Mark cells covered by rowspan/colspan for skipping later
            if (rowspan > 1) {
                for (let i = 1; i < rowspan; i++) {
                    for (let j = 0; j < colspan; j++) {
                        spanMap[`${r + i}:${colIndex + j}`] = '';
                    }
                }
            }

            excelRow[colIndex] = cellValue;
            colIndex += colspan;
        }
        maxColCount = Math.max(maxColCount, excelRow.length);
        allRows.push(excelRow);
    }

    // Add Title Rows
    sheet.addRow([]);
    sheet.addRow([]);

    // Title Row 1
    sheet.getCell('A1').value = 'IOT BASED REAL TIME WELL MONITORING SYSTEM ONGC,CAMBAY ASSET';
    sheet.getRow(1).height = 30;
    sheet.getCell('A1').alignment = { horizontal: 'center', vertical: 'middle', wrapText: true };
    sheet.getCell('A1').font = { bold: true, size: 22, color: { argb: 'FFFFFF' } };
    sheet.getCell('A1').fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: '001A6E' } };
    sheet.mergeCells(1, 1, 1, maxColCount);

    // Title Row 2 with date range
    sheet.getCell('A2').value = `Configuration Report from ${fromDate} to ${toDate}`;
    sheet.getCell('A2').alignment = { horizontal: 'center', vertical: 'middle', wrapText: true };
    sheet.getCell('A2').font = { italic: true, size: 15, color: { argb: 'FFFFFF' } };
    sheet.getCell('A2').fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: '001A6E' } };
    sheet.mergeCells(2, 1, 2, maxColCount);

    // Add table rows from parsed HTML
    allRows.forEach(row => {
        while (row.length < maxColCount) row.push('');
        sheet.addRow(row);
    });

    // Merge vertically on SL No, Area, Location, Well columns (1-based)
    const mergeCols = [1, 2, 3, 4,5];
    const startRow = 3; // Because you have 2 title rows before data

    mergeCols.forEach(col => {
        let start = startRow;
        let prevVal = sheet.getCell(start, col).value;

        for (let i = start + 1; i <= sheet.rowCount + 1; i++) {
            const currentVal = i <= sheet.rowCount ? sheet.getCell(i, col).value : '__END__';

            const isBlankOrSame = currentVal === '' || currentVal === prevVal;
            const isLastRow = i === sheet.rowCount + 1;
            const isNextDifferent = !isBlankOrSame || isLastRow;

            if (isNextDifferent) {
                const endRow = i - 1;
                if (start < endRow) {
                    sheet.mergeCells(start, col, endRow, col);
                    const mergedCell = sheet.getCell(start, col);
                    mergedCell.alignment = { vertical: 'middle', horizontal: 'center', wrapText: true };
                }
                start = i;
                prevVal = currentVal;
            }
        }
    });

    // Style cells
    sheet.eachRow((row, rowNumber) => {
        row.eachCell(cell => {
            if (rowNumber === 1 || rowNumber === 2) {
                cell.fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: '001A6E' } };
                cell.font = { color: { argb: 'FFFFFF' }, bold: rowNumber === 1, italic: rowNumber === 2 };
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

    // Set column widths to 20 characters approx.
    sheet.columns.forEach(col => {
        col.width = 20;
    });

    // Export as Excel file
    const buffer = await workbook.xlsx.writeBuffer();
    const blob = new Blob([buffer], { type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" });
    const link = document.createElement("a");
    link.href = URL.createObjectURL(blob);
    link.download = "Configuration_Report.xlsx";
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}


</script>