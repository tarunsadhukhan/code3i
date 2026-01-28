  <!-- /.navbar -->

  <?php



use PHPUnit\TextUI\XmlConfiguration\CodeCoverage\Report\Php;

 $this->load->view('admin/header'); ?>

<style>
    #dofmodexprecordTable {
        border-collapse: collapse;
        width: 100%;
    }

    #dofmodexprecordTable th,
    #dofmodexprecordTable td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #dofmodexprecordTable th {
        background-color: #f2f2f2;
    }

    #dofmodexprecordTable tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    #dofmodexprecordTable tr:hover {
        background-color: #ddd;
    }

    .selected {
        background-color: yellow;
    }

    .selected td {
background-color: #AED6F1;
 /* color: skyblue; */
  font-weight: bold;
}


    #dofmodexprecordTable td.column-align-center {
        text-align: center;
    }
    #dofmodexprecordTable td.column-align-right {
        text-align: right;
    }</style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-10">
          <h3 class="m-1 text-dark text-center" style="background-color: #1589FF;">Spinning Doff Modification</h3>

          </div><!-- /.col -->
          <div class="col-sm-2">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url().'admin/home'; ?>">Home</a></li>
              <li class="breadcrumb-item"><a href="<?php echo base_url().'admin/doffdata'; ?>">Doff Data</a></li>
              <li class="breadcrumb-item active">Spg Doff Modification</li>
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
               class="form-control datepicker text-center" id="doffmodexpdate" 
              name="doffmodexpdate"   readonly >
						</div>
			
            <div class="form-group col-md-3" style="margin-left: 50px;">
						  <label for="purchaseDetailsPurchaseDate">Record Time<span class="requiredIcon text-center">*</span></label>
						  <input type="text" 
              style="height: 50px; color:blue; font-style: bold; font-size: 28px;" 
              class="form-control  text-center" id="rec_time" name="payrolltime" value="0"  readonly >
						</div>
 

            <div class="form-group col-md-3"  style="margin-left: 50px;">
							<label for="purchaseDetailsVendorName">Spell<span class="requiredIcon text-center">*</span></label>
							<select id="doffmodexpshiftName" style="height: 50px; color:blue; font-style: bold; font-size: 28px;"
              name="doffmodexpshiftName" class="form-control chosenSelect  text-center">
        

              echo "<option value='A1' > A1</option>";
              echo "<option value='B1' " > B1</option>";
              echo "<option value='A2' > A2</option>";
              echo "<option value='B2' > B2</option>";
              echo "<option value='C' > C</option>";
       

             
							</select>
						  </div>
              <?php
                  $company_id = $this->session->userdata('company_id');
                //  echo $company_id;
              ?>
 
            <input type="hidden" class="input" value="<?php echo $company_id; ?>" id="companyId" />
              <input type="hidden" class="input" id="fetchtnetwt" />
              <input type="hidden" class="input" id="record_id" />
              
					  </div>
			
      
      

        <div class="row">
          <div class="col-md-1">
          
            <div class="form-group ">
                    <label >Frame No </label>
                    <input type="text" name="q" id="frameNo" value="" 
                    style="height: 100px; color:blue; font-style: bold; font-size: 58px; "
                    class="form-control text-center readonly">
                    
            </div>
          </div>

          <div class="col-lg-2">
            <div class="form-group ">
                    <label >Trolly No </label>
                    <input type="text" name="trollyNo" id="trollyNo" value="" 
                    style="height: 100px; color:blue; font-style: bold; font-size: 58px;"
                    class="form-control text-center ">
            </div>
          </div> 
          <div class="col-lg-1">
          <div class="form-group ">
                    <label >Doff No </label>
                    <input type="text" name="framename" id="doffNo" value="" 
                    style="height: 100px; color:blue; font-style: bold; font-size: 58px; disabled:disabled" "
                    class="form-control text-center readonly">
            </div>
          </div>
          <div class="col-lg-2">
          <div class="form-group ">
                    <label >Gross Weight </label>
                    <input type="text" name="dofmodgrosswt" id="dofmodgrossWt" value="" 
                    style="height: 100px; color:blue; font-style: bold; font-size: 58px;"
                    class="form-control text-center ">
            </div>
          </div>
          <div class="col-lg-2">
          <div class="form-group ">
                    <label >Tare Weight </label>
                    <input type="text" name="framename" id="dofmodtareWt" value="" 
                    style="height: 100px; color:blue; font-style: bold; font-size: 58px;"
                    class="form-control text-center  readonly ">
            </div>
          </div>
          <div class="col-lg-2">
          <div class="form-group ">
                    <label >Net Weight </label>
                    <input type="text" name="framename" id="dofmodnetWt" value="" 
                    style="height: 100px; color:blue; font-style: bold; font-size: 58px; maxlength: 2;"
                    class="form-control text-center  readonly">
            </div>
          </div>
