<?php

namespace App\Jobs;

use App\Console\Commands\DownloadDataB3Command;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Helpers\DateHelper;
use App\Services\B3DataService;

class DownloadDataB3Job implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        ## Informação de quantos dias
        $pastDates = 10;
        $dates = DateHelper::getPastDays($pastDates);

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

            ## Exclui registros na pasta temp
            $clearTemp = $b3Service->clearTemp();

        }

    }
}
