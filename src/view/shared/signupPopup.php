<form id="signupForm" method="POST" action="../../controller/UserController.php">
    <div class="input">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required />
        <div class="spin"></div>
    </div>
    <div class="input">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required />
        <div class="spin"></div>
    </div>
    <div class="input">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required />
        <div class="spin"></div>
    </div>
    <button type="submit" class="button">Sign Up</button>
</form>