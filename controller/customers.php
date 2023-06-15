<?php

require_once("../model/customers.php");
session_start();

switch ($_POST['method']) {
  case 'insert':
    $data = array();
    $keys = array();

    foreach ($_POST as $key => $value) {

      if ($key == 'method') {
        continue;
      } else if ($key == 'ID') {
        continue;
      } else if ($key == 'type') {
        continue;
      } else {
        array_push($keys, $key);
        array_push($data, $value);
      }
    }
    $Customers = new Customers($data);

    $result = $Customers->insert($keys);
    echo json_encode($result);

    break;

  case 'update':
    $data = '';
    $id = 0;
    $i = 1;
    foreach ($_POST as $key => $value) {
      if ($key == 'method') {
        continue;
      } else if ($key == 'ID') {
        $id = $_POST[$key];
        continue;
      } else if ($key == 'type') {
        continue;
      } else {
        $data .= "$key='$value'";
        if ($i != (count($_POST) - 3))
          $data .= ", ";
      }
      $i++;
    }
    $Customers = new Customers($data);
    $result = $Customers->update($id);
    echo json_encode($result);

    break;

  case 'delete':
    $data = '';
    $id = $_POST['id'];

    $Customers = new Customers($data);
    $result = $Customers->delete($id);
    echo json_encode($result);

    break;

  case 'findAll':
    $data = '';

    $Customers = new Customers($data);
    $result = $Customers->findAll();
    echo json_encode($result);

    break;

  case 'findById':
    $data = '';
    $id = $_POST['id'];

    $Customers = new Customers($data);
    $result = $Customers->findById($id);
    echo json_encode($result);

    break;

  case 'search':
    $count = 0;
    foreach ($_POST as $key => $value) {
      if ($value != "")
        $count++;
    }

    $query = "WHERE ";
    $i = 0;

    foreach ($_POST as $key => $value) {
      if ($key == 'method') {
        continue;
      }
      if ($value != "") {
        if ($key == 'name') {
          $name = ucwords($value);
          $query .= "BINARY name like '%$name%'";
        } else if ($key == 'address') {
          $address = ucwords($value);
          $query .= "BINARY address like '%$address%'";
        } else {
          $query .= $key . " = '$value'";
        }

        if ($i != ($count - 2)) {
          $query .= "AND ";
        }
        $i++;
      }
    }

    $Customers = new Customers($query);
    $result = $Customers->searchClient();

    echo json_encode(array('result' => 'success', 'data' => $result));

    break;

  case 'uploadCSV':
    $data = '';
    $csv = $_POST['data'];
    $arr = explode("\n", $csv);

    foreach ($arr as &$line) {
      $line = str_getcsv($line);
    }

    $fp = fopen('../csv/file.csv', 'w');

    foreach ($arr as $fields) {
        fputcsv($fp, $fields);
    }

    var_dump($arr); die;

    $Customers = new Customers($data);
    $result = $Customers->findById($id);
    echo json_encode($result);

    break;

  case 'generatePDF':
    $data = '';
    $id = $_POST['id'];
    $type_id = 10;

    $Customers = new Customers($data);
    $data = $Customers->findById($id);

    $Customers = new Customers($data);
    $result = $Customers->generatePDF($id, $type_id);

    echo json_encode($result);

    break;
  default:
    #code...
    break;
}
