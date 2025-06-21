<div class="page-wrapper">
    <div class="content container-fluid pb-0">
        <div class="page-header">
            <div class="content-page-header">
                <h5>Area</h5>
            </div>  
        </div>
            <div class="row">                   
                        <!-- Lightbox -->
                        <div class="col-lg-12">
                            <div class="card">
                               
                                <div class="card-body">
                                   <div class="row align-items-center">
                                        <div class="col">
                                           <h4 class="header-title mb-4"><b>Add Area</b></h4>
                                        </div>
                                        <div class="col-auto float-end ms-auto">
                                             <a href="<?php echo base_url('Area_c'); ?>">
                                               <button type="button" class="btn btn-sm btn-rounded btn-success">Back</button>
                                            </a>
                                        </div>
                                    </div>

                        <div class="card-body">
                            <form class="custom-validation" method="POST" action="<?php echo base_url('Area_c/add_area'); ?>" enctype="multipart/form-data">
                                    <div class="row">
                                    <div class="form-group col-md-6">
                                        <h5><b>Assets Name <span style="color:red">*</span></b></h5>
                                        <select name="assets_name" id="assets_name" class="form-control select2"  required>
                                            <option value="">Select</option>
                                            <?php 
                                            if(!empty($assets_list))
                                            {
                                                foreach ($assets_list as $key => $value) 
                                                {
                                                    ?>
                                                        <option value="<?php echo $value['id']; ?>"> <?php echo $value['assets_name']; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6 ">
                                        <h5><b>Area Name <span style="color:red">*</span></b></h5>
                                       <input type="text" name="area_name" id="area_name" class="form-control" required onkeyup="this.value = this.value.replace(/[^a-zA-Z- ]/g,'')">
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
            </div>