<?php 
// include '../config/config.php';

class AuthController {
    
    public function register(){
        function containsNumbers($string) {
            return preg_match('/[0-9]/', $string);
        }
        session_start();
        global $notification, $notificationClass, $conn;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = ucfirst(strtolower(trim($_POST['reg_username'])));
            $email = trim($_POST['reg_email']);
            $password = trim($_POST['reg_password']);
            $passwordConf = trim($_POST['reg_passwordConf']);

            //CHECK IF FIELDS ARE EMPTY
            if(empty($username) || empty($email) || empty($password) || empty($passwordConf)) {
                $notification = "All fields are required";
                $notificationClass = "error";
                return;
            }

            if(containsNumbers($username)) {
                $notification = "Username should not contain numbers";
                $notificationClass = "error";
                return;
            }
            // Validate email
            elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $notification = "Invalid email format";
                $notificationClass = "error";
                return;
            }

            // Validate password
            $passwordPattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";
            if (!preg_match($passwordPattern, $password)) {
                $notification = "Password must be at least 8 characters long, contain at least one uppercase letter, one lowercase letter, one number, and one special character";
                $notificationClass = "error";
                return;
            }

            if ($password == $passwordConf) {
                // Check for duplicate email
                $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt->store_result();

                if ($stmt->num_rows > 0) {
                    $notification = "Email already registered";
                    $notificationClass = "error";
                    $stmt->close();
                    return;
                }
                $stmt->close();

                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashedPassword')";
                if ($conn->query($sql) === TRUE) {
                    $_SESSION['notification'] = "User $username registered successfully";
                    $_SESSION['notificationClass'] = "success";
                    echo "<script>setTimeout(() => { window.location = 'login.php' }, 1000)</script>";
                    // header("Location: login.php?success=1");
                    exit();
                } else {
                    $notification = "Error: " . $sql . "<br>" . $conn->error;
                    $notificationClass = "error";
                }
            } else {
                $notification = "Passwords do not match";
                $notificationClass = "error";
            }
        }
    }

    public function login() {
        global $notification, $notificationClass, $conn;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST['log_email'];
            $password = $_POST['log_password'];

            $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($id, $username, $hashedPassword);
                $stmt->fetch();

                if (password_verify($password, $hashedPassword)) {
                    $_SESSION['user_id'] = $id;
                    $_SESSION['username'] = $username;
                    $_SESSION['notification'] = "Welcome $username!";
                    $_SESSION['notificationClass'] = "success";
                    // Redirect to avoid resubmission
                    echo "<script>setTimeout(() => { window.location = '../Adminstrator/dashboard.php' }, 1000)</script>";
                    exit();
                } else {
                    $notification = "Invalid password!";
                    $notificationClass = "error";
                }
            } else {
                $notification = "No user found with that email!";
                $notificationClass = "error";
            }

            $stmt->close();
        }
    }

    function Logout(){
        session_start();
        session_unset();
        session_destroy();
        header("Location: ../views/Auth/login.php");
    }
    
}

$authController = new AuthController();
if (isset($_GET['action']) || isset($_POST['action'])) {
    $action = $_GET['action'] ?? $_POST['action'];
    
    switch ($action) {
        case 'logout':
            $authController->logout();
            break;
    }
} 
elseif (strpos($_SERVER['REQUEST_URI'], 'register.php') !== false) {
    $authController->register();
} elseif (strpos($_SERVER['REQUEST_URI'], 'login.php') !== false) {
    $authController->login();
}

?>