<div class="page-wrapper">
        <div class="content container-fluid">
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center" style="background-color: white;">
                <h5 class="card-title fs-18 mb-0">Well Setup Formula</h5>
                <a class="btn btn-warning btn-sm text-white" href="<?php echo base_url('Well_setup_c/cgl_well_setup_list');?>">
                    <i class="fas fa-arrow-left me-1 text-white"></i> Back
                </a>
            </div>
            <div class="card-body">
                <div class="setup-section">
                    <form method="POST" action="<?php echo base_url() ?>Well_setup_c/store_well_formula_data">
                        <div class="well-setup-section">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label>Well Type<span class="text-danger">*</span></label>
                                    <select class="form-select select2" name="well_type_id" id="well_type_id" style="width:100%;" required>
                                        <option value="">select</option>
                                        <?php foreach ($well_type_list as $key => $well) { ?>
                                            <option value="<?php echo $well['id'] ?>"><?php echo $well['well_type_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1 mt-4">
                                 <a href="javascript:;" onclick="add_well_setup();" class="btn btn-success btn-sm addRow"><i class="fa-solid fa-plus"></i>
                                 </a>
                            </div>
                        </div>
                            <div id="rowContainer">

                            </div> <hr>
                           
                            <div class="pt-3 pb-3 text-end">
                                <button type="submit" class="btn btn-success btn-sm">Submit</button>
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
                        <label>Item Name<span class="text-danger">*</span></label>
                        <select  class="form-select select2" name="items[]" style="width:100%;">
                            <option value="">-select-</option>
                            <?php foreach ($component_list as $key => $value) { ?>
                                <option value="<?php echo $value['id'] ?>"><?php echo $value['component_name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                        <label>Quantity<span class="text-danger">*</span></label>
                        <input type="number" name="qty[]" class="form-control" value="">
                </div>

                <div class="col-md-1 mt-4">
                    <a onclick="remove_row(${c})" href="javascript:;" class="btn btn-danger btn-sm">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                </div>
            </div>`;

        $('#rowContainer').append(newRow);
        $('.select2').select2(); 
        c++; 
    }
};

const remove_row = (id) => {
    $('#addWell_setup_' + id).remove();
};
add_well_setup();
</script>