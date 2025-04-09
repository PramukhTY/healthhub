function sendMessage() {
    const input = document.getElementById("userInput");
    const msg = input.value.trim();
    if (!msg) return;

    const messages = document.getElementById("messages");

    // Display user's message
    const userDiv = document.createElement("div");
    userDiv.className = "message user";
    userDiv.textContent = "You: " + msg;
    messages.appendChild(userDiv);

    // Clear input
    input.value = "";

    // Fetch bot response
    fetch("../api/chat.php", {
        method: "POST",
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({ message: msg })
    })
    .then(res => res.json())
    .then(data => {
        const botDiv = document.createElement("div");
        botDiv.className = "message bot";
        botDiv.textContent = "Bot: " + data.response;
        messages.appendChild(botDiv);
        messages.scrollTop = messages.scrollHeight;
    })
    .catch(err => {
        const botDiv = document.createElement("div");
        botDiv.className = "message bot";
        botDiv.textContent = "Bot: Sorry, something went wrong.";
        messages.appendChild(botDiv);
    });
}
