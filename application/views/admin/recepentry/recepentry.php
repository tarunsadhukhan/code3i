<?php
$this->load->view('admin/header'); 
?>

<!-- Select2 CSS -->
<link rel="stylesheet" href="<?php echo base_url('public/admin/plugins/select2/css/select2.min.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('public/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css'); ?>">

 


<style>
    #receprecordTable {
        border-collapse: collapse;
        width: 100%;
    }

    #receprecordTable th,
    #receprecordTable td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
        white-space: nowrap;
    }

    #receprecordTable th {
        background-color: #EBF5FB;
        font-weight: bold;
    }

    #receprecordTable tr:nth-child(even) {
        background-color: #FFEBCD;
    }

    #receprecordTable tr:hover {
        background-color: #2E86C1;
    }

    #receprecordTable tr.grand-total-row {
        background-color: #E8F4F8 !important;
        font-weight: bold;
        border-top: 3px solid #1589FF;
        border-bottom: 3px solid #1589FF;
    }

    #receprecordTable tr.grand-total-row:hover {
        background-color: #E8F4F8 !important;
    }

    #grandTotalTable {
        border-collapse: collapse;
    }

    #grandTotalTable td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
        white-space: nowrap;
    }

    #grandTotalTable tr.grand-total-row {
        background-color: #E8F4F8 !important;
        font-weight: bold;
        border-top: 3px solid #1589FF;
        border-bottom: 3px solid #1589FF;
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

    /* Input Focus Styling */
    input.form-control:focus,
    textarea.form-control:focus {
        background-color: #fffacd !important;
        border-color: #1589FF !important;
        box-shadow: 0 0 5px rgba(21, 137, 255, 0.5) !important;
        outline: none !important;
    }

    /* Select2 Focus Styling */
    .select2-container--bootstrap4.select2-container--focus .select2-selection {
        background-color: #fffacd !important;
        border-color: #1589FF !important;
        box-shadow: 0 0 5px rgba(21, 137, 255, 0.5) !important;
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
        border-radius: 16px;
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
                    <h3 class="m-1 text-dark text-center" style="background-color: #1589FF;">Receipt Entry</h3>
                </div>
                <div class="col-sm-2">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url().'admin/home'; ?>">Home</a></li>
                        <li class="breadcrumb-item active">Receipt Entry</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="container-fluid">
            <div class="card-body">
                <form name="recepForm" id="recepForm" method="" action="">

                    <div class="form-row">
                        <?php $company_id = $this->session->userdata('company_id'); ?>
                        
                        <input type="hidden" class="input" value="<?php echo $company_id; ?>" id="companyId" />
                        <input type="hidden" class="input" id="recpmast_id" />

                        <div class="form-group col-md-2">
                            <label for="inwarddate">Inward Date<span class="text-danger">*</span></label>
                            <input type="text" style="height: 40px; color:blue; font-weight: bold; font-size: 20px;"
                                class="form-control datepicker text-center" id="inwarddate" 
                                name="inwarddate" readonly>
                        </div>

                        <div class="form-group col-md-2">
                            <label>Receipt No.</label>
                            <input type="text" name="recpno" id="recpno" value="" 
                                style="height: 40px; color:blue; font-weight: bold; font-size: 16px;"
                                class="form-control text-center" >
                        </div>

                        <div class="form-group col-md-2">
                            <label>F/Year</label>
                            <input type="text" name="fyyear" id="fyyear" value="" 
                                style="height: 40px;"
                                class="form-control text-center">
                        </div>

                        <div class="form-group col-md-2">
                            <label>Lot No.</label>
                            <input type="text" name="lotno" id="lotno" value="" 
                                style="height: 40px;"
                                class="form-control text-center">
                        </div>

                        <div class="form-group col-md-2">
                            <label>JCI No.</label>
                            <input type="text" name="jcino" id="jcino" value="" 
                                style="height: 40px;"
                                class="form-control text-center">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label>Party<span class="text-danger">*</span></label>
                            <select name="party_id" id="party_id" class="form-control select2" data-placeholder="Select Party">
                                <option value="">Select Party</option>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Broker<span class="text-danger">*</span></label>
                            <select name="broker_id" id="broker_id" class="form-control select2" data-placeholder="Select Broker">
                                <option value="">Select Broker</option>
                            </select>
                        </div>

 
                        <div class="form-group col-md-2">
                            <label>Challan No.</label>
                            <input type="text" name="challno" id="challno" value="" 
                                style="height: 40px;"
                                class="form-control text-center">
                        </div>

                        <div class="form-group col-md-2">
                            <label>Challan Date</label>
                            <input type="text" name="chaldate" id="chaldate" value="" 
                                style="height: 40px;"
                                class="form-control datepicker text-center">
                        </div>
                        <div class="form-group col-md-2">
                            <label>Lorry No.</label>
                            <input type="text" name="lorryno" id="lorryno" value="" 
                                style="height: 40px;"
                                class="form-control text-center">
                        </div>

                    </div>

                    <div class="form-row">

                        <div class="form-group col-md-2">
                            <label>Mukam<span class="text-danger">*</span></label>
                            <select name="agency_id" id="agency_id" class="form-control select2" data-placeholder="Select Agency">
                                <option value="">Select Agency</option>
                            </select>
                        </div>

  
                        <div class="form-group col-md-2">
                            <label>M/R Date</label>
                            <input type="text" name="mrdate" id="mrdate" value="" 
                                style="height: 40px;"
                                class="form-control datepicker text-center">
                        </div>
                        <div class="form-group col-md-2">
                            <label>Rukka No.</label>
                            <input type="text" name="rukkano" id="rukkano" value="" 
                                style="height: 40px;"
                                class="form-control text-center">
                        </div>

                        <div class="form-group col-md-2">
                            <label>Rukka Date</label>
                            <input type="text" name="rukkadate" id="rukkadate" value="" 
                                style="height: 40px;"
                                class="form-control datepicker text-center">
                        </div>

                    </div>

                    <hr style="height:2px; background-color: #1589FF; margin: 20px 0;"></hr>

                    <h4 style="color: #1589FF; font-weight: bold;">Line Items Detail Section</h4>

                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label>Quality<span class="text-danger">*</span></label>
                            <select name="jcodeid" id="jcodeid" class="form-control select2" data-placeholder="Select Quality">
                                <option value="">Select Quality</option>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Godown<span class="text-danger">*</span></label>
                            <select name="godown" id="godown" class="form-control select2" data-placeholder="Select Godown">
                                <option value="">Select Godown</option>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Bales</label>
                            <input type="text" name="bales" id="bales" value="" 
                                style="height: 40px;"
                                class="form-control text-center">
                        </div>
                        <div class="form-group col-md-2">
                            <label>Unit<span class="text-danger">*</span></label>
                            <select name="unit" id="unit" class="form-control select2" data-placeholder="Select Unit">
                                <option value="">Select Unit</option>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label>Weight</label>
                            <input type="text" name="weight" id="weight" value="" 
                                style="height: 40px;"
                                class="form-control text-center">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-2" style="margin-left: 20px;">
                            <label for="addLineItem">&nbsp;</label>
                            <button type="button" id="addLineItem" style="height: 50px;" 
                                class="form-control btn btn-success">
                                <i class="fas fa-plus"></i> Add Line Item
                            </button>
                        </div>
                    </div>

                    <hr style="height:2px; background-color: #1589FF; margin: 20px 0;"></hr>

                    <h4 style="color: #1589FF; font-weight: bold;">Added Line Items</h4>
                    <div class="table-responsive">
                        <table id="lineItemsTable" class="table table-sm table-bordered" style="margin-bottom: 20px;">
                            <thead style="background-color: #EBF5FB;">
                                <tr>
                                    <th style="width: 150px; text-align: center;">Action</th>
                                    <th style="text-align: center;">Quality</th>
                                    <th style="text-align: center;">Godown</th>
                                    <th style="text-align: center;">Bales</th>
                                    <th style="text-align: center;">Unit</th>
                                    <th style="text-align: center;">Weight</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-2" style="margin-left: 20px;">
                            <label for="saveData">Save Data</label>
                            <button name="submit" id="saveData" style="height: 50px;" type="submit" 
                                class="form-control btn btn-primary">Save Data</button>
                            <button name="submit" id="updateData" style="height: 50px; display:none;" type="submit" 
                                class="form-control btn btn-primary">Update Data</button>
                        </div>
                        <div class="form-group col-md-2" style="margin-left: 20px;">
                            <label for="importBtn">&nbsp;</label>
                            <button type="button" class="btn" id="importBtn" style="height: 50px; width: 100%; font-size: 16px; font-weight: bold; background-color: #ff9800; color: white; border: none;">Import</button>
                        </div>
                        <div class="form-group col-md-2" style="margin-left: 20px;">
                            <label for="clearFormBtn">&nbsp;</label>
                            <button type="button" class="btn btn-secondary" id="clearFormBtn" style="height: 50px; width: 100%; font-size: 16px; font-weight: bold;">Clear Form</button>
                        </div>
                    </div>

                    <!-- Spinner Overlay -->
                    <div id="spinnerContainer" class="spinner-container">
                        <div class="liquid-loader">
                            <div class="loader-track">
                                <div class="liquid-fill"></div>
                            </div>
                            <div class="spinner-text">Processing...</div>
                        </div>
                    </div>

                    <hr style="height:4px; background-color: brown;"></hr>

                </form>

                <h1>Receipt Records</h1>
                <table id="receprecordTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Receipt No.</th>
                            <th>Date</th>
                            <th>Party</th>
                            <th>Challan No.</th>
                            <th>Lorry No.</th>
                            <th>Agency</th>
                            <th>Quality</th>
                            <th>Godown</th>
                            <th>Bales</th>
                            <th>Weight</th>
                            <th>Claim Qty</th>
                            <th>Claim Moist</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

                <!-- Grand Total Table -->
                <table id="grandTotalTable" style="width: 100%; margin-top: -1px;">
                    <tbody>
                        <tr class="grand-total-row">
                            <td style="width: 50px;"></td>
                            <td style="width: 100px;"></td>
                            <td style="width: 100px;"></td>
                            <td style="width: 250px;"></td>
                            <td style="width: 100px;"></td>
                            <td style="width: 100px;"></td>
                            <td style="width: 150px;"></td>
                            <td style="width: 150px;"><strong style="color: #1589FF;">GRAND TOTAL</strong></td>
                            <td style="width: 100px;"></td>
                            <td style="width: 80px;"><strong style="color: #1589FF;" id="totalBales">0.00</strong></td>
                            <td style="width: 120px;"><strong style="color: #1589FF;" id="totalWeight">0.00</strong></td>
                            <td style="width: 80px;"></td>
                            <td style="width: 100px;"></td>
                            <td style="width: 150px;"></td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<?php $this->load->view('admin/footer'); ?>

<!-- REQUIRED SCRIPTS -->
<script src="<?php echo base_url()?>public/admin/plugins/jquery/jquery.min.js"></script>
<script src="<?php echo base_url()?>public/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url()?>public/admin/dist/js/adminlte.min.js"></script>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

<!-- Select2 JS (local) -->
<script src="<?php echo base_url('public/admin/plugins/select2/js/select2.full.min.js'); ?>"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

<script>
$(function () {
    $('#saveData').show();
    $('#updateData').hide();
    $("#saveData").attr('disabled', true);
    $('#recpmast_id').val('0');
    
    // Initialize Select2 for all dropdowns with Bootstrap4 theme
    $('.select2').select2({
        theme: 'bootstrap4',
        allowClear: true,
        width: '100%',
        minimumResultsForSearch: 0,
        language: {
            searching: function() {
                return 'Searching...';
            }
        }
    });
    
    // Date picker setup
    $("#inwarddate").datepicker({ 
        dateFormat: 'dd-mm-yy',
        todayHighlight: 'TRUE',
        autoclose: true,
        maxDate: '0'
    });
    
    $(".datepicker").datepicker({
        dateFormat: 'dd-mm-yy',
        autoclose: true
    });

    $('#inwarddate').datepicker('setDate', 'today');

    // Load all dropdowns
    loadPartyList();
    loadAgencyList();
    loadBrokerList();
    loadQualityList();
    loadGodownList();
    loadUnitList();

    // Get fiscal year
    function getFiscalYear(date) {
        var month = date.getMonth() + 1;
        var year = date.getFullYear();
        
        if (month >= 4) {
            return year + '-' + (year + 1).toString().substr(2);
        } else {
            return (year - 1) + '-' + year.toString().substr(2);
        }
    }
    
    $('#inwarddate').on('change', function() {
        var dateStr = $(this).val();
        var parts = dateStr.split('-');
        var date = new Date(parts[2], parts[1] - 1, parts[0]);
        var fy = getFiscalYear(date);
        $('#fyyear').val(fy);
        clearForm();
        refreshDataTable();
    });

    // Party selection
    $('#party_id').on('change', function() {
        var party_id = $(this).val();
        if (!party_id) {
            $('#party_name').val('');
            $("#saveData").attr('disabled', true);
            return;
        }
        
        $.ajax({
            url: "<?php echo base_url('admin/Recepentry/get_party'); ?>",
            type: "POST",
            data: { party_id: party_id },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    $('#party_name').val(response.party);
                    $("#saveData").attr('disabled', false);
                } else {
                    $('#party_name').val('').css('border-color', 'red');
                    $("#saveData").attr('disabled', true);
                }
            }
        });
    });

    // Agency selection
    $('#agency_id').on('change', function() {
        var agency_id = $(this).val();
        if (!agency_id) {
            $('#agency_name').val('');
            return;
        }
        
        $.ajax({
            url: "<?php echo base_url('admin/Recepentry/get_agency'); ?>",
            type: "POST",
            data: { agency_id: agency_id },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    $('#agency_name').val(response.agency);
                }
            }
        });
    });

    // Broker selection
    $('#broker_id').on('change', function() {
        // Broker name is already in the dropdown, no need for AJAX lookup
        var selectedText = $('#broker_id option:selected').text();
    });
});

