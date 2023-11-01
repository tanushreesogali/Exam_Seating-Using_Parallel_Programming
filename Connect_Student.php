<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="student.css">
</head>
<body>
<div class=student>
<?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $reg_number = $_POST["studentRegNo"];
        $dept_number = $_POST["studentDept"];
        $studentSubject = $_POST["studentSubject"];

        $csvFile = fopen($studentSubject, "r");

        while (($data = fgetcsv($csvFile, 1000, ",")) !== FALSE) {
            if ($data[0] === $reg_number && $data[1] === $dept_number) {
                
                echo '<span id="regno">Registration Number: ' . $data[0] . '</span><br>';
                echo '<span id="deptno">Department: ' . $data[1] . '</span><br>';
                echo '<span id="roomno">Room Number: ' . $data[2] . '</span><br>';
                echo '<span id="seatno">Seat Number: ' . $data[3] . '</span><br>';
                fclose($csvFile);
                echo '<a href="Home.html"><button>Go to Home</button></a>';
                exit();
            }
        }
        echo "Incorrect Registration number or Department number.";
        fclose($csvFile);
        echo '<a href="Home.html"><button>Go to Home</button></a>';
    }
?>
</div>
</body>
</html>