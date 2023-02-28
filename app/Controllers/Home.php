<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('home');
    }
    public function mantenimientoCarro()
    {
        return view('mantenimientoCarro/index');
    }
}
