re<!-- Sidebar -->
	<div class="sidebar" id="sidebar">
		<div class="sidebar-inner slimscroll">
			<div id="sidebar-menu" class="sidebar-menu">
				<ul class="sidebar-vertical">
					
					<li class="submenu">
						<a href="#"><i class="la la-home active"></i> <span>Dashboard</span> <span class="menu-arrow"></span></a>
						<ul>
							<li><a  href="<?php echo base_url('Dashboard_c'); ?>">Area Dashboard</a></li>
							<li><a  href="<?php echo base_url('Selfflow_c'); ?>">Self-flow Dashboard</a></li>


							<?php if($this->session->userdata('user_type')=='2')
								{
									?>
									<li><a  href="<?php echo base_url('Maintainance_Dasboard_c'); ?>">Maintainance</a></li>
									<?php
								}
							?>

							<?php  if($this->session->userdata('user_type')=='3' && $this->session->userdata('role_type')=='3')
              {						

              ?>
							<li><a  href="<?php echo base_url('Technical_compalint_c/complaint_details_admin_page'); ?>">Complaint Dashboard</a></li>
							
							<li><a href="<?php echo base_url('Well_Integration_c/well_integration_report'); ?>">Well Add/Replace</a></li>

							

							<li><a  href="<?php echo base_url('Maintainance_Dasboard_c'); ?>">Maintainance</a></li>


							<?php
                   }
                   ?>
                     <?php  if($this->session->userdata('user_type')=='3' && $this->session->userdata('role_type')=='1'  || $this->session->userdata('role_type')=='2')
                     {

                	?>
							   <li><a  href="<?php echo base_url('Technical_compalint_c'); ?>">Complaint Dashboard</a></li>
								 <li><a href="<?php echo base_url('Well_Integration_c/well_integration_report'); ?>">Well Add/Replace</a></li>
							<?Php
						}
						?>

							
						</ul>
					</li>
				   <?php  if($this->session->userdata('user_type')=='1')
                     {

                	?>
					<li class="submenu">
						<a href="#"><i class="la la-users"></i> <span>Master</span> <span class="menu-arrow"></span></a>
						<ul>
							<li><a href="<?php echo base_url('Company_c'); ?>" class="slide-item">Company</a></li>
              <li><a href="<?php echo base_url('Device_c'); ?>" class="slide-item">Device</a></li>
							
						</ul>
					</li>

					<li> 
						<a href="#"><i class="la la-object-ungroup"></i> <span>Device Allotment</span><span class="menu-arrow"></span></a>  
						<ul>
					         
							  <li><a href="<?php echo base_url('Device_allotment_to_company_c'); ?>" class="slide-item">Device Allotment</a></li>
							  <li><a href="<?php echo base_url('Device_allotment_report_c'); ?>" class="slide-item">Device Allotment Report</a></li>

					       
							
							  
                        </ul>
					</li>

					<li class="submenu">
						<a href="#"><i class="la la-pie-chart"></i> <span> Reports </span> <span class="menu-arrow"></span></a>
						<ul>
							<li><a href="<?php echo base_url('Running_log_c'); ?>" class="slide-item">Running Log Report</a></li>
							<li><a href="<?php echo base_url('Flag_unflag_report_c'); ?>" class="slide-item">Flag Unflag Log Report</a></li>
								<li><a href="<?php echo base_url('Flag_unflag_report_selfflow_c'); ?>" class="slide-item">Flag Unflag selfflow Log Report</a></li>


              <li><a href="<?php echo base_url('Max_min_value_c'); ?>" class="slide-item">Max Min Value Report</a></li>
								
							
							<li><a href="<?php echo base_url('Access_log_report_c'); ?>" class="slide-item">Access Log Report</a></li>
							<li><a href="<?php echo base_url('Company_device_receiving_report_c/Device_allotment_to_installer'); ?>" class="slide-item">Allotment to Installer Report</a></li>
							<li><a href="<?php echo base_url('Company_device_receiving_report_c/userwise_site_allotment'); ?>" class="slide-item">Site Allotment Report</a></li>
							<li><a href="<?php echo base_url('Equipment_details_report_c'); ?>" class="slide-item">Equipment Details Report</a></li>
							
							
							<li><a href="<?php echo base_url('Installation_details_report_c'); ?>">Installation Details </a></li>
							<li><a href="<?php echo base_url('Installation_details_report_c/replacement_report_page'); ?>">Replacement Details </a></li>
							
							
							<li><a href="<?php echo base_url('Mis_report_c'); ?>">Device Details Report</a></li>
							<li><a href="<?php echo base_url('Last_10_data_report_c'); ?>"> Last 10 Data Report </a></li>	
						
						</ul>
					</li>

					<?php
                   }
                   ?>
                     <?php  if($this->session->userdata('user_type')=='2')
                     {

                	?>
                	<li class="submenu">
						<a href="#"><i class="la la-users"></i> <span>Master</span> <span class="menu-arrow"></span></a>
						<ul>
						  <li><a href="<?php echo base_url('Assets_c'); ?>">Assets</a></li>
                          <li><a href="<?php echo base_url('Area_c'); ?>">Area</a></li>
                          <li><a href="<?php echo base_url('Site_c'); ?>">Site</a></li>
                          <li><a href="<?php echo base_url('Well_c'); ?>">Well</a></li>
                          <li><a href="<?php echo base_url('Fault_c'); ?>">Fault</a></li>
                          <li><a href="<?php echo base_url('Equipment_c'); ?>">Equipment</a></li>
                          <li><a href="<?php echo base_url('Well_configration_c'); ?>">Well Scheduling</a></li>
                          <li><a href="<?php echo base_url('Feeder_master_c'); ?>">Feeder</a></li>
                          <li><a href="<?php echo base_url('Well_install_c'); ?>">Well Re-Installation</a></li>
                          <li><a href="<?php echo base_url('Temporary_off_reason_c'); ?>">Temporary Off Reason</a></li>
                          <li><a href="<?php echo base_url('Well_type_c'); ?>">Well type</a></li>
                          <li><a href="<?php echo base_url('Tag_master_c');?>"  class="slide-item">tag list</a></li>
						              <li><a href="<?php echo base_url('Component_c');?>"  class="slide-item">component</a></li>
   
                        </ul>
                    </li>
               
          


					<li> 
				     <a href="#"><i class="la la-user"></i> <span>User</span><span class="menu-arrow"></span></a>
						<ul>
							 <li><a href="<?php echo base_url('User_c'); ?>" class="slide-item">User</a></li>
							 <li><a href="<?php echo base_url('Site_allotment_to_user_c'); ?>" class="slide-item">User Allotment</a></li>
							 <li><a href="<?php echo base_url('Device_allot_to_installer_c'); ?>" class="slide-item">Installer Device Allotment</a></li>
							 <li><a href="<?php echo base_url('Well_setup_c/cgl_well_setup_list'); ?>" class="slide-item">Well Setup Formula</a></li>
						</ul>
					</li>

					<li> 
						<a href="#"><i class="la la-object-ungroup"></i> <span>Threshold Setup</span><span class="menu-arrow"></span></a>
						<ul>
					       <!-- <li><a href="<?php echo base_url('Equipment_details_c'); ?>" class="slide-item">Equipment Details</a></li> -->
					       <li><a href="<?php echo base_url('Threshold_setup_c'); ?>" class="slide-item">Threshold Setup</a></li>

					       
							
							  
              </ul>
					</li>
					<li> 
						<a href="#"><i class="la la-object-ungroup"></i> <span>Billing Report</span><span class="menu-arrow"></span></a>
						<ul>
					      <li><a href="<?php echo base_url('Monthly__Details_c'); ?>"> Well Details Monthly Report </a></li>
					      <li><a href="<?php echo base_url('Device_billing_repot_c/device_performance'); ?>" class="slide-item">Device  Performance Log Report</a></li>
					       
              </ul>
					</li>
				
					<li class="submenu">
						<a href="#"><i class="la la-pie-chart"></i> <span> Reports </span> <span class="menu-arrow"></span></a>
						<ul>
							<li>
                  <a class='tp-link' href="<?php echo base_url() ?>Maintenance_c">Maintenance Log Report</a>
              </li>
							<li><a href="<?php echo base_url('Running_log_c'); ?>" class="slide-item">Running Log Report</a></li>
							<li><a href="<?php echo base_url('Well_running_energy_log_c'); ?>">Well Performance Report </a></li>
							<li><a href="<?php echo base_url('Flag_unflag_report_c'); ?>" class="slide-item">Flag Unflag Log Report</a></li>
							<li><a href="<?php echo base_url('Flag_unflag_report_selfflow_c'); ?>" class="slide-item">Flag Unflag selfflow Log Report</a></li>
							
              <li><a href="<?php echo base_url('Max_min_value_c'); ?>" class="slide-item">Max Min Value Report</a></li>
							<li><a href="<?php echo base_url('Alert_report_c'); ?>" class="slide-item">Alert Log Report</a></li>
							
							<!-- <li><a href="<?php echo base_url('Offline_data_report_c'); ?>">Well Offline Report </a></li> -->
							
							<li><a href="<?php echo base_url('Company_Mis_Report_c'); ?>" class="slide-item">Device Log Report</a></li>
							
							<li><a href="<?php echo base_url('Company_device_receiving_report_c'); ?>" class="slide-item">Device Receiving Report</a></li>
							<li><a href="<?php echo base_url('Company_device_receiving_report_c/Device_allotment_to_installer'); ?>" class="slide-item">Allotment to Installer Report</a></li>
							<li><a href="<?php echo base_url('Company_device_receiving_report_c/userwise_site_allotment'); ?>" class="slide-item">Site Allotment Report</a></li>
							<!-- <li><a href="<?php echo base_url('Equipment_details_report_c'); ?>" class="slide-item">Equipment Details Report</a></li> -->
							<li><a href="<?php echo base_url('Well_configration_c/Well_configration_details_report'); ?>"> Well Scheduling Report </a></li>		
						
						
							<li><a href="<?php echo base_url('Installation_details_report_c'); ?>">Installation Details </a></li>
							<li><a href="<?php echo base_url('Installation_details_report_c/replacement_report_page'); ?>">Replacement Details </a></li>
							
							<li><a href="<?php echo base_url('Well_replacement_report_c'); ?>">Device Shifting Report</a></li>
							<li><a href="<?php echo base_url('Mis_report_c'); ?>">Device Details Report</a></li>
							<li><a href="<?php echo base_url('Last_10_data_report_c'); ?>"> Last 10 Data Report </a></li>
							<li><a href="<?php echo base_url('Technical_compalint_c/get_report_log_complaints'); ?>">Complaint Log Report </a></li>
							
								<li><a href="<?php echo base_url('Historical_report_c'); ?>" class="slide-item">Historical Report</a></li>
								<li><a href="<?php echo base_url('Well_Integration_c/well_integration_report'); ?>" class="slide-item">Well Add/Replace Report</a></li>
								
								<li><a href="<?php echo base_url('Maintainance_Dasboard_c/maintainance_Report'); ?>" class="slide-item">Maintainance Report</a></li>
					
						</ul>
					</li>
					<li class="submenu">
						<a href="#"><i class="la la-pie-chart"></i> <span>  Self-Flow Reports </span> <span class="menu-arrow"></span></a>
						<ul>
							
							<li><a href="<?php echo base_url('Selfflow_alert_c'); ?>" class="slide-item">Alert Log Report</a></li>
							
								<li><a href="<?php echo base_url('Selfflow_historical_report_c'); ?>" class="slide-item">Historical Report</a></li>

								<li><a href="<?php echo base_url('Selfflow_historical_report_c/historical_graph_page'); ?>" class="slide-item">Historical Report Graph</a></li>
					
						</ul>
					</li>

							<li class="submenu">
						<a href="#"><i class="la la-pie-chart"></i> <span> Graphical Reports </span> <span class="menu-arrow"></span></a>
						<ul>
							<li><a href="<?php echo base_url('Running_Log_Graph_report_c'); ?>" class="slide-item">Running Graphs</a></li>
							<li><a href="<?php echo base_url('Comparison_data_c'); ?>" class="slide-item">Comparison Graphs</a></li>
					
						</ul>
					</li>

					
				 <?php
          }
        ?>

            <?php  if($this->session->userdata('user_type')=='3' && $this->session->userdata('role_type') == '3')
             {
             ?>

             <li>
             	<a href="#"><i class="la la-user"></i> <span>Well</span><span class="menu-arrow"></span></a>
						<ul>
							

              <li><a href="<?php echo base_url('Well_configration_c'); ?>">Well Scheduling</a></li>
              <li><a href="<?php echo base_url('Well_Integration_c/update_well_feeder'); ?>">Change Well Feeder</a></li>
              
            </ul>
          </li>

          <li> 
						<a href="#"><i class="la la-files-o"></i> <span>Setup</span><span class="menu-arrow"></span></a>
						<ul>
							   <li><a href="<?php echo base_url('Well_install_c'); ?>">Well Re-Installation</a></li>
					       <li><a href="<?php echo base_url('Device_installation_c'); ?>" class="slide-item">Device Installation</a></li>
					       <li><a href="<?php echo base_url('Device_replacement_c'); ?>" class="slide-item">Device  Replacement</a></li>
					        <li><a href="<?php echo base_url('Device_shifting_c'); ?>" class="slide-item">Device Shifting</a></li>
					        <li><a href="<?php echo base_url('Device_installation_selflow_c'); ?>" class="slide-item">Sensor Installation</a></li>
					    </ul>
					</li>
					<li>
						<a href="#"><i class="la la-files-o"></i> <span>Selfflow-Setup</span><span class="menu-arrow"></span></a>
						<ul>
					       <li><a href="<?php echo base_url('Device_installation_selflow_c'); ?>" class="slide-item">Device Installation</a></li></li>
					         <li><a href="<?php echo base_url('Removal_c'); ?>" class="slide-item">Removal</a></li>
					    </ul>
					</li>

					<li> 
						<a href="#"><i class="la la-object-ungroup"></i> <span>Threshold Setup</span><span class="menu-arrow"></span></a>
						<ul>
					       <!-- <li><a href="<?php echo base_url('Equipment_details_c'); ?>" class="slide-item">Equipment Details</a></li> -->
					       <li><a href="<?php echo base_url('Threshold_setup_c'); ?>" class="slide-item">Threshold Setup</a></li>
					       
							
							  
              </ul>
					</li>
					<li> 
						<a href="#"><i class="la la-object-ungroup"></i> <span>Billing Report</span><span class="menu-arrow"></span></a>
						<ul>
					      <li><a href="<?php echo base_url('Monthly_well_Details_c'); ?>"> Well Details Monthly Report </a></li>
					      <li><a href="<?php echo base_url('Device_billing_repot_c/device_performance'); ?>" class="slide-item">Device  Performance Log Report</a></li>
					       
              </ul>
					</li>
            <li class="submenu">
						<a href="#"><i class="la la-pie-chart"></i> <span> Reports </span> <span class="menu-arrow"></span></a>
						<ul>
							<li><a href="<?php echo base_url('Running_log_c'); ?>" class="slide-item">Running Log Report</a></li>
							<li><a href="<?php echo base_url('Well_running_energy_log_c'); ?>">Well Performance Report </a></li>
							<li><a href="<?php echo base_url('Flag_unflag_report_c'); ?>" class="slide-item">Flag Unflag Log Report</a></li>
							<li><a href="<?php echo base_url('Flag_unflag_report_selfflow_c'); ?>" class="slide-item">Flag Unflag selfflow Log Report</a></li>

							
              <li><a href="<?php echo base_url('Max_min_value_c'); ?>" class="slide-item">Max Min Value Report</a></li>
							<li><a href="<?php echo base_url('Alert_report_c'); ?>" class="slide-item">Alert Log Report</a></li>
							
							<!-- <li><a href="<?php echo base_url('Equipment_details_report_c'); ?>" class="slide-item">Equipment Details Report</a></li> -->
							
							<li><a href="<?php echo base_url('Well_configration_c/Well_configration_details_report'); ?>"> Well Scheduling Report </a></li>		
							<li><a href="<?php echo base_url('Technical_compalint_c/get_report_log_complaints'); ?>">Complaint Log Report </a></li>	
							<li><a href="<?php echo base_url('Installation_details_report_c'); ?>">Installation Details </a></li>
							<li><a href="<?php echo base_url('Installation_details_report_c/replacement_report_page'); ?>">Replacement Details </a></li>

							<li><a href="<?php echo base_url('Well_replacement_report_c'); ?>">Device Shifting Report</a></li>
								<li><a href="<?php echo base_url('Historical_report_c'); ?>" class="slide-item">Historical Report</a></li>
								<li><a href="<?php echo base_url('Well_Integration_c/well_integration_report'); ?>" class="slide-item">Well Add/Replace Report</a></li>
								

               <li><a href="<?php echo base_url('Maintainance_Dasboard_c/maintainance_Report'); ?>" class="slide-item">Maintainance Report</a></li>
					
												
						</ul>
					</li>
						<li class="submenu">
						<a href="#"><i class="la la-pie-chart"></i> <span> Graphical Reports </span> <span class="menu-arrow"></span></a>
						<ul>
							<li><a href="<?php echo base_url('Running_Log_Graph_report_c'); ?>" class="slide-item">Running Graphs</a></li>
							<li><a href="<?php echo base_url('Comparison_data_c'); ?>" class="slide-item">Comparison Graphs</a></li>
					
						</ul>
					</li>
					 <?php
                   }
                   ?>

            <?php  if($this->session->userdata('user_type')=='3' && $this->session->userdata('role_type') == '2')
             {
             ?>
            <li>
             	<a href="#"><i class="la la-user"></i> <span>Well</span><span class="menu-arrow"></span></a>
						<ul>
							

              <li><a href="<?php echo base_url('Well_configration_c'); ?>">Well Scheduling</a></li>
                <li><a href="<?php echo base_url('Well_Integration_c'); ?>">Well Add/Replace</a></li>
                <li><a href="<?php echo base_url('Well_Integration_c/update_well_feeder'); ?>">Change Well Feeder</a></li>
            </ul>
          </li>

         
            <li class="submenu">
						<a href="#"><i class="la la-object-ungroup"></i> </i> <span> Reports </span> <span class="menu-arrow"></span></a>
						<ul>
							<li><a href="<?php echo base_url('Running_log_c'); ?>" class="slide-item">Running Log Report</a></li>
							<li><a href="<?php echo base_url('Well_running_energy_log_c'); ?>">Well Performance Report </a></li>
							<li><a href="<?php echo base_url('Flag_unflag_report_c'); ?>" class="slide-item">Flag Unflag Log Report</a></li>
							<li><a href="<?php echo base_url('Flag_unflag_report_selfflow_c'); ?>" class="slide-item">Flag Unflag selfflow Log Report</a></li>
							
              <li><a href="<?php echo base_url('Device_billing_repot_c/device_performance'); ?>" class="slide-item">Device  Performance Log Report</a></li>

              <li><a href="<?php echo base_url('Monthly_well_Details_c'); ?>"> Well Details Monthly Report </a></li>
							<li><a href="<?php echo base_url('Alert_report_c'); ?>" class="slide-item">Alert Log Report</a></li>


							<li><a href="<?php echo base_url('Historical_report_c'); ?>" class="slide-item">Historical Report</a></li>
							<li><a href="<?php echo base_url('Well_configration_c/Well_configration_details_report'); ?>"> Well Scheduling Report </a></li>		
							<li><a href="<?php echo base_url('Technical_compalint_c/get_report_log_complaints'); ?>">Complain Log Report </a></li>	
							<li><a href="<?php echo base_url('Well_Integration_c/well_integration_report'); ?>" class="slide-item">Well Add/Replace Report</a></li>
									
						</ul>
					 </li>
					<li class="submenu">
						<a href="#"><i class="la la-pie-chart"></i> <span> Graphical Reports </span> <span class="menu-arrow"></span></a>
						<ul>
							<li><a href="<?php echo base_url('Running_Log_Graph_report_c'); ?>" class="slide-item">Running Graphs</a></li>
							<li><a href="<?php echo base_url('Comparison_data_c'); ?>" class="slide-item">Comparison Graphs</a></li>
					
						</ul>
					</li>
					 <?php
					    }
				    ?>

				    <?php  if($this->session->userdata('user_type')=='3' && $this->session->userdata('role_type') == '1')
             {
             ?>
            <li>
             	<a href="#"><i class="la la-user"></i> <span>Well</span><span class="menu-arrow"></span></a>
						<ul>
							

              <li><a href="<?php echo base_url('Well_configration_c'); ?>">Well Scheduling</a></li>
                <li><a href="<?php echo base_url('Well_Integration_c/well_integration_report'); ?>">Well Add/Replace</a></li>
                <li><a href="<?php echo base_url('Well_Integration_c/update_well_feeder'); ?>">Change Well Feeder</a></li>
            </ul>
          </li>

         
            <li class="submenu">
						<a href="#"><i class="la la-object-ungroup"></i>  <span> Reports </span> <span class="menu-arrow"></span></a>
						<ul>
							<li><a href="<?php echo base_url('Running_log_c'); ?>" class="slide-item">Running Log Report</a></li>
							<li><a href="<?php echo base_url('Well_running_energy_log_c'); ?>">Well Performance Report </a></li>
							<li><a href="<?php echo base_url('Flag_unflag_report_c'); ?>" class="slide-item">Flag Unflag Log Report</a></li>
							<li><a href="<?php echo base_url('Flag_unflag_report_selfflow_c'); ?>" class="slide-item">Flag Unflag selfflow Log Report</a></li>
							
              <li><a href="<?php echo base_url('Device_billing_repot_c/device_performance'); ?>" class="slide-item">Device  Performance Log Report</a></li>
              <li><a href="<?php echo base_url('Monthly_well_Details_c'); ?>"> Well Details Monthly Report </a></li>
							<li><a href="<?php echo base_url('Alert_report_c'); ?>" class="slide-item">Alert Log Report</a></li>

							<li><a href="<?php echo base_url('Historical_report_c'); ?>" class="slide-item">Historical Report</a></li>
							<li><a href="<?php echo base_url('Well_configration_c/Well_configration_details_report'); ?>"> Well Scheduling Report </a></li>		
							<li><a href="<?php echo base_url('Technical_compalint_c/get_report_log_complaints'); ?>">Complain Log Report </a></li>	
							<li><a href="<?php echo base_url('Well_Integration_c/well_integration_report'); ?>" class="slide-item">Well Add/Replace Report</a></li>
												
						</ul>
					 </li>

						<li class="submenu">
						<a href="#"><i class="la la-pie-chart"></i> <span> Graphical Reports </span> <span class="menu-arrow"></span></a>
						<ul>
							<li><a href="<?php echo base_url('Running_Log_Graph_report_c'); ?>" class="slide-item">Running Graphs</a></li>
							<li><a href="<?php echo base_url('Comparison_data_c'); ?>" class="slide-item">Comparison Graphs</a></li>
					
						</ul>
					</li>					 <?php
					    }
				    ?>
                	
					
					<li>
						<a href="<?php echo base_url('Change_password_c'); ?>"><i class="la la-key"></i><span>Change Password</span></a>
						
					</li>
					<li>
						<a href="<?php echo base_url('Authentication/signout'); ?>"><i class="fa fa-power-off"></i><span>Log Out</span></a>
						
					</li>
					 
					
						</ul>
					</li>
				</ul>
				
			</div>
		</div>
	</div>
	
	<!-- /Sidebar -->
	
	