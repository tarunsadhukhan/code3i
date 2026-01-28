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

/* Define the color for the delete icon */


#recordTable {
        border-collapse: collapse;
        width: 100%;
    }

    #recordTable th,
    #recordTable td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #recordTable th {
        background-color: #f2f2f2;
    }

    #recordTable tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    #recordTable tr:hover {
        background-color: #ddd;
    }

    .selected {
        background-color: yellow;
    }
    #recordTable td.column-align-center {
        text-align: center;
    }

    #recordTable td.column-align-right {
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
.delete-icon {
    color: red;
}

/* CSS for the confirmation dialog */
.confirmation-dialog {
    background-color: #fff; /* Background color of the dialog box */
    border: 2px solid #333; /* Border color of the dialog box */
    padding: 20px; /* Padding inside the dialog box */
    text-align: center;
}

/* CSS for the "Yes" button */
.btn-yes {
    background-color: #FF0000; /* Red background color for "Yes" button */
    color: #FFF; /* Text color for "Yes" button */
    padding: 10px 20px; /* Padding for the button */
    border: none; /* Remove button border */
    cursor: pointer;
}

/* CSS for the "No" button */
.btn-no {
    background-color: #333; /* Background color for "No" button */
    color: #FFF; /* Text color for "No" button */
    padding: 10px 20px; /* Padding for the button */
    border: none; /* Remove button border */
    cursor: pointer;
}

    </style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
          <h3 class="m-1 text-dark text-center" style="background-color: #1589FF;"><strong>Daily Drawing Entry</strong></h3>

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
						<div class="form-group col-md-3">
						  <label for="purchaseDetailsPurchaseDate">Date<span class="text-center">*</span></label>
						  <input type="text" style="height: 40px; color:blue; font-style: bold; font-size: 20px;"
               class="form-control datepicker text-center" id="windingDate" 
              name="windingDate"   readonly >
						</div>
            <div class="form-group col-md-2"  style="margin-left: 30px;">
							<label for="purchaseDetailsVendorName">SHift<span class="requiredIcon text-center">*</span></label>
							<select id="shiftName" style="height: 40px; color:blue; font-style: bold; font-size: 20px;"
              name="shiftName" class="form-control chosenSelect  text-center">
              echo "<option value='A' > A</option>";
              echo "<option value='B' > B</option>";
              echo "<option value='C' > C</option>";
 							</select>
						  </div>
            <div class="form-group col-sm-2" style="margin-left: 20px;">
                    <label >Spell Hours(1) </label>
                    <input type="number" name="splhrs1" id="splhrs1" value=5
                    style="height: 40px; color:blue; font-style: bold; font-size: 20px;"
                    class="form-control text-center ">
           </div> 
           <div class="form-group col-sm-2" style="margin-left: 20px;">
                    <label >Spell Hours(2) </label>
                    <input type="number" name="splhrs2" id="splhrs2" value=3
                    style="height: 40px; color:blue; font-style: bold; font-size: 20px;"
                    class="form-control text-center ">
           </div> 





<?php
                  $company_id = $this->session->userdata('company_id');
                //  echo $company_id;
              ?>
 
