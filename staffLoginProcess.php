<?php
$conn = new mysqli("localhost", "root", "", "librarydb");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_POST['username'];
$password = $_POST['password'];

// Check if credentials match
$stmt = $conn->prepare("SELECT * FROM staff WHERE username=? AND password=?");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Success
    header("Location: addBook.php");
    exit();
} else {
    header("Location: staffLogin.html");
    exit();
}

$stmt->close();
$conn->close();
?>
