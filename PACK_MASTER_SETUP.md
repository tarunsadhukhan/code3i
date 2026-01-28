# Pack Master Table Creation Instructions

## Method 1: Using phpMyAdmin (Recommended for Windows)

1. Open phpMyAdmin in your browser: `http://localhost/phpmyadmin`
2. Select the `EMPMILL12` database from the left sidebar
3. Click on the "SQL" tab at the top
4. Copy and paste the following SQL code:

```sql
CREATE TABLE IF NOT EXISTS pack_master (
  pack_id         BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  packcode        SMALLINT   NULL,
  packing         CHAR(10)   NULL,
  calc            CHAR(1)    NULL,
  shr_pack        CHAR(5)    NULL,
  user_id         INT        NULL,
  ent_date_time   DATETIME   NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (pack_id),
  KEY idx_packmast_packcode (packcode),
  KEY idx_packmast_packing (packing)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

5. Click "Go" to execute the query
6. You should see the success message

## Method 2: Using CodeIgniter Migrations

1. The migration file is already created at: `application/migrations/001_create_pack_master.php`
2. Configure migrations in `application/config/migration.php` if not already done:
   ```php
   $config['migration_enabled'] = TRUE;
   $config['migration_type'] = 'sequential';
   $config['migration_path'] = APPPATH.'migrations/';
   ```
3. Access migration via controller or CLI command

## Table Details

- **pack_id**: Auto-increment primary key
- **packcode**: Numeric code for packing (SMALLINT)
- **packing**: Packing name/description (CHAR 10)
- **calc**: Calculation flag (CHAR 1)
- **shr_pack**: Short pack code (CHAR 5)
- **user_id**: User who created the record (INT)
- **ent_date_time**: Timestamp (auto-updated)

## What's New in Receipt Entry

The following fields have been converted to dropdowns:
- **Quality**: Now pulls from `jutemaster` table
- **Godown**: Now pulls from `godownmaster` table
- **Unit**: Now pulls from `pack_master` table (Packing)

All dropdowns load automatically on page load and are marked as required fields.
