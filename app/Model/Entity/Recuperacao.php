<?php

namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;

class Recuperacao
{

  public $id;

  public int $user_id;

  public $date_expire;

  public $md5;

  public function cadastro()
  {
    /* INSERE NO BANCO DE DADOS */
    $this->id = (new Database('recuperacao'))->insert([
      'user_id' => $this->user_id,
      'date_expire' => $this->date_expire,
      'md5' => $this->md5
    ]);

    /* Sucesso */
    return true;
  }

  public static function uniqidReal($lenght = 7)
  {
    // uniqid gives 13 chars, but you could adjust it to your needs.
    if (function_exists("random_bytes")) {
      $bytes = random_bytes(ceil($lenght / 2));
    } elseif (function_exists("openssl_random_pseudo_bytes")) {
      $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
    } else {
      throw new \Exception("no cryptographically secure random function available");
    }
    return substr(bin2hex($bytes), 0, $lenght);
  }

  /**
   * Método responsável por buscar o item de recuperação com base no md5 informado
   * @param string $md5
   * @return Recuperacao
   */
  public static function getByMd5($md5)
  {
    return self::getItems('md5 = ' . "'$md5'")->fetchObject(self::class);
  }


  /**
   * Método responsável por retornar (itens da tabela recuperacao)
   * @param string $where
   * @param string $order
   * @param string $limit
   * @param string $fields
   */
  public static function getItems($where = null, $order = null, $limit = null, $fields = '*')
  {

    return (new Database('recuperacao'))->select($where, $order, $limit, $fields);
  }
}