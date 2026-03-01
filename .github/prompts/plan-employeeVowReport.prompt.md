# Employee VOW Data Report - Implementation Plan

## Overview
Create a comprehensive Employee VOW (Vowel/Verify of Work) report with searchable, filterable columns (like Excel filters), column visibility toggle, print functionality, and Excel export. The report will be accessible as a new submenu item under the Reports menu.

---

## Database Clarification Required ⚠️
**PENDING:** Which database contains the HRMS tables referenced in the SQL?
- `tbl_hrms_ed_personal_details`
- `tbl_hrms_ed_official_details`
- `tbl_hrms_ed_bank_details`
- `tbl_hrms_ed_esi`
- `tbl_hrms_ed_pf`
- `department_master`, `designation`, `category_master`, `contractor_master`, `status_master`

Possible options:
- [ ] `empmill12` (secondary database)
- [ ] Main CodeIgniter database (from config/database.php)
- [ ] Different database (specify name in connector variable)

**Action:** Once confirmed, the database connection will be initialized in the controller's `__construct()` method.

---

## Files to Create/Modify

### 1. **Model** - `application/models/Employee_vow_report_model.php`
**Purpose:** Handle all database queries for employee VOW data

**Key Methods:**
- `getEmployeeVowData($companyId, $filters = [])` - Main query with optional date range, department, contractor, status filters
- `getDepartmentMaster($companyId)` - For filter dropdown (Department)
- `getContractorMaster($companyId)` - For filter dropdown (Contractor)
- `getStatusMaster()` - For filter dropdown (Status)
- `getDesignationMaster($companyId)` - For filter dropdown (Designation)

**Database Pattern:**
```php
// Multiple database support
public function __construct() {
    parent::__construct();
    $this->load->database();
    $this->load->database('empmill12', TRUE);  // Or appropriate database name
}
```

---

### 2. **Controller** - `application/controllers/admin/reports/Employee_vow_report.php`
**Purpose:** Handle requests, business logic, and responses

**Key Methods:**
- `index()` - Load the report view with filter dropdowns
- `get_employeevowdata()` - AJAX endpoint returning JSON for DataTables
- `get_employeevowdataexl()` - Excel export with filters applied

**Features:**
- Session validation for company_id
- Parameter validation from GET/POST requests
- JSON response for AJAX
- Excel file generation with formatting

---

### 3. **View** - `application/views/admin/reports/Employee_vow_report.php`
**Purpose:** Display the report UI with filters, DataTable, and export buttons

**Sections:**
1. **Header & Navigation** - `admin/header` include
2. **Filter Form** - Date range, Department, Contractor, Designation, Status dropdowns
3. **Action Buttons** - Search, Reset, Excel Export, Print
4. **DataTable Container** - Searchable, sortable, with column visibility toggle
5. **Footer & Navigation** - `admin/footer` include

**UI Libraries:**
- **DataTables** - Main table with search, sort, pagination
- **Select2** - Multi-select dropdowns for filters
- **jQuery UI Datepicker** - Date range selection
- **Bootstrap 4** - Responsive layout
- **Print.js** - Print functionality for table

---

### 4. **Menu Update** - `application/views/admin/header.php`
**Location:** Line 237 onwards (Reports menu section)

**New Menu Item:**
```html
<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-chart-bar"></i>
        <p> Reports <i class="right fas fa-angle-left"></i></p>
    </a>
    <ul class="nav nav-treeview">
        <!-- Existing menu items -->
        <li class="nav-item">
            <a href="<?php echo base_url().'admin/reports/Employee_vow_report'; ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Employee VOW Report</p>
            </a>
        </li>
        <!-- Other existing items -->
    </ul>
</li>
```

---

## SQL Query to be Executed

