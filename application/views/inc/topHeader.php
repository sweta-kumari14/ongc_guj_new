<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark"  data-sidebar-size="lg" data-sidebar-image="none">
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
        <meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>assets/img/logo_square.png"/>
        <title>ONGC :: Oil and Natural Gas Corporation</title>
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/fontawesome/css/fontawesome.min.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/line-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/material.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/morris/morris.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/customeStyle.css">
     <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/custome_css.css">
    <!-- Datatable CSS -->
    <script src="<?php echo base_url() ?>assets/js/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/dataTables.bootstrap4.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
     <link href="<?php echo base_url(); ?>assets/local/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    
     
      

        
</head>
<body>
<div id="preloader">
        <div id="status">
           <img src="<?php echo base_url(); ?>assets/loader_img.svg" class="loader-img" alt="Loader" style="height:200px;width:100px;align-items: center;">
        </div>
    </div>
<style type="text/css">
            .parsley-errors-list>li {
            font-size: 12px;
            list-style: none;
            color: #f46a6a;
            margin-top: 5px;
            }
            .parsley-error {
            border-color: #f46a6a;
        }
       
    .footer {
        background-color: White; 
        color: black; 
        padding: 15px 0; 
    }

    .select2-selection__rendered{
        margin-top: 9px!important;
    }

    .select2-selection__arrow {
  margin-top: 20px!important;
    transform: translateY(-50%);
}


    #preloader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: #fff; 
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    #status {
        display: block;
        text-align: center;
        font-size: 16px;
        color: #333; 
    }

     #preloader {
        /* Existing styles... */
        opacity: 1;
        transition: opacity 0.5s ease-in-out;
    }

    #preloader.hide {
        opacity: 0;
        pointer-events: none;
    }



</style> 
<div class="main-wrapper">

    <script>
    document.onreadystatechange = function () {
        if (document.readyState === 'complete') {
            // Page is fully loaded, hide the preloader
            document.getElementById('preloader').style.display = 'none';
        }
    };
</script>
<script>
    document.onreadystatechange = function () {
        if (document.readyState == 'complete') {
            
            var preloader = document.getElementById('preloader');
            preloader.classList.add('hide');
            setTimeout(function () {
                preloader.style.display = 'none';
            }, 500);
        }
    };
</script>
<!-- <script type="text/javascript">
function validateSession() {
    swal({
        title: "Your Session will be Expired Soon",
        text: "Do you want to continue working or log out?",
        icon: "warning",
        buttons: {
            confirm: {
                text: "Continue",
                value: true,
                visible: true,
                className: "primary-button",
            },
            cancel: {
                text: "Log Out",
                value: null,
                visible: true,
                className: "danger-button",
                closeModal: true,
            },
        },
        dangerMode: true,
    }).then((willContinue) => {
        if (willContinue === null) {
            setTimeout(() => {
                window.location.href = "<?php echo base_url(); ?>Authentication/signout";
            }, 1000);
        } else {
           
        }
    });
}

setInterval(() => {
    validateSession();
}, 1800000);



