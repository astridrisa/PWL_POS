<?php

namespace App\Http\Controllers;

use App\DataTables\LevelDataTable;
use App\Http\Requests\StorePostRequest;
use App\Models\LevelModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Monolog\Level;
use Yajra\DataTables\Facades\DataTables;

class LevelController extends Controller
{
    public function index() 
    {
        // Menampilkan halaman awal level
        $breadcrumb = (object) [
            'title' => 'Daftar Level',
            'list' => ['Home', 'Level']
        ];

        $page = (object) [
            'title' => 'Daftar Level yang terdaftar dalam sistem'
        ];

        $activeMenu = 'level'; //set menu yang aktif

        return view('level.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    // Ambil data level dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $levels = LevelModel::select('level_id', 'level_kode', 'level_nama');

        return DataTables::of($levels)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($level) { // menambahkan kolom aksi
                $btn = '<a href="'.url('/level/' . $level->level_id).'" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="'.url('/level/' . $level->level_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="'. url('/level/'.$level->level_id).'">'.
                            csrf_field() . method_field('DELETE') .
                            '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    // Menampilkan halaman form tambah level
    public function create() 
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Level',
            'list' => ['Home', 'Level', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Level Baru'
        ];

        $activeMenu = 'level'; //set menu yang aktif

        return view('level.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    // Menyimpan data level baru
    public function store(Request $request)
    {
        $request->validate([
            'level_kode' => 'required|string|min:3|unique:m_level,level_kode',
            'level_nama' => 'required|string|max:100'
        ]);

        LevelModel::create([
            'level_kode' => $request->level_kode,
            'level_nama' => $request->level_nama
        ]);

        return redirect('/level')->with('success', 'Data level berhasil ditambahkan');
    }

    // Menampilkan detail level
    public function show($id)
    {
        $level = LevelModel::find($id);
        $breadcrumb = (object) [
            'title' => 'Detail Level',
            'list' => ['Home', 'Level', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Level'
        ];

        $activeMenu = 'level'; //set menu yang aktif

        return view('level.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    // Menampilkan halaman form edit level
    public function edit($id) 
    {
        $level = LevelModel::find($id);
        $breadcrumb = (object) [
            'title' => 'Edit Level',
            'list' => ['Home', 'Level', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Level'
        ];

        $activeMenu = 'level'; //set menu yang aktif

        return view('level.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    // Menyimpan data level yang telah diedit
    public function update(Request $request, $id)
    {
        $request->validate([
            'level_kode' => 'required|string|min:3|unique:m_level,level_kode,'.$id.',level_id',
            'level_nama' => 'required|string|max:100'
        ]);

        LevelModel::find($id)->update([
            'level_kode' => $request->level_kode,
            'level_nama' => $request->level_nama
        ]);

        return redirect('/level')->with('success', 'Data level berhasil diubah');
    }

    // Menghapus data level
    public function destroy($id)
    {
        $check = LevelModel::find($id);
        if (!$check) {
            return redirect('/level')->with('error', 'Data level tidak ditemukan');
        }

        try {
            LevelModel::destroy($id);

            return redirect('/level')->with('success', 'Data level berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/level')->with('error', 'Data level gagal dihapus');
        }
    }
}
    // public function index()
    // {
    //     // DB::insert('insert into m_level(level_kode, level_nama, created_at) values(?, ?, ?)',['CUS', 'Pelanggan', now()]);
    //     // return 'Insert data baru berhasil';

    //     //$row = DB::update('update m_level set level_nama =? where level_kode = ?', ['Customer', 'CUS']);
    //     //return 'Update data berhasil. Jumlah data yang diupdate ' .$row. ' baris';

    //     // $row = DB::delete('delete from m_level where level_kode =?', ['CUS']);
    //     // return 'Delete data berhasil. Jumlah data yang dihapus:' . $row . 'baris';

    //     $data = DB::select('select * from m_level');
    //     return view('level' , ['data' => $data]);
    // }

    // public function index(LevelDataTable  $dataTable) {
    //     return  $dataTable->render('level.index');
    // }

    // public function create() {
    //     return view('level.create');
    // }  


    // public function store(StorePostRequest $request)
    // {
    //      // The incoming request is valid...

    //     // Retrieve the validated input data...
    //     $request->validate();

    //     // Retrieve a portion of the validated input data...
    //     $request->safe()->only(['level_kode', 'level_nama']);
    //     $request->safe()->except(['level_kode', 'level_nama']);
        
    //     LevelModel::create([
    //         'level_kode' => $request->level_kode,
    //         'level_nama' => $request->level_nama,
    //     ]);

    //     return redirect('/level');
    // }

    // public function edit($id)
    // {
    //     $level = LevelModel::find($id);
    //     return view('level.edit', ['data' => $level]);
    // }

    // public function edit_simpan($id, Request $request)
    // {
    //     $level = LevelModel::find($id);
    //     $level->level_kode = $request->level_kode;
    //     $level->level_nama = $request->level_nama;

    //     $level->save();
    //     return redirect('/level');
    // }

    // public function delete($id)
    // {
    //     $user = LevelModel::find($id);
    //     $user->delete();

    //     return redirect('/level');
    // }