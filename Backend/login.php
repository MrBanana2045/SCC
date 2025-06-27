<html>
    <head>
        <title>Login - SCC</title>
        <meta charset="UTF-8" />
<meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <link rel="stylesheet" href="/style/login.css">
    </head>
    <body>
    <form method="POST" action="loginback.php" id="loginForm">
    <h1 style="text-align:center;">LOGIN - SCC</h1>
    <label>Username</label><br>
    <input type="text" name="user" pattern="^[a-zA-Z]+$" required><br>
    <label>Password</label><br>
    <input type="password" name="pass" required><br>
    <a id="forg" style="text-decoration:none; color:#d4d4b5;">Forgot password</a><br>
    <input type="submit" value="login" style="margin-right: 10px; margin-top:10px;"><button type="button" id="showRegister" style="background:none; border:3px solid #214b42;">Register</button>
</form>

<form method="POST" action="regback.php" id="registerForm" style="display: none;">
    <h1 style="text-align:center;">Register - SCC</h1>
    <label>Username</label><br>
    <input type="text" name="user" pattern="^[a-zA-Z]+$" required><br>
    <label>Email</label><br>
    <input type="text" name="email" pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" required><br>
    <label>Password</label><br>
    <input type="password" name="pass" required><br>
    <input type="submit" value="Register" style="width:300px;">
</form>
<form method="POST" action="forg.php" id="forgForm" style="display: none;">
<h3 style="margin-top:-57px;"><a href="/login.php" style="text-decoration:none; color:#e4ecea;"><- Back</a></h3>
    <h1 style="text-align:center; margin-top:40px;">Recovery - SCC</h1>
    <label>Email</label><br>
    <input type="text" name="email" pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" required><br>
    <label>New Password</label><br>
    <input type="password" name="pass" required><br>
    <input type="submit" value="Save" style="width:300px;">
</form>

<script>
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    const forgForm = document.getElementById('forgForm');
    const showRegisterBtn = document.getElementById('showRegister');
    const forg = document.getElementById('forg');

    showRegisterBtn.addEventListener('click', () => {
        loginForm.style.display = 'none';
        registerForm.style.display = 'block';
    });
    forg.addEventListener('click', () => {
        loginForm.style.display = 'none';
        registerForm.style.display = 'none';
        forgForm.style.display = 'block';
    });
</script>
    </body>
</html