<input type="hidden" class="input" value="<?php echo $company_id; ?>" id="companyId" />
              <input type="hidden" class="input" id="mc1_id" />
              <input type="hidden" class="input" id="spell" />
              <input type="hidden" class="input" id="mc3_id" />
              <input type="hidden" class="input" id="trollyid" />
             
					  </div>
			
      
      

        <div class="row">
        <div class="form-group col-md-2" style="margin-left: 20px;" >
							<label for="purchaseDetailsVendorName">MC NO 1<span class="requiredIcon text-center">*</span></label>
              <select class="form-group form-control select2" id="mc_no1" style=" font-size: 20px; height: 30px; ">
              echo "<option value=0 > Select.... </option>";
            <?php
                foreach ($data['wndmcdata'] as $each){	 
                   echo "<option value=".$each['mechine_id'].">".$each['mechine_name']."</option>"
                ?>
                <?php }  ?>
							</select>
            </div>
           <div class="form-group col-sm-1" style="margin-left: 30px;">
                    <label >Const Meter </label>
                    <input type="number" name="cmeter" id="cmeter" value=0
                    style="height: 40px; color:blue; font-style: bold; font-size: 20px;"
                    class="form-control text-center " readonly>

           </div> 
           <div class="form-group col-sm-1" style="margin-left: 30px;">
                    <label >Open Meter </label>
                    <input type="number" name="opmeter" id="opmeter" value=0
                    style="height: 40px; color:blue; font-style: bold; font-size: 20px;"
                    class="form-control text-center ">
           </div> 
           <div class="form-group col-sm-1" style="margin-left: 30px;">
                    <label >Close Meter(1) </label>
                    <input type="number" name="clmeter1" id="clmeter1" value=0
                    style="height: 40px; color:blue; font-style: bold; font-size: 20px;"
                    class="form-control text-center ">
           </div> 
           <div class="form-group col-sm-1" style="margin-left: 30px;">
                    <label >Close Meter(2) </label>
                    <input type="number" name="clmeter2" id="clmeter2" value=0
                    style="height: 40px; color:blue; font-style: bold; font-size: 20px;"
                    class="form-control text-center ">
           </div> 

           <div class="form-group col-sm-1" style="margin-left: 30px;">
                    <label >Diff Meter </label>
                    <input type="text" name="dfmeter" id="dfmeter" value=0
                    style="height: 40px; color:blue; font-style: bold; font-size: 20px;"
                    class="form-control text-center " readonly>
           </div> 

           <div class="form-group col-sm-1" style="margin-left: 30px;">
                    <label >Eff (%) </label>
                    <input type="text" name="eff" id="eff" value=0
                    style="height: 40px; color:blue; font-style: bold; font-size: 20px;"
                    class="form-control text-center " readonly>
           </div> 

           </div> 
            
           <div class="row">
           <div class="form-group col-sm-4" style="margin-left: 20px;">
                    <label >Remarks </label>
                    <input type="text" name="remarks" id="remarks" value=""
                    style="height: 40px; color:blue; font-style: bold; font-size: 20px;"
                    class="form-control text-center" maxlength="100">
           </div> 
           <div class="form-group col-sm-3" style="margin-left: 20px;">
                    <label >Upload Csv File </label>
                    <input type="file" accept=".csv" id="csv_files"   name="csv_files[]" multiple 
                   style="height: 40px; color:blue; font-style: bold; font-size: 20px;"
                    class="form-control text-center ">
           </div> 
      
           <div class="form-group col-md-2" style="margin-left: 0px;">
						  <label for="purchaseDetailsPurchaseDate">Save Data<span class="text-center"></span></label>
              <button name="submit" id="savewnddoff" style="height: 40px;" type="submit" class="form-control btn btn-primary">Save</button>
            </div>
            <div class="form-group col-md-2" style="margin-left: 0px;">
						  <label for="purchaseDetailsPurchaseDate">Update Data<span class="text-center"></span></label>
              <button name="submit" id="upload_button" style="height: 40px;" type="submit" class="form-control btn btn-primary">Update</button>
            </div>
            <div class="form-group col-md-2" style="margin-left: 0px;">
						  <label for="purchaseDetailsPurchaseDate">Export Data<span class="text-center"></span></label>
              <button name="submit" id="exportdbfdata" style="height: 40px;" type="submit" class="form-control btn btn-primary">Export</button>
            </div>
          
            </div> 
        

            </form>
       
            <h1>Record List</h1>
    <table id="recordTable">
        <thead>
            <tr>
                <th>Record ID</th>
                <th>Tran Date</th>
                <th>Spell</th>
                <th>Mc Code</th>
                <th>Mc Name</th>
                <th>Const Meter</th>
                <th>Open Meter</th>
                <th>Close Meter</th>
                <th>Diff Meter</th>
                <th>Eff(%)</th>
                <th>Wrokign Hrs</th>
                <th>Remarks</th>
                <th>Mc Id</th>
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

