  <!-- /.navbar -->

  <?php



use PHPUnit\TextUI\XmlConfiguration\CodeCoverage\Report\Php;

 $this->load->view('admin/header'); ?>

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="<?php echo base_url()?>public/admin/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url()?>public/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url()?>public/admin/dist/js/adminlte.min.js"></script>

 
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>


<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
<!--
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
-->
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
   <!-- Select2 -->
   <link rel="stylesheet" href="<?php echo base_url()?>public/admin/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo base_url()?>public/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <script src="<?php echo base_url()?>public/admin/plugins/select2/js/select2.full.min.js"></script>
   



<style>



#qcrecordTable {
        border-collapse: collapse;
        width: 100%;
    }

    #qcrecordTable th,
    #qcrecordTable td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #qcrecordTable th {
        background-color: #f2f2f2;
    }

    #qcrecordTable tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    #qcrecordTable tr:hover {
        background-color: #ddd;
    }

    .selected {
        background-color: yellow;
    }
    #qcrecordTable td.column-align-center {
        text-align: center;
    }

    #qcrecordTable td.column-align-right {
        text-align: right;
    }
    
    
    .select2-selection__rendered {
    line-height: 50px !important;
    
}
.select2-container .select2-selection--single {
    height: 50px !important;
    font-size: 20px;
    font-style: bold;
    color: #FFFFFF;
}
.select2-selection__arrow {
    height: 50px !important;
}


    </style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
          <h3 class="m-1 text-dark text-center" style="background-color: #1589FF;"><strong>Winding Data Checklists</strong></h3>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
      <div class="card-body">
      <form name="categoryForm" id="categoryForm" method="" 
            action=""  >

      <div class="form-row">

						<div class="form-group col-md-2">
						  <label for="purchaseDetailsPurchaseDate">Date<span class="text-center">*</span></label>
						  <input type="text" style="height: 50px; color:blue; font-style: bold; font-size: 28px;"
                            class="form-control datepicker text-center" id="windingrepDate" 
                            name="windingrepDate"   readonly >
						</div>
                        <div class="form-group col-md-1"  style="margin-left: 20px;">
							<label for="purchaseDetailsVendorName">Spell<span class="requiredIcon text-center">*</span></label>
							<select id="repshiftName" style="height: 50px; color:blue; font-style: bold; font-size: 28px;"
                              name="repshiftName" class="form-control chosenSelect  text-center">
        

              echo "<option value='A1' > A1</option>";
              echo "<option value='B1' > B1</option>";
              echo "<option value='A2' > A2</option>";
              echo "<option value='B2' > B2</option>";
              echo "<option value='C' > C</option>";
       

             
							</select>

            </div>
   
 
       
  
           <div class="form-group col-md-2" style="margin-left: 20px;">
						  <label for="purchaseDetailsPurchaseDate">Att Checklist<span class="text-center"></span></label>
              <button name="submit" id="attwndchk" style="height: 50px;" type="submit" class="form-control btn btn-primary">Attendance Checklist</button>
            
            </div>
        <div class="form-group col-md-2" style="margin-left: 20px;">
						  <label for="purchaseDetailsPurchaseDate">Mpaped Data<span class="text-center"></span></label>
              <button name="submit" id="getprddata" style="height: 50px;" disabled="disabled" type="submit" class="form-control btn btn-primary">Mapped data</button>
              <div id="loadingSpinner" style="display: none;">
              <img src="ajax-loader.gif" alt="Loading..." /> Loading...
        </div>

            </div>
            <div class="form-group col-md-2" style="margin-left: 20px;">
						  <label for="purchaseDetailsPurchaseDate">Export Data<span class="text-center"></span></label>
              <button name="submit" id="expwnddata" style="height: 50px;" type="submit" class="form-control btn btn-primary">Export Data</button>
            </div>
            <div class="form-group col-md-2" style="margin-left: 20px;">
						  <label for="purchaseDetailsPurchaseDate">Mechine Wise Details Report<span class="text-center"></span></label>
              <button name="submit" id="expmcdata" style="height: 50px;" type="submit" class="form-control btn btn-primary">Mechine Wise Details Report</button>
            </div>



 <?php
                  $company_id = $this->session->userdata('company_id');
                //  echo $company_id;
              ?>
 
