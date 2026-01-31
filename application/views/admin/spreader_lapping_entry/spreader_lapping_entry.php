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
    #sprdlapprecordTable {
        border-collapse: collapse;
        width: 100%;
        font-size: 12px;
    }

    #sprdlapprecordTable th,
    #sprdlapprecordTable td {
        border: 1px solid #ddd;
        padding: 4px;
    }

    #sprdlapprecordTable th {
        background-color: #1589FF;
        color: white;
        font-weight: bold;
    }

    #sprdlapprecordTable tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    #sprdlapprecordTable tr:hover {
        background-color: #ddd;
    }

    .selected {
        background-color: yellow;
    }
    
    #sprdlapprecordTable td.column-align-center {
        text-align: center;
    }

    #sprdlapprecordTable td.column-align-right {
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
        background-color: white;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #1589FF;
        background-color: #fffacd;
        box-shadow: 0 0 0 0.2rem rgba(21, 137, 255, 0.25);
        outline: none;
    }

    input[type="number"]:focus,
    input[type="text"]:focus,
    input[type="date"]:focus,
    textarea:focus {
        background-color: #fffacd !important;
        border-color: #1589FF !important;
        box-shadow: 0 0 5px rgba(21, 137, 255, 0.5) !important;
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
                    <h3 class="m-1 text-dark text-center" style="background-color: #1589FF; color: white;">Spreader Lapping Entry</h3>
                </div>
                <div class="col-sm-2">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url().'admin/home'; ?>">Home</a></li>
                        <li class="breadcrumb-item active">Spreader Lapping Entry</li>
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
                <form name="sprdlappForm" id="sprdlappForm" method="post" action="">

                    <div class="form-row">
                        <?php
                        $company_id = $this->session->userdata('company_id');
                        ?>
                        
                        <input type="hidden" class="input" value="<?php echo $company_id; ?>" id="companyId" />
                        <input type="hidden" class="input" id="sprd_lapp_id" />
                        <input type="hidden" class="input" id="feeder_eb_id" />
                        <input type="hidden" class="input" id="receiver_eb_id" />

                        <div class="form-group col-md-3">
                            <label>Date</label>
                            <input type="text" name="tran_date" id="tran_date" value="" 
                                style="height: 40px;" class="form-control datepicker text-center">
                        </div>

                        <div class="form-group col-md-2">
                            <label>Spell</label>
                            <select name="spell" id="spell" style="height: 40px;" class="form-control">
                                <option value="">Select Spell</option>
                                <option value="A1">A1</option>
                                <option value="B1">B1</option>
                                <option value="A2">A2</option>
                                <option value="B2">B2</option>
                                <option value="C">C</option>
                            </select>
                        </div>

                        <div class="form-group col-md-2">
                            <label>Prod Type</label>
                            <select name="prod_type" id="prod_type" style="height: 40px;" class="form-control">
                                <option value="">Select Type</option>
                                <option value="0">Spreader</option>
                                <option value="1">Lapping</option>
                            </select>
                        </div>

                        <div class="form-group col-md-2">
                            <label>Hours</label>
                            <input type="number" step="0.001" name="hours" id="hours" value="" 
                                style="height: 40px;" class="form-control text-center" >
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label>Machine Name</label>
                            <select name="mechine_id" id="mechine_id" style="height: 50px;" class="form-control">
                                <option value="">Select Machine</option>
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label>Feeder (EBNO)</label>
                            <input type="text" name="feeder_id" id="feeder_id" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>

                        <div class="form-group col-md-3">
                            <label>Feeder Name</label>
                            <input type="text" name="feeder_name" id="feeder_name" value="" 
                                style="height: 40px;" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label>Receiver (EBNO)</label>
                            <input type="text" name="receiver_id" id="receiver_id" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>

                        <div class="form-group col-md-3">
                            <label>Receiver Name</label>
                            <input type="text" name="receiver_name" id="receiver_name" value="" 
                                style="height: 40px;" class="form-control" readonly>
                        </div>

                        <div class="form-group col-md-3">
                            <label>Production</label>
                            <input type="number" step="0.001" name="production" id="production" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>&nbsp;</label>
                            <div style="display: flex; gap: 10px;">
                                <button type="button" class="btn btn-primary" id="saveBtn" style="height: 40px; font-weight: bold;">Save Data    </button>
                                <button type="button" class="btn btn-warning" id="updateBtn" style="height: 40px; font-weight: bold; display: none;">Update Data</button>
                                <button type="button" class="btn btn-danger" id="deleteBtn" style="height: 40px; font-weight: bold; display: none;">Delete Data</button>
                                <button type="button" class="btn btn-secondary" id="clearBtn" style="height: 40px; font-weight: bold;">Clear Data</button>
                                <button type="button" class="btn btn-info" id="importBtn" style="height: 40px; font-weight: bold;">Import (Spreader)</button>
                            </div>
                        </div>
                    </div>

                </form>

                <hr>

                <div class="table-responsive" style="margin-top: 20px;">
                    <table id="sprdlapprecordTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Spell</th>
                                <th>Hours</th>
                                <th>Prod Type</th>
                                <th>Machine</th>
                                <th>Mech Code</th>
                                <th>Feeder EB No</th>
                                <th>Feeder Name</th>
                                <th>Receiver EB No</th>
                                <th>Receiver Name</th>
                                <th>Production</th>
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

    // Initialize Select2 for machine dropdown
    $('#mechine_id').select2({
        placeholder: 'Select Machine',
        allowClear: true,
        width: '100%',
        matcher: function(params, data) {
            if ($.trim(params.term) === '') {
                return data;
            }
            if (typeof data.text === 'undefined') {
                return null;
            }
            if (data.text.toUpperCase().indexOf(params.term.toUpperCase()) > -1) {
                return data;
            }
            return null;
        }
    });

    // Set today's date on page load
    var today = new Date();
    var formattedDate = ("0" + (today.getDate())).slice(-2) + "-" + ("0" + (today.getMonth() + 1)).slice(-2) + "-" + today.getFullYear();
    $('#tran_date').val(formattedDate);

    // Load machine list on page load
    loadMachineList();

    // Load records on date change
    $('#tran_date').on('change', function() {
        loadRecords();
        fetchAndPopulateData();
    });

    // Spell change - set hours automatically
    $('#spell').on('change', function() {
        var spell = $(this).val();
        var hours = getHoursBySpell(spell);
        $('#hours').val(hours);
    });

    // Feeder ID change - fetch feeder name
    $('#feeder_id').on('change', function() {
        if ($(this).val()) {
            fetchWorkerName($(this).val(), 'feeder');
        } else {
            $('#feeder_name').val('');
        }
    });

    // Receiver ID change - fetch receiver name
    $('#receiver_id').on('change', function() {
        if ($(this).val()) {
            fetchWorkerName($(this).val(), 'receiver');
        } else {
            $('#receiver_name').val('');
        }
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
    });

    // Import Button
    $('#importBtn').on('click', function() {
        var date = $('#tran_date').val();
        if (!date) {
            alert('Please select a date first');
            return;
        }

        if (confirm('Are you sure you want to import spreader data for this date?')) {
            importSpreaaderData(date);
        }
    });

    // Edit button click (last column button)
    $(document).on('click', '#sprdlapprecordTable tbody tr td:last-child button', function(e) {
        e.stopPropagation();
        var $btn = $(this);
        var row = $btn.closest('tr');
        var cells = row.find('td');
        var feederId = $btn.data('feeder-id');      // Numeric feeder_id from button data attribute
        var receiverId = $btn.data('receiver-id');  // Numeric receiver_id from button data attribute
     //   alert('edit')        
        var rowData = {
            id: cells.eq(0).text(),              // ID
            date: cells.eq(1).text(),            // Date (dd-m-Y format)
            spell: cells.eq(2).text(),           // Spell
            hours: cells.eq(3).text(),           // Hours
            prodType: cells.eq(4).text(),        // Prod Type
            machineId: cells.eq(5).text(),       // Machine
            mechCode: cells.eq(6).text(),        // Mech Code
            feederEbNo: cells.eq(7).text(),      // Feeder EB No (text display)
            feederName: cells.eq(8).text(),      // Feeder Name
            receiverEbNo: cells.eq(9).text(),    // Receiver EB No (text display)
            receiverName: cells.eq(10).text(),   // Receiver Name
            production: cells.eq(11).text()      // Production
        };
        editRecord(rowData);
    });

    function loadMachineList() {
        $.ajax({
            url: '<?php echo base_url("admin/spreader_lapping_entry/get_mechine_list"); ?>',
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                if (response.success && response.data.length > 0) {
                    var select = $('#mechine_id');
                    select.empty();
                    select.append('<option value="">Select Machine</option>');
                    $.each(response.data, function(index, machine) {
                        select.append('<option value="' + machine.mechine_id + '">' + machine.mechine_name + '</option>');
                    });
                }
            },
            error: function() {
                console.log('Error loading machine list');
            }
        });
    }

    function getHoursBySpell(spell) {
        var hoursMap = {
            'A1': 5,
            'A2': 3,
            'B1': 3,
            'B2': 5,
            'C': 7.5
        };
        return hoursMap[spell] || '';
    }

    function fetchWorkerName(ebno, type) {
        $.ajax({
            url: '<?php echo base_url("admin/spreader_lapping_entry/get_worker_name"); ?>',
            type: 'POST',
            data: {ebno: ebno},
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    if (type === 'feeder') {
                        $('#feeder_name').val(response.data.worker_name || 'Not Found');
                        $('#feeder_eb_id').val(response.data.eb_id || '');
                    } else {
                        $('#receiver_name').val(response.data.worker_name || 'Not Found');
                        $('#receiver_eb_id').val(response.data.eb_id || '');
                    }
                } else {
                    var fieldName = type === 'feeder' ? '#feeder_name' : '#receiver_name';
                    $(fieldName).val('Not Found');
                }
            },
            error: function() {
                var fieldName = type === 'feeder' ? '#feeder_name' : '#receiver_name';
                $(fieldName).val('Error');
            }
        });
    }

    function loadRecords() {
        var date = $('#tran_date').val();
        var compId = $('#companyId').val();
         if (!date) {
            alert('Please select a date');
            return;
        }

        showSpinner();
        
        $.ajax({
            url: '<?php echo base_url("admin/spreader_lapping_entry/get_records"); ?>',
            type: 'POST',
            data: {date: date, compId: compId},
            dataType: 'json',
            success: function(response) {
                hideSpinner();
                var table = $('#sprdlapprecordTable').DataTable();
                table.clear().draw();
                
                if (response.data.length > 0) {
                    $.each(response.data, function(index, record) {
                        table.row.add([
                            record[0],  // ID
                            record[1],  // Date
                            record[2],  // Spell
                            record[3],  // Hours
                            record[4],  // Prod Type
                            record[5],  // Machine
                            record[6],  // Mech Code
                            record[7],  // Feeder EB No
                            record[8],  // Feeder Name
                            record[9], // Receiver EB No (shifted due to numeric IDs)
                            record[10], // Receiver Name (shifted due to numeric IDs)
                            record[11], // Production (shifted due to numeric IDs)
                            '<button class="btn btn-sm btn-info" data-feeder-id="' + record[9] + '" data-receiver-id="' + record[10] + '">Edit</button>'
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
            spell: $('#spell').val(),
            production: $('#production').val(),
            hours: $('#hours').val(),
            feeder_id: $('#feeder_id').val(),
            receiver_id: $('#receiver_id').val(),
            prod_type: $('#prod_type').val(),
            mechine_id: $('#mechine_id').val()
        };

        showSpinner();

        $.ajax({
            url: '<?php echo base_url("admin/spreader_lapping_entry/save_data"); ?>',
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
            sprd_lapp_id: $('#sprd_lapp_id').val(),
            tran_date: $('#tran_date').val(),
            spell: $('#spell').val(),
            production: $('#production').val(),
            hours: $('#hours').val(),
            feeder_id: $('#feeder_id').val(),
            receiver_id: $('#receiver_id').val(),
            prod_type: $('#prod_type').val(),
            mechine_id: $('#mechine_id').val()
        };

        alert(JSON.stringify(formData));
        showSpinner();

        $.ajax({
            url: '<?php echo base_url("admin/spreader_lapping_entry/update_data"); ?>',
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

    function editRecord(rowData) {
        // Populate form from table data (no AJAX call needed)
        $('#sprd_lapp_id').val(rowData.id);
        $('#tran_date').val(rowData.date);
        $('#spell').val(rowData.spell);
        $('#hours').val(rowData.hours);
        
        // Map prod type label back to value
        var prodTypeValue = (rowData.prodType === 'Spreader') ? '0' : '1';
        $('#prod_type').val(prodTypeValue);
        
        $('#mechine_id').val(rowData.machineId).trigger('change');
        $('#feeder_id').val(rowData.feederEbNo);
        $('#feeder_name').val(rowData.feederName);
        $('#receiver_id').val(rowData.receiverEbNo);
        $('#receiver_name').val(rowData.receiverName);
        $('#production').val(rowData.production);
        
        $('#saveBtn').hide();
        $('#updateBtn').show();
        $('#deleteBtn').show();
        
        // Scroll to form
        $('html, body').animate({scrollTop: 0}, 'fast');
    }

    function deleteData() {
        var id = $('#sprd_lapp_id').val();
        
        showSpinner();

        $.ajax({
            url: '<?php echo base_url("admin/spreader_lapping_entry/delete_data"); ?>',
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
        if (!$('#spell').val()) {
            alert('Please select spell');
            return false;
        }
        if (!$('#prod_type').val()) {
            alert('Please select production type');
            return false;
        }
        if (!$('#mechine_id').val()) {
            alert('Please select machine');
            return false;
        }
        return true;
    }

    function clearForm() {
//        $('#sprdlappForm')[0].reset();
        $('#sprd_lapp_id').val('');
//        var today = new Date();
//        var formattedDate = ("0" + (today.getDate())).slice(-2) + "-" + ("0" + (today.getMonth() + 1)).slice(-2) + "-" + today.getFullYear();
        //$('#tran_date').val(formattedDate);
        $('#feeder_name').val('');
        $('#receiver_name').val('');
        //$('#hours').val('');
        $('#production').val('');
        $('#feeder_id').val('');
        $('#receiver_id').val('');
        $('#saveBtn').show();
        $('#updateBtn').hide();
        $('#deleteBtn').hide();
    }

    function formatDate(dateString) {
        // Expected format: yyyy-mm-dd (from database)
        // Convert to dd-mm-yyyy format for datepicker
        if (!dateString) return '';
        
        var parts = dateString.split('-');
        if (parts.length === 3) {
            // Check if first part is 4 digits (year)
            if (parts[0].length === 4) {
                // Format: yyyy-mm-dd
                return parts[2] + "-" + parts[1] + "-" + parts[0];
            }
        }
        return dateString;
    }

    function fetchAndPopulateData() {
        var date = $('#tran_date').val();

        if (!date) {
            return;
        }

        $.ajax({
            url: '<?php echo base_url("admin/spreader_lapping_entry/get_data_by_date"); ?>',
            type: 'POST',
            data: {date: date},
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    var record = response.data;
                    $('#spell').val(record.spell || '');
                    $('#prod_type').val(record.prod_type || '');
                    $('#mechine_id').val(record.mechine_id || '');
                    $('#feeder_id').val(record.feeder_id || '');
                    $('#feeder_name').val(record.feeder_name || '');
                    $('#receiver_id').val(record.receiver_id || '');
                    $('#receiver_name').val(record.receiver_name || '');
                    $('#production').val(record.production || '');
                    $('#hours').val(record.hours || '');
                    $('#sprd_lapp_id').val(record.sprd_lapp_id);
                    $('#saveBtn').hide();
                    $('#updateBtn').show();
                    $('#deleteBtn').show();
                } else {
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

    function importSpreaaderData(date) {
        showSpinner();

        $.ajax({
            url: '<?php echo base_url("admin/spreader_lapping_entry/import_spreader"); ?>',
            type: 'POST',
            data: {date: date},
            dataType: 'json',
            success: function(response) {
                hideSpinner();
                if (response.success) {
                    alert(response.message);
                    clearForm();
                    loadRecords();
                } else {
                    alert(response.message || 'Error importing data');
                }
            },
            error: function() {
                hideSpinner();
                alert('Error importing spreader data');
            }
        });
    }

    // Initialize DataTable
    var table = $('#sprdlapprecordTable').DataTable({
        "paging": true,
        "pageLength": 10,
        "searching": true,
        "ordering": false,
        "info": true
    });

    // Load records on page load
    loadRecords();
});

// Global error handler for unhandled promise rejections
window.addEventListener('unhandledrejection', function(event) {
    console.log('Unhandled promise rejection:', event.reason);
});
</script>
