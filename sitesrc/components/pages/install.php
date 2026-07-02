<?php
if (!isset($_SESSION['username'])) {
    die('Make an account before attempting to download.');
}
?>
<div id="Body">

					
    
    
    <p id="ctl00_cphRoblox_SystemRequirements1_OS" align="center" style="color: red">Currently, TRIAXX is only available on PCs running the Windows® operating system</p>

    <div style="margin-top: 12px; margin-bottom: 12px">
        <div id="AlreadyInstalled" style="display: none">
            <p>
                TRIAXX is already installed on this computer. If you want to try installing it again then follow the instructions below. Otherwise, you can just <a href="javascript:goBack()">continue</a>.</p>
        </div>
        <img id="ctl00_cphRoblox_Image3" class="Bullet" src="../assets/BuildIcon.png" border="0">
        <div id="InstallStep1" style="padding-left: 60px">
            <h2>
                Download TRIAXX</h2>
            <p>
                <button id="back" class="BigButton" onclick="location.replace('./download.php')">INSTALL TRIAXX</button>
                &nbsp;(Total download about 108Mb)</p>
            </div>
        <img id="ctl00_cphRoblox_Image4" class="Bullet" src="../assets/FriendsIcon.png" border="0">
        <div id="InstallStep2" style="padding-left: 60px">
            <h2>
                Run the Installer    A window will open asking what you want to do with a file called Setup.exe.
            <p></p>
            <p>
                Click 'Run'. You might see a confirmation message, asking if you're sure you want to run this software. Click 'Run' again.
            </p>
            <p>
                <img id="ctl00_cphRoblox_Image1" src="../assets/DownloadPrompt.PNG" border="0">
            </p>
        </h2></div>
        <img id="ctl00_cphRoblox_Image5" class="Bullet" src="../assets/BattleIcon.png" border="0">
        <div id="InstallStep3" style="padding-left: 60px">
            <h2>
                Follow the Setup Wizard</h2>
            <p>
                When the download has finished, the TRIAXX Setup Wizard will appear and guide you through the rest of the installation.
            </p>
            <p>
                <img id="ctl00_cphRoblox_Image2" src="../assets/Wizard.PNG" border="0">
            </p>
        </div>
    </div>

    <script>
        function isInstalled()
        {
		    try { 
			    var robloxClient = new ActiveXObject("RobloxInstall.Updater"); 
			    return true;
		    } catch (e) { 
		        return false;
		    } 
        }
        function goBack()
        {
 		    window.history.back();
        }
		function checkInstall() 
		{ 
			if (isInstalled()) { 
				// If we didn't fail, then we can move on
				document.getElementById("ctl00_cphRoblox_ButtonDownload").disabled = true;
				urchinTracker("InstallSuccess");
                Roblox.Install.Service.InstallSucceeded();
				goBack();
			} else { 
				// Try again later 
				window.setTimeout("checkInstall()", 2000); 
			} 
		} 
    </script>

    <script type="text/javascript">
		if (isInstalled())
		{
		    AlreadyInstalled.style.display="block";
		}
		else
		{
		    window.setTimeout("checkInstall()", 1000);
		}
    </script>


				</div>