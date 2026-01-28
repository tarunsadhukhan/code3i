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

/* Define the color for the delete icon */


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
.delete-icon {
    color: red;
}

/* CSS for the confirmation dialog */
.confirmation-dialog {
    background-color: #fff; /* Background color of the dialog box */
    border: 2px solid #333; /* Border color of the dialog box */
    padding: 20px; /* Padding inside the dialog box */
    text-align: center;
}

/* CSS for the "Yes" button */
.btn-yes {
    background-color: #FF0000; /* Red background color for "Yes" button */
    color: #FFF; /* Text color for "Yes" button */
    padding: 10px 20px; /* Padding for the button */
    border: none; /* Remove button border */
    cursor: pointer;
}

/* CSS for the "No" button */
.btn-no {
    background-color: #333; /* Background color for "No" button */
    color: #FFF; /* Text color for "No" button */
    padding: 10px 20px; /* Padding for the button */
    border: none; /* Remove button border */
    cursor: pointer;
}

    </style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
          <h3 class="m-1 text-dark text-center" style="background-color: #1589FF;"><strong>Winding Doff Entry</strong></h3>

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
						  <label for="purchaseDetailsPurchaseDate">Date<span class="text-center">*</span></label>
						  <input type="text" style="height: 50px; color:blue; font-style: bold; font-size: 28px;"
               class="form-control datepicker text-center" id="windingDate" 
              name="windingDate"   readonly >
						</div>
			
            <div class="form-group col-md-3" style="margin-left: 50px;">
						  <label for="purchaseDetailsPurchaseDate">Record Time<span class="requiredIcon text-center">*</span></label>
						  <input type="text" 
              style="height: 50px; color:blue; font-style: bold; font-size: 28px;" 
              class="form-control  text-center" id="rec_time" name="payrolltime" value="0"  readonly >
						</div>
 

            <div class="form-group col-md-3"  style="margin-left: 50px;">
							<label for="purchaseDetailsVendorName">Spell<span class="requiredIcon text-center">*</span></label>
							<select id="shiftName" style="height: 50px; color:blue; font-style: bold; font-size: 28px;"
              name="shiftName" class="form-control chosenSelect  text-center">
        

              echo "<option value='A1' > A1</option>";
              echo "<option value='B1' > B1</option>";
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
              <input type="hidden" class="input" id="mc1_id" />
              <input type="hidden" class="input" id="mc2_id" />
              <input type="hidden" class="input" id="mc3_id" />
              <input type="hidden" class="input" id="trollyid" />
             
					  </div>
			
      
      

        <div class="row">
        <div class="form-group col-md-1"  style="margin-left: 0px;">
							<label for="purchaseDetailsVendorName">No of Mcs<span class="requiredIcon text-center">*</span></label>
							<select id="nomcs" style="height: 50px; color:blue; font-style: bold; font-size: 28px;"
              name="nomcs" class="form-control chosenSelect  text-center">
              echo "<option value=1 > 1</option>";
              echo "<option value=2 > 2 </option>";
              echo "<option value=3 > 3</option>";
              
							</select>
						  </div>
           <div class="form-group col-md-2" style="margin-left: 20px;" >
							<label for="purchaseDetailsVendorName">MC NO 1<span class="requiredIcon text-center">*</span></label>
              <select class="form-group form-control select2" id="mc_no1" style=" font-size: 28px; height: 50px; ">
              echo "<option value=0 > Select.... </option>";
            <?php
                foreach ($data['wndmcdata'] as $each){	 
                   echo "<option value=".$each['mechine_id'].">".$each['mechine_name']."</option>"
                ?>
                <?php }  ?>
							</select>
            </div>
            <div class="form-group col-md-2" style="margin-left: 20px;" >
							<label for="purchaseDetailsVendorName">MC NO 2<span class="requiredIcon text-center">*</span></label>
              <select class="form-group form-control select2" id="mc_no2" style=" font-size: 28px; height: 50px; ">
              echo "<option value=0 > Select.... </option>";
            <?php
                foreach ($data['wndmcdata'] as $each){	 
                   echo "<option value=".$each['mechine_id'].">".$each['mechine_name']."</option>"
                ?>
                <?php }  ?>
							</select>
            </div>
            <div class="form-group col-md-2" style="margin-left: 20px;" >
							<label for="purchaseDetailsVendorName">MC NO 3<span class="requiredIcon text-center">*</span></label>
              <select class="form-group form-control select2" id="mc_no3" style=" font-size: 28px; height: 50px; ">
              echo "<option value=0 > Select.... </option>";
            <?php
                foreach ($data['wndmcdata'] as $each){	 
                   echo "<option value=".$each['mechine_id'].">".$each['mechine_name']."</option>"
                ?>
                <?php }  ?>
							</select>
            </div>
               <div class="form-group col-sm-1" style="margin-left: 20px;">
                    <label >Trolly No </label>
                    <input type="text" name="trollyNo" id="trollyNo" value="" 
                    style="height: 50px; color:blue; font-style: bold; font-size: 28px;"
                    class="form-control text-center ">
           </div> 
           <div class="form-group col-sm-1" style="margin-left: 20px;">
                    <label >Trolly Wt </label>
                    <input type="text" name="trollywt" id="trollywt" value="" 
                    style="height: 50px; color:blue; font-style: bold; font-size: 28px;"
                    class="form-control text-center ">
           </div>
           
           <div class="form-group col-sm-1" style="margin-left: 20px;">
                    <label >EB No </label>
                    <input type="text" name="ebno" id="ebno" value="" 
                    style="height: 50px; color:blue; font-style: bold; font-size: 28px;"
                    class="form-control text-center ">
           </div>
           
        
           </div> 

        

           <div class="row">
           <div class="form-group col-md-2" style="margin-left: 0px;" >
							<label for="purchaseDetailsVendorName">Spool Code<span class="requiredIcon text-center">*</span></label>
              <select class="form-group form-control select2" id="spoolcode" style=" font-size: 28px; height: 50px; ">
              echo "<option value=0 > Select.... </option>";
          
            <?php
                foreach ($datas['spooldata'] as $each){	 
                   echo "<option value=".$each['trollyid'].">".$each['trolly_details']."</option>"
                ?>
                <?php }  ?>
							</select>
            </div>
              <div class="form-group col-sm-1" style="margin-left: 0px;">
                    <label >Spool Wt </label>
                    <input type="text" name="spoolwt" id="spoolwt" value="" 
                    style="height: 50px; color:blue; font-style: bold; font-size: 28px;"
                    class="form-control text-center ">
           </div> 

           <div class="form-group col-md-2" style="margin-left: 0px;" >
							<label for="purchaseDetailsVendorName">Quality<span class="requiredIcon text-center">*</span></label>
              <select class="form-group form-control select2" id="quality_id" style=" font-size: 28px; height: 50px; ">
              echo "<option value=0 > Select.... </option>";
                <?php
                foreach ($dataq['qualitydata'] as $each){	 
                  echo "<option value=".$each['wnd_quality_id'].">".$each['QUALITY']."</option>"
                ?>
                <?php }  ?>
							</select>
            </div>
              <div class="form-group col-sm-1"  style="margin-left: 0px;">
                    <label >Gross Weight </label>
                    <input type="text" name="grosswt" id="grosswt" value="" 
                    style="height: 50px; color:blue; font-style: bold; font-size: 28px;"
                    class="form-control text-center ">
           </div> 
           <div class="form-group col-sm-1"  style="margin-left: 0px;">
                    <label >Mc 1 Net Wt </label>
                    <input type="text" name="mc1netwt" id="mc1netwt" value="" 
                    style="height: 50px; color:blue; font-style: bold; font-size: 28px;"
                    class="form-control text-center ">
           </div> 
           <div class="form-group col-sm-1"  style="margin-left: 0px;">
           <label >Mc 2  Net Wt </label>
                    <input type="text" name="mc2netwt" id="mc2netwt" value="" 
                    style="height: 50px; color:blue; font-style: bold; font-size: 28px;"
                    class="form-control text-center ">
           </div> 
           <div class="form-group col-sm-1"  style="margin-left: 0px;">
           <label >Mc 3  Net Wt </label>
                    <input type="text" name="mc3netwt" id="mc3netwt" value="" 
                    style="height: 50px; color:blue; font-style: bold; font-size: 28px;"
                    class="form-control text-center ">
           </div> 

           <div class="form-group col-md-2" style="margin-left: 0px;">
						  <label for="purchaseDetailsPurchaseDate">Save Data<span class="text-center"></span></label>
              <button name="submit" id="savewnddoff" style="height: 50px;" type="submit" class="form-control btn btn-primary">Save</button>
            
            </div>


        </div> 
         
            

         


            </form>
       
            <h1>Record List</h1>
    <table id="recordTable">
        <thead>
            <tr>
                <th>Record ID</th>
                <th>Doff Date</th>
                <th>Spell</th>
                <th>Mc No</th>
                <th>Gross Weight</th>
                <th>Trolly No</th>
                <th>Trolly Weight</th>
                <th>Spool Type</th>
                <th>Spool Weight</th>
                <th>Net Weight</th>
                <th>Entry Time</th>
                <th>Delete</th>
                
                
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

