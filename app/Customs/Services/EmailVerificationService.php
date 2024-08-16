<?php

namespace App\Customs\Services;

use App\Models\EmailVerficationToken;
//use Psy\Util\Str;
use App\Models\User;
use App\Notifications\EmailVerificationNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;


class EmailVerificationService
{

    public function sendVerificationLink(object $user): void
    {
        Notification::send($user, new EmailVerificationNotification($this->generateVerificationLink($user->email)));
    }

    public function verifyToken(string $email, string $token)
    {
        $token = EmailVerficationToken::where('email', $email)->where('token', $token)->first();
        if($token){
            if($token->expires_at >= now()){
                return $token;
            }
            else{
                $token->delete();
                response()->json([
                    'status' => 'failed',
                    'message' => 'Token expired'
                ], 401)->send();
                exit;
            }
        }else{
            response()->json([
                'status' => 'failed',
                'message' => 'Token Invalid',
            ], 400)->send();
            exit;
        }
    }

    public function checkEmailIsVerified(object $user)
    {
        if($user->email_verified_at) {
            response()->json([
                'status' => 'failed',
                'message' => 'Email already verified'
            ])->send();
            exit;
        }
    }

    public function verifyEmail(string $email, string $token)
    {
        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json([
                'status' => 'failed',
                'message' => 'User not found'
            ], 404);
        }

        $this->checkEmailIsVerified($user);

        $verifiedToken = $this->verifyToken($email, $token);
        if (!$verifiedToken) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Invalid or expired token'
            ], 400);
        }

        if ($user->markEmailAsVerified()) {
            $verifiedToken->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Email has been verified'
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Email verification failed'
            ], 400);
        }
    }


    public function resendLink($email)
    {
        $user = user::where('email', $email)->first();
        if($user){
            $this->generateVerificationLink($user);
        }
        else{
            return response()->json([
               'status' => 'failed',
               'message' => 'User not found'
            ]);
        }
    }
    public function generateVerificationLink(string $email):string
    {
        $checkIfTokenExists = EmailVerficationToken::where('email', $email)->first();
        if ($checkIfTokenExists) {
            $checkIfTokenExists->delete();
        }
        $token = Str::uuid();
        $url = config('app.url') . "?token=" . $token . "&email=" . $email;

        //$url = route('verify.email', ['token' => $token, 'email' => $email]);

        $saveToken = EmailVerficationToken::create([
            "email" => $email,
            "token" => $token,
            "expires_at" => now()->addMinutes(60)
        ]);
        if($saveToken){
            return $url;
        }
        throw new \Exception("Unable to generate verification link.");
    }

}
