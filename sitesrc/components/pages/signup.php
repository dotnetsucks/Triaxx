<form method="POST" action="../api/signup.aspx">

<div id="Body">
		<div id="Registration">
			<div id="ctl00_cphRoblox_upAccountRegistration">
	
					<h2>Sign Up and Play</h2>
					<h3>Step 1 of 2: Create Account</h3>
					<div id="EnterAgeGroup">
						<fieldset title="Provide your age-group">
							<legend>Provide your age-group</legend>
							<div class="Suggestion">
								This will help us to customize your experience.  Users under 13 years will only be shown pre-approved images.
							</div>
							<div class="AgeGroupRow">
								<span id="ctl00_cphRoblox_rblAgeGroup"><input id="ctl00_cphRoblox_rblAgeGroup_0" type="radio" name="ctl00$cphRoblox$rblAgeGroup" value="1" checked="checked" tabindex="5"><label for="ctl00_cphRoblox_rblAgeGroup_0">Under 13 years</label><br><input id="ctl00_cphRoblox_rblAgeGroup_1" type="radio" name="ctl00$cphRoblox$rblAgeGroup" value="2" onclick="javascript:setTimeout(&#39;__doPostBack(\&#39;ctl00$cphRoblox$rblAgeGroup$1\&#39;,\&#39;\&#39;)&#39;, 0)" tabindex="5"><label for="ctl00_cphRoblox_rblAgeGroup_1">13 years or older</label></span>
							</div>
						</fieldset>
					</div>
					<div id="EnterUsername">
						<fieldset title="Choose a name for your TRIAXX character">
							<legend>Choose a name for your TRIAXX character</legend>
							<div class="Suggestion">
								Use 3-20 alphanumeric characters: A-Z, a-z, 0-9, no spaces
							</div>
							<div class="Validators">
								<div></div>
								<div></div>
								<div></div>
								<div></div>
								<div></div>
							</div>
							<div class="UsernameRow">
								<label for="ctl00_cphRoblox_UserName" id="ctl00_cphRoblox_UserNameLabel" class="Label">Character Name:</label>&nbsp;<input name="username" type="text" id="ctl00_cphRoblox_UserName" tabindex="1" class="TextBox">
							</div>
						</fieldset>
					</div>
					<div id="EnterPassword">
						<fieldset title="Choose your TRIAXX password">
							<legend>Choose your TRIAXX password</legend>
							<div class="Suggestion">
								4-10 characters, no spaces
							</div>
							<div class="Validators">
								<div></div>
								<div></div>
								<div></div>
								<div></div>
							</div>
							<div class="PasswordRow">
								<label for="ctl00_cphRoblox_Password" id="ctl00_cphRoblox_LabelPassword" class="Label">Password:</label>&nbsp;<input name="password" type="password" id="ctl00_cphRoblox_Password" tabindex="2" class="TextBox">
							</div>
							<div class="ConfirmPasswordRow">
								<label for="ctl00_cphRoblox_TextBoxPasswordConfirm" id="ctl00_cphRoblox_LabelPasswordConfirm" class="Label">Confirm Password:</label>&nbsp;<input name="confirm_password" type="password" id="ctl00_cphRoblox_TextBoxPasswordConfirm" tabindex="3" class="TextBox">
							</div>
						</fieldset>
					</div>
					<div id="EnterChatMode">
						<fieldset title="Choose your chat mode">
							<legend>Choose your chat mode</legend>
							<div class="Suggestion">
								All in-game chat is subject to profanity filtering and moderation.  For enhanced chat safety, choose SuperSafe Chat; only chat from pre-approved menus will be shown to you.
							</div>
							<div class="ChatModeRow">
								<span id="ctl00_cphRoblox_rblChatMode"><input id="ctl00_cphRoblox_rblChatMode_0" type="radio" name="ctl00$cphRoblox$rblChatMode" value="false" checked="checked" tabindex="6"><label for="ctl00_cphRoblox_rblChatMode_0">Safe Chat</label><br><input id="ctl00_cphRoblox_rblChatMode_1" type="radio" name="ctl00$cphRoblox$rblChatMode" value="true" tabindex="6"><label for="ctl00_cphRoblox_rblChatMode_1">SuperSafe Chat</label></span>
							</div>
						</fieldset>
					</div>
					<div id="EnterEmail">
						<fieldset title="Provide your parent&#39;s email address">
							<legend>Provide your parent's email address</legend>
							<div class="Suggestion">
								This will allow you to recover a lost password
							</div>

							<div class="Validators">
								<div></div>
								<div></div>
								<div></div>
							</div>
							<div class="EmailRow">
								<label for="ctl00_cphRoblox_TextBoxEMail" id="ctl00_cphRoblox_LabelEmail" class="Label">Your Parent's Email:</label>&nbsp;<input name="ctl00$cphRoblox$TextBoxEMail" type="text" id="ctl00_cphRoblox_TextBoxEMail" tabindex="4" class="TextBox">
							</div>
						</fieldset>
					</div>

						<div id="EnterEmail">
						<fieldset title="Enter your invite key">
							<legend>Enter your invite key</legend>
							<div class="Suggestion">
								<a href="https://discord.gg/tuHDbhn3JY" target="_blank">Join our Discord server for an invite key.</a>
							</div>

							<div class="Validators">
								<div></div>
								<div></div>
								<div></div>
							</div>
							<div class="EmailRow">
								<label for="invitekey" id="ctl00_cphRoblox_LabelEmail" class="Label">Your Invite key:</label>&nbsp;<input name="invitekey" type="text" id="invitekey" tabindex="4" class="TextBox">
							</div>
						</fieldset>
					</div>
					<div class="Confirm">
    				<input type="submit" name="create" value="Register" id="create" tabindex="5" class="BigButton">
					</div>
				
</div>
		</div>
		<div id="Sidebars">
			<div id="AlreadyRegistered">
				<h3>Already Registered?</h3>
				<p>If you just need to login, go to the <a id="ctl00_cphRoblox_HyperLinkLogin" href="./Default.aspx">Login</a> page.</p>
				<p>If you have already registered but you still need to download the game installer, go directly to <a id="ctl00_cphRoblox_HyperLinkDownload" href="../Install/Default.aspx">download</a>.</p>
			</div>
			<div id="TermsAndConditions">
				<h3>Terms &amp; Conditions</h3>
				<p>Registration does not provide any guarantees of service. See our <a id="ctl00_cphRoblox_HyperLinkToS" href="https://web.archive.org/web/20070804083927/http://roblox.com/Info/TermsOfService.aspx?layout=null" target="_blank">Terms of Service</a> and <a id="ctl00_cphRoblox_HyperLinkEULA" href="https://web.archive.org/web/20070804083927/http://roblox.com/Info/EULA.htm" target="_blank">Licensing Agreement</a> for details.</p>
				<p>ROBLOX will not share your email address with 3rd parties. See our <a id="ctl00_cphRoblox_HyperLinkPrivacy" href="https://web.archive.org/web/20070804083927/http://roblox.com/Info/Privacy.aspx?layout=null" target="_blank">Privacy Policy</a> for details.</p>
			</div>
		</div>
		<div id="ctl00_cphRoblox_ie6_peekaboo" style="clear: both"></div>

</div>

</form>