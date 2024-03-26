@extends('layout.app')
{{-- Customize layout sections --}}
@section('subtitle', 'Level')
@section('content_header_title', 'Level')
@section('content_header_subtitle', 'Create')
{{-- Content body: main page content --}}
@section('content')
    <div class="container">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Tambah level baru</h3>
            </div>
            <form method="post" action="../level">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="level_kode">Level Kode</label>
                        <input type="text" class="form-control" id="level_kode" name="level_kode" placeholder="Level Kode">
                    </div>
                    <div class="form-group">
                        <label for="level_nama">Level Nama</label>
                        <input type="text" class="form-control" id="level_nama" name="level_nama" placeholder="Level Nama">
                    </div>
                    <div class="form-group">
                        <label for="level_id">ID Level</label>
                        <input type="number" class="form-control" id="level_id" name="level_id" placeholder="Id Level">
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection