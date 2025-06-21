<div class="page-wrapper">
    <div class="content container-fluid pb-0">
    	<div class="page-header">
			<div class="content-page-header">
				<h5>Installer Device Allotment</h5>
			</div>	
		</div>
			<div class="row">					
						<!-- Lightbox -->
                        <div class="col-lg-12">
                            <div class="card">
                               
                                <div class="card-body">
                                   <div class="row align-items-center">
                                        <div class="col">
                                           <h3 class="header-title mb-4 mx-2"><b>Installer Device Allotment</b></h3>
                                        </div>
                                       
                                    </div>


                                      <form class="custom-validation" method="POST" action="<?php echo base_url('Device_allot_to_installer_c/allot_ins_devices'); ?>" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="form-group col-md-4 mt-3 mx-2">
                                            <h3><b>User Name</b></h3>
                                            <select name="user_id" id="user_id" class="form-control select2"  required onchange="get_device_area();">
                                                <option value="">Select User</option>
                                                <?php 
                                                if(!empty($user_list))
                                                {
                                                    foreach ($user_list as $key => $value) 
                                                    {
                                                        ?>
                                                            <option value="<?php echo $value['id']; ?>"><?php echo $value['user_full_name'].'-['.$value['emp_id'].']'; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mt-3 mx-2">
                                        <div  style="max-height:500px;overflow-y: scroll;" class="user-class mt-3">
                                            <div>
                                                <h3>
                                                    <b>Device List</b>
                                                </h3>
                                            </div>
                                            <div class="row mt-2" id="device_area">
                                                
                                            </div>
                                        </div    >  
                                    </div>
                                    <div class="footer mt-4 mx-2">
                                        <div>
                                            <button type="submit" class="btn btn-sm btn-primary" >Submit</button>
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

<script type="text/javascript">
    
    
    function get_device_area()
    {  
       let user_id = $('#user_id').val();
       let company_id = '<?php echo $this->session->userdata('company_id') ?>';
       $.ajax({
            type: 'POST',
            url: '<?php echo base_url();?>Device_allot_to_installer_c/get_device_list',
            data:{company_id:company_id,user_id:user_id},
            success:function(data)
            {
                data = JSON.parse(data);
                console.log(data);
                if(data.response_code==200)
                {   
                    if(data.data.length>0)
                    {
                        $('#device_area').html('');
                        $.each(data.data,function(i,v){
                            $('#device_area').append('<div class="col-md-3 mt-3">'+
                                                        '<div><input type="checkbox" value="'+v.device_name+'|'+v.imei_no+'" name="assign[]" class="mx-1">'+
                                                        '&nbsp;<strong>'+v.device_name+'</strong>'+
                                                      '</div></div>');
                          
                            
                        });
                        
                    }else
                    {
                        $('#device_area').html('No Device Available');
                    }
                }else
                {
                    swal('error',data.msg,'error');
                }
              console.log();
            }
          });
    }
</script>






                

                









                


