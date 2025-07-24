<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - BBB</title>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/21127659_BuiNgocKieuNhi/assets/css/style.css">
</head>
<body class="login-body">

    <div class="login-container">
        <div class="logo-box">
            <img src="/21127659_BuiNgocKieuNhi/assets/images/smile-2_removebg.png" alt="logo">
            <h1>BBB</h1>
        </div>

    <form class="login-form" method="post" action="index.php?action=login">
        <label class="login-field" for="username">Username</label>
        <input class="input-field" type="text" id="username" name="username" placeholder="Please enter your username" required>

        <label class="login-field" for="password">Password</label>
        <input class="input-field" type="password" id="password" name="password" placeholder="Please enter your password" required>

        <div class="login-buttons">
            <button type="button" class="btn-outline">Register</button>
            <button type="submit" class="btn-primary">Login</button>
        </div>
    </form>
    </div>

</body>
</html>
