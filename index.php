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

// Check if a post has been deleted
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM posts WHERE id='$id'";
    mysqli_query($conn, $sql);
    header('location: index.php');
}

// Retrieve all posts from the database
$sql = "SELECT * FROM posts";
$result = mysqli_query($conn, $sql);

// Display all posts in a table
?>
<!DOCTYPE html>
<html>

<head>

    <title>Blog</title>
    <style>
        .auth-links {
            gap: 10px;
        }

        .create-post-btn,
        .login-btn,
        .signup-btn {
            background-color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            padding: 10px 20px;
            text-decoration: none;
            cursor: pointer;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.25);
            transition: all 0.3s ease;
        }

        .create-post-btn:hover,
        .login-btn:hover,
        .signup-btn:hover {
            background-color: #f2f2f2;
        }

        h1 {
            text-align: center;
        }

        table,
        th,
        td {
            border: 1px solid black;
            padding: 5px;
        }

        th {
            background-color: lightgray;
        }

        a {
            color: blue;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <h1>Blog Posts</h1>
    <p>Create your own blog post here, click on create new post</p>
    <div class="auth-links">
        <button><a href="create.php">Create New Post</a></button>
        <button> <a href="login.php">Login</a></button>
        <button><a href="signup.php">Sign up</a></button>
    </div>
    <table>
        <tr>
            <th>Title</th>
            <th>Content</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th></th>
            <th></th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['title']; ?></td>
                <td><?php echo $row['content']; ?></td>
                <td><?php echo $row['created_at']; ?></td>
                <td><?php echo $row['updated_at']; ?></td>
                <td><a href="delete.php?id=<?php echo $row['id']; ?>">Delete</a></td>
                <td><a href="update.php?id=<?php echo $row['id']; ?>">Update</a></td>
            </tr>
        <?php } ?>
    </table>
</body>

</html>
<?php mysqli_close($conn); ?>