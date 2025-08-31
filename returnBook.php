<?php
$conn = new mysqli("localhost", "root", "", "librarydb");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Just for demo: show all borrowed books
$result = $conn->query("
  SELECT bb.id as borrow_id, b.title, bb.student_name, bb.due_date
  FROM borrowed_books bb
  JOIN books b ON bb.book_id = b.id
");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Return Books</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="banner">
    <h1>Return a Book</h1>
    <a href="library.php">Back to Library</a>
  </div>
  <br>

  <div class="border">
    <form method="POST" action="processReturn.php">
      <h2>Select a book to return:</h2>
      <table>
        <tr>
          <th>Select</th>
          <th>Title</th>
          <th>Borrowed By</th>
          <th>Due Date</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><input type="radio" name="borrow_id" value="<?= $row['borrow_id'] ?>" required></td>
          <td><?= htmlspecialchars($row['title']) ?></td>
          <td><?= htmlspecialchars($row['student_name']) ?></td>
          <td><?= htmlspecialchars($row['due_date']) ?></td>
        </tr>
        <?php endwhile; ?>
      </table>
      <br>
      <button type="submit">Return Selected Book</button>
    </form>
  </div>
</body>
</html>

<?php $conn->close(); ?>