<!--
          <div class="col-lg-2">
          <div class="form-group ">
                    <label >Total Net Weight </label>
                    <input type="text" name="framename" id="dofmodtnetWt" value="" 
                    style="height: 100px; color:blue; font-style: bold; font-size: 58px;"
                    class="form-control text-center  readonly">
                  
            </div>
          </div>
  -->


        </div> 
         
            

            <div class="card-footer"></div>
                <div class="row">
<!--
            <button name="submit" id="savebtn" type="submit" class="form-control btn btn-primary">Save</button>
-->            
            <div class="form-group col-md-2" style="margin-left: 20px;">
			  <label for="purchaseDetailsPurchaseDate">Update<span class="text-center"></span></label>
              <button name="submit" id="dofmodupdatebtn" style="height: 50px;" type="submit" class="form-control btn btn-primary">Update</button>
            </div>
            <div class="form-group col-md-2" style="margin-left: 20px;">
			  <label for="purchaseDetailsPurchaseDate">Delete<span class="text-center"></span></label>
              <button name="submit"  id="dofmoddelbtn" style="height: 50px;" type="submit" class="form-control btn btn-primary">Delete</button>
            </div>
                
            <div class="form-group col-md-2" style="margin-left: 20px;">
			  <label for="purchaseDetailsPurchaseDate">Export Doff Data<span class="text-center"></span></label>
              <button name="submit" id="exportdbfdata" style="height: 50px;" type="submit" class="form-control btn btn-primary">Export</button>
            </div>

          </div>

    
            </form>
       
            <h1>Record List</h1>
    <table id="dofmodexprecordTable">
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

$("#dofmoddelbtn").hide();

$("#doffmodexpdate").datepicker({ 
  dateFormat: 'dd-mm-yy',
					todayHighlight:'TRUE',
					autoclose: true,
                });
                $("#payrollenddate").datepicker({ 
                  dateFormat: 'dd-mm-yy',
					todayHighlight:'TRUE',
					autoclose: true,
                });

                $('#doffmodexpdate').datepicker('setDate', 'today');

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
           $('#frameNo').on('input', function() {
          var frameNo =  $('#frameNo').val();
          var payrollstartdate= $('#payrollstartdate').val();
          var shiftName= $('#shiftName').val();
          var companyId=$('#companyId').val();
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
                    var mcno=(response.mcno);
                    var ln=mcno.length;
                    $("#savebtn").attr('disabled',false);
                    
                    $('#frameNo').css({'border-color': 'green','background-color': 'white'
                    });
                    if (ln==0)  {
                      $('#frameNo').css({'border-color': 'red','background-color': 'yellow'
                    });
                    $("#savebtn").attr('disabled',true);


                    }
                } else {
                    $('#trollyNo').val('0');
                }
            }
        });
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
                $('#dofmodtareWt').val(response.trollyWt);
                $tw=$('#dofmodtareWt').val();
                $('#dofmodtareWt').css({'border-color': 'green','background-color': 'white'
                });
                $('#dofmodtrollyNo').css({'border-color': 'green','background-color': 'white'
                });
                 
                if ($tw==0) {
                       $('#dofmodtareWt').css({'border-color': 'red','background-color': 'yellow'
                    });
                    $('#dofmodtrollyNo').css({'border-color': 'red','background-color': 'yellow'
                    });
                    
                  }
                }
                });
    });


    $('#dofmodgrossWt').on('input', function() {
          var grossWt =  $('#dofmodgrossWt').val();
          var grossWt=parseFloat(grossWt);
          var tareWt= $('#dofmodtareWt').val();
          var tareWt=parseFloat(tareWt);
          var fetchtnetwt= $('#fetchtnetwt').val();
          var fetchtnetwt=parseFloat(fetchtnetwt);
          var tnetWt= $('#dofmodtnetWt').val();
          var tnetWt=parseFloat(tnetWt);
          var companyId=$('#companyId').val();
          netwt=(grossWt-tareWt).toFixed(2);
          var netwt=parseFloat(netwt);
          
 //         alert(grossWt);
 //         alert(tareWt);
  //        alert(netwt);
          tnetWt=(fetchtnetwt+netwt).toFixed(2);
          if (netwt >0 ) { 
     //       alert(netwt);
             $('#dofmodnetWt').val(netwt);
             $('#dofmodtnetWt').val(tnetWt);
             $("#dofmodupdatebtn").attr('disabled',false);
                     $('#dofmodnetWt').css({'border-color': 'green','background-color': 'white'
                     });
          }  else {
           // netwt=0;
       //    alert(netwt);
             $('#dofmodnetWt').val(netwt);
             $('#dofmodtnetWt').val(tnetWt);
             $('#dofmodnetWt').css({'border-color': 'red','background-color': 'yellow'
                    });
                    $("#dofmodupdatebtn").attr('disabled',true);

          } 

      
      });


      $('#doffNo').prop('disabled', true);
      $('#dofmodnetWt').prop('disabled', true);
      $('#dofmodtnetWt').prop('disabled', true);
      $('#dofmodtareWt').prop('disabled', true);
      
 
        });

