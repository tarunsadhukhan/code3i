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



#qcrecordTable {
        border-collapse: collapse;
        width: 100%;
    }

    #qcrecordTable th,
    #qcrecordTable td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #qcrecordTable th {
        background-color: #f2f2f2;
    }

    #qcrecordTable tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    #qcrecordTable tr:hover {
        background-color: #ddd;
    }

    .selected {
        background-color: yellow;
    }
    #qcrecordTable td.column-align-center {
        text-align: center;
    }

    #qcrecordTable td.column-align-right {
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
          <h3 class="m-1 text-dark text-center" style="background-color: #1589FF;"><strong>S4 Incentive Report</strong></h3>
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
						  <label for="purchaseDetailsPurchaseDate">From Date<span class="text-center">*</span></label>
						  <input type="text" style="height: 50px; color:blue; font-style: bold; font-size: 28px;"
                            class="form-control datepicker text-center" id="windingperfrDate" 
                            name="windingperfrDate"   readonly >
						</div>
						<div class="form-group col-md-2">
						  <label for="purchaseDetailsPurchaseDate">To Date<span class="text-center">*</span></label>
						  <input type="text" style="height: 50px; color:blue; font-style: bold; font-size: 28px;"
                            class="form-control datepicker text-center" id="windingpertoDate" 
                            name="windingpertoDate"   readonly >
						</div>
            <div class="form-group col-md-3"  style="margin-left: 50px;">
							<label for="purchaseDetailsVendorName">Loom Type<span class="requiredIcon text-center">*</span></label>
							<select id="loomtype" style="height: 50px; color:blue; font-style: bold; font-size: 28px;"
              name="loomtype" class="form-control chosenSelect  text-center">
        

              echo "<option value='41' > Weaver</option>";
              echo "<option value='42' > Helper</option>";
        

             
							</select>
						  </div>

 
       
  
           <div class="form-group col-md-2" style="margin-left: 20px;">
						  <label for="purchaseDetailsPurchaseDate">Report<span class="text-center"></span></label>
              <button name="submit" id="attlmrept" style="height: 50px;" type="submit" class="form-control btn btn-primary">Report</button>
            
            </div>
            <div class="form-group col-md-2" style="margin-left: 20px;">
						  <label for="purchaseDetailsPurchaseDate">Excel<span class="text-center"></span></label>
              <button name="submit" id="exploomdata" style="height: 50px;" type="submit" class="form-control btn btn-primary">Excel</button>
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
 
              


					  </div>
			
      
      

 
        

         
            

         


            </form>
       
 <h1 id="reportTitle">S4 Incentive Report</h1>
   <table id="qcrecordTable">
        <thead>
 
            <tr>
                <th>EB No</th>
                <th>Name</th>
                <th>Hrs</th>
                <th>Prod</th>
                <th>Eff%</th>
                <th>Hrs</th>
                <th>Prod</th>
                <th>Eff%</th>
                <th>Prod</th>
                <th>Eff%</th>
                <th>Hrs</th>
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
new    
    $('.select2').select2();

//Initialize Select2 Elements
$('.select2bs4').select2({
  theme: 'bootstrap4'
})



  $( ".selector" ).datepicker( "setDate", new Date());

  
 
})
//$(".datepicker").datepicker({maxDate: '0'});

$("#windingperfrDate").datepicker({ 
  dateFormat: 'dd-mm-yy',
					todayHighlight:'TRUE',
					autoclose: true,
                    maxDate: '0',
                });
                $("#windingpertoDate").datepicker({ 
                  dateFormat: 'dd-mm-yy',
					todayHighlight:'TRUE',
					autoclose: true,
                });

                $('#windingperfrDate').datepicker('setDate', 'today');
                $('#windingpertoDate').datepicker('setDate', 'today');

 




 
</script>

<script>
        $(document).ready(function() {
            $('input[type="text"]').on('focus', function() {
                $(this).select();
            });

  
   

       
 
        });

//start save

 //     initDataTable();

function parseDMY(str) {
    // expects "dd-mm-yyyy"
    var parts = str.split('-');
    return new Date(parts[2], parts[1] - 1, parts[0]);
}

