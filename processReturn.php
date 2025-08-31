<?php
$conn = new mysqli("localhost", "root", "", "librarydb");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$borrow_id = $_POST['borrow_id'] ?? null;

if (!$borrow_id) {
    die("No book selected for return.");
}

// Get the book ID from the borrow record
$stmt = $conn->prepare("SELECT book_id FROM borrowed_books WHERE id = ?");
$stmt->bind_param("i", $borrow_id);
$stmt->execute();
$stmt->bind_result($book_id);
$stmt->fetch();
$stmt->close();

if ($book_id) {
    // 1. Increase copies
    $conn->query("UPDATE books SET copies = copies + 1 WHERE id = $book_id");

    // 2. If status was 'Borrowed' and copies > 0, set status to 'Available'
    $conn->query("UPDATE books SET status = 'Available' WHERE id = $book_id AND copies > 0");

    // 3. Delete the borrow record
    $conn->query("DELETE FROM borrowed_books WHERE id = $borrow_id");
}

$conn->close();
header("Location: profile.php");
exit();
