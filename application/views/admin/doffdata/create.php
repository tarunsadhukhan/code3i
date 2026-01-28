  <!-- /.navbar -->

  <?php



use PHPUnit\TextUI\XmlConfiguration\CodeCoverage\Report\Php;

 $this->load->view('admin/header'); ?>

<style>
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
    }</style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-10">
          <h3 class="m-1 text-dark text-center" style="background-color: #1589FF;">Spinning Doff Entry</h3>

          </div><!-- /.col -->
          <div class="col-sm-2">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url().'admin/home'; ?>">Home</a></li>
              <li class="breadcrumb-item"><a href="<?php echo base_url().'admin/doffdata'; ?>">Doff Data</a></li>
              <li class="breadcrumb-item active">Spg Doff Entry</li>
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

						<div class="form-group col-md-3">
						  <label for="purchaseDetailsPurchaseDate">Doffing Date<span class="text-center">*</span></label>
						  <input type="text" style="height: 50px; color:blue; font-style: bold; font-size: 28px;"
               class="form-control datepicker text-center" id="payrollstartdate" 
              name="payrollstartdate"   readonly >
						</div>
			
            <div class="form-group col-md-3" style="margin-left: 50px;">
						  <label for="purchaseDetailsPurchaseDate">Record Time<span class="requiredIcon text-center">*</span></label>
						  <input type="text" 
              style="height: 50px; color:blue; font-style: bold; font-size: 28px;" 
              class="form-control  text-center" id="rec_time" name="payrolltime" value="0"  readonly >
						</div>
 

            <div class="form-group col-md-3"  style="margin-left: 50px;">
							<label for="purchaseDetailsVendorName">Spell<span class="requiredIcon text-center">*</span></label>
							<select id="shiftName" style="height: 50px; color:blue; font-style: bold; font-size: 28px;"
              name="shiftName" class="form-control chosenSelect  text-center">
        

              echo "<option value='A1' > A1</option>";
              echo "<option value='B1' > B1</option>";
              echo "<option value='A2' > A2</option>";
              echo "<option value='B2' > B2</option>";
              echo "<option value='C' > C</option>";
       

             
							</select>
						  </div>
              <?php
                  $company_id = $this->session->userdata('company_id');
                  $company_name = $this->session->userdata('company_name');
                //  echo $company_id;
              ?>
 
<input type="hidden" class="input" value="<?php echo $company_id; ?>" id="companyId" />
              <input type="hidden" class="input" id="fetchtnetwt" />
              
					  </div>
			
      
      

        <div class="row">
          <div class="col-md-1">
          
            <div class="form-group ">
                    <label >Frame No </label>
                    <input type="number" name="q" id="frameNo" value="" 
                    style="height: 100px; color:blue; font-style: bold; font-size: 38px; "
                    class="form-control text-center">
                    
            </div>
          </div>

          <div class="col-lg-2">
            <div class="form-group ">
                    <label >Trolly No </label>
                    <input type="number" name="trollyNo" id="trollyNo" value="" 
                    style="height: 100px; color:blue; font-style: bold; font-size: 38px;"
                    class="form-control text-center ">
            </div>
          </div> 
          <div class="col-lg-1">
          <div class="form-group ">
                    <label >Doff No </label>
                    <input type="number" name="framename" id="doffNo" value="" 
                    style="height: 100px; color:blue; font-style: bold; font-size: 38px; disabled:disabled" "
                    class="form-control text-center readonly">
            </div>
          </div>
          <div class="col-lg-2">
          <div class="form-group ">
                    <label >Gross Weight </label>
                    <input type="number" name="framename" id="grossWt" value="" 
                    style="height: 100px; color:blue; font-style: bold; font-size: 38px;"
                    class="form-control text-center ">
            </div>
          </div>
          <div class="col-lg-2">
          <div class="form-group ">
                    <label >Tare Weight </label>
                    <input type="text" name="framename" id="tareWt" value="" 
                    style="height: 100px; color:blue; font-style: bold; font-size: 38px;"
                    class="form-control text-center  readonly ">
            </div>
          </div>
          <div class="col-lg-2">
          <div class="form-group ">
                    <label >Net Weight </label>
                    <input type="text" name="framename" id="netWt" value="" 
                    style="height: 100px; color:blue; font-style: bold; font-size: 38px; maxlength: 2;"
                    class="form-control text-center  readonly">
            </div>
          </div>
          <div class="col-lg-2">
          <div class="form-group ">
                    <label >Total Net Weight </label>
                    <input type="text" name="framename" id="tnetWt" value="" 
                    style="height: 100px; color:blue; font-style: bold; font-size: 38px;"
                    class="form-control text-center  readonly">
                  
            </div>
          </div>



        </div> 
         
            

            <div class="card-footer"></div>
                <button name="submit" id="savebtn" type="submit" class="btn btn-primary">Save</button>


            </form>
       
            <h1>Record List</h1>
    <table id="recordTable">
        <thead>
            <tr>
                <th>Record ID</th>
                <th>Doff Date</th>
                <th>Spell</th>
                <th>Frame No</th>
                <th>Trolly No</th>
                <th>Gross Weight</th>
                <th>Tare Weight</th>
                <th>Net Weight</th>
                <th>Entry Time</th>
                
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

