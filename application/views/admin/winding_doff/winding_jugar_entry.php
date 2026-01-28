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



#jrecordTable {
        border-collapse: collapse;
        width: 100%;
    }

    #jrecordTable th,
    #jrecordTable td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #jrecordTable th {
        background-color: #f2f2f2;
    }

    #jrecordTable tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    #jrecordTable tr:hover {
        background-color: #ddd;
    }

    .selected {
        background-color: yellow;
    }
    #jrecordTable td.column-align-center {
        text-align: center;
    }

    #jrecordTable td.column-align-right {
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
          <h3 class="m-1 text-dark text-center" style="background-color: #1589FF;"><strong>Winding Jugar Entry</strong></h3>

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
               class="form-control datepicker text-center" id="windingjugarDate" 
              name="windingjugarDate"   readonly >
						</div>
            <div class="form-group col-md-1"  style="margin-left: 20px;">
							<label for="purchaseDetailsVendorName">Spell<span class="requiredIcon text-center">*</span></label>
							<select id="jugarshiftName" style="height: 50px; color:blue; font-style: bold; font-size: 28px;"
              name="jugarshiftName" class="form-control chosenSelect  text-center">
              echo "<option value='A1' > A1</option>";
              echo "<option value='B1' > B1</option>";
              echo "<option value='A2' > A2</option>";
              echo "<option value='B2' > B2</option>";
              echo "<option value='C' > C</option>";
							</select>
						  </div>
              <div class="form-group col-md-2"  style="margin-left: 0px;">
							<label for="purchaseDetailsVendorName">Opening/Closing<span class="requiredIcon text-center">*</span></label>
							<select id="openclose" style="height: 50px; color:blue; font-style: bold; font-size: 20px;"
              name="openclose" class="form-control chosenSelect  text-center">
              echo "<option value='O' > Opening</option>";
              echo "<option value='C' > Closing </option>";
							</select>
						  </div>
          
           <div class="form-group col-md-2" style="margin-left: 20px;" >
							<label for="purchaseDetailsVendorName">MC NO <span class="requiredIcon text-center">*</span></label>
              <select class="form-group form-control select2" id="jugmc_no1" style=" font-size: 20px; height: 50px; ">
              echo "<option value=0 > Select.... </option>";
              <?php
                foreach ($data['wndmcdata'] as $each){	 
                   echo "<option value=".$each['mechine_id'].">".$each['mechine_name']."</option>"
                ?>
                <?php }  ?>
							</select>
            </div>
           <div class="form-group col-sm-1" style="margin-left: 20px;">
                    <label >Jugar </label>
                    <input type="text" name="jugarwt" id="jugarwt" value="" 
                    style="height: 50px; color:blue; font-style: bold; font-size: 28px;"
                    class="form-control text-center ">
           </div>
           
           <div class="form-group col-md-2" style="margin-left: 0px;">
						  <label for="purchaseDetailsPurchaseDate">Save Data<span class="text-center"></span></label>
              <button name="submit" id="savejugdoff" style="height: 50px;" type="submit" class="form-control btn btn-primary">Save</button>
              <button name="submit" id="updatejugdoff" style="height: 50px;" type="submit" class="form-control btn btn-primary">Update Data</button>
          
            </div>

<?php
                  $company_id = $this->session->userdata('company_id');
                //  echo $company_id;
              ?>
 