<input type="hidden" class="input" value="<?php echo $company_id; ?>" id="companyId" />
              <input type="hidden" class="input" id="mc1_id" />
              <input type="hidden" class="input" id="record_id" />
              <input type="hidden" class="input" id="mc3_id" />
              <input type="hidden" class="input" id="trollyid" />
 
              


					  </div>
			
      
      

 
        

         
            

         


            </form>
       
            <h1>Winding Quality  List</h1>
    <table id="qcrecordTable">
        <thead>
            <tr>
                <th>Date </th>
                <th>Shift</th>
                <th>MC No</th>
                <th>Emp Code</th>
                <th>Emp Name</th>
                <th>Q Code</th>
                <th>Quality</th>
                <th>Production</th>
                <th>W.Hours</th>
                <th>No of Spindle</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
           
       
 
          
            </div><!-- /.card -->
          <!-- /.col-md-6 -->
          <div class="col-lg-6">
            <div class="card">
            </div>

          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php $this->load->view('admin/footer'); ?>



<script>
$(function () {
  
     //Initialize Select2 Elements
    
    $('.select2').select2();

//Initialize Select2 Elements
$('.select2bs4').select2({
  theme: 'bootstrap4'
})



  $( ".selector" ).datepicker( "setDate", new Date());

  
 
})
//$(".datepicker").datepicker({maxDate: '0'});

$("#windingrepDate").datepicker({ 
  dateFormat: 'dd-mm-yy',
					todayHighlight:'TRUE',
					autoclose: true,
                    maxDate: '0',
                });
                $("#payrollenddate").datepicker({ 
                  dateFormat: 'dd-mm-yy',
					todayHighlight:'TRUE',
					autoclose: true,
                });

                $('#windingrepDate').datepicker('setDate', 'today');

setInterval(function() {




var now = new Date();
var outStr = ((now.getHours()<10?'0':'') + now.getHours() )+':'+((now.getMinutes()<10?'0':'') + now.getMinutes() )+':'+((now.getSeconds()<10?'0':'') + now.getSeconds() );
$('#rec_time').val(outStr);
}, 1000);


var newDate = new Date();
var ctime=new Date().toLocaleTimeString('en-GB');

var hr= ctime.substr(0, 2);
if (hr>='00' && hr<'06' ) {
    $("#shiftName").val('C');
}
if (hr>'22'  ) {
    $("#shiftName").val('C');
}
if (hr>='06' && hr<'11' ) {
    $("#shiftName").val('A1');
}
if (hr>='11' && hr<'14' ) {
    $("#shiftName").val('B1');
}
if (hr>='14' && hr<'17' ) {
    $("#shiftName").val('A2');
}
if (hr>='17' && hr<'22' ) {
    $("#shiftName").val('B2');
}

$("#savewnddoff").attr('disabled',true);

$("#mc_no1").attr('disabled',false);
$("#mc_no2").attr('disabled',true);
$("#mc_no3").attr('disabled',true);

$("#trollywt").attr('disabled',true);
$("#spoolwt").attr('disabled',true);
$("#mc1netwt").attr('disabled',true);
$("#mc2netwt").attr('disabled',true);
$("#mc3netwt").attr('disabled',true);


$('#nomcs').focus();
$('#nomcs').select();

 
</script>

<script>
        $(document).ready(function() {
            $('input[type="text"]').on('focus', function() {
                $(this).select();
            });

  
   

       
 
        });

