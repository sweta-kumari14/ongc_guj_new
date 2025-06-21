<div class="page-wrapper">
    <div class="content container-fluid pb-0">
    	<div class="page-header">
			<div class="content-page-header">
				<h5>Well Scheduling</h5>
			</div>	
		</div>
			<div class="row">					
						<!-- Lightbox -->
                        <div class="col-lg-12">
                            <div class="card">
                               
                                <div class="card-body">
                                   <div class="row align-items-center">
                                        <div class="col">
                                           <h4 class="header-title mb-4"><b>Well Scheduling</b></h4>
                                        </div>
                                         <div class="col-auto float-end ms-auto">
                                             <a href="<?php echo base_url('Well_configration_c'); ?>">
                                               <button type="button" class="btn btn-sm  btn-success">Back</button>
                                            </a>
                                        </div>
                                       
                                    </div>


                                    <form class="custom-validation" method="POST" action="<?php echo base_url('Well_configration_c/allot_well_configration'); ?>" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="form-group col-md-3 mt-2" >
                                        <h4><b>Well Name</b></h4>
                                        <select name="well_id" id="well_id" class="form-control select2" onchange="get_well_hdn_data();get_details_well();" >
                                            <option value="">Select Well</option>
                                            <?php 
                                            if(!empty($well_list))
                                            {
                                                foreach ($well_list as $key => $value) 
                                                {
                                                    ?>
                                                        <option value="<?php echo $value['id'].'|'.$value['well_name']; ?>"> <?php echo $value['well_name']; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <input type="hidden" name="well_name_hdn" id="well_name_hdn">
                                    <input type="hidden" name="well_id_hdn" id="well_id_hdn">
                                
                                   <div class="form-group col-md-3 mt-2">
                                        <h4><b>Well Type</b></h4>
                                        <select name="well_type" id="well_type" class="form-control select2" required>
                                            <option value="">Select Well Type</option>
                                            <option value="0">Regular</option>
                                            <option value="1">Periodic</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3 mt-2">
                                        <h4><b>Assign Date</b></h4>
                                        <input type="date" id="assign_date" name="assign_date" value="<?= date('Y-m-d',time()); ?>" class="form-control" required>
                                        
                                    </div>

                                     

                                      <div class="form-group col-md-3 mt-2" style="display: none;" id="regular_schedule">
                                            <h4><b>Running Hours</b></h4>
                                            <input type="text" class="form-control" value="" id="Running_hours" readonly>
                                        </div>


                                      
                                      
                                        <div class="form-group col-md-3 mt-2" style="display: none;" id="periodic_schedule_start">
                                            <h4><b>Start Time</b></h4>
                                              <input type="time" class="form-control" value="06:00" id="start_time">
                                        </div>

                                        <div class="form-group col-md-4 mt-3" style="display: none;" id="periodic_schedule_stop">
                                            <h4><b>Stop Time</b></h4>
                                            <input type="time" class="form-control" value="05:59" id="stop_time" >
                                        </div>
                                        <div class="form-group col-md-4 mt-3" style="display:none;" id="total_hours_minutes">
                                         <h4><b>Running Hours</b></h4>
                                          <input type="text" class="form-control" value="" id="total_hours_minutes_display" readonly>
                                       </div>
                                        
                                   
                                    <div class="col-md-1 mt-4">
                                        <button type="button" onclick="add_well();"  id="shedule_data" class="btn btn-sm btn-success mt-4">Add</button>
                                    </div>

                                    
                                    
                                </div>

                                <div class="" id="assign_well"></div>
                                <div class="" id="assign_device">
                                    
                                </div>
                                <div class="footer mt-4">
                                    <div>
                                        <button type="submit" class="btn btn-sm btn-primary" id="submit_button" >Submit</button>
                                    </div>
                                </div>
                            </form>
                                  

                                  
                              
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

<script>
var runningMinutes = 1440;

var hours = Math.floor(runningMinutes / 60);
var remainingMinutes = runningMinutes % 60;


document.getElementById('Running_hours').value = hours + ' hours ' + remainingMinutes + ' minutes';
</script>
 <script>
        function calculateTotalHoursMinutes() {
            var startTimeInput = document.getElementById('start_time');
            var stopTimeInput = document.getElementById('stop_time');
            var totalHoursMinutesInput = document.getElementById('total_hours_minutes_display');

            if (startTimeInput.value && stopTimeInput.value) {
                var startTime = new Date('2022-01-01T' + startTimeInput.value + ':00');
                var stopTime = new Date('2022-01-01T' + stopTimeInput.value + ':00');

                // Adjust stop time if it's before the start time
                if (stopTime < startTime) {
                    stopTime.setDate(stopTime.getDate() + 1); // Add one day
                }

                var timeDifference = stopTime - startTime;
                var totalMinutes = Math.floor(timeDifference / (1000 * 60));
                var totalHours = Math.floor(totalMinutes / 60);
                var remainingMinutes = totalMinutes % 60;

                totalHoursMinutesInput.value = totalHours + ' hours ' + remainingMinutes + ' minutes';
            } else {
                totalHoursMinutesInput.value = '';
            }
        }

        // Attach the function to the change event of the input fields
        document.getElementById('start_time').addEventListener('change', calculateTotalHoursMinutes);
        document.getElementById('stop_time').addEventListener('change', calculateTotalHoursMinutes);

        // Calculate on load (if initial values are present)
        calculateTotalHoursMinutes();
    </script>
<script type="text/javascript">
    
     function get_well_hdn_data()
    {
        let well_data = $('#well_id').val();
        $('#well_id_hdn').val(well_data.split('|')[0]);
        $('#well_name_hdn').val(well_data.split('|')[1]);
       
    }

    let row_no = 0;
    function add_well()
    {
        
        
        let well_data = $('#well_id').val();
        let well_type = $('#well_type').val();

        if (!well_data  && !well_type) 
        {
            swal('well required','','error');
            return false;
        }

        if (well_type == 1) {
        $('#assign_device').append('<div id="row_' + row_no + '" class="row">'+
            '<input type="hidden" name="well_id_hdn" class="form-control" value="'+$('#well_id_hdn').val() +'" readonly>'+

            '<div class="col-md-3 mt-3">'+
                    '<label>Start Time</label>'+
                    '<input type="time" name="start_time[]" class="form-control" value="'+$('#start_time').val() +'" readonly>'+
                           
            '</div>'+
             '<div class="col-md-3 mt-3">'+
                    '<label>Stop Time</label>'+
                    '<input type="time" name="stop_time[]" class="form-control" value="'+$('#stop_time').val() +'" readonly>'+
                           
            '</div>'+
            '<div class="col-md-3 mt-3">'+
                    '<label>Running Hours</label>'+
                    '<input type="text" name="total_hours_minutes_display" class="form-control" value="'+$('#total_hours_minutes_display').val() +'" readonly>'+
                           
            '</div>'+
            '<div class="col-md-1 mt-4">'+
                '<img src="<?php echo base_url(); ?>assets/img/delete.png" alt="" width="20" onclick="deleterow(' + row_no + ')" style="cursor:pointer;" class="mt-4">' +
                           
            '</div>'+
            '</div>');
        }

        row_no++;
        
        $('#start_time').val('').change();
        $('#stop_time').val('').change();
        $('#total_hours_minutes_display').val('').change();
               
    }

      function deleterow(id) {


        swal({
            title: "Are you sure You want to delete",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    $('#row_' + id).remove();

                    swal("Deleted Successfully", {
                        icon: "success",
                    });
                } else {
                    swal("Delete Cancelled");
                }
            });



    }
</script>

<script>
     $(document).ready(function () {
        $('#well_type').change(function () {
            if($(this).val() == '0')
            {
                $('#regular_schedule').show();
                $('#shedule_data').hide();
                $('#periodic_schedule_start').hide();
                $('#periodic_schedule_stop').hide();
                $('#shedule_data').hide();
                $('#total_hours_minutes').hide();

            }else if($(this).val() == '1') 
            { 

                
                $('#periodic_schedule_start').show();
                $('#periodic_schedule_stop').show();
                $('#shedule_data').show();
                $('#regular_schedule').hide();
                $('#total_hours_minutes').show();


            }else{
                 $('#periodic_schedule_start').hide();
                 $('#periodic_schedule_stop').hide();
                 $('#shedule_data').hide();
                 $('#regular_schedule').hide();
                 $('#total_hours_minutes').hide();
                 
            }
        });
    });
   
</script>

 <!--  <script>
        document.getElementById('start_time').addEventListener('input', function() {
            var selectedTime = new Date('1970-01-01T' + this.value + ':00');
            var startTime = new Date('1970-01-01T06:00:00');

            if (selectedTime < startTime) {
                this.value = '06:00';
            }
        });

        document.getElementById('stop_time').addEventListener('input', function() {
            var selectedTime = new Date('1970-01-01T' + this.value + ':00');
            var stopTime = new Date('1970-01-01T05:59:00');

            if (selectedTime < stopTime) {
                this.value = '05:59';
            }
        });
    </script> -->

   

<script type="text/javascript">
  $(document).ready(function () {
    $("#submit_button").on("click", function () {
        var well_type = $("#well_type").val();

        if (well_type == 1 && $("[name='total_hours_minutes_display']").length === 0) {
            swal('All Fields Required', '', 'error');
            return false; 
        }
        
        return true; 
    });
});

</script>
<script type="text/javascript">
function get_details_well() {
    var well_id = $('#well_id_hdn').val();

    $.ajax({
        url: '<?php echo base_url(); ?>Well_configration_c/well_details_data',
        method: 'POST',
        data: { well_id: well_id },
        success: function (res) {
            var response = JSON.parse(res);
            // console.log(response);
            if (response.response_code == 200) {
                if (response.data.result.length > 0) {
                    $('#assign_well').html("");
                    $.each(response.data.result, function (i, v) {
                        var well_type = v.well_type;
                        var welltype = v.well_type;
                        if(well_type == 0)
                        {
                            well_type = 'Regular';

                        }else{
                             well_type = 'Periodic';
                        }
                         var formattedDate = moment(v.assign_date).format('DD-MM-YYYY');
                        if (welltype == 0) {
                        $('#assign_well').append('<div id="row_' + i + '" class="row">' +
                            '<div class="col-md-3 mt-3">' +
                            '<label>Well Type</label>' +
                            '<input type="text"  class="form-control" value="' + well_type + '" readonly>' +
                            '</div>' +
                            '<div class="col-md-3 mt-3">' +
                            '<label>Assign Date</label>' +
                            '<input type="text" class="form-control" value="' + formattedDate + '" readonly>' +
                            '</div>' +
                            '</div>');
                    }else if(welltype == 1)
                    {
                        var formattedStartTime = moment(v.start_time, 'HH:mm:ss').format('hh:mm A');
                        var formattedStopTime = moment(v.stop_time, 'HH:mm:ss').format('hh:mm A');


                         $('#assign_well').append('<div id="row_' + i + '" class="row">' +
                            '<div class="col-md-3 mt-3">' +
                            '<label>Well Type</label>' +
                            '<input type="text"  class="form-control" value="' + well_type + '" readonly>' +
                            '</div>' +
                            '<div class="col-md-3 mt-3">' +
                            '<label>Start Time</label>' +
                            '<input type="text"  class="form-control" value="' + formattedStartTime + '" readonly>' +
                            '</div>' +
                            '<div class="col-md-3 mt-3">' +
                            '<label>Stop  Time</label>' +
                            '<input type="text"  class="form-control" value="' + formattedStopTime + '" readonly>' +
                            '</div>' +
                            '<div class="col-md-3 mt-3">' +
                            '<label>Assign Date</label>' +
                            '<input type="text"  class="form-control" value="' + formattedDate + '" readonly>' +
                            '</div>' +
                            '</div>');

                     }
                    });
                }
            } else {
                $('#assign_well').html("");
            }
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}


</script>






                