$("#windingDate").datepicker({ 
  dateFormat: 'dd-mm-yy',
					todayHighlight:'TRUE',
					autoclose: true,
          maxDate: '0',        });
                $("#payrollenddate").datepicker({ 
                  dateFormat: 'dd-mm-yy',
					todayHighlight:'TRUE',
					autoclose: true,
                });

                $('#windingDate').datepicker('setDate', 'today');

setInterval(function() {

var now = new Date();
var outStr = ((now.getHours()<10?'0':'') + now.getHours() )+':'+((now.getMinutes()<10?'0':'') + now.getMinutes() )+':'+((now.getSeconds()<10?'0':'') + now.getSeconds() );
$('#rec_time').val(outStr);
}, 1000);


var newDate = new Date();
var ctime=new Date().toLocaleTimeString('en-GB');

var hr= ctime.substr(0, 2);
 
$("#savewnddoff").attr('disabled',true);

$("#mc_no1").attr('disabled',false);
$("#mc_no2").attr('disabled',true);
$("#mc_no3").attr('disabled',true);

$("#ebno").attr('disabled',true);
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

            $('#shiftName').on('change', function() {
                var shiftName=$("#shiftName").val();
                if  (shiftName=='A')  {
                    $('#splhrs1').val(5);
                    $('#splhrs2').val(3);
                    $("#clmeter2").attr('disabled',false);
            }
                if  (shiftName=='B')  {
                    $('#splhrs1').val(3);
                    $('#splhrs2').val(5);
                    $("#clmeter2").attr('disabled',false);
                }
                if  (shiftName=='C')  {
                    $('#splhrs1').val(7.5);
                    $('#splhrs2').val(0);
                    $("#clmeter2").attr('disabled',true);
                }
                $('#cmeter').val(0);
                $('#opmeter').val(0);
                $('#clmeter1').val(0);
                $('#clmeter2').val(0);
                $('#dfmeter').val(0);
                $('#eff').val(0);
                $("#mc_no1").val(0);
                $("#mc_no1").trigger('change');


              });

