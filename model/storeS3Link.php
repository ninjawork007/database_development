<?php

use Mpdf\Mpdf;


class StoreS3Link
{

    private $data;

    function __construct($entities)
    {
        $this->data = $entities;
    }
    function create()
    {
        $conn = dbCon();
        $sql = "CREATE TABLE tbl_s3link (
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `link` VARCHAR(200) NOT NULL,
            `user_id` int(30),
            handled_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )";

        $result = mysqli_query($conn, $sql);

        if ($result === TRUE) {
            return (bool) true;
        } else {
            return (bool) false;
        }
    }
    function isTable()
    {
        $conn = dbCon();
        $val = mysqli_query($conn, "SELECT * FROM tbl_s3link LIMIT 1");
        if ($val !== FALSE) {
            return (bool) true;
        } else {
            return $this->create();
        }
    }

    function insert($keys)
    {
        $conn = dbCon();
        if ($this->isTable() === true) {
            $importData = implode("', '", $this->data);
            $params = implode("`, `", $keys);
            $sql = "INSERT INTO tbl_s3link (`" . $params . "`) VALUES ('" . $importData . "')";
            
            $q = mysqli_query($conn, $sql);
            $id = mysqli_insert_id($conn);
            if ($q === true) {
                
                return array('id' => $id, 'result' => $q);
               
            } else {
                return array('id' => 0, 'result' => (bool) false);
            }
        } else {
            var_dump("Failed in Creating tbl_s3link Table");
            die;
        }
    }

 
    function update($id = NULL)
    {
        $conn = dbCon();

        $sql = "UPDATE tbl_s3link SET " . $this->data . " WHERE id=" . $id;

        $q = mysqli_query($conn, $sql);
        if ($q === true)
            return array('id' => $id, 'result' => $q);
        else
            return array('id' => 0, 'result' => (bool) false);
    }

    function delete($id = NULL)
    {
        $conn = dbCon();

        $sql = "DELETE FROM tbl_s3link WHERE id=" . $id;
        $q = mysqli_query($conn, $sql);

        if ($q === true)
            return array('id' => $id, 'result' => $q);
        else
            return array('id' => 0, 'result' => (bool) false);
    }

    function findById($id = NULL)
    {
        $conn = dbCon();

        $sql = "SELECT * FROM  tbl_s3link WHERE id=" . $id;
        $q = mysqli_query($conn, $sql);
        $data = mysqli_fetch_assoc($q);

        return $data;
    }

    function findAll()
    {
        $conn = dbCon();

        $sql = "SELECT * FROM  tbl_s3link";
        $q = mysqli_query($conn, $sql);
        $data = mysqli_fetch_assoc($q);

        return $data;
    }
}