```sql
SELECT 
    thepd.eb_id,                               -- Employee ID
    theod.emp_code,                            -- Employee Code
    CONCAT(first_name, ' ', IFNULL(middle_name, ' '), ' ', 
           IFNULL(last_name, ' ')) AS emp_name, -- Full Name
    thepd.gender,                              -- Gender
    dm.dept_code,                              -- Department Code
    dm.dept_desc,                              -- Department Description
    d.desig,                                   -- Designation
    cm.cata_desc,                              -- Category Description
    thepd.date_of_birth,                       -- Date of Birth
    theod.date_of_join,                        -- Date of Join
    thee.esi_no,                               -- ESI Number
    thep.pf_no,                                -- PF Number
    thep.pf_date_of_join,                      -- PF Date of Join
    thep.pf_uan_no,                            -- PF UAN Number
    thebd.bank_acc_no,                         -- Bank Account Number
    thebd.ifsc_code,                           -- IFSC Code
    thebd.bank_name,                           -- Bank Name
    cnt.contractor_name,                       -- Contractor Name
    sm.status_name,                            -- Status Name
    tps.NAME as pay_scheme,                    -- Pay Scheme
    CASE WHEN thepd.is_active=1 
         THEN 'Active' ELSE 'InActive' 
    END AS isactive,                           -- Active Status
    da.last_workings                           -- Last Working Date
FROM tbl_hrms_ed_personal_details thepd
LEFT JOIN tbl_hrms_ed_official_details theod ON thepd.eb_id=theod.eb_id AND theod.is_active=1
LEFT JOIN tbl_hrms_ed_bank_details thebd ON thepd.eb_id=thebd.eb_id AND thebd.is_active=1
LEFT JOIN tbl_hrms_ed_esi thee ON thepd.eb_id=thee.eb_id AND thee.is_active=1
LEFT JOIN tbl_hrms_ed_pf thep ON thepd.eb_id=thep.eb_id AND thep.is_active=1
LEFT JOIN department_master dm ON dm.dept_id=theod.department_id
LEFT JOIN designation d ON d.id=theod.designation_id
LEFT JOIN category_master cm ON cm.cata_id=theod.catagory_id
LEFT JOIN contractor_master cnt ON cnt.cont_id=theod.contractor_id
LEFT JOIN status_master sm ON sm.status_id=thepd.status
LEFT JOIN tbl_pay_employee_payscheme tpep ON thepd.eb_id=tpep.EMPLOYEEID AND tpep.STATUS=1
LEFT JOIN tbl_pay_scheme tps ON tps.ID=tpep.PAY_SCHEME_ID
LEFT JOIN (
    SELECT eb_id, MAX(attendance_date) as last_workings 
    FROM daily_attendance 
    WHERE is_active=1 
    GROUP BY eb_id
) da ON da.eb_id=thepd.eb_id
WHERE thepd.company_id=? AND theod.emp_code IS NOT NULL
ORDER BY cata_desc, emp_name
```

---

## Report Features

### 1. **Filter Form** (All optional, show results after submission)
- **Date Range:** Date of Join (from/to)
- **Department:** Multi-select dropdown (Select2)
- **Contractor:** Multi-select dropdown (Select2)
- **Designation:** Multi-select dropdown (Select2)
- **Status:** Active/InActive combo box
- **Search:** General text search (DataTables client-side)

### 2. **DataTable Columns** (21 columns total)
| # | Column Name | Searchable | Sortable | Filterable |
|---|---|---|---|---|
| 1 | Employee ID | ✓ | ✓ | - |
| 2 | Employee Code | ✓ | ✓ | - |
| 3 | Employee Name | ✓ | ✓ | - |
| 4 | Gender | - | ✓ | ✓ |
| 5 | Department Code | ✓ | ✓ | - |
| 6 | Department Description | ✓ | ✓ | ✓ |
| 7 | Designation | ✓ | ✓ | ✓ |
| 8 | Category | ✓ | ✓ | ✓ |
| 9 | Date of Birth | - | ✓ | - |
| 10 | Date of Join | - | ✓ | - |
| 11 | ESI Number | ✓ | ✓ | - |
| 12 | PF Number | ✓ | ✓ | - |
| 13 | PF Date of Join | - | ✓ | - |
| 14 | PF UAN Number | ✓ | ✓ | - |
| 15 | Bank Account Number | ✓ | ✓ | - |
| 16 | IFSC Code | ✓ | ✓ | - |
| 17 | Bank Name | ✓ | ✓ | - |
| 18 | Contractor Name | ✓ | ✓ | ✓ |
| 19 | Status | - | ✓ | ✓ |
| 20 | Pay Scheme | ✓ | ✓ | - |
| 21 | Active Status | - | ✓ | ✓ |
| 22 | Last Working Date | - | ✓ | - |

### 3. **Search & Filter** (DataTables style)
- Global search box (searches across all columns)
- Individual column filters (column headers with dropdown/text)
- DataTables built-in search highlighting

### 4. **Column Visibility Toggle**
- Button to show/hide columns
- Persist selection via localStorage (optional)
- Right-aligned toggle box

### 5. **Excel Export**
- **Filename:** `employee_vow_report_YYYY-MM-DD.xlsx`
- **Formatting:**
  - Header row with bold background color
  - Borders around all cells
  - Auto-fit column widths
  - Landscape orientation, A4 paper size
  - Frozen header row for better navigation
