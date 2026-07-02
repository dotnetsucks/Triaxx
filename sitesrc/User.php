<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Triaxx</title>

    <link rel="stylesheet" type="text/css" href="AllCSS.css">

    <style>
    #Banner {
    background-image: url(assets/Banner.jpg);
    }
    #Point1 {
        background-image: url(assets/BuildIcon.png);
    }
    #Point2 {
        background-image: url(assets/FriendsIcon.png);
    }
    #Point3 {
        background-image: url(assets/BattleIcon.png);
    }   
</style>
</head>
<body>
    <?php
    require_once './config/db.php';

    $id = (int) $_GET['ID'];

    $stmt = $mysqli->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user || !isset($_GET['ID']) || (int)$_GET['ID'] == 0) {
        header('Location: ./Default.aspx');
        exit;
    }
    
    include("./components/nav.php");
    include("./components/pages/user.php");
    include("./components/footer.php");
    ?>
</body>
</html>