function getDateRangeDays() {
    var s = $('#windingperfrDate').val();
    var e = $('#windingpertoDate').val();

    if (!s || !e) return [];

    var start = parseDMY(s);
    var end   = parseDMY(e);

    var days = [];
    var current = new Date(start);

    while (current <= end) {
        var d = ('0' + current.getDate()).slice(-2); // "01", "02", ...
        days.push(d);
        current.setDate(current.getDate() + 1);
    }
    return days;
}

function updateReportTitle() {
    var sdate = $('#windingperfrDate').val();
    var edate = $('#windingpertoDate').val();
    var loomText = $('#loomtype option:selected').text();  // Weaver / Helper etc.

    var title = 'S4 Incentive Report';

    // Append info if available
    if (sdate && edate) {
        title += ' (' + sdate + ' to ' + edate + ')';
    }
    if (loomText) {
        title += ' - ' + loomText;
    }

    $('#reportTitle').text(title);
}



function buildDynamicHeader() {
    var days = getDateRangeDays();
    dayCount = days.length;   
    var $thead = $('#qcrecordTable thead');

    var html = '<tr>';
    html += '<th>EB No</th>';
    html += '<th>Name</th>';

    // One column per day between from/to
    days.forEach(function (d) {
        html += '<th>' + d + '</th>';
    });
   html += '<th>Avg Eff(%)</th>';
   html += '<th>No of Days</th>';
   html += '<th>Inc Days</th>';
   html += '<th>Inc Amount</th>';
 

    html += '</tr>';

    $thead.html(html);
}






function initDataTable() {

    // Destroy old table safely (only if already initialized)
    if ($.fn.DataTable.isDataTable('#qcrecordTable')) {
        $('#qcrecordTable').DataTable().destroy();
        $('#qcrecordTable tbody').empty();
    }

    // 🔹 FIRST: build dynamic header based on from/to date
    updateReportTitle();

    buildDynamicHeader();

 //   alert('dsy');   
 
    // THEN initialize DataTable
    table = $('#qcrecordTable').DataTable({
        ajax: {
            url: '<?php echo base_url('admin/reports/S4_incentive_report/get_s4incentivedata'); ?>',
            type: 'POST',
            data: function(d) {
                d.sdate    = $('#windingperfrDate').val();
                d.edate    = $('#windingpertoDate').val();
                d.companyId= $('#companyId').val();
                d.loomtype = $('#loomtype').val();
            }
        },
        columnDefs: [
            { targets: [0], visible: true },
            { targets: [3], visible: true },
            {
                targets: [1,5,6],
                render: function(data, type, row, meta) {
                    if (meta.col == 0) {
                        return '<img src="data:image/png;base64,' + data + '" alt="Image" style="max-width:100px;max-height:100px;">';
                    } else {
                        return '<div class="column-align-right">' + data + '</div>';
                    }
                }
            }
        ],
 fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {

    // 0 -> EBNO
    // 1 -> Name
    // 2..(2+dayCount-1) -> day columns
    // then last 4 -> summary columns

    var startCol = 2;                      // first day column index
    var endCol   = startCol + dayCount - 1; // last day column index

    for (var i = startCol; i <= endCol; i++) {
        var val = parseFloat(aData[i]);
        var $cell = $('td:eq(' + i + ')', nRow);
        if (isNaN(val) || aData[i] === null || aData[i] === '') {
            // no value / empty → light grey
            $cell.css('background-color', '#f0f0f0').css('color', '#000');
        } else if (val==0) {
            // low eff → red
//            $cell.css('background-color', 'red').css('color', '#fff');
                $cell.text('X');           
        } else if (val<40) {
            // low eff → red
            $cell.css('background-color', 'red').css('color', '#fff');
        } else if (val<60) {
            // low eff → red
//            $cell.css('background-color', 'red').css('color', '#fff');
        } else if (val < 99) {
            // medium → orange
            $cell.css('background-color', 'green').css('color', '#fff');
        } else {
            // good → green
            $cell.css('background-color', 'green').css('color', '#fff');
        }
    }
 
 



    return nRow;
},

        drawCallback: function() {
            // (You probably meant #qcrecordTable here, not #recordTable)
            $('#qcrecordTable td.column-align-center').css('text-align', 'center');
            $('#qcrecordTable td.column-align-right').css('text-align', 'right');
        },
    ordering: false,   // no sorting at all
    order: [],         // no initial order

    columnDefs: [
        // if you like, can ensure no column is orderable:
        { targets: '_all', orderable: false }
    ],
        pageLength: 10
    });
}   
        function refreshDataTable() {
          table.ajax.reload(null, false); // Reload the data without resetting the current page
        }


        $('#qcrecordTable tbody').on('click', 'tr', function() {
                var rowData = table.row(this).data();
                $('#record_id').val(rowData[0]);
                $("#mc_no1").val(rowData[3]).trigger("change");
                $("#quality_id").val(rowData[5]).trigger("change");
                $('#nospool').val(rowData[7]);
            });
        
            $('#recordTable tbody').on('click', 'tr', function() {
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                } else {
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                }
            });


            $('#windingrepDate, #repshiftName').on('change', function() {
                $('#record_id').val(0);
             
                initDataTable();

//                refreshDataTable();
            });

 

