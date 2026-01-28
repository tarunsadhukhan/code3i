  <!-- /.navbar -->

  <?php



use PHPUnit\TextUI\XmlConfiguration\CodeCoverage\Report\Php;

 $this->load->view('admin/header'); ?>

<style>
    #frmqcrecordTable {
        border-collapse: collapse;
        width: 100%;
    }

    #frmqcrecordTable th,
    #frmqcrecordTable td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #frmqcrecordTable th {
        background-color: #f2f2f2;
    }

    #frmqcrecordTable tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    #frmqcrecordTable tr:hover {
        background-color: #ddd;
    }

    .selected {
        background-color: yellow;
    }
    #frmqcrecordTable td.column-align-center {
        text-align: center;
    }

    #frmqcrecordTable td.column-align-right {
        text-align: right;
    }</style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-10">
          <h3 class="m-1 text-dark text-center" style="background-color: #1589FF;">Daily Frame Quality Mapping</h3>
          </div><!-- /.col -->
          <div class="col-sm-2">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url().'admin/home'; ?>">Home</a></li>
              <li class="breadcrumb-item"><a href="<?php echo base_url().'admin/doffdata'; ?>">Doff Data</a></li>
              <li class="breadcrumb-item active">Frame Quality Entry</li>
            </ol>
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

      <?php
                  $company_id = $this->session->userdata('company_id');
                //  echo $company_id;
              ?>
 
    <input type="hidden" class="input" value="<?php echo $company_id; ?>" id="companyId" />

              <input type="hidden" class="input" id="record_id" />
						<div class="form-group col-md-3">
						  <label for="purchaseDetailsPurchaseDate">Doffing Date<span class="text-center">*</span></label>
						  <input type="text" style="height: 50px; color:blue; font-style: bold; font-size: 28px;"
               class="form-control datepicker text-center" id="doffqcdate" 
              name="doffqcdate"   readonly >
						</div>
			
            <div class="form-group col-md-2" style="margin-left: 50px;">
						  <label for="purchaseDetailsPurchaseDate">Record Time<span class="requiredIcon text-center">*</span></label>
						  <input type="text" 
              style="height: 50px; color:blue; font-style: bold; font-size: 28px;" 
              class="form-control  text-center" id="rec_time" name="payrolltime" value="0"  readonly >
						</div>
 

            <div class="form-group col-md-3"  style="margin-left: 50px;">
							<label for="purchaseDetailsVendorName">Shift<span class="requiredIcon text-center">*</span></label>
							<select id="doffqcshiftName" style="height: 50px; color:blue; font-style: bold; font-size: 28px;"
              name="doffqcshiftName" class="form-control chosenSelect  text-center">
              echo "<option value='A1' > A1</option>";
              echo "<option value='B1' > B1</option>";
              echo "<option value='A2' > A2</option>";
              echo "<option value='B2'  > B2</option>";
              echo "<option value='C' > C</option>";
							</select>
						  </div>
 
 
              <div class="form-group col-md-2" style="margin-left: 20px;">
						  <label for="purchaseDetailsPurchaseDate">Get Quality<span class="text-center"></span></label>
              <button name="submit" id="getfrmpqcode" style="height: 50px;" type="submit" class="form-control btn btn-primary">Get Quality</button>
            
            </div>


					  </div>
			
            <hr style="height:4px; background-color: brown;"></hr>
            <h4 align="center" style="font-family:Droid Serif">Frame Quality Details</h4>
            <hr style="height:4px; background-color: brown;"></hr>
   
      

        <div class="row">
        <div class="form-group col-md-2">
           
                    <label >Frame No </label>
                    <input type="text" name="q" id="qcframeNo" value="" 
                    style="height: 50px; color:blue; font-style: bold; font-size: 30px; "
                    class="form-control text-center" readonly>
           
          </div>
          <div class="form-group col-md-2">

         

           <label >Frame Name </label>
           <input type="text" name="q" id="qcframeName" value="" 
           style="height: 50px; color:blue; font-style: bold; font-size: 30px;    "
           class="form-control text-center " readonly >
  
 </div>

 
          <div class="form-group col-md-2">
                    <label >Q Code </label>
                    <input type="text" name="qcode_1" id="qcode_1" value="" 
                    style="height: 50px; color:blue; font-style: bold; font-size: 30px;"
                    class="form-control text-center ">
            </div>
            <div class="form-group col-md-3">
                    <label >Quality </label>
                    <input type="text" name="framename" id="quality1" value="" 
                    style="height: 50px; color:blue; font-style: bold; font-size: 28px; disabled:disabled" "
                    class="form-control text-center " readonly>
          </div>
 
  
          <div class="form-group col-md-2" style="margin-left: 20px;">
						  <label for="purchaseDetailsPurchaseDate">Update Data<span class="text-center"></span></label>
              <button name="submit" id="savefrmqc" style="height: 50px;" type="submit" class="form-control btn btn-primary">Save</button>
            
            </div>
            <div class="form-group col-md-2" style="margin-left: 20px;">
						  <label for="purchaseDetailsPurchaseDate">EB & Quality Mapping<span class="text-center"></span></label>
              <button name="submit" id="allpostfrmqc" style="height: 50px;" type="submit" class="form-control btn btn-primary">Mapped</button>
            
            </div>



        </div> 
         
            

 

            </form>
       
            <h1>Record List</h1>
    <table id="frmqcrecordTable">
        <thead>
            <tr>
                <th>Record ID</th>
                <th>Doff Date</th>
                <th>Spell</th>
                <th>Frame No</th>
                <th>Frame Name</th>
                <th>Q Code</th>
                <th>Quality</th>
                 
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
    