$('#mc_no1').blur(function () {
 //  alert('mcno1');
   $('#clmeter1').focus();
  });

  $('#mc_no1').on('change', function() {
          var mcno1 =  $('#mc_no1').val();
          var windingDate= $('#windingDate').val();
          var shiftName= $('#shiftName').val();
          var companyId=$('#companyId').val();
          $.ajax({
            url: "<?php echo base_url('admin/Daily_spell_drawing_entry/mcno1_data'); ?>",
            type: "POST",
            data: {mcno1: mcno1,companyId: companyId,windingDate: windingDate,shiftName : shiftName },
            dataType: "json",
            success: function(response) {
              if (response.success) {
                $('#cmeter').val(response.constmtr);
                $('#opmeter').val(response.openmtr);
                $('#mc_no1').css({'border-color': 'green','background-color': 'white'
                    });
               } else {
                $('#cmeter').val(0);
                $('#opmeter').val(0);
                 $('#mc_no1').css({'border-color': 'red','background-color': 'yellow'
                    });
                $("#savewnddoff").attr('disabled',true);
                $('#mc_no1').focus();
                

              }
            }  
            });
 
              });


   
 


  
   

    $('#clmeter1').on('input', function() {
          var companyId=$('#companyId').val();
          var shiftName= $('#shiftName').val();
          var clmeter1 =$('#clmeter1').val();
          var clmeter1=parseFloat(clmeter1);
          var clmeter2 =$('#clmeter2').val();
          var clmeter2=parseFloat(clmeter2);
          var opmeter= $('#opmeter').val();
          var opmeter=parseFloat(opmeter);
          var cmeter= $('#cmeter').val();
          var cmeter=parseFloat(cmeter);
          var netwt=clmeter1-opmeter;
          var splhrs1= $('#splhrs1').val();
          var splhrs1=parseFloat(splhrs1);
          var splhrs2= $('#splhrs2').val();
          var splhrs2=parseFloat(splhrs1);
          var netwt1=clmeter2-clmeter1;
          var eff=0;
          if (netwt>=0 ) {
            $('#dfmeter').css({'border-color': 'green','background-color': 'white'
                     });
          if (clmeter2<=0 || netwt>0 ) {
             var netwt1=0;
             eff=(netwt/(cmeter/8*splhrs1) *100).toFixed(2);
             }
          if (netwt==0 || netwt1>0) {
            eff=(netwt1/(cmeter/8*splhrs2) *100).toFixed(2);
          }
          if (netwt>0 & netwt1>0) {
            eff=((netwt+netwt1)/cmeter/8*(splhrs1+splhrs2)*100).toFixed(2);
          }
          var dfm=netwt+netwt1;
        
          $('#dfmeter').val(dfm);
          $('#eff').val(eff);
          $('#dfmeter').css({'border-color': 'black','background-color': 'white'
                    });
            $("#savewnddoff").attr('disabled',false);
        if (shiftName!='C') {
          $('#clmeter2').val(clmeter1);
            
        }              
                    }  else {
            $('#dfmeter').css({'border-color': 'red','background-color': 'yellow'
                    });
            $("#savewnddoff").attr('disabled',true);
          } 
      });
        });

        $('#clmeter2').on('input', function() {
          var companyId=$('#companyId').val();
          var clmeter1 =$('#clmeter1').val();
          var clmeter1=parseFloat(clmeter1);
          var clmeter2 =$('#clmeter2').val();
          var clmeter2=parseFloat(clmeter2);
          var opmeter= $('#opmeter').val();
          var opmeter=parseFloat(opmeter);
          var cmeter= $('#cmeter').val();
          var cmeter=parseFloat(cmeter);
          var netwt=clmeter1-opmeter;
          var splhrs1= $('#splhrs1').val();
          var splhrs1=parseFloat(splhrs1);
          var splhrs2= $('#splhrs2').val();
          var splhrs2=parseFloat(splhrs2);
          var netwt1=clmeter2-clmeter1;
          var eff=0;
          if (netwt1>0) {
          if (netwt1<=0 & netwt>0 ) {
             var netwt1=0;
             eff=(netwt/(cmeter/8*splhrs1) *100).toFixed(2);
            }
          if (netwt==0 & netwt1>0) {
            eff=(netwt1/(cmeter/8*splhrs2) *100).toFixed(2);
          }
          if (netwt>0 & netwt1>0) {
            cm=cmeter/8*(splhrs1+splhrs2);
            dfm=netwt+netwt1;
            eff=( dfm/cm*100).toFixed(2);
 }
          var dfm=netwt+netwt1;
        //  alert(dfm);
          $('#dfmeter').val(dfm);
          $('#eff').val(eff);
          $('#dfmeter').css({'border-color': 'black','background-color': 'white'
                    });
            $("#savewnddoff").attr('disabled',false);
          }  else  {
            $('#dfmeter').css({'border-color': 'red','background-color': 'yellow'
                    });
            $("#savewnddoff").attr('disabled',true);
          } 
      });
  


