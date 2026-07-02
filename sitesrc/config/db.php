<?php
$servername = "localhost";
$username = "root";
$password = "password!@?";
$database = "triaxx";

$mysqli = new mysqli($servername, $username, $password, $database);

error_reporting(0);
ini_set('dislay_errors', 0);