<script>
$(function () {
  
  $( ".selector" ).datepicker( "setDate", new Date());

  
 
})

$("#doffqcdate").datepicker({ 
  dateFormat: 'dd-mm-yy',
					todayHighlight:'TRUE',
					autoclose: true,
          maxDate: '0',                });
                $("#payrollenddate").datepicker({ 
                  dateFormat: 'dd-mm-yy',
					todayHighlight:'TRUE',
					autoclose: true,
                });

                $('#doffqcdate').datepicker('setDate', 'today');

setInterval(function() {




var now = new Date();
var outStr = ((now.getHours()<10?'0':'') + now.getHours() )+':'+((now.getMinutes()<10?'0':'') + now.getMinutes() )+':'+((now.getSeconds()<10?'0':'') + now.getSeconds() );
$('#rec_time').val(outStr);
}, 1000);

/*
var newDate = new Date();
var ctime=new Date().toLocaleTimeString('en-GB');

var hr= ctime.substr(0, 2);
 if (hr>='00' && hr<='06' ) {
    $("#shiftName").val('C');
}
if (hr>'22'  ) {
    $("#shiftName").val('C');
}
if (hr>'06' && hr<='11' ) {
    $("#shiftName").val('A1');
}
if (hr>'11' && hr<='14' ) {
    $("#shiftName").val('B1');
}
if (hr>'14' && hr<='17' ) {
    $("#shiftName").val('A2');
}
if (hr>'17' && hr<='22' ) {
    $("#shiftName").val('A2');
}
*/



</script>

<script>
        $(document).ready(function() {
           $('#qcode_1').on('input', function() {
          var qcode_1 =  $('#qcode_1').val();
          var companyId=$('#companyId').val();
        $.ajax({
            url: "<?php echo base_url('admin/Doffdata/frmqcget_quality'); ?>",
            type: "POST",
            data: {qcode_1: qcode_1,companyId: companyId },
            dataType: "json",
            success: function(response) {
              if (response.success) {
                    $('#quality1').val(response.name);
                     $("#savefrmqc").attr('disabled',false);
                    
                    $('#quality1').css({'border-color': 'green','background-color': 'white'
                    });
                    var quality1=$('#quality1').val();
                    var ln=length.quality1;
                    if (ln==0)  {
                      $('#quality1').css({'border-color': 'red','background-color': 'yellow'
                    });
                    $("#savefrmqc").attr('disabled',true);


                    }
                } else {
                    $('#trollyNo').val('0');
                    $('#quality1').css({'border-color': 'red','background-color': 'yellow'
                    });
                    $("#savefrmqc").attr('disabled',true);
                }
            }
        });
 
      });

    $('#trollyNo').on('input', function() {
          var trollyNo =  $('#trollyNo').val();
          var frameNo =  $('#frameNo').val();
          var companyId=$('#companyId').val();
        
          $.ajax({
            url: "<?php echo base_url('admin/Doffdata/trolly_data'); ?>",
            type: "POST",
            data: {trollyNo: trollyNo,companyId: companyId,frameNo: frameNo },
            dataType: "json",
            success: function(response) {
                $('#tareWt').val(response.trollyWt);
                $tw=$('#tareWt').val();
                $('#tareWt').css({'border-color': 'green','background-color': 'white'
                });
                $('#trollyNo').css({'border-color': 'green','background-color': 'white'
                });
                 
                if ($tw==0) {
                       $('#tareWt').css({'border-color': 'red','background-color': 'yellow'
                    });
                    $('#trollyNo').css({'border-color': 'red','background-color': 'yellow'
                    });
                    
                  }
                }
                });
    });


    $('#grossWt').on('input', function() {
          var grossWt =  $('#grossWt').val();
          var grossWt=parseFloat(grossWt);
          var tareWt= $('#tareWt').val();
          var tareWt=parseFloat(tareWt);
          var fetchtnetwt= $('#fetchtnetwt').val();
          var fetchtnetwt=parseFloat(fetchtnetwt);
          var tnetWt= $('#tnetWt').val();
          var tnetWt=parseFloat(tnetWt);
          var companyId=$('#companyId').val();
          netwt=grossWt-tareWt;
          tnetWt=fetchtnetwt+netwt;
          if (netwt >0 ) { 
             $('#netWt').val(netwt);
             $('#tnetWt').val(tnetWt);
             $("#savebtn").attr('disabled',false);
                     $('#netWt').css({'border-color': 'green','background-color': 'white'
                     });
          }  else {
           // netwt=0;
       //    alert(netwt);
             $('#netWt').val(netwt);
             $('#tnetWt').val(tnetWt);
             $('#netWt').css({'border-color': 'red','background-color': 'yellow'
                    });
                    $("#savebtn").attr('disabled',true);

          } 

      
      });


      $('#doffNo').prop('disabled', true);
      $('#netWt').prop('disabled', true);
      $('#tnetWt').prop('disabled', true);
      $('#tareWt').prop('disabled', true);
      
 
        });

