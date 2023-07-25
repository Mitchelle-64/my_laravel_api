<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailVerificationController extends Controller
{
    // public function sendVerificationEmail(Request $request){
    //     //retrieve the authenticated user / user signing up
    //     $user = $request-> user();

    //     // Check if the user already has a verification token in the database
    //     if (!$user->verificationToken) {
    //         // If the user doesn't have a token, generate a new one
    //         $verificationToken = Str::random(60);

    //         // Save the token in the database
    //         $user->update([
    //             'verificationToken' => $verificationToken,
    //             'email_verified_at' => null,
    //         ]);
    //     } else {
    //         // If the user already has a token, use the existing one
    //         $verificationToken = $user->verificationToken;
    //     }

    //     //send the verification email
    //     Mail::to($user->email)->send(new EmailVerification($user, $verificationToken));

    //     return response() -> json(['message' => 'Verification email sent successfully']);

    // }

    public function verifyEmail($verificationToken){
        // Extract the verification token from the request
        // $verificationToken = $request->input('token');

        //Find the user by the verification token
        $user = User::where('verificationToken', $verificationToken)->first();

        // If no user found or the token is invalid, handle the error (e.g., show a message or redirect)
        if (!$user) {
            return response()->json(['error' => 'Invalid verification token'], 422);
        }

        $user->update([
            'verificationToken' => null,
            'email_verified_at' => now(),
        ]);

        return response()->json(['message' => 'Email verified successfully']);





    }
}
