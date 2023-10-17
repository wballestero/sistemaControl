<?php
//require_once 'dbConection';
namespace App\Controllers;
use App\Database;
use App\Database\dbConection;

class mantenimientoCarro extends BaseController
{

  public function index()
  {
    return view('mantenimientoCarro/index');
  }
  public function listarOrigenes(): void
  {
    $data = $_POST;
    $sql="";
    $dbconn = new dbConection();
    $pConsulta = "listarFacturaOrigenAll";
    if (isset($data["idOrigen"])){
      $pId = $data['idOrigen'];
      $pConsulta = "buscarFacturaOrigenId";
      $params = array(
        array($pConsulta, SQLSRV_PARAM_IN),
        array($pId, SQLSRV_PARAM_IN)
              );
      $sql = "EXEC paConsultaFacturaOrigen @pConsulta=?, @pId=?";
    }
    else {
      $params = array(
        array($pConsulta, SQLSRV_PARAM_IN));
      $sql = "EXEC paConsultaFacturaOrigen @pConsulta=?";
    }
    try {
          $result = $dbconn->backendRequest($params, $sql);
            echo $result;
          return;
    } catch (\Exception $e) {
        echo ($e);
      return;
    };
  }
  public function listarMotivos(): void
  {
    $data = $_POST;
    $sql="";
    $dbconn = new dbConection();
    $pConsulta = "listarFacturaMotivoAll";
    if (isset($data["idOrigen"])){
      $fkFacturaOrigen = $data['idOrigen'];
      $pConsulta = "buscarFacturaMotivoFk";
      $params = array(
        array($pConsulta, SQLSRV_PARAM_IN),
              $fkFacturaOrigen, SQLSRV_PARAM_IN
              );
      $sql = "EXEC paConsultaFacturaMotivo @pConsulta=?, @fkFacturaOrigen=?";
    }
    else {
      $params = array(
        array($pConsulta, SQLSRV_PARAM_IN));
      $sql = "EXEC paConsultaFacturaMotivo @pConsulta=?";
    }
    try {
          $result = $dbconn->backendRequest($params, $sql);
            echo $result;
          return;
    } catch (\Exception $e) {
        echo ($e);
      return;
    };
  }
  public function listarFormaPago(): void
  {
    $data = $_POST;
    $sql="";
    $dbconn = new dbConection();
    $pConsulta = __FUNCTION__;
    if (isset($data["idFormaPago"])){
      $pIdFormaPago = $data['idFormaPago'];
      $pConsulta = "buscarFormaPago";
      $params = array(
        array($pConsulta, SQLSRV_PARAM_IN),
              $pIdFormaPago, SQLSRV_PARAM_IN
              );
      $sql = "EXEC paConsultaFormaPago @pConsulta=?, @pIdFormaPago=?";
    }
    else {
      $params = array(
        array($pConsulta, SQLSRV_PARAM_IN));
      $sql = "EXEC paConsultaFormaPago @pConsulta=?";
    }
    try {
          $result = $dbconn->backendRequest($params, $sql);
            echo $result;
          return;
    } catch (\Exception $e) {
        echo ($e);
      return;
    };
  }
  
public function listarCategorias():void
{
  $data = $_POST;
  $sql="";
  $dbconn = new dbConection();
  $pConsulta = "listarDetalleOrigenAll";{

  if (isset($data["idOrigen"])){
    $pIdFacturaOrige = $data['idOrigen'];
    $pConsulta = "BuscarDetalleOrigenFK";
    $params = array(
      array($pConsulta, SQLSRV_PARAM_IN),
            $pIdFacturaOrige, SQLSRV_PARAM_IN
            );
    $sql = "EXEC paConsultaFacturaMotivoDetalle @pConsulta=?, @pIdFacturaOrigen=?";
  }
  else {
    $params = array(
      array($pConsulta, SQLSRV_PARAM_IN));
    $sql = "EXEC paConsultaFacturaMotivoDetalle @pConsulta=?";
  }





  try {
        $result = $dbconn->backendRequest($params, $sql);
          echo $result;
        return;
  } catch (\Exception $e) {
      echo ($e);
    return;
  };
}
}

public function procesarFactura():void
{
  try{
    $data = $_POST;
    $sql="";
    $dbconn = new dbConection();
    $pConsulta = "ingresaFactura";
    $pIdFacturaOrigen = $data['IdOrigen'];
    $pIdFacturaMotivo = $data['IdMotivo'];
    $pMontoTotal = $data['MontoFactura'];
	  $pIdFormaPago = $data['FormaPago'];
    $pDetalle = $data['Detalle'];
    $pJsonDetalles = $data['JsonDetalles'];
    $pFecha = $data['fecha'];


    $params = array(
        array($pConsulta, SQLSRV_PARAM_IN),
        array($pIdFacturaOrigen, SQLSRV_PARAM_IN),
        array($pIdFacturaMotivo, SQLSRV_PARAM_IN),
        array($pMontoTotal, SQLSRV_PARAM_IN), 
        array($pIdFormaPago, SQLSRV_PARAM_IN),
        array($pDetalle, SQLSRV_PARAM_IN),
        array($pJsonDetalles, SQLSRV_PARAM_IN),
        array($pFecha, SQLSRV_PARAM_IN)
              );
      $sql = "EXEC paMantenimientoFactura 
              @pConsulta=?, 
              @pIdFacturaOrigen=?,
              @pIdFacturaMotivo=?,
              @pMontoTotal=?, 
              @pIdFormaPago=?, 
              @pDetalle=?,
              @pJsonDetalles=?,
              @pFecha=?";
    try {
          $resultado = $dbconn->backendRequest($params, $sql);
         // echo $resultado;
          echo "200";
          return;
    } catch (\Exception $e) {
        echo ($e);
      return;
    };
  }catch  (\Exception $e)
  {
    echo ($e);
    return;
  }
}

}
