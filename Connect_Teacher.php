<?php
if (isset($_POST['teacherSubmit'])) {
    $teacher_id = $_POST['teacherId'];
    $password = $_POST['Password'];
    $teacherProcess = $_POST['teacherProcess'];
    $teacherSubject = $_POST['teacherSubject'];
    file_put_contents("subject_config.txt", $teacherSubject);

    $file = fopen('teacher_IDS.csv', 'r');

    if ($file) {
        $authenticated = false;

        while (($line = fgetcsv($file)) !== false) {
            if ($line[0] === $teacher_id && $line[1] === $password) {
                $authenticated = true;
                break;
            }
        }

        fclose($file);

        if ($authenticated) {
            if ($teacherProcess === 'Generate') {
                // If "Generate" is selected, execute the code as it is.
                $compileCommand = "g++ -o OpenMP OpenMP.cpp -fopenmp";
                $runCommand = "OpenMP.exe";
        
                // Compile the C++ program
                exec($compileCommand, $compileOutput, $compileReturnValue);
                exec($runCommand, $output, $returnValue);
                echo "Seats Assigned Successfully <br>" . implode("<br>", $output);
            } elseif ($teacherProcess === 'View') {
                // If "View" is selected, read and display the contents of csv in a tabular form.
                echo "<h2>Viewing Seats:</h2>";
                echo "<table border='1'>";
        
                $file = fopen($teacherSubject, "r");
                while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
                    echo "<tr>";
                    foreach ($data as $cell) {
                        echo "<td>$cell</td>";
                    }
                    echo "</tr>";
                }
                fclose($file);
        
                echo "</table>";
            } else {
                echo "Invalid process selected.";
            }
            
        } else {
            // Redirect back to Login.php with an error message
            header('Location: Login_Teacher.php?error=1');
            exit();
        }
    } else {
        echo "Unable to open the CSV file.";
    }
} else {
    echo "Form not submitted.";
}
?>