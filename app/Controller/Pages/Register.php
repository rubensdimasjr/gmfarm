<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\User as EntityUser;
use \App\Controller\Admin\Login;

class Register extends Page
{

  /**
   * Método responsável por buscar a rota de cadastro e exibi-la para o usuário
   * @return string
   */
  public static function getRegister()
  {
    $content = View::render('pages/cadastro', []);

    if (empty($content)) {
      throw new \Exception("Tela vazia");
    }

    /* Retorna a View da Página */
    return parent::getPage('CADASTRO > GMFARM', $content);
  }

  /**
   * Método responsável por validar e cadastrar um requerimento de inserção do aluno
   * @param \App\Http\Request $request
   * @return string|void
   */
  public static function setRegister($request)
  {

    $postVars = $request->getPostVars();

    /* Validação dos campos */
    if (!preg_match('/^[0-9]*$/', $postVars['matricula'])) {
      echo 'algo de errado';
      exit;
    }

    if (!filter_var($postVars['email'], FILTER_VALIDATE_EMAIL)) {
      echo 'algo de errado';
      exit;
    }

    /* NOVA INSTANCIA DE ALUNO */
    $obUser = new EntityUser;
    $obUser->nome = $postVars['nome'];
    $obUser->email = $postVars['email'];
    $obUser->matricula = $postVars['matricula'];
    $obUser->senha = password_hash($postVars['senha'], PASSWORD_BCRYPT);
    $obUser->tipo_usuario = 'aluno';
    $obUser->status = 'deactivated';
    $obUser->cadastrar();


    /* RETORNA PARA PÁGINA DE HOME */
    $request->getRouter()->redirect('/admin/login?status=created');

  }

}