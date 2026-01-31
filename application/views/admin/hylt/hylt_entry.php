<!-- /.navbar -->

<?php
use PHPUnit\TextUI\XmlConfiguration\CodeCoverage\Report\Php;
$this->load->view('admin/header'); 
?>

<style>
    #hyltrecordTable {
        border-collapse: collapse;
        width: 100%;
    }

    #hyltrecordTable th,
    #hyltrecordTable td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #hyltrecordTable th {
        background-color: #f2f2f2;
    }

    #hyltrecordTable tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    #hyltrecordTable tr:hover {
        background-color: #ddd;
    }

    .selected {
        background-color: yellow;
    }
    
    #hyltrecordTable td.column-align-center {
        text-align: center;
    }

    #hyltrecordTable td.column-align-right {
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
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-10">
                    <h3 class="m-1 text-dark text-center" style="background-color: #1589FF;">Daily Hy/Lt Entry</h3>
                </div>
                <div class="col-sm-2">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url().'admin/home'; ?>">Home</a></li>
                        <li class="breadcrumb-item active">Hylt Entry</li>
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
                <form name="hyltForm" id="hyltForm" method="" action="">

                    <div class="form-row">
                        <?php
                        $company_id = $this->session->userdata('company_id');
                        ?>
                        
                        <input type="hidden" class="input" value="<?php echo $company_id; ?>" id="companyId" />
                        <input type="hidden" class="input" id="record_id" />

                        <div class="form-group col-md-2">
                            <label for="tran_date">Entry Date<span class="text-center">*</span></label>
                            <input type="text" style="height: 40px; color:blue; font-weight: bold; font-size: 20px;"
                                class="form-control datepicker text-center" id="tran_date" 
                                name="tran_date" readonly>
                        </div>

                        <div class="form-group col-md-2">
                            <label>Q Code</label>
                            <input type="text" name="qcode" id="qcode" value="" 
                                style="height: 40px; color:blue; font-weight: bold; font-size: 20px;"
                                class="form-control text-center">
                        </div>

                        <div class="form-group col-md-3">
                            <label>Quality</label>
                            <input type="text" name="quality_name" id="quality_name" value="" 
                                style="height: 40px; color:blue; font-weight: bold; font-size: 20px;"
                                class="form-control text-center" readonly>
                        </div>

                        <div class="form-group col-md-2">
                            <label>Orders</label>
                            <input type="text" name="orders" id="orders" value="" 
                                style="height: 40px;"
                                class="form-control text-center">
                        </div>

                        <div class="form-group col-md-2">
                            <label>No of Bales</label>
                            <input type="number" name="bales" id="bales" value="" 
                                style="height: 40px;"
                                class="form-control text-center">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label>Av M/r</label>
                            <input type="text" name="av_mr" id="av_mr" value="" 
                                style="height: 40px;"
                                class="form-control text-center">
                        </div>

                        <div class="form-group col-md-2">
                            <label>Av Std wt/Bale</label>
                            <input type="number" name="av_std" id="av_std" value="" 
                                style="height: 40px;"
                                class="form-control text-center">
                        </div>

                        <div class="form-group col-md-2">
                            <label>Av Obj wt/Bale</label>
                            <input type="number" name="av_obj" id="av_obj" value="" 
                                style="height: 40px;"
                                class="form-control text-center">
                        </div>

                        <div class="form-group col-md-2">
                            <label>Av Cor wt/Bale</label>
                            <input type="number" name="av_cor" id="av_cor" value="" 
                                style="height: 40px;"
                                class="form-control text-center">
                        </div>

                        <div class="form-group col-md-2">
                            <label>Std Weight</label>
                            <input type="text" name="std_wt" id="std_wt" value="" 
                                style="height: 40px;"
                                class="form-control text-center" readonly>
                        </div>

                        <div class="form-group col-md-2">
                            <label>Obj Weight</label>
                            <input type="text" name="obj_wt" id="obj_wt" value="" 
                                style="height: 40px;"
                                class="form-control text-center" readonly>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label>Correct Weight</label>
                            <input type="text" name="cor_wt" id="cor_wt" value="" 
                                style="height: 40px;"
                                class="form-control text-center" readonly>
                        </div>

                        <div class="form-group col-md-2">
                            <label>Diff Weight</label>
                            <input type="text" name="diff_wt" id="diff_wt" value="" 
                                style="height: 40px;"
                                class="form-control text-center" readonly>
                        </div>

                        <div class="form-group col-md-2">
                            <label>Length</label>
                            <input type="text" name="mlen" id="mlen" value="" 
                                style="height: 40px;"
                                class="form-control text-center">
                        </div>

                        <div class="form-group col-md-2">
                            <label>Unit</label>
                            <input type="text" name="unit" id="unit" value="" 
                                style="height: 40px;"
                                class="form-control text-center" readonly>
                        </div>

                        <div class="form-group col-md-2">
                            <label>Hylt Obj</label>
                            <input type="text" name="hylt_obj" id="hylt_obj" value="" 
                                style="height: 40px;"
                                class="form-control text-center" readonly>
                        </div>

                        <div class="form-group col-md-2">
                            <label>Hylt Cor</label>
                            <input type="text" name="hylt_cor" id="hylt_cor" value="" 
                                style="height: 40px;"
                                class="form-control text-center" readonly>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-2" style="margin-left: 20px;">
                            <label for="saveData">Save Data<span class="text-center"></span></label>
                            <button name="submit" id="saveData" style="height: 50px;" type="submit" 
                                class="form-control btn btn-primary">Save Data</button>
                            <button name="submit" id="updateData" style="height: 50px;" type="submit" 
                                class="form-control btn btn-primary">Update Data</button>
                        </div>
                    </div>

                    <hr style="height:4px; background-color: brown;"></hr>

                </form>

                <!-- Spinner Overlay - Outside Form -->
                <div id="spinnerContainer" class="spinner-container">
                    <div class="liquid-loader">
                        <div class="loader-track">
                            <div class="liquid-fill"></div>
                        </div>
                        <div class="spinner-text">Processing...</div>
                    </div>
                </div>

                <h1>Record List</h1>
                <table id="hyltrecordTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Q Code</th>
                            <th>Quality</th>
                            <th>Orders</th>
                            <th>Bales</th>
                            <th>Av M/r</th>
                            <th>Av Std</th>
                            <th>Av Obj</th>
                            <th>Av Cor</th>
                            <th>Std Wt</th>
                            <th>Obj Wt</th>
                            <th>Cor Wt</th>
                            <th>Length</th>
                            <th>Unit</th>
                            <th>Diff Wt</th>
                            <th>Obj %</th>
                            <th>Cor %</th>
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
    
    // Move to next input on Enter key
    $('input, button').on('keydown', function(e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            e.preventDefault();
            
            // If it's the save or update button, trigger click
            if ($(this).is('#saveData, #updateData')) {
                $(this).click();
                return;
            }
            
            var inputs = $('input:visible:not([readonly]):not([disabled])');
            var index = inputs.index(this);
            if (index < inputs.length - 1) {
                inputs.eq(index + 1).focus();
            } else {
                // If on last input, focus on save button
                if ($('#saveData').is(':visible')) {
                    $('#saveData').focus();
                } else if ($('#updateData').is(':visible')) {
                    $('#updateData').focus();
                }
            }
        }
    });
});

