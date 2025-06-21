<style>
.colored-hr {
    border-top: 2px solid orange; 
}

.circle{
        display:inline-block; 
        border-radius:50%;
        color:white;
        width:45px; 
        height:50px;
        text-align:center;
        font-size:25px;
        line-height:55px;
        margin-top: 10PX;
        
    }

    
.card-success {
background-color: #06E763;   /* start   */
color: white;
}

.card-danger {
    background-color: #FB4A4A;   /* stop  */
    color: white;
}

.card-timer {
    background-color: #59ADEC;   /* timer  */
    color: white;
}



.card-fault {
    background-color: #5D6D7E ;   /* fault error    */
    color: white;
}
.card-temporary
{
    background-color: #800000 ;   /* fault error    */
    color: white;
}

.card-shifting
{
    background-color: #f39c12 ;   /* fault error    */
    color: white;
}




.box3{
    width: 20px;        /* fault  */
    height: 20px;
    background-color: #5D6D7E ; 
    border-radius: 10%;
}

.box4{
    width: 20px;        /* timer off  */
    height: 20px;
    background-color: #59ADEC ; 
    border-radius: 10%;
}

.box1{
    width: 20px;        
    height: 20px;
    background-color: #06E763; 
    border-radius: 10%;
}

.box5{
    width: 20px;        /* timer off  */
    height: 20px;
    background-color: #800000 ; 
    border-radius: 10%;
}

.box2{
    width: 20px;        
    height: 20px;
    background-color: #FB4A4A; 
    border-radius: 10%;
}

.box6{
    width: 20px;        
    height: 20px;
    background-color: #f39c12; 
    border-radius: 10%;
}


.card-container {
    padding-left: 0px;
    padding-top: 30px;
    flex-basis: calc(12.5% - 10px); /* Adjusted for 8 cards per row */
    max-width: calc(12.5% - 10px); /* Adjusted for 8 cards per row */
    margin-right: 10px;
    height: 90px;
    overflow: hidden;
}

.card-body {
    padding: 8px;
    transition: all 0.1s ease-in 0s;
    cursor: pointer;
    border-radius: 7px;
    box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.06) 0px 2px 4px -1px;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.card-title {
    margin: 0px;
    font-weight: 600;
    font-size: 1.5rem;
    line-height: 1.75rem;
    font-family: "Plus Jakarta Sans", sans-serif;
    text-align: center;
    word-break: break-all;
}

.card-subtitle {
    margin: 0px;
    font-weight: 600;
    font-size: 0.75rem;
    line-height: 1.2rem;
    font-family: "Plus Jakarta Sans", sans-serif;
    text-align: center;
    word-break: break-all;
}
.small-title {
    font-size: 25px;
      margin-left: 40px;
  }
@media only screen and (max-width: 768px) {
    .card-container {
        flex-basis: calc(50% - 10px);
        max-width: calc(50% - 10px);
        margin-right: 5px;
        height: auto;
    }
}

