<?php
require '../config/db.php';
session_start();
header('Content-Type: application/json');

if (isset($_GET['mode']) && $_GET['mode'] === 'get') {

    $name = $_SESSION['username'];

    $stmt = $mysqli->prepare("
        SELECT headcolor, torsocolor, leftarmcolor, rightarmcolor, leftlegcolor, rightlegcolor
        FROM users
        WHERE username = ?
    ");
    $stmt->bind_param("s", $name);
    $stmt->execute();

    $result = $stmt->get_result();

    echo json_encode($result->fetch_assoc());
    exit;
}

if (!isset($_SESSION['username'])) {
    echo json_encode(['error' => 'not_logged_in']);
    exit;
}

$name = $_SESSION['username'];

$part = (int)($_POST['part'] ?? 0);
$color = (int)($_POST['color'] ?? 0);
$csrf = $_POST['csrf'] ?? '';

if (!isset($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(32));
}

$columns = [
    1 => 'rightlegcolor',
    2 => 'headcolor',
    3 => 'torsocolor',
    4 => 'leftarmcolor',
    5 => 'rightarmcolor',
    6 => 'leftlegcolor'
];

if (!isset($columns[$part])) {
    echo json_encode(['error' => 'invalid_part']);
    exit;
}

if ($color < 1 || $color > 226) {
    echo json_encode(['error' => 'invalid_color']);
    exit;
}

$column = $columns[$part];

$sql = "UPDATE users SET {$column} = ? WHERE username = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("is", $color, $name);
$stmt->execute();

$stmt = $mysqli->prepare("
    SELECT headcolor, torsocolor, leftarmcolor, rightarmcolor, leftlegcolor, rightlegcolor
    FROM users
    WHERE username = ?
");
$stmt->bind_param("s", $name);
$stmt->execute();

$result = $stmt->get_result();

echo json_encode($result->fetch_assoc());