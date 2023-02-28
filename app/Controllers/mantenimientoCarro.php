<?php

namespace App\Controllers;

class mantenimientoCarro extends BaseController
{
    public function index()
    {       
         $cva = 'holadd';
        // var_dump($cva );
        // exit();
        return view('mantenimientoCarro/index');

    }
}
