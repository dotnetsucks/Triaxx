<?php
include('../../config/db.php');

if (!isset($_GET['gid'])) {
die('no gid');
} else {
$gid = $_GET['gid'];
}

if (!isset($_GET['jobid'])) {
die('no jobid');
} else {
$id = $_GET['jobid'];
}
$base = "http://26.78.157.198";
require('../Soap.php');
$rcc = new GetALiveAndSoap("26.78.157.198", 799);
    
$response = $rcc->CloseJob($id);

$stmt = $mysqli->prepare("UPDATE games SET status = 0, jobid = ? WHERE gid = ?");
$stmt->bind_param("ss", $emptyJobId, $gid);

$emptyJobId = "";
$stmt->execute();

echo 'server closed';
?>	