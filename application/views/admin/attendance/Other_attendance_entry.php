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
                      <h3 class="m-1 text-dark text-center" style="background-color: #1589FF;"><strong>Daily Other Attendance Entry</strong></h3>

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
                              <input type="text" style="height: 50px; color:blue; font-style: bold; font-size: 20px;" class="form-control datepicker text-center" id="windingDate" name="windingDate" readonly>
                          </div>
                          <div class="form-group col-md-1" style="margin-left: 30px;">
                              <label for="purchaseDetailsVendorName">Spell<span class="requiredIcon text-center">*</span></label>
                              <select id="shiftName" style="height: 50px; color:blue; font-style: bold; font-size: 20px;" name="shiftName" class="form-control chosenSelect  text-center">
                                  echo "<option value='A1'> A1</option>";
                                  echo "<option value='B1'> B1</option>";
                                  echo "<option value='A2'> A2</option>";
                                  echo "<option value='B2'> B2</option>";
                                  echo "<option value='C'> C</option>";
                              </select>
                          </div>

                          <div class="form-group col-md-2" style="margin-left: 20px;">
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


                          <div class="form-group col-md-2">
                    <label >EB No </label>
                    <input type="text" name="ebno1" id="ebno1" value="" 
                    style="height: 50px; color:blue; font-style: bold; font-size: 30px;"
                    class="form-control text-center ">
            </div>
            <div class="form-group col-md-4">
                    <label >Name </label>
                    <input type="text" name="ebname" id="ebname" value="" 
                    style="height: 50px; color:blue; font-style: bold; font-size: 24px; disabled:disabled" "
                    class="form-control text-center " readonly>
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
                          <div class="form-group col-sm-4" style="margin-left: 20px;">
                              <label>Remarks </label>
                              <input type="text" name="remarks" id="remarks" value="" style="height: 50px; color:blue; font-style: bold; font-size: 20px;" class="form-control text-center" maxlength="100">
                          </div>
                          <div class="form-group col-md-1" style="margin-left: 10px;">
                              <label for="purchaseDetailsPurchaseDate">Search Data<span class="text-center"></span></label>
                              <button name="submit" id="searchdata" style="height: 50px;" type="submit" class="form-control btn btn-primary">Search</button>
                          </div>

                          <div class="form-group col-md-1" style="margin-left: 10px;">
                              <label for="purchaseDetailsPurchaseDate">Save Data<span class="text-center"></span></label>
                              <button name="submit" id="savedrgdoff" style="height: 50px;" type="submit" class="form-control btn btn-primary">Save</button>
                          </div>
                          <div class="form-group col-md-1" style="margin-left: 10px;">
                              <label for="purchaseDetailsPurchaseDate">Delete Data<span class="text-center"></span></label>
                              <button name="submit" id="updatedrgdoff" style="height: 50px;" type="submit" class="form-control btn btn-danger">Delete</button>
                          </div>
                          <div class="form-group col-md-1" style="margin-left:10px;">
                              <label for="purchaseDetailsPurchaseDate">Reset Data<span class="text-center"></span></label>
                              <button name="submit" id="resetdrgdata" style="height: 50px;" type="submit" class="form-control btn btn-primary">Reset</button>
                          </div>
                          <div class="form-group col-md-1" style="margin-left: 10px;">
                              <label for="purchaseDetailsPurchaseDate">Export Data<span class="text-center"></span></label>
                              <button name="submit" id="exportdbfdata" style="height: 50px;" type="submit" class="form-control btn btn-primary">Export</button>
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
                              <th>ebid</th>
                              <th>spellid</th>
                              <th>deptid</th>
                              <th>Remarks</th>
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

      $("#mc_no1").attr('disabled', false);
      $("#mc_no2").attr('disabled', true);
      $("#mc_no3").attr('disabled', true);

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
          var mcno1 = $('#mc_no1').val();
          var ebid1 = $('#ebid1').val();
          var remarks = $('#remarks').val();
          if (ebid1==0) {
            alert('Please Enter Active EB No');
              $('#ebno1').focus().css("border-color", "red");
              return false;

          }
          $.ajax({
              url: "<?php echo base_url('admin/Other_daily_atten/saveothatt_data'); ?>",
              type: "POST",
              data: {
                  windingDate: windingDate,
                  shiftName: shiftName,
                  companyId: companyId,
                  mcno1: mcno1,
                  ebid1: ebid1,
                  remarks: remarks,
              },
              dataType: "json",
              success: function(response) {
                  var savedata = (response.savedata);
                  if (response.success) {
                      $('#ebno1').val('');
                      $('#ebnname').val('');
//                      $("#mc_no1").val(0);
//                      $("#mc_no1").trigger('change');
                      alert('Record Added Successfully');
                      refreshDataTable();
                      $("#savedrgdoff").attr('disabled', true);
                      $("#updatedrgdoff").attr('disabled', true);
                      $('#record_id').val(0);

                  }
              }
          });

      });

      $("#updatedrgdoff").click(function(event) {
          event.preventDefault();
          var record_id = $('#record_id').val();
          $.ajax({
              url: "<?php echo base_url('admin/Other_daily_atten/updateretattndata'); ?>",
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




      initDataTable();

      function initDataTable() {
        var deptid = $('#mc_no1').val();
//            alert(deptid);    

          table = $('#recordTable').DataTable({
              ajax: {
                  url: '<?php echo base_url('admin/Other_daily_atten/get_records'); ?>',
                  type: 'POST',
                  data: function(d) {
                      d.date = $('#windingDate').val();
                      d.shift = $('#shiftName').val();
                      d.companyId = $('#companyId').val();
                      d.deptid = $('#mc_no1').val();
                      
                  }
              },
              columnDefs: [{
                      targets: [0,6,7,8],
                      visible: false
                  }, // Hide the first column (auto_id)
                  {
                      targets: [5, 6],
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
              order: [
                  [0, 'desc']
              ], // Sort by the first column (auto_id) in descending order
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

      // Function to delete a record
      function deleteRecord(recordId) {

          $.ajax({
              url: "<?php echo base_url('admin/Winding_doff_data/deleteRecord'); ?>",
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
          $("#mc_no1").val(rowData[8]);
          $("#mc_no1").trigger('change');
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
          $('#record_id').val(0);
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
  </script>



  </body>

  </html>