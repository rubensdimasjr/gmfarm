<?php

use \App\Http\Response;
use \App\Controller\Admin;

/* Rota de CRUD de Receitas */

$obRouter->get('/admin/receitas', [
  'middlewares' => [
    'required-admin-login'
  ],
  function ($request) {
    return new Response(200, Admin\Receita::getReceita($request));
  }
]);

/* Rota de GET de Receituário */

$obRouter->get('/admin/receita/save', [
  'middlewares' => [
    'required-admin-login'
  ],
  function ($request) {
    return new Response(200, Admin\Receita::getInsertRecipe($request));
  }
]);

$obRouter->post('/admin/receita/save', [
  'middlewares' => [
    'required-admin-login'
  ],
  function ($request) {
    return new Response(200, Admin\Receita::setInsertRecipe($request));
  }
]);

$obRouter->get('/admin/receita/{id}/generate', [
  'middlewares' => [
    'required-admin-login'
  ],
  function ($request, $id) {
    return new Response(200, Admin\Receita::getGenerateRecipeById($request, $id));
  }
]);

$obRouter->post('/admin/receita/{id}/generate', [
  'middlewares' => [
    'required-admin-login'
  ],
  function ($request, $id) {
    return new Response(200, Admin\Receita::setGenerateRecipeById($request, $id));
  }
]);