// Date picker setup
$("#tran_date").datepicker({ 
    dateFormat: 'dd-mm-yy',
    todayHighlight: 'TRUE',
    autoclose: true,
    maxDate: '0',
});

$('#tran_date').datepicker('setDate', 'today');

// Quality code lookup
$(document).ready(function() {
    $('#qcode').on('blur', function() {
        var qcode = $('#qcode').val();
        var companyId = $('#companyId').val();
        var record_id = $('#record_id').val();
        
        $.ajax({
            url: "<?php echo base_url('admin/Hylt_entry/get_quality'); ?>",
            type: "POST",
            data: {
                qcode: qcode,
                companyId: companyId,
                record_id: record_id
            },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    $('#quality_name').val(response.quality_display);
                        $('#mlen').val(response.i_b);
                    
                        $('#av_std').val(response.stdwt);
                    $('#unit').val(response.unit);
                    $("#saveData").attr('disabled', false);
                    $("#updateData").attr('disabled', false);
                    
                    $('#quality_name').css({
                        'border-color': 'green',
                        'background-color': 'white'
                    });
                } else {
                    $('#quality_name').val('');
                    $('#std_wt').val('');
                    $('#unit').val('');
                    $('#quality_name').css({
                        'border-color': 'red',
                        'background-color': 'yellow'
                    });
                    $("#saveData").attr('disabled', true);
                    $("#updateData").attr('disabled', true);
                }
            }
        });
    });

    // Calculate weights when bales, av_std, av_obj, av_cor change
    function calculateWeights() {
        var bales = parseFloat($('#bales').val()) || 0;
        var av_std = parseFloat($('#av_std').val()) || 0;
        var av_obj = parseFloat($('#av_obj').val()) || 0;
        var av_cor = parseFloat($('#av_cor').val()) || 0;
        
        // Calculate std_wt, obj_wt, cor_wt
        var std_wt = (av_std * bales).toFixed(3);
        var obj_wt = (av_obj * bales).toFixed(3);
        var cor_wt = (av_cor * bales).toFixed(3);
        
        $('#std_wt').val(std_wt);
        $('#obj_wt').val(obj_wt);
        $('#cor_wt').val(cor_wt);
        
        // Calculate diff weight
        var diff = (parseFloat(cor_wt) - parseFloat(std_wt)).toFixed(3);
        $('#diff_wt').val(diff);
        
        // Calculate hylt_obj and hylt_cor
        var std_wt_num = parseFloat(std_wt);
        var obj_wt_num = parseFloat(obj_wt);
        var cor_wt_num = parseFloat(cor_wt);
        
        if (std_wt_num !== 0) {
            var hylt_obj = ((obj_wt_num - std_wt_num) / std_wt_num * 100).toFixed(2);
            var hylt_cor = ((cor_wt_num - std_wt_num) / std_wt_num * 100).toFixed(2);
            
            $('#hylt_obj').val(hylt_obj);
            $('#hylt_cor').val(hylt_cor);
        } else {
            $('#hylt_obj').val('');
            $('#hylt_cor').val('');
        }
    }
    
    // Trigger calculation on input change
    $('#bales, #av_std, #av_obj, #av_cor').on('input', function() {
        calculateWeights();
    });

    // Calculate diff weight when cor_wt or std_wt changes manually
    $('#cor_wt, #std_wt').on('input', function() {
        var cor_wt = parseFloat($('#cor_wt').val()) || 0;
        var std_wt = parseFloat($('#std_wt').val()) || 0;
        var diff = (cor_wt - std_wt).toFixed(3);
        $('#diff_wt').val(diff);
    });

});