@media only screen and (min-width: 879px) {
    .card-container {
        flex-basis: calc(14.2857% - 10px); 
        max-width: calc(14.2857% - 10px);
        margin-right: 10px;


    .ov-card {
        border-radius: 20px;
        transition: transform 0.2s ease, box-shadow 0.3s ease;
        background: #ffffff;
        border: none;
    }

    .ov-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
    }

    .ov-card .icon-circle {
        width: 60px;
        height: 60px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(93, 109, 126, 0.1);
        border-radius: 50%;
        margin-bottom: 15px;
    }

    .ov-card h4 {
        font-size: 24px;
        font-weight: bold;
        color: #2c3e50;
    }

    .ov-card h5 {
        font-size: 16px;
        color: #566573;
    }

    .ov-card small {
        font-size: 12px;
    }


</style>
<div class="page-wrapper">
    <div class="content container-fluid pt-2">
        <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm border-0 rounded-3" style="background: linear-gradient(to left,#F1948A ,#5D6D7E);">
                <div class="card-body text-center">
                    <h4 class="mb-0" style="color: white; font-weight: bold;">Self Flow Dashboard</h4>
                </div>
            </div>
        </div>
    </div>
        <div class="row">
            
            <div class="col-md-12">
                <div class="card" style="background: linear-gradient(to left,#F1948A ,#5D6D7E);">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label  style="color:white;"><b>Installation/Field</b></label>
                                <select name="area_id" id="area_id" class="form-control select2" onchange="get_site_list();get_dashboard_count();initMap();get_well_data();on_well_list();get_feeder_list(); get_feeder_data(); get_well_list();updateURLAndRefresh();">
                                    <?php
                                    $user_type = $this->session->userdata('user_type', true);
                                    $role_type = $this->session->userdata('role_type',true);
                                    if ($user_type == 3 && $role_type == 2) {
                                       if (!empty($area_list)) {
                                            
                                            foreach ($area_list as $key => $value) {
                                                ?>
                                                <option value="<?php echo $value['id']; ?>"> <?php echo $value['area_name']; ?></option>
                                                <?php
                                            }
                                        }
                                    } else {
                                        if (!empty($area_list)) {
                                            echo '<option value="">Select All</option>'; 
                                            foreach ($area_list as $key => $value) {
                                                ?>
                                                <option value="<?php echo $value['id']; ?>"> <?php echo $value['area_name']; ?></option>
                                                <?php
                                            }
                                        }
                                    }
                                    ?>
                                </select>

                            </div>
                            
<div class="form-group col-md-4" style="display:none;" id="feeder_dropdown">
                                <label  style="color:white;"><b>Feeder</b></label>
                                <select name="feeder_id" id="feeder_id" class="form-control select2" onchange="get_dashboard_count();get_well_data();on_well_list();get_well_list();">
                                    <option value="">Select Feeder</option>

                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label  style="color:white;"><b>Well Name</b></label>
                                <select name="well_id" id="well_id" class="form-control select2" onchange="get_dashboard_count();initMap();get_well_data();on_well_list();">
                                    <option value="">Select Well </option>

                                </select>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

<div class="row">
        <div class="col-md-12">
            <div class="card" style="background: linear-gradient(to left, #5D6D7E,  #F1948A );">
                <div class="card-body">
                    <div class="row align-items-center"> 
                        <div class="col-xl-12">
                            <div class="row mt-4">
                                <div class="col-xl-3 col-sm-3 col-6">
                                    <a id="overall_details_link" href="<?php echo base_url(); ?>Overall_list_selfflow_c/overall_details_total">
                                        <div class="card ov-card" style="height:87%;box-shadow: 0 4px 8px rgba(44, 62, 80);">
                                            <div class="card-body">
                                                <div class="ana-box">   
                                                    <div class="ic-n-bx">
                                                        <div class=" text-center bd-warning rounded-circle">
                                                            <img src="<?php echo base_url(); ?>assets/img/oil-pump.gif" width="45" style="border-radius: 50%; border: 5%;">
                                                        </div>
                                                    </div>
                                                    <div class="anta-data mt-4">
                                                 <h3 class="text-center" id="total_well">0</h3>
                                                        <h5 class="text-center">Total Wells</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-xl-3 col-sm-3 col-6">
                                    <a id="temp_non_functional" href="<?php echo base_url(); ?>Overall_list_selfflow_c/overall_details_flowing">
                                    <div class="card ov-card" style="height:87%;box-shadow: 0 4px 8px rgba(44, 62, 80);">
                                        <div class="card-body">
                                            <div class="ana-box">   
                                                <div class="ic-n-bx">
                                                    <div class=" text-center rounded-circle">
                                                        <img src="<?php echo base_url(); ?>assets/img/well.gif" width="45" style="border-radius:50%; border: 5%;">
                                                    </div>
                                                </div>
                                                   <div class="anta-data mt-4">
                                                    <h3 class="text-center" id="total_flowing_well">0</h3>
                                                    <h5 class="text-center">Flowing wells</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                </div>
                                <div class="col-xl-3 col-sm-3 col-6">
                                 <a id="timer_off_id" href="<?php echo base_url()?>Overall_list_selfflow_c">
                                    <div class="card ov-card" style="height:87%;box-shadow: 0 4px 8px rgba(44, 62, 80);">
                                        <div class="card-body">
                                            <div class="ana-box">   
                                                <div class="ic-n-bx">
                                                    <div class=" text-center rounded-circle">
                                                        <img src="<?php echo base_url(); ?>assets/img/hourglass.gif" width="45" style="border-radius: 50%; border: 5%;">
                                                    </div>
                                                </div>
                                                <div class="anta-data mt-4">
                                                    <h3 class="text-center" id="total_non_flowing_well">0</h3>
                                                    <h5 class="text-center"> Non-flowing wells</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                 </a> 
                                </div>

                                
                                <div class="col-xl-3 col-sm-3 col-6">
                                    <a id="rtms_non_functional" href="<?php echo base_url('Overall_list_selfflow_c/overall_details_rtms'); ?>">
                                        <div class="card ov-card" style="height: 87%; box-shadow: 0 4px 8px rgba(44, 62, 80);">
                                            <div class="card-body">
                                                <div class="ana-box">    
                                                    <div class="ic-n-bx">
                                                        <div class="text-center rounded-circle">
                                                            <img src="<?php echo base_url(); ?>assets/img/cancel.gif" width="45" style="border-radius: 50%; border: 5%;">
                                                        </div>
                                                    </div>

                                                    <!-- Total Offline Count -->
                                                    <div class="anta-data mt-4">
                                                        <h3 class="text-center" id="off_unit">0</h3>
                                                        <h5 class="text-center">RTMS Non-Functional</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                              
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
    </div>

<div class="row">
    <div class="col-xl-12 col-md-12">
        <div class="card">
            <!-- Card Header -->
            <div class="card-header d-flex justify-content-between align-items-center"
                style="height: 65px; background-color: #CD5C5C; cursor: pointer; color:white;">
<b>
  <h4 style="color: white;">
    Well Details&nbsp;
    <badge class="circle" style="background-color:#515A5A; color: white;" id="totalcount"></badge>
  </h4>
</b>

                <img src="<?php echo base_url() ?>assets/img/oil-pump.gif" width="40" style="border-radius: 25%;">
            </div>

            <!-- Card Body -->
            <div class="card-body">
                <div class="card-details">
                    <div class="mt-1 accordion-collapse collapse show" id="welldetails_area_card"
                        aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="col-md-12 pb-3 px-0">
                            <!-- Colored Well Status Legend -->
                            <div class="indicator">
                                <div class="col-md-12 px-0">
                                    <div class="box-section d-flex align-items-center flex-wrap gap-4">
                                        <div class="d-flex align-items-center gap-2">
                                            <div style="background-color: rgb(227,66,52); width: 20px; height: 20px; border-radius: 3px;"></div>
                                            <span>Non Flowing Wells</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <div style="background-color: green; width: 20px; height: 20px; border-radius: 3px;"></div>
                                            <span>Flowing Well</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <div style="background-color: #394f62; width: 20px; height: 20px; border-radius: 3px;"></div>
                                            <span>RTMS Non-Functional Wells</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                           </div>
             
</div>
                        <!-- Cards Display Area -->
                       <div class="small-card-well" id="well_area_card">
                            <!-- Well boxes will be dynamically loaded here -->
                        </div>
               </div>
        </div>
    </div>
</div>




 <div class="row mt-2">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center" style="height: 65px;background-color:#F1948A;cursor: pointer;" data-bs-toggle="collapse" data-bs-target="#map_area_card" aria-expanded="false" aria-controls="map_area_card" id="accordionButton">
                <div>
                    <h5 class="text-white " style="font-size: 18px;">Asset GIS Map</h5>
                </div>
                <div class="d-flex align-items-center">
                    <img src="<?php echo base_url() ?>assets/img/map.gif" width="40" style="border-radius: 25%;">
                </div>
            </div>
            <div class="card-body">
                <div class="mt-1 accordion-collapse collapse" id="map_area_card" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="row">
                    <div class="col-md-6">
                        <button type="button" class="btn btn-sm btn-rounded" style="background-color: #06E763;color:white;">  Flowing Well</button>
                        <button type="button" class="btn btn-sm btn-rounded mx-3" style="background-color: rgb(227,66,52);color:white;"> Non Flowing Well</button>
                         <button type="button" class="btn btn-sm btn-rounded mx-3" style="background-color: grey ;color:white;"> RTMS Non functional</button>
                    </div>
                </div>
                    <div class="mt-2" id="mymap" style="width:100%;height: 400px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel"> 
  <div class="offcanvas-header">
     <!-- <img src="<?php echo base_url() ?>assets/img/logo.png" width="70" style="border-radius: 50%; height:50"> -->
    <h5 id="offcanvasRightLabel">Well Status</h5>
    
       <button type="button" class="btn-close text-reset btn-primary" data-bs-dismiss="offcanvas" aria-label="Close"></button>

  </div>
  <div class="col-md-10" style="margin-left:20px;">
  <label><b>Search Well Name</b></label>   
    <input type="text" onkeyup="get_well_details()" name="search_box_1" id="search_box_1" class="form-control">
  </div>

   <hr class="colored-hr">
  <div class="offcanvas-body">
        <div class="container" id="flash_data">
                    
                </div>
            </div>
            
        </div>
    </div>
<script type="text/javascript">
    
    get_site_list();

function get_site_list() { 
    let company_id = "<?php echo $this->session->userdata('company_id') ?>";
    let user_id = "<?php echo $this->session->userdata('user_id') ?>";
    let assets_id = "<?php echo $this->session->userdata('assets_id') ?>";
    let area_id = $('#area_id').val();

    $.ajax({
        type: 'POST',
        url: '<?php echo base_url();?>Selfflow_c/site_list',
        data: { company_id: company_id, assets_id: assets_id, area_id: area_id, user_id: user_id },
        success: function(data) {
            data = JSON.parse(data);
    
            if (data.response_code == 200) {   
                if (data.data.length > 0) {
                    $('#site_id').html('');
                    $('#site_id').html('<option value="">Select site</option>');
                    $.each(data.data, function(i, v) {
                        // let selected = (v.id == v.id) ? 'selected' : '';
                        $('#site_id').append('<option value="' + v.id + '">' + v.well_site_name + '</option>');
                    });
                } else {
                    $('#site_id').html('<option value="">No Data Found</option>');
                }
            } else {
                swal('error', data.msg, 'error');
            }   
        }
    });
}

get_well_list();
function get_well_list() { 
    let company_id = "<?php echo $this->session->userdata('company_id') ?>";
    let user_id = "<?php echo $this->session->userdata('user_id') ?>";
    let assets_id = "<?php echo $this->session->userdata('assets_id') ?>";
    let area_id = $('#area_id').val();
    let feeder_id = $('#feeder_id').val();
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url();?>Selfflow_c/Well_list',
        data: { company_id: company_id, assets_id: assets_id, area_id: area_id, user_id: user_id,feeder_id:feeder_id },
        success: function(data) {
            data = JSON.parse(data);
           
            if (data.response_code == 200) {   
                if (data.data.length > 0) {
                    $('#well_id').html('');
                    $('#well_id').html('<option value="">Select Well</option>');
                    $.each(data.data, function(i, v) {
                     
                        $('#well_id').append('<option value="' + v.well_id + '">' + v.well_name + '</option>');
                    });
                } else {
                    $('#well_id').html('<option value="">No Well Found</option>');
                }
            } else {
                swal('error', data.msg, 'error');
            }   
        }
    });
}

