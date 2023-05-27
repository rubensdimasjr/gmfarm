<?php

use \App\Http\Response;
use \App\Controller\Pages;

/* Rota HOME */

$obRouter->get('/', [
  function () {
    return new Response(200, Pages\Home::getHome());
  }
]);

/* Rota de Termos */

$obRouter->get('/termos', [
  function () {
    return new Response(200, Pages\Termos::getTermos());
  }
]);

/* Rota de Esqueceu a senha */

$obRouter->get('/esqueci', [
  function () {
    return new Response(200, Pages\EsqueceuSenha::getEsqueceuSenha());
  }
]);

/* Rota de Esqueceu a senha */

$obRouter->get('/cadastro', [
  function () {
    return new Response(200, Pages\Register::getRegister());
  }
]);


/* Rotas DINAMICAS */
$obRouter->get('/pagina/{idPagina}/{acao}', [
  function ($idPagina, $acao) {
    return new Response(200, 'Página ' . $idPagina . ' - ' . $acao);
  }
]);