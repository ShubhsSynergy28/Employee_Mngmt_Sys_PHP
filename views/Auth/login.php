<?php
session_start();
if(isset($_SESSION['user_id'])) {
    header("Location: ../../views/Adminstrator/Dashboard.php");
    exit();
}
if (isset($_SESSION['notification'])) {
    $notification = $_SESSION['notification'];
    $notificationClass = $_SESSION['notificationClass'];
    unset($_SESSION['notification']);
    unset($_SESSION['notificationClass']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/reveal.js/4.3.1/reveal.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../../assets/Styles/login.css">
    <link rel="stylesheet" href="../../assets/Styles/Notification.css">
</head>
<body>
    <?php 
    include '../../config/config.php';
    include '../../controllers/AuthController.php';
    include '../Components/Notification.php';
    
    $email = isset($_POST['log_email']) ? htmlspecialchars($_POST['log_email']) : '';
    ?>
    
    <div class="login-wrapper">
        <h1 class="reveal">Employee Management System</h1>
        <div class="login-container reveal">
            <h3><i class="fas fa-sign-in-alt"></i> Login</h3>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <label for="log_email">Email</label>
                <input type="text" name="log_email" placeholder="Email" value="<?php echo $email; ?>" required>
                
                <label for="log_password">Password</label>
                <div style="position: relative;">
                    <input type="password" name="log_password" id="log_password" placeholder="Password" required>
                    <i class="fas fa-eye" id="togglePassword"></i>
                </div>
                
                <button type="submit">Login <i class="fas fa-arrow-right"></i></button>
                <p>New user? <a href="register.php">Register <i class="fas fa-user-plus"></i></a></p>
            </form>
        </div>
        <div class="login-footer reveal">
            <p>&copy; <?php echo date('Y'); ?> Employee Management System</p>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/reveal.js/4.3.1/reveal.min.js"></script>
    <script src="../../assets/Scripts/Login.js"></script>
    <script src="../../assets/Scripts/NotificationScript.js"></script>
</body>
</html>