</script> -->
<script type="text/javascript">
    if (window.top !== window.self) {
    
    window.top.location = window.self.location; 
}
</script>
<script type="text/javascript">
    var user_type = '<?php echo $this->session->userdata('user_type') ?>';
    var role_type = '<?php echo $this->session->userdata('role_type') ?>';
    // console.log(role_type);

   
    if (user_type == 1) {
        redirectForUserTypeOne();
    }



    function redirectForUserTypeOne() {
        const accessibleControllers = ['Unauthorised_c','Authentication','Dashboard_c', 'Company_c','Device_c','Device_allotment_to_company_c','Device_allotment_report_c','Running_log_c','Max_min_value_c','Access_log_report_c','Company_device_receiving_report_c','Equipment_details_report_c','Installation_details_report_c','Mis_report_c','Last_10_data_report_c','Alert_report_c','Change_password_c','Flag_unflag_report_c','Well_type_c','Selfflow_c','Selfflow_alert_c','Selfflow_historical_report_c','Overall_list_selfflow_c','Sensor_c','Item_master_c','Component_c','Tag_master_c','Flag_unflag_report_selfflow_c','Sensor_installed_report_c','Downtime_report_c','Faulty_alert_report_c','Running_log_selfflow_c','Threshold_setup_selfflow_c'];
        const currentController = '<?php echo $this->uri->segment(1) ?>'; 
        const count = countControllerOccurrences(currentController, accessibleControllers);
       
        if (count == 0) {
            // console.log('count time=', count);
            window.location.href = "<?php echo base_url(); ?>Unauthorised_c";
        }
    }


    if(user_type == 2)
    {
        redirectForUserTypeTwo();
    }

    function redirectForUserTypeTwo() {
        const accessibleControllers = ['Unauthorised_c','Authentication','Dashboard_c','Assets_c','Area_c','Site_c','Well_c','Fault_c','Equipment_c','Well_configration_c','User_c','Site_allotment_to_user_c','Device_allot_to_installer_c','Threshold_setup_c','Running_log_c','Max_min_value_c','Company_device_receiving_report_c','Alert_report_c','Installation_details_report_c','Well_replacement_report_c','Mis_report_c','Last_10_data_report_c','Technical_compalint_c','Well_running_energy_log_c','Historical_report_c','Well_Integration_c','Change_password_c','Running_Log_Graph_report_c','Company_Mis_Report_c','Temporary_off_reason_c','Device_billing_repot_c','Maintainance_Dasboard_c','Monthly_well_Details_c','Feeder_master_c','Temp_running_log_c','Offline_data_report_c','Comparison_data_c','Flag_unflag_report_c','Well_install_c','Maintenance_c','Selfflow_c','Well_type_c','Selfflow_alert_c','Selfflow_historical_report_c','Overall_list_selfflow_c','Well_setup_c','Component_c','Tag_master_c','Flag_unflag_report_selfflow_c','Sensor_installed_report_c','Downtime_report_c','Faulty_alert_report_c','Running_log_selfflow_c','Threshold_setup_selfflow_c'];
        const currentController = '<?php echo $this->uri->segment(1) ?>'; 
        const count = countControllerOccurrences(currentController, accessibleControllers);
        
        if (count == 0) {
            window.location.href = "<?php echo base_url(); ?>Unauthorised_c";
        }
    }


    if(user_type == 3  && role_type == 3)
    {
        redirectForUserTypeThree();
    }


    function redirectForUserTypeThree() {
        const accessibleControllers = ['Unauthorised_c','Authentication','Dashboard_c','Well_configration_c','Technical_compalint_c','Device_installation_c','Device_replacement_c','Device_shifting_c','Threshold_setup_c','Running_log_c','Well_running_energy_log_c','Max_min_value_c','Alert_report_c','Installation_details_report_c','Well_replacement_report_c','Historical_report_c','Well_Integration_c','Change_password_c','Running_Log_Graph_report_c','Maintainance_Dasboard_c','Monthly_well_Details_c','Device_billing_repot_c','Comparison_data_c','Flag_unflag_report_c','Well_install_c','Selfflow_c','Selfflow_alert_c','Selfflow_historical_report_c','Overall_list_selfflow_c','Device_installation_selflow_c','Flag_unflag_report_selfflow_c','Device_installation_report_c','Removal_c','Device_reinstalltion_c','Sensor_installed_report_c','Downtime_report_c','Faulty_alert_report_c','Running_log_selfflow_c','Threshold_setup_selfflow_c'];
        const currentController = '<?php echo $this->uri->segment(1) ?>'; 
        const count = countControllerOccurrences(currentController, accessibleControllers);
        
       
        if (count == 0) {
            // console.log('count time=', count);
            window.location.href = "<?php echo base_url(); ?>Unauthorised_c";
        }
    }


     if(user_type == 3  && role_type == 1 || role_type == 2)
    {
        redirectForUserTypeFour();
    }


    function redirectForUserTypeFour() {
        const accessibleControllers = ['Unauthorised_c','Authentication','Dashboard_c','Well_configration_c','Technical_compalint_c','Running_log_c','Well_running_energy_log_c','Alert_report_c','Historical_report_c','Well_Integration_c','Change_password_c','Running_Log_Graph_report_c','Monthly_well_Details_c','Device_billing_repot_c','Comparison_data_c','Flag_unflag_report_c','Selfflow_c','Selfflow_alert_c','Selfflow_historical_report_c','Overall_list_selfflow_c','Flag_unflag_report_selfflow_c','Sensor_installed_report_c','Downtime_report_c.php','Faulty_alert_report_c','Running_log_selfflow_c','Threshold_setup_selfflow_c'];
        const currentController = '<?php echo $this->uri->segment(1) ?>'; 
        const count = countControllerOccurrences(currentController, accessibleControllers);
        
       
        if (count == 0) {
           
            window.location.href = "<?php echo base_url(); ?>Unauthorised_c";
        }
    }

   
    function countControllerOccurrences(currentController, accessibleControllers) {
        let count = 0;
        for (let i = 0; i < accessibleControllers.length; i++) {
            if (accessibleControllers[i] === currentController) {
                count++;
            }
        }
        return count;
    }
</script>
<!-- <script type="text/javascript">
   
  
get_details_session();
function get_details_session() {
    let id = "<?php echo $this->session->userdata('id') ?>";
    var session_id = "<?php echo $_SESSION['__ci_last_regenerate'];?>";
    $.ajax({
        url:'<?php echo base_url(); ?>Authentication/session_details',
        method:'POST',
        data:{id:id},
        success:function(res) {
            var response = JSON.parse(res);
            if(response.response_code == 200) {
                
                var sessionTocken = response.data[0].sessionTocken;
                compareSessionTokens(sessionTocken, session_id);
            }
        }
    });
}
 function compareSessionTokens(sessionTocken, session_id) {
    if (sessionTocken == session_id) {
        
    }else{
        
         swal('Warning', 'Your account has been logged into from another device.', 'error');
         setTimeout(()=>{window.location.href = '<?php echo base_url("Authentication/signout"); ?>';},1000)

         
        }
    }
 
</script> -->