- **Data:** Include all filtered results with applied filters

### 6. **Print Functionality**
- Print.js library integration
- Print table with all visible columns
- Include report title and date
- Page break handling for multi-page reports
- Print stylesheet for proper formatting

---

## Technology Stack

| Layer | Technology | Usage |
|-------|-----------|-------|
| **Server-side** | PHP + CodeIgniter 3 | Controller & Model |
| **Database** | MySQL | HRMS tables with multi-join |
| **Frontend** | HTML5 + Bootstrap 4 | Responsive layout |
| **Table Rendering** | DataTables | Interactive table with search/sort |
| **Dropdown Filters** | Select2 + Bootstrap 4 theme | Multi-select filtering |
| **Date Selection** | jQuery UI Datepicker | Date range picking |
| **Excel Export** | PhpOffice\PhpSpreadsheet | XLSX file generation |
| **Printing** | Print.js | Client-side print handling |

---

## Implementation Steps

### Phase 1: Backend Setup
- [ ] Confirm database name for HRMS tables → Update plan
- [ ] Create `Employee_vow_report_model.php` with all query methods
- [ ] Create `Employee_vow_report.php` controller with index(), get_employeevowdata(), get_employeevowdataexl()
- [ ] Test model queries and AJAX endpoint

### Phase 2: Frontend - Report View
- [ ] Create `Employee_vow_report.php` view with header/footer
- [ ] Implement filter form (date range, dropdowns, buttons)
- [ ] Integrate DataTables with all columns
- [ ] Add global search box

### Phase 3: Interactivity
- [ ] Implement AJAX call to fetch filtered data
- [ ] Add DataTables client-side search and sorting
- [ ] Add column visibility toggle functionality
- [ ] Add print button with Print.js integration

### Phase 4: Export & Polish
- [ ] Implement Excel export with formatting and styling
- [ ] Add loading indicators and error handling
- [ ] Test all filters, export, and print functionality
- [ ] Optimize query performance (indexes if needed)

### Phase 5: Menu Integration
- [ ] Update `application/views/admin/header.php` with new menu item
- [ ] Test menu navigation
- [ ] Verify session-based access control

---

## File Checklist

**New Files to Create:**
- [ ] `application/models/Employee_vow_report_model.php`
- [ ] `application/controllers/admin/reports/Employee_vow_report.php`
- [ ] `application/views/admin/reports/Employee_vow_report.php`

**Files to Modify:**
- [ ] `application/views/admin/header.php` - Add menu item

**Dependencies (Already Available):**
- ✓ DataTables JS/CSS
- ✓ Select2 JS/CSS
- ✓ jQuery UI Datepicker JS/CSS
- ✓ Bootstrap 4
- ✓ PhpOffice\PhpSpreadsheet (Composer)
- ✓ Print.js (May need to add via CDN)

---

## Notes & Considerations

1. **Database Connection:** Must confirm which database contains the HRMS tables before proceeding with model creation.

2. **Company Filtering:** All queries will filter by `$this->session->userdata('company_id')` for multi-company support.

3. **Session Security:** The controller will validate session exists and redirect to login if not authenticated.

4. **Date Format Conversion:** 
   - UI displays as `dd-mm-yy` (jQuery UI Datepicker)
   - Database stored/queried as `YYYY-MM-DD`
   - Conversion handled in controller before passing to model

5. **Query Optimization:** The LEFT JOINs may benefit from indexes on:
   - `tbl_hrms_ed_personal_details.eb_id`
   - `tbl_hrms_ed_official_details.eb_id`
   - All foreign key joins

6. **AJAX Response Format:** Follows DataTables Server-side Processing format:
   ```json
   {
     "draw": 1,
     "recordsTotal": 1000,
     "recordsFiltered": 250,
     "data": [...]
   }
   ```

7. **Print.js:** If not already included in your project, add via CDN:
   ```html
   <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
   ```

---

## Questions for Refinement

- [ ] Which database should be used for HRMS tables? (PENDING)
- [ ] Should date filters be applied (Date of Join range) or optional?
- [ ] Should there be a maximum row limit for performance?
- [ ] Are there any specific styling preferences (colors, fonts)?
- [ ] Should the report include subtotals or summary statistics?
- [ ] Preferred column order in Excel export (same as display or different)?

---

**Status:** Ready for implementation once database confirmation is received.
**Created:** 2026-02-27
**Target Completion:** Estimated 2-3 hours for full implementation and testing
