<?php
session_start();
if (isset($_SESSION['user_id'])) {
    // If the user is already logged in, redirect them to the welcome page
    header('Location: welcome.php');
    exit;
}

include('db.php'); // Include the database connection
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="navbar">
        <h1>Welcome to Our Website</h1>
    </div>
    <div class="container">
        <div class="content">
            <h2>Login</h2>
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $email = $_POST['email'];
                $password = $_POST['password'];

                // Prepare a select statement to check if the user exists
                $sql = "SELECT * FROM users WHERE email = ?";

                if ($stmt = $pdo->prepare($sql)) {
                    // Bind variables
                    $stmt->bindParam(1, $email);

                    // Execute the query
                    if ($stmt->execute()) {
                        if ($stmt->rowCount() == 1) {
                            $user = $stmt->fetch(PDO::FETCH_ASSOC);
                            
                            // Verify the password
                            if (password_verify($password, $user['password'])) {
                                // Password is correct, create session and redirect
                                $_SESSION['user_id'] = $user['id'];
                                $_SESSION['username'] = $user['username'];
                                header('Location: welcome.php');
                                exit;
                            } else {
                                echo "<p class='error'>Incorrect password!</p>";
                            }
                        } else {
                            echo "<p class='error'>No user found with that email.</p>";
                        }
                    } else {
                        echo "<p class='error'>Something went wrong. Please try again later.</p>";
                    }
                }
            }
            ?>
            <form method="POST" action="login.php">
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
            <p>Don't have an account? <a href="register.php">Sign Up</a></p>
        </div>
    </div>
</body>
</html>
