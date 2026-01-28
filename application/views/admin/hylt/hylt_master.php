<!-- /.navbar -->

<?php
use PHPUnit\TextUI\XmlConfiguration\CodeCoverage\Report\Php;
$this->load->view('admin/header'); 
?>

<style>
    #hyltmasterTable {
        border-collapse: collapse;
        width: 100%;
    }

    #hyltmasterTable th,
    #hyltmasterTable td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #hyltmasterTable th {
        background-color: #f2f2f2;
    }

    #hyltmasterTable tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    #hyltmasterTable tr:hover {
        background-color: #ddd;
    }

    .selected {
        background-color: yellow;
    }
    
    #hyltmasterTable td.column-align-center {
        text-align: center;
    }

    #hyltmasterTable td.column-align-right {
        text-align: right;
    }

    /* Spinner styles */
    .spinner-container {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 9999;
        background-color: rgba(255, 255, 255, 0.95);
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
    }

    .spinner-container.show {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .spinner {
        border: 4px solid #f3f3f3;
        border-top: 4px solid #1589FF;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 1s linear infinite;
        margin-bottom: 10px;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .spinner-text {
        color: #1589FF;
        font-weight: bold;
        font-size: 16px;
    }
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-10">
                    <h3 class="m-1 text-dark text-center" style="background-color: #1589FF;">Hylt Master Entry</h3>
                </div>
                <div class="col-sm-2">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url().'admin/home'; ?>">Home</a></li>
                        <li class="breadcrumb-item active">Hylt Master</li>
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
                <form name="hyltMasterForm" id="hyltMasterForm" method="" action="">

                    <div class="form-row">
                        <?php
                        $company_id = $this->session->userdata('company_id');
                        ?>
                        
                        <input type="hidden" class="input" value="<?php echo $company_id; ?>" id="companyId" />
                        <input type="hidden" class="input" id="record_id" />

                        <div class="form-group col-md-2">
                            <label>Q Code<span class="text-danger">*</span></label>
                            <input type="text" name="qcode" id="qcode" value="" 
                                style="height: 50px; color:blue; font-weight: bold; font-size: 38px;"
                                class="form-control text-center" required>
                        </div>

                        <div class="form-group col-md-2">
                            <label>Width</label>
                            <input type="text" name="width" id="width" value="" 
                                style="height: 40px;"
                                class="form-control text-center">
                        </div>

                        <div class="form-group col-md-1">
                            <label>Shots</label>
                            <input type="number" name="shots" id="shots" value="" 
                                style="height: 40px;"
                                class="form-control text-center">
                        </div>

                        <div class="form-group col-md-1">
                            <label>Ports</label>
                            <input type="number" name="ports" id="ports" value="" 
                                style="height: 40px;"
                                class="form-control text-center">
                        </div>

                        <div class="form-group col-md-2">
                            <label>Ozs/Yds</label>
                            <input type="text" name="ozsyds" id="ozsyds" value="" 
                                style="height: 40px;"
                                class="form-control text-center">
                        </div>

                        <div class="form-group col-md-2">
                            <label>I/B</label>
                            <input type="text" name="i_b" id="i_b" value="" 
                                style="height: 40px;"
                                class="form-control text-center">
                        </div>

                        <div class="form-group col-md-1">
                            <label>Unit</label>
                            <input type="text" name="unit" id="unit" value="" 
                                style="height: 40px;"
                                class="form-control text-center" maxlength="3">
                        </div>

                        <div class="form-group col-md-2">
                            <label>Std Weight</label>
                            <input type="text" name="stdwt" id="stdwt" value="" 
                                style="height: 40px;"
                                class="form-control text-center">
                        </div>

                        <div class="form-group col-md-1">
                            <label>J/B/O</label>
                            <input type="text" name="jborbo" id="jborbo" value="" 
                                style="height: 40px;"
                                class="form-control text-center" maxlength="1">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-2" style="margin-left: 20px;">
                            <label for="saveData">Actions<span class="text-center"></span></label>
                            <button name="submit" id="saveData" style="height: 50px;" type="submit" 
                                class="form-control btn btn-primary">Save Data</button>
                            <button name="submit" id="updateData" style="height: 50px;" type="submit" 
                                class="form-control btn btn-success">Update Data</button>
                        </div>
                        <div class="form-group col-md-2">
                            <label>&nbsp;</label>
                            <button name="clear" id="clearData" style="height: 50px;" type="button" 
                                class="form-control btn btn-warning">Clear Form</button>
                        </div>
                    </div>

                    <!-- Spinner Overlay -->
                    <div id="spinnerContainer" class="spinner-container">
                        <div class="spinner"></div>
                        <div class="spinner-text">Processing...</div>
                    </div>

                    <hr style="height:4px; background-color: brown;"></hr>

                    <hr style="height:4px; background-color: brown;"></hr>

                </form>

                <h1>Master Records</h1>
                <table id="hyltmasterTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Q Code</th>
                            <th>Width</th>
                            <th>Shots</th>
                            <th>Ports</th>
                            <th>Ozs/Yds</th>
                            <th>I/B</th>
                            <th>Unit</th>
                            <th>Std Wt</th>
                            <th>J/B/O</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php $this->load->view('admin/footer'); ?>

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
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

<script>
$(function () {
    $('#saveData').show();
    $('#updateData').hide();
    $("#saveData").attr('disabled', true);
    $('#record_id').val('0');
});

// Quality code validation
$(document).ready(function() {
    $('#qcode').on('input', function() {
        var qcode = $('#qcode').val();
        var record_id = $('#record_id').val();
        
        if (qcode.length >= 4) {
            $.ajax({
                url: "<?php echo base_url('admin/Hylt_master/check_qcode'); ?>",
                type: "POST",
                data: {
                    qcode: qcode,
                    record_id: record_id
                },
                dataType: "json",
                success: function(response) {
                    if (response.duplicate) {
                        $('#qcode').css({
                            'border-color': 'red',
                            'background-color': 'orange'
                        });
                        $("#saveData").attr('disabled', true);
                        $("#updateData").attr('disabled', true);
                        alert('Quality code already exists!');
                    } else {
                        $('#qcode').css({
                            'border-color': 'green',
                            'background-color': 'white'
                        });
                        $("#saveData").attr('disabled', false);
                        $("#updateData").attr('disabled', false);
                    }
                }
            });
        }
    });
});

// Initialize DataTable
var table;
initDataTable();

function initDataTable() {
    table = $('#hyltmasterTable').DataTable({
        ajax: {
            url: '<?php echo base_url('admin/Hylt_master/get_records'); ?>',
            type: 'POST'
        },
        columnDefs: [
            { targets: [0], visible: false }, // Hide the ID column
            {
                targets: [2, 3, 4, 5, 6, 8],
                render: function(data, type, row, meta) {
                    return '<div class="column-align-right">' + data + '</div>';
                }
            }
        ],
        drawCallback: function() {
            $('#hyltmasterTable td.column-align-center').css('text-align', 'center');
            $('#hyltmasterTable td.column-align-right').css('text-align', 'right');
        },
        order: [[0, 'desc']],
        pageLength: 10
    });
}

function refreshDataTable() {
    table.ajax.reload(null, false);
}

// Row click handler
$('#hyltmasterTable tbody').on('click', 'tr', function() {
    var rowData = table.row(this).data();
    $('#record_id').val(rowData[0]);
    $('#qcode').val(rowData[1]);
    $('#width').val(rowData[2]);
    $('#shots').val(rowData[3]);
    $('#ports').val(rowData[4]);
    $('#ozsyds').val(rowData[5]);
    $('#i_b').val(rowData[6]);
    $('#unit').val(rowData[7]);
    $('#stdwt').val(rowData[8]);
    $('#jborbo').val(rowData[9]);
    
    $('#updateData').show();
    $('#saveData').hide();
    $("#updateData").attr('disabled', false);
});

$('#hyltmasterTable tbody').on('click', 'tr', function() {
    if ($(this).hasClass('selected')) {
        $(this).removeClass('selected');
    } else {
        table.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
    }
});

// Clear form button
$('#clearData').click(function() {
    clearForm();
});

function clearForm() {
    $('#record_id').val(0);
    $('#qcode').val('');
    $('#width').val('');
    $('#shots').val('');
    $('#ports').val('');
    $('#ozsyds').val('');
    $('#i_b').val('');
    $('#unit').val('');
    $('#stdwt').val('');
    $('#jborbo').val('');
    
    $('#qcode').css({
        'border-color': '',
        'background-color': ''
    });
    
    $('#updateData').hide();
    $('#saveData').show();
    $("#saveData").attr('disabled', true);
    $("#updateData").attr('disabled', true);
    
    table.$('tr.selected').removeClass('selected');
}

// Save button handler
$("#saveData").click(function(event) {
    event.preventDefault();
    
    var qcode = $('#qcode').val();
    if (!qcode) {
        alert('Please enter Quality Code');
        return;
    }
    
    var formData = {
        qcode: qcode,
        width: $('#width').val(),
        shots: $('#shots').val(),
        ports: $('#ports').val(),
        ozsyds: $('#ozsyds').val(),
        i_b: $('#i_b').val(),
        unit: $('#unit').val(),
        stdwt: $('#stdwt').val(),
        jborbo: $('#jborbo').val()
    };
    
    // Show spinner
    $('#spinnerContainer').addClass('show');
    $("#saveData").prop('disabled', true);
    $("#updateData").prop('disabled', true);
    
    $.ajax({
        url: "<?php echo base_url('admin/Hylt_master/save_data'); ?>",
        type: "POST",
        data: formData,
        dataType: "json",
        success: function(response) {
            if (response.success) {
                alert('Record Saved Successfully');
                clearForm();
                refreshDataTable();
            } else {
                alert('Error: ' + response.message);
            }
        },
        complete: function() {
            // Hide spinner
            $('#spinnerContainer').removeClass('show');
            $("#saveData").prop('disabled', false);
            $("#updateData").prop('disabled', false);
        }
    });
});

// Update button handler
$("#updateData").click(function(event) {
    event.preventDefault();
    
    var record_id = $('#record_id').val();
    if (!record_id || record_id == '0') {
        alert('Please select a record to update');
        return;
    }
    
    var qcode = $('#qcode').val();
    if (!qcode) {
        alert('Please enter Quality Code');
        return;
    }
    
    var formData = {
        record_id: record_id,
        qcode: qcode,
        width: $('#width').val(),
        shots: $('#shots').val(),
        ports: $('#ports').val(),
        ozsyds: $('#ozsyds').val(),
        i_b: $('#i_b').val(),
        unit: $('#unit').val(),
        stdwt: $('#stdwt').val(),
        jborbo: $('#jborbo').val()
    };
    
    // Show spinner
    $('#spinnerContainer').addClass('show');
    $("#saveData").prop('disabled', true);
    $("#updateData").prop('disabled', true);
    
    $.ajax({
        url: "<?php echo base_url('admin/Hylt_master/update_data'); ?>",
        type: "POST",
        data: formData,
        dataType: "json",
        success: function(response) {
            if (response.success) {
                alert('Record Updated Successfully');
                clearForm();
                refreshDataTable();
            } else {
                alert('Error: ' + response.message);
            }
        },
        complete: function() {
            // Hide spinner
            $('#spinnerContainer').removeClass('show');
            $("#saveData").prop('disabled', false);
            $("#updateData").prop('disabled', false);
        }
    });
});

</script>

</body>
</html>
