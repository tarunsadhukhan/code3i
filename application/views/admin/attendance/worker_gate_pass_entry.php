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

<?php $this->load->view('admin/header'); ?>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-10">
          <h3 class="m-1 text-dark text-center" style="background-color:#1589FF;">Worker Gate Pass</h3>
        </div>
        <div class="col-sm-2">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url('admin/home'); ?>">Home</a></li>
            <li class="breadcrumb-item active">Worker Gate Pass</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <div class="content">
    <div class="container-fluid">
      <div class="card-body">

        <input type="hidden" id="rec_id" value="" />

        <div class="row">
          <div class="col-md-2">
            <label>Issue Date</label>

            <input type="text" class="form-control date text-center" id="issue_date" placeholder="dd-mm-yyyy" >
          </div>

          <div class="col-md-2">
            <label>Spell</label>
            <select id="spell" class="form-control text-center">
              <option value="">Select</option>
              <option value="A">A</option>
              <option value="B">B</option>
              <option value="C">C</option>
            </select>
          </div>

          <div class="col-md-2">
            <label>EB No</label>
            <input type="text" class="form-control text-center" id="ebno">
          </div>

          <div class="col-md-3">
            <label>Name</label>
            <input type="text" class="form-control" id="name" readonly>
          </div>

          <div class="col-md-3">
            <label>Authority</label>
            <select id="authority" class="form-control">
              <option value="">Select</option>
              <option value="Personnel Manager">Personnel Manager</option>
              <option value="Personnel Officer">Personnel Officer</option>
              <option value="Welfare Officer">Welfare Officer</option>
              <option value="Labour Officer">Labour Officer</option>
            </select>
          </div>
        </div>

        <div class="row mt-3">
          <div class="col-md-2">
            <label>Absent From</label>
            <input type="text" class="form-control date text-center" id="absent_from">
          </div>
          <div class="col-md-2">
            <label>Absent To</label>
            <input type="text" class="form-control date text-center" id="absent_to">
          </div>
          <div class="col-md-2">
            <label>No of Days</label>
            <input type="text" class="form-control text-center" id="no_of_days">
          </div>
          <div class="col-md-6">
            <label>Remarks</label>
            <input type="text" class="form-control" id="remarks">
          </div>
        </div>

        <div class="row mt-3">
          <div class="col-md-12 text-center">
            <button id="savetab" class="btn btn-primary">Save</button>
            <button id="deltab" class="btn btn-danger">Delete</button>
            <button id="printSelected" class="btn btn-secondary">Print</button>
            <button id="downloadExcel" class="btn btn-info">Download Excel</button>
            <button id="resettab" class="btn btn-warning">Reset</button>
            <span id="loading" style="margin-left:10px;"></span>
          </div>
        </div>

        <hr>
                          <?php
                            $company_id = $this->session->userdata('company_id');
                            ?>
                 <input type="hidden" class="input" id="ebid" />
                 <input type="hidden" class="input" id="recid" />
                 
           
<table id="fileData" class="table table-bordered table-striped" style="width:100%">
  <thead>
    <tr>
      <th style="width:30px;">
        <input type="checkbox" id="checkAll">
      </th>
      <th>TRAN_ID</th>
      <th>EB_NO</th>
      <th>NAME</th>
      <th>GATE PASS DATE</th>
      <th>SHIFT</th>
      <th>ABSENT FROM</th>
      <th>ABSENT TO</th>
      <th>DAYS</th>
      <th>REASONS</th>
      <th>AUTHORITY</th>
    </tr>
  </thead>
  <tbody></tbody>
</table>
<!-- Period Filter Modal -->
<div class="modal fade" id="periodFilterModal" tabindex="-1" role="dialog" aria-labelledby="periodFilterModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="periodFilterModalLabel">Download Excel Report</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="excelFilterForm">
          <div class="form-group">
            <label for="period_from">Period From:</label>
            <input type="text" class="form-control date" id="period_from" placeholder="dd-mm-yyyy" required>
          </div>
          <div class="form-group">
            <label for="period_to">Period To:</label>
            <input type="text" class="form-control date" id="period_to" placeholder="dd-mm-yyyy" required>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="submitExcelFilter">Submit</button>
      </div>
    </div>
  </div>
