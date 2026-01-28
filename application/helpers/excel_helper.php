<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//require_once APPPATH . 'third_party/PhpSpreadsheet/vendor/autoload.php';
//require_once FCPATH . 'vendor/autoload.php';


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

function export_to_excel($data, $filename)
{
    // The existing export_to_excel function goes here
    // ...
}

function export_to_csv($data, $filename)
{
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->fromArray($data, NULL, 'A1');

    $writer = new Csv($spreadsheet);
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename="' . $filename . '.csv"');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
    exit;
}
