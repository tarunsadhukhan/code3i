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
          <h3 class="m-1 text-dark text-center" style="background-color: #1589FF;">PF ESI Data</h3>

          </div><!-- /.col -->
          <div class="col-sm-2">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url().'admin/home'; ?>">Home</a></li>
              <li class="breadcrumb-item"><a href="<?php echo base_url().'admin/doffdata'; ?>">PF ESI Data</a></li>
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
      <form name="categoryForm" id="categoryForm" method="post" 
            action=""  

      <div class="form-row">

						<div class="form-group col-md-3">
						  <label for="purchaseDetailsPurchaseDate">Pay Period From<span class="text-center">*</span></label>
						  <input type="text" style="height: 50px; color:blue; font-style: bold; font-size: 28px;"
               class="form-control datepicker text-center" id="payrollstartdate" 
              name="payrollstartdate"   readonly >
						</div>
            <?php
                                $company_id = $this->session->userdata('company_id');
                            ?>
                    <input type="hidden" class="form-control" value="<?php echo $company_id; ?>" id="companyId" name="companyId" />
                     
              <input type="hidden" class="input" id="fetchtnetwt" />
        
			<div class="form-group col-md-3">
						  <label for="purchaseDetailsPurchaseDate">Pay Period End<span class="text-center">*</span></label>
						  <input type="text" style="height: 50px; color:blue; font-style: bold; font-size: 28px;"
               class="form-control datepicker text-center" id="payrollenddate" 
              name="payrollenddate"   readonly >
						</div>
  

            <div class="form-group col-md-3"  style="margin-left: 50px;">
							<label for="purchaseDetailsVendorName">PayScheme<span class="requiredIcon text-center">*</span></label>
							<select id="payScheme" style="height: 50px; color:blue; font-style: bold; font-size: 18px;"
              name="payScheme" class="form-control chosenSelect  text-left">
             
              <?php foreach ($payschemes as $payscheme): ?>
                        <option value="<?php echo $payscheme->ID; ?>"><?php echo $payscheme->NAME; ?></option>

              <?php
                endforeach; ?>
			</select>
		  </div>

          <div class="form-group col-md-1" style="margin-left: 20px;">
						  <label for="purchaseDetailsPurchaseDate">Export Data<span class="text-center"></span></label>
              <button name="submit" id="savebtnt" style="height: 50px;" type="submit" class="form-control btn btn-primary">Export To Csv</button>
<!--
              <button class="form-control btn btn-primary"  style="margin-right:40px" id="exportCsvBtn">
        <i class="fa fa-file-excel-o"></i> Export to CSV
      </button>
              -->   


          <!--
    <a  class="form-control btn btn-primary" style="margin-right:40px" href="<?php echo site_url(); ?>admin/reports/pfesidata/exportToCsv"><i class="fa fa-file-excel-o"></i> Export to Excel</a>
            					<a class="pull-right btn btn-warning btn-large" style="margin-right:40px" href="<?php echo site_url(); ?>/employee/createexcel"><i class="fa fa-file-excel-o"></i> Export to Excel</a>

                <button name="submit" href="<?php echo site_url(); ?>/employee/createexcel"  id="exportbtn"  type="submit"  style="height: 50px;" class="form-control btn btn-primary">Export</button>
              -->
              </div>
  
              <div class="form-group col-md-1" style="margin-left: 20px;">
						  <label for="purchaseDetailsPurchaseDate">Export Data<span class="text-center"></span></label>
              <button name="submit" id="excelbt" style="height: 50px;" type="submit" class="form-control btn btn-primary">Export to Xl</button>
            
            </div>

          
 

              
					  </div>
	

            </form>
       
            <h1>Record List</h1>
    <table id="recordTable">
        <thead>
            <tr>
                <th>Pay Period ID</th>
                <th>EB NO</th>
                <th>NAME</th>
                <th>PF No</th>
                <th>UAN No</th>
                <th>ESI No</th>
                <th>Days</th>
                <th>PF Gross</th>
                <th>PF Amount</th>
                <th>ESI Gross</th>
                <th>ESI Amount</th>
                
                
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
                });
                $("#payrollenddate").datepicker({ 
                  dateFormat: 'dd-mm-yy',
					todayHighlight:'TRUE',
					autoclose: true,
                });

                $('#payrollstartdate').datepicker('setDate', 'today');
                $('#payrollenddate').datepicker('setDate', 'today');

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
$("#savebtnt").click(function(event){
  event.preventDefault(); 
  event.preventDefault();
  

  var payrollstartdate = $('#payrollstartdate').val();
    var payrollenddate = $('#payrollenddate').val();
    var companyId = $('#companyId').val();
    var payScheme = $('#payScheme').val();
    var data = {
        payrollstartdate: payrollstartdate,
        payrollenddate: payrollenddate,
        companyId: companyId,
        payScheme: payScheme
    };
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '<?php echo site_url("admin/reports/pfesidata/exportToCsv"); ?>', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.responseType = 'blob';
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // Create a temporary anchor element to trigger the download
                var a = document.createElement('a');
                a.href = window.URL.createObjectURL(xhr.response);
                //a.download = 'data_export_' + new Date().toISOString() + '.csv';
               a.download = 'pf_esidata_export' + '.csv';

                a.style.display = 'none';
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(a.href);
                document.body.removeChild(a);
            } else {
                // Handle error response
                console.error('Failed to export data to CSV');
            }
        }
    };

    xhr.send(JSON.stringify(data));
  //alert('check');
});


