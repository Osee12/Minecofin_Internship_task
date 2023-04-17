<?php
// Establish database connection
$conn = mysqli_connect("localhost", "root", "amahoro", "user_accounts");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Retrieve values from form
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    // Check if the password and confirm password match
    if ($password != $confirm_password) {
        echo "Passwords do not match!";
        exit();
    }

    // Check if the username is already taken
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        echo "Username already taken!";
        exit();
    }

    // Check if the email is already registered
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        echo "Email already registered!";
        exit();
    }

    // Insert user data into the database
    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
    if (mysqli_query($conn, $sql)) {
        echo "Registration successful!";
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
        exit();
    }
}

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
</head>
<body>
	<h2>Register</h2>
	<form method="POST" action="register.php">
		<label>Username:</label>
		<input type="text" name="username"><br>

		<label>Email:</label>
		<input type="email" name="email"><br>

		<label>Password:</label>
		<input type="password" name="password"><br>

		<label>Confirm Password:</label>
		<input type="password" name="confirm_password"><br>

		<input type="submit" name="submit" value="Register">
	</form>
</body>
</html>
