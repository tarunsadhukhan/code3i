   <!-- /.navbar -->

   <?php



use PHPUnit\TextUI\XmlConfiguration\CodeCoverage\Report\Php;

 $this->load->view('admin/header'); ?>

 
<style>
        /* Apply center alignment to the merged cell */
        th.center-align {
            text-align: center;
        }

        th.center-align, td.center-align {
            text-align: center;
        }
        
        /* Add border to the table */
        table {
            border-collapse: collapse;
            width: 100%;
        }

        /* Add borders to table cells */
        th, td {
            border: 1px solid black;
            padding: 8px;
        }

        /* Style the header row (optional) */
        th {
            background-color: #f2f2f2;
        }

        #doff10repcrecordTable {
        border-collapse: collapse;
        width: 100%;
    }

    #doff10repcrecordTable th,
    #doff10repcrecordTable td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #doff10repcrecordTable th {
        background-color: #EBF5FB;
    }

    #doff10repcrecordTable tr:nth-child(even) {
        background-color: #FFEBCD;
    }

    #doff10repcrecordTable tr:hover {
        background-color: #2E86C1;
    }

    .selected {
        background-color: yellow;
    }
    #doff10repcrecordTable td.column-align-center {
        text-align: center;
    }

    #doff10repcrecordTable td.column-align-right {
        text-align: right;
    }
   
     #doff10repcrecordTable th,
    #doff10repcrecordTable td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #doff10repcrecordTable th {
        background-color: #EBF5FB;
    }

    #doff10repcrecordTable tr:nth-child(even) {
        background-color: #FFEBCD;
    }

    #doff10repcrecordTable tr:hover {
        background-color: #2E86C1;
    }

    .selected {
        background-color: yellow;
    }
    #doff10repcrecordTable td.column-align-center {
        text-align: center;
    }

    #doff10repcrecordTable td.column-align-right {
        text-align: right;
    }
   
        /* Style the header row (optional) */
    
        #doffqualitysumTable {
        border-collapse: collapse;
        width: 100%;
    }

    #doffqualitysumTable th,
    #doffqualitysumTable td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #doffqualitysumTable th {
        background-color: #EBF5FB;
    }

    #doffqualitysumTable tr:nth-child(even) {
        background-color: #FFEBCD;
    }

    #doffqualitysumTable tr:hover {
        background-color: #2E86C1;
    }

    .selected {
        background-color: yellow;
    }
    #doffqualitysumTable td.column-align-center {
        text-align: center;
    }

    #doffqualitysumTable td.column-align-right {
        text-align: right;
    }
   
     #doffqualitysumTable th,
    #doffqualitysumTable td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #doffqualitysumTable th {
        background-color: #EBF5FB;
    }

    #doffqualitysumTable tr:nth-child(even) {
        background-color: #FFEBCD;
    }

    #doffqualitysumTable tr:hover {
        background-color: #2E86C1;
    }

    .selected {
        background-color: yellow;
    }
    #doffqualitysumTable td.column-align-center {
        text-align: center;
    }

    #doffqualitysumTable td.column-align-right {
        text-align: right;
    }
   
    

    </style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-10">
          <h3 class="m-1 text-dark text-center" style="background-color: #1589FF;">Doff 10 Report</h3>
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
    <input type="hidden" class="input" value="" id="doffrepframeNo" />
    <input type="hidden" class="input" value="" id="doff10type" />

              <input type="hidden" class="input" id="record_id" />
						<div class="form-group col-md-3">
						  <label for="purchaseDetailsPurchaseDate">Doffing Date<span class="text-center">*</span></label>
						  <input type="text" style="height: 50px; color:blue; font-style: bold; font-size: 28px;"
               class="form-control datepicker text-center" id="doff10repdate" 
              name="doff10repdate"   readonly >
			</div>
<!--
            <div class="form-group col-md-2" style="margin-left: 20px;">
			  <label for="purchaseDetailsPurchaseDate">Details Report<span class="text-center"></span></label>
              <button name="submit" id="dof10detbtn" style="height: 50px;" type="submit" class="form-control btn btn-primary">Details Report</button>
            </div>