//start save
        $("#dofmodupdatebtn").click(function(event){
          event.preventDefault(); 
          var frameNo =  $('#frameNo').val();
          var doffmodexpdate= $('#doffmodexpdate').val();
          var trollyNo= $('#trollyNo').val();
          var tareWt= $('#dofmodtareWt').val();
          var grossWt= $('#dofmodgrossWt').val();
          var netWt= $('#dofmodnetWt').val();
          var companyId=$('#companyId').val();
          var record_id=$('#record_id').val();
 
          $.ajax({
            url: "<?php echo base_url('admin/Doffdata/dofmodupdate_data'); ?>",
            type: "POST",
            data: {frameNo: frameNo,doffmodexpdate: doffmodexpdate,companyId: companyId,
           trollyNo: trollyNo,tareWt: tareWt,grossWt: grossWt,netWt: netWt,record_id: record_id
            },
            dataType: "json",
            success: function(response) {
              var savedata=(response.savedata);
                $('#tnetWt').val('');
                $('#netWt').val('');
                $('#dofmodframeNo').val('');
                $('#trollyNo').val('');
                $('#doffNo').val('');
                $('#tareWt').val('');
                $('#grossWt').val('');
                $('#record_id').val('');
                

                if (response.success) {
                    alert('Record Updated Successfully');
                    refreshDataTable();
                  }
            }
        });

      });
 
  function commonDeleteFunction() {
  var frameNo = $('#frameNo').val();
  var doffmodexpdate = $('#doffmodexpdate').val();
  var trollyNo = $('#trollyNo').val();
  var tareWt = $('#dofmodtareWt').val();
  var grossWt = $('#dofmodgrossWt').val();
  var netWt = $('#dofmodnetWt').val();
  var companyId = $('#companyId').val();
  var record_id = $('#record_id').val();

  $.ajax({
    url: "<?php echo base_url('admin/Doffdata/dofmoddel_data'); ?>",
    type: "POST",
    data: {
      frameNo: frameNo,
      doffmodexpdate: doffmodexpdate,
      companyId: companyId,
      trollyNo: trollyNo,
      tareWt: tareWt,
      grossWt: grossWt,
      netWt: netWt,
      record_id: record_id
    },
    dataType: "json",
    success: function(response) {
      var savedata = (response.savedata);
      $('#tnetWt').val('');
      $('#netWt').val('');
      $('#dofmodframeNo').val('');
      $('#trollyNo').val('');
      $('#doffNo').val('');
      $('#tareWt').val('');
      $('#grossWt').val('');
      $('#record_id').val('');

      if (response.success) {
        alert('Record Deleted Successfully');
        refreshDataTable();
      }
    }
  });
}

$("#dofmoddelbtn").click(function(event) {
  event.preventDefault();
  commonDeleteFunction();
});

