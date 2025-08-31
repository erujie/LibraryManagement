<?php
$conn = new mysqli("localhost", "root", "", "librarydb");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$search = $_GET['search'] ?? '';
$genre = $_GET['genre'] ?? 'All';

// Base query
$sql = "SELECT * FROM books WHERE 1=1";
$params = [];
$types = "";

// Add search filter
if (!empty($search)) {
    $sql .= " AND (title LIKE ? OR author LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $types .= "ss";
}

// Add genre filter only if not "All"
if ($genre !== "All") {
    $sql .= " AND genre = ?";
    $params[] = $genre;
    $types .= "s";
}

$stmt = $conn->prepare($sql);

// Bind parameters if any
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Search - Library</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <div class="banner">
        <h1>Library Book Search</h1>
        <a href="addBook.php">Back</a>
    </div>
    <br>
    <div class="border">
        <form method="get" action="">
            <input type="text" name="search" placeholder="Search by title, author..." value="<?= htmlspecialchars($search) ?>" />
            <select name="genre">
                <option value="All" <?= $genre === 'All' ? 'selected' : '' ?>>All Genres</option>
                <option value="Action" <?= $genre === 'Action' ? 'selected' : '' ?>>Action</option>
                <option value="Romance" <?= $genre === 'Romance' ? 'selected' : '' ?>>Romance</option>
                <option value="Sci-Fi" <?= $genre === 'Sci-Fi' ? 'selected' : '' ?>>Sci-Fi</option>
                <option value="Autobiography" <?= $genre === 'Autobiography' ? 'selected' : '' ?>>Autobiography</option>
            </select>
            <button type="submit">Search</button>
        </form>

        <table>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Genre</th>
                <th>Status</th>
            </tr>

            <?php if ($result->num_rows > 0): ?>
                <?php while ($book = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($book['title']) ?></td>
                        <td><?= htmlspecialchars($book['author']) ?></td>
                        <td><?= htmlspecialchars($book['genre']) ?></td>
                        <td><?= htmlspecialchars($book['status']) ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="4">No books found.</td></tr>
            <?php endif; ?>
        </table>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
