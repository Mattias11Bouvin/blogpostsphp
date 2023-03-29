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
	$title = $_POST['title'];
	$content = $_POST['content'];

	// Insert new post into the database
	$sql = "INSERT INTO posts (title, content, created_at, updated_at) VALUES ('$title', '$content', now(), now())";
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
	<title>Create New Post</title>
	<style>
		h1 {
			text-align: center;
		}
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

</head>

<body>
	<h1>Create New Post</h1>
	<form method="post">
		<label for="title">Title:</label>
		<input type="text" name="title"> <br>
		<label for="content">Content:</label>
		<textarea name="content" required></textarea><br>
		<input type="submit" value="Create">
	</form>
</body>

</html>
<?php mysqli_close($conn); ?>