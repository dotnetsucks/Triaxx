<?php
require_once __DIR__ . '/../../config/db.php';

$id = (int) $_GET['ID'];

$stmt = $mysqli->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>
<div id="Body">
	<div id="UserContainer">
		<div id="LeftBank">
			<div id="ctl00_cphTRIAXX_pProfile">
	
				<div id="ProfilePane">
					
<table width="100%" bgcolor="lightsteelblue" cellpadding="6" cellspacing="0">
    <tbody><tr>
        <td>
            <?php
            if (isset($_SESSION['username']) && $_SESSION['username'] === $user['username']) {
                echo '<span id="ctl00_cphTRIAXX_rbxUserPane_lUserName" class="Title">Hi, ' . htmlspecialchars($user['username']) . '!</span><br>';
            } else {
                echo '<span id="ctl00_cphTRIAXX_rbxUserPane_lUserName" class="Title">' . htmlspecialchars($user['username']) . '\'s TRIAXX:</span><br>';
            }
            ?>
            
        </td>
    </tr>
    <tr>
        <td>
            <?php
            if (isset($_SESSION['username']) && $_SESSION['username'] === $user['username']) {
                echo '<span id="ctl00_cphTRIAXX_rbxUserPane_lUserTRIAXXURL">Your TRIAXX:</span><br>';
            } else {
                echo "<span id='ctl00_cphTRIAXX_rbxUserPane_lUserTRIAXXURL'>" . $user["username"] . "'s TRIAXX:</span><br>";
            }
            ?>
            <a id="ctl00_cphTRIAXX_rbxUserPane_hlUserTRIAXXURL" href="./User.aspx?ID=<?php echo $_GET["ID"] ?>">http://triaxx.nl/User.aspx?ID=<?php echo $_GET["ID"] ?></a><br>
            <br>
            <div style="left: 0px; float: left; position: relative; top: 0px">
                <a id="ctl00_cphTRIAXX_rbxUserPane_Image1" disabled="disabled" title="<?php echo $user['username']; ?>" onclick="return false" style="display:inline-block;height:220px;width:180px;">
                    <img src="./Thumbs/Avatar.aspx?ID=<?php echo $user['id'];?>" style="display:inline-block;height:220px;width:220px;" border="0" id="img" alt="<?php echo $user['username']; ?>"></a><br>
                
            </div>
            
<?php
if (isset($_SESSION['username']) && $_SESSION['username'] === $user['username']) {

    echo '
    <p><a id="ctl00_cphTRIAXX_rbxUserPane_rbxMyUser_UpgradesHyperLink" href="/My/AccountUpgrades/Manage.aspx">Upgrades</a></p>
    <p><a id="ctl00_cphTRIAXX_rbxUserPane_rbxMyUser_hlMyRobux" href="/My/AccountBalance.aspx">Account Balance</a></p>
    <p><a id="ctl00_cphTRIAXX_rbxUserPane_rbxMyUser_hlMyInbox" href="/My/Inbox.aspx">Inbox</a>&nbsp;</p>
    <p><a id="ctl00_cphTRIAXX_rbxUserPane_rbxMyUser_hlMyAvatar" href="/My/Character.aspx">Change Character</a></p>
    <p><a id="ctl00_cphTRIAXX_rbxUserPane_rbxMyUser_hlMyProfile_Edit" href="./Profile.aspx">Edit Profile</a></p>
    <p><a id="ctl00_cphTRIAXX_rbxUserPane_rbxMyUser_hlMyProfile_View" href="./user.aspx?ForcePublicView=true&amp;id=26">View Profile</a></p>
    <p>
        <a href="./PlaceUpload.aspx">Create New Place</a><br>
        <span style="color:black;">(' . 3 - $user['uploads'] . ' Remaining)</span>
    </p>
    ';

    if ($user['id'] == 1 || $user['id'] ==24) {
        echo '<p><a href="./admin.aspx">Admin Panel</a></p>';
    }
} else {
    echo '
    <p><a id="ctl00_cphTRIAXX_rbxUserPane_rbxMyUser_sendmessage" href="./My/PrivateMessage.aspx?RecipientID=' . $_GET['ID'] . '">Send Message</a></p>
    <p><a id="ctl00_cphTRIAXX_rbxUserPane_rbxMyUser_sendfriendrequest" href="./My/FriendInvitation.aspx?RecipientID=' . $_GET['ID'] . '">Send Friend Request</a></p>
    ';
}
?>
            
        </td>
    </tr>
</tbody></table>

				</div>
			
</div>
			<div id="ctl00_cphTRIAXX_pUserBadges">
	
				<div id="UserBadgesPane">
					

