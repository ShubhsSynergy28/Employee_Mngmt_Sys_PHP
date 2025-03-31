<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/reveal.js/4.3.1/reveal.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../../assets/Styles/Register.css">
</head>
<body>
    <?php 
    include '../../config/config.php';
    include '../../controllers/AuthController.php';
    include '../Components/Notification.php';
    

    $username = isset($_POST['reg_username']) ? htmlspecialchars($_POST['reg_username']) : '';
    $email = isset($_POST['reg_email']) ? htmlspecialchars($_POST['reg_email']) : '';
    ?>
    
    <div class="reg-wrapper">
        <h1 class="reveal">Employee Management System</h1>
        <div class="reg-container reveal">
            <h3><i class="fas fa-user-plus"></i> Register</h3>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="input-group">
                    <i class="fas fa-user input-icon"></i>
                    <input type="text" name="reg_username" placeholder="Username" value="<?php echo $username; ?>" required>
                </div>
                
                <div class="input-group">
                    <i class="fas fa-envelope input-icon"></i>
                    <input type="email" name="reg_email" placeholder="Email" value="<?php echo $email; ?>" required>
                </div>
                
                <div class="input-group">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" name="reg_password" id="reg_password" placeholder="Password" required>
                    <i class="fas fa-eye" id="togglePassword" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #777;"></i>
                </div>
                <div class="password-strength">
                    <div class="strength-meter" id="password-strength"></div>
                </div>
                
                <div class="input-group">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" name="reg_passwordConf" id="reg_passwordConf" placeholder="Confirm Password" required>
                    <i class="fas fa-eye" id="togglePasswordConf" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #777;"></i>
                </div>
                
                <button type="submit">Register <i class="fas fa-arrow-right"></i></button>
                <p>Already registered? <a href="login.php">Login <i class="fas fa-sign-in-alt"></i></a></p>
            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/reveal.js/4.3.1/reveal.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.4.2/zxcvbn.js"></script>
    <script src="../../assets/Scripts/Register.js">
      
    </script>
</body>
</html>