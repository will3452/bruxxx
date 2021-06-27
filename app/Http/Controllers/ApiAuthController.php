<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ApiAuthController extends Controller
{
    public function login(){
        $fields = request()->validate([
            'email'=>'required',
            'password'=>'required|min:8'
        ]);

        $user = User::where('email', $fields['email'])->first();
        if(!$user || !\Hash::check($fields['password'], $user->password)){
            return responce([
                'message'=>'Bad Creds',
            ], 401);
        }
        $token = $user->createToken('myapptoken')->plainTextToken;
        $response = [
            'user'=>$user,
            'token'=>$token
        ];

        return $response;
    }

    public function register(Request $request){
        $fields = request()->validate([
            'last_name'=>'required',
            'first_name'=>'required',
            'email'=>'required|unique:users',
            'password'=>'required|min:8',
            'sex'=>'required',
            'gender'=>'required',
            'college'=>'required',
            'course'=>'required',
            'club'=>'required',
            'country'=>'required',
            'city'=>'required',
            'birthdate'=>'required'
        ]);

        $user = User::create([
            'last_name'=>$request->last_name,
            'first_name'=>$request->first_name,
            'email'=>$request->email, 
            'password'=>\Hash::make($request->password),
            'role'=>'student',
        ]);

        $user->bio()->create([
            'gender'=>$request->gender, 
            'sex'=>$request->sex,
            'birthdate'=>$request->birthdate,
            'country'=>$request->country,
            'city'=>$request->city
        ]);

        $user->interests()->create([
            'type'=>'course',
            'name'=>$request->course
        ]);
        $user->interests()->create([
            'type'=>'college',
            'name'=>$request->college
        ]);
        $user->interests()->create([
            'type'=>'club',
            'name'=>$request->club
        ]);

       $token = $user->createToken('myapptoken')->plainTextToken;
       $response = [
           'user'=>$user,
           'token'=>$token
       ];

       return response($response, 201);
    }

    public function logout(){
        auth()->user()->tokens()->delete();
        return [
            'message'=>'Logged out'
        ];
    }
}