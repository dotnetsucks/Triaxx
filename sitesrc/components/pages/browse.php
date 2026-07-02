<?php
require_once __DIR__ . '/../../config/db.php';

$page = isset($_GET['i']) ? max(1, (int)$_GET['i']) : 1;
$limit = 10;
$offset = ($page - 1) * $limit;
$search = isset($_GET['q']) ? trim($_GET['q']) : '';
$searchParam = '%' . $search . '%';

if ($search !== '') {
    $countStmt = $mysqli->prepare("SELECT COUNT(*) FROM users WHERE username LIKE ?");
    $countStmt->bind_param("s", $searchParam);
} else {
    $countStmt = $mysqli->prepare("SELECT COUNT(*) FROM users");
}
$countStmt->execute();
$totalUsers = $countStmt->get_result()->fetch_row()[0];
$totalPages = max(1, ceil($totalUsers / $limit));

if ($search !== '') {
    $stmt = $mysqli->prepare("SELECT id, username, createdat FROM users WHERE username LIKE ? LIMIT ? OFFSET ?");
    $stmt->bind_param("sii", $searchParam, $limit, $offset);
} else {
    $stmt = $mysqli->prepare("SELECT id, username, createdat FROM users LIMIT ? OFFSET ?");
    $stmt->bind_param("ii", $limit, $offset);
}
$stmt->execute();
$result = $stmt->get_result();
?>
<div id="Body">
    <div id="ctl00_cphRoblox_Panel1">
        <div id="BrowseContainer" style="text-align:center">
            <form method="GET" action="Browse.aspx">
                <input name="q" type="text" maxlength="100" value="<?php echo htmlspecialchars($search); ?>"/>&nbsp;
                <input type="submit" value="Search"/>
            </form>
            <br/>
            <div>
                <table class="Grid" cellspacing="0" cellpadding="4" border="0">
                    <tr class="GridHeader">
                        <th scope="col">Avatar</th>
                        <th scope="col">Name</th>
                        <th scope="col">Status</th>
                        <th scope="col">Location / Last Seen</th>
                    </tr>
                    <?php if ($totalUsers == 0) { ?>
                    <tr><td colspan="4">No users found.</td></tr>
                    <?php } ?>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr class="GridItem">
                        <td>
                            <a title="<?php echo htmlspecialchars($row['username']); ?>" href="User.aspx?ID=<?php echo $row['id']; ?>" style="display:inline-block;cursor:pointer;">
                                <img src="./Thumbs/Avatar.aspx?ID=<?php echo $row['id']; ?>" height="40" width="40" border="0" alt="User"/>
                            </a>
                        </td>
                        <td>
                            <a href="User.aspx?ID=<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['username']); ?></a>
                            <br/>
                            <span><?php echo htmlspecialchars("Hi my name is " . $row['username'] . "!"); ?></span>
                        </td>
                        <td><span>Unknown</span></td>
                        <td><span>Unknown</span></td>
                    </tr>
                    <?php } ?>
                    <tr class="GridPager">
                        <td colspan="4">
                            <table border="0"><tr>
                                <?php if ($page > 1) { ?>
                                    <td><a href="Browse.aspx?i=<?php echo $page - 1; ?>&q=<?php echo urlencode($search); ?>">&lt;&lt; Previous</a></td>
                                <?php } ?>
                                <?php for ($p = 1; $p <= $totalPages; $p++) { ?>
                                    <td><?php if ($p == $page) { ?><span><?php echo $p; ?></span><?php } else { ?><a href="Browse.aspx?i=<?php echo $p; ?>&q=<?php echo urlencode($search); ?>"><?php echo $p; ?></a><?php } ?></td>
                                <?php } ?>
                                <?php if ($page < $totalPages) { ?>
                                    <td><a href="Browse.aspx?i=<?php echo $page + 1; ?>&q=<?php echo urlencode($search); ?>">Next &gt;&gt;</a></td>
                                <?php } ?>
                            </tr></table>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>