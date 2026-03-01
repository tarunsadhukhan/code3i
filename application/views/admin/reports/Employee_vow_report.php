<?php $this->load->view('admin/header'); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<?php 
// Get company_id from session for use in JavaScript
$company_id = $this->session->userdata('company_id');
$company_id_value = (!empty($company_id)) ? $company_id : 'NOT_SET';
?>

<style>
    .content-wrapper {
        padding: 20px;
    }
    
    .btn-group-custom {
        margin-bottom: 15px;
    }
    
    .btn-group-custom .btn {
        margin-right: 10px;
        margin-bottom: 10px;
    }
    
    .dataTables_wrapper {
        margin-top: 10px;
    }
    
    .table-title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 15px;
        color: #333;
    }
    
    .report-table-container {
        background-color: white;
        padding: 15px;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        overflow-x: auto;
    }
    
    .column-toggle {
        float: right;
        margin-bottom: 10px;
    }
    
    .column-toggle-btn {
        background-color: #17a2b8;
        color: white;
        padding: 8px 15px;
        border-radius: 3px;
        cursor: pointer;
        font-size: 12px;
    }
    
    .column-toggle-btn:hover {
        background-color: #138496;
    }
    
    .column-toggle-menu {
        display: none;
        background-color: white;
        border: 1px solid #ccc;
        border-radius: 3px;
        padding: 10px;
        position: absolute;
        z-index: 1000;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        right: 0;
        top: 35px;
    }
    
    .column-toggle-menu.active {
        display: block;
    }
    
    .column-toggle-menu label {
        display: block;
        margin-bottom: 8px;
        cursor: pointer;
    }
    
    .column-toggle-menu input[type="checkbox"] {
        margin-right: 8px;
    }
    
    .dataTables_filter input {
        margin-left: 10px;
    }
    
    .column-header-filter {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }
    
    .column-header-filter-wrapper {
        font-size: 12px;
        padding: 10px 8px !important;
        position: relative;
        vertical-align: middle !important;
        white-space: nowrap !important;
        min-height: auto !important;
        background-color: #f8f9fa !important;
        overflow: visible !important;
        height: auto !important;
    }
    
    .column-header-title {
        font-weight: bold;
        padding: 4px 2px;
        color: #333;
        font-size: 13px;
        display: flex;
        justify-content: flex-start;
        align-items: center;
        gap: 2px;
        flex-wrap: nowrap;
        overflow: visible !important;
        width: auto;
        white-space: normal;
    }
    
    .column-header-title span {
        white-space: nowrap;
        overflow: visible !important;
    }
    
    .filter-icon-btn {
        background: none !important;
        border: none !important;
        cursor: pointer !important;
        font-size: 14px !important;
        color: #666 !important;
        padding: 0 2px !important;
        display: inline-block !important;
        visibility: visible !important;
        opacity: 1 !important;
        width: 16px !important;
        height: 16px !important;
        min-width: 16px !important;
        min-height: 16px !important;
        flex-shrink: 0 !important;
        z-index: 200 !important;
        margin: 0 2px !important;
        line-height: 1 !important;
        vertical-align: top !important;
        position: relative !important;
        box-sizing: border-box !important;
    }
    
    .filter-icon-btn i {
        display: inline-block !important;
        visibility: visible !important;
        opacity: 1 !important;
        width: 12px !important;
        height: 12px !important;
        color: #666 !important;
        font-size: 12px !important;
    }
    
    .filter-icon-btn:hover {
        color: #0066cc !important;
    }
    
    .filter-icon-btn:hover {
        color: #0066cc !important;
    }
    
    .filter-icon-btn.filtered {
        color: #0066cc !important;
        font-weight: bold !important;
    }
    
    .filter-dropdown-menu {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        right: auto;
        background-color: white;
        border: 1px solid #999;
        border-radius: 4px;
        padding: 10px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.3);
        z-index: 1100;
        min-width: 300px;
        margin-top: 2px;
        visibility: visible !important;
    }
    
    .filter-dropdown-menu.active {
        display: block;
    }
    
    .filter-operator {
        margin-bottom: 10px;
    }
    
    .filter-operator label {
        display: block;
        font-size: 12px;
        font-weight: bold;
        margin-bottom: 5px;
        color: #333;
    }
    
    .filter-operator select {
        width: 100%;
        padding: 6px;
        border: 1px solid #999;
        border-radius: 3px;
        font-size: 12px;
        box-sizing: border-box;
    }
    
    .filter-value {
        margin-bottom: 10px;
    }
    
    .filter-value label {
        display: block;
        font-size: 12px;
        font-weight: bold;
        margin-bottom: 5px;
        color: #333;
    }
    
    .filter-value input,
    .filter-value select {
        width: 100%;
        padding: 6px;
        border: 1px solid #999;
        border-radius: 3px;
        font-size: 12px;
        box-sizing: border-box;
    }
    
    .filter-buttons {
        display: flex;
        gap: 5px;
        margin-top: 10px;
    }
    
    .filter-buttons button {
        flex: 1;
        padding: 6px 10px;
        font-size: 12px;
        border: 1px solid #999;
        border-radius: 3px;
        cursor: pointer;
        background-color: #f5f5f5;
    }
    
    .filter-buttons button:hover {
        background-color: #e0e0e0;
    }
    
    .filter-buttons .apply-btn {
        background-color: #0066cc;
        color: white;
        border-color: #0066cc;
    }
    
    .filter-buttons .apply-btn:hover {
        background-color: #0052a3;
    }
    
    .filter-buttons .clear-btn {
        background-color: #f0f0f0;
    }
    
    table.dataTable thead th {
        padding: 0 !important;
        vertical-align: top !important;
        background-color: #f8f9fa !important;
        position: sticky;
        top: 0;
        z-index: 100;
    }
    
    table.dataTable thead {
        background-color: #f8f9fa;
        position: sticky;
        top: 0;
        z-index: 100;
    }
    
    .th-content {
        padding: 0;
        display: flex;
        flex-direction: column;
    }
    
    table.dataTable thead .th-content .column-header-title {
        background-color: #f8f9fa;
        border-bottom: 1px solid #ddd;
    }
    
    .loading-spinner {
        display: none;
        text-align: center;
        padding: 20px;
    }
    
    .loading-spinner.active {
        display: block;
    }
    
    table.dataTable tbody td {
        padding: 10px 12px;
        border-bottom: 1px solid #ddd;
    }
    
    table.dataTable thead th .th-content {
        min-height: 80px;
    }
    
    .select2-container--bootstrap4 .select2-selection--multiple {
        min-height: 38px;
    }
    
    .report-table-container {
        margin-top: 20px;
        background-color: white;
        padding: 15px;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        overflow: auto;
        height: calc(100vh - 280px);
        display: flex;
        flex-direction: column;
    }
    
    .dataTables_wrapper {
        display: flex;
        flex-direction: column;
        height: 100%;
        width: 100%;
        overflow: visible !important;
    }
    
    .dataTables_scroll {
        flex: 1;
        overflow: auto !important;
        position: relative;
        width: 100%;
        overflow-x: scroll !important;
        overflow-y: auto !important;
        display: block;
        -webkit-overflow-scrolling: touch;
    }
    
    .dataTables_scrollBody {
        overflow: auto !important;
    }

    .dataTables_scrollHead {
        overflow: hidden !important;
        display: block;
        width: 100%;
    }

    table.dataTable {
        width: 100% !important;
        min-width: 3000px;
        border-collapse: collapse;
        margin: 0;
        padding: 0;
    }

    table.dataTable thead th {
        white-space: nowrap;
        padding: 10px 8px !important;
        position: sticky;
        top: 0;
        z-index: 100;
        background-color: #f8f9fa !important;
    }

    table.dataTable tbody td {
        white-space: nowrap;
        padding: 10px 8px !important;
    }
    
    .dataTables_filter {
        display: none !important;
    }

    .dataTables_length {
        margin-bottom: 10px;
    }

    .dt-scroll {
        overflow-x: auto !important;
        overflow-y: auto !important;
        max-height: calc(100vh - 450px) !important;
    }

    /* Select2 styling in filter dropdowns */
    .filter-dropdown-menu .select2-container {
        width: 100% !important;
        margin-bottom: 12px;
    }

    .filter-dropdown-menu .select2-container--bootstrap4 .select2-selection--multiple {
        min-height: 38px;
        border: 1px solid #999 !important;
        border-radius: 4px !important;
        background-color: white !important;
    }

    .filter-dropdown-menu .select2-container--bootstrap4.select2-container--focus .select2-selection--multiple {
        border-color: #007bff !important;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25) !important;
    }

    .filter-dropdown-menu .select2-container--bootstrap4 .select2-selection--multiple .select2-selection__choice {
        background-color: #007bff;
        border-color: #0066cc;
        color: white;
        padding: 2px 8px;
        font-size: 12px;
    }

    .filter-dropdown-menu .select2-container--bootstrap4 .select2-selection--multiple .select2-selection__choice__remove {
        color: white;
        margin-right: 4px;
    }

    .filter-dropdown-menu .select2-dropdown {
        border: 1px solid #999 !important;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2) !important;
    }

    .filter-dropdown-menu .select2-dropdown--below {
        border-top: none;
    }

    .filter-dropdown-menu .select2-search__field {
        border: 1px solid #999 !important;
        padding: 6px 8px !important;
        font-size: 13px !important;
    }

    .filter-dropdown-menu .select2-results__option {
        padding: 8px 12px;
        font-size: 13px;
    }

    .filter-dropdown-menu .select2-results__option--highlighted {
        background-color: #007bff !important;
    }

    /* Select2 with checkboxes styling */
    .select2-checkbox-option {
        display: flex;
        align-items: center;
        padding: 4px 0;
        cursor: pointer;
        user-select: none;
    }

    .select2-checkbox-option input[type="checkbox"] {
        margin-right: 10px;
        cursor: pointer;
        width: 16px;
        height: 16px;
        accent-color: #007bff;
    }

    .select2-checkbox-option span {
        padding: 2px 0;
        font-size: 13px;
        color: #333;
    }

    .select2-results {
        padding: 0 !important;
    }

    .select2-results__option {
        padding: 8px 12px !important;
    }

    .select2-results__option.select2-checkbox-option {
        padding: 6px 12px !important;
    }

    /* Row highlighting for filtered results */
    table.dataTable tbody tr.filter-highlight {
        background-color: #fff3cd !important;
        box-shadow: inset 0 0 10px rgba(255, 193, 7, 0.3);
    }

    table.dataTable tbody tr.filter-highlight:hover {
        background-color: #ffe699 !important;
    }

    table.dataTable tbody tr.filter-highlight td {
        background-color: inherit;
    }

    /* Filter button active state */
    .filter-icon-btn.active-filter {
        color: #dc3545 !important;
        font-weight: bold;
    }

    .filter-icon-btn.active-filter i {
        color: #dc3545 !important;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.6;
        }
    }

    /* Header column highlighting for active filters */
    table.dataTable thead th.column-filtered {
        background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%) !important;
        color: white !important;
        font-weight: bold;
        box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.1);
        border: 2px solid #ff9800 !important;
    }

    table.dataTable thead th.column-filtered .column-header-title {
        color: white !important;
    }

    table.dataTable thead th.column-filtered .column-header-title span {
        color: white !important;
    }

    table.dataTable thead th.column-filtered .filter-icon-btn {
        color: white !important;
    }

    table.dataTable thead th.column-filtered .filter-icon-btn i {
        color: white !important;
    }

    /* Red pulsing icon should be visible even on filtered headers */
    table.dataTable thead th.column-filtered .filter-icon-btn.active-filter {
        color: #dc3545 !important;
        font-weight: bold;
    }

    table.dataTable thead th.column-filtered .filter-icon-btn.active-filter i {
        color: #dc3545 !important;
        animation: pulse 2s infinite;
    }
