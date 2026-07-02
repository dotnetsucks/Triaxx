<?php
require_once('../config/db.php');

header("Content-Type: application/json");

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    echo json_encode(["success" => false, "error" => "DB error"]);
    exit;
}

$key = $_GET["key"] ?? null
;

if (!$key) {
    echo json_encode(["success" => false, "error" => "Missing key"]);
    exit;
}

$stmt = $conn->prepare("SELECT id, username, clikey FROM users WHERE clikey = ?");
$stmt->bind_param("s", $key);
$stmt->execute();

$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode([
        "success" => true,
        "data" => $row
    ]);
} else {
    echo json_encode([
        "success" => false,
        "error" => "Invalid key"
    ]);
}

$conn->close();