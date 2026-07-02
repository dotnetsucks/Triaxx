<?php
include('../config/db.php');

if (!isset($_GET['ID'])) {
if (!isset($gameId)) {
    die('render failed.');
} else {
    $id = (int) $gameId;
}
} else {
$id = (int) $_GET['ID'];
}
$base = "http://26.72.83.255";
require('./Soap.php');
$rcc = new GetALiveAndSoap("26.72.83.255", 799);
// var_dump($rcc->isOnline());
$luaScript = '
game:Load("http://26.72.83.255/api/game/rbxl/' . $id . '.rbxl")
b64 = game:GetService("ThumbnailGenerator"):Click("PNG", 420, 230, false)
return b64
';
    
$response = $rcc->execScript($luaScript, "render_game_" . $id . "_" . bin2hex(random_bytes(10)), 2);

$stmt = $mysqli->prepare("UPDATE games SET render = ? WHERE gid = ?");

if (!$stmt) {
    die($mysqli->error);
}

$stmt->bind_param("si", $response, $id);
$stmt->execute();

echo 'game rendered.';
?>