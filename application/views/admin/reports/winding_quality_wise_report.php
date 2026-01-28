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




#wndqcwsieTable {
        border-collapse: collapse;
        width: 100%;
    }

    #wndqcwsieTable th,
    #wndqcwsieTable td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #wndqcwsieTable th {
        background-color: #f2f2f2;
    }

    #wndqcwsieTable tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    #wndqcwsieTable tr:hover {
        background-color: #ddd;
    }

    .selected {
        background-color: yellow;
    }
    #wndqcwsieTable td.column-align-center {
        text-align: center;
    }

    #wndqcwsieTable td.column-align-right {
        text-align: right;
    }
    
#wndqcwsieTable {
        border-collapse: collapse;
        width: 100%;
    }

    #wndqcwsieTable th,
    #wndqcwsieTable td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #wndqcwsieTable th {
        background-color: #f2f2f2;
    }

    #wndqcwsieTable tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    #wndqcwsieTable tr:hover {
        background-color: #ddd;
    }

    .selected {
        background-color: yellow;
    }
    #wndqcwsieTable td.column-align-center {
        text-align: center;
    }

    #wndqcwsieTable td.column-align-right {
        text-align: right;
    }
    

    #wndqcsummTable {
        border-collapse: collapse;
        width: 100%;
    }

    #wndqcsummTable th,
    #wndqcsummTable td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #wndqcsummTable th {
        background-color: #f2f2f2;
    }

    #wndqcsummTable tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    #wndqcsummTable tr:hover {
        background-color: #ddd;
    }

    .selected {
        background-color: yellow;
    }
    #wndqcsummTable td.column-align-center {
        text-align: center;
    }

    #wndqcsummTable td.column-align-right {
        text-align: right;
    }
    
#wndqcsummTable {
        border-collapse: collapse;
        width: 100%;
    }

    #wndqcsummTable th,
    #wndqcsummTable td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #wndqcsummTable th {
        background-color: #f2f2f2;
    }

    #wndqcsummTable tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    #wndqcsummTable tr:hover {
        background-color: #ddd;
    }

    .selected {
        background-color: yellow;
    }
    #wndqcsummTable td.column-align-center {
        text-align: center;
    }

    #wndqcsummTable td.column-align-right {
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
          <h3 class="m-1 text-dark text-center" style="background-color: #1589FF;"><strong>Winding Quality Wise Report</strong></h3>
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
                            class="form-control datepicker text-center" id="wndqcwiseDate" 
                            name="wndqcwiseDate"   readonly >
						</div>
                        <div id="loadingSpinner" style="display: none;">
                             <img src="ajax-loader.gif" alt="Loading..." /> Loading...
                         </div>

       
  
           <div class="form-group col-md-2" style="margin-left: 40px;">
						  <label for="purchaseDetailsPurchaseDate">Quality Wise Report<span class="text-center"></span></label>
              <button name="submit" id="wndqcwisereport" style="height: 50px;" type="submit" class="form-control btn btn-primary">Quality Wise Report</button>
            
            </div>
            <div class="form-group col-md-2" style="margin-left: 40px;">
						  <label for="purchaseDetailsPurchaseDate">Spinning Input<span class="text-center"></span></label>
              <button name="submit" id="wndspginput" style="height: 50px;" type="submit" class="form-control btn btn-primary">Spinning Input</button>
            
            </div>
 
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
       
            <h2>Winding Quality  List</h2>
    <table id="wndqcwsieTable">
        <thead>
        <tr>
        <th colspan="1" class="center-align">Date</th> 
          <th colspan="2" class="center-align">Quality</th> 
          <th colspan="1" class="center-align">No of Winder</th>
            <th colspan="4" class="center-align">Production</th>
            <th colspan="4" class="center-align">Target</th>
            <th colspan="1" class="center-align">Difference</th>
            <th colspan="4" class="center-align">Production/Winder</th>
            <th colspan="2" class="center-align">Month to Date</th>
        </tr>

            <tr>
                <th>Date </th>
                <th>Q Code </th>
                <th>Quality </th>
                <th>no Of Winder</th>

                <th>Shift A</th>
                <th>Shift B</th>
                <th>Shift C</th>
                <th>Total</th>
                
                <th>Shift A</th>
                <th>Shift B</th>
                <th>Shift C</th>
                <th>Total</th>
                
                <th>.</th>
            
                <th>Shift A</th>
                <th>Shift B</th>
                <th>Shift C</th>
                <th>Average</th>
 
                <th>Production</th>
                <th>Avg Prod/Winder</th>
       
                
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
<br></br>
<br></br>

    <h2>Winding Quality Group List</h2>
    <table id="wndqcsummTable">
    <thead>
        <tr>
          <th colspan="9" class="center-align">Winding</th> 
          <th colspan="6" class="center-align">Spining</th>
      </tr>  
      <tr>
      <th   colspan="1" class="center-align">Quality</th>
            <th colspan="4" class="center-align">Employee</th>
            <th colspan="4" class="center-align">Production</th>
            <th colspan="1" class="center-align">Quality</th>
            <th colspan="4" class="center-align">Production</th>
        </tr>

            <tr>
                <th>Quality </th>
         
                <th>Shift A</th>
                <th>Shift B</th>
                <th>Shift C</th>
                <th>Total</th>
                
                <th>Shift A</th>
                <th>Shift B</th>
                <th>Shift C</th>
                <th>Total</th>
                
            
                <th>Winder </th>
         
                <th>Shift A</th>
                <th>Shift B</th>
                <th>Shift C</th>
                <th>Total</th>
 
                 
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