<div id="UserBadges">
    <h4><a id="ctl00_cphRoblox_rbxUserBadgesPane_hlHeader" href="./Badges.aspx">Badges</a></h4>
    
        
    <table id="ctl00_cphRoblox_rbxUserBadgesPane_dlBadges" cellspacing="0" align="Center" border="0">
        <tbody>
                        <tr>
                    <?php
                    if ($user['id'] == 1) {
                        echo '
                        <td>
                    <div class="Badge">
                        <div class="BadgeImage">
                            <a id="ctl00_cphRoblox_rbxUserBadgesPane_dlBadges_ctl01_hlHeader" href="./Badges.aspx">
                                <img id="ctl00_cphRoblox_rbxUserBadgesPane_dlBadges_ctl01_iBadge" src="/assets/Badges/Administrator-75x75.png" alt="..." height="75" border="0">
                            </a>
                        </div>
                        <div class="BadgeLabel">
                            <a id="ctl00_cphRoblox_rbxUserBadgesPane_dlBadges_ctl01_HyperLink1" href="./Badges.aspx">Administrator</a>
                        </div>
                    </div>
                </td>
                        ';
                    }

                    if ($user['bc'] == 1) {
                        echo '<td>
                    <div class="Badge">
                        <div class="BadgeImage">
                            <a id="ctl00_cphRoblox_rbxUserBadgesPane_dlBadges_ctl02_hlHeader" href="./Badges.aspx">
                                <img id="ctl00_cphRoblox_rbxUserBadgesPane_dlBadges_ctl02_iBadge" src="/assets/Badges/BuildersClub-75x75.png" alt="..." height="75" border="0">
                            </a>
                        </div>
                        <div class="BadgeLabel">
                            <a id="ctl00_cphRoblox_rbxUserBadgesPane_dlBadges_ctl02_HyperLink1" href="./Badges.aspx">Builders Club</a>
                        </div>
                    </div>
                </td>';
                    }
                    ?>
                                <td>
                    <div class="Badge">
                        <div class="BadgeImage">
                            <a id="ctl00_cphRoblox_rbxUserBadgesPane_dlBadges_ctl03_hlHeader" href="./Badges.aspx">
                                <img id="ctl00_cphRoblox_rbxUserBadgesPane_dlBadges_ctl03_iBadge" src="/assets/Badges/CombatInitiation-75x75.jpg" alt="..." height="75" border="0">
                            </a>
                        </div>
                        <div class="BadgeLabel">
                            <a id="ctl00_cphRoblox_rbxUserBadgesPane_dlBadges_ctl03_HyperLink1" href="./Badges.aspx">Combat Initiation</a>
                        </div>
                    </div>
                </td>
                            </tr>
                    </tbody>
    </table>
</div>
				</div>
			
</div>

			
            <div id="ctl00_cphTRIAXX_pUser">

                <div id="Userhahahahanopane">


<div id="ctl00_cphRoblox_pUserStatistics">

        <div id="UserStatisticsPane">
                <div id="UserStatistics">
                    <div id="ctl00_cphRoblox_rbxUserStatisticsPane_upBody" style="">
                        <div id="ctl00_cphRoblox_rbxUserStatisticsPane_pHeader">
                            <div class="Header">
                                <h4 style="font-size: small;">Statistics</h4> 
                            </div>        
                        </div>
                        
                        <div id="ctl00_cphRoblox_rbxUserStatisticsPane_pBody" style="height:150px;">
                            <div id="ctl00_cphRoblox_rbxUserStatisticsPane_pResults">
                                <div id="Results">
                                    <div class="Statistic">
                                        <div class="Label">
                                            <acronym title="The number of this user's friends.">Friends</acronym>:
                                        </div>
                                        <div class="Value">
                                            <span id="ctl00_cphRoblox_rbxUserStatisticsPane_lFriendsStatistics">
                                                0 (0 last week)
                                            </span>
                                        </div>
                                    </div>
                                    <div class="Statistic">
                                        <div class="Label">
                                            <acronym title="The number of posts this user has made to the R89BX forum.">Forum Posts</acronym>:
                                        </div>
                                        <div class="Value">
                                            <span id="ctl00_cphRoblox_rbxUserStatisticsPane_lForumPostsStatistics">
                                                0 (0 last week)
                                            </span>
                                        </div>
                                    </div>
                                    <div class="Statistic">
                                        <div class="Label">
                                            <acronym title="The number of times this user's profile has been viewed.">Profile Views</acronym>:
                                        </div>
                                        <div class="Value">
                                            <span id="ctl00_cphRoblox_rbxUserStatisticsPane_lProfileViewsStatistics">
                                                26 (0 last week)
                                            </span>
                                        </div>
                                    </div>
                                    <div class="Statistic">
                                        <div class="Label">
                                            <acronym title="The number of times this user's place has been visited.">Place Visits</acronym>:
                                        </div>
                                        <div class="Value">
                                            <span id="ctl00_cphRoblox_rbxUserStatisticsPane_lPlaceVisitsStatistics">
                                                90 (0 last week)
                                            </span>
                                        </div>
                                    </div>
                                    <div class="Statistic">
                                        <div class="Label">
                                            <acronym title="The number of times this user's character has destroyed another user's character in-game.">Knockouts</acronym>:
                                        </div>
                                        <div class="Value">
                                            <span id="ctl00_cphRoblox_rbxUserStatisticsPane_lKillsStatistics">
                                                30 (0 last week)
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
		</div>
		<div id="RightBank">
			<div id="UserPlacesPane">
			<div id="ctl00_cphTRIAXX_pUserPlacesPane">
<script>
document.addEventListener("DOMContentLoaded", function () {

    var headers = document.querySelectorAll(".AccordionHeader");
    var speed = 10;

    function setNaturalHeight(el) {
        el.style.overflow = "";
        el.style.height = "auto";
        el.style.display = "block";
    }

    headers.forEach(function (header) {
        var content = header.nextElementSibling;
        if (!content) return;

        var isOpen = window.getComputedStyle(content).display !== "none";

        if (!isOpen) {
            content.style.display = "none";
            content.style.height = "0px";
        } else {
            setNaturalHeight(content);
        }
    });

    headers.forEach(function (header) {
        header.addEventListener("click", function () {

            var content = header.nextElementSibling;
            if (!content) return;

            headers.forEach(function (h) {
                var c = h.nextElementSibling;
                if (c && c !== content && c.style.display !== "none") {
                    slideUp(c);
                }
            });

            if (content.style.display === "none" || (content.style.height === "0px" && content.style.display !== "none")) {
                slideDown(content);
            } else if (content.style.display !== "none") {
                slideUp(content);
            }
        });
    });

    function slideDown(el) {
        if (!el || el.style.display === "block" && el.style.height === "auto") return;

        el.style.display = "block";
        el.style.overflow = "hidden";
        el.style.height = "0px";

        var fullHeight = el.scrollHeight;
        if (fullHeight === 0) return;

        var current = 0;

        var interval = setInterval(function () {
            current += speed;
            if (current >= fullHeight) {
                clearInterval(interval);
                el.style.overflow = "";
                el.style.height = "auto";
            } else {
                el.style.height = current + "px";
            }
        }, 10);
    }

    function slideUp(el) {
        if (!el || el.style.display === "none") return;

        if (el.style.height === "auto" || el.style.height === "") {
            el.style.height = el.scrollHeight + "px";
        }

        var current = parseInt(el.style.height, 10);
        if (isNaN(current) || current <= 0) return;

        el.style.overflow = "hidden";
        var interval = setInterval(function () {
            current -= speed;
            if (current <= 0) {
                clearInterval(interval);
                el.style.height = "0px";
                el.style.display = "none";
            } else {
                el.style.height = current + "px";
            }
        }, 10);
    }

});
</script>

