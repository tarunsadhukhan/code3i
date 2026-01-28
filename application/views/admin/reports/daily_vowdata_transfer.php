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
          <h3 class="m-1 text-dark text-center" style="background-color: #1589FF;"><strong>Daily Vow Data Transfer</strong></h3>

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
						  <input type="text" style="height: 40px; color:blue; font-style: bold; font-size: 20px;"
               class="form-control datepicker text-center" id="windingDate" 
              name="windingDate"   readonly >
						</div>
            <div class="form-group col-md-2"  style="margin-left: 30px;">
							<label for="purchaseDetailsVendorName">SHift<span class="requiredIcon text-center">*</span></label>
							<select id="shiftName" style="height: 40px; color:blue; font-style: bold; font-size: 20px;"
              name="shiftName" class="form-control chosenSelect  text-center">
              echo "<option value='ALL' > ALL</option>";
              echo "<option value='A1' > A1</option>";
              echo "<option value='B1' > B1</option>";
              echo "<option value='A2' > A2</option>";
              echo "<option value='B2' > B2</option>";
              echo "<option value='C' > C</option>";
 							</select>
						  </div>
              <div class="form-group col-md-2"  style="margin-left: 30px;">
							<label for="purchaseDetailsVendorName">Trans Typespan<span class="requiredIcon text-center">*</span></label>
							<select id="transName" style="height: 40px; color:blue; font-style: bold; font-size: 20px;"
              name="transName" class="form-control chosenSelect  text-center">
              echo "<option value=1 > Att Data Transfer</option>";
              echo "<option value=2 > Wvg Mc Transfer</option>";
              echo "<option value='B1' > B1</option>";
              echo "<option value='A2' > A2</option>";
              echo "<option value='B2' > B2</option>";
              echo "<option value='C' > C</option>";
 							</select>
						  </div>
            <div class="form-group col-sm-2" style="margin-left: 20px;">
                    <label >Spell Hour </label>
                    <input type="number" name="splhrs1" id="splhrs1" value=5
                    style="height: 40px; color:blue; font-style: bold; font-size: 20px;"
                    class="form-control text-center ">
           </div> 
 




<?php
                  $company_id = $this->session->userdata('company_id');
                //  echo $company_id;
              ?>
 
