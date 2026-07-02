<?php
include('./components/nav.php');
require_once('./config/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_SESSION['userid'])) {
        die("Not logged in");
    }

    $id = (int)$_SESSION['userid'];

    $stmt = $mysqli->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user['uploads'] >= 3) {
        die('limit of 3 uploads reached');
    }

    if (!isset($_FILES['rbxl'])) {
        die("No file received");
    }

    if ($_FILES['rbxl']['error'] !== UPLOAD_ERR_OK) {
        die("Upload error: " . $_FILES['rbxl']['error']);
    }

    $maxFileSize = 10 * 1024 * 1024; // 10 mb

    if ($_FILES['rbxl']['size'] > $maxFileSize) {
        die("file exceeds limit of 10 mega beetas");
    }

    $extension = strtolower(pathinfo($_FILES['rbxl']['name'], PATHINFO_EXTENSION));

    if ($extension !== 'rbxl') {
        die("Only .rbxl files are allowed");
    }
    
    $assetDir = "./api/game/rbxl/";

    if (!is_dir($assetDir)) {
        mkdir($assetDir, 0755, true);
    }

    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $creatorId = (int)$_SESSION['userid'];

    $stmt = $mysqli->prepare("INSERT INTO games (name, creatorid, description) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $name, $creatorId, $description);
    $stmt->execute();

    $gameId = $mysqli->insert_id;

    $filename = $gameId . ".rbxl";
    $targetFile = $assetDir . $filename;

    if (move_uploaded_file($_FILES['rbxl']['tmp_name'], $targetFile)) {

        $stmt = $mysqli->prepare("UPDATE users SET uploads = uploads + 1 WHERE id = ?");
        $stmt->bind_param("i", $creatorId);
        $stmt->execute();

        $stmt = $mysqli->prepare("UPDATE games SET gid = ? WHERE gid = 0 ORDER BY gid DESC LIMIT 1");
        $stmt->bind_param("i", $gameId);
        $stmt->execute();

        include('./api/render_game.php');

    } else {

        $stmt = $mysqli->prepare("DELETE FROM games WHERE gid = ?");
        $stmt->bind_param("i", $gameId);
        $stmt->execute();

        die("Upload failed");
    }
}
?>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Triaxx</title>

<link rel="stylesheet" type="text/css" href="AllCSS1.css">

<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3447738868663983" crossorigin="anonymous"></script>

<style>
#Banner { background-image: url(assets/Banner.jpg); }
#Point1 { background-image: url(assets/BuildIcon.png); }
#Point2 { background-image: url(assets/FriendsIcon.png); }
#Point3 { background-image: url(assets/BattleIcon.png); }
</style>

<div id="ItemContainer">
<form method="POST" enctype="multipart/form-data">
    <h1>Name</h1>
    <input type="text" name="name" required>
    <br><br>
    <h1>Description</h1>
    <textarea name="description" required></textarea>
    <br><br>
    <input type="file" name="rbxl" accept=".rbxl" required>
    <br><br>
    <input type="submit" value="Upload">
</form>
</div>

<?php include('./components/footer.php'); ?>