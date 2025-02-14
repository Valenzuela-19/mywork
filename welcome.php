<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    // If the user is not logged in, redirect them to the login page
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="navbar">
        <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
        <a href="logout.php">Logout</a>
    </div>
    <div class="container">
        <div class="sidebar">
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="messages.php">Messages</a></li>
                <li><a href="settings.php">Settings</a></li>
            </ul>
        </div>
        <div class="content">
            <h2>News Feed</h2>
            <div class="post">
                <h3>User 1</h3>
                <p>This is a sample post.</p>
            </div>
            <div class="post">
                <h3>User 2</h3>
                <p>This is another sample post.</p>
            </div>
        </div>
    </div>
</body>
</html>