<input type="hidden" class="input" value="<?php echo $company_id; ?>" id="companyId" />
              <input type="hidden" class="input" value=0 id="record_id" />
              <input type="hidden" class="input" id="mc1_id" />
              <input type="hidden" class="input" id="spell" />
              <input type="hidden" class="input" id="mc3_id" />
              <input type="hidden" class="input" id="update" />
             
					  </div>
			
      
      

            
            <div class="row">
            <div class="form-group col-md-2" style="margin-left: 20px;" >
							<label for="purchaseDetailsVendorName">Department<span class="requiredIcon text-center">*</span></label>
              <select class="form-group form-control select2" id="mc_no1" style=" font-size: 20px; height: 30px; ">
              echo "<option value=0 > Select.... </option>";
            <?php
                foreach ($data['wndmcdata'] as $each){	 
                   echo "<option value=".$each['dept_id'].">".$each['dept_desc']."</option>"
                ?>
                <?php }  ?>
							</select>
            </div>
      
                      
           <div class="form-group col-md-2" style="margin-left: 0px;">
						  <label for="purchaseDetailsPurchaseDate">Export Hands Data<span class="text-center"></span></label>
              <button name="submit" id="exphnddata" style="height: 40px;" type="submit" class="form-control btn btn-primary">Export Hands Data</button>
            </div>
            <div class="form-group col-md-2" style="margin-left: 0px;">
						  <label for="purchaseDetailsPurchaseDate">Update Data<span class="text-center"></span></label>
              <button name="submit" id="updatedrgdoff" style="height: 40px;" type="submit" class="form-control btn btn-primary">Update</button>
            </div>
            <div class="form-group col-md-2" style="margin-left: 0px;">
						  <label for="purchaseDetailsPurchaseDate">Reset Data<span class="text-center"></span></label>
              <button name="submit" id="resetdrgdata" style="height: 40px;" type="submit" class="form-control btn btn-primary">Reset</button>
            </div>
            <div class="form-group col-md-2" style="margin-left: 0px;">
						  <label for="purchaseDetailsPurchaseDate">Export Att Data<span class="text-center"></span></label>
              <button name="submit" id="exportdbfdata" style="height: 40px;" type="submit" class="form-control btn btn-primary">Export</button>
            </div>
            <div class="form-group col-md-2" style="margin-left: 0px;">
						  <label for="purchaseDetailsPurchaseDate">Export Jute MRs<span class="text-center"></span></label>
              <button name="submit" id="exportmrdata" style="height: 40px;" type="submit" class="form-control btn btn-primary">Export</button>
            </div>
            <div class="form-group col-md-2" style="margin-left: 0px;">
						  <label for="purchaseDetailsPurchaseDate">Spreader Inputs<span class="text-center"></span></label>
              <button name="submit" id="exportsprddata" style="height: 40px;" type="submit" class="form-control btn btn-primary">Export</button>
            </div>
            <div class="form-group col-md-2" style="margin-left: 0px;">
						  <label for="purchaseDetailsPurchaseDate">Winding Checklist<span class="text-center"></span></label>
              <button name="submit" id="wndchecklist" style="height: 40px;" type="submit" class="form-control btn btn-primary">Export</button>
            </div>
            <div class="form-group col-md-2" style="margin-left: 0px;">
						  <label for="purchaseDetailsPurchaseDate">Finishing Checklist<span class="text-center"></span></label>
              <button name="submit" id="fngchecklist" style="height: 40px;" type="submit" class="form-control btn btn-primary">Export</button>
            </div>
          
            </div> 
        

            </form>
       
            <h1>Record List</h1>
    <table id="recordTable">
        <thead>
            <tr>
                <th>Record ID</th>
                <th>Tran Date</th>
                <th>Spell</th>
                <th>Mc Code</th>
                <th>Mc Name</th>
                <th>Const Meter</th>
                <th>Open Meter</th>
                <th>Close Meter</th>
                <th>Diff Meter</th>
                <th>Eff(%)</th>
                <th>Wrokign Hrs</th>
                <th>Remarks</th>
                <th>Mc Id</th>
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
 
 

$('#nomcs').focus();
$('#nomcs').select();

 
</script>

<script>
    




 
// Function to delete a record



  
             $("#exportdbfdata").click(function(event){
              event.preventDefault(); 
             alert('aabb');
	          var payrollstartdate= $('#windingDate').val();
            var companyId=$('#companyId').val();
            var mc_no1=$('#mc_no1').val();
            var shiftName=$('#shiftName').val();
            var transName=$('#transName').val();
      alert(transName);
            var url = '<?php echo site_url("admin/Daily_vowdata_transfer/exportdbfdata"); ?>' +
                      '?payrollstartdate=' + payrollstartdate +
                      '&companyId=' + companyId+ 
                      '&mc_no1=' + mc_no1 +
                      '&shiftName=' + shiftName+
                      '&transName=' + transName
                      
                      ;
//                      alert(url);
			//$(location).attr('href',url);
			window.open( url, '_blank');
			
			
return false;
});

$("#exportmrdata").click(function(event){
              event.preventDefault(); 
             alert('aabb');
	          var payrollstartdate= $('#windingDate').val();
            var companyId=$('#companyId').val();
            var mc_no1=$('#mc_no1').val();
            var shiftName=$('#shiftName').val();
            var transName=$('#transName').val();
      alert(transName);
            var url = '<?php echo site_url("admin/Daily_vowdata_transfer/exportmrdata"); ?>' +
                      '?payrollstartdate=' + payrollstartdate +
                      '&companyId=' + companyId+ 
                      '&mc_no1=' + mc_no1 +
                      '&shiftName=' + shiftName+
                      '&transName=' + transName
                      
                      ;
//                      alert(url);
			//$(location).attr('href',url);
			window.open( url, '_blank');
			
			
return false;
});
 