</div>
      </div>
    </div>
  </div>
</div>

<?php $this->load->view('admin/footer'); ?>


<script>
  window.WGP = {
    ajaxListUrl: "<?php echo site_url('admin/reports/WorkerGatePass/ajax_list'); ?>",
    printMultiUrl: "<?php echo site_url('admin/reports/WorkerGatePass/print_multi'); ?>"
  };
</script>



<script>
$(document).ready(function () {

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

      $("#issueDate").datepicker({
          dateFormat: 'dd-mm-yy',
          todayHighlight: 'TRUE',
          autoclose: true,
      });

      $('#issueDate').datepicker('setDate', 'today');

      setInterval(function() {

          var now = new Date();
          var outStr = ((now.getHours() < 10 ? '0' : '') + now.getHours()) + ':' + ((now.getMinutes() < 10 ? '0' : '') + now.getMinutes()) + ':' + ((now.getSeconds() < 10 ? '0' : '') + now.getSeconds());
          $('#rec_time').val(outStr);
      }, 1000);


      var newDate = new Date();
      var ctime = new Date().toLocaleTimeString('en-GB');

      var hr = ctime.substr(0, 2);




  // IMPORTANT: In jQuery UI datepicker, "yy" = 4-digit year

  $(".date").datepicker({
  dateFormat: "dd-mm-yy",
  changeMonth: true,
  changeYear: true,
  minDate: 0    // 0 = today
});


/*   var table = $('#fileData').DataTable({
    processing: true,
    serverSide: true,
    order: [[0, 'desc']],
    ajax: { url: WGP.ajaxListUrl, type: "GET" },
    columnDefs: [{ targets: 0, visible: false }]
  });

  // Row click -> fill form
  $('#fileData tbody').on('click', 'tr', function () {
    var data = table.row(this).data();
    if (!data) return;

    $('#rec_id').val(data[0]);
    $('#EBNO').val(data[1]);
    $('#NAME').val(data[2]);
    $('#issue_date').val(data[3]);
    $('#spell').val(data[4]);
    $('#DATE_OFWORK1').val(data[5]);
    $('#DATE_OFWORK2').val(data[6]);
    $('#working_hours').val(data[7]);
    $('#REMARKS').val(data[8]);
    $('#authority').val(data[9]);
  });

 */  // EB no -> get name
/*   $('#EBNO').on('input', function () {
    var EBNO = $('#EBNO').val();
    if (EBNO.length <= 4) return;

    $.ajax({
      url: WGP.workerUrl,
      type: "POST",
      dataType: "json",
      data: { EBNO: EBNO },
      success: function (x) {
        $('#NAME').val(x.name || 'Invalid EB No');
        if ((x.name || '') === 'Invalid EB No') {
          alert('Invalid EB No');
          $('#EBNO').focus();
        }
      }
    });
  });
*/


var table = $('#fileData').DataTable({
  processing: true,
  serverSide: true,
  order: [[1, 'desc']], // 1 = TRAN_ID because 0 is checkbox

  language: {
    emptyTable: "No data available for selected date",
    zeroRecords: "No matching records found"
  },

  ajax: {
    url: WGP.ajaxListUrl,
    type: "GET",
    data: function (d) {
      d.issue_date = $('#issue_date').val(); // must be YYYY-MM-DD (or convert here)
    },
    dataSrc: "data" // ✅ DataTables expects "data"
  },

  columns: [
    {
      data: null,
      orderable: false,
      searchable: false,
      render: function (data, type, row) {
        return '<input type="checkbox" class="row-check" value="'+ row[0] +'">'; // row[0]=TRAN_ID
      }
    },
    { data: 0 }, { data: 1 }, { data: 2 }, { data: 3 }, { data: 4 },
    { data: 5 }, { data: 6 }, { data: 7 }, { data: 8 }, { data: 9 }
  ]
});

// reload on date change
$('#issue_date').on('change blur', function () {
  table.ajax.reload(null, true);
});

// ✅ On issue date change: clear table then reload
 
  // Select all
  $('#checkAll').on('change', function () {
    $('.row-check').prop('checked', this.checked);
  });

  // If redraw happens (pagination/filter), uncheck "select all"
  $('#fileData').on('draw.dt', function () {
    $('#checkAll').prop('checked', false);
  });




  // Print checked
  $('#printSelected').on('click', function (e) {
    e.preventDefault();

    var ids = [];
    $('.row-check:checked').each(function () {
      ids.push($(this).val());
    });

    if (ids.length === 0) {
      alert('Please select at least one record to print.');
      return;
    }


    // Open print page in new tab with ids
    window.open(WGP.printMultiUrl + '?ids=' + encodeURIComponent(ids.join(',')), '_blank');
  });



   // Save
  $('#savetab').click(function (e) {
    e.preventDefault();
  //  alert('save');
  

    var payload = {
      issuedate: $('#issue_date').val(),
      spell: $('#spell').val(),
      ebno: $.trim($('#ebno').val()),
      ebid: $.trim($('#ebid').val()),
      date_ofwork1: $('#absent_from').val(),
      date_ofwork2: $('#absent_to').val(),
      nodays: $('#no_of_days').val(),
      remarks: $('#remarks').val(),
      authority: $('#authority').val()
    };

//    alert(payload);
 //   alert(payload.spell);
 //   alert(payload.authority);
   if (!payload.spell) { alert("Please Select spell !"); $('#spell').focus(); return; }
  if (!payload.authority) { alert("Please Select authority !"); $('#authority').focus(); return; }
 
    if (!payload.ebno) { alert("Please Enter Ebnumber !"); $('#ebno').focus(); return; }
    if ($('#name').val() === 'Invalid EB No') { alert("Please Enter Valid EB No !"); $('#ebno').focus(); return; }
    if (!payload.date_ofwork1) { alert("Please Enter From Date !"); $('#date_ofwork1').focus(); return; }
    if (!payload.date_ofwork2) { alert("Please Enter To Date !"); $('#date_ofwork2').focus(); return; }
    if (!payload.nodays) { alert("Please Enter Day !"); $('#nodays').focus(); return; }
 
    $('#loading').html('Saving...');

    $.ajax({
             url: "<?php echo base_url('admin/reports/WorkerGatePass/savetab'); ?>",
               type: "POST",
      data: payload,
      success: function (resp) {
        $('#loading').html('');
        alert(resp);
        table.ajax.reload(null, false);
          $('#ebno').val(' ');

                $('#resettab').click();

      },
      error: function () {
        $('#loading').html('');
        alert("Save failed!");
      }
    });
  });

  // Delete
/*   $('#deltab').click(function (e) {
    e.preventDefault();

    var rec_id = $('#rec_id').val();
    if (!rec_id) return alert('Please select a record!');
    if (!confirm('Are you sure you want to delete ?')) return;

    $('#loading').html('Deleting...');

    $.ajax({
      url: WGP.deleteUrl,
      type: "POST",
      data: { rec_id: rec_id },
      success: function (resp) {
        $('#loading').html('');
        alert(resp);
        table.ajax.reload(null, false);
        $('#resettab').click();
      },
      error: function () {
        $('#loading').html('');
        alert("Delete failed!");
      }
    });
  });
 */
       $("#printtab").click(function(event) {
          event.preventDefault();
         //    alert('aabb');
          var payrollstartdate = $('#issue_date').val();
          var companyId = $('#companyId').val();
          var ebno = $('#ebno').val();
          var ebid = $('#ebid').val();
        // alert(payrollstartdate);
          var url = '<?php echo site_url("admin/reports/WorkerGatePass/exportpdfdata"); ?>' +
              '?payrollstartdate=' + payrollstartdate +
              '&companyId=' + companyId+
              '&ebno=' + ebno+              
             '&ebid=' + ebid;      


          //                     alert(url);
          //$(location).attr('href',url);
          window.open(url, '_blank');


          return false;
      });
 
 // Reset
  $('#resettab').click(function (e) {
    e.preventDefault();
    $('#rec_id').val('');
//    $('#issue_date').val('');
    $('#spell').val(' ');
    $('#ebno').val(' ');
    $('#name').val(' ');
    $('#absent_from').val('');
    $('#absent_to').val('');
    $('#no_of_days').val('');
    $('#remarks').val(' ');
    $('#authority').val(' ');
  });

});
        $('.select2').select2();

          //Initialize Select2 Elements
          $('.select2bs4').select2({
              theme: 'bootstrap4'
          })



          $(".selector").datepicker("setDate", new Date());



      

      $("#issue_date").datepicker({
          dateFormat: 'dd-mm-yy',
          todayHighlight: 'TRUE',
          autoclose: true,
      });
      $("#absent_from").datepicker({
          dateFormat: 'dd-mm-yy',
          todayHighlight: 'TRUE',
          autoclose: true,
          maxDate: '0',
      });
      $("#absent_to").datepicker({
          dateFormat: 'dd-mm-yy',
          todayHighlight: 'TRUE',
          autoclose: true,
          maxDate: '0',
      });


      setInterval(function() {

          var now = new Date();
          var outStr = ((now.getHours() < 10 ? '0' : '') + now.getHours()) + ':' + ((now.getMinutes() < 10 ? '0' : '') + now.getMinutes()) + ':' + ((now.getSeconds() < 10 ? '0' : '') + now.getSeconds());
          $('#rec_time').val(outStr);
      }, 1000);


      var newDate = new Date();
      var ctime = new Date().toLocaleTimeString('en-GB');

      var hr = ctime.substr(0, 2);

      $('#issue_date').datepicker('setDate', 'today');


          $('#ebno').on('change', function() {
              var ebno = $('#ebno').val();
              var companyId = $('#companyId').val();
              var issueDate = $('#issue_date').val();
            //  alert(ebno);
            //  alert (companyId);
               if (!ebno) {
                alert('Please Enter Ebno');
                  $('#ebno').focus().css("border-color", "red");
                  return false;

              }   
                  $.ajax({
                      url: "<?php echo base_url('admin/reports/WorkerGatePass/getebdata'); ?>",
                      type: "POST",
                      data: {
                          ebno: ebno,
                          companyId: companyId,
                          issueDate: issueDate 
        
                      },
                      dataType: "json",
                      success: function(response) {
                          if (response.success) {
                              $('#name').val(response.ebname);
                              $('#ebid').val(response.ebid);
                              $('#remarks').val(response.rem);
                              $('#absent_from').val(response.frdate);
                              $('#absent_to').val(response.todate);
                              $('#no_of_days').val(response.diffDays);
                          if (response.ebid>0) {
                              $("#savetab").attr('disabled', false);
                        } else {
                            $("#savetab").attr('disabled', true);
                        } 
                            
                        }   
                        }
                    });
  
          });

