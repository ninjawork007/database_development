<?php
error_reporting(0);
ob_start();
session_start();

header("Content-Type: text/html;charset=UTF-8");

DEFINE ('DB_USER', 'root');
DEFINE ('DB_PASSWORD', 'zbU4r3Vfcb');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'data_db');


$mysqli=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME) or die("Not connected.");

mysqli_query($mysqli,"SET NAMES 'utf8'");
