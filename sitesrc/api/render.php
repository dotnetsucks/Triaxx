<?php
include('../config/db.php');

if (!isset($_GET['ID'])) {
die('Avatar failed to render.');
} else {
$id = $_GET['ID'];
}
$base = "http://26.72.83.255";
require('./Soap.php');
$rcc = new GetALiveAndSoap("26.72.83.255", 799);
// var_dump($rcc->isOnline());
$luaScript = '
local plr = game.Players:CreateLocalPlayer(0)
plr:LoadCharacter()
plr.CharacterAppearance = "http://triaxx.nl/asset/BodyColors.ashx?ID=' . $id . ';http://triaxx.nl/asset/Hats.ashx?ID=' . $id . '"

-- face: plr.Character.Head.face.Texture = "' . $base . '/assets/faces/Smile.png"
local thumbnailGenerator = game:GetService("ThumbnailGenerator")
local b64 = thumbnailGenerator:Click("PNG", 500, 500, true)
return b64
';
    
$response = $rcc->execScript($luaScript, "render_user_" . $id . "_" . bin2hex(random_bytes(10)), 2);

$stmt = $mysqli->prepare("UPDATE users SET render = ? WHERE id = ?");

if (!$stmt) {
    die($mysqli->error);
}

$stmt->bind_param("si", $response, $id);
$stmt->execute();

header("Location: " . ($_SERVER['HTTP_REFERER'] ?? '/'));
exit;
?>
