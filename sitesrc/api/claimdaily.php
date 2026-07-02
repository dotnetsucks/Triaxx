<?php
if (!isset($_SESSION['userid'])) {
    die("login bro");
}

$id = $_SESSION['userid'];

$stmt = $mysqli->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$stmt = $mysqli->prepare("SELECT lstcli, tix FROM currency WHERE id = ?");
if (!$stmt) {
    die("Prepare failed: " . $mysqli->error);
}

$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($lstcli, $tix);

if (!$stmt->fetch()) {
    $stmt->close();
    die("No currency row for this user");
}

$stmt->close();

$now = time();
$cooldown = 86400;

if ($lstcli == 0 || $now > ($lstcli + $cooldown)) {

    $newTix = $tix + 10;

    $update = $mysqli->prepare("UPDATE currency SET lstcli = ?, tix = ? WHERE id = ?");
    if (!$update) {
        die("update prep fail: " . $mysqli->error);
    }

    $update->bind_param("iii", $now, $newTix, $id);

    if (!$update->execute()) {
        die("upd fail: " . $update->error);
    }

    $update->close();

    echo '
    <div class="SystemAlert">
        <div class="SystemAlertText" style="background-color:blue;">
            <div class="Exclamation"></div>
            <div>Claimed daily 10 tickets!</div>
        </div>
    </div>
    ';

} else {
    $timeLeft = ($lstcli + $cooldown) - $now;

    echo "Next claim in: " . gmdate("H:i:s", $timeLeft);
}


?>
<style>
	.SystemAlert {
                    background-color: #FFF;
                    text-align: center;
                    color: #FFF;
                    border: 2px solid #000;
                    font: normal 8pt/normal 'Comic Sans MS', Verdana, sans-serif;
                    padding: 1px;
                    border-top: 1.9px black solid;
                }

                .SystemAlertText {
                    font: normal 8pt/normal 'Comic Sans MS', Verdana, sans-serif;
                    font-size: 16px;
                    font-weight: bold;
                    padding: 2px;
                }

                .Exclamation {
                    background: url("/images/exclamation.png") no-repeat;
                    font: normal 8pt/normal 'Comic Sans MS', Verdana, sans-serif;
                    height: 16px;
                    width: 16px;
                    float: left;
                }
</style>