$("#exportmrdata").click(function(event){
              event.preventDefault(); 
             alert('aabb');
	          var payrollstartdate= $('#windingDate').val();
            var companyId=$('#companyId').val();
            var mc_no1=$('#mc_no1').val();
            var shiftName=$('#shiftName').val();
            var transName=$('#transName').val();
      alert(transName);
            var url = '<?php echo site_url("admin/Daily_vowdata_transfer/exportmrdata"); ?>' +
                      '?payrollstartdate=' + payrollstartdate +
                      '&companyId=' + companyId+ 
                      '&mc_no1=' + mc_no1 +
                      '&shiftName=' + shiftName+
                      '&transName=' + transName
                      
                      ;
//                      alert(url);
			//$(location).attr('href',url);
			window.open( url, '_blank');
			
			
return false;
});
 

$("#exportsprddata").click(function(event){
              event.preventDefault(); 
      //       alert('aabb');
	          var payrollstartdate= $('#windingDate').val();
            var companyId=$('#companyId').val();
            var mc_no1=$('#mc_no1').val();
            var shiftName=$('#shiftName').val();
            var transName=$('#transName').val();
     // alert(transName);
            var url = '<?php echo site_url("admin/Daily_vowdata_transfer/exportsprddata"); ?>' +
                      '?payrollstartdate=' + payrollstartdate +
                      '&companyId=' + companyId+ 
                      '&mc_no1=' + mc_no1 +
                      '&shiftName=' + shiftName+
                      '&transName=' + transName
                      
                      ;
//                      alert(url);
			//$(location).attr('href',url);
			window.open( url, '_blank');
			
			
return false;
});
 

$("#wndchecklist").click(function(event){
              event.preventDefault(); 
      //       alert('aabb');
	          var payrollstartdate= $('#windingDate').val();
            var companyId=$('#companyId').val();
            var mc_no1=$('#mc_no1').val();
            var shiftName=$('#shiftName').val();
            var transName=$('#transName').val();
     // alert(transName);
            var url = '<?php echo site_url("admin/Daily_vowdata_transfer/wndchecklist"); ?>' +
                      '?payrollstartdate=' + payrollstartdate +
                      '&companyId=' + companyId+ 
                      '&mc_no1=' + mc_no1 +
                      '&shiftName=' + shiftName+
                      '&transName=' + transName
                      
                      ;
                      alert(url);
			//$(location).attr('href',url);
			window.open( url, '_blank');
			
			
return false;
});
 

$("#fngchecklist").click(function(event){
              event.preventDefault(); 
      //       alert('aabb');
	          var payrollstartdate= $('#windingDate').val();
            var companyId=$('#companyId').val();
            var mc_no1=$('#mc_no1').val();
            var shiftName=$('#shiftName').val();
            var transName=$('#transName').val();
     // alert(transName);
            var url = '<?php echo site_url("admin/Daily_vowdata_transfer/fngchecklist"); ?>' +
                      '?payrollstartdate=' + payrollstartdate +
                      '&companyId=' + companyId+ 
                      '&mc_no1=' + mc_no1 +
                      '&shiftName=' + shiftName+
                      '&transName=' + transName
                      
                      ;
                      alert(url);
			//$(location).attr('href',url);
			window.open( url, '_blank');
			
			
return false;
});






$("#exphnddata").click(function(event){
              event.preventDefault(); 
             alert('aabb');
	          var payrollstartdate= $('#windingDate').val();
            var companyId=$('#companyId').val();
            var mc_no1=$('#mc_no1').val();
            var shiftName=$('#shiftName').val();
            var transName=$('#transName').val();
      alert(transName);
            var url = '<?php echo site_url("admin/Daily_vowdata_transfer/exphnddata"); ?>' +
                      '?payrollstartdate=' + payrollstartdate +
                      '&companyId=' + companyId+ 
                      '&mc_no1=' + mc_no1 +
                      '&shiftName=' + shiftName+
                      '&transName=' + transName
                      
                      ;
//                      alert(url);
			//$(location).attr('href',url);
			window.open( url, '_blank');
			
			
return false;
});
 



        


</script>



</body>
</html>
