<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// application/models/CSVModel.php

class Daily_batch_report_Model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    public function readCSV($file_path) {
        $csv_data = array();

        if (file_exists($file_path)) {
            $csv_data = array_map('str_getcsv', file($file_path));
        }

        return $csv_data;
    }

    public function insertCSVData($file_path) {
        if (file_exists($file_path)) {
            echo "<br>".$file_path."</br>";
            $csv_data = array_map('str_getcsv', file($file_path));
            var_dump($csv_data);
            $n=1;
            foreach ($csv_data as $row) {
                echo $n.'=';
                echo $row[0];
                echo $row[1];
                echo $row[2];
                echo $row[3];
                echo $row[4];
                echo $row[5];
                echo $row[6];
                echo $row[7];
                echo $row[8]."<br>";
                $n++;

                $data = array(
              //      'column1' => $row[0], // Adjust column index as needed
              //      'column2' => $row[1], // Adjust column index as needed
                    // ... Add columns for your CSV data
                );

             //   $this->db->insert('csv_data', $data);
            }
        }
    }



}
