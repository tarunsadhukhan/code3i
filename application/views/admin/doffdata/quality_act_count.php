  <!-- /.navbar -->

  <?php



use PHPUnit\TextUI\XmlConfiguration\CodeCoverage\Report\Php;

 $this->load->view('admin/header'); ?>

<style>
    #qacntrecordTable {
        border-collapse: collapse;
        width: 100%;
    }

    #qacntrecordTable th,
    #qacntrecordTable td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #qacntrecordTable th {
        background-color: #f2f2f2;
    }

    #qacntrecordTable tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    #qacntrecordTable tr:hover {
        background-color: #ddd;
    }

    .selected {
        background-color: yellow;
    }
    #qacntrecordTable td.column-align-center {
        text-align: center;
    }

    #qacntrecordTable td.column-align-right {
        text-align: right;
    }</style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-10">
          <h3 class="m-1 text-dark text-center" style="background-color: #1589FF;">Daily Quality Wise Act Count</h3>
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
						<div class="form-group col-md-2">
						  <label for="purchaseDetailsPurchaseDate">Entry Date<span class="text-center">*</span></label>
						  <input type="text" style="height: 50px; color:blue; font-style: bold; font-size: 28px;"
               class="form-control datepicker text-center" id="qcacntdate" 
              name="qcacntdate"   readonly >
						</div>
			
                        <div class="form-group col-md-2">
                    <label >Q Code </label>
                    <input type="text" name="qcode_1" id="qcode_1" value="" 
                    style="height: 50px; color:blue; font-style: bold; font-size: 38px;"
                    class="form-control text-center ">
            </div>
            <div class="form-group col-md-3">
                    <label >Quality </label>
                    <input type="text" name="framename" id="quality1" value="" 
                    style="height: 50px; color:blue; font-style: bold; font-size: 28px; disabled:disabled" "
                    class="form-control text-center readonly">
          </div>
 
          <div class="form-group col-md-2">
                    <label >Act Count</label>
                    <input type="text" name="act_count" id="act_count" value="" 
                    style="height: 50px; color:blue; font-style: bold; font-size: 38px;"
                    class="form-control text-center ">
            </div>
  
  

 
              <div class="form-group col-md-2" style="margin-left: 20px;">
						  <label for="purchaseDetailsPurchaseDate">Save Data<span class="text-center"></span></label>
              <button name="submit" id="saveqacnt" style="height: 50px;" type="submit" class="form-control btn btn-primary">Save Data</button>
              <button name="submit" id="updateqacnt" style="height: 50px;" type="submit" class="form-control btn btn-primary">Update Data</button>
            
            </div>


					  </div>
			
            <hr style="height:4px; background-color: brown;"></hr>
 
          
            
            </div>
  
 

            </form>
       
            <h1>Record List</h1>
    <table id="qacntrecordTable">
        <thead>
            <tr>
                <th>Record ID</th>
                <th>Entry Date</th>
                <th>Q Code</th>
                <th>Quality</th>
                <th>Actual Count</th>
                 
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

 // $("#updateqacnt").attr('disabled',true);
$('#saveqacnt').show();
$('#updateqacnt').hide();
$("#saveqacnt").attr('disabled',true);
//$('#updateqacnt').show();
//$('#saveqacnt').hide();
$('#record_id').val('0');
         
 
})

