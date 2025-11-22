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
        background-color: #fff;
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
    }#processing_message {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
    width: 100%;
    text-align: center;
}
.loader-img {
    height: 200px;
    width: 100px;
}
#loader-container {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: rgba(0, 0, 0, 0.5);
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 9999;
}

.loader {
    border: 4px solid #f3f3f3;
    border-top: 4px solid #3498db;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    animation: spin 1s linear infinite;
}

#loader-message {
    color: white !important;
    font-size: 20px;
    font-weight: bold;
    margin-left: 18%;
    margin-top: 65px;
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
}

</style>
<div id="loader-container" style="display:none;">
    <div class="loader"></div>
    <div id="loader-message">Please Wait while</div>
</div>
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
                                   <a href="<?= base_url('Device_commissioning_c/commissioning_report_page'); ?>">
                                    <button type="button"
                                        class="btn btn-sm btn-success">
                                         Report
                                    </button>
                                </a>

                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-center">
                        <div class="col-12">
                        <form method="POST" action="" enctype="multipart/form-data" class="needs-validation" novalidate>
                        <div class="row">
                            <div class="col-md-4 mt-2">
                            <label class="form-group">Area Name<sup class="text-danger">*</sup></label>
                            <select name="area_id" id="area_id" class="form-control select2" style="width: 100%;" onchange="well_list_ajax();" required>
                                <option value=""> Select Area </option>
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
                            <label for="example-select" class="form-group">Commissioning Date <sup class="text-danger">*</sup></label>
                            <input type="date" name="commissioning_date" id="commissioning_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" onchange="get_installation_date();" required>
                        </div>
                        </div>
                        <hr>
                        <div class="table-responsive mt-3">
                          <table class="table table-bordered table-hover m-0" id="data-table">
                           <thead class="thead-dark">
                                  <tr class="text-center">
                                      <th>S.No</th>
                                      <th>
                                        <input type="checkbox" id="select_all" style="width:18px;height:18px;">
                                        
                                      </th>
                                      <th>Location </th>
                                      <th>Well</th>
                                      <th>Device</th>
                                      <th>Imei</th>
                                      <th>Installtion</th>
                                      
                                  </tr>
                              </thead>
                              <tbody class="text-center" id="well_table_body"></tbody>
                          </table>
                          <div class="text-end mt-3">
                            <button id="submit_btn" type="button" class="btn btn-sm btn-success" style="display:none;">
                                Submit
                            </button>
                         </div>
                      </div>
                    </form>
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
    var date = $('#commissioning_date').val();
    
    f_date = moment(date);
   
    if(f_date.isValid())
    {
        $('#show_date').text(f_date.format("DD-MM-YYYY"));
        $('#to').show();
    }else{
        $('#show_date').text('');
    }
}
well_list_ajax();
function well_list_ajax() {
    let area_id = $('#area_id').val();

    // alert(area_id);

    $.ajax({
        url: "<?php echo base_url(); ?>Device_commissioning_c/well_list_ajax",
        type: "POST",
        data: { area_id: area_id },
        success: (res) => {

            let resp = JSON.parse(res);
            console.log(resp, 'well_details');

            if (resp.response_code == 200) {

                if (resp.data.length > 0) {

                    let html = "";
                    let i = 1;

                    resp.data.forEach(row => {

                        html += `
                            <tr>
                                <td>${i++}</td>
                                <td>
                                    <input type="checkbox" 
                                        class="well_checkbox"
                                        value='${JSON.stringify(row)}'
                                        style="width:18px;height:18px;cursor:pointer;">
                                </td>
                                <td>${row.area_name} - ${row.well_site_name}</td>
                                <td>${row.well_name}</td>
                                <td>${row.device_name}</td>
                                <td>${row.imei_no}</td>
                                <td>${row.date_time}</td>
                            </tr>`;
                    });

                    $("#well_table_body").html(html);
                } 
                else {
                    $('#well_table_body').html(`
                        <tr>
                            <td colspan="7" class="text-center">
                                
                                <p class="text-danger mt-2 fw-bold">No Record Found !!</p>
                            </td>
                        </tr>
                    `);
                }
            }
        }
    });
}



$(document).on("change", "#select_all", function () {
    $(".well_checkbox").prop("checked", this.checked);
    toggleSubmitButton();
});

$(document).on("change", ".well_checkbox", function () {
    toggleSubmitButton();
});

function toggleSubmitButton() {
    let anyChecked = $(".well_checkbox:checked").length > 0;

    if (anyChecked) $("#submit_btn").show();
    else $("#submit_btn").hide();
}


$("#submit_btn").click(function () {

    let commissioning_date = $("#commissioning_date").val();
    let area_id = $("#area_id").val();

    if (commissioning_date == "") {
        swal("warning","Please select commissioning date","warning");
        return;
    }

    let commissioningData = [];

    $(".well_checkbox:checked").each(function () {
        let row = JSON.parse($(this).val());

        commissioningData.push({
            well_id: row.well_id,
            device_name: row.device_name,
            imei_no: row.imei_no,
            installation_date: row.date_time,
            site_id: row.site_id
        });
    });

    console.log("Final Data:", commissioningData);
    $('#loader-container').show();

    $.ajax({
        url: "<?php echo base_url(); ?>Device_commissioning_c/add_commissoning_data",
        type: "POST",
        data: {
            area_id: area_id,
            commissioning_date: commissioning_date,
            commissioningData: JSON.stringify(commissioningData)
        },
        success: function (res) {
           
            if (!res) {
                swal("error", "Empty response from server", "error");
                return;
            }

            let resp = JSON.parse(res);
            if (resp.response_code == 200) {
                 swal("Success", resp.msg, "success").then(() => {
                   window.location.href = "<?php echo base_url(); ?>Device_commissioning_c/commissioning_report_page";
                  });
            } else {
                swal("error", resp.msg, "error");
            }
        },
        error: function () {
            swal("error", "Something went wrong!", "error");
        },
        complete: function () {
            $('#loader-container').hide();
        }
    });

});
</script>
      