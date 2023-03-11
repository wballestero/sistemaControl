<?php

namespace App\Controllers;

class mantenimientoCarro extends BaseController
{

    public function index()
    {       
        return view('mantenimientoCarro/index');

    }
    public function buscar():void
    {       
        // $data = $_POST;
       // $this->input->get_post(); 
         try{
           // $datos = $_POST;
            // $cva = $_POST['param1'];
             //var_dump($cva );
             //echo($cva);
            //  if (isset($_POST['idCar'])) {
            //     $data = $_POST['idCar'];
            //     echo $data;
            //     return;
            //  }
            //echo $_SERVER['REQUEST_METHOD'];
             //exit();
             //$data = $_POST;
              //$cva = $_POST;
            $data = $_POST;
            echo  'Mensaje desde PHP '.json_decode($data['idCarro']);
            return;
           //return view('mantenimientoCarro/index');
         }
         catch (\Exception $e){
            echo($e);
         };


    }
}
