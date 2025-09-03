<?php
$conn = new mysqli("localhost", "root", "", "librarydb");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="style.css">
  <title>Messages - Library</title>
</head>
<body>
  <div class="banner2">
    <h1>Admin Messaging</h1>
    <a href="logoutStaff.php">Logout</a>
    <a href="search.php">Book List</a>
  </div>

  <div class="chatbot-container" style="display:flex; margin:20px auto;">
    <div class="chatbot-header">Messages with Students</div>
    
    <!-- Messages -->
    <div class="chatbot-messages"></div>

    <!-- Input -->
    <div class="chatbot-input">
      <input type="text" id="adminInput" placeholder="Type a reply..." />
      <button id="adminSend">Send</button>
    </div>
  </div>

  <script>
    const messagesDiv = document.querySelector('.chatbot-messages');
    const adminInput = document.querySelector('#adminInput');
    const adminSend = document.querySelector('#adminSend');

    function loadMessages() {
      fetch('studentMessages.php')
        .then(res => res.json())
        .then(data => {
          messagesDiv.innerHTML = '';
          data.forEach(msg => {
            const div = document.createElement('div');
            div.innerHTML = `<b>${msg.sender}:</b> ${msg.message} <br><small>${msg.created_at}</small>`;
            div.style.marginBottom = "10px";
            messagesDiv.appendChild(div);
          });
          messagesDiv.scrollTop = messagesDiv.scrollHeight;
        });
    }

    adminSend.addEventListener('click', () => {
      const message = adminInput.value.trim();
      if (message !== '') {
        fetch('studentMessages.php', {
          method: 'POST',
          headers: {'Content-Type': 'application/x-www-form-urlencoded'},
          body: `sender=admin&message=${encodeURIComponent(message)}`
        }).then(() => {
          adminInput.value = '';
          loadMessages();
        });
      }
    });

    setInterval(loadMessages, 2000);
    loadMessages();
  </script>
</body>
</html>
