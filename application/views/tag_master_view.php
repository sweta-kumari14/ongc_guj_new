 <div class="page-wrapper">
    <div class="content container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                               <h4 class="header-title mb-4">Tag List</h4>
                            </div>
                            <div class="col-auto float-end ms-auto">
                                <button class="btn btn-sm btn-success btn-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#add_area_drawer" aria-controls="add_area_drawer">
                                <i class="fas fa-plus me-1" style="font-size: 12px;"></i> Add
                                </button>
                                <button type="button" id="export_btns" onclick="export_report()" class="btn btn-sm btn-primary"><i class="fas fa-file-export me-1" style="font-size: 12px;"></i> Export
                                </button>
                            </div>
                         
                        </div>
                   <div class="table-responsive">
                        <table class="table table-striped custom-table mb-0 datatable" id="data-table">
                            <tr>
                                <th class="text-center">SL.No.</th>
                                <th class="text-center">Tag Number</th>
                                <th class="text-center">Installation Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody class="text-center">
                                 <?php 
                                    if (!empty($tag_list))
                                    {
                                        foreach ($tag_list as $key => $value)
                                        {
                                            ?>
                                                <tr>
                                                    <td style="width:15%"><?php echo $key+1; ?></td>
                                                    <td><?php echo $value['tag_number']??'-'; ?></td>
                                                    <td>
                                                        <?php 
                                                            if($value['installation_status'] == 1){
                                                                     ?>
                                                            <img src="<?php echo base_url(); ?>assets/green_tick.png" width="20px" alt="Active">
                                                            <?php
                                                            }
                                                           if($value['installation_status'] == 0){
                                                                ?>
                                                            <img src="<?php echo base_url(); ?>assets/cross-tick.png" width="20px" alt="Not-Active">
                                                                <?php
                                                                }
                                                            ?>   
                                                         </td>
                                                    <td  style="width:15%;">
                                                        <a onclick="setTagDetails(this.id)" id="<?php echo $value['id']; ?>" href="javascript:;" data-bs-toggle="offcanvas"
                                                           data-bs-target="#area_edit_drawer"><i class="fa-solid fa-pen-to-square text-success" style="font-size:14px;"></i></a>

                                                        <a id="<?php echo $value['id']; ?>" onclick="deleteTagData(this.id);">
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
<div class="offcanvas offcanvas-end" tabindex="-1" id="add_area_drawer" aria-labelledby="offcanvasRightLabel">
    
    <!-- Header with background color -->
    <div class="offcanvas-header" style="background: linear-gradient(to right, #032448 20%, #fc6075 100%);">
        <h5 id="offcanvasRightLabel" class="offcanvas-title" style="color:#e8d7d6;">Add Tags</h5>
        <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <!-- Body -->
    <div class="offcanvas-body">
        <form action="<?php echo base_url() ?>Tag_master_c/add_Tag_data" class="row needs-validation" method="post" novalidate>

            <div class="row">
                <!-- Tag No Input -->
                <div class="col-md-12 mt-2">
                    <label for="validationCustom01" class="form-label">Tag Number<sup class="text-danger">*</sup></label>
                    <input name="tag_number" type="text" class="form-control" id="validationCustom01" placeholder="Enter tag number" 
                           pattern="^[A-Za-z0-9#\-]+$" required>
                    <div class="invalid-feedback">
                       Please provide a valid tag number (alphabets, numbers, hyphen, and hash allowed)!
                    </div>
                </div>
            </div>
            <hr class="mt-3">
            <div class="text-end">
                <button type="submit" class="btn btn-sm btn-success">Submit</button>
            </div>
        </form>

    </div>
</div>

<!-- --------------------------Edit----------------------- -->

<!-- Offcanvas for Editing Area -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="area_edit_drawer" aria-labelledby="offcanvasEditLabel">
    
    <!-- Header with background color -->
    <div class="offcanvas-header" style="background: linear-gradient(to right, #032448 20%, #fc6075 100%);">
        <h5 id="offcanvasEditLabel" class="offcanvas-title" style="color:#e8d7d6;">Edit Tags</h5>
        <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <!-- Body -->
    <div class="offcanvas-body">
        <form action="<?php echo base_url() ?>Tag_master_c/update_TagData" class="row needs-validation" novalidate method="post">

            <input type="hidden" name="id" id="editTagId">
            <div class="col-md-12">
                <label class="form-label">Tag Number<sup class="text-danger">*</sup></label>
                <input name="tag_number" type="text" class="form-control" id="editTagName"
                       pattern="^[A-Za-z0-9#\-]+$" required>
                <div class="invalid-feedback">
                   Please provide a valid tag number (alphabets, numbers, hyphen, and hash allowed)!
                </div>
            </div>
            <hr class="mt-3">
            <div class="text-end">
                <button type="submit" class="btn btn-sm btn-primary" >Update</button>
            </div>
        </form>
    </div>
</div>

<?php 
if($this->session->flashdata('success') != '')
{
    ?>
    <script type="text/javascript">
      $(document).ready(function () {
        var msg = "<?php echo $this->session->flashdata('success'); ?>";
        swal(msg, "", "success");
      });
    </script>
  <?php
}
if($this->session->flashdata('error') != '')
{
    ?>
        <script type="text/javascript">
          $(document).ready(function () {
            var msg = "<?php echo $this->session->flashdata('error'); ?>";
            swal(msg, "", "error");
          });
        </script>
    <?php
}
?>
<script type="text/javascript">
    
    $(document).ready(function () {
        $('.select2').select2();

        $('#add_area_drawer').on('shown.bs.offcanvas', function () {
            $('.select2').select2({
                dropdownParent: $('#add_area_drawer') 
            });
        });

        $('#add_area_drawer').on('hidden.bs.offcanvas', function () {
            $('.select2').select2(); 
        });
    });

    $(document).ready(function () {
        $('.select2').select2();

        $('#area_edit_drawer').on('shown.bs.offcanvas', function () {
            $('.select2').select2({
                dropdownParent: $('#area_edit_drawer') 
            });
        });

        $('#area_edit_drawer').on('hidden.bs.offcanvas', function () {
            $('.select2').select2(); 
        });
    });
</script>

<script>

//     getTagMasterList();
//     function getTagMasterList()
//     {
//          $.ajax({
//             url: '<?php echo base_url() ?>Tag_master_c/tagMaster_list',
//             type: 'POST',
//             data: {
                
//             },
//             success:(res)=>{
//                 resp = JSON.parse(res); 
//                 console.log(resp,'dsafdjsdfa');
//                 if(resp.response_code == 200){
//                     if(resp.data.length > 0){
//                         $("#tag_list").html(``);
//                        $.each(resp.data, (i,v)=>{
//     $("#tag_list").append(`<tr>
//         <td>${i + 1}</td>
//         <td>${v.tag_number || '-'}</td>
//         <td>
//             <a onclick="setTagDetails('${v.id}')" id="${v.id}" href="javascript:;" data-bs-toggle="offcanvas" data-bs-target="#area_edit_drawer">
//                 <i class="fa-solid fa-pen-to-square text-success" style="font-size:14px;"></i>
//             </a>
//             <a onclick="deleteTagData('${v.id}')">
//                 <i class="fas fa-trash mx-2 text-danger" style="font-size:14px;cursor:pointer;"></i>
//             </a>
//         </td>
//     </tr>`);
// });

//                     }else{

//                         $('#tag_list').html(`<tr><td colspan="4" class="text-center"><div class="mt-3">
//                              <img src="<?php echo base_url(); ?>assets/img/no_records.svg" width="100">
//                             <p class="text-danger mt-2 fw-bold">No Record Found !!</p></div></td></tr>
//                           `);
//                     }
//                 }
//             }
//         });
//     }

    function setTagDetails(id)
    {
        $.ajax({
            type:'POST',
            url:'<?php echo base_url(); ?>Tag_master_c/get_tag_details',
            data:{id: id},
            success:function(res)
            {
                res = JSON.parse(res);
                console.log(res);
                if(res.response_code==200)
                {
                    $("#editTagName").val(res.data[0]['tag_number']);
                    $("#editTagId").val(res.data[0]['id']);
                }                
            }
        })
    }

    function deleteTagData(id)
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
                url:'<?php echo base_url(); ?>Tag_master_c/deleteTag_data',
                data:{id: id},
                success:function(res)
                {
                    res = JSON.parse(res);
                    console.log(res);
                    if(res.response_code==200)
                    {
                      swal('success',res.msg,'success');
                      setTimeout(()=>{window.location.href="<?php echo base_url(); ?>Tag_master_c"},200)
                   }else
                   {
                        swal('warning',res.msg,'warning');
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
      var fileName = "Tag list.xlsx";
      var table = $("data-table")[0];

      // Convert table to worksheet
      var ws = XLSX.utils.table_to_sheet(table);

      // Create a new workbook and add the worksheet to it
      var wb = XLSX.utils.book_new();
      XLSX.utils.book_append_sheet(wb, ws, sheetName);

      // Save the workbook as an Excel file and download it
      XLSX.writeFile(wb, fileName);
    }

</script>