<?php
session_start();

if (!isset($_GET['ID'])) {
    die('no id');
}

$gid = (int) $_GET['ID'];

//include('./server.php?ID=' . $gid);
require_once('./server.php');
require_once('../../config/db.php');
require_once('../../api/keygen.php');

$id = $_SESSION['username'] ?? null;

if (!$id) {
    die("<br>Not logged in");
}

$stmt = $mysqli->prepare("SELECT * FROM users WHERE username = ?");

$stmt->bind_param("s", $id);

$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    die("<br>User not found");
}

header('Location: triaxx://join?key=' . rawurlencode($user['clikey']) . '&gid=' . $gid);
?>