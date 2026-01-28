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
  
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    
    <!-- Include FixedColumns CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedcolumns/3.3.2/css/fixedColumns.dataTables.min.css">
    
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    
    <!-- Include FixedColumns JavaScript -->
    <script src="https://cdn.datatables.net/fixedcolumns/3.3.2/js/dataTables.fixedColumns.min.js"></script>


  <style>
/* Hide the image by default */
/*
.item-image {
    display: none;
    position: absolute;
    top: 10;
    left: 0;
    z-index: 9999;
    max-width: 400px; /* Adjust the maximum width as needed 
    z-index: 9999;
}
*/
/* Show the image on hover */
#spgdailyrecordTable tbody tr:hover .item-image {
    display: block;
}
*/

/* Hide the image by default */
.item-image {
    display: none;
    position: absolute;
    max-width: 100%;
    z-index: 9999;
    border: 2px solid #ddd;
    background-color: white;
    padding: 10px;
}

/* Show the image on hover over the specified column */
.show-image:hover + .image-column .item-image {
    display: block;
}


/* Zebra stripes for odd and even rows */
#spgdailyrecordTable tbody tr:nth-child(odd) {
    background-color: #f2f2f2; /* Light gray */
}

#spgdailyrecordTable tbody tr:nth-child(even) {
    background-color: #ffffff; /* White */
}

    #spgdailyrecordTable {
        border-collapse: collapse;
        width: 100%;
    }

    #recordTable th,
    #recordTable td {
        border: 1px solid #ddd;
      /*  padding: 8px; */
    }

    #spgdailyrecordTable th {
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
    }
    .no-wrap{
    white-space:normal;
}
.width-200{
    width:200px;
}
th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        margin: 0 auto;
    }

    </style>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
          <h3 class="m-1 text-dark text-center" style="background-color: #1589FF;"><strong>Item Master </strong></h3>

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
						  <label for="purchaseDetailsPurchaseDate">From Date<span class="text-center">*</span></label>
						  <input type="text" style="height: 50px; color:blue; font-style: bold; font-size: 28px;"
               class="form-control datepicker text-center" id="startdate" 
              name="startdate"   readonly >
			</div>					<div class="form-group col-md-2">
						  <label for="purchaseDetailsPurchaseDate">To  Date<span class="text-center">*</span></label>
						  <input type="text" style="height: 50px; color:blue; font-style: bold; font-size: 28px;"
               class="form-control datepicker text-center" id="enddate" 
              name="enddate"   readonly >
			</div>
                        <div class="form-group col-md-2"  style="margin-left: 20px;">
							<label for="purchaseDetailsVendorName">Item Code<span class="requiredIcon text-center">*</span></label>
							<input type="text" id="itemcode" style="height: 50px; color:blue; font-style: bold; font-size: 28px;"  
                              name="itemcode" class="form-control   text-center">
						 </div>
                          <div class="form-group col-md-2"  style="margin-left: 20px;">
							<label for="purchaseDetailsVendorName">Issue Qty<span class="requiredIcon text-center">*</span></label>
							<input type="text" id="issqty" style="height: 50px; color:blue; font-style: bold; font-size: 28px;"  
                              name="issqty" class="form-control   text-center">
		    		  </div>

                      <div class="form-group col-md-2" style="margin-left: 20px;">
			  <label for="purchaseDetailsPurchaseDate">Update<span class="text-center"></span></label>
              <button name="submit" id="searchbtn" style="height: 50px;" type="submit" class="form-control btn btn-primary">Update</button>
            </div>
               </div>
 
               <div class="form-row">
               <div class="form-group col-md-2" style="margin-left: 20px;">
			  <label for="purchaseDetailsPurchaseDate">Update SR Issue<span class="text-center"></span></label>
              <button name="submit" id="upsrnobtn" style="height: 50px;" type="submit" class="form-control btn btn-primary">Update SR Issue</button>
            </div>
          
            
            </div>
   
              </div>



 
 <?php
                  $company_id = $this->session->userdata('company_id');
                //  echo $company_id;
              ?>
 
<input type="hidden" class="input" value="<?php echo $company_id; ?>" id="companyId" />
              <input type="hidden" class="input" value=0 id="mc1_id" />
              <input type="hidden" class="input" id="record_id" />
              <input type="hidden" class="input" id="mc3_id" />
              <input type="hidden" class="input" id="trollyid" />
 
              


			
      
      

 
        

         
            

              <div id="imageContainer"></div>         


            </form>
       
    <table id="spgdailyrecordTable" class="display nowrap" style="width:100%">
        <thead>
            <tr>
            <th>Inward_id</th>
            <th>Inw Detail/issNo</th>
            <th>Date</th>
            <th>SR No</th>
            <th>Item Id</th>
                <th>Item Code </th>
                <th>Item Desc</th>
                <th>Recv Qty</th>
                <th>App Iss Qty</th>
                <th>Iss Qty</th>
                <th>SR Bal Qty</th>
                <th>Stk Qty</th>
                <th>Last Sr Bal</th>
                <th>SR Line Id</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
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

$("#startdate").datepicker({ 
  dateFormat: 'dd-mm-yy',
					todayHighlight:'TRUE',
					autoclose: true,
                    maxDate: '0',
                });
                $("#enddate").datepicker({ 
                  dateFormat: 'dd-mm-yy',
					todayHighlight:'TRUE',
					autoclose: true,
                });

                $('#enddate').datepicker('setDate', 'today');
                $('#startdate').datepicker('setDate', '01-04-2020');

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

//$("#savespgentry").attr('disabled',true);

 
 
</script>