</style>


<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Employee VOW Report</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin/Welcome'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="#">Reports</a></li>
                        <li class="breadcrumb-item active">Employee VOW Report</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <!-- Debug Info -->
        <div id="debugInfo" style="background: #f0f0f0; padding: 10px; margin-bottom: 10px; border-radius: 4px; font-size: 12px; display: none;">
            <strong>Debug Info (Ctrl+Shift+D to toggle):</strong>
            <div>Company ID: <span id="debugCompanyId">Not available</span></div>
            <div>Base URL: <span id="debugBaseUrl"></span></div>
            <div>API URL: <span id="debugApiUrl"></span></div>
            <div style="margin-top: 10px;">
                <button id="testSimpleApiBtn" class="btn btn-sm btn-warning" type="button">Test Simple API</button>
                <button id="testApiBtn" class="btn btn-sm btn-primary" type="button">Test API Connection</button>
                <button id="testDbBtn" class="btn btn-sm btn-secondary" type="button">Test Database</button>
                <span id="testResult" style="margin-left: 10px; font-weight: bold;"></span>
            </div>
            <div id="testOutput" style="background: white; padding: 10px; margin-top: 10px; max-height: 300px; overflow-y: auto; font-family: monospace; font-size: 11px; display: none;"></div>
        </div>

        <!-- Error Message -->
        <div class="error-message" id="errorMessage"></div>

        <!-- Report Table Container -->
        <div class="report-table-container">
            <div style="margin-bottom: 15px;">
                <div class="table-title">
                    Employee VOW Details
                </div>

                <!-- Action Buttons -->
                <div class="btn-group-custom" style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <button type="button" class="btn btn-success" id="exportBtn">
                            <i class="fas fa-file-excel"></i> Export to Excel
                        </button>
                        <button type="button" class="btn btn-info" id="printBtn">
                            <i class="fas fa-print"></i> Print
                        </button>
                        <button type="button" class="btn btn-secondary" id="resetBtn">
                            <i class="fas fa-redo"></i> Reset Filters
                        </button>
                    </div>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <label style="font-weight: bold; color: #333; margin: 0;">Quick Search:</label>
                        <input type="text" id="quickSearchInput" placeholder="Search all fields..." style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px; width: 250px; font-size: 12px;">
                    </div>
                </div>
            </div>

            <div class="loading-spinner" id="loadingSpinner">
                <i class="fas fa-spinner fa-spin fa-2x"></i> Loading data...
            </div>

            <div style="position: relative;">
                <div class="column-toggle">
                    <button class="column-toggle-btn" id="columnToggleBtn">
                        <i class="fas fa-eye"></i> Show/Hide Columns
                    </button>
                    <div class="column-toggle-menu" id="columnToggleMenu">
                        <!-- Dynamically populated -->
                    </div>
                </div>
            </div>

            <table id="employeeVowTable" class="table table-striped table-bordered dt-responsive nowrap" width="100%">
                <thead>
                    <tr>
                        <th class="column-header-filter-wrapper" data-column="0">
                            <div class="column-header-title">
                                <span>Employee ID</span>
                                <button class="filter-icon-btn" title="Filter">
                                    <i class="fas fa-filter"></i>
                                </button>
                            </div>
                            <div class="filter-dropdown-menu">
                                <div class="filter-operator">
                                    <label>Filter Type:</label>
                                    <select class="filter-type-select">
                                        <option value="">-- No Filter --</option>
                                        <option value="equals">Equals to</option>
                                        <option value="contains">Contains</option>
                                        <option value="startswith">Starts with</option>
                                        <option value="endswith">Ends with</option>
                                        <option value="greater">Greater than</option>
                                        <option value="less">Less than</option>
                                    </select>
                                </div>
                                <div class="filter-value">
                                    <label>Value:</label>
                                    <input type="text" class="filter-value-input" placeholder="Enter value">
                                </div>
                                <div class="filter-buttons">
                                    <button class="apply-btn">Apply</button>
                                    <button class="clear-btn">Clear</button>
                                </div>
                            </div>
                        </th>
                        <th class="column-header-filter-wrapper" data-column="1">
                            <div class="column-header-title">
                                <span>Employee Code</span>
                                <button class="filter-icon-btn" title="Filter">
                                    <i class="fas fa-filter"></i>
                                </button>
                            </div>
                            <div class="filter-dropdown-menu">
                                <div class="filter-operator">
                                    <label>Filter Type:</label>
                                    <select class="filter-type-select">
                                        <option value="">-- No Filter --</option>
                                        <option value="equals">Equals to</option>
                                        <option value="contains">Contains</option>
                                        <option value="startswith">Starts with</option>
                                        <option value="endswith">Ends with</option>
                                    </select>
                                </div>
                                <div class="filter-value">
                                    <label>Value:</label>
                                    <input type="text" class="filter-value-input" placeholder="Enter value">
                                </div>
                                <div class="filter-buttons">
                                    <button class="apply-btn">Apply</button>
                                    <button class="clear-btn">Clear</button>
                                </div>
                            </div>
                        </th>
                        <th class="column-header-filter-wrapper" data-column="2">
                            <div class="column-header-title">
                                <span>Employee Name</span>
                                <button class="filter-icon-btn" title="Filter">
                                    <i class="fas fa-filter"></i>
                                </button>
                            </div>
                            <div class="filter-dropdown-menu">
                                <div class="filter-operator">
                                    <label>Filter Type:</label>
                                    <select class="filter-type-select">
                                        <option value="">-- No Filter --</option>
                                        <option value="equals">Equals to</option>
                                        <option value="contains">Contains</option>
                                        <option value="startswith">Starts with</option>
                                        <option value="endswith">Ends with</option>
                                    </select>
                                </div>
                                <div class="filter-value">
                                    <label>Value:</label>
                                    <input type="text" class="filter-value-input" placeholder="Enter value">
                                </div>
                                <div class="filter-buttons">
                                    <button class="apply-btn">Apply</button>
                                    <button class="clear-btn">Clear</button>
                                </div>
                            </div>
                        </th>
                        <th class="column-header-filter-wrapper" data-column="3">
                            <div class="column-header-title">
                                <span>Gender</span>
                                <button class="filter-icon-btn" title="Filter">
                                    <i class="fas fa-filter"></i>
                                </button>
                            </div>
                            <div class="filter-dropdown-menu">
                                <div class="filter-operator">
                                    <label>Filter Type:</label>
                                    <select class="filter-type-select">
                                        <option value="">-- No Filter --</option>
                                        <option value="equals">Equals to</option>
                                    </select>
                                </div>
                                <div class="filter-value">
                                    <label>Value:</label>
                                    <select class="filter-value-input">
                                        <option value="">-- All --</option>
                                        <option value="M">Male</option>
                                        <option value="F">Female</option>
                                    </select>
                                </div>
                                <div class="filter-buttons">
                                    <button class="apply-btn">Apply</button>
                                    <button class="clear-btn">Clear</button>
                                </div>
                            </div>
                        </th>
                        <th class="column-header-filter-wrapper" data-column="4">
                            <div class="column-header-title">
                                <span>Department Code</span>
                                <button class="filter-icon-btn" title="Filter">
                                    <i class="fas fa-filter"></i>
                                </button>
                            </div>
                            <div class="filter-dropdown-menu">
                                <div class="filter-operator">
                                    <label>Filter Type:</label>
                                    <select class="filter-type-select">
                                        <option value="">-- No Filter --</option>
                                        <option value="equals">Equals to</option>
                                        <option value="contains">Contains</option>
                                        <option value="startswith">Starts with</option>
                                    </select>
                                </div>
                                <div class="filter-value">
                                    <label>Value:</label>
                                    <input type="text" class="filter-value-input" placeholder="Enter value">
                                </div>
                                <div class="filter-buttons">
                                    <button class="apply-btn">Apply</button>
                                    <button class="clear-btn">Clear</button>
                                </div>
                            </div>
                        </th>
                        <th class="column-header-filter-wrapper" data-column="5">
                            <div class="column-header-title">
                                <span>Department Description</span>
                                <button class="filter-icon-btn" title="Filter">
                                    <i class="fas fa-filter"></i>
                                </button>
                            </div>
                            <div class="filter-dropdown-menu">
                                <div class="filter-operator">
                                    <label>Filter Type:</label>
                                    <select class="filter-type-select">
                                        <option value="">-- No Filter --</option>
                                        <option value="equals">Equals to</option>
                                        <option value="contains">Contains</option>
                                        <option value="startswith">Starts with</option>
                                    </select>
                                </div>
                                <div class="filter-value">
                                    <label>Value:</label>
                                    <input type="text" class="filter-value-input" placeholder="Enter value">
                                </div>
                                <div class="filter-buttons">
                                    <button class="apply-btn">Apply</button>
                                    <button class="clear-btn">Clear</button>
                                </div>
                            </div>
                        </th>
                        <th class="column-header-filter-wrapper" data-column="6">
                            <div class="column-header-title">
                                <span>Designation</span>
                                <button class="filter-icon-btn" title="Filter">
                                    <i class="fas fa-filter"></i>
                                </button>
                            </div>
                            <div class="filter-dropdown-menu">
                                <div class="filter-operator">
                                    <label>Filter Type:</label>
                                    <select class="filter-type-select">
                                        <option value="">-- No Filter --</option>
                                        <option value="equals">Equals to</option>
                                        <option value="contains">Contains</option>
                                        <option value="startswith">Starts with</option>
                                    </select>
                                </div>
                                <div class="filter-value">
                                    <label>Value:</label>
                                    <input type="text" class="filter-value-input" placeholder="Enter value">
                                </div>
                                <div class="filter-buttons">
                                    <button class="apply-btn">Apply</button>
                                    <button class="clear-btn">Clear</button>
                                </div>
                            </div>
                        </th>
                        <th class="column-header-filter-wrapper" data-column="7">
                            <div class="column-header-title">
                                <span>Category</span>
                                <button class="filter-icon-btn" title="Filter">
                                    <i class="fas fa-filter"></i>
                                </button>
                            </div>
                            <div class="filter-dropdown-menu">
                                <div class="filter-operator">
                                    <label>Filter Type:</label>
                                    <select class="filter-type-select">
                                        <option value="">-- No Filter --</option>
                                        <option value="equals">Equals to</option>
                                        <option value="contains">Contains</option>
                                        <option value="startswith">Starts with</option>
                                    </select>
                                </div>
                                <div class="filter-value">
                                    <label>Value:</label>
                                    <input type="text" class="filter-value-input" placeholder="Enter value">
                                </div>
                                <div class="filter-buttons">
                                    <button class="apply-btn">Apply</button>
                                    <button class="clear-btn">Clear</button>
                                </div>
                            </div>
                        </th>
                        <th class="column-header-filter-wrapper" data-column="8">
                            <div class="column-header-title">
                                <span>Date of Birth</span>
                                <button class="filter-icon-btn" title="Filter">
                                    <i class="fas fa-filter"></i>
                                </button>
                            </div>
                            <div class="filter-dropdown-menu">
                                <div class="filter-operator">
                                    <label>Filter Type:</label>
                                    <select class="filter-type-select">
                                        <option value="">-- No Filter --</option>
                                        <option value="equals">Equals to</option>
                                        <option value="greater">Greater than</option>
                                        <option value="less">Less than</option>
                                    </select>
                                </div>
                                <div class="filter-value">
                                    <label>Value:</label>
                                    <input type="text" class="filter-value-input" placeholder="dd-mm-yyyy">
                                </div>
                                <div class="filter-buttons">
                                    <button class="apply-btn">Apply</button>
                                    <button class="clear-btn">Clear</button>
                                </div>
                            </div>
                        </th>
                        <th class="column-header-filter-wrapper" data-column="9">
                            <div class="column-header-title">
                                <span>Date of Join</span>
                                <button class="filter-icon-btn" title="Filter">
                                    <i class="fas fa-filter"></i>
                                </button>
                            </div>
                            <div class="filter-dropdown-menu">
                                <div class="filter-operator">
                                    <label>Filter Type:</label>
                                    <select class="filter-type-select">
                                        <option value="">-- No Filter --</option>
                                        <option value="equals">Equals to</option>
                                        <option value="greater">Greater than</option>
                                        <option value="less">Less than</option>
                                    </select>
                                </div>
                                <div class="filter-value">
                                    <label>Value:</label>
                                    <input type="text" class="filter-value-input" placeholder="dd-mm-yyyy">
                                </div>
                                <div class="filter-buttons">
                                    <button class="apply-btn">Apply</button>
                                    <button class="clear-btn">Clear</button>
                                </div>
                            </div>
                        </th>
                        <th class="column-header-filter-wrapper" data-column="10">
                            <div class="column-header-title">
                                <span>ESI Number</span>
                                <button class="filter-icon-btn" title="Filter">
                                    <i class="fas fa-filter"></i>
                                </button>
                            </div>
                            <div class="filter-dropdown-menu">
                                <div class="filter-operator">
                                    <label>Filter Type:</label>
                                    <select class="filter-type-select">
                                        <option value="">-- No Filter --</option>
                                        <option value="equals">Equals to</option>
                                        <option value="contains">Contains</option>
                                        <option value="startswith">Starts with</option>
                                    </select>
                                </div>
                                <div class="filter-value">
                                    <label>Value:</label>
                                    <input type="text" class="filter-value-input" placeholder="Enter value">
                                </div>
                                <div class="filter-buttons">
                                    <button class="apply-btn">Apply</button>
                                    <button class="clear-btn">Clear</button>
                                </div>
                            </div>
                        </th>
                        <th class="column-header-filter-wrapper" data-column="11">
                            <div class="column-header-title">
                                <span>PF Number</span>
                                <button class="filter-icon-btn" title="Filter">
                                    <i class="fas fa-filter"></i>
                                </button>
                            </div>
                            <div class="filter-dropdown-menu">
                                <div class="filter-operator">
                                    <label>Filter Type:</label>
                                    <select class="filter-type-select">
                                        <option value="">-- No Filter --</option>
                                        <option value="equals">Equals to</option>
                                        <option value="contains">Contains</option>
                                        <option value="startswith">Starts with</option>
                                    </select>
                                </div>
                                <div class="filter-value">
                                    <label>Value:</label>
                                    <input type="text" class="filter-value-input" placeholder="Enter value">
                                </div>
                                <div class="filter-buttons">
                                    <button class="apply-btn">Apply</button>
                                    <button class="clear-btn">Clear</button>
                                </div>
                            </div>
                        </th>
                        <th class="column-header-filter-wrapper" data-column="12">
                            <div class="column-header-title">
                                <span>PF Date of Join</span>
                                <button class="filter-icon-btn" title="Filter">
                                    <i class="fas fa-filter"></i>
                                </button>
                            </div>
                            <div class="filter-dropdown-menu">
                                <div class="filter-operator">
                                    <label>Filter Type:</label>
                                    <select class="filter-type-select">
                                        <option value="">-- No Filter --</option>
                                        <option value="equals">Equals to</option>
                                        <option value="greater">Greater than</option>
                                        <option value="less">Less than</option>
                                    </select>
                                </div>
                                <div class="filter-value">
                                    <label>Value:</label>
                                    <input type="text" class="filter-value-input" placeholder="dd-mm-yyyy">
                                </div>
                                <div class="filter-buttons">
                                    <button class="apply-btn">Apply</button>
                                    <button class="clear-btn">Clear</button>
                                </div>
                            </div>
                        </th>
                        <th class="column-header-filter-wrapper" data-column="13">
                            <div class="column-header-title">
                                <span>PF UAN Number</span>
                                <button class="filter-icon-btn" title="Filter">
                                    <i class="fas fa-filter"></i>
                                </button>
                            </div>
                            <div class="filter-dropdown-menu">
                                <div class="filter-operator">
                                    <label>Filter Type:</label>
                                    <select class="filter-type-select">
                                        <option value="">-- No Filter --</option>
                                        <option value="equals">Equals to</option>
                                        <option value="contains">Contains</option>
                                        <option value="startswith">Starts with</option>
                                    </select>
                                </div>
                                <div class="filter-value">
                                    <label>Value:</label>
                                    <input type="text" class="filter-value-input" placeholder="Enter value">
                                </div>
                                <div class="filter-buttons">
                                    <button class="apply-btn">Apply</button>
                                    <button class="clear-btn">Clear</button>
                                </div>
                            </div>
                        </th>
                        <th class="column-header-filter-wrapper" data-column="14">
                            <div class="column-header-title">
                                <span>Bank Account Number</span>
                                <button class="filter-icon-btn" title="Filter">
                                    <i class="fas fa-filter"></i>
                                </button>
                            </div>
                            <div class="filter-dropdown-menu">
                                <div class="filter-operator">
                                    <label>Filter Type:</label>
                                    <select class="filter-type-select">
                                        <option value="">-- No Filter --</option>
                                        <option value="equals">Equals to</option>
                                        <option value="contains">Contains</option>
                                        <option value="startswith">Starts with</option>
                                    </select>
                                </div>
                                <div class="filter-value">
                                    <label>Value:</label>
                                    <input type="text" class="filter-value-input" placeholder="Enter value">
                                </div>
                                <div class="filter-buttons">
                                    <button class="apply-btn">Apply</button>
                                    <button class="clear-btn">Clear</button>
                                </div>
                            </div>
                        </th>
                        <th class="column-header-filter-wrapper" data-column="15">
                            <div class="column-header-title">
                                <span>IFSC Code</span>
                                <button class="filter-icon-btn" title="Filter">
                                    <i class="fas fa-filter"></i>
                                </button>
                            </div>
                            <div class="filter-dropdown-menu">
                                <div class="filter-operator">
                                    <label>Filter Type:</label>
                                    <select class="filter-type-select">
                                        <option value="">-- No Filter --</option>
                                        <option value="equals">Equals to</option>
                                        <option value="contains">Contains</option>
                                        <option value="startswith">Starts with</option>
                                    </select>
                                </div>
                                <div class="filter-value">
                                    <label>Value:</label>
                                    <input type="text" class="filter-value-input" placeholder="Enter value">
                                </div>
                                <div class="filter-buttons">
                                    <button class="apply-btn">Apply</button>
                                    <button class="clear-btn">Clear</button>
                                </div>
                            </div>
                        </th>
                        <th class="column-header-filter-wrapper" data-column="16">
                            <div class="column-header-title">
                                <span>Bank Name</span>
                                <button class="filter-icon-btn" title="Filter">
                                    <i class="fas fa-filter"></i>
                                </button>
                            </div>
                            <div class="filter-dropdown-menu">
                                <div class="filter-operator">
                                    <label>Filter Type:</label>
                                    <select class="filter-type-select">
                                        <option value="">-- No Filter --</option>
                                        <option value="equals">Equals to</option>
                                        <option value="contains">Contains</option>
                                        <option value="startswith">Starts with</option>
                                    </select>
                                </div>
                                <div class="filter-value">
                                    <label>Value:</label>
                                    <input type="text" class="filter-value-input" placeholder="Enter value">
                                </div>
                                <div class="filter-buttons">
                                    <button class="apply-btn">Apply</button>
                                    <button class="clear-btn">Clear</button>
                                </div>
                            </div>
                        </th>
                        <th class="column-header-filter-wrapper" data-column="17">
                            <div class="column-header-title">
                                <span>Contractor Name</span>
                                <button class="filter-icon-btn" title="Filter">
                                    <i class="fas fa-filter"></i>
                                </button>
                            </div>
                            <div class="filter-dropdown-menu">
                                <div class="filter-operator">
                                    <label>Filter Type:</label>
                                    <select class="filter-type-select">
                                        <option value="">-- No Filter --</option>
                                        <option value="equals">Equals to</option>
                                        <option value="contains">Contains</option>
                                        <option value="startswith">Starts with</option>
                                    </select>
                                </div>
                                <div class="filter-value">
                                    <label>Value:</label>
                                    <input type="text" class="filter-value-input" placeholder="Enter value">
                                </div>
                                <div class="filter-buttons">
                                    <button class="apply-btn">Apply</button>
                                    <button class="clear-btn">Clear</button>
                                </div>
                            </div>
                        </th>
                        <th class="column-header-filter-wrapper" data-column="18">
                            <div class="column-header-title">
                                <span>Status</span>
                                <button class="filter-icon-btn" title="Filter">
                                    <i class="fas fa-filter"></i>
                                </button>
                            </div>
                            <div class="filter-dropdown-menu">
                                <div class="filter-operator">
                                    <label>Filter Type:</label>
                                    <select class="filter-type-select">
                                        <option value="">-- No Filter --</option>
                                        <option value="equals">Equals to</option>
                                    </select>
                                </div>
                                <div class="filter-value">
                                    <label>Value:</label>
                                    <select class="filter-value-input">
                                        <option value="">-- All --</option>
                                        <option value="Active">Active</option>
                                        <option value="InActive">InActive</option>
                                    </select>
                                </div>
                                <div class="filter-buttons">
                                    <button class="apply-btn">Apply</button>
                                    <button class="clear-btn">Clear</button>
                                </div>
                            </div>
                        </th>
                        <th class="column-header-filter-wrapper" data-column="19">
                            <div class="column-header-title">
                                <span>Pay Scheme</span>
                                <button class="filter-icon-btn" title="Filter">
                                    <i class="fas fa-filter"></i>
                                </button>
                            </div>
                            <div class="filter-dropdown-menu">
                                <div class="filter-operator">
                                    <label>Filter Type:</label>
                                    <select class="filter-type-select">
                                        <option value="">-- No Filter --</option>
                                        <option value="equals">Equals to</option>
                                        <option value="contains">Contains</option>
                                        <option value="startswith">Starts with</option>
                                    </select>
                                </div>
                                <div class="filter-value">
                                    <label>Value:</label>
                                    <input type="text" class="filter-value-input" placeholder="Enter value">
                                </div>
                                <div class="filter-buttons">
                                    <button class="apply-btn">Apply</button>
                                    <button class="clear-btn">Clear</button>
                                </div>
                            </div>
                        </th>
                        <th class="column-header-filter-wrapper" data-column="20">
                            <div class="column-header-title">
                                <span>Active Status</span>
                                <button class="filter-icon-btn" title="Filter">
                                    <i class="fas fa-filter"></i>
                                </button>
                            </div>
                            <div class="filter-dropdown-menu">
                                <div class="filter-operator">
                                    <label>Filter Type:</label>
                                    <select class="filter-type-select">
                                        <option value="">-- No Filter --</option>
                                        <option value="equals">Equals to</option>
                                    </select>
                                </div>
                                <div class="filter-value">
                                    <label>Value:</label>
                                    <select class="filter-value-input">
                                        <option value="">-- All --</option>
                                        <option value="Active">Active</option>
                                        <option value="InActive">InActive</option>
                                    </select>
                                </div>
                                <div class="filter-buttons">
                                    <button class="apply-btn">Apply</button>
                                    <button class="clear-btn">Clear</button>
                                </div>
                            </div>
                        </th>
                        <th class="column-header-filter-wrapper" data-column="21">
                            <div class="column-header-title">
                                <span>Last Working Date</span>
                                <button class="filter-icon-btn" title="Filter">
                                    <i class="fas fa-filter"></i>
                                </button>
                            </div>
                            <div class="filter-dropdown-menu">
                                <div class="filter-operator">
                                    <label>Filter Type:</label>
                                    <select class="filter-type-select">
                                        <option value="">-- No Filter --</option>
                                        <option value="equals">Equals to</option>
                                        <option value="greater">Greater than</option>
                                        <option value="less">Less than</option>
                                    </select>
                                </div>
                                <div class="filter-value">
                                    <label>Value:</label>
                                    <input type="text" class="filter-value-input" placeholder="dd-mm-yyyy">
                                </div>
                                <div class="filter-buttons">
                                    <button class="apply-btn">Apply</button>
                                    <button class="clear-btn">Clear</button>
                                </div>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $this->load->view('admin/footer'); ?>

