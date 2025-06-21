<div class="page-wrapper">
    <div class="content container-fluid pb-0">
    	<div class="page-header">
			<div class="content-page-header">
				<h5>Feeder</h5>
			</div>	
		</div>
			<div class="row">					
						<!-- Lightbox -->
                        <div class="col-lg-12">
                            <div class="card">
                               
                                <div class="card-body">
                                   <div class="row align-items-center">
                                        <div class="col">
                                           <h4 class="header-title mb-4"><b>Edit Feeder</b></h4>
                                        </div>
                                        <div class="col-auto float-end ms-auto">
                                             <a href="<?php echo base_url('Feeder_master_c'); ?>">
                                               <button type="button" class="btn btn-sm btn-rounded btn-success">Back</button>
                                            </a>
                                        </div>
                                    </div>
                                   <form class="custom-validation" method="POST" action="<?php echo base_url('Feeder_master_c/update_feeder'); ?>" enctype="multipart/form-data">
                                <div class="row">
                                    <input type="hidden" id="id" name="id" value="<?php echo $this->uri->segment(3); ?>">
                                    <div class="col-md-6 mt-2">
                                        <h4><b>Feeder Name <span style="color:red">*</span></b></h4>
                                        <input type="text" name="feeder_name" id="feeder_name" class="form-control" value="<?php echo $feeder_list[0]['feeder_name']; ?>" required onkeyup="this.value = this.value.replace(/[^a-zA-Z0-9- ]/g,'')">
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