$("#windingDate").datepicker({ 
  dateFormat: 'dd-mm-yy',
					todayHighlight:'TRUE',
					autoclose: true,
          maxDate: '0',        });
                $("#payrollenddate").datepicker({ 
                  dateFormat: 'dd-mm-yy',
					todayHighlight:'TRUE',
					autoclose: true,
                });

                $('#windingDate').datepicker('setDate', 'today');

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
    $('#windingDate').datepicker('setDate', 'today-1');
        
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

$("#savewnddoff").attr('disabled',true);

$("#mc_no1").attr('disabled',false);
$("#mc_no2").attr('disabled',true);
$("#mc_no3").attr('disabled',true);

$("#ebno").attr('disabled',true);
$("#trollywt").attr('disabled',true);
$("#spoolwt").attr('disabled',true);
$("#mc1netwt").attr('disabled',true);
$("#mc2netwt").attr('disabled',true);
$("#mc3netwt").attr('disabled',true);


$('#nomcs').focus();
$('#nomcs').select();

 
</script>

<script>
        $(document).ready(function() {
            $('input[type="text"]').on('focus', function() {
                $(this).select();
            });

            $('#nomcs').on('change', function() {
                var no_mc=$("#nomcs").val();
             //   alert(no_mc);
                if ( (no_mc==0) || (no_mc>3) ) {
                    alert ("Please Enter between 1-3");
                    $('#nomcs').val(1);
                    $('#nomcs').focus();
                }
                $("#mc_no1").attr('disabled',false);
                $("#mc_no2").attr('disabled',true);
                $("#mc_no3").attr('disabled',true);
            
                if  (no_mc==2)   {
                  $("#mc_no2").attr('disabled',false);
                  $("#mc_no3").attr('disabled',true);
                }      
                if  (no_mc==3)   {
                  $("#mc_no2").attr('disabled',false);
                  $("#mc_no3").attr('disabled',false);
                }      

            });

$('#mcno5').blur(function () {
   alert('mcno1');
   $('#grosswt').focus();
  });

  $('#mc_no1').on('change', function() {
          var mcno1 =  $('#mc_no1').val();
          var windingDate= $('#windingDate').val();
          var companyId=$('#companyId').val();
          $.ajax({
            url: "<?php echo base_url('admin/Winding_doff_data/mcno1_data'); ?>",
            type: "POST",
            data: {mcno1: mcno1,companyId: companyId,windingDate: windingDate },
            dataType: "json",
            success: function(response) {
              if (response.success) {
                $('#trollywt').val(response.trollyWt);
                $('#spoolwt').val(response.spoolwt);
                $('#trollyNo').val(response.trollyno);
                $("#spoolcode").val(response.spool_id);
                $("#mc1_id").val(response.mcid);
                $("#spoolcode").trigger('change');
                $("#quality_id").val(response.qualityid);
                $("#quality_id").trigger('change');
                $('#trollyid').val(response.trolly_id);
                $('#mc_no1').css({'border-color': 'green','background-color': 'white'
                    });
               } else {
                $('#trollywt').val(response.trollyWt);
                $('#spoolwt').val(response.spoolwt);
                $('#trollyNo').val(response.trollyno);
                $("#spoolcode").val(response.spool_id);
                $("#spoolcode").trigger('change');
                $("#quality_id").val(response.qualityid);
                $("#quality_id").trigger('change');
                $('#mc_no1').css({'border-color': 'red','background-color': 'yellow'
                    });
                $("#savewnddoff").attr('disabled',true);
                $('#mc_no1').focus();
                

              }
            }  
            });
 
              });


              $('#mc_no2').on('change', function() {
          var mcno1 =  $('#mc_no1').val();
          var mcno2 =  $('#mc_no2').val();
          var windingDate= $('#windingDate').val();
          var companyId=$('#companyId').val();

          $.ajax({
            url: "<?php echo base_url('admin/Winding_doff_data/mcno2_data'); ?>",
            type: "POST",
            data: {mcno2: mcno2,companyId: companyId,windingDate: windingDate },
            dataType: "json",
            success: function(response) {
              if (response.success) {
                $("#mc2_id").val(response.mcid);

             //   $("#savewnddoff").attr('disabled',false);
                $('#mc_no2').css({'border-color': 'green','background-color': 'white'
                    });
              
               } else {
                $('#mc_no2').css({'border-color': 'red','background-color': 'yellow'
                    });
                $("#savewnddoff").attr('disabled',true);
                $('#mc_no2').focus();
                

              }
            }  
            });
 
              });

              $('#mc_no3').on('change', function() {
           var mcno2 =  $('#mc_no3').val();
          var windingDate= $('#windingDate').val();
          var companyId=$('#companyId').val();
          $.ajax({
            url: "<?php echo base_url('admin/Winding_doff_data/mcno2_data'); ?>",
            type: "POST",
            data: {mcno2: mcno2,companyId: companyId,windingDate: windingDate },
            dataType: "json",
            success: function(response) {
              if (response.success) {
                $("#mc3_id").val(response.mcid);
              //  $("#savewnddoff").attr('disabled',false);
                $('#mc_no3').css({'border-color': 'green','background-color': 'white'
                    });
              
               } else {
                $('#mc_no3').css({'border-color': 'red','background-color': 'yellow'
                    });
                $("#savewnddoff").attr('disabled',true);
                $('#mc_no3').focus();
                

              }
            }  
            });
 
              });

              $('#trollyNo').blur(function () {
                var trollyNo =  $('#trollyNo').val();
              var companyId=$('#companyId').val();
          $.ajax({
            url: "<?php echo base_url('admin/Winding_doff_data/trolly_data'); ?>",
            type: "POST",
            data: {trollyNo: trollyNo,companyId: companyId },
            dataType: "json",
            success: function(response) {
              if (response.success) {

             //   $("#savewnddoff").attr('disabled',false);
                $('#trollyNo').css({'border-color': 'green','background-color': 'white'
                    });
                  $('#trollyid').val(response.trollyid);
                    $('#trollywt').val(response.trollyWt);
                    $('#grosswt').val(0);
                    $('#mc1netwt').val(0);
                    $('#mc2netwt').val(0);
                    $('#mc3netwt').val(0);
              
               } else {
                $('#trollyNo').css({'border-color': 'red','background-color': 'yellow'
                    });
                $("#savewnddoff").attr('disabled',true);
                 $('#trollywt').val(response.trollyWt);
                $('#trollyNo').focus();
                $('#grosswt').val(0);
                    $('#mc1netwt').val(0);
                    $('#mc2netwt').val(0);
                    $('#mc3netwt').val(0);
                

              }
            }  
            });
 
              });



              $('#spoolcode').on('change', function() {
              var spoolcode =  $('#spoolcode').val();
              var companyId=$('#companyId').val();
            $.ajax({
            url: "<?php echo base_url('admin/Winding_doff_data/spool_data'); ?>",
            type: "POST",
            data: {spoolcode: spoolcode,companyId: companyId },
            dataType: "json",
            success: function(response) {
              if (response.success) {

                    $('#spoolwt').val(response.spoolwt);
                    $('#grosswt').val(0);
                    $('#mc1netwt').val(0);
                    $('#mc2netwt').val(0);
                    $('#mc3netwt').val(0);
              
               } else {
                $("#savewnddoff").attr('disabled',true);
                $('#grosswt').val(0);
                    $('#mc1netwt').val(0);
                    $('#mc2netwt').val(0);
                    $('#mc3netwt').val(0);
              }
            }  
            });
 
              });



  
   

    $('#grosswt').on('input', function() {
           var companyId=$('#companyId').val();
          var grosswt =$('#grosswt').val();
          var grosswt=parseFloat(grosswt);
          var trollywt= $('#trollywt').val();
          var trollywt=parseFloat(trollywt);
          var spoolwt= $('#spoolwt').val();
          var splwt=parseFloat(spoolwt);
          var nomcs= $('#nomcs').val();
          var nomc=parseFloat(nomcs);
          var netwt=grosswt-trollywt-(nomc*spoolwt);
           if (netwt>0 ) {
              var trlw=(trollywt/nomc).toFixed(2);
              var prdw=(grosswt/nomc).toFixed(2); 
              
              var wt=0;
              var wt1=0;
              var wt2=0;
              var wta=0;

              wt=prdw-trlw-splwt;
              wt1=prdw-trlw-splwt;
              wt2=prdw-trlw-splwt;

              wt=Math.round(wt);
              wt1=Math.round(wt1);
              wt2=Math.round(wt2);
              if (nomc==1) {
                $("#mc1netwt").val(wt);
                $("#mc2netwt").val(wta);
                $("#mc3netwt").val(wta);
                
              }
              if (nomc==2) {
                $("#mc1netwt").val(wt);
                $("#mc2netwt").val(wt1);
                $("#mc3netwt").val(wta);
                
              }

              if (nomc==3) {

                $("#mc1netwt").val(wt);
                $("#mc2netwt").val(wt1);
                $("#mc3netwt").val(wt2);
              }  

              $("#savewnddoff").attr('disabled',false);
                     $('#grosswt').css({'border-color': 'green','background-color': 'white'
                     });
          }  else {
                var wta=0;
                $("#mc1netwt").val(wta);
                $("#mc2netwt").val(wta);
                $("#mc3netwt").val(wta);
             $('#grosswt').css({'border-color': 'red','background-color': 'yellow'
                    });
                    $("#savewnddoff").attr('disabled',true);

          } 

      
      });


      $('#doffNo').prop('disabled', true);
      $('#netWt').prop('disabled', true);
      $('#tnetWt').prop('disabled', true);
      $('#tareWt').prop('disabled', true);
      
 
        });

