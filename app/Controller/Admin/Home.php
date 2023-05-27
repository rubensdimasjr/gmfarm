<?php

namespace App\Controller\Admin;

use \App\Utils\View;
use \App\Model\Entity\User as EntityUser;
use \App\Model\Entity\Dados as EntityDados;

class Home extends Page
{

  /**
   * Método responsável por renderizar a view de Home
   * @return string
   */
  public static function getHome($request)
  {

    $results = EntityDados::getDados(null, null, null, '(select count(*) from material) AS materiais, (select count(*) from paciente) AS pacientes, (select count(*) from usuario) AS usuarios');

    $obDados = $results->fetchObject(EntityDados::class);

    /* CONTEÚDO DA HOME */
    $content = View::render('admin/modules/home/index', [
      'nmateriais' => $obDados->materiais ?? 0,
      'nusuarios' => $obDados->usuarios ?? 0,
      'npacientes' => $obDados->pacientes ?? 0,
    ]);

    /* RETORNA A PÁGINA COMPLETA */
    return parent::getPanel('Home > GMFARM', $content, 'home');
  }
}
