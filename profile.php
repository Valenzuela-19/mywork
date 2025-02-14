<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include('db.php'); // Include the database connection

$user_id = $_SESSION['user_id'];

// Fetch user information from the database
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(1, $user_id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
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
            <h2>Profile</h2>
            <p>Username: <?php echo htmlspecialchars($user['username']); ?></p>
            <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
            <p><img src="<?php echo htmlspecialchars($user['photo']); ?>" alt="Profile Photo" width="100"></p>
        </div>
    </div>
</body>
</html>