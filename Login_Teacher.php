<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <link rel="stylesheet" href="stylefac.css">
</head>

<body>
    <div class="teacher">
        <h1>Faculty Login</h1>
        <?php
        if (isset($_GET['error']) && $_GET['error'] == 1) {
        echo "Incorrect ID or Password";
        }
        ?>
        <form action="Connect_Teacher.php" method="post">
            <label id="idteach" for="teacherId">Enter your ID:</label>
            <input type="text" id="teacherId" name="teacherId" required><br><br>
            <label id="passteach" for="Password">Password:</label>
            <input type="password" id="Password" name="Password" required><br><br>
            <label id="sub" for="teacherSubject">Choose a Subject:</label>
            <select id="teacherSubject" name="teacherSubject">
                <option value="seating_cao.csv">CAO</option>
                <option value="seating_cn.csv">CN</option>
                <option value="seating_discrete.csv">Discrete</option>
                <option value="seating_dsa.csv">DSA</option>
            </select><br>
            <label id="process" for="teacherProcess">Choose Process:</label>
            <select id="teacherProcess" name="teacherProcess">
                <option value="View">View</option>
                <option value="Generate">Generate</option>
            </select><br>
            <button id="submitbut" type="submit" name="teacherSubmit">Submit</button>
        </form>
        <a href="Home.html" class="home-button">Go to Home</a>
    </div>
</body>
</html>