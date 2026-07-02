<?php
include('../../config/db.php');
date_default_timezone_set('UTC');
$mysqli->query("SET time_zone = '+00:00'");

if (!isset($_GET['ID'])) {
    die('no id found');
}

$stmt = $mysqli->prepare("UPDATE games SET lastping = FROM_UNIXTIME(?) WHERE gid = ?");
$stmt->bind_param("ii", time(), $_GET['ID']);
$stmt->execute();