<?php

$page = isset($_GET['i']) ? max(1, (int)$_GET['i']) : 1;
$limit = 9;
$offset = ($page - 1) * $limit;

$countStmt = $mysqli->prepare("SELECT COUNT(*) FROM games");
$countStmt->execute();
$totalGames = $countStmt->get_result()->fetch_row()[0];
$totalPages = max(1, ceil($totalGames / $limit));

$stmt = $mysqli->prepare("SELECT g.name, g.gid, g.creatorid, u.username FROM games g LEFT JOIN users u ON u.id = g.creatorid LIMIT ? OFFSET ?");
$stmt->bind_param("ii", $limit, $offset);
$stmt->execute();
$games = $stmt->get_result();
?>

<div id="Body">
    <div id="GamesContainer">
        <div id="ctl00_cphRoblox_rbxGames_GamesContainerPanel">
            <div class="DisplayFilters">
                <h2>Games&nbsp;<a href="#"><img src="./assets/feed-icon-14x14.png" alt="RSS" border="0"/></a></h2>

                <div id="BrowseMode">
                    <h4>Browse</h4>
                    <ul>
                        <li><img class="GamesBullet" src="./assets/games_bullet.png" alt="Bullet" border="0"/><a href="Games.aspx?m=MostPopular&amp;t=Now"><b>Most Popular</b></a></li>
                        <li><a href="Games.aspx?m=TopFavorites&amp;t=AllTime">Top Favorites</a></li>
                        <li><a href="Games.aspx?m=RecentlyUpdated">Recently Updated</a></li>
                        <li><a href="User.aspx?id=1">Featured Games</a></li>
                    </ul>
                </div>

                <div id="ctl00_cphRoblox_rbxGames_pTimespan">
                    <div id="Timespan">
                        <h4>Time</h4>
                        <ul>
                            <li><img class="GamesBullet" src="./assets/games_bullet.png" alt="Bullet" border="0"/><a href="Games.aspx?m=MostPopular&amp;t=Now"><b>Now</b></a></li>
                            <li><a href="Games.aspx?m=MostPopular&amp;t=PastDay">Past Day</a></li>
                            <li><a href="Games.aspx?m=MostPopular&amp;t=PastWeek">Past Week</a></li>
                            <li><a href="Games.aspx?m=MostPopular&amp;t=PastMonth">Past Month</a></li>
                            <li><a href="Games.aspx?m=MostPopular&amp;t=AllTime">All-time</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div id="Games">
                <span class="GamesDisplaySet">Most Popular (Now)</span>

                <div class="HeaderPager">
                    <span>Page <?php echo $page; ?> of <?php echo $totalPages; ?>:</span>
                    <?php if ($page > 1) { ?>
                        <a href="Games.aspx?i=<?php echo $page - 1; ?>">
                            <span class="NavigationIndicators">&lt;&lt;</span> Previous
                        </a>
                    <?php } ?>
                    <?php if ($page < $totalPages) { ?>
                        <a href="Games.aspx?i=<?php echo $page + 1; ?>">
                            Next <span class="NavigationIndicators">&gt;&gt;</span>
                        </a>
                    <?php } ?>
                </div>

                <table id="ctl00_cphRoblox_rbxGames_dlGames" cellspacing="0" align="Center" border="0" width="550">

                    <?php
                    $i = 0;
                    while ($game = $games->fetch_assoc()) {

                        if ($i % 3 == 0) {
                            echo "<tr>";
                        }
                    ?>

                        <td class="Game" valign="top">
                            <div style="padding-bottom:5px">
                                <div class="GameThumbnail">
                                    <a title="<?php echo htmlspecialchars($game['name']); ?>" href="/Place.aspx?ID=<?php echo $game['gid']; ?>" style="display:inline-block;cursor:pointer;">
                                        <img src="/Thumbs/Place.aspx?ID=<?php echo htmlspecialchars($game['gid']) ?>" style="width:160px;height:100px;">
                                    </a>
                                </div>

                                <div class="GameDetails">
                                    <div class="GameName">
                                        <a href="Place.aspx?ID=<?php echo $game['gid']; ?>">
                                            <?php echo htmlspecialchars($game['name']); ?>
                                        </a>
                                    </div>

                                    <div class="GameLastUpdate">
                                        <span class="Label">Updated:</span>
                                        <span class="Detail">0 hours ago</span>
                                    </div>

                                    <div class="GameCreator">
                                        <span class="Label">Creator:</span>
                                        <span class="Detail">
                                            <a href="User.aspx?ID=<?php echo $game['creatorid']; ?>">
                                                <?php echo htmlspecialchars($game['username']); ?>
                                            </a>
                                        </span>
                                    </div>

                                    <div class="AssetFavorites">
                                        <span class="Label">Favorited:</span>
                                        <span class="Detail">0 times</span>
                                    </div>

                                    <div class="GamePlays">
                                        <span class="Label">Played:</span>
                                        <span class="Detail">0 times today</span>
                                    </div>

                                    <div class="GameCurrentPlayers">
                                        <span class="DetailHighlighted">0 players online</span>
                                    </div>
                                </div>
                            </div>
                        </td>

                    <?php
                        $i++;

                        if ($i % 3 == 0) {
                            echo "</tr>";
                        }
                    }

                    if ($i % 3 != 0) {
                        echo "</tr>";
                    }
                    ?>

                </table>

                <div class="HeaderPager">
                    <span>Page <?php echo $page; ?> of <?php echo $totalPages; ?>:</span>
                    <?php if ($page > 1) { ?>
                        <a href="Games.aspx?i=<?php echo $page - 1; ?>">
                            <span class="NavigationIndicators">&lt;&lt;</span> Previous
                        </a>
                    <?php } ?>
                    <?php if ($page < $totalPages) { ?>
                        <a href="Games.aspx?i=<?php echo $page + 1; ?>">
                            Next <span class="NavigationIndicators">&gt;&gt;</span>
                        </a>
                    <?php } ?>
                </div>

            </div>
        </div>

        <a style="color: #000000; display: block;" href="" title="ad">
			<img src="/assets/AdSkyscraperTemplate.png" alt="ad" width="160" height="600" border="1">
        </a>

        <div style="clear: both;"></div>
    </div>
</div>