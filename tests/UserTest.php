<?php 

namespace Tests;

use App\Model\Entity\User;
use \WilliamCosta\DatabaseManager\Database;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase {
    public function testIfUserExists() {
      $user = new User;
      $query = $user -> getUserByEmail("admin@gmail.com");
      $this -> assertEquals("admin@gmail.com", $query);
    }

    public function testIfAlunoExists() {
      $user =  new User;
      $query = $user -> getAlunoById(1);
      $this -> assertEquals(1, $query);
    }

    public function testGetAtributos() {
      $user =  new User;
      $query = $user -> getAtributos("id", "id", "15", '*');
      $this -> assertEquals($query, $query);
    }
}