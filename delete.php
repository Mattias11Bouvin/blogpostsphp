<?php
// connect db

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "blog_db";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// hantera post radera
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    //radera posten från db 
    $sql = "DELETE FROM posts WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// retrive post from db 

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM posts WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $post = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Delete Post</title>
</head>

<body>
    <h1>Delete post</h1>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        
        h1 {
            font-size: 36px;
            color: #333;
        }
        
        h2 {
            font-size: 24px;
            color: #666;
        }
        
        p {
            font-size: 16px;
            line-height: 1.5;
            color: #999;
        }
        
        form {
            margin-top: 20px;
        }
        
        input[type="submit"] {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        
        input[type="submit"]:hover {
            background-color: #666;
        }
    </style>
    <p>Are you sure you want to delete this post</p>
    <h2>Title: <?php echo $post['title']; ?></h2>
    <p>Content: <?php echo $post['content']; ?></p>
    <form method="post">
        <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
        <input type="submit" value="Delete">
    </form>
</body>

</html>

<?php mysqli_close($conn); ?>