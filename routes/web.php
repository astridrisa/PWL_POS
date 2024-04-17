<?php

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/level', [LevelController::class, 'index']);
Route::get('/kategori', [KategoriController::class, 'index']);
Route::get('/user', [UserController::class, 'index']);
Route::get('/user/tambah', [UserController::class, 'tambah']);
Route::post('/user/tambah_simpan', [UserController::class, 'tambah_simpan']);
Route::get('/user/ubah/{id}', [UserController::class, 'ubah']);
Route::put('/user/ubah_simpan/{id}', [UserController::class, 'ubah_simpan']);
Route::get('/user/hapus/{id}', [UserController::class, 'hapus']);


Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');

//Kategori
Route::get('/kategori', [KategoriController::class, 'index'])->name('/kategori');

//Create Kategori
Route::get('/kategori/create', [KategoriController::class, 'create'])->name('/kategori/create');
Route::post('/kategori', [KategoriController:: class, 'store']);

//Edit Kategori
Route::get('/kategori/update/{id}', [KategoriController::class, 'update'])->name('/kategori/update');
Route::put('/kategori/update_simpan/{id}', [KategoriController :: class, 'update_simpan'])->name('/kategori/update_simpan');

//Delete Kategori
Route::get('/kategori/delete/{id}', [KategoriController::class, 'delete'])->name('/kategori/delete');

//Manage User
Route::get('/user', [UserController::class, 'index'])->name('user.index');
Route::get('/user/create', [UserController::class, 'create'])->name('/user/create');
Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('/user/edit');
Route::get('/user', [UserController :: class, 'index'])->name('user.index');
Route::post('/user', [UserController :: class, 'store']);
Route::put('/user/{id}', [UserController :: class, 'edit_simpan'])->name('/user/edit_simpan');
Route::get('/user/delete/{id}', [UserController::class, 'delete'])->name('/user/delete');

//Manage Level
Route::get('/level', [LevelController::class, 'index'])->name('level.index');
Route::get('/level/create', [LevelController::class, 'create'])->name('/level/create');
Route::post('/level', [LevelController::class, 'store']);
Route::get('/level/edit/{id}', [LevelController::class, 'edit'])->name('/level/edit');
Route::put('/level/{id}', [LevelController::class, 'edit_simpan'])->name('/level/edit_simpan');
Route::get('/level/delete/{id}', [LevelController::class, 'delete'])->name('/level/delete');

//m_user
Route::resource('m_user', POSController::class);

//adminlte
Route::get('/', [WelcomeController::class, 'index']);

Route::group(['prefix' => 'user'], function () {
    Route:: get('/', [UserController::class, 'index']);  //menampilkan halaman awal user
    Route:: post('/list', [UserController::class, 'list']); // menampilkan data user dalam bentuk json untuk datatables
    Route:: get('/create', [UserController::class, 'create']); // menampilkan halaman form tambah user
    Route:: post('/', [UserController::class, 'store']); // menyimpan data user baru
    Route:: get('/{id}', [UserController::class, 'show']); // menampilkan detail user
    Route:: get('/{id}/edit', [UserController::class, 'edit']);  // menampilkan halaman form edit user
    Route::put('/{id}', [UserController::class, 'update']); // menyimpan perubahan data user
    Route::delete('/{id}', [UserController::class, 'destroy']); // menghapus data user
    });


//TUGAS JOBSHEET 7- Level
Route::group(['prefix' => 'level'], function () {
    Route::get('/', [LevelController::class, 'index']); //menampilkan halaman awal level
    Route::post('/list', [LevelController::class, 'list']); //menampilkan data level dalam bentuk json untuk database
    Route::get('create', [LevelController::class, 'create']); //menampilkan halaman form tambah level
    Route::post('/', [LevelController::class, 'store']); //menyimpan data level baru
    Route::get('/{id}', [LevelController::class, 'show']); //menampilkan detail level
    Route::get('/{id}/edit', [LevelController::class, 'edit']); //menampilkan halaman form edit level
    Route::put('/{id}', [LevelController::class, 'update']); //menyimpan perubahan data level
    Route::delete('/{id}', [LevelController::class, 'destroy']); //menghapus data level
});

