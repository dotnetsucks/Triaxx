<?php
header("content-type: text/plain");
if (!isset($_GET["id"])) {
    die('no id');
}
if (!filter_var($_GET["id"], FILTER_VALIDATE_INT)) {
    die('no int');
}
$id = (int) $_GET["id"];
if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/asset/" . $id . ""))
{
$file = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/asset/" . $id . "");
echo $file;
} else {
header("Location: https://assetdelivery.ttblox.mom/v1/asset/?id=". $id ."");
die();
}
?>