<?php

namespace App\Services;

use App\Models\OpenPositions;
use App\Models\Asset;
use Carbon\Carbon;

class B3DataService
{
    public function readCsv($data)
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

        $openPositionsData = [];

        // Transforma os dados do CSV em um array associativo para ser inserido no banco de dados

        /* TODO: Testar sem assets no BD */

        foreach ($data as $row) {
            $ISIN = $row[2];
            $asset = Asset::where('ISIN', $ISIN)->first();

            if (!$asset) {
                $assetData = [];
                $assetData = [
                    'tracker_symbol' => $row[1],
                    'ISIN' => $row[2],
                    'asset' => $row[3],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
                $asset_id = Asset::insertGetId($assetData);
            }
            else{
                $asset_id = $asset->id;
            }
            $openPositionsData[] = [
                'date' => $row[0],
                'asset_id' => $asset_id,
                'balance_quantity' => $row[4],
                'trade_average_price' => $row[5],
                'price_factor' => $row[6],
                'balance_value' => $row[7],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        }
        if (!empty($openPositionsData)) {
            ## verifica se os dados da data já existem
            $dataExists = OpenPositions::where('date', $openPositionsData[0]['date'])->exists();
            if ($dataExists == True) {
                return True;
            } else if ($dataExists == False) {
                return OpenPositions::insert($openPositionsData);
            }
        }
    }

    public function clearTemp()
    {
        $files = glob(base_path() . '\temp\*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }
}
