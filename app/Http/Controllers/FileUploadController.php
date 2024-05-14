<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function fileUpload() 
    {
        return view('file-upload');
    }

    public function prosesFileUpload(Request $request) 
    {
        $request->validate(['berkas'=>'required|file|image|max:500',]);
        // $path = $request->berkas->store('uploads');
        $extfile = $request->berkas->getClientOriginalName();
        $namaFile = 'web-'.time().".".$extfile;

        $path = $request->berkas->move('gambar',$namaFile);
        $path = str_replace("\\","//", $path);
        echo "Variabel path berisi:$path <br>";

        $pathBaru = asset('gambar/'.$namaFile);
        echo "proses upload berhasil, data disimpan pada:$path";
        echo "<br>";
        echo "Tampilkan link:<a href='$pathBaru'>$pathBaru</a>";
        // echo $request->berkas->getClientOriginalName()."lolos validasi";       
    }
}