<input type="hidden" class="input" value="<?php echo $company_id; ?>" id="companyId" />
              <input type="hidden" class="input" id="mc1_id" />
              <input type="hidden" class="input" id="mc2_id" />
              <input type="hidden" class="input" id="mc3_id" />
              <input type="hidden" class="input" id="trollyid" />
              <input type="hidden" class="input" id="record_id" />

             
					  </div>
			
						<div class="form-group col-md-2">
                
            </div>      
  
            
            <div class="form-row">

            <div class="form-group col-md-2" id="dateContainer">
            <label for="purchaseDetailsPurchaseDate">Date<span class="text-center">*</span></label>
            <input type="text" style="height: 50px; color: blue; font-style: bold; font-size: 28px;"
                class="form-control datepicker text-center" id="windingprvjugarDate"
                name="windingprvjugarDate" readonly>
        </div>
        <div class="form-group col-md-1" id="spellContainer" style="margin-left: 20px;">
            <label for="purchaseDetailsVendorName">Spell<span class="requiredIcon text-center">*</span></label>
            <select id="jugarprvshiftName" style="height: 50px; color: blue; font-style: bold; font-size: 28px;"
                name="jugarprvshiftName" class="form-control chosenSelect text-center">
                <option value='A1'>A1</option>
                <option value='B1'>B1</option>
                <option value='A2'>A2</option>
                <option value='B2'>B2</option>
                <option value='C'>C</option>
            </select>
        </div>
           </div> 


            </form>
       
            <h1>Jugar Record List</h1>
            <table id="jrecordTable">
        <thead>
            <tr>
                <th>Record ID</th>
                <th>Doff Date</th>
                <th>Spell</th>
                <th>Mc No</th>
                <th>Open Close</th>
                <th>Weight</th>
                <th>Wnd mc id</th>
             
                
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

$("#windingjugarDate").datepicker({ 
  dateFormat: 'dd-mm-yy',
					todayHighlight:'TRUE',
					autoclose: true,
          maxDate: '0',     });
                $("#windingprvjugarDate").datepicker({ 
          dateFormat: 'dd-mm-yy',
					todayHighlight:'TRUE',
					autoclose: true,
                });

                $("#payrollenddate").datepicker({ 
                  dateFormat: 'dd-mm-yy',
					todayHighlight:'TRUE',
					autoclose: true,
                });

                $('#windingjugarDate').datepicker('setDate', 'today');
                $('#windingprvjugarDate').datepicker('setDate', 'today');

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

$("#savejugdoff").attr('disabled',true);

$("#jugmc_no1").attr('disabled',false);
 
$('#savejugdoff').show();
$('#updatejugdoff').hide();
$('#record_id').val('0');

 
 
</script>

<script>
        $(document).ready(function() {
            $('input[type="text"]').on('focus', function() {
                $(this).select();
            });

 $('#mcno5').blur(function () {
   // do whatever
   alert('mcno1');
   $('#grosswt').focus();

  });

  $('#mc_no1').on('change', function() {
          var mcno1 =  $('#mc_no1').val();
          var windingjugarDate= $('#windingjugarDate').val();
          var companyId=$('#companyId').val();
          var jugarshiftName=$('#jugarshiftName').val();
          var openclose=$('#openclose').val();
          var record_id=$('#record_id').val();
         alert(mcno1);
          $.ajax({
            url: "<?php echo base_url('admin/Winding_doff_data/mcno1_jugardata'); ?>",
            type: "POST",
            data: {mcno1: mcno1,companyId: companyId,windingjugarDate: windingjugarDate,jugarshiftName: jugarshiftName,openclose:openclose },
            dataType: "json",
            success: function(response) {
              if (response.success) {
                $("#jugarwt").attr('disabled',false);
                $('#jugarwt').val(response.jweight);
                alert (response.jugarwt);
                $('#mc_no1').css({'border-color': 'green','background-color': 'white'
                    });
               } else {
                if (record_id==0) {
                $("#jugarwt").attr('disabled',true);
                $('#jugarwt').val(response.jweight);
                $('#mc_no1').css({'border-color': 'red','background-color': 'yellow'
                    });
                $("#savejugdoff").attr('disabled',true);
                alerta('Jugar  Already Enter for This Mechine');
               $('#mc_no1').focus();
                  }
               if (record_id>0) {
                  $("#jugarwt").attr('disabled',false);
                  $("#savejugdoff").attr('disabled',false);
               }     

              }
            }  
            });
 
              });



    $('#jugarwt').on('input', function() {
          var companyId=$('#companyId').val();
          var jugarwt =$('#jugarwt').val();
          var jugarwt=parseFloat(jugarwt);
        //  alert(jugarwt);
          if ((jugarwt>0) && (jugarwt<100)  )  {
        //    alert(jugarwt);
            $("#savejugdoff").attr('disabled',false);
                     $('#jugarwt').css({'border-color': 'green','background-color': 'white'
                     });
          }  else {
                var wta=0;
             $('#jugarwt').css({'border-color': 'red','background-color': 'yellow'
                    });
                    $("#savejugdoff").attr('disabled',true);


          } 

      
      });


       
 
        });

