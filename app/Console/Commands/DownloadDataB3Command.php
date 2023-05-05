<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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
        ## TODO: pegar dados de 7 dias anteriores
        $url_b3 = "https://arquivos.b3.com.br/";
        $url = $url_b3 . "/api/download/requestname?fileName=LendingOpenPosition&date=2023-05-03";

        $response = file_get_contents($url);
        $response_data = json_decode($response, true);

        // Substitui o ~/ pela url e pega o token para utilizar no header
        $download_url = str_replace("~/", $url_b3, $response_data["redirectUrl"]);
        $token = $response_data["token"];

        $file_path = base_path() . '\temp\LendingOpenPositionFile_20230503_1.csv';

        $context_options = array(
            'http' => array(
                'method' => 'GET',
                'header' => "Authorization: Bearer $token\r\n"
            )
        );

        $context = stream_context_create($context_options);

        // Baixa o arquivo e armazena na pasta
        file_put_contents($file_path, file_get_contents($download_url, false, $context));


        ### TODO: Inserir no banco de dados
    }
}
