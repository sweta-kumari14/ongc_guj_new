<div class="page-wrapper">
        <div class="content container-fluid">
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center" style="background-color: white;">
                <h5 class="card-title fs-18 mb-0">Well Setup List</h5>
                <div class="d-flex gap-2">
                    <a class="btn btn-warning btn-sm text-white" id="add_btns_list" href="<?php echo base_url('Well_setup_c'); ?>">
                        <i class="fas fa-plus me-1 text-white"></i> Add
                    </a>
                    <a class="btn btn-warning btn-sm text-white" id="back_btn" href="<?php echo base_url('Well_setup_c/cgl_well_setup_list');?>" style="display: none;">
                    <i class="fas fa-arrow-left me-1 text-white"></i> Back
                    </a>
                    <button type="button"  id="export_btns" onclick="export_report();" class="btn btn-success btn-sm">
                        <i class="fa-solid fa-file-excel me-1"></i> Export
                    </button>
                </div>
            </div>

             <div class="filter-section" style="padding: 10px 24px;" id="cgl_table_list_div">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="example-select" class="form-label">Well Type</label>
                                    <select onchange="get_wellwise_report();" class="form-select select2" name="well_type" id="well_type">
                                        <option value="">select</option>
                                        <?php
                                            foreach ($well_type_list as $key => $asset) {
                                                ?>
                                                <option value="<?php echo $asset['id'] ?>"><?php echo $asset['well_type_name'] ?></option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap text-center">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Well Type</th>
                                            <th>Component Name</th>
                                            <th>Quantity</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id ="table_data">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="card-body" id="edit_cgl_data_div" style="display: none;padding: 10px 24px;">
                <div class="cgl-detail-section">
                        <div class="content-section">
                            <div class="col-xl-12">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label> <strong>Well Type</strong> </label>
                                            <input type="text" class="form-control" name="welltype" id="welltype" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label> <strong>Component Name</strong> </label>
                                            <input type="text" class="form-control" name="items" id="items" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label> <strong>Quatity</strong> </label>
                                            <input type="number" name="qty" id="qty" class="form-control" required>
                                        </div>
                                    </div> 
                                   </div>
                                     <hr>
                                    <div class="btns-sections text-end mt-2">
                                        <button type="button" onclick="updateCGL_setup_data()" class="btn btn-success btn-md"> Update </button>
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


<script type="text/javascript">

    const showHideFormList = (action)=>{
        if(action == "list"){
            $("#edit_cgl_data_div").hide();
            $("#cgl_table_list_div").show();
            $("#add_btns_list").hide();
            $('#export_btns').show();
            $('#back_btn').hide();
        }else{
            $("#edit_cgl_data_div").show();
            $("#cgl_table_list_div").hide();
            $("#add_btns_list").hide();
            $('#export_btns').hide();
            $('#back_btn').show();
        }
    }

    let cglUpdateId = null;

    const getCGLSetupDetails = (id) => {
        $.ajax({
            url: '<?php echo base_url() ?>Well_setup_c/edit_cgl_setup',
            type: 'POST',
            data: {
                id: id,
            },
            success: (res) => {
                let resp = JSON.parse(res);
                console.log(resp,'nfgfdj');
                if (resp.response_code == 200) {
                    if (resp.data.length > 0) {
                        
                        $("#welltype").val(resp.data[0]['well_type_name']);
                        $("#items").val(resp.data[0]['component_name']);
                        $("#qty").val(resp.data[0]['quantity_required']);
                        cglUpdateId = resp.data[0]['id'];
                    
                    }
                }
            }
        });
    };

    const updateCGL_setup_data = ()=>
    {
        if($("#qty").val() == ""){
            toastr.error("Enter quatity!");
            return false;
        }
        else{
            $.ajax({
                url: '<?php echo base_url() ?>Well_setup_c/update_cgl_setup',
                type: 'POST',
                data: {
                    id: cglUpdateId,
                    qty: $("#qty").val(),
                },
                success:(res)=>{
                    let resp = JSON.parse(res);
                    if(resp.response_code == 200){
                        swal('success',resp.msg,'success');
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000); 
                    }else{
                       
                        swal('warning',resp.msg,'warning');
                    }
                }
            });
        }
    }
  get_wellwise_report();
    function get_wellwise_report() {
    $('#table_data').html('<tr><td colspan="7">processing please wait.......</td></tr>');
    var well_type = $('#well_type').val();
   
    $.ajax({
        url: '<?php echo base_url(); ?>Well_setup_c/well_setup_ajax',
        method: 'POST',
        data: { well_type:well_type},
        success: function (res) {
            var response = JSON.parse(res);
            console.log(response,'ddfdgfgffg');
            if (response.response_code == 200) {
                $('#table_data').html("");
                if (response.data.length > 0) {
                    
                    $.each(response.data, function (i, v) {
                    $("#table_data").append('<tr>' +
                        '<td>' + (i + 1) + '</td>' +
                        '<td>' + v.well_type_name + '</td>' +
                        '<td>' + v.component_name + '</td>' +
                        '<td>' + v.quantity_required + '</td>' +
                        '<td>' + 
                            '<a onclick="showHideFormList(); getCGLSetupDetails(this.id)" id="' + v.id + '" href="javascript:;" class="fs-16" style="color: blue;">' +
                            '<i class="fa-solid fa-pen-to-square"></i>' +
                            '</a>' +
                        '</td>' +
                        '</tr>');
                });
                   
                } else {
                    $('#table_data').html('<tr>' +
                        '<td class="text-danger" style="text-align:center;" colspan="7">No Record Found !!</td>' +
                        '</tr>');
                }
            }
        }

    });
}
</script>
<script src="<?php echo base_url(); ?>assets/local/excel/xlsx.full.min.js"></script>
<script type="text/javascript">
    
    function export_report() {
      var sheetName = "Sheet1";
      var fileName = "Well Formula List.xlsx";
      var table = $("#datatable")[0];

      // Convert table to worksheet
      var ws = XLSX.utils.table_to_sheet(table);

      // Create a new workbook and add the worksheet to it
      var wb = XLSX.utils.book_new();
      XLSX.utils.book_append_sheet(wb, ws, sheetName);

      // Save the workbook as an Excel file and download it
      XLSX.writeFile(wb, fileName);
    }

</script>
        