<div id="UserPlaces">
	<h4>Showcase</h4>
	<div>
    <div id="ctl00_cphRoblox_rbxUserPlacesPane_ShowcasePlacesAccordion">
        <input type="hidden" name="ctl00$cphRoblox$rbxUserPlacesPane$ShowcasePlacesAccordion_AccordionExtender_ClientState" id="ctl00_cphRoblox_rbxUserPlacesPane_ShowcasePlacesAccordion_AccordionExtender_ClientState" value="0">

                                
                <div class="AccordionHeader">
                    Game</div>
                

                <div style="display: block; height: auto;">
                    <div class="Place">
                        <div class="PlayStatus">
                                                            <span id="ctl00_cphRoblox_rbxUserPlacesPane_ctl02_rbxPlatform_rbxPlaceAccessIndicator_FriendsOnlyLocked" style="display:inline;">
                                    <img id="ctl00_cphRoblox_rbxUserPlacesPane_ctl02_rbxPlatform_rbxPlaceAccessIndicator_iFriendsOnly_Locked" src="./assets/unavail.png" alt="Locked" border="0">&nbsp;Friends-only
                                </span>
                                                    </div>
                        
                        <div class="PlayOptions">
                            <div id="ctl00_cphRoblox_rbxUserPlacesPane_ctl02_rbxPlatform_rbxVisitButtons_VisitMPButton" style="display:inline">
                                <div id="ctl00_cphRoblox_rbxUserPlacesPane_ctl02_rbxPlatform_rbxVisitButtons_rbxPlaceLauncher_Panel1" class="modalPopup" style="display: none">
                                    <div style="margin: 1.5em">
                                        <div id="Spinner" style="float:left;margin:0 1em 1em 0">
                                            <img id="ctl00_cphRoblox_rbxUserPlacesPane_ctl02_rbxPlatform_rbxVisitButtons_rbxPlaceLauncher_Image1" src="TRIAXX_%20A%20FREE%20Virtual%20World-Building%20Game%20with%20Avatar%20Chat,%203D%20Environments,%20and%20Physics_files/ProgressIndicator2.gif" alt="Progress" border="0">
                                        </div>
                                        <div id="Requesting" style="display: inline">Requesting a server</div>
                                        <div id="Waiting" style="display: none">Waiting for a server</div>
                                        <div id="Loading" style="display: none">A server is loading the game</div>
                                        <div id="Joining" style="display: none">The server is ready. Joining the game...</div>
                                        <div id="Error" style="display: none">An error occured. Please try again later</div>
                                        <div id="Expired" style="display: none">There are no game servers available at this time. Please try again later</div>
                                        <div id="GameEnded" style="display: none">The game you requested has ended</div>
                                        <div id="GameFull" style="display: none">The game you requested is full. Please try again later</div>
                                        <div style="text-align: center; margin-top: 1em">
                                            <input id="Cancel" type="button" class="Button" value="Cancel">
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="ctl00$cphRoblox$rbxUserPlacesPane$ctl02$rbxPlatform$rbxVisitButtons$rbxPlaceLauncher$HiddenField1" id="ctl00_cphRoblox_rbxUserPlacesPane_ctl02_rbxPlatform_rbxVisitButtons_rbxPlaceLauncher_HiddenField1">
                                <button id="ctl00_cphRoblox_rbxUserPlacesPane_ctl02_rbxPlatform_rbxVisitButtons_hlMultiplayerVisit" class="Button" onclick="window.location = '/Place.aspx?ID=143'; return false;">Visit Online</button>
                            </div>
                            <div id="ctl00_cphRoblox_rbxUserPlacesPane_ctl02_rbxPlatform_rbxVisitButtons_VisitButton" style="display:inline">
                                &nbsp;&nbsp;&nbsp;<button id="ctl00_cphRoblox_rbxUserPlacesPane_ctl02_rbxPlatform_rbxVisitButtons_hlSoloVisit" class="Button" onclick="window.location = '/Place.aspx?ID=143'; return false;">Visit Solo</button>
                            </div>
                        </div>
                        
                        <div class="Statistics">
                            <span id="ctl00_cphRoblox_rbxUserPlacesPane_ctl02_rbxPlatform_lStatistics">
                                Visited 0 times
                            </span>
                        </div>
                        
                        <div class="Thumbnail">
                            <a id="ctl00_cphRoblox_rbxUserPlacesPane_ctl02_rbxPlatform_rbxPlaceThumbnail" title="Game" href="./Place.aspx?ID=0" style="display:inline-block;">
                                <img src="TRIAXX_%20A%20FREE%20Virtual%20World-Building%20Game%20with%20Avatar%20Chat,%203D%20Environments,%20and%20Physics_files/Place_002.png" border="0" alt="RocketArena">
                            </a>
                        </div>
                        
                        						<div class="Configuration">
           					<a id="ctl00_cphRoblox_rbxUserPlacesPane_ctl05_rbxPlatform_hlConfigurePlace" href="./Place.aspx?ID=0">Configure this Place</a>
        				</div>
                    </div>

                            </div>
                      </div>
