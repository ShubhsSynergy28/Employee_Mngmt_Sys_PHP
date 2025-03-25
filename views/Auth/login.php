<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../../assets/Styles/Login.css">
</head>
<body>
    <?php 
    include '../../config/config.php';
    include '../../controllers/AuthController.php';
    include '../Components/Notification.php';
    
    // Initialize form values
    $email = isset($_POST['log_email']) ? htmlspecialchars($_POST['log_email']) : '';
    ?>
    <h1>Employee Management System</h1>
    <div class="login-container">
        <h3>Login</h3>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <label for="log_email">Email</label>
            <input type="text" name="log_email" placeholder="Email" value="<?php echo $email; ?>" required>
            <label for="log_password">Password</label>
            <input type="password" name="log_password" placeholder="Password" required>
            <button type="submit">Login</button>
            <p>New user? <a href="register.php">Register</a></p>
        </form>
    </div>
</body>
</html>