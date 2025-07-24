<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'BBB - Paper System' ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/21127659_BuiNgocKieuNhi/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<div class="container">
    <header class="nav-container">
        <div class="nav-left">
            <img src="/21127659_BuiNgocKieuNhi/assets/images/smile-2_removebg.png" alt="Smile.png" class="nav-header__logo">
            <h1 class="nav-header__name">BBB</h1>
        </div>
        <div class="nav-items">
            <a class="nav-item" href="index.php">Homepage</a>
            <a class="nav-item" href="index.php?action=list-papers">Papers</a>
            <a class="nav-item" href="index.php?action=search-form">Search</a>
        </div>
        <div class="nav-right">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="index.php?action=add-paper" class="btn-primary">Add new paper</a>
                <div class="user-dropdown">
                    <div class="user-info">
                        <div class="avatar-circle"></div>
                        <span class="username"><?= $_SESSION['username'] ?? 'User' ?></span>
                    </div>
                    <div class="dropdown-user">
                        <a href="index.php?action=profile">Profile</a>
                        <a href="index.php?action=logout">Logout</a>
                    </div>
                </div>
            <?php else: ?>
                <a href="index.php?action=login" class="btn-primary">Login</a>
            <?php endif; ?>

        </div>
    </header>