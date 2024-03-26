@extends('layout.app')

{{-- Customize layout sections --}}
@section('subtitle', 'User')
@section('content_header_title', 'User')
@section('content_header_subtitle', 'Edit')

{{-- Content body: main page content --}}
@section('content')
    <div class="container">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit user</h3>
            </div>

            <form  method="post" action="{{ route('/user/edit_simpan', $data->user_id)}}">
                @csrf
                @method('PUT')

                <div class='card'></div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="{{$data->username}}">
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="{{$data->nama}}">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="text" class="form-control" id="password" name="password" value="{{$data->password}}">
                    </div>
                    <div class="form-group">
                        <label for="level_id">ID Level</label>
                        <input type="text" class="form-control" id="level_id" name="level_id" value="{{$data->level_id}}">
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('user.index') }}" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
            </form>
        </div>
    </div>
@endsection