<div class="page-wrapper">
    <div class="content container-fluid pt-2">
<div class="container-xxl">

    

    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header mb-0" style="    padding: 11px; background-color: #ede4d1;">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="mb-1">Component List</h4>
                        </div>
                        <div class="col-auto ms-auto d-flex gap-2">
                           <button class="btn btn-success motion-btn" type="button"data-bs-toggle="offcanvas"data-bs-target="#offcanvasRight"aria-controls="offcanvasRight"style="font-size: 12px; padding: 2px 6px; line-height: 1.2;">
    <i class="fas fa-plus me-1" style="font-size: 10px;"></i> Add
</button>


                            <button type="button" id="export_btns" onclick="export_report()" class="btn btn-sm btn-primary motion-btn">
                                <i class="fas fa-file-export me-1" style="font-size: 12px;"></i> Export</button>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-1">
                    <div class="table-responsive">
                         <table class="table datatable" id="datatable_2">
                            <thead class="table-secondary">
                                <tr>
                                    <th>SL.No.</th>
                                    <th>Component Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    if (!empty($component_list))
                                    {
                                        foreach ($component_list as $key => $value)
                                        {
                                            ?>
                                                <tr>
                                                    <td style="width:15%"><?php echo $key+1; ?></td>
                                                    <td><?php echo $value['component_name']??'-'; ?></td>
                                                    <td  style="width:15%;">
                                                        <a onclick="setcomponentDetails(this.id)" id="<?php echo $value['id']; ?>" href="javascript:;" data-bs-toggle="offcanvas"
                                                           data-bs-target="#offcanvasEdit"><i class="fa-solid fa-pen-to-square text-success" style="font-size:14px;"></i></a>

                                                        <a id="<?php echo $value['id']; ?>" onclick="delete_component(this.id);">
                                                         <i class="fas fa-trash mx-2 text-danger" style="font-size:14px;cursor:pointer;"></i> 
                                                      </a>
                                                    </td>
                                                </tr>
                                            <?php
                                        }
                                        
                                    }else{
                                        ?>
                                            <tr>
                                                <td colspan="3" class="text-danger"><img src="<?php echo base_url() ?>assets/img/no_records.svg" width="100" class="mx-auto d-block">
                                                <p class="text-danger fw-bold mt-2 text-center"> No Data Available !!</p></td>
                                            </tr>
                                        <?php
                                    }

                                ?>
                                
                            </tbody>
                        </table>
                    </div>   
                </div>
            </div>
        </div>
    </div>                                      
</div>

<!-- Offcanvas Component -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    
    <!-- Header with background color -->
    <div class="offcanvas-header" style="background: linear-gradient(to right, #8B4513, #A9A9A9);">
        <h5 id="offcanvasRightLabel" class="offcanvas-title" style="color:#e8d7d6;">Add Component</h5>
        <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <!-- Body -->
    <div class="offcanvas-body">
        <form action="<?php echo base_url() ?>Component_c/add_component" class="row needs-validation" method="post" novalidate>

            <div class="col-md-12">
                <label for="validationCustom01" class="form-label">Component Name<sup class="text-danger">*</sup></label>
                <input name="component_name" type="text" class="form-control" id="validationCustom01"
                     pattern="^[A-Za-z ]+$" required placeholder="Enter component name">
                <div class="invalid-feedback">
                Please provide a valid asset name (alphabets only)!
                </div>
            </div>
            <hr class="mt-3">
            <div class="text-end">
                <button type="submit" class="btn btn-sm btn-success">Submit</button>
            </div>
        </form>
    </div>
</div>
</div>
</div>

<!-- --------------------------Edit----------------------- -->

<!-- Offcanvas for Editing Component -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEdit" aria-labelledby="offcanvasEditLabel">
    
    <!-- Header with background color -->
    <div class="offcanvas-header" style="background: linear-gradient(to right, #8B4513, #A9A9A9);">
        <h5 id="offcanvasEditLabel" class="offcanvas-title" style="color:#e8d7d6;">Edit Component</h5>
        <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <!-- Body -->
    <div class="offcanvas-body">
        <form action="<?php echo base_url() ?>Component_c/update_Component" class="row needs-validation" novalidate method="post">

            <input type="hidden" name="id" id="editComponentId">

            <div class="col-md-12">
                <label for="editComponentName" class="form-label">Component Name<sup class="text-danger">*</sup></label>
                <input name="component_name" type="text" class="form-control" id="editComponentName"
                       pattern="^[A-Za-z ]+$" required placeholder="Enter component name">
                <div class="invalid-feedback">
                    Please provide a valid asset name (alphabets only)!
                </div>
            </div>
            <hr class="mt-3">
            <div class="text-end">
                <button type="submit" class="btn btn-sm btn-primary" >Update</button>
            </div>
        </form>
    </div>
</div>

<script>

    function setcomponentDetails(id)
    {
        $.ajax({
            type:'POST',
            url:'<?php echo base_url(); ?>Component_c/get_component_details',
            data:{id: id},
            success:function(res)
            {
                res = JSON.parse(res);
                console.log(res);
                if(res.response_code==200)
                {
                    $("#editComponentName").val(res.data[0]['component_name']);
                    $("#editComponentId").val(res.data[0]['id']);
                }                
            }
        })
    }

    function delete_component(id)
    {
      swal({
           title: "Are you sure?",
           text: "You want to delete",
           icon: "warning",
           buttons: true,
           dangerMode: true,
         })
         .then((willDelete) => {
           if (willDelete) {
            
            $.ajax({
                type:'POST',
                url:'<?php echo base_url(); ?>Component_c/delete_Component',
                data:{id: id},
                success:function(res)
                {
                    res = JSON.parse(res);
                    console.log(res);
                    if(res.response_code==200)
                    {
                      toastr.success(res.msg);
                      setTimeout(()=>{window.location.href="<?php echo base_url(); ?>Component_c"},200)
                   }else
                   {
                        toastr.error(res.msg);
                   }
                    
                }
            })

           }
         });
    }

</script>
<script src="<?php echo base_url(); ?>assets/local/excel/xlsx.full.min.js"></script>
<script type="text/javascript">
    
    function export_report() {
      var sheetName = "Sheet1";
      var fileName = "Component list.xlsx";
      var table = $("#datatable_2")[0];

      // Convert table to worksheet
      var ws = XLSX.utils.table_to_sheet(table);

      // Create a new workbook and add the worksheet to it
      var wb = XLSX.utils.book_new();
      XLSX.utils.book_append_sheet(wb, ws, sheetName);

      // Save the workbook as an Excel file and download it
      XLSX.writeFile(wb, fileName);
    }

</script>

