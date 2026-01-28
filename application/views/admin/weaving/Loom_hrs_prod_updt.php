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
 
.selected td {
background-color: #AED6F1;
 /* color: skyblue; */
  font-weight: bold;
}

#spgdailyrecordTable {
        border-collapse: collapse;
        width: 100%;
    }

    #spgdailyrecordTable th,
    #spgdailyrecordTable td {
        border: 1px solid #ddd;
      
    }

    #spgdailyrecordTable th {
        background-color: #f2f2f2;
    }

    #spgdailyrecordTable tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    #spgdailyrecordTable tr:hover {
        background-color: #ddd;
    }

    .selected {
        background-color: yellow;
    }
    #spgdailyrecordTable td.column-align-center {
        text-align: center;
    }

    #spgdailyrecordTable td.column-align-right {
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

.no-wrap {
    white-space: nowrap;
}
.dataTables thead th.no-wrap,
.dataTables tbody td.no-wrap {
    white-space: nowrap;
}
.dataTables thead th:nth-child(0), /* First column (Date) */
.dataTables tbody td:nth-child(0),
.dataTables thead th:nth-child(2), /* Third column (Quality) */
.dataTables tbody td:nth-child(2) {
    width: auto; /* You can specify the width here, e.g., "100px" */
}
.dataTables thead th.no-wrap {
    white-space: nowrap;
    width: 100px; /* Set the width here, e.g., "100px" for the first column (Date) */
}
.dataTables th.no-wrap,
.dataTables td.no-wrap {
    white-space: nowrap;
    width: 100px; /* Set the common width here, e.g., "100px" for the first column (Date) */
}
</style>
<style>
@keyframes spin { to { transform: rotate(360deg); } }
</style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
          <h3 class="m-1 text-dark text-center" style="background-color: #1589FF;"><strong>Loom Hours/Production Update</strong></h3>

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
						  <input type="text" style="height: 50px; color:blue; font-style: bold; font-size: 20px;"
                            class="form-control datepicker text-center" id="spgdailyDate" 
                            name="spgdailyDate"   readonly >
						</div>

 						<div class="form-group col-md-1">
							<label for="purchaseDetailsVendorName">Spell<span class="requiredIcon text-center">*</span></label>
							<select id="shiftName" style="height: 50px; color:blue; font-style: bold; font-size: 20px;"
              name="shiftName" class="form-control chosenSelect  text-center">
        

              echo "<option value='A1' > A1</option>";
              echo "<option value='B1' > B1</option>";
              echo "<option value='A2' > A2</option>";
              echo "<option value='B2' > B2</option>";
              echo "<option value='C' > C</option>";
							</select>
						  </div>


         
 


           <div class="form-group col-md-2" style="margin-left: 20px;" >
							<label for="purchaseDetailsVendorName">Loom<span class="requiredIcon text-center">*</span></label>
              <select class="form-group form-control select2" id="mc_no1" style=" font-size: 20px; height: 40px; ">
              echo "<option value=0 > Select.... </option>";
            <?php
                foreach ($data['lmmcdata'] as $each){	 
                  echo "<option value=".$each['mechine_id'].">".$each['mech_code']."</option>";
                ?>
                <?php }  ?>
							</select>
            </div>
                <div class="form-group col-md-1" style="margin-left: 0px;" >

                <label for="purchaseDetailsVendorName">Stoppage Hrs<span class="requiredIcon text-center">*</span></label>
							<input type="text" id="mcstop" style="height: 50px; color:blue; font-style: bold; font-size: 20px;" value=''
                              name="mcstop"  class="form-control read  text-center">

            </div>
 
            <div class="form-group col-md-1"  style="margin-left: 0px;">
							<label for="purchaseDetailsVendorName">Less Prod<span class="requiredIcon text-center">*</span></label>
							<input type="text" id="lessprod" style="height: 50px; color:blue; font-style: bold; font-size: 28px;" value=''
                              name="lessprod"  class="form-control   text-center">
						  </div>
  
             <div class="form-group col-md-1" style="margin-left: 0px;">
						  <label for="purchaseDetailsPurchaseDate">Update<span class="text-center"></span></label>
                          <button name="submit" id="updateloomdata" style="height: 50px;" type="submit" class="form-control btn btn-primary">Update</button>
            </div>
            <div class="form-group col-md-1" style="margin-left: 0px;">
						    <label for="purchaseDetailsPurchaseDate">Reset <span class="text-center"></span></label>
                <button name="submit" id="resetloomdata" style="height: 50px;" type="submit" class="form-control btn btn-primary">Reset</button>
            </div>
           <div class="form-group col-md-1" style="margin-left: 0px;">
						    <label for="purchaseDetailsPurchaseDate">Show <span class="text-center"></span></label>
                <button name="submit" id="resetloomdata" style="height: 50px;" type="submit" class="form-control btn btn-primary">Show</button>
            </div>

 
                </div>
               </div>

     

 <?php
                  $company_id = $this->session->userdata('company_id');
                //  echo $company_id;
              ?>
 
              <input type="hidden" class="input" value="<?php echo $company_id; ?>" id="companyId" />
              <input type="hidden" class="input" id="bufferid" />
              <input type="hidden" class="input" id="record_id" />
  

            </form>
       


            
            <h1>Loom Data List</h1>
              <table id="spgdailyrecordTable" class="display">
        <thead>
            <tr>
               <th>cj_buff1_id</th>
               <th >dtl_rec_id</th>
                <th>Date </th>
                <th>Mech Code</th>
                <th>EB No</th>
                <th>Name</th>
                <th>Cuts</th>
                <th>Jugar</th>
                <th>Production</th>
                <th>Efficiency</th>
                <th>Working Hrs</th>
                <th>Mc Stop Hrs</th>
                <th>Less Prod</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
           
       

