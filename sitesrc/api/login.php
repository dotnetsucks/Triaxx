<?php
require_once("../config/db.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

$conn = new mysqli($servername, $username, $password, $database);

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");

    if (!$stmt) {
        die($conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {

        echo "User found<br>";

        if (password_verify($password, $user['password'])) {

            $_SESSION['userid'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['userid'] = $user['id'];

            echo $_SESSION['username'];
            header("Location: ../User.aspx");

        } else {
            echo "Password wrong";
        }

    } else {
        echo "No user found";
    }
}