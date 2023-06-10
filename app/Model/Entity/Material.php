<?php

namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;

class Material
{

  public $id_material;

  public $reagente;

  public $lote;

  public $fabricante;

  public $fabricacao;

  public $validade;

  public $quantidade;

  public $embalagem_original;

  public $cas;

  public $user_id;

  public function cadastrar()
  {
    /* INSERE NO BANCO DE DADOS */
    $this->id_material = (new Database('material'))->insert([
      'reagente' => $this->reagente,
      'lote' => $this->lote,
      'fabricante' => $this->fabricante,
      'fabricacao' => $this->fabricacao,
      'validade' => $this->validade,
      'quantidade' => $this->quantidade,
      'embalagem_original' => $this->embalagem_original,
      'cas' => $this->cas,
      'user_id' => $this->user_id
    ]);

    /* Sucesso */
    return true;
  }

  /**
   * Método responsável por retornar o material com base no ID
   * @param integer $id_material
   * @return Material
   */
  public static function getMaterialById($id_material)
  {
    return self::getItems('id_material = ' . $id_material)->fetchObject(self::class);
  }

  public function atualizar()
  {
    /* ATUALIZA NO BANCO DE DADOS */
    return (new Database('material'))->update('id_material = ' . $this->id_material, [
      'reagente' => $this->reagente,
      'lote' => $this->lote,
      'fabricante' => $this->fabricante,
      'fabricacao' => $this->fabricacao,
      'validade' => $this->validade,
      'quantidade' => $this->quantidade,
      'embalagem_original' => $this->embalagem_original,
      'cas' => $this->cas,
      'user_id' => $this->user_id
    ]);
  }

  public function excluir()
  {
    /* EXCLUI O MATERIAL NO BANCO DE DADOS */
    return (new Database('material'))->delete('id_material = ' . $this->id_material);
  }


  /**
   * Método responsável por retornar (itens do estoque)
   * @param string $where
   * @param string $order
   * @param string $limit
   * @param string $fields
   */
  public static function getItems($where = null, $order = null, $limit = null, $fields = '*')
  {

    return (new Database('material'))->select($where, $order, $limit, $fields);
  }
}