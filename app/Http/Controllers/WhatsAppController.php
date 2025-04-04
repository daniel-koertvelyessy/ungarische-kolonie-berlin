<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppController extends Controller
{
    public function sendMessage(Request $request)
    {
        $accessToken = config('services.whatsapp.token');
        $hook_url = config('services.whatsapp.hook_url');

        $respose = Http::withToken($accessToken)
            ->post($hook_url, [
                    'messaging_product' => 'whatsapp',
                    'to'                => $request->input('to'),
                    'type'              => 'text',
                    'text'              => ['body' => $request->input('message')],
                ]
            );

        return response()->json($respose->json());
    }

    public function getMessage(Request $request ) {


        if($request->get('hub_mode') === 'subscribe' && $request->get('hub_verify_token') === config('services.whatsapp.hook_token')) {
            return response($request->get('hub_challenge'),200);
        } else {
            return response('Token mismatch',403);
        }



        $data = $request->all();

        Log::info('recieved data from whatsapp webhook:',$data);

        $message = $data['entry'][0]['changes'][0]['value']['messages'][0] ?? null;

        if($message) {
            $from = $message['from'];
            $body = $message['text']['body'] ?? 'empty body';
            Log::info('recieved message from whatsapp webhook:',['from'> $from, 'body' => $body]);

        }

        return response('OK',200);
    }
}