//start save
        $("#savewnddoff").click(function(event){
          event.preventDefault(); 
          var companyId=$('#companyId').val();
          var windingDate= $('#windingDate').val();
          var shiftName= $('#shiftName').val();
          var mcno1= $('#mc_no1').val();
          var clmeter1= $('#clmeter1').val();
          var clmeter2= $('#clmeter2').val();
          var opmeter= $('#opmeter').val();
          var dfmeter= $('#dfmeter').val();
          var cmeter= $('#cmeter').val();
          var splhrs1= $('#splhrs1').val();
          var splhrs2= $('#splhrs2').val();
          var remarks= $('#remarks').val();
          if (mcno1==0) {
            alert('Please Enter Mc No');
            $('#mc_no1').focus().css("border-color", "red");
      			return false;
          }
          $.ajax({
            url: "<?php echo base_url('admin/Daily_spell_drawing_entry/savewnddoff_data'); ?>",
            type: "POST",
            data: {windingDate: windingDate,shiftName: shiftName,companyId: companyId,mcno1: mcno1,
            clmeter1: clmeter1,clmeter2: clmeter2,opmeter: opmeter,dfmeter: dfmeter,splhrs1:splhrs1,
            splhrs2:splhrs2,remarks:remarks,cmeter:cmeter
            },
            dataType: "json",
            success: function(response) {
              var savedata=(response.savedata);
              if (response.success) {
                $('#cmeter').val(0);
                $('#opmeter').val(0);
                $('#clmeter1').val(0);
                $('#clmeter2').val(0);
                $('#dfmeter').val(0);
                $('#eff').val(0);
                $("#mc_no1").val(0);
                $("#mc_no1").trigger('change');
                  alert('Record Added Successfully');
                  refreshDataTable();

                  }
            }
        });
 
      });

      initDataTable();
      function initDataTable() {
    table = $('#recordTable').DataTable({
        ajax: {
            url: '<?php echo base_url('admin/Daily_spell_drawing_entry/get_records'); ?>',
            type: 'POST',
            data: function(d) {
                d.date = $('#windingDate').val();
                d.shift = $('#shiftName').val();
                d.companyId=$('#companyId').val();
            }
        },
        columnDefs: [
            { targets: [0], visible: false }, // Hide the first column (auto_id)
            {
                targets: [5, 6],
                render: function(data, type, row, meta) {
                    return '<div class="column-align-right">' + data + '</div>';
                }
            },
        ],
        drawCallback: function() {
            // Apply alignment styles to the table cells
            $('#recordTable td.column-align-center').css('text-align', 'center');
            $('#recordTable td.column-align-right').css('text-align', 'right');
        },
        order: [[0, 'desc']], // Sort by the first column (auto_id) in descending order
        pageLength: 5 // Set the default number of rows per page to 25
    });
}

// Handle the click event for the "Delete" button
// Handle the click event for the "Delete" button
$('#recordTable tbody').on('click', 'button.delete-button', function () {
    var recordId = $(this).data('record-id');
    
    // Show a custom confirmation dialog
    var confirmationDialog = $('<div class="confirmation-dialog">Are you sure you want to delete this record?<br><button class="btn btn-yes">Yes</button><button class="btn btn-no">No</button></div>');
    
    confirmationDialog.dialog({
        resizable: false,
        modal: true,
        buttons: {
            "Yes": function() {
                $(this).dialog("close");
                deleteRecord(recordId);
            },
            "No": function() {
                $(this).dialog("close");
                // The user clicked "No," do nothing or provide feedback
            }
        }
    });
});

