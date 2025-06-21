<style type="text/css">
    .select2-container--default .select2-selection--single{
        border: 1px solid #8299b557;
    }
    .select2-container .select2-selection--single{
        height: 38px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered{
        line-height: 35px;
    }
    .form-check-input,
    label{
        cursor: pointer;
    }
    .top-card-header{
        position: relative;
        display: flex;
        text-align: center;
        justify-content: space-between;
    }
    .setup-section{
        height: 350px;
        overflow-y: scroll;
        scroll-behavior: smooth;
        scrollbar-width: none;
        padding: 5px 25px;
    }
</style>
<div class="page-wrapper">
        <div class="content container-fluid">
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header top-card-header" style="padding:8px; background-color:#ede4d1">
                <h5 class="card-title fs-18" style="margin-top: 8px;">Well Setup Formula</h5>
                <a href="javascript:;" onclick="add_well_setup();" class="btn btn-dark addRow">
                    <i class="fa-solid fa-plus"></i>
                </a>
            </div>
            <div class="card-body">
                <div class="setup-section">
                    <form method="POST" action="<?php echo base_url() ?>Well_setup_c/store_well_formula_data">
                        <div class="well-setup-section">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Well Type</label>
                                    <select class="form-select select2" name="well_type_id" style="width:100%;" required>
                                        <option value="">-select-</option>
                                        <?php foreach ($well_type_list as $key => $well) { ?>
                                            <option value="<?php echo $well['id'] ?>"><?php echo $well['well_type_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div id="rowContainer">

                            </div>
                            <div class="pt-3 pb-3 text-center">
                                <button type="submit" class="btn btn-success rounded-pill">Submit</button>
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

<!-- jQuery (Toastr depends on this) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<!-- Select2 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet" />

<!-- jQuery (must be loaded first) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>


<script type="text/javascript">

    var c = 1;  

const add_well_setup = () => {
   
    if ($('select[name="items[]"]').last().val() == "") {
        toastr.error("Select item name first!");
        return false;
    } else if ($('input[name="qty[]"]').last().val() == "") {
        toastr.error("Enter quantity first!");
        return false;
    } else {
        // Create new row
        const newRow = `
            <div class="row" id="addWell_setup_${c}">
                <div class="col-md-5 form-group">
                    <div class="mb-3">
                        <label class="form-label">Item Name</label>
                        <select  class="form-select select2" name="items[]" style="width:100%;">
                            <option value="">-select-</option>
                            <?php foreach ($component_list as $key => $value) { ?>
                                <option value="<?php echo $value['id'] ?>"><?php echo $value['component_name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Quantity</label>
                        <input type="number" name="qty[]" class="form-control" value="">
                    </div>
                </div>
                <div class="col-md-1 mt-4">
                    <a onclick="remove_row(${c})" href="javascript:;" class="btn btn-danger">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                </div>
            </div>`;

        $('#rowContainer').append(newRow);
        $('.select2').select2(); // Reinitialize select2
        c++; // Increment counter for the next row
    }
};

// Function to remove a row
const remove_row = (id) => {
    $('#addWell_setup_' + id).remove(); // Correctly removes the targeted row by ID
};

    add_well_setup();
</script>