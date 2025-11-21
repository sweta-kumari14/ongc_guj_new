
<div class="page-wrapper">
<!-- Page Content -->
    <div class="content container-fluid">
            <div class="row row-sm">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body" >
                        <div class="row">
                            <div class="col-md-6">
                                <h3><b>Device Configration Log</b></h3>
                            </div>
                            <div class="col-md-6 d-md-flex justify-content-end">
                                <div>

                                    <button onclick="exportExcel();" class="btn btn btn-sm btn-success me-2"><i class="fa-solid fa-file-excel"></i> Export</button>
                                    
                                     <a href="<?php echo base_url('Device_configration_setup_c'); ?>" class="btn btn-sm btn-warning  text-white">
                                      <i class="fas fa-arrow-left me-1" style="font-size: 12px;"></i> Back
                                    </a>
                                </div>
                            </div>
                        </div>
                        </div>
                        <hr style="margin: 0rem 0 !important;">
                    <div class="card-body">                    
                       
                        <div class="row">
                            <div class="form-group col-md-4" >
                                <label class="form-label">Device Name<sup class="text-danger">*</sup></label>
                                <select name="imei_no" id="imei_no" class="form-control select2" 
                                 onchange="fetch_well_list();" required>
                                 <option value=""> All  </option>
                                        <?php 
                                        if (!empty($device_list))
                                        {
                                            foreach ($device_list as $key => $value)
                                            {
                                                ?>
                                                    <option value="<?php echo $value['imei_no']; ?>"><?php echo $value['device_name'] .'|'. $value['imei_no'] ; ?></option>

                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                            </div>
                            <div class="form-group col-md-4">
                               <label class="form-label">From Date</label>
                                    <input type="date" name="from_date" id="from_date" class="form-control" onchange="fetch_well_list();">
                            </div>

                            <div class="form-group col-md-4">
                                <label class="form-label">To Date</label>
                                <input type="date" name="to_date" id="to_date" class="form-control" onchange="fetch_well_list();">
                            </div>
                        </div>
                      
                        <div class="table-responsive mt-3">
                          <table class="table table-bordered table-sm">
                              <thead class="table-light">
                                  <tr class="text-center">
                                      <th>S.No</th>
                                      <th>Device/Imei No</th>
                                      <th>Topic</th>
                                      <th>Publish Date Time</th>
                                      <th>Publish By</th>
                                      <th>Command Value</th>
                                      
                                      
                                  </tr>
                              </thead>
                              <tbody  id="well_table_body"></tbody>
                          </table>
                      </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="previewModal">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header" style="background: linear-gradient(to right, #032448 20%, #fc6075 100%);">
        <h5 class="modal-title" style="color:white;">Command Preview</h5>
        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body" id="previewContent">
        Loading...
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
   fetch_well_list();

function fetch_well_list() {
    let imei_no = $('#imei_no').val();
    let from_date = $('#from_date').val();
    let to_date = $('#to_date').val();

    $("#well_table_body").html("");

    $.ajax({
        url: "<?php echo base_url('Device_configration_setup_c/device_config_ajax'); ?>",
        type: "POST",
        data: { imei_no: imei_no, from_date: from_date, to_date: to_date },
        dataType: "json",
        success: function (res) {

            if (res.status && res.data.length > 0) {

                let grouped = groupBy(res.data, "imei_no");
                let html = "";
                let sno = 1; // ⭐ Continuous S.No.

                Object.keys(grouped).forEach((imei) => {

                    let rows = grouped[imei];
                    let rowspan = rows.length;

                    rows.forEach((row, i) => {

                        html += `<tr>`;

                        if (i === 0) {
                            html += `
                                <td rowspan="${rowspan}" 
                                    style="vertical-align: middle; font-weight:bold;">
                                    ${sno++}
                                </td>

                                <td rowspan="${rowspan}" 
                                    style="vertical-align: middle; font-weight:bold;">
                                    ${imei}(${row.device_name})
                                </td>
                            `;
                        }

                        html += `
                            <td>${row.topic}</td>
                            <td>${moment(row.publish_date_time).format("DD-MM-YYYY hh:mm:ss A")}</td>
                            <td>${row.user_full_name} (${row.unique_userId})</td>

                            <td>
                                <a href="javascript:void(0)" 
                                   class="text-primary viewPreview"
                                   data-json='${row.command_value}'>
                                   <i class="fa fa-eye"></i>
                                </a> ${row.command_value}
                            </td>
                        `;

                        html += `</tr>`;
                    });

                });

                $("#well_table_body").html(html);

            } else {
                $("#well_table_body").html('<tr><td colspan="6" class="text-center text-danger">No Record Found!</td></tr>');
            }
        },
        error: function () {
            alert("Error fetching data!");
        }
    });
}


// ⭐ GROUP-BY FUNCTION
function groupBy(arr, key) {
    return arr.reduce((acc, item) => {
        (acc[item[key]] = acc[item[key]] || []).push(item);
        return acc;
    }, {});
}

$(document).on("click", ".viewPreview", function () {

    let raw = $(this).attr("data-json");

    try {
        let data = JSON.parse(raw);
        let jsonPreview = `{
    "sVal": "${data.sVal}",
    "nw": "${data.nw}",
    "wd": [
`;

        data.wd.forEach((well, wi) => {

            jsonPreview += `        {
            "wn": "${well.wn}",
            "nn": "${well.nn}",
            "ndata": [
`;

            // ⭐ ONE-LINE OBJECTS INSIDE ndata ARRAY
            well.ndata.forEach((nd, ni) => {
                jsonPreview += `               ${JSON.stringify(nd)}${ni < well.ndata.length - 1 ? "," : ""}\n`;
            });

            jsonPreview += `            ]
        }${wi < data.wd.length - 1 ? "," : ""}
`;
        });

        jsonPreview += `    ]
}`;

        // ---------------------------------------------------------
        // ⭐ JSON Preview Output Block
        // ---------------------------------------------------------

        let rawJson = `
            <h4>JSON Preview</h4>
            <pre style="background:#f4f4f4;padding:15px;border-radius:5px;white-space: pre-wrap;height:300px;overflow-x:auto;">
${jsonPreview}
            </pre>
        `;

        let sValParts = data.sVal.split(",");
        let dt = sValParts[0] + " " + sValParts[1];
        let formattedDT = moment(dt).format("DD-MM-YYYY HH:mm:ss A");

       let html = `
            <hr>
            <div style="height:500px;overflow-x:auto;">
            <h4>Tabular Format</h4>
            <div class="row">
                <div class="col-md-6">
                    <h5><b>sVal</b> ${formattedDT}, ${sValParts[2]}, ${sValParts[3]}, ${sValParts[4]}</h5>
                </div>
                <div class="col-md-6">
                    <h5><b>No of wells </b> ${data.nw}</h5>
                </div>
            </div>

            <hr>
        `;

        data.wd.forEach((well, i) => {
            html += `
                <h5>Well  ${well.wn}</h5>
                <p><b>Node No </b> ${well.nn}</p>
               
                   <table class="table table-bordered mb-0">
                    <tr>
                        <th>Tag Number (nm)</th>
                        <th> Component (vnm)</th>
                        <th>Max Value (vmx)</th>
                        <th>Upper Value (vu)</th>
                        <th>Lower Value (vl)</th>
                        <th>Multiplier (mul)</th>
                        <th>Offset (ofs)</th>
                    </tr>
            `;

            well.ndata.forEach(n => {
                html += `
                    <tr>
                        <td>${n.nm}</td>
                        <td>${n.vnm}</td>
                        <td>${n.vmx}</td>
                        <td>${n.vu}</td>
                        <td>${n.vl}</td>
                        <td>${n.mul}</td>
                        <td>${n.ofs}</td>
                    </tr>
                `;
            });

            html += "</table><hr>";
        });

        html += "</div>";

        // ---------------------------------------------------------
        // ⭐ SHOW MODAL
        // ---------------------------------------------------------

        $("#previewContent").html(rawJson + html);
        $("#previewModal").modal("show");

    } catch (e) {
        $("#previewContent").html("<p class='text-danger'>Invalid JSON</p>");
        $("#previewModal").modal("show");
    }
});

</script>
<script src="https://cdn.jsdelivr.net/npm/exceljs@4.3.0/dist/exceljs.min.js"></script>
<script type="text/javascript">
    async function exportExcel() {

    let imei_no = $('#imei_no').val();
    let from_date = $('#from_date').val();
    let to_date = $('#to_date').val();

    let res = await $.post("<?php echo base_url('Device_configration_setup_c/device_config_ajax'); ?>", 
        { imei_no, from_date, to_date },
        null,
        "json"
    );

    if (!res.status || res.data.length === 0) {
        alert("No data to export!");
        return;
    }

    // Group by IMEI
    let grouped = groupBy(res.data, "imei_no");

    // Create Excel workbook
    const workbook = new ExcelJS.Workbook();
    const sheet = workbook.addWorksheet("Config Report");

    // Header Row
    sheet.addRow(["S.No", "IMEI No", "Topic", "Publish Date", "User", "Command Value"]);

    let header = sheet.getRow(1);
    header.font = { bold: true };
    header.alignment = { horizontal: "center" };
    header.eachCell(cell => {
        cell.fill = {
            type: "pattern",
            pattern: "solid",
            fgColor: { argb: "FFE5E5E5" }
        };
    });

    let sno = 1;
    let excelRow = 2;

    Object.keys(grouped).forEach(imei => {

        let rows = grouped[imei];
        let rowspan = rows.length;

        rows.forEach((row, index) => {

            sheet.addRow([
                index === 0 ? sno : "",       // S.No only once
                index === 0 ? imei : "",      // IMEI only once
                row.topic,
                moment(row.publish_date_time).format("DD-MM-YYYY hh:mm:ss A"),
                `${row.user_full_name} (${row.unique_userId})`,
                row.command_value
            ]);

            excelRow++;
        });

        // ⭐ Merge S.No and IMEI Rows (Rowspan in Excel)
        let startRow = excelRow - rowspan;

        sheet.mergeCells(`A${startRow}:A${excelRow - 1}`);
        sheet.mergeCells(`B${startRow}:B${excelRow - 1}`);

        // Center align
        sheet.getCell(`A${startRow}`).alignment = { vertical: "middle", horizontal: "center" };
        sheet.getCell(`B${startRow}`).alignment = { vertical: "middle", horizontal: "center" };

        sno++;
    });

    // Auto column width
    sheet.columns.forEach(col => {
        col.width = 25;
    });

    // Download file
    const buffer = await workbook.xlsx.writeBuffer();

    let blob = new Blob([buffer], { type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" });
    let link = document.createElement("a");
    link.href = URL.createObjectURL(blob);
    link.download = "Device_Config_Report.xlsx";
    link.click();
}
</script>


      