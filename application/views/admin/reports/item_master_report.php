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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

 
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>


<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

<!--
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
-->
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
   <!-- Select2 -->
   <link rel="stylesheet" href="<?php echo base_url()?>public/admin/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo base_url()?>public/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <script src="<?php echo base_url()?>public/admin/plugins/select2/js/select2.full.min.js"></script>
   



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
    
    .custom-popover {
    background-color: #add8e6 !important;
}
    
    </style>

<style>
        /* Add your styles for the modal and form here */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
             border: 4px solid #333; /* Border color */
             background-color: #fff;
             
            background-color: rgba(0,0,0,0.4);
            
        }
/*
.modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            border: 2px solid #333; 
            background-color: #fff;
            z-index: 1000;
        }
  */
        .modal-content {
            background-color: rgb(235, 245, 251);
            margin: auto;
            padding: 40px;
            border: 1px solid #888;
            width: 60%; /* Set the width as needed */
     /*   height: 80%;  Set the height as needed 
        max-width: 800px; */ /* Optional: Set a maximum width */
        overflow-y: auto; /* Enable vertical scrollbar if needed */
                    margin-top: 10%; /* Adjust the top margin to center vertically */
                    display: flex;
        align-items: flex-start; /* Align items at the top */
                    
                }

        .image-container {
            max-width: 400px;
            max-height: 400px;
            overflow: hidden;
            flex: 1;
        padding: 20px;
        }

        .image-container img {
            max-width: 400px;
            max-height: 500px;
        }
         .image-container {
  float: right;
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

            <?php
                  $company_id = $this->session->userdata('company_id');
                  $Stock='Stock Quantity ';  
                  //  echo $company_id;
              ?>

            
      <div class="form-row">

                        <div class="form-group col-md-2"  style="margin-left: 20px;">
							<label for="purchaseDetailsVendorName">Group Code<span class="requiredIcon text-center">*</span></label>
							<input type="text" id="groupcode" style="height: 50px;  color:blue; font-style: bold; font-size: 28px;"  
                              name="groupcode" class="form-control   text-center">
						  </div>
                        <div class="form-group col-md-2"  style="margin-left: 20px;">
							<label for="purchaseDetailsVendorName">Item Code<span class="requiredIcon text-center">*</span></label>
							<input type="text" id="itemcode" style="height: 50px; color:blue; font-style: bold; font-size: 28px;"  
                              name="itemcode" class="form-control   text-center">
						 </div>
                          <div class="form-group col-md-2"  style="margin-left: 20px;">
							<label for="purchaseDetailsVendorName">Item Desc<span class="requiredIcon text-center">*</span></label>
							<input type="text" id="itemdesc" style="height: 50px; color:blue; font-style: bold; font-size: 28px;"  
                              name="itemdesc" class="form-control   text-center">
		    		  </div>
                      <div class="form-group col-md-2"  style="margin-left: 20px;">
							<label for="purchaseDetailsVendorName">Location<span class="requiredIcon text-center">*</span></label>
							<input type="text" id="location" style="height: 50px; color:blue; font-style: bold; font-size: 28px;"  
                              name="location" class="form-control   text-center">
		    		  </div>
                      <div class="form-group col-md-2" style="margin-left: 20px;">
                         <label for="purchaseDetailsVendorName">Stocks More Than<span class="requiredIcon text-center">*</span></label>
                        <input type="text" id="stock" style="height: 50px; color: blue; font-style: bold; font-size: 28px;" name="stock" class="form-control text-center">
                        </div>
                        <div class="form-group col-md-1" style="margin-left: 20px;">
						  <label for="purchaseDetailsPurchaseDate">Update Data<span class="text-center"></span></label>
                        <button onclick="openModal()" name="submit" id="excelbt" style="height: 50px;" type="submit" class="form-control btn btn-primary">Update Data</button>
            
                        </div>
                    </div>
 
  
   
              </div>
        <div id="myModal" class="modal">
            <div class="modal-content">
                <form action="<?= site_url('maincontroller/add_data') ?>" method="post" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="form-group col-md-2"  style="margin-left: 20px;">
                            <label for="purchaseDetailsVendorName">Item Code<span class="requiredIcon text-center">*</span></label>
                            <input type="text" id="uitemcode" style="height: 40px; color:blue; font-style: bold; font-size: 18px;"  
                            name="uitemcode" disabled class="form-control   text-center">
                        </div>
                        <div class="form-group col-md-6"  style="margin-left: 20px;">
                            <label for="purchaseDetailsVendorName">Item Description<span class="requiredIcon text-center">*</span></label>
                            <input type="text" id="uitemdesc" readonly style="height: 40px; color:blue; font-style: bold; font-size: 18px;"  
                            name="uitemcode" class="form-control   text-center">
                        </div>
                        <div class="form-group col-md-2"  style="margin-left: 20px;">
                            <label for="purchaseDetailsVendorName">Location<span class="requiredIcon text-center">*</span></label>
                            <input type="text" id="ulocation" style="height: 40px; color:blue; font-style: bold; font-size: 18px;"  
                            name="ulocation" class="form-control   text-center">
                        </div>
                      <div class="form-group col-md-2"  style="margin-left: 20px;">
                          <input type="text" class="form-control   text-center" disabled id="stockqty" style="height: 40px; color:blue; font-style: bold; font-size: 18px;"  />
 		    		  </div>
                       <div class="form-group col-md-2"  style="margin-left: 20px;">
                          <input type="text" class="form-control   text-center" disabled id="minqt" style="height: 40px; color:blue; font-style: bold; font-size: 18px;"  />
 		    		  </div>
                       <div class="form-group col-md-2"  style="margin-left: 20px;">
                          <input type="text" class="form-control   text-center" disabled id="maxqt" style="height: 40px; color:blue; font-style: bold; font-size: 18px;"  />
 		    		  </div>
                       <div class="form-group col-md-2"  style="margin-left: 20px;">
                          <input type="text" class="form-control   text-center" disabled id="opoqty" style="height: 40px; color:blue; font-style: bold; font-size: 18px;"  />
 		    		  </div>
                       <div class="form-group col-md-2"  style="margin-left: 20px;">
                          <input type="text" class="form-control   text-center" disabled id="oindqty" style="height: 40px; color:blue; font-style: bold; font-size: 18px;"  />
 		    		  </div>
 
</div>
<div class="form-row">
<div class="form-group col-md-4 image-container"  style="margin-left: 20px;"
         width="600" height="600" id="imageContainer"  ></div>
  <div class="form-group col-md-8"  style="margin-left: 20px;">
  <canvas id="monthlyChart" width="1200" height="500"></canvas>
  </div>
  
</div>

<div class="form-row">

            <!-- File input for image upload 
                       <label for="image">Upload Image:</label>
            -->
        <div class="form-group col-md-6"  style="margin-left: 20px;">
    <label for="purchaseDetailsVendorName">Upload Photo<span class="requiredIcon text-center">*</span></label>
    <input type="file" id="itemimage" accept=".jpg, .jpeg" required style="height: 40px; color:blue; font-style: bold; font-size: 18px;"  
      name="itemimage" class="form-control   text-center">
 </div>
          
                 <div class="form-group col-md-2" style="margin-left: 20px;">
						  <label for="purchaseDetailsPurchaseDate">Update Data<span class="text-center"></span></label>
                          <button name="submit" id="savebtn" style="height: 40px;" type="submit" class="form-control btn-primary">Update </button>
                 </div>
                        <div class="form-group col-md-2" style="margin-left: 20px;">
						  <label for="purchaseDetailsPurchaseDate">Close <span class="text-center"></span></label>
                          <button onclick="closeModal()" name="submit" id="closebtn" style="height: 40px;" type="submit" class="form-control btn btn-danger">Close</button>
              
                        </div>
    </div>  
        </form>
  

    </div>
</div>


 
 
<input type="hidden" class="input" value="<?php echo $company_id; ?>" id="companyId" />
              <input type="hidden" class="input" value=0 id="mc1_id" />
              <input type="hidden" class="input" id="record_id" />
              <input type="hidden" class="input" id="stockqty" />
              
              <input type="hidden" class="input" id="maxqty" />
              <input type="hidden" class="input" id="pooutqty" />
              <input type="hidden" class="input" id="indoutqty" />
 

              <div id="imageContainer"></div>         
 

            </form>
       
             
    <table id="spgdailyrecordTable" >
        <thead>
            <tr>
               <th>Item Id</th>
               <th >Group Code</th>
                <th>ItemCode </th>
                <th>Item Code </th>
                <th>Item Desc</th>
                <th>UOM</th>
                <th>Stock Qty</th>
                <th>Min Qty</th>
                <th>Max Qty</th>
                <th>Re Order Qty</th>
                <th>Location</th>
                <th>source</th>
                <th>Outstanding PO Qty</th>
                <th>Outstanding Ind Qty</th>
              
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

$("#spgdailyDate").datepicker({ 
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

                $('#spgdailyDate').datepicker('setDate', 'today');

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
             var itemdesc=$('#itemdesc').val();
             var location=$('#location').val();
             var stock=$('#location').val();

            table = $('#spgdailyrecordTable').DataTable({
                ajax: {
                    url: '<?php echo base_url('admin/reports/item_master_report/get_itemdatarecords'); ?>',
                    type: 'POST',
                    data: function(d) {
                        d.companyId=$('#companyId').val();
                        d.groupcode=$('#groupcode').val();
                        d.itemcode=$('#itemcode').val();
                        d.itemdesc=$('#itemdesc').val();
                        d.location=$('#location').val();
                        d.stock=$('#stock').val();
                    }
                  },
                      columnDefs: [
                    { targets: [0,1,2], visible: false }, // Hide the first column (auto_id)
                    { targets: [11], visible: false },
                    { targets: [0], "className": "no-wrap" },
                    { "width": "50px", "targets": [0, 3], "className": "no-wrap" }, // Set the width and apply the no-wrap class to the first and third columns
                    { targets: [6,7,8,9,10,12,13], className: "text-center" }, 
   
                  {
                    targets: [4],
                    render: function (data, type, row) {
                      // Customize the column rendering here
                    return '<td><a href="#" class="itemDetailsHover" data-toggle="popover" id="' + row[3] + '">' + row[4] + '</a></td>';
                },
            },
  
                ],
 
                order: [[1, 'asc']],   
                scrollCollapse: true,
                scrollX: true,
                scroller: true,  
                autoWidth: false,    
                // Sort by the first column (auto_id) in descending order
                pageLength: 10 // Set the default number of rows per page to 25
              });
        }
   



        function refreshDataTable() {
          table.ajax.reload(null, false); // Reload the data without resetting the current page
        }



            $('#groupcode, #itemcode,#itemdesc,#location,#stock').on('change', function() {
               
                refreshDataTable();
            });

 
  
// Lazy load images when hovering
    $(document).on('mouseover', '.itemDetailsHover', function() {
        // Get the DataTable row corresponding to the clicked element
        var dataTable = $('#spgdailyrecordTable').DataTable();
        var row = dataTable.row($(this).closest('tr'));

        // Get the data for the specific columns (e.g., col 0, 3, 4, 6, 7, 8, 9, 10, and 11)
        var itemid = row.data()[0];
        var itemcd = row.data()[3];
        var itemds = row.data()[4];
        var stkqt = row.data()[6];
        var mnqt = row.data()[7];
        var mxqt = row.data()[8];
        var mnrqt = row.data()[9];
        var loca = row.data()[10];
        var colimg = row.data()[11]; // Assuming colimg is the 11th column

        // Create item details popover boxes with a function to fetch data
        $(this).popover({
        container: 'body',
        title: 'Item Details',
        trigger: 'hover',
        html: true,
        placement: 'right',
        content: function () {
            return fetchData(itemid, itemcd, itemds, stkqt, mnqt, mxqt, mnrqt, loca, colimg);
        },
        template: '<div class="popover" style="max-width: 400px; width: 400px; background-color: #add8e6;">' +
                      '<div class="arrow"></div>' +
                      '<h3 class="popover-header"></h3>' +
                      '<div class="popover-body"></div>' +
                  '</div>'
    });
    });
    
    function fetchData(itemid, itemcd, itemds, stkqt, mnqt, mxqt, mnrqt, loca, colimg) {
        var fetch_data = '';
        var mc1_id = $('#mc1_id').val();
        mc1_id = mc1_id + 1;
        $('#mc1_id').val(mc1_id);
        
        // You can use the passed variables in your AJAX request data
        $.ajax({
            url: '<?php echo base_url('admin/reports/item_master_report/get_itemdataimg'); ?>',
            method: 'POST',
            async: false,
            data: {
                itemid: itemid,
                itemds: itemds,
                itemcd: itemcd,
                stkqt: stkqt,
                mnqt: mnqt,
                mxqt: mxqt,
                mnrqt: mnrqt,
                loca: loca,
                colimg: colimg,
                mc1_id: mc1_id,
            },
            success: function (data) {
                fetch_data = data;
            }
        });
        // alert(fetch_data);
        return fetch_data;
    }
 
/*
    $("#savebtn").click(function(event){
          event.preventDefault(); 

          var uitemcode= $('#uitemcode').val();
          var ulocation= $('#ulocation').val();
          var itemimage= $('#itemimage').val();
          var companyId=$('#companyId').val();

          alert(itemimage);
         alert(ulocation);

          $.ajax({
            url: "<?php echo base_url('admin/reports/Item_master_report/save_itemdata'); ?>",
            type: "POST",
            data: {uitemcode: uitemcode,ulocation: ulocation,itemimage: itemimage,companyId: companyId
            },
            dataType: "json",
            success: function(response) {
              var savedata=(response.savedata);
                 alert(savedata);    
             
                

                if (response.success) {
                    alert('Record Added Successfully');
              }
            }
        });

    });
  


  $("#savebtn").click(function(event){
    event.preventDefault(); 

    var uitemcode = $('#uitemcode').val();
    var ulocation = $('#ulocation').val();
    var companyId = $('#companyId').val();
    var itemimage= $('#itemimage').val();
    var formData = new FormData(); // Create a FormData object to send the file

    // Append the file to FormData object
    var fileInput = $('#itemimage')[0].files[0];
    formData.append('itemimage', fileInput);

    // Append other form data
    formData.append('uitemcode', uitemcode);
    formData.append('ulocation', ulocation);
    formData.append('companyId', companyId);

    // Make AJAX request
    $.ajax({
        url: "<?php echo base_url('admin/reports/Item_master_report/save_itemdata'); ?>",
        type: "POST",
        data: formData,
        dataType: "json",
        contentType: false, // Prevent jQuery from setting the Content-Type
        processData: false, // Prevent jQuery from processing the data
        success: function(response) {
            var savedata = response.savedata;
            alert(savedata);    

            if (response.success) {
                alert('Record Added Successfully');
            }
        }
    });
});

*/   
/*
$("#savebtn").click(function(event){
    event.preventDefault(); 

    var uitemcode = $('#uitemcode').val();
    var ulocation = $('#ulocation').val();
    var companyId = $('#companyId').val();
    var fileInput = $('#itemimage')[0].files[0];
    var formData = new FormData(); // Create a FormData object to send the file
    alert('aaa111');

    // Append the file to FormData object
    formData.append('itemimage', fileInput);
    alert('aaa222');

    // Append other form data
    formData.append('uitemcode', uitemcode);
    formData.append('ulocation', ulocation);
    formData.append('companyId', companyId);
    formData.append('itemimage', itemimage);
    
    alert('aaa333');
    // Append filename to FormData object
    alert(fileInput);
    formData.append('filename', fileInput.name);

alert('aaa');
    // Make AJAX request
    $.ajax({
        url: "<?php echo base_url('admin/reports/Item_master_report/save_itemdata'); ?>",
        type: "POST",
        data: formData,
        dataType: "json",
        contentType: false, // Prevent jQuery from setting the Content-Type
        processData: false, // Prevent jQuery from processing the data
        success: function(response) {
            var savedata = response.savedata;
            alert(savedata);    

            if (response.success) {
                alert('Record Added Successfully');
                refreshDataTable();
           
            }
        }
    });
});
*/

$("#savebtn").click(function(event){
    event.preventDefault(); 

    var uitemcode = $('#uitemcode').val();
    var ulocation = $('#ulocation').val();
    var companyId = $('#companyId').val();
    var fileInput = $('#itemimage')[0].files[0];
    var formData = new FormData(); // Create a FormData object to send the file
    var fileChosen = (fileInput) ? 1 : 0; // Check if file is chosen

    // Append the file to FormData object if a file is selected
    if (fileInput) {
        formData.append('itemimage', fileInput);
    } else {
        // If no file is chosen, provide a default filename
        formData.append('itemimage', new Blob(), 'default_filename.jpg');
    }

    // Append other form data
    formData.append('uitemcode', uitemcode);
    formData.append('ulocation', ulocation);
    formData.append('companyId', companyId);
    
    // Append flag indicating if a file was chosen
    formData.append('fileChosen', fileChosen);

    // Make AJAX request
    $.ajax({
        url: "<?php echo base_url('admin/reports/Item_master_report/save_itemdata'); ?>",
        type: "POST",
        data: formData,
        dataType: "json",
        contentType: false, // Prevent jQuery from setting the Content-Type
        processData: false, // Prevent jQuery from processing the data
        success: function(response) {
            var savedata = response.savedata;
            alert(savedata);    

            if (response.success) {
                alert('Record Added Successfully');
            }
        }
    });
});




    $('#spgdailyrecordTable tbody').on('click', 'tr', function () {
        var dataTable = $('#spgdailyrecordTable').DataTable();
        var row = dataTable.row($(this).closest('tr'));

        // Get the data for the specific columns (e.g., col 0, 3, 4, 6, 7, 8, 9, 10, and 11)
        var itemid = row.data()[0];
        var itemcd = row.data()[3];
        var itemds = row.data()[4];
        var stkqt = 'Stock Qty = '+row.data()[6];
        var mnqt = 'Min Qty = '+row.data()[7];
        var mxqt = 'Max Qty = '+row.data()[8];
        var mnrqt = 'Reorder Qty = '+row.data()[9];
        var opoqty = 'O/S PO Qty = '+row.data()[12];
        var oindqty = 'O/S Indent Qty = '+row.data()[13];
        var loca = row.data()[10];
        var colimg = row.data()[11]; // Assuming colimg is the 11th column
      //  alert(itemcd);
        $('#uitemdesc').val(itemds);
        $('#uitemcode').val(itemcd);
        $('#ulocation').val(loca);
        $('#stockqty').val(stkqt);
        $('#minqt').val(mnqt);
        $('#maxqt').val(mxqt);
        $('#mnrqt').val(mnrqt);
        $('#opoqty').val(opoqty);
        $('#oindqty').val(oindqty);
           
        displayImage(colimg); 
        fetchMonthlyChartDataWithImage();
        openModal();

    });



function openModal() {
        document.getElementById('myModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('myModal').style.display = 'none';
    }

    function previewImage(input) {
        var preview = document.getElementById('imagePreview');
        var file = input.files[0];
        var reader = new FileReader();

        reader.onloadend = function () {
            preview.src = reader.result;
            preview.style.display = 'block';
        };

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = '';
            preview.style.display = 'none';
        }
    }

   // $('#uitemcode').on('input', function() {
        $('#uitemcode').blur(function () {
          var uitemcode =  $('#uitemcode').val();
          var ulocation =  $('#ulocation').val();
          var companyId=$('#companyId').val();
//          alert(companyId);
 //         alert(uitemcode);
        $.ajax({
            url: "<?php echo base_url('admin/reports/Item_master_report/get_itemquality'); ?>",
            type: "POST",
            data: {uitemcode: uitemcode,ulocation: ulocation,companyId: companyId },
            dataType: "json",
            success: function(response) {
              if (response.success) {
                    $('#uitemdesc').val(response.name);
                    $('#ulocation').val(response.location);
                    
                          }
                                    }
        });
 
      });

      function displayImage(imageUrl) {
        var imageContainer = document.getElementById('imageContainer');
        var imageElement = document.createElement('img');
        imageElement.src = imageUrl;
        imageElement.style.maxWidth = '300%';
        imageElement.style.maxHeight = '800px';

        // Clear existing content in the image container
        imageContainer.innerHTML = '';

        // Append the new image to the container
        imageContainer.appendChild(imageElement);
    }

    var ctx = document.getElementById('monthlyChart').getContext('2d');
    var monthlyChart;

    // Fetch initial data when the page loads
    document.addEventListener('DOMContentLoaded', function () {
        fetchMonthlyChartDataWithImage();
    });

    function fetchMonthlyChartDataWithImage() {
        var uitemcode =  $('#uitemcode').val();
        fetch('<?= site_url('admin/reports/Item_master_report/getMonthlyChartDataWithImage') ?>?itemcode=' + uitemcode)
        .then(response => response.json())
        .then(data => {
            drawMonthlyChart(data.labels, data.data);
        })
        .catch(error => console.error('Error fetching data:', error));
}

    function drawMonthlyChart(labels, data) {
        if (monthlyChart) {
            monthlyChart.destroy(); // Destroy the existing chart instance
        }
        monthlyChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Monthly Consumptions for last 12 months',
                    data: data,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }


</script>



</body>
</html>
