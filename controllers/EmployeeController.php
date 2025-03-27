<?php

class EmployeeController{

    public function CreateEmployee () {
        $errors = [];
        global  $notification, $notificationClass, $conn;
        if ($_SERVER["REQUEST_METHOD"]=="POST"){
            $EmployeeName = $_POST['firstname']." ".$_POST['lastname'];
            $phnNO = $_POST['phone'];
            $educations = $_POST['education'] ?? [];
            $hobbies = $_POST['hobbies'] ?? [];
            $birthdate = $_POST['birthdate'];
            $Gender = $_POST['gender'];
            $Description = $_POST['description'];

            if (empty($_POST['firstname'])){ {
                $notification = "First Name is required";
                $notificationClass = "error";
                $errors[] = "Errors";
            }
            }
            if (empty($_POST['lastname'])){ {
                $notification = "Last Name is required";
                $notificationClass = "error";
                $errors[] = "Errors";
            }
            }
            if (empty($_POST['phone'])){ {
                $notification = "Phone Number is required";
                $notificationClass = "error";
                $errors[] = "Errors";
            }
        } 
        if (count($educations) == 0){ {
                $notification = "Education is required";
                $notificationClass = "error";
                $errors[] = "Errors";
            }}
            if (count($hobbies) == 0){
                $notification = "Hobbies is required";
                $notificationClass = "error";
                $errors[] = "Errors";
            }
            $file_path = '';
            if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
                $uploadDir = '../../Uploads/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $filename = uniqid() . '_' . basename($_FILES['file']['name']);
                $targetPath = $uploadDir . $filename;
                
                // Check file type (example: only allow PDF and images)
                $allowedTypes = ['pdf', 'jpg', 'jpeg', 'png'];
                $fileType = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));
                
                if (in_array($fileType, $allowedTypes)) {
                    if (move_uploaded_file($_FILES['file']['tmp_name'], $targetPath)) {
                        $file_path = $filename;
                    } else {
                        $notification = "Failed to upload file";
                        $notificationClass = "error";
                        $errors[] = "Errors";
                    }
                } else {
                    $notification = "Only PDF, JPG, JPEG, PNG files are allowed";
                    $notificationClass = "error";
                    $errors[] = "Errors";
                }
            } else {
                $notification = "File upload is required";
                $notificationClass = "error";
                $errors[] = "Errors";
            }
        
        }
            //proceed with the database
            $conn->begin_transaction();

            try {
                // Insert basic employee info
              

                $stmt = $conn->prepare("INSERT INTO employees (EName, Ephone, Ebirth_date, Egender, Edescription, Efile_path) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssss",$EmployeeName, $phnNO, $birthdate, $Gender, $Description, $file_path);
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
                $errors[] = "Database error: " . $e->getMessage();
                
                // var_dump($errors);
                // Delete uploaded file if transaction failed
                if (!empty($file_path)) {
                    @unlink($uploadDir . $file_path);
                }
            }
        }

        public function ViewEmployeeDetailswithPagination() {
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
                      GROUP BY e.Eid";
            
            try {
                $stmt = $conn->prepare($query);
                if (!$stmt) {
                    throw new Exception("Prepare failed: " . $conn->error);
                }
                
                $stmt->execute();
                $result = $stmt->get_result();
                $employees = $result->fetch_all(MYSQLI_ASSOC);
                
                return $employees;
                $stmt->close();
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

        public function UpdateEmployee($Eid) {
            $errors = [];
            global $conn, $notification, $notificationClass;
            $query= "UPDATE employees SET EName = ?, Ephone = ?, Ebirth_date = ?, Egender = ?, Edescription = ?, Efile_path = ? WHERE Eid = ?";
            $EmployeeName = $_POST['firstname']." ".$_POST['lastname'];

        }
        public function DeleteEmployee($Eid) {
            $errors = [];
            global $conn, $notification, $notificationClass;
            $query = "DELETE FROM employees WHERE Eid = ?";
            try{
                $stmt = $conn->prepare($query);
                if(!$stmt){
                    throw new Exception("Prepare failed: " . $conn->error);
                }
                $stmt->bind_param("i", $Eid);
                $stmt->execute();
                $stmt->close();
                $notification = "Employee deleted successfully";
                $notificationClass = "success";
            }
            catch(Exception $e){
                error_log("Database error: " . $e->getMessage());
                return [];
            }
        }

               }

$EmployeeController = new EmployeeController();
if(strpos($_SERVER['REQUEST_URI'], 'AddEmp.php') !== false){
    $EmployeeController->CreateEmployee();
}

elseif(strpos($_SERVER['REQUEST_URI'], 'Dashboard.php') !== false){

    // $EmployeeController->ViewEmployeeDetailswithPagination();

}
elseif(strpos($_SERVER['REQUEST_URI'], 'Dashboard.php') !== false){
    $EmployeeController->DeleteEmployee();
}


?>