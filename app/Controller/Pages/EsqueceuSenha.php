<?php

namespace App\Controller\Pages;

use App\Controller\Admin\Alert;
use App\Model\Entity\Recuperacao;
use \App\Utils\View;
use \App\Model\Entity\User;
use Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

class EsqueceuSenha extends Page
{

  public static function getEsqueceuSenha($message = null, $type = null)
  {

    /* STATUS */
    $status = !is_null($message) ? Alert::getMessage($message, $type) : '';

    /* View da Home */
    $content = View::render('pages/esqueceusenha', [
      'status' => $status
    ]);

    if (empty($content)) {
      throw new Exception("Tela vazia");
    }

    /* Retorna a View da Página */
    return parent::getPage('ESQUECEU SENHA > GMFARM', $content);
  }

  /**
   * Método responsável por enviar um e-mail com o código de recuperação para o usuário
   * @param \App\Http\Request $request
   * @return string|void
   */
  public static function setEsqueceuSenha($request)
  {

    $postVars = $request->getPostVars();

    if (!$postVars || empty($postVars)) {
      return self::getEsqueceuSenha("Post Vars não foram encontrados!", "danger");
    }

    $obUser = User::getUserByEmail($postVars['email']);

    if (!$obUser instanceof User) {
      return self::getEsqueceuSenha("E-mail não foi encontrado!", "danger");
    }

    date_default_timezone_set("America/Sao_Paulo");
    $stmt = Recuperacao::getItems('user_id = ' . $obUser->id);
    $arrRecuperacao = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    foreach ($arrRecuperacao as $object) {
      if (strtotime($object['date_expire']) > strtotime(date('Y-m-d H:i:s'))) {
        return self::getEsqueceuSenha("Você realizou a pouco tempo uma nova solicitacão, aguarde alguns minutos antes de realizar uma outra!", "warning");
      }
    }

    $obRecuperacao = new Recuperacao;
    $obRecuperacao->user_id = $obUser->id;
    $obRecuperacao->date_expire = date('Y-m-d H:i:s', strtotime("+15 minutes"));
    $obRecuperacao->md5 = md5(date('YmdHis'));
    $obRecuperacao->cadastro();

    $mail = new PHPMailer(true);

    $resposta = "<body><br><table border='0' width='100%'>
		<tr>
			<td text='center'>Prezado(a) <b>" . $obUser->nome . "</b>,<br/><br/>
			 Utilize o link abaixo para redefinir sua senha, clique no link e acesse a página de recuperação.<br/>
       Acesso: <a href='" . URL . "/$obRecuperacao->md5/redefinicao'>Link de Recuperação</a><br/><br/>
			 Seu acesso expira em <b>15 minutos</b>.<br/><br/>
		Qualquer dúvida, estamos à disposição!<br/><br/>
		Att,<br />
		<strong>Informática GMFARM</strong><br/><br/>
																<hr /><br/>
																Mensagem enviada através do Sistema GMFARM</td>
		</tr>
		</table></body>
								";

    try {
      $mail = new PHPMailer(true);
      $mail->setLanguage('pt_BR'); // Habilita as saídas de erro em Português
      $mail->CharSet = 'UTF-8';
      $mail->isSMTP(); // Configura o disparo como SMTP
      $mail->Host = 'email-ssl.com.br'; // Especifica o enderço do servidor SMTP da Locaweb
      $mail->SMTPAuth = true; // Habilita a autenticação SMTP
      $mail->Username = 'naoresponda@crefito11.gov.br'; // Usuário do SMTP
      $mail->Password = 'Crefito11@2021'; // Senha do SMTP
      $mail->SMTPSecure = 'ssl'; // Habilita criptografia TLS | 'ssl' também é possível
      $mail->Port = 465; // Porta TCP para a conexão

      //Recipients
      $mail->setFrom('naoresponda@crefito11.gov.br', 'Sistema de Gerenciamento de Farmácia');
      $mail->addAddress('rubens.jr107@gmail.com'); //Add a recipient

      //Content
      $mail->isHTML(true); // Configura o formato do email como HTML
      $mail->Subject = 'Recuperação de Senha GMFARM';
      $mail->Body = $resposta;
      $mail->send();

    } catch (PHPMailerException $e) {
      return self::getEsqueceuSenha("O código não pôde ser enviado. Mailer Error: {$mail->ErrorInfo}", "danger");
    }

    return self::getEsqueceuSenha("E-mail com código e link de recuperação enviado com sucesso!", "success");
  }

  public static function getRedefinicao($request, $md5, $message = null)
  {
    $obRecuperacao = Recuperacao::getByMd5($md5);

    if (!$obRecuperacao instanceof Recuperacao) {
      $request->getRouter()->redirect('/');
      exit;
    }

    date_default_timezone_set("America/Sao_Paulo");

    if (strtotime($obRecuperacao->date_expire) < strtotime(date("Y-m-d H:i:s"))) {
      echo "Código expirado!";
      exit;
    }

    $obUser = User::getAlunoById($obRecuperacao->user_id);

    if (!$obUser instanceof User) {
      echo "Erro na busca pelo usuário do objeto de recuperação!";
      exit;
    }

    $content = View::render('pages/redefinicao', [
      'status' => !is_null($message) ? Alert::getError($message) : '',
      'user_id' => $obUser->id
    ]);

    /* Retorna a View da Página */
    return parent::getPage('REDEFINIÇÃO SENHA > GMFARM', $content);

  }

  /**
   * Método responsável por lidar com a requisição de redefinição de senha
   * @param \App\Http\Request $request
   * @param string $md5
   * @return string|void
   */
  public static function setRedefinicao($request, $md5)
  {
    $postVars = $request->getPostVars();

    if (empty($postVars)) {
      echo "Sem variáveis POST";
      exit;
    }

    if ($postVars['senha'] !== $postVars['confirm_senha']) {
      return self::getRedefinicao($request, $md5, "As senhas não coincidem!");
    }

    $cripSenha = password_hash($postVars['senha'], PASSWORD_BCRYPT);

    $obUser = User::getAlunoById($postVars['user_id']);

    if (!$obUser instanceof User) {
      echo "Erro na busca pelo usuário do objeto de recuperação!";
      exit;
    }

    /* ATUALIZA A SENHA */
    $obUser->senha = $cripSenha;
    $obUser->atualizar();

    /* REDIRECIONA O USUARIO PARA HOME ADMIN */
    $request->getRouter()->redirect('/admin/login?status=updatedpassword');
  }

}