<!-- CSS Libraries -->
<link rel="stylesheet" href="<?php echo base_url('public/admin/plugins/select2/css/select2.min.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('public/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('public/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('public/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('public/admin/plugins/jquery-ui/jquery-ui.min.css'); ?>">

<!-- jQuery - MUST LOAD FIRST -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- JavaScript Libraries -->
<script src="<?php echo base_url('public/admin/plugins/select2/js/select2.full.min.js'); ?>"></script>
<script src="<?php echo base_url('public/admin/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo base_url('public/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js'); ?>"></script>
<script src="<?php echo base_url('public/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js'); ?>"></script>
<script src="<?php echo base_url('public/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js'); ?>"></script>
<script src="<?php echo base_url('public/admin/plugins/jquery-ui/jquery-ui.min.js'); ?>"></script>
<script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>

<script>
$(document).ready(function() {
    const baseUrl = '<?php echo base_url(); ?>';
    const companyId = '<?php echo $company_id_value; ?>';
    let columnVisibility = {};
    let columnFilters = {};

    // Check if required libraries are loaded
    console.log('=== Checking Required Libraries ===');
    console.log('jQuery:', typeof jQuery !== 'undefined' ? 'LOADED' : 'NOT LOADED');
    console.log('DataTables:', typeof $.fn.DataTable !== 'undefined' ? 'LOADED' : 'NOT LOADED');
    console.log('Bootstrap:', typeof Bootstrap !== 'undefined' ? 'LOADED' : 'NOT LOADED');

    // Debug logging
    console.log('=== Employee VOW Report Initialization ===');
    console.log('Company ID:', companyId);
    console.log('Base URL:', baseUrl);
    console.log('Session Company ID is', (companyId && companyId !== 'NOT_SET') ? 'SET - WILL LOAD DATA' : 'NOT SET - WILL SHOW UNAUTHORIZED');
    
    // Show debug info
    $('#debugCompanyId').text(companyId);
    $('#debugBaseUrl').text(baseUrl);
    $('#debugApiUrl').text(baseUrl + 'admin/reports/Employee_vow_report/get_employeevowdata');
    
    // Toggle debug panel on Ctrl+Shift+D
    $(document).on('keydown', function(e) {
        if (e.ctrlKey && e.shiftKey && e.which === 68) { // Ctrl+Shift+D
            $('#debugInfo').toggle();
        }
    });

    // Test Simple API (verify framework is working)
    $('#testSimpleApiBtn').on('click', function() {
        const url = baseUrl + 'admin/reports/Employee_vow_report/test_api';
        console.log('Testing Simple API:', url);
        $('#testOutput').show();
        $('#testResult').text('Testing Simple API...');
        
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            timeout: 5000,
            success: function(response) {
                console.log('Simple API Success:', response);
                $('#testResult').text('✓ Simple API Works!').css('color', 'green');
                $('#testOutput').html('<pre>' + JSON.stringify(response, null, 2) + '</pre>');
            },
            error: function(xhr, status, error) {
                console.error('Simple API Error:', status, error);
                $('#testResult').text('✗ Simple API Error: ' + status).css('color', 'red');
                $('#testOutput').html('<pre>Status: ' + xhr.status + '\nError: ' + error + '\nResponse: ' + xhr.responseText.substring(0, 500) + '</pre>');
            }
        });
    });

    // Test API Connection
    $('#testApiBtn').on('click', function() {
        const url = baseUrl + 'admin/reports/Employee_vow_report/get_employeevowdata';
        console.log('Testing API:', url);
        $('#testOutput').show();
        $('#testResult').text('Testing...');
        
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            timeout: 5000,
            success: function(response) {
                console.log('API Test Success:', response);
                $('#testResult').text('✓ API Responded').css('color', 'green');
                $('#testOutput').html('<pre>' + JSON.stringify(response, null, 2) + '</pre>');
            },
            error: function(xhr, status, error) {
                console.error('API Test Error:', status, error);
                $('#testResult').text('✗ API Error: ' + status).css('color', 'red');
                $('#testOutput').html('<pre>Status: ' + xhr.status + '\nError: ' + error + '\nResponse: ' + xhr.responseText + '</pre>');
            }
        });
    });

    // Test Database
    $('#testDbBtn').on('click', function() {
        const url = baseUrl + 'admin/reports/Employee_vow_report/test_db';
        console.log('Testing Database:', url);
        $('#testOutput').show();
        $('#testResult').text('Testing...');
        
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            timeout: 5000,
            success: function(response) {
                console.log('DB Test Success:', response);
                const status = response.database_test === 'success' ? 'green' : 'red';
                $('#testResult').text(('✓ DB Test: ' + response.database_test)).css('color', status);
                $('#testOutput').html('<pre>' + JSON.stringify(response, null, 2) + '</pre>');
            },
            error: function(xhr, status, error) {
                console.error('DB Test Error:', status, error);
                $('#testResult').text('✗ DB Test Error').css('color', 'red');
                $('#testOutput').html('<pre>Status: ' + xhr.status + '\nError: ' + error + '</pre>');
            }
        });
    });

    // Create filter UI dynamically for each column header
    function createFilterUI() {
        console.log('Creating filter UI...');
        
        // Only create filter UI if it doesn't exist yet
        if ($('th').find('.filter-icon-btn').length > 0) {
            console.log('Filter UI already created, skipping...');
            return;
        }
        
        // Get all header cells
        $('#employeeVowTable thead th').each(function(index) {
            const $th = $(this);
            
            // Skip if filter already exists
            if ($th.find('.filter-icon-btn').length > 0) {
                return;
            }
            
            // Get the text content
            let headerText = $th.text().trim();
            headerText = headerText.replace(/[▼▲]/g, '').trim();
            
            console.log('Adding filter to column ' + index + ': ' + headerText);
            
            // Create filter button
            const filterBtn = $('<button class="filter-icon-btn" type="button" title="Filter" style="display: inline-block; background: none; border: none; cursor: pointer; padding: 2px 4px; margin-left: 4px; color: #666; font-size: 14px; vertical-align: middle;"><i class="fas fa-filter"></i></button>');
            
            // Create filter dropdown menu
            const filterMenu = $(`
                <div class="filter-dropdown-menu" style="position: absolute; background: white; border: 2px solid #007bff; border-radius: 4px; padding: 12px; z-index: 10000; min-width: 300px; box-shadow: 0 4px 15px rgba(0,0,0,0.3); top: 100%; left: 0; margin-top: 5px;">
                    <div class="filter-operator" style="margin-bottom: 12px;">
                        <label style="display: block; margin-bottom: 6px; font-weight: bold; font-size: 13px; color: #333;">Filter Type:</label>
                        <select class="filter-type-select" style="width: 100%; padding: 8px; border: 1px solid #999; border-radius: 4px; font-size: 13px; cursor: pointer; background-color: white; color: black; appearance: auto; -webkit-appearance: auto;">
                            <option value="" style="color: #999;">-- No Filter --</option>
                            <option value="equals" style="color: black;">Equals to</option>
                            <option value="contains" style="color: black;">Contains</option>
                            <option value="startswith" style="color: black;">Starts with</option>
                            <option value="endswith" style="color: black;">Ends with</option>
                            <option value="greater" style="color: black;">Greater than</option>
                            <option value="less" style="color: black;">Less than</option>
                        </select>
                    </div>
                    <div class="filter-value" style="margin-bottom: 12px;">
                        <label style="display: block; margin-bottom: 6px; font-weight: bold; font-size: 13px; color: #333;">Value:</label>
                        <input type="text" class="filter-value-input" placeholder="Enter filter value" style="width: 100%; padding: 8px; border: 1px solid #999; border-radius: 4px; font-size: 13px; box-sizing: border-box;">
                    </div>
                    <div style="display: flex; gap: 6px;">
                        <button class="filter-apply-btn" type="button" style="flex: 1; padding: 8px; background: #007bff; color: white; border: none; border-radius: 3px; cursor: pointer; font-size: 13px; font-weight: bold; transition: background 0.2s;">Apply</button>
                        <button class="filter-clear-btn" type="button" style="flex: 1; padding: 8px; background: #6c757d; color: white; border: none; border-radius: 3px; cursor: pointer; font-size: 13px; font-weight: bold; transition: background 0.2s;">Clear</button>
                    </div>
                </div>
            `);
            
            // Append filter button and menu to header
            $th.append(filterBtn);
            $th.append(filterMenu);
            
            // Make TH able to hold positioned elements
            $th.css({
                'position': 'relative',
                'white-space': 'nowrap',
                'overflow': 'visible'
            });
        });
        
        console.log('Filter UI created for all columns');
    }

    // Define columns that should have unique data dropdowns
    const dropdownColumns = {
        3: { name: 'gender', label: 'Gender' },
        4: { name: 'dept_code', label: 'Department Code' },
        5: { name: 'dept_desc', label: 'Department' },
        6: { name: 'desig', label: 'Designation' },
        7: { name: 'cata_desc', label: 'Category' },
        17: { name: 'contractor_name', label: 'Contractor Name' },
        18: { name: 'status_name', label: 'Status' },
        19: { name: 'pay_scheme', label: 'Pay Scheme' },
        20: { name: 'isactive', label: 'Active Status' }
    };

    let uniqueDataCache = {};

    // Initialize DataTable
    const table = $('#employeeVowTable').DataTable({
        processing: true,
        serverSide: false,
        scrollX: true,
        ajax: {
            url: baseUrl + 'admin/reports/Employee_vow_report/get_employeevowdata',
            type: 'GET',
            dataType: 'json',
            data: function(d) {
                return $.extend({}, d, {
                    date_of_join_from: '',
                    date_of_join_to: '',
                    departments: '',
                    contractors: '',
                    designations: '',
                    status: ''
                });
            },
            dataSrc: function(json) {
                console.log('=== API Response ===');
                console.log('Full Response:', json);
                console.log('Has error?', json.error);
                console.log('Data array:', json.data);
                console.log('Data count:', json.data ? json.data.length : 0);
                
                if (!json) {
                    console.error('Empty response from API');
                    showError('No response from server');
                    return [];
                }
                if (json.error) {
                    console.error('API Error:', json.message);
                    showError('Error: ' + (json.message || 'Unknown error loading data'));
                    return [];
                }
                if (!json.data || !Array.isArray(json.data)) {
                    console.warn('Data is not an array:', json.data);
                    showError('Invalid data format from server');
                    return [];
                }
                
                console.log('Success! Loading ' + json.data.length + ' records');
                hideError();
                
                // Extract unique values for dropdown columns
                extractUniqueValues(json.data);
                
                return json.data;
            },
            error: function(xhr, error, thrown) {
                console.error('AJAX Error Details:', {
                    status: xhr.status,
                    statusText: xhr.statusText,
                    error: error,
                    thrown: thrown,
                    response: xhr.responseText
                });
                const errorMsg = xhr.status + ' ' + xhr.statusText;
                showError('Failed to load data: ' + errorMsg);
                $('#loadingSpinner').removeClass('active');
            },
            beforeSend: function() {
                console.log('API Call Starting - URL:', baseUrl + 'admin/reports/Employee_vow_report/get_employeevowdata');
                $('#loadingSpinner').addClass('active');
            },
            complete: function(xhr, status) {
                console.log('API Call Complete - Status:', status);
                $('#loadingSpinner').removeClass('active');
            }
        },
        columns: [
            { data: 'eb_id', title: 'Employee ID' },
            { data: 'emp_code', title: 'Employee Code' },
            { data: 'emp_name', title: 'Employee Name' },
            { data: 'gender', title: 'Gender' },
            { data: 'dept_code', title: 'Department Code' },
            { data: 'dept_desc', title: 'Department Description' },
            { data: 'desig', title: 'Designation' },
            { data: 'cata_desc', title: 'Category' },
            { data: 'date_of_birth', title: 'Date of Birth' },
            { data: 'date_of_join', title: 'Date of Join' },
            { data: 'esi_no', title: 'ESI Number' },
            { data: 'pf_no', title: 'PF Number' },
            { data: 'pf_date_of_join', title: 'PF Date of Join' },
            { data: 'pf_uan_no', title: 'PF UAN Number' },
            { data: 'bank_acc_no', title: 'Bank Account Number' },
            { data: 'ifsc_code', title: 'IFSC Code' },
            { data: 'bank_name', title: 'Bank Name' },
            { data: 'contractor_name', title: 'Contractor Name' },
            { data: 'status_name', title: 'Status' },
            { data: 'pay_scheme', title: 'Pay Scheme' },
            { data: 'isactive', title: 'Active Status' },
            { data: 'last_workings', title: 'Last Working Date' }
        ],
        paging: true,
        pageLength: 10,
        lengthChange: false,
        searching: true,
        ordering: true,
        autoWidth: false,
        responsive: false,
        dom: 'lf<"dataTables_scroll"t>ip',
        language: {
            emptyTable: 'No employee records found',
            zeroRecords: 'No matching records found',
            info: 'Showing _START_ to _END_ of _TOTAL_ records'
        },
        initComplete: function() {
            console.log('✓ DataTable initialized with ' + this.api().rows().count() + ' rows');
            createFilterUI();
            
            // Wait a brief moment for DOM to fully settle, then update dropdowns
            setTimeout(function() {
                console.log('Calling updateDropdownFilters after brief delay...');
                updateDropdownFilters();
            }, 100);
            
            fixFilterIcons();
        },
        drawCallback: function() {
            console.log('✓ DataTable redrawn with ' + this.api().rows().count() + ' visible rows');
            createFilterUI();
            
            setTimeout(function() {
                updateDropdownFilters();
            }, 100);
            
            fixFilterIcons();
        }
    });

    // Extract unique values from table data for dropdown filters
    function extractUniqueValues(data) {
        console.log('Extracting unique values for dropdown columns...');
        console.log('Data array length:', data ? data.length : 0);
        uniqueDataCache = {};
        
        // Initialize each dropdown column
        Object.keys(dropdownColumns).forEach(colIndex => {
            uniqueDataCache[colIndex] = [];
        });
        
        // Process each row in the data array
        if (data && Array.isArray(data)) {
            data.forEach((rowData, index) => {
                // Extract unique values for each dropdown column
                Object.keys(dropdownColumns).forEach(colIndex => {
                    const fieldName = dropdownColumns[colIndex].name;
                    const value = rowData[fieldName];
                    
                    if (value && value !== '') {
                        // Add value only if not already present
                        if (!uniqueDataCache[colIndex].includes(value)) {
                            uniqueDataCache[colIndex].push(value);
                        }
                    }
                });
            });
        }
        
        // Sort the unique values
        Object.keys(uniqueDataCache).forEach(colIndex => {
            uniqueDataCache[colIndex].sort();
            console.log(`Column ${colIndex}: ${uniqueDataCache[colIndex].length} unique values -`, uniqueDataCache[colIndex].slice(0, 3));
        });
        
        console.log('Unique values extraction complete:', uniqueDataCache);
    }

    // Update filter dropdowns with unique values
    function updateDropdownFilters() {
        console.log('=== Updating dropdown filters ===');
        console.log('dropdownColumns:', dropdownColumns);
        console.log('uniqueDataCache:', uniqueDataCache);
        
        let updatedCount = 0;
        
        Object.keys(dropdownColumns).forEach(colIndex => {
            console.log(`Processing column ${colIndex}...`);
            
            const $th = $(`th[data-column="${colIndex}"]`);
            console.log(`Found th element for column ${colIndex}:`, $th.length > 0);
            
            if ($th.length === 0) {
                console.warn(`Could not find th[data-column="${colIndex}"]`);
                return;
            }
            
            const $filterMenu = $th.find('.filter-dropdown-menu');
            console.log(`Found filter menu for column ${colIndex}:`, $filterMenu.length > 0);
            
            if ($filterMenu.length === 0) {
                console.warn(`Could not find filter menu for column ${colIndex}`);
                return;
            }
            
            const $filterOperator = $filterMenu.find('.filter-operator');
            const $filterValue = $filterMenu.find('.filter-value');
            
            console.log(`Found filter operator: ${$filterOperator.length > 0}, filter value: ${$filterValue.length > 0}`);
            
            // Update filter type select to only show "equals" option
            const filterTypeSelect = $filterOperator.find('.filter-type-select');
            filterTypeSelect.html(`
                <option value="" style="color: #999;">-- No Filter --</option>
                <option value="equals" style="color: black;">Equals to</option>
            `);
            
            let uniqueValues = uniqueDataCache[colIndex] || [];
            console.log(`Column ${colIndex} has ${uniqueValues.length} unique values`);
            
            // Create dropdown with unique values
            const optionsHtml = uniqueValues.map(val => `<option value="${escapeHtml(val)}">${escapeHtml(val)}</option>`).join('');
            
            const $input = $filterValue.find('.filter-value-input');
            console.log(`Found input field for column ${colIndex}:`, $input.length > 0);
            
            const dropdownHtml = `
                <select class="filter-value-input filter-multiselect-${colIndex}" multiple="multiple" data-column="${colIndex}" style="width: 100%; padding: 8px; border: 1px solid #999; border-radius: 4px; font-size: 13px; box-sizing: border-box; background-color: white; color: black; cursor: pointer;">
                    ${optionsHtml}
                </select>
            `;
            
            $input.replaceWith(dropdownHtml);
            
            // Initialize Select2 on the new dropdown with checkboxes
            const $newSelect = $filterValue.find(`.filter-multiselect-${colIndex}`);
            if ($.fn.select2) {
                $newSelect.select2({
                    width: '100%',
                    placeholder: 'Search and select...',
                    allowClear: true,
                    theme: 'bootstrap4',
                    closeOnSelect: false,
                    templateResult: function(data) {
                        if (!data.id) return data.text;
                        
                        // Display checkbox next to each option
                        const $div = $('<div class="select2-checkbox-option"></div>');
                        $div.append($('<input type="checkbox" class="select2-checkbox">'));
                        $div.append($('<span>' + escapeHtml(data.text) + '</span>'));
                        return $div;
                    },
                    templateSelection: function(data) {
                        if (!Array.isArray(data)) {
                            data = [data];
                        }
                        if (data.length === 0) {
                            return 'Select options...';
                        } else if (data.length === 1) {
                            return data[0].text;
                        } else {
                            return data.length + ' selected';
                        }
                    }
                });
                
                // Update checkboxes to reflect current selection state
                $newSelect.on('select2:open', function() {
                    const selectedValues = $(this).val() || [];
                    
                    setTimeout(function() {
                        $('.select2-dropdown .select2-result-selectable').each(function() {
                            const $option = $(this).find('option');
                            const value = $option.val();
                            const isSelected = selectedValues.includes(value);
                            $(this).find('.select2-checkbox').prop('checked', isSelected);
                        });
                    }, 10);
                });
                
                // Handle checkbox clicks within the dropdown
                $(document).on('click', '.select2-dropdown .select2-checkbox', function(e) {
                    e.stopPropagation();
                    
                    // Toggle the underlying option
                    const $option = $(this).closest('.select2-result-selectable').find('option');
                    const newState = !$(this).is(':checked');
                    $option.prop('selected', newState);
                    
                    // Trigger change on the select element
                    $option.closest('select').trigger('change');
                    
                    // Update checkbox visual state
                    $(this).prop('checked', newState);
                });
                
                // Update checkboxes after any change
                $newSelect.on('change', function() {
                    const selectedValues = $(this).val() || [];
                    
                    setTimeout(function() {
                        $('.select2-dropdown .select2-result-selectable').each(function() {
                            const $option = $(this).find('option');
                            const value = $option.val();
                            const isSelected = selectedValues.includes(value);
                            $(this).find('.select2-checkbox').prop('checked', isSelected);
                        });
                    }, 10);
                });
            }
            
            updatedCount++;
            console.log(`✓ Updated dropdown for column ${colIndex} with ${uniqueValues.length} values (Select2 with checkboxes enabled)`);
        });
        
        console.log(`=== Dropdown update complete: ${updatedCount} columns updated ===`);
    }

    // Helper function to escape HTML special characters
    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, function(m) { return map[m]; });
    }

    // Helper function to fix filter icons visibility (called after each render)
    function fixFilterIcons() {
        console.log('Fixing filter icons...');
        
        // Ensure header is sticky
        $('table.dataTable thead').css({
            'position': 'sticky',
            'top': '0',
            'z-index': '100',
            'background-color': '#f8f9fa'
        });
        
        $('table.dataTable thead th').css({
            'position': 'sticky',
            'top': '0',
            'z-index': '100',
            'background-color': '#f8f9fa',
            'overflow': 'visible'
        });
        
        // Show all filter icon buttons
        $('.filter-icon-btn').each(function() {
            $(this).removeAttr('style');
            $(this).css({
                'display': 'inline-block',
                'visibility': 'visible',
                'opacity': '1',
                'z-index': '200',
                'width': '16px',
                'height': '16px',
                'padding': '0 2px',
                'margin': '0 2px',
                'border': 'none',
                'background': 'none',
                'cursor': 'pointer',
                'color': '#666',
                'vertical-align': 'top',
                'font-size': '14px'
            });
            
            // Show icon inside button
            $(this).find('i').css({
                'display': 'inline-block',
                'visibility': 'visible',
                'opacity': '1',
                'width': '12px',
                'height': '12px',
                'color': '#666',
                'font-size': '12px'
            });
        });
        
        // Ensure header wrappers are properly styled
        $('.column-header-filter-wrapper').css({
            'padding': '10px 8px',
            'vertical-align': 'middle',
            'white-space': 'nowrap',
            'overflow': 'visible',
            'background-color': '#f8f9fa',
            'height': 'auto'
        });
        
        // Ensure column header titles display properly
        $('.column-header-title').css({
            'display': 'flex',
            'align-items': 'center',
            'gap': '2px',
            'overflow': 'visible',
            'white-space': 'normal'
        });
        
        // Show all spans in titles
        $('.column-header-title span').css({
            'white-space': 'nowrap',
            'overflow': 'visible'
        });
    }
    
    // Setup infinite scroll functionality
    function setupInfiniteScroll() {
        // Infinite scroll disabled - using traditional pagewise pagination (1, 2, 3, etc.)
    }

    // Filter Icon Button Click - Toggle Dropdown
    $(document).on('click', '.filter-icon-btn', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        const $btn = $(this);
        const $menu = $btn.closest('th').find('.filter-dropdown-menu');
        
        // Hide all other menus
        $('.filter-dropdown-menu').not($menu).removeClass('active').hide();
        
        // Toggle this menu
        $menu.toggleClass('active');
        if ($menu.hasClass('active')) {
            $menu.show();
        } else {
            $menu.hide();
        }
        
        console.log('Filter icon clicked, menu visible:', $menu.is(':visible'));
    });

    // Close filter menu when clicking outside
    $(document).on('click', function(e) {
        const $target = $(e.target);
        // Don't close if clicking on filter button or inside the menu
        if (!$target.closest('.filter-icon-btn').length && !$target.closest('.filter-dropdown-menu').length) {
            $('.filter-dropdown-menu').removeClass('active').hide();
        }
    });

    // Prevent closing menu when clicking inside it
    $(document).on('click', '.filter-dropdown-menu', function(e) {
        e.stopPropagation();
    });

    // Log filter type changes
    $(document).on('change', '.filter-type-select', function(e) {
        const selectedValue = $(this).val();
        console.log('Filter type selected:', selectedValue);
    });

    // Apply Filter Button
    $(document).on('click', '.filter-apply-btn', function() {
        const $filterMenu = $(this).closest('.filter-dropdown-menu');
        const filterType = $filterMenu.find('.filter-type-select').val();
        let filterValues = $filterMenu.find('.filter-value-input').val();
        
        // Convert to array if it's a Select2 multi-select
        if (!Array.isArray(filterValues)) {
            filterValues = filterValues ? [filterValues] : [];
        }
        
        const $th = $filterMenu.closest('th');
        const columnIndex = $th.index();
        
        console.log('Apply filter - Column:', columnIndex, 'Type:', filterType, 'Values:', filterValues);
        
        if (!filterType || filterValues.length === 0) {
            console.log('No filter type or values selected');
            return;
        }
        
        // Apply DataTables search with custom filtering
        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            if (!filterType || filterValues.length === 0) return true;
            
            const cellValue = data[columnIndex] ? data[columnIndex].toString().toLowerCase() : '';
            
            // Check if cell value matches any of the selected values
            for (let value of filterValues) {
                const searchValue = value.toLowerCase();
                
                switch(filterType) {
                    case 'equals':
                        if (cellValue === searchValue) return true;
                        break;
                    case 'contains':
                        if (cellValue.includes(searchValue)) return true;
                        break;
                    case 'startswith':
                        if (cellValue.startsWith(searchValue)) return true;
                        break;
                    case 'endswith':
                        if (cellValue.endsWith(searchValue)) return true;
                        break;
                    case 'greater':
                        if (parseFloat(cellValue) > parseFloat(searchValue)) return true;
                        break;
                    case 'less':
                        if (parseFloat(cellValue) < parseFloat(searchValue)) return true;
                        break;
                }
            }
            return false;
        });
        
        table.draw();
        
        // Mark header column as filtered
        $th.addClass('column-filtered');
        
        // Mark filter button as active
        $th.find('.filter-icon-btn').addClass('active-filter');
        
        // Add highlighting to visible rows after filter is applied
        setTimeout(function() {
            // Remove all existing highlights
            $('#employeeVowTable tbody tr').removeClass('filter-highlight');
            
            // Add highlight to currently visible rows
            $('#employeeVowTable tbody tr:visible').addClass('filter-highlight');
            
            console.log('Highlighted ' + $('#employeeVowTable tbody tr.filter-highlight').length + ' filtered rows');
        }, 50);
        
        $filterMenu.removeClass('active').hide();
    });
    
    // Clear Filter Button
    $(document).on('click', '.filter-clear-btn', function() {
        const $filterMenu = $(this).closest('.filter-dropdown-menu');
        const $th = $filterMenu.closest('th');
        
        $filterMenu.find('.filter-type-select').val('');
        const $input = $filterMenu.find('.filter-value-input');
        
        // Clear Select2 if it exists
        if ($input.data('select2')) {
            $input.val(null).trigger('change');
        } else {
            $input.val('');
        }
        
        // Clear all search filters
        $.fn.dataTable.ext.search.length = 0;
        table.draw();
        
        // Remove column header highlighting
        $th.removeClass('column-filtered');
        
        // Remove active filter indicator from button
        $th.find('.filter-icon-btn').removeClass('active-filter');
        
        // Remove highlighting after filter is cleared
        setTimeout(function() {
            $('#employeeVowTable tbody tr').removeClass('filter-highlight');
            console.log('All highlights removed');
        }, 50);
        
        $filterMenu.removeClass('active').hide();
        console.log('Filter cleared');
    });

    // Function to apply filter based on operator
    function applyColumnFilter(dataTable, columnIndex) {
        if (columnFilters[columnIndex]) {
            const filter = columnFilters[columnIndex];
            dataTable.column(columnIndex).search('').draw();
            
            // Apply custom search function
            dataTable.column(columnIndex).search(
                function(searchStr, index, cellData) {
                    return checkFilterMatch(cellData, filter.operator, filter.value);
                },
                true,
                false
            ).draw();
        } else {
            dataTable.column(columnIndex).search('').draw();
        }
    }

    // Function to check if cell data matches filter condition
    function checkFilterMatch(cellValue, operator, filterValue) {
        if (!cellValue) cellValue = '';
        cellValue = cellValue.toString().toLowerCase();
        filterValue = filterValue.toLowerCase();

        switch(operator) {
            case 'equals':
                return cellValue === filterValue;
            case 'contains':
                return cellValue.indexOf(filterValue) !== -1;
            case 'startswith':
                return cellValue.startsWith(filterValue);
            case 'endswith':
                return cellValue.endsWith(filterValue);
            case 'greater':
                return cellValue > filterValue;
            case 'less':
                return cellValue < filterValue;
            default:
                return true;
        }
    }

    // Populate column toggle menu
    const columnLabels = [
        'Employee ID', 'Employee Code', 'Employee Name', 'Gender', 'Department Code',
        'Department Description', 'Designation', 'Category', 'Date of Birth', 'Date of Join',
        'ESI Number', 'PF Number', 'PF Date of Join', 'PF UAN Number', 'Bank Account Number',
        'IFSC Code', 'Bank Name', 'Contractor Name', 'Status', 'Pay Scheme',
        'Active Status', 'Last Working Date'
    ];

    let toggleMenuHtml = '';
    columnLabels.forEach((label, index) => {
        toggleMenuHtml += `<label><input type="checkbox" class="column-toggle-checkbox" data-column="${index}" checked> ${label}</label>`;
        columnVisibility[index] = true;
    });
    $('#columnToggleMenu').html(toggleMenuHtml);

    // Column toggle functionality
    $('#columnToggleBtn').on('click', function(e) {
        e.stopPropagation();
        $('#columnToggleMenu').toggleClass('active');
    });

    $(document).on('click', function(e) {
        if (!$(e.target).closest('#columnToggleBtn, #columnToggleMenu').length) {
            $('#columnToggleMenu').removeClass('active');
        }
    });

    $('.column-toggle-checkbox').on('change', function() {
        const columnIndex = $(this).data('column');
        const isVisible = $(this).is(':checked');
        columnVisibility[columnIndex] = isVisible;
        table.column(columnIndex).visible(isVisible);
        localStorage.setItem('columnVisibility', JSON.stringify(columnVisibility));
    });

    // Load column visibility from localStorage
    const savedVisibility = localStorage.getItem('columnVisibility');
    if (savedVisibility) {
        columnVisibility = JSON.parse(savedVisibility);
        Object.keys(columnVisibility).forEach(index => {
            const isVisible = columnVisibility[index];
            table.column(index).visible(isVisible);
            $(`[data-column="${index}"]`).prop('checked', isVisible);
        });
    }

    // Load data on page load
    console.log('=== INITIATING DATA LOAD ===');
    table.ajax.reload(function(json) {
        console.log('=== Data Reload Callback ===');
        console.log('JSON parameter:', json);
        console.log('Total Records:', json.recordsTotal || 0);
        console.log('Records per page: 10');
        
        if (json && json.data) {
            if (json.data.length > 0) {
                console.log('✓ SUCCESS! Loaded ' + json.data.length + ' employee records on this page');
                console.log('First record sample:', json.data[0]);
                console.log('Total records in table:', table.rows().count());
                
                // Fix filter icons, update dropdowns, and adjust columns
                setTimeout(function() {
                    table.columns.adjust();
                    createFilterUI();
                    updateDropdownFilters();
                    fixFilterIcons();
                    console.log('Visible row count after display:', table.rows().count());
                }, 100);
            } else {
                console.log('⚠ No records found in database for this company');
                showError('No employee records found. Please check if data exists in the database.');
            }
        } else {
            console.log('✗ FAILED: json.data is undefined or null');
        }
    }, false);

    // Adjust columns on window resize and fix filter icons
    $(window).on('resize', function() {
        table.columns.adjust();
        fixFilterIcons();
    });
    
    // Periodically ensure filter icons are visible
    setInterval(function() {
        const visibleButtons = $('.filter-icon-btn:visible').length;
        const totalButtons = $('.filter-icon-btn').length;
        if (visibleButtons < totalButtons) {
            console.warn('Some filter icons hidden (' + visibleButtons + '/' + totalButtons + '), restoring...');
            fixFilterIcons();
        }
    }, 1000);

    console.log('✓ DataTable initialization complete');

    // Reset Filters button
    $('#resetBtn').on('click', function() {
        // Clear all column filters
        $('.filter-dropdown-menu').each(function() {
            $(this).find('.filter-type-select').val('');
            $(this).find('.filter-value-input').val('').trigger('change');
            $(this).removeClass('active').hide();
        });

        // Clear filter icons
        $('.filter-icon-btn').removeClass('filtered').removeClass('active-filter');

        // Remove highlighting from all column headers
        $('table.dataTable thead th').removeClass('column-filtered');

        // Clear stored filters
        columnFilters = {};

        // Clear all column searches
        table.columns().every(function() {
            this.search('');
        });
        
        // Clear all DataTables ext search filters
        $.fn.dataTable.ext.search.length = 0;
        
        table.draw();
        
        // Remove all highlighting
        setTimeout(function() {
            $('#employeeVowTable tbody tr').removeClass('filter-highlight');
            console.log('All filters and highlights cleared');
        }, 50);
    });

    // Quick Search functionality
    $('#quickSearchInput').on('keyup', function() {
        const searchValue = $(this).val().toLowerCase();
        
        if (!searchValue) {
            // Clear search filter
            table.search('').draw();
        } else {
            // Search across all columns
            table.search(searchValue).draw();
        }
        
        console.log('Quick search:', searchValue);
    });

    // Export to Excel button
    $('#exportBtn').on('click', function() {
        const filters = {
            date_of_join_from: '',
            date_of_join_to: '',
            departments: '',
            contractors: '',
            designations: '',
            status: ''
        };

        const queryString = Object.keys(filters)
            .map(k => encodeURIComponent(k) + '=' + encodeURIComponent(filters[k]))
            .join('&');

        window.location = baseUrl + 'admin/reports/Employee_vow_report/get_employeevowdataexl?' + queryString;
        
        // Clear localStorage after download
        setTimeout(() => {
            localStorage.removeItem('columnVisibility');
        }, 500);
    });

    // Print button click
    $('#printBtn').on('click', function() {
        printTable();
    });

    function printTable() {
        const printWindow = window.open('', '', 'height=600,width=900');
        printWindow.document.write('<html><head><title>Employee VOW Report</title>');
        printWindow.document.write('<link rel="stylesheet" href="' + baseUrl + 'public/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">');
        printWindow.document.write('<style>');
        printWindow.document.write('body { font-family: Arial, sans-serif; margin: 20px; }');
        printWindow.document.write('h2 { text-align: center; }');
        printWindow.document.write('table { border-collapse: collapse; width: 100%; }');
        printWindow.document.write('th, td { border: 1px solid #ddd; padding: 8px; text-align: left; font-size: 12px; }');
        printWindow.document.write('th { background-color: #f5f5f5; font-weight: bold; }');
        printWindow.document.write('tr:nth-child(even) { background-color: #f9f9f9; }');
        printWindow.document.write('.print-date { text-align: center; font-size: 12px; margin-bottom: 10px; }');
        printWindow.document.write('@media print { body { margin: 0; } .no-print { display: none; } }');
        printWindow.document.write('</style>');
        printWindow.document.write('</head><body>');
        printWindow.document.write('<h2>Employee VOW Report</h2>');
        printWindow.document.write('<div class="print-date">Generated on: ' + new Date().toLocaleString() + '</div>');
        
        // Get visible columns only
        let tableHtml = '<table border="1" cellpadding="5" cellspacing="0">';
        
        // Header
        tableHtml += '<thead><tr>';
        table.columns().visible().each(function(index) {
            if (table.column(index).visible()) {
                const header = table.column(index).header();
                tableHtml += '<th>' + $(header).find('.column-header-title span').text() + '</th>';
            }
        });
        tableHtml += '</tr></thead>';
        
        // Data rows
        tableHtml += '<tbody>';
        table.rows({search: 'applied'}).nodes().to$().each(function() {
            tableHtml += $(this).prop('outerHTML');
        });
        tableHtml += '</tbody>';
        tableHtml += '</table>';
        
        printWindow.document.write(tableHtml);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    }

    function showError(message) {
        $('#errorMessage').text(message).show();
    }

    function hideError() {
        $('#errorMessage').hide();
    }
});
</script>
