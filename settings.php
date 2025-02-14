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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : $user['password'];
    $photo = $_FILES['photo']['name'];

    // Handle photo upload
    if (!empty($photo)) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($photo);
        move_uploaded_file($_FILES['photo']['tmp_name'], $target_file);
    } else {
        $target_file = $user['photo'];
    }

    // Prepare an update statement
    $sql = "UPDATE users SET username = ?, email = ?, password = ?, photo = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(1, $username);
    $stmt->bindParam(2, $email);
    $stmt->bindParam(3, $password);
    $stmt->bindParam(4, $target_file);
    $stmt->bindParam(5, $user_id);

    // Execute the query
    if ($stmt->execute()) {
        echo "Profile updated successfully!";
        header('Location: settings.php');
        exit;
    } else {
        echo "Something went wrong. Please try again later.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
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
            <h2>Settings</h2>
            <form method="POST" action="settings.php" enctype="multipart/form-data">
                <label for="username">Username:</label>
                <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                
                <label for="email">Email:</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                
                <label for="password">Password (leave blank to keep current password):</label>
                <input type="password" name="password">
                
                <label for="photo">Profile Photo:</label>
                <input type="file" name="photo">
                
                <button type="submit">Update Profile</button>
            </form>
        </div>
    </div>
</body>
</html>