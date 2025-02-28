<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use LucianoTonet\GroqPHP\Groq;

class GroqClient
{
    public function chat(Request $request){

        $prompt = $request->message;

        $groq = new Groq(config('app.LLM_API_KEY'));

        $chatCompletions = $groq->chat()->completions()->create([
            'model' => config('groq.GROQ_MODEL'),
            'messages' => [
                ['role' => 'user', 'content' => $prompt],
            ]
        ]);

        $to_return = [
            'status' => 200,
            'prompt' => $prompt,
            'response' =>  $chatCompletions['choices'][0]['message']['content'],
        ];

        return response()->json($to_return);

    }
}
