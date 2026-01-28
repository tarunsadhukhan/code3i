   <!-- /.navbar -->

   <?php



use PHPUnit\TextUI\XmlConfiguration\CodeCoverage\Report\Php;

 $this->load->view('admin/header'); ?>

<style>
    #doffrepcrecordTable {
        border-collapse: collapse;
        width: 100%;
    }

    #doffrepcrecordTable th,
    #doffrepcrecordTable td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #doffrepcrecordTable th {
        background-color: #EBF5FB;
    }

    #doffrepcrecordTable tr:nth-child(even) {
        background-color: #FFEBCD;
    }

    #doffrepcrecordTable tr:hover {
        background-color: #2E86C1;
    }

    .selected {
        background-color: yellow;
    }
    #doffrepcrecordTable td.column-align-center {
        text-align: center;
    }

    #doffrepcrecordTable td.column-align-right {
        text-align: right;
    }</style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-10">
          <h3 class="m-1 text-dark text-center" style="background-color: #1589FF;">Online Doff Report</h3>
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
               class="form-control datepicker text-center" id="doffrepdate" 
              name="doffrepdate"   readonly >
			</div>
			
       
 

            <div class="form-group col-md-2"  style="margin-left: 50px;">
							<label for="purchaseDetailsVendorName">Shift<span class="requiredIcon text-center">*</span></label>
							<select id="doffrepshiftName" style="height: 50px; color:blue; font-style: bold; font-size: 28px;"
              name="doffrepshiftName" class="form-control chosenSelect  text-center">
              
              echo "<option value='' > All Spell</option>";
               echo "<option value='A1' > A1</option>";
              echo "<option value='B1' > B1</option>";
              echo "<option value='A2' > A2</option>";
              echo "<option value='B2'  > B2</option>";
              echo "<option value='C' > C</option>";
							</select>
						  </div>
          <div class="form-group col-md-2">
           <label >Frame No </label>
           <input type="text" name="q" id="doffrepframeNo" value="" 
           style="height: 50px; color:blue; font-style: bold; font-size: 38px; "
           class="form-control text-center">
           </div>

           <div class="form-group col-md-2" style="margin-left: 20px;">
	  		  <label for="purchaseDetailsPurchaseDate">Export to Xl<span class="text-center"></span></label>
              <button name="submit" id="dofonlinechecklist" style="height: 50px;" type="submit" class="form-control btn btn-primary">Checklist</button>
            </div>

            <div class="form-group col-md-2" style="margin-left: 20px;">
  	  		  <label for="purchaseDetailsPurchaseDate">Export to Xl<span class="text-center"></span></label>
            <button name="submit" id="dofonlineexcelbtn" style="height: 50px;" type="submit" class="form-control btn btn-primary">Export</button>
            </div>


            </div>


					  </div>
			
            <hr style="height:4px; background-color: brown;"></hr>
    
 
            </form>
       
            <h1>Record List</h1>
    <table id="doffrepcrecordTable">
        <thead>
            <tr>
                <th>Sl No</th>
                <th>Doff Date</th>
                <th>Spell</th>
                <th>Frame No</th>
                <th>Employee</th>
                <th>Quality</th>
                <th>Trolly No</th>
                <th>Gross Wt</th>
                <th>Tare Wt</th>
                <th>Net Wt</th>
                <th>Doff Time</th>
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
function getQueryParam(name) {
        var urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
    }


//    function getdataprm() {
         var frm = getQueryParam('frm');
         var spfdt = getQueryParam('spfdt');
 //   $('#doffrepframeNo').val(frm);

    function getdataprm() {
//            alert(frm);
          var companyId=$('#companyId').val();
            
          $.ajax({
            url: "<?php echo base_url('admin/reports/onlinedoffreporta/getfrmshno'); ?>",
            type: "POST",
            data: {companyId: companyId,frameNo: frm },
            dataType: "json",
            success: function(response) {
                var shfrm=response.trollyWt;
                $('#doffrepframeNo').val(shfrm);
                refreshDataTable();
                
                     
                 }
                });

        }

getdataprm();


