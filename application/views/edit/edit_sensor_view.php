<div class="page-wrapper">
  <div class="content container-fluid pb-0">
    <div class="page-header">
      <div class="content-page-header">
        <h5>Sensor</h5>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col">
                <h4 class="header-title mb-4"><b>Edit Sensor</b></h4>
              </div>
              <div class="col-auto float-end ms-auto">
                <a href="<?php echo base_url('Sensor_c'); ?>">
                  <button type="button" class="btn btn-sm btn-rounded btn-success">Back</button>
                </a>
              </div>
            </div>

            <form class="custom-validation" role="form" method="POST" action="<?php echo base_url('Sensor_c/update_device') ?>" enctype="multipart/form-data">
              <input type="hidden" name="id" id="id" value="<?php echo $device_list[0]['id']; ?>">

              <div class="row">
                <div class="form-group col-md-6 mt-2">
                  <h5><b>Sensor No </b><span class="text-danger">*</span></h5>
                  <div class="controls">
                    <input data-parsley-type="alphanum" name="sensor_no" id="sensor_no" class="form-control" required maxlength="20" minlength="10" value="<?php echo $device_list[0]['sensor_no']; ?>" onkeyup="this.value = this.value.replace(/[<>]/g,'')">
                  </div>
                </div>

                <div class="col-md-6 mt-2">
                  <h5><b>Sensor Name</b><span style="color:red;">*</span></h5>
                  <input data-parsley-type="text" name="sensor_name" id="sensor_name" class="form-control" required value="<?php echo htmlspecialchars($device_list[0]['sensor_name']); ?>" onkeyup="this.value = this.value.replace(/[<>]/g,'')">
                </div>
                 <div class="col-md-6 mt-2">
<label class="form-label">Item Name</label>
<select class="form-select select2" name="item_name" style="width:100%;">
    <option value="">-select-</option>
    <?php foreach ($items as $item) { ?>
        <option value="<?php echo $item['item_name']; ?>">
            <?php echo $item['item_name']; ?>
        </option>
    <?php } ?>
</select>

</div>
                <div class="col-md-6 mt-2">
                  <h5><b>Manufacturer Year</b><span style="color:red;">*</span></h5>
                  <select name="sensor_allotment_year" id="sensor_allotment_year" class="form-control">
                    <?php
                    $current_year = date('Y');
                    for ($i = $current_year - 3; $i < $current_year + 3; $i++) {
                      echo '<option value="' . $i . '"';
                      if ($i == $device_list[0]['sensor_allotment_year']) {
                        echo ' selected="selected"';
                      }
                      echo '>' . $i . '</option>';
                    }
                    ?>
                  </select>
                </div>

                <div class="col-md-6 mt-2">
                  <h5><b>Manufacture Month</b><span style="color:red;">*</span></h5>
                  <input data-parsley-type="text" name="sensor_allotment_month" id="sensor_allotment_month" class="form-control" required value="<?php echo htmlspecialchars($device_list[0]['sensor_allotment_month']); ?>" onkeyup="this.value = this.value.replace(/[<>]/g,'')">
                </div>
              </div>

              <!-- Add d_by as hidden or visible field -->
              <input type="hidden" name="d_by" id="d_by" value="<?php echo $current_user_id_or_name ?? 'admin'; ?>">

              <div class="footer mt-4">
                <div>
                  <button type="submit" class="btn btn-sm btn-primary">Update</button>
                </div>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
