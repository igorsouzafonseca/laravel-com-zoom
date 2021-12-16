<h2>Criando o Projeto</h2><br/>

<b>1º passo:</b>

Clonar o repositório: 
$ git clone https://github.com/igorsouzafonseca/laravel-com-zoom.git

<b>2º passo:</b>

Criar conta no site do Zoom https://zoom.us/signup

<b>3º passo:</b>
- Ao estar logado no site do Zoom, procure pela opção <b>ADMINISTRADOR -> AVANÇADO -> APP MARKETPLACE</b>, que fica do lado esquerdo da tela e clique;
- Na nova página, clique em DEVELOP e selecione BUILD APP;
- Em JWT, clique em CREATE;
- Prencha as informações solicitadas até que seja gerado as credenciais (API KEY e API SECRET).

<b>4º passo:</b>

Dentro do .env inserir os campos abaixo:

<b>ZOOM_API_KEY="CHAVE DA API"</b>

<b>ZOOM_API_SECRET="API SECRET"</b>

<b>5º passo:</b>

Baixar a dependência jwt: <b>composer require firebase/php-jwt </b>

<b>6º passo</b>

start no servidor: <b>php artisan serve</b>