// Function to delete a record
function deleteRecord(recordId) {
  
  $.ajax({
    url: "<?php echo base_url('admin/Winding_doff_data/deleteRecord'); ?>",
            type: "POST",
            data: {recordId: recordId },
            dataType: "json",
            success: function(response) {
              var savedata=(response.savedata);
                 if (response.success) {
                    
                  alert('Record Deleted Successfully');
                  refreshDataTable();

                  }
         
                }
      
              });
}




    
        function refreshDataTable() {
          table.ajax.reload(null, false); // Reload the data without resetting the current page
        }


        $('#recordTable tbody').on('click', 'tr', function() {
                var rowData = table.row(this).data();
                $('#record_id').val(rowData[0]);
                $('#windingDate').val(rowData[1]);
                $('#spell').val(rowData[2]);
                $sft=rowData[2].substr(0,1);
//               $sft='A'; 
               $('#shiftName').val($sft);
                $("#mc_no1").val(rowData[12]);
                $("#mc_no1").trigger('change');
                $("#cmeter").val(rowData[5]);
                var mcno1 =  $('#mc_no1').val();
          var windingDate= $('#windingDate').val();
          var shiftName= $('#shiftName').val();
          var companyId=$('#companyId').val();

          $.ajax({
            url: "<?php echo base_url('admin/Daily_spell_drawing_entry/get_drgedit_data'); ?>",
            type: "POST",
            data: {mcno1: mcno1,companyId: companyId,windingDate: windingDate,shiftName : shiftName },
            dataType: "json",
            success: function(response) {
          if (response.success) {
                $('#opmeter').val(response.opmtr);
                $('#clmeter1').val(response.clmtr1);
                $('#clmeter2').val(response.clmtr2);
                $('#splhrs1').val(response.hrs1);
                $('#splhrs2').val(response.hrs2);
                $('#remarks').val(response.rem);
                var cmeter= $('#cmeter').val();
                var cmeter=parseFloat(cmeter);
                var splhrs1= $('#splhrs1').val();
                var splhrs1=parseFloat(splhrs1);
               var splhrs2= $('#splhrs2').val();
              var splhrs2=parseFloat(splhrs2);
                var netwt=parseFloat(response.dfm1);
                var netwt1=parseFloat(response.dfm2);
                 
                dfm=parseFloat(netwt)+parseFloat(netwt1);
                $('#dfmeter').val(dfm);
                if (netwt1<=0 & netwt>0 ) {
                  var netwt1=0;
                  var eff=(netwt/(cmeter/8*splhrs1) *100).toFixed(2);
          }
          if (netwt==0 & netwt1>0) {
              var eff=(netwt1/(cmeter/8*splhrs2) *100).toFixed(2);
          }
          if (netwt>0 & netwt1>0) {
            var cm=cmeter/8*(splhrs1+splhrs2);
            var dfm=netwt+netwt1;
            var eff=( dfm/cm*100).toFixed(2);
          }
          $('#eff').val(eff);
                 
                 

              }
            }  
            });



             });
        
            $('#recordTable tbody').on('click', 'tr', function() {
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                } else {
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                }
            });


            $('#windingDate, #shiftName,#mc_no1').on('change', function() {
               $('#tnetWt').val('');
                $('#mc1netWt').val('');
             
                $('#trollyNo').val('');
                $('#spoolwt').val('');
                $('#trollywt').val('');
                $('#grossWt').val('');
                $('#mc1netwt').val('');
                $('#mc2netwt').val('');
                $('#mc3netwt').val('');
                $('#trollyNo').val('');
                $('#trollywt').val('');
                $('#grosswt').val('');
                $('#mc1netwt').val('');
                $('#mc2netwt').val('');
                $('#mc3netwt').val('');
             
                refreshDataTable();
            });

            $("#exportdbfdata").click(function(event){
              event.preventDefault(); 
	          var payrollstartdate= $('#windingDate').val();
            var companyId=$('#companyId').val();
      
            var url = '<?php echo site_url("admin/Daily_spell_drawing_entry/exportdbfdata"); ?>' +
                      '?payrollstartdate=' + payrollstartdate +
                      '&companyId=' + companyId 
                      ;
//                      alert(url);
			//$(location).attr('href',url);
			window.open( url, '_blank');
			
			
return false;
});
 


            $("#upload_button").click(function(event){
          event.preventDefault(); 
          console.log('Before formData');
                var formData = new FormData();
                 console.log('After formData');
 
                var files = $('#csv_files')[0].files;
                console.log('After getting files');

                 for (var i = 0; i < files.length; i++) {
                 //   alert(i);
                    formData.append('csv_files[]', files[i]);
                }
alert(formData);
                $.ajax({
                    url: "<?php echo base_url('admin/reports/Daily_batch_report/uploadAndInsertCSV'); ?>",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#upload_status').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        $('#upload_status').html('Error: ' + xhr.responseText);
                    }
                });
              });




</script>



</body>
</html>