$("#doffrepdate").datepicker({ 
    dateFormat: 'dd-mm-yy',
					todayHighlight:'TRUE',
					autoclose: true,
                });
                $("#payrollenddate").datepicker({ 
                  dateFormat: 'dd-mm-yy',
					todayHighlight:'TRUE',
					autoclose: true,
                });

                $('#doffrepdate').datepicker('setDate', spfdt);

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
 /*
    $('#doffrepcrecordTable').DataTable({
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
      function initDataTable() {
          var compid=$('#companyId').val();
  //       alert('compid');
         $('#doffrepcrecordTable').DataTable().destroy();
            table = $('#doffrepcrecordTable').DataTable({
                ajax: {
                    url: '<?php echo base_url('admin/Doffdata/get_doffreprecords'); ?>',
                    type: 'POST',
                    data: function(d) {
                        d.date = $('#doffrepdate').val();
                        d.shift = $('#doffrepshiftName').val();
                        d.compId=$('#companyId').val();
                        d.doffrepframeNo=$('#doffrepframeNo').val();
                    }
                  },columnDefs: [
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
                order: [[0, 'desc']],  
                scrollx: 1300,
       
        scroller: true,
                autoWidth : true,           
                 // But we do have value, so we can add CSS from data.status_color value
  
  "initComplete": function (settings, json) {  
    $("#DataTableID").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
  },             // Sort by the first column (auto_id) in descending order
                pageLength: 10 // Set the default number of rows per page to 25
              });
        }


  $("#dofonlinechecklist").click(function(event){
           event.preventDefault();  
           var compid=$('#companyId').val();
    //  alert(compid);
      if ($.fn.DataTable.isDataTable('#doffrepcrecordTable')) {
    $('#doffrepcrecordTable').DataTable().destroy();
  }
           table = $('#doffrepcrecordTable').DataTable({
                ajax: {
                    url: '<?php echo base_url('admin/Doffdata/get_doffreprecordschk'); ?>',
                    type: 'POST',
                    data: function(d) {
                        d.date = $('#doffrepdate').val();
                        d.shift = $('#doffrepshiftName').val();
                        d.compId=$('#companyId').val();
                        d.doffrepframeNo=$('#doffrepframeNo').val();
                    }
                  },columnDefs: [
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
                order: [[0, 'desc']],  
                scrollx: 1300,
        scroller: true,
                autoWidth : true,           
  "initComplete": function (settings, json) {  
    $("#DataTableID").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
  },             // Sort by the first column (auto_id) in descending order
                pageLength: 10 // Set the default number of rows per page to 25
              });
            });

    
        function refreshDataTable() {
          initDataTable();
   //         table.ajax.reload(null, false); // Reload the data without resetting the current page
        }
        
 
 
 

        $('#doffrepcrecordTable tbody').on('click', 'tr', function() {
                var rowData = table.row(this).data();
                $('#record_id').val(rowData[0]);
                $('#qcframeNo').val(rowData[3]);
                $('#qcframeName').val(rowData[4]);
                $('#qcode_1').val(rowData[5]);
                $('#quality1').val(rowData[6]);
            });
        
            $('#doffrepcrecordTable tbody').on('click', 'tr', function() {
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                } else {
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                }
            });


            $('#doffrepdate, #doffrepshiftName,#doffrepframeNo' ).on('change', function() {
 
                refreshDataTable();
            });

//end save
//$('#recordTable').DataTable();

 
//start save
 

//start save
 
$("#dofonlineexcelbtn").click(function(event){
  event.preventDefault(); 

//	alert ("aaaa");
	var opt=3;
            var doffrepdate= $('#doffrepdate').val();
            var companyId=$('#companyId').val();
            var doffrepframeNo=$('#doffrepframeNo').val();
            var doffrepshiftName=$('#doffrepshiftName').val();
  //          alert(companyId);
            // doffrepframeNo            
           // doffrepshiftName
            var url = '<?php echo site_url("admin/Doffdata/dofonlineexportToExcel"); ?>' +
                      '?doffrepdate=' + doffrepdate +
                       '&companyId=' + companyId + '&doffrepframeNo=' + doffrepframeNo + '&doffrepshiftName=' + doffrepshiftName  
                         ;
                      alert(url);
			//$(location).attr('href',url);
			window.open( url, '_blank');
			
			
return false;
});





</script>



</body>
</html>
