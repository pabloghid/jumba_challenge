<?php

namespace App\Services;

use App\Models\OpenPositions;

class InsertB3Data
{
    public function read_csv(){
        ## TODO: dinamizar pela data
        $filename = base_path() . '\temp\LendingOpenPositionFile_20230503_1.csv';
        $handle = fopen($filename, "r");

        while ($row = fgetcsv($handle, 1000, ";")) {
            $csv_data[] = $row;
        }

        # retira o header
        unset($csv_data[0]);

        print("<pre>" . print_r($csv_data, true) . "</pre>");
        return $csv_data;
    }
    public function execute(array $data)
    {
        $insertData = [];
        print("<pre>" . print_r($data, true) . "</pre>");
        // Transforma os dados do CSV em um array associativo para ser inserido no banco de dados
        foreach ($data as $row) {
            print_r($row);
/*             $insertData[] = [
                'date' => $row
                'tracker_symbol' =>
                'ISIN' =>
                'asset' =>
                'balance_quantity' =>
                'trade_average_price' =>
                'price_factor' =>
                'balance_value' =>
                'symbol' => $row['Symbol'],
                'date' => $row['Date'],
                'quantity' => $row['Quantity'],
                'price' => $row['Price'],
            ]; */
        }
        
        // Insere os dados no banco de dados
        /* OpenPositions::insert($insertData); */
    }
}