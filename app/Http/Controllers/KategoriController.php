<?php

namespace App\Http\Controllers;

use App\DataTables\KategoriDataTable;
use App\Http\Requests\StorePostRequest;
use App\Models\KategoriModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class KategoriController extends Controller
{
    public function index(KategoriDataTable $dataTable)
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Kategori',
            'list'  => ['Home', 'Kategori']
        ];

        $page = (object) [
            'title' => 'Daftar kategori yang terdaftar dalam sistem'
        ];

        $activeMenu = 'kategori';

        $kategori = KategoriModel::all();

        return view('kategori.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $kategori = KategoriModel::query()
            ->select('kategori_id', 'kategori_kode', 'kategori_nama');

        if ($request->kategori_id) {
            $kategori->where('kategori_id', $request->kategori_id);
        }

        return DataTables::of($kategori)
            ->addIndexColumn()
            ->addColumn('aksi', function ($kategori) {
                $btn = '<a href="' . url('/kategori/' . $kategori->kategori_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/kategori/' . $kategori->kategori_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/kategori/' . $kategori->kategori_id) . '">'
                    . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Kategori',
            'list'  => ['Home', 'Kategori', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah kategori baru'
        ];

        $kategori = KategoriModel::all();
        $activeMenu = 'kategori';

        return view('kategori.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_kode'  => 'required|string|max:10|unique:m_kategori,kategori_kode',
            'kategori_nama'  => 'required|string|max:100|unique:m_kategori,kategori_nama'
        ]);

        KategoriModel::create([
            'kategori_kode'  => $request->kategori_kode,
            'kategori_nama'  => $request->kategori_nama
        ]);

        return redirect('/kategori')->with('success', 'Data kategori berhasil disimpan');
    }

    public function show(string $id)
    {
        $kategori = KategoriModel::with('kategori')->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Kategori',
            'list'  => ['Home', 'Kategori', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Kategori'
        ];

        $activeMenu = 'kategori';

        return view('kategori.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    public function edit(string $id)
    {
        $kategori = KategoriModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Kategori',
            'list' => ['Home', 'Kategori', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit kategori'
        ];

        $activeMenu = 'kategori';

        return view('kategori.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'kategori_kode'  => 'required|string|max:10|',
            'kategori_nama'  => 'required|string|max:100|'
        ]);

        KategoriModel::find($id)->update([
            'kategori_kode'  => $request->kategori_kode,
            'kategori_nama'  => $request->kategori_nama
        ]);

        return redirect('/kategori')->with('success', 'Data kategori berhasil diubah');
    }

    public function destroy(string $id)
    {
        $check = KategoriModel::find($id);
        if (!$check) {
            return redirect('/kategori')->with('error', 'Data kategori tidak ditemukan');
        }

        try {
            KategoriModel::destroy($id);

            return redirect('/kategori')->with('success', 'Data kategori berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/kategori')->with('error', 'Data kategori gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
    // public function index(KategoriDataTable $dataTable)
    // {
    //     return $dataTable->render('kategori.index');
    // }

    // public function create(): View
    // {
    //     return view('kategori.create');
    // }

    // public function store(StorePostRequest $request): RedirectResponse
    // {

    //     // The incoming request is valid...

    //     // Retrieve the validated input data...
    //     $request->validate();

    //     // Retrieve a portion of the validated input data...
    //     $request->safe()->only(['kategori_kode', 'kategori_nama']);
    //     $request->safe()->except(['kategori_kode', 'kategori_nama']);

    //     KategoriModel::create([
    //         'kategori_kode' => $request->kodeKategori,
    //         'kategori_nama' => $request->namaKategori
    //     ]);
    //     // Store the post...

    //     return redirect('/kategori');
    // }

    // public function edit($id)
    // {
    //     $kategori = KategoriModel::find($id);
    //     return view('kategori.edit', ['data' => $kategori]);
    // }

    // public function edit_simpan($id, Request $request)
    // {
    //     $kategori = KategoriModel::find($id);

    //     $kategori->kategori_kode = $request->kodeKategori;
    //     $kategori->kategori_nama = $request->namaKategori;

    //     $kategori->save();

    //     return redirect('/kategori');
    // }

    // public function delete($id)
    // {
    //     $kategori = KategoriModel::find($id);
    //     $kategori->delete();

    //     return redirect('/kategori');
    // }