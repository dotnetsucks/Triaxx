<?php
require_once('../config/db.php');

if (!isset($_GET['ID'])) {
    die('no id set');
}
$id = (int)$_GET['ID'];

$stmt = $mysqli->prepare("SELECT * FROM users WHERE ID = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$user = $stmt->get_result()->fetch_assoc();

$hat = $user['hat'];

header("Location: /asset/Hats/" . $hat . ".rbxm")
?>
