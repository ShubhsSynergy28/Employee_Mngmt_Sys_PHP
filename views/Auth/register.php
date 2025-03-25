<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../../assets/Styles/Register.css">
</head>
<body>
    <?php 
    include '../../config/config.php';
    include '../../controllers/AuthController.php';
    include '../Components/Notification.php';
    
    // Initialize form values
    $username = isset($_POST['reg_username']) ? htmlspecialchars($_POST['reg_username']) : '';
    $email = isset($_POST['reg_email']) ? htmlspecialchars($_POST['reg_email']) : '';
    ?>
    <h1>Employee Management System</h1>
    <div class="reg-container">
        <h3>Register</h3>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="text" name="reg_username" placeholder="Username" value="<?php echo $username; ?>">
            <input type="email" name="reg_email" placeholder="Email" value="<?php echo $email; ?>">
            <input type="password" name="reg_password" placeholder="Password">
            <input type="password" name="reg_passwordConf" placeholder="Confirm Password">
            <button type="submit">Register</button>
            <p>
                Already registered? <a href="login.php">Login</a>
            </p>
        </form>
    </div>
</body>
</html>