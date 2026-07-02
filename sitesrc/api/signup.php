<?php
require_once("../config/db.php");

$conn = new mysqli($servername, $username, $password , $database);

if ($conn->connect_error) {
    die("Database connection failed");
}

session_start();

$username = trim(htmlspecialchars($_POST["username"]));
$password = trim(htmlspecialchars($_POST["password"]));
$confirm_password = trim(htmlspecialchars($_POST["confirm_password"]));
$invitekey = trim(htmlspecialchars($_POST["invitekey"]));

if ($username == "" || $password == "" || $confirm_password == "" || $invitekey == "") {
    die("Fill in all fields");
}

if (strlen($username) < 3 || strlen($username) > 20) {
    die("Username must be between 3 and 20 characters");
}

if (!ctype_alnum($username)) {
    die("Username can only contain A-Z, a-z, and 0-9 with no spaces");
}

if (strlen($password) < 6) {
    die("Password must be at least 6 characters");
}

if ($password != $confirm_password) {
    die("Passwords do not match");
}

$stmt = $conn->prepare("SELECT * FROM invitekeys WHERE invitekey = ?");
$stmt->bind_param("s", $invitekey);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Invalid invite key");
}

$check = $conn->prepare("SELECT id FROM users WHERE username = ?");
$check->bind_param("s", $username);
$check->execute();

$result = $check->get_result();

if ($result->num_rows > 0) {
    die("Username already exists");
}

$delete = $conn->prepare("DELETE FROM invitekeys WHERE invitekey = ?");
$delete->bind_param("s", $invitekey);
$delete->execute();

$idResult = $conn->query("SELECT MAX(id) AS maxid FROM users");
$idRow = $idResult->fetch_assoc();

$newid = 1;

if ($idRow["maxid"] != null) {
    $newid = $idRow["maxid"] + 1;
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$createdat = date("Y-m-d");

$stmt = $conn->prepare("INSERT INTO users (id, username, password, createdat) VALUES (?, ?, ?, ?)");

$stmt->bind_param("isss", $newid, $username, $hashedPassword, $createdat);

if ($stmt->execute()) {

    $_SESSION["userid"] = $newid;
    $_SESSION["username"] = $username;

    header("Location: /");
    exit;

} else {

    die("Signup failed");

}
?>