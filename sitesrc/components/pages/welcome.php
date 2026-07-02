<style>
body {
  margin: 0;
  min-height: 100vh;
  overflow: hidden;
  position: relative;
}

body::before {
  content: "";
  position: fixed;

  width: 250vmax;
  height: 250vmax;

  left: 50%;
  top: 50%;
  transform-origin: center;
  
background: linear-gradient(
  45deg,
  darkred,
  goldenrod,
  darkgreen,
  darkblue,
  darkcyan,
  darkmagenta,
  darkred
);

  animation:
    spin 20s linear infinite,
    hueShift 5s linear infinite;

  z-index: -1;
}

@keyframes spin {
  from {
    transform: translate(-50%, -50%) rotate(0deg);
  }
  to {
    transform: translate(-50%, -50%) rotate(360deg);
  }
}

@keyframes hueShift {
  from { filter: hue-rotate(0deg); }
  to   { filter: hue-rotate(360deg); }
}
</style>
<form method="POST" action="./api/login.aspx"
      style="min-height:100vh; display:flex; justify-content:center; align-items:center; margin:0;">

    <div id="Body">
		<center>
		<img src="/assets/TriaxxBanner.png" width="270px" height="70px">
            <div id="PaneLogin">
                <h3>Welcome back!</h3>

                <div class="AspNet-Login">

                    <div class="AspNet-Login-UserPanel">
                        <label for="username"><em>U</em>ser Name:</label>
                        <input type="text" id="username" name="username" required/>
                    </div>

                    <div class="AspNet-Login-PasswordPanel">
                        <label for="password"><em>P</em>assword:</label>
                        <input type="password" id="password" name="password" required/>
                    </div>
					
                    <div class="AspNet-Login-SubmitPanel">
						<input type="button" value="Sign up" onclick="window.location.replace('/Login/New.aspx')" />
                        <input type="submit" value="Log In" id="login" name="login" />
                    </div>

                    <div class="AspNet-Login-PasswordRecoveryPanel">
                        <a href="ResetPasswordRequest.aspx">Forgot your password?</a>
                    </div>

					<br>
					<h1>Build, Create and more!</h1>
          <br>
          <h2>
          <a href="https://discord.gg/tuHDbhn3JY">Discord invite!</a>
          </h2>
                </div>
            </div>
		</center>
    </div>
</form>