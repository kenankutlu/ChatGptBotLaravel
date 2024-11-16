<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ChatBotController extends Controller
{
    public function ask(Request $request)
    {

        try {
            $client = new Client();
            $response = $client->post('https://api.openai.com/v1/chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . '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',
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        ['role' => 'user', 'content' => $request->input('message')],
                    ],
                ],
            ]);


            $data = json_decode($response->getBody()->getContents(), true);
            return response()->json($data['choices'][0]['message']['content']);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            $responseBody = $response->getBody()->getContents();
            return response()->json(['error' => json_decode($responseBody)], 201);
        }
    }

}
