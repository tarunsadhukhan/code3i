  <!-- /.navbar -->

  <?php



    use PHPUnit\TextUI\XmlConfiguration\CodeCoverage\Report\Php;

    $this->load->view('admin/header'); ?>

  <!-- REQUIRED SCRIPTS -->

  <!-- jQuery -->
  <script src="<?php echo base_url() ?>public/admin/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?php echo base_url() ?>public/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?php echo base_url() ?>public/admin/dist/js/adminlte.min.js"></script>


  <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>


  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
  <!--
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
-->
  <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url() ?>public/admin/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>public/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <script src="<?php echo base_url() ?>public/admin/plugins/select2/js/select2.full.min.js"></script>




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
          background-color: #fff;
          /* Background color of the dialog box */
          border: 2px solid #333;
          /* Border color of the dialog box */
          padding: 20px;
          /* Padding inside the dialog box */
          text-align: center;
      }

      /* CSS for the "Yes" button */
      .btn-yes {
          background-color: #FF0000;
          /* Red background color for "Yes" button */
          color: #FFF;
          /* Text color for "Yes" button */
          padding: 10px 20px;
          /* Padding for the button */
          border: none;
          /* Remove button border */
          cursor: pointer;
      }

      /* CSS for the "No" button */
      .btn-no {
          background-color: #333;
          /* Background color for "No" button */
          color: #FFF;
          /* Text color for "No" button */
          padding: 10px 20px;
          /* Padding for the button */
          border: none;
          /* Remove button border */
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
                      <h3 class="m-1 text-dark text-center" style="background-color: #1589FF;"><strong>Daily Attendance Entry</strong></h3>

                  </div><!-- /.col -->
              </div><!-- /.row -->
          </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <div class="content">
          <div class="container-fluid">
              <div class="card-body">
                  <form name="categoryForm" id="categoryForm" method="" action="">

                      <div class="form-row">
                          <div class="form-group col-md-2">
                              <label for="purchaseDetailsPurchaseDate">Date<span class="text-center">*</span></label>
                              <input type="text" style="height: 50px; color:blue; font-style: bold; font-size: 20px;" 
                              class="form-control datepicker text-center" id="windingDate" name="windingDate" readonly>
                          </div>
                          <div class="form-group col-md-2" style="margin-left: 30px;">
                              <label for="purchaseDetailsVendorName">Spell<span class="requiredIcon text-center">*</span></label>
                              <select id="shiftName" style="height: 50px; color:blue; font-style: bold; font-size: 20px;" name="shiftName" class="form-control chosenSelect  text-center">
                                  echo "<option value='A1'> A1</option>";
                                  echo "<option value='B1'> B1</option>";
                                  echo "<option value='A2'> A2</option>";
                                  echo "<option value='B2'> B2</option>";
                                  echo "<option value='C'> C</option>";
                              </select>
                          </div>
                          <div class="form-group col-md-1">
                    <label >Spell Hours </label>
                    <input type="text" name="splhrs1" id="splhrs1" value="5" 
                    style="height: 50px; color:blue; font-style: bold; font-size: 30px;"
                    class="form-control text-center " readonly>
            </div>
          
                          <div class="form-group col-md-3" style="margin-left: 20px;">
                              <label for="purchaseDetailsVendorName">Department<span class="requiredIcon text-center">*</span></label>
                              <select class="form-group form-control select2" id="mc_no1" style=" font-size: 20px; height: 20px; ">
                                  echo "<option value=0> Select.... </option>";
                                  <?php
                                    foreach ($data['deptdata'] as $each) {
                                        echo "<option value=" . $each['dept_id'] . ">" . $each['dept_desc'] . "</option>"
                                    ?>
                                  <?php }  ?>
                              </select>
                          </div>

                          <div class="form-group col-md-1" style="margin-left: 0px;">
                              <label for="purchaseDetailsPurchaseDate">Search Data<span class="text-center"></span></label>
                              <button name="submit" id="searchdata" style="height: 50px;" type="submit" class="form-control btn btn-primary">Search</button>
                          </div>
                          <div class="form-group col-md-1" style="margin-left:10px;">
                              <label for="purchaseDetailsPurchaseDate">Reset Data<span class="text-center"></span></label>
                              <button name="submit" id="resetdrgdata" style="height: 50px;" type="submit" class="form-control btn btn-primary">Reset</button>
                          </div>
                          <div class="form-group col-md-1" style="margin-left:10px;">
                              <label for="purchaseDetailsPurchaseDate">Delete Data<span class="text-center"></span></label>
                              <button name="submit" id="deletedrgdata" style="height: 50px;" type="submit" class="form-control btn btn-primary">Delete</button>
                          </div>
                


                          <?php
                            $company_id = $this->session->userdata('company_id');
                            //  echo $company_id;
                            ?>

                          <input type="hidden" class="input" value="<?php echo $company_id; ?>" id="companyId" />
                          <input type="hidden" class="input" value=0 id="record_id" />
                          <input type="hidden" class="input" id="ebid1" />
                          <input type="hidden" class="input" id="spell" />
                          <input type="hidden" class="input" id="mc3_id" />
                          <input type="hidden" class="input" id="update" />

                      </div>




  
                      <div class="row">
                      <div class="form-group col-md-1">
                    <label >EB No </label>
                    <input type="text" name="ebno1" id="ebno1" value="" 
                    style="height: 50px; color:blue; font-style: bold; font-size: 30px;"
                    class="form-control text-center ">
            </div>
            <div class="form-group col-md-2">
                    <label >Name </label>
                    <input type="text" name="ebname" id="ebname" value="" 
                    style="height: 50px; color:blue; font-style: bold; font-size: 24px; disabled:disabled" "
                    class="form-control text-center " readonly>
          </div>
          <div class="form-group col-md-2" style="margin-left: 0px;">
                              <label for="purchaseDetailsVendorName">Designation<span class="requiredIcon text-center">*</span></label>
                              <select class="form-group form-control select2" id="mc_no2" style=" font-size: 20px; height: 20px; ">
                                  echo "<option value=0> Select.... </option>";
                              </select>
                          </div>
                         <div class="form-group col-md-1" style="margin-left: 0px;">
                              <label for="purchaseDetailsVendorName">Att Type<span class="requiredIcon text-center">*</span></label>
                              <select id="typeName" style="height: 50px; color:blue; font-style: bold; font-size: 20px;" 
                              name="typeName" class="form-control chosenSelect  text-center">
                                  echo "<option value='R'> Regular</option>";
                                  echo "<option value='O'> OT</option>";
                                  echo "<option value='C'> Cash</option>";
                               </select>
                          </div>

                    <div class="form-group col-md-1" style="margin-left: 0px;">
                 <label >Working Hrs </label>
                    <input type="text" name="whrs" id="whrs" value="5" 
                    style="height: 50px; color:blue; font-style: bold; font-size: 30px;"
                    class="form-control text-center ">
            </div>
            <div class="form-group col-md-1" style="margin-left: 0px;">
                 <label >Idle Hrs </label>
                    <input type="text" name="idlehrs" id="idlehrs" value="0" 
                    style="height: 50px; color:blue; font-style: bold; font-size: 30px;"
                    class="form-control text-center ">
            </div>

            <div class="form-group col-md-2" style="margin-left: 0px;">
    <label for="purchaseDetailsVendorName">Mc Nos<span class="requiredIcon text-center">*</span></label>
    <select class="form-group form-control select2" id="mc_no3" name="mc_no[]" multiple="multiple" style="font-size: 20px; height: 20px;">
        <option value="0">Select...</option>
    </select>
</div>
                 
                          <div class="form-group col-md-1" style="margin-left: 10px;">
                              <label for="purchaseDetailsPurchaseDate">Save Data<span class="text-center"></span></label>
                              <button name="submit" id="savedrgdoff" style="height: 50px;" type="submit" class="form-control btn btn-primary">Save</button>
                          </div>

                      </div>


                  </form>

                  <h1>Record List</h1>
                  <table id="recordTable">
                      <thead>
                          <tr>
                              <th>Record ID</th>
                              <th>Date</th>
                              <th>Spell</th>
                              <th>Department</th>
                              <th>EB No</th>
                              <th>Name</th>
                              <th>Designation</th>
                              <th>Working Hours</th>
                              <th>Idle Hours</th>
                              <th>Mc Nos</th>
                              <th>ebid</th>
                              <th>desigid</th>
                              <th>deptid</th>
                              <th>Mcids</th>
                              <th>Reg/OT/Cash</th>
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
      $(function() {

          //Initialize Select2 Elements

          $('.select2').select2();

          //Initialize Select2 Elements
          $('.select2bs4').select2({
              theme: 'bootstrap4'
          })



          $(".selector").datepicker("setDate", new Date());



      })

      $("#windingDate").datepicker({
          dateFormat: 'dd-mm-yy',
          todayHighlight: 'TRUE',
          autoclose: true,
          maxDate: '0',
      });
      $("#payrollenddate").datepicker({
          dateFormat: 'dd-mm-yy',
          todayHighlight: 'TRUE',
          autoclose: true,
      });

      $('#windingDate').datepicker('setDate', 'today');

      setInterval(function() {

          var now = new Date();
          var outStr = ((now.getHours() < 10 ? '0' : '') + now.getHours()) + ':' + ((now.getMinutes() < 10 ? '0' : '') + now.getMinutes()) + ':' + ((now.getSeconds() < 10 ? '0' : '') + now.getSeconds());
          $('#rec_time').val(outStr);
      }, 1000);


      var newDate = new Date();
      var ctime = new Date().toLocaleTimeString('en-GB');

      var hr = ctime.substr(0, 2);

      $("#savedrgdoff").attr('disabled', true);
      $("#updatedrgdoff").attr('disabled', true);

//      $("#mc_no1").attr('disabled', false);
//      $("#mc_no2").attr('disabled', true);
//      $("#mc_no3").attr('disabled', true);

      $("#ebno").attr('disabled', true);
      $("#trollywt").attr('disabled', true);
      $("#spoolwt").attr('disabled', true);
      $("#mc1netwt").attr('disabled', true);
      $("#mc2netwt").attr('disabled', true);
      $("#mc3netwt").attr('disabled', true);


      $('#nomcs').focus();
      $('#nomcs').select();
  </script>

  <script>
      $(document).ready(function() {
          $('input[type="text"]').on('focus', function() {
              $(this).select();
          });

          $('#mc_no3').select2({
            placeholder: "Select MC Nos",
            allowClear: true
        });  
            $('#shiftName').on('change', function() {
                var shiftName=$("#shiftName").val();
           //         alert(shiftName);
                if  (shiftName=='A1')  {
                    $('#splhrs1').val(5);

            }
                if  (shiftName=='B1')  {
                    $('#splhrs1').val(3);
                }
                if  (shiftName=='A2')  {
                    $('#splhrs1').val(3);
            }
                if  (shiftName=='B2')  {
                    $('#splhrs1').val(5);
                }

                if  (shiftName=='C')  {
                    $('#splhrs1').val(7.5);
                }
                $('#whrs').val($('#splhrs1').val());
                $('#idlehrs').val(0);
                
            });

          $('#ebno1').on('change', function() {
              var ebno1 = $('#ebno1').val();
              var companyId = $('#companyId').val();
              var mcno1 = $('#mc_no1').val();
              var windingDate = $('#windingDate').val();
               if (mcno1==0) {
                alert('Please Select Department');
                  $('#mc_no1').focus().css("border-color", "red");
                  return false;

              }   
        //      alert(ebno1);
                  $.ajax({
                      url: "<?php echo base_url('admin/Other_daily_atten/getebdata'); ?>",
                      type: "POST",
                      data: {
                          ebno1: ebno1,
                          companyId: companyId,
                          windingDate: windingDate 
        
                      },
                      dataType: "json",
                      success: function(response) {
                          if (response.success) {
                              $('#ebname').val(response.ebname);
                              $('#ebid1').val(response.ebid);
                          if (response.ebid>0) {
                              $("#savedrgdoff").attr('disabled', false);
                        } else {
                            $('#ebname').val('No Data');
                            $("#savedrgdoff").attr('disabled', true);
                        } 
                            
                        }   
                        }
                    });
  
          });




/*
$('#ebno1').on('input', function() {
          var ebno1 =  $('#ebno1').val();
          var companyId=$('#companyId').val();
        
          $.ajax({
            url: "<?php echo base_url('admin/Doffdata/trolly_data'); ?>",
            type: "POST",
            data: {trollyNo: trollyNo,companyId: companyId,frameNo: frameNo },
            dataType: "json",
            success: function(response) {
                $('#tareWt').val(response.trollyWt);
                $tw=$('#tareWt').val();
                $('#tareWt').css({'border-color': 'green','background-color': 'white'
                });
                $('#trollyNo').css({'border-color': 'green','background-color': 'white'
                });
                 
                if ($tw==0) {
                       $('#tareWt').css({'border-color': 'red','background-color': 'yellow'
                    });
                    $('#trollyNo').css({'border-color': 'red','background-color': 'yellow'
                    });
                    
                  }
                }
                });
    });
*/






          $('#clmeter1').on('input', function() {
              // alert('netwt');
              var companyId = $('#companyId').val();
              var shiftName = $('#shiftName').val();
              var clmeter1 = $('#clmeter1').val();
              var clmeter1 = parseFloat(clmeter1);
              var opmeter = $('#opmeter').val();
              var opmeter = parseFloat(opmeter);
              var cmeter = $('#cmeter').val();
              var cmeter = parseFloat(cmeter);
              var netwt = clmeter1 - opmeter;

              var splhrs1 = $('#splhrs1').val();
              var splhrs1 = parseFloat(splhrs1);
              if (opmeter > clmeter1) {
                  netwt = (clmeter1 + 10000) - opmeter;
              }
              //   alert(netwt);
              var eff = 0;
              if (netwt >= 0) {
                  $('#dfmeter').css({
                      'border-color': 'green',
                      'background-color': 'white'
                  });
                  if (netwt > 0) {
                      eff = (netwt / (cmeter / 8 * splhrs1) * 100).toFixed(2);
                  }
                  var dfm = netwt;

                  $('#dfmeter').val(dfm);
                  $('#eff').val(eff);
                  $('#dfmeter').css({
                      'border-color': 'black',
                      'background-color': 'white'
                  });
                  $("#savedrgdoff").attr('disabled', false);
              } else {
                  $('#dfmeter').css({
                      'border-color': 'red',
                      'background-color': 'yellow'
                  });
                  $("#savedrgdoff").attr('disabled', true);
              }
              var record_id = $('#record_id').val();
              //    alert(record_id);
              if (record_id > 0 & dfm >= 0) {
                  $("#savedrgdoff").attr('disabled', true);
                  $("#updatedrgdoff").attr('disabled', false);
              }
              if (record_id == 0 & dfm >= 0) {
                  $("#savedrgdoff").attr('disabled', false);
                  $("#updatedrgdoff").attr('disabled', true);
              }

          });
      });


      $("#searchdata").click(function(event) {
          event.preventDefault();
      //    initDataTable();
//  alert('aaaa');
refreshDataTable();   
});


      //start save
      $("#savedrgdoff").click(function(event) {
          event.preventDefault();
          var companyId = $('#companyId').val();
          var windingDate = $('#windingDate').val();
          var shiftName = $('#shiftName').val();
          var deptid = $('#mc_no1').val();
          var desigid = $('#mc_no2').val();
          var mcnos = $('#mc_no3').val();
          var ebid1 = $('#ebid1').val();
          var ebno1 = $('#ebno1').val();
          var splhrs1 = $('#splhrs1').val();
          var whrs = $('#whrs').val();
          var idlehrs = $('#idlehrs').val();
          var atttype = $('#typeName').val();
          var recordid = $('#record_id').val();
          
          if (recordid>0) {
            alert('Please Reset And do Again');
              $('#ebno1').focus().css("border-color", "red");
              return false;
 

          }
//alert(mcnos);

          if (isNaN(deptid)) {
            deptid=0;
          }
          if (isNaN(desigid)) {
            desigid=0;
          }
          if (isNaN(whrs)) {
            whrs=0;
          }
          if (isNaN(idlehrs)) {
            desigid=0;
          }
          
          if (whrs==0)    {
            alert('Please Enter Working Hrs');
              $('#whrs').focus().css("border-color", "red");
              return false;
          }
          if ((whrs-idlehrs)<0) {
            alert('Please check Working Hrs negative='+whrs-idlehrs);
              $('#whrs').focus().css("border-color", "red");
              return false;
      
          }
          if (ebid1==0) {
            alert('Please Enter Active EB No');
              $('#ebno1').focus().css("border-color", "red");
              return false;

          }
          if (deptid==0) {
            alert('Please Enter Department');
              $('#mc_no1').focus().css("border-color", "red");
              return false;

          }
          if (desigid==0) {
            alert('Please Enter Designation');
              $('#mc_no2').focus().css("border-color", "red");
              return false;

          }

          $.ajax({
              url: "<?php echo base_url('admin/Daily_Attendance_Entry/saveatt_data'); ?>",
              type: "POST",
              data: {
                  windingDate: windingDate,
                  shiftName: shiftName,
                  companyId: companyId,
                  deptid: deptid,
                  ebid1: ebid1,
                  ebno1: ebno1,
                  desigid: desigid,
                  splhrs1: splhrs1,
                  whrs: whrs,
                  idlehrs: idlehrs,
                  ebid1: ebid1,
                  mcnos: mcnos,
                  atttype: atttype,
                  
              
              },
              dataType: "json",
              success: function(response) {
                  var savedata = (response.savedata);
                  if (response.success) {
                    alert('Record Added Successfully');
                    $('#ebno1').val('');
          $('#ebname').val('');
          $('#remarks').val('');
//          $('#mc_no2').empty();
       //   $('#mc_no3').val(null).trigger('change');  
  //        $('#mc_no2').empty();
          $('#mc_no3').val(null).css({
    'height': '05px'      // Reset height
}).trigger('change'); // This will trigger the visual update if needed
          $('#record_id').val(0);
          $('#idlehrs').val(0);
          $("#savedrgdoff").attr('disabled', false);
          $("#updatedrgdoff").attr('disabled', true);

                      refreshDataTable();
                      $("#savedrgdoff").attr('disabled', true);
                      $("#updatedrgdoff").attr('disabled', true);
                      $('#record_id').val(0);

                  }
              }
          });

      });





      initDataTable();

      function initDataTable() {
        var deptid = $('#mc_no1').val();

//            alert(deptid);    

          table = $('#recordTable').DataTable({
              ajax: {
                  url: '<?php echo base_url('admin/Daily_Attendance_Entry/get_records'); ?>',
                  type: 'POST',
                  data: function(d) {
                      d.date = $('#windingDate').val();
                      d.shift = $('#shiftName').val();
                      d.companyId = $('#companyId').val();
                      d.deptid = $('#mc_no1').val();
                      
                  }
              },
              columnDefs: [{
                      targets: [0,13,12,11,10],
                      visible: false
                  }, // Hide the first column (auto_id)
                  {
                      targets: [7, 8],
                      render: function(data, type, row, meta) {
                          return '<div class="column-align-right">' + data + '</div>';
                      }
                  },
              ],
              drawCallback: function() {
                  // Apply alignment styles to the table cells
                  $('#recordTable td.column-align-center').css('text-align', 'center');
                  $('#recordTable td.column-align-right').css('text-align', 'right');
              },
          // Sort by the first column (auto_id) in descending order
              pageLength: 10 // Set the default number of rows per page to 25
          });
      }

      // Handle the click event for the "Delete" button
      // Handle the click event for the "Delete" button
      $('#recordTable tbody').on('click', 'button.delete-button', function() {
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

      // Function to delete a record deletedrgdata
      function deleteRecord(recordId) {

          $.ajax({
              url: "<?php echo base_url('admin/Daily_Attendance_Entry/deleteRecord'); ?>",
              type: "POST",
              data: {
                  recordId: recordId
              },
              dataType: "json",
              success: function(response) {
                  var savedata = (response.savedata);
                  if (response.success) {

                      alert('Record Deleted Successfully');
                      refreshDataTable();

                  }

              }

          });
      }

      $("#deletedrgdata").click(function(event) {
          event.preventDefault();
          var record_id = $('#record_id').val();
          alert(record_id);
          $.ajax({
              url: "<?php echo base_url('admin/Daily_Attendance_Entry/updateattndata'); ?>",
              type: "POST",
              data: {
                  record_id
              },
              dataType: "json",
              success: function(response) {
                  var savedata = (response.savedata);
                  if (response.success) {
                      $('#ebno1').val('');
                      $('#ebname').val('');
                      $('#remarks').val('');
                      alert('Record Deleted Successfully');
                      refreshDataTable();
                      $("#savedrgdoff").attr('disabled', true);
                      $("#updatedrgdoff").attr('disabled', true);
                      $('#record_id').val(0);

                  }
              }
          });

      });





      function refreshDataTable() {
          table.ajax.reload(null, false); // Reload the data without resetting the current page
      }


      $('#recordTable tbody').on('click', 'tr', function() {
          var rowData = table.row(this).data();
          $('#record_id').val(rowData[0]);
      //    $('#windingDate').val(rowData[1]);
          $sft = rowData[2];
          var rc = $('#record_id').val();
          $('#shiftName').val($sft);
          $("#shiftName").trigger('change');
          $("#ebno1").val(rowData[4]);
          $("#ebname").val(rowData[5]);
          $("#remarks").val(rowData[9]);
          $("#savedrgdoff").attr('disabled', true);
          $("#updatedrgdoff").attr('disabled', false);
      });

      $('#recordTable tbody').on('click', 'tr', function() {
          if ($(this).hasClass('selected')) {
              $(this).removeClass('selected');
          } else {
              table.$('tr.selected').removeClass('selected');
              $(this).addClass('selected');
          }
      });

      $("#resetdrgdata").click(function(event) {
        event.preventDefault();
          $('#ebno1').val('');
          $('#ebname').val('');
          $('#remarks').val('');
//          $('#mc_no2').empty();
       //   $('#mc_no3').val(null).trigger('change');  
  //        $('#mc_no2').empty();
          $('#mc_no3').val(null).css({
    'height': '05px'      // Reset height
}).trigger('change'); // This will trigger the visual update if needed
          $('#record_id').val(0);
          $('#idlehrs').val(0);
          $("#savedrgdoff").attr('disabled', false);
          $("#updatedrgdoff").attr('disabled', true);

      });

      $('#windingDate, #shiftName,#mc_no1').on('change', function() {
//          refreshDataTable();
      });

      $("#exportdbfdata").click(function(event) {
          event.preventDefault();
          //      alert('aabb');
          var payrollstartdate = $('#windingDate').val();
          var companyId = $('#companyId').val();
          var shift = $('#shiftName').val();
          var deptid = $('#mc_no1').val();
         alert(payrollstartdate);
          var url = '<?php echo site_url("admin/Other_daily_atten/exportdbfdata"); ?>' +
              '?payrollstartdate=' + payrollstartdate +
              '&companyId=' + companyId+
              '&shift=' + shift+
              '&deptid=' + deptid;
                               alert(url);
          //$(location).attr('href',url);
          window.open(url, '_blank');


          return false;
      });




      $('#mc_no1x').on('change', function() {
                var deptid = $(this).val(); // Get the selected category ID

                // If category ID is selected
                if (deptid) {
                    // Send AJAX request to fetch subcategories based on the selected category
                    $.ajax({
                        url: "<?= base_url('controller_name/get_subcategories'); ?>",  // Adjust the controller and method
                        type: "POST",
                        data: { category_id: categoryId },
                        dataType: "json",
                        success: function(response) {
                            // Clear the second combo box
                            $('#secondCombo').empty();
                            $('#secondCombo').append('<option value="">Select a subcategory</option>');

                            // Populate the second combo box with the fetched subcategories
                            $.each(response, function(key, value) {
                                $('#secondCombo').append('<option value="' + value.id + '">' + value.name + '</option>');
                            });
                        }
                    });
                } else {
                    // Clear the second combo box if no category is selected
                    $('#secondCombo').empty();
                    $('#secondCombo').append('<option value="">Select a subcategory</option>');
                }
            });

            $('#mc_no1').on('change', function() {
              var mcno1 = $('#mc_no1').val();
              var companyId = $('#companyId').val();
              var mcno1 = $('#mc_no1').val();
              var windingDate = $('#windingDate').val();
               if (mcno1==0) {
                alert('Please Select Department');
                  $('#mc_no1').focus().css("border-color", "red");
                  return false;

              }   
                  $.ajax({
                      url: "<?php echo base_url('admin/Daily_Attendance_Entry/getdesigdata'); ?>",
                      type: "POST",
                      data: {
                          mcno1: mcno1,
                          companyId: companyId,
                          windingDate: windingDate 
        
                      },
                      dataType: "json",
                      success: function(response) {
                        
                            $('#mc_no2').empty();
                            $('#mc_no2').append('<option value="">Select Designation</option>');

                            // Populate the second combo box with the fetched subcategories
                            $.each(response, function(key, value) {
                                $('#mc_no2').append('<option value="' + value.id + '">' + value.name + '</option>');
                            });
                                                     
                        
                        }
                    });
                        
          });

          $('#mc_no2').on('change', function() {
              var mcno1 = $('#mc_no1').val();
              var mcno2 = $('#mc_no2').val();
              var companyId = $('#companyId').val();
              var mcno1 = $('#mc_no1').val();
              var windingDate = $('#windingDate').val();
               if (mcno2==0) {
                alert('Please Select Department/Designation');
                  $('#mc_no2').focus().css("border-color", "red");
                  return false;

              }   
                  $.ajax({
                      url: "<?php echo base_url('admin/Daily_Attendance_Entry/getmcnodata'); ?>",
                      type: "POST",
                      data: {
                          mcno1: mcno1,
                          mcno2: mcno2,
                          companyId: companyId,
                          windingDate: windingDate 
        
                      },
                      dataType: "json",
                      success: function(response) {
                        
                            $('#mc_no3').empty();
                            $('#mc_no3').append('<option value="">Select Mc Nos</option>');

                            // Populate the second combo box with the fetched subcategories
                            $.each(response, function(key, value) {
                                $('#mc_no3').append('<option value="' + value.id + '">' + value.name + '</option>');
                            });
                                                     
                        
                        }
                    });
                        
          });



  </script>



  </body>

  </html>