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



#spgdailyrecordTable {
        border-collapse: collapse;
        width: 100%;
    }

    #spgdailyrecordTable th,
    #spgdailyrecordTable td {
        border: 1px solid #ddd;
    /*    padding: 8px; */
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


 
.dataTables_scroll
{
    overflow:auto;
}

</style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
          <h3 class="m-1 text-dark text-center" style="background-color: #1589FF;"><strong>Spinning Daily Entry</strong></h3>

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
						  <label for="purchaseDetailsPurchaseDate">Entry Date<span class="text-center">*</span></label>
						  <input type="text" style="height: 50px; color:blue; font-style: bold; font-size: 28px;"
                            class="form-control datepicker text-center" id="spgdailyDate" 
                            name="spgdailyDate"   readonly >
						</div>
						<div class="form-group col-md-2">
            <label for="purchaseDetailsPurchaseDate">From Date<span class="text-center">*</span></label>
						  <input type="text" style="height: 50px; color:blue; font-style: bold; font-size: 28px;"
                            class="form-control datepicker text-center" id="spgfdailyDate" 
                            name="spgfdailyDate"   readonly >
						</div>

            <div class="form-group col-md-1"  style="margin-left: 20px;">
							<label for="purchaseDetailsVendorName">Hrs A<span class="requiredIcon text-center">*</span></label>
							<input type="text" id="spgdailyahrs" style="height: 50px; color:blue; font-style: bold; font-size: 28px;" value=8.00
                              name="spgdailyahrs" class="form-control   text-center">
        

						  </div>
              <div class="form-group col-md-1"  style="margin-left: 20px;">
							<label for="purchaseDetailsVendorName">Hrs B<span class="requiredIcon text-center">*</span></label>
							<input type="text" id="spgdailybhrs" style="height: 50px; color:blue; font-style: bold; font-size: 28px;" value=8.00
                              name="spgdailybhrs" class="form-control   text-center">
        

						  </div>
    
              <div class="form-group col-md-1"  style="margin-left: 20px;">
							<label for="purchaseDetailsVendorName">Hrs C<span class="requiredIcon text-center">*</span></label>
							<input type="text" id="spgdailychrs" style="height: 50px; color:blue; font-style: bold; font-size: 28px;" value=7.5
                              name="spgdailychrs" class="form-control   text-center">
        

						  </div>
              
              <div class="form-group col-md-1" style="margin-left: 0px;">
						    <label for="purchaseDetailsPurchaseDate">Export Data<span class="text-center"></span></label>
                <button name="submit" id="expspgdata" style="height: 50px;" type="submit" class="form-control btn btn-primary">Export Data</button>
            </div>
            <div class="form-group col-md-1" style="margin-left: 0px;">
						    <label for="purchaseDetailsPurchaseDate">Excel Report<span class="text-center"></span></label>
                <button name="submit" id="exlspgreport" style="height: 50px;" type="submit" class="form-control btn btn-primary">Excel</button>
            </div>


 
                </div>
                <div class="form-row">
                <div class="form-group col-md-1" style="margin-left: 0px;" >
        			<label for="purchaseDetailsVendorName">Q Code<span class="requiredIcon text-center">*</span></label>
							<input type="text" id="spgquality_id" style="height: 50px; color:blue; font-style: bold; font-size: 28px;" value=''
                              name="spgquality_id" readonly class="form-control read  text-center">

            </div>
                <div class="form-group col-md-3" style="margin-left: 0px;" >
        			<label for="purchaseDetailsVendorName">Quality<span class="requiredIcon text-center">*</span></label>
							<input type="text" id="spgquality" style="height: 50px; color:blue; font-style: bold; font-size: 28px;" value=''
                              name="spgquality" readonly class="form-control read  text-center">

            </div>
 
            <div class="form-group col-md-1"  style="margin-left: 0px;">
							<label for="purchaseDetailsVendorName">Std Count<span class="requiredIcon text-center">*</span></label>
							<input type="text" id="spgstdcount" style="height: 50px; color:blue; font-style: bold; font-size: 28px;" value=''
                              name="spgstdcount" readonly class="form-control   text-center">
						  </div>
              <div class="form-group col-md-1"  style="margin-left: 0px;">
							<label for="purchaseDetailsVendorName">Speed<span class="requiredIcon text-center">*</span></label>
							<input type="text" id="spgspeed" style="height: 50px; color:blue; font-style: bold; font-size: 28px;" value=''
                              name="spgspeed" readonly class="form-control   text-center">
        

						  </div>
              <div class="form-group col-md-1"  style="margin-left: 0px;">
							<label for="purchaseDetailsVendorName">TPI<span class="requiredIcon text-center">*</span></label>
							<input type="text" id="spgtpi" style="height: 50px; color:blue; font-style: bold; font-size: 28px;" value=''
              name="spgtpi" readonly class="form-control   text-center">
						  </div>
              <div class="form-group col-md-1"  style="margin-left: 0px;">
							<label for="purchaseDetailsVendorName">Frame Type<span class="requiredIcon text-center">*</span></label>
							<input type="text" id="spgfrmtype" style="height: 50px; color:blue; font-style: bold; font-size: 28px;" value=''
              readonly       name="spgfrmtype" class="form-control   text-center">
						  </div>
              <div class="form-group col-md-1"  style="margin-left: 0px;">
							<label for="purchaseDetailsVendorName">No of Spindle<span class="requiredIcon text-center">*</span></label>
							<input type="text" id="spgspindle" style="height: 50px; color:blue; font-style: bold; font-size: 28px;" value=''
              readonly            name="spgspindle" class="form-control   text-center">
						  </div>
              <div class="form-group col-md-1"  style="margin-left: 0px;">
  							<label for="purchaseDetailsVendorName">JBO/RBO<span class="requiredIcon text-center">*</span></label>
	  						<input type="text" id="spgjborbo" style="height: 50px; color:blue; font-style: bold; font-size: 28px;" value=''
                readonly name="spgjborbo" class="form-control   text-center">
						  </div>

              <div class="form-group col-md-1"  style="margin-left: 20px;">
  							<label for="purchaseDetailsVendorName">Actual Count<span class="requiredIcon text-center">*</span></label>
	  						<input type="text" id="spgactcount" style="height: 50px; color:blue; font-style: bold; font-size: 28px;" value=0.00
                 name="spgactcount" class="form-control   text-center">
						  </div>

                </div>

                <div class="form-row">
                <div class="form-group col-md-1"  style="margin-left: 0px;">
    							<label for="purchaseDetailsVendorName">No of Winder<span class="requiredIcon text-center">*</span></label>
		    					<input type="text" id="spgnowinder" style="height: 50px; color:blue; font-style: bold; font-size: 28px;" value='0'
                  name="spgnowinder" class="form-control   text-center">
						  </div>
              <div class="form-group col-md-1"  style="margin-left: 20px;">
    							<label for="purchaseDetailsVendorName">Frames (A)<span class="requiredIcon text-center">*</span></label>
		    					<input type="text" id="spgnofrma" style="height: 50px; color:blue; font-style: bold; font-size: 28px;" value='0'
                  name="spgnofrma" class="form-control   text-center">
						  </div>
              <div class="form-group col-md-1"  style="margin-left: 20px;">
    							<label for="purchaseDetailsVendorName">Frames (B)<span class="requiredIcon text-center">*</span></label>
		    					<input type="text" id="spgnofrmb" style="height: 50px; color:blue; font-style: bold; font-size: 28px;" value='0'
                  name="spgnofrmb" class="form-control   text-center">
						  </div>
              <div class="form-group col-md-1"  style="margin-left: 20px;">
    							<label for="purchaseDetailsVendorName">Frames (C)<span class="requiredIcon text-center">*</span></label>
		    					<input type="text" id="spgnofrmc" style="height: 50px; color:blue; font-style: bold; font-size: 28px;" value='0'
                  name="spgnofrmc" class="form-control   text-center">
						  </div>
              <div class="form-group col-md-1"  style="margin-left: 20px;">
    							<label for="purchaseDetailsVendorName">Total Frames<span class="requiredIcon text-center">*</span></label>
		    					<input type="text" id="spgnofrmtot" style="height: 50px; color:blue; font-style: bold; font-size: 28px;" value='0'
                  name="spgnofrmc" class="form-control   text-center">
						  </div>
              <div class="form-group col-md-1"  style="margin-left: 20px;">
    							<label for="purchaseDetailsVendorName">Production(A)<span class="requiredIcon text-center">*</span></label>
		    					<input type="text" id="spgproda" style="height: 50px; color:blue; font-style: bold; font-size: 28px;" value='0'
                  name="spgproda" class="form-control   text-center">
						  </div>
              <div class="form-group col-md-1"  style="margin-left: 20px;">
    							<label for="purchaseDetailsVendorName">Production(B)<span class="requiredIcon text-center">*</span></label>
		    					<input type="text" id="spgprodb" style="height: 50px; color:blue; font-style: bold; font-size: 28px;" value='0'
                  name="spgprodb" class="form-control   text-center">
						  </div>
              <div class="form-group col-md-1"  style="margin-left: 20px;">
    							<label for="purchaseDetailsVendorName">Production(C)<span class="requiredIcon text-center">*</span></label>
		    					<input type="text" id="spgprodc" style="height: 50px; color:blue; font-style: bold; font-size: 28px;" value='0'
                  name="spgprodc" class="form-control   text-center">
						  </div>
              <div class="form-group col-md-1"  style="margin-left: 20px;">
    							<label for="purchaseDetailsVendorName">Total<span class="requiredIcon text-center">*</span></label>
		    					<input type="text" id="spgprodtot" style="height: 50px; color:blue; font-style: bold; font-size: 28px;" value='0'
                  name="spgprodtot" class="form-control   text-center">
						  </div>


              <div class="form-group col-md-1" style="margin-left: 0px;">
						  <label for="purchaseDetailsPurchaseDate">Save Data<span class="text-center"></span></label>
              <button name="submit" id="savespgentry" style="height: 50px;" type="submit" class="form-control btn btn-primary">Save Data</button>
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
 
              


			
      
      

 
        

         
            

         


            </form>
       
            <h1>Winding Quality  List</h1>
    <table id="spgdailyrecordTable" class="display">
        <thead>
            <tr>
            <th >Date</th>
                 <th>Q Code </th>
                <th>Quality</th>
                <th>Speed</th>
                <th>TPI</th>
                <th>Act Count</th>
                <th>No of Winders</th>
                <th>Frames A</th>
                <th>Frames B</th>
                <th>Frames C</th>
                <th>Total Frames</th>
                <th>Hours A</th>
                <th>Hours B</th>
                <th>Hours C</th>
                <th>Total Hours</th>
                <th>Prod  A</th>
                <th>Prod B</th>
                <th>Prod C</th>
                <th>Total Prod</th>
                <th>Target Prod</th>
                <th>Target Avg Prod/Frame</th>
                <th>Eff(%)</th>
                <th>Prod/Frame</th>
                <th>Prod/Winder</th>
                <th>JBO/RBO</th>
                <th>Frame Type</th>
                <th>No of Spindle</th>
                <th>Std Count</th>
                

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

