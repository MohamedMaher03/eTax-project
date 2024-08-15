<?php

namespace App\Customs\Services;

use App\Models\EmailVerficationToken;
//use Psy\Util\Str;
use App\Notifications\EmailVerificationNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;


class EmailVerificationService
{
    public function sendVerificationLink(object $user): void
    {
        Notification::send($user, new EmailVerificationNotification($this->generateVerificationLink($user->email)));
    }
    public function generateVerificationLink(string $email):string
    {
        $checkIfTokenExists = EmailVerficationToken::where('email', $email)->first();
        if ($checkIfTokenExists) {
            $checkIfTokenExists->delete();
        }
        $token = Str::uuid();
        $url = config('app.url') . "?token=" . $token . "&email=" . $email;
        $saveToken = EmailVerficationToken::create([
            "email" => $email,
            "token" => $token,
            "expires_at" => now()->addMinutes(60)
        ]);
        if($saveToken){
            return $url;
        }
    }



}