function get_feeder_list() { 
    let area_id = $('#area_id').val();
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url();?>Selfflow_c/feeder_list',
        data: { area_id: area_id },
        success: function(data) {
            data = JSON.parse(data);
            if (data.response_code == 200) {   
                if (data.data.length > 0) {
                    $('#feeder_id').html('<option value="">Select Feeder</option>');
                    $.each(data.data, function(i, v) {
                        $('#feeder_id').append('<option value="' + v.id + '">' + v.feeder_name + '</option>');
                    });
                } else {
                    $('#feeder_id').html('<option value="">No Feeder Found</option>');
                }
            } else {
                swal('error', data.msg, 'error');
            }   
        }
    });
}

function get_feeder_data() { 
    let area_id = $('#area_id').val();
    if (area_id == "52dbde99-b394-11ee-a6d4-5cb901ad9cf0") {
        $('#feeder_dropdown').show();
    } else {
        $('#feeder_dropdown').hide();
    }
}

// Bind both functions on area_id change:
$('#area_id').on('change', function() {
    get_feeder_list();
    get_feeder_data();
});

// Initial call to set on page load
get_feeder_list();
get_feeder_data();



</script>
<script type="text/javascript">
    
    on_well_list()
    function on_well_list()
    {
        var company_id = '<?php echo $this->session->userdata('company_id') ?>';
        var user_id = '<?php echo $this->session->userdata('user_id') ?>';
        var assets_id = '<?php echo $this->session->userdata('assets_id') ?>';
        var area_id = $('#area_id').val();
        let site_id = $('#site_id').val();
        
    
        $.ajax({
            url: '<?php echo base_url(); ?>Dashboard_c/get_popup_data',
            type: 'POST',
            data: {company_id:company_id,user_id:user_id,assets_id:assets_id,area_id:area_id,site_id:site_id},
            success:function(res)
            {
                $('#flash_data').html(res);
            }
        });
    } 