$("#excelbtnt1").click(function(event){
  event.preventDefault(); 
  event.preventDefault();
    var payrollstartdate = $('#payrollstartdate').val();
    var payrollenddate = $('#payrollenddate').val();
    var companyId = $('#companyId').val();
    var payScheme = $('#payScheme').val();
    var data = {
        payrollstartdate: payrollstartdate,
        payrollenddate: payrollenddate,
        companyId: companyId,
        payScheme: payScheme
    };
 
    
  alert(payrollstartdate);

  $.ajax({
            type: "POST",
            url: "<?php echo site_url('admin/reports/pfesidata/exportToExcel'); ?>",
            data: data,
            success: function(response) {
                // The response will be the Excel file
                // Trigger a download by creating a temporary link
                var blob = new Blob([response], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = 'your_excel_file.xlsx';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            },
            error: function(xhr, status, error) {
                // Handle error
                console.log("Error: " + error);
            }
        });
});  

$("#excelbtnt").click(function(event) {
        event.preventDefault();
        // Get the values from the input fields and select element
    var payrollstartdate = $('#payrollstartdate').val();
    var payrollenddate = $('#payrollenddate').val();
    var companyId = $('#companyId').val();
    var payScheme = $('#payScheme').val();

    var data = {
        payrollstartdate: payrollstartdate,
        payrollenddate: payrollenddate,
        companyId: companyId,
        payScheme: payScheme
    };
  
  
    alert(payrollstartdate);
 
        // AJAX POST request to the server
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('admin/reports/pfesidata/exportToExcel'); ?>",
            data: data,
            success: function(response) {

              var blob = new Blob([response], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = 'your_excel_file.xlsx';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
 
              },
            error: function(xhr, status, error) {
                // Handle error
                console.log("Error: " + error);
            }
        });
    });




$("#savebtn").click(function(event){
          event.preventDefault(); 
          var payrollstartdate= $('#payrollstartdate').val();
          var payrollenddate= $('#payrollenddate').val();
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

  

        $("#exportCsvBtns").click(function(event){
          event.preventDefault(); 
          var payrollstartdate = document.getElementById('payrollstartdate').value;
            var payrollenddate = document.getElementById('payrollenddate').value;
            var payscheme = document.getElementById('payScheme').value;
            var payrollstartdate= $('#payrollstartdate').val();
            var payrollenddate= $('#payrollenddate').val();
            var companyId=$('#companyId').val();
            var payScheme= $('#payScheme').val();
 
            // Create the URL with the form input values as parameters
            var url = '<?php echo site_url("admin/reports/pfesidata/exportToCsv"); ?>' +
                      '?payrollstartdate=' + payrollstartdate +
                      '&payrollenddate=' + payrollenddate +
                      '&payscheme=' + payscheme +
                      '&companyId=' + companyId 
                      ;

            // Redirect to the URL for exporting data to Excel
           window.location.href = url;
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
    url: '<?php echo base_url('admin/reports/pfesidata/get_records'); ?>',
    type: 'POST',
    data: function(d) {
      d.sdate = $('#payrollstartdate').val();
      d.edate = $('#payrollenddate').val();
      d.payscheme = $('#payScheme').val();
      d.companyId = $('#companyId').val();
    }
  },
  columnDefs: [
    { targets: [0], visible: true }, // Hide the first column (auto_id)
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
  order: [[1, 'asc']], // Sort by the first column (auto_id) in descending order
  pageLength: 5
//  , // Set the default number of rows per page to 5
//  scrollX: true, // Enable horizontal scrolling
//  columns: [
 //   { width: '150px' }, // Set the width of the first column (auto_id) to 10 pixels
 //   null, // Let DataTables handle the default width for the other columns
 //   { width: '800px' }, // Set the width of the first column (auto_id) to 10 pixels
  //  null,
   // null,
   // null,
   // { width: '500px' }, // Set the width of the sixth column (name) to 50 pixels
   // { width: '50px' }  // Set the width of the seventh column (id) to 50 pixels
 // ]
});

      }      
      
      
      
      function initDataTablex() {

            table = $('#recordTable').DataTable({
                ajax: {
                    url: '<?php echo base_url('admin/reports/pfesidata/get_records'); ?>',
                    type: 'POST',
                    data: function(d) {
                        d.date = $('#payrollstartdate').val();
                        d.date = $('#payrollenddate').val();
                        d.shift = $('#payScheme').val();
                        d.companyId=$('#companyId').val();
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


            $('#payrollstartdate, #payrollenddate,#payScheme').on('change', function() {

 
                refreshDataTable();
            });

//end save
//$('#recordTable').DataTable();
$("#excelbt").click(function(event){
  event.preventDefault(); 

	alert ("aaaa");
	var opt=3;
  var payrollstartdate= $('#payrollstartdate').val();
            var payrollenddate= $('#payrollenddate').val();
            var companyId=$('#companyId').val();
            var payScheme= $('#payScheme').val();	//alert (spltb);
	 
            var url = '<?php echo site_url("admin/reports/pfesidata/exportToExcel"); ?>' +
                      '?payrollstartdate=' + payrollstartdate +
                      '&payrollenddate=' + payrollenddate +
                      '&payScheme=' + payScheme +
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
