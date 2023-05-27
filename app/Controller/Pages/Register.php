<?php

namespace App\Controller\Pages;

use \App\Utils\View;

class Register extends Page
{

  public static function getRegister()
  {
    $content = View::render('pages/cadastro', []);

    if (empty($content)) {
      throw new \Exception("Tela vazia");
    }

    /* Retorna a View da Página */
    return parent::getPage('CADASTRO > GMFARM', $content);
  }

}