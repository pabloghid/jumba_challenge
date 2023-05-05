<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class B3DataController extends Controller
{
    public function csv_reader(){
        ## TODO: dinamizar pela data
        $filename = base_path() . '\\temp\\LendingOpenPositionFile_20230502_1.csv';
        $handle = fopen($filename, "r");

        while ($row = fgetcsv($handle, 1000, ";")) {
            $csv_data[] = $row;
        }

        # retira o header
        $header = $csv_data[0];
        return $header;
        unset($csv_data[0]);


        print("<pre>" . print_r($csv_data, true) . "</pre>");
    }
}
