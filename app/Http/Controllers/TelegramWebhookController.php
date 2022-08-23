<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Telegram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\PersonalAccessToken;

class TelegramWebhookController extends Controller
{
    public function handle(Request $request)
    {
        Log::channel('telegram')->info(json_encode($request->all()));
        // $user = User::where('telegram_id', $request->from['id'])->first();


        if ($request->exists('message') && array_key_exists('text', $request->message)) {
            $text = $request->message['text']; // /start 8-4
            if (str_contains($text, '/start') && strpos($text, '-') !== false && strpos($text, ' ') !== false) {
                [$token_id, $user_id] = explode('-', explode(' ', $text, 2)[1]);
                if (PersonalAccessToken::find($token_id)->tokenable_id == $user_id) {
                    $user = User::find($user_id);
                    $user->telegram_id = $request->message['from']['id'];
                    $user->telegram_notify = true;
                    if ($user->save())
                        Telegram::sendMessage("We will be updating you the order status here.", $request->message['from']['id']);
                }
            }
        }

        // if ($message) {
        //     try {
        //         if ($password)
        //             $user->notify([$message, $username, $password]);
        //         else
        //             $user->notify($message);
        //     } catch (\Throwable $th) {
        //         if ($password && str()->contains($message, $password)) {
        //             $user->reverseResitration();
        //         }
        //         throw $th;
        //     }
        // }
    }
}
