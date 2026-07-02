<?php
session_start();
require_once('../config/db.php');
$mysqli = new mysqli($servername, $username, $password, $database);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['assetFile'])) {
    $userID = $_SESSION['userid'];
    $name = $mysqli->real_escape_string($_POST['name']);
    $desc = $mysqli->real_escape_string($_POST['description']);
    $type = $_POST['assettype']; 

    $allowedTypes = ['Hats', 'Shirts', 'Pants', 'Decals', 'Audios', 'TShirts'];
    if (!in_array($type, $allowedTypes)) die("Invalid asset type");

    $file = $_FILES['assetFile'];
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    if (strtolower($ext) !== 'rbxm') die("only .rbxm files allowed dumbass");

    $stmt = $mysqli->prepare("INSERT INTO assets (assetname, assetdesc, assettype, creatorid) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $name, $desc, $type, $userID);
    $stmt->execute();
    $newID = $stmt->insert_id;

    $targetDir = $_SERVER['DOCUMENT_ROOT'] . "/storage/" . $type . "/";
    if (!file_exists($targetDir)) mkdir($targetDir, 0777, true);
    
    move_uploaded_file($file['tmp_name'], $targetDir . $newID . ".rbxm");
    
    echo "Asset uploaded successfully with ID: " . $newID;
}
?>