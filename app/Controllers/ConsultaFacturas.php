<?php
//require_once 'dbConection';
namespace App\Controllers;

use App\Database;
use App\Database\dbConection;

class ConsultaFacturas extends BaseController
{

    public function index()
    {
        return view('ConsultaFacturas/index');
    }
    public function buscarFactura(): void
    {
        $data = $_POST;
        $sql = "";
        $dbconn = new dbConection();
        $pConsulta = "buscarFactura";
        
        if (isset($data["IdFactura"])) {
            $pConsulta = "buscarEncabezadoFactura";
            if (isset($data["detalle"])) {
                $pConsulta = "buscarEncabezadoDetalles";
            } 
            $pIdFactura = $data['IdFactura'];
            $params = array(
                array($pConsulta, SQLSRV_PARAM_IN),
                array($pIdFactura, SQLSRV_PARAM_IN)
            );
        
                $sql = "EXEC paConsultaFactura 
                @pConsulta=?, 
                @pIdFactura=?"; 
                
        } else {
            $pIdFacturaOrigen = $data['IdOrigen'];
            $pIdFacturaMotivo = $data['IdMotivo'];
            $pIdFormaPago = $data['FormaPago'];
            $pFechaI = $data['fechaI'];
            $pFechaF = $data['fechaF'];
            $params = array(
                array($pConsulta, SQLSRV_PARAM_IN),
                array($pIdFacturaOrigen, SQLSRV_PARAM_IN),
                array($pIdFacturaMotivo, SQLSRV_PARAM_IN),
                array($pIdFormaPago, SQLSRV_PARAM_IN),
                array($pFechaI, SQLSRV_PARAM_IN),
                array($pFechaF, SQLSRV_PARAM_IN)
            );

            $sql = "EXEC paConsultaFactura 
                        @pConsulta=?, 
                        @pIdFacturaOrigen=?,
                        @pIdFacturaMotivo=?,
                        @pIdFormaPago=?, 
                        @pFechaI=?,
                        @pFechaF=?";
        }


        try {
            $resultado = $dbconn->backendRequest($params, $sql);
            echo $resultado;
            //print_r(json_encode($resultado));
            return;
        } catch (\Exception $e) {
            echo ($e);
            return;
        };
    }
}
