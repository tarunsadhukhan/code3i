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
    #issuerecordTable {
        border-collapse: collapse;
        width: 100%;
    }

    #issuerecordTable th,
    #issuerecordTable td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }

    #issuerecordTable th {
        background-color: #EBF5FB;
        font-weight: bold;
    }

    #issuerecordTable tr:nth-child(even) {
        background-color: #FFEBCD;
    }

    #issuerecordTable tr:hover {
        background-color: #2E86C1;
    }

    .selected {
        background-color: yellow;
    }

    /* Select2 Custom Styling */
    .select2-selection__rendered {
        line-height: 40px !important;
    }
    
    .select2-container .select2-selection--single {
        height: 40px !important;
        font-size: 14px;
        border: 1px solid #ced4da !important;
    }
    
    .select2-selection__arrow {
        height: 40px !important;
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
</style>

<!-- Content Wrapper -->
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-10">
                    <h3 class="m-1 text-dark text-center" style="background-color: #1589FF;">Issue Entry</h3>
                </div>
                <div class="col-sm-2">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url().'admin/home'; ?>">Home</a></li>
                        <li class="breadcrumb-item active">Issue Entry</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="container-fluid">
            <div class="card-body">
                <form name="issueForm" id="issueForm" method="" action="">

                    <div class="form-row">
                        <?php $company_id = $this->session->userdata('company_id'); ?>
                        
                        <input type="hidden" class="input" value="<?php echo $company_id; ?>" id="companyId" />
                        <input type="hidden" class="input" id="issue_id" />
                        <input type="hidden" class="input" id="editMode" value="0" />

                        <div class="form-group col-md-3">
                            <label for="issuedate">Issue Date<span class="text-danger">*</span></label>
                            <input type="text" style="height: 40px; color:blue; font-weight: bold; font-size: 20px;"
                                class="form-control datepicker text-center" id="issuedate" 
                                name="issuedate" readonly>
                        </div>

                        <div class="form-group col-md-3">
                            <label>Quality<span class="text-danger">*</span></label>
                            <select name="quality" id="quality" class="form-control select2" style="height: 40px;" required>
                                <option value="">Select Quality</option>
                            </select>
                        </div>

                        <div class="form-group col-md-2">
                            <label>Godown<span class="text-danger">*</span></label>
                            <select name="godown" id="godown" class="form-control select2" style="height: 40px;" required>
                                <option value="">Select Godown</option>
                            </select>
                        </div>

                        <div class="form-group col-md-2">
                            <label>Bales<span class="text-danger">*</span></label>
                            <input type="number" name="bales" id="bales" value="" 
                                style="height: 40px;"
                                class="form-control text-center" step="1" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label>Unit<span class="text-danger">*</span></label>
                            <select name="packcode" id="packcode" class="form-control select2" style="height: 40px;" required>
                                <option value="">Select Unit</option>
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label>Weight<span class="text-danger">*</span></label>
                            <input type="number" name="weight" id="weight" value="" 
                                style="height: 40px;"
                                class="form-control text-center" step="0.01" required>
                        </div>

                        <div class="form-group col-md-2">
                            <label>S/Type</label>
                            <input type="text" name="stype" id="stype" value="" 
                                style="height: 40px;"
                                class="form-control text-center">
                        </div>

                        <div class="form-group col-md-1">
                            <label>Jute 01</label>
                            <select name="jute01" id="jute01" class="form-control select2" style="height: 40px;">
                                <option value="">Select</option>
                                <option value="Yes" selected>Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>

                        <div class="form-group col-md-1">
                            <label>Jute 02</label>
                            <select name="jute02" id="jute02" class="form-control select2" style="height: 40px;">
                                <option value="">Select</option>
                                <option value="Yes" selected>Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <button type="submit" class="btn btn-success" style="height: 40px; width: 150px; font-size: 16px; font-weight: bold;">Save Issue</button>
                            <button type="button" class="btn btn-secondary" id="clearForm" style="height: 40px; width: 150px; font-size: 16px; font-weight: bold;">Clear Form</button>
                        </div>
                        <div class="form-group col-md-4 text-right">
                            <button type="button" class="btn" id="importBtn" style="height: 40px; width: 150px; font-size: 16px; font-weight: bold; background-color: #ff9800; color: white; border: none;">Import</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title"><strong>Issue Records</strong></h3>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label>Search by Date</label>
                            <input type="text" class="form-control datepicker" id="searchDate">
                        </div>
                        <div class="form-group col-md-2">
                            <label>&nbsp;</label>
                            <button type="button" class="btn btn-primary" id="searchRecords" style="width: 100%; height: 40px;">Search</button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="issueTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Issue Date</th>
                                    <th>Quality</th>
                                    <th>Godown</th>
                                    <th>Bales</th>
                                    <th>Weight</th>
                                    <th>Unit</th>
                                    <th>S/Type</th>
                                    <th>Jute 01</th>
                                    <th>Jute 02</th>
                                    <th>Action</th>
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
</div>

<div class="spinner-container" id="spinnerContainer">
    <div class="liquid-loader">
        <div class="loader-track">
            <div class="liquid-fill"></div>
        </div>
        <div class="spinner-text">Loading...</div>
    </div>
</div>

<!-- Scripts -->
<script src="<?php echo base_url('public/admin/plugins/jquery/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('public/admin/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
<script src="<?php echo base_url('public/admin/plugins/jquery-ui/jquery-ui.min.js'); ?>"></script>
<script src="<?php echo base_url('public/admin/plugins/select2/js/select2.full.min.js'); ?>"></script>
<script src="<?php echo base_url('public/admin/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo base_url('public/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js'); ?>"></script>
<script src="<?php echo base_url('public/admin/dist/js/adminlte.min.js'); ?>"></script>

<script>
var issueTable;

$(document).ready(function() {
    // Initialize datepickers
    $('.datepicker').datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true
    });

    // Set default dates
    var today = new Date();
    $('#issuedate').val(formatDate(today));
    $('#searchDate').val(formatDate(today));

    // Initialize Select2
    $('.select2').select2({
        width: '100%'
    });

    // Load dropdowns
    loadQualityList();
    loadGodownList();
    loadUnitList();
    
    // Initialize DataTable
    issueTable = $('#issueTable').DataTable({
        pageLength: 10,
        order: [[0, 'desc']]
    });

    // Load today's records
    searchRecords();
});

