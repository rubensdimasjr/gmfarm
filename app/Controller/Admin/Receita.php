<?php

namespace App\Controller\Admin;

use \App\Utils\View;
use clsTinyButStrong;
use \App\Model\Entity\Receita as EntityReceita;
use \WilliamCosta\DatabaseManager\Pagination;

include_once "app/Utils/tbs_class.php";
include_once "app/Utils/plugins/tbs_plugin_opentbs.php";

class Receita extends Page
{

  /**
   * Método responsável por renderizar a view de Relatório
   * @return string
   */
  public static function getReceita($request)
  {
    /* CONTEÚDO DA HOME */
    $content = View::render('admin/modules/receitas/index', [
      'atributos' => self::getAtributosItems($request, $obPagination),
      'pagination' => parent::getPagination($request, $obPagination),
      'status' => self::getStatus($request)
    ]);

    /* RETORNA A PÁGINA COMPLETA */
    return parent::getPanel('Receitas > GMFARM', $content, 'receitas');
  }

  /**
   * Método responsável por obter a renderização dos itens da receita 
   * @param \App\Http\Request
   * @param Pagination $obPagination
   * @return string
   */
  private static function getAtributosItems($request, &$obPagination)
  {
    $atributos = '';

    $quantidadeTotal = EntityReceita::getItems(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

    /* Página atual */
    $queryParams = $request->getQueryParams();
    $paginaAtual = $queryParams['page'] ?? 1;

    /* Instancia de paginação */
    $obPagination = new Pagination($quantidadeTotal, $paginaAtual, 20);

    $results = EntityReceita::getItems(null, 'id_receita DESC', $obPagination->getLimit());

    while ($obReceita = $results->fetchObject(EntityReceita::class)) {
      $atributos .= View::render('admin/modules/receitas/atributo', [
        'id' => $obReceita->id_receita,
        'criado_por' => $obReceita->created_by,
        'criado_em' => $obReceita->created_at
      ]);
    }

    return $atributos;
  }

  /**
   * Método responsável por exibir a view de salvar uma receita
   * @param \App\Http\Request $request
   * @return string|void
   */
  public static function getInsertRecipe($request)
  {
    $content = View::render('admin/modules/receitas/salvar', []);

    /* RETORNA A PÁGINA COMPLETA */
    return parent::getPanel('Receitas > GMFARM', $content, 'receitas');
  }

  public static function setInsertRecipe($request)
  {
    $postVars = $request->getPostVars();

    date_default_timezone_set("America/Sao_Paulo");

    $obReceita = new EntityReceita();
    $obReceita->created_by = $_SESSION['admin']['usuario']['nome'];
    $obReceita->created_at = date('Y-m-d H:i');
    $obReceita->data = json_encode(array($postVars));
    $obReceita->cadastrar();

    $request->getRouter()->redirect('/admin/receitas?status=created');
  }

  /**
   * Método responsável por gerar uma receita
   * @param \App\Http\Request $request
   * @param int $id
   * @return string|void
   */
  public static function setGenerateRecipeById($request, $id)
  {

    $obReceita = EntityReceita::getRecipeById($id);

    if (!$obReceita instanceof EntityReceita) {
      $request->getRouter()->redirect('/admin/receitas?status=notfound');
    }

    $postVars = $request->getPostVars();

    $inputs = $postVars['medicacao'];
    $obs = array($postVars['obs']);
    $date = array(date('d/M/y'));
    $time = array(date('H:m'));

    $arr = [];
    for ($i = 1; $i <= count($inputs); $i++) {
      array_push($arr, "medicacao$i");
    }

    $array_type1 = array_combine($arr, $inputs);
    $array_type2 = array_combine(array("observacao"), $obs);
    $array_type3 = array_combine(array("date"), $date);
    $array_type4 = array_combine(array("time"), $time);

    $TBS = new clsTinyButStrong;
    $TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
    $template = 'resources/view/admin/modules/receitas/Receituario.docx';
    $nome = 'Receituario.docx';
    $TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8);
    $TBS->MergeBlock('blk1', $array_type1);
    $TBS->MergeBlock('blk2', $array_type2);
    $TBS->MergeBlock('blk3', $array_type3);
    $TBS->MergeBlock('blk4', $array_type4);

    $TBS->PlugIn(OPENTBS_DELETE_COMMENTS);

    $save_as = (isset($_POST['save_as']) && (trim($_POST['save_as']) !== '') && ($_SERVER['SERVER_NAME'] == 'localhost')) ? trim($_POST['save_as']) : '';
    $output_file_name = str_replace('.', '_' . date('Y-m-d') . $save_as . '.', $nome);
    if ($save_as === '') {
      $TBS->Show(OPENTBS_DOWNLOAD, $output_file_name);
      exit();
    } else {
      $TBS->Show(OPENTBS_FILE, $output_file_name);
      exit("Arquivo [$output_file_name] já foi criado.");
    }
  }

  /**
   * Método responsável por gerar uma receita com base no id
   * @param \App\Http\Request $request
   * @param int $id
   * @return string
   */
  public static function getGenerateRecipeById($request, $id)
  {
    echo "<pre>";
    print_r($request);
    echo "</pre>";
    exit;
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
        return Alert::getSuccess('Receita cadastrada com sucesso!');
      case 'updated':
        return Alert::getSuccess('Dados da receita atualizados com sucesso!');
      case 'deleted':
        return Alert::getSuccess('Receita deletada com sucesso!');
      case 'notfound':
        return Alert::getSuccess('Receita não encontrada!');
    }
  }
}