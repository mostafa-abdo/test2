<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\EmailConfirmation;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\SignupRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Google_Client;
use Google_Service_Gmail;
use Google_Service_Gmail_Message;

class AuthController extends Controller
{


    public function register (SignupRequest $request)
    {
        $data = $request->validated();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'phone' => $data['phone'],
        ]);

        $token = $user->createToken('main')->plainTextToken;

        return response(compact('user', 'token'));
    }

    public function login (LoginRequest $request)
    {

        $credentials = $request->validated();

        if(!Auth::attempt($credentials)) {
            return response([
                'message' => 'Provided password or email address are not correct'
            ], 422);
        }

        $user = Auth::user();

        $token = $user->createToken('main')->plainTextToken;

        return response(compact('user', 'token'));
    }

    public function logout (Request $request) {

        $user = $request->user();

        $user->currentAccessToken()->delete();

        return response('', 204);
    }

    public function confirmEmail (Request $request)
    {
        $user = User::where('email', $request->email)->first();


        if($user) {
            $confermationCode = Str::random(4);

            $user->update([
                'confirmation_code' => $confermationCode
            ]);


            return response(['success' => true, 'message' => 'Email sent successfully'], 200);



        }else{
            return response(['success' => false, 'message' => 'User not found'], 404);
        }
    }

    public function confirmCode (Request $request)
    {
        
    }

}
