<div class="page-wrapper">
    <div class="content container-fluid pb-0">
    	<div class="page-header">
			<div class="content-page-header">
				<h5>Well Type</h5>
			</div>	
		</div>
			<div class="row">					
						<!-- Lightbox -->
                        <div class="col-lg-12">
                            <div class="card">
                               
                                <div class="card-body">
                                   <div class="row align-items-center">
                                        <div class="col">
                                           <h4 class="header-title mb-4"><b>Edit Well Type</b></h4>
                                        </div>
                                        <div class="col-auto float-end ms-auto">
                                             <a href="<?php echo base_url('Well_type_c'); ?>">
                                               <button type="button" class="btn btn-sm btn-rounded btn-success">Back</button>
                                            </a>
                                        </div>
                                    </div>


                                   <form class="custom-validation" method="POST" action="<?php echo base_url('Well_type_c/update_well_type'); ?>" enctype="multipart/form-data">
                                <div class="row">
                                    <input type="hidden" id="id" name="id" value="<?php echo $this->uri->segment(3); ?>">
                                     <div class="form-group col-md-6">
                                         <h5><b>Well Type Name </b><span class="text-danger">*</span></h5>
                                          <input type="text" name="well_type_name" id="well_type_names" class="form-control" required onkeyup="this.value = this.value.replace(/[^a-zA-Z- ]/g,'')" value="<?php echo $well_type_list[0]['well_type_name']; ?>">
        
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
