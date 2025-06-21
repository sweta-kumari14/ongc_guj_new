    <!-- Page Content -->
    <div class="page-wrapper" style="margin-top: -33px;">
    <div class="content container-fluid" style="padding: 19px;">
        <!-- Page Header -->
        <div class="page-header"style="padding: 9px;">
            <div class="row">
<div class="col-sm-12">
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="page-title m-0">Sensor</h3>
        <ul class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="<?php echo base_url('Selfflow_c'); ?>">Dashboard</a>
            </li>
            <li class="breadcrumb-item">Sensor</li>
        </ul>
    </div>
</div>


            </div>
        </div>
        <!-- /Page Header -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card" style="margin-top: -20px;">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="header-title mb-4">Sensor</h4>
                            </div>
                            <div class="col-auto float-end ms-auto">
                                <a href="<?php echo base_url('Sensor_c/add_sensor_page'); ?>">
                                    <button type="button" class="btn btn-sm btn-rounded btn-success">Add</button>
                                </a>
                                <button class="btn btn-primary btn-sm btn-rounded mx-2" onclick="export_report()" style="font-size: 14px;">Export</button>
                            </div>
                        </div>



                        <div class="table-responsive">
                            <table class="table table-striped custom-table mb-0 datatable" id="data-table">
                                <thead class="text-center">
                                    <tr>
                                        <th style="width:10%;">Sl No.</th>
                                        <th>Sensor Name</th>
                                        <th>Sensor No.</th>
                                        <th>Allotment date time</th>
                                        <th>Allot Status</th>
                                        <th style="width:20%;">Action</th>
                                    </tr>
                                </thead>

                                <tbody class="text-center" style="border-collapse: collapse;">
                                    <?php 
                                    if (!empty($device_list))
                                    {
                                        foreach ($device_list as $key => $value)
                                        {
                                            ?>
                                            <tr>
                                                <td><?php echo $key+1; ?></td>
                                                <td><?php echo $value['sensor_name']; ?></td>
                                                <td><?php echo $value['sensor_no']; ?></td>
                                                <td><?php echo $value['allotment_date_time']; ?></td>
                                                <td>
                                                    <?php 
                                                    if($value['status'] == 1){
                                                        ?>
                                                        <img src="<?php echo base_url(); ?>assets/green_tick.png" width="20px" alt="Active">
                                                        <?php
                                                    } else if($value['status'] == 0){
                                                        ?>
                                                        <img src="<?php echo base_url(); ?>assets/cross-tick.png" width="20px" alt="Not-Active">
                                                        <?php
                                                    }
                                                    ?>   
                                                </td>
                                                <td>
                                                    <a href="<?php echo base_url().'Sensor_c/edit/'.$value['id']; ?>">
                                                        <i class="fas fa-pencil-alt" style="font-size:20px;color:green;"></i>
                                                    </a>
                                                    <a id="<?php echo $value['id']; ?>" onclick="delete_device(this.id);">
                                                        <i class="fas fa-trash mx-2" style="color:#A93226;font-size:20px;cursor:pointer;"></i> 
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="8" class="text-danger text-center">No records Found !!</td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- /Content End -->
            </div>
        </div>
    </div>
    <!-- /Page Content -->
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
    function delete_device(id)
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
                    url:'<?php echo base_url(); ?>Sensor_c/delete_device',
                    data:{ id: id },
                    success:function(res)
                    {
                        res = JSON.parse(res);
                        console.log(res);
                        if(res.response_code==200)
                        {
                            swal('success',res.msg,'success');
                            setTimeout(()=>{window.location.href="<?php echo base_url(); ?>Sensor_c"},200);
                        } else {
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
        var fileName = "device list.xlsx";
        var table = $("#data-table")[0];
        var ws = XLSX.utils.table_to_sheet(table);
        var wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, sheetName);
        XLSX.writeFile(wb, fileName);
    }
</script>
