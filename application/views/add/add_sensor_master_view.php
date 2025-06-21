<div class="page-wrapper">
    <div class="content container-fluid pb-0">
        <div class="page-header">
            <div class="content-page-header">
                <h5>Sensor</h5>
            </div>  
        </div>
            <div class="row">                   
                        <!-- Lightbox -->
                        <div class="col-lg-12">
                            <div class="card">
                               
                                <div class="card-body">
                                   <div class="row align-items-center">
                                        <div class="col">
                                           <h4 class="header-title mb-4"><b>Add Sensor</b></h4>
                                        </div>
                                        <div class="col-auto float-end ms-auto">
                                             <a href="<?php echo base_url('Sensor_c'); ?>">
                                               <button type="button" class="btn btn-sm btn-rounded btn-success">Back</button>
                                            </a>
                                        </div>
                                    </div>


                                    <form role="form" class="custom-validation" method="POST" action="<?php echo base_url('Sensor_c/add_sensor') ?>" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-6 mt-2">
                                                <h5><b>Sensor No</b><span style="color:red;">*</span></h5>
                                                <input data-parsley-type="alphanum" name="sensor_no" id="sensor_no" class="form-control" required maxlength="20" minlength="10" onkeyup="this.value = this.value.replace(/[^a-zA-Z0-9]/g,'')">
                                            </div>

                                            <div class="col-md-6 mt-2">
                                                <h5><b>Sensor Name</b><span style="color:red;">*</span></h5>
                                                <input type="text" name="sensor_name" id="sensor_name" class="form-control" required onkeyup="this.value = this.value.replace(/[<>]/g,'')">
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
                                                <h5><b>Manufactur Month</b><span style="color:red;">*</span></h5>
                                                <input type="text" name="manufacturer_month" id="manufacturer_month" class="form-control" required onkeyup="this.value = this.value.replace(/[^a-zA-Z]/g,'')">
                                            </div>

                                            <div class="col-md-6 mt-2">
                                                <h5><b>Manufacturer Year</b><span style="color:red;">*</span></h5>
                                                <select name="manufacturer_year" id="manufacturer_year" class="form-control" >
    <?php
        $current_year = date('Y');
        for ($i = $current_year - 3; $i < $current_year + 3; $i++) {
            echo '<option value="'.$i.'"';
            if ($i == $current_year) {
                echo ' selected="selected"';
            }
            echo '>'.$i.'</option>';
        }
    ?>
</select>

                                                
                                            </div>


                                            
                                        </div>
                                        <div class="footer mt-4">
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
