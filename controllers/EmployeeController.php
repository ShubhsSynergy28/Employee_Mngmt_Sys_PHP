<?php

class EmployeeController{

    public function CreateEmployee() {
        function toProperSentenceCase($text) {
            $text = strtolower(trim($text));
            return ucfirst($text);
        }
        
        function containsNumbers($string) {
            return preg_match('/[0-9]/', $string);
        }
        
        $errors = [];
        global $notification, $notificationClass, $conn;
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
         
            if (empty(trim($_POST['firstname']))) {
                $notification = "First Name is required";
                $notificationClass = "error";
                $errors[] = "First name error";
            } elseif (containsNumbers($_POST['firstname'])) {
                $notification = "First Name cannot contain numbers";
                $notificationClass = "error";
                $errors[] = "First name numbers error";
            }
            
            if (empty(trim($_POST['lastname']))) {
                $notification = "Last Name is required";
                $notificationClass = "error";
                $errors[] = "Last name error";
            } elseif (containsNumbers($_POST['lastname'])) {
                $notification = "Last Name cannot contain numbers";
                $notificationClass = "error";
                $errors[] = "Last name numbers error";
            }
            
            if (empty(trim($_POST['phone']))) {
                $notification = "Phone Number is required";
                $notificationClass = "error";
                $errors[] = "Phone empty error";
            } elseif (!preg_match("/^[0-9]{10}$/", $_POST['phone'])) {
                $notification = "Phone number must be 10 digits";
                $notificationClass = "error";
                $errors[] = "Phone format error";
            }
            
            $educations = $_POST['education'] ?? [];
            if (count($educations) == 0) {
                $notification = "Education is required";
                $notificationClass = "error";
                $errors[] = "Education error";
            }
            
            $hobbies = $_POST['hobbies'] ?? [];
            $birthdate = $_POST['birthdate'];
            $Gender = $_POST['gender'];
            $Description = $_POST['description'];
            
            $file_path = '';
            if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
                $uploadDir = '../../Uploads/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $filename = uniqid() . '_' . basename($_FILES['file']['name']);
                $targetPath = $uploadDir . $filename;
                
                $allowedTypes = ['pdf', 'jpg', 'jpeg', 'png', 'txt', 'csv', 'doc', 'docx', 'rtf'];
                $fileType = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));
                
                if (in_array($fileType, $allowedTypes)) {
                    if (!move_uploaded_file($_FILES['file']['tmp_name'], $targetPath)) {
                        $notification = "Failed to upload file";
                        $notificationClass = "error";
                        $errors[] = "File upload error";
                    } else {
                        $file_path = $filename;
                    }
                } else {
                    $notification = "Only PDF, JPG, JPEG, PNG and TEXT files are allowed";
                    $notificationClass = "error";
                    $errors[] = "File type error";
                }
            } else {
                $notification = "File upload is required";
                $notificationClass = "error";
                $errors[] = "File missing error";
            }
            
            // Check if phone number already exists (only if phone number format is valid)
            if (!empty($_POST['phone']) && preg_match("/^[0-9]{10}$/", $_POST['phone'])) {
                $checkPhoneStmt = $conn->prepare("SELECT Eid FROM employees WHERE Ephone = ?");
                $checkPhoneStmt->bind_param("s", $_POST['phone']);
                $checkPhoneStmt->execute();
                $checkPhoneStmt->store_result();
                
                if ($checkPhoneStmt->num_rows > 0) {
                    $notification = "Employee with this phone number already exists";
                    $notificationClass = "error";
                    $errors[] = "Phone number exists error";
                }
                $checkPhoneStmt->close();
            }
            
            // Only proceed with database operations if no errors
            if (empty($errors)) {
                $EmployeeName = toProperSentenceCase($_POST['firstname']) . " " . toProperSentenceCase($_POST['lastname']);
                $phnNO = $_POST['phone'];
                
                $conn->begin_transaction();
                
                try {
                    // Insert basic employee info
                    $stmt = $conn->prepare("INSERT INTO employees (EName, Ephone, Ebirth_date, Egender, Edescription, Efile_path) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("ssssss", $EmployeeName, $phnNO, $birthdate, $Gender, $Description, $file_path);
                    $stmt->execute();
                    $employee_id = $stmt->insert_id;
                    $stmt->close();
                    
                    // Insert education levels
                    $stmt = $conn->prepare("INSERT INTO employee_educations (employee_id, education_id) VALUES (?, ?)");
                    foreach ($educations as $education_id) {
                        $education_id = (int)$education_id;
                        $stmt->bind_param("ii", $employee_id, $education_id);
                        $stmt->execute();
                    }
                    $stmt->close();
                    
                    // Insert hobbies
                    $stmt = $conn->prepare("INSERT INTO employee_hobbies (employee_id, hobby_id) VALUES (?, ?)");
                    foreach ($hobbies as $hobby_id) {
                        $hobby_id = (int)$hobby_id;
                        $stmt->bind_param("ii", $employee_id, $hobby_id);
                        $stmt->execute();
                    }
                    $stmt->close();
                    
                    // Commit transaction
                    $conn->commit();
                    $notification = "Employee created successfully";
                    $notificationClass = "success";
                } catch (Exception $e) {
                    // Rollback on error
                    $conn->rollback();
                    $notification = "Error creating employee: " . $e->getMessage();
                    $notificationClass = "error";
                    
                    // Delete uploaded file if transaction failed
                    if (!empty($file_path)) {
                        @unlink($uploadDir . $file_path);
                    }
                }
            }
        }
    }

        public function ViewEmployeeDetailswithPagination($Length, $multiplier) {
            $errors = [];
            global $conn, $notification, $notificationClass;
            
            $offset = $Length * $multiplier;
    
            $query = "SELECT 
                        e.Eid,
                        e.EName, 
                        e.Ephone, 
                        e.Ebirth_date, 
                        e.Egender, 
                        e.Edescription, 
                        e.Efile_path,
                        GROUP_CONCAT(DISTINCT ed.EduName SEPARATOR ', ') AS education,
                        GROUP_CONCAT(DISTINCT h.Hname SEPARATOR ', ') AS hobbies
                      FROM employees e
                      LEFT JOIN employee_educations ee ON e.Eid = ee.employee_id
                      LEFT JOIN educations ed ON ee.education_id = ed.Eduid
                      LEFT JOIN employee_hobbies eh ON e.Eid = eh.employee_id
                      LEFT JOIN hobbies h ON eh.hobby_id = h.Hid
                      GROUP BY e.Eid
                      LIMIT ? OFFSET ?";
            
            try {
                $stmt = $conn->prepare($query);
                if (!$stmt) {
                    throw new Exception("Prepare failed: " . $conn->error);
                }
                $stmt->bind_param("ii", $Length, $offset);
                $stmt->execute();
                $result = $stmt->get_result();
                $employees = $result->fetch_all(MYSQLI_ASSOC);
                
                $stmt->close();
                return $employees;
            } catch (Exception $e) {
                error_log("Database error: " . $e->getMessage());
                return [];
            }
        }

        function ViewEmployeeDetails($Eid) {
            $errors = [];
            global $conn, $notification, $notificationClass;
            $query = "SELECT 
                        e.Eid,
                        e.EName, 
                        e.Ephone, 
                        e.Ebirth_date, 
                        e.Egender, 
                        e.Edescription, 
                        e.Efile_path,
                        GROUP_CONCAT(DISTINCT ed.EduName SEPARATOR ', ') AS education,
                        GROUP_CONCAT(DISTINCT h.Hname SEPARATOR ', ') AS hobbies
                      FROM employees e
                      LEFT JOIN employee_educations ee ON e.Eid = ee.employee_id
                      LEFT JOIN educations ed ON ee.education_id = ed.Eduid
                      LEFT JOIN employee_hobbies eh ON e.Eid = eh.employee_id
                      LEFT JOIN hobbies h ON eh.hobby_id = h.Hid
                      WHERE e.Eid = ?;
                      "
                      ;
                    try{
                        $stmt = $conn->prepare($query);
                        if(!$stmt){
                            throw new Exception("Prepare failed: " . $conn->error);
                        }
                        $stmt->bind_param("i", $Eid);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $employee = $result->fetch_assoc();
                        return $employee;
                        $stmt->close();
                    }

                catch(Exception $e){
                    error_log("Database error: " . $e->getMessage());
                    return [];
                }

        }

        public function getEmployeeEducations($employeeId) {
            global $conn;
            
            $query = "SELECT education_id FROM employee_educations WHERE employee_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $employeeId);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $educations = [];
            while ($row = $result->fetch_assoc()) {
                $educations[] = $row;
            }
            
            $stmt->close();
            return $educations;
        }
        
        public function getEmployeeHobbies($employeeId) {
            global $conn;
            
            $query = "SELECT hobby_id FROM employee_hobbies WHERE employee_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $employeeId);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $hobbies = [];
            while ($row = $result->fetch_assoc()) {
                $hobbies[] = $row;
            }
            
            $stmt->close();
            return $hobbies;
        }
        
        public function UpdateEmployee($Eid) {
            $errors = [];
            global $conn, $notification, $notificationClass;
            
            if ($_SERVER["REQUEST_METHOD"] != "POST") {
                return false;
            }
            
            // Collect form data
            $EmployeeName = $_POST['firstname'] . " " . $_POST['lastname'];
            $phnNO = $_POST['phone'];
            $educations = $_POST['education'] ?? [];
            $hobbies = $_POST['hobbies'] ?? [];
            $birthdate = $_POST['birthdate'];
            $Gender = $_POST['gender'];
            $Description = $_POST['description'];
            
            // File upload handling
            $file_path = $_POST['existing_file'] ?? '';
            
            if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
                $uploadDir = '../../Uploads/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                // Delete old file if exists
                if (!empty($file_path) && file_exists($uploadDir . $file_path)) {
                    @unlink($uploadDir . $file_path);
                }
                
                $filename = uniqid() . '_' . basename($_FILES['file']['name']);
                $targetPath = $uploadDir . $filename;
                
                $allowedTypes = ['pdf', 'jpg', 'jpeg', 'png'];
                $fileType = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));
                
                if (in_array($fileType, $allowedTypes)) {
                    if (move_uploaded_file($_FILES['file']['tmp_name'], $targetPath)) {
                        $file_path = $filename;
                    } else {
                        $notification = "Failed to upload file";
                        $notificationClass = "error";
                        return false;
                    }
                } else {
                    $notification = "Only PDF, JPG, JPEG, PNG files are allowed";
                    $notificationClass = "error";
                    return false;
                }
            }
            
            // Begin transaction
            $conn->begin_transaction();
            
            try {
                // Update basic employee info
                $stmt = $conn->prepare("UPDATE employees SET EName=?, Ephone=?, Ebirth_date=?, Egender=?, Edescription=?, Efile_path=? WHERE Eid=?");
                $stmt->bind_param("ssssssi", $EmployeeName, $phnNO, $birthdate, $Gender, $Description, $file_path, $Eid);
                $stmt->execute();
                $stmt->close();
                
                // Update education levels - first delete existing, then insert new
                $stmt = $conn->prepare("DELETE FROM employee_educations WHERE employee_id = ?");
                $stmt->bind_param("i", $Eid);
                $stmt->execute();
                $stmt->close();
                
                $stmt = $conn->prepare("INSERT INTO employee_educations (employee_id, education_id) VALUES (?, ?)");
                foreach ($educations as $education_id) {
                    $education_id = (int)$education_id;
                    $stmt->bind_param("ii", $Eid, $education_id);
                    $stmt->execute();
                }
                $stmt->close();
                
                // Update hobbies - first delete existing, then insert new
                $stmt = $conn->prepare("DELETE FROM employee_hobbies WHERE employee_id = ?");
                $stmt->bind_param("i", $Eid);
                $stmt->execute();
                $stmt->close();
                
                $stmt = $conn->prepare("INSERT INTO employee_hobbies (employee_id, hobby_id) VALUES (?, ?)");
                foreach ($hobbies as $hobby_id) {
                    $hobby_id = (int)$hobby_id;
                    $stmt->bind_param("ii", $Eid, $hobby_id);
                    $stmt->execute();
                }
                $stmt->close();
                
                // Commit transaction
                $conn->commit();
                return true;
            } catch (Exception $e) {
                // Rollback on error
                $conn->rollback();
                $notification = "Error updating employee: " . $e->getMessage();
                $notificationClass = "error";
                error_log("Database error: " . $e->getMessage());
                return false;
            }
        }
        public function DeleteEmployee($Eid) {
            $errors = [];
            global $conn, $notification, $notificationClass;
            
            // First get the file path to delete the associated file
            $fileQuery = "SELECT Efile_path FROM employees WHERE Eid = ?";
            $fileStmt = $conn->prepare($fileQuery);
            $fileStmt->bind_param("i", $Eid);
            $fileStmt->execute();
            $result = $fileStmt->get_result();
            $employee = $result->fetch_assoc();
            $fileStmt->close();
            
            $conn->begin_transaction();
            
            try {
                // First delete from child tables
                $stmt = $conn->prepare("DELETE FROM employee_educations WHERE employee_id = ?");
                $stmt->bind_param("i", $Eid);
                $stmt->execute();
                $stmt->close();
                
                $stmt = $conn->prepare("DELETE FROM employee_hobbies WHERE employee_id = ?");
                $stmt->bind_param("i", $Eid);
                $stmt->execute();
                $stmt->close();
                
                // Then delete from main table
                $stmt = $conn->prepare("DELETE FROM employees WHERE Eid = ?");
                $stmt->bind_param("i", $Eid);
                $stmt->execute();
                $stmt->close();
                
                $conn->commit();
                
                // Delete the associated file
                if (!empty($employee['Efile_path'])) {
                    $uploadDir = '../../Uploads/';
                    @unlink($uploadDir . $employee['Efile_path']);
                }
                
                $notification = "Employee deleted successfully";
                $notificationClass = "success";
                return true;
            } catch (Exception $e) {
                $conn->rollback();
                $notification = "Error deleting employee: " . $e->getMessage();
                $notificationClass = "error";
                error_log("Database error: " . $e->getMessage());
                return false;
            }
        }

               }

$EmployeeController = new EmployeeController();
if(strpos($_SERVER['REQUEST_URI'], 'AddEmp.php') !== false){
    $EmployeeController->CreateEmployee();
}

elseif (strpos($_SERVER['REQUEST_URI'], 'ViewEmployee.php') !== false && isset($_GET['id'])) {
    // The view page will handle the display, no need to call controller here
}
elseif (strpos($_SERVER['REQUEST_URI'], 'DeleteEmployee.php') !== false && isset($_GET['id'])) {
    $EmployeeController->DeleteEmployee((int)$_GET['id']);
}


?>