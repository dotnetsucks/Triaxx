<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Triaxx</title>

    <link rel="stylesheet" type="text/css" href="https://triaxx.nl/AllCSS.css">

    <style>
    #Banner {
    background-image: url(http://triaxx.nl/assets/Banner.jpg);
    }
</style>
</head>
<body>
    <?php
    include("./components/nav.php");
    ?>
    <center>
        <h1><p>404 - Oops! The page you were looking for doesn't exist.</p></h1><button id="back" class="BigButton" onclick="location.replace('/')">Go back Home</button>
    </center>
    <?php
    include("./components/footer.php");
    ?>
</body>
</html>