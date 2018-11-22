<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     * 
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    //Rutas de pagina principal
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        return View('home');
    }
    public function animov(){
        return View('animov');
    }
    public function gamedev(){
        return View('gamedev');
    }
    public function miembros(){
        return View('miembros');
    }
    public function quienes(){
        return View('quienes');
    }
    public function servicios(){
        return View('servicios');
    }
    public function solstec(){
        return View('solstec');
    }
    public function tecnosoft(){
        return View('tecnosoft');
    }
    public function tv(){
        return View('tv');
    }
    public function cabalas(){
        return View('cabalas');
    }
    public function concurso(){
        return View('concurso');
    }
    public function emisora(){
        return View('emisora');
    }
    public function eventos(){
        return View('eventos');
    }
}