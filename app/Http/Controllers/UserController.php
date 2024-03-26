<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use App\DataTables\UserDataTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function index(UserDataTable $dataTable)
    {
        return $dataTable->render('user.index');
        // $user = UserModel::with('level')->get();
        // return view('user', ['data' => $user]);
    }
        // $user = UserModel::with('level')->get();
        // dd($user);
    // $user = UserModel::create([
    //     'username' => 'manager55',
    //     'nama' => 'Manager55',
    //     'password'=> Hash::make('12345'),
    //     'level_id'=> 2,
    // ]);

    // $user->username = 'manager56';

    // $user->isDirty(); // true
    // $user->isDirty('username'); //true
    // $user->isDirty('nama'); //false
    // $user->isDirty(['nama', 'username']); //true

    // $user->isClean(); // false
    // $user->isClean('username'); //false
    // $user->isClean('nama'); //true
    // $user->isClean(['nama', 'username']); //false

    // $user->save();

    // $user->isDirty(); //false
    // $user->isClean(); //true
    // dd($user->isDirty());

    // $user = UserModel::create([
    //     'username' => 'manager11',
    //     'nama' => 'Manager11',
    //     'password'=> Hash::make('12345'),
    //     'level_id'=> 2,
    // ]);

    // $user->username = 'manager12';

    // $user->save();

    // $user->wasChanged(); // true
    // $user->wasChanged('username'); //true
    // $user->wasChanged(['username', 'level_id']); //true
    // $user->wasChanged('nama'); //false
    // dd($user->wasChanged(['nama', 'username'])); //true


    // $user = UserModel::all();
    // return view('user', ['data' => $user]);
    // }

    public function tambah()
    {
        return view('user_tambah');
    }

    public function tambah_simpan(Request $request)
    {
        UserModel::create([
            'username' => $request->username,
            'nama'=> $request->nama,
            'password' => Hash::make('$request->password'),
            'level_id' => $request->level_id
        ]);
        return redirect('/user');
    }

    public function ubah($id)
    {
        $user = UserModel::find($id);
        return view('user_ubah', ['data' => $user]);
    }

    public function ubah_simpan($id, Request $request)
    {
        $user = UserModel::find($id);

        $user->username = $request->username;
        $user->nama = $request->nama;
        $user->password = Hash::make('request->password');
        $user->level_id = $request->level_id;

        $user->save();

        return redirect('/user');
    }

    public function hapus($id)
    {
        $user = UserModel::find($id);
        $user->delete();

        return redirect('/user');
    }

    public function create() {
        return view('user.create'); 
     }
 
     public function store(Request $request)
     {
         UserModel::create([
             'user_username' => $request->username,
             'user_nama' => $request->namaUser,
             'user_levelId' => $request->level_id,
         ]);
         return redirect('/user');
     }
}