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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Update post in the database
    $sql = "UPDATE posts SET title='$title', content='$content', updated_at=now() WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Retrieve post from the database
$id = $_GET['id'];
$sql = "SELECT * FROM posts WHERE id=$id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Post</title>
</head>
<body>
    <h1>Edit Post</h1>
    <form method="post">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <label for="title">Title:</label>
        <input type="text" name="title" value="<?php echo $row['title']; ?>" ><br>
        <label for="content">Content:</label>
        <textarea name="content" required><?php echo $row['content']; ?></textarea><br>
        <input type="submit" value="Save">
    </form>
</body>
</html>
<?php mysqli_close($conn); ?> 
