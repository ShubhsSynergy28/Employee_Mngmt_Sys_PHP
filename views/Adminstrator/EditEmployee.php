<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../views/Auth/login.php");
    exit();
}

include '../../config/config.php';
include '../../controllers/EmployeeController.php';
include '../Components/Notification.php';

// Initialize variables
$employee = null;
$firstname = $lastname = $phone = $birthdate = $gender = $description = $file_path = '';
$educations = $hobbies = [];

// Fetch employee data if ID is provided
if (isset($_GET['id'])) {
    $employeeId = (int)$_GET['id'];
    $employeeController = new EmployeeController();
    $employee = $employeeController->ViewEmployeeDetails($employeeId);
    
    if ($employee) {
        // Split full name into first and last names
        $nameParts = explode(' ', $employee['EName'], 2);
        $firstname = $nameParts[0] ?? '';
        $lastname = $nameParts[1] ?? '';
        
        $phone = $employee['Ephone'];
        $birthdate = $employee['Ebirth_date'];
        $gender = $employee['Egender'];
        $description = $employee['Edescription'];
        $file_path = $employee['Efile_path'];
        
        // Fetch employee's education and hobbies
        $educations = $employeeController->getEmployeeEducations($employeeId);
        $hobbies = $employeeController->getEmployeeHobbies($employeeId);
    } else {
        $_SESSION['notification'] = "Employee not found";
        $_SESSION['notificationClass'] = "error";
        header("Location: Dashboard.php");
        exit();
    }
} else {
    header("Location: Dashboard.php");
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_employee'])) {
    $result = $employeeController->UpdateEmployee($employeeId);
    
    if ($result) {
        $_SESSION['notification'] = "Employee updated successfully";
        $_SESSION['notificationClass'] = "success";
        header("Location: ViewEmployee.php?id=" . $employeeId);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee</title>
    <link rel="stylesheet" href="../../assets/Styles/AddEmp.css">
    <link rel="stylesheet" href="../../assets/Styles/EditEmp.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <h1>Edit Employee</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $employeeId; ?>" method="POST" enctype="multipart/form-data">
        <label for="firstname">First Name:</label>
        <input type="text" id="firstname" name="firstname" value="<?= htmlspecialchars($firstname) ?>" required>

        <label for="lastname">Last Name:</label>
        <input type="text" id="lastname" name="lastname" value="<?= htmlspecialchars($lastname) ?>" required>

        <label for="phone">Phone Number:</label>
        <input type="tel" id="phone" name="phone" value="<?= htmlspecialchars($phone) ?>" required>

        <label>Education:</label>
        <div class="checkbox-group">
            <?php
            // Fetch education levels from database
            include '../../utils/FetchEdu.php';
            
            // Mark checked educations
            echo '<script>document.addEventListener("DOMContentLoaded", function() {';
            foreach ($educations as $edu) {
                echo 'document.querySelector("input[name=\'education[]\'][value=\'' . $edu['education_id'] . '\']").checked = true;';
            }
            echo '});</script>';
            ?>
        </div>

        <label for="hobbies">Hobbies:</label>
        <select id="hobbies" name="hobbies[]" multiple class="form-select">
            <?php
            include '../../utils/FetchHobbies.php';
            ?>
        </select>

        <label for="birthdate">Birth Date:</label>
        <input type="date" id="birthdate" name="birthdate" value="<?= htmlspecialchars($birthdate) ?>" required>

        <label for="file">Upload File:</label>
        <input type="file" id="file" name="file">
        <?php if ($file_path): ?>
    <div class="current-file">
        <a href="../../Uploads/<?= htmlspecialchars($file_path) ?>" class="file-download-link" download >
            <i class="fas fa-file-download"></i> Download your file: <?= htmlspecialchars($file_path) ?>
        </a>
        <input type="hidden" name="existing_file" value="<?= htmlspecialchars($file_path) ?>">
    </div>
<?php endif; ?>

        <label>Gender:</label>
        <div class="radio-group">
            <input type="radio" id="male" name="gender" value="Male" <?= $gender == 'Male' ? 'checked' : '' ?> required>
            <label for="male">Male</label>
            
            <input type="radio" id="female" name="gender" value="Female" <?= $gender == 'Female' ? 'checked' : '' ?> required>
            <label for="female">Female</label>
            
            <input type="radio" id="other" name="gender" value="Other" <?= $gender == 'Other' ? 'checked' : '' ?> required>
            <label for="other">Other</label>
        </div>

        <label for="description">Description:</label>
        <textarea id="description" name="description" rows="4" cols="50" required><?= htmlspecialchars($description) ?></textarea>
        
        <div class="actionfield">
            <button type="submit" name="update_employee">Update</button>
            <a href="ViewEmployee.php?id=<?= $employeeId ?>">Cancel</a>
        </div>
    </form>

    <script src="../../assets/Scripts/AddEmp.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
    $(document).ready(function() {
        $('#hobbies').select2({
            theme: 'bootstrap-5',
            placeholder: "Select hobbies",
            allowClear: true,
            width: '100%'
        });
        
        // Set selected hobbies
        const selectedHobbies = [<?php echo implode(',', array_map(function($h) { return $h['hobby_id']; }, $hobbies)); ?>];
        $('#hobbies').val(selectedHobbies).trigger('change');
    });
    </script>
</body>
</html>