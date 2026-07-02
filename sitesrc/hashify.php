<?php

$hashed = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $password = $_POST["password"];
    $hashed = password_hash($password, PASSWORD_DEFAULT);

}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Password Hasher</title>
</head>
<body>

<form method="POST">

    <input type="text" name="password" placeholder="Enter password">

    <button type="submit">Hash Password</button>

</form>

<?php if ($hashed != "") { ?>

    <h3>Hashed Password:</h3>

    <textarea rows="3" cols="80"><?php echo $hashed; ?></textarea>

<?php } ?>

</body>
</html>