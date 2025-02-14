<?php
session_start();
if (isset($_SESSION['user_id'])) {
    // If the user is already logged in, redirect them to the welcome page
    header('Location: welcome.php');
    exit;
}

include('db.php'); // Include the database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Prepare an insert statement
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";

    if ($stmt = $pdo->prepare($sql)) {
        // Bind variables
        $stmt->bindParam(1, $username);
        $stmt->bindParam(2, $email);
        $stmt->bindParam(3, $password);

        // Execute the query
        if ($stmt->execute()) {
            echo "<p class='success'>Registration successful!</p>";
            header('Location: login.php');
            exit;
        } else {
            echo "<p class='error'>Something went wrong. Please try again later.</p>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="navbar">
        <h1>Welcome to Our Website</h1>
    </div>
    <div class="container">
        <div class="content">
            <h2>Register</h2>
            <form method="POST" action="register.php">
                <input type="text" name="username" placeholder="Username" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Register</button>
            </form>
            <p>Already have an account? <a href="login.php">Login</a></p>
        </div>
    </div>
</body>
</html>
