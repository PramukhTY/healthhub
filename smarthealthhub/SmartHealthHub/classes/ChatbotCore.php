<?php

class ChatbotCore {
    public static function getResponse($msg) {
        $msg = strtolower($msg);

        $responses = [
            "paracetamol" => "Paracetamol is used to reduce fever and relieve pain.",
            "ibuprofen" => "Ibuprofen is a non-steroidal anti-inflammatory drug for pain relief.",
            "covid" => "Please get tested if you experience symptoms. Stay hydrated and isolate.",
            "headache" => "Try to rest, stay hydrated, and consider over-the-counter pain relievers.",
            "fever" => "Keep track of your temperature and stay hydrated. See a doctor if high fever persists.",
            "thank you" => "You're welcome! Stay healthy!",
            "hi" => "Hello! How can I assist you with your health today?",
        ];

        foreach ($responses as $keyword => $reply) {
            if (strpos($msg, $keyword) !== false) {
                return $reply;
            }
        }

        return "I'm still learning. Please consult a doctor for serious health issues.";
    }
}