$(document).keydown(function(e) {
  // Check if "Delete" key (Del) is pressed
  if (e.key === "Delete" || e.key === "Del") {
    alert('Del key pressed');
    commonDeleteFunction();
  }
});


      initDataTable();
      function initDataTable() {
            table = $('#dofmodexprecordTable').DataTable({
          
                ajax: {
                    url: '<?php echo base_url('admin/Doffdata/doffmodexpget_records'); ?>',
                    type: 'POST',
                    data: function(d) {
                        d.date = $('#doffmodexpdate').val();
                        d.shift = $('#doffmodexpshiftName').val();
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
                $('#dofmodexprecordTable td.column-align-center').css('text-align', 'center');
                $('#dofmodexprecordTable td.column-align-right').css('text-align', 'right');
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
            table = $('#dofmodexprecordTable').DataTable({
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


        $('#dofmodexprecordTable tbody').on('click', 'tr', function() {
                var rowData = table.row(this).data();
                $('#record_id').val(rowData[0]);
                $('#frameNo').val(rowData[3]);
                $('#trollyNo').val(rowData[4]);
                $('#dofmodgrossWt').val(rowData[5]);                
                $('#dofmodtareWt').val(rowData[6]);
                $('#dofmodnetWt').val(rowData[7]);
                $('#dofmodtnetWt').val(rowData[8]);
            });
        
            $('#dofmodexprecordTable tbody').on('click', 'tr', function() {
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                } else {
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                }
            });
/*
    var table = $('#dofmodexprecordTable').DataTable();
    var selectedRowIndex = -1; // Variable to keep track of the selected row index

    // Event listener for F2 key press
    $(document).on('keydown', function(e) {
        if (e.which === 113) { // 113 is the key code for F2
            var rowCount = table.rows().count();

            if (rowCount > 0) {
                // Increment the selected row index (cycling back to the first row if necessary)
                selectedRowIndex = (selectedRowIndex + 1) % rowCount;
                // Deselect all rows
                table.rows().nodes().to$().removeClass('selected');

// Select the currently selected row
table.rows(selectedRowIndex).nodes().to$().addClass('selected');

// Get the data of the selected row
var selectedRowData = table.row(selectedRowIndex).data();
$('#frameNo').val('');
 
                // Update your form fields here based on selectedRowData
                $('#record_id').val(selectedRowData[0]);
                $('#frameNo').val(selectedRowData[3]);
                $('#trollyNo').val(selectedRowData[4]);
                $('#dofmodgrossWt').val(selectedRowData[5]);                
                $('#dofmodtareWt').val(selectedRowData[6]);
                $('#dofmodnetWt').val(selectedRowData[7]);
                $('#dofmodtnetWt').val(selectedRowData[8]);
            }
        }
    });
 
 */




            $('#doffmodexpdate, #doffmodexpshiftName').on('change', function() {
               $('#tnetWt').val('');
                $('#dofmodnetWt').val('');
                $('#frameNo').val('');
                $('#trollyNo').val('');
                $('#doffNo').val('');
                $('#dofmodtareWt').val('');
                $('#dofmodgrossWt').val('');

                refreshDataTable();
            });

//end save
//$('#dofmodexprecordTable').DataTable();

$("#exportdbfdata").click(function(event){
  event.preventDefault(); 
	alert ("aaaa");
	var opt=3;
            var payrollstartdate= $('#doffmodexpdate').val();
            var companyId=$('#companyId').val();
      
            var url = '<?php echo site_url("admin/doffdata/exportdbfdata"); ?>' +
                      '?payrollstartdate=' + payrollstartdate +
                      '&companyId=' + companyId 
                      ;
                      alert(url);
			//$(location).attr('href',url);
			window.open( url, '_blank');
			
			
return false;
});


$("#exportothdata").click(function(event){
  event.preventDefault(); 
	alert ("aaaa");
	var opt=3;
            var payrollstartdate= $('#doffmodexpdate').val();
            var companyId=$('#companyId').val();
      
            var url = '<?php echo site_url("admin/doffdata/exportothdata"); ?>' +
                      '?payrollstartdate=' + payrollstartdate +
                      '&companyId=' + companyId 
                      ;
                      alert(url);
			//$(location).attr('href',url);
			window.open( url, '_blank');
			
			
return false;
});





</script>



</body>
</html>