//TUGAS JOBSHEET 7 - Kategori
Route::group(['prefix' => 'kategori'], function () {
    Route::get('/', [KategoriController::class, 'index']); //menampilkan halaman awal kategori
    Route::post('/list', [KategoriController::class, 'list']); //menampilkan data kategori dalam bentuk json untuk database
    Route::get('create', [KategoriController::class, 'create']); //menampilkan halaman form tambah
    Route::post('/', [KategoriController::class, 'store']); //menyimpan data kategori baru
    Route::get('/{id}', [KategoriController::class, 'show']); //menampilkan detail kategori
    Route::get('/{id}/edit', [KategoriController::class, 'edit']); //menampilkan halaman form edit k
    Route::put('/{id}', [KategoriController::class, 'update']); //menyimpan perubahan data kategori
    Route::delete('/{id}', [KategoriController::class, 'destroy']); //menghapus data kategori
});

//TUGAS JOBSHEET 7  - Barang
Route::group(['prefix' => 'barang'], function () {
    Route::get('/', [BarangController::class, 'index']); //menampilkan halaman awal barang
    Route::post('/list', [BarangController::class, 'list']); //menampilkan data barang dalam bentuk json untuk database
    Route::get('create', [BarangController::class, 'create']); //menampilkan halaman form tambah
    Route::post('/', [BarangController::class, 'store']); //menyimpan data barang baru
    Route::get('/{id}', [BarangController::class, 'show']); //menampilkan detail barang
    Route::get('/{id}/edit', [BarangController::class, 'edit']); //menampilkan halaman form edit barang
    Route::put('/{id}', [BarangController::class, 'update']); //menyimpan perubahan data barang
    Route::delete('/{id}', [BarangController::class, 'destroy']); //menghapus data barang
});

//TUGAS JOBSHEET 7  - Stok
Route::group(['prefix' => 'stok'], function () {
    Route::get('/', [StokController::class, 'index']); //menampilkan halaman awal stok
    Route::post('/list', [StokController::class, 'list']); //menampilkan data stok dalam bentuk json untuk database
    Route::get('create', [StokController::class, 'create']); //menampilkan halaman form tambah
    Route::post('/', [StokController::class, 'store']); //menyimpan data stok baru
    Route::get('/{id}', [StokController::class, 'show']); //menampilkan detail stok
    Route::get('/{id}/edit', [StokController::class, 'edit']); //menampilkan halaman form edit stok
    Route::put('/{id}', [StokController::class, 'update']); //menyimpan perubahan data stok
    Route::delete('/{id}', [StokController::class, 'destroy']); //menghapus data stok
});

//TUGAS JOBSHEET 7  - Transaksi
Route::group(['prefix' => 'transaksi'], function () {
    Route::get('/', [TransaksiController::class, 'index']); //menampilkan halaman awal transaksi
    Route::post('/list', [TransaksiController::class, 'list']); //menampilkan data transaksi dalam bentuk json untuk database
    Route::get('create', [TransaksiController::class, 'create']); //menampilkan halaman form tambah transaksi
    Route::post('/', [TransaksiController::class, 'store']); //menyimpan data transaksi baru
    Route::get('/{id}', [TransaksiController::class, 'show']); //menampilkan detail transaksi 
    Route::get('/{id}/edit', [TransaksiController::class, 'edit']); //menampilkan halaman form edit transaksi
    Route::put('/{id}', [TransaksiController::class, 'update']); //menyimpan perubahan data transaksi
    Route::delete('/{id}', [TransaksiController::class, 'destroy']); //menghapus data transaksi
});

// PRAKTIKUM JOBSHEET 8
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('proses_login', [AuthController::class, 'proses_login'])->name('proses_login');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::post('proses_register', [AuthController::class, 'proses_register'])->name('proses_register');

// kita atur juga untuk middleware menggunakan group pada routing
// didalamnya terdapat group untuk mengecek kondisi login
// jika user yang login merupakan admin maka akan diarahkan ke AdminController
// jika user yang login merupakan manager maka akan diarahkan ke UserController
Route::group(['middleware' => ['auth']], function () {

    Route::group(['middleware' => ['cek_login:1']], function () {
        Route::resource('admin', AdminController::class);
    });
    Route::group(['middleware' => ['cek_login:2']], function () {
        Route::resource('manager', ManagerController:: class) ;
    });

});