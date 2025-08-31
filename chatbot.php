<?php
if (isset($_POST['message'])) {
    $userMessage = strtolower(trim($_POST['message']));
    $response = "Sorry, I didn’t understand that.";

    // Rule-based responses
    if (strpos($userMessage, "hello") !== false || strpos($userMessage, "hi") !== false) {
        $response = "Hello! How can I help you with the library today?";
    } elseif (strpos($userMessage, "hours") !== false || strpos($userMessage, "open") !== false) {
        $response = "The library is open Monday to Friday, 8AM - 5PM.";
    } elseif (strpos($userMessage, "book") !== false) {
        $response = "You can search for books in the catalog section of the system.";
    } elseif (strpos($userMessage, "bye") !== false) {
        $response = "Goodbye! Have a great day!";
    }

    echo $response;
}
?>