//start save
        $("#savewndqc").click(function(event){
          event.preventDefault(); 
          var companyId=$('#companyId').val();
          var windingqcDate= $('#windingqcDate').val();
          var qcshiftName= $('#qcshiftName').val();
          var nospool= $('#nospool').val();
          var mcno1= $('#mc_no1').val();
          var quality_id= $('#quality_id').val();
          var record_id= $('#record_id').val();
          if (record_id==0) {
            alert('Please Enter Any Record');
            $('#mc_no1').focus().css("border-color", "red");
      			return false;
          }
          
          if (mcno1==0) {
            alert('Please Enter Mc No');
            $('#mc_no1').focus().css("border-color", "red");
      			return false;
          }
       
          if (quality_id==0) {
            alert('Please Select Quality');
            $('#quality_id').focus().css("border-color", "red");
      			return false;
          }
          if ( (nospool)<=0 || (nospool>16) )  {
            alert('Please Enter  No of Spindle between 1 to 16');
            $('#nospool').focus().css("border-color", "red");
      			return false;
          }
 
          $.ajax({
            url: "<?php echo base_url('admin/Winding_quality_entry/savewndqc_data'); ?>",
            type: "POST",
            data: {windingqcDate: windingqcDate,qcshiftName: qcshiftName,companyId: companyId,
            mcno1: mcno1,
            nospool:nospool,quality_id:quality_id,record_id:record_id
            },
            dataType: "json",
            success: function(response) {
              var savedata=(response.savedata);
                $("#mc_no1").val(0);
                $("#mc_no1").trigger('change');
                $("#quality_id").val(0);
                $("#quality_id").trigger('change');
                $("#nospool").val(0);
                if (response.success) {
                    
                  alert('Record Added Successfully');
                  refreshDataTable();

                  }
            }
        });
 
      });

      initDataTable();
      function initDataTable() {
           //   alert('ada');  
           $('#qcrecordTable').DataTable().destroy();

            table = $('#qcrecordTable').DataTable({
                ajax: {
                    url: '<?php echo base_url('admin/reports/Winding_data_reports/get_wndreprecords'); ?>',
                    type: 'POST',
                    data: function(d) {
                        d.date = $('#windingrepDate').val();
                        d.shift = $('#repshiftName').val();
                        d.companyId=$('#companyId').val();
                    }
                  },columnDefs: [
                    { targets: [0], visible: true }, // Hide the first column (auto_id)
                    { targets: [3], visible: true },{
                    targets: [5, 6],
                    render: function(data, type, row, meta) {
                        return '<div class="column-align-right">' + data + '</div>';
                    }
                  }
                ],
                "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
        //          var ln = aData[4].length; 
                     // alert(ln);
                if   (aData[4]==null)    {
                  $('td', nRow).css('background-color', 'Red');
                } 
                 },

                drawCallback: function() {
                // Apply alignment styles to the table cells
                $('#recordTable td.column-align-center').css('text-align', 'center');
                $('#recordTable td.column-align-right').css('text-align', 'right');
            },
                order: [[0, 'desc']],                 // Sort by the first column (auto_id) in descending order
                pageLength: 10 // Set the default number of rows per page to 25
              });
        }
   
        function refreshDataTable() {
          table.ajax.reload(null, false); // Reload the data without resetting the current page
        }


        $('#qcrecordTable tbody').on('click', 'tr', function() {
                var rowData = table.row(this).data();
                $('#record_id').val(rowData[0]);
                $("#mc_no1").val(rowData[3]).trigger("change");
                $("#quality_id").val(rowData[5]).trigger("change");
                $('#nospool').val(rowData[7]);
            });
        
            $('#recordTable tbody').on('click', 'tr', function() {
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                } else {
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                }
            });


            $('#windingrepDate, #repshiftName').on('change', function() {
                $('#record_id').val(0);
             
                initDataTable();

//                refreshDataTable();
            });

