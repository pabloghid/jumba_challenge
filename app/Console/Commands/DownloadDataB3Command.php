<?php

namespace App\Console\Commands;

use App\Services\B3DataService;
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
        $dates = DateHelper::getPast5Days();

        foreach ($dates as $date) {
            $initial_url = 'https://arquivos.b3.com.br/api/download/requestname';
            $params = ['fileName' => 'LendingOpenPosition', 'date' => $date];


            $headers = get_headers($initial_url . '?' . http_build_query($params));

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
            $b3Service = new B3DataService();

            $data = $b3Service->readCsv($formattedDate);

            $insert = $b3Service->execute($data);

            $clearTemp = $b3Service->clearTemp();
            ## Exclui registros na pasta temp

        }
    }

}