function updateWorkingHours() {
  var fromUi = $("#absent_from").val();
  var toUi   = $("#absebt_from").val();

  var fromDb = uiDateToDb(fromUi);
  var toDb   = uiDateToDb(toUi);

  // store DB dates if you use hidden fields
//  $("#absent_from").val(fromDb);
//  $("#absent_to").val(toDb);

  var days = calcDaysInclusive(fromDb, toDb);

  if (days === null) {
    $("#no_of_days").val("");
    return;
  }

  if (days <= 0) {
    $("#no_of_days").val("");
    alert("Absent To date must be greater than or equal to Absent From date.");
    $("#abset_to").focus();
    return;
  }

  $("#no_of_days").val(days);
}

function uiDateToDb(dateStr) {
  if (!dateStr) return "";
  var parts = dateStr.split("-");
  if (parts.length !== 3) return "";

  var dd = parts[0];
  var mon = (parts[1] || "").toLowerCase();
  var yyyy = parts[2];

  var mmMap = {jan:"01",feb:"02",mar:"03",apr:"04",may:"05",jun:"06",jul:"07",aug:"08",sep:"09",oct:"10",nov:"11",dec:"12"};
  var mm = mmMap[mon];
  if (!mm) return "";

  return yyyy + "-" + mm + "-" + dd; // YYYY-MM-DD
}

