<?php
require_once __DIR__ . '/../config/db.php';
session_start();

$allowedPages = [
    '/Welcome.aspx',
    '/Login/New.aspx',
    '/Login/Default.aspx'
];

$currentPage = strtok($_SERVER['REQUEST_URI'], '?');

if (!isset($_SESSION['username']) && !in_array($currentPage, $allowedPages, true)) {
    header('Location: /Welcome.aspx');
    exit;
}

$id = null;

if (isset($_SESSION['username'])) {

    $username = $_SESSION['username'];

    $userStmt = $mysqli->prepare("SELECT id FROM users WHERE username = ?");
    $userStmt->bind_param("s", $username);
    $userStmt->execute();

    $userStmt->bind_result($id);

    if (!$userStmt->fetch()) {
        $userStmt->close();
        die("User not found");
    }

    $userStmt->close();

	$stmt = $mysqli->prepare("SELECT rbx, tix FROM currency WHERE id = ?");
	$stmt->bind_param("i", $id);
	$stmt->execute();

	$result = $stmt->get_result();
	$currency = $result->fetch_assoc();

	$stmt->close();

	if (!$currency) {

		$rbx = 0;
		$tix = 0;

		$insert = $mysqli->prepare("INSERT INTO currency (id, rbx, tix) VALUES (?, ?, ?)");
		$insert->bind_param("iii", $id, $rbx, $tix);
		$insert->execute();
		$insert->close();

		$currency = [
			'rbx' => 0,
			'tix' => 0
		];
	}

    include(__DIR__ . '/../api/claimdaily.php');

    $alert = $mysqli->prepare("SELECT * FROM alert LIMIT 1");
	$alert->execute();

	$result = $alert->get_result();
	$row = $result->fetch_assoc();

	$alert->close();
}

?>
<link rel="stylesheet" type="text/css" href="/AllCSS.css">
<style>
	#Banner {
    background-image: url(/assets/Banner.jpg);
    }
	.SystemAlert {
                    background-color: #FFF;
                    text-align: center;
                    color: #FFF;
                    border: 2px solid #000;
                    font: normal 8pt/normal 'Comic Sans MS', Verdana, sans-serif;
                    padding: 1px;
                    border-top: 1.9px black solid;
                }

                .SystemAlertText {
                    font: normal 8pt/normal 'Comic Sans MS', Verdana, sans-serif;
                    font-size: 16px;
                    font-weight: bold;
                    padding: 2px;
                }

                .Exclamation {
                    background: url("/assets/exclamation.png") no-repeat;
                    font: normal 8pt/normal 'Comic Sans MS', Verdana, sans-serif;
                    height: 16px;
                    width: 16px;
                    float: left;
                }
</style>

<br><br><br>
<div id="Container">
		<center>
	<div class="Ads_WideSkyscraper" style="position: relative; display: inline-block;">
		<a style="color: #000000; display: block;" href="" title="ad">
			<img src="/assets/ad.png" alt="ad" width="728" height="90" border="1">
		</a>
		<a href="/AbuseReport/Ad.aspx?id=1" style="position:absolute;bottom:0;right:0; background:#EEE;border:1px solid #000; font-family:Verdana;font-size:10px;color:blue;">
			[ report ]
		</a>
	</div>
	</center>
