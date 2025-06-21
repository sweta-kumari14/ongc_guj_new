                              <form class="custom-validation" method="POST" action="<?php echo base_url('Well_configration_c/update_configration'); ?>" enctype="multipart/form-data">
                                <div class="row">
                                    <input type="hidden" name="id" value="<?php echo $well_configration_list[0]['id']; ?>">

                                    <input type="hidden" name="well_id" value="<?php echo $well_configration_list[0]['well_id']; ?>">
                                    
                                      <div class="form-group col-md-12 mt-2">
                                         <h4><b>Well Name <span style="color:red">*</span></b></h4>
                                       
                                        <input type="text" name="well_name" id="well_name" value="<?php echo $well_configration_list[0]['well_name']; ?>" class="form-control" readonly>
                                       
                                   </div>
                                    <div class="form-group col-md-12 mt-2">
                                        <h4><b>Well Type</b></h4>
                                          <input type="text" name="well_type" id="well_type" value="<?php echo ($well_configration_list[0]['well_type'] == 0) ? 'Regular' : 'Periodic'; ?>" class="form-control" readonly>
                                    </div>

                                    <input type="hidden" name="well_type_hdn" id="well_type_hdn" value="<?php echo ($well_configration_list[0]['well_type']);?>">


                                     <div class="form-group col-md-12 mt-2">
                                        <h4><b>Assign Date</b></h4>
                                        <input type="date" class="form-control" name="assign_date" id="assign_date" value="<?php echo date('Y-m-d', strtotime($well_configration_list[0]['assign_date'])) ; ?>">
                                    </div>



                                    <div class="form-group col-md-12 mt-2" style="display: none;" id="regular_schedule">
                                            <h4><b>Running Hours</b></h4>
                                            <input type="text" class="form-control" value="" id="Running_hours" readonly>
                                        </div>
                                      
                                      
                                       <div class="form-group col-md-12 mt-2" style="display: none;" id="periodic_schedule_starts">
                                            <h4><b>Start Time</b></h4>
                                            <input type="time" class="form-control" value="<?php echo $well_configration_list[0]['start_time']; ?>" name="start_time" id="start_time">
                                        </div>

                                        <div class="form-group col-md-12 mt-2" style="display: none;" id="periodic_schedule_stops">
                                            <h4><b>Stop Time</b></h4>
                                            <input type="time" class="form-control" value="<?php echo $well_configration_list[0]['stop_time']; ?>" name="stop_time" id="stop_time">
                                        </div>
                                        

                                        
                                    

                                 <div class="form-group  mt-4">
                                    <div>
                                        <button type="submit" class="btn btn-sm btn-primary" >Update</button>
                                    </div>
                                </div>
                                
                            </div>
                                
                            </form>
  <script>
var runningMinutes = 1440;

// Calculate hours and remaining minutes
var hours = Math.floor(runningMinutes / 60);
var remainingMinutes = runningMinutes % 60;

// Display the result in the input field
document.getElementById('Running_hours').value = hours + ' hours ' + remainingMinutes + ' minutes';
</script>

<script type="text/javascript">
    
    check_well_type();
    function check_well_type()
    {
        var well_type = $('#well_type').val();
        // alert(well_type);
         if (well_type == 0) 
         {
           
            $('#periodic_schedule_starts').hide();
            $('#periodic_schedule_stops').hide();
            $('#shedule_datas').hide();
            
        } else if (well_type == 1) {
          
            $('#periodic_schedule_starts').show();
            $('#periodic_schedule_stops').show();
            $('#shedule_datas').show();
            $('#regular_schedules').hide();
           
        } else {
           
            $('#regular_schedules').hide();
            $('#periodic_schedule_starts').hide();
            $('#periodic_schedule_stops').hide();
            $('#shedule_datas').hide();
            
        }
    }
</script>

        
 