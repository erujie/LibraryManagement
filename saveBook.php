<?php
// Connect to DB
$conn = new mysqli("localhost", "root", "", "librarydb");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form values
$title = $_POST['title'];
$author = $_POST['author'];
$isbn = $_POST['isbn'];
$publisher = $_POST['publisher'];
$year = $_POST['year'];
$genre = $_POST['genre'];
$copies = $_POST['copies'];
$shelf = $_POST['shelf'];

// Handle cover image
$coverName = "";
if (isset($_FILES['cover']) && $_FILES['cover']['error'] == 0) {
    $coverName = basename($_FILES['cover']['name']);
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir);
    }
    $targetFile = $targetDir . $coverName;
    move_uploaded_file($_FILES["cover"]["tmp_name"], $targetFile);
}

// Insert into DB
$stmt = $conn->prepare("INSERT INTO books (title, author, isbn, publisher, publication_year, genre, copies, shelf_location, cover_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssiss", $title, $author, $isbn, $publisher, $year, $genre, $copies, $shelf, $coverName);

if ($stmt->execute()) {
    header("Location: addBook.php"); // redirect to form page
    exit();
} else {
    echo "Error: " . $stmt->error; // show error only if something breaks
}

$stmt->close();
$conn->close();
?>
