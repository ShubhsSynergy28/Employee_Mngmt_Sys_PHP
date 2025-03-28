<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../views/Auth/login.php");
    exit();
}

// Include the database configuration
include '../../config/config.php';
include '../../controllers/EmployeeController.php';
include '../Components/Notification.php';

// Store submitted values if they exist
$submittedValues = [
    'firstname' => $_POST['firstname'] ?? '',
    'lastname' => $_POST['lastname'] ?? '',
    'phone' => $_POST['phone'] ?? '',
    'birthdate' => $_POST['birthdate'] ?? '',
    'gender' => $_POST['gender'] ?? '',
    'description' => $_POST['description'] ?? '',
    'education' => $_POST['education'] ?? [],
    'hobbies' => $_POST['hobbies'] ?? []
];
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add Employee</title>
        <link rel="stylesheet" href="../../assets/Styles/AddEmp.css">
        <!-- Add these to your <head> section -->
            <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
        </head>
        <body>
    <h1>Add Employee</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
        <label for="firstname">First Name:</label>
        <input type="text" id="firstname" name="firstname" value="<?= htmlspecialchars($submittedValues['firstname']) ?>" required>

        <label for="lastname">Last Name:</label>
        <input type="text" id="lastname" name="lastname" value="<?= htmlspecialchars($submittedValues['lastname']) ?>" required>

        <label for="phone">Phone Number:</label>
        <input type="tel" id="phone" name="phone" value="<?= htmlspecialchars($submittedValues['phone']) ?>" required>

        <label>Education:</label>
        <div class="checkbox-group">
            <?php
            // Fetch education levels from database
            include '../../utils/FetchEdu.php';
            
            // Add this script to check previously selected education options
            echo '<script>document.addEventListener("DOMContentLoaded", function() {';
            foreach ($submittedValues['education'] as $eduId) {
                echo 'if(document.querySelector("input[name=\'education[]\'][value=\'' . $eduId . '\']")) {';
                echo '  document.querySelector("input[name=\'education[]\'][value=\'' . $eduId . '\']").checked = true;';
                echo '}';
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
        <input type="date" id="birthdate" name="birthdate" value="<?= htmlspecialchars($submittedValues['birthdate']) ?>" required>

        <label for="file">Upload File:</label>
        <input type="file" id="file" name="file" required>

        <label>Gender:</label>
        <div class="radio-group">
            <input type="radio" id="male" name="gender" value="Male" <?= $submittedValues['gender'] == 'Male' ? 'checked' : '' ?> required>
            <label for="male">Male</label>
            
            <input type="radio" id="female" name="gender" value="Female" <?= $submittedValues['gender'] == 'Female' ? 'checked' : '' ?> required>
            <label for="female">Female</label>
            
            <input type="radio" id="other" name="gender" value="Other" <?= $submittedValues['gender'] == 'Other' ? 'checked' : '' ?> required>
            <label for="other">Other</label>
        </div>

        <label for="description">Description:</label>
        <textarea id="description" name="description" rows="4" cols="50" required><?= htmlspecialchars($submittedValues['description']) ?></textarea>
        
        <div class="actionfield">
            <button type="submit">Submit</button>
            <a href="./Dashboard.php">Cancel</a>
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
        
        // Set previously selected hobbies
        var selectedHobbies = <?= json_encode($submittedValues['hobbies']) ?>;
        $('#hobbies').val(selectedHobbies).trigger('change');
    });
    </script>
</body>
</html>

<?php
$conn->close();
?>