-->
           <div class="form-group col-md-2" style="margin-left: 20px;">
			  <label for="purchaseDetailsPurchaseDate">Export to Xl(Summary)<span class="text-center"></span></label>
              <button name="submit" id="dof10excelbtn" style="height: 50px;" type="submit" class="form-control btn btn-primary">Export</button>
            </div>
            <div class="form-group col-md-2" style="margin-left: 20px;">
			  <label for="purchaseDetailsPurchaseDate">Analysis<span class="text-center"></span></label>
              <button name="submit" id="dof10analysis" style="height: 50px;" type="submit" class="form-control btn btn-primary">Analysis</button>
            </div>
<!--
            <div class="form-group col-md-2" style="margin-left: 20px;">
			  <label for="purchaseDetailsPurchaseDate">Export to Xl(Details)<span class="text-center"></span></label>
              <button name="submit" id="dof10detexcelbtn" style="height: 50px;" type="submit" class="form-control btn btn-primary">Export</button>
            </div>
-->
             
            </div>


					  </div>
			
            <hr style="height:4px; background-color: brown;"></hr>
    
 
            </form>
       
            <h1>Doff 10 Report</h1>

      <div id="doff10sum">
           <table id="doff10repcrecordTable">
    <thead>
        <tr>
          <th colspan="3" class="center-align">Frame Details</th> 
          <th colspan="6" class="center-align">Shift A1</th>
            <th colspan="6" class="center-align">Shift A2</th>
            <th colspan="4" class="center-align">Shift A</th>
            <th colspan="6" class="center-align">Shift B1</th>
            <th colspan="6" class="center-align">Shift B2</th>
            <th colspan="4" class="center-align">Shift B</th>
            <th colspan="7" class="center-align">Shift C</th>
            <th colspan="4" class="center-align">Overall</th>
        </tr>
        <tr>
            <td font color='#FFFF00'>Frame No</td>
            <td font color='#FFFF00'>No of Spindle</td>
            <td font color='#FFFF00'>Std Avg Wt/doff</td>

            <td colspan="1">Quality</td>
            <td colspan="1" width="100px">Employee</td>
            <td colspan="1">Std Doff</td>
            <td colspan="1">No of Doff</td>
            <td colspan="1">Prod</td>
            <td colspan="1">Avg Doff Wt</td>

            <td colspan="1">Quality</td>
            <td colspan="1">Employee</td>
            <td colspan="1">Std Doff</td>
            <td colspan="1">No of Doff</td>
            <td colspan="1">Prod</td>
            <td colspan="1">Avg Doff Wt</td>

            <td colspan="1">No of Doff</td>
            <td colspan="1">Prod</td>
            <td colspan="1">Avg Doff Wt</td>
            <td colspan="1">Eff(%)</td>
            <!-- Here, we use colspan="4" to merge the next four cells under "Shift A1" -->
 
            <td colspan="1">Quality</td>
            <td colspan="1">Employee</td>
            <td colspan="1">Std Doff</td>
            <td colspan="1">No of Doff</td>
            <td colspan="1">Prod</td>
            <td colspan="1">Avg Doff Wt</td>

            <td colspan="1">Quality</td>
            <td colspan="1">Employee</td>
            <td colspan="1">Std Doff</td>
            <td colspan="1">No of Doff</td>
            <td colspan="1">Prod</td>
            <td colspan="1">Avg Doff Wt</td>

            <td colspan="1">No of Doff</td>
            <td colspan="1">Prod</td>
            <td colspan="1">Avg Doff Wt</td>
            <td colspan="1">Eff(%)</td>
            <!-- Here, we use colspan="4" to merge the next four cells under "Shift b1" -->
 
            <td colspan="1">Quality</td>
            <td colspan="1">Employee</td>
            <td colspan="1">Std Doff</td>
            <td colspan="1">No of Doff</td>
            <td colspan="1">Prod</td>
            <td colspan="1">Avg Doff Wt</td>
            <td colspan="1">Eff(%)</td>
        
            <td colspan="1">No of Doff</td>
            <td colspan="1">Prod</td>
            <td colspan="1">Avg Doff Wt</td>
            <td colspan="1">Eff(%)</td>
 
          </tr>
    </thead>
    <tbody>
        <!-- Table body content goes here -->
    </tbody>
