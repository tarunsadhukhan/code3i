<?php
require_once APPPATH . 'libraries/fpdf.php'; // Adjust path for CI4 if needed

class Fpdf_lib extends FPDF {
    public function __construct() {
        parent::__construct();
    }
}
