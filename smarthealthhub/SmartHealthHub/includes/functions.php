<?php
function sanitizeInput($input) {
    return htmlspecialchars(trim($input));
}

function redirect($url) {
    header("Location: $url");
    exit();
}
?>