//start save
        $("#savewnddoff").click(function(event){
          event.preventDefault(); 
          var companyId=$('#companyId').val();
          var nomcs =  $('#nomcs').val();
          var windingDate= $('#windingDate').val();
          var rec_time= $('#rec_time').val();
          var shiftName= $('#shiftName').val();
          var trollyNo= $('#trollyNo').val();
          var trollywt= $('#trollywt').val();
          var trollyid= $('#trollyid').val();
          var mcno1= $('#mc_no1').val();
          var mcno2= $('#mc_no2').val();
          var mcno3= $('#mc_no3').val();
          var spoolcode= $('#spoolcode').val();
          var spoolwt= $('#spoolwt').val();
          var quality_id= $('#quality_id').val();
          var grosswt= $('#grosswt').val();
          var mc1netwt= $('#mc1netwt').val();
          var mc2netwt= $('#mc2netwt').val();
          var mc3netwt= $('#mc3netwt').val();
          if ((trollyNo.length)==0 ) {
            alert('Please Enter Trolly No');
            $('#trollyNo').focus().css("border-color", "red");
      			return false;
          }
          if ((trollyid)==0 ) {
            alert('Please Enter Trolly No');
            $('#trollyNo').focus().css("border-color", "red");
      			return false;
          }
          if (mcno1==0) {
            alert('Please Enter Mc No');
            $('#mc_no1').focus().css("border-color", "red");
      			return false;
          }
          if ((nomcs==2) && (mcno2==0)) {
            alert('Please Select 2nd  Mc No');
            $('#mc_no2').focus().css("border-color", "red");
      			return false;
      
          } 
          if ((nomcs==3) && (mcno2==0)) {
            alert('Please Select 2nd  Mc No');
            $('#mc_no2').focus().css("border-color", "red");
      			return false;
      
          } 
          if ((nomcs==3) && (mcno3==0)) {
            alert('Please Select 3rd  Mc No');
            $('#mc_no3').focus().css("border-color", "red");
      			return false;
          } 
          if (spoolcode==0) {
            alert('Please Select Spool');
            $('#spoolcode').focus().css("border-color", "red");
      			return false;

          }

          if (quality_id==0) {
            alert('Please Select Quality');
            $('#quality_id').focus().css("border-color", "red");
      			return false;
          }
          if ((grosswt)==0 ) {
            alert('Please Enter Gross Weight');
            $('#grosswt').focus().css("border-color", "red");
      			return false;
          }
          if ( (mc1netwt<1) || (mc1netwt>500)  ) {
            alert('Please Check Weight Weight');
            $('#grosswt').focus().css("border-color", "red");
      			return false;
          }



          $.ajax({
            url: "<?php echo base_url('admin/Winding_doff_data/savewnddoff_data'); ?>",
            type: "POST",
            data: {nomcs: nomcs,windingDate: windingDate,shiftName: shiftName,companyId: companyId,
            rec_time: rec_time,trollyNo: trollyNo,trollywt: trollywt,trollyid: trollyid,mcno1: mcno1,mcno2: mcno2,mcno3: mcno3,
            spoolcode:spoolcode,spoolwt:spoolwt,quality_id:quality_id, grosswt: grosswt,mc1netwt: mc1netwt,
            mc2netwt: mc2netwt,mc3netwt: mc3netwt
            },
            dataType: "json",
            success: function(response) {
              var savedata=(response.savedata);
                $('#mc1netwt').val('');
                $('#mc2netwt').val('');
                $('#mc3netwt').val('');
                $('#trollyNo').val('');
                $('#trollywt').val('');
                $('#grosswt').val('');
                $("#nomcs").val(1);
                $("#nomcs").trigger('change');
                $("#mc_no1").val(0);
                $("#mc_no1").trigger('change');
                $("#mc_no2").val(0);
                $("#mc_no2").trigger('change');
                $("#mc_no3").val(0);
                $("#mc_no3").trigger('change');
                if (response.success) {
                    
                  alert('Record Added Successfully');
                  refreshDataTable();

                  }
            }
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
            url: '<?php echo base_url('admin/Winding_doff_data/get_records'); ?>',
            type: 'POST',
            data: function(d) {
                d.date = $('#windingDate').val();
                d.shift = $('#shiftName').val();
                d.companyId=$('#companyId').val();
                d.mcno =  $('#mc_no1').val();
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
                targets: -1, // The last column
                render: function(data, type, row, meta) {
                  return '<button class="delete-button" data-record-id="' + row[0] + '"><i class="fas fa-trash"></i></button>';
               //   return '<button class="delete-button" data-record-id="' + row[0] + '">Delete</button>';
                }
            }
        ],
        drawCallback: function() {
            // Apply alignment styles to the table cells
            $('#recordTable td.column-align-center').css('text-align', 'center');
            $('#recordTable td.column-align-right').css('text-align', 'right');
        },
        order: [[0, 'desc']], // Sort by the first column (auto_id) in descending order
        pageLength: 5 // Set the default number of rows per page to 25
    });
}

// Handle the click event for the "Delete" button
// Handle the click event for the "Delete" button
$('#recordTable tbody').on('click', 'button.delete-button', function () {
    var recordId = $(this).data('record-id');
    
    // Show a custom confirmation dialog
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
});

 

// Function to delete a record
function deleteRecord(recordId) {
  
  $.ajax({
    url: "<?php echo base_url('admin/Winding_doff_data/deleteRecord'); ?>",
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


            $('#windingDate, #shiftName,#mc_no1').on('change', function() {
               $('#tnetWt').val('');
                $('#mc1netWt').val('');
             
                $('#trollyNo').val('');
                $('#spoolwt').val('');
                $('#trollywt').val('');
                $('#grossWt').val('');
                $('#mc1netwt').val('');
                $('#mc2netwt').val('');
                $('#mc3netwt').val('');
                $('#trollyNo').val('');
                $('#trollywt').val('');
                $('#grosswt').val('');
                $('#mc1netwt').val('');
                $('#mc2netwt').val('');
                $('#mc3netwt').val('');
             
                refreshDataTable();
            });

 






</script>



</body>
</html>
