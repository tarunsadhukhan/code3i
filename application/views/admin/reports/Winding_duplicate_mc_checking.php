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



#mcduprecordTable {
        border-collapse: collapse;
        width: 100%;
    }

    #mcduprecordTable th,
    #mcduprecordTable td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #mcduprecordTable th {
        background-color: #f2f2f2;
    }

    #mcduprecordTable tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    #mcduprecordTable tr:hover {
        background-color: #ddd;
    }

    .selected {
        background-color: yellow;
    }
    #mcduprecordTable td.column-align-center {
        text-align: center;
    }

    #mcduprecordTable td.column-align-right {
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
          <h3 class="m-1 text-dark text-center" style="background-color: #1589FF;"><strong>Winding Double Mechine Check</strong></h3>

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
                            class="form-control datepicker text-center" id="windingmcdupDate" 
                            name="windingmcdupDate"   readonly >
						</div>
                        <div class="form-group col-md-1"  style="margin-left: 20px;">
							<label for="purchaseDetailsVendorName">Spell<span class="requiredIcon text-center">*</span></label>
							<select id="mcdupshiftName" style="height: 50px; color:blue; font-style: bold; font-size: 28px;"
                              name="mcdupshiftName" class="form-control chosenSelect  text-center">
        

              echo "<option value='A1' > A1</option>";
              echo "<option value='B1' > B1</option>";
              echo "<option value='A2' > A2</option>";
              echo "<option value='B2' > B2</option>";
              echo "<option value='C' > C</option>";
       

             
							</select>
						  </div>
                          <div class="form-group col-md-2" style="margin-left: 20px;" >
							<label for="purchaseDetailsVendorName">MC NO <span class="requiredIcon text-center">*</span></label>
              <select class="form-group form-control select2" id="dupmc_no1" style=" font-size: 28px; height: 50px; ">
              echo "<option value=0 > Select.... </option>";
            <?php
                foreach ($data['wndmcdata'] as $each){	 
                   echo "<option value=".$each['mechine_id'].">".$each['mechine_name']."</option>"
                ?>
                <?php }  ?>
							</select>
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
    <table id="mcduprecordTable">
        <thead>
            <tr>
                <th>Record ID</th>
                <th>Date </th>
                <th>Spell</th>
                <th>Eb No</th>
                <th>Att Designation</th>
                <th>Mc Designation</th>
                <th>Mechine</th>
                <th>Action</th>
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

$("#windingmcdupDate").datepicker({ 
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

                $('#windingmcdupDate').datepicker('setDate', 'today');

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

 
      initDataTable();
      function initDataTable() {

            table = $('#mcduprecordTable').DataTable({
                ajax: {
                    url: '<?php echo base_url('admin/Winding_quality_entry/get_wndmcduprecords'); ?>',
                    type: 'POST',
                    data: function(d) {
                        d.date = $('#windingmcdupDate').val();
                        d.shift = $('#mcdupshiftName').val();
                        d.companyId=$('#companyId').val();
                        d.mcno1=$('#dupmc_no1').val();
                    }
                  },columnDefs: [
                    { targets: [0], visible: true }, // Hide the first column (auto_id)
                    { targets: [3], visible: true },{
                    targets: [5, 6],
                    render: function(data, type, row, meta) {
                        return '<div class="column-align-right">' + data + '</div>';
                    }
                  },
                  {
                targets: -1, // The last column
                render: function(data, type, row, meta) {
                  return '<button class="delete-button" data-record-id="' + row[0] + '"><i class="fas fa-trash"></i></button>';
               //   return '<button class="delete-button" data-record-id="' + row[0] + '">Delete</button>';
                }
            }

                ],
                drawCallback: function() {
                // Apply alignment styles to the table cells
                $('#mcduprecordTable td.column-align-center').css('text-align', 'center');
                $('#mcduprecordTable td.column-align-right').css('text-align', 'right');
            },
                order: [[0, 'asc']],                 // Sort by the first column (auto_id) in descending order
                pageLength: 10 // Set the default number of rows per page to 25
              });
        }
   
        $('#mcduprecordTable tbody').on('click', 'button.delete-button', function () {
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
    url: "<?php echo base_url('admin/Winding_doff_data/mcdupdeleteRecord'); ?>",
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


            $('#windingmcdupDate, #mcdupshiftName,#dupmc_no1').on('change', function() {
                $('#record_id').val(0);
                $("#mc_no1").val(0).trigger("change");
                $("#quality_id").val(0).trigger("change");
                $('#nospool').val(0);
              
                refreshDataTable();
            });

$("#getwndqc").click(function(event){
          event.preventDefault(); 
          var windingqcDate = $('#windingqcDate').val();
             var companyId=$('#companyId').val();
             var qcshiftName= $('#qcshiftName').val(); 
             alert (windingqcDate);
          $.ajax({
            url: "<?php echo base_url('admin/Winding_quality_entry/getwndqcode_data'); ?>",
            type: "POST",
            data: {windingqcDate: windingqcDate,qcshiftName: qcshiftName,companyId: companyId
            },
            dataType: "json",
            success: function(response) {
              var savedata=(response.savedata);
                $('#tnetWt').val('');
                $('#netWt').val('');
                $('#frameNo').val('');
                $('#trollyNo').val('');
                $('#doffNo').val('');
                $('#tareWt').val('');
                $('#grossWt').val('');
                
               
                if (response.success) {
                    alert(savedata);    
              }
            }
        });
        refreshDataTable();
      });







</script>



</body>
</html>