function calcDaysInclusive(fromDb, toDb) {
  if (!fromDb || !toDb) return null;

  // Parse as UTC to avoid timezone issues
  var d1 = new Date(fromDb + "T00:00:00Z");
  var d2 = new Date(toDb   + "T00:00:00Z");

  if (isNaN(d1.getTime()) || isNaN(d2.getTime())) return null;

  var diffMs = d2.getTime() - d1.getTime();
  var diffDays = Math.floor(diffMs / (24 * 60 * 60 * 1000)) + 1; // +1 inclusive
  return diffDays;
}

function updateWorkingHours() {
  var fromUi = $("#absent_from").val();
  var toUi   = $("#absent_to").val();

  alert(fromUi);
  alert(toUi);

  var fromDb = uiDateToDb(fromUi);
  var toDb   = uiDateToDb(toUi);

  // store DB dates if you use hidden fields
  $("#absent_from").val(fromDb);
  $("#absent_to").val(toDb);

  var days = calcDaysInclusive(fromDb, toDb);

  if (days === null) {
    $("#no_of_days").val("");
    return;
  }

  if (days <= 0) {
    $("#no_of_days").val("");
    alert("Absent To date must be greater than or equal to Absent From date.");
    $("#absent_from").focus();
    return;
  }

  $("#no_of_days").val(days);
}


       $('#absent_from').on('change', function() {
   

var  date1m =$('#absent_from').val();
var  date2m =$('#absent_to').val();

if (date1m && date1m.length === 10) {
  var date1a =
      date1m.substr(3, 2) + "/" +   // mm
      date1m.substr(0, 2) + "/" +   // dd
      date1m.substr(6, 4);          // yyyy
}


if (date2m && date2m.length === 10) {
  var date2a =
      date2m.substr(3, 2) + "/" +   // mm
      date2m.substr(0, 2) + "/" +   // dd
      date2m.substr(6, 4);          // yyyy
}
//alert('first '+date1a+'=='+date2a)

const date1 = new Date(date1a);
const date2 = new Date(date2a);

//alert('2nd '+date1+'=='+date2)



//const new Date('7/13/2010');
//const date2 = new Date('12/15/2010');
const diffTime = Math.abs(date2 - date1);
const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24)); 
//console.log(diffTime + " milliseconds");
//console.log(diffDays + " days");
//alert (diffDays);
                             $('#no_of_days').val(diffDays);
 
       })



