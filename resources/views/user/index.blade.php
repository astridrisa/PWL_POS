@extends('layout.app')

{{-- Customize layout sections --}}

@section('subtitle', 'User')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'User')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Manage User</div>
            <div class="card-body">
                <button  class="btn btn-success float-right text-decoration-none"><a href="{{ route('/user/create') }}" class="text-white">Add</a></button>
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}