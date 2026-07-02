<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/db.php');

ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($mysqli->connect_error) { die("Connection failed: " . $mysqli->connect_error); }

$c = isset($_GET['c']) ? (int)$_GET['c'] : 8;
$stmt = $mysqli->prepare("SELECT id, name, creator_id, sold, favorites, price_robux, price_tix FROM catalog WHERE category = ?");
$stmt->bind_param("i", $c);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id, $name, $creator_id, $sold, $favorites, $price_robux, $price_tix);

$rows = [];
while ($stmt->fetch()) {
    $rows[] = [
        'id' => $id,
        'name' => $name,
        'creator_id' => $creator_id,
        'sold' => $sold,
        'favorites' => $favorites,
        'price_robux' => $price_robux,
        'price_tix' => $price_tix
    ];
}
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Triaxx</title>
    <link rel="stylesheet" type="text/css" href="https://triaxx.nl/AllCSS.css">
    <style>
    #Banner { background-image: url(http://triaxx.nl/assets/Banner.jpg); }
    </style>
</head>
<body>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/components/nav.php'); ?>
    <center>
        <div id="Body">
<div id="CatalogContainer">
    <div id="SearchBar" class="SearchBar">
        <span class="SearchBox"><input name="ctl00$cphRoblox$rbxCatalog$SearchTextBox" type="text" maxlength="100" id="ctl00_cphRoblox_rbxCatalog_SearchTextBox" class="TextBox"></span>
        <span class="SearchButton"><input type="submit" name="ctl00$cphRoblox$rbxCatalog$SearchButton" value="Search" id="ctl00_cphRoblox_rbxCatalog_SearchButton"></span>
    </div>
    <div class="DisplayFilters">
        <h2>Catalog</h2>
        <div id="BrowseMode">
            <h4><a href="http://www.cafepress.com/triaxx" target="_blank">Buy TRIAXX Stuff!</a></h4>
            <h4>Browse</h4>
            <ul>
                <li><img class="GamesBullet" src="/assets/games_bullet.png" border="0"><a href="Catalog.aspx?m=TopFavorites&amp;c=8&amp;t=AllTime&amp;d=All"><b>Top Favorites</b></a></li>
                <li><a href="Catalog.aspx?m=BestSelling&amp;c=8&amp;t=AllTime&amp;d=All">Best Selling</a></li>
                <li><a href="Catalog.aspx?m=RecentlyUpdated&amp;c=8">Recently Updated</a></li>
                <li><a href="Catalog.aspx?m=ForSale&amp;c=8&amp;d=All">For Sale</a></li>
                <li><a href="Catalog.aspx?m=PublicDomain&amp;c=8">Public Domain</a></li>
            </ul>
        </div>
        <div id="Category">
            <h4>Category</h4>
            <ul>
                <li><a href="Catalog.aspx?m=TopFavorites&amp;c=2&amp;t=PastWeek&amp;d=All">T-Shirts</a></li>
                <li><a href="Catalog.aspx?m=TopFavorites&amp;c=11&amp;t=PastWeek&amp;d=All">Shirts</a></li>
                <li><a href="Catalog.aspx?m=TopFavorites&amp;c=12&amp;t=PastWeek&amp;d=All">Pants</a></li>
                <li><a href="Catalog.aspx?m=TopFavorites&amp;c=8&amp;t=PastWeek&amp;d=All">Hats</a></li>
                <li><a href="Catalog.aspx?m=TopFavorites&amp;c=10&amp;t=PastWeek&amp;d=All">Models</a></li>
                <li><a href="Catalog.aspx?m=TopFavorites&amp;c=9&amp;t=PastWeek&amp;d=All">Places</a></li>
            </ul>
        </div>
    </div>
    <div class="Assets">
        <table cellspacing="0" align="Center" border="0" width="735">
        <tbody>
        <?php if (count($rows) === 0): ?>
        <tr><td><p>No items found.</p></td></tr>
        <?php else: ?>
        <tr>
        <?php
        $counter = 0;
        foreach ($rows as $row) {
            if ($counter > 0 && $counter % 5 == 0) echo '</tr><tr>';
        ?>
            <td valign="top">
                <div class="Asset">
                    <div class="AssetThumbnail">
                        <a href="Item.aspx?ID=<?php echo (int)$row['id']; ?>"><img src="/Thumbs/Hat.ashx?ID=<?=$row['id']?>" border="0" alt="<?php echo htmlspecialchars($row['name']); ?>" width=125px height=125px></a>
                    </div>
                    <div class="AssetDetails">
                        <div class="AssetName"><a href="Item.aspx?ID=<?php echo (int)$row['id']; ?>"><?php echo htmlspecialchars($row['name']); ?></a></div>
                        <div class="AssetCreator"><span class="Label">Creator:</span> <span class="Detail">
                            <a href="/User.aspx?ID=
                            <?php
                            $stmt = $mysqli->prepare("SELECT * FROM users WHERE id = ?");
                            $stmt->bind_param("i", $row['creator_id']);
                            $stmt->execute();

                            $result = $stmt->get_result();
                            $user = $result->fetch_assoc();

                            echo htmlspecialchars($row['creator_id']);
                            ?>"><?=$user['username']?></a></span></div>
                        <div class="AssetsSold"><span class="Label">Number Sold:</span> <span class="Detail"><?php echo (int)$row['sold']; ?></span></div>
                        <div class="AssetFavorites"><span class="Label">Favorited:</span> <span class="Detail"><?php echo (int)$row['favorites']; ?> times</span></div>
                        <?php if ($row['price_robux'] > 0) echo '<div class="AssetPrice"><span class="PriceInRobux">R$: ' . number_format($row['price_robux']) . '</span></div>'; ?>
                        <?php if ($row['price_tix'] > 0) echo '<div class="AssetPrice"><span class="PriceInTickets">Tx: ' . number_format($row['price_tix']) . '</span></div>'; ?>
                    </div>
                </div>
            </td>
        <?php
            $counter++;
        }
        ?>
        </tr>
        <?php endif; ?>
        </tbody>
        </table>
    </div>
</div>
        </div>
    </center>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/components/footer.php'); ?>
</body>
</html>