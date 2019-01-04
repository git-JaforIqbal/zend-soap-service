<?php

/**
 * Created by PhpStorm.
 * User: Jafor
 * Date: 16/24/2017
 * Time: 12:20 PM
 * Desc: DB connection with Oracle 11g
 */


class DBConnection extends Exception
{


    var $db = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 000.00.00.00)(PORT = 0000)))(CONNECT_DATA=(SID=dbsid)))";
    var $user = "userid";
    var $password = "password";

    var $conn;

    function throwOCIError($err)
    {
        throw new Exception("");
    }

    /* ---------------------
     *  creating connection
     * ---------------------
    */
    function createConnection()
    {
        $this->conn = oci_connect($this->user, $this->password, $this->db);
        if (!$this->conn) {
            $e = OCIError();
            $this->throwOCIError($e);
        }
        return $this->conn;
    }

    /* ---------------------
     *  Insert data into DB
     * ---------------------
    */
    function insertData($query)
    {
        $stmt = oci_parse($this->conn, $query);
        //if error in creating statement
        if (!$stmt) {
            $e = OCIError($this->conn);
            $this->throwOCIError($e);
        }
        if (oci_execute($stmt, OCI_DEFAULT)) {
            $this->commit();
            return "success";
        } else {
            $e = OCIError($stmt);
            $this->throwOCIError($e);
        }
    }

    //commit into DB
    function commit()
    {
        oci_commit($this->conn);
    }

    //get data from table
    function getEffectdRow()
    {

    }

    /* ---------------------
     *  For data selection
     * ---------------------
    */
    function selectData($query)
    {
        $select_stmt = oci_parse($this->conn, $query);
        oci_execute($select_stmt, OCI_DEFAULT);
        return $select_stmt;
    }

    function closeConnection()
    {
        oci_close($this->conn);
    }

}

?>