function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-');
}

function showSpinner(show) {
    if (show) {
        $('#spinnerContainer').addClass('show');
    } else {
        $('#spinnerContainer').removeClass('show');
    }
}

function loadQualityList() {
    $.ajax({
        url: '<?php echo base_url("admin/issueentry/get_quality_list"); ?>',
        type: 'POST',
        dataType: 'json',
        success: function(response) {
            var options = '<option value="">Select Quality</option>';
            $.each(response, function(index, item) {
                options += '<option value="' + item.jcode_id + '" data-code="' + item.jcode + '">' + item.quality + '</option>';
            });
            $('#quality').html(options);
            $('#quality').trigger('change');
        }
    });
}

function loadGodownList() {
    $.ajax({
        url: '<?php echo base_url("admin/issueentry/get_godown_list"); ?>',
        type: 'POST',
        dataType: 'json',
        success: function(response) {
            var options = '<option value="">Select Godown</option>';
            $.each(response, function(index, item) {
                options += '<option value="' + item.id + '">' + item.name + '</option>';
            });
            $('#godown').html(options);
            $('#godown').trigger('change');
        }
    });
}

function loadUnitList() {
    $.ajax({
        url: '<?php echo base_url("admin/issueentry/get_unit_list"); ?>',
        type: 'POST',
        dataType: 'json',
        success: function(response) {
            var options = '<option value="">Select Unit</option>';
            $.each(response, function(index, item) {
                options += '<option value="' + item.pack_id + '">' + item.packing + '</option>';
            });
            $('#packcode').html(options);
            $('#packcode').trigger('change');
        }
    });
}

$('#issueForm').on('submit', function(e) {
    e.preventDefault();

    if (!$('#quality').val() || !$('#godown').val() || !$('#bales').val() || 
        !$('#weight').val() || !$('#packcode').val()) {
        alert('Please fill all required fields');
        return;
    }

    showSpinner(true);

    var formData = {
        issuedate: $('#issuedate').val(),
        jcode_id: $('#quality').val(),
        godown_id: $('#godown').val(),
        bales: $('#bales').val(),
        packcode: $('#packcode').val(),
        weight: $('#weight').val(),
        stype: $('#stype').val(),
        jute01: $('#jute01').val(),
        jute02: $('#jute02').val(),
        editMode: $('#editMode').val(),
        issue_id: $('#issue_id').val()
    };

    var url = $('#editMode').val() == '1' 
        ? '<?php echo base_url("admin/issueentry/update_issue"); ?>'
        : '<?php echo base_url("admin/issueentry/save_issue"); ?>';

    $.ajax({
        url: url,
        type: 'POST',
        data: JSON.stringify(formData),
        contentType: 'application/json',
        dataType: 'json',
        success: function(response) {
            showSpinner(false);
            if (response.success) {
                alert(response.message);
                clearForm();
                searchRecords();
            } else {
                alert(response.message);
            }
        },
        error: function() {
            showSpinner(false);
            alert('Error saving issue');
        }
    });
});

$('#clearForm').on('click', function() {
    clearForm();
});

function clearForm() {
    $('#issueForm')[0].reset();
    $('#editMode').val('0');
    $('#issue_id').val('');
    
    $('#quality').val('').trigger('change');
    $('#godown').val('').trigger('change');
    $('#packcode').val('').trigger('change');
    
    var today = new Date();
    $('#issuedate').val(formatDate(today));
}

$('#searchRecords').on('click', function() {
    searchRecords();
});

$('#searchDate').on('change', function() {
    searchRecords();
});

