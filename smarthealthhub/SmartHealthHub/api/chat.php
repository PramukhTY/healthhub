<?php
require_once "../classes/ChatbotCore.php";

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);
$message = $data['message'] ?? "";

$response = ChatbotCore::getResponse($message);

echo json_encode(["response" => $response]);
