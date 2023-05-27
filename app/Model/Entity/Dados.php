<?php

namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;

class Dados
{

  public $materiais;
  public $usuarios;
  public $pacientes;

  /**
   * Método responsável por retornar dados estatisticos
   */
  public static function getDados($where = null, $order = null, $limit = null, $fields = '*')
  {
    return (new Database('usuario'))->select($where, $order, $limit, $fields);
  }
}