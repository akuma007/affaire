<?php
$invalid = ""; // Variable to store error message
if (isset($_POST['submit'])) {
    $user = $_POST['NUM'];
    $pass = $_POST['mdp']; // Change 'user' and 'pass' variable names accordingly

    if (empty($user) || empty($pass)) {
        $invalid = "Fields cannot be empty";
    } else {
        $conn = mysqli_connect("localhost", "root", "", "affaire"); // Add the database name as the fourth argument

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $query = "SELECT * FROM login WHERE password = '$mdp' AND username = '$Num'";
        $result = mysqli_query($conn, $query);

        $rows = mysqli_num_rows($result);
        if ($rows == 1) {
            header("Location: login.php1"); // Redirecting to another page upon success
            exit(); // Make sure to add an exit() after redirection
        } else {
            $invalid = "Incorrect";
        }

        mysqli_close($conn);
    }
}
?>