$('#issuedate').on('change', function() {
     var searchDate = $('#issuedate').val();   
    $('#searchDate').val(searchDate);
    searchRecords();
});



function searchRecords() {
    var searchDate = $('#searchDate').val();
    showSpinner(true);
    
    $.ajax({
        url: '<?php echo base_url("admin/issueentry/get_records"); ?>',
        type: 'POST',
        data: { date: searchDate },
        dataType: 'json',
        success: function(response) {
            showSpinner(false);
            issueTable.clear();

            $.each(response, function(index, record) {
                issueTable.row.add([
                    record.issuedate,
                    record.quality || '',
                    record.godownno || '',
                    record.bales,
                    record.weight,
                    record.packing || '',
                    record.stype || '',
                    record.jute01 || '',
                    record.jute02 || '',
                    '<button class="btn btn-info btn-sm view-issue" data-id="' + record.issue_id + '" data-issuedate="' + record.issuedate + '" data-jcode="' + record.jcode_id + '" data-godown="' + record.godown_id + '" data-bales="' + record.bales + '" data-weight="' + record.weight + '" data-packcode="' + record.packcode + '" data-stype="' + (record.stype || '') + '" data-jute01="' + (record.jute01 || '') + '" data-jute02="' + (record.jute02 || '') + '">Edit</button> ' +
                    '<button class="btn btn-danger btn-sm delete-issue" data-id="' + record.issue_id + '">Delete</button>'
                ]);
            });

            issueTable.draw();
        },
        error: function() {
            showSpinner(false);
        }
    });
}

$(document).on('click', '.view-issue', function() {
    var issueId = $(this).data('id');
    
    // Convert Y/N to Yes/No
    var jute01Value = $(this).data('jute01');
    var jute02Value = $(this).data('jute02');
    
    if (jute01Value === 'Y') jute01Value = 'Yes';
    if (jute01Value === 'N') jute01Value = 'No';
    if (jute02Value === 'Y') jute02Value = 'Yes';
    if (jute02Value === 'N') jute02Value = 'No';
    
    // Populate form from button data attributes
    $('#issue_id').val(issueId);
    $('#issuedate').val($(this).data('issuedate'));
    $('#quality').val($(this).data('jcode')).trigger('change');
    $('#godown').val($(this).data('godown')).trigger('change');
    $('#bales').val($(this).data('bales'));
    $('#packcode').val($(this).data('packcode')).trigger('change');
    $('#weight').val($(this).data('weight'));
    $('#stype').val($(this).data('stype') || '');
    $('#jute01').val(jute01Value || '').trigger('change');
    $('#jute02').val(jute02Value || '').trigger('change');
    
    $('#editMode').val('1');
    
    $('html, body').animate({
        scrollTop: $('#issueForm').offset().top - 100
    }, 500);
});

$(document).on('click', '.delete-issue', function() {
    if (confirm('Are you sure you want to delete this issue?')) {
        var issueId = $(this).data('id');
        showSpinner(true);
        
        $.ajax({
            url: '<?php echo base_url("admin/issueentry/delete_issue_item"); ?>',
            type: 'POST',
            data: { issue_id: issueId },
            dataType: 'json',
            success: function(response) {
                showSpinner(false);
                if (response.success) {
                    alert(response.message);
                    searchRecords();
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                showSpinner(false);
            }
        });
    }
});

$('#importBtn').on('click', function() {
    var issueDate = $('#issuedate').val();
    
    if (!issueDate) {
        alert('Please select an issue date first');
        return;
    }
        showSpinner(true);
        $.ajax({
        url: '<?php echo base_url("admin/issueentry/import_jute_issue"); ?>',
        type: 'POST',
        data: { issue_date: issueDate },
        dataType: 'json',
        success: function(response) {
            showSpinner(false);
            if (response.success) {
                // Populate form with imported data
                if (response.data) {
                    var data = response.data;
                    $('#quality').val(data.jcode_id || '').trigger('change');
                    $('#godown').val(data.godown_id || '').trigger('change');
                    $('#bales').val(data.bales || '');
                    $('#packcode').val(data.packcode || '').trigger('change');
                    $('#weight').val(data.weight || '');
                    $('#stype').val(data.stype || '');
                    
                    // Convert Y/N to Yes/No for jute fields
                    var jute01 = data.jute01 === 'Y' ? 'Yes' : (data.jute01 === 'N' ? 'No' : data.jute01);
                    var jute02 = data.jute02 === 'Y' ? 'Yes' : (data.jute02 === 'N' ? 'No' : data.jute02);
                    
                    $('#jute01').val(jute01 || '').trigger('change');
                    $('#jute02').val(jute02 || '').trigger('change');
                    
                    alert(response.message);
                    
                    // Refresh the table with fresh data
                    searchRecords();
                }
            } else {
                alert(response.message);
            }
        },
        error: function() {
            showSpinner(false);
            alert('Error importing data');
        }
    });
});

</script>

<?php
$this->load->view('admin/footer'); 
?>
