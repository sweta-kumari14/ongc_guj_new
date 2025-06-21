<div class="page-wrapper">
    <div class="content container-fluid pb-0">
    	<div class="page-header">
			<div class="content-page-header">
				<h5>Equipment</h5>
			</div>	
		</div>
			<div class="row">					
						<!-- Lightbox -->
                        <div class="col-lg-12">
                            <div class="card">
                               
                                <div class="card-body">
                                   <div class="row align-items-center">
                                        <div class="col">
                                           <h4 class="header-title mb-4"><b>Add Equipment</b></h4>
                                        </div>
                                        <div class="col-auto float-end ms-auto">
                                             <a href="<?php echo base_url('Equipment_c'); ?>">
                                               <button type="button" class="btn btn-sm btn-rounded btn-success">Back</button>
                                            </a>
                                        </div>
                                    </div>


                                    <form class="custom-validation" method="POST" action="<?php echo base_url('Equipment_c/add_equipment'); ?>" enctype="multipart/form-data">
                                <div class="row">
                                   <div class="col-md-6 mt-2">
                                       <h5><b>Equipment Name <span style="color:red">*</span></b></h5>
                                       <input type="text" name="equipment_name" id="equipment_name" class="form-control" required onkeyup="this.value = this.value.replace(/[^a-zA-Z0-9- ]/g,'')">
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
