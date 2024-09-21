<?php

namespace App\Http\Controllers;

use App\Models\ChatbotMessage;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{

    public function chatbot() {
        return view('chatbot-guest');
    }

    public function handleMessage(Request $request)
    {
        $userMessage = $request->input('message');

        // Implement your chatbot logic here
        $chatbotResponse = $this->getChatbotReply($userMessage);

        // Save the message and response to the database
        $chatbotMessage = new ChatbotMessage();
        $chatbotMessage->user_message = $userMessage;
        $chatbotMessage->chatbot_response = $chatbotResponse;
        // Set any other necessary fields, such as user_id
        $chatbotMessage->save();

        return response()->json(['reply' => $chatbotResponse]);
    }

    private function getChatbotReply($message)
    {
        // Replace this with your actual chatbot logic
        // You can implement intent recognition, knowledge base lookup, etc.
        $knowledgeBase = [
            'What are the admission requirements?' => 'The admission requirements include...',
            'How can I register for classes?' => 'To register for classes, follow these steps...',
            // Add more entries to your knowledge base
        ];

        $lowercaseMessage = strtolower($message);
        foreach ($knowledgeBase as $question => $answer) {
            if (str_contains($lowercaseMessage, strtolower($question))) {
                return $answer;
            }
        }

        return 'Sorry, I could not understand your query. Please rephrase or contact our support team.';
    }
}