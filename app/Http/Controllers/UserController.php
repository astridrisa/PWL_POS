<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {

    // $user = UserModel::all(1); 
    // $user = UserModel::where('level_id', 1)->first();
    // $user = UserModel::firstWhere('level_id',1);
    // $user = UserModel::findOr(1, ['username', 'nama'], function(){
    //     abort(404);
    // });
    // $user = UserModel::findOr(20, ['username', 'nama'], function(){
    //     abort(404);
    // });
    // $user = UserModel::findOrFail(1);
    // $user = UserModel::where('username', 'manager9')->firstOrFail();
    // $user = UserModel::where('level_id', 2)->count();
    // dd($user);
    $users = UserModel::where('level_id', 2)->get();  
    return view('user', ['data' => $users]);
    }
}