</div>
		</div>
</div>
		</div>
			<div id="ctl00_cphTRIAXX_pFriends">
	
				<div id="FriendsPane">
					

<div id="Friends">
	<h4>My Friends <a href="./Friends.aspx?UserID=29757">See all 74</a> (<a href="./EditFriends.aspx">Edit</a>)</h4>
    
	<table id="ctl00_cphTRIAXX_rbxFriendsPane_dlFriends" cellspacing="0" align="Center" border="0" style="border-collapse:collapse;">
		<tbody><tr>
			<td>
			<div class="Friend">
				<div class="Avatar"><a id="ctl00_cphTRIAXX_rbxFriendsPane_dlFriends_ctl00_hlAvatar" title="BuilderMan" href="./User.aspx?ID=156" style="display:inline-block;height:100px;width:100px;cursor:pointer;"><img src="TRIAXX_%20A%20FREE%20Virtual%20World-Building%20Game%20with%20Avatar%20Chat,%203D%20Environments,%20and%20Physics_files/Avatar-100x100-0213f2c129eae0280a01fb9e0ed747fa.Png" border="0" id="img" alt="BuilderMan"></a></div>
				<div class="Summary">
					<span class="OnlineStatus"><img id="ctl00_cphTRIAXX_rbxFriendsPane_dlFriends_ctl00_iOnlineStatus" src="TRIAXX_%20A%20FREE%20Virtual%20World-Building%20Game%20with%20Avatar%20Chat,%203D%20Environments,%20and%20Physics_files/OnlineStatusIndicator_IsOnline.gif" alt="BuilderMan is online at Web Site." style="border-width:0px;"></span>
					<span class="Name"><a id="ctl00_cphTRIAXX_rbxFriendsPane_dlFriends_ctl00_hlFriend" href="./User.aspx?ID=156">BuilderMan</a></span>
				</div>
			</div>
		</td><td>
			<div class="Friend">
				<div class="Avatar"><a id="ctl00_cphTRIAXX_rbxFriendsPane_dlFriends_ctl01_hlAvatar" title="Chels" href="./User.aspx?ID=15952" style="display:inline-block;height:100px;width:100px;cursor:pointer;"><img src="TRIAXX_%20A%20FREE%20Virtual%20World-Building%20Game%20with%20Avatar%20Chat,%203D%20Environments,%20and%20Physics_files/Avatar-100x100-c833e2a708758b37540dff0ffffab558.Png" border="0" id="img" alt="Chels"></a></div>
				<div class="Summary">
					<span class="OnlineStatus"><img id="ctl00_cphTRIAXX_rbxFriendsPane_dlFriends_ctl01_iOnlineStatus" src="TRIAXX_%20A%20FREE%20Virtual%20World-Building%20Game%20with%20Avatar%20Chat,%203D%20Environments,%20and%20Physics_files/OnlineStatusIndicator_IsOffline.gif" alt="Chels is offline (last seen at 12/27/2007 3:32:07 PM)." style="border-width:0px;"></span>
					<span class="Name"><a id="ctl00_cphTRIAXX_rbxFriendsPane_dlFriends_ctl01_hlFriend" href="./User.aspx?ID=15952">Chels</a></span>
				</div>
			</div>
		</td><td>
			<div class="Friend">
				<div class="Avatar"><a id="ctl00_cphTRIAXX_rbxFriendsPane_dlFriends_ctl02_hlAvatar" title="KilllerZ" href="./User.aspx?ID=29338" style="display:inline-block;height:100px;width:100px;cursor:pointer;"><img src="TRIAXX_%20A%20FREE%20Virtual%20World-Building%20Game%20with%20Avatar%20Chat,%203D%20Environments,%20and%20Physics_files/Avatar-100x100-1d17ee8366974fb1d4f07cfb324e3d70.Png" border="0" id="img" alt="KilllerZ"></a></div>
				<div class="Summary">
					<span class="OnlineStatus"><img id="ctl00_cphTRIAXX_rbxFriendsPane_dlFriends_ctl02_iOnlineStatus" src="TRIAXX_%20A%20FREE%20Virtual%20World-Building%20Game%20with%20Avatar%20Chat,%203D%20Environments,%20and%20Physics_files/OnlineStatusIndicator_IsOffline.gif" alt="KilllerZ is offline (last seen at 6/21/2007 1:38:48 PM)." style="border-width:0px;"></span>
					<span class="Name"><a id="ctl00_cphTRIAXX_rbxFriendsPane_dlFriends_ctl02_hlFriend" href="./User.aspx?ID=29338">KilllerZ</a></span>
				</div>
			</div>
		</td>
		</tr><tr>
			<td>
			<div class="Friend">
				<div class="Avatar"><a id="ctl00_cphTRIAXX_rbxFriendsPane_dlFriends_ctl03_hlAvatar" title="mythicalgirl97" href="./User.aspx?ID=28595" style="display:inline-block;height:100px;width:100px;cursor:pointer;"><img src="TRIAXX_%20A%20FREE%20Virtual%20World-Building%20Game%20with%20Avatar%20Chat,%203D%20Environments,%20and%20Physics_files/Avatar-100x100-c7cb696d50db8a4eb92cc3509271ecf4.Png" border="0" id="img" alt="mythicalgirl97"></a></div>
				<div class="Summary">
					<span class="OnlineStatus"><img id="ctl00_cphTRIAXX_rbxFriendsPane_dlFriends_ctl03_iOnlineStatus" src="TRIAXX_%20A%20FREE%20Virtual%20World-Building%20Game%20with%20Avatar%20Chat,%203D%20Environments,%20and%20Physics_files/OnlineStatusIndicator_IsOffline.gif" alt="mythicalgirl97 is offline (last seen at 9/30/2007 8:07:06 PM)." style="border-width:0px;"></span>
					<span class="Name"><a id="ctl00_cphTRIAXX_rbxFriendsPane_dlFriends_ctl03_hlFriend" href="./User.aspx?ID=28595">mythicalgirl97</a></span>
				</div>
			</div>
		</td><td>
			<div class="Friend">
				<div class="Avatar"><a id="ctl00_cphTRIAXX_rbxFriendsPane_dlFriends_ctl04_hlAvatar" title="Godzilla24" href="./User.aspx?ID=25934" style="display:inline-block;height:100px;width:100px;cursor:pointer;"><img src="TRIAXX_%20A%20FREE%20Virtual%20World-Building%20Game%20with%20Avatar%20Chat,%203D%20Environments,%20and%20Physics_files/Avatar-100x100-9c1c3c6e8243958a948e555bf5349a79.Png" border="0" id="img" alt="Godzilla24"></a></div>
				<div class="Summary">
					<span class="OnlineStatus"><img id="ctl00_cphTRIAXX_rbxFriendsPane_dlFriends_ctl04_iOnlineStatus" src="TRIAXX_%20A%20FREE%20Virtual%20World-Building%20Game%20with%20Avatar%20Chat,%203D%20Environments,%20and%20Physics_files/OnlineStatusIndicator_IsOffline.gif" alt="Godzilla24 is offline (last seen at 12/27/2007 4:14:55 PM)." style="border-width:0px;"></span>
					<span class="Name"><a id="ctl00_cphTRIAXX_rbxFriendsPane_dlFriends_ctl04_hlFriend" href="./User.aspx?ID=25934">Godzilla24</a></span>
				</div>
			</div>
		</td><td>
			<div class="Friend">
				<div class="Avatar"><a id="ctl00_cphTRIAXX_rbxFriendsPane_dlFriends_ctl05_hlAvatar" title="Gamehero" href="./User.aspx?ID=29680" style="display:inline-block;height:100px;width:100px;cursor:pointer;"><img src="TRIAXX_%20A%20FREE%20Virtual%20World-Building%20Game%20with%20Avatar%20Chat,%203D%20Environments,%20and%20Physics_files/Avatar-100x100-4300edbc08eef1b9d709779ed6105409.Png" border="0" id="img" alt="Gamehero"></a></div>
				<div class="Summary">
					<span class="OnlineStatus"><img id="ctl00_cphTRIAXX_rbxFriendsPane_dlFriends_ctl05_iOnlineStatus" src="TRIAXX_%20A%20FREE%20Virtual%20World-Building%20Game%20with%20Avatar%20Chat,%203D%20Environments,%20and%20Physics_files/OnlineStatusIndicator_IsOnline.gif" alt="Gamehero is online at Web Site." style="border-width:0px;"></span>
					<span class="Name"><a id="ctl00_cphTRIAXX_rbxFriendsPane_dlFriends_ctl05_hlFriend" href="./User.aspx?ID=29680">Gamehero</a></span>
				</div>
			</div>
		</td>
		</tr>
	</tbody></table>

