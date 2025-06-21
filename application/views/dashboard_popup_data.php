<div class="card-body">
	
	<div class="table-responsive">
		<table class="table table-striped custom-table mb-0 datatable" id="data-table">
			<thead class="text-center">
				
                 <tr>
					<th style="width:20%;">Sl No.</th>
					<th>Well No</th>
					<th>Status</th>
					<th>Last Log Time</th>
					
					
				</tr>
			</thead>
			<tbody class="text-center" id="table_data">
				
		</table>
	</div>
</div>

<script type="text/javascript">

    
	
get_well_details();
    function get_well_details() 
    {
        $('#table_data').html('<tr><td colspan="4">Processing please wait.......</td></tr>');
        var company_id = '<?php echo $this->session->userdata("company_id"); ?>';
        let assets_id = '<?php echo $this->session->userdata("assets_id"); ?>';
        let user_id = '<?php echo $this->session->userdata("user_id"); ?>';
        var search = $('#search_box_1').val();


	    $.ajax({

            url: '<?php echo base_url(); ?>Dashboard_c/get_popup_details',
            method: 'POST',
            data: {
                company_id: company_id,user_id: user_id,assets_id: assets_id,search:search
            },
            success: function (res) 
            {

                var response = JSON.parse(res);
                // console.log('popup_details',response);
                if (response.response_code == 200) {

                    if (response.data.length > 0) {
                           $('#table_data').html("");
                        // console.log(response.data);

                      
                         var well_details = '';
                        $.each(response.data, function (i, v){
                           
                           

                           	var last_data_time = v.last_log_datetime;
                           	var currentDate = new Date();
                           	var year = currentDate.getFullYear();
							var month = String(currentDate.getMonth() + 1).padStart(2, '0');
							var day = String(currentDate.getDate()).padStart(2, '0');
							var hours = String(currentDate.getHours()).padStart(2, '0');
							var minutes = String(currentDate.getMinutes()).padStart(2, '0');
							var seconds = String(currentDate.getSeconds()).padStart(2, '0');

						    var formattedDate = year + '-' + month + '-' + day + ' ' + hours + ':' + minutes + ':' + seconds;
                            var formattedDateObj = new Date(formattedDate);
						    var lastDataTimeObj = new Date(last_data_time);

						    var diffInMilliseconds = formattedDateObj - lastDataTimeObj;
						    var diffInSeconds = Math.floor(diffInMilliseconds / 1000); 

                            var avg_out_current = v.output_Average_Current;

                            status = v.device_shifted;


                            if(status == 0)
                            {
                                if(avg_out_current > 0 && diffInSeconds < 300)
                                {
                                    well_details = '<span style="color: green;">ON</span>';
                                }else{
                                	well_details = '<span style="color: red;">OFF</span>';
                                }
                            }else if(status == 1)
							{
								well_details = '<span style="color: blue;">Shifted</span>';
							}
                           $("#table_data").append('<tr>' +
                             '<td>'+(i+1)+'</td>'+
                             '<td><a style="color: green;" href="Dashboard_c/get_single_well_detail_dashboard/' + v.well_id + '">' + v.well_name + '</a></td>'+
                             '<td>'+ well_details+'</td>'+
                            '<td>' + (v.last_log_datetime ? moment(v.last_log_datetime).format('DD-MM-YYYY h:mm:ss a') : 'NA') + '</td>'+

                           '</tr>');

                            });
                    }else {
                    $('#table_data').html('<tr>' +
                        '<td class="text-danger" style="text-align:center;" colspan="5">No Record Found !!</td>' +
                        '</tr>');
                   }
                }
            }
      
    });
}
</script>



