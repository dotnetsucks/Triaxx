<?php
include('../config/db.php');

if (!isset($_GET['ID'])) {
die('Hat failed to render.');
} else {
$id = $_GET['ID'];
}
$base = "http://26.72.83.255";
require('./Soap.php');
$rcc = new GetALiveAndSoap("26.72.83.255", 799);
// var_dump($rcc->isOnline());
$luaScript = '
game:GetObjects("http://triaxx.nl/asset/Hats/' . $id . '.rbxm")[1].Parent = workspace

local thumbnailGenerator = game:GetService("ThumbnailGenerator")
local b64 = thumbnailGenerator:Click("PNG", 500, 500, true)
return b64
';
    
$response = $rcc->execScript($luaScript, "render_hat_" . $id . "_" . bin2hex(random_bytes(10)), 2);

$stmt = $mysqli->prepare("UPDATE catalog SET render = ? WHERE id = ?");

if (!$stmt) {
    die($mysqli->error);
}

$stmt->bind_param("si", $response, $id);
$stmt->execute();

// header("Location: " . ($_SERVER['HTTP_REFERER'] ?? '/'));
exit;
?>
