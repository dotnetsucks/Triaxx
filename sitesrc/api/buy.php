<?php
session_start();
include('../config/db.php');

if (!isset($_SESSION['userid'])) {
    die("Not logged in");
}

if (!isset($_GET['id'], $_GET['t'])) {
    die("Missing parameters");
}

$user_id = (int) $_SESSION['userid'];
$item_id = (int) $_GET['id'];
$currency = $_GET['t'];

$stmt = $mysqli->prepare("SELECT * FROM catalog WHERE id = ?");
$stmt->bind_param("i", $item_id);
$stmt->execute();
$item = $stmt->get_result()->fetch_assoc();

if (!$item) {
    die("Item not found");
}

$stmt = $mysqli->prepare("SELECT * FROM currency WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$money = $stmt->get_result()->fetch_assoc();

if (!$money) {
    die("Currency not found");
}

if ($currency === "rbx") {
    $price = $item['price_robux'];
    $balance = $money['rbx'];
} elseif ($currency === "tix") {
    $price = $item['price_tix'];
    $balance = $money['tix'];
} else {
    die("Invalid currency");
}

if ($price <= 0) {
    die("Item not for sale");
}

if ($balance < $price) {
    die("Not enough balance");
}

$stmt = $mysqli->prepare("SELECT 1 FROM inventory WHERE user_id = ? AND item_id = ?");
$stmt->bind_param("ii", $user_id, $item_id);
$stmt->execute();
$exists = $stmt->get_result()->fetch_assoc();

if ($exists) {
    die("Already owned");
}

$mysqli->begin_transaction();

if ($currency === "robux") {
    $stmt = $mysqli->prepare("UPDATE currency SET rbx = rbx - ? WHERE id = ?");
} else {
    $stmt = $mysqli->prepare("UPDATE currency SET tix = tix - ? WHERE id = ?");
}

$stmt->bind_param("ii", $price, $user_id);

if (!$stmt->execute()) {
    $mysqli->rollback();
    die("Failed to deduct balance");
}

$stmt = $mysqli->prepare("INSERT IGNORE INTO inventory (user_id, item_id) VALUES (?, ?)");
$stmt->bind_param("ii", $user_id, $item_id);

if (!$stmt->execute()) {
    $mysqli->rollback();
    die("Failed to grant item");
}

$mysqli->commit();

echo "success";
?>