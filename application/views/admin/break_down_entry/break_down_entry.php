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
    #breakdownrecordTable {
        border-collapse: collapse;
        width: 100%;
        font-size: 12px;
    }

    #breakdownrecordTable th,
    #breakdownrecordTable td {
        border: 1px solid #ddd;
        padding: 4px;
    }

    #breakdownrecordTable th {
        background-color: #1589FF;
        color: white;
        font-weight: bold;
    }

    #breakdownrecordTable tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    #breakdownrecordTable tr:hover {
        background-color: #ddd;
    }

    .selected {
        background-color: yellow;
    }
    
    #breakdownrecordTable td.column-align-center {
        text-align: center;
    }

    #breakdownrecordTable td.column-align-right {
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

    /* Select2 styling to match input box height */
    .select2-container--bootstrap4 .select2-selection--single {
        height: 40px !important;
        padding: 0 !important;
        border-radius: 4px;
    }

    .select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered {
        line-height: 40px !important;
        padding: 0 12px !important;
    }

    .select2-container--bootstrap4 .select2-selection--single .select2-selection__arrow {
        height: 40px !important;
        top: 0 !important;
    }

    .select2-container--bootstrap4 .select2-selection--single .select2-selection__arrow b {
        top: 50% !important;
        transform: translateY(-50%) !important;
    }
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-10">
                    <h3 class="m-1 text-dark text-center" style="background-color: #1589FF; color: white;">Break Down Entry</h3>
                </div>
                <div class="col-sm-2">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url().'admin/home'; ?>">Home</a></li>
                        <li class="breadcrumb-item active">Break Down Entry</li>
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
                <form name="breakdownForm" id="breakdownForm" method="post" action="">

                    <div class="form-row">
                        <?php
                        $company_id = $this->session->userdata('company_id');
                        ?>
                        
                        <input type="hidden" class="input" value="<?php echo $company_id; ?>" id="companyId" />
                        <input type="hidden" class="input" id="bkd_id" />

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
                        <div class="form-group col-md-3">
                            <label>Machine Name</label>
                            <select name="mechine_id" id="mechine_id" style="height: 40px;" class="form-control">
                                <option value="">Select Machine</option>
                            </select>
                        </div>

                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label>Time From (HH:MM)</label>
                            <input type="text" name="time_from" id="time_from" value="" 
                                style="height: 40px;" class="form-control text-center" placeholder="HH:MM">
                        </div>

                        <div class="form-group col-md-2">
                            <label>Time To (HH:MM)</label>
                            <input type="text" name="time_to" id="time_to" value="" 
                                style="height: 40px;" class="form-control text-center" placeholder="HH:MM">
                        </div>

                        <div class="form-group col-md-2">
                            <label>Total Hours</label>
                            <input type="number" step="0.01" name="total_hours" id="total_hours" value="" 
                                style="height: 40px;" class="form-control text-center">
                        </div>

                        <div class="form-group col-md-5">
                            <label>Remarks</label>
                            <input type="text" name="remarks" id="remarks" value="" 
                                style="height: 40px;" class="form-control">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>&nbsp;</label>
                            <div style="display: flex; gap: 10px;">
                                <button type="button" class="btn btn-primary" id="saveBtn" style="height: 40px; font-weight: bold;">Save Data</button>
                                <button type="button" class="btn btn-warning" id="updateBtn" style="height: 40px; font-weight: bold; display: none;">Update Data</button>
                                <button type="button" class="btn btn-danger" id="deleteBtn" style="height: 40px; font-weight: bold; display: none;">Delete Data</button>
                                <button type="button" class="btn btn-secondary" id="clearBtn" style="height: 40px; font-weight: bold;">Clear Data</button>
                            </div>
                        </div>
                    </div>

                </form>

                <hr>

                <div class="table-responsive" style="margin-top: 20px;">
                    <table id="breakdownrecordTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Spell</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Hours</th>
                                <th>Machine</th>
                                <th>Remarks</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
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
var companyId = "<?php echo $this->session->userdata('company_id'); ?>";
var table;

$(document).ready(function() {
    // Initialize datepicker
    $('.datepicker').datepicker({
        dateFormat: 'dd-mm-yy',
        changeMonth: true,
        changeYear: true
    });

    // Initialize Select2 for spell dropdown
    $('#spell').select2({
        placeholder: 'Select Spell',
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

    // Initialize DataTable
    table = $('#breakdownrecordTable').DataTable({
        paging: true,
        searching: true,
        ordering: false,
        info: true,
        pageLength: 10
    });

    // Load records for today's date
    loadRecords();

    // Button click handlers
    $('#saveBtn').on('click', function() {
        saveData();
    });

    $('#updateBtn').on('click', function() {
        updateData();
    });

    $('#deleteBtn').on('click', function() {
        deleteData();
    });

    $('#clearBtn').on('click', function() {
        clearForm();
    });
});

function showSpinner() {
    $('#spinnerContainer').addClass('show');
}

function hideSpinner() {
    $('#spinnerContainer').removeClass('show');
}

function loadMachineList() {
    $.ajax({
        url: "<?php echo base_url('admin/break_down_entry/get_mechine_list'); ?>",
        type: 'POST',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                var options = '<option value="">-- Select Machine --</option>';
                $.each(response.data, function(key, value) {
                    options += '<option value="' + value.mechine_id + '">' + value.mechine_name + '</option>';
                });
                $('#mechine_id').html(options);
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
            }
        },
        error: function() {
            alert('Error loading machines');
        }
    });
}

