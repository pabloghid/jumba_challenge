<?php

namespace App\Services;

use App\Models\OpenPositions;
use Carbon\Carbon;
use App\Helpers\DateHelper;

class InsertB3Data
{
    public function read_csv($data)
    {

        $filename = base_path() . "\\temp\LendingOpenPositionFile_$data.csv";
        $handle = fopen($filename, "r");

        while ($row = fgetcsv($handle, 1000, ";")) {
            $row = str_replace(',', '.', $row);
            $csv_data[] = $row;
        }

        # retira o header
        unset($csv_data[0]);

        return $csv_data;
    }

    public function execute(array $data)
    {
        
        $dataToInsert = [];

        // Transforma os dados do CSV em um array associativo para ser inserido no banco de dados
        foreach ($data as $row) {
            $dataToInsert[] = [
                'date' => $row[0],
                'tracker_symbol' => $row[1],
                'ISIN' => $row[2],
                'asset' => $row[3],
                'balance_quantity' => $row[4],
                'trade_average_price' => $row[5],
                'price_factor' => $row[6],
                'balance_value' => $row[7],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        }

        ## verifica se o dado já existe
        $dataExists = OpenPositions::where('date', $dataToInsert[0]['date'])->exists();
        if ($dataExists == True) {
            return True;
        } else if ($dataExists == False) {
            return OpenPositions::insert($dataToInsert);
        }
    }
}
