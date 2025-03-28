<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../assets/Styles/Header.css">
</head>
<body>
    <header>
        <div class="container">
            <a class="link-to=home-in-logo" href="http://localhost/Projects/Employee%20Management%20System/views/Adminstrator/Dashboard.php">
                <div class="logo">
                    <h1><i class="fas fa-users-cog"></i> Employee Management System</h1>
                </div>
            </a>
            <nav>
                <ul>
                    <!-- <li><a href="../../index.php"><i class="fas fa-home"></i> Home</a></li>
                    <li><a href="../../views/Employees/index.php"><i class="fas fa-users"></i> Employees</a></li> -->
                    <li>
                    <form action="../../controllers/AuthController.php" method="post">
        <input type="hidden" name="action" value="logout">
        <button type="submit" class="logout-btn">
            <i class="fas fa-sign-out-alt"></i> Logout
        </button>
    </form>
</li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- <script src="../../assets/Scripts/LogoutScript.js"></script> -->
</body>
</html>