<div class="page-wrapper">
    <!-- Page Content -->
    <div class="content container-fluid">

        <div class="row row-sm">
            <div class="col-lg-12">
                <div class="card">

                    <!-- Header -->
                    <div class="card-body" style="padding: 6px;">
                        <div class="row align-items-center">
                            <div class="col-md-6 d-flex align-items-center" style="margin-top: 8px;">
                                <h3 class="m-0">Threshold Setup</h3>
                            </div>
                            <div class="col-md-6 d-flex justify-content-end align-items-center" style="margin-top: 8px;">
                                <a href="Threshold_setup_selfflow_c">
                                    <button class="btn btn-sm btn-primary mx-2">Back</button>
                                </a>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Main Body -->
                    <div class="card-body">

    <!-- Inline Row: View Setup + Inline Fields -->
    <div class="row align-items-end" style="margin-top:-25px">
        <!-- View Setup Dropdown -->
        <div class="form-group col-md-4">
            <label for="report_view" class="form-label"><b>View Setup</b></label>
            <select name="report_view" id="report_view" class="form-control select2" onchange="get_view();" style="width: 100%;">
                <option value="">Select Setup</option>
                <option value="well">Well Wise</option>
                <option value="area">Area Wise</option>
            </select>
        </div>

        <!-- Inline Area Dropdown (shown for both Well Wise and Area Wise) -->
        <div class="form-group col-md-4" id="inline_area_div" style="display: none;">
            <label for="inline_area_select" class="form-label">Area</label>
            <select name="area_id" id="area_id" class="form-control select2">
                                    <?php
                                    $user_type = $this->session->userdata('user_type', true);
                                    $role_type = $this->session->userdata('role_type', true);

                                    if ($user_type == 3 && $role_type == 2) {
                                        if (!empty($area_list)) {
                                            foreach ($area_list as $value) {
                                                echo '<option value="' . $value['id'] . '">' . $value['area_name'] . '</option>';
                                            }
                                        }
                                    } else {
                                        if (!empty($area_list)) {
                                            echo '<option value="">Select All</option>';
                                            foreach ($area_list as $value) {
                                                echo '<option value="' . $value['id'] . '">' . $value['area_name'] . '</option>';
                                            }
                                        }
                                    }
                                    ?>
                                </select>
        </div>

        <!-- Inline Well Name Dropdown (only for Well Wise) -->
        <div class="form-group col-md-4" id="inline_well_div" style="display: none;">
            <label for="inline_well_name" class="form-label">Well Name</label>
             <select name="well" id="well" class="form-control select2"> 
                                            <option value="">Select Well</option>
                                            <?php 
                                            if (!empty($well_list))
                                            {
                                                foreach ($well_list as $key => $value)
                                                {
                                                    ?>
                                                        <option value="<?php echo $value['well_id'].'|'.$value['well_id']; ?>"><?php echo $value['well_name']; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
        </div>
        <div id="multiWellDiv" style="display: none;">
    <div class="row mt-2">
        <div class="form-group col-md-8">
            <label for="well" class="form-label">Select Wells</label>
            <select name="well[]" id="well" class="form-control select2" multiple="multiple" style="width: 100%;">
                <option value="">Select Well</option>
                <?php 
                if (!empty($well_list)) {
                    foreach ($well_list as $key => $value) {
                        ?>
                        <option value="<?php echo $value['well_id'].'|'.$value['well_id']; ?>">
                            <?php echo $value['well_name']; ?>
                        </option>
                        <?php
                    }
                }
                ?>
            </select>
        </div>
    </div>
</div>


    <!-- Threshold Fields (appear when any setup is selected) -->
    <div id="thresholdFields" style="display: none; margin-top: 23px;">
        <div class="row mt-2">
            <!-- CHP -->
            <div class="form-group col-md-3">
                <label><b>Upper CHP</b></label>
                <input type="number" class="form-control" name="upper_chp" placeholder="Enter Upper CHP" step="any">
            </div>
            <div class="form-group col-md-3">
                <label><b>Lower CHP</b></label>
                <input type="number" class="form-control" name="lower_chp" placeholder="Enter Lower CHP" step="any">
            </div>
            <!-- THP -->
            <div class="form-group col-md-3">
                <label><b>Upper THP</b></label>
                <input type="number" class="form-control" name="upper_thp" placeholder="Enter Upper THP" step="any">
            </div>
            <div class="form-group col-md-3">
                <label><b>Lower THP</b></label>
                <input type="number" class="form-control" name="lower_thp" placeholder="Enter Lower THP" step="any">
            </div>
            <!-- ABP -->
            <div class="form-group col-md-3" style="margin-top: 18px;">
                <label><b>Upper ABP</b></label>
                <input type="number" class="form-control" name="upper_abp" placeholder="Enter Upper ABP" step="any">
            </div>
            <div class="form-group col-md-3" style="margin-top: 18px;">
                <label><b>Lower ABP</b></label>
                <input type="number" class="form-control" name="lower_abp" placeholder="Enter Lower ABP" step="any">
            </div>
            <!-- THT -->
            <div class="form-group col-md-3" style="margin-top: 18px;">
                <label><b>Upper THT</b></label>
                <input type="number" class="form-control" name="upper_tht" placeholder="Enter Upper THT" step="any">
            </div>
            <div class="form-group col-md-3" style="margin-top: 18px;">
                <label><b>Lower THT</b></label>
                <input type="number" class="form-control" name="lower_tht" placeholder="Enter Lower THT" step="any">
            </div>
        </div>
    </div>

    <div class="footer">
                                    <button type="submit" class="btn btn-primary ">Submit</button>
                                </div>

</div> <!-- End of card-body -->

                </div> <!-- card -->
            </div> <!-- col -->
        </div> <!-- row -->

    </div> <!-- container-fluid -->
</div> <!-- page-wrapper -->


<script>
    const wellData = {
        "Padra": ["PD1", "PD2", "PD3"],
        "Ankleshwar": ["AK1", "AK2", "AK3"],
        "Mehsana": ["MH1", "MH2"]
    };

    function get_view() {
        const view = document.getElementById("report_view").value;

        // Show inline area and threshold fields if a view is selected.
        if (view === "well" || view === "area") {
            document.getElementById("inline_area_div").style.display = "block";
            document.getElementById("thresholdFields").style.display = "block";
        } else {
            document.getElementById("inline_area_div").style.display = "none";
            document.getElementById("inline_well_div").style.display = "none";
            document.getElementById("thresholdFields").style.display = "none";
            document.getElementById("multiWellDiv").style.display = "none";
        }

        if (view === "well") {
            // For Well Wise, show single-selection well name dropdown.
            document.getElementById("inline_well_div").style.display = "block";
            document.getElementById("multiWellDiv").style.display = "none";
        } else if (view === "area") {
            // For Area Wise, hide single well dropdown and show multi-select wells.
            document.getElementById("inline_well_div").style.display = "none";
            document.getElementById("multiWellDiv").style.display = "block";
        }

        // Reset inline area and well selections.
        document.getElementById("inline_area_select").value = "";
        document.getElementById("inline_well_name").innerHTML = '<option value="">Select Well</option>';
        document.getElementById("area_wells").innerHTML = "";
    }

    function loadInlineWells() {
        const area = document.getElementById("inline_area_select").value;
        const inlineWell = document.getElementById("inline_well_name");
        const multiWell = document.getElementById("area_wells");

        // Clear existing options.
        inlineWell.innerHTML = '<option value="">Select Well</option>';
        multiWell.innerHTML = "";

        if (area && wellData[area]) {
            wellData[area].forEach(function (well) {
                // For single-select inline well (used in Well Wise view)
                const optionSingle = document.createElement("option");
                optionSingle.value = well;
                optionSingle.text = well;
                inlineWell.appendChild(optionSingle);

                // For multi-select wells (used in Area Wise view)
                const optionMulti = document.createElement("option");
                optionMulti.value = well;
                optionMulti.text = well;
                multiWell.appendChild(optionMulti);
            });
        }

        // Refresh select2 elements.
        if ($(inlineWell).hasClass("select2")) {
            $(inlineWell).trigger("change");
        }
        if ($(multiWell).hasClass("select2")) {
            $(multiWell).trigger("change");
        }
    }

    $(document).ready(function () {
        $('.select2').select2({
            placeholder: "Select options",
            allowClear: true
        });
    });
</script>
