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
    #miscprodrecordTable {
        border-collapse: collapse;
        width: 100%;
        font-size: 12px;
    }

    #miscprodrecordTable th,
    #miscprodrecordTable td {
        border: 1px solid #ddd;
        padding: 4px;
    }

    #miscprodrecordTable th {
        background-color: #1589FF;
        color: white;
        font-weight: bold;
    }

    #miscprodrecordTable tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    #miscprodrecordTable tr:hover {
        background-color: #ddd;
    }

    .selected {
        background-color: yellow;
    }
    
    #miscprodrecordTable td.column-align-center {
        text-align: center;
    }

    #miscprodrecordTable td.column-align-right {
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
                    <h3 class="m-1 text-dark text-center" style="background-color: #1589FF; color: white;">Misc Prod Entry</h3>
                </div>
                <div class="col-sm-2">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url().'admin/home'; ?>">Home</a></li>
                        <li class="breadcrumb-item active">Misc Prod Entry</li>
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
                <form name="miscprodForm" id="miscprodForm" method="post" action="">

                    <div class="form-row">
                        <?php
                        $company_id = $this->session->userdata('company_id');
                        ?>
                        
                        <input type="hidden" class="input" value="<?php echo $company_id; ?>" id="companyId" />
                        <input type="hidden" class="input" id="misc_prod_ent_id" />

                        <div class="form-group col-md-3">
                            <label for="tran_date">Entry Date<span class="text-center">*</span></label>
                            <input type="text" style="height: 40px; color:blue; font-weight: bold; font-size: 16px;"
                                class="form-control datepicker text-center" id="tran_date" 
                                name="tran_date" readonly required>
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
                            <label>Sliver Wastage</label>
                            <input type="number" step="0.001" name="sliver_wastage" id="sliver_wastage" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>

                        <div class="form-group col-md-2">
                            <label>Hess Wastage</label>
                            <input type="number" step="0.001" name="hess_wastage" id="hess_wastage" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>

                        <div class="form-group col-md-2">
                            <label>Sacking Wastage</label>
                            <input type="number" step="0.001" name="sacking_wastage" id="sacking_wastage" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>

                        <div class="form-group col-md-2">
                            <label>Beaming Wastage</label>
                            <input type="number" step="0.001" name="beaming_wastage" id="beaming_wastage" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>

                        <div class="form-group col-md-2">
                            <label>Winding Wastage</label>
                            <input type="number" step="0.001" name="winding_wastage" id="winding_wastage" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>

                        <div class="form-group col-md-2">
                            <label>Finishing Wastage</label>
                            <input type="number" step="0.001" name="finishing_wastage" id="finishing_wastage" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label>Roll Weight </label>
                            <input type="number" step="0.001" name="roll_weight_wastage" id="roll_weight_wastage" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>

                        <div class="form-group col-md-2">
                            <label>Hands MT Roll</label>
                            <input type="number" step="0.001" name="hands_mt_roll" id="hands_mt_roll" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>

                        <div class="form-group col-md-2">
                            <label>Sale Yarn</label>
                            <input type="number" step="0.001" name="sale_yarn" id="sale_yarn" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>

                        <div class="form-group col-md-2">
                            <label>Purchase Yarn</label>
                            <input type="number" step="0.001" name="purchase_yarn" id="purchase_yarn" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>

                        <div class="form-group col-md-2">
                            <label>Yarn Purchase Hands</label>
                            <input type="number" step="0.001" name="yarn_purchase_hands" id="yarn_purchase_hands" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>

                        <div class="form-group col-md-2">
                            <label>JBO Consumption</label>
                            <input type="number" step="0.001" name="jbo_consumption" id="jbo_consumption" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label>JBO Rate</label>
                            <input type="number" step="0.001" name="jbo_rate" id="jbo_rate" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>

                        <div class="form-group col-md-2">
                            <label>C Acid</label>
                            <input type="number" step="0.001" name="c_acid" id="c_acid" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>

                        <div class="form-group col-md-2">
                            <label>C Acid Rate</label>
                            <input type="number" step="0.001" name="c_acid_rate" id="c_acid_rate" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>

                        <div class="form-group col-md-2">
                            <label>RBO Cons</label>
                            <input type="number" step="0.001" name="rbo_cons" id="rbo_cons" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>

                        <div class="form-group col-md-2">
                            <label>RBO Rate</label>
                            <input type="number" step="0.001" name="rbo_rate" id="rbo_rate" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>

                        <div class="form-group col-md-2">
                            <label>Power Unit</label>
                            <input type="number" name="power_unit" id="power_unit" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label>Adjustment Unit</label>
                            <input type="number" name="adjustment_unit" id="adjustment_unit" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>

                        <div class="form-group col-md-2">
                            <label>Winding WVG Diff</label>
                            <input type="number" step="0.001" name="winding_wvg_diff" id="winding_wvg_diff" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>

                        <div class="form-group col-md-8">
                            <label>&nbsp;</label>
                            <div style="display: flex; gap: 10px;">
                                <button type="button" class="form-control btn btn-primary" id="saveBtn" style="height: 40px; font-weight: bold;">Save</button>
                                <button type="button" class="form-control btn btn-warning" id="updateBtn" style="height: 40px; font-weight: bold; display: none;">Update</button>
                                <button type="button" class="form-control btn btn-danger" id="deleteBtn" style="height: 40px; font-weight: bold; display: none;">Delete</button>
                                <button type="button" class="form-control btn btn-secondary" id="clearBtn" style="height: 40px; font-weight: bold;">Clear</button>
                            </div>
                        </div>
                    </div>

                </form>

                <hr>

                <div class="table-responsive" style="margin-top: 20px;">
                    <table id="miscprodrecordTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Sliver</th>
                                <th>Hess</th>
                                <th>Sacking</th>
                                <th>Beaming</th>
                                <th>Winding</th>
                                <th>Finishing</th>
                                <th>Roll Wt</th>
                                <th>Hands MT</th>
                                <th>Sale Yarn</th>
                                <th>Pur Yarn</th>
                                <th>Pur Hands</th>
                                <th>JBO Cons</th>
                                <th>JBO Rate</th>
                                <th>C Acid</th>
                                <th>C Acid Rate</th>
                                <th>RBO Cons</th>
                                <th>RBO Rate</th>
                                <th>Power</th>
                                <th>Adjust</th>
                                <th>Winding Diff</th>
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
    $('.datepicker').datepicker({
        dateFormat: 'dd-mm-yy',
        changeMonth: true,
        changeYear: true
    });

    // Set today's date on page load
    var today = new Date();
    var formattedDate = ("0" + (today.getDate())).slice(-2) + "-" + ("0" + (today.getMonth() + 1)).slice(-2) + "-" + today.getFullYear();
    $('#tran_date').val(formattedDate);

    // Load records on date change
    $('#tran_date').on('change', function() {
        loadRecords();
        fetchAndPopulateData();
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

    // Table row click for edit
    $(document).on('click', '#miscprodrecordTable tbody tr', function() {
        var id = $(this).find('td:first').text();
        editRecord(id);
    });

    function loadRecords() {
        var date = $('#tran_date').val();
        var compId = $('#companyId').val();

        if (!date) {
            alert('Please select a date');
            return;
        }

        showSpinner();
        
        $.ajax({
            url: '<?php echo base_url("admin/misc_prod_entry/get_records"); ?>',
            type: 'POST',
            data: {date: date, compId: compId},
            dataType: 'json',
            success: function(response) {
                hideSpinner();
                var table = $('#miscprodrecordTable').DataTable();
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
                            record[19],
                            record[20],
                            record[21],
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
            tran_date: $('#tran_date').val(),
            sliver_wastage: $('#sliver_wastage').val(),
            hess_wastage: $('#hess_wastage').val(),
            sacking_wastage: $('#sacking_wastage').val(),
            beaming_wastage: $('#beaming_wastage').val(),
            winding_wastage: $('#winding_wastage').val(),
            finishing_wastage: $('#finishing_wastage').val(),
            roll_weight_wastage: $('#roll_weight_wastage').val(),
            hands_mt_roll: $('#hands_mt_roll').val(),
            sale_yarn: $('#sale_yarn').val(),
            purchase_yarn: $('#purchase_yarn').val(),
            yarn_purchase_hands: $('#yarn_purchase_hands').val(),
            jbo_consumption: $('#jbo_consumption').val(),
            jbo_rate: $('#jbo_rate').val(),
            c_acid: $('#c_acid').val(),
            c_acid_rate: $('#c_acid_rate').val(),
            rbo_cons: $('#rbo_cons').val(),
            rbo_rate: $('#rbo_rate').val(),
            power_unit: $('#power_unit').val(),
            adjustment_unit: $('#adjustment_unit').val(),
            winding_wvg_diff: $('#winding_wvg_diff').val()
        };

        showSpinner();

        $.ajax({
            url: '<?php echo base_url("admin/misc_prod_entry/save_data"); ?>',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                hideSpinner();
                if (response.success) {
                    alert('Record saved successfully');
                    clearForm();
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
            misc_prod_ent_id: $('#misc_prod_ent_id').val(),
            tran_date: $('#tran_date').val(),
            sliver_wastage: $('#sliver_wastage').val(),
            hess_wastage: $('#hess_wastage').val(),
            sacking_wastage: $('#sacking_wastage').val(),
            beaming_wastage: $('#beaming_wastage').val(),
            winding_wastage: $('#winding_wastage').val(),
            finishing_wastage: $('#finishing_wastage').val(),
            roll_weight_wastage: $('#roll_weight_wastage').val(),
            hands_mt_roll: $('#hands_mt_roll').val(),
            sale_yarn: $('#sale_yarn').val(),
            purchase_yarn: $('#purchase_yarn').val(),
            yarn_purchase_hands: $('#yarn_purchase_hands').val(),
            jbo_consumption: $('#jbo_consumption').val(),
            jbo_rate: $('#jbo_rate').val(),
            c_acid: $('#c_acid').val(),
            c_acid_rate: $('#c_acid_rate').val(),
            rbo_cons: $('#rbo_cons').val(),
            rbo_rate: $('#rbo_rate').val(),
            power_unit: $('#power_unit').val(),
            adjustment_unit: $('#adjustment_unit').val(),
            winding_wvg_diff: $('#winding_wvg_diff').val()
        };

        showSpinner();

        $.ajax({
            url: '<?php echo base_url("admin/misc_prod_entry/update_data"); ?>',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                hideSpinner();
                if (response.success) {
                    alert('Record updated successfully');
                    clearForm();
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
            url: '<?php echo base_url("admin/misc_prod_entry/get_record"); ?>',
            type: 'POST',
            data: {id: id},
            dataType: 'json',
            success: function(response) {
                hideSpinner();
                if (response.success) {
                    var record = response.data;
                    $('#misc_prod_ent_id').val(record.misc_prod_ent_id);
                    $('#tran_date').val(formatDate(record.tran_date));
                    $('#sliver_wastage').val(record.sliver_wastage);
                    $('#hess_wastage').val(record.hess_wastage);
                    $('#sacking_wastage').val(record.sacking_wastage);
                    $('#beaming_wastage').val(record.beaming_wastage);
                    $('#winding_wastage').val(record.winding_wastage);
                    $('#finishing_wastage').val(record.finishing_wastage);
                    $('#roll_weight_wastage').val(record.roll_weight_wastage);
                    $('#hands_mt_roll').val(record.hands_mt_roll);
                    $('#sale_yarn').val(record.sale_yarn);
                    $('#purchase_yarn').val(record.purchase_yarn);
                    $('#yarn_purchase_hands').val(record.yarn_purchase_hands);
                    $('#jbo_consumption').val(record.jbo_consumption);
                    $('#jbo_rate').val(record.jbo_rate);
                    $('#c_acid').val(record.c_acid);
                    $('#c_acid_rate').val(record.c_acid_rate);
                    $('#rbo_cons').val(record.rbo_cons);
                    $('#rbo_rate').val(record.rbo_rate);
                    $('#power_unit').val(record.power_unit);
                    $('#adjustment_unit').val(record.adjustment_unit);
                    $('#winding_wvg_diff').val(record.winding_wvg_diff);
                    
                    $('#saveBtn').hide();
                    $('#updateBtn').show();
                    $('#deleteBtn').show();
                    
                    // Scroll to form
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
        var id = $('#misc_prod_ent_id').val();
        
        showSpinner();

        $.ajax({
            url: '<?php echo base_url("admin/misc_prod_entry/delete_data"); ?>',
            type: 'POST',
            data: {id: id},
            dataType: 'json',
            success: function(response) {
                hideSpinner();
                if (response.success) {
                    alert('Record deleted successfully');
                    clearForm();
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
        if (!$('#tran_date').val()) {
            alert('Please select a date');
            return false;
        }
        return true;
    }

    function clearForm() {
        $('#miscprodForm')[0].reset();
        $('#misc_prod_ent_id').val('');
        var today = new Date();
        var formattedDate = ("0" + (today.getDate())).slice(-2) + "-" + ("0" + (today.getMonth() + 1)).slice(-2) + "-" + today.getFullYear();
        $('#tran_date').val(formattedDate);
        $('#saveBtn').show();
        $('#updateBtn').hide();
        $('#deleteBtn').hide();
    }

    function formatDate(dateString) {
        var date = new Date(dateString);
        return ("0" + date.getDate()).slice(-2) + "-" + ("0" + (date.getMonth() + 1)).slice(-2) + "-" + date.getFullYear();
    }

    function fetchAndPopulateData() {
        var date = $('#tran_date').val();
        var compId = $('#companyId').val();

        if (!date) {
            return;
        }

        $.ajax({
            url: '<?php echo base_url("admin/misc_prod_entry/get_data_by_date"); ?>',
            type: 'POST',
            data: {date: date},
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    var record = response.data;
                    // Populate form fields with fetched data
                    $('#sliver_wastage').val(record.sliver_wastage || '');
                    $('#hess_wastage').val(record.hess_wastage || '');
                    $('#sacking_wastage').val(record.sacking_wastage || '');
                    $('#beaming_wastage').val(record.beaming_wastage || '');
                    $('#winding_wastage').val(record.winding_wastage || '');
                    $('#finishing_wastage').val(record.finishing_wastage || '');
                    $('#roll_weight_wastage').val(record.roll_weight_wastage || '');
                    $('#hands_mt_roll').val(record.hands_mt_roll || '');
                    $('#sale_yarn').val(record.sale_yarn || '');
                    $('#purchase_yarn').val(record.purchase_yarn || '');
                    $('#yarn_purchase_hands').val(record.yarn_purchase_hands || '');
                    $('#jbo_consumption').val(record.jbo_consumption || '');
                    $('#jbo_rate').val(record.jbo_rate || '');
                    $('#c_acid').val(record.c_acid || '');
                    $('#c_acid_rate').val(record.c_acid_rate || '');
                    $('#rbo_cons').val(record.rbo_cons || '');
                    $('#rbo_rate').val(record.rbo_rate || '');
                    $('#power_unit').val(record.power_unit || '');
                    $('#adjustment_unit').val(record.adjustment_unit || '');
                    $('#winding_wvg_diff').val(record.winding_wvg_diff || '');
                    
                    // Set record ID and show update/delete buttons
                    $('#misc_prod_ent_id').val(record.misc_prod_ent_id);
                    $('#saveBtn').hide();
                    $('#updateBtn').show();
                    $('#deleteBtn').show();
                } else {
                    // No record found, clear form for new entry
                    clearForm();
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

    // Initialize DataTable
    var table = $('#miscprodrecordTable').DataTable({
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
