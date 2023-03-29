<?php
// connect the database

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "blog_db";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: . mysqli_connect_error"());
}

// kolla om posten har ett id 

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

// retrieve post med id från databasen

$id = $_GET['id'];
$sql = "SELECT * FROM posts WHERE id=$id";
$result = mysqli_query($conn, $sql); // fixed typo here
if (!$result || mysqli_num_rows($result) == 0) {
    header("Location: index.php");
    exit();
}
$row = mysqli_fetch_assoc($result);

// handle form 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Update the post with the new data
    $sql = "UPDATE posts SET title='$title', content='$content', updated_at=now() WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>

<head>

<body>
    <h1>Edit post</h1>
    <style>
        form {
            display: flex;
            flex-direction: column;
            width: 50%;
            margin: auto;
        }

        label {
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        input[type="text"],
        textarea {
            padding: 0.5rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        form input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        form input[type="submit"]:hover {
            background-color: #0062cc;
        }
    </style>
    <form method="post">
        <label for="title">Title:</label>
        <input type="text" name="title" value="<?php echo $row['title']; ?> " required><br>
        <label for="content">Content:</label>
        <textarea name="content" required><?php echo $row['content']; ?></textarea><br>
        <input type="submit" value="Update">
    </form>
</body>

</html>
<?php mysqli_close($conn); ?>