//start save
        $("#savebtn").click(function(event){
          event.preventDefault(); 
          var frameNo =  $('#frameNo').val();
          var payrollstartdate= $('#payrollstartdate').val();
          var rec_time= $('#rec_time').val();
          var shiftName= $('#shiftName').val();
          var trollyNo= $('#trollyNo').val();
          var tareWt= $('#tareWt').val();
          var grossWt= $('#grossWt').val();
          var netWt= $('#netWt').val();
          var companyId=$('#companyId').val();
 
          $.ajax({
            url: "<?php echo base_url('admin/Doffdata/save_data'); ?>",
            type: "POST",
            data: {frameNo: frameNo,payrollstartdate: payrollstartdate,shiftName: shiftName,companyId: companyId,
            rec_time: rec_time,trollyNo: trollyNo,tareWt: tareWt,grossWt: grossWt,netWt: netWt
            },
            dataType: "json",
            success: function(response) {
              var savedata=(response.savedata);
                 alert(savedata);    
                $('#tnetWt').val('');
                $('#netWt').val('');
                $('#frameNo').val('');
                $('#trollyNo').val('');
                $('#doffNo').val('');
                $('#tareWt').val('');
                $('#grossWt').val('');
                

                if (response.success) {
                    alert('Record Added Successfully');
              }
            }
        });
/*
        var table = $('#recordTable').DataTable({
                ajax: {
                    url: '<?php echo base_url('admin/Doffdata/get_records'); ?>',
                    type: 'POST',
                    data: function(d) {
                        d.date = $('#payrollstartdate').val();
                        d.shift = $('#shiftName').val();
                        d.companyId=$('#companyId').val();
                    }
                }
            });
*/

      });

      initDataTable();
      function initDataTable() {
          var compid=$('#companyId').val();
//          alert(compid);
            table = $('#frmqcrecordTable').DataTable({
                ajax: {
                    url: '<?php echo base_url('admin/Doffdata/get_frmqcrecords'); ?>',
                    type: 'POST',
                    data: function(d) {
                        d.date = $('#doffqcdate').val();
                        d.shift = $('#doffqcshiftName').val();
                        d.compId=$('#companyId').val();
                    }
                  },columnDefs: [
                    { targets: [0], visible: false }, // Hide the first column (auto_id)
                    {
                    targets: [5, 6],
                    render: function(data, type, row, meta) {
                        return '<div class="column-align-right">' + data + '</div>';
                    }
                  }
                ],
                drawCallback: function() {
                // Apply alignment styles to the table cells
                $('#recordTable td.column-align-center').css('text-align', 'center');
                $('#recordTable td.column-align-right').css('text-align', 'right');
            },
                order: [[0, 'desc']],                 // Sort by the first column (auto_id) in descending order
                pageLength: 5 // Set the default number of rows per page to 25
              });
        }
