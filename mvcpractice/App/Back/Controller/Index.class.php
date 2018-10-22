<?php
namespace Back\Controller;
use Core\Controller;

class Index extends Controller{
    public function index(){
    $this->smarty->display('index.html');
    }
}