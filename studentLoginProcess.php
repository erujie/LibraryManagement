<?php
session_start();

$conn = new mysqli("localhost", "root", "", "librarydb");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$student_id = $_POST['student_id'];
$password = $_POST['password'];


$stmt = $conn->prepare("SELECT * FROM students WHERE student_id=? AND password=?");
$stmt->bind_param("ss", $student_id, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $_SESSION['student_id'] = $student_id;
    header("Location: library.php");
    exit();
}else {
    header("Location: studentLogin.html");
    exit();
}

$stmt->close();
$conn->close();
?>
