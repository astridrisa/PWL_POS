<?php

namespace App\Http\Controllers;

use App\DataTables\UserDataTable;
use App\Http\Requests\StorePostRequest;
use App\Models\UserModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function index(UserDataTable $dataTable):View
    {
        return $dataTable->render('user.index');
    }
    public function create(): View
    {
        return view('user.create'); 
     }
 
     public function store(StorePostRequest $request): RedirectResponse
     {
        // The incoming request is valid...

        // Retrieve the validated input data...
        $request->validate();

        // Retreive a portion of the validated input data...
        $request->safe()->only(['username', 'nama', 'password', 'level_id']);
        $request->safe()->except(['username', 'nama', 'password', 'level_id']);
        
        UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => Hash::make($request->password),
            'level_id' => $request->level_id,
        ]);
         return redirect('/user');
     }

    public function edit($id)
    {
        $user = UserModel::find($id);
        return view('user.edit', ['data' => $user]);
    }

    public function edit_simpan($id, Request $request)
    {
        $user = UserModel :: find($id);

        $user->username = $request->username;
        $user->nama = $request->nama;
        $user->password = Hash::make( '$request->password');
        $user->level_id = $request->level_id;

        $user->save();

        return redirect('/user');
    }

    public function delete($id)
    {
        $user = UserModel :: find($id);
        $user->delete();

        return redirect('/user');
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
}