/*
 createdCell: function(cell, cellData, rowData, rowIndex, colIndex) {
                // Customize cell color based on column and cell values
                if (colIndex >= 0 && colIndex <= 4 && parseInt(cellData) <= 5) {
                    $(cell).addClass('red-cell');
                } else if (colIndex >= 5 && colIndex <= 9 && parseInt(rowData[5]) > 20) {
                    $(cell).addClass('green-cell');
                }
            }

function initDataTable() {
            table = $('#recordTable').DataTable({
                ajax: {
                    url: '<?php echo base_url('record/get_records'); ?>',
                    type: 'POST',
                    data: function(d) {
                        d.date = $('#date').val();
                        d.shift = $('#shift').val();
                    }
                },
                order: [[0, 'desc']] // Sort by the first column (auto_id) in descending order
            });
*/

   
        function refreshDataTable() {
            table.ajax.reload(null, false); // Reload the data without resetting the current page
        }
        
 
 
 

        $('#frmqcrecordTable tbody').on('click', 'tr', function() {
                var rowData = table.row(this).data();
                $('#record_id').val(rowData[0]);
                $('#qcframeNo').val(rowData[3]);
                $('#qcframeName').val(rowData[4]);
                $('#qcode_1').val(rowData[5]);
                $('#quality1').val(rowData[6]);
            });
        
            $('#frmqcrecordTable tbody').on('click', 'tr', function() {
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                } else {
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                }
            });


            $('#doffqcdate, #doffqcshiftName').on('change', function() {
                $('#record_id').val(0);
                $('#qcframeNo').val('');
                $('#frameNo').val('');
                $('#qcframeName').val('');
                $('#qcode_1').val('');
                $('#quality1').val('');
                $('#grossWt').val('');

                refreshDataTable();
            });

//end save
//$('#recordTable').DataTable();

 
//start save
$("#getfrmpqcode").click(function(event){
          event.preventDefault(); 
          var doffdate = $('#doffqcdate').val();
             var companyId=$('#companyId').val();
             var doffshift= $('#doffqcshiftName').val(); 
          $.ajax({
            url: "<?php echo base_url('admin/Doffdata/savepfrmqcode_data'); ?>",
            type: "POST",
            data: {doffdate: doffdate,doffshift: doffshift,companyId: companyId
            },
            dataType: "json",
            success: function(response) {
              var savedata=(response.savedata);
                 alert(savedata);    
                $('#tnetWt').val('');
                $('#netWt').val('');
                $('#frameNo').val('');
                $('#trollyNo').val('');
                $('#doffNo').val('');
                $('#tareWt').val('');
                $('#grossWt').val('');
                
               
                if (response.success) {
                    alert('Record Added Successfully');
              }
            }
        });
        refreshDataTable();
      });


//start save
$("#savefrmqc").click(function(event){
          event.preventDefault(); 

          var doffqcdate = $('#doffqcdate').val();
          var companyId=$('#companyId').val();
          var doffqcshiftName= $('#doffqcshiftName').val(); 
          var qcframeNo= $('#qcframeNo').val(); 
          var qcode_1= $('#qcode_1').val(); 
          var record_id= $('#record_id').val(); 
          
          
            $.ajax({
            url: "<?php echo base_url('admin/Doffdata/updatefrmqcode_data'); ?>",
            type: "POST",
            data: {doffqcdate: doffqcdate,doffqcshiftName: doffqcshiftName,companyId: companyId,record_id: record_id,
              qcframeNo: qcframeNo,  qcode_1: qcode_1
            },
            dataType: "json",
            success: function(response) {
              var savedata=(response.savedata);
                 alert(savedata);    
                $('#qcframeNo').val('');
                $('#qcode_1').val('');
                $('#record_id').val('');
                $('#quality1').val('');
                $('#qcframeName').val('');
                 
               
                if (response.success) {
                    alert('Record Updated Successfully');
              }
            }
        });
        refreshDataTable();
      });

      $("#allpostfrmqc").click(function(event){
          event.preventDefault(); 
            var doffdate = $('#doffqcdate').val();
             var companyId=$('#companyId').val();
             var doffshift= $('#doffqcshiftName').val(); 
             document.getElementById("allpostfrmqc").disabled = true;
             document.getElementById("allpostfrmqc").style.backgroundColor = "#6BFF33"; // Set to red color as an example
             document.getElementById("allpostfrmqc").innerText = "Processing"; // Set to "New Text" as an example
          //   alert(doffdate);
          $.ajax({
            url: "<?php echo base_url('admin/Doffdata/updateebqc_data'); ?>",
            type: "POST",
            data: {doffdate: doffdate,doffshift: doffshift,companyId: companyId
            },
            dataType: "json",
            success: function(response) {
              var savedata=(response.savedata);
            //     alert(savedata);    
                $('#tnetWt').val('');
                $('#netWt').val('');
                $('#frameNo').val('');
                $('#trollyNo').val('');
                $('#doffNo').val('');
                $('#tareWt').val('');
                $('#grossWt').val('');
                if (response.success) {
                    alert('Record Added Successfully');
                    document.getElementById("allpostfrmqc").disabled = false;
                    document.getElementById("allpostfrmqc").style.backgroundColor = "#33A5FF"; // Set to red color as an example
                   document.getElementById("allpostfrmqc").innerText = "Mapped"; // Set to "New Text" as an example
              }
            }
        });
//        refreshDataTable();
      });






</script>



</body>
</html>
