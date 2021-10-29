@extends('layouts.app')

@section('heading')
    <h1>
        Folders
        <a href="{{ route('settings.folders.create') }}" class="btn btn-outline-primary">Create <i class="fas fa-plus fa-fw"></i></a>
    </h1>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('settings.index') }}">Settings</a></li>
    <li class="breadcrumb-item active" aria-current="page">Folders</li>
@endsection

@section('content')
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($folders as $folder)
                <tr>
                    <td>{{ $folder->id }}</td>
                    <td>{{ $folder->name }}</td>
                    <td>{{ $folder->getCreatedAt() }}</td>
                    <td>{{ $folder->getUpdatedAt() }}</td>
                    <td>
                        <a href="{{ route('settings.folders.edit', ['folder' => $folder]) }}" class="btn btn-outline-primary">
                            <i class="fa fa-pen fa-fw"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-italic">There are no folders.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
