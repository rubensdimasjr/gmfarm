<?php

namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;

class Receita
{
  public $id_receita;

  public $name;

  public $created_by;

  public $created_at;

  public $data;

  public $path;

  public function cadastrar()
  {
    /* INSERE NO BANCO DE DADOS */
    $this->id_receita = (new Database('receita'))->insert([
      'name' => $this->name,
      'created_by' => $this->created_by,
      'created_at' => $this->created_at,
      'data' => $this->data,
      'path' => null
    ]);

    /* Sucesso */
    return true;
  
  }

  public function atualizar()
  {
    /* ATUALIZA NO BANCO DE DADOS */
    return (new Database('receita'))->update('id_receita = ' . $this->id_receita, [
      'name' => $this->name,
      'created_by' => $this->created_by,
      'created_at' => $this->created_at,
      'data' => $this->data,
      'path' => $this->path
    ]);
  }

  /**
   * Método responsável por retornar (itens da receita)
   * @param string $where
   * @param string $order
   * @param string $limit
   * @param string $fields
   */
  public static function getItems($where = null, $order = null, $limit = null, $fields = '*')
  {

    return (new Database('receita'))->select($where, $order, $limit, $fields);
  }

  /**
   * Método responsável por retornar a receita com base no ID
   * @param integer $id_receita
   * @return Receita
   */
  public static function getRecipeById($id_receita)
  {
    return self::getItems('id_receita = ' . $id_receita)->fetchObject(self::class);
  }


}