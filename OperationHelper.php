<?php

/**
 * Created by PhpStorm.
 * User: Jafor
 * Date: 16/24/2017
 * Time: 12:20 PM
 */

include 'ResponseHelper.php';
include 'DBConnection.php';

class OperationHelper
{

    var $dbconn;
    var $dbsqlconn;
    var $response;

    public function __construct()
    {
        $this->dbconn = new DBConnection();
        $this->dbsqlconn = $this->dbconn->createConnection();
        $this->response = new ResponseHelper();
    }


    public function simpleDbOperation($param1,$param2)
    {

        $result_id = 111;
        $requestIP = $this->getRealIpAddr();

        $query = "BEGIN PackageName.ProcedureName("
            . ":param1,:param1,:param1,:ipAddress,:p_RESPONSE_CODE); END;";
        $resultStmt = oci_parse($this->dbsqlconn, $query);
        oci_bind_by_name($resultStmt, ":param1", $param1);
        oci_bind_by_name($resultStmt, ":param2", $param2);
        oci_bind_by_name($resultStmt, ":param3", $param3);
        oci_bind_by_name($resultStmt, ":ipAddress", $requestIP);
        oci_bind_by_name($resultStmt, ":p_RESPONSE_CODE", $result_id, 200);

        if (oci_execute($resultStmt)) {
            oci_free_statement($resultStmt);
            $responseObj = new stdClass();
            $responseObj->RESPONSE_CODE = $result_id;

            return $responseObj;
        } else {
            $responseObj = new stdClass();
            $responseObj->RESPONSE_CODE = $result_id;

            return $responseObj;
        }


        oci_close($this->dbsqlconn);
    }

    public function getRealIpAddr()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    public function randomDigits($length)
    {
        $numbers = range(0, 9);
        shuffle($numbers);
        $digits = "";
        for ($i = 0; $i < $length; $i++)
            $digits .= $numbers[$i];
        return $digits;
    }

}
