<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include('db.php'); // Include the database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post_content = $_POST['post_content'];
    $user_id = $_SESSION['user_id'];

    // Prepare an insert statement
    $sql = "INSERT INTO posts (user_id, content) VALUES (?, ?)";

    if ($stmt = $pdo->prepare($sql)) {
        // Bind variables
        $stmt->bindParam(1, $user_id);
        $stmt->bindParam(2, $post_content);

        // Execute the query
        if ($stmt->execute()) {
            echo "<p class='success'>Post submitted successfully!</p>";
        } else {
            echo "<p class='error'>Something went wrong. Please try again later.</p>";
        }
    }
}

// Fetch posts from the database
$sql = "SELECT posts.content, users.username FROM posts JOIN users ON posts.user_id = users.id ORDER BY posts.created_at DESC";
$posts = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
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
            <h2>Home</h2>
            <form method="POST" action="home.php">
                <textarea name="post_content" placeholder="What's on your mind?" required></textarea>
                <button type="submit">Post</button>
            </form>
            <h2>News Feed</h2>
            <?php foreach ($posts as $post): ?>
                <div class="post">
                    <h3><?php echo htmlspecialchars($post['username']); ?></h3>
                    <p><?php echo htmlspecialchars($post['content']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>