<?php

namespace App\Controller\Admin;

use \App\Utils\View;
use \App\Model\Entity\User;
use \App\Session\Admin\Login as SessionAdminLogin;


class Login extends Page
{

  /**
   * Método responsável por retornar a renderização da página de login
   * @param \App\Http\Request $request
   * @param string $errorMsg
   * @return string 
   */
  public static function getLogin($request, $message = null)
  {
    /* STATUS */
    $status = !is_null($message) ? Alert::getError($message) : '';

    $content = View::render('admin/login', [
      'status' => $status,
      'return' => self::getStatus($request)
    ]);

    $style = '../resources/css/index.css';
    return parent::getPage('Login > GMFARM', $content, $style);
  }

  /**
   * Método responsável por definir o login do usuário
   * @param \App\Http\Request $request
   */
  public static function setLogin($request)
  {

    /* POST VARS */
    $postVars = $request->getPostVars();
    $emailOuMatricula = trim($postVars['emailOuMatricula']) ?? '';
    $senha = $postVars['senha'] ?? '';

    /* VERIFICA SE O DADO É E-MAIL */
    $email_validation_regex = '/^\\S+@\\S+\\.\\S+$/';
    $is_email = preg_match($email_validation_regex, $emailOuMatricula);
    $is_email === 1 ? $obUser = User::getUserByEmail($emailOuMatricula) : $obUser = User::getUserByMatricula($emailOuMatricula);

    /* BUSCA USUARIO PELO EMAIL */
    if (!$obUser instanceof User) {
      return self::getLogin($request, 'E-mail ou senha inválidos');
    }

    /* VERIFICA A SENHA DO USUÁRIO */
    if (!password_verify($senha, $obUser->senha)) {
      return self::getLogin($request, 'E-mail ou senha inválidos');
    }

    /* CRIA SESSÃO DE LOGIN */
    SessionAdminLogin::login($obUser);

    /* REDIRECIONA O USUARIO PARA HOME ADMIN */
    $request->getRouter()->redirect('/admin');
  }

  /**
   * Método responsável por deslogar o usuário
   * @param \App\Http\Request $request
   */
  public static function setLogout($request)
  {

    /* DESTROI SESSÃO DE LOGIN */
    SessionAdminLogin::logout();

    /* REDIRECIONA O USUARIO PARA TELA DE LOGIN */
    $request->getRouter()->redirect('/admin/login');
  }

  /**
   * Método responsável por retornar a mensagem de status
   * @param \App\Http\Request $request
   * @return string|void
   */
  private static function getStatus($request)
  {

    /* QUERY PARAMS */
    $queryParams = $request->getQueryParams();

    /* STATUS */
    if (!isset($queryParams['status']))
      return '';

    /* MENSAGENS DE STATUS */
    switch ($queryParams['status']) {
      case 'created':
        return Alert::getSuccess('Seu cadastrado foi enviado! Após aprovação, você poderá realizar login.');
    }
  }
}