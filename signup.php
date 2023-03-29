<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "root"; // Replace with your MySQL root password
$dbname = "blog_db";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form has been submitted
if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Insert the new user into the database
    $sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['username'] = $username;
        header('Location: index.php');
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Sign Up</title>
</head>

<body>
    <h2>Sign Up</h2>
    <form method="POST" action="">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <input type="submit" name="submit" value="Sign Up">
    </form>
</body>

</html>