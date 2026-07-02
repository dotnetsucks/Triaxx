<?php
header('Content-Type: text/plain');
include('../config/db.php');

$ticket = "TRIAXX-" . bin2hex(random_bytes(32));
$secret_code = bin2hex(random_bytes(16));

$stmt = $mysqli->prepare("INSERT INTO auth_tickets (ticket, secret_code) VALUES (?, ?)");
$stmt->execute([$ticket, password_hash($secret_code, PASSWORD_DEFAULT)]);

echo $ticket;