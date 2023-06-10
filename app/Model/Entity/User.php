<?php

namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;


class User
{
  public $id;

  public $nome;

  public $email;

  public $matricula;

  public $senha;

  public $tipo_usuario;

  public $status;

  public function cadastrar()
  {
    /* INSERE NO BANCO DE DADOS */
    $this->id = (new Database('usuario'))->insert([
      'nome' => $this->nome,
      'email' => $this->email,
      'matricula' => $this->matricula,
      'senha' => $this->senha,
      'tipo_usuario' => $this->tipo_usuario,
      'status' => $this->status
    ]);

    /* Sucesso */
    return true;
  }

  public function atualizar()
  {
    /* ATUALIZA NO BANCO DE DADOS */
    return (new Database('usuario'))->update('id = ' . $this->id, [
      'nome' => $this->nome,
      'email' => $this->email,
      'matricula' => $this->matricula,
      'senha' => $this->senha,
      'tipo_usuario' => $this->tipo_usuario,
      'status' => $this->status
    ]);
  }

  public function excluir()
  {
    /* EXCLUI O ALUNO NO BANCO DE DADOS */
    return (new Database('usuario'))->delete('id = ' . $this->id);
  }


  /**
   * Método responsável por retornar um usuári com base em seu e-mail
   * @param string $email
   * @return User
   */
  public static function getUserByEmail($email)
  {
    return (new Database('usuario'))->select('email = "' . $email . '"')->fetchObject(self::class);
  }

  /**
   * Método responsável por retornar um usuári com base em sua matricula
   * @param string $matricula
   * @return User
   */
  public static function getUserByMatricula($matricula)
  {
    return (new Database('usuario'))->select('matricula = "' . $matricula . '"')->fetchObject(self::class);
  }

  /**
   * Método responsável por retornar o usuário com base no ID
   * @param integer $id
   * @return User
   */
  public static function getAlunoById($id)
  {
    return self::getAtributos('id = ' . $id)->fetchObject(self::class);
  }

  /**
   * Método responsável por retornar (atributos do usuário)
   * @param string $where
   * @param string $order
   * @param string $limit
   * @param string $fields
   * @return \PDOStatement 
   */
  public static function getAtributos($where = null, $order = null, $limit = null, $fields = '*')
  {
    return (new Database('usuario'))->select($where, $order, $limit, $fields);
  }
}