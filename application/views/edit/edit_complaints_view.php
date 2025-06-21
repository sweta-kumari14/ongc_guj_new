
                        <form class="custom-validation" method="POST" action="<?php echo base_url('Technical_compalint_c/update_complaints'); ?>" enctype="multipart/form-data">
                                <div class="row">

                                    <input type="hidden" name="id" value="<?php echo $list_complaints[0]['id']; ?>">
                                      <div class="form-group col-md-12 mt-2">
                                         <h4><b>Well Name <span style="color:red">*</span></b></h4>
                                        <input type="text" name="well_name" id="well_name" class="form-control" value="<?php echo $list_complaints[0]['well_name']; ?>" readonly>
                                         <input type="hidden" name="well_id" id="well_id" class="form-control" value="<?php echo $list_complaints[0]['well_id']; ?>" readonly>
                                         <input type="hidden" name="user_id" id="user_id" class="form-control" value="<?php echo $list_complaints[0]['user_id']; ?>" readonly>
                                   </div>
                                   <div class="form-group col-md-12 mt-2">
                                         <h4><b>Device Name <span style="color:red">*</span></b></h4>
                                        <input type="text" name="device_name" id="device_name" class="form-control" value="<?php echo $list_complaints[0]['device_name']; ?>" readonly>
                                   </div>
                                    <div class="form-group col-md-12 mt-2">
                                         <h4><b>Imei No <span style="color:red">*</span></b></h4>
                                        <input type="text" name="imei_no" id="imei_no" class="form-control" value="<?php echo $list_complaints[0]['imei_no']; ?>" readonly>
                                   </div>
                                   <div class="form-group col-md-12 mt-2">
                                         <h4><b>Installation Date <span style="color:red">*</span></b></h4>
                                        <input type="text" name="date_of_installation" id="date_of_installation" class="form-control" value="<?php echo $list_complaints[0]['date_of_installation']; ?>" readonly>
                                   </div>
                                    <div class="form-group col-md-12 mt-2">
                                         <h4><b>Ticket ID <span style="color:red">*</span></b></h4>
                                        <input type="text" name="ticket_id" id="ticket_id" class="form-control" value="<?php echo $list_complaints[0]['ticket_id']; ?>" readonly>
                                   </div>
                                    <div class="form-group col-md-12 mt-2">
                                         <h4><b>Reason for Complaints<span style="color:red">*</span></b></h4>
                                        <input type="text" name="complaint_type" id="complaint_type" class="form-control" value="<?php $compliment_data = $list_complaints[0]['complaint_type'];

                                        if($compliment_data == 0)
                                        {
                                            echo $compliment_details = 'RTMS Offline';
                                        }elseif($compliment_data == 1)
                                        {
                                            echo $compliment_details = 'RTMS Physical Damage';
                                        }elseif($compliment_data == 2)
                                        {
                                            echo $compliment_details = 'RTMS Burn'; 
                                        }else{
                                            echo $compliment_details = 'Others'; 
                                        } ?>" readonly>
                                   </div>
                                   <div class="form-group col-md-12 mt-2">
                                        <h4><b>Complaints Status</b></h4>
                                        <select name="complaint_status" id="complaint_status" class="form-control select2">
                                            <option value="">Select Well Type</option>
                                            <option value="0" <?php echo ($list_complaints[0]['complaint_status'] == 0) ? 'selected' : ''; ?>>Pending</option>
                                            <option value="1" <?php echo ($list_complaints[0]['complaint_status'] == 1) ? 'selected' : ''; ?>>In Progress</option>
                                             <option value="2" <?php echo ($list_complaints[0]['complaint_status'] == 2) ? 'selected' : ''; ?>>Solved</option>
                                             
                                        </select>
                                    </div>
                                   <div class="col-md-12 mt-2">
                                        <h4><b>Complaints Description <span style="color:red">*</span></b></h4>
                                        <textarea type="text" name="complaint_description" id="complaint_description" class="form-control" required onkeyup="this.value = this.value.replace(/[^a-zA-Z0-9-,.\/ ]/g,'')"><?php echo $list_complaints[0]['complaint_description']; ?></textarea>
                                    </div>

                                    

                                    <div class="col-md-12 mt-2">
                                        <h4><b>Resolution Description <span style="color:red">*</span></b></h4>
                                        <textarea type="text" name="resolution_description" id="resolution_description" class="form-control" required onkeyup="this.value = this.value.replace(/[^a-zA-Z0-9-,.\/ ]/g,'')"><?php echo $list_complaints[0]['resolution_description']; ?></textarea>
                                    </div>

                                   



                                 <div class="form-group  mt-4">
                                    <div>
                                        <button type="submit" class="btn btn-sm btn-primary" >Update</button>
                                    </div>
                                </div>
                                
                            </div>
                                
                            </form>
  