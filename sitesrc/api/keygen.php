<?php
$username = $_SESSION['username'];

$stmt = $mysqli->prepare("SELECT clikey FROM users WHERE username=?");
$stmt->bind_param("s", $username);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user) {

    $clikey = bin2hex(random_bytes(32));

        $update = $mysqli->prepare("UPDATE users SET clikey=? WHERE username=?");
        $update->bind_param("ss", $clikey, $username);
        $update->execute();

} else {

    echo "User not found";

}
?>