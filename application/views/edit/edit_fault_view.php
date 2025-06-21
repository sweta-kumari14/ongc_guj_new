<div class="page-wrapper">
    <div class="content container-fluid pb-0">
    	<div class="page-header">
			<div class="content-page-header">
				<h5>Fault</h5>
			</div>	
		</div>
			<div class="row">					
						<!-- Lightbox -->
                        <div class="col-lg-12">
                            <div class="card">
                               
                                <div class="card-body">
                                   <div class="row align-items-center">
                                        <div class="col">
                                           <h4 class="header-title mb-4"><b>Edit Fault</b></h4>
                                        </div>
                                        <div class="col-auto float-end ms-auto">
                                             <a href="<?php echo base_url('Fault_c'); ?>">
                                               <button type="button" class="btn btn-sm btn-rounded btn-success">Back</button>
                                            </a>
                                        </div>
                                    </div>


                                   <form class="custom-validation" method="POST" action="<?php echo base_url('Fault_c/update_faults'); ?>" enctype="multipart/form-data">
                                <div class="row">
                                    <input type="hidden" id="id" name="id" value="<?php echo $this->uri->segment(3); ?>">
                                        <div class="form-group col-md-6 mt-2">
                                            <h5><b>Fault Name </b><span class="text-danger">*</span></h5>
                                            <input type="text" name="fault_name" id="fault_names" class="form-control" required onkeyup="this.value = this.value.replace(/[^a-zA-Z- ]/g,'')" value="<?php echo $fault_list[0]['fault_name']; ?>">
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <h5><b>Choose Color</b></h5>
                                             <input type="color" id="color_code" name="color_code" value="<?php echo $fault_list[0]['color_code']; ?>" style="cursor: pointer;">
                                                    
                                        </div>

                                   </div>
                                <div class="footer mt-4">
                                    <div>
                                        <button type="submit" class="btn btn-sm btn-primary" >Update</button>
                                    </div>
                                </div>
                                
                            </form>
                                    
                        </div>
                    </div>
                </div>
            </div>
        </div>                  
	
	</div>			

