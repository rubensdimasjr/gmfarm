<?php

namespace App\Controller\Pages;

use \App\Utils\View;

class EsqueceuSenha extends Page
{

  public static function getEsqueceuSenha()
  {
    /* View da Home */
    $content = View::render('pages/esqueceusenha', [

    ]);

    if (empty($content)) {
      throw new \Exception("Tela vazia");
    }

    /* Retorna a View da Página */
    return parent::getPage('ESQUECEU SENHA > GMFARM', $content);
  }

}