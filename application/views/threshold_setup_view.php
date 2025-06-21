 <div class="page-wrapper">
            
                <!-- Page Content -->
                <div class="content container-fluid">
                               
                               
                                    <div class="page-header">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h3 class="page-title">Threshold</h3>
                                                <ul class="breadcrumb">
                                                    <li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard_c');?>">Dashboard</a></li>
                                                    <li class="breadcrumb-item ">Threshold</li>
                                                    
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Page Header -->

                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-body">
                                   <form role="form" class="custom-validation" method="POST" action="<?php echo base_url('Threshold_setup_c/add_threshold_setup'); ?>">
                                    <div class="row my-2">
                                    <div class="form-group col-md-4">
                                        <h4><b>Well No</b></h4>
                                        <select name="well" id="well" class="form-control select2" required onchange="get_equipment();get_imei_list();"> 
                                            <option value="">Select Well</option>
                                            <?php 
                                            if (!empty($well_list))
                                            {
                                                foreach ($well_list as $key => $value)
                                                {
                                                    ?>
                                                        <option value="<?php echo $value['well_id'].'|'.$value['equipment_name']; ?>"><?php echo $value['well_name']; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                        <input type="hidden" name="well_id" id="well_id" class="form-control" readonly> 
                                    </div>


                                    <div class="form-group col-md-4">
                                        <h4><b>Equipment Type</b></h4>
                                        <input type="text" name="equipment_type" id="equipment_type" class="form-control" readonly> 
                                            
                                    </div>

                                    <div class="form-group col-md-4">
                                        <h4><b>Imei No</b></h4>
                                        <select name="imei_no" id="imei_no" class="form-control select2" required onchange="get_threshold_value();"> 
                                            <option value="">Select Imei No</option>
                                                                                        
                                        </select>
                                    </div>

                                </div>
                             
                                        
                                 <!--  ================ Output P2P fields starts ============ -->
                                <div class="row my-2">
                                    
                                    <div class="col-md-6 mt-2">
                                        <h4><b>Output P2P Voltage Upper Threshold</b></h4>
                                        <input data-parsley-type="number" data-parsley-pattern="^[-+]?[0-9]*\.?[0-9]+([eE][-+]?[0-9]+)?$" name="out_p2p_ut" id="out_p2p_ut" class="form-control" required onkeyup="this.value = this.value.replace(/[^0-9.]/g,'')">
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <h4><b>Output P2P  Voltage Lower Threshold</b></h4>
                                        <input data-parsley-type="number" data-parsley-pattern="^[-+]?[0-9]*\.?[0-9]+([eE][-+]?[0-9]+)?$" name="out_p2p_lt" id="out_p2p_lt" class="form-control" required onkeyup="this.value = this.value.replace(/[^0-9.]/g,'')">
                                    </div>
                                    
                                </div>
                                <!-- ===================== Output Current fields starts ========== -->
                                <div class="row my-2" >
                                    
                                    <div class="col-md-6 mt-2">
                                        <h4><b>Output Current Upper Threshold</b></h4>
                                        <input data-parsley-type="number" data-parsley-pattern="^[-+]?[0-9]*\.?[0-9]+([eE][-+]?[0-9]+)?$" name="out_current_ut" id="out_current_ut" class="form-control" required onkeyup="this.value = this.value.replace(/[^0-9.]/g,'')">
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <h4><b>Output Current Lower Threshold</b></h4>
                                        <input data-parsley-type="number" data-parsley-pattern="^[-+]?[0-9]*\.?[0-9]+([eE][-+]?[0-9]+)?$" name="out_current_lt" id="out_current_lt" class="form-control" required onkeyup="this.value = this.value.replace(/[^0-9.]/g,'')">
                                    </div>
                                    
                                </div>
                                <!-- ===================== Output Frequency fields starts ========== -->
                             

                                <div class="footer">
                                    <button type="submit" class="btn btn-primary ">Submit</button>
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
    
    function get_imei_list()
    {  
       let well_id = $('#well_id').val();
      
       $.ajax({
            type: 'POST',
            url: '<?php echo base_url();?>Threshold_setup_c/get_imei_no',
            data:{well_id:well_id},
            success:function(res)
            {
                res = JSON.parse(res);
                console.log(res);
                if(res.response_code==200)
                {   
                    if(res.data.length>0)
                    {
                        $('#imei_no').html('');
                        $('#imei_no').html('<option value=" ">Select Imei No</option>');
                        $.each(res.data,function(i,v){
  
                        $('#imei_no').append('<option value="'+v.imei_no+'">'+v.imei_no+'</option>');
                           
                            
                        });
                        
                    }else
                    {
                        $('#area_id').html('No Data Found');
                    }
                }else
                {
                    swal('error',data.msg,'error');
                }
              console.log();
            }
    
          });
    }

    function get_equipment()
    {
        let device_data = $('#well').val();
        $('#well_id').val(device_data.split('|')[0]);
        $('#equipment_type').val(device_data.split('|')[1]);
        
    }

   
</script>

<script type="text/javascript">
    

    function get_threshold_value()
    {
        let well_id = $('#well_id').val();
        let imei_no = $('#imei_no').val();
        $.ajax({
           url: '<?php echo base_url();?>Threshold_setup_c/get_well_threshold_details',
           type: 'POST',
           data: {well_id:well_id,imei_no:imei_no},
           success: function (res) {
                res = JSON.parse(res);
               if(res.response_code==200)
               {
                    $.each(res.data, function (i, v) {
                    if (v.imei_no == imei_no && v.well_id == well_id)
                    {
                      
                       

                       $('#out_p2p_ut').val(v.output_p2p_ut);
                       $('#out_p2p_lt').val(v.output_p2p_lt);
                     
                       $('#out_current_ut').val(v.out_current_ut);
                       $('#out_current_lt').val(v.out_current_lt);
                
                      
                  
                    }  
               });   
               }else
               {    
                   swal('error','','error');
               }
              console.log(res);
           },
       }); 
    }
</script>

