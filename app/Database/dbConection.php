<?php
namespace App\Database;

//use CodeIgniter\Config\BaseConfig;
//use CodeIgniter\Database\Config;
use Config;
use Config\Database;

 class dbConection 
{
 
    // public function __construct()
    // {
    //     parent::__construct();
    // }

    public function backendRequest($params, $sql)
    {
      try {
            $data[] = '';
            $dataConn = new Database();
            $serverName = $dataConn->connSqlServer['hostname'];//"WILL_SERVER2\SQLSERVERWILL";
            $connectionOptions = array(
              "Database" => $dataConn->connSqlServer['database'],
              "Uid" => $dataConn->connSqlServer['username'],
              "PWD" => $dataConn->connSqlServer['password']
            );
            $conn = sqlsrv_connect($serverName, $connectionOptions);
            $stmt = sqlsrv_query($conn, $sql, $params);
            if ($stmt === false) {
              echo "Error in executing statement 3.\n";
              die(print_r(sqlsrv_errors(), true));
            }
            $data = array();
           
            while ($row =  sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
              $data[] = $row;
            }
            
            $json_data = json_encode($data);
            sqlsrv_close($conn);
            return $json_data;
      } catch (\Exception $e) {
        echo ($e);
        return;
      };
    }

}