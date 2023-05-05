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
        // TODO: Buscar ultimos 5 dias
        $initial_url = 'https://arquivos.b3.com.br/api/download/requestname';
        $params = ['fileName' => 'LendingOpenPosition', 'date' => '2023-05-03'];
        
        // Faz o request inicial para pegar a url e o token
        $response = file_get_contents($initial_url . '?' . http_build_query($params));
        $data = json_decode($response, true);

        // Cria a URL com o token para download
        $url = "https://arquivos.b3.com.br/api/download/?token=".$data['token'];

        $file = file_get_contents($url);

        $savePath = base_path() . '\temp\LendingOpenPositionFile_20230503_1.csv';
        file_put_contents($savePath, $file);

    }
}
