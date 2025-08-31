<?php
$conn = new mysqli("localhost", "root", "", "librarydb");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$student_name = $_POST['student_name'] ?? '';
$book_id = $_POST['book_id'] ?? '';
$duration = $_POST['duration'] ?? '';

if (!$student_name || !$book_id || !$duration) {
    die("Missing required input.");
}

// Calculate due date
$days = match ($duration) {
    '1 week' => 7,
    '2 weeks' => 14,
    '1 month' => 30,
    default => 0
};

$borrow_date = date('Y-m-d');
$due_date = date('Y-m-d', strtotime("+$days days"));

// Insert into borrowed_books
$stmt = $conn->prepare("INSERT INTO borrowed_books (student_name, book_id, duration, borrow_date, due_date) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sisss", $student_name, $book_id, $duration, $borrow_date, $due_date);
$stmt->execute();

// Update books: reduce copy count
$conn->query("UPDATE books SET copies = copies - 1 WHERE id = $book_id AND copies > 0");

// If no more copies, update status
$conn->query("UPDATE books SET status = 'Borrowed' WHERE id = $book_id AND copies = 0");

$conn->close();
header("Location: profile.php"); // redirect to student profile
exit();
