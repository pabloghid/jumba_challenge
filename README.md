# Histórico de Posições em Empréstimo

Teste prático para a vaga de desenvolvedor na empresa Jumba

## Requisitos
Criar o projeto em Laravel com os seguintes requisitos:
 - Dados: arquivo de Posições em Aberto de Empréstimo de Ativos - https://www.b3.com.br/pt_br/market-data-e-indices/servicos-de-dados/market-data/consultas/boletim-diario/dados-publicos-de-produtos-listados-e-de-balcao/
- Um comando Artisan para baixar dados  da B3 através de um Job (queue), e salvar os dados no banco de dados. Necessário salvar os valores de múltiplos dias.
- Implemente algum teste unitário no PHP se encontrar alguma possibilidade
- Uma página para exibir os dados com pelo menos um gráfico relacionado usando Vue.js. Ideia: ter um Dropdown para escolher um ativo e ao selecioná-lo exibir um gráfico mostrando a evolução da quantidade de saldo do ativo e do preço médio.
- Descrever o que achar pertinente no readme.md e enviar junto uma screenshot da interface
A entrega pode ser um repositório privado no GitHub. Compartilhe com o usuário: thiagolcks

## Instalação

Clone o repositório:
```bash
git clone https://github.com/pabloghid/jumba_challenge.git
```

Instale as dependências do Laravel usando o Composer:
```bash
composer install
```
Configure o arquivo .env com o seu banco de dados;

Gere uma nova chave de aplicativo:
```bash
php artisan key:generate
```

Execute a migração do banco de dados:
```bash
php artisan migrate
```

Instale as dependências com npm:
```bash
npm install
```

Baixe os dados da B3 pela primeira vez:
```bash
php artisan download:data-b3
```

Compile o front-end:
```bash
npm run dev
```

Inicie o servidor do Laravel:
```bash
php artisan serve
```

Inicie o worker do schedule:
```bash
php artisan schedule:work
```

## Interface

 ![Interface](/etc/interface.jpg)

## Funcionamento

Os dados são baixados da B3 diariamente às 8:30 da manhã. O gráfico é renderizado com os dados das tabelas de Posições em Aberto de Empréstimo de Ativos, com um limite de 20 dias. 

Como padrão, foi definido o download da informação de 10 dias anteriores. Caso seja um fim de semana, não é baixado. Isso pode ser alterado no comando DownloadDataB3Command.

Foi utilizado a bilbioteca Chart.js para criação do gráfico, além de css e bootstrap para a criação do visual.