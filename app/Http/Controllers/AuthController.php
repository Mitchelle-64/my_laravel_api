<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Mail; // Import the Mail facade
use App\Mail\EmailVerification; // Correct the namespace for the EmailVerification Mailable

class AuthController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    public function signup(Request $request){
        $this -> validate($request, [
            'username'=>'required',
            'email'=> 'required|email',
            'password' => 'required|min:6',
        ]);
        
        $verificationToken = Str::random(60);


        $user = User::create([
            'username'=> $request->username,
            'email'=> $request-> email,
            'password'=> $request -> password,
            'verificationToken' => $verificationToken,
        ]);

        //generate email verification URL
        // $verificationUrl = $this->generateVerificationUrl($user, $verificationToken);
        $verificationUrl = $this->generateVerificationUrl($verificationToken);



         // Send the verification email
        // Mail::to($user->email)->send(new EmailVerification($user, $verificationUrl));
        Mail::to($user->email)->send(new EmailVerification($user, $verificationUrl));


        
        return response()-> json(['message' => 'signup successful', 'verification_url' => $verificationUrl], 201);
    }

    // Helper method to generate the verification URL
    // protected function generateVerificationUrl($user, $verificationToken)
    protected function generateVerificationUrl($verificationToken)

    {
        // Generate the signed URL using the 'verification.verify' route and the verification token as a parameter
        // return URL::signedRoute('verification.verify', ['verificationToken' => $verificationToken]);
        // return route('verification.verify', ['token' => $verificationToken]);
        // Extract the token part of the URL (excluding the base URL)
        // Parse the URL and extract the token parameter
        $parsedUrl = parse_url($verificationToken);
    
        if (isset($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $queryParams);
            if (isset($queryParams['token'])) {
                $token = $queryParams['token'];
                return URL::route('verification.verify', ['token' => $token]);
            }
        }
    }
        
    


    public function login(Request $request){
        $credentials = $request->only(['username', 'password']);
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            $is_admin = $user->hasRole('admin');
            $token = $user->createToken('auth-token')->plainTextToken;
            return response()->json(['token' => $token, 'user' => $user, 'is_admin' => $is_admin], 200);

        }
            return response()->json(['message', 'Invalid credentials'], 401);
    }

    public function logout(Request $request){
        $user = $request-> user();

        $user -> tokens()->delete();

        return response()->json(['message'=> 'logout successful']);
    }


}


