<?php

namespace App\Http\Controllers;

use App\User;

use App\DailyGoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    public function signIn(Request $request)
    {
        $http = new \GuzzleHttp\Client();
        try {
            $response = $http->post('http://localhost/FitnessTracker/public/oauth/token', [

                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => 2,
                    'client_secret' => 'EaW1vpEiYvE8WuPMoW8q2T3AN4aGIzMKnhjwRAlZ',
                    'username' => $request->email,
                    'password' => $request->password,
                ]
            ]);
            return $response->getBody()->getContents();
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            if ($e->getCode() === 400) {
                return response()->json('Error! Please enter your E-mail and Password.', $e->getCode());
            } else if ($e->getCode() === 401) {
                return response()->json('Incorrect E-mail or Password', $e->getCode());
            }
            return response()->json('Server Issues.', $e->getCode());
        }
    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8',
        ]);
       

        
  
         $user=User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->dailygoal()->create([
            'calories' => 0,
            'carbohydrate' => 0,
            'protein' => 0,
            'fat' => 0,       
        ]);


        
    

        return $user;
    }
    public function signOut()
    {
       
        auth()->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });
        return response()->json('You have been logged out!', 200);
    }
    
}
