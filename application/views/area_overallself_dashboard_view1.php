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
</style>

<div class="page-wrapper">
    <div class="content container-fluid pt-2">
    	<div class="page-header">
				<div class="row">
					<div class="col-sm-12">
						<h3 class="page-title">Overall</h3>
						<ul class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo base_url('Selfflow_c');?>">Dashboard</a></li>
							<li class="breadcrumb-item ">Overall</li>
							
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
                        <h4 class="header-title mb-0">Overall List</h4>
                    </div>
                    <div class="col-auto ms-auto">
                        <a href="<?php echo base_url('Selfflow_c'); ?>">
                            <button type="button" class="btn btn-sm btn-info">Back</button>
                        </a>
                        <button class="btn btn-success btn-sm mx-2" onclick="export_report()" style="font-size: 14px;">Export</button>
                    </div>
                </div>

                <!-- Table controls row -->
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

                <!-- Table -->
                <div class="table-responsive" style="max-height: 500px; overflow-y: auto; overflow-x: auto;">
                    <table class="table table-bordered table-hover m-0" id="data-table">
                        <thead>
                            <tr>
                                <th class="sortable" data-index="0" onclick="sortMIS(0)">S.No <span class="arrow"><span class="up">▲</span><span class="down">▼</span></span></th>
                                <th class="sortable" data-index="1" onclick="sortMIS(1)">Area <span class="arrow"><span class="up">▲</span><span class="down">▼</span></span></th>
                                <th class="sortable" data-index="4" onclick="sortMIS(4)">Well <span class="arrow"><span class="up">▲</span><span class="down">▼</span></span></th>
                                <th class="sortable" data-index="5" onclick="sortMIS(5)">Well Status <span class="arrow"><span class="up">▲</span><span class="down">▼</span></span></th>
                                <th class="sortable" data-index="6" onclick="sortMIS(6)">Installation Date <span class="arrow"><span class="up">▲</span><span class="down">▼</span></span></th>
                                <th class="sortable" data-index="7" onclick="sortMIS(7)">Last Updated Date Time <span class="arrow"><span class="up">▲</span><span class="down">▼</span></span></th>
                                <th class="sortable" data-index="8" onclick="sortMIS(8)">Imei No <span class="arrow"><span class="up">▲</span><span class="down">▼</span></span></th>
                                <th class="sortable" data-index="9" onclick="sortMIS(9)">THP (kgf/cm²)<span class="arrow"><span class="up">▲</span><span class="down">▼</span></span></th>
                                <th class="sortable" data-index="10" onclick="sortMIS(10)">CHP (kgf/cm²)<span class="arrow"><span class="up">▲</span><span class="down">▼</span></span></th>
                                <th class="sortable" data-index="11" onclick="sortMIS(11)">ABP (kgf/cm²)<span class="arrow"><span class="up">▲</span><span class="down">▼</span></span></th>
                                <th class="sortable" data-index="13" onclick="sortMIS(13)">FLT (°C)<span class="arrow"><span class="up">▲</span><span class="down">▼</span></span></th>
                                <th class="sortable" data-index="15" onclick="sortMIS(15)">Battery (v)<span class="arrow"><span class="up">▲</span><span class="down">▼</span></span></th>
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


<script src="<?php echo base_url(); ?>assets/local/excel/xlsx.full.min.js"></script>
<script type="text/javascript">
	
	function export_report() {
	  var sheetName = "Sheet1";
	  var fileName = "Total Well List.xlsx";
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
        url: base_url + 'Overall_list_selfflow_c/wellCount_details_ajax',
        method: 'POST',
        data: { well_id, site_id, area_id },
        success: function (res) {
            const response = JSON.parse(res);
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
                        <div><img src="${link_url}assets/images/no_records.svg" width="100" alt="No Records"></div>
                        <div style="margin-top: 5px;">No records Found.</div>
                    </td></tr>
                `);
            }
        },
        error: function () {
            $('#table_data').html(`
                <tr><td colspan="12" class="text-danger text-center">
                    <div><img src="${link_url}assets/images/no_records.svg" width="100" alt="No Records"></div>
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
                <div><img src="${link_url}assets/img/no_records.svg" width="100" alt="No Records"></div>
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
            const lastUpdatedTime = v.last_Log_Date_Time ? moment(v.last_Log_Date_Time).format('DD-MM-YYYY h:mm:ss a') : "NA";
            const installDate = v.date_of_installation ? moment(v.date_of_installation).format('DD-MM-YYYY h:mm:ss a') : "NA";
            const link = `${link_url}Main_dashboard/SingleWell_Dashboard/${v.well_id}/${v.site_id}/${v.area_id}/${v.well_type}`;
            const statusColor = {
                Flowing: '#28a745',
                Offline: '#dc3545',
                'Non-Flowing': '#ECA869',
                battery_issue: '#82A0D8'
            }[v.status_variable] || '#6c757d';

            html += `<tr>`;

            if (!areaRendered) {
                html += `<td rowspan="${records.length}" style="text-align:center; vertical-align:middle;">${serial++}</td>`;
                html += `<td rowspan="${records.length}" style="text-align:center; vertical-align:middle;">${group.area_name}</td>`;
                areaRendered = true;
            }

            html += `<td style="text-align:center;">
                        <a style="color: green;" href="${link}" 
                            ${v.well_geo_name ? `data-toggle="tooltip" title="Geo Well - ${v.well_geo_name}"` : ''}>
                            ${v.well_name ?? '-'}
                            ${v.well_geo_name ? `<br>(${v.well_geo_name})` : '' }
                        </a>
                    </td>`;

            html += `<td style="text-align:center;" class="well-status-cell" data-status="${v.status_variable}">
                        <span class="badge d-inline-block" style="width: 18px; height: 18px; background-color: ${statusColor}; border-radius: 50%;" title="${v.status_variable}"></span>
                    </td>`;

            html += `<td style="text-align:center;">${installDate}</td>`;
            html += `<td style="text-align:center;">${lastUpdatedTime}</td>`;
            html += `<td style="text-align:center;">${v.imei_no ?? ''}</td>`;
            html += `<td style="text-align:center;">${v.FTHP ? parseFloat(v.FTHP).toFixed(2) : '0.00'}</td>`;
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
  3: 'status_variable',
  4: 'date_of_installation',
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
