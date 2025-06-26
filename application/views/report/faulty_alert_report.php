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
                            <h4 class="mb-1">Faulty Alert Report</h4>
                        </div>
                        <div class="col-auto ms-auto d-flex gap-2">
                            <button type="button" id="export_btns" onclick="export_report()" class="btn btn-sm btn-primary motion-btn">
                                <i class="fas fa-file-export me-1" style="font-size: 12px;"></i> Export</button>
                        </div>
                    </div>
                </div>
                <div class="row m-4">
                    
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
                   <div class="col-md-3">
    <label class="form-label">Alert Type</label>
    <select name="alert_type" id="alert_type" class="form-control select2" style="width: 100%;">
        <option value="">Select Alert Type</option>
        <option value="low_chp">Low CHP</option>
        <option value="high_chp">High CHP</option>
        <option value="low_thp">Low THP</option>
        <option value="high_thp">High THP</option>
        <option value="low_abp">Low ABP</option>
        <option value="high_abp">High ABP</option>
        <option value="temp_flt">Temp FLT</option>
    </select>
</div>


                        
                    <div class="col-md-3">
                        <label class="form-label">From Date</label>
                        <input type="date" name="from_date" id="from_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" onchange="get_downtime_report();get_installation_date();">
                    </div>
                    <div class="col-md-3">
                         <label class="form-label">To Date</label>
                        <input type="date" name="to_date" id="to_date" class="form-control" value="<?php echo date('Y-m-d'); ?>"  onchange="get_downtime_report();get_installation_date();">
                    </div>
                
                </div>

                <div class="card-body mt-1">
                    <div class="table-responsive">
                        <table class="table datatable border 0" id="downtimeData">
                            <thead class="table-secondary text-center">
                                <tr style="border-bottom: 1px solid #C5D3E8;">
                                    <th colspan="7" class="text-uppercase text-center" style="font-size: 20px; font-weight: bolder; color: #35404a;">
                                        IOT Based Real Time Well Monitoring System – ONGC, Cambay Asset
                                    </th>
                                </tr>
                                <tr style="border-bottom: 1px solid #C5D3E8;">
                                    <th colspan="7" class="text-uppercase text-center" id="downtime-report-heading" style="font-size: 15px; font-weight: bolder; color: #35404a;">
                                        Faulty Alert Report as on
                                    </th>
                                </tr>
                                <tr>
                                    <th style="width:10%;">Sl No.</th>
                                    <th>Well Name</th>
                                    <th>Well Type</th>
                                    <th>Alert Descrption</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Status</th>
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