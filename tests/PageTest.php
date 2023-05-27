<?php 
namespace Tests;

use App\Controller\Pages\Page;
use PHPUnit\Framework\TestCase;
use \App\Http\Request;
use \WilliamCosta\DatabaseManager\Pagination;


class PageTest extends TestCase {

  public function testIfPageIsNull() {
    $request = Request::class;
    $obPagination = Pagination::class;

    $page = new Page($request, $obPagination);
    $this -> assertNull($page);
  }

  public function testIfPageIsEmpty() {
    $request = Request::class;
    $obPagination = Pagination::class;

    $page = new Page($request, $obPagination);
    $this -> assertEmpty($page);
  } 

}