// Load dropdown lists
function loadPartyList() {
    $.ajax({
        url: "<?php echo base_url('admin/Recepentry/get_party_list'); ?>",
        type: "GET",
        dataType: "json",
        success: function(parties) {
            var options = '<option value="">Select Party</option>';
            $.each(parties, function(index, party) {
                options += '<option value="' + party.party_id + '">' + party.party + '</option>';
            });
            $('#party_id').html(options).trigger('change');
        }
    });
}

function loadAgencyList() {
    $.ajax({
        url: "<?php echo base_url('admin/Recepentry/get_agency_list'); ?>",
        type: "GET",
        dataType: "json",
        success: function(agencies) {
            var options = '<option value="">Select Agency</option>';
            $.each(agencies, function(index, agency) {
                options += '<option value="' + agency.agency_id + '">' + agency.agency + '</option>';
            });
            $('#agency_id').html(options).trigger('change');
        }
    });
}

function loadBrokerList() {
    $.ajax({
        url: "<?php echo base_url('admin/Recepentry/get_broker_list'); ?>",
        type: "GET",
        dataType: "json",
        success: function(brokers) {
            var options = '<option value="">Select Broker</option>';
            $.each(brokers, function(index, broker) {
                options += '<option value="' + broker.broker_id + '">' + broker.broker_name + '</option>';
            });
            $('#broker_id').html(options).trigger('change');
        }
    });
}