$("#wndqcwiseDate").datepicker({ 
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

                $('#wndqcwiseDate').datepicker('setDate', 'today');

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

  
</script>

<script>
        $(document).ready(function() {
            $('input[type="text"]').on('focus', function() {
                $(this).select();
            });

       
 
        });

//start save
  
      initDataTable();
      qinitDataTable();
      function initDataTable() {
        $("#loadingSpinner").show();
       
                var companyId=$('#companyId').val();
                var windingqcDate= $('#wndqcwiseDate').val();
         
          $('#wndqcwsieTable').DataTable().destroy();
       
            table = $('#wndqcwsieTable').DataTable({
                ajax: {
                    url: '<?php echo base_url('admin/reports/Winding_data_reports/get_wndqcwisereport'); ?>',
                    type: 'POST',
                    data: function(d) {
                        d.date = $('#wndqcwiseDate').val();
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
                   
                 },

                drawCallback: function() {
                // Apply alignment styles to the table cells
                $('#recordTable td.column-align-center').css('text-align', 'center');
                $('#recordTable td.column-align-right').css('text-align', 'right');
            },
                order: [[0, 'asc']],                 // Sort by the first column (auto_id) in descending order
                pageLength: 25 // Set the default number of rows per page to 25
              });
              $("#loadingSpinner").hide();

            }

        function qinitDataTable() {
           $("#loadingSpinner").show();
          $('#wndqcsummTable').DataTable().destroy();
         table = $('#wndqcsummTable').DataTable({
                ajax: {
                    url: '<?php echo base_url('admin/reports/Winding_data_reports/get_wndqcsummreport'); ?>',
                    type: 'POST',
                    data: function(d) {
                      d.date = $('#wndqcwiseDate').val();
                        d.companyId=$('#companyId').val();
                    }
                  },columnDefs: [
                    { targets: [0], visible: true }, // Hide the first column (auto_id)
                    { targets: [3], visible: true },{
                    targets: [3],
                    render: function(data, type, row) {
                        if (parseFloat(data)>8 ) {
                             return '<strong>' + data + '</strong>';
                        }
                        return data;
                    }
                  }
                ],
                "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                   if ((aData[6] )!=(aData[11])) {
                     $('td', nRow).css('background-color', 'Red');
                   }
                   if ((aData[7] )!=(aData[12])) {
                     $('td', nRow).css('background-color', 'Red');
                   }
                   if ((aData[8] )!=(aData[13])) {
                     $('td', nRow).css('background-color', 'Red');
                   }
 

     
                },
   
   
                drawCallback: function() {
                // Apply alignment styles to the table cells
                $('#recordTable td.column-align-center').css('text-align', 'center');
                $('#recordTable td.column-align-right').css('text-align', 'right');
            },
                order: [[0, 'desc']],                 // Sort by the first column (auto_id) in descending order
                pageLength: 25 // Set the default number of rows per page to 25
              });
              $("#loadingSpinner").hide();
            }
   
       

        function refreshDataTable() {
            $("#loadingSpinner").show();

            initDataTable();
      qinitDataTable();
//          table.ajax.reload(null, false); // Reload the data without resetting the current page
$("#loadingSpinner").hide();

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


            $('#wndqcwiseDate').on('change', function() {

                refreshDataTable();
            });

 

    $("#wndspginput").click(function(event){
                  event.preventDefault(); 
                
        	var opt=3;
            var wndqcwiseDate= $('#wndqcwiseDate').val();
            var companyId=$('#companyId').val();
            alert('spg');
            var url = '<?php echo site_url("admin/reports/winding_data_reports/expspginputexl"); ?>' +
                      '?windingrepDate=' + wndqcwiseDate +
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
