-- Create pack_master table
CREATE TABLE IF NOT EXISTS pack_master (
  pack_id         BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  packcode        SMALLINT   NULL,        -- Numeric(4)
  packing         CHAR(10)   NULL,
  calc            CHAR(1)    NULL,
  shr_pack        CHAR(5)    NULL,
  user_id         INT        NULL,
  ent_date_time   DATETIME   NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (pack_id),
  KEY idx_packmast_packcode (packcode),
  KEY idx_packmast_packing (packing)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
