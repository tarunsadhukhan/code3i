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
          <h3 class="m-1 text-dark text-center" style="background-color: #1589FF;">Finishing Data Export</h3>

          </div><!-- /.col -->
          <div class="col-sm-2">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url().'admin/home'; ?>">Home</a></li>
              <li class="breadcrumb-item"><a href="<?php echo base_url().'admin/doffdata'; ?>">Doff Data</a></li>
              <li class="breadcrumb-item active">Weaving Data Export</li>
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
						  <label for="purchaseDetailsPurchaseDate">Export Date<span class="text-center">*</span></label>
						  <input type="text" style="height: 50px; color:blue; font-style: bold; font-size: 28px;"
               class="form-control datepicker text-center" id="doffmodexpdate" 
              name="doffmodexpdate"   readonly >
						</div>
			
                        <div class="form-group col-md-2" style="margin-left: 20px;">
			  <label for="purchaseDetailsPurchaseDate">Export Doff Data<span class="text-center"></span></label>
              <button name="submit" id="exportdbfdata" style="height: 50px;" type="submit" class="form-control btn btn-primary">Export</button>
            </div>
          
            <div class="form-group col-md-2" style="margin-left: 20px;">
			      <label for="purchaseDetailsPurchaseDate">Check List Attendance<span class="text-center"></span></label>
             <button name="submit" id="fngchckattbtn" style="height: 50px;" type="submit" class="form-control btn btn-primary">Check List Attendance</button>
            </div>

            <?php
                  $company_id = $this->session->userdata('company_id');
                //  echo $company_id;
              ?>
 
            <input type="hidden" class="input" value="<?php echo $company_id; ?>" id="companyId" />
              <input type="hidden" class="input" id="fetchtnetwt" />
              <input type="hidden" class="input" id="record_id" />
              
					  </div>
			
      
      

             

            <div class="card-footer"></div>
                <div class="row">
<!--
            <button name="submit" id="savebtn" type="submit" class="form-control btn btn-primary">Save</button>
-->            
          
                 
                </div>

    
            </form>
       
            <h1>Record List</h1>
    <table id="dofmodexprecordTable">
        <thead>
            <tr>
                <th>Work Type</th>
                <th>Date</th>
                <th>Spell</th>
                <th>EB No</th>
                <th>Name </th>
                <th>Mechine Name </th>
                <th>Quality</th>
                <th>PRoduction</th>
                <th>Working Hours</th>
                <th>Attendance Id</th>
                <th>No of Mcs</th>
                <th>Work Type</th>
                
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
/*
        var table = $('#dofmodexprecordTable').DataTable({
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
 
      $("#dofmoddelbtn").click(function(event){
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
            url: "<?php echo base_url('admin/Doffdata/dofmoddel_data'); ?>",
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
                    alert('Record Deleted Successfully');
                    refreshDataTable();
                  }
            }
        });
 
      });
 


      initDataTable();
      function initDataTable() {
        $('#dofmodexprecordTable').DataTable().destroy();
        table = $('#dofmodexprecordTable').DataTable({
            ajax: {
                url: '<?php echo base_url('admin/reports/finishing_data_export/finishalllist'); ?>',
                type: 'POST',
                data: function(d) {
                    d.date = $('#doffmodexpdate').val();
                    d.companyId = $('#companyId').val();
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
                {
                    targets: [0], // Change to the column index you want to check
                      }
            ],
            "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {

                if ( ((aData[0] == "6") || (aData[0] == "7")) && ((aData[8] == "0") || (aData[9] == "0")))    {
                   $('td', nRow).css('background-color', 'Red');
                } 
                if ( ((aData[0] == "25")) && ((aData[8] <= 0) ))    {
                   $('td', nRow).css('background-color', 'Red');
                }
             //   else if (aData[0] == "7") {
              //     $('td', nRow).css('background-color', 'Orange');
            //  }
            },
    createdRow: (row, data, dataIndex, cells) => {
        var col0=$(cells[0]); 
        var col4=$(cells[4]); 
        var col5=$(cells[5]); 
        var col8=$(cells[8]); 
        var col9=$(cells[9]); 
        var color1='#90EE90';
     //   $(cells[3]).css('background-color', color1)
    },
            drawCallback: function() {
                $('#dofmodexprecordTable td.column-align-center').css('text-align', 'center');
                $('#dofmodexprecordTable td.column-align-right').css('text-align', 'right');
            },
            order: [[0, 'desc']], // Sort by the first column (auto_id) in descending order
            pageLength: 25 // Set the default number of rows per page to 25
        });
    }

        /*
 createdCell: function(cell, cellData, rowData, rowIndex, colIndex) {
                // Customize cell color based on column and cell values
                if (colIndex = 0  && (parseInt(cellData) == 6) ) {
                    $(cell).addClass('red-cell');
                } else if (colIndex = 0  && (parseInt(cellData) == 7) ) {
                    $(cell).addClass('green-cell');
                }
            }
 */
            /*
            createdCell: function(cell, cellData, rowData, rowIndex, colIndex) {
                // Customize cell color based on column and cell values
                if (colIndex = 1 && colIndex <= 4 && parseInt(cellData) <= 5) {
                    $(cell).addClass('red-cell');
                } else if (colIndex >= 5 && colIndex <= 9 && parseInt(rowData[5]) > 20) {
                    $(cell).addClass('green-cell');
                }
            }
 */
   
        function refreshDataTable() {
          initDataTable();

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
      
            var url = '<?php echo site_url("admin/reports/finishing_data_export/exportdbfdata"); ?>' +
                      '?date=' + payrollstartdate +
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


$("#fngchckattbtn").click(function(event){
  event.preventDefault(); 
	//alert ("aaaa");
  chkDataTable();
return false;
});


function chkDataTable() {
  $('#dofmodexprecordTable').DataTable().destroy();
       alert('nn');
        table = $('#dofmodexprecordTable').DataTable({
            ajax: {
                url: '<?php echo base_url('admin/reports/finishing_data_export/finishchklist'); ?>',
                type: 'POST',
                data: function(d) {
                    d.date = $('#doffmodexpdate').val();
                    d.companyId = $('#companyId').val();
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
                {
                    targets: [0], // Change to the column index you want to check
                      }
            ],
            "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {

                if (( aData[7] == "0"))    {
                   $('td', nRow).css('background-color', 'Red');
                } 
              //   else if (aData[0] == "7") {
              //     $('td', nRow).css('background-color', 'Orange');
            //  }
            },
    createdRow: (row, data, dataIndex, cells) => {
        var col0=$(cells[0]); 
        var col4=$(cells[4]); 
        var col5=$(cells[5]); 
        var col8=$(cells[8]); 
        var col9=$(cells[9]); 
        var color1='#90EE90';
     //   $(cells[3]).css('background-color', color1)
    },
            drawCallback: function() {
                $('#dofmodexprecordTable td.column-align-center').css('text-align', 'center');
                $('#dofmodexprecordTable td.column-align-right').css('text-align', 'right');
            },
            order: [[0, 'desc']], // Sort by the first column (auto_id) in descending order
            pageLength: 25 // Set the default number of rows per page to 25
        });
    }






</script>



</body>
</html>
