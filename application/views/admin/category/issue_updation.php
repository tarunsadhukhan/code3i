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
          <h3 class="m-1 text-dark text-center" style="background-color: #1589FF;"><strong>Issue Updation</strong></h3>

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
                            class="form-control datepicker text-center" id="isspassDate" 
                            name="isspassDate"    >
						</div>
                        <div class="form-group col-md-2"  style="margin-left: 20px;">
							<label for="purchaseDetailsVendorName">issue Pass no<span class="requiredIcon text-center">*</span></label>
							<input type="text" id="issueno" style="height: 50px; color:blue; font-style: bold; font-size: 28px;"  
                              name="spgdailyahrs" class="form-control   text-center">
        

						  </div>
     
                    <div class="form-group col-md-2"  style="margin-left: 20px;">
							<label for="purchaseDetailsVendorName">Itemcode C<span class="requiredIcon text-center">*</span></label>
							<input type="text" id="itemcode" style="height: 50px; color:blue; font-style: bold; font-size: 28px;"  
                              name="itemcode"  class="form-control   text-center">
						  </div>
                          <div class="form-group col-md-2"  style="margin-left: 20px;">
							<label for="purchaseDetailsVendorName">Quantity C<span class="requiredIcon text-center">*</span></label>
							<input type="text" id="issqty" style="height: 50px; color:blue; font-style: bold; font-size: 28px;"  
                              name="issqty" class="form-control   text-center">
						  </div>
                          <div class="form-group col-md-2"  style="margin-left: 20px;">
    							<label for="purchaseDetailsVendorName">Inactive<span class="requiredIcon text-center">*</span></label>
	    						<input type="text" id="issact" style="height: 50px; color:blue; font-style: bold; font-size: 28px;" 
                                  name="issact" class="form-control   text-center">
						  </div>
               
                          <div class="form-group col-md-1" style="margin-left: 0px;">
			    			    <label for="purchaseDetailsPurchaseDate">Save Data<span class="text-center"></span></label>
                                <button name="submit" id="saveissdata" style="height: 50px;" type="submit" class="form-control btn btn-primary">Save Data</button>
                        </div>
 
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

$("#isspassDate").datepicker({ 
  dateFormat: 'dd-mm-yy',
					todayHighlight:'TRUE',
					autoclose: true,
                    maxDate: '0',
                });
   
                $('#isspassDate').datepicker('setDate', 'today');

setInterval(function() {

//alert('isspassDate');


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
        $("#saveissdata").click(function(event){
          event.preventDefault(); 
          var companyId=$('#companyId').val();
          var isspassDate= $('#isspassDate').val();
          var issueno= $('#issueno').val();
          var itemcode= $('#itemcode').val();
          var issqty=     $('#issqty').val();                
          var issact=     $('#issact').val();                
          var recid=     $('#record_id').val();                
       
          $.ajax({
           url: "<?php echo base_url('admin/issue_updation/save_data'); ?>",
            type: "POST",
            data: {isspassDate: isspassDate,itemcode: itemcode,companyId: companyId,
                issqty: issqty,issact: issact,issueno:issueno,recid:recid
            },
            dataType: "json",
            success: function(response) {
              var savedata=(response.savedata);
              alert(response.closqty);
                 if (response.success) {
                  alert('Record Updated  Successfully');
                  $('#itemcode').val('');
  
                  }
            }
        });
 
      });

 

  

   

   
 

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


 

    
      
      $('#itemcode').on('change', function() {
             var itemcode =  $('#itemcode').val();
             var isspassDate= $('#isspassDate').val();
             var companyId=$('#companyId').val();
             var issueno= $('#issueno').val();
          $.ajax({
            url: "<?php echo base_url('admin/issue_updation/issue_data'); ?>",
            type: "POST",
            data: {companyId: companyId,isspassDate: isspassDate,itemcode: itemcode,issueno:issueno },
            dataType: "json",
            success: function(response) {
             
              if (response.success) {
                $('#issqty').val(response.issqty);
                $('#issact').val(response.issact);
                $('#record_id').val(response.issno);
              }
            }  
            });
 
              });


    





</script>



</body>
</html>