// Initialize DataTable
initDataTable();

function initDataTable() {
    table = $('#hyltrecordTable').DataTable({
        ajax: {
            url: '<?php echo base_url('admin/Hylt_entry/get_records'); ?>',
            type: 'POST',
            data: function(d) {
                d.date = $('#tran_date').val();
                d.compId = $('#companyId').val();
            }
        },
        columnDefs: [
            { targets: [0], visible: false }, // Hide the ID column
            {
                targets: [5, 6, 7, 8, 9, 10, 11, 12, 13, 15],
                render: function(data, type, row, meta) {
                    return '<div class="column-align-right">' + data + '</div>';
                }
            }
        ],
        drawCallback: function() {
            $('#hyltrecordTable td.column-align-center').css('text-align', 'center');
            $('#hyltrecordTable td.column-align-right').css('text-align', 'right');
        },
        order: [[0, 'desc']],
        pageLength: 10
    });
}

function refreshDataTable() {
    table.ajax.reload(null, false);
}

// Row click handler
$('#hyltrecordTable tbody').on('click', 'tr', function() {
    var rowData = table.row(this).data();
    $('#record_id').val(rowData[0]);
    $('#qcode').val(rowData[2]);
    $('#quality_name').val(rowData[3]);
    $('#orders').val(rowData[4]);
    $('#bales').val(rowData[5]);
    $('#av_mr').val(rowData[6]);
    $('#av_std').val(rowData[7]);
    $('#av_obj').val(rowData[8]);
    $('#av_cor').val(rowData[9]);
    $('#std_wt').val(rowData[10]);
    $('#obj_wt').val(rowData[11]);
    $('#cor_wt').val(rowData[12]);
    $('#mlen').val(rowData[13]);
    $('#unit').val(rowData[14]);
    $('#diff_wt').val(rowData[15]);
    $('#hylt_obj').val(rowData[16]);
    $('#hylt_cor').val(rowData[17]);
    
    // Trigger qcode lookup to get quality name
    $('#qcode').trigger('input');
    
    $('#updateData').show();
    $('#saveData').hide();
});

