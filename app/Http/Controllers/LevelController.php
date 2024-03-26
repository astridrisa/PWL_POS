<?php

namespace App\Http\Controllers;

use App\DataTables\LevelDataTable;
use App\Models\LevelModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Monolog\Level;

class LevelController extends Controller
{
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

    public function index(LevelDataTable  $dataTable) {
        return  $dataTable->render('level.index');
    }

    public function create() {
        return view('level.create');
    }  


    public function store(Request $request)
    {
        LevelModel::create([
            'level_kode' => $request->level_kode,
            'level_nama' => $request->level_nama,
        ]);

        return redirect('/level');
    }

    public function edit($id)
    {
        $level = LevelModel::find($id);
        return view('level.edit', ['data' => $level]);
    }

    public function edit_simpan($id, Request $request)
    {
        $level = LevelModel::find($id);
        $level->level_kode = $request->level_kode;
        $level->level_nama = $request->level_nama;

        $level->save();
        return redirect('/level');
    }

    public function delete($id)
    {
        $user = LevelModel::find($id);
        $user->delete();

        return redirect('/level');
    }
}

