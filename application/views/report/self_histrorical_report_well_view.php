
<style type="text/css">
    .select2-container--default .select2-selection--single{
        border: 1px solid #8299b557;
    }
    .select2-container .select2-selection--single{
        height: 38px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered{
        line-height: 35px;
    }
    table thead tr th{
        background: #daebf9 !important;
    }
    .form-label{
        font-size: 15px;
    }
     #export_btns{
        font-size: 16px;
        padding: 3px 13px;
    }
    #export_btns i{
        margin-right: -20px;
        position: relative;
        opacity: 0; 
        transition: all 0.5s ease-out;
    }
    #export_btns:hover i{
        opacity: 1; 
        margin-right: 2px;
    }
     #back_btns{
        font-size: 16px;
        padding: 3px 13px;
    }
    #back_btns i{
        margin-right: -20px;
        position: relative;
        opacity: 0; 
        transition: all 0.5s ease-out;
    }
    #back_btns:hover i{
        opacity: 1; 
        margin-right: 2px;
    }
</style>
<div class="page-wrapper">
    <div class="content container-fluid pb-0">
        <div class="page-header">
            <div class="content-page-header">
                <h5>Historical Report</h5>
            </div>  
        </div>
            <div class="row">                   
                    
            <div class="col-lg-12">
                <div class="card">
                   
                    <div class="card-body">
                       <div class="row align-items-center">
                            <div class="col">
                               <h4 class="header-title mb-4"><b>Historical Report</b></h4>
                            </div>

                    <div class="col-auto float-end ms-auto">
                        <button type="button" id="export_btns" onclick="export_report();" class="btn btn-outline-success button"> <i class="fa-solid fa-file-excel"></i> Export</button>
                         
                        <a href="Selfflow_c">
                            <button type="button" id="back_btns" class="btn btn-outline-warning button">
                                <i class="fa-solid fa-left-long"></i> Back
                            </button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="filter-section" style="padding: 15px 20px;">
                <div class="col-xl-12">
                    <div class="row">
                        <div class="form-group col-md-4">
                                <h5><b>Well  Name</b></h5>
                                <select name="well_id" id="well_id" class="form-control select2" onchange="get_mis_report();">
                                 
                                    <?php 
                                    if (!empty($well_list))
                                    {
                                        foreach ($well_list as $key => $value)
                                        {
                                            ?>
                                                <option <?php if ($this->uri->segment(3) == $value['well_id']) {echo 'selected="selected"';} ?> value="<?php echo $value['well_id']; ?>">
                                                  <?php echo $value['well_name']; ?>
                                             </option>

                                            <?php
                                        }
                                    }

                                    ?>
                                </select>
                            </div>

                                <div class="form-group col-md-4">
                                    <h5><b>From Date</b></h5>
                                    <input type="date" name="from_date" id="from_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" onchange="get_mis_report();get_installation_date();">
                                </div>

                                <div class="form-group col-md-4">
                                    <h5><b>To Date</b></h5>
                                    <input type="date" name="to_date" id="to_date" class="form-control" value="<?php echo date('Y-m-d'); ?>"  onchange="get_mis_report();get_installation_date();">
                                </div>
                            </div>
           
                             <div class="table-responsive mt-4">
                                <table class="table table-bordered border-bottom table-striped" id="data-table">
                                      <thead style="background-color:blue; color: white; text-align: center;">
                                        <tr>
                                          <th colspan="25" class="text-uppercase" style="font-size: 20px;font-weight: bolder;">IOT BASED REAL TIME WELL MONITORING SYSTEM ONGC,CAMBAY ASSET</th>
                                        </tr>
                                        <tr>
                                            <th colspan="25" class="text-uppercase" style="font-size: 15px;font-weight: bolder;" id="report-heading"> Historical Report as on </th>
                                        </tr>
                                        <tr>
                                            <th style="width:10%;">Sl No.</th>
                                            <th>Last Log Date Time</th>
                                            <th>GIP</th>
                                            <th>CHP</th>
                                            <th>THP</th>
                                            <th>ABP</th>
                                            <th>THT</th>
                                            <th>Battery Voltage</th>
                                            <th>Target Time</th>
                                            <th>On Time</th>
                                            <th>OFf Time</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center" id="table_data"> 
                                    </tbody>
                                </table>


                                </div>

        </div>
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
        get_installation_date();
    function get_installation_date()
    {
        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();

        f_from_date = moment(from_date);
        t_to_date = moment(to_date);

        if(f_from_date.isValid())
        {
            $('#show_from_date').text(f_from_date.format("DD-MM-YYYY"));
            $('#to').show();
        }else{
            $('#show_from_date').text('');
        }

        if(t_to_date.isValid())
        {
            $('#show_to_date').text(t_to_date.format("DD-MM-YYYY"));
            $('#to').show();
        }else{
            $('#show_to_date').text('');
        }

        // Additional check to show only the 'from date' if from_date == to_date
          if (f_from_date.isValid() && t_to_date.isValid() && f_from_date.isSame(t_to_date, 'day')) {
            $('#show_to_date').text('');
            $('#to').hide();

          }

    }
