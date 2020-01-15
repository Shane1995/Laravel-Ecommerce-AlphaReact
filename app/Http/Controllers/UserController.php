<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{



    public function updateUserDetails(Request $req)
    {

        $this->validate($req, [
            "email" => 'required|string|email|max:255',
            "name" => 'required|string',
            "lastName" =>  'required|string',
            "address" => 'required|string|max:255',
            'password' => ['required', 'string', 'min:8', 'confirmed'],


        ]);


        $name = $req->input('name');
        $lastName = $req->input('lastName');
        $email = $req->input('email');
        $newPassword = Hash::make($req->password);

        $updatedUserDetails = array("name" => $name, "lastName" => $lastName, "email" => $email, "password" => $newPassword);
        $updatedUserDetails = DB::table('users')->where(["id" => Auth::user()->id])->update($updatedUserDetails);
        return view('home', ['success' => 'yes']);
    }
}