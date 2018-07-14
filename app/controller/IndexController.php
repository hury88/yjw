<?php
namespace App\controller;

class IndexController extends Controller
{
    private $lister = null;

    public function __construct()
    {
        /*if(! IS_INDEX) {
            $this->lister = new \Lister();
        }*/
    }

    public function index()
    {

        // $data = v_news(8, -16, '*');
        //$this->view('index', compact('data'));
        $this->view('index');
    }

    public function eyeglass()
    {
        $this->view('eyeglass');
    }
    public function jjSelect()
    {

        $this->view('jjSelect');
    }


}