$("#spgfdailyDate").datepicker({ 
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

                $('#spgfdailyDate').datepicker('setDate', 'today');


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
          var spgactcount=     $('#spgactcount').val();                
          var spgdailyahrs=     $('#spgdailyahrs').val();                
          var spgdailybhrs=     $('#spgdailybhrs').val();                
          var spgdailychrs=     $('#spgdailychrs').val();                
          var spgnowinder=     $('#spgnowinder').val();                
          var spgnofrma=     $('#spgnofrma').val();                
          var spgnofrmb=     $('#spgnofrmb').val();                
          var spgnofrmc=     $('#spgnofrmc').val();                
          var spgnofrmtot=     $('#spgnofrmtot').val();                
          var spgproda=     $('#spgproda').val();                
          var spgprodb=     $('#spgprodb').val();                
          var spgprodc=     $('#spgprodc').val();                
          var spgprodtot=     $('#spgprodtot').val();         
          var spgspeed=     $('#spgspeed').val();         
          var spgtpi=     $('#spgtpi').val();         
          var spgspindle=     $('#spgspindle').val();         
//alert(spgprodc);
          if (length.spgquality_id==0) {
            alert("Please Select any Record !");
		      	return false;
          }  
          if (spgnofrmtot<=0) {
            alert("Please Enter No of frames !");
      			$('#spgnofrma').focus().css("border-color", "red");
		      	return false;
          }          
          if (spgprodtot<=0) {
            alert("Please Enter Production !");
      			$('#spgnofrma').focus().css("border-color", "red");
		      	return false;
          }          
          if (spgnowinder<=0) {
            alert("Please Enter Production !");
      			$('#spgnofrma').focus().css("border-color", "red");
		      	return false;
          }          
          $.ajax({
           url: "<?php echo base_url('admin/doffdata/savespgdaily_data'); ?>",
           
            type: "POST",
            data: {spgdailyDate: spgdailyDate,spgquality_id: spgquality_id,companyId: companyId,
            spgactcount: spgactcount,spgdailyahrs: spgdailyahrs,spgdailybhrs: spgdailybhrs,spgdailychrs: spgdailychrs,
            spgnowinder: spgnowinder, spgnofrma: spgnofrma,spgnofrmb: spgnofrmb,spgnofrmc: spgnofrmc,spgproda: spgproda,
            spgprodb: spgprodb,spgprodc: spgprodc,spgspeed: spgspeed,spgspindle: spgspindle,spgtpi: spgtpi
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
                  refreshDataTable();
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

      initDataTable();
      function initDataTable() {
             var spgdailyDate= $('#spgdailyDate').val();
             var companyId=$('#companyId').val();
//             alert(spgdailyDate);
jQuery('.dataTable').wrap('<div class="dataTables_scroll" />');
            table = $('#spgdailyrecordTable').DataTable({
                ajax: {
                    url: '<?php echo base_url('admin/doffdata/get_spgdailydatarecords'); ?>',
                    type: 'POST',
                    data: function(d) {
                        d.date = $('#spgdailyDate').val();
                        d.companyId=$('#companyId').val();
                    }
                  },
/*
                  columns: [
            { "width": "20%", "className": "no-wrap" }, // Set the width and apply the no-wrap class to the first column
            null,               // Let DataTables determine the width for the second column
            null                // Let DataTables determine the width for the third column
        ],
*/
                  columnDefs: [
                    { targets: [0], visible: true }, // Hide the first column (auto_id)
                    { targets: [3], visible: true },
                    { targets: [0], "className": "no-wrap" },
                    { "width": "50px", "targets": [0, 2], "className": "no-wrap" }, // Set the width and apply the no-wrap class to the first and third columns
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
                order: [[1, 'asc']],   
                scrollCollapse: true,
                scrollX: true,
                scroller: true,  
              // Sort by the first column (auto_id) in descending order
                pageLength: 10 // Set the default number of rows per page to 25
              });
        }
 


        function refreshDataTable() {
          table.ajax.reload(null, false); // Reload the data without resetting the current page
        }


        $('#spgdailyrecordTable tbody').on('click', 'tr', function() {
                var rowData = table.row(this).data();
                $('#spgquality_id').val(rowData[1]);
                $('#spgquality').val(rowData[2]);
                $('#spgspeed').val(rowData[3]);
                $('#spgtpi').val(rowData[4]);
                $('#spgfrmtype').val(rowData[25]);
                $('#spgspindle').val(rowData[26]);                
                $('#spgjborbo').val(rowData[24]);                
                $('#spgactcount').val(rowData[5]);                
                $('#spgdailyahrs').val(rowData[11]);                
                $('#spgdailybhrs').val(rowData[12]);                
                $('#spgdailychrs').val(rowData[13]);                
                $('#spgnowinder').val(rowData[6]);                
                $('#spgnofrma').val(rowData[7]);                
                $('#spgnofrmb').val(rowData[8]);                
                $('#spgnofrmc').val(rowData[9]);                
                $('#spgnofrmtot').val(rowData[10]);                
                $('#spgproda').val(rowData[15]);                
                $('#spgprodb').val(rowData[16]);                
                $('#spgprodc').val(rowData[17]);                
                $('#spgprodtot').val(rowData[18]);                
                $('#spgstdcount').val(rowData[27]);                
                       });
        
            $('#recordTable tbody').on('click', 'tr', function() {
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                } else {
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                }
            });


            $('#spgdailyDate, #qcshiftName').on('change', function() {
               
                refreshDataTable();
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


  $("#expspgdata").click(function(event){
  event.preventDefault(); 
	alert ("aaaa");
	var opt=3;
  var spgdailyDate= $('#spgdailyDate').val();
             var companyId=$('#companyId').val();
      
            var url = '<?php echo site_url("admin/doffdata/exportspgdailydata"); ?>' +
                      '?spgdailyDate=' + spgdailyDate +
                      '&companyId=' + companyId 
                      ;
                      alert(url);
			//$(location).attr('href',url);
			window.open( url, '_blank');
			
			
return false;
});



$("#exlspgreport").click(function(event){
  event.preventDefault(); 
//	alert ("aaaa");
	var opt=3;
  var spgdailyDate= $('#spgdailyDate').val();
  var spgfdailyDate= $('#spgfdailyDate').val();
             var companyId=$('#companyId').val();
      
            var url = '<?php echo site_url("admin/doffdata/exlspgreport"); ?>' +
                      '?spgdailyDate=' + spgdailyDate +
                      '&spgfdailyDate=' + spgfdailyDate+
                      '&companyId=' + companyId 
                      ;
  //                    alert(url);
			//$(location).attr('href',url);
			window.open( url, '_blank');
			
			
return false;
});


$('#spgnofrma').on('input', function() {
          var spgnofrma =  $('#spgnofrma').val();
          var spgnofrma=parseFloat(spgnofrma);
          var spgnofrmb =  $('#spgnofrmb').val();
          var spgnofrmb=parseFloat(spgnofrmb);
          var spgnofrmc =  $('#spgnofrmc').val();
          var spgnofrmc=parseFloat(spgnofrmc);
          totfrm=(spgnofrma+spgnofrmb+spgnofrmc);
          var totfrm=parseFloat(totfrm);
          $('#spgnofrmtot').val(totfrm);
 
      
      });


      $('#spgnofrmb').on('input', function() {
//        $('#spgnofrma').on('input', function();

        var spgnofrma =  $('#spgnofrma').val();
          var spgnofrma=parseFloat(spgnofrma);
          var spgnofrmb =  $('#spgnofrmb').val();
          var spgnofrmb=parseFloat(spgnofrmb);
          var spgnofrmc =  $('#spgnofrmc').val();
          var spgnofrmc=parseFloat(spgnofrmc);
          totfrm=(spgnofrma+spgnofrmb+spgnofrmc);
          var totfrm=parseFloat(totfrm);
          $('#spgnofrmtot').val(totfrm);

      
      });

      $('#spgnofrmc').on('input', function() {
        var spgnofrma =  $('#spgnofrma').val();
          var spgnofrma=parseFloat(spgnofrma);
          var spgnofrmb =  $('#spgnofrmb').val();
          var spgnofrmb=parseFloat(spgnofrmb);
          var spgnofrmc =  $('#spgnofrmc').val();
          var spgnofrmc=parseFloat(spgnofrmc);
          totfrm=(spgnofrma+spgnofrmb+spgnofrmc);
          var totfrm=parseFloat(totfrm);
          $('#spgnofrmtot').val(totfrm);
      });

      $('#spgproda').on('input', function() {
        var spgproda =  $('#spgproda').val();
          var spgproda=parseFloat(spgproda);
          var spgprodb =  $('#spgprodb').val();
          var spgprodb=parseFloat(spgprodb);
          var spgprodc =  $('#spgprodc').val();
          var spgprodc=parseFloat(spgprodc);
          totprd=(spgproda+spgprodb+spgprodc);
          var totprd=parseFloat(totprd);
          $('#spgprodtot').val(totprd);
      });

      $('#spgprodb').on('input', function() {
        var spgproda =  $('#spgproda').val();
          var spgproda=parseFloat(spgproda);
          var spgprodb =  $('#spgprodb').val();
          var spgprodb=parseFloat(spgprodb);
          var spgprodc =  $('#spgprodc').val();
          var spgprodc=parseFloat(spgprodc);
          totprd=(spgproda+spgprodb+spgprodc);
          var totprd=parseFloat(totprd);
          $('#spgprodtot').val(totprd);
      });
  
      $('#spgprodc').on('input', function() {
        var spgproda =  $('#spgproda').val();
          var spgproda=parseFloat(spgproda);
          var spgprodb =  $('#spgprodb').val();
          var spgprodb=parseFloat(spgprodb);
          var spgprodc =  $('#spgprodc').val();
          var spgprodc=parseFloat(spgprodc);
          totprd=(spgproda+spgprodb+spgprodc);
          var totprd=parseFloat(totprd);
          $('#spgprodtot').val(totprd);
      });

      


</script>



</body>
</html>
