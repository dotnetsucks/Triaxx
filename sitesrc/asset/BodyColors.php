<?php
require_once('../config/db.php');

if (!isset($_GET['ID'])) {
    die('no id set');
}
$id = (int)$_GET['ID'];

$stmt = $mysqli->prepare("SELECT * FROM users WHERE ID = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$user = $stmt->get_result()->fetch_assoc();

$head = $user['headcolor'];
$torso = $user['torsocolor'];
$leftarm = $user['leftarmcolor'];
$rightarm = $user['rightarmcolor'];
$leftleg = $user['leftlegcolor'];
$rightleg = $user['rightlegcolor'];

header("Content-Type: application/xml")
?>

<roblox xmlns:xmime="http://www.w3.org/2005/05/xmlmime"
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:noNamespaceSchemaLocation="http://www.roblox.com/roblox.xsd"
        version="4">
    <External>null</External>
    <External>nil</External>
    <Item class="BodyColors" referent="RBX0">
        <Properties>
            <int name="HeadColor"><?= $head ?></int>
            <int name="LeftArmColor"><?= $leftarm ?></int>
            <int name="LeftLegColor"><?= $leftleg ?></int>
            <string name="Name">Body Colors</string>
            <int name="RightArmColor"><?= $rightarm ?></int>
            <int name="RightLegColor"><?= $rightleg ?></int>
            <int name="TorsoColor"><?= $torso ?></int>
            <bool name="archivable">true</bool>
        </Properties>
    </Item>
</roblox>