function loadQualityList() {
    $.ajax({
        url: "<?php echo base_url('admin/Recepentry/get_quality_list'); ?>",
        type: "GET",
        dataType: "json",
        success: function(qualities) {
            var options = '<option value="">Select Quality</option>';
            $.each(qualities, function(index, quality) {
                options += '<option value="' + quality.jcode_id + '">' + quality.quality + '</option>';
            });
            $('#jcodeid').html(options).trigger('change');
        }
    });
}

function loadGodownList() {
    $.ajax({
        url: "<?php echo base_url('admin/Recepentry/get_godown_list'); ?>",
        type: "GET",
        dataType: "json",
        success: function(godowns) {
            var options = '<option value="">Select Godown</option>';
            $.each(godowns, function(index, godown) {
                options += '<option value="' + godown.id + '">' + godown.name + ' - ' + godown.address + '</option>';
            });
            $('#godown').html(options).trigger('change');
        }
    });
}

function loadUnitList() {
    $.ajax({
        url: "<?php echo base_url('admin/Recepentry/get_unit_list'); ?>",
        type: "GET",
        dataType: "json",
        success: function(units) {
            var options = '<option value="">Select Unit</option>';
            $.each(units, function(index, unit) {
                options += '<option value="' + unit.pack_id + '">' + unit.packing + '</option>';
            });
            $('#unit').html(options).trigger('change');
        }
    });
}