<div id="dtSpinner" style="
  display:none;
  position:fixed;
  inset:0;
  background:rgba(255,255,255,0.7);
  z-index:9999;
  align-items:center;
  justify-content:center;
">
  <div style="
    width:48px;height:48px;
    border:6px solid #ddd;
    border-top-color:#333;
    border-radius:50%;
    animation:spin 0.8s linear infinite;
  "></div>
</div>


          
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

//start save
        $("#savespgentry").click(function(event){
          event.preventDefault(); 
       
          var companyId=$('#companyId').val();
          var spgdailyDate= $('#spgdailyDate').val();
          var spgquality_id= $('#spgquality_id').val();
          var wvgwidth=     $('#wvgwidth').val();                
          var wvgport=     $('#wvgport').val();                
          var wvgshots=     $('#wvgshots').val();                
          var wvgrs=     $('#wvgrs').val();                
          var wvgozsyds=     $('#wvgozsyds').val();                
          var wvgjborbo=     $('#wvgjborbo').val();                
          var wvgashots=     $('#wvgashots').val();                
          var spgproda=     $('#spgproda').val();                
          var spgprodb=     $('#spgprodb').val();                
          var spgprodc=     $('#spgprodc').val();                
          var wvgfrma=     $('#wvgfrma').val();                
          var wvgfrmb=     $('#wvgfrmb').val();                
          var wvgfrmc=     $('#wvgfrmc').val();                
          var wvgaports=     $('#wvgaports').val();         
          var spgdailyahrs=     $('#spgdailyahrs').val();         
          var spgdailybhrs=     $('#spgdailybhrs').val();         
          var spgdailychrs=     $('#spgdailychrs').val();         
          var spgnofrmtot=     $('#spgnofrmtot').val();         
          var spgprodtot=     $('#spgprodtot').val();         
        

          if (length.spgquality_id==0) {
            alert("Please Select any Record !");
		      	return false;
        

          }  
          if (spgnofrmtot<=0) {
            alert("Please Enter No of Looms !");
      			$('#wvgfrma').focus().css("border-color", "red");
		      	return false;
          }          
          if (spgprodtot<=0) {
            alert("Please Enter Production !");
      			$('#wvgfrma').focus().css("border-color", "red");
		      	return false;
          }          
          if (wvgaports<=0) {
            alert("Please Enter A Ports !");
      			$('#wvgaports').focus().css("border-color", "red");
		      	return false;
          }          
          $.ajax({
           url: "<?php echo base_url('admin/weaving_daily_entry/savespgdaily_data'); ?>",
           
            type: "POST",
            data: {spgdailyDate: spgdailyDate,spgquality_id: spgquality_id,companyId: companyId,
            wvgwidth: wvgwidth,wvgport: wvgport,wvgshots: wvgshots,wvgrs: wvgrs,
            wvgozsyds: wvgozsyds, wvgjborbo: wvgjborbo,wvgashots: wvgashots,spgproda: spgproda,
            spgprodb: spgprodb,spgprodc: spgprodc,wvgfrma: wvgfrma,wvgfrmb: wvgfrmb,wvgfrmc: wvgfrmc,wvgaports:wvgaports,
            spgdailyahrs:spgdailyahrs,spgdailybhrs:spgdailybhrs,spgdailychrs:spgdailychrs
            },
          dataType: "json",
            success: function(response) {
              var savedata=(response.savedata);
              alert('save');
                $("#mc_no1").val(0);
                $("#mc_no1").trigger('change');
                $("#quality_id").val(0);
                $("#quality_id").trigger('change');
                $("#nospool").val(0);
                if (response.success) {
                    
                  alert('Record Added Successfully');
              //    refreshDataTable();
                   $('#spgquality_id').val('');
                   $('#spgquality').val('');
                   
           $('#spgactcount').val(0);                
            $('#spgdailyahrs').val(0);                
            $('#spgdailybhrs').val(0);                
            $('#spgdailychrs').val(0);                
              $('#spgnowinder').val(0);                
            $('#spgnofrma').val(0);                
            $('#spgnofrmb').val(0);                
            $('#spgnofrmc').val(0);                
            $('#spgnofrmtot').val(0);                
             $('#spgproda').val(0);                
            $('#spgprodb').val(0);                
            $('#spgprodc').val(0);                
            $('#spgprodtot').val(0);         
            $('#spgspeed').val(0);         
            $('#spgtpi').val(0);         
           $('#spgspindle').val(0);         

                  }
            }
        });
 
      });

      