<div id="Header">
	
					<div id="Banner">
						<div id="Options">
							<div id="Authentication">
								<span><?php echo isset($_SESSION['username']) ? "Logged in as " . $_SESSION['username'] . " | <a href='/api/logout.aspx'>Logout</a>" : "<a href='/Login/Default.aspx'>Login</a>"; ?></span>
							</div>
							<div id="Settings">
								<span id="ctl00_lSettings"><?php echo isset($_SESSION['username']) ? "Age: 13+, Chat Mode: higu" : ""; ?></span>
							</div>
						</div>
						<div id="Logo">
						<a id="ctl00_rbxImage_Logo" title="TRIAXX" href="/Default.aspx" style="display:inline-block;cursor:pointer;">
                        <img src="/assets/TriaxxBanner.png" width="190px" height="56px" border="0" alt="TRIAXX" blankurl="#">
					</a>
						</div>
						<div id="Alerts">
							<table style="width:100%;height:100%"><tbody><tr><td valign="middle">
							<?php
							if (isset($_SESSION['username']))
							{
								echo 
								'
								<div id="ctl00_rbxAlerts_AlertSpacePanel">
	
	    <div id="AlertSpace">
								<div id="ctl00_rbxAlerts_RobuxAlertPanel">
			    					<div id="RobuxAlert">
			        					<a id="ctl00_rbxAlerts_RobuxAlertIconHyperLink" class="RobuxAlertIcon" href="My/AccountBalance.aspx">
										<img src="/assets/Robux.png" style="border-width:0px;"/></a>&nbsp;
				   						<a id="ctl00_rbxAlerts_RobuxAlertCaptionHyperLink" class="RobuxAlertCaption" href="/My/AccountBalance.aspx">' . $currency['rbx'] . ' TRIBUX</a>
			    					</div>
		    					</div>

		    					<div id="ctl00_rbxAlerts_TicketsAlertPanel">
			    					<div id="TicketsAlert">
			        					<a id="ctl00_rbxAlerts_TicketsAlertIconHyperLink" class="TicketsAlertIcon" href="My/AccountBalance.aspx">
										<img src="/assets/Tickets.png" style="border-width:0px;"/></a>&nbsp;
				   						<a id="ctl00_rbxAlerts_TicketsAlertCaptionHyperLink" class="TicketsAlertCaption" href="/My/AccountBalance.aspx">' . $currency['tix'] . ' Trickets</a>
			    				</div>
								</div>
								'
								; }
								else {
									echo 
									'
									<a id="ctl00_rbxAlerts_SignupAndPlayHyperLink" class="SignUpAndPlay" href="/Login/New.aspx">
									<img src="/assets/SignupBanner.png" alt="Sign-up and Play!" border="0" width="202px" height="32px"></a>
									'
								; }								
								?>
</td></tr></tbody></table></div>
					</div>
					<div class="Navigation">
						<span><a id="ctl00_hlMyRoblox" class="MenuItem" href="/User.aspx?ID=<?php echo $id; ?>">My TRIAXX</a></span>
						<span class="Separator">&nbsp;|&nbsp;</span>
						<span><a id="ctl00_hlGames" class="MenuItem" href="/Games.aspx">Games</a></span>
						<span class="Separator">&nbsp;|&nbsp;</span>
						<span><a id="ctl00_hlCatalog" class="MenuItem" href="/Catalog.aspx">Catalog</a></span>
						<span class="Separator">&nbsp;|&nbsp;</span>
						<span><a id="ctl00_hlBrowse" class="MenuItem" href="/Browse.aspx">People</a></span>
						<span class="Separator">&nbsp;|&nbsp;</span>
                        <span><a id="ctl00_hlBuildersClub" class="MenuItem" href="/Upgrades/BuildersClub.aspx">Builders Club</a></span>
						<span class="Separator">&nbsp;|&nbsp;</span>
						<span><a id="ctl00_hlForum" class="MenuItem" href="/Forum/Default.aspx">Forum</a></span>
						<span class="Separator">&nbsp;|&nbsp;</span>
						<span><a id="ctl00_hlNews" class="MenuItem" href="/Blog.aspx" target="_blank">News</a>&nbsp;<a id="ctl00_hlNewsFeed" href="#"><img src="/assets/feed-icon-14x14.png" alt="RSS" border="0"></a></span> 
						<span class="Separator">&nbsp;|&nbsp;</span>
						<span><a id="ctl00_hlHelp" class="MenuItem" href="/Help.aspx" target="_blank">Help</a></span>
 					</div>
				</div>

<div class="SystemAlert">
    <div id="ctl00_SystemAlertTextColor" class="SystemAlertText" style="background-color:red;">
            <div class="Exclamation"></div>
            <div id="ctl00_LabelAnnouncement">Join our <a href="https://discord.gg/tuHDbhn3JY">discord server</a>!</div>
    </div>
</div>

<?php
if (isset($row['text'])) {
echo '
<div class="SystemAlert">
    <div id="ctl00_SystemAlertTextColor" class="SystemAlertText" style="background-color:orange;">
            <div class="Exclamation"></div>
            <div id="ctl00_LabelAnnouncement">' . htmlspecialchars($row['text']) . '</div>
    </div>
</div>
';
}
?>