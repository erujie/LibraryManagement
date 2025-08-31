<?php
$conn = new mysqli("localhost", "root", "", "librarydb");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// For now we just get all borrows (you can filter by student name or session later)
$result = $conn->query("
  SELECT b.title, bb.due_date
  FROM borrowed_books bb
  JOIN books b ON bb.book_id = b.id
  ORDER BY bb.due_date ASC
");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Student Profile - Library</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <div class="banner">
    <h1>Student Profile</h1>
    <a href="logoutStudent.php">Logout</a>
    <a href="library.php">Back</a>
  </div>
  <br>

  <div class="border">
    <h2>Currently Borrowed Books</h2>
    <table>
      <tr>
        <th>Book Title</th>
        <th>Due Date</th>
      </tr>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['title']) ?></td>
          <td><?= htmlspecialchars($row['due_date']) ?></td>
        </tr>
      <?php endwhile; ?>
    </table>
  </div>
</body>
</html>

<?php $conn->close(); ?>
