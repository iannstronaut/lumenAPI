<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $user = User::orderBy('id', 'ASC')->get();
        return response()->json(['status' => 'success', 'data' => $user], 200);
    }

    public function create(Request $req){
        $this->validate($req, [
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = User::create([
            'username' => $req->username,
            'password' => $req->password
        ]);

        return response()->json(['status' => 'success', 'data' => $user], 200);
    }

    public function update(Request $req, $id){
        $user = User::find($id);

        $user->update($req->all());
        return response()->json(['status' => 'success', 'data' => $user], 200);
    }

    public function delete($id){
        $user = User::find($id);

        $user->delete();
        return response()->json(['status' => 'success', 'data '.$user->username.' dihapus'], 200);
    }
}
