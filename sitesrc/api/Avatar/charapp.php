<?php
if (!isset($_GET['ID'])) {
    die('no id set');
}
$id = (int)$_GET['ID'];
include('./bodycolors.php');