</table>

</thead>
        <tbody>
        </tbody>
    </table>
           
      </div>       

 
      <h1>Quality Wise Summry Report</h1>
    <table id="doffqualitysumTable">
        <thead>
        <tr>
          <th colspan="2" class="center-align">Quality Details</th> 
          <th colspan="4" class="center-align">Frames Run</th>
          <th colspan="4" class="center-align">Production</th>
        </tr>
            <tr>
            <td font color='#FFFF00'>Q Code</td>
            <td font color='#FFFF00'>Quality</td>

            <td colspan="1">Shift A</td>
            <td colspan="1">Shift B</td>
            <td colspan="1">Shift C</td>
            <td colspan="1">Total</td>
 
            <td colspan="1">Shift A</td>
            <td colspan="1">Shift B</td>
            <td colspan="1">Shift C</td>
            <td colspan="1">Total</td>
 
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
<!--
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
-->
<!--
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
-->
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
 

<script>
$(function () {
  
  $( ".selector" ).datepicker( "setDate", new Date());

  
 
})

$("#doff10repdate").datepicker({ 
  dateFormat: 'dd-mm-yy',
					todayHighlight:'TRUE',
					autoclose: true,
                });
                $("#payrollenddate").datepicker({ 
                  dateFormat: 'dd-mm-yy',
					todayHighlight:'TRUE',
					autoclose: true,
                });

                $('#doff10repdate').datepicker('setDate', 'today');

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
var ss=1;
$('#doff10type').val(ss);
                

</script>

<script>
        $(document).ready(function() {
 /*
    $('#doff10repcrecordTable').DataTable({
        scrollY: 300,
        scrollX: true,
        scroller: true
    });
*/


    $('#doffrepframeNo').on('input', function() {
 
        refreshDataTable();
        var trollyNo =  $('#trollyNo').val();
          var frameNo =  $('#frameNo').val();
          var companyId=$('#companyId').val();
        
     });


 

       
 
        });

