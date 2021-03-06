<?php

namespace App\Http\Controllers;

use App\Bio;
use App\Interest;
use App\Mail\PreRegistrationDetails;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PreregisterController extends Controller
{
    public function index()
    {
        return view('student-register');
    }

    public function save()
    {
        $data = request()->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'gender' => 'required|string',
            'sex' => 'required|string',
            'country' => 'required|string',
            'city' => 'required',
            'birthdate' => 'required|string',
            'interest.*' => 'required',
        ]);

        $age = Carbon::parse($data['birthdate'])->age;
        if ($age < 15) {
            return back()->with(['age_error'=>'You must be 15 years old and above to register and use this site.']);
        }

        $lastId = User::latest()->first()->id;
        $aan = "BRUSTD".now()->format('Y').Str::padLeft("".($lastId), 8, '0');
        $user = User::create([
            'first_name' => $data['first_name'],
            'role' => 'student',
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'is_pre_register' => true,
            'aan_string'=>$aan
        ]);

        Bio::create([
            'user_id' => $user->id,
            'gender' => $data['gender'],
            'sex' => $data['sex'],
            'birthdate' => $data['birthdate'],
            'country' => $data['country'],
            'city' => ucwords($data['city']),
        ]);

//        //interest
//        $i1 = explode('@', $data['interest'][0]);
//
//        Interest::create([
//            'user_id' => $user->id,
//            'type' => 'college',
//            'name' => $i1[0],
//            'description' => end($i1),
//        ]);
//
//        $i2 = explode('@', $data['interest'][1]);
//
//        Interest::create([
//            'user_id' => $user->id,
//            'type' => 'course',
//            'name' => $i2[0],
//            'description' => end($i2),
//        ]);
//
//        $i3 = explode('@', $data['interest'][2]);
//
//        Interest::create([
//            'user_id' => $user->id,
//            'type' => 'club',
//            'name' => $i3[0],
//            'description' => end($i3),
//        ]);

        $user->box()->create();

        Mail::to($user)->send(new PreRegistrationDetails($user));

        return view('preregister_success', compact('aan'));
    }
}
