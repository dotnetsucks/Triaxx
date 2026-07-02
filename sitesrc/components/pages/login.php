<form method="POST" action="../api/login.aspx">

<div id="Body">
					
	<script type="text/javascript">
		function signUp()
		{
			window.location = "/Login/New.aspx";
		}
	</script>

	<div id="FrameLogin" style="margin: 150px auto 150px auto; width: 500px; border: black thin solid; padding: 22px;">
		
		<div id="PaneNewUser">
			<h3>New User?</h3>
			<p>You need an account to play TRIAXX.</p>
			<p>If you aren't a TRIAXX member then <a id="ctl00_cphRoblox_HyperLink1" href="./New.aspx">register</a>. It's easy and we do <em>not</em> share your personal information with anybody.</p>
		</div>

		<div id="PaneLogin">
			<h3>Log In</h3>
			
			<div class="AspNet-Login">

				<div class="AspNet-Login-UserPanel">
					<label for="username" class="TextboxLabel"><em>U</em>ser Name:</label>

					<input 
						type="text" 
						id="username" 
						name="username" 
						value="" 
						accesskey="u"
					/>&nbsp;
				</div>

				<div class="AspNet-Login-PasswordPanel">
					<label for="password" class="TextboxLabel"><em>P</em>assword:</label>

					<input 
						type="password" 
						id="password" 
						name="password" 
						value="" 
						accesskey="p"
					/>&nbsp;
				</div>

				<div class="AspNet-Login-SubmitPanel">
					<input 
						type="submit" 
						value="Log In" 
						id="login" 
						name="login"
					/>
				</div>

				<div class="AspNet-Login-PasswordRecoveryPanel">
					<a href="ResetPasswordRequest.aspx" title="Password recovery">Forgot your password?</a>
				</div>

			</div>
		</div>
	</div>

</div>

</form>