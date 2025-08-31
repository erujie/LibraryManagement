<?php 
$conn = new mysqli("localhost", "root", "", "librarydb");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch only available books
$result = $conn->query("SELECT id, title FROM books WHERE status = 'Available'");
?>

<!DOCTYPE html>
<html>

<head>
  <title>Library</title>
  <link rel="stylesheet" href="style.css" />
</head>

<body>
  <div class="banner">
    <h1>Welcome to the Library</h1>
    <a href="search2.php">Book Search</a>
    <a href="returnBook.php">Return a Book</a>
    <a href="profile.php">Student Profile</a>
  </div>
  <br>
  <div class="border">
    <form method="POST" action="borrow.php">
      <label for="Name">Enter Your Name: </label>
      <input type="text" id="Name" name="student_name" required />
      <br><br>

      <label for="Book">Select Book:</label>
      <select id="Book" name="book_id" required>
        <option value="">-SELECTION-</option>
        <?php while ($book = $result->fetch_assoc()): ?>
          <option value="<?= $book['id'] ?>"><?= htmlspecialchars($book['title']) ?></option>
        <?php endwhile; ?>
      </select>
      <br><br>

      <label>Duration:</label><br>
      <input type="radio" name="duration" value="1 week" required> <label>1 week</label><br>
      <input type="radio" name="duration" value="2 weeks"> <label>2 weeks</label><br>
      <input type="radio" name="duration" value="1 month"> <label>1 month</label><br><br>

      <input type="checkbox" name="agree" required />
      <label>I agree to the Library Terms</label>
      <br><br>

      <button type="submit">Submit</button>
    </form>
    <br><br>
  </div>

  <!-- === Chatbot Toggle Button === -->
  <div class="chatbot-toggle">💬</div>

  <!-- === Chatbot Window === -->
  <div class="chatbot-container" style="display:none;">
    <div class="chatbot-header">Chatbot</div>
    <div class="chatbot-messages"></div>
    <div class="chatbot-input">
      <input type="text" placeholder="Type a message..." />
      <button>Send</button>
    </div>
  </div>

  <script>
    const toggleBtn = document.querySelector('.chatbot-toggle');
    const chatbot = document.querySelector('.chatbot-container');

    toggleBtn.addEventListener('click', () => {
      chatbot.style.display =
        chatbot.style.display === 'none' || chatbot.style.display === ''
          ? 'flex'
          : 'none';
    });
  </script>
</body>

</html>

<?php
$conn->close();
?>
