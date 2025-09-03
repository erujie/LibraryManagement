<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Book Add - Library</title>
</head>
<body>
    <div class="banner2"><h1>Add Books in library</h1>
        <a href="logoutStaff.php">Logout</a>
        <a href="search.php">Book List</a>
    </div>
    
    <br>
    <form method="POST" action="saveBook.php" enctype="multipart/form-data">
    <div class="border2">
        <br>
        <label for="title">Book Title: </label>
        <input type="text" id="title" name="title" required>
        <br><br>
        <label for="author">Author: </label>
        <input type="text" id="author" name="author">
        <br><br>
        <label for="isbn">ISBN: </label>
        <input type="text" id="isbn" name="isbn">
        <br><br>
        <label for="publisher">Publisher: </label>
        <input type="text" id="publisher" name="publisher">
        <br><br>
        <label for="year">Publication Year:</label>
        <input type="number" id="year" name="year" min="1900" max="2025">
        <br><br>
        <label for="genre">Genre:</label>
        <select id="genre" name="genre">
            <option value="">-select-</option>
            <option value="Action">Action</option>
            <option value="Fantasy">Fantasy</option>
            <option value="Sci-Fi">Sci-Fi</option>
            <option value="Comedy">Comedy</option>
            <option value="Romance">Romance</option>
        </select>
        <br><br>
        <label for="copies">Number of Copies:</label>
        <input type="number" id="copies" name="copies">
        <br><br>
        <label for="shelf">Shelf Location:</label>
        <select name="shelf">
            <option value="A-01">A-01</option>
            <option value="A-02">A-02</option>
            <option value="B-01">B-01</option>
            <option value="B-02">B-02</option>
            <!-- Add more if needed -->
        </select>
        <br><br>
        <label for="cover">Upload Cover Image:</label>
        <input type="file" name="cover" accept="image/*">
        <br><br>
        <button type="submit">SAVE</button>
        <br><br>
    </div>
    </form>

    <!-- === Chatbot Window === -->
    <div class="chatbot-container" style="display:none;">
    <div class="chatbot-header">Messages</div>
    <div class="chatbot-messages"></div>
    
    <!-- proper form -->
    <form class="chatbot-input" id="chatForm">
    <input type="text" name="message" placeholder="Type a message..." required />
    <button type="submit">Send</button>
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

    // handle form submit
    chatForm.addEventListener('submit', function(e) {
    e.preventDefault();

    const input = this.querySelector('input[name="message"]');
    const message = input.value.trim();
    if (!message) return;

    // show message immediately
    const userMsg = document.createElement('div');
    userMsg.textContent = "You: " + message;
    chatMessages.appendChild(userMsg);

    // send to backend
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
