<div id="loginPopup" class="popup" >
  <div class="popup-content">
    <button class="close">&times;</button>
    <h2>Login</h2>
    <form id="loginForm" method="POST" action="../../controller/UserController.php">
      <div class="input">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required />
        <div class="spin"></div>
      </div>
      <div class="input">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required />
        <div class="spin"></div>
      </div>
      <button type="submit" class="button">Login</button>
    </form>
    <p>Don't have an account? <a id="signupLink" href="#">Sign up</a></p>
  </div>
</div>