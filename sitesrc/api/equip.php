<?php
session_start();
include('../config/db.php');

if (!isset($_SESSION['userid']) || !isset($_GET['ID'])) {
    die("Missing parameters.");
}

$uid = (int)$_SESSION['userid'];
$hatid = (int)$_GET['ID'];

if ($hatid === 0) {
    $stmt = $mysqli->prepare("UPDATE users SET hat = 0 WHERE id = ?");
    $stmt->bind_param("i", $uid);
    $stmt->execute();

    header("Location: ../My/Character.aspx");
    exit;
}

$stmt = $mysqli->prepare("SELECT * FROM inventory WHERE user_id = ? AND item_id = ?");
$stmt->bind_param("ii", $uid, $hatid);
$stmt->execute();
$hat = $stmt->get_result()->fetch_assoc();

if (!$hat) {
    die("You do not own this hat.");
}

$stmt = $mysqli->prepare("UPDATE users SET hat = ? WHERE id = ?");
$stmt->bind_param("ii", $hatid, $uid);
$stmt->execute();

header("Location: ../My/Character.aspx");
exit;
?>