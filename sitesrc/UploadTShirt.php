
<?php
include('./components/nav.php');
require_once('./config/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_SESSION['userid'])) {
        die("Not logged in");
    }

    $id = (int)$_SESSION['userid'];

	try {
    $lemecheck = $mysqli->query("SHOW TABLES LIKE 'currency'");
    if ($lemecheck->num_rows == 0) {
        throw new Exception("Unknown table. ask pluto");
    }
    
    if (!isset($id) || filter_var($id, FILTER_VALIDATE_INT) === false) {
     throw new Exception("Bad id");
    }
    
    $stmt = $mysqli->prepare("SELECT * FROM currency WHERE id = ?");
    $stmt->bind_param("i", $id);
     $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 0) {
     throw new Exception("Id $id not found. go ahead");
    }
    $user = $result->fetch_assoc(); } 
	catch (Exception $e) {
    error_log($e->getMessage());
    die("Error SystemD: " . $e->getMessage());
	}

    if ($user['tix'] <= 3) {
        die('Need more tix');
    }

    if (!isset($_FILES['png'])) {
        die("No file received");
    }

    if ($_FILES['png']['error'] !== UPLOAD_ERR_OK) {
        die("Upload error: " . $_FILES['png']['error']);
    }

    $maxFileSize = 10 * 1024 * 1024; // 10 mb

    if ($_FILES['png']['size'] > $maxFileSize) {
		echo "bros want FULL HD 16K Image <br>";
        die("file exceeds limit of 10 mega beetas");
    } // ima will add some debug on this

    $extension = strtolower(pathinfo($_FILES['png']['name'], PATHINFO_EXTENSION));

    if ($extension !== 'png') { 
		echo "sorry but.. <br>";
        echo("Only .png files are allowed <br>");
		die("Bye!");
    }
    
   $theimaeg = file_get_contents($_FILES['png']['tmp_name']);
   $bcode = base64_encode($theimaeg);
	
    $assetDir = "./asset/tshirts/";

    if (!is_dir($assetDir)) {
        mkdir($assetDir, 0755, true);
    }

    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
	$robux = (int)trim($_POST['robuxsale']);
	$tixs = (int)trim($_POST['tixss']);
    $creatorId = (int)$_SESSION['userid'];
	$nothin = 0;
	$cat = 2;

    $stmt = $mysqli->prepare("INSERT INTO catalog (name, creator_id, category, favorites, sold, price_robux, price_tix, description, render) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("siiiiiiss", $name, $creatorId, $cat, $nothin, $nothin, $robux, $tixs, $description, $bcode);
    $stmt->execute();

    $gameId = $mysqli->insert_id;

    $filename = $gameId . ".png";
    $targetFile = $assetDir . $filename;

    if (move_uploaded_file($_FILES['png']['tmp_name'], $targetFile)) {

        $stmt = $mysqli->prepare("UPDATE currency SET tix = tix - 3 WHERE id = ?");
        $stmt->bind_param("i", $creatorId);
        $stmt->execute();

     

    } else {

        $stmt = $mysqli->prepare("DELETE FROM catalog WHERE id = ?");
        $stmt->bind_param("i", $gameId);
        $stmt->execute();

        die("Upload failed");
    }
}
?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Triaxx</title>

<link rel="stylesheet" type="text/css" href="AllCSS1.css">

<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3447738868663983" crossorigin="anonymous"></script>

<style>
#Banner { background-image: url(assets/Banner.jpg); }
#Point1 { background-image: url(assets/BuildIcon.png); }
#Point2 { background-image: url(assets/FriendsIcon.png); }
#Point3 { background-image: url(assets/BattleIcon.png); }
#ItemContainer #Item {
    width: 896px;
}
</style>

<div id="ItemContainer">
        <div id="Item">
            <h2>Upload T-Shirt</h2>
<form method="POST" enctype="multipart/form-data">
    <h1></h1>
    <input type="text" name="name" required>
    <br><br>
    <h1>Description</h1>
    <textarea name="description" required></textarea>
    <br><br>
    <input type="file" name="png" accept=".png" required>
    <br><br>
    <input type="submit" value="Upload">
</form>
            </div>
</div>


                

<?php
include("./components/footer.php");