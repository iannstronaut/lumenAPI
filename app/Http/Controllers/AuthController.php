<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $req){
        $this->validate($req,[
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = User::create([
            'username' => $req->username,
            'password' => Hash::make($req->password),
            'api_token' => Str::random(60)
        ]);

        return response()->json(['status' => 'success', 'data' => $user],200);
    }

    public function login(Request $req){
        $this->validate($req, [
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('username', $req->username)->first();
        if($user && Hash::check($req->password, $user->password)){
            $user->update(['api_token' => Str::random(60) ]);
            return response()->json(['status' => 'success', 'api_token' => $user->api_token], 200);
        }

        return response()->json(['status' => 'failed', 'message' => 'Username atau Password Salah'],400);
    }
}