$('#hyltrecordTable tbody').on('click', 'tr', function() {
    if ($(this).hasClass('selected')) {
        $(this).removeClass('selected');
    } else {
        table.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
    }
});

// Date change handler
$('#tran_date').on('change', function() {
    clearForm();
    refreshDataTable();
});

function clearForm() {
    $('#record_id').val(0);
    $('#qcode').val('');
    $('#quality_name').val('');
    $('#orders').val('');
    $('#bales').val('');
    $('#av_mr').val('');
    $('#av_std').val('');
    $('#av_obj').val('');
    $('#av_cor').val('');
    $('#std_wt').val('');
    $('#obj_wt').val('');
    $('#cor_wt').val('');
    $('#diff_wt').val('');
    $('#mlen').val('');
    $('#unit').val('');
    $('#hylt_obj').val('');
    $('#hylt_cor').val('');
    
    $('#updateData').hide();
    $('#saveData').show();
    $("#saveData").attr('disabled', true);
    $("#updateData").attr('disabled', true);
}

// Save button handler
$("#saveData").click(function(event) {
    event.preventDefault();
    
    var formData = {
        tran_date: $('#tran_date').val(),
        qcode: $('#qcode').val(),
        orders: $('#orders').val(),
        bales: $('#bales').val(),
        av_mr: $('#av_mr').val(),
        av_std: $('#av_std').val(),
        av_obj: $('#av_obj').val(),
        av_cor: $('#av_cor').val(),
        hylt_obj: $('#hylt_obj').val(),
        hylt_cor: $('#hylt_cor').val(),
        mlen: $('#mlen').val(),
        unit: $('#unit').val(),
        std_wt: $('#std_wt').val(),
        obj_wt: $('#obj_wt').val(),
        cor_wt: $('#cor_wt').val(),
        diff_wt: $('#diff_wt').val()
    };
    alert(JSON.stringify(formData));    
    // Show spinner
    $('#spinnerContainer').addClass('show');
    $("#saveData").prop('disabled', true);
    $("#updateData").prop('disabled', true);
    
    $.ajax({
        url: "<?php echo base_url('admin/Hylt_entry/save_data'); ?>",
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
    
    var formData = {
        record_id: $('#record_id').val(),
        tran_date: $('#tran_date').val(),
        qcode: $('#qcode').val(),
        orders: $('#orders').val(),
        bales: $('#bales').val(),
        av_mr: $('#av_mr').val(),
        av_std: $('#av_std').val(),
        av_obj: $('#av_obj').val(),
        av_cor: $('#av_cor').val(),
        hylt_obj: $('#hylt_obj').val(),
        hylt_cor: $('#hylt_cor').val(),
        mlen: $('#mlen').val(),
        unit: $('#unit').val(),
        std_wt: $('#std_wt').val(),
        obj_wt: $('#obj_wt').val(),
        cor_wt: $('#cor_wt').val(),
        diff_wt: $('#diff_wt').val()
    };
    
    // Show spinner
    $('#spinnerContainer').addClass('show');
    $("#saveData").prop('disabled', true);
    $("#updateData").prop('disabled', true);
    
    $.ajax({
        url: "<?php echo base_url('admin/Hylt_entry/update_data'); ?>",
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
