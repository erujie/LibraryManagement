<?php
$conn = new mysqli("localhost", "root", "", "librarydb");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert new message
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'], $_POST['sender'])) {
    $sender = $_POST['sender'];
    $message = trim($_POST['message']);

    if (!empty($message)) {
        $stmt = $conn->prepare("INSERT INTO messages (sender, message) VALUES (?, ?)");
        $stmt->bind_param("ss", $sender, $message);
        $stmt->execute();
        $stmt->close();
    }
    exit; // stop here on POST
}

// Fetch all messages
$result = $conn->query("SELECT * FROM messages ORDER BY created_at ASC");

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

header('Content-Type: application/json');
echo json_encode($messages);

$conn->close();
?>