$('#absent_to').on('change', function () {
    $('#absent_from').change();
});
// Run when either date changes OR loses focus
 
// Run when either date changes OR loses focus

// Excel Download Modal and Download Handler
$('#downloadExcel').on('click', function (e) {
  e.preventDefault();
  // Clear previous values
  $('#period_from').val('');
  $('#period_to').val('');
  // Show modal
  $('#periodFilterModal').modal('show');
});

// Initialize datepickers for period inputs
$("#period_from").datepicker({
    dateFormat: 'dd-mm-yy',
    todayHighlight: 'TRUE',
    autoclose: true,
});

$("#period_to").datepicker({
    dateFormat: 'dd-mm-yy',
    todayHighlight: 'TRUE',
    autoclose: true,
});

// Submit Excel Filter
$('#submitExcelFilter').on('click', function (e) {
  e.preventDefault();
  
  var periodFrom = $('#period_from').val();
  var periodTo = $('#period_to').val();
  
  if (!periodFrom) {
    alert('Please select Period From date');
    $('#period_from').focus();
    return;
  }
  
  if (!periodTo) {
    alert('Please select Period To date');
    $('#period_to').focus();
    return;
  }
  
  // Validate dates
  var dateFrom = new Date(periodFrom.split('-').reverse().join('-'));
  var dateTo = new Date(periodTo.split('-').reverse().join('-'));
  
  if (dateFrom > dateTo) {
    alert('Period From date cannot be greater than Period To date');
    return;
  }
  
  // Hide modal
  $('#periodFilterModal').modal('hide');
  
  // Trigger Excel download
  var url = "<?php echo base_url('admin/reports/WorkerGatePass/downloadExcel'); ?>" +
            '?period_from=' + encodeURIComponent(periodFrom) +
            '&period_to=' + encodeURIComponent(periodTo);
  
  window.location.href = url;
});

</script>