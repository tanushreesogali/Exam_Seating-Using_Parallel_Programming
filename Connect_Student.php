<?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $reg_number = $_POST["studentRegNo"];
        $dept_number = $_POST["studentDept"];
        $studentSubject = $_POST["studentSubject"];

        $csvFile = fopen($studentSubject, "r");

        while (($data = fgetcsv($csvFile, 1000, ",")) !== FALSE) {
            if ($data[0] === $reg_number && $data[1] === $dept_number) {
                echo "<h2>Details:</h2>";
                echo "Registration Number: " . $data[0] . "<br>";
                echo "Department Number: " . $data[1] . "<br>";
                echo "Room Number: " . $data[2] . "<br>";
                echo "Seat Number: " . $data[3] . "<br>";
                fclose($csvFile);
                exit();
            }
        }

        //echo "<h2>Result:</h2>";
        echo "Incorrect Registration number or Department number.";
        fclose($csvFile);
    }
?>