//start save
        $("#savejugdoff").click(function(event){
          event.preventDefault(); 
          var mcno1 =  $('#jugmc_no1').val();
          var windingjugarDate= $('#windingjugarDate').val();
          var companyId=$('#companyId').val();
          var jugarshiftName=$('#jugarshiftName').val();
          var openclose=$('#openclose').val();
          var jugarwt =$('#jugarwt').val();
           if (mcno1==0) {
            alert('Please Enter Mc No');
            $('#mc_no1').focus().css("border-color", "red");
      			return false;
          }
            if ((jugarwt==0) || (jugarwt>100)) {
            alert('Please Enter Valid Jugar Weight');
            $('#jugarwt').focus().css("border-color", "red");
      			return false;
          }
 
  //       alert(mcno1);

          $.ajax({
            url: "<?php echo base_url('admin/Winding_doff_data/savejugdoff_data'); ?>",
            type: "POST",
            data: {mcno1: mcno1,companyId: companyId,windingjugarDate: windingjugarDate,jugarshiftName: jugarshiftName,
              openclose:openclose,jugarwt:jugarwt },
           dataType: "json",
            success: function(response) {
              var savedata=(response.savedata);
          //       alert(savedata);    
                $('#jugarwt').val(0);
                 $("#jugmc_no1").val(0);
                 $("#jugmc_no1").trigger('change');
                  if (response.success) {
                  alert('Record Added Successfully');
                  refreshDataTable();
                  $('#record_id').val('0');  
                  }
            }
        });
 
      });

      $("#updatejugdoff").click(function(event){
          event.preventDefault();
//          alert('update'); 
          var record_id = $('#record_id').val();
  //        alert(record_id);
          var mcno1 =  $('#jugmc_no1').val();
          var windingjugarDate= $('#windingjugarDate').val();
          var companyId=$('#companyId').val();
          var jugarshiftName=$('#jugarshiftName').val();
          var openclose=$('#openclose').val();
          var jugarwt =$('#jugarwt').val();
           if (mcno1==0) {
            alert('Please Enter Mc No');
            $('#mc_no1').focus().css("border-color", "red");
      			return false;
          }
            if ((jugarwt==0) || (jugarwt>100)) {
            alert('Please Enter Valid Jugar Weight');
            $('#jugarwt').focus().css("border-color", "red");
      			return false;
          }
 
    //     alert(record_id);

          $.ajax({
            url: "<?php echo base_url('admin/Winding_doff_data/updatejugdoff_data'); ?>",
            type: "POST",
            data: {mcno1: mcno1,companyId: companyId,windingjugarDate: windingjugarDate,jugarshiftName: jugarshiftName,
              openclose:openclose,jugarwt:jugarwt,record_id: record_id },
           dataType: "json",
            success: function(response) {
              var savedata=(response.savedata);
          //       alert(savedata);    
                $('#jugarwt').val(0);
                 $("#jugmc_no1").val(0);
                 $("#jugmc_no1").trigger('change');
           if (response.success) {
                  alert('Record updated Successfully');
                  refreshDataTable();
                  $('#record_id').val('0');  
                  }
            }
        });
 
      });




    
      initDataTable();
      function initDataTable() {
//alert('ll');
            table = $('#jrecordTable').DataTable({
                ajax: {
                    url: '<?php echo base_url('admin/Winding_doff_data/get_jugarrecords'); ?>',
                    type: 'POST',
                    data: function(d) {
                        d.date = $('#windingjugarDate').val();
                        d.shift = $('#jugarshiftName').val();
                        d.companyId=$('#companyId').val();
                        d.mcno =  $('#mc_no1').val();
                        d.openclose =  $('#openclose').val();
                    }
                  },columnDefs: [
                    { targets: [0], visible: false }, // Hide the first column (auto_id)
                    { targets: [6], visible: false }, // Hide the first column (auto_id)
                 ],
                drawCallback: function() {
                // Apply alignment styles to the table cells
                $('#recordTable td.column-align-center').css('text-align', 'center');
                $('#recordTable td.column-align-right').css('text-align', 'right');
            },
                order: [[0, 'desc']],                 // Sort by the first column (auto_id) in descending order
                pageLength: 10 // Set the default number of rows per page to 25
              });
        }



        function refreshDataTable() {
          table.ajax.reload(null, false); // Reload the data without resetting the current page
        }


        $('#jrecordTable tbody').on('click', 'tr', function() {
                var rowData = table.row(this).data();
                $('#record_id').val(rowData[0]);
            //    $('#date').val(rowData[1]);
           //     $('#shift').val(rowData[2]);
         //       $('#mc_no1').select2(rowData[6]);
          //      $("#splcd").select2(ft) ;
          $("#jugmc_no1").val(rowData[6]).trigger("change");

                $('#jugarwt').val(rowData[5]);
                $('#savejugdoff').hide();
                $('#updatejugdoff').show();
            });
        
            $('#jrecordTable tbody').on('click', 'tr', function() {
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                } else {
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                }
            });


            $('#windingjugarDate, #jugarshiftName,#openclose').on('change', function() {
    //            alert('oo');
              $('#jugarwt').val('');
              
                refreshDataTable();
            });