</script>
<script type="text/javascript">
	get_mis_report();
		function get_mis_report()
		{
			$('#table_data').html('<tr><td colspan="25">Processing please wait.......</td></tr>');
			var company_id = "<?php echo $this->session->userdata('company_id') ?>";
			var from_date = $('#from_date').val();
			var to_date = $('#to_date').val();
			var well_id = $('#well_id').val();
          
            var selectedWellName = $('#well_id option:selected').text();
            let formattedFromDate = moment(from_date, 'YYYY-MM-DD').format('DD-MM-YYYY');
            let formattedToDate = moment(to_date, 'YYYY-MM-DD').format('DD-MM-YYYY');
            let headingText = `  Historical Report of ${selectedWellName} from ${formattedFromDate} to ${formattedToDate}   `;
            $('#report-heading').text(headingText);

			$.ajax({
				url:'<?php echo base_url(); ?>Self_flow_well_historical_log_c/get_mis_report_histrorical',
				method:'POST',
				data:{company_id:company_id,from_date:from_date,to_date:to_date,well_id:well_id},
				success:function(res)
				{
					var response = JSON.parse(res);
					// console.log('mis',response);
				
					if(response.response_code==200)
		                {
		                    $('#table_data').html("");

                          
		                     if(response.data.length > 0)
		                     {
		                        $.each(response.data,function(i,v){

		                            $("#table_data").append('<tr>'+
		                                '<td>'+(i+1)+'</td>'+
                                        '<td>' + (v.Log_Date_Time !== null ? moment(v.Log_Date_Time).format('DD-MM-YYYY h:mm:ss a') : 'NA') + '</td>' +
                                       
                                       '<td>'+(v.PS_1_GIP != null ? v.PS_1_GIP : "")+'</td>'+
                                       '<td>'+(v.PS_2_CHP != null ? v.PS_2_CHP : "")+'</td>'+
                                       '<td>'+(v.PS_3_THP != null ? v.PS_3_THP : "")+'</td>'+
                                       '<td>'+(v.PS_4_ABP != null ? v.PS_4_ABP : "")+'</td>'+
                                        '<td>'+(v.FLTP_1_Temp != null ? v.FLTP_1_Temp : "")+'</td>'+
                                        '<td>'+(v.Battery_Voltage!=null? v.Battery_Voltage : "")+'</td>'+
                                        '<td>'+(v.TRGT_Time !== null ? v.TRGT_Time : '')+'</td>'+
                                        '<td>'+(v.ON_Time !== null ? v.ON_Time : '')+'</td>'+
                                        '<td>'+(v.Off_Time !== null ? v.Off_Time : '')+'</td>'+
		                            '</tr>');
		                        });
		                     }
		                     else{
		                        $('#table_data').html('<tr>'+
		                                 '<td class="text-danger" style="text-align:center;" colspan="25">No Record Found !!</td>'+
		                              '</tr>');
		                     }
		                }

				}
				
			});
		}

</script>


<script src="<?php echo base_url(); ?>assets/local/excel/xlsx.full.min.js"></script>
<script type="text/javascript">
    
    function export_report() {
      var sheetName = "Sheet1";
      var fileName = "Historical report.xlsx";
      var table = $("#data-table")[0];
      // Convert table to worksheet
      var ws = XLSX.utils.table_to_sheet(table);
      // Create a new workbook and add the worksheet to it
      var wb = XLSX.utils.book_new();
      XLSX.utils.book_append_sheet(wb, ws, sheetName);
      // Save the workbook as an Excel file and download it
      XLSX.writeFile(wb, fileName);
    }

</script>
         

