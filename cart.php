<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "root"; // Replace with your MySQL root password
$dbname = "blog_db";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve the ID from the URL parameter
$id = mysqli_real_escape_string($conn, $_GET["id"]);

// Select the blog post with the specified ID
$sql = "SELECT * FROM posts WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Display the blog post information
    $row = $result->fetch_assoc();
    echo "<table>";
    echo "<tr><td>Title:</td><td>" . $row["title"] . "</td></tr>";
    echo "<tr><td>Content:</td><td>" . $row["content"] . "</td></tr>";
    echo "<tr><td>Price:</td><td>" . $row["price"] . "</td></tr>";
    echo "<tr><td>Created at:</td><td>" . $row["created_at"] . "</td></tr>";
    echo "<tr><td>Updated at:</td><td>" . $row["updated_at"] . "</td></tr>";
    echo "</table>";
} else {
    // Display an error message if the blog post was not found
    echo "Blog post not found";
}
// Select all rows from the payments table
$sql = "SELECT * FROM payments";
$result = $conn->query($sql);

// LOOP THROUGH RESULTS AND DISPLAY HERE
while ($row = $result->fetch_assoc()) {
    echo "Payment Type: " . $row['payment_type'] . "<br>";
    echo "Card Number: " . $row['card_number'] . "<br>";
    echo " Expiration Date: " . $row['expiration_date'] . "<br>";
    echo "CVV Code: " . $row['cvv_code'] . "<br>";
    echo "<br>";
}

//initialize error message
$errors = array();

//process from submission if data is posted 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate payment type
    if (empty($_POST["payment_type"])) {
        $errors[] = "Payment type is required";
    } else {
        $payment_type = mysqli_real_escape_string($conn, $_POST["payment_type"]);
    }

    // Validate card number
    if (empty($_POST["card_number"])) {
        $errors[] = "Card number is required";
    } else {
        $card_number = mysqli_real_escape_string($conn, $_POST["card_number"]);
        // Validate card number format
        if (!preg_match("/^[0-9]{16}$/", $card_number)) {
            $errors[] = "Invalid card number format";
        }
    }

    // Validate expiration date
    if (empty($_POST["expiration_date"])) {
        $errors[] = "Expiration date is required";
    } else {
        $expiration_date = mysqli_real_escape_string($conn, $_POST["expiration_date"]);
        // Validate expiration date format
        if (!preg_match("/^((0[1-9])|(1[0-2]))\/\d{4}$/", $expiration_date)) {
            $errors[] = "Invalid expiration date format (use MM/YYYY)";
        }
    }

    // Validate CVV code
    if (empty($_POST["cvv_code"])) {
        $errors[] = "CVV code is required";
    } else {
        $cvv_code = mysqli_real_escape_string($conn, $_POST["cvv_code"]);
        // Validate CVV code format
        if (!preg_match("/^[0-9]{3}$/", $cvv_code)) {
            $errors[] = "Invalid CVV code format (must be 3 digits)";
        }
    }

    // If no errors, insert payment into database and display success message
    if (empty($errors)) {
        $sql = "INSERT INTO payments (payment_type, card_number, expiration_date, cvv_code)
                VALUES ('$payment_type', '$card_number', '$expiration_date', '$cvv_code')";
        if (mysqli_query($conn, $sql)) {
            echo "<p>Thank you for your order!</p>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        // If there are errors, display them
        foreach ($errors as $error) {
            echo "<p style='color: red;'>$error</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Your cart</title>
</head>
<style>
    form {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 50px;
    }

    label {
        font-weight: bold;
        margin-bottom: 0.5rem;
    }

    select,
    input[type="text"] {
        padding: 0.5rem;
        border-radius: 4px;
        border: 1px solid #ccc;
        margin-bottom: 1rem;
        width: 50%;
        box-sizing: border-box;
    }

    input[type="submit"] {
        background-color: #007bff;
        color: #fff;
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #0069d9;
    }

    table {
        border-collapse: collapse;
        width: 50%;
    }

    th,
    td {
        text-align: left;
        padding: 8px;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f2f2f2;
    }
</style>

<body>

    <form method="POST" action="">
        <label for="payment_type">Payment Type:</label>
        <select name="payment_type">
            <option value="Credit Card">Credit Card</option>
            <option value="Debit Card">Debit Card</option>
            <option value="PayPal">PayPal</option>
        </select><br><br>
        <label for="card_number">Card Number:</label>
        <input type="text" name="card_number"><br><br>
        <label for="expiration_date">Expiration Date:</label>
        <input type="text" name="expiration_date" placeholder="MM/YYYY"><br><br>
        <label for="cvv_code">CVV Code:</label>
        <input type="text" name="cvv_code"><br><br>
        <input type="submit" value="Submit">
    </form>

</body>

</html>