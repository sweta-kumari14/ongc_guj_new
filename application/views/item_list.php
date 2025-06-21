<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>

<style type="text/css">
    table thead tr th{
        background-color: #adefd169 !important;
    }
    .top-card-header{
        position: relative;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        padding-bottom: 8px;
    }
    .edit_btn{
        color: blue;
        font-size: 17px;
    }
    .delete_btn{
        color: #ff0000b5;
        font-size: 17px;
    }
    .add-btn-icon{
        color: #4a5a6bb0;
    }
    .add-btn-icon i{
        font-size: 2.1rem;
    }
    .form-btns{
        text-align: right;
        margin-top: 10px;
    }
    .butons{
        font-size: 18px;
        padding: 2px 10px;
    }
    .dlt-head{
        text-align: center;
        padding: 10px 15px;
    }
    .text-para{
        font-size: 15px;
        font-weight: 500;
        margin-bottom: 1px;
    }

    #add_btns{
        font-size: 16px;
        padding: 3px 13px;
    }
    #add_btns i{
        margin-right: -20px;
        position: relative;
        opacity: 0; 
        transition: all 0.5s ease-out;
    }
    #add_btns:hover i{
        opacity: 1; 
        margin-right: 2px;
    }
    #add_btns_list{
        font-size: 16px;
        padding: 3px 13px;
    }
    #add_btns_list i{
        margin-right: -20px;
        position: relative;
        opacity: 0; 
        transition: all 0.5s ease-out;
    }
    #add_btns_list:hover i{
        opacity: 1; 
        margin-right: 2px;
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
</style>
<div class="page-wrapper">
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold" style="margin-left:34px;">Dashboard</h4>
        </div>
        <div class="text-end" style="margin-right:35px">
            <ol class="breadcrumb m-0 py-0">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Masters</a></li>
                <li class="breadcrumb-item active">Component</li>
            </ol>
        </div>
    </div>

    <!-- Datatables -->
    <div class="row" style="    margin-top: -1px;">
        <div class="col-12" style="width: 97%;">
            <div class="card" style="margin-left: 29px;">
                <div class="card-header top-card-header" style="padding: 10px; background-color: #ede4d1;">
                    <h5 class="card-title mb-0 fs-18"><span>Component List</span></h5>
                    <div class="add-btns">
                        <a type="button" id="add_btns" onclick="showHideFormList('add')" class="btn btn-outline-primary button">
                            <i class="fa-solid fa-square-plus"></i> Add</a>
                        <button type="button" id="export_btns" onclick="export_report();showHideFormList('list')" class="btn btn-outline-dark button">
                            <i class="fa-solid fa-file-excel"></i> Export</button>
                        <a type="button" id="add_btns_list" onclick="showHideFormList('list')" class="btn btn-outline-info button" style="display:none;">
                            <i class="fa-solid fa-list"></i> List</a>
                    </div>
                </div><!-- end card header -->

                <div class="card-body" id="items_table_div">
                    <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Component Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="items_list"></tbody>
                    </table>
                </div>

                <div class="card-body" id="add_items_div" style="display: none;">
                    <div class="form-container">
                        <div class="col-xl-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Component Name</strong></label>
                                        <input type="text" name="item_name" id="item_name" class="form-control" required placeholder="Enter item name">
                                    </div>
                                </div>
                            </div>
                            <div class="form-btns pt-2">
                                <button type="button" onclick="handleFormSubmit()" class="btn btn-success">
                                    <span id="submit_update"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header dlt-head" style="justify-content: center;background: #f3f3f3;font-weight: 600;">
                    <h5 class="modal-title text-center" id="mySmallModalLabel">Confirmation</h5>
                </div>
                <div class="modal-body text-center">
                    <p class="text-para">Are you sure you want to delete this item?</p>
                </div>
                <div class="modal-footer" style="justify-content: center;">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">No</button>
                    <button type="button" onclick="confirmDelete()" class="btn btn-primary">Yes</button>
                </div>
            </div>
        </div>
    </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script type="text/javascript">
        let submitUpdateBtn = null;
        let submitAction = "create";
        let itemsUpdateId = null;
        let setItemsDltId = null;

        const showHideFormList = (divType) => {
            if (divType == 'add') {
                $("#heading_title").html(`Item Details`);
                $("#item_name").val(``);
                $("#submit_update").html(`Submit`);
                $("#add_items_div").show();
                $("#items_table_div").hide();
                $(".btn-outline-info").show();
                $(".btn-outline-primary").hide();
                $("#export_btns").hide();
            }
            if (divType == 'list') {
                $("#heading_title").html(`Item List`);
                $("#add_items_div").hide();
                $("#items_table_div").show();
                $(".btn-outline-info").hide();
                $(".btn-outline-primary").show();
                $("#export_btns").show();
            }
        }

        const getItemsList = () => {
            showHideFormList('list');
            $("#items_list").html(`<tr><td colspan="3"> Please wait........!</td></tr>`);
            $.ajax({
                url: '<?php echo base_url() ?>Item_master_c/items_list_data',
                type: 'post',
                data: {},
                success: (res) => {
                    resp = JSON.parse(res);
                    if (resp.response_code == 200 && resp.data.length > 0) {
                        $("#items_list").html(``);
                        $.each(resp.data, (i, v) => {
                            $("#items_list").append(`<tr>
                                <td>${i + 1}</td>
                                <td>${v.item_name}</td>
                                <td>
                                    <a onclick="setEditItems('${v.id}')" class="edit_btn" href="javascript:;">
                                        <i class="fas fa-pencil-alt" style="color: green;"></i>
                                    </a>
                                    <a onclick="setItemsDeleteId('${v.id}')" class="delete_btn" href="javascript:;" data-bs-toggle="modal" data-bs-target=".bs-example-modal-sm">
                                        <i class="fas fa-trash" style="color:#A93226;"></i>
                                    </a>
                                </td>
                            </tr>`);
                        });
                    }
                }
            });
        }

        const createItems = () => {
            if (!/^[a-zA-Z\s]+$/.test($('#item_name').val())) {
                toastr.error("Please enter valid item name!");
                return false;
            }
            $.ajax({
                url: '<?php echo base_url() ?>Item_master_c/add_item_name',
                type: 'POST',
                data: { item_name: $('#item_name').val() },
                success: (res) => {
                    resp = JSON.parse(res);
                    if (resp.response_code == 200) {
                        getItemsList();
                        showHideFormList('list');
                        toastr.success(resp.msg);
                    } else {
                        getItemsList();
                        showHideFormList('add');
                        toastr.error(resp.msg);
                    }
                }
            });
        }

        const setActionType = (action) => {
            submitAction = action;
        }

        const setEditItems = (item_id) => {
            showHideFormList('add');
            setActionType('update');
            $("#submit_update").html('Update');
            $.ajax({
                url: '<?php echo base_url() ?>Item_master_c/getitems_details',
                type: 'POST',
                data: { id: item_id },
                success: (res) => {
                    resp = JSON.parse(res);
                    if (resp.response_code == 200 && resp.data.length > 0) {
                        $('#item_name').val(resp.data[0]['item_name']);
                        itemsUpdateId = resp.data[0]['id'];
                    }
                }
            });
        }

        const updatePressureType = () => {
            if (!/^[a-zA-Z\s]+$/.test($('#item_name').val())) {
                toastr.error("Please enter valid item name!");
                return false;
            }
            $.ajax({
                url: '<?php echo base_url() ?>Item_master_c/update_item_data',
                type: 'POST',
                data: {
                    item_name: $('#item_name').val(),
                    id: itemsUpdateId,
                },
                success: (res) => {
                    resp = JSON.parse(res);
                    if (resp.response_code == 200) {
                        getItemsList();
                        showHideFormList('list');
                        toastr.success(resp.msg);
                    } else {
                        getItemsList();
                        toastr.error(resp.msg);
                    }
                }
            });
        }

        const setItemsDeleteId = (items_Id) => {
            setItemsDltId = items_Id;
        }

       const confirmDelete = () => {
    $(".bs-example-modal-sm").modal('hide');
    $.ajax({
        url: '<?php echo base_url() ?>Item_master_c/delete_item_data',
        type: 'POST',
        data: { id: setItemsDltId },
        success: (res) => {
            // res is already parsed, no need to do JSON.parse
            if (res.response_code == 200) {
                getItemsList();
                toastr.success(res.msg);
            } else {
                getItemsList();
                toastr.error(res.msg);
            }
        }
    });
}


        const handleFormSubmit = () => {
            if (submitAction === 'create') createItems();
            if (submitAction === 'update') updatePressureType();
        }

        getItemsList();
    </script>

    <script src="<?php echo base_url(); ?>assets/local/excel/xlsx.full.min.js"></script>
    <script type="text/javascript">
        function export_report() {
            var sheetName = "Sheet1";
            var fileName = "Item list.xlsx";
            var table = $("#datatable")[0];

            var ws = XLSX.utils.table_to_sheet(table);
            var wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, sheetName);
            XLSX.writeFile(wb, fileName);
        }
    </script>
</div>