$("#getprddata").click(function(event){
          event.preventDefault(); 
          $("#loadingSpinner").show();
          var windingrepDate = $('#windingrepDate').val();
             var companyId=$('#companyId').val();
             var repshiftName= $('#repshiftName').val(); 
             var remno=1;
             alert (windingrepDate);
          $.ajax({
            url: "<?php echo base_url('admin/reports/Winding_data_reports/get_wnduprecords'); ?>",
            type: "POST",
            data: {windingrepDate: windingrepDate,repshiftName: repshiftName,companyId: companyId,remno: remno
            },
            dataType: "json",
            success: function(response) {
              var savedata=(response.savedata);
            //  alert(savedata) ;               
               
                if (response.success) {
                    alert(savedata);    
                    $("#loadingSpinner").hide();
                 } else { 
                  alert(savedata);    
                    $("#loadingSpinner").hide();
          
              }
            }
        });
        refreshDataTable();
      });


  $("#expwnddata").click(function(event){
  event.preventDefault(); 
	alert ("aaaa");
	var opt=3;
            var payrollstartdate= $('#windingrepDate').val();
            var companyId=$('#companyId').val();

            var url = '<?php echo site_url("admin/reports/winding_data_reports/exportdbfdata"); ?>' +
                      '?date=' + payrollstartdate +
                      '&companyId=' + companyId 
                      ;
                      alert(url);
			//$(location).attr('href',url);
			window.open( url, '_blank');
return false;
});


$("#attwndchk").click(function(event){
  event.preventDefault(); 
	//alert ("aaaa");
  chkDataTable();
return false;
});


function chkDataTable() {
  $('#qcrecordTable').DataTable().destroy();
  table = $('#qcrecordTable').DataTable({
                ajax: {
                    url: '<?php echo base_url('admin/reports/Winding_data_reports/get_attwndchkrecords'); ?>',
                    type: 'POST',
                    data: function(d) {
                        d.date = $('#windingrepDate').val();
                        d.shift = $('#repshiftName').val();
                        d.companyId=$('#companyId').val();
                    }
                  },columnDefs: [
                    { targets: [0], visible: true }, // Hide the first column (auto_id)
                    { targets: [3], visible: true },{
                    targets: [5, 6],
                    render: function(data, type, row, meta) {
                        return '<div class="column-align-right">' + data + '</div>';
                    }
                  }
                ],
                "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                   
                if (aData[7] == 0)    {
                  $('td', nRow).css('background-color', 'Red');
                } 
                 },

                drawCallback: function() {
                // Apply alignment styles to the table cells
                $('#recordTable td.column-align-center').css('text-align', 'center');
                $('#recordTable td.column-align-right').css('text-align', 'right');
            },
                order: [[0, 'desc']],                 // Sort by the first column (auto_id) in descending order
                pageLength: 10 // Set the default number of rows per page to 25
              });
        }
  

        $("#expmcdata").click(function(event){
                  event.preventDefault(); 
        	var opt=3;
            var windingrepDate= $('#windingrepDate').val();
            var companyId=$('#companyId').val();
            var repshiftName=$('#repshiftName').val();
            alert(repshiftName);
            var url = '<?php echo site_url("admin/reports/winding_data_reports/expmcdataexl"); ?>' +
                      '?windingrepDate=' + windingrepDate +
                      '&repshift=' + repshiftName +
                      '&companyId=' + companyId 
                      ;
                      alert(url);
			//$(location).attr('href',url);
			window.open( url, '_blank');
			
			
return false;
});


$("#expmcdata1").click(function(event){
          event.preventDefault(); 
          var windingrepDate = $('#windingrepDate').val();
             var companyId=$('#companyId').val();
             var repshiftName= $('#repshiftName').val(); 
             alert (windingrepDate);
          $.ajax({
            url:  '<?php echo site_url("admin/reports/winding_data_reports/expmcdataexl"); ?>',
            type: "POST",
            data: {windingrepDate: windingrepDate,repshiftName: repshiftName,companyId: companyId
            }
            });
            alert(url);
			//$(location).attr('href',url);
			window.open( url, '_blank');
			
			
return false;
  
        });






</script>



</body>
</html>