$("#qcacntdate").datepicker({ 
  dateFormat: 'dd-mm-yy',
					todayHighlight:'TRUE',
					autoclose: true,
          maxDate: '0',                });
                $("#payrollenddate").datepicker({ 
                  dateFormat: 'dd-mm-yy',
					todayHighlight:'TRUE',
					autoclose: true,
                });

                $('#qcacntdate').datepicker('setDate', 'today');

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
          var qcacntdate=$('#qcacntdate').val();
          var record_id=$('#record_id').val();
         
          $.ajax({
            url: "<?php echo base_url('admin/Doffdata/qacntcget_quality'); ?>",
            type: "POST",
            data: {qcode_1: qcode_1,companyId: companyId,qcacntdate: qcacntdate,record_id: record_id },
            dataType: "json",
            success: function(response) {
              if (response.success) {
                     $('#quality1').val(response.name);
                     $("#saveqacnt").attr('disabled',false);
                     $("#updateqacnt").attr('disabled',false);
                     
                    var duplicate=(response.duplicate);
                    $('#quality1').css({'border-color': 'green','background-color': 'white'
                    });
                    var quality1=$('#quality1').val();
                    var ln=length.quality1;
                    if (duplicate>0)  {
                        alert('Quality already Entered');
                        $('#quality1').css({'border-color': 'red','background-color': 'orange'      });
                         $("#updateqacnt").attr('disabled',true);
                         $("#saveqacnt").attr('disabled',true);
                    }
                } else {
                    $('#trollyNo').val('0');
                    $('#quality1').css({'border-color': 'red','background-color': 'yellow'
                    });
                    $("#saveqacnt").attr('disabled',true);
                    $("#updateqacnt").attr('disabled',true);
                    
                }
            }
        });
 
      });

 
     
       
 
        });

  
      initDataTable();
      function initDataTable() {
          var compid=$('#companyId').val();
//          alert(compid);
            table = $('#qacntrecordTable').DataTable({
                ajax: {
                    url: '<?php echo base_url('admin/Doffdata/get_qacntrecords'); ?>',
                    type: 'POST',
                    data: function(d) {
                        d.date = $('#qcacntdate').val();
                        d.compId=$('#companyId').val();
                    }
                  },columnDefs: [
                    { targets: [0], visible: false }, // Hide the first column (auto_id)
                    {
                    targets: [1, 3],
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
        
 
 
 

        $('#qacntrecordTable tbody').on('click', 'tr', function() {
                var rowData = table.row(this).data();
                $('#record_id').val(rowData[0]);
                $('#qcode_1').val(rowData[2]);
                $('#quality1').val(rowData[3]);
                $('#act_count').val(rowData[4]);
                $('#updateqacnt').show();
                $('#saveqacnt').hide();
    

              });
        
            $('#qacntrecordTable tbody').on('click', 'tr', function() {
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                } else {
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                }
            });


            $('#qcacntdate').on('change', function() {
                $('#record_id').val(0);
                $('#act_count').val('');
                $('#qcode_1').val('');
                $('#quality1').val('');
                
                $('#updateqacnt').hide();
                $('#saveqacnt').show();
                $("#saveqacnt").attr('disabled',true);
                $("#updateqacnt").attr('disabled',true);
 
                refreshDataTable();
            });

//end save
//$('#recordTable').DataTable();

 
//start save
 

//start save
$("#saveqacnt").click(function(event){
          event.preventDefault(); 
          var qcacntdate = $('#qcacntdate').val();
          var companyId=$('#companyId').val();
          var act_count= $('#act_count').val(); 
          var qcode_1= $('#qcode_1').val(); 
          var record_id= $('#record_id').val(); 
            $.ajax({
            url: "<?php echo base_url('admin/Doffdata/saveqacnt_data'); ?>",
            type: "POST",
            data: {qcacntdate: qcacntdate,act_count: act_count,companyId: companyId,record_id: record_id,
               qcode_1: qcode_1
            },
            dataType: "json",
            success: function(response) {
              var savedata=(response.savedata);
//                 alert(savedata);    
                $('#act_count').val('');
                $('#qcode_1').val('');
                $('#record_id').val(0);
                $('#quality1').val('');
                $('#frameName').val('');
                 
               
                if (response.success) {
                    alert('Record Updated Successfully');
                    $('#updateqacnt').hide();
                   $('#saveqacnt').show();
                   refreshDataTable();
     
                }
            }
        });
        refreshDataTable();
      });

      $("#updateqacnt").click(function(event){
          event.preventDefault(); 
          var qcacntdate = $('#qcacntdate').val();
          var companyId=$('#companyId').val();
          var act_count= $('#act_count').val(); 
          var qcode_1= $('#qcode_1').val(); 
          var record_id= $('#record_id').val(); 
            $.ajax({
            url: "<?php echo base_url('admin/Doffdata/updateqacnt_data'); ?>",
            type: "POST",
            data: {qcacntdate: qcacntdate,act_count: act_count,companyId: companyId,record_id: record_id,
               qcode_1: qcode_1
            },
            dataType: "json",
            success: function(response) {
              var savedata=(response.savedata);
                 alert(savedata);    
                $('#act_count').val('');
                $('#qcode_1').val('');
                $('#record_id').val(0);
                $('#quality1').val('');
               
                 
               
                if (response.success) {
                    alert('Record Updated Successfully');
                    $('#updateqacnt').hide();
                   $('#saveqacnt').show();
                   refreshDataTable();
     
                }
            }
        });
        refreshDataTable();
      });





</script>



</body>
</html>