// Initialize DataTable
initDataTable();

function initDataTable() {
    table = $('#receprecordTable').DataTable({
        pageLength: 10,
        order: [[0, 'desc']],
        columnDefs: [
            { targets: [0], visible: false }
        ]
    });
    
    // Update totals when search/filter changes
    table.on('search.dt', function() {
        updateTotalsFromVisibleRows();
    });
    
    table.on('page.dt', function() {
        updateTotalsFromVisibleRows();
    });
}

function updateTotalsFromVisibleRows() {
    try {
        var totalBales = 0;
        var totalWeight = 0;
        
        // Calculate totals from visible rows only
        table.rows({search: 'applied'}).nodes().to$().each(function() {
            var $cells = $(this).find('td');
            if ($cells.length > 0) {
                totalBales += parseFloat($cells.eq(9).text()) || 0;     // bales
                totalWeight += parseFloat($cells.eq(10).text()) || 0;   // weight
            }
        });
        
        // Update grand total table
        $('#totalBales').text(totalBales.toFixed(2));
        $('#totalWeight').text(totalWeight.toFixed(2));
        
    } catch(e) {
        console.error('Error updating totals:', e);
    }
}

function refreshDataTable() {
    $('#spinnerContainer').addClass('show');
    
    $.ajax({
        url: '<?php echo base_url('admin/Recepentry/get_records'); ?>',
        type: 'POST',
        data: { date: $('#inwarddate').val() },
        dataType: 'json',
        success: function(response) {
            $('#spinnerContainer').removeClass('show');
            
            try {
                if (!response.data || response.data.length === 0) {
                    table.clear().draw();
                    $('#totalBales').text('0.00');
                    $('#totalWeight').text('0.00');
                    return;
                }
                
                table.clear();
                
                // Add data rows
                $.each(response.data, function(index, record) {
                    table.row.add([
                        record[0],  // recpmast_id (hidden)
                        record[1],  // recpno
                        record[2],  // inwarddate
                        record[3],  // party
                        record[4],  // challno
                        record[5],  // lorryno
                        record[6],  // agency
                        record[7],  // quality
                        record[8],  // godownno
                        record[9],  // recpbales
                        record[10], // netweight
                        record[11], // claimqt
                        record[12], // claimmoist
                        '<button class="btn btn-info btn-sm view-receipt" data-id="' + record[0] + '" data-recpno="' + record[1] + '" data-inwarddate="' + record[2] + '" data-party="' + record[3] + '" data-challno="' + (record[4] || '') + '" data-lorryno="' + (record[5] || '') + '" data-agency="' + record[6] + '" data-quality="' + record[7] + '" data-godownno="' + record[8] + '" data-recpbales="' + record[9] + '" data-netweight="' + record[10] + '" data-claimqt="' + (record[11] || '') + '" data-claimmoist="' + (record[12] || '') + '">Edit</button> ' +
                        '<button class="btn btn-danger btn-sm delete-receipt" data-id="' + record[0] + '">Delete</button>'
                    ]);
                });
                
                // Draw table
                table.draw();
                
                // Update grand total table from server response
                if (response.totals) {
                    $('#totalBales').text(parseFloat(response.totals.bales).toFixed(2));
                    $('#totalWeight').text(parseFloat(response.totals.weight).toFixed(2));
                }
                
            } catch(e) {
                console.error('Error in refreshDataTable:', e);
                $('#spinnerContainer').removeClass('show');
            }
        },
        error: function(xhr, status, error) {
            $('#spinnerContainer').removeClass('show');
            console.error('AJAX Error:', status, error);
        }
    });
}

