<?php 

namespace Tests;

use App\Controller\Admin\Login;
use App\Http\Request;
use App\Http\Router;
use PHPUnit\Framework\TestCase;

class LoginTest extends TestCase {
    
    public function testSetLogin(){
        $router = new Router('');
        $request = new Request($router); 
        $login = new Login;
        $login -> getLogin($request);
        
        $this -> assertEquals($login, true);
        
    }
    
    public function testSetLogout(){
        $router = new Router('');
        $request = new Request($router);
        $login = new Login;
        $login -> setLogout($request);
        $this->assertEquals($login, true);
    }    
}