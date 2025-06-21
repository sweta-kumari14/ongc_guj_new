<form class="custom-validation" method="POST" action="<?php echo base_url('Well_Integration_c/well_integration_update'); ?>" enctype="multipart/form-data">
    <div class="row">

        <div class="form-group col-md-12 mt-2">
            <p><b>Ticket ID:</b> <?php echo $list_complaints[0]['ticket_id']; ?>
            <b>Well Type:</b> 
                <?php 
                if ($list_complaints[0]['well_type'] == 0) {
                    echo "Add New Well";
                } elseif ($list_complaints[0]['well_type'] == 1) {
                    echo "Remove Well";
                } elseif ($list_complaints[0]['well_type'] == 2) {
                    echo "Shift Well";
                } else {
                    echo "Unknown Type";
                }
                ?>
        </div>

        <input type="hidden" name="ticket_id" value="<?php echo $list_complaints[0]['ticket_id']; ?>">
        <input type="hidden" name="well_type" value="<?php echo $list_complaints[0]['well_type']; ?>">

        <div class="form-group col-md-12 mt-2">
            <h4><b>Well Name <span style="color:red">*</span></b></h4>
            <input type="text" name="well_name" id="well_name" class="form-control" value="<?php echo $list_complaints[0]['well_name']; ?>" readonly>
        </div>

        <div class="form-group col-md-12 mt-2">
            <h4>
                <b>
                    <?php 
                    if ($list_complaints[0]['well_type'] == 0) {
                        echo "Installation Date";
                    } elseif ($list_complaints[0]['well_type'] == 1) {
                        echo "Removed Date";
                    } else {
                        echo "Shifting Date";
                    }
                    ?>
                </b>
            </h4>
            <input type="datetime-local" id="operation_date" name="operation_date" value="<?= date('Y-m-d\TH:i', time()); ?>" class="form-control" required>
        </div>

        <?php if ($list_complaints[0]['well_type'] == 0): ?>
        <div class="form-group col-md-12 mt-2">
            <h4><b>IMEI No</b></h4>
            <input type="text" name="imei_no" class="form-control" value="<?php echo $list_complaints[0]['imei_no'] ?? ''; ?>" placeholder="Enter IMEI No">
        </div>
        <?php endif; ?>

        <div class="form-group col-md-12 mt-2">
            <h4><b>Request Status</b></h4>
            <select name="complaint_status" id="complaint_status" class="form-control select2">
                <option value="">Select Well Type</option>
                <option value="0" <?php echo ($list_complaints[0]['execution_status'] == 0) ? 'selected' : ''; ?>>Pending</option>
                <option value="1" <?php echo ($list_complaints[0]['execution_status'] == 1) ? 'selected' : ''; ?>>Solved</option>
            </select>
        </div>

        <div class="form-group col-md-12 mt-4">
    <h4><b id="reason_text">Remarks</b><span style="color:red;">*</span></h4>
    
    <textarea name="reason_remove" id="reason_remove" class="form-control" 
        onkeyup="this.value = this.value.replace(/[<>]/g,'')"><?php echo isset($list_complaints[0]['reason_remove']) ? $list_complaints[0]['reason_remove'] : ''; ?></textarea>
</div>

        <?php if ($list_complaints[0]['execution_status'] != 1): ?>
        <div class="form-group mt-4">
            <div>
                <button type="submit" class="btn btn-sm btn-primary">Update</button>
            </div>
        </div>
        <?php endif; ?>

    </div>
</form>
