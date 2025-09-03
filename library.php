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

      <label for="Book">Select Book:</label>
      <select id="Book" name="book_id" required>
        <option value="">-SELECTION-</option>
        <?php while ($book = $result->fetch_assoc()): ?>
          <option value="<?= $book['id'] ?>"><?= htmlspecialchars($book['title']) ?></option>
        <?php endwhile; ?>
      </select>

      <label>Duration:</label><br>
      <input type="radio" name="duration" value="1 week" required> 1 week<br>
      <input type="radio" name="duration" value="2 weeks"> 2 weeks<br>
      <input type="radio" name="duration" value="1 month"> 1 month<br><br>

      <input type="checkbox" name="agree" required /> I agree to the Library Terms
      <br><br>
      <button type="submit">Submit</button>
    </form>
  </div>

  <!-- === Chatbot Window === -->
  <div class="chatbot-container" style="display:none;">
    <div class="chatbot-header">Messages</div>
    <div class="chatbot-messages"></div>
    
    <!-- FORM FIXED -->
    <form id="chatForm" class="chatbot-input">
      <input type="text" name="message" id="chatbotMessage" placeholder="Type a message...">
      <button type="submit">&gt;</button>
    </form>
  </div>

  <div class="chatbot-toggle">💬</div>

  <script>
  const toggleBtn = document.querySelector('.chatbot-toggle');
  const chatbot = document.querySelector('.chatbot-container');
  const chatForm = document.getElementById('chatForm');
  const chatMessages = document.querySelector('.chatbot-messages');

  toggleBtn.addEventListener('click', () => {
    chatbot.style.display =
      chatbot.style.display === 'none' || chatbot.style.display === ''
        ? 'flex'
        : 'none';
  });

  chatForm.addEventListener('submit', function(e) {
    e.preventDefault();
    const input = document.getElementById('chatbotMessage');
    const message = input.value.trim();
    if (!message) return;

    const userMsg = document.createElement('div');
    userMsg.textContent = "You: " + message;
    chatMessages.appendChild(userMsg);

    fetch('studentMessages.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: new URLSearchParams({ sender: 'student', message })
    })
    .then(res => res.json())
    .then(data => {
      chatMessages.innerHTML = ""; 
      data.forEach(msg => {
        const div = document.createElement('div');
        div.textContent = msg.sender + ": " + msg.message;
        chatMessages.appendChild(div);
      });
      chatMessages.scrollTop = chatMessages.scrollHeight;
    });

    input.value = "";
  });
  </script>
</body>
</html>

<?php
$conn->close();
?>