</div>
				</div>
			<br>
</div>
		</div>
		
		
		<div id="ctl00_cphTRIAXX_pUserAssets">
            <br>
			<div id="UserAssetsPane">
                
				<div id="ctl00_cphTRIAXX_rbxUserAssetsPane_upUserAssetsPane">
		
		<div id="UserAssets">
			<h4>Stuff</h4>
			<div id="AssetsMenu">
				
						<div id="ctl00_cphTRIAXX_rbxUserAssetsPane_AssetCategoryRepeater_ctl00_AssetCategorySelectorPanel" class="AssetsMenuItem_Selected">
			<a id="ctl00_cphTRIAXX_rbxUserAssetsPane_AssetCategoryRepeater_ctl00_AssetCategorySelector" class="AssetsMenuButton_Selected" href="javascript:__doPostBack('ctl00$cphTRIAXX$rbxUserAssetsPane$AssetCategoryRepeater$ctl00$AssetCategorySelector','')">Hats</a>
		</div>
					
						<div id="ctl00_cphTRIAXX_rbxUserAssetsPane_AssetCategoryRepeater_ctl01_AssetCategorySelectorPanel" class="AssetsMenuItem">
			<a id="ctl00_cphTRIAXX_rbxUserAssetsPane_AssetCategoryRepeater_ctl01_AssetCategorySelector" class="AssetsMenuButton" href="javascript:__doPostBack('ctl00$cphTRIAXX$rbxUserAssetsPane$AssetCategoryRepeater$ctl01$AssetCategorySelector','')">Shirts</a>
		</div>
					
			</div>
			<div id="AssetsContent">
				
				<table id="ctl00_cphTRIAXX_rbxUserAssetsPane_UserAssetsDataList" cellspacing="0" border="0" style="border-collapse:collapse;">
			<tbody><tr>
				<td class="Asset" valign="top">
					    <div style="padding:5px">
						<div class="AssetThumbnail">
							<a id="ctl00_cphTRIAXX_rbxUserAssetsPane_UserAssetsDataList_ctl00_AssetThumbnailHyperLink" title="Ninja Mask of Awesome" href="./Item.aspx?ID=1286496&amp;UserAssetID=641607" style="display:inline-block;height:110px;width:110px;cursor:pointer;"><img src="TRIAXX_%20A%20FREE%20Virtual%20World-Building%20Game%20with%20Avatar%20Chat,%203D%20Environments,%20and%20Physics_files/Hat-110x110-c9fb55013f8279f5644a601aeea6875b.Png" border="0" id="img" alt="Ninja Mask of Awesome"></a>
						</div>
						<div class="AssetDetails">
							<div class="AssetName"><a id="ctl00_cphTRIAXX_rbxUserAssetsPane_UserAssetsDataList_ctl00_AssetNameHyperLink" href="./Item.aspx?ID=1286496&amp;UserAssetID=641607">Ninja Mask of Awesome</a></div>
							<div class="AssetCreator"><span class="Label">Creator:</span> <span class="Detail"><a id="ctl00_cphTRIAXX_rbxUserAssetsPane_UserAssetsDataList_ctl00_GameCreatorHyperLink" href="./User.aspx?ID=1">TRIAXX</a></span></div>
							
						    
						</div>
					</div></td><td class="Asset" valign="top">
					    <div style="padding:5px">
						<div class="AssetThumbnail">
							<a id="ctl00_cphTRIAXX_rbxUserAssetsPane_UserAssetsDataList_ctl01_AssetThumbnailHyperLink" title="Buildermaster Headband" href="./Item.aspx?ID=1286495&amp;UserAssetID=638951" style="display:inline-block;height:110px;width:110px;cursor:pointer;"><img src="TRIAXX_%20A%20FREE%20Virtual%20World-Building%20Game%20with%20Avatar%20Chat,%203D%20Environments,%20and%20Physics_files/Hat-110x110-1b7d2acf69ea64877079647f8f56ba1f.Png" border="0" id="img" alt="Buildermaster Headband"></a>
						</div>
						<div class="AssetDetails">
							<div class="AssetName"><a id="ctl00_cphTRIAXX_rbxUserAssetsPane_UserAssetsDataList_ctl01_AssetNameHyperLink" href="./Item.aspx?ID=1286495&amp;UserAssetID=638951">Buildermaster Headband</a></div>
							<div class="AssetCreator"><span class="Label">Creator:</span> <span class="Detail"><a id="ctl00_cphTRIAXX_rbxUserAssetsPane_UserAssetsDataList_ctl01_GameCreatorHyperLink" href="./User.aspx?ID=1">TRIAXX</a></span></div>
							
						    
						</div>
					</div></td><td class="Asset" valign="top">
					    <div style="padding:5px">
						<div class="AssetThumbnail">
							<a id="ctl00_cphTRIAXX_rbxUserAssetsPane_UserAssetsDataList_ctl02_AssetThumbnailHyperLink" title="Pink Winter Cap" href="./Item.aspx?ID=1279019&amp;UserAssetID=613624" style="display:inline-block;height:110px;width:110px;cursor:pointer;"><img src="TRIAXX_%20A%20FREE%20Virtual%20World-Building%20Game%20with%20Avatar%20Chat,%203D%20Environments,%20and%20Physics_files/Hat-110x110-10d0594983488ad0a7e9686b77917409.Png" border="0" id="img" alt="Pink Winter Cap"></a>
						</div>
						<div class="AssetDetails">
							<div class="AssetName"><a id="ctl00_cphTRIAXX_rbxUserAssetsPane_UserAssetsDataList_ctl02_AssetNameHyperLink" href="./Item.aspx?ID=1279019&amp;UserAssetID=613624">Pink Winter Cap</a></div>
							<div class="AssetCreator"><span class="Label">Creator:</span> <span class="Detail"><a id="ctl00_cphTRIAXX_rbxUserAssetsPane_UserAssetsDataList_ctl02_GameCreatorHyperLink" href="./User.aspx?ID=1">TRIAXX</a></span></div>
							
						    
						</div>
					</div></td><td class="Asset" valign="top">
					    <div style="padding:5px">
						<div class="AssetThumbnail">
							<a id="ctl00_cphTRIAXX_rbxUserAssetsPane_UserAssetsDataList_ctl03_AssetThumbnailHyperLink" title="Christmas Baseball Cap" href="./Item.aspx?ID=1272713&amp;UserAssetID=553515" style="display:inline-block;height:110px;width:110px;cursor:pointer;"><img src="TRIAXX_%20A%20FREE%20Virtual%20World-Building%20Game%20with%20Avatar%20Chat,%203D%20Environments,%20and%20Physics_files/Hat-110x110-0b16797bf15b7ee6c208b3f73face654.Png" border="0" id="img" alt="Christmas Baseball Cap"></a>
						</div>
						<div class="AssetDetails">
							<div class="AssetName"><a id="ctl00_cphTRIAXX_rbxUserAssetsPane_UserAssetsDataList_ctl03_AssetNameHyperLink" href="./Item.aspx?ID=1272713&amp;UserAssetID=553515">Christmas Baseball Cap</a></div>
							<div class="AssetCreator"><span class="Label">Creator:</span> <span class="Detail"><a id="ctl00_cphTRIAXX_rbxUserAssetsPane_UserAssetsDataList_ctl03_GameCreatorHyperLink" href="./User.aspx?ID=1">TRIAXX</a></span></div>
							
						    
						</div>
					</div></td><td class="Asset" valign="top">
					    <div style="padding:5px">
						<div class="AssetThumbnail">
							<a id="ctl00_cphTRIAXX_rbxUserAssetsPane_UserAssetsDataList_ctl04_AssetThumbnailHyperLink" title="Opened Bombastic Gift of Awesome" href="./Item.aspx?ID=1258151&amp;UserAssetID=522558" style="display:inline-block;height:110px;width:110px;cursor:pointer;"><img src="TRIAXX_%20A%20FREE%20Virtual%20World-Building%20Game%20with%20Avatar%20Chat,%203D%20Environments,%20and%20Physics_files/Hat-110x110-745f51f5232a5785488454a583e7fbb4.Png" border="0" id="img" alt="Opened Bombastic Gift of Awesome"></a>
						</div>
						<div class="AssetDetails">
							<div class="AssetName"><a id="ctl00_cphTRIAXX_rbxUserAssetsPane_UserAssetsDataList_ctl04_AssetNameHyperLink" href="./Item.aspx?ID=1258151&amp;UserAssetID=522558">Opened Bombastic Gift of Awesome</a></div>
							<div class="AssetCreator"><span class="Label">Creator:</span> <span class="Detail"><a id="ctl00_cphTRIAXX_rbxUserAssetsPane_UserAssetsDataList_ctl04_GameCreatorHyperLink" href="./User.aspx?ID=1">TRIAXX</a></span></div>
							
						    
						</div>
					</div></td>
			</tr><tr>
				<td class="Asset" valign="top">
					    <div style="padding:5px">
						<div class="AssetThumbnail">
							<a id="ctl00_cphTRIAXX_rbxUserAssetsPane_UserAssetsDataList_ctl05_AssetThumbnailHyperLink" title="Opened Azure Gift of Builder" href="./Item.aspx?ID=1258956&amp;UserAssetID=516176" style="display:inline-block;height:110px;width:110px;cursor:pointer;"><img src="TRIAXX_%20A%20FREE%20Virtual%20World-Building%20Game%20with%20Avatar%20Chat,%203D%20Environments,%20and%20Physics_files/Hat-110x110-a2d22ebd275676df7c784dacb8bac768.Png" border="0" id="img" alt="Opened Azure Gift of Builder"></a>
						</div>
						<div class="AssetDetails">
							<div class="AssetName"><a id="ctl00_cphTRIAXX_rbxUserAssetsPane_UserAssetsDataList_ctl05_AssetNameHyperLink" href="./Item.aspx?ID=1258956&amp;UserAssetID=516176">Opened Azure Gift of Builder</a></div>
							<div class="AssetCreator"><span class="Label">Creator:</span> <span class="Detail"><a id="ctl00_cphTRIAXX_rbxUserAssetsPane_UserAssetsDataList_ctl05_GameCreatorHyperLink" href="./User.aspx?ID=1">TRIAXX</a></span></div>
							
						    
						</div>
					</div></td><td class="Asset" valign="top">
					    <div style="padding:5px">
						<div class="AssetThumbnail">
							<a id="ctl00_cphTRIAXX_rbxUserAssetsPane_UserAssetsDataList_ctl06_AssetThumbnailHyperLink" title="Opened Speckled Gift of Pinksplosion" href="./Item.aspx?ID=1245828&amp;UserAssetID=477981" style="display:inline-block;height:110px;width:110px;cursor:pointer;"><img src="TRIAXX_%20A%20FREE%20Virtual%20World-Building%20Game%20with%20Avatar%20Chat,%203D%20Environments,%20and%20Physics_files/Hat-110x110-3241cbddd5e35863b100334b5d60b215.Png" border="0" id="img" alt="Opened Speckled Gift of Pinksplosion"></a>
						</div>
						<div class="AssetDetails">
							<div class="AssetName"><a id="ctl00_cphTRIAXX_rbxUserAssetsPane_UserAssetsDataList_ctl06_AssetNameHyperLink" href="./Item.aspx?ID=1245828&amp;UserAssetID=477981">Opened Speckled Gift of Pinksplosion</a></div>
							<div class="AssetCreator"><span class="Label">Creator:</span> <span class="Detail"><a id="ctl00_cphTRIAXX_rbxUserAssetsPane_UserAssetsDataList_ctl06_GameCreatorHyperLink" href="./User.aspx?ID=1">TRIAXX</a></span></div>
							
						    
						</div>
					</div></td><td class="Asset" valign="top">
					    <div style="padding:5px">
						<div class="AssetThumbnail">
							<a id="ctl00_cphTRIAXX_rbxUserAssetsPane_UserAssetsDataList_ctl07_AssetThumbnailHyperLink" title="Opened Shiny Blue Gift of Niceness" href="./Item.aspx?ID=1237428&amp;UserAssetID=409343" style="display:inline-block;height:110px;width:110px;cursor:pointer;"><img src="TRIAXX_%20A%20FREE%20Virtual%20World-Building%20Game%20with%20Avatar%20Chat,%203D%20Environments,%20and%20Physics_files/Hat-110x110-3430837ab22e88c74cc793d536cdd9a4.Png" border="0" id="img" alt="Opened Shiny Blue Gift of Niceness"></a>
						</div>
						<div class="AssetDetails">
							<div class="AssetName"><a id="ctl00_cphTRIAXX_rbxUserAssetsPane_UserAssetsDataList_ctl07_AssetNameHyperLink" href="./Item.aspx?ID=1237428&amp;UserAssetID=409343">Opened Shiny Blue Gift of Niceness</a></div>
							<div class="AssetCreator"><span class="Label">Creator:</span> <span class="Detail"><a id="ctl00_cphTRIAXX_rbxUserAssetsPane_UserAssetsDataList_ctl07_GameCreatorHyperLink" href="./User.aspx?ID=1">TRIAXX</a></span></div>
							
						    
						</div>
					</div></td><td class="Asset" valign="top">
					    <div style="padding:5px">
						<div class="AssetThumbnail">
							<a id="ctl00_cphTRIAXX_rbxUserAssetsPane_UserAssetsDataList_ctl08_AssetThumbnailHyperLink" title="Ribbons" href="./Item.aspx?ID=1098284&amp;UserAssetID=376743" style="display:inline-block;height:110px;width:110px;cursor:pointer;"><img src="TRIAXX_%20A%20FREE%20Virtual%20World-Building%20Game%20with%20Avatar%20Chat,%203D%20Environments,%20and%20Physics_files/Hat-110x110-2f3e6c6d419a10817d76f703d6dd9914.Png" border="0" id="img" alt="Ribbons"></a>
						</div>
						<div class="AssetDetails">
							<div class="AssetName"><a id="ctl00_cphTRIAXX_rbxUserAssetsPane_UserAssetsDataList_ctl08_AssetNameHyperLink" href="./Item.aspx?ID=1098284&amp;UserAssetID=376743">Ribbons</a></div>
							<div class="AssetCreator"><span class="Label">Creator:</span> <span class="Detail"><a id="ctl00_cphTRIAXX_rbxUserAssetsPane_UserAssetsDataList_ctl08_GameCreatorHyperLink" href="./User.aspx?ID=1">TRIAXX</a></span></div>
							
						    <div class="AssetPrice"><span class="PriceInTickets">Tx: 20</span></div>
						</div>
					</div></td><td class="Asset" valign="top">
					    <div style="padding:5px">
						<div class="AssetThumbnail">
							<a id="ctl00_cphTRIAXX_rbxUserAssetsPane_UserAssetsDataList_ctl09_AssetThumbnailHyperLink" title="Straw Hat" href="./Item.aspx?ID=1033722&amp;UserAssetID=100780" style="display:inline-block;height:110px;width:110px;cursor:pointer;"><img src="TRIAXX_%20A%20FREE%20Virtual%20World-Building%20Game%20with%20Avatar%20Chat,%203D%20Environments,%20and%20Physics_files/Hat-110x110-01bbbc926b61a02718fef67462725758.Png" border="0" id="img" alt="Straw Hat"></a>
						</div>
						<div class="AssetDetails">
							<div class="AssetName"><a id="ctl00_cphTRIAXX_rbxUserAssetsPane_UserAssetsDataList_ctl09_AssetNameHyperLink" href="./Item.aspx?ID=1033722&amp;UserAssetID=100780">Straw Hat</a></div>
							<div class="AssetCreator"><span class="Label">Creator:</span> <span class="Detail"><a id="ctl00_cphTRIAXX_rbxUserAssetsPane_UserAssetsDataList_ctl09_GameCreatorHyperLink" href="./User.aspx?ID=1">TRIAXX</a></span></div>
							<div class="AssetPrice"><span class="PriceInRobux">R$: 98</span></div>
						    
						</div>
					</div></td>
			</tr><tr>
				<td class="Asset" valign="top">
					    <div style="padding:5px">
						<div class="AssetThumbnail">
							<a id="ctl00_cphTRIAXX_rbxUserAssetsPane_UserAssetsDataList_ctl10_AssetThumbnailHyperLink" title="Princess Hat" href="./Item.aspx?ID=1032641&amp;UserAssetID=48881" style="display:inline-block;height:110px;width:110px;cursor:pointer;"><img src="TRIAXX_%20A%20FREE%20Virtual%20World-Building%20Game%20with%20Avatar%20Chat,%203D%20Environments,%20and%20Physics_files/Hat-110x110-05045a9094287296b87ab494d6865ece.Png" border="0" id="img" alt="Princess Hat"></a>
						</div>
						<div class="AssetDetails">
							<div class="AssetName"><a id="ctl00_cphTRIAXX_rbxUserAssetsPane_UserAssetsDataList_ctl10_AssetNameHyperLink" href="./Item.aspx?ID=1032641&amp;UserAssetID=48881">Princess Hat</a></div>
							<div class="AssetCreator"><span class="Label">Creator:</span> <span class="Detail"><a id="ctl00_cphTRIAXX_rbxUserAssetsPane_UserAssetsDataList_ctl10_GameCreatorHyperLink" href="./User.aspx?ID=1">TRIAXX</a></span></div>
							<div class="AssetPrice"><span class="PriceInRobux">R$: 109</span></div>
						    
						</div>
					</div></td><td class="Asset" valign="top">
					    <div style="padding:5px">
						<div class="AssetThumbnail">
							<a id="ctl00_cphTRIAXX_rbxUserAssetsPane_UserAssetsDataList_ctl11_AssetThumbnailHyperLink" title="Lavender Baseball Cap" href="./Item.aspx?ID=1031324&amp;UserAssetID=40352" style="display:inline-block;height:110px;width:110px;cursor:pointer;"><img src="TRIAXX_%20A%20FREE%20Virtual%20World-Building%20Game%20with%20Avatar%20Chat,%203D%20Environments,%20and%20Physics_files/Hat-110x110-22e0600beb8be84bc10a858497e554c7.Png" border="0" id="img" alt="Lavender Baseball Cap"></a>
						</div>
						<div class="AssetDetails">
							<div class="AssetName"><a id="ctl00_cphTRIAXX_rbxUserAssetsPane_UserAssetsDataList_ctl11_AssetNameHyperLink" href="./Item.aspx?ID=1031324&amp;UserAssetID=40352">Lavender Baseball Cap</a></div>
							<div class="AssetCreator"><span class="Label">Creator:</span> <span class="Detail"><a id="ctl00_cphTRIAXX_rbxUserAssetsPane_UserAssetsDataList_ctl11_GameCreatorHyperLink" href="./User.aspx?ID=1">TRIAXX</a></span></div>
							
						    
						</div>
					</div></td><td></td><td></td><td></td>
			</tr>
		</tbody></table>
				
			</div>
			<div style="clear:both;"></div>
		</div>
	
	</div>
			</div>
		
</div>
	</div>
	

				</div>