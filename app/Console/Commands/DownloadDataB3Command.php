<?php

namespace App\Console\Commands;

use App\Services\InsertB3Data;
use Illuminate\Console\Command;
use App\Helpers\DateHelper;
class DownloadDataB3Command extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'download:data-b3';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // TODO: Buscar ultimos 5 dias
        $dates = DateHelper::getPast5Days();
        print_r($dates);
        foreach ($dates as $date) {
            print_r($date);
            $initial_url = 'https://arquivos.b3.com.br/api/download/requestname';
            $params = ['fileName' => 'LendingOpenPosition', 'date' => $date];

            print($initial_url . '?' . http_build_query($params));

            $headers = get_headers($initial_url . '?' . http_build_query($params));
            print_r('<pre>' . $headers[0]);
            if(strpos($headers[0], '200') == false) {
                continue;
            }

            // Faz o request inicial para pegar a url e o token
            $response = file_get_contents($initial_url . '?' . http_build_query($params));
            $data = json_decode($response, true);
            
            // Cria a URL com o token para download
            $url = "https://arquivos.b3.com.br/api/download/?token=" . $data['token'];

            $file = file_get_contents($url);
            
            $formattedDate = str_replace('-', '', $date);
            $savePath = base_path() . "\\temp\LendingOpenPositionFile_$formattedDate.csv";
            file_put_contents($savePath, $file);

            ## Insere data no BD
            $insertData = new InsertB3Data();

            $data = $insertData->read_csv($formattedDate);

            $insert = $insertData->execute($data);
        }
    }

}
