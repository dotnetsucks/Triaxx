<?php
require_once("./config/db.php");

$place_id = isset($_GET['ID']) ? (int)$_GET['ID'] : 0;

if ($place_id <= 0) {
    header("Location: http://triaxx.nl/404.aspx");
    exit;
}

function get_place($mysqli, $place_id) {
    $stmt = $mysqli->prepare("SELECT * FROM games WHERE gid = ?");
    $stmt->bind_param("i", $place_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $place = $result->fetch_assoc();

    if (!$place) {
        return false;
    }

    $stmt = $mysqli->prepare("SELECT username FROM users WHERE id = ?");
    $stmt->bind_param("i", $place["creatorid"]);
    $stmt->execute();
    $result = $stmt->get_result();
    $creator = $result->fetch_assoc();

    $place['creator_id'] = $place['creatorid'];
    $place['creator_name'] = $creator['username'];
    $place['thumbnail_url'] = '/Thumbs/Place.aspx?ID=' . $place_id;
    $place['access_type'] = 'public';
    $place['copy_protected'] = false;
    $place['favorited_count'] = 0;
    $place['visited_count'] = 0;
    $place['updated_at'] = $place['lastping'];

    return $place;
}

function get_servers($mysqli, $place_id) {
    $stmt = $mysqli->prepare("SELECT status, gid, jobid FROM games WHERE gid = ?");
    $stmt->bind_param("i", $place_id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();

    $servers = [];

    if ($row && (int)$row['status'] === 1) {
        $servers[] = [
            'max_players' => 6,
            'players'     => [],
            'gid'        => $row['gid'],
            'jobid'       => $row['jobid'],
        ];
    }

    return $servers;
}

function get_comments($mysqli, $place_id, $page = 1, $per_page = 10) {
    return [
        'total'    => 0,
        'page'     => 1,
        'pages'    => 1,
        'comments' => [],
    ];
}

function time_ago($datetime) {
    $diff = time() - strtotime($datetime);
    if ($diff < 60)    return "just now";
    if ($diff < 3600)  return floor($diff / 60) . " minute" . (floor($diff/60) == 1 ? "" : "s") . " ago";
    if ($diff < 86400) return floor($diff / 3600) . " hour" . (floor($diff/3600) == 1 ? "" : "s") . " ago";
    return floor($diff / 86400) . " day" . (floor($diff/86400) == 1 ? "" : "s") . " ago";
}

$place = get_place($mysqli, $place_id);

if (!$place) {
    header("Location: http://triaxx.nl/404.aspx");
    exit;
}

$servers = get_servers($mysqli, $place_id);

$comment_page = isset($_GET['cpage']) ? (int)$_GET['cpage'] : 1;
$comments_data = get_comments($mysqli, $place_id, $comment_page);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Triaxx - <?php echo htmlspecialchars($place['name']); ?></title>

    <link rel="stylesheet" type="text/css" href="https://triaxx.nl/AllCSS.css">
    <script src="/javascript/playersStuff.js"></script>

    <style>
    #Banner {
        background-image: url(http://triaxx.nl/assets/Banner.jpg);
    }
    </style>
</head>
<body>
    <?php include("./components/nav.php"); ?>

    <center>
    <div id="ItemContainer">
        <div id="Item">
            <h2><?php echo htmlspecialchars($place['name']); ?></h2>

            <div id="Details">

                <div id="Thumbnail_Place">
                    <a title="<?php echo htmlspecialchars($place['name']); ?>" style="display:inline-block;">
                        <img src="<?php echo htmlspecialchars($place['thumbnail_url']); ?>" border="0" alt="<?php echo htmlspecialchars($place['name']); ?>" width="420px" height="230px">
                    </a>
                </div>

                <div id="Actions_Place">
                    <a>Favorite</a>
                </div>

                <div class="PlayGames">
                    <div style="text-align: center; margin: 1em 5px;">
                        <?php if ($place['access_type'] === 'friends_only'): ?>
                            <span><img src="/assets/locked.png" alt="Locked" border="0">&nbsp;Friends-only</span>
                        <?php else: ?>
                            <span><img src="/assets/public.png" alt="Public" border="0">&nbsp;Public</span>
                        <?php endif; ?>

                        <?php if ($place['copy_protected']): ?>
                            <img src="/assets/CopyLocked.png" alt="CopyLocked" border="0">
                            Copy Protection: CopyLocked
                        <?php endif; ?>
                    </div>

<button class="Button" onclick="window.location.href='./api/game/join.aspx?ID=<?php echo isset($_GET['ID']) ? $_GET['ID'] : ''; ?>'">
    Visit Online
</button>

                        &nbsp;&nbsp;&nbsp;
                        <button class="Button" disabled style="opacity:0.5; cursor:not-allowed;" onclick="return false;">Visit Solo</button>
                    </div>
                </div>
                
                <div id="Summary" style="text-align: left; display: inline-block;">
                    <h3>TRIAXX Place</h3>
                            
                    <div id="Creator" class="Creator">
                        <div class="Avatar">
                            <a title="<?php echo htmlspecialchars($place['creator_name']); ?>" href="/User.php?ID=<?php echo $place['creator_id']; ?>" style="display:inline-block;cursor:pointer;">
                                <img src="/Thumbs/Avatar.aspx?ID=<?php echo $place['creator_id']; ?>" border="0" alt="<?php echo htmlspecialchars($place['creator_name']); ?>" width="100px" height="100px">
                            </a>
                        </div>
                        Creator: <a href="/User.php?ID=<?php echo $place['creator_id']; ?>"><?php echo htmlspecialchars($place['creator_name']); ?></a>
                    </div>

                    <div id="LastUpdate">Updated: <?php echo date('M j, Y', strtotime($place['updated_at'])); ?></div>
                    <div id="Favorited">Favorited: <?php echo (int)$place['favorited_count']; ?> times</div>
                    <div class="Visited">Visited: <?php echo (int)$place['visited_count']; ?> times</div>

                    <div>
                        <div id="DescriptionLabel">Description:</div>
                        <div id="Description"><?php echo nl2br(htmlspecialchars($place['description'])); ?></div>
                    </div>

                    <div id="ReportAbuse">
                        <span class="AbuseButton"><a href="/AbuseReport.php?ID=<?php echo $place_id; ?>">Report Abuse</a></span>
                    </div>
                </div>

                <div style="clear: both;"></div>
            </div>
            <a style="color: #000000; display: block;" href="" title="ad">
		    	<img src="/assets/AdSkyscraperTemplate.png" alt="ad" width="160" height="600" border="1">
            </a>


            <div style="margin: 10px; width: 703px;">
                <div class="ajax__tab_xp">
                    <div id="TabHeader">
                        <span id="GamesTabLink"><h3>Games</h3></span>
                        <span id="CommentaryTabLink"><h3>Commentary</h3></span>
                    </div>

                    <div id="TabBody">

                        <div id="GamesTab">
                            <table width="100%" cellspacing="0" border="0">
                                <?php if (empty($servers)): ?>
                                    <tr><td>No servers are currently running.</td></tr>
                                <?php else: ?>
                                    <?php foreach ($servers as $server): ?>
                                        <tr>
                                            <td>
                                                <div class="GameInstance" style="margin: 3px 0">
                                                    <div style="float: right;">
                                                        <?php foreach ($server['players'] as $player): ?>
                                                            <a title="<?php echo htmlspecialchars($player['username']); ?>" href="/User.php?ID=<?php echo $player['id']; ?>" style="display:inline-block;">
                                                                <img src="/Thumbs/Avatar.aspx?ID=<?php echo $place['creator_id']; ?>" border="0" alt="<?php echo htmlspecialchars($place['creator_name']); ?>" width="100px" height="100px">
                                                            </a>
                                                        <?php endforeach; ?>
                                                    </div>
                                                    <div style="text-align: left;">
                                                        <?php echo count($server['players']); ?> players of <?php echo (int)$server['max_players']; ?> max<br>&nbsp;
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </table>

                            <div class="RefreshRunningGames">
                                <input type="submit" value="Refresh" class="Button" onclick="location.reload()">
                            </div>
                        </div>

                        <div id="CommentaryTab" style="display:none;">
                            <div class="CommentsContainer">
                                <h3>Comments (<?php echo (int)$comments_data['total']; ?>)</h3>

                                <div class="HeaderPager">
                                    <span>Page <?php echo $comments_data['page']; ?> of <?php echo $comments_data['pages']; ?></span>
                                    <?php if ($comments_data['page'] < $comments_data['pages']): ?>
                                        <a href="?ID=<?php echo $place_id; ?>&cpage=<?php echo $comments_data['page'] + 1; ?>">Next &gt;&gt;</a>
                                    <?php endif; ?>
                                </div>

                                <div class="Comments">
                                    <?php if (empty($comments_data['comments'])): ?>
                                        <p>No comments yet.</p>
                                    <?php else: ?>
                                        <?php foreach ($comments_data['comments'] as $i => $comment): ?>
                                            <div class="<?php echo $i % 2 === 0 ? 'Comment' : 'AlternateComment'; ?>">
                                                <div class="Commenter">
                                                    <div class="Avatar">
                                                        <a title="<?php echo htmlspecialchars($comment['username']); ?>" href="/User.php?ID=<?php echo $comment['id']; ?>" style="display:inline-block;cursor:pointer;">
                                                            <img src="/Thumbs/Avatar.aspx?ID=<?php echo $place['creator_id']; ?>" border="0" alt="<?php echo htmlspecialchars($place['creator_name']); ?>" width="100px" height="100px">
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="Post">
                                                    <div class="Audit">
                                                        Posted <?php echo time_ago($comment['posted_at']); ?> by
                                                        <a href="/User.php?ID=<?php echo $comment['id']; ?>"><?php echo htmlspecialchars($comment['username']); ?></a>
                                                    </div>
                                                    <div class="Content"><?php echo htmlspecialchars($comment['content']); ?></div>
                                                </div>
                                                <div style="clear: both;"></div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>

                                <form method="POST" action="/post_comment.php">
                                    <input type="hidden" name="place_id" value="<?php echo $place_id; ?>">
                                    <textarea name="content" rows="3" style="width:100%;" placeholder="Post a comment..."></textarea>
                                    <button type="submit" class="Button">Post</button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    
    </center>

    <script>
    document.getElementById('GamesTabLink').onclick = function() {
        document.getElementById('GamesTab').style.display = 'block';
        document.getElementById('CommentaryTab').style.display = 'none';
    };
    document.getElementById('CommentaryTabLink').onclick = function() {
        document.getElementById('GamesTab').style.display = 'none';
        document.getElementById('CommentaryTab').style.display = 'block';
    };
    </script>
    <?php include("./components/footer.php"); ?>
</body>
</html>