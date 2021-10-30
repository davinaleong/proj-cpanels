@extends('layouts.app')

@section('heading')
    <h1>Create Image</h1>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('settings.index') }}">Settings</a></li>
    <li class="breadcrumb-item"><a href="{{ route('settings.images.index') }}">Images</a></li>
    <li class="breadcrumb-item active" aria-current="page">Create Image</li>
@endsection

@section('content')
    <form method="POST" action="{{ route('settings.images.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Name*</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Name" required>
        </div>

        <div class="mb-3">
            <label for="folder_id" class="form-label">Folder*</label>
            <select name="folder_id" class="form-control" id="folder_id" required>
                <option value="">-- Folders --</option>
                @foreach($folders as $folder)
                <option value="{{ $folder->id }}" {{ old('folder_id') == $folder->id ? 'selected="selected"' : '' }}>{{ $folder->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="file" class="form-label">File*</label>
            <input type="file" class="form-control" name="file" id="file" accept=".jpg,.gif,.png,.jpeg,.bmp" required>
        </div>

        @include('components.errors')

        <p>* required fields</p>
        <div>
            <button type="submit" class="btn btn-primary">Submit <i class="fas fa-check fa-fw"></i></button>
            <a href="{{ route('settings.images.index') }}" class="btn btn-outline-secondary">Cancel <i class="fas fa-ban fa-fw"></i></a>
        </div>
    </form>
@endsection