</script>

<script type="text/javascript">
    

  get_dashboard_count();

function get_dashboard_count() {
    let company_id = '<?php echo $this->session->userdata('company_id') ?>';
    let area_id = $('#area_id').val();
    let well_id = $('#well_id').val();
    let well_type = $('#well_type').val();
    let site_id = $('#site_id').val();
    let feeder_id = $('#feeder_id').val();
    let assets_id = $('#assets_id').val();

    $.ajax({
        url: '<?php echo base_url(); ?>Selfflow_c/get_dashboard_count',
        type: 'POST',
        data: {
            company_id: company_id,
            area_id: area_id,
            well_id: well_id,
            well_type: well_type,
            site_id: site_id,
            feeder_id: feeder_id,
            assets_id: assets_id
        },
        success: function(res) {
            try {
                res = JSON.parse(res);
                console.log(res, 'dashboard_count');

                if (res.response_code == 200) {
                    // Populate basic stats
                    $('#total_well').text(res.data.total_well ?? 0);
                    $('#total_flowing_well').text(res.data.total_flowing_well ?? 0);
                    $('#total_non_flowing_well').text(res.data.total_non_flowing_well ?? 0);
                    $('#totalcount').text(res.data.total_well_count ?? 0);

                    // Debug: log raw inputs
                    console.log("Raw counts:", {
                        total_temperory_well: res.data.total_temperory_well,
                        faulty_well: res.data.faulty_well,
                        timer_off_well: res.data.timer_off_well,
                        power_cut_well: res.data.power_cut_well,
                        ON_Well: res.data.ON_Well
                    });

                    // Safely calculate total_data
                    let total_data = 
                        (parseInt(res.data.total_temperory_well) || 0) +
                        (parseInt(res.data.faulty_well) || 0) +
                        (parseInt(res.data.timer_off_well) || 0) +
                        (parseInt(res.data.power_cut_well) || 0) +
                        (parseInt(res.data.ON_Well) || 0);

                    let total_well = parseInt(res.data.total_well) || 0;
                    let off_func = total_well - total_data;
                    let off_func_data = off_func < 0 ? 0 : off_func;

                    $('#off_unit').text(off_func_data);

                    // RTMS offline categories
                    $('#total_offline').text(res.data.rtms_offline?.total_offline ?? 0);
                    $('#network_issue').text(res.data.rtms_offline?.network_issue ?? 0);
                    $('#battery_issue').text(res.data.rtms_offline?.battery_issue ?? 0);
                } else {
                    console.error('API Error:', res.msg || 'Unknown error');
                }
            } catch (e) {
                console.error('JSON Parse Error:', e.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', status, error);
        }
    });
}

get_well_data();

function get_well_data() {
    let area_id = $('#area_id').val();
    let well_id = $('#well_id').val();
    let well_type = $('#well_type').val();
    let site_id = $('#site_id').val();
    let user_type = '<?php echo $this->session->userdata('user_type') ?>';
    let role_type = '<?php echo $this->session->userdata('role_type') ?>';

    $.ajax({
        url: '<?php echo base_url(); ?>Selfflow_c/well_card_data',
        method: 'POST',
        data: {
            area_id: area_id,
            well_id: well_id,
            well_type: well_type,
            site_id: site_id,
            user_type:user_type,
            role_type:role_type

        },
        success: function(res) {
            var response = JSON.parse(res);
            console.log(res,'well_details');

            if (response.response_code == 200) {
                if (response.data.length > 0) {
                    $("#well_area_card").html('');
                   
                    $.each(response.data, function(i, v) 
                    {
                        var status_variable = v.status_variable;
                        var badgeClass = "";
                        var badgeStyle = "";
                        var badgeText = "";

                        if (status_variable == 'Offline_well') {
                            badgeClass = "text-warning";
                            badgeStyle = "background-color: #394f62;color: white !important;";
                            badgeText = v.well_name;
                        }else if(status_variable == 'non_flowing_well')
                        {
                            badgeClass = "text-danger";
                            badgeStyle = "background-color: #d90707ed;color: white !important;";
                            badgeText = v.well_name;

                        }else if(status_variable == 'flowing_well')
                        {
                            badgeClass = "text-success";
                            badgeStyle = "background-color: #008000ed;color: white !important;";
                            badgeText = v.well_name;
                        }else{
                            badgeClass = "text-warning";
                            badgeStyle = "background-color: #394f62;color: white !important;";
                            badgeText = v.well_name;

                        }

                        var link =
                            '<?php echo base_url("Selfflow_c/SingleWellDashboard/"); ?>' + v
                            .well_id + '/' + v.site_id + '/' + v.area_id + '/' + v.well_type;

                        $("#well_area_card").append(
                            '<a href="' + link + '" style="text-decoration: none; color: inherit; display: inline-block; margin: 5px;">' +
                            '<span class="badge ' + badgeClass +
                            ' fw-semibold rounded-pill text-center d-inline-flex align-items-center justify-content-center" ' +
                            'style="' + badgeStyle + ' padding: 15px 0px;; min-width: 100px; display: inline-block; text-align: center;">' +
                            badgeText +
                            '</span></a>'
                        );

                    });
                } else {
                    $('#well_area_card').html('<div class="card card-body mx-3 mt-3">' +
                        '<div class="text-danger" style="text-align:center;" colspan="6"><h4>No Well Found !!</h4></div>' +
                        '</div>');
                }
            }
        }
    });
}


</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBKoAgLoslTEUCNabLj5H5jLVdWFD2WhK8"></script>
<script type="text/javascript">
initMap();

function initMap() {
    let area_id = $('#area_id').val();
    let well_id = $('#well_id').val();
    let well_type = $('#well_type').val();
    let site_id = $('#site_id').val();
   
    $.ajax({
        url: '<?php echo base_url(); ?>Selfflow_c/get_site_location_for_dashboard',
        type: 'POST',
        data: {
            area_id,
            well_id,
            well_type,
            site_id
        },
        success: function(res) {
            let response;
            try {
                response = JSON.parse(res);
            } catch (error) {
                console.error("Invalid JSON response:", error);
                return;
            }

            if (response.data && Array.isArray(response.data)) {
                const markers = response.data.map(item => ({
                    position: {
                        lat: parseFloat(item.lat),
                        lng: parseFloat(item.long)
                    },
                    title: item.well_name,
                    well_id: item.well_id,
                    offline_time: item.Log_Date_Time,
                    flag_status: item.flag_status,
                    long: item.long,
                    lat: item.lat,
                    site: item.site_id,
                    area_id: item.area_id,
                    well_type: item.well_type,
                }));

                const map = new google.maps.Map(document.getElementById('mymap'), {
                    zoom: 13,
                    center: {
                        lat: 21.62640  ,
                        lng:  73.0152
                    }
                });

                const timeLimit = (user_type == 2 || (user_type == 3 && role_type == 3)) ? 900 : 7200;

                markers.forEach((marker, index) => {
                    const baseUrl = '<?php echo base_url(); ?>assets/img/';
                    let markerIcon = {
                        url: baseUrl + 'offline.png',
                        scaledSize: new google.maps.Size(20, 20)
                    };

                    const lastDataTimeObj = marker.offline_time ? new Date(marker.offline_time) : null;
                    const seconds = lastDataTimeObj ? Math.floor((new Date() - lastDataTimeObj) / 1000) : Infinity;

                    if (!marker.offline_time || seconds > timeLimit) {
                        markerIcon.url = baseUrl + 'offline.png';
                    } else if (seconds <= timeLimit && marker.flag_status == 0) {
                        markerIcon.url = baseUrl + 'green.png';
                    } else if (seconds <= timeLimit && marker.flag_status == 1) {
                        markerIcon.url = baseUrl + 'red.png';
                    }

                    const adjustedPosition = {
                        lat: parseFloat(marker.lat) + index * 0.000001,
                        lng: parseFloat(marker.long) + index * 0.000001
                    };

                    const mapMarker = new google.maps.Marker({
                        position: adjustedPosition,
                        map,
                        icon: markerIcon,
                        title: marker.title,
                    });
                    let statusText = '';

                    if (!marker.offline_time || seconds > timeLimit) {
                        statusText = 'RTMS Non functional Well';
                    } else if (seconds <= timeLimit && marker.flag_status == 0) {
                        statusText = 'Flowing Well';
                    } else if (seconds <= timeLimit && marker.flag_status == 1) {
                        statusText = 'Non-Flowing Well';
                    } else {
                        statusText = 'RTMS Non functional Well';
                    }

                    const infowindow = new google.maps.InfoWindow({
                        content: `
                            <div class="site-info" style="width: 150px; height: auto;">
                                <h6><a target="_blank" href="https://www.google.com/maps/place/${marker.lat},${marker.long}">View on Google Maps</a></h6>
                                <h6>${marker.title}</h6>
                                <h6><b>Well Status</b>: ${statusText}</h6>
                                <h6><b><a href="<?php echo base_url(); ?>Selfflow_c/SingleWellDashboard/${marker.well_id}/${marker.site}/${marker.area_id}/${marker.well_type}">View Details</a></b></h6>
                            </div>`
                    });

                    mapMarker.addListener('click', () => infowindow.open(map, mapMarker));
                    map.addListener('click', () => infowindow.close());
                });
            } else {
                console.error("Invalid or empty data array");
            }
        }
    });
}

</script>