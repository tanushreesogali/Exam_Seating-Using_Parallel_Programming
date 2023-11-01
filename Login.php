<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
</head>

<body>
    <div class="teacher">
        <h1>Teacher Login</h1>
        <?php
        if (isset($_GET['error']) && $_GET['error'] == 1) {
        echo "Incorrect ID or Password";
        }
        ?>
        <form action="Verify_Teacher.php" method="post">
            <label for="teacherId">ID:</label><br>
            <input type="text" id="teacherId" name="teacherId" required><br><br>
            <label for="Password">Password:</label><br>
            <input type="password" id="Password" name="Password" required><br><br>
            <label for="teacherSubject">Choose a Subject:</label>
            <select id="teacherSubject" name="teacherSubject">
                <option value="CAO">CAO</option>
                <option value="CN">CN</option>
                <option value="Discrete">Discrete</option>
                <option value="DSA">DSA</option>
            </select><br>
            <label for="teacherProcess">Choose Process:</label>
            <select id="teacherProcess" name="teacherProcess">
                <option value="View">View</option>
                <option value="Generate">Generate</option>
            </select><br>
            <button type="submit" name="teacherSubmit">Submit</button>
        </form>
    </div>

    <div class="student">
        <h1>Student Login</h1>
        <form action="Connect_Student.php" method="post">
            <label for="studentRegNo">Registration Number:</label><br>
            <input type="text" id="studentRegNo" name="studentRegNo" required><br><br>
            <label for="studentDept">Department:</label><br>
            <input type="text" id="studentDept" name="studentDept" required><br><br>
            <label for="studentSubject">Choose a Subject:</label>
            <select id="studentSubject" name="studentSubject">
                <option value="CAO">CAO</option>
                <option value="CN">CN</option>
                <option value="Discrete">Discrete</option>
                <option value="DSA">DSA</option>
            </select><br>
            <button type="submit" name="studentSubmit">Submit</button>
        </form>
    </div>
</body>
</html>