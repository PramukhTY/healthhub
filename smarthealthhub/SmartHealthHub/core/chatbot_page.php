<?php
require_once "../includes/auth.php";
require_once "../includes/navbar.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Smart HealthBot</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="../assets/js/chatbot.js" defer></script>
    <style>
        #chat-container {
            width: 90%;
            max-width: 600px;
            margin: 20px auto;
            background: #f4f4f4;
            padding: 20px;
            border-radius: 10px;
        }

        #messages {
            height: 300px;
            overflow-y: scroll;
            background: white;
            padding: 10px;
            border: 1px solid #ccc;
            margin-bottom: 10px;
        }

        .message {
            margin-bottom: 10px;
        }

        .user { color: #0077cc; }
        .bot { color: green; }
    </style>
</head>
<body>

<div class="dashboard-container">
    <h2>🤖 Smart HealthBot</h2>
    <div id="chat-container">
        <div id="messages"></div>
        <input type="text" id="userInput" placeholder="Ask me about medicines, health, etc.">
        <button onclick="sendMessage()">Send</button>
    </div>
</div>

<?php require_once "../includes/footer.php"; ?>
</body>
</html>