function loadRecords() {
    var date = $('#tran_date').val();
    
    if (!date) {
        alert('Please select a date');
        return;
    }

    showSpinner();

    $.ajax({
        url: "<?php echo base_url('admin/break_down_entry/get_records'); ?>",
        type: 'POST',
        data: {
            date: date,
            compId: companyId
        },
        dataType: 'json',
        success: function(response) {
            hideSpinner();
            table.clear();

            if (response.data.length > 0) {
                $.each(response.data, function(key, value) {
                    var btn = '<button class="btn btn-xs btn-info" onclick="editRecord(this)" data-id="' + value[0] + '" data-spell="' + value[2] + '" data-machine-id="' + value[6] + '">Edit</button>';
                    table.row.add([
                        value[0],      // ID
                        value[1],      // Date
                        value[2],      // Spell
                        value[3],      // Time From
                        value[4],      // Time To
                        value[5],      // Total Hours
                        value[7],      // Machine Name
                        value[8],      // Remarks
                        btn            // Edit button
                    ]).draw(false);
                });
            }
            table.draw();
        },
        error: function() {
            hideSpinner();
            alert('Error loading records');
        }
    });
}

function saveData() {
    if (!validateForm()) {
        alert('Please fill all required fields');
        return;
    }

    var formData = {
        tran_date: $('#tran_date').val(),
        spell: $('#spell').val(),
        time_from: $('#time_from').val(),
        time_to: $('#time_to').val(),
        total_hours: $('#total_hours').val(),
        remarks: $('#remarks').val(),
        mechine_id: $('#mechine_id').val()
    };

    showSpinner();

    $.ajax({
        url: "<?php echo base_url('admin/break_down_entry/save_data'); ?>",
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(response) {
            hideSpinner();
            if (response.success) {
                alert(response.message);
                clearForm();
                loadRecords();
            } else {
                alert(response.message);
            }
        },
        error: function() {
            hideSpinner();
            alert('Error saving record');
        }
    });
}

function updateData() {
    if (!validateForm()) {
        alert('Please fill all required fields');
        return;
    }

    var formData = {
        bkd_id: $('#bkd_id').val(),
        tran_date: $('#tran_date').val(),
        spell: $('#spell').val(),
        time_from: $('#time_from').val(),
        time_to: $('#time_to').val(),
        total_hours: $('#total_hours').val(),
        remarks: $('#remarks').val(),
        mechine_id: $('#mechine_id').val()
    };

    showSpinner();

    $.ajax({
        url: "<?php echo base_url('admin/break_down_entry/update_data'); ?>",
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(response) {
            hideSpinner();
            if (response.success) {
                alert(response.message);
                clearForm();
                loadRecords();
            } else {
                alert(response.message);
            }
        },
        error: function() {
            hideSpinner();
            alert('Error updating record');
        }
    });
}

function deleteData() {
    if (confirm('Are you sure you want to delete this record?')) {
        var id = $('#bkd_id').val();

        showSpinner();

        $.ajax({
            url: "<?php echo base_url('admin/break_down_entry/delete_data'); ?>",
            type: 'POST',
            data: { id: id },
            dataType: 'json',
            success: function(response) {
                hideSpinner();
                if (response.success) {
                    alert(response.message);
                    clearForm();
                    loadRecords();
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                hideSpinner();
                alert('Error deleting record');
            }
        });
    }
}

function editRecord(btn) {
    var id = $(btn).data('id');
    var spell = $(btn).data('spell');
    var machineId = $(btn).data('machine-id');
    
    // Get the row data from table
    var row = $(btn).closest('tr');
    var cells = row.find('td');

    $('#bkd_id').val(id);
    $('#tran_date').datepicker('setDate', cells.eq(1).text().trim());
    $('#spell').val(spell).trigger('change');
    $('#time_from').val(cells.eq(3).text().trim());
    $('#time_to').val(cells.eq(4).text().trim());
    $('#total_hours').val(cells.eq(5).text().trim());
    $('#remarks').val(cells.eq(7).text().trim());

    // Set machine
    $('#mechine_id').val(machineId).trigger('change');

    // Show update/delete buttons, hide save button
    $('#saveBtn').hide();
    $('#updateBtn').show();
    $('#deleteBtn').show();

    // Scroll to form
    $('html, body').animate({
        scrollTop: $('#breakdownForm').offset().top - 100
    }, 800);
}

function validateForm() {
    return $('#tran_date').val() !== '' &&
           $('#spell').val() !== '' &&
           $('#time_from').val() !== '' &&
           $('#time_to').val() !== '' &&
           $('#total_hours').val() !== '' &&
           $('#mechine_id').val() !== '';
}

function clearForm() {
    document.getElementById('breakdownForm').reset();
    
    // Set today's date
    var today = new Date();
    var formattedDate = ("0" + (today.getDate())).slice(-2) + "-" + ("0" + (today.getMonth() + 1)).slice(-2) + "-" + today.getFullYear();
    $('#tran_date').val(formattedDate);
    
    $('#bkd_id').val('');
    $('#spell').val('').trigger('change');
    $('#mechine_id').val('').trigger('change');
    $('#saveBtn').show();
    $('#updateBtn').hide();
    $('#deleteBtn').hide();
}

function fetchAndPopulateData() {
    var date = $('#tran_date').val();
    $.ajax({
        url: "<?php echo base_url('admin/break_down_entry/get_data_by_date'); ?>",
        type: 'POST',
        data: { date: date },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                var data = response.data;
                $('#spell').val(data.spell).trigger('change');
                $('#mechine_id').val(data.mechine_id).trigger('change');
            }
        }
    });
}
</script>
