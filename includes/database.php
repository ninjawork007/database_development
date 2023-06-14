<?php
function dbCon()
{
  //  $host =    "localhost";
  //  $user =    "ftnhealt_good";
  //  $passwd =  "+D5EEhD#9,K;";
  //  $db =    "ftnhealt_health";
  $host =    "localhost";
  $user =    "root";
  $passwd =  "zbU4r3Vfcb";
  $db =    "data_db";


  $con = mysqli_connect($host, $user, $passwd, $db);

  return $con;
}
