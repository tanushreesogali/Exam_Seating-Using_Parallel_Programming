<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $teacher_id = $_POST['teacherId'];
    $password = $_POST['Password'];

    // Read the CSV file
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
            // Redirect to Connect_Teacher.php on success
            header('Location: Connect_Teacher.php');
            exit();
        } else {
            // Redirect back to Login.php with an error message
            header('Location: Login.php?error=1');
            exit();
        }
    } else {
        echo "Unable to open the CSV file.";
    }
}
?>

