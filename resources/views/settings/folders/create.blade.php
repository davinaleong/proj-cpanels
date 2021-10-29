@extends('layouts.app')

@section('heading')
    <h1>Create Folder</h1>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('settings.index') }}">Settings</a></li>
    <li class="breadcrumb-item"><a href="{{ route('settings.folders.index') }}">Folders</a></li>
    <li class="breadcrumb-item active" aria-current="page">Create Folder</li>
@endsection

@section('content')
    <form method="POST" action="{{ route('settings.folders.store') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Name*</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Name" required>
        </div>

        @include('components.errors')

        <p>* required fields</p>
        <div>
            <button type="submit" class="btn btn-primary">Submit <i class="fas fa-check fa-fw"></i></button>
            <a href="{{ route('settings.folders.index') }}" class="btn btn-outline-secondary">Cancel <i class="fas fa-ban fa-fw"></i></a>
        </div>
    </form>
@endsection
