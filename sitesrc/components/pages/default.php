<div id="Body">
					
	<div id="SplashContainer">
		<div id="SignInPane">
			

<div id="LoginViewContainer">
	
<?php
if ($_SESSION == null) {
echo '
<div id="LoginView">
    <h5>Member Login</h5>

    <form action="./api/login.aspx" method="POST">
        <div class="AspNet-Login">

            <div class="AspNet-Login-UserPanel">
                <label for="username" class="Label">
                    Character Name
                </label>

                <input
                    type="text"
                    id="username"
                    name="username"
                    tabindex="1"
                    class="Text"
                    required
                >
            </div>

            <div class="AspNet-Login-PasswordPanel">
                <label for="password" class="Label">
                    Password
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    tabindex="2"
                    class="Text"
                    required
                >
            </div>

            <div class="AspNet-Login-SubmitPanel">
                <button
                    type="submit"
                    tabindex="4"
                    class="Button"
                >
                    Login
                </button>
            </div>

            <div class="AspNet-Login-PasswordRecoveryPanel">
                <a href="Login/ResetPasswordRequest.aspx">
                    Forgot your password?
                </a>
            </div>

        </div>
    </form>
</div>
';
} else {
echo '
<div id="LoginView">
<h5>Logged in</h5>
				
<div class="AspNet-Login">
						<div class="AspNet-Login">
							 <img src="./Thumbs/Avatar.aspx?ID=' . $_SESSION['userid'] . '" width=100% height=100%>
						</div>
					
</div>
</div>
';
}
?>
		
</div>

			<br>
            
                    <div id="ctl00_cphRoblox_LoginView1_pFigure">
	
				        <div id="Figure"><a id="ctl00_cphRoblox_LoginView1_ImageFigure" disabled="disabled" title="Figure" onclick="return false" style="display:inline-block;"><img src="./assets/NewFrontPageGuy.png" border="0" alt="Figure" blankurl="http://t1.roblox.com:80/blank-115x130.gif"></a></div>
			        
</div>  
			    
		</div>
		<div id="RobloxAtAGlance">
			<h2>TRIAXX Virtual Playworld</h2>
			<small>Its pronounced: try-aks</small>
			<h3>TRIAXX is Free!</h3>
			<ul id="ThingsToDo">
				<li id="Point1">
					<h3>Build your personal Place</h3>
					<div>Create buildings, vehicles, scenery, and traps with thousands of virtual bricks.</div>
				</li>
				<li id="Point2">
					<h3>Meet new friends online</h3>
					<div>Visit your friend's place, chat in 3D, and build together.</div>
				</li>
				<li id="Point3">
					<h3>Battle in the Brick Arenas</h3>
					<div>Play with the slingshot, rocket, or other brick battle tools.  Be careful not to get "bloxxed".</div>
				</li>
			</ul>
			<div id="Showcase" onload="MM_CheckFlashVersion('8,0,0,0','Content on this page requires a newer version of Macromedia Flash Player. Do you want to download it now?');">
                <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="https://web.archive.org/web/20080430222116oe_/http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="400" height="326" align="middle">
					<div style="left: 0; width: 400x; height: 0; position: relative; padding-bottom: 75%;"><iframe src="https://www.youtube.com/embed/VqB1uoDTdKM?rel=0" style="top: 0; left: 0; width: 100%; height: 100%; position: absolute; border: 0;" allowfullscreen scrolling="no" allow="accelerometer *; clipboard-write *; encrypted-media *; gyroscope *; picture-in-picture *; web-share *;" referrerpolicy="strict-origin"></iframe></div>
				</object>			
            </div>
			<div id="Install">
				<div id="CompatibilityNote"><div id="ctl00_cphRoblox_pCompatibilityNote">
	Works with your<br>Windows PC!
