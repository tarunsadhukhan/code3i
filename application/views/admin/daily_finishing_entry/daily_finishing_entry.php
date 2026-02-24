<!-- /.navbar -->

<?php
$this->load->view('admin/header'); 
?>


<!-- Select2 CSS -->
<link rel="stylesheet" href="<?php echo base_url('public/admin/plugins/select2/css/select2.min.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('public/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css'); ?>">

<!-- DataTables CSS -->
<link rel="stylesheet" href="<?php echo base_url('public/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css'); ?>">

<!-- jQuery UI CSS -->
<link rel="stylesheet" href="<?php echo base_url('public/admin/plugins/jquery-ui/jquery-ui.min.css'); ?>">

<style>
    #finishingrecordTable {
        border-collapse: collapse;
        width: 100%;
        font-size: 12px;
    }

    #finishingrecordTable th,
    #finishingrecordTable td {
        border: 1px solid #ddd;
        padding: 4px;
    }

    #finishingrecordTable th {
        background-color: #1589FF;
        color: white;
        font-weight: bold;
    }

    #finishingrecordTable tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    #finishingrecordTable tr:hover {
        background-color: #ddd;
    }

    .selected {
        background-color: yellow;
    }
    
    #finishingrecordTable td.column-align-center {
        text-align: center;
    }

    #finishingrecordTable td.column-align-right {
        text-align: right;
    }

    /* Spinner styles */
    .spinner-container {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.7);
        z-index: 99999;
    }

    .spinner-container.show {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .liquid-loader {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 15px;
        padding: 40px 50px;
        background: rgba(255, 255, 255, 0.95);
        border-radius: 12px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        font-family: system-ui, sans-serif;
    }

    .loader-track {
        position: relative;
        width: 180px;
        height: 32px;
        background: linear-gradient(135deg, #2a2a2a, #1a1a1a);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.6), 0 1px 3px rgba(255, 255, 255, 0.1);
    }

    .liquid-fill {
        position: absolute;
        top: 2px;
        left: 2px;
        height: calc(100% - 4px);
        width: 0%;
        background: linear-gradient(90deg, #1589FF, #40a7ff, #1589FF);
        background-size: 200% 100%;
        border-radius: 14px;
        animation: fillLoader 2s ease-in-out infinite, shimmer 1.5s linear infinite;
        box-shadow: 0 0 10px rgba(21, 137, 255, 0.5);
    }

    @keyframes fillLoader {
        0%, 100% {
            width: 20%;
            left: 2px;
        }
        50% {
            width: 80%;
            left: calc(100% - 80% - 2px);
        }
    }

    @keyframes shimmer {
        0% {
            background-position: 200% 0;
        }
        100% {
            background-position: -200% 0;
        }
    }

    .spinner-text {
        color: #333;
        font-weight: bold;
        font-size: 16px;
        letter-spacing: 1px;
    }

    .form-control {
        border: 1px solid #ced4da;
    }

    .form-control:focus {
        border-color: #1589FF;
        background-color: #fffacd;
        box-shadow: 0 0 0 0.2rem rgba(21, 137, 255, 0.25);
    }

    .btn-primary {
        background-color: #1589FF;
        border-color: #1589FF;
    }

    .btn-primary:hover {
        background-color: #0d6edb;
        border-color: #0d6edb;
    }

    .text-center {
        color: red;
    }
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-10">
                    <h3 class="m-1 text-dark text-center" style="background-color: #1589FF; color: white;">Daily Finishing Entry</h3>
                </div>
                <div class="col-sm-2">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url().'admin/home'; ?>">Home</a></li>
                        <li class="breadcrumb-item active">Daily Finishing Entry</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="card-body">
                <form name="finishingForm" id="finishingForm" method="post" action="">

                    <div class="form-row">
                        <input type="hidden" class="input" id="finishing_id" />

                        <div class="form-group col-md-3">
                            <label for="entry_date">Entry Date<span class="text-center">*</span></label>
                            <input type="text" style="height: 40px; color:blue; font-weight: bold; font-size: 16px;"
                                class="form-control datepicker text-center" id="entry_date" 
                                name="entry_date" readonly required>
                        </div>

                        <div class="form-group col-md-3">
                            <label>&nbsp;</label>
                            <button type="button" class="form-control btn btn-primary" id="loadRecordsBtn" style="height: 40px; font-weight: bold;">Load Records</button>
                        </div>

                        <div class="form-group col-md-3">
                            <label>&nbsp;</label>
                            <button type="button" class="form-control btn btn-success" id="newEntryBtn" style="height: 40px; font-weight: bold;">New Entry</button>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label>WVG Bag</label>
                            <input type="number" name="wvgbag" id="wvgbag" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>

                        <div class="form-group col-md-2">
                            <label>Cutting</label>
                            <input type="number" name="cutting" id="cutting" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>

                        <div class="form-group col-md-2">
                            <label>Cut MC</label>
                            <input type="number" step="0.01" name="cutmc" id="cutmc" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>

                        <div class="form-group col-md-2">
                            <label>HND Cutting</label>
                            <input type="number" name="hndcutting" id="hndcutting" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>
                        <div class="form-group col-md-2">
                            <label>Hemming</label>
                            <input type="number" name="hemming" id="hemming" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>

                        <div class="form-group col-md-2">
                            <label>Hemming MC</label>
                            <input type="number" step="0.01" name="hemmc" id="hemmc" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>

                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label>Union Bags</label>
                            <input type="number" name="sewing" id="sewing" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>
                        <div class="form-group col-md-2">
                            <label>Union Mc</label>
                            <input type="number" step="0.01" name="sewmc" id="sewmc" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>

                        <div class="form-group col-md-2">
                            <label>Herakle</label>
                            <input type="number" name="herakle" id="herakle" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>

                        <div class="form-group col-md-2">
                            <label>Herakle MC</label>
                            <input type="number" step="0.01" name="hermc" id="hermc" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>

                        <div class="form-group col-md-2">
                            <label>Hand Sewing Bags</label>
                            <input type="number" name="hsewing" id="hsewing" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>
                        <div class="form-group col-md-2">
                            <label>Hand Sewing Hands</label>
                            <input type="number" step="0.01" name="hsewingh" id="hsewingh" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>
</div>
                    <div class="form-row">
                        
                        <div class="form-group col-md-2">
                            <label>Press Bags</label>
                            <input type="number" name="press" id="press" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>

                        <div class="form-group col-md-2">
                            <label>Press MC(Skg)</label>
                            <input type="number" step="0.01" name="premc" id="premc" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>

                        <div class="form-group col-md-2">
                            <label>No of Bales Pkd(S)</label>
                            <input type="number" name="inpkbls" id="inpkbls" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>
                        <div class="form-group col-md-2">
                            <label>Repak Bales(S)</label>
                            <input type="number" name="repakbls" id="repakbls" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>
                        <div class="form-group col-md-2">
                            <label>Repak Weight(S)</label>
                            <input type="number" step="0.001" name="repakwt" id="repakwt" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>
                        <div class="form-group col-md-2">
                            <label> Packed (Hess)</label>
                            <input type="number" step="0.001" name="inpkhs" id="inpkhs" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>
                    </div>
                    
                    <div class="form-row">
                    
                    <div class="form-group col-md-2">
                            <label>Packed (SKg)</label>
                            <input type="number" step="0.001" name="inpksk" id="inpksk" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>
                        <div class="form-group col-md-2">
                            <label>Bales Pkd Out</label>
                            <input type="number" name="outpkbls" id="outpkbls" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>
                        <div class="form-group col-md-2">
                            <label>Bales Pkd out (H)</label>
                            <input type="number" step="0.001" name="outpkhs" id="outpkhs" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>
                        <div class="form-group col-md-2">
                            <label>Bales Pkd Out (Skg)</label>
                            <input type="number" step="0.001" name="outpksk" id="outpksk" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>
                        <div class="form-group col-md-2">
                            <label>Press MC (H)</label>
                            <input type="number" step="0.01" name="press_mc_h" id="press_mc_h" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>
                        <div class="form-group col-md-2">
                            <label>Packed Bakram</label>
                            <input type="number" step="0.001" name="packedbk" id="packedbk" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>
</div>

                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label>Packed Sale Twine</label>
                            <input type="number" step="0.001" name="saletwin" id="saletwin" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>
                        <div class="form-group col-md-2">
                            <label>Packed Bales(H)</label>
                            <input type="number" name="inpckbls_h" id="inpckbls_h" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>
                        <div class="form-group col-md-2">
                            <label>Adj Pack Sheet</label>
                            <input type="number" step="0.001" name="packsheet" id="packsheet" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>

                        <div class="form-group col-md-2">
                            <label>Adj Hessian</label>
                            <input type="number" step="0.001" name="adj_hs" id="adj_hs" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>
                        <div class="form-group col-md-2">
                            <label>Repak Bales (H)</label>
                            <input type="number" name="repakbls_h" id="repakbls_h" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>

                        <div class="form-group col-md-2">
                            <label>Adj Sacking</label>
                            <input type="number" step="0.001" name="adj_sk" id="adj_sk" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>


                    </div>

 
                    <div class="form-row">

                        <div class="form-group col-md-2">
                            <label>Adj Sale Yarn</label>
                            <input type="number" step="0.001" name="adj_sy" id="adj_sy" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>
                      <div class="form-group col-md-2">
                            <label>Bale Stock (H)</label>
                            <input type="number" name="bale_stk_h" id="bale_stk_h" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>

                        <div class="form-group col-md-2">
                            <label>Adj Gunny Cutting</label>
                            <input type="number" step="0.001" name="adj_gc" id="adj_gc" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>

                        <div class="form-group col-md-2">
                            <label>Adj Bakram</label>
                            <input type="number" step="0.001" name="adj_bk" id="adj_bk" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>
                    <div class="form-group col-md-2">
                            <label>Bale Stock (S)</label>
                            <input type="number" name="bale_stk_s" id="bale_stk_s" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>
                <div class="form-group col-md-2">
                            <label>YDS</label>
                            <input type="number" name="yds" id="yds" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>
        

                    </div>


                    <div class="form-row d-none">
                
                        <div class="form-group col-md-2">
                            <label>User Code</label>
                            <input type="text" name="user_code" id="user_code" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>

                        <div class="form-group col-md-2">
                            <label>Joint Bags</label>
                            <input type="number" name="joint_bags" id="joint_bags" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>

                        <div class="form-group col-md-2">
                            <label>Joint MC</label>
                            <input type="number" step="0.01" name="joint_mc" id="joint_mc" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>
                    </div>

                    <div class="form-row d-none">
                        <div class="form-group col-md-2">
                            <label>Lapp YDS</label>
                            <input type="number" name="lapp_yds" id="lapp_yds" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>

                        <div class="form-group col-md-2">
                            <label>Lapp MC</label>
                            <input type="number" step="0.01" name="lapp_mc" id="lapp_mc" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>

                        <div class="form-group col-md-2">
                            <label>ExSewing</label>
                            <input type="number" name="exsewing" id="exsewing" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>

                        <div class="form-group col-md-2">
                            <label>ExSew MC</label>
                            <input type="number" step="0.01" name="exsewmc" id="exsewmc" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>


                    </div>

                    <div class="form-row d-none">

                        <div class="form-group col-md-2">
                            <label>Packed SK</label>
                            <input type="number" step="0.001" name="packedsk" id="packedsk" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>
                        <div class="form-group col-md-2">
                            <label>No of Bales Packed(S)</label>
                            <input type="number" name="pckbls" id="pckbls" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>


                         <div class="form-group col-md-2">
                            <label>Packed Bales(H)</label>
                            <input type="number" step="0.001" name="packedhs" id="packedhs" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>

                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>&nbsp;</label>
                            <div style="display: flex; gap: 10px;">
                                <button type="button" class="form-control btn btn-primary" id="saveBtn" style="height: 40px; font-weight: bold; flex: 1;">Save</button>
                                <button type="button" class="form-control btn btn-warning" id="updateBtn" style="height: 40px; font-weight: bold; display: none; flex: 1;">Update</button>
                                <button type="button" class="form-control btn btn-danger" id="deleteBtn" style="height: 40px; font-weight: bold; display: none; flex: 1;">Delete</button>
                                <button type="button" class="form-control btn btn-secondary" id="clearBtn" style="height: 40px; font-weight: bold; flex: 1;">Clear</button>
                                <button type="button" class="form-control btn btn-secondary" id="pressBtn" style="height: 40px; font-weight: bold; flex: 1;">Press Report</button>

                            </div>
                        </div>
                    </div>

                </form>

                <hr>

                <div class="table-responsive" style="margin-top: 20px;">
                    <table id="finishingrecordTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>WVG Bag</th>
                                <th>Cutting</th>
                                <th>Cut MC</th>
                                <th>Hemming</th>
                                <th>Hem MC</th>
                                <th>Sewing</th>
                                <th>Sew MC</th>
                                <th>Herakle</th>
                                <th>Her MC</th>
                                <th>H Sewing</th>
                                <th>Press</th>
                                <th>Press MC</th>
                                <th>PCK Bls</th>
                                <th>Packed HS</th>
                                <th>Pack Sheet</th>
                                <th>Sale Twin</th>
                                <th>User Code</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Spinner Container -->
<div id="spinnerContainer" class="spinner-container">
    <div class="liquid-loader">
        <div class="loader-track">
            <div class="liquid-fill"></div>
        </div>
        <div class="spinner-text">Processing...</div>
    </div>
</div>

<?php
$this->load->view('admin/footer');
?>

<!-- jQuery UI CSS for datepicker -->
<link rel="stylesheet" href="<?php echo base_url('public/admin/plugins/jquery-ui/jquery-ui.min.css'); ?>">

<!-- jQuery UI JS for datepicker -->
<script src="<?php echo base_url('public/admin/plugins/jquery/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('public/admin/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
<script src="<?php echo base_url('public/admin/plugins/jquery-ui/jquery-ui.min.js'); ?>"></script>
<script src="<?php echo base_url('public/admin/plugins/select2/js/select2.full.min.js'); ?>"></script>
<script src="<?php echo base_url('public/admin/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo base_url('public/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js'); ?>"></script>
<script src="<?php echo base_url('public/admin/dist/js/adminlte.min.js'); ?>"></script>

<script>
$(document).ready(function() {
    // Initialize datepicker
    $('#entry_date').datepicker({
        dateFormat: 'dd-mm-yy',
        changeMonth: true,
        changeYear: true,
        onSelect: function(dateText) {
            $(this).val(dateText);
            $(this).trigger('change');
        },
        onClose: function(dateText) {
            $(this).val(dateText);
        }
    });

    // Set today's date on page load
    var today = new Date();
    var formattedDate = ("0" + (today.getDate())).slice(-2) + "-" + ("0" + (today.getMonth() + 1)).slice(-2) + "-" + today.getFullYear();
    $('#entry_date').val(formattedDate);

    // Load records on date change
    $('#entry_date').on('change', function() {
        var selectedDate = $(this).val();
        loadRecords();
        fetchAndPopulateData();
        $(this).val(selectedDate);
    });

    // Load Records Button
    $('#loadRecordsBtn').on('click', function() {
        loadRecords();
    });

    // New Entry Button
    $('#newEntryBtn').on('click', function() {
        clearForm();
        $('#saveBtn').show();
        $('#updateBtn').hide();
        $('#deleteBtn').hide();
    });

    // Save Button
    $('#saveBtn').on('click', function() {
        if (validateForm()) {
            saveData();
        }
    });

    // Update Button
    $('#updateBtn').on('click', function() {
        if (validateForm()) {
            updateData();
        }
    });

    // Delete Button
    $('#deleteBtn').on('click', function() {
        if (confirm('Are you sure you want to delete this record?')) {
            deleteData();
        }
    });

    // Clear Button
    $('#clearBtn').on('click', function() {
        clearForm();
        $('#saveBtn').show();
        $('#updateBtn').hide();
        $('#deleteBtn').hide();
    });

    // Press Report / Export to Excel Button
    $('#pressBtn').on('click', function() {
        var date = $('#entry_date').val();
        if (!date) {
            alert('Please select a date to export');
            return;
        }
        exportToExcel(date);
    });

    // Table row click for edit
    $(document).on('click', '#finishingrecordTable tbody tr', function() {
        var id = $(this).find('td:first').text();
        editRecord(id);
    });

    function loadRecords() {
        var date = $('#entry_date').val();

        if (!date) {
            alert('Please select a date');
            return;
        }

        showSpinner();
        
        $.ajax({
            url: '<?php echo base_url("admin/daily_finishing_entry/get_records"); ?>',
            type: 'POST',
            data: {date: date},
            dataType: 'json',
            success: function(response) {
                hideSpinner();
                var table = $('#finishingrecordTable').DataTable();
                table.clear().draw();
                
                if (response.data.length > 0) {
                    $.each(response.data, function(index, record) {
                        table.row.add([
                            record[0],
                            record[1],
                            record[2],
                            record[3],
                            record[4],
                            record[5],
                            record[6],
                            record[7],
                            record[8],
                            record[9],
                            record[10],
                            record[11],
                            record[12],
                            record[13],
                            record[14],
                            record[15],
                            record[16],
                            record[17],
                            record[18],
                            '<button class="btn btn-sm btn-info">Edit</button>'
                        ]).draw(false);
                    });
                }
            },
            error: function() {
                hideSpinner();
                alert('Error loading records');
            }
        });
    }

    function saveData() {
        var formData = {
            date: $('#entry_date').val(),
            wvgbag: $('#wvgbag').val(),
            cutting: $('#cutting').val(),
            cutmc: $('#cutmc').val(),
            hemming: $('#hemming').val(),
            hemmc: $('#hemmc').val(),
            sewing: $('#sewing').val(),
            sewmc: $('#sewmc').val(),
            herakle: $('#herakle').val(),
            hermc: $('#hermc').val(),
            hsewing: $('#hsewing').val(),
            press: $('#press').val(),
            premc: $('#premc').val(),
            pckbls: $('#pckbls').val(),
            hsewingh: $('#hsewingh').val(),
            packedhs: $('#packedhs').val(),
            yds: $('#yds').val(),
            packsheet: $('#packsheet').val(),
            saletwin: $('#saletwin').val(),
            adj_hs: $('#adj_hs').val(),
            adj_sk: $('#adj_sk').val(),
            adj_sy: $('#adj_sy').val(),
            adj_gc: $('#adj_gc').val(),
            adj_bk: $('#adj_bk').val(),
            packedsk: $('#packedsk').val(),
            packedbk: $('#packedbk').val(),
            outpkbls: $('#outpkbls').val(),
            outpkhs: $('#outpkhs').val(),
            outpksk: $('#outpksk').val(),
            inpkbls: $('#inpkbls').val(),
            inpkhs: $('#inpkhs').val(),
            inpksk: $('#inpksk').val(),
            repakbls: $('#repakbls').val(),
            hndcutting: $('#hndcutting').val(),
            repakwt: $('#repakwt').val(),
            user_code: $('#user_code').val(),
            joint_bags: $('#joint_bags').val(),
            joint_mc: $('#joint_mc').val(),
            lapp_yds: $('#lapp_yds').val(),
            lapp_mc: $('#lapp_mc').val(),
            exsewing: $('#exsewing').val(),
            exsewmc: $('#exsewmc').val(),
            press_mc_h: $('#press_mc_h').val(),
            inpckbls_h: $('#inpckbls_h').val(),
            repakbls_h: $('#repakbls_h').val(),
            bale_stk_h: $('#bale_stk_h').val(),
            bale_stk_s: $('#bale_stk_s').val()
        };

        showSpinner();

        $.ajax({
            url: '<?php echo base_url("admin/daily_finishing_entry/save_data"); ?>',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                hideSpinner();
                if (response.success) {
                    alert('Record saved successfully');
                    clearForm(false);
                    loadRecords();
                } else {
                    alert(response.message || 'Error saving record');
                }
            },
            error: function() {
                hideSpinner();
                alert('Error saving record');
            }
        });
    }

    function updateData() {
        var formData = {
            id: $('#finishing_id').val(),
            date: $('#entry_date').val(),
            wvgbag: $('#wvgbag').val(),
            cutting: $('#cutting').val(),
            cutmc: $('#cutmc').val(),
            hemming: $('#hemming').val(),
            hemmc: $('#hemmc').val(),
            sewing: $('#sewing').val(),
            sewmc: $('#sewmc').val(),
            herakle: $('#herakle').val(),
            hermc: $('#hermc').val(),
            hsewing: $('#hsewing').val(),
            press: $('#press').val(),
            premc: $('#premc').val(),
            pckbls: $('#pckbls').val(),
            hsewingh: $('#hsewingh').val(),
            packedhs: $('#packedhs').val(),
            yds: $('#yds').val(),
            packsheet: $('#packsheet').val(),
            saletwin: $('#saletwin').val(),
            adj_hs: $('#adj_hs').val(),
            adj_sk: $('#adj_sk').val(),
            adj_sy: $('#adj_sy').val(),
            adj_gc: $('#adj_gc').val(),
            adj_bk: $('#adj_bk').val(),
            packedsk: $('#packedsk').val(),
            packedbk: $('#packedbk').val(),
            outpkbls: $('#outpkbls').val(),
            outpkhs: $('#outpkhs').val(),
            outpksk: $('#outpksk').val(),
            inpkbls: $('#inpkbls').val(),
            inpkhs: $('#inpkhs').val(),
            inpksk: $('#inpksk').val(),
            repakbls: $('#repakbls').val(),
            hndcutting: $('#hndcutting').val(),
            repakwt: $('#repakwt').val(),
            joint_bags: $('#joint_bags').val(),
            joint_mc: $('#joint_mc').val(),
            lapp_yds: $('#lapp_yds').val(),
            lapp_mc: $('#lapp_mc').val(),
            exsewing: $('#exsewing').val(),
            exsewmc: $('#exsewmc').val(),
            press_mc_h: $('#press_mc_h').val(),
            inpckbls_h: $('#inpckbls_h').val(),
            repakbls_h: $('#repakbls_h').val(),
            bale_stk_h: $('#bale_stk_h').val(),
            bale_stk_s: $('#bale_stk_s').val()
        };

        showSpinner();

        $.ajax({
            url: '<?php echo base_url("admin/daily_finishing_entry/update_data"); ?>',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                hideSpinner();
                if (response.success) {
                    alert('Record updated successfully');
                    clearForm(false);
                    loadRecords();
                } else {
                    alert(response.message || 'Error updating record');
                }
            },
            error: function() {
                hideSpinner();
                alert('Error updating record');
            }
        });
    }

    function editRecord(id) {
        showSpinner();

        $.ajax({
            url: '<?php echo base_url("admin/daily_finishing_entry/get_record"); ?>',
            type: 'POST',
            data: {id: id},
            dataType: 'json',
            success: function(response) {
                hideSpinner();
                if (response.success) {
                    var record = response.data;
                    $('#finishing_id').val(record.id);
                    $('#entry_date').val(formatDate(record.date));
                    $('#wvgbag').val(record.wvgbag);
                    $('#cutting').val(record.cutting);
                    $('#cutmc').val(record.cutmc);
                    $('#hemming').val(record.hemming);
                    $('#hemmc').val(record.hemmc);
                    $('#sewing').val(record.sewing);
                    $('#sewmc').val(record.sewmc);
                    $('#herakle').val(record.herakle);
                    $('#hermc').val(record.hermc);
                    $('#hsewing').val(record.hsewing);
                    $('#press').val(record.press);
                    $('#premc').val(record.premc);
                    $('#pckbls').val(record.pckbls);
                    $('#hsewingh').val(record.hsewingh);
                    $('#packedhs').val(record.packedhs);
                    $('#yds').val(record.yds);
                    $('#packsheet').val(record.packsheet);
                    $('#saletwin').val(record.saletwin);
                    $('#adj_hs').val(record.adj_hs);
                    $('#adj_sk').val(record.adj_sk);
                    $('#adj_sy').val(record.adj_sy);
                    $('#adj_gc').val(record.adj_gc);
                    $('#adj_bk').val(record.adj_bk);
                    $('#packedsk').val(record.packedsk);
                    $('#packedbk').val(record.packedbk);
                    $('#outpkbls').val(record.outpkbls);
                    $('#outpkhs').val(record.outpkhs);
                    $('#outpksk').val(record.outpksk);
                    $('#inpkbls').val(record.inpkbls);
                    $('#inpkhs').val(record.inpkhs);
                    $('#inpksk').val(record.inpksk);
                    $('#repakbls').val(record.repakbls);
                    $('#hndcutting').val(record.hndcutting);
                    $('#repakwt').val(record.repakwt);
                    $('#user_code').val(record.user_code);
                    $('#joint_bags').val(record.joint_bags);
                    $('#joint_mc').val(record.joint_mc);
                    $('#lapp_yds').val(record.lapp_yds);
                    $('#lapp_mc').val(record.lapp_mc);
                    $('#exsewing').val(record.exsewing);
                    $('#exsewmc').val(record.exsewmc);
                    $('#press_mc_h').val(record.press_mc_h);
                    $('#inpckbls_h').val(record.inpckbls_h);
                    $('#repakbls_h').val(record.repakbls_h);
                    $('#bale_stk_h').val(record.bale_stk_h);
                    $('#bale_stk_s').val(record.bale_stk_s);
                    
                    $('#saveBtn').hide();
                    $('#updateBtn').show();
                    $('#deleteBtn').show();
                    
                    $('html, body').animate({scrollTop: 0}, 'fast');
                } else {
                    alert('Error loading record');
                }
            },
            error: function() {
                hideSpinner();
                alert('Error loading record');
            }
        });
    }

    function deleteData() {
        var id = $('#finishing_id').val();
        
        showSpinner();

        $.ajax({
            url: '<?php echo base_url("admin/daily_finishing_entry/delete_data"); ?>',
            type: 'POST',
            data: {id: id},
            dataType: 'json',
            success: function(response) {
                hideSpinner();
                if (response.success) {
                    alert('Record deleted successfully');
                    clearForm(false);
                    loadRecords();
                } else {
                    alert(response.message || 'Error deleting record');
                }
            },
            error: function() {
                hideSpinner();
                alert('Error deleting record');
            }
        });
    }

    function validateForm() {
        if (!$('#entry_date').val()) {
            alert('Please select a date');
            return false;
        }
        return true;
    }

    function clearForm(resetDate = true) {
        var currentDate = $('#entry_date').val();
        
        $('#finishingForm')[0].reset();
        $('#finishing_id').val('');
        
        if (resetDate) {
            var today = new Date();
            var formattedDate = ("0" + (today.getDate())).slice(-2) + "-" + ("0" + (today.getMonth() + 1)).slice(-2) + "-" + today.getFullYear();
            $('#entry_date').val(formattedDate);
        } else {
            $('#entry_date').val(currentDate);
        }
        
        $('#saveBtn').show();
        $('#updateBtn').hide();
        $('#deleteBtn').hide();
    }

    function formatDate(dateString) {
        var date = new Date(dateString);
        return ("0" + date.getDate()).slice(-2) + "-" + ("0" + (date.getMonth() + 1)).slice(-2) + "-" + date.getFullYear();
    }

    function fetchAndPopulateData() {
        var date = $('#entry_date').val();

        if (!date) {
            return;
        }

        $.ajax({
            url: '<?php echo base_url("admin/daily_finishing_entry/get_data_by_date"); ?>',
            type: 'POST',
            data: {date: date},
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    var record = response.data;
                    $('#wvgbag').val(record.wvgbag || '');
                    $('#cutting').val(record.cutting || '');
                    $('#cutmc').val(record.cutmc || '');
                    $('#hemming').val(record.hemming || '');
                    $('#hemmc').val(record.hemmc || '');
                    $('#sewing').val(record.sewing || '');
                    $('#sewmc').val(record.sewmc || '');
                    $('#herakle').val(record.herakle || '');
                    $('#hermc').val(record.hermc || '');
                    $('#hsewing').val(record.hsewing || '');
                    $('#press').val(record.press || '');
                    $('#premc').val(record.premc || '');
                    $('#pckbls').val(record.pckbls || '');
                    $('#hsewingh').val(record.hsewingh || '');
                    $('#packedhs').val(record.packedhs || '');
                    $('#yds').val(record.yds || '');
                    $('#packsheet').val(record.packsheet || '');
                    $('#saletwin').val(record.saletwin || '');
                    $('#adj_hs').val(record.adj_hs || '');
                    $('#adj_sk').val(record.adj_sk || '');
                    $('#adj_sy').val(record.adj_sy || '');
                    $('#adj_gc').val(record.adj_gc || '');
                    $('#adj_bk').val(record.adj_bk || '');
                    $('#packedsk').val(record.packedsk || '');
                    $('#packedbk').val(record.packedbk || '');
                    $('#outpkbls').val(record.outpkbls || '');
                    $('#outpkhs').val(record.outpkhs || '');
                    $('#outpksk').val(record.outpksk || '');
                    $('#inpkbls').val(record.inpkbls || '');
                    $('#inpkhs').val(record.inpkhs || '');
                    $('#inpksk').val(record.inpksk || '');
                    $('#repakbls').val(record.repakbls || '');
                    $('#hndcutting').val(record.hndcutting || '');
                    $('#repakwt').val(record.repakwt || '');
                    $('#user_code').val(record.user_code || '');
                    $('#joint_bags').val(record.joint_bags || '');
                    $('#joint_mc').val(record.joint_mc || '');
                    $('#lapp_yds').val(record.lapp_yds || '');
                    $('#lapp_mc').val(record.lapp_mc || '');
                    $('#exsewing').val(record.exsewing || '');
                    $('#exsewmc').val(record.exsewmc || '');
                    $('#press_mc_h').val(record.press_mc_h || '');
                    $('#inpckbls_h').val(record.inpckbls_h || '');
                    $('#repakbls_h').val(record.repakbls_h || '');
                    $('#bale_stk_h').val(record.bale_stk_h || '');
                    $('#bale_stk_s').val(record.bale_stk_s || '');
                    
                    $('#finishing_id').val(record.id);
                    $('#saveBtn').hide();
                    $('#updateBtn').show();
                    $('#deleteBtn').show();
                } else {
                    clearForm(false);
                }
            },
            error: function() {
                console.log('Error fetching data for date');
            }
        });
    }

    function showSpinner() {
        $('#spinnerContainer').addClass('show');
    }

    function hideSpinner() {
        $('#spinnerContainer').removeClass('show');
    }

    function exportToExcel(date) {
        showSpinner();
        window.location.href = '<?php echo base_url("admin/daily_finishing_entry/export_excel"); ?>' + '?date=' + encodeURIComponent(date);
        setTimeout(hideSpinner, 1000);
    }

    // Initialize DataTable
    var table = $('#finishingrecordTable').DataTable({
        "paging": true,
        "pageLength": 10,
        "searching": true,
        "ordering": true,
        "info": true
    });

    // Load records on page load
    loadRecords();
});
</script>