// Edit button click handler
$(document).on('click', '.view-receipt', function() {
    var recpmast_id = $(this).data('id');
    loadReceiptForEdit(recpmast_id, $(this));
    
    $('html, body').animate({
        scrollTop: $('#recepForm').offset().top - 100
    }, 500);
});

// Delete button click handler
$(document).on('click', '.delete-receipt', function() {
    if (confirm('Are you sure you want to delete this receipt?')) {
        var recpmast_id = $(this).data('id');
        $('#spinnerContainer').addClass('show');
        
        $.ajax({
            url: '<?php echo base_url("admin/Recepentry/delete_receipt"); ?>',
            type: 'POST',
            data: { recpmast_id: recpmast_id },
            dataType: 'json',
            success: function(response) {
                $('#spinnerContainer').removeClass('show');
                if (response.success) {
                    alert(response.message);
                    refreshDataTable();
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                $('#spinnerContainer').removeClass('show');
            }
        });
    }
});

// Function to load receipt data for editing
function loadReceiptForEdit(recpmast_id, buttonElement) {
    $('#recpmast_id').val(recpmast_id);
    
    // Get data from button attributes
    $('#recpno').val(buttonElement.data('recpno'));
    $('#inwarddate').val(formatDateForInput(buttonElement.data('inwarddate')));
    $('#challno').val(buttonElement.data('challno') || '');
    $('#lorryno').val(buttonElement.data('lorryno') || '');
    $('#claimqt').val(buttonElement.data('claimqt') || '');
    $('#claimmoist').val(buttonElement.data('claimmoist') || '');
    
    // Fetch complete receipt data for additional fields and line items
    $.ajax({
        url: "<?php echo base_url('admin/Recepentry/get_receipt_data'); ?>",
        type: "POST",
        data: { recpmast_id: recpmast_id },
        dataType: "json",
        success: function(response) {
            if (response.success) {
                var header = response.data.header;
                var items = response.data.items;
                
                // Populate remaining header fields
                $('#fyyear').val(header.fyyear);
                $('#lotno').val(header.lotno || '');
                $('#jcino').val(header.jcino || '');
                $('#chaldate').val(formatDateForInput(header.chaldate));
                $('#mrdate').val(formatDateForInput(header.mrdate));
                $('#rukkano').val(header.rukkano || '');
                $('#rukkadate').val(formatDateForInput(header.rukkadate));
                
                // Set Party
                $('#party_id').val(header.partcode).trigger('change');
                
                // Set Agency
                $('#agency_id').val(header.agcode).trigger('change');
                
                // Set Broker
                $('#broker_id').val(header.brcode).trigger('change');
                
                // Clear and populate line items
                lineItems = [];
                lineItemCounter = 0;
                $('#lineItemsTable tbody').html('');
                
                $.each(items, function(index, item) {
                    var lineItem = {
                        id: lineItemCounter++,
                        jcodeid: item.jcode_id,
                        jcodeName: item.quality,
                        godown: item.godown_id,
                        godownName: item.godownname,
                        bales: item.recpbales || '0',
                        unit: item.packcode,
                        unitName: item.packing,
                        weight: item.netweight || '0'
                    };
                    
                    lineItems.push(lineItem);
                    addLineItemToTable(lineItem);
                });
                
                $('#updateData').show();
                $('#saveData').hide();
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function(xhr, status, error) {
            alert('Error loading receipt data: ' + error);
        }
    });
}



// Store line items in array
var lineItems = [];
var lineItemCounter = 0;
var editingLineItemId = null; // Track which line item is being edited

// Helper function to format date for input field
function formatDateForInput(dateStr) {
    if (!dateStr) return '';
    
    // If already in dd-mm-yyyy format, return as is
    if (dateStr.match(/^\d{2}-\d{2}-\d{4}$/)) {
        return dateStr;
    }
    
    // Convert from yyyy-mm-dd to dd-mm-yyyy
    if (dateStr.match(/^\d{4}-\d{2}-\d{2}$/)) {
        var parts = dateStr.split('-');
        return parts[2] + '-' + parts[1] + '-' + parts[0];
    }
    
    return dateStr;
}

// Add Line Item button handler
$("#addLineItem").click(function() {
    // Validate line item fields
    if (!$('#jcodeid').val()) {
        alert('Please select Quality');
        return;
    }
    if (!$('#godown').val()) {
        alert('Please select Godown');
        return;
    }
    if (!$('#unit').val()) {
        alert('Please select Unit');
        return;
    }
    
    var qualityText = $('#jcodeid option:selected').text();
    var godownText = $('#godown option:selected').text();
    var unitText = $('#unit option:selected').text();
    
    // Check if we're updating an existing line item
    if (editingLineItemId !== null) {
        // Update existing line item
        var lineItem = lineItems.find(function(item) {
            return item.id === editingLineItemId;
        });
        
        if (lineItem) {
            lineItem.jcodeid = $('#jcodeid').val();
            lineItem.jcodeName = qualityText;
            lineItem.godown = $('#godown').val();
            lineItem.godownName = godownText;
            lineItem.bales = $('#bales').val() || '0';
            lineItem.unit = $('#unit').val();
            lineItem.unitName = unitText;
            lineItem.weight = $('#weight').val() || '0';
            
            // Update table row
            $('#lineItem_' + editingLineItemId).html(
                '<td style="text-align: center;">' +
                '<button type="button" class="btn btn-sm btn-warning editLineItem" data-id="' + lineItem.id + '" title="Edit">' +
                '<i class="fas fa-edit"></i> Edit' +
                '</button> ' +
                '<button type="button" class="btn btn-sm btn-danger deleteLineItem" data-id="' + lineItem.id + '" title="Delete">' +
                '<i class="fas fa-trash"></i> Delete' +
                '</button>' +
                '</td>' +
                '<td style="text-align: center;">' + lineItem.jcodeName + '</td>' +
                '<td style="text-align: center;">' + lineItem.godownName + '</td>' +
                '<td style="text-align: center;">' + lineItem.bales + '</td>' +
                '<td style="text-align: center;">' + lineItem.unitName + '</td>' +
                '<td style="text-align: center;">' + lineItem.weight + '</td>'
            );
        }
        
        // Reset editing mode
        editingLineItemId = null;
        $(this).html('<i class="fas fa-plus"></i> Add Line Item').removeClass('btn-warning').addClass('btn-success');
    } else {
        // Check if in edit mode - only block adding NEW items when editing a receipt
        if ($('#updateData').is(':visible')) {
            alert('Cannot add new line items while editing. Please modify existing items only.');
            return;
        }
        
        // Add new line item (only in add mode)
        var lineItem = {
            id: lineItemCounter++,
            jcodeid: $('#jcodeid').val(),
            jcodeName: qualityText,
            godown: $('#godown').val(),
            godownName: godownText,
            bales: $('#bales').val() || '0',
            unit: $('#unit').val(),
            unitName: unitText,
            weight: $('#weight').val() || '0'
        };
        
        lineItems.push(lineItem);
        addLineItemToTable(lineItem);
    }
    
    // Clear line item fields
    $('#jcodeid').val('');
    $('#godown').val('');
    $('#bales').val('');
    $('#unit').val('');
    $('#weight').val('');
    $('#jcodeid').trigger('change');
    $('#godown').trigger('change');
    $('#unit').trigger('change');
});

// Add line item to display table
function addLineItemToTable(item) {
    var row = '<tr id="lineItem_' + item.id + '">' +
        '<td style="text-align: center;">' +
        '<button type="button" class="btn btn-sm btn-warning editLineItem" data-id="' + item.id + '" title="Edit">' +
        '<i class="fas fa-edit"></i> Edit' +
        '</button> ' +
        '<button type="button" class="btn btn-sm btn-danger deleteLineItem" data-id="' + item.id + '" title="Delete">' +
        '<i class="fas fa-trash"></i> Delete' +
        '</button>' +
        '</td>' +
        '<td style="text-align: center;">' + item.jcodeName + '</td>' +
        '<td style="text-align: center;">' + item.godownName + '</td>' +
        '<td style="text-align: center;">' + item.bales + '</td>' +
        '<td style="text-align: center;">' + item.unitName + '</td>' +
        '<td style="text-align: center;">' + item.weight + '</td>' +
        '</tr>';
    
    $('#lineItemsTable tbody').append(row);
}

// Edit line item from table
$(document).on('click', '.editLineItem', function() {
    var itemId = $(this).data('id');
    var lineItem = lineItems.find(function(item) {
        return item.id === itemId;
    });
    
    if (!lineItem) return;
    
    // Populate form fields with line item data
    $('#jcodeid').val(lineItem.jcodeid).trigger('change');
    
    // Set godown with a small delay to ensure Select2 is ready
    setTimeout(function() {
        $('#godown').val(lineItem.godown).trigger('change');
    }, 100);
    
    $('#bales').val(lineItem.bales);
    $('#unit').val(lineItem.unit).trigger('change');
    $('#weight').val(lineItem.weight);
    
    // Set editing mode
    editingLineItemId = itemId;
    
    // Change button text and styling for update mode
    $('#addLineItem').html('<i class="fas fa-save"></i> Update Line Item').removeClass('btn-success').addClass('btn-warning');
    
    // Scroll to form
    $('html, body').animate({
        scrollTop: $('#jcodeid').offset().top - 100
    }, 300);
});

// Delete line item from table
$(document).on('click', '.deleteLineItem', function() {
    var itemId = $(this).data('id');
    
    // Remove from array
    lineItems = lineItems.filter(function(item) {
        return item.id !== itemId;
    });
    
    // Remove from table
    $('#lineItem_' + itemId).remove();
});

function clearForm() {
    $('#recpmast_id').val(0);
    $('#recpno').val('');
    $('#lotno').val('');
    $('#jcino').val('');
    $('#challno').val('');
    $('#chaldate').val('');
    $('#lorryno').val('');
    $('#mrdate').val('');
    $('#rukkano').val('');
    $('#rukkadate').val('');
    
    // Clear select2 dropdowns
    $('#party_id').val('').trigger('change');
    $('#agency_id').val('').trigger('change');
    $('#broker_id').val('').trigger('change');
    $('#jcodeid').val('').trigger('change');
    $('#godown').val('').trigger('change');
    $('#unit').val('').trigger('change');
    
    // Clear line item input fields
    $('#bales').val('');
    $('#weight').val('');
    
    // Clear line items
    lineItems = [];
    lineItemCounter = 0;
    editingLineItemId = null;
    $('#lineItemsTable tbody').html('');
    
    // Reset button
    $('#addLineItem').html('<i class="fas fa-plus"></i> Add Line Item').removeClass('btn-warning').addClass('btn-success');
    
    $('#updateData').hide();
    $('#saveData').show();
    $("#saveData").attr('disabled', true);
}

// Clear Form button handler
$("#clearFormBtn").click(function(event) {
    event.preventDefault();
    if (confirm('Are you sure you want to clear the form? All unsaved data will be lost.')) {
        clearForm();
    }
});

// Save button handler
$("#saveData").click(function(event) {
    event.preventDefault();
    
    // Validate header
    if (!$('#party_id').val()) {
        alert('Please select Party');
        return;
    }
    if (!$('#agency_id').val()) {
        alert('Please select Mukam/Agency');
        return;
    }
    if (!$('#broker_id').val()) {
//        alert('Please select Broker');
//        return;
    }
    
    // Validate line items
    if (lineItems.length === 0) {
        alert('Please add at least one line item');
        return;
    }
    
    var headerData = {
        recpno: $('#recpno').val(),
        inwarddate: $('#inwarddate').val(),
        fyyear: $('#fyyear').val(),
        lotno: $('#lotno').val(),
        party_id: $('#party_id').val(),
        challno: $('#challno').val(),
        chaldate: $('#chaldate').val(),
        lorryno: $('#lorryno').val(),
        agency_id: $('#agency_id').val(),
        mrdate: $('#mrdate').val(),
        jcino: $('#jcino').val(),
        rukkano: $('#rukkano').val(),
        rukkadate: $('#rukkadate').val(),
        broker_id: $('#broker_id').val(),
        lineItems: JSON.stringify(lineItems)
    };
    
    $('#spinnerContainer').addClass('show');
    
    $.ajax({
        url: "<?php echo base_url('admin/Recepentry/save_receipt_header'); ?>",
        type: "POST",
        data: headerData,
        dataType: "json",
        success: function(response) {
            if (response.success) {
                alert('Receipt Saved Successfully');
                clearForm();
                refreshDataTable();
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function(xhr, status, error) {
            alert('Error saving receipt: ' + error);
        },
        complete: function() {
            $('#spinnerContainer').removeClass('show');
        }
    });
});

// Update button handler
$("#updateData").click(function(event) {
    event.preventDefault();
    
    // Validate header
    if (!$('#party_id').val()) {
        alert('Please select Party');
        return;
    }
    if (!$('#agency_id').val()) {
        alert('Please select Mukam/Agency');
        return;
    }
    
    // Validate line items
    if (lineItems.length === 0) {
        alert('Please add at least one line item');
        return;
    }
    
    // Confirm update
    if (!confirm('Are you sure you want to update this receipt? All line items will be replaced.')) {
        return;
    }
    
    var formData = {
        recpmast_id: $('#recpmast_id').val(),
        inwarddate: $('#inwarddate').val(),
        lotno: $('#lotno').val(),
        party_id: $('#party_id').val(),
        challno: $('#challno').val(),
        chaldate: $('#chaldate').val(),
        lorryno: $('#lorryno').val(),
        agency_id: $('#agency_id').val(),
        mrdate: $('#mrdate').val(),
        jcino: $('#jcino').val(),
        rukkano: $('#rukkano').val(),
        rukkadate: $('#rukkadate').val(),
        broker_id: $('#broker_id').val(),
        lineItems: JSON.stringify(lineItems)
    };
    
    $('#spinnerContainer').addClass('show');
    
    $.ajax({
        url: "<?php echo base_url('admin/Recepentry/update_receipt'); ?>",
        type: "POST",
        data: formData,
        dataType: "json",
        success: function(response) {
            if (response.success) {
                alert('Receipt Updated Successfully');
                clearForm();
                refreshDataTable();
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function(xhr, status, error) {
            alert('Error updating receipt: ' + error);
            console.log(xhr.responseText);
        },
        complete: function() {
            $('#spinnerContainer').removeClass('show');
        }
    });
});

// Import Button Handler
$('#importBtn').on('click', function() {
    var recepDate = $('#inwarddate').val();
    
                    date = $('#inwarddate').val();
//alert('Receipt Date: ' + recepDate);
//alert('Date Value: ' + date);
    if (!recepDate) {
        alert('Please select a receipt date first');
        return;
    }
    
    // First check if data already exists for this date
    $.ajax({
        url: '<?php echo base_url("admin/recepentry/check_existing_import"); ?>',
        type: 'POST',
        data: { receipt_date: recepDate },
        dataType: 'json',
        success: function(response) {
            console.log('Check existing response:', response);
            console.log('Exists:', response.exists);
            
            if (response.exists === true || response.exists === 1) {
                // Data already exists, show confirmation
                var confirmMsg = 'Data already imported for this date.\n\nClick "OK" to delete previous records and import again.\nClick "Cancel" to go back.';
                if (confirm(confirmMsg)) {
                    // User clicked Yes - proceed with import
                    performImport(recepDate, true);
                }
                // If user clicked Cancel/No, just return - don't do anything
            } else {
                // No existing data, proceed with import
                performImport(recepDate, false);
            }
        },
        error: function(xhr, status, error) {
            console.log('Check error:', error);
            console.log('Response:', xhr.responseText);
            alert('Error checking existing data: ' + error);
        }
    });
});

function performImport(recepDate, deleteExisting) {
    $('#spinnerContainer').addClass('show');
    
    $.ajax({
        url: '<?php echo base_url("admin/recepentry/import_jute_receipt"); ?>',
        type: 'POST',
        data: { receipt_date: recepDate, delete_existing: deleteExisting },
        dataType: 'json',
        success: function(response) {
            $('#spinnerContainer').removeClass('show');
            console.log('Response:', response);
            if (response.success) {
                // Populate form with imported data
                if (response.data) {
                    var data = response.data;
                    $('#party_id').val(data.party_id || '').trigger('change');
                    $('#broker_id').val(data.broker_id || '').trigger('change');
                    $('#challno').val(data.challno || '');
                    $('#chaldate').val(data.chaldate || '');
                    $('#lorryno').val(data.lorryno || '');
                    $('#agency_id').val(data.agency_id || '').trigger('change');
                    $('#mrdate').val(data.mrdate || '');
                    $('#rukkano').val(data.rukkano || '');
                    $('#rukkadate').val(data.rukkadate || '');
                    
                    alert(response.message);
                    
                    // Refresh the table with fresh data
                    refreshDataTable();
                } else {
                    alert('Data imported but no details returned');
                }
            } else {
                alert(response.message);
            }
        },
        error: function(xhr, status, error) {
            $('#spinnerContainer').removeClass('show');
            console.log('Error Status:', status);
            console.log('Error:', error);
            console.log('Response Text:', xhr.responseText);
            alert('Error importing data: ' + error);
        }
    });
}
</script>

</body>
</html>
