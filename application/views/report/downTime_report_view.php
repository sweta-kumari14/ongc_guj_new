<style>
    /* Active page style */
    .pagination .page-item.active .page-link {
        background-color: #927780;  /* Custom green-blue */
        border-color: #927780;
        color: white;
        font-weight: bold;
    }

    /* Normal page link style */
    .pagination .page-link {
        color: #927780;
        border-radius: 4px;
    }

    /* Hover effect */
    .pagination .page-link:hover {
        background-color: #d3f3ec;
        border-color: #927780;
        color: #927780;
    }

    /* Disabled state */
    .pagination .page-item.disabled .page-link {
        color: #ccc;
        background-color: #f8f9fa;
        pointer-events: none;
    }

    nav ul li{
        margin-left: 5px ;
        margin-right: 5px ;
    }
</style>
<div class="page-wrapper">
    <div class="content container-fluid pb-0" style="margin-top: -13px;">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header mb-0" style="padding: 10px;">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="mb-1">Downtime Report</h4>
                        </div>
                        <div class="col-auto ms-auto d-flex gap-2">
                            <button type="button" id="export_btns" onclick="export_report()" class="btn btn-sm btn-primary motion-btn">
                                <i class="fas fa-file-export me-1" style="font-size: 12px;"></i> Export</button>
                        </div>
                    </div>
                </div>
                <div class="row m-2">
                    
                    <div class="col-md-3">
                        <label class="form-label" >Well Name</label>
                        <select name="well_id" id="well_id" class="form-control select2" onchange="get_downtime_report();" style="width: 100%;">
                            <option value=""> Select Well </option>
                            <?php 
                            if (!empty($well_list))
                            {
                                foreach ($well_list as $key => $value)
                                {
                                    ?>
                                        <option value="<?php echo $value['well_id']; ?>"><?php echo $value['well_name']; ?></option>

                                    <?php
                                }
                            }

                            ?>   
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">From Date</label>
                        <input type="date" name="from_date" id="from_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" onchange="get_downtime_report();get_installation_date();">
                    </div>
                    <div class="col-md-2">
                         <label class="form-label">To Date</label>
                        <input type="date" name="to_date" id="to_date" class="form-control" value="<?php echo date('Y-m-d'); ?>"  onchange="get_downtime_report();get_installation_date();">
                    </div>
                
                </div>

                <div class="card-body mt-1">
                    <div class="table-responsive">
                        <table class="table datatable border 0" id="downtimeData">
                            <thead class="table-secondary text-center">
                                <tr style="border-bottom: 1px solid #C5D3E8;">
                                    <th colspan="9" class="text-uppercase text-center" style="font-size: 20px; font-weight: bolder; color: #35404a;">
                                        IOT Based Real Time Well Monitoring System – ONGC, Cambay Asset
                                    </th>
                                </tr>
                                <tr style="border-bottom: 1px solid #C5D3E8;">
                                    <th colspan="9" class="text-uppercase text-center" id="downtime-report-heading" style="font-size: 15px; font-weight: bolder; color: #35404a;">
                                        Well Downtime Report as on
                                    </th>
                                </tr>
                                <tr>
                                    <th style="width:10%;">Sl No.</th>
                                    <th>Well</th>
                                    <th>IMEI</th>
                                    <th>Downtime Start</th>
                                    <th>Downtime End</th>
                                    <th>Total Duration (min)</th>
                                    <th>Reason</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>

                            <tbody id="downtime_table_data" class="text-center">
                                <!-- Dynamic rows will be appended here -->
                            </tbody>
                        </table>
                    </div>   
                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-end">
                            <nav>
                                <ul class="pagination pagination-sm mb-0" id="pagination_controls"></ul>
                            </nav>
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

    let currentPage = 1;
    let limit = parseInt($('#limit_selector').val()) || 10;

    $(document).ready(function () {
        $('.select2').select2({
            minimumResultsForSearch: Infinity,
            width: 'resolve'
        });

        get_downtime_report(currentPage);
    });

    function changeLimit() {
        limit = parseInt($('#limit_selector').val()) || 10;
        currentPage = 1;
        get_downtime_report(currentPage);
    }

    function get_downtime_report(page = 1) {
        currentPage = page;

        $('#downtime_table_data').html('<tr><td colspan="9">Processing please wait.......</td></tr>');

        const well_id = $('#well_id').val();
        const from_date = $('#from_date').val();
        const to_date = $('#to_date').val();
        const selectedWellName = $('#well_id option:selected').text();

        const formattedFromDate = moment(from_date, 'YYYY-MM-DD').format('DD-MM-YYYY');
        const formattedToDate = moment(to_date, 'YYYY-MM-DD').format('DD-MM-YYYY');
        const headingText = `Well Downtime Report of ${selectedWellName} from ${formattedFromDate} to ${formattedToDate}`;
        $('#downtime-report-heading').text(headingText);

        $.ajax({
            url: '<?php echo base_url(); ?>reports/Downtime_report_c/getWell_downtime_report',
            method: 'POST',
            data: {
                well_id: well_id,
                from_date: from_date,
                to_date: to_date,
                limit: limit,
                offset: (page - 1) * limit,
            },
            success: function (res) {
                const response = JSON.parse(res);
                $('#downtime_table_data').html('');

                if (response.response_code === 200 && response.data && response.data.length > 0) {
                    response.data.forEach((v, i) => {
                        $('#downtime_table_data').append(`
                            <tr>
                                <td>${(i + 1) + ((currentPage - 1) * limit)}</td>
                                <td>${v.well_name ?? ''}</td>
                                <td>${v.imei_no ?? ''}</td>
                                <td>${v.downtime_start_time ? moment(v.downtime_start_time).format('DD-MM-YYYY h:mm:ss a') : 'NA'}</td>
                                <td>${v.downtime_end_time ? moment(v.downtime_end_time).format('DD-MM-YYYY h:mm:ss a') : 'NA'}</td>
                                <td>${v.total_duration_minutes != null ? v.total_duration_minutes : 'NA'}</td>
                                <td>${v.reason ?? 'NA'}</td>
                                <td>${v.remarks ?? 'NA'}</td>
                            </tr>
                        `);
                    });

                    renderPagination(response.total);
                } else {
                    $('#downtime_table_data').html(`
                        <tr>
                            <td colspan="9" class="text-center">
                                <div class="mt-3">
                                    <img src="<?php echo base_url(); ?>assets/images/no_records.svg" width="100">
                                    <p class="text-danger mt-2 fw-bold">No Record Found !!</p>
                                </div>
                            </td>
                        </tr>
                    `);
                    $('#pagination_controls').html('');
                }
            },
            error: function () {
                $('#downtime_table_data').html('<tr><td colspan="9">Something went wrong while fetching data.</td></tr>');
                $('#pagination_controls').html('');
            }
        });
    }

    function renderPagination(totalItems) {
        const totalPages = Math.ceil(totalItems / limit);
        let paginationHTML = '';

        // Previous button
        paginationHTML += `
            <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                <a class="page-link" href="javascript:void(0);" onclick="get_downtime_report(${currentPage - 1})" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
        `;

        // Page numbers
        for (let i = 1; i <= totalPages; i++) {
            paginationHTML += `
                <li class="page-item ${i === currentPage ? 'active' : ''}">
                    <a class="page-link" href="javascript:void(0);" onclick="get_downtime_report(${i})">${i}</a>
                </li>
            `;
        }

        // Next button
        paginationHTML += `
            <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                <a class="page-link" href="javascript:void(0);" onclick="get_downtime_report(${currentPage + 1})" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        `;

        $('#pagination_controls').html(paginationHTML);
    }


</script>

<script src="<?php echo base_url(); ?>assets/local/excel/xlsx.full.min.js"></script>
<script type="text/javascript">
    function export_report() {
        var sheetName = "Sheet1";
        var fileName = "Downtime report.xlsx";
        var table = document.getElementById("downtimeData");

        if (!table) {
            alert("Table not found!");
            return;
        }

        // Convert table to worksheet
        var ws = XLSX.utils.table_to_sheet(table);

        // Create a new workbook and add the worksheet to it
        var wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, sheetName);

        // Save the workbook as an Excel file and download it
        XLSX.writeFile(wb, fileName);
    }
</script>