$("#attlmrept").click(function(event){
  event.preventDefault(); 
	//alert ("aaaa");
    initDataTable();
 return false;
});


function chkDataTable() {
  $('#qcrecordTable').DataTable().destroy();
  table = $('#qcrecordTable').DataTable({
                ajax: {
                    url: '<?php echo base_url('admin/reports/Winding_data_reports/get_attwndchkrecords'); ?>',
                    type: 'POST',
                    data: function(d) {
                        d.date = $('#windingrepDate').val();
                        d.shift = $('#repshiftName').val();
                        d.companyId=$('#companyId').val();
                    }
                  },columnDefs: [
                    { targets: [0], visible: true }, // Hide the first column (auto_id)
                    { targets: [3], visible: true },{
                    targets: [5, 6],
                    render: function(data, type, row, meta) {
                        return '<div class="column-align-right">' + data + '</div>';
                    }
                  }
                ],
                "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                   
                if (aData[7] == 0)    {
                  $('td', nRow).css('background-color', 'Red');
                } 
                 },

                drawCallback: function() {
                // Apply alignment styles to the table cells
                $('#recordTable td.column-align-center').css('text-align', 'center');
                $('#recordTable td.column-align-right').css('text-align', 'right');
            },
                order: [[0, 'desc']],                 // Sort by the first column (auto_id) in descending order
                pageLength: 10 // Set the default number of rows per page to 25
              });
        }
  
                   
        $("#exploomdata").click(function(event){
                  event.preventDefault(); 
        	var opt=3;
            var windingperfrDate= $('#windingperfrDate').val();
            var companyId=$('#companyId').val();
            var windingpertoDate=$('#windingpertoDate').val();
            var loomtype= $('#loomtype').val();

            var url = '<?php echo site_url("admin/reports/S4_incentive_report/get_dailyloomdataexl"); ?>' +
                      '?windingperfrDate=' + windingperfrDate +
                      '&windingpertoDate=' + windingpertoDate +
                      '&loomtype=' + loomtype +
                      '&companyId=' + companyId 

                      ;
                      alert(url);
			//$(location).attr('href',url);
			window.open( url, '_blank');
			
			
return false;
});


$("#expmcdata1").click(function(event){
          event.preventDefault(); 
          var windingrepDate = $('#windingrepDate').val();
             var companyId=$('#companyId').val();
             var repshiftName= $('#repshiftName').val(); 
             alert (windingrepDate);
          $.ajax({
            url:  '<?php echo site_url("admin/reports/winding_data_reports/expmcdataexl"); ?>',
            type: "POST",
            data: {windingrepDate: windingrepDate,repshiftName: repshiftName,companyId: companyId
            }
            });
            alert(url);
			//$(location).attr('href',url);
			window.open( url, '_blank');
			
			
return false;
  
        });






</script>



</body>
</html>
