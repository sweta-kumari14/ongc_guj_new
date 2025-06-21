
<div class="page-wrapper">
    <div class="content container-fluid">
	
			

 <div class="row mt-2">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center" style="height: 65px;background-color:#F1948A;">
                <div>
                	<input type="hidden" id="well_id" name="well_id" value="<?php echo $this->uri->segment(3); ?>">
                    <h5 class="text-white " style="font-size: 18px;"><span id="well_namedata"></span> GIS Map</h5>
                </div>
                <div class="d-flex align-items-center">
                	 <a href="<?php echo base_url('Dashboard_c'); ?>">
                     <button type="button" class="btn btn-sm btn-secondary">Back</button>
                    </a> &nbsp; &nbsp;
                    <img src="<?php echo base_url() ?>assets/img/map.gif" width="40" style="border-radius: 25%;">
                </div>
            </div>
            <div class="card-body">
               
                	<div class="row">
                    <div class="col-md-6">
                        <button type="button" class="btn btn-sm btn-rounded" style="background-color: #06E763;color:white;"> Well Running</button>
                        <button type="button" class="btn btn-sm btn-rounded mx-3" style="background-color: rgb(227,66,52);color:white;">Well Not Running</button>
                        <button type="button" class="btn btn-sm btn-rounded" style="background-color: #F39C12;color:white;">Device Not Installed</button>
                    </div>
                </div>
                    <div class="mt-4" id="mymap" style="width:100%;height: 400px;"></div>
                </div>
            
        </div>
    </div>
</div>
</div>
</div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA80-_i6Nd7DPLz-axQE8eFEXV6WPDmwK4"></script>


<script type="text/javascript">
	
	initMap();
function initMap() {

	
	let well_id = $('#well_id').val();


  $.ajax({
    url:'<?php echo base_url(); ?>Dashboard_c/get_site_location_for_new_tab',
    type : 'POST',
    data : {well_id:well_id},
    success : function(res)
    {
      response = JSON.parse(res);
          console.log('Map details',response);     
      if(response.data.length>0)
      {   
        let markers=[];
        for(item of response.data){
          markers.push({
            position: {lat: parseFloat(item.lat), lng: parseFloat(item.long)},
            title: item.well_name,
            status: item.smps_voltage,
            site_id: item.site_id,
            well_id: item.well_id,
            ins_status: item.device_setup_status,
            device_active_status:item.device_active_status,
            avg_out_current : item.output_Average_Current,
            offline_time : item.last_log_datetime
          })
        }

        var map = new google.maps.Map(document.getElementById('mymap'), {
          zoom: 13,
          center: {lat:22.24541800, lng:73.07932750}
        });

        

       	markers.forEach(function(marker) {
          var markerIcon = {
            url: '<?php echo base_url(); ?>assets/images/yellow-well.png',
            scaledSize: new google.maps.Size(20, 20)
            
          };

          var well_name = marker.title; 
          $('#well_namedata').text(well_name);

          if (marker.offline_time != null )
      	 	{
      	 		// =============== time convert code starts =========
			        		var last_data_time = marker.offline_time;
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
									var diffInSeconds = Math.floor(diffInMilliseconds / 1000); // Convert milliseconds to seconds

									// console.log('seconds==',diffInSeconds);

									var second = diffInSeconds;
									// console.log(second);
        		// =============== time convert code ends ===========
		      	 	}else{
		      	 			var second = 200;
		      	 			// console.log(second);
		      	 	}

	          if (marker.ins_status == '1' && marker.device_active_status == '1')
	         	{
	         		if (second < 180 )
	         		{
	         				if (marker.avg_out_current > 0) {
			            markerIcon.url = '<?php echo base_url(); ?>assets/img/green.png';
				          } else {
				            markerIcon.url = '<?php echo base_url(); ?>assets/img/red.png';
				          } 
				         
	         		}	else{
	         				markerIcon.url = '<?php echo base_url(); ?>assets/img/red.png';
	         		}
		         		
	         	}else{
	         			
	         			markerIcon.url = '<?php echo base_url(); ?>assets/img/orange.png';
	         	}

		          var mapMarker = new google.maps.Marker({
		            position: marker.position,
		            map: map,
		            icon: markerIcon,
		            title: marker.title
		          });

		          var statusText = '';
						if (marker.ins_status == 1)
						{
							if (second < 180)
							{
									if (marker.avg_out_current > 0 )
									{
										statusText = 'ON';
									}else{
										statusText = 'OFF';
									}
							}else{
								statusText = 'DCU OFF';
							}
							
						  
						}
						
						else{
							 statusText = 'Device Not Installed';
						}

          var infowindow = new google.maps.InfoWindow({
				  content: '<div class="site-info" style="width: 100px; height: 100px;">' +
				            '<h5>' + marker.title + '</h5>' +
				            '<h6><b>Well Status</b>: ' + statusText + '</h6>' +
				            ((marker.status == null )
				              ? ''
				              : '<a target="_blank" href="<?php echo base_url(); ?>Dashboard_c/get_single_well_detail_dashboard/' + marker.well_id + '">View Details</a>'
                                

				              ) +

				            '</div>'
					});

          mapMarker.addListener('click', function() {
					    infowindow.open(map, mapMarker);
					});

					map.addListener('click', function() {
					    infowindow.close();
					});

        });
      }
    }
  });
}
</script>
