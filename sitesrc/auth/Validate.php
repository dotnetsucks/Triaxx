<?php
require_once('../config/db.php');
require_once('../config/fgyhdiyfgjkfeurdhfiugejrdksghoutjdfsuthgrsedkfjguhdhfkgiuhdbyfugivgidvugy.php');

$ticket_input = $_POST['ticket'] ?? '';

$stmt = $mysqli->prepare("SELECT signature, used FROM auth_tickets WHERE ticket = ?");
$stmt->execute([$ticket_input]);
$row = $stmt->fetch();

$expected_signature = hash_hmac('sha256', $ticket_input, GLOBAL_AUTH_KEY);

if ($row && $row['used'] == 0 && hash_equals($row['signature'], $expected_signature)) {
    $update = $mysqli->prepare("UPDATE auth_tickets SET used = 1 WHERE ticket = ?");
    $update->execute([$ticket_input]);
    
    echo "Valid";
} else {
    echo "Invalid";
}

$mysqli->exec("DELETE FROM auth_tickets WHERE created_at < NOW() - INTERVAL 1 DAY");
