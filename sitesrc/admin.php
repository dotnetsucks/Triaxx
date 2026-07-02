<?php
session_start();

require_once('./config/db.php');

$stmt = $mysqli->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (
    !isset($_SESSION["username"]) ||
    ($user['id'] !== 1 && $user['id'] !== 24)
) {
    die("Access denied.");
}


if ($mysqli->connect_error) {
    die("Connection failed");
}

function generateInviteKey() {
    return "TRIAXX-" .
        rand(1000, 9999) . "-" .
        rand(1000, 9999) . "-" .
        rand(1000, 9999) . "-" .
        rand(1000, 9999);
}

$generatedKeys = [];

$currentText = "";

$result = $mysqli->query("SELECT text FROM alert LIMIT 1");
if ($result && $row = $result->fetch_assoc()) {
    $currentText = $row["text"];
}

if (isset($_POST["update_alert"])) {
    $newText = $_POST["alert_text"];

    $stmt = $mysqli->prepare("UPDATE alert SET text = ? LIMIT 1");
    $stmt->bind_param("s", $newText);
    $stmt->execute();
    $stmt->close();

    header("Location: admin.aspx");
    exit;
}

if (isset($_POST["generate"])) {
    $amount = intval($_POST["amount"]);

    if ($amount > 0 && $amount <= 100) {
        $stmt = $mysqli->prepare("INSERT INTO invitekeys (invitekey) VALUES (?)");

        for ($i = 0; $i < $amount; $i++) {
            $inviteKey = generateInviteKey();
            $stmt->bind_param("s", $inviteKey);
            $stmt->execute();
            $generatedKeys[] = $inviteKey;
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Triaxx Admin</title>

    <link rel="stylesheet" type="text/css" href="AllCSS.css">

    <style>
        #Banner {
            background-image: url(assets/Banner.jpg);
        }
    </style>
</head>
<body>

<?php include("./components/nav.php"); ?>

<h2>Edit Alert</h2>
<form method="POST">
    <input type="text" name="alert_text" value="<?php echo htmlspecialchars($currentText); ?>" required>
    <button type="submit" name="update_alert">Update Alert</button>
</form>

<br><br>

<form method="POST">
    <input type="number" name="amount" min="1" max="100" placeholder="Amount" required>
    <button type="submit" name="generate">Generate Keys</button>
</form>

<?php
if (!empty($generatedKeys)) {
    echo "<h3>Generated Keys:</h3>";
    foreach ($generatedKeys as $key) {
        echo "<p>$key</p>";
    }
}
?>

<?php include("./components/footer.php"); ?>

</body>
</html>