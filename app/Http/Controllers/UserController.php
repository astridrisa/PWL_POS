<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    // Menampilkan halaman awal user
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar User',
            'list' => ['Home', 'User']
        ];
        
        $page = (object) [
            'title' => 'Daftar user yang terdaftar dalam sistem'
        ];

        $activeMenu = 'user'; //set menu yang sedang aktif

        $level = LevelModel::all(); //ambil data level untuk filter level

        return view('user.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level,'activeMenu' => $activeMenu]);
    }

    // Ambil data user dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $users = UserModel::select('user_id', 'username', 'nama', 'level_id')
            ->with('level');
        
        // Filter data user berdasarkan level_id
        if ($request->level_id) {
            $users->where('level_id', $request->level_id);
        }
        
        return DataTables::of($users)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($user) { // menambahkan kolom aksi
                $btn = '<a href="' . url('/user/' . $user->user_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/user/' . $user->user_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/user/' . $user->user_id) . '">'
                    . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

     //Menampilkan halaman form tambah user
     public function create() 
     {
         $breadcrumb = (object) [
             'title' => 'Tambah User',
             'list' => ['Home', 'User', 'Tambah']
         ];
 
         $page = (object) [
             'title' => 'Tambah User Baru'
         ];
 
         $level = LevelModel::all(); //ambil data level untuk ditampilkan di form
         $activeMenu = 'user'; //set menu yang aktif
 
         return view('user.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
     }

     //Menyimpan data user baru
    //Retreiving or Creating Models
    public function store(Request $request)
    {
        $request->validate([    
        //Username harus diisi, berupa string, minimal 3 karakter, dan bernilai unik didalam tabel m_user kolom username
            'username' => 'required|string|min:3|unique:m_user,username',
            'nama' => 'required|string|max:100', //nama harus diisi, berupa string, dan maksimal 100 karakter
            'password' => 'required|min:5', //password harus diisi dan minimal 5 karakter
            'level_id' => 'required|integer' //level_id harus diisi dan berupa angka
        ]);

        UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => bcrypt($request->password), //password dienkripsi sebelum disimpan
            'level_id' => $request->level_id
        ]);

        return redirect('/user')->with('success', 'Data user berhasil disimpan');
    }

    //Menampilkan detail user
    public function show($id)
    {
        $user = UserModel::find($id);
        $breadcrumb = (object) [
            'title' => 'Detail User',
            'list' => ['Home', 'User', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail User'
        ];

        $activeMenu = 'user'; //set menu yang aktif

        return view('user.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    //Menampilkan halaman form edit user
    public function edit($id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::all(); //ambil data level untuk ditampilkan di form

        $breadcrumb = (object) [
            'title' => 'Edit User',
            'list' => ['Home', 'User', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit User'
        ];

        $activeMenu = 'user'; //set menu yang aktif

        return view('user.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'level' => $level, 'activeMenu' => $activeMenu]);
    }
    //Menyimpan data user yang telah diedit
    public function update(Request $request, $id)
    {
        $request->validate([
            //Username harus diisi, berupa string, minimal 3 karakter, 
            //dan bernilai unik didalam tabel m_user kolom username kecuali untuk user dengan id yang sedang diedit
            'username' => 'required|string|min:3|unique:m_user,username,'.$id.',user_id',
            'nama' => 'required|string|max:100', //nama harus diisi, berupa string, dan maks 100 karakter
            'password' => 'nullable|min:5', //password bisa diisi min 5 karakter dan bisa tidak diisi
            'level_id' => 'required|integer' //level_id harus diisi dan berupa angka
        ]);

        UserModel::find($id)->update([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => $request->password ? bcrypt($request->password) : UserModel::find($id)->password, //password dienkripsi jika diisi, jika tidak diisi maka password tetap
            'level_id' => $request->level_id
        ]);

        return redirect('/user')->with('success', 'Data user berhasil diubah');
    }

    //Menghapus data user
    // Not Found Exceptions
    public function destroy(String $id)
    {
        $check = UserModel::find($id);
        if (!$check) { //untuk mengecek apakah data user dengan id yang dimaksud ada atau tidak
            return redirect('/user')->with('error', 'Data user tidak ditemukan');
        }

        try {
            UserModel::destroy($id); //menghapus data level

            return redirect('/user')->with('success', 'Data user berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            //jika terjadi error ketika menghapus data, redirect kembali ke halaman user dengan membawa pesan error
            return redirect('/user')->with('error', 'Data user gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}

    // public function index(UserDataTable $dataTable)
    // {
        
    //     return $dataTable->render('user.index');
    // }

    // public function create()
    // {
    //     return view('user.create');
    // }

    // public function store(StorePostRequest $request)
    // {
    //     // The incoming request is valid...

    //     // Retrieve the validated input data...
    //     $request->validate();

    //     // Retreive a portion of the validated input data...
    //     $request->safe()->only(['username', 'nama', 'password', 'level_id']);
    //     $request->safe()->except(['username', 'nama', 'password', 'level_id']);

    //     UserModel::create([
    //         'username' => $request->username,
    //         'nama' => $request->nama,
    //         'password' => Hash::make('$request->password'),
    //         'level_id' => $request->level_id,
    //     ]);

    //     // Store the post

    //     return redirect('/user');
    // }

    // public function edit($id)
    // {
    //     $user = UserModel::find($id);
    //     return view('user.edit', ['data' => $user]);
    // }

    // public function edit_simpan($id, Request $request)
    // {
    //     $user = UserModel::find($id);

    //     $user->username = $request->username;
    //     $user->nama = $request->nama;
    //     $user->password = Hash::make('$request->password');
    //     $user->level_id = $request->level_id;

    //     $user->save();

    //     return redirect('/user');
    // }

    // public function delete($id)
    // {
    //     $user = UserModel::find($id);
    //     $user->delete();

    //     return redirect('/user');
    // }

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

    // public function tambah()
    // {
    //     return view('user_tambah');
    // }

    // public function tambah_simpan(Request $request)
    // {
    //     UserModel::create([
    //         'username' => $request->username,
    //         'nama'=> $request->nama,
    //         'password' => Hash::make('$request->password'),
    //         'level_id' => $request->level_id
    //     ]);
    //     return redirect('/user');
    // }

    // public function ubah($id)
    // {
    //     $user = UserModel::find($id);
    //     return view('user_ubah', ['data' => $user]);
    // }

    // public function ubah_simpan($id, Request $request)
    // {
    //     $user = UserModel::find($id);

    //     $user->username = $request->username;
    //     $user->nama = $request->nama;
    //     $user->password = Hash::make('request->password');
    //     $user->level_id = $request->level_id;

    //     $user->save();

    //     return redirect('/user');
    // }

    // public function hapus($id)
    // {
    //     $user = UserModel::find($id);
    //     $user->delete();

    //     return redirect('/user');
    // }