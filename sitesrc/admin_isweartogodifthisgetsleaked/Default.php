<?php
session_start();
require_once($_SERVER["DOCUMENT_ROOT"] . "/config/db.php");

$stmt = $mysqli->prepare("SELECT id, username FROM users WHERE username = ?");
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!isset($_SESSION["username"]) || ($user['id'] !== 1 && $user['id'] !== 24)) {
    die("Access denied.");
}

$userCount = $mysqli->query("SELECT COUNT(*) FROM users")->fetch_row()[0];
$gameCount = $mysqli->query("SELECT COUNT(*) FROM games")->fetch_row()[0];
$visitsResult = $mysqli->query("SELECT SUM(visits) FROM games")->fetch_row()[0];
$totalVisits = ($visitsResult !== null) ? $visitsResult : 0;
?>

<?php include(__DIR__ . "/components/nav.php"); ?>

<div id="Container">
    <div id="Body">
        <h1>Welcome to the Admin Panel, <?= htmlspecialchars($user["username"]) ?>!</h1>
        
        <div class="Card">
            <h3>Statistics</h3>
            <p>Users: <?= number_format($userCount) ?></p>
            <p>Games: <?= number_format($gameCount) ?></p>
            <p>Total Visits: <?= number_format($totalVisits) ?></p>
        </div>

        <h3>Users</h3>
        <a href="/admin_isweartogodifthisgetsleaked/Users/Economy.aspx">economy</a><br>
        <a href="/admin_isweartogodifthisgetsleaked/Keys.aspx">Invite Keys</a>

        <h3>Catalog</h3>
        <a href="/admin_isweartogodifthisgetsleaked/Catalog/Face.aspx">Upload a Face</a><br>
        <a href="/admin_isweartogodifthisgetsleaked/Catalog/Hat.aspx">Upload a Hat</a><br>
        <a href="/admin_isweartogodifthisgetsleaked/Catalog/Gear.aspx">Upload Gears</a><br>
        <a href="/admin_isweartogodifthisgetsleaked/Catalog/Mesh.aspx">Upload a Mesh</a><br>
        <a href="/admin_isweartogodifthisgetsleaked/Catalog/Texture.aspx">Upload a Texture</a>

        <h3>Misc</h3>
        <a href="/admin_isweartogodifthisgetsleaked/Misc/Asset.aspx">Download an Asset</a>
    </div>
</div>

<?php include(__DIR__ . "/components/footer.php"); ?>