<script>
        $(document).ready(function() {
            $('input[type="text"]').on('focus', function() {
                $(this).select();
            });
        });

      initDataTable();
 
        function initDataTable() {
             var companyId=$('#companyId').val();
             var groupcode=$('#groupcode').val();
             var itemcode=$('#itemcode').val();
             var startdate=$('#startdate').val();
             var enddate=$('#enddate').val();
             $('#spgdailyrecordTable').DataTable().destroy();

            table = $('#spgdailyrecordTable').DataTable({
                ajax: {
                    url: '<?php echo base_url('admin/reports/physical_item_report/get_itemdatarecords'); ?>',
                    type: 'POST',
                    data: function(d) {
                        d.companyId=$('#companyId').val();
                        d.itemcode=$('#itemcode').val();
                        d.startdate=$('#startdate').val();
                        d.enddate=$('#enddate').val();
                    }
                  },
                      columnDefs: [
                    { targets: [0,1,2], visible: true }, // Hide the first column (auto_id)
                    { targets: [0], "className": "no-wrap" },
                    { "width": "50px", "targets": [0, 2], "className": "no-wrap" }, // Set the width and apply the no-wrap class to the first and third columns
                    { targets: [6,7,8,9,10,11,12], className: "text-center" }, 
   
            {
                targets: -1, // The last column
                render: function(data, type, row, meta) {
                  return '<button class="delete-button" data-record-id="' + row[1] + '"><i class="fas fa-trash"></i></button>';
               //   return '<button class="delete-button" data-record-id="' + row[0] + '">Delete</button>';
                }
            }
     
            
                ],
                              "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {

                if (aData[10] <0)    {
                        $('td', nRow).css('background-color', 'Red');
                } 
                if (aData[11]<0)    {
                        $('td', nRow).css('background-color', 'orange');
}
},

fixedColumns: {
                    leftColumns: 1,
                    rightColumns: 1
                },processing: true,

                lengthMenu: [
        [10, 25, 50, -1],
        [10, 25, 50, 'All']
    ],
              scrollY: "560px",
  
                scrollCollapse: true,
                scrollX: true,
                scroller: true,
                scrolly:true,  
                autoWidth: false,   
                paging: false, 
                "ordering": false,
                // Sort by the first column (auto_id) in descending order
                pageLength: 10 // Set the default number of rows per page to 25
              });
        }
   



        function refreshDataTable() {
      
          table.ajax.reload(null, false); // Reload the data without resetting the current page
        }



            $('#enddate, #itemcode,#itemdesc,#location,#stock').on('change', function() {
     //          alert('refr');
                refreshDataTable();
            });

            $('#spgdailyrecordTable tbody').on('click', 'tr', function() {
                var rowData = table.row(this).data();
                $('#record_id').val(rowData[1]);
                var rcvqty=rowData[7];
                var aissqty=rowData[8];
                var nissqty=rowData[9];

                if (aissqty>0) {
                    $('#issqty').val(aissqty);
                } else {
                    $('#issqty').val(nissqty);
                }
                if (rcvqty>0) { 
                    alert( 'Please select Issue');
                    $('#record_id').val(0);
                    $('#issqty').val(0);
                }    
           
            });

          
            
            $('#recordTable tbody').on('click', 'tr', function() {
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                } else {
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                }
            });

  
            $('#spgdailyrecordTable tbody').on('click', 'button.delete-button', function () {
              var closestRow = $(this).closest('tr');
    
    // Get the data associated with the table row
    var rowData = table.row(closestRow).data();
    
    if (rowData) {
  //      alert(rowData[7]); // Assuming the data you want is in the first column (index 0)
    } else {
        alert("Row data not found.");
    }
              
                var recordId = $(this).data('record-id');
               var rcvqty=rowData[7];
    //            alert(recordId);
  
    // Show a custom confirmation dialog
    if (rcvqty>0) {
        alert('Please select issue only');
    }
    if (rcvqty==0) {
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
    }

});

 

// Function to delete a record
function deleteRecord(recordId) {
  
  $.ajax({
    url: "<?php echo base_url('admin/reports/physical_item_report/deleteRecord'); ?>",
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

 


//start save
$("#searchbtn").click(function(event){
          event.preventDefault(); 
          var issqty =  $('#issqty').val();
          var companyId=$('#companyId').val();
          var record_id=$('#record_id').val();
           if (issqty==0) {
                alert('enter issue qty');
            
                return false;
            
           } 
          $.ajax({
            url: "<?php echo base_url('admin/reports/physical_item_report/dofmodupdate_data'); ?>",
            type: "POST",
            data: {issqty: issqty,companyId: companyId,
           record_id: record_id
            },
            dataType: "json",
            success: function(response) {
              var savedata=(response.savedata);
                $('#issqty').val('');
                $('#record_id').val('');
                

                if (response.success) {
                    alert('Record Updated Successfully');
                    refreshDataTable();
                  }
            }
        });

      });


      $("#upsrnobtn").click(function(event){
          event.preventDefault(); 
          var issqty =  $('#issqty').val();
          var companyId=$('#companyId').val();
          var record_id=$('#record_id').val();
          var itemcode=$('#itemcode').val();
          alert(itemcode);
          $.ajax({
            url: "<?php echo base_url('admin/reports/physical_item_report/srissueupdate_data'); ?>",
            type: "POST",
            data: {issqty: issqty,companyId: companyId,
           record_id: record_id,itemcode: itemcode
            },
            dataType: "json",
            success: function(response) {
              var savedata=(response.savedata);
                $('#issqty').val('');
                $('#record_id').val('');
                

                if (response.success) {
                    alert('Record Updated Successfully');
                    refreshDataTable();
                  }
            }
        });

      });



   
 

 
 
       

 
</script>



</body>
</html>