//start save
       initDataTable();
       initsummDataTable(); 
       function initDataTable() {
          var compid=$('#companyId').val();
          $('#doff10repcrecordTable').DataTable().destroy();
          table = $('#doff10repcrecordTable').DataTable({
                ajax: {
                    url: '<?php echo base_url('admin/Doffdata/get_doff10_records'); ?>',
                    type: 'POST',
                    data: function(d) {
                        d.date = $('#doff10repdate').val();
                        d.compId=$('#companyId').val();
                        d.doffrepframeNo=$('#doffrepframeNo').val();
                    }
                  },columnDefs: [
                 { data: 'mech_code', width: '100px' }, // Specify fixed width for each column
                 { data: 'bobbin_count', width: '80px' },
                 { data: 'stdwtddoff', width: '80px' },
                 { data: 'Quality', width: '180px' },
                 { data: 'a1empname', width: '80px' },
                 { data: 'a1stddoff', width: '180px' },
                 { data: 'a1doff', width: '80px' },
                 { data: 'a1netwt', width: '80px' },
                 { data: 'a1avgwtdoff', width: '80px' },
                   
                    { targets: [0], visible: true }, // Hide the first column (auto_id)
                ],
                drawCallback: function() {
            },
                 order: [[0, 'asc']],  
                scrollX: true,
                scroller: true,  
                 pageLength: 10 // Set the default number of rows per page to 25
              });
  

            }

 
         function initsummDataTable() {
          var compid=$('#companyId').val();
//       alert('mm');
       $('#doffqualitysumTable').DataTable().destroy();
          table = $('#doffqualitysumTable').DataTable({
                ajax: {
                    url: '<?php echo base_url('admin/Doffdata/get_doffqcsum_records'); ?>',
                    type: 'POST',
                    data: function(d) {
                        d.date = $('#doff10repdate').val();
                        d.compId=$('#companyId').val();
                        d.doffrepframeNo=$('#doffrepframeNo').val();
                    }
                  },columnDefs: [
                
                   
                    { targets: [0], visible: true }, // Hide the first column (auto_id)
                ],
                drawCallback: function() {
            },
                 order: [[0, 'asc']],  
       //         scrollX: true,
        //        scroller: true,  
                 pageLength: 50 // Set the default number of rows per page to 25
              });
  

            }

 
 
        
        function refreshDataTable() {
//          $("#doff10repcrecordTable").DataTable().columns.adjust();   
initDataTable();
       initsummDataTable(); 
     
        table.ajax.reload(null, false); // Reload the data without resetting the current page
        }
        
 
        var table = $('#doff10repcrecordTable').DataTable();
    var clickedColIndex = null; // To store the index of the clicked column header

    // Add a click event listener to table header cells
    $('#doff10repcrecordTable  tbody').on( 'click', 'td', function () {
    //    alert('Data:'+$(this).html().trim());
    //    alert('Row:'+$(this).parent().find('td').html().trim());
    //    alert('Column:'+$('#doff10repcrecordTable thead tr th').eq($(this).index()).html().trim());
   //     var cl=$(this).html();
   //     var rw=$(this).parent().find('td').html();
   //     var clm=$('#doff10repcrecordTable thead tr th').eq($(this).index()).html();
    //    alert(clm);
    });
 

        $('#doff10repcrecordTable tbody').on('dblclick', 'tr', function() {
            var table = $('#doff10repcrecordTable').DataTable();

    var rowData = $('#doff10repcrecordTable').DataTable().row(this).data();
    var frm = rowData[0];
    var spfdt = $('#doff10repdate').val();
 
  
     // Construct the URL with query parameters
    var redirectUrl = "<?php echo base_url('admin/reports/onlinedoffreporta'); ?>";
    redirectUrl += "?frm=" + encodeURIComponent(frm) + "&spfdt=" + encodeURIComponent(spfdt);

    // Redirect to the new page with parameters
    window.location.href = redirectUrl;
});




            $('#doff10repcrecordTable tbody').on('click', 'tr', function() {
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                } else {
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                }
            });


            $('#doff10repdate, #doffrepshiftName,#doffrepframeNo' ).on('change', function() {
 
                refreshDataTable();
            });

            $("#dof10detbtn").click(function(event){
                  event.preventDefault();
                  var rtype=$('#doff10type').val();
//                alert('b');
                 // $("#doff10sum").hide(); 
                 //   $("#Div1, #Div2").toggle();
               //   $("#doff10det, #doff10sum").toggle();
               
               refreshDataTable();
                if (rtype=1) {
                    doff10repcrecordTable.column(3).visible(false);  
              //      doff10repcrecordTable.column(2).visible(false,false)  //  .column(2).visible(false, false); // Column index 2 is the department column
              //      doff10repcrecordTable.columns.adjust().draw(false); // Redraw 
                } else {
              //      doff10repcrecordTable.column(2).visible(true, false); // Column index 2 is the department column
              //      doff10repcrecordTable.columns.adjust().draw(false); // Redraw 
                } 
 
            });


            $("#dof10excelbtn").click(function(event){
                  event.preventDefault(); 
        	var opt=3;
            var doff10repdate= $('#doff10repdate').val();
            var companyId=$('#companyId').val();
            var url = '<?php echo site_url("admin/Doffdata/dof10exportToExcel"); ?>' +
                      '?doff10repdate=' + doff10repdate +
                      '&companyId=' + companyId 
                      ;
                      alert(url);
			//$(location).attr('href',url);
			window.open( url, '_blank');
			
			
return false;
});


$("#dof10analysis").click(function(event){
                  event.preventDefault(); 
        	var opt=3;
            var doff10repdate= $('#doff10repdate').val();
            var companyId=$('#companyId').val();
            var url = '<?php echo site_url("admin/Doffdata/dof10ana"); ?>' +
                      '?doff10repdate=' + doff10repdate +
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
