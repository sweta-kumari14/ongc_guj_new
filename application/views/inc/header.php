
	<div class="header">
		     
			<!-- Logo -->
	      <div class="header-left">

	           <a href="#" class="logo">
					 <img src="<?php echo base_url() ?>assets/img/logo.png" width="60" style="border-radius: 50%; height:50">

				</a>
				<a href="#" class="logo2">
					 <img src="<?php echo base_url() ?>assets/img/logo.png" width="60" style="border-radius: 50%; height:50">
				</a>
	      </div>
			<!-- /Logo -->
			
			<a id="toggle_btn" href="javascript:void(0);">
				<span class="bar-icon">
					<span></span>
					<span></span>
					<span></span>
				</span>
			</a>
			
			<!-- Header Title -->
	      <div class="page-title-box">
				<h3>Intelligent Well Monitoring System</h3>
	      </div>
			
			
			<a id="mobile_btn" class="mobile_btn" href="#sidebar"><i class="fa-solid fa-bars"></i></a>
			
			<!-- Header Menu -->
			<ul class="nav user-menu">

				<li class="nav-item dropdown has-arrow main-drop">
					<a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
						
					
						<?php
						   if ($this->session->userdata('user_type')=='1')
                           {
                                echo "Super-Admin";
	                        }elseif($this->session->userdata('user_type')=='2')
	                        {
	                            echo $this->session->userdata('name');

	                        }elseif($this->session->userdata('user_type')=='3')
	                        {
	                            echo $this->session->userdata('name');

	                        }elseif($this->session->userdata('user_type')=='4')
	                        {
	                            echo $this->session->userdata('name');

	                        }else{
	                        	
	                            echo "";
	                        }
	                      ?>

					</a>
					<div class="dropdown-menu">
						<a class="dropdown-item" href="<?php echo base_url('Change_password_c'); ?>"> <i class="fa fa-key  mx-2"></i>Change Password</a>
						<a class="dropdown-item" href="<?php echo base_url('Authentication/signout'); ?>"> <i class="fa-solid fa-power-off mx-2"></i>Logout</a>
					</div>
				</li>
			</ul>
			<!-- /Header Menu -->
			
			<!-- Mobile Menu -->
			<div class="dropdown mobile-user-menu">
				<a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-ellipsis-vertical"></i></a>
				<div class="dropdown-menu dropdown-menu-right">
					
					<a class="dropdown-item" href="<?php echo base_url('Change_password_c'); ?>"> <i class="fa fa-key  mx-2"></i>Change Password</a>
					<a class="dropdown-item" href="<?php echo base_url('Authentication/signout'); ?>"><i class="fa-solid fa-power-off mx-2"></i>Logout</a>
				</div>
			</div>
			<!-- /Mobile Menu -->
			
	</div>
		<!-- /Header -->
		
		
	