/*
            function toggleFields() {
            var opencloseSelect = document.getElementById("openclose");
            var dateField = document.getElementById("windingprvjugarDate");
            var spellSelect = document.getElementById("jugarprvshiftName");

            if (opencloseSelect.value === "O") {
                dateField.style.display = "block";  // Show the Date field
                spellSelect.style.display = "block"; // Show the Spell field
            } else {
                dateField.style.display = "none";   // Hide the Date field
                spellSelect.style.display = "none"; // Hide the Spell field
            }
        }

        // Add an event listener to the "Opening/Closing" select element
        document.getElementById("openclose").addEventListener("change", toggleFields);

        // Call toggleFields initially to set the initial visibility
        toggleFields();
*/

      function toggleFields() {
            var opencloseSelect = document.getElementById("openclose");
            var dateContainer = document.getElementById("dateContainer");
            var spellContainer = document.getElementById("spellContainer");

            if (opencloseSelect.value === "O") {
                dateContainer.style.display = "block";  // Show the Date field
                spellContainer.style.display = "block"; // Show the Spell field
            } else {
                dateContainer.style.display = "none";   // Hide the Date field
                spellContainer.style.display = "none";  // Hide the Spell field
            }
        }

        // Add an event listener to the "Opening/Closing" select element
        document.getElementById("openclose").addEventListener("change", toggleFields);

        // Call toggleFields initially to set the initial visibility
        toggleFields();


        $('#jugmc_no1').on('change', function() {
          var mcno1 =  $('#jugmc_no1').val();
          var windingDate= $('#windingprvjugarDate').val();
          var windingcDate= $('#windingjugarDate').val();
          var companyId=$('#companyId').val();
          var shiftname=$('#jugarprvshiftName').val();
          var openclose=$('#openclose').val();
          var shiftcname=$('#jugarshiftName').val();
          $.ajax({
            url: "<?php echo base_url('admin/Winding_doff_data/jugmcno1_data'); ?>",
            type: "POST",
            data: {mcno1: mcno1,companyId: companyId,windingDate: windingDate,shiftname: shiftname,openclose: openclose,windingcDate:windingcDate,
              shiftcname: shiftcname },
            dataType: "json",
            success: function(response) {
              if (response.success) {
                alert(response.autoid);
                if (response.autoid>0) {  
                  $('#jugarwt').val(response.weight);
                  $('#record_id').val(response.autoid);
                  $("#savejugdoff").attr('disabled',false);
                  $('#savejugdoff').hide();
                  $('#updatejugdoff').show();
                } else {
                  $('#jugarwt').val(response.weight);
                  $('#record_id').val(0);
                  $("#savejugdoff").attr('disabled',false);
                  $('#savejugdoff').show();
                  $('#updatejugdoff').hide();
                }  


                } else {
                  $('#jugarwt').val(response.weight);
                  $("#savejugdoff").attr('disabled',true);
              }
            }  
            });

 
 


        });









</script>



</body>
</html>
