<h2>Criando o Projeto</h2><br/>

<b>1º passo:</b>

Clonar o repositório: 
$ git clone https://github.com/igorsouzafonseca/laravel-com-zoom.git
<hr>
<b>2º passo:</b>

Criar conta no site do Zoom https://zoom.us/signup
<hr>
<b>3º passo:</b>
- Ao estar logado no site do Zoom, procure pela opção <b>ADMINISTRADOR -> AVANÇADO -> APP MARKETPLACE</b>, que fica do lado esquerdo da tela e clique;
- Na nova página, clique em DEVELOP e selecione BUILD APP;
- Em JWT, clique em CREATE;
- Prencha as informações solicitadas até que seja gerado as credenciais (API KEY e API SECRET);
- Avance até que o aplicativo criado dentro Zoom seja ativado.
<hr>
<b>4º passo:</b>

Dentro do .env inserir os campos abaixo:

<b>ZOOM_API_KEY="CHAVE DA API"</b>

<b>ZOOM_API_SECRET="API SECRET"</b>
<hr>
<b>5º passo:</b>

Baixar a dependência jwt: <b>composer require firebase/php-jwt </b>
<hr>
<b>6º passo</b>

start no servidor: <b>php artisan serve</b>
