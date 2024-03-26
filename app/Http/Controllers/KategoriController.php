<?php

namespace App\Http\Controllers;
use App\Models\KategoriModel;
use Illuminate\Http\Request;
use App\DataTables\KategoriDataTable;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class KategoriController extends Controller
{
    public function index(KategoriDataTable $dataTable)
    {
        return $dataTable->render('kategori.index');
    }
    

    public function create(): View
    {
        return view('kategori.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'kodeKategori' => 'bail|required|string|max:255',
            'namaKategori' => 'bail|required|string|max:255',
        ]);
        
        KategoriModel::create([
            'kategori_kode' => $request->kodeKategori,
            'kategori_nama' => $request->namaKategori,
    ]);
    return redirect('/kategori');
    }

    public function update($id)
    {
    $kategori = KategoriModel :: find($id);
    return view('kategori.kategori_update', ['data' => $kategori]);
    }

    public function update_simpan($id, Request $request)
    {
    $kategori = KategoriModel :: find($id);

    $kategori->kategori_kode = $request->kodeKategori;
    $kategori->kategori_nama = $request->namaKategori;

    $kategori->save();
    return redirect('/kategori');
    }

    public function delete($id)
    {
        $kategori = KategoriModel::find($id);
        $kategori->delete();

        return redirect('/kategori');
    }
}