<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee</title>
    <link rel="stylesheet" href="../../assets/Styles/AddEmp.css">
</head>
<body>
    <h1>Add Employee</h1>
    <form action="process_add_emp.php" method="POST" enctype="multipart/form-data">
        <label for="firstname">First Name:</label>
        <input type="text" id="firstname" name="firstname" required>

        <label for="lastname">Last Name:</label>
        <input type="text" id="lastname" name="lastname" required>

        <label for="phone">Phone Number:</label>
        <input type="tel" id="phone" name="phone" required>

        <label>Education:</label>
        <div class="checkbox-group">
            <input type="checkbox" id="highschool" name="education[]" value="High School">
            <label for="highschool">High School</label>
            
            <input type="checkbox" id="bachelor" name="education[]" value="Bachelor's">
            <label for="bachelor">Bachelor's</label>
            
            <input type="checkbox" id="master" name="education[]" value="Master's">
            <label for="master">Master's</label>
            
            <input type="checkbox" id="phd" name="education[]" value="PhD">
            <label for="phd">PhD</label>
        </div>

        <label for="hobbies">Hobbies:</label>
        <select id="hobbies" name="hobbies">
            <option value="Reading">Reading</option>
            <option value="Traveling">Traveling</option>
            <option value="Cooking">Cooking</option>
            <option value="Sports">Sports</option>
            <option value="Music">Music</option>
        </select>

        <label for="birthdate">Birth Date:</label>
        <input type="date" id="birthdate" name="birthdate" required>

        <label for="file">Upload File:</label>
        <input type="file" id="file" name="file" required>

        <label>Gender:</label>
        <div class="radio-group">
            <input type="radio" id="male" name="gender" value="Male" required>
            <label for="male">Male</label>
            
            <input type="radio" id="female" name="gender" value="Female" required>
            <label for="female">Female</label>
            
            <input type="radio" id="other" name="gender" value="Other" required>
            <label for="other">Other</label>
        </div>

        <label for="description">Description:</label>
        <textarea id="description" name="description" rows="4" cols="50" required></textarea>

        <button type="submit">Submit</button>
    </form>
</body>
</html>