let table;


initDataTable();


function initDataTable() {

  // Destroy if already created
  if ($.fn.DataTable.isDataTable('#spgdailyrecordTable')) {
    $('#spgdailyrecordTable').DataTable().clear().destroy();
    $('#spgdailyrecordTable').off('processing.dt'); // remove old handler if any
  }

  table = $('#spgdailyrecordTable').DataTable({
    processing: true,   // needed for processing.dt event
    serverSide: false,  // keep as per your setup (change if you use serverside)

    ajax: {
      url: '<?php echo base_url('admin/Loom_hrs_prod_updt/get_loomhoursprodrecords'); ?>',
      type: 'POST',
      data: function (d) {
        d.date      = $('#spgdailyDate').val();
        d.companyId = $('#companyId').val();
        d.shiftName = $('#shiftName').val();
        d.loomid    = $('#mc_no1').val();
      },
      beforeSend: function () {
        showSpinner();
      },
      complete: function () {
        hideSpinner();
      },
      error: function () {
        hideSpinner();
        alert('Failed to load data');
      }
    },

    select: { style: 'single' },

    columnDefs: [
      { targets: [0], visible: true },
      { targets: [3], visible: true },
      { targets: [2], className: "no-wrap" },
      { width: "100px", targets: [2], className: "no-wrap" },
      {
        targets: [5, 6],
        render: function (data) {
          return '<div class="column-align-right">' + data + '</div>';
        }
      }
    ],

    drawCallback: function () {
      $('#spgdailyrecordTable td.column-align-center').css('text-align', 'center');
      $('#spgdailyrecordTable td.column-align-right').css('text-align', 'right');
    },

    createdRow: function (row, data) {
      const cell4 = parseFloat((data[4] ?? '0').toString().replace(/,/g, '')) || 0;
      const cell1 = parseFloat((data[1] ?? '0').toString().replace(/,/g, '')) || 0;

      if (cell1 === 0) {
        $('td:eq(2)', row).addClass('cell-red');
        $('td:eq(4)', row).addClass('cell-green');
      }
    },

    order: [[1, 'asc']],
    scrollCollapse: true,
    scrollX: true,
    scroller: true,
    pageLength: 10
  });

  // Extra safety: spinner toggles whenever DT is "processing"
  $('#spgdailyrecordTable').on('processing.dt', function (e, settings, processing) {
    if (processing) showSpinner();
    else hideSpinner();
  });
}

        function refreshDataTable() {
 //       $('#spgdailyrecordTable').DataTable().clear().destroy();
//          alert('daata refreshing');
        
              table.ajax.reload(null, false); // Reload the data without resetting the current page
        
        }


        $('#spgdailyrecordTable tbody').on('click', 'tr', function() {
                var rowData = table.row(this).data();
              $('#record_id').val(rowData[1]);
               $('#bufferid').val(rowData[0]);
            $('#mcstop').val(rowData[11]);
          $('#lessprod').val(rowData[12]);
//    alert(rowData[9]);


 //         alert('nnn');                                
                        });
            $('#spgdailyrecordTable tbody').on('click', 'tr', function() {
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                } else {
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                }
            });

            $(document).keydown(function(e) {
            //  if (e.which === 113) { // Check if F2 key is pressed (F2 has key code 113)
});


$('#spgdailyDate, #shiftName, #mc_no1').on('change', function () {

      var spgdailyDate = $('#spgdailyDate').val();
    var shiftName = $('#shiftName').val();
    var mc_no1 = $('#mc_no1').val();
        
        if (mc_no1==0) {                      // no records
            $('#record_id,#bufferid,#mcstop,#lessprod').val('');
            return;
        }
     if (!shiftName) {                      // no records
            $('#record_id,#bufferid,#mcstop,#lessprod').val('');
            return;
        }


    table.ajax.reload(function () {

      var spgdailyDate = $('#spgdailyDate').val();
    var shiftName = $('#shiftName').val();
    var mc_no1 = $('#mc_no1').val();
        
        if (!mc_no1) {                      // no records
            $('#record_id,#bufferid,#mcstop,#lessprod').val('');
            return;
        }
     if (!shiftName) {                      // no records
            $('#record_id,#bufferid,#mcstop,#lessprod').val('');
            return;
        }



        var rowData = table.row(0).data();   // first row

        if (!rowData) {                      // no records
            $('#record_id,#bufferid,#mcstop,#lessprod').val('');
            return;
        }

        $('#record_id').val(rowData[1]);
        $('#bufferid').val(rowData[0]);
        $('#mcstop').val(rowData[11]);
        $('#lessprod').val(rowData[12]);

    }, false);

});