$("#payrollstartdate").datepicker({ 
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

                $('#payrollstartdate').datepicker('setDate', 'today');

setInterval(function() {




var now = new Date();
var outStr = ((now.getHours()<10?'0':'') + now.getHours() )+':'+((now.getMinutes()<10?'0':'') + now.getMinutes() )+':'+((now.getSeconds()<10?'0':'') + now.getSeconds() );
$('#rec_time').val(outStr);
}, 1000);


var newDate = new Date();
var ctime=new Date().toLocaleTimeString('en-GB');

var hr= ctime.substr(0, 2);
if (hr>='00' && hr<'06' ) {
  $('#payrollstartdate').datepicker('setDate', 'today-1');
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

$("#savebtn").attr('disabled',true);



</script>

<script>
        $(document).ready(function() {

          $('#frameNo').on('input', function() {
          var frameNo =  $('#frameNo').val();
          var payrollstartdate= $('#payrollstartdate').val();
          var shiftName= $('#shiftName').val();
          var companyId=$('#companyId').val();
          $('#grossWt').val(0);
        $.ajax({
            url: "<?php echo base_url('admin/Doffdata/fetch_data'); ?>",
            type: "POST",
            data: {frameNo: frameNo,payrollstartdate: payrollstartdate,shiftName: shiftName,companyId: companyId },
            dataType: "json",
            success: function(response) {
              if (response.success) {
                    $('#trollyNo').val(response.trollyNo);
                    $('#doffNo').val(response.doffNo);
                    $('#tareWt').val(response.trollyWt);
                    $('#tnetWt').val(response.tnetWt);
                    $('#fetchtnetwt').val(response.tnetWt);
                    $('#grossWt').val(0);
                    $("#grossWt").attr('disabled',false);
                   
                    var mcno=(response.mcno);
                    var ln=mcno.length;
//                    $("#savebtn").attr('disabled',false);
                    
                    $('#frameNo').css({'border-color': 'green','background-color': 'white'
                    });
                    if (ln==0)  {
                      $('#frameNo').css({'border-color': 'red','background-color': 'yellow'
                    });
                    $("#savebtn").attr('disabled',true);


                    }
                } else {
                    $('#frameNo').val('');
                    $('#trollyNo').val('0');
                    $("#grossWt").attr('disabled',true);
                    var mcno=('');
                    $('#grossWt').val(0);
                    $('#trollyNo').val('');
                    $('#doffNo').val('');
                    $('#tareWt').val('');
                    $('#tnetWt').val('');
                    $('#fetchtnetwt').val('');
                    $('#grossWt').val(0);

                    $("#savebtn").attr('disa568bled',true);

                }
            }
        });
//        refreshDataTable();

      });

      $('#frameNo').blur(function () {
        refreshDataTable();

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
                $('#netWt').val(0);
                $('#grossWt').val(0);
                if ($tw==0) {
                  $('#trollyNo').val('');
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
          netwt=(grossWt-tareWt).toFixed(2);
          var netwt=parseFloat(netwt);
          
          tnetWt=(fetchtnetwt+netwt).toFixed(2);
          if (netwt >5 & netwt<60 ) { 
             $('#netWt').val(netwt);
             $('#tnetWt').val(tnetWt);
             $("#savebtn").attr('disabled',false);
                     $('#netWt').css({'border-color': 'green','background-color': 'white'
                     });

                    }  else {
             $('#netWt').val(0);
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
          var frameNo=parseFloat(frameNo);
          if (frameNo==0) {
            alert('Please Check Frame No ');
            return false;
       		  
          }
         // alert(frameNo);
          var trollyNo=parseFloat(trollyNo);
          if (trollyNo==0) {
            alert('Please Check Trolly No ');
            return false;
       		  
          }

          if (netWt <5 & netWt>60 ) { 
            $('#grossWt').css({'border-color': 'red','background-color': 'yellow'
                    });
                    alert('Please Check Weight ');
       			return false;
    
          } 
          $.ajax({
            url: "<?php echo base_url('admin/Doffdata/save_data'); ?>",
            type: "POST",
            data: {frameNo: frameNo,payrollstartdate: payrollstartdate,shiftName: shiftName,companyId: companyId,
            rec_time: rec_time,trollyNo: trollyNo,tareWt: tareWt,grossWt: grossWt,netWt: netWt
            },
            dataType: "json",
            success: function(response) {
              var savedata=(response.savedata);
          //       alert(savedata);    
                $('#tnetWt').val('');
                $('#netWt').val('');
                $('#frameNo').val('');
                $('#trollyNo').val('');
                $('#doffNo').val('');
                $('#tareWt').val('');
                $('#grossWt').val('');
                
                $("#savebtn").attr('disabled',true);
                refreshDataTable();
        
                if (response.success) {
        //          refreshDataTable();
                    
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

            table = $('#recordTable').DataTable({
                ajax: {
                    url: '<?php echo base_url('admin/Doffdata/get_records'); ?>',
                    type: 'POST',
                    data: function(d) {
                        d.date = $('#payrollstartdate').val();
                        d.shift = $('#shiftName').val();
                        d.companyId=$('#companyId').val();
                        d.frameNo =  $('#frameNo').val();
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
                pageLength: 5, // Set the default number of rows per page to 25

                rowCallback: function(row, data, index) {
            // Example: Change row color if the value in the 3rd column (index 2) meets a condition
            if (data[9] =='W' ) { // Adjust the column index and condition as needed
                $(row).css('background-color', '#ccffcc'); // Light red for values > 100
            } else if (data[9] =='M') {
                $(row).css('background-color', '#ffcccc'); // Light green for values < 50
            } else {
                $(row).css('background-color', ''); // Reset to default
            }
        }

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


        $('#recordTable tbody').on('click', 'tr', function() {
                var rowData = table.row(this).data();
                $('#record_id').val(rowData[0]);
                $('#date').val(rowData[1]);
                $('#shift').val(rowData[2]);
                $('#mcno').val(rowData[3]);
                $('#weight').val(rowData[4]);
            });
        
            $('#recordTable tbody').on('click', 'tr', function() {
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                } else {
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                }
            });


            $('#payrollstartdate, #shiftName').on('change', function() {
               $('#tnetWt').val('');
                $('#netWt').val('');
                $('#frameNo').val('');
                $('#trollyNo').val('');
                $('#doffNo').val('');
                $('#tareWt').val('');
                $('#grossWt').val('');

                refreshDataTable();
            });

//end save
//$('#recordTable').DataTable();




</script>



</body>
</html>
