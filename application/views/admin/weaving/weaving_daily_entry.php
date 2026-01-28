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

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
          <h3 class="m-1 text-dark text-center" style="background-color: #1589FF;"><strong>Weaving Daily Entry</strong></h3>

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
                            class="form-control datepicker text-center" id="spgdailyDate" 
                            name="spgdailyDate"   readonly >
						</div>
                        <div class="form-group col-md-2"  style="margin-left: 20px;">
							<label for="purchaseDetailsVendorName">Working Hrs A<span class="requiredIcon text-center">*</span></label>
							<input type="text" id="spgdailyahrs" style="height: 50px; color:blue; font-style: bold; font-size: 28px;" value=8.00
                              name="spgdailyahrs" class="form-control   text-center">
        

						  </div>
              <div class="form-group col-md-2"  style="margin-left: 20px;">
							<label for="purchaseDetailsVendorName">Working Hrs B<span class="requiredIcon text-center">*</span></label>
							<input type="text" id="spgdailybhrs" style="height: 50px; color:blue; font-style: bold; font-size: 28px;" value=8.00
                              name="spgdailybhrs" class="form-control   text-center">
        

						  </div>
    
              <div class="form-group col-md-2"  style="margin-left: 20px;">
							<label for="purchaseDetailsVendorName">Working Hrs C<span class="requiredIcon text-center">*</span></label>
							<input type="text" id="spgdailychrs" style="height: 50px; color:blue; font-style: bold; font-size: 28px;" value=7.5
                              name="spgdailychrs" class="form-control   text-center">
        

						  </div>
              
              <div class="form-group col-md-1" style="margin-left: 0px;">
						    <label for="purchaseDetailsPurchaseDate">Export Data<span class="text-center"></span></label>
                <button name="submit" id="expspgdata" style="height: 50px;" type="submit" class="form-control btn btn-primary">Export Data</button>
            </div>

            <div class="form-group col-md-1" style="margin-left: 0px;">
						    <label for="purchaseDetailsPurchaseDate">Map EB & Q Code <span class="text-center"></span></label>
                <button name="submit" id="expspgrepo" style="height: 50px;" type="submit" class="form-control btn btn-primary">Map Loom Data</button>
            </div>

 
                </div>
                <div class="form-row">
                <div class="form-group col-md-1" style="margin-left: 0px;" >
        			<label for="purchaseDetailsVendorName">Q Code<span class="requiredIcon text-center">*</span></label>
							<input type="text" id="spgquality_id" style="height: 50px; color:blue; font-style: bold; font-size: 28px;" value=''
                              name="spgquality_id" readonly class="form-control read  text-center">

            </div>
                <div class="form-group col-md-2" style="margin-left: 0px;" >
        			<label for="purchaseDetailsVendorName">Quality<span class="requiredIcon text-center">*</span></label>
							<input type="text" id="spgquality" style="height: 50px; color:blue; font-style: bold; font-size: 28px;" value=''
                              name="spgquality" readonly class="form-control read  text-center">

            </div>
 
            <div class="form-group col-md-1"  style="margin-left: 0px;">
							<label for="purchaseDetailsVendorName">Width<span class="requiredIcon text-center">*</span></label>
							<input type="text" id="wvgwidth" style="height: 50px; color:blue; font-style: bold; font-size: 28px;" value=''
                              name="wvgwidth" readonly class="form-control   text-center">
						  </div>
              <div class="form-group col-md-1"  style="margin-left: 0px;">
							<label for="purchaseDetailsVendorName">Ports<span class="requiredIcon text-center">*</span></label>
							<input type="text" id="wvgport" style="height: 50px; color:blue; font-style: bold; font-size: 28px;" value=''
                              name="wvgport" readonly class="form-control   text-center">
        

						  </div>
              <div class="form-group col-md-1"  style="margin-left: 0px;">
							<label for="purchaseDetailsVendorName">Shots<span class="requiredIcon text-center">*</span></label>
							<input type="text" id="wvgshots" style="height: 50px; color:blue; font-style: bold; font-size: 28px;" value=''
              name="wvgshots" readonly class="form-control   text-center">
						  </div>
              <div class="form-group col-md-1"  style="margin-left: 0px;">
							<label for="purchaseDetailsVendorName">Reed Space<span class="requiredIcon text-center">*</span></label>
							<input type="text" id="wvgrs" style="height: 50px; color:blue; font-style: bold; font-size: 28px;" value=''
              readonly       name="wvgrs" class="form-control   text-center">
						  </div>
              <div class="form-group col-md-1"  style="margin-left: 0px;">
							<label for="purchaseDetailsVendorName">Ozs/Yds<span class="requiredIcon text-center">*</span></label>
							<input type="text" id="wvgozsyds" style="height: 50px; color:blue; font-style: bold; font-size: 28px;" value=''
              readonly            name="wvgozsyds" class="form-control   text-center">
						  </div>
              <div class="form-group col-md-1"  style="margin-left: 0px;">
  							<label for="purchaseDetailsVendorName">JBO/RBO<span class="requiredIcon text-center">*</span></label>
	  						<input type="text" id="wvgjborbo" style="height: 50px; color:blue; font-style: bold; font-size: 28px;" value=''
                readonly name="wvgjborbo" class="form-control   text-center">
						  </div>

              <div class="form-group col-md-1"  style="margin-left: 0px;">
    							<label for="purchaseDetailsVendorName">Act Shots<span class="requiredIcon text-center">*</span></label>
		    					<input type="text" id="wvgashots" style="height: 50px; color:blue; font-style: bold; font-size: 28px;" value='0'
                  name="wvgashots" class="form-control   text-center">
						  </div>

                </div>

                <div class="form-row">
                <div class="form-group col-md-1"  style="margin-left: 0px;">
    							<label for="purchaseDetailsVendorName">A Ports<span class="requiredIcon text-center">*</span></label>
		    					<input type="text" id="wvgaports" style="height: 50px; color:blue; font-style: bold; font-size: 28px;" value='0'
                  name="wvgaports" class="form-control   text-center">
						  </div>
              <div class="form-group col-md-1"  style="margin-left: 20px;">
    							<label for="purchaseDetailsVendorName">Loom (A)<span class="requiredIcon text-center">*</span></label>
		    					<input type="text" id="wvgfrma" style="height: 50px; color:blue; font-style: bold; font-size: 28px;" value='0'
                  name="wvgfrma" class="form-control   text-center">
						  </div>
              <div class="form-group col-md-1"  style="margin-left: 20px;">
    							<label for="purchaseDetailsVendorName">Loom (B)<span class="requiredIcon text-center">*</span></label>
		    					<input type="text" id="wvgfrmb" style="height: 50px; color:blue; font-style: bold; font-size: 28px;" value='0'
                  name="wvgfrmb" class="form-control   text-center">
						  </div>
              <div class="form-group col-md-1"  style="margin-left: 20px;">
    							<label for="purchaseDetailsVendorName">Loom (C)<span class="requiredIcon text-center">*</span></label>
		    					<input type="text" id="wvgfrmc" style="height: 50px; color:blue; font-style: bold; font-size: 28px;" value='0'
                  name="wvgfrmc" class="form-control   text-center">
						  </div>
              <div class="form-group col-md-1"  style="margin-left: 20px;">
    							<label for="purchaseDetailsVendorName">Total Looms<span class="requiredIcon text-center">*</span></label>
		    					<input type="text" id="spgnofrmtot" style="height: 50px; color:blue; font-style: bold; font-size: 28px;" value='0'
                  name="spgnofrmc" class="form-control   text-center">
						  </div>
              <div class="form-group col-md-1"  style="margin-left: 20px;">
    							<label for="purchaseDetailsVendorName">Cuts (A)<span class="requiredIcon text-center">*</span></label>
		    					<input type="text" id="spgproda" style="height: 50px; color:blue; font-style: bold; font-size: 28px;" value='0'
                  name="spgproda" class="form-control   text-center">
						  </div>
              <div class="form-group col-md-1"  style="margin-left: 20px;">
    							<label for="purchaseDetailsVendorName">Cuts (B)<span class="requiredIcon text-center">*</span></label>
		    					<input type="text" id="spgprodb" style="height: 50px; color:blue; font-style: bold; font-size: 28px;" value='0'
                  name="spgprodb" class="form-control   text-center">
						  </div>
              <div class="form-group col-md-1"  style="margin-left: 20px;">
    							<label for="purchaseDetailsVendorName">Cuts (C)<span class="requiredIcon text-center">*</span></label>
		    					<input type="text" id="spgprodc" style="height: 50px; color:blue; font-style: bold; font-size: 28px;" value='0'
                  name="spgprodc" class="form-control   text-center">
						  </div>
              <div class="form-group col-md-1"  style="margin-left: 20px;">
    							<label for="purchaseDetailsVendorName">Total Cuts<span class="requiredIcon text-center">*</span></label>
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
       
            <h1>Weaving Data List</h1>
    <table id="spgdailyrecordTable" class="display">
        <thead>
            <tr>
               <th>Company Id</th>
               <th >Date</th>
                <th>Q Code </th>
                <th>Quality</th>
                <th>Ozs/Yds</th>
                <th>Read Porter</th>
                <th>Reed Space</th>
                <th>Width</th>
                <th>RPM</th>
                <th>Std Shots</th>
                <th>Act Shots</th>
                <th>Target Eff</th>
                <th>Target Kg/Lm</th>
                <th>Looms Run</th>
                <th>Production</th>
                <th>Kg/Lm/Shift</th>
                <th>Total Hours</th>
                <th>Act Eff(%)</th>
                <th>JBO RBO</th>
                <th>Hrs A</th>
                <th>Hrs B</th>
                <th>Hrs C</th>
                <th>MC A</th>
                <th>MC B</th>
                <th>MC C</th>
                <th>Prd A</th>
                <th>Prd B</th>
                <th>Prd C</th>
                <th>A Ports</th>
                
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

            table = $('#spgdailyrecordTable').DataTable({
                ajax: {
                    url: '<?php echo base_url('admin/weaving_daily_entry/get_spgdailydatarecords'); ?>',
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
                    { targets: [0], visible: false }, // Hide the first column (auto_id)
                    { targets: [3], visible: true },
                    { targets: [1], "className": "no-wrap" },
                    { "width": "100px", "targets": [3], "className": "no-wrap" }, // Set the width and apply the no-wrap class to the first and third columns
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
         var table = $('#spgdailyrecordTable').DataTable({
      select: 'single' // You can change 'single' to 'multiple' for multi-row selection
    });

        function refreshDataTable() {
          table.ajax.reload(null, false); // Reload the data without resetting the current page
        }


        $('#spgdailyrecordTable tbody').on('click', 'tr', function() {
                var rowData = table.row(this).data();

                $spgnofrmtot= parseFloat(rowData[22])+parseFloat(rowData[23])+parseFloat(rowData[24]);              
                $spgprodtot=  parseFloat(rowData[25])+parseFloat(rowData[26])+parseFloat(rowData[27]);
              //  alert($spgprodtot);              
                $('#spgquality_id').val(rowData[2]);
                $('#spgquality').val(rowData[3]);
                $('#wvgwidth').val(rowData[7]);
                $('#wvgport').val(rowData[5]);
                $('#wvgshots').val(rowData[9]);
                $('#wvgrs').val(rowData[6]);                
                $('#wvgozsyds').val(rowData[4]);                
                $('#wvgjborbo').val(rowData[18]);                
                $('#wvgashots').val(rowData[10]);                
                $('#spgdailyahrs').val(rowData[19]);                
                $('#spgdailybhrs').val(rowData[20]);                
                $('#spgdailychrs').val(rowData[21]);                
                $('#wvgfrma').val(rowData[22]);                
                $('#wvgfrmb').val(rowData[23]);                
                $('#wvgfrmc').val(rowData[24]);                
                $('#wvgaports').val(rowData[28]);                
                $('#spgnofrmtot').val($spgnofrmtot);                
                $('#spgproda').val(rowData[25]);                
                $('#spgprodb').val(rowData[26]);                
                $('#spgprodc').val(rowData[27]);                
                $('#spgprodtot').val($spgprodtot);                
                              
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
  if (e.key === "Delete" || e.key === "Del") {
  alert('del');
        var spgdailyDate= $('#spgdailyDate').val();
          var spgquality_id= $('#spgquality_id').val();
alert(spgdailyDate);
alert(spgquality_id);


        // Make an AJAX request to fetch data
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


$('#wvgfrma').on('input', function() {
          var wvgfrma =  parseFloat($('#wvgfrma').val());
          var wvgfrmb =  parseFloat($('#wvgfrmb').val());
          var wvgfrmc =  parseFloat($('#wvgfrmc').val());
          totfrm=(wvgfrma+wvgfrmb+wvgfrmc);
          var totfrm=parseFloat(totfrm);
          $('#spgnofrmtot').val(totfrm);
      });


      $('#wvgfrmb').on('input', function() {
          var wvgfrma =  parseFloat($('#wvgfrma').val());
          var wvgfrmb =  parseFloat($('#wvgfrmb').val());
          var wvgfrmc =  parseFloat($('#wvgfrmc').val());
          totfrm=(wvgfrma+wvgfrmb+wvgfrmc);
          var totfrm=parseFloat(totfrm);
          $('#spgnofrmtot').val(totfrm);
      });

      $('#wvgfrmc').on('input', function() {
          var wvgfrma =  parseFloat($('#wvgfrma').val());
          var wvgfrmb =  parseFloat($('#wvgfrmb').val());
          var wvgfrmc =  parseFloat($('#wvgfrmc').val());
          totfrm=(wvgfrma+wvgfrmb+wvgfrmc);
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

/*
      $("#expspgrepo").click(function(event){
          event.preventDefault(); 

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
                 alert(savedata);    
                 if (response.success) {
                    alert('Record Added Successfully');
              }
            }
        });
//        refreshDataTable();
      });
*/
$("#expspgrepo").click(function(event){
          event.preventDefault(); 
          $("#expspgrepo").attr('disabled',true);

          updatelmqc();
/*
          updatelmeb();
          updatelmopen();
*/
 
        });


      function updatelmqc() {
         var spgdailyDate = $('#spgdailyDate').val();
             var companyId=$('#companyId').val();
             var deferred = $.Deferred();
         //    alert(spgdailyDate);
          $.ajax({
            url: "<?php echo base_url('admin/weaving_daily_entry/updatelmqc_data'); ?>",
            type: "POST",
            data: {spgdailyDate: spgdailyDate,companyId: companyId
            },
            dataType: "json",
            success: function(response) {
              var savedata=(response.savedata);
                 if (response.success) {
                    var qcst=response.qcstarttime;
                    var qcend=response.qcendtime;
                    var msg='Quality Updated Successfully '+qcst+' to '+qcend ;
                    alert(msg);
                    updatelmeb();               
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



</script>



</body>
</html>