/*
            $('#spgquality_id').on('change', function() {
              var spgquality_id =  $('#spgquality_id').val();
             var spgdailyDate= $('#spgdailyDate').val();
             var companyId=$('#companyId').val();
          $.ajax({
            url: "<?php echo base_url('admin/doffdata/spgquality_data'); ?>",
            type: "POST",
            data: {companyId: companyId,spgdailyDate: spgdailyDate,spgquality_id: spgquality_id },
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


  */     

  $("#resetloomdata").click(function(event){
                $('#bufferid').val(0);
                $('#record_id').val(0);
                $('#mechcode').val(0);
                $('#mcstop').val(0);
                $('#lessprod').val(0);

                refreshDataTable();

});


  $("#expspgdata").click(function(event){
  event.preventDefault(); 
//	alert ("aaaa");
	var opt=3;
  var spgdailyDate= $('#spgdailyDate').val();
             var companyId=$('#companyId').val();
      
            var url = '<?php echo site_url("admin/weaving_daily_entry/exportspgdailydata"); ?>' +
                      '?spgdailyDate=' + spgdailyDate +
                      '&companyId=' + companyId 
                      ;
                      alert(url);
			//$(location).attr('href',url);
			window.open( url, '_blank');
			
			
return false;
});


 
 $("#updateloomdata").click(function(event){
          event.preventDefault(); 
//          showSpinner();
//          $("#expspgrepo").attr('disabled',true);
//alert('update s');
          updatelmqc();
//                refreshDataTable();
 
});


      function updatelmqc() {
         var spgdailyDate = $('#spgdailyDate').val();
            var companyId=$('#companyId').val();
            var bufferid=$('#bufferid').val();
            var record_id=$('#record_id').val();
            var mcstop=$('#mcstop').val();
            var lessprod=$('#lessprod').val();
            var shiftName=$('#shiftName').val();
            var mc_no1=$('#mc_no1').val();
  //          alert(shiftName);

          if (length.shiftName==0) {
            alert("Please Select Shift !");
		      	return ;
        

          }  
     if (mc_no1==0) {
            alert("Please Select Loom !");
		      	return ;
        

          }  


  showSpinner();

             var deferred = $.Deferred();
         //    alert(spgdailyDate);
//         alert(bufferid);
//         alert(record_id)
          var mechcode=$('#mechcode').val();
         $.ajax({
            url: "<?php echo base_url('admin/Loom_hrs_prod_updt/updateloomdata'); ?>",
            type: "POST",
            data: {bufferid: bufferid,record_id: record_id,mcstop: mcstop,lessprod: lessprod,shiftName: shiftName
            },
            dataType: "json",
            success: function(response) {
              var savedata=(response.savedata);
                 if (response.success) {
                    var qcst=response.qcstarttime;
                    var qcend=response.qcendtime;
                    var msg='Loom Updated Successfully '+mechcode ;
                //    alert(msg);
                    refreshDataTable();
                    hideSpinner();
                  $('#mcstop').val(0);
                  $('#lessprod').val(0);
                $("#mc_no1").val(0);
                $("#mc_no1").trigger('change');

                    //   alert('refresh');
//                    updatelmeb();               
                  }
            }
        });

      }  
      function updatelmeb() {
         var spgdailyDate = $('#spgdailyDate').val();
             var companyId=$('#companyId').val();
         //    alert(spgdailyDate);
          $.ajax({
            url: "<?php echo base_url('admin/weaving_daily_entry/updatelmebqc_data'); ?>",
            type: "POST",
            data: {spgdailyDate: spgdailyDate,companyId: companyId
            },
            dataType: "json",
            success: function(response) {
              var savedata=(response.savedata);
//                 alert(savedata);    
                 if (response.success) {
                  var qcst=response.qcstarttime;
                    var qcend=response.qcendtime;
                    var msg='EB & Working Hours Updated Successfully '+qcst+' to '+qcend ;
                    alert(msg);
                    updatelmopen();             }
            }
        });

      }  


      function updatelmopen() {
         var spgdailyDate = $('#spgdailyDate').val();
             var companyId=$('#companyId').val();
         //    alert(spgdailyDate);
          $.ajax({
            url: "<?php echo base_url('admin/weaving_daily_entry/updatelmopen_data'); ?>",
            type: "POST",
            data: {spgdailyDate: spgdailyDate,companyId: companyId
            },
            dataType: "json",
            success: function(response) {
              var savedata=(response.savedata);
                 if (response.success) {
                  var qcst=response.qcstarttime;
                    var qcend=response.qcendtime;
                    var msg='Opening Transfer Updated Successfully '+qcst+' to '+qcend ;
                    alert(msg);
                 $("#expspgrepo").attr('disabled',false);
              }
            }
        });

      }  



  $('#mc_no1').blur(function () {
      var mcshrcd =  $('#mc_no1').val();  
    $('#loomid').val(mcshrcd);                  
    
  })

 

 

function showSpinner() {
  $('#dtSpinner').css('display', 'flex');
}
function hideSpinner() {
  $('#dtSpinner').hide();
}

/*     $('#mc_no1').on('change', function () {
      var mcshrcd =  $('#mc_no1').val();  
        $('#loomid').val(mcshrcd);                  
    //           refreshDataTable();
 
  });
 *//*
  // if edit page and a value is already selected, trigger once:
  $('#mc_no1').trigger('change');
 */
 
</script>



</body>
</html>