</div></div>
				<div id="DownloadAndPlay"><a id="ctl00_cphRoblox_hlDownloadAndPlay" href="<?php if (isset($_SESSION['username'])) { echo '/Install/Default.aspx'; } else { echo '/Login/New.aspx'; } ?>"><img src="assets/DownloadAndPlay.png" alt="FREE - Download and Play!" border="0"></a></div>
			</div>
			<div id="ctl00_cphRoblox_pForParents">
	
				<div id="ForParents">
					<a id="ctl00_cphRoblox_hlKidSafe" title="TRIAXX is rabbid-safe!" href="Parents.aspx" style="display:inline-block;"><img title="TRIAXX is rabbid-safe!" src="assets/RabbidSafe.png" border="0"></a>
				</div>
			
</div>
		</div>
		<div id="UserPlacesPane">
			<div id="UserPlaces_Content">
				<table id="ctl00_cphRoblox_CoolPlacesDataList" cellspacing="0" border="0" width="100%">
	<tbody><tr>
		<td class="UserPlace">
						<a id="ctl00_cphRoblox_CoolPlacesDataList_ctl00_rbxContentImage" title="Game" href="/web/20080430222116/http://www.roblox.com/Item.aspx?ID=501247" style="display:inline-block;cursor:pointer;"><img src="https://web.archive.org/web/20080430222116im_/http://t1.roblox.com:80/fd1bc161532cc153c48b8ee573f11f7b" border="0" alt="Can You Survive...... A Plane Crash!?!?!?" blankurl="http://t2.roblox.com:80/blank-120x70.gif"></a>
					</td><td class="UserPlace">
						<a id="ctl00_cphRoblox_CoolPlacesDataList_ctl01_rbxContentImage" title="Waterfall" href="/web/20080430222116/http://www.roblox.com/Item.aspx?ID=364754" style="display:inline-block;cursor:pointer;"><img src="https://web.archive.org/web/20080430222116im_/http://t1.roblox.com:80/d2500f8dbea5a7bfa746e4d4f1ad9181" border="0" alt="Waterfall" blankurl="http://t2.roblox.com:80/blank-120x70.gif"></a>
					</td><td class="UserPlace">
						<a id="ctl00_cphRoblox_CoolPlacesDataList_ctl02_rbxContentImage" title="Zombie Mega Horde, use the RAH66 and UH60" href="/web/20080430222116/http://www.roblox.com/Item.aspx?ID=152793" style="display:inline-block;cursor:pointer;"><img src="https://web.archive.org/web/20080430222116im_/http://t3.roblox.com:80/fa60a035c40d8675083330b227bd3e03" border="0" alt="Zombie Mega Horde, use the RAH66 and UH60" blankurl="http://t2.roblox.com:80/blank-120x70.gif"></a>
					</td><td class="UserPlace">
						<a id="ctl00_cphRoblox_CoolPlacesDataList_ctl03_rbxContentImage" title="roblox tutoial for beginners! (under construction)" href="/web/20080430222116/http://www.roblox.com/Item.aspx?ID=288365" style="display:inline-block;cursor:pointer;"><img src="https://web.archive.org/web/20080430222116im_/http://t1.roblox.com:80/00292e163b842fc634041223392c2e6b" border="0" alt="roblox tutoial for beginners! (under construction)" blankurl="http://t2.roblox.com:80/blank-120x70.gif"></a>
					</td><td class="UserPlace">
						<a id="ctl00_cphRoblox_CoolPlacesDataList_ctl04_rbxContentImage" title="Sword Fight on the Heights III" href="/web/20080430222116/http://www.roblox.com/Item.aspx?ID=47324" style="display:inline-block;cursor:pointer;"><img src="https://web.archive.org/web/20080430222116im_/http://t4.roblox.com:80/b2d74abc58baba0ffa09d1103ea0a6a4" border="0" alt="Sword Fight on the Heights III" blankurl="http://t2.roblox.com:80/blank-120x70.gif"></a>
					</td>
	</tr>
</tbody></table>
			</div>
			<div id="UserPlaces_Header">
				<h3>Cool Places</h3>
				<p>Check out some of our favorite TRIAXX places!</p>
			</div>
			<div id="ctl00_cphRoblox_ie6_peekaboo" style="clear: both"></div>
		</div>
	</div>

				</div>
